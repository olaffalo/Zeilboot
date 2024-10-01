<?php
$host = 'localhost';
$dbname = 'zeilschool';
$username = 'root';  // pas dit aan met jouw database gebruikersnaam
$password = '';      // pas dit aan met jouw database wachtwoord

try {
    $conn = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}
