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
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
</head>
<body>
	<?php require_once "navigation.php"; ?>
	<div id="main">
	<?php require_once "connect.php"; 
	$connect= @new mysqli($db_domain,$db_login,$db_password,$db_name);	//połączenie do bazy
		if($connect->connect_errno!=0): //sprawdzenie czy polaczenie sie nie udało			
		echo "Error;".$connect->connect_errno;
		else:		
		$sql="SELECT * FROM match_list WHERE odd_1>'1' ORDER BY timestamp"; //pobieranie wszystkich meczow z bazy
		$result=@$connect->query($sql);	//wysłanie zapytania do bazy		
		$amount_of_results=$result->num_rows; //zliczanie wyników zapytania
		for ($i = 1; $i <= $amount_of_results; $i++):
		$row=$result->fetch_assoc();
		$date=$row['date'];
		$date = date('Y-m-d H:i:s', strtotime($date.'+1 hour')); //konwersja daty
		$timetobet = date('Y-m-d H:i:s', strtotime($date.'-15 minutes'));
		$matchfinished = date('Y-m-d H:i:s', strtotime($date.'+2 hour'));
		$time=time(); //odzczytanie czasu serwera
		$time=date('Y-m-d H:i:s');
		$stadium_name=$row['stadium_name'];
		$id_match=$row['id_match'];
		$city=$row['city'];
		$id_country1=$row['id_country1'];
		$name_country1=$row['name_country1'];		
		$id_country2=$row['id_country2'];
		$name_country2=$row['name_country2'];
		$logo_country1=$row['logo_country1'];
		$logo_country2=$row['logo_country2'];
		$country2_goals=$row['country2_goals'];
		$country1_goals=$row['country1_goals'];
		$match_status=$row['match_status'];
		$name_country1=strtr($name_country1,' ','_');
		$name_country2=strtr($name_country2,' ','_');								// zamienia spacje na podkreślnik
		$elapsed=$row['elapsed'];	//wyciaganie z bazy danych informacji
		$URLstadium="url('images/".$stadium_name.".jpg')  center ";
		$URLcountry1="images/flag/".$name_country1.".jpg";
		$URLcountry2="images/flag/".$name_country2.".jpg";
		
		$sql1="SELECT * FROM standings WHERE id_team='$id_country1'"; //pobieranie polskich nazw panstw
        if($result1=@$connect->query($sql1)){
        $row1=$result1->fetch_assoc();
        $name_country1=$row1['polish_name'];
		$result1->close();}

        $sql2="SELECT * FROM standings WHERE id_team='$id_country2'"; //pobieranie polskich nazw panstw
        if($result2=@$connect->query($sql2)){
        $row2=$result2->fetch_assoc();
        $name_country2=$row2['polish_name'];
		$result2->close();}
		
		if($time>$matchfinished):
		?>	
			<form action="add_score.php?matchid=<?php echo $id_match?>&odd_1=<?php echo $odd_1?>&odd_X=<?php echo $odd_X?>&odd_2=<?php echo $odd_2?> " method="post">
			<div id="matchcontainer" style="background:<?php echo $URLstadium?>" >
				<?php echo"<div id='space_matchcontainer'></div><div id=name_matchcontainer><a href='match.php?matchid=$id_match'>".$date." ".$stadium_name." ".$city."</a></div><div id='space_matchcontainer'></div>
				<div id=host_matchcontainer><a href='country.php?teamid=$id_country1'><img class='flag' src=".$URLcountry1." alt='flag of ".$name_country1."'></a>".$name_country1."</div><div id=minute_matchcontainer>".$elapsed."'</div><div id=guest_matchcontainer>"." <a href='country.php?teamid=$id_country2'><img class='flag' src='".$URLcountry2."' alt='flag of ".$name_country2."'></a>$name_country2</div>
				<div id=host_matchcontainer_goal>".$country1_goals."</div>
				<div id=guest_matchcontainer_goal>".$country2_goals."</div>" ?>	
			</div>
			<input type="hidden" name="scrollPosition" class="scrollPosition" />
			</form>
		<?phpelseif($matchfinished==0):?>
			<form>
			<div id="matchcontainer">
				<?php echo"<div id=name_matchcontainer></div>" ?>	
			</div>
			<input type="hidden" name="scrollPosition" class="scrollPosition" />
			</form>
		<?php
		endif;
		endfor;		
		endif;
		 if ( isset($_POST["scrollPosition"] ) ): ?>
        // JUMP BACK TO SCROLL LOCATION WHEN FORM WAS SUBMITTED
        window.scrollTo( 0, <?php echo intval( $_POST["scrollPosition"] ); ?> );
		<?php endif; ?>
	</div>
	<script type="text/javascript">
	$(document).ready(function () {

    if (localStorage.getItem("my_app_name_here-quote-scroll") != null) {
        $(window).scrollTop(localStorage.getItem("my_app_name_here-quote-scroll"));
    }

    $(window).on("scroll", function() {
        localStorage.setItem("my_app_name_here-quote-scroll", $(window).scrollTop());
    });

  });
	</script>
</body>