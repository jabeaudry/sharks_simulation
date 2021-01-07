<?php 
session_start();
if (ini_get('register_globals'))
{
    foreach ($_SESSION as $key=>$value)
    {
        if (isset($GLOBALS[$key]))
            unset($GLOBALS[$key]);
    }
}
$exit = true;
include("startSession.php"); //this page receives the form information and adds it to the database
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
  <script src = "js/background1.js" ></script>  
  <script src = "js/location.js" defer></script> 
  <script>/*jshint esversion: 6 */</script>
</head>
<body id = "main">
<div id ="main-container">
<!--form html-->
<form id = "form" class = "inputWindow" method="post" action="save_the_sharks.php" enctype ="multipart/form-data">
    <div><label>NAME: </label><input type = "text" size="24" maxlength = "40"  name = "names" id = "nameIn" required ></div>
    <div><label for="colourPick">COLOUR: </label>
         <select name = "colour" id = "colourPick" required>
            <option value = "#94d0ff">Light blue</option>
            <option value = "#c774e8">Purple</option>
            <option value = "#455f65">Blue</option>
            <option value = "#b252a1">Pink</option>
            <option value = "#66a1d2">Turquoise</option>
        </select></div>
        <div><label>FAVOURITE MEAL: </label><input type = "text" size="24" maxlength = "40" name = "faveMeal" required id="meal"></div>
        <input type="checkbox" name="import" value="check" id="import"></input>
        <div id = "check">Check this box to import an internation shark as well!</div>
        <!-- hidden  fields, used to assign lat and long-->
        <input type="hidden" id="lat" name="lat"/>
        <input type="hidden" id="long" name="long" />
        


    <input type="submit" id="subButton"></input>
    
</form>
<canvas id = "canvas-background"></canvas>



</body>
</html>