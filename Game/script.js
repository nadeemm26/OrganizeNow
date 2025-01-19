console.log("Welcome , Tic Tac Toe")
let music = new Audio("/Game/tic tac toe/music.mp3")
let ting = new Audio("/Game/tic tac toe/ting.mp3")
let gameover = new Audio("/Game/tic tac toe/gameover.mp3")
let turn = "X"

//change turn x to o
const changeTurn =()=>{
    return turn ==="X"?"0":"X"
} 

//check for win
const checkWin =()=>{
    let win =[
        [0,1,2],
        [3,4,5],
        [6,7,8],
        [0,3,6],
        [1,4,7],
        [2,5,8],
        [0,4,8],
        [2,4,6],
    ]
}

//start
let boxes = document.getElementsByClassName("box");
Array.from(boxes).forEach(element =>{
    let boxtext = element.querySelector('.boxtext');
    element.addEventListener('click',()=>{
        if(boxtext.innerText === ''){
            boxtext.innerText = turn;
            turn = changeTurn();
            ting.play();
            checkWin();
            document.getElementsByClassName("info")[0].innerText = "Turn For "+turn;
        }
    })
})