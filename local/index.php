<?php
require_once ('php/session.php');

// Autochargement des classes
function __autoload($class) {
	require_once "php/classes/$class.php";
}

/*
 * on cache l'image et on affiche le tableau des statistiques
 * si l'utilisateur est admin
 */
if ($_SESSION ['login'] === 'admin') {
	$hide[0] = "hide";
	$hide[1] = "";
} else {
	$hide[0] = "";
	$hide[1] = "hide";
}

$stats = new Statistiques(MaBD::getInstance());

/*
 * Affiche les statistiques par parcours
 * @param : un type de parcours
 */
function afficherStatsParcours($type){
	global $stats;
	$effectif = $stats->getEffectifParParcours($type);
	foreach ($effectif as $key => $value)
		echo "<tr><td>", $key, "km</td><td>", $value, "</td></tr>";
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
			<div class="row">
			<div class="col-lg-offset-2 col-lg-8 col-lg-offset-2">
			<table class="table table-condensed font-3">
				<thead>
					<tr class="success">
						<th><span class="glyphicon glyphicon-signal">&nbsp;</span>TOTAL</th>
						<th><?php echo $stats->getEffectif(); ?></th>
					</tr>
				</thead>
			</table>
			</div>
			</div>
			<div class="row">
			<div class="col-lg-offset-2 col-lg-4">
			<table class="table table-condensed font-2">
				<thead>
					<tr class="success"><th colspan="2"><span class="glyphicon glyphicon-chevron-right">&nbsp;</span>
					VTT</th></tr>
				</thead>
				<tbody>
					<?php afficherStatsParcours("VTT");?>
				</tbody>
			</table>
			</div>
			<div class="col-lg-4">
			<table class="table table-condensed font-2">
			<thead>
				<tr class="success"><th colspan="2"><span class="glyphicon glyphicon-chevron-right">&nbsp;</span>
				Route</th></tr>
				</thead>
				<tbody>
					<?php afficherStatsParcours("ROUTE"); ?>
				</tbody>
			</table>
			</div>
			</div>
			</div>
			</div>
		</div>
	</div>
</body>
</html>