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
			<textarea name="content" class="content" placeholder="Content" required rows="20"></textarea>

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

		echo ";<div class=\"formdiv\">";
		echo "<form action=\"POST.php\" method=\"post\">";
		echo "<label for=\"title\">Titel</label>";
		echo "<input type=\"text\" id=\"title\" name=\"title\" value=\"" . $value["title"] . "\" size=\"29\" placeholder=\"Title\" required>";
			
		echo "<label for=\"content\">Text</label>";
		echo "<textarea name=\"content\" class=\"content\" value=\"" . $value["content"] . "\" placeholder=\"Content\" rows=\"20\" required>" . $value["content"] . "</textarea>";

		echo "<lable for=\"image\">Bild</lable>";
		echo "<input type=\"text\" id=\"image\" name=\"image\" value=\"" . $value["image"] . "\" size=\"29\" placeholder=\"Image\" required>";

		echo "<lable for=\"image\">Bild</lable>";
		echo "<input type=\"text\" id=\"id\" name=\"id\" value=\"" . $value["id"] . "\" size=\"29\" placeholder=\"Id\" required>";

		echo "<input type=\"submit\" name=\"editpost\" value=\"Editpost\">";
		echo "</form>";
 		echo "</div>";

 		exit();
	}

	if(isset($_POST['editpost'])){

		try{
			$sql = "UPDATE posts SET title ='" . $_POST['title'] . "', content ='" . $_POST['content'] . "', image ='" . $_POST['image'] . "' WHERE id =" . $_POST['id'] . "";
			echo $sql;
			$stmt = $dbh->prepare($sql);
			$stmt->execute();
		} catch(PDOException $e) {
			$e->getMessage();
		}
		//Header("Location: ../POST/POST.php");
		//exit();
	}

?>

</body>

</html>