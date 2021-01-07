<?php
//this page receives the form information and adds it to the database
//as seen is class notes 2020 by Sabine Rosenberg, Concordia University
//check if there has been something posted to the server to be processed
if(($_SERVER['REQUEST_METHOD'] == 'POST')){
  require('openDB.php');
// variables


  try{
    $theQuery = "CREATE TABLE IF NOT EXISTS sharkList (sharkID INTEGER PRIMARY KEY NOT NULL, user TEXT, pass TEXT, names TEXT, lat TEXT,long TEXT, colour TEXT,faveMeal TEXT)";
    $file_db ->exec($theQuery);
    $file_db = null;
    }
  catch(PDOException $e) {
        // Print PDOException message
        echo $e->getMessage();
  }

//form variables
  $userName = $_SESSION['a_user'];
  $pass = $_SESSION['a_pass'];
  $name = $_POST['names'];
  $colour = $_POST['colour'];
  $faveMeal = $_POST['faveMeal'];
  $long = $_POST['long'];
  $lat = $_POST['lat'];
 
try {
  require('openDB.php');
  //quote fn used on all the form variables
  $name_es = $file_db->quote($name);
    $lat_es = $file_db->quote($lat);
    $long_es = $file_db->quote($long);
    $colour_es = $file_db->quote($colour);
    $faveMeal_es = $file_db->quote($faveMeal);
    $queryInsert = "INSERT INTO sharkList (user, pass, names, lat, long, colour, faveMeal) VALUES ('$userName', '$pass', $name_es, $lat_es, $long_es, $colour_es, $faveMeal_es)";
    $file_db->exec($queryInsert);
    $file_db = null; //databse is updated
    $exit = false;
    
  } catch(PDOException $e) {
    // Print PDOException message
    echo $e->getMessage();
  }
  
}  

?>

<?php 
if(($_SERVER['REQUEST_METHOD'] == 'POST')){

if (!$exit){ //only runs when the form is updated
  //user and pass variables, based on the first form
  $userNow = $_SESSION['a_user'];
  $passNow = $_SESSION['a_pass'];
  require('openDB.php');

  //returns the total amount of sharks
  $total = array();    //array that will store the rows
  $querySelect= "SELECT sharkID FROM sharkList";   //selects all the rows of the database, regardless of username
  $result11 = $file_db->query($querySelect);
    if (!$result11) die("Cannot execute query.");
    //counter variables
    $i=0;
    $j = 0;
    $k = 0;
    $m = 0;

    //this counts the amount of rows
    while($row = $result11->fetch(PDO::FETCH_ASSOC))
      {
       $total[$j] = $row;
       $j++;
       $_SESSION['globalval'] = $j;    //total sharks created stored here
     }
       
    
    $myNumber = array();    //array that will store the rows
    $querySelect2= "SELECT sharkID FROM sharkList WHERE user = '$userNow' AND pass ='$passNow' LIMIT 25";
    $result22 = $file_db->query($querySelect2);
      if (!$result22) die("Cannot execute query.");
      $k=0;
       
      //stores the user's sharks
      while($row = $result22->fetch(PDO::FETCH_ASSOC))
      {
         
        $myNumber[$k] = $row;
        $k++;
      }

    //this code only executes when a shark is imported (checkbox == true)


    //selects a random number within the database
    //if the sharkID corresponds to one of the user's own sharks, a different number is selected
    //only returns a shark that is not already in the database
    if (isset($_POST['import'])){
      

    $randomNum =  rand (1 , $_SESSION['globalval']);
    for ($m = 0; $m < $k ;$m++) {
        if ($myNumber[$m] != $randomNum) {
            continue;   //check next value, current one doesn't match
        }
        else if (($myNumber[$m] != $randomNum) && (($m+1) == $k)){
            break;  //SUCCESS! none of the values matched the random one
        }
        else {
            $randomNum =  rand (1 , $_SESSION['global']);
            $m = -1;   //the random shark matches one of the user's shark, start again
        }
    } 

    //UPDATES DATABASE with random shark
    try
    {
  $sql_update2="UPDATE sharkList SET user = '$_SESSION[a_user]' WHERE sharkID ==$randomNum";
  $sql_update3="UPDATE sharkList SET pass = '$_SESSION[a_pass]' WHERE sharkID ==$randomNum";
   
    $file_db ->exec($sql_update2);
    $file_db ->exec($sql_update3);
   
 
 }
  catch(PDOException $e) {
     // Print PDOException message
      echo $e->getMessage();
    }
    }
    //creates an infant
if ((($_SESSION['enough']) == "true") && ($k > 2)){
    $queryInsert = "INSERT INTO sharkList (user, pass, names, lat, long, colour, faveMeal) VALUES ('$userName', '$pass', 'Child', $lat_es, $long_es, 'black', 'Milk')";
    $file_db->exec($queryInsert);
    $file_db = null; 
    include('openDB.php');
    $_SESSION['enough'] = "false";
}
else {
  $_SESSION['enough'] = "false";   //if the user logs in with less than two sharks, they will not get an infant
}
  try {
   //the user's current sharks for the json file

   $res = array();    //array that will store the rows
   $querySelect= "SELECT * FROM sharkList WHERE user = '$userNow' AND pass ='$passNow' LIMIT 25";
   $result = $file_db->query($querySelect);
   if (!$result) die("Cannot execute query.");
   $i=0;

   //stores the user's sharks in an array
     while($row = $result->fetch(PDO::FETCH_ASSOC))
     {
       
      $res[$i] = $row;
      $i++;
      }
    $myJSONObj = json_encode($res);    //encoded to json
    

       //writes to the json file
    require('openDB.php');
    $fp = fopen('server/shark.json', 'w');
    fwrite($fp,$myJSONObj);
    fclose($fp);
    header("location: main_page.php");
    exit;
}
catch(PDOException $e) {
    // Print PDOException message
     echo $e->getMessage();
}  
} 
}

?>
