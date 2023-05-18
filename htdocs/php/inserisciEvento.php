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
	$user = 'acignoni';	//placeholder
	$stato = 'IN';	//placeholder
	if ($arrPrepared['tipoEven'] == 1) {
		$q = pg_prepare($conn, 'inserisciEventoRela',
						'INSERT INTO evento(bene1, denominazione_bene1, data_da, data_a, tipo_data,
											ruolo_bene1, funzione, bene2, denominazione_bene2, ruolo_bene2,
											bibliografia, schedatore, note, stato)
						VALUES ($1, $2, $3, $4, $5, $6, $7, $8, $9, $10, $11, $12, $13, $14)');
		$res = pg_execute($conn, 'inserisciEventoRela',
							array($arrPrepared['l1'], $arrPrepared['nuovCit1'], $arrPrepared['nuovDataDa'],
								$arrPrepared['nuovDataA'], $arrPrepared['nuovDataTipo'], $arrPrepared['r1'],
								$arrPrepared['f'], $arrPrepared['l2'], $arrPrepared['nuovCit2'],
								$arrPrepared['r2'], $arrPrepared['nuovBib'], $user,	$arrPrepared['nuovNot'],
								$stato));
	} else {
		$q = pg_prepare($conn, 'inserisciEventoSing',
						'INSERT INTO evento(bene1, denominazione_bene1, data_da, data_a, tipo_data,
											ruolo_bene1, funzione, bibliografia, schedatore, note, stato)
						VALUES ($1, $2, $3, $4, $5, $6, $7, $8, $9, $10, $11)');
		$res = pg_execute($conn, 'inserisciEventoSing',
							array($arrPrepared['l1'], $arrPrepared['nuovCit1'], $arrPrepared['nuovDataDa'],
								$arrPrepared['nuovDataA'], $arrPrepared['nuovDataTipo'], $arrPrepared['r1'],
								$arrPrepared['f'], $arrPrepared['nuovBib'], $user,	$arrPrepared['nuovNot'],
								$stato));
	};
	echo 'Evento inserito.';
?>