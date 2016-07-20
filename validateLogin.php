<?php
session_start();
include "databaseCon.php";
// Is this a login attempt?
// If so, is the username and password provided?
// If so, are they correct

// connect to database server (servername, username, password)
 $con = mysqli_connect($dbhost, $username, $password, $database);
if (mysqli_connect_errno())
{
    echo "Failed to connect to MySql: ". mysqli_connect_error();
}

// If this is a login attempt
if(isset( $_POST[ 'emailAddress' ] ) && isset( $_POST['pwordV'] ))
{
    
// 
$sql = "
    SELECT
        *
    FROM
        volunteer_details
    WHERE
        email_Address = '" . $_POST[ 'emailAddress' ] . "'
    AND password = '" . $_POST[ 'pwordV' ] . "'";
    


if ($results=mysqli_query($con,$sql)) // the query works or successful and do this
{
    if (mysqli_num_rows($results) == 1) // how many rows came out from the results query
    { // if user exists and password matches
      //  " . $_POST[ 'emailAddress' ] . " also the dots are to stick 2 things together
    // Set username session variable
        $_SESSION['emailAddress'] = $_POST['emailAddress'];
        $_SESSION['pwordV'] = $_POST['pwordV'];
        
        // Below is the code for submitting the details to the logs table.
        
        $sql = "INSERT INTO logs(log_action, log_details)
                VALUES( 'Volunteer Logged In', 'Sucessful login by " . $_POST["emailAddress"] . "' )";
        
        $results = mysqli_query($con,$sql) or die( "SQL Error: " . mysqli_error($con) );
     
     }
     else
     {
        echo 'The username or password you entered is incorrect!';
        
        // Below is the code for submitting the details to the logs table.        
        $sql = "INSERT INTO logs(log_action, log_details)
                VALUES( 'Failed Login', 'Failed Login attempt by " . $_POST["emailAddress"] . "' )";
        
        $results = mysqli_query($con,$sql) or die( "SQL Error: " . mysqli_error($con) );
        exit; //to stop the page from entering the new page & always remember to put this
     }
     mysqli_free_result($results); // get rid of the memory that's being used - let go of the sql .
}
else
{
   echo 'Something is not working, contact the organizer!';
   session_destroy(); // because the query didnt work, the session can be destroyed!
   exit; //to stop the page from entering the new page & always remember to put this
}

}
if (!isset($_SESSION['emailAddress'])) {
    echo "You are not logged in.  Please log in to continue.<br>";
    echo "<a href='index.html'>Login</a>";
    exit;
} else {
    ?>
    <script type="text/javascript">
        window.location.replace('volunteerTimeSlots.php');
    </script>
    <?php
}
?>