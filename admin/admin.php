<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "netfish";

try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // READ: Data ophalen
    $stmt = $conn->prepare("SELECT * FROM videos");
    $stmt->execute();
?>
<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/style.css"></link>
</head>
<body>
    <header>
        <h1>NetFish</h1>
        <nav>
            <a href="../php/index.php">Home</a>
            <a href="../php/videos.php">Video's</a>
            <a href="../php/mijnLijst.php">Mijn Lijst</a>
            <a href="../login&register/login.php">Login</a>
        </nav>
    </header>

    <div class="admin-container">
        <h2>Videos editor</h2>
        <h4>Edit, Add, or Delete videos for the Homepage</h4>
        
        <a href="create.php" class="btn-add">+ Nieuwe Video Toevoegen</a>

        <table>
            <thead>
                <tr>
                    <th>Id</th>
                    <th>Lenght</th>
                    <th>Title</th>
                    <th>Leeftijd</th>
                    <th>Link</th>
                    <th>Genre</th>
                    <th>Beschrijving</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($rows = $stmt->fetch(PDO::FETCH_ASSOC)) { ?>
                <tr>
                    <td><?= htmlspecialchars($rows['id']) ?></td>
                    <td><strong><?= htmlspecialchars($rows['length']) ?></strong></td>
                    <td><?= htmlspecialchars($rows['title']) ?></td>
                    <td><?= htmlspecialchars($rows['leeftijd']) ?></td>
                    <td><?= htmlspecialchars($rows['link']) ?></td>
                    <td><?= htmlspecialchars($rows['genre']) ?></td>
                    <td><?= htmlspecialchars($rows['beschrijving']) ?></td>
                    <td>
                        <a href="update.php?id=<?= $rows['id'] ?>" class="btn btn-edit">Edit</a>
                        <a href="delete.php?id=<?= $rows['id'] ?>" class="btn btn-delete" onclick="return confirm('Weet je zeker?')">Wis</a>
                    </td>
                </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>

    <script src="js/script.js"></script>
</body>
</html>
<?php
} catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}
?>