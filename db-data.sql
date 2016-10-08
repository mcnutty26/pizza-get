-- phpMyAdmin SQL Dump
-- version 4.0.10deb1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Oct 08, 2016 at 05:57 PM
-- Server version: 10.1.16-MariaDB-1~trusty
-- PHP Version: 5.5.9-1ubuntu4.20

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `pizzaget`
--

-- --------------------------------------------------------

--
-- Table structure for table `hir2_events`
--

CREATE TABLE IF NOT EXISTS `hir2_events` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `discount` float NOT NULL,
  `discountSides` tinyint(1) NOT NULL,
  `active` tinyint(1) NOT NULL,
  `live` tinyint(1) NOT NULL,
  `deadline` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `hir2_events`
--

INSERT INTO `hir2_events` (`id`, `discount`, `discountSides`, `active`, `live`, `deadline`) VALUES
(1, 1, 1, 1, 0, '2016-10-07 22:18:00');

-- --------------------------------------------------------

--
-- Table structure for table `hir2_ingredients`
--

CREATE TABLE IF NOT EXISTS `hir2_ingredients` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `pizza` int(11) NOT NULL,
  `topping` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `pizza` (`pizza`),
  KEY `topping` (`topping`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=12 ;

--
-- Dumping data for table `hir2_ingredients`
--

INSERT INTO `hir2_ingredients` (`id`, `pizza`, `topping`) VALUES
(1, 2, 3),
(2, 2, 7),
(3, 2, 8),
(4, 2, 10),
(5, 2, 11),
(6, 2, 14),
(7, 5, 11),
(8, 6, 2),
(9, 6, 6),
(10, 6, 14),
(11, 6, 15);

-- --------------------------------------------------------

--
-- Table structure for table `hir2_log`
--

CREATE TABLE IF NOT EXISTS `hir2_log` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) CHARACTER SET utf8 NOT NULL,
  `order` varchar(500) CHARACTER SET utf8 NOT NULL,
  `price` int(11) NOT NULL,
  `cardTransaction` tinyint(1) NOT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=238 ;

--
-- Dumping data for table `hir2_log`
--

INSERT INTO `hir2_log` (`id`, `name`, `order`, `price`, `cardTransaction`, `date`) VALUES
(2, 'Max Cherrill', 'A Medium Normal Crust Cheese and Tomato with Garlic Pizza Bread (Extra Cheese)', 749, 0, '2015-11-13 20:33:10'),
(3, 'Matthew Eakin ', 'A Large Italian Crust Vegi Supreme', 850, 0, '2015-11-13 20:34:01'),
(4, 'Bradley Garlick', 'A Personal Normal Crust Build Your Own - Tomato Sauce, Mozarella Cheese, Ground Beef, Pineapple', 280, 0, '2015-11-13 20:36:51'),
(5, 'Edward', 'A Large Normal Crust Texas BBQ with The Big Garlic and Herb Dip', 950, 0, '2015-11-13 20:37:49'),
(6, 'James Fitzpatrick', 'A Medium Normal Crust Build Your Own - Tomato Sauce, Mozarella Cheese, Ground Beef', 610, 0, '2015-11-13 20:38:18'),
(7, 'Eleanor Pratt', 'A Personal Normal Crust Pepperoni Passion with Coca Cola (500ml), Fanta (500ml)', 425, 0, '2015-11-13 20:38:56'),
(8, 'Sam', 'A Medium Stuffed Crust Cheese and Tomato', 675, 0, '2015-11-13 20:41:21'),
(9, 'Jiaman', 'A Medium Normal Crust Build Your Own - Tomato Sauce, Mozarella Cheese, Ham, Mushrooms, Pepperoni', 730, 0, '2015-11-13 20:41:51'),
(10, 'Tom Sawyer', 'A Personal Normal Crust Cheese and Tomato with Chick ''n'' Mix Box, Chicken Strippers, Fanta (500ml)', 911, 0, '2015-11-13 20:42:36'),
(11, 'Abbaas Rafiq', 'A Large Normal Crust Build Your Own - BBQ Sauce, Mozarella Cheese, Green and Red Peppers, Red Onions', 780, 0, '2015-11-13 20:45:50'),
(12, 'Callum', 'A Large Normal Crust Cheese and Tomato', 650, 0, '2015-11-13 20:46:50'),
(13, 'Jai Sharma', 'A Large Stuffed Crust Texas BBQ (Yee)', 1025, 0, '2015-11-13 20:50:00'),
(14, 'Ian Domone', 'A Large Normal Crust Meateor', 900, 0, '2015-11-13 21:00:50'),
(15, 'Jimmy ', 'A Large Normal Crust New Yorker with Fanta (500ml)', 912, 0, '2015-11-13 21:02:24'),
(16, 'Marmite', 'A Medium Normal Crust Pepperoni Passion with Garlic Pizza Bread, Coca Cola (500ml)', 1012, 0, '2015-11-13 21:05:02'),
(17, 'Ali Patton', 'A Medium Normal Crust Build Your Own - Tomato Sauce, Mozarella Cheese, Chicken Breast Strips, Ground Beef, Jalapeno Peppers', 730, 0, '2015-11-20 20:15:48'),
(18, 'metalgabu', 'No Pizza - Sides Only with Garlic Pizza Bread, Chicken Wings (thank)', 449, 0, '2015-11-20 20:45:46'),
(19, 'Max Cherrill', 'A Small Normal Crust Cheese and Tomato (Extra Cheese!)', 450, 0, '2015-11-20 21:10:41'),
(20, 'Callum', 'A Large Normal Crust Cheese and Tomato', 650, 0, '2015-11-20 21:23:26'),
(21, 'Zoggoth', 'A Large Normal Crust Meatilicious', 900, 0, '2015-11-20 21:25:35'),
(22, 'Paolo', 'A Large Normal Crust Hot and Spicy with The Big Garlic and Herb Dip, Chilli Flakes, Coca Cola (500ml)', 1005, 1, '2015-11-20 21:25:48'),
(23, 'Ryan  Davis', 'A Small Normal Crust Pepperoni Passion', 682, 1, '2015-11-20 21:26:43'),
(24, 'Tom Pickford', 'A Large Normal Crust Meatilicious', 937, 1, '2015-11-20 21:29:00'),
(25, 'Abbaas Rafiq', 'A Large Normal Crust Build Your Own - Tomato Sauce, Mozarella Cheese, Green and Red Peppers, Red Onions', 780, 0, '2015-11-20 21:29:03'),
(26, 'J', 'A Medium Normal Crust Build Your Own - Tomato Sauce, Mozarella Cheese, Ham, Mushrooms, Pepperoni', 730, 0, '2015-11-20 21:29:48'),
(27, 'Jai Sharma', 'A Large Stuffed Crust Cheese and Tomato/Tandoori Hot', 975, 0, '2015-11-20 21:44:04'),
(28, 'Jai Sharma', 'A Large Stuffed Crust Cheese and Tomato/Tandoori Hot (:(){ :|:& };:)', 1013, 1, '2015-11-20 21:49:22'),
(29, 'Domenico', 'A Large Normal Crust Mighty Meaty', 900, 0, '2015-11-20 22:14:48'),
(30, 'Truby', 'A Medium BBQ Stuffed Crust Build Your Own - Tomato Sauce, Mozarella Cheese, Garlic Butter, Ground Beef, Ham, Red Onions, Tandoori Chicken', 975, 0, '2015-11-27 18:25:53'),
(31, 'mcnutty', 'A Large Normal Crust Pepperoni Passion/Vegi Volcano (YOLO)', 850, 0, '2015-11-27 18:26:30'),
(32, 'Maddy', 'A Medium Stuffed Crust Build Your Own - Tomato Sauce, Mozarella Cheese, Ham, Mushrooms', 830, 1, '2015-11-27 18:33:01'),
(33, 'hermit', 'A Large Stuffed Crust Build Your Own - Tomato Sauce, Mozarella Cheese, Chicken Breast Strips, Green and Red Peppers, Pork Meatballs, Red Onions with Potato Wedges, Dips', 1302, 1, '2015-11-27 18:33:03'),
(34, 'Jai Sharma', 'A Large Stuffed Crust Tandoori Hot (yee)', 1013, 1, '2015-11-27 18:35:19'),
(35, 'Glynn Taylor', 'A Large Normal Crust Chicken Feast', 886, 1, '2015-11-27 18:37:57'),
(36, 'asd', 'A Large Normal Crust Cheese and Tomato', 650, 0, '2015-12-04 21:09:45'),
(37, 'Marmite', 'A Medium Italian Crust Pepperoni Passion with Chicken Strippers', 999, 0, '2015-12-04 21:23:20'),
(38, 'Abbaas Rafiq', 'A Large Italian Crust Cheese and Tomato (Free topping thingies: green and red peppers and red onions)', 650, 0, '2015-12-04 21:44:24'),
(39, 'J', 'A Medium Italian Crust Build Your Own - Tomato Sauce, Mozarella Cheese, Ham, Mushrooms, Pepperoni', 730, 0, '2015-12-04 21:48:09'),
(40, 'Edward Wenban', 'A Large Normal Crust Meateor with The Big Garlic and Herb Dip', 950, 0, '2015-12-04 22:00:17'),
(41, 'Callum', 'A Large Normal Crust Cheese and Tomato', 650, 0, '2015-12-04 22:35:53'),
(42, 'Sam', 'A Large Stuffed Crust Cheese and Tomato', 775, 0, '2015-12-04 22:36:11'),
(43, 'Jessica', 'A Personal Normal Crust Cheese and Tomato with Chick ''n'' Mix Box', 599, 0, '2015-12-04 22:38:37'),
(44, 'Mega Man', 'A Personal Normal Crust Build Your Own - Tomato Sauce, Mozarella Cheese, Ground Beef, Pineapple', 280, 0, '2015-12-04 22:44:01'),
(45, 'Zoggoth', 'A Large Normal Crust Mighty Meaty', 900, 0, '2015-12-04 23:12:38'),
(46, 'Cyberia', 'A Large Normal Crust Texas BBQ (2x bacon 2x chicken -onions -peppers)', 900, 0, '2015-12-11 22:02:15'),
(47, 'Ian Domone', 'A Large Normal Crust Meateor', 900, 0, '2015-12-11 22:02:28'),
(48, 'Sam', 'A Large Stuffed Crust Cheese and Tomato with Coke Zero (500ml)', 837, 0, '2015-12-11 22:02:57'),
(49, 'Ali Patton', 'A Medium Normal Crust Build Your Own - Tomato Sauce, Mozarella Cheese, Chicken Breast Strips, Jalapeno Peppers', 670, 0, '2015-12-11 22:03:43'),
(50, 'Max Cherrill', 'A Large Normal Crust Cheese and Tomato (Extra Cheese!)', 650, 0, '2015-12-11 22:04:28'),
(51, 'Vignesh ', 'A Large Normal Crust Cheese and Tomato (Extra Cheese)', 650, 0, '2015-12-11 22:05:35'),
(52, 'Huwen Edwards', 'A Small Normal Crust Cheese and Tomato', 450, 0, '2015-12-11 22:05:39'),
(53, 'Marmite', 'A Medium Italian Crust Pepperoni Passion with Coca Cola (500ml)', 847, 1, '2015-12-11 22:05:44'),
(54, 'Ryan Davis', 'A Small Normal Crust Texas BBQ', 733, 1, '2015-12-11 22:08:18'),
(55, 'Faheem Mirza', 'A Small Normal Crust Vegi Volcano', 650, 0, '2015-12-11 22:08:19'),
(56, 'Vergo', 'A Large Normal Crust Vegi Supreme/Chicken Feast', 850, 0, '2015-12-11 22:08:27'),
(57, 'Zoggoth', 'A Large Normal Crust New Yorker (DROP TABLE MEMES;)', 850, 0, '2015-12-11 22:08:42'),
(58, 'J', 'A Medium Normal Crust Build Your Own - Tomato Sauce, Mozarella Cheese, Ham, Mushrooms, Pepperoni', 730, 0, '2015-12-11 22:10:22'),
(59, 'MaxC', 'A Large Normal Crust Cheese and Tomato (Extra Cheese!)', 682, 1, '2015-12-11 22:10:31'),
(60, 'Jessica', 'A Personal Normal Crust Cheese and Tomato with Chick ''n'' Mix Box, Fanta (500ml), Sprite (500ml)', 724, 0, '2015-12-11 22:10:43'),
(61, 'Vignesh', 'A Large Normal Crust Cheese and Tomato (Extra Cheese)', 682, 1, '2015-12-11 22:12:06'),
(62, 'Alex', 'A Small Normal Crust New Yorker', 682, 1, '2015-12-11 22:12:30'),
(63, 'the hacker known as 4chan', 'A Large Normal Crust Tandoori Hot (https://www.youtube.com/watch?v=dQw4w9WgXcQ)', 886, 1, '2015-12-11 22:22:38'),
(64, 'Abbaas Rafiq', 'A Large Italian Crust Build Your Own - Tomato Sauce, Mozarella Cheese, Green and Red Peppers, Red Onions', 780, 0, '2015-12-11 22:24:35'),
(65, 'Mirbaele', 'A Medium Normal Crust Vegi Volcano/Mighty Meaty', 800, 0, '2015-12-11 23:05:46'),
(66, 'Max Cherrill', 'A Large Normal Crust Cheese and Tomato (Extra Cheese!)', 682, 1, '2016-01-15 21:32:55'),
(67, 'Callum', 'A Large Normal Crust Cheese and Tomato', 650, 0, '2016-01-15 21:33:13'),
(68, 'J', 'A Large Normal Crust New Yorker (Smoke bacon rashers -> change to Ham please)', 850, 0, '2016-01-15 21:33:43'),
(69, 'Paolo Juan', 'A Large Normal Crust Meateor with The Big Garlic and Herb Dip, Coca Cola (500ml)', 1051, 1, '2016-01-15 21:35:38'),
(70, 'Marmite', 'A Medium Italian Crust Pepperoni Passion with Coca Cola (500ml)', 812, 0, '2016-01-15 21:35:39'),
(71, 'Ryan Davis', 'A Small Normal Crust Texas BBQ', 733, 1, '2016-01-15 21:36:21'),
(72, 'siyuan ma', 'A Medium Normal Crust Ham and Pineapple', 750, 0, '2016-01-15 21:37:01'),
(73, 'Jessica', 'A Personal Normal Crust Cheese and Tomato with Chick ''n'' Mix Box', 599, 0, '2016-01-15 21:37:47'),
(74, 'Edward', 'A Large Normal Crust Texas BBQ with The Big Garlic and Herb Dip', 950, 0, '2016-01-15 21:38:21'),
(75, 'Sean Adamson', 'A Large Normal Crust Meateor/Chicken Feast', 900, 0, '2016-01-15 21:38:28'),
(76, 'James', 'A Large Normal Crust Meateor with Garlic Pizza Bread, Potato Wedges', 1299, 0, '2016-01-15 21:39:13'),
(77, 'Ali Patton', 'A Medium Normal Crust Build Your Own - Tomato Sauce, Mozarella Cheese, Chicken Breast Strips, Jalapeno Peppers', 670, 0, '2016-01-15 21:39:27'),
(78, 'Sam ', 'A Large Stuffed Crust Cheese and Tomato with Diet Coca Cola (500ml)', 837, 0, '2016-01-15 21:39:38'),
(79, 'Ella', 'A Large Normal Crust Cheese and Tomato with Nachos, Ben & Jerry''s - Cookie Dough (bbq sauce instead of tomato sauce pls)', 1074, 0, '2016-01-15 21:43:35'),
(80, 'Ellie', 'A Small Normal Crust Cheese and Tomato with Ben & Jerry''s - Cookie Dough', 699, 0, '2016-01-15 21:45:16'),
(81, 'Zoggoth', 'A Large Normal Crust Pepperoni Passion with Chick ''n'' Mix Box', 1249, 0, '2016-01-15 21:46:32'),
(82, 'Johan Byttner', 'A Large Normal Crust Mighty Meaty', 937, 1, '2016-01-15 22:18:14'),
(83, 'Jai Sharma', 'A Large Stuffed Crust Texas BBQ', 1064, 1, '2016-01-22 20:42:43'),
(84, 'Ryan Davis', 'A Medium Normal Crust Tandoori Hot', 784, 1, '2016-01-22 20:44:03'),
(85, 'Callum', 'A Large Stuffed Crust Pepperoni Passion with Fanta (500ml)', 1037, 0, '2016-01-22 20:44:21'),
(86, 'J', 'A Medium Normal Crust New Yorker (No bacon rasher, ham instead please)', 750, 0, '2016-01-22 20:44:36'),
(87, 'Sam', 'A Medium Stuffed Crust Cheese and Tomato with Diet Coca Cola (500ml)', 737, 0, '2016-01-22 20:46:27'),
(88, 'Max C', 'A Large Normal Crust Cheese and Tomato (Extra Cheese)', 682, 1, '2016-01-22 20:47:15'),
(89, 'Matthew F', 'A Large Normal Crust Vegi Volcano with Coca Cola (500ml)', 912, 0, '2016-01-22 20:47:20'),
(90, 'Jessica', 'A Personal Normal Crust Cheese and Tomato with Chicken Strippers, Fanta (500ml)', 512, 0, '2016-01-22 20:48:35'),
(91, 'siyuan', 'A Large Normal Crust Meateor (hello)', 900, 0, '2016-01-22 20:49:07'),
(92, 'siyuan', 'A Large Normal Crust Ham and Pineapple with The Big Garlic and Herb Dip', 900, 0, '2016-01-22 20:49:51'),
(93, 'Lord of the Memes', 'No Pizza - Sides Only with Garlic Pizza Bread, Chicken Kickers', 449, 0, '2016-01-22 20:49:56'),
(94, 'Antonio Rolandelli', 'A Large Normal Crust Texas BBQ/Ranch BBQ', 900, 0, '2016-01-22 20:49:57'),
(95, 'Lord of the Memes', 'No Pizza - Sides Only with Garlic Pizza Bread, Chicken Kickers', 449, 0, '2016-01-22 20:50:18'),
(96, 'Gokul', 'A Large Normal Crust New Yorker', 886, 1, '2016-01-22 20:52:41'),
(97, 'Bradley Garlick', 'A Personal Normal Crust Cheese and Tomato', 200, 0, '2016-01-22 20:54:13'),
(98, 'Paolo', 'A Large Stuffed Crust Tandoori Hot with The Big Garlic and Herb Dip, Coca Cola (500ml)', 1128, 1, '2016-01-22 20:58:24'),
(99, 'Sean Adamson', 'A Large Normal Crust Chicken Feast', 850, 0, '2016-01-22 21:02:24'),
(100, 'Zoggoth', 'A Large Normal Crust Pepperoni Passion with Spicy BBQ Wings', 1099, 0, '2016-01-22 21:09:14'),
(101, 'Cyberia', 'A Large Normal Crust Texas BBQ (2xBacon 2xChicken -Onions -Peppers)', 900, 0, '2016-01-22 21:09:38'),
(102, 'Matthew Piper', 'A Large Hotdog Stuffed Crust with Mustard Build Your Own - Tomato Sauce, Mozarella Cheese, Cumberland Sausage, Red Onions', 905, 0, '2016-01-29 20:38:26'),
(103, 'Callum', 'A Large Stuffed Crust Pepperoni Passion with Fanta (500ml)', 1037, 0, '2016-01-29 20:38:44'),
(104, 'Ali Patton', 'A Medium Normal Crust Build Your Own - Tomato Sauce, Mozarella Cheese, Chicken Breast Strips, Cumberland Sausage, Jalapeno Peppers', 730, 0, '2016-01-29 20:39:01'),
(105, 'Daniel Walvin', 'A Large Stuffed Crust Meateor', 1025, 0, '2016-01-29 20:43:45'),
(106, 'Alex Zhou', 'A Small Normal Crust New Yorker', 650, 0, '2016-01-29 20:44:11'),
(107, 'Sean Adamson', 'A Large Normal Crust Chicken Feast/Vegi Supreme', 850, 0, '2016-01-29 20:44:23'),
(108, 'Ryan', 'A Medium Normal Crust Hot and Spicy', 750, 0, '2016-01-29 20:44:34'),
(109, 'Jai Sharma', 'A Large Normal Crust Texas BBQ with Coca Cola (500ml)', 962, 0, '2016-01-29 21:03:30'),
(110, 'Max C', 'A Large Normal Crust Cheese and Tomato', 682, 1, '2016-02-12 20:54:59'),
(111, 'Ali Patton', 'A Medium Normal Crust Build Your Own - Tomato Sauce, Mozarella Cheese, Jalapeno Peppers, Tandoori Chicken', 670, 0, '2016-02-12 20:56:28'),
(112, 'Sam', 'A Medium Stuffed Crust Cheese and Tomato with Diet Coca Cola (500ml)', 737, 0, '2016-02-12 20:56:53'),
(113, 'Gokul', 'A Large Normal Crust Meateor', 937, 1, '2016-02-12 20:57:31'),
(114, 'Gokul', 'A Large Normal Crust New Yorker', 886, 1, '2016-02-12 20:59:02'),
(115, 'Jessica ', 'A Personal Normal Crust Cheese and Tomato with Chicken Strippers, Fanta (500ml)', 512, 0, '2016-02-12 20:59:35'),
(116, 'Calvin', 'A Large Normal Crust New Yorker', 850, 0, '2016-02-12 21:02:10'),
(117, 'Callum', 'A Large BBQ Stuffed Crust Meateor with Fanta (500ml)', 1087, 0, '2016-02-12 21:02:12'),
(118, 'Walvin-desu', 'A Large Stuffed Crust Meateor (Switch pepperoni for chicken breast strips. If impossible then pepperoni is fine.)', 1025, 0, '2016-02-12 21:05:59'),
(119, 'Zoggoth NOT PIZZA', 'A Large Normal Crust Cheese and Tomato (DONT ORDER ME A CHEESE AND TOMATO PIZZA, ORDER 21 BBQ WINGS, also DORP TALBE)', 650, 0, '2016-02-12 21:06:12'),
(120, 'Ryan', 'A Medium Normal Crust Hot and Spicy', 750, 0, '2016-02-12 21:18:20'),
(121, 'Murtag', 'A Large Hotdog Stuffed Crust with Mustard Build Your Own - Tomato Sauce, Mozarella Cheese, Anchovies, Chicken Breast Strips, Cumberland Sausage, Red Onions (Double Cumberland Sausage and Double Red Onions)', 1035, 0, '2016-02-12 21:20:29'),
(122, 'jai', 'A Medium Hotdog Stuffed Crust Texas BBQ with Dr Pepper (500ml) (ayy lmao)', 1026, 1, '2016-02-12 21:22:00'),
(123, 'Max C', 'A Large Normal Crust Cheese and Tomato', 682, 1, '2016-02-19 20:24:23'),
(124, 'Sean Adamson', 'A Large Normal Crust Chicken Feast/Mighty Meaty with The Big Garlic and Herb Dip', 950, 0, '2016-02-19 20:58:14'),
(125, 'Phillip', 'A Large Normal Crust Meateor', 900, 0, '2016-02-19 21:01:24'),
(126, 'Jai Sharma', 'A Large Stuffed Crust Cheese and Tomato/Texas BBQ', 1025, 0, '2016-02-19 21:03:53'),
(127, 'Paolo', 'A Large Normal Crust Texas BBQ with Coca Cola (500ml) (2xBacon 2xChicken -Peppers -Onions)', 1000, 1, '2016-02-19 21:04:44'),
(128, 'Varun ', 'A Large Normal Crust Vegi Supreme (No cheese on pizza pls )', 850, 0, '2016-02-19 21:06:41'),
(129, 'Jai Sharma', 'A Large Stuffed Crust Texas BBQ (Ayy lmao, im in charge)', 1025, 0, '2016-02-26 20:31:39'),
(130, 'Max C', 'A Large Normal Crust Cheese and Tomato', 682, 1, '2016-02-26 20:33:36'),
(131, '<b>MEME_LORD</b>', 'A Medium Normal Crust Build Your Own - Tomato Sauce, Mozarella Cheese, Cumberland Sausage, Mushrooms, Pineapple, Red Onions (<marquee>ayy lmao</marquee>)', 825, 1, '2016-02-26 20:35:50'),
(132, '<b>MEME_LORD</b>', 'A Large Normal Crust Build Your Own - Tomato Sauce, Mozarella Cheese, Pepperoni, Smoked Bacon Rashers (<marquee> A_Y_Y_L_M_A_O)', 814, 1, '2016-02-26 20:37:55'),
(133, 'Ali Patton', 'A Medium Normal Crust Build Your Own - Tomato Sauce, Mozarella Cheese, Cumberland Sausage, Jalapeno Peppers, Tuna', 730, 0, '2016-02-26 20:38:00'),
(134, 'Ryan ', 'A Large Normal Crust Tandoori Hot', 850, 0, '2016-02-26 20:40:00'),
(135, 'J', 'A Large Normal Crust New Yorker (No bacon, ham instead please)', 850, 0, '2016-02-26 20:46:34'),
(136, 'Zoggoth NOT PIZZA', 'A Large Normal Crust Cheese and Tomato (DONT ORDER ME A CHEESE AND TOMATO PIZZA, ORDER 21 BBQ WINGS, also DORP TALBE)', 650, 0, '2016-02-26 20:48:58'),
(137, 'Abbaas Rafiq', 'A Large Normal Crust Build Your Own - Tomato Sauce, Mozarella Cheese, Green and Red Peppers, Red Onions', 780, 0, '2016-02-26 20:51:17'),
(138, 'Callum', 'A Large Normal Crust Build Your Own - Tomato Sauce, Mozarella Cheese, Pepperoni, Pork Meatballs with Fanta (500ml)', 842, 0, '2016-02-26 20:51:33'),
(139, 'Dave', 'A Large Normal Crust Pepperoni Passion', 850, 0, '2016-02-26 20:52:03'),
(140, 'Phillammon', 'A Medium BBQ Stuffed Crust Meateor with Nachos, Twisted Dough Balls - Pepperoni, Chicken Strippers, Diet Coca Cola (500ml) (BBQ Sauce, not tomato)', 1611, 0, '2016-02-26 20:52:10'),
(141, 'Joe Zazzaro-Francis', 'A Small Normal Crust Meateor with Garlic Pizza Bread', 899, 0, '2016-02-26 21:32:07'),
(142, 'Jai Sharma', 'A Large Hotdog Stuffed Crust Texas BBQ (dank memes)', 1025, 0, '2016-03-11 21:13:01'),
(143, 'Matthew Eakin', 'A Large Thin and Crispy Crust Vegi Volcano', 850, 0, '2016-03-11 21:14:04'),
(144, 'metalgabu', 'No Pizza - Sides Only with Garlic Pizza Bread, Chicken Wings', 478, 1, '2016-03-11 21:16:20'),
(145, 'Damon', 'A Large Normal Crust Ranch BBQ with Coca Cola (500ml), Sprite (500ml)', 1064, 1, '2016-03-11 21:19:58'),
(146, 'Callum', 'A Large Hotdog Stuffed Crust Build Your Own - Tomato Sauce, Mozarella Cheese, Chicken Breast Strips, Pepperoni with Sprite (500ml)', 967, 0, '2016-03-11 21:20:28'),
(147, 'Ali Patton', 'A Medium Normal Crust Build Your Own - BBQ Sauce, Mozarella Cheese, Chicken Breast Strips, Jalapeno Peppers, Sweetcorn', 730, 0, '2016-03-11 21:25:38'),
(148, 'Timothy Shelton', 'A Medium Normal Crust Ranch BBQ', 835, 1, '2016-03-11 21:26:22'),
(149, 'Ryan', 'A Small Normal Crust Texas BBQ', 700, 0, '2016-03-11 22:10:49'),
(150, 'J', 'A Medium Normal Crust New Yorker (Change bacon to ham pls)', 750, 0, '2016-03-11 22:11:13'),
(151, 'Murtag', 'A Large Hotdog Stuffed Crust with Mustard Build Your Own - Tomato Sauce, Mozarella Cheese, Cumberland Sausage, Red Onions, Tandoori Chicken', 970, 0, '2016-03-11 22:21:21'),
(152, 'Jai', 'A Medium BBQ Stuffed Crust Texas BBQ (dank memes)', 925, 0, '2016-04-29 20:34:01'),
(153, 'Matthew Eakin', 'A Large Thin and Crispy Crust Vegi Volcano', 850, 0, '2016-04-29 20:36:32'),
(154, 'Zoggoth NOT PIZZA', 'A Large Normal Crust Cheese and Tomato (DONT ORDER ME A CHEESE AND TOMATO PIZZA, ORDER 21 BBQ WINGS, also DORP TALBE)', 682, 1, '2016-04-29 20:36:45'),
(155, 'Sam', 'A Large Stuffed Crust Cheese and Tomato with Diet Coca Cola (500ml)', 837, 0, '2016-04-29 20:38:18'),
(156, 'maddy', 'A Personal Normal Crust Build Your Own - BBQ Sauce, Mozarella Cheese, Green and Red Peppers, Mushrooms, Pork Meatballs, Tomato with Garlic Pizza Bread', 590, 1, '2016-04-29 20:39:42'),
(157, 'Callum', 'A Large Hotdog Stuffed Crust Build Your Own - Tomato Sauce, Mozarella Cheese, Pepperoni, Pork Meatballs with Sprite (500ml)', 967, 0, '2016-04-29 20:42:41'),
(158, 'Abbaas Rafiq', 'A Large Normal Crust Build Your Own - Tomato Sauce, Mozarella Cheese, Green and Red Peppers, Red Onions', 780, 0, '2016-04-29 20:43:04'),
(159, 'David Todd', 'A Medium Normal Crust Pepperoni Passion', 750, 0, '2016-04-29 20:43:42'),
(160, 'Bradley', 'A Personal Normal Crust Build Your Own - Tomato Sauce, Mozarella Cheese, Ground Beef, Pineapple', 280, 0, '2016-04-29 20:46:12'),
(161, 'Jessica', 'A Personal Normal Crust Cheese and Tomato with Chicken Strippers', 449, 0, '2016-04-29 20:50:36'),
(162, 'Jamie', 'A Small Italian Crust Vegi Volcano', 650, 0, '2016-04-29 21:04:27'),
(163, 'Veltas', 'A Large Normal Crust Vegi Supreme', 886, 1, '2016-04-29 21:05:40'),
(164, 'Mide Segun', 'A Large Stuffed Crust Meateor', 1064, 1, '2016-04-29 21:07:41'),
(165, 'Murtag', 'A Large Hotdog Stuffed Crust with Mustard Build Your Own - Tomato Sauce, Mozarella Cheese, Cumberland Sausage, Pork Meatballs, Red Onions with Coke Zero (500ml)', 1032, 0, '2016-04-29 21:07:46'),
(166, 'Phillammon', 'A Large Hotdog Stuffed Crust Meatilicious', 1064, 1, '2016-04-29 21:11:21'),
(167, 'Zoggoth NOT PIZZA', 'A Large Normal Crust Cheese and Tomato (DONT ORDER ME A CHEESE AND TOMATO PIZZA, ORDER 21 BBQ WINGS, also DORP TALBE)', 650, 0, '2016-05-06 20:14:40'),
(168, 'Matthew Eakin', 'A Large Italian Crust Vegi Supreme (No mushrooms.)', 850, 0, '2016-05-06 20:16:44'),
(169, 'Paolo', 'A Large Stuffed Crust Tandoori Hot with Coca Cola (500ml)', 1077, 1, '2016-05-06 20:19:19'),
(170, 'Sam', 'A Large Stuffed Crust Cheese and Tomato with Diet Coca Cola (500ml)', 837, 0, '2016-05-06 20:19:52'),
(171, 'Mide Segun', 'A Large Stuffed Crust Meateor', 1064, 1, '2016-05-06 20:24:22'),
(172, 'Max Cherrill', 'A Large Normal Crust Cheese and Tomato', 682, 1, '2016-05-06 20:25:37'),
(173, 'Sean Adamson', 'A Medium Normal Crust Build Your Own - No Sauce, Mozarella Cheese, Chicken Breast Strips, Ham, Mushrooms', 702, 1, '2016-05-06 20:26:10'),
(174, 'Jessica', 'A Large Stuffed Crust Cheese and Tomato with Chicken Strippers, FRANK''S RedHot Wings, Domino''s Cookies, Fanta (500ml)', 1536, 0, '2016-05-06 20:26:23'),
(175, 'Osu! Achievements get', 'A Large Hotdog Stuffed Crust Build Your Own - Tomato Sauce, Mozarella Cheese, Chicken Breast Strips, Pepperoni with Sprite (500ml)', 967, 0, '2016-05-06 20:30:54'),
(176, 'Ali Patton', 'A Medium Normal Crust Build Your Own - BBQ Sauce, Mozarella Cheese, Chicken Breast Strips, Cumberland Sausage, Ground Beef, Jalapeno Peppers', 790, 0, '2016-05-06 20:34:13'),
(177, 'J', 'A Medium Normal Crust New Yorker (Bacon->extra ham pls)', 750, 0, '2016-05-06 20:37:56'),
(178, 'Tom Pickford', 'A Large Stuffed Crust Ham and Pineapple', 1013, 1, '2016-05-06 20:40:23'),
(179, 'Cyberia', 'A Large Normal Crust Texas BBQ (2xbacon 2xchicken -onions -peppers)', 900, 0, '2016-05-06 20:41:35'),
(180, 'Gillian Yu', 'A Large Normal Crust Texas BBQ', 937, 1, '2016-05-06 20:53:35'),
(181, 'Gillian Yu', 'A Large Normal Crust Meatilicious', 937, 1, '2016-05-06 20:55:38'),
(182, 'Murtag', 'A Small Normal Crust Build Your Own - Tomato Sauce, Mozarella Cheese, Cumberland Sausage, Red Onions', 580, 1, '2016-05-06 21:02:17'),
(183, 'jai', 'A Large BBQ Stuffed Crust Texas BBQ (dank memes)', 1025, 0, '2016-05-06 21:11:08'),
(184, 'Zoggoth NOT PIZZA', 'A Large Normal Crust Cheese and Tomato (DONT ORDER ME A CHEESE AND TOMATO PIZZA, ORDER 21 BBQ WINGS, also DORP TALBE)', 682, 1, '2016-05-13 21:24:47'),
(185, 'Callum', 'A Large Stuffed Crust Build Your Own - Tomato Sauce, Mozarella Cheese, Pepperoni, Smoked Bacon Rashers with Fanta (500ml)', 967, 0, '2016-05-13 21:25:40'),
(186, 'Sam', 'A Large Stuffed Crust Vegi Supreme with Diet Coca Cola (500ml)', 1077, 1, '2016-05-13 21:26:25'),
(187, 'Callum', 'A Large Stuffed Crust Build Your Own - Tomato Sauce, Mozarella Cheese, Pepperoni, Smoked Bacon Rashers with Fanta (500ml)', 1005, 1, '2016-05-13 21:29:13'),
(188, 'Jessica', 'A Personal Normal Crust Cheese and Tomato with Chicken Strippers, FRANK''S RedHot Wings, Fanta (500ml)', 761, 0, '2016-05-13 21:30:55'),
(189, 'Seaber', 'A Large Normal Crust Vegi Volcano (remove tomato and add extra jalapenos)', 850, 0, '2016-05-13 21:34:24'),
(190, 'jai', 'A Large BBQ Stuffed Crust Texas BBQ with Coca Cola (500ml) (with sirarcha, big coke)', 1087, 0, '2016-05-13 21:46:18'),
(191, 'Matthew Eakin', 'A Large Thin and Crispy Crust Vegi Volcano with Garlic Pizza Bread, Sprite (500ml)', 1153, 1, '2016-05-20 20:26:41'),
(192, 'Sam', 'A Large Stuffed Crust Cheese and Tomato with Diet Coca Cola (500ml)', 837, 0, '2016-05-20 20:30:19'),
(193, 'Veltas', 'No Pizza - Sides Only with Fanta (500ml) (large fanta)', 63, 0, '2016-05-20 20:30:25'),
(194, 'A E S T H E T I C', 'No Pizza - Sides Only with Garlic Pizza Bread, Chicken Strippers, Spicy BBQ Wings, Fanta (500ml)', 761, 0, '2016-05-20 20:34:12'),
(195, 'Murtag', 'A Large Hotdog Stuffed Crust with Mustard Build Your Own - Tomato Sauce, Mozarella Cheese, Cumberland Sausage, Red Onions with Coke Zero (500ml)', 967, 0, '2016-05-20 20:46:33'),
(196, 'Bradley', 'A Personal Normal Crust Build Your Own - Tomato Sauce, Mozarella Cheese, Ground Beef, Pineapple', 280, 0, '2016-05-20 20:51:32'),
(197, 'Liam C', 'A Large Hotdog Stuffed Crust with Mustard Build Your Own - Tomato Sauce, Mozarella Cheese, Cumberland Sausage, Jalapeno Peppers with Kickers Combo, Dr Pepper (500ml)', 1317, 0, '2016-05-20 20:59:00'),
(198, 'Mide Segun', 'A Large Stuffed Crust Meateor with Spicy BBQ Wings', 1318, 1, '2016-05-20 21:00:31'),
(199, 'Zoggoth NOT PIZZA', 'A Large Normal Crust Cheese and Tomato (DONT ORDER ME A CHEESE AND TOMATO PIZZA, ORDER 21 BBQ WINGS, also DORP TALBE)', 682, 1, '2016-06-17 19:58:47'),
(200, 'Phillammon', 'A Large Hotdog Stuffed Crust Meateor with Twisted Dough Balls - Pepperoni, Diet Coca Cola (1.25l)', 1369, 1, '2016-06-17 20:02:32'),
(201, 'Abbaas Rafiq', 'A Large Normal Crust Build Your Own - BBQ Sauce, Mozarella Cheese, Red Onions, Tuna', 780, 0, '2016-06-17 20:03:57'),
(202, 'Ali Patton', 'A Medium Normal Crust Build Your Own - BBQ Sauce, Mozarella Cheese, Chicken Breast Strips, Green and Red Peppers, Jalapeno Peppers, Tandoori Chicken', 790, 0, '2016-06-17 20:06:40'),
(203, 'Ash', 'A Medium Normal Crust Tandoori Hot with Oasis Summer Fruits (500ml)', 812, 0, '2016-06-17 20:10:44'),
(204, 'meme queen', 'No Pizza - Sides Only with Twisted Dough Balls - Cheese, The Big Garlic and Herb Dip', 274, 1, '2016-06-17 20:18:53'),
(205, 'Murtag', 'No Pizza - Sides Only with Ben & Jerry''s - Cookie Dough', 250, 0, '2016-06-17 20:22:58'),
(206, 'Tom Pickford', 'A Large Stuffed Crust Build Your Own - Tomato Sauce, Mozarella Cheese, Anchovies, Green and Red Peppers, Ground Beef', 1008, 1, '2016-06-17 20:28:17'),
(207, 'jai', 'A Medium Normal Crust Texas BBQ with Ben & Jerry''s - Cookie Dough, Diet Coca Cola (1.25l) (memes)', 1149, 0, '2016-06-17 20:34:08'),
(208, 'Mide Segun', 'A Large Stuffed Crust Meateor', 1064, 1, '2016-06-24 20:55:48'),
(209, 'Domenico', 'A Large Normal Crust New Yorker', 886, 1, '2016-06-24 20:57:24'),
(210, 'Marmite', 'No Pizza - Sides Only with Garlic Pizza Bread, Strippers Combo, Coca Cola (500ml)', 643, 1, '2016-06-24 20:58:44'),
(211, 'Ali ', 'A Medium Normal Crust Build Your Own - BBQ Sauce, Mozarella Cheese, Jalapeno Peppers, Smoked Bacon Rashers, Tandoori Chicken', 730, 0, '2016-06-24 20:59:33'),
(212, 'jai', 'No Pizza - Sides Only (21 bbq wings)', 0, 0, '2016-06-24 21:03:53'),
(213, 'jai', 'A Large Hotdog Stuffed Crust Texas BBQ (dorb talbe)', 1025, 0, '2016-06-29 23:59:12'),
(214, 'Zoggoth NOT PIZZA', 'A Large Normal Crust Cheese and Tomato (DONT ORDER ME A CHEESE AND TOMATO PIZZA, ORDER 21 BBQ WINGS, also DORP TALBE)', 682, 1, '2016-06-29 23:59:17'),
(215, 'Daki', 'A Personal Normal Crust Cheese and Tomato with Chicken Kickers, Chicken Wings (+chicken)', 732, 1, '2016-06-29 23:59:34'),
(216, ' ', 'A Large Normal Crust Ranch BBQ/Cheese and Tomato', 937, 1, '2016-06-30 00:02:25'),
(217, 'sorry forgot sides my pizza name is " "', 'No Pizza - Sides Only with Chick ''n'' Mix Box, Sprite (500ml)', 491, 1, '2016-06-30 00:04:16'),
(218, 'jai', 'A Large Stuffed Crust Texas BBQ with Ben & Jerry''s - Cookie Dough (dorp talbe)', 1274, 0, '2016-06-30 00:07:13'),
(219, 'Zoggoth NOT PIZZA', 'A Large Normal Crust Cheese and Tomato (GET ME 21 BBQ CHICKEN THINGS, NOT A BLINKING PIZZA, I ONLY CHOSE IT COS'' IT''S THE SAME PRICE)', 682, 1, '2016-10-07 20:50:55'),
(220, 'Callum', 'A Large Hotdog Stuffed Crust Cheese and Tomato with Fanta (1.25l)', 874, 0, '2016-10-07 20:51:58'),
(221, 'Veltas', 'A Large Stuffed Crust Vegi Volcano', 975, 0, '2016-10-07 20:52:47'),
(222, 'Max Cherrill', 'A Medium Normal Crust Cheese and Tomato', 580, 1, '2016-10-07 20:53:23'),
(223, 'Matthew F', 'A Medium Normal Crust Cheese and Tomato with Coca Cola (500ml)', 612, 0, '2016-10-07 20:53:41'),
(224, 'Ali Patton', 'A Medium Normal Crust Build Your Own - Tomato Sauce, Mozarella Cheese, Chicken Breast Strips, Green and Red Peppers, Jalapeno Peppers, Tuna', 790, 0, '2016-10-07 20:54:16'),
(225, 'Jessica', 'No Pizza - Sides Only with Garlic Pizza Bread, Chicken Kickers, Spicy BBQ Wings', 732, 1, '2016-10-07 20:54:27'),
(226, 'Mide Segun', 'A Large Stuffed Crust Ranch BBQ', 1025, 0, '2016-10-07 20:56:38'),
(227, 'Murtag', 'A Large Hotdog Stuffed Crust with Mustard Build Your Own - Tomato Sauce, Mozarella Cheese, Cumberland Sausage, Red Onions with Coke Zero (1.25l)', 1004, 0, '2016-10-07 20:56:51'),
(228, 'Sam', 'A Medium Stuffed Crust Cheese and Tomato with Diet Coca Cola (1.25l)', 774, 0, '2016-10-07 20:57:00'),
(229, 'Elliott ', 'A Large Italian Crust Mighty Meaty', 900, 0, '2016-10-07 21:06:51'),
(230, 'Calvin Wang', 'A Large Stuffed Crust Meateor', 1025, 0, '2016-10-07 21:09:06'),
(231, 'Sam Bolton', 'A Large Normal Crust Mighty Meaty', 900, 0, '2016-10-07 21:10:26'),
(232, 'Matt Clancy', 'A Large Normal Crust Cheese and Tomato', 682, 1, '2016-10-07 21:10:47'),
(233, '(X) Shaun', 'A Medium Normal Crust Build Your Own - No Sauce, Mozarella Cheese, Chicken Breast Strips, Ham, Mushrooms', 670, 0, '2016-10-07 21:11:43'),
(234, 'Ryan', 'A Medium Normal Crust Pepperoni Passion', 750, 0, '2016-10-07 21:12:15'),
(235, 'Bradley', 'A Personal Normal Crust Build Your Own - Tomato Sauce, Mozarella Cheese, Ground Beef, Pineapple', 280, 0, '2016-10-07 21:12:42'),
(236, 'Edd', 'A Large Hotdog Stuffed Crust with Mustard Meatilicious with The Big Garlic and Herb Dip', 1115, 1, '2016-10-07 21:13:15'),
(237, 'James', 'A Large Stuffed Crust Build Your Own - BBQ Sauce, Mozarella Cheese, Chicken Breast Strips, Ham, Pepperoni, Pork Meatballs, Smoked Bacon Rashers', 1100, 0, '2016-10-07 21:14:35');

-- --------------------------------------------------------

--
-- Table structure for table `hir2_orders`
--

CREATE TABLE IF NOT EXISTS `hir2_orders` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) CHARACTER SET utf8 NOT NULL,
  `order` varchar(500) CHARACTER SET utf8 NOT NULL,
  `price` int(11) NOT NULL,
  `paid` tinyint(1) NOT NULL,
  `entered` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=43 ;

--
-- Dumping data for table `hir2_orders`
--

INSERT INTO `hir2_orders` (`id`, `name`, `order`, `price`, `paid`, `entered`) VALUES
(21, 'Zoggoth NOT PIZZA', 'A Large Normal Crust Cheese and Tomato (GET ME 21 BBQ CHICKEN THINGS, NOT A BLINKING PIZZA, I ONLY CHOSE IT COS'' IT''S THE SAME PRICE)', 682, 1, 0),
(22, 'Callum', 'A Large Hotdog Stuffed Crust Cheese and Tomato with Fanta (1.25l)', 874, 1, 0),
(23, 'Veltas', 'A Large Stuffed Crust Vegi Volcano', 975, 1, 0),
(24, 'Max Cherrill', 'A Medium Normal Crust Cheese and Tomato', 580, 1, 0),
(25, 'Matthew F', 'A Medium Normal Crust Cheese and Tomato with Coca Cola (500ml)', 612, 1, 0),
(26, 'Ali Patton', 'A Medium Normal Crust Build Your Own - Tomato Sauce, Mozarella Cheese, Chicken Breast Strips, Green and Red Peppers, Jalapeno Peppers, Tuna', 790, 1, 0),
(27, 'Jessica', 'No Pizza - Sides Only with Garlic Pizza Bread, Chicken Kickers, Spicy BBQ Wings', 732, 1, 0),
(28, 'Mide Segun', 'A Large Stuffed Crust Ranch BBQ', 1025, 0, 0),
(29, 'Murtag', 'A Large Hotdog Stuffed Crust with Mustard Build Your Own - Tomato Sauce, Mozarella Cheese, Cumberland Sausage, Red Onions with Coke Zero (1.25l)', 1004, 1, 0),
(30, 'Sam', 'A Medium Stuffed Crust Cheese and Tomato with Diet Coca Cola (1.25l)', 774, 1, 0),
(31, 'Elliott ', 'A Large Italian Crust Mighty Meaty', 900, 1, 0),
(32, 'Calvin Wang', 'A Large Stuffed Crust Meateor', 1025, 1, 0),
(33, 'Sam Bolton', 'A Large Normal Crust Mighty Meaty', 900, 1, 0),
(34, 'Matt Clancy', 'A Large Normal Crust Cheese and Tomato', 682, 1, 0),
(35, '(X) Shaun', 'A Medium Normal Crust Build Your Own - No Sauce, Mozarella Cheese, Chicken Breast Strips, Ham, Mushrooms', 670, 1, 0),
(36, 'Ryan', 'A Medium Normal Crust Pepperoni Passion', 750, 1, 0),
(37, 'Bradley', 'A Personal Normal Crust Build Your Own - Tomato Sauce, Mozarella Cheese, Ground Beef, Pineapple', 280, 1, 0),
(38, 'Edd', 'A Large Hotdog Stuffed Crust with Mustard Meatilicious with The Big Garlic and Herb Dip', 1115, 1, 0),
(39, 'James', 'A Large Stuffed Crust Build Your Own - BBQ Sauce, Mozarella Cheese, Chicken Breast Strips, Ham, Pepperoni, Pork Meatballs, Smoked Bacon Rashers', 1100, 1, 0),
(40, 'mcnutty', 'A Small Italian Crust Texas BBQ with Chick ''n'' Mix Box (leifjselfjsldfjdslfk)', 1140, 1, 0),
(42, 'sdfsdfszzzzz', 'A Large Hotdog Stuffed Crust Mighty Meaty/Vegi Supreme with Chocolate Melt, Chocolate Brownies (q)', 1424, 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `hir2_pizza`
--

CREATE TABLE IF NOT EXISTS `hir2_pizza` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `pizza` varchar(50) CHARACTER SET latin1 NOT NULL,
  `personal` int(11) NOT NULL,
  `small` int(11) NOT NULL,
  `medium` int(11) NOT NULL,
  `large` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=25 ;

--
-- Dumping data for table `hir2_pizza`
--

INSERT INTO `hir2_pizza` (`id`, `pizza`, `personal`, `small`, `medium`, `large`) VALUES
(1, 'Cheese and Tomato', 649, 1099, 1299, 1499),
(2, 'Mighty Meaty', 799, 1499, 1699, 1899),
(5, 'Pepperoni Passion', 699, 1399, 1599, 1799),
(6, 'Texas BBQ', 799, 1499, 1699, 1899),
(7, 'Vegi Supreme', 699, 1399, 1599, 1799),
(8, 'Chicken Feast', 799, 1499, 1699, 1899),
(9, 'Ham and Pineapple', 699, 1399, 1599, 1799),
(10, 'Hot and Spicy', 699, 1399, 1599, 1799),
(11, 'Meateor', 799, 1499, 1699, 1899),
(12, 'Meatilicious', 799, 1499, 1699, 1899),
(13, 'New Yorker', 699, 1399, 1599, 1799),
(14, 'Ranch BBQ', 799, 1499, 1699, 1899),
(15, 'Tandoori Hot', 799, 1499, 1699, 1899),
(16, 'Tuna Delight', 699, 1399, 1599, 1699),
(17, 'Vegi Volcano', 699, 1399, 1599, 1699),
(18, 'American Hot', 799, 1499, 1699, 1899),
(19, 'Hawaiian', 799, 1499, 1699, 1899),
(20, 'Italiano Milano', 0, 0, 1699, 1899),
(21, 'Italiano Ardente', 0, 0, 1699, 1899),
(22, 'Italiano Sicilia', 0, 0, 1699, 1899),
(23, 'Italiano Verona', 0, 0, 1699, 1899),
(24, 'Italiano Roma', 0, 0, 1699, 1899),
(100, 'No Pizza - Sides Only', 0, 0, 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `hir2_sessions`
--

CREATE TABLE IF NOT EXISTS `hir2_sessions` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `guid` varchar(13) CHARACTER SET utf8 NOT NULL,
  `name` varchar(50) CHARACTER SET utf8 NOT NULL,
  `order` varchar(500) CHARACTER SET utf8 NOT NULL,
  `price` int(11) NOT NULL,
  `price_stripe` int(11) DEFAULT NULL,
  `method` varchar(10) CHARACTER SET utf32 DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=30 ;

--
-- Dumping data for table `hir2_sessions`
--

INSERT INTO `hir2_sessions` (`id`, `guid`, `name`, `order`, `price`, `price_stripe`, `method`) VALUES
(25, '57f91ca707cb0', 'a', 'A Small Normal Crust Verona', 0, 20, NULL),
(26, '57f920405855f', 'asx', 'A Small Normal Crust Italiano Verona', 0, 20, NULL),
(27, '57f9228d5a000', 'sdasd', 'A Small Normal Crust Italiano Sicilia', 0, 20, NULL),
(28, '57f92351c87c5', 'asdasd', 'A Small Normal Crust Italiano Ardente', 0, 20, NULL),
(29, '57f924e036e55', 'lk', 'A Medium Normal Crust Italiano Roma', 1699, 1751, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `hir2_sides`
--

CREATE TABLE IF NOT EXISTS `hir2_sides` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) CHARACTER SET utf8 NOT NULL,
  `price` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=119 ;

--
-- Dumping data for table `hir2_sides`
--

INSERT INTO `hir2_sides` (`id`, `name`, `price`) VALUES
(1, 'Garlic Pizza Bread', 399),
(2, 'Potato Wedges', 399),
(3, 'Twisted Dough Balls - Pepperoni', 399),
(4, 'Twisted Dough Balls - Cheese', 399),
(5, 'Italian Garlic Bread', 399),
(6, 'Chick ''n'' Mix Box', 899),
(7, 'Chicken Strippers', 599),
(8, 'Strippers Combo', 799),
(9, 'Chicken Kickers', 599),
(10, 'Kickers Combo', 799),
(11, 'Tomato & Mozzarella Salad', 499),
(12, 'Chicken Wings (7)', 599),
(13, 'Spicy BBQ Wings', 599),
(14, 'FRANK''S RedHot Wings', 599),
(15, 'Coleslaw', 299),
(16, 'Dips', 49),
(17, 'The Big Garlic and Herb Dip', 100),
(18, 'BBQ Big Dip', 100),
(19, 'Chicken Wings (21)', 1299),
(20, 'FRANKS RedHot Big Dip', 100),
(117, 'Tiramisu', 399),
(118, 'Sicilian Lemon Cheesecake', 399),
(119, 'Chocolate Melt', 399),
(120, 'Chocolate Brownies', 399),
(121, 'Domino''s Cookies', 399),
(122, 'Ben & Jerry''s - Caramel Chew Chew', 549),
(123, 'Ben & Jerry''s - Chocolate Fudge Brownie', 549),
(124, 'Ben & Jerry''s - Cookie Dough', 549),
(125, 'Ben & Jerry''s - One Love', 499),
(126, 'Ben & Jerry''s - Peanut Butter Cup', 549),
(127, 'Ben & Jerry''s - Phish Food', 549),
(228, 'Monster Energy (500ml)', 149),
(229, 'Dr Pepper (500ml)', 149),
(230, 'Coca Cola (500ml)', 149),
(231, 'Coca Cola (1.25l)', 249),
(232, 'Diet Coca Cola (500ml)', 149),
(233, 'Diet Coca Cola (1.25l)', 249),
(235, 'Coke Zero (500ml)', 149),
(236, 'Coke Zero (1.25l)', 249),
(237, 'Fanta (500ml)', 149),
(238, 'Fanta (1.25l)', 249),
(239, 'Sprite (500ml)', 149),
(240, 'Oasis Summer Fruits (500ml)', 149),
(241, 'Oasis Citrus Punch (500ml)', 149);

-- --------------------------------------------------------

--
-- Table structure for table `hir2_toppings`
--

CREATE TABLE IF NOT EXISTS `hir2_toppings` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) CHARACTER SET utf8 NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=21 ;

--
-- Dumping data for table `hir2_toppings`
--

INSERT INTO `hir2_toppings` (`id`, `name`) VALUES
(1, 'Anchovies'),
(2, 'Chicken Breast Strips'),
(3, 'Cumberland Sausage'),
(4, 'Domino''s Herbs'),
(5, 'Garlic Butter'),
(6, 'Green and Red Peppers'),
(7, 'Ground Beef'),
(8, 'Ham'),
(9, 'Jalapeno Peppers'),
(10, 'Mushrooms'),
(11, 'Pepperoni'),
(12, 'Pineapple'),
(13, 'Pork Meatballs'),
(14, 'Red Onions'),
(15, 'Smoked Bacon Rashers'),
(16, 'Sweetcorn'),
(17, 'Tandoori Chicken'),
(18, 'Tomato'),
(19, 'Tuna'),
(20, 'Sriracha Sauce');

--
-- Constraints for dumped tables
--

--
-- Constraints for table `hir2_ingredients`
--
ALTER TABLE `hir2_ingredients`
  ADD CONSTRAINT `hir2_ingredients_ibfk_1` FOREIGN KEY (`pizza`) REFERENCES `hir2_pizza` (`id`),
  ADD CONSTRAINT `hir2_ingredients_ibfk_2` FOREIGN KEY (`topping`) REFERENCES `hir2_toppings` (`id`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
