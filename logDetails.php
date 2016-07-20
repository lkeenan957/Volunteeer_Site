// LOG FOR REGISTRATION
<?php
include "databaseCon.php";

$con = mysqli_connect($dbhost, $username, $password, $database);

$sql = INSERT INTO logs("log_action", "log_details")
        VALUES("Registraion", "firstname{0} . surname . '"with"' . emailAddress . '"registered as a volunteer"')";

if($results = mysqli_query("$con","$sql"))
{
    echo "The details were added to the logs table";
}
else
{
    echo "The details were NOT added to the logs table";
}

?>
log_action” – a short description of the event that occurred, e.g. “Task Allocated”
􏰁 “log_details” – the email address or username of the user who performed the action, and what it involved, e.g. “mjones allocated Set Up task to jbloggs@stuff.com on Day 1, Morning”
---------------------------------------------------

