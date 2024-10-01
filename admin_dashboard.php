<?php
session_start();

// Controleer of de gebruiker is ingelogd en admin is
if (!isset($_SESSION['user_id']) || $_SESSION['rol'] !== 'admin') {
    header("Location: login.php");
    exit();
}

echo "Welkom bij het admin dashboard!";
?>

<!DOCTYPE html>
<html lang="nl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
</head>

<body>
    <h1>Welkom, Admin!</h1>
    <a href="cursisten_beheer.php">Beheer Cursisten</a>
    <br>
    <a href="cursussen_beheer.php">Beheer Cursussen</a>
    <br>
    <a href="logout.php">Uitloggen</a>
</body>

</html>