# ************************************************************
# Sequel Pro SQL dump
# Version 3408
#
# http://www.sequelpro.com/
# http://code.google.com/p/sequel-pro/
#
# Host: localhost (MySQL 5.5.25)
# Database: movies
# Generation Time: 2012-09-16 21:33:30 +0000
# ************************************************************


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


# Dump of table genres
# ------------------------------------------------------------

LOCK TABLES `genres` WRITE;
/*!40000 ALTER TABLE `genres` DISABLE KEYS */;

INSERT INTO `genres` (`id`, `name`)
VALUES
	(1,'Action'),
	(2,'Comedy'),
	(3,'Family'),
	(4,'History'),
	(5,'Mystery'),
	(6,'Sci-Fi'),
	(7,'War'),
	(8,'Adventure'),
	(9,'Crime'),
	(10,'Fantasy'),
	(11,'Horror'),
	(12,'News'),
	(13,'Sport'),
	(14,'Western'),
	(15,'Animation'),
	(16,'Documentary'),
	(17,'Film-Noir'),
	(18,'Music'),
	(19,'Reality-TV'),
	(20,'Talk-Show'),
	(21,'Biography'),
	(22,'Drama'),
	(23,'Game-Show'),
	(24,'Musical'),
	(25,'Romance'),
	(26,'Thriller');

/*!40000 ALTER TABLE `genres` ENABLE KEYS */;
UNLOCK TABLES;



/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
