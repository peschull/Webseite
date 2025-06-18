document.addEventListener('DOMContentLoaded', function() {
    initializeTagBlocks();
});

function initializeTagBlocks() {
    const tagBlocks = document.querySelectorAll('.verlinkte-schlagworte');
    
    tagBlocks.forEach(block => {
        const container = block.querySelector('.tags-container');
        const showMoreButton = block.querySelector('.show-more-tags');
        
        if (showMoreButton && container) {
            // Initial-Zustand
            const tags = container.querySelectorAll('.tag-item');
            const initialShow = parseInt(showMoreButton.dataset.initialShow) || 10;
            
            if (tags.length > initialShow) {
                block.classList.add('has-more');
            }
            
            // Toggle-Funktion
            showMoreButton.addEventListener('click', () => {
                block.classList.toggle('expanded');
                
                // Aria-Expanded aktualisieren
                const isExpanded = block.classList.contains('expanded');
                showMoreButton.setAttribute('aria-expanded', isExpanded);
                
                // Container-Höhe anpassen
                if (isExpanded) {
                    container.style.maxHeight = container.scrollHeight + 'px';
                } else {
                    container.style.maxHeight = '100px';
                }
            });
        }
        
        // Hover-Effekte für Tags
        const tags = block.querySelectorAll('.tag-item');
        tags.forEach(tag => {
            tag.addEventListener('mouseenter', () => {
                const count = parseInt(tag.dataset.count) || 0;
                if (count > 0) {
                    tag.title = `${count} Einträge mit diesem Schlagwort`;
                }
            });
        });
    });
    
    // Optional: Tag-Klick-Tracking
    document.addEventListener('click', e => {
        const tag = e.target.closest('.tag-item');
        if (tag && typeof gtag === 'function') {
            gtag('event', 'tag_click', {
                'tag_name': tag.textContent.trim(),
                'tag_url': tag.href
            });
        }
    });
}
