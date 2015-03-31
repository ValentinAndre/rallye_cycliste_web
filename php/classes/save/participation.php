<?php
require_once ('php/session.php');
function __autoload($class) {
	require_once "php/classes/$class.php";
}

$stats = new Statistiques ( MaBD::getInstance () );
$p = $stats->getParticipation ();
$pVTT = $stats->getParticipation("VTT");
$pRoute = $stats->getParticipation("ROUTE");
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
			<div class="col-lg-offset-2 col-lg-8 col-lg-offset-2">
				<h3>Global</h3>
				<table class="table table-bordered center-table">
					<?php $p->toTableContent(); ?>			
				</table>
				<h3>VTT</h3>
				<table class="table table-bordered center-table">
					<?php $pVTT->toTableContent(); ?>			
				</table>
				<h3>Route</h3>
				<table class="table table-bordered center-table">
					<?php $pRoute->toTableContent(); ?>			
				</table>
			</div>
		</div>
	</div>
</body>
</html>