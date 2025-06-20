/**
 * Skip Link Focus Fix für IE11
 * 
 * @package Verein_Menschlichkeit
 * @since 1.0.0
 */

(function() {
    'use strict';
    
    var isIe = /(trident|msie)/i.test(navigator.userAgent);
    
    if (isIe && document.getElementById && window.addEventListener) {
        window.addEventListener('hashchange', function() {
            var id = location.hash.substring(1);
            var element;
            
            if (!/^[A-z0-9_-]+$/.test(id)) {
                return;
            }
            
            element = document.getElementById(id);
            
            if (element) {
                if (!/^(?:a|select|input|button|textarea)$/i.test(element.tagName)) {
                    element.tabIndex = -1;
                }
                
                element.focus();
            }
        }, false);
    }
})();
