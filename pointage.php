<?php
require_once ('php/session.php');
?>

<!DOCTYPE html>
<html>
<head>
		<?php require_once('php/head.php'); ?>
		<script src="js/pointage.js"></script>
<title>Pointage</title>
</head>
<body>
		<?php require_once('php/menu.php'); ?>
		<div class="container">
		<div class="row">
			<div class="page-header center-text">
				<h1>Pointage des cyclistes</h1>
			</div>
		</div>
		<div class="row">
			<div class="col-lg-offset-2 col-lg-8 col-lg-offset-2">
				<table class="table table-striped">
					<thead>
						<tr>
							<th>Nom</th>
							<th>Prénom</th>
							<th>Sexe</th>
							<th>Date de naissance</th>
						</tr>
					</thead>
					<tbody>
					</tbody>
					<tfoot>
						<tr>
							<td></td>
							<td></td>
							<td></td>
							<td></td>
						</tr>
					</tfoot>
				</table>
			</div>
		</div>
	</div>
</body>
</html>