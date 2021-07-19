
const addMarker = (position, text, map) => {
    new google.maps.Marker({
        position: position,
        label: {
            text : text,
            color :"#FFFFFF"
        },
        map: map    
    });
}
function initMap() {
    let lat_ini = parseFloat(document.getElementById("lat_ini").value);
    let lng_ini = parseFloat(document.getElementById("lng_ini").value);

    let lat_fin = parseFloat(document.getElementById("lat_fin").value);
    let lng_fin = parseFloat(document.getElementById("lng_fin").value);


    let zoom = parseFloat(document.getElementById("zoom").value);

    let coordenadas = document.getElementById("ruta").value;
    coordenadas = coordenadas.split(",");
    let puntos = [];
    for(c in coordenadas){
        let lat_place = coordenadas[c].split(" ")[0];
        let lng_place = coordenadas[c].split(" ")[1];
        puntos.push({ lat: parseFloat(lat_place), lng: parseFloat(lng_place) });
    }
    
    map = new google.maps.Map(document.getElementById("map"), {
        center: { lat: lat_ini, lng: lng_ini },
        zoom: zoom,
    });
    const ruta_seleccionada = new google.maps.Polyline({
        path: puntos,
        geodesic: true,
        strokeColor: "#FF0000",
        strokeOpacity: 1.0,
        strokeWeight: 2,
    });
    ruta_seleccionada.setMap(map);
    addMarker({ lat: lat_ini, lng: lng_ini }, "INI", map);
    addMarker({ lat: lat_fin, lng: lng_fin }, "FIN", map);
    addPeajes(map);
}


function addPeajes(map){
    let pea_nombres = document.getElementsByName("pea_nombre[]");
    let pea_lats = document.getElementsByName("pea_lat[]");
    let pea_lngs = document.getElementsByName("pea_lng[]");
    let pea_valor_cobrado = document.getElementsByName("pea_valor_cobrado[]");
    for (let i = 0; i < pea_nombres.length; i++){
        
        const marker = new google.maps.Marker({
            position: { lat: parseFloat(pea_lats[i].value), lng: parseFloat(pea_lngs[i].value) },
            label: {
                text : `P ${i + 1}`,
                color :"#FFFFFF"
            },
            map: map    
        });
        const infowindow = new google.maps.InfoWindow({
            content: `<h5>${pea_nombres[i].value}</h5><b>Valor: </b>${pea_valor_cobrado[i].value}`,
        });

        marker.addListener("click", () => {
            infowindow.open({
                anchor: marker,
                map,
                shouldFocus: false,
            });
        });
        

    }
}

jQuery(function() {
    $("body").on("click", "#cancelar_servicio", function(e) {
        e.preventDefault();
        $(".modal-eliminar").modal("show");
    });
});

