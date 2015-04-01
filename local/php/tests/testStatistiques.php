<?php
// Autochargement des classes
function __autoload($class) { require_once "../classes/$class.php"; }

$stats = new Statistiques(MaBD::getInstance());
echo $stats->getNumberOfInscriptions();
echo $stats->getYoungest("h");
?>
