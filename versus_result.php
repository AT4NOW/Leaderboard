<?php
require_once 'admin/config.php'; // database en configuratie
include 'admin/debug.php'; // Activeert debug-instellingen indien nodig vanuit config
?>

<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <title>Resultaten Speler vs Speler</title>
    <style>
        .result-item {
            margin: 5px 0;
        }
        .result-label {
            display: inline-block;
            width: 200px;
        }
    </style>
</head>
<body>
    <h1>Resultaten van vergelijking</h1>
    <a href="versus.php">Terug naar spelerselectie</a>
    <?php
    if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['speler1'], $_POST['speler2'])) {
        $speler1 = $_POST['speler1'];
        $speler2 = $_POST['speler2'];

        if ($speler1 == 'all' && $speler2 == 'all') {
            echo "<h2>Vergelijking van Iedereen vs Iedereen</h2>";

            // Query's voor het tellen van gewonnen, verloren, gelijkgespeelde potjes en flags voor alle spelers
            $query_total_games = "SELECT COUNT(*) AS total_games FROM matches WHERE flag IS NULL";
            $query_wins = "SELECT COUNT(*) AS wins FROM matches WHERE winnaar_id IS NOT NULL AND draw = 0 AND flag IS NULL";
            $query_losses = "SELECT COUNT(*) AS losses FROM matches WHERE verliezer_id IS NOT NULL AND draw = 0 AND flag IS NULL";
            $query_draws = "SELECT COUNT(*) AS draws FROM matches WHERE draw = 1 AND flag IS NULL";
            $query_flags = "SELECT COUNT(*) AS flag_count FROM matches WHERE flag IS NOT NULL";

            $result_total_games = $mysqli->query($query_total_games);
            $result_wins = $mysqli->query($query_wins);
            $result_losses = $mysqli->query($query_losses);
            $result_draws = $mysqli->query($query_draws);
            $result_flags = $mysqli->query($query_flags);

            $total_games_count = $result_total_games->fetch_assoc()['total_games'];
            $wins_count = $result_wins->fetch_assoc()['wins'];
            $losses_count = $result_losses->fetch_assoc()['losses'];
            $draws_count = $result_draws->fetch_assoc()['draws'];
            $flag_count = $result_flags->fetch_assoc()['flag_count'];

            echo "<div class='result-item'><span class='result-label'>Totaal aantal games:</span> $total_games_count</div>";
            echo "<div class='result-item'><span class='result-label'>Gewonnen potjes:</span> $wins_count</div>";
            echo "<div class='result-item'><span class='result-label'>Verloren potjes:</span> $losses_count</div>";
            echo "<div class='result-item'><span class='result-label'>Gelijkspellen:</span> $draws_count</div>";
            echo "<div class='result-item'><span class='result-label'>Aantal flags:</span> $flag_count</div>";
        } else {
            // Ophalen van de namen van de spelers
            $naam_speler1 = $speler1 == 'all' ? 'Iedereen' : '';
            $naam_speler2 = $speler2 == 'all' ? 'Iedereen' : '';

            if ($speler1 != 'all') {
                $stmt = $mysqli->prepare("SELECT naam FROM spelers WHERE speler_id = ?");
                $stmt->bind_param("i", $speler1);
                $stmt->execute();
                $result = $stmt->get_result();
                $naam_speler1 = $result->fetch_assoc()['naam'];
                $stmt->close();
            }

            if ($speler2 != 'all') {
                $stmt = $mysqli->prepare("SELECT naam FROM spelers WHERE speler_id = ?");
                $stmt->bind_param("i", $speler2);
                $stmt->execute();
                $result = $stmt->get_result();
                $naam_speler2 = $result->fetch_assoc()['naam'];
                $stmt->close();
            }

            echo "<h2>Vergelijking van " . htmlspecialchars($naam_speler1) . " vs " . htmlspecialchars($naam_speler2) . "</h2>";

            if ($speler1 == 'all' || $speler2 == 'all') {
                // Query's voor het tellen van gewonnen en verloren potjes en flags
                $query_total_games = "SELECT COUNT(*) AS total_games FROM matches WHERE (winnaar_id = ? OR verliezer_id = ?) AND flag IS NULL";
                $query_wins = "SELECT COUNT(*) AS wins FROM matches WHERE winnaar_id = ? AND draw = 0 AND flag IS NULL";
                $query_losses = "SELECT COUNT(*) AS losses FROM matches WHERE verliezer_id = ? AND draw = 0 AND flag IS NULL";
                $query_draws = "SELECT COUNT(*) AS draws FROM matches WHERE (winnaar_id = ? OR verliezer_id = ?) AND draw = 1 AND flag IS NULL";
                $query_flags = "SELECT COUNT(*) AS flag_count FROM matches WHERE (winnaar_id = ? OR verliezer_id = ?) AND flag IS NOT NULL";

                if ($speler1 == 'all') {
                    $stmt = $mysqli->prepare($query_total_games);
                    $stmt->bind_param("ii", $speler2, $speler2);
                    $stmt->execute();
                    $result_total_games = $stmt->get_result();
                    $total_games_count = $result_total_games->fetch_assoc()['total_games'];
                    $stmt->close();

                    $stmt = $mysqli->prepare($query_wins);
                    $stmt->bind_param("i", $speler2);
                    $stmt->execute();
                    $result_wins = $stmt->get_result();
                    $wins_count = $result_wins->fetch_assoc()['wins'];
                    $stmt->close();

                    $stmt = $mysqli->prepare($query_losses);
                    $stmt->bind_param("i", $speler2);
                    $stmt->execute();
                    $result_losses = $stmt->get_result();
                    $losses_count = $result_losses->fetch_assoc()['losses'];
                    $stmt->close();

                    $stmt = $mysqli->prepare($query_draws);
                    $stmt->bind_param("ii", $speler2, $speler2);
                    $stmt->execute();
                    $result_draws = $stmt->get_result();
                    $draws_count = $result_draws->fetch_assoc()['draws'];
                    $stmt->close();

                    $stmt = $mysqli->prepare($query_flags);
                    $stmt->bind_param("ii", $speler2, $speler2);
                    $stmt->execute();
                    $result_flags = $stmt->get_result();
                    $flag_count = $result_flags->fetch_assoc()['flag_count'];
                    $stmt->close();
                } else {
                    $stmt = $mysqli->prepare($query_total_games);
                    $stmt->bind_param("ii", $speler1, $speler1);
                    $stmt->execute();
                    $result_total_games = $stmt->get_result();
                    $total_games_count = $result_total_games->fetch_assoc()['total_games'];
                    $stmt->close();

                    $stmt = $mysqli->prepare($query_wins);
                    $stmt->bind_param("i", $speler1);
                    $stmt->execute();
                    $result_wins = $stmt->get_result();
                    $wins_count = $result_wins->fetch_assoc()['wins'];
                    $stmt->close();

                    $stmt = $mysqli->prepare($query_losses);
                    $stmt->bind_param("i", $speler1);
                    $stmt->execute();
                    $result_losses = $stmt->get_result();
                    $losses_count = $result_losses->fetch_assoc()['losses'];
                    $stmt->close();

                    $stmt = $mysqli->prepare($query_draws);
                    $stmt->bind_param("ii", $speler1, $speler1);
                    $stmt->execute();
                    $result_draws = $stmt->get_result();
                    $draws_count = $result_draws->fetch_assoc()['draws'];
                    $stmt->close();

                    $stmt = $mysqli->prepare($query_flags);
                    $stmt->bind_param("ii", $speler1, $speler1);
                    $stmt->execute();
                    $result_flags = $stmt->get_result();
                    $flag_count = $result_flags->fetch_assoc()['flag_count'];
                    $stmt->close();
                }

                echo "<div class='result-item'><span class='result-label'>Totaal aantal games:</span> $total_games_count</div>";
                echo "<div class='result-item'><span class='result-label'>Gewonnen potjes:</span> $wins_count</div>";
                echo "<div class='result-item'><span class='result-label'>Verloren potjes:</span> $losses_count</div>";
                echo "<div class='result-item'><span class='result-label'>Gelijkspellen:</span> $draws_count</div>";
                echo "<div class='result-item'><span class='result-label'>Aantal flags:</span> $flag_count</div>";
            } else {
                // Voer de query uit om de wedstrijden te vinden
                $query = "SELECT winnaar_id, verliezer_id, draw FROM matches WHERE ((winnaar_id = ? AND verliezer_id = ?) OR (winnaar_id = ? AND verliezer_id = ?)) AND flag IS NULL";
                $stmt = $mysqli->prepare($query);
                $stmt->bind_param("iiii", $speler1, $speler2, $speler2, $speler1);
                $stmt->execute();
                $result = $stmt->get_result();

                $total_games = 0;
                $wins_speler1 = 0;
                $wins_speler2 = 0;
                $losses_speler1 = 0;
                $losses_speler2 = 0;
                $draws = 0;

                // Verwerk de resultaten
                while ($row = $result->fetch_assoc()) {
                    $total_games++;
                    if ($row['draw']) {
                        $draws++;
                    } elseif ($row['winnaar_id'] == $speler1) {
                        $wins_speler1++;
                        $losses_speler2++;
                    } elseif ($row['winnaar_id'] == $speler2) {
                        $wins_speler2++;
                        $losses_speler1++;
                    }
                }

                $stmt->close();

                // Query voor het tellen van geflagde matches specifiek voor deze twee spelers
                $flag_query = "SELECT COUNT(*) AS flag_count FROM matches WHERE flag IS NOT NULL AND ((winnaar_id = ? AND verliezer_id = ?) OR (winnaar_id = ? AND verliezer_id = ?))";
                $stmt = $mysqli->prepare($flag_query);
                $stmt->bind_param("iiii", $speler1, $speler2, $speler2, $speler1);
                $stmt->execute();
                $flag_result = $stmt->get_result();
                $flag_data = $flag_result->fetch_assoc();
                $flag_count = $flag_data['flag_count'];

                // Toon de resultaten
                echo "<p><b>Totaal aantal games tussen <u>" . htmlspecialchars($naam_speler1) . "</u> VS <u>" . htmlspecialchars($naam_speler2) . "</u>:</b> $total_games</p>";
                echo "<p>Aantal games gewonnen door <u>" . htmlspecialchars($naam_speler1) . "</u>: $wins_speler1</p>";
                echo "<p>Aantal games gewonnen door <u>" . htmlspecialchars($naam_speler2) . "</u>: $wins_speler2</p>";
                echo "<p>Aantal games verloren door <u>" . htmlspecialchars($naam_speler1) . "</u>: $losses_speler1</p>";
                echo "<p>Aantal games verloren door <u>" . htmlspecialchars($naam_speler2) . "</u>: $losses_speler2</p>";
                echo "<p>Aantal gelijkspellen: $draws</p>";
                echo "<p>Aantal flags: $flag_count</p>";
            }
        }
    } else {
        echo "<p>Geen informatie ontvangen. Ga terug en selecteer twee spelers.</p>";
    }
    ?>
</body>
</html>
