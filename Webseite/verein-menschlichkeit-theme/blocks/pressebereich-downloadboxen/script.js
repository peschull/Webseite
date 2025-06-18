(function($) {
    'use strict';
    // Optional: Animation für Downloadboxen
    $(document).ready(function() {
        $('.pressebereich-downloadboxen .downloadbox').each(function(i) {
            var $box = $(this);
            setTimeout(function() {
                $box.addClass('visible');
            }, 120 * i);
        });
    });
})(jQuery);
