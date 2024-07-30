<div class="show">
<input type="checkbox" name="check" id="check" onclick="showPass()">Afficher le mot de passe
	<script>
		function showPass() {
			var temp = document.getElementById('password');
			var temp2 = document.getElementById('confirm');

			if (temp.type === "password") {
				temp.type = "text";
			} else {
				temp.type = "password";
			}

			if (temp2.type === "password") {
				temp2.type = "text";
			} else {
				temp2.type = "password";
			}
		}
	</script>
</div>	