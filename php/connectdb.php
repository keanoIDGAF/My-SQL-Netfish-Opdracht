<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "netfish";

try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    // Verwijder hier de echo "Connected successfully" voor een schone output
} catch(PDOException $e) {
    die("Verbinding mislukt: " . $e->getMessage());
}
// GEEN $conn = null; hier!
?>