/*
 Navicat MySQL Data Transfer

 Source Server         : localhost_3306
 Source Server Type    : MySQL
 Source Server Version : 100428 (10.4.28-MariaDB)
 Source Host           : localhost:3306
 Source Schema         : capstone

 Target Server Type    : MySQL
 Target Server Version : 100428 (10.4.28-MariaDB)
 File Encoding         : 65001

 Date: 29/12/2023 13:34:52
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for applicant_status
-- ----------------------------
DROP TABLE IF EXISTS `applicant_status`;
CREATE TABLE `applicant_status`  (
  `status_id` int NOT NULL AUTO_INCREMENT,
  `app_id` int NULL DEFAULT NULL,
  `job_position` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `process_id` int NULL DEFAULT NULL,
  `status` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `date_updated` timestamp NOT NULL DEFAULT current_timestamp ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`status_id`) USING BTREE,
  INDEX `app_id`(`app_id` ASC) USING BTREE,
  CONSTRAINT `applicant_status_ibfk_1` FOREIGN KEY (`app_id`) REFERENCES `applicants` (`app_id`) ON DELETE RESTRICT ON UPDATE RESTRICT
) ENGINE = InnoDB AUTO_INCREMENT = 58 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of applicant_status
-- ----------------------------
INSERT INTO `applicant_status` VALUES (2, 6, NULL, 0, 'Pending', '2023-12-28 03:57:57');
INSERT INTO `applicant_status` VALUES (54, 7, NULL, 0, 'Pending', '2023-12-28 03:24:27');
INSERT INTO `applicant_status` VALUES (55, 8, NULL, 0, 'Pending', '2023-12-28 03:24:27');
INSERT INTO `applicant_status` VALUES (56, 9, NULL, 0, 'Pending', '2023-12-28 03:24:27');
INSERT INTO `applicant_status` VALUES (57, 10, NULL, 0, 'Pending', '2023-12-28 03:24:27');

-- ----------------------------
-- Table structure for applicants
-- ----------------------------
DROP TABLE IF EXISTS `applicants`;
CREATE TABLE `applicants`  (
  `app_id` int NOT NULL AUTO_INCREMENT,
  `firstname` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `middlename` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `lastname` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `gender` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `contact` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `address` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `cover_letter` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL,
  `job_id` int NULL DEFAULT NULL,
  `resume_path` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `process_id` int NULL DEFAULT NULL,
  `date_apply` date NULL DEFAULT NULL,
  PRIMARY KEY (`app_id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 14 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of applicants
-- ----------------------------
INSERT INTO `applicants` VALUES (6, 'Cherry Love', 'Flores', 'Gloria', 'female', 'labidc98@gmail.com', '09551391253', 'Pangantucan Bukidnon', 'letter', 2, 'Labid_CL Application & Resume.pdf', 0, '2023-12-26');
INSERT INTO `applicants` VALUES (7, 'Cherry Love', 'labid', 'Flores', 'female', 'labidc98@gmail.com', '09551391253', 'Pangantucan Bukidnon', 'dfs', 2, 'CHERRY LOVE G. LABID.docx', 0, '2023-12-26');
INSERT INTO `applicants` VALUES (8, 'April', 'May', 'June', 'male', 'June@gmail.com', '988456123', 'Valencia, Bukidnon', 'fafa', 2, 'CHERRY LOVE G. LABID.docx', 0, '2023-12-26');
INSERT INTO `applicants` VALUES (9, 'Love', 'Labid', 'Cherry', 'male', 'June@gmail.com', '988456123', 'Valencia, Bukidnon', 'love', 2, 'Labid_CL Application & Resume.pdf', 0, '2023-12-26');
INSERT INTO `applicants` VALUES (10, 'afas', 'a', 'as', 'female', 'asd@gmail.com', '4242', 'as', '', 3, '', 0, '2023-12-26');
INSERT INTO `applicants` VALUES (11, '', '', '', 'male', '', '', '', '', 1, '', NULL, '2023-12-28');
INSERT INTO `applicants` VALUES (12, '', '', '', 'male', '', '', '', '', 1, '', NULL, '2023-12-28');
INSERT INTO `applicants` VALUES (13, '', '', '', 'male', '', '', '', '', 1, '', NULL, '2023-12-28');

-- ----------------------------
-- Table structure for attendance
-- ----------------------------
DROP TABLE IF EXISTS `attendance`;
CREATE TABLE `attendance`  (
  `attendance_id` int NOT NULL AUTO_INCREMENT,
  `in_status` bit(1) NULL DEFAULT NULL,
  `in_time` timestamp NULL DEFAULT current_timestamp,
  `out_status` bit(1) NULL DEFAULT NULL,
  `out_time` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  `emp_id` int NULL DEFAULT NULL,
  `date` date GENERATED ALWAYS AS (cast(`in_time` as date)) VIRTUAL NULL,
  `dailyDuration` time GENERATED ALWAYS AS (timediff(`out_time`,`in_time`)) VIRTUAL NULL,
  PRIMARY KEY (`attendance_id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 10 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of attendance
-- ----------------------------
INSERT INTO `attendance` VALUES (1, b'1', '2023-12-26 00:04:15', b'1', '2023-12-26 12:58:16', 101, DEFAULT, DEFAULT);
INSERT INTO `attendance` VALUES (2, b'1', '2023-12-26 00:35:00', b'1', '2023-12-26 12:57:59', 102, DEFAULT, DEFAULT);
INSERT INTO `attendance` VALUES (3, b'1', '2023-12-26 02:06:42', b'1', '2023-12-26 02:07:31', 101, DEFAULT, DEFAULT);
INSERT INTO `attendance` VALUES (8, b'1', '2023-12-28 11:59:01', b'1', '2023-12-28 11:59:11', 101, DEFAULT, DEFAULT);
INSERT INTO `attendance` VALUES (9, b'1', '2023-12-28 12:39:45', b'1', '2023-12-28 12:50:03', 101, DEFAULT, DEFAULT);

-- ----------------------------
-- Table structure for careers
-- ----------------------------
DROP TABLE IF EXISTS `careers`;
CREATE TABLE `careers`  (
  `career_ID` int NOT NULL,
  `applicant_ID` int NULL DEFAULT NULL,
  `job_ID` int NULL DEFAULT NULL,
  PRIMARY KEY (`career_ID`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of careers
-- ----------------------------

-- ----------------------------
-- Table structure for deduction_details
-- ----------------------------
DROP TABLE IF EXISTS `deduction_details`;
CREATE TABLE `deduction_details`  (
  `deddetails_id` int NOT NULL AUTO_INCREMENT,
  `dedtype_id` int NULL DEFAULT NULL,
  `deduction_type` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `emppay_id` int NULL DEFAULT NULL,
  `amount` decimal(10, 2) NULL DEFAULT NULL,
  PRIMARY KEY (`deddetails_id`) USING BTREE,
  INDEX `dedtype_id`(`dedtype_id` ASC) USING BTREE,
  INDEX `emppay_id`(`emppay_id` ASC) USING BTREE,
  CONSTRAINT `deduction_details_ibfk_1` FOREIGN KEY (`dedtype_id`) REFERENCES `deduction_template` (`dedtype_id`) ON DELETE RESTRICT ON UPDATE RESTRICT
) ENGINE = InnoDB AUTO_INCREMENT = 67 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of deduction_details
-- ----------------------------
INSERT INTO `deduction_details` VALUES (39, 2, 'SSS', 97, 450.00);
INSERT INTO `deduction_details` VALUES (54, 3, 'PhilHealth', 97, 500.00);
INSERT INTO `deduction_details` VALUES (55, 3, 'PhilHealth', 98, 750.00);
INSERT INTO `deduction_details` VALUES (56, 4, 'PagIBIG', 97, 300.00);
INSERT INTO `deduction_details` VALUES (57, 4, 'PagIBIG', 98, 450.00);
INSERT INTO `deduction_details` VALUES (58, 2, 'SSS', 100, 675.00);
INSERT INTO `deduction_details` VALUES (59, 2, 'SSS', 99, 450.00);
INSERT INTO `deduction_details` VALUES (60, 4, 'PagIBIG', 99, 300.00);
INSERT INTO `deduction_details` VALUES (61, 2, 'SSS', 101, 562.50);
INSERT INTO `deduction_details` VALUES (62, 2, 'SSS', 102, 562.50);
INSERT INTO `deduction_details` VALUES (63, 3, 'PhilHealth', 101, 625.00);
INSERT INTO `deduction_details` VALUES (64, 3, 'PhilHealth', 102, 625.00);
INSERT INTO `deduction_details` VALUES (65, 4, 'PagIBIG', 101, 375.00);
INSERT INTO `deduction_details` VALUES (66, 4, 'PagIBIG', 102, 375.00);

-- ----------------------------
-- Table structure for deduction_template
-- ----------------------------
DROP TABLE IF EXISTS `deduction_template`;
CREATE TABLE `deduction_template`  (
  `dedtype_id` int NOT NULL AUTO_INCREMENT,
  `deduction_type` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `amount` decimal(10, 2) NULL DEFAULT NULL,
  `percentage_amount` decimal(5, 2) NULL DEFAULT NULL,
  PRIMARY KEY (`dedtype_id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 13 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of deduction_template
-- ----------------------------
INSERT INTO `deduction_template` VALUES (1, 'Tax', NULL, 12.00);
INSERT INTO `deduction_template` VALUES (2, 'SSS', NULL, 4.50);
INSERT INTO `deduction_template` VALUES (3, 'PhilHealth', NULL, 5.00);
INSERT INTO `deduction_template` VALUES (4, 'PagIBIG', NULL, 3.00);
INSERT INTO `deduction_template` VALUES (5, 'Salary Advance', NULL, NULL);
INSERT INTO `deduction_template` VALUES (6, 'Other', NULL, NULL);

-- ----------------------------
-- Table structure for disputes
-- ----------------------------
DROP TABLE IF EXISTS `disputes`;
CREATE TABLE `disputes`  (
  `disputes_ID` int NOT NULL,
  `payroll_ID` int NULL DEFAULT NULL,
  `emp_ID` int NULL DEFAULT NULL,
  `attachments` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `notes` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  PRIMARY KEY (`disputes_ID`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of disputes
-- ----------------------------

-- ----------------------------
-- Table structure for emp_history
-- ----------------------------
DROP TABLE IF EXISTS `emp_history`;
CREATE TABLE `emp_history`  (
  `hist_id` int NOT NULL AUTO_INCREMENT,
  `emp_id` int NULL DEFAULT NULL,
  `date` date NULL DEFAULT NULL,
  `position_id` int NULL DEFAULT NULL,
  `salary_rate` decimal(10, 2) NULL DEFAULT NULL,
  `status` enum('Active','Inactive') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT 'Active',
  PRIMARY KEY (`hist_id`) USING BTREE,
  INDEX `emp_id`(`emp_id` ASC) USING BTREE,
  INDEX `position_id`(`position_id` ASC) USING BTREE,
  CONSTRAINT `emp_history_ibfk_1` FOREIGN KEY (`emp_id`) REFERENCES `employee` (`emp_id`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  CONSTRAINT `emp_history_ibfk_2` FOREIGN KEY (`position_id`) REFERENCES `job_position` (`position_id`) ON DELETE RESTRICT ON UPDATE RESTRICT
) ENGINE = InnoDB AUTO_INCREMENT = 22 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of emp_history
-- ----------------------------
INSERT INTO `emp_history` VALUES (1, 101, '2023-12-01', 1, 20000.00, 'Inactive');
INSERT INTO `emp_history` VALUES (2, 102, '2023-12-05', 1, 20000.00, 'Inactive');
INSERT INTO `emp_history` VALUES (3, 101, '2023-12-12', 2, 21000.00, 'Inactive');
INSERT INTO `emp_history` VALUES (10, 101, '2023-12-13', 3, 25000.00, 'Inactive');
INSERT INTO `emp_history` VALUES (17, 101, '2023-12-18', 7, 30000.00, 'Inactive');
INSERT INTO `emp_history` VALUES (18, 102, '2023-12-13', 2, 21000.00, 'Inactive');
INSERT INTO `emp_history` VALUES (20, 101, '2023-12-26', 5, 25000.00, 'Active');
INSERT INTO `emp_history` VALUES (21, 102, '2023-12-26', 3, 25000.00, 'Active');

-- ----------------------------
-- Table structure for employee
-- ----------------------------
DROP TABLE IF EXISTS `employee`;
CREATE TABLE `employee`  (
  `emp_id` int NOT NULL AUTO_INCREMENT,
  `lname` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `fname` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `gender` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `birthdate` date NULL DEFAULT NULL,
  `contact_no` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `email` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `password` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `home_address` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `profile_img` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `start_date` date NULL DEFAULT NULL,
  `emp_type` enum('Full-time','Part-time') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `identity` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `position_id` int NULL DEFAULT NULL,
  `hrs_per_day` time NULL DEFAULT NULL,
  `employee_status` enum('Active','Resigned','Terminated') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT 'Active',
  `role` enum('HR','Payroll','Admin','Emp') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  PRIMARY KEY (`emp_id`) USING BTREE,
  INDEX `fk_employee_position_id`(`position_id` ASC) USING BTREE,
  CONSTRAINT `fk_employee_position_id` FOREIGN KEY (`position_id`) REFERENCES `job_position` (`position_id`) ON DELETE RESTRICT ON UPDATE RESTRICT
) ENGINE = InnoDB AUTO_INCREMENT = 130 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of employee
-- ----------------------------
INSERT INTO `employee` VALUES (101, 'Araneta', 'Humbeline', 'Female', '1998-05-01', '09751112222', 'clarizaraneta123@gmail.com', '123', '123 GSIS', NULL, '2023-11-21', 'Full-time', NULL, 5, '08:00:00', 'Active', 'Emp');
INSERT INTO `employee` VALUES (102, 'Ellarina', 'Johnnie', 'Male', '1997-12-03', '09234445555', 'johnnie.ellarina03@gmail.com', '123', 'Matina DC', NULL, '2023-10-01', 'Part-time', NULL, 3, '04:00:00', 'Active', 'Emp');
INSERT INTO `employee` VALUES (105, 'test2', 'test2', NULL, NULL, NULL, 'HR@gmail.com', 'hr', NULL, NULL, NULL, 'Full-time', NULL, 4, NULL, 'Active', 'HR');
INSERT INTO `employee` VALUES (106, 'payroll', 'payroll', NULL, NULL, NULL, 'payroll@gmail.com', 'payroll', NULL, NULL, NULL, 'Full-time', NULL, 4, NULL, 'Active', 'Payroll');
INSERT INTO `employee` VALUES (107, 'admin', 'admin', NULL, NULL, NULL, 'admin@gmail.com', 'admin', NULL, NULL, NULL, 'Full-time', NULL, 4, NULL, 'Active', 'Admin');
INSERT INTO `employee` VALUES (109, 'sample', 'sample', 'female', '2000-03-06', '1111111111', 'sampol@gmail.com', 'sampol', 'asdasdasdasdas', NULL, '2023-12-12', 'Full-time', NULL, NULL, '00:00:00', 'Active', 'Emp');
INSERT INTO `employee` VALUES (119, 'Lastname', 'Firstname', 'female', '2000-01-01', '09751001234', 'lastname@gmail.com', 'lastname', 'asdkhfsdhfhsdkfjsdhjfs', NULL, '2023-01-01', 'Full-time', NULL, 1, '04:00:00', 'Active', 'Emp');
INSERT INTO `employee` VALUES (120, 'Lastname', 'Firstname', 'female', '2000-01-01', '09751001234', 'lastname@gmail.com', 'lastname', 'asdkhfsdhfhsdkfjsdhjfs', NULL, '2023-01-01', 'Full-time', NULL, 1, '04:00:00', 'Active', 'Emp');
INSERT INTO `employee` VALUES (121, 'Lastname', 'Firstname', 'female', '2000-01-01', '09751001234', 'lastname@gmail.com', 'lastname', 'asdkhfsdhfhsdkfjsdhjfs', NULL, '2023-01-01', 'Full-time', NULL, 1, '04:00:00', 'Active', 'Emp');
INSERT INTO `employee` VALUES (122, 'Lastname', 'Firstname', 'female', '2000-01-01', '09751001234', 'lastname@gmail.com', 'lastname', 'asdkhfsdhfhsdkfjsdhjfs', NULL, '2023-01-01', 'Full-time', NULL, 1, '04:00:00', 'Active', 'Emp');
INSERT INTO `employee` VALUES (123, '', '', 'female', '0000-00-00', '', '', '', '', NULL, '0000-00-00', NULL, NULL, NULL, '04:00:00', 'Active', NULL);
INSERT INTO `employee` VALUES (124, '', '', 'female', '0000-00-00', '', '', '', '', NULL, '0000-00-00', NULL, NULL, NULL, '04:00:00', 'Active', NULL);
INSERT INTO `employee` VALUES (125, '', '', 'female', '0000-00-00', '', '', '', '', NULL, '0000-00-00', NULL, NULL, NULL, '04:00:00', 'Active', NULL);
INSERT INTO `employee` VALUES (126, '', '', 'female', '0000-00-00', '', '', '', '', NULL, '0000-00-00', NULL, NULL, NULL, '04:00:00', 'Active', NULL);
INSERT INTO `employee` VALUES (127, 'test', 'test', 'female', '0000-00-00', '123132123', 'test@asd.com', 'test', 'asdadsadasdas', NULL, '2009-01-01', 'Full-time', NULL, 1, '04:00:00', 'Active', 'Emp');
INSERT INTO `employee` VALUES (128, '', '', 'female', '1001-01-01', '', '', '', '', NULL, '0000-00-00', 'Full-time', NULL, 1, '08:00:00', 'Active', 'Emp');
INSERT INTO `employee` VALUES (129, '', '', 'female', '0000-00-00', '', '', '', '', NULL, '0000-00-00', 'Part-time', NULL, 1, '04:00:00', 'Active', 'Emp');

-- ----------------------------
-- Table structure for employee_payroll
-- ----------------------------
DROP TABLE IF EXISTS `employee_payroll`;
CREATE TABLE `employee_payroll`  (
  `emppay_id` int NOT NULL AUTO_INCREMENT,
  `emp_id` int NULL DEFAULT NULL,
  `lname` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `fname` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `period_id` int NULL DEFAULT NULL,
  `period_from` date NULL DEFAULT NULL,
  `period_to` date NULL DEFAULT NULL,
  `basic_salary` decimal(10, 2) NULL DEFAULT NULL,
  `required_hours` int NULL DEFAULT NULL,
  `hours_rendered` time NULL DEFAULT NULL,
  `deductions_total` decimal(10, 2) UNSIGNED NULL DEFAULT NULL,
  `status` enum('Incomplete','Completed') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT 'Incomplete',
  `date_generated` datetime NULL DEFAULT NULL,
  `ot_hrs` decimal(10, 2) GENERATED ALWAYS AS (time_to_sec(`hours_rendered`) / 3600 - `required_hours`) STORED NULL,
  `ot_rate` decimal(10, 2) NULL DEFAULT NULL,
  `ot_payment` decimal(10, 2) GENERATED ALWAYS AS (`ot_hrs` * `ot_rate`) STORED NULL,
  `gross_pay` decimal(10, 2) GENERATED ALWAYS AS (`ot_payment` + `basic_salary`) STORED NULL,
  `net_pay` decimal(10, 2) GENERATED ALWAYS AS (`gross_pay` - `deductions_total`) STORED NULL,
  PRIMARY KEY (`emppay_id`) USING BTREE,
  INDEX `emp_id`(`emp_id` ASC) USING BTREE,
  INDEX `period_id`(`required_hours` ASC) USING BTREE,
  CONSTRAINT `employee_payroll_ibfk_1` FOREIGN KEY (`emp_id`) REFERENCES `employee` (`emp_id`) ON DELETE RESTRICT ON UPDATE RESTRICT
) ENGINE = InnoDB AUTO_INCREMENT = 103 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of employee_payroll
-- ----------------------------
INSERT INTO `employee_payroll` VALUES (97, 101, 'Araneta', 'Humbeline', 2365, '2023-06-01', '2023-06-15', 10000.00, 88, '90:25:10', NULL, 'Incomplete', NULL, DEFAULT, 120.00, DEFAULT, DEFAULT, DEFAULT);
INSERT INTO `employee_payroll` VALUES (98, 102, 'Ellarina', 'Johnnie', 2365, '2023-06-01', '2023-06-15', 15000.00, 44, '16:35:00', NULL, 'Incomplete', NULL, DEFAULT, 175.00, DEFAULT, DEFAULT, DEFAULT);
INSERT INTO `employee_payroll` VALUES (99, 101, 'Araneta', 'Humbeline', 2367, '2023-06-01', '2023-06-15', 10000.00, 88, '90:25:10', 450.00, 'Incomplete', NULL, DEFAULT, 120.00, DEFAULT, DEFAULT, DEFAULT);
INSERT INTO `employee_payroll` VALUES (100, 102, 'Ellarina', 'Johnnie', 2367, '2023-06-01', '2023-06-15', 15000.00, 44, '16:35:00', 0.00, 'Incomplete', NULL, DEFAULT, 175.00, DEFAULT, DEFAULT, DEFAULT);
INSERT INTO `employee_payroll` VALUES (101, 101, 'Araneta', 'Humbeline', 2368, '2023-06-01', '2023-06-15', 12500.00, 88, '90:25:10', 1562.50, 'Incomplete', NULL, DEFAULT, 145.00, DEFAULT, DEFAULT, DEFAULT);
INSERT INTO `employee_payroll` VALUES (102, 102, 'Ellarina', 'Johnnie', 2368, '2023-06-01', '2023-06-15', 12500.00, 44, '16:35:00', 1562.50, 'Incomplete', NULL, DEFAULT, 145.00, DEFAULT, DEFAULT, DEFAULT);

-- ----------------------------
-- Table structure for job_department
-- ----------------------------
DROP TABLE IF EXISTS `job_department`;
CREATE TABLE `job_department`  (
  `dept_id` int NOT NULL AUTO_INCREMENT,
  `job_dept` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  PRIMARY KEY (`dept_id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 8 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of job_department
-- ----------------------------
INSERT INTO `job_department` VALUES (1, 'HR');
INSERT INTO `job_department` VALUES (2, 'Managerial');
INSERT INTO `job_department` VALUES (3, 'Marketing');
INSERT INTO `job_department` VALUES (4, 'IT');
INSERT INTO `job_department` VALUES (5, 'Virtual Assistant');
INSERT INTO `job_department` VALUES (6, 'Recruitment');
INSERT INTO `job_department` VALUES (7, 'Sample2');

-- ----------------------------
-- Table structure for job_position
-- ----------------------------
DROP TABLE IF EXISTS `job_position`;
CREATE TABLE `job_position`  (
  `position_id` int NOT NULL AUTO_INCREMENT,
  `position_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `job_description` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL,
  `salary_rate` decimal(10, 2) NULL DEFAULT NULL,
  `dept_id` int NOT NULL,
  `hourly_rate` decimal(10, 2) GENERATED ALWAYS AS (`salary_rate` / 22 / 8) STORED NULL,
  `ot_rate` decimal(10, 2) GENERATED ALWAYS AS (floor((`hourly_rate` + 4) / 5) * 5) VIRTUAL NULL,
  PRIMARY KEY (`position_id`) USING BTREE,
  INDEX `dept_id`(`dept_id` ASC) USING BTREE,
  CONSTRAINT `fk_dept_id` FOREIGN KEY (`dept_id`) REFERENCES `job_department` (`dept_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE = InnoDB AUTO_INCREMENT = 18 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of job_position
-- ----------------------------
INSERT INTO `job_position` VALUES (1, 'Virtual Assistant 1', 'Sample', 20000.00, 5, DEFAULT, DEFAULT);
INSERT INTO `job_position` VALUES (2, 'Virtual Assistant 2', 'Test', 21000.00, 5, DEFAULT, DEFAULT);
INSERT INTO `job_position` VALUES (3, 'Virtual Assistant 3', 'Roles and Responsibilities:\r\n\r\nRecruitment and Onboarding:\r\n\r\nParticipate in the recruitment process, including resume screening and interviews.\r\nFacilitate new employee onboarding, including orientation and documentation.\r\nEmployee Relations:\r\n\r\nAddress employee queries and concerns regarding HR policies and procedures.\r\nConduct investigations and resolve workplace issues.\r\nPerformance Management:\r\n\r\nCoordinate performance review processes and provide support to managers.\r\nAssist in the development and implementation of performance improvement plans.\r\nTraining and Development:\r\n\r\nIdentify training needs and coordinate employee training programs.\r\nSupport career development initiatives and succession planning.\r\nHR Policy Development:\r\n\r\nContribute to the development and updating of HR policies and procedures.\r\nEnsure company-wide understanding and compliance with policies.\r\nEmployee Engagement:\r\n\r\nPlan and execute employee engagement activities and events.\r\nMonitor and improve employee satisfaction and morale.\r\nBenefits Administration:\r\n\r\nAdminister employee benefits programs and communicate changes to employees.\r\nAssist employees with benefit-related inquiries.\r\nHR Data Management:\r\n\r\nMaintain accurate employee records and HR databases.\r\nGenerate HR reports and analytics as needed.\r\nCompliance:\r\n\r\nEnsure compliance with employment laws and regulations.\r\nAssist in audits related to HR functions.\r\nConflict Resolution:\r\n\r\nMediate and resolve conflicts between employees or departments.\r\nProvide guidance on conflict resolution strategies.\r\nHealth and Safety:\r\n\r\nCollaborate with relevant stakeholders to ensure a safe and healthy work environment.\r\nImplement and monitor health and safety policies.\r\nQualifications:\r\n\r\nBachelor\'s degree in Human Resources, Business, or related field.\r\nProven experience as an HR Generalist or in a similar role.\r\nKnowledge of HR laws, regulations, and best practices.\r\nStrong interpersonal and communication skills.', 25000.00, 5, DEFAULT, DEFAULT);
INSERT INTO `job_position` VALUES (4, 'Recruiter 1', 'Roles and Responsibilities:\r\n\r\nStrategic Planning:\r\n\r\nContribute to the development and execution of organizational strategies.\r\nAlign operations with company goals and objectives.\r\nTeam Management:\r\n\r\nSupervise and lead a team of operations staff.\r\nSet performance goals, conduct performance reviews, and provide feedback.\r\nProcess Improvement:\r\n\r\nIdentify opportunities for operational efficiency and process improvement.\r\nImplement and monitor streamlined workflows.\r\nResource Allocation:\r\n\r\nManage resources, including budget, personnel, and equipment.\r\nOptimize resource allocation to meet operational objectives.\r\nQuality Control:\r\n\r\nEstablish and maintain quality control standards.\r\nMonitor and evaluate operational performance against quality metrics.\r\nSupply Chain Management:\r\n\r\nOversee the supply chain process, including procurement and inventory management.\r\nBuild relationships with vendors and negotiate contracts.\r\nRisk Management:\r\n\r\nIdentify and mitigate operational risks.\r\nDevelop and implement risk management strategies.\r\nCustomer Satisfaction:\r\n\r\nMonitor customer feedback and implement improvements based on customer needs.\r\nEnsure a positive customer experience throughout the operational process.\r\nCompliance:\r\n\r\nEnsure compliance with industry regulations and standards.\r\nStay informed about changes in regulations affecting operations.\r\nTechnology Integration:\r\n\r\nIdentify and implement relevant technologies to enhance operational efficiency.\r\nCollaborate with IT teams for system integration and upgrades.\r\nEmergency Response Planning:\r\n\r\nDevelop and maintain emergency response and business continuity plans.\r\nEnsure readiness for potential disruptions.\r\nQualifications:\r\n\r\nBachelor\'s degree in Business, Operations Management, or related field.\r\nProven experience in operations management.\r\nStrong leadership and decision-making skills.\r\nExcellent analytical and problem-solving abilities.', 20000.00, 6, DEFAULT, DEFAULT);
INSERT INTO `job_position` VALUES (5, 'Recruiter 2', 'Test', 25000.00, 6, DEFAULT, DEFAULT);
INSERT INTO `job_position` VALUES (6, 'Recruiter 3', 'Roles and Responsibilities:\r\n\r\nPayroll Processing:\r\n\r\nManage end-to-end payroll processing, ensuring accuracy and timeliness.\r\nCalculate and process employee salaries, bonuses, and deductions.\r\nCompliance:\r\n\r\nStay updated on payroll laws and regulations to ensure compliance.\r\nPrepare and submit payroll tax returns in a timely manner.\r\nRecord Keeping:\r\n\r\nMaintain accurate records of employee earnings, benefits, and deductions.\r\nEnsure confidentiality and security of payroll information.\r\nPayroll Reporting:\r\n\r\nGenerate and analyze payroll reports for management and accounting purposes.\r\nPrepare reports on payroll costs, overtime, and other relevant metrics.\r\nBenefits Administration:\r\n\r\nAdminister employee benefits programs related to payroll, such as health insurance and retirement plans.\r\nAssist employees with benefit-related inquiries.\r\nCommunication:\r\n\r\nCommunicate with employees regarding payroll-related matters and address any concerns.\r\nCollaborate with the HR department on payroll and benefits communication.\r\nPayroll System Management:\r\n\r\nOversee the implementation and maintenance of payroll software and systems.\r\nProvide training to employees on using self-service portals.\r\nYear-End Activities:\r\n\r\nPrepare and distribute annual tax forms (W-2, 1099, etc.).\r\nAssist in year-end reconciliation and reporting.\r\nAudit Support:\r\n\r\nSupport internal and external audits related to payroll.\r\nEnsure accuracy and completeness of payroll records.\r\nContinuous Improvement:\r\n\r\nIdentify opportunities for process improvements in payroll operations.\r\nStay informed about payroll technology trends and recommend updates.\r\nQualifications:\r\n\r\nBachelor\'s degree in Accounting, Finance, or related field.\r\nProven experience in payroll processing and administration.\r\nKnowledge of payroll software and tax regulations.\r\nStrong attention to detail and analytical skills.', 30000.00, 6, DEFAULT, DEFAULT);
INSERT INTO `job_position` VALUES (7, 'Virtual Assistant 4', 'dsadasdsadasda', 30000.00, 5, DEFAULT, DEFAULT);

-- ----------------------------
-- Table structure for jobs
-- ----------------------------
DROP TABLE IF EXISTS `jobs`;
CREATE TABLE `jobs`  (
  `job_id` int NOT NULL AUTO_INCREMENT,
  `job_title` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `description` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL,
  `qualification` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `person_need` int NULL DEFAULT NULL,
  `salary` decimal(10, 2) NULL DEFAULT NULL,
  `published` bit(1) NULL DEFAULT NULL,
  `date_published` datetime NULL DEFAULT current_timestamp,
  PRIMARY KEY (`job_id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 8 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of jobs
-- ----------------------------
INSERT INTO `jobs` VALUES (1, 'Payroll Specialist', 'Experienced Payroll Specialist adept at managing end-to-end payroll processes with precision and efficiency. Holds a bachelor\'s degree in Accounting and brings a proven track record in tax compliance, using cutting-edge payroll software, and ensuring accuracy in financial transactions. Strong attention to detail, excellent communication skills, and a commitment to maintaining confidentiality. Proficient in Microsoft Excel and dedicated to providing top-notch customer service. A reliable professional with a keen understanding of evolving payroll regulations and a focus on contributing to organizational success.', 'Qualified payroll specialist with a bachelor\'s degree in Accounting or related field. \r\n Excellent communication skills and a commitment to maintaining confidentiality.\r\nProficient in relevant software, including Microsoft Excel. \r\nAdept at problem-solvin', 10, 20000.00, b'1', '2023-12-26 03:26:57');
INSERT INTO `jobs` VALUES (2, 'Recruiter', 'A Recruiter is a professional responsible for identifying, attracting, and hiring qualified candidates to fill job vacancies within an organization. Recruiters work in various industries and are employed either in-house by a company or by external recruitment agencies. Their primary goal is to source the right talent to meet the staffing needs of the organization.', 'Collaborate with hiring managers to understand the requirements of each job opening and create detailed job descriptions.\r\nConduct in-depth interviews to evaluate a candidate\'s skills, experience, and cultural fit within the organization.\r\n\r\nCollaborate w', 10, 30000.00, b'1', '2023-12-26 03:28:26');
INSERT INTO `jobs` VALUES (3, 'Virtual Assistant', 'A Virtual Assistant (VA) is a professional who provides administrative, technical, or creative support to clients from a remote location. Virtual assistants leverage technology to collaborate with clients and perform various tasks, allowing them to focus on their core responsibilities. VAs are often self-employed or work as part of virtual assistant agencies, offering a range of services to individuals, entrepreneurs, small businesses, and even larger enterprises.', 'Administrative Support, Customer Service, Social Media Management', 5, 40000.00, b'1', '2023-12-26 03:29:40');

-- ----------------------------
-- Table structure for leave
-- ----------------------------
DROP TABLE IF EXISTS `leave`;
CREATE TABLE `leave`  (
  `leave_ID` int NOT NULL,
  `emp_ID` int NULL DEFAULT NULL,
  `date` datetime NULL DEFAULT NULL,
  `type` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `leaveDate` datetime NULL DEFAULT NULL,
  `reason` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `attachments` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `status` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  PRIMARY KEY (`leave_ID`) USING BTREE,
  INDEX `fk_leave_emp_id`(`emp_ID` ASC) USING BTREE,
  CONSTRAINT `fk_leave_emp_id` FOREIGN KEY (`emp_ID`) REFERENCES `employee` (`emp_id`) ON DELETE RESTRICT ON UPDATE RESTRICT
) ENGINE = InnoDB CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of leave
-- ----------------------------

-- ----------------------------
-- Table structure for payroll_period
-- ----------------------------
DROP TABLE IF EXISTS `payroll_period`;
CREATE TABLE `payroll_period`  (
  `period_id` int NOT NULL AUTO_INCREMENT,
  `period_from` date NOT NULL,
  `period_to` date NULL DEFAULT NULL,
  `period_type` enum('Semi-monthly','Monthly') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `total` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `date_generated` datetime NULL DEFAULT NULL,
  `status` enum('Open','Completed','Paid') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT 'Open',
  PRIMARY KEY (`period_id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 2369 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of payroll_period
-- ----------------------------
INSERT INTO `payroll_period` VALUES (2365, '2023-06-01', '2023-06-15', 'Semi-monthly', NULL, '2023-12-20 03:46:12', 'Open');
INSERT INTO `payroll_period` VALUES (2367, '2023-06-01', '2023-06-15', 'Semi-monthly', NULL, '2023-12-25 10:16:59', 'Open');
INSERT INTO `payroll_period` VALUES (2368, '2023-06-01', '2023-06-15', 'Semi-monthly', NULL, '2023-12-25 19:44:06', 'Open');

-- ----------------------------
-- View structure for payroll_view
-- ----------------------------
DROP VIEW IF EXISTS `payroll_view`;
CREATE ALGORITHM = UNDEFINED SQL SECURITY DEFINER VIEW `payroll_view` AS SELECT
    ep.emp_id,
    ep.payroll_id,
    a.attendance_id,
    a.dailyDuration,
    a.ot_hours
FROM
    employee_payroll ep
JOIN
    attendance a ON ep.emp_id = a.emp_id ;

SET FOREIGN_KEY_CHECKS = 1;
