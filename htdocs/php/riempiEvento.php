<?php
	$conn = pg_connect("host=localhost port=5432 user=postgres password=root dbname=benilun");
	if (!$conn) {
		die("Connessione PostgreSQL fallita.");
	};
	if ($_POST['flagSing'] == 1) { // caso evento a 1
		$res = pg_query($conn, 'SELECT evento.id, bene1, denominazione_bene1, data_da, data_a, tipo_data,
									r1.ruolo, funzione.funzione, evento.bibliografia, evento.schedatore,
									evento.note, l1.identificazione
								FROM evento, funzione, ruolo AS r1, luogo AS l1
								WHERE evento.funzione = funzione.id AND ruolo_bene1 = r1.id AND
									 bene1 = l1.id AND evento.id = '.$_POST['id']);
	} else { // caso evento a 2
		$res = pg_query($conn, 'SELECT evento.id, bene1, denominazione_bene1, data_da, data_a, tipo_data,
									r1.ruolo, funzione.funzione, bene2, denominazione_bene2, r2.ruolo,
									evento.bibliografia, evento.schedatore, evento.note, l1.identificazione,
									l2.identificazione
								FROM evento, funzione, ruolo AS r1, ruolo AS r2, luogo AS l1, luogo AS l2
								WHERE evento.funzione = funzione.id AND ruolo_bene1 = r1.id AND
									ruolo_bene2 = r2.id AND bene1 = l1.id AND bene2 = l2.id AND
									evento.id = '.$_POST['id']);	
	};
	$even = pg_fetch_row($res);
	echo json_encode($even);
?>