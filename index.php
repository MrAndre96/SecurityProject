<?php
session_start();
if (isset($_POST['difficulty'])) {
	$_SESSION['difficulty'] = $_POST['difficulty'];
} else if(empty($_SESSION['difficulty'])) {
	$_SESSION['difficulty'] = 'low';
}
require 'database.php';

if( isset($_SESSION['user_id']) ){
	if($_SESSION['difficulty'] == 'low' || $_SESSION['difficulty'] == 'medium'){
		$sql='SELECT id,email,password FROM users WHERE id="'.$_SESSION['user_id'].'"';

		$records = mysqli_query($connection, $sql);
		$results = mysqli_fetch_array($records,MYSQLI_ASSOC);
		$user = $results;
	} else if($_SESSION['difficulty'] == 'high'){
		$records = $conn->prepare('SELECT id,email,password FROM users WHERE id = :id');
		$records->bindParam(':id', $_SESSION['user_id']);
		$records->execute();
		$results = $records->fetch(PDO::FETCH_ASSOC);

		$user = $results;
	}
}

if (isset($_POST['submit'])){
	if(!empty($_POST['email']) && !empty($_POST['password'])){

		if($_SESSION['difficulty'] == 'low'){
			//Check username and password from database
			$sql='SELECT id,email,password FROM users WHERE email="'.$_POST['email'].'" && password="'.$_POST['password'].'"';

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
            preg_match_all("/([A-z0-9@._]+)/", $_POST['email'], $out, 0); // Search the input for all characters between [] and store them in $out
            $email = $out[0][0]; // Access the first element (2D array)

            preg_match_all("/([A-z0-9@._!@#$%^*()]+)/", $_POST['password'], $out, 0); // Search the input for all characters between [] and store them in $out
            $password = $out[0][0]; // Access the first element (2D array)
            $sql  = 'SELECT id,email,password FROM users WHERE email ="'.$email.'" && password="'.$password.'"';

            $records = mysqli_query($connection, $sql);
            $results = mysqli_fetch_array($records,MYSQLI_ASSOC);
            $message = '';

            if($results){
                $_SESSION['user_id'] = $results['id'];
                header("Location: /");
            } else {
                $message = 'Sorry, those credentials do not match';
            }

		} else if($_SESSION['difficulty'] == 'high'){
			$records = $conn->prepare('SELECT id,email,password FROM users WHERE email = :email');
			$records->bindParam(':email', $_POST['email']);
			$records->execute();
			$results = $records->fetch(PDO::FETCH_ASSOC);

			$message = '';

			if($results > 0 && password_verify($_POST['password'], $results['password']) ){

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

?>

<!DOCTYPE html>
<html>
	<head>
		<title>Login Below</title>
		<link rel="stylesheet" type="text/css" href="assets/css/style.css">
		<link href='http://fonts.googleapis.com/css?family=Comfortaa' rel='stylesheet' type='text/css'>
	</head>
	<body>
		<form action="#" method="POST">
			Security Level:&nbsp
			<?php if($_SESSION['difficulty'] == 'low'){ ?>
				<input name="difficulty" type="submit" value="low" style="width: 100px; background-color: red">
			<?php } else{ ?>
				<input name="difficulty" type="submit" value="low" style="width: 100px; background-color: gray">
			<?php }?>

			<?php if($_SESSION['difficulty'] == 'medium'){ ?>
				<input name="difficulty" type="submit" value="medium" style="width: 100px; background-color: orange">
			<?php } else{ ?>
				<input name="difficulty" type="submit" value="medium" style="width: 100px; background-color: gray">
			<?php }?>

			<?php if($_SESSION['difficulty'] == 'high'){ ?>
				<input name="difficulty" type="submit" value="high" style="width: 100px; background-color: green">
			<?php } else{ ?>
				<input name="difficulty" type="submit" value="high" style="width: 100px; background-color: gray">
			<?php }?>
		</form>

		<div class="header">
			<a href="/">Temp App Name</a>
		</div>

		<?php if(!empty($user)){ ?>

			<br />Welcome <?= $user['email']; ?>
			<br /><br />You are successfully logged in!
			<br /><br />
			<a href="logout">Logout?</a>

		<?php }else{ ?>

		<?php if(!empty($message)){ ?>
			<p><?php echo $message ?></p>
		<?php } ?>

			<h1>Login</h1>
			<span>or <a href="register">register here</a></span>

			<form action="#" method="POST">

				<input type="text" placeholder="Enter your email" name="email">
				<input type="password" placeholder="and password" name="password">

				<input name="submit" type="submit" value="Inloggen">

			</form>

		<?php } ?>
	</body>
</html>