var dati = new FormData();
var res;
$.ajax({
	url: "php/trovaEventi.php",
	type: "POST",
	data: dati,
	success: function (resJ) { // controlla che il database contenga eventi
		res = JSON.parse(JSON.parse(resJ));
		if (res.features != null) { // controlla che il database contenga eventi
			// geojson
			var vectorSource = new ol.source.Vector({
			  features: new ol.format.GeoJSON().readFeatures(res)
			});
			// vettori
			var creaFreccia = function (feature) {
				var geometry = feature.getGeometry();
				var stile = [
					new ol.style.Style({
						image: new ol.style.Circle({
							fill: new ol.style.Fill({ color: 'rgba(255, 0, 0, 1)' }),
							stroke: new ol.style.Stroke({ color: 'rgba(255, 0, 0, 1)', width: 2 }),
							radius: 6
						}),
						stroke: new ol.style.Stroke({
							color: 'rgba(255, 0, 0, 1)',
							width: 2,
						})
					}),
				];
				// controllo: solo se la geometria è una linea
				if (geometry.getType() == 'LineString') {
					geometry.forEachSegment(function (start, end) {
						var dx = end[0] - start[0];
						var dy = end[1] - start[1];
						var rotation = Math.atan2(dy, dx);
						stile.push(
							new ol.style.Style({
								geometry: new ol.geom.Point(end),
								image: new ol.style.Icon({
									src: 'img/frecciaRossa.png',
									anchor: [0.5, 0.5],
									rotateWithView: true,
									rotation: -rotation,
								}),
							})
						);
					});
				};
				return stile;
			};
			var vectorLayer = new ol.layer.Vector({
			  source: vectorSource,
			  style: creaFreccia
			});
		} else {
			var vectorLayer = new ol.layer.Vector({
				source: new ol.source.Vector({})
			});
		};
		// scala
		var lineaScala = new ol.control.ScaleLine({
			bar: true,
			steps: 2,
			text: true
		});
		// mappa
		var map = new ol.Map({
			target: 'map',
			controls: ol.control.defaults().extend([lineaScala]),
			layers: [
				new ol.layer.Tile({
					source: new ol.source.OSM()
				}),
				vectorLayer
			],
			view: new ol.View({
				center: ol.proj.fromLonLat([10.1, 44.083333]), //Massa
				zoom: 10,
				padding: [40, 40, 40, 40],
				projection: 'EPSG:3857'
			})
		});
		$('#map').data('map', map);
		
		if (res.features != null) {
			// view
			map.getView().fit(vectorSource.getExtent(), {maxZoom: 15});
		};
	},
	cache: false,
	contentType: false,
	processData: false
});

var parametri = new URLSearchParams(window.location.search);
var tipoEven = parseInt(parametri.get("rela"));

var nodoTendL1 = document.getElementById('tendina_l1');
nodoTendL1.style.visibility = 'visible';
var nodoTendR1 = document.getElementById('tendina_r1');
nodoTendR1.style.visibility = 'visible';
var nodoTendL1 = document.getElementById('tendina_f');
nodoTendL1.style.visibility = 'visible';

if (tipoEven == 1) {
	var nodoTendL2 = document.getElementById('tendina_l2');
	nodoTendL2.style.visibility = 'visible';
	var nodoTendR2 = document.getElementById('tendina_r2');
	nodoTendR2.style.visibility = 'visible';
};