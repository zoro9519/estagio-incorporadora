function UseWicketToGoFromGooglePolysToWKT(poly1, poly2) {
    var wicket = new Wkt.Wkt();

    wicket.fromObject(poly1);
    var wkt1 = wicket.write();

    wicket.fromObject(poly2);
    var wkt2 = wicket.write();

    return [wkt1, wkt2];
}

function UseJstsToTestForIntersection(wkt1, wkt2) {
    // Instantiate JSTS WKTReader and get two JSTS geometry objects
    var wktReader = new jsts.io.WKTReader();
    var geom1 = wktReader.read(wkt1);
    var geom2 = wktReader.read(wkt2);

    return geom2.intersects(geom1);
}

function isPolygonOverlap(pol1, pol2){
    let wkt = UseWicketToGoFromGooglePolysToWKT(pol1, pol2);
    return UseJstsToTestForIntersection(wkt[0], wkt[1]);
}