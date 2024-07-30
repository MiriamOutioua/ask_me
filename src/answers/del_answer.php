<?php

	require_once "../layouts/header.php";

	if (isset($_GET['id']) && isset($_SESSION['id'])) {
		$a_id =  $_GET['id'];
		$uid = $_SESSION['id'];

		$req = "DELETE FROM answers WHERE a_id = '$a_id' AND a_uid = $uid";
		$queryResults = mysqli_query($dbh, $req);

		if (!$queryResults) {
			echo "Impossible de supprimer la réponse";
		} else {
			header('Location: ../profil/profil.php?id='.$_SESSION['id'] . "&page=reponses");
		}
	}