<?php
	require_once "../layouts/header.php";

	if (isset($_SESSION['id'])) { 
		$id =  $_GET['id'];

?>

<div class='abo-container'>
	<p title="Retour à votre page de profil" class="retour-abo"><a href="profil.php?id=<?php echo $_GET['id']; ?>&page=questions">⬅</a></p>
	<?php
		$req = "SELECT username, id FROM follow, users WHERE f_user_id = id AND f_suivre = $id ORDER BY username";
		$result = mysqli_query($dbh, $req);

		$queryResults = mysqli_num_rows($result);

		if ($queryResults > 0)
		{
			while ($lignes = mysqli_fetch_assoc($result))
			{
				echo "<div class='abo-box'><a title='Voir le profil' href='voir_profil.php?id=".$lignes['id']."&page=questions'>".$lignes['username']."</a></div>";
			}
		}
	?>
</div>  


<?php

} else {
		header('Location: ../../index.php');
	}

	require_once "../layouts/footer.php";

?>
