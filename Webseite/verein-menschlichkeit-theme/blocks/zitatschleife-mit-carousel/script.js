document.addEventListener('DOMContentLoaded', function() {
    const carouselModule = document.querySelector('.quote-carousel-module');
    if (!carouselModule) return;
    
    const carousel = carouselModule.querySelector('.quote-carousel');
    const slides = carousel.querySelectorAll('.quote-slide');
    const dots = carouselModule.querySelectorAll('.dot');
    const prevButton = carouselModule.querySelector('.carousel-nav.prev');
    const nextButton = carouselModule.querySelector('.carousel-nav.next');
    
    let currentSlide = 0;
    let isAutoPlaying = carouselModule.dataset.autoplay === 'true';
    const autoPlaySpeed = parseInt(carouselModule.dataset.speed) || 5000;
    let autoPlayInterval;
    
    // Initialisiere den Carousel
    function initCarousel() {
        slides[0].classList.add('active');
        if (isAutoPlaying) {
            startAutoPlay();
        }
        attachEventListeners();
    }
    
    // Event Listener hinzufügen
    function attachEventListeners() {
        if (prevButton) {
            prevButton.addEventListener('click', showPreviousSlide);
        }
        
        if (nextButton) {
            nextButton.addEventListener('click', showNextSlide);
        }
        
        dots.forEach((dot, index) => {
            dot.addEventListener('click', () => goToSlide(index));
        });
        
        // Pause Autoplay bei Hover
        carousel.addEventListener('mouseenter', () => {
            if (isAutoPlaying) {
                clearInterval(autoPlayInterval);
            }
        });
        
        carousel.addEventListener('mouseleave', () => {
            if (isAutoPlaying) {
                startAutoPlay();
            }
        });
        
        // Keyboard Navigation
        document.addEventListener('keydown', (e) => {
            if (e.key === 'ArrowLeft') {
                showPreviousSlide();
            } else if (e.key === 'ArrowRight') {
                showNextSlide();
            }
        });
        
        // Touch Events
        let touchStartX = 0;
        let touchEndX = 0;
        
        carousel.addEventListener('touchstart', (e) => {
            touchStartX = e.changedTouches[0].screenX;
        });
        
        carousel.addEventListener('touchend', (e) => {
            touchEndX = e.changedTouches[0].screenX;
            handleSwipe();
        });
        
        function handleSwipe() {
            const swipeThreshold = 50;
            const diff = touchStartX - touchEndX;
            
            if (Math.abs(diff) > swipeThreshold) {
                if (diff > 0) {
                    showNextSlide();
                } else {
                    showPreviousSlide();
                }
            }
        }
    }
    
    // Starte Autoplay
    function startAutoPlay() {
        autoPlayInterval = setInterval(showNextSlide, autoPlaySpeed);
    }
    
    // Zeige vorherige Slide
    function showPreviousSlide() {
        goToSlide(currentSlide - 1);
    }
    
    // Zeige nächste Slide
    function showNextSlide() {
        goToSlide(currentSlide + 1);
    }
    
    // Gehe zu einer bestimmten Slide
    function goToSlide(index) {
        // Entferne aktive Klassen
        slides[currentSlide].classList.remove('active');
        if (dots[currentSlide]) {
            dots[currentSlide].classList.remove('active');
        }
        
        // Berechne neuen Index
        currentSlide = (index + slides.length) % slides.length;
        
        // Füge aktive Klassen hinzu
        slides[currentSlide].classList.add('active');
        if (dots[currentSlide]) {
            dots[currentSlide].classList.add('active');
        }
        
        // Füge ARIA-Label für Barrierefreiheit hinzu
        slides.forEach((slide, i) => {
            slide.setAttribute('aria-hidden', i !== currentSlide);
        });
    }
    
    // Fokus Management für Barrierefreiheit
    function handleFocus() {
        const focusableElements = carousel.querySelectorAll('button, [href], input, select, textarea, [tabindex]:not([tabindex="-1"])');
        const firstFocusable = focusableElements[0];
        const lastFocusable = focusableElements[focusableElements.length - 1];
        
        function handleTabKey(e) {
            const isTabPressed = e.key === 'Tab';
            
            if (!isTabPressed) return;
            
            if (e.shiftKey) {
                if (document.activeElement === firstFocusable) {
                    lastFocusable.focus();
                    e.preventDefault();
                }
            } else {
                if (document.activeElement === lastFocusable) {
                    firstFocusable.focus();
                    e.preventDefault();
                }
            }
        }
        
        carousel.addEventListener('keydown', handleTabKey);
    }
    
    // Initialisierung
    initCarousel();
    handleFocus();
});
