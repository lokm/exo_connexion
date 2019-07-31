<?php 
	// Appel à la connection de la base de donnée
	require_once('bdd.php');
	
	$log = "";
	$isGood = 0;
	// récupération des inputs du formulaire d'inscription 
	$lastName = $_POST['lastName'];
	$firstName = $_POST['firstName'];
	$email = $_POST['email'];
	$pass1 = $_POST['pass1'];
	$pass2 = $_POST['pass2'];

	//Vérification 
	if (!preg_match("/^[A-Za-zÀ-ÖØ-öø-ÿ]+$/", $lastName)) {
		$isGood++;
		$log .= "1";
	} 
	if (!preg_match("/^[A-Za-zÀ-ÖØ-öø-ÿ]+$/", $firstName)) {
		$isGood++;
		$log .= "_2";
	} 
	if (!preg_match("/^[a-z0-9._-]+@[a-z0-9._-]+\.[a-z]{2,6}$/", $email)) {
		$isGood++;
		$log .= "_3";
	} 
	if (!preg_match('/^(?=.{6,})(?=.*[A-Z])(?=.*[a-z])(?=.*[0-9])(?=.*[&?:\/=+§^¤£@\#*!()"$]).*$/',$pass1)) {
		$isGood++;
		$log .= "_4";
	} elseif ($pass1 != $pass2) {
		$isGood++;
		$log .= "_5";
	} else {
		$goodPass = sha1($pass1);
	}

	// Vérification si l'email d'inscription est déjà présente dans la base de donnée
	$request = $bdd->prepare('SELECT email FROM user WHERE email = ? AND archive = 0');
	$request->execute(array($email));
	$isEmail = $request->fetchAll();

	if (sizeof($isEmail) > 0) {
			$log .= "_6";
	}

	// Si le mot de passe est bon et que l'email n'est pas présent dans la bdd, j'ajoute l'utilisateur à la bdd
	if ($isGood == 0 && sizeof($isEmail) == 0) {
		$request = $bdd->prepare('INSERT INTO user (firstname, lastname, email, pass) VALUES (?,?,?,?)');
		$request->execute(array($firstName, $lastName, $email, $goodPass));
		$userId = $bdd->lastInsertId();
	} 

	// redirection vers l'index avec le log en GET
	header("Location: index.php?log=".$log);

	if (strlen($log) > 0) {
		header("Location: index.php?log=".$log);
	} else {
		session_start();
		$_SESSION['id'] = $userId;
	 	$_SESSION['lastName'] = $lastName;
	 	$_SESSION['firstName'] = $firstName;
		header("Location: index.php");
	}
 ?>