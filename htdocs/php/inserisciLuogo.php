<?php
	$conn = pg_connect("host=localhost port=5432 user=postgres password=root dbname=benilun");
	if (!$conn) {
		die("Connessione PostgreSQL fallita.");
	};
	$gjStr = $_POST['geoJSON'];
	$gjObj = json_decode($gjStr);
	$geom = json_encode($gjObj->geometry);
	$user = 'acignoni';
	$stato = 'IN';
	$q = pg_prepare($conn, 'inserisciLuogo',
					'INSERT INTO luogo(identificazione, descrizione, meo, mec, toponimo, esistenza, comune,
										bibliografia, note, area, punto, schedatore, stato)
					VALUES ($1, $2, $3, $4, $5, $6, $7, $8, $9, ST_Transform(ST_GeomFromGeoJSON($10), 3857),
							ST_PointOnSurface(ST_Transform(ST_GeomFromGeoJSON($10), 3857)), $11, $12)');
	$q = pg_execute($conn, 'inserisciLuogo', array($_POST['nuovNom'], $_POST['nuovDes'], $_POST['nuovMEO'],
													$_POST['nuovMEC'], $_POST['nuovEsi'], $_POST['nuovTop'],
													$_POST['nuovCom'], $_POST['nuovBib'], $_POST['nuovNot'],
													$geom, $user, $stato));
	echo 'Luogo inserito.';
?>