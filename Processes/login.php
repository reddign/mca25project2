<?php
session_start();
// Process the login for the website.

$username = $_POST["username"];
$password = $_POST["password"];

$sql = "SELECT * FROM users
WHERE username='{$username}'
and password=MD5('{$password}');";

if($_SERVER['HTTP_HOST']=="127.0.0.1"){
    $mysqli = new mysqli("195.35.59.14","u121755072_chess","Mu4[XM@[D6&d","u121755072_chessdb");
}else{
    $mysqli = new mysqli("195.35.59.14","u121755072_chess","Mu4[XM@[D6&d","u121755072_chessdb");
}

if($mysqli->connect_errno){
    echo "Failed to connect to MySQL " . $mysqli->connect_errno;
}

$result = $mysqli -> query($sql);
$rows = $result -> fetch_all(MYSQLI_ASSOC);

if(count($rows)>0){
    $_SESSION["LoggedIn"]="YES";
    $_SESSION["UserID"]=$_POST["username"];
    header("location:../navbar.php");
}else{
    $_SESSION["LoggedIn"]="No";
    $_SESSION["UserID"]="";
    header("location:index.htm");
}
exit;
?>