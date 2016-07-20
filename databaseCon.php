<?php
//scoping == use global variables (simple version of using the variables outside of the file!)

$dbhost = "localhost";    
$username = "root";
$password = "";
$database = "volunteer";

global $dbhost, $username, $password, $database;
?>