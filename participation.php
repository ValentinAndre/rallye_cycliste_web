<?php
// Autochargement des classes
function __autoload($class) {
	require_once "php/classes/$class.php";
}

require_once ('php/session.php');

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
<title>Participation</title>
</head>
<body>
		<?php require_once('php/menu.php'); ?>
		<div class="container">
		<div class="row">
			<div class="page-header center-text">
				<h1>Participation</h1>
			</div>
		</div>
		<div class="row">
			<div class="lg-offset-2 col-lg-8 col-lg-offset-2">
				<table class="table table-bordered center-table">
					<tbody>
						<tr><th>Nombre de participants total</th><th><?php echo ObtenirNombreParticipants("");?></th></tr>
						<tr><td>Nombre de féminines</td><td> <?php echo ObtenirNombreParticipants("where sexe='F'");?></td></tr>
						<tr><td>Nombre de -18ans</td><td><?php echo ObtenirNombreParticipants("where TIMESTAMPDIFF(YEAR, dateNaissance, CURDATE()) < 19");?></td></tr>
						<tr><td>Nombre de non licenciés</td><td><?php echo ObtenirNombreParticipants("where federation='NL'")?></td></tr>
						<tr><td>Nombre de licenciés FFC</td><td><?php echo ObtenirNombreParticipants("where federation='FFC'")?></td></tr>
						<tr><td>Nombre de licenciés FFCT</td><td><?php echo ObtenirNombreParticipants("where federation='FFCT'")?></td></tr>
						<tr><td>Nombre de licenciés UFOLEP</td><td><?php echo ObtenirNombreParticipants("where federation='UFOLEP'")?></td></tr>
						<tr><td>Nombre de licenciés FSGT</td><td><?php echo ObtenirNombreParticipants("where federation='FSGT'")?></td></tr>
						<tr><td>Nombre de licenciés FFTri</td><td><?php echo ObtenirNombreParticipants("where federation='FFTri'")?></td></tr>
					</tbody>
				</table>
				</div>
				</div>
				<div class="row">
				<div class="col-lg-4 col-lg-offset-2">
				<table class="table table-bordered center-table">
					<tbody>
						<tr><th>Nombre de VTTistes</th><th><?php echo ObtenirNombreParticipants("join PARCOURS on parcours=idParcours where type='VTT'")?></th></tr>
						<tr><td>Nombre de VTTistes non licenciés</td><td><?php echo ObtenirNombreParticipants("join PARCOURS on parcours=idParcours where type='VTT' AND federation='NL'")?></td></tr>
						<tr><td>Nombre de VTTistes licenciés CCSTPeray</td><td><?php echo ObtenirNombreParticipants("join PARCOURS on parcours=idParcours where type='VTT' AND clubOuVille='CCSTPeray'")?></td></tr>
						<tr><td>Nombre de VTTistes non licenciés CCSTPeray</td><td><?php echo ObtenirNombreParticipants("join PARCOURS on parcours=idParcours where type='VTT' AND clubOuVille<>'CCSTPeray'")?></td></tr>
						<tr><td>Nombre de VTTistes féminines</td><td><?php echo ObtenirNombreParticipants("join PARCOURS on parcours=idParcours where type='VTT' and sexe='F'");?></td></tr>
						<tr><td colspan="2"></td></tr>
						<tr><td colspan="2"><b>Par parcours VTT</b></td></tr>
						<?php afficherStatsParcours("VTT");?>
					</tbody>
				</table>
				</div>
				<div class="col-lg-4">
				<table class="table table-bordered center-table">
					<tbody>
						<tr><th>Nombre de routards</th><th><?php echo ObtenirNombreParticipants("join PARCOURS on parcours=idParcours where type='Route'")?></th></tr>
						<tr><td>Nombre de routards non licenciés</td><td><?php echo ObtenirNombreParticipants("join PARCOURS on parcours=idParcours where type='ROUTE' AND federation='NL'")?></td></tr>
						<tr><td>Nombre de routards licenciés CCSTPeray</td><td><?php echo ObtenirNombreParticipants("join PARCOURS on parcours=idParcours where type='ROUTE' AND clubOuVille='CCSTPeray'")?></td></tr>	
						<tr><td>Nombre de routards non licenciés CCSTPeray</td><td><?php echo ObtenirNombreParticipants("join PARCOURS on parcours=idParcours where type='ROUTE' AND clubOuVille<>'CCSTPeray'")?></td></tr>
						<tr><td>Nombre de routards féminines</td><td><?php echo ObtenirNombreParticipants("join PARCOURS on parcours=idParcours where type='ROUTE' and sexe='F'");?></td></tr>
						<tr><td colspan="2"></td></tr>	
						<tr><td colspan="2"><b>Par parcours Route</b></td></tr>
						<?php afficherStatsParcours("ROUTE");?>
					</tbody>
				</table>
			</div>
		</div>
	</div>
</body>
</html>