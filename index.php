<!-- demarrer une session -->
<?php session_start(); ?>
<!DOCTYPE html>
<html lang="fr">
<head>
	<meta charset="UTF-8">
	<title>Mon site en PHP !</title>
	<link rel="stylesheet" href="style.css">
</head>
<body>

	<?php 
	// Message de bienvenue si l'id est présent dans la session
	if (isset($_SESSION['id']) && $_SESSION['id'] != null) {

		echo '<nav>
			<a href="index.php">Accueil</a>
			<a href="index.php?p=profil">Profil</a>
		</nav>';

		echo 'Bienvenue '.$_SESSION['firstName'].' '.$_SESSION['lastName'].' !';
		// bouton pour deconnecter la session
		echo ' <a href="logOut.php"><button>Déconnecter</button></a>';
	
		if (isset($_GET['p'])) {
			switch ($_GET['p']) {
				case 'profil':
					require('profil.php');
					break;
				
				default:
					require('index.php');
					break;
			}
		}

	} else {
		require('connexion.php');
		require('inscription.php');
	}
		?>
	<script src="script.js"></script>
</body>
</html>