<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Netfish - Video Player</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>

<header>
    <h1>NETFISH</h1>
    <nav class="nav">
        <a href="../php/index.php">Home</a>
        <a href="../php/videos.php">Video's</a>
        <a href="../php/mijnLijst.php">Mijn Lijst</a>
        <a href="../login&register/login.php">Login</a>
    </nav>
    <div class="hamburger">☰</div>
</header>

<div class="video-wrapper">
<?php
// Haal de databaseverbinding op
require_once '../php/connectdb.php'; 

// Haalt het ID uit de URL (bijv. watch.php?id=3)
// De (int) zorgt ervoor dat het altijd een getal is (veiligheid tegen tekst-injecties)
// Als er geen ID is, wordt standaard video 1 gekozen
$videoId = (int)($_GET['id'] ?? 1);

try {
    // Zoekt de video in de database die hoort bij het opgevraagde ID
    $stmt = $conn->prepare("SELECT * FROM videos WHERE id = ?"); 
    $stmt->execute([$videoId]);
    $video = $stmt->fetch();

    // Controleert of er daadwerkelijk een video is gevonden
    if ($video): ?>
        <h3><?= htmlspecialchars($video['title']) ?></h3>
        
        <h5><?= htmlspecialchars($video['beschrijving']) ?></h5>
        
        <video width="100%" controls autoplay muted>
            <source src="../videos/<?= htmlspecialchars($video['link']) ?>" type="video/mp4">
            Je browser ondersteunt de video tag niet.
        </video>

    <?php else: ?>
        <p>Video niet gevonden.</p>
    <?php endif;

} catch(PDOException $e) {
    // Toont een foutmelding als de database-query mislukt
    echo "Fout: " . $e->getMessage();
}
?>
</div>

</body>
</html>