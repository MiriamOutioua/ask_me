<?php

	$page = "ask";
	require_once "../layouts/header.php";
	require_once "../auth/fonctions.php";

	if (isset($_POST['submit'])) {	
		$p_title = checkInput($dbh, $_POST['title']);
		$p_content = checkInput($dbh, $_POST['content']);
		$p_tags = checkInput($dbh, $_POST['tags']);

		$req = "SELECT * FROM users WHERE id = '$uid'";
		$result = mysqli_query($dbh, $req);
		$user = mysqli_fetch_assoc($result);

		$p_author = $user['username'];
		$p_uid = $_SESSION['id'];

		if (isset($p_title) && isset($p_content) && isset($p_tags) 
			&& !empty($p_title) && !empty($p_content) && !empty($p_tags)) {
			$req = "INSERT INTO posts (p_title, p_content, p_tags, p_author, p_uid) VALUES ('$p_title', '$p_content', '$p_tags', '$p_author', '$p_uid')";
			$result = mysqli_query($dbh, $req);

			header('Location: ../accueil/accueil.php');
		} else {
			$erreur = "Veuillez remplir tous les champs";
		}
	}
?>
<div class="container">

	<div class="content">

		<div class="question">
			<h1 id="Ask">Poser une question</h1>

			<?php if (isset($erreur)) echo "<p class='err'>".$erreur."</p>"; ?>

			<form method="POST" action="">
				<label for="title">Titre</label>
				<input type="text" name="title" id="title">	

				<label for="content">Contenu</label>
				<textarea name="content" id="content" cols="30" rows="10"></textarea>

				<label for="tags">Tags</label>
				<input type="text" name="tags" id="tags">

				<button type="submit" id="submit" name="submit">Poster ma question</button>
			</form>
		</div>

		<div class="how-to-ask">
			<h1>Comment poser votre question :</h1>
			<ul>
				<li>
					<p>
						Le titre doit contenir votre question explicitement.
					</p>
					<p class="exemple">
						Ex : Comment faire un lien en html ?
					</p>
				</li>

				<li>
					<p>
						Dans le contenu, veillez à expliquer votre question de la manière la plus détaillée et dans un français correct.
					</p>
					<p class="exemple">
						Ex : Bonjour, j'aimerais faire un lien en html mais je ne sais pas comment faire.
					</p>
				</li>

				<li>
					<p>
						Enfin, dans les tags, écrivez les catégories auxquelles votre question appartient.
					</p>
					<p class="exemple">
						Ex : #lien #html
					</p>
				</li>
			</ul>
			<p id="ps">Ps : Soyez courtois</p>
		</div>

	</div>
</div>

<?php

	require_once "../layouts/footer.php";

?>