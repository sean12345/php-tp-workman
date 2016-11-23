-- MySQL dump 10.13  Distrib 5.5.49, for debian-linux-gnu (x86_64)
--
-- Host: 192.168.2.115    Database: aums
-- ------------------------------------------------------
-- Server version	5.5.44

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
-- Table structure for table `au_subscribe`
--

DROP TABLE IF EXISTS `au_subscribe`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `au_subscribe` (
  `sid` int(11) NOT NULL AUTO_INCREMENT COMMENT '订阅ID',
  `dealer_id` int(11) NOT NULL COMMENT '车商ID',
  `name` varchar(100) DEFAULT NULL COMMENT '订阅器名称',
  `createtime` datetime DEFAULT NULL COMMENT '创建时间',
  PRIMARY KEY (`sid`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `au_subscribe`
--

LOCK TABLES `au_subscribe` WRITE;
/*!40000 ALTER TABLE `au_subscribe` DISABLE KEYS */;
INSERT INTO `au_subscribe` VALUES (1,206,'订阅1','2016-09-21 20:21:57'),(2,206,'订阅2','2016-09-14 20:22:54');
/*!40000 ALTER TABLE `au_subscribe` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `au_subscribe_key`
--

DROP TABLE IF EXISTS `au_subscribe_key`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `au_subscribe_key` (
  `key_id` int(11) NOT NULL COMMENT '自增ID',
  `key_name` varchar(30) DEFAULT NULL COMMENT '名称',
  `key_type` tinyint(1) NOT NULL COMMENT '类型',
  `dealer_id` int(11) NOT NULL COMMENT '车商ID',
  `sid` int(11) NOT NULL COMMENT '订阅ID',
  `createtime` datetime NOT NULL COMMENT '创建时间',
  PRIMARY KEY (`key_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `au_subscribe_key`
--

LOCK TABLES `au_subscribe_key` WRITE;
/*!40000 ALTER TABLE `au_subscribe_key` DISABLE KEYS */;
INSERT INTO `au_subscribe_key` VALUES (1,'宝马',1,206,1,'2016-09-21 20:29:09'),(2,'北京',3,206,1,'2016-09-21 20:23:31'),(3,'金华',3,206,2,'2016-09-21 20:30:11'),(4,'三年以下',4,206,2,'2016-09-21 20:31:06'),(5,'杭州',3,206,1,'2016-09-21 20:49:23'),(6,'1A',2,206,1,'2016-09-23 15:38:18');
/*!40000 ALTER TABLE `au_subscribe_key` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `au_subscribe_order`
--

DROP TABLE IF EXISTS `au_subscribe_order`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `au_subscribe_order` (
  `so_id` int(11) NOT NULL AUTO_INCREMENT COMMENT '自增ID',
  `sid` int(11) NOT NULL COMMENT '订阅ID',
  `order_id` int(11) NOT NULL COMMENT '拍单ID',
  PRIMARY KEY (`so_id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `au_subscribe_order`
--

LOCK TABLES `au_subscribe_order` WRITE;
/*!40000 ALTER TABLE `au_subscribe_order` DISABLE KEYS */;
INSERT INTO `au_subscribe_order` VALUES (1,1,1398),(2,2,1397);
/*!40000 ALTER TABLE `au_subscribe_order` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `au_car_dealer_device`
--

DROP TABLE IF EXISTS `au_car_dealer_device`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `au_car_dealer_device` (
  `cdd_id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '自增ID',
  `uid` int(11) NOT NULL COMMENT '用户id',
  `dealer_id` int(11) NOT NULL COMMENT '车商ID',
  `jpush_id` varchar(40) COLLATE utf8_bin NOT NULL COMMENT '设备码',
  `createtime` datetime NOT NULL COMMENT '创建时间',
  PRIMARY KEY (`cdd_id`),
  KEY `idx_uid` (`uid`),
  KEY `idx_dealer_id` (`dealer_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='车商设备码关联表';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `au_car_dealer_device`
--

LOCK TABLES `au_car_dealer_device` WRITE;
/*!40000 ALTER TABLE `au_car_dealer_device` DISABLE KEYS */;
/*!40000 ALTER TABLE `au_car_dealer_device` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2016-09-23  8:57:14
