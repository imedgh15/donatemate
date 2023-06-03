<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "donormate";

// Création de la connexion
$conn = mysqli_connect($servername, $username, $password, $dbname);

// Vérification de la connexion
if ($conn->connect_error) {
    die("La connexion a échoué: " . $conn->connect_error);
}
?>