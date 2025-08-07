document.addEventListener('DOMContentLoaded', () => {
    fetchLobbies();
    // Poll for updates every few seconds
    setInterval(fetchLobbies, 3000); 
});

async function fetchLobbies() {
    const response = await fetch('get_lobbies.php');
    const data = await response.json();
    const lobbyListDiv = document.getElementById('lobbyList');
    lobbyListDiv.innerHTML = '';

    if (data.success && data.lobbies.length > 0) {
        data.lobbies.forEach(game => {
            const gameItem = document.createElement('div');
            gameItem.className = 'game-item';
            
            let statusText = `Status: ${game.status}`;
            let players = [];
            if (game.player_white_id) players.push(`White: User ${game.player_white_id}`);
            if (game.player_black_id) players.push(`Black: User ${game.player_black_id}`);
            
            gameItem.innerHTML = `
                <strong>${game.lobby_name} (ID: ${game.id})</strong><br>
                ${players.join(', ')}<br>
                ${statusText}
            `;

            const currentUserId = document.getElementById('currentUserId').value;
            const canJoin = (game.player_white_id != currentUserId && game.player_black_id != currentUserId) && 
                            (game.player_white_id === null || game.player_black_id === null) && 
                            game.status === 'waiting';

            if (canJoin) {
                const joinButton = document.createElement('button');
                joinButton.textContent = 'Join';
                joinButton.onclick = () => joinLobby(game.id, currentUserId);
                gameItem.appendChild(joinButton);
            } else if (game.status === 'in_progress' && (game.player_white_id == currentUserId || game.player_black_id == currentUserId)) {
                // If the game is in progress and the current user is a player, provide a "Go to Game" button
                const goToGameButton = document.createElement('button');
                goToGameButton.textContent = 'Go to Game';
                goToGameButton.onclick = () => window.location.href = `game.php?game_id=${game.id}`; 
                gameItem.appendChild(goToGameButton);
            }

            lobbyListDiv.appendChild(gameItem);
        });
    } else {
        lobbyListDiv.innerHTML = '<p>No active lobbies found. Create one!</p>';
    }
}

async function createLobby() {
    const lobbyName = document.getElementById('newGameName').value;
    const userId = document.getElementById('currentUserId').value;
    const messageDiv = document.getElementById('createLobbyMessage');

    if (!lobbyName) {
        messageDiv.textContent = 'Please enter a lobby name.';
        return;
    }

    const formData = new FormData();
    formData.append('lobby_name', lobbyName);
    formData.append('user_id', userId);

    const response = await fetch('create_lobby.php', {
        method: 'POST',
        body: formData
    });
    const data = await response.json();

    if (data.success) {
        messageDiv.textContent = data.message;
        document.getElementById('newGameName').value = ''; // Clear input
        fetchLobbies(); // Refresh the list
    } else {
        messageDiv.textContent = `Error: ${data.message}`;
    }
}

async function joinLobby(gameId, userId) {
    const formData = new FormData();
    formData.append('game_id', gameId);
    formData.append('user_id', userId);

    const response = await fetch('join_lobby.php', {
        method: 'POST',
        body: formData
    });
    const data = await response.json();

    alert(data.message);
    if (data.success) {
        fetchLobbies(); // Refresh the list
        // Potentially redirect to game if it started immediately after joining
        if (data.message.includes('Game starting')) {
            window.location.href = `game.php?game_id=${gameId}`; 
        }
    }
}