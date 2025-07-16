<?php
require 'session_check.php';
require 'db.php';

header('Content-Type: application/json');

$userId = $_SESSION['user_id'];
$name = trim($_POST['name'] ?? '');
$members = json_decode($_POST['members'] ?? '[]');

if (empty($members)) {
    echo json_encode(['status' => 'error', 'message' => 'No members selected.']);
    exit;
}

$isGroup = !empty($name);
$members[] = $userId; // Add current user to the chat

// Avoid duplicates
$members = array_unique($members);

// Check if private chat already exists
if (!$isGroup && count($members) === 2) {
    sort($members);
    $check = $pdo->prepare("
        SELECT c.id
        FROM conversations c
        JOIN conversation_members cm1 ON cm1.conversation_id = c.id AND cm1.user_id = ?
        JOIN conversation_members cm2 ON cm2.conversation_id = c.id AND cm2.user_id = ?
        WHERE c.is_group = 0
        GROUP BY c.id
        HAVING COUNT(*) = 2
    ");
    $check->execute($members);
    if ($row = $check->fetch()) {
        echo json_encode(['status' => 'success', 'conversation_id' => $row['id']]);
        exit;
    }
}

// Create conversation
$stmt = $pdo->prepare("INSERT INTO conversations (name, is_group) VALUES (?, ?)");
$stmt->execute([$name ?: null, $isGroup]);
$conversationId = $pdo->lastInsertId();

// Add members
$insert = $pdo->prepare("INSERT INTO conversation_members (conversation_id, user_id) VALUES (?, ?)");
foreach ($members as $memberId) {
    $insert->execute([$conversationId, $memberId]);
}

echo json_encode(['status' => 'success', 'conversation_id' => $conversationId]);
