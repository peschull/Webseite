document.addEventListener('DOMContentLoaded', function() {
    initializeMaps();
});

function initializeMaps() {
    const mapContainers = document.querySelectorAll('.map-container');
    
    mapContainers.forEach(container => {
        const lat = parseFloat(container.dataset.lat);
        const lng = parseFloat(container.dataset.lng);
        const zoom = parseInt(container.dataset.zoom);
        const mapElement = container.querySelector('#map');
        
        if (mapElement && !isNaN(lat) && !isNaN(lng)) {
            // Hier später die Map-Initialisierung mit dem gewählten Kartendienst
            // (z.B. Google Maps, OpenStreetMap, etc.) implementieren
            
            // Beispiel für OpenStreetMap:
            const map = L.map(mapElement).setView([lat, lng], zoom);
            
            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: '© OpenStreetMap contributors'
            }).addTo(map);
            
            L.marker([lat, lng]).addTo(map);
        }
    });
}
