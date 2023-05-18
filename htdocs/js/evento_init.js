var id = parseInt(window.location.search.substr(4));
var dati = new FormData();
dati.append("id", id)
var res;
$.ajax({
	url: "php/trovaEvento.php",
	type: "POST",
	data: dati,
	success: function (resJ) {
		res = JSON.parse(resJ);
		// evento principale
		var focusSource = new ol.source.Vector({
		  features: new ol.format.GeoJSON().readFeatures(res[0], {featureProjection: 'EPSG:4326'})
		});
		var creaFrecciaFocus = function (feature) {
			var geometry = feature.getGeometry();
			var stile = [
				new ol.style.Style({
					image: new ol.style.Circle({
						fill: new ol.style.Fill({ color: 'rgba(255, 0, 255, 1)' }),
						stroke: new ol.style.Stroke({ color: 'rgba(255, 0, 255, 1)', width: 2 }),
						radius: 6
					}),
					stroke: new ol.style.Stroke({
						color: 'rgba(255, 0, 255, 1)',
						width: 2,
					})
				}),
			];
			if (geometry.getType() == 'LineString') {
				geometry.forEachSegment(function (start, end) {
					var dx = end[0] - start[0];
					var dy = end[1] - start[1];
					var rotation = Math.atan2(dy, dx);
					stile.push(
						new ol.style.Style({
							geometry: new ol.geom.Point(end),
							image: new ol.style.Icon({
								src: 'img/frecciaViola.png',
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
		var focusLayer = new ol.layer.Vector({
		  source: focusSource,
		  style: creaFrecciaFocus
		});
		// altri eventi
		var otherSource = new ol.source.Vector({
		  features: new ol.format.GeoJSON().readFeatures(res[1], {featureProjection: 'EPSG:4326'})
		});
		var creaFrecciaOther = function (feature) {
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
		var otherLayer = new ol.layer.Vector({
		  source: otherSource,
		  style: creaFrecciaOther
		});
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
				focusLayer,
				otherLayer
			],
			view: new ol.View({
				padding: [225, 225, 225, 225],
				projection: 'EPSG:4326'
			})
		});
		$('#map').data('map', map);
		// view
		map.getView().fit(focusSource.getExtent(), {maxZoom: 15});
	},
	cache: false,
	contentType: false,
	processData: false
});