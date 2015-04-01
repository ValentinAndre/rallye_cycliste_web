<?php
function __autoload($class) { require_once "php/classes/$class.php"; };
require_once ('php/session.php');

// On vérifie qu'il s'agit bien de l'admin
if ($_SESSION ['login'] !== 'admin') {
	header ( "Location: login.php" );
	exit ( 0 );
}

// Initialisation des erreurs
$_POST['erreur'] = false;

$parcours = new ParcoursDAO(MaBD::getInstance());
$inscriptions = new InscriptionsDAO(MaBD::getInstance());
$new = new Parcours(array('idParcours' => DAO::UNKNOWN_ID,
									'type' => "",
									'distance' => ""));

function afficherFormulaire() {
	global $parcours, $new;			
	
	foreach ($parcours->getAll("ORDER BY type, distance") as $p)
		$p->toForm();
	
	$new->toForm();
}

// Affiche un message d'erreur ou d'information
function afficherMessage() {
	if (isset($_POST['message']) && isset($_POST['erreur'])) {
		if ($_POST['erreur'])
			echo '<div id="erreur" class="alert alert-danger center-text" role="alert">',
				  $_POST['message'], '</div>';
		else
			echo '<div id="info" class="alert alert-info center-text" role="alert">',
				  $_POST['message'], '</div>';
	}
}

// Ajout d'un parcours
if (isset($_POST['add'])) {	
	$p = new Parcours(array('idParcours' => $_POST['id'],
									'type' => $_POST['type'], 
									'distance' => $_POST['distance']));
	$parcours->insert($p);
	$_POST['message'] = "Le parcours a bien été ajouté !";
}


// Suppression d'un parcours
if (isset($_POST['supp'])) {
	if (!$inscriptions->checkRef($_POST['id'])) {
		$p = $parcours->getOne($_POST['id']);
		$parcours->delete($p);
		$_POST['message'] = "Le parcours a bien été supprimé !";
	} else {
		$_POST['erreur'] = true;
		$_POST['message'] = "Impossible de supprimer le parcours,
							 il fait référence à une ou plusieurs inscriptions !";
	}
}

// Modification d'un parcours
if (isset($_POST['modif'])) {
	if (!$inscriptions->checkRef($_POST['id'])) {
		$p = new Parcours(array('idParcours' => $_POST['id'],
				'type' => $_POST['type'],
				'distance' => $_POST['distance']));
		$parcours->update($p);
		$_POST['message'] = "Le parcours a bien été mis à jour";
	} else {
		$_POST['erreur'] = true;
		$_POST['message'] = "Impossible de modifier le parcours,
							 il fait référence à une ou plusieurs inscriptions !";
	}	
}
?>

<!DOCTYPE html>
<html>
<head>
		<?php require_once('php/head.php'); ?>		
<title>Parcours</title>
</head>
<body>
		<?php require_once('php/menu.php'); ?>
		<div class="container">
			<div class="row">
				<div class="page-header center-text">
					<h1>Gestion des parcours</h1>
				</div>
			</div>
			<div class="row">
				<div class="col-lg-offset-4 col-lg-4 col-lg-offset-4">
					<?php afficherFormulaire();?>
					<div class="vertical-offset-20">
						<?php afficherMessage();?>
					</div>				
				</div>				
			</div>
	</div>
</body>
</html>
