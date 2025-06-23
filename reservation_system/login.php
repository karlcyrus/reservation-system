<?php
include 'db_connection.php'; // connect to DB

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Check if user exists in the database
    $sql = "SELECT * FROM users WHERE username = ?";
    $stmt = $conn->prepare($sql); 
    $stmt->bind_param("s", $username); // "s" = string
    $stmt->execute();
    $result = $stmt->get_result();

    // Check if user was found
    if ($result->num_rows === 1) {
        $user = $result->fetch_assoc();

        // Compare passwords (later we’ll use hashed passwords!)
        if ($password === $user['password']) {
            header("Location: schedule.php"); 
            exit(); 
        } else {
            echo "Incorrect password.";
        }
    } else {
        echo "Username not found.";
    }

    $stmt->close();
    $conn->close();
}
?>
