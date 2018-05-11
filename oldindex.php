<?php

session_start();

require 'database.php';
require 'settings.php';

if( isset($_SESSION['user_id']) ){

	$records = $conn->prepare('SELECT id,email,password FROM users WHERE id = :id');
	$records->bindParam(':id', $_SESSION['user_id']);
	$records->execute();
	$results = $records->fetch(PDO::FETCH_ASSOC);

	$user = NULL;

	if( count($results) > 0){
		$user = $results;
	}

}

?>

<!DOCTYPE html>
<html>
<head>
	<title>Security project</title>
	<link rel="stylesheet" type="text/css" href="assets/css/style.css">
	<link href='http://fonts.googleapis.com/css?family=Comfortaa' rel='stylesheet' type='text/css'>
</head>
<body>

	<div class="header">
		<a href="/">Security project</a>
	</div>
	<textarea>Er zijn drie security niveaus beschikbaar:&#13;&#10;-low&#13;&#10;-medium&#13;&#10;-high</textarea>
	<!--<textarea style="resize: none; width: 300px; height: 200px;">Er zijn drie security niveaus beschikbaar:&#13;&#10;-low&#13;&#10;-medium&#13;&#10;-high</textarea>-->

	<?php 
		$_SESSION['difficulty'] = $_DIFFICULTY;
	?>

	<?php if( !empty($user) ): ?>

		<br />Welcome <?= $user['email']; ?> 
		<br /><br />You are successfully logged in!
		<br /><br />
		<a href="logout.php">Logout?</a>

	<?php else: ?>

		<!--<h1>Please Login or Register</h1>
		<a href="login.php">Login</a> or
		<a href="register.php">Register</a>-->

	<?php endif; ?>

</body>
</html>
