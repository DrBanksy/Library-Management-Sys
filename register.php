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
	require_once "db.php";
	session_start();

	if(
		isset($_POST['username']) && isset($_POST['firstname']) && isset($_POST['password']) && isset($_POST['password2'])
		&& isset($_POST['surname']) && isset($_POST['addressline1']) && isset($_POST['addressline2'])
		&& isset($_POST['city']) && isset($_POST['telephone']) && isset($_POST['mobile'])) 
	{
		$uname = mysqli_real_escape_string($db,$_POST['username']);
		$p = mysqli_real_escape_string($db,$_POST['password']);
		$p2 = mysqli_real_escape_string($db,$_POST['password2']);
		$f = mysqli_real_escape_string($db,$_POST['firstname']);
		$s = mysqli_real_escape_string($db,$_POST['surname']);
		$a1 = mysqli_real_escape_string($db,$_POST['addressline1']);
		$a2 = mysqli_real_escape_string($db,$_POST['addressline2']);
		$c = mysqli_real_escape_string($db,$_POST['city']);
		$t = mysqli_real_escape_string($db,$_POST['telephone']);
		$m = mysqli_real_escape_string($db,$_POST['mobile']);

		//remove all illegal characters from number
		$filtered_phone_num = filter_var($m, FILTER_SANITIZE_NUMBER_INT);

		//remove +, - and .  from mobile number
		$symbol_check_mobile = str_replace(str_split("-+."),"", $filtered_phone_num);
		$mobile = is_numeric($symbol_check_mobile);

		//filtering telephone number
		$filtered_telephone_num = filter_var($t, FILTER_SANITIZE_NUMBER_INT);
		$symbol_check_telephone = str_replace(str_split("-+."),"", $filtered_telephone_num);

		if(strlen($symbol_check_telephone) != 9) {
			$_SESSION['error_number_telephone'] = "Must enter 9 numbers";
			header('Location: register.php');
			return;
		}

		//checking number length is 10 and making sure its numeric
		if($mobile==0 || strlen($symbol_check_mobile)!=10) {
			$_SESSION['error_number'] = "Must enter 10 numbers";
			header('Location: register.php');
			return;
		}

		//pasword confirmation
		if($p != $p2) {
			$_SESSION['error_pass'] = "Passwords do not match";
			header('Location: register.php');
			return;
		}

		$sql = "SELECT * FROM users where username = '$uname'";
		$result = mysqli_query($db, $sql);
		$row = mysqli_fetch_array($result);

		//checking if the name is unique or not
		if($row!=0) {
			$_SESSION['error_not_unique'] = "Username is not unique";
			header('Location: register.php');
			return;
		}

		//if all validation is ok then execute following query
		$sql2 = "INSERT INTO users (username, password, firstname, surname, addressline1, addressline2, city, telephone, mobile) 
				 			VALUES ('$uname', '$p', '$f', '$s', '$a1', '$a2', '$c', '$symbol_check_telephone', '$symbol_check_mobile')";
		//echo "<pre>\n$sql2\n</pre>\n";
		mysqli_query($db,$sql2);	

		$_SESSION['registered'] = "Account created, please log in to continue";

	} 
?>



<body>

		<div class="header">
	 		 <a class="headerhome" href="memberview.php"><h1>Smith's Library</h1></a>
		</div>

		<h3>Enter your details below:</h3>
		<?php
			if(isset($_SESSION["registered"])) {
				echo "<p style='margin-left:1em;'>" . $_SESSION["registered"] . ": " . "<a href='login.php'>Login</a>" ."</p>";
				unset($_SESSION["registered"]);
			}
		?>

		<div id="register">
		  	<form method="post">
		    	<label for="username">Username</label><br>
		    	<input type="text" id="username" name="username" placeholder="Enter username" required>

		    	<?php
					if(isset($_SESSION["error_not_unique"])) {
						echo "<span style='color:red;'";
						echo "<p>" . $_SESSION["error_not_unique"] . "</p>";
						echo "</span>";
						unset($_SESSION["error_not_unique"]);
					}
				?>

		    	<label for="password">Password</label><br>
		    	<input type="password" class="password" name="password" placeholder="Enter password" required maxlength="6" minlength="6">

		    	<label for="password">Confirm Password</label><br>
		    	<input type="password" class="password" name="password2" placeholder="Enter password" required maxlength="6" minlength="6">

				<?php
					if(isset($_SESSION["error_pass"])) {
						echo "<span style='color:red;'";
						echo "<p>" . $_SESSION["error_pass"] . "</p>";
						echo "</span>";
						unset($_SESSION["error_pass"]);
					}
				?>

		    	<label for="firstname">First name</label><br>
		    	<input type="text" id="firstname" name="firstname" placeholder="Enter first name" required>

		    	<label for="surname">surname</label><br>
		    	<input type="text" id="surname" name="surname" placeholder="Enter surname" required>

		    	<label for="addressline1">Address Line 1</label><br>
		    	<input type="text" id="addressline1" name="addressline1" placeholder="Enter address line 1" required>

		    	<label for="addressline2">Address Line 2</label><br>
		    	<input type="text" id="addressline2" name="addressline2" placeholder="Enter address line 2" required>

		    	<label for="city">City</label><br>
		    	<input type="text" id="city" name="city" placeholder="Enter city" required>

		    	<label for="telephone">Enter telephone</label><br>
		    	<input type="text" id="telephone" name="telephone" placeholder="e.g. 012836547" required>
		    	<?php
					if(isset($_SESSION["error_number_telephone"])) {
						echo "<span style='color:red;'";
						echo "<p" . ' style = margin-block-start="0px";>'  . $_SESSION["error_number_telephone"] . "</p>";
						echo "</span>";
						unset($_SESSION["error_number_telephone"]);
					}
				?>

		    	<label for="mobile">Enter mobile</label><br>
		    	<input type="text" id="mobile" name="mobile" placeholder="e.g. 0861359798" required>
		    	<?php
					if(isset($_SESSION["error_number"])) {
						echo "<span style='color:red;'";
						echo "<p" . ' style = margin-block-start="0px";>'  . $_SESSION["error_number"] . "</p>";
						echo "</span>";
						unset($_SESSION["error_number"]);
					}
				?>
				



		   		
		 	<div id="submitbutton">
		   		<input type="submit" value="Register">
		   		
		   	</div>

		  	</form>

			<p style="text-align:center;">Site by: Cormac Smith &copy; 2020</p>
		</div>



</body>

</html>