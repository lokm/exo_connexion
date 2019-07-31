<?php 
	if(!isset($_SESSION)) 
    { 
        session_start();

    } 
	require_once('bdd.php');

	

	// READ
	// prepare une requete qui selectionne le firstname, lastname et email de la table user si l'id correspond à l'id de l'utilisateur en session.
	$request = $bdd->prepare('SELECT firstname, lastname, email FROM user WHERE id = ? AND archive = 0');
 	// execute la requete
 	$request->execute(array($_SESSION['id']));
 	// affecte à la variable donnee le tableau de resultats de la requete ordonnée par le fetchall 
 	$donnee = $request->fetchAll();
 	

 	$request = $bdd->prepare('SELECT * FROM infouser WHERE fk_user = ? AND archive = 0');
 	$request->execute(array($_SESSION['id']));
 	$donnee2 = $request->fetchAll(); 
 	
 	// VUE INDEX PROFIL
 	echo '<main>';
 	echo '<section id="userView">';

 	echo '<label>Nom : <span>'.$donnee[0]['lastname'].'</span></label>';
 	echo '<label>Prenom : <span>'.$donnee[0]['firstname'].'</span></label>';
 	echo '<label>Email : <span>'.$donnee[0]['email'].'</span></label>';
 	/*
	IF TERNAIRE :
	(condition) ? alors : sinon;
 	*/
 	echo '<label>Sexe : <span>'.((sizeof($donnee2) > 0) ? (($donnee2[0]['sexe'] == 0) ? 'Homme' : 'Femme') : "");
 	echo '</span></label>';

 	if (sizeof($donnee2) > 0) {
	 	// création d'une date & heure à partir de la date d'anniversaire dans l'infouser
	 	$birthday = new DateTime($donnee2[0]['birthday']);
  	}
  	// $birthday->format('d/m/Y') => affichage de la date au format jj/mm/AAAA
 	echo '<label>Date de naissance : <span>'.((sizeof($donnee2) > 0) ? $birthday->format('d/m/Y') : "");
 	echo '</span></label>';
 	
 	echo '<label>Adresse : <span>'.((sizeof($donnee2) > 0) ? $donnee2[0]['adress'] : "");
 	echo '</span></label>';
 	echo '<label>Téléphone : <span>'.((sizeof($donnee2) > 0) ? $donnee2[0]['tel'] : "");
 	echo '</span></label>';
 	echo '<button>Modifier</button>';
 	echo '</section>';


 ?>
 	<section id="userUpdate">
 		
	<form action="dataUser.php" method="POST">
		<div class="info" id="infoNom"></div>
		<input type="text" name="lastName" placeholder="Entrez votre nom" value="<?php echo $donnee[0]['lastname'] ?>">
		<div class="info" id="infoPrenom"></div>
		<input type="text" name="firstName" placeholder="Entrez votre prenom" value="<?php echo $donnee[0]['firstname'] ?>">
		<div class="info" id="infoSexe"></div>

		<span><input type="radio" name="sexe" id="h"  value="0" <?php echo (sizeof($donnee2) > 0) ? (($donnee2[0]['sexe'] == 0) ? 'checked' : '') : ''; ?>> <label for="h">Homme</label></span>
		<span><input type="radio" name="sexe"  id="f" value="1" <?php echo (sizeof($donnee2) > 0) ? (($donnee2[0]['sexe'] == 1) ? 'checked' : '') : ''; ?>> <label for="f">Femme</label></span>
		<div class="info" id="infoBirth"></div>
		<input type="date" name="birthday" placeholder="Entrez votre date de naissance" value="<?php echo (sizeof($donnee2) > 0) ? $donnee2[0]['birthday'] : ''; ?>">
		<div class="info" id="infoAdress"></div>
		<input type="text" name="adress" placeholder="Entrez votre adresse" value="<?php echo (sizeof($donnee2) > 0) ? $donnee2[0]['adress'] : ''; ?>">
		<div class="info" id="infoTel"></div>
		<input type="text" name="tel" placeholder="Entrez votre téléphone" value="<?php echo (sizeof($donnee2) > 0) ? $donnee2[0]['tel']: ''; ?>">
		<div class="info" id="infoEmail"></div>
		<input type="email" name="email" placeholder="Entrez votre email" value="<?php echo $donnee[0]['email'] ?>">
		<div class="info" id="infoPass1"></div>
		<input type="password" name="pass1" placeholder="Nouveau mot de passe">
		<div class="info" id="infoPass2"></div>
		<input type="password" name="pass2" placeholder="Confirmez le nouveau mot de passe">
		<input type="submit" value="Modifier">
	</form>
	<button>Supprimer compte</button>
	</section>

<?php echo '</main>';  ?>

