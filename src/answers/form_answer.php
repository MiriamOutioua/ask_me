<div class="post-box">
	<form action="../answers/form_answer.php" method="POST">
		<h3>Votre réponse</h3>
		<textarea name="a_content" id="a_content" cols="30" rows="10"></textarea>
		<button type="submit" id="submit_answer" name="submit_answer">Poster ma réponse</button>
		<input type="hidden" name="post_id" value="<?php echo $post_id; ?>">
	</form>
</div>
<h3>Réponses : </h3>

<?php
	require_once "../layouts/header.php";
	require_once "../auth/fonctions.php";

	if (isset($_POST['submit_answer'])) {
		$a_content = checkInput($dbh, $_POST['a_content']);
		$post_id = $_POST['post_id'];
		$a_uid = $_SESSION['id'];
	
		$req = "SELECT * FROM users WHERE id = $uid";
		$result = mysqli_query($dbh, $req);
		$user = mysqli_fetch_assoc($result);	
	
		$a_author = $user['username'];
	
		if (isset($a_content) && isset($post_id) && !empty($a_content) && !empty($post_id)) {
			$req = "INSERT INTO answers (a_author, a_content, post_id, a_uid) VALUES ('$a_author', '$a_content', '$post_id', '$a_uid')";
			$result = mysqli_query($dbh, $req);
			
			header("Location: ../posts/post.php?id=$post_id");
		} else {
			header("Location: ../posts/post.php?id=$post_id");
		}
	}
?>