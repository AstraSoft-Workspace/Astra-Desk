<?php
// === Only handle POST ===
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    header('Content-Type: application/json');
    require_once 'db.php'; // connect using PDO as $pdo

    function respond($status, $message) {
        echo json_encode(['status' => $status, 'message' => $message]);
        exit;
    }

    // Sanitize & validate
    $username = trim($_POST['username'] ?? '');
    $email    = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';

    if (empty($username) || empty($email) || empty($password)) {
        respond('error', 'All fields are required.');
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        respond('error', 'Invalid email address.');
    }

    // Check for existing email
    $stmt = $pdo->prepare("SELECT id FROM users WHERE email = ?");
    $stmt->execute([$email]);
    if ($stmt->fetch()) {
        respond('error', 'Email is already registered.');
    }

    // Securely hash password
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    // Insert user
    try {
        $stmt = $pdo->prepare("INSERT INTO users (username, email, password) VALUES (?, ?, ?)");
        $stmt->execute([$username, $email, $hashedPassword]);
        respond('success', 'Registration successful.');
    } catch (PDOException $e) {
        error_log($e->getMessage());
        respond('error', 'Registration failed. Please try again.');
    }
}
?>
