<?php 
session_start();
if(!isset($_SESSION['logged']))
{
	header('Location: index.php');
	exit();
}
 ?>
<!DOCTYPE HTML>
<html lang="pl">
<head>
	<meta charset="utf-8"/>
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1"/>
	<link rel="stylesheet" href="style.css">
	<link rel="preconnect" href="https://fonts.googleapis.com">
	<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
	<link href="https://fonts.googleapis.com/css2?family=Noto+Serif+Gujarati:wght@400;700&display=swap" rel="stylesheet"> <!-- import czcionki -->
	<title>Mundial Katar 2022</title>
</head>
<body>
	<?php require_once "navigation.php"; ?>
	<div id="main">	
	<br><br><br>
		<h2>Kontakt</h2>		
		<p> Kontakt to twórców:<br>
			korczjakub@gmail.pl<br>
			marcinratajczak1911@gmail.com<br>
			lub napisać na popularnej aplikacji messenger !		
		</p>
	</div>
</body>
</html>