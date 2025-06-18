document.addEventListener('DOMContentLoaded', function() {
    initializeFeedbackButtons();
});

function initializeFeedbackButtons() {
    const feedbackContainers = document.querySelectorAll('.live-feedback-button');
    
    feedbackContainers.forEach(container => {
        const triggerButton = container.querySelector('.feedback-trigger');
        const popup = container.querySelector('.feedback-popup');
        const closeButton = container.querySelector('.close-popup');
        const options = container.querySelectorAll('.feedback-option');
        const submitButton = container.querySelector('.submit-feedback');
        const commentTextarea = container.querySelector('textarea');
        
        // Popup öffnen/schließen
        triggerButton.addEventListener('click', () => {
            popup.style.display = 'block';
        });
        
        closeButton.addEventListener('click', () => {
            popup.style.display = 'none';
            resetForm();
        });
        
        // Optionen-Auswahl
        options.forEach(option => {
            option.addEventListener('click', () => {
                options.forEach(opt => opt.classList.remove('selected'));
                option.classList.add('selected');
            });
        });
        
        // Feedback absenden
        submitButton.addEventListener('click', () => {
            const selectedOption = container.querySelector('.feedback-option.selected');
            if (!selectedOption) {
                alert('Bitte wählen Sie eine Feedback-Option aus.');
                return;
            }
            
            const feedbackData = {
                value: selectedOption.dataset.value,
                comment: commentTextarea ? commentTextarea.value : '',
                timestamp: new Date().toISOString(),
                page: window.location.pathname
            };
            
            // AJAX-Request zum Speichern des Feedbacks
            submitFeedback(feedbackData, container);
        });
        
        // Klick außerhalb schließt Popup
        document.addEventListener('click', (event) => {
            if (!container.contains(event.target) && popup.style.display === 'block') {
                popup.style.display = 'none';
                resetForm();
            }
        });
    });
}

function submitFeedback(data, container) {
    // Hier AJAX-Request zum WordPress-Backend implementieren
    console.log('Feedback-Daten:', data);
    
    // Erfolgsanzeige
    const popup = container.querySelector('.feedback-popup');
    const originalContent = popup.innerHTML;
    
    popup.innerHTML = `
        <div class="feedback-success">
            <p>✅ Vielen Dank für Ihr Feedback!</p>
        </div>
    `;
    
    // Nach 2 Sekunden Popup schließen und Form zurücksetzen
    setTimeout(() => {
        popup.style.display = 'none';
        popup.innerHTML = originalContent;
        initializeFeedbackButtons(); // Eventlistener neu initialisieren
    }, 2000);
}

function resetForm() {
    const options = document.querySelectorAll('.feedback-option');
    options.forEach(opt => opt.classList.remove('selected'));
    
    const textarea = document.querySelector('.feedback-comment textarea');
    if (textarea) {
        textarea.value = '';
    }
}
