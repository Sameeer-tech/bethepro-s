// Professional Scroll-Triggered Animations for BeThePros Website
// Minimal and performance-optimized animation triggers

document.addEventListener('DOMContentLoaded', function() {
    // Create Intersection Observer for scroll-triggered animations
    const observerOptions = {
        threshold: 0.1,
        rootMargin: '0px 0px -50px 0px'
    };

    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.classList.add('animate-in-view');
                // Unobserve after animation to improve performance
                observer.unobserve(entry.target);
            }
        });
    }, observerOptions);

    // Observe all elements with animation classes
    const animatedElements = document.querySelectorAll(
        '.animate-fade-in, .animate-slide-up, .animate-scale-in, ' +
        '.animate-fade-in-left, .animate-fade-in-right, ' +
        '.feature-card, .testimonial, .course-card'
    );

    animatedElements.forEach(el => {
        observer.observe(el);
    });

    // Add special animations for hero section (immediate)
    setTimeout(() => {
        const heroElements = document.querySelectorAll('.hero .animate-fade-in, .hero .animate-slide-up, .hero .animate-scale-in');
        heroElements.forEach(el => {
            el.classList.add('animate-in-view');
        });
    }, 300);

    // Enhanced button hover effects
    const buttons = document.querySelectorAll('.btn, .primary-btn, .secondary-btn, button');
    buttons.forEach(btn => {
        btn.addEventListener('mouseenter', function() {
            this.style.transform = 'translateY(-3px) scale(1.02)';
        });
        
        btn.addEventListener('mouseleave', function() {
            this.style.transform = 'translateY(0) scale(1)';
        });
    });

    // Add parallax effect to hero section (subtle)
    const hero = document.querySelector('.hero');
    if (hero) {
        window.addEventListener('scroll', () => {
            const scrolled = window.pageYOffset;
            const parallax = scrolled * 0.5;
            hero.style.transform = `translateY(${parallax}px)`;
        });
    }

    // Smooth scroll for anchor links
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function (e) {
            e.preventDefault();
            const target = document.querySelector(this.getAttribute('href'));
            if (target) {
                target.scrollIntoView({
                    behavior: 'smooth',
                    block: 'start'
                });
            }
        });
    });
});
