<?php

$curl = curl_init();
require_once "connect.php";

curl_setopt_array($curl, [
	CURLOPT_URL => "https://api-football-v1.p.rapidapi.com/v3/standings?season=2022&league=1",
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
} 
else 
{
	$tab = json_decode($response,true);
	var_dump($tab);
	
$connect= @new mysqli($db_domain,$db_login,$db_password,$db_name);	//połączenie do bazy
if($connect->connect_errno!=0) //sprawdzenie czy polaczenie sie nie udało
{
	echo "Error;".$connect->connect_errno;	
}
else
{
	for ($i=0; $i<8; $i++)
	{
	for ($j=0; $j<4; $j++)
	{
	$rank=$tab["response"][0]["league"]["standings"][$i][$j]["rank"];
	$id_team=$tab["response"][0]["league"]["standings"][$i][$j]["team"]["id"];
	$name_team=$tab["response"][0]["league"]["standings"][$i][$j]["team"]["name"];
	$logo_team=$tab["response"][0]["league"]["standings"][$i][$j]["team"]["logo"];
	$points=$tab["response"][0]["league"]["standings"][$i][$j]["points"];
	$goalsDiff=$tab["response"][0]["league"]["standings"][$i][$j]["goalsDiff"];
	$group_name=$tab["response"][0]["league"]["standings"][$i][$j]["group"];
	$pleyed=$tab["response"][0]["league"]["standings"][$i][$j]["all"]["played"];
	$wins=$tab["response"][0]["league"]["standings"][$i][$j]["all"]["win"];
	$draws=$tab["response"][0]["league"]["standings"][$i][$j]["all"]["draw"];
	$loses=$tab["response"][0]["league"]["standings"][$i][$j]["all"]["lose"];
	$goalsfor=$tab["response"][0]["league"]["standings"][$i][$j]["all"]["goals"]["for"];
	$goalsagainst=$tab["response"][0]["league"]["standings"][$i][$j]["all"]["goals"]["against"];
	
	$sql_check="SELECT * FROM standings WHERE id_team='$id_team'";
	$sql_add="INSERT INTO standings VALUES('$id_team','$name_team','$logo_team','$group_name','$rank','$points','$pleyed','$wins','$draws','$loses','$goalsDiff','$goalsfor','$goalsagainst','')";
	$sql_update="UPDATE standings SET rank='$rank', points='$points', pleyed='$pleyed',wins='$wins',draws='$draws',loses='$loses','goalsDiff=$goalsDiff',goalsFor='$goalsfor',goalsAgainst='$goalsagainst' WHERE id_team='$id_team' ";
	
		if($result=$connect->query($sql_check))
		{
			$amount_of_records=$result->num_rows;	//spradzenie ile jest porawnych wyników tego zapytania
			if($amount_of_records>0)
			{
				if($connect->query($sql_update))
					{echo "Record '$i' '$j' updated successfully;   ";}
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
	}}
	$connect->close();
}
}
