<?php
$host = getenv('MYSQL_HOST') ?: 'db';
$user = getenv('MYSQL_USER') ?: 'root';
$pass = getenv('MYSQL_PASSWORD') ?: 'root';
$db = getenv('MYSQL_DATABASE') ?: 'api_db';

$conn = new mysqli($host, $user, $pass, $db);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Ensure table exists
$sql = "CREATE TABLE IF NOT EXISTS url_shorter_db (
    id INT AUTO_INCREMENT PRIMARY KEY,
    original_url TEXT NOT NULL,
    short_code VARCHAR(10) NOT NULL UNIQUE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    clicks INT DEFAULT 0
)";

if (!$conn->query($sql)) {
    die("Error creating table: " . $conn->error);
}
?>