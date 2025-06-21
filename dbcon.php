<?php
$con = mysqli_connect('localhost', 'root', '', 'sms');

if (!$con) {
    die("Database Connection Failed: " . mysqli_connect_error());
}
?>
