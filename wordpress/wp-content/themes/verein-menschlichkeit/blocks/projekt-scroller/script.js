(function($) {
    'use strict';
    // Optional: Horizontales Scrollen per Maus/Touch
    $(document).ready(function() {
        var $liste = $('.projekt-scroller .projekt-scroller-liste');
        if ($liste.length) {
            $liste.on('wheel', function(e) {
                if (e.originalEvent.deltaY !== 0) {
                    e.preventDefault();
                    $liste.scrollLeft($liste.scrollLeft() + e.originalEvent.deltaY);
                }
            });
        }
    });
})(jQuery);
