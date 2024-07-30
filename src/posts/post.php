<?php

	require_once "../layouts/header.php";
    require_once "fonc_date.php";
	
	if (isset($_GET['id'])) {
		$id = $_GET['id'];
?>

<div class="post-container">
    <?php
        $post_id = $_GET['id'];

        $sql = "SELECT * FROM posts WHERE p_id = $post_id";
        $result = mysqli_query($dbh, $sql);
        $queryResults = mysqli_num_rows($result);
        
        if ($queryResults == 0) {
            echo "<div class='post-box'>Aucun contenu</div>";
        }

        if ($queryResults > 0):
            while ($lignes = mysqli_fetch_assoc($result)):
    ?>
        <div class="post-box">
            <h1><?php echo $lignes['p_title']; ?></h1>
            <p>
                <?php
                    if ($lignes['p_uid'] == $_SESSION['id']) {    
                        echo "<a title='Voir le profil' href='../profil/profil.php?id=$uid&page=questions'>".$lignes['p_author']."</a>";
                    } else {        
                        echo "<a title='Voir le profil' href='../profil/voir_profil.php?id=".$lignes['p_uid']."&page=questions'>".$lignes['p_author']."</a>";        
                    }   
                ?>
                &#10072; 
                <?php 
                    if ($lignes['p_edit_date'] === '0000-00-00 00:00:00') {
                        echo " Posté le : " . convert_date($lignes['p_date']);
                    } else {
                        echo "Posté le : " . convert_date($lignes['p_date']) . " &#10072; Modifié le : " . convert_date($lignes['p_edit_date']);
                    }
                ?> 
                &#10072; Tag(s) : <?php echo $lignes['p_tags']; ?>

            </p>

            <p class="post-content">
                <?php
                        echo str_replace('\n', '<br />', nl2br($lignes['p_content']));
                ?>
            </p>
        </div>
    <?php
                require_once "../answers/form_answer.php";
            endwhile;
        endif;
        require_once "../answers/affiche_answer.php";
    ?>
</div>

<?php
	} else {
		header("Location: ../accueil/accueil.php");
	}
	require_once "../layouts/footer.php";
    
?>