<?php
    
    require_once "../layouts/header.php";

    $suivre_id = $_GET['id'];
    $uid = $_SESSION['id'];

    if ($suivre_id != $_SESSION['id']) {
        $abonne = "SELECT * FROM follow WHERE f_user_id = $uid && f_suivre = $suivre_id";
        $resultat = mysqli_query($dbh, $abonne);
        $abonne = mysqli_num_rows($resultat);

        if ($abonne == 0) {
            $suivre = "INSERT INTO follow (f_user_id, f_suivre) VALUES ($uid, $suivre_id)";
            mysqli_query($dbh, $suivre);
        } else  {
            $desabo = "DELETE FROM follow WHERE f_user_id = $uid && f_suivre = $suivre_id";
            mysqli_query($dbh, $desabo);
        }
    }

    header('Location: voir_profil.php?id='.$_GET['id'] . "&page=questions");