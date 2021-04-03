<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>Smith's Library</title>
<link rel="shortcut icon" href="img/favicon.ico">
<link rel="stylesheet" type="text/css" href="style.css">   
<link rel="preconnect" href="https://fonts.gstatic.com">
<link href="https://fonts.googleapis.com/css2?family=Barlow&display=swap" rel="stylesheet">
</head>


<?php
	session_start();
	unset($_SESSION["username"]);
	require_once "db.php";
	

	//checking if username and password were entered
	if(isset($_POST['username']) && isset($_POST['password'])) {
		$u =  mysqli_real_escape_string($db, $_POST['username']);
		$p =  mysqli_real_escape_string($db, $_POST['password']);

		//generating sql query
		$sql = "SELECT * FROM Users WHERE Username = '$u' AND Password = '$p'";
		$result = mysqli_query($db, $sql);
		$row = mysqli_fetch_array($result);

		//if no rows were found then zero is returned
		if(!$row) {
			$_SESSION['incorrectlogin'] = "Incorrect Details Entered";
			echo $_SESSION['incorrectlogin'];
			header('Location: login.php');
			return;

		}
		//if rows were found
		else {
			$_SESSION["username"] = $_POST["username"];
			header( 'Location: memberview.php' ) ;
			return;

		}

						
	}

?>

<body>
	
		<div class="header">
		 	<h1>Smith's Library</h1>
		</div>

			<h2>Log in</h2>
		<div class="login">    
		    <form id="login" method="post">
		       
		        <input type="text" name="username" id="username" placeholder="Username" required><br><br>        
		  
		        <input type="Password" name="password" id="password_login" placeholder="Password" required>    
		        <br><br>    
		        <input type="submit" name="submit" id="loginbutton" value="Login">  
		   
				<?php
					if(isset($_SESSION["incorrectlogin"])) {
						echo "<p style='margin-left:6.6em;'>" . $_SESSION["incorrectlogin"] . "</p>";
						unset($_SESSION["incorrectlogin"]);
					}
				?>
		    </form>   
		</div>
		<div id="sub-container">
			<a href="register.php"><button id="registerbutton">Register</button></a>
		</div>

		

		<footer>
			<div class="bottomdiv">
				<p>Site by: Cormac Smith &copy; 2020</p>
			</div>
		</footer>

		
	
</body>

</html>