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
?>

<body>

		<div class="header">
	 		 <h1>Smith's Library</h1>
		</div>

		<div id="main">
			<div id="container">
				<?php
					echo "<p><h2>Welcome back, " . $_SESSION['username'] . "</h2></p>";
				?>
			</div>
			<div class="flex-container">
  				<div><a href="searchforbook.php">Search for a book</a></div>
  				<div><a href="viewreservedbooks.php">View reserved Books</a></div>
 				<div><a href="logout.php">Logout</div>
			</div>

			<div class="logoutcontainer">
				<a href="logout.php">Logout</a>
			</div>
		</div>

		<footer>
			<div class="bottomdiv">
				<p>Site by: Cormac Smith &copy; 2020</p>
			</div>
		</footer>


</body>

</html>