<?php
require "../dbCreds.php";

$chessGame = //Pull current chess game lobby from somewhere?
$piecePosition = //Get the position of the current piece
$requestPosition = //Get the position of the requested move (both the above will be entered as like a2)


$mysqli = new mysqli($servername,$username,$password,$database);

//set taken piece to attacking piece
$sql = "update table '{$chessGame}' set '{substr($requestPosition,0,1)}'=(select '{substr($piecePosition,0,1)}' where id= '{substr($piecePosition,1,1)}') where id='{substr($requestPosition,1,1)}'"
$result=$mysqli -> query($sql);

//set attacking piece's previous position to 0
$sql = "update table '{$chessGame}' set '{substr($piecePosition,0,1)}'=0 where id='{substr($piecePosition,1,1)}'"
$result=$mysqli -> query($sql);

//TODO: redirect user back to chess board
?>