<?php
$currentBoardState=[
    ["wr","wn","wb","wq","wk","wb","wk","wr"],
    ["wp","wp","wp","wp","wp","wp","wp","wp"],
    ["0","0","0","0","0","0","0","0"],
    ["0","0","0","0","0","0","0","0"],
    ["0","0","0","0","0","0","0","0"],
    ["0","0","0","0","0","0","0","0"],
    ["bp","bp","bp","bp","bp","bp","bp","bp"],
    ["br","bn","bb","bq","bk","bb","bk","br"]];

$playerMove = ["a2","a4"];

mover($playerMove);

function mover($playersMove) {
    $initialX = substr($playersMove[0],0,1);
    $initialY = substr($playersMove[0],1,1);

    $endX = substr($playersMove[1],0,1);
    $endY = substr($playersMove[1],1,1);

    $initialX = changeintonumber($initialX);
    $endX = changeintonumber($endX);

    print_r($initialX);
    print("<br>");

}

function changeintonumber($inputLetter){
    if ($inputLetter == "a"){
        return "1";
    }
}

?>