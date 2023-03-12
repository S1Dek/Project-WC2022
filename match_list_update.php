<?php

$curl = curl_init();
require_once "connect.php";

curl_setopt_array($curl, [
	CURLOPT_URL => "https://api-football-v1.p.rapidapi.com/v3/fixtures?league=1&season=2022",
	CURLOPT_RETURNTRANSFER => true,
	CURLOPT_FOLLOWLOCATION => true,
	CURLOPT_ENCODING => "",
	CURLOPT_MAXREDIRS => 10,
	CURLOPT_TIMEOUT => 30,
	CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
	CURLOPT_CUSTOMREQUEST => "GET",
	CURLOPT_HTTPHEADER => [
		"X-RapidAPI-Host: api-football-v1.p.rapidapi.com",
		"X-RapidAPI-Key: b031db6fc6mshf80c4815b722109p10e5d9jsnbc1c6a0e84c8"
	],
]);

$response = curl_exec($curl);
$err = curl_error($curl);

curl_close($curl);

if ($err) {
	echo "cURL Error #:" . $err;
} else {
	$tab = json_decode($response,true);
	var_dump($tab); 

$connect= @new mysqli($db_domain,$db_login,$db_password,$db_name);	//połączenie do bazy
if($connect->connect_errno!=0) //sprawdzenie czy polaczenie sie nie udało
{
	echo "Error;".$connect->connect_errno;	
}
else
{
	$a=$tab["results"];
	for ($i=0; $i<$a; $i++)
	{
	$id_match=$tab["response"][$i]["fixture"]["id"];
	$date=$tab["response"][$i]["fixture"]["date"];
	$timestamp=$tab["response"][$i]["fixture"]["timestamp"];
	$stadium_name=$tab["response"][$i]["fixture"]["venue"]["name"];
	$city=$tab["response"][$i]["fixture"]["venue"]["city"];
	$round=$tab["response"][$i]["league"]["round"];
	$hometeam_id=$tab["response"][$i]["teams"]["home"]["id"];
	$hometeam_name=$tab["response"][$i]["teams"]["home"]["name"];
	$hometeam_logo=$tab["response"][$i]["teams"]["home"]["logo"];
	$awayteam_id=$tab["response"][$i]["teams"]["away"]["id"];
	$awayteam_name=$tab["response"][$i]["teams"]["away"]["name"];
	$awayteam_logo=$tab["response"][$i]["teams"]["away"]["logo"];
	$h_goals=$tab["response"][$i]["goals"]["home"];
	$a_goals=$tab["response"][$i]["goals"]["away"];
	$match_status=$tab["response"][$i]["fixture"]["status"]["short"];
	$elapsed=$tab["response"][$i]["fixture"]["status"]["elapsed"];
	
	$sql_check="SELECT * FROM match_list WHERE id_match='$id_match'";
	$sql_add="INSERT INTO match_list VALUES('$id_match','$date','$timestamp','$stadium_name','$city','$round','$hometeam_id','$hometeam_name','$hometeam_logo','$awayteam_id','$awayteam_name','$awayteam_logo','$h_goals','$a_goals','$match_status','$elapsed')";
	$sql_update="UPDATE match_list SET country1_goals='$h_goals', country2_goals='$a_goals', match_status='$match_status', elapsed='$elapsed' WHERE id_match='$id_match' ";
	
		if($result=$connect->query($sql_check))
		{
			$amount_of_records=$result->num_rows;	//spradzenie ile jest porawnych wyników tego zapytania
			if($amount_of_records>0)
			{
				if($connect->query($sql_update))
					{echo "Record '$i' updated successfully; ";}
				else
					{ echo "Error: " . $sql . "<br>" . $connect->error;}
			}
			else
			{
				if($connect->query($sql_add))
					{echo "New record created successfully";}
				else
					{ echo "Error: " . $sql . "<br>" . $connect->error;}
			}
			$result->close();
		}
		else	
			{echo "Error: " . $sql . "<br>" . $connect->error;}
	}
	$connect->close();
}
}
	

?>