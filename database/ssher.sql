CREATE DATABASE  IF NOT EXISTS `ssher` /*!40100 DEFAULT CHARACTER SET latin1 */;
USE `ssher`;
-- MySQL dump 10.13  Distrib 5.7.22, for Linux (x86_64)
--
-- Host: localhost    Database: ssher
-- ------------------------------------------------------
-- Server version	5.7.22-0ubuntu0.16.04.1

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
-- Table structure for table `acts`
--

DROP TABLE IF EXISTS `acts`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `acts` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) DEFAULT NULL,
  `description` varchar(500) DEFAULT NULL,
  `server_id` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=45 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `acts`
--

LOCK TABLES `acts` WRITE;
/*!40000 ALTER TABLE `acts` DISABLE KEYS */;
INSERT INTO `acts` VALUES (24,'act1','act1',7,NULL,'2018-04-30 15:34:35','2018-04-30 15:34:35'),(25,'act2','awefawefawefawef',7,NULL,'2018-04-30 15:42:35','2018-04-30 15:42:35'),(26,'act3','act3',7,NULL,'2018-04-30 15:50:05','2018-04-30 15:50:05'),(27,'act4','act4',7,NULL,'2018-04-30 15:53:24','2018-04-30 15:53:24'),(28,'aad1','awefawefawef',7,NULL,'2018-04-30 15:57:13','2018-04-30 15:57:13'),(29,'vvvv','aaaaaaaaaaaaaaa',7,NULL,'2018-04-30 16:00:04','2018-04-30 16:00:04'),(30,'11111','12412412',7,NULL,'2018-04-30 16:43:24','2018-04-30 16:43:24'),(31,'aaaaaa','bbbbbbbbbbb',7,NULL,'2018-04-30 16:45:21','2018-04-30 16:45:21'),(32,'aaaaaaaaa','aaaaaaaaa',7,NULL,'2018-04-30 16:49:21','2018-04-30 16:49:21'),(33,'act','act',7,NULL,'2018-04-30 17:00:06','2018-04-30 17:00:06'),(34,'1111','awefawef',7,NULL,'2018-04-30 17:04:08','2018-04-30 17:04:08'),(35,'aaaaaaaaaaaaaaa','aaaaaaaaaaaaaa',7,NULL,'2018-04-30 17:05:05','2018-04-30 17:05:05'),(36,'awefawefawef','awefawef',7,NULL,'2018-04-30 17:06:47','2018-04-30 17:06:47'),(37,'22222222222222222','222222222222',7,NULL,'2018-04-30 17:09:14','2018-04-30 17:09:14'),(38,'aaaaaaaaaaaaaaaaaaaaa','aaaaaaaaaaaaaaa',7,NULL,'2018-04-30 17:12:15','2018-04-30 17:12:15'),(39,'awefawefawefawef','awefawefawef',7,NULL,'2018-04-30 17:14:26','2018-04-30 17:14:26'),(40,'aaaaaaaaaaaaaaaa','aaaaaaaaaaaaaaaa',7,NULL,'2018-04-30 17:21:38','2018-04-30 17:21:38'),(41,'1111111111111111111111','111111111111111111',7,NULL,'2018-04-30 17:23:01','2018-04-30 17:23:01'),(42,'1111111111111111111111','awefawefawef',6,NULL,'2018-04-30 17:27:04','2018-04-30 17:27:04'),(43,'2222222222222222','222222222222222222',6,NULL,'2018-04-30 17:52:12','2018-04-30 17:52:12'),(44,'aaaaaaaaaaaaaaaaaaaaa','awefaweffffffffffffffffffffffffffffffff',6,NULL,'2018-04-30 17:55:22','2018-04-30 17:55:22');
/*!40000 ALTER TABLE `acts` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cmds`
--

DROP TABLE IF EXISTS `cmds`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cmds` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `server_id` int(11) DEFAULT NULL,
  `action` varchar(50) DEFAULT NULL,
  `cmd` varchar(50) DEFAULT NULL,
  `act_name` varchar(50) DEFAULT NULL,
  `act_description` varchar(500) DEFAULT NULL,
  `act_id` int(11) DEFAULT NULL,
  `ret` longtext,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=159 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cmds`
--

LOCK TABLES `cmds` WRITE;
/*!40000 ALTER TABLE `cmds` DISABLE KEYS */;
INSERT INTO `cmds` VALUES (90,7,'connect',NULL,'act1','act1',24,'Authentication Failed!','2018-04-30 15:34:35','2018-04-30 15:34:35'),(91,7,'cmd','ls',NULL,NULL,24,'nothing','2018-04-30 15:40:25','2018-04-30 15:40:25'),(92,7,'connect',NULL,'act2','awefawefawefawef',25,'Authentication Failed!','2018-04-30 15:42:35','2018-04-30 15:42:35'),(93,7,'connect',NULL,'act3','act3',26,'Authentication Failed!','2018-04-30 15:50:05','2018-04-30 15:50:05'),(94,7,'cmd','ls',NULL,NULL,26,'nothing','2018-04-30 15:51:05','2018-04-30 15:51:05'),(95,7,'connect',NULL,'act4','act4',27,'Authentication Failed!','2018-04-30 15:53:24','2018-04-30 15:53:24'),(96,7,'connect',NULL,'aad1','awefawefawef',28,'Authentication Failed!','2018-04-30 15:57:13','2018-04-30 15:57:13'),(97,7,'connect',NULL,'vvvv','aaaaaaaaaaaaaaa',29,'Authentication Successful!','2018-04-30 16:00:04','2018-04-30 16:00:04'),(98,7,'cmd','ls',NULL,NULL,29,'a\nb\ngo\nparallels\n','2018-04-30 16:00:10','2018-04-30 16:00:10'),(99,7,'cmd','rm a',NULL,NULL,29,'nothing','2018-04-30 16:00:15','2018-04-30 16:00:15'),(100,7,'cmd','ls',NULL,NULL,29,'b\ngo\nparallels\n','2018-04-30 16:00:18','2018-04-30 16:00:18'),(101,7,'cmd','rm b',NULL,NULL,29,'nothing','2018-04-30 16:00:22','2018-04-30 16:00:22'),(102,7,'cmd','cd /',NULL,NULL,29,'nothing','2018-04-30 16:00:34','2018-04-30 16:00:34'),(103,7,'cmd','ls',NULL,NULL,29,'go\nparallels\n','2018-04-30 16:00:36','2018-04-30 16:00:36'),(104,7,'cmd','cd /var',NULL,NULL,29,'nothing','2018-04-30 16:00:46','2018-04-30 16:00:46'),(105,7,'cmd','ls',NULL,NULL,29,'go\nparallels\n','2018-04-30 16:00:50','2018-04-30 16:00:50'),(106,7,'connect',NULL,'11111','12412412',30,'Authentication Successful!','2018-04-30 16:43:24','2018-04-30 16:43:24'),(107,7,'cmd','ls',NULL,NULL,30,'go\nparallels\n','2018-04-30 16:44:30','2018-04-30 16:44:30'),(108,7,'connect',NULL,'aaaaaa','bbbbbbbbbbb',31,'Authentication Successful!','2018-04-30 16:45:21','2018-04-30 16:45:21'),(109,7,'cmd','ls',NULL,NULL,31,'go\nparallels\n','2018-04-30 16:45:28','2018-04-30 16:45:28'),(110,7,'connect',NULL,'aaaaaaaaa','aaaaaaaaa',32,'Authentication Successful!','2018-04-30 16:49:21','2018-04-30 16:49:21'),(111,7,'cmd','ls',NULL,NULL,32,'go\nparallels\n','2018-04-30 16:49:28','2018-04-30 16:49:28'),(112,7,'cmd','cd /var',NULL,NULL,32,'nothing','2018-04-30 16:49:33','2018-04-30 16:49:33'),(113,7,'cmd','ls',NULL,NULL,32,'go\nparallels\n','2018-04-30 16:49:37','2018-04-30 16:49:37'),(114,7,'connect',NULL,'act','act',33,'Authentication Successful!','2018-04-30 17:00:06','2018-04-30 17:00:06'),(115,7,'cmd','ls',NULL,NULL,33,'go\nparallels\n/root\n','2018-04-30 17:00:13','2018-04-30 17:00:13'),(116,7,'connect',NULL,'1111','awefawef',34,'Authentication Successful!','2018-04-30 17:04:08','2018-04-30 17:04:08'),(117,7,'cmd','ls',NULL,NULL,34,'go\nparallels\n/root\n','2018-04-30 17:04:14','2018-04-30 17:04:14'),(118,7,'connect',NULL,'aaaaaaaaaaaaaaa','aaaaaaaaaaaaaa',35,'Authentication Successful!','2018-04-30 17:05:05','2018-04-30 17:05:05'),(119,7,'cmd','ls',NULL,NULL,35,'go\nparallels\n/root\n','2018-04-30 17:05:11','2018-04-30 17:05:11'),(120,7,'connect',NULL,'awefawefawef','awefawef',36,'Authentication Successful!','2018-04-30 17:06:47','2018-04-30 17:06:47'),(121,7,'cmd','ls',NULL,NULL,36,'go\nparallels\n/root\n','2018-04-30 17:06:56','2018-04-30 17:06:56'),(122,7,'connect',NULL,'22222222222222222','222222222222',37,'Authentication Successful!','2018-04-30 17:09:14','2018-04-30 17:09:14'),(123,7,'cmd','ls',NULL,NULL,37,'go\nparallels\n/root\n','2018-04-30 17:09:36','2018-04-30 17:09:36'),(124,7,'connect',NULL,'aaaaaaaaaaaaaaaaaaaaa','aaaaaaaaaaaaaaa',38,'Authentication Successful!','2018-04-30 17:12:15','2018-04-30 17:12:15'),(125,7,'cmd','ls',NULL,NULL,38,'go\nparallels\n/root\n','2018-04-30 17:12:21','2018-04-30 17:12:21'),(126,7,'cmd','cd /var',NULL,NULL,38,'/var\n','2018-04-30 17:12:57','2018-04-30 17:12:57'),(127,7,'cmd','ls',NULL,NULL,38,'backups\ncache\ndrweb\nlib\nlist\nlocal\nlock\nlog\nmail\nnamed\nopt\nparallels\nproftpd.delay\nqmail\nrun\nspool\ntmp\nwww\n/var\n','2018-04-30 17:13:03','2018-04-30 17:13:03'),(128,7,'connect',NULL,'awefawefawefawef','awefawefawef',39,'Authentication Successful!','2018-04-30 17:14:26','2018-04-30 17:14:26'),(129,7,'cmd','ls',NULL,NULL,39,'backups\ncache\ndrweb\nlib\nlist\nlocal\nlock\nlog\nmail\nnamed\nopt\nparallels\nproftpd.delay\nqmail\nrun\nspool\ntmp\nwww\n','2018-04-30 17:14:33','2018-04-30 17:14:33'),(130,7,'connect',NULL,'aaaaaaaaaaaaaaaa','aaaaaaaaaaaaaaaa',40,'Authentication Successful!','2018-04-30 17:21:38','2018-04-30 17:21:38'),(131,7,'cmd','ls',NULL,NULL,40,'go\nparallels\n','2018-04-30 17:21:45','2018-04-30 17:21:45'),(132,7,'cmd','cd /var',NULL,NULL,40,'','2018-04-30 17:21:49','2018-04-30 17:21:49'),(133,7,'connect',NULL,'1111111111111111111111','111111111111111111',41,'Authentication Successful!','2018-04-30 17:23:01','2018-04-30 17:23:01'),(134,7,'cmd','ls',NULL,NULL,41,'go\nparallels\n','2018-04-30 17:23:50','2018-04-30 17:23:50'),(135,7,'cmd','cd /var',NULL,NULL,41,'nothing','2018-04-30 17:24:02','2018-04-30 17:24:02'),(136,7,'cmd','ls',NULL,NULL,41,'backups\ncache\ndrweb\nlib\nlist\nlocal\nlock\nlog\nmail\nnamed\nopt\nparallels\nproftpd.delay\nqmail\nrun\nspool\ntmp\nwww\n','2018-04-30 17:24:05','2018-04-30 17:24:05'),(137,7,'cmd','cd ..',NULL,NULL,41,'nothing','2018-04-30 17:26:40','2018-04-30 17:26:40'),(138,7,'cmd','ls',NULL,NULL,41,'bin\nboot\ndev\netc\nhome\ninitrd.img\ninitrd.img.old\nlib\nlib32\nlib64\nlost+found\nmedia\nmnt\nopt\nproc\nroot\nrun\nsbin\nsrv\nsys\ntmp\nusr\nvar\nvmlinuz\nvmlinuz.old\n','2018-04-30 17:26:45','2018-04-30 17:26:45'),(139,6,'connect',NULL,'1111111111111111111111','awefawefawef',42,'Authentication Successful!','2018-04-30 17:27:04','2018-04-30 17:27:04'),(140,6,'cmd','ls',NULL,NULL,42,'nothing','2018-04-30 17:27:10','2018-04-30 17:27:10'),(141,6,'cmd','ls',NULL,NULL,42,'nothing','2018-04-30 17:27:19','2018-04-30 17:27:19'),(142,6,'cmd','pwd',NULL,NULL,42,'nothing','2018-04-30 17:27:53','2018-04-30 17:27:53'),(143,6,'cmd','df',NULL,NULL,42,'Filesystem     1K-blocks    Used Available Use% Mounted on\nudev             1966928       0   1966928   0% /dev\ntmpfs             394804   40076    354728  11% /run\n/dev/sda1       50758760 1280628  49461748   3% /\ntmpfs            1974008       0   1974008   0% /dev/shm\ntmpfs               5120       0      5120   0% /run/lock\ntmpfs            1974008       0   1974008   0% /sys/fs/cgroup\ntmpfs             394804       0    394804   0% /run/user/0\n','2018-04-30 17:29:33','2018-04-30 17:29:33'),(144,6,'cmd','cd /',NULL,NULL,42,'nothing','2018-04-30 17:35:14','2018-04-30 17:35:14'),(145,6,'cmd','ls',NULL,NULL,42,'bin\nboot\ndev\netc\nhome\ninitrd.img\ninitrd.img.old\nlib\nlib64\nlost+found\nmedia\nmnt\nopt\nproc\nroot\nrun\nsbin\nsnap\nsrv\nsys\ntmp\nusr\nvar\nvmlinuz\nvmlinuz.old\n','2018-04-30 17:35:17','2018-04-30 17:35:17'),(146,6,'connect',NULL,'2222222222222222','222222222222222222',43,'Authentication Successful!','2018-04-30 17:52:12','2018-04-30 17:52:12'),(147,6,'cmd','ls',NULL,NULL,43,'nothing','2018-04-30 17:52:17','2018-04-30 17:52:17'),(148,6,'cmd','pwd',NULL,NULL,43,'/root','2018-04-30 17:52:32','2018-04-30 17:52:32'),(149,6,'cmd','cd /var',NULL,NULL,43,'nothing','2018-04-30 17:52:38','2018-04-30 17:52:38'),(150,6,'cmd','ls',NULL,NULL,43,'backups\ncache\ncrash\nlib\nlocal\nlock\nlog\nmail\nopt\npuppet\nrun\nsnap\nspool\ntmp','2018-04-30 17:52:41','2018-04-30 17:52:41'),(151,6,'cmd','ls',NULL,NULL,43,'backups\ncache\ncrash\nlib\nlocal\nlock\nlog\nmail\nopt\npuppet\nrun\nsnap\nspool\ntmp','2018-04-30 17:54:16','2018-04-30 17:54:16'),(152,6,'connect',NULL,'aaaaaaaaaaaaaaaaaaaaa','awefaweffffffffffffffffffffffffffffffff',44,'Authentication Successful!','2018-04-30 17:55:22','2018-04-30 17:55:22'),(153,6,'cmd','ls',NULL,NULL,44,'nothing','2018-04-30 17:55:27','2018-04-30 17:55:27'),(154,6,'cmd','pwd',NULL,NULL,44,'/root','2018-04-30 17:55:32','2018-04-30 17:55:32'),(155,6,'cmd','blkid',NULL,NULL,44,'/dev/sda1: LABEL=\"cloudimg-rootfs\" UUID=\"5c615711-516f-4eb1-bca9-592288a14b59\" TYPE=\"ext4\" PARTUUID=\"55bca5c1-01\"','2018-04-30 17:55:42','2018-04-30 17:55:42'),(156,6,'cmd','ls',NULL,NULL,44,'nothing','2018-04-30 18:00:10','2018-04-30 18:00:10'),(157,6,'cmd','cd /var',NULL,NULL,44,'nothing','2018-04-30 18:00:24','2018-04-30 18:00:24'),(158,6,'cmd','ls',NULL,NULL,44,'backups\ncache\ncrash\nlib\nlocal\nlock\nlog\nmail\nopt\npuppet\nrun\nsnap\nspool\ntmp','2018-04-30 18:00:27','2018-04-30 18:00:27');
/*!40000 ALTER TABLE `cmds` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `migrations`
--

DROP TABLE IF EXISTS `migrations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `migrations` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `migrations`
--

LOCK TABLES `migrations` WRITE;
/*!40000 ALTER TABLE `migrations` DISABLE KEYS */;
INSERT INTO `migrations` VALUES (1,'2014_10_12_000000_create_users_table',1),(2,'2014_10_12_100000_create_password_resets_table',1);
/*!40000 ALTER TABLE `migrations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `password_resets`
--

DROP TABLE IF EXISTS `password_resets`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `password_resets` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  KEY `password_resets_email_index` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `password_resets`
--

LOCK TABLES `password_resets` WRITE;
/*!40000 ALTER TABLE `password_resets` DISABLE KEYS */;
/*!40000 ALTER TABLE `password_resets` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `servers`
--

DROP TABLE IF EXISTS `servers`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `servers` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) DEFAULT NULL,
  `description` varchar(500) DEFAULT NULL,
  `host` varchar(50) DEFAULT NULL,
  `password` varchar(50) DEFAULT NULL,
  `username` varchar(50) DEFAULT NULL,
  `current_path` longtext,
  `current_act_id` int(11) DEFAULT NULL,
  `session_log` longtext,
  `is_connected` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `servers`
--

LOCK TABLES `servers` WRITE;
/*!40000 ALTER TABLE `servers` DISABLE KEYS */;
INSERT INTO `servers` VALUES (6,'142.44.241.179',NULL,'142.44.241.179','lFopfb5Z','root','/var',44,'connecting...\nAuthentication Successful!\nroot@142.44.241.179&gt;ls\n\nroot@142.44.241.179&gt;pwd\n/root\nroot@142.44.241.179&gt;blkid\n/dev/sda1: LABEL=\"cloudimg-rootfs\" UUID=\"5c615711-516f-4eb1-bca9-592288a14b59\" TYPE=\"ext4\" PARTUUID=\"55bca5c1-01\"\nroot@142.44.241.179&gt;ls\n\nroot@142.44.241.179&gt;cd /var\n\nroot@142.44.241.179&gt;ls\nbackups\ncache\ncrash\nlib\nlocal\nlock\nlog\nmail\nopt\npuppet\nrun\nsnap\nspool\ntmp',1,'2018-04-29 03:41:33','2018-04-30 18:00:28'),(7,'server2',NULL,'88.208.216.161','SY3nxzx7N','root','/',41,'connecting...\nAuthentication Successful!\nls\ngo\nparallels\n\ncd /var\n\nls\nbackups\ncache\ndrweb\nlib\nlist\nlocal\nlock\nlog\nmail\nnamed\nopt\nparallels\nproftpd.delay\nqmail\nrun\nspool\ntmp\nwww\n\ncd ..\n\nls\nbin\nboot\ndev\netc\nhome\ninitrd.img\ninitrd.img.old\nlib\nlib32\nlib64\nlost+found\nmedia\nmnt\nopt\nproc\nroot\nrun\nsbin\nsrv\nsys\ntmp\nusr\nvar\nvmlinuz\nvmlinuz.old',1,'2018-04-30 15:27:34','2018-04-30 17:26:47');
/*!40000 ALTER TABLE `servers` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `users` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping routines for database 'ssher'
--
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2018-04-30  7:25:17
