<?php


session_start(); // IMPORTANT ALWAYS START SESSION AT THE START OF THE PAGE_ OTHERWISE IT DOESN'T WORK AND START ON ALL THE PAGES WHERE THE USER SHOULD BE LOGGED IN
include "check_orglogin.php";
include "databaseCon.php";
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01//EN">
<html>
  <head>
    <title>
      Allocate Tasks
    </title>
    <script type="text/javascript">
    function confirmClear() {
        var answer = confirm ("This task will be deleted!")
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

  </head>
  <body>
    <form name="allocateForm" method="post" action="manageTimeslots.php">
      <table style="width: 500px;" cellspacing="1" cellpadding="1">    
          <tr>
              <td width="100%" align="right"><a href="../logout.php">Logout</td>
          </tr>
      </table>
      <table style="width: 500px; border:1px; background-color: #D8D8D8;" cellspacing="1" cellpadding="1">    
          
      <tr style="background-color: #0174DF:"/>
    
    
    <td colspan="2"><h2><strong><font color = "firebrick">Allocate Tasks:</font></strong></h2></td>   
      </tr>
         
      <?php
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
                  VT.vol_time_id as vtid,
                  concat(V.first_name,' ',V.surname) as vname
                
              FROM
                  volunteer_times VT
                  INNER JOIN time_slots TS
                      ON VT.timeslot_id = TS.timeslot_id
                  LEFT JOIN tasks_table tasks
                      ON VT.task_id = tasks.task_id
                  INNER JOIN volunteer_details V
                      ON VT.email = V.email_Address
                      
             WHERE
                 VT.vol_time_id = '" . $_GET['timeslot'] . "'
          ";
        
          if ($results=mysqli_query($con,$sql))
          {

               if($row = mysqli_fetch_object($results))
               {
                   
                   ?>
                   <tr style="background-color: #D0E7E6:"/>
                       <td colspan="1"><h3><strong>Name of the Volunteer:</strong></h3></td>
                        <td colspan="1"><h3><strong><?=$row->vname?></strong></h3></td>
                    </tr>
                    
                    <tr style="background-color: #D0E7E6:"/>
                        <td colspan="1"><h3><strong>Time slot:</strong></h3></td>
                         <td colspan="1"><h3><strong><?=$row->tsname?></strong></h3></td>
                     </tr>
                 
          <?php
               }
          mysqli_free_result($results);
          } else {
              echo mysqli_error($con);
          }
          ?>  
        </tr>
        
        <table, th, td {
            border: 1px solid black;
            border-collapse: collapse;
        }>
     
        <tr style = "background-color: #D0E7E6:"/>
    
        <td colspan="2"><h2><strong><font color = "firebrick">Add Tasks:</font></strong></h2></td> 
    
        <tr>
            <td>
          <?php
        
              // connect to database server (servername, username, password)
              $con = mysqli_connect("localhost","lydia", "smileall123", "volunteer");
              if (mysqli_connect_errno())
              {
                  echo "Failed to connect to MySql: ". mysqli_connect_error();
              }
        
              //SQL query
              $sql = "SELECT * FROM tasks_table";
        
              if ($results=mysqli_query($con,$sql))
              {
                  $detsql = "SELECT details from volunteer_times where vol_time_id = " . $_GET['timeslot'];
                  $detres=mysqli_query($con,$detsql);
                  if (mysqli_connect_errno())
                  {
                      echo "Failed to connect to MySql: ". mysqli_connect_error();
                  }
                  $det = mysqli_fetch_row($detres);
                  ?>
                  <input type="hidden" name="timeslot" value="<?=$_GET['timeslot']?>">
                   <select name="task">
                       <option>Select a task..</option>
                  <?php
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
                   <input type="text" name="detail" value="<?=$det[0]?>">
              <?php
                  mysqli_free_result($results);
              }
              ?>
          </td>
          <td colspan="2">
            <input type="submit" name="add" value="Add"/>
            </td>
        </form>
             
        <form name="clearForm" method="post" action="manageTimeslots.php" onSubmit="return confirmClear()">
            <td colspan="2">
                <input type="hidden" name="detail" >
                <input type="hidden" name="task">
                <input type="hidden" name="timeslot" value="<?=$_GET['timeslot']?>">
                <input type="submit" name="clear" value="Clear"/>
            </td>
        </tr>
        
        <tr height = "50">
            <td></td>
        </tr>
            
        <tr colspan = "2" align = "right">
            <td><B> No changes ....  </B><INPUT TYPE='button' VALUE='Back' onClick="window.location.href='manageTimeslots.php'"></td>
        </tr>
            
              <?php
              // close the database connection
              mysqli_close($con);
          ?>
     
      <form>
          
    </table>
  </body>
</html>