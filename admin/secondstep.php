
<?php
session_start();
				
				if(isset($_SESSION['uid']))
				{
					echo "";					
				}
				else
				{
					header('location: ../login.php');
				}
				
?>

<!DOCTYPE html>
<head>
    <title>Homepage</title>
<link rel="stylesheet" href="../csss/secondstep.css" type="text/css">
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
            </ul>
        </div>
      </nav>
      <div class="main-content-header">
          
      <form method="post" action="thirdstep.php">
                <h2>Step 2/2 : Enter Semester Grades</h2>
                
                <td><input type="hidden" name="rollno" class="rollno" 
    value="<?php echo isset($_POST['rollno']) ? $_POST['rollno'] : ''; ?>" required/></td>

                    <!-- 1st Semester -->
                <h3>1st Semester</h3>
                <table>
                    <tr>
                        <th>Course</th><th>Grade</th>
                    </tr>
                    <tr>
                        <td>Mathematics I</td><td><input type="text" name="grade1_MA1011" required/></td>
                    </tr>
                    <tr>
                        <td>Computer Programming</td><td><input type="text" name="grade1_CP1012" required/></td>
                    </tr>
                    <tr>
                        <td>Could Computing</td><td><input type="text" name="grade1_CC1013" required/></td>
                    </tr>
                    <tr>
                        <td>Machine Learning </td><td><input type="text" name="grade1_ML1014" required/></td>
                    </tr>
                    <tr>
                        <td>Data Science </td><td><input type="text" name="grade1_DS1015" required/></td>
                    </tr>
                </table>

                <h3>2nd Semester</h3>
                <table>
                    <tr>
                        <th>Course</th><th>Grade</th>
                    </tr>
                    <tr>
                        <td>Physics II</td><td><input type="text" name="grade2_PH2011" required/></td>
                    </tr>
                    <tr>
                        <td>Data Structures</td><td><input type="text" name="grade2_DS2012" required/></td>
                    </tr>
                    <tr>
                        <td>C Programming</td><td><input type="text" name="grade2_CP2013" required/></td>
                    </tr>
                    <tr>
                        <td>PHP </td><td><input type="text" name="grade2_PHP2014" required/></td>
                    </tr>
                    <tr>
                        <td>SQL </td><td><input type="text" name="grade2_SQL2015" required/></td>
                    </tr>
                    <tr>
                        <td>AI</td><td><input type="text" name="grade2_AI2016" required/></td>
                    </tr>
                    
                    
                </table>

                
                <input type="submit" name="submit" value="Submit">
                
                
            </form>
      </div>
    </header>

    
</body>
<?php
if (isset($_POST['submit'])) { 
    include('../dbcon.php');

    $username = $_POST['name'];
    $dob = $_POST['dob'];
    $rollno = $_POST['rollno'];
    $branch = $_POST['branch'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];

    // ✅ DOB validation: ensure year is 4 digits and reasonable
    $dobParts = explode("-", $dob);
    $year = isset($dobParts[0]) ? (int)$dobParts[0] : 0;

    if ($year < 1980 || $year > 2005 || strlen($dobParts[0]) !== 4) {
        echo "<script>alert('Invalid Date of Birth. Please use a 4-digit year between 1900 and 2099.');</script>";
        exit();
    }

    $imagename = $_FILES['img']['name'];
    $tempname = $_FILES['img']['tmp_name'];
    // move_uploaded_file($tempname,"../dataimg/$imagename");

    // ✅ Check for duplicates
    $checkQuery = "SELECT * FROM student_data WHERE u_email = '$email' OR u_rollno = '$rollno' OR u_phone = '$phone'";
    $checkResult = mysqli_query($con, $checkQuery);

    if (mysqli_num_rows($checkResult) > 0) {
        $existing = mysqli_fetch_assoc($checkResult);
        $duplicateFields = [];

        if ($existing['u_email'] === $email) {
            $duplicateFields[] = "Email";
        }
        if ($existing['u_rollno'] === $rollno) {
            $duplicateFields[] = "Roll Number";
        }
        if ($existing['u_phone'] === $phone) {
            $duplicateFields[] = "Phone Number";
        }

        $fieldsList = implode(", ", $duplicateFields);
        echo "<script>alert('$fieldsList already registered. Please use different values.'); window.location.href = 'addmark.php';</script>";

    } else {
        // ✅ Insert into DB
        $sql = "INSERT INTO `student_data` (`u_name`, `u_dob`, `u_rollno`, `u_branch`, `u_email`, `u_phone`, `u_image`)
                VALUES ('$username','$dob','$rollno','$branch','$email','$phone','$imagename')";

        $run = mysqli_query($con, $sql);

        if ($run) {
            echo "<script>alert('1st Step Complete and this is Second Step');</script>";
        } else {
            echo "Error: " . mysqli_error($con);
        }
    }
}
?>
