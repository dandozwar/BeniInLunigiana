function confermaEvento() {
	var parametri = new URLSearchParams(window.location.search);
	var tipoEven = parseInt(parametri.get('rela'));
	// possibili errori di inserimento
	var errori = [];
	if ($('input[name=l1]:checked').length == 0) {
		if (tipoEven == 1) {
			errori.push('luogo 1');
		} else {
			errori.push('luogo');
		};
	};
	if ($('input[name=f]:checked').length == 0) {
		errori.push('funzione');
	};
	if (tipoEven == 1) {
		if ($('input[name=l2]:checked').length == 0) {
			errori.push('luogo 2');
		};
	};
	var nodoData = document.getElementById('nuovDataDa');
	if (nodoData.value == "") {
		errori.push('data da');
	};
	if (errori.length != 0) {
		messaggio = 'Selezionare: ' + errori[0];
		for (var e = 1; e < errori.length; e++) {
			messaggio += ', ' + errori[e];
		};
		messaggio += '.';
		alert(messaggio);
	} else {	//inserimento
		var nodoForm = document.getElementById('campi');
		var dati = new FormData(nodoForm);
		dati.append('tipoEven', tipoEven);
		$.ajax({
			url: 'php/inserisciEvento.php',
			type: 'POST',
			data: dati,
			success: function (resJ) {
				alert(resJ);
				window.location.replace('./listaEventi.php');
			},
			cache: false,
			contentType: false,
			processData: false
		});
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