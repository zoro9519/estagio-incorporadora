window.initMap = function() {
    // JS API is loaded and available
    map = new google.maps.Map(document.getElementById('map'), {
        center: {lat: LatLanding, lng: LongLanding},
        zoom: 7
    });

    const marker = new google.maps.Marker({
        position: {
            lat: LatLanding,
            lng: LongLanding
        },
        map: map,
      });

    infoWindow = new google.maps.InfoWindow();
    // Try HTML5 geolocation.
    if (navigator.geolocation) {
      navigator.geolocation.getCurrentPosition(
        (position) => {
          const pos = {
            lat: position.coords.latitude,
            lng: position.coords.longitude,
          };
          infoWindow.setPosition(pos);
          infoWindow.setContent("Location found.");
          infoWindow.open(map);
          map.setCenter(pos);
        },
        () => {
        //   handleLocationError(true, infoWindow, map.getCenter());
        }
      );
    } else {
      // Browser doesn't support Geolocation
      handleLocationError(false, infoWindow, map.getCenter());
    }

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