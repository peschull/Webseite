document.addEventListener('DOMContentLoaded', function() {
    initializePDFViewers();
});

function initializePDFViewers() {
    const viewers = document.querySelectorAll('.pdf-viewer-block');
    
    viewers.forEach(viewer => {
        const iframe = viewer.querySelector('.pdf-frame');
        
        if (iframe) {
            // Loading-Status
            iframe.addEventListener('load', () => {
                iframe.classList.add('loaded');
            });
            
            // Fallback für Browser ohne PDF-Plugin
            iframe.addEventListener('error', () => {
                const container = iframe.closest('.pdf-container');
                const url = iframe.src.split('#')[0];
                
                container.innerHTML = `
                    <div class="pdf-fallback">
                        <p>Der PDF-Viewer konnte nicht geladen werden.</p>
                        <a href="${url}" class="download-button" target="_blank">
                            <span class="download-icon">📄</span>
                            PDF im Browser öffnen
                        </a>
                    </div>
                `;
            });
        }
        
        // Download-Button Interaktion
        const downloadButton = viewer.querySelector('.download-button');
        if (downloadButton) {
            downloadButton.addEventListener('click', () => {
                // Tracking des Downloads (optional)
                if (typeof gtag === 'function') {
                    gtag('event', 'pdf_download', {
                        'file_name': downloadButton.getAttribute('download')
                    });
                }
            });
        }
    });
}
