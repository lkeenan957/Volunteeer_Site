<?php
// Is this a login attempt?
// If so, is the username and password provided?
// If so, are they correct
if (!isset($_SESSION['emailAddress'])) {
    echo "You are not logged in.  Please log in to continue.<br>";
    echo "<a href='index.html'>Login</a>";
    exit;
}
?>