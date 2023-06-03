<?php
require_once "C:\x\htdocs\projet\php\config.php";
// Détruire la session en cours

session_start();
session_destroy();

// Rediriger l'utilisateur vers la page de connexion
header("Location: http://localhost/projet/login/login.php");
exit();
?>