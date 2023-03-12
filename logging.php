<?php

session_start();

if((!isset($_POST['login']))||(!isset($_POST['password'])))
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
	$login=$_POST['login'];	//przypisanie do zminnej loginu informacji wpisanej w pole w login w index.php
	$password=$_POST['password'];
	
	$login=htmlentities($login,ENT_QUOTES,"UTF-8");	//zabezpieczenie czy dominik nie probuje oszukac
	$password=htmlentities($password,ENT_QUOTES,"UTF-8");
	
	$sql="SELECT * FROM accounts WHERE login='$login' AND password='$password'";	//zapytanie do bazy
	
	if($result=@$connect->query($sql))	//wysłanie zapytania do bazy
	{
		$user_check=$result->num_rows;	//spradzenie ile jest porawnych wyników tego loginu i hasła
		if($user_check>0)
		{
			$_SESSION['logged']=true;	//zmienna pomocniza czy zalogowany ==true
			
			$row=$result->fetch_assoc(); 	//tu jest mozliwosc wyciagniecia informacji z bazy
			$_SESSION['name']=$row['name'];
			$_SESSION['id']=$row['id_accounts'];
			$_SESSION['principle']=$row['isknownprinciple'];
			
			unset($_SESSION['logged_error']);		//usuniecie błędu "niepoprawny login"
			$result->close();				//zamknięcier zapytania
			if($_SESSION['principle']==0)
			{
				header('Location: principles.php');
			}
			else
			{
				header('Location: main.php');	//przekierowanie
			}		
		}
		else
		{
		$_SESSION['logged_error']='<span style="color:white">Nieprawidłowy login lub hasło!</span>';		//zero wyników loginu i hasła
		header('Location: index.php');		//przekierowanie
		}
	}
	
	$connect->close();
	
}

?>