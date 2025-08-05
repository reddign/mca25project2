<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>testing chess</title>
    <link href="chessstyle.css" rel="stylesheet">
</head>
<body style="background-color: blanchedalmond;">
    <h1>This is chess</h1>
    <h2>I am john chess</h2>
<br><br><br><br><br><br><br><br><br><br><br><br>
    <table>
        <h1>Leaderboard</h1>
            <tr><th>Username</th><th>Wins</th></tr>
           
            <?php

require "scoreboarddb.php";                    
$mysqli = new mysqli($servername,$username,$password,$database);
               //make a SQL message
$sql = "select * FROM scores
JOIN users on (users.id=scores.id);

//send SQL and get result
$result = $mysqli -> query($sql);
$rows = $result -> fetch_all(MYSQLI_ASSOC);

//add loop
foreach($rows as $row){
    print("<tr><td>{$row['username']}</td><td>{$row['score']}</td></tr>");            
}
