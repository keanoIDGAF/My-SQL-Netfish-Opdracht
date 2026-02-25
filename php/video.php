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
        <a href="#">Series</a>
        <a href="#">Films</a>
    </nav>
    <div class="hamburger">☰</div>
</header>

<div class="video-wrapper">
    <?php
require_once '../php/connectdb.php'; 

try {
    $stmt = $conn->query("SELECT * FROM videos WHERE id=1;"); 
    $videos = $stmt->fetchAll();

    foreach ($videos as $video) {
    echo "<h3>" . htmlspecialchars($video['title']) . "</h3>";
    
    // Pas hier het pad aan naar de map waar je video's ECHT staan
    // Bijvoorbeeld: "videos/" . $video['link']
    $videoPath = "../videos/" . $video['link']; 

    echo "<video width='400' controls>";
    echo "<source src='" . htmlspecialchars($videoPath) . "' type='video/mp4'>";
    echo "Je browser ondersteunt de video tag niet.";
    echo "</video>";
    echo "<br><hr>";
}
} catch(PDOException $e) {
    echo "Fout bij ophalen videos: " . $e->getMessage();
}
?>

</div>

</body>
</html>