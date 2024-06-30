-- phpMyAdmin SQL Dump
-- version 4.9.2
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le :  ven. 10 jan. 2020 à 15:46
-- Version du serveur :  8.0.18
-- Version de PHP :  7.4.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données :  `phptodolist`
--

-- --------------------------------------------------------

--
-- Structure de la table `todo`
--

DROP TABLE IF EXISTS `todo`;
CREATE TABLE IF NOT EXISTS `todo` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `description` varchar(300) NOT NULL,
  `isDone` tinyint(1) NOT NULL,
  `idList` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `FKEY_TODO_IDLIST` (`idList`)
) ENGINE=InnoDB AUTO_INCREMENT=527 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `todo`
--

INSERT INTO `todo` (`id`, `description`, `isDone`, `idList`) VALUES
(417, 'Finir/tester connexion', 1, 189),
(516, 'Faire la présentation du projet', 0, 307),
(520, 'Faire la présentation du projet', 0, 310),
(521, 'Terminer le projet', 1, 311),
(523, 'Faire le drag and drop', 1, 189),
(524, 'Réviser les patrons de conception', 1, 311),
(525, 'Zipper le projet de todolist', 0, 189),
(526, 'rien', 1, 311);

--
-- Déclencheurs `todo`
--
DROP TRIGGER IF EXISTS `TRG_DELETE_TODO`;
DELIMITER $$
CREATE TRIGGER `TRG_DELETE_TODO` BEFORE DELETE ON `todo` FOR EACH ROW INSERT INTO todo_log VALUES(null, NOW(), 'DELETE', OLD.id, OLD.description, OLD.isDone, OLD.idList)
$$
DELIMITER ;
DROP TRIGGER IF EXISTS `TRG_INSERT_TODO`;
DELIMITER $$
CREATE TRIGGER `TRG_INSERT_TODO` AFTER INSERT ON `todo` FOR EACH ROW INSERT INTO todo_log VALUES(null, NOW(), 'INSERT', NEW.id, NEW.description, NEW.isDone, NEW.idList)
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Structure de la table `todolist`
--

DROP TABLE IF EXISTS `todolist`;
CREATE TABLE IF NOT EXISTS `todolist` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(300) NOT NULL,
  `isPublic` tinyint(1) NOT NULL,
  `idUser` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `FKEY_TODOLIST_IDUSER` (`idUser`)
) ENGINE=InnoDB AUTO_INCREMENT=315 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `todolist`
--

INSERT INTO `todolist` (`id`, `title`, `isPublic`, `idUser`) VALUES
(189, 'Projet PHP 1', 1, 0),
(307, 'liste Lilian 1', 0, 35),
(309, 'Admin list 1', 0, 37),
(310, 'Tâches IUT', 1, 0),
(311, 'Liste Hector', 1, 0),
(312, 'Liste Lilian', 1, 0),
(313, 'Autres', 1, 0),
(314, 'totototo', 0, 35);

--
-- Déclencheurs `todolist`
--
DROP TRIGGER IF EXISTS `TRG_DELETE_TODOLIST`;
DELIMITER $$
CREATE TRIGGER `TRG_DELETE_TODOLIST` BEFORE DELETE ON `todolist` FOR EACH ROW INSERT INTO todolist_log VALUES(null, NOW(), "DELETE", OLD.id, OLD.title, OLD.isPublic, OLD.idUser)
$$
DELIMITER ;
DROP TRIGGER IF EXISTS `TRG_INSERT_TODOLIST`;
DELIMITER $$
CREATE TRIGGER `TRG_INSERT_TODOLIST` AFTER INSERT ON `todolist` FOR EACH ROW INSERT INTO todolist_log VALUES(null, NOW(), "INSERT", NEW.id, NEW.title, NEW.isPublic, NEW.idUser)
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Structure de la table `todolist_log`
--

DROP TABLE IF EXISTS `todolist_log`;
CREATE TABLE IF NOT EXISTS `todolist_log` (
  `idLog` int(11) NOT NULL AUTO_INCREMENT,
  `date` date NOT NULL,
  `action` varchar(50) NOT NULL,
  `idList` int(11) NOT NULL,
  `title` varchar(300) NOT NULL,
  `isPublic` tinyint(1) NOT NULL,
  `idUser` int(11) NOT NULL,
  PRIMARY KEY (`idLog`)
) ENGINE=MyISAM AUTO_INCREMENT=104 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `todolist_log`
--

INSERT INTO `todolist_log` (`idLog`, `date`, `action`, `idList`, `title`, `isPublic`, `idUser`) VALUES
(1, '2019-12-30', 'DELETE', 254, 'qsqsdqsd', 1, 0),
(2, '2019-12-31', 'INSERT', 257, 'saluuuuuuuuuuuuuuuuuuuuuuuuuuuuuuuuuuuuuuuuuuuuuuuuut', 1, 0),
(3, '2019-12-31', 'DELETE', 257, 'saluuuuuuuuuuuuuuuuuuuuuuuuuuuuuuuuuuuuuuuuuuuuuuuuut', 1, 0),
(4, '2019-12-31', 'INSERT', 258, 'salutsalut', 1, 0),
(5, '2019-12-31', 'DELETE', 258, 'salutsalut', 1, 0),
(6, '2019-12-31', 'INSERT', 259, 'hello', 1, 0),
(7, '2019-12-31', 'DELETE', 259, 'hello', 1, 0),
(8, '2019-12-31', 'INSERT', 260, 'sqdqsdqd', 0, 28),
(9, '2019-12-31', 'DELETE', 260, 'sqdqsdqd', 0, 28),
(10, '2020-01-06', 'INSERT', 261, 'salut', 1, 0),
(11, '2020-01-06', 'DELETE', 261, 'salut', 1, 0),
(12, '2020-01-06', 'INSERT', 262, 'lilian liste 1', 0, 30),
(13, '2020-01-06', 'INSERT', 263, 'admin list', 0, 29),
(14, '2020-01-06', 'DELETE', 262, 'lilian liste 1', 0, 30),
(15, '2020-01-06', 'DELETE', 263, 'admin list', 0, 29),
(16, '2020-01-06', 'INSERT', 264, 'sasasasa', 0, 29),
(17, '2020-01-06', 'DELETE', 264, 'sasasasa', 0, 29),
(18, '2020-01-06', 'INSERT', 265, 'd', 0, 29),
(19, '2020-01-06', 'INSERT', 266, 'j', 0, 29),
(20, '2020-01-06', 'INSERT', 267, 'j', 0, 29),
(21, '2020-01-06', 'INSERT', 268, 'j', 0, 29),
(22, '2020-01-06', 'INSERT', 269, 'j', 0, 29),
(23, '2020-01-06', 'INSERT', 270, 'j', 0, 29),
(24, '2020-01-06', 'DELETE', 269, 'j', 0, 29),
(25, '2020-01-06', 'DELETE', 270, 'j', 0, 29),
(26, '2020-01-06', 'DELETE', 266, 'j', 0, 29),
(27, '2020-01-06', 'INSERT', 271, 'dsf', 0, 29),
(28, '2020-01-06', 'INSERT', 272, 'sdffgqdfdqg', 0, 29),
(29, '2020-01-06', 'DELETE', 267, 'j', 0, 29),
(30, '2020-01-06', 'DELETE', 272, 'sdffgqdfdqg', 0, 29),
(31, '2020-01-06', 'DELETE', 271, 'dsf', 0, 29),
(32, '2020-01-06', 'DELETE', 268, 'j', 0, 29),
(33, '2020-01-06', 'DELETE', 265, 'd', 0, 29),
(34, '2020-01-06', 'INSERT', 273, 'salut admin', 0, 29),
(35, '2020-01-06', 'INSERT', 274, 'public admin', 1, 0),
(36, '2020-01-06', 'DELETE', 274, 'public admin', 1, 0),
(37, '2020-01-06', 'INSERT', 275, 'salut', 1, 0),
(38, '2020-01-06', 'DELETE', 275, 'salut', 1, 0),
(39, '2020-01-06', 'INSERT', 276, 'qdsqd', 1, 0),
(40, '2020-01-06', 'DELETE', 276, 'qdsqd', 1, 0),
(41, '2020-01-06', 'DELETE', 273, 'salut admin', 0, 29),
(42, '2020-01-06', 'INSERT', 277, 'myprivate', 0, 29),
(43, '2020-01-06', 'DELETE', 277, 'myprivate', 0, 29),
(44, '2020-01-06', 'INSERT', 278, 'ddvsgdb', 0, 29),
(45, '2020-01-06', 'INSERT', 279, 'qsdqsd', 1, 0),
(46, '2020-01-07', 'INSERT', 280, 'testusernull', 0, 0),
(47, '2020-01-07', 'INSERT', 281, 'TEST TURN PUBLIC', 0, 31),
(48, '2020-01-07', 'DELETE', 279, 'qsdqsd', 1, 0),
(49, '2020-01-07', 'INSERT', 282, 'tets priv', 0, 31),
(50, '2020-01-07', 'DELETE', 282, 'tets priv', 1, 31),
(51, '2020-01-07', 'INSERT', 283, 'salut', 1, 0),
(52, '2020-01-07', 'DELETE', 283, 'salut', 1, 0),
(53, '2020-01-07', 'INSERT', 284, 'dddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddd', 0, 31),
(54, '2020-01-07', 'DELETE', 284, 'dddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddd', 0, 31),
(55, '2020-01-07', 'DELETE', 281, 'TEST TURN PUBLIC', 1, 31),
(56, '2020-01-07', 'INSERT', 285, 'Projet PHP 3', 1, 0),
(57, '2020-01-07', 'INSERT', 286, 'Projet 4', 1, 0),
(58, '2020-01-08', 'DELETE', 286, 'Projet 4', 1, 0),
(59, '2020-01-08', 'INSERT', 287, 'test', 1, 0),
(60, '2020-01-08', 'INSERT', 288, 'qsddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddd', 1, 0),
(61, '2020-01-08', 'INSERT', 289, 'dddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddd', 1, 0),
(62, '2020-01-08', 'DELETE', 285, 'test', 1, 0),
(63, '2020-01-08', 'INSERT', 290, 'private admin list', 0, 31),
(64, '2020-01-09', 'INSERT', 291, 'salutttttt', 1, 0),
(65, '2020-01-09', 'DELETE', 291, 'salutttttt', 1, 0),
(66, '2020-01-09', 'INSERT', 292, 'salut', 1, 0),
(67, '2020-01-09', 'DELETE', 280, 'testusernull', 0, 0),
(68, '2020-01-09', 'DELETE', 287, 'test', 0, 0),
(69, '2020-01-09', 'DELETE', 288, 'qsddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddd', 0, 0),
(70, '2020-01-09', 'DELETE', 289, 'dddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddd', 0, 0),
(71, '2020-01-09', 'DELETE', 290, 'private admin list', 0, 31),
(72, '2020-01-09', 'DELETE', 292, 'salut', 1, 0),
(73, '2020-01-09', 'INSERT', 293, 'list test', 1, 0),
(74, '2020-01-09', 'INSERT', 294, 'priv admin 1', 0, 31),
(75, '2020-01-09', 'INSERT', 295, 'qsdsqdsqd', 0, 31),
(76, '2020-01-09', 'INSERT', 296, 'qsdsqd', 0, 31),
(77, '2020-01-09', 'INSERT', 297, 'qsdsqd', 0, 31),
(78, '2020-01-09', 'INSERT', 298, 'qsdsqd', 0, 31),
(79, '2020-01-09', 'INSERT', 299, 'test', 1, 0),
(80, '2020-01-09', 'DELETE', 299, 'test', 1, 0),
(81, '2020-01-09', 'INSERT', 300, 'ssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssss', 1, 0),
(82, '2020-01-09', 'DELETE', 300, 'ssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssss', 1, 0),
(83, '2020-01-09', 'INSERT', 301, 'd', 1, 0),
(84, '2020-01-09', 'DELETE', 301, 'd', 1, 0),
(85, '2020-01-09', 'INSERT', 302, 'sdqds', 1, 0),
(86, '2020-01-10', 'INSERT', 303, 'dqsdqsds', 1, 0),
(87, '2020-01-10', 'INSERT', 304, 'qdqsdqsd', 1, 0),
(88, '2020-01-10', 'INSERT', 305, 'qsdqsd', 0, 32),
(89, '2020-01-10', 'DELETE', 302, 'sdqds', 1, 0),
(90, '2020-01-10', 'DELETE', 303, 'dqsdqsds', 1, 0),
(91, '2020-01-10', 'DELETE', 304, 'qdqsdqsd', 1, 0),
(92, '2020-01-10', 'DELETE', 293, 'Projet PHP 3', 1, 0),
(93, '2020-01-10', 'INSERT', 306, 'salut', 1, 0),
(94, '2020-01-10', 'DELETE', 306, 'salut', 1, 0),
(95, '2020-01-10', 'INSERT', 307, 'liste Lilian 1', 0, 35),
(96, '2020-01-10', 'INSERT', 308, 'qsdqsd', 1, 0),
(97, '2020-01-10', 'DELETE', 308, 'qsdqsd', 1, 0),
(98, '2020-01-10', 'INSERT', 309, 'Admin list 1', 0, 37),
(99, '2020-01-10', 'INSERT', 310, 'Tâches IUT', 1, 0),
(100, '2020-01-10', 'INSERT', 311, 'Liste Hector', 1, 0),
(101, '2020-01-10', 'INSERT', 312, 'Liste Lilian', 1, 0),
(102, '2020-01-10', 'INSERT', 313, 'Autres', 1, 0),
(103, '2020-01-10', 'INSERT', 314, 'totototo', 0, 35);

-- --------------------------------------------------------

--
-- Structure de la table `todo_log`
--

DROP TABLE IF EXISTS `todo_log`;
CREATE TABLE IF NOT EXISTS `todo_log` (
  `idLog` int(11) NOT NULL AUTO_INCREMENT,
  `date` date NOT NULL,
  `action` varchar(50) NOT NULL,
  `idTodo` int(11) NOT NULL,
  `description` varchar(300) NOT NULL,
  `isDone` tinyint(1) NOT NULL,
  `idList` int(11) NOT NULL,
  PRIMARY KEY (`idLog`)
) ENGINE=MyISAM AUTO_INCREMENT=124 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `todo_log`
--

INSERT INTO `todo_log` (`idLog`, `date`, `action`, `idTodo`, `description`, `isDone`, `idList`) VALUES
(1, '2019-12-31', 'INSERT', 452, 'tototototootottodo', 0, 258),
(2, '2019-12-31', 'DELETE', 452, 'tototototootottodo', 0, 258),
(3, '2019-12-31', 'INSERT', 453, 'sdfsdf', 0, 259),
(4, '2019-12-31', 'DELETE', 453, 'sdfsdf', 0, 259),
(5, '2019-12-31', 'INSERT', 454, 'qdqsd', 0, 260),
(6, '2019-12-31', 'DELETE', 454, 'qdqsd', 1, 260),
(7, '2020-01-06', 'INSERT', 455, 'qsd', 0, 261),
(8, '2020-01-06', 'DELETE', 455, 'qsd', 0, 261),
(9, '2020-01-06', 'INSERT', 456, 'sdqsd', 0, 263),
(10, '2020-01-06', 'DELETE', 456, 'sdqsd', 0, 263),
(11, '2020-01-06', 'INSERT', 457, 'admin', 0, 263),
(12, '2020-01-06', 'DELETE', 457, 'admin', 1, 263),
(13, '2020-01-06', 'INSERT', 458, '', 0, 264),
(14, '2020-01-06', 'INSERT', 459, '', 0, 264),
(15, '2020-01-06', 'DELETE', 459, '', 1, 264),
(16, '2020-01-06', 'DELETE', 458, '', 0, 264),
(17, '2020-01-06', 'INSERT', 460, 'dqf', 0, 275),
(18, '2020-01-06', 'DELETE', 460, 'dqf', 0, 275),
(19, '2020-01-06', 'INSERT', 461, 'qsdq', 0, 273),
(20, '2020-01-06', 'DELETE', 461, 'qsdq', 1, 273),
(21, '2020-01-06', 'INSERT', 462, 'qsdqs', 0, 277),
(22, '2020-01-06', 'DELETE', 462, 'qsdqs', 0, 277),
(23, '2020-01-06', 'INSERT', 463, 'qsdqsdqsd', 0, 278),
(24, '2020-01-06', 'INSERT', 464, 'sdqsd', 0, 279),
(25, '2020-01-07', 'INSERT', 465, 'sqdqsdqsd', 0, 279),
(26, '2020-01-07', 'INSERT', 466, 'sqdqsdqsd', 0, 279),
(27, '2020-01-07', 'INSERT', 467, 'qsdqsd', 0, 279),
(28, '2020-01-07', 'DELETE', 466, 'sqdqsdqsd', 0, 279),
(29, '2020-01-07', 'DELETE', 467, 'qsdqsd', 0, 279),
(30, '2020-01-07', 'INSERT', 468, 'qdsqf', 0, 282),
(31, '2020-01-07', 'DELETE', 468, 'qdsqf', 0, 282),
(32, '2020-01-07', 'INSERT', 469, 'tets 1', 0, 285),
(33, '2020-01-07', 'DELETE', 469, 'tets 1', 0, 285),
(34, '2020-01-07', 'INSERT', 470, '1', 0, 285),
(35, '2020-01-07', 'INSERT', 471, '2', 0, 285),
(36, '2020-01-07', 'INSERT', 472, '3', 0, 285),
(37, '2020-01-07', 'INSERT', 473, '4', 0, 285),
(38, '2020-01-07', 'INSERT', 474, '5', 0, 285),
(39, '2020-01-07', 'INSERT', 475, '6', 0, 285),
(40, '2020-01-07', 'INSERT', 476, '7', 0, 286),
(41, '2020-01-07', 'INSERT', 477, '8', 0, 286),
(42, '2020-01-07', 'INSERT', 478, '9', 0, 286),
(43, '2020-01-07', 'INSERT', 479, '10', 0, 286),
(44, '2020-01-07', 'INSERT', 480, '11', 0, 286),
(45, '2020-01-07', 'INSERT', 481, '12', 0, 286),
(46, '2020-01-08', 'DELETE', 476, '7', 0, 286),
(47, '2020-01-08', 'DELETE', 477, '8', 0, 286),
(48, '2020-01-08', 'DELETE', 478, '9', 0, 286),
(49, '2020-01-08', 'DELETE', 470, '1', 0, 285),
(50, '2020-01-08', 'DELETE', 472, '3', 0, 287),
(51, '2020-01-08', 'INSERT', 482, 'qdsd', 0, 287),
(52, '2020-01-08', 'INSERT', 483, '', 0, 285),
(53, '2020-01-08', 'DELETE', 483, '', 0, 285),
(54, '2020-01-08', 'INSERT', 484, 'qdsqd', 0, 285),
(55, '2020-01-08', 'DELETE', 484, 'qdsqd', 0, 285),
(56, '2020-01-09', 'DELETE', 420, 'Réparer/refaire pagination', 1, 189),
(57, '2020-01-09', 'DELETE', 473, '4', 0, 189),
(58, '2020-01-09', 'DELETE', 474, '5', 1, 189),
(59, '2020-01-09', 'INSERT', 485, 'sdqd', 0, 189),
(60, '2020-01-09', 'INSERT', 486, 'qsdqsd', 0, 189),
(61, '2020-01-09', 'INSERT', 487, 'qqfqd', 0, 294),
(62, '2020-01-09', 'INSERT', 488, 'qsdqsd', 0, 294),
(63, '2020-01-09', 'INSERT', 489, 'qsdqsd', 0, 294),
(64, '2020-01-09', 'INSERT', 490, 'qsdqds', 0, 294),
(65, '2020-01-09', 'INSERT', 491, 'salut', 0, 294),
(66, '2020-01-09', 'INSERT', 492, 'salut', 0, 294),
(67, '2020-01-09', 'INSERT', 493, 'sadsfqsf', 0, 294),
(68, '2020-01-09', 'INSERT', 494, 'sadsfqsf', 0, 294),
(69, '2020-01-09', 'INSERT', 495, 'sdqsd', 0, 294),
(70, '2020-01-09', 'INSERT', 496, 'sdqsd', 0, 294),
(71, '2020-01-09', 'INSERT', 497, 'sqdsdq', 0, 294),
(72, '2020-01-09', 'INSERT', 498, 'sqdsdq', 0, 294),
(73, '2020-01-09', 'INSERT', 499, 'sfds', 0, 299),
(74, '2020-01-09', 'DELETE', 499, 'sfds', 0, 299),
(75, '2020-01-09', 'INSERT', 500, 'sdqsd', 0, 299),
(76, '2020-01-09', 'DELETE', 500, 'sdqsd', 0, 299),
(77, '2020-01-09', 'INSERT', 501, ' Cette liste de todos est vide Cette liste de todos est vide Cette liste de todos est vide Cette liste de todos est vide Cette liste de todos est vide Cette liste de todos est vide Cette liste de todos est vide Cette liste de todos est vide Cette liste de todos est vide Cette liste de todos est vide', 0, 300),
(78, '2020-01-09', 'INSERT', 502, ' Cette liste de todos est vide Cette liste de todos est vide Cette liste de todos est vide Cette liste de todos est vide Cette liste de todos est vide Cette liste de todos est vide Cette liste de todos est vide Cette liste de todos est vide Cette liste de todos est vide Cette liste de todos est vide', 0, 300),
(79, '2020-01-09', 'INSERT', 503, 'http://la-tout-doux-liste/guest/addPublicTodo/http://la-tout-doux-liste/guest/addPublicTodo/http://la-tout-doux-liste/guest/addPublicTodo/http://la-tout-doux-liste/guest/addPublicTodo/http://la-tout-doux-liste/guest/addPublicTodo/http://la-tout-doux-liste/guest/addPublicTodo/http://la-tout-doux-list', 0, 293),
(80, '2020-01-09', 'INSERT', 504, 'http://la-tout-doux-liste/guest/addPublicTodo/http://la-tout-doux-liste/guest/addPublicTodo/http://la-tout-doux-liste/guest/addPublicTodo/http://la-tout-doux-liste/guest/addPublicTodo/http://la-tout-doux-liste/guest/addPublicTodo/http://la-tout-doux-liste/guest/addPublicTodo/http://la-tout-doux-list', 0, 293),
(81, '2020-01-09', 'INSERT', 505, 'http://la-tout-doux-liste/guest/addPublicTodo/http://la-tout-doux-liste/guest/addPublicTodo/http://la-tout-doux-liste/guest/addPublicTodo/http://la-tout-doux-liste/guest/addPublicTodo/http://la-tout-doux-liste/guest/addPublicTodo/http://la-tout-doux-liste/guest/addPublicTodo/http://la-tout-doux-list', 0, 293),
(82, '2020-01-09', 'INSERT', 506, 'sdsd', 0, 293),
(83, '2020-01-09', 'DELETE', 505, 'http://la-tout-doux-liste/guest/addPublicTodo/http://la-tout-doux-liste/guest/addPublicTodo/http://la-tout-doux-liste/guest/addPublicTodo/http://la-tout-doux-liste/guest/addPublicTodo/http://la-tout-doux-liste/guest/addPublicTodo/http://la-tout-doux-liste/guest/addPublicTodo/http://la-tout-doux-list', 0, 301),
(84, '2020-01-09', 'DELETE', 503, 'http://la-tout-doux-liste/guest/addPublicTodo/http://la-tout-doux-liste/guest/addPublicTodo/http://la-tout-doux-liste/guest/addPublicTodo/http://la-tout-doux-liste/guest/addPublicTodo/http://la-tout-doux-liste/guest/addPublicTodo/http://la-tout-doux-liste/guest/addPublicTodo/http://la-tout-doux-list', 0, 293),
(85, '2020-01-09', 'DELETE', 506, 'sdsd', 0, 293),
(86, '2020-01-09', 'DELETE', 504, 'http://la-tout-doux-liste/guest/addPublicTodo/http://la-tout-doux-liste/guest/addPublicTodo/http://la-tout-doux-liste/guest/addPublicTodo/http://la-tout-doux-liste/guest/addPublicTodo/http://la-tout-doux-liste/guest/addPublicTodo/http://la-tout-doux-liste/guest/addPublicTodo/http://la-tout-doux-list', 0, 293),
(87, '2020-01-09', 'INSERT', 507, 'qsdq', 0, 293),
(88, '2020-01-09', 'DELETE', 507, 'qsdq', 0, 293),
(89, '2020-01-09', 'INSERT', 508, '$listIdUser$listIdUser$listIdUser$listIdUser$listIdUser$listIdUser$listIdUser$listIdUser$listIdUser$listIdUser$listIdUser$listIdUser$listIdUser$listIdUser$listIdUser$listIdUser$listIdUser$listIdUser$listIdUser$listIdUser$listIdUser$listIdUser$listIdUser$listIdUser$listIdUser$listIdUser$listIdUser$li', 0, 293),
(90, '2020-01-09', 'DELETE', 508, '$listIdUser$listIdUser$listIdUser$listIdUser$listIdUser$listIdUser$listIdUser$listIdUser$listIdUser$listIdUser$listIdUser$listIdUser$listIdUser$listIdUser$listIdUser$listIdUser$listIdUser$listIdUser$listIdUser$listIdUser$listIdUser$listIdUser$listIdUser$listIdUser$listIdUser$listIdUser$listIdUser$li', 0, 189),
(91, '2020-01-09', 'DELETE', 485, 'sdqd', 0, 189),
(92, '2020-01-09', 'DELETE', 486, 'qsdqsd', 0, 189),
(93, '2020-01-09', 'INSERT', 509, 'qsdqsd', 0, 302),
(94, '2020-01-09', 'DELETE', 509, 'qsdqsd', 0, 302),
(95, '2020-01-10', 'INSERT', 510, 'test', 0, 302),
(96, '2020-01-10', 'DELETE', 510, 'test', 1, 302),
(97, '2020-01-10', 'INSERT', 511, 'qsdqsd', 0, 293),
(98, '2020-01-10', 'INSERT', 512, 'sqdqsd', 0, 304),
(99, '2020-01-10', 'DELETE', 512, 'sqdqsd', 0, 304),
(100, '2020-01-10', 'INSERT', 513, 'qsdqsd', 0, 304),
(101, '2020-01-10', 'DELETE', 513, 'qsdqsd', 0, 304),
(102, '2020-01-10', 'INSERT', 514, 'qsdqsd', 0, 295),
(103, '2020-01-10', 'DELETE', 514, 'qsdqsd', 0, 295),
(104, '2020-01-10', 'DELETE', 494, 'sadsfqsf', 0, 293),
(105, '2020-01-10', 'DELETE', 511, 'qsdqsd', 0, 293),
(106, '2020-01-10', 'DELETE', 491, 'salut', 0, 293),
(107, '2020-01-10', 'INSERT', 515, 'saluttache', 0, 306),
(108, '2020-01-10', 'DELETE', 515, 'saluttache', 0, 306),
(109, '2020-01-10', 'INSERT', 516, 'Faire la présentation du projet', 0, 307),
(110, '2020-01-10', 'INSERT', 517, 'sqdqsd', 0, 307),
(111, '2020-01-10', 'DELETE', 517, 'sqdqsd', 0, 307),
(112, '2020-01-10', 'INSERT', 518, 'dddddddddddjskdjksdjkjjjjjjjazertyuiogfdjklkjhgfghjklkjhgffgdddddddddddjskdjksdjkjjjjjjjazertyuiogfdjklkjhgfghjklkjhgffgdddddddddddjskdjksdjkjjjjjjjazertyuiogfdjklkjhgfghjklkjhgffgdddddddddddjskdjksdjkjjjjjjjazertyuiogfdjklkjhgfghjklkjhgffgdddddddddddjskdjksdjkjjjjjjjazertyuiogfdjklkjhgfghjklkjhgffg', 0, 307),
(113, '2020-01-10', 'DELETE', 518, 'dddddddddddjskdjksdjkjjjjjjjazertyuiogfdjklkjhgfghjklkjhgffgdddddddddddjskdjksdjkjjjjjjjazertyuiogfdjklkjhgfghjklkjhgffgdddddddddddjskdjksdjkjjjjjjjazertyuiogfdjklkjhgfghjklkjhgffgdddddddddddjskdjksdjkjjjjjjjazertyuiogfdjklkjhgfghjklkjhgffgdddddddddddjskdjksdjkjjjjjjjazertyuiogfdjklkjhgfghjklkjhgffg', 0, 307),
(114, '2020-01-10', 'INSERT', 519, 'sqdqsdd', 0, 308),
(115, '2020-01-10', 'DELETE', 519, 'sqdqsdd', 0, 189),
(116, '2020-01-10', 'INSERT', 520, 'Faire la présentation du projet', 0, 189),
(117, '2020-01-10', 'INSERT', 521, 'Terminer le projet', 0, 189),
(118, '2020-01-10', 'INSERT', 522, 'Faire le drag & drop', 0, 189),
(119, '2020-01-10', 'DELETE', 522, 'Faire le drag & drop', 0, 189),
(120, '2020-01-10', 'INSERT', 523, 'Faire le drag and drop', 0, 189),
(121, '2020-01-10', 'INSERT', 524, 'Réviser les patrons de conception', 0, 310),
(122, '2020-01-10', 'INSERT', 525, 'Zipper le projet de todolist', 0, 189),
(123, '2020-01-10', 'INSERT', 526, 'rien', 0, 311);

-- --------------------------------------------------------

--
-- Structure de la table `user`
--

DROP TABLE IF EXISTS `user`;
CREATE TABLE IF NOT EXISTS `user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `pseudo` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL,
  `isAdmin` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `pseudo` (`pseudo`)
) ENGINE=InnoDB AUTO_INCREMENT=39 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `user`
--

INSERT INTO `user` (`id`, `pseudo`, `password`, `isAdmin`) VALUES
(0, 'public', 'public', 0),
(35, 'lilian', '$2y$10$bpzJUb./lDrqlg9bQtwsteL9MUfhHHRibNwlupmG1yRZi7lnTBbly', 0),
(37, 'admin', '$2y$10$pjDZBUe9BbTy6S3decNEDO3rmOKxUSus6fyoYbJT3iB1CE6AcfL6G', 1),
(38, 'toto', '$2y$10$Ac2SEyJZkuz8x7gkOiuPwuvT4m1hKAFRTXyNaTNt2GwtrE1EIW61C', 0);

--
-- Déclencheurs `user`
--
DROP TRIGGER IF EXISTS `TRG_DELETE_USER`;
DELIMITER $$
CREATE TRIGGER `TRG_DELETE_USER` BEFORE DELETE ON `user` FOR EACH ROW INSERT INTO user_log VALUES(null, NOW(), 'DELETE', OLD.id, OLD.pseudo, OLD.isAdmin)
$$
DELIMITER ;
DROP TRIGGER IF EXISTS `TRG_INSERT_USER`;
DELIMITER $$
CREATE TRIGGER `TRG_INSERT_USER` AFTER INSERT ON `user` FOR EACH ROW INSERT INTO user_log VALUES(null, NOW(), 'INSERT', NEW.id, NEW.pseudo, NEW.isAdmin)
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Structure de la table `user_log`
--

DROP TABLE IF EXISTS `user_log`;
CREATE TABLE IF NOT EXISTS `user_log` (
  `idLog` int(11) NOT NULL AUTO_INCREMENT,
  `date` date NOT NULL,
  `action` varchar(50) NOT NULL,
  `idUser` int(11) NOT NULL,
  `pseudo` varchar(100) NOT NULL,
  `isAdmin` tinyint(1) NOT NULL,
  PRIMARY KEY (`idLog`)
) ENGINE=MyISAM AUTO_INCREMENT=27 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `user_log`
--

INSERT INTO `user_log` (`idLog`, `date`, `action`, `idUser`, `pseudo`, `isAdmin`) VALUES
(1, '2019-12-31', 'INSERT', 27, 'salut', 0),
(2, '2019-12-31', 'DELETE', 27, 'salut', 0),
(3, '2019-12-31', 'INSERT', 28, 'moi', 0),
(4, '2020-01-06', 'DELETE', 20, 'lilian', 0),
(5, '2020-01-06', 'DELETE', 23, 'yoyo', 0),
(6, '2020-01-06', 'DELETE', 24, 'myuser', 0),
(7, '2020-01-06', 'DELETE', 25, 'heyho', 0),
(8, '2020-01-06', 'DELETE', 26, 'tetsttetstte', 0),
(9, '2020-01-06', 'DELETE', 28, 'moi', 0),
(10, '2020-01-06', 'INSERT', 29, 'admin', 0),
(11, '2020-01-06', 'INSERT', 30, 'lilian', 0),
(12, '2020-01-06', 'INSERT', 31, 'administrateur', 0),
(13, '2020-01-06', 'DELETE', 29, 'admin', 1),
(14, '2020-01-10', 'INSERT', 32, 'tests', 0),
(15, '2020-01-10', 'INSERT', 33, 'usertest', 0),
(16, '2020-01-10', 'INSERT', 34, 'salut', 0),
(17, '2020-01-10', 'DELETE', 34, 'salut', 0),
(18, '2020-01-10', 'DELETE', 30, 'lilian', 0),
(19, '2020-01-10', 'DELETE', 31, 'administrateur', 1),
(20, '2020-01-10', 'DELETE', 32, 'tests', 0),
(21, '2020-01-10', 'DELETE', 33, 'usertest', 0),
(22, '2020-01-10', 'INSERT', 35, 'lilian', 0),
(23, '2020-01-10', 'INSERT', 36, 'tests', 0),
(24, '2020-01-10', 'DELETE', 36, 'tests', 0),
(25, '2020-01-10', 'INSERT', 37, 'admin', 0),
(26, '2020-01-10', 'INSERT', 38, 'toto', 0);

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `todo`
--
ALTER TABLE `todo`
  ADD CONSTRAINT `FKEY_TODO_IDLIST` FOREIGN KEY (`idList`) REFERENCES `todolist` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT;

--
-- Contraintes pour la table `todolist`
--
ALTER TABLE `todolist`
  ADD CONSTRAINT `FKEY_TODOLIST_IDUSER` FOREIGN KEY (`idUser`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
