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
  
  if (isset($_POST['action']) && $_POST['action']=="add") {
    $addsql = "INSERT INTO tasks_table (task_name) VALUES ('" . $_POST['taskname'] . "')";
    if (!($res = mysqli_query($con,$addsql))) {
      echo mysqli_error($con);
      mysqli_free_result($res);
    }
  }
  
  if (isset($_GET['delete'])) {
    $deletesql = "
      DELETE FROM tasks_table
      WHERE task_id = '" . $_GET['taskid'] . "'";
      if (!($res = mysqli_query($con,$deletesql))) {
        echo mysqli_error($con);
        mysqli_free_result($res);
      }
  }
  if (isset($_POST['action']) && $_POST['action']=="edit") {
    $deletesql = "
      UPDATE tasks_table
      SET task_name='" . $_POST['taskname'] . "'
      WHERE task_id = '" . $_POST['taskid'] . "'";
      if (!($res = mysqli_query($con,$deletesql))) {
        echo mysqli_error($con);
        mysqli_free_result($res);
      }
  }
  
  
  $tasksql = "
    SELECT
      task_name task,
      task_id id
    FROM
      tasks_table
    ORDER BY task_id
    ";
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01//EN">
<html>
  <head>
    <title>
      Manage Tasks
    </title>
  </head>
  <body>
    <table style="width: 500px;" cellspacing="1" cellpadding="1">
        <tr>
            <td width="100%" align="right"><a href="../logout.php">Logout</td>
        </tr>
    </table>
    <h3>
      <strong><font color="firebrick">Current Tasks:</font></strong>
    </h3>
    <table style="width: 500px; border:1px; background-color: #D8D8D8;" cellspacing="1" cellpadding="1">
    
      <tr style="background-color: #0174DF:">
        <td align="center" bgcolor="#0174DF"><font color="white">Task Name</font></td>
        <td align="center" bgcolor="#0174DF"><font color="white">Edit</font></td>
        <td align="center" bgcolor="#0174DF"><font color="white">Delete</font></td>
      </tr>
      <?php
      if ($tresults=mysqli_query($con,$tasksql))
      {
        while($row = mysqli_fetch_object($tresults)) {
          ?>
          <tr>
            <td><?=$row->task?></td>
            <td><a href="editTask.php?taskid=<?=$row->id?>">Edit</td>
            <td><a href="manageTasks.php?delete=1&taskid=<?=$row->id?>">Delete</a></td>
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
      <strong><font color="firebrick">Add New Task:</font></strong>
    </h3>
    
    <form method="post" action="">
      <input type="hidden" name="action" value="add">
      Task Name: <input type="text" name="taskname"><input type="submit" name="Add" value="add">
      <tr height = 20>
          <td><br></td>
      </tr>
      <tr height = 20>
          <td><br></td>
      </tr>
      
      <tr colspan = "2" align = "right" height = "20">
          <td><B> No changes ....  </B><INPUT TYPE='button' VALUE='Back' onClick="window.location.href='manageTimeslots.php'"></td>
      </tr>
      
    </form>
  </body>
</html>
