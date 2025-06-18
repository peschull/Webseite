document.addEventListener('DOMContentLoaded', function() {
    const heroSection = document.querySelector('.hero-section-scroll-trigger');
    const ctaButton = heroSection.querySelector('.cta-button');
    
    if (heroSection && ctaButton) {
        // Scroll Event Handler
        window.addEventListener('scroll', function() {
            const scrollPosition = window.scrollY;
            const heroHeight = heroSection.offsetHeight;
            const scrollPercentage = (scrollPosition / heroHeight) * 100;
            
            // Aktiviere die Scroll-Animation, wenn der User 30% der Hero-Section gescrollt hat
            if (scrollPercentage >= 30) {
                ctaButton.classList.add('scroll-active');
            } else {
                ctaButton.classList.remove('scroll-active');
            }
        });
        
        // Smooth Scroll zu der Zielposition wenn der CTA-Button geklickt wird
        ctaButton.addEventListener('click', function(e) {
            const href = this.getAttribute('href');
            
            if (href.startsWith('#')) {
                e.preventDefault();
                const targetElement = document.querySelector(href);
                
                if (targetElement) {
                    targetElement.scrollIntoView({
                        behavior: 'smooth',
                        block: 'start'
                    });
                }
            }
        });
    }
    
    // Parallax-Effekt für den Hintergrund
    const heroBackground = heroSection.querySelector('.hero-background');
    if (heroBackground) {
        window.addEventListener('scroll', function() {
            const scrolled = window.scrollY;
            heroBackground.style.transform = `translateY(${scrolled * 0.4}px)`;
        });
    }
});
