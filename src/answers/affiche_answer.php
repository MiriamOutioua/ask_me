<?php
    require_once "isLiked.php";
	$req = "SELECT * FROM answers WHERE post_id = $post_id ORDER BY like_count DESC";
	$result = mysqli_query($dbh, $req);
	$queryResult = mysqli_num_rows($result);

	if ($queryResult == 0) {
		echo "<div class='post-box'>Il n'y aucune réponse à cette question pour l'instant.</div>";
	}

	if ($queryResult > 0):
		while ($lignes = mysqli_fetch_assoc($result)):
?>

	<div class="answer" id="<?php echo $lignes['a_id']; ?>">
		<div class="like">
			<a href="../answers/like.php?id=<?php echo $lignes['a_id'] . "&id2=" . $lignes['post_id']; ?>" title="Réponse utile"><p id="like-button" class="<?php echo isLiked($dbh, $uid, $lignes['a_id']); ?>">&#10003;</p> <p><?php echo $lignes['like_count'];?></p></a>
		</div>
		<div class="answer-content">
			<p>
				<?php
					echo str_replace('\n', '<br />', nl2br($lignes['a_content']));
				?>
				</p>
			<?php
				if ($lignes['a_uid'] == $_SESSION['id']) {    
					echo "<p class='answer-date'><a title='Voir le profil' href='../profil/profil.php?id=$uid&page=questions'>".$lignes['a_author']."</a> &#10072; ";
				} else {        
					echo "<p class='answer-date'><a title='Voir le profil' href='../profil/voir_profil.php?id=".$lignes['a_uid']."&page=questions'>".$lignes['a_author']."</a> &#10072; ";        
				}

				if ($lignes['a_edit_date'] === '0000-00-00 00:00:00') {
					echo "Posté le : " . convert_date($lignes['a_date']) . "</p>";
				} else {
					echo "Posté le : " . convert_date($lignes['a_date']) . " | Modifié le : " . convert_date($lignes['a_edit_date']) . "</p>";	
				}

			?>
		</div>
	</div>

<?php 
	endwhile;
	endif;
?>