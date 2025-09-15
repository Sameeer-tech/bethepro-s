<?php
// Notification System
// Automatically generates personalized notifications for users

class NotificationSystem {
    private $pdo;
    
    public function __construct($pdo) {
        $this->pdo = $pdo;
    }
    
    // Generate notifications for a specific user
    public function generateUserNotifications($user_id) {
        // Clear expired notifications
        $this->cleanExpiredNotifications($user_id);
        
        // Generate different types of notifications
        $this->generateCourseRecommendationNotifications($user_id);
        $this->generateSkillAssessmentNotifications($user_id);
        $this->generateProgressUpdateNotifications($user_id);
        $this->generateCareerOpportunityNotifications($user_id);
        $this->generateMilestoneNotifications($user_id);
    }
    
    // Generate notifications for all active users
    public function generateAllUserNotifications() {
        try {
            $stmt = $this->pdo->query("SELECT id FROM users WHERE status = 'Active'");
            $users = $stmt->fetchAll();
            
            foreach ($users as $user) {
                $this->generateUserNotifications($user['id']);
            }
        } catch (PDOException $e) {
            error_log("Error generating notifications: " . $e->getMessage());
        }
    }
    
    // Clean up expired notifications
    private function cleanExpiredNotifications($user_id) {
        try {
            $stmt = $this->pdo->prepare("DELETE FROM user_notifications WHERE user_id = ? AND expires_at < NOW()");
            $stmt->execute([$user_id]);
        } catch (PDOException $e) {
            error_log("Error cleaning notifications: " . $e->getMessage());
        }
    }
    
    // Generate course recommendation notifications
    private function generateCourseRecommendationNotifications($user_id) {
        try {
            // Check if user has new high-relevance course recommendations
            $stmt = $this->pdo->prepare("
                SELECT COUNT(*) as count, MAX(relevance_score) as max_score
                FROM course_recommendations 
                WHERE user_id = ? AND status = 'pending' AND relevance_score >= 8.0
            ");
            $stmt->execute([$user_id]);
            $result = $stmt->fetch();
            
            if ($result && $result['count'] > 0) {
                // Check if we already sent this notification recently
                $stmt = $this->pdo->prepare("
                    SELECT COUNT(*) as count 
                    FROM user_notifications 
                    WHERE user_id = ? AND notification_type = 'course_recommendation' 
                    AND created_at > DATE_SUB(NOW(), INTERVAL 3 DAY)
                ");
                $stmt->execute([$user_id]);
                $recent = $stmt->fetch();
                
                if (!$recent || $recent['count'] == 0) {
                    $this->createNotification([
                        'user_id' => $user_id,
                        'notification_type' => 'course_recommendation',
                        'title' => 'Perfect Course Matches Found!',
                        'message' => "We found {$result['count']} highly recommended courses that match your skills and career goals perfectly (up to " . round($result['max_score'] * 10) . "% match).",
                        'action_url' => 'recommendations.php#courses',
                        'action_text' => 'View Recommendations',
                        'priority' => 'high'
                    ]);
                }
            }
        } catch (PDOException $e) {
            error_log("Error generating course notifications: " . $e->getMessage());
        }
    }
    
    // Generate skill assessment notifications
    private function generateSkillAssessmentNotifications($user_id) {
        try {
            // Check when user last updated their skills
            $stmt = $this->pdo->prepare("
                SELECT MAX(last_assessed) as last_assessment, COUNT(*) as skills_count
                FROM user_capabilities 
                WHERE user_id = ?
            ");
            $stmt->execute([$user_id]);
            $result = $stmt->fetch();
            
            $needs_assessment = false;
            $message = '';
            
            if (!$result || $result['skills_count'] == 0) {
                $needs_assessment = true;
                $message = "Complete your skills assessment to unlock personalized course recommendations and career guidance tailored specifically for you.";
            } elseif ($result['last_assessment'] && 
                     strtotime($result['last_assessment']) < strtotime('-3 months')) {
                $needs_assessment = true;
                $months_ago = floor((time() - strtotime($result['last_assessment'])) / (30 * 24 * 60 * 60));
                $message = "It's been {$months_ago} months since your last skills assessment. Update your profile to get the most relevant recommendations.";
            }
            
            if ($needs_assessment) {
                // Check if we already sent this notification recently
                $stmt = $this->pdo->prepare("
                    SELECT COUNT(*) as count 
                    FROM user_notifications 
                    WHERE user_id = ? AND notification_type = 'skill_assessment' 
                    AND created_at > DATE_SUB(NOW(), INTERVAL 7 DAY)
                ");
                $stmt->execute([$user_id]);
                $recent = $stmt->fetch();
                
                if (!$recent || $recent['count'] == 0) {
                    $this->createNotification([
                        'user_id' => $user_id,
                        'notification_type' => 'skill_assessment',
                        'title' => 'Skills Assessment Needed',
                        'message' => $message,
                        'action_url' => 'skill-assessment.php',
                        'action_text' => 'Take Assessment',
                        'priority' => 'medium'
                    ]);
                }
            }
        } catch (PDOException $e) {
            error_log("Error generating skill assessment notifications: " . $e->getMessage());
        }
    }
    
    // Generate progress update notifications
    private function generateProgressUpdateNotifications($user_id) {
        try {
            // Check user's learning progress
            $stmt = $this->pdo->prepare("
                SELECT 
                    COUNT(CASE WHEN status = 'completed' THEN 1 END) as completed_courses,
                    COUNT(CASE WHEN status = 'active' THEN 1 END) as active_courses,
                    COUNT(*) as total_enrollments
                FROM enrollments 
                WHERE user_id = ?
            ");
            $stmt->execute([$user_id]);
            $progress = $stmt->fetch();
            
            if ($progress && $progress['total_enrollments'] > 0) {
                $completion_rate = ($progress['completed_courses'] / $progress['total_enrollments']) * 100;
                
                // Motivational notifications based on progress
                if ($progress['completed_courses'] > 0 && $progress['completed_courses'] % 3 == 0) {
                    // Check if we already celebrated this milestone
                    $stmt = $this->pdo->prepare("
                        SELECT COUNT(*) as count 
                        FROM user_notifications 
                        WHERE user_id = ? AND notification_type = 'milestone_achieved' 
                        AND message LIKE '%{$progress['completed_courses']} courses%'
                    ");
                    $stmt->execute([$user_id]);
                    $already_celebrated = $stmt->fetch();
                    
                    if (!$already_celebrated || $already_celebrated['count'] == 0) {
                        $this->createNotification([
                            'user_id' => $user_id,
                            'notification_type' => 'milestone_achieved',
                            'title' => 'Congratulations on Your Progress! 🎉',
                            'message' => "Amazing! You've completed {$progress['completed_courses']} courses. Your dedication to learning is paying off!",
                            'action_url' => 'profile.php',
                            'action_text' => 'View Achievements',
                            'priority' => 'medium'
                        ]);
                    }
                }
                
                // Encourage users with active courses
                if ($progress['active_courses'] > 0 && $completion_rate < 50) {
                    $stmt = $this->pdo->prepare("
                        SELECT COUNT(*) as count 
                        FROM user_notifications 
                        WHERE user_id = ? AND notification_type = 'progress_update' 
                        AND created_at > DATE_SUB(NOW(), INTERVAL 2 WEEK)
                    ");
                    $stmt->execute([$user_id]);
                    $recent = $stmt->fetch();
                    
                    if (!$recent || $recent['count'] == 0) {
                        $this->createNotification([
                            'user_id' => $user_id,
                            'notification_type' => 'progress_update',
                            'title' => 'Keep Up the Great Work!',
                            'message' => "You have {$progress['active_courses']} active courses. A little progress each day leads to big results!",
                            'action_url' => 'profile.php#enrollments',
                            'action_text' => 'Continue Learning',
                            'priority' => 'low'
                        ]);
                    }
                }
            }
        } catch (PDOException $e) {
            error_log("Error generating progress notifications: " . $e->getMessage());
        }
    }
    
    // Generate career opportunity notifications
    private function generateCareerOpportunityNotifications($user_id) {
        try {
            // Check if user has career goals and matching opportunities
            $stmt = $this->pdo->prepare("
                SELECT cg.target_role, cg.target_industry, cg.timeline_months,
                       COUNT(cpr.id) as matching_paths
                FROM user_career_goals cg
                LEFT JOIN career_path_recommendations cpr ON (
                    cpr.user_id = cg.user_id AND 
                    (cpr.target_role LIKE CONCAT('%', cg.target_role, '%') OR 
                     cpr.industry = cg.target_industry)
                )
                WHERE cg.user_id = ? AND cg.is_active = TRUE
                GROUP BY cg.id
                HAVING matching_paths > 0
                ORDER BY cg.priority_level = 'high' DESC
                LIMIT 1
            ");
            $stmt->execute([$user_id]);
            $opportunity = $stmt->fetch();
            
            if ($opportunity) {
                // Check if we already sent career opportunity notifications recently
                $stmt = $this->pdo->prepare("
                    SELECT COUNT(*) as count 
                    FROM user_notifications 
                    WHERE user_id = ? AND notification_type = 'career_opportunity' 
                    AND created_at > DATE_SUB(NOW(), INTERVAL 1 WEEK)
                ");
                $stmt->execute([$user_id]);
                $recent = $stmt->fetch();
                
                if (!$recent || $recent['count'] == 0) {
                    $this->createNotification([
                        'user_id' => $user_id,
                        'notification_type' => 'career_opportunity',
                        'title' => 'Career Path Opportunity!',
                        'message' => "Great news! We found {$opportunity['matching_paths']} career paths that align with your goal to become a {$opportunity['target_role']} in {$opportunity['target_industry']}.",
                        'action_url' => 'recommendations.php#career-paths',
                        'action_text' => 'Explore Paths',
                        'priority' => 'high'
                    ]);
                }
            }
        } catch (PDOException $e) {
            error_log("Error generating career opportunity notifications: " . $e->getMessage());
        }
    }
    
    // Generate milestone notifications
    private function generateMilestoneNotifications($user_id) {
        try {
            // Check for users following career paths
            $stmt = $this->pdo->prepare("
                SELECT * FROM career_path_recommendations 
                WHERE user_id = ? AND status = 'following'
                ORDER BY created_at DESC
                LIMIT 1
            ");
            $stmt->execute([$user_id]);
            $following_path = $stmt->fetch();
            
            if ($following_path) {
                $months_following = floor((time() - strtotime($following_path['created_at'])) / (30 * 24 * 60 * 60));
                
                // Milestone notifications every 2 months
                if ($months_following > 0 && $months_following % 2 == 0) {
                    $stmt = $this->pdo->prepare("
                        SELECT COUNT(*) as count 
                        FROM user_notifications 
                        WHERE user_id = ? AND notification_type = 'milestone_achieved' 
                        AND message LIKE '%{$months_following} months%'
                        AND created_at > DATE_SUB(NOW(), INTERVAL 1 MONTH)
                    ");
                    $stmt->execute([$user_id]);
                    $already_notified = $stmt->fetch();
                    
                    if (!$already_notified || $already_notified['count'] == 0) {
                        $milestones = json_decode($following_path['milestones'], true);
                        $current_milestone = isset($milestones[$months_following - 1]) ? 
                                           $milestones[$months_following - 1] : 
                                           "Continue building skills and experience";
                        
                        $this->createNotification([
                            'user_id' => $user_id,
                            'notification_type' => 'milestone_achieved',
                            'title' => 'Career Path Milestone Reached!',
                            'message' => "You've been following the {$following_path['path_name']} path for {$months_following} months. Current focus: {$current_milestone}",
                            'action_url' => 'recommendations.php#career-paths',
                            'action_text' => 'View Progress',
                            'priority' => 'medium'
                        ]);
                    }
                }
            }
        } catch (PDOException $e) {
            error_log("Error generating milestone notifications: " . $e->getMessage());
        }
    }
    
    // Create a notification in the database
    private function createNotification($data) {
        try {
            $stmt = $this->pdo->prepare("
                INSERT INTO user_notifications 
                (user_id, notification_type, title, message, action_url, action_text, priority, metadata)
                VALUES (?, ?, ?, ?, ?, ?, ?, ?)
            ");
            
            $metadata = json_encode([
                'generated_at' => date('Y-m-d H:i:s'),
                'source' => 'NotificationSystem'
            ]);
            
            $stmt->execute([
                $data['user_id'],
                $data['notification_type'],
                $data['title'],
                $data['message'],
                $data['action_url'] ?? null,
                $data['action_text'] ?? null,
                $data['priority'] ?? 'medium',
                $metadata
            ]);
            
            return $this->pdo->lastInsertId();
        } catch (PDOException $e) {
            error_log("Error creating notification: " . $e->getMessage());
            return false;
        }
    }
    
    // Mark notification as read
    public function markAsRead($notification_id, $user_id) {
        try {
            $stmt = $this->pdo->prepare("
                UPDATE user_notifications 
                SET is_read = TRUE, read_at = NOW() 
                WHERE id = ? AND user_id = ?
            ");
            return $stmt->execute([$notification_id, $user_id]);
        } catch (PDOException $e) {
            error_log("Error marking notification as read: " . $e->getMessage());
            return false;
        }
    }
    
    // Dismiss notification
    public function dismissNotification($notification_id, $user_id) {
        try {
            $stmt = $this->pdo->prepare("
                UPDATE user_notifications 
                SET is_dismissed = TRUE 
                WHERE id = ? AND user_id = ?
            ");
            return $stmt->execute([$notification_id, $user_id]);
        } catch (PDOException $e) {
            error_log("Error dismissing notification: " . $e->getMessage());
            return false;
        }
    }
    
    // Get unread notification count for user
    public function getUnreadCount($user_id) {
        try {
            $stmt = $this->pdo->prepare("
                SELECT COUNT(*) as count 
                FROM user_notifications 
                WHERE user_id = ? AND is_read = FALSE AND is_dismissed = FALSE 
                AND expires_at > NOW()
            ");
            $stmt->execute([$user_id]);
            $result = $stmt->fetch();
            return $result ? $result['count'] : 0;
        } catch (PDOException $e) {
            error_log("Error getting unread count: " . $e->getMessage());
            return 0;
        }
    }
    
    // Get recent notifications for user
    public function getRecentNotifications($user_id, $limit = 10) {
        try {
            $stmt = $this->pdo->prepare("
                SELECT * FROM user_notifications 
                WHERE user_id = ? AND expires_at > NOW() AND is_dismissed = FALSE
                ORDER BY 
                    CASE priority 
                        WHEN 'urgent' THEN 4
                        WHEN 'high' THEN 3 
                        WHEN 'medium' THEN 2 
                        ELSE 1 
                    END DESC,
                    created_at DESC
                LIMIT ?
            ");
            $stmt->execute([$user_id, $limit]);
            return $stmt->fetchAll();
        } catch (PDOException $e) {
            error_log("Error getting recent notifications: " . $e->getMessage());
            return [];
        }
    }
}
?>