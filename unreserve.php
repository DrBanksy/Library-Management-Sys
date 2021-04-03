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
	 		 <a class="headerhome" href="memberview.php"><h1>Smith's Library</h1></a>
		</div>

		
		<div id="unreserve">
			<h2>Are you sure you want to unreserve </h2>
			<form method="post">
			<?php
				$isbn  = $_GET['isbn'];
				$sql = "SELECT booktitle FROM book where ISBN = '$isbn'";
				$result = mysqli_query($db, $sql);
				$row = mysqli_fetch_row($result);
				echo "<span style=font-size:1.2em;>";
				echo $row[0];
				echo "</span>";
				echo "<br>"; 
				echo "<input style=margin-top:1em type='submit' name='submit' value='Unreserve' id='unreservebutton'>";
				echo "<a style=padding:10px href='viewreservedbooks.php'>Cancel</a>"
				
			?>
			</form>
			<?php
				if(isset($_POST['submit'])) {
					$isbn  = $_GET['isbn'];
					//updating book table, setting reservation to N
					$sql = "UPDATE book set reservation='N' where ISBN = '$isbn'";
					mysqli_query($db, $sql);

					//updating reservedbook table, removing the record
					$sql = "DELETE FROM reservedbook where ISBN = '$isbn'";
					mysqli_query($db, $sql);

					//redirect user to their list of reserved books
					header('location:viewreservedbooks.php');
				}
			?>
		</div>
		

		<footer>
			<div class="bottomdiv">
				<p>Site by: Cormac Smith &copy; 2020</p>
			</div>
		</footer>


</body>

</html>