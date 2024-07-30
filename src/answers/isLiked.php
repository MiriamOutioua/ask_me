<?php
	function isLiked($dbh, $id, $a_id)
    {
        $req = "SELECT * FROM likes WHERE l_uid = '$id' AND answer_id = '$a_id'";
        $result = mysqli_query($dbh, $req);
        $query = mysqli_num_rows($result);
        
        if ($query > 0)
        {
            return "liked";
        }
    }