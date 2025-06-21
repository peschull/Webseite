document.addEventListener('DOMContentLoaded', function() {
    initializeProjectMatrix();
});

function initializeProjectMatrix() {
    const matrices = document.querySelectorAll('.projektmatrix');
    
    matrices.forEach(matrix => {
        const filterButtons = matrix.querySelectorAll('.filter-button');
        const projectCards = matrix.querySelectorAll('.project-card');
        
        // Filter-Funktionalität
        filterButtons.forEach(button => {
            button.addEventListener('click', () => {
                const category = button.dataset.category;
                
                // Button-Status aktualisieren
                filterButtons.forEach(btn => btn.classList.remove('active'));
                button.classList.add('active');
                
                // Projekte filtern
                projectCards.forEach(card => {
                    const categories = JSON.parse(card.dataset.categories || '[]');
                    
                    if (category === 'all' || categories.includes(category)) {
                        card.style.display = '';
                        setTimeout(() => {
                            card.style.opacity = '1';
                            card.style.transform = 'translateY(0)';
                        }, 50);
                    } else {
                        card.style.opacity = '0';
                        card.style.transform = 'translateY(20px)';
                        setTimeout(() => {
                            card.style.display = 'none';
                        }, 300);
                    }
                });
            });
        });
        
        // Masonry-ähnliches Layout bei Filterung
        function updateLayout() {
            const visibleCards = Array.from(projectCards).filter(
                card => card.style.display !== 'none'
            );
            
            if (visibleCards.length === 0) {
                const noProjects = document.createElement('p');
                noProjects.className = 'no-projects';
                noProjects.textContent = 'Keine Projekte in dieser Kategorie gefunden.';
                matrix.querySelector('.projects-grid').appendChild(noProjects);
            } else {
                const noProjects = matrix.querySelector('.no-projects');
                if (noProjects) {
                    noProjects.remove();
                }
            }
        }
        
        // Layout nach Filterung aktualisieren
        filterButtons.forEach(button => {
            button.addEventListener('click', () => {
                setTimeout(updateLayout, 350);
            });
        });
        
        // Initiales Layout
        updateLayout();
    });
}
