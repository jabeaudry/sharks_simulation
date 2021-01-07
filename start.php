<?php
session_start();
//session starts

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
<html>
<head>
<title>LOGIN </title>
<!-- get JQUERY/js -->
 <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/p5@1.1.9/lib/p5.js"></script>
 <script src = "js/background1.js" ></script>
 <script src = "js/location.js" ></script> 
<!--style -->
<link rel="stylesheet" type="text/css" href="css/start.css">

</head>
<body>

<div class= "formContainer">
<!--form elements -->
<form id="insertUser" action="start.php" method="post" enctype ="multipart/form-data">
<h2> LOGIN / REGISTER</h2>
<fieldset >
<p><label>Username:</label><input type="text" size="15" maxlength = "20" name = "a_user" required></p>
<p><label>Password:</label><input type = "text" size="15" maxlength = "20"  name = "a_pass" required></p>
<p class = "sub"><input type = "submit" name = "submit" value = "Submit" id ="buttonS" /></p>
 </fieldset>
</form>
<div id="welcome"> One shark is killed by a human every three seconds. As their numbers dwindle, it's easy to feel helpless. Use this virtual tank to create and maintain up to 25 rescued sharks. Feel free to create your own, or import one from anywhere in the world. Watch as the community's numbers grow. Please log in or create a new user.
<div id ="error"></div>
</div>
<canvas id = "canvas-background"></canvas>
<?php

//check if there has been something posted to the server to be processed
if (isset($_POST['a_user'])) {

// these variables will be sotred accross the session
$_SESSION['enough'] = "true";    //only true once, adds a baby shark
$_SESSION['a_user'] = $_POST['a_user']; //stores the username
 $_SESSION['a_pass'] = $_POST['a_pass'];  //stores the password
 header("Location: save_the_sharks.php");  //redirects
  exit();
}//POST
?>



</body>
</html>
