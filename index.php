<!DOCTYPE html>
<?php 
require_once 'admin/config.php'; // database en configuratie
include 'admin/debug.php'; // Activeert debug-instellingen indien nodig vanuit config
?> 
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="robots" content="noindex, nofollow">
    <title><?php echo WEBSITE_TEAM . ' ' . WEBSITE_GAME . ' Leaderboard'; ?></title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
</head>
<body>
    <h1><?php echo WEBSITE_TEAM . ' ' . WEBSITE_GAME . ' Leaderboard'; ?></h1>
    <a href="games.php">Bekijk matchgeschiedenis</a> | <a href="versus.php">Vergelijk scores</a>

    <!-- Dropdown menu voor tijdspannen -->
    <p><select id="timeframe" onchange="loadLeaderboard()">
        <option value="alltime" selected>All Time</option>
        <option value="daily">Daily</option>
        <option value="weekly">Weekly</option>
        <option value="monthly">Monthly</option>
        <option value="quarterly">Quarterly</option>
        <option value="yearly">Yearly</option>
    </select></p>

    <div id="leaderboardContainer">
        <?php include 'leaderboard_alltime.php'; ?>
    </div>

    <script>
    function loadLeaderboard() {
        var timeframe = document.getElementById("timeframe").value;
        $("#leaderboardContainer").load("leaderboard_" + timeframe + ".php");
    }
    </script>

    <a href="/admin/score.php">Voer nieuwe score in</a>
</body>
</html>