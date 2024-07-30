<?php

	$page = "profil";
	require_once "../layouts/header.php";
    require_once "../posts/fonc_date.php";

	if (isset($_SESSION['id'])) { 
           
        if (empty($_GET['id']) || !isset($_GET['id'])) {
            header('Location: ../accueil/accueil.php');
        }

        if ($_GET['id'] != $_SESSION['id']) {
            header('Location: voir_profil.php?id='.$_GET['id'] . "&page=questions");
        }

        $id = $_GET['id']; 

        $req = "SELECT * FROM users WHERE id = $id";
        $result = mysqli_query($dbh, $req);
        $user = mysqli_fetch_assoc($result);	
?>

<div class="profil-container">

    <div class="info_bar">

        <div class="edit-profil"><a href='edit_profil.php?id=<?php echo $uid ?>'>&Eacute;diter le profil</a></div>
        <div class="edit-pwd"><a href='edit_pwd.php?id=<?php echo $uid ?>'>Modifier le mot de passe</a></div>

        <ul>
            <li class="<?php if (isset($_GET['page']) && $_GET['page'] === "questions") echo "active";?>">
                <a href="profil.php?id=<?php echo $uid ?>&page=questions">Vos questions</a>
            </li>

            <li class="<?php if (isset($_GET['page']) && $_GET['page'] === "reponses") echo "active"?>" id="reponses">
                <a href="profil.php?id=<?php echo $uid ?>&page=reponses">Vos réponses</a>
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
        if (isset($_GET['page']) && $_GET['page'] === "questions"):
        $sql = "SELECT * FROM posts WHERE p_uid = $id";
        $result = mysqli_query($dbh, $sql);

        $queryResults = mysqli_num_rows($result);

        if ($queryResults > 0) {
            while ($lignes = mysqli_fetch_assoc($result)) {
                if (strlen($lignes['p_content']) > 130) {
                    $extrait = substr($lignes['p_content'], 0, 130)."...";
                } else {
                    $extrait = $lignes['p_content'];
                }

                $str = "<div class='post-box'>
                            <h1><a class='author' href='../posts/post.php?id=".$lignes['p_id']."'>".$lignes['p_title']."</a></h1>
                            <div class='edit' title='Modifier la question'><a href='../posts/edit_post.php?id=".$lignes['p_id']."'>&#9998;</a></div>
                            <div class='delete' title='Supprimer la question'><a href='../posts/del_post.php?id=" . $lignes['p_id'] ."' onclick=" . '"' . "return confirm('Voulez-vous vraiment supprimer la question : &#171; " . $lignes['p_title'] . " &#187; ?')" . '"' .  ">&#10005;</a></div>
                            <p>".$lignes['p_author'];

                if ($lignes['p_edit_date'] === '0000-00-00 00:00:00') {
                    $str .= "   &#10072; Posté le : ".convert_date($lignes['p_date'])." &#10072; Tag(s) : ".$lignes['p_tags']."</p>
                            <p class='post-content'>".$extrait."</p> 
                        </div>";
                } else {
                    $str .= "   &#10072; Posté le : ".convert_date($lignes['p_date'])." &#10072; Modifié le : ".convert_date($lignes['p_edit_date'])." &#10072; Tag(s) : ".$lignes['p_tags']."</p>
                            <p class='post-content'>".$extrait."</p> 
                        </div>";
                }
    
                echo $str;
            }
        } else {
            echo "<div class='post-box'>Vous n'avez pas encore posé de question.</div>";
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
                    $str = "<div class='answer' id='" . $lignes['a_id'] . "'>
                        <div class='answer-content-profil'>
                            <a href='../posts/post.php?id=" . $lignes['post_id'] . "#" . $lignes['a_id'] . "'><h3>" . $extrait . "</h3></a>
                            <div class='edit' title='Modifier la réponse'><a href='../answers/edit_answer.php?id=".$lignes['a_id']."'>&#9998;</a></div>
                            <div class='delete' title='Supprimer la réponse'><a href='../answers/del_answer.php?id=" . $lignes['a_id'] . "' onclick=" . '"' . "return confirm('Voulez-vous vraiment supprimer la réponse : &#171; " . $extrait . " &#187; ?')" . '"' . ">&#10005;</a></div>
                            <p>" . $lignes['a_author'];

                    if ($lignes['a_edit_date'] === '0000-00-00 00:00:00') {
                        $str .= " &#10072; Posté le : ".convert_date($lignes['a_date'])."</p></div></div>";
                    } else {
                        $str .= " &#10072; Posté le : ".convert_date($lignes['a_date'])." &#10072; Modifié le : ".convert_date($lignes['a_edit_date'])."</p></div></div>";
                    }
                    echo $str;
            }
		} else {
			echo "<div class='post-box'>Vous n'avez répondu à aucune question.</div>";
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