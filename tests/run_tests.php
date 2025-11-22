<?php
// Simple Test Suite for Acortador Ursol

function runTest($name, $callback)
{
    echo "Running test: $name ... ";
    try {
        $result = $callback();
        if ($result) {
            echo "\033[32mPASSED\033[0m\n";
        } else {
            echo "\033[31mFAILED\033[0m\n";
        }
    } catch (Exception $e) {
        echo "\033[31mERROR: " . $e->getMessage() . "\033[0m\n";
    }
}

// Test 1: Database Connection
runTest("Database Connection", function () {
    require __DIR__ . '/../db.php';
    return isset($conn) && !$conn->connect_error;
});

// Test 2: API Shorten Endpoint (Integration)
runTest("API Shorten URL", function () {
    $url = 'http://localhost:8000/api/shorten.php';
    $data = json_encode(['originalUrl' => 'https://www.example.com']);

    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
    curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);

    $response = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);

    $json = json_decode($response, true);

    return $httpCode === 200 && isset($json['shortUrl']) && isset($json['shortCode']);
});

// Test 3: API Invalid URL Validation
runTest("API Invalid URL Validation", function () {
    $url = 'http://localhost:8000/api/shorten.php';
    $data = json_encode(['originalUrl' => 'not-a-url']);

    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
    curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);

    $response = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);

    $json = json_decode($response, true);

    return $httpCode === 400 && isset($json['error']) && $json['error'] === 'Invalid URL format';
});

echo "\nTest Suite Completed.\n";
?>