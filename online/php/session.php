<?php
// On démarre la session
session_start();

// Test de la session
if (! isset($_SESSION['login'])) {
	header("Location: login.php");
	exit(0);
}

// Déconnexion
if (isset($_GET['deco']))
{
	session_unset();
	header("Location: login.php");
}
?>