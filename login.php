<?php
// include database connection
include 'include/db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Haal de ingevoerde gegevens op   
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Controleer of de gebruiker in de database bestaat
    $stmt = $pdo->prepare("SELECT * FROM cursisten WHERE email = :email");
    $stmt->execute(['email' => $email]);
    $cursist = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($cursist) {
        // Controleer of het wachtwoord overeenkomt met de wachtwoord_hash in de database
        if (password_verify($password, $cursist['wachtwoord_hash'])) {
            // Login succesvol, start sessie en stuur door naar beveiligde pagina
            session_start();
            $_SESSION['cursisten_id'] = $cursist['id'];
            $_SESSION['rol'] = $cursist['rol']; // eventueel de rol opslaan
            header("Location: home.php");
            exit();
        } else {
            $error = "Onjuist wachtwoord.";
        }
    } else {
        $error = "Geen gebruiker gevonden met dit e-mailadres.";
    }
}
?>

<!DOCTYPE html>
<html lang="nl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Zeilschool</title>
    <style>
        /* Jouw CSS blijft hier hetzelfde */
        body {
            font-family: Arial, sans-serif;
            background-color: #f2f2f2;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }

        .login-container {
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
        input[type="password"] {
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

        .register-link {
            color: #337ab7;
            text-decoration: none;
        }

        .register-link:hover {
            text-decoration: underline;
        }
    </style>
</head>

<body>
    <div class="login-container">
        <h2>Welkom</h2>
        <?php if (isset($error)): ?>
            <p style="color: red;"><?php echo htmlspecialchars($error); ?></p>
        <?php endif; ?>
        <form action="login.php" method="POST">
            <label for="email">E-mail</label>
            <input type="email" id="email" name="email" placeholder="Voer je e-mail in" required>

            <label for="password">Wachtwoord</label>
            <input type="password" id="password" name="password" placeholder="Voer je wachtwoord in" required>

            <input type="submit" value="Log in">
        </form>
        <p><a href="register.php" class="register-link">Geen account? Registreer hier</a></p>
    </div>
</body>

</html>