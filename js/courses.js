
// Enhanced Course Page Functionality
document.addEventListener('DOMContentLoaded', function() {
    const courseCards = document.querySelectorAll('.course-card');

    // Enhanced course card hover effects with 3D transform
    courseCards.forEach(card => {
        card.addEventListener('mouseenter', () => {
            card.style.transition = 'all 0.3s ease';
            card.style.transform = 'translateY(-15px) rotateY(5deg) scale(1.02)';
            card.style.boxShadow = '0 25px 50px rgba(0, 0, 0, 0.15)';
            
            // Add glow effect
            card.style.filter = 'brightness(1.05)';
        });
        
        card.addEventListener('mouseleave', () => {
            card.style.transform = 'translateY(0) rotateY(0) scale(1)';
            card.style.boxShadow = '0 10px 30px rgba(0, 0, 0, 0.1)';
            card.style.filter = 'brightness(1)';
        });
        
        // Add click animation
        card.addEventListener('mousedown', () => {
            card.style.transform = 'translateY(-10px) scale(0.98)';
        });
        
        card.addEventListener('mouseup', () => {
            card.style.transform = 'translateY(-15px) rotateY(5deg) scale(1.02)';
        });
    });

    // Add search functionality (if search input exists)
    const searchInput = document.getElementById('courseSearch');
    if (searchInput) {
        searchInput.addEventListener('input', function() {
            const searchTerm = this.value.toLowerCase();
            
            courseCards.forEach(card => {
                const title = card.querySelector('h3').textContent.toLowerCase();
                const description = card.querySelector('.course-description').textContent.toLowerCase();
                
                if (title.includes(searchTerm) || description.includes(searchTerm)) {
                    card.style.display = 'block';
                    card.style.opacity = '1';
                } else {
                    card.style.opacity = '0.3';
                }
            });
        });
    }

    // Enhanced enroll button functionality
    const enrollBtns = document.querySelectorAll('.enroll-btn');
    enrollBtns.forEach(btn => {
        btn.addEventListener('click', function(e) {
            // Add ripple effect
            const ripple = document.createElement('span');
            ripple.classList.add('ripple');
            this.appendChild(ripple);
            
            const rect = this.getBoundingClientRect();
            const size = Math.max(rect.width, rect.height);
            ripple.style.width = ripple.style.height = size + 'px';
            ripple.style.left = (e.clientX - rect.left - size / 2) + 'px';
            ripple.style.top = (e.clientY - rect.top - size / 2) + 'px';
            
            setTimeout(() => {
                ripple.remove();
            }, 600);
        });
    });
});