import GrayScaleMapStyles from './grayscale-map-styles.json';

export function onSubmit(token: string) {
    const form = document.getElementById("quote-form") as HTMLFormElement;
    if (form.checkValidity()) {
        form.submit();
    } else {
        grecaptcha.reset();
        form.reportValidity();
    }
}

export function initMap() {
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

    const grayscaleMapType = new google.maps.StyledMapType(GrayScaleMapStyles, {name: 'Grayscale'});
    map.mapTypes.set('Grayscale', grayscaleMapType);
    map.setMapTypeId('Grayscale');
}