<!DOCTYPE html>

<html>

<head>

	<title>POST</title>

	 <link rel="stylesheet" type="text/css" href="style.css">

	 <link href="https://fonts.googleapis.com/css?family=Lato" rel="stylesheet">

</head>

<body>

	<div class="formdiv">
		<form action="POST.php" method="post">
			<label for="title">Titel</label> 
			<input type="text" id="title" name="title" size="29" placeholder="Title" required>
			
			<label for="content">Text</label>
			<input type="text" name="content" class="content" placeholder="Content" required>

			<lable for="image">Bild</lable>
			<input type="text" id="image" name="image" size="29" placeholder="Image" required>
			<input type="submit" name="submit" value="Submit">
		</form>
	</div>

	<form action="POST.php" method="post">
		<table class="table">
			<tr>
				<th>Id</th>
				<th>Userid</th>
				<th>Title</th>
				<th>Content</th>
				<th>Image</th>
				<th>Date</th>
				<th> </th>
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
					echo "<td>" . date("Y-m-d", strtotime($value["date"])) . "</td>";
					echo "<input type=\"hidden\" name=\"postid1\" value=" . $value["id"] .">";
					echo "<td><input type=\"submit\" name=\"delete\" value=\"Delete\"></td>";
					echo "<input type=\"hidden\" name=\"postid2\" value=" . $value["id"] .">";
					echo "<td><input type=\"submit\" name=\"edit\" value=\"Edit\"</td>";
					echo "</tr>";
				}

			?>
		</table>
	</form>

<?php

	$dbh = new PDO("mysql:host=localhost;dbname=post;charset=utf8", "root", "");
	
	if(isset($_POST['submit'])){

		$Title = filter_input(INPUT_POST, 'title', FILTER_SANITIZE_SPECIAL_CHARS);
		$Content = filter_input(INPUT_POST, 'content', FILTER_SANITIZE_SPECIAL_CHARS);
		$Image = filter_input(INPUT_POST, 'image', FILTER_SANITIZE_SPECIAL_CHARS);


		try{
			$sql = "INSERT INTO posts(userid,title,content,image) VALUES(1 , ' " . $_POST['title'] . " ', ' " . $_POST['content'] . " ', ' " . $_POST['image'] . " ' )";
			$stmt = $dbh->prepare($sql);
			$stmt->execute();
		} catch(PDDExeption $e){
			$e->getMessage();
		}

		Header("Location: ../POST/POST.php");
		exit();
}
	
	if(isset($_POST['delete'])){
		
		try {
			$sql = "DELETE FROM posts WHERE id= " . $_POST['postid1'] . "";
			$dbh->exec($sql);
		} catch(PDOException $e) {
			$e->getMessage();		
		}

		Header("Location: ../POST/POST.php");
		exit();
}

	if(isset($_POST['edit'])){

		$sql = "SELECT * FROM posts WHERE id= " . $_POST['postid2'] . "";
		
		echo $sql;

		$stmt = $dbh->prepare($sql);
		$stmt->execute();
		$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

	

		<div class="formdiv">
		<form action="POST.php" method="post">
		<label for="title">Titel</label> 
		<input type="text" id="title" name="title" size="29" placeholder="Title" required>
			
		<label for="content">Text</label>
		<input type="text" name="content" class="content" placeholder="Content" required>

		<lable for="image">Bild</lable>
				<input type="text" id="image" name="image" size="29" placeholder="Image" required>
				<input type="submit" name="submit" value="Submit">
			</form>
 		</div>


		try{
			$sql = "UPDATE posts SET title='UPDATE', content='UPDATE', image='UPDATE' WHERE  id= " . $_POST['postid2'] . "";
			$dbh->exec($sql);
		} catch(PDOException $e) {
			$e->getMessage();
		}
		Header("Location: ../POST/POST.php");
		exit();
	}

?>

</body>

</html>