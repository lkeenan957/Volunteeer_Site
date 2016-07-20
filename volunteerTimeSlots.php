<?php


session_start();
include "databaseCon.php";
 // IMPORTANT ALWAYS START SESSION AT THE START OF THE PAGE_ OTHERWISE IT DOESN'T WORK AND START ON ALL THE PAGES WHERE THE USER SHOULD BE LOGGED IN
  $con = mysqli_connect($dbhost, $username, $password, $database);
if (mysqli_connect_errno())
{
    echo "Failed to connect to MySql: ". mysqli_connect_error();
}

if( isset( $_POST[ 'msgid' ] ) )
{
    $sql = "
    UPDATE 
        messages 
    SET 
        volunteer_response = '" . $_POST["response"] . "'
    WHERE 
        message_id = " . $_POST['msgid'] . "
        AND emailAddress = '" . $_SESSION['emailAddress'] . "'
    ";
    
    if(!mysqli_query($con,$sql))
    {
        echo mysqli_error($con);
    }
    mysqli_close($con);
}

// If the $_POST( "add" ) variable exists
// sending back to the same page
if( isset( $_POST[ 'add' ] ) )
{
    // Insert a record into the timeslots table
    // vol_time_id, timeslot_id, email
    
    // DML commands: INSERT, UPDATE, SELECT, DELETE
    
    // When you submit a form, all input elements with the name attribute set will have a value in the $_POST array
    
    //echo "The user selected: " . $_POST[ 'timeslot' ]; - IMPORTANT
    
    // We need quotation marks around $_SESSION['emailAddress'] INSIDE the query because it is a VARCHAR
    
    // see below lines 186-195 for the next set of explanation
    
    $sql = "
    INSERT INTO volunteer_times(timeslot_id, email )
    VALUES(" . $_POST[ 'timeslot' ] . ", '" . $_SESSION['emailAddress'] . "')
    ";
    
    if(!mysqli_query($con,$sql))
    {
        if(mysqli_errno($con) == 1062) {
            // pop up an alert (pop-up box)
            ?>
            <script type="text/javascript">
              alert("You already entered that time slot")
            </script>
            <?php
        }
        else {
            echo mysqli_error($con);            
        }
    }
    else{
        $sql = "INSERT INTO logs(log_action, log_details)
                VALUES( 'Volunteer adding timeslot', ' A timeslot was added by" . $_SESSION['emailAddress'] . "' )";
        $results = mysqli_query($con,$sql) or die( "SQL Error: " . mysqli_error($con) );
        mysqli_close($con);
    }
    
}

if( isset($_GET['remove']) && $_GET['remove'] == "1")
{
    $sql="
        DELETE FROM volunteer_times
        WHERE timeslot_id = " . $_GET[ 'timeslot' ] . "
        AND email = '" . $_SESSION['emailAddress'] . "'";
        
        if(!mysqli_query($con,$sql))
        {

            echo mysqli_error($con);
        }
        else
        {
            $sql = "INSERT INTO logs(log_action, log_details)
                    VALUES( 'Volunteer removing timeslot', ' A timeslot was removed by " . $_SESSION['emailAddress'] . "' )";
            $results = mysqli_query($con,$sql) or die( "SQL Error: " . mysqli_error($con) );
        
        }
        mysqli_close($con);    
}

?>

<!DOCTYPE html>
<html>
<head>
    <title>VOLUNTEER TIME_SLOTS SELECTION FORM</title>
    <script type="text/javascript">
    function confirmRemove() {
        var answer = confirm ("Are you sure you want to delete this timeslot?")
        if(answer)
        {
            return true;
        }
        else
        {
            return false;
        }
    }
    </script>
<head>
<body>
    <table style="width: 500px; border:1px; background-color: #FAFAFA;" cellspacing="1" cellpadding="1">    
    <tr>
        <td colspan="3" align="right"><a href="editDetails.php">Edit Profile</a> | </td>
        <td width="50" align="left"><a href="logout.php">Logout</a>
        </td>
    </tr>
    

</table>
    
    <table style="width: 500px; border:1px; background-color: #FAFAFA;" cellspacing="1" cellpadding="1">    
    <tr style = "background-color: #E6E6E6:"/>
    
    <td colspan="2"><h2><strong><font color = "red">Your Time Slots:</font></strong></h2></td>
    
    <form name="volunteerTimeSlotsForm" method="post" action="volunteerTimeSlots.php">
    <table, th, td {
        border: 1px solid black;
        border-collapse: collapse;
    }>
    <tr>
        <td style="background-color: #0174DF" align="center" style="width: 200px;"><b><font color = "white">Time Slot</font></b></td>
        <td style="background-color: #0174DF" align="center" style="width: 200px;"><b><font color = "white">Allocated Task</font></b></td>
        <td style="background-color: #0174DF" align="center" style="width: 200px;"><b><font color = "white">Details</font></b></td>
        <td style="background-color: #0174DF" align="center" style="width: 200px;"><b><font color = "white">Remove</font></b></td>
    
    </tr>
    
     
    <?php
    
        // connect to database server (servername, username, password)
         $con = mysqli_connect($dbhost, $username, $password, $database);
        if (mysqli_connect_errno())
        {
            echo "Failed to connect to MySql: ". mysqli_connect_error();
        }
    
        //In SQL query * means select everything!!
        $sql = "
            SELECT
                TS.timeslot_name as tsname,
                tasks.task_name as task,
                VT.details as det,
                TS.timeslot_id as tsid
                
            FROM
                volunteer_times VT
                INNER JOIN time_slots TS
                    ON VT.timeslot_id = TS.timeslot_id
                LEFT JOIN tasks_table tasks
                    ON VT.task_id = tasks.task_id
            WHERE
               VT.email = '" . $_SESSION['emailAddress'] . "' 
        ";
        
        if ($results=mysqli_query($con,$sql))
        {
            
            //fetch one and one row
             while($row = mysqli_fetch_object($results))
             {
                 //for below - see lines from 130 - 150
                 ?>
            <tr>
                <td style= "background-color: #D8D8D8;"><?=$row->tsname?></td>
                <td style= "background-color: #D8D8D8;"><?=$row->task?>
                <?php
                    if($row->task == '')
                    {
                        echo 'No Task Allocated';
                    }
                ?></td>
                <td style= "background-color: #D8D8D8;"><?=$row->det?></td>
                <td style= "background-color: #D8D8D8;" align="center">
                    <a href="volunteerTimeSlots.php?remove=1&timeslot=<?=$row->tsid?>" onClick="return confirmRemove();">Remove</a></td> 
            </tr>
                <?php
             }
        mysqli_free_result($results);
        } else {
            echo mysqli_error($con);
        }
        ?>
    
  


    <tr style = "background-color: #58ACFA:"/>
    
    <td colspan="2"><h2><strong><font color = "red">Add Time Slot:</font></strong></h2></td> 
    
    
    <tr>
        <td colspan="3">
        <?php
            //SQL query
            $sql = "SELECT * FROM time_slots";
        
            if ($results=mysqli_query($con,$sql))
            {
                ?>
                <select name="timeslot">
                    <option>Select a time slot..</option>
                <?
                
                //fetch one and one row
                 while($row = mysqli_fetch_row($results))
                 {
                     ?>
                         
                         <option value="<?=$row[0]?>"><?=$row[1]?>
                         </option>
                    <?php
                 }
                 ?>
                 </select>
            <?php
            mysqli_free_result($results);
            }
           
            ?>
            <input type="hidden" name="email" value="<?=$_SESSION['emailAddress']?>">
            <input type="submit" name="add" value="Add"/>
            
        </td>
    </tr>
    <tr height= "30"></tr>
</table>
</form>


<table style="width: 500px; border:1px; background-color: #FAFAFA;" cellspacing="1" cellpadding="1"> 

    <form name="volunteerMessagesForm" method="post" action="volunteerTimeSlots.php">
   
    <tr><td colspan="2"><h2><strong><font color = "red">Your Messages:</font></strong></h2></td></tr>
    <tr>
        <td style="background-color: #0174DF" align="center" style="width: 100px;"><b><font color = "white">Date</font></b></td>
        <td style="background-color: #0174DF" align="center" style="width: 150px;"><b><font color = "white">Organiser Name</font></b></td>
        <td style="background-color: #0174DF" align="center" style="width: 300px;"><b><font color = "white">Message</font></b></td>
        <td style="background-color: #0174DF" align="center" style="width: 200px;"><b><font color = "white">Your Response</font></b></td>
    
    </tr>
    
     
    <?php
    
        // connect to database server (servername, username, password)
        $con = mysqli_connect($dbhost, $username, $password, $database);
        if (mysqli_connect_errno())
        {
            echo "Failed to connect to MySql: ". mysqli_connect_error();
        }
    
        //In SQL query * means select everything!!
        //response null 
        $sql = "
            SELECT
                M.message_id as id,
                M.message as message,
                M.date as date,
                M.username,
                M.emailAddress,
                M.volunteer_response as response,
                concat(O.firstname,'',O.surname) AS oname
                
            FROM
                messages M
                    INNER JOIN organizers O
                        ON O.username = M.username
            WHERE
                M.emailAddress = '" . $_SESSION['emailAddress'] . "' 
                    
            ORDER BY
                M.date DESC
        ";
        
        if ($results=mysqli_query($con,$sql))
        {
            
            //fetch one and one row
             while($row = mysqli_fetch_object($results))
             {
                 //converting the date from the sql to php
                 $phpdate = strtotime($row->date);
                 $retrievedDate = date("d/m/Y", $phpdate);
                 ?>
            <tr>
                <td style= "background-color: #D8D8D8;"><?=$retrievedDate?></td>
                <td style= "background-color: #D8D8D8;"><?=$row->oname?>
                <td style= "background-color: #D8D8D8;"><?=$row->message?></td>
                
                    <?php
                    if($row->response == null)
                    {
                        ?>
                    <td style= "background-color: #D8D8D8;" align="center">
                        <a href="respond.php?id=<?=$row->id?>">Respond</a></td> 
                    <?php
                    }
                    else
                    {
                        ?>
                       <td style= "background-color: #D8D8D8;"><?=$row->response?></td>
                     <?php
                    }
                    ?>
            </tr>
                <?php
             }
        mysqli_free_result($results);
        } 
        else 
        {
            echo mysqli_error($con);
        }
        ?>
    <tr height= "30">
    </tr>
</table>
</form>   
</body>
</html>