<?php
require "../dbCreds.php";

$chessGame = "chessGame1";//Pull current chess game lobby from somewhere?
$piecePosition = "b1";//Get the position of the current piece
$requestPosition = "a2";//Get the position of the requested move (both the above will be entered as like a2)
$pieceCol = substr($piecePosition,0,1);
$pieceRow = substr($piecePosition,1,1);
$requestCol = substr($requestPosition,0,1);
$requestRow = substr($requestPosition,1,1);

$mysqli = new mysqli($servername,$username,$password,$database);

//set taken piece to attacking piece
$sql = "update {$chessGame} set {$requestCol}=(select {$pieceCol} from {$chessGame} where id= {$pieceRow}) where id={$requestRow};";
$result=$mysqli -> query($sql);
print_r($sql);

//set attacking piece's previous position to 0
$sql = "update {$chessGame} set {$pieceCol}=0 where id={$pieceRow};";
$result=$mysqli -> query($sql);
print_r($sql);

//TODO: redirect user back to chess board
?>