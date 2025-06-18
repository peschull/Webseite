(function($) {
    'use strict';
    $(document).ready(function() {
        $('.vorlese-block .vorlese-button').on('click', function() {
            var targetId = $(this).data('target');
            var text = $('#' + targetId).text();
            if ('speechSynthesis' in window) {
                var utter = new SpeechSynthesisUtterance(text);
                utter.lang = 'de-DE';
                window.speechSynthesis.speak(utter);
            } else {
                alert('Text-to-Speech wird von Ihrem Browser nicht unterstützt.');
            }
        });
    });
})(jQuery);
