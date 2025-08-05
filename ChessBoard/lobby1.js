let canvas = document.querySelector("canvas")
let graphics = canvas.getContext("2d")


let currentBoardState=[
    ["wr","wn","wb","wq","wk","wb","wn","wr"],
    ["wp","wp","wp","wp","wp","wp","wp","wp"],
    ["0","0","0","0","0","0","0","0"],
    ["0","0","0","0","0","0","0","0"],
    ["0","0","0","0","0","0","0","0"],
    ["0","0","0","0","0","0","0","0"],
    ["bp","bp","bp","bp","bp","bp","bp","bp"],
    ["br","bn","bb","bq","bk","bb","bn","br"]
];


displayPieces()
function displayPieces(){
    //Draws the pieces to the canvas based on the current board state
}

selectPiece();
function selectPiece(){
    //on click, if there is a piece there, then select it. Press Esc to cancel selection


}





drawBoard()
function drawBoard(){
    //Draws the board to the canvas
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
}