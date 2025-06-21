<?php
session_start();

if (!isset($_SESSION['uid'])) {
    header('location: ../login.php');
    exit();
}
?>

<?php
include('../dbcon.php');

$gradePoints = [
    'AA' => 10,
    'AB' => 9,
    'BB' => 8,
    'BC' => 7,
    'CC' => 6,
    'CD' => 5,
    'DD' => 4,
    'FF' => 0   // Incomplete - Not considered for SPI calculation
];

// Course Credits
$courseCredits = [
    'MA1011' => 4,
    'CP1012' => 4,
    'CC1013' => 3,
    'ML1014' => 3,
    'DS1015' => 3,
    'PH2011' => 4,
    'DS2012' => 4,
    'CP2013' => 3,
    'PHP2014' => 3,
    'SQL2015' => 3,
    'AI2016' => 3
];

if (isset($_POST['submit'])) {
    $rollno = mysqli_real_escape_string($con, $_POST['rollno']);

    // 1st Semester Grades
    $grade1_MA1011 = mysqli_real_escape_string($con, $_POST['grade1_MA1011']);
    $grade1_CP1012 = mysqli_real_escape_string($con, $_POST['grade1_CP1012']);
    $grade1_CC1013 = mysqli_real_escape_string($con, $_POST['grade1_CC1013']);
    $grade1_ML1014 = mysqli_real_escape_string($con, $_POST['grade1_ML1014']);
    $grade1_DS1015 = mysqli_real_escape_string($con, $_POST['grade1_DS1015']);

    // 2nd Semester Grades
    $grade2_PH2011 = mysqli_real_escape_string($con, $_POST['grade2_PH2011']);
    $grade2_DS2012 = mysqli_real_escape_string($con, $_POST['grade2_DS2012']);
    $grade2_CP2013 = mysqli_real_escape_string($con, $_POST['grade2_CP2013']);
    $grade2_PHP2014 = mysqli_real_escape_string($con, $_POST['grade2_PHP2014']);
    $grade2_SQL2015 = mysqli_real_escape_string($con, $_POST['grade2_SQL2015']);
    $grade2_AI2016 = mysqli_real_escape_string($con, $_POST['grade2_AI2016']);

    // Calculate SPI for 1st Semester
    $semester1Grades = [
        'MA1011' => $grade1_MA1011,
        'CP1012' => $grade1_CP1012,
        'CC1013' => $grade1_CC1013,
        'ML1014' => $grade1_ML1014,
        'DS1015' => $grade1_DS1015
    ];
    $spi1 = calculateSPI($semester1Grades, $gradePoints, $courseCredits);

    // Calculate SPI for 2nd Semester
    $semester2Grades = [
        'PH2011' => $grade2_PH2011,
        'DS2012' => $grade2_DS2012,
        'CP2013' => $grade2_CP2013,
        'PHP2014' => $grade2_PHP2014,
        'SQL2015' => $grade2_SQL2015,
        'AI2016' => $grade2_AI2016
    ];
    $spi2 = calculateSPI($semester2Grades, $gradePoints, $courseCredits);

    // Calculate CPI (Cumulative SPI)
    $totalCredits = array_sum($courseCredits);
    $cpi = (($spi1 * array_sum(array_intersect_key($courseCredits, $semester1Grades))) + 
            ($spi2 * array_sum(array_intersect_key($courseCredits, $semester2Grades)))) / $totalCredits;

    // Insert query with correct column names and calculated SPI/CPI
    $sql = "UPDATE user_mark SET 
    grade1_MA1011 = '$grade1_MA1011',
    grade1_CP1012 = '$grade1_CP1012',
    grade1_CC1013 = '$grade1_CC1013',
    grade1_ML1014 = '$grade1_ML1014',
    grade1_DS1015 = '$grade1_DS1015',
    grade2_PH2011 = '$grade2_PH2011',
    grade2_DS2012 = '$grade2_DS2012',
    grade2_CP2013 = '$grade2_CP2013',
    grade2_PHP2014 = '$grade2_PHP2014',
    grade2_SQL2015 = '$grade2_SQL2015',
    grade2_AI2016 = '$grade2_AI2016',
    spi1 = '$spi1',
    spi2 = '$spi2',
    cpi = '$cpi'
    WHERE u_rollno = '$rollno'";
    $run = mysqli_query($con, $sql);

    if ($run) {
        echo "<script>
            alert('Data Inserted Successfully');
            window.open('admindash.php?sid=$rollno', '_self');
        </script>";
    } else {
        echo "Error: " . mysqli_error($con);
    }
}

// Function to calculate SPI
function calculateSPI($semesterGrades, $gradePoints, $courseCredits) {
    $totalPoints = 0;
    $totalCreditsAttempted = 0;

    foreach ($semesterGrades as $course => $grade) {
        if (isset($gradePoints[$grade])) {
            $points = $gradePoints[$grade];
            $credits = $courseCredits[$course];
            
            if ($grade != 'AU' && $grade != 'PP' && $grade != 'NP' && $grade != 'I') {
                $totalPoints += $points * $credits;
                $totalCreditsAttempted += $credits;
            }
        }
    }

    if ($totalCreditsAttempted > 0) {
        return round($totalPoints / $totalCreditsAttempted, 2);
    } else {
        return 0; // Handle cases where no valid credits are attempted
    }
}

// Check if 'sid' is provided
if (!isset($_GET['sid'])) {
    echo "<script>alert('No student ID provided.'); window.location.href='admindash.php';</script>";
    exit();
}

$rollno = $_GET['sid'];

// Fetch student personal details
$sql = "SELECT * FROM student_data WHERE u_rollno='$rollno'";
$run = mysqli_query($con, $sql);
$row = mysqli_fetch_assoc($run);

// Handle if no student found
if (!$row) {
    echo "<script>alert('No student found with Roll Number: $rollno'); window.location.href='admindash.php';</script>";
    exit();
}

$dob = $row['u_dob'];

// Fetch student marks
$sql2 = "SELECT * FROM user_mark WHERE u_rollno='$rollno'";
$run2 = mysqli_query($con, $sql2);
$data = mysqli_fetch_assoc($run2);
?>

<html>
<head>
    <title>Update Mark Detail</title>
    <link rel="stylesheet" href="../csss/updatemark_form.css" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Flamenco" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/3.7.0/animate.min.css">
</head>
<body>
<header>
    <nav>
        <div class="row clearfix">
            <ul class="main-nav" animate slideInDown>
                <li><a href="admindash.php"><b>DASHBOARD</b></a></li>
                <li><a href="../index.php"><b>HOME</b></a></li>
                <li><a href="aboutus.php"><b>ABOUT</b></a></li>
                <li><a href="contactus.php"><b>CONTACT</b></a></li>
            </ul>
        </div>
    </nav>
    <div class="main-content-header">
        <form method="post" action="update_mark_data.php">
            <input type="hidden" name="rollno" value="<?php echo $rollno; ?>"/>

            <h3>1st Semester</h3>
            <table>
                <tr><th>Course</th><th>Grade</th></tr>
                <tr><td>Mathematics I</td><td><input type="text" name="grade1_MA1011" required value="<?php echo $data['grade1_MA1011'] ?? ''; ?>"/></td></tr>
                <tr><td>Computer Programming</td><td><input type="text" name="grade1_CP1012" required value="<?php echo $data['grade1_CP1012'] ?? ''; ?>"/></td></tr>
                <tr><td>Cloud Computing</td><td><input type="text" name="grade1_CC1013" required value="<?php echo $data['grade1_CC1013'] ?? ''; ?>"/></td></tr>
                <tr><td>Machine Learning</td><td><input type="text" name="grade1_ML1014" required value="<?php echo $data['grade1_ML1014'] ?? ''; ?>"/></td></tr>
                <tr><td>Data Science</td><td><input type="text" name="grade1_DS1015" required value="<?php echo $data['grade1_DS1015'] ?? ''; ?>"/></td></tr>
            </table>

            <h3>2nd Semester</h3>
            <table>
                <tr><th>Course</th><th>Grade</th></tr>
                <tr><td>Physics II</td><td><input type="text" name="grade2_PH2011" required value="<?php echo $data['grade2_PH2011'] ?? ''; ?>"/></td></tr>
                <tr><td>Data Structures</td><td><input type="text" name="grade2_DS2012" required value="<?php echo $data['grade2_DS2012'] ?? ''; ?>"/></td></tr>
                <tr><td>C Programming</td><td><input type="text" name="grade2_CP2013" required value="<?php echo $data['grade2_CP2013'] ?? ''; ?>"/></td></tr>
                <tr><td>PHP</td><td><input type="text" name="grade2_PHP2014" required value="<?php echo $data['grade2_PHP2014'] ?? ''; ?>"/></td></tr>
                <tr><td>SQL</td><td><input type="text" name="grade2_SQL2015" required value="<?php echo $data['grade2_SQL2015'] ?? ''; ?>"/></td></tr>
                <tr><td>AI</td><td><input type="text" name="grade2_AI2016" required value="<?php echo $data['grade2_AI2016'] ?? ''; ?>"/></td></tr>
            </table>
            
            

            <input type="submit" name="submit" value="Submit">
        </form>
    </div>
</header>
</body>
</html>