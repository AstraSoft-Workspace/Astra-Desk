<?php
require 'session_check.php';
require 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['conversation_id'])) {
    $userId = $_SESSION['user_id'];
    $conversationId = (int) $_POST['conversation_id'];

    $sql = "UPDATE messages_read SET is_read = 1 
            WHERE conversation_id = ? AND user_id = ?";

    // If you're storing reads in a separate table
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$conversationId, $userId]);

    echo json_encode(['status' => 'success']);
} else {
    echo json_encode(['status' => 'error', 'message' => 'Invalid request']);
}
?>
