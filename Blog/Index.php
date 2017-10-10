<!DOCTYPE html>

<html>

<head>

	<title>Test</title>

	 <link rel="stylesheet" type="text/css" href="style.css">

	 <link href="https://fonts.googleapis.com/css?family=Abril+Fatface" rel="stylesheet">

	 <link href="https://fonts.googleapis.com/css?family=Josefin+Slab" rel="stylesheet">

</head>

<body>

<main>

	<h1 class="rubrik">GamePost</h1>"


<?php

	$dbh = new PDO("mysql:host=localhost;dbname=post;charset=utf8" , 
				"root",
				"");
	
	$sql = "select * from posts";
	$stmt = $dbh->prepare($sql);
	$stmt->execute();
	$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);



	include_once("data.php");


	foreach ($rows as $key => $value) {

		echo "<article>";
		echo "<img class=\"img\" src=" . $value["image"] . ">";
		echo "<h2 class=\"titel\">" . $value["title"] . "</h2>";
		echo "<div class=\"border\">";
		echo "<p class=\"txt\">" . $value["content"] . "</p>";
		echo "</div></article>";

	}

?>

</main>

</body>

</html>
