<?php
$hostname = "localhost"; //local server name default localhost
$username = "root";  //mysql username default is root.
$password = "";       //blank if no password is set for mysql.
$database = "kerala_congress";  //database name which you created

$con = new mysqli($hostname, $username, $password, $database);

// Check connection
if ($con->connect_error) {
    die('Connection Failed: ' . $con->connect_error);
}
?>
