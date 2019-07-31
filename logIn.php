<?php
	// Appel à la connection de la base de donnée
	require_once('bdd.php');

	// récupération des inputs du formulaire de login
 	$login = $_POST['login'];
 	$pass = $_POST['pass'];

 	// vérification que l'email et le mot de passe correspondent à un utilisateur dans la bdd
 	$request = $bdd->prepare('SELECT * FROM user WHERE email = ? AND pass = ? AND archive = 0');
 	$request->execute(array($login,sha1($pass)));
 	$donnee = $request->fetchAll();

 	if (sizeOf($donnee) > 0) {
	 	// demarrage de la session
	 	session_start();
	 	
	 	// Stockage dans la session des infos de l'utilisateur
	 	$_SESSION['id'] = $donnee[0]['id'];
	 	$_SESSION['lastName'] = $donnee[0]['lastname'];
	 	$_SESSION['firstName'] = $donnee[0]['firstname'];
	 	
	 	// redirection vers l'index
	 	header('Location: index.php');
 	} else {
 		header('Location: index.php?log=7');
 	}
 ?>