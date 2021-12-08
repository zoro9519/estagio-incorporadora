window.initMap = function () {

    var map = new google.maps.Map(document.getElementById('map'), {
        center: { lat: LatLanding, lng: LongLanding },
        zoom: ZoomLanding,
        // zoomControl: false,
        // mapTypeControl: false,
        streetViewControl: false
    });


    const drawingManager = new google.maps.drawing.DrawingManager({
        drawingControl: true,
        drawingControlOptions: {
            position: google.maps.ControlPosition.TOP_CENTER,
            drawingModes: [
                google.maps.drawing.OverlayType.POLYGON,
                // google.maps.drawing.OverlayType.POLYLINE,
            ],
        },
    });

    drawingManager.setMap(map);

    loteamentoQuadras.forEach((quadra) => {
        // console.log(quadra);
        let coordsQuadra = quadra.coords.map((item) => {
            return new google.maps.LatLng(item.lat, item. lng);
        });

        let quadraPolygon = new google.maps.Polygon({
            paths: coordsQuadra,
            strokeColor: "#FF0000",
            strokeOpacity: 0.8,
            strokePosition: google.maps.StrokePosition.OUTSIDE,
            strokeWeight: 2,
            fillColor: "#FF0000",
            fillOpacity: 0.35
        })

        quadraPolygon.setMap(map);
        google.maps.event.addListener(quadraPolygon, 'click', function() {
            location.href = quadra.url
        });

        quadrasPolygons.push(quadraPolygon);
    })

    google.maps.event.addListener(drawingManager, 'overlaycomplete', function (event) {
        let success = false;
        let quadraLatLngs = event.overlay.getPath().getArray();
        let novaQuadraCoords = [];
        novaQuadra = event.overlay;
        
        if(quadraLatLngs.length < 3){
            alert("Forma não é um polígono");
        } else {
            let filterInterpolation = quadrasPolygons.filter(quadra =>  isPolygonOverlap(novaQuadra, quadra)
            );
            if(filterInterpolation.length)
                alert("A nova quadra está colidindo com outra(s)!");
            else
                success = true;
        }

        if(success){
            quadraLatLngs.forEach((item, i) => {
                let curr_quadra_coords = {
                    lat: item.lat(),
                    lng: item.lng()
                };
                novaQuadraCoords.push(curr_quadra_coords);
            })
            // console.log(currentCoords);
            criarCoords(novaQuadraCoords);
            $("#add_method").val("map");
            $("#modal-add-quadra").modal("show");
        } else {
            novaQuadra.setMap(null);
        }
        
    });

    // 
    // Salvando ponto central do loteamento
    // 

    var centralMarker = false;
    let coords = {
        lat: LatLanding,
        lng: LongLanding,
        zoom: ZoomLanding
    };
    centralMarker = addMarker(coords);


    function addMarker(coords) {
        const marker = new google.maps.Marker({
            position: coords,
            map: map,
            draggable: true
        });
        return marker
    }

    let btnSaveNewLocation = document.getElementById("btnSaveLocation");
    let txtLatitude = document.getElementById("txtLatitude");
    let txtLongitude = document.getElementById("txtLongitude");
    let txtZoom = document.getElementById("txtZoom");

    centralMarker.addListener("dragend", function(e){
        coords = {
            lat: e.latLng.lat(),
            lng: e.latLng.lng()
        };

        btnSaveNewLocation.style.display = "block";

        txtLatitude.value = coords.lat;
        txtLongitude.value = coords.lng;
    });

    $(btnSaveNewLocation).on("click", (e) => {
        e.preventDefault();
        txtZoom.value = map.getZoom() || 7;
        let frmUpdateLocation = document.getElementById("frmUpdateLocation");
        frmUpdateLocation.submit();
    });

    $("#btnAddCoordQuadra").on("click", criarCoord);
    $(".btnRemoveCoord").on("click", removeCoord);
};


// Adicionar Quadra

let quadrasPolygons = [];
let novaQuadra = false;
let currentCoords = [];


function criarCoords(coords)
{
    coords.forEach(item => {
        console.log("Adicionando" + JSON.stringify(item));
        criarCoord(item.lat, item.lng)
    });
}

function criarCoord(lat, lng){
    let lista = $("#listQuadraCoords");
    let blockEdit = lat && lng;

    if(!lat)
        lat = "";
    if(!lng)
        lng = "";

    let pos = currentCoords.length;
    item = $("<div />");
    item.html(`
    <div class="form-group" id="coord-${pos}">
        <label>Coordenada: ${blockEdit ? 
            "" : 
            `<a class="badge badge-warning" id="btnRemoveCoord" onclick="removeCoord(${pos})">Remover</a>`}
        </label>
        <div class="row">
            <div class="col-6">
                Latitude
                <input type="number" min="-180" max="180" name="latitudes_quadra[]" value="${lat}" ${ blockEdit ? "readonly" : ""} class="form-control" required>
            </div>
            <div class="col-6">
                Longitude
                <input type="number" min="-180" max="180" name="longitudes_quadra[]" value="${lng}" ${ blockEdit ? "readonly" : ""} class="form-control" required>
            </div>
        </div>
    </div>`);
    currentCoords.push(
        {
            "i": currentCoords.length,
            "lat": lat,
            "lng": lng
        }
    );
    $(lista).append(item);
}

function removeCoord(pos){
    if(pos >= 0 && currentCoords.length){ 
        let lista = $("#listQuadraCoords");
        let item = $("#coord-" + pos);

        $(item).remove();
        currentCoords = currentCoords.filter((item, i) => item.i != pos);
    }
}

function removeAllCoords() {
    currentCoords.forEach((item, i) => removeCoord(i));
}

$("#modal-add-quadra").on("hidden.bs.modal", (e) => {
    let add_method = $("#add_method");

    if(add_method.val() == 'map'){
        e.preventDefault();
        // if(confirm("Deseja cancelar a criação dessa quadra?")){
            removeAllCoords();
            if(novaQuadra !== false){
                // Remove quadra do mapa
                novaQuadra.setMap(null);
            }
            // console.log(currentCoords);
            $(add_method).val("basic");
        // }
    }
});
