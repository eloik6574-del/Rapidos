<?php
$hostname = "localhost";
$username = "root";
$password = "";
$database = "rapido";

// Connexion à la base de données
$connexion = mysqli_connect($hostname, $username, $password, $database);

// Vérification de la connexion
if (!$connexion) {
    die("Connexion échouée : " . mysqli_connect_error());
}
?>