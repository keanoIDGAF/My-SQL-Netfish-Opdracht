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
    <link rel="stylesheet" href="../css/style.css">
    <style>
        /* Styles for the Modal */
        .modal {
            display: none;
            position: fixed;
            z-index: 9999;
            left: 0; top: 0;
            width: 100%; height: 100%;
            background-color: rgba(0,0,0,0.8);
            align-items: center;
            justify-content: center;
        }
        .modal-content {
            background-color: white;
            padding: 30px;
            border-radius: 10px;
            text-align: center;
            color: black;
            width: 350px;
        }
        .modal-buttons {
            display: flex;
            gap: 10px;
            justify-content: center;
            margin-top: 20px;
        }
        .btn-confirm-delete {
            background: #e50914;
            color: white !important;
            padding: 10px 20px;
            text-decoration: none;
            border-radius: 5px;
            font-weight: bold;
        }
        .btn-cancel {
            background: #ccc;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            cursor: pointer;
        }
    </style>
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
       
        <a href="create.php" class="btn btn-add">+ Nieuwe Video Toevoegen</a>
 
        <table>
            <thead>
                <tr>
                    <th>Id</th>
                    <th>Length</th>
                    <th>Title</th>
                    <th>Leeftijd</th>
                    <th>Link</th>
                    <th>Genre</th>
                    <th>Beschrijving</th>
                    <th>Acties</th>
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
                       
                        <button type="button"
                                class="btn btn-delete"
                                onclick="openModal('delete.php?id=<?= $rows['id'] ?>')">
                            Wis
                        </button>
                    </td>
                </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
 
    <div id="deleteModal" class="modal">
        <div class="modal-content">
            <h3>Weet je het zeker?</h3>
            <p>Deze video wordt definitief verwijderd.</p>
            <div class="modal-buttons">
                <button type="button" onclick="closeModal()" class="btn-cancel">Annuleren</button>
                <a id="confirmBtn" href="#" class="btn-confirm-delete">Verwijderen</a>
            </div>
        </div>
    </div>
 
    <script>
        function openModal(deleteUrl) {
            document.getElementById('confirmBtn').href = deleteUrl;
            document.getElementById('deleteModal').style.display = 'flex';
        }
 
        function closeModal() {
            document.getElementById('deleteModal').style.display = 'none';
        }
 
        // Close if you click outside the box
        window.onclick = function(event) {
            let modal = document.getElementById('deleteModal');
            if (event.target == modal) {
                closeModal();
            }
        }
    </script>
</body>
</html>
<?php
} catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}
?>