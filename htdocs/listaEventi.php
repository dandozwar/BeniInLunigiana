<?php
	$conn = pg_connect("host=localhost port=5432 user=postgres password=root dbname=benilun");
	if (!$conn) {
		die("Connessione PostgreSQL fallita.");
	};
?>
<html lang='it'>
	<head>
		<meta charset='UTF-8'/>
		<title>Eventi - Beni in Lunigiana</title>
		<meta name='author' content='Alessandro Cignoni'/>
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
		<link rel='stylesheet' href='https://cdn.jsdelivr.net/gh/openlayers/openlayers.github.io@master/en/v6.5.0/css/ol.css' type='text/css'>
		<link rel='stylesheet' href='./css/stile.css'>
		<script src='https://cdn.jsdelivr.net/gh/openlayers/openlayers.github.io@master/en/v6.5.0/build/ol.js'></script>
		<script type='module' src='./js/listaEventi_init.js'></script>
		<script src='./js/listaEventi.js'></script>
	</head>
	<body>
		<header>
			<a href='./index.php'>Torna alla Home</a>.
			<h1>Eventi nel database</h1>
		</header>
		<div class='legenda'>
			<div class='lista'>
				<h2>Elenco</h2>
				<?php					
					$res = pg_query($conn, "SELECT evento.id, bene1, r1.ruolo, denominazione_bene1, funzione.funzione, bene2, r2.ruolo, denominazione_bene2
											FROM evento, funzione, ruolo AS r1, ruolo AS r2
											WHERE funzione.id = evento.funzione AND ruolo_bene1 = r1.id AND ruolo_bene2 = r2.id
											UNION
											SELECT evento.id, bene1, r1.ruolo, denominazione_bene1, funzione.funzione, NULL, NULL, NULL
											FROM evento, funzione, ruolo AS r1
											WHERE funzione.id = evento.funzione AND ruolo_bene1 = r1.id AND bene2 IS NULL
											ORDER BY id");
					$toteven = pg_num_rows($res);
					echo'<table>
							<tr><th>Id</th><th>Ruolo Luogo 1</th><th>Luogo 1</th><th>Funzione</th><th>Ruolo Luogo 2</th><th>Luogo 2</th></tr>';
					for ($e = 0; $e < $toteven; $e++) {
						$even = pg_fetch_row($res);
						if ($even[5] != NULL) {
							echo '<tr><td><a href="./evento.php?id='.$even[0].'">'.$even[0].'</a></td><td>'.$even[2].'</td><td><a href="./luogo.php?id='.$even[1].'">'.$even[3].'</a></td><td>'.$even[4].'</td><td>'.$even[6].'</td><td><a href="./luogo.php?id='.$even[5].'">'.$even[7].'</a></td></tr>';
						} else {
							echo '<tr><td><a href="./evento.php?id='.$even[0].'">'.$even[0].'</a></td><td>'.$even[2].'</td><td><a href="./luogo.php?id='.$even[1].'">'.$even[3].'</a></td><td>'.$even[4].'</td><td></td><td></td></tr>';
						};
					};
					echo'</table>';
				?>
			</div>
			<div class='selezione'>
				<h2>Evento selezionato</h2>
				<ul>
					<li id='datiSelez'>Nessun evento selezionato.</li>
				</ul>
			</div>
		</div>
		<div id='map' class='map'></div>
		<footer>
			Alessandro Cignoni 2022
		</footer>
	</body>
	
</html>