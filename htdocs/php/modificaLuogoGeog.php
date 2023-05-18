<?php
	$conn = pg_connect("host=localhost port=5432 user=postgres password=root dbname=benilun");
	if (!$conn) {
		die("Connessione PostgreSQL fallita.");
	};
	$gjStr = $_POST['geoJSON'];
	$gjObj = json_decode($gjStr);
	$id = $gjObj->properties->name;
	$geom = json_encode($gjObj->geometry);
	$user = 'acignoni';
	$stato = 'IN';
	$q = pg_prepare($conn, 'modificaLuogoGeog',
					'UPDATE luogo
					SET (area, punto) = (ST_GeomFromGeoJSON($2), ST_PointOnSurface(ST_GeomFromGeoJSON($2)))
					WHERE id = $1');
	$q = pg_execute($conn, 'modificaLuogoGeog', array($id, $geom));
	echo 'Luogo aggiornato.';
?>