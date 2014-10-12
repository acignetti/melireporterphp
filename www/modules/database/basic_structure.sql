CREATE DATABASE  IF NOT EXISTS `melireport` /*!40100 DEFAULT CHARACTER SET utf8 COLLATE utf8_spanish_ci */;
USE `melireport`;
-- MySQL dump 10.15  Distrib 10.0.14-MariaDB, for Linux (x86_64)
--
-- Host: 127.0.0.1    Database: melireport
-- ------------------------------------------------------
-- Server version	10.0.14-MariaDB-log

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
-- Table structure for table `buyers`
--

DROP TABLE IF EXISTS `buyers`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `buyers` (
  `buyer_id` bigint(20) NOT NULL AUTO_INCREMENT,
  `buyer_ml_id` varchar(200) COLLATE utf8_spanish_ci NOT NULL,
  `buyer_name` varchar(200) COLLATE utf8_spanish_ci NOT NULL,
  `buyer_real_name` varchar(200) COLLATE utf8_spanish_ci DEFAULT NULL,
  `buyer_last_name` varchar(200) COLLATE utf8_spanish_ci DEFAULT NULL,
  `buyer_email` varchar(200) COLLATE utf8_spanish_ci DEFAULT NULL,
  `buyer_address` text COLLATE utf8_spanish_ci,
  `buyer_created_on` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `buyer_modified_on` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`buyer_id`),
  UNIQUE KEY `buyer_ml_id` (`buyer_ml_id`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `categories`
--

DROP TABLE IF EXISTS `categories`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `categories` (
  `category_id` bigint(20) NOT NULL AUTO_INCREMENT,
  `category_name` varchar(100) COLLATE utf8_spanish_ci NOT NULL,
  `category_description` tinytext COLLATE utf8_spanish_ci,
  `category_father` bigint(20) NOT NULL DEFAULT '0',
  `category_status` tinyint(4) NOT NULL DEFAULT '1',
  `category_ml_id` varchar(50) COLLATE utf8_spanish_ci DEFAULT NULL,
  PRIMARY KEY (`category_id`),
  UNIQUE KEY `cetegory_ml_id` (`category_ml_id`)
) ENGINE=InnoDB AUTO_INCREMENT=47792 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `items`
--

DROP TABLE IF EXISTS `items`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `items` (
  `item_id` bigint(20) NOT NULL AUTO_INCREMENT,
  `item_ml_id` varchar(200) COLLATE utf8_spanish_ci NOT NULL,
  `item_name` varchar(250) COLLATE utf8_spanish_ci NOT NULL,
  `item_description` text COLLATE utf8_spanish_ci,
  `item_thumbnail` text COLLATE utf8_spanish_ci,
  `item_price` float NOT NULL,
  `item_cost` float DEFAULT NULL,
  `item_published_on` datetime NOT NULL,
  `item_ended_on` datetime DEFAULT NULL,
  `item_category_id` bigint(20) NOT NULL,
  PRIMARY KEY (`item_id`),
  UNIQUE KEY `item_ml_id` (`item_ml_id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `payment_type`
--

DROP TABLE IF EXISTS `payment_type`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `payment_type` (
  `payment_id` bigint(20) NOT NULL AUTO_INCREMENT,
  `payment_name` varchar(100) COLLATE utf8_spanish_ci NOT NULL,
  `payment_description` tinytext COLLATE utf8_spanish_ci,
  `payment_status` tinyint(4) NOT NULL DEFAULT '1',
  `payment_category` varchar(45) COLLATE utf8_spanish_ci DEFAULT NULL,
  PRIMARY KEY (`payment_id`),
  UNIQUE KEY `payment_name` (`payment_name`)
) ENGINE=InnoDB AUTO_INCREMENT=49 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `sales`
--

DROP TABLE IF EXISTS `sales`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `sales` (
  `sale_id` bigint(20) NOT NULL AUTO_INCREMENT,
  `sale_ml_id` bigint(20) DEFAULT NULL,
  `sale_user_id` bigint(20) NOT NULL,
  `sale_item_id` bigint(20) NOT NULL,
  `sale_payment_id` bigint(20) NOT NULL,
  `sale_buyer_id` bigint(20) NOT NULL,
  `sale_quantity` int(11) NOT NULL,
  `sale_bought_on` datetime NOT NULL,
  `sale_paid_on` datetime DEFAULT NULL,
  `sale_status` varchar(100) COLLATE utf8_spanish_ci NOT NULL,
  `sale_total` float NOT NULL,
  PRIMARY KEY (`sale_id`),
  UNIQUE KEY `sale_ml_id_UNIQUE` (`sale_ml_id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `users` (
  `user_id` bigint(20) NOT NULL AUTO_INCREMENT,
  `user_ml_id` bigint(20) DEFAULT NULL,
  `user_name` varchar(50) COLLATE utf8_spanish_ci NOT NULL,
  `user_password` varchar(100) COLLATE utf8_spanish_ci NOT NULL,
  `user_email` tinytext COLLATE utf8_spanish_ci NOT NULL,
  `user_real_name` tinytext COLLATE utf8_spanish_ci NOT NULL,
  `user_last_name` tinytext COLLATE utf8_spanish_ci NOT NULL,
  `user_token` tinytext COLLATE utf8_spanish_ci,
  `user_last_seen` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `user_status` tinyint(4) NOT NULL DEFAULT '1',
  PRIMARY KEY (`user_id`),
  UNIQUE KEY `user_name_UNIQUE` (`user_name`),
  UNIQUE KEY `user_ml_id_UNIQUE` (`user_ml_id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (1,NULL,'admin','asdf','do.not@email.me','Agustin','Cignetti','APP_USR-6283809452926869-101201-3a4ac1332df1fa8125a466211252c180__G_F__-42743213','2014-10-07 21:06:09',1),(2,NULL,'admin@gmail.com','asdf1234','','','',NULL,'2014-10-11 22:00:56',1),(3,168655102,'TT726719','qatest683','test_user_85167671@testuser.com','Seller','User','APP_USR-6283809452926869-101206-07dbf5f79659b12a37aa2f62cc7e642a__D_K__-168655102','2014-10-12 02:35:21',1);
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2014-10-12 14:20:28
