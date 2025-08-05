<?php
// Get data from the posted variables

$firstName = $_POST["first_name"];
$lastName = $_POST["last_name"];
$email = $_POST["sign_up_email"];
$username = $_POST["sign_up_username"];
$password = $_POST["sign_up_password"];

$sql = "INSERT INTO users
(firstName,lastName,email,username,password)
VALUES
('{$firstName}','{$lastName}',
'{$email}','{$username}',MD5('{$password}'))";

if($_SERVER['HTTP_HOST']=="127.0.0.1"){
    $mysqli = new mysqli("195.35.59.14","u121755072_chess1","Mu4[XM@[D6&d","u121755072_chessdb");
}

if($mysqli->connect_errno){
    echo "Failed to connect to MySQL: " . $MYSQLI->connect_errno;
}
$stmt = $mysqli->prepare($sql);
$stmt->execute();

header("location:../login.php");
exit;

?>