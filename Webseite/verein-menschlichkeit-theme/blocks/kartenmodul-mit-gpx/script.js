(function($) {
    'use strict';
    // Beispiel: Leaflet.js für GPX-Track
    $(document).ready(function() {
        $('.kartenmodul-mit-gpx .kartenmodul-map').each(function() {
            var $mapDiv = $(this);
            var gpxUrl = $mapDiv.data('gpx');
            if (!gpxUrl) return;
            // Leaflet Map initialisieren
            var map = L.map($mapDiv[0]).setView([51.1657, 10.4515], 6);
            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: '&copy; OpenStreetMap contributors'
            }).addTo(map);
            // GPX-Track laden (Leaflet.GPX Plugin erforderlich)
            new L.GPX(gpxUrl, {
                async: true,
                marker_options: {
                    startIconUrl: null,
                    endIconUrl: null,
                    shadowUrl: null
                }
            }).on('loaded', function(e) {
                map.fitBounds(e.target.getBounds());
            }).addTo(map);
        });
    });
})(jQuery);
