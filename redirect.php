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

        // Security: Validate protocol before redirecting
        $parsedUrl = parse_url($originalUrl);
        if (!isset($parsedUrl['scheme']) || !in_array(strtolower($parsedUrl['scheme']), ['http', 'https'])) {
            // Invalid protocol, redirect to home with error
            header("Location: /?error=invalid_url");
            exit;
        }

        // Increment clicks
        $updateStmt = $conn->prepare("UPDATE url_shorter_db SET clicks = clicks + 1 WHERE short_code = ?");
        $updateStmt->bind_param("s", $code);
        $updateStmt->execute();
        $updateStmt->close();

        $stmt->close();
        header("Location: " . $originalUrl);
        exit;
    } else {
        $stmt->close();
        // Redirect to home with error parameter
        header("Location: /?error=not_found");
        exit;
    }
} else {
    echo "No code provided";
}

$conn->close();
?>