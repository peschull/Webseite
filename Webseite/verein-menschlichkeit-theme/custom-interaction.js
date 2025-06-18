// Scroll-Reveal für .reveal-Elemente
(function(){
  document.addEventListener("DOMContentLoaded", function() {
    var elements = document.querySelectorAll('.reveal');
    if (!('IntersectionObserver' in window)) {
      elements.forEach(function(el){ el.classList.add('visible'); });
      return;
    }
    var observer = new IntersectionObserver(function(entries) {
      entries.forEach(function(entry) {
        if (entry.isIntersecting) entry.target.classList.add('visible');
      });
    });
    elements.forEach(function(el){ observer.observe(el); });
  });
})();

// Galerie-Filter
(function(){
  document.addEventListener('DOMContentLoaded', function() {
    var filterBtns = document.querySelectorAll('.gallery-filter [data-filter]');
    var items = document.querySelectorAll('.gallery [data-category]');
    if(filterBtns.length && items.length) {
      filterBtns.forEach(function(btn){
        btn.addEventListener('click', function(){
          var cat = btn.getAttribute('data-filter');
          filterBtns.forEach(function(b){b.classList.remove('active');});
          btn.classList.add('active');
          items.forEach(function(item){
            if(cat==='all'||item.getAttribute('data-category')===cat){
              item.style.display='block';
            } else {
              item.style.display='none';
            }
          });
        });
      });
    }
  });
})();

// FAQ-Akkordeon
(function(){
  document.addEventListener('DOMContentLoaded', function() {
    document.querySelectorAll('.faq-question').forEach(function(btn){
      btn.addEventListener('click', function(){
        btn.nextElementSibling.classList.toggle('open');
      });
    });
  });
})();
