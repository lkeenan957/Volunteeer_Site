<?php
session_start();
include "databaseCon.php";
?>
<!DOCTYPE>
<html>
<head>
    <title>RESPONSE TO MESSAGE
    </title>
</head>
<body>
<?php

  // connect to database server (servername, username, password)
   $con = mysqli_connect($dbhost, $username, $password, $database);
  if (mysqli_connect_errno())
  {
      echo "Failed to connect to MySql: ". mysqli_connect_error();
  }
  else
  {


  //In SQL query * means select everything!!
  $sql1 = "
      SELECT 
          *
      FROM messages
      WHERE message_id = " . $_GET['id'];
    

      if($results = mysqli_query($con,$sql1))
      {
          $message = $results->fetch_array(MYSQLI_ASSOC)["message"];
?>


    <h1>RESPONSE TO MESSAGE</h1>
    <form name="responseToMessageForm" action="volunteerTimeSlots.php" method="POST" onsubmit="">
        
        <table style="width: 500px; border=1px; background-color:#FAFAFA;" cellspacing="1" cellpadding="1"> 
        <tr style = "background-color: #E6E6E6:"/>  
        <table, tr, td {
            border: 1px solid black;
            border-collapse: collapse;
        }>
    <input type="hidden" name="msgid" value="<?=$_GET['id']?>">
        <tr>
            <td style="width:200px; background-color: #0174DF" align="center"><b><font color="white">Message</font></b></td>
            <td style="width:200px; background-color: #0174DF" align="center"><b><font color="white">Response</font></b></td>
            
        </tr>
        <tr>
            <td style="width:200px; background-color: #0174DF" align="center"><b><font color="white"><?=$message?></font></b></td>
            <td style="width:200px; background-color: #0174DF" align="center"><b><font color="white">
                <textarea rows="3" cols="50" name="response"></textarea>
               
            </font></b></td>
            
        </tr>
        
        <tr>
              <td colspan="2" align="right">
                  <input type="submit" name="Send"></td>
            </tr>
        </table>
    </form>
<?php
            }
            else
            {
                echo "Failed to find message with id: " . $_GET["id"];
            }
        }

      ?>
</body>
</html>