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
    print_r($initialY);
    print("<br>");
    print_r($endX);
    print("<br>");
    print_r($endY);
    print("<br>");

}

function changeintonumber($inputLetter){
    if ($inputLetter == "a"){
        return "1";
    } else if ($inputLetter == "b"){
        return "2";
    } else if ($inputLetter == "c"){
        return "3";
    } else if ($inputLetter == "d"){
        return "4";
    } else if ($inputLetter == "e"){
        return "5";
    } else if ($inputLetter == "f"){
        return "6";
    } else if ($inputLetter == "g"){
        return "7";
    } else if ($inputLetter == "h"){
        return "8";
    }
}

?>