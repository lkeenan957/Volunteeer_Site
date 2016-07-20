<?php
if(!isset($_SESSION)){
    session_start();
}
include "check_login.php";
include "databaseCon.php";


?>

<!DOCTYPE html>
<html>
<head> 
    <title>VOLUNTEER DETAILS EDIT FORM</title>
    <script type="text/javascript" language="JavaScript">
    function validateForm()
    {
		
		//Address
		if (document.volunteerRegistrationForm.homeAddress1.value == '')
		{
			alert('Home Address field cannot be blank.');
			document.volunteerRegistrationForm.homeAddress1.focus();
			//focus means put the cusor there
			//alert is a pop up box
			return false; //very important
		}
		
		if (document.volunteerRegistrationForm.suburb.value == '')
		{
			alert('Suburb field cannot be blank.');
			document.volunteerRegistrationForm.suburb.focus();
			//focus means put the cusor there
			//alert is a pop up box
			return false; //very important
		}
        
		if (document.volunteerRegistrationForm.postcode.value == '')
		{
			alert('Postcode field cannot be blank.');
			document.volunteerRegistrationForm.postcode.focus();
			//focus means put the cusor there
			//alert is a pop up box
			return false; //very important
		}
        
		if (!document.volunteerRegistrationForm.postcode.length == 5)
		{
			alert('Postcode should be only 5 characters.');
			document.volunteerRegistrationForm.postcode.focus();
			//focus means put the cusor there
			//alert is a pop up box
			return false; //very important
		}
	
		//Phone Number
		if(document.volunteerRegistrationForm.phonenumber.value == '' )
		{
			alert('Phone number field is blank');
			document.volunteerRegistrationForm.phonenumber.focus();
			return false;
		}
		if(isNaN(document.volunteerRegistrationForm.phonenumber.value))
		{
			alert('Phone Phone field must be a number');
			document.volunteerRegistrationForm.phonenumber.focus();
			return false;
		}
        
		//Password
		if(document.volunteerRegistrationForm.pword.value == '' )
		{
			alert('Password field is blank');
			document.volunteerRegistrationForm.pword.focus();
			return false;
		}
		if(document.volunteerRegistrationForm.pword.value.length < 5)
		{
			alert('Password field must be aleast 5 characters long');
			document.volunteerRegistrationForm.pword.focus();
			return false;
		}
		
		//Confirm Password
		if(document.volunteerRegistrationForm.confirmPword.value == '' )
		{
			alert('Confirm Password field is blank');
			document.volunteerRegistrationForm.confirmPword.focus();
			return false;
		}
		if(document.volunteerRegistrationForm.password.value != document.volunteerRegistrationForm.confirmPword.value)
		{
			alert('Password fields do not match');
			document.volunteerRegistrationForm.confirmPword.focus();
			return false;
		}
		
		return true; //very important
    }
    
    </script>
        
</head>
    
<body>
     <table style="width: 500px; border:1px; background-color: #FAFAFA;" cellspacing="1" cellpadding="1"><!--to create another heading-->
    <tr style = "background-color: #FAFAFA;"/>
    
        <td colspan="2"><h2><strong><font color="firebrick">Your Information</font></strong></h2></td>
        <!--colspan is like tab- span 2 columns-->
   
    </tr>
    
    <tr style = "background-color: #FAFAFA;"/>
        <td ><h3><strong><font color="firebrick">You could edit the address, phone number and password fields</font></strong></h3></td>
        <!--colspan is like tab- span 2 columns-->
    </tr>
     
     <form name="volunteerTimeSlotsForm" method="post" action="updateEditDetails.php" onsubmit="return validateForm();">


        
        <!--ALWAYS REMEMBER WHEN YOU CREATE A NEW COLUMN- MAKE SURE TO FINISH IT WITH td AND THEN In THE NEXT COLUMN ASK FOR THE INPUT-->
       
        <!--REMEMBER :ALWAYS FINISH THE INPUT STATEMENT WITH /
        and 200px;"-->
        <!-- <input name="firstname" type="text" style="width: 200px;" maxlength="100" /> -->
        <!--nothing  needs value, unless something asked- otherwise it appears in the site
        only buttons need value- ex:submit, restart-->
        <!--  <td>Address:</td>
            <td><textarea name= "homeAddress1" cols="1" rows="1"></textarea> -->
            <!--dob and email are same as name- no need of value but style:width-->
            <!--buttons dont need a name- it will appear in the site-->
<?php
$con = mysqli_connect($dbhost, $username, $password, $database);
   
    if (mysqli_connect_errno())
    {
        echo "Failed to connect to MySql: ". mysqli_connect_error();
    }
    
        $sql = "
            SELECT
                * 
            FROM
                volunteer_details
            WHERE
                email_Address = '" . $_SESSION['emailAddress'] . "'";
                
        if ($results=mysqli_query($con,$sql))
        {
            $row = mysqli_fetch_object($results)
                // getting a row from the table as an object and displaying it
                ?>
                <tr>
                     <td></td>
                </tr>
                
                <tr colspan = "2" align = "right">
                
                <td> No changes .. <br><INPUT TYPE='button' VALUE='Back' onClick="window.location.href='volunteerTimeSlots.php'"></td>
                </tr>
                
                <tr height = 25>
                     <td></td>
                </tr>
                
                <tr>
                    <td>Email Address:</td>
                    <td><?=$row->email_Address?></td>
                </tr> 
                
                <tr>
                    <td>First Name:</td>
                    <td><?=$row->first_name?></td>
                </tr>
        
                <tr>
                    <td>Surname:</td>
                    <td><?=$row->surname?></td>
                </tr>
                
                <tr>
                    <td>Address:</td>
                    <td><input type= "text" name= "homeAddress1" value = "<?=$row->homeaddress_line1?>" maxlength="30" style="width: 200px;"/>
                    </td>
                </tr>
                
                <tr>
                    <td colspan="1"></td>
                    <td><input type= "text" name= "homeAddress2" value = "<?=$row->homeaddress_line2?>" maxlength="30" style="width: 200px;"/>
                    </td>
                </tr>
                
                <tr>
                    <td>Suburb:</td>
                   <td><input type= "text" name= "suburb" value = "<?=$row->suburb?>" maxlength="30" style="width: 200px;"/>
                    </td>
                </tr>
                
                <tr>
                    <td>Postcode:</td>
                    <td><input type= "text" name= "postcode" value= "<?=$row->postcode?>" maxlength="30" style="width: 200px;"/>
                    </td>
                </tr>

                <tr>
                    <td>Phone Number:</td>
                    <td><input type="text" name="phonenumber" value = "<?=$row->phone_number?>" maxlength="30" style="width: 200px;"/>
                    </td>
                </tr>
        
                <tr>
                    <td>Date of Birth (in YYYY/MM/DD):</td>
                    <td><?=$row->DOB?></td>
                </tr>
        
                <tr>
                    <td>Password:</td>
                    <td><input type="password" name="pword"  value = "<?=$row->password?>" maxlength="30" style="width: 200px;"/>
                    </td>
                </tr>
        
                <tr>
                    <td>Confirm Password:</td>
                    <td align ="left"><input type="password" name="confirmPword"  value = "<?=$row->password?>" maxlength="30" style="width: 200px;"/>
                    </td>
                </tr>
        
                <tr>
                    <td colspan="1">
                        <input type="submit" name = "update" value ="Update">
                    </td>
                </tr>

                <?php
                
            
        }
    
            
            
 ?>           
        

</form> 
</table>
</body>
</html>