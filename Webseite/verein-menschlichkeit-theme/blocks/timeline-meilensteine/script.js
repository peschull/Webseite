(function($) {
    'use strict';

    $(document).ready(function() {
        // Optional: Animation für Timeline-Items beim Scrollen
        $('.timeline-meilensteine .timeline-item').each(function(i) {
            var $item = $(this);
            setTimeout(function() {
                $item.addClass('visible');
            }, 200 * i);
        });
    });
})(jQuery);
