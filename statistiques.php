<?php
require_once('php/session.php');

// Autochargement des classes
function __autoload($class) {
	require_once "classes/$class.php";
}

$stats = new Statistiques(MaBD::getInstance());
$dataSet = $stats->getNumberByParcoursType();
?>

<!DOCTYPE html>
<html>
	<head>
		<?php require_once('php/head.php'); ?>
		<title>Statistiques</title>
	</head>
	<body>
		<?php require_once('php/menu.php'); ?>
		<script>
			var numberByParcoursType = <?php echo json_encode($stats->getNumberByParcoursType()); ?> ;
			var dataSet2 = <?php echo json_encode($dataSet2); ?> ;
		</script>
		<div class="container">    		
			<div class="row">
				<div class="page-header center-text">
  					<h1>Statistiques</h1>
				</div>
			</div>
			<div class="row">
				<div class="col-lg-4">
					<h3 class="text-center">Répartition Route/VTT</h3>
					<canvas id="graph1"></canvas>
				</div>
				<div class="col-lg-8">
					<h3 class="text-center">Répartition générale</h3>
					<?php displayChart($stats->getAll(), 'bar'); ?>
				</div>			
			</div>
		</div>
	</body>
</html>