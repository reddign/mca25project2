<?php

session_start()


require "../dbCreds.php";

$mysqli = new mysqli($servername,$username,$password,$database);

$sqlreset = `
update {$_SESSION['game']} set a = "wr" where id = 1;
update {$_SESSION['game']} set b = "wn" where id = 1;
update {$_SESSION['game']} set c = "wb" where id = 1;
update {$_SESSION['game']} set d = "wq" where id = 1;
update {$_SESSION['game']} set e = "wk" where id = 1;
update {$_SESSION['game']} set f = "wb" where id = 1;
update {$_SESSION['game']} set g = "wn" where id = 1;
update {$_SESSION['game']} set h = "wr" where id = 1;
update {$_SESSION['game']} set a = "wp" where id = 2;
update {$_SESSION['game']} set b = "wp" where id = 2;
update {$_SESSION['game']} set c = "wp" where id = 2;
update {$_SESSION['game']} set d = "wp" where id = 2;
update {$_SESSION['game']} set e = "wp" where id = 2;
update {$_SESSION['game']} set f = "wp" where id = 2;
update {$_SESSION['game']} set g = "wp" where id = 2;
update {$_SESSION['game']} set h = "wp" where id = 2;

update {$_SESSION['game']} set a = "0" where id = 3;
update {$_SESSION['game']} set b = "0" where id = 3;
update {$_SESSION['game']} set c = "0" where id = 3;
update {$_SESSION['game']} set d = "0" where id = 3;
update {$_SESSION['game']} set e = "0" where id = 3;
update {$_SESSION['game']} set f = "0" where id = 3;
update {$_SESSION['game']} set g = "0" where id = 3;
update {$_SESSION['game']} set h = "0" where id = 3;

update {$_SESSION['game']} set a = "0" where id = 4;
update {$_SESSION['game']} set b = "0" where id = 4;
update {$_SESSION['game']} set c = "0" where id = 4;
update {$_SESSION['game']} set d = "0" where id = 4;
update {$_SESSION['game']} set e = "0" where id = 4;
update {$_SESSION['game']} set f = "0" where id = 4;
update {$_SESSION['game']} set g = "0" where id = 4;
update {$_SESSION['game']} set h = "0" where id = 4;

update {$_SESSION['game']} set a = "0" where id = 5;
update {$_SESSION['game']} set b = "0" where id = 5;
update {$_SESSION['game']} set c = "0" where id = 5;
update {$_SESSION['game']} set d = "0" where id = 5;
update {$_SESSION['game']} set e = "0" where id = 5;
update {$_SESSION['game']} set f = "0" where id = 5;
update {$_SESSION['game']} set g = "0" where id = 5;
update {$_SESSION['game']} set h = "0" where id = 5;

update {$_SESSION['game']} set a = "0" where id = 6;
update {$_SESSION['game']} set b = "0" where id = 6;
update {$_SESSION['game']} set c = "0" where id = 6;
update {$_SESSION['game']} set d = "0" where id = 6;
update {$_SESSION['game']} set e = "0" where id = 6;
update {$_SESSION['game']} set f = "0" where id = 6;
update {$_SESSION['game']} set g = "0" where id = 6;
update {$_SESSION['game']} set h = "0" where id = 6;


update {$_SESSION['game']} set a = "br" where id = 8;
update {$_SESSION['game']} set b = "bn" where id = 8;
update {$_SESSION['game']} set c = "bb" where id = 8;
update {$_SESSION['game']} set d = "bq" where id = 8;
update {$_SESSION['game']} set e = "bk" where id = 8;
update {$_SESSION['game']} set f = "bb" where id = 8;
update {$_SESSION['game']} set g = "bn" where id = 8;
update {$_SESSION['game']} set h = "br" where id = 8;
update {$_SESSION['game']} set a = "bp" where id = 7;
update {$_SESSION['game']} set b = "bp" where id = 7;
update {$_SESSION['game']} set c = "bp" where id = 7;
update {$_SESSION['game']} set d = "bp" where id = 7;
update {$_SESSION['game']} set e = "bp" where id = 7;
update {$_SESSION['game']} set f = "bp" where id = 7;
update {$_SESSION['game']} set g = "bp" where id = 7;
update {$_SESSION['game']} set h = "bp" where id = 7;`;

//Send SQL and get results
$result = $mysqli -> multi_query($sqlreset);



header("location: {$_SESSION['lobby']}.php");
?>