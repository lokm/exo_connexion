<?php 
	// Définition de constantes globales 
	define('DB_HOST', 'localhost');
	define('DB_NAME', 'exophp');
	define('DB_USER', 'root');
	define('DB_PASS', '');

	// Stockage de la connection à la base de donnée dans la varible $bdd avec la méthode PDO
	$bdd = new PDO('mysql:host='.DB_HOST.';dbname='.DB_NAME.';charset=utf8',DB_USER, DB_PASS, [
              PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
              PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
              PDO::ATTR_EMULATE_PREPARES => false
            ]);

 ?>