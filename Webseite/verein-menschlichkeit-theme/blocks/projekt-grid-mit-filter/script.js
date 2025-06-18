document.addEventListener('DOMContentLoaded', function() {
    const filterButtons = document.querySelectorAll('.filter-button');
    const projectCards = document.querySelectorAll('.projekt-card');
    
    // Filter-Funktionalität
    filterButtons.forEach(button => {
        button.addEventListener('click', function() {
            const filter = this.dataset.filter;
            
            // Aktiven Button aktualisieren
            filterButtons.forEach(btn => btn.classList.remove('active'));
            this.classList.add('active');
            
            // Projekte filtern
            projectCards.forEach(card => {
                const cardCategory = card.dataset.category;
                
                if (filter === 'all' || cardCategory === filter) {
                    card.style.animation = 'none';
                    card.offsetHeight; // Trigger Reflow
                    card.style.animation = null;
                    card.classList.remove('hidden');
                } else {
                    card.classList.add('hidden');
                }
            });
            
            // Optional: Isotope oder Masonry Layout aktualisieren
            if (typeof Isotope !== 'undefined' && grid) {
                grid.arrange({
                    filter: filter === 'all' ? '*' : `[data-category="${filter}"]`
                });
            }
        });
    });
    
    // Lazy Loading für Bilder
    if ('loading' in HTMLImageElement.prototype) {
        const images = document.querySelectorAll('.projekt-image img[loading="lazy"]');
        images.forEach(img => {
            img.src = img.dataset.src;
        });
    } else {
        // Fallback für Browser ohne natives Lazy Loading
        const script = document.createElement('script');
        script.src = 'https://cdnjs.cloudflare.com/ajax/libs/lazysizes/5.3.2/lazysizes.min.js';
        document.body.appendChild(script);
    }
    
    // Optional: Masonry Layout für bessere Darstellung
    if (typeof Isotope !== 'undefined') {
        const grid = new Isotope('.projekt-grid', {
            itemSelector: '.projekt-card',
            percentPosition: true,
            masonry: {
                columnWidth: '.projekt-card'
            },
            transitionDuration: '0.4s',
            hiddenStyle: {
                opacity: 0,
                transform: 'scale(0.95)'
            },
            visibleStyle: {
                opacity: 1,
                transform: 'scale(1)'
            }
        });
    }
    
    // URL Parameter für vorausgewählten Filter
    const urlParams = new URLSearchParams(window.location.search);
    const selectedCategory = urlParams.get('category');
    
    if (selectedCategory) {
        const targetButton = document.querySelector(`.filter-button[data-filter="${selectedCategory}"]`);
        if (targetButton) {
            targetButton.click();
        }
    }
    
    // Smooth Scroll zu gefilterten Ergebnissen
    filterButtons.forEach(button => {
        button.addEventListener('click', function() {
            const gridTop = document.querySelector('.projekt-grid').offsetTop - 100;
            window.scrollTo({
                top: gridTop,
                behavior: 'smooth'
            });
        });
    });
});
