<?php
	$conn = pg_connect("host=localhost port=5432 user=postgres password=root dbname=benilun");
	if (!$conn) {
		die("Connessione PostgreSQL fallita.");
	};
?>
<html lang='it'>
	<head>
		<meta charset='UTF-8'/>
		<title>Home - Beni in Lunigiana</title>
		<meta name='author' content='Alessandro Cignoni'/>
		<link rel='stylesheet' href='./css/stile.css'>
	</head>
	<body>
		<header>
			<h1>Bentornato utente X</h1>
		</header>
		<div>
			<h2>I tuoi dati</h2>
			<ul>
				<?php
					echo '<li>Varie ed eventuali</li>';
				?>
				<li><a href='./listaLuoghi.php?geom=1'>Lista dei luoghi</a>.</li>
				<li><a href='./listaEventi.php'>Lista degli eventi</a>.</li>
			</ul>
			<h2>Crea</h2>
			<ul>
				<li><a href='./nuovoLuogo.php'>Nuovo luogo</a></li>
				<li><a href='./nuovoEvento.php'>Nuovo evento singolo</a></li>
				<li><a href='./nuovoEvento.php?rela=1'>Nuovo evento relazione</a></li>
			</ul>
		</div>
		<footer>
			Alessandro Cignoni 2022
		</footer>
	</body>
	
</html>