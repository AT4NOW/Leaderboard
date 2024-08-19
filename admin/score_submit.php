<?php
include 'config.php'; // Database en configuratie
include 'debug.php'; // Activeert debug-instellingen indien nodig vanuit config

$winnaar_id = $_POST['winnaar_id'];
$verliezer_id = $_POST['verliezer_id'];
$score_winnaar = $_POST['score_winnaar'];
$score_verliezer = $_POST['score_verliezer'];
$new_winner_name = $_POST['new_winner_name'];
$new_loser_name = $_POST['new_loser_name'];

// Controle of beide spelers geselecteerd zijn of nieuwe namen ingevoerd zijn.
if ((empty($winnaar_id) && empty($new_winner_name)) || (empty($verliezer_id) && empty($new_loser_name))) {
    echo "Fout: Beide spelers moeten geselecteerd zijn of een nieuwe naam ingevuld.<br>";
    echo '<p><a href="score.php">Terug naar score invoeren</a></p>';
    exit();
}

// Nieuwe spelers toevoegen indien de naam is ingevuld en geen bestaande ID geselecteerd is.
if (empty($winnaar_id) && !empty($new_winner_name)) {
    $stmt = $mysqli->prepare("INSERT INTO spelers (naam) VALUES (?)");
    $stmt->bind_param("s", $new_winner_name);
    $stmt->execute();
    $winnaar_id = $mysqli->insert_id; // Update winnaar_id met de nieuwe speler ID
}

if (empty($verliezer_id) && !empty($new_loser_name)) {
    $stmt = $mysqli->prepare("INSERT INTO spelers (naam) VALUES (?)");
    $stmt->bind_param("s", $new_loser_name);
    $stmt->execute();
    $verliezer_id = $mysqli->insert_id; // Update verliezer_id met de nieuwe speler ID
}

// Logica voor scoreverwerking en gelijkspel bepaling.
$draw = ($score_winnaar == $score_verliezer);

// Controleer of de score van de winnaar hoger is dan die van de verliezer, tenzij het een gelijkspel is.
if (!$draw && $score_winnaar <= $score_verliezer) {
    echo "Fout: De score van de winnaar moet hoger zijn dan die van de verliezer.<br>";
    echo '<p><a href="score.php">Terug naar score invoeren</a></p>';
    exit();
}

// Bereken de draw_value voor de SQL query
$draw_value = $draw ? 1 : 0;

// SQL-query om de matchgegevens toe te voegen.
$stmt = $mysqli->prepare("INSERT INTO matches (winnaar_id, verliezer_id, score_winnaar, score_verliezer, `draw`) VALUES (?, ?, ?, ?, ?)");
$stmt->bind_param("iiiii", $winnaar_id, $verliezer_id, $score_winnaar, $score_verliezer, $draw_value);
$stmt->execute();

// Feedback na het opslaan
if ($stmt->affected_rows > 0) {
    echo $draw ? "Score succesvol opgeslagen!<br> De game eindigde in een gelijkspel, er is geen winnaar of verliezer.<br>" : "Score succesvol opgeslagen.<br>";
    echo '<p><a href="/index.php">Terug naar leaderboard</a></p>';
} else {
    echo "Er is een fout opgetreden. Probeer het opnieuw.<br>";
    echo '<p><a href="score.php">Terug naar score invoeren</a></p>';
}

$mysqli->close();
?>
