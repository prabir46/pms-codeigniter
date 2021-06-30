-- phpMyAdmin SQL Dump
-- version 3.5.2
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Mar 06, 2017 at 04:46 PM
-- Server version: 5.5.25a
-- PHP Version: 5.4.4

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `dmps`
--

-- --------------------------------------------------------

--
-- Table structure for table `appointments`
--

CREATE TABLE IF NOT EXISTS `appointments` (
  `id` int(9) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) DEFAULT NULL,
  `doctor_id` int(9) unsigned NOT NULL,
  `whom` tinyint(1) DEFAULT NULL,
  `patient_id` int(9) unsigned DEFAULT NULL,
  `contact_id` int(9) unsigned DEFAULT NULL,
  `other` varchar(255) DEFAULT NULL,
  `date` datetime DEFAULT NULL,
  `end_date` datetime DEFAULT NULL,
  `motive` text,
  `notes` text,
  `status` tinyint(1) NOT NULL DEFAULT '0',
  `is_view` tinyint(1) NOT NULL DEFAULT '0',
  `is_paid` tinyint(1) NOT NULL DEFAULT '0',
  `is_closed` tinyint(1) NOT NULL DEFAULT '0',
  `Color` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `assistant_payment`
--

CREATE TABLE IF NOT EXISTS `assistant_payment` (
  `id` int(9) unsigned NOT NULL AUTO_INCREMENT,
  `assistant_id` int(9) unsigned NOT NULL,
  `payment_mode_id` int(9) unsigned NOT NULL,
  `date` date DEFAULT NULL,
  `invoice` int(10) unsigned NOT NULL,
  `amount` decimal(10,2) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `blood_group_type`
--

CREATE TABLE IF NOT EXISTS `blood_group_type` (
  `id` int(9) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `canned_messages`
--

CREATE TABLE IF NOT EXISTS `canned_messages` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `deletable` tinyint(1) DEFAULT '1',
  `type` varchar(255) DEFAULT NULL,
  `name` varchar(50) DEFAULT NULL,
  `subject` varchar(100) DEFAULT NULL,
  `content` text,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `case_history`
--

CREATE TABLE IF NOT EXISTS `case_history` (
  `id` int(9) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  `doctor_id` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `case_history`
--

INSERT INTO `case_history` (`id`, `name`, `doctor_id`) VALUES
(1, 'pratul udainiya', 2);

-- --------------------------------------------------------

--
-- Table structure for table `chiff_complaint`
--

CREATE TABLE IF NOT EXISTS `chiff_complaint` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `doctor_id` int(10) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=7 ;

--
-- Dumping data for table `chiff_complaint`
--

INSERT INTO `chiff_complaint` (`id`, `name`, `doctor_id`) VALUES
(6, 'Chiff Complaint', 2);

-- --------------------------------------------------------

--
-- Table structure for table `contacts`
--

CREATE TABLE IF NOT EXISTS `contacts` (
  `id` int(9) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  `contact` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `address` text,
  `doctor_id` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `custom_fields`
--

CREATE TABLE IF NOT EXISTS `custom_fields` (
  `id` int(9) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  `field_type` int(10) DEFAULT NULL,
  `form` int(10) DEFAULT NULL,
  `values` text,
  `doctor_id` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `days`
--

CREATE TABLE IF NOT EXISTS `days` (
  `id` int(9) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=8 ;

--
-- Dumping data for table `days`
--

INSERT INTO `days` (`id`, `name`) VALUES
(1, 'Mon'),
(2, 'Tue'),
(3, 'Wed'),
(4, 'Thu'),
(5, 'Fri'),
(6, 'Sat'),
(7, 'Sun');

-- --------------------------------------------------------

--
-- Table structure for table `disease`
--

CREATE TABLE IF NOT EXISTS `disease` (
  `id` int(9) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  `description` text NOT NULL,
  `doctor_id` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `doctor_payment`
--

CREATE TABLE IF NOT EXISTS `doctor_payment` (
  `id` int(9) unsigned NOT NULL AUTO_INCREMENT,
  `doctor_id` int(9) unsigned NOT NULL,
  `payment_mode_id` int(9) unsigned NOT NULL,
  `date` date DEFAULT NULL,
  `invoice` int(10) unsigned NOT NULL,
  `amount` decimal(10,2) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `drug_allergy`
--

CREATE TABLE IF NOT EXISTS `drug_allergy` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `doctor_id` int(10) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `drug_allergy`
--

INSERT INTO `drug_allergy` (`id`, `name`, `doctor_id`) VALUES
(2, 'Drug Allergy', 2);

-- --------------------------------------------------------

--
-- Table structure for table `event_calendar`
--

CREATE TABLE IF NOT EXISTS `event_calendar` (
  `id` int(9) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) DEFAULT NULL,
  `starttime` datetime DEFAULT NULL,
  `endtime` datetime DEFAULT NULL,
  `schedule_category_id` int(9) unsigned NOT NULL,
  `doctor_id` int(9) unsigned NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `extra_oral_exm`
--

CREATE TABLE IF NOT EXISTS `extra_oral_exm` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `doctor_id` int(10) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `extra_oral_exm`
--

INSERT INTO `extra_oral_exm` (`id`, `name`, `doctor_id`) VALUES
(2, 'Extra Oral_Exm', 2);

-- --------------------------------------------------------

--
-- Table structure for table `fees`
--

CREATE TABLE IF NOT EXISTS `fees` (
  `id` int(9) unsigned NOT NULL AUTO_INCREMENT,
  `prescription_id` int(9) unsigned NOT NULL,
  `payment_mode_id` int(9) unsigned NOT NULL,
  `amount` text,
  `total` text,
  `dates` text NOT NULL,
  `invoice` int(10) DEFAULT NULL,
  `patient_id` int(9) unsigned NOT NULL,
  `treatment_Advised_id` text NOT NULL,
  `payment_for` varchar(255) DEFAULT NULL,
  `balance` text,
  `status` varchar(400) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `fees`
--

INSERT INTO `fees` (`id`, `prescription_id`, `payment_mode_id`, `amount`, `total`, `dates`, `invoice`, `patient_id`, `treatment_Advised_id`, `payment_for`, `balance`, `status`) VALUES
(1, 0, 1, '122', NULL, '["2017-03-06"]', 1, 3, '["Treatment Advised"]', '', '["100"]', ''),
(2, 0, 1, '122', NULL, '["2017-03-07","2017-03-07"]', 2, 3, '["Treatment Advised","Treatment Advised"]', '', '["100","100"]', ''),
(3, 0, 1, '3000', NULL, '["2017-03-07"]', 3, 3, '["Treatment Advised"]', '', '["1000"]', ''),
(4, 0, 1, '5000', NULL, '["2017-03-07","2017-03-06"]', 4, 3, '["Treatment Advised","Treatment Advised"]', '', '["2000","1000"]', 'Pandding Amount : 2000 INR');

-- --------------------------------------------------------

--
-- Table structure for table `fixed_schedule`
--

CREATE TABLE IF NOT EXISTS `fixed_schedule` (
  `id` int(9) unsigned NOT NULL AUTO_INCREMENT,
  `doctor_id` int(9) unsigned NOT NULL,
  `day` varchar(255) DEFAULT NULL,
  `timing_to` time DEFAULT NULL,
  `timing_from` time DEFAULT NULL,
  `work` text,
  `hospital` int(9) unsigned NOT NULL,
  `type` tinyint(2) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `hospitals`
--

CREATE TABLE IF NOT EXISTS `hospitals` (
  `id` int(9) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  `doctor_id` int(9) unsigned NOT NULL,
  `address` text,
  `phone` varchar(255) DEFAULT NULL,
  `hospital_type` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `hospital_type`
--

CREATE TABLE IF NOT EXISTS `hospital_type` (
  `id` int(9) unsigned NOT NULL AUTO_INCREMENT,
  `type` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `instruction`
--

CREATE TABLE IF NOT EXISTS `instruction` (
  `id` int(9) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  `type` tinyint(2) DEFAULT NULL,
  `doctor_id` int(9) unsigned NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=7 ;

--
-- Dumping data for table `instruction`
--

INSERT INTO `instruction` (`id`, `name`, `type`, `doctor_id`) VALUES
(4, 'Medicine Instruction', 1, 2),
(5, 'Medical Test Instruction', 2, 2),
(6, 'Treatment Instruction', 3, 2);

-- --------------------------------------------------------

--
-- Table structure for table `intra_oral_exm`
--

CREATE TABLE IF NOT EXISTS `intra_oral_exm` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `doctor_id` int(10) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `intra_oral_exm`
--

INSERT INTO `intra_oral_exm` (`id`, `name`, `doctor_id`) VALUES
(2, ' Intra Oral_Exm', 2);

-- --------------------------------------------------------

--
-- Table structure for table `jqcalendar`
--

CREATE TABLE IF NOT EXISTS `jqcalendar` (
  `Id` int(9) unsigned NOT NULL AUTO_INCREMENT,
  `Subject` varchar(255) DEFAULT NULL,
  `Location` varchar(255) DEFAULT NULL,
  `Description` varchar(255) DEFAULT NULL,
  `StartTime` datetime DEFAULT NULL,
  `EndTime` datetime DEFAULT NULL,
  `IsAllDayEvent` smallint(6) NOT NULL,
  `Color` varchar(255) DEFAULT NULL,
  `RecurringRule` varchar(500) DEFAULT NULL,
  `doctor_id` int(9) unsigned NOT NULL,
  `type_id` tinyint(4) NOT NULL DEFAULT '5',
  PRIMARY KEY (`Id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `lab_management`
--

CREATE TABLE IF NOT EXISTS `lab_management` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `patient_id` int(10) NOT NULL,
  `lab_select` varchar(200) NOT NULL,
  `lab_select_work` varchar(200) NOT NULL,
  `lab_payment` varchar(200) NOT NULL,
  `admin` int(10) NOT NULL,
  `status` varchar(20) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `lab_management`
--

INSERT INTO `lab_management` (`id`, `patient_id`, `lab_select`, `lab_select_work`, `lab_payment`, `admin`, `status`) VALUES
(1, 3, '1', '1', '', 2, 'PENDING'),
(2, 3, '1', '1', '222', 2, 'PENDING');

-- --------------------------------------------------------

--
-- Table structure for table `language`
--

CREATE TABLE IF NOT EXISTS `language` (
  `id` int(9) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(32) DEFAULT NULL,
  `flag` text,
  `file` text,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `manufacturing_company`
--

CREATE TABLE IF NOT EXISTS `manufacturing_company` (
  `id` int(9) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  `description` text,
  `doctor_id` int(9) unsigned DEFAULT NULL,
  `start_date` date DEFAULT NULL,
  `end_date` date DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `manufacturing_company`
--

INSERT INTO `manufacturing_company` (`id`, `name`, `description`, `doctor_id`, `start_date`, `end_date`) VALUES
(2, 'Manufacturing Company', 'Manufacturing Company des', 2, '2017-03-06', '2017-03-21');

-- --------------------------------------------------------

--
-- Table structure for table `medical_college`
--

CREATE TABLE IF NOT EXISTS `medical_college` (
  `id` int(9) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  `address` text,
  `phone` varchar(32) DEFAULT NULL,
  `doctor_id` int(9) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `medical_history`
--

CREATE TABLE IF NOT EXISTS `medical_history` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `doctor_id` int(10) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `medical_history`
--

INSERT INTO `medical_history` (`id`, `name`, `doctor_id`) VALUES
(2, 'Medical History', 2);

-- --------------------------------------------------------

--
-- Table structure for table `medical_test`
--

CREATE TABLE IF NOT EXISTS `medical_test` (
  `id` int(9) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  `doctor_id` int(9) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `medical_test`
--

INSERT INTO `medical_test` (`id`, `name`, `doctor_id`) VALUES
(2, 'Medical Test', 2);

-- --------------------------------------------------------

--
-- Table structure for table `medicine`
--

CREATE TABLE IF NOT EXISTS `medicine` (
  `id` int(9) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  `category_id` int(9) unsigned DEFAULT NULL,
  `company_id` int(9) unsigned DEFAULT NULL,
  `description` text NOT NULL,
  `price` decimal(10,2) DEFAULT NULL,
  `status` tinyint(1) DEFAULT NULL,
  `doctor_id` int(9) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `medicine`
--

INSERT INTO `medicine` (`id`, `name`, `category_id`, `company_id`, `description`, `price`, `status`, `doctor_id`) VALUES
(2, 'Medicine', 2, 2, 'Medicine_des', 1500.00, 1, 2);

-- --------------------------------------------------------

--
-- Table structure for table `medicine_category`
--

CREATE TABLE IF NOT EXISTS `medicine_category` (
  `id` int(9) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  `doctor_id` int(9) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `medicine_category`
--

INSERT INTO `medicine_category` (`id`, `name`, `doctor_id`) VALUES
(2, 'medicine_category', 2);

-- --------------------------------------------------------

--
-- Table structure for table `message`
--

CREATE TABLE IF NOT EXISTS `message` (
  `id` int(9) unsigned NOT NULL AUTO_INCREMENT,
  `message` text,
  `from_id` int(9) unsigned DEFAULT NULL,
  `to_id` int(9) unsigned NOT NULL,
  `is_view_from` int(9) NOT NULL DEFAULT '0',
  `is_view_to` int(9) NOT NULL DEFAULT '0',
  `date_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE IF NOT EXISTS `migrations` (
  `version` int(3) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`version`) VALUES
(1);

-- --------------------------------------------------------

--
-- Table structure for table `monthly_schedule`
--

CREATE TABLE IF NOT EXISTS `monthly_schedule` (
  `id` int(2) unsigned NOT NULL AUTO_INCREMENT,
  `date_id` int(2) NOT NULL,
  `doctor_id` int(11) unsigned NOT NULL,
  `timing_from` time DEFAULT NULL,
  `timing_to` time DEFAULT NULL,
  `work` text,
  `hospital` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `notes`
--

CREATE TABLE IF NOT EXISTS `notes` (
  `id` int(9) unsigned NOT NULL AUTO_INCREMENT,
  `patient_id` int(11) unsigned NOT NULL,
  `doctor_id` int(11) unsigned NOT NULL,
  `notes` text,
  `datetime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `notification_setting`
--

CREATE TABLE IF NOT EXISTS `notification_setting` (
  `id` int(9) unsigned NOT NULL AUTO_INCREMENT,
  `to_do_alert` int(10) DEFAULT NULL,
  `appointment_alert` int(10) DEFAULT NULL,
  `doctor_id` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `other_schedule`
--

CREATE TABLE IF NOT EXISTS `other_schedule` (
  `id` int(2) unsigned NOT NULL AUTO_INCREMENT,
  `doctor_id` int(11) unsigned NOT NULL,
  `dates` date DEFAULT NULL,
  `timing_from` time DEFAULT NULL,
  `timing_to` time DEFAULT NULL,
  `work` text,
  `hospital_id` int(9) unsigned NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `payment_modes`
--

CREATE TABLE IF NOT EXISTS `payment_modes` (
  `id` int(9) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  `doctor_id` int(11) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `payment_modes`
--

INSERT INTO `payment_modes` (`id`, `name`, `doctor_id`) VALUES
(1, 'cash', 2);

-- --------------------------------------------------------

--
-- Table structure for table `pimages`
--

CREATE TABLE IF NOT EXISTS `pimages` (
  `id` int(9) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) DEFAULT NULL,
  `file_name` varchar(255) DEFAULT NULL,
  `user_id` int(11) unsigned DEFAULT NULL,
  `doctor_id` int(11) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `prescription`
--

CREATE TABLE IF NOT EXISTS `prescription` (
  `id` int(9) unsigned NOT NULL AUTO_INCREMENT,
  `prescription_id` int(11) unsigned NOT NULL,
  `patient_id` int(11) unsigned NOT NULL,
  `medicines` text,
  `tests` text,
  `test_instructions` text,
  `disease` text,
  `oe_description` text,
  `date_time` datetime DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `remark` text,
  `medicine_instruction` text,
  `case_history` text,
  `chiff_Complaint_id` text NOT NULL,
  `chiff_Complaint_history` text NOT NULL,
  `medical_History_id` text NOT NULL,
  `medical_History_history` text NOT NULL,
  `drug_Allergy_id` text NOT NULL,
  `drug_Allergy_history` text NOT NULL,
  `extra_Oral_Exm_id` text NOT NULL,
  `extra_Oral_Exm_history` text NOT NULL,
  `intra_Oral_Exm_id` text NOT NULL,
  `intra_Oral_Exm_history` text NOT NULL,
  `treatment_Advised_id` text NOT NULL,
  `treatment_Advised_instruction` text NOT NULL,
  `case_history_id` text,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `prescription`
--

INSERT INTO `prescription` (`id`, `prescription_id`, `patient_id`, `medicines`, `tests`, `test_instructions`, `disease`, `oe_description`, `date_time`, `name`, `remark`, `medicine_instruction`, `case_history`, `chiff_Complaint_id`, `chiff_Complaint_history`, `medical_History_id`, `medical_History_history`, `drug_Allergy_id`, `drug_Allergy_history`, `extra_Oral_Exm_id`, `extra_Oral_Exm_history`, `intra_Oral_Exm_id`, `intra_Oral_Exm_history`, `treatment_Advised_id`, `treatment_Advised_instruction`, `case_history_id`) VALUES
(3, 1001, 3, '[]', '[]', '[""]', 'false', '', '2017-03-06 11:43:00', NULL, '<p>remark<br></p>', '["",""]', '', '["Chiff Complaint"]', 'chiff', '["Medical History"]', 'me_histry', '["Drug Allergy"]', 'd_allrgy', '["Extra Oral_Exm"]', 'extra_oral', '[" Intra Oral_Exm"]', 'intra_oral', '[""]', '["Treatment Instruction"]', 'false');

-- --------------------------------------------------------

--
-- Table structure for table `prescription_template`
--

CREATE TABLE IF NOT EXISTS `prescription_template` (
  `id` int(9) unsigned NOT NULL AUTO_INCREMENT,
  `header` text,
  `footer` text,
  `doctor_id` int(11) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `rel_days_doctors`
--

CREATE TABLE IF NOT EXISTS `rel_days_doctors` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `doctor_id` varchar(200) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `rel_form_custom_fields`
--

CREATE TABLE IF NOT EXISTS `rel_form_custom_fields` (
  `custom_field_id` int(9) unsigned NOT NULL AUTO_INCREMENT,
  `reply` text,
  `table_id` int(9) unsigned NOT NULL,
  `form` int(9) unsigned NOT NULL,
  PRIMARY KEY (`custom_field_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `reports`
--

CREATE TABLE IF NOT EXISTS `reports` (
  `id` int(9) unsigned NOT NULL AUTO_INCREMENT,
  `prescription_id` int(11) unsigned NOT NULL,
  `date_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `type_id` int(11) unsigned NOT NULL,
  `file` text,
  `remark` text,
  `from_id` int(11) unsigned NOT NULL,
  `to_id` int(11) unsigned NOT NULL,
  `is_view_to` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `settings`
--

CREATE TABLE IF NOT EXISTS `settings` (
  `id` int(9) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  `image` text,
  `address` text,
  `contact` varchar(32) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `doctor_id` int(11) DEFAULT NULL,
  `invoice` int(10) NOT NULL DEFAULT '1',
  `date_format` varchar(255) DEFAULT NULL,
  `timezone` varchar(255) DEFAULT NULL,
  `smtp_host` varchar(255) DEFAULT NULL,
  `smtp_user` varchar(255) DEFAULT NULL,
  `smtp_pass` varchar(255) DEFAULT NULL,
  `smtp_port` varchar(255) DEFAULT NULL,
  `session_hours` int(11) NOT NULL DEFAULT '2',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `settings`
--

INSERT INTO `settings` (`id`, `name`, `image`, `address`, `contact`, `email`, `doctor_id`, `invoice`, `date_format`, `timezone`, `smtp_host`, `smtp_user`, `smtp_pass`, `smtp_port`, `session_hours`) VALUES
(1, 'Doctor', NULL, NULL, NULL, 'doctor@doctor.com', NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, 2);

-- --------------------------------------------------------

--
-- Table structure for table `to_do_list`
--

CREATE TABLE IF NOT EXISTS `to_do_list` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) DEFAULT NULL,
  `description` text,
  `date` date DEFAULT NULL,
  `is_view` int(10) NOT NULL DEFAULT '0',
  `doctor_id` int(10) unsigned NOT NULL,
  `Color` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `treatment_advised`
--

CREATE TABLE IF NOT EXISTS `treatment_advised` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `doctor_id` int(10) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `treatment_advised`
--

INSERT INTO `treatment_advised` (`id`, `name`, `doctor_id`) VALUES
(2, 'Treatment Advised', 2);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  `blood_group_id` int(10) DEFAULT NULL,
  `image` text,
  `username` varchar(255) DEFAULT NULL,
  `password` varchar(40) DEFAULT NULL,
  `gender` varchar(40) DEFAULT NULL,
  `dob` int(11) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `contact` varchar(32) DEFAULT NULL,
  `address` text,
  `user_role` varchar(8) DEFAULT NULL,
  `doctor_id` int(10) DEFAULT NULL,
  `token` varchar(255) DEFAULT NULL,
  `appointment_alert` int(10) NOT NULL DEFAULT '1',
  `to_do_alert` int(10) unsigned NOT NULL DEFAULT '1',
  `schedule` tinyint(1) DEFAULT '0',
  `add_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `blood_group_id`, `image`, `username`, `password`, `gender`, `dob`, `email`, `contact`, `address`, `user_role`, `doctor_id`, `token`, `appointment_alert`, `to_do_alert`, `schedule`, `add_date`) VALUES
(1, 'pratul udainiya', NULL, NULL, 'admin', 'f865b53623b121fd34ee5426c792e5c33af8c227', NULL, NULL, 'synram.pratul@gmail.com', NULL, NULL, 'Admin', NULL, NULL, 1, 1, 0, '2017-03-03 11:42:14'),
(2, 'ram', NULL, NULL, 'ram', 'e17e5425a021224b63e91499ff8ac491c87567db', 'Male', 1992, 'synram.ram@gmail.com', '1234567890', 'sdsd', '1', NULL, NULL, 1, 1, 0, '2017-03-03 11:43:38'),
(3, 'pradeep', 0, NULL, '2Patient1', '7c4a8d09ca3762af61e59520943dc26494f8941b', 'Male', 1992, 'synram.pradeep@gmail.com', '1234567890', 'dfs', '2', 2, NULL, 1, 1, 0, '2017-03-03 13:30:12');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
