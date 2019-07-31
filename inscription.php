<h1>Inscription</h1>
	<?php 
		$errNom = "";
		$errPrenom = "";
		$errEmail = "";
		$errEmailInBdd = "";
		$errPass = "";
		$errPassSame = "";
		// extrait du GET log les erreurs dans un tableau
		if (isset($_GET['log'])) {
			$tabLog = explode('_',$_GET['log']);
			
			foreach ($tabLog as $key => $error) {
				switch ($error) {
					case '1':
						$errNom = 'Le nom doit contenir uniquement des lettres<br>';
						break;
					case '2':
						$errPrenom = 'Le prénom doit contenir uniquement des lettres<br>';
					break;
					case '3':
						$errEmail = 'l\'email n\'est pas valide<br>';
					break;
					case '4':
						$errPass = 'Le mot de passe doit avoir :
							<ul>
							<li>Au moins une majuscule</li>
							<li>Au moins un chiffre</li>
							<li>Au moins 6 caractères</li>
							<li>Au moins un caractère spécial</li>
							</ul><br>
						';
						break;
					case '5':
						$errPassSame = 'La vérification du mot de passe ne correspond pas<br>';
						break;
					case '6':
						$errEmailInBdd = '- Email déjà inscript<br>';
						break;
					default:
						
						break;
				}
			}
		}
	 ?>
	<!-- formulaire d'inscription -->
	<form action="signIn.php" method="POST">
		<div class="info" id="infoNom">
			<?php echo $errNom; ?>
		</div>
		<input type="text" name="lastName" placeholder="Entrez votre Nom" required="required">
		<div class="info" id="infoPrenom">
			<?php echo $errPrenom; ?>
		</div>
		<input type="text" name="firstName" placeholder="Entrez votre prénom">
		<div class="info" id="infoEmail">
			<?php 
				echo $errEmail;
				echo $errEmailInBdd;
			?>
		</div>
		<input type="email" name="email" placeholder="Entrez  votre email">
		<div class="info" id="infoPass1">
			<?php echo $errPass; ?>
		</div>
		<input type="password" name="pass1" placeholder="Entrez votre mot de passe">
		<div class="info" id="infoPass2">
			<?php echo $errPassSame; ?>
		</div>
		<input type="password" name="pass2" placeholder="Confirmez votre mot de passe">
		<input type="submit" value="S'inscrire">
	</form>