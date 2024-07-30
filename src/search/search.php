<?php

	require_once "../layouts/header.php";

?>

<div class="post-container">
    <?php
        if (isset($_POST['submit-search'])) 
        {
            $search = mysqli_real_escape_string($dbh, $_POST['search']);
            $sql = "SELECT * FROM posts WHERE p_title LIKE '%$search%' OR p_content LIKE '%$search%' OR p_author LIKE '%$search%' OR p_tags LIKE '%$search%' OR p_date LIKE '%$search%' LIMIT 100";
            $result = mysqli_query($dbh, $sql);

            $queryResults = mysqli_num_rows($result);

            if ($queryResults > 0)
            {
                while ($lignes = mysqli_fetch_assoc($result))
                {
                    require "../posts/info_post.php";
                }
            }
            else 
            {
                echo "<div class='post-box'>Aucun résultat disponible pour votre recherche.</div>";
            }
        }
    ?>
</div>

<?php

	require_once "../layouts/footer.php";

?>