<?php 

require_once "Database.php";
require_once "fonctions.php";

$username = $email = $password = '';
$dbhSqli = Database::connectSqli();

if (isset($_POST['sign_up'])) {

	if( isset($_POST['username']) && isset($_POST['email']) && isset($_POST['password']) && isset($_POST['confirm'])
		&& !empty($_POST['username']) && !empty($_POST['email']) && !empty($_POST['password']) && !empty($_POST['confirm'])) {
		
			$username = checkInput($dbhSqli, $_POST['username']);
			$email = checkInput($dbhSqli, $_POST['email']);
			$password = md5(checkInput($dbhSqli, $_POST['password']));
			$isAdmin = 0;

			if (check_email_exist($dbhSqli, $_POST['email']) && check_username($dbhSqli, $_POST['username']) 
				&& confirm_password($_POST['password'], $_POST['confirm'])) {
					$req = "INSERT INTO users (username, email, password, isAdmin) VALUES ('$username', '$email', '$password', '$isAdmin')";
					$result = mysqli_query($dbhSqli, $req);

					header("Location: ../accueil/accueil.php");
					session_start();

					$req = "SELECT id, isAdmin FROM users WHERE username = '$username'"; 
					$result = mysqli_query($dbhSqli, $req);
					$queryResult = mysqli_num_rows($result);
					if ($queryResult > 0) {

						while ($lignes = mysqli_fetch_assoc($result)) {
							$_SESSION['username'] = $username;
							$_SESSION['email'] = $email;
							$_SESSION['id'] = $lignes['id'];
							$_SESSION['isAdmin'] = $lignes['isAdmin'];
						}
					}
			}
			if (!check_email_exist($dbhSqli, $_POST['email'])) {
				$erreur_email = "Cet email est déjà associé à un compte";

			} 
			else if (!check_username($dbhSqli, $_POST['username'])) {
				$erreur_username = "Le nom d'utilisateur est déjà utilisé";	
			} 
			else if (!confirm_password($_POST['password'], $_POST['confirm'])) {
				$erreur_confirm = "Les deux mots de passe ne sont pas identiques";
			}
	} else {
		$erreur_champ = "Veuillez remplir tous les champs";
	}
}

?>


<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" href="style_auth.css">
	<link rel="preconnect" href="https://fonts.gstatic.com">
	<link href="https://fonts.googleapis.com/css2?family=Ubuntu&display=swap" rel="stylesheet">
	<link rel="preconnect" href="https://fonts.gstatic.com">
	<link href="https://fonts.googleapis.com/css2?family=Kaushan+Script&display=swap" rel="stylesheet">
	
	<title>ASK.me</title>
</head>
<body>
	<div class="page">
		<div class="card">

			<div class="left">
				<div class="left-text">
					<h2>ASK.me</h2>
					<p id="p1">
						Bienvenue sur ASK.me ! 
					</p>
					<p>Vous avez déjà un compte ?</p>
					<a href="../../index.php">Connectez-vous</a>
				</div>
			</div>

			<div class="right">
				<div class="form-content">
					<h1>Inscription</h1>
					<?php if(isset($erreur_champ)) echo "<p class='erreur'> " . $erreur_champ . "</p>"; ?> </p>

					<form method="POST" action="">
						<label for="email">Adresse Email</label>
						<input id="email" type="email" name="email" placeholder="Entrer votre adresse email">
						<?php if(isset($erreur_email)) echo "<p class='erreur'> " . $erreur_email . "</p>"; ?>

						<label for="username">Nom d'utilisateur</label>
						<input id="username" type="text" name="username" placeholder="Entrer votre nom d'utilisateur">
						<?php if(isset($erreur_username)) echo "<p class='erreur'> " .$erreur_username . "</p>"; ?>  </p>

						<label for="password">Mot de passe</label>
						<input id="password" type="password" name="password" placeholder="Entrer votre mot de passe">

						<label for="confirm">Confirmer le mot de passe</label>
						<input id="confirm" type="password" name="confirm" placeholder="Entrer à nouveau le mot de passe">
						<?php if(isset($erreur_confirm)) echo "<p class='erreur'> " .$erreur_confirm . "</p>"; ?> </p>
						<?php require_once "showPass.php"; ?>

						<button type="submit" id="sign_up" name="sign_up">Inscription &#10142</button>
					</form>
				</div>
			</div>

		</div>
	</div>
	<div class="circle1"></div>
	<div class="circle2"></div>
</body>
</html>