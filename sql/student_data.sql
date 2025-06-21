SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

-- Database: `sms`

-- Table structure for table `student_data`
CREATE TABLE `student_data` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `u_name` TEXT COLLATE utf8_unicode_ci NOT NULL,
  `u_dob` TEXT COLLATE utf8_unicode_ci NOT NULL,
  `u_rollno` TEXT COLLATE utf8_unicode_ci NOT NULL,
  `u_branch` TEXT COLLATE utf8_unicode_ci NOT NULL,
  `u_email` TEXT COLLATE utf8_unicode_ci NOT NULL,
  `u_phone` TEXT COLLATE utf8_unicode_ci NOT NULL,
  `u_image` TEXT COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `unique_rollno` (`u_rollno`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;


--
-- Indexes for dumped tables
--

--
-- Indexes for table `student_data`
--
ALTER TABLE `student_data`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `student_data`
--
ALTER TABLE `student_data`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
