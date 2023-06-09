var dati = new FormData();
var res;
$.ajax({
	url: "php/trovaLuoghiPoli.php",
	type: "POST",
	data: dati,
	success: function (resJ) {
		res = JSON.parse(JSON.parse(resJ));
		if (res.features != null) { // controlla che il database contenga luoghi
			// geojson
			var vectorSource = new ol.source.Vector({
				features: new ol.format.GeoJSON().readFeatures(res)
			});
			// vettori
			var stile = new ol.style.Style({
				stroke: new ol.style.Stroke({
				  color: 'red',
				  width: 1,
				}),
				fill: new ol.style.Fill({
				  color: 'rgba(255, 0, 0, 0.1)',
				}),
			});
			var vectorLayer = new ol.layer.Vector({
			  source: vectorSource,
			  style: stile
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
		// gestione del nuovo luogo
		var stileCrea = new ol.style.Style({
			stroke: new ol.style.Stroke({
				color: 'blue',
				width: 1,
			}),
			fill: new ol.style.Fill({
				color: 'rgba(0, 0, 255, 0.1)',
			}),
		});
		var stileNuovo = new ol.style.Style({
			stroke: new ol.style.Stroke({
				color: 'green',
				width: 1,
			}),
			fill: new ol.style.Fill({
				color: 'rgba(0, 255, 0, 0.1)',
			}),
		});
		var vettoreNuovo = new ol.source.Vector({});
		var layerNuovo = new ol.layer.Vector({
			source: vettoreNuovo,
			style: stileNuovo
		});
		var evtNuovo = new ol.interaction.Draw({
			type: 'MultiPolygon',
			style: stileCrea
		});
		evtNuovo.on('drawend', function(evt) {
			vettoreNuovo.addFeature(evt.feature);
			alert('finito!');
		});
		map.addLayer(layerNuovo);
		map.getInteractions().pop();
		map.addInteraction(evtNuovo)
		if (res.features != null) {
			// view
			map.getView().fit(vectorSource.getExtent());	
		};
	},
	cache: false,
	contentType: false,
	processData: false
});