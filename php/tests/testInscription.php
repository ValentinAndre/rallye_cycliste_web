<?php
// Autochargement des classes
function __autoload($class) { require_once "../classes/$class.php"; }

function afficheTout($inscriptions) {
    echo "------- Tous les parcours :\n";
    foreach ($inscriptions->getAll() as $i)
        echo $i, "\n";
    echo "---------------------------\n";
}

$exemple = new Inscription(array('idInscription' => DAO::UNKNOWN_ID, 
    'estArrive' => false, 'nom' => "DUROT", 'prenom' => "Marvin", 'sexe' => "H",
	 'dateNaissance' => "1994-01-19", 'federation' => "NL", 'clubOuVille' => "ZSTPERAY", 
	  'departement' => 7, 'idParcours' => 1, 'idUtilisateur' => 2));
echo $exemple, "\n";

$inscriptions = new InscriptionsDAO(MaBD::getInstance());
echo $inscriptions->getOne(1), "\n";
echo $inscriptions->getOne(2), "\n";

afficheTout($inscriptions);

echo "Enregistrement de ";
$inscriptions->insert($exemple);
echo $exemple->nom, "\n";

echo "------- Tous les parcours tries par nom :\n";
foreach ($inscriptions->getAll("ORDER BY nom") as $i)
    echo $i, "\n";
echo "---------------------------\n";

echo "Modification de $exemple->nom\n";
$exemple->departement = 26;
$inscriptions->update($exemple);
echo "\t==> $exemple\n";

echo "------- Tous les parcours tries par sexe :\n";
foreach ($inscriptions->getAll("ORDER BY sexe") as $i)
    echo $i, "\n";
echo "---------------------------\n";

afficheTout($inscriptions);

echo "Effacement de $exemple->nom\n";
$inscriptions->delete($exemple);

afficheTout($inscriptions);

echo "Les 5 derniers enregistrements de benevole1:\n";
echo "---------------------------\n";
$last = $inscriptions->getLastTen('benevole1');
foreach($last as $i)
	echo $i, "\n";
?>
