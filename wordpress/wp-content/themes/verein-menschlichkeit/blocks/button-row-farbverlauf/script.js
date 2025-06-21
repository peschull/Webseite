(function($) {
    'use strict';
    // Optional: Animation für Buttons
    $(document).ready(function() {
        $('.button-row-farbverlauf .button-farbverlauf').each(function(i) {
            var $btn = $(this);
            setTimeout(function() {
                $btn.addClass('visible');
            }, 100 * i);
        });
    });
})(jQuery);
