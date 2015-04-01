<?php
require_once ('php/session.php');

// Autochargement des classes
function __autoload($class) {
	require_once "php/classes/$class.php";
}

$stats = new Statistiques(MaBD::getInstance());

/*
 * Affiche le club avec le plus grand effectif
 * @param : un complément de requête SQL
 */
function afficherMax($complementRequete = "") {
	global $stats;
	$res = $stats->getClubMax($complementRequete);
	echo "<td>", $res['clubOuVille'], "</td><td>", $res['effectif'], "</td>";
}

/*
 * Affiche les plus jeunes participants
 * @params : un type de parcours, un sexe
 */
function afficherLesPlusJeunes($type, $sexe) {
	global $stats;
	$personnes = $stats->getYounger($type, $sexe);
	echo '<td colspan="2">';
	foreach ($personnes as $key => $value)
		echo '<p>', $personnes['nom'], " ", $personnes['prenom'], " −−> ", $personnes['age'], " ans</p>";
	echo "</td>";
}
?>

<!DOCTYPE html>
<html>
<head>
		<?php require_once('php/head.php'); ?>
<title>Primes</title>
</head>
<body>
		<?php require_once('php/menu.php'); ?>
		<div class="container">
		<div class="row">
			<div class="page-header center-text">
				<h1>Primes</h1>
			</div>
		</div>
		<div class="row">
			<div class="col-lg-offset-1 col-lg-5">
				<table class="table table-condensed">
					<caption class="font-2">ROUTE</caption>
					<thead>
						<tr>	
							<th>Récompenses</th>
							<th>Nom</th>
							<th>Nombre</th>					
						</tr>
					</thead>
					<tbody>
						<tr>
							<td>Les plus nombreux</td>
							<?php afficherMax("AND type='ROUTE'"); ?>
						</tr>
						<tr>
							<td>Les plus nombreux d'Ardèche</td>
							<?php afficherMax("AND type='ROUTE' AND departement=7"); ?>
						</tr>
						<tr>
							<td>Les plus nombreux de Drôme</td>
							<?php afficherMax("AND type='ROUTE' AND departement=26"); ?>
						</tr>
						<tr>
							<td>Le plus de féminines</td>
							<?php afficherMax("AND type='ROUTE' AND sexe='F'"); ?>
						</tr>
						<tr>
							<td>Les plus jeunes (F)</td>
							<?php afficherLesPlusJeunes("ROUTE", "F"); ?>
						</tr>
						<tr>
							<td>Les plus jeunes (H)</td>
							<?php afficherLesPlusJeunes("ROUTE", "H"); ?>
						</tr>
					</tbody>
				</table>
				</div>
				<div class="col-lg-5">
				<table class="table table-condensed">
					<caption class="font-2">VTT</caption>
					<thead>
						<tr>	
							<th>Récompenses</th>
							<th>Nom</th>
							<th>Nombre</th>					
						</tr>
					</thead>
					<tbody>
						<tr>
							<td>Les plus nombreux</td>
							<?php afficherMax("AND type='VTT'"); ?>
						</tr>
						<tr>
							<td>Les plus nombreux d'Ardèche</td>
							<?php afficherMax("AND type='VTT' AND departement=07"); ?>
						</tr>
						<tr>
							<td>Les plus nombreux de Drôme</td>
							<?php afficherMax("AND type='VTT' AND departement=26"); ?>
						</tr>
						<tr>
							<td>Le plus de féminines</td>
							<?php afficherMax("AND type='VTT' AND sexe='F'"); ?>
						</tr>
						<tr>
							<td>Les plus jeunes (F)</td>
							<?php afficherLesPlusJeunes("VTT", "F"); ?>
						</tr>
						<tr>
							<td>Les plus jeunes (H)</td>
							<?php afficherLesPlusJeunes("VTT", "H"); ?>
						</tr>
					</tbody>
				</table>
			</div>
		</div>
	</div>
</body>
</html>