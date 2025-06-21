<?php
session_start();

if (!isset($_SESSION['uid'])) {
    header('location: ../login.php');
    exit();
}
?>
<html>
<head>
    <title>Delete Mark</title>
    <link rel="stylesheet" href="../csss/updatemark.css" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Flamenco" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/3.7.0/animate.min.css">
</head>
<body>
    <header>
      <nav>
        <div class="row clearfix">
            <ul class="main-nav" animate slideInDown>
                <li><a href="../index.php">Home</a></li>
                <li><a href="aboutus.php">About Us</a></li>
                <li><a href="contactus.php">Contact Us</a></li>
                <li class="logout"><a href="admindash.php">Dashboard</a></li>
            </ul>
        </div>
      </nav>
      <div class="main-content-header">
        <form method="post" action="deleteform.php">
            <h1 align="center">Search Student and Delete Marks</h1>
            <table class="table1">
                <tr>
                    <th>Roll No</th>
                    <td><input type="text" name="rollno" required/></td>
                    <th><input type="submit" value="Search" name="submit" class="submit"/></th>
                </tr>
            </table>
        </form>

        <table class="table2">
            <tr> 
                <th>Id</th>
                <th>Name</th>
                <th>Roll No</th>
                <th>Date of Birth</th>
                <th>Branch</th>
                <th>Delete</th>
            </tr>
            
            <?php
            if (isset($_POST['submit'])) {
                include('../dbcon.php');
                $rollno = $_POST['rollno'];
                
                $sql = "SELECT id, u_name, u_rollno, u_dob, u_branch FROM student_data WHERE u_rollno='$rollno'";
                $run = mysqli_query($con, $sql);
                
                if (mysqli_num_rows($run) == 0) {
                    echo "<tr><td colspan='6' align='center'>No Record Found</td></tr>";
                } else {
                    while ($data = mysqli_fetch_assoc($run)) {
                        echo "<tr>
                            <td>{$data['id']}</td>
                            <td>{$data['u_name']}</td>
                            <td>{$data['u_rollno']}</td>
                            <td>{$data['u_dob']}</td>
                            <td>{$data['u_branch']}</td>
                            <td><a href='delete_data.php?sid={$data['id']}'>Delete</a></td>
                        </tr>";
                    }
                }
            }
            ?>
        </table>
      </div>
    </header>
</body>
</html>
