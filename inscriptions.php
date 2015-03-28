<?php
// Autochargement des classes
function __autoload($class) {
	require_once "php/classes/$class.php";
}

require_once ('php/session.php');
?>

<!DOCTYPE html>
<html>
<head>
		<?php require_once('php/head.php'); ?>
		<script src="js/inscriptions.js"></script>
<title>Inscriptions</title>
</head>
<body>
	<?php require_once('php/menu.php'); ?>
	<div class="container">
		<div class="row">
			<div class="page-header center-text">
				<h1>Gestion des inscriptions</h1>
			</div>
		</div>
		<div class="row">
			<div class="col-lg-12">
				<table class="table table-striped">
					<thead>
						<tr>
							<th>Nom</th>
							<th>Prénom</th>
							<th>Sexe</th>
							<th>Date de naissance</th>
							<th>Fédération</th>
							<th>Club ou Ville</th>
							<th>Département</th>
							<th>Parcours</th>
						</tr>
					</thead>
					<tbody class="no-border">
					</tbody>
					<tfoot>
						<tr>
							<td></td>
							<td></td>
							<td></td>
							<td></td>
							<td></td>
							<td></td>
							<td></td>
							<td></td>
							<td>
								<button class="icon-button">
									<span class="glyphicon glyphicon-repeat"></span>
								</button>
								<button class="icon-button">
									<span class="glyphicon glyphicon-remove"></span>
								</button>
							</td>
						</tr>
					</tfoot>
				</table>
			</div>
		</div>

		<div class="row">
			<div class="col-lg-12">
				<form>
					<div class="panel panel-info">
						<div class="panel-heading">
							<h3 class="panel-title">
								<span class="glyphicon glyphicon-ok">&nbsp;</span> Inscrire un
								cycliste
							</h3>
						</div>
						<div class="panel-body">
							<div class="form-group">
								<div class="col-lg-2">
									<label>Nom</label> <input class="form-control input-sm"
										id="nom" name="nom" type="text" placeholder="Nom..." autofocus>
								</div>
								<div class="col-lg-2">
									<label>Prénom</label> <input class="form-control input-sm"
										id="prenom" name="prenom" type="text" placeholder="Prénom...">
								</div>
								<div class="col-lg-1">
									<label>Sexe</label> <select id="sexe">
										<option value="H">H</option>
										<option value="F">F</option>
									</select>
								</div>
								<div class="col-lg-2">
									<label>Date de naissance</label> <input
										class="form-control input-sm" id="date" name="date"
										type="date" placeholder="AAAA-MM-JJ">
								</div>

								<div class="col-lg-1">
									<label>Fédé.</label><select id="federation"></select>
								</div>
								<div class="col-lg-2">
									<label>Ville ou Club</label> <input
										class="form-control input-sm" id="clubOuVille"
										name="clubOuVille" type="text" placeholder="Ville ou Club...">
								</div>
								<div class="col-lg-1">
									<label>Dép.</label> <input class="form-control input-sm"
										id="departement" name="departement" type="text"
										placeholder="Ex: 07">
								</div>
								<div class="col-lg-1">
									<label>Parcours</label> <select id="parcours"></select>
								</div>

								<input type="text" value="<?php echo $_SESSION['login']; ?>"
									name="inscriveur" id="inscriveur" class="hide">

							</div>
						</div>

						<div class="panel-footer clearfix">
							<div class="pull-right">
								<button type="submit" class="btn btn-primary" id="valider">Valider</button>
							</div>
						</div>
					</div>
				</form>
			</div>
		</div>

		<div class="row">
			<div class="col-lg-12">
				<div id="erreur" class="alert alert-danger center-text" role="alert"></div>
				<div id="info" class="alert alert-info center-text" role="alert"></div>
			</div>
		</div>
	</div>
	</div>
</body>
</html>
