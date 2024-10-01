<?php
global $pdo;
include 'include/db.php';
// Start de sessie
session_start();

// Controleer of de gebruiker is ingelogd
if (!isset($_SESSION['cursisten_id'])) {
    // Zo niet, stuur de gebruiker terug naar de loginpagina
    header("Location: login.php");
    exit();
}

// Haal de gebruikersinformatie op uit de database
$stmt = $pdo->prepare("SELECT naam, email, telefoonnummer, niveau FROM cursisten WHERE id = :id");
$stmt->execute(['id' => $_SESSION['cursisten_id']]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);

// Controleer of de gebruiker is gevonden
if (!$user) {
    echo "Gebruiker niet gevonden.";
    exit();
}
?>

<!DOCTYPE html>
<html lang="nl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home - Zeilschool</title>

    <style>
        body {
            margin: 0;
            font-family: Arial, sans-serif;
        }

        .navbar {
            background-color: #337ab7;
            padding: 15px;
            color: white;
            text-align: right;
        }

        .navbar a {
            color: white;
            margin-left: 20px;
            text-decoration: none;
            font-weight: bold;
        }

        .navbar a:hover {
            text-decoration: underline;
        }

        .container {
            text-align: center;
            padding: 100px 20px;
        }

        h1 {
            font-size: 48px;
            color: #337ab7;
        }

        p {
            font-size: 20px;
            color: #333;
        }

        .logout-btn {
            background-color: #ff4d4d;
            color: white;
            padding: 10px 20px;
            text-decoration: none;
            border-radius: 5px;
            font-size: 16px;
        }

        .logout-btn:hover {
            background-color: #ff3333;
        }
    </style>
</head>

<body>

    <!-- Navigatiebalk -->
    <div class="navbar">
        Welkom, <?php echo htmlspecialchars($user['naam']); ?>
        <a href="profiel.php">Profiel</a>
        <a href="login.php" class="logout-btn">Uitloggen</a>
    </div>

    <!-- Inhoud van de homepagina -->
    <div class="container">
        <h1>Welkom bij de Zeilschool</h1>
        <p>Je bent ingelogd als: <?php echo htmlspecialchars($user['naam']); ?></p> <!-- Naam weergegeven in plaats van e-mail -->
    </div>

</body>

</html>