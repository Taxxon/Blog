<!DOCTYPE html>

<html>

<head>

	<title>Test</title>

	 <link rel="stylesheet" type="text/css" href="style.css">

	 <link href="https://fonts.googleapis.com/css?family=Abril+Fatface" rel="stylesheet">

	 <link href="https://fonts.googleapis.com/css?family=Josefin+Slab" rel="stylesheet">

	 <script type="text/javascript" src="script.js"></script>

</head>

<body>

<main>

	<h1 class="rubrik">GamePost</h1>

	<button onclick="">Login</button>

<?php

	$dbh = new PDO("mysql:host=localhost;dbname=post;charset=utf8" , 
				"root",
				"");
	
	$sql = "SELECT * FROM posts";
	$stmt = $dbh->prepare($sql);
	$stmt->execute();
	$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);


	foreach ($rows as $key => $value) {

		echo "<article>";
		echo "<img class=\"img\" src=" . $value["image"] . ">";
		echo "<h2 class=\"titel\">" . $value["title"] . "</h2>";
		echo "<div class=\"border\">";
		echo "<p class=\"txt\">" . $value["content"] . "</p>";
		echo "</div>";
		echo "<p class=\"date\">" . date("Y-m-d", strtotime($value["date"])) . "</p>";
		echo "<div class=\"border2\"></div>";
		echo "</article>";

	}

?>


</main>

</body>

</html>
