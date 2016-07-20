<?php
session_start();
include "databaseCon.php";
// you dont need the organizer coz its just validating!

$con = mysqli_connect($dbhost, $username, $password, $database);
if(mysqli_connect_errno())
{
    echo "Failed to connect to MySql: ". mysqli_connect_errno();
}
else
{
        $querySuccessful = true;
    
             // no if coz no results to check
        // $_POST['start_day'] //this is form the hiddden name

        // Loop through each day after the start day  
            for ($i=$_POST['start_day']; $i<=$_POST['duration']; $i++)
            {
            // Insert a morning, afternoon, and night record for each day
                $sql = "INSERT INTO time_slots (timeslot_name)
                        VALUES ('Day " . strval($i) . ", Morning'),
                                ('Day " . strval($i) . ", Afternoon'),
                                ('Day " . strval($i) . ", Night')";
                               
                if(!mysqli_query($con,$sql))
                {
                
                    $querySuccessful = false;
                
                     echo 'The duration has NOT been updated, contact the management!<br/>';
  
                 }
                 
             }
         if(!$querySuccessful)
         {
             echo 'Failure updting...';
         }
         else
         {
             $querySuccessful;
             echo 'The time duration has been updated!';
         }     

}

?>