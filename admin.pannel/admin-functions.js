/**
 * Admin Panel JavaScript Functions
 * 
 * This file contains all JavaScript functionality for the admin dashboard.
 * It handles navigation, user interactions, AJAX requests, and notifications.
 * 
 * @author BeThePro Development Team
 * @version 2.0
 * @since 2025-09-25
 */

// ==========================================
// NAVIGATION AND UI FUNCTIONS
// ==========================================

/**
 * Initialize the admin dashboard when page loads
 */
document.addEventListener('DOMContentLoaded', function() {
    initializeNavigation();
    initializeSidebar();
    initializeNotifications();
    
    console.log('Admin Dashboard initialized successfully');
});

/**
 * Set up navigation between different sections
 */
function initializeNavigation() {
    const navLinks = document.querySelectorAll('.nav-link[data-section]');
    const sections = document.querySelectorAll('.content-section');
    const pageTitle = document.getElementById('pageTitle');
    
    navLinks.forEach(link => {
        link.addEventListener('click', function(e) {
            e.preventDefault();
            
            const targetSection = this.getAttribute('data-section');
            
            // Update active navigation
            navLinks.forEach(nav => nav.classList.remove('active'));
            this.classList.add('active');
            
            // Show target section
            sections.forEach(section => section.classList.remove('active'));
            const targetElement = document.getElementById(targetSection);
            if (targetElement) {
                targetElement.classList.add('active');
            }
            
            // Update page title
            if (pageTitle) {
                pageTitle.textContent = this.textContent.trim();
            }
        });
    });
}

/**
 * Handle sidebar toggle for mobile devices
 */
function initializeSidebar() {
    // Close sidebar when clicking outside on mobile
    document.addEventListener('click', function(e) {
        const sidebar = document.getElementById('sidebar');
        const sidebarToggle = document.querySelector('.sidebar-toggle');
        
        if (window.innerWidth <= 768 && 
            !sidebar.contains(e.target) && 
            !sidebarToggle.contains(e.target)) {
            sidebar.classList.remove('open');
        }
    });
}

/**
 * Toggle sidebar visibility (mobile)
 */
function toggleSidebar() {
    const sidebar = document.getElementById('sidebar');
    sidebar.classList.toggle('open');
}

// ==========================================
// NOTIFICATION FUNCTIONS
// ==========================================

/**
 * Initialize notification system
 */
function initializeNotifications() {
    const notificationBtn = document.querySelector('.notification-btn');
    if (notificationBtn) {
        notificationBtn.addEventListener('click', function() {
            showSampleNotification();
        });
    }
}

/**
 * Show a sample notification (for demo purposes)
 */
function showSampleNotification() {
    alert('You have 3 new notifications:\n1. New user registration\n2. Course completion\n3. New message received');
}

/**
 * Display notification toast message
 * @param {string} message - The message to display
 * @param {string} type - Type of notification ('success', 'error', 'info')
 */
function showNotification(message, type = 'info') {
    const notification = document.createElement('div');
    notification.className = `notification notification-${type}`;
    notification.textContent = message;
    
    // Style the notification
    notification.style.cssText = `
        position: fixed;
        top: 20px;
        right: 20px;
        padding: 15px 20px;
        border-radius: 8px;
        color: white;
        font-weight: 500;
        z-index: 2000;
        opacity: 0;
        transition: opacity 0.3s ease;
        max-width: 350px;
        box-shadow: 0 4px 12px rgba(0,0,0,0.15);
        ${getNotificationColor(type)}
    `;
    
    document.body.appendChild(notification);
    
    // Fade in
    setTimeout(() => notification.style.opacity = '1', 100);
    
    // Remove after 4 seconds
    setTimeout(() => {
        notification.style.opacity = '0';
        setTimeout(() => notification.remove(), 300);
    }, 4000);
}

/**
 * Get notification background color based on type
 * @param {string} type - Notification type
 * @return {string} CSS background color
 */
function getNotificationColor(type) {
    switch(type) {
        case 'success': return 'background-color: #28a745;';
        case 'error': return 'background-color: #dc3545;';
        case 'warning': return 'background-color: #ffc107; color: #000;';
        case 'info': return 'background-color: #17a2b8;';
        default: return 'background-color: #6c757d;';
    }
}

// ==========================================
// ENROLLMENT MANAGEMENT
// ==========================================

/**
 * Accept an enrollment and notify the student
 * @param {string} enrollmentId - The enrollment ID
 * @param {string} studentName - The student's full name
 */
window.acceptEnrollment = function(enrollmentId, studentName) {
    console.log('Processing enrollment acceptance:', { enrollmentId, studentName });
    
    if (!confirm(`Accept enrollment for ${studentName}?\n\nThis will:\n- Update status to 'Accepted'\n- Notify the student\n- Mark admin notification as read`)) {
        return;
    }
    
    // Get the button that was clicked
    const button = event.target;
    const originalText = button.innerHTML;
    
    // Show loading state
    button.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Processing...';
    button.disabled = true;
    button.style.opacity = '0.7';
    
    // Send AJAX request
    fetch('message_actions.php', {
        method: 'POST',
        headers: { 
            'Content-Type': 'application/x-www-form-urlencoded' 
        },
        body: `action=accept_enrollment&enrollment_id=${encodeURIComponent(enrollmentId)}`
    })
    .then(response => {
        console.log('Response status:', response.status);
        if (!response.ok) {
            throw new Error(`HTTP ${response.status}: ${response.statusText}`);
        }
        return response.text();
    })
    .then(text => {
        console.log('Server response:', text);
        
        let data;
        try {
            data = JSON.parse(text);
        } catch (parseError) {
            console.error('JSON parse error:', parseError);
            throw new Error('Invalid server response: ' + text.substring(0, 100));
        }
        
        if (data.success) {
            // Show success notification
            showNotification(`✅ Enrollment for ${studentName} has been accepted successfully!`, 'success');
            
            // Update button to success state
            button.innerHTML = '<i class="fas fa-check-circle"></i> Accepted';
            button.style.background = '#28a745';
            button.style.borderColor = '#28a745';
            button.style.opacity = '1';
            button.disabled = true;
            
            // Refresh page after delay to show updated data
            setTimeout(() => {
                showNotification('Refreshing dashboard...', 'info');
                location.reload();
            }, 2000);
            
        } else {
            throw new Error(data.message || 'Unknown error occurred');
        }
    })
    .catch(error => {
        console.error('Enrollment acceptance error:', error);
        showNotification(`❌ Error: ${error.message}`, 'error');
        
        // Restore button to original state
        button.innerHTML = originalText;
        button.disabled = false;
        button.style.opacity = '1';
    });
};

/**
 * Reject an enrollment
 * @param {string} enrollmentId - The enrollment ID
 * @param {string} studentName - Student's full name
 */
window.rejectEnrollment = function(enrollmentId, studentName) {
    console.log('Processing enrollment rejection:', { enrollmentId, studentName });
    
    if (!confirm(`Reject enrollment for ${studentName}?\n\nThis will:\n- Update status to 'Rejected'\n- Notify the student\n- Mark admin notification as read\n\nThis action cannot be easily undone.`)) {
        return;
    }
    
    // Get the button that was clicked
    const button = event.target;
    const originalText = button.innerHTML;
    
    // Show loading state
    button.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Processing...';
    button.disabled = true;
    button.style.opacity = '0.7';
    
    // Send AJAX request
    fetch('message_actions.php', {
        method: 'POST',
        headers: { 
            'Content-Type': 'application/x-www-form-urlencoded' 
        },
        body: `action=reject_enrollment&enrollment_id=${encodeURIComponent(enrollmentId)}`
    })
    .then(response => {
        console.log('Response status:', response.status);
        if (!response.ok) {
            throw new Error(`HTTP ${response.status}: ${response.statusText}`);
        }
        return response.text();
    })
    .then(text => {
        console.log('Server response:', text);
        
        let data;
        try {
            data = JSON.parse(text);
        } catch (parseError) {
            console.error('JSON parse error:', parseError);
            throw new Error('Invalid server response: ' + text.substring(0, 100));
        }
        
        if (data.success) {
            // Show success notification
            showNotification(`❌ Enrollment for ${studentName} has been rejected.`, 'warning');
            
            // Update button to rejected state
            button.innerHTML = '<i class="fas fa-times-circle"></i> Rejected';
            button.style.background = '#dc3545';
            button.style.borderColor = '#dc3545';
            button.style.opacity = '1';
            button.disabled = true;
            
            // Refresh page after delay to show updated data
            setTimeout(() => {
                showNotification('Refreshing dashboard...', 'info');
                location.reload();
            }, 2000);
            
        } else {
            throw new Error(data.message || 'Unknown error occurred');
        }
    })
    .catch(error => {
        console.error('Enrollment rejection error:', error);
        showNotification(`❌ Error: ${error.message}`, 'error');
        
        // Restore button to original state
        button.innerHTML = originalText;
        button.disabled = false;
        button.style.opacity = '1';
    });
};

/**
 * Show detailed enrollment information in a modal
 * @param {Object} enrollment - Enrollment data object
 */
function showEnrollmentDetails(enrollment) {
    // Implementation for enrollment details modal
    console.log('Showing enrollment details for:', enrollment);
    // This function would open a modal with detailed enrollment information
    alert(`Enrollment Details:\n\nName: ${enrollment.firstName} ${enrollment.lastName}\nEmail: ${enrollment.email}\nPhone: ${enrollment.phone}\nCountry: ${enrollment.country}\nExperience: ${enrollment.experience}\nDate: ${enrollment.date}\nStatus: ${enrollment.status}`);
}

// ==========================================
// NOTIFICATION MANAGEMENT  
// ==========================================

/**
 * Mark a single notification as read
 * @param {number} notificationId - The notification ID
 */
function markNotificationRead(notificationId) {
    fetch('message_actions.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
        body: `action=mark_notification_read&notification_id=${notificationId}`
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            // Update UI
            const notificationElement = document.querySelector(`[data-notification-id="${notificationId}"]`);
            if (notificationElement) {
                notificationElement.classList.remove('unread');
                notificationElement.classList.add('read');
                const badge = notificationElement.querySelector('.notification-badge');
                if (badge) badge.remove();
            }
            updateNotificationBadge();
            showNotification('Notification marked as read', 'success');
        } else {
            showNotification('Error marking notification as read', 'error');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        showNotification('Error marking notification as read', 'error');
    });
}

/**
 * Mark all notifications as read
 */
function markAllNotificationsRead() {
    if (!confirm('Mark all notifications as read?')) return;
    
    fetch('message_actions.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
        body: 'action=mark_all_notifications_read'
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            showNotification('All notifications marked as read', 'success');
            setTimeout(() => location.reload(), 1500);
        } else {
            showNotification('Error marking notifications as read', 'error');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        showNotification('Error marking notifications as read', 'error');
    });
}

/**
 * View specific enrollment from notification
 * @param {string} enrollmentId - The enrollment ID to view
 */
function viewEnrollment(enrollmentId) {
    // Switch to enrollments section
    showSection('enrollments');
    
    // Highlight the specific enrollment row
    setTimeout(() => {
        const enrollmentRow = document.querySelector(`tr[data-enrollment-id="${enrollmentId}"]`);
        if (enrollmentRow) {
            enrollmentRow.style.background = '#fff3cd';
            enrollmentRow.style.transition = 'background-color 0.3s ease';
            enrollmentRow.scrollIntoView({ behavior: 'smooth', block: 'center' });
            
            // Remove highlight after 3 seconds
            setTimeout(() => {
                enrollmentRow.style.background = '';
            }, 3000);
        }
    }, 100);
}

/**
 * Show a specific section and update navigation
 * @param {string} sectionName - Name of section to show
 */
function showSection(sectionName) {
    // Hide all sections
    const sections = document.querySelectorAll('.content-section');
    sections.forEach(section => section.classList.remove('active'));
    
    // Show target section
    const targetSection = document.getElementById(sectionName);
    if (targetSection) {
        targetSection.classList.add('active');
    }
    
    // Update navigation
    const navLinks = document.querySelectorAll('.nav-link');
    navLinks.forEach(link => link.classList.remove('active'));
    
    const targetNavLink = document.querySelector(`[data-section="${sectionName}"]`);
    if (targetNavLink) {
        targetNavLink.classList.add('active');
    }
    
    // Update page title
    const pageTitle = document.getElementById('pageTitle');
    if (pageTitle && targetNavLink) {
        pageTitle.textContent = targetNavLink.textContent.trim();
    }
}

/**
 * Update notification badge count in sidebar
 */
function updateNotificationBadge() {
    const unreadCount = document.querySelectorAll('.notification-item.unread').length;
    const badge = document.querySelector('.nav-link[data-section="notifications"] .notification-badge');
    
    if (badge) {
        if (unreadCount > 0) {
            badge.textContent = unreadCount;
        } else {
            badge.remove();
        }
    }
}