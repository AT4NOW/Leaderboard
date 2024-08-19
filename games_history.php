<?php
require_once 'admin/config.php'; // database en configuratie
include 'admin/debug.php'; // Activeert debug-instellingen indien nodig vanuit config

$sql = "SELECT a.naam as speler1, b.naam as speler2, matches.score_winnaar, matches.score_verliezer, matches.datum, matches.flag, matches.draw FROM matches 
        LEFT JOIN spelers a ON matches.winnaar_id = a.speler_id 
        LEFT JOIN spelers b ON matches.verliezer_id = b.speler_id 
        ORDER BY matches.datum DESC";

if ($result = $mysqli->query($sql)) {
    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            $flaggedStyle = "";
            $nonFlagStyle = "style='color: red; font-style: italic;'"; // Stijl voor de tekst zonder doorstreping
            $flagInfo = "";
            $drawStyle = "";

            if ($row['flag'] !== NULL) {
                $flaggedStyle = "style='color: red; font-style: italic; text-decoration: line-through;'";
                $flagInfo = "<span $nonFlagStyle> - *(" . htmlspecialchars($row['flag']) . ")*</span>"; // Flag-info in dezelfde stijl maar zonder doorstreping
            }

            if ($row['draw'] == 1) {
                $drawStyle = "style='font-style: italic;'";
                $row["speler1"] = $row["speler1"] ?? 'Onbekend'; // Gebruik 'Onbekend' als de spelernaam niet beschikbaar is
                $row["speler2"] = $row["speler2"] ?? 'Onbekend'; // Gebruik 'Onbekend' als de spelernaam niet beschikbaar is
                echo "<span $drawStyle>" . $row["datum"] . " - Speler: " . $row["speler1"] .
                    " - Score: " . $row["score_winnaar"] . " - VS - Score: " . $row["score_verliezer"] . 
                    " - Speler: " . $row["speler2"] . "</span><br>";
            } else {
                echo "<span $flaggedStyle>" . $row["datum"] . " - Speler: " . ($row["speler1"] ?? 'Onbekend') .
                    " - Score: " . $row["score_winnaar"] . " - VS - Score: " . $row["score_verliezer"] . 
                    " - Speler: " . ($row["speler2"] ?? 'Onbekend') . "</span>" . $flagInfo . "<br>";
            }
        }
    } else {
        echo "Geen matchgegevens beschikbaar.";
    }
    $result->close(); // Sluit het resultaat
} else {
    echo "Fout bij het uitvoeren van de query: " . $mysqli->error;
}
$mysqli->close();
?>
