<!DOCTYPE html>
<?php 
require_once 'config.php'; // database en configuratie
include 'debug.php'; // Activeert debug-instellingen indien nodig vanuit config
?> 
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <title>Score Invoeren - <?php echo WEBSITE_GAME; ?></title>
</head>
<body>
    <h1>Voer <?php echo WEBSITE_GAME; ?> Score In</h1>
    <a href="/index.php">Terug naar leaderboard</a>
    <p><form action="score_submit.php" method="post">
        <p>Winnaar Naam (selecteer of nieuw):
        <select name="winnaar_id">
            <option value="">Kies een bestaande speler of voeg een nieuwe toe</option>
            <?php include 'score_load_spelers.php'; ?>
        </select>
        <input type="text" name="new_winner_name" placeholder="Nieuwe naam">
        <br>
        Winnaar Score:
        <input type="number" name="score_winnaar" required></p>
        <p>Verliezer Naam (selecteer of nieuw):
        <select name="verliezer_id">
            <option value="">Kies een bestaande speler of voeg een nieuwe toe</option>
            <?php include 'score_load_spelers.php'; ?>
        </select>
        <input type="text" name="new_loser_name" placeholder="Nieuwe naam">
        <br>
        Verliezer Score:
        <input type="number" name="score_verliezer" required></p>
        <input type="submit" value="Score Opslaan">
    </form></p>
    <p><strong>Opgelet:</strong> speel het spel eerlijk en vul de scores naar waarheid in! <br> Gelijk spel?: dan word wel de score opgeslagen maar zonder winnaar of verliezer. <br>Toch een foutje?: vul dan hier het <a href="/admin/correction.php">herstel</a> formulier in.</p>
    <p>Versie:<?php echo WEBSITE_VERSION; ?> </p>
</body>
</html>