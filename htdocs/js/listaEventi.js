function confermaEvento() {
	/*
	var nomeNuovo = document.getElementById('nomeNuovo');
	if (nomeNuovo.value == "") {
		alert("Inserire nome del luogo.");
	} else {
		var map = $('#map').data('map');
		var layerNuovo = map.getLayers().item(2);
		var nuovaFeature = layerNuovo.getSource().getFeatures()[0];
		if (nuovaFeature != undefined) {
			nuovaFeature.setProperties({'name': nomeNuovo.value});
			var geoNuovo = new ol.format.GeoJSON().writeFeatureObject(nuovaFeature, { 'featureProjection': 'EPSG:4326'});
			var geoString = JSON.stringify(geoNuovo);
			var dati = new FormData();
			dati.append('geoJSON', geoString);
			$.ajax({
				url: "php/inserisciLuogo.php",
				type: "POST",
				data: dati,
				success: function (resJ) {
					alert(resJ);
					location.reload();
				},
				cache: false,
				contentType: false,
				processData: false
			});
		} else {
			alert('Disegnare la sagoma del luogo prima di confermare.');
		};
	};
	*/
};

function nuovoEvento() {
	/*
	var nodoLink = document.getElementById('linkNuovo');
	nodoLink.value = 'Conferma';
	nodoLink.parentNode.insertAdjacentHTML('afterbegin', ' \
		<label for="nomeNuovo">Nome:</label><input type="text" id="nomeNuovo" name="nomeNuovo" maxlength="256"/><br/> \
	');
	nodoLink.setAttribute('onclick', 'confermaLuogo()');
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
	var vettoreNuovo = new ol.source.Vector({
	});
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
	var map = $('#map').data('map');
	map.addLayer(layerNuovo);
	map.getInteractions().pop();
	map.addInteraction(evtNuovo);
	*/
};