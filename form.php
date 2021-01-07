
<!--BACK UP FILE, NOT USED IN CODE-->





<?php
//check if there has been something posted to the server to be processed
if($_SERVER['REQUEST_METHOD'] == 'POST')
{
 
  require('openDB.php');
   try {
      // need to process
      // could have different types of queries
      $criteria = $_POST['a_crit'];
      if($criteria == "ALL")
      {
      $querySelect='SELECT * FROM sharkList';
      $result = $file_db->query($querySelect);
      if (!$result) die("Cannot execute query.");
      }
    // get a row...
    // MAKE AN ARRAY::
    $res = array();
    $i=0;
    while($row = $result->fetch(PDO::FETCH_ASSOC))
    {
      // note the result from SQL is ALREADy ASSOCIATIVE
      $res[$i] = $row;
      $i++;
    }//end while
    // endcode the resulting array as JSON
    $myJSONObj = json_encode($res);
    echo $myJSONObj;
 
  } //end try
     catch(PDOException $e) {
       // Print PDOException message
       echo $e->getMessage();
 
     }
      exit;
}//POST
?>
<!DOCTYPE html>
<html>
<head>
<title>Sample Retrieval USING JQUERY AND AJAX </title>
<!-- get JQUERY -->
 <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<!--set some style properties::: -->
</head>
<body>
<div class= "formContainer">
<!--form done using more current tags... -->
<form id="save_the_sharks" action="">
<!-- group the related elements in a form -->
<h3> RETRIEVE STUFF :::</h3>
<fieldset>
<p><label>Criteria:</label><input type = "text" size="10" maxlength = "15"  name = "a_crit" value = "ALL" required></p>
<p class = "sub"><input type = "submit" name = "submit" value = "get Results" id ="buttonS" /></p>
 </fieldset>
</form>
</div>
<!-- NEW for the result -->
<div id = "back"></div>




<script>
/*jshint esversion: 6 */
$(document).ready (function(){

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



  let sharkList = [];    //array
  
    
  $("#form").on( "submit", function(e) {
   e.preventDefault();
   console.log("button clicked");
   let form = $('#form')[0];
     let data = new FormData(form);
     $.ajax({
      type: "POST",
      enctype: 'text/plain',
      url: "save_the_sharks.php",
      data: data,
      processData: false,//prevents from converting into a query string
      contentType: false,
      cache: false,
      timeout: 600000,
      success: function (response) {
      //reponse is a STRING (not a JavaScript object -> so we need to convert)
      console.log("we had success!");
      
            console.log(response);
           
      //window.location = "Commence.php";
      $('#form')[0].reset();
     },
     error:function(){
    console.log("error occurred");
    $('#form')[0].reset();
  }
});


   /*
$.getJSON('server/shark.json',function(data) {
  
    dataFromJSON = data;
    console.log(dataFromJSON);
    // fill the array with values from JSON...
      for(let j = 0; j<dataFromJSON.length; j++){
         let shark = dataFromJSON[j];

          sharkList.push(new sharkId((shark.name),(shark.colour),(shark.faveMeal),parseInt(shark.lat),parseInt(shark.long),31,31,300,100,"whitesmoke", "",j));

      }
      $( ".inputWindow" ).fadeOut( "slow", function() { }); //fades the form out
    //fail -- fill IN
    }).fail(function(error) {
             console.log("errr");
     });
      
     
    */ 
   });
   function displayResponse(data){
    for(let i=0; i< data.length; i++){
      let currentObject = data[i];
      currentObject.push(new sharkId((shark.name),(shark.colour),(shark.faveMeal),parseInt(shark.lat),parseInt(shark.long),31,31,300,100,"whitesmoke", "",j));
    }
     
     
      //this fuction will create the shark info
    function sharkId(name,colour,faveMeal,lat,long,x,y,w,h, col, image, number){
          this.name = name;
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
                      textPara.innerHTML = "This is a shark SVG object. Clicking on a shark will open a window with its information, acquired from the JSON file. It's colour depends on the user input. Hovering above the shark stops the animation.";
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
                        document.getElementById("pname").innerHTML = "Name: "+this.name;
                        document.getElementById("pmeal").innerHTML = "Favourite meal: "+this.faveMeal;
                        document.getElementById("plat").innerHTML = "Latitude: "+this.lat;
                        document.getElementById("plong").innerHTML = "Longitude: "+this.long;
                        
                      }
                      
                   
                  }
          };
        }
   }     
  });

</script>
</body>
</html>