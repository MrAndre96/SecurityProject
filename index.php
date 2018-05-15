<?php
session_start();

// Start with default low if no choice has been made.
if (isset($_POST['difficulty'])) {
	$_SESSION['difficulty'] = $_POST['difficulty'];
} else {
	$_SESSION['difficulty'] = 'low';
}
require 'database.php';


if( isset($_SESSION['user_id']) ){
	if($_SESSION['difficulty'] == 'low'){
		echo 'Logged in';
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

if (isset($_POST['submit'])){
	if(!empty($_POST['email']) && !empty($_POST['password'])){

		if($_SESSION['difficulty'] == 'low'){
			//$query  = 'SELECT id,email,password FROM users WHERE email =\'test\';';
			//$query  = 'SELECT id,email,password FROM users WHERE email =\'test\' OR 1=1;';
			// $email = $_POST['email'];
			// $password = $_POST['password'];
			
			// $query  = 'SELECT id,email,password FROM users WHERE email = ' . $email . ' && password = ' . $password . '';
			
			$email = $_POST['email'];
			$password = password_hash($_POST['password'], PASSWORD_BCRYPT);

			//Check username and password from database
			$sql='SELECT id,email,password FROM users WHERE email="'.$email.'" && password="'.$password.'"';
			
			$records = mysqli_query($connection, $sql);
			$results = mysqli_fetch_array($records,MYSQLI_ASSOC);
			$message = '';

			if($results){
				$_SESSION['user_id'] = $results['id'];
				header("Location: /");
			} else {
				$message = 'Sorry, those credentials do not match';
			}

		} else if($_SESSION['difficulty'] == 'medium'){
			  preg_match_all("/([A-z 0-9_]+)/", $_POST['email'], $out, 0); // Search the input for all characters between [] and store them in $out
			  $email = $out[0][0]; // Access the first element (2D array)
			  $query  = 'SELECT id,email,password FROM users WHERE email =\'' . $email . '\';'; // Do the query using the fixed.
			  echo $query;
			  $result = mysqli_query($connection, $query);

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
		} else {
			echo 'Index.php: Wrong settings specified in settings file' . '<br>';
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

<div style="margin-left: 0px; text-align: left">
	<form action="index.php" method="POST">
		
		<input name="difficulty" type="submit" value="low" style="width: 100px; background-color: green">
		<input name="difficulty" type="submit" value="medium" style="width: 100px; background-color: orange">
		<input name="difficulty" type="submit" value="high" style="width: 100px; background-color: red">

	</form>
</div>

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
