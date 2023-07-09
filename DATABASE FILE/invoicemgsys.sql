-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Jul 09, 2023 at 08:06 PM
-- Server version: 5.7.31
-- PHP Version: 7.4.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `invoicemgsys`
--

-- --------------------------------------------------------

--
-- Table structure for table `countries`
--

DROP TABLE IF EXISTS `countries`;
CREATE TABLE IF NOT EXISTS `countries` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `country_name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `country_code` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `International_dialing` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_active` tinyint(1) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=247 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `countries`
--

INSERT INTO `countries` (`id`, `country_name`, `country_code`, `International_dialing`, `is_active`, `created_at`, `updated_at`) VALUES
(1, 'Afghanistan', 'AF', '+93', 1, '2022-01-20 09:30:27', '2022-01-20 09:30:27'),
(2, 'Albania', 'AL', '+355', 1, '2022-01-20 09:30:27', '2022-01-20 09:30:27'),
(3, 'Algeria', 'DZ', '+213', 1, '2022-01-20 09:30:27', '2022-01-20 09:30:27'),
(4, 'American Samoa', 'AS', '+1-684', 1, '2022-01-20 09:30:27', '2022-01-20 09:30:27'),
(5, 'Andorra, Principality of', 'AD', '+376', 1, '2022-01-20 09:30:27', '2022-01-20 09:30:27'),
(6, 'Angola', 'AO', '+244', 1, '2022-01-20 09:30:27', '2022-01-20 09:30:27'),
(7, 'Anguilla', 'AI', '+1-264', 1, '2022-01-20 09:30:27', '2022-01-20 09:30:27'),
(8, 'Antarctica', 'AQ', '+672', 1, '2022-01-20 09:30:27', '2022-01-20 09:30:27'),
(9, 'Antigua and Barbuda', 'AG', '+1-268', 1, '2022-01-20 09:30:27', '2022-01-20 09:30:27'),
(10, 'Argentina', 'AR', '+54', 1, '2022-01-20 09:30:27', '2022-01-20 09:30:27'),
(11, 'Armenia', 'AM', '+374', 1, '2022-01-20 09:30:27', '2022-01-20 09:30:27'),
(12, 'Aruba', 'AW', '+297', 1, '2022-01-20 09:30:27', '2022-01-20 09:30:27'),
(13, 'Australia', 'AU', '+61', 1, '2022-01-20 09:30:27', '2022-01-20 09:30:27'),
(14, 'Austria', 'AT', '+43', 1, '2022-01-20 09:30:27', '2022-01-20 09:30:27'),
(15, 'Azerbaijan or Azerbaidjan (Former Azerbaijan Soviet Socialist Republic)', 'AZ', '+994', 1, '2022-01-20 09:30:27', '2022-01-20 09:30:27'),
(16, 'Bahamas, Commonwealth of The', 'BS', '+1-242', 1, '2022-01-20 09:30:27', '2022-01-20 09:30:27'),
(17, 'Bahrain, Kingdom of (Former Dilmun)', 'BH', '+973', 1, '2022-01-20 09:30:27', '2022-01-20 09:30:27'),
(18, 'Bangladesh', 'BD', '+880', 1, '2022-01-20 09:30:27', '2022-01-20 09:30:27'),
(19, 'Barbados', 'BB', '+1-246', 1, '2022-01-20 09:30:27', '2022-01-20 09:30:27'),
(20, 'Belarus', 'BY', '+375', 1, '2022-01-20 09:30:27', '2022-01-20 09:30:27'),
(21, 'Belgium', 'BE', '+32', 1, '2022-01-20 09:30:27', '2022-01-20 09:30:27'),
(22, 'Belize', 'BZ', '+501', 1, '2022-01-20 09:30:27', '2022-01-20 09:30:27'),
(23, 'Benin', 'BJ', '+229', 1, '2022-01-20 09:30:27', '2022-01-20 09:30:27'),
(24, 'Bermuda', 'BM', '+1-441', 1, '2022-01-20 09:30:27', '2022-01-20 09:30:27'),
(25, 'Bhutan, Kingdom of', 'BT', '+975', 1, '2022-01-20 09:30:27', '2022-01-20 09:30:27'),
(26, 'Bolivia', 'BO', '+591', 1, '2022-01-20 09:30:27', '2022-01-20 09:30:27'),
(27, 'Bosnia and Herzegovina', 'BA', '+387', 1, '2022-01-20 09:30:27', '2022-01-20 09:30:27'),
(28, 'Botswana', 'BW', '+267', 1, '2022-01-20 09:30:27', '2022-01-20 09:30:27'),
(29, 'Bouvet Island (Territory of Norway)', 'BV', '', 1, '2022-01-20 09:30:27', '2022-01-20 09:30:27'),
(30, 'Brazil', 'BR', '+55', 1, '2022-01-20 09:30:27', '2022-01-20 09:30:27'),
(31, 'British Indian Ocean Territory (BIOT)', 'IO', '', 1, '2022-01-20 09:30:27', '2022-01-20 09:30:27'),
(32, 'Brunei', 'BN', '+673', 1, '2022-01-20 09:30:27', '2022-01-20 09:30:27'),
(33, 'Bulgaria', 'BG', '+359', 1, '2022-01-20 09:30:27', '2022-01-20 09:30:27'),
(34, 'Burkina Faso (Former Upper Volta)', 'BF', '+226', 1, '2022-01-20 09:30:27', '2022-01-20 09:30:27'),
(35, 'Burundi', 'BI', '+257', 1, '2022-01-20 09:30:27', '2022-01-20 09:30:27'),
(36, 'Cambodia, Kingdom of (Former Khmer Republic, Kampuchea Republic)', 'KH', '+855', 1, '2022-01-20 09:30:27', '2022-01-20 09:30:27'),
(37, 'Cameroon', 'CM', '+237', 1, '2022-01-20 09:30:27', '2022-01-20 09:30:27'),
(38, 'Canada', 'CA', '+1', 1, '2022-01-20 09:30:27', '2022-01-20 09:30:27'),
(39, 'Cape Verde', 'CV', '+238', 1, '2022-01-20 09:30:27', '2022-01-20 09:30:27'),
(40, 'Cayman Islands', 'KY', '+1-345', 1, '2022-01-20 09:30:27', '2022-01-20 09:30:27'),
(41, 'Central African Republic', 'CF', '+236', 1, '2022-01-20 09:30:27', '2022-01-20 09:30:27'),
(42, 'Chad', 'TD', '+235', 1, '2022-01-20 09:30:27', '2022-01-20 09:30:27'),
(43, 'Chile', 'CL', '+56', 1, '2022-01-20 09:30:27', '2022-01-20 09:30:27'),
(44, 'China', 'CN', '+86', 1, '2022-01-20 09:30:27', '2022-01-20 09:30:27'),
(45, 'Christmas Island', 'CX', '+53', 1, '2022-01-20 09:30:27', '2022-01-20 09:30:27'),
(46, 'Cocos (Keeling) Islands', 'CC', '+61', 1, '2022-01-20 09:30:27', '2022-01-20 09:30:27'),
(47, 'Colombia', 'CO', '+57', 1, '2022-01-20 09:30:27', '2022-01-20 09:30:27'),
(48, 'Comoros, Union of the', 'KM', '+269', 1, '2022-01-20 09:30:27', '2022-01-20 09:30:27'),
(49, 'Congo, Democratic Republic of the (Former Zaire)', 'CD', '+243', 1, '2022-01-20 09:30:27', '2022-01-20 09:30:27'),
(50, 'Congo, Republic of the', 'CG', '+242', 1, '2022-01-20 09:30:27', '2022-01-20 09:30:27'),
(51, 'Cook Islands', 'CK', '+682', 1, '2022-01-20 09:30:27', '2022-01-20 09:30:27'),
(52, 'Costa Rica', 'CR', '+506', 1, '2022-01-20 09:30:27', '2022-01-20 09:30:27'),
(53, 'Cote D\'Ivoire (Former Ivory Coast)', 'CI', '+225', 1, '2022-01-20 09:30:27', '2022-01-20 09:30:27'),
(54, 'Croatia (Hrvatska)', 'HR', '+385', 1, '2022-01-20 09:30:27', '2022-01-20 09:30:27'),
(55, 'Cuba', 'CU', '+53', 1, '2022-01-20 09:30:27', '2022-01-20 09:30:27'),
(56, 'Cyprus', 'CY', '+357', 1, '2022-01-20 09:30:27', '2022-01-20 09:30:27'),
(57, 'Czech Republic', 'CZ', '+420', 1, '2022-01-20 09:30:27', '2022-01-20 09:30:27'),
(58, 'Czechoslavakia (Former) See CZ Czech Republic or Slovakia', 'CS', '', 1, '2022-01-20 09:30:27', '2022-01-20 09:30:27'),
(59, 'Denmark', 'DK', '+45', 1, '2022-01-20 09:30:27', '2022-01-20 09:30:27'),
(60, 'Djibouti', 'DJ', '+253', 1, '2022-01-20 09:30:27', '2022-01-20 09:30:27'),
(61, 'Dominica', 'DM', '+1-767', 1, '2022-01-20 09:30:27', '2022-01-20 09:30:27'),
(62, 'Dominican Republic', 'DO', '+1-809 and +1-829  ', 1, '2022-01-20 09:30:27', '2022-01-20 09:30:27'),
(63, 'East Timor', 'TP', '+670', 1, '2022-01-20 09:30:27', '2022-01-20 09:30:27'),
(64, 'Ecuador', 'EC', '+593 ', 1, '2022-01-20 09:30:27', '2022-01-20 09:30:27'),
(65, 'Egypt', 'EG', '+20', 1, '2022-01-20 09:30:27', '2022-01-20 09:30:27'),
(66, 'El Salvador', 'SV', '+503', 1, '2022-01-20 09:30:27', '2022-01-20 09:30:27'),
(67, 'Equatorial Guinea (Former Spanish Guinea)', 'GQ', '+240', 1, '2022-01-20 09:30:27', '2022-01-20 09:30:27'),
(68, 'Eritrea', 'ER', '+291', 1, '2022-01-20 09:30:27', '2022-01-20 09:30:27'),
(69, 'Estonia', 'EE', '+372', 1, '2022-01-20 09:30:27', '2022-01-20 09:30:27'),
(70, 'Ethiopia', 'ET', '+251', 1, '2022-01-20 09:30:27', '2022-01-20 09:30:27'),
(71, 'Falkland Islands', 'FK', '+500', 1, '2022-01-20 09:30:27', '2022-01-20 09:30:27'),
(72, 'Faroe Islands', 'FO', '+298', 1, '2022-01-20 09:30:27', '2022-01-20 09:30:27'),
(73, 'Fiji', 'FJ', '+679', 1, '2022-01-20 09:30:27', '2022-01-20 09:30:27'),
(74, 'Finland', 'FI', '+358', 1, '2022-01-20 09:30:27', '2022-01-20 09:30:27'),
(75, 'France', 'FR', '+33', 1, '2022-01-20 09:30:27', '2022-01-20 09:30:27'),
(76, 'French Guiana or French Guyana', 'GF', '+594', 1, '2022-01-20 09:30:27', '2022-01-20 09:30:27'),
(77, 'French Polynesia (Former French Colony of Oceania)', 'PF', '+689', 1, '2022-01-20 09:30:27', '2022-01-20 09:30:27'),
(78, 'French Southern Territories and Antarctic Lands', 'TF', '', 1, '2022-01-20 09:30:27', '2022-01-20 09:30:27'),
(79, 'Gabon', 'GA', '+241', 1, '2022-01-20 09:30:27', '2022-01-20 09:30:27'),
(80, 'Gambia, The', 'GM', '+220', 1, '2022-01-20 09:30:27', '2022-01-20 09:30:27'),
(81, 'Georgia', 'GE', '+995', 1, '2022-01-20 09:30:27', '2022-01-20 09:30:27'),
(82, 'Germany', 'DE', '+49', 1, '2022-01-20 09:30:27', '2022-01-20 09:30:27'),
(83, 'Ghana (Former Gold Coast)', 'GH', '+233', 1, '2022-01-20 09:30:27', '2022-01-20 09:30:27'),
(84, 'Gibraltar', 'GI', '+350', 1, '2022-01-20 09:30:27', '2022-01-20 09:30:27'),
(85, 'United Kingdom', 'GB', '', 1, '2022-01-20 09:30:27', '2022-01-20 09:30:27'),
(86, 'Greece', 'GR', '+30', 1, '2022-01-20 09:30:27', '2022-01-20 09:30:27'),
(87, 'Greenland', 'GL', '+299', 1, '2022-01-20 09:30:27', '2022-01-20 09:30:27'),
(88, 'Grenada', 'GD', '+1-473', 1, '2022-01-20 09:30:27', '2022-01-20 09:30:27'),
(89, 'Guadeloupe', 'GP', '+590', 1, '2022-01-20 09:30:27', '2022-01-20 09:30:27'),
(90, 'Guam', 'GU', '+1-671', 1, '2022-01-20 09:30:27', '2022-01-20 09:30:27'),
(91, 'Guatemala', 'GT', '+502', 1, '2022-01-20 09:30:27', '2022-01-20 09:30:27'),
(92, 'Guinea', 'GN', '+224', 1, '2022-01-20 09:30:27', '2022-01-20 09:30:27'),
(93, 'Guinea-Bissau', 'GW', '+245', 1, '2022-01-20 09:30:27', '2022-01-20 09:30:27'),
(94, 'Guyana', 'GY', '+592', 1, '2022-01-20 09:30:27', '2022-01-20 09:30:27'),
(95, 'Haiti', 'HT', '+509', 1, '2022-01-20 09:30:27', '2022-01-20 09:30:27'),
(96, 'Heard Island and McDonald Islands (Territory of Australia)', 'HM', '', 1, '2022-01-20 09:30:27', '2022-01-20 09:30:27'),
(97, 'Holy See (Vatican City State)', 'VA', '', 1, '2022-01-20 09:30:27', '2022-01-20 09:30:27'),
(98, 'Honduras', 'HN', '+504', 1, '2022-01-20 09:30:27', '2022-01-20 09:30:27'),
(99, 'Hong Kong', 'HK', '+852', 1, '2022-01-20 09:30:27', '2022-01-20 09:30:27'),
(100, 'Hungary', 'HU', '+36', 1, '2022-01-20 09:30:27', '2022-01-20 09:30:27'),
(101, 'Iceland', 'IS', '+354', 1, '2022-01-20 09:30:27', '2022-01-20 09:30:27'),
(102, 'India', 'IN', '+91', 1, '2022-01-20 09:30:27', '2022-01-20 09:30:27'),
(103, 'Indonesia', 'ID', '+62', 1, '2022-01-20 09:30:27', '2022-01-20 09:30:27'),
(104, 'Iran, Islamic Republic of', 'IR', '+98', 1, '2022-01-20 09:30:27', '2022-01-20 09:30:27'),
(105, 'Iraq', 'IQ', '+964', 1, '2022-01-20 09:30:27', '2022-01-20 09:30:27'),
(106, 'Ireland', 'IE', '+353', 1, '2022-01-20 09:30:27', '2022-01-20 09:30:27'),
(107, 'Israel', 'IL', '+972', 1, '2022-01-20 09:30:27', '2022-01-20 09:30:27'),
(108, 'Italy', 'IT', '+39', 1, '2022-01-20 09:30:27', '2022-01-20 09:30:27'),
(109, 'Jamaica', 'JM', '+1-876', 1, '2022-01-20 09:30:27', '2022-01-20 09:30:27'),
(110, 'Japan', 'JP', '+81', 1, '2022-01-20 09:30:27', '2022-01-20 09:30:27'),
(111, 'Jordan', 'JO', '+962', 1, '2022-01-20 09:30:27', '2022-01-20 09:30:27'),
(112, 'Kazakstands', 'KZ', '+7', 1, '2022-01-20 09:30:27', '2022-01-20 09:30:27'),
(113, 'Kenya', 'KE', '+254', 1, '2022-01-20 09:30:27', '2022-01-20 09:30:27'),
(114, 'Kiribati', 'KI', '+686', 1, '2022-01-20 09:30:27', '2022-01-20 09:30:27'),
(115, 'Korea, Democratic People\'s Republic of (North Korea)', 'KP', '+850', 1, '2022-01-20 09:30:27', '2022-01-20 09:30:27'),
(116, 'Korea, Republic of (South Korea)', 'KR', '+82', 1, '2022-01-20 09:30:27', '2022-01-20 09:30:27'),
(117, 'Kuwait', 'KW', '+965', 1, '2022-01-20 09:30:27', '2022-01-20 09:30:27'),
(118, 'Kyrgyzstan (Kyrgyz Republic) (Former Kirghiz Soviet Socialist Republic)', 'KG', '+996', 1, '2022-01-20 09:30:27', '2022-01-20 09:30:27'),
(119, 'Lao People\'s Democratic Republic (Laos)', 'LA', '+856', 1, '2022-01-20 09:30:27', '2022-01-20 09:30:27'),
(120, 'Latvia', 'LV', '+371', 1, '2022-01-20 09:30:27', '2022-01-20 09:30:27'),
(121, 'Lebanon', 'LB', '+961', 1, '2022-01-20 09:30:27', '2022-01-20 09:30:27'),
(122, 'Lesotho', 'LS', '+266', 1, '2022-01-20 09:30:27', '2022-01-20 09:30:27'),
(123, 'Liberia', 'LR', '+231', 1, '2022-01-20 09:30:27', '2022-01-20 09:30:27'),
(124, 'Libya (Libyan Arab Jamahiriya)', 'LY', '+218', 1, '2022-01-20 09:30:27', '2022-01-20 09:30:27'),
(125, 'Liechtenstein', 'LI', '+423', 1, '2022-01-20 09:30:27', '2022-01-20 09:30:27'),
(126, 'Lithuania (Former Lithuanian Soviet Socialist Republic)', 'LT', '+370', 1, '2022-01-20 09:30:27', '2022-01-20 09:30:27'),
(127, 'Luxembourg', 'LU', '+352', 1, '2022-01-20 09:30:27', '2022-01-20 09:30:27'),
(128, 'Macau', 'MO', '+853', 1, '2022-01-20 09:30:27', '2022-01-20 09:30:27'),
(129, 'Macedonia, The Former Yugoslav Republic of', 'MK', '+389', 1, '2022-01-20 09:30:27', '2022-01-20 09:30:27'),
(130, 'Madagascar', 'MG', '+261', 1, '2022-01-20 09:30:27', '2022-01-20 09:30:27'),
(131, 'Malawi', 'MW', '+265', 1, '2022-01-20 09:30:27', '2022-01-20 09:30:27'),
(132, 'Malaysia', 'MY', '+60', 1, '2022-01-20 09:30:27', '2022-01-20 09:30:27'),
(133, 'Maldives', 'MV', '+960', 1, '2022-01-20 09:30:27', '2022-01-20 09:30:27'),
(134, 'Mali', 'ML', '+223', 1, '2022-01-20 09:30:27', '2022-01-20 09:30:27'),
(135, 'Malta', 'MT', '+356', 1, '2022-01-20 09:30:27', '2022-01-20 09:30:27'),
(136, 'Marshall Islands (Former Marshall Islands District - Trust Territory of the Pacific Islands)', 'MH', '+692', 1, '2022-01-20 09:30:27', '2022-01-20 09:30:27'),
(137, 'Martinique', 'MQ', '+596', 1, '2022-01-20 09:30:27', '2022-01-20 09:30:27'),
(138, 'Mauritania', 'MR', '+222', 1, '2022-01-20 09:30:27', '2022-01-20 09:30:27'),
(139, 'Mauritius', 'MU', '+230', 1, '2022-01-20 09:30:27', '2022-01-20 09:30:27'),
(140, 'Mayotte', 'YT', '+269', 1, '2022-01-20 09:30:27', '2022-01-20 09:30:27'),
(141, 'Mexico', 'MX', '+52', 1, '2022-01-20 09:30:27', '2022-01-20 09:30:27'),
(142, 'Micronesia, Federated States of (Former Ponape, Truk, and Yap Districts - Trust Territory of the Pacific Islands)', 'FM', '+691', 1, '2022-01-20 09:30:27', '2022-01-20 09:30:27'),
(143, 'Moldova, Republic of', 'MD', '+373', 1, '2022-01-20 09:30:27', '2022-01-20 09:30:27'),
(144, 'Monaco, Principality of', 'MC', '+377', 1, '2022-01-20 09:30:27', '2022-01-20 09:30:27'),
(145, 'Mongolia', 'MN', '+976', 1, '2022-01-20 09:30:27', '2022-01-20 09:30:27'),
(146, 'Montserrat', 'MS', '+1-664', 1, '2022-01-20 09:30:27', '2022-01-20 09:30:27'),
(147, 'Morocco', 'MA', '+212', 1, '2022-01-20 09:30:27', '2022-01-20 09:30:27'),
(148, 'Mozambique (Former Portuguese East Africa)', 'MZ', '+258', 1, '2022-01-20 09:30:27', '2022-01-20 09:30:27'),
(149, 'Myanmar, Union of (Former Burma)', 'MM', '+95', 1, '2022-01-20 09:30:27', '2022-01-20 09:30:27'),
(150, 'Namibia', 'NA', '+264', 1, '2022-01-20 09:30:27', '2022-01-20 09:30:27'),
(151, 'Nauru', 'NR', '+674', 1, '2022-01-20 09:30:27', '2022-01-20 09:30:27'),
(152, 'Nepal', 'NP', '+977', 1, '2022-01-20 09:30:27', '2022-01-20 09:30:27'),
(153, 'Netherlands', 'NL', '+31', 1, '2022-01-20 09:30:27', '2022-01-20 09:30:27'),
(154, 'Netherlands Antilles', 'AN', '+599', 1, '2022-01-20 09:30:27', '2022-01-20 09:30:27'),
(155, 'New Caledonia', 'NC', '+687', 1, '2022-01-20 09:30:27', '2022-01-20 09:30:27'),
(156, 'New Zealand (Aotearoa)', 'NZ', '+64', 1, '2022-01-20 09:30:27', '2022-01-20 09:30:27'),
(157, 'Nicaragua', 'NI', '+505', 1, '2022-01-20 09:30:27', '2022-01-20 09:30:27'),
(158, 'Niger', 'NE', '+227', 1, '2022-01-20 09:30:27', '2022-01-20 09:30:27'),
(159, 'Nigeria', 'NG', '+234', 1, '2022-01-20 09:30:27', '2022-01-20 09:30:27'),
(160, 'Niue', 'NU', '+683', 1, '2022-01-20 09:30:27', '2022-01-20 09:30:27'),
(161, 'Norfolk Island', 'NF', '+672', 1, '2022-01-20 09:30:27', '2022-01-20 09:30:27'),
(162, 'Northern Mariana Islands (Former Mariana Islands District - Trust Territory of the Pacific Islands)', 'MP', '+1-670', 1, '2022-01-20 09:30:27', '2022-01-20 09:30:27'),
(163, 'Norway', 'NO', '+47', 1, '2022-01-20 09:30:27', '2022-01-20 09:30:27'),
(164, 'Oman, Sultanate of (Former Muscat and Oman)', 'OM', '+968', 1, '2022-01-20 09:30:27', '2022-01-20 09:30:27'),
(165, 'Pakistan (Former West Pakistan)', 'PK', '+92', 1, '2022-01-20 09:30:27', '2022-01-20 09:30:27'),
(166, 'Palau', 'PW', '+680', 1, '2022-01-20 09:30:27', '2022-01-20 09:30:27'),
(167, 'Palestinian State (Proposed)', 'PS', '+970', 1, '2022-01-20 09:30:27', '2022-01-20 09:30:27'),
(168, 'Panama', 'PA', '+507', 1, '2022-01-20 09:30:27', '2022-01-20 09:30:27'),
(169, 'Papua New Guinea (Former Territory of Papua and New Guinea)', 'PG', '+675', 1, '2022-01-20 09:30:27', '2022-01-20 09:30:27'),
(170, 'Paraguay', 'PY', '+595', 1, '2022-01-20 09:30:27', '2022-01-20 09:30:27'),
(171, 'Peru', 'PE', '+51', 1, '2022-01-20 09:30:27', '2022-01-20 09:30:27'),
(172, 'Philippines', 'PH', '+63', 1, '2022-01-20 09:30:27', '2022-01-20 09:30:27'),
(173, 'Pitcairn Island', 'PN', '', 1, '2022-01-20 09:30:27', '2022-01-20 09:30:27'),
(174, 'Poland', 'PL', '+48', 1, '2022-01-20 09:30:27', '2022-01-20 09:30:27'),
(175, 'Portugal', 'PT', '+351', 1, '2022-01-20 09:30:27', '2022-01-20 09:30:27'),
(176, 'Puerto Rico', 'PR', '+1-787 or +1-939', 1, '2022-01-20 09:30:27', '2022-01-20 09:30:27'),
(177, 'Qatar, State of', 'QA', '+974 ', 1, '2022-01-20 09:30:27', '2022-01-20 09:30:27'),
(178, 'Reunion (French) (Former Bourbon Island)', 'RE', '+262', 1, '2022-01-20 09:30:27', '2022-01-20 09:30:27'),
(179, 'Romania', 'RO', '+40', 1, '2022-01-20 09:30:27', '2022-01-20 09:30:27'),
(180, 'Russia', 'SU', '', 1, '2022-01-20 09:30:27', '2022-01-20 09:30:27'),
(181, 'Russian Federation', 'RU', '+7', 1, '2022-01-20 09:30:27', '2022-01-20 09:30:27'),
(182, 'Rwanda', 'RW', '+250', 1, '2022-01-20 09:30:27', '2022-01-20 09:30:27'),
(183, 'Saint Helena', 'SH', '+290', 1, '2022-01-20 09:30:27', '2022-01-20 09:30:27'),
(184, 'Saint Kitts and Nevis', 'KN', '+1-869', 1, '2022-01-20 09:30:27', '2022-01-20 09:30:27'),
(185, 'Saint Lucia', 'LC', '+1-758', 1, '2022-01-20 09:30:27', '2022-01-20 09:30:27'),
(186, 'Saint Pierre and Miquelon', 'PM', '+508', 1, '2022-01-20 09:30:27', '2022-01-20 09:30:27'),
(187, 'Saint Vincent and the Grenadines', 'VC', '+1-784', 1, '2022-01-20 09:30:27', '2022-01-20 09:30:27'),
(188, 'Samoa', 'WS', '+685', 1, '2022-01-20 09:30:27', '2022-01-20 09:30:27'),
(189, 'San Marino', 'SM', '+378', 1, '2022-01-20 09:30:27', '2022-01-20 09:30:27'),
(190, 'Sao Tome and Principe', 'ST', '+239', 1, '2022-01-20 09:30:27', '2022-01-20 09:30:27'),
(191, 'Saudi Arabia', 'SA', '+966', 1, '2022-01-20 09:30:27', '2022-01-20 09:30:27'),
(192, 'Serbia, Republic of', 'RS', '', 1, '2022-01-20 09:30:27', '2022-01-20 09:30:27'),
(193, 'Senegal', 'SN', '+221', 1, '2022-01-20 09:30:27', '2022-01-20 09:30:27'),
(194, 'Seychelles', 'SC', '+248', 1, '2022-01-20 09:30:27', '2022-01-20 09:30:27'),
(195, 'Sierra Leone', 'SL', '+232', 1, '2022-01-20 09:30:27', '2022-01-20 09:30:27'),
(196, 'Singapore', 'SG', '+65', 1, '2022-01-20 09:30:27', '2022-01-20 09:30:27'),
(197, 'Slovakia', 'SK', '+421', 1, '2022-01-20 09:30:27', '2022-01-20 09:30:27'),
(198, 'Slovenia', 'SI', '+386', 1, '2022-01-20 09:30:27', '2022-01-20 09:30:27'),
(199, 'Solomon Islands', 'SB', '+677', 1, '2022-01-20 09:30:27', '2022-01-20 09:30:27'),
(200, 'Somalia', 'SO', '+252', 1, '2022-01-20 09:30:27', '2022-01-20 09:30:27'),
(201, 'South Africa (Former Union of South Africa)', 'ZA', '+27', 1, '2022-01-20 09:30:27', '2022-01-20 09:30:27'),
(202, 'South Georgia and the South Sandwich Islands', 'GS', '', 1, '2022-01-20 09:30:27', '2022-01-20 09:30:27'),
(203, 'Spain', 'ES', '+34', 1, '2022-01-20 09:30:27', '2022-01-20 09:30:27'),
(204, 'Sri Lanka (Former Serendib, Ceylon)', 'LK', '+94', 1, '2022-01-20 09:30:27', '2022-01-20 09:30:27'),
(205, 'Sudan (Former Anglo-Egyptian Sudan)', 'SD', '+249', 1, '2022-01-20 09:30:27', '2022-01-20 09:30:27'),
(206, 'Suriname (Former Netherlands Guiana, Dutch Guiana)', 'SR', '+597', 1, '2022-01-20 09:30:27', '2022-01-20 09:30:27'),
(207, 'Svalbard (Spitzbergen) and Jan Mayen Islands', 'SJ', '', 1, '2022-01-20 09:30:27', '2022-01-20 09:30:27'),
(208, 'Swaziland, Kingdom of', 'SZ', '+268', 1, '2022-01-20 09:30:27', '2022-01-20 09:30:27'),
(209, 'Sweden', 'SE', '+46', 1, '2022-01-20 09:30:27', '2022-01-20 09:30:27'),
(210, 'Switzerland', 'CH', '+41', 1, '2022-01-20 09:30:27', '2022-01-20 09:30:27'),
(211, 'Syria (Syrian Arab Republic) (Former United Arab Republic - with Egypt)', 'SY', '+963', 1, '2022-01-20 09:30:27', '2022-01-20 09:30:27'),
(212, 'Taiwan', 'TW', '+886', 1, '2022-01-20 09:30:27', '2022-01-20 09:30:27'),
(213, 'Tajikistand', 'TJ', '+992', 1, '2022-01-20 09:30:27', '2022-01-20 09:30:27'),
(214, 'Tanzania, United Republic of (Former United Republic of Tanganyika and Zanzibar)', 'TZ', '+255', 1, '2022-01-20 09:30:27', '2022-01-20 09:30:27'),
(215, 'Thailand (Former Siam)', 'TH', '+66', 1, '2022-01-20 09:30:27', '2022-01-20 09:30:27'),
(216, 'Togo', 'TG', '', 1, '2022-01-20 09:30:27', '2022-01-20 09:30:27'),
(217, 'Tokelau', 'TK', '+690', 1, '2022-01-20 09:30:27', '2022-01-20 09:30:27'),
(218, 'Tonga, Kingdom of (Former Friendly Islands)', 'TO', '+676', 1, '2022-01-20 09:30:27', '2022-01-20 09:30:27'),
(219, 'Trinidad and Tobago', 'TT', '+1-868', 1, '2022-01-20 09:30:27', '2022-01-20 09:30:27'),
(220, 'Tromelin Island', 'TE', '', 1, '2022-01-20 09:30:27', '2022-01-20 09:30:27'),
(221, 'Tunisia', 'TN', '+216', 1, '2022-01-20 09:30:27', '2022-01-20 09:30:27'),
(222, 'Turkey', 'TR', '+90', 1, '2022-01-20 09:30:27', '2022-01-20 09:30:27'),
(223, 'Turkmenistan', 'TM', '+993', 1, '2022-01-20 09:30:27', '2022-01-20 09:30:27'),
(224, 'Turks and Caicos Islands', 'TC', '+1-649', 1, '2022-01-20 09:30:27', '2022-01-20 09:30:27'),
(225, 'Tuvalu', 'TV', '+688', 1, '2022-01-20 09:30:27', '2022-01-20 09:30:27'),
(226, 'Uganda, Republic of', 'UG', '+256', 1, '2022-01-20 09:30:27', '2022-01-20 09:30:27'),
(227, 'Ukraine)', 'UA', '+380', 1, '2022-01-20 09:30:27', '2022-01-20 09:30:27'),
(228, 'United Arab Emirates (UAE) (Former Trucial Oman, Trucial States)', 'AE', '+971', 1, '2022-01-20 09:30:27', '2022-01-20 09:30:27'),
(229, 'United Kingdom (Great Britain / UK)', 'GB', '+44', 1, '2022-01-20 09:30:27', '2022-01-20 09:30:27'),
(230, 'United States', 'US', '+1', 1, '2022-01-20 09:30:27', '2022-01-20 09:30:27'),
(231, 'United States Minor Outlying Islands', 'UM', '', 1, '2022-01-20 09:30:27', '2022-01-20 09:30:27'),
(232, 'Uruguay, Oriental Republic of (Former Banda Oriental, Cisplatine Province)', 'UY', '+598', 1, '2022-01-20 09:30:27', '2022-01-20 09:30:27'),
(233, 'Uzbekistan', 'UZ', '+998', 1, '2022-01-20 09:30:27', '2022-01-20 09:30:27'),
(234, 'Vanuatu', 'VU', '+678', 1, '2022-01-20 09:30:27', '2022-01-20 09:30:27'),
(235, 'Vatican City State (Holy See)', 'VA', '+418', 1, '2022-01-20 09:30:27', '2022-01-20 09:30:27'),
(236, 'Venezuela', 'VE', '+58', 1, '2022-01-20 09:30:27', '2022-01-20 09:30:27'),
(237, 'Vietnam', 'VN', '+84', 1, '2022-01-20 09:30:27', '2022-01-20 09:30:27'),
(238, 'Virgin Islands, British', 'VI', '+1-284', 1, '2022-01-20 09:30:27', '2022-01-20 09:30:27'),
(239, 'Virgin Islands, United States (Former Danish West Indies)', 'VQ', '+1-340', 1, '2022-01-20 09:30:27', '2022-01-20 09:30:27'),
(240, 'Wallis and Futuna Islands', 'WF', '+681', 1, '2022-01-20 09:30:27', '2022-01-20 09:30:27'),
(241, 'Western Sahara (Former Spanish Sahara)', 'EH', '', 1, '2022-01-20 09:30:27', '2022-01-20 09:30:27'),
(242, 'Yemen', 'YE', '+967', 1, '2022-01-20 09:30:27', '2022-01-20 09:30:27'),
(243, 'Yugoslavia', 'YU', '', 1, '2022-01-20 09:30:27', '2022-01-20 09:30:27'),
(244, 'Zaire', 'ZR', '', 1, '2022-01-20 09:30:27', '2022-01-20 09:30:27'),
(245, 'Zambia, Republic of (Former Northern Rhodesia)', 'ZM', '+260', 1, '2022-01-20 09:30:27', '2022-01-20 09:30:27'),
(246, 'Zimbabwe', 'ZW', '+263', 1, '2022-01-20 09:30:27', '2022-01-20 09:30:27');

-- --------------------------------------------------------

--
-- Table structure for table `customers`
--

DROP TABLE IF EXISTS `customers`;
CREATE TABLE IF NOT EXISTS `customers` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `invoice` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) DEFAULT NULL,
  `address_1` varchar(255) DEFAULT NULL,
  `address_2` varchar(255) DEFAULT NULL,
  `town` varchar(255) DEFAULT NULL,
  `county` varchar(255) DEFAULT NULL,
  `postcode` varchar(255) DEFAULT NULL,
  `phone` varchar(100) DEFAULT NULL,
  `name_ship` varchar(255) DEFAULT NULL,
  `address_1_ship` varchar(255) DEFAULT NULL,
  `address_2_ship` varchar(255) DEFAULT NULL,
  `town_ship` varchar(255) DEFAULT NULL,
  `county_ship` varchar(255) DEFAULT NULL,
  `postcode_ship` varchar(255) DEFAULT NULL,
  `physician_title` varchar(255) DEFAULT NULL,
  `physician_full_name` varchar(255) DEFAULT NULL,
  `age` varchar(255) DEFAULT NULL,
  `assign_physician` varchar(255) DEFAULT NULL,
  `date_registration` varchar(255) DEFAULT NULL,
  `sex` varchar(255) DEFAULT NULL,
  `email_physician` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=76 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `customers`
--

INSERT INTO `customers` (`id`, `invoice`, `name`, `email`, `address_1`, `address_2`, `town`, `county`, `postcode`, `phone`, `name_ship`, `address_1_ship`, `address_2_ship`, `town_ship`, `county_ship`, `postcode_ship`, `physician_title`, `physician_full_name`, `age`, `assign_physician`, `date_registration`, `sex`, `email_physician`) VALUES
(62, 'INV/2023/0019', 'samson snow', 'Juba', '29', 'Male', 'Juba', '', '02/07/2023', '', 'aklilu Tsehaye', 'akiye1997@gmail.com', 'Dr.', '', '', '', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(61, 'INV/2023/0018', 'Abrhet Mariqos', 'Beniu', '18', 'Female', 'Beniu', '', '28/06/2023', '', 'Nahom Ghebrihiwet', 'steclezion@gmail.com', 'Dr.', '', '', '', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(60, 'INV/2023/0017', 'Albert M Dunford\'', 'Nimule', '14', 'Female', 'Nimule', '', '28/06/2023', '', 'Samson Teclezion', 'demouser@mail.com', 'Dr.', '', '', '', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(44, 'INV/2023/0001', 'Albert M Dunford\'', 'Nimule', '14', 'Female', 'Nimule', 'Nimule', '28/06/2023', '14', 'Samson Teclezion', 'demouser@mail.com', 'Dr.', 'Dr.', 'Dr.', 'Dr.', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(45, 'INV/2023/0002', 'Albert M Dunford\'', 'Nimule', '14', 'Female', 'Nimule', 'Nimule', '28/06/2023', '14', 'Samson Teclezion', 'demouser@mail.com', 'Dr.', 'Dr.', 'Dr.', 'Dr.', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(46, 'INV/2023/0003', 'Albert M Dunford\'', 'Nimule', '14', 'Female', 'Nimule', 'Nimule', '28/06/2023', '14', 'Samson Teclezion', 'demouser@mail.com', 'Dr.', 'Dr.', 'Dr.', 'Dr.', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(47, 'INV/2023/0004', 'Albert M Dunford\'', 'Nimule', '14', 'Female', 'Nimule', 'Nimule', '28/06/2023', '14', 'Samson Teclezion', 'demouser@mail.com', 'Dr.', 'Dr.', 'Dr.', 'Dr.', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(48, 'INV/2023/0005', 'Albert M Dunford\'', 'Nimule', '14', 'Female', 'Nimule', 'Nimule', '28/06/2023', '14', 'Samson Teclezion', 'demouser@mail.com', 'Dr.', 'Dr.', 'Dr.', 'Dr.', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(49, 'INV/2023/0006', 'Roman Ghbere', 'Turalei', '14', 'Male', 'Turalei', 'Turalei', '29/06/2023', '14', 'Nahom Ghebrihiwet', 'steclezion@gmail.com', 'Dr.', 'Dr.', 'Dr.', 'Dr.', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(50, 'INV/2023/0007', 'Albert M Dunford\'', 'Nimule', '14', 'Female', 'Nimule', 'Nimule', '28/06/2023', '14', 'Samson Teclezion', 'demouser@mail.com', 'Dr.', 'Dr.', 'Dr.', 'Dr.', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(51, 'INV/2023/0008', 'Anne B Ruch', 'Juba', '18', 'Female', 'Juba', 'Juba', '28/06/2023', '18', 'Demo User', 'demouser@mail.com', 'FY1/FY2', 'FY1/FY2', 'FY1/FY2', 'FY1/FY2', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(52, 'INV/2023/0009', 'Anne B Ruch', 'Juba', '18', 'Female', 'Juba', 'Juba', '28/06/2023', '18', 'Demo User', 'demouser@mail.com', 'FY1/FY2', 'FY1/FY2', 'FY1/FY2', 'FY1/FY2', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(53, 'INV/2023/0010', 'Abrhet Mariqos', 'Beniu', '18', 'Female', 'Beniu', 'Beniu', '28/06/2023', '18', 'Nahom Ghebrihiwet', 'steclezion@gmail.com', 'Dr.', 'Dr.', 'Dr.', 'Dr.', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(54, 'INV/2023/0011', 'Ermias Ermias', 'Kuajo', '13', 'Male', 'Kuajo', 'Kuajo', '28/06/2023', '13', 'Samson Teclezion', 'demouser@mail.com', 'Dr.', 'Dr.', 'Dr.', 'Dr.', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(55, 'INV/2023/0012', 'Anne B Ruch', 'Juba', '18', 'Female', 'Juba', 'Juba', '28/06/2023', '18', 'Demo User', 'demouser@mail.com', 'FY1/FY2', 'FY1/FY2', 'FY1/FY2', 'FY1/FY2', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(56, 'INV/2023/0013', 'Seare Menghisteab', 'Juba', '40', 'Male', 'Juba', 'Juba', '01/07/2023', '40', 'Samson Teclezion', 'demouser@mail.com', 'Dr.', 'Dr.', 'Dr.', 'Dr.', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(57, 'INV/2023/0014', 'Roman Ghbere', 'Turalei', '14', 'Male', 'Turalei', 'Turalei', '29/06/2023', '14', 'Nahom Ghebrihiwet', 'steclezion@gmail.com', 'Dr.', '', '', '', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(58, 'INV/2023/0015', 'Albert M Dunford\'', 'Nimule', '14', 'Female', 'Nimule', '', '28/06/2023', '', 'Samson Teclezion', 'demouser@mail.com', 'Dr.', '', '', '', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(59, 'INV/2023/0016', 'Ermias Gebreluul', 'Eritrea', '27', 'Male', 'Eritrea', '', '01/07/2023', '', 'Nahom Ghebrihiwet', 'steclezion@gmail.com', 'Dr.', '', '', '', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(63, 'INV/2023/0020', 'samson snow', 'Juba', '29', 'Male', 'Juba', '', '02/07/2023', '', 'aklilu Tsehaye', 'akiye1997@gmail.com', 'Dr.', '', '', '', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(64, 'INV/2023/0021', 'Ermias Ermias', 'Kuajo', '13', 'Male', 'Kuajo', '', '28/06/2023', '', 'Samson Teclezion', 'demouser@mail.com', 'Dr.', '', '', '', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(65, 'INV/2023/0022', 'Abrhet Mariqos', 'Beniu', '18', 'Female', 'Beniu', '', '28/06/2023', '', 'Nahom Ghebrihiwet', 'steclezion@gmail.com', 'Dr.', '', '', '', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(66, 'INV/2023/0023', 'Seare Menghisteab', 'Juba', '40', 'Male', 'Juba', '', '01/07/2023', '', 'Samson Teclezion', 'demouser@mail.com', 'Dr.', '', '', '', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(67, 'INV/2023/0024', 'Demo User', 'Abyei', '97', 'Male', 'Abyei', '', '04/07/2023', '', 'Samson Teclezion', 'demouser@mail.com', 'Dr.', '', '', '', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(68, 'INV/2023/0025', 'Abrhet Mariqos', 'Beniu', '18', 'Female', 'Beniu', '', '28/06/2023', '', 'Nahom Ghebrihiwet', 'steclezion@gmail.com', 'Dr.', '', '', '', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(69, 'INV/2023/0026', 'Ermias Gebreluul', 'Eritrea', '27', 'Male', 'Eritrea', '', '01/07/2023', '', 'Nahom Ghebrihiwet', 'steclezion@gmail.com', 'Dr.', '', '', '', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(70, 'INV/2023/0027', 'Ermias Ermias', 'Kuajo', '13', 'Male', 'Kuajo', '', '28/06/2023', '', 'Samson Teclezion', 'demouser@mail.com', 'Dr.', '', '', '', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(71, 'INV/2023/0028', 'Abrhet Mariqos', 'Beniu', '18', 'Female', 'Beniu', '', '28/06/2023', '', 'Nahom Ghebrihiwet', 'steclezion@gmail.com', 'Dr.', '', '', '', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(72, 'INV/2023/0029', 'Albert M Dunford\'', 'Nimule', '14', 'Female', 'Nimule', '', '28/06/2023', '', 'Samson Teclezion', 'demouser@mail.com', 'Dr.', '', '', '', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(73, 'INV/2023/0030', 'Albert M Dunford\'', 'Nimule', '14', 'Female', 'Nimule', '', '28/06/2023', '', 'Samson Teclezion', 'demouser@mail.com', 'Dr.', '', '', '', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(74, 'INV/2023/0031', 'Abrhet Mariqos', 'Beniu', '18', 'Female', 'Beniu', '', '28/06/2023', '', 'Nahom Ghebrihiwet', 'steclezion@gmail.com', 'Dr.', '', '', '', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(75, 'INV/2023/0032', 'Albert M Dunford\'', 'Nimule', '14', 'Female', 'Nimule', '', '28/06/2023', '', 'Samson Teclezion', 'demouser@mail.com', 'Dr.', '', '', '', NULL, NULL, NULL, NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `department`
--

DROP TABLE IF EXISTS `department`;
CREATE TABLE IF NOT EXISTS `department` (
  `departmentid` int(10) NOT NULL AUTO_INCREMENT,
  `departmentname` varchar(100) NOT NULL,
  `description` text NOT NULL,
  `status` varchar(10) NOT NULL,
  `delete_status` int(11) NOT NULL,
  PRIMARY KEY (`departmentid`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `department`
--

INSERT INTO `department` (`departmentid`, `departmentname`, `description`, `status`, `delete_status`) VALUES
(1, 'ICU department', 'ICU department for people with serious illness', 'Active', 0),
(2, 'Neurology department', 'neurology department for treating diseases of nervous system', 'Active', 0);

-- --------------------------------------------------------

--
-- Table structure for table `doctor`
--

DROP TABLE IF EXISTS `doctor`;
CREATE TABLE IF NOT EXISTS `doctor` (
  `doctorid` int(10) NOT NULL AUTO_INCREMENT,
  `doctorname` varchar(50) NOT NULL,
  `mobileno` varchar(15) NOT NULL,
  `departmentid` int(10) NOT NULL,
  `status` varchar(100) NOT NULL,
  `education` varchar(250) NOT NULL,
  `consultancy_charge` int(11) NOT NULL,
  `delete_status` blob NOT NULL,
  `address_one` varchar(45) DEFAULT NULL,
  `email` varchar(45) DEFAULT NULL,
  `address_two` varchar(45) DEFAULT NULL,
  `town` varchar(45) DEFAULT NULL,
  `country_id` varchar(45) DEFAULT NULL,
  `postcode` varchar(45) DEFAULT NULL,
  `title` varchar(45) DEFAULT NULL,
  `Timestamp` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`doctorid`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `doctor`
--

INSERT INTO `doctor` (`doctorid`, `doctorname`, `mobileno`, `departmentid`, `status`, `education`, `consultancy_charge`, `delete_status`, `address_one`, `email`, `address_two`, `town`, `country_id`, `postcode`, `title`, `Timestamp`) VALUES
(11, 'Nahom Ghebrihiwet', '7893232', 1, 'Active', 'Master in Makerere University', 2, '', 'Hai-Neem Neemra Talata', 'steclezion@gmail.com', '!233', 'Juba', '242', '123', 'Dr.', NULL),
(12, 'Samson Teclezion', '929400500', 1, 'Active', 'Master', 52, '', '115 Demo Address', 'demouser@mail.com', 'Nimra Talata Boxing', 'DemoTown', '12', '--', 'Dr.', NULL),
(14, 'aklilu Tsehaye', '925362337', 2, 'Active', 'midical', 100, '', 'Luanda', 'akiye1997@gmail.com', '', 'luanda', '6', '0000', 'Dr.', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `invoices`
--

DROP TABLE IF EXISTS `invoices`;
CREATE TABLE IF NOT EXISTS `invoices` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `invoice` varchar(255) NOT NULL,
  `custom_email` text,
  `invoice_date` varchar(255) NOT NULL,
  `invoice_due_date` varchar(255) NOT NULL,
  `subtotal` decimal(10,0) NOT NULL,
  `shipping` varchar(255) NOT NULL,
  `discount` decimal(10,0) NOT NULL,
  `vat` decimal(10,0) NOT NULL,
  `total` decimal(10,0) NOT NULL,
  `notes` text NOT NULL,
  `invoice_type` varchar(255) NOT NULL,
  `status` varchar(255) NOT NULL,
  PRIMARY KEY (`id`,`vat`),
  UNIQUE KEY `invoice_UNIQUE` (`invoice`)
) ENGINE=MyISAM AUTO_INCREMENT=227 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `invoices`
--

INSERT INTO `invoices` (`id`, `invoice`, `custom_email`, `invoice_date`, `invoice_due_date`, `subtotal`, `shipping`, `discount`, `vat`, `total`, `notes`, `invoice_type`, `status`) VALUES
(196, 'INV/2023/0002', '', '30/06/2023', '30/06/2023', '13', '0.01', '0', '0', '13', '', 'invoice', 'paid'),
(195, 'INV/2023/0001', '', '30/06/2023', '30/06/2023', '2033', '0.01', '0', '0', '2033', '', 'invoice', 'paid'),
(197, 'INV/2023/0003', '', '30/06/2023', '30/06/2023', '13', '0.01', '0', '0', '13', '', 'invoice', 'paid'),
(198, 'INV/2023/0004', '', '30/06/2023', '30/06/2023', '38', '0.01', '0', '0', '38', '', 'invoice', 'paid'),
(199, 'INV/2023/0005', '', '30/06/2023', '30/06/2023', '38', '0.01', '0', '0', '38', '', 'invoice', 'paid'),
(200, 'INV/2023/0006', '', '30/06/2023', '30/06/2023', '30', '0.01', '0', '0', '30', '', 'invoice', 'paid'),
(201, 'INV/2023/0007', '', '30/06/2023', '30/06/2023', '25', '0.01', '0', '0', '25', '', 'invoice', 'paid'),
(202, 'INV/2023/0008', '', '30/06/2023', '30/06/2023', '60', '0.01', '0', '0', '60', '', 'invoice', 'paid'),
(203, 'INV/2023/0009', '', '30/06/2023', '30/06/2023', '188845', '0.01', '0', '0', '188845', '', 'invoice', 'paid'),
(204, 'INV/2023/0010', '', '30/06/2023', '30/06/2023', '10000', '0.01', '0', '0', '10000', '', 'invoice', 'paid'),
(205, 'INV/2023/0011', '', '30/06/2023', '30/06/2023', '25', '0.01', '0', '0', '25', '', 'invoice', 'paid'),
(206, 'INV/2023/0012', 'No I dont want work witjh', '30/06/2023', '30/06/2023', '109', '0.01', '0', '0', '109', 'Hellow sir how are you?', 'invoice', 'paid'),
(207, 'INV/2023/0013', '', '01/07/2023', '01/07/2023', '10060', '0.01', '0', '0', '10060', '', 'invoice', 'paid'),
(208, 'INV/2023/0014', '', '01/07/2023', '01/07/2023', '105', '0.01', '0', '0', '105', '', 'invoice', 'paid'),
(209, 'INV/2023/0015', '', '01/07/2023', '01/07/2023', '2033', '0.01', '0', '0', '2033', '', 'invoice', 'paid'),
(210, 'INV/2023/0016', '', '01/07/2023', '01/07/2023', '40', '0.01', '0', '0', '40', '', 'invoice', 'paid'),
(211, 'INV/2023/0017', '', '01/07/2023', '01/07/2023', '13', '0.01', '0', '0', '13', '', 'invoice', 'paid'),
(212, 'INV/2023/0018', '', '01/07/2023', '01/07/2023', '17588', '0.01', '0', '0', '17588', '', 'invoice', 'paid'),
(213, 'INV/2023/0019', '', '02/07/2023', '02/07/2023', '548', '0.01', '0', '0', '548', '', 'invoice', 'paid'),
(214, 'INV/2023/0020', '', '02/07/2023', '02/07/2023', '60012', '0.01', '0', '0', '60012', '', 'invoice', 'paid'),
(215, 'INV/2023/0021', '', '04/07/2023', '04/07/2023', '50', '0.01', '0', '0', '50', '', 'invoice', 'paid'),
(216, 'INV/2023/0022', '', '04/07/2023', '04/07/2023', '68', '0.01', '0', '0', '68', '', 'invoice', 'paid'),
(217, 'INV/2023/0023', '', '04/07/2023', '04/07/2023', '68', '0.01', '0', '0', '68', '', 'invoice', 'paid'),
(218, 'INV/2023/0024', '', '05/07/2023', '05/07/2023', '37', '0.01', '0', '0', '37', '', 'invoice', 'paid'),
(219, 'INV/2023/0025', '', '09/07/2023', '09/07/2023', '10012', '0.01', '0', '0', '10012', '', 'invoice', 'paid'),
(220, 'INV/2023/0026', '', '09/07/2023', '09/07/2023', '2227', '0.01', '0', '0', '2227', '', 'invoice', 'paid'),
(221, 'INV/2023/0027', '', '09/07/2023', '09/07/2023', '194', '0.01', '0', '0', '194', '', 'invoice', 'paid'),
(222, 'INV/2023/0028', '', '09/07/2023', '09/07/2023', '232', '0.01', '0', '0', '232', '', 'invoice', 'paid'),
(223, 'INV/2023/0029', '', '09/07/2023', '09/07/2023', '25', '0.01', '0', '0', '25', '', 'invoice', 'paid'),
(224, 'INV/2023/0030', '', '09/07/2023', '09/07/2023', '1271', '0.01', '0', '0', '1271', '', 'invoice', 'paid'),
(225, 'INV/2023/0031', '', '09/07/2023', '09/07/2023', '23', '0.01', '0', '0', '23', '', 'invoice', 'paid'),
(226, 'INV/2023/0032', '', '09/07/2023', '09/07/2023', '10165', '0.01', '0', '0', '10165', '', 'invoice', 'paid');

-- --------------------------------------------------------

--
-- Table structure for table `invoice_items`
--

DROP TABLE IF EXISTS `invoice_items`;
CREATE TABLE IF NOT EXISTS `invoice_items` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `invoice` varchar(255) NOT NULL,
  `product` text NOT NULL,
  `qty` int(11) NOT NULL,
  `price` varchar(255) NOT NULL,
  `discount` varchar(255) NOT NULL,
  `subtotal` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=268 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `invoice_items`
--

INSERT INTO `invoice_items` (`id`, `invoice`, `product`, `qty`, `price`, `discount`, `subtotal`) VALUES
(232, 'INV/2023/0011', 'Aspirin', 1, '25', '0', '25'),
(221, 'INV/2023/0009', 'ALLERGY AND INTOLERANCE TESTS', 14, '30', '0', '420.00'),
(222, 'INV/2023/0009', 'DENTAL LABORATORY TESTS', 9, '27', '0', '243.00'),
(223, 'INV/2023/0009', 'Aspirin', 6, '25', '0', '150.00'),
(224, 'INV/2023/0009', 'Registration', 15, '10000', '0', '150000.00'),
(225, 'INV/2023/0009', 'MICROBIOLOGICAL TESTS', 7, '2033', '0', '14231.00'),
(226, 'INV/2023/0009', 'HORMONE TESTS', 1, '12', '0', '12'),
(227, 'INV/2023/0009', 'CLINICAL URINE TESTS', 1, '194', '0', '194'),
(228, 'INV/2023/0009', 'NAhom tEst', 19, '1233', '0', '23427.00'),
(229, 'INV/2023/0009', 'HORMONE TESTS', 1, '12', '0', '12'),
(230, 'INV/2023/0009', 'BED', 13, '12', '0', '156.00'),
(231, 'INV/2023/0010', 'Registration', 1, '10000', '0', '10000'),
(219, 'INV/2023/0008', 'ALLERGY AND INTOLERANCE TESTS', 1, '30', '0', '30'),
(220, 'INV/2023/0008', 'ALLERGY AND INTOLERANCE TESTS', 1, '30', '0', '30'),
(218, 'INV/2023/0007', 'HORMONE TESTS', 1, '12', '0', '12'),
(217, 'INV/2023/0007', 'CLINICAL URINE TESTS', 1, '13', '0', '13'),
(216, 'INV/2023/0006', 'ALLERGY AND INTOLERANCE TESTS', 1, '30', '0', '30'),
(211, 'INV/2023/0001', 'MICROBIOLOGICAL TESTS', 1, '2033', '0', '2033'),
(212, 'INV/2023/0002', 'CLINICAL URINE TESTS', 1, '13', '0', '13'),
(213, 'INV/2023/0003', 'CLINICAL URINE TESTS', 1, '13', '0', '13'),
(214, 'INV/2023/0004', 'VITAMINS, MINERALS, TRACE ELEMENTS TESTS', 1, '38', '0', '38'),
(215, 'INV/2023/0005', 'TUMOR MARKER TESTS', 1, '38', '0', '38'),
(233, 'INV/2023/0012', 'INFECTIOUS SEROLOGY TESTS', 1, '34', '0', '34'),
(234, 'INV/2023/0012', 'Aspirin', 3, '25', '0', '75.00'),
(235, 'INV/2023/0013', 'Registration', 1, '10000', '0', '10000'),
(236, 'INV/2023/0013', 'ALLERGY AND INTOLERANCE TESTS', 2, '30', '0', '60.00'),
(237, 'INV/2023/0014', 'CLINICAL URINE TESTS', 1, '13', '0', '13'),
(238, 'INV/2023/0014', 'IMMUNOLOGICAL TESTS', 4, '23', '0', '92.00'),
(239, 'INV/2023/0015', 'MICROBIOLOGICAL TESTS', 1, '2033', '0', '2033'),
(240, 'INV/2023/0016', 'CLINICAL URINE TESTS', 1, '13', '0', '13'),
(241, 'INV/2023/0016', 'DENTAL LABORATORY TESTS', 1, '27', '0', '27'),
(242, 'INV/2023/0017', 'CLINICAL URINE TESTS', 1, '13', '0', '13'),
(243, 'INV/2023/0018', 'CLINICAL URINE TESTS', 1, '13', '0', '13'),
(244, 'INV/2023/0018', 'Registration', 1, '10000', '0', '10000'),
(245, 'INV/2023/0018', 'POLO', 1, '7575', '0', '7575'),
(246, 'INV/2023/0019', 'malaria +2', 1, '500', '0', '500'),
(247, 'INV/2023/0019', 'BED', 4, '12', '0', '48.00'),
(248, 'INV/2023/0020', 'MALARIA TEST PLUS 1', 2, '30000', '0', '60000.00'),
(249, 'INV/2023/0020', 'BED', 1, '12', '0', '12'),
(250, 'INV/2023/0021', 'VITAMINS, MINERALS, TRACE ELEMENTS TESTS', 1, '38', '0', '38'),
(251, 'INV/2023/0021', 'BED', 1, '12', '0', '12'),
(252, 'INV/2023/0022', 'INFECTIOUS SEROLOGY TESTS', 2, '34', '0', '68'),
(253, 'INV/2023/0023', 'INFECTIOUS SEROLOGY TESTS', 2, '34', '0', '68.00'),
(254, 'INV/2023/0024', 'Aspirin', 1, '25', '0', '25'),
(255, 'INV/2023/0024', 'HORMONE TESTS', 1, '12', '0', '12'),
(256, 'INV/2023/0025', 'HORMONE TESTS', 1, '12', '0', '12'),
(257, 'INV/2023/0025', 'Registration', 1, '10000', '0', '10000'),
(258, 'INV/2023/0026', 'CLINICAL URINE TESTS', 1, '194', '0', '194'),
(259, 'INV/2023/0026', 'MICROBIOLOGICAL TESTS', 1, '2033', '0', '2033'),
(260, 'INV/2023/0027', 'CLINICAL URINE TESTS', 1, '194', '0', '194'),
(261, 'INV/2023/0028', 'TUMOR MARKER TESTS', 1, '38', '0', '38'),
(262, 'INV/2023/0028', 'CLINICAL URINE TESTS', 1, '194', '0', '194'),
(263, 'INV/2023/0029', 'Aspirin', 1, '25', '0', '25'),
(264, 'INV/2023/0030', 'TUMOR MARKER TESTS', 1, '38', '0', '38'),
(265, 'INV/2023/0030', 'NAhom tEst', 1, '1233', '0', '1233'),
(266, 'INV/2023/0031', 'IMMUNOLOGICAL TESTS', 1, '23', '0', '23'),
(267, 'INV/2023/0032', 'MICROBIOLOGICAL TESTS', 5, '2033', '0', '10165');

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

DROP TABLE IF EXISTS `products`;
CREATE TABLE IF NOT EXISTS `products` (
  `product_id` int(11) NOT NULL AUTO_INCREMENT,
  `product_name` text NOT NULL,
  `product_desc` text NOT NULL,
  `product_price` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`product_id`)
) ENGINE=MyISAM AUTO_INCREMENT=1011 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`product_id`, `product_name`, `product_desc`, `product_price`) VALUES
(994, 'DENTAL LABORATORY TESTS', 'During the procedures, our bodies encounter a number of foreign substances that can trigger an immune response. Therefore, any complaints that may arise from dental treatments such as implants or root canal treatment may be due to an allergic reaction of the body, not to poor quality work of the dentist.  In the case of allergies, the immune system reacts to the materials used in dental procedures by producing antibodies and an immune response that makes the implantation and treatment less effective.  To detect the different immune responses after dental treatments, we were among the first in Hungary to develop the laboratory tests.', '27'),
(993, 'ALLERGY AND INTOLERANCE TESTS', 'Allergy and intolerance tests help identify the allergen causing the symptoms. Allergy tests can be performed by provocation tests or by blood sampling. In the case of a blood allergy test, allergen-specific IgE is measured. IgE molecules are antibodies belonging to the immunoglobulin superfamily, which are produced by the immune system to recognize and then neutralize foreign substances that have entered the body.', '30'),
(995, 'HORMONE TESTS', 'The bodyâ€™s endocrine glands (hypophysis, thyroid gland, parathyroid gland, pancreas, adrenal gland, ovary, testis) produce hormones that affect the functioning of the organs. The examination and treatment of hormonal disorders are performed by specialists in the field of internal medicine, endocrinology, and gynecology.', '12'),
(996, 'IMMUNOLOGICAL TESTS', 'Immunological laboratory tests can be used to detect the causes of recurrent infections, immunodeficiency diseases, and autoimmune diseases.', '23'),
(997, 'INFECTIOUS SEROLOGY TESTS', 'By detecting antibodies against various pathogens, we look for the background of acute and chronic infections. With their help, we can show receptivity, the course of the infection, and protection against a pathogen. Serostatus tests before and during pregnancy are very important. (TORCH panel: Toxoplasma, Rubella, Cytomegalia, Herpes simplex, and Varicella).', '34'),
(998, 'MICROBIOLOGICAL TESTS', 'Medical microbiology examines the pathogens of infectious diseases and organisms found in the normal flora of the human body, as well as the details, manner, and course of host-infection interactions, and the possibility of protection and prevention against them.', '2033'),
(999, 'CLINICAL URINE TESTS', 'A urine test could detect kidney function diseases and a nu', '13'),
(1002, 'Aspirin', 'Asprin 12', '25'),
(1003, 'Registration', 'Registration', '10000'),
(1004, 'BED', 'BED', '12'),
(1000, 'VITAMINS, MINERALS, TRACE ELEMENTS TESTS', 'A diverse diet could ensure the intake of minerals, trace elements, and vitamins, however, in case of certain conditions or increased stress, additional supplementation may be necessary. Their lack, next to proper nutrition, might refer to an illness', '38'),
(1001, 'TUMOR MARKER TESTS', 'Tumor markers are produced by tumor cells. The laboratory tests can detect these in body secretions: blood, urine, cerebrospinal fluid, feces. These tests are recommended if there are any complaints or symptoms that raise the possibility of a tumor.  If the tumor marker test is performed before the tumor therapy, the monitoring of the parameter is suitable for monitoring the effectiveness of the therapy, and for indicating the recurrence of the tumor.  A negative test result (the tumor marker concentration is in the normal range) does not necessarily indicate a tumor-free condition, as a positive result does not necessarily indicate cancer.  In the case of positivity, only further tests can determine the presence of a cancerous lesion.', '38'),
(1005, 'CLINICAL URINE TESTS', 'A urine test could detect kidney function diseases and a nu', '194'),
(1006, 'NAhom tEst', 'ALLERGY AND INTOLERANCE TESTS', '1233'),
(1007, 'POLO', 'fsdklfjklsdajflksdj', '7575'),
(1008, 'MALARIA TEST PLUS 1', 'FEVER', '30000'),
(1009, 'malaria +2', 'blood test', '500'),
(1010, 'Ema', 'dgdfgdfgdfgd', '1200');

-- --------------------------------------------------------

--
-- Table structure for table `store_customers`
--

DROP TABLE IF EXISTS `store_customers`;
CREATE TABLE IF NOT EXISTS `store_customers` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  `town` varchar(255) DEFAULT NULL,
  `age` varchar(45) DEFAULT NULL,
  `sex` varchar(45) DEFAULT NULL,
  `assigned_dr` varchar(45) DEFAULT NULL,
  `date_of_reg` varchar(45) DEFAULT NULL,
  `Timestamp` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=85 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `store_customers`
--

INSERT INTO `store_customers` (`id`, `name`, `town`, `age`, `sex`, `assigned_dr`, `date_of_reg`, `Timestamp`) VALUES
(76, 'Ermias Ermias', 'Kuajo', '13', 'Male', '12', '28-06-2023', NULL),
(77, 'Abrhet Mariqos', 'Beniu', '18', 'Female', '11', '28-06-2023', NULL),
(78, 'Albert M Dunford\'', 'Nimule', '14', 'Female', '12', '28-06-2023', NULL),
(79, 'Anne B Ruch', 'Juba', '18', 'Female', '13', '28-06-2023', NULL),
(80, 'Roman Ghbere', 'Turalei', '14', 'Male', '11', '29-06-2023', NULL),
(81, 'Seare Menghisteab', 'Juba', '40', 'Male', '12', '01-07-2023', NULL),
(82, 'Ermias Gebreluul', 'Eritrea', '27', 'Male', '11', '01-07-2023', NULL),
(83, 'samson snow', 'Juba', '29', 'Male', '14', '02-07-2023', NULL),
(84, 'Demo User', 'Abyei', '97', 'Male', '12', '04-07-2023', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `town`
--

DROP TABLE IF EXISTS `town`;
CREATE TABLE IF NOT EXISTS `town` (
  `town_id` int(11) NOT NULL,
  `town_name` varchar(45) DEFAULT NULL,
  `town_location` varchar(45) DEFAULT NULL,
  `town_description` varchar(45) DEFAULT NULL,
  `created_at` varchar(45) DEFAULT NULL,
  `uploaded_at` varchar(45) DEFAULT NULL,
  `Timestamp` timestamp NULL DEFAULT NULL,
  `towncol` varchar(45) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `town`
--

INSERT INTO `town` (`town_id`, `town_name`, `town_location`, `town_description`, `created_at`, `uploaded_at`, `Timestamp`, `towncol`) VALUES
(1, 'Juba', NULL, NULL, NULL, NULL, NULL, NULL),
(2, 'Beniu', NULL, NULL, NULL, NULL, NULL, NULL),
(3, 'Yei', NULL, NULL, NULL, NULL, NULL, NULL),
(4, 'Renk', NULL, NULL, NULL, NULL, NULL, NULL),
(5, 'Kuajo', NULL, NULL, NULL, NULL, NULL, NULL),
(6, 'Nimule', NULL, NULL, NULL, NULL, NULL, NULL),
(7, 'Abyei', NULL, NULL, NULL, NULL, NULL, NULL),
(8, 'Leer', NULL, NULL, NULL, NULL, NULL, NULL),
(9, 'Raga', NULL, NULL, NULL, NULL, NULL, NULL),
(10, 'Ezo', NULL, NULL, NULL, NULL, NULL, NULL),
(11, 'Turalei', NULL, NULL, NULL, NULL, NULL, NULL),
(12, 'Malakal', NULL, NULL, NULL, NULL, NULL, NULL),
(13, 'Wau', NULL, NULL, NULL, NULL, NULL, NULL),
(15, 'Yambio', NULL, NULL, NULL, NULL, NULL, NULL),
(16, 'Maridi', NULL, NULL, NULL, NULL, NULL, NULL),
(17, 'Gorial', NULL, NULL, NULL, NULL, NULL, NULL),
(18, 'Pajok', NULL, NULL, NULL, NULL, NULL, NULL),
(19, 'Wanyjok', NULL, NULL, NULL, NULL, NULL, NULL),
(20, 'Tambura', NULL, NULL, NULL, NULL, NULL, NULL),
(21, 'Yei', NULL, NULL, NULL, NULL, NULL, NULL),
(22, 'Tonj', NULL, NULL, NULL, NULL, NULL, NULL),
(23, 'Oroba', NULL, NULL, NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `username` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `phone` varchar(100) NOT NULL,
  `password` varchar(200) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `username`, `email`, `phone`, `password`) VALUES
(1, 'Liam Moore', 'admin', 'admin@codeastro.com', '7896541250', 'd00f5d5217896fb7fd601412cb890830'),
(2, 'Nahom', 'nahom', 'nahomata@gmail.com', '00211922562622', '202cb962ac59075b964b07152d234b70'),
(3, 'Aklili Tsehaye Mihtsun', 'Aklilu', 'akiye1997@gmail.com', '+244 925 362 337', 'ff5863f89907077d2de51e624120d7db'),
(4, 'Sam Tec', 'steclezion', 'steclezion@gmail.com', '+211980253474', '210b48b542659fb951a80a15c5997513');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
