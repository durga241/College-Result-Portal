<?php
session_start();

// Ensure rollno was submitted first
if (!isset($_SESSION['rollno'])) {
    echo "<script>alert('Please submit the roll number first.'); window.location.href='index.php';</script>";
    exit();
}

// Handle OTP verification
if (isset($_POST['verify'])) {
    $user_otp = $_POST['otp'];

    if (isset($_SESSION['otp']) && isset($_SESSION['otp_expiry'])) {
        if (time() > $_SESSION['otp_expiry']) {
            echo "<script>alert('OTP has expired. Please request a new one.'); window.location.href='index.php';</script>";
            exit();
        }

        if ($user_otp == $_SESSION['otp']) {
            $rollno = $_SESSION['rollno'];
            unset($_SESSION['otp'], $_SESSION['otp_expiry']);
            header("Location: result.php?rollno=$rollno");
            exit();
        } else {
            echo "<script>alert('Invalid OTP. Please try again.'); window.location.href='verify_otp.php';</script>";
            exit();
        }
    } else {
        echo "<script>alert('OTP not set. Please request again.'); window.location.href='index.php';</script>";
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>OTP Verification</title>
    <link rel="stylesheet" href="csss/style1.css" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Flamenco" rel="stylesheet">
</head>
<body>
    <header>
        <nav>
            <div class="row clearfix">
                <ul class="main-nav">
                    <li><a href="index.php">HOME</a></li>
                    <li><a href="admin/aboutus.php">ABOUT</a></li>
                    <li><a href="admin/contactus.php">CONTACT</a></li>
                    <li><a href="login.php">ADMIN LOGIN</a></li>
                </ul>
            </div>
        </nav>
    </header>

    <!-- OTP Section -->
    <div class="otp-container">
        <div class="otp-box">
            <form method="post" action="verify_otp.php">
                <h2>Enter OTP</h2>
                <input type="text" name="otp" required class="box1"/>
                <br>
                <input type="submit" name="verify" value="Verify OTP" class="submit"/>
            </form>
        </div>
    </div>
</body>
</html>
