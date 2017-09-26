<!DOCTYPE html>

<html>

<head>

	<title>Test</title>

	 <link rel="stylesheet" type="text/css" href="Style.css">

	 <link href="https://fonts.googleapis.com/css?family=Abril+Fatface" rel="stylesheet">

	 <link href="https://fonts.googleapis.com/css?family=Josefin+Slab" rel="stylesheet">

</head>

<body>

<main>

	<h1 class="rubrik">Rubrik</h1>"


<?php



	include_once("data.php");


	foreach ($data as $key => $value) {

		echo "<article>";
		echo "<h2 class=\"titel\">" . $value["title"] . "</h2>";
		echo "<h2 class=\"författare\">" . $value["author"] . "</h2>";
		echo "<div class=\"border\">";
		echo "<img class=\"img\" src=" . $value["img"] . ">";
		echo "<p class=\"txt\">" . $value["message"] . "</p>";
		echo "</div></article>";

	}

?>

</main>

</body>

</html>
