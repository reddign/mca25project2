<?php
require "dbCreds.php";

$mysqli = new mysqli($servername,$username,$password,$database);

$sqlboard = "select a as '0',b as '1',c as '2',d as '3',e as '4',f as '5',g as '6',h as '7' from chessGame1;";

//Send SQL and get results
$result = $mysqli -> query($sqlboard);
$sqlresult = $result -> fetch_all(MYSQLI_ASSOC);

$jsonBoard= json_encode($sqlresult);

?>



<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Super Cool Chess</title>
    
</head>
<body>
    <p2>
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
    <img style="height: 0px" src="../chessImages/wPawn.png" id="whitePawn">
    <img style="height: 0px" src="../chessImages/bPawn.png" id="blackPawn">
    <img style="height: 0px" src="../chessImages/wBishop.png" id="whiteBishop">
    <img style="height: 0px" src="../chessImages/bBishop.png" id="blackBishop">
    <img style="height: 0px" src="../chessImages/wKnight.png" id="whiteKnight">
    <img style="height: 0px" src="../chessImages/bKnight.png" id="blackKnight">
    <img style="height: 0px" src="../chessImages/wRook.png" id="whiteRook">
    <img style="height: 0px" src="../chessImages/bRook.png" id="blackRook">
    <img style="height: 0px" src="../chessImages/wQueen.png" id="whiteQueen">
    <img style="height: 0px" src="../chessImages/bQueen.png" id="blackQueen">
    <img style="height: 0px" src="../chessImages/wKing.png" id="whiteKing">
    <img style="height: 0px" src="../chessImages/bKing.png" id="blackKing">


    <script src = "lobby.js"></script>

    <form id="myForm" action="moveProcessor.php" method="post">
        <input type="hidden" id="jsVar1" name="startPos">
        <input type="hidden" id="jsVar2" name="endPos">
    </form>

    <script>   var jsBoard = <?php echo $jsonBoard; ?>;  </script>
    <script src = "lobby.js"></script>

</body>
</html>