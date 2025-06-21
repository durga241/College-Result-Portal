<?php
session_start();
include('dbcon.php');
require 'vendor/autoload.php'; // PHPMailer

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

if (isset($_POST['submit'])) {
    $rollno = mysqli_real_escape_string($con, $_POST['rollno']);
    $dob_input = $_POST['dob']; // format: DD-MM-YYYY

    // Convert DD-MM-YYYY to YYYY-MM-DD
    $dob_parts = explode('-', $dob_input);
    if (count($dob_parts) !== 3) {
        echo "<script>alert('Invalid Date format. Please use DD-MM-YYYY.'); window.location.href='index.php';</script>";
        exit();
    }

    $formatted_dob = $dob_parts[2] . '-' . $dob_parts[1] . '-' . $dob_parts[0]; // YYYY-MM-DD

    // Fetch student details
    $sql = "SELECT * FROM student_data WHERE u_rollno='$rollno'";
    $run = mysqli_query($con, $sql);

    if (mysqli_num_rows($run) > 0) {
        $data = mysqli_fetch_assoc($run);

        if ($data['u_dob'] === $formatted_dob) {
            $recipientEmail = $data['u_email'];
            $username = $data['u_name'];

            // Store rollno and email in session
            $_SESSION['rollno'] = $rollno;
            $_SESSION['email'] = $recipientEmail;

            // Generate 6-digit OTP
            $otp = random_int(100000, 999999);

            // Store OTP and expiry in session
            $_SESSION['otp'] = $otp;
            $_SESSION['otp_expiry'] = time() + 300; // 5 minutes

            // Send Email using PHPMailer
            $mail = new PHPMailer(true);
            try {
                $mail->isSMTP();
                $mail->Host       = 'smtp.gmail.com';
                $mail->SMTPAuth   = true;
                $mail->Username   = 'durga.ishu123@gmail.com'; // your Gmail
                $mail->Password   = 'sjkaqabbvkbiyccq';         // app password
                $mail->SMTPSecure = 'tls';
                $mail->Port       = 587;

                $mail->setFrom('your_email@gmail.com', 'DP');
                $mail->addAddress($recipientEmail);
                $mail->isHTML(true);
                $mail->Subject = 'OTP Verification - Durga Prasad';
                $mail->Body    = "
                    <h3>Hello $username,</h3>
                    <p>Your One-Time Password (OTP) is: <strong>$otp</strong></p>
                    <p>This OTP is valid for 5 minutes.</p>
                    <br><p>Regards,<br><strong>Durga Prasad</strong></p>
                ";

                $mail->send();
                echo "<script>alert('OTP sent to $recipientEmail'); window.location.href = 'verify_otp.php';</script>";
            } catch (Exception $e) {
                echo "<script>alert('Email could not be sent. Error: {$mail->ErrorInfo}'); window.location.href = 'index.php';</script>";
            }

        } else {
            echo "<script>alert('Date of Birth does not match our records.'); window.location.href='index.php';</script>";
        }

    } else {
        echo "<script>alert('Roll number not found'); window.location.href = 'index.php';</script>";
    }
}
?>
