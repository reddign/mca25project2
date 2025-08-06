<?php
session_start();
$_SESSION["lobby"] = "chessGame3";
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

    <form id="myForm" action="sendHere.php" method="post">
        <input type="hidden" id="jsVar1" name="startPos">
        <input type="hidden" id="jsVar2" name="endPos">
    </form>

    <script src = "lobby.js"></script>

</body>
</html>