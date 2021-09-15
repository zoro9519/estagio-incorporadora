window.initMap = function() {

    var map = new google.maps.Map(document.getElementById('map'), {
        center: {lat: LatLanding, lng: LongLanding},
        zoom: ZoomLanding,
        zoomControl: false,
        mapTypeControl: false,
        streetViewControl: false
    });

    map.addListener("click", setMarker);


    var lastMarker = false;
    let coords = { };

    if(MustAddMarker){
        coords = {
            lat: LatLanding, 
            lng: LongLanding,
            zoom: ZoomLanding
        };
        lastMarker = addMarker(coords);
    }

    function addMarker(coords){
        const marker = new google.maps.Marker({
            position: coords,
            map: map,
        });
        return marker
    }

    function setMarker(e){
        
        console.log(map.getZoom());
        
        coords = {
            lat: e.latLng.lat(),
            lng: e.latLng.lng(),
            zoom: map.getZoom()
        };
        
        let txtLatitude = document.getElementById("txtLatitude");
        let txtLongitude = document.getElementById("txtLongitude");
        let txtZoom = document.getElementById("txtZoom");

        let btnSaveNewLocation = document.getElementById("btnSaveLocation");
        let frmUpdateLocation = document.getElementById("frmUpdateLocation");

        txtLatitude.value = coords.lat;
        txtLongitude.value = coords.lng;
        txtZoom.value = coords.zoom;

        if(lastMarker){
            lastMarker.setMap(null);
            btnSaveNewLocation.style.display = "block";
        }
        let auxMarker = addMarker(coords);

        // if(confirm("Deseja substituir o ponto central do loteamento?")){

            lastMarker = auxMarker;
            frmUpdateLocation.submit();
        // } else{

        // }

    }
    
};