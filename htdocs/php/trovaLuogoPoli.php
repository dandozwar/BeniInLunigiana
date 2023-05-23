<?php
	$conn = pg_connect("host=localhost port=5432 user=postgres password=root dbname=benilun");
	if (!$conn) {
		die("Connessione PostgreSQL fallita.");
	};
	
	$q = pg_query($conn, "SELECT json_build_object( 'type', 'FeatureCollection', 'features', json_agg(ST_AsGeoJSON(t.*)::json) )
							FROM ( SELECT id, identificazione, area FROM luogo ORDER BY
							CASE id
								WHEN ".$_POST['id']." THEN 1
								ELSE 2
							END ) as t(id, name, geom);");
	$res = pg_fetch_row($q);
	echo json_encode($res[0]);
?>