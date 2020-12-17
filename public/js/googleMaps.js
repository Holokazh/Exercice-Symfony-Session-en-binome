let map;

function initMap() {
    map = new google.maps.Map(document.getElementById("map"), {
        center: { lat: 48.075965881347656, lng: 7.3440632820129395 },
        zoom: 10,
    });

    const marker = new google.maps.Marker({
        position: { lat: 48.075965881347656, lng: 7.3440632820129395 },
        map: map,
    });
}