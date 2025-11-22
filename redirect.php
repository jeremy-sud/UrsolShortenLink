<?php
require_once 'db.php';

$code = $_GET['code'] ?? '';

if ($code) {
    $stmt = $conn->prepare("SELECT original_url FROM url_shorter_db WHERE short_code = ?");
    $stmt->bind_param("s", $code);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($row = $result->fetch_assoc()) {
        $originalUrl = $row['original_url'];

        // Increment clicks
        $updateStmt = $conn->prepare("UPDATE url_shorter_db SET clicks = clicks + 1 WHERE short_code = ?");
        $updateStmt->bind_param("s", $code);
        $updateStmt->execute();
        $updateStmt->close();

        header("Location: " . $originalUrl);
        exit;
    } else {
        echo "URL not found";
    }

    $stmt->close();
} else {
    echo "No code provided";
}

$conn->close();
?>