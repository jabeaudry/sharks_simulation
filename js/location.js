/*jshint esversion: 6 */

//this file uses the location api and returns the latitude and longitude of the user
//based on class notes, HTML geolocation Api section




$(document).ready(function() {
  
  
  var lati; //latitude of user
var long;   //longitude of user


 // the function that assigns the lat and long to a variable
     //also rounds it to 3 decimal points
     function usePosition(position) {
        console.log(position);
        lati = (position.coords.latitude).toFixed(2);  //rounds to 2 decimals
        long = (position.coords.longitude).toFixed(2);  //rounds to 2 decimals
        console.log(lati);
        console.log(long);
        $('#long').attr("value", lati.toString()); //adds the value to the hidden form input
         $('#lat').attr("value", long.toString());
    } 
   
   try{
        if (navigator.geolocation) {
              navigator.geolocation.getCurrentPosition(usePosition); 
        
          }
         
        }
        catch(error) {
                    lati = "Unknown";
                  long = "Top secret";
        }
      });
    
      



