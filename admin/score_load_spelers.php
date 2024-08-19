<?php
include 'config.php'; // database en configuratie
include 'debug.php'; // Activeert debug-instellingen indien nodig vanuit config

// Wijzig $conn naar $mysqli indien nodig
$sql = "SELECT speler_id, naam FROM spelers ORDER BY naam ASC";
$result = $mysqli->query($sql);

if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        echo '<option value="' . $row["speler_id"] . '">' . $row["naam"] . '</option>';
    }
} else {
    echo "<option>Geen spelers gevonden</option>";
}

$mysqli->close();
?>