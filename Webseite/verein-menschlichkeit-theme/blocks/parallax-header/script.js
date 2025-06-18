document.addEventListener('DOMContentLoaded', function() {
    initializeParallaxHeaders();
});

function initializeParallaxHeaders() {
    const headers = document.querySelectorAll('.parallax-header');
    
    headers.forEach(header => {
        const background = header.querySelector('.parallax-background');
        const speed = parseFloat(header.dataset.parallaxSpeed);
        
        if (background && !isNaN(speed)) {
            let ticking = false;
            let lastScrollY = window.scrollY;
            
            // Initial position
            updateParallax();
            
            // Scroll handler
            window.addEventListener('scroll', () => {
                lastScrollY = window.scrollY;
                
                if (!ticking) {
                    window.requestAnimationFrame(() => {
                        updateParallax();
                        ticking = false;
                    });
                    
                    ticking = true;
                }
            });
            
            // Update parallax effect
            function updateParallax() {
                const rect = header.getBoundingClientRect();
                const scrolled = window.scrollY;
                
                if (rect.top + rect.height > 0 && rect.top < window.innerHeight) {
                    const yPos = -(scrolled * speed);
                    background.style.transform = `translate3d(0, ${yPos}px, 0)`;
                }
            }
            
            // Resize handler
            let resizeTimeout;
            window.addEventListener('resize', () => {
                clearTimeout(resizeTimeout);
                resizeTimeout = setTimeout(updateParallax, 100);
            });
        }
    });
    
    // Smooth Scroll für Buttons
    const buttons = document.querySelectorAll('.header-button');
    buttons.forEach(button => {
        button.addEventListener('click', (e) => {
            const href = button.getAttribute('href');
            if (href.startsWith('#')) {
                e.preventDefault();
                const target = document.querySelector(href);
                if (target) {
                    target.scrollIntoView({
                        behavior: 'smooth'
                    });
                }
            }
        });
    });
}
