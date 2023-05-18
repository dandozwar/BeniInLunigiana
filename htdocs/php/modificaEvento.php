<?php
	$conn = pg_connect("host=localhost port=5432 user=postgres password=root dbname=benilun");
	if (!$conn) {
		die("Connessione PostgreSQL fallita.");
	};
	$arrPrepared = array();
	foreach ($_POST as $chiave => $valore) {
		if ($valore == "") {
			$nuovVal = NULL;
		} else {
			$nuovVal = $valore;
		};
		$arrPrepared[$chiave] = $nuovVal;
	};
	$q = pg_prepare($conn, 'modificaEventoStandard',
					'UPDATE evento
					SET (denominazione_bene1, data_da, data_a, tipo_data, bibliografia, note) =
					($1, $2, $3, $4, $5, $6)
					WHERE id = $7');
	$res = pg_execute($conn, 'modificaEventoStandard',
						array($arrPrepared['nuovCit1'], $arrPrepared['nuovDataDa'],
							$arrPrepared['nuovDataA'], $arrPrepared['nuovDataTipo'],
							$arrPrepared['nuovBib'], $arrPrepared['nuovNot'],
							$arrPrepared['id']));
	if (isset($arrPrepared['l1'])) {
		$q = pg_prepare($conn, 'modificaEventoLuogo1',
						'UPDATE evento SET bene1 = $1 WHERE id = $2');
		$res = pg_execute($conn, 'modificaEventoLuogo1', array($arrPrepared['l1'], $arrPrepared['id']));
	};
	if (isset($arrPrepared['r1'])) {
		$q = pg_prepare($conn, 'modificaEventoRuolo1',
						'UPDATE evento SET ruolo_bene1 = $1 WHERE id = $2');
		$res = pg_execute($conn, 'modificaEventoRuolo1', array($arrPrepared['r1'], $arrPrepared['id']));
	};
	if (isset($arrPrepared['f'])) {
		$q = pg_prepare($conn, 'modificaEventoFunz',
						'UPDATE evento SET funzione = $1 WHERE id = $2');
		$res = pg_execute($conn, 'modificaEventoFunz', array($arrPrepared['f'], $arrPrepared['id']));			
	};
		if (isset($arrPrepared['l2'])) {
		$q = pg_prepare($conn, 'modificaEventoLuogo2',
						'UPDATE evento SET bene2 = $1 WHERE id = $2');
		$res = pg_execute($conn, 'modificaEventoLuogo2', array($arrPrepared['l2'], $arrPrepared['id']));
	};
	if (isset($arrPrepared['r2'])) {
		$q = pg_prepare($conn, 'modificaEventoRuolo2',
						'UPDATE evento SET ruolo_bene2 = $1 WHERE id = $2');
		$res = pg_execute($conn, 'modificaEventoRuolo2', array($arrPrepared['r2'], $arrPrepared['id']));
	};
	echo 'Evento aggiornato.';
?>