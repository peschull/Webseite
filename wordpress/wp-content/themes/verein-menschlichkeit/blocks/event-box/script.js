// script.js für event-box Block
// Hier können interaktive Features für den Block ergänzt werden

document.addEventListener('DOMContentLoaded', function() {
    // Beispiel: Klick-Event für die Event-Box
    document.querySelectorAll('.event-box-block').forEach(function(box) {
        box.addEventListener('click', function() {
            box.classList.toggle('active');
        });
    });
});
