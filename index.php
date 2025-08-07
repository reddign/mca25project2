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
