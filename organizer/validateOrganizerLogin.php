    <?php
        session_start();
        include "databaseCon.php";
        
        $valid=true;
    
        if (!preg_match("/^[a-zA-Z ]+$/",$_POST["username"])) 
            {
                ?>
                <script type="text/javascript">
                alert("Invalid Username!");
                </script>
                <?php
            
                $valid=false;
            };
            //if the 1st part doesnt match, it displays the 2nd part
        ?>
    
        <?php
        if (!preg_match("/.{6}/",$_POST["pwordO"]))
            //{5} - to contain only 5 characters
            //{3,5} - to contain characters between 3-5
            //if u dont put the $ sign at the end - it means u r not looking for a end.
            //$ puts an end to the formula
            {
                ?>
                <script type="text/javascript">
                alert("The password must be longer than 6 characters!");
                </script>
                <?php
                $valid=false;
            };
       $con = mysqli_connect($dbhost, $username, $password, $database);
       if (mysqli_connect_errno())
       {
           echo "Failed to connect to MySql: ". mysqli_connect_error();
       };


       $sql = "
           SELECT
               username,
               password
           FROM
               organizers
           WHERE
               username = '" . $_POST["username"] . "' 
               AND password = '" . $_POST["pwordO"] . "'";
         
        if($results=mysqli_query($con,$sql))
        {
            if (mysqli_num_rows($results) == 1)
            {
                $_SESSION['username'] = $_POST["username"];
                $sql = "INSERT INTO logs(log_action, log_details)
                        VALUES( 'Organizer Logged In', 'Organizer: " . $_SESSION['username'] . " login in sucessfully' )";
                $results = mysqli_query($con,$sql) or die( "SQL Error: " . mysqli_error($con) );
                ?>
                <script type="text/javascript">
                    window.location.replace('manageTimeslots.php');
                </script>
                    <?php
            }
            else
            {
                $_SESSION['username'] = $_POST["username"];
                $sql = "INSERT INTO logs(log_action, log_details)
                        VALUES( 'Organizer Failed Login', 'Organizer: " . $_SESSION['username'] . "  failed to login.' )";
                $results = mysqli_query($con,$sql) or die( "SQL Error: " . mysqli_error($con) );
                ?>
                <script type="text/javascript">
                alert("The username and password you entered is wrong! ");
                </script>
                Login failed, Try again ... <br><INPUT TYPE='button' VALUE='Back' onClick='history.go(-1);'>
                <?php
            }
        }
        else {
            echo mysqli_error($con);
        }
        mysqli_close($con);    
        ?>
