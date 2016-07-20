<?php
if(!isset($_SESSION)){
    session_start();
    include "check_login.php";
    include "databaseCon.php";
}
?>
    <!-- = means print out the variable that's next to it, instead of running a long php code and $_POST is how ou get the post variable-->
    <?php
    $valid=true;
    $homeAddress1 = $_POST["homeAddress1"];
    if (!preg_match("/^[0-9 a-zA-Z ]+$/",$homeAddress1))
        //if the 1st part doesnt match, it displays the 2nd part 
    //also + means 1 or more
        {
            print 'The home address line 1 must only contain numbers and letters.  Got: ';
            $valid = $_POST["homeAddress1"];
            //the top lin shows what they entered before and its wrong and for them to fix. or it could just be $valid=false;
        }

    $homeAddress2 = $_POST["homeAddress2"];
    if (!preg_match("/^[0-9 a-zA-Z ]*$/",$homeAddress2))
        //if the 1st part doesnt match, it displays the 2nd part 
    //also + means 1 or more
        {
            print 'The home address line 2 is invalid, retype!';
            $valid=$_POST["homeAddress2"];
        }
  
    $suburb = $_POST["suburb"];
    if (!preg_match("/^[a-zA-Z ]+ [a-zA-Z]+$/",$suburb))
        //if the 1st part doesnt match, it displays the 2nd part 
    //also + means 1 or more
        {
            print 'The suburb is invalid, format is: "Suburb ST".  Got: ';
            $valid = $_POST["suburb"];
        }

    $postcode = $_POST["postcode"];
    if (!preg_match("/^[0-9]{5}$/",$postcode))
        //{5} - to contain only 5 characters
        //{3,5} - to contain characters between 3-5
        {
            print 'The postcode must be 5 characters!  Got: ';
            $valid = $_POST["postcode"];
        }

    $phonenumber = $_POST["phonenumber"];
    if (!preg_match("/^[0-9]{10}$/",$phonenumber))
        //{5} - to contain only 5 characters
        //{3,5} - to contain characters between 3-5
        {
            print 'The phone number is invalid!  Format: 1231231234.  Got: ';
            $valid = $_POST["phonenumber"];
        }

    $pword = $_POST["pword"];
    if (!preg_match("/.{6}/",$pword))
        //{5} - to contain only 5 characters
        //{3,5} - to contain characters between 3-5
        //if u dont put the $ sign at the end - it means u r not looking for a end.
        //$ puts an end to the formula
        {
            print 'The password must be longer than 6 characters';
            $valid = $_POST["pword"];
        }
  
    $confirmPword = $_POST["confirmPword"];
    if (!($_POST["confirmPword"] == $_POST["pword"]))
    {
        print 'The passwords do not match, retype!';
        $valid=false;
    }

    ?>
    
    <!--Trying to insert the validated data into a database/table-->
    <?php
    if ($valid) 
    {
        // connect to database server (servername, username, password)
        $con = mysqli_connect($dbhost, $username, $password, $database);
        if (mysqli_connect_errno())
        {
            echo "Failed to connect to MySql: ". mysqli_connect_error();
        }
        
        //updating data
        $sql = "
            UPDATE 
                volunteer_details
            SET 
                homeaddress_line1 = '" . $homeAddress1 . "' , homeaddress_line2 = '" . $homeAddress2 . "', suburb = '" . $suburb . "', postcode = '" . $postcode . "', phone_number = " . $phonenumber . ", password = '" . $pword . "'
            WHERE 
                email_Address = '" . $_SESSION[ 'emailAddress' ] . "'";
                
        
        if ($con->query($sql) === TRUE) {
            ?>
            <script type="text/javascript">
              alert("Your changes have been updated!")
            </script>
            <?php
           
        } else {
            echo "Error: " . $sql . "<br>" . $con->error;
            exit;
        }
        
        // close the database connection
        mysqli_close($con);
         
    }
    include "editDetails.php";
    ?>