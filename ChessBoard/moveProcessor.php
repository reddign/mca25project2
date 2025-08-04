<?php
$currentBoardState=[
    ["wr","wn","wb","wq","wk","wb","wn","wr"],
    ["wp","wp Correct","wp","wp","wp","wp","wp","wp"],
    ["0","0","0","0","0","0","0","0"],
    ["0","0","0","0","0","0","0","0"],
    ["0","0","0","0","0","0","0","0"],
    ["0","0","0","0","0","0","0","0"],
    ["bp","bp","bp","bp","bp","bp","bp","bp"],
    ["br","bn","bb","bq","bk","bb","bn","br"]];

$playerMove = ["b2","a4"];

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
    print_r($initialY);
    print("<br>");
    print_r($initialX);
    print("<br>");
    print_r($endY);
    print("<br>");
    print_r($endX);
    print("<br>");
    print_r(whatPieceWeMoving($currentBoardState,$initialX,$initialY));

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
    
    $returning = $currentBoardState[$Y][$X];
    return $returning;
}

?>