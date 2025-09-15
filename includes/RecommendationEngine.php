<?php
// Intelligent Recommendation Engine
// Analyzes user capabilities and generates personalized course, quiz, and career recommendations

if (!class_exists('RecommendationEngine')) {
class RecommendationEngine {
    private $pdo;
    
    public function __construct($pdo) {
        $this->pdo = $pdo;
    }
    
    // Analyze user capabilities and learning patterns
    public function analyzeUserProfile($user_id) {
        $profile = [];
        
        // Get user's current skills and proficiencies
        $stmt = $this->pdo->prepare("
            SELECT skill_category, skill_name, proficiency_level, years_experience, 
                   self_rating, verified_rating 
            FROM user_capabilities 
            WHERE user_id = ? 
            ORDER BY verified_rating DESC, self_rating DESC
        ");
        $stmt->execute([$user_id]);
        $profile['skills'] = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        // Get career goals
        $stmt = $this->pdo->prepare("
            SELECT target_role, target_industry, timeline_months, priority_level 
            FROM user_career_goals 
            WHERE user_id = ? AND is_active = TRUE 
            ORDER BY priority_level = 'high' DESC, timeline_months ASC
        ");
        $stmt->execute([$user_id]);
        $profile['career_goals'] = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        // Get learning analytics
        $stmt = $this->pdo->prepare("
            SELECT * FROM user_learning_analytics WHERE user_id = ?
        ");
        $stmt->execute([$user_id]);
        $profile['learning_analytics'] = $stmt->fetch(PDO::FETCH_ASSOC);
        
        // Get completed courses
        $stmt = $this->pdo->prepare("
            SELECT course_name, level, status 
            FROM enrollments 
            WHERE user_id = ? 
            ORDER BY enrollment_date DESC
        ");
        $stmt->execute([$user_id]);
        $profile['completed_courses'] = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        return $profile;
    }
    
    // Generate course recommendations based on user profile
    public function generateCourseRecommendations($user_id, $limit = 10) {
        $user_profile = $this->analyzeUserProfile($user_id);
        $recommendations = [];
        
        // Clear old recommendations
        $stmt = $this->pdo->prepare("DELETE FROM course_recommendations WHERE user_id = ? AND expires_at < NOW()");
        $stmt->execute([$user_id]);
        
        // Get available courses
        $stmt = $this->pdo->prepare("SELECT * FROM courses WHERE status = 'Active' ORDER BY created_at DESC");
        $stmt->execute();
        $available_courses = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        foreach ($available_courses as $course) {
            $score = $this->calculateCourseRelevanceScore($course, $user_profile);
            
            if ($score['relevance_score'] >= 6.0) {
                $recommendation = [
                    'user_id' => $user_id,
                    'course_id' => $course['id'],
                    'course_title' => $course['title'],
                    'recommendation_reason' => $score['reason'],
                    'relevance_score' => $score['relevance_score'],
                    'difficulty_match' => $score['difficulty_match'],
                    'career_impact_score' => $score['career_impact'],
                    'estimated_completion_days' => $this->estimateCompletionTime($course, $user_profile)
                ];
                
                $recommendations[] = $recommendation;
            }
        }
        
        // Sort by relevance score and limit results
        usort($recommendations, function($a, $b) {
            return $b['relevance_score'] <=> $a['relevance_score'];
        });
        
        $recommendations = array_slice($recommendations, 0, $limit);
        
        // Insert recommendations into database
        foreach ($recommendations as $rec) {
            $this->insertCourseRecommendation($rec);
        }
        
        return $recommendations;
    }
    
    // Calculate course relevance score based on user profile
    private function calculateCourseRelevanceScore($course, $user_profile) {
        $base_score = 5.0;
        $reason_parts = [];
        $career_impact = 5.0;
        $difficulty_match = 'perfect';
        
        // Check alignment with career goals
        if (!empty($user_profile['career_goals'])) {
            foreach ($user_profile['career_goals'] as $goal) {
                if (stripos($course['title'], $goal['target_role']) !== false ||
                    stripos($course['description'], $goal['target_role']) !== false) {
                    $base_score += 2.0;
                    $career_impact += 2.0;
                    $reason_parts[] = "Aligns with your {$goal['target_role']} career goal";
                }
            }
        }
        
        // Check skill level match
        $user_skill_levels = [];
        if (!empty($user_profile['skills'])) {
            foreach ($user_profile['skills'] as $skill) {
                $user_skill_levels[] = $skill['proficiency_level'];
            }
            
            $avg_skill_level = $this->getAverageSkillLevel($user_skill_levels);
            
            if ($course['level'] === 'Beginner' && in_array('beginner', $user_skill_levels)) {
                $base_score += 1.0;
                $reason_parts[] = "Perfect for your current skill level";
            } elseif ($course['level'] === 'Intermediate' && $avg_skill_level >= 1.5) {
                $base_score += 1.5;
                $difficulty_match = 'perfect';
                $reason_parts[] = "Matches your intermediate skill level";
            } elseif ($course['level'] === 'Advanced' && $avg_skill_level >= 2.5) {
                $base_score += 2.0;
                $difficulty_match = 'challenging';
                $reason_parts[] = "Challenging course to advance your skills";
            }
        }
        
        // Check for skill gaps
        $course_keywords = strtolower($course['title'] . ' ' . $course['description']);
        if (stripos($course_keywords, 'interview') !== false) {
            $base_score += 1.5;
            $reason_parts[] = "Helps with interview preparation";
        }
        if (stripos($course_keywords, 'leadership') !== false) {
            $base_score += 1.0;
            $reason_parts[] = "Develops leadership capabilities";
        }
        if (stripos($course_keywords, 'technical') !== false) {
            $base_score += 1.0;
            $reason_parts[] = "Enhances technical expertise";
        }
        
        // Learning analytics consideration
        if (!empty($user_profile['learning_analytics'])) {
            $analytics = $user_profile['learning_analytics'];
            if ($analytics['completion_rate'] > 0.8) {
                $base_score += 0.5;
                $reason_parts[] = "You have excellent course completion rate";
            }
        }
        
        // Cap the score at 10
        $final_score = min($base_score, 10.0);
        
        $reason = empty($reason_parts) ? 
            "Recommended based on your profile and learning goals" : 
            implode(". ", $reason_parts);
        
        return [
            'relevance_score' => round($final_score, 2),
            'reason' => $reason,
            'difficulty_match' => $difficulty_match,
            'career_impact' => round($career_impact, 2)
        ];
    }
    
    // Generate quiz recommendations
    public function generateQuizRecommendations($user_id, $limit = 5) {
        $user_profile = $this->analyzeUserProfile($user_id);
        
        // Clear old quiz recommendations
        $stmt = $this->pdo->prepare("DELETE FROM quiz_recommendations WHERE user_id = ? AND expires_at < NOW()");
        $stmt->execute([$user_id]);
        
        $quiz_recommendations = [
            [
                'user_id' => $user_id,
                'quiz_category' => 'Interview Preparation',
                'quiz_title' => 'Technical Interview Assessment',
                'quiz_description' => 'Evaluate your readiness for technical interviews with coding challenges and system design questions.',
                'difficulty_level' => $this->determineBestQuizDifficulty($user_profile, 'technical'),
                'estimated_duration_minutes' => 30,
                'skills_assessed' => json_encode(['problem_solving', 'coding', 'system_design']),
                'recommendation_reason' => 'Based on your technical background and career goals',
                'priority_score' => $this->calculateQuizPriority($user_profile, 'technical')
            ],
            [
                'user_id' => $user_id,
                'quiz_category' => 'Communication Skills',
                'quiz_title' => 'Professional Communication Assessment',
                'quiz_description' => 'Assess your communication skills including presentation, writing, and interpersonal abilities.',
                'difficulty_level' => $this->determineBestQuizDifficulty($user_profile, 'communication'),
                'estimated_duration_minutes' => 20,
                'skills_assessed' => json_encode(['verbal_communication', 'written_communication', 'presentation']),
                'recommendation_reason' => 'Essential for career advancement in any field',
                'priority_score' => $this->calculateQuizPriority($user_profile, 'communication')
            ],
            [
                'user_id' => $user_id,
                'quiz_category' => 'Leadership Potential',
                'quiz_title' => 'Leadership Readiness Assessment',
                'quiz_description' => 'Discover your leadership potential and areas for development in management roles.',
                'difficulty_level' => $this->determineBestQuizDifficulty($user_profile, 'leadership'),
                'estimated_duration_minutes' => 25,
                'skills_assessed' => json_encode(['leadership', 'team_management', 'decision_making']),
                'recommendation_reason' => 'Perfect for aspiring leaders and managers',
                'priority_score' => $this->calculateQuizPriority($user_profile, 'leadership')
            ]
        ];
        
        // Sort by priority score
        usort($quiz_recommendations, function($a, $b) {
            return $b['priority_score'] <=> $a['priority_score'];
        });
        
        $quiz_recommendations = array_slice($quiz_recommendations, 0, $limit);
        
        // Insert into database
        foreach ($quiz_recommendations as $quiz) {
            $this->insertQuizRecommendation($quiz);
        }
        
        return $quiz_recommendations;
    }
    
    // Generate career path recommendations
    public function generateCareerPathRecommendations($user_id, $limit = 3) {
        $user_profile = $this->analyzeUserProfile($user_id);
        
        $career_paths = [
            [
                'user_id' => $user_id,
                'path_name' => 'Software Development Professional',
                'path_description' => 'Advance from junior to senior software developer with expertise in modern technologies.',
                'current_role' => 'Junior Developer',
                'target_role' => 'Senior Software Engineer',
                'industry' => 'Technology',
                'estimated_timeline_months' => 18,
                'required_skills' => json_encode(['Programming', 'System Design', 'Code Review', 'Testing']),
                'optional_skills' => json_encode(['Cloud Computing', 'DevOps', 'Machine Learning']),
                'milestones' => json_encode([
                    '3 months: Complete advanced programming course',
                    '6 months: Build portfolio projects',
                    '12 months: Lead a small project',
                    '18 months: Senior developer interview preparation'
                ]),
                'compatibility_score' => $this->calculateCareerPathCompatibility($user_profile, 'technical')
            ],
            [
                'user_id' => $user_id,
                'path_name' => 'Project Management Leader',
                'path_description' => 'Transition into project management with leadership and organizational skills.',
                'current_role' => 'Team Member',
                'target_role' => 'Project Manager',
                'industry' => 'Various',
                'estimated_timeline_months' => 12,
                'required_skills' => json_encode(['Project Planning', 'Team Leadership', 'Communication', 'Risk Management']),
                'optional_skills' => json_encode(['Agile Methodology', 'Budget Management', 'Stakeholder Management']),
                'milestones' => json_encode([
                    '2 months: Complete project management fundamentals',
                    '4 months: Obtain PMP certification',
                    '8 months: Lead a pilot project',
                    '12 months: Apply for PM positions'
                ]),
                'compatibility_score' => $this->calculateCareerPathCompatibility($user_profile, 'management')
            ],
            [
                'user_id' => $user_id,
                'path_name' => 'Data Analytics Specialist',
                'path_description' => 'Build expertise in data analysis, visualization, and business intelligence.',
                'current_role' => 'Analyst',
                'target_role' => 'Senior Data Analyst',
                'industry' => 'Technology/Finance',
                'estimated_timeline_months' => 15,
                'required_skills' => json_encode(['Data Analysis', 'SQL', 'Python/R', 'Data Visualization']),
                'optional_skills' => json_encode(['Machine Learning', 'Big Data', 'Statistical Analysis']),
                'milestones' => json_encode([
                    '3 months: Master SQL and data fundamentals',
                    '6 months: Complete Python for data analysis',
                    '9 months: Build data visualization portfolio',
                    '15 months: Advanced analytics certification'
                ]),
                'compatibility_score' => $this->calculateCareerPathCompatibility($user_profile, 'analytical')
            ]
        ];
        
        // Sort by compatibility score
        usort($career_paths, function($a, $b) {
            return $b['compatibility_score'] <=> $a['compatibility_score'];
        });
        
        $career_paths = array_slice($career_paths, 0, $limit);
        
        // Insert into database
        foreach ($career_paths as $path) {
            $this->insertCareerPathRecommendation($path);
        }
        
        return $career_paths;
    }
    
    // Helper methods
    private function getAverageSkillLevel($skill_levels) {
        $level_values = ['beginner' => 1, 'intermediate' => 2, 'advanced' => 3, 'expert' => 4];
        $total = 0;
        $count = 0;
        
        foreach ($skill_levels as $level) {
            if (isset($level_values[$level])) {
                $total += $level_values[$level];
                $count++;
            }
        }
        
        return $count > 0 ? $total / $count : 1;
    }
    
    private function determineBestQuizDifficulty($user_profile, $category) {
        // Logic to determine appropriate quiz difficulty based on user skills
        if (empty($user_profile['skills'])) return 'beginner';
        
        $relevant_skills = array_filter($user_profile['skills'], function($skill) use ($category) {
            return stripos($skill['skill_category'], $category) !== false;
        });
        
        if (empty($relevant_skills)) return 'beginner';
        
        $avg_rating = array_sum(array_column($relevant_skills, 'self_rating')) / count($relevant_skills);
        
        if ($avg_rating >= 8) return 'expert';
        if ($avg_rating >= 6) return 'advanced';
        if ($avg_rating >= 4) return 'intermediate';
        return 'beginner';
    }
    
    private function calculateQuizPriority($user_profile, $category) {
        // Calculate priority score based on user's career goals and current skills
        $base_priority = 5.0;
        
        if (!empty($user_profile['career_goals'])) {
            foreach ($user_profile['career_goals'] as $goal) {
                if (stripos($goal['target_role'], $category) !== false) {
                    $base_priority += 2.0;
                }
            }
        }
        
        return min($base_priority, 10.0);
    }
    
    private function calculateCareerPathCompatibility($user_profile, $path_type) {
        $base_score = 5.0;
        
        // Check existing skills alignment
        if (!empty($user_profile['skills'])) {
            foreach ($user_profile['skills'] as $skill) {
                if (($path_type === 'technical' && stripos($skill['skill_category'], 'technical') !== false) ||
                    ($path_type === 'management' && stripos($skill['skill_category'], 'leadership') !== false) ||
                    ($path_type === 'analytical' && stripos($skill['skill_category'], 'analytical') !== false)) {
                    $base_score += 1.0;
                }
            }
        }
        
        // Check career goals alignment
        if (!empty($user_profile['career_goals'])) {
            foreach ($user_profile['career_goals'] as $goal) {
                if (stripos($goal['target_role'], $path_type) !== false) {
                    $base_score += 2.0;
                }
            }
        }
        
        return min($base_score, 10.0);
    }
    
    private function estimateCompletionTime($course, $user_profile) {
        $base_days = 30;
        
        // Adjust based on user's learning pace
        if (!empty($user_profile['learning_analytics'])) {
            $pace = $user_profile['learning_analytics']['learning_pace'];
            if ($pace === 'fast') $base_days -= 10;
            elseif ($pace === 'slow') $base_days += 15;
        }
        
        // Adjust based on course duration
        if (stripos($course['duration'], 'week') !== false) {
            preg_match('/(\d+)/', $course['duration'], $matches);
            if (!empty($matches[1])) {
                $base_days = intval($matches[1]) * 7;
            }
        }
        
        return max($base_days, 7); // Minimum 1 week
    }
    
    // Database insertion methods
    private function insertCourseRecommendation($recommendation) {
        $stmt = $this->pdo->prepare("
            INSERT INTO course_recommendations 
            (user_id, course_id, course_title, recommendation_reason, relevance_score, 
             difficulty_match, career_impact_score, estimated_completion_days) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?)
            ON DUPLICATE KEY UPDATE
            relevance_score = VALUES(relevance_score),
            recommendation_reason = VALUES(recommendation_reason)
        ");
        
        $stmt->execute([
            $recommendation['user_id'],
            $recommendation['course_id'],
            $recommendation['course_title'],
            $recommendation['recommendation_reason'],
            $recommendation['relevance_score'],
            $recommendation['difficulty_match'],
            $recommendation['career_impact_score'],
            $recommendation['estimated_completion_days']
        ]);
    }
    
    private function insertQuizRecommendation($quiz) {
        $stmt = $this->pdo->prepare("
            INSERT INTO quiz_recommendations 
            (user_id, quiz_category, quiz_title, quiz_description, difficulty_level, 
             estimated_duration_minutes, skills_assessed, recommendation_reason, priority_score) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)
            ON DUPLICATE KEY UPDATE
            priority_score = VALUES(priority_score),
            recommendation_reason = VALUES(recommendation_reason)
        ");
        
        $stmt->execute([
            $quiz['user_id'],
            $quiz['quiz_category'],
            $quiz['quiz_title'],
            $quiz['quiz_description'],
            $quiz['difficulty_level'],
            $quiz['estimated_duration_minutes'],
            $quiz['skills_assessed'],
            $quiz['recommendation_reason'],
            $quiz['priority_score']
        ]);
    }
    
    private function insertCareerPathRecommendation($path) {
        $stmt = $this->pdo->prepare("
            INSERT INTO career_path_recommendations 
            (user_id, path_name, path_description, current_role, target_role, industry,
             estimated_timeline_months, required_skills, optional_skills, milestones, compatibility_score) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
            ON DUPLICATE KEY UPDATE
            compatibility_score = VALUES(compatibility_score),
            path_description = VALUES(path_description)
        ");
        
        $stmt->execute([
            $path['user_id'],
            $path['path_name'],
            $path['path_description'],
            $path['current_role'],
            $path['target_role'],
            $path['industry'],
            $path['estimated_timeline_months'],
            $path['required_skills'],
            $path['optional_skills'],
            $path['milestones'],
            $path['compatibility_score']
        ]);
    }
    
    // Generate all types of recommendations for a user
    public function generateAllRecommendations($user_id) {
        try {
            // Generate course recommendations
            $this->generateCourseRecommendations($user_id, 10);
            
            // Generate quiz recommendations
            $this->generateQuizRecommendations($user_id, 5);
            
            // Generate career path recommendations  
            $this->generateCareerPathRecommendations($user_id, 3);
            
            return true;
        } catch (Exception $e) {
            error_log("Error generating all recommendations for user {$user_id}: " . $e->getMessage());
            
            // Generate basic recommendations even if some fail
            try {
                $this->generateBasicRecommendations($user_id);
                return true;
            } catch (Exception $e2) {
                error_log("Error generating basic recommendations: " . $e2->getMessage());
                return false;
            }
        }
    }
    
    // Generate basic recommendations when full system isn't available
    public function generateBasicRecommendations($user_id) {
        try {
            // Clear old recommendations
            $stmt = $this->pdo->prepare("DELETE FROM course_recommendations WHERE user_id = ?");
            $stmt->execute([$user_id]);
            
            // Get available courses and create simple recommendations
            $stmt = $this->pdo->prepare("SELECT * FROM courses WHERE status = 'Active' LIMIT 5");
            $stmt->execute();
            $courses = $stmt->fetchAll(PDO::FETCH_ASSOC);
            
            foreach ($courses as $course) {
                $stmt = $this->pdo->prepare("
                    INSERT INTO course_recommendations 
                    (user_id, course_id, course_title, recommendation_reason, relevance_score, status, created_at)
                    VALUES (?, ?, ?, ?, ?, 'pending', NOW())
                ");
                
                $stmt->execute([
                    $user_id,
                    $course['id'],
                    $course['title'], // Changed from 'course_name' to 'title'
                    'Recommended based on your interests and current skill level.',
                    7.5, // Default score
                ]);
            }
            
            // Generate basic quiz recommendations
            $quizTopics = ['Python', 'JavaScript', 'SQL', 'HTML/CSS', 'Communication'];
            $stmt = $this->pdo->prepare("DELETE FROM quiz_recommendations WHERE user_id = ?");
            $stmt->execute([$user_id]);
            
            foreach ($quizTopics as $topic) {
                $stmt = $this->pdo->prepare("
                    INSERT INTO quiz_recommendations 
                    (user_id, quiz_title, quiz_category, recommendation_reason, priority_score, status, created_at)
                    VALUES (?, ?, ?, ?, ?, 'pending', NOW())
                ");
                
                $stmt->execute([
                    $user_id,
                    $topic . ' Skills Quiz',
                    $topic,
                    'Test your knowledge in ' . $topic . ' and identify areas for improvement.',
                    6.0
                ]);
            }
            
            // Generate basic career path recommendation
            $stmt = $this->pdo->prepare("DELETE FROM career_path_recommendations WHERE user_id = ?");
            $stmt->execute([$user_id]);
            
            $stmt = $this->pdo->prepare("
                INSERT INTO career_path_recommendations 
                (user_id, path_name, path_description, current_job_role, target_job_role, industry, compatibility_score, status, created_at)
                VALUES (?, ?, ?, ?, ?, ?, ?, 'pending', NOW())
            ");
            
            $stmt->execute([
                $user_id,
                'Full Stack Developer Path',
                'Complete journey from beginner to full stack developer with modern technologies.',
                'Student/Beginner',
                'Full Stack Developer',
                'Technology',
                8.0
            ]);
            
            return true;
        } catch (Exception $e) {
            error_log("Error generating basic recommendations: " . $e->getMessage());
            return false;
        }
    }
}
} // End of class_exists check
?>