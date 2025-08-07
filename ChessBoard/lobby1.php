<?php
session_start();
$_SESSION["game"] = "chessGame1";
$_SESSION["lobby"] = "lobby1";
?>


<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Super Cool Chess</title>
    
</head>
<body>
    <style>
            body {
                background-image: url('../chessImages/wood.jpg'); 
                background-repeat: no-repeat; 
                background-size: cover; 
                background-position: center; 
                background-attachment: fixed; 
            }
        </style>
    <p2>    
        <!-- I had to get rid of move processor being called here. I don't think it was neccessary -->
    <?php
          include "../includes/header.php";
          include "../includes/navbar2.php";
    ?>
    </p2>
    
    <canvas style="border:2px solid #000000;background-color: grey; display: block; margin-left: auto; margin-right: auto;" width = "480;" height = "480;"
    onmousedown="selectPiece(event);"
    ></canvas>

    <br>
    <button onclick="displayPieces(event)">Start Game</button>
    <img style="height: 0px" src="../chessImages/wPawn.png" id="whitePawn" loading="lazy">
    <img style="height: 0px" src="../chessImages/bPawn.png" id="blackPawn" loading="lazy">
    <img style="height: 0px" src="../chessImages/wBishop.png" id="whiteBishop" loading="lazy">
    <img style="height: 0px" src="../chessImages/bBishop.png" id="blackBishop" loading="lazy">
    <img style="height: 0px" src="../chessImages/wKnight.png" id="whiteKnight" loading="lazy">
    <img style="height: 0px" src="../chessImages/bKnight.png" id="blackKnight" loading="lazy">
    <img style="height: 0px" src="../chessImages/wRook.png" id="whiteRook" loading="lazy">
    <img style="height: 0px" src="../chessImages/bRook.png" id="blackRook" loading="lazy">
    <img style="height: 0px" src="../chessImages/wQueen.png" id="whiteQueen" loading="lazy">
    <img style="height: 0px" src="../chessImages/bQueen.png" id="blackQueen" loading="lazy">
    <img style="height: 0px" src="../chessImages/wKing.png" id="whiteKing" loading="lazy">
    <img style="height: 0px" src="../chessImages/bKing.png" id="blackKing" loading="lazy">


<?php
require "../dbCreds.php";
require "trackPlayer.php";

$mysqli = new mysqli($servername,$username,$password,$database);

$sqlboard = "select a as '0',b as '1',c as '2',d as '3',e as '4',f as '5',g as '6',h as '7' from {$_SESSION['game']};";

//Send SQL and get results
$result = $mysqli -> query($sqlboard);
$sqlresult = $result -> fetch_all(MYSQLI_ASSOC);

$jsonBoard= json_encode($sqlresult);

?>


    <!-- a script called sendHere was being called as the action in one of the versions. I chose to get rid of it -->
    <form id="myForm" action="moveProcessor.php" method="post">
        <input type="hidden" id="jsVar1" name="startPos">
        <input type="hidden" id="jsVar2" name="endPos">
    </form>
    <!-- I don't know what jsBoard is, but I kept it -->
    <script>   var jsBoard = <?php echo $jsonBoard; ?>;  </script>
    <script src = "lobby.js"></script>

</body>
</html>