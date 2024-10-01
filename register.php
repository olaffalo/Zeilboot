<?php
// include database connection
include 'include/db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Haal de ingevoerde gegevens op
    $email = $_POST['email'];
    $naam = $_POST['naam'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];
    $telefoonnummer = $_POST['telefoonnummer'];
    $niveau = $_POST['niveau'];

    // Controleer of het wachtwoord en de bevestiging hetzelfde zijn
    if ($password !== $confirm_password) {
        $error = "Wachtwoorden komen niet overeen.";
    } else {
        // Controleer of de e-mail al bestaat in de database
        $stmt = $pdo->prepare("SELECT * FROM cursisten WHERE email = :email");
        $stmt->execute(['email' => $email]);
        $existingUser = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($existingUser) {
            $error = "Dit e-mailadres is al in gebruik.";
        } else {
            // Hash het wachtwoord
            $hashed_password = password_hash($password, PASSWORD_BCRYPT);

            // Voeg de nieuwe gebruiker toe aan de database
            $stmt = $pdo->prepare(
                "
                INSERT INTO cursisten (email, naam, wachtwoord_hash, telefoonnummer, niveau, opmerkingen, rol, created_at) 
                VALUES (:email, :naam, :wachtwoord_hash, :telefoonnummer, :niveau, :opmerkingen, :rol, NOW())"
            );
            $stmt->execute([
                'email' => $email,
                'naam' => $naam,
                'wachtwoord_hash' => $hashed_password,
                'telefoonnummer' => $telefoonnummer,  // Telefoonnummer wordt nu opgeslagen
                'niveau' => $niveau,                   // Niveau wordt nu opgeslagen
                'opmerkingen' => null,                 // Voeg opmerkingen toe als je die hebt
                'rol' => 'gebruiker'                   // Standaard rol
            ]);

            // Doorsturen naar de loginpagina na succesvolle registratie
            header("Location: login.php");
            exit();
        }
    }
}
?>

<!DOCTYPE html>
<html lang="nl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registreren - Zeilschool</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f2f2f2;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }

        .register-container {
            background-color: #e6f0ff;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            text-align: center;
            width: 400px;
        }

        h2 {
            color: #337ab7;
            font-size: 28px;
            margin-bottom: 20px;
        }

        input[type="email"],
        input[type="text"],
        input[type="password"],
        select {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        input[type="submit"] {
            background-color: #4CAF50;
            color: white;
            padding: 10px 15px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            width: 100%;
        }

        input[type="submit"]:hover {
            background-color: #45a049;
        }

        .login-link {
            color: #337ab7;
            text-decoration: none;
        }

        .login-link:hover {
            text-decoration: underline;
        }
    </style>
</head>

<body>

    <div class="register-container">
        <h2>Registreren</h2>
        <?php if (isset($error)): ?>
            <p style="color: red;"><?php echo htmlspecialchars($error); ?></p>
        <?php endif; ?>
        <form action="register.php" method="POST">
            <label for="naam">Naam</label>
            <input type="text" id="naam" name="naam" placeholder="Voer je naam in" required>

            <label for="email">E-mail</label>
            <input type="email" id="email" name="email" placeholder="Voer je e-mail in" required>

            <label for="telefoonnummer">Telefoonnummer</label>
            <input type="text" id="telefoonnummer" name="telefoonnummer" placeholder="Voer je telefoonnummer in" required>

            <label for="niveau">Niveau</label>
            <select id="niveau" name="niveau" required>
                <option value="" disabled selected>Kies je niveau</option>
                <option value="beginner">Beginner</option>
                <option value="gevorderd">Gevorderd</option>
                <option value="expert">Expert</option>
            </select>

            <label for="password">Wachtwoord</label>
            <input type="password" id="password" name="password" placeholder="Voer je wachtwoord in" required>

            <label for="confirm_password">Bevestig Wachtwoord</label>
            <input type="password" id="confirm_password" name="confirm_password" placeholder="Bevestig je wachtwoord" required>

            <input type="submit" value="Registreer">
        </form>
        <p><a href="login.php" class="login-link">Heb je al een account? Log in hier</a></p>
    </div>

</body>

</html>