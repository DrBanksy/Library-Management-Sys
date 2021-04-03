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

		<div id="mainsearch">
			<form method="get" action="booksview.php">
			  <input type="text" name="author" id="author" placeholder="Author" ><br><br>       
		      <input type="text" name="booktitle" id="booktitle" placeholder="Book Title" >    
		      <br><br>    
		      <input type="submit" name="submit" id="searchbutton" value="Search">  
		     
		      <div id="dropdown">
		      	    <h2>Category</h2>
				    <?php
			  				if($db) {
								$sql = "SELECT categoryDes FROM category";
								mysqli_query($db, $sql);
								$result = mysqli_query($db, "SELECT categoryDes FROM category");

								echo "<select name='bookcategory'style= width:50%>";
								echo "<option selected='selected'>Select a category</option>";

								//getting all categories from database and putting into dropdown
								while($row = mysqli_fetch_row($result)) {
									//echo "<p>" . $row[0] . "</p>";
									echo "<option value='$row[0]'" . ">" . $row[0] . "</option>";
								}
								echo "</select>";
								echo "<br>";
								echo "<a href='memberview.php'>Return</a>";

							}
					?>

				</div>
			</form>

			<div id="logoutcontainer_search">
				<a  href="logout.php">Logout</a>
			</div>
		</div>

		

		<footer>
			<div class="bottomdiv">
				<p>Site by: Cormac Smith &copy; 2020</p>
			</div>
		</footer>


</body>

</html>