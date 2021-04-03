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
	if($_SESSION['username'] == false) {
		header('Location:login.php');
	}
	if(isset($_GET['ISBN'])) {
		$isbn = $_GET['ISBN'];			
	} else {
		echo "Sorry, an error has occured";
		header('Location: login.php');
	}
?>

<?php
	if(isset($_POST['reserve'])) {
		$checkout_date = date("d-M-Y");
		$username = $_SESSION['username'];
		$sql = "UPDATE book SET reservation = 'Y' WHERE ISBN = '$isbn'";
		mysqli_query($db, $sql);
		$sql = "INSERT INTO reservedbook (ISBN, Username, reservedDate) VALUES ('$isbn', '$username', '$checkout_date')";
		mysqli_query($db, $sql);
	}
	
?>

<body>

		<div class="header">
	 		 <a class="headerhome" href="memberview.php"><h1>Smith's Library</h1></a>
		</div>

		<div class="mainview">
				<div id="reservecontainer">
					<p style = "font-size:1.2em;padding:5px;">You are about to reserve the following book</p>
					<form method="post">
					<?php
						$sql = "SELECT * FROM book WHERE ISBN = '$isbn'";
						$result = mysqli_query($db, $sql);
						echo"<p><b>";

						while($row = mysqli_fetch_array($result)) {
							echo "<span style=font-size:1.2em;>";
							echo $row['BookTitle'];
							echo "</span>";
						}
						echo "</b></p>";

					?>

					<input id= "reserve" type="Submit" value="Reserve" name="reserve">
					<span style="display: inline-block; width: 100%; padding-bottom: 1em;">
						<a href="searchforbook.php">Cancel</a>
					</span>
					</form>

					<?php
						if(isset($_POST['reserve'])) {
							echo "<p>Reserved</p>";
						}
					?>
				</div>
		</div>

		<footer>
			<div class="bottomdiv">
				<p>Site by: Cormac Smith &copy; 2020</p>
			</div>
		</footer>


</body>

</html>