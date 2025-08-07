<?php
include 'db_connect.php';

header('Content-Type: application/json');

$response = ['success' => false, 'message' => ''];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $gameId = $_POST['game_id'] ?? '';
    $userId = $_POST['user_id'] ?? ''; // Assuming user is logged in and ID is available

    if (empty($gameId) || empty($userId)) {
        $response['message'] = 'Game ID and User ID are required.';
    } else {
        try {
            // Check if the game exists and has a slot
            $stmt = $conn->prepare("SELECT player_white_id, player_black_id, status FROM games WHERE id = :game_id FOR UPDATE");
            $stmt->bindParam(':game_id', $gameId);
            $stmt->execute();
            $game = $stmt->fetch(PDO::FETCH_ASSOC);

            if (!$game) {
                $response['message'] = 'Game not found.';
            } else if ($game['player_white_id'] == $userId || $game['player_black_id'] == $userId) {
                $response['message'] = 'You are already in this lobby.';
            } else if ($game['player_white_id'] === null) {
                // Join as White
                $stmt = $conn->prepare("UPDATE games SET player_white_id = :user_id WHERE id = :game_id");
                $stmt->bindParam(':user_id', $userId);
                $stmt->bindParam(':game_id', $gameId);
                $stmt->execute();
                $response['success'] = true;
                $response['message'] = 'Joined as White!';
            } else if ($game['player_black_id'] === null) {
                // Join as Black
                $stmt = $conn->prepare("UPDATE games SET player_black_id = :user_id, status = 'in_progress' WHERE id = :game_id"); // Game can start if two players
                $stmt->bindParam(':user_id', $userId);
                $stmt->bindParam(':game_id', $gameId);
                $stmt->execute();
                $response['success'] = true;
                $response['message'] = 'Joined as Black! Game starting.';
            } else {
                $response['message'] = 'Lobby is full.';
            }
        } catch(PDOException $e) {
            $response['message'] = "Error joining lobby: " . $e->getMessage();
        }
    }
} else {
    $response['message'] = 'Invalid request method.';
}

echo json_encode($response);
?>