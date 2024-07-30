<?php 

    $nbAbo = "SELECT f_user_id FROM follow WHERE f_suivre = $id";
    $result = mysqli_query($dbh, $nbAbo);

    $queryResults = mysqli_num_rows($result);
    if ($queryResults == 0) {
        echo "<p class='nbAbo'>Aucun abonné</p>";
    }
    else if ($queryResults == 1) {
        echo "<p class='nbAbo'><a title='Voir les abonnés' href='abonnes.php?id=$id'>".$queryResults." abonné</a></p>";
    } else {
        echo "<p class='nbAbo'><a title='Voir les abonnés' href='abonnes.php?id=$id'>".$queryResults." abonnés</a></p>";
    }

    $nbAbo = "SELECT f_suivre FROM follow WHERE f_user_id = $id";
    $result = mysqli_query($dbh, $nbAbo);

    $queryResults = mysqli_num_rows($result);
    if ($queryResults == 0) {
        echo "<p class='nbAbo'>Aucun abonnement</p>";
    }
    else if ($queryResults == 1) {
        echo "<p class='nbAbo'><a title='Voir les abonnements' href='u_abonnements.php?id=$id'>".$queryResults." abonnement</a></p>";
    } else {
        echo "<p class='nbAbo'><a title='Voir les abonnemants' href='u_abonnements.php?id=$id'>".$queryResults." abonnements</a></p>";
    }