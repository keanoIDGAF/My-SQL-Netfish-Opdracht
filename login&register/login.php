<?php
session_start();
require_once '../php/connectdb.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user = $_POST['username'] ?? '';
    $pass = $_POST['password'] ?? '';

    $stmt = $conn->prepare("SELECT * FROM users WHERE username = ?");
    $stmt->execute([$user]);
    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($row && password_verify($pass, $row['password'])) {
        $_SESSION['user'] = $row['username'];
        
        // Save the admin status in the session (0 or 1)
        $_SESSION['isAdmin'] = $row['isAdmin'];

        if ($_SESSION['isAdmin'] == 1) {
            header("Location: ../php/index.php");
        } else {
            header("Location: ../php/index.php");
        }
        exit;
    } 
    
    $error = "Invalid username or password.";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Netfish - Login</title>
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
            flex-direction: column; /* Stacks header on top */
        }

        /* --- Header & Navigation (Matches Register) --- */
        header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 20px 40px;
            background-color: #1f1f1f;
            width: 100%;
            position: absolute; 
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

        /* --- Main Content Area (Centers the card) --- */
        .main-content {
            flex: 1;
            display: flex;
            justify-content: center;
            align-items: center;
            padding-top: 80px; /* Space for the header */
        }

        .login-container {
            background-color: rgba(0, 0, 0, 0.75);
            padding: 60px;
            border-radius: 8px;
            width: 100%;
            max-width: 450px;
            box-shadow: 0 15px 25px rgba(0,0,0,0.5);
        }

        h2 {
            margin-bottom: 25px;
            font-size: 2rem;
            font-weight: 600;
        }

        input[type="text"], 
        input[type="password"] {
            width: 100%;
            padding: 15px;
            margin-bottom: 20px;
            border: none;
            border-radius: 5px;
            background: #333;
            color: white;
            font-size: 1rem;
        }

        input:focus {
            background: #454545;
            outline: 2px solid #e50914;
        }

        button {
            width: 100%;
            padding: 15px;
            border: none;
            border-radius: 5px;
            background-color: #e50914;
            color: white;
            font-size: 1.1rem;
            font-weight: bold;
            cursor: pointer;
            transition: background 0.3s ease;
        }

        button:hover {
            background-color: #b20710;
        }

        .error-msg {
            background: #e87c03;
            color: white;
            padding: 12px;
            border-radius: 4px;
            font-size: 0.9rem;
            margin-bottom: 20px;
        }

        .footer-text {
            text-align: center; 
            margin-top: 25px;
            color: #737373;
        }

        .footer-text a {
            color: white;
            text-decoration: none;
        }

        .footer-text a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>

<header>
    <h1>NetFish</h1>
    <nav class="nav">
        <a href="../php/index.php">Home</a>
        <a href="../php/videos.php">Video's</a>
        <a href="../php/mijnLijst.php">Mijn Lijst</a>
        <a href="../login&register/login.php">Login</a>
    </nav>
</header>

<main class="main-content">
    <div class="login-container">
        <h2>Log In</h2>
        
    <?php if (!empty($error)): ?>
        <p class="error-msg"><?= $error; ?></p>
    <?php endif; ?>

        <form method="POST">
            <input type="text" name="username" placeholder="Username" required autofocus>
            <input type="password" name="password" placeholder="Password" required>
            <button type="submit">Login</button>
        </form>

        <div class="footer-text">
            <span>New to Netfish?</span> 
            <a href="register.php">Create a account</a>
        </div>
    </div>
</main>

</body>
</html>