<?php
session_start();
include "check_orglogin.php";
include "databaseCon.php";
?>


<!DOCTYPE html>
<html>
<head>
    <title>Increase Duration</title>
</head>
<body>
    
    <form name="increaseDurationForm" action="validateDuration.php" method="post" onsubmit="">
 
    <?php
        
        // connect to database server (servername, username, password)
        $con = mysqli_connect($dbhost, $username, $password, $database);
        if (mysqli_connect_errno())
        {
            echo "Failed to connect to MySql: ". mysqli_connect_error();
        }
        ?>
    
    <tr height="40"></tr>
    <tr height="10"><b>Duration for the Childrens' Gospel Outreach</b></tr>
    <tr height="40"></tr>
    
    <?php
    $sql = "SELECT COUNT(*) FROM time_slots";
        
    if ($results=mysqli_query($con,$sql))
    {
        $row = mysqli_fetch_row($results);
        $divide = intval($row[0])/3;
        //the query returns value in a row.. thats why row[0].
        // intval - is to get an interger value
        ?>
                    <tr>
                        <td colspan="1"><p>
                           <select name="duration">                       
                               <option value="">Select the Duration</option>
                               <?php
                               $start_day = (1 + $divide);
                               for ($i=$start_day; $i<=14; $i++)
                               {
                                   ?>
                                  <option value="<?=$i?>"><?=$i?> day</option>
                       <?php 
                               }
                               ?>
                               </select>
                                   <input type="hidden" name="start_day" value="<?=$start_day?>">
                               </p></td>
                               <?php

    }
    ?>
   
        <td colspan="2">
            <input type="submit" name="submit" value="Submit" />
        </td>
        <!--below few lines are for to submit a page!!!-->

    </tr>
    <tr height="40"></tr>
    <tr colspan = "2" align = "right" height = "20">
        <td><p><B> No changes ....  </B><INPUT TYPE='button' VALUE='Back' onClick="window.location.href='manageTimeslots.php'"></p></td>
    </tr>
</form>
</body>
