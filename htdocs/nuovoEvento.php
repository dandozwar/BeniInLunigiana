<?php
	$conn = pg_connect('host=localhost port=5432 user=postgres password=root dbname=benilun');
	if (!$conn) {
		die('Connessione PostgreSQL fallita.');
	};
	if (isset($_GET["rela"])) {
		if ($_GET["rela"] == 1) {
			$flagRela = true;
		} else {
			$flagRela = false;
		};
		
	} else {
		$flagRela = false;
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
		<script type='module' src='./js/nuovoEvento_init.js'></script>
		<script src='./js/nuovoEvento.js'></script>
		<?php
			echo '<title> Crea evento singolo - Beni in Lunigiana</title>';
		?>
	</head>
	<body>
		<header>
			<a href='./index.php'>Torna alla Home</a>.
			<?php
				if ($flagRela == true) {
					echo '<h1>Crea evento relazione</h1>';
				} else {
					echo '<h1>Crea evento singolo</h1>';
				};
			?>
		</header>
		<div class='legenda'>
			<?php
				if ($flagRela == true) {
					echo '<a href="./nuovoEvento.php"><input type="button" id="vaiSing" value="Passa a evento singolo"/></a>';
				} else {
					echo '<a href="./nuovoEvento.php?rela=1"><input type="button" id="vaiRela" value="Passa a evento relazione"/></a>';
				};	
			?>
			<form id='campi'>
				<table>
					<?php
						$qL = pg_query($conn, 'SELECT id, identificazione, mec, toponimo, comune FROM luogo ORDER BY identificazione');
						$luoghi = pg_fetch_all($qL);
						$qR = pg_query($conn, 'SELECT id, ruolo FROM ruolo ORDER BY ruolo');
						$ruoli = pg_fetch_all($qR);
						$qF = pg_query($conn, 'SELECT id, funzione FROM funzione ORDER BY funzione');
						$funzs = pg_fetch_all($qF);
						if ($flagRela == false) {
							echo '<tr><th>Ruolo luogo:</th><td id="campoR1"><input id="nuovR1" name="nuovR1" type="text" value="" readonly/><td id="id_r1" hidden="hidden"></td></td>';
							echo '<td id="tendina_r1" class="tendina"> 
								<input type="button" value="Seleziona">
								<div id="tend_cont_r1" class="tendina_contenuto">';
							foreach ($ruoli as $ruol) {
								echo '<div><input type="radio" id="r1_'.$ruol['id'].'" name="r1" value="'.$ruol['id'].'">
									<label for="r1_'.$ruol['id'].'" onclick="aggiorna(this, \'r1\')"><span>'.$ruol['ruolo'].'</span></label></div>';
							};
							echo '</div></td></tr>';
							echo '<tr><th>Luogo:</th><td id="campoL1"><input id="nuovL1" name="nuovL1" type="text" value="" readonly/></td><td id="id_l1" hidden="hidden"></td>';
							echo '<td id="tendina_l1" class="tendina"> 
								<input type="button" value="Seleziona">*
								<div id="tend_cont_l1" class="tendina_contenuto">';
							foreach ($luoghi as $luog) {
								echo '<div><input type="radio" id="l1_'.$luog['id'].'" name="l1" value="'.$luog['id'].'">
									<label for="l1_'.$luog['id'].'" onclick="aggiorna(this, \'l1\')"><span>'.$luog['identificazione'].'</span> ('.$luog['mec'].', '.$luog['toponimo'].' in '.$luog['comune'].')</label></div>';
							};
							echo '</div></td></tr>';
							echo '<tr><th>Luogo citato come:</th><td id="campoCit1"><input id="nuovCit1" name="nuovCit1" type="text" value=""/></td></tr>';
							echo '<tr><th>Data da:</th><td id="campoDataDa"><input id="nuovDataDa" name="nuovDataDa" type="text" value=""/>*</td></tr>';
							echo '<tr><th>Data a:</th><td id="campoDataA"><input id="nuovDataA" name="nuovDataA" type="text" value=""/></td></tr>';
							echo '<tr><th>Tipo data:</th><td id="campoDataTipo"><input id="nuovDataTipo" name="nuovDataTipo" type="text" value=""/></td></tr>';
							echo '<tr><th>Funzione:</th><td id="campoF"><input id="nuovF" name="nuovF" type="text" value=""  readonly/></td><td id="id_f" hidden="hidden"></td>';
							echo '<td id="tendina_f" class="tendina"> 
								<input type="button" value="Seleziona">*
								<div id="tend_cont_f" class="tendina_contenuto">';
							foreach ($funzs as $funz) {
								echo '<div><input type="radio" id="f_'.$funz['id'].'" name="f" value="'.$funz['id'].'">
									<label for="f_'.$funz['id'].'" onclick="aggiorna(this, \'f\')"><span>'.$funz['funzione'].'</span></label></div>';
							};
							echo '</div></td></tr>';
						} else {
							echo '<tr><th>Ruolo luogo 1:</th><td id="campoR1"><input id="nuovR1" name="nuovR1" type="text" value="" readonly/><td id="id_r1" hidden="hidden"></td></td>';
							echo '<td id="tendina_r1" class="tendina"> 
								<input type="button" value="Seleziona">
								<div id="tend_cont_r1" class="tendina_contenuto">';
							foreach ($ruoli as $ruol) {
								echo '<div><input type="radio" id="r1_'.$ruol['id'].'" name="r1" value="'.$ruol['id'].'">
									<label for="r1_'.$ruol['id'].'" onclick="aggiorna(this, \'r1\')"><span>'.$ruol['ruolo'].'</span></label></div>';
							};
							echo '</div></td></tr>';
							echo '<tr><th>Luogo 1:</th><td id="campoL1"><input id="nuovL1" name="nuovL1" type="text" value="" readonly/></td><td id="id_l1" hidden="hidden"></td>';
							echo '<td id="tendina_l1" class="tendina"> 
								<input type="button" value="Seleziona">*
								<div id="tend_cont_l1" class="tendina_contenuto">';
							foreach ($luoghi as $luog) {
								echo '<div><input type="radio" id="l1_'.$luog['id'].'" name="l1" value="'.$luog['id'].'">
									<label for="l1_'.$luog['id'].'" onclick="aggiorna(this, \'l1\')"><span>'.$luog['identificazione'].'</span> ('.$luog['mec'].', '.$luog['toponimo'].' in '.$luog['comune'].')</label></div>';
							};
							echo '</div></td></tr>';
							echo '<tr><th>Luogo 1 citato come:</th><td id="campoCit1"><input id="nuovCit1" name="nuovCit1" type="text" value=""/></td><tr/>';
							echo '<tr><th>Data da:</th><td id="campoDataDa"><input id="nuovDataDa" name="nuovDataDa" type="text" value=""/>*</td></tr>';
							echo '<tr><th>Data a:</th><td id="campoDataA"><input id="nuovDataA" name="nuovDataA" type="text" value=""/></td></tr>';
							echo '<tr><th>Tipo data:</th><td id="campoDataTipo"><input id="nuovDataTipo" name="nuovDataTipo" type="text" value=""/></td></tr>';
							echo '<tr><th>Funzione:</th><td id="campoF"><input id="nuovF" name="nuovF" type="text" value=""  readonly/><td id="id_f"  hidden="hidden"></td>';
							echo '<td id="tendina_f" class="tendina"> 
								<input type="button" value="Seleziona">*
								<div id="tend_cont_f" class="tendina_contenuto">';
							foreach ($funzs as $funz) {
								echo '<div><input type="radio" id="f_'.$funz['id'].'" name="f" value="'.$funz['id'].'">
									<label for="f_'.$funz['id'].'" onclick="aggiorna(this, \'f\')"><span>'.$funz['funzione'].'</span></label></div>';
							};
							echo '</div></td></tr>';
							echo '<tr><th>Ruolo luogo 2:</th><td id="id_r2"><input id="nuovR2" name="nuovR2" type="text" value="" readonly/></td><td id="campoR2" hidden="hidden"></td>';
							echo '<td id="tendina_r2" class="tendina"> 
								<input type="button" value="Seleziona">
								<div id="tend_cont_r2" class="tendina_contenuto">';
							foreach ($ruoli as $ruol) {
								echo '<div><input type="radio" id="r2_'.$ruol['id'].'" name="r2" value="'.$ruol['id'].'">
									<label for="r2_'.$ruol['id'].'" onclick="aggiorna(this, \'r2\')"><span>'.$ruol['ruolo'].'</span></label></div>';
							};
							echo '</div></td></tr>';
							echo '<tr><th>Luogo 2:</th><td id="campoL2"><input id="nuovL2" name="nuovL2" type="text" value="" readonly/></td><td id="id_l2" hidden="hidden"></td>';
							echo '<td id="tendina_l2" class="tendina"> 
								<input type="button" value="Seleziona">*
								<div id="tend_cont_l2" class="tendina_contenuto">';
							foreach ($luoghi as $luog) {
								echo '<div><input type="radio" id="l2_'.$luog['id'].'" name="l2" value="'.$luog['id'].'">
									<label for="l2_'.$luog['id'].'" onclick="aggiorna(this, \'l2\')"><span>'.$luog['identificazione'].'</span> ('.$luog['mec'].', '.$luog['toponimo'].' in '.$luog['comune'].')</label></div>';
							};
							echo '</div></td></tr>';
							echo '<tr><th>Luogo 2 citato come:</th><td id="campoCit2"><input id="nuovCit2" name="nuovCit2" type="text" value=""/></td></tr>';
						};
					?>
					<tr><th>Bibliografia:</th><td id="campoBib"><input id="nuovBib" name="nuovBib" type="text" value=""/></td></tr>
					<tr><th>Note</th><td id="campoNot"><input id="nuovNot" name="nuovNot" type="text" value=""/></td></tr>
				</table>
			</form>
			* campi obbligatori
			<div id='interazioni'>
				<input type='button' id='confermaNuovo' onclick='confermaEvento()' value='Inserisci'/>
			</div>
		</div>
		<div id='map' class='map'></div>
		<footer>
			Alessandro Cignoni 2022
		</footer>
	</body>
</html>