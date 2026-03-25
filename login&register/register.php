<?php
// Haalt de databaseverbinding op
require_once '../php/connectdb.php';

// Maakt een lege variabele aan voor statusberichten
$message = "";

// Controleert of de gebruiker het formulier heeft verstuurd (POST-methode)
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Haalt de ingevoerde gebruikersnaam en het wachtwoord op
    // De ?? '' zorgt ervoor dat de variabele leeg blijft als er niets is ingevuld
    $user = $_POST['username'] ?? '';
    $pass = $_POST['password'] ?? '';

    // Controleert of beide velden niet leeg zijn
    if (!empty($user) && !empty($pass)) {
        try {
            // Bereidt de SQL-query voor om een nieuwe gebruiker in te voegen
            $sql = "INSERT INTO users (username, password) VALUES (?, ?)";
            $stmt = $conn->prepare($sql);
            
            // Voert de query uit
            // Belangrijk: password_hash versleutelt het wachtwoord voordat het de database in gaat
            $stmt->execute([$user, password_hash($pass, PASSWORD_DEFAULT)]);
            
            // stuurt een succesbericht 
            $message = "Account succesvol aangemaakt!";
            
        } catch (PDOException $e) {
            // Als er iets misgaat, vang de fout op
            $message = "Error: Username might already exist.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Netfish | Register</title>
    <style>
        /* General Reset */
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: 'Segoe UI', Roboto, Helvetica, Arial, sans-serif;
            background-color: #141414;
            color: #ffffff;
            min-height: 100vh;
            display: flex;
            flex-direction: column; /* Stacks header on top of the content */
        }

        /* --- Header & Navigation --- */
        header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 20px 40px;
            background-color: #1f1f1f;
            width: 100%;
            position: absolute; /* Keeps it at the top without pushing the card down too far */
            top: 0;
            z-index: 1000;
        }

        header h1 {
            margin: 0;
            font-size: 28px;
            color: #e50914;
            letter-spacing: 1px;
        }

        header nav a {
            color: #fff;
            text-decoration: none;
            margin-left: 20px;
            font-weight: bold;
            font-size: 0.9rem;
            transition: color 0.3s;
        }

        header nav a:hover {
            color: #e50914;
        }

        /* --- Card Wrapper (Centers the card in the remaining space) --- */
        .main-content {
            flex: 1;
            display: flex;
            justify-content: center;
            align-items: center;
            padding-top: 80px; /* Prevents header from overlapping card content */
        }

        .auth-card {
            background-color: rgba(0, 0, 0, 0.75);
            padding: 60px;
            border-radius: 8px;
            width: 100%;
            max-width: 450px;
            box-shadow: 0 15px 25px rgba(0,0,0,0.5);
            text-align: left;
        }

        h2 {
            font-size: 2rem;
            margin-bottom: 25px;
            font-weight: 600;
        }

        .input-group {
            margin-bottom: 20px;
        }

        input[type="text"], 
        input[type="password"] {
            width: 100%;
            padding: 15px;
            background: #333;
            border: none;
            border-radius: 5px;
            color: white;
            font-size: 1rem;
        }

        input:focus {
            background: #454545;
            outline: 2px solid #e50914;
        }

        .btn-primary {
            width: 100%;
            padding: 15px;
            background-color: #e50914;
            color: white;
            border: none;
            border-radius: 5px;
            font-size: 1.1rem;
            font-weight: bold;
            cursor: pointer;
            margin-top: 10px;
            transition: background 0.3s ease;
        }

        .btn-primary:hover {
            background-color: #b20710;
        }

        .success-msg { color: #2ecc71; margin-bottom: 20px; font-size: 0.9rem; }
        .error-msg { color: #e74c3c; margin-bottom: 20px; font-size: 0.9rem; }

        .card-footer {
            margin-top: 30px;
            color: #737373;
        }

        .card-footer a {
            color: #fff;
            text-decoration: none;
        }

        .card-footer a:hover { text-decoration: underline; }

    </style>
</head>
<body>

<header>
    <h1>NetFish</h1>
    <nav class="nav">
        <a href="../php/index.php">Home</a>
        <a href="../login&register/login.php">Login</a>
    </nav>
</header>

<main class="main-content">
    <div class="auth-card">
        <h2>Create a Account</h2>

        <?php if ($message): ?>
            <div class="<?php echo $messageClass; ?>">
                <?php echo $message; ?>
            </div>
        <?php endif; ?>

        <form method="POST">
            <div class="input-group">
                <input type="text" name="username" placeholder="Username" required>
            </div>
            <div class="input-group">
                <input type="password" name="password" placeholder="Password" required>
            </div>
            <button type="submit" class="btn-primary">Register</button>
        </form>

        <div class="card-footer">
            <p>Already have an account? <a href="login.php">log in</a></p>
        </div>
    </div>
</main>

</body>
</html>