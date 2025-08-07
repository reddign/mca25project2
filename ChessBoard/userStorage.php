<?php
//check if id 2 has anything, if it's null then put the username there.
//check if id 3 has anything, if it's null then put the username there. 
//if both have something then kick the user back to the lobbies page.

//username - store in the table uder turn id 2 if white or turn id 3 if black

require "../dbcreds.php";

if(__){ //IF there are no players in the lobby
    echo "<script>
        alert('The lobby is empty.');
        let joinLobby1 = prompt('Do you wish to continue? Please respond with y or n.');

        if(joinLobby1 = y || Y || yes || Yes){
            continue();
        }else{
            exit;    
        }

        function continue(){
            
        }
    </script>";
}else if(__){ //IF there is one player in the lobby
    echo "<script>
        let joinLobby2 = prompt('There is one player waiting. Do you wish to join? Please respond with y or n.');

        if(joinLobby1 = y || Y || yes || Yes){
            continue();
        }else{
            exit;    
        }

        function continue(){
            
        }
    </script>";
}else{ //Lobby should already have 2 players.
    echo "<script>
        alert('Sorry, the lobby is full. Please try another lobby.')
        exit;
    </script>";
}














?>