<?php
	$conn = pg_connect('host=localhost port=5432 user=postgres password=root dbname=benilun');
	if (!$conn) {
		die('Connessione PostgreSQL fallita.');
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
		<script type='module' src='./js/nuovoLuogo_init.js'></script>
		<script src='./js/nuovoLuogo.js'></script>
		<?php
			echo '<title> Crea luogo - Beni in Lunigiana</title>';
		?>
	</head>
	<body>
		<header>
			<a href='./index.php'>Torna alla Home</a>.
			<h1>Crea luogo</h1>
		</header>
		<div class='legenda'>
			<form id='campi'>
				<table>
					<tr><th>Identificazione:</th><td id="campoNom"><input id="nuovNom" name="nuovNom" type="text" value=""/>*</td></tr>
					<tr><th>Descrizione:</th><td id="campoDes"><input id="nuovDes" name="nuovDes" type="text" value=""/></td></tr>
					<tr><th>Macro Epoca Originale:</th><td id="campoMEO"><input id="nuovMEO" name="nuovMEO" type="text" value=""/></td></tr>
					<tr><th>Macro Epica Caratteristica:</th><td id="campoMEC"><input id="nuovMEC" name="nuovMEC" type="text" value=""/></td></tr>
					<tr><th>Esistenza:</th><td id="campoEsi"><input id="nuovEsi" name="nuovEsi" type="text" value=""/></td></tr>
					<tr><th>Toponimo:</th><td id="campoTop"><input id="nuovTop" name="nuovTop" type="text" value=""/></td></tr>
					<tr><th>Comune:</th><td id="campoCom"><input id="nuovCom" name="nuovCom" type="text" value=""/></td></tr>
					<tr><th>Bibliografia:</th><td id="campoBib"><input id="nuovBib" name="nuovBib" type="text" value=""/></td></tr>
					<tr><th>Note</th><td id="campoNot"><input id="nuovNot" name="nuovNot" type="text" value=""/></td></tr>
				</table>
			</form>
			* campi obbligatori
			<div id='interazioni'>
				<input type='button' id='confermaNuovo' onclick='confermaLuogo()' value='Inserisci'/>
			</div>
		</div>
		<div id='map' class='map'></div>
		<footer>
			Alessandro Cignoni 2022
		</footer>
	</body>
</html>