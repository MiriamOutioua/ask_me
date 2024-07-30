<?php

	require_once "../layouts/header.php";

	$l_uid = $_SESSION['id'];

	if (isset($_GET['id']) && isset($_GET['id2'])) {
		$a_id =  $_GET['id'];
		$p_id =  $_GET['id2'];

		$req = "SELECT * FROM answers WHERE a_id = $a_id";
		$result = mysqli_query($dbh, $req);
		$queryResult = mysqli_num_rows($result);

		if ($queryResult > 0) {
			$req_like = "SELECT * FROM likes WHERE l_uid = '$l_uid' AND answer_id = $a_id";
			$result_like = mysqli_query($dbh, $req_like);
			$query = mysqli_num_rows($result_like);

			if ($query > 0) {
				$req_unlike = "DELETE FROM likes WHERE l_uid = '$l_uid' AND answer_id = $a_id";
				$result_unlike = mysqli_query($dbh, $req_unlike);

			} else {
				$req1 = "INSERT INTO likes (answer_id, l_uid) VALUES ('$a_id', '$l_uid')";
				$result1 = mysqli_query($dbh, $req1);
			}

			$req2 = "SELECT * FROM likes WHERE answer_id = $a_id";
			$result2 = mysqli_query($dbh, $req2);
		
			if ($result2) {
				$like_count = mysqli_num_rows($result2);
		
				$req_like1 = "UPDATE answers SET like_count = '$like_count' WHERE a_id = $a_id";
				$result_like = mysqli_query($dbh, $req_like1);
		
			}
	
			header("Location: ../posts/post.php?id=" . $p_id);
	
		}
	}