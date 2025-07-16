<?php
require 'session_check.php';
require 'db.php';
header('Content-Type: application/json');

$userId = $_SESSION['user_id'] ?? null;
$message = trim($_POST['message'] ?? '');
$conversationId = isset($_POST['conversation_id']) ? (int)$_POST['conversation_id'] : 0;

// Basic validations
if (!$userId) {
    echo json_encode(['status' => 'error', 'message' => 'User not authenticated']);
    exit;
}
if ($message === '') {
    echo json_encode(['status' => 'error', 'message' => 'Message is empty']);
    exit;
}
if (!$conversationId) {
    echo json_encode(['status' => 'error', 'message' => 'Conversation ID missing']);
    exit;
}

// Check if user is part of the conversation
$check = $pdo->prepare("SELECT 1 FROM conversation_members WHERE user_id = ? AND conversation_id = ?");
$check->execute([$userId, $conversationId]);
if (!$check->fetch()) {
    echo json_encode(['status' => 'error', 'message' => 'Unauthorized']);
    exit;
}

// Save the message
try {
    $stmt = $pdo->prepare("INSERT INTO messages (conversation_id, user_id, message, created_at) VALUES (?, ?, ?, NOW())");
    $stmt->execute([$conversationId, $userId, htmlspecialchars($message)]);
    echo json_encode(['status' => 'success']);
} catch (PDOException $e) {
    error_log("Message insert failed: " . $e->getMessage());
    echo json_encode(['status' => 'error', 'message' => 'Database error']);
}
