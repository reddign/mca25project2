<?php
session_start();
$_SESSION["LoggedIn"]="";
session_destroy();

header("location:index.php")
?>