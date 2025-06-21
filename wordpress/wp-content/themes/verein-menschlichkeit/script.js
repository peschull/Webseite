// Verein Menschlichkeit - Mobile-First Enhanced User Experience Script
(function() {
    'use strict';
    
    // ===== MOBILE NAVIGATION =====
    function initMobileMenu() {
        const header = document.querySelector('.site-header .container');
        const nav = document.querySelector('.main-navigation');
        const menu = document.querySelector('.nav-menu');
        
        if (!header || !nav || !menu) return;
        
        // Erstelle Mobile Menu Toggle Button
        const menuToggle = document.createElement('button');
        menuToggle.className = 'mobile-menu-toggle';
        menuToggle.setAttribute('aria-label', 'Menü öffnen/schließen');
        menuToggle.setAttribute('aria-expanded', 'false');
        menuToggle.innerHTML = `
            <span></span>
            <span></span>
            <span></span>
        `;
        
        // Füge Toggle Button zum Header hinzu
        header.appendChild(menuToggle);
        
        // Toggle Funktionalität
        menuToggle.addEventListener('click', function() {
            const isOpen = nav.classList.contains('active');
            
            if (isOpen) {
                closeMenu();
            } else {
                openMenu();
            }
        });
        
        function openMenu() {
            nav.classList.add('active');
            menuToggle.classList.add('active');
            menuToggle.setAttribute('aria-expanded', 'true');
            document.body.style.overflow = 'hidden'; // Verhindert Hintergrund-Scrollen
            
            // Focus auf erstes Menu-Item
            const firstMenuItem = menu.querySelector('a');
            if (firstMenuItem) {
                firstMenuItem.focus();
            }
        }
        
        function closeMenu() {
            nav.classList.remove('active');
            menuToggle.classList.remove('active');
            menuToggle.setAttribute('aria-expanded', 'false');
            document.body.style.overflow = '';
            menuToggle.focus();
        }
        
        // Schließe Menu bei Klick auf Menu-Item
        menu.addEventListener('click', function(e) {
            if (e.target.tagName === 'A') {
                closeMenu();
            }
        });
        
        // Schließe Menu bei Escape-Taste
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape' && nav.classList.contains('active')) {
                closeMenu();
            }
        });
        
        // Schließe Menu bei Klick außerhalb
        document.addEventListener('click', function(e) {
            if (!header.contains(e.target) && nav.classList.contains('active')) {
                closeMenu();
            }
        });
        
        // Schließe Menu bei Resize zu Desktop
        window.addEventListener('resize', function() {
            if (window.innerWidth > 768 && nav.classList.contains('active')) {
                closeMenu();
            }
        });
    }
    
    // ===== RESPONSIVE IMAGES =====
    function initResponsiveImages() {
        const images = document.querySelectorAll('img');
        
        images.forEach(img => {
            // Lazy Loading für bessere Performance
            if ('loading' in HTMLImageElement.prototype) {
                if (!img.getAttribute('loading')) {
                    img.setAttribute('loading', 'lazy');
                }
            }
            
            // Verbesserter Alt-Text Check
            if (!img.alt && !img.getAttribute('role')) {
                console.warn('Bild ohne Alt-Text gefunden:', img.src);
            }
        });
    }
    
    // ===== TOUCH & GESTURE HANDLING =====
    function initTouchHandling() {
        // Verbesserte Touch-Gesten für Slider/Carousel
        const sliders = document.querySelectorAll('.slider');
        
        sliders.forEach(slider => {
            let startX = 0;
            let currentX = 0;
            let isDragging = false;
            
            slider.addEventListener('touchstart', (e) => {
                startX = e.touches[0].clientX;
                isDragging = true;
            }, { passive: true });
            
            slider.addEventListener('touchmove', (e) => {
                if (!isDragging) return;
                currentX = e.touches[0].clientX;
            }, { passive: true });
            
            slider.addEventListener('touchend', () => {
                if (!isDragging) return;
                
                const diffX = startX - currentX;
                const threshold = 50;
                
                if (Math.abs(diffX) > threshold) {
                    // Trigger slide change
                    const event = new CustomEvent('slideChange', {
                        detail: { direction: diffX > 0 ? 'next' : 'prev' }
                    });
                    slider.dispatchEvent(event);
                }
                
                isDragging = false;
            });
        });
    }
    
    // ===== VIEWPORT & ORIENTATION HANDLING =====
    function initViewportHandling() {
        // Fix für iOS Safari Viewport-Probleme
        function setViewportHeight() {
            const vh = window.innerHeight * 0.01;
            document.documentElement.style.setProperty('--vh', `${vh}px`);
        }
        
        setViewportHeight();
        window.addEventListener('resize', setViewportHeight);
        window.addEventListener('orientationchange', () => {
            setTimeout(setViewportHeight, 100);
        });
        
        // Orientation Change Handling
        window.addEventListener('orientationchange', function() {
            // Schließe Mobile Menu bei Orientation Change
            const nav = document.querySelector('.main-navigation');
            if (nav && nav.classList.contains('active')) {
                nav.classList.remove('active');
                document.body.style.overflow = '';
            }
        });
    }
    
    // ===== FORM ENHANCEMENTS =====
    function enhanceForm() {
        const form = document.querySelector('.contact-form form');
        if (!form) return;
        
        // Verbesserte Formular-Validierung
        const inputs = form.querySelectorAll('input, textarea');
        
        inputs.forEach(input => {
            // Real-time Validierung
            input.addEventListener('blur', function() {
                validateField(this);
            });
            
            // Entferne Fehler-Styling bei Eingabe
            input.addEventListener('input', function() {
                this.classList.remove('error');
                const errorMsg = this.parentNode.querySelector('.error-message');
                if (errorMsg) {
                    errorMsg.remove();
                }
            });
        });
        
        function validateField(field) {
            const value = field.value.trim();
            let isValid = true;
            let errorMessage = '';
            
            // Required Field Check
            if (field.hasAttribute('required') && !value) {
                isValid = false;
                errorMessage = 'Dieses Feld ist erforderlich.';
            }
            
            // Email Validation
            if (field.type === 'email' && value) {
                const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
                if (!emailRegex.test(value)) {
                    isValid = false;
                    errorMessage = 'Bitte geben Sie eine gültige E-Mail-Adresse ein.';
                }
            }
            
            // Telefon Validation
            if (field.type === 'tel' && value) {
                const phoneRegex = /^[\+]?[\d\s\-\(\)]+$/;
                if (!phoneRegex.test(value)) {
                    isValid = false;
                    errorMessage = 'Bitte geben Sie eine gültige Telefonnummer ein.';
                }
            }
            
            // Update UI
            if (!isValid) {
                field.classList.add('error');
                showFieldError(field, errorMessage);
            } else {
                field.classList.remove('error');
                hideFieldError(field);
            }
            
            return isValid;
        }
        
        function showFieldError(field, message) {
            hideFieldError(field);
            const errorDiv = document.createElement('div');
            errorDiv.className = 'error-message';
            errorDiv.textContent = message;
            errorDiv.setAttribute('role', 'alert');
            field.parentNode.appendChild(errorDiv);
        }
        
        function hideFieldError(field) {
            const errorMsg = field.parentNode.querySelector('.error-message');
            if (errorMsg) {
                errorMsg.remove();
            }
        }
        
        // Form Submit Handler
        form.addEventListener('submit', function(e) {
            e.preventDefault();
            
            let isFormValid = true;
            inputs.forEach(input => {
                if (!validateField(input)) {
                    isFormValid = false;
                }
            });
            
            if (isFormValid) {
                // Show loading state
                const submitBtn = form.querySelector('button[type="submit"]');
                const originalText = submitBtn.textContent;
                submitBtn.textContent = 'Wird gesendet...';
                submitBtn.disabled = true;
                
                // Simulate form submission
                setTimeout(() => {
                    showSuccessMessage();
                    form.reset();
                    submitBtn.textContent = originalText;
                    submitBtn.disabled = false;
                }, 2000);
            } else {
                // Focus erstes Fehlerfeld
                const firstError = form.querySelector('.error');
                if (firstError) {
                    firstError.focus();
                    firstError.scrollIntoView({ behavior: 'smooth', block: 'center' });
                }
            }
        });
        
        function showSuccessMessage() {
            const successDiv = document.createElement('div');
            successDiv.className = 'success-message';
            successDiv.textContent = 'Vielen Dank! Ihre Nachricht wurde erfolgreich gesendet.';
            successDiv.setAttribute('role', 'alert');
            successDiv.style.cssText = `
                background: #10b981;
                color: white;
                padding: 16px 20px;
                border-radius: 8px;
                margin-bottom: 20px;
                text-align: center;
                font-weight: 500;
            `;
            
            form.insertBefore(successDiv, form.firstChild);
            
            // Auto-remove nach 5 Sekunden
            setTimeout(() => {
                successDiv.remove();
            }, 5000);
        }
    }
    
    // ===== ACCESSIBILITY ENHANCEMENTS =====
    function enhanceAccessibility() {
        // Skip Link Enhancement
        const skipLink = document.querySelector('.skip-link');
        if (skipLink) {
            skipLink.addEventListener('click', function(e) {
                e.preventDefault();
                const target = document.querySelector(this.getAttribute('href'));
                if (target) {
                    target.setAttribute('tabindex', '-1');
                    target.focus();
                    target.scrollIntoView({ behavior: 'smooth' });
                }
            });
        }
        
        // Keyboard Navigation für Custom Elements
        const customButtons = document.querySelectorAll('[role="button"]');
        customButtons.forEach(button => {
            button.addEventListener('keydown', function(e) {
                if (e.key === 'Enter' || e.key === ' ') {
                    e.preventDefault();
                    this.click();
                }
            });
        });
        
        // ARIA Live Region für dynamische Inhalte
        const liveRegion = document.createElement('div');
        liveRegion.setAttribute('aria-live', 'polite');
        liveRegion.setAttribute('aria-atomic', 'true');
        liveRegion.className = 'sr-only';
        liveRegion.id = 'live-region';
        document.body.appendChild(liveRegion);
        
        // Funktion zum Ankündigen von Änderungen
        window.announceToScreenReader = function(message) {
            const liveRegion = document.getElementById('live-region');
            if (liveRegion) {
                liveRegion.textContent = message;
                setTimeout(() => {
                    liveRegion.textContent = '';
                }, 1000);
            }
        };
    }
    
    // ===== PERFORMANCE OPTIMIZATIONS =====
    function initPerformanceOptimizations() {
        // Intersection Observer für lazy loading
        if ('IntersectionObserver' in window) {
            const lazyImages = document.querySelectorAll('img[data-src]');
            const imageObserver = new IntersectionObserver((entries, observer) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        const img = entry.target;
                        img.src = img.dataset.src;
                        img.classList.remove('lazy');
                        imageObserver.unobserve(img);
                    }
                });
            });
            
            lazyImages.forEach(img => imageObserver.observe(img));
        }
        
        // Preload wichtige Ressourcen
        const preloadLinks = [
            { href: '/images/hero-image.jpg', as: 'image' },
            { href: '/images/logo.png', as: 'image' }
        ];
        
        preloadLinks.forEach(link => {
            const linkElement = document.createElement('link');
            linkElement.rel = 'preload';
            linkElement.href = link.href;
            linkElement.as = link.as;
            document.head.appendChild(linkElement);
        });
    }
    
    // ===== SMOOTH SCROLLING FÜR ANKER-LINKS =====
    function initSmoothScrolling() {
        const anchorLinks = document.querySelectorAll('a[href^="#"]');
        
        anchorLinks.forEach(link => {
            link.addEventListener('click', function(e) {
                const targetId = this.getAttribute('href');
                const target = document.querySelector(targetId);
                
                if (target) {
                    e.preventDefault();
                    target.scrollIntoView({
                        behavior: 'smooth',
                        block: 'start'
                    });
                    
                    // Update URL ohne Jump
                    history.pushState(null, null, targetId);
                }
            });
        });
    }
    
    // ===== ERROR HANDLING =====
    function initErrorHandling() {
        // Global Error Handler
        window.addEventListener('error', function(e) {
            console.error('JavaScript Error:', e.error);
            // Fallback für kaputte Funktionalität
            if (e.error.message.includes('mobile')) {
                // Fallback für mobile Navigation
                document.body.classList.add('js-error-fallback');
            }
        });
        
        // Unhandled Promise Rejection Handler
        window.addEventListener('unhandledrejection', function(e) {
            console.error('Unhandled Promise Rejection:', e.reason);
            e.preventDefault();
        });
    }
    
    // Initialize when DOM is ready
    document.addEventListener('DOMContentLoaded', function() {
        initMobileMenu();
        enhanceSkipLink();
        enhanceForm();
        initViewportHandling();
        initTouchHandling();
        initPerformanceOptimizations();
        initSmoothScrolling();
        enhanceAccessibility();
        initErrorHandling();
        
        // Add focus management for accessibility
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Tab') {
                document.body.classList.add('keyboard-navigation');
            }
        });
        
    
    // ===== INITIALIZATION =====
    function init() {
        try {
            initErrorHandling();
            initViewportHandling();
            initMobileMenu();
            initResponsiveImages();
            initTouchHandling();
            enhanceForm();
            enhanceAccessibility();
            initPerformanceOptimizations();
            initSmoothScrolling();
            
            // Announce page ready to screen readers
            setTimeout(() => {
                if (window.announceToScreenReader) {
                    window.announceToScreenReader('Seite vollständig geladen');
                }
            }, 1000);
            
        } catch (error) {
            console.error('Initialization error:', error);
            // Fallback für kritische Funktionen
            document.body.classList.add('js-fallback');
        }
    }
    
    // ===== DOM READY =====
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', init);
    } else {
        init();
    }
    
})();

// ===== ZUSÄTZLICHE MOBILE UTILITIES =====

// Debounce Funktion für Performance
function debounce(func, wait) {
    let timeout;
    return function executedFunction(...args) {
        const later = () => {
            clearTimeout(timeout);
            func(...args);
        };
        clearTimeout(timeout);
        timeout = setTimeout(later, wait);
    };
}

// Throttle Funktion für Scroll-Events
function throttle(func, limit) {
    let inThrottle;
    return function() {
        const args = arguments;
        const context = this;
        if (!inThrottle) {
            func.apply(context, args);
            inThrottle = true;
            setTimeout(() => inThrottle = false, limit);
        }
    };
}

// Device Detection
const isMobile = {
    Android: () => navigator.userAgent.match(/Android/i),
    BlackBerry: () => navigator.userAgent.match(/BlackBerry/i),
    iOS: () => navigator.userAgent.match(/iPhone|iPad|iPod/i),
    Opera: () => navigator.userAgent.match(/Opera Mini/i),
    Windows: () => navigator.userAgent.match(/IEMobile/i) || navigator.userAgent.match(/WPDesktop/i),
    any: function() {
        return (this.Android() || this.BlackBerry() || this.iOS() || this.Opera() || this.Windows());
    }
};

// Add mobile class to body
if (isMobile.any()) {
    document.body.classList.add('is-mobile');
}

// iOS Specific Fixes
if (isMobile.iOS()) {
    document.body.classList.add('is-ios');
    
    // Fix für iOS Safari bounce
    document.addEventListener('touchmove', function(e) {
        if (e.target.closest('.scrollable')) return;
        e.preventDefault();
    }, { passive: false });
}

// Add touch support class
if ('ontouchstart' in window || navigator.maxTouchPoints > 0) {
    document.body.classList.add('touch-device');
} else {
    document.body.classList.add('no-touch');
}
