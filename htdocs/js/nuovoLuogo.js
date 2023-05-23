function confermaLuogo() {
	var nomeNuovo = document.getElementById('nuovNom');
	if (nomeNuovo.value == "") {
		alert("Inserire nome del luogo.");
	} else {
		var map = $('#map').data('map');
		var layerNuovo = map.getLayers().item(2);
		var nuovaFeature = layerNuovo.getSource().getFeatures()[0];
		if (nuovaFeature != undefined) {
			nuovaFeature.setProperties({'name': nomeNuovo.value});
			var geoNuovo = new ol.format.GeoJSON().writeFeatureObject(nuovaFeature, {'featureProjection': 'EPSG:3857'});
			var geoString = JSON.stringify(geoNuovo);
			alert(geoString);
			var dati = new FormData(document.getElementById('campi'));
			dati.append('geoJSON', geoString);
			$.ajax({
				url: "php/inserisciLuogo.php",
				type: "POST",
				data: dati,
				success: function (resJ) {
					alert(resJ);
					if (resJ == "Luogo inserito.") {
						window.location.replace('./listaLuoghi.php');
					};
				},
				cache: false,
				contentType: false,
				processData: false
			});
		} else {
			alert('Disegnare la sagoma del luogo prima di confermare.');
		};
	};
};