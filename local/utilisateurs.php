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
		<script src="js/utilisateurs.js"></script>
<title>Utilisateurs</title>
</head>
<body>
		<?php require_once('php/menu.php'); ?>
		<div class="container">
		<div class="row">
			<div class="page-header center-text">
				<h1>Gestion des utilisateurs</h1>
			</div>
		</div>
		<div class="row">
			<div class="col-lg-offset-1 col-lg-5">
				<table class="table table-striped">
					<thead>
						<tr>
							<th><span class="glyphicon glyphicon-user">&nbsp;</span>Identifiant</th>
							<th><span class="glyphicon glyphicon-eye-open">&nbsp;</span>Mot
								de passe</th>
						</tr>
					</thead>
					<tbody>
					</tbody>
					<tfoot>
						<td></td>
						<td></td>
						<td>
							<button class="icon-button">
								<span class=" glyphicon glyphicon-remove"></span>
							</button>
						</td>
					</tfoot>
				</table>
			</div>

			<div class="col-lg-offset-1 col-lg-4 col-lg-offset-1">
				<div class="panel panel-info">
					<div class="panel-heading">
						<h3 class="panel-title">
							<span class="glyphicon glyphicon-ok">&nbsp;</span> Ajouter un
							utilisateur
						</h3>
					</div>
					<div class="panel-body">
						<div class="form-group">
							<div class="col-lg-6">
								<label>Identifiant</label> <input class="form-control input-sm"
									id="login" name="login" type="text"
									placeholder="Identifiant..." autofocus>
							</div>
							<div class="col-lg-6">
								<label>Mot de passe</label> <input class="form-control input-sm"
									id="password" name="password" type="password">
							</div>
						</div>
					</div>

					<div class="panel-footer clearfix">
						<div class="pull-right">
							<button type="button" class="btn btn-primary" id="valider">Valider</button>
						</div>
					</div>
				</div>
			</div>

		</div>
		<div class="row">
			<div class="col-lg-12">
				<div id="erreur" class="alert alert-danger center-text" role="alert"></div>
				<div id="info" class="alert alert-info center-text" role="alert"></div>
			</div>
		</div>
	</div>
</body>
</html>
