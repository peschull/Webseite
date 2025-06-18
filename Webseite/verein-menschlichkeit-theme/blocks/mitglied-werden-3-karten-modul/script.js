document.addEventListener('DOMContentLoaded', function() {
    // Hovering cards animation on desktop
    if (window.innerWidth > 768) {
        const cards = document.querySelectorAll('.membership-card');
        
        cards.forEach(card => {
            card.addEventListener('mouseenter', function() {
                // Reduziere die Skalierung der anderen Karten
                cards.forEach(otherCard => {
                    if (otherCard !== card && !otherCard.classList.contains('highlighted')) {
                        otherCard.style.transform = 'scale(0.98)';
                        otherCard.style.opacity = '0.8';
                    }
                });
            });
            
            card.addEventListener('mouseleave', function() {
                // Stelle den ursprünglichen Zustand wieder her
                cards.forEach(otherCard => {
                    if (!otherCard.classList.contains('highlighted')) {
                        otherCard.style.transform = 'scale(1)';
                        otherCard.style.opacity = '1';
                    }
                });
            });
        });
    }
    
    // Tracking für CTA-Klicks
    const ctaButtons = document.querySelectorAll('.cta-button');
    
    ctaButtons.forEach(button => {
        button.addEventListener('click', function(e) {
            const membershipType = this.dataset.membershipType;
            
            // Sende Event an Google Analytics (falls vorhanden)
            if (typeof gtag === 'function') {
                gtag('event', 'membership_selected', {
                    'event_category': 'Membership',
                    'event_label': membershipType
                });
            }
        });
    });
    
    // Smooth Reveal Animation beim Scrollen
    const observerOptions = {
        root: null,
        rootMargin: '0px',
        threshold: 0.1
    };
    
    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.classList.add('reveal');
                observer.unobserve(entry.target);
            }
        });
    }, observerOptions);
    
    const membershipModule = document.querySelector('.membership-cards-module');
    if (membershipModule) {
        observer.observe(membershipModule);
    }
});
