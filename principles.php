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

<body >
	<?php require_once "navigation.php"; ?>
	<div id="main">
		<h1>Zasady naszej bukmacherki	</h1>
		<p>1. Kuba to kutasiarz	</p>
		<p>2. Jebać szczura z daszewic	</p>
		<p>3. korcz to grzybek	</p>
		<p>4. kuba(celowo z małej) ssie pałe !!!	</p>
		<p>5. Kocham bolta !(wszyscy go skrycie kochamy) </p>
		
		
		
		
		
		
		
		<form action="post-principles.php" method="post">
		<?php
			if($_SESSION['principle']==0):?>
				<label><input type="checkbox" value="1" name="checkbox"/> Nie pokazuj ponownie odrazu po zalogowaniu </label>
		<?php endif; ?>
				<input type="submit" value="Przejdź do menu głównego"/>	
		</form>
	</div>
	
</body> 