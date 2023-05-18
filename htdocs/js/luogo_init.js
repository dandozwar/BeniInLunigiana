var parametri = new URLSearchParams(window.location.search);
var id = parseInt(parametri.get("id"));
var tipoGeom = parseInt(parametri.get("geom"));
var dati = new FormData();
dati.append("id", id)

var res;
if (tipoGeom == 1) {
	$.ajax({
		url: "php/trovaLuogoPunto.php",
		type: "POST",
		data: dati,
		success: function (resJ) {
			res = JSON.parse(resJ);
				// luogo principale
				var focusSource = new ol.source.Vector({
				  features: new ol.format.GeoJSON().readFeatures(res[0], {featureProjection: 'EPSG:4326'})
				});
				var stileFocus = new ol.style.Style({
					image: new ol.style.Circle({
						fill: new ol.style.Fill({ color: 'rgba(255, 0, 255, 0.1)' }),
						stroke: new ol.style.Stroke({ color: 'rgba(255, 0, 255, 1)', width: 2 }),
						radius: 6
					}),
					stroke: new ol.style.Stroke({
					  color: 'rgba(255, 0, 255, 1)',
					  width: 1,
					}),
					fill: new ol.style.Fill({
					  color: 'rgba(255, 0, 255, 0.1)',
					})
				});
				var focusLayer = new ol.layer.Vector({
				  source: focusSource,
				  style: stileFocus
				});
				// altri luoghi
				var otherSource = new ol.source.Vector({
				  features: new ol.format.GeoJSON().readFeatures(res[1], {featureProjection: 'EPSG:4326'})
				});
				var otherFocus = new ol.style.Style({
					image: new ol.style.Circle({
						fill: new ol.style.Fill({ color: 'rgba(255, 0, 0, 0.1)' }),
						stroke: new ol.style.Stroke({ color: 'rgba(255, 0, 0, 1)', width: 2 }),
						radius: 6
					}),
					stroke: new ol.style.Stroke({
					  color: 'rgba(255, 0, 0, 1)',
					  width: 1,
					}),
					fill: new ol.style.Fill({
					  color: 'rgba(255, 0, 0, 0.1)',
					})
				});
				var otherLayer = new ol.layer.Vector({
				  source: otherSource,
				  style: otherFocus
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
} else {
	$.ajax({
		url: "php/trovaLuogoPoli.php",
		type: "POST",
		data: dati,
		success: function (resJ) {
			res = JSON.parse(resJ);
				// luogo principale
				var focusSource = new ol.source.Vector({
				  features: new ol.format.GeoJSON().readFeatures(res[0], {featureProjection: 'EPSG:4326'})
				});
				var stileFocus = new ol.style.Style({
					image: new ol.style.Circle({
						fill: new ol.style.Fill({ color: 'rgba(255, 0, 255, 0.1)' }),
						stroke: new ol.style.Stroke({ color: 'rgba(255, 0, 255, 1)', width: 2 }),
						radius: 6
					}),
					stroke: new ol.style.Stroke({
					  color: 'rgba(255, 0, 255, 1)',
					  width: 1,
					}),
					fill: new ol.style.Fill({
					  color: 'rgba(255, 0, 255, 0.1)',
					})
				});
				var focusLayer = new ol.layer.Vector({
				  source: focusSource,
				  style: stileFocus
				});
				// altri luoghi
				var otherSource = new ol.source.Vector({
				  features: new ol.format.GeoJSON().readFeatures(res[1], {featureProjection: 'EPSG:4326'})
				});
				var otherFocus = new ol.style.Style({
					image: new ol.style.Circle({
						fill: new ol.style.Fill({ color: 'rgba(255, 0, 0, 0.1)' }),
						stroke: new ol.style.Stroke({ color: 'rgba(255, 0, 0, 1)', width: 2 }),
						radius: 6
					}),
					stroke: new ol.style.Stroke({
					  color: 'rgba(255, 0, 0, 1)',
					  width: 1,
					}),
					fill: new ol.style.Fill({
					  color: 'rgba(255, 0, 0, 0.1)',
					})
				});
				var otherLayer = new ol.layer.Vector({
				  source: otherSource,
				  style: otherFocus
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
				map.getView().fit(focusSource.getExtent());
		},
		cache: false,
		contentType: false,
		processData: false
	});
};