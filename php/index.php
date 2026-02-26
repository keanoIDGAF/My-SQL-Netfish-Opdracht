<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/style.css">
    <body>
    <header>
        <h1>NetFish</h1>
        <div class="topnav">
        <button class="hamburger" aria-label="Open menu">
            ☰
        </button>

        <nav class="nav">
        <a href="index.php">Home</a>
        <a href="videos.php">Video's</a>
        <a href="mijnLijst.php">Mijn Lijst</a>
        <a href="login.php">Login</a>
        </nav>
        </header>

    <div class="head">
        <h2>Top Videos</h2>
    </div>

    <div class="row-container">
    <?php
    require_once '../php/connectdb.php';

    try {
        $stmt = $conn->query("SELECT id, title, link FROM videos");
        $videos = $stmt->fetchAll(PDO::FETCH_ASSOC);

        if (count($videos) > 0) {
            foreach ($videos as $video) {
                // pakt de videonaam (bijv. "skbidi.mp4") 
                // verandert de extensie naar .jpg voor de afbeelding
                $videoFilename = $video['link'];
                $imageFilename = str_replace('.mp4', '.jpg', $videoFilename);
                
                // Pad naar je afbeelding
                $imagePath = "../images/" . $imageFilename;

                // Check of de afbeelding wel echt bestaat, anders toon een placeholder
                if (!file_exists($imagePath)) {
                    $imagePath = "../images/placeholder.jpg";
                }
                ?>
                <div class="video-card">
                    <a href="video.php?id=<?php echo $video['id']; ?>">
                        <img src="<?php echo htmlspecialchars($imagePath); ?>" 
                             alt="<?php echo htmlspecialchars($video['title']); ?>" 
                             style="width:200px; height:150px; object-fit: cover;">
                    </a>
                    <h4><?php echo htmlspecialchars($video['title']); ?></h4>
                </div>
                <?php
            }
        } else {
            echo "<p>Geen video's gevonden.</p>";
        }
    } catch(PDOException $e) {
        echo "Fout: " . $e->getMessage();
    }
    ?>
</div>
</div>
    <script src="js/script.js"></script>
</body>
</html>
