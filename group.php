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
	<div id="main_group">
	<?php require_once "connect.php"; 
	$connect= @new mysqli($db_domain,$db_login,$db_password,$db_name); 		 //połączenie do bazy
		if($connect->connect_errno!=0):										 //sprawdzenie czy polaczenie sie nie udało			
		echo "Error;".$connect->connect_errno;
		else:
		for ($i = 1; $i <= 8; $i++):
		$sql="SELECT * FROM standings WHERE group_id=$i ORDER BY rank"; 	//pobieranie wszystkich grup z bazy
		$result=@$connect->query($sql);				//wysłanie zapytania do bazy
		?>
		<div id="groupbox">
		<?php
		echo "<div id=groupcontainer>GRUPA $i</div>";
		for($j = 1; $j <= 4; $j++):
		$row=$result->fetch_assoc();
		$id_team=$row['id_team'];
		$name_team=$row['name_team'];
		$country=$row['polish_name'];
		$points=$row['points'];
		$name_team=strtr($name_team,' ','_');								// zamienia spacje na podkreślnik
		$URLcountry="images/flag/".$name_team.".jpg";
		$rank=$row['rank']; 												//miejsce w tabeli
		echo "<a href='country.php?teamid=$id_team'><div id=country_groupcontainer><div>$rank. <img class='flag_group' src=".$URLcountry." alt='flag of ".$country."'> $country</div><div>$points</div></div></a>";
		endfor;
		?>
		</div>
		<?php
		$result->close();
		endfor;
		endif;
		?>
	</div>
</body>
</html>