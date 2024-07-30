<?php

	$page = "admin";

	require_once "../layouts/header.php";
	require_once "../auth/fonctions.php";

	if (isset($_SESSION['isAdmin']) && $_SESSION['isAdmin'] != 1) {
		header("Location: ../accueil/accueil.php");
	}

	if (!empty($_POST)) {

		if(isset($_POST['username']) && isset($_POST['email']) 
			&& isset($_POST['password']) && isset($_POST['confirm'])
			&& !empty($_POST['username']) && !empty($_POST['email']) 
			&& !empty($_POST['password']) && !empty($_POST['confirm'])) {

			$username = checkInput($dbh, $_POST['username']);
			$email = checkInput($dbh, $_POST['email']);
			$password = md5(checkInput($dbh, $_POST['password']));
			$isAdmin = 1; 

			if (check_email_exist($dbh, $_POST['email']) && check_username($dbh, $_POST['username']) 
				&& confirm_password($_POST['password'], $_POST['confirm'])) {
				$req = "INSERT INTO users (username, email, password, isAdmin) VALUES ('$username', '$email', '$password', '$isAdmin')";
				$result = mysqli_query($dbh, $req);

				$success = "L'admin a bien été ajouté";
			}
			else if (!check_email_exist($dbh, $_POST['email'])) {
				$erreur_email = "Cet email est déjà associé à un compte";
			}
			else if (!check_username($dbh, $_POST['username'])) {
				$erreur_username = "Le nom d'utilisateur est déjà utilisé";
			} else {
				$erreur_confirm = "Les deux mots de passe ne sont pas identiques";
			}
		} else {
			$erreur_champ = "Veuillez remplir tous les champs";
		}
	}

?>

<div class="container-admin">
	<div class="admin-form-container">
		<p title="Retour" class="retour"><a href="accueil_admin.php">⬅</a></p>
		<?php if(isset($success)){ echo "<p class='success'>" . $success . "</p>"; }?>

		<h1>Ajouter un nouvel admin</h1>
		<form method="POST" action="" class="admin-form">
			<?php if(isset($erreur_champ)) echo "<p class='erreur'> " . $erreur_champ . "</p>"; ?>

			<label for="email">Adresse Email</label>
			<input id="email" type="email" name="email" placeholder="Entrer une adresse email">
			<?php if(isset($erreur_email)) echo "<p class='erreur'> " . $erreur_email . "</p>"; ?>

			<label for="username">Nom d'utilisateur</label>
			<input id="username" type="text" name="username" placeholder="Entrer un nom d'utilisateur">
			<?php if(isset($erreur_username)) echo "<p class='erreur'> " .$erreur_username . "</p>"; ?>  </p>

			<label for="password">Mot de passe</label>
			<input id="password" type="password" name="password" placeholder="Entrer un mot de passe">

			<label for="confirm">Confirmation du mot de passe</label>
			<input id="confirm" type="password" name="confirm" placeholder="Entrer à nouveau le mot de passe">
			<?php if(isset($erreur_confirm)) echo "<p class='erreur'> " .$erreur_confirm . "</p>"; ?> </p>

			<button type="submit" id="sign up">Ajouter</button>

		</form>
	</div>
</div>

<?php

	require_once "../layouts/footer.php";

?>