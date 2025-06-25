<?php
// Get database credentials from environment variables
$host = getenv("DB_HOST");
$port = getenv("DB_PORT") ?: 5432; // Default to 5432 if not set
$user = getenv("DB_USER");
$pass = getenv("DB_PASS");
$dbname = getenv("DB_NAME");

// Check for missing variables
if (!$host || !$user || !$pass || !$dbname) {
    die("Missing one or more environment variables: DB_HOST, DB_USER, DB_PASS, DB_NAME.");
}

try {
    $conn = new PDO("pgsql:host=$host;port=$port;dbname=$dbname", $user, $pass);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    // echo "Connected successfully"; // Optional
} catch (PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}
?>
