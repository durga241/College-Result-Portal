<?php
session_start();
if (!isset($_SESSION['uid'])) {
    header('location: ../login.php');
    exit();
}

include('../dbcon.php');

// Grade Code to Grade Points Mapping
$gradePoints = [
    'AA' => 10,
    'AB' => 9,
    'BB' => 8,
    'BC' => 7,
    'CC' => 6,
    'CD' => 5,
    'DD' => 4,
    'FF' => 0,
    'DP' => 0, // Dropped
    'AU' => 0, // Audit - Not considered for SPI calculation
    'PP' => 0, // Pass - Not considered for SPI calculation
    'NP' => 0, // Fail - Not considered for SPI calculation
    'I' => 0   // Incomplete - Not considered for SPI calculation
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
    $sql = "INSERT INTO `user_mark` (`u_rollno`, `grade1_MA1011`, `grade1_CP1012`, `grade1_CC1013`, `grade1_ML1014`, `grade1_DS1015`, `grade2_PH2011`, `grade2_DS2012`, `grade2_CP2013`, `grade2_PHP2014`, `grade2_SQL2015`, `grade2_AI2016`, `spi1`, `spi2`, `cpi`) 
            VALUES ('$rollno', '$grade1_MA1011', '$grade1_CP1012', '$grade1_CC1013', '$grade1_ML1014', '$grade1_DS1015', '$grade2_PH2011', '$grade2_DS2012', '$grade2_CP2013', '$grade2_PHP2014', '$grade2_SQL2015', '$grade2_AI2016', '$spi1', '$spi2', '$cpi')";

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
?>