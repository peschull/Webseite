document.addEventListener('DOMContentLoaded', function() {
    const signButtons = document.querySelectorAll('.sign-petition-button');
    
    signButtons.forEach(button => {
        button.addEventListener('click', handlePetitionSign);
    });
    
    function handlePetitionSign(event) {
        // Hier später die Logik für die Unterschriften-Verarbeitung implementieren
        const button = event.target;
        const block = button.closest('.petition-block');
        
        // Animation für den Klick
        button.style.transform = 'scale(0.95)';
        setTimeout(() => {
            button.style.transform = 'scale(1)';
        }, 100);
        
        // Feedback an den Benutzer
        alert('Vielen Dank für Ihre Unterstützung! Die Unterschriftenfunktion wird in Kürze implementiert.');
    }
});
