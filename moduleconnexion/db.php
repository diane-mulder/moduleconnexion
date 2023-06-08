<?php
$servername = "localhost";
$username = "root";
$password = "Dyane198124//";
$dbname = "moduleconnexion";
 // Créer une connexion
 $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
 // Configurer PDO pour lancer des exceptions en cas d'erreur
 $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);