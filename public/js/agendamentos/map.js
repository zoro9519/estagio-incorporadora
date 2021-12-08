window.initMap = function () {
    console.log(LatLanding, LongLanding);
    var map = new google.maps.Map(document.getElementById('map'), {
        center: { lat: LatLanding, lng: LongLanding },
        zoom: ZoomLanding,
        // zoomControl: false,
        // mapTypeControl: false,
        streetViewControl: false
    });


    lotes.forEach((lote) => {
        // console.log(lote);
        let coordsLote = lote.coords.map((item) => {
            return new google.maps.LatLng(item.lat, item. lng);
        });

        let lotePolygon = new google.maps.Polygon({
            paths: coordsLote,
            strokeColor: coresLotes[lote.status],
            strokeOpacity: 0.8,
            strokeWeight: 2,
            fillColor: coresLotes[lote.status],
            fillOpacity: 0.35
        })

        lotePolygon.setMap(map);

        google.maps.event.addListener(lotePolygon, 'click', function() {
            switch(lote.status)
            {
                case 'L':
                
                    location.href = lote.url;
                    break;
                
                case 'R':
                    alert("Este lote está reservado. Entre em contato com a administração para mais detalhes");
                    break;

                default:
                    alert("Este lote não está mais disponível");
            }
        });

    })
}