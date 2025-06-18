(function($) {
    'use strict';
    $(document).ready(function() {
        $('.reaktions-block .reaktions-emoji').on('click', function() {
            var $btn = $(this);
            var $count = $btn.find('.reaktions-count');
            var current = parseInt($count.text(), 10) || 0;
            $count.text(current + 1);
            $btn.addClass('reaktiviert');
            setTimeout(function() {
                $btn.removeClass('reaktiviert');
            }, 400);
        });
    });
})(jQuery);
