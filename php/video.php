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
require_once '../php/connectdb.php'; 

$videoId = (int)($_GET['id'] ?? 1);

try {
    $stmt = $conn->prepare("SELECT * FROM videos WHERE id = ?"); 
    $stmt->execute([$videoId]);
    $video = $stmt->fetch();

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
    echo "Fout: " . $e->getMessage();
}
?>
</div>

</body>
</html>