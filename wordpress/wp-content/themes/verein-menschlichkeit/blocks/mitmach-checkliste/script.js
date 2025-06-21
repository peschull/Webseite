(function($) {
    'use strict';
    $(document).ready(function() {
        $('.mitmach-checkliste .checkliste-checkbox').on('change', function() {
            var $cb = $(this);
            $cb.closest('.checkliste-item').toggleClass('abgehakt', $cb.is(':checked'));
        });
    });
})(jQuery);
