<?php

    $page = "profil";
    require_once "../layouts/header.php";
    require_once "../auth/fonctions.php";

    if (isset($_SESSION['id'])) {
        
        $uid = $_SESSION['id'];
        $p_id  = $_GET['id'];

        $date = date('Y-m-d H:i:s');

        $req = "SELECT * FROM posts WHERE p_id = $p_id && p_uid = $uid";
        $result = mysqli_query($dbh, $req);
        $queryResults = mysqli_num_rows($result);

        if ($queryResults == 0) {
            header('Location: ../accueil/accueil.php');
        }

        $req = "SELECT * FROM posts WHERE p_id = $p_id && p_uid = $uid";
        $result = mysqli_query($dbh, $req);
        $post = mysqli_fetch_assoc($result);

        if (isset($_POST['edit'])) {    
            if (isset($_POST['newtitle']) && !empty($_POST['newtitle']) 
				&& checkInput($dbh, $_POST['newtitle']) != $post['p_title']) {
			
                $newtitle = checkInput($dbh, $_POST['newtitle']);
               
                $reqtitle = "UPDATE posts SET p_title = '$newtitle', p_edit_date = '$date' WHERE p_id = $p_id && p_uid = $uid";
                mysqli_query($dbh, $reqtitle);
                
                header('Location: ../profil/profil.php?id='. $_SESSION['id'] . "&page=questions");
            } else {
                $err = "Veuillez remplir tous les champs.";
            }

            if (isset($_POST['newcontent']) && !empty($_POST['newcontent']) 
				&& checkInput($dbh, $_POST['newcontent']) != $post['p_content']) {

                $newcontent = checkInput($dbh, $_POST['newcontent']);
               
                $reqcontent = "UPDATE posts SET p_content = '$newcontent', p_edit_date = '$date' WHERE p_id = $p_id && p_uid = $uid";
                mysqli_query($dbh, $reqcontent);
                
                header('Location: ../profil/profil.php?id='. $_SESSION['id'] . "&page=questions");
            } else {
                $err = "Veuillez remplir tous les champs.";
            }

            if (isset($_POST['newtags']) && !empty($_POST['newtags']) 
				&& checkInput($dbh, $_POST['newtags']) != $post['p_tags']) {

                $newtags = checkInput($dbh, $_POST['newtags']);
               
                $reqtags = "UPDATE posts SET p_tags = '$newtags', p_edit_date = '$date' WHERE p_id = $p_id && p_uid = $uid";
                mysqli_query($dbh, $reqtags);
                
                header('Location: ../profil/profil.php?id='. $_SESSION['id'] . "&page=questions");
            } else {
                $err = "Veuillez remplir tous les champs.";
            }
            if (checkInput($dbh, $_POST['newtitle']) === $post['p_title'] 
				&& checkInput($dbh, $_POST['newcontent']) === $post['p_content'] 
				&& checkInput($dbh, $_POST['newtags']) === $post['p_tags']) {
                $err = "Aucune modification n'a été faite";
            }
        }

?>

<div class="edit-post-container">
    <p title="Retour à votre page de profil sans modification" class="retour-profil"><a href="../profil/profil.php?id=<?php echo $uid; ?>&page=questions">⬅</a></p>
    <h1>&Eacute;diter la question</h1>
    <?php
        if (isset($err)) echo "<p class='err'>".$err."</p>";
    ?>
    <div class="edit-form">
        <form method="POST">
            <label for="title">Titre</label>
            <input id="title" name="newtitle" value="<?php echo $post['p_title']; ?>">
            
            <label for="content">Contenu</label>
            <textarea id="content" name="newcontent" cols="30" rows="10"><?php echo $post['p_content']; ?></textarea>

            <label for="tags">Tags</label>
            <input id="tags" type="text" name="newtags" value="<?php echo $post['p_tags']; ?>">

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