<?php
// Start de sessie
global $pdo;
session_start();

// Controleer of de gebruiker is ingelogd
if (!isset($_SESSION['cursisten_id'])) {
    header("Location: login.php");
    exit();
}

// Verbind met de database
include 'include/db.php';

// Haal cursisteninformatie op uit de database
$stmt = $pdo->prepare("SELECT * FROM cursisten WHERE id = :id");
$stmt->execute(['id' => $_SESSION['cursisten_id']]);
$cursist = $stmt->fetch(PDO::FETCH_ASSOC);

// Controleer of de cursist is gevonden
if (!$cursist) {
    echo "Cursist niet gevonden.";
    exit();
}

// Variabelen voor het bijwerken van het profiel
$nameError = $emailError = $phoneError = $passwordError = $successMessage = "";
$name = $cursist['naam'];
$mail = $cursist['email'];
$phone = $cursist['telefoonnummer']; // Telefoonnummer
$hashed_password = $cursist['wachtwoord_hash']; // gebruik wachtwoord_hash

// Als het formulier is ingediend
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = trim($_POST['name']);
    $mail = trim($_POST['mail']);
    $phone = trim($_POST['phone']); // Nieuwe telefoonnummer
    $password = trim($_POST['password']);

    // Validatie
    if (empty($name)) {
        $nameError = "Naam is verplicht";
    }

    if (empty($mail)) {
        $emailError = "E-mail is verplicht";
    } elseif (!filter_var($mail, FILTER_VALIDATE_EMAIL)) {
        $emailError = "Ongeldig e-mailadres";
    }

    if (empty($phone)) {
        $phoneError = "Telefoonnummer is verplicht";
    } elseif (!preg_match('/^\d{10,15}$/', $phone)) { // Validatie voor telefoonnummer (10-15 cijfers)
        $phoneError = "Ongeldig telefoonnummer (voer 10 tot 15 cijfers in)";
    }

    // Wachtwoord update alleen als het veld niet leeg is
    if (!empty($password)) {
        if (strlen($password) < 6) {
            $passwordError = "Het wachtwoord moet minimaal 6 tekens bevatten";
        } else {
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        }
    }

    // Als er geen fouten zijn, werk de gegevens bij
    if (empty($nameError) && empty($emailError) && empty($phoneError) && empty($passwordError)) {
        // Update de naam, e-mail en telefoonnummer
        $stmt = $pdo->prepare("UPDATE cursisten SET naam = :naam, email = :email, telefoonnummer = :telefoonnummer WHERE id = :id");
        $stmt->execute([
            'naam' => $name,
            'email' => $mail,
            'telefoonnummer' => $phone,
            'id' => $_SESSION['cursisten_id']
        ]);

        // Update het wachtwoord als dat is opgegeven
        if (!empty($password)) {
            $stmt = $pdo->prepare("UPDATE cursisten SET wachtwoord_hash = :wachtwoord_hash WHERE id = :id");
            $stmt->execute([
                'wachtwoord_hash' => $hashed_password,
                'id' => $_SESSION['cursisten_id']
            ]);
        }

        $successMessage = "Je profiel is bijgewerkt!";
    }
}
?>

<!DOCTYPE html>
<html lang="nl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profiel bewerken</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f2f2f2;
            margin: 0;
            padding: 0;
        }

        .container {
            max-width: 600px;
            margin: 100px auto;
            background-color: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        h2 {
            text-align: center;
            color: #337ab7;
        }

        form {
            display: flex;
            flex-direction: column;
        }

        input[type="text"],
        input[type="email"],
        input[type="password"] {
            padding: 10px;
            margin-bottom: 10px;
            border-radius: 5px;
            border: 1px solid #ccc;
            font-size: 16px;
        }

        .error {
            color: red;
            font-size: 14px;
            margin-bottom: 10px;
        }

        .success {
            color: green;
            font-size: 16px;
            margin-bottom: 10px;
        }

        button {
            padding: 10px;
            background-color: #337ab7;
            color: white;
            border: none;
            border-radius: 5px;
            font-size: 16px;
            cursor: pointer;
        }

        button:hover {
            background-color: #286090;
        }

        .back-link {
            display: block;
            text-align: center;
            margin-top: 20px;
            text-decoration: none;
            color: #337ab7;
        }

        .back-link:hover {
            text-decoration: underline;
        }
    </style>
</head>

<body>

    <div class="container">
        <h2>Profiel</h2>
        <?php if ($successMessage): ?>
            <p class="success"><?php echo $successMessage; ?></p>
        <?php endif; ?>

        <form action="profiel.php" method="post">
            <label for="name">Naam</label>
            <input type="text" id="name" name="name" value="<?php echo htmlspecialchars($name); ?>">
            <span class="error"><?php echo $nameError; ?></span>

            <label for="mail">E-mail</label>
            <input type="email" id="mail" name="mail" value="<?php echo htmlspecialchars($mail); ?>">
            <span class="error"><?php echo $emailError; ?></span>

            <label for="phone">Telefoonnummer</label>
            <input type="text" id="phone" name="phone" value="<?php echo htmlspecialchars($phone); ?>">
            <span class="error"><?php echo $phoneError; ?></span>

            <label for="password">Nieuw wachtwoord (optioneel)</label>
            <input type="password" id="password" name="password">
            <span class="error"><?php echo $passwordError; ?></span>

            <button type="submit">Profiel bijwerken</button>
        </form>

        <a href="home.php" class="back-link">Terug naar Dashboard</a>
    </div>

</body>

</html>