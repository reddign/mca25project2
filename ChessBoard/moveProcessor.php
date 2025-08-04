<?php
$currentBoardState=[
    ["wr","wn","wb","wq","wk","wb","wn","wr"],
    ["wp","wp","wp","wp","wp","wp","wp","wp"],
    ["0","0","0","0","0","0","0","0"],
    ["0","0","0","0","0","0","0","0"],
    ["0","0","0","0","0","0","0","0"],
    ["0","0","0","0","0","0","0","0"],
    ["bp","bp","bp","bp","bp","bp","bp","bp"],
    ["br","bn","bb","bq","bk","bb","bn","br"]];

$playerMove = ["a2","a4"];

mover($currentBoardState,$playerMove);

function mover($currentBoardState,$playersMove) {
    $initialY = substr($playersMove[0],0,1);
    $initialX = substr($playersMove[0],1,1);

    $endY = substr($playersMove[1],0,1);
    $endX = substr($playersMove[1],1,1);

    $initialY = changeintonumber($initialY);
    $endY = changeintonumber($endY);

    $initialX -= 1;
    $endX -= 1;

    $pieceType = whatPieceWeMoving($currentBoardState,$initialX,$initialY);
    $team = substr($pieceType,0,1);

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
    }
}

function whatPieceWeMoving($currentBoardState,$X,$Y) {
    $returning = $currentBoardState[$X][$Y];
    return $returning;
}

function whitePawn($currentBoardState,$X,$Y) {

}

function blackPawn($currentBoardState,$X,$Y) {
    
}

function knight($currentBoardState,$X,$Y) {

}

function bishop($currentBoardState,$X,$Y) {
    
}




?>