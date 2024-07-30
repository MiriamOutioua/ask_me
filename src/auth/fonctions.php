<?php

function checkInput($dbh, $data) {
	$data = trim($data);
	$data = stripslashes($data);
	$data = htmlspecialchars($data);
	$data = mysqli_real_escape_string($dbh, $data);
	return $data;
}

function check_password($dbh, $email) {
	$req = "SELECT username, email, password FROM users WHERE email = '$email'";
	$resultat = mysqli_query($dbh, $req);
	$lignes = mysqli_num_rows($resultat);
	
	if ($lignes > 0) {
		$query = mysqli_fetch_assoc($resultat);
		if (md5($_POST['password']) === $query['password']) {
			return 1;
		}
		return 0;
	}
}

function check_email($dbh, $email) {
	$req = "SELECT email FROM users WHERE email = '$email'";
	$resultat = mysqli_query($dbh, $req);
	$lignes = mysqli_num_rows($resultat);
	if ($lignes > 0) {
		$query = mysqli_fetch_assoc($resultat);
		if ($_POST['email'] === $query['email']) {
			return 1;
		}
		return 0;
	}
}

function check_email_exist($dbh, $email) {
	$req = "SELECT username, email FROM users WHERE email = '$email'";
	$resultat = mysqli_query($dbh, $req);
	$lignes = mysqli_num_rows($resultat);
	if ($lignes == 0) {
		return 1;
	}
	return 0;
}

function check_username($dbh, $username) {
	$req = "SELECT username, email FROM users WHERE username = '$username'";
	$resultat = mysqli_query($dbh, $req);
	$lignes = mysqli_num_rows($resultat);
	if ($lignes == 0) {
		return 1;
	}
	return 0;
}

function confirm_password($password, $confirm) {
	if ($password === $confirm) {
		return 1;
	}
	return 0;
}