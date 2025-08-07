let canvas = document.querySelector("canvas")
let graphics = canvas.getContext("2d")

let wPawnImg = document.getElementById("whitePawn")
let bPawnImg = document.getElementById("blackPawn")
let wBishopImg = document.getElementById("whiteBishop")
let bBishopImg = document.getElementById("blackBishop")
let wKnightImg = document.getElementById("whiteKnight")
let bKnightImg = document.getElementById("blackKnight")
let wRookImg = document.getElementById("whiteRook")
let bRookImg = document.getElementById("blackRook")
let wQueenImg = document.getElementById("whiteQueen")
let bQueenImg = document.getElementById("blackQueen")
let wKingImg = document.getElementById("whiteKing")
let bKingImg = document.getElementById("blackKing")



drawBoard()


let currentBoardState = jsBoard;
// [
//     ["wr","wn","wb","wq","wk","wb","wn","wr"],
//     ["wp","wp","wp","wp","wp","wp","wp","wp"],
//     ["0","0","0","0","0","0","0","0"],
//     ["0","0","0","0","0","0","0","0"],
//     ["0","0","0","0","0","0","0","0"],
//     ["0","0","0","0","0","0","0","0"],
//     ["bp","bp","bp","bp","bp","bp","bp","bp"],
//     ["br","bn","bb","bq","bk","bb","bn","br"]
// ];

let currentDrawPiece = wPawnImg


wPawnImg.onload = function() {
    img1 = true;
    checkIfImagesLoaded();
    console.log("Image1 loaded")
};

bPawnImg.onload = function() {
    img2 = true;
    checkIfImagesLoaded();
    console.log("Image2 loaded")

};

wKnightImg.onload = function() {
    img3 = true;
    checkIfImagesLoaded();
    console.log("Image3 loaded")

};

bKnightImg.onload = function() {
    img4 = true;
    checkIfImagesLoaded();
    console.log("Image4 loaded")

};

wBishopImg.onload = function() {
    img5 = true;
    checkIfImagesLoaded();
    console.log("Image5 loaded")

};

bBishopImg.onload = function() {
    img6 = true;
    checkIfImagesLoaded();
    console.log("Image6 loaded")

};

wRookImg.onload = function() {
    img7 = true;
    checkIfImagesLoaded();
    console.log("Image7 loaded")

};

bRookImg.onload = function() {
    img8 = true;
    checkIfImagesLoaded();
    console.log("Image8 loaded")

};

wQueenImg.onload = function() {
    img9 = true;
    checkIfImagesLoaded();
    console.log("Image9 loaded")

};

bQueenImg.onload = function() {
    img10 = true;
    checkIfImagesLoaded();
    console.log("Image10 loaded")

};

wKingImg.onload = function() {
    img11 = true;
    checkIfImagesLoaded();
    console.log("Image11 loaded")

};

bKingImg.onload = function() {
    img12 = true;
    checkIfImagesLoaded();
    console.log("Image12 loaded")

};


function checkIfImagesLoaded(){

    if (img1 && img2 && img3 && img4 && img5 && img6 && img7 && img8 && img9 && img10 && img11 && img12){
        displayPieces()

    }
}



function displayPieces(){

    for(let row=0;row<8;row++){
        for(let column=0;column<8;column++){
            if(currentBoardState[row][column]=="wp"){
                currentDrawPiece = wPawnImg
            } else if(currentBoardState[row][column]=="bp"){
                currentDrawPiece = bPawnImg
            } else if(currentBoardState[row][column]=="wb"){
                currentDrawPiece = wBishopImg
            } else if(currentBoardState[row][column]=="bb"){
                currentDrawPiece = bBishopImg
            } else if(currentBoardState[row][column]=="wn"){
                currentDrawPiece = wKnightImg
            } else if(currentBoardState[row][column]=="bn"){
                currentDrawPiece = bKnightImg
            } else if(currentBoardState[row][column]=="wr"){
                currentDrawPiece = wRookImg
            } else if(currentBoardState[row][column]=="br"){
                currentDrawPiece = bRookImg
            } else if(currentBoardState[row][column]=="wq"){
                currentDrawPiece = wQueenImg
            } else if(currentBoardState[row][column]=="bq"){
                currentDrawPiece = bQueenImg
            } else if(currentBoardState[row][column]=="wk"){
                currentDrawPiece = wKingImg
            } else if(currentBoardState[row][column]=="bk"){
                currentDrawPiece = bKingImg
            } else {
                currentDrawPiece = "0"
            }
            if(currentDrawPiece != "0"){
                graphics.drawImage(currentDrawPiece, column*60, row*60)
            }
        }
    }



}

let isAnySelected = false;

let columnLetter = "A"
let rowNumber = "1"

let selectedSquare = "A2"

let moveToSquare = "A3"

let sendInfo = ["A2", 0]

function selectPiece(event){
    //on click, if there is a piece there, then select it
    let canvasrect = canvas.getBoundingClientRect()

    let x = event.clientX - canvasrect.x
    let y = event.clientY - canvasrect.y

    getChessCoordinates(x, y)


    if(isAnySelected){
        isAnySelected = false
        drawBoard()
        displayPieces()
        moveToSquare = getChessCoordinates(x, y)
        sendInfo[1] = moveToSquare
        console.log(sendInfo)

        document.getElementById("jsVar1").value = sendInfo[0];
        document.getElementById("jsVar2").value = sendInfo[1];

        document.getElementById('myForm').submit();

    } else{


         if(currentBoardState[rowNumber][columnLetter[1]]=="0"){
            selectedSquare = 0

        } else{

            selectedSquare = getChessCoordinates(x, y)
            graphics.fillStyle="red"
            graphics.fillRect(columnLetter[1]*60,rowNumber*60, 60, 60)
            displayPieces()
            sendInfo[0] = selectedSquare
            sendInfo[1] = 0

            isAnySelected = true
            console.log(selectedSquare)

        }
    }

}

// Pressing escape cancels the selection
document.addEventListener('keydown', function(event) {
        if (event.key === 'Escape') {
        
            isAnySelected = false
            drawBoard()
            displayPieces()
            sendInfo[0] = 0
            sendInfo[1] = 0
        }
    });


function getChessCoordinates(x, y){
    if(x<=60){
        columnLetter = ["a",0]
    } else if(x<=120 && x>60){
        columnLetter = ["b",1]
    } else if(x<=180 && x>120){
        columnLetter = ["c",2]
    } else if(x<=240 && x>180){
        columnLetter = ["d",3]
    } else if(x<=300 && x>240){
        columnLetter = ["e",4]
    } else if(x<=360 && x>300){
        columnLetter = ["f",5]
    } else if(x<=420 && x>360){
        columnLetter = ["g",6]
    } else if(x<=480 && x>420){
        columnLetter = ["h",7]
    } 

    if(y<=60){
        rowNumber = 0
    } else if(y<=120 && y>60){
        rowNumber = 1
    } else if(y<=180 && y>120){
        rowNumber = 2
    } else if(y<=240 && y>180){
        rowNumber = 3
    } else if(y<=300 && y>240){
        rowNumber = 4
    } else if(y<=360 && y>300){
        rowNumber = 5
    } else if(y<=420 && y>360){
        rowNumber = 6
    } else if(y<=480 && y>420){
        rowNumber = 7
    } 
    return columnLetter[0]+(rowNumber+1)
}




function drawBoard(){
    let offset=0;
    graphics.fillStyle="White"

    for(j=0;j<480;j+=60){
        if(offset==0){
            offset=60
        }else{
            offset=0
        }
        for(i=0;i<480;i+=120){
            graphics.fillRect(i+offset, j, 60, 60)
        }
    }

    let offset2=60;
    graphics.fillStyle="Grey"

    for(j=0;j<480;j+=60){
        if(offset2==0){
            offset2=60
        }else{
            offset2=0
        }
        for(i=0;i<480;i+=120){
            graphics.fillRect(i+offset2, j, 60, 60)
        }
    }
}