<?php
    session_start();
    include "databaseCon.php";
?>

<!DOCTYPE html>
<html>
<head>
    <title>Retrieve data from the form Volunteer Registration- "VolunteerUserDetails"</title>
</head>
<body>
    
    <!-- = means print out the variable that's next to it, instead of running a long php code and $_POST is how ou get the post variable-->
    <?php
    $valid=true;
    $emailAddress = $_POST["emailAddress"];
    if (!filter_var($_POST["emailAddress"], FILTER_VALIDATE_EMAIL)) 
        //run a email filter on this variable - and post this message
        {
            print 'The email address is invalid.  You typed: ' . $_POST["emailAddress"];
            $valid=false;
        }
    $firstname = $_POST["firstname"];
    if (!preg_match("/^[a-zA-Z ]+$/",$firstname)) 
        {
            print 'The firstname is invalid.  You typed: ' . $_POST["firstname"];
            ?>
            <INPUT TYPE='button' VALUE='Back' onClick="history.go(-1)">
            <?php
            $valid=false;
        }
        //if the 1st part doesnt match, it displays the 2nd part
   $surname = $_POST["surname"];
   if (!preg_match("/^[a-zA-Z ]+$/",$surname))
       //if the 1st part doesnt match, it displays the 2nd part
       {
           print 'The surname is invalid.  You typed: ' . $_POST["surname"];
           ?>
           <INPUT TYPE='button' VALUE='Back' onClick="history.go(-1)">
           <?php
           $valid=false;
       }

    $homeAddress1 = $_POST["homeAddress1"];
    if (!preg_match("/^[0-9 a-zA-Z ]+$/",$homeAddress1))
        //if the 1st part doesnt match, it displays the 2nd part 
    //also + means 1 or more
        {
            print 'The home address line 1 must only contain numbers and letters.  You typed: ' . $_POST["homeAddress1"];
            ?>
            <INPUT TYPE='button' VALUE='Back' onClick="history.go(-1)">
            <?php
            $valid=false;
        }
   
    $homeAddress2 = $_POST["homeAddress2"];
    if (!preg_match("/^[0-9 a-zA-Z ]*$/",$homeAddress2))
        //if the 1st part doesnt match, it displays the 2nd part 
    //also + means 1 or more
        {
            print 'The home address line 2 is invalid. You typed: ' . $_POST["homeAddress2"];
            ?>
            <INPUT TYPE='button' VALUE='Back' onClick="history.go(-1)">
            <?php
            $valid=false;
        }
   
    $suburb = $_POST["suburb"];
    if (!preg_match("/^[a-zA-Z ]+ [a-zA-Z]+$/",$suburb))
        //if the 1st part doesnt match, it displays the 2nd part 
    //also + means 1 or more
        {
            print 'The suburb is invalid, format is: "Suburb ST".  You typed: ' . $_POST["suburb"];
            ?>
            <INPUT TYPE='button' VALUE='Back' onClick="history.go(-1)">
            <?php
            $valid=false;
        }
    
    $postcode = $_POST["postcode"];
    if (!preg_match("/^[0-9]{5}$/",$postcode))
        //{5} - to contain only 5 characters
        //{3,5} - to contain characters between 3-5
        {
            print 'The postcode must be 5 characters!  You typed: "' . $_POST["postcode"] . '"';
            ?>
            <INPUT TYPE='button' VALUE='Back' onClick="history.go(-1)">
            <?php
            $valid=false;
        }

    $phonenumber = $_POST["phonenumber"];
    if (!preg_match("/^[0-9]{10}$/",$phonenumber))
        //{5} - to contain only 5 characters
        //{3,5} - to contain characters between 3-5
        {
            print 'The phone number is invalid!  Format: 1231231234.  You typed: ' . $_POST["phonenumber"];
            ?>
            <INPUT TYPE='button' VALUE='Back' onClick="history.go(-1)">
            <?php
            $valid=false;
        }

    $DOB = $_POST["DOB"];
    if (!preg_match("/^[0-9]{4}\/[0-9]{2}\/[0-9]{2}$/",$DOB))
        //{5} - to contain only 5 characters
        //{3,5} - to contain characters between 3-5
        {
            print 'The DOB format is invalid!  Format: YYYY/MM/DD. You typed: ' . $_POST["DOB"];
            ?>
            <INPUT TYPE='button' VALUE='Back' onClick="history.go(-1)">
            <?php
            $valid=false;
        }

    $pword = $_POST["pword"];
    if (!preg_match("/.{6}/",$pword))
        //{5} - to contain only 5 characters
        //{3,5} - to contain characters between 3-5
        //if u dont put the $ sign at the end - it means u r not looking for a end.
        //$ puts an end to the formula
        {
            print 'The password must be longer than 6 characters. You typed: ' . $_POST["pword"];
            ?>
            <INPUT TYPE='button' VALUE='Back' onClick="history.go(-1)">
            <?php
            $valid=false;
        }

    $confirmPword = $_POST["confirmPword"];
    if (!($_POST["confirmPword"] == $_POST["pword"]))
    {
        print 'The passwords do not match, retype! You typed: ' . $_POST["confirmPword"];
        ?>
        <INPUT TYPE='button' VALUE='Back' onClick="history.go(-1)">
        <?
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
        
        //inserting data
        $sql = "INSERT INTO volunteer_details (email_Address, first_name, surname, homeaddress_line1, homeaddress_line2, suburb, postcode, phone_number, DOB, password) VALUES ('$emailAddress', '$firstname', '$surname', '$homeAddress1', '$homeAddress2', '$suburb', $postcode, $phonenumber, '$DOB', '$pword')";
        
        if ($con->query($sql) === TRUE) {
            print "Registration Successful!";
            
            $firstLetter = substr( $_POST[ "firstname" ], 0, 1 );
            
            $sql = "INSERT INTO logs(log_action, log_details)
                    VALUES( 'Registration', '" . $firstLetter . " " . $_POST["surname"] . " with " . $_POST["emailAddress"] . 
                    " registered as a volunteer' )";
            
            $results = mysqli_query($con,$sql) or die( "SQL Error: " . mysqli_error($con) );
            
        } else {
            if(mysqli_errno($con) == 1062) {
                // pop up an alert (pop-up box)
                echo $emailAddress . " is already in use by another account.<br>";
                ?>
                <script type="text/javascript">
                  alert("This e-mail address is already in use by another account.")
                </script>
                <INPUT TYPE='button' VALUE='Back' onClick="history.go(-1)">
                <?php
                exit;
            } else {
                echo "Error: " . $sql . "<br>" . $con->error;
            }
        }
        

        

        
        // close the database connection
        mysqli_close($con);
        ?>
        <tr></tr>
        <tr>
            <td><a href="index.html">Now login as a volunteer!!</a>
        </tr>
     <?php
    }
        
    ?>
    
</body>
</html>