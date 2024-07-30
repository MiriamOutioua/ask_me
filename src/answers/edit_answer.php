<?php

    $page = "profil";
    require_once "../layouts/header.php";
    require_once "../auth/fonctions.php";

    if (isset($_SESSION['id'])) {   
        $uid = $_SESSION['id'];
        $a_id  = $_GET['id'];

        $date = date('Y-m-d H:i:s');

        $req = "SELECT * FROM answers WHERE a_id = $a_id AND a_uid = $uid";
        $result = mysqli_query($dbh, $req);
        $queryResults = mysqli_num_rows($result);

        if ($queryResults == 0) {
            header('Location: ../accueil/accueil.php');
        }

        $req = "SELECT * FROM answers WHERE a_id = $a_id AND a_uid = $uid";
        $result = mysqli_query($dbh, $req);
        $post = mysqli_fetch_assoc($result);

        if (isset($_POST['edit'])) {    
            if (isset($_POST['newcontent']) && !empty($_POST['newcontent']) 
				&& checkInput($dbh, $_POST['newcontent']) != $post['a_content']) {               

                $newcontent = checkInput($dbh, $_POST['newcontent']);

                $reqcontent = "UPDATE answers SET a_content = '$newcontent', a_edit_date = '$date' WHERE a_id = $a_id && a_uid = $uid";
                mysqli_query($dbh, $reqcontent);
                
                header('Location: ../profil/profil.php?id='.$_SESSION['id'] . "&page=reponses");
            } else {
                $err = "Veuillez remplir tous les champs.";
            }

            if (checkInput($dbh, $_POST['newcontent']) === $post['a_content']) {
                $err = "Aucune modification n'a été faite.";
            }
        }

?>

<div class="edit-post-container">
    <p title="Retour à votre page de profil sans modification" class="retour-profil"><a href="../profil/profil.php?id=<?php echo $uid; ?>&page=reponses">⬅</a></p>
    <h1>&Eacute;diter la réponse</h1>
    <?php if (isset($err)) echo "<p class='err'>".$err."</p>"; ?>
    <div class="edit-form">
        <form method="POST">
			
            <label for="content">Contenu</label>
            <textarea id="content" name="newcontent" cols="30" rows="10"><?php echo $post['a_content']; ?></textarea>
			
            <button type="submit" name="edit">Enregistrer les modifications</button>
            <button type="reset">Annuler les modifications</button>
        </form>
    </div>
</div>

<?php 

    }
    else
    {
        header('Location: ../../index.php');
    }

	require_once "../layouts/footer.php";
    
?>  