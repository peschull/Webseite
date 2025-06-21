document.addEventListener('DOMContentLoaded', function() {
    const spendenModule = document.querySelector('.spendenfortschritt-module');
    if (!spendenModule) return;
    
    const targetPercentage = parseFloat(spendenModule.dataset.percentage) || 0;
    const animationDuration = parseInt(spendenModule.dataset.duration) || 1500;
    const isCircle = spendenModule.classList.contains('circle');
    
    // Funktion zum Animieren der Zahlen
    function animateNumber(element, start, end, duration) {
        const range = end - start;
        const increment = range / (duration / 16);
        let current = start;
        
        const animate = () => {
            current += increment;
            
            if ((increment > 0 && current >= end) || (increment < 0 && current <= end)) {
                element.textContent = Math.round(end);
                return;
            }
            
            element.textContent = Math.round(current);
            requestAnimationFrame(animate);
        };
        
        animate();
    }
    
    // Intersection Observer für verzögerte Animation
    const observerOptions = {
        root: null,
        rootMargin: '0px',
        threshold: 0.2
    };
    
    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                // Starte Animation
                if (isCircle) {
                    animateCircleProgress();
                } else {
                    animateBarProgress();
                }
                
                observer.unobserve(entry.target);
            }
        });
    }, observerOptions);
    
    observer.observe(spendenModule);
    
    // Animiere Fortschrittsbalken
    function animateBarProgress() {
        const progressFill = spendenModule.querySelector('.progress-fill');
        const percentageElement = spendenModule.querySelector('.percentage');
        
        if (progressFill && percentageElement) {
            // Setze Füllfarbe basierend auf Prozentsatz
            setProgressColor(progressFill, targetPercentage);
            
            // Animiere Breite
            progressFill.style.transition = `width ${animationDuration}ms ease`;
            progressFill.style.width = `${targetPercentage}%`;
            
            // Animiere Prozentzahl
            animateNumber(percentageElement, 0, targetPercentage, animationDuration);
        }
    }
    
    // Animiere Kreisdiagramm
    function animateCircleProgress() {
        const circlePath = spendenModule.querySelector('.progress-circle-fill');
        const percentageElement = spendenModule.querySelector('.percentage');
        
        if (circlePath && percentageElement) {
            // Setze Kreisfarbe basierend auf Prozentsatz
            setProgressColor(circlePath, targetPercentage);
            
            // Berechne Stroke-Dashoffset
            const circumference = 100;
            const offset = circumference - (targetPercentage / 100) * circumference;
            
            // Animiere Kreis
            circlePath.style.transition = `stroke-dashoffset ${animationDuration}ms ease`;
            circlePath.style.strokeDashoffset = offset;
            
            // Animiere Prozentzahl
            animateNumber(percentageElement, 0, targetPercentage, animationDuration);
        }
    }
    
    // Setze Farbe basierend auf Prozentsatz
    function setProgressColor(element, percentage) {
        if (percentage >= 100) {
            element.style.filter = 'hue-rotate(0deg)'; // Grün
        } else if (percentage >= 75) {
            element.style.filter = 'hue-rotate(-25deg)'; // Gelb-Grün
        } else if (percentage >= 50) {
            element.style.filter = 'hue-rotate(-50deg)'; // Gelb
        } else if (percentage >= 25) {
            element.style.filter = 'hue-rotate(-75deg)'; // Orange
        } else {
            element.style.filter = 'hue-rotate(-100deg)'; // Rot
        }
    }
    
    // ARIA Updates für Barrierefreiheit
    function updateARIA() {
        const progressElement = spendenModule.querySelector('[role="progressbar"]');
        if (progressElement) {
            progressElement.setAttribute('aria-valuenow', Math.round(targetPercentage));
            progressElement.setAttribute('aria-valuetext', `${Math.round(targetPercentage)}% erreicht`);
        }
    }
    
    // Event Listener für Animationsende
    const progressElements = spendenModule.querySelectorAll('.progress-fill, .progress-circle-fill');
    progressElements.forEach(element => {
        element.addEventListener('transitionend', updateARIA);
    });
});
