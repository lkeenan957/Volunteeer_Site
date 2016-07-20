<?php
session_start();
include "databaseCon.php";

$con = mysqli_connect($dbhost, $username, $password, $database);

    if(mysqli_connect_errno($con))
    {
        echo "Failed to connect to MySqli: " . mysqli_connect_errno();
    }
    else
    {
      
        $sql1 = "INSERT INTO messages(username, emailAddress, message) 
                  VALUES ('" . $_SESSION['username'] . "', '" . $_POST['volemailadd'] . "', '" . $_POST['writtenMessage'] . "')";
                
        if($results = mysqli_query($con,$sql1))
        {
            // see: http://stackoverflow.com/questions/768431/how-to-make-a-redirect-in-php
            header("Location: messageToVolunteer.php");
            die;
 
        }   
        else
        {       
            echo "<script type='text/javascript'>alert('The details was FAILED to be added to the messages table!');</script>";
        }  
          
      $previous = "javascript:history.go(-1)";
      if(isset($_SERVER['HTTP_REFERER'])) {
          $previous = $_SERVER['HTTP_REFERER'];
      }
        
        
    }
    
?> 
