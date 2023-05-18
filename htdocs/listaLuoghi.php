<?php
	$conn = pg_connect("host=localhost port=5432 user=postgres password=root dbname=benilun");
	if (!$conn) {
		die("Connessione PostgreSQL fallita.");
	};
	if (isset($_GET["geom"])) {
		if ($_GET["geom"] == 1) {
			$flagPunto = true;
		} else {
			$flagPunto = false;
		};
	} else {
		$flagPunto = false;
	};
?>
<html lang='it'>
	<head>
		<meta charset='UTF-8'/>
		<title>Luoghi - Beni in Lunigiana</title>
		<meta name='author' content='Alessandro Cignoni'/>
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
		<link rel='stylesheet' href='https://cdn.jsdelivr.net/gh/openlayers/openlayers.github.io@master/en/v6.5.0/css/ol.css' type='text/css'>
		<link rel='stylesheet' href='./css/stile.css'>
		<script src='https://cdn.jsdelivr.net/gh/openlayers/openlayers.github.io@master/en/v6.5.0/build/ol.js'></script>
		<script type='module' src='./js/listaLuoghi_init.js'></script>
	</head>
	<body>
		<header>
			<a href='./index.php'>Torna alla Home</a>.
			<h1>Luoghi nel database</h1>
		</header>
		<div class='legenda'>
			<div class='lista'>
				<h2>Lista</h2>
				<?php
					if ($flagPunto == true) {
						echo '<a href="./listaLuoghi.php"><input type="button" id="vaiPolig" value="Vedi come poligoni"/></a>';
					} else {
						echo '<a href="./listaLuoghi.php?geom=1"><input type="button" id="vaiPunti" value="Vedi come punti"/></a>';
					};
					
					$res = pg_query($conn, "SELECT id, identificazione FROM luogo ORDER BY id");
					$totluog = pg_num_rows($res);
					echo'<table>
							<tr><th>Id</th><th>Nome</th></tr>';
					for ($l = 0; $l < $totluog; $l++) {
						$luog = pg_fetch_row($res);
						echo '<tr><td><a href="./luogo.php?id='.$luog[0].'">'.$luog[0].'</a></td><td>'.$luog[1].'</td></tr>';
					};
					echo'</table>';
				?>
			</div>
			<div class='selezione'>
				<h2>Luogo selezionato</h2>
				<ul>
					<li id='datiSelez'>Nessun luogo selezionato.</li>
				</ul>
			</div>
		</div>
		<div id='map' class='map'></div>
		<footer>
			Alessandro Cignoni 2022
		</footer>
	</body>
	
</html>