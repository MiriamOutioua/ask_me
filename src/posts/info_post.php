<?php
    require_once "fonc_date.php";

    if (strlen($lignes['p_content']) > 150) {
        $extrait = substr($lignes['p_content'], 0, 150)."...";
    } else {
        $extrait = $lignes['p_content'];
    }

    $str = "<div class='post-box'><a href='../posts/post.php?id=".$lignes['p_id']."'>
                <h3>".$lignes['p_title']."</h3></a>
                <p>";
            
    if ($lignes['p_uid'] == $_SESSION['id']) {    
        $str .= "<a title='Voir le profil' href='../profil/profil.php?id=$uid&page=questions'>".$lignes['p_author']."</a>";
    } else {        
        $str .= "<a title='Voir le profil' href='../profil/voir_profil.php?id=".$lignes['p_uid']."&page=questions'>".$lignes['p_author']."</a>";        
    }   

    if ($lignes['p_edit_date'] === '0000-00-00 00:00:00') {
        $str .= " &#10072; Posté le : ".convert_date($lignes['p_date']);
    } else {
        $str .= "  &#10072; Posté le : " . convert_date($lignes['p_date']) . " &#10072; Modifié le : " . convert_date($lignes['p_edit_date']);
    }

    $str .=     " &#10072; Tag(s) : ".$lignes['p_tags']."</p>
                <p class='post-content'>".$extrait."</p> 
            </div>";

    echo $str;
