<!-- hoi olaf gfjsdgfjs -->

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
            /* Zorg ervoor dat de link het hele gebied beslaat */
            height: 100%;
            /* Zorg ervoor dat de link de volledige hoogte heeft */
            color: white;
            /* Zorg ervoor dat de tekstkleur wit is */
            text-decoration: none;
            /* Verwijder de standaard onderstreping */
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
            /* Zorg ervoor dat de gradient boven de afbeelding staat */
        }


        .boot:hover {
            cursor: pointer;
            /* Hand cursor wanneer je over de boot gaat */
        }

        .boot::before {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            height: 60%;
            border-radius: 10px;
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


    <?php
    include 'navbar.php';


    ?>

    <!-- Boten Weergave -->
    <div class="boten-container" id="boten-container">
        <?php foreach ($boten as $boot): ?>
            <div class="boot" data-naam="<?= htmlspecialchars($boot['naam']) ?>">
                <a href="detail.php?id=<?= htmlspecialchars($boot['id']) ?>" style="text-decoration:none; color:white;">
                    <div class="gradient"></div> <!-- Gradient hier toegevoegd -->
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
        boten.forEach((boot, index) => {
            // Voeg een 'mouseenter' eventlistener toe
            boot.addEventListener('mouseenter', () => {
                boten.forEach(b => b.classList.remove('groot'));
                boten.forEach(b => b.classList.add('klein'));

                boot.classList.add('groot'); // Vergroot de huidige boot
                boot.classList.remove('klein'); // Verwijder de 'klein' class van de huidige
            });

            // Voeg een 'mouseleave' eventlistener toe (optioneel, als je iets wilt terugdraaien na hover)
            boot.addEventListener('mouseleave', () => {
                // Hier kun je gedrag instellen als de muis weer van de boot afgaat.
            });
        });
    </script>

    <!-- Voeg Font Awesome toe voor het zoekicoon -->
    <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>

</body>

</html>