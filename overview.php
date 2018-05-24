<?php

session_start();
require 'database.php';
//bklasd
$name = "default";

		if($_SESSION['difficulty'] == 'low'){
			$result = mysqli_query($connection,"SELECT id,message FROM messages");

		}
		else {
			if(isset($_SESSION['user_id'])){
			
			$result = mysqli_query($connection,"SELECT id,message FROM messages");
			$name = mysqli_query($connection,"SELECT email FROM users where id = " . $_SESSION['user_id']);


			}

			else {
				
				header("Location: /index.php");

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

<br/>
	<b>Welcome <?php echo $name; ?>, You are succesfully logged in!</b>
		</br><br/>
					<a href='logout.php'>Logout?</a>
</br>
		
		<div class="overview">

			<table border='1'>
			<tr>
			<th>Secret information</th>
			</tr>

			<?php while($row = mysqli_fetch_array($result))
			{
			echo "<tr>";
			echo "<td>" . $row['message'] . "</td>";
			echo "</tr>";
			}
			echo "</table>"?>
		</div>
		
	</body>
</html>


