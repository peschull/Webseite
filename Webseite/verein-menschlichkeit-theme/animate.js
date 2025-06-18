// Verein Menschlichkeit Animationen: Sichtbarkeit beim Scrollen
function vereinAnimateOnScroll() {
  var elements = document.querySelectorAll('.card, .gallery img, .btn-primary, .btn-secondary');
  var windowHeight = window.innerHeight;
  elements.forEach(function(el) {
    var rect = el.getBoundingClientRect();
    if (rect.top < windowHeight - 60) {
      el.classList.add('visible');
    }
  });
}
document.addEventListener('DOMContentLoaded', vereinAnimateOnScroll);
window.addEventListener('scroll', vereinAnimateOnScroll);
