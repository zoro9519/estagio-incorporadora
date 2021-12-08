window.initMap = function () {

    google.maps.Polygon.prototype.hasPoint = function(point) { 
        var crossings = 0, path = this.getPath();

        // for each edge
        for (var i=0; i < path.getLength(); i++) {
            var a = path.getAt(i),
                j = i + 1;
            if (j >= path.getLength()) {
                j = 0;
            }
            var b = path.getAt(j);
            if (rayCrossesSegment(point, a, b)) {
                crossings++;
            }
        }
        
        // odd number of crossings?
        return (crossings % 2 == 1);
        
        function rayCrossesSegment(point, a, b) {
            var px = point.lng(),
                py = point.lat(),
                ax = a.lng(),
                ay = a.lat(),
                bx = b.lng(),
                by = b.lat();
            if (ay > by) {
                ax = b.lng();
                ay = b.lat();
                bx = a.lng();
                by = a.lat();
            }
            // alter longitude to cater for 180 degree crossings
            if (px < 0) { px += 360 };
            if (ax < 0) { ax += 360 };
            if (bx < 0) { bx += 360 };
        
            if (py == ay || py == by) py += 0.00000001;
            if ((py > by || py < ay) || (px > Math.max(ax, bx))) return false;
            if (px < Math.min(ax, bx)) return true;
        
            var red = (ax != bx) ? ((by - ay) / (bx - ax)) : Infinity;
            var blue = (ax != px) ? ((py - ay) / (px - ax)) : Infinity;
            return (blue >= red);
        
        }
    };

    var map = new google.maps.Map(document.getElementById('map'), {
        center: { lat: LatLanding, lng: LongLanding },
        zoom: ZoomLanding,
        // zoomControl: false,
        // mapTypeControl: false,
        streetViewControl: false
    });

    const drawingManager = new google.maps.drawing.DrawingManager({
        drawingMode: google.maps.drawing.OverlayType.POLYGON,
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

    quadraCoordsPolygon = quadraCoords.map((item) => {
        console.log(item);
        return new google.maps.LatLng(item.lat, item. lng);
    });

    // var quadraArea = google.maps.geometry.spherical.computeArea(quadraCoords);

    quadraPolygon = new google.maps.Polygon({
        paths: quadraCoordsPolygon,
        strokeColor: "#4F4F4F",
        strokeOpacity: 0.8,
        strokeWeight: 2,
        fillColor: "#4F4F4F",
        fillOpacity: 0.35
    })

    quadraPolygon.setMap(map);

    quadraLotes.forEach((lote) => {
        // console.log(lote);
        let coordsLote = lote.coords.map((item) => {
            return new google.maps.LatLng(item.lat, item. lng);
        });

        let lotePolygon = new google.maps.Polygon({
            paths: coordsLote,
            strokeColor: "#EEAD0E",
            strokeOpacity: 0.8,
            strokeWeight: 2,
            fillColor: "#EEAD0E",
            fillOpacity: 0.35
        })

        lotePolygon.setMap(map);
        google.maps.event.addListener(lotePolygon, 'click', function() {
            location.href = lote.url
        });
        lotesPolygons.push(lotePolygon);
    })


    google.maps.event.addListener(drawingManager, 'overlaycomplete', function (event) {

        let loteLatLngs = event.overlay.getPath().getArray();
        let novoLoteCoords = [];
        let success = false;

        novoLote = event.overlay;

        if(loteLatLngs.length < 3){
            alert("Forma não é um polígono");
        } else {
            let filterInterpolation = lotesPolygons.filter(lote =>  isPolygonOverlap(novoLote, lote)
            );
            if(filterInterpolation.length)
                alert("O novo lote está colidindo com outro(s)!");
            else {
                let filterOutside = loteLatLngs.filter(item => !quadraPolygon.hasPoint(item));

                if(filterOutside.length)
                    alert("O novo lote está fora da quadra!");
                else
                    success = true;
            }
        }

        if(success){
            loteLatLngs.forEach((item, i) => {
                let curr_lote_coords = {
                    lat: item.lat(),
                    lng: item.lng()
                };
                console.log("Adicionando " + JSON.stringify(curr_lote_coords));
                novoLoteCoords.push(curr_lote_coords);
            })

            criarCoords(novoLoteCoords);
            console.log(currentCoords);
            
            let area = google.maps.geometry.spherical.computeArea(novoLote.getPath());
            console.log("Area: " + area);
            
            if(area > 0){
                $("#txtArea").val(parseFloat(area).toFixed(2));
            }
            $("#add_method").val("map");
            $("#modal-add-lote").modal("show");
        } else {
            novoLote.setMap(null);
            
        }
        
    });


    let btnSaveNewLocation = document.getElementById("btnSaveLocation");
    $(btnSaveNewLocation).on("click", (e) => {
        e.preventDefault();

        let txtZoom = document.getElementById("txtZoom");
        txtZoom.value = map.getZoom() || 7;
        let frmUpdateLocation = document.getElementById("frmUpdateLocation");
        frmUpdateLocation.submit();
    });

    $("#btnAddCoordLote").on("click", criarCoord);
    $(".btnRemoveCoord").on("click", removeCoord);
};


// Adicionar Lote

let lotesPolygons = [];
let novoLote = false;
let currentCoords = [];

function criarCoords(coords)
{
    coords.forEach(item => {
        console.log("Adicionando" + JSON.stringify(item));
        criarCoord(item.lat, item.lng)
    });
}

function criarCoord(lat, lng){
    let lista = $("#listLoteCoords");
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
                <input type="number" min="-180" max="180" name="latitudes_lote[]" value="${lat}" ${ blockEdit ? "readonly" : ""} class="form-control" required>
            </div>
            <div class="col-6">
                Longitude
                <input type="number" min="-180" max="180" name="longitudes_lote[]" value="${lng}" ${ blockEdit ? "readonly" : ""} class="form-control" required>
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
        let lista = $("#listLoteCoords");
        let item = $("#coord-" + pos);

        $(item).remove();
        currentCoords = currentCoords.filter((item, i) => item.i != pos);
    }
}

function removeAllCoords() {
    currentCoords.forEach((item, i) => removeCoord(i));
}

$("#modal-add-lote").on("hidden.bs.modal", (e) => {
    let add_method = $("#add_method");

    if(add_method.val() == 'map'){
        e.preventDefault();
        // if(confirm("Deseja cancelar a criação dessa lote?")){
            removeAllCoords();
            if(novoLote !== false){
                // Remove lote do mapa
                novoLote.setMap(null);
            }
            $(add_method).val("basic");
        // }
    }
});