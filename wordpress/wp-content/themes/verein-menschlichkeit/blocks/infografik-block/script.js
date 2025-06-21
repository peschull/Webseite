(function($) {
    'use strict';
    // Optional: Animation oder Interaktivität für Infografik
    $(document).ready(function() {
        // Beispiel: Fade-in-Effekt für Grafik
        $('.infografik-block .infografik-grafik img').css('opacity', 0).on('load', function() {
            $(this).animate({opacity: 1}, 800);
        });
    });
})(jQuery);
