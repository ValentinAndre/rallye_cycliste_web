<?php
// Autochargement des classes
function __autoload($class) { require_once "../classes/$class.php"; }

function afficheTout($utilisateurs) {
	echo "------- Tous les utilisateurs :\n";
	foreach ($utilisateurs->getAll() as $u)
		echo $u, "\n";
	echo "---------------------------\n";
}

$exemple = new Utilisateur(array('login' => "durotm", 'mdp' => "azerty"));
echo $exemple, "\n";
$utilisateurs = new UtilisateursDAO(MaBD::getInstance());
echo $utilisateurs->getOne(1), "\n";
echo $utilisateurs->getOne(2), "\n";

afficheTout($utilisateurs);

echo "Enregistrement de ";
$utilisateurs->insert($exemple);
echo $exemple->login, "\n";

echo "------- Tous les utilisateurs tries par login :\n";
foreach ($utilisateurs->getAll("ORDER BY login") as $u)
	echo $u, "\n";
echo "---------------------------\n";

echo "Modification de $exemple->login\n";
$exemple->login = "peterpan";
$utilisateurs->update($exemple);
echo "\t==> $exemple\n";

afficheTout($utilisateurs);

echo "Effacement de $exemple->login\n";
$utilisateurs->delete($exemple);

afficheTout($utilisateurs);
?>
