<?php

require "../dbCreds.php";

$mysqli = new mysqli($servername,$username,$password,$database);

$sql = "select turn from $_SESSION['game']";

//Send SQL and get results
$result = $mysqli -> query($sql);
$sqlresult = $result -> fetch_all(MYSQLI_ASSOC);

print_r($sqlresult);

?>