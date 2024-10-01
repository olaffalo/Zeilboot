<?php
include 'config.php';

$zoekterm = isset($_GET['zoekterm']) ? $_GET['zoekterm'] : '';

// SQL-query om boten te zoeken op basis van de naam
$stmt = $conn->prepare('SELECT * FROM boten WHERE naam LIKE ?');
$stmt->execute(["%$zoekterm%"]);
$boten = $stmt->fetchAll(PDO::FETCH_ASSOC);

if (empty($boten)) {
    echo "<p>Geen boten gevonden.</p>";
} else {
    foreach ($boten as $index => $boot) {
?>
        <div class="boot <?= $index === 0 ? 'groot' : 'klein' ?>">
            <img src="<?= htmlspecialchars($boot['foto']) ?>" alt="<?= htmlspecialchars($boot['naam']) ?>">
            <p>
                <strong><?= htmlspecialchars($boot['naam']) ?></strong><br>
                <?= htmlspecialchars($boot['niveau']) ?>
            </p>
        </div>
<?php
    }
}
