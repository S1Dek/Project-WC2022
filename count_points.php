<?php
session_start();
	
if(!isset($_SESSION['logged']))
{
	header('Location: index.php');
	exit();
}

require_once "connect.php";

$connect= @new mysqli($db_domain,$db_login,$db_password,$db_name);    //połączenie do bazy
if($connect->connect_errno!=0) //sprawdzenie czy polaczenie sie nie udało
{
    echo "Error;".$connect->connect_errno;
}
else
{
		$time=time();
		$sql="SELECT * FROM bet WHERE match_finish<'$time' AND points_counted=0 ";
		if($result=@$connect->query($sql))
		{
			$amount_of_results=$result->num_rows;
			for($i = 1; $i <= $amount_of_results; $i++)
			{
				
				$row=$result->fetch_assoc();
				$id_match=$row['id_match'];
				$id_account=$row['id_accounts'];
				$odd=$row['odd'];
				$betgoalsH=$row['result_bet_c1'];
				$betgoalsA=$row['result_bet_c2'];
				
				if($betgoalsH>$betgoalsA)
				{
					$p="H";
				}
				else if($betgoalsH==$betgoalsA)
				{
					$p="X";
				}
				else
				{
					$p="A";
				}
				
				$sql_matchlist="SELECT * FROM match_list WHERE id_match='$id_match' ";
				if($result1=@$connect->query($sql_matchlist))
				{
					$row1=$result1->fetch_assoc();
					$goalsH=$row1['country1_goals'];
					$goalsA=$row1['country2_goals'];
					
					if($goalsH>$goalsA)
					{
						$a="H";
					}
					else if($goalsH==$goalsA)
					{
						$a="X";
					}
					else
					{
						$a="A";
					}
					
					if($goalsH==$betgoalsH and $goalsA==$betgoalsA )
					{
						$points=3*$odd;	
					}
					else if($p==$a)
					{
						$points=$odd;
					}
					else
					{
						$points=0;
					}
					
					$result1->close();
					$sql_acc="SELECT points FROM accounts WHERE id_accounts='$id_account'";
					if($result2=@$connect->query($sql_acc))
					{
							$row2=$result2->fetch_assoc();
							$points_db=$row2['points'];
							$result2->close();
							$points_gain=$points+$points_db;
							echo $points;
							$sql_update="UPDATE accounts SET points=$points_gain WHERE id_accounts='$id_account'";
							$sql_update2="UPDATE bet SET points_counted=true WHERE id_accounts='$id_account' AND id_match='$id_match'";
							if($result3=@$connect->query($sql_update))
							{
								;
							}
							if($result4=@$connect->query($sql_update2))
							{
								;
							}
					}				
				}
			}
			$result->close();
		}
	
}
?>