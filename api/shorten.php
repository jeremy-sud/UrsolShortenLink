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

    if (!filter_var($originalUrl, FILTER_VALIDATE_URL)) {
        http_response_code(400);
        echo json_encode(['error' => 'Invalid URL format']);
        exit;
    }

    // Security: Ensure protocol is http or https
    $parsedUrl = parse_url($originalUrl);
    if (!isset($parsedUrl['scheme']) || !in_array(strtolower($parsedUrl['scheme']), ['http', 'https'])) {
        http_response_code(400);
        echo json_encode(['error' => 'Only HTTP and HTTPS URLs are allowed']);
        exit;
    }

    // Generate Short Code (Simple random string) with retry logic
    $maxRetries = 5;
    $retryCount = 0;
    $success = false;
    $shortCode = '';

    while ($retryCount < $maxRetries && !$success) {
        $shortCode = substr(str_shuffle("0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ"), 0, 6);

        $stmt = $conn->prepare("INSERT INTO url_shorter_db (original_url, short_code) VALUES (?, ?)");
        $stmt->bind_param("ss", $originalUrl, $shortCode);

        try {
            if ($stmt->execute()) {
                $success = true;
            }
        } catch (mysqli_sql_exception $e) {
            // Check for duplicate entry error code (1062)
            if ($e->getCode() == 1062) {
                $retryCount++;
                continue;
            } else {
                throw $e;
            }
        }
        $stmt->close();
    }

    if ($success) {
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
        echo json_encode(['error' => 'Failed to generate unique code. Please try again.']);
    }
} else {
    http_response_code(405); // Method Not Allowed
}

$conn->close();
?>