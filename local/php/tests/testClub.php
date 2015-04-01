<?php
// Autochargement des classes
function __autoload($class) { require_once "../classes/$class.php"; }

$stats = new Statistiques(MaBD::getInstance());

echo "Effectif Total : ", $stats->getEffectifTotal(), "\n\n";

$clubs = $stats->getClubs();

foreach ($clubs as $c)
	$c->toTableRow();
?>
