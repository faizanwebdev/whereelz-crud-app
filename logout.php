<?php
session_start();
date_default_timezone_set("Asia/Kolkata");

//unsetting and destroying session
unset($_SESSION['userid']);
unset($_SESSION['username']);
unset($_SESSION['role']);

session_destroy();

//destroying cookie
setcookie('user', '', time() - 3600, '/');
setcookie('userid', '', time() - 3600, '/');

$con = null;
header("Location: index.php");
?>