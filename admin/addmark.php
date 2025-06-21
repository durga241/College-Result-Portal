<?php
session_start();
if (!isset($_SESSION['uid'])) {
    header('location: ../login.php');
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $_SESSION['rollno'] = $_POST['rollno'];  // Store Roll Number in Session
}
?>

<!DOCTYPE html>
<head>
    <title>Add Marks</title>
    <link rel="stylesheet" href="../csss/addmark.css" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Flamenco" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/3.7.0/animate.min.css">
</head>
<body>
    <header>
        <nav>
            <div class="row clearfix">
                <ul class="main-nav" animate slideInDown>
                    <li class="logout"><a href="admindash.php">Dashboard</a></li>
                    <li><a href="../index.php">Home</a></li>
                    <li><a href="aboutus.php">About</a></li>
                    <li><a href="contactus.php">Contact</a></li>
                </ul>
            </div>
        </nav>
        <div class="main-content-header">
            <h2>Step 1/2 : Enter the Details of Student</h2>
            <form method="post" enctype="multipart/form-data" action="secondstep.php">
                <table class="table1">
                    <tr>
                        <th>Name</th>
                        <th>Date of Birth</th>
                        <th>Roll No</th>
                        <th>Branch</th>
                    </tr>
                    <tr>
                        <td><input type='text' name='name' placeholder='Enter Full Name' class="box"/></td>
                        <td><input type='date' name='dob' required class="box"/></td>
                        <td><input type='text' name='rollno' placeholder='Roll No' required class="box"/></td>
                        <td>
                            <select name='branch' required class="box">
                                <option value='' disabled selected>Select Branch</option>
                                <option value='CSE'>CSE</option>
                                <option value='ECE'>ECE</option>
                                <option value='CSE_AI_DS'>CSE with AI & DS</option>
                                <option value='ECE_VLSI'>ECE with VLSI</option>
                            </select>
                        </td>
                    </tr>
                </table>

                <table class="table2">
                    <tr>
                        <th>Email ID</th>
                        <th>Phone Number</th>
                    </tr>
                    <tr>
                        <td><input type="email" name="email" placeholder="Enter Email ID" required class="box"/></td>
                        <td><input type="text" name="phone" placeholder="Enter Phone Number" required class="box" pattern="[0-9]{10}" title="Enter a valid 10-digit phone number"/></td>
                    </tr>
                </table>

                <table class="table3">
                    <tr>
                        <th>Choose Image -</th>
                        <td><input type="file" name="img" required/></td>
                    </tr>
                </table>

                <table class="table4">
                    <tr>
                        <td align="center" colspan="2">
                            <input type="submit" name="submit" value="Next" class="next_Step"/>
                        </td>
                    </tr>
                </table>
            </form>
        </div>
    </header>
</body>
</html>
