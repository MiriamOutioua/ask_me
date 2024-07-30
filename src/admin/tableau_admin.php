<?php 
	require_once "../layouts/header.php"; 	
?>

<?php
	function tab_questions($dbh)
	{
		if (isset($_GET['page_admin']) && $_GET['page_admin'] == "tab_questions"):
?>

	<h1>Questions</h1>
	<table>

		<?php
            $sql = "SELECT * FROM posts ORDER BY p_id";
            $result = mysqli_query($dbh, $sql);
            
            $queryResults = mysqli_num_rows($result);

			if ($queryResults == 0) {
                echo "<div class='post-box'>Aucune question.</div>";
			}

			if ($queryResults > 0):
		?>
			<thead>
			<tr>
				<th>Titre</th>
				<th>Auteur</th>
				<th>Date d'ajout</th>
				<th>Tag(s)</th>
				<th>Post Id</th>
			</tr>
			</thead>
		<?php
				while ($lignes = mysqli_fetch_assoc($result)): 
		?>

		<tbody>
			<tr>
				<td>
					<a href="../posts/post.php?id=<?php echo $lignes['p_id']; ?>"><h3><?php echo $lignes['p_title']; ?></h3></a>
				</td>

				<td>
					<a title="Voir le profil" href="../profil/voir_profil.php?id=<?php echo $lignes['p_uid']; ?>&page=questions"><?php echo $lignes['p_author']; ?></a>
				</td>

				<td>
					<p>&#10072; <?php echo $lignes['p_date']; ?> &#10072;</p>
				</td>

				<td>
					<p><?php echo $lignes['p_tags']; ?></p>
				</td>

				<td>
					<p class="admin-id"><?php echo $lignes['p_id']; ?></p>
				</td>

				<td>
					<div class="suppr"><a href="supprimer.php?id=<?php echo $lignes['p_id']; ?>" onclick="return confirm('Voulez-vous vraiment supprimer la question : &#171 <?php echo $lignes['p_title']; ?> &#187')">&#10005;</a></div>
				</td>
			</tr>
		</tbody>

		<?php
				endwhile;
			endif;
		?>

	</table>
<?php 
		endif; 
	}
?>

<?php
	function tab_reponses($dbh) {
		if (isset($_GET['page_admin']) && $_GET['page_admin'] == "tab_reponses"): 
?>

	<h1>Réponses</h1>

	<table>

		<?php
			$req = "SELECT * FROM answers ORDER BY a_id";
			$result = mysqli_query($dbh, $req);
			
			$queryResults = mysqli_num_rows($result);

			if ($queryResults == 0) {
				echo "<div class='post-box'>Aucune réponse.</div>";
			}
			
			if ($queryResults > 0):
		?>
			<thead>
				<tr>
					<th>Contenu</th>
					<th>Auteur</th>
					<th>Date d'ajout</th>
					<th>Post relié</th>
					<th>Answer Id</th>
				</tr>
			</thead>
		<?php
				while ($lignes = mysqli_fetch_assoc($result)):
					if (strlen($lignes['a_content']) > 100) {
						$extrait = substr($lignes['a_content'], 0, 100)."...";
					} else {
						$extrait = $lignes['a_content'];
					}
		?>
		
		<tbody>
			<tr>
				<td>
					<a href="../posts/post.php?id=<?php echo $lignes['post_id'] . "#" . $lignes['a_id']; ?>"><?php echo $extrait; ?></a>
				</td>

				<td>
					<a title="Voir le profil" href="../profil/voir_profil.php?id=<?php echo $lignes['a_uid']; ?>&page=questions"><?php echo $lignes['a_author']; ?></a>
				</td>

				<td>
					<p>&#10072; <?php echo $lignes['a_date']; ?> &#10072;</p>
				</td>

				<td>
					<p class="admin-id"><?php echo $lignes['post_id']; ?></p>
				</td>

				<td>
					<p class="admin-id"><?php echo $lignes['a_id']; ?></p>
				</td>

				<td>
					<div class="suppr"><a href="supprimer.php?id2=<?php echo $lignes['a_id']; ?>" onclick="return confirm('Voulez-vous vraiment supprimer cette réponse : <?php echo $extrait; ?> ?')">&#10005;</a></div>
				</td>
			</tr>
		</tbody>

		<?php
				endwhile;
			endif;
		?>

	</table>
<?php 
		endif; 
	} 
?>

<?php 
	function tab_profils($dbh) {
		if (isset($_GET['page_admin']) && $_GET['page_admin'] == "tab_profils"): 
?>
	<h1>Profils</h1>

	<table>
			
		<?php
			$req = "SELECT * FROM users WHERE isAdmin = 0 ORDER BY id";
			$result = mysqli_query($dbh, $req);
			$queryResults = mysqli_num_rows($result);

			if ($queryResults == 0) {
				echo "<div class='post-box'>Aucun profil.</div>";
			}

			if ($queryResults > 0):
		?>
		<thead>
			<tr>
				<th>Username</th>
				<th>Email</th>
				<th>User Id</th>
			</tr>
		</thead>

		<?php
				while ($lignes = mysqli_fetch_assoc($result)):
		?>

		<tbody>
			<tr>
				<td>
					<a title="Voir le profil" href="../profil/voir_profil.php?id=<?php echo $lignes['id']; ?>&page=questions"><?php echo $lignes['username']; ?></a>
				</td>

				<td>
					<p><?php echo $lignes['email']; ?></p>
				</td>

				<td>
					<p class="admin-id"><?php echo $lignes['id']; ?></p>
				</td>

				<td>
					<div class="suppr"><a href="supprimer.php?id_u=<?php echo $lignes['id']; ?>" onclick="return confirm('Voulez-vous vraiment supprimer le profil de <?php echo $lignes['username']; ?>')">&#10005;</a></div>
				</td>
			</tr>
		</tbody>

		<?php
				endwhile;
			endif;
		?>
	</table>
<?php 
		endif; 
	} 
?>


<?php 
	function tab_admins($dbh) {
		if (isset($_GET['page_admin']) && $_GET['page_admin'] == "tab_admins"): 
?>
	<h1>Admins</h1>
	<table>
		<thead>
			<tr>
				<th>Username</th>
				<th>Email</th>
				<th>User Id</th>
			</tr>
		</thead>

		<?php
			$req = "SELECT * FROM users WHERE isAdmin = 1 ORDER BY id";
			$result = mysqli_query($dbh, $req);
			$queryResults = mysqli_num_rows($result);

			if ($queryResults == 0) {
				echo "<div class='post-box'>Aucun admin.</div>";
			}

			if ($queryResults > 0):
				while ($lignes = mysqli_fetch_assoc($result)):

		?>

		<tbody>
			<tr>
				<td>
					<a title="Voir le profil" href="../profil/voir_profil.php?id=<?php echo $lignes['id']; ?>&page=questions"><?php echo $lignes['username']; ?></a>
				</td>

				<td>
					<p><?php echo $lignes['email']; ?></p>
				</td>

				<td>
					<p class="admin-id"><?php echo $lignes['id']; ?></p>
				</td>
				
			</tr>
		</tbody>

		<?php
				endwhile;
			endif;
		?>

	</table>

<?php 
		endif; 
	}
?>