let map;
let marca;
let circulo;
$(".separadorMiles").inputmask({ alias: "currency", removeMaskOnSubmit: true });

function initMap() {
    let lat = parseFloat(document.getElementById("lat").value);
    let lng = parseFloat(document.getElementById("lng").value);
    let zoom = parseFloat(document.getElementById("zoom").value);

    map = new google.maps.Map(document.getElementById("map"), {
        center: { lat: lat, lng: lng },
        zoom: zoom,
    });

    google.maps.event.addListenerOnce(map, 'idle', function() {
        if (document.getElementById("map_select").value == "1") {
            agregarPeaje({ lat: lat, lng: lng }, map);
        }
    });

    google.maps.event.addListener(map, "zoom_changed", (event) => {
        document.getElementById("zoom").value = map.getZoom();
    });

    google.maps.event.addListener(map, "click", (event) => {
        if (marca) {
            marca.setMap(null);
            circulo.setMap(null);
        }
        agregarPeaje(event.latLng.toJSON(), map);
    });

    document.getElementById("radio").addEventListener("change", () => {
        if (circulo) {
            circulo.setRadius(parseInt(document.getElementById("radio").value));
        }
    }, );

}

function agregarPeaje(location, map) {
    document.getElementById("map_select").value = "1";
    document.getElementById("lat").value = location.lat;
    document.getElementById("lng").value = location.lng;
    marca = new google.maps.Marker({
        position: location,
        map: map
    });
    const radio = parseInt(document.getElementById("radio").value);
    circulo = new google.maps.Circle({
        strokeColor: "#FF0000",
        strokeOpacity: 0.8,
        strokeWeight: 2,
        fillColor: "#FF0000",
        fillOpacity: 0.35,
        map,
        center: location,
        radius: radio,
    });
}