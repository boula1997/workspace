-- MySQL dump 10.13  Distrib 5.7.23-23, for Linux (x86_64)
--
-- Host: localhost    Database: yousabte_lapmob
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
-- Table structure for table `addresses`
--

DROP TABLE IF EXISTS `addresses`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `addresses` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) unsigned DEFAULT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `fullName` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `phone` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `fullAddress` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `city` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `country` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `latitude` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `longitude` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `current` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `addresses_user_id_foreign` (`user_id`),
  CONSTRAINT `addresses_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=59 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `addresses`
--

LOCK TABLES `addresses` WRITE;
/*!40000 ALTER TABLE `addresses` DISABLE KEYS */;
INSERT INTO `addresses` (`id`, `user_id`, `title`, `fullName`, `phone`, `fullAddress`, `city`, `country`, `latitude`, `longitude`, `created_at`, `updated_at`, `current`) VALUES (1,2,'Boula','1126785910','Abuhashima','Giza','Ayat','Egypt','varchar','varchar',NULL,NULL,1),(3,1,'Home','Ahmad Al-Faisal','+966501234567','123 King Fahd Road, Olaya','Riyadh','Saudi Arabia','24.7136','46.6753','2025-02-16 16:22:57','2025-02-25 08:44:54',1),(4,1,'Home','Ahmad Al-Faisal','+966501234567','123 King Fahd Road, Olaya','Riyadh','Saudi Arabia','24.648712596278067','46.45969331054686','2025-02-16 16:23:03','2025-02-26 11:53:39',0),(10,11,'aa','qq','05091283111','ama','qq','aa','24.0081231','32.17823','2025-02-17 08:52:39','2025-02-18 19:32:44',0),(11,11,'qq','aa','599999991','aa','a','qq','24.0081231','32.17823','2025-02-17 09:29:57','2025-02-18 19:32:44',1),(12,1,'Work','Work','01127366548','Riyadh','Riyadh','Saudia','24.0081231','32.17823','2025-02-19 10:55:20','2025-02-25 08:44:54',0),(13,4,NULL,NULL,'(+1) 65558845',NULL,'0','1',NULL,NULL,'2025-02-19 21:12:53','2025-02-19 21:12:53',0),(14,20,'qq','aa','0101902381','aa','qdq','qdq','24.0081231','32.17823','2025-02-20 14:59:19','2025-02-27 13:05:34',0),(15,4,'Egypt',NULL,'+201065879463','Fifth settlement','1','0',NULL,NULL,'2025-02-20 15:35:09','2025-02-20 15:35:09',0),(16,20,'home1','qq','0123091821','asd','qwd','qwd','24.0081231','32.17823','2025-02-20 16:33:17','2025-02-27 13:05:34',1),(17,21,'Ipsam tempore sit',NULL,'+1 (789) 343-9325','Talon Dawson','1','2',NULL,NULL,'2025-02-20 19:45:41','2025-02-20 19:45:41',0),(19,25,'ggg',NULL,'(+1) 65558845','bbb','1','0',NULL,NULL,'2025-02-23 08:49:14','2025-02-23 08:49:14',1),(20,20,'aedq','aq','0101209381','qwdqd','qwd','qwdqwd','24.839619010507896','46.604549400508404','2025-02-23 15:51:44','2025-02-27 13:05:34',0),(21,20,'qqd','qwdq','01012391231','1cdas','v sd','sdvwd','24.81833610394187','46.642429903149605','2025-02-23 15:52:39','2025-02-27 13:05:34',0),(22,20,'qwdq','qwdq','010120381','123123','sdcsdc','dsv','24.821984435947144','46.64863854646683','2025-02-23 15:53:41','2025-02-27 13:05:34',0),(23,30,'aa','as','0102131311','qwdqw','qwdq','d','24.81833610394187','46.642429903149605','2025-02-23 16:25:16','2025-02-23 16:25:16',1),(24,31,'qq','qwdq','010102938','jugy','kugi','uyg','24.81833610394187','46.642429903149605','2025-02-23 16:31:47','2025-02-23 17:15:40',0),(25,31,'u','wef','01012312123','qwijd','wqdq','qwd','24.81833610394187','46.642429903149605','2025-02-23 17:15:34','2025-02-23 17:15:40',1),(26,32,'as','qwd','01091203821','opqkdqwd','qowidjqiowd','dwsvcw','24.81833610394187','46.642429903149605','2025-02-23 17:17:07','2025-02-23 17:19:47',0),(27,32,'mohamed','wefwe','01012038121','dsoicj','wrev','vrewrv','24.81833610394187','46.642429903149605','2025-02-23 17:19:44','2025-02-23 17:19:47',1),(28,33,'ابن اياس الكناني','mohamed mabrouk','503998427','ابن اياس الكناني - حي العليا','الرياض','السعوديه','24.70953463756323','46.67075637727976','2025-02-24 10:09:30','2025-02-24 10:09:30',1),(29,34,'مدينتي','محمد علي','01097981079','مدينتي','القاهرة','مصر','30.07722494177799','31.643357165157795','2025-02-24 10:12:14','2025-02-24 10:12:14',1),(30,35,'قس بن ساعدة','ا','0598058741','g','Riyadh','ksa','24.762594477600175','46.77456356585025','2025-02-24 11:07:32','2025-02-24 11:07:32',1),(35,26,'Old Work-02','Mohamed','01850607080','Sharm El-Shikh','Sharm El-Shikh','Egypt','27.963778736696533','34.36574935913086','2025-02-24 17:39:35','2025-03-24 16:43:25',0),(43,20,'ثخنخهصرهعصثردهعصثهدعرصثهعدرصث٩ردهصعثردعهصثردهعرصثدع٩رصثهدرصثهدرصثهدرصثهردهعصثردهعصثردهعصثردهعصثردهعصثردهعصثردهعرصثدرصثهدرصثهردهصر','ثخنخهصرهعصثردهعصثهدعرصثهعدرصث٩ردهصعثردعهصثردهعرصثدع٩رصثهدرصثهدرصثهدرصثهردهعصثردهعصثردهعصثردهعصثردهعصثردهعصثردهعرصثدرصثهدرصثهردهصر','0101098312903891283012843091849182309182081204813098491028218312083901283901283901820398129','ثخنخهصرهعصثردهعصثهدعرصثهعدرصث٩ردهصعثردعهصثردهعرصثدع٩رصثهدرصثهدرصثهدرصثهردهعصثردهعصثردهعصثردهعصثردهعصثردهعصثردهعرصثدرصثهدرصثهردهصر','ثخنخهصرهعصثردهعصثهدعرصثهعدرصث٩ردهصعثردعهصثردهعرصثدع٩رصثهدرصثهدرصثهدرصثهردهعصثردهعصثردهعصثردهعصثردهعصثردهعصثردهعرصثدرصثهدرصثهردهصر','ثخنخهصرهعصثردهعصثهدعرصثهعدرصث٩ردهصعثردعهصثردهعرصثدع٩رصثهدرصثهدرصثهدرصثهردهعصثردهعصثردهعصثردهعصثردهعصثردهعصثردهعرصثدرصثهدرصثهردهصر','24.81833610394187','46.642429903149605','2025-02-26 18:35:03','2025-02-27 13:05:34',0),(44,20,'oidsoicjso. ppl I','2','0102301231','cdmwowmdo e e Mel me','wdeww','wdcwe','24.81833610394187','46.642429903149605','2025-02-26 19:38:54','2025-02-27 13:05:34',0),(45,44,'Quia fugiat fugit','Samson Horn','0122456789','Ut quia et vitae dol','Dolorum Nam expedita','Aut totam et molliti','24.71284109009079','46.715755462646484','2025-02-27 10:39:13','2025-02-27 10:39:13',1),(46,20,'تصريض','ضصيض','966509580928','iowj','wde','ewd','24.81833610394187','46.642429903149605','2025-02-27 13:24:21','2025-02-27 13:24:21',0),(48,36,'I’m','I’m','000000000','I’m','I’m','I’m','27.1894073285767','31.179656870663162','2025-03-02 15:40:17','2025-03-02 15:40:27',1),(49,49,'home','Mohamed','00000000000','home','home','home','36.01706844594026','-5.585214123129845','2025-03-02 23:13:52','2025-03-02 23:13:52',1),(50,50,'Excepturi nisi optio','Iona Cox','0112547896','Id id dolore liber','Nemo beatae sit quam','Proident pariatur','24.66043433623631','46.73086166381836','2025-03-03 10:30:15','2025-03-03 10:30:15',1),(51,19,'gdgcvv','foggy','555555555','fgfygh','foggy','fghjk','37.45272823128002','-121.8901441991329','2025-03-05 09:30:49','2025-03-05 09:30:49',1),(52,59,'Assiut Assiut  Assiut Assiut Assiut Assiut Assiut Assiut Assiut Assiut Assiut Assiut  Assiut Assiut Assiut Assiut Assiut Assiut Assiut Assiut','Assiut Assiut  Assiut Assiut Assiut Assiut Assiut Assiut Assiut Assiut Assiut Assiut  Assiut Assiut Assiut Assiut Assiut Assiut Assiut Assiut','0587415256','Assiut Assiut  Assiut Assiut Assiut Assiut Assiut Assiut Assiut Assiut Assiut Assiut  Assiut Assiut Assiut Assiut Assiut Assiut Assiut Assiut','Assiut Assiut  Assiut Assiut Assiut Assiut Assiut Assiut Assiut Assiut Assiut Assiut  Assiut Assiut Assiut Assiut Assiut Assiut Assiut Assiut','Assiut Assiut  Assiut Assiut Assiut Assiut Assiut Assiut Assiut Assiut Assiut Assiut  Assiut Assiut Assiut Assiut Assiut Assiut Assiut Assiut','27.192622482666682','31.17065973579884','2025-03-05 12:47:10','2025-03-05 21:53:38',0),(53,59,'assiut','assiut','966552535444','assiut','assiut','assiut','27.18939301361237','31.179650835692883','2025-03-05 13:26:50','2025-03-05 21:53:38',1),(55,73,'Veniam qui non magn','Catherine Clayton','01123654789','Voluptates mollit qu','Quae est minim cons','Dolore aliquid velit','24.75649654167075','46.800899505615234','2025-03-24 11:23:16','2025-03-24 11:23:16',1),(56,26,'pyramids Gardens','mohamed','966558558555','$','$','$','29.97931698236305','31.098169349133972','2025-03-24 16:43:16','2025-03-24 16:43:25',1),(57,26,'old work-01','khalid','966558558055','egypt-alex-moharm bek','alex','egypt','29.97533352728794','31.096154674887657','2025-03-24 17:15:34','2025-03-24 17:15:34',0),(58,19,'AA','AA','966502976683','AA','AA','MASR','37.410185518091424','-122.08392206579445','2025-03-25 09:41:06','2025-03-25 09:41:06',0);
/*!40000 ALTER TABLE `addresses` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `admins`
--

DROP TABLE IF EXISTS `admins`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `admins` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `phone` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `type` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `admins_phone_unique` (`phone`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `admins`
--

LOCK TABLES `admins` WRITE;
/*!40000 ALTER TABLE `admins` DISABLE KEYS */;
INSERT INTO `admins` (`id`, `name`, `email`, `phone`, `type`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES (2,'MohamedHossny','MH2025@example.com','5896838088','admin',NULL,'$2y$10$ORyRtJmUVEhE9jBAtv2fauJ9jcj4iChd2naVRDAhDEp67rl2hKj7C',NULL,'2025-02-19 19:24:51','2025-03-15 14:31:32'),(5,'Super Admin','admin@gmail.com','01126785910','admin',NULL,'$2y$10$sCbUrTRgsRjvWIsHs1gpeuYA2jzU4XGZxv29O4Jfc8W1CrEUu1lh2',NULL,'2025-02-22 14:50:06','2025-02-22 14:50:06');
/*!40000 ALTER TABLE `admins` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `b_settings`
--

DROP TABLE IF EXISTS `b_settings`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `b_settings` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `b_settings`
--

LOCK TABLES `b_settings` WRITE;
/*!40000 ALTER TABLE `b_settings` DISABLE KEYS */;
/*!40000 ALTER TABLE `b_settings` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `banner_translations`
--

DROP TABLE IF EXISTS `banner_translations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `banner_translations` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `banner_id` bigint(20) unsigned NOT NULL,
  `locale` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `banner_translations_banner_id_locale_unique` (`banner_id`,`locale`),
  KEY `banner_translations_locale_index` (`locale`),
  CONSTRAINT `banner_translations_banner_id_foreign` FOREIGN KEY (`banner_id`) REFERENCES `banners` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `banner_translations`
--

LOCK TABLES `banner_translations` WRITE;
/*!40000 ALTER TABLE `banner_translations` DISABLE KEYS */;
/*!40000 ALTER TABLE `banner_translations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `banners`
--

DROP TABLE IF EXISTS `banners`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `banners` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `store_id` bigint(20) unsigned DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `category_id` bigint(20) unsigned DEFAULT NULL,
  `type` int(11) DEFAULT NULL COMMENT '1 => category, 2 => flash sale',
  PRIMARY KEY (`id`),
  KEY `banners_store_id_foreign` (`store_id`),
  KEY `banners_category_id_foreign` (`category_id`),
  CONSTRAINT `banners_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`),
  CONSTRAINT `banners_store_id_foreign` FOREIGN KEY (`store_id`) REFERENCES `stores` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `banners`
--

LOCK TABLES `banners` WRITE;
/*!40000 ALTER TABLE `banners` DISABLE KEYS */;
/*!40000 ALTER TABLE `banners` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `brand_translations`
--

DROP TABLE IF EXISTS `brand_translations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `brand_translations` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `brand_id` bigint(20) unsigned NOT NULL,
  `locale` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `brand_translations_brand_id_locale_unique` (`brand_id`,`locale`),
  KEY `brand_translations_locale_index` (`locale`),
  CONSTRAINT `brand_translations_brand_id_foreign` FOREIGN KEY (`brand_id`) REFERENCES `brands` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=43 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `brand_translations`
--

LOCK TABLES `brand_translations` WRITE;
/*!40000 ALTER TABLE `brand_translations` DISABLE KEYS */;
INSERT INTO `brand_translations` (`id`, `title`, `description`, `brand_id`, `locale`, `created_at`, `updated_at`) VALUES (1,'نايكي','علامة تجارية للأزياء الرياضية عالية الأداء.',1,'ar','2025-02-12 09:07:53','2025-02-12 09:07:53'),(2,'Nike','High-performance sportswear brand.',1,'en','2025-02-12 09:07:53','2025-02-12 09:07:53'),(3,'Nike','Marque de vêtements de sport haute performance.',1,'fr','2025-02-12 09:07:53','2025-02-12 09:07:53'),(4,'أديداس','رائد عالمي في الملابس الرياضية.',2,'ar','2025-02-12 09:07:53','2025-02-12 09:07:53'),(5,'Adidas','Global leader in athletic apparel.',2,'en','2025-02-12 09:07:53','2025-02-12 09:07:53'),(6,'Adidas','Leader mondial des vêtements de sport.',2,'fr','2025-02-12 09:07:53','2025-02-12 09:07:53'),(7,'زارا','متجر أزياء عصري لكل المواسم.',3,'ar','2025-02-12 09:07:53','2025-02-12 09:07:53'),(8,'Zara','Trendy fashion retailer for all seasons.',3,'en','2025-02-12 09:07:53','2025-02-12 09:07:53'),(9,'Zara','Boutique de mode tendance pour toutes les saisons.',3,'fr','2025-02-12 09:07:53','2025-02-12 09:07:53'),(10,'إتش آند إم','ملابس عصرية بأسعار معقولة.',4,'ar','2025-02-12 09:07:53','2025-02-12 09:07:53'),(11,'H&M','Affordable and stylish casual wear.',4,'en','2025-02-12 09:07:53','2025-02-12 09:07:53'),(12,'H&M','Vêtements décontractés abordables et élégants.',4,'fr','2025-02-12 09:07:53','2025-02-12 09:07:53'),(13,'غوتشي','علامة فاخرة بجودة حرفية إيطالية.',5,'ar','2025-02-12 09:07:53','2025-02-12 09:07:53'),(14,'Gucci','Luxury brand with Italian craftsmanship.',5,'en','2025-02-12 09:07:53','2025-02-12 09:07:53'),(15,'Gucci','Marque de luxe avec un savoir-faire italien.',5,'fr','2025-02-12 09:07:53','2025-02-12 09:07:53'),(16,'لويس فيتون','دار أزياء فرنسية فاخرة ومميزة.',6,'ar','2025-02-12 09:07:53','2025-02-12 09:07:53'),(17,'Louis Vuitton','Iconic French luxury fashion house.',6,'en','2025-02-12 09:07:53','2025-02-12 09:07:53'),(18,'Louis Vuitton','Maison de mode française emblématique.',6,'fr','2025-02-12 09:07:53','2025-02-12 09:07:53'),(19,'برادا','أزياء أنيقة وراقية.',7,'ar','2025-02-12 09:07:53','2025-02-12 09:07:53'),(20,'Prada','Elegant and high-end fashion.',7,'en','2025-02-12 09:07:53','2025-02-12 09:07:53'),(21,'Prada','Mode élégante et haut de gamme.',7,'fr','2025-02-12 09:07:53','2025-02-12 09:07:53'),(22,'شانيل','علامة تجارية فاخرة ذات جذور فرنسية.',8,'ar','2025-02-12 09:07:53','2025-02-12 09:07:53'),(23,'Chanel','Timeless luxury brand with French roots.',8,'en','2025-02-12 09:07:53','2025-02-12 09:07:53'),(24,'Chanel','Marque de luxe intemporelle d\'origine française.',8,'fr','2025-02-12 09:07:53','2025-02-12 09:07:53'),(25,'فيرساتشي','تصاميم جريئة لعشاق الموضة المعاصرة.',9,'ar','2025-02-12 09:07:53','2025-02-12 09:07:53'),(26,'Versace','Bold designs for contemporary fashion lovers.',9,'en','2025-02-12 09:07:53','2025-02-12 09:07:53'),(27,'Versace','Designs audacieux pour les amateurs de mode contemporaine.',9,'fr','2025-02-12 09:07:53','2025-02-12 09:07:53'),(28,'ليفايز','ماركة كلاسيكية للجينز والملابس الكاجوال.',10,'ar','2025-02-12 09:07:53','2025-02-12 09:07:53'),(29,'Levi\'s','Classic denim and casual wear brand.',10,'en','2025-02-12 09:07:53','2025-02-12 09:07:53'),(30,'Levi\'s','Marque classique de denim et de vêtements décontractés.',10,'fr','2025-02-12 09:07:53','2025-02-12 09:07:53'),(34,'Atlas','First Brand to Test',12,'en','2025-02-18 21:54:08','2025-02-22 19:33:15'),(35,'أطلسي','First Brand to Test',12,'ar','2025-02-18 21:54:08','2025-02-22 19:33:15'),(36,'Greek','First Brand to Test',12,'fr','2025-02-18 21:54:08','2025-02-22 19:33:15'),(40,'ADC','<span style=\"color: rgb(0, 0, 0); font-family: Arial, Tahoma, Helvetica, sans-serif; letter-spacing: normal;\">Aloodot.com est une plate-forme mondiale de commerce électronique saoudien révolutionnant la mode rapide. Nous proposons des vêtements à la mode, des accessoires et les derniers styles à des prix abordables. Achetez en ligne et profitez de l\'expédition mondiale</span>',14,'en','2025-03-09 15:46:32','2025-03-09 15:46:32'),(41,'أي دي سي','هي منصة سعودية عالمية للتجارة الإلكترونية تُحدث ثورة في عالم الموضة السريعة. نقدم لكم أزياء عصرية، وإكسسوارات، وآخر صيحات الموضة بأسعار مناسبة للجميع. تسوق عبر الإنترنت واستمتع بخدمة الشحن إلى جميع أنحاء العالم.',14,'ar','2025-03-09 15:46:32','2025-03-09 15:46:32'),(42,'ADC','<span style=\"color: rgb(0, 0, 0); font-family: Arial, Tahoma, Helvetica, sans-serif; letter-spacing: normal;\">Aloodot.com est une plate-forme mondiale de commerce électronique saoudien révolutionnant la mode rapide. Nous proposons des vêtements à la mode, des accessoires et les derniers styles à des prix abordables. Achetez en ligne et profitez de l\'expédition mondiale</span>',14,'fr','2025-03-09 15:46:32','2025-03-09 15:46:32');
/*!40000 ALTER TABLE `brand_translations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `brands`
--

DROP TABLE IF EXISTS `brands`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `brands` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `sort` int(11) NOT NULL DEFAULT '0',
  `isTop` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `brands`
--

LOCK TABLES `brands` WRITE;
/*!40000 ALTER TABLE `brands` DISABLE KEYS */;
INSERT INTO `brands` (`id`, `created_at`, `updated_at`, `sort`, `isTop`) VALUES (1,'2025-02-12 09:07:53','2025-03-09 22:16:44',0,0),(2,'2025-02-12 09:07:53','2025-03-09 22:16:43',0,0),(3,'2025-02-12 09:07:53','2025-03-09 22:16:42',0,0),(4,'2025-02-12 09:07:53','2025-02-27 00:59:00',0,0),(5,'2025-02-12 09:07:53','2025-02-27 00:59:01',0,0),(6,'2025-02-12 09:07:53','2025-02-27 00:58:37',0,0),(7,'2025-02-12 09:07:53','2025-02-24 19:29:17',0,0),(8,'2025-02-12 09:07:53','2025-02-27 00:47:08',0,0),(9,'2025-02-12 09:07:53','2025-02-24 19:30:39',0,0),(10,'2025-02-12 09:07:53','2025-02-27 00:47:10',0,0),(12,'2025-02-18 21:54:08','2025-02-22 19:33:15',0,0),(14,'2025-03-09 15:46:32','2025-03-09 15:46:32',0,0);
/*!40000 ALTER TABLE `brands` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `categories`
--

DROP TABLE IF EXISTS `categories`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `categories` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `type` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'shop, featuredOccasions, service',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `categories`
--

LOCK TABLES `categories` WRITE;
/*!40000 ALTER TABLE `categories` DISABLE KEYS */;
INSERT INTO `categories` (`id`, `created_at`, `updated_at`, `type`) VALUES (1,'2025-03-30 20:22:13','2025-03-30 20:22:13','featuredOccasions'),(2,'2025-03-30 20:22:13','2025-03-30 20:22:13','featuredOccasions');
/*!40000 ALTER TABLE `categories` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `category_translations`
--

DROP TABLE IF EXISTS `category_translations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `category_translations` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `category_id` bigint(20) unsigned NOT NULL,
  `locale` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `category_translations_category_id_locale_unique` (`category_id`,`locale`),
  KEY `category_translations_locale_index` (`locale`),
  CONSTRAINT `category_translations_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=62 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `category_translations`
--

LOCK TABLES `category_translations` WRITE;
/*!40000 ALTER TABLE `category_translations` DISABLE KEYS */;
INSERT INTO `category_translations` (`id`, `title`, `category_id`, `locale`, `created_at`, `updated_at`) VALUES (56,'لابات',1,'ar','2025-03-30 20:22:13','2025-09-16 20:13:44'),(57,'Labtops',1,'en','2025-03-30 20:22:13','2025-09-16 20:13:44'),(58,'Saint-Valentin',1,'fr','2025-03-30 20:22:13','2025-03-30 20:22:13'),(59,'موبيلات',2,'ar','2025-03-30 20:22:13','2025-09-16 20:15:02'),(60,'Mobiles',2,'en','2025-03-30 20:22:13','2025-09-16 20:15:02'),(61,'Fête des Mères',2,'fr','2025-03-30 20:22:13','2025-03-30 20:22:13');
/*!40000 ALTER TABLE `category_translations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `chooseUs_translations`
--

DROP TABLE IF EXISTS `chooseUs_translations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `chooseUs_translations` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `choose_us_id` bigint(20) unsigned NOT NULL,
  `locale` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `chooseus_translations_choose_us_id_locale_unique` (`choose_us_id`,`locale`),
  KEY `chooseus_translations_locale_index` (`locale`),
  CONSTRAINT `chooseus_translations_choose_us_id_foreign` FOREIGN KEY (`choose_us_id`) REFERENCES `chooseUss` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `chooseUs_translations`
--

LOCK TABLES `chooseUs_translations` WRITE;
/*!40000 ALTER TABLE `chooseUs_translations` DISABLE KEYS */;
INSERT INTO `chooseUs_translations` (`id`, `title`, `description`, `choose_us_id`, `locale`, `created_at`, `updated_at`) VALUES (1,'تصاميم أنيقة ومبتكرة','ديكورات مذهلة وترتيبات زهور مصممة على ذوقك.',1,'ar','2025-04-09 19:51:50','2025-04-09 19:51:50'),(2,'Elegant & Creative Designs','Stunning décor & floral arrangements tailored to your style.',1,'en','2025-04-09 19:51:50','2025-04-09 19:51:50'),(3,'Des designs élégants et créatifs','Une décoration et des arrangements floraux époustouflants adaptés à votre style.',1,'fr','2025-04-09 19:51:50','2025-04-09 19:51:50'),(4,'تخطيط سلس','كل التفاصيل يتم التعامل معها بدقة للحصول على تجربة مثالية.',2,'ar','2025-04-09 19:51:50','2025-04-09 19:51:50'),(5,'Seamless Planning','Every detail handled with precision for a flawless experience.',2,'en','2025-04-09 19:51:50','2025-04-09 19:51:50'),(6,'Planification sans faille','Chaque détail est géré avec précision pour une expérience parfaite.',2,'fr','2025-04-09 19:51:50','2025-04-09 19:51:50'),(7,'لمسة شخصية','رؤيتك وخبرتنا - مصممة خصيصًا لك.',3,'ar','2025-04-09 19:51:50','2025-04-09 19:51:50'),(8,'Personalized Touch','Your vision, our expertise—crafted just for you.',3,'en','2025-04-09 19:51:50','2025-04-09 19:51:50'),(9,'Une touche personnalisée','Votre vision, notre expertise – conçue juste pour vous.',3,'fr','2025-04-09 19:51:50','2025-04-09 19:51:50'),(10,'تنفيذ بدون توتر','استرخِ واستمتع بينما نحول رؤيتك إلى واقع.',4,'ar','2025-04-09 19:51:50','2025-04-09 19:51:50'),(11,'Stress-Free Execution','Relax & enjoy while we bring your event to life.',4,'en','2025-04-09 19:51:50','2025-04-09 19:51:50'),(12,'Exécution sans stress','Détendez-vous pendant que nous donnons vie à votre événement.',4,'fr','2025-04-09 19:51:50','2025-04-09 19:51:50'),(13,'ذكريات خالدة','مع فيوري فلاور، كل لحظة تصبح ذكرى لا تُنسى!',5,'ar','2025-04-09 19:51:50','2025-04-09 19:51:50'),(14,'Cherished Memories','With Fiori Flower, every moment becomes a cherished memory!',5,'en','2025-04-09 19:51:50','2025-04-09 19:51:50'),(15,'Souvenirs inoubliables','Avec Fiori Flower, chaque moment devient un souvenir précieux !',5,'fr','2025-04-09 19:51:50','2025-04-09 19:51:50');
/*!40000 ALTER TABLE `chooseUs_translations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `chooseUss`
--

DROP TABLE IF EXISTS `chooseUss`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `chooseUss` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `emoji` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `chooseUss`
--

LOCK TABLES `chooseUss` WRITE;
/*!40000 ALTER TABLE `chooseUss` DISABLE KEYS */;
INSERT INTO `chooseUss` (`id`, `emoji`, `created_at`, `updated_at`) VALUES (1,'?','2025-04-09 19:51:50','2025-04-09 19:51:50'),(2,'?️','2025-04-09 19:51:50','2025-04-09 19:51:50'),(3,'?','2025-04-09 19:51:50','2025-04-09 19:51:50'),(4,'?‍♀️','2025-04-09 19:51:50','2025-04-09 19:51:50'),(5,'?','2025-04-09 19:51:50','2025-04-09 19:51:50');
/*!40000 ALTER TABLE `chooseUss` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `color_translations`
--

DROP TABLE IF EXISTS `color_translations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `color_translations` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `subtitle` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `color_id` bigint(20) unsigned NOT NULL,
  `locale` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `color_translations_color_id_locale_unique` (`color_id`,`locale`),
  KEY `color_translations_locale_index` (`locale`),
  CONSTRAINT `color_translations_color_id_foreign` FOREIGN KEY (`color_id`) REFERENCES `colors` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=58 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `color_translations`
--

LOCK TABLES `color_translations` WRITE;
/*!40000 ALTER TABLE `color_translations` DISABLE KEYS */;
INSERT INTO `color_translations` (`id`, `title`, `subtitle`, `description`, `color_id`, `locale`, `created_at`, `updated_at`) VALUES (1,'أحمر',NULL,NULL,1,'ar','2025-02-12 09:07:53','2025-02-12 09:07:53'),(2,'Red',NULL,NULL,1,'en','2025-02-12 09:07:53','2025-02-12 09:07:53'),(3,'Rouge',NULL,NULL,1,'fr','2025-02-12 09:07:53','2025-02-12 09:07:53'),(4,'أزرق',NULL,NULL,2,'ar','2025-02-12 09:07:53','2025-02-12 09:07:53'),(5,'Blue',NULL,NULL,2,'en','2025-02-12 09:07:53','2025-02-12 09:07:53'),(6,'Bleu',NULL,NULL,2,'fr','2025-02-12 09:07:53','2025-02-12 09:07:53'),(7,'أخضر',NULL,NULL,3,'ar','2025-02-12 09:07:53','2025-02-12 09:07:53'),(8,'Green',NULL,NULL,3,'en','2025-02-12 09:07:53','2025-02-12 09:07:53'),(9,'Vert',NULL,NULL,3,'fr','2025-02-12 09:07:53','2025-02-12 09:07:53'),(10,'أصفر',NULL,NULL,4,'ar','2025-02-12 09:07:53','2025-02-12 09:07:53'),(11,'Yellow',NULL,NULL,4,'en','2025-02-12 09:07:53','2025-02-12 09:07:53'),(12,'Jaune',NULL,NULL,4,'fr','2025-02-12 09:07:53','2025-02-12 09:07:53'),(13,'أسود',NULL,NULL,5,'ar','2025-02-12 09:07:53','2025-02-12 09:07:53'),(14,'Black',NULL,NULL,5,'en','2025-02-12 09:07:53','2025-02-12 09:07:53'),(15,'Noir',NULL,NULL,5,'fr','2025-02-12 09:07:53','2025-02-12 09:07:53'),(16,'أبيض',NULL,NULL,6,'ar','2025-02-12 09:07:53','2025-02-12 09:07:53'),(17,'White',NULL,NULL,6,'en','2025-02-12 09:07:53','2025-02-12 09:07:53'),(18,'Blanc',NULL,NULL,6,'fr','2025-02-12 09:07:53','2025-02-12 09:07:53'),(19,'أرجواني',NULL,NULL,7,'ar','2025-02-12 09:07:53','2025-02-12 09:07:53'),(20,'Purple',NULL,NULL,7,'en','2025-02-12 09:07:53','2025-02-12 09:07:53'),(21,'Violet',NULL,NULL,7,'fr','2025-02-12 09:07:53','2025-02-12 09:07:53'),(22,'برتقالي',NULL,NULL,8,'ar','2025-02-12 09:07:53','2025-02-12 09:07:53'),(23,'Orange',NULL,NULL,8,'en','2025-02-12 09:07:53','2025-02-12 09:07:53'),(24,'Orange',NULL,NULL,8,'fr','2025-02-12 09:07:53','2025-02-12 09:07:53'),(25,'وردي',NULL,NULL,9,'ar','2025-02-12 09:07:53','2025-02-12 09:07:53'),(26,'Pink',NULL,NULL,9,'en','2025-02-12 09:07:53','2025-02-12 09:07:53'),(27,'Rose',NULL,NULL,9,'fr','2025-02-12 09:07:53','2025-02-12 09:07:53'),(28,'رمادي',NULL,NULL,10,'ar','2025-02-12 09:07:53','2025-02-12 09:07:53'),(29,'Gray',NULL,NULL,10,'en','2025-02-12 09:07:53','2025-02-12 09:07:53'),(30,'Gris',NULL,NULL,10,'fr','2025-02-12 09:07:53','2025-02-12 09:07:53'),(31,'Green',NULL,NULL,11,'en','2025-02-18 22:21:52','2025-02-18 22:21:52'),(32,'أخضر',NULL,NULL,11,'ar','2025-02-18 22:21:52','2025-02-18 22:21:52'),(33,'French',NULL,NULL,11,'fr','2025-02-18 22:21:52','2025-02-18 22:21:52'),(34,'Black',NULL,NULL,12,'en','2025-02-18 22:22:14','2025-02-18 22:22:14'),(35,'أسود',NULL,NULL,12,'ar','2025-02-18 22:22:14','2025-02-18 22:22:14'),(36,'French',NULL,NULL,12,'fr','2025-02-18 22:22:14','2025-02-18 22:22:14'),(37,'Gray',NULL,NULL,13,'en','2025-02-18 22:23:00','2025-02-22 18:10:02'),(38,'رمادي1',NULL,NULL,13,'ar','2025-02-18 22:23:00','2025-02-20 13:46:42'),(39,'1French',NULL,NULL,13,'fr','2025-02-18 22:23:00','2025-02-20 13:46:42'),(40,'Yellow',NULL,NULL,14,'en','2025-02-22 18:12:14','2025-02-22 18:13:31'),(41,'أصفر',NULL,NULL,14,'ar','2025-02-22 18:12:14','2025-02-22 18:13:31'),(42,'Yellow',NULL,NULL,14,'fr','2025-02-22 18:12:14','2025-02-22 18:13:31'),(43,'Blue',NULL,NULL,15,'en','2025-02-22 18:12:52','2025-02-22 18:14:00'),(44,'أزرق',NULL,NULL,15,'ar','2025-02-22 18:12:52','2025-02-22 18:14:00'),(45,'Blue',NULL,NULL,15,'fr','2025-02-22 18:12:52','2025-02-22 18:14:00'),(46,'White',NULL,NULL,16,'en','2025-02-22 18:14:44','2025-02-22 18:14:44'),(47,'ابيض',NULL,NULL,16,'ar','2025-02-22 18:14:44','2025-02-22 18:14:44'),(48,'White',NULL,NULL,16,'fr','2025-02-22 18:14:44','2025-02-22 18:14:44'),(49,'Purple',NULL,NULL,17,'en','2025-02-22 18:15:02','2025-02-22 18:15:02'),(50,'بنفسجي',NULL,NULL,17,'ar','2025-02-22 18:15:02','2025-02-22 18:15:02'),(51,'Purple',NULL,NULL,17,'fr','2025-02-22 18:15:02','2025-02-22 18:15:02'),(52,'Pink',NULL,NULL,18,'en','2025-02-22 18:15:58','2025-02-22 18:15:58'),(53,'بمبي',NULL,NULL,18,'ar','2025-02-22 18:15:58','2025-02-22 18:15:58'),(54,'Pink',NULL,NULL,18,'fr','2025-02-22 18:15:58','2025-02-22 18:15:58'),(55,'Red',NULL,NULL,19,'en','2025-02-23 13:36:35','2025-02-23 13:36:35'),(56,'أحمر',NULL,NULL,19,'ar','2025-02-23 13:36:35','2025-02-23 13:36:35'),(57,'Red',NULL,NULL,19,'fr','2025-02-23 13:36:35','2025-02-23 13:36:35');
/*!40000 ALTER TABLE `color_translations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `colors`
--

DROP TABLE IF EXISTS `colors`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `colors` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `store_id` bigint(20) unsigned DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `hexCode` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '#000',
  PRIMARY KEY (`id`),
  KEY `colors_store_id_foreign` (`store_id`),
  CONSTRAINT `colors_store_id_foreign` FOREIGN KEY (`store_id`) REFERENCES `stores` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=20 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `colors`
--

LOCK TABLES `colors` WRITE;
/*!40000 ALTER TABLE `colors` DISABLE KEYS */;
INSERT INTO `colors` (`id`, `store_id`, `created_at`, `updated_at`, `hexCode`) VALUES (1,9,'2025-02-12 09:07:53','2025-02-12 09:07:53','#000'),(2,6,'2025-02-12 09:07:53','2025-02-12 09:07:53','#000'),(3,8,'2025-02-12 09:07:53','2025-02-12 09:07:53','#000'),(4,10,'2025-02-12 09:07:53','2025-02-12 09:07:53','#000'),(5,10,'2025-02-12 09:07:53','2025-02-12 09:07:53','#000'),(6,1,'2025-02-12 09:07:53','2025-02-12 09:07:53','#000'),(7,7,'2025-02-12 09:07:53','2025-02-12 09:07:53','#000'),(8,5,'2025-02-12 09:07:53','2025-02-12 09:07:53','#000'),(9,4,'2025-02-12 09:07:53','2025-02-12 09:07:53','#000'),(10,7,'2025-02-12 09:07:53','2025-02-12 09:07:53','#000'),(11,7,'2025-02-18 22:21:52','2025-03-12 11:17:30','#000000'),(12,7,'2025-02-18 22:22:14','2025-03-12 11:17:39','#000000'),(13,11,'2025-02-18 22:23:00','2025-02-18 22:23:00','#000'),(14,11,'2025-02-22 18:12:14','2025-02-22 18:12:14','#000'),(15,7,'2025-02-22 18:12:52','2025-03-12 11:17:47','#000000'),(16,11,'2025-02-22 18:14:44','2025-02-22 18:14:44','#000'),(17,11,'2025-02-22 18:15:02','2025-02-22 18:15:02','#000'),(18,7,'2025-02-22 18:15:58','2025-03-12 11:17:58','#000000'),(19,11,'2025-02-23 13:36:35','2025-02-23 13:36:35','#000');
/*!40000 ALTER TABLE `colors` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `contacts`
--

DROP TABLE IF EXISTS `contacts`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `contacts` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `contact` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `icon` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `type` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `contacts`
--

LOCK TABLES `contacts` WRITE;
/*!40000 ALTER TABLE `contacts` DISABLE KEYS */;
INSERT INTO `contacts` (`id`, `contact`, `icon`, `type`, `created_at`, `updated_at`) VALUES (1,'+201070718676','fas fa-phone','phone','2025-04-01 15:09:43','2025-04-01 15:09:43'),(2,'+201070718676','fab fa-whatsapp','whatsapp','2025-04-01 15:09:43','2025-04-01 15:09:43'),(3,'https://www.facebook.com/fiori.flower2','fab fa-facebook','social','2025-04-16 22:42:16','2025-04-16 22:42:29'),(4,'https://www.instagram.com/fioriflower_eg?fbclid=IwY2xjawJtrStleHRuA2FlbQIxMAABHu8e2cLVECcsEigS-fJQqSFGmaLa6uOuD5MLdV0jHQWPsVlzZHsNHUsqgKQM_aem_pTu6s98xLtvHFSaRA-4dug','fab fa-instagram','social','2025-04-16 22:42:22','2025-04-16 22:42:34');
/*!40000 ALTER TABLE `contacts` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `failed_jobs`
--

DROP TABLE IF EXISTS `failed_jobs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `failed_jobs` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `failed_jobs`
--

LOCK TABLES `failed_jobs` WRITE;
/*!40000 ALTER TABLE `failed_jobs` DISABLE KEYS */;
/*!40000 ALTER TABLE `failed_jobs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `faq_translations`
--

DROP TABLE IF EXISTS `faq_translations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `faq_translations` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `subtitle` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `faq_id` bigint(20) unsigned NOT NULL,
  `locale` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `faq_translations_faq_id_locale_unique` (`faq_id`,`locale`),
  KEY `faq_translations_locale_index` (`locale`),
  CONSTRAINT `faq_translations_faq_id_foreign` FOREIGN KEY (`faq_id`) REFERENCES `faqs` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `faq_translations`
--

LOCK TABLES `faq_translations` WRITE;
/*!40000 ALTER TABLE `faq_translations` DISABLE KEYS */;
INSERT INTO `faq_translations` (`id`, `title`, `subtitle`, `description`, `faq_id`, `locale`, `created_at`, `updated_at`) VALUES (1,'كيف يمكنك التأكد من سلامة البضائع المنقولة؟',NULL,'<p>السلامة هي أولويتنا. نحن نستخدم أحدث المعدات والموظفين المدربين ونقوم بإجراء فحوصات صارمة للجودة لضمان النقل الآمن للبضائع.</p>',1,'ar','2025-02-12 09:07:54','2025-02-12 09:07:54'),(2,'How do you ensure the safety of transported goods?',NULL,'<p>Safety is our priority. We employ state-of-the-art equipment, trained personnel, and rigorous quality checks to ensure the secure transportation of goods.</p>',1,'en','2025-02-12 09:07:54','2025-02-12 09:07:54'),(3,'ما حجم الأحمال التي يمكن أن تستوعبها شاحناتك؟',NULL,'<p>أسطولنا مجهز للتعامل مع مجموعة متنوعة من أحجام التحميل. بدءًا من حمولات الشاحنات الجزئية إلى الكاملة، نقوم بتصميم خدماتنا لتلائم احتياجات الشحن المحددة الخاصة بك.</p>',2,'ar','2025-02-12 09:07:54','2025-02-12 09:07:54'),(4,'What size of loads can your trucks accommodate?',NULL,'<p>Our fleet is equipped to handle a variety of load sizes. From partial to full truckloads, we tailor our services to accommodate your specific cargo needs.</p>',2,'en','2025-02-12 09:07:54','2025-02-12 09:07:54'),(5,'كيف يمكنني متابعة تقدم شحنتي؟',NULL,'<p>نحن نقدم حلول تتبع في الوقت الفعلي، مما يتيح لك مراقبة تقدم شحنتك في كل خطوة على الطريق. فريقنا متاح أيضًا لأية تحديثات أو استفسارات.</p>',3,'ar','2025-02-12 09:07:54','2025-02-12 09:07:54'),(6,'How can I track my shipment\'s progress?',NULL,'<p>We offer real-time tracking solutions, enabling you to monitor your shipment\'s progress every step of the way. Our team is also available for any updates or queries.</p>',3,'en','2025-02-12 09:07:54','2025-02-12 09:07:54');
/*!40000 ALTER TABLE `faq_translations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `faqs`
--

DROP TABLE IF EXISTS `faqs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `faqs` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `faqs`
--

LOCK TABLES `faqs` WRITE;
/*!40000 ALTER TABLE `faqs` DISABLE KEYS */;
INSERT INTO `faqs` (`id`, `created_at`, `updated_at`) VALUES (1,'2025-02-12 09:07:54','2025-02-12 09:07:54'),(2,'2025-02-12 09:07:54','2025-02-12 09:07:54'),(3,'2025-02-12 09:07:54','2025-02-12 09:07:54');
/*!40000 ALTER TABLE `faqs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `favorites`
--

DROP TABLE IF EXISTS `favorites`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `favorites` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `product_id` bigint(20) unsigned DEFAULT NULL,
  `user_id` bigint(20) unsigned DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `favorites_product_id_foreign` (`product_id`),
  KEY `favorites_user_id_foreign` (`user_id`),
  CONSTRAINT `favorites_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE,
  CONSTRAINT `favorites_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=77 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `favorites`
--

LOCK TABLES `favorites` WRITE;
/*!40000 ALTER TABLE `favorites` DISABLE KEYS */;
INSERT INTO `favorites` (`id`, `product_id`, `user_id`, `created_at`, `updated_at`) VALUES (65,47,19,NULL,NULL),(72,47,26,NULL,NULL),(74,55,19,NULL,NULL),(75,44,26,NULL,NULL),(76,48,26,NULL,NULL);
/*!40000 ALTER TABLE `favorites` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `files`
--

DROP TABLE IF EXISTS `files`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `files` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `url` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `fileable_id` int(11) NOT NULL,
  `fileable_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=635 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `files`
--

LOCK TABLES `files` WRITE;
/*!40000 ALTER TABLE `files` DISABLE KEYS */;
INSERT INTO `files` (`id`, `url`, `fileable_id`, `fileable_type`, `created_at`, `updated_at`) VALUES (371,'images/qzGstNJ36SIQ8qUWS7oHYfMS9JP6SIuSv5wzm3tj.jpg',1,'App\\Models\\Service','2025-04-16 21:39:51','2025-04-16 21:39:51'),(372,'images/MBWduikwuym3ULWYDNPL2OuEXfkcyi2d2oioZZxy.jpg',1,'App\\Models\\Service','2025-04-16 21:39:51','2025-04-16 21:39:51'),(373,'images/m3QDLcCvYD2bC3CpIstovPvBPQWAVgSI6kKh6kas.jpg',1,'App\\Models\\Service','2025-04-16 21:39:51','2025-04-16 21:39:51'),(374,'images/T7BoBgxOBUQrcrpa7BJ1XaSdGOuMRrZdtJlbSg01.jpg',1,'App\\Models\\Service','2025-04-16 21:39:51','2025-04-16 21:39:51'),(375,'images/6b6HMnJK9Q8HJGoYL0DKlWVmi3b0wLNfyN6r7FDJ.jpg',1,'App\\Models\\Service','2025-04-16 21:39:51','2025-04-16 21:39:51'),(376,'images/rlYsFllkk9vGw7fbT5isLbfMz3HloGHgby9bmEZT.jpg',1,'App\\Models\\Service','2025-04-16 21:39:51','2025-04-16 21:39:51'),(377,'images/JHhglHGw4jC1QRIxQH6Ep9Pqax7hVinY0iGyZj18.jpg',2,'App\\Models\\Service','2025-04-16 21:44:06','2025-04-16 21:44:06'),(378,'images/uH40OkAqVoy9i9TnPepfvHr5VmvG0S0YSiK2QhAM.jpg',2,'App\\Models\\Service','2025-04-16 21:44:06','2025-04-16 21:44:06'),(379,'images/guq9TZJvHHbpaNbYb0VQV4xA6XENomw5FVlefZb9.jpg',2,'App\\Models\\Service','2025-04-16 21:44:06','2025-04-16 21:44:06'),(380,'images/FrNNZzrLonqWk5mHAA48ixlciEFuI5tuRRdqdiDH.jpg',2,'App\\Models\\Service','2025-04-16 21:44:06','2025-04-16 21:44:06'),(381,'images/DwweU070bRDGgSwX6oF6j1f7d0NcHeS8S5TwAbRm.jpg',2,'App\\Models\\Service','2025-04-16 21:44:06','2025-04-16 21:44:06'),(382,'images/Rpa8kyLJSdwwHBD53lAXnL2EINzXOKbcHJoMeDuT.jpg',2,'App\\Models\\Service','2025-04-16 21:44:06','2025-04-16 21:44:06'),(383,'images/nG7VIT4O4MYJe3G1LkT70KKCfhDk4xmkHafHDB2h.jpg',3,'App\\Models\\Service','2025-04-16 21:46:45','2025-04-16 21:46:45'),(384,'images/N7KHTG8P9GLrJfxGPttyTPmpguSdzCwzrKGBuU4Y.jpg',3,'App\\Models\\Service','2025-04-16 21:46:45','2025-04-16 21:46:45'),(385,'images/M3iTsOKR2V9HufY47BMKMcAzz7FqDHpLM1yj6On6.jpg',3,'App\\Models\\Service','2025-04-16 21:46:45','2025-04-16 21:46:45'),(386,'images/Yj2ojN3ammyUrPBb2WURlcoCpoV9cw1WdezNmGig.jpg',3,'App\\Models\\Service','2025-04-16 21:46:45','2025-04-16 21:46:45'),(387,'images/sL0L7FN2inhlgpPiqDp5vPbdCw3Kbsiaf7TUyDKZ.jpg',3,'App\\Models\\Service','2025-04-16 21:46:45','2025-04-16 21:46:45'),(388,'images/U9KWCg3yOXwzh4h2V9jmuJGBf2dehuYFpZZRMbRv.jpg',4,'App\\Models\\Service','2025-04-16 22:01:15','2025-04-16 22:01:15'),(389,'images/x1xED3iR0EjQhtIPs1G01F06YILiLjQUvMicuuNs.jpg',4,'App\\Models\\Service','2025-04-16 22:01:15','2025-04-16 22:01:15'),(390,'images/xAQ7REwPZVenPCblF7Yn4Bfo38D1qxMHyjTYlRpf.jpg',4,'App\\Models\\Service','2025-04-16 22:01:15','2025-04-16 22:01:15'),(391,'images/gT3m7GjbLUCBinIJbqev5UyCpllwfDFhMTeK5zb1.jpg',4,'App\\Models\\Service','2025-04-16 22:01:15','2025-04-16 22:01:15'),(392,'images/kpFU65wR1jUFKaQgzDiBkGBH8VUO9dS9DJT9oacg.jpg',4,'App\\Models\\Service','2025-04-16 22:01:15','2025-04-16 22:01:15'),(393,'images/jxRngkh41pRRJphKa5JrR1LeTFIVPdl7B8OxWNNk.jpg',4,'App\\Models\\Service','2025-04-16 22:01:15','2025-04-16 22:01:15'),(394,'images/bAq8ZGNPGMptOhS8GlH4qpYfWcl2Bkdw3GNQ0zC6.jpg',4,'App\\Models\\Service','2025-04-16 22:01:15','2025-04-16 22:01:15'),(395,'images/3Q0zGC5DMQfto3m7cW5bTIeygEtYckYhoTDChM2f.jpg',4,'App\\Models\\Service','2025-04-16 22:01:15','2025-04-16 22:01:15'),(396,'images/Bu7tMAX477KWYkSnRJBQtdAoABW3IdbXDkSZfGVt.jpg',4,'App\\Models\\Service','2025-04-16 22:01:15','2025-04-16 22:01:15'),(422,'images/Ogly7iY2Spc7984I9axkeEOBWaL53FvksJTMJL8o.jpg',2,'App\\Models\\Product','2025-04-17 19:15:56','2025-04-17 19:15:56'),(423,'images/4FTt5txOzYePzaXfojrB4egopXRc1bwMi4H9SluZ.jpg',2,'App\\Models\\Product','2025-04-17 19:15:56','2025-04-17 19:15:56'),(424,'images/cXnvKVuQFRcmCRPANhJ5bDFNFG4qKlCFZcRkqI8Y.jpg',2,'App\\Models\\Product','2025-04-17 19:15:56','2025-04-17 19:15:56'),(425,'images/fOkiDE4xtbAMaTkbvlLfLjvBfQPUvkz6Ljf77n6y.jpg',2,'App\\Models\\Product','2025-04-17 19:15:56','2025-04-17 19:15:56'),(426,'images/cuwn4HkKUbZfUPoNexiN6zZRoA9JOeMIOlIeUHlr.jpg',2,'App\\Models\\Product','2025-04-17 19:15:56','2025-04-17 19:15:56'),(427,'images/NyFMvI0Y3x5OSWdYCRwagL7gEPVxilBa4cX1Ol5Z.jpg',2,'App\\Models\\Product','2025-04-17 19:15:56','2025-04-17 19:15:56'),(428,'images/lYh5pRjrXcRhgj8uTBinErSW2iprIxO96HPX3knN.jpg',3,'App\\Models\\Product','2025-04-17 19:16:38','2025-04-17 19:16:38'),(429,'images/nKWxkPFhKLOWV0jWREuADzDZvDm30HQMIf7rl93j.jpg',3,'App\\Models\\Product','2025-04-17 19:16:38','2025-04-17 19:16:38'),(430,'images/X2ueNVQCsEVQJu6Aw3r8dWdAaqoF0ulXBJRcljz8.jpg',3,'App\\Models\\Product','2025-04-17 19:16:38','2025-04-17 19:16:38'),(431,'images/hmrwH1HSdYLaZqM3ycIzoCUDFNHfBXV82asnUSzZ.jpg',3,'App\\Models\\Product','2025-04-17 19:16:38','2025-04-17 19:16:38'),(432,'images/vDUumpOArsfpoQQUKhOZ11jtyLmoS8ghwfW281gJ.jpg',1,'App\\Models\\Product','2025-04-17 19:18:34','2025-04-17 19:18:34'),(433,'images/DpN08jazlYSpKvZxk9rucJ8viOK5IayfBCGG2CZb.jpg',4,'App\\Models\\Product','2025-04-17 19:19:56','2025-04-17 19:19:56'),(434,'images/leS6ec28pzqRbNYLyUZiiLpBP8J4V3mu6ovzlk5l.jpg',4,'App\\Models\\Product','2025-04-17 19:19:56','2025-04-17 19:19:56'),(435,'images/tIb0CI1GsT3T2xeNThfqIXaKfMsqb7w2SPvxHYIL.jpg',4,'App\\Models\\Product','2025-04-17 19:19:56','2025-04-17 19:19:56'),(436,'images/OQ5GZoatoNbYWrzC1GIXRAOuUcnFbgZnFX1heHj4.jpg',4,'App\\Models\\Product','2025-04-17 19:19:56','2025-04-17 19:19:56'),(437,'images/P4naAKU6htg1OQtlxz1Ooyx5gsaVMyov5EJJ5ZF6.jpg',4,'App\\Models\\Product','2025-04-17 19:19:56','2025-04-17 19:19:56'),(438,'images/77eWfbpUM0AQiNDGnd1HsxYqNM01vFxss7y53DfD.jpg',5,'App\\Models\\Product','2025-04-17 19:20:53','2025-04-17 19:20:53'),(439,'images/cAo6JSz1RPKTmsu63PumKoATCXkD84WhrraXdzH2.jpg',5,'App\\Models\\Product','2025-04-17 19:20:53','2025-04-17 19:20:53'),(440,'images/wC6rBxGpGdniv0tXTshvDQTnuvWQmjMS9BfkHK6D.jpg',5,'App\\Models\\Product','2025-04-17 19:20:53','2025-04-17 19:20:53'),(441,'images/6ZXhdxffRqF9ocWD2fBKGKGTRvNVJ0BmxYMlb1Yj.jpg',5,'App\\Models\\Product','2025-04-17 19:20:53','2025-04-17 19:20:53'),(442,'images/SQpEq7DwOr9l69YwSM180YhE3Wg2Kfqiq5c7w6tC.jpg',5,'App\\Models\\Product','2025-04-17 19:20:53','2025-04-17 19:20:53'),(443,'images/0qPQ5QFuVNqEZDMf9auXbiPmTxj5VxF0nATRY9x0.jpg',5,'App\\Models\\Product','2025-04-17 19:20:53','2025-04-17 19:20:53'),(449,'images/6EuJ7GssJFwkVKmMUGWahVjWpmeTtjfPNErL5EBa.jpg',7,'App\\Models\\Product','2025-04-17 19:22:21','2025-04-17 19:22:21'),(450,'images/ZqaSigvzi6Te3cd08X8lQGgLuGyDeiw0LyrY8mjl.jpg',7,'App\\Models\\Product','2025-04-17 19:22:21','2025-04-17 19:22:21'),(451,'images/qHGQxc522o0buzie12ZiorVUGun9nZUoLryCMCHE.jpg',7,'App\\Models\\Product','2025-04-17 19:22:21','2025-04-17 19:22:21'),(452,'images/AxDehYHU87JVOJ83edSx6QJHLP2SVpuzRvxyQ1JC.jpg',7,'App\\Models\\Product','2025-04-17 19:22:21','2025-04-17 19:22:21'),(453,'images/Pl0CZPogzSCOfGntYp5aCP9Uq7GnePVtnXqpp6TH.jpg',7,'App\\Models\\Product','2025-04-17 19:22:21','2025-04-17 19:22:21'),(454,'images/WBE77dZjjmDQ68gTvbHU67U4WZn0Es6drZFkdwfI.jpg',8,'App\\Models\\Product','2025-04-17 19:23:03','2025-04-17 19:23:03'),(455,'images/rH9GrT6Mh5cSXYUwVGmgy5gooQJZb1fuQ9bQdeme.jpg',8,'App\\Models\\Product','2025-04-17 19:23:03','2025-04-17 19:23:03'),(456,'images/Chv3yYYD0bCVDTKQDm1BkgWeDe4W4cUDhHFVOPme.jpg',8,'App\\Models\\Product','2025-04-17 19:23:03','2025-04-17 19:23:03'),(457,'images/RnhTtMZnSO3LSqxfesUMgBxgAInrt8EngsncG2PH.jpg',8,'App\\Models\\Product','2025-04-17 19:23:03','2025-04-17 19:23:03'),(458,'images/HiZv0uHoazcBJQeBRl6RkCHjxMdfXMhXUwsPI4c0.jpg',8,'App\\Models\\Product','2025-04-17 19:23:03','2025-04-17 19:23:03'),(459,'images/8iIekWO5wbs0SHIpq3KK7OEywzEeDuPFaVxsaCYe.jpg',8,'App\\Models\\Product','2025-04-17 19:23:03','2025-04-17 19:23:03'),(460,'images/luz86nzdNImM9s6DaiN6zMmJzD9C262VLdwpAZis.jpg',9,'App\\Models\\Product','2025-04-17 19:24:20','2025-04-17 19:24:20'),(461,'images/S8BonlwJojnYSMhP5D8pOEkQfbFY2b5oWjcJXUmr.jpg',9,'App\\Models\\Product','2025-04-17 19:24:20','2025-04-17 19:24:20'),(462,'images/yuNYqKWY6o4UBCrWQKOZ5auQmRgFwzRqgAcslHCU.jpg',9,'App\\Models\\Product','2025-04-17 19:24:20','2025-04-17 19:24:20'),(463,'images/hGnBqbjUNuhNT3LzfOHS1CHd4xwnl1iLvjDrJDbI.jpg',9,'App\\Models\\Product','2025-04-17 19:24:20','2025-04-17 19:24:20'),(464,'images/VE3axmlk3rvQSutc9eh7MgjiImhsKVXNtA6BeP7H.jpg',9,'App\\Models\\Product','2025-04-17 19:24:20','2025-04-17 19:24:20'),(471,'images/q50jw4joceORS1AgA9xamCtpHrJEsqW13DLm7Tci.jpg',11,'App\\Models\\Product','2025-05-07 20:41:40','2025-05-07 20:41:40'),(474,'images/lXXuH8tsU9Bpg7fyxXw28aTjnK2Lx1XNe5qliar9.jpg',13,'App\\Models\\Product','2025-05-07 20:53:08','2025-05-07 20:53:08'),(475,'images/inmef9MKuYAsfCQxPzw7lmrjtCxaQfjN3bHqGxLa.jpg',14,'App\\Models\\Product','2025-05-07 21:00:09','2025-05-07 21:00:09'),(476,'images/fF74JSGF4LXBeSBt4vgRLzIAjuY0rQXyYhGSWx9o.jpg',15,'App\\Models\\Product','2025-05-07 21:03:40','2025-05-07 21:03:40'),(477,'images/jqB28Z13avEjwLGr9umYcM6OJ4cmPgIAf5nmRZW4.jpg',16,'App\\Models\\Product','2025-05-07 21:06:53','2025-05-07 21:06:53'),(478,'images/m7KIeqJmwCmreT8rt0DRq0hQK2RFJugpCI5AHwze.jpg',17,'App\\Models\\Product','2025-05-07 21:08:42','2025-05-07 21:08:42'),(479,'images/bZPmcONhebROMplGPkL8gTa68tPh9Hkzz8nSAsHo.jpg',18,'App\\Models\\Product','2025-05-07 21:11:23','2025-05-07 21:11:23'),(480,'images/xANx6ZH00InY3H7ZLSYPtjYl2MNVga5rrh3WUPk5.jpg',19,'App\\Models\\Product','2025-05-07 21:12:56','2025-05-07 21:12:56'),(481,'images/DLGJLuOaBIJV6HHSe42BZi2N2ZDnrvwWvKM5NhbZ.jpg',20,'App\\Models\\Product','2025-05-07 21:18:19','2025-05-07 21:18:19'),(482,'images/T6MIs9H5vUOjckVhhWZmBfM3zR6HtKgMdd8jH8EF.jpg',21,'App\\Models\\Product','2025-05-07 21:19:59','2025-05-07 21:19:59'),(483,'images/aWyZqRxPFX7SKRPDbhozB6aq9zTW3VR4sl2oPr67.jpg',22,'App\\Models\\Product','2025-05-07 21:21:48','2025-05-07 21:21:48'),(484,'images/627DyBFckae2LoNzn4AmbJoi9FTgJrXGX0GGVxQB.jpg',23,'App\\Models\\Product','2025-05-07 21:24:06','2025-05-07 21:24:06'),(487,'images/hYTBLGXEui6rAf9kpY0Qge0e7mEdFY7ubmYs3hDs.jpg',26,'App\\Models\\Product','2025-05-07 21:34:33','2025-05-07 21:34:33'),(488,'images/wzF8o60rP8m92JExQWxoUFNHJy1Bo0rQwKMbotNj.jpg',27,'App\\Models\\Product','2025-05-07 21:36:55','2025-05-07 21:36:55'),(489,'images/hKg2wIjQqhQhYIyhR0VnHtF0nJrkQIj8Yy1tI3zh.jpg',28,'App\\Models\\Product','2025-05-07 21:39:48','2025-05-07 21:39:48'),(490,'images/faQxUctWrswkLg1k5TQyYIkFTigCHdWT8GK6QTSb.jpg',29,'App\\Models\\Product','2025-05-07 21:42:17','2025-05-07 21:42:17'),(491,'images/fBAR3CfubQ56ERrTM8T9MXHzWPlbxkPd3f6ezbvb.jpg',30,'App\\Models\\Product','2025-05-07 21:46:17','2025-05-07 21:46:17'),(492,'images/CFVPNloMmauF47MbRBdBqzQOAmG5HBxG4kmMNP8C.jpg',31,'App\\Models\\Product','2025-05-07 21:49:07','2025-05-07 21:49:07'),(493,'images/PaHRy2TWOu3SVNrM01pN5x7GaLRXHE5QD7QyT9Wn.jpg',32,'App\\Models\\Product','2025-05-07 21:51:55','2025-05-07 21:51:55'),(494,'images/Qwpwk89JZbXNWVBOnZk9EhpMrMxSJZJRlhI4ipdg.jpg',33,'App\\Models\\Product','2025-05-07 21:54:30','2025-05-07 21:54:30'),(496,'images/pyeLLBvrxxLy5QPcA6fj1eQ0bJaa3oyqK6N77Eu6.jpg',35,'App\\Models\\Product','2025-05-07 21:58:42','2025-05-07 21:58:42'),(498,'images/0vkPbwKHGDzNcApF7X9DFuAgvxooMkMBqYIABVUU.png',37,'App\\Models\\Product','2025-05-15 14:41:05','2025-05-15 14:41:05'),(499,'images/sE6y7pGAmApiUq3m924qvrKBRr2xtopJzXnGnAfQ.png',38,'App\\Models\\Product','2025-05-15 14:43:10','2025-05-15 14:43:10'),(500,'images/ei04cDdwLBlP4pcURGTXnnIhmavbxELqMwFZNnTN.png',39,'App\\Models\\Product','2025-05-15 14:49:09','2025-05-15 14:49:09'),(501,'images/sFBmUBdlRnZLT7AZnYZ27n7FSF5DbOT5ivqgOmtH.png',40,'App\\Models\\Product','2025-05-15 14:52:43','2025-05-15 14:52:43'),(502,'images/pyE82Zas5dZFdJobSzgtspxE3yNCXMYxdI9ybCd3.png',41,'App\\Models\\Product','2025-05-15 15:01:54','2025-05-15 15:01:54'),(503,'images/BItstMB3dHCLXE5O9VXzGLPfv8QtdTHngbryUXMK.png',42,'App\\Models\\Product','2025-05-15 15:28:21','2025-05-15 15:28:21'),(504,'images/FeLyhl85MprJsCvENQQ84cs6Pg4XyOogOWTgBQ3B.png',43,'App\\Models\\Product','2025-05-15 15:30:02','2025-05-15 15:30:02'),(505,'images/UHB0cqtmdmlEiNDFZwQiznqTHYjhzKQWoEAO77bV.png',45,'App\\Models\\Product','2025-05-15 15:32:54','2025-05-15 15:32:54'),(506,'images/3IcCt3lPEGWdwBOi5xnRkNnGrIG1zrDXSqsijYSc.png',46,'App\\Models\\Product','2025-05-15 15:36:40','2025-05-15 15:36:40'),(507,'images/BBbaCXeWApB7nUKhDeLXqKi7TgCczE4B8eEZi9oZ.png',49,'App\\Models\\Product','2025-05-15 15:46:07','2025-05-15 15:46:07'),(508,'images/YuShiN2P65GvETQsx5nOjNfXzkdf8N6SMezdgepR.png',50,'App\\Models\\Product','2025-05-15 15:55:47','2025-05-15 15:55:47'),(509,'images/ywX1rICfvdwlbo8rdfKCyytMFlKHO0lJ2GC6xfDf.png',51,'App\\Models\\Product','2025-05-17 01:45:35','2025-05-17 01:45:35'),(510,'images/ENoqP41LCtn0xA1GbDBFeQYRsbwJ6JpwnO1B3gvz.png',52,'App\\Models\\Product','2025-05-17 01:53:40','2025-05-17 01:53:40'),(513,'images/lCLDyZdXyaBrfvzLaQdhS5EG7eoUvF74KoXnJijN.png',56,'App\\Models\\Product','2025-05-24 18:11:55','2025-05-24 18:11:55'),(515,'images/JojMHSEP5PDUv83wNJMAmXzt1jMEeRcOi39lexiB.png',58,'App\\Models\\Product','2025-05-24 18:16:37','2025-05-24 18:16:37'),(516,'images/8gTha1khtWjd3W8ZWNJHkpyM8BvQnClWhhcoecgE.png',59,'App\\Models\\Product','2025-05-24 18:19:12','2025-05-24 18:19:12'),(518,'images/bQcL82UAcX3uyx8TrGQyLdHJqCfSSVcVFBAnxZgC.png',61,'App\\Models\\Product','2025-05-24 18:23:30','2025-05-24 18:23:30'),(519,'images/Mhe0uUmlHTzXzL86Pgy5fDJPDXcK9eijXUgwhPqy.png',62,'App\\Models\\Product','2025-05-24 18:25:44','2025-05-24 18:25:44'),(520,'images/tGUK8NRwdJGGVuJJWFL4eDgsPFPoKg5fwBUwCR0P.png',63,'App\\Models\\Product','2025-05-24 18:28:27','2025-05-24 18:28:27'),(521,'images/25K3510DWfulBlmX9BtrwM61o73i5uPetZsIplt5.png',64,'App\\Models\\Product','2025-05-24 18:31:01','2025-05-24 18:31:01'),(522,'images/w6e6tekAJpFurbZ6XdLVoyQxSbQ3FVbPQmQjsTn4.png',65,'App\\Models\\Product','2025-05-24 18:33:59','2025-05-24 18:33:59'),(523,'images/xWTxUEBHGkSWf0uAgcdF8roZDFwm7s4QYInQ8djX.png',66,'App\\Models\\Product','2025-05-24 18:37:31','2025-05-24 18:37:31'),(524,'images/NCLQS0NwA9PlatDstAfmcBwYPyWumTdcLXx2Gd95.png',67,'App\\Models\\Product','2025-05-24 18:40:18','2025-05-24 18:40:18'),(525,'images/nXdo0fgr0rXssu0RFpNeL3l9kvkNuwaMEnajJKAW.png',68,'App\\Models\\Product','2025-05-24 18:43:07','2025-05-24 18:43:07'),(528,'images/zd8VtXl6QGnIgBhhMyL0uuXmhTM8Xm6XmOiVXurA.png',71,'App\\Models\\Product','2025-06-01 20:32:48','2025-06-01 20:32:48'),(530,'images/LOeavjRKTVhsd3z6RKOz66CVhFcZkzoj4FaKpl28.png',73,'App\\Models\\Product','2025-06-01 21:00:46','2025-06-01 21:00:46'),(533,'images/q2BRcfxMyHlCUk137fHK4rX7hdevWieUO5fMdJQF.png',76,'App\\Models\\Product','2025-06-02 16:14:29','2025-06-02 16:14:29'),(534,'images/yyVoTeQSxFsTFCec5bWussir2WSDi5JUj5n0Pbgd.png',77,'App\\Models\\Product','2025-06-02 16:42:10','2025-06-02 16:42:10'),(538,'images/tN9vIMuyckjThTL1AhpcfiCWAv74UyTx5AeV7GD0.png',81,'App\\Models\\Product','2025-06-02 16:59:32','2025-06-02 16:59:32'),(539,'images/QdmE4MokLnXflb28GiUBVkwcknDnPE57rTdwdJNc.png',82,'App\\Models\\Product','2025-06-02 17:05:52','2025-06-02 17:05:52'),(541,'images/ha2989UA5aCmK40tNdsqmvcsdXYzX7kPUkTNwAEd.png',84,'App\\Models\\Product','2025-06-02 17:28:58','2025-06-02 17:28:58'),(543,'images/Po9H4DUjY7XrSYAApYt2YsZTJAdaR84NSKHYhUjs.png',86,'App\\Models\\Product','2025-06-02 18:45:18','2025-06-02 18:45:18'),(544,'images/uYlQaw4k1JGK4NcoeO5NWjezh2QKdolisBHW0HJx.png',87,'App\\Models\\Product','2025-06-02 18:53:58','2025-06-02 18:53:58'),(545,'images/4j7HNCAgArqCve4fVHJrWv7YMc8L7chACdmSAwXh.png',88,'App\\Models\\Product','2025-06-02 19:01:17','2025-06-02 19:01:17'),(546,'images/ukLctTALJaUw1rHThSCQ2z0rBNnCLOS9UtUuAOrw.png',89,'App\\Models\\Product','2025-06-02 19:14:53','2025-06-02 19:14:53'),(547,'images/Q2Sv8VXmyTvYM7y1gLqTMZLcafmgz0LaOag38vrF.png',90,'App\\Models\\Product','2025-06-02 19:24:14','2025-06-02 19:24:14'),(548,'images/g2dtwLh8VgL4q4gAxwgu7UtRlBoU8r15AsocItbu.png',91,'App\\Models\\Product','2025-06-02 19:29:50','2025-06-02 19:29:50'),(549,'images/fTg1DEDNU7PMhdloQW0svpZFOiLyOdQr5SljfXGQ.png',92,'App\\Models\\Product','2025-06-02 19:35:58','2025-06-02 19:35:58'),(550,'images/FzGCWvr58gzd0DYBrpDDpnP16xxVopMMrrdmLvC0.png',93,'App\\Models\\Product','2025-06-02 19:45:17','2025-06-02 19:45:17'),(551,'images/ccDSMhET0KVjBoYQdbMIBaNXORfzZShHzwsaCGFR.png',94,'App\\Models\\Product','2025-06-02 20:38:09','2025-06-02 20:38:09'),(552,'images/HBIvZ8nit56nRKAh7P7cgHxc4TVppJYNnelAwOJ7.png',95,'App\\Models\\Product','2025-06-02 20:41:04','2025-06-02 20:41:04'),(553,'images/qFTwhzFlLQvK9iI8OAAdwgEqvGfEyyhvQU4SaxYB.png',96,'App\\Models\\Product','2025-06-02 20:44:51','2025-06-02 20:44:51'),(554,'images/CTsVY4jGXJ9OgE6ZddtYnurUoWjgqJBRFRuKLLP8.png',97,'App\\Models\\Product','2025-06-02 20:52:12','2025-06-02 20:52:12'),(555,'images/AI5FWAAjnENanJW0gbTaaN5pckFJSxSJVAfg2u3P.png',98,'App\\Models\\Product','2025-06-02 20:55:55','2025-06-02 20:55:55'),(556,'images/XRyMLETshBVPouonLhRhqA4DaU1s34ks622EDvSo.png',99,'App\\Models\\Product','2025-06-03 16:30:31','2025-06-03 16:30:31'),(557,'images/rLidlOcQwGG5D06IZf6bk2X3tUTP6loA9axAfiSq.png',100,'App\\Models\\Product','2025-06-03 16:37:24','2025-06-03 16:37:24'),(558,'images/dCSU7HGJeJaz6ftPuIHOKDOYvUIvd0HnVCZn2cRK.png',101,'App\\Models\\Product','2025-06-03 16:50:19','2025-06-03 16:50:19'),(559,'images/d2yZcMPYltI9H5jWX5fNcCFS6xQgzgDgn2Nshacb.png',102,'App\\Models\\Product','2025-06-03 16:57:09','2025-06-03 16:57:09'),(560,'images/yg7FjKybOnZBSbPB6SgGEVq7UxKoEo9XnCQYGFYo.png',103,'App\\Models\\Product','2025-06-03 17:01:25','2025-06-03 17:01:25'),(561,'images/4o9j2cXsUki3H8ZEotvgiT4L7HNGc3Scl4uGBis3.png',104,'App\\Models\\Product','2025-06-03 17:08:20','2025-06-03 17:08:20'),(562,'images/W7ADcU5XDnCvtBMcdJsQQjwcjW0CBtdECCNL78ft.png',105,'App\\Models\\Product','2025-06-03 17:13:26','2025-06-03 17:13:26'),(563,'images/u4UMWr8h36wBMzdnbosarW0oEeImPqdCekk5ZcqQ.png',106,'App\\Models\\Product','2025-06-03 17:17:56','2025-06-03 17:17:56'),(565,'images/2zJd9d5VGONHgy1XLRAqOXZqVCNt8kyQNeiy5OxM.png',108,'App\\Models\\Product','2025-06-03 17:25:56','2025-06-03 17:25:56'),(566,'images/UwLWCoge3W5alZe9VJAP1rMxzCj5Y013PfJWVIEX.jpg',109,'App\\Models\\Product','2025-06-03 17:32:00','2025-06-03 17:32:00'),(567,'images/CTGBH7wemRsmqGMn4HcMGVS8k8t19QXuF7BTuidY.png',110,'App\\Models\\Product','2025-06-03 17:33:50','2025-06-03 17:33:50'),(568,'images/o6ed5xQ5ISCAlIjKlIGfO5mohMavtw8j3AZgbhIz.png',111,'App\\Models\\Product','2025-06-03 17:38:42','2025-06-03 17:38:42'),(570,'images/iBvKiO09jmBqRYYx7yrxrHxePlg4wIyjecJhG6fv.jpg',113,'App\\Models\\Product','2025-06-04 15:51:13','2025-06-04 15:51:13'),(571,'images/jgdFE4IJh7lNYrF34CS99VKSTJ7hMzlAet6cujXG.jpg',114,'App\\Models\\Product','2025-06-04 15:52:56','2025-06-04 15:52:56'),(572,'images/Rz36i5fMxT62d98jPQYa2UDawlyOXVPptv5c453K.jpg',115,'App\\Models\\Product','2025-06-04 15:55:11','2025-06-04 15:55:11'),(580,'images/DJ4EBztm8Jp5J5F525SFWLaKkitI9be46hpe0dQs.jpg',123,'App\\Models\\Product','2025-06-12 14:57:38','2025-06-12 14:57:38'),(581,'images/M93Q3bQUpGGZmAFKwxCgzPnNt4Tyxnv0h2AXP99O.jpg',124,'App\\Models\\Product','2025-06-12 14:59:05','2025-06-12 14:59:05'),(582,'images/ZTjKgTNv85yAyBxHQxmhEKKexshpAd0p0vs9JZxw.jpg',125,'App\\Models\\Product','2025-06-12 15:00:26','2025-06-12 15:00:26'),(585,'images/qB2bX8kJdwmZ4eI8C7znAyLU3XWzkk8qC90pswjx.jpg',126,'App\\Models\\Product','2025-07-17 20:02:29','2025-07-17 20:02:29'),(586,'images/nTurs7LEDamq3BwTujIHZarLlTIHiIj92ZYcfFOU.jpg',1,'App\\Models\\Category','2025-09-16 20:13:45','2025-09-16 20:13:45'),(587,'images/JxMJnvbcx1yrZ6iozLFSefud14PvdXwEMWhg7lRZ.jpg',2,'App\\Models\\Category','2025-09-16 20:15:02','2025-09-16 20:15:02'),(591,'images/vu8alKVogjFD0Rk8S3NDcevUXOMYYwCtdscupxdq.avif',19,'App\\Models\\Slider','2025-09-16 20:22:30','2025-09-16 20:22:30'),(592,'images/8FjjEWDDe0tesUoIhCcLwvBQ8ANxiQSGq3lyicoU.jpg',18,'App\\Models\\Slider','2025-09-16 20:23:47','2025-09-16 20:23:47'),(594,'images/2yL1UoLA3yphx4iJoXsfr5P5ciOJ5Ky8ysntkZSJ.avif',17,'App\\Models\\Slider','2025-09-16 20:25:35','2025-09-16 20:25:35'),(614,'images/cJgTusySLntdZPeKbSeSol4srwk2c0bWp8tHL9aO.jpg',119,'App\\Models\\Product','2025-09-21 19:16:18','2025-09-21 19:16:18'),(615,'images/NqW82ItIBWuV1NFAB0IaNwkR34gUDL10KgI4DAd1.jpg',119,'App\\Models\\Product','2025-09-21 19:16:18','2025-09-21 19:16:18'),(617,'images/YAVayu4ypswt8IJdEcRnBIWj4in9vVQjdW0BvCeg.jpg',118,'App\\Models\\Product','2025-09-21 20:04:24','2025-09-21 20:04:24'),(618,'images/lC3wQ7GYeCWa9QNAbp2RJ8z4VS6L1UGBEDsAR7rJ.jpg',117,'App\\Models\\Product','2025-09-21 20:05:00','2025-09-21 20:05:00'),(620,'images/E8qdhKBdVD9o6OD6xXBV4lG8I4JViwiU1a9rvhvt.jpg',116,'App\\Models\\Product','2025-09-21 20:05:45','2025-09-21 20:05:45'),(621,'images/KbdL9HdhpK0ndrUEtmU9gjmrL6uHTMsryt0RJ1Ex.jpg',120,'App\\Models\\Product','2025-09-21 20:06:22','2025-09-21 20:06:22'),(629,'images/OOqRp352LQP29Q9souK8hipjzCU2rMECJ93q7OI8.webp',1,'App\\Models\\Page','2025-09-21 21:50:23','2025-09-21 21:50:23');
/*!40000 ALTER TABLE `files` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `itemrequest_translations`
--

DROP TABLE IF EXISTS `itemrequest_translations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `itemrequest_translations` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `itemRequest_id` bigint(20) unsigned NOT NULL,
  `locale` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `itemrequest_translations_itemrequest_id_locale_unique` (`itemRequest_id`,`locale`),
  KEY `itemrequest_translations_locale_index` (`locale`),
  CONSTRAINT `itemrequest_translations_itemrequest_id_foreign` FOREIGN KEY (`itemRequest_id`) REFERENCES `itemrequests` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `itemrequest_translations`
--

LOCK TABLES `itemrequest_translations` WRITE;
/*!40000 ALTER TABLE `itemrequest_translations` DISABLE KEYS */;
/*!40000 ALTER TABLE `itemrequest_translations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `itemrequests`
--

DROP TABLE IF EXISTS `itemrequests`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `itemrequests` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `store_id` bigint(20) unsigned NOT NULL,
  `reviewer_id` bigint(20) unsigned DEFAULT NULL,
  `type` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'create, edit',
  `data` longtext COLLATE utf8mb4_unicode_ci,
  `product_id` bigint(20) unsigned DEFAULT NULL,
  `status` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'pending, accepted',
  `rejected_reason` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `affected_fields` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `image` longtext COLLATE utf8mb4_unicode_ci,
  `images` longtext COLLATE utf8mb4_unicode_ci,
  `variationImages` longtext COLLATE utf8mb4_unicode_ci,
  PRIMARY KEY (`id`),
  KEY `itemrequests_product_id_foreign` (`product_id`),
  KEY `itemrequests_reviewer_id_foreign` (`reviewer_id`),
  CONSTRAINT `itemrequests_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE,
  CONSTRAINT `itemrequests_reviewer_id_foreign` FOREIGN KEY (`reviewer_id`) REFERENCES `admins` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `itemrequests`
--

LOCK TABLES `itemrequests` WRITE;
/*!40000 ALTER TABLE `itemrequests` DISABLE KEYS */;
/*!40000 ALTER TABLE `itemrequests` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ltm_translations`
--

DROP TABLE IF EXISTS `ltm_translations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ltm_translations` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `status` int(11) NOT NULL DEFAULT '0',
  `locale` varchar(255) COLLATE utf8mb4_bin NOT NULL,
  `group` varchar(255) COLLATE utf8mb4_bin NOT NULL,
  `key` text COLLATE utf8mb4_bin NOT NULL,
  `value` text COLLATE utf8mb4_bin,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ltm_translations`
--

LOCK TABLES `ltm_translations` WRITE;
/*!40000 ALTER TABLE `ltm_translations` DISABLE KEYS */;
/*!40000 ALTER TABLE `ltm_translations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `merchantrequests`
--

DROP TABLE IF EXISTS `merchantrequests`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `merchantrequests` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `storeName` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `merchantName` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `phone` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `address` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `username` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pending' COMMENT 'pending',
  `pending_at` timestamp NULL DEFAULT NULL,
  `approved_at` timestamp NULL DEFAULT NULL,
  `rejected_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=42 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `merchantrequests`
--

LOCK TABLES `merchantrequests` WRITE;
/*!40000 ALTER TABLE `merchantrequests` DISABLE KEYS */;
INSERT INTO `merchantrequests` (`id`, `storeName`, `merchantName`, `email`, `phone`, `address`, `username`, `password`, `status`, `pending_at`, `approved_at`, `rejected_at`, `created_at`, `updated_at`) VALUES (1,'El hima',NULL,'newemail@example.com','+966502548565','Family Court','ibrahimsamy308','$2y$10$UtXDA5rVN/jHQh.7nkADxOzvjHCfha82KD7ivCXP9xa/DFoXa9Fpu','pending','2025-03-10 17:27:43',NULL,NULL,'2025-03-10 17:27:43','2025-03-10 17:30:31'),(4,NULL,'himaNew','ibrahimsamy308@gmail.com','+966502458757','Family Court','ibrahim308','$2y$10$jw8HLbxsys8TCHKTXxuo8OIST75DttZgtpSRnGTwjnWbLfHJ4O81O','approved','2025-03-11 11:43:46',NULL,NULL,'2025-03-11 11:43:46','2025-03-11 11:46:25'),(19,NULL,'MH','mohamedhossnyahmed.123@gmail.com','+966500000002','Giza','MH','$2y$10$oFuZLz3IPEvbe0KoaQ..oujui89E.YIhinN6FE/rs4Md0UHrORc36','rejected','2025-03-15 13:20:58',NULL,'2025-03-15 13:22:37','2025-03-15 13:20:58','2025-03-15 13:22:37'),(20,NULL,'MH','mohamedhossnyahmed.123@gmail.com','+966500000002','Giza','MH','$2y$10$Q5QU.8SvjiVJNXd0xayVz.e6kUi3uzIUyySNj8zw3Cd.zmjDlVmuK','rejected','2025-03-15 13:26:57',NULL,'2025-03-15 13:27:24','2025-03-15 13:26:57','2025-03-15 13:27:24'),(21,'MH',NULL,'mohamedhossnyahmed.123@gmail.com','+966500000002','Giza','MH','$2y$10$CzocME4xkpL2raT7qNBRpeT42P6nNXTJ/QnDkM/2TPtX8wYa1gs8C','rejected','2025-03-15 13:27:59',NULL,'2025-03-15 13:28:10','2025-03-15 13:27:59','2025-03-15 13:28:10'),(22,'MH','MH','mohamedhossnyahmed.123@gmail.com','+966500000002',NULL,'MH','$2y$10$uIXaaKNQh3Q4ZNKDhi.uE.cLIbEr/X43lTExt.31qUD4jP9rxs7Mm','rejected','2025-03-15 13:29:26',NULL,'2025-03-15 13:31:09','2025-03-15 13:29:26','2025-03-15 13:31:09'),(24,'MH','MH','mohamedhossnyahmed.123@gmail.com','+966500000002','Giza','M  H  A','$2y$10$YDoNi0ZmUSKLAifyRybPA.ZpBQbUlLbFplOlvhSbnH3AB8RwRXU.S','approved','2025-03-15 13:40:12','2025-03-15 13:40:33',NULL,'2025-03-15 13:40:12','2025-03-15 13:40:33'),(25,'MH','MH','mohamedhossnyahmed.123@gmail.com','+966500000002','Dhab','H  G  X','$2y$10$PDqjH3oNYJeCsUlCUbUYyeTs9uJVl/n/tckYrG02BYu0z9t04HUGa','approved','2025-03-15 13:48:29','2025-03-15 13:48:46',NULL,'2025-03-15 13:48:29','2025-03-15 13:48:46'),(27,'DF','Karlos Wiliam','M@gmail','+966500000003','Dhab','Karlos','$2y$10$TEehHAulkDFQ6R63mX4rxOhwrJtbmL9/OxBuqx2rGKnDOaPgOQGcG','pending','2025-03-15 14:53:15',NULL,NULL,'2025-03-15 14:53:15','2025-03-15 14:53:15'),(28,'ShopEase','Tom Ford','mohamedhossnyahmed.123@gmail.com','+966500000005','Giza','TomFord','$2y$10$Alc2zI14lxLhZl2QVLPIqu15tcWEG3utAqly/35xEHglZwNp1yT8m','pending','2025-03-15 15:11:14',NULL,NULL,'2025-03-15 15:11:14','2025-03-15 15:11:14'),(29,'Elite Styles','James Bond','mohamedhossnyahmed.123@gmail.com','+966522522500','Giza','James','$2y$10$gC1kqXLvTHv6jNUDgwbaM.uMH018gQIJyBX2Thsc6aI47buAEfdgC','pending','2025-03-15 15:20:34',NULL,NULL,'2025-03-15 15:20:34','2025-03-15 15:20:34'),(30,'Fashion Hub','John Doe','mohamedhossnyahmed.123@gmail.com','+966500000006','Giza','MH','$2y$10$lc9/y00v3mAyvdBDdNjGeOpLB4e89NrV/mkNHZxbx3W40QoOXO8u6','approved','2025-03-15 15:25:20','2025-03-15 15:25:36',NULL,'2025-03-15 15:25:20','2025-03-15 15:25:36'),(31,'Fashion Hub','John Doe','mohamedhossnyahmed.123@gmail.com','+966500000001','Dhab','MH','$2y$10$CPPBKwsyZZWUK6NIqU2/weX01VPZAOTcKeW2w3nV0AbAjtxSIgwWG','approved','2025-03-15 15:27:38','2025-03-15 15:27:55',NULL,'2025-03-15 15:27:38','2025-03-15 15:27:55'),(32,'Fashion Hub','John Doe','mohamed.123hossny@gmail.com','+966500000002','Dhab','MH','$2y$10$JWe1F0Ry3QiAWh9ep2rQGuDxxHu/16RuAdJ.88wBsaATfJtDC1bWm','approved','2025-03-15 15:27:40','2025-03-15 15:27:57',NULL,'2025-03-15 15:27:40','2025-03-15 15:27:57'),(35,'XZ','ZX','mohamedhossnyahmed.123@gmail.com','+966500000003','Dhab','MH','$2y$10$XtFHhwxxp.fQsXnoYTmiDeSN29sExa7p4e2pGjOqsH4DL8hbGr7cO','rejected','2025-03-18 14:23:21',NULL,'2025-03-18 14:25:03','2025-03-18 14:23:21','2025-03-18 14:25:03'),(36,'CV','CV','mohamedhossnyahmed.123@gmail.com','+966500000011','Dhab','ADCB','$2y$10$rfxNElJ9THQOB8tcjWBHKOTDyJzgO27Zw.O6eUStQEw6Q8cDb63gi','pending','2025-03-18 14:45:41',NULL,NULL,'2025-03-18 14:45:41','2025-03-18 14:45:41'),(37,'SD','SD','mohamedhossnyahmed.123@gmail.com','+966500000011','Dhab','BNG','$2y$10$.oTp7yJxjEHrBPWUPrX7P.Dkjudkj9DHrw7.wCs403sMdNW3cNwW6','pending','2025-03-18 14:46:58',NULL,NULL,'2025-03-18 14:46:58','2025-03-18 14:46:58'),(38,'GHF','DFR','mohamed.123hossny@gmail.com','+966500000011','Dhab','DSW','$2y$10$Yn5g66Wz8yoQURqwqrgziOMmYOu5nyXf9MWBXrhYQlIUGO0T92mqq','pending','2025-03-18 14:47:43',NULL,NULL,'2025-03-18 14:47:43','2025-03-18 14:47:43'),(39,'FRE','RTE','mohamedhossnyahmed.123@gmail.com','+966500000003','Giza','FGD','$2y$10$vDeZzffpU83wa8FIKQTYwODM2NDydUAGyP42BvHCQOSUFL/edjRSa','pending','2025-03-18 14:55:37',NULL,NULL,'2025-03-18 14:55:37','2025-03-18 14:55:37'),(40,'WER','ASD','mohamed.123hossny@gmail.com','+966500000002','Dhab','VCD','$2y$10$DeXwWZ300aXbTZniWlO6E.VBb/wQU6ZWZfqQnjhT2eMYgXVqSy.GG','pending','2025-03-18 14:56:32',NULL,NULL,'2025-03-18 14:56:32','2025-03-18 14:56:32'),(41,'XC','CX','ih4510070@gmail.com','+966500000051','Dhab','MH','$2y$10$8gN41x0NyUb0tYwKLlaHL.k3VICmo.r94c1ovyW7AKz1bbmMu/zim','pending','2025-03-23 21:50:04',NULL,NULL,'2025-03-23 21:50:04','2025-03-23 21:50:04');
/*!40000 ALTER TABLE `merchantrequests` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `merchants`
--

DROP TABLE IF EXISTS `merchants`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `merchants` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `sellingCountry` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'saudiArabia',
  `merchantName` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '0',
  `username` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `store_id` bigint(20) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `merchants_email_unique` (`email`),
  UNIQUE KEY `merchants_username_unique` (`username`),
  KEY `merchants_store_id_foreign` (`store_id`),
  CONSTRAINT `merchants_store_id_foreign` FOREIGN KEY (`store_id`) REFERENCES `stores` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `merchants`
--

LOCK TABLES `merchants` WRITE;
/*!40000 ALTER TABLE `merchants` DISABLE KEYS */;
INSERT INTO `merchants` (`id`, `sellingCountry`, `merchantName`, `email`, `phone`, `status`, `username`, `password`, `remember_token`, `created_at`, `updated_at`, `store_id`) VALUES (1,'saudiArabia',NULL,'newemail@example.com','+966502548565',1,'ibrahimsamy308','$2y$10$UtXDA5rVN/jHQh.7nkADxOzvjHCfha82KD7ivCXP9xa/DFoXa9Fpu',NULL,'2025-03-10 17:30:31','2025-03-10 17:30:31',12),(4,'saudiArabia','El hima','ibrahimsamy308@gmail.com','+966502458757',1,'ibrahim308','$2y$10$jw8HLbxsys8TCHKTXxuo8OIST75DttZgtpSRnGTwjnWbLfHJ4O81O',NULL,'2025-03-11 11:46:25','2025-03-16 15:02:04',15);
/*!40000 ALTER TABLE `merchants` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `messages`
--

DROP TABLE IF EXISTS `messages`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `messages` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `subject` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `phone` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `message` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `messages`
--

LOCK TABLES `messages` WRITE;
/*!40000 ALTER TABLE `messages` DISABLE KEYS */;
INSERT INTO `messages` (`id`, `name`, `subject`, `email`, `phone`, `message`, `created_at`, `updated_at`) VALUES (1,'Gillian Shelton',NULL,'geniga@mailinator.com','+1 (984) 351-9192','Consequatur et et n','2025-04-08 20:58:58','2025-04-08 20:58:58'),(2,'Uta Glover',NULL,'panyvom@mailinator.com','+1 (482) 794-9718','Magni perspiciatis','2025-04-08 21:13:08','2025-04-08 21:13:08'),(3,'Boula Nessim Soliman',NULL,'nessimboula@gmail.com','01126785910','Hello','2025-04-22 21:36:52','2025-04-22 21:36:52'),(4,'Boula Nessim Soliman',NULL,'nessimboula@gmail.com','01126785910','Hello','2025-04-22 21:40:32','2025-04-22 21:40:32');
/*!40000 ALTER TABLE `messages` ENABLE KEYS */;
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
) ENGINE=InnoDB AUTO_INCREMENT=116 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `migrations`
--

LOCK TABLES `migrations` WRITE;
/*!40000 ALTER TABLE `migrations` DISABLE KEYS */;
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (1,'2014_04_02_124945_create_admins_table',1),(2,'2014_04_02_193005_create_translations_table',1),(3,'2014_10_12_000000_create_users_table',1),(4,'2014_10_12_100000_create_password_reset_tokens_table',1),(5,'2014_10_12_100000_create_password_resets_table',1),(6,'2016_06_01_000001_create_oauth_auth_codes_table',1),(7,'2016_06_01_000002_create_oauth_access_tokens_table',1),(8,'2016_06_01_000003_create_oauth_refresh_tokens_table',1),(9,'2016_06_01_000004_create_oauth_clients_table',1),(10,'2016_06_01_000005_create_oauth_personal_access_clients_table',1),(11,'2017_04_08_163453_create_world_cities_locale_table',1),(12,'2017_04_08_163453_create_world_cities_table',1),(13,'2017_04_08_163453_create_world_continents_locale_table',1),(14,'2017_04_08_163453_create_world_continents_table',1),(15,'2017_04_08_163453_create_world_countries_locale_table',1),(16,'2017_04_08_163453_create_world_countries_table',1),(17,'2017_04_08_163453_create_world_divisions_locale_table',1),(18,'2017_04_08_163453_create_world_divisions_table',1),(19,'2017_04_08_163454_add_foreign_keys_to_world_cities_locale_table',1),(20,'2017_04_08_163454_add_foreign_keys_to_world_cities_table',1),(21,'2017_04_08_163454_add_foreign_keys_to_world_continents_locale_table',1),(22,'2017_04_08_163454_add_foreign_keys_to_world_countries_locale_table',1),(23,'2017_04_08_163454_add_foreign_keys_to_world_countries_table',1),(24,'2017_04_08_163454_add_foreign_keys_to_world_divisions_locale_table',1),(25,'2017_04_08_163454_add_foreign_keys_to_world_divisions_table',1),(26,'2019_08_19_000000_create_failed_jobs_table',1),(27,'2019_12_14_000001_create_personal_access_tokens_table',1),(28,'2022_10_21_075806_create_categories_table',1),(29,'2022_10_22_075805_create_stores_table',1),(30,'2022_10_22_075806_create_banners_table',1),(31,'2022_10_22_075806_create_brands_table',1),(32,'2022_10_22_075806_create_colors_table',1),(33,'2022_10_22_075806_create_sizes_table',1),(34,'2022_10_22_075806_create_subcategories_table',1),(35,'2022_10_23_075806_create_faqs_table',1),(36,'2022_10_23_075806_create_offers_table',1),(37,'2022_10_23_075806_create_productOffers_table',1),(38,'2022_10_23_075806_create_products_table',1),(39,'2022_10_23_075846_create_settings_table',1),(40,'2022_10_26_125729_create_pages_table',1),(41,'2022_10_29_155126_create_messages_table',1),(42,'2022_10_29_155126_create_newsletters_table',1),(43,'2022_10_29_155126_create_orders_table',1),(44,'2022_11_26_153759_create_orderproducts_table',1),(45,'2022_11_26_154654_create_contacts_table',1),(46,'2023_06_26_173744_create_permission_tables',1),(47,'2023_06_27_170717_create_banner_translations_table',1),(48,'2023_06_27_170717_create_brand_translations_table',1),(49,'2023_06_27_170717_create_category_translations_table',1),(50,'2023_06_27_170717_create_color_translations_table',1),(51,'2023_06_27_170717_create_faq_translations_table',1),(52,'2023_06_27_170717_create_offer_translations_table',1),(53,'2023_06_27_170717_create_product_translations_table',1),(54,'2023_06_27_170717_create_size_translations_table',1),(55,'2023_06_27_170717_create_store_translations_table',1),(56,'2023_06_27_170717_create_subcategory_translations_table',1),(57,'2023_06_28_105000_create_files_table',1),(58,'2023_06_28_175550_create_setting_translations_table',1),(59,'2023_06_28_180243_create_page_translations_table',1),(60,'2023_10_23_075806_create_productVariations_table',1),(61,'2023_11_22_170717_create_productVariation_translations_table',1),(62,'2025_01_09_133939_add_youtibe_link_to_pages_table',1),(63,'2025_01_18_153527_create_storeBrands_table',1),(64,'2025_01_18_153527_create_storeCategories_table',1),(65,'2025_02_04_131459_add_cart_to_users_table',1),(66,'2025_02_05_092041_add_sort_is_top_to_brands',1),(67,'2025_02_06_142130_create_addresses_table',1),(68,'2025_02_09_093328_add_status_to_orders',1),(69,'2025_02_09_114426_remove_address_from_table',1),(70,'2025_02_09_135754_add_current_to_addresses',1),(71,'2025_02_09_140613_add_cancel_reason_to_orders_table',1),(72,'2025_02_13_091838_add_variation_id_to_orderproducts_table',2),(73,'2025_02_16_134128_create_temb_orders_table',2),(74,'2025_02_16_135542_create_temb_order_products_table',2),(75,'2025_02_16_145447_add_balance_to_users_table',2),(76,'2025_02_18_082138_add_color_to_products_table',3),(77,'2025_02_17_145447_add_transaction_reference_to_orders_table',4),(78,'2025_02_18_082138_add_status_to_users_table',4),(79,'2025_02_18_133958_add_columns_to_orders_table',5),(80,'2025_02_20_155447_add_payment_name_to_orders_table',6),(81,'2025_02_22_155447_add_paid_at_to_orders_table',7),(82,'2025_02_18_133959_add_columns_to_orders_table',8),(83,'2022_10_22_075806_create_sliders_table',9),(84,'2023_06_27_170717_create_slider_translations_table',9),(85,'2025_02_23_182138_add_fcm_to_users_table',10),(86,'2025_02_26_111904_create_transactions_table',11),(87,'2025_02_26_141557_add_column_to_colors_table',12),(88,'2025_03_02_095625_update_status_comment_in_orders_table',13),(89,'2025_03_02_101355_rename_failed_at_to_returned_at_in_orders_table',13),(90,'2025_03_03_145912_add_uuid_to_users_table',14),(91,'2025_03_09_105322_create_merchantRequests_table',15),(92,'2025_03_6_145915_create_merchants_table',15),(93,'2025_03_09_145912_add_category_to_banners_table',16),(94,'2025_03_10_110518_add_merchant_name_to_merchants_table',17),(95,'2025_03_10_110519_add_merchant_id_to_stores_table',17),(96,'2025_03_12_122719_create_product_requests_table',18),(97,'2022_10_23_075806_create_itemRequests_table',19),(98,'2023_06_27_170717_create_itemRequest_translations_table',19),(99,'2025_03_19_145912_add_type_to_banners_table',19),(100,'2025_03_19_122719_create_favorites_table',20),(101,'2024_05_18_143428_create_b_settings_table',21),(102,'2025_03_24_104820_add_new_fields_to_settings_table',21),(103,'2025_03_26_110624_add_otp_to_users_table',22),(104,'2025_03_19_114309_add_columns_to_item_requests_tables',23),(105,'2025_03_19_114309_add_variationImages_to_item_requests_tables',23),(106,'2025_03_26_110624_add_price_to_products_table',23),(107,'2025_03_30_193701_remove_variation_from_orderproducts',24),(108,'2025_04_08_125839_add_title_and_subtitle_to_slider_translations_table',25),(109,'2025_04_09_104636_update_orders_table_replace_address_id_with_address',24),(110,'2025_04_09_105414_add_type_to_categories_table',26),(111,'2022_10_22_075806_create_chooseUss_table',27),(112,'2023_06_27_170717_create_chooseUs_translations_table',27),(113,'2022_10_26_125729_create_services_table',28),(114,'2023_06_28_180243_create_service_translations_table',28),(115,'2025_07_17_143957_add_is_addition_to_products_table',29);
/*!40000 ALTER TABLE `migrations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `model_has_permissions`
--

DROP TABLE IF EXISTS `model_has_permissions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `model_has_permissions` (
  `permission_id` bigint(20) unsigned NOT NULL,
  `model_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `model_id` bigint(20) unsigned NOT NULL,
  PRIMARY KEY (`permission_id`,`model_id`,`model_type`),
  KEY `model_has_permissions_model_id_model_type_index` (`model_id`,`model_type`),
  CONSTRAINT `model_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `model_has_permissions`
--

LOCK TABLES `model_has_permissions` WRITE;
/*!40000 ALTER TABLE `model_has_permissions` DISABLE KEYS */;
/*!40000 ALTER TABLE `model_has_permissions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `model_has_roles`
--

DROP TABLE IF EXISTS `model_has_roles`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `model_has_roles` (
  `role_id` bigint(20) unsigned NOT NULL,
  `model_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `model_id` bigint(20) unsigned NOT NULL,
  PRIMARY KEY (`role_id`,`model_id`,`model_type`),
  KEY `model_has_roles_model_id_model_type_index` (`model_id`,`model_type`),
  CONSTRAINT `model_has_roles_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `model_has_roles`
--

LOCK TABLES `model_has_roles` WRITE;
/*!40000 ALTER TABLE `model_has_roles` DISABLE KEYS */;
INSERT INTO `model_has_roles` (`role_id`, `model_type`, `model_id`) VALUES (1,'App\\Models\\Admin',2),(1,'App\\Models\\Admin',5);
/*!40000 ALTER TABLE `model_has_roles` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `newsletters`
--

DROP TABLE IF EXISTS `newsletters`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `newsletters` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `newsletterEmail` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `newsletters_newsletteremail_unique` (`newsletterEmail`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `newsletters`
--

LOCK TABLES `newsletters` WRITE;
/*!40000 ALTER TABLE `newsletters` DISABLE KEYS */;
INSERT INTO `newsletters` (`id`, `newsletterEmail`, `created_at`, `updated_at`) VALUES (1,'ibrahimsamy308@gmail.com','2025-02-12 09:07:53','2025-02-12 09:07:53'),(2,'Kero@gmail.com','2025-02-12 09:07:53','2025-02-12 09:07:53'),(3,'ibrahim@gmail.com','2025-02-12 09:07:53','2025-02-12 09:07:53'),(4,'nessimboula@gmail.com','2025-04-08 21:08:59','2025-04-08 21:08:59'),(5,'nagroup268@gmail.com','2025-06-26 21:17:39','2025-06-26 21:17:39'),(6,'Shahdmfawzy956@gmail.com','2025-08-18 18:08:14','2025-08-18 18:08:14');
/*!40000 ALTER TABLE `newsletters` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `oauth_access_tokens`
--

DROP TABLE IF EXISTS `oauth_access_tokens`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `oauth_access_tokens` (
  `id` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint(20) unsigned DEFAULT NULL,
  `client_id` bigint(20) unsigned NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `scopes` text COLLATE utf8mb4_unicode_ci,
  `revoked` tinyint(1) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `expires_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `oauth_access_tokens_user_id_index` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `oauth_access_tokens`
--

LOCK TABLES `oauth_access_tokens` WRITE;
/*!40000 ALTER TABLE `oauth_access_tokens` DISABLE KEYS */;
INSERT INTO `oauth_access_tokens` (`id`, `user_id`, `client_id`, `name`, `scopes`, `revoked`, `created_at`, `updated_at`, `expires_at`) VALUES ('0068efc1139e9c4aa8113f0653c0b7692c54f530723d154a678ea2acbd82753f5967272b70ae1bf6',19,1,'API Token','[]',0,'2025-03-09 15:28:10','2025-03-09 15:28:10','2026-03-09 15:28:10'),('00b8bdd60afe8fd4c625755e22066fd3af9aec0b8444eec35f5b28b00bfbc694d9c44bf7393592de',19,1,'API Token','[]',0,'2025-03-20 14:08:09','2025-03-20 14:08:09','2026-03-20 14:08:09'),('014671211be327438e8823d19126c7a7e61452b436dfea0f81b395c8e7559a2b7819bd768938e8ee',19,1,'API Token','[]',0,'2025-03-16 12:52:53','2025-03-16 12:52:53','2026-03-16 12:52:53'),('029a1424ba8ab88e2f49ca2a6aaf4ac15f6cddfe462ea02727959c7acd76b08112ec8108aeccaf80',20,1,'API Token','[]',0,'2025-02-24 09:51:38','2025-02-24 09:51:38','2026-02-24 09:51:38'),('0484ba032569c391fde6f4a997859f86706051f20c50d94cb6f064815be8f00fa9b437d110aad900',19,1,'API Token','[]',0,'2025-03-24 12:56:10','2025-03-24 12:56:10','2026-03-24 12:56:10'),('063857ae06687cd174810fe11f9bed7cee1612d6fc1deee2fe955214c63a26574699dad705383ee3',63,1,'API Token','[]',0,'2025-03-15 19:16:36','2025-03-15 19:16:36','2026-03-15 19:16:36'),('06ad2bf1066220128d7831d26e07c90d9123cc2871faf69698e6ed7c5caf485396e509a5f1ef572b',6,1,'API Token','[]',0,'2025-02-13 15:12:51','2025-02-13 15:12:51','2026-02-13 15:12:51'),('07fc983f7648d01c2578ae9a0db0ab6de9554f239acf8ca27fff587ddcb43aaebf481bbf054a399b',5,1,'API Token','[]',0,'2025-02-13 12:19:12','2025-02-13 12:19:12','2026-02-13 12:19:12'),('08508a7aeea9fd7e2de24e342b8fa58a6076d2859d25e51750a2666f979ce2976c050586a3cbfe88',26,1,'API Token','[]',0,'2025-03-16 11:54:51','2025-03-16 11:54:51','2026-03-16 11:54:51'),('08a12cdd6d1404bf0b1335b46b57c09e28b5131f6ff8d0289531b17f5bb8ca147b661d0022f617be',70,1,'API Token','[]',0,'2025-03-23 11:30:00','2025-03-23 11:30:00','2026-03-23 11:30:00'),('092562a0990a85e32fd562df1e769e9a88cb7a773c30eec01380dd4004b1882cbd805656b0b59f93',10,1,'API Token','[]',0,'2025-02-13 08:19:56','2025-02-13 08:19:57','2026-02-13 08:19:56'),('0a31fde327808dcb15158517ddc59a1fcad25822a53d50636bf9e0dc7f84da61c396ca0747b4ffde',1,1,'API Token','[]',0,'2025-03-17 11:40:03','2025-03-17 11:40:03','2026-03-17 11:40:03'),('0ac94ed64aa59757e2232706f9b476b0ec4f5e33bda1fa8a7fefce92b07c005fff8e3ac99398ab0c',6,1,'API Token','[]',0,'2025-02-13 22:18:28','2025-02-13 22:18:28','2026-02-13 22:18:28'),('0cf2119518b9152e4fbf47fb180e51043f569af956622efca0fd361d5543377c735deb04f1a524e7',19,1,'API Token','[]',0,'2025-03-09 22:09:40','2025-03-09 22:09:40','2026-03-09 22:09:40'),('0d7a24468b22ead1a553c257709e7e57ad7b5e93ff814b436e51654df3c3ba8de52cbadf2aa62a39',6,1,'API Token','[]',0,'2025-02-13 15:11:06','2025-02-13 15:11:06','2026-02-13 15:11:06'),('0e0c76e462c9096fd696ea7476e274a5d71d7bb64ea8d43df2c8db2fbef8b8b3c779863b640091c6',1,1,'API Token','[]',0,'2025-02-21 20:52:31','2025-02-21 20:52:31','2026-02-21 20:52:31'),('0f2ece508d1b08cfc2057a81fdc9a027b5b4a55c570be9132ba4b4595549e441f09745697871825d',26,1,'API Token','[]',0,'2025-03-19 00:45:54','2025-03-19 00:45:54','2026-03-19 00:45:54'),('10780fc10588b3eb53cb206b0f8272409d71f8ac88e2833d32db143b3f041bf5cb21e66088537326',19,1,'API Token','[]',0,'2025-03-19 21:38:08','2025-03-19 21:38:08','2026-03-19 21:38:08'),('111d6759d76c0684aeb531d26169acc10c0666a6af4e5ce50b555da8acaa339891938d0459286a66',33,1,'API Token','[]',0,'2025-02-24 10:05:38','2025-02-24 10:05:38','2026-02-24 10:05:38'),('1156a21d290b64ae12e2f470bc58b8e20165a7f80a8c5af79887bbfec77698d53853bd6e776c20b5',19,1,'API Token','[]',0,'2025-03-05 09:39:36','2025-03-05 09:39:36','2026-03-05 09:39:36'),('138e5b25e2fa7458ecd914f6e2ee9701a5f49ad6f8804b8a45c305f0950469177e3ffed587d12efa',64,1,'API Token','[]',0,'2025-03-24 03:59:32','2025-03-24 03:59:32','2026-03-24 03:59:32'),('14674627ed90635a1512688eadbd3a21253ae2ac010f3aca378afb37a9cf557d434e76b9c3033c65',56,1,'API Token','[]',0,'2025-03-05 12:15:40','2025-03-05 12:15:40','2026-03-05 12:15:40'),('1533aa6cd5c7398785650d7ed7aaf06e9eca594601fc27421ed40710ed95b84be41b566b501e3053',26,1,'API Token','[]',0,'2025-03-19 01:31:53','2025-03-19 01:31:53','2026-03-19 01:31:53'),('1555b2c4865bc4f617bb8f594972fedc003ce96cb95f51e107ae90c817613aff52c5d0d5534d3b9e',64,1,'API Token','[]',0,'2025-03-17 19:22:01','2025-03-17 19:22:02','2026-03-17 19:22:01'),('158b300166b107f9b1a45253545186d56a34c92a5bb97fd0740965fff37424e822d7a231d9d2c811',20,1,'API Token','[]',0,'2025-02-19 13:59:23','2025-02-19 13:59:23','2026-02-19 13:59:23'),('15d0a1b41b3d341d6453676d6f9457a4175b82acd843bd8db9beab3747028a9eaa703fe55cf90de6',1,1,'API Token','[]',0,'2025-04-07 20:27:36','2025-04-07 20:27:36','2026-04-07 15:27:36'),('19509e9ee7f1f54236db4602f370b64a82e31351b86ef0f98c05935619d85ad1488a783a8de0b325',1,1,'API Token','[]',0,'2025-03-05 12:31:43','2025-03-05 12:31:43','2026-03-05 12:31:43'),('19b948cdfceefeec670423a2a7a95a6c205654e8436e7427a174600ec6fd00564d59012a68249f98',26,1,'API Token','[]',0,'2025-03-16 11:54:51','2025-03-16 11:54:51','2026-03-16 11:54:51'),('19de9a40d56ac7ad7979e85dafc7ce174b4e23f7efe75b4b344ff018d42298710da6206dfa34429f',1,1,'API Token','[]',0,'2025-02-25 09:51:00','2025-02-25 09:51:00','2026-02-25 09:51:00'),('1a1452a76d1a03d874fa2e800f6c69d9c4346d7b9f819b10a0cfd9b4d4d955f6f21342ff11bf8eea',6,1,'API Token','[]',0,'2025-02-16 11:07:34','2025-02-16 11:07:34','2026-02-16 11:07:34'),('1a391d32e6235625e5ea46616a3aa29594e301e913f993c25b0d065ddafcab5288b66286365e1d14',19,1,'API Token','[]',0,'2025-03-24 10:15:46','2025-03-24 10:15:46','2026-03-24 10:15:46'),('1a54edab6b717ac822fd6134f0237a2be8f84cedd950f5b3ecdab2f0e590f48da8c90f32b7f8157a',26,1,'API Token','[]',0,'2025-03-19 01:36:24','2025-03-19 01:36:24','2026-03-19 01:36:24'),('1c2e204bc3cb3eb374da28a64199eec501688c6cd1cba37c55d4409516e17692f2c239cf67009597',1,1,'API Token','[]',0,'2025-03-30 18:41:20','2025-03-30 18:41:20','2026-03-30 13:41:20'),('1c794ae09713f14198476aff9c44e5e402c674d2e96700cbc252d59a24e86efca6cb3c3ae5d43ef0',5,1,'API Token','[]',0,'2025-02-13 07:51:21','2025-02-13 07:51:21','2026-02-13 07:51:21'),('1e05736e1486596ed7ae98edb201f4d7d3a64bc5953e03bfa1d7497082f69b58d144821c7c443ae6',1,1,'API Token','[]',0,'2025-02-25 12:09:55','2025-02-25 12:09:55','2026-02-25 12:09:55'),('1e5bcfe92f2a365783ae553d0263f1824bf265a1a392e0bf17959ebb735e1d687f3f4794349909a2',79,1,'API Token','[]',0,'2025-03-30 19:09:14','2025-03-30 19:09:14','2026-03-30 14:09:14'),('1e815aceea555f2b821b3bb12a9cce295720700aa17958486e142931335ce64becfcf7372e3f8bf0',65,1,'API Token','[]',0,'2025-03-24 04:44:15','2025-03-24 04:44:15','2026-03-24 04:44:15'),('2190cc99f78a43b865a4c7dbc327bcdf85422b41554b45d994cedb2dc616e8fc57e1c4f3e29875b5',53,1,'API Token','[]',0,'2025-03-17 18:38:38','2025-03-17 18:38:38','2026-03-17 18:38:38'),('2210ddcdad8f365cb2899c8bc832b2f223619aad831e394f0c696b6f109e52cd8eb33cab99c6abb4',64,1,'API Token','[]',0,'2025-03-17 19:27:49','2025-03-17 19:27:49','2026-03-17 19:27:49'),('22e44d74b46eb1b9dcd688e4de94671e5ee3710e7df32820cbc13b948255c49661b1b7d046cbac36',19,1,'API Token','[]',0,'2025-03-24 06:52:10','2025-03-24 06:52:10','2026-03-24 06:52:10'),('231504a9c22fcf496b048c69cfe4421f19f91ea0357ef14870551329e63a2e2b7550c068bae87c4b',1,1,'API Token','[]',0,'2025-04-07 19:49:54','2025-04-07 19:49:55','2026-04-07 14:49:54'),('251a99ee12b4a24e9caf5fbe80c3a88590f8d8f463db80bca30abd8d6fb95f6d6a541eed2ba6c119',26,1,'API Token','[]',0,'2025-02-25 17:24:30','2025-02-25 17:24:30','2026-02-25 17:24:30'),('27fe791f393a649d64774145dc84f2531af5a4485ff1bf2dd836229d16e7c2a7edc6d6bc06e94817',74,1,'API Token','[]',0,'2025-03-25 03:17:27','2025-03-25 03:17:27','2026-03-25 03:17:27'),('2908622629b03a2b045971b453af91393cd86db17b0de14f0c08c7babfc11968bbfc7d7999e81d69',26,1,'API Token','[]',0,'2025-03-12 22:00:12','2025-03-12 22:00:12','2026-03-12 22:00:12'),('29f873445a8b23b1a01e6a76aa1fda5ddaf4ba4bf6ff0653b58a70f91d1fb422e08ca9b6c426ed08',6,1,'API Token','[]',0,'2025-02-13 15:17:59','2025-02-13 15:17:59','2026-02-13 15:17:59'),('2a4d7a3e27698bfb48d52cc8d570e5d7374c904339d6004cd34f3e7b86877a99230fd67406df2380',87,1,'API Token','[]',0,'2025-08-13 16:21:35','2025-08-13 16:21:35','2026-08-13 11:21:35'),('2ccf8ab63458f64d739a9b767a88fcf7ad64750fc20e95a593ed89890caa0a46d4b5ee67bdce0856',20,1,'API Token','[]',0,'2025-02-23 16:43:46','2025-02-23 16:43:46','2026-02-23 16:43:46'),('2d56ee8d272b659a31191df7d23ed95e84dda3f7aaefb292971bbcd3f20ea1b6635fcda19854d727',19,1,'API Token','[]',0,'2025-03-19 21:35:52','2025-03-19 21:35:52','2026-03-19 21:35:52'),('2f3037cdbffa29b92d7eac3cd4a0221e9230ff271843c04b3ab5ba97324d32aad4209a24af5b4d72',19,1,'API Token','[]',0,'2025-03-16 13:05:21','2025-03-16 13:05:21','2026-03-16 13:05:21'),('2f741516877bbe93eeb63604a9eff134bb22ad76eff47642dbe18b72b11ae6b299f60fa5fd81f2b0',20,1,'API Token','[]',0,'2025-02-22 17:48:37','2025-02-22 17:48:37','2026-02-22 17:48:37'),('2f8c1306853e2ddea53dd3d83860ca96bb6dc1160f7fbd69d1faff8eab699d4073c42cb265f4b973',19,1,'API Token','[]',0,'2025-03-23 13:08:37','2025-03-23 13:08:37','2026-03-23 13:08:37'),('3115283d8e3742a2a8cb587d1611e004564574c8f101b7ecafa0b05c3bffaf85abe35f9b8405b6af',5,1,'API Token','[]',0,'2025-02-13 15:18:27','2025-02-13 15:18:27','2026-02-13 15:18:27'),('318eafc26784282594616109f3e4df8661e9b70ee049f60eeefeebae0c0de6f5911460c8fd95bc38',19,1,'API Token','[]',0,'2025-03-24 11:00:36','2025-03-24 11:00:36','2026-03-24 11:00:36'),('31979c8d82452d150eb08a25ca9603d552e942673f37fc8063ac64941678eded784b18a7cfce36f5',30,1,'API Token','[]',0,'2025-02-26 15:23:53','2025-02-26 15:23:53','2026-02-26 15:23:53'),('3207454fb5c0dd526131c700341d15399e4a1c16a7917bc703110267d6f4a15e13e6256c21fd4cc2',88,1,'API Token','[]',0,'2025-09-19 03:12:31','2025-09-19 03:12:31','2026-09-18 22:12:31'),('327ace98d17a475be75d901ae59c6c90c60ec9516dfcae0d6266f809ce8c5550edc3b9f48715cdb5',1,1,'API Token','[]',0,'2025-03-30 18:39:39','2025-03-30 18:39:39','2026-03-30 13:39:39'),('32d6cf3221b6cade561fd3a80004abfe5c7e7e9d8e927357389bd73499dab17ac828ce24ac27c6bd',11,1,'API Token','[]',0,'2025-02-18 09:07:27','2025-02-18 09:07:27','2026-02-18 09:07:27'),('33701089d902d2b34e789b80980135e79b309072dd8324df7ea470973cd7a4039575f23e77440dc5',19,1,'API Token','[]',0,'2025-03-24 10:52:51','2025-03-24 10:52:51','2026-03-24 10:52:51'),('33c2f771098f285daaa79734a88db965133ab82132d296408508eac314713ff258d9ba493ff1b155',11,1,'API Token','[]',0,'2025-02-13 11:48:55','2025-02-13 11:48:55','2026-02-13 11:48:55'),('35a879c1e49d8331ff16d4258cf589c16e5f730cc22f1cdb6901b8bb58aaf1670987ea5ea6ccb4ff',31,1,'API Token','[]',0,'2025-03-04 12:14:54','2025-03-04 12:14:54','2026-03-04 12:14:54'),('369e1fa2df49de20f4b49dc65695c4058ad5aab9ab0b1e034601860abd0ec9dcd2aa3e98609326cf',53,1,'API Token','[]',0,'2025-03-18 10:29:31','2025-03-18 10:29:31','2026-03-18 10:29:31'),('37a0054f41f7d23badea3c42dfa40800f8f22127962d60debea62979cdb8fecdb3d17a0ca3a631ed',19,1,'API Token','[]',0,'2025-02-19 13:54:50','2025-02-19 13:54:50','2026-02-19 13:54:50'),('3957c66cfc4dcb94724866b6def822e136e526477fb4c9170dcf1e36e0af6a94acb2865337e85d79',36,1,'API Token','[]',0,'2025-03-02 14:22:38','2025-03-02 14:22:38','2026-03-02 14:22:38'),('3a0ac04bc62eed024ca98e66a34ba8998169111a6c55174c74047a091b911b3cb512645668571d3d',52,1,'API Token','[]',0,'2025-03-05 09:13:26','2025-03-05 09:13:26','2026-03-05 09:13:26'),('3a7656e38a8034e58fbbc37f75ce071b4c089782c505eae9362bc534211dca950a41e1eda7c300ae',81,1,'API Token','[]',0,'2025-04-08 21:58:42','2025-04-08 21:58:42','2026-04-08 16:58:42'),('3aa75a9085f454ade60007026c48f1d42470b023452f8b1c57acf19a04ef4b93a907180fe5d17903',86,1,'API Token','[]',0,'2025-08-13 16:25:22','2025-08-13 16:25:22','2026-08-13 11:25:22'),('3af40134978188ab9e2223736365ff1c3c89c2ff2d04b7700b91ca6e5a61e9eb31c38a01b2c179df',64,1,'API Token','[]',0,'2025-03-17 19:05:35','2025-03-17 19:05:35','2026-03-17 19:05:35'),('40ac153f107878c65507d3fede8863f2c1b694c4aea4f3afe55d173703b10e576972eb78629be6cc',1,1,'API Token','[]',0,'2025-03-05 13:11:25','2025-03-05 13:11:25','2026-03-05 13:11:25'),('410fa5d0f774ecc44677f62ebc33be1883cf0951929252f38a9dc9cbe16c128a0b41a87c97e8fd48',19,1,'API Token','[]',0,'2025-02-19 21:07:14','2025-02-19 21:07:14','2026-02-19 21:07:14'),('4250d0de8ad08e8b6e3c242e64738d781bcf1341bf4893ea4d002f5845d2273d79682018d04bab1c',80,1,'API Token','[]',0,'2025-04-08 21:18:57','2025-04-08 21:18:57','2026-04-08 16:18:57'),('43278d4e7a28a161d8f2b34a6dd642106b0c9f501b8c23fb9ac2bc9502d437921acbbe9ef0566828',20,1,'API Token','[]',0,'2025-02-25 19:33:53','2025-02-25 19:33:53','2026-02-25 19:33:53'),('4481aab75e7b8acfae7c1b86ac5e06df5d61ca46423ccb9e531f93b27dd10b4dd23a3c0c169c9fdd',19,1,'API Token','[]',0,'2025-03-24 09:49:01','2025-03-24 09:49:01','2026-03-24 09:49:01'),('45d40f8278507f08c2f0c34406bf79f05a6f8b96341a1f96e9af0f51f5c93a44531b3da4aed40a17',36,1,'API Token','[]',0,'2025-02-25 18:22:33','2025-02-25 18:22:33','2026-02-25 18:22:33'),('47732884e5a3700f2c8a20e2e11934af08a00aa66c36c1054988eb6fad9ec36c66c232c6d5d077c1',9,1,'API Token','[]',0,'2025-02-13 08:11:29','2025-02-13 08:11:29','2026-02-13 08:11:29'),('47d58202068dcd4f75c03daecc1974c5834ebdb4d4119dcf53a649052f3e12f84665dd5ae58c2dc4',20,1,'API Token','[]',0,'2025-02-19 13:59:19','2025-02-19 13:59:19','2026-02-19 13:59:19'),('48310ad6f4d8d0096e7cb33bc0469e72f964c96791587883df968ba3b64afb69b7d10d082b835b68',64,1,'API Token','[]',0,'2025-03-24 03:17:06','2025-03-24 03:17:06','2026-03-24 03:17:06'),('4885cdb5aaa1876385aa3515eb71a19a2c348a309367fb10bc78f1b04cf662af12d176ec0a771bbc',1,1,'API Token','[]',0,'2025-02-20 17:21:42','2025-02-20 17:21:42','2026-02-20 17:21:42'),('49f309cb68dc9aedfbe27a7095a80c9cc46df9f667217c1d8e26344dceff2dc0f5848a0b2566a573',20,1,'API Token','[]',0,'2025-02-25 11:08:07','2025-02-25 11:08:07','2026-02-25 11:08:07'),('4a60973e7959a738d4e42be5d06ba21a8a11bdd7f85b365c2d43c5a469170b26738e567c74d2e05a',2,1,'API Token','[]',0,'2025-07-21 01:09:03','2025-07-21 01:09:03','2026-07-20 20:09:03'),('4b0b0c08dab224963fb4abf4a2aff553150881812bb1a6f3eeb8087cf2492fed0733f6c3910d22b9',85,1,'API Token','[]',0,'2025-06-07 17:49:19','2025-06-07 17:49:19','2026-06-07 12:49:19'),('4b3f51dbdc58d1fd40cff668d33946e37a8ac369011b98ccc9fb75f2bc66ee99794cac0fd68f0a94',20,1,'API Token','[]',0,'2025-02-26 19:22:40','2025-02-26 19:22:40','2026-02-26 19:22:40'),('4d3340a6167e74d73628826236f7eabec5f28ad802eb42deb887d178c1592aa34ad50657a56604d7',54,1,'API Token','[]',0,'2025-03-05 10:16:43','2025-03-05 10:16:43','2026-03-05 10:16:43'),('4e0eb2a48c0301419d2967915c3d81eb2991dc84c776b87d9c07ea58d24e5a250f9b07fc8727bea3',1,1,'API Token','[]',0,'2025-02-25 08:41:20','2025-02-25 08:41:20','2026-02-25 08:41:20'),('4fc420d0c40e88cf32870473111365ad6d9c4ed945c2397df39da45e1ec4ccc24943a9522d025ef7',11,1,'API Token','[]',0,'2025-02-13 11:44:12','2025-02-13 11:44:12','2026-02-13 11:44:12'),('505d783ad22d5738b140986fdd76a71c08a0ee11041a98347f205aa34b3105ad211b1afa6a0a34ba',19,1,'API Token','[]',0,'2025-03-19 22:01:13','2025-03-19 22:01:13','2026-03-19 22:01:13'),('509926d0bbab54200e9b3a9b340f4055ac8167486aeac4240310b5b1be827907004e089acce8af44',1,1,'API Token','[]',0,'2025-03-31 01:57:18','2025-03-31 01:57:18','2026-03-30 20:57:18'),('50b0c9d9ff44fc57bb98b67cce2169d0d96dc7566af1c5492c95c5f9f1d9a0a379ea4d79f9086366',25,1,'API Token','[]',0,'2025-02-23 17:23:10','2025-02-23 17:23:10','2026-02-23 17:23:10'),('512b474ea41d6068f34cff24c30855056d1bdf0082973aa321f689ac0819240b5df1d7e926feb8d4',88,1,'API Token','[]',0,'2025-09-19 02:14:16','2025-09-19 02:14:16','2026-09-18 21:14:16'),('5362b227e0e9b1be6e093fd6178094bf53652943e857f9f07452cc57361a2d4e0cd355f7c22364d9',20,1,'API Token','[]',0,'2025-02-22 20:11:39','2025-02-22 20:11:39','2026-02-22 20:11:39'),('5372050c6de040ec6f386f388c8c3d22a0130d4ad7fe41fd88419d74f079e920375a11e7bdca2e40',1,1,'API Token','[]',0,'2025-04-07 19:38:27','2025-04-07 19:38:27','2026-04-07 14:38:27'),('53914d11abd488caff5b2794bd89518bcd575339d954c9a171abb5db5d9731ed4071842755fcf529',1,1,'API Token','[]',0,'2025-03-30 16:45:34','2025-03-30 16:45:35','2026-03-30 11:45:34'),('53a2c93dad4fbf10bd0f1ba7000373a18441373a8950fd22f57bd54c47eeb04c40a45aa4427c9d35',6,1,'API Token','[]',0,'2025-02-16 12:46:03','2025-02-16 12:46:03','2026-02-16 12:46:03'),('54459805e7824c6acc968119f35ca5f4278425781cf1ae21d64c74572b523378c353df14f7171a26',19,1,'API Token','[]',0,'2025-03-19 21:38:41','2025-03-19 21:38:41','2026-03-19 21:38:41'),('55074ee958249f04f8acfc30f01be48c1bacc3496ebe5bdebb2f19e79a8474263b3a254a1f1db0e4',72,1,'API Token','[]',0,'2025-03-24 10:58:01','2025-03-24 10:58:01','2026-03-24 10:58:01'),('5600f46b5fb0d3e45519691fbabe7ceda6ad70383ea83b2d990eb03e67453632669224245fe4b415',25,1,'API Token','[]',0,'2025-02-23 11:06:50','2025-02-23 11:06:50','2026-02-23 11:06:50'),('571b904fb2545c2d7e09487d52853160e9bacbd61c9365f0692e6646e3376d069393973990ec63ec',58,1,'API Token','[]',0,'2025-03-05 12:19:52','2025-03-05 12:19:52','2026-03-05 12:19:52'),('575ff77b88035fcf3299c58f85e1c4c8a450242a9b7d6225db23c5f47b359fe1a2cccdb6d977d83f',84,1,'API Token','[]',0,'2025-04-18 19:59:52','2025-04-18 19:59:52','2026-04-18 14:59:52'),('57d869e2603ac8d5e0ea6f4fbb98aee706a6133de1ce2aa1cd6e4fe489c0683e0fe369fa5ea41675',59,1,'API Token','[]',0,'2025-03-05 12:44:13','2025-03-05 12:44:13','2026-03-05 12:44:13'),('57ee7ea7af573f9781dd021a2f26e3f5328d01749db2609542e6b03df3a93ce360ccfc9f100488ac',49,1,'API Token','[]',0,'2025-03-02 22:31:14','2025-03-02 22:31:14','2026-03-02 22:31:14'),('57feefc034876b373e607aefc3c6b649550f7a2c9fe4e0b9b9e6afd4c0580c2a1f6593545ad13266',1,1,'API Token','[]',0,'2025-03-02 14:54:07','2025-03-02 14:54:07','2026-03-02 14:54:07'),('58971f55dc36a4391e4135c6820bd580a8d2bd41c056aa614d21e5727c892b97b70d4cccea65ce19',1,1,'API Token','[]',0,'2025-03-30 19:17:47','2025-03-30 19:17:47','2026-03-30 14:17:47'),('59f57d564de4515bc58a3319ba369b708013dec6abcbaaf057bf1bb745b42f9a77d20c5a5ce20c9e',26,1,'API Token','[]',0,'2025-03-15 20:32:18','2025-03-15 20:32:18','2026-03-15 20:32:18'),('5a7babb0d146f0b4d9904f56d2a97900c72e5591d63966d7d83b5794db0283985693a5539f20e255',61,1,'API Token','[]',0,'2025-03-08 17:10:23','2025-03-08 17:10:23','2026-03-08 17:10:23'),('5ba902fe6cb3bead809dc4bef2387c4ba2f962b8626eb67a8607994bf3deef6824a47d14fed9f536',20,1,'API Token','[]',0,'2025-02-26 15:25:21','2025-02-26 15:25:21','2026-02-26 15:25:21'),('5cb1e360c4b4a48055cc7f35848cdd5cda655ddab7f04cb2bea2303b2770a223a3fc8d998e643234',5,1,'API Token','[]',0,'2025-02-13 11:36:07','2025-02-13 11:36:07','2026-02-13 11:36:07'),('5cf4d4b0f4f84c79eacf38ba4bdf98180eb744ae9dc7b357876e2e976779e92b539b847dd8a61ab3',52,1,'API Token','[]',0,'2025-03-05 09:13:16','2025-03-05 09:13:16','2026-03-05 09:13:16'),('6094d8b7e82be2f542f9662d5d8f8a621b47d4003eb13d2054955bac3ed289bc1d21b86d4f923aed',26,1,'API Token','[]',0,'2025-03-06 14:24:56','2025-03-06 14:24:56','2026-03-06 14:24:56'),('6101e63274f6cfa54072714aad94882ee6695b2bf02d1f0de1403199622dbe8901da410bed495512',82,1,'API Token','[]',0,'2025-04-16 20:13:59','2025-04-16 20:14:00','2026-04-16 15:13:59'),('647544cc09940eb7b0fe186e465bd2025c9321c6e317e530a643144de8fff049ff305cd298d01d41',19,1,'API Token','[]',0,'2025-03-24 10:49:22','2025-03-24 10:49:22','2026-03-24 10:49:22'),('653cab852b71f3f3ddb8b3336f0a9dd3df195349a581628d723c3960f284cf9feb018ce3f688ef3c',20,1,'API Token','[]',0,'2025-02-25 19:51:02','2025-02-25 19:51:02','2026-02-25 19:51:02'),('656f9c6016c128f495d33492165c7123831443715192b4552df804db5d4ec3b9adb5342fc2c4282f',31,1,'API Token','[]',0,'2025-02-23 16:31:12','2025-02-23 16:31:12','2026-02-23 16:31:12'),('66329a7f3f68812412052a9ae00e439155c453ec9c8c59e630aef447c4e3f2d222ded64d8912a71a',1,1,'API Token','[]',0,'2025-04-07 20:20:53','2025-04-07 20:20:53','2026-04-07 15:20:53'),('675b90675aa8d55631983614cf33fc0e07bbd3b6111ea73078b4368eaa39cc00d394f89e66b86d5e',36,1,'API Token','[]',0,'2025-03-02 23:52:16','2025-03-02 23:52:16','2026-03-02 23:52:16'),('6851b9963aced9809aab86ff0d4881c07a35b65ceccdc6e41ff0066b43758b96af7ed8db8bb5c248',83,1,'API Token','[]',0,'2025-04-17 14:54:23','2025-04-17 14:54:23','2026-04-17 09:54:23'),('68d4ff684ad8e5ae8f8d3bebce3f1e06ecd759386cb6a688386e672e94048efb18f76ce13cb6f993',1,1,'API Token','[]',0,'2025-02-27 14:59:06','2025-02-27 14:59:06','2026-02-27 14:59:06'),('695236b2ed6d8a6d94c5183e7281ab0b1f54ebec509e711135ae8be37514831dc22e9e18778b7e21',1,1,'API Token','[]',0,'2025-02-20 16:58:04','2025-02-20 16:58:04','2026-02-20 16:58:04'),('69f85eba0d04a4c671b1f486f373e1e6ba6774a6fee6c1991524671faf48d6b9aa229b8b5c1be679',1,1,'API Token','[]',0,'2025-02-25 09:47:45','2025-02-25 09:47:45','2026-02-25 09:47:45'),('6b0d4d466dbfedb64b2d58f347b258a14d0c51af656dbbfd937e7ae9645f42a03d91d615ade8b8f0',1,1,'API Token','[]',0,'2025-03-30 08:42:29','2025-03-30 08:42:29','2026-03-30 10:42:29'),('6b6accd821e7c90783140a923bf96a615f9fb2a43dc604a8cc459f19741bad5d8c91c3cd78f00597',26,1,'API Token','[]',0,'2025-03-19 00:32:35','2025-03-19 00:32:35','2026-03-19 00:32:35'),('6b6fdd9bd435c8f9aa71e312bbfad4d1ed5a330033e06ba0017942364c6265b1c095887343e32f1d',6,1,'API Token','[]',0,'2025-02-16 11:07:57','2025-02-16 11:07:57','2026-02-16 11:07:57'),('6bc35e1654594e6b72caa2ac6bf8d972380697fa36423754c80dfb898bb53e390579f49c644aca2b',25,1,'API Token','[]',0,'2025-02-22 16:38:39','2025-02-22 16:38:39','2026-02-22 16:38:39'),('6bc5260462e4a91d56b8a63111e247887b2cd36d8b50c5cd8bab9925ac7dae4d8fd8bea3a705e018',26,1,'API Token','[]',0,'2025-03-24 15:59:24','2025-03-24 15:59:24','2026-03-24 15:59:24'),('6c35ba4e2451ca227d4461f4b9c5f6e0f6a04cc89212c0c1dddfeb5fc313a1589870d88ca957d72c',1,1,'API Token','[]',0,'2025-03-18 10:14:23','2025-03-18 10:14:23','2026-03-18 10:14:23'),('6e555d158037fb00490cc116bd1c44b01399856529fca18f997047690060bf4b78450f9d33b50980',1,1,'API Token','[]',0,'2025-04-07 21:02:42','2025-04-07 21:02:42','2026-04-07 16:02:42'),('6e93edc89403d99d5b0431f49d3db57bb99f8665c7d14bc4f31fce0304d7b7281d80d23ff839ceb6',20,1,'API Token','[]',0,'2025-02-19 16:04:46','2025-02-19 16:04:46','2026-02-19 16:04:46'),('6f04e4f19e24223cf53942ca9c6e7f6ecfa401d14a7c31373f95ef5d5537f4253ee5cba3717d520f',60,1,'API Token','[]',0,'2025-08-29 20:50:43','2025-08-29 20:50:43','2026-08-29 15:50:43'),('6f0566fcd5a0132ab005be0e5728aaeb6612c293dfc0036e06188e14df66e2bf5b3d803c6d4b4489',68,1,'API Token','[]',0,'2025-03-19 00:42:58','2025-03-19 00:42:58','2026-03-19 00:42:58'),('70585d1b06c13ed11b510ca629cef17502c43ef2613a79c62e5dff2a2fc365bfe3eb45bfa8c03807',65,1,'API Token','[]',0,'2025-03-24 10:58:16','2025-03-24 10:58:16','2026-03-24 10:58:16'),('70dc198a21b9f0bb93a09f835899814cf3022ceef8df274aba0c342a1ada039130dcabc18baa91e3',19,1,'API Token','[]',0,'2025-03-23 10:50:58','2025-03-23 10:50:58','2026-03-23 10:50:58'),('70fd69b4f4f8e493b74938f1087930ac6a7575608dc92278601798d184c17e1a10113a113cd43016',20,1,'API Token','[]',0,'2025-03-03 13:11:18','2025-03-03 13:11:18','2026-03-03 13:11:18'),('71a2c3a827a7af204b0f90b8d71b191ae1467451e9061d213179d67143cdf660898f946d763946ff',64,1,'API Token','[]',0,'2025-03-17 19:16:07','2025-03-17 19:16:07','2026-03-17 19:16:07'),('726e0b3883f0680cb3c605da28de04d5484d805b6c968009ad41f60f036db679f0f15ed4ac238855',5,1,'API Token','[]',0,'2025-02-13 08:19:23','2025-02-13 08:19:23','2026-02-13 08:19:23'),('72ca8d9bc01c1b49bec797764e8f2175762b55e4b4179042522529ea2484f408bf45b1d2c7a960f2',1,1,'API Token','[]',0,'2025-02-20 20:52:40','2025-02-20 20:52:40','2026-02-20 20:52:40'),('7320180b926ee9498a219ae3a9da92660e4ff48d057c2bbe12ed98155a7fcefd620751178865ecb6',1,1,'API Token','[]',0,'2025-02-19 14:18:44','2025-02-19 14:18:44','2026-02-19 14:18:44'),('732e9830af164b7c21ae41f832c955738e7ece3339eb800e190bfe5301207353196a4a49c15a6d6b',64,1,'API Token','[]',0,'2025-03-17 19:17:48','2025-03-17 19:17:48','2026-03-17 19:17:48'),('747aa1c8456d1876f5186da285899d981ee8a7fde8136980cdd0030091f7cb16e03c958761e0f2ef',1,1,'API Token','[]',0,'2025-03-25 11:51:14','2025-03-25 11:51:15','2026-03-25 13:51:14'),('747ce32667c37ea933cc24fbde80645f19441480683a12e28747b4e080266c1519cc35eb46ffeb79',48,1,'API Token','[]',0,'2025-03-01 18:43:57','2025-03-01 18:43:57','2026-03-01 18:43:57'),('74cf5bb72c0ea1c920fb88c0ef2061a9783e2841ed88ba4d65921d530286b551bc692ee0030c1ab5',26,1,'API Token','[]',0,'2025-03-24 16:34:33','2025-03-24 16:34:33','2026-03-24 16:34:33'),('75043517257fd5bbea9bfd7fb056f5414243783820d0ac70adb8849bebb6fdc8cc7eb17124294093',88,1,'API Token','[]',0,'2025-09-19 02:14:25','2025-09-19 02:14:25','2026-09-18 21:14:25'),('753b3691b719a96a4ac3a0f18f9a802e70dba91c91f2c364c57ee164052778ccc85dbc32c01a161d',20,1,'API Token','[]',0,'2025-03-03 09:21:07','2025-03-03 09:21:07','2026-03-03 09:21:07'),('756585ab99e7cd51698552c1000d197d9ec295f3a5b3877d5320dcf1b4047b356503662734764790',1,1,'API Token','[]',0,'2025-02-25 10:03:42','2025-02-25 10:03:42','2026-02-25 10:03:42'),('75d864c83270bd339534f82f693218090e6032901567772bb3eb8e4aa3af6605a3a1303e9919f2ca',2,1,'API Token','[]',0,'2025-02-13 14:03:29','2025-02-13 14:03:29','2026-02-13 14:03:29'),('76ad2c2c97ff05d1eaa615ef083f77471c5590f82a88525c205a71c2645bcf5d9ba6e20a813fed96',19,1,'API Token','[]',0,'2025-03-06 22:04:59','2025-03-06 22:04:59','2026-03-06 22:04:59'),('7783cb28f7b3443495a3c7d3a9f7f61ba4fa4d8255dd7898b255071ff19345c006bfd39a475780b3',46,1,'API Token','[]',0,'2025-02-28 22:07:07','2025-02-28 22:07:07','2026-02-28 22:07:07'),('77cd12b0a6221cb009dd8a74e2022ed1af317483289a92437713b2b8fe547ef60fef002f66b13a1d',1,1,'API Token','[]',0,'2025-03-12 12:44:42','2025-03-12 12:44:42','2026-03-12 12:44:42'),('79a3b6432689d88b94e5dd2813f33ec6006538ae1469573a3459a548675dd128e467de88614d5f8c',11,1,'API Token','[]',0,'2025-02-16 11:59:48','2025-02-16 11:59:48','2026-02-16 11:59:48'),('7a2d2865f021f3b121f25aa4f82e28aa21f3331dae9feea0b37db4db22b044e4afbb26d738f45445',19,1,'API Token','[]',0,'2025-02-19 13:55:08','2025-02-19 13:55:08','2026-02-19 13:55:08'),('7bd89a14bebfa5ecf1a43ea2bfe942e4daebeaa72c161f201aa11aaf101587b06cd16330bcb54b19',6,1,'API Token','[]',0,'2025-02-13 15:15:45','2025-02-13 15:15:45','2026-02-13 15:15:45'),('7beddb3bf7e0a89ae9a8d4c7079fcf5f417057b624fd65b76082b3a490ac12a009d424bca2568645',26,1,'API Token','[]',0,'2025-03-08 17:11:52','2025-03-08 17:11:52','2026-03-08 17:11:52'),('7dc053a9c7a0bf24166999eb8ec65cad525b2f237078055c7d1d35d2c3ce446186ebc59b5c99e7a5',1,1,'API Token','[]',0,'2025-02-20 17:15:43','2025-02-20 17:15:43','2026-02-20 17:15:43'),('8118aabdf370ca24902966bddc4d7c386820c6de8c5f86b42cb57cba1fb4c6dc136dbd564e156165',36,1,'API Token','[]',0,'2025-02-24 18:26:21','2025-02-24 18:26:21','2026-02-24 18:26:21'),('815e3620596716fd2622541bd15d752750f8fa46ec49b6049c3c3c1741129794366482c2c32845b5',1,1,'API Token','[]',0,'2025-03-16 11:54:36','2025-03-16 11:54:36','2026-03-16 11:54:36'),('8290263c47ce343920aaf72ba943aadabb01ccb6243c9f4f6890b69a266c81b64344e10c7549aee5',63,1,'API Token','[]',0,'2025-03-16 13:47:06','2025-03-16 13:47:06','2026-03-16 13:47:06'),('82e65f5d360f9f21260a76745a5f13a62b1587bfbee0435f9bf702e21a0cad5c2882aab555ef66db',19,1,'API Token','[]',0,'2025-03-19 20:51:21','2025-03-19 20:51:22','2026-03-19 20:51:21'),('846ee1fe7127856e54195cbc9622b827e342f35b7572280e1d7d672f5168d41fb57b6e56b6ca7f79',1,1,'API Token','[]',0,'2025-03-31 00:30:46','2025-03-31 00:30:46','2026-03-30 19:30:46'),('84c6a0607c0d4279c05f4727a72e76f43a7f2dbcdc11bb5ffc86321560b24c7c843a143a8f912cd5',78,1,'API Token','[]',0,'2025-03-30 19:03:28','2025-03-30 19:03:28','2026-03-30 14:03:28'),('85b3609369d5acc96e9eec685d74ea7165cad8711f0aaf8fd90133f0ec8645825a87cc07bf9f859b',1,1,'API Token','[]',0,'2025-02-19 14:01:01','2025-02-19 14:01:01','2026-02-19 14:01:01'),('86903d1a4685e73bf27002a9c2615f9173c6450578690d14f80cefa9d71e7ca8b09360c804cde093',77,1,'API Token','[]',0,'2025-03-30 18:59:46','2025-03-30 18:59:46','2026-03-30 13:59:46'),('87555cb0b099dbae4aa11bd646e6b8a8918f99b02ed5e7aa9a1aeacf6741dfc5da76f2538162409b',64,1,'API Token','[]',0,'2025-03-24 04:41:51','2025-03-24 04:41:51','2026-03-24 04:41:51'),('8775e26665945ab27ab9b3863779b5ba4e18d8b16b53fb66c3e18cdecbe22ddb04cadf6fa3c4ae76',53,1,'API Token','[]',0,'2025-03-05 09:14:38','2025-03-05 09:14:38','2026-03-05 09:14:38'),('88ca51d27b1bd74eabb3254b00e853aad98803533fa862614acd9e22aba836f863622849960fa10f',1,1,'API Token','[]',0,'2025-02-17 22:38:50','2025-02-17 22:38:50','2026-02-17 22:38:50'),('89f6783e39b5e1f249f718dc819f59781e7e7905d2a6d7459ce8c3d99327b491c55b4d8363f2c5f9',64,1,'API Token','[]',0,'2025-03-17 19:27:30','2025-03-17 19:27:30','2026-03-17 19:27:30'),('8a0f7fba652bf831ef6af34843db1d015a19d53b1c91260f6d2a71ed50b3913be1735c2f10877fef',88,1,'API Token','[]',0,'2025-09-19 02:29:08','2025-09-19 02:29:08','2026-09-18 21:29:08'),('8ac92af21bb25f60fedb14acc3ed1b3d449cce4baa11db05fe434083c59e109d5478affd282be90a',20,1,'API Token','[]',0,'2025-02-20 23:29:02','2025-02-20 23:29:02','2026-02-20 23:29:02'),('8beb3a12325fc687372b80d83e5ee5abdc35bb82aa95347a93ad9abb003a9d0411d3df9aa1f795b1',19,1,'API Token','[]',0,'2025-03-21 01:03:25','2025-03-21 01:03:25','2026-03-21 01:03:25'),('8e6612b80ae0bd1edcb79f1df795131ceaeb0e891ad596dc7cd303ca0c8e9657ff6dcc9745d51b9e',19,1,'API Token','[]',0,'2025-03-06 23:26:17','2025-03-06 23:26:18','2026-03-06 23:26:17'),('8e81bc53454f8ebea1a08ec0af8f1fec49291fb9ecc29a81326fce0fa065ef0f579bc2b76f97235f',19,1,'API Token','[]',0,'2025-03-05 09:38:44','2025-03-05 09:38:45','2026-03-05 09:38:44'),('8f402ebdf0f6fe0bb6c460d598840f8557db2c5e207f1efefb4f15947a314aca39a9de926e44b893',88,1,'API Token','[]',0,'2025-09-19 02:30:23','2025-09-19 02:30:23','2026-09-18 21:30:23'),('8fd4bd2d1909d6957cb9a1941301f5ca8373200e22a97004749af5b74b22fb229f3f596d55e8a540',1,1,'API Token','[]',0,'2025-02-19 17:28:34','2025-02-19 17:28:34','2026-02-19 17:28:34'),('902c31aa412217dec59404b8053beced114f4d0c7b9e3aa5a9e8ad1526c92c9d2d34c41022c35632',2,1,'API Token','[]',0,'2025-02-13 08:43:52','2025-02-13 08:43:52','2026-02-13 08:43:52'),('904882cc01cd26054b98b91abaf97aa13410d338ef45927cb535008e77e8b72dca859dc2f925af54',1,1,'API Token','[]',0,'2025-02-19 09:44:31','2025-02-19 09:44:31','2026-02-19 09:44:31'),('90a9021a25eb807e75dd25098d3ade063d2d5df87fc1960b7250b5285156f4b6bf4e9278ce91ea5e',67,1,'API Token','[]',0,'2025-03-19 00:26:28','2025-03-19 00:26:28','2026-03-19 00:26:28'),('91e5ae0b175159490803a5ff294c52356d598f53e014f3f415a9ad6e664e58ee3c6bb40cd6f8b113',6,1,'API Token','[]',0,'2025-02-13 15:06:55','2025-02-13 15:06:55','2026-02-13 15:06:55'),('92c5b710b60c4a800c02e6bd5d0cb09e948a2aeffc4c7e1bae655d01aa79bf4e2f72d8cafacd0bf2',59,1,'API Token','[]',0,'2025-03-05 13:12:10','2025-03-05 13:12:10','2026-03-05 13:12:10'),('93bafc92abfdbff4743fac8581339923a7b19556e8803295cb74899e570aecefc64c6c531fcd8e9b',20,1,'API Token','[]',0,'2025-02-27 20:39:47','2025-02-27 20:39:47','2026-02-27 20:39:47'),('95705fc187543ef089136e4300dda3490210aa969c7df643201c660654f0f44aedca8181dc476fa6',65,1,'API Token','[]',0,'2025-03-24 04:00:43','2025-03-24 04:00:43','2026-03-24 04:00:43'),('95903aa7b06f7a0e6686cbf0e30963373ee4fe71dd6be41be7fa83aa4bcaf36e0e66eed0aac27a63',86,1,'API Token','[]',0,'2025-08-13 16:20:52','2025-08-13 16:20:52','2026-08-13 11:20:52'),('961176a9c5c2fa750659fa19a3a345554d45a31d3a2c6ca284eb7e9f2f28ff47cc3ae07985789fff',11,1,'API Token','[]',0,'2025-02-18 19:25:32','2025-02-18 19:25:32','2026-02-18 19:25:32'),('96143cdcbbed74669af03bbe6533f50d8ab5a5348d992e895774625aa72063aecbbabf489637cc3a',6,1,'API Token','[]',0,'2025-02-13 15:13:46','2025-02-13 15:13:46','2026-02-13 15:13:46'),('97e7556a0fae7b15962de5da9ae07108437e18f3f26101b1d09b8d146cc8613a2a77e8a8c3199627',53,1,'API Token','[]',0,'2025-03-18 10:28:53','2025-03-18 10:28:53','2026-03-18 10:28:53'),('9a9eec600ede51ef4849fda766910910719f7b75b1d8cd8f74e847a9a7073659018dc51531f828af',20,1,'API Token','[]',0,'2025-02-20 13:40:26','2025-02-20 13:40:26','2026-02-20 13:40:26'),('9b019378b58353cc699650deec68f7b9a57162964b5d08c0e0deff50424572b0fc2741a21c814fd2',20,1,'API Token','[]',0,'2025-02-25 11:45:51','2025-02-25 11:45:51','2026-02-25 11:45:51'),('9b48fc67295e638a05545b5007ac89c598f09fab950494c886141e3fe5c98e67d2c1bbe608578ee8',34,1,'API Token','[]',0,'2025-02-24 10:11:22','2025-02-24 10:11:22','2026-02-24 10:11:22'),('9b5c41a6fb7620105a36e2ccdbe3be77d44c823f5499004639b9ca53334d6e4ebed013fc921b0527',19,1,'API Token','[]',0,'2025-03-21 04:01:21','2025-03-21 04:01:21','2026-03-21 04:01:21'),('9b789d0dcdff42e29cc51cb289e20c32456a2d4a31c2083cfa6283ce4ffe2f293815484655f0129b',11,1,'API Token','[]',0,'2025-02-16 11:38:29','2025-02-16 11:38:29','2026-02-16 11:38:29'),('9d945706745aa782691c2f98ae908815384da07952f97e42defad6c59258d954eae1a93322f72d8c',6,1,'API Token','[]',0,'2025-02-16 07:52:58','2025-02-16 07:52:58','2026-02-16 07:52:58'),('9f0c4b97c6983bf68afbef1718af0940528ea1636048e51af812debe9ad71e1e9630756c3309c89d',1,1,'API Token','[]',0,'2025-04-07 20:24:15','2025-04-07 20:24:15','2026-04-07 15:24:15'),('9fcb2087e30ae63265719c5dca7f0cb45c51c6d365e3d01dde2f297995c68df2d9a508c7e267e8db',19,1,'API Token','[]',0,'2025-03-19 20:58:55','2025-03-19 20:58:55','2026-03-19 20:58:55'),('a00c119c30f3448ae9612fd6a9a276d224621f0bd31117be57b32168cbc1f6ed6de226e9969ea7ec',32,1,'API Token','[]',0,'2025-02-23 17:16:39','2025-02-23 17:16:39','2026-02-23 17:16:39'),('a013d18290edf42c1d4c7c1f857c536e87001f6a28a44417fe7430120b67dea614d0c599fbf19d2b',1,1,'API Token','[]',0,'2025-04-08 20:45:21','2025-04-08 20:45:21','2026-04-08 15:45:21'),('a08c5521e361ba3c8b23da521ce8f018e2018308a37e1c87421dd9cf629c9d4f84da5e522bfe10af',20,1,'API Token','[]',0,'2025-02-27 14:24:39','2025-02-27 14:24:39','2026-02-27 14:24:39'),('a1466c7dfcd0b53a9dcffa03bb58280e24ff20d2d15145e75a0a6e03433b77febfcbcecf5f133a10',38,1,'API Token','[]',0,'2025-02-26 08:28:54','2025-02-26 08:28:54','2026-02-26 08:28:54'),('a17c427aeaed8b6683175b4f87a3d8715f9d1edb33c78fb22a39234e571fd3901eaea566d2d42419',19,1,'API Token','[]',0,'2025-03-19 21:28:59','2025-03-19 21:28:59','2026-03-19 21:28:59'),('a41660597e59fddbb4478636dfd772e918ef0dc80ff64f2bdabc63c77431cb6425294af91d798f56',19,1,'API Token','[]',0,'2025-03-25 09:36:56','2025-03-25 09:36:56','2026-03-25 09:36:56'),('a5bb930b1bf5409268b75323c1b24bdbbe61983950eb5c0320f4dafefaba444c2bec5bec46fbd9ba',20,1,'API Token','[]',0,'2025-02-27 14:27:06','2025-02-27 14:27:06','2026-02-27 14:27:06'),('a6a736dc05ee5c384c7aaea92113d234e5469a55598f50b2ded991211ed8ed2fe4c7ab92ead9e964',1,1,'API Token','[]',0,'2025-02-19 14:11:41','2025-02-19 14:11:41','2026-02-19 14:11:41'),('a81b7d3e881284ef33e9c18617723004ec2e659b87b4a209da3fe158f2959a619c5626db4300f924',1,1,'API Token','[]',0,'2025-02-19 13:24:22','2025-02-19 13:24:22','2026-02-19 13:24:22'),('a9f82483efe5d89bf74b69bbb6002a06d002ceaa93324cfa1344dad3dbd75f7045689435e794be94',11,1,'API Token','[]',0,'2025-02-13 09:58:54','2025-02-13 09:58:54','2026-02-13 09:58:54'),('aae0e55e3600c68722c408753395a57cb44b6d8e2d05c0abfc390a77eb94b52d8bde16e964b71b76',20,1,'API Token','[]',0,'2025-02-24 09:19:33','2025-02-24 09:19:33','2026-02-24 09:19:33'),('ab371a461288616fc31a27ce44f6995b8dc8fbf0e6e93e066d22fca82075135b3b8cf37cbb72272a',1,1,'API Token','[]',0,'2025-02-20 16:28:17','2025-02-20 16:28:17','2026-02-20 16:28:17'),('ac05855fe4cea9430a43ac1e3c7150248bd1035fc65e837a9e1cfc0819b404dd3c2bc909f765b04b',57,1,'API Token','[]',0,'2025-03-05 12:19:02','2025-03-05 12:19:02','2026-03-05 12:19:02'),('af73a7dce27a365e5f751a492f9b7b2654eaa9fc043e931a97fbda02440c067126f4f037deee7b1c',19,1,'API Token','[]',0,'2025-03-05 09:38:19','2025-03-05 09:38:19','2026-03-05 09:38:19'),('afa1d2079340d3d16456b283046e075b6c53520ec773124711ed16b6fcc3f0042d79c266375af4d1',20,1,'API Token','[]',0,'2025-02-27 14:25:49','2025-02-27 14:25:49','2026-02-27 14:25:49'),('affeef70387f9aa3525f5414848e213a53497edcba836c0f61f45a883c20847a13532f680e0fb5bd',19,1,'API Token','[]',0,'2025-03-04 11:14:40','2025-03-04 11:14:40','2026-03-04 11:14:40'),('b077416dd0dc5855ecb36fbe8c89c2fa51147844ff9d8bc8b13fc7f060967833363a124d6cb5959f',88,1,'API Token','[]',0,'2025-09-19 02:32:41','2025-09-19 02:32:41','2026-09-18 21:32:41'),('b178089b44c2208c7a203e38c8664691b0e222391480d37fbc1be4f80f677afa3000466c56ccbfc5',20,1,'API Token','[]',0,'2025-03-03 13:49:19','2025-03-03 13:49:19','2026-03-03 13:49:19'),('b26be4317f88671d800ab68c43aa9efa08fc29da933492a92ddbe346e6f4f32bc83eda93468b03a8',88,1,'API Token','[]',0,'2025-09-19 20:49:55','2025-09-19 20:49:55','2026-09-19 15:49:55'),('b2aa80c906b2129f77dd657ba0f07848bdca88de060f712a767c44287c7d1a8b8543a43bbae01b48',1,1,'API Token','[]',0,'2025-02-20 17:19:08','2025-02-20 17:19:08','2026-02-20 17:19:08'),('b2e530b4650668c9d101bd4173684cc541745c8c40d028903597823740c89fc429d225b029499c00',19,1,'API Token','[]',0,'2025-03-19 20:49:54','2025-03-19 20:49:54','2026-03-19 20:49:54'),('b313d6d0dc0e09fb8ef28a109095d6cac57726af6878bce5c5e3282adcf1f1527a2af3ef8896413b',19,1,'API Token','[]',0,'2025-03-20 05:08:30','2025-03-20 05:08:30','2026-03-20 05:08:30'),('b3fdf8ff21c3113e60bef1b79b93f48e56ce32306232a5746e44b1f6ae8bd3a05a76a2bee5d25905',60,1,'API Token','[]',0,'2025-08-29 20:52:53','2025-08-29 20:52:53','2026-08-29 15:52:53'),('b5ac18fdefe6c08da42c4da884e571af4855fd06302f3bf5fd81f2f1d0f6229ae0908bcc27f114fb',26,1,'API Token','[]',0,'2025-03-24 13:43:25','2025-03-24 13:43:25','2026-03-24 13:43:25'),('b6cac6cb589823d09d8534b598b76883588aabedeef6fafa8f84b6157faa08d1a9773bec8a017442',20,1,'API Token','[]',0,'2025-02-25 17:16:06','2025-02-25 17:16:06','2026-02-25 17:16:06'),('b78b258d2b872802372a8d81bfdcf92b25e4ac2e507a1164e115f5a96a53a08404d11ec0a6a585d4',88,1,'API Token','[]',0,'2025-09-19 02:30:54','2025-09-19 02:30:54','2026-09-18 21:30:54'),('b803569045c947f2043ee338a0ef7ace8225825ef9d49bdbb8bb65684d7bb46577a3d642aa0a6e82',1,1,'API Token','[]',0,'2025-04-07 20:18:51','2025-04-07 20:18:51','2026-04-07 15:18:51'),('b817568adc92c10d34e61b52c6d1609c83eec958fb15d940ec0fda24748b87b43ebcf033d279cc7a',51,1,'API Token','[]',0,'2025-03-03 15:31:07','2025-03-03 15:31:07','2026-03-03 15:31:07'),('b81d0ddde2367c38ced355d03c0893213a7f18392107d611d85b22157e434b9549c896dc69c556b2',20,1,'API Token','[]',0,'2025-02-26 09:51:48','2025-02-26 09:51:48','2026-02-26 09:51:48'),('b86294a7311effba5d8e2452fe60ea4b4bc0e1df45428ac71f10a5a7da81c52dd0ed2fb0a6eceea4',20,1,'API Token','[]',0,'2025-03-03 23:30:52','2025-03-03 23:30:52','2026-03-03 23:30:52'),('b8a7c00f126b55079b4bc09851ba166e509bfe2a943af92a78a067421e881f930bfa156c7d35d823',11,1,'API Token','[]',0,'2025-02-18 19:16:00','2025-02-18 19:16:00','2026-02-18 19:16:00'),('b9b85010e18e8326e463747d2c545af3062a6626b12459ebc014aff298a8052ed7f0f38ea3816cc3',20,1,'API Token','[]',0,'2025-02-25 12:53:55','2025-02-25 12:53:56','2026-02-25 12:53:55'),('b9c6207a5f5945767b20b5e3f365ec7d194cd00dd2dde08800153269509eca909927baaf715f1b48',25,1,'API Token','[]',0,'2025-02-22 17:28:50','2025-02-22 17:28:50','2026-02-22 17:28:50'),('ba5a23bca078272edef2eebf5fb5631bc4ec2a785e3376d2bb5803be2b89ef4f14997f0c67229bd0',19,1,'API Token','[]',0,'2025-03-05 11:27:51','2025-03-05 11:27:51','2026-03-05 11:27:51'),('ba6c9896700cabf2ffbdd7dd14e034d0709b37d6e968defdfc6d662224de64b37efe8712e1c509f2',79,1,'API Token','[]',0,'2025-03-30 19:08:24','2025-03-30 19:08:24','2026-03-30 14:08:24'),('baaaa82cccf2a17bdc00eb754d9412e79990d5e32e19e47242818b026c8c3b4a322cef2a8862dc38',20,1,'API Token','[]',0,'2025-02-26 17:26:23','2025-02-26 17:26:23','2026-02-26 17:26:23'),('baf9516df13136d2007478d3611c6c5c3c431eff4d46a9d076f9577580e56735a7869ead5856610d',60,1,'API Token','[]',0,'2025-03-06 13:54:21','2025-03-06 13:54:21','2026-03-06 13:54:21'),('bb46c1ee9f28e973d06aa5c0001dc4e54db7936d30e6aa59350314e2d0730f425c134de5fe6bb871',2,1,'API Token','[]',0,'2025-02-13 13:56:29','2025-02-13 13:56:29','2026-02-13 13:56:29'),('bbf0f94f375006adc5479374786aab369dac517fbbb9f59a1f02f545276b14ec5fd721968fb3e4d0',1,1,'API Token','[]',0,'2025-03-31 02:14:07','2025-03-31 02:14:07','2026-03-30 21:14:07'),('bc3e0984de1cf2e98e4bcfbedc61b3b4f4a290319d93466a970b4d4757611f28cb431a888cfb1ecd',20,1,'API Token','[]',0,'2025-02-23 11:25:36','2025-02-23 11:25:36','2026-02-23 11:25:36'),('bc98e1d92339037e6024c469ccb5631e3baa3a97a5dddd4e40d356e820d183643f6529dc2aba3298',35,1,'API Token','[]',0,'2025-02-24 11:01:43','2025-02-24 11:01:43','2026-02-24 11:01:43'),('be62716552719e0bd9a93ea74587a431778c316c8b3494a35dc1431cb6b351a412cf1042b5c36a12',1,1,'API Token','[]',0,'2025-03-25 09:48:33','2025-03-25 09:48:33','2026-03-25 09:48:33'),('bf6d048ab72a2762f367a1d3bce80ed91c05791a85050e5b5e5db82089c12f3e1c8574983ac2f384',19,1,'API Token','[]',0,'2025-03-19 20:56:35','2025-03-19 20:56:35','2026-03-19 20:56:35'),('c1478342f196790a4e48635db280c7d81766fe28ef98f736c52f98aa86ee55374a3886f77562350c',26,1,'API Token','[]',0,'2025-03-19 00:48:22','2025-03-19 00:48:22','2026-03-19 00:48:22'),('c19f269661d83d7cc0caabfd6ee52efd27ccd87cc4e0d510cd1aed31320c7ff3b611473e4e021914',11,1,'API Token','[]',0,'2025-02-17 22:36:31','2025-02-17 22:36:31','2026-02-17 22:36:31'),('c1d18546f6fb81b7d0ff5b72d32c9f3a02acc9ed270ec69f55afa7dcd2ea0b1f24d411d3bcfcd245',19,1,'API Token','[]',0,'2025-03-16 12:54:16','2025-03-16 12:54:16','2026-03-16 12:54:16'),('c2192b478a751ce5306792c21568bc4dd0d44aa6f58886cd7025f5d1847e458f36ca165fb0cdd9c9',19,1,'API Token','[]',0,'2025-03-16 21:55:38','2025-03-16 21:55:38','2026-03-16 21:55:38'),('c2c56bef76fc3ebee1bd774685882033b8fc6c634fa20387d68f157662b2588254619472f253f0d6',76,1,'API Token','[]',0,'2025-03-30 17:04:17','2025-03-30 17:04:17','2026-03-30 12:04:17'),('c6cf219b50c68b79180e42614dc137187577bc85017996fce1d46a9d6c04841adaf5cfb2daa07ea2',20,1,'API Token','[]',0,'2025-02-26 18:13:12','2025-02-26 18:13:12','2026-02-26 18:13:12'),('c8fad0d2ae0c786d6b43ca7cad9b4342322cdcc59cd6e9a908d64a517f9adf6f436437b110434bba',25,1,'API Token','[]',0,'2025-02-22 17:38:09','2025-02-22 17:38:09','2026-02-22 17:38:09'),('c90a25d4a9efb0173e2ee1928f4ee3cad0586e135bd3f016fe46016020604e8350df76c8d8f9f2f5',6,1,'API Token','[]',0,'2025-02-13 15:12:57','2025-02-13 15:12:57','2026-02-13 15:12:57'),('c9c33f45d6204b536f283f0446edfe2cccd8b48c6959623c77c897f12e0e0c9a34a704359ea0bbf9',1,1,'API Token','[]',0,'2025-02-20 16:13:08','2025-02-20 16:13:08','2026-02-20 16:13:08'),('cb7bbe958bb08be9f87ff45e6836f6824d3063bb85c6bd19e107a37881df8e67800d7580ac8b10ee',1,1,'API Token','[]',0,'2025-02-17 13:34:31','2025-02-17 13:34:31','2026-02-17 13:34:31'),('cc60e472cecf5db0e42cbb9a44260a6e799e57cde1f691c0776ee9006e6c9df0d101e394fc42d7d2',5,1,'API Token','[]',0,'2025-02-13 13:12:23','2025-02-13 13:12:23','2026-02-13 13:12:23'),('cd618520a36b604c06e8a029cd4a7b37c12e74eee9d3cd0ec75b3ac4946535068a663a090a1fb015',82,1,'API Token','[]',0,'2025-04-16 20:14:18','2025-04-16 20:14:19','2026-04-16 15:14:18'),('cdb3f964669d3b8d842c33d065b7b6a88464711fd76e44e478bb598f078c5e5150f27ccf56f9935e',75,1,'API Token','[]',0,'2025-03-25 10:01:47','2025-03-25 10:01:47','2026-03-25 10:01:47'),('ceaf332d316a628869f9fbaa1437c8963730bf7c5ba3272710a0be8c4d7141a5b11d0765d15e93ef',64,1,'API Token','[]',0,'2025-03-17 19:04:08','2025-03-17 19:04:08','2026-03-17 19:04:08'),('d018e6e83f5b646accee86a9348191535f09fc27a0c14c0bb750379a846aeb1803aa9f3428cbee8f',20,1,'API Token','[]',0,'2025-03-03 00:30:26','2025-03-03 00:30:26','2026-03-03 00:30:26'),('d0d38b4d5e1d49cb6f90ca85ba82a24a27f0d96cb80622b39524dc3d66eeb1b91d3c218781696b2e',59,1,'API Token','[]',0,'2025-03-05 12:38:22','2025-03-05 12:38:22','2026-03-05 12:38:22'),('d17716301de8a606c52c2223007c9c87acddec8da781fdcf3d719507fe23d6f535d4a5b8db70510e',84,1,'API Token','[]',0,'2025-04-18 19:59:34','2025-04-18 19:59:34','2026-04-18 14:59:34'),('d1c5201c7ebd8a485abd39b41fc2c9a9a09c58b7787b8133b885eaff02b0450d5f8917a043231e83',19,1,'API Token','[]',0,'2025-03-16 13:10:57','2025-03-16 13:10:57','2026-03-16 13:10:57'),('d84bf1017cd14da972b61315a5f9d4ae861711fb94caa96724aff2e4aa37a6b2344ca860db409315',1,1,'API Token','[]',0,'2025-02-19 17:28:42','2025-02-19 17:28:42','2026-02-19 17:28:42'),('da9c32e9bcdaa4de6082c8a44f816ec0c73817f242b7ecb9daa3c6f1ad3a76a06ab7d0c1aae7cd47',19,1,'API Token','[]',0,'2025-03-22 13:35:44','2025-03-22 13:35:44','2026-03-22 13:35:44'),('dac6738e7161beb643b818fba8bfba3179c2585f73d1ddabe0aabb02ace84c297b7b90dbfd61420c',36,1,'API Token','[]',0,'2025-03-04 09:38:59','2025-03-04 09:38:59','2026-03-04 09:38:59'),('db546521ecc7d5b4a68783ea7dac64cc0f7ba30d7d9280b9a9e9ae7d3a2f0ebc4aac9c95c3811154',5,1,'API Token','[]',0,'2025-02-13 07:48:32','2025-02-13 07:48:32','2026-02-13 07:48:32'),('dbd32db905d23f7543e58e1007e81b51425c281aa75272d47249ae46916a839130d44e32434ce19b',1,1,'API Token','[]',0,'2025-04-22 21:08:23','2025-04-22 21:08:23','2026-04-22 16:08:23'),('dca9ac8387a9b7343c434da8e7b59904bc0dcc5cba3b5cf452bf17277285b5ad4f7dc5333d076a48',20,1,'API Token','[]',0,'2025-02-26 17:56:57','2025-02-26 17:56:57','2026-02-26 17:56:57'),('dcfd3ff306321232ffbffe4df1aa9fade10eb5fe990c9823e9c04204c405c2ad97cc4a310ed1f400',64,1,'API Token','[]',0,'2025-03-17 19:20:10','2025-03-17 19:20:10','2026-03-17 19:20:10'),('ddd6a4458a780bc78de2674c8427fbc276ca234e45bf36613822fbe956abeb82df8bbca44eed385e',60,1,'API Token','[]',0,'2025-08-29 20:52:53','2025-08-29 20:52:53','2026-08-29 15:52:53'),('de28d31685f023539b779fec804af52f4625f5c3f52fc04fe1cf98cba28130989e4bc0ce6303c38a',60,1,'API Token','[]',0,'2025-03-06 13:54:39','2025-03-06 13:54:39','2026-03-06 13:54:39'),('deeaf72981df34de4d5ec5319654639b51c00cc88af88a87eb0f51d4269d70f333bb0bb6906b4bd7',20,1,'API Token','[]',0,'2025-03-01 13:33:31','2025-03-01 13:33:31','2026-03-01 13:33:31'),('defac12e0c8024bf1d75f91e282455e21d40b1285b1c8b4f6f46b7055b5a2781fce7a6ba786ceaf1',1,1,'API Token','[]',0,'2025-03-30 08:31:21','2025-03-30 08:31:21','2026-03-30 10:31:21'),('dfa4cf2ede30bbed28190e3485156017ee6874221a36fe3efeb3ef082d07b5a45f23fff55ca7165d',71,1,'API Token','[]',0,'2025-03-24 10:38:06','2025-03-24 10:38:06','2026-03-24 10:38:06'),('e1823c7cc11f15aed436d86a3b5bdd6a3ea4b14de7742a9de32d0674d243f5f21317c76f787b001d',1,1,'API Token','[]',0,'2025-02-17 11:20:50','2025-02-17 11:20:50','2026-02-17 11:20:50'),('e1f48e27761d1cdd12b7a0053c3adae1ed07c9ff5a288c12228fd4c9173842274d7265c64d2488a8',20,1,'API Token','[]',0,'2025-02-20 22:50:20','2025-02-20 22:50:20','2026-02-20 22:50:20'),('e20d58ddb77190f6861c01d9084219a1f246f37381cd855e76945d6313c0e4bb203c18c5900c3d52',31,1,'API Token','[]',0,'2025-03-05 11:08:24','2025-03-05 11:08:24','2026-03-05 11:08:24'),('e25a14726b2fea54a3aa2191fe8eaa45c0abcf19549db8e338ac703b1dbca33e1a5cfe28d9d69dff',19,1,'API Token','[]',0,'2025-03-05 09:29:49','2025-03-05 09:29:49','2026-03-05 09:29:49'),('e29687398b4c72e2214adbcbaf13596a2164765a40d6030fe36da5ddaeb7cbdeacbe89bedc3904d0',85,1,'API Token','[]',0,'2025-06-07 17:49:09','2025-06-07 17:49:09','2026-06-07 12:49:09'),('e3a3eb538baac143c238ea75b8aa3629a6ec8911bbf90c70f7674ef36eeb16b7a9a17aed1d5db205',66,1,'API Token','[]',0,'2025-03-18 10:29:43','2025-03-18 10:29:43','2026-03-18 10:29:43'),('e489a3f618f5c883a357eb72e3ae5a6c5b75b1f0bc10ab49bad1d2f3ec00dfd59e652cdf8dd8e334',5,1,'API Token','[]',0,'2025-02-13 07:50:50','2025-02-13 07:50:50','2026-02-13 07:50:50'),('e5dc2393c5863d758a20180ce430d9d5081c979a97992813cf66d7ef1919e6f0f4076b9640054406',6,1,'API Token','[]',0,'2025-02-13 15:06:48','2025-02-13 15:06:48','2026-02-13 15:06:48'),('e642cf0d04a4bcc50ce1b5b8e0bbaeb4e8df7f00cc4b59b36f4b66aa31a32ddb0b4d1d800c02ee25',26,1,'API Token','[]',0,'2025-03-19 01:32:46','2025-03-19 01:32:46','2026-03-19 01:32:46'),('e6de5d1f220f7b1cda6e072a1c8d31e99306593eff1c3ae05a2b824e85f24676cced1678ea63b668',1,1,'API Token','[]',0,'2025-04-07 20:39:01','2025-04-07 20:39:01','2026-04-07 15:39:01'),('e7b527f4ee6834e00650b17d0bc1755a610130a2b4efd313a6485462f3429528563d2aa9c3adad64',20,1,'API Token','[]',0,'2025-02-23 19:26:04','2025-02-23 19:26:04','2026-02-23 19:26:04'),('e7be10f52723aaaf8537a12af26952087f6522720a1dd3b6cd9527b76f7e005867682cbdc14cd3ed',81,1,'API Token','[]',0,'2025-04-08 21:58:54','2025-04-08 21:58:54','2026-04-08 16:58:54'),('e819efb21b335b485122f8657e6385785a728ba41a7aa5c2693dbe068429e6f719b2e0bcdebb8fbe',2,1,'API Token','[]',0,'2025-02-13 08:54:39','2025-02-13 08:54:39','2026-02-13 08:54:39'),('e8466f8d1ae2b393de2bdd8dd954006089c520db42853f8923175caecc31535913466b4629537d2d',76,1,'API Token','[]',0,'2025-03-30 17:04:33','2025-03-30 17:04:33','2026-03-30 12:04:33'),('e8ab7bf8a040eb0008fac50e6dfa71925e6cc1af0de67ad39ab21fe0cb83cd8ed240cf98b67c539a',1,1,'API Token','[]',0,'2025-02-20 16:55:31','2025-02-20 16:55:31','2026-02-20 16:55:31'),('e91c4979582955f18c2736a096f4878b9f223603ef704c3165a6eaa7e6df2317fd9630d5e30c79fa',53,1,'API Token','[]',0,'2025-03-05 09:14:51','2025-03-05 09:14:51','2026-03-05 09:14:51'),('ea19877be4a4d0bdc4d0bc59e0e85f07a0020ac2d6c067021e3ff9fed93dd84a0c23003f4a8b3949',69,1,'API Token','[]',0,'2025-03-19 00:47:31','2025-03-19 00:47:31','2026-03-19 00:47:31'),('eaf61892e6f62e64b525e4d5c90d52f596bc7142e609620e01efba79bf3cebed250d6a5bfd9cd171',1,1,'API Token','[]',0,'2025-02-16 16:21:49','2025-02-16 16:21:49','2026-02-16 16:21:49'),('ebf68c0d6a2d6fc561a76fe8b556a4a32c249f8033a3f5d7c6f909316b8505f62314a01982c6331d',26,1,'API Token','[]',0,'2025-03-12 11:54:03','2025-03-12 11:54:03','2026-03-12 11:54:03'),('ec9ce16c3c9faf0aae360e8ef4bb18b1a8282fbc68b93348024a2116dab905936c861b83a6530264',37,1,'API Token','[]',0,'2025-02-26 07:25:09','2025-02-26 07:25:09','2026-02-26 07:25:09'),('ece20b30ec2e3783e28b508a7abbe4c2239c71ea18bbbdebbf5d1ef312107c5e211ade43fb441545',20,1,'API Token','[]',0,'2025-02-23 16:24:41','2025-02-23 16:24:41','2026-02-23 16:24:41'),('ecf3fb3a498cb018749baed2abe9fbcdfdec9e1c705e1fecc8d93cfd73c1f75d12e0aef9e87af7c8',83,1,'API Token','[]',0,'2025-04-17 14:54:55','2025-04-17 14:54:55','2026-04-17 09:54:55'),('ed2d493a16f9fef01c78e7f0bbc6e2a2ee5c014e3291bbd8bace621f6e2ec4b35b584738a0e3b42d',65,1,'API Token','[]',0,'2025-03-17 19:35:13','2025-03-17 19:35:13','2026-03-17 19:35:13'),('ed3b27bf3c7e9b52c51bcb7c31496132e11fe6a5b618d508b32dc5b06f88c6659ff8d224929c3deb',1,1,'API Token','[]',0,'2025-06-07 17:42:23','2025-06-07 17:42:23','2026-06-07 12:42:23'),('edba74d7dd326227d04b4cbce0f265563e7075f7618a4af545659625653b29672994d69bc0d9332b',19,1,'API Token','[]',0,'2025-03-13 14:16:29','2025-03-13 14:16:29','2026-03-13 14:16:29'),('ef21ef2667de4d5a444f9b6702bb65476be0baa3daf31c0688672d4828261409c288f8f583db5664',11,1,'API Token','[]',0,'2025-02-13 09:04:42','2025-02-13 09:04:42','2026-02-13 09:04:42'),('f0619da3dff4eb6f56a3aaa8319b4a368211135be6019f98e1d546a1622208358bc8f281a60c60fe',26,1,'API Token','[]',0,'2025-03-16 20:37:56','2025-03-16 20:37:56','2026-03-16 20:37:56'),('f0f4f845ffb9a4bdcb3e2f3c80e91d139fa0c097a99dd8b1749c5453c45bdede51e859ddd1aa324f',45,1,'API Token','[]',0,'2025-02-28 17:59:00','2025-02-28 17:59:00','2026-02-28 17:59:00'),('f23e21f0f8231f2baadd3ca361e352a45786a30caf667d916f9088aba1a4d7356ea9982c4383d34b',20,1,'API Token','[]',0,'2025-02-27 13:11:05','2025-02-27 13:11:05','2026-02-27 13:11:05'),('f47878377817a8a8e68401b883c9229b75ad283f6a501ec1ed37488b5dd56b52bcb97613aab3f00c',19,1,'API Token','[]',0,'2025-03-23 17:31:40','2025-03-23 17:31:40','2026-03-23 17:31:40'),('f4a7d768cd2ba4ee018aec532c1ecbbe90f6eb67b4c7d05d1d684c106517d6e66e25c60d6e3b61bf',5,1,'API Token','[]',0,'2025-02-13 13:53:35','2025-02-13 13:53:35','2026-02-13 13:53:35'),('f5e48a83fb0ca65e79b8b0a04ec1e682657d8d6505e340702f159d4a4b6f991a727b87568597c15a',1,1,'API Token','[]',0,'2025-04-16 20:47:32','2025-04-16 20:47:32','2026-04-16 15:47:32'),('f63817f186a5a96849a583a8ba58ae9931480335df05993cad63f72b6a949e8bfe9fde4b2ee03fea',5,1,'API Token','[]',0,'2025-02-13 08:18:00','2025-02-13 08:18:00','2026-02-13 08:18:00'),('f6c9a679a264b4eaff5ae827ace7b2f7631ac367d526f1c3975c357b31d69a56bcea2481ecc0bddb',30,1,'API Token','[]',0,'2025-02-23 16:24:07','2025-02-23 16:24:07','2026-02-23 16:24:07'),('f6e569771215629f5f1701e61b850fd27587ae296739b7322358344ddf4575384f430fc6b3d4b7e2',20,1,'API Token','[]',0,'2025-02-20 15:48:12','2025-02-20 15:48:12','2026-02-20 15:48:12'),('f757687a9077b29f994d5e7b4e867f117a3bb67e17ce5eaadce3a6727d7468c8d879571d47732eba',26,1,'API Token','[]',0,'2025-02-25 17:25:36','2025-02-25 17:25:36','2026-02-25 17:25:36'),('f7d0efbfd4ca91fac5a7a0ddef4681b6dee37ff82bfba34e2354ef3b0a710739ed8fcdf7fbc37a24',19,1,'API Token','[]',0,'2025-03-19 20:16:17','2025-03-19 20:16:17','2026-03-19 20:16:17'),('f89253034f9469c9e32caab257fbfc698e223fa7c58dfa3c9f35fcdf1e42c40dc78d9bbc20eaef8c',19,1,'API Token','[]',0,'2025-03-24 11:13:33','2025-03-24 11:13:33','2026-03-24 11:13:33'),('fa3e44ce427a02e40773480130d21ed6fdf8e1610cfebed6c24e461e736d2ca2b233b8ad11525bdb',20,1,'API Token','[]',0,'2025-02-27 13:07:33','2025-02-27 13:07:33','2026-02-27 13:07:33'),('fa910efb5cdce434f0a260e3a326a4777163a3bab7660631221c98247cf4ca23281344b72578c170',79,1,'API Token','[]',0,'2025-03-30 19:04:21','2025-03-30 19:04:21','2026-03-30 14:04:21'),('fb212b6091988c59adae31c5489169e5faf57b0d54ff0b628a5a9524991d07b5f70261ddfa164f72',60,1,'API Token','[]',0,'2025-08-13 16:11:41','2025-08-13 16:11:41','2026-08-13 11:11:41'),('fb4871129ccf124bdb7cf644127288c8f8d8510efdaa8ee64eaa76f42272a6db2058648a58e02f47',1,1,'API Token','[]',0,'2025-02-18 09:31:10','2025-02-18 09:31:10','2026-02-18 09:31:10'),('fc9a5362eac8a13939d5adbac804c6b617ebbf5be46f454d32f0192f944e70e200c80b32e753d311',1,1,'API Token','[]',0,'2025-04-08 00:16:53','2025-04-08 00:16:53','2026-04-07 19:16:53'),('ffe2da13e458de142c653c022880f9774ae46e275c4f8e0cb3c740386ac653d54fefd1179351fbbf',20,1,'API Token','[]',0,'2025-02-23 15:24:05','2025-02-23 15:24:05','2026-02-23 15:24:05'),('ffeafc25c5503cef7dc00e68e0002bf301f43ffd04c32d4c8398daaff958f67f6d862e2828bdd79e',1,1,'API Token','[]',0,'2025-02-19 09:50:45','2025-02-19 09:50:45','2026-02-19 09:50:45');
/*!40000 ALTER TABLE `oauth_access_tokens` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `oauth_auth_codes`
--

DROP TABLE IF EXISTS `oauth_auth_codes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `oauth_auth_codes` (
  `id` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint(20) unsigned NOT NULL,
  `client_id` bigint(20) unsigned NOT NULL,
  `scopes` text COLLATE utf8mb4_unicode_ci,
  `revoked` tinyint(1) NOT NULL,
  `expires_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `oauth_auth_codes_user_id_index` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `oauth_auth_codes`
--

LOCK TABLES `oauth_auth_codes` WRITE;
/*!40000 ALTER TABLE `oauth_auth_codes` DISABLE KEYS */;
/*!40000 ALTER TABLE `oauth_auth_codes` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `oauth_clients`
--

DROP TABLE IF EXISTS `oauth_clients`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `oauth_clients` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) unsigned DEFAULT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `secret` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `provider` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `redirect` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `personal_access_client` tinyint(1) NOT NULL,
  `password_client` tinyint(1) NOT NULL,
  `revoked` tinyint(1) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `oauth_clients_user_id_index` (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `oauth_clients`
--

LOCK TABLES `oauth_clients` WRITE;
/*!40000 ALTER TABLE `oauth_clients` DISABLE KEYS */;
INSERT INTO `oauth_clients` (`id`, `user_id`, `name`, `secret`, `provider`, `redirect`, `personal_access_client`, `password_client`, `revoked`, `created_at`, `updated_at`) VALUES (1,NULL,'Laravel Personal Access Client','eAbF2eSGiEt4Q6IdeOILTtmQVnJ9LBRGCx50YDUk',NULL,'http://localhost',1,0,0,'2025-02-13 07:48:09','2025-02-13 07:48:09'),(2,NULL,'Laravel Password Grant Client','DCc6lJmwRCKLwTafFbjSNqJ1LFAAWdvzfVH8p3KX','users','http://localhost',0,1,0,'2025-02-13 07:48:09','2025-02-13 07:48:09');
/*!40000 ALTER TABLE `oauth_clients` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `oauth_personal_access_clients`
--

DROP TABLE IF EXISTS `oauth_personal_access_clients`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `oauth_personal_access_clients` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `client_id` bigint(20) unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `oauth_personal_access_clients`
--

LOCK TABLES `oauth_personal_access_clients` WRITE;
/*!40000 ALTER TABLE `oauth_personal_access_clients` DISABLE KEYS */;
INSERT INTO `oauth_personal_access_clients` (`id`, `client_id`, `created_at`, `updated_at`) VALUES (1,1,'2025-02-13 07:48:09','2025-02-13 07:48:09');
/*!40000 ALTER TABLE `oauth_personal_access_clients` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `oauth_refresh_tokens`
--

DROP TABLE IF EXISTS `oauth_refresh_tokens`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `oauth_refresh_tokens` (
  `id` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `access_token_id` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `revoked` tinyint(1) NOT NULL,
  `expires_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `oauth_refresh_tokens_access_token_id_index` (`access_token_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `oauth_refresh_tokens`
--

LOCK TABLES `oauth_refresh_tokens` WRITE;
/*!40000 ALTER TABLE `oauth_refresh_tokens` DISABLE KEYS */;
/*!40000 ALTER TABLE `oauth_refresh_tokens` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `offer_translations`
--

DROP TABLE IF EXISTS `offer_translations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `offer_translations` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `subtitle` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `offer_id` bigint(20) unsigned NOT NULL,
  `locale` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `offer_translations_offer_id_locale_unique` (`offer_id`,`locale`),
  KEY `offer_translations_locale_index` (`locale`),
  CONSTRAINT `offer_translations_offer_id_foreign` FOREIGN KEY (`offer_id`) REFERENCES `offers` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=25 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `offer_translations`
--

LOCK TABLES `offer_translations` WRITE;
/*!40000 ALTER TABLE `offer_translations` DISABLE KEYS */;
INSERT INTO `offer_translations` (`id`, `title`, `subtitle`, `description`, `offer_id`, `locale`, `created_at`, `updated_at`) VALUES (1,'دعاية',NULL,'Vivamus aliquet rutrum dui a varius. Mauris ornare tortor in eleifend blanditullam ut ligula et neque.',1,'ar','2025-02-12 09:07:54','2025-02-12 09:07:54'),(2,'ADVERTISING','Vivamus aliquet rutrum dui a varius. Mauris ornare tortor in eleifend blanditullam ut ligula et neque.',NULL,1,'en','2025-02-12 09:07:54','2025-02-12 09:07:54'),(3,'احجز جلسة تدريب شخصية مجانية',NULL,'Vivamus aliquet rutrum dui a varius. Mauris ornare tortor in eleifend blanditullam ut ligula et neque.',2,'ar','2025-02-12 09:07:54','2025-02-12 09:07:54'),(4,'BOOK A FREE PERSONAL TRAINING SESSION','Vivamus aliquet rutrum dui a varius. Mauris ornare tortor in eleifend blanditullam ut ligula et neque.',NULL,2,'en','2025-02-12 09:07:54','2025-02-12 09:07:54'),(5,'دعاية',NULL,'Vivamus aliquet rutrum dui a varius. Mauris ornare tortor in eleifend blanditullam ut ligula et neque.',3,'ar','2025-02-12 09:07:54','2025-02-12 09:07:54'),(6,'ADVERTISING','Vivamus aliquet rutrum dui a varius. Mauris ornare tortor in eleifend blanditullam ut ligula et neque.',NULL,3,'en','2025-02-12 09:07:54','2025-02-12 09:07:54'),(7,'اللياقة البدنية الداخلية',NULL,'Vivamus aliquet rutrum dui a varius. Mauris ornare tortor in eleifend blanditullam ut ligula et neque.',4,'ar','2025-02-12 09:07:54','2025-02-12 09:07:54'),(8,'INDOOR FITNESS','Vivamus aliquet rutrum dui a varius. Mauris ornare tortor in eleifend blanditullam ut ligula et neque.',NULL,4,'en','2025-02-12 09:07:54','2025-02-12 09:07:54'),(9,'اللياقة البدنية فنون القتال المختلطة',NULL,'Vivamus aliquet rutrum dui a varius. Mauris ornare tortor in eleifend blanditullam ut ligula et neque.',5,'ar','2025-02-12 09:07:54','2025-02-12 09:07:54'),(10,'MMA FITNESS','Vivamus aliquet rutrum dui a varius. Mauris ornare tortor in eleifend blanditullam ut ligula et neque.',NULL,5,'en','2025-02-12 09:07:54','2025-02-12 09:07:54'),(11,'اللياقة البدنية في الهواء الطلق',NULL,'Vivamus aliquet rutrum dui a varius. Mauris ornare tortor in eleifend blanditullam ut ligula et neque.',6,'ar','2025-02-12 09:07:54','2025-02-12 09:07:54'),(12,'OUTDOOR FITNESS','Vivamus aliquet rutrum dui a varius. Mauris ornare tortor in eleifend blanditullam ut ligula et neque.',NULL,6,'en','2025-02-12 09:07:54','2025-02-12 09:07:54'),(13,'جلسة المقاومة الإسبارطية',NULL,'Vivamus aliquet rutrum dui a varius. Mauris ornare tortor in eleifend blanditullam ut ligula et neque.',7,'ar','2025-02-12 09:07:54','2025-02-12 09:07:54'),(14,'SPARTAN RESISTANCE SESSION','Vivamus aliquet rutrum dui a varius. Mauris ornare tortor in eleifend blanditullam ut ligula et neque.',NULL,7,'en','2025-02-12 09:07:54','2025-02-12 09:07:54'),(15,'معسكر الشاطئ التدريبي',NULL,'Vivamus aliquet rutrum dui a varius. Mauris ornare tortor in eleifend blanditullam ut ligula et neque.',8,'ar','2025-02-12 09:07:54','2025-02-12 09:07:54'),(16,'BEACH BOOTCAMP','Vivamus aliquet rutrum dui a varius. Mauris ornare tortor in eleifend blanditullam ut ligula et neque.',NULL,8,'en','2025-02-12 09:07:54','2025-02-12 09:07:54'),(17,'جلسة وظائف الجسم بالكامل',NULL,'Vivamus aliquet rutrum dui a varius. Mauris ornare tortor in eleifend blanditullam ut ligula et neque.',9,'ar','2025-02-12 09:07:54','2025-02-12 09:07:54'),(18,'FULL BODY FUNC SESSION','Vivamus aliquet rutrum dui a varius. Mauris ornare tortor in eleifend blanditullam ut ligula et neque.',NULL,9,'en','2025-02-12 09:07:54','2025-02-12 09:07:54'),(19,'دعاية',NULL,'Vivamus aliquet rutrum dui a varius. Mauris ornare tortor in eleifend blanditullam ut ligula et neque.',10,'ar','2025-02-12 09:07:54','2025-02-12 09:07:54'),(20,'ADVERTISING','Vivamus aliquet rutrum dui a varius. Mauris ornare tortor in eleifend blanditullam ut ligula et neque.',NULL,10,'en','2025-02-12 09:07:54','2025-02-12 09:07:54'),(21,'خطة النظام الغذائي والتغذية',NULL,'Vivamus aliquet rutrum dui a varius. Mauris ornare tortor in eleifend blanditullam ut ligula et neque.',11,'ar','2025-02-12 09:07:54','2025-02-12 09:07:54'),(22,'DIET & NUTRITION PLAN','Vivamus aliquet rutrum dui a varius. Mauris ornare tortor in eleifend blanditullam ut ligula et neque.',NULL,11,'en','2025-02-12 09:07:54','2025-02-12 09:07:54'),(23,'دعاية',NULL,'Vivamus aliquet rutrum dui a varius. Mauris ornare tortor in eleifend blanditullam ut ligula et neque.',12,'ar','2025-02-12 09:07:54','2025-02-12 09:07:54'),(24,'ADVERTISING','Vivamus aliquet rutrum dui a varius. Mauris ornare tortor in eleifend blanditullam ut ligula et neque.',NULL,12,'en','2025-02-12 09:07:54','2025-02-12 09:07:54');
/*!40000 ALTER TABLE `offer_translations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `offers`
--

DROP TABLE IF EXISTS `offers`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `offers` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `icon` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `offers`
--

LOCK TABLES `offers` WRITE;
/*!40000 ALTER TABLE `offers` DISABLE KEYS */;
INSERT INTO `offers` (`id`, `icon`, `created_at`, `updated_at`) VALUES (1,NULL,'2025-02-12 09:07:54','2025-02-12 09:07:54'),(2,NULL,'2025-02-12 09:07:54','2025-02-12 09:07:54'),(3,NULL,'2025-02-12 09:07:54','2025-02-12 09:07:54'),(4,NULL,'2025-02-12 09:07:54','2025-02-12 09:07:54'),(5,NULL,'2025-02-12 09:07:54','2025-02-12 09:07:54'),(6,NULL,'2025-02-12 09:07:54','2025-02-12 09:07:54'),(7,NULL,'2025-02-12 09:07:54','2025-02-12 09:07:54'),(8,NULL,'2025-02-12 09:07:54','2025-02-12 09:07:54'),(9,NULL,'2025-02-12 09:07:54','2025-02-12 09:07:54'),(10,NULL,'2025-02-12 09:07:54','2025-02-12 09:07:54'),(11,NULL,'2025-02-12 09:07:54','2025-02-12 09:07:54'),(12,NULL,'2025-02-12 09:07:54','2025-02-12 09:07:54');
/*!40000 ALTER TABLE `offers` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `orderproducts`
--

DROP TABLE IF EXISTS `orderproducts`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `orderproducts` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `count` bigint(20) unsigned NOT NULL,
  `total` double DEFAULT NULL,
  `product_id` bigint(20) unsigned NOT NULL,
  `order_id` bigint(20) unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `orderproducts_product_id_foreign` (`product_id`),
  KEY `orderproducts_order_id_foreign` (`order_id`),
  CONSTRAINT `orderproducts_order_id_foreign` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE,
  CONSTRAINT `orderproducts_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=392 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `orderproducts`
--

LOCK TABLES `orderproducts` WRITE;
/*!40000 ALTER TABLE `orderproducts` DISABLE KEYS */;
/*!40000 ALTER TABLE `orderproducts` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `orders`
--

DROP TABLE IF EXISTS `orders`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `orders` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `phone` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `total` double DEFAULT NULL,
  `user_id` bigint(20) unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `status` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pending' COMMENT 'pending,in_processing,cancelled,shipped,out_for_delivery,delivered,refunded,returned',
  `cancelReason` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `transaction_reference` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `payment_method` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'digital_payment',
  `payment_status` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'unpaid',
  `refunded_at` timestamp NULL DEFAULT NULL,
  `payment_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'cards, apple_pay, stc_pay, wallet',
  `paid_at` timestamp NULL DEFAULT NULL,
  `cancelled_by` int(11) DEFAULT NULL COMMENT '1->customer, 2->merchant, 3->app, 4->timeout',
  `pending_at` timestamp NULL DEFAULT NULL,
  `in_processing_at` timestamp NULL DEFAULT NULL,
  `cancelled_at` timestamp NULL DEFAULT NULL,
  `shipped_at` timestamp NULL DEFAULT NULL,
  `out_for_delivery_at` timestamp NULL DEFAULT NULL,
  `delivered_at` timestamp NULL DEFAULT NULL,
  `returned_at` timestamp NULL DEFAULT NULL,
  `address` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `orders_user_id_foreign` (`user_id`),
  CONSTRAINT `orders_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=299 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `orders`
--

LOCK TABLES `orders` WRITE;
/*!40000 ALTER TABLE `orders` DISABLE KEYS */;
INSERT INTO `orders` (`id`, `name`, `email`, `phone`, `total`, `user_id`, `created_at`, `updated_at`, `status`, `cancelReason`, `transaction_reference`, `payment_method`, `payment_status`, `refunded_at`, `payment_name`, `paid_at`, `cancelled_by`, `pending_at`, `in_processing_at`, `cancelled_at`, `shipped_at`, `out_for_delivery_at`, `delivered_at`, `returned_at`, `address`) VALUES (246,NULL,NULL,NULL,0,1,'2025-03-30 08:42:53','2025-03-30 08:42:53','pending',NULL,'8bef4770-79b4-4db8-be7f-fbb8f01d443d','wallet','paid',NULL,'wallet','2025-03-30 08:42:53',NULL,'2025-03-30 08:42:53',NULL,NULL,NULL,NULL,NULL,NULL,NULL),(247,NULL,NULL,NULL,0,1,'2025-03-30 16:46:42','2025-03-30 16:46:42','pending',NULL,'5e1862e1-4ee9-4d6b-8edf-df070d7b9135','wallet','paid',NULL,'wallet','2025-03-30 16:46:42',NULL,'2025-03-30 16:46:42',NULL,NULL,NULL,NULL,NULL,NULL,NULL),(248,NULL,NULL,NULL,0,1,'2025-03-30 18:42:26','2025-03-30 18:42:26','pending',NULL,'b0727a03-ad1f-49bc-9456-119acdbf332c','wallet','paid',NULL,'wallet','2025-03-30 18:42:26',NULL,'2025-03-30 18:42:26',NULL,NULL,NULL,NULL,NULL,NULL,NULL),(251,NULL,NULL,NULL,4921,1,'2025-03-31 00:45:19','2025-03-31 00:45:19','pending',NULL,'9ef32967-bfe4-4c49-a2f4-b1bd5803fa89','wallet','paid',NULL,'wallet','2025-03-31 00:45:19',NULL,'2025-03-31 00:45:19',NULL,NULL,NULL,NULL,NULL,NULL,NULL),(252,NULL,NULL,NULL,0,1,'2025-03-31 00:48:15','2025-03-31 00:48:15','pending',NULL,'6b8ba012-1bb7-4f8d-8743-2ff97a2b710f','wallet','paid',NULL,'wallet','2025-03-31 00:48:15',NULL,'2025-03-31 00:48:15',NULL,NULL,NULL,NULL,NULL,NULL,NULL),(253,NULL,NULL,NULL,0,1,'2025-03-31 00:50:28','2025-03-31 00:50:28','pending',NULL,'572445c7-7725-46f2-af53-524ce8c02248','wallet','paid',NULL,'wallet','2025-03-31 00:50:28',NULL,'2025-03-31 00:50:28',NULL,NULL,NULL,NULL,NULL,NULL,NULL),(254,NULL,NULL,NULL,753,1,'2025-03-31 00:51:20','2025-03-31 00:51:20','pending',NULL,'a9a64589-e300-46b3-a585-580d2b53d432','wallet','paid',NULL,'wallet','2025-03-31 00:51:20',NULL,'2025-03-31 00:51:20',NULL,NULL,NULL,NULL,NULL,NULL,NULL),(255,NULL,NULL,NULL,0,1,'2025-03-31 00:53:14','2025-03-31 00:53:14','pending',NULL,'629f23b3-5124-4caf-882b-93c83ff8e181','wallet','paid',NULL,'wallet','2025-03-31 00:53:14',NULL,'2025-03-31 00:53:14',NULL,NULL,NULL,NULL,NULL,NULL,NULL),(256,NULL,NULL,NULL,753,1,'2025-03-31 00:53:25','2025-03-31 00:53:25','pending',NULL,'439e451f-b10b-4ed1-9134-ce5f95101283','wallet','paid',NULL,'wallet','2025-03-31 00:53:25',NULL,'2025-03-31 00:53:25',NULL,NULL,NULL,NULL,NULL,NULL,NULL),(257,NULL,NULL,NULL,0,1,'2025-03-31 01:44:13','2025-03-31 01:44:13','pending',NULL,'3f866f67-bea8-4d05-967d-3aaa86c1869d','wallet','paid',NULL,'wallet','2025-03-31 01:44:13',NULL,'2025-03-31 01:44:13',NULL,NULL,NULL,NULL,NULL,NULL,NULL),(258,NULL,NULL,NULL,1000,1,'2025-03-31 01:58:04','2025-03-31 01:58:04','pending',NULL,'bc4137b4-6047-46ec-8424-ab513ad1fdd7','wallet','paid',NULL,'wallet','2025-03-31 01:58:04',NULL,'2025-03-31 01:58:04',NULL,NULL,NULL,NULL,NULL,NULL,NULL),(259,NULL,NULL,NULL,1676,1,'2025-03-31 02:15:10','2025-03-31 02:15:10','pending',NULL,'bcfdffa5-1f83-4034-84b7-e2e5ac1f9db9','wallet','paid',NULL,'wallet','2025-03-31 02:15:10',NULL,'2025-03-31 02:15:10',NULL,NULL,NULL,NULL,NULL,NULL,NULL),(260,NULL,NULL,NULL,3012,1,'2025-03-31 02:22:31','2025-03-31 02:22:31','pending',NULL,'0886e668-bfd2-4939-9a5b-b28461dc2b33','wallet','paid',NULL,'wallet','2025-03-31 02:22:31',NULL,'2025-03-31 02:22:31',NULL,NULL,NULL,NULL,NULL,NULL,NULL),(261,NULL,NULL,NULL,1583,1,'2025-03-31 02:24:41','2025-03-31 02:24:41','pending',NULL,'e0b315a1-9ff8-4996-bf89-aec1a005ac9a','wallet','paid',NULL,'wallet','2025-03-31 02:24:41',NULL,'2025-03-31 02:24:41',NULL,NULL,NULL,NULL,NULL,NULL,NULL),(262,NULL,NULL,NULL,0,1,'2025-03-31 02:25:18','2025-03-31 02:25:18','pending',NULL,'560f6e86-0c41-44b7-9253-27757a3f0fd5','wallet','paid',NULL,'wallet','2025-03-31 02:25:18',NULL,'2025-03-31 02:25:18',NULL,NULL,NULL,NULL,NULL,NULL,NULL),(263,NULL,NULL,NULL,394,1,'2025-03-31 02:26:13','2025-03-31 02:26:13','pending',NULL,'aab87b00-c701-49a2-9a05-64100dffea12','wallet','paid',NULL,'wallet','2025-03-31 02:26:13',NULL,'2025-03-31 02:26:13',NULL,NULL,NULL,NULL,NULL,NULL,NULL),(264,NULL,NULL,NULL,1691,1,'2025-03-31 02:44:50','2025-03-31 02:44:50','pending',NULL,'18be6c84-ed80-4400-84b0-240289d60c6d','wallet','paid',NULL,'wallet','2025-03-31 02:44:50',NULL,'2025-03-31 02:44:50',NULL,NULL,NULL,NULL,NULL,NULL,NULL),(265,NULL,NULL,NULL,753,1,'2025-03-31 02:46:12','2025-03-31 02:46:12','pending',NULL,'8ddf1df0-8a05-40ce-9908-df7d94f653a7','wallet','paid',NULL,'wallet','2025-03-31 02:46:12',NULL,'2025-03-31 02:46:12',NULL,NULL,NULL,NULL,NULL,NULL,NULL),(266,NULL,NULL,NULL,0,1,'2025-03-31 02:47:37','2025-03-31 02:47:37','pending',NULL,'112fbb33-0437-47bd-a3a8-b60be7664c62','wallet','paid',NULL,'wallet','2025-03-31 02:47:37',NULL,'2025-03-31 02:47:37',NULL,NULL,NULL,NULL,NULL,NULL,NULL),(267,NULL,NULL,NULL,1000,1,'2025-03-31 02:48:06','2025-03-31 02:48:06','pending',NULL,'9ecd267d-44bf-4eae-82ed-92e9d04f6963','wallet','paid',NULL,'wallet','2025-03-31 02:48:06',NULL,'2025-03-31 02:48:06',NULL,NULL,NULL,NULL,NULL,NULL,NULL),(268,NULL,NULL,NULL,1778,1,'2025-03-31 03:02:28','2025-03-31 03:02:28','pending',NULL,'46783faa-9890-464d-b6f7-13388a5ccac9','wallet','paid',NULL,'wallet','2025-03-31 03:02:28',NULL,'2025-03-31 03:02:28',NULL,NULL,NULL,NULL,NULL,NULL,NULL),(269,NULL,NULL,NULL,1506,1,'2025-03-31 03:07:29','2025-03-31 03:07:29','pending',NULL,'0313fe6c-9254-4c2e-9fa1-cef5311d57f8','wallet','paid',NULL,'wallet','2025-03-31 03:07:29',NULL,'2025-03-31 03:07:29',NULL,NULL,NULL,NULL,NULL,NULL,NULL),(270,NULL,NULL,NULL,1691,1,'2025-04-07 19:49:38','2025-04-07 19:49:38','pending',NULL,'9b10d978-f3b3-402d-a18a-34ed73a22dd5','wallet','paid',NULL,'wallet','2025-04-07 19:49:38',NULL,'2025-04-07 19:49:38',NULL,NULL,NULL,NULL,NULL,NULL,NULL),(271,NULL,NULL,NULL,0,1,'2025-04-07 19:50:03','2025-04-07 19:50:03','pending',NULL,'742e2cd4-7f6e-4b2c-8f5a-aea4096a9f68','wallet','paid',NULL,'wallet','2025-04-07 19:50:03',NULL,'2025-04-07 19:50:03',NULL,NULL,NULL,NULL,NULL,NULL,NULL),(272,NULL,NULL,NULL,923,1,'2025-04-07 19:50:47','2025-04-07 19:50:47','pending',NULL,'aa5b7dc1-1702-4ac8-b098-e00e06eabd2b','wallet','paid',NULL,'wallet','2025-04-07 19:50:47',NULL,'2025-04-07 19:50:47',NULL,NULL,NULL,NULL,NULL,NULL,NULL),(273,NULL,NULL,NULL,753,1,'2025-04-07 20:07:57','2025-04-07 20:07:57','pending',NULL,'9cba6b9c-2710-4c5a-8508-9f96fed1f608','wallet','paid',NULL,'wallet','2025-04-07 20:07:57',NULL,'2025-04-07 20:07:57',NULL,NULL,NULL,NULL,NULL,NULL,NULL),(274,NULL,NULL,NULL,0,1,'2025-04-07 20:09:48','2025-04-07 20:09:48','pending',NULL,'fc3b21a3-0480-4eff-9266-71a82369aca6','wallet','paid',NULL,'wallet','2025-04-07 20:09:48',NULL,'2025-04-07 20:09:48',NULL,NULL,NULL,NULL,NULL,NULL,NULL),(275,NULL,NULL,NULL,0,1,'2025-04-07 20:10:33','2025-04-07 20:10:33','pending',NULL,'ba90864a-b1c0-4437-b31c-26c274b31421','wallet','paid',NULL,'wallet','2025-04-07 20:10:33',NULL,'2025-04-07 20:10:33',NULL,NULL,NULL,NULL,NULL,NULL,NULL),(276,NULL,NULL,NULL,0,1,'2025-04-07 20:10:44','2025-04-07 20:10:44','pending',NULL,'a3715c51-3742-4f7a-86e2-ee084151fbde','wallet','paid',NULL,'wallet','2025-04-07 20:10:44',NULL,'2025-04-07 20:10:44',NULL,NULL,NULL,NULL,NULL,NULL,NULL),(277,NULL,NULL,NULL,0,1,'2025-04-16 20:50:04','2025-04-16 20:50:04','pending',NULL,'7cd97663-3c20-437c-9c50-35c56dfc294c','wallet','paid',NULL,'wallet','2025-04-16 20:50:04',NULL,'2025-04-16 20:50:04',NULL,NULL,NULL,NULL,NULL,NULL,NULL),(278,NULL,NULL,NULL,1830,82,'2025-04-16 20:50:31','2025-04-16 20:50:31','pending',NULL,'4abef61d-ba51-4190-a206-401aff454187','wallet','paid',NULL,'wallet','2025-04-16 20:50:31',NULL,'2025-04-16 20:50:31',NULL,NULL,NULL,NULL,NULL,NULL,'1'),(279,NULL,NULL,NULL,0,1,'2025-04-16 20:51:58','2025-04-16 20:51:58','pending',NULL,'547326d9-a7c0-40eb-9424-7bda98e0d1d8','wallet','paid',NULL,'wallet','2025-04-16 20:51:58',NULL,'2025-04-16 20:51:58',NULL,NULL,NULL,NULL,NULL,NULL,'cairo'),(280,NULL,NULL,NULL,753,82,'2025-04-16 20:55:20','2025-04-16 20:55:20','pending',NULL,'52fda3db-beaf-423d-b6d0-252e0e316fba','wallet','paid',NULL,'wallet','2025-04-16 20:55:20',NULL,'2025-04-16 20:55:20',NULL,NULL,NULL,NULL,NULL,NULL,'Hic voluptatem duis'),(281,NULL,NULL,NULL,1583,82,'2025-04-16 20:56:13','2025-04-16 20:56:13','pending',NULL,'fce16cd4-e1f4-4724-a28b-fe266eeb6765','wallet','paid',NULL,'wallet','2025-04-16 20:56:13',NULL,'2025-04-16 20:56:13',NULL,NULL,NULL,NULL,NULL,NULL,'Hic voluptatem duis'),(282,NULL,NULL,NULL,923,82,'2025-04-16 20:58:11','2025-04-16 20:58:11','pending',NULL,'85a6fe97-5073-4267-8d73-d1d2fd7945f7','wallet','paid',NULL,'wallet','2025-04-16 20:58:11',NULL,'2025-04-16 20:58:11',NULL,NULL,NULL,NULL,NULL,NULL,NULL),(283,NULL,NULL,NULL,923,82,'2025-04-16 21:01:15','2025-04-16 21:01:15','pending',NULL,'60b2cfcf-d59c-418e-876e-c9565fc43e18','wallet','paid',NULL,'wallet','2025-04-16 21:01:15',NULL,'2025-04-16 21:01:15',NULL,NULL,NULL,NULL,NULL,NULL,'giza'),(284,NULL,NULL,NULL,1753,82,'2025-04-16 21:23:36','2025-04-16 21:23:36','pending',NULL,'b246662a-bc67-4bf4-8579-c5e181e57902','wallet','paid',NULL,'wallet','2025-04-16 21:23:36',NULL,'2025-04-16 21:23:36',NULL,NULL,NULL,NULL,NULL,NULL,NULL),(285,NULL,NULL,NULL,753,1,'2025-04-22 21:44:52','2025-04-22 21:44:52','pending',NULL,'f00aa0b2-46ae-4a8e-ae41-a130b398980d','wallet','paid',NULL,'wallet','2025-04-22 21:44:52',NULL,'2025-04-22 21:44:52',NULL,NULL,NULL,NULL,NULL,NULL,'qjhjqhdjqhwd'),(286,NULL,NULL,NULL,0,1,'2025-04-22 21:45:12','2025-04-22 21:45:12','pending',NULL,'6938955e-4d00-41c2-a773-87062c16d02c','wallet','paid',NULL,'wallet','2025-04-22 21:45:12',NULL,'2025-04-22 21:45:12',NULL,NULL,NULL,NULL,NULL,NULL,'qjhjqhdjqhwd'),(288,NULL,NULL,NULL,3750,1,'2025-06-07 17:45:39','2025-06-07 17:45:39','pending',NULL,'8cfea714-5a41-444f-b8e4-b061abaa19b4','wallet','paid',NULL,'wallet','2025-06-07 17:45:39',NULL,'2025-06-07 17:45:39',NULL,NULL,NULL,NULL,NULL,NULL,'cairo'),(289,NULL,NULL,NULL,0,1,'2025-06-07 17:46:38','2025-06-07 17:46:38','pending',NULL,'3d7bcd7e-3687-4ea1-ad9a-8b7235229ccb','wallet','paid',NULL,'wallet','2025-06-07 17:46:38',NULL,'2025-06-07 17:46:38',NULL,NULL,NULL,NULL,NULL,NULL,'cairo'),(292,NULL,NULL,NULL,0,1,'2025-06-07 17:55:22','2025-06-07 17:55:22','pending',NULL,'41b2c336-672f-48de-8041-f3ed4922f34d','wallet','paid',NULL,'wallet','2025-06-07 17:55:22',NULL,'2025-06-07 17:55:22',NULL,NULL,NULL,NULL,NULL,NULL,'cairo'),(293,NULL,NULL,NULL,3750,1,'2025-06-07 18:01:06','2025-06-07 18:01:06','pending',NULL,'164bd904-f6d0-4c52-b45b-41577a75e1cc','wallet','paid',NULL,'wallet','2025-06-07 18:01:06',NULL,'2025-06-07 18:01:06',NULL,NULL,NULL,NULL,NULL,NULL,'cairo'),(294,NULL,NULL,NULL,4000,1,'2025-06-07 18:10:34','2025-06-07 18:10:34','pending',NULL,'508b75d2-f2e7-4d67-89be-74b21e5a13f1','wallet','paid',NULL,'wallet','2025-06-07 18:10:34',NULL,'2025-06-07 18:10:34',NULL,NULL,NULL,NULL,NULL,NULL,'cairo'),(295,NULL,NULL,NULL,0,1,'2025-06-07 18:17:37','2025-06-07 18:17:37','pending',NULL,'ae9dbabe-f1c7-458a-828d-365dc8b05495','wallet','paid',NULL,'wallet','2025-06-07 18:17:37',NULL,'2025-06-07 18:17:37',NULL,NULL,NULL,NULL,NULL,NULL,'cairo'),(296,NULL,NULL,NULL,0,1,'2025-06-07 18:18:44','2025-06-07 18:18:44','pending',NULL,'acd66512-fd2f-4989-b598-406b2dc46d50','wallet','paid',NULL,'wallet','2025-06-07 18:18:44',NULL,'2025-06-07 18:18:44',NULL,NULL,NULL,NULL,NULL,NULL,'cairo'),(297,NULL,NULL,NULL,3600,60,'2025-08-13 16:12:14','2025-08-13 16:12:14','pending',NULL,'e0dba11d-1609-4571-b2fa-b769a0173ac0','wallet','paid',NULL,'wallet','2025-08-13 16:12:14',NULL,'2025-08-13 16:12:14',NULL,NULL,NULL,NULL,NULL,NULL,'wsegverg'),(298,NULL,NULL,NULL,5400,86,'2025-08-13 16:27:25','2025-08-13 16:27:25','pending',NULL,'20a96bc8-ae32-4659-8525-406e46c27382','wallet','paid',NULL,'wallet','2025-08-13 16:27:25',NULL,'2025-08-13 16:27:25',NULL,NULL,NULL,NULL,NULL,NULL,'Giza - 6th of October');
/*!40000 ALTER TABLE `orders` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `page_translations`
--

DROP TABLE IF EXISTS `page_translations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `page_translations` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `subtitle` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `page_id` bigint(20) unsigned NOT NULL,
  `locale` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `page_translations_page_id_locale_unique` (`page_id`,`locale`),
  KEY `page_translations_locale_index` (`locale`),
  CONSTRAINT `page_translations_page_id_foreign` FOREIGN KEY (`page_id`) REFERENCES `pages` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `page_translations`
--

LOCK TABLES `page_translations` WRITE;
/*!40000 ALTER TABLE `page_translations` DISABLE KEYS */;
INSERT INTO `page_translations` (`id`, `title`, `subtitle`, `description`, `page_id`, `locale`, `created_at`, `updated_at`) VALUES (1,'من نحن',NULL,'في <strong data-start=\"37\" data-end=\"47\">LapMob</strong>، نؤمن بأن التكنولوجيا يجب أن تمنحك القوة وتلهم حياتك اليومية. بشغف نحو الابتكار والتزام بالجودة، نحن متخصصون في توفير أحدث أجهزة اللابتوب والهواتف الذكية والإكسسوارات من أبرز العلامات التجارية العالمية. يقوم فريقنا الخبير باختيار كل منتج بعناية—سواء كنت طالبًا، محترفًا، لاعبًا، أو رائد أعمال—لنضمن لك العثور على الجهاز المثالي الذي يلبي احتياجاتك. بدءًا من أجهزة اللابتوب القوية للعمل والدراسة، وصولًا إلى الهواتف الذكية المتطورة التي تبقيك على اتصال دائم، نقدم لك تكنولوجيا تجمع بين الأداء والأناقة والموثوقية. في&nbsp;<span data-start=\"37\" data-end=\"47\" style=\"font-weight: bolder;\">LapMob</span>، كل عملية شراء هي أكثر من مجرد منتج—إنها خطوة نحو مستقبل أكثر ذكاءً، وسرعة، واتصالًا.',1,'ar','2025-04-01 14:23:24','2025-09-21 21:54:10'),(2,'About Us',NULL,'At <strong data-start=\"137\" data-end=\"155\">LapMob</strong>, we believe that technology should empower and inspire your everyday life. With a passion for innovation and a commitment to quality, we specialize in providing the latest laptops, smartphones, and accessories from top global brands. Our expert team carefully curates every product—whether you’re a student, professional, gamer, or entrepreneur—ensuring you find the perfect device to match your needs. From powerful laptops for work and study to cutting-edge mobiles that keep you connected on the go, we bring you technology that blends performance, style, and reliability. At&nbsp;<span data-start=\"137\" data-end=\"155\" style=\"font-weight: bolder;\">LapMob&nbsp;</span>Store, every purchase is more than just a product—it’s a step towards a smarter, faster, and more connected future.',1,'en','2025-04-01 14:23:24','2025-09-21 21:54:10');
/*!40000 ALTER TABLE `page_translations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `pages`
--

DROP TABLE IF EXISTS `pages`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `pages` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `identifier` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `youtube_link` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `pages`
--

LOCK TABLES `pages` WRITE;
/*!40000 ALTER TABLE `pages` DISABLE KEYS */;
INSERT INTO `pages` (`id`, `identifier`, `created_at`, `updated_at`, `youtube_link`) VALUES (1,'about','2025-04-01 14:23:24','2025-04-01 14:23:24',NULL);
/*!40000 ALTER TABLE `pages` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `password_reset_tokens`
--

DROP TABLE IF EXISTS `password_reset_tokens`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `password_reset_tokens`
--

LOCK TABLES `password_reset_tokens` WRITE;
/*!40000 ALTER TABLE `password_reset_tokens` DISABLE KEYS */;
/*!40000 ALTER TABLE `password_reset_tokens` ENABLE KEYS */;
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
INSERT INTO `password_resets` (`email`, `token`, `created_at`) VALUES ('ibrahimsamy308@gmail.com','$2y$10$R2bXxxWGGYl.H6JhK0l0g.vRWjleYulqCWpiSDp76DpmulNVTrr3.','2025-03-05 13:34:57');
/*!40000 ALTER TABLE `password_resets` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `permissions`
--

DROP TABLE IF EXISTS `permissions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `permissions` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `guard_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `permissions_name_guard_name_unique` (`name`,`guard_name`)
) ENGINE=InnoDB AUTO_INCREMENT=84 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `permissions`
--

LOCK TABLES `permissions` WRITE;
/*!40000 ALTER TABLE `permissions` DISABLE KEYS */;
INSERT INTO `permissions` (`id`, `name`, `guard_name`, `created_at`, `updated_at`) VALUES (1,'role-list','admin','2025-02-12 09:07:52','2025-02-12 09:07:52'),(2,'role-create','admin','2025-02-12 09:07:52','2025-02-12 09:07:52'),(3,'role-edit','admin','2025-02-12 09:07:52','2025-02-12 09:07:52'),(4,'role-delete','admin','2025-02-12 09:07:52','2025-02-12 09:07:52'),(5,'product-list','admin','2025-02-12 09:07:52','2025-02-12 09:07:52'),(6,'product-create','admin','2025-02-12 09:07:52','2025-02-12 09:07:52'),(7,'product-edit','admin','2025-02-12 09:07:52','2025-02-12 09:07:52'),(8,'product-delete','admin','2025-02-12 09:07:52','2025-02-12 09:07:52'),(9,'image-list','admin','2025-02-12 09:07:52','2025-02-12 09:07:52'),(10,'image-create','admin','2025-02-12 09:07:52','2025-02-12 09:07:52'),(11,'image-edit','admin','2025-02-12 09:07:52','2025-02-12 09:07:52'),(12,'image-delete','admin','2025-02-12 09:07:52','2025-02-12 09:07:52'),(13,'category-list','admin','2025-02-12 09:07:52','2025-02-12 09:07:52'),(14,'category-create','admin','2025-02-12 09:07:52','2025-02-12 09:07:52'),(15,'category-edit','admin','2025-02-12 09:07:52','2025-02-12 09:07:52'),(16,'category-delete','admin','2025-02-12 09:07:52','2025-02-12 09:07:52'),(17,'setting-edit','admin','2025-02-12 09:07:52','2025-02-12 09:07:52'),(18,'orderproduct-list','admin','2025-02-12 09:07:52','2025-02-12 09:07:52'),(19,'orderproduct-create','admin','2025-02-12 09:07:52','2025-02-12 09:07:52'),(20,'orderproduct-edit','admin','2025-02-12 09:07:52','2025-02-12 09:07:52'),(21,'orderproduct-delete','admin','2025-02-12 09:07:52','2025-02-12 09:07:52'),(22,'admin-list','admin','2025-02-12 09:07:52','2025-02-12 09:07:52'),(23,'admin-create','admin','2025-02-12 09:07:52','2025-02-12 09:07:52'),(24,'admin-edit','admin','2025-02-12 09:07:52','2025-02-12 09:07:52'),(25,'admin-delete','admin','2025-02-12 09:07:52','2025-02-12 09:07:52'),(26,'message-list','admin','2025-02-12 09:07:52','2025-02-12 09:07:52'),(27,'message-delete','admin','2025-02-12 09:07:52','2025-02-12 09:07:52'),(28,'message-reply','admin','2025-02-12 09:07:52','2025-02-12 09:07:52'),(29,'order-list','admin','2025-02-12 09:07:52','2025-02-12 09:07:52'),(32,'order-reply','admin','2025-02-12 09:07:52','2025-02-12 09:07:52'),(33,'newsletter-list','admin','2025-02-12 09:07:52','2025-02-12 09:07:52'),(34,'newsletter-delete','admin','2025-02-12 09:07:52','2025-02-12 09:07:52'),(35,'newsletter-reply','admin','2025-02-12 09:07:52','2025-02-12 09:07:52'),(36,'store-list','admin','2025-02-12 09:07:52','2025-02-12 09:07:52'),(37,'store-create','admin','2025-02-12 09:07:52','2025-02-12 09:07:52'),(38,'store-edit','admin','2025-02-12 09:07:52','2025-02-12 09:07:52'),(39,'store-delete','admin','2025-02-12 09:07:52','2025-02-12 09:07:52'),(40,'size-list','admin','2025-02-12 09:07:52','2025-02-12 09:07:52'),(41,'size-create','admin','2025-02-12 09:07:52','2025-02-12 09:07:52'),(42,'size-edit','admin','2025-02-12 09:07:52','2025-02-12 09:07:52'),(43,'size-delete','admin','2025-02-12 09:07:52','2025-02-12 09:07:52'),(44,'color-list','admin','2025-02-12 09:07:52','2025-02-12 09:07:52'),(45,'color-create','admin','2025-02-12 09:07:52','2025-02-12 09:07:52'),(46,'color-edit','admin','2025-02-12 09:07:52','2025-02-12 09:07:52'),(47,'color-delete','admin','2025-02-12 09:07:52','2025-02-12 09:07:52'),(48,'brand-list','admin','2025-02-12 09:07:52','2025-02-12 09:07:52'),(49,'brand-create','admin','2025-02-12 09:07:52','2025-02-12 09:07:52'),(50,'brand-edit','admin','2025-02-12 09:07:52','2025-02-12 09:07:52'),(51,'brand-delete','admin','2025-02-12 09:07:52','2025-02-12 09:07:52'),(52,'subcategory-list','admin','2025-02-12 09:07:52','2025-02-12 09:07:52'),(53,'subcategory-create','admin','2025-02-12 09:07:52','2025-02-12 09:07:52'),(54,'subcategory-edit','admin','2025-02-12 09:07:52','2025-02-12 09:07:52'),(55,'subcategory-delete','admin','2025-02-12 09:07:52','2025-02-12 09:07:52'),(56,'banner-list','admin','2025-02-12 09:07:52','2025-02-12 09:07:52'),(57,'banner-create','admin','2025-02-12 09:07:52','2025-02-12 09:07:52'),(58,'banner-edit','admin','2025-02-12 09:07:52','2025-02-12 09:07:52'),(59,'banner-delete','admin','2025-02-12 09:07:52','2025-02-12 09:07:52'),(60,'slider-list','admin','2025-02-22 14:52:47','2025-02-22 14:52:47'),(61,'slider-create','admin','2025-02-22 14:52:47','2025-02-22 14:52:47'),(62,'slider-edit','admin','2025-02-22 14:52:47','2025-02-22 14:52:47'),(63,'slider-delete','admin','2025-02-22 14:52:47','2025-02-22 14:52:47'),(64,'merchantRequest-list','admin','2025-03-10 17:29:58','2025-03-10 17:29:58'),(65,'merchantRequest-delete','admin','2025-03-10 17:29:58','2025-03-10 17:29:58'),(70,'chooseUs-list','admin','2025-04-16 21:32:50','2025-04-16 21:32:50'),(71,'chooseUs-create','admin','2025-04-16 21:32:50','2025-04-16 21:32:50'),(72,'chooseUs-edit','admin','2025-04-16 21:32:50','2025-04-16 21:32:50'),(73,'chooseUs-delete','admin','2025-04-16 21:32:50','2025-04-16 21:32:50'),(74,'service-list','admin','2025-04-16 21:32:50','2025-04-16 21:32:50'),(75,'service-create','admin','2025-04-16 21:32:50','2025-04-16 21:32:50'),(76,'service-edit','admin','2025-04-16 21:32:50','2025-04-16 21:32:50'),(77,'service-delete','admin','2025-04-16 21:32:50','2025-04-16 21:32:50'),(78,'page-list','admin','2025-04-24 19:26:22','2025-04-24 19:26:22'),(79,'page-edit','admin','2025-04-24 19:26:22','2025-04-24 19:26:22'),(80,'contact-list','admin','2025-04-24 21:27:34','2025-04-24 21:27:34'),(81,'contact-create','admin','2025-04-24 21:27:34','2025-04-24 21:27:34'),(82,'contact-edit','admin','2025-04-24 21:27:34','2025-04-24 21:27:34'),(83,'contact-delete','admin','2025-04-24 21:27:34','2025-04-24 21:27:34');
/*!40000 ALTER TABLE `permissions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `personal_access_tokens`
--

DROP TABLE IF EXISTS `personal_access_tokens`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `personal_access_tokens` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `tokenable_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tokenable_id` bigint(20) unsigned NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `abilities` text COLLATE utf8mb4_unicode_ci,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `personal_access_tokens`
--

LOCK TABLES `personal_access_tokens` WRITE;
/*!40000 ALTER TABLE `personal_access_tokens` DISABLE KEYS */;
/*!40000 ALTER TABLE `personal_access_tokens` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `product_requests`
--

DROP TABLE IF EXISTS `product_requests`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `product_requests` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `store_id` bigint(20) unsigned NOT NULL,
  `reviewer_id` bigint(20) unsigned DEFAULT NULL,
  `type` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'create, edit',
  `data` longtext COLLATE utf8mb4_unicode_ci,
  `product_id` bigint(20) unsigned DEFAULT NULL,
  `status` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'pending, accepted',
  `rejected_reason` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `affected_fields` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `product_requests_product_id_foreign` (`product_id`),
  KEY `product_requests_reviewer_id_foreign` (`reviewer_id`),
  CONSTRAINT `product_requests_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE,
  CONSTRAINT `product_requests_reviewer_id_foreign` FOREIGN KEY (`reviewer_id`) REFERENCES `admins` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `product_requests`
--

LOCK TABLES `product_requests` WRITE;
/*!40000 ALTER TABLE `product_requests` DISABLE KEYS */;
/*!40000 ALTER TABLE `product_requests` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `product_translations`
--

DROP TABLE IF EXISTS `product_translations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `product_translations` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `product_id` bigint(20) unsigned NOT NULL,
  `locale` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `product_translations_product_id_locale_unique` (`product_id`,`locale`),
  KEY `product_translations_locale_index` (`locale`),
  CONSTRAINT `product_translations_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=418 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `product_translations`
--

LOCK TABLES `product_translations` WRITE;
/*!40000 ALTER TABLE `product_translations` DISABLE KEYS */;
INSERT INTO `product_translations` (`id`, `title`, `description`, `product_id`, `locale`, `created_at`, `updated_at`) VALUES (130,'Women\'s Handbag','<li data-start=\"434\" data-end=\"646\" style=\"font-weight: 400; letter-spacing: normal; caret-color: rgb(0, 0, 0); color: rgb(0, 0, 0);\"><p data-start=\"436\" data-end=\"646\">A stylish handbag made from high-quality materials, perfect for daily use and special occasions. It features a modern design and spacious interior to carry all your essentials with ease.</p></li><li data-start=\"648\" data-end=\"902\" style=\"font-weight: 400; letter-spacing: normal; caret-color: rgb(0, 0, 0); color: rgb(0, 0, 0);\"><p data-start=\"650\" data-end=\"902\"><strong data-start=\"650\" data-end=\"666\"></strong></p></li><br class=\"Apple-interchange-newline\" style=\"caret-color: rgb(0, 0, 0); color: rgb(0, 0, 0); font-weight: 400; letter-spacing: normal;\">',44,'en','2025-03-12 11:20:53','2025-03-12 11:20:53'),(131,'حقيبة يد نسائية','<span style=\"font-weight: 400; letter-spacing: normal; caret-color: rgb(0, 0, 0); color: rgb(0, 0, 0); font-size: medium;\">حقيبة يد أنيقة مصنوعة من مواد عالية الجودة، مثالية للاستخدام اليومي والمناسبات الخاصة. تتميز بتصميم عصري ومساحة واسعة لحمل جميع احتياجاتك بسهولة.</span>',44,'ar','2025-03-12 11:20:53','2025-03-12 11:20:53'),(132,'Sac à main pour femme','<span style=\"font-weight: 400; letter-spacing: normal; caret-color: rgb(0, 0, 0); color: rgb(0, 0, 0); font-size: medium;\">Un sac à main élégant fabriqué à partir de matériaux de haute qualité, idéal pour un usage quotidien et les occasions spéciales. Il offre un design moderne et un intérieur spacieux pour transporter facilement tous vos essentiels.</span>',44,'fr','2025-03-12 11:20:53','2025-03-12 11:20:53'),(139,'Men\'s Jacket','<span style=\"font-weight: 400; letter-spacing: normal; caret-color: rgb(0, 0, 0); color: rgb(0, 0, 0); font-size: medium;\">A stylish and modern men\'s jacket made from high-quality materials to provide warmth and comfort. Designed for both casual and formal looks, making it a perfect choice for all seasons and occasions.</span>',47,'en','2025-03-12 12:49:23','2025-03-12 12:49:23'),(140,'جاكيت رجالي','<span style=\"font-weight: 400; letter-spacing: normal; caret-color: rgb(0, 0, 0); color: rgb(0, 0, 0); font-size: medium;\">جاكيت رجالي أنيق وعصري مصنوع من خامات عالية الجودة ليمنحك الدفء والراحة. يتميز بتصميم أنيق يناسب الإطلالات الكاجوال والرسمية، مما يجعله خيارًا مثاليًا لجميع الفصول والمناسبات.</span>',47,'ar','2025-03-12 12:49:23','2025-03-12 12:49:23'),(141,'Veste pour homme','<span style=\"font-weight: 400; letter-spacing: normal; caret-color: rgb(0, 0, 0); color: rgb(0, 0, 0); font-size: medium;\">Une veste pour homme élégante et moderne, fabriquée à partir de matériaux de haute qualité pour offrir chaleur et confort. Son design sophistiqué convient aussi bien aux tenues décontractées que formelles, idéale pour toutes les saisons et occasions.</span>',47,'fr','2025-03-12 12:49:23','2025-03-12 12:49:23'),(142,'Women\'s Dress','<span style=\"font-weight: 400; letter-spacing: normal; caret-color: rgb(0, 0, 0); color: rgb(0, 0, 0); font-size: medium;\">A stylish and elegant women\'s dress designed with premium fabrics to give you a sophisticated and charming look. Featuring a feminine cut that suits various occasions, from parties to chic everyday wear.</span>',48,'en','2025-03-12 12:52:40','2025-03-12 12:52:40'),(143,'فستان نسائي','<span style=\"font-weight: 400; letter-spacing: normal; caret-color: rgb(0, 0, 0); color: rgb(0, 0, 0); font-size: medium;\">فستان أنيق وعصري مصمم بأجود الخامات ليمنحك مظهرًا راقيًا وجذابًا. يتميز بقصة أنثوية رائعة تناسب مختلف المناسبات، سواء كانت حفلات أو إطلالات يومية مميزة.</span>',48,'ar','2025-03-12 12:52:40','2025-03-12 12:52:40'),(144,'Robe pour femme','<span style=\"font-weight: 400; letter-spacing: normal; caret-color: rgb(0, 0, 0); color: rgb(0, 0, 0); font-size: medium;\">Une robe élégante et moderne, conçue avec des tissus de qualité supérieure pour un look raffiné et séduisant. Sa coupe féminine s’adapte à toutes les occasions, qu\'il s\'agisse de soirées ou de tenues quotidiennes chics.</span>',48,'fr','2025-03-12 12:52:40','2025-03-12 12:52:40'),(157,'Denim Jacket','<span style=\"font-weight: 400; letter-spacing: normal; caret-color: rgb(0, 0, 0); color: rgb(0, 0, 0); font-size: medium;\">Elevate your casual style with this trendy denim jacket! Made from high-quality materials for ultimate comfort and durability. Its classic design makes it perfect for everyday wear. Pair it with a t-shirt or shirt for a stylish look that suits all seasons.</span>',53,'en','2025-03-12 21:10:21','2025-03-12 21:10:21'),(158,'جاكت جينز','<span style=\"font-weight: 400; letter-spacing: normal; caret-color: rgb(0, 0, 0); color: rgb(0, 0, 0); font-size: medium;\">تألق بإطلالة كاجوال أنيقة مع هذا الجاكت الجينز العصري! مصنوع من خامات عالية الجودة ليمنحك الراحة والمتانة، بتصميم كلاسيكي يناسب جميع المناسبات اليومية. ارتديه مع تيشيرت أو قميص لإطلالة مميزة تناسب جميع الفصول.</span>',53,'ar','2025-03-12 21:10:21','2025-03-12 21:10:21'),(159,'Veste en jean','<span style=\"font-weight: 400; letter-spacing: normal; caret-color: rgb(0, 0, 0); color: rgb(0, 0, 0); font-size: medium;\">Mettez en valeur votre style décontracté avec cette veste en jean tendance ! Fabriquée à partir de matériaux de haute qualité pour un confort et une durabilité exceptionnels. Son design classique la rend parfaite pour toutes les occasions. Associez-la à un t-shirt ou une chemise pour un look élégant adapté à toutes les saisons.</span>',53,'fr','2025-03-12 21:10:21','2025-03-12 21:10:21'),(163,'Men\'s Shirt','A stylish men\'s shirt made from high-quality materials for ultimate comfort and elegance. Featuring a modern design suitable for both formal and casual occasions, making it a perfect addition to your wardrobe.',55,'en','2025-03-12 22:18:16','2025-03-12 22:18:16'),(164,'قميص رجالي','قميص رجالي أنيق مصنوع من أجود الخامات لضمان الراحة والأناقة. يتميز بتصميم عصري يناسب جميع المناسبات الرسمية والكاجوال، مما يجعله إضافة مثالية لخزانة ملابسك.',55,'ar','2025-03-12 22:18:16','2025-03-12 22:18:16'),(165,'Chemise pour homme','Une chemise pour homme élégante fabriquée à partir de matériaux de haute qualité pour un confort et une élégance incomparables. Son design moderne convient aussi bien aux occasions formelles que décontractées, un incontournable de votre garde-robe.',55,'fr','2025-03-12 22:18:16','2025-03-12 22:18:16'),(404,'SGIN 17.3 Inch Laptop Computer,','Laptop 17 inch screen: Experience the best of laptops on sale with this 17 inch laptop Computer, featuring a 1920×1080 HD IPS display for breathtaking clarity. Ideal for laptop for college students and professionals, it provides the perfect balance of performance and portability for work, study, and entertainmentPowerful Intel i3-5005U Processor: This win 11 laptop is powered by an Intel Core i3-5005U processor with 2.4GHz Turbo Boost, offering dual-core, four-thread performance for seamless multitasking. Easily handle 20+ Chrome tabs, video editing, and demanding workloads with desktop-level efficiencyFlexible Storage Options: Equipped with 4GB RAM and 128GB SSD, SGIN laptop supports expansion up to 1TB SSD, ensuring ample storage and lightning-fast performance. An additional SSD slot allows for easy upgrades. As a laptop for work, it guarantees a smooth workflow, keeping your creativity and productivity on trackLong Lasting Battery: Equipped with a 8000 mWh lithium-ion battery, long battery life. SGIN laptop has a long battery life and reliable performance. It features a Type-C port, HDMI (for external monitors/projectors), dual USB 3.2 ports, a 3.5mm headphone jack, and a MicroSD card slot (expandable up to 512GB)After-Sales Support: This win laptop includes a 1-year comprehensive after-sales covering essential components. Our professional customer service team responds within 12 hours, ensuring your electronics device remains in optimal condition',116,'en','2025-09-18 14:47:06','2025-09-21 20:05:21'),(405,'لابتوب اس جي اي ان 17.3 انش،','شاشة لابتوب 17 انش: جرب أفضل أجهزة اللاب توب المعروضة للبيع مع هذا الكمبيوتر المحمول مقاس 17 انش، والذي يتميز بشاشة HD IPS 1920 × 1080 للحصول على وضوح مذهل. مثالي للاب توب لطلاب الجامعات والمحترفين، فهو يوفر التوازن المثالي بين الأداء وسهولة الحمل للعمل والدراسة والترفيهمعالج انتل i3-5005U قوي: يعمل هذا اللاب توب ويندوز 11 بمعالج انتل كور i3-5005U مع تعزيز تربو 2.4 جيجاهرتز، مما يوفر أداءً ثنائي النواة رباعي الخيوط لتعدد المهام بسلاسة. التعامل بسهولة مع أكثر من 20 علامة تبويب كروم وتحرير الفيديو وأعباء العمل الصعبة بكفاءة على مستوى سطح المكتبخيارات تخزين مرنة: مزود بذاكرة رام 4 جيجابايت وهارد SSD 128 جيجابايت، يدعم لابتوب اس جي اي ان التوسع حتى 1 تيرابايت اس اس دي، مما يضمن مساحة تخزين واسعة وأداء فائق السرعة. فتحة SSD إضافية تسمح بسهولة الترقيات. كلاب توب للعمل، فإنه يضمن سير عمل سلس، مما يحافظ على إبداعك وإنتاجيتك على المسار الصحيحبطارية تدوم طويلاً: مجهزة ببطارية ليثيوم أيون 8000 مللي واط في الساعة، عمر بطارية طويل. يتميز لابتوب اس جي اي ان بعمر بطارية طويل وأداء موثوق. يتميز بمنفذ نوع سي ومنفذ HDMI (للشاشات الخارجية/أجهزة العرض)، ومنافذ USB 3.2 مزدوجة، ومقبس سماعة رأس 3.5 ملم، وفتحة بطاقة مايكرو اس دي (قابلة للتوسيع حتى 512 جيجابايت)دعم ما بعد البيع: يتضمن هذا الكمبيوتر المحمول الذي يعمل بنظام وين تغطية شاملة لما بعد البيع لمدة عام واحد تغطي المكونات الأساسية. يستجيب فريق خدمة العملاء المحترف لدينا في غضون 12 ساعة، مما يضمن بقاء جهازك الإلكتروني في حالة مثالية',116,'ar','2025-09-18 14:47:06','2025-09-21 20:05:21'),(406,'Blackview Laptop 2025, Laptops Computer for Business Student','【Powerful Performance】 The Blackview Acebook6 laptop is powered by the 2025 Intel N150 processor (4 cores, up to 3.6GHz, 6MB Cache), engineered for real-world speed and efficiency. With Intel 10nm ultra efficient architecture, it delivers 20% faster multitasking and graphics performance than N4020/J4005/J4105/N5095/N95/N97/N100 laptops. The laptop computer effortlessly handles office tasks, online classes, and streaming. The 6W low-power design ensures long battery life while running cool and quiet, eliminating lag. Ideal for business professionals and students.【16GB DDR4 & 256GB SSD】This computer comes equipped with 16GB DDR4 RAM (2666MHz) for seamless multitasking and a 256GB M.2 SSD for rapid booting and file transfers 3x faster than HDDs. This traditional laptop computer delivers up to 50% better performance than DDR3 computers, ensuring smooth system operation and efficient handling of personal files. Supports 32GB RAM +2TB SSD upgrades, never run out of space for projects or media.【FHD IPS & TÜV Rheinland Eye Care Display】This business & student laptop features a 15.6\" Full HD IPS display (1920x1080, 220 nits, 45% NTSC) with TÜV Rheinland-certified low blue light technology and ultra-narrow bezels (84% screen-to-body ratio). The windows laptop delivers crystal-clear visuals while reducing eye strain, protecting your eyes during long work or study sessions. Equipped with Intel UHD Graphics supporting 4K output via HDMI, it provides immersive HD visuals for multimedia streaming, presentations, and productivity tasks.【Fast Charging & High-Capacity Battery】This Windows 11 laptop features a 5000mAh (38Whr) high-capacity battery and 45W Type-C fast charging (PD 3.0 compliant, with 100W fast charging support)—reaching 60% charge in just 45 minutes, 2.5x faster than traditional DC adapters. Ideal for busy professionals and students, it delivers all-day productivity with minimal downtime—perfect for back-to-back meetings, lectures, or remote work where charging opportunities are limited.【Efficient Cooling & Whisper-Quiet Operation】Engineered with a dual copper tube + fan cooling system and 16,800mm² total heat dissipation area, this computadora maintains optimal performance even during extended work or study sessions—preventing overheating while editing documents, streaming lectures, or running multitab workflows. The intelligent thermal management automatically adjusts fan speed based on usage, ensuring noise levels stay below 43dB. The copper tubing efficiently dissipates heat from the CPU and GPU, keeping temperatures stable during intensive tasks.【Portable Design & Modern Connectivity】Featuring a slim 19.5mm profile and 1.7kg lightweight build, the traditional laptops offer effortless portability for on-the-go tasks. The 180° lay-flat hinge enables easy content sharing in meetings, classrooms, or collaborative settings. Equipped with full-function connectivity, it includes: Type-C (PD 3.0), 2x USB 3.2 Gen1 ports, 1x USB 2.0 port, HDMI 2.0, 3.5mm audio jack, and TF card slot. Dual-band Wi-Fi and Bluetooth 5.0 ensure fast, stable wireless connections. Pre-installed with Windows 11 Home, it delivers a familiar, productive computing experience right out of the box.【24-Month Warranty & Comprehensive Support】Enjoy 24-month repair warranty for manufacturer defects, backed by 12+ years of tech expertise. As a Blackview laptop, it’s supported by our global offline stores—with dedicated locations across the U.S.—for in-person assistance. Our team provides lifetime technical support, including setup guidance and troubleshooting responses within 24 hours (Mon-Sat). We’re committed to assisting with questions and resolving issues efficiently.【Perfect Back-to-School Gift & Daily Use】Whether back-to-school season or daily life, Blackview Acebook 6 laptop fits seamlessly—ideal for students, remote workers, or anyone needing reliability. For students, its 15.6\" TÜV eye-care display eases long study sessions; 16GB RAM handles notes, research, and courses effortlessly. Lightweight and compact, it slides into backpacks for campus or commutes. Beyond school, it excels at work, streaming, and more—practical year-round. Sleek and functional, it’s a thoughtful gift for anyone seeking efficiency and portability, no matter the season.',117,'en','2025-09-18 14:52:21','2025-09-21 20:05:00'),(407,'بلاك فيو لابتوب 2025، لابتوب لطلاب الاعمال،','【أداء قوي】 يعمل لاب توب بلاك فيو Acebook6 بمعالج انتل N150 2025 (رباعي النواة، حتى 3.6 جيجاهرتز، ذاكرة تخزين مؤقتة 6 ميجابايت)، مصمم للسرعة والكفاءة في العالم الحقيقي. مع بنية انتل فائقة الكفاءة 10 نانومتر، فإنها توفر أداء رسومات وتعدد المهام أسرع بنسبة 20% من أجهزة اللاب توب N4020/J4005/J4105/N5095/N95/N97/N100. يتعامل الكمبيوتر المحمول مع المهام المكتبية والدروس عبر الإنترنت والبث دون عناء. يضمن التصميم منخفض الطاقة بقدرة 6 واط عمر بطارية طويل أثناء التشغيل البارد والهدوء، مما يقلل من التأخير. مثالية لمحترفي الأعمال والطلاب.【16GB DDR4 و256GB SSD】يأتي هذا الكمبيوتر مزودًا بذاكرة RAM DDR4 سعة 16GB (2666 ميجاهرتز) لتعدد المهام بسلاسة وهارد SSD M.2 سعة 256GB للتشغيل السريع ونقل الملفات أسرع 3 مرات من الأقراص الصلبة. يوفر الكمبيوتر المحمول التقليدي هذا أداءً أفضل بنسبة تصل إلى 50% من أجهزة الكمبيوتر DDR3، مما يضمن تشغيل النظام بسلاسة ومعالجة فعالة للملفات الشخصية. يدعم ترقية ذاكرة RAM 32GB + SSD 2TB، لا تنفد مساحة المشاريع أو الوسائط.【شاشة FHD IPS وشاشة تي يو في راينلاند للعناية بالعين】يتميز لابتوب الأعمال والطلاب بشاشة IPS FHD مقاس 15.6 انش (1920 × 1080، 220 وحدة مضيئة في البكسل، 45% ان تي اس سي) مع تقنية الضوء الأزرق المنخفض المعتمدة من تي يو في راينلاند وحواف ضيقة للغاية (نسبة الشاشة إلى الهيكل 84%). يوفر اللاب توب الذي يعمل بنظام ويندوز مرئيات واضحة للغاية مع تقليل إجهاد العين، وحماية عينيك أثناء العمل أو جلسات الدراسة الطويلة. مزود برسومات انتل الترا اتش دي التي تدعم مخرج 4 كيه عبر اتش دي ام اي، ويوفر مرئيات عالية الدقة غامرة لبث الوسائط المتعددة والعروض التقديمية ومهام الإنتاجية.【شحن سريع وبطارية عالية السعة】يتميز لابتوب ويندوز 11 هذا ببطارية عالية السعة 5000 مللي امبير في الساعة (38 واط في الساعة) وشحن سريع 45 واط من النوع C (متوافق مع بي دي 3.0، مع دعم شحن سريع 100 واط) - يصل إلى 60% شحن في 45 دقيقة فقط، أسرع بمقدار 2.5 مرة من محولات التيار المستمر التقليدية. مثالي للمحترفين والطلاب المشغولين، فهو يوفر إنتاجية طوال اليوم مع الحد الأدنى من وقت التوقف - مثالي للاجتماعات أو المحاضرات أو العمل عن بعد حيث تكون فرص الشحن محدودة.【تبريد فعال وتشغيل هادئ للغاية】مصمم بأنبوب نحاسي مزدوج + نظام تبريد مروحة ومنطقة تبديد الحرارة الإجمالية 16,800 ملم مربع، يحافظ هذا الكمبيوتر على الأداء الأمثل حتى أثناء العمل الطويل أو جلسات الدراسة - يمنع ارتفاع درجة الحرارة أثناء تحرير المستندات أو بث المحاضرات أو تشغيل سير العمل متعدد التبويبات. تعمل الإدارة الحرارية الذكية على ضبط سرعة المروحة تلقائيًا بناءً على الاستخدام، مما يضمن بقاء مستويات الضوضاء أقل من 43 ديسيبل. تعمل الأنابيب النحاسية على تبديد الحرارة بكفاءة من وحدة المعالجة المركزية ووحدة معالجة الرسومات الجرافيكية، مما يحافظ على ثبات درجات الحرارة أثناء المهام المكثفة.【تصميم محمول واتصال عصري】تتميز بتصميم نحيف 19.5 ملم وهيكل خفيف الوزن 1.7 كغم، توفر أجهزة اللاب توب التقليدية سهولة الحمل للمهام أثناء التنقل. تتيح المفصلات المسطحة بزاوية 180 درجة مشاركة المحتوى بسهولة في الاجتماعات أو الفصول الدراسية أو الإعدادات التعاونية. مزود باتصال كامل الوظائف، ويشمل: نوع سي (بي دي 3.0)، 2 × منفذ يو اس بي 3.2 الجيل الأول، 1 × منفذ يو اس بي 2.0، اتش دي ام اي 2.0، مقبس صوت 3.5 ملم، وفتحة بطاقة تي اف. يضمن واي فاي ثنائي النطاق وبلوتوث 5.0 اتصالات لاسلكية سريعة ومستقرة. مثبت مسبقًا مع ويندوز 11 هوم، يوفر تجربة حوسبة مألوفة ومنتجة بمجرد إخراجه من الصندوق.【ضمان لمدة 24 شهرًا ودعم شامل】استمتع بضمان إصلاح لمدة 24 شهرًا لعيوب الشركة المصنعة، مدعومة بأكثر من 12 عامًا من الخبرة التقنية. باعتباره لابتوب بلاك فيو فهو مدعوم من متاجرنا العالمية غير المتصلة بالإنترنت - مع مواقع مخصصة في جميع أنحاء الولايات المتحدة - للحصول على مساعدة شخصية. يوفر فريقنا دعمًا فنيًا مدى الحياة، بما في ذلك إرشادات الإعداد واستجابات استكشاف الأخطاء وإصلاحها في غضون 24 ساعة (من الاثنين إلى السبت). نحن ملتزمون بالمساعدة في الأسئلة وحل المشكلات بكفاءة.【هدية مثالية للعودة إلى المدرسة والاستخدام اليومي】سواء كان موسم العودة إلى المدرسة أو الحياة اليومية، فإن لابتوب بلاك فيو Acebook 6 يناسب بسلاسة - مثالي للطلاب أو العاملين عن بُعد أو أي شخص يحتاج إلى الموثوقية. بالنسبة للطلاب، فإن شاشة تي يو في للعناية بالعين مقاس 15.6 انش تسهل جلسات الدراسة الطويلة؛ ذاكرة رام 16 جيجابايت تتعامل مع الملاحظات والأبحاث والدورات التدريبية دون عناء. خفيفة الوزن وصغيرة الحجم، تنزلق في حقائب الظهر للحرم الجامعي أو التنقل. ما بعد المدرسة، فهي تتفوق في العمل والبث وأكثر من ذلك - عملية على مدار العام. أنيقة وعملية، إنها هدية مدروسة لأي شخص يبحث عن الكفاءة وسهولة الحمل، بغض النظر عن الموسم.',117,'ar','2025-09-18 14:52:21','2025-09-21 20:05:00'),(408,'ACEMAGIC 2025 Laptop,17.3-Inch FHD','【Powerful Capabilities】The ACEMAGIC AX17 Traditional laptop computer is equipped with the latest 12th Gen Intel Alder Lake N97 processor (4C/4T, 6MB Cache, 12W, base frequency 1.7GHz, up to 3.6GHz, 7nm process), delivering significantly higher performance than Celeron N5095 or Pentium N5030. With built-in 16GB DDR4 RAM and a 512GB SSD, it offers enhanced power for seamless multitasking.【Immersive IPS Display】This 17.3inch laptop features an innovative thin-bezel design that maximizes the screen area for a truly immersive FHD viewing experience. The compact chassis integrates a larger display while maintaining a smaller footprint. A built-in front-facing webcam, centered above the screen, allows you to easily take photos or join video calls anytime.【Long Battery Life】Take this laptop anywhere without carrying a power adapter. Its 6000mAh battery supports up to 5 hours of continuous use, providing flexibility for work or entertainment on the go. The integrated cooling fans ensure quiet and sustained performance, minimizing distractions whether you’re working on spreadsheets or watching movies.【Seamless Connectivity】This Windows 11 laptop includes a versatile selection of ports: HDMI Type A × 1, USB 3.2 × 3, Type-C (Data Only) × 1, a 3.5mm headphone jack × 1, a 128GB TF card slot × 1, and a DC jack × 1. It supports 802.11ac Wi-Fi for speeds up to three times faster than 802.11n, ensuring high-speed data transmission and downloads. Bluetooth 5.0 enables stable and easy connections with compatible devices.【ACEMAGIC Care For You】Designed with a durable metal casing, this 2025 laptop resists pressure and impacts while remaining slim and lightweight,easy to carry in a backpack wherever you go. We provide lifetime technical support and a 12-month quality warranty. Should you have any questions, feel free to reach out—we’re always here to help.',118,'en','2025-09-18 15:00:11','2025-09-18 15:02:05'),(409,'لابتوب ايس ماجيك 2025 بشاشة FHD 17.3 انش','قدرات قوية】تم تجهيز لابتوب ايه اكس 17 التقليدي من اسيماجيك بأحدث معالج انتل ألدر ليك N97 من الجيل الثاني عشر (4C/4T، ذاكرة تخزين مؤقتة 6 ميجابايت، 12 واط، تردد أساسي 1.7 جيجاهرتز، حتى 3.6 جيجاهرتز، عملية 7 نانومتر)، مما يوفر أداءً أعلى بكثير من سيليرون N5095 أو بنتيوم N5030. مع ذاكرة رام DDR4 مدمجة بسعة 16 جيجابايت وهارد SSD سعة 512 جيجابايت، فإنها توفر قوة معززة لتعدد المهام بسلاسة.【شاشة IPS غامرة】يتميز هذا اللاب توب مقاس 17.3 انش بتصميم مبتكر رفيع الحواف يزيد من مساحة الشاشة لتجربة عرض FHD غامرة حقًا. يدمج الهيكل المدمج شاشة أكبر مع الحفاظ على بصمة أصغر. كاميرا ويب أمامية مدمجة، في المنتصف فوق الشاشة، تسمح لك بالتقاط الصور بسهولة أو الانضمام إلى مكالمات الفيديو في أي وقت.【عمر بطارية طويل】اصطحب هذا اللاب توب إلى أي مكان دون حمل محول طاقة. بطارية 6000mAh تدعم ما يصل إلى 5 ساعات من الاستخدام المستمر، مما يوفر المرونة للعمل أو الترفيه أثناء التنقل. تضمن مراوح التبريد المدمجة أداءً هادئًا ومستدامًا، مما يقلل من التشتيت سواء كنت تعمل على جداول البيانات أو تشاهد الأفلام.【اتصال سلس】يتضمن هذا اللاب توب الذي يعمل بنظام ويندوز 11 مجموعة متنوعة من المنافذ: HDMI Type A × 1، USB 3.2 × 3، نوع C (البيانات فقط) × 1، مقبس سماعة رأس 3.5 ملم × 1، فتحة بطاقة TF 128GB × 1، ومقبس تيار مستمر × 1. يدعم واي فاي 802.11ac لسرعات تصل إلى ثلاث مرات أسرع من 802.11n، مما يضمن نقل البيانات وتنزيلها بسرعة عالية. يتيح بلوتوث 5.0 اتصالات مستقرة وسهلة مع الأجهزة المتوافقة.【عناية رائعة لك】مصمم بغلاف معدني متين، يقاوم هذا اللاب توب 2025 الضغط والتأثيرات مع الحفاظ على النحافة وخفيف الوزن، سهل الحمل في حقيبة الظهر أينما ذهبت. نقدم الدعم الفني مدى الحياة وضمان الجودة لمدة 12 شهرًا. إذا كانت لديك أي أسئلة، فلا تتردد في التواصل معنا - فنحن دائمًا هنا للمساعدة.',118,'ar','2025-09-18 15:00:11','2025-09-18 15:02:05'),(410,'jumper 16 inch Convertible Laptop','1 Year Office 365: Convertible Laptop includes 1 year Office 365 to start using advanced productivity tools right away. Compliment your new laptop with free year-round access to Word, Excel, PowerPoint, Outlook and more. Increased productivity and creativity360° Foldable Notebook: 2 in 1 laptop with four modes of use: laptop, tablet, tent and stand. Laptop with 360° swivel hinge, flexible and free to switch between different modes, can help you improve your work efficiency and recreational use. Very practical16 inch FHD Screen: Folding laptop with 16 inch IPS touchable display with 1920x1200 resolution and narrow bezels for an immersive viewing experience. In addition, the 10 point touch feature enhances usability for browsing and entertainmentMemory & Expandable Storage: Laptop features 16GB DDR4 RAM 640GB storage, with an extra DDR4 slot for expansion (supports up to 16GB). The SSD can also be upgraded to 2TB, ensuring ample space for all your files and eliminating storage concernsCooling System & Secure Login: Touchscreen Laptop is equipped with a fan system at the bottom to help dissipate heat from the computer and make the system run smoother. Computer also has a built in fingerprint reader for quick access without a password',119,'en','2025-09-18 15:07:57','2025-09-21 19:16:18'),(411,'جمبر لابتوب قابل للتحويل مقاس 16 انش','اوفيس 365 لمدة عام واحد: يتضمن الكمبيوتر المحمول القابل للتحويل اوفيس 365 لمدة عام واحد لبدء استخدام أدوات إنتاجية متقدمة على الفور. أكمل اللاب توب الجديد الخاص بك مع إمكانية الوصول المجاني على مدار العام إلى وورد واكسيل وباور بوينت واوت لوك والمزيد. زيادة الإنتاجية والإبداعنوت بوك قابل للطي 360 درجة: لابتوب 2 في 1 مع أربعة أوضاع للاستخدام: اللاب توب والتابلت والخيمة والحامل. لابتوب بمفصلات دوارة 360 درجة، مرن وحرية للتبديل بين الأوضاع المختلفة، يمكن أن يساعدك على تحسين كفاءة العمل والاستخدام الترفيهي. عملي للغايةشاشة FHD مقاس 16 انش: لابتوب قابل للطي بشاشة لمس IPS مقاس 16 انش بدقة 1920 × 1200 وحواف ضيقة لتجربة مشاهدة غامرة. بالإضافة إلى ذلك، تعزز ميزة اللمس المكونة من 10 نقاط سهولة الاستخدام للتصفح والترفيهالذاكرة والتخزين القابل للتوسيع: يتميز اللاب توب بذاكرة رام DDR4 سعة 16 جيجابايت وذاكرة تخزين 640 جيجابايت، مع فتحة DDR4 إضافية للتوسع (يدعم حتى 16 جيجابايت). يمكن أيضًا ترقية SSD إلى 2 تيرابايت، مما يضمن مساحة واسعة لجميع ملفاتك والتخلص من مخاوف التخزيننظام التبريد وتسجيل الدخول الآمن: تم تجهيز لابتوب بشاشة اللمس بنظام مروحة في الأسفل للمساعدة في تبديد الحرارة من الكمبيوتر وجعل النظام يعمل بشكل أكثر سلاسة. يحتوي الكمبيوتر أيضًا على قارئ بصمات الأصابع مدمج للوصول السريع بدون كلمة مرور',119,'ar','2025-09-18 15:07:57','2025-09-21 19:16:18'),(412,'Samsung Galaxy A16 5G A Series','CRISP DETAIL. VIVID POSSIBILITIES: The ultra-clear 6.7\" display¹ of Galaxy A16 5G helps bring your content to life whether you’re checking emails or reading online blogs and recipes.MEMORIES MADE PICTURE PERFECT: Capture every angle in stunning clarity, from big group shots to close-ups, with the triple-lens camera on Galaxy A16 5G.MORE DURABLE THAN EVER BEFORE: Take on your day with confidence, thanks to the awesome durability of Galaxy A16 5G with an improved IP54 rating.²HEALTH INSIGHTS MADE EASY: Stay connected to your health with Galaxy A16 5G and Fit3. Track your steps, sleep and heart rate³ and then see it all in one place with the Samsung Health app.AWESOME EXPERIENCE. AWESOME VALUE: Galaxy A16 5G offers essential features and practical extras designed to enhance your everyday life — all at a price you’ll love.PAYING MAD EASY: Pay with a tap, plus store your cards and ID all in one app with Samsung Wallet.⁴,⁵6X UPDATES. AWESOME SECURITY: 6X of OS and security updates mean you can keep your Galaxy A16 5G longer, making it a great value for years to come.LIVE FAST. CHARGE FASTER: Focus more on the moment and less on your battery percentage with Galaxy A16 5G. Super Fast Charging⁶ powers up your battery at lightning speed so you can get back to life sooner.STORE MORE AND WORRY LESS: With improved internal storage of up to 128GB and up to 1.5TB⁷ of expandable storage, Galaxy A16 5G makes it easy to keep cherished photos, videos and important files readily accessible whenever you need them.',120,'en','2025-09-18 15:16:09','2025-09-21 18:33:44'),(413,'سامسونج جوال جالكسي ايه 16 سلسلة 5G A،','تفاصيل كريسب. إمكانيات حيوية: تساعد شاشة جالكسي ايه 16 الجيل الخامس فائقة الوضوح مقاس 6.7 انش على إضفاء الحيوية على المحتوى الخاص بك سواء كنت تتحقق من رسائل البريد الإلكتروني أو تقرأ المدونات والوصفات عبر الإنترنت.صورة مثالية للذكريات: التقط كل زاوية بوضوح مذهل، من اللقطات الجماعية الكبيرة إلى الصور المقربة، مع الكاميرا ثلاثية العدسات على جالاكسي A16 5G.أكثر متانة من أي وقت مضى: خذ يومك بثقة، بفضل المتانة الرائعة لهاتف جالاكسي A16 5G مع تصنيف IP54 المحسن.²أصبحت الرؤى الصحية سهلة: ابق على اتصال بصحتك مع جالكسي ايه 16 الجيل الخامس وفيت 3. تتبع خطواتك ونومك ومعدل ضربات القلب³ ثم شاهد كل ذلك في مكان واحد باستخدام تطبيق سامسونج Health.تجربة رائعة. قيمة رائعة: يوفر هاتف جالكسي ايه 16 الجيل الخامس ميزات أساسية وإضافات عملية مصممة لتعزيز حياتك اليومية - كل ذلك بسعر ستحبه.الدفع بسهولة: ادفع بنقرة واحدة، بالإضافة إلى تخزين بطاقاتك وهويتك كلها في تطبيق واحد باستخدام سامسونج Wallet.6 أضعاف التحديثات. أمان رائع: 6 أضعاف من تحديثات نظام التشغيل والأمان تعني أنه يمكنك الحفاظ على هاتف جالاكسي A16 5G لفترة أطول، مما يجعله قيمة رائعة لسنوات قادمة.عش بسرعة. شحن أسرع: ركز أكثر على اللحظة وأقل على نسبة البطارية الخاصة بك مع جالكسي ايه 16 الجيل الخامس. شحن فائق السرعة، يعمل على تشغيل بطاريتك بسرعة البرق حتى تتمكن من العودة إلى الحياة في وقت أقرب.تخزين أكثر وأقل قلقًا: بفضل سعة التخزين الداخلية المحسنة التي تصل إلى 128 جيجابايت وما يصل إلى 1.5 تيرابايت من التخزين القابل للتوسيع، فإن هاتف جالكسي ايه 16 الجيل الخامس يجعل من السهل الحفاظ على الصور ومقاطع الفيديو والملفات المهمة في متناول اليد كلما احتجت إليها.',120,'ar','2025-09-18 15:16:09','2025-09-21 18:33:44');
/*!40000 ALTER TABLE `product_translations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `productoffers`
--

DROP TABLE IF EXISTS `productoffers`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `productoffers` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `startDate` date DEFAULT NULL,
  `endDate` date DEFAULT NULL,
  `percentage` double NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=36 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `productoffers`
--

LOCK TABLES `productoffers` WRITE;
/*!40000 ALTER TABLE `productoffers` DISABLE KEYS */;
INSERT INTO `productoffers` (`id`, `startDate`, `endDate`, `percentage`, `created_at`, `updated_at`) VALUES (1,'2025-03-01','2025-03-25',22,'2025-02-12 09:07:53','2025-02-12 09:07:53'),(2,'2025-03-01','2025-03-25',28,'2025-02-12 09:07:53','2025-02-12 09:07:53'),(3,'2025-03-01','2025-03-25',37,'2025-02-12 09:07:53','2025-02-12 09:07:53'),(4,'2025-03-01','2025-03-25',38,'2025-02-12 09:07:53','2025-02-12 09:07:53'),(5,'2025-03-01','2025-03-25',30,'2025-02-12 09:07:53','2025-02-12 09:07:53'),(6,'2025-03-01','2025-03-25',27,'2025-02-12 09:07:53','2025-02-12 09:07:53'),(7,'2025-03-01','2025-03-25',20,'2025-02-12 09:07:53','2025-02-12 09:07:53'),(8,'2025-03-01','2025-03-25',39,'2025-02-12 09:07:53','2025-02-12 09:07:53'),(9,'2025-03-01','2025-03-25',21,'2025-02-12 09:07:53','2025-02-12 09:07:53'),(10,'2025-03-01','2025-03-25',22,'2025-02-12 09:07:53','2025-02-12 09:07:53'),(12,'2025-03-01','2025-03-25',27,'2025-02-12 09:07:53','2025-02-12 09:07:53'),(13,'2025-03-01','2025-03-25',20,'2025-02-12 09:07:53','2025-02-12 09:07:53'),(14,'2025-03-01','2025-03-25',33,'2025-02-12 09:07:53','2025-02-12 09:07:53'),(15,'2025-03-01','2025-03-25',29,'2025-02-12 09:07:53','2025-02-12 09:07:53'),(16,'2025-03-01','2025-03-25',10,'2025-02-18 21:54:27','2025-02-18 21:54:27'),(17,'2025-03-01','2025-03-25',20,'2025-02-18 22:30:03','2025-02-18 22:30:03'),(18,'2025-03-01','2025-03-25',30,'2025-02-18 22:34:04','2025-02-18 22:34:04'),(19,'2025-03-01','2025-03-25',30,'2025-02-18 22:52:33','2025-02-18 22:52:33'),(20,'2025-03-01','2025-03-25',50,'2025-02-19 20:12:25','2025-02-19 20:12:25'),(21,'2025-03-01','2025-03-25',50,'2025-02-22 15:52:41','2025-02-22 15:52:41'),(22,'2025-03-01','2025-03-25',10,'2025-02-22 16:03:43','2025-02-22 16:03:43'),(23,'2025-03-01','2025-03-25',10,'2025-02-22 20:19:16','2025-02-22 20:19:16'),(24,'2025-03-01','2025-03-25',40,'2025-02-22 22:07:51','2025-02-26 14:49:13'),(25,'2025-03-01','2025-03-25',80,'2025-02-22 22:16:49','2025-02-26 14:48:29'),(26,'2025-03-01','2025-03-25',40,'2025-02-24 17:54:50','2025-02-24 19:35:46'),(27,'2025-03-01','2025-03-25',50,'2025-02-25 14:40:25','2025-02-26 14:48:00'),(28,'2025-03-01','2025-03-25',100,'2025-02-26 12:21:25','2025-02-26 12:23:52'),(29,'2025-03-01','2025-03-25',50,'2025-03-02 13:06:05','2025-03-02 13:06:05'),(31,'2025-03-01','2025-03-25',60,'2025-03-06 13:17:08','2025-03-08 17:16:35'),(32,'2025-03-01','2025-03-25',30,'2025-03-08 18:53:16','2025-03-08 18:53:16'),(33,'2025-03-19','2025-03-21',5,'2025-03-19 01:06:38','2025-03-19 01:06:38'),(34,'2025-03-19','2025-03-21',5,'2025-03-19 01:14:54','2025-03-19 01:14:54'),(35,'2025-03-21','2025-03-31',20,'2025-03-21 01:26:44','2025-03-21 01:26:44');
/*!40000 ALTER TABLE `productoffers` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `products`
--

DROP TABLE IF EXISTS `products`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `products` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `weight` double NOT NULL DEFAULT '0',
  `rate` double NOT NULL DEFAULT '5',
  `SKU` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `category_id` bigint(20) unsigned DEFAULT NULL,
  `subcategory_id` bigint(20) unsigned DEFAULT NULL,
  `brand_id` bigint(20) unsigned DEFAULT NULL,
  `store_id` bigint(20) unsigned DEFAULT NULL,
  `productOffer_id` bigint(20) unsigned DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `backgroundColor` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '#C6C6C6',
  `price` double NOT NULL DEFAULT '0',
  `quantity` bigint(20) NOT NULL DEFAULT '0',
  `is_addition` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `products_category_id_foreign` (`category_id`),
  KEY `products_subcategory_id_foreign` (`subcategory_id`),
  KEY `products_brand_id_foreign` (`brand_id`),
  KEY `products_store_id_foreign` (`store_id`),
  KEY `products_productoffer_id_foreign` (`productOffer_id`),
  CONSTRAINT `products_brand_id_foreign` FOREIGN KEY (`brand_id`) REFERENCES `brands` (`id`) ON DELETE CASCADE,
  CONSTRAINT `products_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE CASCADE,
  CONSTRAINT `products_productoffer_id_foreign` FOREIGN KEY (`productOffer_id`) REFERENCES `productoffers` (`id`) ON DELETE SET NULL,
  CONSTRAINT `products_store_id_foreign` FOREIGN KEY (`store_id`) REFERENCES `stores` (`id`) ON DELETE CASCADE,
  CONSTRAINT `products_subcategory_id_foreign` FOREIGN KEY (`subcategory_id`) REFERENCES `subcategories` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=123 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `products`
--

LOCK TABLES `products` WRITE;
/*!40000 ALTER TABLE `products` DISABLE KEYS */;
INSERT INTO `products` (`id`, `weight`, `rate`, `SKU`, `category_id`, `subcategory_id`, `brand_id`, `store_id`, `productOffer_id`, `created_at`, `updated_at`, `backgroundColor`, `price`, `quantity`, `is_addition`) VALUES (116,0,4,'ABC-12345-S-BL',1,7,NULL,NULL,NULL,'2025-09-18 14:47:06','2025-09-21 20:05:45','#C6C6C6',12130,8,0),(117,0,4,'ABC-12695-L-re',1,7,NULL,NULL,NULL,'2025-09-18 14:52:21','2025-09-21 20:05:00','#C6C6C6',15000,8,0),(118,0,4,'ABC-14865-L-BL',1,7,NULL,NULL,NULL,'2025-09-18 15:00:11','2025-09-21 20:04:24','#C6C6C6',19200,7,1),(119,0,5,'ABC-12585-M-BL',1,7,NULL,NULL,NULL,'2025-09-18 15:07:57','2025-09-21 19:16:18','#C6C6C6',22000,9,1),(120,0,3,'ADC-145545-M-BL',2,3,NULL,NULL,NULL,'2025-09-18 15:16:09','2025-09-21 20:06:22','#C6C6C6',9754,7,0);
/*!40000 ALTER TABLE `products` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `productvariation_translations`
--

DROP TABLE IF EXISTS `productvariation_translations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `productvariation_translations` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `productVariation_id` bigint(20) unsigned NOT NULL,
  `locale` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `productvariation_translations_productvariation_id_locale_unique` (`productVariation_id`,`locale`),
  KEY `productvariation_translations_locale_index` (`locale`),
  CONSTRAINT `productvariation_translations_productvariation_id_foreign` FOREIGN KEY (`productVariation_id`) REFERENCES `productvariations` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `productvariation_translations`
--

LOCK TABLES `productvariation_translations` WRITE;
/*!40000 ALTER TABLE `productvariation_translations` DISABLE KEYS */;
/*!40000 ALTER TABLE `productvariation_translations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `productvariations`
--

DROP TABLE IF EXISTS `productvariations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `productvariations` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `price` double NOT NULL DEFAULT '0',
  `quantity` int(11) NOT NULL DEFAULT '0',
  `product_id` bigint(20) unsigned DEFAULT NULL,
  `size_id` bigint(20) unsigned DEFAULT NULL,
  `color_id` bigint(20) unsigned DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `productvariations_product_id_foreign` (`product_id`),
  KEY `productvariations_size_id_foreign` (`size_id`),
  KEY `productvariations_color_id_foreign` (`color_id`),
  CONSTRAINT `productvariations_color_id_foreign` FOREIGN KEY (`color_id`) REFERENCES `colors` (`id`) ON DELETE CASCADE,
  CONSTRAINT `productvariations_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE,
  CONSTRAINT `productvariations_size_id_foreign` FOREIGN KEY (`size_id`) REFERENCES `sizes` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=433 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `productvariations`
--

LOCK TABLES `productvariations` WRITE;
/*!40000 ALTER TABLE `productvariations` DISABLE KEYS */;
INSERT INTO `productvariations` (`id`, `price`, `quantity`, `product_id`, `size_id`, `color_id`, `created_at`, `updated_at`) VALUES (376,40,10,44,3,12,'2025-03-12 11:20:53','2025-03-12 11:20:53'),(387,75,30,47,1,12,'2025-03-12 12:49:23','2025-03-12 12:49:23'),(388,70,20,47,2,12,'2025-03-12 12:49:23','2025-03-12 12:49:23'),(389,70,10,47,4,12,'2025-03-12 12:49:23','2025-03-12 12:49:23'),(390,70,10,48,2,11,'2025-03-12 12:52:40','2025-03-12 12:52:40'),(391,70,15,48,3,11,'2025-03-12 12:52:40','2025-03-12 12:52:40'),(402,55,20,53,3,15,'2025-03-12 21:10:21','2025-03-12 21:10:21'),(403,55,20,53,4,15,'2025-03-12 21:10:21','2025-03-12 21:10:21'),(404,60,20,53,14,15,'2025-03-12 21:10:21','2025-03-12 21:10:21'),(405,55,20,53,2,15,'2025-03-12 21:10:21','2025-03-12 21:10:21'),(430,50,10,55,1,7,'2025-03-21 01:26:44','2025-03-21 01:26:44'),(431,45,10,55,2,7,'2025-03-21 01:26:44','2025-03-21 01:26:44'),(432,45,10,55,3,7,'2025-03-21 01:26:44','2025-03-21 01:26:44');
/*!40000 ALTER TABLE `productvariations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `role_has_permissions`
--

DROP TABLE IF EXISTS `role_has_permissions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `role_has_permissions` (
  `permission_id` bigint(20) unsigned NOT NULL,
  `role_id` bigint(20) unsigned NOT NULL,
  PRIMARY KEY (`permission_id`,`role_id`),
  KEY `role_has_permissions_role_id_foreign` (`role_id`),
  CONSTRAINT `role_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE,
  CONSTRAINT `role_has_permissions_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `role_has_permissions`
--

LOCK TABLES `role_has_permissions` WRITE;
/*!40000 ALTER TABLE `role_has_permissions` DISABLE KEYS */;
INSERT INTO `role_has_permissions` (`permission_id`, `role_id`) VALUES (1,1),(2,1),(3,1),(4,1),(5,1),(6,1),(7,1),(8,1),(9,1),(10,1),(11,1),(12,1),(13,1),(14,1),(15,1),(16,1),(17,1),(18,1),(19,1),(20,1),(21,1),(22,1),(23,1),(24,1),(25,1),(26,1),(27,1),(28,1),(29,1),(32,1),(33,1),(34,1),(35,1),(36,1),(37,1),(38,1),(39,1),(40,1),(41,1),(42,1),(43,1),(44,1),(45,1),(46,1),(47,1),(48,1),(49,1),(50,1),(51,1),(52,1),(53,1),(54,1),(55,1),(56,1),(57,1),(58,1),(59,1),(60,1),(61,1),(62,1),(63,1),(64,1),(65,1),(70,1),(71,1),(72,1),(73,1),(74,1),(75,1),(76,1),(77,1),(78,1),(79,1),(80,1),(81,1),(82,1),(83,1);
/*!40000 ALTER TABLE `role_has_permissions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `roles`
--

DROP TABLE IF EXISTS `roles`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `roles` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `guard_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `roles_name_guard_name_unique` (`name`,`guard_name`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `roles`
--

LOCK TABLES `roles` WRITE;
/*!40000 ALTER TABLE `roles` DISABLE KEYS */;
INSERT INTO `roles` (`id`, `name`, `guard_name`, `created_at`, `updated_at`) VALUES (1,'admin','admin','2025-02-12 09:07:53','2025-02-12 09:07:53');
/*!40000 ALTER TABLE `roles` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `service_translations`
--

DROP TABLE IF EXISTS `service_translations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `service_translations` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `service_id` bigint(20) unsigned NOT NULL,
  `locale` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `service_translations_service_id_locale_unique` (`service_id`,`locale`),
  KEY `service_translations_locale_index` (`locale`),
  CONSTRAINT `service_translations_service_id_foreign` FOREIGN KEY (`service_id`) REFERENCES `services` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `service_translations`
--

LOCK TABLES `service_translations` WRITE;
/*!40000 ALTER TABLE `service_translations` DISABLE KEYS */;
INSERT INTO `service_translations` (`id`, `title`, `description`, `service_id`, `locale`, `created_at`, `updated_at`) VALUES (1,'Fleurs','<p data-start=\"229\" data-end=\"376\" class=\"\">Découvrez nos magnifiques collections de fleurs pour chaque occasion. Fraîches, élégantes et livrées avec amour.</p>\r\n<p data-start=\"378\" data-end=\"489\" class=\"\"></p>',1,'ar','2025-04-16 18:04:16','2025-04-16 21:39:51'),(2,'Flowers','<p data-start=\"92\" data-end=\"227\" class=\"\">Discover our stunning flower collections for every occasion. Fresh, elegant, and delivered with love.</p>\r\n<p data-start=\"229\" data-end=\"376\" class=\"\"></p>',1,'en','2025-04-16 18:04:16','2025-04-16 21:39:51'),(3,'الزهور','<p data-start=\"378\" data-end=\"489\" class=\"\">استمتع بتشكيلة رائعة من الزهور لكل مناسبة. زهور طبيعية وأنيقة تُسلَّم بكل حب.</p>',1,'fr','2025-04-16 18:04:16','2025-04-16 21:39:51'),(4,'تصاميم الأزهار','<p data-start=\"352\" data-end=\"465\" class=\"\">تنسيقات زهور فريدة مصممة خصيصًا لتناسب ذوقك وتُضفي لمسة خاصة على كل لحظة.</p>',2,'ar','2025-04-16 18:04:16','2025-04-16 21:44:05'),(5,'Floral Designs','<p data-start=\"84\" data-end=\"210\" class=\"\">Unique floral arrangements crafted to match your style and make every moment special.</p>\r\n<p data-start=\"212\" data-end=\"350\" class=\"\"></p>',2,'en','2025-04-16 18:04:16','2025-04-16 21:44:05'),(6,'Motifs floraux','<p data-start=\"212\" data-end=\"350\" class=\"\">Des compositions florales uniques conçues selon votre style pour rendre chaque moment spécial.</p>\r\n<p data-start=\"352\" data-end=\"465\" class=\"\"></p>',2,'fr','2025-04-16 18:04:16','2025-04-16 21:44:05'),(7,'الفنادق','<p data-start=\"335\" data-end=\"443\" class=\"\">تنسيقات زهرية أنيقة مصممة خصيصًا لردهات الفنادق والغرف والفعاليات الخاصة.</p>',3,'ar','2025-04-16 18:04:16','2025-04-16 21:46:45'),(8,'Hotels','<p data-start=\"77\" data-end=\"186\" class=\"\">Elegant floral setups tailored for hotel lobbies, rooms, and special events.</p>\r\n<p data-start=\"188\" data-end=\"333\" class=\"\"></p>',3,'en','2025-04-16 18:04:16','2025-04-16 21:46:45'),(9,'Hôtels','<p data-start=\"188\" data-end=\"333\" class=\"\">Des décorations florales élégantes conçues pour les halls, les chambres et les événements spéciaux des hôtels.</p>\r\n<p data-start=\"335\" data-end=\"443\" class=\"\"></p>',3,'fr','2025-04-16 18:04:16','2025-04-16 21:46:45'),(10,'حفلات الزفاف والمناسبات','<p style=\"text-align: center;\" dir=\"rtl\">\r\n    <font style=\"background-color: rgb(255, 255, 255);\" color=\"#000000\">\r\n        <span style=\"font-family: \'Arial Black\';\">خدمات حفلات الزفاف</span>\r\n    </font>\r\n</p>\r\n\r\n<p style=\"text-align: right;\" dir=\"rtl\">خلفية زهرية للحفل</p>\r\n<ol dir=\"rtl\" style=\"text-align: right;\">\r\n  <li>تصاميم أنيقة مزينة بأجود أنواع الزهور لتكون خلفية مثالية ليومك المميز.</li>\r\n</ol>\r\n\r\n<p style=\"text-align: right;\" dir=\"rtl\">قطع التزيين للطاولات</p>\r\n<ol dir=\"rtl\" style=\"text-align: right;\">\r\n  <li>تنسيقات فاخرة تُضفي لمسة من الجمال والرقي لكل طاولة.</li>\r\n</ol>\r\n\r\n<p style=\"text-align: right;\" dir=\"rtl\">أرضية الرقص</p>\r\n<ol dir=\"rtl\" style=\"text-align: right;\">\r\n  <li>أرضيات رقص عصرية أنيقة تعزز من أجواء الاحتفال.</li>\r\n</ol>\r\n\r\n<p style=\"text-align: right;\" dir=\"rtl\">الكراسي</p>\r\n<ol dir=\"rtl\" style=\"text-align: right;\">\r\n  <li>تشكيلة متنوعة من الكراسي الأنيقة لتناسب أي نمط من الفعاليات.</li>\r\n</ol>\r\n\r\n<p style=\"text-align: right;\" dir=\"rtl\">الطاولات</p>\r\n<ol dir=\"rtl\" style=\"text-align: right;\">\r\n  <li>طاولات فاخرة بأحجام وأشكال متعددة لتلائم تصميم الحدث.</li>\r\n</ol>\r\n\r\n<p style=\"text-align: right;\" dir=\"rtl\">السقف المزخرف</p>\r\n<ol dir=\"rtl\" style=\"text-align: right;\">\r\n  <li>زخارف زهرية أو إضاءة ساحرة تضفي جواً خيالياً وفاخراً.</li>\r\n</ol>\r\n\r\n<p style=\"text-align: right;\" dir=\"rtl\">تصميم المدخل</p>\r\n<ol dir=\"rtl\" style=\"text-align: right;\">\r\n  <li>مدخل فاخر يرحب بضيوفك بأناقة ورُقي.</li>\r\n</ol>\r\n\r\n<p style=\"text-align: right;\" dir=\"rtl\">الإضاءة</p>\r\n<ol dir=\"rtl\" style=\"text-align: right;\">\r\n  <li>حلول إضاءة مبتكرة لخلق الأجواء المثالية لمناسبتك.</li>\r\n</ol>\r\n\r\n<p style=\"text-align: right;\" dir=\"rtl\">عملية التخطيط</p>\r\n<ol dir=\"rtl\" style=\"text-align: right;\">\r\n  <li>الاستشارة والرؤية – نبدأ بفهم أحلامك وتفضيلاتك وموضوع الحدث.</li>\r\n  <li>المفهوم والتصميم – نصمم لك تصوراً مميزاً يشمل الديكور والزهور والإضاءة.</li>\r\n  <li>التخطيط والتنسيق – نُدير كافة التفاصيل اللوجستية من التجهيز إلى جدولة الحدث.</li>\r\n  <li>اللمسات النهائية – نُتقن كل تفصيلة لتستمتع بيومك المميز.</li>\r\n  <li>يوم الحفل – فريقنا يضمن تنفيذًا سلسًا ليكون يومك لا يُنسى. مع \"فيوري فلاور\"، حلمك يصبح حقيقة!</li>\r\n</ol>',4,'ar','2025-04-16 18:04:16','2025-04-16 22:18:04'),(11,'Wedding & Events','<p style=\"text-align: center;\"><font style=\"background-color: rgb(255, 255, 255);\" color=\"#000000\"><span style=\"font-family: \"Arial Black\";\">Our Wedding Services</span></font></p><p style=\"text-align: left;\"><font color=\"#000000\" style=\"background-color: rgb(255, 255, 255);\">Floral Wedding Backdrop</font></p><ol><li style=\"text-align: left;\"><font color=\"#000000\" style=\"background-color: rgb(255, 255, 255); font-weight: normal;\">Elegant designs adorned with the finest flowers, creating the perfect backdrop for your special day.</font></li></ol><p style=\"text-align: left;\"><font color=\"#000000\" style=\"background-color: rgb(255, 255, 255);\">Centerpieces</font></p><ol><li style=\"text-align: left;\"><font color=\"#000000\" style=\"background-color: rgb(255, 255, 255); font-weight: normal;\">Luxurious table arrangements that add beauty and sophistication to every table.</font></li></ol><p><font color=\"#000000\">Dance Floor </font></p><ol><li><font color=\"#000000\" style=\"font-weight: normal;\">Stylish and modern dance floors that enhance the celebration’s ambiance.</font></li></ol><p><font color=\"#000000\">Chairs</font></p><ol><li style=\"font-weight: normal;\"><font color=\"#000000\">A variety of elegant chair designs to complement any </font><span style=\"color: rgb(0, 0, 0); letter-spacing: 0.7px;\">event style.</span></li></ol><p style=\"\"><font color=\"#000000\">Tables</font></p><ol><li><font color=\"#000000\"><span style=\"font-weight: 400;\">Premium tables in different sizes and shapes to suit your event’s layout.</span></font></li></ol><p style=\"\"><font color=\"#000000\">Decorated Ceiling</font></p><ol><li><font color=\"#000000\"><span style=\"font-weight: 400;\">Stunning floral or lighting decorations to create </span></font><span style=\"font-weight: 400; color: rgb(0, 0, 0); letter-spacing: 0.7px;\">a magical and luxurious atmosphere.</span></li></ol><p><font color=\"#000000\">Entrance Design</font></p><ol><li><font color=\"#000000\"><span style=\"font-weight: 400;\"> A grand entrance setup that welcomes your guests with elegance and style.</span></font></li></ol><p><font color=\"#000000\">Lighting</font></p><ol><li><font color=\"#000000\"><span style=\"font-weight: 400;\">Creative lighting solutions to set the perfect </span></font><span style=\"font-weight: 400; color: rgb(0, 0, 0); letter-spacing: 0.7px;\">mood for your event.</span></li></ol><p style=\"text-align: center; \"><font color=\"#000000\" style=\"background-color: rgb(255, 255, 255);\">Planning Process</font></p><p style=\"text-align: center; \"><font color=\"#000000\" style=\"background-color: rgb(255, 255, 255);\"><br></font></p><ol><ol><ol><ol><li><span style=\"font-weight: normal; color: rgb(0, 0, 0); font-size: 13px; letter-spacing: 0.7px;\"><br></span></li><li><span style=\"font-weight: normal; color: rgb(0, 0, 0); font-size: 13px; letter-spacing: 0.7px;\"><br></span></li><li><span style=\"font-weight: normal; color: rgb(0, 0, 0); font-size: 13px; letter-spacing: 0.7px;\"><br></span></li><li><span style=\"font-weight: normal; color: rgb(0, 0, 0); font-size: 13px; letter-spacing: 0.7px;\"><br></span></li><li><span style=\"font-weight: normal; color: rgb(0, 0, 0); font-size: 13px; letter-spacing: 0.7px;\"><br></span></li><li><span style=\"font-weight: normal; color: rgb(0, 0, 0); font-size: 13px; letter-spacing: 0.7px;\">Consultation & Vision – We start by understanding your dreams, preferences, and event theme.</span></li></ol></ol></ol><li style=\"text-align: left;\"><font color=\"#000000\" style=\"background-color: rgb(255, 255, 255); font-weight: normal;\">Concept & Design – Our experts craft a personalized concept, including décor, floral arrangements, and lighting.</font></li><li style=\"text-align: left;\"><font color=\"#000000\" style=\"background-color: rgb(255, 255, 255); font-weight: normal;\">Planning & Coordination – We handle all logistics, from venue setup to timeline management, ensuring smooth execution.</font></li><li style=\"text-align: left;\"><font color=\"#000000\" style=\"background-color: rgb(255, 255, 255); font-weight: normal;\">Final Touches – Every detail is perfected, so you can relax and enjoy your specialday.5- The Big Day – Our team ensures flawless execution, making your event an unforgettable experience. With Fiori Flower, your vision comes to life effortlessly!</font></li></ol>',4,'en','2025-04-16 18:04:16','2025-04-16 22:18:04'),(12,'Mariages et Événements','<p style=\"text-align: center;\"><font style=\"background-color: rgb(255, 255, 255);\" color=\"#000000\"><span style=\"font-family: \'Arial Black\';\">Nos Services de Mariage</span></font></p>\r\n<p style=\"text-align: left;\">Décor floral de fond</p>\r\n<ol>\r\n  <li>Des designs élégants ornés des plus belles fleurs pour une toile de fond parfaite.</li>\r\n</ol>\r\n<p>Centres de table</p>\r\n<ol>\r\n  <li>Des arrangements luxueux qui apportent beauté et raffinement à chaque table.</li>\r\n</ol>\r\n<p>Piste de danse</p>\r\n<ol>\r\n  <li>Des pistes de danse modernes et élégantes qui subliment l’ambiance.</li>\r\n</ol>\r\n<p>Chaises</p>\r\n<ol>\r\n  <li>Une variété de chaises élégantes adaptées à tous les styles d’événement.</li>\r\n</ol>\r\n<p>Tables</p>\r\n<ol>\r\n  <li>Des tables de qualité en différentes tailles et formes selon votre disposition.</li>\r\n</ol>\r\n<p>Plafond décoré</p>\r\n<ol>\r\n  <li>Des décors floraux ou lumineux pour une ambiance magique et luxueuse.</li>\r\n</ol>\r\n<p>Design d’entrée</p>\r\n<ol>\r\n  <li>Une entrée grandiose accueillant vos invités avec élégance.</li>\r\n</ol>\r\n<p>Éclairage</p>\r\n<ol>\r\n  <li>Des solutions lumineuses créatives pour une atmosphère parfaite.</li>\r\n</ol>\r\n<p style=\"text-align: center;\">Processus de planification</p>\r\n<ol>\r\n  <li>Consultation & Vision – Nous comprenons d’abord vos rêves, préférences et le thème de l’événement.</li>\r\n  <li>Concept & Design – Nos experts conçoivent un projet personnalisé incluant décor, fleurs et éclairage.</li>\r\n  <li>Planification & Coordination – Nous gérons toute la logistique pour une exécution fluide.</li>\r\n  <li>Touches finales – Chaque détail est perfectionné pour que vous puissiez profiter pleinement de votre journée.</li>\r\n  <li>Le Grand Jour – Notre équipe assure une exécution parfaite pour un événement inoubliable. Avec Fiori Flower, votre rêve devient réalité !</li>\r\n</ol>',4,'fr','2025-04-16 18:04:16','2025-04-16 22:18:04');
/*!40000 ALTER TABLE `service_translations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `services`
--

DROP TABLE IF EXISTS `services`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `services` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `services`
--

LOCK TABLES `services` WRITE;
/*!40000 ALTER TABLE `services` DISABLE KEYS */;
INSERT INTO `services` (`id`, `created_at`, `updated_at`) VALUES (1,'2025-04-16 18:04:16','2025-04-16 18:04:16'),(2,'2025-04-16 18:04:16','2025-04-16 18:04:16'),(3,'2025-04-16 18:04:16','2025-04-16 18:04:16'),(4,'2025-04-16 18:04:16','2025-04-16 18:04:16');
/*!40000 ALTER TABLE `services` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `setting_translations`
--

DROP TABLE IF EXISTS `setting_translations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `setting_translations` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `address` text COLLATE utf8mb4_unicode_ci,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `appointment` text COLLATE utf8mb4_unicode_ci,
  `copyright` text COLLATE utf8mb4_unicode_ci,
  `meta_data` text COLLATE utf8mb4_unicode_ci,
  `policy` text COLLATE utf8mb4_unicode_ci,
  `setting_id` bigint(20) unsigned NOT NULL,
  `locale` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `setting_translations_setting_id_locale_unique` (`setting_id`,`locale`),
  KEY `setting_translations_locale_index` (`locale`),
  CONSTRAINT `setting_translations_setting_id_foreign` FOREIGN KEY (`setting_id`) REFERENCES `settings` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `setting_translations`
--

LOCK TABLES `setting_translations` WRITE;
/*!40000 ALTER TABLE `setting_translations` DISABLE KEYS */;
INSERT INTO `setting_translations` (`id`, `address`, `title`, `description`, `appointment`, `copyright`, `meta_data`, `policy`, `setting_id`, `locale`, `created_at`, `updated_at`) VALUES (10,'Online Store','LapMob','LapMob is an electronic compoany that has many stores fill of Laptops and Mobiles Devices and cover all Egypt governrates',': 24/7','Copyright reserved by LapMob © 2025','LapMob  - The easies and cheapest way to buy Phones and Laptops','Flower Fiori - Excellence in Floral Art & Supply',4,'en','2025-04-01 14:52:43','2025-09-21 21:30:55'),(11,'Entrée Palm Hills, Mohandeseen, Hôtel Grand Nile Tower - Égypte','Flower Fiori','Fondée en 1994, Flower Fiori est devenue l\'une des marques leaders dans l\'arrangement floral et la fourniture de fleurs en Égypte. Au fil des ans, nous avons collaboré avec des entreprises prestigieuses telles que EFG Hermes et la Banque Arabe Africaine Internationale. Notre influence s\'étend aux hôtels les plus luxueux d\'Égypte, notamment le Four Seasons Hotel, le Hilton Heliopolis et le Hilton Grand Nile Tower.',': 24/7','Tous droits réservés par Flower Fiori © 2025','Flower Fiori - L’Art du Design Floral & Arrangements de Luxe','Flower Fiori - L’Excellence dans l’Art Floral & Fourniture',4,'fr','2025-04-01 14:52:43','2025-04-01 14:52:43'),(12,'متجر الكتروني','لابموب','لابموب هي شركة الكترونية تمتلك الكثير من المخازن الملئى باجهزة الابتوب والموبيلات في كل انحاء مصر بافضل الاسعار واقوي الضمانات',': 24/7','جميع الحقوق محفوظة لدى LapMob © 2025','لابموب - افضل واسهل طريقة لشراء هواتف واجهزة لابتوب','فلاور فيوري - التميز في فن الزهور وتوريدها',4,'ar','2025-04-01 14:52:43','2025-09-21 21:30:55');
/*!40000 ALTER TABLE `setting_translations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `settings`
--

DROP TABLE IF EXISTS `settings`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `settings` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `logo` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `white_logo` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tab` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `breadcrumb` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `map` text COLLATE utf8mb4_unicode_ci,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `latitude` text COLLATE utf8mb4_unicode_ci,
  `longitude` text COLLATE utf8mb4_unicode_ci,
  `nutritionDefault` text COLLATE utf8mb4_unicode_ci,
  `shipping` double DEFAULT NULL,
  `taxes` double DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `settings`
--

LOCK TABLES `settings` WRITE;
/*!40000 ALTER TABLE `settings` DISABLE KEYS */;
INSERT INTO `settings` (`id`, `logo`, `white_logo`, `tab`, `breadcrumb`, `map`, `image`, `latitude`, `longitude`, `nutritionDefault`, `shipping`, `taxes`, `created_at`, `updated_at`) VALUES (4,'images/0bW4rh4OFJMSYXsh16n1ZmP7kv3pwZkqRPnEVuVA.png','images/NWdOhkQOJwLnc8cgUdpEgKlIA38ctzOGSF5JDgqn.png','images/vdGTUrq8ftx1tAp6O5e7IPLnLUXuvIVwD47Z4YPb.png','images/TZb0eNyyzriIwXIELETQjBS5qdmYXQfmfegHEmQz.png','<iframe src=\"https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d55275.18948853619!2d31.18964315!3d30.016788299999998!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x1458469235579697%3A0x4e91d61f9878fc52!2sGiza%2C%20El%20Omraniya%2C%20Giza%20Governorate!5e0!3m2!1sen!2seg!4v1695471231297!5m2!1sen!2seg\" width=\"600\" height=\"450\" style=\"border:0;\" allowfullscreen=\"\" loading=\"lazy\" referrerpolicy=\"no-referrer-when-downgrade\"></iframe>','image',NULL,NULL,NULL,NULL,NULL,'2025-04-01 14:52:43','2025-09-21 20:31:12');
/*!40000 ALTER TABLE `settings` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `size_translations`
--

DROP TABLE IF EXISTS `size_translations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `size_translations` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `subtitle` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `size_id` bigint(20) unsigned NOT NULL,
  `locale` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `size_translations_size_id_locale_unique` (`size_id`,`locale`),
  KEY `size_translations_locale_index` (`locale`),
  CONSTRAINT `size_translations_size_id_foreign` FOREIGN KEY (`size_id`) REFERENCES `sizes` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=46 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `size_translations`
--

LOCK TABLES `size_translations` WRITE;
/*!40000 ALTER TABLE `size_translations` DISABLE KEYS */;
INSERT INTO `size_translations` (`id`, `title`, `subtitle`, `description`, `size_id`, `locale`, `created_at`, `updated_at`) VALUES (1,'صغير جدًا',NULL,NULL,1,'ar','2025-02-12 09:07:53','2025-02-12 09:07:53'),(2,'Extra Small',NULL,NULL,1,'en','2025-02-12 09:07:53','2025-02-12 09:07:53'),(3,'Très petit',NULL,NULL,1,'fr','2025-02-12 09:07:53','2025-02-12 09:07:53'),(4,'صغير',NULL,NULL,2,'ar','2025-02-12 09:07:53','2025-02-12 09:07:53'),(5,'Small',NULL,NULL,2,'en','2025-02-12 09:07:53','2025-02-12 09:07:53'),(6,'Petit',NULL,NULL,2,'fr','2025-02-12 09:07:53','2025-02-12 09:07:53'),(7,'متوسط',NULL,NULL,3,'ar','2025-02-12 09:07:53','2025-02-12 09:07:53'),(8,'Medium',NULL,NULL,3,'en','2025-02-12 09:07:53','2025-02-12 09:07:53'),(9,'Moyen',NULL,NULL,3,'fr','2025-02-12 09:07:53','2025-02-12 09:07:53'),(10,'كبير',NULL,NULL,4,'ar','2025-02-12 09:07:53','2025-02-12 09:07:53'),(11,'Large',NULL,NULL,4,'en','2025-02-12 09:07:53','2025-02-12 09:07:53'),(12,'Grand',NULL,NULL,4,'fr','2025-02-12 09:07:53','2025-02-12 09:07:53'),(13,'كبير جدًا',NULL,NULL,5,'ar','2025-02-12 09:07:53','2025-02-12 09:07:53'),(14,'Extra Large',NULL,NULL,5,'en','2025-02-12 09:07:53','2025-02-12 09:07:53'),(15,'Très grand',NULL,NULL,5,'fr','2025-02-12 09:07:53','2025-02-12 09:07:53'),(16,'ضعف كبير جدًا',NULL,NULL,6,'ar','2025-02-12 09:07:53','2025-02-12 09:07:53'),(17,'Double Extra Large',NULL,NULL,6,'en','2025-02-12 09:07:53','2025-02-12 09:07:53'),(18,'Double très grand',NULL,NULL,6,'fr','2025-02-12 09:07:53','2025-02-12 09:07:53'),(19,'ثلاثي كبير جدًا',NULL,NULL,7,'ar','2025-02-12 09:07:53','2025-02-12 09:07:53'),(20,'Triple Extra Large',NULL,NULL,7,'en','2025-02-12 09:07:53','2025-02-12 09:07:53'),(21,'Triple très grand',NULL,NULL,7,'fr','2025-02-12 09:07:53','2025-02-12 09:07:53'),(22,'مقاس واحد يناسب الجميع',NULL,NULL,8,'ar','2025-02-12 09:07:53','2025-02-12 09:07:53'),(23,'One Size Fits All',NULL,NULL,8,'en','2025-02-12 09:07:53','2025-02-12 09:07:53'),(24,'Taille unique',NULL,NULL,8,'fr','2025-02-12 09:07:53','2025-02-12 09:07:53'),(25,'صغير الحجم',NULL,NULL,9,'ar','2025-02-12 09:07:53','2025-02-12 09:07:53'),(26,'Petite',NULL,NULL,9,'en','2025-02-12 09:07:53','2025-02-12 09:07:53'),(27,'Petite',NULL,NULL,9,'fr','2025-02-12 09:07:53','2025-02-12 09:07:53'),(28,'مقاس كبير',NULL,NULL,10,'ar','2025-02-12 09:07:53','2025-02-12 09:07:53'),(29,'Plus Size',NULL,NULL,10,'en','2025-02-12 09:07:53','2025-02-12 09:07:53'),(30,'Grande taille',NULL,NULL,10,'fr','2025-02-12 09:07:53','2025-02-12 09:07:53'),(31,'Medium',NULL,NULL,11,'en','2025-02-18 22:18:36','2025-02-18 22:18:36'),(32,'متوسط',NULL,NULL,11,'ar','2025-02-18 22:18:36','2025-02-18 22:18:36'),(33,'French',NULL,NULL,11,'fr','2025-02-18 22:18:36','2025-02-18 22:18:36'),(34,'Small',NULL,NULL,12,'en','2025-02-18 22:20:03','2025-02-18 22:20:03'),(35,'من سن 15 الي 17',NULL,NULL,12,'ar','2025-02-18 22:20:03','2025-02-18 22:20:59'),(36,'French',NULL,NULL,12,'fr','2025-02-18 22:20:03','2025-02-18 22:20:03'),(37,'Extra Small',NULL,NULL,13,'en','2025-02-18 22:20:28','2025-02-18 22:20:28'),(38,'اطفال',NULL,NULL,13,'ar','2025-02-18 22:20:28','2025-02-18 22:20:28'),(39,'French',NULL,NULL,13,'fr','2025-02-18 22:20:28','2025-02-18 22:20:28'),(40,'X-large',NULL,NULL,14,'en','2025-02-19 22:30:13','2025-02-19 22:30:13'),(41,'اكس لارج',NULL,NULL,14,'ar','2025-02-19 22:30:13','2025-02-19 22:30:13'),(42,'French',NULL,NULL,14,'fr','2025-02-19 22:30:13','2025-02-19 22:30:13'),(43,'3X-Large',NULL,NULL,15,'en','2025-02-19 22:30:42','2025-02-20 13:45:44'),(44,'3اكس لارج',NULL,NULL,15,'ar','2025-02-19 22:30:42','2025-02-20 13:45:44'),(45,'-3French',NULL,NULL,15,'fr','2025-02-19 22:30:42','2025-02-20 13:45:44');
/*!40000 ALTER TABLE `size_translations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sizes`
--

DROP TABLE IF EXISTS `sizes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `sizes` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `store_id` bigint(20) unsigned DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `sizes_store_id_foreign` (`store_id`),
  CONSTRAINT `sizes_store_id_foreign` FOREIGN KEY (`store_id`) REFERENCES `stores` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sizes`
--

LOCK TABLES `sizes` WRITE;
/*!40000 ALTER TABLE `sizes` DISABLE KEYS */;
INSERT INTO `sizes` (`id`, `store_id`, `created_at`, `updated_at`) VALUES (1,7,'2025-02-12 09:07:53','2025-02-12 09:07:53'),(2,7,'2025-02-12 09:07:53','2025-03-12 11:16:23'),(3,7,'2025-02-12 09:07:53','2025-02-12 09:07:53'),(4,7,'2025-02-12 09:07:53','2025-03-12 11:16:51'),(5,9,'2025-02-12 09:07:53','2025-02-12 09:07:53'),(6,4,'2025-02-12 09:07:53','2025-02-12 09:07:53'),(7,3,'2025-02-12 09:07:53','2025-02-12 09:07:53'),(8,8,'2025-02-12 09:07:53','2025-02-12 09:07:53'),(9,9,'2025-02-12 09:07:53','2025-02-12 09:07:53'),(10,6,'2025-02-12 09:07:53','2025-02-12 09:07:53'),(11,7,'2025-02-18 22:18:36','2025-03-12 11:16:11'),(12,7,'2025-02-18 22:20:03','2025-03-12 11:16:02'),(13,11,'2025-02-18 22:20:28','2025-02-18 22:20:28'),(14,7,'2025-02-19 22:30:13','2025-03-12 11:15:51'),(15,11,'2025-02-19 22:30:42','2025-02-19 22:30:42');
/*!40000 ALTER TABLE `sizes` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `slider_translations`
--

DROP TABLE IF EXISTS `slider_translations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `slider_translations` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `slider_id` bigint(20) unsigned NOT NULL,
  `locale` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `subtitle` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `slider_translations_slider_id_locale_unique` (`slider_id`,`locale`),
  KEY `slider_translations_locale_index` (`locale`),
  CONSTRAINT `slider_translations_slider_id_foreign` FOREIGN KEY (`slider_id`) REFERENCES `sliders` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `slider_translations`
--

LOCK TABLES `slider_translations` WRITE;
/*!40000 ALTER TABLE `slider_translations` DISABLE KEYS */;
INSERT INTO `slider_translations` (`id`, `slider_id`, `locale`, `created_at`, `updated_at`, `title`, `subtitle`) VALUES (1,17,'ar','2025-04-08 18:26:54','2025-04-08 18:26:54','توصيل الورد الطازج','فاجئ أحبّاءك بترتيبات زهور طازجة'),(2,17,'en','2025-04-08 18:26:54','2025-04-08 18:26:54','Fresh Flowers Delivered','Surprise your loved ones with fresh floral arrangements'),(3,17,'fr','2025-04-08 18:26:54','2025-04-08 18:26:54','Fleurs Fraîches Livrées','Surprenez vos proches avec des arrangements floraux frais'),(4,18,'ar','2025-04-08 18:26:54','2025-04-08 18:26:54','ازهِر يومك','ابدأ يومك بالألوان والعطور'),(5,18,'en','2025-04-08 18:26:54','2025-04-08 18:26:54','Bloom Your Day','Start your day with colors and fragrances'),(6,18,'fr','2025-04-08 18:26:54','2025-04-08 18:26:54','Fleurissez Votre Journée','Commencez votre journée en couleurs et en senteurs'),(7,19,'ar','2025-04-08 18:26:54','2025-04-08 18:26:54','باقات أنيقة','زهور فاخرة لكل مناسبة'),(8,19,'en','2025-04-08 18:26:54','2025-04-08 18:26:54','Elegant Bouquets','Luxury flowers for every occasion'),(9,19,'fr','2025-04-08 18:26:54','2025-04-08 18:26:54','Bouquets Élégants','Des fleurs de luxe pour chaque occasion');
/*!40000 ALTER TABLE `slider_translations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sliders`
--

DROP TABLE IF EXISTS `sliders`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `sliders` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=20 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sliders`
--

LOCK TABLES `sliders` WRITE;
/*!40000 ALTER TABLE `sliders` DISABLE KEYS */;
INSERT INTO `sliders` (`id`, `created_at`, `updated_at`) VALUES (17,'2025-04-08 18:26:54','2025-04-08 18:26:54'),(18,'2025-04-08 18:26:54','2025-04-08 18:26:54'),(19,'2025-04-08 18:26:54','2025-04-08 18:26:54');
/*!40000 ALTER TABLE `sliders` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `store_translations`
--

DROP TABLE IF EXISTS `store_translations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `store_translations` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `store_id` bigint(20) unsigned NOT NULL,
  `locale` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `store_translations_store_id_locale_unique` (`store_id`,`locale`),
  KEY `store_translations_locale_index` (`locale`),
  CONSTRAINT `store_translations_store_id_foreign` FOREIGN KEY (`store_id`) REFERENCES `stores` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=38 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `store_translations`
--

LOCK TABLES `store_translations` WRITE;
/*!40000 ALTER TABLE `store_translations` DISABLE KEYS */;
INSERT INTO `store_translations` (`id`, `title`, `description`, `store_id`, `locale`, `created_at`, `updated_at`) VALUES (1,'مركز الموضة','اكتشف أحدث صيحات الموضة.',1,'ar','2025-02-12 09:07:53','2025-02-12 09:07:53'),(2,'Fashion Central','Discover the latest trends in fashion.',1,'en','2025-02-12 09:07:53','2025-02-12 09:07:53'),(3,'Centre de Mode','Découvrez les dernières tendances en mode.',1,'fr','2025-02-12 09:07:53','2025-02-12 09:07:53'),(4,'ملاذ التقنية','وجهتك لجميع احتياجات التكنولوجيا.',2,'ar','2025-02-12 09:07:53','2025-02-12 09:07:53'),(5,'Tech Haven','Your one-stop shop for technology needs.',2,'en','2025-02-12 09:07:53','2025-02-12 09:07:53'),(6,'Havre Technologique','Votre guichet unique pour les besoins technologiques.',2,'fr','2025-02-12 09:07:53','2025-02-12 09:07:53'),(7,'نعيم الجمال','كل ما تحتاجه لروتين الجمال الخاص بك.',3,'ar','2025-02-12 09:07:53','2025-02-12 09:07:53'),(8,'Beauty Bliss','Find everything for your beauty regimen.',3,'en','2025-02-12 09:07:53','2025-02-12 09:07:53'),(9,'Bonheur Beauté','Trouvez tout pour votre routine beauté.',3,'fr','2025-02-12 09:07:53','2025-02-12 09:07:53'),(10,'أساسيات المنزل','منتجات عالية الجودة لمنزلك.',4,'ar','2025-02-12 09:07:53','2025-02-12 09:07:53'),(11,'Home Essentials','Top-quality products for your home.',4,'en','2025-02-12 09:07:53','2025-02-12 09:07:53'),(12,'Essentiels de Maison','Des produits de qualité supérieure pour votre maison.',4,'fr','2025-02-12 09:07:53','2025-02-12 09:07:53'),(13,'مملكة الأطفال','ألعاب وملابس للأطفال من جميع الأعمار.',5,'ar','2025-02-12 09:07:53','2025-02-12 09:07:53'),(14,'Kids Kingdom','Toys and apparel for kids of all ages.',5,'en','2025-02-12 09:07:53','2025-02-12 09:07:53'),(15,'Royaume des Enfants','Jouets et vêtements pour les enfants de tous âges.',5,'fr','2025-02-12 09:07:53','2025-02-12 09:07:53'),(16,'مركز الرياضة','تجهيز نفسك لرياضتك المفضلة.',6,'ar','2025-02-12 09:07:53','2025-02-12 09:07:53'),(17,'Sports Hub','Gear up for your favorite sports.',6,'en','2025-02-12 09:07:53','2025-02-12 09:07:53'),(18,'Centre Sportif','Équipez-vous pour vos sports préférés.',6,'fr','2025-02-12 09:07:53','2025-02-12 09:07:53'),(19,'ADC','أحدث الأدوات والاكسسوارات.',7,'ar','2025-02-12 09:07:53','2025-03-12 11:13:49'),(20,'ADC','Cutting-edge gadgets and accessories.',7,'en','2025-02-12 09:07:53','2025-03-12 11:13:49'),(21,'ADC','Des gadgets et accessoires à la pointe de la technologie.',7,'fr','2025-02-12 09:07:53','2025-03-12 11:13:49'),(22,'حياة الفخامة','استمتع بمنتجات فاخرة تناسب أسلوب حياتك.',8,'ar','2025-02-12 09:07:53','2025-02-12 09:07:53'),(23,'Luxury Living','Indulge in luxury products for your lifestyle.',8,'en','2025-02-12 09:07:53','2025-02-12 09:07:53'),(24,'Vie de Luxe','Profitez de produits de luxe pour votre style de vie.',8,'fr','2025-02-12 09:07:53','2025-02-12 09:07:53'),(25,'زاوية الكتب','مجموعة مختارة بعناية من الكتب للجميع.',9,'ar','2025-02-12 09:07:53','2025-02-12 09:07:53'),(26,'Book Nook','A curated collection of books for everyone.',9,'en','2025-02-12 09:07:53','2025-02-12 09:07:53'),(27,'Coin des Livres','Une collection de livres soigneusement sélectionnés pour tous.',9,'fr','2025-02-12 09:07:53','2025-02-12 09:07:53'),(28,'حصاد صحي','منتجات طازجة وعضوية لحياة صحية.',10,'ar','2025-02-12 09:07:53','2025-02-12 09:07:53'),(29,'Healthy Harvest','Fresh and organic products for a healthy life.',10,'en','2025-02-12 09:07:53','2025-02-12 09:07:53'),(30,'Récolte Saine','Produits frais et biologiques pour une vie saine.',10,'fr','2025-02-12 09:07:53','2025-02-12 09:07:53'),(31,'Hero for Hero','Hero',11,'en','2025-02-18 22:17:50','2025-02-20 13:42:42'),(32,'المحيط للمحيط','المحيط',11,'ar','2025-02-18 22:17:50','2025-02-20 13:43:16'),(33,'Sdad','Sdad',11,'fr','2025-02-18 22:17:50','2025-02-18 22:17:50'),(34,'El hima',NULL,12,'en','2025-03-10 17:30:31','2025-03-10 17:30:31'),(37,NULL,NULL,15,'en','2025-03-11 11:46:25','2025-03-11 11:46:25');
/*!40000 ALTER TABLE `store_translations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `storebrands`
--

DROP TABLE IF EXISTS `storebrands`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `storebrands` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `store_id` bigint(20) unsigned DEFAULT NULL,
  `brand_id` bigint(20) unsigned DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `storebrands_store_id_foreign` (`store_id`),
  KEY `storebrands_brand_id_foreign` (`brand_id`),
  CONSTRAINT `storebrands_brand_id_foreign` FOREIGN KEY (`brand_id`) REFERENCES `brands` (`id`) ON DELETE CASCADE,
  CONSTRAINT `storebrands_store_id_foreign` FOREIGN KEY (`store_id`) REFERENCES `stores` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=25 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `storebrands`
--

LOCK TABLES `storebrands` WRITE;
/*!40000 ALTER TABLE `storebrands` DISABLE KEYS */;
INSERT INTO `storebrands` (`id`, `store_id`, `brand_id`, `created_at`, `updated_at`) VALUES (1,1,4,NULL,NULL),(2,1,9,NULL,NULL),(3,2,3,NULL,NULL),(4,2,6,NULL,NULL),(5,3,3,NULL,NULL),(6,3,9,NULL,NULL),(7,4,3,NULL,NULL),(8,4,10,NULL,NULL),(9,5,5,NULL,NULL),(10,5,8,NULL,NULL),(11,6,4,NULL,NULL),(12,6,8,NULL,NULL),(13,7,5,NULL,NULL),(14,7,7,NULL,NULL),(15,8,5,NULL,NULL),(16,8,9,NULL,NULL),(17,9,2,NULL,NULL),(18,9,10,NULL,NULL),(19,10,3,NULL,NULL),(20,10,7,NULL,NULL),(21,11,12,NULL,NULL),(22,7,1,NULL,NULL),(23,7,2,NULL,NULL),(24,7,3,NULL,NULL);
/*!40000 ALTER TABLE `storebrands` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `storecategories`
--

DROP TABLE IF EXISTS `storecategories`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `storecategories` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `store_id` bigint(20) unsigned DEFAULT NULL,
  `category_id` bigint(20) unsigned DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `storecategories_store_id_foreign` (`store_id`),
  KEY `storecategories_category_id_foreign` (`category_id`),
  CONSTRAINT `storecategories_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE CASCADE,
  CONSTRAINT `storecategories_store_id_foreign` FOREIGN KEY (`store_id`) REFERENCES `stores` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=29 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `storecategories`
--

LOCK TABLES `storecategories` WRITE;
/*!40000 ALTER TABLE `storecategories` DISABLE KEYS */;
INSERT INTO `storecategories` (`id`, `store_id`, `category_id`, `created_at`, `updated_at`) VALUES (5,3,1,NULL,NULL),(17,9,2,NULL,NULL),(22,11,1,NULL,NULL),(23,11,2,NULL,NULL),(27,7,1,NULL,NULL),(28,7,2,NULL,NULL);
/*!40000 ALTER TABLE `storecategories` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `stores`
--

DROP TABLE IF EXISTS `stores`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `stores` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `banner` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `deliveryCharge` double NOT NULL DEFAULT '0',
  `phone` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `address` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `merchant_id` bigint(20) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `stores_merchant_id_foreign` (`merchant_id`),
  CONSTRAINT `stores_merchant_id_foreign` FOREIGN KEY (`merchant_id`) REFERENCES `merchants` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `stores`
--

LOCK TABLES `stores` WRITE;
/*!40000 ALTER TABLE `stores` DISABLE KEYS */;
INSERT INTO `stores` (`id`, `banner`, `deliveryCharge`, `phone`, `email`, `address`, `status`, `created_at`, `updated_at`, `merchant_id`) VALUES (1,'store1_banner',20,'+966500000001','store1@gmail.com',NULL,'0','2025-02-12 09:07:53','2025-02-12 09:07:53',NULL),(2,'store2_banner',15,'+966500000002','store2@gmail.com',NULL,'0','2025-02-12 09:07:53','2025-02-12 09:07:53',NULL),(3,'store3_banner',20,'+966500000003','store3@gmail.com',NULL,'0','2025-02-12 09:07:53','2025-02-12 09:07:53',NULL),(4,'store4_banner',5,'+966500000004','store4@gmail.com',NULL,'0','2025-02-12 09:07:53','2025-02-12 09:07:53',NULL),(5,'store5_banner',12,'+966500000005','store5@gmail.com',NULL,'0','2025-02-12 09:07:53','2025-02-12 09:07:53',NULL),(6,'store6_banner',18,'+966500000006','store6@gmail.com',NULL,'0','2025-02-12 09:07:53','2025-02-12 09:07:53',NULL),(7,'store7_banner',5,'+966500000007','store7@gmail.com',NULL,'0','2025-02-12 09:07:53','2025-02-12 09:07:53',NULL),(8,'store8_banner',20,'+966500000008','store8@gmail.com',NULL,'0','2025-02-12 09:07:53','2025-02-12 09:07:53',NULL),(9,'store9_banner',17,'+966500000009','store9@gmail.com',NULL,'0','2025-02-12 09:07:53','2025-02-12 09:07:53',NULL),(10,'store10_banner',7,'+966500000010','store10@gmail.com',NULL,'0','2025-02-12 09:07:53','2025-02-12 09:07:53',NULL),(11,'1001',1500,'+966500000001','musokize2025@mailinator.com',NULL,'0','2025-02-18 22:17:50','2025-02-22 19:35:49',NULL),(12,NULL,0,'+966502548565','ibrahimsamy308@gmail.com','Family Court','0','2025-03-10 17:30:31','2025-03-10 17:30:31',1),(15,NULL,0,'+966502458757','ibrahimsamy308@gmail.com','Family Court','0','2025-03-11 11:46:25','2025-03-11 11:46:25',4);
/*!40000 ALTER TABLE `stores` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `subcategories`
--

DROP TABLE IF EXISTS `subcategories`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `subcategories` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `category_id` bigint(20) unsigned DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `subcategories_category_id_foreign` (`category_id`),
  CONSTRAINT `subcategories_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `subcategories`
--

LOCK TABLES `subcategories` WRITE;
/*!40000 ALTER TABLE `subcategories` DISABLE KEYS */;
INSERT INTO `subcategories` (`id`, `category_id`, `created_at`, `updated_at`) VALUES (3,2,'2025-03-30 20:22:28','2025-03-30 20:22:28'),(7,1,'2025-03-30 20:22:28','2025-03-30 20:22:28'),(8,2,'2025-03-30 20:22:28','2025-03-30 20:22:28'),(9,2,'2025-03-30 20:22:28','2025-03-30 20:22:28');
/*!40000 ALTER TABLE `subcategories` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `subcategory_translations`
--

DROP TABLE IF EXISTS `subcategory_translations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `subcategory_translations` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `subtitle` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `subcategory_id` bigint(20) unsigned NOT NULL,
  `locale` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `subcategory_translations_subcategory_id_locale_unique` (`subcategory_id`,`locale`),
  KEY `subcategory_translations_locale_index` (`locale`),
  CONSTRAINT `subcategory_translations_subcategory_id_foreign` FOREIGN KEY (`subcategory_id`) REFERENCES `subcategories` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=79 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `subcategory_translations`
--

LOCK TABLES `subcategory_translations` WRITE;
/*!40000 ALTER TABLE `subcategory_translations` DISABLE KEYS */;
INSERT INTO `subcategory_translations` (`id`, `title`, `subtitle`, `description`, `subcategory_id`, `locale`, `created_at`, `updated_at`) VALUES (58,'سامسونج',NULL,NULL,3,'ar','2025-03-30 20:22:28','2025-09-16 20:22:05'),(59,'Samsung',NULL,NULL,3,'en','2025-03-30 20:22:28','2025-09-16 20:22:05'),(60,'Tulipes',NULL,NULL,3,'fr','2025-03-30 20:22:28','2025-03-30 20:22:28'),(70,'ديل',NULL,NULL,7,'ar','2025-03-30 20:22:28','2025-09-16 20:22:49'),(71,'Dell',NULL,NULL,7,'en','2025-03-30 20:22:28','2025-09-16 20:22:49'),(72,'Œillets',NULL,NULL,7,'fr','2025-03-30 20:22:28','2025-03-30 20:22:28'),(73,'ايفون',NULL,NULL,8,'ar','2025-03-30 20:22:28','2025-09-16 20:23:15'),(74,'Iphone',NULL,NULL,8,'en','2025-03-30 20:22:28','2025-09-16 20:23:15'),(75,'Hortensias',NULL,NULL,8,'fr','2025-03-30 20:22:28','2025-03-30 20:22:28'),(76,'ريلمي',NULL,NULL,9,'ar','2025-03-30 20:22:28','2025-09-16 20:23:44'),(77,'Realme',NULL,NULL,9,'en','2025-03-30 20:22:28','2025-09-16 20:23:44'),(78,'Pivoines',NULL,NULL,9,'fr','2025-03-30 20:22:28','2025-03-30 20:22:28');
/*!40000 ALTER TABLE `subcategory_translations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `temb_order_products`
--

DROP TABLE IF EXISTS `temb_order_products`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `temb_order_products` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `temb_order_products`
--

LOCK TABLES `temb_order_products` WRITE;
/*!40000 ALTER TABLE `temb_order_products` DISABLE KEYS */;
/*!40000 ALTER TABLE `temb_order_products` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `temb_orders`
--

DROP TABLE IF EXISTS `temb_orders`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `temb_orders` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `phone` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `total` double DEFAULT NULL,
  `address` text COLLATE utf8mb4_unicode_ci,
  `cart` longtext COLLATE utf8mb4_unicode_ci,
  `user_id` bigint(20) unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `temb_orders_user_id_foreign` (`user_id`),
  CONSTRAINT `temb_orders_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `temb_orders`
--

LOCK TABLES `temb_orders` WRITE;
/*!40000 ALTER TABLE `temb_orders` DISABLE KEYS */;
/*!40000 ALTER TABLE `temb_orders` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `transactions`
--

DROP TABLE IF EXISTS `transactions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `transactions` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `order_id` bigint(20) unsigned NOT NULL,
  `user_id` bigint(20) unsigned NOT NULL,
  `amount` double NOT NULL DEFAULT '0',
  `transaction_id` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `transaction_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `payment_type` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'debit',
  `payment_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'wallet',
  `payment_gateway` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'hyperpay',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `transactions_order_id_foreign` (`order_id`),
  KEY `transactions_user_id_foreign` (`user_id`),
  CONSTRAINT `transactions_order_id_foreign` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE,
  CONSTRAINT `transactions_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=172 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `transactions`
--

LOCK TABLES `transactions` WRITE;
/*!40000 ALTER TABLE `transactions` DISABLE KEYS */;
INSERT INTO `transactions` (`id`, `order_id`, `user_id`, `amount`, `transaction_id`, `transaction_date`, `payment_type`, `payment_name`, `payment_gateway`, `created_at`, `updated_at`) VALUES (9,176,1,710,'82ddae02-ad6d-4700-b63a-97609df79ea6','2025-02-27 14:05:00','debit','wallet','wallet','2025-02-27 14:05:00','2025-02-27 14:05:00'),(10,177,1,1000,'8ac7a49f954554c6019547bb205a194d','2025-02-27 14:06:44','debit','card','digital_payment','2025-02-27 14:06:44','2025-02-27 14:06:44'),(11,178,1,2600,'8ac7a4a095455d15019547bd4f01747e','2025-02-27 14:09:04','debit','stc_pay','digital_payment','2025-02-27 14:09:04','2025-02-27 14:09:04'),(12,179,1,200,'8ac7a4a1954554ca019547be947811e9','2025-02-27 14:10:28','debit','stc_pay','digital_payment','2025-02-27 14:10:28','2025-02-27 14:10:28'),(13,180,1,710,'fce574a2-584f-4003-856a-e7037f8765d2','2025-02-27 14:55:06','debit','wallet','wallet','2025-02-27 14:55:06','2025-02-27 14:55:06'),(14,178,1,2600,'5a72c34f-de62-4139-9c5a-5cc85798a25e','2025-02-27 15:12:23','credit','wallet','wallet','2025-02-27 15:12:23','2025-02-27 15:12:23'),(15,161,1,2130,'1e6bcd6d-c7ae-476a-88ff-0024f0255f74','2025-02-27 15:16:38','credit','wallet','wallet','2025-02-27 15:16:38','2025-02-27 15:16:38'),(16,106,1,120,'6c962312-c50d-479a-bcfb-73501a1e5a7d','2025-02-27 15:17:46','credit','wallet','wallet','2025-02-27 15:17:46','2025-02-27 15:17:46'),(18,182,1,355,'fa4d8ab8-81e6-4d29-a15f-5a0003909803','2025-02-27 15:27:14','debit','wallet','wallet','2025-02-27 15:27:14','2025-02-27 15:27:14'),(19,183,1,200,'8ac7a4a295455d31019548059a73303d','2025-02-27 15:28:04','debit','card','digital_payment','2025-02-27 15:28:04','2025-02-27 15:28:04'),(21,185,1,710,'8ac7a49f954554c60195480769e755d5','2025-02-27 15:30:02','debit','card','digital_payment','2025-02-27 15:30:02','2025-02-27 15:30:02'),(22,186,1,300,'8ac7a49f954554c60195480cb6bb5c89','2025-02-27 15:35:54','debit','cards','digital_payment','2025-02-27 15:35:54','2025-02-27 15:35:54'),(23,187,1,355,'8ac7a4a295455d310195481476a1415f','2025-02-27 15:44:19','debit','cards','digital_payment','2025-02-27 15:44:19','2025-02-27 15:44:19'),(24,187,1,355,'ef414c4c-acdd-427b-8427-869350e1d2ac','2025-02-27 15:46:15','credit','wallet','wallet','2025-02-27 15:46:15','2025-02-27 15:46:15'),(25,186,1,300,'f4d3a094-e057-4d91-b9f1-7a65af6516ba','2025-02-27 15:52:24','credit','wallet','wallet','2025-02-27 15:52:24','2025-02-27 15:52:24'),(26,188,1,1200,'8ac7a4a1954554ca0195481cfe666cfc','2025-02-27 15:53:38','debit','card','digital_payment','2025-02-27 15:53:38','2025-02-27 15:53:38'),(27,188,1,1200,'8ac7a49f954554c60195481d7ff07d11','2025-02-27 15:54:07','credit','card','digital_payment','2025-02-27 15:54:07','2025-02-27 15:54:07'),(28,189,20,120,'b1a9d72f-12ec-4669-bfda-a31a86d95f34','2025-02-27 20:40:50','debit','wallet','wallet','2025-02-27 20:40:50','2025-02-27 20:40:50'),(29,190,20,355,'adda0211-e312-4428-8d55-8d247d9c3a21','2025-02-27 20:42:45','debit','wallet','wallet','2025-02-27 20:42:45','2025-02-27 20:42:45'),(30,191,20,100,'e63b9c67-6d69-4f59-b35c-5b1fa8d08c94','2025-02-27 20:43:18','debit','wallet','wallet','2025-02-27 20:43:18','2025-02-27 20:43:18'),(31,185,1,710,'82f4b1f4-aba9-495a-8a36-32d2278e999e','2025-03-02 10:43:03','credit','wallet','wallet','2025-03-02 10:43:03','2025-03-02 10:43:03'),(32,183,1,200,'1d0d6e66-d2a0-4ebb-9cbc-ea8f5256e8f9','2025-03-02 10:44:13','credit','wallet','wallet','2025-03-02 10:44:13','2025-03-02 10:44:13'),(33,192,1,355,'f980105c-5023-4022-a30f-b4f45307de7a','2025-03-02 10:44:36','debit','wallet','wallet','2025-03-02 10:44:36','2025-03-02 10:44:36'),(34,193,1,100,'8ac7a4a2954d8b6e01955675a31a4ca4','2025-03-02 10:45:08','debit','card','digital_payment','2025-03-02 10:45:08','2025-03-02 10:45:08'),(35,193,1,100,'8ac7a4a2954d8b6e0195567661804e0f','2025-03-02 10:45:53','credit','card','digital_payment','2025-03-02 10:45:53','2025-03-02 10:45:53'),(36,194,1,100,'8ac7a4a0954d8b55019556772de754bf','2025-03-02 10:46:49','debit','card','digital_payment','2025-03-02 10:46:49','2025-03-02 10:46:49'),(37,194,1,100,'8ac7a4a1954d82c801955677b2916419','2025-03-02 10:47:20','credit','card','digital_payment','2025-03-02 10:47:20','2025-03-02 10:47:20'),(38,192,1,355,'287303fb-ab13-418e-8d65-bc065356c8bb','2025-03-02 10:58:46','credit','wallet','wallet','2025-03-02 10:58:46','2025-03-02 10:58:46'),(53,198,49,3850,'8ac7a4a0954d8b5501955923732e280f','2025-03-02 23:14:11','debit','stc_pay','digital_payment','2025-03-02 23:14:11','2025-03-02 23:14:11'),(54,199,49,1500,'8ac7a4a1954d82c801955935e5774e69','2025-03-02 23:34:20','debit','stc_pay','digital_payment','2025-03-02 23:34:20','2025-03-02 23:34:20'),(55,198,49,3850,'8ac7a4a1954d82c801955937163f4fa8','2025-03-02 23:35:37','credit','stc_pay','digital_payment','2025-03-02 23:35:37','2025-03-02 23:35:37'),(59,182,1,355,'8579435e-81a3-4b5e-8a15-9011b6722b5e','2025-03-03 09:29:37','credit','wallet','wallet','2025-03-03 09:29:37','2025-03-03 09:29:37'),(60,203,50,37508,'bbeb8688-5ae7-4f84-a2c9-02a82a4b3a0b','2025-03-03 10:39:49','debit','wallet','wallet','2025-03-03 10:39:49','2025-03-03 10:39:49'),(61,204,1,300,'c8a27eb9-a167-454d-9935-ce084b54aedf','2025-03-03 10:46:42','debit','wallet','wallet','2025-03-03 10:46:42','2025-03-03 10:46:42'),(62,205,59,5000,'8ac7a4a19568502401956bcbc31f6f70','2025-03-06 14:11:11','debit','stc_pay','digital_payment','2025-03-06 14:11:11','2025-03-06 14:11:11'),(63,206,59,5000,'8ac7a4a19568502401956bd687010441','2025-03-06 14:22:57','debit','stc_pay','digital_payment','2025-03-06 14:22:57','2025-03-06 14:22:57'),(68,210,19,546,'11e9b428-81ba-4f65-bbe3-0753fc4a6fe2','2025-03-10 23:34:18','debit','wallet','wallet','2025-03-10 23:34:18','2025-03-10 23:34:18'),(77,217,19,99,'2cfd69e7-892a-49dc-8f1e-5aae306ee7d4','2025-03-12 13:02:32','debit','wallet','wallet','2025-03-12 13:02:32','2025-03-12 13:02:32'),(83,210,19,546,'a6ea24b2-0312-4532-9245-a8143820fdb8','2025-03-12 21:57:55','credit','wallet','wallet','2025-03-12 21:57:55','2025-03-12 21:57:55'),(84,217,19,99,'d1415a3c-2f76-48cb-8a70-eac969053eac','2025-03-12 22:05:13','credit','wallet','wallet','2025-03-12 22:05:13','2025-03-12 22:05:13'),(85,219,19,122,'4e65c7ee-514e-4dd1-bc58-f958b803bd69','2025-03-12 22:19:07','debit','wallet','wallet','2025-03-12 22:19:07','2025-03-12 22:19:07'),(86,219,19,122,'a8839224-9805-47d2-b438-f64bee7fa4b6','2025-03-12 22:20:08','credit','wallet','wallet','2025-03-12 22:20:08','2025-03-12 22:20:08'),(100,226,19,110,'4b256571-1408-4eac-8ddf-9f53bc4a55f1','2025-03-16 12:54:57','debit','wallet','wallet','2025-03-16 12:54:57','2025-03-16 12:54:57'),(101,226,19,110,'28e80553-072c-4709-a970-229ea3d3c09a','2025-03-16 12:55:28','credit','wallet','wallet','2025-03-16 12:55:28','2025-03-16 12:55:28'),(102,227,19,215,'160ab6fe-4e91-4697-aa23-1e467e01af92','2025-03-16 13:22:22','debit','wallet','wallet','2025-03-16 13:22:22','2025-03-16 13:22:22'),(103,227,19,215,'82233d41-5842-4776-b788-067da8393736','2025-03-16 13:22:47','credit','wallet','wallet','2025-03-16 13:22:47','2025-03-16 13:22:47'),(108,230,19,185,'4380f82c-d50d-41d2-add0-296f84239ae5','2025-03-18 20:05:36','debit','wallet','wallet','2025-03-18 20:05:36','2025-03-18 20:05:36'),(115,237,19,365,'773c2a1c-ee46-4eab-a29f-0e27a2a46a6a','2025-03-19 11:13:50','debit','wallet','wallet','2025-03-19 11:13:50','2025-03-19 11:13:50'),(116,238,19,169,'74dabcef-838a-4b99-ac80-f297b1871f51','2025-03-19 20:12:58','debit','wallet','wallet','2025-03-19 20:12:58','2025-03-19 20:12:58'),(117,239,19,258,'fa87d16a-3fbe-478b-badb-95ff11ddee59','2025-03-19 22:07:21','debit','wallet','wallet','2025-03-19 22:07:21','2025-03-19 22:07:21'),(118,240,19,640,'7718e9fe-60ff-4e96-a285-6b9807cc1bc0','2025-03-21 04:04:53','debit','wallet','wallet','2025-03-21 04:04:53','2025-03-21 04:04:53'),(119,241,19,55,'cd9111bc-57cc-4b26-ad88-bba799b1d74d','2025-03-21 04:30:09','debit','wallet','wallet','2025-03-21 04:30:09','2025-03-21 04:30:09'),(120,242,19,60,'e3f5d5ae-71c6-46dc-ba58-48003c86320f','2025-03-21 04:31:38','debit','wallet','wallet','2025-03-21 04:31:38','2025-03-21 04:31:38'),(121,243,19,40,'4c84cd58-7b3b-4c59-aa37-b19f5db32575','2025-03-21 04:33:22','debit','wallet','wallet','2025-03-21 04:33:22','2025-03-21 04:33:22'),(122,244,26,63,'3df4442a-a1eb-43e9-a901-25ddd8ff879e','2025-03-24 12:42:47','debit','wallet','wallet','2025-03-24 12:42:47','2025-03-24 12:42:47'),(124,246,1,0,'8bef4770-79b4-4db8-be7f-fbb8f01d443d','2025-03-30 08:42:53','debit','wallet','wallet','2025-03-30 08:42:53','2025-03-30 08:42:53'),(125,247,1,0,'5e1862e1-4ee9-4d6b-8edf-df070d7b9135','2025-03-30 16:46:42','debit','wallet','wallet','2025-03-30 16:46:42','2025-03-30 16:46:42'),(126,248,1,0,'b0727a03-ad1f-49bc-9456-119acdbf332c','2025-03-30 18:42:26','debit','wallet','wallet','2025-03-30 18:42:26','2025-03-30 18:42:26'),(127,251,1,4921,'9ef32967-bfe4-4c49-a2f4-b1bd5803fa89','2025-03-31 00:45:19','debit','wallet','wallet','2025-03-31 00:45:19','2025-03-31 00:45:19'),(128,252,1,0,'6b8ba012-1bb7-4f8d-8743-2ff97a2b710f','2025-03-31 00:48:15','debit','wallet','wallet','2025-03-31 00:48:15','2025-03-31 00:48:15'),(129,253,1,0,'572445c7-7725-46f2-af53-524ce8c02248','2025-03-31 00:50:28','debit','wallet','wallet','2025-03-31 00:50:28','2025-03-31 00:50:28'),(130,254,1,753,'a9a64589-e300-46b3-a585-580d2b53d432','2025-03-31 00:51:20','debit','wallet','wallet','2025-03-31 00:51:20','2025-03-31 00:51:20'),(131,255,1,0,'629f23b3-5124-4caf-882b-93c83ff8e181','2025-03-31 00:53:14','debit','wallet','wallet','2025-03-31 00:53:14','2025-03-31 00:53:14'),(132,256,1,753,'439e451f-b10b-4ed1-9134-ce5f95101283','2025-03-31 00:53:25','debit','wallet','wallet','2025-03-31 00:53:25','2025-03-31 00:53:25'),(133,257,1,0,'3f866f67-bea8-4d05-967d-3aaa86c1869d','2025-03-31 01:44:13','debit','wallet','wallet','2025-03-31 01:44:13','2025-03-31 01:44:13'),(134,258,1,1000,'bc4137b4-6047-46ec-8424-ab513ad1fdd7','2025-03-31 01:58:04','debit','wallet','wallet','2025-03-31 01:58:04','2025-03-31 01:58:04'),(135,259,1,1676,'bcfdffa5-1f83-4034-84b7-e2e5ac1f9db9','2025-03-31 02:15:10','debit','wallet','wallet','2025-03-31 02:15:10','2025-03-31 02:15:10'),(136,260,1,3012,'0886e668-bfd2-4939-9a5b-b28461dc2b33','2025-03-31 02:22:31','debit','wallet','wallet','2025-03-31 02:22:31','2025-03-31 02:22:31'),(137,261,1,1583,'e0b315a1-9ff8-4996-bf89-aec1a005ac9a','2025-03-31 02:24:41','debit','wallet','wallet','2025-03-31 02:24:41','2025-03-31 02:24:41'),(138,262,1,0,'560f6e86-0c41-44b7-9253-27757a3f0fd5','2025-03-31 02:25:18','debit','wallet','wallet','2025-03-31 02:25:18','2025-03-31 02:25:18'),(139,263,1,394,'aab87b00-c701-49a2-9a05-64100dffea12','2025-03-31 02:26:13','debit','wallet','wallet','2025-03-31 02:26:13','2025-03-31 02:26:13'),(140,264,1,1691,'18be6c84-ed80-4400-84b0-240289d60c6d','2025-03-31 02:44:50','debit','wallet','wallet','2025-03-31 02:44:50','2025-03-31 02:44:50'),(141,265,1,753,'8ddf1df0-8a05-40ce-9908-df7d94f653a7','2025-03-31 02:46:12','debit','wallet','wallet','2025-03-31 02:46:12','2025-03-31 02:46:12'),(142,266,1,0,'112fbb33-0437-47bd-a3a8-b60be7664c62','2025-03-31 02:47:37','debit','wallet','wallet','2025-03-31 02:47:37','2025-03-31 02:47:37'),(143,267,1,1000,'9ecd267d-44bf-4eae-82ed-92e9d04f6963','2025-03-31 02:48:06','debit','wallet','wallet','2025-03-31 02:48:06','2025-03-31 02:48:06'),(144,268,1,1778,'46783faa-9890-464d-b6f7-13388a5ccac9','2025-03-31 03:02:28','debit','wallet','wallet','2025-03-31 03:02:28','2025-03-31 03:02:28'),(145,269,1,1506,'0313fe6c-9254-4c2e-9fa1-cef5311d57f8','2025-03-31 03:07:29','debit','wallet','wallet','2025-03-31 03:07:29','2025-03-31 03:07:29'),(146,270,1,1691,'9b10d978-f3b3-402d-a18a-34ed73a22dd5','2025-04-07 19:49:38','debit','wallet','wallet','2025-04-07 19:49:38','2025-04-07 19:49:38'),(147,271,1,0,'742e2cd4-7f6e-4b2c-8f5a-aea4096a9f68','2025-04-07 19:50:03','debit','wallet','wallet','2025-04-07 19:50:03','2025-04-07 19:50:03'),(148,272,1,923,'aa5b7dc1-1702-4ac8-b098-e00e06eabd2b','2025-04-07 19:50:47','debit','wallet','wallet','2025-04-07 19:50:47','2025-04-07 19:50:47'),(149,273,1,753,'9cba6b9c-2710-4c5a-8508-9f96fed1f608','2025-04-07 20:07:57','debit','wallet','wallet','2025-04-07 20:07:57','2025-04-07 20:07:57'),(150,274,1,0,'fc3b21a3-0480-4eff-9266-71a82369aca6','2025-04-07 20:09:48','debit','wallet','wallet','2025-04-07 20:09:48','2025-04-07 20:09:48'),(151,275,1,0,'ba90864a-b1c0-4437-b31c-26c274b31421','2025-04-07 20:10:33','debit','wallet','wallet','2025-04-07 20:10:33','2025-04-07 20:10:33'),(152,276,1,0,'a3715c51-3742-4f7a-86e2-ee084151fbde','2025-04-07 20:10:44','debit','wallet','wallet','2025-04-07 20:10:44','2025-04-07 20:10:44'),(153,277,1,0,'7cd97663-3c20-437c-9c50-35c56dfc294c','2025-04-16 20:50:04','debit','wallet','wallet','2025-04-16 20:50:04','2025-04-16 20:50:04'),(154,278,82,1830,'4abef61d-ba51-4190-a206-401aff454187','2025-04-16 20:50:31','debit','wallet','wallet','2025-04-16 20:50:31','2025-04-16 20:50:31'),(155,279,1,0,'547326d9-a7c0-40eb-9424-7bda98e0d1d8','2025-04-16 20:51:58','debit','wallet','wallet','2025-04-16 20:51:58','2025-04-16 20:51:58'),(156,280,82,753,'52fda3db-beaf-423d-b6d0-252e0e316fba','2025-04-16 20:55:20','debit','wallet','wallet','2025-04-16 20:55:20','2025-04-16 20:55:20'),(157,281,82,1583,'fce16cd4-e1f4-4724-a28b-fe266eeb6765','2025-04-16 20:56:13','debit','wallet','wallet','2025-04-16 20:56:13','2025-04-16 20:56:13'),(158,282,82,923,'85a6fe97-5073-4267-8d73-d1d2fd7945f7','2025-04-16 20:58:11','debit','wallet','wallet','2025-04-16 20:58:11','2025-04-16 20:58:11'),(159,283,82,923,'60b2cfcf-d59c-418e-876e-c9565fc43e18','2025-04-16 21:01:15','debit','wallet','wallet','2025-04-16 21:01:15','2025-04-16 21:01:15'),(160,284,82,1753,'b246662a-bc67-4bf4-8579-c5e181e57902','2025-04-16 21:23:36','debit','wallet','wallet','2025-04-16 21:23:36','2025-04-16 21:23:36'),(161,285,1,753,'f00aa0b2-46ae-4a8e-ae41-a130b398980d','2025-04-22 21:44:52','debit','wallet','wallet','2025-04-22 21:44:52','2025-04-22 21:44:52'),(162,286,1,0,'6938955e-4d00-41c2-a773-87062c16d02c','2025-04-22 21:45:12','debit','wallet','wallet','2025-04-22 21:45:12','2025-04-22 21:45:12'),(163,288,1,3750,'8cfea714-5a41-444f-b8e4-b061abaa19b4','2025-06-07 17:45:40','debit','wallet','wallet','2025-06-07 17:45:40','2025-06-07 17:45:40'),(164,289,1,0,'3d7bcd7e-3687-4ea1-ad9a-8b7235229ccb','2025-06-07 17:46:39','debit','wallet','wallet','2025-06-07 17:46:39','2025-06-07 17:46:39'),(165,292,1,0,'41b2c336-672f-48de-8041-f3ed4922f34d','2025-06-07 17:55:22','debit','wallet','wallet','2025-06-07 17:55:22','2025-06-07 17:55:22'),(166,293,1,3750,'164bd904-f6d0-4c52-b45b-41577a75e1cc','2025-06-07 18:01:07','debit','wallet','wallet','2025-06-07 18:01:07','2025-06-07 18:01:07'),(167,294,1,4000,'508b75d2-f2e7-4d67-89be-74b21e5a13f1','2025-06-07 18:10:35','debit','wallet','wallet','2025-06-07 18:10:35','2025-06-07 18:10:35'),(168,295,1,0,'ae9dbabe-f1c7-458a-828d-365dc8b05495','2025-06-07 18:17:38','debit','wallet','wallet','2025-06-07 18:17:38','2025-06-07 18:17:38'),(169,296,1,0,'acd66512-fd2f-4989-b598-406b2dc46d50','2025-06-07 18:18:45','debit','wallet','wallet','2025-06-07 18:18:45','2025-06-07 18:18:45'),(170,297,60,3600,'e0dba11d-1609-4571-b2fa-b769a0173ac0','2025-08-13 16:12:14','debit','wallet','wallet','2025-08-13 16:12:14','2025-08-13 16:12:14'),(171,298,86,5400,'20a96bc8-ae32-4659-8525-406e46c27382','2025-08-13 16:27:26','debit','wallet','wallet','2025-08-13 16:27:26','2025-08-13 16:27:26');
/*!40000 ALTER TABLE `transactions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `users` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `fullname` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `phone` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `cart` longtext COLLATE utf8mb4_unicode_ci,
  `balance` double NOT NULL DEFAULT '0',
  `status` tinyint(4) NOT NULL DEFAULT '1',
  `fcm_token` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `app_lang` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'en',
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `otp_code` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_verified` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`),
  UNIQUE KEY `users_uuid_unique` (`uuid`)
) ENGINE=InnoDB AUTO_INCREMENT=89 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` (`id`, `fullname`, `email`, `phone`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`, `cart`, `balance`, `status`, `fcm_token`, `app_lang`, `uuid`, `otp_code`, `is_verified`) VALUES (1,'Jarrod Logan','ibrahimsamy308@gmail.com','+1 (227) 291-8946',NULL,'$2y$10$6r8KuPObI51oQzRs0Y1CUuOaRIx992aZI.7YT8OxxeFELDB.bHj5C',NULL,'2025-02-12 09:07:54','2025-07-21 02:25:20','{\n    \"item_21ccb40510cba56bdfd11aecda4df4a5\": {\n        \"id\": 125,\n        \"title\": \"Royal Lavender Bouquet\",\n        \"quantity\": 1,\n        \"price\": 1800,\n        \"options\": []\n    },\n    \"item_1f4b90672241c201e6b2e1ea98809c3d\": {\n        \"id\": 126,\n        \"title\": \"package1\",\n        \"quantity\": 2,\n        \"price\": 100,\n        \"options\": []\n    }\n}',1000000,1,NULL,'en',NULL,NULL,1),(2,'Mohamed Ali','Kero@gmail.com','01126985910',NULL,'$2y$10$hHxAJVUenVtSkEGa9HcTIeqQ5eIdGhWnnc1mGuOWz9gwKF8LocnyO',NULL,'2025-02-12 09:07:54','2025-07-21 02:39:58','{\n    \"item_ec134cbdaa76fa23ba1429c3cf73d528\": {\n        \"id\": 122,\n        \"title\": \"Paradise flower bouquet\",\n        \"quantity\": 6,\n        \"price\": 2000,\n        \"options\": []\n    }\n}',1000000,1,NULL,'en',NULL,NULL,0),(3,'Britanney Norris','bylil@mailinator.com','+1 (312) 641-3189',NULL,'$2y$10$ZCt0ESZXKwn80BfVhdWnk.uo2F8OIJBJ.HJPK5Ncxf98HmD/.aLxW',NULL,'2025-02-12 09:08:49','2025-02-12 09:08:49','',1000000,1,NULL,'en',NULL,NULL,0),(4,'Murad','murad2025@gmail.com','01099999999',NULL,'$2y$10$XuozZYGChJ2SOLSoUxl5Q.uSnkP/PkPrWW8SOVKqHXVIkqZo1x292',NULL,'2025-02-12 09:36:39','2025-02-20 15:47:43','',1000000,1,NULL,'en',NULL,NULL,0),(5,'Boula Nessim','nessim@gmail.com','011267856767',NULL,'$2y$10$7dVx4ZoK4jLv3Dkh/zfAKe5XAgeBvmWUcj4xBbBrh7WOWq/Q4bIuG',NULL,'2025-02-12 20:21:02','2025-02-13 15:28:34','',1000000,1,NULL,'en',NULL,NULL,0),(6,'Boula','nessim88@gmail.com','011267859300',NULL,'$2y$10$S7k.bA5Ll4d3CUcwbjDJQemeuEIdPq.zJKLUrCvHmbTSkzHawj7YG',NULL,'2025-02-12 20:21:46','2025-02-16 13:13:08','',1000000,1,NULL,'en',NULL,NULL,0),(7,'Boula Nessim','nessimswboula2@gmail.com','011267859104',NULL,'$2y$10$mhprRAZCIOSkWhqONChr9OQfSCRzE2CNtiR.98lIn/9SmoDUuLTZy',NULL,'2025-02-12 21:13:49','2025-02-12 21:13:49','',1000000,1,NULL,'en',NULL,NULL,0),(8,'Boula Nessim','nessimswboula56@gmail.com','011267859104',NULL,'$2y$10$HlHm1QXsatjaSByScU947Ot1Y6u1FtjKESM9R.0FhSK0FHYYnajPu',NULL,'2025-02-13 07:39:18','2025-02-13 07:39:18','',1000000,1,NULL,'en',NULL,NULL,0),(9,'Boula Nessim','nessimswboula54@gmail.com','011267859104',NULL,'$2y$10$3HvM5DQQ0zI/M3qkkfTPsOAqu.eGPU6Tf4Woe6a.F5bY47PEfCGZK',NULL,'2025-02-13 08:11:29','2025-02-13 08:11:29','',1000000,1,NULL,'en',NULL,NULL,0),(10,'Boula Nessim','nessimswboula526@gmail.com','011267859104',NULL,'$2y$10$/Pr03uY6s2kfRBePychg4OkYJNxaz4SzZWiK2OI/TEaM/ltnRIB8S',NULL,'2025-02-13 08:19:56','2025-02-13 08:19:56','',1000000,1,NULL,'en',NULL,NULL,0),(11,'mohamed','m@m.com','01097981079',NULL,'$2y$10$wnKnN1SIi5Bn0jCRBnXi9uBEAanH0T2nK.YWIr2oR.9izDYGjEeJy',NULL,'2025-02-13 09:04:42','2025-02-18 19:30:36','',1000000,1,NULL,'en',NULL,NULL,0),(12,'uJcOnkKG','azexofukif519@gmail.com','9680327833',NULL,'$2y$10$wFvQFHISgVnT27mKgQieX.2Cgoq4y2LLn0Kk7ty.lj7ELKPsM1oK2',NULL,'2025-02-13 15:58:46','2025-02-13 15:58:46','',1000000,1,NULL,'en',NULL,NULL,0),(13,'omlTpuuCqbtmqzJ','movapuyusute55@gmail.com','2997298140',NULL,'$2y$10$BtbqRZVvJUU1KfJ033HmiOrU0GLtBUkUwrWgo4AKGWGV0Fgyhj.XO',NULL,'2025-02-14 19:29:33','2025-02-14 19:29:33','',1000000,1,NULL,'en',NULL,NULL,0),(14,'gqOxdfYKrQaV','abnarbaileyvz1996@gmail.com','9524172714',NULL,'$2y$10$2qiJIL68SU1BZIbbMIBdHOyXKfDD.B.sRTaWRwjMWIGgjPEFqPDUe',NULL,'2025-02-15 13:12:18','2025-02-15 13:12:18','',1000000,1,NULL,'en',NULL,NULL,0),(15,'jtHyWaQQmMjPn','ressijy@gmail.com','3474017478',NULL,'$2y$10$3V1hUQgyXJQHVv71MC8s1evi8lz5wq75QJ.M8NeL1qmeGyZAti0xO',NULL,'2025-02-16 05:15:29','2025-02-16 05:15:29','',1000000,1,NULL,'en',NULL,NULL,0),(16,'Timothy Mcknight','gujytyji@mailinator.com','+1 (709) 255-2302',NULL,'$2y$10$qWdyABW30SWcXKsfhrTcUuE3dfMDmp8.DJZsnVeLp4iYsdgYw0Ax.',NULL,'2025-02-16 16:53:27','2025-02-16 16:53:57','',1000000,1,NULL,'en',NULL,NULL,0),(17,'nLGJzIOPfhdAKm','hramirezmr66@gmail.com','6541053617',NULL,'$2y$10$IvXn5FollhZOB0e50Oy8oe8MdNmaT6xqtArUIytM.6jBktbWpaFYC',NULL,'2025-02-16 21:50:31','2025-02-16 21:50:31','',1000000,1,NULL,'en',NULL,NULL,0),(18,'FxijEPDowInOESw','sdunnu25@gmail.com','2118476475',NULL,'$2y$10$WklvIhlHiOUQwfpD0PChrOVTxu3EAU6mwZcmytDMcaF9uwwU2B1nC',NULL,'2025-02-17 16:56:08','2025-02-17 16:56:08','',1000000,1,NULL,'en',NULL,NULL,0),(19,'mohamed','a@a.com','01097981077',NULL,'$2y$10$dZ0ZYeExpuQyBDS/9.I1uuBhDXeULs3iw1TZvG7jx/T5LcCZxZbWW',NULL,'2025-02-19 13:54:50','2025-03-25 09:36:56','{\n    \"item_5ac79fd6d13d369e92b5e1494f1ff3a2\": {\n        \"id\": \"47-12c1s\",\n        \"title\": \"Men\'s Jacket\",\n        \"quantity\": 2,\n        \"price\": 75,\n        \"options\": {\n            \"image\": \"https:\\/\\/adc1.com.sa\\/images\\/1741783763_3-removebg-preview.png\",\n            \"color\": 12,\n            \"size\": 1,\n            \"variation_id\": 387,\n            \"colorTitle\": \"Black\",\n            \"sizeTitle\": \"Extra Small\",\n            \"offer_id\": null,\n            \"validOffer\": false\n        }\n    },\n    \"item_bf21fa7b294ab860f4e44a4acc61fb87\": {\n        \"id\": \"53-15c3s\",\n        \"title\": \"Denim Jacket\",\n        \"quantity\": 1,\n        \"price\": 55,\n        \"options\": {\n            \"image\": \"https:\\/\\/adc1.com.sa\\/images\\/1741813821_11-removebg-preview.png\",\n            \"color\": 15,\n            \"size\": 3,\n            \"variation_id\": 402,\n            \"colorTitle\": \"Blue\",\n            \"sizeTitle\": \"Medium\",\n            \"offer_id\": null,\n            \"validOffer\": false\n        }\n    }\n}',1000000,1,'cgL3RZaHTBuUuVzbWcGBEk:APA91bG5inUE_9vjRXS5-GQSXbGc4Q2r42jLFJ1_anYsIzdFKZdMfzoAzYhh2RLmQYnvT1x0ERpcPu5t4jDRqSLw5blJBlkzVetSHYirfBw3sxKsmp1PE-I','ar',NULL,NULL,0),(20,'Mohamed Ali','a1@aa.com','0109012831',NULL,'$2y$10$0GSQERIQC2KyT.P37HnNW.P1fy.DeKNvl3XGUwO9QjT33uvTJJr5m',NULL,'2025-02-19 13:59:19','2025-03-05 09:38:45','{\n    \"item_911a24337cc7c07ffa7f2efa1c3074d0\": {\n        \"id\": \"11-2c10s\",\n        \"title\": \"\\u0627\\u0644\\u0647\\u0648\\u062f\\u064a \\u0627\\u0644\\u0623\\u0648\\u0641\\u0631 \\u0633\\u0627\\u064a\\u0632\",\n        \"quantity\": 1,\n        \"price\": 100,\n        \"options\": {\n            \"image\": \"https:\\/\\/adc1.com.sa\\/default.jpg\",\n            \"color\": 2,\n            \"size\": 10,\n            \"colorTitle\": \"\\u0623\\u0632\\u0631\\u0642\",\n            \"sizeTitle\": \"\\u0645\\u0642\\u0627\\u0633 \\u0643\\u0628\\u064a\\u0631\"\n        }\n    },\n    \"item_85e6b2c7ef6d426a1ac443365b2c9094\": {\n        \"id\": \"17-12c11s\",\n        \"title\": \"\\u0628\\u0646\\u0637\\u0644\\u0648\\u0646 \\u0643\\u0627\\u0631\\u062c\\u0648 \\u0631\\u064a\\u0627\\u0636\\u064a \\u0631\\u062c\\u0627\\u0644\\u064a\",\n        \"quantity\": 1,\n        \"price\": 121,\n        \"options\": {\n            \"image\": \"https:\\/\\/adc1.com.sa\\/images\\/1739918928_e376aef7c23443df26dd9c95e20024a1.jpg\",\n            \"color\": 12,\n            \"size\": 11,\n            \"colorTitle\": \"\\u0623\\u0633\\u0648\\u062f\",\n            \"sizeTitle\": \"\\u0645\\u062a\\u0648\\u0633\\u0637\"\n        }\n    }\n}',1000000,3,'c9Cj9ndSSwub6uy7BJiarO:APA91bGZHnUO3lgeWQ4gMBVWQUdoPP1ZW0rgNtKZG-iiS5-yqc_EjSN-kc1xQNrgw2MKEDIAJCv9PiHbBHmk0eKe2FjHI_fKCccwpebm59RSz78-88YnYFc','ar',NULL,NULL,0),(21,'Hossny','hossny@gmail','/*/*/*%#^%^$',NULL,'$2y$10$b/qBj/amm8VBFq6D5IT6hOPXoRAeNvlp0UuPC70DLWSiWRGwJSGq2',NULL,'2025-02-19 19:38:38','2025-02-22 11:23:18','',1000000,1,NULL,'en',NULL,NULL,0),(22,'oeYdiMMllGUIBo','costaris67@gmail.com','6497385201',NULL,'$2y$10$A1xVosBVG2ZOep1NZDzFsum9wYnjWgmoVZm2QG0uJocCfdDTO720S',NULL,'2025-02-20 07:27:29','2025-02-20 07:27:29','',1000000,1,NULL,'en',NULL,NULL,0),(23,'byhbUvNlvgczP','ezowupebuh84@gmail.com','5207464792',NULL,'$2y$10$YaTyJ0u8FvILsr0UVJ6u.eEERrbSEMXuvveAHLS/qvyctiTV6HPga',NULL,'2025-02-21 06:43:58','2025-02-21 06:43:58','',1000000,1,NULL,'en',NULL,NULL,0),(24,'UasxjRYJ','griirhenryfu1982@gmail.com','9243603142',NULL,'$2y$10$78DOLOwPlJIL7Up2HIPAiODrKwx2Vxxl5veVqK.Vd0EJlf2Qh/YUy',NULL,'2025-02-21 12:24:48','2025-02-21 12:24:48','',1000000,1,NULL,'en',NULL,NULL,0),(25,'test payment','testpayment@gmail.com','503898789',NULL,'$2y$10$T.YKbYHP4Fu6cH2xEBS26ei.uzX0BDmgPVZFjrwg60ZYwAI4Qoc.u',NULL,'2025-02-22 09:55:51','2025-02-26 13:32:04','{\n    \"item_7fdcc83e1f0ac5e0391ceed32331dbf7\": {\n        \"id\": \"31-18c11s\",\n        \"title\": \"Maroon Baseball Cap with New York Yankees Logo\",\n        \"quantity\": 1,\n        \"price\": 100,\n        \"options\": {\n            \"image\": \"https:\\/\\/adc1.com.sa\\/images\\/1740319329_744a9656a70e7342c83ddd012276c019.jpg\",\n            \"color\": \"18\",\n            \"size\": \"11\",\n            \"colorTitle\": \"Pink\",\n            \"sizeTitle\": \"Medium\"\n        }\n    },\n    \"item_1c02475dda94d229c27154daee99f3d4\": {\n        \"id\": \"31-11c12s\",\n        \"title\": \"Maroon Baseball Cap with New York Yankees Logo\",\n        \"quantity\": 1,\n        \"price\": 100,\n        \"options\": {\n            \"image\": \"https:\\/\\/adc1.com.sa\\/images\\/1740319329_636fdbce41ac9bb383dbf721a92d7e6b.jpg\",\n            \"color\": \"11\",\n            \"size\": \"12\",\n            \"colorTitle\": \"Green\",\n            \"sizeTitle\": \"Small\"\n        }\n    }\n}',1000000,1,NULL,'en',NULL,NULL,0),(26,'MohamedHossny','hossny1@gmail.com','01000000008',NULL,'$2y$10$w.Cj.LhtN9QAqjXvJv7.R.Nz5EUAwxZU3wpMnobqd.XVtSXjwQ2tO',NULL,'2025-02-22 12:25:52','2025-03-24 16:58:38','[]',1000000,1,'e_S8iQuuSR6h1im_KmwE8p:APA91bG_aKjOqwG_p5gnnFmrM4L-MkR3jd6WF0HlrszYQkOxdNZYcrvi7PZyB0xnekbidfv3l4Ap8sp65YHn3104zlRRbmpFiisuKoclWiUxfiAxC5wA44A','ar',NULL,NULL,0),(27,'Chastity Gonzalez','wikevalyn@mailinator.com','+1 (571) 123-6007',NULL,'$2y$10$MYlRfN9MdErp6mKR0Hy07.B.VAFQerMXltbE95jcFkTb58q/MXqey',NULL,'2025-02-22 13:25:03','2025-02-22 20:30:50','{\n    \"item_f380fc2ef7302e24fb80bb94ac92f2f3\": {\n        \"id\": \"27-1215\",\n        \"title\": \"Elegant Black Tuxedo\",\n        \"quantity\": 3,\n        \"price\": 1000,\n        \"options\": {\n            \"image\": \"https:\\/\\/adc1.com.sa\\/default.jpg\",\n            \"color\": \"12\",\n            \"size\": \"15\",\n            \"colorTitle\": \"Black\",\n            \"sizeTitle\": \"3X-Large\"\n        }\n    }\n}',1000000,1,NULL,'en',NULL,NULL,0),(28,'Alhanouf','Alhanoufi@outlook.sa','0555885203',NULL,'$2y$10$PLlUkPovQg5HtPlNtgWxBOVXTtk4jM62VSjEghtTF9j1xMdbZz3Ki',NULL,'2025-02-23 09:24:54','2025-02-23 09:24:54',NULL,1000000,1,NULL,'en',NULL,NULL,0),(29,'Violet Chambers','fitydase@mailinator.com','+1 (616) 879-1422',NULL,'$2y$10$QOLRuL4dMCpZUrKGBR3PgOmpaCW7czTSR6YJmJK1h7kTicIUmBj1q',NULL,'2025-02-23 11:44:18','2025-02-23 12:46:53','{\n    \"item_554cc5e92545e0a14237328579b1e070\": {\n        \"id\": \"26-12c14s\",\n        \"title\": \"Classic Baseball Cap\",\n        \"quantity\": 1,\n        \"price\": 300,\n        \"options\": {\n            \"image\": \"https:\\/\\/adc1.com.sa\\/images\\/1740240995_8e390e3280ea31a61d4b26e73c24614c.jpg\",\n            \"color\": \"12\",\n            \"size\": \"14\",\n            \"colorTitle\": \"Black\",\n            \"sizeTitle\": \"X-large\"\n        }\n    },\n    \"item_5db3fb690c8d60b12a8a92f35256edb1\": {\n        \"id\": \"26-12c11s\",\n        \"title\": \"Classic Baseball Cap\",\n        \"quantity\": 1,\n        \"price\": 250,\n        \"options\": {\n            \"image\": \"https:\\/\\/adc1.com.sa\\/images\\/1740240995_f58cf7a435fac53dc8788a38f49a30ea.jpg\",\n            \"color\": \"12\",\n            \"size\": \"11\",\n            \"colorTitle\": \"Black\",\n            \"sizeTitle\": \"Medium\"\n        }\n    },\n    \"item_c051244d68e8d1c8fe5bf1fb7e490155\": {\n        \"id\": \"26-11c14s\",\n        \"title\": \"Classic Baseball Cap\",\n        \"quantity\": 1,\n        \"price\": 300,\n        \"options\": {\n            \"image\": \"https:\\/\\/adc1.com.sa\\/images\\/1740240995_507b2c5dac6ab1b9faf52df71f4268f0.jpg\",\n            \"color\": \"11\",\n            \"size\": \"14\",\n            \"colorTitle\": \"Green\",\n            \"sizeTitle\": \"X-large\"\n        }\n    },\n    \"item_1373b3eb6f26465b9ae066f840fd6978\": {\n        \"id\": \"26-13c11s\",\n        \"title\": \"Classic Baseball Cap\",\n        \"quantity\": 10,\n        \"price\": 250,\n        \"options\": {\n            \"image\": \"https:\\/\\/adc1.com.sa\\/images\\/1740240995_939a45988f1e17e50b03fe9b8100f19c.jpg\",\n            \"color\": \"13\",\n            \"size\": \"11\",\n            \"colorTitle\": \"Gray\",\n            \"sizeTitle\": \"Medium\"\n        }\n    }\n}',1000000,1,NULL,'en',NULL,NULL,0),(30,'Mohamed','a@aaa.com','01097981079',NULL,'$2y$10$8BnfPWABxIdki02dyeDNsOX8uXVXtYIP.Yzufrkl4oymtDXGFoZeu',NULL,'2025-02-23 16:24:07','2025-02-26 15:23:53','{\n    \"item_911a24337cc7c07ffa7f2efa1c3074d0\": {\n        \"id\": \"11-2c10s\",\n        \"title\": \"\\u0627\\u0644\\u0647\\u0648\\u062f\\u064a \\u0627\\u0644\\u0623\\u0648\\u0641\\u0631 \\u0633\\u0627\\u064a\\u0632\",\n        \"quantity\": 1,\n        \"price\": 100,\n        \"options\": {\n            \"image\": \"https:\\/\\/adc1.com.sa\\/default.jpg\",\n            \"color\": 2,\n            \"size\": 10,\n            \"colorTitle\": \"\\u0623\\u0632\\u0631\\u0642\",\n            \"sizeTitle\": \"\\u0645\\u0642\\u0627\\u0633 \\u0643\\u0628\\u064a\\u0631\"\n        }\n    }\n}',1000000,1,'fV-yTQ7NQHShfYNgzt1-oT:APA91bHfr64zTCKCHBthyesA2HUhtxbwDc-2XKeslfuwLYLbM6k2OwASB-E1XC7f1Le2Emxmrd1i8fQptcDKEkMnreao6RVE6l8mmzvAnFWGpfuboin7sxE','en',NULL,NULL,0),(31,'mohamed','aa@aa.com','0109898113',NULL,'$2y$10$8lL/Kyk3mcnQb4/KPR9ACuKAIS195KPPl4nzq/HpSV091JrZPdhWK',NULL,'2025-02-23 16:31:12','2025-03-04 12:14:54','{\n    \"item_911a24337cc7c07ffa7f2efa1c3074d0\": {\n        \"id\": \"11-2c10s\",\n        \"title\": \"\\u0627\\u0644\\u0647\\u0648\\u062f\\u064a \\u0627\\u0644\\u0623\\u0648\\u0641\\u0631 \\u0633\\u0627\\u064a\\u0632\",\n        \"quantity\": 1,\n        \"price\": 100,\n        \"options\": {\n            \"image\": \"https:\\/\\/adc1.com.sa\\/default.jpg\",\n            \"color\": 2,\n            \"size\": 10,\n            \"colorTitle\": \"\\u0623\\u0632\\u0631\\u0642\",\n            \"sizeTitle\": \"\\u0645\\u0642\\u0627\\u0633 \\u0643\\u0628\\u064a\\u0631\"\n        }\n    }\n}',1000000,1,'diH8NJmOSXe5nDecoWS982:APA91bGlYeusE0c6zeAK4PCsGmvRkguLhw8m6bLCOibK-XDDMTQZ4QDwi3owoYAFPAVIxWzpfdz4aqrH2aDRYQ3auwX1mnRoHI8zi1UysOcbo0wpzOci5c4','ar',NULL,NULL,0),(32,'mohamed','aa@al.com','010912038',NULL,'$2y$10$Y2BAms1UciPwg5OWyfz/AOiebnxaVQRtxJ92h2q6Jcwh2U7pzJM9G',NULL,'2025-02-23 17:16:39','2025-02-23 18:49:21','{\n    \"item_911a24337cc7c07ffa7f2efa1c3074d0\": {\n        \"id\": \"11-2c10s\",\n        \"title\": \"\\u0627\\u0644\\u0647\\u0648\\u062f\\u064a \\u0627\\u0644\\u0623\\u0648\\u0641\\u0631 \\u0633\\u0627\\u064a\\u0632\",\n        \"quantity\": 1,\n        \"price\": 100,\n        \"options\": {\n            \"image\": \"https:\\/\\/adc1.com.sa\\/default.jpg\",\n            \"color\": 2,\n            \"size\": 10,\n            \"colorTitle\": \"\\u0623\\u0632\\u0631\\u0642\",\n            \"sizeTitle\": \"\\u0645\\u0642\\u0627\\u0633 \\u0643\\u0628\\u064a\\u0631\"\n        }\n    },\n    \"item_10dbf1e42d675442b742aba0979f6b1c\": {\n        \"id\": \"1-7c1s\",\n        \"title\": \"\\u0642\\u0645\\u064a\\u0635 \\u0643\\u0644\\u0627\\u0633\\u064a\\u0643\\u064a \\u0644\\u0644\\u0631\\u062c\\u0627\\u0644\",\n        \"quantity\": 1,\n        \"price\": 355,\n        \"options\": {\n            \"image\": \"https:\\/\\/adc1.com.sa\\/default.jpg\",\n            \"color\": 7,\n            \"size\": 1,\n            \"colorTitle\": \"\\u0623\\u0631\\u062c\\u0648\\u0627\\u0646\\u064a\",\n            \"sizeTitle\": \"\\u0635\\u063a\\u064a\\u0631 \\u062c\\u062f\\u064b\\u0627\"\n        }\n    }\n}',1000000,1,'fGAhBWa7AEqrthLqH8oI15:APA91bHYLc5ly_n3yxizO6EDtCXaNRiqEV_F5MOK58ysqrBT_isi2vc4JRugn4Pa8RR0R2Mn6B81LXEif6ymJi8agN0bZJnzwFQF3E4fo5ZleZfYzCe2HUc','ar',NULL,NULL,0),(33,'mohamed Mabrouk','m.mabrouk@aloo.com.sa','503998427',NULL,'$2y$10$WPXdmsd3v6vaS5/obKhrGOXFcfTKwiwQc8.SIiectIpXyINf1vIZm',NULL,'2025-02-24 10:05:38','2025-02-24 10:56:53',NULL,1000000,1,'eNTQiKr1bkrugvgSyqbA6A:APA91bE5moMNLuNRjBwIBm5PtlTzisl2Sj9bNxpctZ5zyvtYxfv1KILfCDeTim7Wuv8k1Pac5TQI7czZecRvZJf3XDVFozzKkb_rEvZO0cG3PLmviWy2cWA','ar',NULL,NULL,0),(34,'Mohamed','a@b.com','01097981079',NULL,'$2y$10$WWDUVASYwkpTWIaDJqQ9reAexUMTVmesSyIQH9knCqLVPukvUBtea',NULL,'2025-02-24 10:11:22','2025-02-25 17:53:49',NULL,1000000,1,'czM3kU7tek9vuhZimzUeg_:APA91bHTXzK6XYEuwdH6gVDC6uXEyfAsVNpWDKLzQ99UFg3gdEOyMmf9HYMT6mQnzvxhFa9ctjkJIK3zBNL1VH42m98lW8bTtA75MXK3MllRL-Gd-AnhB4s','ar',NULL,NULL,0),(35,'Ahmed Abdelrahman','ahmedabdelrahman0191@gmail.com','0598058741',NULL,'$2y$10$sY4lsiYDtjnZ4FeyN3nGluf822QwPa2PlkXTvZR2JTtZkphLXxE82',NULL,'2025-02-24 11:01:43','2025-03-12 18:05:19','[]',1000000,1,'ecH8LZFsj0Xdlp6iovrjT7:APA91bEkM2aMGtAp-hgPewTaykNox3Be4uJkWiRoQhcfK75slIvLw5jxW65TupWQFxn81N75Kuu_2wzlyX2uMUCZdMMAAC7MlY0HPp2Og3LrNZibmPkm35E','en',NULL,NULL,0),(36,'mohamed','mohamed@gmail.com','0199999999',NULL,'$2y$10$6Mwbz8uZTIbDP2hDVZnOu.9DzDj0z/NKJHuQ2RlsmxCmMIOWGlyie',NULL,'2025-02-24 18:26:21','2025-03-05 11:44:11','[]',1000000,3,'cPvU7qAvqkXStyG9yVHWeJ:APA91bEGF91LbJci92MAzUYS-4rdeWrF0Woksji4hXuKjcNkV8Vh1W20mFbeRE-nmGWGMUNqUwbTPV5AuFZUj-bUD2106UDfhFl89FkHWKgDDLZtVy_SvEw','ar',NULL,NULL,0),(37,'Alhanouf','Alhanoufi@outloo.sa','0555885203',NULL,'$2y$10$vAhEaUrWNI9haCzwZfezuuHZMfjIVmsfkwvjsg.fq4WNikWwY.s2C',NULL,'2025-02-26 07:25:09','2025-02-26 07:25:09',NULL,1000000,1,'cwjqXemoIUyTv9E0TXmf7S:APA91bErSXRXoLpV4lVe-FOZabTPhHrbtmAUJOIE6dJ2kQI-XVolpMpYv70CRQc3ihlZLQ8x4evqI0TXxyQgrGAuprWW3n8wN6M6PUyrmIqSvD01OGQuaHE','ar',NULL,NULL,0),(38,'Faizan Qureshi','loverboy22faizan@gmail.com','9259777294',NULL,'$2y$10$iUc4UvKXOKjvtEgCtW5mpujrmYBCdotVICltvNn4AOeI6fX5uqVM.',NULL,'2025-02-26 08:28:54','2025-02-26 08:28:54',NULL,1000000,1,'dRY_t3Qp3UQch1Vx54nkTh:APA91bEsl3KijzmgJLJPU0Mn-HAfBiXPD9rfpI6cTW0V3xHi9yzkT-aEYSaHDifVo1fSIy8x5z6CeDK_bO5Ibx1qX6UW2rAcxGV134LH2r9oCfh4LnuXFfo','en',NULL,NULL,0),(39,'Macaulay Morton','hawuwi@mailinator.com','+1 (384) 589-4674',NULL,'$2y$10$OzABK0MjHxlb8uAb9YQnoOOe5cBBYUrXOVDiXixiU5/h4HWaHTTGG',NULL,'2025-02-26 11:10:53','2025-02-26 11:11:45','{\n    \"item_37031a520bc4d491584d6867cdcf9a6c\": {\n        \"id\": \"32-12c14s\",\n        \"title\": \"New York NY Baseball & Snapback Hat For Unisex\",\n        \"quantity\": 1,\n        \"price\": 1000,\n        \"options\": {\n            \"image\": \"https:\\/\\/adc1.com.sa\\/default.jpg\",\n            \"color\": \"12\",\n            \"size\": \"14\",\n            \"colorTitle\": \"Black\",\n            \"sizeTitle\": \"X-large\"\n        }\n    }\n}',1000000,1,NULL,'en',NULL,NULL,0),(40,'Magee Whitehead','juli@mailinator.com','+1 (755) 157-7411',NULL,'$2y$10$WpBD3OIbtvof5L0E5qzoKueLD84/4kA8uVBi0jP.FJHjCQslrunRy',NULL,'2025-02-26 11:33:27','2025-02-26 11:33:27',NULL,1000000,1,NULL,'en',NULL,NULL,0),(41,'Megan Patel','vohevugiru@mailinator.com','+1 (204) 843-8466',NULL,'$2y$10$8kOgm9rlWFTOTkCJGU.5Mu2nm.80bk/ItN7AKi0kunsy1J7vuT1TC',NULL,'2025-02-26 11:38:07','2025-02-26 11:38:07',NULL,1000000,1,NULL,'en',NULL,NULL,0),(42,'Rhona Walton','joxuciby@mailinator.com','+1 (304) 349-9415',NULL,'$2y$10$lff1wxP.kUGPrEH7670PB.s/RfMTs9h9WwIyvu1dAD/lob6ixj9CC',NULL,'2025-02-26 11:38:25','2025-02-26 11:38:25',NULL,1000000,1,NULL,'en',NULL,NULL,0),(43,'Natalie Garcia','cypibiro@mailinator.com','+1 (124) 328-1919',NULL,'$2y$10$AP6prtrlpJPeYyoBGgSMluUsSW0.pfu0TdxBKG.hI0cR7Kmc7jorm',NULL,'2025-02-27 10:03:03','2025-02-27 10:03:03',NULL,1000000,1,NULL,'en',NULL,NULL,0),(44,'Abraham Burns','ziqosecamu@mailinator.com','+1 (597) 882-3496',NULL,'$2y$10$GSXRCdnNomY5NVyFXrD6xeMDUKrpssBb6fpMfdSn5yg.hMWJQUMXy',NULL,'2025-02-27 10:04:49','2025-02-27 10:46:09','[]',1000000,1,NULL,'en',NULL,NULL,0),(45,'Дмитрий','plusnind78@mail.ru','79024720997',NULL,'$2y$10$Ljnn/l3Glo/1YsfO8iZqHO0XyFidCEu48TwkprHp62ZPKsrotiTKu',NULL,'2025-02-28 17:59:00','2025-02-28 17:59:00',NULL,1000000,1,'f_EfBuJM5EmguaigR04rnM:APA91bEovd3-BFCjzLc7ankYg7yg0su7dAheor7j_NCC8HWhfT2IY6S6YOjqmZFTyqjsO8tFp7P93DdxDrGnMIHjjylgOn4GKWYzciiFXHGUaS0iUOjMSo0','en',NULL,NULL,0),(46,'Priyanka John','priyankajon6@gmail.com','447909149143',NULL,'$2y$10$5FU0Kxhae./KGyHBo35S5uf2TrkOllF/YlSvEirjr0DuaXuvh9OWa',NULL,'2025-02-28 22:07:07','2025-02-28 22:07:07',NULL,1000000,1,'cxktZxPwb0w1rMjhdn0125:APA91bHTLt9rOZ_clhKaS0Z5RyQ9laIRT-n6uw-eHpVWNeqtcj5Ky48XuNMZ7EG9YY53RpVm1UVy-oy2ItUA7aHcybQEXe1ZlVlP5oZ7wP8Tc7-1RuvPH8o','en',NULL,NULL,0),(47,'Mohamed Ali','moodamasy@gmail.com','0503998427',NULL,'$2y$10$Pno3gWSxSvJJCZprEsbyx.tPdj6j3BVNYgh4ek.3fyUTkTEB.Z52K',NULL,'2025-03-01 08:35:59','2025-03-01 08:35:59',NULL,1000000,1,NULL,'en',NULL,NULL,0),(48,'عبدالعزيز','az269355@gmail.com','0530409919',NULL,'$2y$10$3hsO8CmzCiUB3mOuzSqSXexQK/m.YyIaff86dYBbrRW.JkGhnvu0O',NULL,'2025-03-01 18:43:57','2025-03-01 18:44:53',NULL,1000000,3,'fWnKuZWTRkqcg3M9S9QLBx:APA91bFg6JsqAS0fhYop3L28b8WSnfHCNzeNd37j8otHvEBfzKJGL6DVy2ZgJTuTDBz6u1w0n7QJWNozCwFRiVH48EPg7Ydtjvpd9VYoubD-BAcvAymBmPk','ar',NULL,NULL,0),(49,'Mohamed','mohamed1@gmail.com','000000000000000000000000000',NULL,'$2y$10$EnQZajetlr9G4K1JBHW9Su0HgnmxEGQvm7L2MickwqYvzv.d5qvX2',NULL,'2025-03-02 22:31:14','2025-03-02 23:47:47',NULL,1000000,3,'cPvU7qAvqkXStyG9yVHWeJ:APA91bEGF91LbJci92MAzUYS-4rdeWrF0Woksji4hXuKjcNkV8Vh1W20mFbeRE-nmGWGMUNqUwbTPV5AuFZUj-bUD2106UDfhFl89FkHWKgDDLZtVy_SvEw','en',NULL,NULL,0),(50,'Kermit Case','kutevuqac@mailinator.com','+1 (747) 377-3315',NULL,'$2y$10$NGwbjiFkotCL.zBIB4CSzeYc4V7iw5OFyAwGvHvaNhPqJ/xXPt4Zi',NULL,'2025-03-03 10:28:21','2025-03-03 10:39:49','[]',1000000,1,NULL,'en',NULL,NULL,0),(51,'KHALID','khalid@gmail.com','00000000000000000000000',NULL,'$2y$10$2xuj5b.9pBXF2ysDlSz9/e3fuMoVlB/dTYOORJ5WVtfbwFQ/JYmj2',NULL,'2025-03-03 15:31:07','2025-03-03 15:31:07',NULL,1000000,1,'cPvU7qAvqkXStyG9yVHWeJ:APA91bEGF91LbJci92MAzUYS-4rdeWrF0Woksji4hXuKjcNkV8Vh1W20mFbeRE-nmGWGMUNqUwbTPV5AuFZUj-bUD2106UDfhFl89FkHWKgDDLZtVy_SvEw','en',NULL,NULL,0),(52,NULL,NULL,NULL,NULL,NULL,NULL,'2025-03-05 09:13:16','2025-03-05 09:13:16',NULL,1000000,1,'yyyyyyyyyyyyyyyyyyyyyyyyyyy','en','fffffffffffffffffffffffffff',NULL,0),(53,'Mohamed Ali','ali@gmial.com',NULL,NULL,NULL,NULL,'2025-03-05 09:14:38','2025-03-05 09:14:38',NULL,1000000,1,'jjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjj','en','yyyyyyyyyyyyyyyyyyyyyyyyyyyyyy',NULL,0),(54,'Lulu','Lulu.Almawash@gmail.com','0559013397',NULL,'$2y$10$QERQvrWfH6ApoISZZDTVtOYzOUlcB2feyErabPijMTvSGHnHd4WFy',NULL,'2025-03-05 10:16:43','2025-03-13 19:59:30','{\n    \"item_911a24337cc7c07ffa7f2efa1c3074d0\": {\n        \"id\": \"11-2c10s\",\n        \"title\": \"\\u0627\\u0644\\u0647\\u0648\\u062f\\u064a \\u0627\\u0644\\u0623\\u0648\\u0641\\u0631 \\u0633\\u0627\\u064a\\u0632\",\n        \"quantity\": 1,\n        \"price\": 100,\n        \"options\": {\n            \"image\": \"https:\\/\\/adc1.com.sa\\/default.jpg\",\n            \"color\": 2,\n            \"size\": 10,\n            \"colorTitle\": \"\\u0623\\u0632\\u0631\\u0642\",\n            \"sizeTitle\": \"\\u0645\\u0642\\u0627\\u0633 \\u0643\\u0628\\u064a\\u0631\"\n        }\n    }\n}',1000000,1,'cW7zIMLmKka5q0VJVTYYRU:APA91bE_r5SwNhxoIquRMTmuVcvBfk1G2pHRxmDtbU7fpXw4P2G6KhpOKcrJiaeceQPqIU5AiJJHtgVVUlOGtIERRZp7l-RuyajkGJhrvGut_vu7JuHH910','ar',NULL,NULL,0),(55,'Mohamed','mohamed10@gmail.com','01250607080',NULL,'$2y$10$GiFPnwurLsz1iJrB6Up8TusSf.yy2bribcNVR2gTZYaKLPHzew73S',NULL,'2025-03-05 10:20:51','2025-03-05 17:08:42','{\n    \"item_53734bbfe3cb06367bc3b9d133f09f14\": {\n        \"id\": \"38-16c11s\",\n        \"title\": \"Warm Poncho Blanket with Hood - Cozy & Stylish Design\",\n        \"quantity\": 1,\n        \"price\": 500,\n        \"options\": {\n            \"image\": \"https:\\/\\/adc1.com.sa\\/images\\/1741185190_81rCtf6w-UL._AC_SX569_.jpg\",\n            \"color\": \"16\",\n            \"size\": \"11\",\n            \"variation_id\": 197,\n            \"colorTitle\": \"White\",\n            \"sizeTitle\": \"Medium\",\n            \"offer_id\": 30,\n            \"validOffer\": false\n        }\n    },\n    \"item_4175ea0c2389e009adb16fba1941853a\": {\n        \"id\": \"38-11c11s\",\n        \"title\": \"Warm Poncho Blanket with Hood - Cozy & Stylish Design\",\n        \"quantity\": 1,\n        \"price\": 500,\n        \"options\": {\n            \"image\": \"https:\\/\\/adc1.com.sa\\/images\\/1741185190_81gYQ6wJNSL._AC_SX569_.jpg\",\n            \"color\": \"11\",\n            \"size\": \"11\",\n            \"variation_id\": 198,\n            \"colorTitle\": \"Green\",\n            \"sizeTitle\": \"Medium\",\n            \"offer_id\": 30,\n            \"validOffer\": false\n        }\n    }\n}',1000000,1,NULL,'en',NULL,NULL,0),(56,'Mohamed','mohamedfgh@gmail.com','0551252552',NULL,'$2y$10$lL7dFTrLb9Fww.IM2MBoqevfpM/4/Xqy95.cHIivOAWGsuJNAaPdm',NULL,'2025-03-05 12:15:40','2025-03-05 12:17:33',NULL,1000000,3,'cPvU7qAvqkXStyG9yVHWeJ:APA91bEGF91LbJci92MAzUYS-4rdeWrF0Woksji4hXuKjcNkV8Vh1W20mFbeRE-nmGWGMUNqUwbTPV5AuFZUj-bUD2106UDfhFl89FkHWKgDDLZtVy_SvEw','ar',NULL,NULL,0),(57,'murad','murad.1@gmail.com','0551252552',NULL,'$2y$10$RvYsgeIZUcSWAKPII7dNX.CE1ng1B3vbOMQNVPoAnpa3c8FJI63te',NULL,'2025-03-05 12:19:02','2025-03-05 12:19:02',NULL,1000000,1,'cPvU7qAvqkXStyG9yVHWeJ:APA91bEGF91LbJci92MAzUYS-4rdeWrF0Woksji4hXuKjcNkV8Vh1W20mFbeRE-nmGWGMUNqUwbTPV5AuFZUj-bUD2106UDfhFl89FkHWKgDDLZtVy_SvEw','ar',NULL,NULL,0),(58,'khalil','khalil@gmail.com','0551252552',NULL,'$2y$10$2UXAXYv.XRexuBem9Wxpje1/BA5BHnmmvVVeMJLkTBfH8xU0DQoSu',NULL,'2025-03-05 12:19:52','2025-03-05 12:19:52',NULL,1000000,1,'cPvU7qAvqkXStyG9yVHWeJ:APA91bEGF91LbJci92MAzUYS-4rdeWrF0Woksji4hXuKjcNkV8Vh1W20mFbeRE-nmGWGMUNqUwbTPV5AuFZUj-bUD2106UDfhFl89FkHWKgDDLZtVy_SvEw','ar',NULL,NULL,0),(59,'fady','fady@gmail.com','0524415568',NULL,'$2y$10$FBQ0s.FohRIEqTobb9qVmOPDEhubWvHP6WFa7gckaseE/FUpNEeYy',NULL,'2025-03-05 12:38:22','2025-03-06 14:22:57',NULL,1000000,1,'cPvU7qAvqkXStyG9yVHWeJ:APA91bEGF91LbJci92MAzUYS-4rdeWrF0Woksji4hXuKjcNkV8Vh1W20mFbeRE-nmGWGMUNqUwbTPV5AuFZUj-bUD2106UDfhFl89FkHWKgDDLZtVy_SvEw','en',NULL,NULL,0),(60,'Boula','nessimboula@gmail.com','966555544484',NULL,'$2y$10$UE2pOy9WDybNwQxNP3AGluUdlhAXZ56DGjyrzf4yJz3fPuPPZraUO','bRKiqTKZ9gCT4qQqB1VO4O0V6TVh7rHc0hBbLNexzO7RyjfvjNI3GaEimaa2','2025-03-06 13:54:21','2025-08-29 20:51:31','{\n    \"item_7ebf19d45dc457d53951d29cd00261ad\": {\n        \"id\": 1,\n        \"title\": \"\\u0648\\u0631\\u0648\\u062f \\u062d\\u0645\\u0631\\u0627\\u0621 \\u0631\\u0648\\u0645\\u0627\\u0646\\u0633\\u064a\\u0629\",\n        \"quantity\": 1,\n        \"price\": 1150,\n        \"options\": []\n    },\n    \"item_77ee7581f74d9a3b153b3e368731eea7\": {\n        \"id\": 9,\n        \"title\": \"\\u0645\\u062c\\u0645\\u0648\\u0639\\u0629 \\u0627\\u0644\\u0642\\u0631\\u0646\\u0641\\u0644 \\u0627\\u0644\\u0643\\u0644\\u0627\\u0633\\u064a\\u0643\\u064a\\u0629\",\n        \"quantity\": 1,\n        \"price\": 943,\n        \"options\": []\n    },\n    \"item_cd629212308b9fdd58b20a3e41a24205\": {\n        \"id\": 45,\n        \"title\": \"\\u0627\\u0633\\u062a\\u0645\\u0631 \\u0641\\u064a \\u0627\\u0644\\u062a\\u0623\\u0644\\u0642\",\n        \"quantity\": 3,\n        \"price\": 2000,\n        \"options\": []\n    }\n}',996400,1,NULL,'en',NULL,NULL,0),(61,'manar','Losy.95@icloud.com','504866761',NULL,'$2y$10$9TDzKJhSDAdqBNNtnytHpeWPJukBB21QYGK2eU7hbN6kxGJT0/7Iq',NULL,'2025-03-08 17:10:23','2025-03-08 17:10:23',NULL,1000000,1,'enx6F8yYu0aDtivLXXjZHr:APA91bFiCifTW2X4ucFWr8iyf7UzqVtXCUj424EDr448tIAC88XnfzXUreVdGbyu57e5j5mhY_DYdRw6s8MI0fmXxNAMteSEM0SgNMhS26i3k829yH5_1Qo','ar',NULL,NULL,0),(62,'Norman Stanton','pujytok@mailinator.com','+1 (993) 748-8383',NULL,'$2y$10$5.DuCvyplyTHgJPcRLGNzuFHGnYEXQsuu78r8j8KBDrel3jxZLZFu',NULL,'2025-03-09 09:34:37','2025-03-09 09:34:37',NULL,1000000,1,NULL,'en',NULL,NULL,0),(63,'mohamed','MH@gmail.com','966500000001',NULL,'$2y$10$LxgeF3A4sX6pnpd6Qa0ud.q5tWnKDIimGcY41F5w91HsFPlmuFEEm',NULL,'2025-03-15 19:16:36','2025-03-15 20:30:57','[]',1000000,1,'e_S8iQuuSR6h1im_KmwE8p:APA91bG_aKjOqwG_p5gnnFmrM4L-MkR3jd6WF0HlrszYQkOxdNZYcrvi7PZyB0xnekbidfv3l4Ap8sp65YHn3104zlRRbmpFiisuKoclWiUxfiAxC5wA44A','ar',NULL,NULL,0),(64,'Mohamed Ali','mohamedali680000@gmail.com',NULL,NULL,NULL,NULL,'2025-03-17 19:04:08','2025-03-24 04:41:51',NULL,1000000,1,'cC06RgJrHE1Xja-DoPDdSY:APA91bEIEGmzjQL0h_Z6y5eHWxUrqgc6jFY3U7Q4wws_2k53e22U-KZSdUKUyM0b60Cu3mrC_2PoRHIveh7Epl-Q0UX8BD3nKuLAXVC1Z_atXSvmqwM5ryU','en','CI2393dBIhOtUOVSQUZxDttpfLJ3',NULL,0),(65,'mohamed',NULL,NULL,NULL,NULL,NULL,'2025-03-17 19:35:13','2025-03-24 10:58:16',NULL,1000000,1,'ccn9pBxH50QJtmYey82mX3:APA91bHOXrpmS0SetU33TTfAU_mdfS88ZuzhZFBuSMuBRS_IXGVn5nkwoz4OP5tKV33Rj6OnB0hH3dTd7BDXOdfJiasLWTCVQAVFMraAKQTYzd9RbF_HiHs','en','pnkfNLvFYiOizCqyweXLHGGgCWH3',NULL,0),(66,'Boula Nessim','nessimswboula@gmail.com','011267859104',NULL,NULL,NULL,'2025-03-18 10:29:43','2025-03-18 10:30:27',NULL,1000000,1,'jjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjj','en','yyyyyyyyyyyyyyyyyyyyyyyyy',NULL,0),(67,'mohamed','mohamed_1@gmail.com','966500000910',NULL,'$2y$10$0aBSSfVlwj9Y5kjp2e8SQ.JX3lTXhFLuXIccyhLcP98SvJ9nkvfN6',NULL,'2025-03-19 00:26:28','2025-03-19 00:26:50','{\n    \"item_d073757590a6c802954dc9828c1f6444\": {\n        \"id\": \"44-12c3s\",\n        \"title\": \"\\u062d\\u0642\\u064a\\u0628\\u0629 \\u064a\\u062f \\u0646\\u0633\\u0627\\u0626\\u064a\\u0629\",\n        \"quantity\": 1,\n        \"price\": 40,\n        \"options\": {\n            \"image\": \"https:\\/\\/adc1.com.sa\\/images\\/1741778453_9-removebg-preview.png\",\n            \"color\": 12,\n            \"size\": 3,\n            \"variation_id\": 376,\n            \"colorTitle\": \"\\u0623\\u0633\\u0648\\u062f\",\n            \"sizeTitle\": \"\\u0645\\u062a\\u0648\\u0633\\u0637\",\n            \"offer_id\": null,\n            \"validOffer\": false\n        }\n    }\n}',1000000,1,'e_S8iQuuSR6h1im_KmwE8p:APA91bG_aKjOqwG_p5gnnFmrM4L-MkR3jd6WF0HlrszYQkOxdNZYcrvi7PZyB0xnekbidfv3l4Ap8sp65YHn3104zlRRbmpFiisuKoclWiUxfiAxC5wA44A','ar',NULL,NULL,0),(68,'mohamed','mohamed_10@gmail.com','966500000910',NULL,'$2y$10$ASfn9zjajZf1/bZZtHvB9uK5l0V89ptPAgLNAaMXYODH9HN3.Vfei',NULL,'2025-03-19 00:42:58','2025-03-19 00:42:58',NULL,1000000,1,'e_S8iQuuSR6h1im_KmwE8p:APA91bG_aKjOqwG_p5gnnFmrM4L-MkR3jd6WF0HlrszYQkOxdNZYcrvi7PZyB0xnekbidfv3l4Ap8sp65YHn3104zlRRbmpFiisuKoclWiUxfiAxC5wA44A','ar',NULL,NULL,0),(69,'murad','murad12@gmail.com','966550000000',NULL,'$2y$10$BcKJG6O4OX9b6OrhytmUUOkZVWJ9rkiSYIocdgRGnQMmRNhIqT.2i',NULL,'2025-03-19 00:47:31','2025-03-19 00:47:31',NULL,1000000,1,'e_S8iQuuSR6h1im_KmwE8p:APA91bG_aKjOqwG_p5gnnFmrM4L-MkR3jd6WF0HlrszYQkOxdNZYcrvi7PZyB0xnekbidfv3l4Ap8sp65YHn3104zlRRbmpFiisuKoclWiUxfiAxC5wA44A','ar',NULL,NULL,0),(70,'Ahmed','a.abdekrahman@aloo.com.sa','0504350500',NULL,'$2y$10$BSzAi7szDzum92FYqCm78uR00iUHDiCNZfieVT0LJA93jnQzdhITK',NULL,'2025-03-23 11:30:00','2025-03-23 11:30:00',NULL,1000000,1,'fOrcYShlSfuSr_1uVwDu0y:APA91bHwfaCB8X-jPRwolwPXXnvBbH65HIHUYNbSE93k-GFwOLO1MduOQaeFsHN9IbQUd8WeofgGH4xE8yjHZE9OonBtSk7886tg5TmTLVmbxhzJU5tO9dE','en',NULL,NULL,0),(71,'Apple','zcjs4zhfs6@privaterelay.appleid.com',NULL,NULL,NULL,NULL,'2025-03-24 10:38:06','2025-03-24 10:38:06',NULL,1000000,1,'dZ2J_UnWVUAfp3wMyumoET:APA91bEg-ARxv1Qp3hO3dK8dP0R9A-lbFCayut0iGO0_avKmXBzMcLsWtVwnYb8o_N4hMWlhGZ8elLIvGl9NDOcB0H98dDPlqTwnITBnS2F0US7s8KjQqW8','en','twjIfF9bLHPoCnOAjTXa74mMbfs2',NULL,0),(72,'Mohamed Ali','engmohammedaly1@gmail.com',NULL,NULL,NULL,NULL,'2025-03-24 10:58:01','2025-03-24 10:58:01',NULL,1000000,1,'ccn9pBxH50QJtmYey82mX3:APA91bHOXrpmS0SetU33TTfAU_mdfS88ZuzhZFBuSMuBRS_IXGVn5nkwoz4OP5tKV33Rj6OnB0hH3dTd7BDXOdfJiasLWTCVQAVFMraAKQTYzd9RbF_HiHs','en','IV8lx8pXdvYEOIemuLKqvPhYgC63',NULL,0),(73,'Yoshi White','bezuki@mailinator.com','+1 (547) 403-1469',NULL,'$2y$10$c75n/esX0KNmgIx8xHjgjOUU8oICCdlkx9aR2sSS7SGpzj/Ej6HMm',NULL,'2025-03-24 11:21:07','2025-03-24 11:22:06','{\n    \"item_7bbb4190f2f2d61cc35daacbb7c770a4\": {\n        \"id\": \"55-7c1s\",\n        \"title\": \"Men\'s Shirt\",\n        \"quantity\": 1,\n        \"price\": 40,\n        \"options\": {\n            \"image\": \"https:\\/\\/adc1.com.sa\\/default.jpg\",\n            \"color\": \"7\",\n            \"size\": \"1\",\n            \"variation_id\": 430,\n            \"colorTitle\": \"Purple\",\n            \"sizeTitle\": \"Extra Small\",\n            \"offer_id\": 35,\n            \"validOffer\": false\n        }\n    },\n    \"item_ee64b9801df90e51ecad2eb500137327\": {\n        \"id\": \"55-7c2s\",\n        \"title\": \"Men\'s Shirt\",\n        \"quantity\": 1,\n        \"price\": 36,\n        \"options\": {\n            \"image\": \"https:\\/\\/adc1.com.sa\\/default.jpg\",\n            \"color\": \"7\",\n            \"size\": \"2\",\n            \"variation_id\": 431,\n            \"colorTitle\": \"Purple\",\n            \"sizeTitle\": \"Small\",\n            \"offer_id\": 35,\n            \"validOffer\": false\n        }\n    }\n}',1000000,1,NULL,'en',NULL,NULL,0),(74,'Abdalla Alamary','abdalla33360@gmail.com',NULL,NULL,NULL,NULL,'2025-03-25 03:17:27','2025-03-25 03:17:27',NULL,1000000,1,'cgL3RZaHTBuUuVzbWcGBEk:APA91bG5inUE_9vjRXS5-GQSXbGc4Q2r42jLFJ1_anYsIzdFKZdMfzoAzYhh2RLmQYnvT1x0ERpcPu5t4jDRqSLw5blJBlkzVetSHYirfBw3sxKsmp1PE-I','en','zvNlIiEaqwfabLgemOdgCWNQsfk2',NULL,0),(75,'Boula Nessim','nessimswboula68@gmail.com','011267859104',NULL,'$2y$10$a4pH7hfTodwUdW7xV0e2teqY8qxmjBJrx9yt0/Aa52ZVwc.1RZY8m',NULL,'2025-03-25 10:01:47','2025-03-30 08:28:14',NULL,1000000,1,NULL,'en',NULL,'118801',0),(76,'Boula Nessim','ibrahimsamy50@gmail.com','01289189898',NULL,'$2y$10$sOQuf7NKmKKE06H1I2inXePFbW4nQ3REFMSVQTCwScS8W0fuBrDvS',NULL,'2025-03-30 17:04:17','2025-03-30 17:04:17',NULL,1000000,1,NULL,'en',NULL,NULL,0),(77,'Leonard Robinson','xuxuf@mailinator.com','01126785910',NULL,'$2y$10$991n2NxGV8LaYzoZ0of1YeKMDwWklC3EclqkqzCwgPZh8E/pUWl16',NULL,'2025-03-30 18:59:46','2025-03-30 18:59:46',NULL,1000000,1,NULL,'en',NULL,NULL,0),(78,'Yvonne Holt','givumi@mailinator.com','01127785910',NULL,'$2y$10$atEOcRBHRKhUF3L6NaZy4e8kzGKq5pFM0/eWLdRFJHDzl/l2xiLTW',NULL,'2025-03-30 19:03:28','2025-03-30 19:03:28',NULL,1000000,1,NULL,'en',NULL,NULL,0),(79,'Troy Cote','heri@mailinator.com','01125785910',NULL,'$2y$10$.RihNsxFyRkdFCj0sQyrTuJcN4DS4tyUvoXjJ9L7TVyG5IBEc4.Re',NULL,'2025-03-30 19:04:21','2025-03-30 19:04:21',NULL,1000000,1,NULL,'en',NULL,NULL,0),(80,'Jaquelyn Nielsen','jymokij@mailinator.com','0114587963',NULL,'$2y$10$DBrKTaOhaZ2BS1zaWquhTu8qkIV1eooKh9wDBeRJ9s21DbpPuxdLS',NULL,'2025-04-08 21:18:57','2025-04-08 21:18:57',NULL,1000000,1,NULL,'en',NULL,NULL,0),(81,'Nola Stephenson','miroq@mailinator.com','0112547895',NULL,'$2y$10$BpPaHqEGN7mjjRbuagnbkO864uELTsAjM3h1JpDeBsCPOEs2/1WDS',NULL,'2025-04-08 21:58:42','2025-04-22 21:42:09','{\n    \"item_43b0985637b7dff8a8593031ff5d170f\": {\n        \"id\": 1,\n        \"title\": \"\\u0648\\u0631\\u0648\\u062f \\u062d\\u0645\\u0631\\u0627\\u0621 \\u0631\\u0648\\u0645\\u0627\\u0646\\u0633\\u064a\\u0629\",\n        \"quantity\": 1,\n        \"price\": 753,\n        \"options\": []\n    },\n    \"item_88009543a94b59edacf8bdba98496a2e\": {\n        \"id\": 2,\n        \"title\": \"\\u0632\\u0646\\u0627\\u0628\\u0642 \\u0628\\u064a\\u0636\\u0627\\u0621 \\u0623\\u0646\\u064a\\u0642\\u0629\",\n        \"quantity\": 1,\n        \"price\": 170,\n        \"options\": []\n    }\n}',1000000,1,NULL,'en',NULL,NULL,0),(82,'Venus Roy','bizyvujuke@mailinator.com','0112456784',NULL,'$2y$10$vhww6rkw9L2OiASkfvTxiOL8Ka.h0SbnPuQT/z/MkSqajMvzbEafm',NULL,'2025-04-16 20:13:59','2025-04-16 21:46:59','{\n    \"item_9e12ed3d46315265bd5d899cdfd5137c\": {\n        \"id\": 4,\n        \"title\": \"Mixed Spring Flowers\",\n        \"quantity\": 1,\n        \"price\": 224,\n        \"options\": []\n    },\n    \"item_a23a3d3fd5a098301fd3029325f46120\": {\n        \"id\": 3,\n        \"title\": \"Sunshine Sunflower Bouquet\",\n        \"quantity\": 2,\n        \"price\": 830,\n        \"options\": []\n    }\n}',1000000,1,NULL,'en',NULL,NULL,0),(83,'eman mohammed','eman125mohamed@gmail.com','01095965235',NULL,'$2y$10$hpw5HTrRWI7Jqbo99OeCnuB0v7aoyCBUpnpyJpZInMzsOJ9HXIEfe',NULL,'2025-04-17 14:54:23','2025-04-17 14:55:24','{\n    \"item_43b0985637b7dff8a8593031ff5d170f\": {\n        \"id\": 1,\n        \"title\": \"Romantic Red Roses\",\n        \"quantity\": 1,\n        \"price\": 753,\n        \"options\": []\n    }\n}',1000000,1,NULL,'en',NULL,NULL,0),(84,'Stewart Burnett','johuroje@mailinator.com','0114578963',NULL,'$2y$10$9J4d1bfbQT2OfdN1HQ8pRuuGy7WiCJBx1ypPKMugilYMeFZy6BfGm',NULL,'2025-04-18 19:59:34','2025-04-18 20:00:15','{\n    \"item_5907f7a8f3bdd636d91a283f47a55070\": {\n        \"id\": 6,\n        \"title\": \"Valentine\'s Special Roses\",\n        \"quantity\": 2,\n        \"price\": 890,\n        \"options\": []\n    }\n}',1000000,1,NULL,'en',NULL,NULL,0),(85,'Dale Everett','juputoli@mailinator.com','01147895214',NULL,'$2y$10$qkO0JLqsiOg0opPELOuphuiQmh8fZP5hSTCFmndNvkvrhjZ4oSTbq',NULL,'2025-06-07 17:49:09','2025-06-07 17:50:14','{\n    \"item_f7241c29baa4b0728cb0c45f0f338ad4\": {\n        \"id\": 70,\n        \"title\": \"\\u0635\\u0646\\u062f\\u0648\\u0642 \\u0647\\u062f\\u0627\\u064a\\u0627 \\u0627\\u0644\\u0648\\u0631\\u062f\",\n        \"quantity\": 1,\n        \"price\": 1450,\n        \"options\": []\n    },\n    \"item_a650e063bef5d3d68d63a6b163c50e75\": {\n        \"id\": 72,\n        \"title\": \"Eternal love box\",\n        \"quantity\": 1,\n        \"price\": 3500,\n        \"options\": []\n    },\n    \"item_d83aefd2e47a57e4777df0edbe9bd721\": {\n        \"id\": 88,\n        \"title\": \"I love you, mom\",\n        \"quantity\": 1,\n        \"price\": 945,\n        \"options\": []\n    },\n    \"item_1fc5c8f22b1f6b0dc29fc65174a7b1a8\": {\n        \"id\": 89,\n        \"title\": \"I love you, mom\",\n        \"quantity\": 1,\n        \"price\": 945,\n        \"options\": []\n    },\n    \"item_027ef7b451f04bc5b01d469625e8e9c2\": {\n        \"id\": 5,\n        \"title\": \"Luxury Orchid Arrangement\",\n        \"quantity\": 1,\n        \"price\": 801,\n        \"options\": []\n    }\n}',1000000,1,NULL,'en',NULL,NULL,0),(86,'Ahmed','dalatonyahmed28@gmail.com','01070718676',NULL,'$2y$10$lglAHCTBdr8l6iVo8tGdfOWi8P88EKY77DZUC4oWzUt7jvbNNRyzi',NULL,'2025-08-13 16:20:52','2025-08-13 16:27:26','[]',94600,1,NULL,'en',NULL,NULL,0),(87,'Adrian Rush','qini@mailinator.com','0114785963',NULL,'$2y$10$hZQ472eT8tpknxYYtyrpjuMM6cuafuLBRlJDbYPoN8u5SO25xd4Um',NULL,'2025-08-13 16:21:35','2025-08-13 16:21:35',NULL,0,1,NULL,'en',NULL,NULL,0),(88,'Kermina Milad','kermina@gmail.com','01272801581',NULL,'$2y$10$mm1F7A.C/l7qAZoDLJDFwuaLRdkB/H7QLLjZz2Nie6cNM547WstTO',NULL,'2025-09-19 02:14:16','2025-09-19 02:15:33','{\n    \"item_c6482e92b8fabd96df02fbf9cc5f2995\": {\n        \"id\": 119,\n        \"title\": \"jumper 16 inch Convertible Laptop\",\n        \"quantity\": 1,\n        \"price\": 22000,\n        \"options\": []\n    }\n}',0,1,NULL,'en',NULL,NULL,0);
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `world_cities`
--

DROP TABLE IF EXISTS `world_cities`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `world_cities` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT COMMENT 'Auto increase ID',
  `country_id` bigint(20) unsigned NOT NULL COMMENT 'Country ID',
  `division_id` bigint(20) unsigned DEFAULT NULL COMMENT 'Division ID',
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT 'City Name',
  `full_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'City Fullname',
  `code` varchar(64) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'City Code',
  PRIMARY KEY (`id`),
  KEY `uniq_city` (`country_id`,`division_id`,`name`),
  KEY `division_id` (`division_id`),
  CONSTRAINT `world_cities_ibfk_1` FOREIGN KEY (`country_id`) REFERENCES `world_countries` (`id`) ON DELETE CASCADE,
  CONSTRAINT `world_cities_ibfk_2` FOREIGN KEY (`division_id`) REFERENCES `world_divisions` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `world_cities`
--

LOCK TABLES `world_cities` WRITE;
/*!40000 ALTER TABLE `world_cities` DISABLE KEYS */;
/*!40000 ALTER TABLE `world_cities` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `world_cities_locale`
--

DROP TABLE IF EXISTS `world_cities_locale`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `world_cities_locale` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT COMMENT 'Auto increase ID',
  `city_id` bigint(20) unsigned NOT NULL COMMENT 'City ID',
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT 'Localized city name',
  `alias` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'Localized city alias',
  `full_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'Localized city fullname',
  `locale` varchar(6) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'locale name',
  PRIMARY KEY (`id`),
  UNIQUE KEY `uniq_city_id_locale` (`city_id`,`locale`),
  CONSTRAINT `world_cities_locale_ibfk_1` FOREIGN KEY (`city_id`) REFERENCES `world_cities` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `world_cities_locale`
--

LOCK TABLES `world_cities_locale` WRITE;
/*!40000 ALTER TABLE `world_cities_locale` DISABLE KEYS */;
/*!40000 ALTER TABLE `world_cities_locale` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `world_continents`
--

DROP TABLE IF EXISTS `world_continents`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `world_continents` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT COMMENT 'Auto increase ID',
  `name` varchar(16) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT 'Continent Name',
  `code` varchar(2) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT 'Continent Code',
  PRIMARY KEY (`id`),
  KEY `uniq_continent` (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `world_continents`
--

LOCK TABLES `world_continents` WRITE;
/*!40000 ALTER TABLE `world_continents` DISABLE KEYS */;
/*!40000 ALTER TABLE `world_continents` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `world_continents_locale`
--

DROP TABLE IF EXISTS `world_continents_locale`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `world_continents_locale` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT COMMENT 'Auto increase ID',
  `continent_id` bigint(20) unsigned NOT NULL COMMENT 'Continent ID',
  `name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'Localized Name',
  `alias` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'Localized Alias',
  `abbr` varchar(16) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'Localized Abbr name',
  `full_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'Localized Fullname',
  `locale` varchar(6) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'Locale',
  PRIMARY KEY (`id`),
  UNIQUE KEY `uniq_continent_id_locale` (`continent_id`,`locale`),
  CONSTRAINT `world_continents_locale_ibfk_1` FOREIGN KEY (`continent_id`) REFERENCES `world_continents` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `world_continents_locale`
--

LOCK TABLES `world_continents_locale` WRITE;
/*!40000 ALTER TABLE `world_continents_locale` DISABLE KEYS */;
/*!40000 ALTER TABLE `world_continents_locale` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `world_countries`
--

DROP TABLE IF EXISTS `world_countries`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `world_countries` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT COMMENT 'Auto increase ID',
  `continent_id` bigint(20) unsigned NOT NULL COMMENT 'Continent ID',
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT 'Country Common Name',
  `full_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'Country Fullname',
  `capital` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'Capital Common Name',
  `code` varchar(4) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'ISO3166-1-Alpha-2',
  `code_alpha3` varchar(6) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'ISO3166-1-Alpha-3',
  `emoji` varchar(16) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'Country Emoji',
  `has_division` tinyint(1) NOT NULL DEFAULT '0' COMMENT 'Has Division',
  `currency_code` varchar(3) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'iso_4217_code',
  `currency_name` varchar(128) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'iso_4217_name',
  `tld` varchar(8) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'Top level domain',
  `callingcode` varchar(8) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'Calling prefix',
  PRIMARY KEY (`id`),
  UNIQUE KEY `uniq_country` (`continent_id`,`name`),
  CONSTRAINT `world_countries_ibfk_1` FOREIGN KEY (`continent_id`) REFERENCES `world_continents` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `world_countries`
--

LOCK TABLES `world_countries` WRITE;
/*!40000 ALTER TABLE `world_countries` DISABLE KEYS */;
/*!40000 ALTER TABLE `world_countries` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `world_countries_locale`
--

DROP TABLE IF EXISTS `world_countries_locale`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `world_countries_locale` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT COMMENT 'Auto increase ID',
  `country_id` bigint(20) unsigned NOT NULL COMMENT 'Country ID',
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT 'Localized Country Name',
  `alias` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'Localized Country Alias',
  `abbr` varchar(16) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'Localized Country Abbr Name',
  `full_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'Localized Country Fullname',
  `currency_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'Localized Country Currency Name',
  `locale` varchar(6) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'locale',
  PRIMARY KEY (`id`),
  UNIQUE KEY `uniq_country_id_locale` (`country_id`,`locale`),
  CONSTRAINT `world_countries_locale_ibfk_1` FOREIGN KEY (`country_id`) REFERENCES `world_countries` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `world_countries_locale`
--

LOCK TABLES `world_countries_locale` WRITE;
/*!40000 ALTER TABLE `world_countries_locale` DISABLE KEYS */;
/*!40000 ALTER TABLE `world_countries_locale` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `world_divisions`
--

DROP TABLE IF EXISTS `world_divisions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `world_divisions` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT COMMENT 'Auto Increase ID',
  `country_id` bigint(20) unsigned NOT NULL COMMENT 'Country ID',
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT 'Division Common Name',
  `full_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'Division Full Name',
  `code` varchar(64) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'ISO 3166-2 Code',
  `has_city` tinyint(1) NOT NULL DEFAULT '0' COMMENT 'Has city?',
  PRIMARY KEY (`id`),
  UNIQUE KEY `uniq_division` (`country_id`,`name`),
  CONSTRAINT `world_divisions_ibfk_1` FOREIGN KEY (`country_id`) REFERENCES `world_countries` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `world_divisions`
--

LOCK TABLES `world_divisions` WRITE;
/*!40000 ALTER TABLE `world_divisions` DISABLE KEYS */;
/*!40000 ALTER TABLE `world_divisions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `world_divisions_locale`
--

DROP TABLE IF EXISTS `world_divisions_locale`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `world_divisions_locale` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT COMMENT 'Auto Increase ID',
  `division_id` bigint(20) unsigned NOT NULL COMMENT 'Division ID',
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT 'Localized Division Name',
  `abbr` varchar(16) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'Localized Division Abbr',
  `alias` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'Localized Division Alias',
  `full_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'Localized Division Fullname',
  `locale` varchar(6) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'locale',
  PRIMARY KEY (`id`),
  UNIQUE KEY `uniq_division_id_locale` (`division_id`,`locale`),
  CONSTRAINT `world_divisions_locale_ibfk_1` FOREIGN KEY (`division_id`) REFERENCES `world_divisions` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `world_divisions_locale`
--

LOCK TABLES `world_divisions_locale` WRITE;
/*!40000 ALTER TABLE `world_divisions_locale` DISABLE KEYS */;
/*!40000 ALTER TABLE `world_divisions_locale` ENABLE KEYS */;
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

-- Dump completed on 2025-09-23  6:59:19
