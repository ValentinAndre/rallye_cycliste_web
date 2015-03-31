<?php
require_once ('php/session.php');
function __autoload($class) {
	require_once "php/classes/$class.php";
}

$stats = new Statistiques ( MaBD::getInstance () );
$clubs = $stats->getClubs ();

function afficher() {
	global $clubs;
	foreach ( $clubs as $c )
		$c->toTableRow ();
}
?>

<!DOCTYPE html>
<html>
<head>
		<?php require_once('php/head.php'); ?>
		<script>
			$(document).ready(function() {
				$('table').tablesorter();
			});
		</script>
<title>Clubs</title>
</head>
<body>
		<?php require_once('php/menu.php'); ?>
		<div class="container">
		<div class="row">
			<div class="page-header center-text">
				<h1>Clubs</h1>
			</div>
		</div>
		<div class="row">
			<div class="col-lg-offset-2 col-lg-8 col-lg-offset-2">
				<table class="table table-bordered center-table">
					<thead>
						<tr class="sort-buttons success">
							<th><span class="glyphicon glyphicon-chevron-down">&nbsp;</span>Club</th>
							<th><span class="glyphicon glyphicon-chevron-down">&nbsp;</span>Département</th>
							<th><span class="glyphicon glyphicon-chevron-down">&nbsp;</span>Effectif</th>
							<th><span class="glyphicon glyphicon-chevron-down">&nbsp;</span>Hommes</th>
							<th><span class="glyphicon glyphicon-chevron-down">&nbsp;</span>Femmes</th>
							<th><span class="glyphicon glyphicon-chevron-down">&nbsp;</span>- 18 ans</th>
						</tr>
					</thead>
					<tbody>
						<?php afficher(); ?>
					</tbody>
				</table>
			</div>
		</div>
	</div>
</body>
</html>