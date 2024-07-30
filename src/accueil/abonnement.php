<?php

	$page = "abonnement";
	require_once "../layouts/header.php";
	require_once "../posts/fonc_date.php";

?>

<div class="post-container">
    <?php
        $uid = $_SESSION['id'];

        $nbAbo = "SELECT f_suivre FROM follow WHERE f_user_id = $uid";
        $result = mysqli_query($dbh, $nbAbo);

        $queryResults = mysqli_num_rows($result);

        if ($queryResults > 0) {
            $sql = "SELECT * FROM answers, follow WHERE f_user_id = $uid AND a_uid = f_suivre ORDER BY a_date DESC"; 
            $result = mysqli_query($dbh, $sql);
            
            $queryResults = mysqli_num_rows($result);

            if ($queryResults > 0) {

                while ($rows = mysqli_fetch_assoc($result)) {

					$req = "SELECT * FROM posts WHERE p_id = " . $rows['post_id'];
					$results = mysqli_query($dbh, $req);
					$query = mysqli_num_rows($results);

					if ($query > 0) {

						while ($lignes = mysqli_fetch_assoc($results)) {
							require "../posts/info_post.php";

							if (strlen($rows['a_content']) > 110) {
								$extrait = substr($rows['a_content'], 0, 110) . "...";
							} else {
								$extrait = $rows['a_content'];
							}

							$str = "<div class='answer_abonne' id='" . $rows['a_id'] . "'>
								<div class='answer-content-profil'>
									<a href='../posts/post.php?id=" . $rows['post_id'] . "#" . $rows['a_id'] . "'><h3>" . $extrait . "</h3></a>
									<p>";  

							$str .= "<p class='answer-date'><a title='Voir le profil' href='../profil/voir_profil.php?id=".$rows['a_uid']."&page=questions'>".$rows['a_author']."</a> &#10072; ";        

							if ($rows['a_edit_date'] === '0000-00-00 00:00:00') {
								$str .= " Posté le : " . convert_date($rows['a_date']) . "</p></div></div>";
							} else {
								$str .= " Posté le : " . convert_date($rows['a_date']) . " &#10072; Modifié le : " . convert_date($rows['a_edit_date']) . "</p></div></div>";
							}
							echo $str;
						}
					}
					
                }
            } else {
                echo "<div class='post-box'>Aucun contenu.</div>";
            }
        } else {
            echo "<div class='post-box'>Vous ne suivez aucun utilisateur.</div>";
        }
    ?>
	
</div>

<?php

	require_once "../layouts/footer.php";

?>