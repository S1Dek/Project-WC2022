<?php 
session_start(); 
if(isset($_SESSION['logged'])&&($_SESSION['logged']==true))
{
header('Location: main.php');
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
<aside>
	<form action="logging.php" method="post">
	<input type="text" class="login" name="login" placeholder="Login"/> 	<!-- pole tekstowe login -->
	<input type="password" class="login" name="password" placeholder="Haslo"/>  <!-- pole tekstowe haslo -->
	<input type="submit" value="Zaloguj się" /> <!-- przycisk zaloguj sie -->
	</form>
	<?php if(isset($_SESSION['logged_error']))
	echo $_SESSION['logged_error']; ?> <!-- napis że login jest nie poprawny -->
</aside>
<footer>
</footer>
</body>
</html>
