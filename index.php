<?php
include 'config.php';

// Haal boten op uit de database
$stmt = $conn->query('SELECT * FROM boten');
$boten = $stmt->fetchAll(PDO::FETCH_ASSOC);

?>
<!DOCTYPE html>
<html lang="nl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Boten Overzicht</title>
    <style>
        /* Basisstijl */
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
        }

        /* Boten weergave stijl */
        .boten-container {
            display: flex;
            justify-content: center;
            align-items: center;
            margin-top: 50px;
        }

        .boot {
            margin: 0 20px;
            text-align: center;
            position: relative;
            color: white;
            width: 250px;
            height: 250px;
            overflow: hidden;
            transition: transform 0.3s ease-in-out, opacity 0.3s ease-in-out;
        }

        .boot img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        }

        .boot a {
            display: block;
            height: 100%;
            color: white;
            text-decoration: none;
        }

        .gradient {
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            height: 60%;
            background: linear-gradient(to top, rgba(0, 0, 0, 0.7), transparent);
            border-radius: 10px;
            z-index: 1;
        }

        .boot:hover {
            cursor: pointer;
        }

        .boot p {
            position: absolute;
            bottom: 15px;
            left: 15px;
            text-align: left;
            margin: 0;
            z-index: 2;
        }

        .boot.groot {
            transform: scale(1.2);
            z-index: 1;
        }

        .boot.klein {
            opacity: 0.7;
        }
    </style>
</head>

<body>

    <?php include 'navbar.php'; ?>

    <!-- Boten Weergave -->
    <div class="boten-container" id="boten-container">
        <?php foreach ($boten as $boot): ?>
            <div class="boot" data-naam="<?= htmlspecialchars($boot['naam']) ?>">
                <a href="detail.php?id=<?= htmlspecialchars($boot['id']) ?>" style="text-decoration:none; color:white;">
                    <div class="gradient"></div>
                    <img src="<?= htmlspecialchars($boot['foto_url']) ?>" alt="<?= htmlspecialchars($boot['naam']) ?>">
                    <p>
                        <strong><?= htmlspecialchars($boot['naam']) ?></strong><br>
                        <?= htmlspecialchars($boot['niveau']) ?>
                    </p>
                </a>
            </div>
        <?php endforeach; ?>
    </div>

    <script>
        const boten = document.querySelectorAll('.boot');
        const zoekveld = document.getElementById('zoekveld');

        // Zoekfunctionaliteit: filter boten tijdens het typen
        zoekveld.addEventListener('input', function() {
            const zoekterm = zoekveld.value.toLowerCase();

            boten.forEach(boot => {
                const naam = boot.getAttribute('data-naam').toLowerCase();

                // Als de bootnaam overeenkomt met de zoekterm, laat hem zien, anders verberg hem
                if (naam.includes(zoekterm)) {
                    boot.style.display = 'block';
                } else {
                    boot.style.display = 'none';
                }
            });
        });

        // Hoverfunctionaliteit voor boten
        boten.forEach(boot => {
            // Voeg 'mouseenter' eventlistener toe
            boot.addEventListener('mouseenter', () => {
                boten.forEach(b => b.classList.remove('groot'));
                boten.forEach(b => b.classList.add('klein'));
                boot.classList.add('groot'); // Vergroot de huidige boot
                boot.classList.remove('klein'); // Verwijder 'klein' class van de huidige
            });

            // Voeg 'mouseleave' eventlistener toe (individuele boot)
            boot.addEventListener('mouseleave', () => {
                resetBoten(); // Reset alle boten als de muis buiten de huidige boot gaat
            });
        });

        // Functie om alle boten terug naar hun oorspronkelijke staat te brengen
        function resetBoten() {
            boten.forEach(boot => {
                boot.classList.remove('groot', 'klein');
            });
        }
    </script>

    <!-- Voeg Font Awesome toe voor het zoekicoon -->
    <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>

</body>

</html>