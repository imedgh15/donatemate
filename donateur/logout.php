<?php
require_once "../php/config.php";
// Détruire la session en cours

session_destroy();

// Rediriger l'utilisateur vers la page de connexion
header('location: /' . $BASEDIR . '/donateur/index.php');
exit();
?>