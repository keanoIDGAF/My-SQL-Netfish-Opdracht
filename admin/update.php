<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "netfish";

try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // 1. Haal de huidige gegevens op om in het formulier te tonen
    if (isset($_GET['id'])) {
        $id = $_GET['id'];
        $stmt = $conn->prepare("SELECT * FROM videos WHERE id = :id");
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        $game = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$game) {
            die("Video niet gevonden.");
        }
    }

    // 2. Verwerk de wijzigingen als er op de knop wordt geklikt
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $sql = "UPDATE videos SET 
                length = :length, 
                title = :title, 
                leeftijd = :leeftijd, 
                link = :link, 
                genre = :genre,
                beschrijving = :beschrijving 
                WHERE id = :id";
        
        $updateStmt = $conn->prepare($sql);
        $updateStmt->execute([
            ':length'      => $_POST['length'],
            ':title'  => $_POST['title'],
            ':leeftijd'      => $_POST['leeftijd'],
            ':link'     => $_POST['link'],
            ':genre' => $_POST['genre'],
            ':beschrijving' => $_POST['beschrijving'],
            ':id'        => $_POST['id']
        ]);

        header("Location: admin.php?msg=aangepast");
        exit();
    }
} catch (PDOException $e) {
    echo "Fout: " . $e->getMessage();
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
        /* De donkere achtergrond van Netfish */
        background-color: #141414; 
        padding: 40px; 
        display: flex; 
        flex-direction: column; 
        align-items: center; 
        color: #ffffff;
    }

    .form-container { 
        /* Donkergrijze kaart zoals de Netflix-tooltips/modals */
        background-color: #1f1f1f; 
        padding: 40px; 
        border-radius: 8px; 
        box-shadow: 0 10px 30px rgba(0,0,0,0.5); 
        width: 100%; 
        max-width: 450px; 
    }

    input { 
        width: 100%; 
        padding: 12px; 
        margin: 10px 0; 
        /* Donkere inputs met subtiele border */
        background-color: #333;
        border: 1px solid #444; 
        border-radius: 4px; 
        box-sizing: border-box; 
        color: white;
        font-size: 1rem;
    }

    input:focus {
        outline: none;
        border-bottom: 2px solid #e50914; /* Rode accentlijn bij typen */
        background-color: #454545;
    }

    .btn-update { 
        /* Het bekende Netflix rood */
        background-color: #e50914; 
        color: white; 
        border: none; 
        padding: 14px; 
        width: 100%; 
        cursor: pointer; 
        font-weight: bold; 
        font-size: 1.1rem;
        border-radius: 4px; 
        margin-top: 15px;
        transition: background-color 0.2s ease;
    }

    .btn-update:hover { 
        background-color: #b20710; /* Iets donkerder rood bij hover */
    }

    .back-link { 
        margin-top: 20px; 
        display: block; 
        color: #b3b3b3; 
        text-decoration: none; 
        font-size: 0.9rem; 
        transition: color 0.2s;
    }

    .back-link:hover {
        color: #ffffff;
        text-decoration: underline;
    }
</style>
</head>
<body>

    <div class="form-container">
        <h2>Video Bewerken</h2>
        <form method="POST" action="update.php">
            <input type="hidden" name="id" value="<?= $game['id'] ?>">

            <label>length</label>
            <input type="text" name="length" value="<?= htmlspecialchars($game['length']) ?>" required>
            
            <label>Title</label>
            <input type="text" name="title" value="<?= htmlspecialchars($game['title']) ?>" required>
            
            <label>Leeftijd</label>
            <input type="number" name="leeftijd" value="<?= htmlspecialchars($game['leeftijd']) ?>" required>
            
            <label>Link</label>
            <input type="text" name="link" value="<?= htmlspecialchars($game['link']) ?>" required>
            
            <label>Genre</label>
            <input type="text" name="genre" value="<?= htmlspecialchars($game['genre']) ?>" required>

            <label>Beschrijving</label>
            <input type="text" name="beschrijving" value="<?= htmlspecialchars($game['beschrijving']) ?>" required>
            
            <button type="submit" class="btn-update">Wijzigingen Opslaan</button>
        </form>
        <a href="admin.php" class="back-link">← Terug naar overzicht</a>
    </div>

</body>
</html>