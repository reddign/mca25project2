<?php
require "../dbCreds.php";

$chessGame = "chessGame1";//Pull current chess game lobby from somewhere?
$piecePosition = "b1";//Get the position of the current piece
$requestPosition = "a2";//Get the position of the requested move (both the above will be entered as like a2)


$mysqli = new mysqli($servername,$username,$password,$database);

//set taken piece to attacking piece
$sql = "update '{$chessGame}' set SUBSTRING('{$requestPosition}',1,1)=(select SUBSTRING('{$piecePosition}',1,1)) where id= SUBSTRING('{$piecePosition}',2,1)) where id=SUBSTRING('{$requestPosition}',2,1);";
$result=$mysqli -> query($sql);

//set attacking piece's previous position to 0
$sql = "update '{$chessGame}' set SUBSTRING('{$piecePosition}',1,1)=0 where id=SUBSTRING('{$piecePosition}',1,1);";
$result=$mysqli -> query($sql);

//TODO: redirect user back to chess board
?>