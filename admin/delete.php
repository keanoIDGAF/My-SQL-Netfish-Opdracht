<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "netfish";

try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Controleren of er een ID in de URL staat
    if (isset($_GET['id'])) {
        $id = $_GET['id'];

        // 1. De DELETE query voorbereiden
        $sql = "DELETE FROM videos WHERE id = :id";
        $stmt = $conn->prepare($sql);
        
        // De variabele koppelen aan de placeholder
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);

        // Uitvoeren van de verwijdering
        $stmt->execute();

        // voor de eerstvolgende video die je toevoegt.
        $conn->query("ALTER TABLE videos AUTO_INCREMENT = 1");

        // Stuurt de gebruiker terug naar de tabel
        header("Location: admin.php?msg=verwijderd");
        exit();
    } else {
        header("Location: ../admin/admin.php");
        exit();
    }

} catch (PDOException $e) {
    echo "Fout bij verwijderen: " . $e->getMessage();
}
?>