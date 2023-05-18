<?php
	$conn = pg_connect("host=localhost port=5432 user=postgres password=root dbname=benilun");
	if (!$conn) {
		die("Connessione PostgreSQL fallita.");
	};
	$res = pg_query($conn, "SELECT json_build_object( 'type', 'FeatureCollection', 'features', json_agg(ST_AsGeoJSON(t.*)::json) )
							FROM ( SELECT id, identificazione, punto FROM luogo ) as t(id, name, geom);");
	$obj_arr = pg_fetch_row($res);
	echo json_encode($obj_arr[0]);
?>