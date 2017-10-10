-- MySQL dump 10.13  Distrib 5.7.19, for Linux (x86_64)
--
-- Host: localhost    Database: hong_cms
-- ------------------------------------------------------
-- Server version	5.7.19-0ubuntu0.16.04.1

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
-- Table structure for table `login_log`
--

DROP TABLE IF EXISTS `login_log`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `login_log` (
  `logid` int(11) NOT NULL AUTO_INCREMENT,
  `account` varchar(30) DEFAULT NULL,
  `ip` varchar(15) DEFAULT NULL,
  `status` int(11) DEFAULT NULL,
  `browser` varchar(255) DEFAULT NULL,
  `logtime` int(11) DEFAULT NULL,
  `get_param` varchar(512) DEFAULT NULL,
  `post_param` varchar(1024) DEFAULT NULL,
  PRIMARY KEY (`logid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `login_log`
--

LOCK TABLES `login_log` WRITE;
/*!40000 ALTER TABLE `login_log` DISABLE KEYS */;
/*!40000 ALTER TABLE `login_log` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `menu`
--

DROP TABLE IF EXISTS `menu`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `menu` (
  `mid` int(11) NOT NULL AUTO_INCREMENT,
  `menu_name` varchar(128) DEFAULT NULL,
  `parent_id` int(11) DEFAULT NULL,
  `url` varchar(512) DEFAULT NULL,
  `type` int(11) DEFAULT NULL,
  `icon` varchar(30) DEFAULT NULL,
  `sort` int(11) DEFAULT NULL,
  `des` varchar(255) DEFAULT NULL,
  `islog` int(11) DEFAULT NULL,
  `optype` varchar(1) DEFAULT NULL,
  `deep` int(11) DEFAULT NULL,
  `status` int(11) DEFAULT NULL,
  PRIMARY KEY (`mid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `menu`
--

LOCK TABLES `menu` WRITE;
/*!40000 ALTER TABLE `menu` DISABLE KEYS */;
/*!40000 ALTER TABLE `menu` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `role`
--

DROP TABLE IF EXISTS `role`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `role` (
  `rid` int(11) NOT NULL AUTO_INCREMENT,
  `rolename` varchar(128) DEFAULT NULL,
  `role_des` varchar(512) DEFAULT NULL,
  `create_time` int(11) DEFAULT NULL,
  `status` int(11) DEFAULT NULL,
  PRIMARY KEY (`rid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `role`
--

LOCK TABLES `role` WRITE;
/*!40000 ALTER TABLE `role` DISABLE KEYS */;
/*!40000 ALTER TABLE `role` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `role_menu`
--

DROP TABLE IF EXISTS `role_menu`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `role_menu` (
  `rmid` int(11) DEFAULT NULL,
  `rid` int(11) DEFAULT NULL,
  `mid` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `role_menu`
--

LOCK TABLES `role_menu` WRITE;
/*!40000 ALTER TABLE `role_menu` DISABLE KEYS */;
/*!40000 ALTER TABLE `role_menu` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sys_log`
--

DROP TABLE IF EXISTS `sys_log`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `sys_log` (
  `logid` int(11) NOT NULL AUTO_INCREMENT,
  `content` varchar(5000) DEFAULT NULL,
  `optype` int(11) DEFAULT NULL,
  `ip` varchar(15) DEFAULT NULL,
  `url` varchar(1024) DEFAULT NULL,
  `account` varchar(30) DEFAULT NULL,
  `username` varchar(50) DEFAULT NULL,
  `get_param` varchar(512) DEFAULT NULL,
  `post_param` varchar(5000) DEFAULT NULL,
  `log_time` int(11) DEFAULT NULL,
  PRIMARY KEY (`logid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sys_log`
--

LOCK TABLES `sys_log` WRITE;
/*!40000 ALTER TABLE `sys_log` DISABLE KEYS */;
/*!40000 ALTER TABLE `sys_log` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sysuer_role`
--

DROP TABLE IF EXISTS `sysuer_role`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `sysuer_role` (
  `srid` int(11) NOT NULL AUTO_INCREMENT,
  `suid` int(11) DEFAULT NULL,
  `rid` int(11) DEFAULT NULL,
  PRIMARY KEY (`srid`),
  UNIQUE KEY `unique_auth` (`suid`,`rid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sysuer_role`
--

LOCK TABLES `sysuer_role` WRITE;
/*!40000 ALTER TABLE `sysuer_role` DISABLE KEYS */;
/*!40000 ALTER TABLE `sysuer_role` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sysuser`
--

DROP TABLE IF EXISTS `sysuser`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `sysuser` (
  `suid` int(11) NOT NULL AUTO_INCREMENT COMMENT '系统用户主键',
  `account` varchar(20) NOT NULL,
  `username` varchar(50) DEFAULT NULL,
  `password` varchar(64) NOT NULL,
  `mobile_phone` varchar(11) DEFAULT NULL,
  `email` varchar(128) DEFAULT NULL,
  `create_time` int(11) DEFAULT NULL,
  `last_loginip` varchar(15) DEFAULT NULL,
  `last_logintime` int(11) DEFAULT NULL,
  `login_count` int(11) DEFAULT NULL,
  `is_super_admin` int(11) DEFAULT NULL,
  `status` int(11) DEFAULT NULL,
  PRIMARY KEY (`suid`),
  UNIQUE KEY `unique_account` (`account`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sysuser`
--

LOCK TABLES `sysuser` WRITE;
/*!40000 ALTER TABLE `sysuser` DISABLE KEYS */;
INSERT INTO `sysuser` VALUES (3,'conna45','hong','$2y$12$f7vUJOteSBoVaXvUHS.FoOORwwvWYY3Xm7Dh28D1Y5hqp9g5qyH.K',NULL,NULL,1506438516,'192.168.10.1',NULL,NULL,1,NULL);
/*!40000 ALTER TABLE `sysuser` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2017-10-10 16:00:39
