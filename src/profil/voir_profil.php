<?php

	require_once "../layouts/header.php";
    require_once "../posts/fonc_date.php";

	if (isset($_SESSION['id'])) {   

        if (empty($_GET['id']) || !isset($_GET['id'])) {
            header('Location: ../accueil/accueil.php');
        }

        if ($_GET['id'] == $_SESSION['id']) {
            header('Location: profil.php?id='.$_SESSION['id']. "&page=questions");
        }

        $uid = $_SESSION['id'];
        $id = $_GET['id'];

        $req = "SELECT * FROM users WHERE id = $id";
        $result = mysqli_query($dbh, $req);
        $user = mysqli_fetch_assoc($result);

?>

<div class="profil-container">
    <div class="info_bar">
        <?php 
            if ($id != $uid) {
                $estAbonne = "SELECT * FROM follow WHERE f_user_id = $uid && f_suivre = $id";
                $result = mysqli_query($dbh, $estAbonne);
                
                $queryResults = mysqli_num_rows($result);

                if ($queryResults == 0) {
        ?>
        <div title="Suivre" class="suivre"><a href="suivre.php?id=<?php echo $user['id']; ?>">Suivre</a></div>
        <?php 
                } else {
        ?>
        <div title="Se d&eacute;sabonn&eacute;" class="abonne"><a href="suivre.php?id=<?php echo $user['id'] ?>">Abonn&eacute;</a></div>
        <?php 
                }
            }
        ?>

        <ul>
            <li class="
            <?php 
                if (isset($_GET['page']) && $_GET['page'] === "questions") echo "active";
                else if (!isset($_GET['page'])) echo "active";
            ?>">
                <a href="voir_profil.php?id=<?php echo $id ?>&page=questions">Questions</a>
            </li>

            <li class="<?php if (isset($_GET['page']) && $_GET['page'] === "reponses") echo "active"?>" id="reponses">
                <a href="voir_profil.php?id=<?php echo $id ?>&page=reponses">Réponses</a>
            </li>

        </ul>
        
        <div class="profil">
            <img src="../layouts/img/profil.png" width="200" alt="Photo de profil">
            <p class="profil-name"><?php echo $user['username']; ?></p>
            <?php 
                require_once "user_info.php";
            ?>
        </div>
    </div>
</div>

<div class="post-container">
    <?php
        $req = "SELECT * FROM users WHERE id = $id";
        $voir_u = mysqli_query($dbh, $req);

        $queryResults = mysqli_num_rows($voir_u);

        if (isset($_GET['page']) && $_GET['page'] === "questions"):
        
            if ($queryResults > 0) {
                $sql = "SELECT * FROM posts WHERE p_uid = $id";
                $result = mysqli_query($dbh, $sql);

                $queryResults = mysqli_num_rows($result);

                if ($queryResults > 0) {
                    while ($lignes = mysqli_fetch_assoc($result)) {
                        if (strlen($lignes['p_content']) > 150) {
                            $extrait = substr($lignes['p_content'], 0, 150)."...";
                        } else {
                            $extrait = $lignes['p_content'];
                        }

                        echo "<div class='post-box'><a href='../posts/post.php?id=".$lignes['p_id']."'>
                            <h1>".$lignes['p_title']."</h1></a>
                            <p>".$lignes['p_author']." &#10072; ". convert_date($lignes['p_date'])." &#10072; Tag(s) : ".$lignes['p_tags']."</p>
                            <p class='post-content'>".$extrait."</p>
                        </div>";
                    }
                } else {
                    echo "<div class='post-box'>Cet utilisateur n'a pas encore posé de question.</div>";
                }
            } else {
                header('Location: ../accueil/accueil.php');
            } 
        endif;
    ?>

	<?php
        if (isset($_GET['page']) && $_GET['page'] === "reponses"):
            $req = "SELECT * FROM answers WHERE a_uid = '$id'";
            $result = mysqli_query($dbh, $req);
            
            $queryResults = mysqli_num_rows($result);

            if ($queryResults > 0) {
                while ($lignes = mysqli_fetch_assoc($result)) {
                    if (strlen($lignes['a_content']) > 110) {
                        $extrait = substr($lignes['a_content'], 0, 110) . "...";
                    } else {
                        $extrait = $lignes['a_content'];
                    }
                    echo "<div class='answer' id='" . $lignes['a_id'] . "'>
                            <div class='answer_content'>
                                <a href='../posts/post.php?id=" . $lignes['post_id'] . "#" . $lignes['a_id'] . "'><h3>" . $extrait . "</h3></a>
                                <p>".$lignes['a_author']."
                                &#10072; ". convert_date($lignes['a_date'])."</p>
                            </div>
                        </div>";
                }
            }
            else {
                echo "<div class='post-box'>Cet utilisateur n'a répondu à aucune question.</div>";
            }
        endif;
	?>
</div>


<?php 

    } else {
        header('Location: ../../index.php');
    }

    require_once "../layouts/footer.php"; 
    
?> 