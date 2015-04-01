<?php
require_once ('php/session.php');

// Autochargement des classes
function __autoload($class) {
	require_once "php/classes/$class.php";
}

$stats = new Statistiques ( MaBD::getInstance () );
$effectifTotal = $stats->getEffectif ();

/*
 * Affiche le nombre d'inscriptions par parcours avec le pourcentage associé
 * @param : un type de parcours
 */
function afficherStatsParcours($type) {
	global $stats, $effectifTotal;
	$effectif = $stats->getEffectifParParcours ( $type );
	foreach ( $effectif as $key => $value ) {
		$pourcentage = round ( ($value / $effectifTotal) * 100, 0 );
		echo "<tr><td>", $key, "km</td><td>", $value, "</td><td>", $pourcentage, "%</td></tr>";
	}
}

/*
 * Affiche le nombre d'inscriptions avec le pourcentage associé
 * @param : un complément de requête SQL
 */
function afficherStats($complementRequete) {
	global $stats, $effectifTotal;
	$effectif = $stats->getEffectif ( $complementRequete );
	$pourcentage = round ( ($effectif / $effectifTotal) * 100, 0 );
	echo "<td>", $effectif, "</td><td>", $pourcentage, "%</td>";
}
?>

<!DOCTYPE html>
<html>
<head>
		<?php require_once('php/head.php'); ?>
<title>Participation</title>
</head>
<body>
	<div class="hidden-print">
		<?php require_once('php/menu.php'); ?>
	</div>
	<div class="container">
		<div class="row hidden-print">
			<div class="page-header center-text">
				<h1>Participation</h1>
			</div>
		</div>

		<div class="row">
			<div class="lg-offset-2 col-lg-8 col-lg-offset-2">
				<table class="table table-bordered center-table">
					<thead>
						<tr class="success">
							<th>TOTAL</th>
							<th colspan="2"><?php echo $effectifTotal;?></th>
						</tr>
					</thead>
					<tbody>
						<tr>
							<td>Non licenciés</td>
							<?php afficherStats("WHERE federation='NL'");?>
						</tr>
						<tr>
							<td>Licenciés FFC</td>
							<?php afficherStats("WHERE federation='FFC'");?>
						</tr>
						<tr>
							<td>Licenciés FFCT</td>
							<?php afficherStats("WHERE federation='FFCT'");?>
						</tr>
						<tr>
							<td>Licenciés UFOLEP</td>
							<?php afficherStats("WHERE federation='UFOLEP'");?>
						</tr>
						<tr>
							<td>Licenciés FSGT</td>
							<?php afficherStats("WHERE federation='FSGT'");?>
						</tr>
						<tr>
							<td>Licenciés FFTri</td>
							<?php afficherStats("WHERE federation='FFTri'");?>
						</tr>
						<tr>
							<td>Féminines</td>
							<?php afficherStats("WHERE sexe='F'");?>							
						</tr>
						<tr>
							<td>- 18 ans</td>
						<?php afficherStats("WHERE TIMESTAMPDIFF(YEAR, dateNaissance, CURDATE()) < 19");?>
						</tr>
					</tbody>
				</table>
			</div>
		</div>
		<div class="row">
			<div class="col-lg-4 col-lg-offset-2">
				<table class="table table-bordered center-table">
					<thead>
						<tr class="success">
							<th>VTT</th>
							<?php afficherStats("JOIN PARCOURS ON parcours=idParcours WHERE type='VTT'")?>
						</tr>
					</thead>
					<tbody>
						<tr>
							<td>Non licenciés</td>
							<?php afficherStats("JOIN PARCOURS ON parcours=idParcours WHERE type='VTT' AND federation='NL'");?>
						</tr>
						<tr>
							<td>Licenciés CCSTPeray</td>
							<?php afficherStats("JOIN PARCOURS ON parcours=idParcours WHERE type='VTT' AND clubOuVille='CCSTPeray'");?>
						</tr>
						<tr>
							<td>Non licenciés CCSTPeray</td>
							<?php afficherStats("JOIN PARCOURS ON parcours=idParcours WHERE type='VTT' AND clubOuVille <> 'CCSTPeray'");?>
						</tr>
						<tr>
							<td>Féminines</td>
							<?php afficherStats("JOIN PARCOURS ON parcours=idParcours WHERE type='VTT' AND sexe='F'");?>
						</tr>
						<tr>
							<td colspan="3"><strong>Par parcours</strong></td>
						</tr>
						<?php afficherStatsParcours("VTT");?>
					</tbody>
				</table>
			</div>
			<div class="col-lg-4">
				<table class="table table-bordered center-table">
					<thead>
						<tr class="success">
							<th>ROUTE</th>
							<?php afficherStats("JOIN PARCOURS ON parcours=idParcours WHERE type='Route'")?>
						</tr>
					</thead>
					<tbody>
						<tr>
							<td>Non licenciés</td>
							<?php afficherStats("join PARCOURS ON parcours=idParcours WHERE type='ROUTE' AND federation='NL'");?>
							</tr>
						<tr>
							<td>Licenciés CCSTPeray</td>
							<?php afficherStats("JOIN PARCOURS ON parcours=idParcours WHERE type='ROUTE' AND clubOuVille='CCSTPeray'");?>
						</tr>
						<tr>
							<td>Non licenciés CCSTPeray</td>
							<?php afficherStats("JOIN PARCOURS ON parcours=idParcours WHERE type='ROUTE' AND clubOuVille <> 'CCSTPeray'");?>
						</tr>
						<tr>
							<td>Féminines</td>
							<?php afficherStats("JOIN PARCOURS ON parcours=idParcours WHERE type='ROUTE' AND sexe='F'");?>
						</tr>
						<tr>
							<td colspan="3"><strong>Par parcours</strong></td>
						</tr>
						<?php afficherStatsParcours("ROUTE");?>
					</tbody>
				</table>
			</div>
		</div>
	</div>
</body>
</html>