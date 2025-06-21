/**
 * Customizer Live Preview JavaScript
 * 
 * @package Verein_Menschlichkeit
 * @since 1.0.0
 */

(function($) {
    'use strict';
    
    // Primary Color
    wp.customize('verein_primary_color', function(value) {
        value.bind(function(newVal) {
            $('head').find('#verein-customizer-css').remove();
            $('head').append('<style id="verein-customizer-css">:root { --color-primary: ' + newVal + '; } .btn-primary, a { color: ' + newVal + '; } .bg-primary { background-color: ' + newVal + '; }</style>');
        });
    });
    
    // Secondary Color
    wp.customize('verein_secondary_color', function(value) {
        value.bind(function(newVal) {
            var existingStyle = $('head').find('#verein-customizer-css');
            var currentCSS = existingStyle.html() || '';
            existingStyle.remove();
            $('head').append('<style id="verein-customizer-css">' + currentCSS + ':root { --color-secondary: ' + newVal + '; } .btn-secondary { background-color: ' + newVal + '; } .bg-secondary { background-color: ' + newVal + '; }</style>');
        });
    });
    
    // Footer Text
    wp.customize('verein_footer_text', function(value) {
        value.bind(function(newVal) {
            $('.footer-text').html(newVal);
        });
    });
    
    // Footer Copyright
    wp.customize('verein_footer_copyright', function(value) {
        value.bind(function(newVal) {
            $('.footer-copyright').text(newVal);
        });
    });
    
})(jQuery);
