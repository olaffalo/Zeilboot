<?php
include 'config.php'; // Zorg ervoor dat dit je database-configuratie bevat

// Haal het boot-id op uit de URL
$boot_id = isset($_GET['boot_id']) ? intval($_GET['boot_id']) : 0;

// Haal de cursusdetails op voor de opgegeven boot, inclusief de prijs
$stmt = $conn->prepare("
    SELECT c.naam AS cursus_naam, c.start_datum, c.eind_datum, 
           b.naam AS boot_naam, b.foto_url, 
           i.naam AS instructeur_naam, c.id AS cursus_id, c.prijs
    FROM cursussen c 
    JOIN boten b ON c.boot_id = b.id 
    JOIN instructeurs i ON c.instructeur_id = i.id 
    WHERE b.id = :boot_id
");
$stmt->execute(['boot_id' => $boot_id]);

$cursus = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$cursus) {
    echo "Cursus niet gevonden!";
    exit;
}

// Gebruik de prijs uit de database
$bedrag = $cursus['prijs']; // Haal het bedrag van de cursus
?>

<!DOCTYPE html>
<html lang="nl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($cursus['cursus_naam']) ?> - Cursus Details</title>
    <script src="https://www.paypal.com/sdk/js?client-id=AeUj_crc7eJIHrd6aVsPjb_RfqYdN7zDfDk4boEtrrVsNEuPKxdPRxFeG3wH1TQ7mr-hCzAYG4-M3e12&currency=EUR"></script> <!-- Vervang met je Sandbox Client ID -->
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

        .details {
            flex: 1;
            margin-left: 20px;
        }

        .details h1 {
            margin-top: 0;
        }
    </style>
</head>

<body>

    <?php include 'navbar.php'; ?>

    <div class="container">
        <div class="image-container">
            <img src="<?= htmlspecialchars($cursus['foto_url']) ?>" alt="<?= htmlspecialchars($cursus['boot_naam']) ?>">
        </div>
        <div class="details">
            <h1><?= htmlspecialchars($cursus['cursus_naam']) ?></h1>
            <p><strong>Boot:</strong> <?= htmlspecialchars($cursus['boot_naam']) ?></p>
            <p><strong>Instructeur:</strong> <?= htmlspecialchars($cursus['instructeur_naam']) ?></p>
            <p><strong>Startdatum:</strong> <?= htmlspecialchars($cursus['start_datum']) ?></p>
            <p><strong>Einddatum:</strong> <?= htmlspecialchars($cursus['eind_datum']) ?></p>
            <p><strong>Prijs:</strong> €<?= number_format($bedrag, 2, ',', '.') ?></p> <!-- Toon prijs -->

            <!-- PayPal Betaalknop -->
            <div id="paypal-button-container"></div>
            <script>
                paypal.Buttons({
                    style: {
                        layout: 'vertical', // of 'horizontal'
                        color: 'silver', // Knopkleur
                        shape: 'rect', // of 'pill'
                        label: 'checkout' // Tekst op de knop
                    },
                    createOrder: function(data, actions) {
                        return actions.order.create({
                            purchase_units: [{
                                amount: {
                                    value: '<?= number_format($bedrag, 2, '.', '') ?>', // Bedrag voor PayPal
                                    currency_code: 'EUR' // Euro als valuta
                                },
                                description: 'Betaling voor cursus: <?= htmlspecialchars($cursus['cursus_naam']) ?>'
                            }]
                        });
                    },
                    onApprove: function(data, actions) {
                        return actions.order.capture().then(function(details) {
                            alert('Bedankt, ' + details.payer.name.given_name + '! Je betaling is succesvol ontvangen.');
                            window.location.reload(); // Pagina herladen
                        });
                    },
                    onCancel: function(data) {
                        alert('Betaling geannuleerd.');
                        window.location.reload(); // Pagina herladen
                    }
                }).render('#paypal-button-container'); // Render de PayPal-knop in de container
            </script>



        </div>
    </div>

</body>

</html>