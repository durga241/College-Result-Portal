# College-Result-Portal
A web-based application developed using HTML, CSS, JavaScript, PHP, and MySQL, designed to manage student academic records efficiently. It features an admin dashboard for updating semester-wise grades, automatic SPI/CPI calculation, and a secure OTP-based result access system using PHPMailer for sending OTPs to student email addresses.

## 📦 Project Setup Steps

Follow these steps to set up and run the College Result Portal on your local machine:

1. **Install XAMPP**  
   - Download and install XAMPP from https://www.apachefriends.org/  
   - Start **Apache** and **MySQL** from the XAMPP control panel.

2. **Install Visual Studio Code (VS Code)**  
   - Download and install VS Code from https://code.visualstudio.com/  
   - Use it as your code editor to work on PHP, HTML, CSS, and JS files.

3. **Clone or Download the Project**  
   - Clone this repository using Git:  
     `git clone https://github.com/yourusername/college-result-portal.git`  
   - Or download it as a ZIP and extract to `htdocs` folder inside your XAMPP directory.

4. **Import the Database**  
   - Open `phpMyAdmin` at http://localhost/phpmyadmin  
   - Create a new database (e.g., `result_db`)  
   - Import the provided `database.sql` file from the `/db` folder

5. **Configure Database in the Project**  
   - Open `config.php` and update the following:
     ```php
     $host = "localhost";
     $username = "root";
     $password = "";
     $dbname = "result_db"; // or your chosen DB name
     ```

6. **Install PHPMailer for OTP Email Verification**  
   - Download PHPMailer from https://github.com/PHPMailer/PHPMailer  
   - Or install via Composer (if available):  
     `composer require phpmailer/phpmailer`
   - Include PHPMailer in the OTP email sending script.

7. **Configure Email Credentials in PHPMailer Script**  
   - In your email-sending PHP file, set your SMTP credentials:
     ```php
     $mail->Host = 'smtp.gmail.com';
     $mail->Username = 'your-email@gmail.com';
     $mail->Password = 'your-app-password'; // Use Gmail App Password
     $mail->Port = 587;
     $mail->SMTPSecure = 'tls';
     ```

8. **Run the Application**  
   - Open your browser and go to:  
     `http://localhost/college-result-portal/`  
   - Use the portal as admin or student to test result viewing and OTP features.

---
