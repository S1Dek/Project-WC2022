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
			$id=$_SESSION['id'];
			$a=0;
			$sql="SELECT * FROM accounts WHERE id_accounts='$id'";
			if($result=$connect->query($sql))
			{
				$row=$result->fetch_assoc();
				$abc=$row['iscompleteodds'];
				if($abc==1)
				{
					$a=$abc;//czy jest uzupełniony już ten formularz
				}
				$result->close();
			}
			$time=time(); //odzczytanie czasu serwera
			$time=date('Y-m-d H:i:s');
			
			if($a==0 and $time<"2022-11-20 17:00:00")://jeżeli formularz nie jest uzupełniony
				?>
				<form action="post_winner_bestplayer.php" method="post">
					<h3>Kto wygra mistrzostwa świata?</h3>
					<select id="champion" name="champion">
						<?php 
							$sql="SELECT polish_name,front_runner FROM standings WHERE front_runner>1 ORDER BY front_runner";
							if($result=@$connect->query($sql))
							{
								$amount_of_results=$result->num_rows;
								for($i = 1; $i <= $amount_of_results; $i++)
								{
									$row=$result->fetch_assoc();
									$polish_name=$row['polish_name'];
									$front_runner=$row['front_runner'];
									echo "<option value='$polish_name'> $polish_name  |  $front_runner </option>";
								}
							$result->close();
							}
						?>
							<option value="ktos_inny"> Ktoś inny  |  25 </option>
					</select >
					<h3>Kto zostanie królem strzelców?</h3>
					<select id="ts" name="ts">
						<?php 
							$sql="SELECT name_player,award FROM players WHERE position='Attacker' AND award>1 ORDER BY award";
							if($result=@$connect->query($sql))
							{
								$amount_of_results=$result->num_rows;
								for($i = 1; $i <= $amount_of_results; $i++)
								{
									$row=$result->fetch_assoc();
									$name_player=$row['name_player'];
									$award=$row['award'];
									echo "<option value='$name_player'> $name_player  |  $award </option>";
								}
							$result->close();
							}							
						?>
						<option value="ktos_inny"> Ktoś inny  |  25 </option>
					</select>
					<h3>Kto zostanie najlepszym bramkarzem?</h3>
					<select id="goalkeeper" name="goalkeeper">
						<?php 
							$sql="SELECT name_player,award FROM players WHERE award>1 AND position='Goalkeeper' OR position='G' ORDER BY award";
							if($result=@$connect->query($sql))
							{
								$amount_of_results=$result->num_rows;
								for($i = 1; $i <= $amount_of_results; $i++)
								{
									$row=$result->fetch_assoc();
									$name_player=$row['name_player'];
									$award=$row['award'];
									echo "<option value='$name_player'> $name_player  |  $award </option>";
								}
							$result->close();
							}							
						?>
						<option value="ktos_inny"> Ktoś inny  |  25 </option>
					</select>
					<h3>Która z tych drużyn zajdzie najdalej? [czarny koń] </h3>
					<select id="blackhorse" name="blackhorse" >
						<?php 
							$sql="SELECT polish_name,black_horse FROM standings WHERE black_horse>1 ORDER BY black_horse";
							if($result=@$connect->query($sql))
							{
								$amount_of_results=$result->num_rows;
								for($i = 1; $i <= $amount_of_results; $i++)
								{
									$row=$result->fetch_assoc();
									$polish_name=$row['polish_name'];
									$black_horse=$row['black_horse'];
									echo "<option value='$polish_name'> $polish_name  |  $black_horse </option>";
								}
							$result->close();
							}
						?>
					</select>
					<h3>Na jakim etapie ukończy mistrzostwa nasza reprezentacja?</h3>
					<select id="poland" name="poland">
						<?php 
							$sql="SELECT round,odd FROM where_polska";
							if($result=@$connect->query($sql))
							{
								$amount_of_results=$result->num_rows;
								for($i = 1; $i <= $amount_of_results; $i++)
								{
									$row=$result->fetch_assoc();
									$round=$row['round'];
									$odd=$row['odd'];
									echo "<option value='$round'> $round  |  $odd </option>";
								}
							$result->close();
							}
						?>
					</select>
					<input type="submit"/>				
				</form>
				<?php
			else:								
				?>
				<h3>Kto wygra mistrzostwa świata?</h3>
					<?php $sql_1="SELECT * FROM other_odds ";
						if($result=@$connect->query($sql_1))
							{
								$amount_of_results=$result->num_rows;
								for($i = 1; $i <= $amount_of_results; $i++)
								{
									$row=$result->fetch_assoc();
									$champion=$row['name_champion'];
									$odd=$row['odd_champion'];
									$id_accounts=$row['id_accounts'];
									$sql2="SELECT * FROM accounts WHERE id_accounts='$id_accounts'";
									if($result1=@$connect->query($sql2))
									{
										$row1=$result1->fetch_assoc();
										$name=$row1['name'];
										$result1->close();
									}
									echo "<p class='winner'>$champion  |  $name |  $odd</p>";
								}
								$result->close();
							}
					?>
				<h3>Kto zostanie królem strzelców?</h3>
				  <?php $sql_1="SELECT * FROM other_odds ";
						if($result=@$connect->query($sql_1))
							{
								$amount_of_results=$result->num_rows;
								for($i = 1; $i <= $amount_of_results; $i++)
								{
									$row=$result->fetch_assoc();
									$name_odd=$row['name_topscorer'];
									$odd=$row['odd_topscorer'];
									$id_accounts=$row['id_accounts'];
									$sql2="SELECT * FROM accounts WHERE id_accounts='$id_accounts'";
									if($result1=@$connect->query($sql2))
									{
										$row1=$result1->fetch_assoc();
										$name=$row1['name'];
										$result1->close();
									}
									echo "<p class='winner'>$name_odd  |  $name |  $odd</p>";
								}
								$result->close();
							}
					?>
				<h3>Kto zostanie najlepszym bramkarzem?</h3>
					 <?php $sql_1="SELECT * FROM other_odds ";
						if($result=@$connect->query($sql_1))
							{
								$amount_of_results=$result->num_rows;
								for($i = 1; $i <= $amount_of_results; $i++)
								{
									$row=$result->fetch_assoc();
									$name_odd=$row['name_goalkeeper'];
									$odd=$row['odd_goalkeeper'];
									$id_accounts=$row['id_accounts'];
									$sql2="SELECT * FROM accounts WHERE id_accounts='$id_accounts'";
									if($result1=@$connect->query($sql2))
									{
										$row1=$result1->fetch_assoc();
										$name=$row1['name'];
										$result1->close();
									}
									echo "<p class='winner'>$name_odd  |  $name |  $odd</p>";
								}
								$result->close();
							}
					?>
				<h3>Która z tych drużyn zajdzie najdalej? [czarny koń]</h3>
					 <?php $sql_1="SELECT * FROM other_odds ";
						if($result=@$connect->query($sql_1))
							{
								$amount_of_results=$result->num_rows;
								for($i = 1; $i <= $amount_of_results; $i++)
								{
									$row=$result->fetch_assoc();
									$name_odd=$row['name_blackhorse'];
									$odd=$row['odd_blackhorse'];
									$id_accounts=$row['id_accounts'];
									$sql2="SELECT * FROM accounts WHERE id_accounts='$id_accounts'";
									if($result1=@$connect->query($sql2))
									{
										$row1=$result1->fetch_assoc();
										$name=$row1['name'];
										$result1->close();
									}
									echo "<p class='winner'>$name_odd  |  $name |  $odd</p>";
								}
								$result->close();
							}
					?>
				<h3>Na jakim etapie ukończy mistrzostwa nasza reprezentacja?</h3>
					 <?php $sql_1="SELECT * FROM other_odds ";
						if($result=@$connect->query($sql_1))
							{
								$amount_of_results=$result->num_rows;
								for($i = 1; $i <= $amount_of_results; $i++)
								{
									$row=$result->fetch_assoc();
									$name_odd=$row['name_poland'];
									$odd=$row['odd_poland'];
									$id_accounts=$row['id_accounts'];
									$sql2="SELECT * FROM accounts WHERE id_accounts='$id_accounts'";
									if($result1=@$connect->query($sql2))
									{
										$row1=$result1->fetch_assoc();
										$name=$row1['name'];
										$result1->close();
									}
									echo "<p class='winner'>$name_odd  |  $name |  $odd</p>";
								}
								$result->close();
							}
			endif;
		endif;
		?>
	</div>
</body>