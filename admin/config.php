<?php
$host = 'localhost';  // Aanpassen naar je database host
$username = 'user';  // Aanpassen naar je database gebruikersnaam
$password = 'p@ssw0rd';  // Aanpassen naar je database wachtwoord
$database = 'user_leaderboard';  // Aanpassen naar je database naam

// Creëer een databaseverbinding
$mysqli = new mysqli($host, $username, $password, $database);

// Controleer de verbinding
if ($mysqli->connect_error) {
    die("Connection failed: " . $mysqli->connect_error);
}
// Debug-instelling
$debug = TRUE;

// Website versie
define('WEBSITE_VERSION', '1.0.0');

// Team name configureren
define('WEBSITE_TEAM', 'Company');

// Game name configureren
define('WEBSITE_GAME', 'Airhockey');

?>