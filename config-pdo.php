<?php

$host =  'localhost';
$user = 'root';
$password = '';
$dbname = 'whereelz-crud-app';

// Set DSN
$dsn = 'mysql:host='. $host .';dbname='. $dbname;

// Create a PDO instance
$con  = new PDO($dsn, $user, $password);
$con->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);
$con->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
?>