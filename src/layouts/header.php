<?php

	session_start();
	require_once "../auth/Database.php";
	$dbh = Database::connectSqli();

	if (isset($_SESSION['id'])) {
        $uid = $_SESSION['id'];
	} else {
		header("Location: ../../index.php");
	}
	ini_set('display_errors', 1);
	ini_set('display_startup_errors', 1);
	error_reporting(E_ALL);
?>


<!DOCTYPE html>
<html lang="fr">
	
	<head>
		<meta charset="UTF-8">
		<title>ASK.me</title>
		<link rel="stylesheet" href="../layouts/style_header.css">
		<link rel="stylesheet" href="../posts/style_post.css">
		<link rel="stylesheet" href="../profil/style_profil.css">
		<link rel="stylesheet" href="../ask/style_ask.css">
		<link rel="stylesheet" href="../admin/style_admin.css">

		<link rel="preconnect" href="https://fonts.gstatic.com">
		<link href="https://fonts.googleapis.com/css2?family=Ubuntu&display=swap" rel="stylesheet">

		<link rel="preconnect" href="https://fonts.gstatic.com">
		<link href="https://fonts.googleapis.com/css2?family=Kaushan+Script&display=swap" rel="stylesheet">
	</head>

	<body>
		<header>
			<nav>
				<ul>
					<li><p class="logo">ASK.me</p></li>
					<li>
                        <form class="search_bar" action="../search/search.php" method="POST">
                            <input class="search" id='search' type="text" name="search" placeholder="Rechercher un nom, une question, une date..." >
                            <button type="submit" name="submit-search" title="Chercher">🔍</button>
                        </form>
                    </li>   
				</ul>
			</nav>

			<nav class="nav_bar">
                <ul>
                    <li class="<?php if (isset($page) && $page == "home") { echo 'current'; } ?>" title="Fil d'actualité"><a href="../accueil/accueil.php"><img src="../layouts/icon/home.png" alt="Fil d'actualité" class="nav-icon"></a></li>
                    <li class="<?php if (isset($page) && $page == "abonnement") { echo 'current'; } ?>" title="Abonnement"><a href="../accueil/abonnement.php"><img src="../layouts/icon/friend.png" alt="Abonnement" class="nav-icon"></a></li>
                </ul>
            </nav>

			<nav class="nav_bar">
                <ul>
					<?php if ($_SESSION['isAdmin'] == 1) :?>
						<li class="<?php if (isset($page) && $page == "admin") { echo 'current'; } ?>" title="Admin"><a href="../admin/accueil_admin.php"><img src="../layouts/icon/admin.png" alt="Admin" class="nav-icon"></a></li>
					<?php endif; ?>	

                    <li class="<?php if (isset($page) && $page == "ask") { echo 'current'; } ?>" title="Poser une question"><a href="../ask/ask.php"><img src="../layouts/icon/question.png" alt="Question" class="nav-icon"></a></li>
                    <li class="<?php if (isset($page) && $page == "profil") { echo 'current'; } ?>" title="Profil"><a href="../profil/profil.php?id=<?php echo $_SESSION['id']; ?>&page=questions"><img src="../layouts/icon/profil.png" alt="Profil" class="nav-icon"></a></li>
                    <li title="Déconnexion"><a href="../auth/deconnexion.php" onclick="return confirm('Voulez-vous vraiment vous déconnecter ?')"><img src="../layouts/icon/off.png" alt="Log out" class="nav-icon"></a></li>
                </ul>
            </nav>
		</header>