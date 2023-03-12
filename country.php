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
	<?php require_once "connect.php"; 
	$connect= @new mysqli($db_domain,$db_login,$db_password,$db_name);	//połączenie do bazy
		if($connect->connect_errno!=0): //sprawdzenie czy polaczenie sie nie udało			
		echo "Error;".$connect->connect_errno;
		else:
		$id_country= $_GET['teamid'];
		$sql="SELECT * FROM standings WHERE id_team='$id_country'"; //pobieranie wszystkich meczow z bazy
		$result=@$connect->query($sql);	//wysłanie zapytania do bazy		
		$amount_of_results=$result->num_rows; //zliczanie wyników zapytania
		$row=$result->fetch_assoc();
		$name_country=$row['name_team'];
		$wins=$row['wins'];
		$draws=$row['draws'];
		$loses=$row['loses'];
		$goalsFor=$row['goalsFor'];
		$goalsAgainst=$row['goalsAgainst'];
		$name_country=strtr($name_country,' ','_');							// zamienia spacje na podkreślnik
		$URLcountry="images/flag/".$name_country.".jpg";
		$name_country=$row['polish_name'];
		$rank=$row['rank']; 
		$points=$row['points'];	
		?>
		<form action="add_score.php?matchid=<?php echo $name_country?>" method="post">
		<div id='country_list'>
		  <div class='row'>
			<div class='column'>									<!-- flaga -->
			  <div class='country_flag'>
			  <?php echo "<img class='flag_country' src='$URLcountry' alt='flag of $name_country'>"?>
			  </div>
			</div>
			<div class='column'>									<!-- nazwa kraju -->
			  <div id='country_name'>
			  <?php echo "<p style='font-size: 50px; text-transform: uppercase;'>$name_country</p>"?>
			  </div>
			</div>
			<div class='column'>									<!-- wszystkie poprzednie mecze mecze -->
			<div id='country_match_all'>
			wszystkie mecze
			</div>
			</div>
		  </div>
		  <div class='row 2'>
			<div class='column'>									<!-- bilans bramkowy -->
			<div id='country_match_score'>
				<p style='font-size: 20px;'>Bilans bramkowy</p>
				<p><?php echo $goalsFor."-".$goalsAgainst?></p>
			 </div>
			</div>
			<div class='column'>									<!-- bilans wygranych meczy -->
			  <div id='country_list_containter'>
			  <p style='color: #6dff45;'><?php echo $wins?></p> - 
			  <p style='color: #ffc745;'><?php echo $draws?></p> -
			  <p style='color: #c73434;'><?php echo $loses?></p>
			  </div>
			</div>
			<div class='column'>									<!-- punkty -->
			<div id='points'>
			<p>PKT <?php echo $points?></p>
			<p>Miejsce w grupie <?php echo $rank?>.</p>
			</div>
			</div>
			</div>
			<div class='row 3'>
			<div class='column'>									<!-- wszyscy zawodnicy -->
			<?php
				$sql1="SELECT * FROM players WHERE id_team='$id_country' AND position='Goalkeeper'"; //pobieranie wszystkich meczow z bazy
				$result1=@$connect->query($sql1);	//wysłanie zapytania do bazy		
				$amount_of_results1=$result1->num_rows; //zliczanie wyników zapytania
				for ($i = 1; $i <= $amount_of_results1; $i++):
				$row1=$result1->fetch_assoc();
				$name_player=$row1['name_player'];
				$position=$row1['position'];
				if($position=="Goalkeeper"){
					$position="Bramkarz";
				}
				else if($position=="Defender"){
					$position="Obrońca";
				}
				else if($position=="Midfielder"){
					$position="Pomocnik";
				}
				else if($position=="Attacker"){
					$position="Napastnik";
				}
				?>
			  <div id='squad_all'>
				<a><?php echo " <p style='color: white;background-color:blue;'>$position</p>".$name_player?></a>
			  </div>
			<?php
			endfor;
			?>
			</div>
			<div class='column'>									<!-- pierwszy skład -->
			  <div id='squad'>
			  pierwsza jedenastka
			  </div>
			</div>
			<div class='column'>									<!-- wszystkie poprzednie mecze mecze -->
			<?php
				$sql2="SELECT * FROM match_list WHERE id_country1='$id_country' OR id_country2='$id_country' ORDER BY timestamp"; //pobieranie wszystkich meczow z bazy
				$result2=@$connect->query($sql2);	//wysłanie zapytania do bazy		
				$amount_of_results2=$result2->num_rows; //zliczanie wyników zapytania
				for ($i = 1; $i <= $amount_of_results2; $i++):
				$row2=$result2->fetch_assoc();
				$date=$row2['date'];
				$date = date('Y-m-d H:i:s', strtotime($date.'+1 hour')); //konwersja daty
				$timetobet = date('Y-m-d H:i:s', strtotime($date.'-15 minutes'));
				$matchfinished = date('Y-m-d H:i:s', strtotime($date.'+2 hour'));
				$time=time(); //odzczytanie czasu serwera
				$time=date('Y-m-d H:i:s');
				$id_match=$row2['id_match'];
				$city=$row2['city'];
				$id_country1=$row2['id_country1'];
				$name_country1=$row2['name_country1'];		
				$id_country2=$row2['id_country2'];
				$name_country2=$row2['name_country2'];
				$logo_country1=$row2['logo_country1'];
				$logo_country2=$row2['logo_country2'];
				$country1_goals=$row2['country1_goals'];
				$country2_goals=$row2['country2_goals'];
				$match_status=$row2['match_status'];
				$name_country1=strtr($name_country1,' ','_');
				$name_country2=strtr($name_country2,' ','_');					// zamienia spacje na podkreślnik
				$elapsed=$row2['elapsed'];										//wyciaganie z bazy danych informacji
				$URLcountry1="images/flag/".$name_country1.".jpg";
				$URLcountry2="images/flag/".$name_country2.".jpg";
				
				$sql3="SELECT * FROM standings WHERE id_team='$id_country1'"; //pobieranie polskich nazw panstw
				if($result3=@$connect->query($sql3)){
				$row3=$result3->fetch_assoc();
				$name_country1=$row3['polish_name'];
				$result3->close();}

				$sql4="SELECT * FROM standings WHERE id_team='$id_country2'"; //pobieranie polskich nazw panstw
				if($result4=@$connect->query($sql4)){
				$row4=$result4->fetch_assoc();
				$name_country2=$row4['polish_name'];
				$result4->close();}
				?>
				<div id='country_matchcontainer'>
					<?php echo "<a href='country.php?teamid=$id_country1'><img class='flag' src=".$URLcountry1." alt='flag of ".$name_country1."'> ".$name_country1."</a>
					<a href='country.php?teamid=$id_country2'>".$name_country2." <img class='flag' src='".$URLcountry2."' alt='flag of ".$name_country2."'></a>"?>
				</div>
				<?php
				endfor;
				?>
			</div>
		</form>
	</div>
	<?php
	endif;
	?>
	</div>
</body>
</html>