var tipoGeom = parseInt(window.location.search.substring(6));
var dati = new FormData();
var res;
if (tipoGeom == 1) { // mappa dei punti
	$.ajax({
		url: "php/trovaLuoghiPunti.php",
		type: "POST",
		data: dati,
		success: function (resJ) {
			res = JSON.parse(resJ);
			// geojson
			var vectorSource = new ol.source.Vector({
			  features: new ol.format.GeoJSON().readFeatures(res, {featureProjection: 'EPSG:3857'})
			});
			// vettori
			var stile = new ol.style.Style({
				image: new ol.style.Circle({
					fill: new ol.style.Fill({ color: 'rgba(255, 0, 0, 0.1)' }),
					stroke: new ol.style.Stroke({ color: 'red', width: 2 }),
					radius: 6
				}),
				stroke: new ol.style.Stroke({
				  color: 'red',
				  width: 1,
				}),
				fill: new ol.style.Fill({
				  color: 'rgba(255, 0, 0, 0.1)',
				})
			});
			var vectorLayer = new ol.layer.Vector({
			  source: vectorSource,
			  style: stile
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
			var stileSelez = new ol.style.Style({
				image: new ol.style.Circle({
					fill: new ol.style.Fill({ color: 'rgba(255, 0, 255, 0.1)' }),
					stroke: new ol.style.Stroke({ color: 'rgba(255, 0, 255,1)', width: 2 }),
					radius: 6
				}),
				stroke: new ol.style.Stroke({
				  color: 'rgba(255, 0, 255,1)',
				  width: 1,
				}),
				fill: new ol.style.Fill({
				  color: 'rgba(255, 0, 255, 1)',
				})
			});
			var evtSelez = new ol.interaction.Select({style: stileSelez});
			evtSelez.on('select', function(evt) {
				if (evt.selected[0] != undefined) {
					var idSelez = evt.selected[0].get('id');
					var nameSelez = evt.selected[0].get('name');
					var nodoDatiSelez = document.getElementById('datiSelez');
					nodoDatiSelez.innerHTML = 'Id: ' + idSelez + '; Nome: ' + nameSelez + '.<br/><a href="./luogo.php?id=' + idSelez +'">Vai alla pagina</a>.';
				};
			});
			map.addInteraction(evtSelez);
		},
		cache: false,
		contentType: false,
		processData: false
	});	
} else { // mappa dei poligoni
	$.ajax({
		url: "php/trovaLuoghiPoli.php",
		type: "POST",
		data: dati,
		success: function (resJ) {
			res = JSON.parse(resJ);
			// geojson
			var vectorSource = new ol.source.Vector({
			  features: new ol.format.GeoJSON().readFeatures(res, {featureProjection: 'EPSG:3857'})
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
			map.getView().fit(vectorSource.getExtent());
			// selezione
			var stileSelez = new ol.style.Style({
				stroke: new ol.style.Stroke({
				  color: 'rgba(255, 0, 255, 1)',
				  width: 1,
				}),
				fill: new ol.style.Fill({
				  color: 'rgba(255, 0, 255, 0.1)',
				}),
			});
			var evtSelez = new ol.interaction.Select({style: stileSelez});
			evtSelez.on('select', function(evt) {
				if (evt.selected[0] != undefined) {
					var idSelez = evt.selected[0].get('id');
					var nameSelez = evt.selected[0].get('name');
					var nodoDatiSelez = document.getElementById('datiSelez');
					nodoDatiSelez.innerHTML = 'Id: ' + idSelez + '; Nome: ' + nameSelez + '.<br/><a href="./luogo.php?id=' + idSelez +'">Vedi più dettagli</a>.';
				};
			});
			map.addInteraction(evtSelez);
		},
		cache: false,
		contentType: false,
		processData: false
	});
};