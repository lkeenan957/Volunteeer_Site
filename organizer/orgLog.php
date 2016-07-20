<a href="insertMessageToVolunteer.php" id="" title="insertMessageToVolunteer">insertMessageToVolunteer</a>
<?php
session_start();

include "check_orglogin.php";
include "databaseCon.php";
?>

<!DOCTYPE>
<html>
<head>
    <title>All the log details</title>
</head>
<body>
    
    
    <form name="orgViewLogForm" method="post">
    <tr>
        <td colspan = "4"; width="100%"; align="right"><a href="../logout.php">Logout</a></td>
    </tr>
    
    <h1><b><font color="red">Log Details:</font></b></h1>  
    
    <table style="border=1px; background-color:#FAFAFA;" cellspacing="1" cellpadding="1"> 
    <tr style = "background-color: #E6E6E6:"/>  
    <table, tr, td {
        border: 1px solid black;
        border-collapse: collapse;
    }>

    
    <tr>
        <td style="width:200px; background-color: #0174DF" align="center"><b><font color="white">Date/Time</font></b></td>
        <td style="width:200px; background-color: #0174DF" align="center"><b><font color="white">Action</font></b></td>
        <td style="width:600px; background-color: #0174DF" align="center"><b><font color="white">Details</font></b></td>
    </tr>

<?php
    
    //connect to the database to get the volunteer names!!
    $con = mysqli_connect($dbhost, $username, $password, $database);
    
    if (mysqli_connect_errno())
    {
        echo "Failed to connect to MySql: ". mysqli_connect_errno();
    }
    else
    {        
            $sql = "SELECT 
                        log_time as date, 
                        log_action as action, 
                        log_details as details 
                    FROM logs
                    ORDER BY log_time DESC";
                    
            if($results=mysqli_query($con,$sql))
            {   

             while($row=mysqli_fetch_object($results))
             {
                 ?>
                 <tr>
                     <td style= td style="width:200px; background-color: #0174DF" align="left"><b><font color="blue"><?=$row->date?></td>
                     <td style= td style="width:200px; background-color: #0174DF" align="left"><b><font color="blue"><?=$row->action?></td>
                     <td style= td style="width:600px; background-color: #0174DF" align="left"><b><font color="blue"><?=$row->details?> </td>
                </tr>
                 <?php
             }
          }
     }
     ?>
    <tr height = "60">
        <td><INPUT TYPE='button' VALUE='Back' onClick="window.location.href='manageTimeslots.php'"></td>
    </tr>
     </table>


</body>
</html>