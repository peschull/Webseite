(function($) {
    'use strict';
    // Optional: Animation für Blog-Kacheln
    $(document).ready(function() {
        $('.blog-kachelgrid .bloggrid-item').each(function(i) {
            var $item = $(this);
            setTimeout(function() {
                $item.addClass('visible');
            }, 120 * i);
        });
    });
})(jQuery);
