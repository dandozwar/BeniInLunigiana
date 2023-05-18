<?php
	$conn = pg_connect("host=localhost port=5432 user=postgres password=root dbname=benilun");
	if (!$conn) {
		die("Connessione PostgreSQL fallita.");
	};
	$res = pg_query($conn, "SELECT * FROM luogo WHERE id =".$_POST['id']);
	$luog = pg_fetch_row($res);
	echo json_encode($luog);
?>