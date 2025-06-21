document.addEventListener('DOMContentLoaded', function() {
    // Touch-Erkennung für mobile Geräte
    const isTouchDevice = ('ontouchstart' in window) || 
                         (navigator.maxTouchPoints > 0) || 
                         (navigator.msMaxTouchPoints > 0);
    
    const teamCards = document.querySelectorAll('.team-card');
    
    teamCards.forEach(card => {
        if (isTouchDevice) {
            // Für Touch-Geräte: Toggle beim Tippen
            card.addEventListener('click', function(e) {
                e.preventDefault();
                const wasActive = this.classList.contains('active');
                
                // Reset alle aktiven Karten
                teamCards.forEach(c => c.classList.remove('active'));
                
                // Toggle die aktuelle Karte
                if (!wasActive) {
                    this.classList.add('active');
                }
            });
        } else {
            // Für Desktop: Smooth Hover-Effekt
            card.addEventListener('mouseenter', function() {
                this.style.transform = 'translateY(-10px)';
            });
            
            card.addEventListener('mouseleave', function() {
                this.style.transform = 'translateY(0)';
            });
        }
    });
    
    // Accessibility: Keyboard Navigation
    teamCards.forEach(card => {
        card.setAttribute('tabindex', '0');
        
        card.addEventListener('keydown', function(e) {
            if (e.key === 'Enter' || e.key === ' ') {
                e.preventDefault();
                this.classList.toggle('active');
            }
        });
    });
    
    // Lazy Loading für Bilder
    if ('loading' in HTMLImageElement.prototype) {
        const images = document.querySelectorAll('.team-member-image img[loading="lazy"]');
        images.forEach(img => {
            img.src = img.dataset.src;
        });
    } else {
        // Fallback für Browser ohne natives Lazy Loading
        const script = document.createElement('script');
        script.src = 'https://cdnjs.cloudflare.com/ajax/libs/lazysizes/5.3.2/lazysizes.min.js';
        document.body.appendChild(script);
    }
});
