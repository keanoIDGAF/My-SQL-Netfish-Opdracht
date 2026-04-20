<?php
// Haalt de databaseverbinding op
require_once '../php/connectdb.php';

// Haalt het ID van de video op uit de URL (bijv. delete.php?id=5)
// De ?? null zorgt dat $id 'null' is als er geen ID is meegegeven
$id = $_GET['id'] ?? null;

// Controleert of er een geldig ID is gevonden
if ($id) {
    try {
        // Bereidt de DELETE-query voor om de video met dit specifieke ID te verwijderen
        $stmt = $conn->prepare("DELETE FROM videos WHERE id = ?");
        $stmt->execute([$id]);

        // Dit vult geen gaten in je ID-lijst op, maar zorgt dat de volgende
        // nieuwe video het eerstvolgende logische nummer krijgt.
        $conn->query("ALTER TABLE videos AUTO_INCREMENT = 1");

        // Stuurt de gebruiker terug naar het admin-overzicht met een succesmelding
        header("Location: admin.php?msg=verwijderd");
    } catch (PDOException $e) {
        // Als er iets misgaat, stop het script en toon de foutmelding
        die("Fout bij verwijderen: " . $e->getMessage());
    }
} else {
    // Als er geen ID in de URL stond, stuur de gebruiker direct terug naar de admin-pagina
    header("Location: admin.php");
}

// Sluit het script altijd af na een header-omleiding
exit();