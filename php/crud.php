<?php
/*
 * Module générique permettant d'accèder à une base de données par des requêtes AJAX
 *
 * IMPORTANT:
 * - La classe DAO doit implémenter la méthode getColumnNames()
 * - Ce module ne vérifie pas le contenu des champs de l'objet à insérer ou à mettre à jour
 * - Le nom des champs doivent être respectés dans les paramètres POST envoyés
 *
 * Paramètres de la requête AJAX :
 * - action : le nom de la fonction à appeler
 * - class : le nom de la classe de l'objet
 * - dao : le nom de la classe DAO de l'objet
 * - champs de l'objet : valeurs des champs
 *
 * Exemple :
 * crud.php?action=create&class=Parcours&dao=ParcoursDAO&distance=20&type=VTT
 */

// Autochargement des classes
function __autoload($class) {
	require_once "classes/$class.php";
}

// Déclaration des fonctions d'accès à la base de données
$functions = [ 
		'retrieve',
		'retrieveAll',
		'retrieveLastTen', // spécifique à aux Inscriptions
		'delete',
		'update',
		'create' 
];

if (! isset ( $_POST ['action'] ) || ! isset ( $_POST ['class'] ) || ! isset ( $_POST ['dao'] )) {
	echo json_encode ( false );
	exit ( 0 );
}

$action = $_POST ['action'];
$class = $_POST ['class'];
$dao = $_POST ['dao'];

if (! contains ( $action, $functions )) {
	echo json_encode ( false );
	exit ( 0 );
}

$dao = new $dao ( MaBD::getInstance () );
$fieldNames = $dao->getColumnNames ();
$fields = getFields ();

if (! checkData ()) {
	echo json_encode ( false );
	exit ( 0 );
}

$action ();

/*
 * Fonction qui insère un objet dans la base
 * Retourne l'objet inséré au format JSON
 */
function create() {
	global $class, $dao, $fields, $fieldNames;
	
	$fields [$fieldNames [0]] = DAO::UNKNOWN_ID;
	
	$new = new $class ( $fields );
	$res = $dao->insert ( $new );
	
	if ($res === 0)
		echo json_encode ( false );
	else
		echo json_encode ( $new );
}

/*
 * Fonction qui récupère un objet dans la base
 * Retourne un objet au format JSON
 */
function retrieve() {
	global $dao, $fields;
	$res = $dao->getOne ( reset ( $fields ) );
	if ($res === null)
		echo json_encode ( false );
	else
		echo json_encode ( $res );
}

/* 
 * Fonction qui récupère les 10 enregistrements d'un utilisateur dans la base
 * Retourne un objet au format JSON
 */
function retrieveLastTen() {
	global $dao, $fields, $class;
	
	if ($class === 'Inscription') {
		$res = $dao->getLastTen ( reset ( $fields ) );
		if ($res === null)
			echo json_encode ( false );
		else
			echo json_encode ( $res );
	} else
		echo json_encode ( false );
}

/*
 * Fonction qui récupère tous les objets dans la base
 * Retourne un tableau d'objets au format JSON
 */
function retrieveAll() {
	global $dao;
	$res = $dao->getAll ();
	if ($res === null)
		echo json_encode ( false );
	else
		echo json_encode ( $res );
}

/*
 * Fonction qui supprime un objet dans la base
 */
function delete() {
	global $dao, $fields;
	$supp = $dao->getOne ( reset ( $fields ) );
	if ($supp !== null) {
		$res = $dao->delete ( $supp );
		if ($res === 0)
			echo json_encode ( false );
		else
			echo json_encode ( true );
	} else
		echo json_encode(false);
}

/*
 * Fonction qui met à jour un objet dans la base
 * Retourne l'objet mis à jour au format JSON
 */
function update() {
	global $class, $dao, $fields;
	
	$new = new $class ( $fields );
	$res = $dao->update ( $new );
	
	if ($res === 0)
		echo json_encode ( false );
	else
		echo json_encode ( true );
}

/*
 * Fonction qui retourne les données envoyées sous forme de tableau associatif
 */
function getFields() {
	global $dao, $fieldNames;
	foreach ( $fieldNames as $fieldName ) {
		if (isset ( $_POST [$fieldName] ))
			$fields [$fieldName] = $_POST [$fieldName];
	}
	if (isset ( $fields ))
		return $fields;
}

/*
 * Fonction de vérification des champs basique
 * Attention, ne vérifie pas le contenu !
 */
function checkData() {
	global $action, $fieldNames, $fields;
	
	switch ($action) {
		case 'create' :
			return (count ( $fields ) === count ( $fieldNames ) - 1);
			break;
		case 'update' :
			return (count ( $fields ) >= 2);
			break;
		case 'retrieveAll' :
			return true;
			break;
		default :
			return (count ( $fields ) === 1);
			break;
	}
}

/*
 * Vérifie si une chaine est présente dans un tableau
 */
function contains($string, $array) {
	foreach ( $array as $a ) {
		if (stripos ( $string, $a ) !== false)
			return true;
	}
	return false;
}
?>
