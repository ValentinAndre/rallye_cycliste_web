<?php
// Autochargement des classes
function __autoload($class) { require_once "php/classes/$class.php"; }

// On démarre la session
session_start();

// Si l'utilisateur est déjà connecté on le redirige
if (isset($_SESSION['login'])) {
	header("Location: index.php");
	exit(0);
}

// Initialisation des erreurs
$_POST['erreur'] = false;

// Récupération des contacts
$utilisateurs = new UtilisateursDAO(MaBD::getInstance());

// Procédure qui affiche les messages d'erreur
function erreur()
{
	if ($_POST['erreur'])
		echo '<div class="alert alert-danger center-text" role="alert">
				<span class="glyphicon glyphicon-exclamation-sign">&nbsp;</span>
				Mot de passe ou login incorrect !</div>';
}

// On a cliqué sur le bouton de connexion
if (isset($_POST['connexion'])) {
	if ($utilisateurs->check($_POST['login'], $_POST['password'])) {
			$_SESSION['login'] = $_POST['login'];
			header("Location: index.php");
			exit(0);
	} else {
			$_POST['erreur'] = true;
	}
}
?>

<!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1" />
		<link href="bootstrap/css/bootstrap.min.css" rel="stylesheet" />
		<link href="css/login.css" rel="stylesheet" />
		<script src="js/jquery.min.js"></script>
		<script src="bootstrap/js/bootstrap.min.js"></script>
		
		<title>Page de connexion</title>
	</head>
	<body>
		<div class="container">
    		<div class="row vertical-offset-100">
    			<div class="col-lg-offset-1 col-lg-4">
    				<div class="panel panel-default">
			  			<div class="panel-heading">
			    			<h3 class="panel-title">Connexion</h3>
			 			</div>
			  			<div class="panel-body">
			    			<form method='post' action='login.php'>
                    			<fieldset>
			    	  				<div class="form-group">
			    		    			<input class="form-control" placeholder="Email ou login" name="login" type="text" required>
			    					</div>
			    					<div class="form-group">
			    						<input class="form-control" placeholder="Password" name="password" type="password" value="" required>
			    					</div>
			    					<input class="btn btn-lg btn-success btn-block" type="submit" name="connexion" value="Se Connecter">
			    				</fieldset>
			      			</form>			    
			    		</div>
			    		<?php  erreur(); ?>
					</div>
				</div>
			</div>
		</div>
	</body>
</html>