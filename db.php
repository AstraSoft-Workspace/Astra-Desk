<?php
// Database credentials
$host = 'localhost';
$dbname = 'astra_desk';
$user = 'root';
$pass = '22092209'; // ⚠️ Don't expose this publicly in production

// PDO options for secure connection
$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION, // Throw exceptions on errors
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,       // Return associative arrays
    PDO::ATTR_EMULATE_PREPARES   => false,                  // Use real prepared statements
];

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $user, $pass, $options);
} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode(['error' => 'Database connection failed.']);
    // You can also log the error internally: error_log($e->getMessage());
    exit;
}
?>
