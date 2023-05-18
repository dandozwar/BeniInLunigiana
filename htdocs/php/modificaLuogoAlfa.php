<?php
	$conn = pg_connect("host=localhost port=5432 user=postgres password=root dbname=benilun");
	if (!$conn) {
		die("Connessione PostgreSQL fallita.");
	};
	if (strlen($_POST['nuovNom']) < 3) {
		echo('Lunghezza identificazione minima: 3 lettere.');
	} else {
		$arrPrepared = array();
		foreach ($_POST as $chiave => $valore) {
			if ($valore == "") {
				$nuovVal = NULL;
			} else {
				$nuovVal = $valore;
			};
			$arrPrepared[$chiave] = $nuovVal;
		};
		$q = pg_prepare($conn, 'modificaLuogoAlfa',
						'UPDATE luogo
						SET (identificazione, descrizione, meo, mec, esistenza,
							toponimo, comune, bibliografia, note) = ($1, $2, $3,
							$4, $5, $6, $7, $8, $9)
						WHERE id = $10');
		$res = pg_execute($conn, 'modificaLuogoAlfa', $arrPrepared);
		echo 'Luogo aggiornato.';
	};
?>