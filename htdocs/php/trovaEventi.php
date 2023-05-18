<?php
	$conn = pg_connect("host=localhost port=5432 user=postgres password=root dbname=benilun");
	if (!$conn) {
		die("Connessione PostgreSQL fallita.");
	};
	$res = pg_query($conn, "SELECT json_build_object( 'type', 'FeatureCollection', 'features', json_agg(ST_AsGeoJSON(t.*)::json) )
		FROM (
			SELECT evento.id, bene1, r1.ruolo, denominazione_bene1, funzione.funzione, bene2, r2.ruolo, denominazione_bene2, ST_MakeLine(l1.punto, l2.punto)
			FROM evento, funzione, ruolo AS r1, ruolo AS r2, luogo AS l1, luogo AS l2
			WHERE funzione.id = evento.funzione AND ruolo_bene1 = r1.id AND ruolo_bene2 = r2.id AND bene1 = l1.id AND bene2 = l2.id
			UNION
			SELECT evento.id, bene1, r1.ruolo, denominazione_bene1, funzione.funzione, NULL, NULL, NULL, l1.punto
			FROM evento, funzione, ruolo AS r1, luogo AS l1
			WHERE funzione.id = evento.funzione AND ruolo_bene1 = r1.id AND bene1 = l1.id AND bene2 IS NULL
			ORDER BY id
		) as t(id, b1, r1, d1, f, b2, r2, d2, geom);");
	$obj_arr = pg_fetch_row($res);
	echo json_encode($obj_arr[0]);
?>