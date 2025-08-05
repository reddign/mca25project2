<?php
$currentBoardState=[
    ["wr","wn","wb","wq","wk","wb","wn","wr"], //row 0
    ["wp","wp","wp","0","wp","wp","wp","wp"], //row 1
    ["0","0","0","0","0","0","0","0"], //row 2
    ["0","0","0","0","0","0","0","0"], //row 3
    ["0","0","0","0","0","0","0","0"], //row 4
    ["0","0","0","0","0","0","0","0"], //row 5
    ["bp","bp","bp","bp","bp","bp","bp","bp"], //row 6
    ["br","bn","bb","bq","bk","bb","bn","br"]]; //row 7

$playerMove = ["e7","e5"];

mover($currentBoardState,$playerMove);

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
    }

    displayinator($initialY,$initialX,$endY,$endX,$pieceType,$team,$playersMove,$legalMove);}
    else {
        $legalMove=false;
    }
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
    if($X==1 || $Y==$endY)
        {
        if(($currentBoardState[$X+1][$Y] == "0")&&($currentBoardState[$X+2][$Y] == "0")){
            if(($endX==($X+2))){
                return true;}
            }
        } 
    if (($currentBoardState[$X+1][$Y] == "0")&&($endX==($X+1))) {
        return true;
    }
    //These if statements will check captures. (I wont have enpassant unless I have extra time)
    if  (($currentBoardState[$X+1][$Y] != "0")&&(($Y-1)==$endY)&&($endX==($X+1))){
        return true;
    } else if  (($currentBoardState[$X+1][$Y] != "0")&&(($Y+1)==$endY)&&($endX==($X+1))){
        return true;
    }
}

function blackPawn($currentBoardState,$X,$Y,$endX,$endY) {
    //these 2 if statements check the forwards moves. NOT captures.
    if($Y==$endY)
        {
        if(($currentBoardState[$X-1][$Y] == "0")&&($currentBoardState[$X-2][$Y] == "0")&&($X==6)){
            if(($endX==($X-2))){
                return true;}
            }
        } 
    if (($currentBoardState[$X-1][$Y] == "0")&&($endX==($X-1))) {
        return true;
    }
    //These if statements will check captures. (I wont have time to add enpassant unless I have extra time)
    if  (($currentBoardState[$X-1][$Y] != "0")&&(($Y-1)==$endY)&&($endX==($X-1))){
        return true;
    } else if  (($currentBoardState[$X-1][$Y] != "0")&&(($Y+1)==$endY)&&($endX==($X-1))){
        return true;
    }
}
function bishop($currentBoardState,$X,$Y,$endX,$endY,$team) {
    //This is the beginning of the down-right code
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
    } else {
        $OtherPieceType = whatPieceWeMoving($currentBoardState,$X+7,$Y+7);$OtherPieceTeam = substr($OtherPieceType,0,1);
        if($OtherPieceTeam!=$team){return true;}}
    } else {
        $OtherPieceType = whatPieceWeMoving($currentBoardState,$X+6,$Y+6);$OtherPieceTeam = substr($OtherPieceType,0,1);
        if($OtherPieceTeam!=$team){return true;}}
    } else {
        $OtherPieceType = whatPieceWeMoving($currentBoardState,$X+5,$Y+5);$OtherPieceTeam = substr($OtherPieceType,0,1);
        if($OtherPieceTeam!=$team){return true;}}
    }   else {
        $OtherPieceType = whatPieceWeMoving($currentBoardState,$X+4,$Y+4);$OtherPieceTeam = substr($OtherPieceType,0,1);
        if($OtherPieceTeam!=$team){return true;}}
    } else {
        $OtherPieceType = whatPieceWeMoving($currentBoardState,$X+3,$Y+3);$OtherPieceTeam = substr($OtherPieceType,0,1);
        if($OtherPieceTeam!=$team){return true;}}
    }   else {
        $OtherPieceType = whatPieceWeMoving($currentBoardState,$X+2,$Y+2);$OtherPieceTeam = substr($OtherPieceType,0,1);
        if($OtherPieceTeam!=$team){return true;}}
    }   else {
        $OtherPieceType = whatPieceWeMoving($currentBoardState,$X+1,$Y+1);$OtherPieceTeam = substr($OtherPieceType,0,1);
        if($OtherPieceTeam!=$team){return true;}}
    //this is the ending of the down right code
    //This is the beginning of the down-left code
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
    } else {
        $OtherPieceType = whatPieceWeMoving($currentBoardState,$X+7,$Y-7);$OtherPieceTeam = substr($OtherPieceType,0,1);
        if($OtherPieceTeam!=$team){return true;}}
    } else {
        $OtherPieceType = whatPieceWeMoving($currentBoardState,$X+6,$Y-6);$OtherPieceTeam = substr($OtherPieceType,0,1);
        if($OtherPieceTeam!=$team){return true;}}
    } else {
        $OtherPieceType = whatPieceWeMoving($currentBoardState,$X+5,$Y-5);$OtherPieceTeam = substr($OtherPieceType,0,1);
        if($OtherPieceTeam!=$team){return true;}}
    }   else {
        $OtherPieceType = whatPieceWeMoving($currentBoardState,$X+4,$Y-4);$OtherPieceTeam = substr($OtherPieceType,0,1);
        if($OtherPieceTeam!=$team){return true;}}
    } else {
        $OtherPieceType = whatPieceWeMoving($currentBoardState,$X+3,$Y-3);$OtherPieceTeam = substr($OtherPieceType,0,1);
        if($OtherPieceTeam!=$team){return true;}}
    }   else {
        $OtherPieceType = whatPieceWeMoving($currentBoardState,$X+2,$Y-2);$OtherPieceTeam = substr($OtherPieceType,0,1);
        if($OtherPieceTeam!=$team){return true;}}
    }   else {
        $OtherPieceType = whatPieceWeMoving($currentBoardState,$X+1,$Y-1);$OtherPieceTeam = substr($OtherPieceType,0,1);
        if($OtherPieceTeam!=$team){return true;}}
    //this is the ending of the down left code
    //This is the beginning of the up-right code
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
    } else {
        $OtherPieceType = whatPieceWeMoving($currentBoardState,$X-7,$Y+7);$OtherPieceTeam = substr($OtherPieceType,0,1);
        if($OtherPieceTeam!=$team){return true;}}
    } else {
        $OtherPieceType = whatPieceWeMoving($currentBoardState,$X-6,$Y+6);$OtherPieceTeam = substr($OtherPieceType,0,1);
        if($OtherPieceTeam!=$team){return true;}}
    } else {
        $OtherPieceType = whatPieceWeMoving($currentBoardState,$X-5,$Y+5);$OtherPieceTeam = substr($OtherPieceType,0,1);
        if($OtherPieceTeam!=$team){return true;}}
    }   else {
        $OtherPieceType = whatPieceWeMoving($currentBoardState,$X-4,$Y+4);$OtherPieceTeam = substr($OtherPieceType,0,1);
        if($OtherPieceTeam!=$team){return true;}}
    } else {
        $OtherPieceType = whatPieceWeMoving($currentBoardState,$X-3,$Y+3);$OtherPieceTeam = substr($OtherPieceType,0,1);
        if($OtherPieceTeam!=$team){return true;}}
    }   else {
        $OtherPieceType = whatPieceWeMoving($currentBoardState,$X-2,$Y+2);$OtherPieceTeam = substr($OtherPieceType,0,1);
        if($OtherPieceTeam!=$team){return true;}}
    }   else {
        $OtherPieceType = whatPieceWeMoving($currentBoardState,$X-1,$Y+1);$OtherPieceTeam = substr($OtherPieceType,0,1);
        if($OtherPieceTeam!=$team){return true;}}
    //this is the ending of the up right code
    //This is the beginning of the up-left code
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
    } else {
        $OtherPieceType = whatPieceWeMoving($currentBoardState,$X-7,$Y-7);$OtherPieceTeam = substr($OtherPieceType,0,1);
        if($OtherPieceTeam!=$team){return true;}}
    } else {
        $OtherPieceType = whatPieceWeMoving($currentBoardState,$X-6,$Y-6);$OtherPieceTeam = substr($OtherPieceType,0,1);
        if($OtherPieceTeam!=$team){return true;}}
    } else {
        $OtherPieceType = whatPieceWeMoving($currentBoardState,$X-5,$Y-5);$OtherPieceTeam = substr($OtherPieceType,0,1);
        if($OtherPieceTeam!=$team){return true;}}
    }   else {
        $OtherPieceType = whatPieceWeMoving($currentBoardState,$X-4,$Y-4);$OtherPieceTeam = substr($OtherPieceType,0,1);
        if($OtherPieceTeam!=$team){return true;}}
    } else {
        $OtherPieceType = whatPieceWeMoving($currentBoardState,$X-3,$Y-3);$OtherPieceTeam = substr($OtherPieceType,0,1);
        if($OtherPieceTeam!=$team){return true;}}
    }   else {
        $OtherPieceType = whatPieceWeMoving($currentBoardState,$X-2,$Y-2);$OtherPieceTeam = substr($OtherPieceType,0,1);
        if($OtherPieceTeam!=$team){return true;}}
    }   else {
        $OtherPieceType = whatPieceWeMoving($currentBoardState,$X-1,$Y-1);$OtherPieceTeam = substr($OtherPieceType,0,1);
        if($OtherPieceTeam!=$team){return true;}}
    //this is the ending of the up left code   
}
?>