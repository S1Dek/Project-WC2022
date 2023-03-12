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
	if($_SESSION['principle']==0) //jezeli do tej pory chceck box nie pokazuj ponownie nigdy nie zotsal zaznaczony
	{ 
		if (isset($_POST['checkbox'])) //jezeli checkbox nie pokazuj ponownie zostal teraz zaznaczony
		{
			$a=1;
			$id=$_SESSION['id'];
			$sql=" UPDATE accounts SET isknownprinciple='$a' WHERE id_accounts='$id'";
			if($result=@$connect->query($sql))	//wysłanie zapytania do bazy
			{
				$_SESSION['principle']=1;
			}		
		}
	}
	
}
header('Location: main.php');