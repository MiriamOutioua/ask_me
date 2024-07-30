<?php

	$page = "admin";

	require_once "../layouts/header.php";
	require_once "tableau_admin.php";

	if (isset($_SESSION['isAdmin']) && $_SESSION['isAdmin'] != 1) {
		header("Location: ../accueil/accueil.php");
	}

?>


<div class="admin-table">
	<div class="ajout-admin"><a href="ajout_admin.php">Ajouter un admin</a></div>

	<div class="lien-questions"><a href="accueil_admin.php?page_admin=tab_questions">Questions</a></div>

	<div class="lien-reponses"><a href="accueil_admin.php?page_admin=tab_reponses">Réponses</a></div>

	<div class="lien-profils"><a href="accueil_admin.php?page_admin=tab_profils">Profils</a></div>

	<div class="lien-admins"><a href="accueil_admin.php?page_admin=tab_admins">Admins</a></div>

	<?php 
		tab_questions($dbh);
	
		tab_reponses($dbh);

		tab_profils($dbh);

		tab_admins($dbh); 
	?>

</div>


<?php

	require_once "../layouts/footer.php";

?>	