<?php
require_once ('php/session.php');

// Autochargement des classes
function __autoload($class) {
	require_once "php/classes/$class.php";
}

if ($_SESSION ['login'] === 'admin') {
	$hide[0] = "hide";
	$hide[1] = "";
} else {
	$hide[0] = "";
	$hide[1] = "hide";
}

$connector = MaBD::getInstance();
$mesStats = new Statistiques($connector);

function afficherStatsParcours($type){
	global $mesStats;
	$listeStats = $mesStats->getEffectifParParcours($type);
	
	foreach ($listeStats as $key => $value){
		echo "<tr><td>".$key."km</td><td>".$value."</td></tr>";
	}
}

function ObtenirNombreParticipants($complementRequete){
	global $mesStats;
	return $mesStats->getEffectif($complementRequete);
}
?>

<!DOCTYPE html>
<html>
<head>
		<?php require_once('php/head.php'); ?>
		<title>Page Principale</title>
</head>
<body>
		<?php require_once('php/menu.php'); ?>
		<div class="container">
		<div class="row">
			<div class="page-header center-text">
				<h1>Bienvenue !</h1>
				<p>Cet outil a été développé dans le cadre d'un projet d'étude par
					un groupe d'étudiants de l'IUT de Valence.</p>
			</div>
		</div>
		<div class="row">
			<div class="span12">
				<img class="img-responsive center-block <?php echo $hide[0];?>" src="img/cycliste.png"
					alt="cycliste">
			<div class="<?php echo $hide[1];?>">
			<table class="table table-condensed">
				<thead>
					<tr><th>Nombre de participants total inscrit</th><th><?php echo ObtenirNombreParticipants("");?></th></tr>
				</thead>
			</table>
			<table class="table table-condensed">
				<thead>
					<tr><th colspan="2">Nombres d'inscrits sur les parcours VTT</th></tr>
				</thead>
				<tbody>
					<?php afficherStatsParcours("VTT");?>
				</tbody>
					<tr><th colspan="2">Nombres d'inscrits sur les parcours Route</th></tr>
				<tbody>
					<?php afficherStatsParcours("Route");?>
				</tbody>
			</table>
			</div>
			</div>
		</div>
	</div>
</body>
</html>