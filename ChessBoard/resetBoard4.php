<?php

session_start()


require "../dbCreds.php";

$mysqli = new mysqli($servername,$username,$password,$database);

$sqlreset = '
update chessGame4 set a = "wr" where id = 1;
update chessGame4 set b = "wn" where id = 1;
update chessGame4 set c = "wb" where id = 1;
update chessGame4 set d = "wq" where id = 1;
update chessGame4 set e = "wk" where id = 1;
update chessGame4 set f = "wb" where id = 1;
update chessGame4 set g = "wn" where id = 1;
update chessGame4 set h = "wr" where id = 1;
update chessGame4 set a = "wp" where id = 2;
update chessGame4 set b = "wp" where id = 2;
update chessGame4 set c = "wp" where id = 2;
update chessGame4 set d = "wp" where id = 2;
update chessGame4 set e = "wp" where id = 2;
update chessGame4 set f = "wp" where id = 2;
update chessGame4 set g = "wp" where id = 2;
update chessGame4 set h = "wp" where id = 2;

update chessGame4 set a = "0" where id = 3;
update chessGame4 set b = "0" where id = 3;
update chessGame4 set c = "0" where id = 3;
update chessGame4 set d = "0" where id = 3;
update chessGame4 set e = "0" where id = 3;
update chessGame4 set f = "0" where id = 3;
update chessGame4 set g = "0" where id = 3;
update chessGame4 set h = "0" where id = 3;

update chessGame4 set a = "0" where id = 4;
update chessGame4 set b = "0" where id = 4;
update chessGame4 set c = "0" where id = 4;
update chessGame4 set d = "0" where id = 4;
update chessGame4 set e = "0" where id = 4;
update chessGame4 set f = "0" where id = 4;
update chessGame4 set g = "0" where id = 4;
update chessGame4 set h = "0" where id = 4;

update chessGame4 set a = "0" where id = 5;
update chessGame4 set b = "0" where id = 5;
update chessGame4 set c = "0" where id = 5;
update chessGame4 set d = "0" where id = 5;
update chessGame4 set e = "0" where id = 5;
update chessGame4 set f = "0" where id = 5;
update chessGame4 set g = "0" where id = 5;
update chessGame4 set h = "0" where id = 5;

update chessGame4 set a = "0" where id = 6;
update chessGame4 set b = "0" where id = 6;
update chessGame4 set c = "0" where id = 6;
update chessGame4 set d = "0" where id = 6;
update chessGame4 set e = "0" where id = 6;
update chessGame4 set f = "0" where id = 6;
update chessGame4 set g = "0" where id = 6;
update chessGame4 set h = "0" where id = 6;


update chessGame4 set a = "br" where id = 8;
update chessGame4 set b = "bn" where id = 8;
update chessGame4 set c = "bb" where id = 8;
update chessGame4 set d = "bq" where id = 8;
update chessGame4 set e = "bk" where id = 8;
update chessGame4 set f = "bb" where id = 8;
update chessGame4 set g = "bn" where id = 8;
update chessGame4 set h = "br" where id = 8;
update chessGame4 set a = "bp" where id = 7;
update chessGame4 set b = "bp" where id = 7;
update chessGame4 set c = "bp" where id = 7;
update chessGame4 set d = "bp" where id = 7;
update chessGame4 set e = "bp" where id = 7;
update chessGame4 set f = "bp" where id = 7;
update chessGame4 set g = "bp" where id = 7;
update chessGame4 set h = "bp" where id = 7;';

//Send SQL and get results
$result = $mysqli -> multi_query($sqlreset);



header("location: {$_SESSION['lobby']}.php");
?>