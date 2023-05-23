<?php
	$conn = pg_connect("host=localhost port=5432 user=postgres password=root dbname=benilun");
	if (!$conn) {
		die("Connessione PostgreSQL fallita.");
	};
	$q = pg_query($conn, "SELECT json_build_object( 'type', 'FeatureCollection', 'features', json_agg(ST_AsGeoJSON(t.*)::json) )
		FROM (
			SELECT *
			FROM (
				SELECT evento.id, ST_MakeLine(l1.punto, l2.punto)
				FROM evento, luogo AS l1, luogo AS l2
				WHERE bene1 = l1.id AND bene2 = l2.id
				UNION
				SELECT evento.id, l1.punto
				FROM evento, luogo AS l1
				WHERE bene1 = l1.id  AND bene2 IS NULL
			) t
			ORDER BY
				CASE id
					WHEN 14 THEN 1
					ELSE 2
				END
		) as t(id, geom);");
	$res = pg_fetch_row($q);
	echo json_encode($res[0]);
		
	/*
	$obj_arr = array();
	$q1 = pg_query($conn,
		"SELECT json_build_object( 'type', 'FeatureCollection', 'features', json_agg(ST_AsGeoJSON(t.*)::json) )
		FROM (
			SELECT evento.id, ST_MakeLine(l1.punto, l2.punto)
			FROM evento, luogo AS l1, luogo AS l2
			WHERE bene1 = l1.id AND bene2 = l2.id AND evento.id = ".$_POST['id']."
			UNION
			SELECT evento.id, l1.punto
			FROM evento, luogo AS l1
			WHERE bene1 = l1.id  AND bene2 IS NULL AND evento.id = ".$_POST['id']."
		) as t(id, geom);");
	$res1 = pg_fetch_row($q1);
	array_push($obj_arr, $res1[0]);
	$q2 = pg_query($conn,
		"SELECT json_build_object( 'type', 'FeatureCollection', 'features', json_agg(ST_AsGeoJSON(t.*)::json) )
		FROM (
			SELECT evento.id, ST_MakeLine(l1.punto, l2.punto)
			FROM evento, luogo AS l1, luogo AS l2
			WHERE bene1 = l1.id AND bene2 = l2.id AND evento.id != ".$_POST['id']."
			UNION
			SELECT evento.id, l1.punto
			FROM evento, luogo AS l1
			WHERE bene1 = l1.id  AND bene2 IS NULL AND evento.id != ".$_POST['id']."
		) as t(id, geom);");
	$res2 = pg_fetch_row($q2);
	array_push($obj_arr, $res2[0]);
	echo json_encode($obj_arr);
	*/
?>