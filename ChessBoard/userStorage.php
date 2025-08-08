<?php
//check if id 2 has anything, if it's null then put the username there.
//check if id 3 has anything, if it's null then put the username there. 
//if both have something then kick the user back to the lobbies page.

//username - store in the table uder turn id 2 if white or turn id 3 if black

require "../dbcreds.php";
$mysqli = new mysqli($servername,$username,$password,$database);
//The Following lines return errors because we use sqli NOT sql
mysql_query("Update chessGame1 SET 'players' = 'players'+1 WHERE id='1';");
$sql = mysql_query("SELECT * FROM chessGame1 WHERE id='1';");
while($row = mysql_fetch_array($sql)){
    $id = $row["id"];
    $players = $row["players"];
}
//Those afformentioned errors aren't showing up because continue is not a name for a function you can use.
//This function name needs changed
function continue(){
    header("location:lobby1.php");
}

function home(){
    header("location:../index.php");
}

if($players = NULL){ //If there are no players in the lobby
    echo "<script>
        alert('The lobby is empty.');
        let joinLobby1 = prompt('Do you wish to continue? Please respond with y or n.');

        if(joinLobby1 = y || Y || yes || Yes){
            continue();
        }else{
            exit;    
        }
    </script>";
}else if($players = 1){ //If there is one player in the lobby
    echo "<script>
        let joinLobby2 = prompt('There is one player waiting. Do you wish to join? Please respond with y or n.');

        if(joinLobby1 = y || Y || yes || Yes){
            continue();
        }else{
            exit;    
        }
    </script>";
}else{ //Lobby should already have 2 players.
    echo "<script>
        alert('Sorry, the lobby is full. Please try another lobby.')
        exit;
    </script>";
}














?>