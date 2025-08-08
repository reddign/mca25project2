<?php

require "../dbCreds.php";

$mysqli = new mysqli($servername,$username,$password,$database);

$sqlreset = '
update chessGame1 set a = "wr" where id = 1;
update chessGame1 set b = "wn" where id = 1;
update chessGame1 set c = "wb" where id = 1;
update chessGame1 set d = "wq" where id = 1;
update chessGame1 set e = "wk" where id = 1;
update chessGame1 set f = "wb" where id = 1;
update chessGame1 set g = "wn" where id = 1;
update chessGame1 set h = "wr" where id = 1;
update chessGame1 set a = "wp" where id = 2;
update chessGame1 set b = "wp" where id = 2;
update chessGame1 set c = "wp" where id = 2;
update chessGame1 set d = "wp" where id = 2;
update chessGame1 set e = "wp" where id = 2;
update chessGame1 set f = "wp" where id = 2;
update chessGame1 set g = "wp" where id = 2;
update chessGame1 set h = "wp" where id = 2;

update chessGame1 set a = "0" where id = 3;
update chessGame1 set b = "0" where id = 3;
update chessGame1 set c = "0" where id = 3;
update chessGame1 set d = "0" where id = 3;
update chessGame1 set e = "0" where id = 3;
update chessGame1 set f = "0" where id = 3;
update chessGame1 set g = "0" where id = 3;
update chessGame1 set h = "0" where id = 3;

update chessGame1 set a = "0" where id = 4;
update chessGame1 set b = "0" where id = 4;
update chessGame1 set c = "0" where id = 4;
update chessGame1 set d = "0" where id = 4;
update chessGame1 set e = "0" where id = 4;
update chessGame1 set f = "0" where id = 4;
update chessGame1 set g = "0" where id = 4;
update chessGame1 set h = "0" where id = 4;

update chessGame1 set a = "0" where id = 5;
update chessGame1 set b = "0" where id = 5;
update chessGame1 set c = "0" where id = 5;
update chessGame1 set d = "0" where id = 5;
update chessGame1 set e = "0" where id = 5;
update chessGame1 set f = "0" where id = 5;
update chessGame1 set g = "0" where id = 5;
update chessGame1 set h = "0" where id = 5;

update chessGame1 set a = "0" where id = 6;
update chessGame1 set b = "0" where id = 6;
update chessGame1 set c = "0" where id = 6;
update chessGame1 set d = "0" where id = 6;
update chessGame1 set e = "0" where id = 6;
update chessGame1 set f = "0" where id = 6;
update chessGame1 set g = "0" where id = 6;
update chessGame1 set h = "0" where id = 6;


update chessGame1 set a = "br" where id = 8;
update chessGame1 set b = "bn" where id = 8;
update chessGame1 set c = "bb" where id = 8;
update chessGame1 set d = "bq" where id = 8;
update chessGame1 set e = "bk" where id = 8;
update chessGame1 set f = "bb" where id = 8;
update chessGame1 set g = "bn" where id = 8;
update chessGame1 set h = "br" where id = 8;
update chessGame1 set a = "bp" where id = 7;
update chessGame1 set b = "bp" where id = 7;
update chessGame1 set c = "bp" where id = 7;
update chessGame1 set d = "bp" where id = 7;
update chessGame1 set e = "bp" where id = 7;
update chessGame1 set f = "bp" where id = 7;
update chessGame1 set g = "bp" where id = 7;
update chessGame1 set h = "bp" where id = 7;';

//Send SQL and get results
$result = $mysqli -> multi_query($sqlreset);



header("location: lobby1.php");
?>