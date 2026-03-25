<?php
session_start();
?>
<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/style.css">
    <script src="js/script.js"></script>
    <title>NetFish | Home</title>
</head>
<body>
    <header>
        <h1>NetFish</h1>
        <div class="topnav">
            <button class="hamburger" aria-label="Open menu">☰</button>
            <nav class="nav">
                <a href="index.php">Home</a>

                <?php if (isset($_SESSION['isAdmin']) && $_SESSION['isAdmin'] == 1): ?>
                    <a href="../admin/admin.php" style="color: #e50914; font-weight: bold;">Admin Panel</a>
                <?php endif; ?>

                <?php if (isset($_SESSION['user'])): ?>
                    <a href="../login&register/logout.php" style="color: white;">Logout (<?= htmlspecialchars($_SESSION['user']) ?>)</a>
                <?php else: ?>
                    <a href="../login&register/login.php">Login</a>
                <?php endif; ?>
            </nav>
        </div>
    </header>

    <div class="head" style="padding: 20px 40px; margin-top: 80px;">
        <h2>Top Videos</h2>
    </div>

    <div class="row-container" style="display: flex; flex-wrap: wrap; padding: 0 40px; gap: 20px;">
        <?php
        require_once '../php/connectdb.php';

        try {
            // Check if $conn exists (from connectdb.php)
            $videos = $conn->query("SELECT id, title, link FROM videos")->fetchAll(PDO::FETCH_ASSOC);

            if ($videos):
                foreach ($videos as $video):
                    // Determine image: replace .mp4 with .jpg
                    $imagePath = "../images/" . str_replace('.mp4', '.jpg', $video['link']);
                    
                    // Use placeholder if image doesn't exist
                    if (!file_exists($imagePath)) {
                        $imagePath = "../images/placeholder.jpg";
                    }
                    ?>
                    <div class="video-card" style="background: #1f1f1f; padding: 10px; border-radius: 8px;">
                        <a href="video.php?id=<?= $video['id'] ?>">
                            <img src="<?= htmlspecialchars($imagePath) ?>" 
                                 alt="<?= htmlspecialchars($video['title']) ?>" 
                                 style="width:200px; height:150px; object-fit: cover; border-radius: 4px;">
                        </a>
                        <h4 style="color: white; margin-top: 10px;"><?= htmlspecialchars($video['title']) ?></h4>
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