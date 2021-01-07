<?php
session_start();




//NOT USED IN CODE, JUST A BACKUP




//this code only executes when a shark is imported (checkbox == true)


//selects a random number within the database
//if the sharkID corresponds to one of the user's own sharks, a different number is selected
//only returns a shark that is not already in the database

$randomNum =  rand (1 , $_SESSION['globalval']);
    for ($m = 0; $m < $k ;$m++) {
        if ($myNumber[$m] != $randomNum) {
            continue;   //checks next value
        }
        else if (($myNumber[$m] != $randomNum) && (($m+1) == $k)){
            break; //success! checked all values and they did not match
        }
        else {
            $randomNum =  rand (1 , $_SESSION['global']);
            $m = -1;       //the random shark matches one of the user's shark, start again
        }
    } 
    
    //after the random shark is valid, the databse updates the user and pass
try
{
  $sql_update2="UPDATE sharkList SET user = '$_SESSION[a_user]' WHERE sharkID ==$randomNum";
  $file_db ->exec($sql_update2);
  $sql_update3="UPDATE sharkList SET pass = '$_SESSION[a_pass]' WHERE sharkID ==$randomNum";
    $file_db ->exec($sql_update3); //db updated
    
 
 }
  catch(PDOException $e) {
     // Print PDOException message
      echo $e->getMessage();
    }
    exit;
?>