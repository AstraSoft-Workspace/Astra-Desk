<?php
session_start();
require_once 'db.php';

header('Content-Type: application/json');

// Ensure user is authenticated
if (!isset($_SESSION['user_id'])) {
    echo json_encode(['status' => 'error', 'message' => 'Not authenticated']);
    exit;
}

$currentUserId = $_SESSION['user_id'];

// Update current user's last seen timestamp
$update = $pdo->prepare("UPDATE users SET last_seen = NOW() WHERE id = ?");
$update->execute([$currentUserId]);

// Fetch all other users
$stmt = $pdo->prepare("SELECT id, username, last_seen FROM users WHERE id != ? ORDER BY username ASC");
$stmt->execute([$currentUserId]);

$users = [];

while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    $lastSeen = strtotime($row['last_seen'] ?? '1970-01-01 00:00:00');
    $isOnline = (time() - $lastSeen <= 60); // online if active in last 60 seconds

    $users[] = [
        'id' => (int)$row['id'],
        'username' => htmlspecialchars($row['username']),
        'online' => $isOnline
    ];
}

echo json_encode(['status' => 'success', 'users' => $users]);
