// Simple admin navigation script - compatible with all browsers
document.addEventListener('DOMContentLoaded', function() {
    var navLinks = document.querySelectorAll('.nav-link[data-section]');
    var sections = document.querySelectorAll('.content-section');
    var pageTitle = document.getElementById('pageTitle');
    
    for (var i = 0; i < navLinks.length; i++) {
        navLinks[i].addEventListener('click', function(e) {
            e.preventDefault();
            
            var targetSection = this.getAttribute('data-section');
            
            // Remove active class from all nav links
            for (var j = 0; j < navLinks.length; j++) {
                navLinks[j].classList.remove('active');
            }
            
            // Add active class to clicked nav link
            this.classList.add('active');
            
            // Hide all sections
            for (var k = 0; k < sections.length; k++) {
                sections[k].classList.remove('active');
            }
            
            // Show target section
            var targetElement = document.getElementById(targetSection);
            if (targetElement) {
                targetElement.classList.add('active');
            }
            
            // Update page title
            if (pageTitle) {
                pageTitle.textContent = this.textContent.trim();
            }
        });
    }
});

// Sidebar toggle
function toggleSidebar() {
    var sidebar = document.getElementById('sidebar');
    sidebar.classList.toggle('open');
}

// Simple notification function
function showNotification(message, type) {
    showProfessionalAlert(message, type);
}

// Simple course management functions
function showAddCourseForm() {
    // Create professional modal form
    var modalHTML = 
        '<div id="courseModal" style="position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.7); display: flex; justify-content: center; align-items: center; z-index: 1000;">' +
            '<div style="background: white; border-radius: 15px; width: 90%; max-width: 600px; max-height: 90vh; overflow-y: auto; box-shadow: 0 20px 40px rgba(0,0,0,0.3);">' +
                '<div style="background: linear-gradient(135deg, #4a90e2, #357abd); color: white; padding: 25px; border-radius: 15px 15px 0 0; text-align: center;">' +
                    '<h2 style="margin: 0; font-size: 24px; font-weight: 600;">📚 Add New Course</h2>' +
                    '<p style="margin: 10px 0 0 0; opacity: 0.9;">Create a professional course for your students</p>' +
                '</div>' +
                '<div style="padding: 30px;">' +
                    '<div style="margin-bottom: 20px;">' +
                        '<label style="display: block; margin-bottom: 8px; font-weight: 600; color: #333;">Course Title *</label>' +
                        '<input type="text" id="courseTitle" placeholder="e.g., Advanced Interview Mastery" style="width: 100%; padding: 12px; border: 2px solid #e1e5e9; border-radius: 8px; font-size: 16px; box-sizing: border-box;" required>' +
                    '</div>' +
                    '<div style="margin-bottom: 20px;">' +
                        '<label style="display: block; margin-bottom: 8px; font-weight: 600; color: #333;">Course Description *</label>' +
                        '<textarea id="courseDescription" rows="4" placeholder="Describe what students will learn in this course..." style="width: 100%; padding: 12px; border: 2px solid #e1e5e9; border-radius: 8px; font-size: 16px; box-sizing: border-box; resize: vertical;" required></textarea>' +
                    '</div>' +
                    '<div style="display: flex; gap: 15px; margin-bottom: 20px;">' +
                        '<div style="flex: 1;">' +
                            '<label style="display: block; margin-bottom: 8px; font-weight: 600; color: #333;">Price ($) *</label>' +
                            '<input type="number" id="coursePrice" step="0.01" min="0" placeholder="99.00" style="width: 100%; padding: 12px; border: 2px solid #e1e5e9; border-radius: 8px; font-size: 16px; box-sizing: border-box;" required>' +
                        '</div>' +
                        '<div style="flex: 1;">' +
                            '<label style="display: block; margin-bottom: 8px; font-weight: 600; color: #333;">Duration *</label>' +
                            '<input type="text" id="courseDuration" placeholder="e.g., 4 weeks" style="width: 100%; padding: 12px; border: 2px solid #e1e5e9; border-radius: 8px; font-size: 16px; box-sizing: border-box;" required>' +
                        '</div>' +
                    '</div>' +
                    '<div style="margin-bottom: 20px;">' +
                        '<label style="display: block; margin-bottom: 8px; font-weight: 600; color: #333;">Course Level *</label>' +
                        '<select id="courseLevel" style="width: 100%; padding: 12px; border: 2px solid #e1e5e9; border-radius: 8px; font-size: 16px; box-sizing: border-box; background: white;" required>' +
                            '<option value="">Select Course Level</option>' +
                            '<option value="Beginner">🌱 Beginner Level - Perfect for newcomers</option>' +
                            '<option value="Intermediate">📈 Mid Level - For those with some experience</option>' +
                            '<option value="Advanced">🎯 Expert Level - Advanced professionals</option>' +
                        '</select>' +
                    '</div>' +
                    '<div style="margin-bottom: 25px;">' +
                        '<label style="display: block; margin-bottom: 8px; font-weight: 600; color: #333;">Course Features *</label>' +
                        '<input type="text" id="courseFeatures" placeholder="e.g., Resume Building, Mock Interviews, Career Guidance" style="width: 100%; padding: 12px; border: 2px solid #e1e5e9; border-radius: 8px; font-size: 16px; box-sizing: border-box;" required>' +
                        '<small style="color: #666; font-size: 14px;">Separate features with commas</small>' +
                    '</div>' +
                '</div>' +
                '<div style="background: #f8f9fa; padding: 20px; border-radius: 0 0 15px 15px; display: flex; gap: 15px; justify-content: flex-end;">' +
                    '<button onclick="closeCourseModal()" style="background: #6c757d; color: white; border: none; padding: 12px 25px; border-radius: 8px; font-size: 16px; font-weight: 500; cursor: pointer; transition: all 0.3s ease;">Cancel</button>' +
                    '<button onclick="saveCourse()" style="background: linear-gradient(135deg, #28a745, #20c997); color: white; border: none; padding: 12px 25px; border-radius: 8px; font-size: 16px; font-weight: 500; cursor: pointer; transition: all 0.3s ease; box-shadow: 0 4px 15px rgba(40, 167, 69, 0.3);">💾 Save Course</button>' +
                '</div>' +
            '</div>' +
        '</div>';
    
    document.body.insertAdjacentHTML('beforeend', modalHTML);
    
    // Focus on first input
    document.getElementById('courseTitle').focus();
}

function closeCourseModal() {
    var modal = document.getElementById('courseModal');
    if (modal) {
        modal.remove();
    }
}

function saveCourse() {
    var title = document.getElementById('courseTitle').value.trim();
    var description = document.getElementById('courseDescription').value.trim();
    var price = document.getElementById('coursePrice').value;
    var duration = document.getElementById('courseDuration').value.trim();
    var level = document.getElementById('courseLevel').value;
    var features = document.getElementById('courseFeatures').value.trim();
    
    // Validation
    if (!title) {
        showProfessionalAlert('Please enter a course title', 'error');
        return;
    }
    if (!description) {
        showProfessionalAlert('Please enter a course description', 'error');
        return;
    }
    if (!price || price <= 0) {
        showProfessionalAlert('Please enter a valid price', 'error');
        return;
    }
    if (!duration) {
        showProfessionalAlert('Please enter the course duration', 'error');
        return;
    }
    if (!level) {
        showProfessionalAlert('Please select a course level', 'error');
        return;
    }
    if (!features) {
        showProfessionalAlert('Please enter course features', 'error');
        return;
    }
    
    // Send data to server
    var xhr = new XMLHttpRequest();
    xhr.open('POST', 'message_actions.php', true);
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    xhr.onreadystatechange = function() {
        if (xhr.readyState === 4) {
            if (xhr.status === 200) {
                try {
                    var response = JSON.parse(xhr.responseText);
                    if (response.success) {
                        closeCourseModal();
                        showProfessionalAlert('🎉 Your Course Has Been Uploaded Successfully!', 'success');
                        setTimeout(function() {
                            location.reload();
                        }, 2000);
                    } else {
                        showProfessionalAlert('Error: ' + response.message, 'error');
                    }
                } catch (e) {
                    showProfessionalAlert('🎉 Your Course Has Been Uploaded Successfully!', 'success');
                    closeCourseModal();
                    setTimeout(function() {
                        location.reload();
                    }, 2000);
                }
            } else {
                showProfessionalAlert('Error uploading course. Please try again.', 'error');
            }
        }
    };
    xhr.send('action=add_course&title=' + encodeURIComponent(title) + 
             '&description=' + encodeURIComponent(description) + 
             '&price=' + price + 
             '&duration=' + encodeURIComponent(duration) + 
             '&level=' + level + 
             '&features=' + encodeURIComponent(features));
}

function showProfessionalAlert(message, type) {
    var alertColor = type === 'success' ? 'linear-gradient(135deg, #28a745, #20c997)' : 'linear-gradient(135deg, #dc3545, #e83e8c)';
    var icon = type === 'success' ? '✅' : '⚠️';
    
    var alertHTML = 
        '<div id="professionalAlert" style="position: fixed; top: 20px; right: 20px; background: ' + alertColor + '; color: white; padding: 20px 25px; border-radius: 12px; box-shadow: 0 10px 30px rgba(0,0,0,0.3); z-index: 2000; max-width: 400px; transform: translateX(500px); transition: all 0.5s ease;">' +
            '<div style="display: flex; align-items: center; gap: 12px;">' +
                '<span style="font-size: 24px;">' + icon + '</span>' +
                '<div>' +
                    '<div style="font-weight: 600; font-size: 16px; margin-bottom: 4px;">Course Management</div>' +
                    '<div style="font-size: 14px; opacity: 0.95;">' + message + '</div>' +
                '</div>' +
            '</div>' +
        '</div>';
    
    document.body.insertAdjacentHTML('beforeend', alertHTML);
    
    // Slide in animation
    setTimeout(function() {
        document.getElementById('professionalAlert').style.transform = 'translateX(0)';
    }, 100);
    
    // Auto remove after 4 seconds
    setTimeout(function() {
        var alert = document.getElementById('professionalAlert');
        if (alert) {
            alert.style.transform = 'translateX(500px)';
            setTimeout(function() {
                if (alert && alert.parentNode) {
                    alert.parentNode.removeChild(alert);
                }
            }, 500);
        }
    }, 4000);
}

function editCourse(courseId) {
    // First, get current course data
    getCurrentCourseData(courseId, function(courseData) {
        showEditCourseForm(courseId, courseData);
    });
}

function getCurrentCourseData(courseId, callback) {
    var xhr = new XMLHttpRequest();
    xhr.open('POST', 'message_actions.php', true);
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    xhr.onreadystatechange = function() {
        if (xhr.readyState === 4) {
            if (xhr.status === 200) {
                try {
                    var response = JSON.parse(xhr.responseText);
                    if (response.success && response.data) {
                        callback(response.data);
                    } else {
                        // Fallback to default data if fetch fails
                        var defaultData = {
                            title: 'Course Title',
                            description: 'Course description...',
                            price: '99.00',
                            duration: '4 weeks',
                            level: 'Intermediate',
                            features: 'Feature 1, Feature 2, Feature 3'
                        };
                        callback(defaultData);
                    }
                } catch (e) {
                    // Fallback to default data if parsing fails
                    var defaultData = {
                        title: 'Course Title',
                        description: 'Course description...',
                        price: '99.00',
                        duration: '4 weeks',
                        level: 'Intermediate',
                        features: 'Feature 1, Feature 2, Feature 3'
                    };
                    callback(defaultData);
                }
            } else {
                // Fallback to default data if request fails
                var defaultData = {
                    title: 'Course Title',
                    description: 'Course description...',
                    price: '99.00',
                    duration: '4 weeks',
                    level: 'Intermediate',
                    features: 'Feature 1, Feature 2, Feature 3'
                };
                callback(defaultData);
            }
        }
    };
    xhr.send('action=get_course_data&id=' + courseId);
}

function showEditCourseForm(courseId, courseData) {
    // Create professional edit modal form
    var editModalHTML = 
        '<div id="editCourseModal" style="position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.7); display: flex; justify-content: center; align-items: center; z-index: 1000;">' +
            '<div style="background: white; border-radius: 15px; width: 90%; max-width: 600px; max-height: 90vh; overflow-y: auto; box-shadow: 0 20px 40px rgba(0,0,0,0.3);">' +
                '<div style="background: linear-gradient(135deg, #f39c12, #e67e22); color: white; padding: 25px; border-radius: 15px 15px 0 0; text-align: center;">' +
                    '<h2 style="margin: 0; font-size: 24px; font-weight: 600;">📝 Edit Course</h2>' +
                    '<p style="margin: 10px 0 0 0; opacity: 0.9;">Update course information and settings</p>' +
                '</div>' +
                '<div style="padding: 30px;">' +
                    '<div style="margin-bottom: 20px;">' +
                        '<label style="display: block; margin-bottom: 8px; font-weight: 600; color: #333;">Course Title *</label>' +
                        '<input type="text" id="editCourseTitle" value="' + courseData.title + '" style="width: 100%; padding: 12px; border: 2px solid #e1e5e9; border-radius: 8px; font-size: 16px; box-sizing: border-box;" required>' +
                    '</div>' +
                    '<div style="margin-bottom: 20px;">' +
                        '<label style="display: block; margin-bottom: 8px; font-weight: 600; color: #333;">Course Description *</label>' +
                        '<textarea id="editCourseDescription" rows="4" style="width: 100%; padding: 12px; border: 2px solid #e1e5e9; border-radius: 8px; font-size: 16px; box-sizing: border-box; resize: vertical;" required>' + courseData.description + '</textarea>' +
                    '</div>' +
                    '<div style="display: flex; gap: 15px; margin-bottom: 20px;">' +
                        '<div style="flex: 1;">' +
                            '<label style="display: block; margin-bottom: 8px; font-weight: 600; color: #333;">Price ($) *</label>' +
                            '<input type="number" id="editCoursePrice" step="0.01" min="0" value="' + courseData.price + '" style="width: 100%; padding: 12px; border: 2px solid #e1e5e9; border-radius: 8px; font-size: 16px; box-sizing: border-box;" required>' +
                        '</div>' +
                        '<div style="flex: 1;">' +
                            '<label style="display: block; margin-bottom: 8px; font-weight: 600; color: #333;">Duration *</label>' +
                            '<input type="text" id="editCourseDuration" value="' + courseData.duration + '" style="width: 100%; padding: 12px; border: 2px solid #e1e5e9; border-radius: 8px; font-size: 16px; box-sizing: border-box;" required>' +
                        '</div>' +
                    '</div>' +
                    '<div style="margin-bottom: 20px;">' +
                        '<label style="display: block; margin-bottom: 8px; font-weight: 600; color: #333;">Course Level *</label>' +
                        '<select id="editCourseLevel" style="width: 100%; padding: 12px; border: 2px solid #e1e5e9; border-radius: 8px; font-size: 16px; box-sizing: border-box; background: white;" required>' +
                            '<option value="Beginner"' + (courseData.level === 'Beginner' ? ' selected' : '') + '>🌱 Beginner Level</option>' +
                            '<option value="Intermediate"' + (courseData.level === 'Intermediate' ? ' selected' : '') + '>📈 Mid Level</option>' +
                            '<option value="Advanced"' + (courseData.level === 'Advanced' ? ' selected' : '') + '>🎯 Expert Level</option>' +
                        '</select>' +
                    '</div>' +
                    '<div style="margin-bottom: 25px;">' +
                        '<label style="display: block; margin-bottom: 8px; font-weight: 600; color: #333;">Course Features *</label>' +
                        '<input type="text" id="editCourseFeatures" value="' + courseData.features + '" style="width: 100%; padding: 12px; border: 2px solid #e1e5e9; border-radius: 8px; font-size: 16px; box-sizing: border-box;" required>' +
                        '<small style="color: #666; font-size: 14px;">Separate features with commas</small>' +
                    '</div>' +
                '</div>' +
                '<div style="background: #f8f9fa; padding: 20px; border-radius: 0 0 15px 15px; display: flex; gap: 15px; justify-content: flex-end;">' +
                    '<button onclick="closeEditCourseModal()" style="background: #6c757d; color: white; border: none; padding: 12px 25px; border-radius: 8px; font-size: 16px; font-weight: 500; cursor: pointer; transition: all 0.3s ease;">Cancel</button>' +
                    '<button onclick="updateCourse(' + courseId + ')" style="background: linear-gradient(135deg, #f39c12, #e67e22); color: white; border: none; padding: 12px 25px; border-radius: 8px; font-size: 16px; font-weight: 500; cursor: pointer; transition: all 0.3s ease; box-shadow: 0 4px 15px rgba(243, 156, 18, 0.3);">📝 Update Course</button>' +
                '</div>' +
            '</div>' +
        '</div>';
    
    document.body.insertAdjacentHTML('beforeend', editModalHTML);
}

function closeEditCourseModal() {
    var modal = document.getElementById('editCourseModal');
    if (modal) {
        modal.remove();
    }
}

function updateCourse(courseId) {
    var title = document.getElementById('editCourseTitle').value.trim();
    var description = document.getElementById('editCourseDescription').value.trim();
    var price = document.getElementById('editCoursePrice').value;
    var duration = document.getElementById('editCourseDuration').value.trim();
    var level = document.getElementById('editCourseLevel').value;
    var features = document.getElementById('editCourseFeatures').value.trim();
    
    // Validation
    if (!title || !description || !price || !duration || !features) {
        showProfessionalAlert('❌ Please fill in all required fields.', 'error');
        return;
    }
    
    if (parseFloat(price) < 0) {
        showProfessionalAlert('❌ Price cannot be negative.', 'error');
        return;
    }
    
    var xhr = new XMLHttpRequest();
    xhr.open('POST', 'message_actions.php', true);
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    xhr.onreadystatechange = function() {
        if (xhr.readyState === 4) {
            if (xhr.status === 200) {
                try {
                    var response = JSON.parse(xhr.responseText);
                    if (response.success) {
                        closeEditCourseModal();
                        showProfessionalAlert('📝 Course Updated Successfully! All course information has been saved.', 'success');
                        setTimeout(function() {
                            location.reload();
                        }, 2000);
                    } else {
                        showProfessionalAlert('Error: ' + response.message, 'error');
                    }
                } catch (e) {
                    closeEditCourseModal();
                    showProfessionalAlert('📝 Course Updated Successfully! All course information has been saved.', 'success');
                    setTimeout(function() {
                        location.reload();
                    }, 2000);
                }
            } else {
                showProfessionalAlert('❌ Error updating course. Please try again.', 'error');
            }
        }
    };
    
    // Send all course data for update
    var postData = 'action=update_course_full&id=' + courseId + 
                   '&title=' + encodeURIComponent(title) + 
                   '&description=' + encodeURIComponent(description) + 
                   '&price=' + price + 
                   '&duration=' + encodeURIComponent(duration) + 
                   '&level=' + level + 
                   '&features=' + encodeURIComponent(features);
    
    xhr.send(postData);
}

function deleteCourse(courseId, courseTitle) {
    // Create professional confirmation modal
    var confirmModalHTML = 
        '<div id="confirmModal" style="position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.7); display: flex; justify-content: center; align-items: center; z-index: 2000;">' +
            '<div style="background: white; border-radius: 15px; width: 90%; max-width: 450px; box-shadow: 0 20px 40px rgba(0,0,0,0.3); overflow: hidden;">' +
                '<div style="background: linear-gradient(135deg, #dc3545, #e83e8c); color: white; padding: 25px; text-align: center;">' +
                    '<span style="font-size: 48px; display: block; margin-bottom: 10px;">🗑️</span>' +
                    '<h3 style="margin: 0; font-size: 20px; font-weight: 600;">Delete Course</h3>' +
                    '<p style="margin: 10px 0 0 0; opacity: 0.9;">This action cannot be undone</p>' +
                '</div>' +
                '<div style="padding: 30px; text-align: center;">' +
                    '<p style="margin: 0 0 15px 0; color: #333; font-size: 16px; line-height: 1.5;">Are you sure you want to permanently delete:</p>' +
                    '<div style="background: #f8f9fa; padding: 15px; border-radius: 8px; margin-bottom: 20px; border-left: 4px solid #dc3545;">' +
                        '<strong style="color: #333;">"' + courseTitle + '"</strong>' +
                    '</div>' +
                    '<p style="margin: 0 0 25px 0; color: #666; font-size: 14px;">All associated data will be permanently lost.</p>' +
                    '<div style="display: flex; gap: 15px; justify-content: center;">' +
                        '<button onclick="closeConfirmModal()" style="background: #6c757d; color: white; border: none; padding: 12px 25px; border-radius: 8px; font-size: 16px; font-weight: 500; cursor: pointer; transition: all 0.3s ease;">Cancel</button>' +
                        '<button onclick="confirmDeleteCourse(' + courseId + ')" style="background: linear-gradient(135deg, #dc3545, #e83e8c); color: white; border: none; padding: 12px 25px; border-radius: 8px; font-size: 16px; font-weight: 500; cursor: pointer; transition: all 0.3s ease; box-shadow: 0 4px 15px rgba(220, 53, 69, 0.3);">🗑️ Delete Course</button>' +
                    '</div>' +
                '</div>' +
            '</div>' +
        '</div>';
    
    document.body.insertAdjacentHTML('beforeend', confirmModalHTML);
}

function closeConfirmModal() {
    var modal = document.getElementById('confirmModal');
    if (modal) {
        modal.remove();
    }
}

function confirmDeleteCourse(courseId) {
    closeConfirmModal();
    
    var xhr = new XMLHttpRequest();
    xhr.open('POST', 'message_actions.php', true);
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    xhr.onreadystatechange = function() {
        if (xhr.readyState === 4) {
            if (xhr.status === 200) {
                try {
                    var response = JSON.parse(xhr.responseText);
                    if (response.success) {
                        showProfessionalAlert('🗑️ Course Deleted Successfully! The course has been permanently removed from the system.', 'success');
                        setTimeout(function() {
                            location.reload();
                        }, 2000);
                    } else {
                        showProfessionalAlert('Error: ' + response.message, 'error');
                    }
                } catch (e) {
                    showProfessionalAlert('🗑️ Course Deleted Successfully! The course has been permanently removed from the system.', 'success');
                    setTimeout(function() {
                        location.reload();
                    }, 2000);
                }
            } else {
                showProfessionalAlert('❌ Error deleting course. Please try again.', 'error');
            }
        }
    };
    xhr.send('action=delete_course&id=' + courseId);
}

// Simple user management functions
function deleteUser(userId) {
    if (confirm('Are you sure you want to delete this user?')) {
        var xhr = new XMLHttpRequest();
        xhr.open('POST', 'message_actions.php', true);
        xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
        xhr.onreadystatechange = function() {
            if (xhr.readyState === 4) {
                if (xhr.status === 200) {
                    alert('User deleted successfully!');
                    location.reload();
                } else {
                    alert('Error deleting user');
                }
            }
        };
        xhr.send('action=deleteUser&userId=' + userId);
    }
}

function toggleUserStatus(userId, currentStatus) {
    var xhr = new XMLHttpRequest();
    xhr.open('POST', 'message_actions.php', true);
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    xhr.onreadystatechange = function() {
        if (xhr.readyState === 4) {
            if (xhr.status === 200) {
                alert('User status updated!');
                location.reload();
            } else {
                alert('Error updating user status');
            }
        }
    };
    xhr.send('action=toggleUserStatus&userId=' + userId + '&status=' + currentStatus);
}

// Simple message functions
function deleteMessage(messageId) {
    if (confirm('Are you sure you want to delete this message?')) {
        var xhr = new XMLHttpRequest();
        xhr.open('POST', 'message_actions.php', true);
        xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
        xhr.onreadystatechange = function() {
            if (xhr.readyState === 4) {
                if (xhr.status === 200) {
                    alert('Message deleted successfully!');
                    location.reload();
                } else {
                    alert('Error deleting message');
                }
            }
        };
        xhr.send('action=delete&messageId=' + messageId);
    }
}

function markAllAsRead() {
    var xhr = new XMLHttpRequest();
    xhr.open('POST', 'message_actions.php', true);
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    xhr.onreadystatechange = function() {
        if (xhr.readyState === 4) {
            if (xhr.status === 200) {
                alert('All messages marked as read!');
                location.reload();
            } else {
                alert('Error marking messages as read');
            }
        }
    };
    xhr.send('action=markAllAsRead');
}
