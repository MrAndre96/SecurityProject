<?php
$server = 'localhost';
$username = 'root';
$password = 'd8n2';
$database = 'SecurityProject';

echo 'In database.php: ' . $_POST['difficulty'] . '<br>';

if($_SESSION['difficulty'] == 'low'){
	$connection = mysqli_connect($server, $username, $password, $database);
	if (!$connection)
	{
		die('Could not connect: ' . mysql_error());
	}
	else
	{
		//echo "Connected<br>";
	}

	//$dbcheck = mysqli_select_db("$database");
    //if (!$dbcheck) {
	//	echo "Could not connect to $database";
    //    echo mysqli_error();
    //}else{
	//	echo "Connected with $database";
	//}

} else if($_SESSION['difficulty'] == 'medium'){

} else if($_SESSION['difficulty'] == 'high'){
	try{
		$conn = new PDO("mysql:host=$server;dbname=$database;", $username, $password);
	} catch(PDOException $e){
		die( "Connection failed: " . $e->getMessage());
	}
} else{
	echo 'Database.php: Wrong settings specified in settings file' . '<br>';
}
