<?php
    
    session_start();

    include "check_orglogin.php";
    include "databaseCon.php";
    
$con = mysqli_connect($dbhost, $username, $password, $database);
    //if (isset($_POST["clear"])) {
        
  // }
   if (isset($_POST["add"])) 
    {
    
        $sql = "
        INSERT INTO volunteer_times(task_id, timeslot_id, details, email)
        VALUES(" . $_POST["task"] . "," . $_POST[ 'timeslot' ] . ",'" . $_POST['detail'] . "','" . $_SESSION['emailAddress'] . "')
        ";
    
        if(!mysqli_query($con,$sql))
        {
            if(mysqli_errno($con) == 1062) 
            {
                // pop up an alert (pop-up box)
                ?>
                <script type="text/javascript">
                  alert("You already entered task")
                </script>
                <?php
            }
            else {
                echo mysqli_error($con);
            }
        }
        else
        {
            $sql = "INSERT INTO logs(log_action, log_details)
                    VALUES( 'Task Allocated', 'was allocated to " . $_SESSION["emailAddress"] . "' )";
        
            $results = mysqli_query($con,$sql) or die( "SQL Error: " . mysqli_error($con) );
     
        }
           
        
    }  
    else 
    {
        echo mysqli_error($con);
    }
?>

<!DOCTYPE html>
<html>
<head>
    <title>VOLUNTEER TIME SLOTS </title>
    <!--This is for the organizer- current volunteer timeslot information-->
<head>
<body>
<?php
// connect to database server (servername, username, password)
$con = mysqli_connect($dbhost, $username, $password, $database);
if (mysqli_connect_errno())
{
    echo "Failed to connect to MySql: ". mysqli_connect_error();



    $sql = "
        UPDATE volunteer_times
    
        SET
            task_id = '" . $_POST['task'] . "',
            details = '" . $_POST['detail'] . "'
            
        WHERE vol_time_id = " . $_POST['timeslot'] ;
        
        if(!mysqli_query($con,$sql))
        {
            echo mysqli_error($con);
        }
}
?>
    <table style="width: 75%;" cellspacing="1" cellpadding="1">
        <tr>
            <td width="100%" align="right"><a href="../logout.php">Logout</td>
        </tr>
    </table>
    <table style="width: 75%; border:1px; background-color: #D8D8D8;" cellspacing="1" cellpadding="1">
    <tr style = "background-color: #D0E7E6:"/>
    
        <td colspan="4"><h3><strong><font color="firebrick">Current Volunteer Time Slots:</font></strong></h3></td>
    </tr>
    <form name="organizercurrentvolunteerTimeSlot" method="post" action="">
    <table, th, td {
        border: 1px solid black;
        border-collapse: collapse;
    }>
    <tr>
        <td style="background-color: #0174DF" align="center" style="width: 200px;"><b><font color = "white">Time Slot</font></b></td>
        <td style="background-color: #0174DF" align="center" style="width: 200px;"><b><font color = "white">Volunteer Name</font></b></td>
        <td style="background-color: #0174DF" align="center" style="width: 200px;"><b><font color = "white">Allocated Task</font></b></td>
        <td style="background-color: #0174DF" align="center" style="width: 200px;"><b><font color = "white">Details</font></b>
        </td>
        <td style="background-color: #0174DF" align="center" style="width: 200px;"><b><font color = "white">Edit</font></b></td>
    
    </tr>
    <?php
        //In SQL query * means select everything!!
        $sql = "
            SELECT
                TS.timeslot_name as tsname,
                tasks.task_name as task,
                VT.details as det,
                VT.vol_time_id as vtid,
                concat(V.first_name,' ',V.surname) as vname
                
            FROM
                volunteer_times VT
                INNER JOIN time_slots TS
                    ON VT.timeslot_id = TS.timeslot_id
                INNER JOIN tasks_table tasks
                    ON VT.task_id = tasks.task_id
                INNER JOIN volunteer_details V
                    ON VT.email = V.email_Address
            ORDER BY tsname
        ";
        
        if ($results=mysqli_query($con,$sql))
        {
            
            //fetch one and one row
             while($row = mysqli_fetch_object($results))
             {
                 //for below - see lines from 130 - 150
                 ?>
            <tr>
                <td style= "background-color: #EFF8FB;"><?=$row->tsname?></td>
                <td style= "background-color: #EFF8FB;"><?=$row->vname?></td>
                <td style= "background-color: #EFF8FB;"><?=$row->task?>
                <?php
                    if($row->task == null)
                    {
                        echo 'No Task Allocated';
                    }
                ?></td>
                <td style= "background-color: #EFF8FB;"><?=$row->det?></td>
                <td style= "background-color: #EFF8FB;" align="center">
                  <a href="allocateTask.php?edit=1&timeslot=<?=$row->vtid?>">Edit</a>
                </td> 
            </tr>
        <?php
             }
        mysqli_free_result($results);
        } else {
            echo mysqli_error($con);
        }
        ?>
        
        <tr height = 20>
            <td></td>
        </tr>
        
        <tr>
            <td><a href="manageTasks.php">Manage Tasks</a></td>
            <td colspan="3"><a href="increaseDuration.php">Increase Duration</a></td>
            <td colspan="4"><a href="messageToVolunteer.php">Message Volunteer</a></td>
            <td colspan="4"><a href="orgLog.php">Log Details</a></td>
        </tr>
        
        <tr height = 40>
            <td></td>
        </tr>
        
</table>

</body>
</html>