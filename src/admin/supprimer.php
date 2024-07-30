<?php

	require_once "../layouts/header.php";

	if (isset($_GET['id'])) {
		$id = $_GET['id'];

		$req_p = "DELETE FROM posts WHERE p_id = $id";
		$req_a = "DELETE FROM answers WHERE post_id = $id";
		$queryResult_p = mysqli_query($dbh, $req_p);
		$queryResult_a = mysqli_query($dbh, $req_a);

		if (!($queryResult_a && $queryResult_p && $queryResult_l)) {
			echo "Impossible de supprimer cette question";
		}

		header('Location: accueil_admin.php?page_admin=tab_questions');
	}

	if (isset($_GET['id2'])) {
		$id2 = $_GET['id2'];

		$req = "DELETE FROM answers WHERE a_id = $id2";
		$req_l = "DELETE FROM likes WHERE answer_id = $id2";
		$queryResult = mysqli_query($dbh, $req);
		$queryResult_l = mysqli_query($dbh, $req_l);

		if (!($queryResult && $queryResult_l)) {
			echo "Impossible de supprimer cette réponse";
		}

		header("Location: accueil_admin.php?page_admin=tab_reponses");
	}

	if (isset($_GET['id_u'])) {
		$id_u = $_GET['id_u'];

		$req_u = "DELETE FROM users WHERE id = $id_u";
		$req_p = "DELETE FROM posts WHERE p_uid = $id_u";
		$req_a = "DELETE FROM answers WHERE a_uid = $id_u";
		$req_l = "DELETE FROM likes WHERE l_uid = $id_u";
		$req_f = "DELETE FROM follow WHERE f_user_id = $id_u";
		$req_f2 = "DELETE FROM follow WHERE f_suivre = $id_u";

		$queryResult_u = mysqli_query($dbh, $req_u);
		$queryResult_p = mysqli_query($dbh, $req_p);
		$queryResult_a = mysqli_query($dbh, $req_a);
		$queryResult_l = mysqli_query($dbh, $req_l);
		$queryResult_f = mysqli_query($dbh, $req_f);
		$queryResult_f2 = mysqli_query($dbh, $req_f2);

		if (!($queryResult_u && $queryResult_p && $queryResult_a && $queryResult_l && $queryResult_f && $queryResult_f2)) {
			echo "Impossible de supprimer ce profil";
		}

		header("Location: accueil_admin.php?page_admin=tab_profils");
	}