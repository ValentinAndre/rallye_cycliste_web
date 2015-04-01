<?php
// Autochargement des classes
function __autoload($class) {
	require_once "../classes/$class.php";
}

$stats = new Statistiques ( MaBD::getInstance () );
$p = $stats->getParticipation ();

var_dump ( $p );
?>


<html>
<head>
<title>Test</title>
</head>
<body>
	<table>
		<?php $p->toTableContent(); ?>
	</table>
</body>
</html>
