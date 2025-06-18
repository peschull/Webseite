document.addEventListener('DOMContentLoaded', function() {
    initializeContentNavigation();
});

function initializeContentNavigation() {
    const navBlocks = document.querySelectorAll('.inhaltsnavigation-ankerlinks');
    
    navBlocks.forEach(nav => {
        const selector = nav.dataset.selector;
        const smoothScroll = nav.dataset.smoothScroll === 'true';
        const navList = nav.querySelector('.nav-list');
        const toggleButton = nav.querySelector('.toggle-nav');
        const scrollTopButton = nav.querySelector('.scroll-top');
        
        // Überschriften finden und Navigation aufbauen
        const headings = document.querySelectorAll(selector);
        if (headings.length > 0) {
            navList.innerHTML = ''; // Platzhalter entfernen
            
            headings.forEach((heading, index) => {
                // Anker-ID erstellen oder vorhandene verwenden
                const headingId = heading.id || `section-${index + 1}`;
                heading.id = headingId;
                
                // Navigationselement erstellen
                const li = document.createElement('li');
                li.className = 'nav-item';
                
                const a = document.createElement('a');
                a.href = `#${headingId}`;
                a.className = 'nav-link';
                a.textContent = heading.textContent;
                
                li.appendChild(a);
                navList.appendChild(li);
                
                // Scroll-Event für aktive Klasse
                const observer = new IntersectionObserver(
                    ([entry]) => {
                        if (entry.isIntersecting) {
                            navList.querySelectorAll('.nav-link').forEach(link => {
                                link.classList.remove('active');
                            });
                            a.classList.add('active');
                        }
                    },
                    { threshold: 0.5 }
                );
                
                observer.observe(heading);
            });
            
            // Smooth Scroll
            if (smoothScroll) {
                navList.addEventListener('click', e => {
                    if (e.target.classList.contains('nav-link')) {
                        e.preventDefault();
                        const targetId = e.target.getAttribute('href').substring(1);
                        const targetElement = document.getElementById(targetId);
                        
                        if (targetElement) {
                            targetElement.scrollIntoView({
                                behavior: 'smooth'
                            });
                        }
                    }
                });
            }
        }
        
        // Toggle-Funktionalität
        if (toggleButton) {
            toggleButton.addEventListener('click', () => {
                nav.classList.toggle('nav-collapsed');
                const isExpanded = !nav.classList.contains('nav-collapsed');
                toggleButton.setAttribute('aria-expanded', isExpanded);
            });
        }
        
        // Scroll-Top Button
        if (scrollTopButton) {
            window.addEventListener('scroll', () => {
                if (window.pageYOffset > 300) {
                    scrollTopButton.classList.add('visible');
                } else {
                    scrollTopButton.classList.remove('visible');
                }
            });
            
            scrollTopButton.addEventListener('click', () => {
                window.scrollTo({
                    top: 0,
                    behavior: 'smooth'
                });
            });
        }
    });
}
