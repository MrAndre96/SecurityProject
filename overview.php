<?php

session_start();
require 'database.php';

		if($_SESSION['difficulty'] == 'low'){
			
			
		}
		else {
			if(isset($_SESSION['user_id'])){
				
			}

			else {
				
				header("Location: /index.php");

			}
		}
				
		$result = mysqli_query($connection,"SELECT id,message FROM messages");
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
	<b>Welcome <?php echo $_SESSION['user_name']; ?>, You are succesfully logged in!</b>
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


