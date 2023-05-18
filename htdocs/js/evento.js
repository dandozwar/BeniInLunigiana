function confermaEve (tipo) {
	var id = parseInt(window.location.search.substr(4));
	var nodoForm = document.getElementById('campi');
	var dati = new FormData(nodoForm);
	dati.append('id', id);
	dati.append('flagSing', tipo);
	var res;
	$.ajax({
		url: 'php/modificaEvento.php',
		type: 'POST',
		data: dati,
		success: function (resJ) {
			alert(resJ);
			tuttiInp = document.getElementsByTagName('input');
			for (i = 0; i < tuttiInp.length; i++) {
				if (tuttiInp[i].type == 'radio') {
					tuttiInp[i].checked = false; 
				};
			};
			location.reload();
		},
		cache: false,
		contentType: false,
		processData: false
	});
};

function modificaEve(tipo) {
	var id = parseInt(window.location.search.substr(4));
	var dati = new FormData();
	dati.append('id', id);
	dati.append('flagSing', tipo);
	var res;
	$.ajax({
		url: 'php/riempiEvento.php',
		type: "POST",
		data: dati,
		success: function (resJ) {
			res = JSON.parse(resJ);
			for (i = 0; i < res.length; i++) {
				if (res[i] === null) {
					res[i] = '';
				};
			};
			if (tipo == true) { // caso evento a 1
				nodoL1 = document.getElementById('campoL1');
				nodoL1.innerHTML = '<input id="nuovL1" name="nuovL1" type="text" value="' + res[11] +'"  readonly/>';
				nodoBib = document.getElementById('campoBib');
				nodoBib.innerHTML = '<input id="nuovBib" name="nuovBib" type="text" value="' + res[8] +'"/>';
				nodoNot = document.getElementById('campoNot');
				nodoNot.innerHTML = '<input id="nuovNot" name="nuovNot" type="text" value="' + res[10] +'"/>';
			} else { // caso evento a 2
				nodoL1 = document.getElementById('campoL1');
				nodoL1.innerHTML = '<input id="nuovL1" name="nuovL1" type="text" value="' + res[14] +'" readonly/>';
				nodoL2 = document.getElementById('campoL2');
				nodoL2.innerHTML = '<input id="nuovL2" name="nuovL2" type="text" value="' + res[15] +'" readonly/>';
				nodoR2 = document.getElementById('campoR2');
				nodoR2.innerHTML = '<input id="nuovR2" name="nuovR2" type="text" value="' + res[10] +'" readonly/>';
				nodoCit2 = document.getElementById('campoCit2');
				nodoCit2.innerHTML = '<input id="nuovCit2" name="nuovCit2" type="text" value="' + res[9] +'"/>';
				nodoBib = document.getElementById('campoBib');
				nodoBib.innerHTML = '<input id="nuovBib" name="nuovBib" type="text" value="' + res[11] +'"/>';
				nodoNot = document.getElementById('campoNot');
				nodoNot.innerHTML = '<input id="nuovNot" name="nuovNot" type="text" value="' + res[13] +'"/>';
				
				nodoTendL2 = document.getElementById('tendina_l2');
				nodoTendL2.style.visibility = 'visible';
				nodoTendR2 = document.getElementById('tendina_r2');
				nodoTendR2.style.visibility = 'visible';
			};
			nodoTendL1 = document.getElementById('tendina_l1');
			nodoTendL1.style.visibility = 'visible';
			nodoTendR1 = document.getElementById('tendina_r1');
			nodoTendR1.style.visibility = 'visible';
			nodoTendL1 = document.getElementById('tendina_f');
			nodoTendL1.style.visibility = 'visible';
			nodoModifica = document.getElementById('modifica');
			nodoModifica.setAttribute('hidden', 'hidden');
			nodoConferma = document.getElementById('conferma');
			nodoConferma.removeAttribute('hidden');
			nodoAnnulla = document.getElementById('annulla');
			nodoAnnulla.removeAttribute('hidden');
			
			nodoR1 = document.getElementById('campoR1');
			nodoR1.innerHTML = '<input id="nuovR1" name="nuovR1" type="text" value="' + res[6] +'" readonly/>';
			nodoCit1 = document.getElementById('campoCit1');
			nodoCit1.innerHTML = '<input id="nuovCit1" name="nuovCit1" type="text" value="' + res[2] +'"/>';
			nodoDataDa = document.getElementById('campoDataDa');
			nodoDataDa.innerHTML = '<input id="nuovDataDa" name="nuovDataDa" type="text" value="' + res[3] +'"/>';
			nodoDataA = document.getElementById('campoDataA');
			nodoDataA.innerHTML = '<input id="nuovDataA" name="nuovDataA" type="text" value="' + res[4] +'"/>';
			nodoDataTipo = document.getElementById('campoDataTipo');
			nodoDataTipo.innerHTML = '<input id="nuovDataTipo" name="nuovDataTipo" type="text" value="' + res[5] +'"/>';
			nodoFun = document.getElementById('campoF');
			nodoFun.innerHTML = '<input id="nuovF" name="nuovF" type="text" value="' + res[7] +'"  readonly/>';
	
		},
		cache: false,
		contentType: false,
		processData: false
	});
};

function annullaMod() {
	if (confirm('Annullare?')) {
		location.reload();
	};
};

function aggiorna(nodo, entita) {
	var id_vero;
	switch (entita) {
		case 'r1': id_vero = 'nuovR1'; break;
		case 'l1': id_vero = 'nuovL1'; break;
		case 'r2': id_vero = 'nuovR2'; break;
		case 'l2': id_vero = 'nuovL2'; break;
		case 'f': id_vero = 'nuovF'; break;
		default: alert('Errore!'); break;
	};
	var nodo_riempire = document.getElementById(id_vero)
	nodo_riempire.value = nodo.firstChild.innerHTML;
};