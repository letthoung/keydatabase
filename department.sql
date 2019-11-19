-- phpMyAdmin SQL Dump
-- version 4.4.14.1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Nov 18, 2019 at 01:47 PM
-- Server version: 5.5.64-MariaDB
-- PHP Version: 7.1.0beta1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `ezdslim30004`
--

-- --------------------------------------------------------

--
-- Table structure for table `department`
--

CREATE TABLE IF NOT EXISTS `department` (
  `id` int(100) NOT NULL,
  `idlink` int(100) NOT NULL,
  `dep` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `costcenter` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `empbld` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `emprm` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `name` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `phone` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `name2` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `email2` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `phone2` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `chair` varchar(150) COLLATE utf8_unicode_ci NOT NULL,
  `dean` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `provost` varchar(100) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=177 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `department`
--

INSERT INTO `department` (`id`, `idlink`, `dep`, `costcenter`, `empbld`, `emprm`, `name`, `email`, `phone`, `name2`, `email2`, `phone2`, `chair`, `dean`, `provost`) VALUES
(1, 4, 'ACCOUNTING & BUSINESS LAW', '236130001', 'BAC', '375', 'Jillian Ross', 'rossj1@nku.edu', '859-572-6526', '', '', '', 'Robert Russ', 'Rebecca Porterfieild', 'Sue Ott Rowlands'),
(2, 1, 'ACCOUNTS PAYABLE', '213020001', 'AC', '605', 'Russ Kerdoff', 'kerdolff@nku.edu', '859-572-6445', '', '', '', 'Russ Kerdoff', 'N/A', 'Mike Hales'),
(3, 5, 'ADMINISTRATION & FINANCE', '202001001', 'AC', '812', 'Mary Beth Barry', 'barrym3@nku.edu', '859-572-5349', 'Tony Wice', 'wicet1@nku.edu', '859-572-5124', 'Sue Hodges Moore', 'N/A', 'Mike Hales'),
(4, 6, 'ADMISSIONS', '241010001', 'AC', '400', 'Rebecca Sherman', 'shermanr1@nku.edu', '859-572-6074', '', '', '', 'Melissa Gorbandt', 'Kimberly Scranage', 'Sue Ott Rowlands'),
(5, 7, 'ADVANCED NURSING STUDIES', '239050010', 'FH/HE', '455', 'Eleanor Ralenkotter', 'ralenkotte2@nku.edu', '859-572-5246', '', '', '', 'Maureen Krebs', 'Dale Stephenson', 'Sue Ott Rowlands'),
(6, 8, 'ADVANCEMENT SERVICES', '281010005', 'AC', '239', 'Karen Young', 'youngk2@nku.edu', '859-572-7709', '', '', '', 'Marilou Singleton', 'N/A', 'Eric Gentry'),
(7, 9, 'AFRICAN AMERICAN PROGRAMS AND SERVICES', '270010005', 'SU', '303', 'Tracy Stokes', 'stokest2@nku.edu', '859-572-5214', '', '', '', 'Tracy Stokes', 'Dannie Moore', 'Dan Nadler'),
(8, 9, 'AFRICAN AMERICAN STUDENT AFFAIRS', '270010500', 'SU', '303', 'Laura Dektas', 'dektasl1@nku.edu', '859-572-5401', '', '', '', 'Tracy Stokes', 'N/A', 'Dan Nadler'),
(9, 10, 'ALLCARD ADMINISTRATION', '210020005', 'SU', '120', 'Ward Wenstrup', 'wenstrupc1@nku.edu', '859-572-1344', 'Madeline Rumker', 'Rmkerm1@nku.edu', '859-572-6016', 'N/A', 'Andy Meeks', 'Mike Hales'),
(10, 11, 'ALLIED HEALTH', '239030001', 'HC', '227', 'Eleanor Ralenkotter', 'ralenkotte2@nku.edu', '859-572-7964', '', '', '', 'Maureen Krebs', 'Dale Stephenson', 'Sue Ott Rowlands'),
(11, 12, 'ATHLETICS', '272010010', 'HC', '244', 'Heather Promer', 'Promerh1@nku.edu', '7859', 'Chris Hafling', 'haflingc1@nku.edu', '859-572-7665', 'Dan McIver', 'Dan McIver', 'Dan McIver'),
(12, 13, 'BIOLOGICAL SCIENCES', '235020001', 'SC', '204D', 'Vickie Hugo', 'hugov@nku.edu', '859-572-5110', 'Beth Sweeney', 'sweeneyb1@nku.edu', '859-572-5307', 'Patrick Schultheis', 'Diana Mcgill', 'Sue Ott Rowlands'),
(13, 14, 'BUDGET OFFICE', '206010005', 'AC', '501', 'Mayme Chow', 'chowm@nku.edu', '859-572-5345', '', '', '', 'Angie Schaffer', 'Chandra Brown', 'Mike Hales'),
(14, 15, 'BURSAR', '213030001', 'AC', '235', 'Karen Merkle', 'merkle@nku.edu', '859-572-5205', '', '', '', 'Kim Grabowsky', 'Mike Hales', 'Mike Hales'),
(15, 16, 'BUSINESS INFORMATICS', '238030001', 'GH', '400F', 'Sue Murphy Angel', 'murphyl1@nku.edu', '859-572-7732', '', '', '', 'Frank Baun', 'Kevin Kirby', 'Sue Ott Rowlands'),
(16, 17, 'BUSINESS SERVICES', '210010005', 'AC', '616A', 'Carole Gibson', 'gibsoncar@nku.edu', '859-572-1904', '', '', '', 'Andy Meeks', 'N/A', 'Mike Hales'),
(17, 114, 'PLANNING, DESIGN, CONSTRUCTION', '211020001', 'AC', '726', 'Allison Greer', 'greera1@nku.edu', '859-572-5120', '', '', '', 'Mary Paula Schuh', 'Syed Zaidi', 'Mike Hales'),
(19, 19, 'CAREER SERVICES', '271010005', 'UC', '230', 'Sydney Gebka', 'gebkas2@nku.edu', '859-572-5680', '', '', '', 'Bill Froude', 'Kim Scranage', 'Sue Ott Rowlands'),
(20, 20, 'CENTER FOR APPLIED INFORMATICS', '238050010', 'GH', '330', 'Tina Altenhofen', 'altenhof@nku.edu', '859-572-7689', '', '', '', 'Jill Henry', 'Kevin Kirby', 'Sue Ott Rowlands'),
(21, 21, 'CENTER FOR ECONOMIC ANALYSIS AND DEVELOPMENT', '230001015', 'BAC', '323', 'Susan Ryman', 'rymans1@nku.edu', '859-572-2413', '', '', '', 'Janet Harrah', 'Rebecca Porterfield', 'Sue Ott Rowlands'),
(22, 22, 'CENTER FOR GLOBAL ENGAGEMENT ', '245001005', 'NH', '309', 'Toni Schneller', 'schnellert1@nku.edu', '859-572-8984', '', '', '', 'Francois LeRoy', 'Francois LeRoy', 'Sue Ott Rowlands'),
(23, 23, 'CENTER FOR INNOVATION & ENTREPRENEURSHIP', '236030001', 'BAC', '350', 'Sally Allen', 'allens@nku.edu', '859-572-5931', '', '', '', 'Rodney D''Souza', 'Rebecca Porterfield', 'Sue Ott Rowlands'),
(24, 25, 'CENTER OF ENVIORMENTAL RESTORATION', '235140002', 'CLRV', '15', 'Kim Tromm', 'trommk@nku.edu', '859-572-8949', 'Nancy Meyer', 'meyerna@nku.edu', '', 'Scott Fennell', 'Samantha Langley-Turnbaugh', 'Sue Ott Rowlands'),
(25, 26, 'CHASE - MOOT COURT', '234010502', 'NH', '554', 'Sherrie Turner', 'turnersh@nku.edu', '859-572-6407', '', '', '', 'Michael Whitman', 'Lawrence Rosenthal', 'Sue Ott Rowlands'),
(26, 26, 'CHASE COLLEGE OF LAW', '234010001', 'NH', '554', 'Sherrie Turner', 'turnersh@nku.edu', '859-572-6407', '', '', '', 'Michael Whitman', 'Lawrence Rosenthal', 'Sue Ott Rowlands'),
(27, 27, 'CHEMISTRY', '235030001', 'SC', '204F', 'Kim Yankovsky', 'yankovskyc1@nku.edu', '859-572-5409', '', '', '', 'Keith Walters', 'Diana McGill', 'Sue Ott Rowlands'),
(28, 29, 'CINSAM', '235150001', 'LA', '130', 'Kelli Rieskamp', 'rieskampk1@nku.edu', '859-572-5381', '', '', '', 'Madhura Kulkarni', 'Diana McGill', 'Sue Ott Rowlands'),
(29, 29, 'CITE', '233020005', 'SL', '508', 'Sherry Cuchiara', 'cucchiara@nku.edu', '859-572-5348', '', '', '', 'Jeffrey Chesnut', 'Arne Almquist', 'Sue Ott Rowlands'),
(30, 30, 'COB ADVISING CENTER', '236001020', 'BAC', '206', 'Rebecca Cox', 'coxr1@nku.edu', '859-572-7902', '', '', '', 'Jessica Ferguson', 'Rebecca Porterfield', 'Sue Ott Rowlands'),
(31, 31, 'COI-ADVISING CENTER', '238001015', 'GH', '404', 'Kara Thompson', 'thompsonk14@nku.edu', '859-572-7726', '', '', '', 'Rebecca Walker', 'Kevin Kirby', 'Sue Ott Rowlands'),
(32, 32, 'COLLEGE OF HEALTH AND HUMAN SERVICES', '239001001', 'FH/HE', '455', 'Eleanor Ralenkotter', 'Ralenkottere2@nku.edu', '859-572-5347', '', '', '', 'Maureen Krebs', 'Dale Stephenson', 'Mike Hales'),
(33, 33, 'COLLEGE OF INFORMATICS', '238001005', 'GH', '565, 500A', 'Sue Murphy Angel', 'murphyl1@nku.edu', '859-572-7732', 'Pam Wagar', 'wagarp@nku.edu', '859-572-5569', 'Pam Wagar', 'Kevin Kirby', 'Sue Ott Rowlands'),
(34, 34, 'COMMUNICATIONS', '238010502', 'GH', '400C', 'Sue Murphy Angel', 'murphyl1@nku.edu', '859-572-7732', 'Pam Wagar', 'wagarp@nku.edu', '859-572-5569', 'Zachary Hart', 'Kevin Kirby', 'Sue Ott Rowlands'),
(35, 35, 'COMMUNITY CONNECTIONS', '242030001', 'SL', '250', 'Melinda Spong', 'spongm1@nku.edu', '859-572-1464', '', '', '', 'Melinda Spong', 'Arne Almquist', 'Sue Ott Rowlands'),
(36, 2, 'COMPTROLLER', '213010001', 'AC', '605', 'Russ Kerdolff', 'kerdolff@nku.edu', '859-572-6455', '', '', '', 'Russ Kerdolff', 'Mike Hales', 'Mike Hales'),
(37, 37, 'COMPUTER SCIENCE', '238020500', 'GH', '400', 'Sue Murphy Angel', 'murphyl1@nku.edu', '859-572-7732', '', '', '', 'Maureen Doyle', 'Kevin Kirby', 'Sue Ott Rowlands'),
(38, 38, 'CONFERENCE MANAGEMENT', '210030005', 'SU', '112', 'Amanda Steinbrunner', 'steinbrunnea@nku.edu', '859-572-6502', '', '', '', 'Amanda Steinbrunner', 'N/A', 'Mike Hales'),
(39, 39, 'COUNSELING, SOCIAL WORK, ', '237030001', 'MEP', '213', 'Melanie Hall', 'hallm10@nku.edu', '859- 572-5604', '', '', '', 'Verl Pope', 'Cynthia Reed', 'Sue Ott Rowlands'),
(40, 40, 'DEAN- COLLEGE OF ARTS & SCIENCES', '235001005', 'SL', '410', 'Annette Pendery', 'penderya@nku.edu', '859-572-5860', '', '', '', 'N/A', 'Diana McGill', 'Sue Ott Rowlands'),
(41, 41, 'DEAN- COLLEGE OF BUSINESS', '236001005', 'BAC', '305B', 'Beth McCubbin', 'mccubbine2@nku.edu', '859-572-5551', '', '', '', 'N/A', 'Rebecca Porterfield', 'Sue Ott Rowlands'),
(42, 42, 'DEAN- COLLEGE OF EDUCATION ', '237001005', 'MEP', '218', 'Sheila Rubin', 'ruarksh@nku.edu', '(859) 572-5373 ', '', '', '', 'N/A', 'Alar Lipping', 'Sue Ott Rowlands'),
(43, 43, 'DEVELOPMENTAL MATH', '231030001', 'MEP', '411', 'Mary Golden', 'goldenm@nku.edu', '859-572-6347', '', '', '', 'Diane Williams', 'Ande Durojaiye', 'Sue Ott Rowlands'),
(44, 44, 'DISABILITY PROGRAMS & SERVICES', '270080010', 'SU', '303', 'Laura Dektas', 'dektasl1@nku.edu', '859-572-5401', '', '', '', 'Cindy Knox', 'Dannie Moore', 'Dan Nadler'),
(46, 45, 'EARLY CHILD CARE', '011-000-100', 'MEP', '147', 'Audrey Wilson', 'wilsona34@nku.edu', '859-572-1391', '', '', '', 'Audrey Wilson', 'MEG COWHERD**', ''),
(47, 46, 'ECONOMICS & FINANCE', '236020001', 'BAC', '376', 'Rebecca Cox', 'coxr1@nku.edu', '859-572-5441', '', '', '', 'J.C. THOMPSON', 'Rebecca Porterfield', 'Sue Ott Rowlands'),
(48, 47, 'EDUCATION ABROAD', '243050010', 'UC', '305', 'Michele Melish', 'melishm1@nku.edu', '859-572-6194', '', '', '', 'Michele Melish', 'Samantha Langley-Turnbaugh', 'Sue Ott Rowlands'),
(49, 48, 'EDUCATIONAL TALENT SEARCH', '5', 'CLR', '10', 'Lisa Brinkman', 'brinkman@nku.edu', '859-572-8942', '', '', '', 'Lisa Brinkman', 'Dannie Moore', 'Dan NaDLER'),
(50, 49, 'ENGLISH', '235190001', 'LA', '500', 'Julie Hess', 'hess@nku.edu', '859-572-5507', '', '', '', 'John Alberti', 'Diana McGill', 'Sue Ott Rowlands'),
(51, 50, 'ENROLLMENT', '241001001', 'AC', '405A', 'Tori Patrick', 'tori.patrick@nku.edu', '859-572-1485', '', '', '', 'Leah Stewart', 'Kim Scranage', 'Sue Ott Rowlands'),
(52, 51, 'EXECUTIVE LEADERSHIP ', '236040020', 'BAC', '363', 'Amberly Nutini', 'hurstam@nku.edu', '859-572-5947', '', '', '', 'Karen Miller', 'Diana McGill', 'Sue Ott Rowlands'),
(53, 52, 'FACILITIES MANAGEMENT', '211010001', 'AC', '726', 'Amy Emmett', 'emmetta2@nku.edu', '859-572-1927', '', '', '', 'N/A', 'Syed Zaidi', 'Mike Hales'),
(54, 53, 'FACULTY SENATE', '293060060', 'AC', '105', 'Grace Hiles', 'hilesg1@nku.edu', '859-572-6400', '', '', '', 'Grace Hiles', 'N/A', 'Diana McGill'),
(55, 54, 'FINANCE & OPERATIONAL AUDITING', '202010001', 'AC', '504', 'Larry Meyer', 'meyerl3@nku.edu', '859-572-6117', '', '', '', 'Larry Meyer', 'Sara B. Kelly', 'Joan M. Gates'),
(56, 55, 'FINANCIAL ASSISTANCE', '241030001', 'AC', '416', 'Pam Stevens', 'stevensp2@nku.edu', '859-572-5144', '', '', '', 'Leah Stewart', 'Kim Scranage', 'Sue Ott Rowlands'),
(57, 56, 'FINE ARTS EVENTS', '235130010', 'FA', '214', 'Rick Endres', 'endresr1@nku.edu', '859-572-5433', '', '', '', 'Rick Endres', 'Diana McGill', 'Sue Ott Rowlands'),
(58, 57, 'FIRST YEAR PROGRAMS', '231040005', 'UC', '122', 'Jeanne Pettit', 'pettitje@nku.edu', '859-572-7544', '', '', '', 'Jeanne Pettit', 'Ande Durojaiye', 'Sue Ott Rowlands'),
(59, 58, 'FRATERNITY & SORORITY LIFE', '270111005', 'SU', '301', 'Kim Vance', 'vanceki@nku.edu', '859-572-5146', '', '', '', 'Kim Vance', 'Arnie Slaughter', 'Dan Nadler'),
(60, 61, 'GOVERNMENT CORPORATE ', '209040001', 'AC', '818', 'Katie Schuler', 'schulerk5@nku.edu', '859-572-5916', '', '', '', 'N/A', 'Adam Caswell', 'Eric Gentry'),
(62, 62, 'GRADUATE PROGRAMS', '242050005', 'AC', '302', 'Peggy Allen', 'allenp1@nku.edu', '859-572-6364', '', '', '', 'Christian Gamm', 'Samantha Langley-Turnbaugh', 'Sue Ott Rowlands'),
(63, 63, 'GREEK LIFE', '270050035', 'SU', '301', 'Kim Vance', 'vanceki@nku.edu', '859-572-5146', '', '', '', 'Kim Vance', 'Arnie Slaughter', 'Dan Nadler'),
(64, 64, 'HEALTH SCIENCE', '239030005', 'HC', '236', 'Eleanor Ralenkotter', 'ralenkottere1@nku.edu', '859-572-7964', '', '', '', 'Maureen Krebs', 'Dale Stephenson', 'Sue Ott RowlandsSue Ott Rowlands'),
(65, 65, 'HEALTH, COUNSELING & STUDENT WELLNESS', '270030005', 'UC', '440', 'Christina Blackburn', 'blackburnc4@nku.edu', '859-572-5650', '', '', '', 'Lisa A. Barresi', 'Dannie Moore', 'Dan Nadler'),
(66, 66, 'HISTORY & GEOGRAPHY', '235040001', 'LA', '415, 415B', 'Lou Stuntz', 'stuntzl@nku.edu', '859-572-5461', 'Jan Rachford', 'rachford@nku.edu', '859-572-5287', 'Burke Miller', 'Diana McGill', 'Sue Ott Rowlands'),
(67, 67, 'HONORS PROGRAM', '240010505', 'FH/HE', '295', 'Brittany Smith', 'smithb18@nku.edu', '859-572-5400', '', '', '', 'Belle Zembrod', 'Ande Durojaiye', 'Sue Ott Rowlands'),
(68, 68, 'HUMAN RESOURCES', '212010005', 'AC', '708, 709', 'Lindsey Christian', 'christianl2@nku.edu', '859-572-6384', '', '', '', 'Rachel Green', 'Lori Southwood', 'Mike Hales'),
(69, 69, 'INCLUSIVE EXCELLENCE', '231005001', 'AC', '834', 'Diane Maldonado', 'maldonadod1@nku.edu', '859-572-6981', '', '', '', 'N/A', 'N/A', 'Kathleen Roberts'),
(70, 70, 'INFORMATION TECHNOLOGY', '232001005', 'AC', '507', 'Velinda Vandegeer', 'vandegeerv1@nku.edu', '859-572-5271', 'Martie Wheeler', 'wheelerm2@nku.edu', '859-572-5973', 'Bert Brown', 'Timothy Ferguson', 'Mike Hales'),
(71, 74, 'INTERNATIONAL STUDENTS ', '27102001', 'UC', '305', 'Toni Schneller', 'schnellert@nku.du', '859-572-7954', '', '', '', 'Rebecca Hansen', 'Francois LeRoy', 'Sue Ott Rowlands'),
(72, 75, 'JAPANESE LANGUAGE SCHOOL', '290050540', 'SU', '112', 'Amanda Steinbrunner', 'steinbrunnea@nku.edu', '859-572-6502', '', '', '', 'Amanda Steinbrunner', 'N/A', 'Sue Ott Rowlands'),
(73, 77, 'KINESIOLOGY ', '237020001', 'HC', '206', 'Annette Shummard', 'shumarda1@nku.edu', '859-572-6557', '', '', '', 'Alar Lipping', 'Cynthia Reed', 'Sue Ott Rowlands'),
(74, 76, 'KENTUCKY CAMPUS COMPACT', '298020010', 'CA', '270', 'Darlene Ryan', 'ryand6@nku.edu', '859-572-7837', '', '', '', 'Meredith Dean', 'Gayle Hilleke', 'Sue Ott Rowlands'),
(76, 78, 'KY CENTER FOR MATH', '235060010', 'CA', '220', 'Paula Seta', 'stapletonp1@nku.edu', '859-572-6339', '', '', '', 'Meredith Brewer', 'Diana McGill', 'Sue Ott Rowlands'),
(77, 79, 'LATINO PROGRAMS & SERVICES', '270040001', 'SU', '315', 'Leo Calderon', 'calderon@nku.edu', '859-572-5821', '', '', '', 'Leo Calderon', 'Danie Moore', 'Dan Nadler'),
(78, 80, 'LAW LIBRARY', '234020002', 'NH', '201A', 'Jane Underwood', 'Jane Underwood', '859-572-6485', '', '', '', 'Thomas Heard', 'TBA', 'Sue Ott Rowlands'),
(79, 81, 'LEARNING EXPERIENCE & PARENTING (LEAP)', '271061055', 'SU', '312', 'Amanda Johnson', 'adamsam@nku.edu', '859-572-5988', '', '', '', 'Amanda Johnson', 'Dannie Moore', 'Dan Nadler'),
(80, 82, 'LEARNING PLUS', '231060005', 'UC', '170G', 'Mary Seifried', 'seifriedm1@nku.edu', '859-572-1981', '', '', '', 'Diane Williams', 'Ande Durojaiye', 'Sue Ott Rowlands'),
(81, 83, 'LEGAL AFFAIRS & GENERAL COUNSEL', '206501001', 'AC', '824', 'Cathy Dewberry', 'dewberryc@nku.edu', '859-572-5588', '', '', '', 'Dawn Bell-Gardiner', 'Sara Kelley', 'Joan Gates'),
(82, 84, 'LGBTQ PROGRAMS & SERVICES', '270050034', 'SU', '309', 'Rachel Loftis', 'loftisr1@nku.edu', '859-572-1418', '', '', '', 'Bonnie Meyer', 'Dannie Moore', 'Dan Nadler'),
(83, 85, 'MAIL SERVICES/COPY CENTER', '210040015', 'LN', '100', 'Kevin Rossell', 'rossellk@nku.edu', '859-572-5652', '', '', '', 'Kevin Rossell', 'Andy Meeks', 'Mike Hales'),
(84, 86, 'MANAGEMENT', '236100001', 'BAC', '392', 'Teresa Huddleston', 'Huddlestot1@nku.edu', '859-572-6582', '', '', '', 'Tracey Sigler', 'Rebecca Porterfield', 'Sue Ott Rowlands'),
(85, 87, 'MARKETING & COMMUNICATION', '286010020', 'AC 701', '701', 'James Smedley', 'smedleyj1@mymail.nku.edu', '859-572-6948', '', '', '', 'Chris Cole', 'Gina Rittinger', 'Eric Gentry'),
(86, 88, 'MARKETING, SPORTS BUSINESS ', '236070001', 'BAC', '392', 'Teresa Huddleston', 'huddlestot1@nku.edu', '859-572-6582', '', '', '', 'Doris Shaw', 'Rebecca Porterfield', 'Sue Ott Rowlands'),
(87, 89, 'MATH ', '235060001', 'MEP', '401', 'Joni Landwehr', 'landwehrj1@nku.edu', '859-572-5377', 'Kimberly Johns', 'johnsk2@nku.edu', '6441', 'Dr. Brooke Buckley', 'Diana McGill', 'Sue Ott Rowlands'),
(88, 90, 'MBA', '236050001 ', 'BAC', '', 'Kari Wright Perkins', 'wrightk11@nku.edu', '859-572-6657', '', '', '', 'Ned Jackson', 'Rebbeca Porterfield', 'Sue Ott Rowlands'),
(89, 91, 'MUSIC', '235070001', 'FA', '371', 'Sandy Davis', 'davissa@nku.edu', '859-572-5935', 'Scott Slucher', 'slucherd1@nku.edu', '(859) 572-6362', 'Jonathan Eaton', 'Ken Jones', 'Sue Ott Rowlands'),
(92, 92, 'NORSE ADVISING', '231010001', 'UC', '210', 'Jackie Rowe', 'rowej@nku.edu', '859-572-6901', '', '', '', 'Frank Robinson', 'Ande Durojaiye', 'Sue Ott Rowlands'),
(93, 93, 'NORSE VIOLENCE PREVENTION', '237030050', 'HC', '246', 'Kendra Massey', '', '5865', 'Laura Dektas', '', '', 'Kendra Massey', 'Dannie Moore', 'Dan Nadler'),
(94, 94, 'NURSING', '239040020', 'FH/HE', '455', 'Hannah Brennan', 'brennanh1@nku.edu', '859-572-7964', '', '', '', 'Maureen Krebs', 'Dale Stephenson', 'Sue Ott Rowlands'),
(95, 97, 'OFFICE OF AMERICAN ENGLISH LANGUAGE', '245010001', 'UC', '340', 'Tiffany Budd', 'buddt1@nku.edu', '859-572-7954', '', '', '', 'David Guttman', 'Francois Ley Roy', 'Sue Ott Rowlands'),
(96, 98, 'OPER&MAINT-ADMIN', '211040005', 'MA', '106', 'Matt Humphress', 'Humphressm1@nku.edu', '859-572-5660', '', '', '', 'Rebecca Lanter', 'Syed Zaidi', 'Mike Hales'),
(97, 99, 'OPER&MAINT-AUTO', '211046005', 'MA', '100', 'Alan Lawson', 'lawsona2@nku.edu', '859-572-5113', '', '', '', 'William Moulton', 'Syed Zaidi', 'Mike Hales'),
(98, 100, 'OPER&MAINT-CARPENTRY', '211044010', 'MA', '100', 'Paul Melville', 'melville@nku.edu', '859-572-7613', '', '', '', 'Paul Hundemer', 'Syed Zaidi', 'Mike Hales'),
(99, 95, 'O & M - CUSTODIAL', '211042010', 'MA', '100', 'Jim Parker', 'parkerj@nku.edu', '859-572-5970', 'Michelle Smith', 'smithm5@nku.edu', '859-572-5971', 'William Moulton', 'Syed Zaidi', 'Mike Hales'),
(100, 101, 'OPER&MAINT-ELECTRIC', '211044025', 'MA', '100', 'Doug Miller', 'millerdo@nku.edu', '859-572-6504', '', '', '', 'Becki Lanter', 'Syed Zaidi', 'Mike Hales'),
(101, 102, 'OPER&MAINT-HORTICULTURE', '211046015', 'MA', '100', 'Roger McCulley', 'mcculleyh1@nku.edu', '859-572-7624', '', '', '', 'William Moulton', 'Syed Zaidi', 'Mike Hales'),
(102, 103, 'OPER&MAINT-HVAC', '211048015', 'MA', '100', 'Dan Magee', 'mageed1@nku.edu', '859-572-6513', '', '', '', 'Becki Lanter', 'Syed Zaidi', 'Mike Hales'),
(103, 104, 'OPER&MAINT-Labor', '211042020', 'PA', '100', 'Jim Parker', 'parkerj@nku.edu', '859-572-5970', '', '', '', 'William Moulton', 'Syed Zaidi', 'Mike Hales'),
(104, 105, 'OPER&MAINT-LOCK', '211044020', 'MA', '156', 'Mike Rumage', 'Rumagem@nku.edu', '859-572-5674', '', '', '', 'Paul Hundemer', 'Syed Zaidi', 'Mike Hales'),
(105, 106, 'OPER&MAINT-PLUMBING', '211044015', 'MA', '100', 'David Bridewell', 'bridewellda@nku.edu', '859-572-5453', '', '', '', 'Paul Hundemer', 'Syed Zaidi', 'Mike Hales'),
(106, 107, 'OPER&MAINT-POWERPLANT', '211048005', 'PP', '100', 'Mike Scott', 'scottmi@nku.edu', '859-572-5548', '', '', '', 'Becki Lanter', 'Syed Zaidi', 'Mike Hales'),
(107, 108, 'OPER&MAINT-ROADS&GROUNDS', '211046010', 'MA', '170C', 'Kim Yelton', 'yeltonk@nku.edu', '859-572-5452', '', '', '', 'William Moulton', 'Syed Zaidi', 'Mike Hales'),
(108, 109, 'ORIENTATION/PARENT PROGRAM', '270070005', 'SU', '321', 'Rebeca Sherman', 'shermanr1@nku.edu', '859-572-1967', '', '', '', 'Britta Gibson', 'Kim Scranage', 'Sue Ott Rowlands'),
(109, 110, 'PARKING SERVICES', '210100010', 'WC', '130', 'Eli Baird', 'bairde1@nku.edu', '859-572-7796', '', '', '', 'Curtis Keller', 'Andy Meeks', 'Mike Hales'),
(110, 111, 'PAYROLL & TAX', '212020005', 'AC', '613', 'Stacey Horan', 'horans@nku.edu', '859-572-6137', '', '', '', 'Cathy Wisher', 'Lori Southwood', 'Mike Hales'),
(111, 112, 'PHYSICS AND GEOLOGY', '235090001', 'SC', '204H', 'Jamie Fearon', 'fearonj1@nku.edu', '859-572-5309', '', '', '', 'Sharmanthie Fernando', 'Diana McGill', 'Sue Ott Rowlands'),
(112, 115, 'POLITICAL SCIENCE, CRIMINAL JUSTICE ', '235100500', 'FH', '555', 'Samra Pilav', 'pilavs1@nku.edu', '859-572-5321', '', '', '', 'Karen Miller', 'Diana McGill', 'Sue Ott Rowlands'),
(113, 116, 'PRESIDENT OFFICE', '201001001', 'AC', '800', 'Wendy Peek', 'peekw1@nku.edu', '859-572-5172', '', '', '', 'N/A', 'N/A', 'Gerard St. Amand'),
(115, 117, 'PROCUREMENT', '215010001', 'AC', '621', 'Ryan Strauss', 'strausr2@nku.edu', '859-572-6605', '', '', '', 'Blaine Gimore', 'Mike Hales', 'Mike Hales'),
(116, 118, 'PSYCHOLOGICAL SCIENCE', '235110001', 'MEP', '301', 'Lynne Fuhrman', 'Lynne Fuhrman', '859-572-5311', 'Lorretta Race', 'racel2@nku.edu', '859-572-5310', 'Jeffrey Smith', 'Diana McGill', 'Sue Ott Rowlands'),
(117, 119, 'RADIOLOGY TECH', '239010001', 'HC', '236', 'Hannah Brennan', 'brennanh1@nku.edu', '859-572-7964', '', '', '', 'Maureen Krebs', 'Dale Stephenson', 'Sue Ott Rowlands'),
(118, 120, 'REAL PROPERTY DEVELOPMENT', '211010015', 'AC', '726', 'Jim Kaufman', 'kaufmanj2@nku.edu', '859-572-1991', '', '', '', 'Jim Kaufman', 'Syed Zaidi', 'Mike Hales'),
(119, 121, 'REGISTRAR', '241020001', 'AC', '306', 'Denzil Carter', 'glidewelld1@nku.edu', '859-572-5782', '', '', '', 'Allen Cole', 'Kim Scranage', 'Sue Ott Rowlands'),
(120, 122, 'RESEARCH, GRANTS ', '242070005', 'UC', '405', 'Mary Ucci', 'uccim@nku.edu', '859-572-5768 ', '', '', '', 'Mary Ucci', 'Samantha Langley-Turnbaugh', 'Sue Ott Rowlands'),
(121, 123, 'RESPIRATORY CARE', '239020001', 'HC', '227', 'Hannah Brennan', 'brennanh1@nku.edu', '859-572-7964', '', '', '', 'Maureen Krebs', 'Dale Stephenson', 'Sue Ott Rowlands'),
(122, 124, 'SAFETY AND EMERGENCY MANAGEMENT', '211040010', 'MA', '118', 'Jeff Baker', 'bakerje@nku.edu', '859-572-6522', '', '', '', 'Jeff Baker', 'Syed Zaidi', 'Mike Hales'),
(123, 126, 'SCHOOL OF THE ARTS (SOTA)', '235080001', 'FA', '312C', 'Ronda Schweitzer', 'schweitzer2@nku.edu', '859-572-5421', '', '', '', 'Ken Jones', 'Diana McGill', 'Sue Ott Rowlands'),
(124, 127, 'SCRIPPS HOWARD CENTER FOR CIVIC ENGAGEMENT', '242020005', 'GH', '523, 525, 527, 529', 'Felicia Share', 'sharef1@nku.edu', '859-572-1448', 'Mark Neikirk', 'neikirkm1@nku.edu', '859-572-1449', 'Mark Neikirk', 'Samantha Langley-Turnbaugh', 'Sue Ott Rowlands'),
(125, 128, 'SMALL BUSINESS DEVELOP', '236030527', 'BAC', '368/376', 'Jesica Jehn', 'jehnj2@nku.edu', '859-572-8801', '', '', '', 'Rebecca Volpe', 'Rebecca Porterfield', 'Sue Ott Rowlands'),
(126, 129, 'SOCIOLOGY, ANTHROPOLOGY, & PHILOSOPHY', '235120001', 'LA', '217C', 'Mindy Berry', 'berrym1@nku.edu', '859-572-5887', '', '', '', 'Doug Hume', 'Diana McGill', 'Sue Ott Rowlands'),
(127, 130, 'SPECIAL EVENTS', '209001030', 'AC', '221', 'Krista Wiseman-Moore', 'mailto:wisemanmok1@nku.edu', '(859) 572-5810 ', '', '', '', 'Krista Wiseman-Moore', 'N/A', 'Eric Gentry'),
(128, 131, 'STAFF CONGRESS', '293060050', 'AC', '105', 'Grace Hiles', 'hilesg1@nku.edu', '859-572-6400', '', '', '', 'Grace Hiles', 'N/A', 'Mike Hales'),
(129, 132, 'STEELY LIBRARY', '233001005', 'SL', '508, 505', 'lilly cook', 'cookl7@nku.edu', '859-572-5348', 'Julie Matthews', 'matthewsju@nku.edu', '859-527-6676', 'N/A', 'Arne Almquist', 'Sue Ott Rowlands'),
(130, 133, 'STUDENT CONDUCT, RIGHTS & ADVOCACY', '270001005', 'SU', '301', 'Julie Bridewell', 'bridewellj@nku.edu', '859-572-5618', 'AJ Miller', 'millera5@nku.edu', '859-572-6498', 'Bob Alston', 'Ann James', 'Dan Nadler'),
(131, 134, 'STUDENT ENGAGEMENT', '270050005', 'SU', '316', 'Krista Salyers', 'salyersk2@nku.edu', '859-572-5807', '', '', '', 'Tiffany Mayse', 'Arnie Slaughter', 'Dan Nadler'),
(132, 135, 'STUDENT GOVERNMENT', '270050010', 'SU', '301', 'Julie Bridewell', 'bridewellj@nku.edu', '859-572-5618', '', '', '', 'N/A', 'Arnie Slaughter', 'Dan Nadler'),
(133, 136, 'STUDENT INCLUSIVENESS', '270120001', 'SU', '303', 'Laura Dektas', 'dektasl1@nku.edu', '859-572-5401', '', '', '', 'N/A', 'Dannie Moore', 'Dan Nadler'),
(135, 137, 'STUDENT MEDIA SERVICES', '270060005', 'GH', '400C', 'Michelle Day', 'daym2@mymail.nku.edu', '859-572-5260', '', '', '', 'Rachel Lyons', 'Arnie Slaughter', 'Dan Nadler'),
(136, 138, 'STUDENT SUPPORT SERVICE', '271030501', 'US', '127F', 'Cynthia Ash', 'ashc@nku.edu', '859-572-5138', '', '', '', 'Lori Wright', 'Ryan Padgett', 'Sue Ott Rowlands'),
(137, 139, 'STUDENT UNION & PROGRAMMING', '270110010', 'SU', '192', 'Maryann Trumble', 'trumblem@nku.edu', '859-572-7774', '', '', '', 'Sarah Aikman', 'Arnie Slaughter', 'Dan Nadler'),
(138, 140, 'SUSTAINABILITY & ENERGY MANAGEMENT', '211010045', 'MA', '105', 'Becki Lanter', 'lanterr1@nku.edu', '859-572-5493', '', '', '', 'Becki Lanter', 'Syed Zaidi', 'Mike Hales'),
(139, 141, 'TEACHER EDUCATION', '237010001', 'MEP', '253', 'Sarah Hellmann', 'hellmann2@nku.edu', '859-572-5624', '', '', '', 'Roland Sintos Coloma', 'Cynthia Reed', 'Sue Ott Rowlands'),
(140, 142, 'TELECOMMUNICATIONS', '232005010', 'AC', '507B', 'Velinda Vandegeer', 'vandegeerv1@nku.edu', '859-572-5271', '', '', '', 'Dave Foppe', 'Tim Ferguson', 'Mike Hales'),
(141, 143, 'TESTINGS SERVICES', '270112005', 'UC', '101', 'Connie Seiter', 'seiterc2@nku.edu', '859-572-5399', '', '', '', 'Amy Danzo', 'Abdou Ndoye', 'Sue Ott Rowlands'),
(142, 144, 'THEATRE & DANCE', '235130001', 'FA', '253B', 'Sandy Davis', 'davissa@nku.edu', '859-572-5935', '', '', '', 'Kenneth Jones', 'Diana McGill', 'Sue Ott Rowlands'),
(143, 145, 'TRANSFER SERVICES', '241020010', 'AC', '301D', 'Kelsey Haskins', 'bevinsk1@nku,edu', '859-572-5990', '', '', '', 'Kelsey Haskins', 'Kim Scranage', 'Sue Ott Rowlands'),
(144, 149, 'UNIVERSITY ARCHITECT, DESIGN & CONSTRUCTION MANAGEMENT', '211030001', 'AC', '726F', 'Brad Lehman', 'lehmanb1@nku.edu', '859-572-1989', '', '', '', 'Mark Jones', 'Syed Zaidi', 'Mike Hales'),
(145, 151, 'UNIVERSITY DEVELOPMENT ', '285010010', 'AC', '221', 'Sarah Eddington', 'edgingtons1@nku.edu', '859-572-6062', '', '', '', 'Amy Wiley', 'Keely Keene', 'Eric Gentry'),
(146, 152, 'UNIVERSITY HOUSING', '270100010', 'NC', '101', 'Jody Sargent', 'sargentj@nku.edu', '859-572-5448', '', '', '', 'Victoria Sttmiller', 'Arnie Slaughter', 'Dan Nadler'),
(147, 153, 'UNIVERSITY POLICE', '214010005', 'JHR', '415', 'Sgt. Matt Bunning', 'bunningm1@nku.edu', '859-572-1917', '', '', '', 'n/a', 'John Gaffin', 'Dan Nadler'),
(148, 150, 'UNIVERSITY CONNECT ', '208001030', 'UC', '120C', 'Peg Adams', 'adamspe@nku.edu', '859-572-7703', '', '', '', 'Peg Adams', 'Kim Scranage', 'Sue Ott Rowlands'),
(149, 155, 'UPWARD BOUND', '271070065', 'JHR', '241', 'Eric Brose', 'brosee@nku.edu', '859-572-8931', '', '', '', 'Eric Brose', 'Dannie Moore', 'Dan Nadler'),
(150, 156, 'VETERANS RESOURCES STATION', '241001030', 'UC', '131A', 'Robin Estridge', 'estridger2@nku.edu', '859-572-7867', '', '', '', 'Ryan Padget', 'Kim Scranage', 'Sue Ott Rowlands'),
(151, 157, 'VICE PROVOST FOR GRADUATE EDUATION RESEARCH & OUTREACH', '244001005', 'UC', '425', 'Kim Wiley', 'wileyk2@nku.edu', '859-572-7528', '', '', '', 'n/a', 'Samantha Langley', 'Sue Ott Rowlands'),
(152, 158, 'VICE PROVOST OFFICE', '204001501', 'UC', '415B', 'Connie Kiskaden', 'kiskadenc@nku.edu', '859-572-6567', '', '', '', 'Abdou Ndoye', 'Ande Durojaiye', 'Sue Ott Rowlands'),
(153, 159, 'VISUAL ARTS', '235010500', 'FA', '312C', 'Ashlee Coats', 'coatesa2@nku.edu', '859-572-5648', '', '', '', 'Brad McComb', 'Diana McGill', 'Sue Ott Rowlands'),
(154, 3, 'ACADEMIC AFFAIRS', '204001501', 'LAC', '830', 'Teri Williams', 'williamste@nku.edu', '572-6904', '', '', '', '', 'Chad Ogle', 'Sue Ott Rowlands'),
(155, 160, 'VP STUDENT AFFAIRS', '208001001', 'AC', '832A', 'Jamie Field', 'fieldj1@nku.edu', '859-572-6447', '', '', '', 'Moore, Dannie', 'Arnie Slaughter', 'Dan Nadler'),
(156, 148, 'UNIVERSITY ADVANCEMENT', '209001001', 'AC', '832A', 'Annie Spaulding', 'spauldinga2@nku.edu', '859-572-6447', '', '', '', 'Erica Bolenbaugh', 'n/a', 'Eric Gentry'),
(157, 154, 'UNIVERSITY WELLNESS', '212010020', 'FH', '359', 'Kim  Baker', 'bakerk7@nku.edu', '859-572-1922', 'Lori Southwood', 'southwood@nku.edu', '6383', 'Kim  Baker', 'NA', 'Lori Southwood'),
(158, 161, 'WOMENS STUDIES', '243090501', 'LA', '327', 'Lou Stuntz', 'stuntzl@nku.edu', '859-572-5461', '', '', '', 'Burke Miller', 'Diana McGill', 'Sue Ott Rowlands'),
(159, 162, 'WORLD LANGUAGES AND LITERATURES', '235200001', 'MEP', '475', 'Eden Schlosser', 'schlossere1@nku.edu', '859-572-7650', 'Dr. Caryn Connelly', 'Connellyc1', '859-572-7651', 'Caryn Connelly', 'Diana McGill', 'Sue Ott Rowlands'),
(162, 72, 'INSTITUTE OF HEALTH INNOVATION', '204020005', 'FH/HE', '225J', 'Valarie Hardcastle', '', '', 'Carolyn Noe', '', '', 'Valarie Hardcastle', '', ''),
(163, 146, 'UK College of Medicine', '0111000100', 'HC', '303', 'Paula Seta', '', '8783', 'Heather Huber', '', '', '', '', ''),
(164, 71, 'INSTITUTE FOR STUDENT RESEARCH AND CREATIVE ACTIVITY (ISRCA)', '244001025', 'FH/HE', '255', 'Shauna Reilly', 'reillys3@nku.edu', '6593', 'Kimberly', 'wileyk2@nku.edu', 'Wiley', 'Shauna Reilly', 'Samantha Langley-Turnbaugh', 'Sue Ott Rowlands '),
(165, 96, 'O & M FLOORCARE', '9999', 'PA', '100', 'Chris Tabor', '', '', 'Diane Vickers', '', '', 'Rebecca Lanter', 'Zaidi', 'Mike Hale'),
(166, 24, 'CENTER FOR STUDENT EXCELLENCE', '', 'BAC', '', 'Rebecca Cox', '', '', '', '', '', '', '', ''),
(167, 73, 'Institutional Research', '220010005', 'AC', '505', 'Shawn Rainey', 'raineys1@nku.edu', '859-572-1359', '', '', '', 'Shawn Rainey', '', ''),
(168, 113, 'PLANNING AND PERFORMANCE', '220010005', 'AC', '503', 'Shawn Rainey', 'raineys1@nku.edu', '(859) 572-1359 ', '', '', '', 'raineys1@nku.edu', '', ''),
(171, 147, 'UNDERGRADUATE AFFAIRS', '204001515', 'UC', '415', 'Constance Kiskaden', 'kiskadenc@nku.edu', '859-572-6567', 'Connie Seiter', 'seiterc2@nku.edu', '(859) 572-6079 ', '', '', 'Ande Durojaiye'),
(172, 18, 'CAMPUS RECREATION', '270020005', 'HC', '260', 'Pat McGrath', '', '', '', '', '', '', '', ''),
(173, 59, 'Fuel NKU\r\n', '', 'Albright Health Center', '107', 'Jessica Taylor', 'taylorj28@nku.edu', '', 'Megan Lindsey', 'lindseym4@nku.edu', '(859) 572-7741 ', '', '', ''),
(174, 59, 'Fuel NKU', '0000000003', 'Albright Health Center', '107', 'Jessica Taylor', 'taylorj28@nku.edu', '', 'Megan Lindsey', 'lindseym4@nku.edu', '(859) 572-7741 ', '', '', ''),
(175, 24, 'CENTER FOR STUDENT EXCELLENCE', '0000000004', 'BAC', '206', 'Hayden Skinner', 'skinnerfih1@nku.edu', '859-572-7902', '', '', '', 'Eileen Weisenbach Keller', '', ''),
(176, 125, 'School Based Scholars', '00000004', 'MEP', '411', 'Mary Golden', '', '572-6347', '', '', '', 'Diane Williamson', '', '');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `department`
--
ALTER TABLE `department`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `department`
--
ALTER TABLE `department`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=177;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
