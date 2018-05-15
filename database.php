<?php
$server = 'localhost';
$username = 'root';
$password = '';
$database = 'securityproject';


if($_SESSION['difficulty'] == 'low'){
	$connection = mysqli_connect($server, $username, $password, $database);
	if (!$connection)
	{
		die('Could not connect: ' . mysql_error());
	}

} else if($_SESSION['difficulty'] == 'medium'){

} else if($_SESSION['difficulty'] == 'high'){
	try{
		$conn = new PDO("mysql:host=$server;dbname=$database;", $username, $password);
	} catch(PDOException $e){
		die( "Connection failed: " . $e->getMessage());
	}
} else{
	echo 'Wrong settings specified in settings file';
}
