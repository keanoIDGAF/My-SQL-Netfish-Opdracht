<?php
// Maakt verbinding met de database
$conn = new PDO("mysql:host=localhost;dbname=netfish", "root", "");
// Zorgt dat databasefouten zichtbaar worden als uitzonderingen
$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

// De bestaande gegevens ophalen om in het formulier te tonen
// Haalt het ID op uit de URL (bijv. edit.php?id=12)
$id = $_GET['id'] ?? null;

if ($id) {
    // Zoekt de video op in de database op basis van het ID
    $stmt = $conn->prepare("SELECT * FROM videos WHERE id = ?");
    $stmt->execute([$id]);
    $video = $stmt->fetch(PDO::FETCH_ASSOC);
    
    // Als de video niet bestaat in de database, stop het script
    if (!$video) die("Video niet gevonden.");
}

// De gewijzigde gegevens opslaan na het versturen van het formulier
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Bereidt de UPDATE-query voor om de bestaande rij aan te passen
    $sql = "UPDATE videos SET length=?, title=?, leeftijd=?, link=?, genre=?, beschrijving=? WHERE id=?";
    
    // Voert de query uit met de nieuwe gegevens uit het formulier ($_POST)
    $conn->prepare($sql)->execute([
        $_POST['length'], 
        $_POST['title'], 
        $_POST['leeftijd'], 
        $_POST['link'], 
        $_POST['genre'], 
        $_POST['beschrijving'], 
        $_POST['id']
    ]);

    // Stuurt de gebruiker terug naar het overzicht met een succesmelding
    header("Location: admin.php?msg=aangepast");
    exit();
}
?>

<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <title>Video Bewerken</title>
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

        h2 { 
            color: #e50914; 
            margin-top: 0; 
            font-size: 24px; 
            text-align: center; 
        }

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
    </style>
</head>
<body>

    <div class="form-container">
        <h2>Video Bewerken</h2>
        <form method="POST">
            <input type="hidden" name="id" value="<?= $video['id'] ?>">

            <input type="text" name="title" placeholder="Titel" value="<?= htmlspecialchars($video['title']) ?>" required>
            <input type="text" name="length" placeholder="Duur (bijv. 1u 30m)" value="<?= htmlspecialchars($video['length']) ?>" required>
            <input type="number" name="leeftijd" placeholder="Leeftijd" value="<?= htmlspecialchars($video['leeftijd']) ?>" required>
            <input type="text" name="link" placeholder="Video Link" value="<?= htmlspecialchars($video['link']) ?>" required>
            <input type="text" name="genre" placeholder="Genre" value="<?= htmlspecialchars($video['genre']) ?>" required>
            <textarea name="beschrijving" placeholder="Beschrijving" rows="3" required><?= htmlspecialchars($video['beschrijving']) ?></textarea>
            
            <button type="submit" class="btn-submit">Wijzigingen Opslaan</button>
        </form>
        <a href="admin.php" class="back-link">← Terug naar overzicht</a>
    </div>

</body>
</html>