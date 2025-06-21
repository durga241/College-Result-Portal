<?php
session_start();

if (!isset($_SESSION['uid'])) {
    header('location: ../login.php');
    exit();
}

include('../dbcon.php');

if (isset($_GET['sid'])) {
    $id = $_GET['sid'];

    $sql = "DELETE FROM `student_data` WHERE `id`='$id'";
    $run = mysqli_query($con, $sql);

    if ($run) {
        echo "<script>alert('Data Deleted Successfully');</script>";
        echo "<script>window.location.href='admindash.php';</script>";
    } else {
        echo "<script>alert('Error in Deleting Data');</script>";
        echo "<script>window.location.href='admindash.php';</script>";
    }
} else {
    echo "<script>alert('No ID Provided');</script>";
    echo "<script>window.location.href='admindash.php';</script>";
}
?>
