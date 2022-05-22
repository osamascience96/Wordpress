-- --------------------------------------------------------

--
-- Database: `klinikal`
--

-- --------------------------------------------------------

SET sql_mode = '';
-- --------------------------------------------------------

--
-- Table structure for table `kk_appointments`
--

DROP TABLE IF EXISTS `kk_appointment`;
CREATE TABLE IF NOT EXISTS `kk_appointments` (
  `id` int(100) NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `mobile` varchar(255) NOT NULL,
  `date` date NOT NULL,
  `time` varchar(255) NOT NULL,
  `message` varchar(255) DEFAULT NULL,
  `slot` varchar(5) NOT NULL,
  `department_id` int(10) NOT NULL,
  `status` tinyint(1) NOT NULL,
  `notes` text NOT NULL,
  `user_id` int(100) DEFAULT NULL,
  `doctor_id` int(100) DEFAULT NULL,
  `invoice_id` int(100) DEFAULT NULL,
  `patient_id` int(11) NOT NULL,
  `note` text,
  `doctor_note` text,
  `date_of_joining` datetime NOT NULL,
  `appointment_id` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `kk_appointment_notes`
--

DROP TABLE IF EXISTS `kk_appointment_notes`;
CREATE TABLE IF NOT EXISTS `kk_appointment_notes` (
  `id` int(11) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `email` varchar(255) NOT NULL,
  `notes` text NOT NULL,
  `appointment_id` int(11) NOT NULL,
  `doctor_id` int(11) NOT NULL,
  `patient_id` int(11) DEFAULT NULL,
  `user_id` int(11) NOT NULL,
  `date_of_joining` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `kk_attached_files`
--

DROP TABLE IF EXISTS `kk_attached_files`;
CREATE TABLE IF NOT EXISTS `kk_attached_files` (
  `id` int(11) NOT NULL,
  `file` varchar(255) NOT NULL,
  `type` varchar(255) NOT NULL,
  `type_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `date_of_joining` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `kk_birth_records`
--

DROP TABLE IF EXISTS `kk_birth_records`;
CREATE TABLE IF NOT EXISTS `kk_birth_records` (
  `id` int(11) NOT NULL,
  `child` varchar(255) NOT NULL,
  `date` date NOT NULL,
  `time` time NOT NULL,
  `gender` varchar(30) NOT NULL,
  `weight` varchar(50) NOT NULL,
  `height` varchar(5) NOT NULL,
  `mother_name` varchar(255) NOT NULL,
  `mother_email` varchar(255) NOT NULL,
  `mother_mobile` varchar(100) NOT NULL,
  `mother_id` int(11) NOT NULL,
  `father_name` varchar(255) NOT NULL,
  `father_email` varchar(255) NOT NULL,
  `father_mobile` varchar(100) NOT NULL,
  `father_id` int(11) NOT NULL,
  `remark` text NOT NULL,
  `doctor_name` varchar(255) NOT NULL,
  `doctor_id` int(11) DEFAULT NULL,
  `user_id` int(11) NOT NULL,
  `date_of_joining` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `kk_blog`
--

DROP TABLE IF EXISTS `kk_blog`;
CREATE TABLE IF NOT EXISTS `kk_blog` (
  `id` int(100) NOT NULL,
  `title` text NOT NULL,
  `blog_url` varchar(255) NOT NULL,
  `short_post` varchar(255) NOT NULL,
  `long_post` text NOT NULL,
  `picture` varchar(255) NOT NULL,
  `user_id` int(100) NOT NULL,
  `author` varchar(255) DEFAULT NULL,
  `hits` int(11) NOT NULL DEFAULT '1',
  `status` tinyint(1) NOT NULL,
  `date_of_joining` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `kk_blog_to_category`
--

DROP TABLE IF EXISTS `kk_blog_to_category`;
CREATE TABLE IF NOT EXISTS `kk_blog_to_category` (
  `blog_id` int(11) NOT NULL,
  `category_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `kk_category`
--

DROP TABLE IF EXISTS `kk_category`;
CREATE TABLE IF NOT EXISTS `kk_category` (
  `id` int(100) NOT NULL,
  `name` varchar(100) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `count` int(10) NOT NULL,
  `icon` varchar(50) NOT NULL,
  `parent` int(10) NOT NULL,
  `meta_tag` varchar(255) NOT NULL,
  `meta_description` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `kk_comment`
--

DROP TABLE IF EXISTS `kk_comment`;
CREATE TABLE IF NOT EXISTS `kk_comment` (
  `id` int(51) NOT NULL,
  `author` varchar(255) NOT NULL,
  `email` varchar(100) NOT NULL,
  `content` text NOT NULL,
  `url` varchar(255) CHARACTER SET latin1 NOT NULL,
  `blog_id` int(11) NOT NULL,
  `parent` int(51) NOT NULL,
  `thumbs_up` int(11) NOT NULL,
  `thumbs_down` int(11) NOT NULL,
  `status` tinyint(4) DEFAULT '0',
  `user_id` int(11) NOT NULL,
  `author_ip` varchar(100) NOT NULL,
  `agent` varchar(255) NOT NULL,
  `level` int(5) NOT NULL,
  `date_of_joining` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `kk_death_records`
--

DROP TABLE IF EXISTS `kk_death_records`;
CREATE TABLE IF NOT EXISTS `kk_death_records` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `date` date NOT NULL,
  `time` time NOT NULL,
  `gender` varchar(30) NOT NULL,
  `guardian_name` varchar(255) NOT NULL,
  `guardian_email` varchar(255) NOT NULL,
  `guardian_mobile` varchar(100) NOT NULL,
  `patient_id` int(11) NOT NULL,
  `remark` text NOT NULL,
  `doctor_name` varchar(255) NOT NULL,
  `doctor_id` int(11) DEFAULT NULL,
  `user_id` int(11) NOT NULL,
  `date_of_joining` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `kk_departments`
--

DROP TABLE IF EXISTS `kk_departments`;
CREATE TABLE IF NOT EXISTS `kk_departments` (
  `id` int(5) NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `icon` varchar(255) NOT NULL,
  `status` tinyint(1) DEFAULT NULL,
  `date_of_joining` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `kk_doctors`
--

DROP TABLE IF EXISTS `kk_doctors`;
CREATE TABLE IF NOT EXISTS `kk_doctors` (
  `id` int(11) NOT NULL,
  `firstname` varchar(100) NOT NULL,
  `lastname` varchar(100) NOT NULL,
  `email` varchar(255) NOT NULL,
  `mobile` varchar(255) NOT NULL,
  `picture` varchar(255) NOT NULL,
  `about` text NOT NULL,
  `department_id` int(5) NOT NULL,
  `social` text NOT NULL,
  `web_status` tinyint(1) DEFAULT NULL,
  `status` tinyint(1) DEFAULT NULL,
  `priority` int(5) DEFAULT NULL,
  `time` text NOT NULL,
  `weekly` text NOT NULL,
  `national` text NOT NULL,
  `appointment_status` tinyint(1) DEFAULT NULL,
  `user_id` int(11) NOT NULL,
  `date_of_joining` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `kk_email_logs`
--

DROP TABLE IF EXISTS `kk_email_logs`;
CREATE TABLE IF NOT EXISTS `kk_email_logs` (
  `id` int(11) NOT NULL,
  `email_to` varchar(100) NOT NULL,
  `email_bcc` varchar(100) NOT NULL,
  `subject` varchar(255) NOT NULL,
  `message` text NOT NULL,
  `type` varchar(50) NOT NULL,
  `type_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `date_of_joining` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `kk_email_template`
--

DROP TABLE IF EXISTS `kk_email_template`;
CREATE TABLE IF NOT EXISTS `kk_email_template` (
  `id` int(11) NOT NULL,
  `template` varchar(100) NOT NULL,
  `name` varchar(100) NOT NULL,
  `subject` varchar(255) NOT NULL,
  `message` text NOT NULL,
  `status` tinyint(1) DEFAULT NULL,
  `last_updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `kk_email_template`
--

INSERT INTO `kk_email_template` (`id`, `template`, `name`, `subject`, `message`, `status`, `last_updated`) VALUES
(1, 'newpatient', 'New Patient (Patient created from admin panel)', 'Klinikal : New Patient Account Created', '<p>Dear {firstname},</p><p>Welcome to {clinic_name}. Thanks for creating account with us. We\'re glad you\'re here. </p><p>Name: {name}<br></p><p>Email Address: {email}</p><p>Mobile Number: {mobile}</p><p>Please create password for login. {password_link}</p><p>Thanks <br></p><p>{clinic_name}</p><p><br></p><p>*DO NOT REPLY TO THIS E-MAIL*<br></p><p>This is an automated e-mail message sent from our support system. Do not reply to this e-mail as we will not receive your reply!</p>', 1, '2020-01-01 01:31:40'),
(2, 'newwebuser', 'New Website User', 'Klinikal : New Patient Account Created', '<p>Dear {firstname},</p><p>Welcome to {clinic_name}. Thanks for creating account with us. We\'re glad you\'re here. </p><p>Name: {name}<br></p><p>Email Address: {email}</p><p>Mobile Number: {mobile}</p><p>Please confirm your email address by clicking on the link below</p><p>{verify_link}</p><p>If you didn\'t create account, then contact our support team at {contact_link}<br></p><p><br></p><p>Thanks <br></p><p>{clinic_name}</p><p><br></p><p>*DO NOT REPLY TO THIS E-MAIL*<br></p><p>This is an automated e-mail message sent from our support system. Do not reply to this e-mail as we will not receive your reply!</p>', 1, '2020-01-03 00:19:25'),
(3, 'newinvoice', 'New Invoice', 'Klinikal: New Invoice Generated', '<div data-mce-style=\"font-size: 11pt; font-weight: bold;\"><div data-mce-style=\"padding: 5px; font-size: 11pt; font-weight: bold;\" style=\"padding: 5px;\"><font color=\"#222222\" face=\"verdana, droid sans, lucida sans, sans-serif\"><span style=\"font-size: 13.3333px; font-family: Verdana;\">Hello {name},</span></font></div><div data-mce-style=\"padding: 5px; font-size: 11pt; font-weight: bold;\" style=\"padding: 5px;\"><font color=\"#222222\" face=\"verdana, droid sans, lucida sans, sans-serif\"><span style=\"font-size: 13.3333px; font-family: Verdana;\"><br></span></font></div></div><div data-mce-style=\"padding: 5px; font-size: 11pt; font-weight: bold;\" style=\"color: rgb(34, 34, 34); font-family: verdana, \" droid=\"\" sans\",=\"\" \"lucida=\"\" sans-serif;=\"\" padding:=\"\" 5px;=\"\" font-size:=\"\" 11pt;=\"\" font-weight:=\"\" bold;\"=\"\"><span style=\"font-size: 13.3333px; font-weight: 400; font-family: Verdana;\">This email serves as your official invoice from </span><span style=\"font-family: Verdana; font-size: 13.3333px; font-weight: bolder;\">{clinic_name}</span></div><div data-mce-style=\"padding: 5px; font-size: 11pt; font-weight: bold;\" style=\"color: rgb(34, 34, 34); font-family: verdana, \" droid=\"\" sans\",=\"\" \"lucida=\"\" sans-serif;=\"\" padding:=\"\" 5px;=\"\" font-size:=\"\" 11pt;=\"\" font-weight:=\"\" bold;\"=\"\"><strong style=\"font-size: 13.3333px;\"><span style=\"font-family: Verdana;\"><br></span></strong></div><div data-mce-style=\"padding: 10px 5px;\" style=\"color: rgb(34, 34, 34); font-family: verdana, \" droid=\"\" sans\",=\"\" \"lucida=\"\" sans-serif;=\"\" font-size:=\"\" 13.3333px;=\"\" padding:=\"\" 10px=\"\" 5px;\"=\"\"><span style=\"font-family: Verdana;\">Invoice ID: {inv_id}</span><br><span style=\"font-family: Verdana;\">Invoice Amount: {amount}</span><br><span style=\"font-family: Verdana;\">Paid Amount: {paid}</span><br><span style=\"font-family: Verdana;\">Due Amount: {due}</span><br><span style=\"font-family: Verdana;\">Due Date: {due_date}</span></div><div data-mce-style=\"padding: 10px 5px;\" style=\"color: rgb(34, 34, 34); font-family: verdana, \" droid=\"\" sans\",=\"\" \"lucida=\"\" sans-serif;=\"\" font-size:=\"\" 13.3333px;=\"\" padding:=\"\" 10px=\"\" 5px;\"=\"\"><span style=\"font-family: Verdana;\">Invoice URL: {inv_url}</span><span style=\"font-family: Verdana;\"><br></span></div><div data-mce-style=\"padding: 10px 5px;\" style=\"color: rgb(34, 34, 34); font-family: verdana, \" droid=\"\" sans\",=\"\" \"lucida=\"\" sans-serif;=\"\" font-size:=\"\" 13.3333px;=\"\" padding:=\"\" 10px=\"\" 5px;\"=\"\"><span style=\"font-family: Verdana;\"><br></span></div><div data-mce-style=\"padding: 5px;\" style=\"color: rgb(34, 34, 34); font-family: verdana, \" droid=\"\" sans\",=\"\" \"lucida=\"\" sans-serif;=\"\" font-size:=\"\" 13.3333px;=\"\" padding:=\"\" 5px;\"=\"\"><span data-mce-style=\"font-size: 13.3333330154419px; line-height: 21.3333320617676px;\" style=\"font-size: 13.3333px; line-height: 21.3333px; font-family: Verdana;\">Invoice PDF has been attached to this mail. If you have any questions or need assistance, please don\'t hesitate to contact us.</span></div><div data-mce-style=\"padding: 5px;\" style=\"color: rgb(34, 34, 34); font-family: verdana, \" droid=\"\" sans\",=\"\" \"lucida=\"\" sans-serif;=\"\" font-size:=\"\" 13.3333px;=\"\" padding:=\"\" 5px;\"=\"\"><br></div><div data-mce-style=\"padding: 0px 5px;\" style=\"color: rgb(34, 34, 34); font-family: verdana, \" droid=\"\" sans\",=\"\" \"lucida=\"\" sans-serif;=\"\" font-size:=\"\" 13.3333px;=\"\" padding:=\"\" 0px=\"\" 5px;\"=\"\"><span style=\"font-family: Verdana;\">Best Regards, </span><br><span style=\"font-family: Verdana; font-size: 13.3333px;\"><b>{clinic_name}</b></span></div><div data-mce-style=\"padding: 0px 5px;\" style=\"color: rgb(34, 34, 34); font-family: verdana, \" droid=\"\" sans\",=\"\" \"lucida=\"\" sans-serif;=\"\" font-size:=\"\" 13.3333px;=\"\" padding:=\"\" 0px=\"\" 5px;\"=\"\"><br></div><div data-mce-style=\"padding: 0px 5px;\" style=\"color: rgb(34, 34, 34); font-family: verdana, \" droid=\"\" sans\",=\"\" \"lucida=\"\" sans-serif;=\"\" font-size:=\"\" 13.3333px;=\"\" padding:=\"\" 0px=\"\" 5px;\"=\"\"><span style=\"font-family: Poppins, Poppins, sans-serif; font-size: 14px; color: red;\"><span style=\"font-weight: bolder; font-family: Verdana;\">*DO NOT REPLY TO THIS E-MAIL*</span></span><br style=\"color: rgb(0, 0, 0); font-family: Poppins, Poppins, sans-serif; font-size: 14px;\"><span style=\"color: rgb(0, 0, 0); font-family: Verdana; font-size: 14px;\">This is an automated e-mail message sent from our support system. Do not reply to this e-mail as we will not receive your reply!</span><br></div>', 1, '2020-01-03 00:19:32'),
(4, 'newappointment', 'New Appointment', 'Klinikal: Appointment Confirmation', '<p><p></p><div data-mce-style=\"font-size: 11pt; font-weight: bold;\"><h6 style=\"padding: 5px;\"><font color=\"#222222\" face=\"verdana, droid sans, lucida sans, sans-serif\"><span style=\"font-size: 13.3333px; font-family: Verdana;\">Hello {name},</span></font></h6></div><div data-mce-style=\"padding: 5px; font-size: 11pt; font-weight: bold;\" style=\"color: rgb(34, 34, 34); font-family: verdana, \" droid=\"\" sans\",=\"\" \"lucida=\"\" sans-serif;=\"\" padding:=\"\" 5px;=\"\" font-size:=\"\" 11pt;=\"\" font-weight:=\"\" bold;\"=\"\"><span style=\"font-size: 13.3333px; font-weight: 400; font-family: Verdana;\">This email serves as your official confirmation for appointment from </span><span style=\"font-family: Verdana; font-size: 13.3333px; font-weight: bolder;\">{clinic_name}</span></div><div data-mce-style=\"padding: 5px; font-size: 11pt; font-weight: bold;\" style=\"color: rgb(34, 34, 34); font-family: verdana, \" droid=\"\" sans\",=\"\" \"lucida=\"\" sans-serif;=\"\" padding:=\"\" 5px;=\"\" font-size:=\"\" 11pt;=\"\" font-weight:=\"\" bold;\"=\"\"><strong style=\"font-size: 13.3333px;\"><span style=\"font-family: Verdana;\"><br></span></strong></div><div data-mce-style=\"padding: 10px 5px;\" style=\"\" droid=\"\" sans\",=\"\" \"lucida=\"\" sans-serif;=\"\" font-size:=\"\" 13.3333px;=\"\" padding:=\"\" 10px=\"\" 5px;\"=\"\"><font color=\"#222222\" face=\"Verdana\">Appointment ID: {appointment_id}</font><br><font color=\"#222222\" face=\"Verdana\">Name: {name}</font><br><font color=\"#222222\" face=\"Verdana\">Email Address: {email}</font><br><font color=\"#222222\" face=\"Verdana\">Mobile Number: {mobile}</font><br><font color=\"#222222\" face=\"Verdana\">Doctor: {doctor}</font></div><div data-mce-style=\"padding: 10px 5px;\" style=\"\" droid=\"\" sans\",=\"\" \"lucida=\"\" sans-serif;=\"\" font-size:=\"\" 13.3333px;=\"\" padding:=\"\" 10px=\"\" 5px;\"=\"\"><font color=\"#222222\" face=\"Verdana\">Date: {date} at {time} o\'clock</font></div><div data-mce-style=\"padding: 10px 5px;\" style=\"\" droid=\"\" sans\",=\"\" \"lucida=\"\" sans-serif;=\"\" font-size:=\"\" 13.3333px;=\"\" padding:=\"\" 10px=\"\" 5px;\"=\"\"><span style=\"color: rgb(34, 34, 34); font-family: Verdana;\">Reason/Problem: {reason}</span></div></p><p><div data-mce-style=\"padding: 5px;\" style=\"\" droid=\"\" sans\",=\"\" \"lucida=\"\" sans-serif;=\"\" font-size:=\"\" 13.3333px;=\"\" padding:=\"\" 5px;\"=\"\"><font color=\"#222222\" face=\"Verdana\"><span style=\"font-size: 13.3333px;\">When we will update your appointment. you can also track your appointment status and details on our website. Track your appointment {link}</span></font><br></div><div data-mce-style=\"padding: 0px 5px;\" style=\"color: rgb(34, 34, 34); font-family: verdana, \" droid=\"\" sans\",=\"\" \"lucida=\"\" sans-serif;=\"\" font-size:=\"\" 13.3333px;=\"\" padding:=\"\" 0px=\"\" 5px;\"=\"\"><span style=\"font-family: Verdana;\"><br></span></div><div data-mce-style=\"padding: 0px 5px;\" style=\"color: rgb(34, 34, 34); font-family: verdana, \" droid=\"\" sans\",=\"\" \"lucida=\"\" sans-serif;=\"\" font-size:=\"\" 13.3333px;=\"\" padding:=\"\" 0px=\"\" 5px;\"=\"\"><span style=\"font-family: Verdana;\">Best Regards, </span><br><span style=\"font-family: Verdana; font-size: 13.3333px;\"><b>{clinic_name}</b></span></div><div data-mce-style=\"padding: 0px 5px;\" style=\"color: rgb(34, 34, 34); font-family: verdana, \" droid=\"\" sans\",=\"\" \"lucida=\"\" sans-serif;=\"\" font-size:=\"\" 13.3333px;=\"\" padding:=\"\" 0px=\"\" 5px;\"=\"\"><br></div><div data-mce-style=\"padding: 0px 5px;\" style=\"color: rgb(34, 34, 34); font-family: verdana, \" droid=\"\" sans\",=\"\" \"lucida=\"\" sans-serif;=\"\" font-size:=\"\" 13.3333px;=\"\" padding:=\"\" 0px=\"\" 5px;\"=\"\"><span style=\"font-family: Poppins, Poppins, sans-serif; font-size: 14px; color: red;\"><span style=\"font-weight: bolder; font-family: Verdana;\">*DO NOT REPLY TO THIS E-MAIL*</span></span><br style=\"color: rgb(0, 0, 0); font-family: Poppins, Poppins, sans-serif; font-size: 14px;\"><span style=\"color: rgb(0, 0, 0); font-family: Verdana; font-size: 14px;\">This is an automated e-mail message sent from our support system. Do not reply to this e-mail as we will not receive your reply!</span><br></div><p></p></p>', 1, '2020-01-03 00:18:55'),
(5, 'newuser', 'New Admin User', 'Klinikal: your account has been created.', '<p style=\"\"><span style=\"font-family: Verdana;\">Hello {name},</span></p><p style=\"\"><span style=\"font-family: Verdana;\">Welcome to {clinic_name}.</span></p><p style=\"\"><span style=\"font-family: Verdana;\">Your admin credentials has been created. Now you can login to admin portal. See below for credentials... </span></p><p style=\"\"><span style=\"font-family: Verdana;\">---------------------------------------------------------------------------------------</span><br></p><p style=\"\"><span style=\"font-family: Verdana;\">Login URL: {login_url} </span><br><span style=\"font-family: Verdana;\">Username: {username}</span><br><span style=\"font-family: Verdana;\">Email Address: {email}</span><br></p><p style=\"\"><span style=\"font-family: Verdana;\">----------------------------------------------------------------------------------------</span></p><p style=\"\"><span style=\"font-family: Verdana;\">We very much appreciate you for choosing us.</span></p><p style=\"\"><span style=\"font-family: Verdana;\">{clinic_name} Team</span></p><p style=\"\"><span style=\"font-family: Verdana;\">*DO NOT REPLY TO THIS E-MAIL*</span><br style=\"\"><span style=\"font-family: Verdana;\">This is an automated e-mail message sent from our support system. Do not reply to this e-mail as we will not receive your reply!</span><br></p>', 1, '2020-01-03 00:18:42'),
(6, 'forgotpassword', 'Forgot password', 'Klinikal: forgot Password', '<div data-mce-style=\"padding: 5px; font-size: 11pt; font-weight: bold;\" style=\"\" droid=\"\" sans\",=\"\" \"lucida=\"\" sans-serif;=\"\" padding:=\"\" 5px;=\"\" font-size:=\"\" 11pt;=\"\" font-weight:=\"\" bold;\"=\"\">Hello {firstname}</div><div data-mce-style=\"padding: 5px; font-size: 11pt; font-weight: bold;\" style=\"\" droid=\"\" sans\",=\"\" \"lucida=\"\" sans-serif;=\"\" padding:=\"\" 5px;=\"\" font-size:=\"\" 11pt;=\"\" font-weight:=\"\" bold;\"=\"\"><br></div><div data-mce-style=\"padding: 5px; font-size: 11pt; font-weight: bold;\" style=\"\" droid=\"\" sans\",=\"\" \"lucida=\"\" sans-serif;=\"\" padding:=\"\" 5px;=\"\" font-size:=\"\" 11pt;=\"\" font-weight:=\"\" bold;\"=\"\">This is to confirm that we have received a Forgot Password request for your Account Username - {email}<br></div><div data-mce-style=\"padding: 5px;\" style=\"\" droid=\"\" sans\",=\"\" \"lucida=\"\" sans-serif;=\"\" font-size:=\"\" 13.3333px;=\"\" padding:=\"\" 5px;\"=\"\">Click this link to reset your password- <br><span style=\"padding: 3px;\">{reset_link}</span></div><div data-mce-style=\"padding: 5px;\" style=\"\" droid=\"\" sans\",=\"\" \"lucida=\"\" sans-serif;=\"\" font-size:=\"\" 13.3333px;=\"\" padding:=\"\" 5px;\"=\"\"><span style=\"padding: 3px;\"><br></span></div><div data-mce-style=\"padding: 5px;\" style=\"\" droid=\"\" sans\",=\"\" \"lucida=\"\" sans-serif;=\"\" font-size:=\"\" 13.3333px;=\"\" padding:=\"\" 5px;\"=\"\">Please note: until your password has been changed, your current password will remain valid. If you have not generated this request. Please contact us as soon as possible.</div><div data-mce-style=\"padding: 5px;\" style=\"\" droid=\"\" sans\",=\"\" \"lucida=\"\" sans-serif;=\"\" font-size:=\"\" 13.3333px;=\"\" padding:=\"\" 5px;\"=\"\"><br></div><div data-mce-style=\"padding: 0px 5px;\" style=\"\" droid=\"\" sans\",=\"\" \"lucida=\"\" sans-serif;=\"\" font-size:=\"\" 13.3333px;=\"\" padding:=\"\" 0px=\"\" 5px;\"=\"\">Regards,<br>{clinic_name} Team</div><div data-mce-style=\"padding: 0px 5px;\" style=\"\" droid=\"\" sans\",=\"\" \"lucida=\"\" sans-serif;=\"\" font-size:=\"\" 13.3333px;=\"\" padding:=\"\" 0px=\"\" 5px;\"=\"\"><br></div><div data-mce-style=\"padding: 0px 5px;\" style=\"\" droid=\"\" sans\",=\"\" \"lucida=\"\" sans-serif;=\"\" font-size:=\"\" 13.3333px;=\"\" padding:=\"\" 0px=\"\" 5px;\"=\"\">*DO NOT REPLY TO THIS E-MAIL*<br style=\"\">This is an automated e-mail message sent from our support system. Do not reply to this e-mail as we will not receive your reply!<br></div>', 1, '2019-12-26 05:49:26'),
(7, 'paymentconfirmation', 'Payment Confirmation', 'Invoice Payment Confirmation', '<div data-mce-style=\"padding: 5px; font-size: 11pt;\" style=\"padding: 5px;\"><span style=\"font-family: Verdana;\">Hello {name},</span></div><div data-mce-style=\"padding: 5px; font-size: 11pt;\" style=\"padding: 5px;\"><br></div><div data-mce-style=\"padding: 5px; font-size: 11pt;\" style=\"\" droid=\"\" sans\",=\"\" \"lucida=\"\" sans-serif;=\"\" padding:=\"\" 5px;=\"\" font-size:=\"\" 11pt;=\"\" font-weight:=\"\" bold;\"=\"\"><span style=\"font-family: Verdana;\">This is a payment receipt for Invoice {invoice_id}</span><br></div><div data-mce-style=\"padding: 5px;\" style=\"\" droid=\"\" sans\",=\"\" \"lucida=\"\" sans-serif;=\"\" font-size:=\"\" 13.3333px;=\"\" padding:=\"\" 5px;\"=\"\"><span style=\"font-family: Verdana;\">Login to your client Portal to view this invoice.</span></div><div data-mce-style=\"padding: 5px;\" style=\"\" droid=\"\" sans\",=\"\" \"lucida=\"\" sans-serif;=\"\" font-size:=\"\" 13.3333px;=\"\" padding:=\"\" 5px;\"=\"\"><span style=\"font-family: Verdana;\"><br></span></div><span style=\"font-family: Verdana;\">Transaction Id: {txn_id}</span><div data-mce-style=\"padding: 10px 5px;\" style=\"\" droid=\"\" sans\",=\"\" \"lucida=\"\" sans-serif;=\"\" font-size:=\"\" 13.3333px;=\"\" padding:=\"\" 10px=\"\" 5px;\"=\"\"><span style=\"font-family: Verdana;\">Paid Amount: {paid_amount}</span><br style=\"\"><span style=\"font-family: Verdana;\">Due Amount: {due_amount}</span><br><span style=\"font-family: Verdana;\">Paid Date: {paid_date}</span></div><div data-mce-style=\"padding: 5px;\" style=\"\" droid=\"\" sans\",=\"\" \"lucida=\"\" sans-serif;=\"\" font-size:=\"\" 13.3333px;=\"\" padding:=\"\" 5px;\"=\"\"><span data-mce-style=\"font-size: 13.3333330154419px; line-height: 21.3333320617676px;\" style=\"line-height: 21.3333px; font-family: Verdana;\"><br></span></div><div data-mce-style=\"padding: 5px;\" style=\"\" droid=\"\" sans\",=\"\" \"lucida=\"\" sans-serif;=\"\" font-size:=\"\" 13.3333px;=\"\" padding:=\"\" 5px;\"=\"\"><span data-mce-style=\"font-size: 13.3333330154419px; line-height: 21.3333320617676px;\" style=\"line-height: 21.3333px; font-family: Verdana;\">If you have any questions or need assistance, please don\'t hesitate to contact us.</span></div><div data-mce-style=\"padding: 5px;\" style=\"\" droid=\"\" sans\",=\"\" \"lucida=\"\" sans-serif;=\"\" font-size:=\"\" 13.3333px;=\"\" padding:=\"\" 5px;\"=\"\"><span data-mce-style=\"font-size: 13.3333330154419px; line-height: 21.3333320617676px;\" style=\"line-height: 21.3333px; font-family: Verdana;\"><br></span><br></div><div data-mce-style=\"padding: 0px 5px;\" style=\"\" droid=\"\" sans\",=\"\" \"lucida=\"\" sans-serif;=\"\" font-size:=\"\" 13.3333px;=\"\" padding:=\"\" 0px=\"\" 5px;\"=\"\"><span style=\"font-family: Verdana;\">Thanks & Regards,</span><br><span style=\"font-family: Verdana;\">{clinic_name} Team</span></div><div data-mce-style=\"padding: 0px 5px;\" style=\"\" droid=\"\" sans\",=\"\" \"lucida=\"\" sans-serif;=\"\" font-size:=\"\" 13.3333px;=\"\" padding:=\"\" 0px=\"\" 5px;\"=\"\"><br></div><div data-mce-style=\"padding: 0px 5px;\" style=\"\" droid=\"\" sans\",=\"\" \"lucida=\"\" sans-serif;=\"\" font-size:=\"\" 13.3333px;=\"\" padding:=\"\" 0px=\"\" 5px;\"=\"\"><span style=\"font-family: Verdana; font-size: 10px;\">*DO NOT REPLY TO THIS E-MAIL*</span><br style=\"\"><span style=\"font-family: Verdana; font-size: 10px;\">This is an automated e-mail message sent from our support system. Do not reply to this e-mail as we will not receive your reply!</span><br></div>', 1, '2020-01-03 00:19:06'),
(8, 'newrequest', 'New Request', 'New Request Created', '<div data-mce-style=\"padding: 5px; font-size: 11pt;\" style=\"padding: 5px;\"><font color=\"#222222\" face=\"verdana, droid sans, lucida sans, sans-serif\"><span style=\"font-size: 13.3333px; font-family: Verdana;\">Hello {name},</span></font></div><div data-mce-style=\"padding: 5px; font-size: 11pt;\" style=\"padding: 5px;\"><font color=\"#222222\" face=\"Verdana\"><span style=\"font-size: 13.3333px;\">Thanks for creating request at </span></font><span style=\"color: rgb(34, 34, 34); font-family: Verdana; font-size: 13.3333px;\">{clinic_name}</span><font color=\"#222222\" face=\"Verdana\"><span style=\"font-size: 13.3333px;\">. Your request has been accepted and now in process. Your details are as follows.</span></font><br></div><div data-mce-style=\"padding: 10px 5px;\" style=\"padding: 10px 5px;\"><font color=\"#222222\" face=\"Verdana\"><span style=\"font-size: 13.3333px;\">Name</span></font><span style=\"color: rgb(34, 34, 34); font-family: Verdana; font-size: 13.3333px;\">: {name}</span><br><font color=\"#222222\" face=\"Verdana\"><span style=\"font-size: 13.3333px;\">Email Address: {email}</span></font><br><span style=\"color: rgb(34, 34, 34); font-family: Verdana; font-size: 13.3333px;\">Mobile Number: {mobile}</span><br style=\"font-size: 13.3333px;\"><span style=\"color: rgb(34, 34, 34); font-family: Verdana; font-size: 13.3333px;\">Subject: {subject}</span><br><span style=\"color: rgb(34, 34, 34); font-family: Verdana; font-size: 13.3333px;\">Message: {message}</span></div><div data-mce-style=\"padding: 5px;\" style=\"color: rgb(34, 34, 34); font-family: verdana, \"droid sans\", \"lucida sans\", sans-serif; font-size: 13.3333px; padding: 5px;\">We will soon process your request. You can track your request at our website. To track request, {request_link}</div><div data-mce-style=\"padding: 5px;\" style=\"color: rgb(34, 34, 34); font-family: verdana, \"droid sans\", \"lucida sans\", sans-serif; font-size: 13.3333px; padding: 5px;\"><span style=\"font-family: Verdana; font-size: 13.3333px;\">Best Regards,</span><br></div><div data-mce-style=\"padding: 0px 5px;\" style=\"color: rgb(34, 34, 34); font-family: verdana, \"droid sans\", \"lucida sans\", sans-serif; font-size: 13.3333px; padding: 0px 5px;\"><span style=\"font-family: Verdana;\">{clinic_name} Team</span></div><div data-mce-style=\"padding: 0px 5px;\" style=\"color: rgb(34, 34, 34); font-family: verdana, \"droid sans\", \"lucida sans\", sans-serif; font-size: 13.3333px; padding: 0px 5px;\"><br></div><div data-mce-style=\"padding: 0px 5px;\" style=\"color: rgb(34, 34, 34); font-family: verdana, \"droid sans\", \"lucida sans\", sans-serif; font-size: 13.3333px; padding: 0px 5px;\"><span style=\"font-family: Poppins, Poppins, sans-serif; font-size: 14px; color: red;\"><span style=\"font-weight: bolder; font-family: Verdana;\">*DO NOT REPLY TO THIS E-MAIL*</span></span><br style=\"color: rgb(0, 0, 0); font-family: Poppins, Poppins, sans-serif; font-size: 14px;\"><span style=\"color: rgb(0, 0, 0); font-family: Verdana; font-size: 14px;\">This is an automated e-mail message sent from our support system. Do not reply to this e-mail as we will not receive your reply!</span><br></div>', 1, '2020-01-03 00:19:10'),
(9, 'resetpassword', 'Reset password', 'Klinikal Password change confirmation', '<div data-mce-style=\"padding: 5px; font-size: 11pt; font-weight: bold;\" style=\"\" droid=\"\" sans\",=\"\" \"lucida=\"\" sans-serif;=\"\" padding:=\"\" 5px;=\"\" font-size:=\"\" 11pt;=\"\" font-weight:=\"\" bold;\"=\"\"><span style=\"font-size: 18px;\">Hello {firstname}</span></div><div data-mce-style=\"padding: 5px; font-size: 11pt; font-weight: bold;\" style=\"\" droid=\"\" sans\",=\"\" \"lucida=\"\" sans-serif;=\"\" padding:=\"\" 5px;=\"\" font-size:=\"\" 11pt;=\"\" font-weight:=\"\" bold;\"=\"\"><br></div><div data-mce-style=\"padding: 5px; font-size: 11pt; font-weight: bold;\" style=\"\" droid=\"\" sans\",=\"\" \"lucida=\"\" sans-serif;=\"\" padding:=\"\" 5px;=\"\" font-size:=\"\" 11pt;=\"\" font-weight:=\"\" bold;\"=\"\"><span style=\"font-size: 18px;\">This is to inform you that you password has been changed successfully for your Account - {email}</span><br></div><div data-mce-style=\"padding: 5px;\" style=\"\" droid=\"\" sans\",=\"\" \"lucida=\"\" sans-serif;=\"\" font-size:=\"\" 13.3333px;=\"\" padding:=\"\" 5px;\"=\"\"><span style=\"padding: 3px;\"><br></span></div><div data-mce-style=\"padding: 5px;\" style=\"\" droid=\"\" sans\",=\"\" \"lucida=\"\" sans-serif;=\"\" font-size:=\"\" 13.3333px;=\"\" padding:=\"\" 5px;\"=\"\"><span style=\"font-size: 18px;\">Please note: If you have not changed your password. Please contact us as soon as possible. {contact_link}</span></div><div data-mce-style=\"padding: 5px;\" style=\"\" droid=\"\" sans\",=\"\" \"lucida=\"\" sans-serif;=\"\" font-size:=\"\" 13.3333px;=\"\" padding:=\"\" 5px;\"=\"\"><br></div><div data-mce-style=\"padding: 0px 5px;\" style=\"\" droid=\"\" sans\",=\"\" \"lucida=\"\" sans-serif;=\"\" font-size:=\"\" 13.3333px;=\"\" padding:=\"\" 0px=\"\" 5px;\"=\"\"><span style=\"font-size: 18px;\">Regards,</span><br><span style=\"font-size: 18px;\">{clinic_name} Team</span></div><div data-mce-style=\"padding: 0px 5px;\" style=\"\" droid=\"\" sans\",=\"\" \"lucida=\"\" sans-serif;=\"\" font-size:=\"\" 13.3333px;=\"\" padding:=\"\" 0px=\"\" 5px;\"=\"\"><br></div><div data-mce-style=\"padding: 0px 5px;\" style=\"\" droid=\"\" sans\",=\"\" \"lucida=\"\" sans-serif;=\"\" font-size:=\"\" 13.3333px;=\"\" padding:=\"\" 0px=\"\" 5px;\"=\"\"><span style=\"font-size: 18px;\">*DO NOT REPLY TO THIS E-MAIL*</span><br style=\"\"><span style=\"font-size: 18px;\">This is an automated e-mail message sent from our support system. Do not reply to this e-mail as we will not receive your reply!</span><br></div>', 1, '2020-01-03 00:19:16');

-- --------------------------------------------------------

--
-- Table structure for table `kk_expenses`
--

DROP TABLE IF EXISTS `kk_expenses`;
CREATE TABLE IF NOT EXISTS `kk_expenses` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `expense_type` int(11) NOT NULL,
  `amount` int(100) NOT NULL,
  `method` int(11) NOT NULL,
  `date` date NOT NULL,
  `description` text NOT NULL,
  `other` text NOT NULL,
  `user_id` int(11) NOT NULL,
  `date_of_joining` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `kk_expense_type`
--

DROP TABLE IF EXISTS `kk_expense_type`;
CREATE TABLE IF NOT EXISTS `kk_expense_type` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `other` text NOT NULL,
  `status` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `kk_facility`
--

DROP TABLE IF EXISTS `kk_facility`;
CREATE TABLE IF NOT EXISTS `kk_facility` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `icon` varchar(255) NOT NULL,
  `status` tinyint(1) DEFAULT NULL,
  `date_of_joining` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `kk_gallery`
--

DROP TABLE IF EXISTS `kk_gallery`;
CREATE TABLE IF NOT EXISTS `kk_gallery` (
  `id` int(11) NOT NULL,
  `media` varchar(100) NOT NULL,
  `ext` varchar(5) NOT NULL,
  `user_id` int(11) NOT NULL,
  `date_of_joining` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `kk_invoice`
--

DROP TABLE IF EXISTS `kk_invoice`;
CREATE TABLE IF NOT EXISTS `kk_invoice` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(100) NOT NULL,
  `mobile` varchar(64) NOT NULL,
  `duedate` date NOT NULL,
  `invoicedate` date NOT NULL,
  `method` int(5) NOT NULL,
  `status` varchar(50) NOT NULL,
  `inv_status` tinyint(1) NOT NULL,
  `items` text NOT NULL,
  `subtotal` decimal(10,2) NOT NULL,
  `tax` decimal(10,2) NOT NULL,
  `discounttype` int(11) NOT NULL,
  `discount` varchar(255) DEFAULT NULL,
  `discount_value` decimal(10,2) NOT NULL,
  `amount` decimal(10,2) NOT NULL,
  `paid` varchar(255) DEFAULT NULL,
  `due` varchar(255) DEFAULT NULL,
  `note` text NOT NULL,
  `tc` text NOT NULL,
  `doctor` varchar(255) NOT NULL,
  `doctor_id` int(5) NOT NULL,
  `patient_id` int(11) NOT NULL,
  `appointment_id` int(11) NOT NULL,
  `mail_sent` tinyint(1) NOT NULL DEFAULT '0',
  `user_id` int(11) NOT NULL,
  `date_of_joining` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `kk_items`
--

DROP TABLE IF EXISTS `kk_items`;
CREATE TABLE IF NOT EXISTS `kk_items` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `currency` int(11) NOT NULL,
  `price` int(11) NOT NULL,
  `description` varchar(255) NOT NULL,
  `other` varchar(255) NOT NULL,
  `date_of_joining` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `kk_login_attempts`
--

DROP TABLE IF EXISTS `kk_login_attempts`;
CREATE TABLE IF NOT EXISTS `kk_login_attempts` (
  `user_id` int(11) NOT NULL,
  `email` varchar(96) NOT NULL,
  `ip` varchar(40) NOT NULL,
  `count` int(4) NOT NULL,
  `date_added` datetime NOT NULL,
  `date_modified` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `kk_media`
--

DROP TABLE IF EXISTS `kk_media`;
CREATE TABLE IF NOT EXISTS `kk_media` (
  `id` int(11) NOT NULL,
  `media` varchar(255) NOT NULL,
  `ext` varchar(5) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `user_id` int(11) NOT NULL,
  `date_of_joining` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `kk_media`
--

INSERT INTO `kk_media` (`id`, `media`, `ext`, `status`, `user_id`, `date_of_joining`) VALUES
(1, 'media-18169037285e0f1b885e008.jpg', 'jpg', 1, 1, '2020-01-03 10:46:32'),
(2, 'media-967969335e0f1b885f332.jpg', 'jpg', 1, 1, '2020-01-03 10:46:32'),
(3, 'media-15402065955e0f1b886d344.jpg', 'jpg', 1, 1, '2020-01-03 10:46:32'),
(4, 'media-1269114305e0f1b889aa4f.jpg', 'jpg', 1, 1, '2020-01-03 10:46:32'),
(5, 'media-19047557375e0f1b889bb14.jpg', 'jpg', 1, 1, '2020-01-03 10:46:32'),
(6, 'media-10420804785e0f1b889efff.jpg', 'jpg', 1, 1, '2020-01-03 10:46:32'),
(7, 'media-14986370945e0f1b88a0011.jpg', 'jpg', 1, 1, '2020-01-03 10:46:32'),
(8, 'media-15245782795e0f1b88a8462.jpg', 'jpg', 1, 1, '2020-01-03 10:46:32'),
(9, 'media-17964721045e0f1b88ad17c.png', 'png', 1, 1, '2020-01-03 10:46:32'),
(10, 'media-15241643955e0f1b88b0157.png', 'png', 1, 1, '2020-01-03 10:46:32'),
(11, 'media-623588825e0f1b88c522b.png', 'png', 1, 1, '2020-01-03 10:46:32'),
(12, 'media-20288955055e0f1b88ca515.png', 'png', 1, 1, '2020-01-03 10:46:32'),
(13, 'media-16583117465e0f1b88d174b.png', 'png', 1, 1, '2020-01-03 10:46:32'),
(14, 'media-5175326295e0f1b88d26f8.png', 'png', 1, 1, '2020-01-03 10:46:32'),
(15, 'media-11427749815e0f1b88ea78d.png', 'png', 1, 1, '2020-01-03 10:46:32'),
(16, 'media-10093157275e0f1b88ec622.png', 'png', 1, 1, '2020-01-03 10:46:32'),
(17, 'media-4496731875e0f3599bbdad.png', 'png', 1, 1, '2020-01-03 12:37:45');

-- --------------------------------------------------------

--
-- Table structure for table `kk_medicines`
--

DROP TABLE IF EXISTS `kk_medicines`;
CREATE TABLE IF NOT EXISTS `kk_medicines` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `company` varchar(255) NOT NULL,
  `generic` text NOT NULL,
  `medicine_group` varchar(255) NOT NULL,
  `category` int(11) NOT NULL,
  `storebox` varchar(255) NOT NULL,
  `minlevel` varchar(100) NOT NULL,
  `reorderlevel` varchar(100) NOT NULL,
  `unit` varchar(255) NOT NULL,
  `unitpacking` varchar(255) NOT NULL,
  `tax` text NOT NULL,
  `note` text NOT NULL,
  `user_id` int(11) NOT NULL,
  `date_of_joining` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `kk_medicine_batch`
--

DROP TABLE IF EXISTS `kk_medicine_batch`;
CREATE TABLE IF NOT EXISTS `kk_medicine_batch` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `batch` varchar(255) NOT NULL,
  `expiry` varchar(10) NOT NULL,
  `pqty` varchar(10) NOT NULL,
  `qty` decimal(10,2) NOT NULL,
  `saleprice` decimal(10,2) NOT NULL,
  `purchaseprice` decimal(10,2) NOT NULL,
  `tax` text NOT NULL,
  `taxprice` decimal(10,2) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `sold` decimal(10,2) NOT NULL DEFAULT '0.00',
  `medicine_id` int(11) NOT NULL,
  `purchase_id` int(11) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `user_id` int(11) NOT NULL,
  `date_of_joining` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `kk_medicine_bill`
--

DROP TABLE IF EXISTS `kk_medicine_bill`;
CREATE TABLE IF NOT EXISTS `kk_medicine_bill` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `mobile` int(100) NOT NULL,
  `doctor` varchar(255) NOT NULL,
  `method` int(11) NOT NULL,
  `items` text NOT NULL,
  `subtotal` decimal(10,2) NOT NULL,
  `tax` decimal(10,2) NOT NULL,
  `discounttype` int(1) NOT NULL,
  `discount` varchar(10) NOT NULL,
  `discount_value` decimal(10,2) NOT NULL,
  `amount` decimal(10,2) NOT NULL,
  `note` text NOT NULL,
  `doctor_id` int(11) NOT NULL,
  `patient_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `date_of_joining` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `kk_medicine_category`
--

DROP TABLE IF EXISTS `kk_medicine_category`;
CREATE TABLE IF NOT EXISTS `kk_medicine_category` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `date_of_joining` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `kk_medicine_purchase`
--

DROP TABLE IF EXISTS `kk_medicine_purchase`;
CREATE TABLE IF NOT EXISTS `kk_medicine_purchase` (
  `id` int(11) NOT NULL,
  `supplier` int(11) NOT NULL,
  `date` date NOT NULL,
  `total` decimal(10,2) NOT NULL,
  `tax` decimal(10,2) NOT NULL,
  `discounttype` int(1) NOT NULL,
  `discount` varchar(20) NOT NULL,
  `discount_value` decimal(10,2) NOT NULL,
  `amount` decimal(10,2) NOT NULL,
  `note` text NOT NULL,
  `user_id` int(11) NOT NULL,
  `date_of_joining` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `kk_menu`
--

DROP TABLE IF EXISTS `kk_menu`;
CREATE TABLE IF NOT EXISTS `kk_menu` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `link` varchar(255) NOT NULL,
  `icon` varchar(255) NOT NULL,
  `parent` int(11) NOT NULL DEFAULT '0',
  `active` varchar(100) NOT NULL,
  `status` tinyint(1) NOT NULL,
  `priority` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `kk_menu`
--

INSERT INTO `kk_menu` (`id`, `name`, `link`, `icon`, `parent`, `active`, `status`, `priority`) VALUES
(1, 'Dashboard', 'dashboard', 'ti-blackboard', 0, 'dashboard', 1, 2000),
(2, 'Patient', 'patients', 'ti-heart-broken', 0, 'patients', 1, 1970),
(3, 'Appointment', '#', 'ti-calendar', 0, 'appointments', 0, 1940),
(4, 'Appointments', 'appointments', 'ti-calendar', 0, 'appointments', 1, 1910),
(5, 'Clinical Notes', 'notes', '', 21, 'appointments', 1, 912),
(6, 'Invoice', '#', 'ti-receipt', 0, 'invoices', 0, 1820),
(7, 'Invoices', 'invoices', 'ti-receipt', 0, 'invoices', 1, 1790),
(8, 'Invoice items', 'items', '', 21, 'invoices', 1, 911),
(9, 'Request/Enquiry', 'request', 'ti-envelope', 0, 'request', 1, 1640),
(10, 'Doctors', 'doctors', 'ti-id-badge', 0, 'doctors', 1, 1180),
(11, 'Expense', '#', 'ti-unlink', 0, 'expenses', 0, 1610),
(12, 'Expenses', 'expenses', 'ti-unlink', 0, 'expenses', 1, 1580),
(13, 'Expense Type', 'expensetype', '', 21, 'expenses', 1, 909),
(14, 'Subscribers', 'subscribers', 'ti-star', 0, 'subscribers', 1, 1240),
(15, 'User', '#', 'ti-user', 0, 'users', 1, 1160),
(16, 'Users', 'users', '', 15, 'users', 1, 1140),
(17, 'User Role', 'role', '', 15, 'users', 1, 1120),
(18, 'Email', '#', 'ti-email', 0, 'email', 1, 1100),
(19, 'Send Email', 'send/email', '', 18, 'email', 1, 1080),
(20, 'Send Bulk Email', 'sendbulk/email', '', 18, 'email', 1, 1060),
(21, 'Setting', '#', 'ti-settings', 0, 'settings', 1, 1020),
(22, 'System Info', 'info', '', 21, 'settings', 1, 1000),
(23, 'Finance Setting', 'tax', '', 21, 'settings', 0, 980),
(24, 'Email Setting', 'emailsetting', '', 18, 'email', 1, 900),
(25, 'Email Template', 'emailtemplate&for=newuser', '', 18, 'email', 1, 840),
(26, 'Web CMS', '#', 'ti-panel', 0, 'webcms', 1, 500),
(27, 'Pages', 'pages', '', 26, 'webcms', 1, 480),
(28, 'Departments', 'departments', 'ti-layers-alt', 0, 'departments', 1, 1200),
(29, 'Facility', 'facility', '', 26, 'webcms', 1, 380),
(30, 'Service', '#', '', 26, 'webcms', 0, 320),
(31, 'Services', 'services', '', 26, 'webcms', 1, 300),
(32, 'Reviews', 'reviews', '', 26, 'webcms', 1, 280),
(33, 'Testimonials', 'testimonials', '', 26, 'webcms', 1, 260),
(34, 'Blog', '#', 'ti-clipboard', 0, 'blogs', 1, 220),
(35, 'Blogs', 'blogs', '', 34, 'blogs', 1, 200),
(36, 'Category', 'category', '', 34, 'blogs', 1, 180),
(37, 'Comment', 'comment', '', 34, 'blogs', 1, 160),
(38, 'Noticeboard', 'noticeboard', 'ti-announcement', 0, 'noticeboard', 1, 1270),
(39, 'Email Log', 'emaillogs', '', 18, 'email', 1, 1040),
(40, 'Web Menu', 'page/menu', '', 26, 'webcms', 1, 460),
(41, 'Web Footer', 'page/footer', '', 26, 'webcms', 1, 420),
(42, 'Web Theme', 'page/theme', '', 26, 'webcms', 1, 400),
(43, 'Taxes', 'tax', '', 21, 'settings', 1, 960),
(44, 'Payment Methods', 'paymentmethod', '', 21, 'settings', 1, 940),
(45, 'Payment Gateway', 'paymentgateway', '', 21, 'settings', 1, 920),
(46, 'Icons', 'icons', '', 26, 'webcms', 1, 240),
(47, 'Theme Customization', 'customization', 'ti-paint-bucket\r\n', 0, 'customization', 1, 140),
(48, 'Prescriptions', 'prescriptions', 'ti-agenda', 0, 'prescriptions', 1, 1755),
(49, 'Attendance', 'staffattendance', 'ti-ink-pen', 0, 'staffattendance', 1, 1500),
(50, 'Payroll', '#', 'ti-money', 0, 'payroll', 1, 1480),
(51, 'Make Payment', 'makepayment', '', 50, 'makepayment', 1, 1400),
(52, 'Manage Salary', 'managesalary', '', 50, 'managesalary', 1, 1430),
(53, 'Salary Template', 'salarytemplate', '', 50, 'payroll', 1, 1460),
(54, 'Birth & Death Record', '#', 'ti-bookmark-alt', 0, 'birthdeath', 1, 1370),
(55, 'Birth Records', 'birthrecords', '', 54, 'birthdeath', 1, 1330),
(56, 'Death Records', 'deathrecords', '', 54, 'birthdeath', 1, 1300),
(57, 'Pharmacy', '#', 'ti-shopping-cart-full', 0, 'pharmacy', 1, 1720),
(58, 'Inventory/Medicines', 'medicines', '', 57, 'pharmacy', 1, 1705),
(59, 'POS/Bill', 'medicine/billing', '', 57, 'pharmacy', 1, 1715),
(60, 'Purchase', 'medicine/purchase', '', 57, 'pharmacy', 1, 1710),
(61, 'Suppliers', 'suppliers', '', 21, 'settings', 1, 907),
(62, 'Stock adjustment', 'medicine/stock', '', 57, 'pharmacy', 1, 1709),
(63, 'Web Settings', 'page/settings', '', 26, 'webcms', 1, 390),
(64, 'Medicine Category', 'medicine/category', '', 57, 'pharmacy', 1, 1704);

-- --------------------------------------------------------

--
-- Table structure for table `kk_notes`
--

DROP TABLE IF EXISTS `kk_notes`;
CREATE TABLE IF NOT EXISTS `kk_notes` (
  `id` int(11) NOT NULL,
  `type` varchar(50) NOT NULL,
  `note` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `kk_noticeboard`
--

DROP TABLE IF EXISTS `kk_noticeboard`;
CREATE TABLE IF NOT EXISTS `kk_noticeboard` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `start_date` date NOT NULL,
  `end_date` date NOT NULL,
  `status` tinyint(1) NOT NULL,
  `user_id` int(11) NOT NULL,
  `date_of_joining` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `kk_page`
--

DROP TABLE IF EXISTS `kk_page`;
CREATE TABLE IF NOT EXISTS `kk_page` (
  `id` int(11) NOT NULL,
  `page_name` text NOT NULL,
  `page_url` varchar(255) NOT NULL,
  `page_data` text NOT NULL,
  `page_title` varchar(255) NOT NULL,
  `meta_tag` text NOT NULL,
  `meta_description` text NOT NULL,
  `predefined` tinyint(1) NOT NULL,
  `last_modified` datetime NOT NULL,
  `date_of_joining` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `kk_page`
--

INSERT INTO `kk_page` (`id`, `page_name`, `page_url`, `page_data`, `page_title`, `meta_tag`, `meta_description`, `predefined`, `last_modified`, `date_of_joining`) VALUES
(1, 'home', '', '{\"slider\":[{\"img\":\"media-15245782795e0f1b88a8462.jpg\",\"tag\":\"Appointment and Patient Data Management\",\"content\":\"Lorem ipsum dolor sit amet, consectetur adipisicing elit. Maiores, delectus placeat hic voluptatem fuga \"},{\"img\":\"media-15245782795e0f1b88a8462.jpg\",\"tag\":\"Complete Health Care Solution for Clinic\",\"content\":\"This is tag line ipsum dolor sit amet, consectetur Nihil cupiditate. #twitterhash, @facebooktag\"},{\"img\":\"media-15245782795e0f1b88a8462.jpg\",\"tag\":\"During your Entire Lifetime We There\",\"content\":\"Lorem ipsum dolor sit amet, consectetur adipisicin oluptatem fuga . #twitterhash, @facebooktag\"}],\"service\":{\"status\":\"1\",\"title\":\"WHAT WE DO\",\"description\":\"Lorem ipsum dolor sit amet, consectetur adipisicing elit. Maiores, delectus placeat hic voluptatem fuga nemo ad fugit? Beatae expedita doloribus obcaecati quam alias. Natus quas provident laboriosam voluptatem! Nostrum, sit!\\r\\nLorem ipsum dolor sit amet, consectetur adipisicing elit. Maiores, delectus placeat hic voluptatem fuga nemo ad fugit? Beatae expedita doloribus obcaecati quam alias. Natus quas provident laboriosam voluptatem! Nostrum, sit!\",\"picture\":\"media-1269114305e0f1b889aa4f.jpg\"},\"about\":{\"status\":\"1\",\"title\":\"Who We Are\",\"block\":[{\"icon\":\"fas fa-user-md\",\"title\":\"Doctor(s)\",\"count\":\"10\"},{\"icon\":\"fas fa-ambulance\",\"title\":\"Room(s)\",\"count\":\"20\"},{\"icon\":\"fas fa-calendar\",\"title\":\"Year of Experience(s)\",\"count\":\"23\"},{\"icon\":\"far fa-clock\",\"title\":\"OPENING HOURS PER WEEK\",\"count\":\"40\"}],\"picture\":\"media-10420804785e0f1b889efff.jpg\",\"description\":\"Lorem ipsum dolor sit amet, consectetur adipisicing elit. Maiores, delectus placeat hic voluptatem fuga nemo ad fugit? Beatae expedita doloribus obcaecati quam alias. Natus quas provident laboriosam voluptatem! Nostrum, sit!\\\\r\\\\nLorem ipsum dolor sit amet, consectetur adipisicing elit. Maiores, delectus placeat hic voluptatem fuga nemo ad fugit? Beatae expedita doloribus obcaecati quam alias. Natus quas provident laboriosam voluptatem! Nostrum, sit!\\\\r\\\\n\",\"background\":\"media-15245782795e0f1b88a8462.jpg\"},\"facility\":{\"status\":\"1\",\"title\":\"Why Choose Us\"},\"doctor\":{\"status\":\"1\",\"title\":\"Our Team\",\"background\":\"media-15245782795e0f1b88a8462.jpg\"},\"blog\":{\"status\":\"1\",\"title\":\"Latest Posts\"},\"testimonial\":{\"status\":\"1\",\"title\":\"What People Say\",\"background\":\"media-15245782795e0f1b88a8462.jpg\"}}', 'Home', 'Hello World | Klinikal - Appointment and data management system ', 'Hello World | Klinikal - Appointment and data management system ', 1, '2020-01-03 16:17:32', '2019-08-02 00:00:00'),
(2, 'services', '', '{\"facility\":{\"status\":\"1\",\"title\":\"Why Choose Us\"}}', 'Services', 'Service | Klinikal health care - Appointment and patient management system', 'Service | Appointment and patient management system created to simplify ', 1, '2019-12-31 11:38:08', '2019-08-03 22:49:40'),
(3, 'doctors', '', '{\"department\":{\"status\":\"1\",\"title\":\"Our Department \"}}', 'Doctor', 'Klinikal health care - Appointment and patient management system', 'Appointment and patient management system created to simplify ', 1, '2019-12-31 11:38:13', '2019-08-04 22:49:40'),
(4, 'about', '', '{\"about\":{\"paragraph\":\"&lt;div style=&quot;text-align: justify;&quot;&gt;&lt;div&gt;A hospital is an institution for healthcare typically providing specialised treatment for inpatient (or overnight) stays. Some hospitals primarily admit patients suffering from a specific disease or affection, or are reserved for the diagnosis and treatment of conditions affecting a specific age group. Others have a mandate that expands beyond offering dominantly curative and rehabilitative care services to include promotional, preventive and educational roles as part of a primary healthcare approach. Today, hospitals are usually funded by the state, health organisations (for profit or non-profit), by health insurances or by charities and by donations. Historically, however, they were often founded and funded by religious orders or charitable individuals and leaders. Hospitals are nowadays staffed by professionally trained doctors, nurses, paramedical clinicians, etc., whereas historically, this work was usually done by the founding religious orders or by volunteers.&lt;\\/div&gt;&lt;div&gt;&lt;br&gt;&lt;\\/div&gt;&lt;div&gt;&lt;div&gt;&lt;b&gt;A walk-in clinic&lt;\\/b&gt; describes a very broad category of medical facilities only loosely defined as those that accept patients on a walk-in basis and with no appointment required. A number of healthcare service providers fall under the walk-in clinic umbrella including urgent care centers, retail clinics and even many free clinics or community health clinics. Walk-in clinics offer the advantages of being accessible and often inexpensive.&lt;\\/div&gt;&lt;\\/div&gt;&lt;\\/div&gt;\\r\\n\",\"picture\":\"media-1269114305e0f1b889aa4f.jpg\"},\"whoweare\":{\"status\":\"1\",\"title\":\"Who We Are?\",\"block\":[{\"icon\":\"fas fa-user-md\",\"title\":\"Doctor(s)\",\"count\":\"10\"},{\"icon\":\"fas fa-ambulance\",\"title\":\"Room(s)\",\"count\":\"20\"},{\"icon\":\"fas fa-calendar\",\"title\":\"Year of Experience(s)\",\"count\":\"23\"},{\"icon\":\"far fa-clock\",\"title\":\"Opening Hours per Week\",\"count\":\"40\"}],\"picture\":\"media-19047557375e0f1b889bb14.jpg\",\"mission\":{\"title\":\"Our Mission\",\"description\":\"Lorem ipsum dolor sit amet, consectetur adipisicing elit. Quas eligendi perferendis ducimus sed aliquid natus enim, beatae velit reiciendis, inventore molestiae, neque sapiente temporibus architecto dicta, vero quaerat sequi quos. Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque\"},\"vission\":{\"title\":\"Our Vission\",\"description\":\"Lorem ipsum dolor sit amet, consectetur adipisicing elit. Quas eligendi perferendis ducimus sed aliquid natus enim, beatae velit reiciendis, inventore molestiae, neque sapiente temporibus architecto dicta, vero quaerat sequi quos. Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque\"}},\"doctor\":{\"status\":\"1\",\"title\":\"Our Team\"},\"testimonial\":{\"status\":\"1\",\"title\":\"What People Say?\"}}', 'About Us', 'About Us | Klinikal health care - Appointment and patient management system', 'Appointment and patient management system created to simplify ', 1, '2020-01-03 16:18:05', '2019-08-05 22:49:40'),
(5, 'contact', '', '{\"contact\":{\"block\":[{\"icon\":\"fas fa-calendar-plus\",\"title\":\"APPOINTMENT\",\"data1\":\"+ 01 1122 333 333\",\"data2\":\"your appointment email addres\"},{\"icon\":\"fas fa-phone-volume\",\"title\":\"Call Us\",\"data1\":\"+ 01 1122 333 333\",\"data2\":\"+ 01 1122 333 333\"},{\"icon\":\"fas fa-envelope-open\",\"title\":\"Email Us\",\"data1\":\"Email Address 1\",\"data2\":\"Email Address 2\"},{\"icon\":\"fas fa-location-arrow\",\"title\":\"Location\",\"data1\":\"Street name, City, Country\"}],\"googleapikey\":\"\",\"latitude\":\"29.758563\",\"longitude\":\"-95.3583957\"},\"googlemap\":{\"status\":\"1\"}}', 'Contact Us', 'Contact | Klinikal health care - Appointment and patient management system', 'Appointment and patient management system created to simplify ', 1, '2020-01-03 16:18:17', '2019-08-06 22:49:40'),
(6, 'blogs', '', '[]', 'Blogs', 'Blog | Klinikal health care - Appointment and patient management system', 'Klinikal health care - Appointment and patient management system', 1, '2019-12-31 11:38:24', '2019-08-07 22:49:40'),
(7, 'gallery', '', '[]', 'Our Gallery', 'Gallery | Klinikal health care - Appointment and patient management system', 'Klinikal health care - Appointment and patient management system', 1, '2019-12-31 11:36:00', '2019-10-01 00:00:00'),
(8, 'faq', '', '[{\"q\":\"Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium?\",\"a\":\"&quot;Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.&quot;\"}]', 'FAQ', 'Klinikal health care - Appointment and patient management system', 'Appointment and patient management system created to simplify ', 1, '2020-01-03 16:18:39', '2019-08-08 22:49:40');

-- --------------------------------------------------------

--
-- Table structure for table `kk_patients`
--

DROP TABLE IF EXISTS `kk_patients`;
CREATE TABLE IF NOT EXISTS `kk_patients` (
  `id` int(11) NOT NULL,
  `firstname` varchar(255) NOT NULL,
  `lastname` varchar(255) NOT NULL,
  `email` varchar(100) NOT NULL,
  `mobile` varchar(32) NOT NULL,
  `address` text NOT NULL,
  `bloodgroup` varchar(5) NOT NULL,
  `gender` varchar(20) NOT NULL,
  `dob` varchar(10) NOT NULL,
  `history` text NOT NULL,
  `other` text NOT NULL,
  `password` varchar(255) NOT NULL,
  `temp_hash` varchar(255) NOT NULL,
  `emailconfirmed` tinyint(1) NOT NULL,
  `status` tinyint(1) NOT NULL,
  `user_id` int(11) NOT NULL,
  `date_of_joining` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `kk_patient_doctor`
--

DROP TABLE IF EXISTS `kk_patient_doctor`;
CREATE TABLE IF NOT EXISTS `kk_patient_doctor` (
  `id` int(11) NOT NULL,
  `patient_id` int(11) NOT NULL,
  `doctor_id` int(11) NOT NULL,
  `appointment_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `kk_payments`
--

DROP TABLE IF EXISTS `kk_payments`;
CREATE TABLE IF NOT EXISTS `kk_payments` (
  `id` int(11) NOT NULL,
  `payer_id` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `txn_id` varchar(100) DEFAULT NULL,
  `currency` varchar(3) DEFAULT NULL,
  `amount` decimal(10,2) DEFAULT NULL,
  `payment_date` datetime DEFAULT NULL,
  `payment_method` varchar(100) DEFAULT NULL,
  `is_online` int(3) DEFAULT NULL,
  `gateway` varchar(255) DEFAULT NULL,
  `invoice` int(11) DEFAULT NULL,
  `patient_id` int(11) DEFAULT NULL,
  `date_of_joining` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `kk_payment_method`
--

DROP TABLE IF EXISTS `kk_payment_method`;
CREATE TABLE IF NOT EXISTS `kk_payment_method` (
  `id` int(5) NOT NULL,
  `name` varchar(100) NOT NULL,
  `description` varchar(255) NOT NULL,
  `other` text NOT NULL,
  `status` tinyint(1) NOT NULL,
  `date_of_joining` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `kk_prescription`
--

DROP TABLE IF EXISTS `kk_prescription`;
CREATE TABLE IF NOT EXISTS `kk_prescription` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(100) NOT NULL,
  `prescription` text NOT NULL,
  `doctor_id` int(11) NOT NULL,
  `appointment_id` int(11) NOT NULL,
  `patient_id` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `date_of_joining` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `kk_reports`
--

DROP TABLE IF EXISTS `kk_reports`;
CREATE TABLE IF NOT EXISTS `kk_reports` (
  `id` int(100) NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `report` varchar(255) NOT NULL,
  `email` varchar(100) NOT NULL,
  `appointment_id` int(11) NOT NULL,
  `patient_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `date_of_joining` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `kk_request`
--

DROP TABLE IF EXISTS `kk_request`;
CREATE TABLE IF NOT EXISTS `kk_request` (
  `id` int(5) NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `mobile` varchar(255) NOT NULL,
  `subject` text NOT NULL,
  `message` text NOT NULL,
  `remark` text NOT NULL,
  `user_id` int(10) NOT NULL,
  `patient_id` int(11) NOT NULL,
  `status` tinyint(1) DEFAULT NULL,
  `date_of_joining` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `kk_review`
--

DROP TABLE IF EXISTS `kk_review`;
CREATE TABLE IF NOT EXISTS `kk_review` (
  `id` int(11) NOT NULL,
  `review_for` varchar(100) NOT NULL,
  `review_for_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(100) NOT NULL,
  `content` text NOT NULL,
  `rating` int(2) NOT NULL,
  `thumbs_up` int(11) NOT NULL,
  `thumbs_down` int(11) NOT NULL,
  `status` tinyint(4) DEFAULT '0',
  `reviewer_ip` varchar(100) NOT NULL,
  `user_id` int(11) NOT NULL,
  `date_of_joining` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `kk_salarytemplate`
--

DROP TABLE IF EXISTS `kk_salarytemplate`;
CREATE TABLE IF NOT EXISTS `kk_salarytemplate` (
  `id` int(11) NOT NULL,
  `grade` varchar(128) NOT NULL,
  `basic_salary` varchar(20) NOT NULL,
  `allowance` text NOT NULL,
  `deduction` text NOT NULL,
  `gross_salary` varchar(20) NOT NULL,
  `total_allowance` varchar(20) NOT NULL,
  `total_deduction` varchar(20) NOT NULL,
  `net_salary` varchar(20) NOT NULL,
  `date_of_joining` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `kk_service`
--

DROP TABLE IF EXISTS `kk_service`;
CREATE TABLE IF NOT EXISTS `kk_service` (
  `id` int(10) NOT NULL,
  `name` varchar(255) NOT NULL,
  `service_url` varchar(255) NOT NULL,
  `short_post` text NOT NULL,
  `long_post` text NOT NULL,
  `icon` varchar(255) NOT NULL,
  `picture` varchar(255) NOT NULL,
  `status` tinyint(1) DEFAULT NULL,
  `priority` int(5) DEFAULT NULL,
  `date_of_joining` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `kk_setting`
--

DROP TABLE IF EXISTS `kk_setting`;
CREATE TABLE IF NOT EXISTS `kk_setting` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `data` text,
  `status` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `kk_setting`
--

INSERT INTO `kk_setting` (`id`, `name`, `data`, `status`) VALUES
(1, 'siteinfo', '{\"logo\":\"media-16583117465e0f1b88d174b.png\",\"favicon\":\"media-17964721045e0f1b88ad17c.png\",\"name\":\"Klinikal Hospital\",\"legal_name\":\"Klinikal Pvt Ltd\",\"mail\":\"support@test.com\",\"phone\":\"1234567890\",\"emergency\":\"1800000001\",\"mode\":\"1\",\"color\":\"blue\",\"language\":\"en\",\"ga\":\"\",\"timezone\":\"Asia\\/Calcutta\",\"date_format\":\"d-m-Y\",\"date_my_format\":\"m-Y\",\"currency\":\"USD\",\"currency_abbr\":\"$\",\"appointment_prefix\":\"APNT-\",\"invoice_prefix\":\"INV-\",\"invoice_cnote\":\"It\'s great to work with you. \",\"invoice_tc\":\"Please pay us your amount in 15 days. Otherwise 12% interest will be applied.  \",\"prescription_template\":\"2\",\"invoice_template\":\"2\",\"doctor_access\":\"1\",\"address\":{\"address1\":\"Address Line 11\",\"address2\":\"Address Line 2\",\"city\":\"City\",\"country\":\"Country\",\"postal\":\"0123456\"}}', 1),
(2, 'admintheme', '{\"layout\":\"\",\"layout_fixed\":\"\",\"layout_menu\":false,\"side_menu\":\"dark\",\"header_color\":\"bg-white\",\"logo\":\"media-16583117465e0f1b88d174b.png\",\"logo_icon\":\"media-4496731875e0f3599bbdad.png\",\"favicon\":\"media-17964721045e0f1b88ad17c.png\",\"lg_background\":\"media-15245782795e0f1b88a8462.jpg\"}', 1),
(3, 'customcss', '\"p {}\\r\\nlabel {}\\r\\ntext{}\"', 1),
(4, 'generalsetting', '{\"appointment\":\"1\",\"comment\":{\"post\":\"1\",\"approve\":\"1\"},\"review\":{\"post\":\"1\",\"approve\":\"1\"}}', 1),
(5, 'paymentgateway', '{\"paypal\":{\"username\":\"\",\"password\":\"\",\"signature\":\"\",\"email\":\"\",\"mode\":\"0\",\"status\":\"0\"}}', 0),
(7, 'emailsetting', '{\"status\":\"0\",\"fromemail\":\"\",\"fromname\":\"\",\"reply\":\"\",\"host\":\"\",\"port\":\"587\",\"username\":\"\",\"password\":\"\",\"encryption\":\"tls\",\"authentication\":\"1\"}', 1),
(8, 'pagetheme', '{\"home\":{\"theme\":\"home-1\",\"header\":\"header-1\",\"status\":\"1\"},\"services\":{\"theme\":\"services-4\",\"header\":\"header-1\",\"status\":\"1\"},\"doctors\":{\"theme\":\"doctors-1\",\"header\":\"header-1\",\"status\":\"1\"},\"blogs\":{\"theme\":\"blogs-1\",\"header\":\"header-1\",\"status\":\"1\"},\"about\":{\"theme\":\"about\",\"header\":\"header-1\"},\"contact\":{\"theme\":\"contact\",\"header\":\"header-1\"},\"gallery\":{\"theme\":\"gallery\",\"header\":\"header-1\"},\"faq\":{\"theme\":\"faq\",\"header\":\"header-1\"},\"other\":{\"theme\":\"page-3\",\"header\":\"header-1\"}}', 1),
(9, 'pageheader', '[{\"menu_id\":\"5db29b8c6ae2d\",\"menu_type_id\":\"1\",\"menu_page_id\":\"3\",\"menu_parent\":\"0\",\"menu_label\":\"Home\",\"menu_custom\":\"1\",\"menu_link\":\"home\"},{\"menu_id\":\"5db29b8c6aca0\",\"menu_type_id\":\"1\",\"menu_page_id\":\"4\",\"menu_parent\":\"0\",\"menu_label\":\"Services\",\"menu_custom\":\"1\",\"menu_link\":\"services\"},{\"menu_id\":\"5db29b8c6ab55\",\"menu_type_id\":\"1\",\"menu_page_id\":\"5\",\"menu_parent\":\"0\",\"menu_label\":\"Doctor\",\"menu_custom\":\"1\",\"menu_link\":\"doctors\"},{\"menu_id\":\"5db29b605da6e\",\"menu_type_id\":\"1\",\"menu_page_id\":\"6\",\"menu_parent\":\"0\",\"menu_label\":\"About Us\",\"menu_custom\":\"1\",\"menu_link\":\"about\"},{\"menu_id\":\"5db29b8c6a786\",\"menu_type_id\":\"1\",\"menu_page_id\":\"8\",\"menu_parent\":\"0\",\"menu_label\":\"Blog\",\"menu_custom\":\"1\",\"menu_link\":\"blogs\"},{\"menu_id\":\"5db29b8c6a9e0\",\"menu_type_id\":\"1\",\"menu_page_id\":\"7\",\"menu_parent\":\"0\",\"menu_label\":\"Contact Us\",\"menu_custom\":\"1\",\"menu_link\":\"contact\"},{\"menu_id\":\"5db29b8e03b5b\",\"menu_type_id\":\"1\",\"menu_page_id\":\"9\",\"menu_parent\":\"0\",\"menu_label\":\"Faq\",\"menu_custom\":\"1\",\"menu_link\":\"faq\"},{\"menu_id\":\"5db95f3248533\",\"menu_type_id\":\"1\",\"menu_page_id\":\"28\",\"menu_parent\":\"0\",\"menu_label\":\"Gallery\",\"menu_custom\":\"1\",\"menu_link\":\"gallery\"}]', 1),
(10, 'pagefooter', '{\"timetable\":{\"status\":\"1\",\"title\":\"Time Table\",\"timing\":{\"sun\":\"Holiday\",\"mon\":\"10 AM - 5 PM\",\"tue\":\"10 AM - 5 PM\",\"wed\":\"10 AM - 5 PM\",\"thu\":\"10 AM - 5 PM\",\"fri\":\"10 AM - 5 PM\",\"sat\":\"10 AM - 5 PM\"}},\"emergency\":{\"status\":\"1\",\"title\":\"On Emergency\",\"description\":\"At vero eos et accusamus et iusto odio dignissimos ducimus qui blanditiis praesentium voluptatum deleniti atque corrupti quos dolores et quas molestias excepturi sint occaecati cupiditate non provident, similique suntasdadsada\"},\"id\":\"10\",\"footermenu\":[{\"menu_id\":\"5db2e56af26ea\",\"menu_type_id\":\"1\",\"menu_page_id\":\"7\",\"menu_parent\":\"0\",\"menu_label\":\"Contact Us\",\"menu_custom\":\"1\",\"menu_link\":\"contact\"},{\"menu_id\":\"5db2e56af29ad\",\"menu_type_id\":\"1\",\"menu_page_id\":\"6\",\"menu_parent\":\"0\",\"menu_label\":\"About Us\",\"menu_custom\":\"1\",\"menu_link\":\"about\"},{\"menu_id\":\"5db2e56af2b11\",\"menu_type_id\":\"1\",\"menu_page_id\":\"5\",\"menu_parent\":\"0\",\"menu_label\":\"Doctor\",\"menu_custom\":\"1\",\"menu_link\":\"doctors\"},{\"menu_id\":\"5db2eba2f12a0\",\"menu_type_id\":\"1\",\"menu_page_id\":\"3\",\"menu_parent\":\"0\",\"menu_label\":\"Home\",\"menu_custom\":\"1\",\"menu_link\":\"home\"},{\"menu_id\":\"5dc24eb446880\",\"menu_type_id\":\"1\",\"menu_page_id\":\"5\",\"menu_parent\":\"0\",\"menu_label\":\"Doctor\",\"menu_custom\":\"1\",\"menu_link\":\"doctors\"},{\"menu_id\":\"5dc24eb446a81\",\"menu_type_id\":\"1\",\"menu_page_id\":\"4\",\"menu_parent\":\"0\",\"menu_label\":\"Services\",\"menu_custom\":\"1\",\"menu_link\":\"services\"}],\"social\":{\"facebook\":\"www.facebook.com\",\"twitter\":\"www.twitter.com\",\"google\":\"www.google.com\",\"instagram\":\"www.instagram.com\",\"youtube\":\"www.youtube.com\",\"linkedin\":\"www.linkedin.com\",\"flickr\":\"www.flickr.com\",\"rss\":\"www.rss.com\"},\"copyright\":\"2020 \\u00a9 Pepdev, ALL RIGHTS RESERVED\",\"page_name\":\"footer\"}', 1),
(11, 'sociallink', '{\"facebook\":\"https:\\/\\/www.facebook.com\",\"twitter\":\"https:\\/\\/www.twitter.com\",\"google\":\"https:\\/\\/www.google.com\",\"instagram\":\"https:\\/\\/www.instagram.com\",\"youtube\":\"https:\\/\\/www.youtube.com\",\"linkedin\":\"https:\\/\\/www.linkedin.com\",\"flickr\":\"https:\\/\\/www.flickr.com\"}', 1);

-- --------------------------------------------------------

--
-- Table structure for table `kk_staff_attendance`
--

DROP TABLE IF EXISTS `kk_staff_attendance`;
CREATE TABLE IF NOT EXISTS `kk_staff_attendance` (
  `id` int(200) UNSIGNED NOT NULL,
  `staff_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `monthyear` varchar(10) NOT NULL,
  `a1` varchar(3) DEFAULT NULL,
  `a2` varchar(3) DEFAULT NULL,
  `a3` varchar(3) DEFAULT NULL,
  `a4` varchar(3) DEFAULT NULL,
  `a5` varchar(3) DEFAULT NULL,
  `a6` varchar(3) DEFAULT NULL,
  `a7` varchar(3) DEFAULT NULL,
  `a8` varchar(3) DEFAULT NULL,
  `a9` varchar(3) DEFAULT NULL,
  `a10` varchar(3) DEFAULT NULL,
  `a11` varchar(3) DEFAULT NULL,
  `a12` varchar(3) DEFAULT NULL,
  `a13` varchar(3) DEFAULT NULL,
  `a14` varchar(3) DEFAULT NULL,
  `a15` varchar(3) DEFAULT NULL,
  `a16` varchar(3) DEFAULT NULL,
  `a17` varchar(3) DEFAULT NULL,
  `a18` varchar(3) DEFAULT NULL,
  `a19` varchar(3) DEFAULT NULL,
  `a20` varchar(3) DEFAULT NULL,
  `a21` varchar(3) DEFAULT NULL,
  `a22` varchar(3) DEFAULT NULL,
  `a23` varchar(3) DEFAULT NULL,
  `a24` varchar(3) DEFAULT NULL,
  `a25` varchar(3) DEFAULT NULL,
  `a26` varchar(3) DEFAULT NULL,
  `a27` varchar(3) DEFAULT NULL,
  `a28` varchar(3) DEFAULT NULL,
  `a29` varchar(3) DEFAULT NULL,
  `a30` varchar(3) DEFAULT NULL,
  `a31` varchar(3) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `kk_staff_payment`
--

DROP TABLE IF EXISTS `kk_staff_payment`;
CREATE TABLE IF NOT EXISTS `kk_staff_payment` (
  `id` int(11) NOT NULL,
  `month_year` varchar(20) NOT NULL,
  `gross_salary` varchar(20) NOT NULL,
  `total_deduction` varchar(20) NOT NULL,
  `net_salary` varchar(20) NOT NULL,
  `method` int(11) NOT NULL,
  `advance` varchar(20) NOT NULL,
  `deduction` varchar(20) NOT NULL,
  `amount` varchar(20) NOT NULL,
  `comments` text,
  `salarytemplate` text NOT NULL,
  `salarytemplate_id` int(11) NOT NULL,
  `staff_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `date_of_joining` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `kk_subscribe`
--

DROP TABLE IF EXISTS `kk_subscribe`;
CREATE TABLE IF NOT EXISTS `kk_subscribe` (
  `id` int(11) NOT NULL,
  `email` varchar(255) NOT NULL,
  `status` tinyint(1) NOT NULL,
  `date_of_joining` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `kk_suppliers`
--

DROP TABLE IF EXISTS `kk_suppliers`;
CREATE TABLE IF NOT EXISTS `kk_suppliers` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `phone` varchar(100) NOT NULL,
  `address` text NOT NULL,
  `user_id` int(11) NOT NULL,
  `date_of_joining` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `kk_taxes`
--

DROP TABLE IF EXISTS `kk_taxes`;
CREATE TABLE IF NOT EXISTS `kk_taxes` (
  `id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `rate` float NOT NULL,
  `description` varchar(255) NOT NULL,
  `other` text NOT NULL,
  `date_of_joining` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `kk_testimonial`
--

DROP TABLE IF EXISTS `kk_testimonial`;
CREATE TABLE IF NOT EXISTS `kk_testimonial` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `mobile` varchar(255) NOT NULL,
  `testimonial` text NOT NULL,
  `picture` varchar(255) NOT NULL,
  `status` tinyint(1) DEFAULT NULL,
  `date_of_joining` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `kk_users`
--

DROP TABLE IF EXISTS `kk_users`;
CREATE TABLE IF NOT EXISTS `kk_users` (
  `user_id` int(5) NOT NULL,
  `user_role` int(4) DEFAULT NULL,
  `user_name` varchar(255) DEFAULT NULL,
  `firstname` varchar(255) NOT NULL,
  `lastname` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `mobile` varchar(255) NOT NULL,
  `picture` varchar(255) NOT NULL,
  `address` text,
  `country` varchar(255) DEFAULT NULL,
  `bloodgroup` varchar(5) DEFAULT NULL,
  `gender` varchar(20) DEFAULT NULL,
  `dob` varchar(10) DEFAULT NULL,
  `salarytemplate_id` int(11) DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `temp_hash` varchar(225) NOT NULL,
  `emailconfirmed` bit(1) DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `date_of_joining` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `kk_users`
--

INSERT INTO `kk_users` (`user_id`, `user_role`, `user_name`, `firstname`, `lastname`, `email`, `mobile`, `picture`, `address`, `country`, `bloodgroup`, `gender`, `dob`, `salarytemplate_id`, `password`, `temp_hash`, `emailconfirmed`, `status`, `date_of_joining`) VALUES
(1, 1, 'admin', 'John', 'Doe', 'support@pepdev.com', '111111111', 'media-5505453175dbaeecba016c.jpg', '{\"address1\":\"Address Line 1\",\"address2\":\"Address Line 2\",\"city\":\"City\",\"country\":\"Country\",\"postal\":\"411048\"}', NULL, NULL, '', NULL, NULL, '$2y$10$VYRcGC7YaqBRybwplD9pvODx.n84jatMXEiiziHzEM.Kf/lyDgv7G', '', b'1', 1, '2020-01-15 14:24:06');

-- --------------------------------------------------------

--
-- Table structure for table `kk_user_role`
--

DROP TABLE IF EXISTS `kk_user_role`;
CREATE TABLE IF NOT EXISTS `kk_user_role` (
  `id` int(5) NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` varchar(255) NOT NULL,
  `permission` text NOT NULL,
  `date_of_joining` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `kk_user_role`
--

INSERT INTO `kk_user_role` (`id`, `name`, `description`, `permission`, `date_of_joining`) VALUES
(1, 'Admin', 'You can not change Admin role setting', '[\"dashboard\",\"login\",\"patients\",\"patient\\/add\",\"patient\\/edit\",\"patient\\/delete\",\"patient\\/view\",\"appointments\",\"appointment\\/add\",\"appointment\\/edit\",\"appointment\\/delete\",\"invoices\",\"invoice\\/add\",\"invoice\\/edit\",\"invoice\\/delete\",\"invoice\\/view\",\"request\",\"request\\/add\",\"request\\/edit\",\"request\\/delete\",\"doctors\",\"doctor\\/add\",\"doctor\\/edit\",\"doctor\\/delete\",\"departments\",\"department\\/add\",\"subscriber\\/add\",\"subscriber\\/edit\",\"subscriber\\/delete\",\"users\",\"user\\/add\",\"user\\/edit\",\"user\\/delete\",\"items\",\"item\\/add\",\"item\\/edit\",\"item\\/delete\",\"notes\",\"note\\/add\",\"note\\/edit\",\"note\\/delete\",\"pharmacy\",\"pharmacy\\/add\",\"pharmacy\\/edit\",\"pharmacy\\/delete\",\"pages\",\"page\\/add\",\"page\\/edit\",\"page\\/delete\",\"facility\",\"facility\\/add\",\"facility\\/edit\",\"facility\\/delete\",\"services\",\"service\\/add\",\"service\\/edit\",\"service\\/delete\",\"testimonials\",\"testimonial\\/add\",\"testimonial\\/edit\",\"testimonial\\/delete\",\"blogs\",\"blog\\/add\",\"blog\\/edit\",\"blog\\/delete\",\"category\",\"category\\/add\",\"category\\/edit\",\"category\\/delete\",\"comment\",\"comment\\/edit\",\"comment\\/delete\",\"reviews\",\"review\\/edit\",\"review\\/delete\",\"expenses\",\"expense\\/add\",\"expense\\/edit\",\"expense\\/delete\"]', '2018-01-10 23:15:47'),
(2, 'Dean', 'Clinic\'s Dean', '[\"dashboard\",\"dashbaordappointment\",\"patients\",\"patient\\/add\",\"patient\\/edit\",\"patient\\/delete\",\"patient\\/view\",\"patient\\/notes\",\"patients\\/documents\",\"patient\\/sendmail\",\"appointments\",\"appointment\\/add\",\"appointment\\/edit\",\"appointment\\/delete\",\"appointment\\/view\",\"appointment\\/sendmail\",\"appointment\\/notes\",\"appointment\\/documents\",\"report\\/reportUpload\",\"report\\/removeReport\",\"prescriptions\",\"prescription\\/add\",\"prescription\\/edit\",\"prescription\\/delete\",\"prescription\\/view\",\"prescription\\/pdf\",\"invoices\",\"invoice\\/add\",\"invoice\\/edit\",\"invoice\\/delete\",\"invoice\\/view\",\"invoice\\/pdf\",\"invoice\\/sentmail\",\"addpayment\",\"request\",\"request\\/edit\",\"request\\/delete\",\"request\\/view\",\"request\\/mail\",\"medicines\",\"medicine\\/add\",\"medicine\\/edit\",\"medicine\\/delete\",\"medicine\\/view\",\"medicine\\/upload\",\"departments\",\"department\\/add\",\"department\\/edit\",\"department\\/delete\",\"doctors\",\"doctor\\/add\",\"doctor\\/edit\",\"doctor\\/delete\",\"expenses\",\"expense\\/add\",\"expense\\/edit\",\"expense\\/delete\",\"expensetype\",\"expensetype\\/add\",\"expensetype\\/edit\",\"expensetype\\/delete\",\"staffattendance\",\"staffattendance\\/add\",\"staffattendance\\/view\",\"salarytemplate\",\"salarytemplate\\/add\",\"salarytemplate\\/edit\",\"salarytemplate\\/delete\",\"managesalary\",\"managesalary\\/add\",\"managesalary\\/edit\",\"managesalary\\/view\",\"payment\",\"payment\\/view\",\"payment\\/pdf\",\"makepayment\",\"makepayment\\/add\",\"birthrecords\",\"birthrecord\\/add\",\"birthrecord\\/edit\",\"birthrecord\\/delete\",\"birthrecord\\/view\",\"birthrecord\\/pdf\",\"deathrecords\",\"deathrecord\\/add\",\"deathrecord\\/edit\",\"deathrecord\\/delete\",\"deathrecord\\/view\",\"deathrecord\\/pdf\",\"noticeboard\",\"noticeboard\\/add\",\"noticeboard\\/edit\",\"noticeboard\\/delete\",\"noticeboard\\/view\",\"users\",\"user\\/add\",\"user\\/edit\",\"user\\/delete\",\"subscribers\",\"subscriber\\/add\",\"subscriber\\/edit\",\"subscriber\\/delete\",\"facility\",\"facility\\/add\",\"facility\\/edit\",\"facility\\/delete\",\"services\",\"service\\/add\",\"service\\/edit\",\"service\\/delete\",\"reviews\",\"review\\/edit\",\"review\\/delete\",\"testimonials\",\"testimonial\\/add\",\"testimonial\\/edit\",\"testimonial\\/delete\",\"blogs\",\"blog\\/add\",\"blog\\/edit\",\"blog\\/delete\",\"category\",\"category\\/add\",\"category\\/edit\",\"category\\/delete\",\"comment\",\"comment\\/edit\",\"comment\\/delete\",\"notes\",\"note\\/add\",\"note\\/edit\",\"note\\/delete\",\"items\",\"item\\/add\",\"item\\/edit\",\"item\\/delete\",\"send\\/email\",\"sendbulk\\/email\",\"emaillogs\",\"get\\/media\",\"media\\/upload\",\"media\\/delete\"]', '2018-01-10 23:37:46'),
(3, 'Doctor', 'clinic\'s doctors', '[\"dashboard\",\"dashbaordappointment\",\"patients\",\"patient\\/add\",\"patient\\/edit\",\"patient\\/delete\",\"patient\\/view\",\"patient\\/notes\",\"patients\\/documents\",\"patient\\/sendmail\",\"appointments\",\"appointment\\/add\",\"appointment\\/edit\",\"appointment\\/delete\",\"appointment\\/view\",\"appointment\\/sendmail\",\"appointment\\/notes\",\"appointment\\/documents\",\"report\\/reportUpload\",\"report\\/removeReport\",\"prescriptions\",\"prescription\\/add\",\"prescription\\/edit\",\"prescription\\/delete\",\"prescription\\/view\",\"prescription\\/pdf\",\"invoices\",\"invoice\\/add\",\"invoice\\/edit\",\"invoice\\/delete\",\"invoice\\/view\",\"invoice\\/sentmail\",\"addpayment\",\"medicines\",\"doctors\",\"doctor\\/edit\",\"expenses\",\"expense\\/add\",\"expense\\/edit\",\"expense\\/delete\",\"birthrecords\",\"deathrecords\",\"noticeboard\",\"noticeboard\\/view\",\"blogs\",\"blog\\/add\",\"blog\\/edit\",\"comment\",\"comment\\/edit\",\"notes\",\"note\\/add\",\"note\\/edit\",\"send\\/email\",\"get\\/media\"]', '2019-08-06 01:35:59'),
(4, 'Nurse', 'clinic\'s doctors', '[\"dashboard\",\"patients\",\"patient\\/add\",\"patient\\/edit\",\"patient\\/delete\",\"patient\\/view\",\"patient\\/sendmail\",\"appointments\",\"appointment\\/add\",\"appointment\\/edit\",\"appointment\\/delete\",\"appointment\\/view\",\"appointment\\/sendmail\",\"prescriptions\",\"prescription\\/add\",\"prescription\\/edit\",\"prescription\\/delete\",\"prescription\\/view\",\"prescription\\/pdf\",\"request\",\"request\\/edit\",\"request\\/delete\",\"request\\/view\",\"request\\/mail\",\"birthrecords\",\"birthrecord\\/add\",\"birthrecord\\/edit\",\"birthrecord\\/delete\",\"birthrecord\\/view\",\"birthrecord\\/pdf\",\"deathrecords\",\"deathrecord\\/add\",\"deathrecord\\/edit\",\"deathrecord\\/delete\",\"deathrecord\\/view\",\"deathrecord\\/pdf\",\"noticeboard\",\"noticeboard\\/view\",\"notes\",\"note\\/add\",\"note\\/edit\",\"note\\/delete\"]', '2019-08-06 01:35:59'),
(5, 'Accountant', 'clinic\'s doctors', '[\"dashboard\",\"invoices\",\"invoice\\/add\",\"invoice\\/edit\",\"invoice\\/delete\",\"invoice\\/view\",\"invoice\\/pdf\",\"invoice\\/sentmail\",\"addpayment\",\"request\",\"request\\/edit\",\"medicine\\/billing\",\"medicine\\/billing\\/add\",\"medicine\\/billing\\/edit\",\"medicine\\/billing\\/delete\",\"medicine\\/billing\\/view\",\"medicine\\/billing\\/pdf\",\"medicine\\/purchase\",\"medicine\\/purchase\\/add\",\"medicine\\/purchase\\/edit\",\"medicine\\/purchase\\/delete\",\"medicine\\/purchase\\/view\",\"medicine\\/purchase\\/pdf\",\"expenses\",\"expense\\/add\",\"expense\\/edit\",\"expense\\/delete\",\"expensetype\",\"expensetype\\/add\",\"expensetype\\/edit\",\"expensetype\\/delete\",\"salarytemplate\",\"salarytemplate\\/add\",\"salarytemplate\\/edit\",\"salarytemplate\\/delete\",\"managesalary\",\"managesalary\\/add\",\"managesalary\\/edit\",\"managesalary\\/view\",\"payment\",\"payment\\/view\",\"payment\\/pdf\",\"makepayment\",\"makepayment\\/add\",\"tax\",\"tax\\/add\",\"tax\\/edit\",\"tax\\/delete\",\"paymentmethod\",\"paymentmethod\\/add\",\"paymentmethod\\/edit\",\"paymentmethod\\/delete\",\"paymentgateway\",\"items\",\"item\\/add\",\"item\\/edit\"]', '2019-08-06 01:35:59'),
(6, 'Pharmacist', 'Pharmacist', '[\"dashboard\",\"medicine\\/billing\",\"medicine\\/billing\\/add\",\"medicine\\/billing\\/edit\",\"medicine\\/billing\\/delete\",\"medicine\\/billing\\/view\",\"medicine\\/billing\\/pdf\",\"medicine\\/purchase\",\"medicine\\/purchase\\/add\",\"medicine\\/purchase\\/edit\",\"medicine\\/purchase\\/delete\",\"medicine\\/purchase\\/view\",\"medicine\\/purchase\\/pdf\",\"medicine\\/stock\",\"medicine\\/stock\\/delete\",\"medicines\",\"medicine\\/add\",\"medicine\\/edit\",\"medicine\\/delete\",\"medicine\\/view\",\"medicine\\/upload\",\"medicine\\/category\",\"medicine\\/category\\/add\",\"medicine\\/category\\/edit\",\"medicine\\/category\\/delete\",\"expenses\",\"expense\\/add\",\"expense\\/edit\",\"noticeboard\",\"noticeboard\\/view\",\"tax\",\"paymentmethod\"]', '2019-12-17 12:00:26'),
(7, 'Receptionist', 'Clinic\'s receptionist', '[\"dashboard\",\"patients\",\"patient\\/add\",\"appointments\",\"appointment\\/add\",\"invoices\",\"invoice\\/add\",\"invoice\\/edit\",\"invoice\\/view\",\"invoice\\/pdf\",\"invoice\\/sentmail\",\"addpayment\",\"request\",\"request\\/edit\",\"request\\/delete\",\"request\\/view\",\"request\\/mail\",\"staffattendance\",\"staffattendance\\/add\",\"staffattendance\\/view\",\"noticeboard\",\"noticeboard\\/view\"]', '2019-12-21 15:39:21'),
(8, 'Employee', 'Employee', '[\"appointments\",\"invoices\",\"request\",\"request\\/add\",\"request\\/edit\",\"expenses\",\"noticeboard\",\"noticeboard\\/add\"]', '2019-10-24 05:31:44');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `kk_appointments`
--
ALTER TABLE `kk_appointments`
ADD PRIMARY KEY (`id`),
ADD UNIQUE KEY `appointment_id` (`appointment_id`);

--
-- Indexes for table `kk_appointment_notes`
--
ALTER TABLE `kk_appointment_notes`
ADD PRIMARY KEY (`id`);

--
-- Indexes for table `kk_attached_files`
--
ALTER TABLE `kk_attached_files`
ADD PRIMARY KEY (`id`);

--
-- Indexes for table `kk_birth_records`
--
ALTER TABLE `kk_birth_records`
ADD PRIMARY KEY (`id`);

--
-- Indexes for table `kk_blog`
--
ALTER TABLE `kk_blog`
ADD PRIMARY KEY (`id`);

--
-- Indexes for table `kk_category`
--
ALTER TABLE `kk_category`
ADD PRIMARY KEY (`id`);

--
-- Indexes for table `kk_comment`
--
ALTER TABLE `kk_comment`
ADD PRIMARY KEY (`id`);

--
-- Indexes for table `kk_death_records`
--
ALTER TABLE `kk_death_records`
ADD PRIMARY KEY (`id`);

--
-- Indexes for table `kk_departments`
--
ALTER TABLE `kk_departments`
ADD PRIMARY KEY (`id`);

--
-- Indexes for table `kk_doctors`
--
ALTER TABLE `kk_doctors`
ADD PRIMARY KEY (`id`);

--
-- Indexes for table `kk_email_logs`
--
ALTER TABLE `kk_email_logs`
ADD PRIMARY KEY (`id`);

--
-- Indexes for table `kk_email_template`
--
ALTER TABLE `kk_email_template`
ADD PRIMARY KEY (`id`);

--
-- Indexes for table `kk_expenses`
--
ALTER TABLE `kk_expenses`
ADD PRIMARY KEY (`id`);

--
-- Indexes for table `kk_expense_type`
--
ALTER TABLE `kk_expense_type`
ADD PRIMARY KEY (`id`);

--
-- Indexes for table `kk_facility`
--
ALTER TABLE `kk_facility`
ADD PRIMARY KEY (`id`);

--
-- Indexes for table `kk_gallery`
--
ALTER TABLE `kk_gallery`
ADD PRIMARY KEY (`id`);

--
-- Indexes for table `kk_invoice`
--
ALTER TABLE `kk_invoice`
ADD PRIMARY KEY (`id`);

--
-- Indexes for table `kk_items`
--
ALTER TABLE `kk_items`
ADD PRIMARY KEY (`id`);

--
-- Indexes for table `kk_login_attempts`
--
ALTER TABLE `kk_login_attempts`
ADD PRIMARY KEY (`user_id`),
ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `kk_media`
--
ALTER TABLE `kk_media`
ADD PRIMARY KEY (`id`);

--
-- Indexes for table `kk_medicines`
--
ALTER TABLE `kk_medicines`
ADD PRIMARY KEY (`id`);

--
-- Indexes for table `kk_medicine_batch`
--
ALTER TABLE `kk_medicine_batch`
ADD PRIMARY KEY (`id`);

--
-- Indexes for table `kk_medicine_bill`
--
ALTER TABLE `kk_medicine_bill`
ADD PRIMARY KEY (`id`);

--
-- Indexes for table `kk_medicine_category`
--
ALTER TABLE `kk_medicine_category`
ADD PRIMARY KEY (`id`);

--
-- Indexes for table `kk_medicine_purchase`
--
ALTER TABLE `kk_medicine_purchase`
ADD PRIMARY KEY (`id`);

--
-- Indexes for table `kk_menu`
--
ALTER TABLE `kk_menu`
ADD PRIMARY KEY (`id`);

--
-- Indexes for table `kk_notes`
--
ALTER TABLE `kk_notes`
ADD PRIMARY KEY (`id`);

--
-- Indexes for table `kk_noticeboard`
--
ALTER TABLE `kk_noticeboard`
ADD PRIMARY KEY (`id`);

--
-- Indexes for table `kk_page`
--
ALTER TABLE `kk_page`
ADD PRIMARY KEY (`id`);

--
-- Indexes for table `kk_patients`
--
ALTER TABLE `kk_patients`
ADD PRIMARY KEY (`id`),
ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `kk_patient_doctor`
--
ALTER TABLE `kk_patient_doctor`
ADD PRIMARY KEY (`id`);

--
-- Indexes for table `kk_payments`
--
ALTER TABLE `kk_payments`
ADD PRIMARY KEY (`id`);

--
-- Indexes for table `kk_payment_method`
--
ALTER TABLE `kk_payment_method`
ADD PRIMARY KEY (`id`);

--
-- Indexes for table `kk_prescription`
--
ALTER TABLE `kk_prescription`
ADD PRIMARY KEY (`id`);

--
-- Indexes for table `kk_reports`
--
ALTER TABLE `kk_reports`
ADD PRIMARY KEY (`id`);

--
-- Indexes for table `kk_request`
--
ALTER TABLE `kk_request`
ADD PRIMARY KEY (`id`);

--
-- Indexes for table `kk_review`
--
ALTER TABLE `kk_review`
ADD PRIMARY KEY (`id`);

--
-- Indexes for table `kk_salarytemplate`
--
ALTER TABLE `kk_salarytemplate`
ADD PRIMARY KEY (`id`);

--
-- Indexes for table `kk_service`
--
ALTER TABLE `kk_service`
ADD PRIMARY KEY (`id`),
ADD UNIQUE KEY `service_url` (`service_url`);

--
-- Indexes for table `kk_setting`
--
ALTER TABLE `kk_setting`
ADD PRIMARY KEY (`id`);

--
-- Indexes for table `kk_staff_attendance`
--
ALTER TABLE `kk_staff_attendance`
ADD PRIMARY KEY (`id`);

--
-- Indexes for table `kk_staff_payment`
--
ALTER TABLE `kk_staff_payment`
ADD PRIMARY KEY (`id`);

--
-- Indexes for table `kk_subscribe`
--
ALTER TABLE `kk_subscribe`
ADD PRIMARY KEY (`id`),
ADD UNIQUE KEY `id` (`id`),
ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `kk_suppliers`
--
ALTER TABLE `kk_suppliers`
ADD PRIMARY KEY (`id`);

--
-- Indexes for table `kk_taxes`
--
ALTER TABLE `kk_taxes`
ADD PRIMARY KEY (`id`);

--
-- Indexes for table `kk_testimonial`
--
ALTER TABLE `kk_testimonial`
ADD PRIMARY KEY (`id`);

--
-- Indexes for table `kk_users`
--
ALTER TABLE `kk_users`
ADD PRIMARY KEY (`user_id`),
ADD UNIQUE KEY `email` (`email`),
ADD UNIQUE KEY `user_name` (`user_name`);

--
-- Indexes for table `kk_user_role`
--
ALTER TABLE `kk_user_role`
ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `kk_appointments`
--
ALTER TABLE `kk_appointments`
MODIFY `id` int(100) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `kk_appointment_notes`
--
ALTER TABLE `kk_appointment_notes`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `kk_attached_files`
--
ALTER TABLE `kk_attached_files`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `kk_birth_records`
--
ALTER TABLE `kk_birth_records`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `kk_blog`
--
ALTER TABLE `kk_blog`
MODIFY `id` int(100) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `kk_category`
--
ALTER TABLE `kk_category`
MODIFY `id` int(100) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `kk_comment`
--
ALTER TABLE `kk_comment`
MODIFY `id` int(51) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `kk_death_records`
--
ALTER TABLE `kk_death_records`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `kk_departments`
--
ALTER TABLE `kk_departments`
MODIFY `id` int(5) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `kk_doctors`
--
ALTER TABLE `kk_doctors`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `kk_email_logs`
--
ALTER TABLE `kk_email_logs`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `kk_email_template`
--
ALTER TABLE `kk_email_template`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `kk_expenses`
--
ALTER TABLE `kk_expenses`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `kk_expense_type`
--
ALTER TABLE `kk_expense_type`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `kk_facility`
--
ALTER TABLE `kk_facility`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `kk_gallery`
--
ALTER TABLE `kk_gallery`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `kk_invoice`
--
ALTER TABLE `kk_invoice`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `kk_items`
--
ALTER TABLE `kk_items`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `kk_login_attempts`
--
ALTER TABLE `kk_login_attempts`
MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;

--
-- AUTO_INCREMENT for table `kk_media`
--
ALTER TABLE `kk_media`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `kk_medicines`
--
ALTER TABLE `kk_medicines`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `kk_medicine_batch`
--
ALTER TABLE `kk_medicine_batch`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `kk_medicine_bill`
--
ALTER TABLE `kk_medicine_bill`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `kk_medicine_category`
--
ALTER TABLE `kk_medicine_category`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;

--
-- AUTO_INCREMENT for table `kk_medicine_purchase`
--
ALTER TABLE `kk_medicine_purchase`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `kk_menu`
--
ALTER TABLE `kk_menu`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=65;

--
-- AUTO_INCREMENT for table `kk_notes`
--
ALTER TABLE `kk_notes`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `kk_noticeboard`
--
ALTER TABLE `kk_noticeboard`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `kk_page`
--
ALTER TABLE `kk_page`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `kk_patients`
--
ALTER TABLE `kk_patients`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `kk_patient_doctor`
--
ALTER TABLE `kk_patient_doctor`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `kk_payments`
--
ALTER TABLE `kk_payments`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `kk_payment_method`
--
ALTER TABLE `kk_payment_method`
MODIFY `id` int(5) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `kk_prescription`
--
ALTER TABLE `kk_prescription`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `kk_reports`
--
ALTER TABLE `kk_reports`
MODIFY `id` int(100) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `kk_request`
--
ALTER TABLE `kk_request`
MODIFY `id` int(5) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `kk_review`
--
ALTER TABLE `kk_review`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `kk_salarytemplate`
--
ALTER TABLE `kk_salarytemplate`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `kk_service`
--
ALTER TABLE `kk_service`
MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `kk_setting`
--
ALTER TABLE `kk_setting`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `kk_staff_attendance`
--
ALTER TABLE `kk_staff_attendance`
MODIFY `id` int(200) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `kk_staff_payment`
--
ALTER TABLE `kk_staff_payment`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `kk_subscribe`
--
ALTER TABLE `kk_subscribe`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `kk_suppliers`
--
ALTER TABLE `kk_suppliers`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `kk_taxes`
--
ALTER TABLE `kk_taxes`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `kk_testimonial`
--
ALTER TABLE `kk_testimonial`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `kk_users`
--
ALTER TABLE `kk_users`
MODIFY `user_id` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `kk_user_role`
--
ALTER TABLE `kk_user_role`
MODIFY `id` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
COMMIT;
