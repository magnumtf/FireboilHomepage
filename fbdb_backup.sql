-- MySQL dump 10.13  Distrib 5.7.16, for Linux (x86_64)
--
-- Host: localhost    Database: fireboil_db
-- ------------------------------------------------------
-- Server version	5.7.16-0ubuntu0.16.04.1

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
-- Table structure for table `account`
--

DROP TABLE IF EXISTS `account`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `account` (
  `account_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `create_date` datetime DEFAULT NULL,
  `balance` float DEFAULT NULL,
  `total_deposits` float DEFAULT NULL,
  `status` tinyint(3) unsigned NOT NULL,
  `type` tinyint(3) unsigned NOT NULL,
  PRIMARY KEY (`account_id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `account`
--

LOCK TABLES `account` WRITE;
/*!40000 ALTER TABLE `account` DISABLE KEYS */;
INSERT INTO `account` VALUES (1,'2012-07-22 20:34:21',0,0,0,31),(2,'2012-07-22 20:38:27',0,0,0,31),(3,'2012-07-22 20:38:29',0,0,0,31),(4,'2012-07-22 20:38:31',0,0,0,31),(5,'2012-07-22 21:02:21',1000,1000,0,30);
/*!40000 ALTER TABLE `account` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `customer`
--

DROP TABLE IF EXISTS `customer`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `customer` (
  `customer_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `account_id` int(10) unsigned DEFAULT NULL,
  `username` varchar(30) NOT NULL,
  `password` varchar(20) NOT NULL,
  `firstname` varchar(30) NOT NULL,
  `lastname` varchar(30) NOT NULL,
  `mi` varchar(1) DEFAULT NULL,
  `profitYear` float DEFAULT NULL,
  `profit10` float DEFAULT NULL,
  `profit100` float DEFAULT NULL,
  `email` varchar(30) NOT NULL,
  `status` tinyint(3) unsigned NOT NULL,
  `admin_level` tinyint(3) unsigned NOT NULL,
  `address1` varchar(30) DEFAULT NULL,
  `address2` varchar(30) DEFAULT NULL,
  `city` varchar(30) DEFAULT NULL,
  `state` varchar(30) DEFAULT NULL,
  `zipcode` varchar(10) DEFAULT NULL,
  `country` varchar(30) DEFAULT NULL,
  `phone` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`customer_id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `customer`
--

LOCK TABLES `customer` WRITE;
/*!40000 ALTER TABLE `customer` DISABLE KEYS */;
INSERT INTO `customer` VALUES (1,5,'magnumtf','farttt','Nathaniel','Fox','S',NULL,NULL,NULL,'magnumtf@yahoo.com',1,5,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(2,NULL,'jagnumtf','farttt','Mathaniel','Jox','S',NULL,NULL,NULL,'magnumtf@gmail.com',1,0,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(3,NULL,'yoshi_sux','catsbigvag','Yoshi','Tonkanator','S',NULL,NULL,NULL,'dbox.msgy@gmail.com',1,0,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(4,NULL,'sharty','farty','turd','ferguson','',NULL,NULL,NULL,'dbox.msgy@gmail.com',1,0,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(5,NULL,'shagnum','farttt','Shart','Shorts','',NULL,NULL,NULL,'dbox.msgy@gmail.com',1,0,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(6,NULL,'cbv','cbv2','Cats','BigVag','V',NULL,NULL,NULL,'cbv@vsea.com',1,0,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(7,NULL,'crumb','giggles','Colton','Monsnake','L',NULL,NULL,NULL,'distilo@hotbox.com',1,0,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(8,NULL,'manass','gere','Shelton','Monsvenus','B',NULL,NULL,NULL,'dante@hobo.com',1,0,'10 jude law way','','wakefield','ar','33343','ar','');
/*!40000 ALTER TABLE `customer` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `entry`
--

DROP TABLE IF EXISTS `entry`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `entry` (
  `entry_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `rot_id` smallint(5) unsigned NOT NULL,
  `name` varchar(45) NOT NULL,
  `date` date NOT NULL,
  PRIMARY KEY (`entry_id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `entry`
--

LOCK TABLES `entry` WRITE;
/*!40000 ALTER TABLE `entry` DISABLE KEYS */;
INSERT INTO `entry` VALUES (1,101,'New York Giants','2012-07-23'),(2,102,'New England Patriots','2012-07-23');
/*!40000 ALTER TABLE `entry` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `game_desc`
--

DROP TABLE IF EXISTS `game_desc`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `game_desc` (
  `game_desc_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(80) NOT NULL,
  `start_time` datetime NOT NULL,
  `num_entries` tinyint(3) unsigned NOT NULL,
  `category` varchar(20) DEFAULT NULL,
  `subcategory` varchar(20) DEFAULT NULL,
  `point_spread` float DEFAULT NULL,
  `pwp_spread` tinyint(4) DEFAULT NULL,
  `over_under` float DEFAULT NULL,
  `status` tinyint(3) unsigned NOT NULL,
  `entry1` smallint(5) unsigned NOT NULL,
  `entry2` smallint(5) unsigned NOT NULL,
  `entry3` smallint(5) unsigned DEFAULT NULL,
  `entry4` smallint(5) unsigned DEFAULT NULL,
  `entry5` smallint(5) unsigned DEFAULT NULL,
  `entry6` smallint(5) unsigned DEFAULT NULL,
  `entry7` smallint(5) unsigned DEFAULT NULL,
  `entry8` smallint(5) unsigned DEFAULT NULL,
  `entry9` smallint(5) unsigned DEFAULT NULL,
  `entry10` smallint(5) unsigned DEFAULT NULL,
  `entry11` smallint(5) unsigned DEFAULT NULL,
  `entry12` smallint(5) unsigned DEFAULT NULL,
  `entry13` smallint(5) unsigned DEFAULT NULL,
  `entry14` smallint(5) unsigned DEFAULT NULL,
  `entry15` smallint(5) unsigned DEFAULT NULL,
  `entry16` smallint(5) unsigned DEFAULT NULL,
  `entry17` smallint(5) unsigned DEFAULT NULL,
  `entry18` smallint(5) unsigned DEFAULT NULL,
  `entry19` smallint(5) unsigned DEFAULT NULL,
  `entry20` smallint(5) unsigned DEFAULT NULL,
  `favorite` smallint(5) unsigned DEFAULT NULL,
  PRIMARY KEY (`game_desc_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `game_desc`
--

LOCK TABLES `game_desc` WRITE;
/*!40000 ALTER TABLE `game_desc` DISABLE KEYS */;
INSERT INTO `game_desc` VALUES (1,'Super Bowl XXXIV - New England Patriots and New York Giants','2012-07-30 16:15:00',2,NULL,NULL,3,3,53.5,200,101,102,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,102);
/*!40000 ALTER TABLE `game_desc` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `pool`
--

DROP TABLE IF EXISTS `pool`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `pool` (
  `pool_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `account_id` int(10) unsigned DEFAULT NULL,
  `game_desc_id` int(10) unsigned NOT NULL,
  `type` tinyint(3) unsigned NOT NULL,
  `status` tinyint(3) unsigned NOT NULL,
  PRIMARY KEY (`pool_id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `pool`
--

LOCK TABLES `pool` WRITE;
/*!40000 ALTER TABLE `pool` DISABLE KEYS */;
INSERT INTO `pool` VALUES (1,1,1,100,1),(2,2,1,101,1),(3,3,1,102,1),(4,4,1,103,1);
/*!40000 ALTER TABLE `pool` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `test`
--

DROP TABLE IF EXISTS `test`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `test` (
  `test_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `odds_1` float DEFAULT NULL,
  `odds_2` float DEFAULT NULL,
  PRIMARY KEY (`test_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `test`
--

LOCK TABLES `test` WRITE;
/*!40000 ALTER TABLE `test` DISABLE KEYS */;
/*!40000 ALTER TABLE `test` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `transaction`
--

DROP TABLE IF EXISTS `transaction`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `transaction` (
  `trans_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `from_acct_id` int(10) unsigned NOT NULL,
  `to_acct_id` int(10) unsigned NOT NULL,
  `amount` float NOT NULL,
  `type` tinyint(4) NOT NULL,
  `status` tinyint(4) NOT NULL,
  PRIMARY KEY (`trans_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `transaction`
--

LOCK TABLES `transaction` WRITE;
/*!40000 ALTER TABLE `transaction` DISABLE KEYS */;
/*!40000 ALTER TABLE `transaction` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2016-12-07 22:00:39
