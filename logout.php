<?php
session_start(); // IMPORTANT ALWAYS START SESSION AT THE START OF THE PAGE_ OTHERWISE IT DOESN'T WORK AND START ON ALL THE PAGES
?>
<!DOCTYPE html>
<html>
<head> 
    <title>LogOut</title>
        
</head>
    
<body>
You have been logged out.
<?php
      session_destroy();
      include "index.html";
?>
</table>
</body>
</html>