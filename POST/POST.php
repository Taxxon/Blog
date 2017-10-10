<!DOCTYPE html>

<html>

<head>

	<title>POST</title>

</head>

<body>

	<form action="POST.php" method="post">
		<p> Titel : <input type="text" name="title" size="29"></p>
		<p> Text : <textarea name="content" rows="10" cols="30"></textarea></p>
		<p> Bild : <input type="text" name="image" size="29"></p>
		<input type="submit" name="submit" value="Submit">
	</form>

<?php
	
	if(isset($_POST['submit'])){
	$dbh = new PDO("mysql:host=localhost;dbname=post;charset=utf8", "root", "");

	$sql = "insert into posts(userid,title,content,image) values(1 , ' " . $_POST['title'] . " ', ' " . $_POST['content'] . " ', ' " . $_POST['image'] . " ' )";
	$stmt = $dbh->prepare($sql);
	$stmt->execute();
}

?>

</body>

</html>