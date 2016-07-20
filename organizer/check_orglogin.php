<?php
if (!isset($_SESSION['username'])) {
    echo "You are not logged in.  Please log in to continue.<br>";
    echo "<a href='../index.html'>Login</a>";
    exit;
}
?>