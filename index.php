<?php
include 'db_connection.php'; // Connect to PostgreSQL using PDO
session_start();

$error = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';

    $sql = "SELECT * FROM users WHERE username = ?";
    $stmt = $conn->prepare($sql);
    $stmt->execute([$username]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user) {
        // You can use password_verify() if using hashed passwords
        if ($password === $user['password']) {
            header("Location: schedule.php");
            exit();
        } else {
            $error = "Incorrect password.";
        }
    } else {
        $error = "Username not found.";
    }
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <link href="https://fonts.googleapis.com/css2?family=Quicksand:wght@500;700&display=swap" rel="stylesheet">
    <title>Login</title>
</head>
<body>
   <div class="navbar">
        <div class="logo">MediPet</div>
        <div class="nav-links">
            <a href="#">Home</a>
            <a href="#">Service</a>
            <a href="#">About Us</a>
        </div>
    </div>
    <div class="hp_background"> 
        <div class="form_container">
            <h1>Login</h1>
            <?php if (!empty($error)): ?>
                <p style="color: red; text-align: center;"><?= htmlspecialchars($error) ?></p>
            <?php endif; ?>
            <form method="POST" action="">
                <div class="form_input">
                    <label for="username">Username:</label>
                    <input type="text" name="username" id="username" required placeholder="Username">
                </div>

                <div class="form_input">
                    <label for="password">Password:</label>
                    <input type="password" name="password" id="password" required placeholder="Password">
                </div>

                <button type="submit" class="login_button">Login</button>
            </form>
        </div>
    </div>  
</body>
</html>
