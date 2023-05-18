function confermaAlfa () {
	var id = parseInt(window.location.search.substr(4));
	var nodoForm = document.getElementById('campi');
	var dati = new FormData(nodoForm);
	dati.append('id', id);
	var res;
	$.ajax({
		url: 'php/modificaLuogoAlfa.php',
		type: 'POST',
		data: dati,
		success: function (resJ) {
			alert(resJ);
			if (resJ != 'Inserire un nome valido.') {
				location.reload();
			};
		},
		cache: false,
		contentType: false,
		processData: false
	});
};

function modificaAlfa() {
	var id = parseInt(window.location.search.substr(4));
	var dati = new FormData();
	dati.append('id', id);
	var res;
	$.ajax({
		url: 'php/riempiLuogo.php',
		type: "POST",
		data: dati,
		success: function (resJ) {
			res = JSON.parse(resJ);
			for (i = 0; i < res.length; i++) {
				if (res[i] === null) {
					res[i] = '';
				};
			};
			nodoNom = document.getElementById('campoNom');
			nodoNom.innerHTML = '<input id="nuovNom" name="nuovNom" type="text" value="' + res[1] +'"/>';
			nodoDes = document.getElementById('campoDes');
			nodoDes.innerHTML = '<input id="nuovDes" name="nuovDes" type="text" value="' + res[2] +'"/>';
			nodoMEO = document.getElementById('campoMEO');
			nodoMEO.innerHTML = '<input id="nuovMEO" name="nuovMEO" type="text" value="' + res[3] +'"/>';
			nodoMEC = document.getElementById('campoMEC');
			nodoMEC.innerHTML = '<input id="nuovMEC" name="nuovMEC" type="text" value="' + res[4] +'"/>';
			nodoEsi = document.getElementById('campoEsi');
			nodoEsi.innerHTML = '<input id="nuovEsi" name="nuovEsi" type="text" value="' + res[6] +'"/>';
			nodoTop = document.getElementById('campoTop');
			nodoTop.innerHTML = '<input id="nuovTop" name="nuovTop" type="text" value="' + res[5] +'"/>';
			nodoCom = document.getElementById('campoCom');
			nodoCom.innerHTML = '<input id="nuovCom" name="nuovCom" type="text" value="' + res[7] +'"/>';
			nodoBib = document.getElementById('campoBib');
			nodoBib.innerHTML = '<input id="nuovBib" name="nuovBib" type="text" value="' + res[8] +'"/>';
			nodoNot = document.getElementById('campoNot');
			nodoNot.innerHTML = '<input id="nuovNot" name="nuovNot" type="text" value="' + res[10] +'"/>';
			
			nodoModiAlfa = document.getElementById('modiAlfa');
			nodoModiAlfa.setAttribute('hidden', 'hidden');
			nodoModiGeog = document.getElementById('modiGeog');
			nodoModiGeog.setAttribute('hidden', 'hidden');
			nodoConfAlfa = document.getElementById('confAlfa');
			nodoConfAlfa.removeAttribute('hidden');
			nodoAnnulla = document.getElementById('annulla');
			nodoAnnulla.removeAttribute('hidden');
		},
		cache: false,
		contentType: false,
		processData: false
	});
};

function confermaGeog() {
	var map = $('#map').data('map');
	var layerNuovo = map.getLayers().item(2);
	var nuovaFeature = layerNuovo.getSource().getFeatures()[0];
	if (nuovaFeature != undefined) {
		var id = parseInt(window.location.search.substr(4));
		nuovaFeature.setProperties({'name': id});
		var geoNuovo = new ol.format.GeoJSON().writeFeatureObject(nuovaFeature, { 'featureProjection': 'EPSG:3857'});
		var geoString = JSON.stringify(geoNuovo);
		var dati = new FormData();
		dati.append('geoJSON', geoString);
		$.ajax({
			url: "php/modificaLuogoGeog.php",
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

function modificaGeog() {
	alert('Disegna la nuova sagoma del bene sulla mappa');
	
	nodoModiAlfa = document.getElementById('modiAlfa');
	nodoModiAlfa.setAttribute('hidden', 'hidden');
	nodoModiGeog = document.getElementById('modiGeog');
	nodoModiGeog.setAttribute('hidden', 'hidden');
	nodoConfAlfa = document.getElementById('confGeog');
	nodoConfAlfa.removeAttribute('hidden');
	nodoAnnulla = document.getElementById('annulla');
	nodoAnnulla.removeAttribute('hidden');
	
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
};

function annullaMod() {
	if (confirm('Annullare?')) {
		location.reload();
	};
};