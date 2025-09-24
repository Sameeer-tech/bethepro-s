<?php
/**
 * Simple Recommendation Engine
 * Easy to understand and maintain recommendation system
 * 
 * This system works by:
 * 1. Looking at user's skills and goals
 * 2. Finding courses that match their needs  
 * 3. Suggesting quizzes to test knowledge
 * 4. Recommending career paths
 */

class SimpleRecommendationEngine {
    private $pdo;
    
    public function __construct($pdo) {
        $this->pdo = $pdo;
    }
    
    /**
     * Get user's basic info for recommendations
     * Returns: skills, goals, completed courses
     */
    public function getUserInfo($user_id) {
        $user_info = [];
        
        // Get user's skills
        try {
            $stmt = $this->pdo->prepare("
                SELECT skill_name, proficiency_level, years_experience 
                FROM user_capabilities 
                WHERE user_id = ? 
                ORDER BY proficiency_level DESC
            ");
            $stmt->execute([$user_id]);
            $user_info['skills'] = $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            $user_info['skills'] = [];
        }
        
        // Get user's career goals
        try {
            $stmt = $this->pdo->prepare("
                SELECT target_role, target_industry 
                FROM user_career_goals 
                WHERE user_id = ? AND is_active = TRUE
            ");
            $stmt->execute([$user_id]);
            $user_info['goals'] = $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            $user_info['goals'] = [];
        }
        
        // Get completed courses
        try {
            $stmt = $this->pdo->prepare("
                SELECT course_name 
                FROM enrollments 
                WHERE user_id = ? AND status = 'completed'
            ");
            $stmt->execute([$user_id]);
            $user_info['completed_courses'] = $stmt->fetchAll(PDO::FETCH_COLUMN);
        } catch (Exception $e) {
            $user_info['completed_courses'] = [];
        }
        
        return $user_info;
    }
    
    /**
     * Generate course recommendations
     * Simple logic: match courses to user's goals and skill level
     */
    public function getCourseRecommendations($user_id, $limit = 6) {
        $user_info = $this->getUserInfo($user_id);
        $recommendations = [];
        
        // Get available courses
        try {
            $stmt = $this->pdo->prepare("
                SELECT id, title, description, level, price, duration 
                FROM courses 
                WHERE status = 'Active' 
                ORDER BY created_at DESC
            ");
            $stmt->execute();
            $courses = $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            return [];
        }
        
        foreach ($courses as $course) {
            // Skip if already completed
            if (in_array($course['title'], $user_info['completed_courses'])) {
                continue;
            }
            
            $score = $this->calculateSimpleScore($course, $user_info);
            
            if ($score['points'] >= 3) {
                $recommendations[] = [
                    'course_id' => $course['id'],
                    'title' => $course['title'],
                    'description' => $course['description'],
                    'level' => $course['level'],
                    'price' => $course['price'],
                    'duration' => $course['duration'],
                    'reason' => $score['reason'],
                    'match_percentage' => min(($score['points'] / 5) * 100, 100)
                ];
            }
        }
        
        // Sort by score and limit results
        usort($recommendations, function($a, $b) {
            return $b['match_percentage'] <=> $a['match_percentage'];
        });
        
        return array_slice($recommendations, 0, $limit);
    }
    
    /**
     * Simple scoring system
     * Points are awarded for matching user goals and skills
     */
    private function calculateSimpleScore($course, $user_info) {
        $points = 1; // Base point for all courses
        $reasons = [];
        
        // Check if course matches user's career goals
        foreach ($user_info['goals'] as $goal) {
            if (stripos($course['title'], $goal['target_role']) !== false ||
                stripos($course['description'], $goal['target_role']) !== false) {
                $points += 2;
                $reasons[] = "Matches your {$goal['target_role']} career goal";
                break;
            }
        }
        
        // Check skill level match
        $user_has_beginner = false;
        $user_has_intermediate = false;
        $user_has_advanced = false;
        
        foreach ($user_info['skills'] as $skill) {
            if ($skill['proficiency_level'] === 'beginner') $user_has_beginner = true;
            if ($skill['proficiency_level'] === 'intermediate') $user_has_intermediate = true;
            if ($skill['proficiency_level'] === 'advanced') $user_has_advanced = true;
        }
        
        if ($course['level'] === 'Beginner' && $user_has_beginner) {
            $points += 1;
            $reasons[] = "Good for your current skill level";
        } elseif ($course['level'] === 'Intermediate' && $user_has_intermediate) {
            $points += 1;
            $reasons[] = "Perfect for your intermediate skills";
        } elseif ($course['level'] === 'Advanced' && $user_has_advanced) {
            $points += 1;
            $reasons[] = "Advanced course to challenge you";
        }
        
        // Check for popular keywords
        $course_text = strtolower($course['title'] . ' ' . $course['description']);
        
        if (stripos($course_text, 'interview') !== false) {
            $points += 1;
            $reasons[] = "Helps with job interviews";
        }
        
        if (stripos($course_text, 'python') !== false || 
            stripos($course_text, 'javascript') !== false ||
            stripos($course_text, 'data') !== false) {
            $points += 1;
            $reasons[] = "Popular technology skill";
        }
        
        $reason = empty($reasons) ? 
            "Recommended course for your profile" : 
            implode(", ", $reasons);
        
        return [
            'points' => $points,
            'reason' => $reason
        ];
    }
    
    /**
     * Generate simple quiz recommendations
     */
    public function getQuizRecommendations($user_id, $limit = 4) {
        $user_info = $this->getUserInfo($user_id);
        
        // Simple predefined quizzes based on common needs
        $quiz_suggestions = [
            [
                'title' => 'Technical Interview Practice',
                'category' => 'Interview Prep',
                'difficulty' => 'Intermediate',
                'reason' => 'Test your technical knowledge for interviews',
                'duration' => '15 minutes',
                'questions' => 10
            ],
            [
                'title' => 'Programming Fundamentals Quiz',
                'category' => 'Technical Skills',
                'difficulty' => 'Beginner',
                'reason' => 'Assess your programming basics',
                'duration' => '20 minutes',
                'questions' => 15
            ],
            [
                'title' => 'Data Analysis Skills Test',
                'category' => 'Data Science',
                'difficulty' => 'Intermediate',
                'reason' => 'Evaluate your data analysis capabilities',
                'duration' => '25 minutes',
                'questions' => 12
            ],
            [
                'title' => 'Leadership & Communication',
                'category' => 'Soft Skills',
                'difficulty' => 'All Levels',
                'reason' => 'Improve your leadership abilities',
                'duration' => '10 minutes',
                'questions' => 8
            ]
        ];
        
        // Filter based on user's career goals
        $recommended_quizzes = [];
        foreach ($quiz_suggestions as $quiz) {
            $should_recommend = false;
            
            // Check if quiz matches user goals
            foreach ($user_info['goals'] as $goal) {
                if (stripos($quiz['title'], $goal['target_role']) !== false ||
                    stripos($goal['target_role'], 'developer') !== false && 
                    stripos($quiz['title'], 'Programming') !== false) {
                    $should_recommend = true;
                    break;
                }
            }
            
            // Always recommend interview prep and basic skills
            if (stripos($quiz['title'], 'Interview') !== false || 
                stripos($quiz['title'], 'Fundamentals') !== false) {
                $should_recommend = true;
            }
            
            if ($should_recommend) {
                $recommended_quizzes[] = $quiz;
            }
        }
        
        return array_slice($recommended_quizzes, 0, $limit);
    }
    
    /**
     * Generate career path recommendations
     */
    public function getCareerRecommendations($user_id, $limit = 3) {
        $user_info = $this->getUserInfo($user_id);
        
        // Simple career paths based on common goals
        $career_paths = [
            [
                'title' => 'Software Developer',
                'description' => 'Build applications and software solutions',
                'skills_needed' => ['Programming', 'Problem Solving', 'Debugging'],
                'avg_salary' => '$75,000',
                'job_growth' => 'High',
                'match_reason' => 'Growing field with many opportunities'
            ],
            [
                'title' => 'Data Analyst',
                'description' => 'Analyze data to help businesses make decisions',
                'skills_needed' => ['Excel', 'SQL', 'Data Visualization'],
                'avg_salary' => '$65,000',
                'job_growth' => 'Very High',
                'match_reason' => 'High demand for data professionals'
            ],
            [
                'title' => 'Digital Marketing Specialist',
                'description' => 'Promote products and services online',
                'skills_needed' => ['Social Media', 'SEO', 'Content Creation'],
                'avg_salary' => '$55,000',
                'job_growth' => 'High',
                'match_reason' => 'Creative and analytical career path'
            ]
        ];
        
        // Score based on user's existing goals
        foreach ($career_paths as &$path) {
            $path['match_score'] = 50; // Base score
            
            foreach ($user_info['goals'] as $goal) {
                if (stripos($path['title'], $goal['target_role']) !== false) {
                    $path['match_score'] += 30;
                    $path['match_reason'] = "Matches your stated career goal";
                }
            }
        }
        
        // Sort by match score
        usort($career_paths, function($a, $b) {
            return $b['match_score'] <=> $a['match_score'];
        });
        
        return array_slice($career_paths, 0, $limit);
    }
    
    /**
     * Save user's recommendation preferences
     */
    public function saveUserAction($user_id, $action, $item_id, $item_type) {
        try {
            $stmt = $this->pdo->prepare("
                INSERT INTO user_recommendation_actions 
                (user_id, action, item_id, item_type, created_at) 
                VALUES (?, ?, ?, ?, NOW())
            ");
            $stmt->execute([$user_id, $action, $item_id, $item_type]);
            return true;
        } catch (Exception $e) {
            return false;
        }
    }
}
?>