<?php
require_once 'admin/config.php'; // database en configuratie
include 'admin/debug.php'; // Activeert debug-instellingen indien nodig vanuit config

// Datum 90 dagen terug vanaf vandaag ophalen in Y-m-d formaat
$ninety_days_ago = date("Y-m-d", strtotime("-89 days"));

$sql = "SELECT spelers.naam, COALESCE(SUM(CASE WHEN matches.draw = 0 AND matches.flag IS NULL THEN 1 ELSE 0 END), 0) AS aantal_wins
        FROM spelers
        LEFT JOIN matches ON spelers.speler_id = matches.winnaar_id
        WHERE DATE(matches.datum) >= '$ninety_days_ago'
        GROUP BY spelers.speler_id, spelers.naam
        ORDER BY aantal_wins DESC, spelers.naam ASC";

if ($result = $mysqli->query($sql)) {
    if ($result->num_rows > 0) {
        $positie = 1;
        echo "<ul style='list-style-type: none; padding: 0;'>";
        while ($row = $result->fetch_assoc()) {
            echo "<li>" . $positie . ". " . htmlspecialchars($row["naam"]) . " - Gewonnen potjes dit kwartaal: " . $row["aantal_wins"] . "</li>";
            $positie++;
        }
        echo "</ul>";
    } else {
        echo "Geen spelersgegevens beschikbaar voor dit kwartaal.";
    }
    $result->close();
} else {
    echo "Fout bij het uitvoeren van de query: " . $mysqli->error;
}
$mysqli->close();
?>