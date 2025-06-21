document.addEventListener('DOMContentLoaded', function() {
    const werteModule = document.querySelector('.werte-block-module');
    if (!werteModule) return;
    
    const werteCards = werteModule.querySelectorAll('.wert-card');
    let currentSlide = 0;
    
    // Intersection Observer für Animation beim Scrollen
    const observerOptions = {
        root: null,
        rootMargin: '0px',
        threshold: 0.2
    };
    
    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                const card = entry.target;
                const delay = card.dataset.index * 200;
                
                setTimeout(() => {
                    card.classList.add('animated');
                }, delay);
                
                observer.unobserve(card);
            }
        });
    }, observerOptions);
    
    // Beobachte alle Werte-Karten
    werteCards.forEach(card => {
        observer.observe(card);
    });
    
    // Carousel Funktionalität
    if (werteModule.classList.contains('carousel')) {
        const autoPlaySpeed = 5000;
        let autoPlayInterval;
        
        // Zeige erste Slide
        werteCards[0].classList.add('active');
        
        // Erstelle Navigation
        const createNavigation = () => {
            const nav = document.createElement('div');
            nav.className = 'carousel-nav';
            
            const prevButton = document.createElement('button');
            prevButton.className = 'nav-button prev';
            prevButton.innerHTML = '←';
            prevButton.setAttribute('aria-label', 'Vorheriger Wert');
            
            const nextButton = document.createElement('button');
            nextButton.className = 'nav-button next';
            nextButton.innerHTML = '→';
            nextButton.setAttribute('aria-label', 'Nächster Wert');
            
            nav.appendChild(prevButton);
            nav.appendChild(nextButton);
            werteModule.appendChild(nav);
            
            // Event Listener
            prevButton.addEventListener('click', showPreviousSlide);
            nextButton.addEventListener('click', showNextSlide);
        };
        
        // Slide Funktionen
        const showSlide = (index) => {
            werteCards[currentSlide].classList.remove('active');
            currentSlide = (index + werteCards.length) % werteCards.length;
            werteCards[currentSlide].classList.add('active');
        };
        
        const showNextSlide = () => {
            showSlide(currentSlide + 1);
        };
        
        const showPreviousSlide = () => {
            showSlide(currentSlide - 1);
        };
        
        // Autoplay
        const startAutoPlay = () => {
            autoPlayInterval = setInterval(showNextSlide, autoPlaySpeed);
        };
        
        const stopAutoPlay = () => {
            clearInterval(autoPlayInterval);
        };
        
        // Touch Events
        let touchStartX = 0;
        let touchEndX = 0;
        
        werteModule.addEventListener('touchstart', (e) => {
            touchStartX = e.changedTouches[0].screenX;
            stopAutoPlay();
        });
        
        werteModule.addEventListener('touchend', (e) => {
            touchEndX = e.changedTouches[0].screenX;
            handleSwipe();
            startAutoPlay();
        });
        
        const handleSwipe = () => {
            const swipeThreshold = 50;
            const diff = touchStartX - touchEndX;
            
            if (Math.abs(diff) > swipeThreshold) {
                if (diff > 0) {
                    showNextSlide();
                } else {
                    showPreviousSlide();
                }
            }
        };
        
        // Initialisierung Carousel
        createNavigation();
        startAutoPlay();
        
        // Pause Autoplay bei Hover
        werteModule.addEventListener('mouseenter', stopAutoPlay);
        werteModule.addEventListener('mouseleave', startAutoPlay);
        
        // Keyboard Navigation
        document.addEventListener('keydown', (e) => {
            if (e.key === 'ArrowLeft') {
                showPreviousSlide();
            } else if (e.key === 'ArrowRight') {
                showNextSlide();
            }
        });
    }
    
    // Hover Effekte für Icons
    werteCards.forEach(card => {
        const icon = card.querySelector('.wert-icon');
        
        if (icon) {
            card.addEventListener('mouseenter', () => {
                icon.style.transform = 'scale(1.1) rotate(5deg)';
            });
            
            card.addEventListener('mouseleave', () => {
                icon.style.transform = 'scale(1) rotate(0)';
            });
        }
    });
});
