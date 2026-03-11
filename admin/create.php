<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "netfish";

$message = ""; 

try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        
        $length = $_POST['length'];
        $title = $_POST['title'];
        $leeftijd = $_POST['leeftijd'];
        $link = $_POST['link'];
        $genre = $_POST['genre'];
        $beschrijving = $_POST['beschrijving'];

        $sql = "INSERT INTO videos (length, title, leeftijd, link, genre, beschrijving) 
                VALUES (:length, :title, :leeftijd, :link, :genre, :beschrijving)";
        
        $stmt = $conn->prepare($sql);
        
        $stmt->bindParam(':length', $length);
        $stmt->bindParam(':title', $title);
        $stmt->bindParam(':leeftijd', $leeftijd);
        $stmt->bindParam(':link', $link);
        $stmt->bindParam(':genre', $genre);
        $stmt->bindParam(':beschrijving', $beschrijving);

        if ($stmt->execute()) {
            $new_id = $conn->lastInsertId();
            $message = "Video succesvol toegevoegd met ID: " . $new_id;
            header("refresh:2;url=../admin/admin.php");
        }
    }
} catch (PDOException $e) {
    $message = "Fout: " . $e->getMessage();
}
?>

<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <title>NetFish - Video Toevoegen</title>
    <link rel="stylesheet" href="../css/style.css">
    <style>
        body { 
            font-family: 'Segoe UI', Arial, sans-serif; 
            background-color: #141414; 
            color: white; 
            display: flex; 
            justify-content: center; 
            align-items: center; 
            min-height: 100vh; 
            margin: 0; 
        }
        .form-container { 
            background: #1f1f1f; 
            padding: 40px; 
            border-radius: 8px; 
            width: 100%; 
            max-width: 450px; 
            box-shadow: 0 10px 30px rgba(0,0,0,0.5); 
        }
        h2 { color: #e50914; margin-top: 0; font-size: 24px; text-align: center; }
        
        input, textarea { 
            width: 100%; 
            padding: 12px; 
            margin: 10px 0; 
            border: 1px solid #333; 
            background: #333; 
            color: white; 
            border-radius: 4px; 
            box-sizing: border-box; 
            font-size: 16px;
        }
        
        input:focus, textarea:focus {
            outline: none;
            border-color: #e50914;
        }

        .btn-submit { 
            background-color: #e50914; 
            color: white; 
            padding: 14px; 
            border: none; 
            border-radius: 4px; 
            cursor: pointer; 
            font-weight: bold; 
            width: 100%; 
            font-size: 16px;
            margin-top: 10px;
            transition: 0.3s;
        }
        .btn-submit:hover { 
            background-color: #b20710; 
        }
        
        .back-link { 
            display: block; 
            margin-top: 20px; 
            color: #aaa; 
            text-decoration: none; 
            text-align: center; 
            font-size: 14px; 
        }

        .back-link:hover { 
            color: #fff; 
            text-decoration: underline; 
        }
        
        .msg { 
            background: rgba(46, 204, 113, 0.2); 
            color: #2ecc71; 
            padding: 10px; 
            border-radius: 4px; 
            text-align: center; 
            margin-bottom: 20px; 
        }
    </style>
</head>
<body>

    <div class="form-container">
        <h2>Video Toevoegen</h2>
        
        <?php if ($message): ?>
            <div class="msg"><?php echo $message; ?></div>
        <?php endif; ?>

        <form method="POST">
            <input type="text" name="title" placeholder="Titel" required>
            <input type="text" name="length" placeholder="Duur (bijv. 1u 45m)" required>
            <input type="number" name="leeftijd" placeholder="Leeftijd" required>
            <input type="text" name="link" placeholder="Video URL / ID" required>
            <input type="text" name="genre" placeholder="Genre" required>
            <textarea name="beschrijving" placeholder="Beschrijving" rows="4" required></textarea>
            
            <button type="submit" class="btn-submit">Opslaan</button>
        </form>

        <a href="admin.php" class="back-link">← Terug naar overzicht</a>
    </div>

</body>
</html>