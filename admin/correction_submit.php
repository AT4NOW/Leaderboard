<?php
include 'config.php'; // database en configuratie
include 'debug.php'; // Activeert debug-instellingen indien nodig vanuit config

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $match_id = $_POST['match_id'];
    $flag = $_POST['action']; // Veranderd van 'flag' naar 'action' zoals gedefinieerd in het formulier
    $info = $_POST['reason']; // Veranderd van 'info' naar 'reason'

    $query = "UPDATE matches SET flag = ?, info = ? WHERE match_id = ?";
    $stmt = $mysqli->prepare($query);
    if ($stmt) {
        $stmt->bind_param('ssi', $flag, $info, $match_id);
        if ($stmt->execute()) {
            echo "Match is bijgewerkt!";
            echo '<p><a href="/index.php">Terug naar leaderboard</a></p>';
        } else {
            echo "Fout bij het updaten van de match: " . $stmt->error;
            echo '<p><a href="/correction.php">Terug naar correctie</a></p>';
        }
        $stmt->close();
    } else {
        echo "Fout bij het voorbereiden van de query: " . $mysqli->error;
        echo '<p><a href="/correction.php">Terug naar correctie</a></p>';
    }
}
?>
