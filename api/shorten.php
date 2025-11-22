<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Content-Type');

require_once '../db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents('php://input'), true);
    $originalUrl = $data['originalUrl'] ?? '';

    if (empty($originalUrl)) {
        http_response_code(400);
        echo json_encode(['error' => 'URL is required']);
        exit;
    }

    // Generate Short Code (Simple random string)
    $shortCode = substr(str_shuffle("0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ"), 0, 6);

    $stmt = $conn->prepare("INSERT INTO url_shorter_db (original_url, short_code) VALUES (?, ?)");
    $stmt->bind_param("ss", $originalUrl, $shortCode);

    if ($stmt->execute()) {
        // Determine protocol and host
        $protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";
        $host = $_SERVER['HTTP_HOST'];

        // If running on localhost with php -S, it's just root. 
        // If in a subdirectory on a real server, we might need to adjust, but for now assume root or handled by .htaccess
        $shortUrl = $protocol . $host . "/" . $shortCode;

        echo json_encode([
            'originalUrl' => $originalUrl,
            'shortCode' => $shortCode,
            'shortUrl' => $shortUrl
        ]);
    } else {
        http_response_code(500);
        echo json_encode(['error' => 'Database error']);
    }

    $stmt->close();
} else {
    http_response_code(405); // Method Not Allowed
}

$conn->close();
?>