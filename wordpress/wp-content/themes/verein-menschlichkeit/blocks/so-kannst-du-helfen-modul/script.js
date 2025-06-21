(function($) {
    'use strict';
    // Optional: Animation für Helfen-Items
    $(document).ready(function() {
        $('.so-kannst-du-helfen-modul .helfen-item').each(function(i) {
            var $item = $(this);
            setTimeout(function() {
                $item.addClass('visible');
            }, 150 * i);
        });
    });
})(jQuery);
