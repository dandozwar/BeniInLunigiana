<?php
	$conn = pg_connect('host=localhost port=5432 user=postgres password=root dbname=benilun');
	if (!$conn) {
		die('Connessione PostgreSQL fallita.');
	};
	if (isset($_GET['id'])) {
		$q = pg_prepare($conn, 'trovaLuogo', 'SELECT * FROM luogo WHERE id = $1');
		$res = pg_execute($conn, 'trovaLuogo', array($_GET['id']));
		if (pg_num_rows($res) != 1) {
			header('Location: index.php');
		} else {
			$luog = pg_fetch_row($res);
			if (isset($_GET["geom"])) {
				if ($_GET["geom"] == 1) {
					$flagPunto = true;
				} else {
					$flagPunto = false;
				};
			} else {
				$flagPunto = false;
			};
		};
	} else {
		header('Location: index.php');
	};
?>
<html lang='it'>
	<head>
		<meta charset='UTF-8'/>
		<meta name='author' content='Alessandro Cignoni'/>
		<script src='https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js'></script>
		<link rel='stylesheet' href='https://cdn.jsdelivr.net/gh/openlayers/openlayers.github.io@master/en/v6.5.0/css/ol.css' type='text/css'>
		<link rel='stylesheet' href='./css/stile.css'>
		<script src='https://cdn.jsdelivr.net/gh/openlayers/openlayers.github.io@master/en/v6.5.0/build/ol.js'></script>
		<script type='module' src='./js/luogo_init.js'></script>
		<script src='./js/luogo.js'></script>
		<?php
			echo '<title>'.$luog[1].' - Beni in Lunigiana</title>';
		?>
	</head>
	<body>
		<header>
			<a href='./index.php'>Torna alla Home</a>.
			<?php
				if ($flagPunto == true) {
					echo '<h1 id="title" geom="1">'.$luog[1].'</h1>';
				} else {
					echo '<h1 id="title" geom="2">'.$luog[1].'</h1>';
				};
			?>
		</header>
		<div class='legenda'>
			<?php
				if ($flagPunto == true) {
					echo '<a href="./luogo.php?id='.$luog[0].'"><input type="button" id="vaiPolig" value="Vedi come poligoni"/></a>';
				} else {
					echo '<a href="./luogo.php?id='.$luog[0].'&geom=1"><input type="button" id="vaiPunti" value="Vedi come punti"/></a>';
				};
			?>
			<form id='campi'>
			<?php
				echo '<table>';
				echo '<tr><th>Id:</th><td>'.$luog[0].'</td></tr>';
				echo '<tr><th>Identificazione:</th><td id="campoNom">'.$luog[1].'</td></tr>';
				echo '<tr><th>Descrizione:</th><td id="campoDes">'.$luog[2].'</td></tr>';
				echo '<tr><th>Macro Epoca Originale:</th><td id="campoMEO">'.$luog[3].'</td></tr>';
				echo '<tr><th>Macro Epica Caratteristica:</th><td id="campoMEC">'.$luog[4].'</td></tr>';
				echo '<tr><th>Esistenza:</th><td id="campoEsi">'.$luog[6].'</td></tr>';
				echo '<tr><th>Toponimo:</th><td id="campoTop">'.$luog[5].'</td></tr>';
				echo '<tr><th>Comune:</th><td id="campoCom">'.$luog[7].'</td></tr>';
				echo '<tr><th>Bibliografia:</th><td id="campoBib">'.$luog[8].'</td></tr>';
				echo '<tr><th>Note</th><td id="campoNot">'.$luog[10].'</td></tr>';
				echo '<tr><th>Schedatore</th><td>'.$luog[9].'</td></tr>';
				echo '</table>';
			?>
			</form>
			<div id='interazioni'>
				<input type='button' id='modiAlfa' onclick='modificaAlfa()' value='Modifica dati'/>
				<?php
					if ($flagPunto == false) {
						echo "<input type='button' id='modiGeog' onclick='modificaGeog()' value='Modifica geografia'/>";
					};
				?>
				<input type='button' id='confAlfa' onclick='confermaAlfa()' value='Conferma' hidden='hidden'/>
				<?php
					if ($flagPunto == false) {
						echo "<input type='button' id='confGeog' onclick='confermaGeog()' value='Conferma' hidden='hidden'/>";
					};
				?>
				<input type='button' id='annulla' onclick='annullaMod()' value='Annulla' hidden='hidden'/>
			</div>
		</div>
		<div id='map' class='map'></div>
		<footer>
			Alessandro Cignoni 2022
		</footer>
	</body>
</html>