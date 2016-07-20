<?
if(!isset($_SESSION)){
    session_start();
    include "databaseCon.php";
}
include "check_login.php";
?>
<html>
<head>
    <title>Retrieve data from database - "Volunteer"</title>
</head>
<body>
    
    <?php
        
        // connect to database server (servername, username, password)
         $con = mysqli_connect($dbhost, $username, $password, $database);
        if (mysqli_connect_errno())
        {
            echo "Failed to connect to MySql: ". mysqli_connect_error();
        }
        
        //SQL query
        $sql = "SELECT * FROM time_slots";
        
        if ($results=mysqli_query($con,$sql))
        {
            ?>
             <select name="category">
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
        <?php
            mysqli_free_result($results);
        }
        ?>
        
      
        <tr>
            <td colspan="1">
                <input type="button" name="add" value="Add"/>
            </td>
        </tr>
        <?php
        
        // close the database connection
        mysqli_close($con);
        
    ?>
    
</body>
</html>