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

		
		<div id="mainreserved">
			<h1>Reserved Books</h1>
			<?php	
				$username = $_SESSION['username'];
				$sql = "SELECT ISBN from reservedBook where Username = '$username'";
				$result = mysqli_query($db, $sql);
				$totalrecords = mysqli_num_rows($result);
				if($totalrecords == 0) {
					echo "<p style=font-size:1.3em;margin-top:3em>You have no reserved books.</p>";
					
				}
				
				echo '<table style="margin: 0px auto;border-collapse: collapse;font-size:1.2em;" cellpadding="5px" border="1">' . "\n";
				while($row=mysqli_fetch_row($result)) {
					$sql = "SELECT booktitle,ISBN FROM reservedBook join book using(ISBN) WHERE ISBN = '$row[0]'";
					$result1 = mysqli_query($db, $sql);
					$row1 = mysqli_fetch_row($result1);

					echo "<span style='font-size: 1.2em; padding:0.2em;'>";
					echo "<tr><td>";
					echo $row1[0];
					echo "</td><td>";
					echo "</span>";
					
					echo ' <a href=unreserve.php?isbn='. $row1[1] . ">" . 'Unreserve' . '</a>';
					echo "</tr>";
				}
				echo "</table>";

				echo "<a href='memberview.php'>"  . "<span style='font-size:1.3em;color:blue;display:inline-block;width:100%;padding-top:2em;'>" ."Return</a>" . "</span>";

			?>
		</div>
		

		<footer>
			<div class="bottomdiv">
				<p>Site by: Cormac Smith &copy; 2020</p>
			</div>
		</footer>


</body>

</html>