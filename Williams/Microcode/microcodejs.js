var myCanvas = document.getElementById("microCanvas");

//Variable for the checkbox that turns off having to input the instruction fetch and program counter increment
//var toggleFirstThree = document.getElementById("toggleFirstThree");

var bus = myCanvas.getContext('2d');
bus.fillStyle = "black";
bus.fillRect(0, 200, 800, 3);

var instrucReg = myCanvas.getContext('2d');
instrucReg.fillStyle = "lightgrey";
instrucReg.fillRect(40,70,50,80);
instrucReg.fill();
instrucReg.font = "10px Arial";
instrucReg.textAlign = "center";
instrucReg.strokeText("I R", 60,100);
var irInArrow = myCanvas.getContext('2d');

function drawIrInClosed() {

    var irInClosed = new Image();
    irInClosed.onload = function () {
        irInArrow.drawImage(irInClosed, 40, 150, 20, 50);
    };
    irInClosed.src = 'switchClosed.gif';
}
function drawIrInOpen() {

    var irInOpen = new Image();
    irInOpen.onload = function () {
        irInArrow.drawImage(irInOpen, 40, 150, 20, 50);
    };
    irInOpen.src = 'switchOpen.gif';
}

var irOutArrow = myCanvas.getContext('2d');

function drawIrOutClosed() {

    var irOutClosed = new Image();
    irOutClosed.onload = function () {
        irOutArrow.drawImage(irOutClosed, 70, 150, 20, 50);
    };
    irOutClosed.src = 'switchClosedDown.gif';
}

function drawIrOutOpen() {

    var irOutOpen = new Image();
    irOutOpen.onload = function () {
        irOutArrow.drawImage(irOutOpen, 70, 150, 20, 50);
    };
    irOutOpen.src = 'switchOpenDown.gif';
}

var resultReg = myCanvas.getContext('2d');
resultReg.fillStyle = "lightgrey";
resultReg.fillRect(170, 70, 50, 80);
resultReg.font = "10px Arial";
resultReg.textAlign = "center";
resultReg.strokeText("RESULT", 195,100);

var resultOutArrow = myCanvas.getContext('2d');

function drawResultOutClosed() {

    var resultOutClosed = new Image();
    resultOutClosed.onload = function () {
        resultOutArrow.drawImage(resultOutClosed, 185, 150, 20, 50);
    };
    resultOutClosed.src = 'switchClosedDown.gif';
}

function drawResultOutOpen() {

    var resultOutOpen = new Image();
    resultOutOpen.onload = function () {
        resultOutArrow.drawImage(resultOutOpen, 185, 150, 20, 50);
    };
    resultOutOpen.src = 'switchOpenDown.gif';
}

var alunit = myCanvas.getContext('2d');
alunit.beginPath();
alunit.moveTo(270,100);
alunit.lineTo(325,70);
alunit.lineTo(325,95);
alunit.lineTo(305,110);
alunit.lineTo(305,120);
alunit.lineTo(325,150);
alunit.lineTo(295,150);
alunit.lineTo(270,125);
alunit.fill();
alunit.font = "10px Arial";
alunit.textAlign = "center";
alunit.strokeText("A L U", 290,115);

var fromOpArrow = myCanvas.getContext('2d');

function drawFromOpClosed() {

    var fromOpClosed = new Image();
    fromOpClosed.onload = function () {
        fromOpArrow.drawImage(fromOpClosed, 325, 70, 45, 20);
    };
    fromOpClosed.src = 'aluSwitchClosed.gif';
}

function drawFromOpOpen() {

    var fromOpOpen = new Image();
    fromOpOpen.onload = function () {
        fromOpArrow.drawImage(fromOpOpen, 325, 70, 45, 20);
    };
    fromOpOpen.src = 'aluSwitchOpen.gif';
}

var aluInArrow = myCanvas.getContext('2d');

function drawAluInClosed() {

    var aluInClosed = new Image();
    aluInClosed.onload = function () {
        aluInArrow.drawImage(aluInClosed, 295, 150, 20, 50);
    };
    aluInClosed.src = 'switchClosed.gif';
}

function drawAluInOpen() {

    var aluInOpen = new Image();
    aluInOpen.onload = function () {
        aluInArrow.drawImage(aluInOpen, 295, 150, 20, 50);
    };
    aluInOpen.src = 'switchOpen.gif';
}

var fromALUArrow = myCanvas.getContext('2d');

function drawFromAluClosed() {

    var fromALUClosed = new Image();
    fromALUClosed.onload = function () {
        fromALUArrow.drawImage(fromALUClosed, 220, 100, 50, 20);
    };
    fromALUClosed.src = 'aluSwitchClosed.gif';
}

function drawFromAluOpen() {

    var fromALUOpen = new Image();
    fromALUOpen.onload = function () {
        fromALUArrow.drawImage(fromALUOpen, 220, 100, 50, 20);
    };
    fromALUOpen.src = 'aluSwitchOpen.gif';
}

var opReg = myCanvas.getContext('2d');
opReg.fillStyle = "lightgrey";
opReg.fillRect(370, 70, 50, 80);
opReg.font = "10px Arial";
opReg.textAlign = "center";
opReg.strokeText("O P", 390,100);

var opInArrow = myCanvas.getContext('2d');

function drawOpInClosed() {

    var opInClosed = new Image();
    opInClosed.onload = function () {
        opInArrow.drawImage(opInClosed, 385, 150, 20, 50);
    };
    opInClosed.src = 'switchClosed.gif';
}

function drawOpInOpen() {

    var opInOpen = new Image();
    opInOpen.onload = function () {
        opInArrow.drawImage(opInOpen, 385, 150, 20, 50);
    };
    opInOpen.src = 'switchOpen.gif';
}

/** var opOutArrow = myCanvas.getContext('2d');

 function drawOpOutClosed() {

    var opOutClosed = new Image();
    opOutClosed.onload = function () {
        opOutArrow.drawImage(opOutClosed, 400, 150, 20, 50);
    };
    opOutClosed.src = 'switchClosedDown.gif';
}

 function drawOpOutOpen() {

    var opOutOpen = new Image();
    opOutOpen.onload = function () {
        opOutArrow.drawImage(opOutOpen, 400, 150, 20, 50);
    };
    opOutOpen.src = 'switchOpenDown.gif';
} **/

var pcReg = myCanvas.getContext('2d');
pcReg.fillStyle = "lightgrey";
pcReg.fillRect(470, 70, 50, 80);
pcReg.font = "10px Arial";
pcReg.textAlign = "center";
pcReg.strokeText("P C", 490,100);

var pcInArrow = myCanvas.getContext('2d');

function drawPcInClosed() {

    var pcInClosed = new Image();
    pcInClosed.onload = function () {
        pcInArrow.drawImage(pcInClosed, 470, 150, 20, 50);
    };
    pcInClosed.src = 'switchClosed.gif';
}

function drawPcInOpen() {

    var pcInOpen = new Image();
    pcInOpen.onload = function () {
        pcInArrow.drawImage(pcInOpen, 470, 150, 20, 50);
    };
    pcInOpen.src = 'switchOpen.gif';
}

var pcOutArrow = myCanvas.getContext('2d');

function drawPcOutClosed() {

    var pcOutClosed = new Image();
    pcOutClosed.onload = function () {
        pcOutArrow.drawImage(pcOutClosed, 500, 150, 20, 50);
    };
    pcOutClosed.src = 'switchClosedDown.gif';
}

function drawPcOutOpen() {

    var pcOutOpen = new Image();
    pcOutOpen.onload = function () {
        pcOutArrow.drawImage(pcOutOpen, 500, 150, 20, 50);
    };
    pcOutOpen.src = 'switchOpenDown.gif';
}

var r1Reg = myCanvas.getContext('2d');
r1Reg.fillStyle = "lightgrey";
r1Reg.fillRect(570, 70, 50, 80);
pcReg.font = "10px Arial";
pcReg.textAlign = "center";
pcReg.strokeText("R 1", 590,100);

var r1InArrow = myCanvas.getContext('2d');

function drawR1InClosed() {

    var r1InClosed = new Image();
    r1InClosed.onload = function () {
        r1InArrow.drawImage(r1InClosed, 570, 150, 20, 50);
    };
    r1InClosed.src = 'switchClosed.gif';
}

function drawR1InOpen() {

    var r1InOpen = new Image();
    r1InOpen.onload = function () {
        r1InArrow.drawImage(r1InOpen, 570, 150, 20, 50);
    };
    r1InOpen.src = 'switchOpen.gif';
}

var r1OutArrow = myCanvas.getContext('2d');

function drawR1OutClosed() {

    var r1OutClosed = new Image();
    r1OutClosed.onload = function () {
        r1OutArrow.drawImage(r1OutClosed, 600, 150, 20, 50);
    };
    r1OutClosed.src = 'switchClosedDown.gif';
}

function drawR1OutOpen() {

    var r1OutOpen = new Image();
    r1OutOpen.onload = function () {
        r1OutArrow.drawImage(r1OutOpen, 600, 150, 20, 50);
    };
    r1OutOpen.src = 'switchOpenDown.gif';
}

var r2Reg = myCanvas.getContext('2d');
r2Reg.fillStyle = "lightgrey";
r2Reg.fillRect(670, 70, 50, 80);
pcReg.font = "10px Arial";
pcReg.textAlign = "center";
pcReg.strokeText("R 2", 690,100);

var r2InArrow = myCanvas.getContext('2d');

function drawR2InClosed() {

    var r2InClosed = new Image();
    r2InClosed.onload = function () {
        r2InArrow.drawImage(r2InClosed, 670, 150, 20, 50);
    };
    r2InClosed.src = 'switchClosed.gif';
}

function drawR2InOpen() {

    var r2InOpen = new Image();
    r2InOpen.onload = function () {
        r2InArrow.drawImage(r2InOpen, 670, 150, 20, 50);
    };
    r2InOpen.src = 'switchOpen.gif';
}

var r2OutArrow = myCanvas.getContext('2d');

function drawR2OutClosed() {

    var r2OutClosed = new Image();
    r2OutClosed.onload = function () {
        r2OutArrow.drawImage(r2OutClosed, 700, 150, 20, 50);
    };
    r2OutClosed.src = 'switchClosedDown.gif';
}

function drawR2OutOpen() {

    var r2OutOpen = new Image();
    r2OutOpen.onload = function () {
        r2OutArrow.drawImage(r2OutOpen, 700, 150, 20, 50);
    };
    r2OutOpen.src = 'switchOpenDown.gif';
}

var memAddReg = myCanvas.getContext('2d');
memAddReg.fillStyle = "lightGrey";
memAddReg.fillRect(70,253,50,60);
pcReg.font = "10px Arial";
pcReg.textAlign = "center";
pcReg.strokeText("M A R", 95, 273);

var marInArrow = myCanvas.getContext('2d');

function drawMarInClosed() {

    var marInClosed = new Image();
    marInClosed.onload = function () {
        marInArrow.drawImage(marInClosed, 85, 203, 20, 50);
    };
    marInClosed.src = 'switchClosedDown.gif';
}

function drawMarInOpen() {

    var marInOpen = new Image();
    marInOpen.onload = function () {
        marInArrow.drawImage(marInOpen, 85, 203, 20, 50);
    };
    marInOpen.src = 'switchOpenDown.gif';
}

var memBufReg = myCanvas.getContext('2d');
memBufReg.fillStyle = "lightgrey";
memBufReg.fillRect(500,253,50,60);
pcReg.font = "10px Arial";
pcReg.textAlign = "center";
pcReg.strokeText("M B R", 525,273);

var mbrInArrow = myCanvas.getContext('2d');

function drawMbrInClosed() {

    var mbrInClosed = new Image();
    mbrInClosed.onload = function () {
        mbrInArrow.drawImage(mbrInClosed, 500, 203, 20, 50);
    };
    mbrInClosed.src = 'switchClosedDown.gif';
}

function drawMbrInOpen() {

    var mbrInOpen = new Image();
    mbrInOpen.onload = function () {
        mbrInArrow.drawImage(mbrInOpen, 500, 203, 20, 50);
    };
    mbrInOpen.src = 'switchOpenDown.gif';
}

var mbrOutArrow = myCanvas.getContext('2d');

function drawMbrOutClosed() {

    var mbrOutClosed = new Image();
    mbrOutClosed.onload = function () {
        mbrOutArrow.drawImage(mbrOutClosed, 530, 203, 20, 50);
    };
    mbrOutClosed.src = 'switchClosed.gif';
}

function drawMbrOutOpen() {

    var mbrOutOpen = new Image();
    mbrOutOpen.onload = function () {
        mbrOutArrow.drawImage(mbrOutOpen, 530, 203, 20, 50);
    };
    mbrOutOpen.src = 'switchOpen.gif';
}

var memSystem = myCanvas.getContext('2d');
memSystem.fillStyle = 'lightgrey';
memSystem.fillRect(60,350,500,30);
pcReg.font = "10px Arial";
pcReg.textAlign = "center";
pcReg.strokeText("M E M O R Y ", 300,365);

var memToMar = myCanvas.getContext('2d');
memToMar.fillStyle = "black";
memToMar.fillRect(95,313,2,37);

var memToMbr = myCanvas.getContext('2d');
memToMbr.fillStyle = "black";
memToMbr.fillRect(525,313,2,37);

var fetching = myCanvas.getContext('2d');
function isFetching(){

    fetching.font = "10px Arial";
    fetching.strokeStyle = "red";
    fetching.strokeText("F e t c h i n g m e m o r y . . .",165, 345);
}

function isNotFetching(){

    fetching.fillStyle = 'white';
    fetching.fillRect(100, 335, 150, 15);
}

var loading = myCanvas.getContext('2d');
function isLoading(){

    loading.font = "10px Arial";
    loading.strokeStyle = "red";
    loading.strokeText("L o a d i n g m e m o r y . . .",450, 345);
}

function isNotLoading(){

    loading.fillStyle = 'white';
    loading.fillRect(370, 335, 150, 15);
}

var memInProgress = false;

var stepCount = 0;

var busValue = -1;

var opData = null;

var MBRData = null;

var MARData = null;

var busData = null;

function drawArrows(){

    if(bus2IRArray[(stepCount-1)].checked == true) {
        drawIrInClosed();
    } else {
        drawIrInOpen();
    }

    if(IR2BusArray[(stepCount-1)].checked == true){
        drawIrOutClosed();
    } else {
        drawIrOutOpen();
    }

    if(result2BusArray[(stepCount-1)].checked == true) {
        drawResultOutClosed();
    } else {
        drawResultOutOpen();
    }

    if(bus2ALUArray[(stepCount-1)].checked == true){
        drawAluInClosed();
    } else {
        drawAluInOpen();
    }

    if(ALUDropMenus[(stepCount-1)].value != 'NULL'){
        drawFromAluClosed();
    } else {
        drawFromAluOpen();
    }

    if(bus2OPArray[(stepCount-1)].checked == true){
        drawOpInClosed();
    } else {
        drawOpInOpen();
    }

    if(stepCount > 1){
        if(bus2ALUArray[(stepCount-1)].checked == true && bus2OPArray[(stepCount-2)].checked == true){
            drawFromOpClosed();
        } else {
            drawFromOpOpen();
        }
    } else if(stepCount <= 1){
        if(bus2ALUArray[(stepCount-1)].checked == false){
            drawFromOpOpen();
        }
    }

    if(bus2PCArray[(stepCount-1)].checked == true){
        drawPcInClosed();
    } else {
        drawPcInOpen();
    }

    if(PC2BusArray[(stepCount-1)].checked == true) {
        drawPcOutClosed();
    } else {
        drawPcOutOpen();
    }

    if(bus2R1Array[(stepCount-1)].checked == true) {
        drawR1InClosed();
    } else {
        drawR1InOpen();
    }

    if(R12BusArray[(stepCount-1)].checked == true) {
        drawR1OutClosed();
    } else {
        drawR1OutOpen();
    }

    if(bus2R2Array[(stepCount-1)].checked == true){
        drawR2InClosed();
    } else {
        drawR2InOpen();
    }

    if(R22BusArray[(stepCount-1)].checked == true){
        drawR2OutClosed();
    } else {
        drawR2OutOpen();
    }

    if(bus2MARArray[(stepCount-1)].checked == true){
        drawMarInClosed();
    } else {
        drawMarInOpen();
    }

    if(bus2MBRArray[(stepCount-1)].checked == true){
        drawMbrInClosed();
    } else {
        drawMbrInOpen();
    }

    if(MBR2BusArray[(stepCount-1)].checked == true){
        drawMbrOutClosed();
    } else {
        drawMbrOutOpen();
    }

    if(memDropMenus[(stepCount - 1)].value == 'READ'){
        isFetching();
    } else {
        isNotFetching();
    }

    if(memDropMenus[(stepCount - 1)].value == 'WAIT'){
        isLoading();
    } else {
        isNotLoading();
    }

}

var bus2IRArray = document.getElementsByName("busToIR");
var IR2BusArray = document.getElementsByName("IRToBus");
var result2BusArray = document.getElementsByName("resultToBus");
var bus2ALUArray = document.getElementsByName("busToALU");
var bus2OPArray = document.getElementsByName("busToOP");
var bus2PCArray = document.getElementsByName("busToPC");
var PC2BusArray = document.getElementsByName("PCToBus");
var bus2R1Array = document.getElementsByName("busToR1");
var R12BusArray = document.getElementsByName("R1ToBus");
var bus2R2Array = document.getElementsByName("busToR2");
var R22BusArray = document.getElementsByName("R2ToBus");
var bus2MARArray = document.getElementsByName("busToMAR");
var bus2MBRArray = document.getElementsByName("busToMBR");
var MBR2BusArray = document.getElementsByName("MBRToBus");

var row1ToBusArray = document.getElementsByClassName("row1ToBus");
var row2ToBusArray = document.getElementsByClassName("row2ToBus");
var row3ToBusArray = document.getElementsByClassName("row3ToBus");
var row4ToBusArray = document.getElementsByClassName("row4ToBus");
var row5ToBusArray = document.getElementsByClassName("row5ToBus");
var row6ToBusArray = document.getElementsByClassName("row6ToBus");
var row7ToBusArray = document.getElementsByClassName("row7ToBus");
var row8ToBusArray = document.getElementsByClassName("row8ToBus");
var row9ToBusArray = document.getElementsByClassName("row9ToBus");
var row10ToBusArray = document.getElementsByClassName("row10ToBus");

var rowOne = document.getElementById("rowOne");
var rowTwo = document.getElementById("rowTwo");
var rowThree = document.getElementById("rowThree");
var rowFour = document.getElementById("rowFour");
var rowFive = document.getElementById("rowFive");
var rowSix = document.getElementById("rowSix");
var rowSeven = document.getElementById("rowSeven");
var rowEight = document.getElementById("rowEight");
var rowNine = document.getElementById("rowNine");
var rowTen = document.getElementById("rowTen");

var microTable = document.getElementById("microTable");

var ALUDropMenus = document.getElementsByName("ALUDropdown");

var memDropMenus = document.getElementsByName("memDropdown");

var yellowRows = document.getElementsByName("every");

var cornSilkRows = document.getElementsByName("other");

var checkboxed = document.getElementsByTagName("input");

var resetButton = document.getElementById("resetButton");

var resetBoard = function(){

    for (var j = 0; j < yellowRows.length; j++) yellowRows[j].style.background = "yellow";

    for (var m = 0; m < cornSilkRows.length; m++) cornSilkRows[m].style.background = "cornsilk";

    stepCount = 0;

    busValue = -1;

    opData = null;

    MBRData = null;

    MARData = null;

    busData = null;

    resetArrows();

    isNotFetching();

    isNotLoading();

};

resetButton.onclick = resetBoard;

resetArrows = function(){
    drawIrInOpen();
    drawIrOutOpen();
    drawResultOutOpen();
    drawAluInOpen();
    drawFromAluOpen();
    drawOpInOpen();
    drawFromOpOpen();
    drawPcInOpen();
    drawPcOutOpen();
    drawR1InOpen();
    drawR1OutOpen();
    drawR2InOpen();
    drawR2OutOpen();
    drawMarInOpen();
    drawMbrOutOpen();
    drawMbrInOpen();

};

resetArrows();

document.getElementById("clearButton").onclick = function() {

    for (var i = 0; i < ALUDropMenus.length; i++) ALUDropMenus[i].value = 'NULL';

    for (var i = 0; i < memDropMenus.length; i++) memDropMenus[i].value = 'NULL';

    for (var k = 0; k < checkboxed.length; k++) checkboxed[k].checked = false;

    for (var j = 0; j < yellowRows.length; j++) yellowRows[j].style.background = "yellow";

    for (var m = 0; m < cornSilkRows.length; m++) cornSilkRows[m].style.background = "cornsilk";

    stepCount = 0;

    resetArrows();

};

document.getElementById("loadSimOne").onclick = function() {

    for (var i = 0; i < ALUDropMenus.length; i++) ALUDropMenus[i].value = 'NULL';

    for (var i = 0; i < memDropMenus.length; i++) memDropMenus[i].value = 'NULL';

    for (var k = 0; k < checkboxed.length; k++) checkboxed[k].checked = false;

    for (var j = 0; j < yellowRows.length; j++) yellowRows[j].style.background = "yellow";

    for (var m = 0; m < cornSilkRows.length; m++) cornSilkRows[m].style.background = "cornsilk";

    stepCount = 0;

    bus2ALUArray[0].checked = true;
    PC2BusArray[0].checked = true;
    bus2MARArray[0].checked = true;
    ALUDropMenus[0].value = 'INC';
    memDropMenus[0].value = 'READ';

    row2ResultToBus.checked = true;
    row2BustoOp.checked = true;
    row2MemFunc.value = 'WAIT';

    row3BusToIR.checked = true;
    row3MBRtoBus.checked = true;
    row4BustoOp.checked = true;
    row4R1ToBus.checked = true;

    row5IRtoBus.checked = true;
    row5BustoALU.checked = true;
    ALUDropMenus[4].value = 'INC';

    result2BusArray[5].checked = true;
    bus2R1Array[5].checked = true;

};

document.getElementById("loadSimTwo").onclick = function() {

    for (var i = 0; i < ALUDropMenus.length; i++) ALUDropMenus[i].value = 'NULL';

    for (var i = 0; i < memDropMenus.length; i++) memDropMenus[i].value = 'NULL';

    for (var k = 0; k < checkboxed.length; k++) checkboxed[k].checked = false;

    for (var j = 0; j < yellowRows.length; j++) yellowRows[j].style.background = "yellow";

    for (var m = 0; m < cornSilkRows.length; m++) cornSilkRows[m].style.background = "cornsilk";

    stepCount = 0;

    row1BustoALU.checked = true;
    row1PCtoBus.checked = true;
    row1BustoMAR.checked = true;
    row1ALUFunc.value = 'INC';
    row1MemFunc.value = 'READ';

    row2ResultToBus.checked = true;
    row2BustoOp.checked = true;
    row2MemFunc.value = 'WAIT';

    row3BusToIR.checked = true;
    row3MBRtoBus.checked = true;

    row4IRtoBus.checked = true;
    row4BustoMAR.checked = true;
    row4MemFunc.value = 'READ';

    row5BustoOp.checked = true;
    row5R1ToBus.checked = true;
    row5MemFunc.value = 'WAIT';

    row6BustoALU.checked = true;
    row6MBRtoBus.checked = true;
    row6ALUFunc.value = 'ADD';

    row7ResultToBus.checked = true;
    row7BustoR1.checked = true;

};

document.getElementById("loadSimThree").onclick = function() {

    for (var i = 0; i < ALUDropMenus.length; i++) ALUDropMenus[i].value = 'NULL';

    for (var i = 0; i < memDropMenus.length; i++) memDropMenus[i].value = 'NULL';

    for (var k = 0; k < checkboxed.length; k++) checkboxed[k].checked = false;

    for (var j = 0; j < yellowRows.length; j++) yellowRows[j].style.background = "yellow";

    for (var m = 0; m < cornSilkRows.length; m++) cornSilkRows[m].style.background = "cornsilk";

    stepCount = 0;

    row1BustoALU.checked = true;
    row1PCtoBus.checked = true;
    row1BustoMAR.checked = true;
    row1ALUFunc.value = 'INC';
    row1MemFunc.value = 'READ';

    row2ResultToBus.checked = true;
    row2BustoPC.checked = true;
    row2MemFunc.value = 'WAIT';

    row3BusToIR.checked = true;
    row3MBRtoBus.checked = true;

    row4IRtoBus.checked = true;
    row4BustoPC.checked = true;

};

var stepButton = document.getElementById("stepButton");

function step() {

    if (stepCount == 0){

        rowOne.style.backgroundColor = "grey";
        stepCount++;
        setUpLogic();
        drawArrows();

        if (catchErrors()) stepCount--;
        resetLogic();


    } else if (stepCount == 1) {

        rowOne.style.backgroundColor = "yellow";
        rowTwo.style.backgroundColor = "grey";
        stepCount++;
        setUpLogic();
        drawArrows();

        if (catchErrors()) stepCount--;
        resetLogic();


    } else if (stepCount == 2) {

        rowTwo.style.backgroundColor = "cornsilk";
        rowThree.style.backgroundColor = "grey";
        stepCount++;
        setUpLogic();
        drawArrows();

        if (catchErrors()) stepCount--;
        resetLogic();


    } else if (stepCount == 3) {

        rowThree.style.backgroundColor = "yellow";
        rowFour.style.backgroundColor = "grey";
        stepCount++;
        setUpLogic();
        drawArrows();

        if (catchErrors()) stepCount--;
        resetLogic();


    } else if (stepCount == 4) {

        rowFour.style.backgroundColor = "cornsilk";
        rowFive.style.backgroundColor = "grey";
        stepCount++;
        setUpLogic();
        drawArrows();

        if (catchErrors()) stepCount--;
        resetLogic();


    } else if (stepCount == 5) {

        rowFive.style.backgroundColor = "yellow";
        rowSix.style.backgroundColor = "grey";
        stepCount++;
        setUpLogic();
        drawArrows();

        if (catchErrors()) stepCount--;
        resetLogic();


    } else if (stepCount == 6) {

        rowSix.style.backgroundColor = "cornsilk";
        rowSeven.style.background = "grey";
        stepCount++;
        setUpLogic();
        drawArrows();

        if (catchErrors()) stepCount--;
        resetLogic();


    } else if (stepCount == 7) {

        rowSeven.style.background = "yellow";
        rowEight.style.background = "grey";
        stepCount++;
        setUpLogic();
        drawArrows();

        if (catchErrors()) stepCount--;
        resetLogic();


    } else if (stepCount == 8) {

        rowEight.style.background = "cornsilk";
        rowNine.style.background = "grey";
        stepCount++;
        setUpLogic();
        drawArrows();

        if (catchErrors()) stepCount--;
        resetLogic();


    } else if (stepCount == 9) {

        rowNine.style.background = "yellow";
        rowTen.style.background = "grey";
        stepCount++;
        setUpLogic();
        drawArrows();

        if (catchErrors()) stepCount--;
        resetLogic();


    } else if (stepCount == 10) {
        rowTen.style.background = "cornsilk";
        stepCount = 0;

    }

}

stepButton.onclick = step;

var isChecked = 0;

function setUpLogic(){

    if(IR2BusArray[(stepCount-1)].checked == true || result2BusArray[(stepCount-1)].checked == true ||
        PC2BusArray[(stepCount-1)].checked == true || R12BusArray[(stepCount-1)].checked == true ||
        R22BusArray[(stepCount-1)].checked == true || MBR2BusArray[(stepCount-1)].checked == true) {

        busData = "";
        busValue = 1;
    }

    if(bus2MARArray[(stepCount-1)].checked == true && memDropMenus[(stepCount-1)].value != "NULL") {

        MARData = "";
    }

    if(stepCount > 1){
        if(bus2MARArray[(stepCount-2)].checked == true) memInProgress = true;
    }

    if(bus2OPArray[(stepCount-1)].checked == true) opData = "";

    if(memDropMenus[(stepCount-1)].value == "WAIT") MBRData = "";

}

function resetLogic(){

    busValue = -1;

    MBRData = null;

    MARData = null;

    busData = null;

    memInProgress = false;

    isChecked = 0;

}

function eraseArrows(){



}

function catchErrors(){

    if (noBusToRegError() || ALUErrors() || waitErrors() ||
        writeErrors() || readErrors() || loopErrors() || busErrors()){
        return true;
    }
    return false;
}



function noBusToRegError() {

    if ((busValue != -1 && ALUDropMenus[(stepCount -1)].value == 'NULL' && bus2MBRArray[(stepCount-1)].checked == false) &&
        (bus2IRArray[(stepCount -1)].checked == false &&
        bus2OPArray[(stepCount -1)].checked == false &&
        bus2PCArray[(stepCount -1)].checked == false &&
        bus2R1Array[(stepCount -1)].checked == false &&
        bus2R2Array[(stepCount -1)].checked == false &&
        bus2MARArray[(stepCount -1)].checked == false &&
        bus2ALUArray[(stepCount -1)].checked == false)) {

        alert("Value on the bus is not being copied to register!");
        return true;
    }

    if (busValue = -1 &&
            (bus2IRArray[(stepCount -1)].checked == true &&
            bus2OPArray[(stepCount -1)].checked == true &&
            bus2PCArray[(stepCount -1)].checked == true &&
            bus2R1Array[(stepCount -1)].checked == true &&
            bus2R2Array[(stepCount -1)].checked == true)) {

        alert("Bus is copied to a register but no value is being copied to the bus!");
        return true;
    }
}

/**
 * @return {boolean}
 */
function ALUErrors() {

    if (ALUDropMenus[(stepCount -1)].value != 'NULL' && busValue == -1) {
        alert("ALU function with no value on the bus!");
        return true;
    }

    if (ALUDropMenus[(stepCount -1)].value != 'NULL' && opData == null &&
        bus2ALUArray[(stepCount-1)].checked == false) {
        alert("No data in the operand register");
        return true;
    }

    if (ALUDropMenus[(stepCount -1)].value == 'NULL' &&
        bus2ALUArray[(stepCount-1)].checked == true){
        alert("No data in the operand register!");
        return true;
    }
    //}


    if (ALUDropMenus[(stepCount -1)].value != 'NULL' && bus2ALUArray[(stepCount -1)].checked == false) {
        alert("ALU operation requires input from the bus");
        return true;
    }

    if(ALUDropMenus[(stepCount -1)].value == 'NULL' && bus2ALUArray[(stepCount -1)].checked == true){
        alert("No ALU function when copying bus to ALU");
        return true;
    }
    return false;
}

function waitErrors() {

    if(memDropMenus[(stepCount -1)].value == 'WAIT' && memInProgress == false) {
        alert("Memory wait without preceeding read or write!");
        return true;
    }
    return false;
}

function writeErrors() {

    if(memDropMenus[(stepCount -1)].value == 'WRITE' && MBRData == null && bus2MBRArray[(stepCount - 1)].checked == false) {
        alert("Memory write with no data in MBR");
        return true;
    }

    if(memDropMenus[(stepCount -1)].value == 'WRITE' && MARData == null && bus2MBRArray[(stepCount - 1)].checked == false) {
        alert("Memory write with no data in MAR");
        return true;
    }

    if(memDropMenus[(stepCount -1)].value == 'WRITE' && memInProgress == true) {
        alert("Write started before previous memory function completed");
        return true;
    }
    return false;
}

function readErrors() {
    /**switch(toggleFirstThree.checked) {
        case true:
            if (stepCount = 1) {
                return false;
            }
            else if (memDropMenus[(stepCount - 1)].value == 'READ' && MARData == null) {
                alert("Memory read with no value in the MAR");
                return true;
            }

        case false: **/
    if (memDropMenus[(stepCount - 1)].value == 'READ' && MARData == null) {
        alert("Memory read with no value in the MAR");
        return true;
    }
    //}

    if(memDropMenus[(stepCount -1)].value == 'READ' && memInProgress == true){
        alert("Read started before previous memory function completed");
        return true;
    }
    return false;
}

function loopErrors(){

    if(bus2MARArray[(stepCount -1)].checked == true && MBR2BusArray[(stepCount -1)].checked == true) {
        alert("LOOP - MAR is copied to and from the bus");
        return true;
    }

    if(bus2R2Array[(stepCount -1)].checked == true && R22BusArray[(stepCount -1)].checked == true){
        alert("LOOP - R2 is copied to and from the bus");
        return true;
    }

    if(bus2R1Array[(stepCount -1)].checked == true && R12BusArray[(stepCount -1)].checked == true){
        alert("LOOP - R1 is copied to and from the bus");
        return true;
    }

    if (bus2PCArray[(stepCount -1)].checked == true && PC2BusArray[(stepCount -1)].checked == true){
        alert("LOOP - PC is copied to and from the bus");
        return true;
    }

    if (bus2IRArray[(stepCount -1)].checked == true && IR2BusArray[(stepCount -1)].checked == true){
        alert("LOOP - Instruction Register is copied to and from the bus");
        return true;
    }
    return false;
}

function busErrors(){

    if (bus2IRArray[(stepCount -1)].checked == true && MBR2BusArray[(stepCount -1)].checked == false){
        alert("Instruction Register being loaded from somewhere other than memory");
        return true;
    }

    if (IR2BusArray[(stepCount -1)].checked == true && busData == null){
        alert("Undefined value in Instruction Register copied to bus");
        return true;
    }

    if (result2BusArray[(stepCount -1)].checked == true && busData == null){
        alert("Undefined value in Instruction Register copied to bus");
        return true;
    }

    if (R22BusArray[(stepCount -1)].checked == true && busData == null){
        alert("Undefined value in Instruction Register copied to bus");
        return true;
    }

    if (MBR2BusArray[(stepCount -1)].checked == true && busData == null){
        alert("Undefined value in Instruction Register copied to bus");
        return true;
    }

    switch(parseInt(stepCount)) {

        case 1:
            for (var i in row1ToBusArray) {
                if (row1ToBusArray[i].checked == true) isChecked++;
            }

            if (isChecked > 1) {
                alert("Multiple register are copying their value to the bus!");
                isChecked = 0;
                return true;
            }
            break;

        case 2:
            for (var j in row2ToBusArray) {
                if (row2ToBusArray[j].checked == true) isChecked++;
            }

            if (isChecked > 1) {
                alert("Multiple register are copying their value to the bus!");
                isChecked = 0;
                return true;
            }
            break;

        case 3:
            for (var k in row3ToBusArray) {
                if (row3ToBusArray[k].checked == true) isChecked++;
            }

            if (isChecked > 1) {
                alert("Multiple register are copying their value to the bus!");
                isChecked = 0;
                return true;
            }
            break;

        case 4:
            for (var l in row4ToBusArray) {
                if (row4ToBusArray[l].checked == true) isChecked++;
            }

            if (isChecked > 1) {
                alert("Multiple register are copying their value to the bus!");
                isChecked = 0;
                return true;
            }
            break;

        case 5:
            for (var m in row5ToBusArray) {
                if (row5ToBusArray[m].checked == true) isChecked++;
            }

            if (isChecked > 1) {
                alert("Multiple register are copying their value to the bus!");
                isChecked = 0;
                return true;
            }
            break;

        case 6:
            for (var n in row6ToBusArray) {
                if (row6ToBusArray[n].checked == true) isChecked++;
            }

            if (isChecked > 1) {
                alert("Multiple register are copying their value to the bus!");
                isChecked = 0;
                return true;
            }
            break;

        case 7:
            for (var o in row7ToBusArray) {
                if (row7ToBusArray[o].checked == true) isChecked++;
            }

            if (isChecked > 1) {
                alert("Multiple register are copying their value to the bus!");
                isChecked = 0;
                return true;
            }
            break;

        case 8:
            for (var p in row8ToBusArray) {
                if (row8ToBusArray[p].checked == true) isChecked++;
            }

            if (isChecked > 1) {
                alert("Multiple register are copying their value to the bus!");
                isChecked = 0;
                return true;
            }
            break;

        case 9:
            for (var q in row9ToBusArray) {
                if (row9ToBusArray[q].checked == true) isChecked++;
            }

            if (isChecked > 1) {
                alert("Multiple register are copying their value to the bus!");
                isChecked = 0;
                return true;
            }
            break;

        case 10:
            for (var r in row10ToBusArray) {
                if (row10ToBusArray[r].checked == true) isChecked++;
            }

            if (isChecked > 1) {
                alert("Multiple register are copying their value to the bus!");
                isChecked = 0;
                return true;
            }
            break;
    }
    return false;
}
