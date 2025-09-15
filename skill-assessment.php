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
            <p>Help us understand your capabilities and career goals to provide personalized recommendations</p>
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
        
        <form method="POST" class="assessment-form">
            <!-- Technical Skills Section -->
            <div class="assessment-section">
                <h2><i class="fas fa-code"></i> Technical Skills</h2>
                <p class="section-description">Rate your proficiency in various technical areas (1-10 scale)</p>
                
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
                            <?php foreach ($skills as $skill): 
                                $existing = $existing_skills[$category][$skill] ?? [];
                            ?>
                                <div class="skill-item">
                                    <label><?php echo $skill; ?></label>
                                    <div class="skill-inputs">
                                        <div class="rating-input">
                                            <span>Rating:</span>
                                            <input type="range" 
                                                   name="skill_<?php echo $category; ?>_<?php echo $skill; ?>" 
                                                   min="0" max="10" 
                                                   value="<?php echo $existing['self_rating'] ?? 0; ?>"
                                                   oninput="updateRatingDisplay(this)">
                                            <span class="rating-display"><?php echo $existing['self_rating'] ?? 0; ?></span>
                                        </div>
                                        <select name="proficiency_<?php echo $category; ?>_<?php echo $skill; ?>" class="proficiency-select">
                                            <option value="beginner" <?php echo ($existing['proficiency_level'] ?? '') === 'beginner' ? 'selected' : ''; ?>>Beginner</option>
                                            <option value="intermediate" <?php echo ($existing['proficiency_level'] ?? '') === 'intermediate' ? 'selected' : ''; ?>>Intermediate</option>
                                            <option value="advanced" <?php echo ($existing['proficiency_level'] ?? '') === 'advanced' ? 'selected' : ''; ?>>Advanced</option>
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
                            <?php endforeach; ?>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
            
            <!-- Soft Skills Section -->
            <div class="assessment-section">
                <h2><i class="fas fa-users"></i> Professional Skills</h2>
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
                            <?php foreach ($skills as $skill): 
                                $existing = $existing_skills[$category][$skill] ?? [];
                            ?>
                                <div class="skill-item">
                                    <label><?php echo $skill; ?></label>
                                    <div class="skill-inputs">
                                        <div class="rating-input">
                                            <span>Rating:</span>
                                            <input type="range" 
                                                   name="skill_<?php echo $category; ?>_<?php echo $skill; ?>" 
                                                   min="0" max="10" 
                                                   value="<?php echo $existing['self_rating'] ?? 0; ?>"
                                                   oninput="updateRatingDisplay(this)">
                                            <span class="rating-display"><?php echo $existing['self_rating'] ?? 0; ?></span>
                                        </div>
                                        <select name="proficiency_<?php echo $category; ?>_<?php echo $skill; ?>" class="proficiency-select">
                                            <option value="beginner" <?php echo ($existing['proficiency_level'] ?? '') === 'beginner' ? 'selected' : ''; ?>>Beginner</option>
                                            <option value="intermediate" <?php echo ($existing['proficiency_level'] ?? '') === 'intermediate' ? 'selected' : ''; ?>>Intermediate</option>
                                            <option value="advanced" <?php echo ($existing['proficiency_level'] ?? '') === 'advanced' ? 'selected' : ''; ?>>Advanced</option>
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
                            <?php endforeach; ?>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
            
            <!-- Career Goals Section -->
            <div class="assessment-section">
                <h2><i class="fas fa-target"></i> Career Goals</h2>
                <div class="career-goals-section">
                    <div id="career-goals-container">
                        <?php if (empty($existing_goals)): ?>
                            <div class="career-goal-item">
                                <div class="goal-inputs">
                                    <input type="text" name="career_goals[0][role]" placeholder="Target Role (e.g., Senior Developer)" required>
                                    <select name="career_goals[0][industry]" required>
                                        <option value="">Select Industry</option>
                                        <option value="Technology">Technology</option>
                                        <option value="Finance">Finance</option>
                                        <option value="Healthcare">Healthcare</option>
                                        <option value="Education">Education</option>
                                        <option value="Marketing">Marketing</option>
                                        <option value="Consulting">Consulting</option>
                                        <option value="Manufacturing">Manufacturing</option>
                                        <option value="Other">Other</option>
                                    </select>
                                    <select name="career_goals[0][timeline]">
                                        <option value="6">6 months</option>
                                        <option value="12" selected>1 year</option>
                                        <option value="18">18 months</option>
                                        <option value="24">2 years</option>
                                        <option value="36">3 years</option>
                                    </select>
                                    <select name="career_goals[0][priority]">
                                        <option value="high">High Priority</option>
                                        <option value="medium" selected>Medium Priority</option>
                                        <option value="low">Low Priority</option>
                                    </select>
                                </div>
                            </div>
                        <?php else: ?>
                            <?php foreach ($existing_goals as $index => $goal): ?>
                                <div class="career-goal-item">
                                    <div class="goal-inputs">
                                        <input type="text" name="career_goals[<?php echo $index; ?>][role]" 
                                               placeholder="Target Role" 
                                               value="<?php echo htmlspecialchars($goal['target_role']); ?>" required>
                                        <select name="career_goals[<?php echo $index; ?>][industry]" required>
                                            <option value="">Select Industry</option>
                                            <option value="Technology" <?php echo $goal['target_industry'] === 'Technology' ? 'selected' : ''; ?>>Technology</option>
                                            <option value="Finance" <?php echo $goal['target_industry'] === 'Finance' ? 'selected' : ''; ?>>Finance</option>
                                            <option value="Healthcare" <?php echo $goal['target_industry'] === 'Healthcare' ? 'selected' : ''; ?>>Healthcare</option>
                                            <option value="Education" <?php echo $goal['target_industry'] === 'Education' ? 'selected' : ''; ?>>Education</option>
                                            <option value="Marketing" <?php echo $goal['target_industry'] === 'Marketing' ? 'selected' : ''; ?>>Marketing</option>
                                            <option value="Consulting" <?php echo $goal['target_industry'] === 'Consulting' ? 'selected' : ''; ?>>Consulting</option>
                                            <option value="Manufacturing" <?php echo $goal['target_industry'] === 'Manufacturing' ? 'selected' : ''; ?>>Manufacturing</option>
                                            <option value="Other" <?php echo $goal['target_industry'] === 'Other' ? 'selected' : ''; ?>>Other</option>
                                        </select>
                                        <select name="career_goals[<?php echo $index; ?>][timeline]">
                                            <option value="6" <?php echo $goal['timeline_months'] == 6 ? 'selected' : ''; ?>>6 months</option>
                                            <option value="12" <?php echo $goal['timeline_months'] == 12 ? 'selected' : ''; ?>>1 year</option>
                                            <option value="18" <?php echo $goal['timeline_months'] == 18 ? 'selected' : ''; ?>>18 months</option>
                                            <option value="24" <?php echo $goal['timeline_months'] == 24 ? 'selected' : ''; ?>>2 years</option>
                                            <option value="36" <?php echo $goal['timeline_months'] == 36 ? 'selected' : ''; ?>>3 years</option>
                                        </select>
                                        <select name="career_goals[<?php echo $index; ?>][priority]">
                                            <option value="high" <?php echo $goal['priority_level'] === 'high' ? 'selected' : ''; ?>>High Priority</option>
                                            <option value="medium" <?php echo $goal['priority_level'] === 'medium' ? 'selected' : ''; ?>>Medium Priority</option>
                                            <option value="low" <?php echo $goal['priority_level'] === 'low' ? 'selected' : ''; ?>>Low Priority</option>
                                        </select>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </div>
                    <button type="button" onclick="addCareerGoal()" class="add-goal-btn">
                        <i class="fas fa-plus"></i> Add Another Goal
                    </button>
                </div>
            </div>
            
            <!-- Learning Preferences Section -->
            <div class="assessment-section">
                <h2><i class="fas fa-brain"></i> Learning Preferences</h2>
                <div class="learning-preferences">
                    <div class="preference-group">
                        <label>Learning Style:</label>
                        <select name="learning_style">
                            <option value="visual" <?php echo ($existing_analytics['learning_style'] ?? '') === 'visual' ? 'selected' : ''; ?>>Visual (diagrams, images)</option>
                            <option value="auditory" <?php echo ($existing_analytics['learning_style'] ?? '') === 'auditory' ? 'selected' : ''; ?>>Auditory (lectures, discussions)</option>
                            <option value="kinesthetic" <?php echo ($existing_analytics['learning_style'] ?? '') === 'kinesthetic' ? 'selected' : ''; ?>>Hands-on (practice, exercises)</option>
                            <option value="mixed" <?php echo ($existing_analytics['learning_style'] ?? 'mixed') === 'mixed' ? 'selected' : ''; ?>>Mixed approach</option>
                        </select>
                    </div>
                    
                    <div class="preference-group">
                        <label>Preferred Difficulty:</label>
                        <select name="preferred_difficulty">
                            <option value="gradual" <?php echo ($existing_analytics['preferred_difficulty'] ?? '') === 'gradual' ? 'selected' : ''; ?>>Gradual progression</option>
                            <option value="challenging" <?php echo ($existing_analytics['preferred_difficulty'] ?? '') === 'challenging' ? 'selected' : ''; ?>>Challenging from start</option>
                            <option value="mixed" <?php echo ($existing_analytics['preferred_difficulty'] ?? 'mixed') === 'mixed' ? 'selected' : ''; ?>>Mixed difficulty</option>
                        </select>
                    </div>
                    
                    <div class="preference-group">
                        <label>Average Study Session (minutes):</label>
                        <input type="number" name="avg_session_duration" 
                               min="15" max="180" 
                               value="<?php echo $existing_analytics['average_session_duration_minutes'] ?? 45; ?>">
                    </div>
                </div>
            </div>
            
            <div class="form-actions">
                <button type="submit" name="save_skills" class="btn btn-primary btn-large">
                    <i class="fas fa-save"></i> Save Assessment & Generate Recommendations
                </button>
            </div>
        </form>
    </div>
</div>

<?php include 'assets/footer.php'; ?>

<script>
let goalCounter = <?php echo count($existing_goals) ?: 1; ?>;

function updateRatingDisplay(slider) {
    const display = slider.nextElementSibling;
    display.textContent = slider.value;
    
    // Add visual feedback
    if (slider.value >= 8) {
        display.style.color = '#48bb78';
        display.style.fontWeight = 'bold';
    } else if (slider.value >= 6) {
        display.style.color = '#ed8936';
    } else if (slider.value >= 3) {
        display.style.color = '#718096';
    } else {
        display.style.color = '#e53e3e';
    }
}

function addCareerGoal() {
    const container = document.getElementById('career-goals-container');
    const newGoal = document.createElement('div');
    newGoal.className = 'career-goal-item';
    newGoal.innerHTML = `
        <div class="goal-inputs">
            <input type="text" name="career_goals[${goalCounter}][role]" placeholder="Target Role" required>
            <select name="career_goals[${goalCounter}][industry]" required>
                <option value="">Select Industry</option>
                <option value="Technology">Technology</option>
                <option value="Finance">Finance</option>
                <option value="Healthcare">Healthcare</option>
                <option value="Education">Education</option>
                <option value="Marketing">Marketing</option>
                <option value="Consulting">Consulting</option>
                <option value="Manufacturing">Manufacturing</option>
                <option value="Other">Other</option>
            </select>
            <select name="career_goals[${goalCounter}][timeline]">
                <option value="6">6 months</option>
                <option value="12" selected>1 year</option>
                <option value="18">18 months</option>
                <option value="24">2 years</option>
                <option value="36">3 years</option>
            </select>
            <select name="career_goals[${goalCounter}][priority]">
                <option value="high">High Priority</option>
                <option value="medium" selected>Medium Priority</option>
                <option value="low">Low Priority</option>
            </select>
            <button type="button" onclick="removeCareerGoal(this)" class="remove-goal-btn">
                <i class="fas fa-times"></i>
            </button>
        </div>
    `;
    container.appendChild(newGoal);
    goalCounter++;
}

function removeCareerGoal(button) {
    button.closest('.career-goal-item').remove();
}

// Initialize rating displays
document.addEventListener('DOMContentLoaded', function() {
    const sliders = document.querySelectorAll('input[type="range"]');
    sliders.forEach(updateRatingDisplay);
});
</script>