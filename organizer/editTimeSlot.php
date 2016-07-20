<?php
  session_start(); 
  
  include "check_orglogin.php";
  include "databaseCon.php";
  
  $vname = "";
  // connect to database server (servername, username, password)
  $con = mysqli_connect($dbhost, $username, $password, $database);
  if (mysqli_connect_errno())
  {
      echo "Failed to connect to MySql: ". mysqli_connect_error();
  }

  //In SQL query * means select everything!!
  $sql = "
      SELECT
          concat(V.first_name,' ',V.surname) as vname
      FROM
          volunteer_times VT
          INNER JOIN time_slots TS
              ON VT.timeslot_id = TS.timeslot_id
          INNER JOIN volunteer_details V
              ON VT.email = V.email_Address
      WHERE
          VT.vol_time_id = '" . $_GET['timeslot'] . "'";
  if ($results=mysqli_query($con,$sql))
  {
    $row = mysqli_fetch_object($results);
    $vname=$row->vname;
    mysqli_free_result($results);
  } else {
    echo mysqli_error($con);
  }
  
  $tasksql = "
    SELECT
      T.task_name task,
      T.task_id id
    FROM
      tasks_table T
      INNER JOIN volunteer_times VT
        ON T.task_id = VT.task_id
    WHERE
      VT.vol_time_id = '" . $_GET['timeslot'] . "'";
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01//EN">
<html>
  <head>
    <title>
      Edit Time Slot for <?=$vname?>
    </title>
  </head>
  <body>
    <h3>
      <strong>Current Tasks:</strong>
    </h3>
    <table style="width: 500px; border:1px; background-color: #D8D8D8;" cellspacing="1" cellpadding="1">
      <tr style="background-color: #D0E7E6:">
        <td align="center">Task Name</td>
        <td align="center">Edit</td>
        <td align="center">Delete</td>
      </tr>
      <?php
      if ($tresults=mysqli_query($con,$tasksql))
      {
        while($row = mysqli_fetch_object($tresults)) {
          ?>
          <tr style="background-color: #D0E7E6:">
            <td><?=$row->task?></td>
            <td>Edit <?=$row->id?></td>
            <td>Delete <?=$row->id?></td>
          </tr>
          <?php
        }
        mysqli_free_result($tresults);
      } else {
        echo mysqli_error($con);
      }
      ?>
    </table>
    <h3>
      <strong>Add New Task:</strong>
    </h3>
    <table style="width: 500px; border:1px; background-color: #D8D8D8;" cellspacing="1" cellpadding="1">
      <tr>
        <td>
          Task Name:
        </td>
        <td>
          <input type="text" name="task">
        </td>
      </tr>
    </table>
  </body>
</html>
