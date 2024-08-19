<!DOCTYPE html>
<?php 
require_once 'admin/config.php'; // database en configuratie
include 'admin/debug.php'; // Activeert debug-instellingen indien nodig vanuit config
?> 
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="robots" content="noindex, nofollow">
    <title>Matchgeschiedenis</title>
</head>
<body>
    <h1>Matchgeschiedenis</h1>
    <a href="index.php">Terug naar leaderboard</a>
    <div id="matches">
    <p><?php include 'games_history.php'; ?></p>
    </div>
</body>
</html>
