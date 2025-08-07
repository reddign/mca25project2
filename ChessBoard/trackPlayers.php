<?php
session_start();

require "../dbCreds.php";

$mysqli = new mysqli($servername,$username,$password,$database);

$sql = "select turn from {$_SESSION['game']}";

//Send SQL and get results
$result = $mysqli -> query($sql);
$sqlresult = $result -> fetch_all(MYSQLI_ASSOC);
//$complete = false

switch($sqlresult[1]){
    case null:
        $sql = "update {$_SESSION['game']} set turn = {$_SESSION['username']} where id = 2;";
        break;
    case $_SESSION['username']:
        break;
    default:
    switch($sqlresult[2]){
        case null:
        $sql = "update {$_SESSION['game']} set turn = {$_SESSION['username']} where id = 3;";
        break;
    case $_SESSION['username']:
        break;
    default:
    header("location:../index.php");
    }
    }
    $result = $mysqli -> query($sql);

?>