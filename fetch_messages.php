<?php
require 'session_check.php';
require 'db.php';
header('Content-Type: application/json');

$userId = $_SESSION['user_id'];
$conversationId = (int) ($_GET['conversation_id'] ?? 0);

if ($conversationId === 0) {
    echo json_encode([]);
    exit;
}

// Ensure user is part of the conversation
$check = $pdo->prepare("SELECT 1 FROM conversation_members WHERE user_id = ? AND conversation_id = ?");
$check->execute([$userId, $conversationId]);
if (!$check->fetch()) {
    echo json_encode([]);
    exit;
}

$stmt = $pdo->prepare("
    SELECT m.message, m.created_at, u.username, 
           CASE WHEN m.user_id = ? THEN 1 ELSE 0 END AS is_self
    FROM messages m
    JOIN users u ON m.user_id = u.id
    WHERE m.conversation_id = ?
    ORDER BY m.created_at ASC
");
$stmt->execute([$userId, $conversationId]);
$messages = $stmt->fetchAll();

echo json_encode($messages);
