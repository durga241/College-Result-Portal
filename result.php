<?php
session_start();
include('dbcon.php');

// Check if the rollno session variable is set
if (isset($_SESSION['rollno'])) {
    $rollno = $_SESSION['rollno'];  // Retrieve rollno from session

    // Initialize data variables
    $data = null;
    $data2 = null;

    // Fetch student details
    $sql = "SELECT * FROM `student_data` WHERE `u_rollno`='$rollno'";
    $sql2 = "SELECT * FROM `user_mark` WHERE `u_rollno`='$rollno'";

    // Execute the queries
    $run = mysqli_query($con, $sql);
    $run2 = mysqli_query($con, $sql2);
    // echo"$run";

    if (mysqli_num_rows($run) > 0) {
        $data = mysqli_fetch_assoc($run);
        $data2 = mysqli_fetch_assoc($run2);
    } else {
        echo "<script>alert('Record Not Found'); window.location.href='index.php';</script>";
        exit();
    }
} else {
    // Redirect if the session rollno is not set
    echo "<script>alert('Please log in first.'); window.location.href='login.php';</script>";
    exit();
}
?>




<!DOCTYPE html>
<html>
<head>
    <title>Result</title>
    <link rel="stylesheet" href="csss/result.css" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Flamenco" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/3.7.0/animate.min.css">
</head>
<body>
    <header>
        <nav>
            <div class="row clearfix">
                <ul class="main-nav">
                    <li><a href="index.php"><b>HOME</b></a></li>
                    <li><a href="admin/aboutus.php"><b>ABOUT</b></a></li>
                    <li><a href="admin/contactus.php"><b>CONTACT</b></a></li>
                    <li><a href="login.php"><b>ADMIN LOGIN</b></a></li>
                </ul>
            </div>
        </nav>

        <div class="main-content-header">
            <?php if ($data): ?>
            <img src="dataimg/<?php echo !empty($data['u_image']) ? $data['u_image'] : 'default.jpg'; ?>" class="image2" />
            
            <table class="table">
                <tr><th>Name:</th><td><?php echo $data['u_name']; ?></td></tr>
                <tr><th>Roll No:</th><td><?php echo $data['u_rollno']; ?></td></tr>
                <tr><th>Date of Birth:</th><td><?php echo $data['u_dob']; ?></td></tr>
                <tr><th>Branch:</th><td><?php echo $data['u_branch']; ?></td></tr>
            </table>

            <!-- 1st Semester -->
            <table class="table2">
                <tr><th colspan="4">1st Semester</th></tr>
                <tr><th>Course Code</th><th>Course Name</th><th>Credit</th><th>Grade</th></tr>
                <tr><td>MA1011</td><td>Mathematics I</td><td>4</td><td><?php echo $data2['grade1_MA1011'] ?? 'N/A'; ?></td></tr>
                <tr><td>CP1012</td><td>Computer Programming</td><td>4</td><td><?php echo $data2['grade1_CP1012'] ?? 'N/A'; ?></td></tr>
                <tr><td>CC1013</td><td>Cloud Computing</td><td>3</td><td><?php echo $data2['grade1_CC1013'] ?? 'N/A'; ?></td></tr>
                <tr><td>ML1014</td><td>Machine Learning</td><td>3</td><td><?php echo $data2['grade1_ML1014'] ?? 'N/A'; ?></td></tr>
                <tr><td>DS1015</td><td>Data Science</td><td>3</td><td><?php echo $data2['grade1_DS1015'] ?? 'N/A'; ?></td></tr>
            </table>

            <!-- 2nd Semester -->
            <table class="table4">
                <tr><th colspan="4">2nd Semester</th></tr>
                <tr><th>Course Code</th><th>Course Name</th><th>Credit</th><th>Grade</th></tr>
                <tr><td>PH2011</td><td>Physics II</td><td>4</td><td><?php echo $data2['grade2_PH2011'] ?? 'N/A'; ?></td></tr>
                <tr><td>DS2012</td><td>Data Structures</td><td>4</td><td><?php echo $data2['grade2_DS2012'] ?? 'N/A'; ?></td></tr>
                <tr><td>CP2013</td><td>C Programming</td><td>3</td><td><?php echo $data2['grade2_CP2013'] ?? 'N/A'; ?></td></tr>
                <tr><td>PHP2014</td><td>PHP</td><td>3</td><td><?php echo $data2['grade2_PHP2014'] ?? 'N/A'; ?></td></tr>
                <tr><td>SQL2015</td><td>SQL</td><td>3</td><td><?php echo $data2['grade2_SQL2015'] ?? 'N/A'; ?></td></tr>
                <tr><td>AI2016</td><td>Artificial Intelligence</td><td>3</td><td><?php echo $data2['grade2_AI2016'] ?? 'N/A'; ?></td></tr>
            </table>

            <!-- SPI & CPI -->
            <table class="table3">
                <tr><th>SPI (1st Semester)</th><td><?php echo $data2['spi1'] ?? 'N/A'; ?></td></tr>
                <tr><th>SPI (2nd Semester)</th><td><?php echo $data2['spi2'] ?? 'N/A'; ?></td></tr>
                <tr><th>CPI</th><td><?php echo $data2['cpi'] ?? 'N/A'; ?></td></tr>
            </table>
            <?php endif; ?>
        </div>
    </header>
</body>
</html>
