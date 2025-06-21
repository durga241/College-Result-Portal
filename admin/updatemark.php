<?php
session_start();

if (!isset($_SESSION['uid'])) {
    header('location: ../login.php');
    exit();
}
?>

<html>
<head>
    <title>Update Record</title>
    <link rel="stylesheet" href="../csss/updatemark.css" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Flamenco" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/3.7.0/animate.min.css">
</head>
<body>
    <header>
        <nav>
            <div class="row clearfix">
                <ul class="main-nav" animate slideInDown>
                    <li><a href="../index.php"><b>HOME</b></a></li>
                    <li><a href="aboutus.php"><b>ABOUT</b></a></li>
                    <li><a href="contactus.php"><b>CONTACT</b></a></li>
                    <li class="logout"><a href="admindash.php"><b>DASHBOARD</b></a></li>
                </ul>
            </div>
        </nav>
        <div class="main-content-header">
            <form method="post" action="updatemark.php">
                <table class="table1">
                    <h1 align="center">Search Student and Update Marks</h1>
                    <tr align="left">
                        <th>Student Roll No :</th>
                        <td><input type="text" name="rollno" class="box" required /></td>
                    </tr>
                    <tr align="left">
                        <th><input type="submit" value="Search" name="submit" class="submit" /></th>
                    </tr>
                </table>

                <table class="table2">
                    <tr>
                        <th class="student_id">ID</th>
                        <th class="student_class">Name</th>
                        <th class="student_class">Date of Birth</th>
                        <th class="student_class">Branch</th>
                        <th class="student_class">Email</th>
                        <th class="student_class">Phone</th>
                        <th class="student_class">Roll No</th>
                        <th class="student_edit">Edit</th>
                    </tr>

                    <?php
if (isset($_POST['submit'])) {
    include('../dbcon.php');
    
    // Ensure the correct database is selected
    mysqli_select_db($con, 'sms');
    
    $rollno = mysqli_real_escape_string($con, $_POST['rollno']);
    $sql = "SELECT * FROM `student_data` WHERE `u_rollno` = '$rollno'";
    $run = mysqli_query($con, $sql);

    if (mysqli_num_rows($run) == 0) {
        echo "<script>alert('No Record Found');</script>";
    } else {
        while ($data = mysqli_fetch_assoc($run)) {
?>
                                <tr>
                                    <th class="student_class2"><?php echo $data['id']; ?></th>
                                    <th class="student_class2"><?php echo $data['u_name']; ?></th>
                                    <th class="student_class2"><?php echo $data['u_dob']; ?></th>
                                    <th class="student_class2"><?php echo $data['u_branch']; ?></th>
                                    <th class="student_class2"><?php echo $data['u_email']; ?></th>
                                    <th class="student_class2"><?php echo $data['u_phone']; ?></th>
                                    <th class="student_class2"><?php echo $data['u_rollno']; ?></th>
                                    <th class="student_class2">
                                        <a href="updatemark_form.php?sid=<?php echo $data['u_rollno']; ?>">Edit</a>
                                    </th>
                                </tr>
                    <?php
                            }
                        }
                    }
                    ?>
                </table>
            </form>
        </div>
    </header>
</body>
</html>
