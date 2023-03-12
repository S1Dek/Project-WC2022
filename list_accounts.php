<?php

session_start();
if(!isset($_SESSION['logged']))
{
	header('Location: index.php');
	exit();
}
require_once "connect.php"; 
	$connect= @new mysqli($db_domain,$db_login,$db_password,$db_name);	//połączenie do bazy
if($connect->connect_errno!=0): //sprawdzenie czy polaczenie sie nie udało			
		echo "Error;".$connect->connect_errno;
else:		
	$sql="SELECT * FROM accounts ORDER BY points DESC LIMIT 10"; //pobieranie wszystkich meczow z bazy
	if($result=$connect->query($sql)){	//wysłanie zapytania do bazy
	$czy_jest=0;
	
for ($i = 1; $i <= 10; $i++):
	$row=$result->fetch_assoc();
	$name[$i]=$row["name"];
	if($_SESSION['name']==$name[$i])
	{	
		$czy_jest=1;
	}
	$points[$i]=$row["points"];
endfor;

if($czy_jest=0)
{
	$name[10]=$_SESSION['name'];
	$sql_point="SELECT points FROM accounts WHERE name='$name[10]'";
	$result=$connect->query($sql_point);	//wysłanie zapytania do bazy
	$row=$result->fetch_assoc();
	$points[10]=$row["points"];
	
}
$result->close();
}


$dataPoints = array(
	array("label"=> $name[1], "y"=>$points[1] ),
	array("label"=> $name[2], "y"=> $points[2]),
	array("label"=> $name[3], "y"=> $points[3]),
	array("label"=> $name[4], "y"=> $points[4]),
	array("label"=> $name[5], "y"=> $points[5]),
	array("label"=> $name[6], "y"=> $points[6]),
	array("label"=> $name[7], "y"=>$points[7]),
	array("label"=> $name[8], "y"=> $points[8]),
	array("label"=> $name[9], "y"=> $points[9]),
	array("label"=> $name[10], "y"=> $points[10])
);
	
?>
<!DOCTYPE HTML>
<html>
<head>  
	<meta charset="utf-8"/>
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1"/>
	<link rel="stylesheet" href="style.css">
	<link rel="preconnect" href="https://fonts.googleapis.com">
	<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
	<link href="https://fonts.googleapis.com/css2?family=Noto+Serif+Gujarati:wght@400;700&display=swap" rel="stylesheet"> <!-- import czcionki -->
	<title>Mundial Katar 2022</title>
<script>
window.onload = function () {
 
var chart = new CanvasJS.Chart("chartContainer", {
	animationEnabled: true,
	theme: "light2",
	title: {
		text: "Top 10 naszego obstawiania"
	},
	axisY: {
		suffix: "pkt",
		scaleBreaks: {
			autoCalculate: false
		}
	},
	data: [{
		type: "column",
		yValueFormatString: "#.##\"pkt\"",
		indexLabel: "{y}",
		indexLabelPlacement: "inside",
		indexLabelFontColor: "white",
		dataPoints: <?php echo json_encode($dataPoints, JSON_NUMERIC_CHECK); ?>
	}]
});
chart.render();
 
}
</script>
</head>
<body>
	<?php require_once "navigation.php"; ?>
	<div id="main" >
		<div style=" margin-top:5%;">
		<?php $name=$_SESSION['name'];
		$sql1="SELECT points FROM accounts WHERE name='$name' ";
		if($result1=$connect->query($sql1)){
			$row1=$result1->fetch_assoc();
			$points=$row1['points'];
		echo "$name  : $points pkt";
		$result1->close();
		}
		?>
		</div>	
		<div id="chartContainer" style=" margin-top:5%;"></div>		
	</div>




<script src="https://canvasjs.com/assets/script/canvasjs.min.js"></script>
<?php endif;?>
</body>
</html>                    