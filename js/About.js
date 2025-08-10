 window.addEventListener('load', function() {
            const loader = document.getElementById('loader');
            const body = document.body;
            
            // Hide loader after a minimum of 2 seconds or when page is fully loaded
            setTimeout(() => {
                loader.classList.add('fade-out');
                body.classList.remove('loading');
                
                // Remove loader from DOM after animation
                setTimeout(() => {
                    loader.style.display = 'none';
                }, 500);
            }, 2000);
        });