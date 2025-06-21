(function($) {
    'use strict';
    function updateCountdown($block) {
        var zielDatum = $block.data('datum');
        if (!zielDatum) return;
        var ziel = new Date(zielDatum).getTime();
        function tick() {
            var jetzt = new Date().getTime();
            var diff = ziel - jetzt;
            if (diff < 0) diff = 0;
            var tage = Math.floor(diff / (1000 * 60 * 60 * 24));
            var stunden = Math.floor((diff / (1000 * 60 * 60)) % 24);
            var minuten = Math.floor((diff / (1000 * 60)) % 60);
            var sekunden = Math.floor((diff / 1000) % 60);
            $block.find('.countdown-tage').text(('0' + tage).slice(-2));
            $block.find('.countdown-stunden').text(('0' + stunden).slice(-2));
            $block.find('.countdown-minuten').text(('0' + minuten).slice(-2));
            $block.find('.countdown-sekunden').text(('0' + sekunden).slice(-2));
            if (diff > 0) {
                setTimeout(tick, 1000);
            }
        }
        tick();
    }
    $(document).ready(function() {
        $('.countdown-timer').each(function() {
            updateCountdown($(this));
        });
    });
})(jQuery);
