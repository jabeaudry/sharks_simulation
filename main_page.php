<?php

//this main page hosts the virtual sharks


session_start(); //session starts
if (ini_get('register_globals'))
{
    foreach ($_SESSION as $key=>$value)
    {
        if (isset($GLOBALS[$key]))
            unset($GLOBALS[$key]);
    }
}

?>



<!DOCTYPE html>
<html lang="en">
<head>

  <title>Save the sharks</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
  <link rel="stylesheet" href="css/main_style.css" type="text/css" >
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js" type="text/javascript"></script>
  
  <!--p5 library-->
  <script src="https://cdn.jsdelivr.net/npm/p5@1.1.9/lib/p5.js"></script>
  <script src = "js/background.js" ></script>  
  <script src = "js/location.js" defer ></script> 
  
  <script>/*jshint esversion: 6 */</script>

</head>
<body id = "main">
  <div id ="main-container">
<!--background-->
  <canvas id = "sharkFrame" mousemove="mouseMover()" ></canvas>
  <canvas id = "canvas-background"></canvas>   


<!--this shows the shark info on click-->
  <div id = "infoContainerLeft"> 
    <p id = "pname"></p>
    <p id = "pmeal"></p>
    <p id = "plat"></p>
    <p id = "plong"></p>
   <button id = "closeInfo1">Close</button>
  </div>

<!--side bar-->
<div id="holders">
<div id="createButton2"><button>Add</button></div>
<div id="createButton3"><button>Learn more!</button></div>
<div id = "yours"></div>
<div id = "global">Globally saved: <?php echo $_SESSION['globalval'];?></div>
<div id = "d">Deaths this year: 100 000 000</div>
</div>


<script defer>



//this script animates the sharks moving and animates 

/*jshint esversion: 6 */
//button to create a shark




$(document).ready (function(){

  //button onclick, sends the user to the page where they can create a shark
  document.getElementById("createButton2").onclick = function () {
    location.href = "save_the_sharks.php";
  };
  //button on click, sends the user to a page to learn more
  document.getElementById("createButton3").onclick = function () {
    location.href = "https://www.worldwildlife.org/species/shark";
  };

  //canvas variable
  canvas2  = $("#sharkFrame")[0];

  //shark info containers
  let paragraphLeft = document.getElementById("infoContainerLeft");
  var click = false;    //keeps track of clicks
  
  //this code was found on: https://medium.com/wdstack/fixing-html5-2d-canvas-blur-8ebe27db07da
  // used to keep the ratio o the SVG objects
  let dpi = window.devicePixelRatio;
  
  fix_dpi();
  let context = canvas2.getContext("2d");
  context.width = canvas2.width;
  context.height = canvas2.height;
  
  function fix_dpi() {
    //get CSS height
    //the + prefix casts it to an integer
    //the slice method gets rid of "px"
    let style_height = +getComputedStyle(canvas2).getPropertyValue("height").slice(0, -2);
    //get CSS width
    let style_width = +getComputedStyle(canvas2).getPropertyValue("width").slice(0, -2);
    //scale the canvas
    canvas2.setAttribute('height', style_height * dpi);
    canvas2.setAttribute('width', style_width * dpi);
  }

  //end of code found on https://medium.com/wdstack/fixing-html5-2d-canvas-blur-8ebe27db07da

//keeps tack of mouse
var mouseX;
var mouseY;




//this functions determines the mouse position

  function mouseMover(e) {
    e = e || window.event;
     mouseX = parseInt(e.clientX);
     mouseY = parseInt(e.clientY);
    
  }
  //this functions sets the clicker to true, meaning the user clicked a shark
  function sharkClick(){
      click =true;
  }
  //this functions closes the info panel
  function closePanel() {
    $(paragraphLeft).css("z-index","0");
     click = false;
  }

  //event listeners
canvas2.addEventListener("mousemove", mouseMover);
canvas2.addEventListener("click", sharkClick);
let buttonClose1 = document.getElementById("closeInfo1");
buttonClose1.addEventListener("click", closePanel);

//array that holds the shark objects
let sharkList = []; 
//counts the amount of sharks created
let sharkAmnt = 0;

$.getJSON("server/shark.json",function(data) {

  dataFromJSON = data;
  console.log(dataFromJSON);
  // fill the array with values from JSON...
    for(let j = 0; j<dataFromJSON.length; j++){
       let shark = dataFromJSON[j];

        sharkList.push(new sharkObj((shark.sharkID),(shark.user),(shark.pass),(shark.names),(shark.colour),(shark.faveMeal),parseInt(shark.lat),parseInt(shark.long),31,31,300,100,"whitesmoke", "",j));
        sharkAmnt++;
        $('#yours').text("Saved: "+sharkAmnt);
       
    } 
  //fail -- fill IN
  }).fail(function(error) {
           console.log("errr");
   });
  
     
      //this fuction will create the shark info
    function sharkObj(sharkID,user,pass,names,colour,faveMeal,lat,long,x,y,w,h, col, image, number){
          this.sharkID = sharkID;
          this.name = names;
          this.colour = colour;
          this.faveMeal = faveMeal;
          this.lat = lat;
          this.long = long;
            var vx;
            var vy;
            this.x = x;
            this.y = y;
            this.w =w;
            this.h =h;
            this.number = number;
            this.col = col;
            this.image = image;
            vx = 0.02*Math.random()*Math.floor(10); 
            vy = 0.02*Math.random()*Math.floor(10); 
            this.x = Math.random()*Math.floor(canvas2.width);
            this.y = Math.random()*Math.floor(canvas2.height);
            requestAnimationFrame(loopAni);
            function loopAni(){
              context.clearRect(0,0,canvas2.width,canvas2.height);
        
              //draw ::
              for(let i =0; i<sharkList.length; i++){
                
               
                

                sharkList[i].pickColour();
                sharkList[i].display();
                sharkList[i].update(); 
                

              }
        
              requestAnimationFrame(loopAni);
        
            }

            this.pickColour = function() {
              this.image = document.createElement("img");
                if (this.colour == "#94d0ff"){ //light blue
                  $(this.image).attr("src", "img/lightblue.svg");
              }
              if (this.colour == "#c774e8"){ //pink
                $(this.image).attr("src", "img/pink.svg");
              }
              if (this.colour == "#455f65"){ //grey
                $(this.image).attr("src", "img/grey.svg");
              }
              if (this.colour == "#b252a1"){ //dark pink
                $(this.image).attr("src", "img/darkpink.svg");
              }
              if (this.colour == "#66a1d2"){ //blue
                $(this.image).attr("src", "img/blue.svg");
              }
              if (this.colour == "black"){ //black
                $(this.image).attr("src", "img/child-01.svg");
              }
            };
            //displays the sharks
            this.display  = function(){
              
            context.drawImage(this.image,this.x, this.y,this.w,this.h);  //draws the shapes


              
          };  
        
              

            
            this.update = function(){
              
              //this checks if the mouse is moving
            
              //if mouse is over one of the sharks
                  
                 
                    
                    if (((this.x+(this.w/2)) >= context.width )) {
                      vx = - vx;
                      
                    }
                    if (((this.x-(this.w/2))<=0)) {
                      vx = - vx;
                      
                    }
                    if ((this.y-(this.h/2))<=0) {
                      vy = -vy;
                     
                    }
                    if (((this.y+(this.h/2)) >= context.height) ) {
                      vy = -vy;
                      
                    }
                    if ((mouseX > this.x)&&(mouseX<(this.x+this.w))&&(mouseY > this.y)&&(mouseY < (this.y + this.h))) {
                      this.x = this.x;
                      this.y = this.y;
                     
                      }

                      //THIS WILL DISPLAY THE SHARK INFO

                    else {
                      this.x = this.x + vx;
                       this.y = this.y + vy;
                      

                    }
                    
                    if (click){
                     if ((mouseX > this.x)&&(mouseX<(this.x+this.w))&&(mouseY > this.y)&&(mouseY < (this.y + this.h))){ 
                       $(paragraphLeft).css("z-index", "39");
                       if (isNaN(this.long)) {
                         this.long = "Classified";
                         this.lat = "Classified";
                       }
                       //this changes the information displayed about the clicked shark
                        document.getElementById("pname").innerHTML = "Name: "+this.name;
                        document.getElementById("pmeal").innerHTML = "Favourite meal: "+this.faveMeal;
                        document.getElementById("plat").innerHTML = "Latitude: "+this.lat;
                        document.getElementById("plong").innerHTML = "Longitude: "+this.long;
                        
                      }
                      
                   
                  }
          };
        }
       
  });


</script>
</body>
</html>