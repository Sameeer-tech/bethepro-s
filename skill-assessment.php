<?php
session_start();
include 'config/database.php';
include 'assets/loader.php';

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];
$message = '';
$error = '';

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['save_skills'])) {
        try {
            // Clear existing capabilities for this user
            $stmt = $pdo->prepare("DELETE FROM user_capabilities WHERE user_id = ?");
            $stmt->execute([$user_id]);
            
            // Insert new capabilities
            $stmt = $pdo->prepare("
                INSERT INTO user_capabilities 
                (user_id, skill_category, skill_name, proficiency_level, years_experience, self_rating) 
                VALUES (?, ?, ?, ?, ?, ?)
            ");
            
            $skills_saved = 0;
            foreach ($_POST as $key => $value) {
                if (strpos($key, 'skill_') === 0) {
                    $parts = explode('_', $key);
                    if (count($parts) >= 3) {
                        $skill_category = $parts[1];
                        $skill_name = $parts[2];
                        $proficiency = $_POST["proficiency_{$skill_category}_{$skill_name}"] ?? 'beginner';
                        $experience = floatval($_POST["experience_{$skill_category}_{$skill_name}"] ?? 0);
                        $rating = intval($value);
                        
                        if ($rating > 0) {
                            $stmt->execute([$user_id, $skill_category, $skill_name, $proficiency, $experience, $rating]);
                            $skills_saved++;
                        }
                    }
                }
            }
            
            // Save career goals
            if (!empty($_POST['career_goals'])) {
                // Clear existing goals
                $stmt = $pdo->prepare("DELETE FROM user_career_goals WHERE user_id = ?");
                $stmt->execute([$user_id]);
                
                // Insert new goals
                $stmt = $pdo->prepare("
                    INSERT INTO user_career_goals 
                    (user_id, target_role, target_industry, timeline_months, priority_level) 
                    VALUES (?, ?, ?, ?, ?)
                ");
                
                foreach ($_POST['career_goals'] as $goal) {
                    if (!empty($goal['role']) && !empty($goal['industry'])) {
                        $stmt->execute([
                            $user_id,
                            $goal['role'],
                            $goal['industry'],
                            intval($goal['timeline'] ?? 12),
                            $goal['priority'] ?? 'medium'
                        ]);
                    }
                }
            }
            
            // Update/Insert learning analytics
            $learning_style = $_POST['learning_style'] ?? 'mixed';
            $preferred_difficulty = $_POST['preferred_difficulty'] ?? 'mixed';
            $avg_session = intval($_POST['avg_session_duration'] ?? 45);
            
            $stmt = $pdo->prepare("
                INSERT INTO user_learning_analytics 
                (user_id, learning_style, preferred_difficulty, average_session_duration_minutes, last_activity_date) 
                VALUES (?, ?, ?, ?, CURDATE())
                ON DUPLICATE KEY UPDATE
                learning_style = VALUES(learning_style),
                preferred_difficulty = VALUES(preferred_difficulty),
                average_session_duration_minutes = VALUES(average_session_duration_minutes),
                last_activity_date = VALUES(last_activity_date)
            ");
            $stmt->execute([$user_id, $learning_style, $preferred_difficulty, $avg_session]);
            
            $message = "Skills assessment completed successfully! {$skills_saved} skills saved.";
            
            // Trigger recommendation generation
            include 'includes/RecommendationEngine.php';
            $recommendationEngine = new RecommendationEngine($pdo);
            $recommendationEngine->generateCourseRecommendations($user_id);
            $recommendationEngine->generateQuizRecommendations($user_id);
            $recommendationEngine->generateCareerPathRecommendations($user_id);
            
        } catch (PDOException $e) {
            $error = "Error saving assessment: " . $e->getMessage();
        }
    }
}

// Get existing user capabilities
$existing_skills = [];
try {
    $stmt = $pdo->prepare("SELECT * FROM user_capabilities WHERE user_id = ?");
    $stmt->execute([$user_id]);
    while ($skill = $stmt->fetch()) {
        $existing_skills[$skill['skill_category']][$skill['skill_name']] = $skill;
    }
} catch (PDOException $e) {
    // Continue without existing skills
}

// Get existing career goals
$existing_goals = [];
try {
    $stmt = $pdo->prepare("SELECT * FROM user_career_goals WHERE user_id = ? AND is_active = TRUE");
    $stmt->execute([$user_id]);
    $existing_goals = $stmt->fetchAll();
} catch (PDOException $e) {
    // Continue without existing goals
}

// Get existing learning preferences
$existing_analytics = [];
try {
    $stmt = $pdo->prepare("SELECT * FROM user_learning_analytics WHERE user_id = ?");
    $stmt->execute([$user_id]);
    $existing_analytics = $stmt->fetch() ?: [];
} catch (PDOException $e) {
    // Continue without existing analytics
}

include 'assets/header.php';
?>

<link rel="stylesheet" href="css/skill-assessment.css">

<div class="assessment-container">
    <div class="container">
        <div class="assessment-header">
            <h1><i class="fas fa-chart-line"></i> Skills & Career Assessment</h1>
            <p>Complete your profile in simple steps to get personalized course recommendations</p>
            
            <!-- Progress Indicator -->
            <div class="progress-container">
                <div class="progress-bar">
                    <div class="progress-fill" id="progressFill"></div>
                </div>
                <div class="step-indicators">
                    <div class="step-indicator active" data-step="1">
                        <div class="step-number">1</div>
                        <div class="step-title">Technical Skills</div>
                    </div>
                    <div class="step-indicator" data-step="2">
                        <div class="step-number">2</div>
                        <div class="step-title">Professional Skills</div>
                    </div>
                    <div class="step-indicator" data-step="3">
                        <div class="step-number">3</div>
                        <div class="step-title">Career Goals</div>
                    </div>
                    <div class="step-indicator" data-step="4">
                        <div class="step-number">4</div>
                        <div class="step-title">Learning Style</div>
                    </div>
                </div>
            </div>
        </div>
        
        <?php if ($message): ?>
            <div class="alert alert-success">
                <i class="fas fa-check-circle"></i>
                <?php echo htmlspecialchars($message); ?>
                <a href="recommendations.php" class="alert-link">View Your Recommendations →</a>
            </div>
        <?php endif; ?>
        
        <?php if ($error): ?>
            <div class="alert alert-error">
                <i class="fas fa-exclamation-circle"></i>
                <?php echo htmlspecialchars($error); ?>
            </div>
        <?php endif; ?>
        
        <form method="POST" class="assessment-form wizard-form">
            <!-- Technical Skills Section -->
            <div class="assessment-section wizard-step active" id="step-1">
                <div class="step-header">
                    <h2><i class="fas fa-code"></i> Technical Skills</h2>
                    <p class="section-description">
                        Rate your experience with different technologies. Don't worry if you're new to some areas - 
                        this helps us find the perfect starting point for you!
                        <span class="help-tooltip" data-tooltip="Rate yourself honestly - this ensures you get courses at the right level">
                            <i class="fas fa-question-circle"></i>
                        </span>
                    </p>
                </div>
                
                <div class="skills-grid">
                    <?php 
                     $technical_skills = [
                        'Programming' => ['Python', 'JavaScript', 'Java', 'PHP', 'C++'],
                        'Web Development' => ['HTML/CSS', 'React', 'Node.js', 'WordPress', 'Database'],
                        'Data Analysis' => ['SQL', 'Excel', 'Python for Data', 'Visualization', 'Statistics'],
                        'DevOps' => ['Git', 'Docker', 'Cloud Computing', 'Linux', 'CI/CD']
                    ];
                    
                    foreach ($technical_skills as $category => $skills): 
                    ?>
                        <div class="skill-category">
                            <h3><?php echo $category; ?></h3>
                            <div class="category-description">
                                <?php
                                $descriptions = [
                                    'Programming' => 'Languages you can write code in',
                                    'Web Development' => 'Building websites and web applications',
                                    'Data Analysis' => 'Working with data and creating insights',
                                    'DevOps' => 'Deployment and infrastructure tools'
                                ];
                                echo $descriptions[$category] ?? '';
                                ?>
                            </div>
                            <?php foreach ($skills as $skill): 
                                $existing = $existing_skills[$category][$skill] ?? [];
                            ?>
                                <div class="skill-item">
                                    <div class="skill-header">
                                        <label><?php echo $skill; ?></label>
                                        <span class="skill-level-indicator" data-skill="<?php echo $category; ?>_<?php echo $skill; ?>">
                                            Beginner
                                        </span>
                                    </div>
                                    <div class="skill-inputs">
                                        <div class="rating-section">
                                            <div class="rating-input">
                                                <span class="rating-label">Experience Level:</span>
                                                <input type="range" 
                                                       name="skill_<?php echo $category; ?>_<?php echo $skill; ?>" 
                                                       min="0" max="10" 
                                                       value="<?php echo $existing['self_rating'] ?? 0; ?>"
                                                       oninput="updateRatingDisplay(this)"
                                                       class="skill-slider">
                                                <span class="rating-display"><?php echo $existing['self_rating'] ?? 0; ?></span>
                                            </div>
                                            <div class="rating-labels">
                                                <span>Never used</span>
                                                <span>Expert</span>
                                            </div>
                                        </div>
                                        <div class="additional-info">
                                            <select name="proficiency_<?php echo $category; ?>_<?php echo $skill; ?>" class="proficiency-select">
                                                <option value="beginner" <?php echo ($existing['proficiency_level'] ?? '') === 'beginner' ? 'selected' : ''; ?>>Learning</option>
                                                <option value="intermediate" <?php echo ($existing['proficiency_level'] ?? '') === 'intermediate' ? 'selected' : ''; ?>>Comfortable</option>
                                                <option value="advanced" <?php echo ($existing['proficiency_level'] ?? '') === 'advanced' ? 'selected' : ''; ?>>Proficient</option>
                                                <option value="expert" <?php echo ($existing['proficiency_level'] ?? '') === 'expert' ? 'selected' : ''; ?>>Expert</option>
                                            </select>
                                            <input type="number" 
                                                   name="experience_<?php echo $category; ?>_<?php echo $skill; ?>" 
                                                   placeholder="Years" 
                                                   min="0" max="20" step="0.5" 
                                                   value="<?php echo $existing['years_experience'] ?? ''; ?>"
                                                   class="experience-input">
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    <?php endforeach; ?>
                </div>
                
                <div class="step-navigation">
                    <button type="button" class="btn btn-secondary" disabled>Previous</button>
                    <div class="step-info">Step 1 of 4</div>
                    <button type="button" class="btn btn-primary" onclick="nextStep()">Next Step</button>
                </div>
            </div>
            
            <!-- Soft Skills Section -->
            <div class="assessment-section wizard-step" id="step-2">
                <div class="step-header">
                    <h2><i class="fas fa-users"></i> Professional Skills</h2>
                    <p class="section-description">
                        These skills are just as important as technical ones! Rate your confidence in these areas.
                        <span class="help-tooltip" data-tooltip="Professional skills help determine leadership and collaboration opportunities">
                            <i class="fas fa-question-circle"></i>
                        </span>
                    </p>
                </div>
                <div class="skills-grid">
                    <?php 
                    $soft_skills = [
                        'Communication' => ['Public Speaking', 'Written Communication', 'Presentation', 'Negotiation'],
                        'Leadership' => ['Team Management', 'Project Leadership', 'Decision Making', 'Mentoring'],
                        'Analytical' => ['Problem Solving', 'Critical Thinking', 'Data Analysis', 'Research'],
                        'Creative' => ['Design Thinking', 'Innovation', 'Creative Writing', 'Visual Design']
                    ];
                    
                    foreach ($soft_skills as $category => $skills): 
                    ?>
                        <div class="skill-category">
                            <h3><?php echo $category; ?></h3>
                            <div class="category-description">
                                <?php
                                $descriptions = [
                                    'Communication' => 'Sharing ideas and information effectively',
                                    'Leadership' => 'Guiding teams and making decisions',
                                    'Analytical' => 'Solving problems and thinking critically',
                                    'Creative' => 'Innovative thinking and design skills'
                                ];
                                echo $descriptions[$category] ?? '';
                                ?>
                            </div>
                            <?php foreach ($skills as $skill): 
                                $existing = $existing_skills[$category][$skill] ?? [];
                            ?>
                                <div class="skill-item">
                                    <div class="skill-header">
                                        <label><?php echo $skill; ?></label>
                                        <span class="skill-level-indicator" data-skill="<?php echo $category; ?>_<?php echo $skill; ?>">
                                            Beginner
                                        </span>
                                    </div>
                                    <div class="skill-inputs">
                                        <div class="rating-section">
                                            <div class="rating-input">
                                                <span class="rating-label">Confidence Level:</span>
                                                <input type="range" 
                                                       name="skill_<?php echo $category; ?>_<?php echo $skill; ?>" 
                                                       min="0" max="10" 
                                                       value="<?php echo $existing['self_rating'] ?? 0; ?>"
                                                       oninput="updateRatingDisplay(this)"
                                                       class="skill-slider">
                                                <span class="rating-display"><?php echo $existing['self_rating'] ?? 0; ?></span>
                                            </div>
                                            <div class="rating-labels">
                                                <span>Not confident</span>
                                                <span>Very confident</span>
                                            </div>
                                        </div>
                                        <div class="additional-info">
                                            <select name="proficiency_<?php echo $category; ?>_<?php echo $skill; ?>" class="proficiency-select">
                                                <option value="beginner" <?php echo ($existing['proficiency_level'] ?? '') === 'beginner' ? 'selected' : ''; ?>>Learning</option>
                                                <option value="intermediate" <?php echo ($existing['proficiency_level'] ?? '') === 'intermediate' ? 'selected' : ''; ?>>Comfortable</option>
                                                <option value="advanced" <?php echo ($existing['proficiency_level'] ?? '') === 'advanced' ? 'selected' : ''; ?>>Proficient</option>
                                                <option value="expert" <?php echo ($existing['proficiency_level'] ?? '') === 'expert' ? 'selected' : ''; ?>>Expert</option>
                                            </select>
                                            <input type="number" 
                                                   name="experience_<?php echo $category; ?>_<?php echo $skill; ?>" 
                                                   placeholder="Years" 
                                                   min="0" max="20" step="0.5" 
                                                   value="<?php echo $existing['years_experience'] ?? ''; ?>"
                                                   class="experience-input">
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    <?php endforeach; ?>
                </div>
                
                <div class="step-navigation">
                    <button type="button" class="btn btn-secondary" onclick="prevStep()">Previous</button>
                    <div class="step-info">Step 2 of 4</div>
                    <button type="button" class="btn btn-primary" onclick="nextStep()">Next Step</button>
                </div>
            </div>
            
            <!-- Career Goals Section -->
            <div class="assessment-section wizard-step" id="step-3">
                <div class="step-header">
                    <h2><i class="fas fa-target"></i> Career Goals</h2>
                    <p class="section-description">
                        Tell us about your career aspirations. This helps us recommend the most relevant courses and learning paths.
                        <span class="help-tooltip" data-tooltip="Your goals help us prioritize recommendations and suggest career-focused content">
                            <i class="fas fa-question-circle"></i>
                        </span>
                    </p>
                </div>
                <div class="career-goals-section">
                    <div class="goals-intro">
                        <h3>What are your career aspirations?</h3>
                        <p>Add one or more career goals. Don't worry - you can always update these later!</p>
                    </div>
                    <div id="career-goals-container">
                        <?php if (empty($existing_goals)): ?>
                            <div class="career-goal-item">
                                <div class="goal-header">
                                    <h4><i class="fas fa-bullseye"></i> Career Goal #1</h4>
                                </div>
                                <div class="goal-inputs">
                                    <div class="input-group">
                                        <label>What role do you want?</label>
                                        <input type="text" name="career_goals[0][role]" placeholder="e.g., Senior Software Developer, Data Scientist, Product Manager" required>
                                    </div>
                                    <div class="input-group">
                                        <label>In which industry?</label>
                                        <select name="career_goals[0][industry]" required>
                                            <option value="">Choose industry...</option>
                                            <option value="Technology">Technology</option>
                                            <option value="Finance">Finance</option>
                                            <option value="Healthcare">Healthcare</option>
                                            <option value="Education">Education</option>
                                            <option value="Marketing">Marketing</option>
                                            <option value="Consulting">Consulting</option>
                                            <option value="Manufacturing">Manufacturing</option>
                                            <option value="Other">Other</option>
                                        </select>
                                    </div>
                                    <div class="input-row">
                                        <div class="input-group">
                                            <label>Timeline</label>
                                            <select name="career_goals[0][timeline]">
                                                <option value="6">6 months</option>
                                                <option value="12" selected>1 year</option>
                                                <option value="18">18 months</option>
                                                <option value="24">2 years</option>
                                                <option value="36">3+ years</option>
                                            </select>
                                        </div>
                                        <div class="input-group">
                                            <label>Priority</label>
                                            <select name="career_goals[0][priority]">
                                                <option value="high">High Priority</option>
                                                <option value="medium" selected>Medium Priority</option>
                                                <option value="low">Low Priority</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php else: ?>
                            <?php foreach ($existing_goals as $index => $goal): ?>
                                <div class="career-goal-item">
                                    <div class="goal-header">
                                        <h4><i class="fas fa-bullseye"></i> Career Goal #<?php echo $index + 1; ?></h4>
                                        <?php if ($index > 0): ?>
                                            <button type="button" onclick="removeCareerGoal(this)" class="remove-goal-btn">
                                                <i class="fas fa-times"></i> Remove
                                            </button>
                                        <?php endif; ?>
                                    </div>
                                    <div class="goal-inputs">
                                        <div class="input-group">
                                            <label>What role do you want?</label>
                                            <input type="text" name="career_goals[<?php echo $index; ?>][role]" 
                                                   placeholder="e.g., Senior Software Developer, Data Scientist" 
                                                   value="<?php echo htmlspecialchars($goal['target_role']); ?>" required>
                                        </div>
                                        <div class="input-group">
                                            <label>In which industry?</label>
                                            <select name="career_goals[<?php echo $index; ?>][industry]" required>
                                                <option value="">Choose industry...</option>
                                                <option value="Technology" <?php echo $goal['target_industry'] === 'Technology' ? 'selected' : ''; ?>>Technology</option>
                                                <option value="Finance" <?php echo $goal['target_industry'] === 'Finance' ? 'selected' : ''; ?>>Finance</option>
                                                <option value="Healthcare" <?php echo $goal['target_industry'] === 'Healthcare' ? 'selected' : ''; ?>>Healthcare</option>
                                                <option value="Education" <?php echo $goal['target_industry'] === 'Education' ? 'selected' : ''; ?>>Education</option>
                                                <option value="Marketing" <?php echo $goal['target_industry'] === 'Marketing' ? 'selected' : ''; ?>>Marketing</option>
                                                <option value="Consulting" <?php echo $goal['target_industry'] === 'Consulting' ? 'selected' : ''; ?>>Consulting</option>
                                                <option value="Manufacturing" <?php echo $goal['target_industry'] === 'Manufacturing' ? 'selected' : ''; ?>>Manufacturing</option>
                                                <option value="Other" <?php echo $goal['target_industry'] === 'Other' ? 'selected' : ''; ?>>Other</option>
                                            </select>
                                        </div>
                                        <div class="input-row">
                                            <div class="input-group">
                                                <label>Timeline</label>
                                                <select name="career_goals[<?php echo $index; ?>][timeline]">
                                                    <option value="6" <?php echo $goal['timeline_months'] == 6 ? 'selected' : ''; ?>>6 months</option>
                                                    <option value="12" <?php echo $goal['timeline_months'] == 12 ? 'selected' : ''; ?>>1 year</option>
                                                    <option value="18" <?php echo $goal['timeline_months'] == 18 ? 'selected' : ''; ?>>18 months</option>
                                                    <option value="24" <?php echo $goal['timeline_months'] == 24 ? 'selected' : ''; ?>>2 years</option>
                                                    <option value="36" <?php echo $goal['timeline_months'] == 36 ? 'selected' : ''; ?>>3+ years</option>
                                                </select>
                                            </div>
                                            <div class="input-group">
                                                <label>Priority</label>
                                                <select name="career_goals[<?php echo $index; ?>][priority]">
                                                    <option value="high" <?php echo $goal['priority_level'] === 'high' ? 'selected' : ''; ?>>High Priority</option>
                                                    <option value="medium" <?php echo $goal['priority_level'] === 'medium' ? 'selected' : ''; ?>>Medium Priority</option>
                                                    <option value="low" <?php echo $goal['priority_level'] === 'low' ? 'selected' : ''; ?>>Low Priority</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </div>
                    <button type="button" onclick="addCareerGoal()" class="add-goal-btn">
                        <i class="fas fa-plus"></i> Add Another Career Goal
                    </button>
                </div>
                
                <div class="step-navigation">
                    <button type="button" class="btn btn-secondary" onclick="prevStep()">Previous</button>
                    <div class="step-info">Step 3 of 4</div>
                    <button type="button" class="btn btn-primary" onclick="nextStep()">Next Step</button>
                </div>
            </div>
            
            <!-- Learning Preferences Section -->
            <div class="assessment-section wizard-step" id="step-4">
                <div class="step-header">
                    <h2><i class="fas fa-brain"></i> Learning Preferences</h2>
                    <p class="section-description">
                        Help us understand how you learn best so we can recommend the most suitable courses and learning formats.
                        <span class="help-tooltip" data-tooltip="Learning preferences help us recommend courses with the right teaching style and difficulty level">
                            <i class="fas fa-question-circle"></i>
                        </span>
                    </p>
                </div>
                <div class="learning-preferences">
                    <div class="preferences-intro">
                        <h3>How do you prefer to learn?</h3>
                        <p>There are no wrong answers - we want to match your natural learning style!</p>
                    </div>
                    
                    <div class="preference-cards">
                        <div class="preference-group">
                            <div class="preference-icon">
                                <i class="fas fa-eye"></i>
                            </div>
                            <label>How do you learn best?</label>
                            <select name="learning_style">
                                <option value="visual" <?php echo ($existing_analytics['learning_style'] ?? '') === 'visual' ? 'selected' : ''; ?>>Visual Learning (diagrams, images, videos)</option>
                                <option value="auditory" <?php echo ($existing_analytics['learning_style'] ?? '') === 'auditory' ? 'selected' : ''; ?>>Auditory Learning (lectures, discussions)</option>
                                <option value="kinesthetic" <?php echo ($existing_analytics['learning_style'] ?? '') === 'kinesthetic' ? 'selected' : ''; ?>>Hands-on Learning (practice, exercises)</option>
                                <option value="mixed" <?php echo ($existing_analytics['learning_style'] ?? 'mixed') === 'mixed' ? 'selected' : ''; ?>>Mixed Approach (combination of all)</option>
                            </select>
                            <div class="preference-hint">Choose what feels most natural to you</div>
                        </div>
                        
                        <div class="preference-group">
                            <div class="preference-icon">
                                <i class="fas fa-chart-line"></i>
                            </div>
                            <label>What difficulty level do you prefer?</label>
                            <select name="preferred_difficulty">
                                <option value="gradual" <?php echo ($existing_analytics['preferred_difficulty'] ?? '') === 'gradual' ? 'selected' : ''; ?>>Gradual Progression (start easy, build up)</option>
                                <option value="challenging" <?php echo ($existing_analytics['preferred_difficulty'] ?? '') === 'challenging' ? 'selected' : ''; ?>>Jump into Challenges (learn by doing hard things)</option>
                                <option value="mixed" <?php echo ($existing_analytics['preferred_difficulty'] ?? 'mixed') === 'mixed' ? 'selected' : ''; ?>>Mixed Difficulty (variety keeps it interesting)</option>
                            </select>
                            <div class="preference-hint">Don't worry - you can always adjust this later</div>
                        </div>
                        
                        <div class="preference-group">
                            <div class="preference-icon">
                                <i class="fas fa-clock"></i>
                            </div>
                            <label>How long can you typically focus on learning?</label>
                            <select name="avg_session_duration">
                                <option value="15" <?php echo ($existing_analytics['average_session_duration_minutes'] ?? 45) == 15 ? 'selected' : ''; ?>>15 minutes (quick sessions)</option>
                                <option value="30" <?php echo ($existing_analytics['average_session_duration_minutes'] ?? 45) == 30 ? 'selected' : ''; ?>>30 minutes (short focused sessions)</option>
                                <option value="45" <?php echo ($existing_analytics['average_session_duration_minutes'] ?? 45) == 45 ? 'selected' : ''; ?>>45 minutes (standard sessions)</option>
                                <option value="60" <?php echo ($existing_analytics['average_session_duration_minutes'] ?? 45) == 60 ? 'selected' : ''; ?>>1 hour (deep focus sessions)</option>
                                <option value="90" <?php echo ($existing_analytics['average_session_duration_minutes'] ?? 45) == 90 ? 'selected' : ''; ?>>1.5 hours (extended learning)</option>
                                <option value="120" <?php echo ($existing_analytics['average_session_duration_minutes'] ?? 45) == 120 ? 'selected' : ''; ?>>2+ hours (marathon sessions)</option>
                            </select>
                            <div class="preference-hint">We'll recommend courses that fit your attention span</div>
                        </div>
                    </div>
                </div>
                
                <div class="step-navigation final-step">
                    <button type="button" class="btn btn-secondary" onclick="prevStep()">Previous</button>
                    <div class="step-info">Step 4 of 4</div>
                    <button type="submit" name="save_skills" class="btn btn-success btn-large">
                        <i class="fas fa-rocket"></i> Complete Assessment & Get My Recommendations!
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>

<?php include 'assets/footer.php'; ?>

<script>
let goalCounter = <?php echo count($existing_goals) ?: 1; ?>;
let currentStep = 1;
const totalSteps = 4;

// Wizard Navigation Functions
function nextStep() {
    if (currentStep < totalSteps) {
        // Hide current step
        document.getElementById(`step-${currentStep}`).classList.remove('active');
        
        // Show next step
        currentStep++;
        document.getElementById(`step-${currentStep}`).classList.add('active');
        
        // Update progress
        updateProgress();
        updateStepIndicators();
        
        // Scroll to top
        document.querySelector('.assessment-container').scrollIntoView({ behavior: 'smooth' });
    }
}

function prevStep() {
    if (currentStep > 1) {
        // Hide current step
        document.getElementById(`step-${currentStep}`).classList.remove('active');
        
        // Show previous step
        currentStep--;
        document.getElementById(`step-${currentStep}`).classList.add('active');
        
        // Update progress
        updateProgress();
        updateStepIndicators();
        
        // Scroll to top
        document.querySelector('.assessment-container').scrollIntoView({ behavior: 'smooth' });
    }
}

function updateProgress() {
    const progressFill = document.getElementById('progressFill');
    const progress = (currentStep / totalSteps) * 100;
    progressFill.style.width = progress + '%';
}

function updateStepIndicators() {
    const indicators = document.querySelectorAll('.step-indicator');
    indicators.forEach((indicator, index) => {
        if (index + 1 < currentStep) {
            indicator.classList.add('completed');
            indicator.classList.remove('active');
        } else if (index + 1 === currentStep) {
            indicator.classList.add('active');
            indicator.classList.remove('completed');
        } else {
            indicator.classList.remove('active', 'completed');
        }
    });
}

function updateRatingDisplay(slider) {
    const display = slider.nextElementSibling;
    display.textContent = slider.value;
    
    // Update skill level indicator
    const skillItem = slider.closest('.skill-item');
    const skillIndicator = skillItem.querySelector('.skill-level-indicator');
    const value = parseInt(slider.value);
    
    let level = 'Never used';
    let color = '#e53e3e';
    
    if (value >= 9) {
        level = 'Expert';
        color = '#38a169';
    } else if (value >= 7) {
        level = 'Advanced';
        color = '#48bb78';
    } else if (value >= 5) {
        level = 'Intermediate';
        color = '#ed8936';
    } else if (value >= 3) {
        level = 'Beginner';
        color = '#718096';
    } else if (value >= 1) {
        level = 'Learning';
        color = '#4a5568';
    }
    
    skillIndicator.textContent = level;
    skillIndicator.style.backgroundColor = color;
    
    // Add visual feedback to rating display
    display.style.backgroundColor = color;
    display.style.color = 'white';
    
    // Add celebration effect for high ratings
    if (value >= 8) {
        slider.classList.add('high-rating');
        setTimeout(() => slider.classList.remove('high-rating'), 1000);
    }
}

function addCareerGoal() {
    const container = document.getElementById('career-goals-container');
    const newGoal = document.createElement('div');
    newGoal.className = 'career-goal-item';
    newGoal.innerHTML = `
        <div class="goal-header">
            <h4><i class="fas fa-bullseye"></i> Career Goal #${goalCounter + 1}</h4>
            <button type="button" onclick="removeCareerGoal(this)" class="remove-goal-btn">
                <i class="fas fa-times"></i> Remove
            </button>
        </div>
        <div class="goal-inputs">
            <div class="input-group">
                <label>What role do you want?</label>
                <input type="text" name="career_goals[${goalCounter}][role]" placeholder="e.g., Senior Software Developer, Data Scientist" required>
            </div>
            <div class="input-group">
                <label>In which industry?</label>
                <select name="career_goals[${goalCounter}][industry]" required>
                    <option value="">Choose industry...</option>
                    <option value="Technology">Technology</option>
                    <option value="Finance">Finance</option>
                    <option value="Healthcare">Healthcare</option>
                    <option value="Education">Education</option>
                    <option value="Marketing">Marketing</option>
                    <option value="Consulting">Consulting</option>
                    <option value="Manufacturing">Manufacturing</option>
                    <option value="Other">Other</option>
                </select>
            </div>
            <div class="input-row">
                <div class="input-group">
                    <label>Timeline</label>
                    <select name="career_goals[${goalCounter}][timeline]">
                        <option value="6">6 months</option>
                        <option value="12" selected>1 year</option>
                        <option value="18">18 months</option>
                        <option value="24">2 years</option>
                        <option value="36">3+ years</option>
                    </select>
                </div>
                <div class="input-group">
                    <label>Priority</label>
                    <select name="career_goals[${goalCounter}][priority]">
                        <option value="high">High Priority</option>
                        <option value="medium" selected>Medium Priority</option>
                        <option value="low">Low Priority</option>
                    </select>
                </div>
            </div>
        </div>
    `;
    container.appendChild(newGoal);
    
    // Add entrance animation
    newGoal.style.opacity = '0';
    newGoal.style.transform = 'translateY(20px)';
    setTimeout(() => {
        newGoal.style.transition = 'all 0.3s ease';
        newGoal.style.opacity = '1';
        newGoal.style.transform = 'translateY(0)';
    }, 10);
    
    goalCounter++;
}

function removeCareerGoal(button) {
    const goalItem = button.closest('.career-goal-item');
    goalItem.style.transition = 'all 0.3s ease';
    goalItem.style.opacity = '0';
    goalItem.style.transform = 'translateY(-20px)';
    setTimeout(() => goalItem.remove(), 300);
}

// Tooltip functionality
function showTooltip(element) {
    const tooltip = element.getAttribute('data-tooltip');
    const tooltipElement = document.createElement('div');
    tooltipElement.className = 'tooltip-popup';
    tooltipElement.textContent = tooltip;
    element.appendChild(tooltipElement);
}

function hideTooltip(element) {
    const tooltip = element.querySelector('.tooltip-popup');
    if (tooltip) {
        tooltip.remove();
    }
}

// Form validation and progress saving
function validateCurrentStep() {
    const currentStepElement = document.getElementById(`step-${currentStep}`);
    const requiredFields = currentStepElement.querySelectorAll('[required]');
    
    for (let field of requiredFields) {
        if (!field.value.trim()) {
            field.classList.add('error');
            field.focus();
            return false;
        }
        field.classList.remove('error');
    }
    return true;
}

// Initialize everything when page loads
document.addEventListener('DOMContentLoaded', function() {
    // Initialize rating displays
    const sliders = document.querySelectorAll('input[type="range"]');
    sliders.forEach(updateRatingDisplay);
    
    // Initialize progress
    updateProgress();
    updateStepIndicators();
    
    // Add tooltip event listeners
    const tooltips = document.querySelectorAll('.help-tooltip');
    tooltips.forEach(tooltip => {
        tooltip.addEventListener('mouseenter', () => showTooltip(tooltip));
        tooltip.addEventListener('mouseleave', () => hideTooltip(tooltip));
    });
    
    // Add keyboard navigation
    document.addEventListener('keydown', function(e) {
        if (e.ctrlKey) {
            if (e.key === 'ArrowRight' && currentStep < totalSteps) {
                nextStep();
                e.preventDefault();
            } else if (e.key === 'ArrowLeft' && currentStep > 1) {
                prevStep();
                e.preventDefault();
            }
        }
    });
    
    // Add form submission confirmation
    const form = document.querySelector('.assessment-form');
    form.addEventListener('submit', function(e) {
        const submitBtn = form.querySelector('button[type="submit"]');
        submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Processing...';
        submitBtn.disabled = true;
    });
    
    // Auto-save functionality (optional - saves to localStorage)
    const inputs = document.querySelectorAll('input, select');
    inputs.forEach(input => {
        input.addEventListener('change', function() {
            const formData = new FormData(form);
            const data = Object.fromEntries(formData);
            localStorage.setItem('skillAssessmentDraft', JSON.stringify(data));
        });
    });
});

// Add some encouraging messages
const encouragementMessages = [
    "Great progress! You're doing amazing! 🎉",
    "Looking good! Keep it up! 💪",
    "Awesome! You're almost there! 🌟",
    "Fantastic! Ready for your recommendations! <i class='fas fa-rocket'></i>"
];

function showEncouragement() {
    const message = encouragementMessages[currentStep - 1];
    const toast = document.createElement('div');
    toast.className = 'encouragement-toast';
    toast.innerHTML = `<i class="fas fa-thumbs-up"></i> ${message}`;
    document.body.appendChild(toast);
    
    setTimeout(() => toast.classList.add('show'), 100);
    setTimeout(() => {
        toast.classList.remove('show');
        setTimeout(() => toast.remove(), 300);
    }, 3000);
}

// Override original next step to add encouragement
const originalNextStep = nextStep;
nextStep = function() {
    originalNextStep();
    if (currentStep > 1) {
        showEncouragement();
    }
};
</script>