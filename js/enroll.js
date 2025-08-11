// Enrollment Form JavaScript

document.addEventListener('DOMContentLoaded', function() {
    // Initialize form
    initializeForm();
    setupFormValidation();
    setupPaymentMethods();
    setupCardFormatting();
    setupAdditionalServices();
});

let currentStep = 1;
const totalSteps = 3;

function initializeForm() {
    const nextBtn = document.getElementById('nextBtn');
    const prevBtn = document.getElementById('prevBtn');
    const submitBtn = document.getElementById('submitBtn');
    
    // Navigation event listeners
    nextBtn.addEventListener('click', nextStep);
    prevBtn.addEventListener('click', prevStep);
    
    // Form submission
    document.getElementById('enrollmentForm').addEventListener('submit', handleFormSubmission);
    
    // Update progress
    updateProgress();
}

function nextStep() {
    if (validateCurrentStep()) {
        if (currentStep < totalSteps) {
            // Hide current step
            document.querySelector(`[data-step="${currentStep}"]`).classList.remove('active');
            
            currentStep++;
            
            // Show next step
            document.querySelector(`[data-step="${currentStep}"]`).classList.add('active');
            
            updateNavigation();
            updateProgress();
            
            // Smooth scroll to top of form
            document.querySelector('.enrollment-form').scrollIntoView({ 
                behavior: 'smooth',
                block: 'start'
            });
        }
    }
}

function prevStep() {
    if (currentStep > 1) {
        // Hide current step
        document.querySelector(`[data-step="${currentStep}"]`).classList.remove('active');
        
        currentStep--;
        
        // Show previous step
        document.querySelector(`[data-step="${currentStep}"]`).classList.add('active');
        
        updateNavigation();
        updateProgress();
        
        // Smooth scroll to top of form
        document.querySelector('.enrollment-form').scrollIntoView({ 
            behavior: 'smooth',
            block: 'start'
        });
    }
}

function updateNavigation() {
    const nextBtn = document.getElementById('nextBtn');
    const prevBtn = document.getElementById('prevBtn');
    const submitBtn = document.getElementById('submitBtn');
    
    // Previous button
    if (currentStep === 1) {
        prevBtn.style.display = 'none';
    } else {
        prevBtn.style.display = 'flex';
    }
    
    // Next/Submit button
    if (currentStep === totalSteps) {
        nextBtn.style.display = 'none';
        submitBtn.style.display = 'flex';
    } else {
        nextBtn.style.display = 'flex';
        submitBtn.style.display = 'none';
    }
}

function updateProgress() {
    const progressFill = document.querySelector('.progress-fill');
    const progressPercentage = (currentStep / totalSteps) * 100;
    progressFill.style.width = `${progressPercentage}%`;
}

function validateCurrentStep() {
    const currentStepElement = document.querySelector(`[data-step="${currentStep}"]`);
    const requiredFields = currentStepElement.querySelectorAll('input[required], select[required]');
    let isValid = true;
    
    requiredFields.forEach(field => {
        if (!field.value.trim()) {
            showFieldError(field, 'This field is required');
            isValid = false;
        } else {
            clearFieldError(field);
            
            // Additional validation based on field type
            if (field.type === 'email' && !isValidEmail(field.value)) {
                showFieldError(field, 'Please enter a valid email address');
                isValid = false;
            }
            
            if (field.type === 'tel' && !isValidPhone(field.value)) {
                showFieldError(field, 'Please enter a valid phone number');
                isValid = false;
            }
        }
    });
    
    // Special validation for step 3 (payment)
    if (currentStep === 3) {
        const termsCheckbox = document.querySelector('input[name="terms"]');
        if (!termsCheckbox.checked) {
            showNotification('Please accept the Terms of Service to continue', 'error');
            isValid = false;
        }
        
        // For class project - payment validation is relaxed
        // No strict validation required for demo purposes
    }
    
    return isValid;
}

function validateCardDetails() {
    // For class project - relaxed validation
    // Students can use dummy data for demonstration
    return true; // Always return true for demo purposes
}

function showFieldError(field, message) {
    clearFieldError(field);
    
    field.style.borderColor = '#EF4444';
    const errorDiv = document.createElement('div');
    errorDiv.className = 'field-error';
    errorDiv.textContent = message;
    errorDiv.style.color = '#EF4444';
    errorDiv.style.fontSize = '0.85rem';
    errorDiv.style.marginTop = '0.25rem';
    
    field.parentNode.appendChild(errorDiv);
}

function clearFieldError(field) {
    field.style.borderColor = '#e2e8f0';
    const existingError = field.parentNode.querySelector('.field-error');
    if (existingError) {
        existingError.remove();
    }
}

function setupFormValidation() {
    // Real-time validation
    const inputs = document.querySelectorAll('input, select');
    inputs.forEach(input => {
        input.addEventListener('blur', function() {
            if (this.hasAttribute('required') && !this.value.trim()) {
                showFieldError(this, 'This field is required');
            } else {
                clearFieldError(this);
            }
        });
        
        input.addEventListener('input', function() {
            clearFieldError(this);
        });
    });
}

function setupPaymentMethods() {
    const paymentMethods = document.querySelectorAll('input[name="paymentMethod"]');
    const cardForm = document.getElementById('cardForm');
    
    paymentMethods.forEach(method => {
        method.addEventListener('change', function() {
            // Update visual state
            document.querySelectorAll('.payment-method').forEach(pm => {
                pm.classList.remove('active');
            });
            this.closest('.payment-method').classList.add('active');
            
            // Show/hide card form
            if (this.value === 'card') {
                cardForm.style.display = 'block';
            } else {
                cardForm.style.display = 'none';
            }
        });
    });
}

function setupCardFormatting() {
    const cardNumberInput = document.getElementById('cardNumber');
    const expiryDateInput = document.getElementById('expiryDate');
    const cvvInput = document.getElementById('cvv');
    
    // Format card number
    cardNumberInput.addEventListener('input', function() {
        let value = this.value.replace(/\s/g, '').replace(/[^0-9]/gi, '');
        let matches = value.match(/\d{4,16}/g);
        let match = matches && matches[0] || '';
        let parts = [];
        
        for (let i = 0, len = match.length; i < len; i += 4) {
            parts.push(match.substring(i, i + 4));
        }
        
        if (parts.length) {
            this.value = parts.join(' ');
        } else {
            this.value = value;
        }
    });
    
    // Format expiry date
    expiryDateInput.addEventListener('input', function() {
        let value = this.value.replace(/\D/g, '');
        if (value.length >= 2) {
            this.value = value.substring(0, 2) + '/' + value.substring(2, 4);
        } else {
            this.value = value;
        }
    });
    
    // Format CVV
    cvvInput.addEventListener('input', function() {
        this.value = this.value.replace(/\D/g, '').substring(0, 4);
    });
}

function setupAdditionalServices() {
    const serviceCheckboxes = document.querySelectorAll('input[name="services[]"]');
    let additionalCost = 0;
    
    serviceCheckboxes.forEach(checkbox => {
        checkbox.addEventListener('change', function() {
            const price = parseInt(this.value.match(/\d+/)[0]);
            
            if (this.checked) {
                additionalCost += price;
            } else {
                additionalCost -= price;
            }
            
            updatePricing(additionalCost);
        });
    });
}

function updatePricing(additionalCost) {
    const basePrice = parseInt(document.getElementById('course-price').textContent.replace('$', ''));
    const discountedPrice = basePrice * 0.8; // 20% discount
    const newSubtotal = discountedPrice + additionalCost;
    const tax = newSubtotal * 0.08; // 8% tax
    const total = newSubtotal + tax;
    
    // Update additional services line if it doesn't exist
    const pricingBreakdown = document.querySelector('.pricing-breakdown');
    let additionalLine = pricingBreakdown.querySelector('.additional-services');
    
    if (additionalCost > 0) {
        if (!additionalLine) {
            additionalLine = document.createElement('div');
            additionalLine.className = 'price-item additional-services';
            additionalLine.innerHTML = `
                <span>Additional Services</span>
                <span>$${additionalCost}</span>
            `;
            pricingBreakdown.insertBefore(additionalLine, pricingBreakdown.querySelector('.price-item.tax'));
        } else {
            additionalLine.innerHTML = `
                <span>Additional Services</span>
                <span>$${additionalCost}</span>
            `;
        }
    } else if (additionalLine) {
        additionalLine.remove();
    }
    
    // Update tax and total
    document.getElementById('tax-amount').textContent = `$${Math.round(tax)}`;
    document.getElementById('total-amount').textContent = `$${Math.round(total)}`;
}

function handleFormSubmission(e) {
    // Only prevent submission if validation fails
    if (!validateCurrentStep()) {
        e.preventDefault();
        return;
    }
    
    // Show loading state but let form submit normally
    const submitBtn = document.getElementById('submitBtn');
    submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Processing...';
    submitBtn.disabled = true;
    
    // Form will submit normally to process_enrollment.php
}

// Utility functions
function isValidEmail(email) {
    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    return emailRegex.test(email);
}

function isValidPhone(phone) {
    const phoneRegex = /^[\+]?[1-9][\d]{0,15}$/;
    return phoneRegex.test(phone.replace(/[\s\-\(\)]/g, ''));
}

function isValidCardNumber(cardNumber) {
    // Basic Luhn algorithm implementation
    if (!/^\d{13,19}$/.test(cardNumber)) return false;
    
    let sum = 0;
    let shouldDouble = false;
    
    for (let i = cardNumber.length - 1; i >= 0; i--) {
        let digit = parseInt(cardNumber.charAt(i));
        
        if (shouldDouble) {
            digit *= 2;
            if (digit > 9) digit -= 9;
        }
        
        sum += digit;
        shouldDouble = !shouldDouble;
    }
    
    return sum % 10 === 0;
}

function isValidExpiryDate(expiryDate) {
    if (!/^\d{2}\/\d{2}$/.test(expiryDate)) return false;
    
    const [month, year] = expiryDate.split('/').map(num => parseInt(num));
    const currentDate = new Date();
    const currentYear = currentDate.getFullYear() % 100;
    const currentMonth = currentDate.getMonth() + 1;
    
    if (month < 1 || month > 12) return false;
    if (year < currentYear || (year === currentYear && month < currentMonth)) return false;
    
    return true;
}

function isValidCVV(cvv) {
    return /^\d{3,4}$/.test(cvv);
}

function showNotification(message, type = 'info') {
    // Remove existing notifications
    const existingNotifications = document.querySelectorAll('.notification');
    existingNotifications.forEach(notification => notification.remove());
    
    // Create notification
    const notification = document.createElement('div');
    notification.className = `notification notification-${type}`;
    notification.style.cssText = `
        position: fixed;
        top: 20px;
        right: 20px;
        padding: 1rem 2rem;
        border-radius: 10px;
        color: white;
        font-weight: 600;
        z-index: 9999;
        transform: translateX(100%);
        transition: transform 0.3s ease;
    `;
    
    // Set background color based on type
    const colors = {
        success: '#10B981',
        error: '#EF4444',
        info: '#3B82F6',
        warning: '#F59E0B'
    };
    
    notification.style.background = colors[type] || colors.info;
    notification.textContent = message;
    
    // Add to page
    document.body.appendChild(notification);
    
    // Animate in
    setTimeout(() => {
        notification.style.transform = 'translateX(0)';
    }, 100);
    
    // Auto remove after 5 seconds
    setTimeout(() => {
        notification.style.transform = 'translateX(100%)';
        setTimeout(() => {
            if (notification.parentNode) {
                notification.remove();
            }
        }, 300);
    }, 5000);
}

// Course selection from URL parameters
function updateCourseFromURL() {
    const urlParams = new URLSearchParams(window.location.search);
    const courseName = urlParams.get('course');
    const coursePrice = urlParams.get('price');
    const courseDuration = urlParams.get('duration');
    const courseLessons = urlParams.get('lessons');
    
    if (courseName) {
        document.getElementById('selected-course').textContent = decodeURIComponent(courseName);
    }
    if (coursePrice) {
        document.getElementById('course-price').textContent = `$${coursePrice}`;
        updatePricing(0); // Recalculate totals
    }
    if (courseDuration) {
        document.getElementById('course-duration').textContent = decodeURIComponent(courseDuration);
    }
    if (courseLessons) {
        document.getElementById('course-lessons').textContent = decodeURIComponent(courseLessons);
    }
}

// Initialize course data from URL on page load
document.addEventListener('DOMContentLoaded', updateCourseFromURL);
