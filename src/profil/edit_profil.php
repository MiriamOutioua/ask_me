<?php

    $page = "profil";
	require_once "../layouts/header.php";
    require_once "../auth/fonctions.php";

    if (isset($_SESSION['id'])) {
        
        $uid = $_SESSION['id'];

        $req = "SELECT * FROM users WHERE id = $uid";
        $result = mysqli_query($dbh, $req);
        $user = mysqli_fetch_assoc($result);

        if (isset($_POST['edit'])) {    
            
            if (isset($_POST['newusername']) && !empty($_POST['newusername']) 
				&& checkInput($dbh, $_POST['newusername']) != $user['username']) {

                $newusername = checkInput($dbh, $_POST['newusername']);
               
                $req = "SELECT username FROM users WHERE username = '$newusername'";
                $req = mysqli_query($dbh, $req);
                $resultat = mysqli_num_rows($req);
               
                if ($resultat == 0) {
                    $requsername = "UPDATE users SET username = '$newusername' WHERE id = $uid";
                    mysqli_query($dbh, $requsername);
                    $reqauthor = "UPDATE posts SET p_author = '$newusername' WHERE p_uid = $uid";
                    mysqli_query($dbh, $reqauthor);
                    $reqauthor_a = "UPDATE answers SET a_author = '$newusername' WHERE a_uid = $uid";
                    mysqli_query($dbh, $reqauthor_a);
                    
                    header('Location: profil.php?id='.$_SESSION['id'] . "&page=questions");
                } else {
                    $erreur_username = "Ce nom d'utilisateur est déjà utilisé.";
                }
            }

            if (isset($_POST['newemail']) && !empty($_POST['newemail']) 
				&& checkInput($dbh, $_POST['newemail']) != $user['email']) {
               
                $newemail = checkInput($dbh, $_POST['newemail']);
               
                $req = "SELECT email FROM users WHERE email = '$newemail'";
                $req = mysqli_query($dbh, $req);
                $resultat = mysqli_num_rows($req);
               
                if ($resultat == 0) {
                    $reqemail = "UPDATE users SET email = '$newemail' WHERE id = $uid";
                    mysqli_query($dbh, $reqemail);
                   
                    header('Location: profil.php?id='.$_SESSION['id'] . "&page=questions");
                } else {
                    $erreur_email = "Cette adresse email est déjà associé à un compte.";
                }
            }
            
            if (checkInput($dbh, $_POST['newusername']) === $user['username'] 
				&& checkInput($dbh, $_POST['newemail']) === $user['email']) {
                $erreur_champ = "Aucune modification n'a été faite";
            }

            if ((!isset($_POST['newusername']) && empty($_POST['newusername'])) 
				|| (!isset($_POST['newemail']) && empty($_POST['newemail']))) {
                $erreur_champ = "Veuillez remplir tous les champs";
            }
            
        }

?>

<div class="edit-profil-container">
    <p title="Retour à votre page de profil sans modification" class="retour-profil"><a href="profil.php?id=<?php echo $uid; ?>&page=questions">⬅</a></p>
    <h1>&Eacute;diter le profil</h1>
    <div class="edit-form">
        <?php if (isset($erreur_champ)) echo "<p class='err'>" . $erreur_champ. "</p>"; ?>
        <form method="POST" enctype="multipart/form-data">
            <label for="email">Adresse Email </label>
            <?php if (isset($erreur_email)) echo "<p class='err'>".$erreur_email."</p>";?>
            <input id="email" type="email" name="newemail" value="<?php echo $user['email']; ?>">
            
            <label for="username">Nom d'utilisateur</label>
            <?php if (isset($erreur_username)) echo "<p class='err'>".$erreur_username."</p>"; ?>
            <input id="username" type="text" name="newusername" value="<?php echo $user['username']; ?>">

            <button type="submit" name="edit">Enregistrer les modifications</button>
            <button type="reset">Annuler les modifications</button>
        </form>
    </div>
</div>

<?php 

    } else {
        header('Location: ../../index.php');
    }

	require_once "../layouts/footer.php";
    
?>    