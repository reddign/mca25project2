<?php
//check if id 2 has anything, if it's null then put the username there.
//check if id 3 has anything, if it's null then put the username there. 
//if both have something then kick the user back to the lobbies page.

//username - store in the table under turn id 2 if white or turn id 3 if black

require "../dbCreds.php";
$mysqli = new mysqli($servername,$username,$password,$database);
mysqli_query("Update chessGame1 SET 'players' = 'players'+1 WHERE id='1';");
$sqli = mysqli_query("SELECT * FROM chessGame1 WHERE id='1';");
while($row = mysqli_fetch_array($sqli)){
    $id = $row["id"];
    $players = $row["players"];
}

if($players = NULL || 0){ //If there are no players in the lobby
    echo "<script>
        alert('The lobby is empty.');
        let joinLobby1 = prompt('Do you wish to continue? Please respond with y or n.');

        if(joinLobby1 = y || Y || yes || Yes){
            window.location.href = 'https://chess.etownmca.com/ChessBoard/lobby1.php';

        }else{
            window.location.href = 'https://chess.etownmca.com/index.php';
        }
    </script>";
}else if($players = 1){ //If there is one player in the lobby
    echo "<script>
        let joinLobby2 = prompt('There is one player waiting. Do you wish to join? Please respond with y or n.');

        if(joinLobby1 = y || Y || yes || Yes){
            window.location.href = 'https://chess.etownmca.com/ChessBoard/lobby1.php';
        }else{
            window.location.href = 'https://chess.etownmca.com/index.php';
        }
    </script>";
}else{ //Lobby should already have 2 players.
    echo "<script>
        alert('Sorry, the lobby is full. Please try another lobby.')
        window.location.href = 'https://chess.etownmca.com/index.php';
    </script>";
}














?>