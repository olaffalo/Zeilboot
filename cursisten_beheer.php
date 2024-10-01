<?php
session_start();

// Controleer of de gebruiker is ingelogd en admin is
if (!isset($_SESSION['cursisten_id']) || $_SESSION['rol'] !== 'admin') {
    header("Location: login.php");
    exit();
}

include 'include/db.php';

// Haal alle cursisten op
$stmt = $pdo->query("SELECT * FROM cursisten");
$cursisten = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="nl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cursisten Beheer</title>
</head>

<body>
    <h1>Cursisten Beheer</h1>
    <table border="1">
        <thead>
            <tr>
                <th>ID</th>
                <th>Naam</th>
                <th>E-mail</th>
                <th>Telefoonnummer</th>
                <th>Niveau</th>
                <th>Rol</th>
                <th>Acties</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($cursisten as $cursist): ?>
                <tr>
                    <td><?php echo htmlspecialchars($cursist['id']); ?></td>
                    <td><?php echo htmlspecialchars($cursist['naam']); ?></td>
                    <td><?php echo htmlspecialchars($cursist['email']); ?></td>
                    <td><?php echo htmlspecialchars($cursist['telefoonnummer']); ?></td>
                    <td><?php echo htmlspecialchars($cursist['niveau']); ?></td>
                    <td><?php echo htmlspecialchars($cursist['rol']); ?></td>
                    <td>
                        <a href="bewerk_cursist.php?id=<?php echo $cursist['id']; ?>">Bewerken</a>
                        <a href="verwijder_cursist.php?id=<?php echo $cursist['id']; ?>">Verwijderen</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</body>

</html>