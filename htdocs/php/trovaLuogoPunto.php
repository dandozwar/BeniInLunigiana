<?php
	$conn = pg_connect("host=localhost port=5432 user=postgres password=root dbname=benilun");
	if (!$conn) {
		die("Connessione PostgreSQL fallita.");
	};
	$obj_arr = array();
	$q1 = pg_query($conn, "SELECT json_build_object( 'type', 'FeatureCollection', 'features', json_agg(ST_AsGeoJSON(t.*)::json) )
							FROM ( SELECT id, identificazione, punto FROM luogo WHERE id = ".$_POST['id'].") as t(id, name, geom);");
	$res1 = pg_fetch_row($q1);
	array_push($obj_arr, $res1[0]);
	$q2 = pg_query($conn, "SELECT json_build_object( 'type', 'FeatureCollection', 'features', json_agg(ST_AsGeoJSON(t.*)::json) )
							FROM ( SELECT id, identificazione, punto FROM luogo WHERE id != ".$_POST['id'].") as t(id, name, geom);");
	$res2 = pg_fetch_row($q2);
	array_push($obj_arr, $res2[0]);
	echo json_encode($obj_arr);
?>