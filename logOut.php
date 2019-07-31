<?php 
// demarrage de la session
session_start();
// Suppression du contenu de la variable session 
$_SESSION = array();
// destruction de la session
session_destroy();
// redirection vers l'index
header('Location: index.php');
 ?>