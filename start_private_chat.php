<?php
require 'session_check.php';
require 'db.php';

header('Content-Type: application/json');

$currentUserId = $_SESSION['user_id'];
$otherUserId = $_POST['user_id'] ?? null;

if (!$otherUserId || $otherUserId == $currentUserId) {
    echo json_encode(['status' => 'error', 'message' => 'Invalid user']);
    exit;
}

// Check if conversation exists
$stmt = $pdo->prepare("
    SELECT c.id FROM conversations c
    JOIN conversation_members cm1 ON c.id = cm1.conversation_id
    JOIN conversation_members cm2 ON c.id = cm2.conversation_id
    WHERE c.is_group = 0 AND cm1.user_id = ? AND cm2.user_id = ?
");
$stmt->execute([$currentUserId, $otherUserId]);
$existing = $stmt->fetchColumn();

if ($existing) {
    echo json_encode(['status' => 'success', 'conversation_id' => $existing]);
    exit;
}

// Create new private conversation
$pdo->beginTransaction();
$pdo->exec("INSERT INTO conversations (is_group) VALUES (0)");
$conversationId = $pdo->lastInsertId();

$insert = $pdo->prepare("INSERT INTO conversation_members (conversation_id, user_id) VALUES (?, ?)");
$insert->execute([$conversationId, $currentUserId]);
$insert->execute([$conversationId, $otherUserId]);

$pdo->commit();

echo json_encode(['status' => 'success', 'conversation_id' => $conversationId]);
