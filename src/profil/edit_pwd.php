<?php
    
    $page = "profil";
	require_once "../layouts/header.php";

    if (isset($_SESSION['id'])) {

        require_once "../auth/fonctions.php";

        $uid = $_SESSION['id'];

        $req = "SELECT * FROM users WHERE id = $uid";
        $result = mysqli_query($dbh, $req);
        $user = mysqli_fetch_assoc($result);

        if (isset($_POST['edit'])) {        
            if (isset($_POST['oldpwd']) && !empty($_POST['oldpwd']) && isset($_POST['newpwd']) 
				&& !empty($_POST['newpwd']) && isset($_POST['confpwd']) && !empty($_POST['confpwd'])) {
                
                $oldpwd = checkInput($dbh, $_POST['oldpwd']);
                $newpwd = checkInput($dbh, $_POST['newpwd']);
                $confpwd = checkInput($dbh, $_POST['confpwd']);

                if ($newpwd === $confpwd) {
                    $oldpwd = md5($oldpwd);
                    $newpwd = md5($newpwd);
                    
                    $req = "SELECT password FROM users WHERE id = $uid AND password = '$oldpwd'";
                    $req = mysqli_query($dbh, $req);
                    $resultat = mysqli_num_rows($req);
                
                    if ($resultat == 1) {
                        $reqpwd = "UPDATE users SET password = '$newpwd' WHERE id = $uid";
                        mysqli_query($dbh, $reqpwd);
                        $maj = "Votre mot de passe a été modifié";    
                    } else {
                        $err_pwd = "Mot de passe incorrect.";
                    }
                } else {
                    $err_ncpwd = "Vos mots de passe ne correspondent pas.";
                }
            } else {
                if (!isset($_POST['newpwd']) || empty($_POST['newpwd'])) {
                    $err_npwd = "Entrer votre nouveau mot de passe";
                }
                if (!isset($_POST['confpwd']) || empty($_POST['confpwd'])) {
                    $err_cpwd = "Confirmer votre mot de passe.";
                }
                if (!isset($_POST['oldpwd']) || empty($_POST['oldpwd'])) {
                    $err_pwd = "Entrer votre mot de passe.";
                }
            }
        }

?>

<div class="edit-profil-container">
    <p title="Retour à votre page de profil sans modification" class="retour-profil"><a href="profil.php?id=<?php echo $uid; ?>&page=questions">⬅</a></p>
    <h1>Modifier le mot de passe</h1>
    <?php if (isset($maj)) echo "<p class='maj'>".$maj."</p>"; ?>
    <div class="edit-form">
        <form method="POST">
            <label for="password">Mot de passe actuel</label>
            <?php if (isset($err_pwd)) echo "<p class='err'>".$err_pwd."</p>"; ?>
            <input id="password" type="password" name="oldpwd" placeholder="Entrer votre mot de passe actuel">

            <label for="password">Nouveau mot de passe</label>
            <?php if (isset($err_ncpwd)) echo "<p class='err'>".$err_ncpwd."</p>"; ?>
            <?php if (isset($err_npwd)) echo "<p class='err'>".$err_npwd."</p>"; ?>
            <input id="password" type="password" name="newpwd" placeholder="Entrer votre nouveau mot de passe">

            <label for="password">Confirmer le Nouveau mot de passe</label>
            <?php if (isset($err_cpwd)) echo "<p class='err'>".$err_cpwd."</p>"; ?>
            <input id="password" type="password" name="confpwd" placeholder="Confirmer votre nouveau mot de passe">

            <button type="submit" name="edit" >Enregistrer les modifications</button>
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
