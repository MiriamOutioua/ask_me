<?php

	$page = "home";
	require_once "../layouts/header.php";

?>

<div class="post-container">
	<?php

		$search = "";
		$req = "SELECT * FROM posts WHERE p_title LIKE '%$search%' ORDER BY p_date DESC"; 
        $result = mysqli_query($dbh, $req);
		$queryResult = mysqli_num_rows($result);

		if ($queryResult > 0) {

			while ($lignes = mysqli_fetch_assoc($result)) {
				require "../posts/info_post.php";
			}
		} else {
            echo "<div class='post-box'>Aucun contenu</div>";
		}
	
	?>
</div>

<?php

	require_once "../layouts/footer.php";

?>