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

<html>
<head>
    <title>All Student Detail</title>
<link rel="stylesheet" href="../csss/allstudentdata.css" type="text/css">
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
                <li class="logout"><a href="admindash.php"><b>ADMIN DASHBOARD</b></a></li>
          </ul>
        </div>
      </nav>
      <div class="main-content-header">
        <h2>Student Record</h2>
        <form>
        <table>
            <tr>
                <th class="id_h">ID</th>
                <th class="name_h">Name</th>
                <th class="roll_h">Roll No</th>
                <th class="email_h">Email ID</th>
                <th class="phone_h">Phone Number</th>
                <th class="dob_h">Date of Birth</th>
                <th class="branch_h">Branch</th>
            </tr>

            <?php
include('../dbcon.php');
  $sql="SELECT * FROM `student_data`";
  $run=mysqli_query($con,$sql);
  if(mysqli_num_rows($run)>0)
{
     while($row=mysqli_fetch_assoc($run))
     {
        ?>
        <tr>
                            <td class="id_h"><?php echo $row['id'] . '<br>'; ?></td>
                            <td class="name_h"><?php echo $row['u_name'] . '<br>'; ?></td>
                            <td class="roll_h"><?php echo $row['u_rollno'] . '<br>'; ?></td>
                            <td class="email_h"><?php echo $row['u_email'] . '<br>'; ?></td>
                            <td class="phone_h"><?php echo $row['u_phone'] . '<br>'; ?></td>
                            <td class="dob_h"><?php echo $row['u_dob'] . '<br>'; ?></td>
                            <td class="branch_h"><?php echo $row['u_branch']; ?></td>
                        </tr>
                        <?php    
        }
   
}
else{
    echo "No Record Found";
}

?>

            </table>
        </form>
    </div>
</body>
</html>