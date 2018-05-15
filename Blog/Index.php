<?php
	try{
		$dbh = new PDO("mysql:host=localhost;dbname=post;charset=utf8", "root", "", array(
			PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,));
	} catch(PDOException $pe){
		echo $pe->getMessage();
	}
?>
<!DOCTYPE html>
<html lang="se">
<head>
	<title>Blog</title>
	 <link rel="stylesheet" type="text/css" href="style.css">
	 <link href="https://fonts.googleapis.com/css?family=Abril+Fatface" rel="stylesheet">
	 <link href="https://fonts.googleapis.com/css?family=Josefin+Slab" rel="stylesheet">
</head>
<body>
	<main>
		<h1 class="rubrik">GamePost</h1>
		<?php
			$sql = "SELECT * FROM posts";
			$stmt = $dbh->prepare($sql);
			$stmt->execute();
			$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

			foreach ($rows as $key => $value) { ?>
				<article>;
					<img alt="ERROR" class="img" src=<?php echo $value["image"]; ?>>;
					<h2 class="titel"><?php echo $value["title"] ?></h2>;
					<div class="border">;
						<p class="txt"><?php echo $value["content"] ?></p>;
					</div>";
					<p class="date"><?php echo date("Y-m-d", strtotime($value["date"])) ?></p>;
					<div class="border2"></div>";
				</article>";
			<?php
			}
			?>
	</main>
</body>
</html>
