/*jshint esversion: 6 */




//variables
var rows = 60;
var columns = 60;
var ySpace = 40;
var xSpace = 40;



/* 
* The background is based on this code found
* on the following website: https://editor.p5js.org/kiel.d.m/sketches/RzVgfVzjX
* The author is called: kiel.d.m.
* The project is called: 4.Grid w/ 2D wave.
*/

//variables
var yWave = 100;
var yWaveSize =11;
var yWaveLength=0.6;
var yWaveSpeed=0.06;
var yWaveOffset= 0.5;

var xWave = 100;
var xWaveSize =12;
var xWaveLength=0.5;
var xWaveSpeed=0.02;
var xWaveOffset=0.1;
   
var windowWidth;
var windowHeight;   
   

var ballSize = 7;

document.onload = function(){


setup();  //creates the canvas
draw(); 
};

function setup() {
var canvas = createCanvas((windowWidth+300), (windowHeight+300));
canvas.id('canvas');
append(canvas, "#canvas-background");
}
function draw() {
  background('#ad8cff');
  
  
  // Center matrix
  translate(width/2,height/2);
  
  // Reposition  matrix depending on width & height of the grid
  translate( -(columns-1) * xSpace/2, -(rows-1) * ySpace/2);
  
  noStroke();
  
  for(var i = 0; i < columns; i++){
    for(var j = 0; j < rows; j++){
     fill('#2c0452');
      //ellipse(i*xSpace, j*ySpace,5,5);
      
      yWave = sin(frameCount*yWaveSpeed + i*yWaveLength + j*yWaveOffset) * yWaveSize;
      xWave = cos(frameCount*xWaveSpeed + j*xWaveLength + i*xWaveOffset) * xWaveSize;
      
      push();
        translate(i*xSpace,j*ySpace);
        fill(0);
        ellipse(0,0,3,3);
        fill(color('#dbd7fd'));
        ellipse(xWave,yWave,ballSize,ballSize);
      pop();
    }
  }
}