-- MySQL dump 10.13  Distrib 5.7.23-23, for Linux (x86_64)
--
-- Host: localhost    Database: yousabte_orange
-- ------------------------------------------------------
-- Server version	5.7.23-23

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
/*!50717 SELECT COUNT(*) INTO @rocksdb_has_p_s_session_variables FROM INFORMATION_SCHEMA.TABLES WHERE TABLE_SCHEMA = 'performance_schema' AND TABLE_NAME = 'session_variables' */;
/*!50717 SET @rocksdb_get_is_supported = IF (@rocksdb_has_p_s_session_variables, 'SELECT COUNT(*) INTO @rocksdb_is_supported FROM performance_schema.session_variables WHERE VARIABLE_NAME=\'rocksdb_bulk_load\'', 'SELECT 0') */;
/*!50717 PREPARE s FROM @rocksdb_get_is_supported */;
/*!50717 EXECUTE s */;
/*!50717 DEALLOCATE PREPARE s */;
/*!50717 SET @rocksdb_enable_bulk_load = IF (@rocksdb_is_supported, 'SET SESSION rocksdb_bulk_load = 1', 'SET @rocksdb_dummy_bulk_load = 0') */;
/*!50717 PREPARE s FROM @rocksdb_enable_bulk_load */;
/*!50717 EXECUTE s */;
/*!50717 DEALLOCATE PREPARE s */;

--
-- Table structure for table `checkout`
--

DROP TABLE IF EXISTS `checkout`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `checkout` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `coustmer_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `coustmer_id` (`coustmer_id`),
  KEY `product_id` (`product_id`),
  CONSTRAINT `checkout_ibfk_1` FOREIGN KEY (`coustmer_id`) REFERENCES `creataccount` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `checkout_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `items` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `checkout`
--

LOCK TABLES `checkout` WRITE;
/*!40000 ALTER TABLE `checkout` DISABLE KEYS */;
INSERT INTO `checkout` VALUES (1,3,12),(2,3,11),(3,11,8),(4,11,7),(5,11,1),(6,11,3),(7,11,2),(8,11,1),(9,11,1),(10,11,2),(11,3,17),(12,3,17),(13,11,11),(14,1,2),(15,1,1),(16,1,4);
/*!40000 ALTER TABLE `checkout` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `contactus`
--

DROP TABLE IF EXISTS `contactus`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `contactus` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `coustmer_id` int(11) NOT NULL,
  `Comment` varchar(128) DEFAULT NULL,
  `User_Name` varchar(128) DEFAULT NULL,
  `Cell_Phone` varchar(128) DEFAULT NULL,
  `Email` varchar(128) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `coustmer_id` (`coustmer_id`),
  CONSTRAINT `contactus_ibfk_1` FOREIGN KEY (`coustmer_id`) REFERENCES `creataccount` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `contactus`
--

LOCK TABLES `contactus` WRITE;
/*!40000 ALTER TABLE `contactus` DISABLE KEYS */;
INSERT INTO `contactus` VALUES (1,1,'hi','boula nessim','01126785910','nessimboula@gmail.com'),(4,1,'nnnnn','Boula','011267859104','emad@gmail.com'),(5,1,'dqwdq','Boula','01126785910','nessimboula@gmail.com'),(6,1,'dqwdq','Boula','01126785910','nessimboula@gmail.com'),(7,3,'hi there','Boula','01126785910','emad@gmail.com'),(8,3,'bbbb','Boula','01126785910','nessimboula@gmail.com'),(9,3,'askj','Boula','01126785910','k.k.nashed@gmail'),(10,11,'You are a disgusting company','Boula','01126785910','boula.nessim.soliman@gmail.com'),(11,11,'Thank you','Boula','01126785910','nessimboula@gmail.com'),(12,11,'Thanks orange','Boula','01126785910','nessimboula@gmail.com'),(13,11,'Grat job','Boula','01126785910','nessimboula@gmail.com');
/*!40000 ALTER TABLE `contactus` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `creataccount`
--

DROP TABLE IF EXISTS `creataccount`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `creataccount` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `Confirm_Password` varchar(128) DEFAULT NULL,
  `Email` varchar(128) DEFAULT NULL,
  `First_Name` varchar(128) DEFAULT NULL,
  `Last_Name` varchar(128) DEFAULT NULL,
  `My_Password` varchar(128) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `Confirm_Password` (`Confirm_Password`),
  UNIQUE KEY `Email` (`Email`),
  UNIQUE KEY `My_Password` (`My_Password`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `creataccount`
--

LOCK TABLES `creataccount` WRITE;
/*!40000 ALTER TABLE `creataccount` DISABLE KEYS */;
INSERT INTO `creataccount` VALUES (1,'boula','nessimboula@gmail.com','Boula','Nessim','boula'),(3,'mmm','boula.nessim.soliman@gmail.com','Boula','Nessim','mmm'),(4,'','emad@gmail.com','','',''),(9,'nnn','emadnessim@gmail.com','emad','Nessim','nnn'),(10,'123','ahmed@gmail.com','Ahmed','Ali','123'),(11,'mora','mora@gmail.com','Mora','Kamal','mora'),(15,'mmmmm','nessimmm@gmail.com','nessim','soliman','mmmmm'),(16,'gemy','Gemian@gmail.com','Gemiana','Shawky','gemy');
/*!40000 ALTER TABLE `creataccount` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `items`
--

DROP TABLE IF EXISTS `items`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `items` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(128) DEFAULT NULL,
  `Price` varchar(128) DEFAULT NULL,
  `Price_disc` varchar(128) DEFAULT NULL,
  `types` varchar(50) NOT NULL,
  `description` varchar(250) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `items`
--

LOCK TABLES `items` WRITE;
/*!40000 ALTER TABLE `items` DISABLE KEYS */;
INSERT INTO `items` VALUES (1,'1.jpg','1000','800','mobile','Huawei-blue-128GB'),(2,'2.jpg','2000','1950','mobile','iPhone11-red-264GB'),(3,'3.jpg','10000','9500','mobile','Samsung-white-264GB'),(4,'4.jpg','1900','1000','mobile','Xiaomi-black-64GB'),(5,'5.jpg','1700','700','mobile','Huawei-purple-128GB'),(6,'6.jpg','12000','11000','mobile','Huawei-black-32GB'),(7,'11.jpg','200','190','accessory','airpods-white'),(8,'22.jpg','300','250','accessory','IceWatch-Black'),(9,'33.jpg','400','50','accessory','Charger-Black'),(10,'44.jpg','550','500','accessory','Powerbank-Black'),(11,'55.jpg','2000','110','accessory','Charger-white'),(12,'66.jpg','900','800','accessory','USB-green'),(15,'02.jpg','2000','1500','router','Home4G-black'),(16,'03.jpg','300','200','router','MIFI-black'),(17,'06.jpg','5000','500','router','Laptop-Lenovo-Gray');
/*!40000 ALTER TABLE `items` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `pruchaces`
--

DROP TABLE IF EXISTS `pruchaces`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `pruchaces` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `coustmer_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `coustmer_id` (`coustmer_id`),
  KEY `product_id` (`product_id`),
  CONSTRAINT `pruchaces_ibfk_1` FOREIGN KEY (`coustmer_id`) REFERENCES `creataccount` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `pruchaces_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `items` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=141 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `pruchaces`
--

LOCK TABLES `pruchaces` WRITE;
/*!40000 ALTER TABLE `pruchaces` DISABLE KEYS */;
INSERT INTO `pruchaces` VALUES (89,1,3),(91,1,5),(92,1,6),(113,9,1),(137,11,1),(138,16,1),(140,1,1);
/*!40000 ALTER TABLE `pruchaces` ENABLE KEYS */;
UNLOCK TABLES;
/*!50112 SET @disable_bulk_load = IF (@is_rocksdb_supported, 'SET SESSION rocksdb_bulk_load = @old_rocksdb_bulk_load', 'SET @dummy_rocksdb_bulk_load = 0') */;
/*!50112 PREPARE s FROM @disable_bulk_load */;
/*!50112 EXECUTE s */;
/*!50112 DEALLOCATE PREPARE s */;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2025-05-05  4:20:02
