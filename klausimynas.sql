-- phpMyAdmin SQL Dump
-- version 4.7.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Jun 01, 2018 at 04:56 PM
-- Server version: 5.7.19
-- PHP Version: 7.1.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `klausimynas`
--

-- --------------------------------------------------------

--
-- Table structure for table `answers`
--

DROP TABLE IF EXISTS `answers`;
CREATE TABLE IF NOT EXISTS `answers` (
  `id` int(3) NOT NULL AUTO_INCREMENT,
  `question_id` int(3) NOT NULL,
  `answer` varchar(255) NOT NULL,
  `points` int(3) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `question_id` (`question_id`)
) ENGINE=InnoDB AUTO_INCREMENT=61 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `answers`
--

INSERT INTO `answers` (`id`, `question_id`, `answer`, `points`) VALUES
(1, 1, 'Programavimo kalba', 5),
(2, 2, 'Kurti Web svetaines', 2),
(3, 3, 'Bendros paskirties programavimo kalba', 3),
(4, 4, 'Įterpimas kito failo kodą', 4),
(5, 1, 'Maisto pavadinimas', 0),
(6, 9, 'Masyvas', 6),
(7, 10, 'Suskaičiuoti elementus', 7),
(8, 11, 'Duomenų rinkinys', 8),
(9, 12, 'Patikrinti svetainę', 9),
(10, 13, 'Būdas perduoti duomenis per url', 10),
(11, 14, 'Model,View,Controller', 11),
(12, 15, 'Būdas gauti failus iš serverio\r\n', 12),
(13, 16, 'Būdas įterpti kenkėjišką kodo dalį į siunčiamą užklausą', 13),
(14, 1, 'Gyvūnas', 5),
(15, 2, 'Versti kalbas', 2),
(16, 2, 'Kurti dainas', 2),
(17, 9, 'Kintamasis', 6),
(18, 9, 'Mašinos modelis', 6),
(19, 10, 'Skaičiuoti nuo 1 iki 10', 7),
(20, 10, 'Nustatyti interneto greitį', 5),
(21, 11, 'Karinė bazė', 8),
(22, 11, 'Duomenų talpykla', 3),
(23, 12, 'Patikrinti įvestus duomenis', 9),
(24, 12, 'Įvertinti rašymo greitį', 5),
(25, 14, 'Mirror,Vision,Cascade', 11),
(26, 14, 'Mini,Vax,Cinor', 87),
(27, 13, 'Būdas siūsti failus į serverį', 6),
(28, 13, 'Būdas gauti failus iš serverio', 55),
(29, 15, 'Būdas perduoti duomenis per url\r\n', 44),
(30, 15, 'Būdas siūsti failus į serverį', 125),
(31, 16, 'Būdas pridėti funkcijų', 19),
(32, 16, 'Būdas sukurti naują puslapį', 81),
(33, 3, 'Maisto papildas', 3),
(34, 3, 'Kalba skirta kurčnebiliams', 3),
(35, 4, 'Kodo trinimas', 4),
(36, 4, 'Kodo tikrinimas', 4),
(37, 17, 'Simbolių rinkinys skirtas organizuoti objektus', 88),
(38, 17, 'Maisto pavadinimas', 10),
(39, 17, 'Kintamasis', 22),
(40, 18, 'Dvigubas skaičius', 35),
(41, 18, 'Dviguba funkcija', 10),
(42, 18, 'Realieji skaičiai', 75),
(43, 19, '1 arba 0', 91),
(44, 19, '3 arba 5', 22),
(45, 19, '10 arba 0', 44),
(46, 20, 'Skaičius', 85),
(47, 20, 'Žodis', 21),
(48, 20, 'Masyvas', 5),
(49, 21, 'Kintamasis', 54),
(50, 21, 'Datos tipas', 22),
(51, 21, 'Nustatymas, skirtas apdorojant duomenis', 1),
(52, 22, '1986 m.', 2),
(53, 22, '2001 m.', 3),
(54, 22, '1998 m.', 4),
(55, 23, 'Su signed arba unsigned', 5),
(56, 23, 'Su positive arba negative', 6),
(57, 23, 'Su true arba false', 7),
(58, 24, 'Kintamojo tipas, turintis galimybe kaupti skaičius, žodžius, simbolius', 8),
(59, 24, 'Skaičiaus tipas, neviršijantis 99', 9),
(60, 24, 'Betkoks žodis iki 16 simbolių', 10);

-- --------------------------------------------------------

--
-- Table structure for table `questions`
--

DROP TABLE IF EXISTS `questions`;
CREATE TABLE IF NOT EXISTS `questions` (
  `id` int(3) NOT NULL AUTO_INCREMENT,
  `test_id` int(3) NOT NULL,
  `question_name` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=25 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `questions`
--

INSERT INTO `questions` (`id`, `test_id`, `question_name`) VALUES
(1, 1, 'Kas yra PHP?'),
(2, 1, 'Kam naudojami PHP scriptai?'),
(3, 2, 'Kas yra C++ ? '),
(4, 2, 'Kas yra include?'),
(9, 1, 'Kas yra \"Array\"?'),
(10, 1, 'Kam naudojamas \"Count\"?'),
(11, 1, 'Kas yra Duomenų bazė?'),
(12, 1, 'Kam reikalingos validacijos?'),
(13, 1, 'Kas yra GET?'),
(14, 1, 'Kas yra MVC?'),
(15, 1, 'Kas yra POST?'),
(16, 1, 'Kas yra injekcijos?'),
(17, 2, 'Kas yra namespace?'),
(18, 2, 'Kas yra double?'),
(19, 2, 'Kas yra bool?'),
(20, 2, 'Kas yra integer?'),
(21, 2, 'Kas yra unitbuf?'),
(22, 2, 'Kada patvirtintas C++ kalbos standartas?'),
(23, 2, 'Kaip nūrodyti kintamojo teigiamą/neigiamą reikšmę?'),
(24, 2, 'Kas yra Varchar?');

-- --------------------------------------------------------

--
-- Table structure for table `results`
--

DROP TABLE IF EXISTS `results`;
CREATE TABLE IF NOT EXISTS `results` (
  `id` int(3) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `points` int(3) NOT NULL,
  `created_at` date NOT NULL,
  `updated_at` date NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=15 DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `tests`
--

DROP TABLE IF EXISTS `tests`;
CREATE TABLE IF NOT EXISTS `tests` (
  `id` int(3) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tests`
--

INSERT INTO `tests` (`id`, `name`) VALUES
(1, 'PHP'),
(2, 'C++');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
