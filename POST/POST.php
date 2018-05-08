<?php
	try{
		$dbh = new PDO("mysql:host=localhost;dbname=post;charset=utf8", "root", "", array(
			PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,));
	} catch(PDOException $pe){
		echo $pe->getMessage();
	}
?>

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

		<table class="table">
			<thead>
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
			</thead>
			<tbody>
			<?php
				$sql = "SELECT * FROM posts";
				$stmt = $dbh->prepare($sql);
				$stmt->execute();
				$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

				foreach ($rows as $key => $value){
					?>
					<form action="POST.php" method="post">
						<tr>
							<td><?php echo $value['id'] ?></td>
							<td><?php echo $value['userid'] ?></td>
							<td><?php echo $value['title'] ?></td>
							<td><?php echo $value['content'] ?></td>
							<td><?php echo $value['image'] ?></td>
							<td><?php echo date("Y-m-d", strtotime($value['date'])) ?></td>
							<input type="hidden" name="id" value=<?php echo $value['id'];?>>
							<td><input type="submit" name="delete" value="Delete"></td>
							<td><input type="submit" name="edit" value="Edit"></td>
						</tr>
						</form>
				<?php
				}
				?>
			</tbody>
		</table>

<?php
	if(isset($_POST['submit'])){
		$title = filter_input(INPUT_POST, 'title', FILTER_SANITIZE_SPECIAL_CHARS);
		$content = filter_input(INPUT_POST, 'content', FILTER_SANITIZE_SPECIAL_CHARS);
		$image = filter_input(INPUT_POST, 'image', FILTER_SANITIZE_SPECIAL_CHARS);
		$stmt = $dbh->prepare("INSERT INTO posts(title, content, image) VALUES (:title, :content, :image)");
		$stmt->bindParam(':title', $title,  PDO::PARAM_STR);
	    $stmt->bindParam(':content', $content,  PDO::PARAM_STR);
	   	$stmt->bindParam(':image', $image,  PDO::PARAM_STR);
	   	$stmt->execute();

		Header("Location: ../POST/POST.php");
		exit();
	}elseif(isset($_POST['delete'])){
		//var_dump($_POST['id']);
		$id = filter_input(INPUT_POST, "id", FILTER_VALIDATE_INT);
		$sql = "DELETE FROM posts WHERE id = :id";
		$stmt = $dbh->prepare($sql);	
		$stmt->bindParam(':id', $id, PDO::PARAM_INT);
		$stmt->execute();
		echo $_POST['delete'];
		var_dump($id);
		Header("Location: ../POST/POST.php");
		exit();
	}elseif(isset($_POST['edit'])){

		$sql = "SELECT * FROM posts WHERE id= " . $_POST['postid'] . "";
		
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
	}elseif(isset($_POST['editpost'])){

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