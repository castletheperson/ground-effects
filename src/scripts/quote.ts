function onSubmit(token: string) {
    const form = document.getElementById("quote-form") as HTMLFormElement;
    if (form.checkValidity()) {
        form.submit();
    } else {
        grecaptcha.reset();
        form.reportValidity();
    }
}

function initMap() {
    const shop = {lat: 36.445603, lng: -94.299035};
    const mapElement = document.getElementById('map')!

    const map = new google.maps.Map(mapElement, {
        zoom: 10,
        center: shop,
        disableDefaultUI: true
    });

    new google.maps.Marker({
        position: shop,
        map: map,
        icon: {
            url: "https://static.squarespace.com/universal/images-v6/icons/icon-map-marker-2x.png",
            size: new google.maps.Size(52, 68),
            scaledSize: new google.maps.Size(26, 34),
            anchor: new google.maps.Point(13, 34)
        }
    });

    const GrayScaleMapStyles = [{
        "stylers": [
            { "visibility": "on" },
            { "saturation": -100 },
            { "gamma": 0.54 }
        ]
    }, {
        "featureType": "road",
        "elementType": "labels.icon",
        "stylers": [{ "visibility": "off" }]
    }, {
        "featureType": "water",
        "stylers": [{ "color": "#4d4946" }]
    }, {
        "featureType": "poi",
        "elementType": "labels.icon",
        "stylers": [{ "visibility": "off" }]
    }, {
        "featureType": "poi",
        "elementType": "labels.text",
        "stylers": [{ "visibility": "simplified" }]
    }, {
        "featureType": "road",
        "elementType": "geometry.fill",
        "stylers": [{ "color": "#ffffff" }]
    }, {
        "featureType": "road.local",
        "elementType": "labels.text",
        "stylers": [{ "visibility": "simplified" }]
    }, {
        "featureType": "water",
        "elementType": "labels.text.fill",
        "stylers": [{ "color": "#ffffff" }]
    }, {
        "featureType": "transit.line",
        "elementType": "geometry",
        "stylers": [{ "gamma": 0.48 }]
    }, {
        "featureType": "transit.station",
        "elementType": "labels.icon",
        "stylers": [{ "visibility": "off" }]
    }, {
        "featureType": "road",
        "elementType": "geometry.stroke",
        "stylers": [{ "gamma": 7.18 }]
    }];

    const grayscaleMapType = new google.maps.StyledMapType(GrayScaleMapStyles, {name: 'Grayscale'});
    map.mapTypes.set('Grayscale', grayscaleMapType);
    map.setMapTypeId('Grayscale');
}
