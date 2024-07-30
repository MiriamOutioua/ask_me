<?php

require_once "src/auth/Database.php";
require_once "src/auth/fonctions.php";

$email = $password = '';
$dbhSqli = Database::connectSqli();


if (isset($_POST['sign_in'])) {
	$email = checkInput($dbhSqli, $_POST['email']);
	$password = md5(checkInput($dbhSqli, $_POST['password']));

	if (isset($email) && isset($password) && !empty($email) && !empty($password)) {

		if (check_password($dbhSqli, $_POST['email']) && check_email($dbhSqli, $email)) {
			header("Location: src/accueil/accueil.php");
			session_start();
			$req = "SELECT * FROM users WHERE email = '$email'";
			$result = mysqli_query($dbhSqli, $req);
			$query = mysqli_num_rows($result);

			if ($query > 0) {
				while ($lignes = mysqli_fetch_assoc($result)) {
					$_SESSION['username'] = $lignes['username'];
					$_SESSION['id'] = $lignes['id'];
					$_SESSION['email'] = $email;
					$_SESSION['isAdmin'] = $lignes['isAdmin'];
				}
			}
		} else {
			$erreur = "Email ou mot de passe incorrect";
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
	<link rel="stylesheet" href="auth/style_auth.css">
	<link rel="preconnect" href="https://fonts.gstatic.com">
	<link href="https://fonts.googleapis.com/css2?family=Ubuntu&display=swap" rel="stylesheet">
	<link rel="preconnect" href="https://fonts.gstatic.com">
	<link href="https://fonts.googleapis.com/css2?family=Kaushan+Script&display=swap" rel="stylesheet">

	<title>ASK.me</title>
</head>
<body id="index">
	<div class="page">
		<div class="card">
			<div class="left">
				<div class="left-text">
					<h2>ASK.me</h2>
					<p id="p1">
						Bienvenue sur ASK.me ! 
					</p>
					<p>Vous n'avez pas de compte ?</p>
					<a href="src/auth/inscription.php">Inscrivez-vous</a>
				</div>
			</div>
			<div class="right">
				<div class="form-content">
					<h1>Connexion</h1>
					<?php if(isset($erreur_champ)) echo "<p class='erreur'> " . $erreur_champ . "</p>"; ?> 

					<form method="POST" action="">
						<label for="email">Adresse email</label>
						<input id="email" type="text" name="email" placeholder="Enter your email">

						<label for="password">Mot de passe</label>
						<input id="password" type="password" name="password" placeholder="Enter your password">
						<?php require_once "auth/showPass.php"; ?>

						<?php if(isset($erreur)) echo "<p class='erreur'> " . $erreur . "</p>"; ?> 
						<button type="submit" id="sign_in" name="sign_in">Connexion &#10142</button>
					</form>
				</div>
			</div>
		</div>
	</div>
	<div class="circle1"></div>
	<div class="circle2"></div>
</body>
</html>