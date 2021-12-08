window.initMap = function() {
    // JS API is loaded and available
    map = new google.maps.Map(document.getElementById('map'), {
        center: {lat: LatLanding, lng: LongLanding},
        zoom: ZoomCoord
    });

    const marker = new google.maps.Marker({
        position: {
            lat: LatLanding,
            lng: LongLanding
        },
        map: map,
        title: loteamentoName
      });


  function handleLocationError(browserHasGeolocation, infoWindow, pos) {
    infoWindow.setPosition(pos);
    infoWindow.setContent(
      browserHasGeolocation
        ? "Erro ao recuperar localização do cliente."
        : "Error: Your browser doesn't support geolocation."
    );
    infoWindow.open(map);
  }
};