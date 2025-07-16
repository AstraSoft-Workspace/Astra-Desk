<?php
require 'session_check.php';
require 'db.php';

header('Content-Type: application/json');

$userId = $_SESSION['user_id'];

$sql = "
SELECT 
  c.id,
  c.name,
  c.is_group,
  GROUP_CONCAT(u.username SEPARATOR ', ') AS members
FROM conversations c
JOIN conversation_members cm ON c.id = cm.conversation_id
JOIN users u ON cm.user_id = u.id
WHERE c.id IN (
    SELECT conversation_id FROM conversation_members WHERE user_id = ?
)
GROUP BY c.id
ORDER BY c.created_at DESC
";

$stmt = $pdo->prepare($sql);
$stmt->execute([$userId]);

$conversations = [];

while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    $isGroup = (bool)$row['is_group'];

    if (!$isGroup) {
        // Split members and remove current user's name
        $allMembers = explode(', ', $row['members']);
        $otherMembers = array_filter($allMembers, fn($name) => $name !== $_SESSION['username']);
        $displayName = implode(', ', $otherMembers);
    } else {
        $displayName = $row['name'];
    }

    $conversations[] = [
        'id' => (int)$row['id'],
        'name' => $isGroup ? htmlspecialchars($displayName) : null,
        'members' => !$isGroup ? htmlspecialchars($displayName) : null,
        'is_group' => $isGroup
    ];
}

echo json_encode($conversations);
