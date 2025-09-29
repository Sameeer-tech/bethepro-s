<?php
/**
 * Enrollments Management Section
 * 
 * Handles display and management of student enrollments.
 * Allows administrators to view, accept, and process enrollment requests.
 * 
 * @author BeThePro Development Team
 * @version 2.0
 */

// Ensure this file is only included
if (!defined('ADMIN_PANEL_ACCESS')) {
    exit('Direct access not allowed');
}
?>

<!-- Enrollments Management Section -->
<section id="enrollments" class="content-section">
    
    <!-- Section Header -->
    <div class="section-header">
        <div class="section-title">
            <h2><i class="fas fa-user-graduate"></i> Enrollment Management</h2>
            <p>Review and process student enrollment requests</p>
        </div>
        <div class="section-actions">
            <button class="btn btn-secondary" onclick="exportEnrollments()">
                <i class="fas fa-download"></i>
                Export Report
            </button>
            <button class="btn btn-primary" onclick="refreshEnrollments()">
                <i class="fas fa-sync-alt"></i>
                Refresh
            </button>
        </div>
    </div>

    <!-- Enrollment Statistics -->
    <div class="enrollment-stats">
        <?php
        $total_enrollments = count($enrollments);
        $pending_enrollments = count(array_filter($enrollments, function($e) { return $e['status'] === 'pending'; }));
        $confirmed_enrollments = count(array_filter($enrollments, function($e) { return $e['status'] === 'confirmed'; }));
        $rejected_enrollments = count(array_filter($enrollments, function($e) { return $e['status'] === 'rejected'; }));
        ?>
        
        <div class="stat-mini">
            <div class="stat-value"><?php echo $total_enrollments; ?></div>
            <div class="stat-label">Total</div>
        </div>
        
        <div class="stat-mini pending">
            <div class="stat-value"><?php echo $pending_enrollments; ?></div>
            <div class="stat-label">Pending</div>
        </div>
        
        <div class="stat-mini confirmed">
            <div class="stat-value"><?php echo $confirmed_enrollments; ?></div>
            <div class="stat-label">Confirmed</div>
        </div>
        
        <div class="stat-mini rejected">
            <div class="stat-value"><?php echo $rejected_enrollments; ?></div>
            <div class="stat-label">Rejected</div>
        </div>
    </div>

    <!-- Enrollments Table -->
    <div class="table-container">
        <table class="data-table">
            <thead>
                <tr>
                    <th>
                        <i class="fas fa-id-card"></i>
                        Enrollment ID
                    </th>
                    <th>
                        <i class="fas fa-user"></i>
                        Student Name
                    </th>
                    <th>
                        <i class="fas fa-envelope"></i>
                        Email
                    </th>
                    <th>
                        <i class="fas fa-phone"></i>
                        Phone
                    </th>
                    <th>
                        <i class="fas fa-globe"></i>
                        Country
                    </th>
                    <th>
                        <i class="fas fa-chart-line"></i>
                        Experience
                    </th>
                    <th>
                        <i class="fas fa-calendar"></i>
                        Date
                    </th>
                    <th>
                        <i class="fas fa-flag"></i>
                        Status
                    </th>
                    <th>
                        <i class="fas fa-cogs"></i>
                        Actions
                    </th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($enrollments)): ?>
                    <tr>
                        <td colspan="9" class="empty-table">
                            <div class="empty-state">
                                <i class="fas fa-user-graduate"></i>
                                <h3>No enrollments yet</h3>
                                <p>Student enrollment requests will appear here</p>
                            </div>
                        </td>
                    </tr>
                <?php else: ?>
                    <?php foreach ($enrollments as $enrollment): ?>
                        <tr data-enrollment-id="<?php echo htmlspecialchars($enrollment['enrollment_id']); ?>" 
                            class="enrollment-row <?php echo $enrollment['status']; ?>">
                            
                            <!-- Enrollment ID -->
                            <td class="enrollment-id">
                                <?php echo htmlspecialchars($enrollment['enrollment_id']); ?>
                            </td>
                            
                            <!-- Student Name -->
                            <td class="student-name">
                                <strong><?php echo htmlspecialchars($enrollment['first_name'] . ' ' . $enrollment['last_name']); ?></strong>
                            </td>
                            
                            <!-- Email -->
                            <td class="student-email">
                                <a href="mailto:<?php echo htmlspecialchars($enrollment['email']); ?>">
                                    <?php echo htmlspecialchars($enrollment['email']); ?>
                                </a>
                            </td>
                            
                            <!-- Phone -->
                            <td class="student-phone">
                                <?php echo htmlspecialchars($enrollment['phone']); ?>
                            </td>
                            
                            <!-- Country -->
                            <td class="student-country">
                                <?php echo htmlspecialchars($enrollment['country']); ?>
                            </td>
                            
                            <!-- Experience Level -->
                            <td class="experience-level">
                                <span class="experience-badge <?php echo strtolower(str_replace(' ', '-', $enrollment['experience_level'])); ?>">
                                    <?php echo htmlspecialchars($enrollment['experience_level']); ?>
                                </span>
                            </td>
                            
                            <!-- Enrollment Date -->
                            <td class="enrollment-date">
                                <?php echo date('M j, Y', strtotime($enrollment['enrollment_date'])); ?>
                                <br>
                                <small><?php echo date('g:i A', strtotime($enrollment['enrollment_date'])); ?></small>
                            </td>
                            
                            <!-- Status -->
                            <td class="enrollment-status">
                                <span class="status-badge status-<?php echo strtolower($enrollment['status']); ?>">
                                    <?php if ($enrollment['status'] === 'pending'): ?>
                                        <i class="fas fa-clock"></i>
                                    <?php elseif ($enrollment['status'] === 'confirmed'): ?>
                                        <i class="fas fa-check-circle"></i>
                                    <?php elseif ($enrollment['status'] === 'rejected'): ?>
                                        <i class="fas fa-times-circle"></i>
                                    <?php endif; ?>
                                    <?php echo ucfirst($enrollment['status']); ?>
                                </span>
                            </td>
                            
                            <!-- Actions -->
                            <td class="enrollment-actions">
                                <div class="action-buttons">
                                    
                                    <!-- View Details Button -->
                                    <button class="btn btn-info btn-sm" 
                                            onclick="showEnrollmentDetails({
                                                id: '<?php echo htmlspecialchars($enrollment['enrollment_id']); ?>',
                                                firstName: '<?php echo htmlspecialchars($enrollment['first_name']); ?>',
                                                lastName: '<?php echo htmlspecialchars($enrollment['last_name']); ?>',
                                                email: '<?php echo htmlspecialchars($enrollment['email']); ?>',
                                                phone: '<?php echo htmlspecialchars($enrollment['phone']); ?>',
                                                country: '<?php echo htmlspecialchars($enrollment['country']); ?>',
                                                experience: '<?php echo htmlspecialchars($enrollment['experience_level']); ?>',
                                                schedule: '<?php echo htmlspecialchars($enrollment['schedule_preference'] ?? ''); ?>',
                                                goals: '<?php echo htmlspecialchars($enrollment['career_goals'] ?? ''); ?>',
                                                date: '<?php echo date('F j, Y \a\t g:i A', strtotime($enrollment['enrollment_date'])); ?>',
                                                status: '<?php echo htmlspecialchars($enrollment['status']); ?>'
                                            })"
                                            title="View Full Details">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                    
                                    <!-- Status-based Action Buttons -->
                                    <?php if ($enrollment['status'] === 'pending'): ?>
                                        
                                        <!-- Accept Button -->
                                        <button class="btn btn-success btn-sm accept-btn" 
                                                onclick="acceptEnrollment('<?php echo htmlspecialchars($enrollment['enrollment_id']); ?>', '<?php echo htmlspecialchars($enrollment['first_name'] . ' ' . $enrollment['last_name']); ?>')" 
                                                title="Accept Enrollment">
                                            <i class="fas fa-check"></i>
                                            Accept
                                        </button>
                                        
                                        <!-- Reject Button -->
                                        <button class="btn btn-danger btn-sm reject-btn"
                                                onclick="rejectEnrollment('<?php echo htmlspecialchars($enrollment['enrollment_id']); ?>', '<?php echo htmlspecialchars($enrollment['first_name'] . ' ' . $enrollment['last_name']); ?>')"
                                                title="Reject Enrollment">
                                            <i class="fas fa-times"></i>
                                            Reject
                                        </button>
                                        
                                    <?php elseif ($enrollment['status'] === 'confirmed'): ?>
                                        
                                        <!-- Already Accepted -->
                                        <span class="status-indicator accepted">
                                            <i class="fas fa-check-circle"></i>
                                            Accepted
                                        </span>
                                        
                                    <?php elseif ($enrollment['status'] === 'rejected'): ?>
                                        
                                        <!-- Reopen Option -->
                                        <button class="btn btn-warning btn-sm reopen-btn"
                                                onclick="reopenEnrollment('<?php echo htmlspecialchars($enrollment['enrollment_id']); ?>')"
                                                title="Reopen Enrollment">
                                            <i class="fas fa-redo"></i>
                                            Reopen
                                        </button>
                                        
                                    <?php endif; ?>
                                    
                                </div>
                            </td>
                            
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

</section>

<script>
/**
 * Enrollment-specific JavaScript functions
 */

// Export enrollments data
function exportEnrollments() {
    showNotification('Preparing enrollment export...', 'info');
    // Implementation for CSV/Excel export
    setTimeout(() => {
        showNotification('Export feature coming soon!', 'warning');
    }, 1000);
}

// Refresh enrollments data
function refreshEnrollments() {
    showNotification('Refreshing enrollment data...', 'info');
    setTimeout(() => {
        location.reload();
    }, 500);
}

// Reject enrollment function
function rejectEnrollment(enrollmentId, studentName) {
    const reason = prompt(`Reject enrollment for ${studentName}?\n\nPlease provide a reason (optional):`);
    if (reason !== null) {
        showNotification(`Rejection feature for ${studentName} - Coming soon!`, 'warning');
        // Implementation for rejection workflow
    }
}

// Reopen enrollment function  
function reopenEnrollment(enrollmentId) {
    if (confirm('Reopen this enrollment for review?')) {
        showNotification('Reopen feature coming soon!', 'warning');
        // Implementation for reopening enrollments
    }
}
</script>