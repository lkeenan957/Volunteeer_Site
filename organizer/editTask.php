<?php
  session_start();
  include "check_orglogin.php";
  include "databaseCon.php";
 
  $tname = "";
  // connect to database server (servername, username, password)
  $con = mysqli_connect($dbhost, $username, $password, $database);
  if (mysqli_connect_errno())
  {
      echo "Failed to connect to MySql: ". mysqli_connect_error();
  }

  //In SQL query * means select everything!!
  $sql = "
      SELECT
          task_id, task_name
      FROM
          tasks_table
      WHERE
          task_id = '" . $_GET['taskid'] . "'";
  if ($results=mysqli_query($con,$sql))
  {
    $row = mysqli_fetch_object($results);
    $tname=$row->task_name;
    mysqli_free_result($results);
  } else {
    echo mysqli_error($con);
  }
  
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01//EN">
<html>
  <head>
    <title>
      Edit Task
    </title>
  </head>
  <body>
      <table style="width: 500px;" cellspacing="1" cellpadding="1">    
          <tr>
              <td width="100%" align="right"><a href="../logout.php">Logout</td>
          </tr>
      </table>
    <h3>
      <strong>Edit Task:</strong>
    </h3>
    <form action="manageTasks.php" method="post">
      <input type="hidden" name="action" value="edit">
      <input type="hidden" name="taskid" value="<?=$_GET['taskid']?>">
      <table style="width: 500px; border:1px; background-color: #D8D8D8;" cellspacing="1" cellpadding="1">
        <tr style="background-color: #D0E7E6:">
          <td align="right">Task Name: </td>
          <td align="left"><input type="text" value="<?=$tname?>" name="taskname"></td>
          <td><input type="submit" name="Change"></td>
        </tr>
      </table>
    </form>
  </body>
</html>
