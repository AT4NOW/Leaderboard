<!DOCTYPE html>
<?php 
require_once 'config.php'; // database en configuratie
include 'debug.php'; // Activeert debug-instellingen indien nodig vanuit config

// Update de SQL-query met de correcte kolomnaam 'datum'
$sql = "SELECT match_id, datum FROM matches WHERE datum >= DATE_SUB(NOW(), INTERVAL 2 DAY) ORDER BY datum DESC LIMIT 5";
$matches = [];
if ($result = $mysqli->query($sql)) {
    while ($row = $result->fetch_assoc()) {
        $matches[] = $row;
    }
} else {
    echo "Error: " . $mysqli->error;
}
?>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <title><?php echo WEBSITE_GAME; ?> - Match Herstel</title>
</head>
<body>
    <h1>Herstel Match</h1>
    <a href="/index.php">Terug naar leaderboard</a>
    <p>
        <form action="correction_submit.php" method="post">
            <select name="match_id" required>
                <option value="">Kies een match</option>
                <?php foreach ($matches as $match): ?>
                <option value="<?= $match['match_id'] ?>"><?= $match['datum'] ?></option>
                <?php endforeach; ?>
            </select>
            <select name="action" required>
                <option value="">Kies een reden</option>
                <option value="valsgespeeld!">Valsgespeeld</option>
                <option value="foutief!">Foutief en verzoek tot verwijderen</option>
            </select>
            <input type="text" name="reason" placeholder="Onderbouw de reden" required>
            <input type="submit" value="Submit">
        </form>
    </p>
    <p><strong>Opgelet:</strong> Foutje, zeker weten?: vul dan hier het herstel formulier in! <br> De laatste 5 matches van afgelopen 2 dagen kan nog worden geflagt!</p>
    <p>Versie:<?php echo WEBSITE_VERSION; ?> </p>
</body>
</html>
