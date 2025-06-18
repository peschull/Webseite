(function($) {
    'use strict';
    // Optional: Animation für Zitat-Items
    $(document).ready(function() {
        $('.zitate-mauer .zitat-item').each(function(i) {
            var $item = $(this);
            setTimeout(function() {
                $item.addClass('visible');
            }, 120 * i);
        });
    });
})(jQuery);
