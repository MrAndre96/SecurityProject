<?php

session_start();

if( isset($_SESSION['user_id']) ){
	header("Location: /");
}

require 'database.php';

$message = '';
if (isset($_POST['submit'])){
	if(!empty($_POST['email']) && !empty($_POST['password']) && !empty($_POST['confirm_password'])) {

		if(!checkEmail($_POST['email'])){
			$message = "Incorrect email";
		} elseif(strlen($_POST['password']) < 6) {
			$message = "Your password must be at least 6 characters";
		} elseif($_POST['password'] != $_POST['confirm_password']) {
			$message = "Your passwords don't match";
		} else {
			// Enter the new user in the database
			$sql = "INSERT INTO users (email, password) VALUES (:email, :password)";
			$stmt = $conn->prepare($sql);

			$stmt->bindParam(':email', $_POST['email']);
			$hash = password_hash($_POST['password'], PASSWORD_BCRYPT);
			$stmt->bindParam(':password', $hash);

			if ($stmt->execute()) {
				$message = 'Successfully created new user';
			} else {
				$message = 'There was an issue creating your account. Please try again later';
			}
		}
	} elseif (!empty($_POST)) {
		$message = "Fill in all fields to register";
	}
}

function checkEmail($email) {
    if ( strpos($email, '@') !== false ) {
        $split = explode('@', $email);
        return (strpos($split['1'], '.') !== false ? true : false);
    }
    else {
        return false;
    }
}

?>

<!DOCTYPE html>
<html>
<head>
	<title>Register Below</title>
	<link rel="stylesheet" type="text/css" href="assets/css/style.css">
	<link href='http://fonts.googleapis.com/css?family=Comfortaa' rel='stylesheet' type='text/css'>
</head>
<body>

	<div class="header">
		<a href="/">Your App Name</a>
	</div>

	<?php if(!empty($message)): ?>
		<p><?= $message ?></p>
	<?php endif; ?>

	<h1>Register</h1>
	<span>or <a href="index.php">login here</a></span>

	<form action="register.php" method="POST">
		
		<input type="text" placeholder="Enter your email" name="email">
		<input type="password" placeholder="and password" name="password">
		<input type="password" placeholder="confirm password" name="confirm_password">
		<input name="submit" type="submit" value="Registreren">

	</form>

</body>
</html>
