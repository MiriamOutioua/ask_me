<?php

	require_once "../layouts/header.php";

	if (isset($_GET['id']) && isset($_SESSION['id'])) {
		$p_id =  $_GET['id'];
		$uid = $_SESSION['id'];

		$req = "DELETE FROM posts WHERE p_id = '$p_id' AND p_uid = $uid";
		$req_a = "DELETE FROM answers WHERE post_id ='$p_id'";
		$queryResults = mysqli_query($dbh, $req);
		$queryResults_a = mysqli_query($dbh, $req_a);

		if (!$queryResults || !$queryResults_a) {
			echo "Impossible de supprimer la question";
		} else {
			header('Location: ../profil/profil.php?id='.$_SESSION['id'] . "&page=questions");
		}
	}
