var dati = new FormData();
var res;
$.ajax({
	url: "php/trovaEventi.php",
	type: "POST",
	data: dati,
	success: function (resJ) {
		res = JSON.parse(resJ);
		// geojson
		var vectorSource = new ol.source.Vector({
		  features: new ol.format.GeoJSON().readFeatures(res, {featureProjection: 'EPSG:3857'})
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
				padding: [40, 40, 40, 40],
				projection: 'EPSG:3857'
			})
		});
		$('#map').data('map', map);
		// view
		map.getView().fit(vectorSource.getExtent(), {maxZoom: 15});
		// selezione
		var frecciaSelez = function (feature) {
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
		var evtSelez = new ol.interaction.Select({style: frecciaSelez});
		evtSelez.on('select', function(evt) {
			if (evt.selected[0] != undefined) {
				var nodoDatiSelez = document.getElementById('datiSelez');
				var idSelez = evt.selected[0].get('id');
				var b1Selez = evt.selected[0].get('b1');
				var r1Selez = evt.selected[0].get('r1');
				var d1Selez = evt.selected[0].get('d1');
				var fSelez = evt.selected[0].get('f');
				if (evt.selected[0].get('b2') != undefined) {
					var b2Selez = evt.selected[0].get('b2');
					var r2Selez = evt.selected[0].get('r2');
					var d2Selez = evt.selected[0].get('d2');
					nodoDatiSelez.innerHTML = '<a href="./evento.php?id=' + idSelez + '">' + idSelez + '</a>: ' + r1Selez + ' <a href="./luogo.php?id=' + b1Selez + '">' + d1Selez + '</a> ' + fSelez + ' ' + r2Selez + ' <a href="./luogo.php?id=' + b2Selez + '">' + d2Selez + '</a>';
				} else {
					nodoDatiSelez.innerHTML = '<a href="./evento.php?id=' + idSelez + '">' + idSelez + '</a>: ' + r1Selez + ' <a href="./luogo.php?id=' + b1Selez + '">' + d1Selez + '</a> ' + fSelez;
				};
			};
		});
		map.addInteraction(evtSelez);
	},
	cache: false,
	contentType: false,
	processData: false
});