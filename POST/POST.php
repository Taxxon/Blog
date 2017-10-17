<!DOCTYPE html>

<html>

<head>

	<title>POST</title>

	 <link rel="stylesheet" type="text/css" href="style.css">

</head>

<body>

	<form action="POST.php" method="post">
		<p> Titel : <input type="text" name="title" size="29"></p>
		<p> Text : <textarea name="content" rows="10" cols="30"></textarea></p>
		<p> Bild : <input type="text" name="image" size="29"></p>
		<input type="submit" name="submit" value="Submit">
	</form>

	<form action="POST.php" method="delete">
		<table>

			<tr>
				<th>Id</th>
				<th>Userid</th>
				<th>Title</th>
				<th>Content</th>
				<th>Image</th>
				<th> </th>
			</tr>
			<?php
				$dbh = new PDO("mysql:host=localhost;dbname=post;charset=utf8" , 
					"root",
					"");
				$sql = "select * from posts";
				$stmt = $dbh->prepare($sql);
				$stmt->execute();
				$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
				
				foreach ($rows as $key => $value) {
					echo "<tr>";
					echo "<td>" . $value["id"] . "</td>";
					echo "<td>" . $value["userid"] . "</td>";
					echo "<td>" . $value["title"] . "</td>";
					echo "<td>" . $value["content"] . "</td>";
					echo "<td>" . $value["image"] . "</td>";
					echo "<td><input type=\"submit\" name=\"delete\" value=\"{row['id']}\"></td>";
					echo "</tr>";
				}

			?>
		</table>
	</form>

<?php

	$dbh = new PDO("mysql:host=localhost;dbname=post;charset=utf8", "root", "");
	
	if(isset($_POST['submit'])){

		$sql = "insert into posts(userid,title,content,image) values(1 , ' " . $_POST['title'] . " ', ' " . $_POST['content'] . " ', ' " . $_POST['image'] . " ' )";
		$stmt = $dbh->prepare($sql);
		$stmt->execute();
}
	
	if(isset($_POST['delete'])){

		$sql = "delete from post where id=" . $_POST['id'] . "";
		$stmt = $dbh->prepare($sql);
		$stmt->execute();
}

?>

</body>

</html>