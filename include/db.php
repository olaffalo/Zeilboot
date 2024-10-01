<?php
// Database-instellingen
$servername = "192.168.137.1";
$username = "server";
$password = "admin";
$dbname = "zeilschool";

try {
    // Maak verbinding met de database
    $pdo = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    // Zet de PDO-foutmodus op uitzondering
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    // Toon een foutmelding als de verbinding niet werkt
    die("Verbinding mislukt: " . $e->getMessage());
}
