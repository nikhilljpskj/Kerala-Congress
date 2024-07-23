<?php
session_start();
$_SESSION = array();
session_destroy();
header("location: dist_auth_log.html");
exit;
?>
