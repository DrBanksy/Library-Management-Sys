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

		<div id = "searchmainview" class = "mainview">
			<?php
				$author = mysqli_real_escape_string($db,$_GET['author']);
				$booktitle = mysqli_real_escape_string($db,$_GET['booktitle']);
				$submit = mysqli_real_escape_string($db,$_GET['submit']);
				$bookcategory = mysqli_real_escape_string($db,$_GET['bookcategory']);

				//if user does not fill any fields or pick a category
				if($bookcategory == 'Select a category' && $_GET['booktitle'] == '' && $_GET['author'] == '') {
					header('location:searchforbook.php');
				}
				
				//if user searches by category
				if($bookcategory != 'Select a category')
				{
					//checking if user chose a cateogry and typed somehing ---> NOT ALLOWED !
					if($bookcategory != 'Select a category' && $author || $booktitle ) {
						header('Location:searchforbook.php');
					}

					$limit = 5;

					$c = mysqli_real_escape_string($db, $_GET['bookcategory']);
					$sql1 = "SELECT categoryID from category WHERE categoryDes = '$c'";
					mysqli_query($db, $sql1);
					$result1 = mysqli_query($db, "SELECT categoryID from category WHERE categoryDes = '$c'");
					$row1 = mysqli_fetch_row($result1);
						
					//now that we have the ID of the category searched by user we can query book
					$sql1 = "SELECT booktitle FROM book WHERE cateogryID = $row1[0] AND reservation = 'N' ";
					$result1 = mysqli_query($db, $sql1) or die(mysqli_error($db));


					$totalRecords = mysqli_num_rows($result1);

					$totalpages = ceil($totalRecords/$limit);

					if(!isset($_GET['page'])) {
						$page =1;
					} else {
						$page = $_GET['page'];
					}
					$pageResult  = ($page-1) * $limit;
					$sql = "SELECT * FROM book WHERE cateogryID = $row1[0] AND reservation = 'N' LIMIT " . $pageResult . ',' . $limit;
					$result = mysqli_query($db, $sql);
					echo "<span style='display:inline-block;width:100%;'>";
					echo '<table style="margin: 0px auto;border-collapse: collapse;font-size:1.2em;" cellpadding="5px" border="1">' . "\n";
					while($row = mysqli_fetch_array($result)) {
						echo "<span style='font-size: 1.2em;'>";
						echo "<tr><td>";
						echo(htmlentities($row['BookTitle']));
						echo "</td><td>";
						echo "</span>";
						echo ' <a href=reserve.php?ISBN='. $row['ISBN'] . ">" . 'Reserve' . '</a>';
						echo "</tr>";
						

					}
					echo "</table>";
					echo "</span>";

					
					if($totalRecords == 0) {
						echo "<p style = font-size:1.3em;padding:10px>" . "No books in this category :(</p>";
						echo '<a href="searchforbook.php"' . ">" . "<span style='font-size:1.3em;color:blue;display:inline-block;width:100%;padding-top:2em;'>" .'Return to search' . '</a>';
					}
					if($totalRecords >5) {
						for($page=1;$page<=$totalpages; $page++) {

						//if the user is searching by category then 
						//the author and booktitle fields are empty
						if($author=='' && $booktitle =='') {
							echo "<span style='padding:0.2em;'>";
							echo '<a href="booksview.php?' . 'author=&' . 'booktitle=&' . 'submit=' . $submit . '&' . 'bookcategory=' . $bookcategory. '&' . 'page='. $page . '">'. $page . '</a> ';
							echo "</span>";

						}
					}
					}
				
					if($totalRecords != 0) {
						echo "<a href=searchforbook.php>" . "<span style='font-size:1.3em;color:blue;display:inline-block;width:100%;padding-top:2em;'>" . "Return to search</a>" . "</span>";
					}
					
				//search by book title only 
				} else if($booktitle != '' && $author == ''  ) {
					$sql = "SELECT * FROM Book WHERE BookTitle LIKE '%$booktitle%' AND reservation='N'";
					$result = mysqli_query($db, $sql) or die(mysqli_error($db));

					$limit = 5;

					$totalRecords = mysqli_num_rows($result);

					if($totalRecords == 0) {
						echo "<p style = font-size:1.3em;padding:10px>No book of that name is available :(</p>";
					}

					$totalpages = ceil($totalRecords/$limit);

					if(!isset($_GET['page'])) {
						$page =1;
					} else {
						$page = $_GET['page'];
					}
					$pageResult  = ($page-1) * $limit;
					$sql = "SELECT * FROM book WHERE BookTitle LIKE '%$booktitle%' AND reservation='N' LIMIT " . $pageResult . ',' . $limit;
					$result = mysqli_query($db, $sql);

					echo "<span style='display:inline-block;width:100%;'>";
					echo '<table style="margin: 0px auto;border-collapse: collapse;font-size:1.2em;" cellpadding="5px" border="1">' . "\n";
					while($row = mysqli_fetch_array($result)) {
						echo "<span style='font-size: 1.2em;'>";
						echo "<tr><td>";
						echo(htmlentities($row['BookTitle']));
						echo "</td><td>";
						echo "</span>";
						echo ' <a href=reserve.php?ISBN='. $row['ISBN'] . ">" . 'Reserve' . '</a>';
						echo "</tr>";
						

					}
					echo "</table>";
					echo "</span>";

					if($totalRecords >5) {
						//if user searches for book title only 
						for($page=1;$page<=$totalpages; $page++) {
							//if book title field is not empty
							if($booktitle !='') {
								echo '<a href="booksview.php?' . 'author=&' . 'booktitle=' . $booktitle . '&' . 'submit=' . $submit . '&' . 'bookcategory=' . 'Select a category' . '&' .  'page='. $page . '">'. $page . '</a> ';

							}
							

						}
					}

					echo "<a href=searchforbook.php>" . "<span style='font-size:1.3em;color:blue;display:inline-block;width:100%;padding-top:2em;'>" . "Return to search</a>" . "</span>";

				//search by author only
				} else if($author != '' && $booktitle == '') {
					$sql = "SELECT * FROM Book WHERE author LIKE '%$author%' AND reservation='N'";
					$result = mysqli_query($db, $sql) or die(mysqli_error($db));

					$limit = 5;

					$totalRecords = mysqli_num_rows($result);

					if($totalRecords == 0) {
						echo "<span style=font-size:1.2em;";
						echo "<p style = padding:10px>No books available for this author</p>";
						echo "</span>";
						echo "<a href=searchforbook.php>" . "<span style='font-size:1.3em;color:blue;display:inline-block;width:100%;padding-top:2em;'>" .'Return to search' . '</a>';
					}

					$totalpages = ceil($totalRecords/$limit);

					if(!isset($_GET['page'])) {
						$page =1;
					} else {
						$page = $_GET['page'];
					}
					$pageResult  = ($page-1) * $limit;
					$sql = "SELECT * FROM book WHERE author LIKE '%$author%' AND reservation='N' LIMIT " . $pageResult . ',' . $limit;
					$result = mysqli_query($db, $sql);


					echo "<span style='display:inline-block;width:100%;'>";
					echo '<table style="margin: 0px auto;border-collapse: collapse;font-size:1.2em;" cellpadding="5px" border="1">' . "\n";
					while($row = mysqli_fetch_array($result)) {
						echo "<span style='font-size: 1.2em;'>";
						echo "<tr><td>";
						echo(htmlentities($row['BookTitle']));
						echo "</td><td>";
						echo "</span>";
						echo ' <a href=reserve.php?ISBN='. $row['ISBN'] . ">" . 'Reserve' . '</a>';
						echo "</tr>";
						

					}
					echo "</table>";
					echo "</span>";
	

					if($totalRecords >5) {
					//if user searches for author only 
						for($page=1;$page<=$totalpages; $page++) {
							//if authorfield is not empty
							if($author !='') {
								echo '<a href="booksview.php?' . 'author='. $author. '&' . 'booktitle=' . '&' . 'submit=' . $submit . '&' . 'bookcategory=Select a category' . '&' . 'page='. $page . '">'. $page . '</a> ';
								

							}
						}
					}
					

					if($totalRecords != 0) {
						echo "<a href=searchforbook.php>" . "<span style='font-size:1.3em;color:blue;display:inline-block;width:100%;padding-top:2em;'>" . "Return to search</a>" . "</span>";
					}

					

				//search author and booktitle
				} else if($author !='' && $booktitle !='') {
					$sql = "SELECT * FROM Book WHERE author LIKE '%$author%' AND booktitle LIKE '%$booktitle%' AND reservation='N'";
					
					$result = mysqli_query($db, $sql) or die(mysqli_error($db));

					$limit = 5;

					$totalRecords = mysqli_num_rows($result);

					if($totalRecords == 0) {
						echo "<p style = font-size:1.3em;padding:10px>No results :(</p>";
						echo "<a href=searchforbook.php>" . "<span style='font-size:1.3em;color:blue;display:inline-block;width:100%;padding-top:2em;'>" .'Return to search' . '</a>';
					}
					
					$totalpages = ceil($totalRecords/$limit);

					if(!isset($_GET['page'])) {
						$page =1;
					} else {
						$page = $_GET['page'];
					}
					$pageResult  = ($page-1) * $limit;
					$sql = "SELECT * FROM book WHERE author LIKE '%$author%' AND booktitle LIKE '%$booktitle%' AND reservation='N' LIMIT " . $pageResult . ',' . $limit;
					$result = mysqli_query($db, $sql);


					echo "<span style='display:inline-block;width:100%;'>";
					echo '<table style="margin: 0px auto;border-collapse: collapse;font-size:1.2em;" cellpadding="5px" border="1">' . "\n";
					while($row = mysqli_fetch_array($result)) {
						echo "<span style='font-size: 1.2em;'>";
						echo "<tr><td>";
						echo(htmlentities($row['BookTitle']));
						echo "</td><td>";
						echo "</span>";
						echo ' <a href=reserve.php?ISBN='. $row['ISBN'] . ">" . 'Reserve' . '</a>';
						echo "</tr>";
						

					}
					echo "</table>";
					echo "</span>";
	

					if($totalRecords >5) {
					//if user searches for author only 
						for($page=1;$page<=$totalpages; $page++) {
							//if authorfield is not empty
							if($author !='' && $booktitle !='') {
								
								echo '<a href="booksview.php?' . 'author='. $author. '&' . 'booktitle=' . $booktitle . '&' . 'submit=' . $submit . '&' . 'bookcategory=Select a category' . '&' . 'page='. $page . '">'. $page . '</a> ';

							}
						

						}
					}
					
					if($totalRecords != 0) {
						echo "<a href=searchforbook.php>" . "<span style='font-size:1.3em;color:blue;display:inline-block;width:100%;padding-top:2em;'>" . "Return to search</a>" . "</span>";
					}
					
				}
			?>

		</div>

		<div class="logoutcontainer" id="logout_booksview">
			<a href="logout.php">Logout</a>
		</div>


		<footer>
			<div class="bottomdiv">
				<p>Site by: Cormac Smith &copy; 2020</p>
			</div>
		</footer>


</body>

</html>