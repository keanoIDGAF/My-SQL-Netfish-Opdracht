<?php
require_once '../php/connectdb.php';

$id = $_GET['id'] ?? null;

if ($id) {
    try {
        $stmt = $conn->prepare("DELETE FROM videos WHERE id = ?");
        $stmt->execute([$id]);

        $conn->query("ALTER TABLE videos AUTO_INCREMENT = 1");

        header("Location: admin.php?msg=verwijderd");
    } catch (PDOException $e) {
        die("Fout bij verwijderen: " . $e->getMessage());
    }
} else {
    header("Location: admin.php");
}
exit();