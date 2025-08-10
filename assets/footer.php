 <style>
footer {
    background-color: var(--text-color);
    color: var(--white);
    padding: 60px 0 20px;
}

.footer-content {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
    gap: 40px;
    margin-bottom: 40px;
}

.footer-section h3 {
    font-size: 1.3rem;
    margin-bottom: 20px;
    position: relative;
    padding-bottom: 10px;
}

.footer-section h3::after {
    content: '';
    position: absolute;
    bottom: 0;
    left: 0;
    width: 40px;
    height: 2px;
    background-color: var(--primary-color);
}

.footer-section p {
    margin-bottom: 20px;
    opacity: 0.8;
    font-size: 0.95rem;
}

.footer-section ul {
    list-style: none;
}

.footer-section ul li {
    margin-bottom: 10px;
}

.footer-section ul li a {
    color: var(--gray-medium);
    text-decoration: none;
    transition: var(--transition);
    font-size: 0.95rem;
}

.footer-section ul li a:hover {
    color: var(--white);
    padding-left: 5px;
}

.footer-bottom {
    text-align: center;
    padding-top: 20px;
    border-top: 1px solid rgba(255, 255, 255, 0.1);
    font-size: 0.9rem;
    opacity: 0.7;
}

/* Responsive Styles */
@media (max-width: 992px) {
    .hero h1 {
        font-size: 2.8rem;
    }
    
    .nav-links {
        display: none;
    }
}

@media (max-width: 768px) {
    .hero {
        text-align: center;
    }
    
    .hero-content {
        margin: 0 auto;
    }
    
    .hero-buttons {
        justify-content: center;
    }
    
    .hero h1 {
        font-size: 2.5rem;
    }
    
    .section-title {
        font-size: 2rem;
    }
}

@media (max-width: 576px) {
    .hero h1 {
        font-size: 2rem;
    }
    
    .hero p {
        font-size: 1rem;
    }
    
    .primary-btn, .secondary-btn {
        padding: 12px 25px;
    }
    
    .feature-card {
        padding: 20px;
    }
    
    .stats-grid {
        grid-template-columns: 1fr 1fr;
    }
    
    .testimonial-grid {
        grid-template-columns: 1fr;
    }
    
    .cta-section h2 {
        font-size: 2rem;
    }
}</style>

<!-- Footer -->
<footer>
    <div class="container">
        <div class="footer-content">
            <div class="footer-section">
                <h3>BeThePro's</h3>
                <p>Empowering professionals to succeed in their career journey through comprehensive interview preparation and skill development.</p>
            </div>
            <div class="footer-section">
                <h3>Quick Links</h3>
                <ul>
                    <li><a href="index.php">Home</a></li>
                    <li><a href="index.php#features">Features</a></li>
                    <li><a href="courses.php">Courses</a></li>
                    <li><a href="about.php">About Us</a></li>
                </ul>
            </div>
            <div class="footer-section">
                <h3>Courses</h3>
                <ul>
                    <li><a href="courses.php#fresher">Fresher Interview Prep</a></li>
                    <li><a href="courses.php#mid">Mid-Level Professional</a></li>
                    <li><a href="courses.php#expert">Expert Level Guidance</a></li>
                    <li><a href="courses.php#soft-skills">Presentation Skills</a></li>
                </ul>
            </div>
            <div class="footer-section">
                <h3>Support</h3>
                <ul>
                    <li><a href="#">Help Center</a></li>
                    <li><a href="contact.php">Contact Us</a></li>
                    <li><a href="#">Privacy Policy</a></li>
                    <li><a href="#">Terms of Service</a></li>
                </ul>
            </div>
        </div>
        <div class="footer-bottom">
            <p>&copy; 2025 BeThePro's. All rights reserved. Empowering your success, one interview at a time.</p>
        </div>
    </div>
</footer>

<script>
// Footer link smooth scroll
document.querySelectorAll('footer a[href^="#"]').forEach(anchor => {
    anchor.addEventListener('click', function (e) {
        e.preventDefault();
        const target = document.querySelector(this.getAttribute('href').split('#')[1]);
        if (target) {
            target.scrollIntoView({
                behavior: 'smooth',
                block: 'start'
            });
        }
    });
});
</script>
