<?php
session_start();
require "../dbCreds.php";

$mysqli = new mysqli($servername,$username,$password,$database);

$sqlboard = "select a as '0',b as '1',c as '2',d as '3',e as '4',f as '5',g as '6',h as '7' from {$_SESSION['game']};";

//Send SQL and get results
$result = $mysqli -> query($sqlboard);
$currentBoardState = $result -> fetch_all(MYSQLI_ASSOC);

// $currentBoardState=[
//     ["wr","wn","wb","wq","wk","wb","wn","wr"], //row 0
//     ["wp","wp","wp","wp","wp","wp","wp","wp"], //row 1
//     ["0","0","0","0","0","0","0","0"], //row 2
//     ["0","0","0","0","0","0","0","0"], //row 3
//     ["0","0","0","0","0","0","0","0"], //row 4
//     ["0","0","0","0","0","0","0","0"], //row 5
//     ["bp","bp","bp","bp","bp","bp","bp","bp"], //row 6
//     ["br","bn","bb","bq","bk","bb","bn","br"]]; //row 7

// Use this to determine $playerMove
// I also need to get the current board state somehow.
$var1 = $_POST['startPos'];
$var2 = $_POST['endPos'];
$_SESSION['startPosition'] = $var1;
$_SESSION['endPosition'] = $var2;
$databaseNumber = $_SESSION['game'];
$lobbyNumber = $_SESSION['lobby'];
$playerMove = [$var1,$var2];
// $playerMove = ["b1","c3"];

$isTheMoveLegal=mover($currentBoardState,$playerMove);

if ($isTheMoveLegal) {
    //update board
    header("location: updateBoard.php");
} else {
//send them back to where they came from
header("location: $lobbyNumber.php");
}

function mover($currentBoardState,$playersMove) {
    $initialY = substr($playersMove[0],0,1);
    $initialX = substr($playersMove[0],1,1);

    $legalMove = false;

    $endY = substr($playersMove[1],0,1);
    $endX = substr($playersMove[1],1,1);

    $initialY = changeintonumber($initialY);
    $endY = changeintonumber($endY);

    $initialX -= 1;
    $endX -= 1;



    if(!($endX>7||$endX<0 || $endY>7||$endY<0 || $initialX>7||$initialX<0 || $initialY>7||$initialY<0)) {
    $pieceType = whatPieceWeMoving($currentBoardState,$initialX,$initialY);
    $team = substr($pieceType,0,1);
    if ($pieceType=="wp"){
    $legalMove = whitePawn($currentBoardState,$initialX,$initialY,$endX,$endY);
    } else if ($pieceType=="bp"){
    $legalMove = blackPawn($currentBoardState,$initialX,$initialY,$endX,$endY);
    } else if ($pieceType=="bb"||$pieceType=="wb"){
    $legalMove = bishop($currentBoardState,$initialX,$initialY,$endX,$endY,$team);
    } else if ($pieceType=="wr"||$pieceType=="br"){
    $legalMove = rook($currentBoardState,$initialX,$initialY,$endX,$endY,$team);
    } else if ($pieceType=="wq"||$pieceType=="bq"){
    $legalMove = queen($currentBoardState,$initialX,$initialY,$endX,$endY,$team);
    } else if ($pieceType=="wn"||$pieceType=="bn"){
    $legalMove = knight($currentBoardState,$initialX,$initialY,$endX,$endY,$team);
    } else if ($pieceType=="wk"||$pieceType=="bk"){
    $legalMove = king($currentBoardState,$initialX,$initialY,$endX,$endY,$team);
    }

    }
    else {
        $legalMove=false;
    }
    return $legalMove;
}

function displayinator($initialY,$initialX,$endY,$endX,$pieceType,$team,$playersMove,$legalMove) {
    print("<br> Beginning Square:");
    print_r($playersMove[0]);
    print("<br> Ending Square:");
    print_r($playersMove[1]);
    print("<br> Beginning Y:");
    print_r($initialY);
    print("<br> Beginning X:");
    print_r($initialX);
    print("<br> ending Y:");
    print_r($endY);
    print("<br> ending X:");
    print_r($endX);
    print("<br> Type:");
    print_r($pieceType);
    print("<br> Side:");
    print_r($team);
    print("<br> Is The Move Legal:");
    print_r($legalMove);
}

function changeintonumber($inputLetter){
    if ($inputLetter == "a"){
        return "0";
    } else if ($inputLetter == "b"){
        return "1";
    } else if ($inputLetter == "c"){
        return "2";
    } else if ($inputLetter == "d"){
        return "3";
    } else if ($inputLetter == "e"){
        return "4";
    } else if ($inputLetter == "f"){
        return "5";
    } else if ($inputLetter == "g"){
        return "6";
    } else if ($inputLetter == "h"){
        return "7";
    }   else {
        return "-1";
    }
}

function whatPieceWeMoving($currentBoardState,$X,$Y) {
    $returning = $currentBoardState[$X][$Y];
    return $returning;
}

function whitePawn($currentBoardState,$X,$Y,$endX,$endY) {
    //these 2 if statements check the forwards moves. NOT captures.
    if($Y==$endY)
    {
        if(($currentBoardState[$X+1][$Y] == "0")&&($currentBoardState[$X+2][$Y] == "0")&&($endX==($X+2))&&($X==1)){
                return true;}
        
    if (($currentBoardState[$X+1][$Y] == "0")&&($endX==($X+1))) {
        return true;
    }
    }
    //These if statements will check captures. (I wont have enpassant unless I have extra time)
    $teamOfPiece1 = substr($currentBoardState[$X+1][$Y-1],0,1);
    $teamOfPiece2 = substr($currentBoardState[$X+1][$Y+1],0,1);
    if  (($currentBoardState[$X+1][$Y-1] != "0")&&(($Y-1)==$endY)&&($endX==($X+1))&& $teamOfPiece2=="b"){
        return true;
    } else if  (($currentBoardState[$X+1][$Y+1] != "0")&&(($Y+1)==$endY)&&($endX==($X+1))&& $teamOfPiece1=="b"){
        return true;
        }
    }

function blackPawn($currentBoardState,$X,$Y,$endX,$endY) {
    //these 2 if statements check the forwards moves. NOT captures.
    if($Y==$endY)
    {
        if(($currentBoardState[$X-1][$Y] == "0")&&($currentBoardState[$X-2][$Y] == "0")&&($X==6)&&($endX==($X-2))){
                return true;}
         
    if (($currentBoardState[$X-1][$Y] == "0")&&($endX==($X-1))) {
        return true;
    }
    }
    //These if statements will check captures. (I wont have time to add enpassant unless I have extra time)
    $teamOfPiece1 = substr($currentBoardState[$X-1][$Y-1],0,1);
    $teamOfPiece2 = substr($currentBoardState[$X-1][$Y+1],0,1);
    if  (($currentBoardState[$X-1][$Y-1] != "0")&&(($Y-1)==$endY)&&($endX==($X-1))&& $teamOfPiece2=="w"){
        return true;
    } else if  (($currentBoardState[$X-1][$Y+1] != "0")&&(($Y+1)==$endY)&&($endX==($X-1))&& $teamOfPiece1=="w"){
        return true;
    }
}
function bishop($currentBoardState,$X,$Y,$endX,$endY,$team) {
    //This is the beginning of the down-right code
    if(!(($X+1)>7 || ($Y+1)>7)){
    if($currentBoardState[$X+1][$Y+1]=="0"){
        if((($X+1)==$endX) && (($Y+1)==$endY)){
        return true;} 
            if($currentBoardState[$X+2][$Y+2]=="0"){
        if((($X+2)==$endX) && (($Y+2)==$endY)){
        return true;} 
                if($currentBoardState[$X+3][$Y+3]=="0"){
        if((($X+3)==$endX) && (($Y+3)==$endY)){
        return true;} 
                    if($currentBoardState[$X+4][$Y+4]=="0"){
        if((($X+4)==$endX) && (($Y+4)==$endY)){
        return true;} 
                        if($currentBoardState[$X+5][$Y+5]=="0"){
        if((($X+5)==$endX) && (($Y+5)==$endY)){
        return true;} 
                            if($currentBoardState[$X+6][$Y+6]=="0"){
        if((($X+6)==$endX) && (($Y+6)==$endY)){
        return true;} 
                                if($currentBoardState[$X+7][$Y+7]=="0"){
        if((($X+7)==$endX) && (($Y+7)==$endY)){
        return true;} 
    } else if(!(($X+7)>7 || ($Y+7)>7)){
        $OtherPieceType = whatPieceWeMoving($currentBoardState,$X+7,$Y+7);$OtherPieceTeam = substr($OtherPieceType,0,1);
        if(($OtherPieceTeam!=$team) && (($X+7)==$endX) && (($Y+7)==$endY)){return true;}}
    } else if(!(($X+6)>7 || ($Y+6)>7)){
        $OtherPieceType = whatPieceWeMoving($currentBoardState,$X+6,$Y+6);$OtherPieceTeam = substr($OtherPieceType,0,1);
        if(($OtherPieceTeam!=$team) && (($X+6)==$endX) && (($Y+6)==$endY)){return true;}}
    } else if(!(($X+5)>7 || ($Y+5)>7)){
        $OtherPieceType = whatPieceWeMoving($currentBoardState,$X+5,$Y+5);$OtherPieceTeam = substr($OtherPieceType,0,1);
        if(($OtherPieceTeam!=$team) && (($X+5)==$endX) && (($Y+5)==$endY)){return true;}}
    }   else if(!(($X+4)>7 || ($Y+4)>7)){
        $OtherPieceType = whatPieceWeMoving($currentBoardState,$X+4,$Y+4);$OtherPieceTeam = substr($OtherPieceType,0,1);
        if(($OtherPieceTeam!=$team) && (($X+4)==$endX) && (($Y+4)==$endY)){return true;}}
    } else if(!(($X+3)>7 || ($Y+3)>7)){
        $OtherPieceType = whatPieceWeMoving($currentBoardState,$X+3,$Y+3);$OtherPieceTeam = substr($OtherPieceType,0,1);
        if(($OtherPieceTeam!=$team) && (($X+3)==$endX) && (($Y+3)==$endY)){return true;}}
    }   else if(!(($X+2)>7 || ($Y+2)>7)){
        $OtherPieceType = whatPieceWeMoving($currentBoardState,$X+2,$Y+2);$OtherPieceTeam = substr($OtherPieceType,0,1);
        if(($OtherPieceTeam!=$team) && (($X+2)==$endX) && (($Y+2)==$endY)){return true;}}
    }   else if(!(($X+1)>7 || ($Y+1)>7)){
        $OtherPieceType = whatPieceWeMoving($currentBoardState,$X+1,$Y+1);$OtherPieceTeam = substr($OtherPieceType,0,1);
        if(($OtherPieceTeam!=$team) && (($X+1)==$endX) && (($Y+1)==$endY)){return true;}}}
    //this is the ending of the down right code
    //This is the beginning of the down-left code
    if(!(($X+1)>7 || ($Y-1)<0)){
    if($currentBoardState[$X+1][$Y-1]=="0"){
        if((($X+1)==$endX) && (($Y-1)==$endY)){
        return true;} 
            if($currentBoardState[$X+2][$Y-2]=="0"){
        if((($X+2)==$endX) && (($Y-2)==$endY)){
        return true;} 
                if($currentBoardState[$X+3][$Y-3]=="0"){
        if((($X+3)==$endX) && (($Y-3)==$endY)){
        return true;} 
                    if($currentBoardState[$X+4][$Y-4]=="0"){
        if((($X+4)==$endX) && (($Y-4)==$endY)){
        return true;} 
                        if($currentBoardState[$X+5][$Y-5]=="0"){
        if((($X+5)==$endX) && (($Y-5)==$endY)){
        return true;} 
                            if($currentBoardState[$X+6][$Y-6]=="0"){
        if((($X+6)==$endX) && (($Y-6)==$endY)){
        return true;} 
                                if($currentBoardState[$X+7][$Y-7]=="0"){
        if((($X+7)==$endX) && (($Y-7)==$endY)){
        return true;} 
    } else if(!(($X+7)>7 || ($Y-7)<0)){
        $OtherPieceType = whatPieceWeMoving($currentBoardState,$X+7,$Y-7);$OtherPieceTeam = substr($OtherPieceType,0,1);
        if(($OtherPieceTeam!=$team) && (($X+7)==$endX) && (($Y-7)==$endY)){return true;}}
    } else if(!(($X+6)>7 || ($Y-6)<0)){
        $OtherPieceType = whatPieceWeMoving($currentBoardState,$X+6,$Y-6);$OtherPieceTeam = substr($OtherPieceType,0,1);
        if(($OtherPieceTeam!=$team) && (($X+6)==$endX) && (($Y-6)==$endY)){return true;}}
    } else if(!(($X+5)>7 || ($Y-5)<0)){
        $OtherPieceType = whatPieceWeMoving($currentBoardState,$X+5,$Y-5);$OtherPieceTeam = substr($OtherPieceType,0,1);
        if(($OtherPieceTeam!=$team) && (($X+5)==$endX) && (($Y-5)==$endY)){return true;}}
    }   else if(!(($X+4)>7 || ($Y-4)<0)){
        $OtherPieceType = whatPieceWeMoving($currentBoardState,$X+4,$Y-4);$OtherPieceTeam = substr($OtherPieceType,0,1);
        if(($OtherPieceTeam!=$team) && (($X+4)==$endX) && (($Y-4)==$endY)){return true;}}
    } else if(!(($X+3)>7 || ($Y-3)<0)){
        $OtherPieceType = whatPieceWeMoving($currentBoardState,$X+3,$Y-3);$OtherPieceTeam = substr($OtherPieceType,0,1);
        if(($OtherPieceTeam!=$team) && (($X+3)==$endX) && (($Y-3)==$endY)){return true;}}
    }   else if(!(($X-2)>7 || ($Y-2)<0)){
        $OtherPieceType = whatPieceWeMoving($currentBoardState,$X+2,$Y-2);$OtherPieceTeam = substr($OtherPieceType,0,1);
        if(($OtherPieceTeam!=$team) && (($X+2)==$endX) && (($Y-2)==$endY)){return true;}}
    }   else if(!(($X+1)>7 || ($Y-1)<0)){
        $OtherPieceType = whatPieceWeMoving($currentBoardState,$X+1,$Y-1);$OtherPieceTeam = substr($OtherPieceType,0,1);
        if(($OtherPieceTeam!=$team) && (($X+1)==$endX) && (($Y-1)==$endY)){return true;}}}
    //this is the ending of the down left code
    //This is the beginning of the up-right code
    if(!(($X-1)<0 || ($Y+1)>7)){
    if($currentBoardState[$X-1][$Y+1]=="0"){
        if((($X-1)==$endX) && (($Y+1)==$endY)){
        return true;} 
            if($currentBoardState[$X-2][$Y+2]=="0"){
        if((($X-2)==$endX) && (($Y+2)==$endY)){
        return true;} 
                if($currentBoardState[$X-3][$Y+3]=="0"){
        if((($X-3)==$endX) && (($Y+3)==$endY)){
        return true;} 
                    if($currentBoardState[$X-4][$Y+4]=="0"){
        if((($X-4)==$endX) && (($Y+4)==$endY)){
        return true;} 
                        if($currentBoardState[$X-5][$Y+5]=="0"){
        if((($X-5)==$endX) && (($Y+5)==$endY)){
        return true;} 
                            if($currentBoardState[$X-6][$Y+6]=="0"){
        if((($X-6)==$endX) && (($Y+6)==$endY)){
        return true;} 
                                if($currentBoardState[$X-7][$Y+7]=="0"){
        if((($X-7)==$endX) && (($Y+7)==$endY)){
        return true;} 
    } else if(!(($X-7)<0 || ($Y+7)>7)){
        $OtherPieceType = whatPieceWeMoving($currentBoardState,$X-7,$Y+7);$OtherPieceTeam = substr($OtherPieceType,0,1);
        if(($OtherPieceTeam!=$team) && (($X-7)==$endX) && (($Y+7)==$endY)){return true;}}
    } else if(!(($X-6)<0 || ($Y+6)>7)){
        $OtherPieceType = whatPieceWeMoving($currentBoardState,$X-6,$Y+6);$OtherPieceTeam = substr($OtherPieceType,0,1);
        if(($OtherPieceTeam!=$team) && (($X-6)==$endX) && (($Y+6)==$endY)){return true;}}
    } else if(!(($X-5)<0 || ($Y+5)>7)){
        $OtherPieceType = whatPieceWeMoving($currentBoardState,$X-5,$Y+5);$OtherPieceTeam = substr($OtherPieceType,0,1);
        if(($OtherPieceTeam!=$team) && (($X-5)==$endX) && (($Y+5)==$endY)){return true;}}
    }   else if(!(($X-4)<0 || ($Y+4)>7)){
        $OtherPieceType = whatPieceWeMoving($currentBoardState,$X-4,$Y+4);$OtherPieceTeam = substr($OtherPieceType,0,1);
        if(($OtherPieceTeam!=$team) && (($X-4)==$endX) && (($Y+4)==$endY)){return true;}}
    } else if(!(($X-3)<0 || ($Y+3)>7)){
        $OtherPieceType = whatPieceWeMoving($currentBoardState,$X-3,$Y+3);$OtherPieceTeam = substr($OtherPieceType,0,1);
        if(($OtherPieceTeam!=$team) && (($X-3)==$endX) && (($Y+3)==$endY)){return true;}}
    }   else if(!(($X-2)<0 || ($Y+2)>7)){
        $OtherPieceType = whatPieceWeMoving($currentBoardState,$X-2,$Y+2);$OtherPieceTeam = substr($OtherPieceType,0,1);
        if(($OtherPieceTeam!=$team) && (($X-2)==$endX) && (($Y+2)==$endY)){return true;}}
    }   else if(!(($X-1)<0 || ($Y+1)>7)){
        $OtherPieceType = whatPieceWeMoving($currentBoardState,$X-1,$Y+1);$OtherPieceTeam = substr($OtherPieceType,0,1);
        if(($OtherPieceTeam!=$team) && (($X-1)==$endX) && (($Y+1)==$endY)){return true;}}}
    //this is the ending of the up right code
    //This is the beginning of the up-left code
    if(!(($X-1)<0 || ($Y-1)<0)){
    if($currentBoardState[$X-1][$Y-1]=="0"){
        if((($X-1)==$endX) && (($Y-1)==$endY)){
        return true;} 
            if($currentBoardState[$X-2][$Y-2]=="0"){
        if((($X-2)==$endX) && (($Y-2)==$endY)){
        return true;} 
                if($currentBoardState[$X-3][$Y-3]=="0"){
        if((($X-3)==$endX) && (($Y-3)==$endY)){
        return true;} 
                    if($currentBoardState[$X-4][$Y-4]=="0"){
        if((($X-4)==$endX) && (($Y-4)==$endY)){
        return true;} 
                        if($currentBoardState[$X-5][$Y-5]=="0"){
        if((($X-5)==$endX) && (($Y-5)==$endY)){
        return true;} 
                            if($currentBoardState[$X-6][$Y-6]=="0"){
        if((($X-6)==$endX) && (($Y-6)==$endY)){
        return true;} 
                                if($currentBoardState[$X-7][$Y-7]=="0"){
        if((($X-7)==$endX) && (($Y-7)==$endY)){
        return true;} 
    } else if(!(($X-7)<0 || ($Y-7)<0)){
        $OtherPieceType = whatPieceWeMoving($currentBoardState,$X-7,$Y-7);$OtherPieceTeam = substr($OtherPieceType,0,1);
        if(($OtherPieceTeam!=$team) && (($X-7)==$endX) && (($Y-7)==$endY)){return true;}}
    } else if(!(($X-6)<0 || ($Y-6)<0)){
        $OtherPieceType = whatPieceWeMoving($currentBoardState,$X-6,$Y-6);$OtherPieceTeam = substr($OtherPieceType,0,1);
        if(($OtherPieceTeam!=$team) && (($X-6)==$endX) && (($Y-6)==$endY)){return true;}}
    } else if(!(($X-5)<0 || ($Y-5)<0)){
        $OtherPieceType = whatPieceWeMoving($currentBoardState,$X-5,$Y-5);$OtherPieceTeam = substr($OtherPieceType,0,1);
        if(($OtherPieceTeam!=$team) && (($X-5)==$endX) && (($Y-5)==$endY)){return true;}}
    }   else if(!(($X-4)<0 || ($Y-4)<0)){
        $OtherPieceType = whatPieceWeMoving($currentBoardState,$X-4,$Y-4);$OtherPieceTeam = substr($OtherPieceType,0,1);
        if(($OtherPieceTeam!=$team) && (($X-4)==$endX) && (($Y-4)==$endY)){return true;}}
    } else if(!(($X-3)<0 || ($Y-3)<0)){
        $OtherPieceType = whatPieceWeMoving($currentBoardState,$X-3,$Y-3);$OtherPieceTeam = substr($OtherPieceType,0,1);
        if(($OtherPieceTeam!=$team) && (($X-3)==$endX) && (($Y-3)==$endY)){return true;}}
    }   else if(!(($X-2)<0 || ($Y-2)<0)){
        $OtherPieceType = whatPieceWeMoving($currentBoardState,$X-2,$Y-2);$OtherPieceTeam = substr($OtherPieceType,0,1);
        if(($OtherPieceTeam!=$team) && (($X-2)==$endX) && (($Y-2)==$endY)){return true;}}
    }   else if(!(($X-1)<0 || ($Y-1)<0)){
        $OtherPieceType = whatPieceWeMoving($currentBoardState,$X-1,$Y-1);$OtherPieceTeam = substr($OtherPieceType,0,1);
        if(($OtherPieceTeam!=$team) && (($X-1)==$endX) && (($Y-1)==$endY)){return true;}}}
    //this is the ending of the up left code   
}

function rook($currentBoardState,$X,$Y,$endX,$endY,$team) {
    //This is the beginning of the down code
    if(!(($Y+1)>7)){
    if($currentBoardState[$X][$Y+1]=="0"){
        if((($X)==$endX) && (($Y+1)==$endY)){
        return true;} 
            if($currentBoardState[$X][$Y+2]=="0"){
        if((($X)==$endX) && (($Y+2)==$endY)){
        return true;} 
                if($currentBoardState[$X][$Y+3]=="0"){
        if((($X)==$endX) && (($Y+3)==$endY)){
        return true;} 
                    if($currentBoardState[$X][$Y+4]=="0"){
        if((($X)==$endX) && (($Y+4)==$endY)){
        return true;} 
                        if($currentBoardState[$X][$Y+5]=="0"){
        if((($X)==$endX) && (($Y+5)==$endY)){
        return true;} 
                            if($currentBoardState[$X][$Y+6]=="0"){
        if((($X)==$endX) && (($Y+6)==$endY)){
        return true;} 
                                if($currentBoardState[$X][$Y+7]=="0"){
        if((($X)==$endX) && (($Y+7)==$endY)){
        return true;} 
    } else if(!(($Y+7)>7)){
        $OtherPieceType = whatPieceWeMoving($currentBoardState,$X,$Y+7);$OtherPieceTeam = substr($OtherPieceType,0,1);
        if(($OtherPieceTeam!=$team) && (($X)==$endX) && (($Y+7)==$endY)){return true;}}
    } else if(!(($Y+6)>7)){
        $OtherPieceType = whatPieceWeMoving($currentBoardState,$X,$Y+6);$OtherPieceTeam = substr($OtherPieceType,0,1);
        if(($OtherPieceTeam!=$team) && (($X)==$endX) && (($Y+6)==$endY)){return true;}}
    } else if(!(($Y+5)>7)){
        $OtherPieceType = whatPieceWeMoving($currentBoardState,$X,$Y+5);$OtherPieceTeam = substr($OtherPieceType,0,1);
        if(($OtherPieceTeam!=$team) && (($X)==$endX) && (($Y+5)==$endY)){return true;}}
    }   else if(!(($Y+4)>7)){
        $OtherPieceType = whatPieceWeMoving($currentBoardState,$X,$Y+4);$OtherPieceTeam = substr($OtherPieceType,0,1);
        if(($OtherPieceTeam!=$team) && (($X)==$endX) && (($Y+4)==$endY)){return true;}}
    } else if(!(($Y+3)>7)){
        $OtherPieceType = whatPieceWeMoving($currentBoardState,$X,$Y+3);$OtherPieceTeam = substr($OtherPieceType,0,1);
        if(($OtherPieceTeam!=$team) && (($X)==$endX) && (($Y+3)==$endY)){return true;}}
    }   else if(!(($Y+2)>7)){
        $OtherPieceType = whatPieceWeMoving($currentBoardState,$X,$Y+2);$OtherPieceTeam = substr($OtherPieceType,0,1);
        if(($OtherPieceTeam!=$team) && (($X)==$endX) && (($Y+2)==$endY)){return true;}}
    }   else if(!(($Y+1)>7)){
        $OtherPieceType = whatPieceWeMoving($currentBoardState,$X,$Y+1);$OtherPieceTeam = substr($OtherPieceType,0,1);
        if(($OtherPieceTeam!=$team) && (($X)==$endX) && (($Y+1)==$endY)){return true;}}}
    //this is the ending of the down code
    //This is the beginning of the up code
    if(!(($Y-1)<0)){
    if($currentBoardState[$X][$Y-1]=="0"){
        if((($X)==$endX) && (($Y-1)==$endY)){
        return true;} 
            if($currentBoardState[$X][$Y-2]=="0"){
        if((($X)==$endX) && (($Y-2)==$endY)){
        return true;} 
                if($currentBoardState[$X][$Y-3]=="0"){
        if((($X)==$endX) && (($Y-3)==$endY)){
        return true;} 
                    if($currentBoardState[$X][$Y-4]=="0"){
        if((($X)==$endX) && (($Y-4)==$endY)){
        return true;} 
                        if($currentBoardState[$X][$Y-5]=="0"){
        if((($X)==$endX) && (($Y-5)==$endY)){
        return true;} 
                            if($currentBoardState[$X][$Y-6]=="0"){
        if((($X)==$endX) && (($Y-6)==$endY)){
        return true;} 
                                if($currentBoardState[$X][$Y-7]=="0"){
        if((($X)==$endX) && (($Y-7)==$endY)){
        return true;} 
    } else if(!(($Y-7)<0)){
        $OtherPieceType = whatPieceWeMoving($currentBoardState,$X,$Y-7);$OtherPieceTeam = substr($OtherPieceType,0,1);
        if(($OtherPieceTeam!=$team) && (($X)==$endX) && (($Y-7)==$endY)){return true;}}
    } else if(!(($Y-6)<0)){
        $OtherPieceType = whatPieceWeMoving($currentBoardState,$X,$Y-6);$OtherPieceTeam = substr($OtherPieceType,0,1);
        if(($OtherPieceTeam!=$team) && (($X)==$endX) && (($Y-6)==$endY)){return true;}}
    } else if(!(($Y-5)<0)){
        $OtherPieceType = whatPieceWeMoving($currentBoardState,$X,$Y-5);$OtherPieceTeam = substr($OtherPieceType,0,1);
        if(($OtherPieceTeam!=$team) && (($X)==$endX) && (($Y-5)==$endY)){return true;}}
    }   else if(!(($Y-4)<0)){
        $OtherPieceType = whatPieceWeMoving($currentBoardState,$X,$Y-4);$OtherPieceTeam = substr($OtherPieceType,0,1);
        if(($OtherPieceTeam!=$team) && (($X)==$endX) && (($Y-4)==$endY)){return true;}}
    } else if(!(($Y-3)<0)){
        $OtherPieceType = whatPieceWeMoving($currentBoardState,$X,$Y-3);$OtherPieceTeam = substr($OtherPieceType,0,1);
        if(($OtherPieceTeam!=$team) && (($X)==$endX) && (($Y-3)==$endY)){return true;}}
    }   else if(!(($Y-2)<0)){
        $OtherPieceType = whatPieceWeMoving($currentBoardState,$X,$Y-2);$OtherPieceTeam = substr($OtherPieceType,0,1);
        if(($OtherPieceTeam!=$team) && (($X)==$endX) && (($Y-2)==$endY)){return true;}}
    }   else if(!(($Y-1)<0)){
        $OtherPieceType = whatPieceWeMoving($currentBoardState,$X,$Y-1);$OtherPieceTeam = substr($OtherPieceType,0,1);
        if(($OtherPieceTeam!=$team) && (($X)==$endX) && (($Y-1)==$endY)){return true;}}}
    //this is the ending of the up code
        //This is the beginning of the left code
        if(!(($X+1)>7)){
    if($currentBoardState[$X+1][$Y]=="0"){
        if((($X+1)==$endX) && (($Y)==$endY)){
        return true;} 
            if($currentBoardState[$X+2][$Y]=="0"){
        if((($X+2)==$endX) && (($Y)==$endY)){
        return true;} 
                if($currentBoardState[$X+3][$Y]=="0"){
        if((($X+3)==$endX) && (($Y)==$endY)){
        return true;} 
                    if($currentBoardState[$X+4][$Y]=="0"){
        if((($X+4)==$endX) && (($Y)==$endY)){
        return true;} 
                        if($currentBoardState[$X+5][$Y]=="0"){
        if((($X+5)==$endX) && (($Y)==$endY)){
        return true;} 
                            if($currentBoardState[$X+6][$Y]=="0"){
        if((($X+6)==$endX) && (($Y)==$endY)){
        return true;} 
                                if($currentBoardState[$X+7][$Y]=="0"){
        if((($X+7)==$endX) && (($Y)==$endY)){
        return true;} 
    } else if(!(($X+7)>7)){
        $OtherPieceType = whatPieceWeMoving($currentBoardState,$X+7,$Y);$OtherPieceTeam = substr($OtherPieceType,0,1);
        if(($OtherPieceTeam!=$team) && (($X+7)==$endX) && (($Y)==$endY)){return true;}}
    } else if(!(($X+6)>7)){
        $OtherPieceType = whatPieceWeMoving($currentBoardState,$X+6,$Y);$OtherPieceTeam = substr($OtherPieceType,0,1);
        if(($OtherPieceTeam!=$team) && (($X+6)==$endX) && (($Y)==$endY)){return true;}}
    } else if(!(($X+5)>7)){
        $OtherPieceType = whatPieceWeMoving($currentBoardState,$X+5,$Y);$OtherPieceTeam = substr($OtherPieceType,0,1);
        if(($OtherPieceTeam!=$team) && (($X+5)==$endX) && (($Y)==$endY)){return true;}}
    }   else if(!(($X+4)>7)){
        $OtherPieceType = whatPieceWeMoving($currentBoardState,$X+4,$Y);$OtherPieceTeam = substr($OtherPieceType,0,1);
        if(($OtherPieceTeam!=$team) && (($X+4)==$endX) && (($Y)==$endY)){return true;}}
    } else if(!(($X+3)>7)){
        $OtherPieceType = whatPieceWeMoving($currentBoardState,$X+3,$Y);$OtherPieceTeam = substr($OtherPieceType,0,1);
        if(($OtherPieceTeam!=$team) && (($X+3)==$endX) && (($Y)==$endY)){return true;}}
    }   else if(!(($X+2)>7)){
        $OtherPieceType = whatPieceWeMoving($currentBoardState,$X+2,$Y);$OtherPieceTeam = substr($OtherPieceType,0,1);
        if(($OtherPieceTeam!=$team) && (($X+2)==$endX) && (($Y)==$endY)){return true;}}
    }   else if(!(($X+1)>7)){
        $OtherPieceType = whatPieceWeMoving($currentBoardState,$X+1,$Y);$OtherPieceTeam = substr($OtherPieceType,0,1);
        if(($OtherPieceTeam!=$team) && (($X+1)==$endX) && (($Y)==$endY)){return true;}}}
    //this is the ending of the left code
    //This is the beginning of the right code
    if(!(($X-1)<0)){
    if($currentBoardState[$X-1][$Y]=="0"){
        if((($X-1)==$endX) && (($Y)==$endY)){
        return true;} 
            if($currentBoardState[$X-2][$Y]=="0"){
        if((($X-2)==$endX) && (($Y)==$endY)){
        return true;} 
                if($currentBoardState[$X-3][$Y]=="0"){
        if((($X-3)==$endX) && (($Y)==$endY)){
        return true;} 
                    if($currentBoardState[$X-4][$Y]=="0"){
        if((($X-4)==$endX) && (($Y)==$endY)){
        return true;} 
                        if($currentBoardState[$X-5][$Y]=="0"){
        if((($X-5)==$endX) && (($Y)==$endY)){
        return true;} 
                            if($currentBoardState[$X-6][$Y]=="0"){
        if((($X-6)==$endX) && (($Y)==$endY)){
        return true;} 
                                if($currentBoardState[$X-7][$Y]=="0"){
        if((($X-7)==$endX) && (($Y)==$endY)){
        return true;} 
    } else if(!(($X-7)<0)){
        $OtherPieceType = whatPieceWeMoving($currentBoardState,$X-7,$Y);$OtherPieceTeam = substr($OtherPieceType,0,1);
        if(($OtherPieceTeam!=$team) && (($X-7)==$endX) && (($Y)==$endY)){return true;}}
    } else if(!(($X-6)<0)){
        $OtherPieceType = whatPieceWeMoving($currentBoardState,$X-6,$Y);$OtherPieceTeam = substr($OtherPieceType,0,1);
        if(($OtherPieceTeam!=$team) && (($X-6)==$endX) && (($Y)==$endY)){return true;}}
    } else if(!(($X-5)<0)){
        $OtherPieceType = whatPieceWeMoving($currentBoardState,$X-5,$Y);$OtherPieceTeam = substr($OtherPieceType,0,1);
        if(($OtherPieceTeam!=$team) && (($X-5)==$endX) && (($Y)==$endY)){return true;}}
    }   else if(!(($X-4)<0)){
        $OtherPieceType = whatPieceWeMoving($currentBoardState,$X-4,$Y);$OtherPieceTeam = substr($OtherPieceType,0,1);
        if(($OtherPieceTeam!=$team) && (($X-4)==$endX) && (($Y)==$endY)){return true;}}
    } else if(!(($X-3)<0)){
        $OtherPieceType = whatPieceWeMoving($currentBoardState,$X-3,$Y);$OtherPieceTeam = substr($OtherPieceType,0,1);
        if(($OtherPieceTeam!=$team) && (($X-3)==$endX) && (($Y)==$endY)){return true;}}
    }   else if(!(($X-2)<0)){
        $OtherPieceType = whatPieceWeMoving($currentBoardState,$X-2,$Y);$OtherPieceTeam = substr($OtherPieceType,0,1);
        if(($OtherPieceTeam!=$team) && (($X-2)==$endX) && (($Y)==$endY)){return true;}}
    }   else if(!(($X-1)<0)){
        $OtherPieceType = whatPieceWeMoving($currentBoardState,$X-1,$Y);$OtherPieceTeam = substr($OtherPieceType,0,1);
        if(($OtherPieceTeam!=$team) && (($X-1)==$endX) && (($Y)==$endY)){return true;}}}
    //this is the ending of the right code
}

function  queen($currentBoardState,$X,$Y,$endX,$endY,$team) {
    //This is the beginning of the down code
    if(!(($Y+1)>7)){
    if($currentBoardState[$X][$Y+1]=="0"){
        if((($X)==$endX) && (($Y+1)==$endY)){
        return true;} 
            if($currentBoardState[$X][$Y+2]=="0"){
        if((($X)==$endX) && (($Y+2)==$endY)){
        return true;} 
                if($currentBoardState[$X][$Y+3]=="0"){
        if((($X)==$endX) && (($Y+3)==$endY)){
        return true;} 
                    if($currentBoardState[$X][$Y+4]=="0"){
        if((($X)==$endX) && (($Y+4)==$endY)){
        return true;} 
                        if($currentBoardState[$X][$Y+5]=="0"){
        if((($X)==$endX) && (($Y+5)==$endY)){
        return true;} 
                            if($currentBoardState[$X][$Y+6]=="0"){
        if((($X)==$endX) && (($Y+6)==$endY)){
        return true;} 
                                if($currentBoardState[$X][$Y+7]=="0"){
        if((($X)==$endX) && (($Y+7)==$endY)){
        return true;} 
    } else if(!(($Y+7)>7)){
        $OtherPieceType = whatPieceWeMoving($currentBoardState,$X,$Y+7);$OtherPieceTeam = substr($OtherPieceType,0,1);
        if(($OtherPieceTeam!=$team) && (($X)==$endX) && (($Y+7)==$endY)){return true;}}
    } else if(!(($Y+6)>7)){
        $OtherPieceType = whatPieceWeMoving($currentBoardState,$X,$Y+6);$OtherPieceTeam = substr($OtherPieceType,0,1);
        if(($OtherPieceTeam!=$team) && (($X)==$endX) && (($Y+6)==$endY)){return true;}}
    } else if(!(($Y+5)>7)){
        $OtherPieceType = whatPieceWeMoving($currentBoardState,$X,$Y+5);$OtherPieceTeam = substr($OtherPieceType,0,1);
        if(($OtherPieceTeam!=$team) && (($X)==$endX) && (($Y+5)==$endY)){return true;}}
    }   else if(!(($Y+4)>7)){
        $OtherPieceType = whatPieceWeMoving($currentBoardState,$X,$Y+4);$OtherPieceTeam = substr($OtherPieceType,0,1);
        if(($OtherPieceTeam!=$team) && (($X)==$endX) && (($Y+4)==$endY)){return true;}}
    } else if(!(($Y+3)>7)){
        $OtherPieceType = whatPieceWeMoving($currentBoardState,$X,$Y+3);$OtherPieceTeam = substr($OtherPieceType,0,1);
        if(($OtherPieceTeam!=$team) && (($X)==$endX) && (($Y+3)==$endY)){return true;}}
    }   else if(!(($Y+2)>7)){
        $OtherPieceType = whatPieceWeMoving($currentBoardState,$X,$Y+2);$OtherPieceTeam = substr($OtherPieceType,0,1);
        if(($OtherPieceTeam!=$team) && (($X)==$endX) && (($Y+2)==$endY)){return true;}}
    }   else if(!(($Y+1)>7)){
        $OtherPieceType = whatPieceWeMoving($currentBoardState,$X,$Y+1);$OtherPieceTeam = substr($OtherPieceType,0,1);
        if(($OtherPieceTeam!=$team) && (($X)==$endX) && (($Y+1)==$endY)){return true;}}}
    //this is the ending of the down code
    //This is the beginning of the up code
    if(!(($Y-1)<0)){
    if($currentBoardState[$X][$Y-1]=="0"){
        if((($X)==$endX) && (($Y-1)==$endY)){
        return true;} 
            if($currentBoardState[$X][$Y-2]=="0"){
        if((($X)==$endX) && (($Y-2)==$endY)){
        return true;} 
                if($currentBoardState[$X][$Y-3]=="0"){
        if((($X)==$endX) && (($Y-3)==$endY)){
        return true;} 
                    if($currentBoardState[$X][$Y-4]=="0"){
        if((($X)==$endX) && (($Y-4)==$endY)){
        return true;} 
                        if($currentBoardState[$X][$Y-5]=="0"){
        if((($X)==$endX) && (($Y-5)==$endY)){
        return true;} 
                            if($currentBoardState[$X][$Y-6]=="0"){
        if((($X)==$endX) && (($Y-6)==$endY)){
        return true;} 
                                if($currentBoardState[$X][$Y-7]=="0"){
        if((($X)==$endX) && (($Y-7)==$endY)){
        return true;} 
    } else if(!(($Y-7)<0)){
        $OtherPieceType = whatPieceWeMoving($currentBoardState,$X,$Y-7);$OtherPieceTeam = substr($OtherPieceType,0,1);
        if(($OtherPieceTeam!=$team) && (($X)==$endX) && (($Y-7)==$endY)){return true;}}
    } else if(!(($Y-6)<0)){
        $OtherPieceType = whatPieceWeMoving($currentBoardState,$X,$Y-6);$OtherPieceTeam = substr($OtherPieceType,0,1);
        if(($OtherPieceTeam!=$team) && (($X)==$endX) && (($Y-6)==$endY)){return true;}}
    } else if(!(($Y-5)<0)){
        $OtherPieceType = whatPieceWeMoving($currentBoardState,$X,$Y-5);$OtherPieceTeam = substr($OtherPieceType,0,1);
        if(($OtherPieceTeam!=$team) && (($X)==$endX) && (($Y-5)==$endY)){return true;}}
    }   else if(!(($Y-4)<0)){
        $OtherPieceType = whatPieceWeMoving($currentBoardState,$X,$Y-4);$OtherPieceTeam = substr($OtherPieceType,0,1);
        if(($OtherPieceTeam!=$team) && (($X)==$endX) && (($Y-4)==$endY)){return true;}}
    } else if(!(($Y-3)<0)){
        $OtherPieceType = whatPieceWeMoving($currentBoardState,$X,$Y-3);$OtherPieceTeam = substr($OtherPieceType,0,1);
        if(($OtherPieceTeam!=$team) && (($X)==$endX) && (($Y-3)==$endY)){return true;}}
    }   else if(!(($Y-2)<0)){
        $OtherPieceType = whatPieceWeMoving($currentBoardState,$X,$Y-2);$OtherPieceTeam = substr($OtherPieceType,0,1);
        if(($OtherPieceTeam!=$team) && (($X)==$endX) && (($Y-2)==$endY)){return true;}}
    }   else if(!(($Y-1)<0)){
        $OtherPieceType = whatPieceWeMoving($currentBoardState,$X,$Y-1);$OtherPieceTeam = substr($OtherPieceType,0,1);
        if(($OtherPieceTeam!=$team) && (($X)==$endX) && (($Y-1)==$endY)){return true;}}}
    //this is the ending of the up code
        //This is the beginning of the left code
        if(!(($X+1)>7)){
    if($currentBoardState[$X+1][$Y]=="0"){
        if((($X+1)==$endX) && (($Y)==$endY)){
        return true;} 
            if($currentBoardState[$X+2][$Y]=="0"){
        if((($X+2)==$endX) && (($Y)==$endY)){
        return true;} 
                if($currentBoardState[$X+3][$Y]=="0"){
        if((($X+3)==$endX) && (($Y)==$endY)){
        return true;} 
                    if($currentBoardState[$X+4][$Y]=="0"){
        if((($X+4)==$endX) && (($Y)==$endY)){
        return true;} 
                        if($currentBoardState[$X+5][$Y]=="0"){
        if((($X+5)==$endX) && (($Y)==$endY)){
        return true;} 
                            if($currentBoardState[$X+6][$Y]=="0"){
        if((($X+6)==$endX) && (($Y)==$endY)){
        return true;} 
                                if($currentBoardState[$X+7][$Y]=="0"){
        if((($X+7)==$endX) && (($Y)==$endY)){
        return true;} 
    } else if(!(($X+7)>7)){
        $OtherPieceType = whatPieceWeMoving($currentBoardState,$X+7,$Y);$OtherPieceTeam = substr($OtherPieceType,0,1);
        if(($OtherPieceTeam!=$team) && (($X+7)==$endX) && (($Y)==$endY)){return true;}}
    } else if(!(($X+6)>7)){
        $OtherPieceType = whatPieceWeMoving($currentBoardState,$X+6,$Y);$OtherPieceTeam = substr($OtherPieceType,0,1);
        if(($OtherPieceTeam!=$team) && (($X+6)==$endX) && (($Y)==$endY)){return true;}}
    } else if(!(($X+5)>7)){
        $OtherPieceType = whatPieceWeMoving($currentBoardState,$X+5,$Y);$OtherPieceTeam = substr($OtherPieceType,0,1);
        if(($OtherPieceTeam!=$team) && (($X+5)==$endX) && (($Y)==$endY)){return true;}}
    }   else if(!(($X+4)>7)){
        $OtherPieceType = whatPieceWeMoving($currentBoardState,$X+4,$Y);$OtherPieceTeam = substr($OtherPieceType,0,1);
        if(($OtherPieceTeam!=$team) && (($X+4)==$endX) && (($Y)==$endY)){return true;}}
    } else if(!(($X+3)>7)){
        $OtherPieceType = whatPieceWeMoving($currentBoardState,$X+3,$Y);$OtherPieceTeam = substr($OtherPieceType,0,1);
        if(($OtherPieceTeam!=$team) && (($X+3)==$endX) && (($Y)==$endY)){return true;}}
    }   else if(!(($X+2)>7)){
        $OtherPieceType = whatPieceWeMoving($currentBoardState,$X+2,$Y);$OtherPieceTeam = substr($OtherPieceType,0,1);
        if(($OtherPieceTeam!=$team) && (($X+2)==$endX) && (($Y)==$endY)){return true;}}
    }   else if(!(($X+1)>7)){
        $OtherPieceType = whatPieceWeMoving($currentBoardState,$X+1,$Y);$OtherPieceTeam = substr($OtherPieceType,0,1);
        if(($OtherPieceTeam!=$team) && (($X+1)==$endX) && (($Y)==$endY)){return true;}}}
    //this is the ending of the left code
    //This is the beginning of the right code
    if(!(($X-1)<0)){
    if($currentBoardState[$X-1][$Y]=="0"){
        if((($X-1)==$endX) && (($Y)==$endY)){
        return true;} 
            if($currentBoardState[$X-2][$Y]=="0"){
        if((($X-2)==$endX) && (($Y)==$endY)){
        return true;} 
                if($currentBoardState[$X-3][$Y]=="0"){
        if((($X-3)==$endX) && (($Y)==$endY)){
        return true;} 
                    if($currentBoardState[$X-4][$Y]=="0"){
        if((($X-4)==$endX) && (($Y)==$endY)){
        return true;} 
                        if($currentBoardState[$X-5][$Y]=="0"){
        if((($X-5)==$endX) && (($Y)==$endY)){
        return true;} 
                            if($currentBoardState[$X-6][$Y]=="0"){
        if((($X-6)==$endX) && (($Y)==$endY)){
        return true;} 
                                if($currentBoardState[$X-7][$Y]=="0"){
        if((($X-7)==$endX) && (($Y)==$endY)){
        return true;} 
    } else if(!(($X-7)<0)){
        $OtherPieceType = whatPieceWeMoving($currentBoardState,$X-7,$Y);$OtherPieceTeam = substr($OtherPieceType,0,1);
        if(($OtherPieceTeam!=$team) && (($X-7)==$endX) && (($Y)==$endY)){return true;}}
    } else if(!(($X-6)<0)){
        $OtherPieceType = whatPieceWeMoving($currentBoardState,$X-6,$Y);$OtherPieceTeam = substr($OtherPieceType,0,1);
        if(($OtherPieceTeam!=$team) && (($X-6)==$endX) && (($Y)==$endY)){return true;}}
    } else if(!(($X-5)<0)){
        $OtherPieceType = whatPieceWeMoving($currentBoardState,$X-5,$Y);$OtherPieceTeam = substr($OtherPieceType,0,1);
        if(($OtherPieceTeam!=$team) && (($X-5)==$endX) && (($Y)==$endY)){return true;}}
    }   else if(!(($X-4)<0)){
        $OtherPieceType = whatPieceWeMoving($currentBoardState,$X-4,$Y);$OtherPieceTeam = substr($OtherPieceType,0,1);
        if(($OtherPieceTeam!=$team) && (($X-4)==$endX) && (($Y)==$endY)){return true;}}
    } else if(!(($X-3)<0)){
        $OtherPieceType = whatPieceWeMoving($currentBoardState,$X-3,$Y);$OtherPieceTeam = substr($OtherPieceType,0,1);
        if(($OtherPieceTeam!=$team) && (($X-3)==$endX) && (($Y)==$endY)){return true;}}
    }   else if(!(($X-2)<0)){
        $OtherPieceType = whatPieceWeMoving($currentBoardState,$X-2,$Y);$OtherPieceTeam = substr($OtherPieceType,0,1);
        if(($OtherPieceTeam!=$team) && (($X-2)==$endX) && (($Y)==$endY)){return true;}}
    }   else if(!(($X-1)<0)){
        $OtherPieceType = whatPieceWeMoving($currentBoardState,$X-1,$Y);$OtherPieceTeam = substr($OtherPieceType,0,1);
        if(($OtherPieceTeam!=$team) && (($X-1)==$endX) && (($Y)==$endY)){return true;}}}
    //this is the ending of the right code
    //This is the beginning of the down-right code
    if(!(($X+1)>7 || ($Y+1)>7)){
    if($currentBoardState[$X+1][$Y+1]=="0"){
        if((($X+1)==$endX) && (($Y+1)==$endY)){
        return true;} 
            if($currentBoardState[$X+2][$Y+2]=="0"){
        if((($X+2)==$endX) && (($Y+2)==$endY)){
        return true;} 
                if($currentBoardState[$X+3][$Y+3]=="0"){
        if((($X+3)==$endX) && (($Y+3)==$endY)){
        return true;} 
                    if($currentBoardState[$X+4][$Y+4]=="0"){
        if((($X+4)==$endX) && (($Y+4)==$endY)){
        return true;} 
                        if($currentBoardState[$X+5][$Y+5]=="0"){
        if((($X+5)==$endX) && (($Y+5)==$endY)){
        return true;} 
                            if($currentBoardState[$X+6][$Y+6]=="0"){
        if((($X+6)==$endX) && (($Y+6)==$endY)){
        return true;} 
                                if($currentBoardState[$X+7][$Y+7]=="0"){
        if((($X+7)==$endX) && (($Y+7)==$endY)){
        return true;} 
    } else if(!(($X+7)>7 || ($Y+7)>7)){
        $OtherPieceType = whatPieceWeMoving($currentBoardState,$X+7,$Y+7);$OtherPieceTeam = substr($OtherPieceType,0,1);
        if(($OtherPieceTeam!=$team) && (($X+7)==$endX) && (($Y+7)==$endY)){return true;}}
    } else if(!(($X+6)>7 || ($Y+6)>7)){
        $OtherPieceType = whatPieceWeMoving($currentBoardState,$X+6,$Y+6);$OtherPieceTeam = substr($OtherPieceType,0,1);
        if(($OtherPieceTeam!=$team) && (($X+6)==$endX) && (($Y+6)==$endY)){return true;}}
    } else if(!(($X+5)>7 || ($Y+5)>7)){
        $OtherPieceType = whatPieceWeMoving($currentBoardState,$X+5,$Y+5);$OtherPieceTeam = substr($OtherPieceType,0,1);
        if(($OtherPieceTeam!=$team) && (($X+5)==$endX) && (($Y+5)==$endY)){return true;}}
    }   else if(!(($X+4)>7 || ($Y+4)>7)){
        $OtherPieceType = whatPieceWeMoving($currentBoardState,$X+4,$Y+4);$OtherPieceTeam = substr($OtherPieceType,0,1);
        if(($OtherPieceTeam!=$team) && (($X+4)==$endX) && (($Y+4)==$endY)){return true;}}
    } else if(!(($X+3)>7 || ($Y+3)>7)){
        $OtherPieceType = whatPieceWeMoving($currentBoardState,$X+3,$Y+3);$OtherPieceTeam = substr($OtherPieceType,0,1);
        if(($OtherPieceTeam!=$team) && (($X+3)==$endX) && (($Y+3)==$endY)){return true;}}
    }   else if(!(($X+2)>7 || ($Y+2)>7)){
        $OtherPieceType = whatPieceWeMoving($currentBoardState,$X+2,$Y+2);$OtherPieceTeam = substr($OtherPieceType,0,1);
        if(($OtherPieceTeam!=$team) && (($X+2)==$endX) && (($Y+2)==$endY)){return true;}}
    }   else if(!(($X+1)>7 || ($Y+1)>7)){
        $OtherPieceType = whatPieceWeMoving($currentBoardState,$X+1,$Y+1);$OtherPieceTeam = substr($OtherPieceType,0,1);
        if(($OtherPieceTeam!=$team) && (($X+1)==$endX) && (($Y+1)==$endY)){return true;}}}
    //this is the ending of the down right code
    //This is the beginning of the down-left code
    if(!(($X+1)>7 || ($Y-1)<0)){
    if($currentBoardState[$X+1][$Y-1]=="0"){
        if((($X+1)==$endX) && (($Y-1)==$endY)){
        return true;} 
            if($currentBoardState[$X+2][$Y-2]=="0"){
        if((($X+2)==$endX) && (($Y-2)==$endY)){
        return true;} 
                if($currentBoardState[$X+3][$Y-3]=="0"){
        if((($X+3)==$endX) && (($Y-3)==$endY)){
        return true;} 
                    if($currentBoardState[$X+4][$Y-4]=="0"){
        if((($X+4)==$endX) && (($Y-4)==$endY)){
        return true;} 
                        if($currentBoardState[$X+5][$Y-5]=="0"){
        if((($X+5)==$endX) && (($Y-5)==$endY)){
        return true;} 
                            if($currentBoardState[$X+6][$Y-6]=="0"){
        if((($X+6)==$endX) && (($Y-6)==$endY)){
        return true;} 
                                if($currentBoardState[$X+7][$Y-7]=="0"){
        if((($X+7)==$endX) && (($Y-7)==$endY)){
        return true;} 
    } else if(!(($X+7)>7 || ($Y-7)<0)){
        $OtherPieceType = whatPieceWeMoving($currentBoardState,$X+7,$Y-7);$OtherPieceTeam = substr($OtherPieceType,0,1);
        if(($OtherPieceTeam!=$team) && (($X+7)==$endX) && (($Y-7)==$endY)){return true;}}
    } else if(!(($X+6)>7 || ($Y-6)<0)){
        $OtherPieceType = whatPieceWeMoving($currentBoardState,$X+6,$Y-6);$OtherPieceTeam = substr($OtherPieceType,0,1);
        if(($OtherPieceTeam!=$team) && (($X+6)==$endX) && (($Y-6)==$endY)){return true;}}
    } else if(!(($X+5)>7 || ($Y-5)<0)){
        $OtherPieceType = whatPieceWeMoving($currentBoardState,$X+5,$Y-5);$OtherPieceTeam = substr($OtherPieceType,0,1);
        if(($OtherPieceTeam!=$team) && (($X+5)==$endX) && (($Y-5)==$endY)){return true;}}
    }   else if(!(($X+4)>7 || ($Y-4)<0)){
        $OtherPieceType = whatPieceWeMoving($currentBoardState,$X+4,$Y-4);$OtherPieceTeam = substr($OtherPieceType,0,1);
        if(($OtherPieceTeam!=$team) && (($X+4)==$endX) && (($Y-4)==$endY)){return true;}}
    } else if(!(($X+3)>7 || ($Y-3)<0)){
        $OtherPieceType = whatPieceWeMoving($currentBoardState,$X+3,$Y-3);$OtherPieceTeam = substr($OtherPieceType,0,1);
        if(($OtherPieceTeam!=$team) && (($X+3)==$endX) && (($Y-3)==$endY)){return true;}}
    }   else if(!(($X-2)>7 || ($Y-2)<0)){
        $OtherPieceType = whatPieceWeMoving($currentBoardState,$X+2,$Y-2);$OtherPieceTeam = substr($OtherPieceType,0,1);
        if(($OtherPieceTeam!=$team) && (($X+2)==$endX) && (($Y-2)==$endY)){return true;}}
    }   else if(!(($X+1)>7 || ($Y-1)<0)){
        $OtherPieceType = whatPieceWeMoving($currentBoardState,$X+1,$Y-1);$OtherPieceTeam = substr($OtherPieceType,0,1);
        if(($OtherPieceTeam!=$team) && (($X+1)==$endX) && (($Y-1)==$endY)){return true;}}}
    //this is the ending of the down left code
    //This is the beginning of the up-right code
    if(!(($X-1)<0 || ($Y+1)>7)){
    if($currentBoardState[$X-1][$Y+1]=="0"){
        if((($X-1)==$endX) && (($Y+1)==$endY)){
        return true;} 
            if($currentBoardState[$X-2][$Y+2]=="0"){
        if((($X-2)==$endX) && (($Y+2)==$endY)){
        return true;} 
                if($currentBoardState[$X-3][$Y+3]=="0"){
        if((($X-3)==$endX) && (($Y+3)==$endY)){
        return true;} 
                    if($currentBoardState[$X-4][$Y+4]=="0"){
        if((($X-4)==$endX) && (($Y+4)==$endY)){
        return true;} 
                        if($currentBoardState[$X-5][$Y+5]=="0"){
        if((($X-5)==$endX) && (($Y+5)==$endY)){
        return true;} 
                            if($currentBoardState[$X-6][$Y+6]=="0"){
        if((($X-6)==$endX) && (($Y+6)==$endY)){
        return true;} 
                                if($currentBoardState[$X-7][$Y+7]=="0"){
        if((($X-7)==$endX) && (($Y+7)==$endY)){
        return true;} 
    } else if(!(($X-7)<0 || ($Y+7)>7)){
        $OtherPieceType = whatPieceWeMoving($currentBoardState,$X-7,$Y+7);$OtherPieceTeam = substr($OtherPieceType,0,1);
        if(($OtherPieceTeam!=$team) && (($X-7)==$endX) && (($Y+7)==$endY)){return true;}}
    } else if(!(($X-6)<0 || ($Y+6)>7)){
        $OtherPieceType = whatPieceWeMoving($currentBoardState,$X-6,$Y+6);$OtherPieceTeam = substr($OtherPieceType,0,1);
        if(($OtherPieceTeam!=$team) && (($X-6)==$endX) && (($Y+6)==$endY)){return true;}}
    } else if(!(($X-5)<0 || ($Y+5)>7)){
        $OtherPieceType = whatPieceWeMoving($currentBoardState,$X-5,$Y+5);$OtherPieceTeam = substr($OtherPieceType,0,1);
        if(($OtherPieceTeam!=$team) && (($X-5)==$endX) && (($Y+5)==$endY)){return true;}}
    }   else if(!(($X-4)<0 || ($Y+4)>7)){
        $OtherPieceType = whatPieceWeMoving($currentBoardState,$X-4,$Y+4);$OtherPieceTeam = substr($OtherPieceType,0,1);
        if(($OtherPieceTeam!=$team) && (($X-4)==$endX) && (($Y+4)==$endY)){return true;}}
    } else if(!(($X-3)<0 || ($Y+3)>7)){
        $OtherPieceType = whatPieceWeMoving($currentBoardState,$X-3,$Y+3);$OtherPieceTeam = substr($OtherPieceType,0,1);
        if(($OtherPieceTeam!=$team) && (($X-3)==$endX) && (($Y+3)==$endY)){return true;}}
    }   else if(!(($X-2)<0 || ($Y+2)>7)){
        $OtherPieceType = whatPieceWeMoving($currentBoardState,$X-2,$Y+2);$OtherPieceTeam = substr($OtherPieceType,0,1);
        if(($OtherPieceTeam!=$team) && (($X-2)==$endX) && (($Y+2)==$endY)){return true;}}
    }   else if(!(($X-1)<0 || ($Y+1)>7)){
        $OtherPieceType = whatPieceWeMoving($currentBoardState,$X-1,$Y+1);$OtherPieceTeam = substr($OtherPieceType,0,1);
        if(($OtherPieceTeam!=$team) && (($X-1)==$endX) && (($Y+1)==$endY)){return true;}}}
    //this is the ending of the up right code
    //This is the beginning of the up-left code
    if(!(($X-1)<0 || ($Y-1)<0)){
    if($currentBoardState[$X-1][$Y-1]=="0"){
        if((($X-1)==$endX) && (($Y-1)==$endY)){
        return true;} 
            if($currentBoardState[$X-2][$Y-2]=="0"){
        if((($X-2)==$endX) && (($Y-2)==$endY)){
        return true;} 
                if($currentBoardState[$X-3][$Y-3]=="0"){
        if((($X-3)==$endX) && (($Y-3)==$endY)){
        return true;} 
                    if($currentBoardState[$X-4][$Y-4]=="0"){
        if((($X-4)==$endX) && (($Y-4)==$endY)){
        return true;} 
                        if($currentBoardState[$X-5][$Y-5]=="0"){
        if((($X-5)==$endX) && (($Y-5)==$endY)){
        return true;} 
                            if($currentBoardState[$X-6][$Y-6]=="0"){
        if((($X-6)==$endX) && (($Y-6)==$endY)){
        return true;} 
                                if($currentBoardState[$X-7][$Y-7]=="0"){
        if((($X-7)==$endX) && (($Y-7)==$endY)){
        return true;} 
    } else if(!(($X-7)<0 || ($Y-7)<0)){
        $OtherPieceType = whatPieceWeMoving($currentBoardState,$X-7,$Y-7);$OtherPieceTeam = substr($OtherPieceType,0,1);
        if(($OtherPieceTeam!=$team) && (($X-7)==$endX) && (($Y-7)==$endY)){return true;}}
    } else if(!(($X-6)<0 || ($Y-6)<0)){
        $OtherPieceType = whatPieceWeMoving($currentBoardState,$X-6,$Y-6);$OtherPieceTeam = substr($OtherPieceType,0,1);
        if(($OtherPieceTeam!=$team) && (($X-6)==$endX) && (($Y-6)==$endY)){return true;}}
    } else if(!(($X-5)<0 || ($Y-5)<0)){
        $OtherPieceType = whatPieceWeMoving($currentBoardState,$X-5,$Y-5);$OtherPieceTeam = substr($OtherPieceType,0,1);
        if(($OtherPieceTeam!=$team) && (($X-5)==$endX) && (($Y-5)==$endY)){return true;}}
    }   else if(!(($X-4)<0 || ($Y-4)<0)){
        $OtherPieceType = whatPieceWeMoving($currentBoardState,$X-4,$Y-4);$OtherPieceTeam = substr($OtherPieceType,0,1);
        if(($OtherPieceTeam!=$team) && (($X-4)==$endX) && (($Y-4)==$endY)){return true;}}
    } else if(!(($X-3)<0 || ($Y-3)<0)){
        $OtherPieceType = whatPieceWeMoving($currentBoardState,$X-3,$Y-3);$OtherPieceTeam = substr($OtherPieceType,0,1);
        if(($OtherPieceTeam!=$team) && (($X-3)==$endX) && (($Y-3)==$endY)){return true;}}
    }   else if(!(($X-2)<0 || ($Y-2)<0)){
        $OtherPieceType = whatPieceWeMoving($currentBoardState,$X-2,$Y-2);$OtherPieceTeam = substr($OtherPieceType,0,1);
        if(($OtherPieceTeam!=$team) && (($X-2)==$endX) && (($Y-2)==$endY)){return true;}}
    }   else if(!(($X-1)<0 || ($Y-1)<0)){
        $OtherPieceType = whatPieceWeMoving($currentBoardState,$X-1,$Y-1);$OtherPieceTeam = substr($OtherPieceType,0,1);
        if(($OtherPieceTeam!=$team) && (($X-1)==$endX) && (($Y-1)==$endY)){return true;}}}
    //this is the ending of the up left code   
}

function knight($currentBoardState,$X,$Y,$endX,$endY,$team){
    //This is the beginning of the knight code
    //x+2s
    if(!(($X+2)>7 || ($Y-1)<0)){
    if($currentBoardState[$X+2][$Y-1]=="0"){
        if((($X+2)==$endX) && (($Y-1)==$endY)){
        return true;} 
    } else {
        $OtherPieceType = whatPieceWeMoving($currentBoardState,$X+2,$Y-1);$OtherPieceTeam = substr($OtherPieceType,0,1);
        if(($OtherPieceTeam!=$team) && (($X+2)==$endX) && (($Y-1)==$endY)){return true;}}
    }

    if(!(($X+2)>7 || ($Y+1)>7)){
    if($currentBoardState[$X+2][$Y+1]=="0"){
        if((($X+2)==$endX) && (($Y+1)==$endY)){
        return true;} 
    } else {
        $OtherPieceType = whatPieceWeMoving($currentBoardState,$X+2,$Y+1);$OtherPieceTeam = substr($OtherPieceType,0,1);
        if(($OtherPieceTeam!=$team) && (($X+2)==$endX) && (($Y+1)==$endY)){return true;}}
    }
    //x-2s
    if(!(($X-2)<0 || ($Y-1)<0)){
    if($currentBoardState[$X-2][$Y-1]=="0"){
        if((($X-2)==$endX) && (($Y-1)==$endY)){
        return true;} 
    } else {
        $OtherPieceType = whatPieceWeMoving($currentBoardState,$X-2,$Y-1);$OtherPieceTeam = substr($OtherPieceType,0,1);
        if(($OtherPieceTeam!=$team) && (($X-2)==$endX) && (($Y-1)==$endY)){return true;}}
    }

    if(!(($X-2)<0 || ($Y+1)>7)){
    if($currentBoardState[$X-2][$Y+1]=="0"){
        if((($X-2)==$endX) && (($Y+1)==$endY)){
        return true;} 
    } else {
        $OtherPieceType = whatPieceWeMoving($currentBoardState,$X-2,$Y+1);$OtherPieceTeam = substr($OtherPieceType,0,1);
        if(($OtherPieceTeam!=$team) && (($X-2)==$endX) && (($Y+1)==$endY)){return true;}}
    }
    //y+2s
    if(!(($X+1)>7 || ($Y+2)>7)){
    if($currentBoardState[$X+1][$Y+2]=="0"){
        if((($X+1)==$endX) && (($Y+2)==$endY)){
        return true;} 
    } else {
        $OtherPieceType = whatPieceWeMoving($currentBoardState,$X+1,$Y+2);$OtherPieceTeam = substr($OtherPieceType,0,1);
        if(($OtherPieceTeam!=$team) && (($X+1)==$endX) && (($Y+2)==$endY)){return true;}}
    }

    if(!(($X-1)<0 || ($Y+2)>7)){
    if($currentBoardState[$X-1][$Y+2]=="0"){
        if((($X-1)==$endX) && (($Y+2)==$endY)){
        return true;} 
    } else {
        $OtherPieceType = whatPieceWeMoving($currentBoardState,$X-1,$Y+2);$OtherPieceTeam = substr($OtherPieceType,0,1);
        if(($OtherPieceTeam!=$team) && (($X-1)==$endX) && (($Y+2)==$endY)){return true;}}
    }
    //y-2s
    if(!(($X+1)>7 || ($Y-2)<0)){
    if($currentBoardState[$X+1][$Y-2]=="0"){
        if((($X+1)==$endX) && (($Y-2)==$endY)){
        return true;} 
    } else {
        $OtherPieceType = whatPieceWeMoving($currentBoardState,$X+1,$Y-2);$OtherPieceTeam = substr($OtherPieceType,0,1);
        if(($OtherPieceTeam!=$team) && (($X+1)==$endX) && (($Y-2)==$endY)){return true;}}
    }

    if(!(($X-1)<0 || ($Y-2)<0)){
    if($currentBoardState[$X-1][$Y-2]=="0"){
        if((($X-1)==$endX) && (($Y-2)==$endY)){
        return true;} 
    } else {
        $OtherPieceType = whatPieceWeMoving($currentBoardState,$X-1,$Y-2);$OtherPieceTeam = substr($OtherPieceType,0,1);
        if(($OtherPieceTeam!=$team) && (($X-1)==$endX) && (($Y-2)==$endY)){return true;}}
    }
}

function king($currentBoardState,$X,$Y,$endX,$endY,$team){
    //This is the beginning of the king code
    if(!(($X+1)>7 || ($Y+1)>7)){
    if($currentBoardState[$X+1][$Y+1]=="0"){
        if((($X+1)==$endX) && (($Y+1)==$endY)){
        return true;} 
    } else {
        $OtherPieceType = whatPieceWeMoving($currentBoardState,$X+1,$Y+1);$OtherPieceTeam = substr($OtherPieceType,0,1);
        if(($OtherPieceTeam!=$team) && (($X+1)==$endX) && (($Y+1)==$endY)){return true;}}
    }

    if(!(($X+1)>7)){
    if($currentBoardState[$X+1][$Y]=="0"){
        if((($X+1)==$endX) && (($Y)==$endY)){
        return true;} 
    } else {
        $OtherPieceType = whatPieceWeMoving($currentBoardState,$X+1,$Y);$OtherPieceTeam = substr($OtherPieceType,0,1);
        if(($OtherPieceTeam!=$team) && (($X+1)==$endX) && (($Y)==$endY)){return true;}}
    }

    if(!(($X-1)<0 || ($Y+1)>7)){
    if($currentBoardState[$X-1][$Y+1]=="0"){
        if((($X-1)==$endX) && (($Y+1)==$endY)){
        return true;} 
    } else {
        $OtherPieceType = whatPieceWeMoving($currentBoardState,$X-1,$Y+1);$OtherPieceTeam = substr($OtherPieceType,0,1);
        if(($OtherPieceTeam!=$team) && (($X-1)==$endX) && (($Y+1)==$endY)){return true;}}
    }

    if(!(($X-1)<0)){
    if($currentBoardState[$X-1][$Y]=="0"){
        if((($X-1)==$endX) && (($Y)==$endY)){
        return true;} 
    } else {
        $OtherPieceType = whatPieceWeMoving($currentBoardState,$X-1,$Y);$OtherPieceTeam = substr($OtherPieceType,0,1);
        if(($OtherPieceTeam!=$team) && (($X-1)==$endX) && (($Y)==$endY)){return true;}}
    }

    if(!(($X+1)>7 || ($Y-1)<0)){
    if($currentBoardState[$X+1][$Y-1]=="0"){
        if((($X+1)==$endX) && (($Y-1)==$endY)){
        return true;} 
    } else {
        $OtherPieceType = whatPieceWeMoving($currentBoardState,$X+1,$Y-1);$OtherPieceTeam = substr($OtherPieceType,0,1);
        if(($OtherPieceTeam!=$team) && (($X+1)==$endX) && (($Y-1)==$endY)){return true;}}
    }

    if(!(($Y-1)<0)){
    if($currentBoardState[$X][$Y-1]=="0"){
        if((($X)==$endX) && (($Y-1)==$endY)){
        return true;} 
    } else {
        $OtherPieceType = whatPieceWeMoving($currentBoardState,$X,$Y-1);$OtherPieceTeam = substr($OtherPieceType,0,1);
        if(($OtherPieceTeam!=$team) && (($X)==$endX) && (($Y-1)==$endY)){return true;}}
    }

    if(!(($X-1)<0 || ($Y-1)<0)){
    if($currentBoardState[$X-1][$Y-1]=="0"){
        if((($X-1)==$endX) && (($Y-1)==$endY)){
        return true;} 
    } else {
        $OtherPieceType = whatPieceWeMoving($currentBoardState,$X-1,$Y-1);$OtherPieceTeam = substr($OtherPieceType,0,1);
        if(($OtherPieceTeam!=$team) && (($X-1)==$endX) && (($Y-1)==$endY)){return true;}}
    }

    if(!(($Y+1)>7)){
    if($currentBoardState[$X][$Y+1]=="0"){
        if((($X)==$endX) && (($Y+1)==$endY)){
        return true;} 
    } else {
        $OtherPieceType = whatPieceWeMoving($currentBoardState,$X,$Y+1);$OtherPieceTeam = substr($OtherPieceType,0,1);
        if(($OtherPieceTeam!=$team) && (($X)==$endX) && (($Y+1)==$endY)){return true;}}
    }
    
}
?>