<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/style.css">
    <script src="js/script.js"></script>
</head>
<body>
    <header>
        <h1>NetFish</h1>
        <div class="topnav">
            <button class="hamburger" aria-label="Open menu">☰</button>
            <nav class="nav">
                <a href="../php/index.php">Home</a>
                <a href="../php/videos.php">Video's</a>
                <a href="../php/mijnLijst.php">Mijn Lijst</a>
                <a href="../login&register/login.php">Login</a>
            </nav>
        </div>
    </header>

    <div class="head">
        <h2>Top Videos</h2>
    </div>

    <div class="row-container">
        <?php
        require_once '../php/connectdb.php';

        try {
            $videos = $conn->query("SELECT id, title, link FROM videos")->fetchAll(PDO::FETCH_ASSOC);

            if ($videos):
                foreach ($videos as $video):
                    // Bepaal de afbeelding: vervang .mp4 door .jpg
                    $imagePath = "../images/" . str_replace('.mp4', '.jpg', $video['link']);
                    
                    // Gebruik placeholder als de afbeelding niet bestaat
                    if (!file_exists($imagePath)) {
                        $imagePath = "../images/placeholder.jpg";
                    }
                    ?>
                    <div class="video-card">
                        <a href="video.php?id=<?= $video['id'] ?>">
                            <img src="<?= htmlspecialchars($imagePath) ?>" 
                                 alt="<?= htmlspecialchars($video['title']) ?>" 
                                 style="width:200px; height:150px; object-fit: cover;">
                        </a>
                        <h4><?= htmlspecialchars($video['title']) ?></h4>
                    </div>
                <?php endforeach; 
            else: ?>
                <p>Geen video's gevonden.</p>
            <?php endif; 

        } catch(PDOException $e) {
            echo "Fout: " . $e->getMessage();
        }
        ?>
    </div>
</body>
</html>