<html lang="en">
    <head>
    
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Multiplayer Chess</title>
    <?php

    include "includes/header.php";
    include "includes/navbar.php";
    
    ?>
    <link href="chessstyle.css" rel="stylesheet">
</head>
<body style="background-color: blanchedalmond;">
    <br><br><br>
    <h1>Multiplayer Chess</h1>
    <h2>Welcome to our chess website. Click on one of the five chess pieces above to join a lobby! (Max 2 players per lobby)</h2>


<!-- add the 5 lobbies' buttons !-->
<?php
    session_start();
    if($_SESSION["LoggedIn"] != "YES"){
        header("location:loginregister/login.php");
        exit;
    }else{

    }
    ?>


<br><br><br><br><br><br>
    <table>
        <h1>Leaderboard</h1>
            <tr><th>Username</th><th>Wins</th></tr>
           
            
<?php
require "dbCreds.php";                    
$mysqli = new mysqli($servername,$username,$password,$database);
               //make a SQL message
$sql = "select userid,score FROM scores
JOIN users on (username=scores.userid);";

$result = $mysqli -> query($sql);
$rows = $result -> fetch_all(MYSQLI_ASSOC);


foreach($rows as $row){
    print("<tr><td>{$row['username']}</td><td>{$row['score']}</td></tr>");            
}
?>
