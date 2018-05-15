<?php
$server = 'localhost';
$username = 'root';
$password = 'd8n2';
$database = 'SecurityProject';

<<<<<<< HEAD
=======
echo 'In database.php: ' . $_POST['difficulty'] . '<br>';
>>>>>>> bc0cffbbfe3ee3b8857d346d366e1ce9f87186a9

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
	echo 'Database.php: Wrong settings specified in settings file' . '<br>';
}
