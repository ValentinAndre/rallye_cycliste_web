<?php
require_once ('php/session.php');

// On vérifie qu'il s'agit bien de l'admin
if ($_SESSION ['login'] !== 'admin') {
	header ( "Location: login.php" );
	exit ( 0 );
}
?>

<!DOCTYPE html>
<html>
<head>
		<?php require_once('php/head.php'); ?>
		<script src="js/parcours.js"></script>
<title>Gestion des parcours</title>
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
			<div class="col-lg-offset-2 col-lg-8 col-lg-offset-2">
				<table class="table table-striped">
					<thead>
						<tr>
							<th><span class="glyphicon glyphicon-asterisk">&nbsp;</span>Identifiant</th>
							<th><span class="glyphicon glyphicon-resize-vertical">&nbsp;</span>Distance</th>
							<th><span class="glyphicon glyphicon-tags">&nbsp;</span>Type</th>
						</tr>
					</thead>
					<tbody>
					</tbody>
					<tfoot>
						<td></td>
						<td></td>
						<td></td>
					</tfoot>
				</table>
			</div>
		</div>
	</div>
</body>
</html>
