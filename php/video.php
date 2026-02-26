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
        <a href="index.php">Home</a>
        <a href="videos.php">Video's</a>
        <a href="mijnLijst.php">Mijn Lijst</a>
        <a href="login.php">Login</a>
    </nav>
    <div class="hamburger">☰</div>
</header>

<div class="video-wrapper">
<?php
require_once '../php/connectdb.php'; 

// 1. Controleer of er een ID is meegegeven in de URL, anders standaard naar id 1
$videoId = isset($_GET['id']) ? (int)$_GET['id'] : 1;

try {
    // 2. Gebruik een placeholder (?) om SQL-injection te voorkomen
    $stmt = $conn->prepare("SELECT * FROM videos WHERE id = ?"); 
    $stmt->execute([$videoId]);
    $video = $stmt->fetch();

    // 3. Controleer of de video wel bestaat in de database
    if ($video) {
        echo "<h3>" . htmlspecialchars($video['title']) . "</h3>";
        
        $videoPath = "../videos/" . $video['link']; 

        echo "<video width='100%' controls autoplay>";
        echo "<source src='" . htmlspecialchars($videoPath) . "' type='video/mp4'>";
        echo "Je browser ondersteunt de video tag niet.";
        echo "</video>";
    } else {
        echo "<p>Video niet gevonden.</p>";
    }

} catch(PDOException $e) {
    echo "Fout bij ophalen video: " . $e->getMessage();
}
?>
</div>

</div>

</body>
</html>