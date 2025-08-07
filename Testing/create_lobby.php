<?php
include 'db_connect.php';

header('Content-Type: application/json');

$response = ['success' => false, 'message' => ''];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $lobbyName = $_POST['lobby_name'] ?? '';
    $userId = $_POST['user_id'] ?? ''; // Assuming user is logged in and ID is available

    if (empty($lobbyName) || empty($userId)) {
        $response['message'] = 'Lobby name and user ID are required.';
    } else {
        try {
            // Assign the creator as White by default
            $stmt = $conn->prepare("INSERT INTO games (lobby_name, player_white_id, status) VALUES (:lobby_name, :player_white_id, 'waiting')");
            $stmt->bindParam(':lobby_name', $lobbyName);
            $stmt->bindParam(':player_white_id', $userId);
            $stmt->execute();
            $newGameId = $conn->lastInsertId();
            $response['success'] = true;
            $response['message'] = 'Lobby created successfully!';
            $response['game_id'] = $newGameId;
        } catch(PDOException $e) {
            $response['message'] = "Error creating lobby: " . $e->getMessage();
        }
    }
} else {
    $response['message'] = 'Invalid request method.';
}

echo json_encode($response);
?>