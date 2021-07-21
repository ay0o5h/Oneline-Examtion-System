<?php
// hide errors notes and warning
ini_set('error_reporting', E_ALL & ~E_NOTICE & ~E_WARNING);
ini_set('display_errors', 1);
// start connection with database
$conn = mysqli_connect('localhost', 'root', '', 'examtest1');
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
