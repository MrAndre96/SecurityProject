<?php

session_start();

require 'database.php';
require 'settings.php';

if( isset($_SESSION['user_id']) ){
	if($_SESSION['difficulty'] == 'low'){
		
	} else if($_SESSION['difficulty'] == 'high'){
		$records = $conn->prepare('SELECT id,email,password FROM users WHERE id = :id');
		$records->bindParam(':id', $_SESSION['user_id']);
		$records->execute();
		$results = $records->fetch(PDO::FETCH_ASSOC);

		$user = NULL;

		if( count($results) > 0){
			$user = $results;
		}
	}
}

$_SESSION['difficulty'] = $_DIFFICULTY;

if (isset($_POST['submit'])){
	if(!empty($_POST['email']) && !empty($_POST['password'])){
		

		if($_SESSION['difficulty'] == 'low'){
			//$query  = 'SELECT id,email,password FROM users WHERE email =\'test\';';
			//$query  = 'SELECT id,email,password FROM users WHERE email =\'test\' OR 1=1;';
			$query  = 'SELECT id,email,password FROM users WHERE email =\'' . $_POST['email'] . '\';';
			echo $query;
			$result = mysqli_query($connection, $query);


			while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
				echo $row['id'] . ', ' . $row['email'] . ', ' . $row['password'] . '<br>';
			}

			mysqli_close($connection);

		} else if($_SESSION['difficulty'] == 'medium'){

		} else if($_SESSION['difficulty'] == 'high'){
			$records = $conn->prepare('SELECT id,email,password FROM users WHERE email = :email');
			$records->bindParam(':email', $_POST['email']);
			$records->execute();
			$results = $records->fetch(PDO::FETCH_ASSOC);

			$message = '';

			if(count($results) > 0 && password_verify($_POST['password'], $results['password']) ){

				$_SESSION['user_id'] = $results['id'];
				header("Location: /");

			} else {
				$message = 'Sorry, those credentials do not match';
			}
		} else{
			echo 'Wrong settings specified in settings file';
		}


	}
}
//endif;

?>

<!DOCTYPE html>
<html>
<head>
	<title>Login Below</title>
	<link rel="stylesheet" type="text/css" href="assets/css/style.css">
	<link href='http://fonts.googleapis.com/css?family=Comfortaa' rel='stylesheet' type='text/css'>
</head>
<body>

	<div class="header">
		<a href="/">Your App Name</a>
	</div>

	
	
	<?php if( !empty($user) ): ?>

		<br />Welcome <?= $user['email']; ?> 
		<br /><br />You are successfully logged in!
		<br /><br />
		<a href="logout.php">Logout?</a>

	<?php else: ?>

		<?php if(!empty($message)): ?>
		<p><?= $message ?></p>
		<?php endif; ?>

		<h1>Login</h1>
		<span>or <a href="register.php">register here</a></span>

		<form action="#" method="POST">
			
			<input type="text" placeholder="Enter your email" name="email">
			<input type="password" placeholder="and password" name="password">

			<input name="submit" type="submit" value="Inloggen">

		</form>

	<?php endif; ?>

</body>
</html>
