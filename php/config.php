<?php
session_start();
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "donormate";
$path = dirname(__FILE__);
$pieces = explode(DIRECTORY_SEPARATOR, $path);
$BASEDIR= $pieces[count($pieces) - 2];

$conn = mysqli_connect($servername, $username, $password, $dbname);
require_once "functions.php";
// Vérification de la connexion
if ($conn->connect_error) {
    die("La connexion a échoué: " . $conn->connect_error);
}
?>
