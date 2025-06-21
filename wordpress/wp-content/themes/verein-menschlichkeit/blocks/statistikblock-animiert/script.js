(function($) {
    'use strict';
    // Animierte Zahlen (Count-Up)
    function animateNumber($el, ziel, duration) {
        var start = 0;
        var startTime = null;
        function step(timestamp) {
            if (!startTime) startTime = timestamp;
            var progress = Math.min((timestamp - startTime) / duration, 1);
            var value = Math.floor(progress * (ziel - start) + start);
            $el.text(value);
            if (progress < 1) {
                requestAnimationFrame(step);
            } else {
                $el.text(ziel);
            }
        }
        requestAnimationFrame(step);
    }
    $(document).ready(function() {
        $('.statistikblock-animiert .statistikblock-zahl').each(function() {
            var $zahl = $(this);
            var ziel = parseInt($zahl.data('ziel'), 10) || 0;
            animateNumber($zahl, ziel, 1200);
        });
    });
})(jQuery);
