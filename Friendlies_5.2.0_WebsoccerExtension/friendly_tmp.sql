-- MySQL dump 10.13  Distrib 5.6.17, for debian-linux-gnu (x86_64)
--
-- ------------------------------------------------------
-- Server version	5.6.17-1~dotdeb.1

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `_friendly_tmp`
--

CREATE TABLE IF NOT EXISTS `_friendly_tmp` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `spieltyp` enum('Freundschaft') DEFAULT 'Freundschaft',
  `datum` int(10) NOT NULL,
  `stadion_id` int(10) NOT NULL,
  `home_verein` int(10) NOT NULL,
  `gast_verein` int(10) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

