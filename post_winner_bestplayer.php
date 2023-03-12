<?php

session_start();

if(!$_SESSION['logged'])
{
	header('Location: index.php');
	exit();
}

require_once "connect.php";

$connect= @new mysqli($db_domain,$db_login,$db_password,$db_name);	//połączenie do bazy
if($connect->connect_errno!=0) //sprawdzenie czy polaczenie sie nie udało
{
	echo "Error;".$connect->connect_errno;	
}
else
{
	$champion=$_POST['champion'];
	$blackhorse=$_POST['blackhorse'];
	$topscorer=$_POST['ts'];
	$goalkeeper=$_POST['goalkeeper'];	
	$poland=$_POST['poland'];
	
	if($champion!="ktos_inny"){
	$sql="SELECT front_runner FROM standings WHERE polish_name='$champion'";
	if($result=@$connect->query($sql))
		{
		$row=$result->fetch_assoc();
		$odd_1=$row['front_runner'];
		$result->close();
		}
	}
	else
	{
		$odd_1=25;
	}
	
	$sql1="SELECT black_horse FROM standings WHERE polish_name='$blackhorse'";
	if($result1=@$connect->query($sql1))
	{
	$row1=$result1->fetch_assoc();
	$odd_2=$row1['black_horse'];
	$result1->close();
	}
	
	if($topscorer!="ktos_inny")
	{
	$sql2="SELECT award FROM players WHERE name_player='$topscorer'";
	if($result2=@$connect->query($sql2))
		{
		$row2=$result2->fetch_assoc();
		$odd_3=$row2['award'];
		$result2->close();
		}
	}
	else
	{
		$odd_3=25;
	}
	
	if($goalkeeper!="ktos_inny")
	{
	$sql3="SELECT award FROM players WHERE name_player='$goalkeeper'";
	if($result3=@$connect->query($sql3))
		{
		$row3=$result3->fetch_assoc();
		$odd_4=$row3['award'];
		$result3->close();
		}
	}
	else
	{
		$odd_4=25;
	}
	
	$sql4="SELECT odd FROM where_polska WHERE round='$poland'";
	if($result4=@$connect->query($sql4))
	{
	$row4=$result4->fetch_assoc();
	$odd_5=$row4['odd'];
	$result4->close();
	}
	$id=$_SESSION['id'];
	
	$sql_insert="INSERT INTO other_odds VALUES('$id','$odd_1','$champion','$odd_3','$topscorer','$odd_4','$goalkeeper','$odd_2','$blackhorse','$odd_5','$poland')";
	$result_insert=@$connect->query($sql_insert);
	
	$sql_update="UPDATE accounts SET iscompleteodds='1' WHERE id_accounts='$id'";
	$result_update=@$connect->query($sql_update);
	
$connect->close();	
}
header('Location: winner_bestplayers.php');

?>