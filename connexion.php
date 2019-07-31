<h1>Connexion</h1>
	<!-- formulaire de connexion -->
	<?php 
	if (isset($_GET['log']) && $_GET['log'] == 7) {
		echo '<div class="info">Connexion échouée</div>';
	}
	 ?>
<form action="logIn.php" method="POST">
	<input type="email" name="login" placeholder="Entrez votre email">
	<input type="password" name="pass" placeholder="Entrez votre mot de passe">
	<input type="submit" value="Se connecter">
</form>