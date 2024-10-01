<?php
include 'config.php';

// Haal het boot-id op uit de URL
$boot_id = isset($_GET['id']) ? intval($_GET['id']) : 0;

// Haal de details van de boot op uit de database
$stmt = $conn->prepare('SELECT * FROM boten WHERE id = :id');
$stmt->execute(['id' => $boot_id]);
$boot = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$boot) {
    echo "Boot niet gevonden!";
    exit;
}
?>

<!DOCTYPE html>
<html lang="nl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($boot['naam']) ?> - Boot Details</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
        }

        .container {
            display: flex;
            align-items: flex-start;
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
            background-color: white;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            border-radius: 10px;
        }

        .container img {
            max-width: 500px;
            border-radius: 10px;
            margin-right: 20px;
        }

        .details {
            flex: 1;
            margin-left: 20px;
        }

        .details h2 {
            margin-top: 0;
        }

        /* Algemene styling voor de container en afbeelding */
        .image-container {
            position: relative;
            display: inline-block;
            width: 500px;
            /* Standaard breedte voor de container */
            height: 400px;
            /* Standaard hoogte voor de container */
            overflow: hidden;
            /* Zorg ervoor dat overlopen inhoud niet zichtbaar is */
        }

        .image-container img {
            width: 100%;
            height: 100%;
            /* Zorg ervoor dat de afbeelding de volle hoogte van de container gebruikt */
            object-fit: cover;
            /* Zorg ervoor dat de afbeelding het gebied bedekt zonder de verhoudingen te verstoren */
            display: block;
            border-radius: 10px;
        }


        /* Overlay */
        .overlay {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-color: rgba(0, 0, 0, 0.7);
            color: white;
            opacity: 0;
            transition: opacity 0.3s ease;
            display: flex;
            justify-content: center;
            align-items: center;
            border-radius: 10px;
        }

        .image-container:hover .overlay {
            opacity: 1;
        }

        /* Tekst binnen de overlay */
        .overlay .text {
            text-align: center;
        }

        .overlay h3 {
            margin: 0;
            font-size: 24px;
            font-weight: bold;
        }

        .overlay p {
            margin: 0;
            font-size: 18px;
        }

        /* Styling voor de reserveer knop */
        .btn {
            display: inline-block;
            padding: 15px 30px;
            /* Vergroot de padding om de knop groter te maken */
            font-size: 18px;
            /* Verhoog de lettergrootte voor een grotere knop */
            border-radius: 5px;
            text-align: center;
            text-decoration: none;
            margin-top: 235px;
            /* Verhoog de marge om de knop verder naar beneden te plaatsen */
        }

        /* Actieve knop styling */
        .btn-active {
            background-color: #4acac5;
            color: white;
            transition: background-color 0.3s ease;
        }

        .btn-active:hover {
            background-color: #3bb0aa;
        }

        /* Niet-beschikbare knop styling */
        .btn-disabled {
            background-color: lightgray;
            color: #888;
            cursor: not-allowed;
        }
    </style>
</head>

<body>

    <?php
    include 'navbar.php';


    ?>


    <div class="container">
        <div class="image-container">
            <img src="<?= htmlspecialchars($boot['foto_url']) ?>" alt="<?= htmlspecialchars($boot['naam']) ?>">
            <div class="overlay">
                <div class="text">
                    <h3><?= htmlspecialchars($boot['naam']) ?></h3>
                    <p>Niveau: <?= htmlspecialchars($boot['niveau']) ?></p>
                </div>
            </div>
        </div>
        <div class="details">
            <h2><?= htmlspecialchars($boot['naam']) ?></h2>
            <p><strong>Niveau:</strong> <?= htmlspecialchars($boot['niveau']) ?></p>
            <p><strong>Capaciteit:</strong> <?= htmlspecialchars($boot['maximale_capaciteit']) ?> personen</p>

            <!-- Reserveer knop -->
            <?php if ($boot['beschikbaarheid']) : ?>
                <a href="reserveren.php?boot_id=<?= htmlspecialchars($boot['id']) ?>" class="btn btn-active">Reserveer</a>
            <?php else : ?>
                <a href="#" class="btn btn-disabled" onclick="return false;">Niet beschikbaar</a>
            <?php endif; ?>

        </div>
    </div>





</body>

</html>