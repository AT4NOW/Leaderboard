<?php
require_once 'admin/config.php'; // database en configuratie
include 'admin/debug.php'; // Activeert debug-instellingen indien nodig vanuit config
?>

<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <title>Speler vs Speler</title>
</head>
<body>
    <h1>Kies Twee Spelers om te vergelijken</h1>
    <a href="index.php">Terug naar leaderboard</a>
    <p><form action="versus_result.php" method="post">
        Speler 1:
        <select name="speler1" required>
            <option value="" disabled selected>Kies Speler</option>
            <option value="all">+iedereen</option>
            <?php
            $query = "SELECT speler_id, naam FROM spelers ORDER BY naam ASC";
            if ($result = $mysqli->query($query)) {
                while ($row = $result->fetch_assoc()) {
                    echo '<option value="' . $row['speler_id'] . '">' . htmlspecialchars($row['naam']) . '</option>';
                }
            }
            ?>
        </select>

        VS Speler 2:
        <select name="speler2" required>
            <option value="" disabled selected>Kies Speler</option>
            <option value="all">+iedereen</option>
            <?php
            $query = "SELECT speler_id, naam FROM spelers ORDER BY naam ASC";
            if ($result = $mysqli->query($query)) {
                while ($row = $result->fetch_assoc()) {
                    echo '<option value="' . $row['speler_id'] . '">' . htmlspecialchars($row['naam']) . '</option>';
                }
            }
            ?>
        </select>

        <input type="submit" value="Vergelijk Scores">
    </form></p>
</body>
</html>
