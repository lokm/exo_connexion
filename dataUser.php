<?php 
if(!isset($_SESSION)) 
    { 
        session_start();

    } 
require_once('bdd.php');

// CREATE
	// preparation d'une requete qui selectionne dans infouser tout les champ si fk_user est égale à l'id de l'utilisateur et que l'archive soit egale à 0
	$request2 = $bdd->prepare('SELECT * FROM infouser WHERE fk_user = ? AND archive = 0');
 	$request2->execute(array($_SESSION['id']));
 	$donnee2 = $request2->fetchAll(); 
 	
 	// si la requete possède des donnees et qu'il existe un post avec un name sexe alors :
 	if (sizeof($donnee2) == 0 && isset($_POST['sexe'])) {
 		
 		// CREATE (insertion de données) INFOUSER
		$request = $bdd->prepare('INSERT INTO infouser (sexe, birthday, adress, tel, fk_user) VALUES (?,?,?,?,?)');
		$request->execute(array($_POST['sexe'],$_POST['birthday'],$_POST['adress'],$_POST['tel'],$_SESSION['id']));
		//header('Location: profil.php');
 	} elseif (isset($_POST['sexe'])) {
 		
 		// UPDATE (modification de données) INFOUSER
 		$request = $bdd->prepare('UPDATE infouser SET sexe = ?, birthday = ?, adress = ?, tel = ? WHERE fk_user = ?');
		$request->execute(array($_POST['sexe'],$_POST['birthday'],$_POST['adress'],$_POST['tel'],$_SESSION['id']));
		//header('Location: profil.php');
 	}

	// DELETE (ou archivage)
	if (isset($_GET['delete'])) {
		// SUPPRESSION DEFINITIVE
		/*$request = $bdd->prepare('DELETE * FROM user WHERE id = ?');
		$request->execute(array($_SESSION['id']));*/
		
		// ARCHIVAGE
		$request = $bdd->prepare('UPDATE user SET archive = 1 WHERE id = ?');
		$request->execute(array($_SESSION['id']));
		$request = $bdd->prepare('UPDATE infouser SET archive = 1 WHERE fk_user = ?');
		$request->execute(array($_SESSION['id']));
		// deconnexion
		$_SESSION = array();
		session_destroy();
		// redirection
		header('Location: index.php');
	}

	// UPDATE
	if ($_POST != null) {
		$request = $bdd->prepare('UPDATE user SET firstname = ?, lastname = ?, email = ? WHERE id = ?');
		$request->execute(array($_POST['firstName'],$_POST['lastName'],$_POST['email'],$_SESSION['id']));
		// verification de mot de passe :
		if (isset($_POST['pass1']) && isset($_POST['pass2']) && $_POST['pass1'] != "" && $_POST['pass2'] != "") {
			// Variable pour garder en memoire si le mot de passe est valable 
			$isBad = 0;
			$pass1 = $_POST['pass1'];
			$pass2 = $_POST['pass2'];

			// 1°. vérification du regexp
			if (!preg_match('/^(?=.{6,})(?=.*[A-Z])(?=.*[a-z])(?=.*[0-9])(?=.*[&?:\/=+§^¤£@\#*!()"$]).*$/',$pass1)) {
				// incrémentation (ajouter +1) de la variable de validité
				$isBad++;
			// 2°. vérification pass similaire
			} elseif ($pass1 != $pass2) {
				$isBad++;
			} else {
				$goodPass = sha1($pass1);
			}
			// Si le mot de passe est valable, alors j'update le mot de passe
			if ($isBad == 0) {
				$request = $bdd->prepare('UPDATE user SET pass = ? WHERE id = ?');
				$request->execute(array($goodPass,$_SESSION['id']));
				
			}
		}
		header('Location: index.php?p=profil');	
	}
 ?>