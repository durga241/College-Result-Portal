<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>
    <link rel="stylesheet" href="csss/style.css" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Flamenco" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/3.7.0/animate.min.css">
</head>
<body>
    <header>
        <nav>
            <div class="row clearfix">
                <ul class="main-nav">
                    <li><a href="index.php">HOME</a></li>
                    <li><a href="admin/aboutus.php">ABOUT</a></li>
                    <li><a href="admin/contactus.php">CONTACT</a></li>
                    <li><a href="login.php">ADMIN LOGIN</a></li>
                </ul>
            </div>
        </nav>

        <div class="main-content-header">
            <form method="post" action="send_otp.php">
                <table class="table">
                    <h2 class="search"> Your Result is One Click Away! </h2>
                    <br><br>
                    <tr>
                        <th class="name1">Roll No</th>
                        <td class="name2"><input type="text" name="rollno" required class="box1"/></td>
                    </tr>
                    <tr>
                        <th class="dob1">Date of Birth</th>
                        <td class="dob2">
                            <input type="text" name="dob" required class="box2"
                                   pattern="\d{2}-\d{2}-\d{4}"
                                   placeholder="DD-MM-YYYY"
                                   title="Enter date in DD-MM-YYYY format"/>
                        </td>
                    </tr>
                    <tr>
                        <td align="center" colspan="2">
                            <input type="submit" name="submit" value="SEND OTP" class="submit"/>
                        </td>
                    </tr>
                </table>
            </form>
        </div>
    </header>
</body>
</html>