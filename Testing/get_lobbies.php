<?php
include 'db_connect.php';

header('Content-Type: application/json');

$response = ['success' => false, 'lobbies' => []];

try {
    $stmt = $conn->prepare("SELECT id, lobby_name, player_white_id, player_black_id, status FROM games WHERE status = 'waiting' OR status = 'in_progress'");
    $stmt->execute();
    $lobbies = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $response['success'] = true;
    $response['lobbies'] = $lobbies;
} catch(PDOException $e) {
    $response['message'] = "Error: " . $e->getMessage();
}

echo json_encode($response);
?>