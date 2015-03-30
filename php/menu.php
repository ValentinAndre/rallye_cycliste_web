<?php
// On cache le menu de configuration si l'utilisateur n'est pas l'admin
function hideMenu() {
	if ($_SESSION ['login'] !== 'admin')
		echo 'hide';
}
?>

<!-- Menu principal -->
<nav class="navbar navbar-default navbar-fixed-top">
	<div class="container">
		<div class="navbar-header">
			<button type="button" class="navbar-toggle collapsed"
				data-toggle="collapse" data-target="#navbar" aria-expanded="false"
				aria-controls="navbar">
				<span class="icon-bar"></span> <span class="icon-bar"></span> <span
					class="icon-bar"></span>
			</button>
			<a class="navbar-brand" href="index.php">Accueil</a>
		</div>
		<div id="navbar" class="navbar-collapse collapse">
			<ul class="nav navbar-nav">
				<li><a href="inscriptions.php">Inscriptions</a></li>
				<li><a href="pointage.php">Pointage</a></li>
				<li><a href="statistiques.php">Statistiques</a></li>				
			</ul>

			<ul class="nav navbar-nav navbar-right">
				<li><a href="?deco=true"><span class="glyphicon glyphicon-off">&nbsp;</span>Se
						Déconnecter</a></li>
				<li class="dropdown <?php hideMenu() ?>"><a href="#"
					class="dropdown-toggle" data-toggle="dropdown" role="button"
					aria-expanded="false"> <span class="glyphicon glyphicon-cog">&nbsp;</span>
						Configuration <span class="caret"></span></a>
					<ul class="dropdown-menu" role="menu">
						<li><a href="bdd.php">Base de données</a></li>
						<li><a href="utilisateurs.php">Utilisateurs</a></li>
						<li><a href="parcours.php">Parcours</a></li>											
					</ul></li>				
			</ul>
		</div>
	</div>
</nav>