<?php
// Autochargement des classes
function __autoload($class) { require_once "../classes/$class.php"; }

function afficheTout($parcours) {
    echo "------- Tous les parcours :\n";
    foreach ($parcours->getAll() as $p)
        echo $p, "\n";
    echo "---------------------------\n";
}

$exemple = new Parcours(array('idParcours' => DAO::UNKNOWN_ID, 
    'distance' => 20, 'type' => "VTT"));
echo $exemple, "\n";
$parcours = new ParcoursDAO(MaBD::getInstance());
echo $parcours->getOne(1), "\n";
echo $parcours->getOne(2), "\n";

afficheTout($parcours);

echo "Enregistrement de ";
$parcours->insert($exemple);
echo $exemple, "\n";

echo "------- Tous les parcours tries par type :\n";
foreach ($parcours->getAll("ORDER BY type") as $p)
    echo $p, "\n";
echo "---------------------------\n";

echo "Modification de $exemple\n";
$exemple->distance = 500;
$parcours->update($exemple);
echo "\t==> $exemple\n";

echo "------- Tous les parcours tries par distance :\n";
foreach ($parcours->getAll("ORDER BY distance ASC") as $p)
    echo $p, "\n";
echo "---------------------------\n";

afficheTout($parcours);

echo "Effacement de $exemple\n";
$parcours->delete($exemple);

afficheTout($parcours);
?>
