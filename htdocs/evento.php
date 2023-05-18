<?php
	$conn = pg_connect("host=localhost port=5432 user=postgres password=root dbname=benilun");
	if (!$conn) {
		die("Connessione PostgreSQL fallita.");
	};
	if (isset($_GET["id"])) {
		$q = pg_prepare($conn, 'trovaEvento', 'SELECT *	FROM evento	WHERE id = $1'
						);
		$res = pg_execute($conn, 'trovaEvento', array($_GET["id"]));
		if (pg_num_rows($res) != 1) {
			header('Location: index.php');
		} else {
			$evenTipo = pg_fetch_row($res);
			if ($evenTipo[8] == NULL) { // caso evento a 1
				$flagSing = true;
				$res = pg_query($conn,
								'SELECT evento.id, bene1, denominazione_bene1, data_da, data_a, tipo_data,
									r1.ruolo, funzione.funzione, evento.bibliografia, evento.schedatore,
									evento.note, l1.identificazione
								FROM evento, funzione, ruolo AS r1, luogo AS l1
								WHERE evento.funzione = funzione.id AND ruolo_bene1 = r1.id AND
									 bene1 = l1.id AND evento.id = '.$_GET["id"]);
			} else { // caso evento a 2
				$flagSing = false;
				$res = pg_query($conn,
								'SELECT evento.id, bene1, denominazione_bene1, data_da, data_a, tipo_data,
									r1.ruolo, funzione.funzione, bene2, denominazione_bene2, r2.ruolo,
									evento.bibliografia, evento.schedatore, evento.note, l1.identificazione,
									l2.identificazione
								FROM evento, funzione, ruolo AS r1, ruolo AS r2, luogo AS l1, luogo AS l2
								WHERE evento.funzione = funzione.id AND ruolo_bene1 = r1.id AND
									ruolo_bene2 = r2.id AND bene1 = l1.id AND bene2 = l2.id AND
									evento.id = '.$_GET["id"]);
			}
			$even = pg_fetch_row($res);
		};
	} else {
		header('Location: index.php');
	};
?>
<html lang='it'>
	<head>
		<meta charset='UTF-8'/>
		<meta name='author' content='Alessandro Cignoni'/>
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
		<link rel='stylesheet' href='https://cdn.jsdelivr.net/gh/openlayers/openlayers.github.io@master/en/v6.5.0/css/ol.css' type='text/css'>
		<link rel='stylesheet' href='./css/stile.css'>
		<script src='https://cdn.jsdelivr.net/gh/openlayers/openlayers.github.io@master/en/v6.5.0/build/ol.js'></script>
		<script type='module' src='./js/evento_init.js'></script>
		<script src='./js/evento.js'></script>
		<?php
			if ($flagSing == true) {
				echo '<title>'.$even[2].' '.$even[7].' - Beni in Lunigiana</title>';
			} else {
				echo '<title>'.$even[2].' '.$even[7].' '.$even[9].'  - Beni in Lunigiana</title>';
			};
		?>
	</head>
	<body>
		<header>
			<a href='./index.php'>Torna alla Home</a>.
			<?php
				if ($flagSing == true) {
					echo '<h1>'.$even[2].' '.$even[7].'</h1>';
				} else {
					echo '<h1>'.$even[2].' '.$even[7].' '.$even[9].'</h1>';
				};
			?>
		</header>			
		<div class='legenda'>
			<form id='campi'>
				<table>
					<?php
						$qL = pg_query($conn, 'SELECT id, identificazione, mec, toponimo, comune FROM luogo ORDER BY identificazione');
						$luoghi = pg_fetch_all($qL);
						$qR = pg_query($conn, 'SELECT id, ruolo FROM ruolo ORDER BY ruolo');
						$ruoli = pg_fetch_all($qR);
						$qF = pg_query($conn, 'SELECT id, funzione FROM funzione ORDER BY funzione');
						$funzs = pg_fetch_all($qF);
						if ($flagSing == true) {
							echo '<tr><th>Id:</th><td>'.$even[0].'</td></tr>';
							echo '<tr><th>Ruolo luogo:</th><td id="campoR1">'.$even[6].'</td>>';
							echo '<td id="tendina_r1" class="tendina" hidden="hidden"> 
								<input type="button" value="Sostituisci">
								<div id="tend_cont_r1" class="tendina_contenuto">';
							foreach ($ruoli as $ruol) {
								echo '<div><input type="radio" id="r1_'.$ruol['id'].'" name="r1" value="'.$ruol['id'].'">
									<label for="r1_'.$ruol['id'].'"  onclick="aggiorna(this, \'r1\')"><span>'.$ruol['ruolo'].'</span></label></div>';
							};
							echo '</div></td></tr>';
							echo '<tr><th>Luogo:</th><td id="campoL1"><a href="./luogo.php?id='.$even[1].'">'.$even[11].'</a></td>';
							echo '<td id="tendina_l1" class="tendina" hidden="hidden"> 
								<input type="button" value="Sostituisci">
								<div id="tend_cont_l1" class="tendina_contenuto">';
							foreach ($luoghi as $luog) {
								echo '<div><input type="radio" id="l1_'.$luog['id'].'" name="l1" value="'.$luog['id'].'">
									<label for="l1_'.$luog['id'].'" onclick="aggiorna(this, \'l1\')"><span>'.$luog['identificazione'].'</span> ('.$luog['mec'].', '.$luog['toponimo'].' in '.$luog['comune'].')</label></div>';
							};
							echo '</div></td></tr>';
							echo '<tr><th>Luogo citato come:</th><td id="campoCit1">'.$even[2].'</td></tr>';
							echo '<tr><th>Data da:</th><td id="campoDataDa">'.$even[3].'</td></tr>';
							echo '<tr><th>Data a:</th><td id="campoDataA">'.$even[4].'</td></tr>';
							echo '<tr><th>Tipo data:</th><td id="campoDataTipo">'.$even[5].'</td></tr>';
							echo '<tr><th>Funzione:</th><td id="campoF">'.$even[7].'</td>';
							echo '<td id="tendina_f" class="tendina" hidden="hidden"> 
								<input type="button" value="Sostituisci">
								<div id="tend_cont_f" class="tendina_contenuto">';
							foreach ($funzs as $funz) {
								echo '<div><input type="radio" id="f_'.$funz['id'].'" name="f" value="'.$funz['id'].'">
									<label for="f_'.$funz['id'].'" onclick="aggiorna(this, \'f\')"><span>'.$funz['funzione'].'</span></label></div>';
							};
							echo '</div></td></tr>';
							echo '<tr><th>Bibliografia:</th><td id="campoBib">'.$even[8].'</td></tr>';
							echo '<tr><th>Note</th><td id="campoNot">'.$even[10].'</td></tr>';
							echo '<tr><th>Schedatore</th><td>'.$even[9].'</td></tr>';
						} else {
							echo '<tr><th>Id:</th><td>'.$even[0].'</td></tr>';
							echo '<tr><th>Ruolo luogo 1:</th><td id="campoR1">'.$even[6].'</td>';
							echo '<td id="tendina_r1" class="tendina" hidden="hidden"> 
								<input type="button" value="Sostituisci">
								<div id="tend_cont_r1" class="tendina_contenuto">';
							foreach ($ruoli as $ruol) {
								echo '<div><input type="radio" id="r1_'.$ruol['id'].'" name="r1" value="'.$ruol['id'].'">
									<label for="r1_'.$ruol['id'].'" onclick="aggiorna(this, \'r1\')"><span>'.$ruol['ruolo'].'</span></label></div>';
							};
							echo '</div></td></tr>';
							echo '<tr><th>Luogo 1:</th><td id="campoL1"><a href="./luogo.php?id='.$even[1].'">'.$even[14].'</a></td>';
							echo '<td id="tendina_l1" class="tendina" hidden="hidden"> 
								<input type="button" value="Sostituisci">
								<div id="tend_cont_l1" class="tendina_contenuto">';
							foreach ($luoghi as $luog) {
								echo '<div><input type="radio" id="l1_'.$luog['id'].'" name="l1" value="'.$luog['id'].'">
									<label for="l1_'.$luog['id'].'" onclick="aggiorna(this, \'l1\')"><span>'.$luog['identificazione'].'</span> ('.$luog['mec'].', '.$luog['toponimo'].' in '.$luog['comune'].')</label></div>';
							};
							echo '</div></td></tr>';
							echo '<tr><th>Luogo 1 citato come:</th><td id="campoCit1">'.$even[2].'</td><tr/>';
							echo '<tr><th>Data da:</th><td id="campoDataDa">'.$even[3].'</td></tr>';
							echo '<tr><th>Data a:</th><td id="campoDataA">'.$even[4].'</td></tr>';
							echo '<tr><th>Tipo data:</th><td id="campoDataTipo">'.$even[5].'</td></tr>';
							echo '<tr><th>Funzione:</th><td id="campoF">'.$even[7].'</td>';
							echo '<td id="tendina_f" class="tendina" hidden="hidden"> 
								<input type="button" value="Sostituisci">
								<div id="tend_cont_f" class="tendina_contenuto">';
							foreach ($funzs as $funz) {
								echo '<div><input type="radio" id="f_'.$funz['id'].'" name="f" value="'.$funz['id'].'">
									<label for="f_'.$funz['id'].'" onclick="aggiorna(this, \'f\')"><span>'.$funz['funzione'].'</span></label></div>';
							};
							echo '</div></td></tr>';
							echo '<tr><th>Ruolo luogo 2:</th><td id="campoR2">'.$even[10].'</td>';
							echo '<td id="tendina_r2" class="tendina" hidden="hidden"> 
								<input type="button" value="Sostituisci">
								<div id="tend_cont_r2" class="tendina_contenuto">';
							foreach ($ruoli as $ruol) {
								echo '<div><input type="radio" id="r2_'.$ruol['id'].'" name="r2" value="'.$ruol['id'].'">
									<label for="r2_'.$ruol['id'].'" onclick="aggiorna(this, \'r2\')"><span>'.$ruol['ruolo'].'</span></label></div>';
							};
							echo '</div></td></tr>';
							echo '<tr><th>Luogo 2:</th><td id="campoL2"><a href="./luogo.php?id='.$even[8].'">'.$even[15].'</a></td>';
							echo '<td id="tendina_l2" class="tendina" hidden="hidden"> 
								<input type="button" value="Sostituisci">
								<div id="tend_cont_l2" class="tendina_contenuto">';
							foreach ($luoghi as $luog) {
								echo '<div><input type="radio" id="l2_'.$luog['id'].'" name="l2" value="'.$luog['id'].'">
									<label for="l2_'.$luog['id'].'" onclick="aggiorna(this, \'l2\')"><span>'.$luog['identificazione'].'</span> ('.$luog['mec'].', '.$luog['toponimo'].' in '.$luog['comune'].')</label></div>';
							};
							echo '</div></td></tr>';
							echo '<tr><th>Luogo 2 citato come:</th><td id="campoCit2">'.$even[9].'</td></tr>';
							echo '<tr><th>Bibliografia:</th><td id="campoBib">'.$even[11].'</td></tr>';
							echo '<tr><th>Note</th><td id="campoNot">'.$even[13].'</td></tr>';
							echo '<tr><th>Schedatore</th><td>'.$even[12].'</td></tr>';
						};
					?>
				</table>
			<form/>
			<div id='interazioni'>
				<?php
					// funzione si comporta diversamente a seconda se l'evento si riferisca a un solo luogo o a due
					if ($flagSing == true) {
						echo '<input type="button" id="modifica" onclick="modificaEve(1)" value="Modifica"/>';
						echo '<input type="button" id="conferma" onclick="confermaEve(1)" value="Conferma" hidden="hidden"/>';
					} else {
						echo '<input type="button" id="modifica" onclick="modificaEve(0)" value="Modifica"/>';
						echo '<input type="button" id="conferma" onclick="confermaEve(0)" value="Conferma" hidden="hidden"/>';
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