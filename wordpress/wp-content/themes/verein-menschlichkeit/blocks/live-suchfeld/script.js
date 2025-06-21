// Basis-JavaScript für den Live-Suchfeld-Block
document.addEventListener('DOMContentLoaded', function() {
    const input = document.querySelector('.block-live-suchfeld input');
    if(input) {
        input.addEventListener('input', function() {
            // Hier kann die Live-Suche implementiert werden
            console.log('Suchbegriff:', input.value);
        });
    }
});
