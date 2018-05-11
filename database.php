<?php
$server = 'localhost';
$username = 'root';
$password = 'd8n2';
$database = 'securityproject';

require 'settings.php';


if($_DIFFICULTY == 'low'){
	$connection = mysqli_connect($server, $username, $password, $database);
	if (!$connection)
	{
		die('Could not connect: ' . mysql_error());
	}
	else
	{
		echo "Connected<br>";
	}

	//$dbcheck = mysqli_select_db("$database");
    //if (!$dbcheck) {
	//	echo "Could not connect to $database";
    //    echo mysqli_error();
    //}else{
	//	echo "Connected with $database";
	//}

} else if($_DIFFICULTY == 'medium'){

} else if($_DIFFICULTY == 'high'){
	try{
		$conn = new PDO("mysql:host=$server;dbname=$database;", $username, $password);
	} catch(PDOException $e){
		die( "Connection failed: " . $e->getMessage());
	}
} else{
	echo 'Wrong settings specified in settings file';
}
