<?php
require_once ('php/session.php');
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
			<div class="col-lg-offset-2 col-lg-8 col-lg-offset-2">
				<table class="table table-bordered center-table">
					<thead>
						<tr>	
							<th colspan="2">Récompenses</th>
							<th>Nombre</th>					
						</tr>
					</thead>
					<tbody>
						<tr>
							<td>Les plus nombreux</td>
							<td></td>
							<td></td>
						</tr>
						<tr>
							<td>Les plus nombreux d'Ardèche</td>
							<td></td>
							<td></td>
						</tr>
						<tr>
							<td>Les plus nombreux de Drôme</td>
							<td></td>
							<td></td>
						</tr>
						<tr>
							<td>Les deuxièmeplus nombreux</td>
							<td></td>
							<td></td>
						</tr>
					</tbody>
				</table>
			</div>
		</div>
	</div>
</body>
</html>