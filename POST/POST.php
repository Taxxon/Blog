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
			<label for="image">Bild</label>
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
						<tr>
							<td><?php echo $value['id'] ?></td>
							<td><?php echo $value['userid'] ?></td>
							<td><?php echo $value['title'] ?></td>
							<td><?php echo $value['content'] ?></td>
							<td><?php echo $value['image'] ?></td>
							<td><?php echo date("Y-m-d", strtotime($value['date'])) ?></td>
							<td><form action="POST.php" method="post">
								<input type="hidden" name="id" value=<?php echo $value['id'];?>>
							    <input type="submit" name="delete" value="Delete"></td>
							<td><input type="submit" name="edit" value="Edit"></td>
								</form>
						</tr>
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
		$id = filter_input(INPUT_POST, "id", FILTER_VALIDATE_INT);
		$sql = "DELETE FROM posts WHERE id = :id";
		$stmt = $dbh->prepare($sql);	
		$stmt->bindParam(':id', $id, PDO::PARAM_INT);
		$stmt->execute();
		Header("Location: ../POST/POST.php");
		exit();
	}elseif(isset($_POST['edit'])){
		$id = filter_input(INPUT_POST, "id", FILTER_VALIDATE_INT);
		$sql = "SELECT * FROM posts WHERE id = :id";
		$stmt = $dbh->prepare($sql);
		$stmt->bindParam(':id', $id, PDO::PARAM_INT);
		$stmt->execute();
		$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
		foreach ($rows as $key => $value) {
		?>
		<div class="formdiv">
			<form action="POST.php" method="post">
				<label for="title">Titel</label>
				<input type="text" id="title" name="title" value=<?php echo $value['title'] ?> size="29" placeholder="Title" required>	
				<label for="content">Text</label>
				<textarea name="content" class="content" value=<?php echo $value['content'] ?> placeholder="Content" rows="20" required><?php echo $value['content'] ?></textarea>	
				<lable for="image">Bild</lable>
				<input type="text" id="image" name="image" value=<?php echo $value['image'] ?> size="29" placeholder="Image" required>
				<input type="hidden" name="id" value=<?php echo $value['id'];?>>
				<input type="submit" name="editpost" value="Editpost">
			</form>
 		</div>
		<?php
		}
	}
	if(isset($_POST['editpost'])){
		$id = filter_input(INPUT_POST, 'id', FILTER_VALIDATE_INT);
		$title = filter_input(INPUT_POST, 'title', FILTER_SANITIZE_SPECIAL_CHARS);
		$content = filter_input(INPUT_POST, 'content', FILTER_SANITIZE_SPECIAL_CHARS);
		$image = filter_input(INPUT_POST, 'image', FILTER_SANITIZE_SPECIAL_CHARS);
		$sql = "UPDATE posts SET title = :title, content = :content, image = :image WHERE id = :id";
		$stmt = $dbh->prepare($sql);
		$stmt->bindParam(':id', $id, PDO::PARAM_INT);
		$stmt->bindParam(':title', $title,  PDO::PARAM_STR);
	    $stmt->bindParam(':content', $content,  PDO::PARAM_STR);
	   	$stmt->bindParam(':image', $image,  PDO::PARAM_STR);
	    $stmt->execute();
	    Header("Location: ../POST/POST.php");
		exit();
	}
?>
</body>
</html>	