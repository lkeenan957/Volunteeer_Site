<?php
session_start();

include "check_orglogin.php";
include "databaseCon.php";
?>

<!DOCTYPE>
<html>
<head>
    <title>Message Volunteer</title>
    
    <script type="text/javascript" language="JavaScript">
    
    function validateForm()
    {
        if(document.messageToVolunteerForm.writtenMessage.value == '')
        {
            alert('Message field is blank');
            document.messageToVolunteerForm.writtenMessage.focus();
            return false;
        }
        
        
        return true;
    }
    
    function checkMessageField() 
    {
        if(document.messageToVolunteerForm.writtenMessage.value == '')
        {
            alert('Please enter a message to send!');
            document.messageToVolunteerForm.writtenMessage.focus();
            return false;
        }
        return true;
        
    }
    
    </script>
    
</head>
<body>
    
    
    <form name="messageToVolunteerForm" action="insertMessageToVolunteer.php" method="post" onsubmit="return checkMessageField()">
    <tr>
        <td colspan = "4"; width="100%"; align="right"><a href="../logout.php">Logout</a></td>
    </tr>
    
    <h1><b><font color:"red">Message Volunteer:</font></b></h1>  
    
    <table style="width: 500px; border=1px; background-color:#FAFAFA;" cellspacing="1" cellpadding="1"> 
    <tr style = "background-color: #E6E6E6:"/>  
    <table, tr, td {
        border: 1px solid black;
        border-collapse: collapse;
    }>
<?php
    
    //connect to the database to get the volunteer names!!
    $con = mysqli_connect($dbhost, $username, $password, $database);
    
    if (mysqli_connect_errno())
    {
        echo "Failed to connect to MySql: ". mysqli_connect_errno();
    }
    
?>    
    
    
    
    <tr>
        <td>Message:</td>
        <td>
            <input type="text" name="writtenMessage" maxlength="250"; style="width:300px">
        </td>
        <td>
            

                    
            <?php
                 
            $sql = "SELECT first_name, surname, email_Address 
                    FROM volunteer_details
                    ORDER BY first_name ASC";
                    
            if($results=mysqli_query($con,$sql))
            {   
            ?>
                <select name="volemailadd">
            <?php
                while($row=mysqli_fetch_row($results))
                {
            ?>
                   
                    <option value="<?=$row[2]?>"><?=$row[0]?>  <?=$row[1]?>
                    <!--the above line : $row[3] this indicates the sql in line above where it was selected from the table as the 3rd element. first element is first_name and the 2nd is surname-->
                    </option>
            <?php
                }
            }

            ?>

            </select>
        </td>
        <td>

            <input type="submit" name="sendMessage" value="Send Message">
        </td>
    </tr>
     </table>

    
    <h1><b><font color:"red">Current Messages:</font></b></h1>  
    
    <table style="width: 500px; border=1px; background-color:#FAFAFA;" cellspacing="1" cellpadding="1"> 
    <tr style = "background-color: #E6E6E6:"/>  
    <table, tr, td {
        border: 1px solid black;
        border-collapse: collapse;
    }>
    
    <tr>
        <td style="width:200px; background-color: #0174DF" align="center"><b><font color="white">Date</font></b></td>
        <td style="width:200px; background-color: #0174DF" align="center"><b><font color="white">Organiser Name</font></b></td>
        <td style="width:200px; background-color: #0174DF" align="center"><b><font color="white">Message</font></b></td>
        <td style="width:200px; background-color: #0174DF" align="center"><b><font color="white">Volunteer Name</font></b></td>
        <td style="width:200px; background-color: #0174DF" align="center"><b><font color="white">Response</font></b></td>
    </tr>
    
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
                M.username as username,
                M.emailAddress as email,
                M.date as date,
                M.message as message,
                M.volunteer_response as response,
                concat(VD.first_name,' ',VD.surname) AS vname,
                concat(O.firstname,'',O.surname) AS oname
                
            FROM
                messages M
                    INNER JOIN organizers O
                        ON O.username = M.username

                   
                    INNER JOIN volunteer_details VD
                        ON M.emailAddress = VD.email_Address


            ORDER BY M.date";
            
            if($results = mysqli_query($con,$sql1))
            {

             while($row=mysqli_fetch_object($results))
             {
                 ?>
                 <tr>
                     <td style= td style="width:200px; background-color: #0174DF" align="center"><b><font color="blue"><?=$row->date?></td>
                     <td style= td style="width:200px; background-color: #0174DF" align="center"><b><font color="blue"><?=$row->oname?></td>
                     <td style= td style="width:200px; background-color: #0174DF" align="center"><b><font color="blue"><?=$row->message?> </td>
                     <td style= td style="width:200px; background-color: #0174DF" align="center"><b><font color="blue"><?=$row->vname?> </td>
                     <td style= td style="width:200px; background-color: #0174DF" align="center"><b><font color="blue"><?=$row->response?> </td>
                </tr>
                 <?php
             }
         }
     }
     ?>
 
    
     <tr colspan = "2" align = "right" height = "60">
         <td><B> No changes ....  </B><INPUT TYPE='button' VALUE='Back' onClick="window.location.href='manageTimeslots.php'"></td>
     </tr>
     </table>


</body>
</html>