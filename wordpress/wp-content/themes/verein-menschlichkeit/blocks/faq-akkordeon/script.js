(function($) {
    'use strict';
    $(document).ready(function() {
        $('.faq-akkordeon .faq-frage').on('click', function() {
            var $button = $(this);
            var $antwort = $button.closest('.faq-item').find('.faq-antwort');
            var expanded = $button.attr('aria-expanded') === 'true';
            $button.attr('aria-expanded', !expanded);
            $antwort.slideToggle(200).attr('hidden', expanded);
            $button.find('.faq-toggle').text(expanded ? '+' : '–');
        });
    });
})(jQuery);
