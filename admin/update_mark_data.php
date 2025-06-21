<?php
if (isset($_POST['submit'])) {
    include('../dbcon.php');

    // Roll number (received from hidden input)
    $rollno = $_POST['rollno'];

    // 1st Semester Grades
    $grade1_MA1011 = $_POST['grade1_MA1011'];
    $grade1_CP1012 = $_POST['grade1_CP1012'];
    $grade1_CC1013 = $_POST['grade1_CC1013'];
    $grade1_ML1014 = $_POST['grade1_ML1014'];
    $grade1_DS1015 = $_POST['grade1_DS1015'];

    // 2nd Semester Grades
    $grade2_PH2011 = $_POST['grade2_PH2011'];
    $grade2_DS2012 = $_POST['grade2_DS2012'];
    $grade2_CP2013 = $_POST['grade2_CP2013'];
    $grade2_PHP2014 = $_POST['grade2_PHP2014'];
    $grade2_SQL2015 = $_POST['grade2_SQL2015'];
    $grade2_AI2016 = $_POST['grade2_AI2016'];

    // Grade Points and Course Credits
    $gradePoints = [
        'AA' => 10, 'AB' => 9, 'BB' => 8, 'BC' => 7, 'CC' => 6,
        'CD' => 5, 'DD' => 4, 'FF' => 0, 'DP' => 0, 'AU' => 0,
        'PP' => 0, 'NP' => 0, 'I' => 0
    ];
    $courseCredits = [
        'MA1011' => 4, 'CP1012' => 4, 'CC1013' => 3, 'ML1014' => 3,
        'DS1015' => 3, 'PH2011' => 4, 'DS2012' => 4, 'CP2013' => 3,
        'PHP2014' => 3, 'SQL2015' => 3, 'AI2016' => 3
    ];

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

    // Update query with calculated SPI1, SPI2, and CPI
    $sql = "UPDATE `user_mark` SET
        `grade1_MA1011` = '$grade1_MA1011',
        `grade1_CP1012` = '$grade1_CP1012',
        `grade1_CC1013` = '$grade1_CC1013',
        `grade1_ML1014` = '$grade1_ML1014',
        `grade1_DS1015` = '$grade1_DS1015',
        `grade2_PH2011` = '$grade2_PH2011',
        `grade2_DS2012` = '$grade2_DS2012',
        `grade2_CP2013` = '$grade2_CP2013',
        `grade2_PHP2014` = '$grade2_PHP2014',
        `grade2_SQL2015` = '$grade2_SQL2015',
        `grade2_AI2016` = '$grade2_AI2016',
        `spi1` = '$spi1',
        `spi2` = '$spi2',
        `cpi` = '$cpi'
        WHERE `u_rollno` = '$rollno'";

    $run = mysqli_query($con, $sql);

    if ($run) {
        echo "
        <script>
            alert('Data Updated Successfully');
            window.open('updatemark_form.php?sid=$rollno', '_self');
        </script>
        ";
    } else {
        echo "
        <script>
            alert('Error updating data');
            window.open('updatemark_form.php?sid=$rollno', '_self');
        </script>
        ";
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
