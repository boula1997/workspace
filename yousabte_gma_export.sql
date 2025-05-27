-- MySQL dump 10.13  Distrib 5.7.23-23, for Linux (x86_64)
--
-- Host: localhost    Database: yousabte_gma
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
-- Table structure for table `admins`
--

DROP TABLE IF EXISTS `admins`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `admins` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `admins_email_unique` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `admins`
--

LOCK TABLES `admins` WRITE;
/*!40000 ALTER TABLE `admins` DISABLE KEYS */;
INSERT INTO `admins` VALUES (1,'Super Admin','admin@gmail.com',NULL,'$2y$10$a.TV8JXh/AxQOV34irPD5.UfCyfX1krWNJSc1OI5WpGIQt35Ql65K',NULL,'2024-10-22 14:48:35','2024-10-22 14:48:35');
/*!40000 ALTER TABLE `admins` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `blog`
--

DROP TABLE IF EXISTS `blog`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `blog` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `date` date DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `blog`
--

LOCK TABLES `blog` WRITE;
/*!40000 ALTER TABLE `blog` DISABLE KEYS */;
INSERT INTO `blog` VALUES (1,'2022-05-19','2024-10-22 14:48:36','2024-10-22 14:48:36'),(2,'2024-08-17','2024-10-22 14:48:36','2024-10-22 14:48:36'),(3,'2023-06-07','2024-10-22 14:48:36','2024-10-22 14:48:36'),(4,'2024-02-28','2024-10-22 14:48:36','2024-10-22 14:48:36'),(5,'2022-03-08','2024-10-22 14:48:36','2024-10-22 14:48:36'),(6,'2022-06-17','2024-10-22 14:48:36','2024-10-22 14:48:36'),(7,'2023-01-08','2024-10-22 14:48:36','2024-10-22 14:48:36'),(8,'2024-04-04','2024-10-22 14:48:36','2024-10-22 14:48:36'),(9,'2023-01-16','2024-10-22 14:48:36','2024-10-22 14:48:36'),(10,'2022-07-01','2024-10-22 14:48:36','2024-10-22 14:48:36');
/*!40000 ALTER TABLE `blog` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `blog_translations`
--

DROP TABLE IF EXISTS `blog_translations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `blog_translations` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `subtitle` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `blog_id` bigint(20) unsigned NOT NULL,
  `locale` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `blog_translations_blog_id_locale_unique` (`blog_id`,`locale`),
  KEY `blog_translations_locale_index` (`locale`),
  CONSTRAINT `blog_translations_blog_id_foreign` FOREIGN KEY (`blog_id`) REFERENCES `blog` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `blog_translations`
--

LOCK TABLES `blog_translations` WRITE;
/*!40000 ALTER TABLE `blog_translations` DISABLE KEYS */;
INSERT INTO `blog_translations` VALUES (1,'قوة الأعشاب في الشفاء','اكتشاف إمكانات الطبيعة','<p>تم استخدام الأعشاب لقرون لخصائصها الطبية. اكتشف العلم وراء قوة الشفاء من الأعشاب وكيف يمكن أن تفيد صحتك اليوم.</p>',1,'ar','2024-10-22 14:48:36','2024-10-22 14:48:36'),(2,'The Power of Herbs in Healing','Unlocking Nature’s Potential','<p>Herbs have been used for centuries for their medicinal properties. Discover the science behind the healing power of herbs and how they can benefit your health today.</p>',1,'en','2024-10-22 14:48:36','2024-10-22 14:48:36'),(3,'كيفية تحضير كوب مثالي من شاي الأعشاب','دليل خطوة بخطوة','<p>تحضير شاي الأعشاب هو فن. تعرف على التقنيات لصنع التحضير المثالي واستخلاص النكهة والفوائد القصوى من الأعشاب المفضلة لديك.</p>',2,'ar','2024-10-22 14:48:36','2024-10-22 14:48:36'),(4,'How to Brew the Perfect Cup of Herbal Tea','A Step-by-Step Guide','<p>Brewing herbal tea is an art. Learn the techniques to make the perfect brew and extract the maximum flavor and benefits from your favorite herbs.</p>',2,'en','2024-10-22 14:48:36','2024-10-22 14:48:36'),(5,'فوائد البابونج لتخفيف التوتر','الاسترخاء بشكل طبيعي','<p>البابونج معروف بتأثيراته المهدئة. استكشف كيف يمكن أن يساعد شرب شاي البابونج أو استخدام مستخلصاته في تقليل التوتر وتعزيز النوم الأفضل.</p>',3,'ar','2024-10-22 14:48:36','2024-10-22 14:48:36'),(6,'The Benefits of Chamomile for Stress Relief','Relax Naturally','<p>Chamomile is renowned for its calming effects. Explore how drinking chamomile tea or using its extracts can help reduce stress and promote better sleep.</p>',3,'en','2024-10-22 14:48:36','2024-10-22 14:48:36'),(7,'صعود الزراعة العضوية','طريقة صحية للنمو','<p>مع تزايد الطلب على المنتجات الطبيعية والخالية من المواد الكيميائية، أصبحت الزراعة العضوية هي الطريقة المفضلة للزراعة. تعرف على فوائدها لصحة الإنسان والبيئة.</p>',4,'ar','2024-10-22 14:48:36','2024-10-22 14:48:36'),(8,'The Rise of Organic Farming','A Healthier Way to Grow','<p>With the growing demand for natural and chemical-free products, organic farming is becoming the preferred method of cultivation. Learn about its benefits for both health and the environment.</p>',4,'en','2024-10-22 14:48:36','2024-10-22 14:48:36'),(9,'فهم الأنواع المختلفة من البذور','اختيار البذور المناسبة لاحتياجاتك','<p>ليست كل البذور متساوية. يشرح هذا المقال الأنواع المختلفة من البذور المتاحة في السوق وكيفية اختيار أفضلها لحديقتك أو مزرعتك.</p>',5,'ar','2024-10-22 14:48:36','2024-10-22 14:48:36'),(10,'Understanding the Different Types of Seeds','Choosing the Right Seeds for Your Needs','<p>Not all seeds are created equal. This blog explains the different types of seeds available in the market and how to select the best ones for your garden or farm.</p>',5,'en','2024-10-22 14:48:36','2024-10-22 14:48:36'),(11,'النعناع: العشب المتعدد الاستخدامات','نظرة جديدة على العافية','<p>النعناع هو أكثر من مجرد عشب منعش. اكتشف استخداماته المتعددة، بدءًا من تحسين الهضم إلى تخفيف الصداع، وكيف يمكن أن يعزز رفاهيتك.</p>',6,'ar','2024-10-22 14:48:36','2024-10-22 14:48:36'),(12,'Peppermint: The Versatile Herb','A Fresh Take on Wellness','<p>Peppermint is more than just a refreshing herb. Discover its wide range of uses, from improving digestion to relieving headaches, and how it can enhance your well-being.</p>',6,'en','2024-10-22 14:48:36','2024-10-22 14:48:36'),(13,'دور الشمر في المأكولات اللذيذة','إضافة نكهة مع فوائد صحية','<p>يعتبر الشمر عنصرًا أساسيًا في العديد من المأكولات حول العالم. اكتشف كيف يمكن استخدام هذا العشب العطري في الطهي وفوائده الصحية العديدة.</p>',7,'ar','2024-10-22 14:48:36','2024-10-22 14:48:36'),(14,'The Role of Fennel in Culinary Delights','Adding Flavor with Health Benefits','<p>Fennel is a staple in many cuisines around the world. Find out how this aromatic herb can be used in cooking and its numerous health benefits.</p>',7,'en','2024-10-22 14:48:36','2024-10-22 14:48:36'),(15,'لماذا الكركديه غذاء خارق','غني بمضادات الأكسدة والفيتامينات','<p>الكركديه غني بمضادات الأكسدة والفيتامينات التي يمكن أن تعزز جهاز المناعة لديك. تعرف على سبب وجوب أن يكون الكركديه جزءًا من نظامك الغذائي اليومي.</p>',8,'ar','2024-10-22 14:48:36','2024-10-22 14:48:36'),(16,'Why Hibiscus is a Superfood','Rich in Antioxidants and Vitamins','<p>Hibiscus is packed with antioxidants and vitamins that can boost your immune system. Learn why hibiscus should be a part of your daily diet.</p>',8,'en','2024-10-22 14:48:36','2024-10-22 14:48:36'),(17,'الزراعة المستدامة: اتجاه متزايد','الزراعة من أجل المستقبل','<p>الاستدامة هي مستقبل الزراعة. اكتشف كيف تعمل ممارسات الزراعة المستدامة على تحويل الصناعة والمساعدة في حماية الكوكب.</p>',9,'ar','2024-10-22 14:48:36','2024-10-22 14:48:36'),(18,'Sustainable Agriculture: A Growing Trend','Farming for the Future','<p>Sustainability is the future of agriculture. Discover how sustainable farming practices are transforming the industry and helping to protect the planet.</p>',9,'en','2024-10-22 14:48:36','2024-10-22 14:48:36'),(19,'كيفية تخزين الأعشاب للحصول على أقصى نضارة','الحفاظ على النكهة والفوائد','<p>تخزين الأعشاب بشكل صحيح أمر ضروري للحفاظ على نكهتها وفوائدها الصحية. تعرف على أفضل الممارسات لتخزين الأعشاب المجففة والطازجة.</p>',10,'ar','2024-10-22 14:48:36','2024-10-22 14:48:36'),(20,'How to Store Herbs for Maximum Freshness','Preserving Flavor and Benefits','<p>Storing herbs correctly is essential for maintaining their flavor and health benefits. Learn the best practices for storing dried and fresh herbs.</p>',10,'en','2024-10-22 14:48:36','2024-10-22 14:48:36');
/*!40000 ALTER TABLE `blog_translations` ENABLE KEYS */;
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
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `categories`
--

LOCK TABLES `categories` WRITE;
/*!40000 ALTER TABLE `categories` DISABLE KEYS */;
INSERT INTO `categories` VALUES (1,'2024-10-22 14:48:35','2024-10-22 14:48:35'),(2,'2024-10-22 14:48:35','2024-10-22 14:48:35'),(3,'2024-10-22 14:48:35','2024-10-22 14:48:35'),(4,'2024-10-22 14:48:35','2024-10-22 14:48:35'),(5,'2024-10-22 14:48:35','2024-10-22 14:48:35'),(6,'2024-10-22 14:48:35','2024-10-22 14:48:35'),(7,'2024-10-22 14:48:35','2024-10-22 14:48:35');
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
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `category_translations`
--

LOCK TABLES `category_translations` WRITE;
/*!40000 ALTER TABLE `category_translations` DISABLE KEYS */;
INSERT INTO `category_translations` VALUES (1,'ألعاب',1,'ar','2024-10-22 14:48:35','2024-10-22 14:48:35'),(2,'Video Games',1,'en','2024-10-22 14:48:35','2024-10-22 14:48:35'),(3,'أجهزة الألعاب',2,'ar','2024-10-22 14:48:35','2024-10-22 14:48:35'),(4,'Consoles & Hardware',2,'en','2024-10-22 14:48:35','2024-10-22 14:48:35'),(5,'اكسسوارات',3,'ar','2024-10-22 14:48:35','2024-10-22 14:48:35'),(6,'Accessories',3,'en','2024-10-22 14:48:35','2024-10-22 14:48:35'),(7,'مستعمل',4,'ar','2024-10-22 14:48:35','2024-10-22 14:48:35'),(8,'Pre Owned',4,'en','2024-10-22 14:48:35','2024-10-22 14:48:35'),(9,'الألعاب والمقتنيات',5,'ar','2024-10-22 14:48:35','2024-10-22 14:48:35'),(10,'Toys & Collectibles',5,'en','2024-10-22 14:48:35','2024-10-22 14:48:35'),(11,'منتجات أخرى',6,'ar','2024-10-22 14:48:35','2024-10-22 14:48:35'),(12,'Others',6,'en','2024-10-22 14:48:35','2024-10-22 14:48:35'),(13,'العروض',7,'ar','2024-10-22 14:48:35','2024-10-22 14:48:35'),(14,'Offers',7,'en','2024-10-22 14:48:35','2024-10-22 14:48:35');
/*!40000 ALTER TABLE `category_translations` ENABLE KEYS */;
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
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `contacts`
--

LOCK TABLES `contacts` WRITE;
/*!40000 ALTER TABLE `contacts` DISABLE KEYS */;
INSERT INTO `contacts` VALUES (1,'https://www.facebook.com/profile.php?id=61551949000995&mibextid=ZbWKwL','fab fa-facebook-f','social','2024-10-22 14:48:35','2024-10-22 14:48:35'),(2,'https://www.linkedin.com','fab fa-linkedin','social','2024-10-22 14:48:35','2024-10-22 14:48:35'),(3,'https://instagram.com/el_alamia_games?igshid=OGQ5ZDc2ODk2ZA%3D%3D&utm_source=qr','fab fa-instagram','social','2024-10-22 14:48:35','2024-10-22 14:48:35'),(4,'alalamia@gmail.com','fas fa-mail-bulk','email','2024-10-22 14:48:35','2024-10-22 14:48:35'),(5,'01020202019','fas fa-phone','phone','2024-10-22 14:48:35','2024-10-22 14:48:35'),(6,'01020202019','fab fa-whatsapp','whatsapp','2024-10-22 14:48:35','2024-10-22 14:48:35');
/*!40000 ALTER TABLE `contacts` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `counter_translations`
--

DROP TABLE IF EXISTS `counter_translations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `counter_translations` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `counter_id` bigint(20) unsigned NOT NULL,
  `locale` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `counter_translations_counter_id_locale_unique` (`counter_id`,`locale`),
  KEY `counter_translations_locale_index` (`locale`),
  CONSTRAINT `counter_translations_counter_id_foreign` FOREIGN KEY (`counter_id`) REFERENCES `counters` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `counter_translations`
--

LOCK TABLES `counter_translations` WRITE;
/*!40000 ALTER TABLE `counter_translations` DISABLE KEYS */;
INSERT INTO `counter_translations` VALUES (1,'خبرتنا',1,'ar','2024-10-22 14:48:35','2024-10-22 14:48:35'),(2,'EXPERIENCE',1,'en','2024-10-22 14:48:35','2024-10-22 14:48:35'),(3,'لاعبينا',2,'ar','2024-10-22 14:48:35','2024-10-22 14:48:35'),(4,'OUR Gamers',2,'en','2024-10-22 14:48:35','2024-10-22 14:48:35'),(5,'ألعابنا',3,'ar','2024-10-22 14:48:35','2024-10-22 14:48:35'),(6,'Our Games',3,'en','2024-10-22 14:48:35','2024-10-22 14:48:35'),(7,'عملائنا',4,'ar','2024-10-22 14:48:35','2024-10-22 14:48:35'),(8,'HAPPY CLIENTS',4,'en','2024-10-22 14:48:35','2024-10-22 14:48:35');
/*!40000 ALTER TABLE `counter_translations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `counters`
--

DROP TABLE IF EXISTS `counters`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `counters` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `count` text COLLATE utf8mb4_unicode_ci,
  `icon` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `counters`
--

LOCK TABLES `counters` WRITE;
/*!40000 ALTER TABLE `counters` DISABLE KEYS */;
INSERT INTO `counters` VALUES (1,'10','fa fa-star','2024-10-22 14:48:35','2024-10-22 14:48:35'),(2,'50','fa fa-users','2024-10-22 14:48:35','2024-10-22 14:48:35'),(3,'150','fa fa-check','2024-10-22 14:48:35','2024-10-22 14:48:35'),(4,'1235','fa fa-mug-hot','2024-10-22 14:48:35','2024-10-22 14:48:35');
/*!40000 ALTER TABLE `counters` ENABLE KEYS */;
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
) ENGINE=InnoDB AUTO_INCREMENT=135 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `files`
--

LOCK TABLES `files` WRITE;
/*!40000 ALTER TABLE `files` DISABLE KEYS */;
INSERT INTO `files` VALUES (1,'images/about.jpg',1,'App\\Models\\Page','2024-10-22 14:48:35','2024-10-22 14:48:35'),(2,'images/sliders/slider1.jpg',1,'App\\Models\\Slider','2024-10-22 14:48:35','2024-10-22 14:48:35'),(3,'images/sliders/slider2.png',2,'App\\Models\\Slider','2024-10-22 14:48:35','2024-10-22 14:48:35'),(4,'images/sliders/slider3.jpg',3,'App\\Models\\Slider','2024-10-22 14:48:35','2024-10-22 14:48:35'),(5,'images/40cfbdV2muONc4yQnTOM2j6Vj1r93LaF8xtPwuiR.jpg',1,'App\\Models\\Category','2024-10-22 14:48:35','2024-10-22 14:48:35'),(6,'images/KzPsjVjmV1cqwSfI3jGAEX7xIwkaaIELyd84kLW5.webp',2,'App\\Models\\Category','2024-10-22 14:48:35','2024-10-22 14:48:35'),(7,'images/mVOcUrWdGH1Pnn36zwTWcgKyuqfe5qCugDtDgQwM.webp',3,'App\\Models\\Category','2024-10-22 14:48:35','2024-10-22 14:48:35'),(8,'images/EidvJDSPrKwzkb2JOnbZ6PmbPNQ3R2RfHAWtNHjM.webp',4,'App\\Models\\Category','2024-10-22 14:48:35','2024-10-22 14:48:35'),(9,'images/ffnJ3QBxG3aL7Y1JxwXTEHaCimitGQIj8YCbpc0k.webp',5,'App\\Models\\Category','2024-10-22 14:48:35','2024-10-22 14:48:35'),(10,'images/8nljzVfkdhbm5xN5YtRgYtIUZ5hv8q9ZSy9XDc5P.webp',6,'App\\Models\\Category','2024-10-22 14:48:35','2024-10-22 14:48:35'),(11,'images/8nljzVfkdhbm5xN5YtRgYtIUZ5hv8q9ZSy9XDc5P.webp',7,'App\\Models\\Category','2024-10-22 14:48:35','2024-10-22 14:48:35'),(12,NULL,1,'App\\Models\\Subcategory','2024-10-22 14:48:35','2024-10-22 14:48:35'),(13,NULL,2,'App\\Models\\Subcategory','2024-10-22 14:48:35','2024-10-22 14:48:35'),(14,NULL,3,'App\\Models\\Subcategory','2024-10-22 14:48:35','2024-10-22 14:48:35'),(15,NULL,4,'App\\Models\\Subcategory','2024-10-22 14:48:35','2024-10-22 14:48:35'),(16,NULL,5,'App\\Models\\Subcategory','2024-10-22 14:48:35','2024-10-22 14:48:35'),(17,NULL,6,'App\\Models\\Subcategory','2024-10-22 14:48:35','2024-10-22 14:48:35'),(18,NULL,7,'App\\Models\\Subcategory','2024-10-22 14:48:35','2024-10-22 14:48:35'),(19,NULL,8,'App\\Models\\Subcategory','2024-10-22 14:48:35','2024-10-22 14:48:35'),(20,NULL,9,'App\\Models\\Subcategory','2024-10-22 14:48:35','2024-10-22 14:48:35'),(21,NULL,10,'App\\Models\\Subcategory','2024-10-22 14:48:35','2024-10-22 14:48:35'),(22,NULL,11,'App\\Models\\Subcategory','2024-10-22 14:48:35','2024-10-22 14:48:35'),(23,NULL,12,'App\\Models\\Subcategory','2024-10-22 14:48:35','2024-10-22 14:48:35'),(24,NULL,13,'App\\Models\\Subcategory','2024-10-22 14:48:35','2024-10-22 14:48:35'),(25,NULL,14,'App\\Models\\Subcategory','2024-10-22 14:48:35','2024-10-22 14:48:35'),(26,NULL,15,'App\\Models\\Subcategory','2024-10-22 14:48:35','2024-10-22 14:48:35'),(27,NULL,16,'App\\Models\\Subcategory','2024-10-22 14:48:35','2024-10-22 14:48:35'),(28,NULL,17,'App\\Models\\Subcategory','2024-10-22 14:48:35','2024-10-22 14:48:35'),(29,NULL,18,'App\\Models\\Subcategory','2024-10-22 14:48:35','2024-10-22 14:48:35'),(30,NULL,19,'App\\Models\\Subcategory','2024-10-22 14:48:35','2024-10-22 14:48:35'),(31,NULL,20,'App\\Models\\Subcategory','2024-10-22 14:48:35','2024-10-22 14:48:35'),(32,NULL,21,'App\\Models\\Subcategory','2024-10-22 14:48:35','2024-10-22 14:48:35'),(33,NULL,22,'App\\Models\\Subcategory','2024-10-22 14:48:35','2024-10-22 14:48:35'),(34,NULL,23,'App\\Models\\Subcategory','2024-10-22 14:48:35','2024-10-22 14:48:35'),(35,NULL,24,'App\\Models\\Subcategory','2024-10-22 14:48:35','2024-10-22 14:48:35'),(36,NULL,25,'App\\Models\\Subcategory','2024-10-22 14:48:35','2024-10-22 14:48:35'),(37,NULL,26,'App\\Models\\Subcategory','2024-10-22 14:48:35','2024-10-22 14:48:35'),(38,NULL,27,'App\\Models\\Subcategory','2024-10-22 14:48:35','2024-10-22 14:48:35'),(39,NULL,1,'App\\Models\\Maincategory','2024-10-22 14:48:35','2024-10-22 14:48:35'),(40,NULL,2,'App\\Models\\Maincategory','2024-10-22 14:48:35','2024-10-22 14:48:35'),(41,NULL,3,'App\\Models\\Maincategory','2024-10-22 14:48:35','2024-10-22 14:48:35'),(42,NULL,4,'App\\Models\\Maincategory','2024-10-22 14:48:35','2024-10-22 14:48:35'),(43,NULL,5,'App\\Models\\Maincategory','2024-10-22 14:48:35','2024-10-22 14:48:35'),(44,NULL,6,'App\\Models\\Maincategory','2024-10-22 14:48:35','2024-10-22 14:48:35'),(45,NULL,7,'App\\Models\\Maincategory','2024-10-22 14:48:35','2024-10-22 14:48:35'),(46,NULL,8,'App\\Models\\Maincategory','2024-10-22 14:48:35','2024-10-22 14:48:35'),(47,NULL,9,'App\\Models\\Maincategory','2024-10-22 14:48:35','2024-10-22 14:48:35'),(48,NULL,10,'App\\Models\\Maincategory','2024-10-22 14:48:35','2024-10-22 14:48:35'),(49,NULL,11,'App\\Models\\Maincategory','2024-10-22 14:48:35','2024-10-22 14:48:35'),(50,NULL,12,'App\\Models\\Maincategory','2024-10-22 14:48:35','2024-10-22 14:48:35'),(51,NULL,13,'App\\Models\\Maincategory','2024-10-22 14:48:35','2024-10-22 14:48:35'),(52,NULL,14,'App\\Models\\Maincategory','2024-10-22 14:48:35','2024-10-22 14:48:35'),(53,NULL,15,'App\\Models\\Maincategory','2024-10-22 14:48:35','2024-10-22 14:48:35'),(54,NULL,16,'App\\Models\\Maincategory','2024-10-22 14:48:35','2024-10-22 14:48:35'),(55,NULL,17,'App\\Models\\Maincategory','2024-10-22 14:48:35','2024-10-22 14:48:35'),(56,NULL,18,'App\\Models\\Maincategory','2024-10-22 14:48:35','2024-10-22 14:48:35'),(57,NULL,19,'App\\Models\\Maincategory','2024-10-22 14:48:35','2024-10-22 14:48:35'),(58,NULL,20,'App\\Models\\Maincategory','2024-10-22 14:48:35','2024-10-22 14:48:35'),(59,NULL,21,'App\\Models\\Maincategory','2024-10-22 14:48:35','2024-10-22 14:48:35'),(60,NULL,22,'App\\Models\\Maincategory','2024-10-22 14:48:35','2024-10-22 14:48:35'),(61,NULL,23,'App\\Models\\Maincategory','2024-10-22 14:48:35','2024-10-22 14:48:35'),(62,NULL,24,'App\\Models\\Maincategory','2024-10-22 14:48:35','2024-10-22 14:48:35'),(63,NULL,25,'App\\Models\\Maincategory','2024-10-22 14:48:35','2024-10-22 14:48:35'),(64,NULL,26,'App\\Models\\Maincategory','2024-10-22 14:48:35','2024-10-22 14:48:35'),(65,NULL,27,'App\\Models\\Maincategory','2024-10-22 14:48:35','2024-10-22 14:48:35'),(66,'images/products/1.jpeg',1,'App\\Models\\Product','2024-10-22 14:48:35','2024-10-22 14:48:35'),(67,'images/products/1.1.webp',1,'App\\Models\\Product','2024-10-22 14:48:35','2024-10-22 14:48:35'),(68,'images/products/1.2.png',1,'App\\Models\\Product','2024-10-22 14:48:35','2024-10-22 14:48:35'),(69,'images/products/2.jpeg',2,'App\\Models\\Product','2024-10-22 14:48:35','2024-10-22 14:48:35'),(70,'images/products/2.1.webp',2,'App\\Models\\Product','2024-10-22 14:48:35','2024-10-22 14:48:35'),(71,'images/products/2.2.jpg',2,'App\\Models\\Product','2024-10-22 14:48:35','2024-10-22 14:48:35'),(72,'images/products/3.jpeg',3,'App\\Models\\Product','2024-10-22 14:48:35','2024-10-22 14:48:35'),(73,'images/products/3.1.jpg',3,'App\\Models\\Product','2024-10-22 14:48:35','2024-10-22 14:48:35'),(74,'images/products/3.2.webp',3,'App\\Models\\Product','2024-10-22 14:48:35','2024-10-22 14:48:35'),(75,'images/products/4.jpeg',4,'App\\Models\\Product','2024-10-22 14:48:35','2024-10-22 14:48:35'),(76,'images/products/4.1.webp',4,'App\\Models\\Product','2024-10-22 14:48:35','2024-10-22 14:48:35'),(77,'images/products/4.2.webp',4,'App\\Models\\Product','2024-10-22 14:48:35','2024-10-22 14:48:35'),(78,'images/products/5.jpeg',5,'App\\Models\\Product','2024-10-22 14:48:35','2024-10-22 14:48:35'),(79,'images/products/5.1.webp',5,'App\\Models\\Product','2024-10-22 14:48:35','2024-10-22 14:48:35'),(80,'images/products/5.2.jpg',5,'App\\Models\\Product','2024-10-22 14:48:35','2024-10-22 14:48:35'),(81,'images/products/6.jpeg',6,'App\\Models\\Product','2024-10-22 14:48:35','2024-10-22 14:48:35'),(82,'images/products/6.1.webp',6,'App\\Models\\Product','2024-10-22 14:48:35','2024-10-22 14:48:35'),(83,'images/products/6.2.webp',6,'App\\Models\\Product','2024-10-22 14:48:35','2024-10-22 14:48:35'),(84,'images/products/7.jpeg',7,'App\\Models\\Product','2024-10-22 14:48:35','2024-10-22 14:48:35'),(85,'images/products/7.1.webp',7,'App\\Models\\Product','2024-10-22 14:48:35','2024-10-22 14:48:35'),(86,'images/products/7.2.webp',7,'App\\Models\\Product','2024-10-22 14:48:35','2024-10-22 14:48:35'),(87,'images/products/8.jpeg',8,'App\\Models\\Product','2024-10-22 14:48:35','2024-10-22 14:48:35'),(88,'images/products/8.1.webp',8,'App\\Models\\Product','2024-10-22 14:48:35','2024-10-22 14:48:35'),(89,'images/products/8.2.webp',8,'App\\Models\\Product','2024-10-22 14:48:35','2024-10-22 14:48:35'),(90,'images/products/9.jpeg',9,'App\\Models\\Product','2024-10-22 14:48:35','2024-10-22 14:48:35'),(91,'images/products/9.1.webp',9,'App\\Models\\Product','2024-10-22 14:48:35','2024-10-22 14:48:35'),(92,'images/products/9.2.webp',9,'App\\Models\\Product','2024-10-22 14:48:35','2024-10-22 14:48:35'),(93,'images/products/10.jpeg',10,'App\\Models\\Product','2024-10-22 14:48:35','2024-10-22 14:48:35'),(94,'images/products/10.1.webp',10,'App\\Models\\Product','2024-10-22 14:48:35','2024-10-22 14:48:35'),(95,'images/products/10.2.jpg',10,'App\\Models\\Product','2024-10-22 14:48:35','2024-10-22 14:48:35'),(96,NULL,1,'App\\Models\\Partner','2024-10-22 14:48:35','2024-10-22 14:48:35'),(97,'images/YE92B4LXiM6QhFcQbr5YKECGaMU5k8NokXve9o1m.jpg',1,'App\\Models\\Team','2024-10-22 14:48:35','2024-10-22 14:48:35'),(98,'images/YQXLPLiQgi8H1E9YE77J3lwUX0qSOYXkHMP192Nz.png',2,'App\\Models\\Team','2024-10-22 14:48:35','2024-10-22 14:48:35'),(99,'images/pekmLKsEWdfVwDSwbG0sSIZARXfO8GavZPaoOF1D.jpg',3,'App\\Models\\Team','2024-10-22 14:48:36','2024-10-22 14:48:36'),(100,'images/w66o7ZleB0PAmRNOOiLp37gmh9iwImRphogPhjFy.webp',1,'App\\Models\\Testimonial','2024-10-22 14:48:36','2024-10-22 14:48:36'),(101,'images/w66o7ZleB0PAmRNOOiLp37gmh9iwImRphogPhjFy.webp',2,'App\\Models\\Testimonial','2024-10-22 14:48:36','2024-10-22 14:48:36'),(102,'images/w66o7ZleB0PAmRNOOiLp37gmh9iwImRphogPhjFy.webp',3,'App\\Models\\Testimonial','2024-10-22 14:48:36','2024-10-22 14:48:36'),(103,'images/blogs/1.jpeg',1,'App\\Models\\Blog','2024-10-22 14:48:36','2024-10-22 14:48:36'),(104,'images/blogs/2.jpeg',2,'App\\Models\\Blog','2024-10-22 14:48:36','2024-10-22 14:48:36'),(105,'images/blogs/3.jpeg',3,'App\\Models\\Blog','2024-10-22 14:48:36','2024-10-22 14:48:36'),(106,'images/blogs/4.jpeg',4,'App\\Models\\Blog','2024-10-22 14:48:36','2024-10-22 14:48:36'),(107,'images/blogs/5.jpeg',5,'App\\Models\\Blog','2024-10-22 14:48:36','2024-10-22 14:48:36'),(108,'images/blogs/6.jpeg',6,'App\\Models\\Blog','2024-10-22 14:48:36','2024-10-22 14:48:36'),(109,'images/blogs/7.jpeg',7,'App\\Models\\Blog','2024-10-22 14:48:36','2024-10-22 14:48:36'),(110,'images/blogs/8.jpeg',8,'App\\Models\\Blog','2024-10-22 14:48:36','2024-10-22 14:48:36'),(111,'images/blogs/9.jpeg',9,'App\\Models\\Blog','2024-10-22 14:48:36','2024-10-22 14:48:36'),(112,'images/blogs/10.jpeg',10,'App\\Models\\Blog','2024-10-22 14:48:36','2024-10-22 14:48:36'),(113,'images/gallery/1/1.1.jpeg',1,'App\\Models\\Gallery','2024-10-22 14:48:36','2024-10-22 14:48:36'),(114,'images/gallery/1/1.2.jpeg',1,'App\\Models\\Gallery','2024-10-22 14:48:36','2024-10-22 14:48:36'),(115,'images/gallery/1/1.3.jpeg',1,'App\\Models\\Gallery','2024-10-22 14:48:36','2024-10-22 14:48:36'),(116,'images/gallery/2/2.1.jpeg',2,'App\\Models\\Gallery','2024-10-22 14:48:36','2024-10-22 14:48:36'),(117,'images/gallery/2/2.2.jpeg',2,'App\\Models\\Gallery','2024-10-22 14:48:36','2024-10-22 14:48:36'),(118,'images/gallery/2/2.3.jpeg',2,'App\\Models\\Gallery','2024-10-22 14:48:36','2024-10-22 14:48:36'),(119,'images/gallery/3/3.1.jpeg',3,'App\\Models\\Gallery','2024-10-22 14:48:36','2024-10-22 14:48:36'),(120,'images/gallery/3/3.2.jpeg',3,'App\\Models\\Gallery','2024-10-22 14:48:36','2024-10-22 14:48:36'),(121,'images/gallery/3/3.3.jpeg',3,'App\\Models\\Gallery','2024-10-22 14:48:36','2024-10-22 14:48:36'),(122,'images/gallery/4/4.1.jpeg',4,'App\\Models\\Gallery','2024-10-22 14:48:36','2024-10-22 14:48:36'),(123,'images/gallery/4/4.2.jpeg',4,'App\\Models\\Gallery','2024-10-22 14:48:36','2024-10-22 14:48:36'),(124,'images/gallery/4/4.3.jpeg',4,'App\\Models\\Gallery','2024-10-22 14:48:36','2024-10-22 14:48:36'),(125,'images/gallery/5/5.1.jpeg',5,'App\\Models\\Gallery','2024-10-22 14:48:36','2024-10-22 14:48:36'),(126,'images/gallery/5/5.2.jpeg',5,'App\\Models\\Gallery','2024-10-22 14:48:36','2024-10-22 14:48:36'),(127,'images/gallery/5/5.3.jpeg',5,'App\\Models\\Gallery','2024-10-22 14:48:36','2024-10-22 14:48:36'),(128,'images/OAca39iRkr57dC4cmTGWAihmZxZ1PmSSjQnxTyfn.png',13,'App\\Models\\Product','2024-11-08 03:25:55','2024-11-08 03:25:55'),(129,'images/OVMf0dWLWmXrxzQptGJHvXneLqscjIcMM1dI62cn.png',13,'App\\Models\\Product','2024-11-08 03:25:55','2024-11-08 03:25:55'),(130,'images/RwHAeXVLPtOB2VziedExlKNjm0kOgWHjzzqnzsFm.png',13,'App\\Models\\Product','2024-11-08 03:25:55','2024-11-08 03:25:55'),(131,'images/KJXSODa9d8SzYe23qp4XoA11BwrCf7e7fN7xmjBc.png',13,'App\\Models\\Product','2024-11-08 03:25:55','2024-11-08 03:25:55'),(132,'images/HUohL43w5Ji4CCL7PkkGgQ0pcq48dZHsxWtsjoQL.png',13,'App\\Models\\Product','2024-11-08 03:25:55','2024-11-08 03:25:55'),(133,'images/DQxvC4dAhvZN8N8pDcbZ1qe65ML90QgJetqv4Mqs.png',13,'App\\Models\\Product','2024-11-08 03:25:55','2024-11-08 03:25:55'),(134,'images/6WLlLrg0Lvai3mVrRAALJsD9FnoZ9FunTlPu65Hz.png',13,'App\\Models\\Product','2024-11-08 03:25:55','2024-11-08 03:25:55');
/*!40000 ALTER TABLE `files` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `gallery`
--

DROP TABLE IF EXISTS `gallery`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `gallery` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `gallery`
--

LOCK TABLES `gallery` WRITE;
/*!40000 ALTER TABLE `gallery` DISABLE KEYS */;
INSERT INTO `gallery` VALUES (1,'2024-10-22 14:48:36','2024-10-22 14:48:36'),(2,'2024-10-22 14:48:36','2024-10-22 14:48:36'),(3,'2024-10-22 14:48:36','2024-10-22 14:48:36'),(4,'2024-10-22 14:48:36','2024-10-22 14:48:36'),(5,'2024-10-22 14:48:36','2024-10-22 14:48:36');
/*!40000 ALTER TABLE `gallery` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `gallery_translations`
--

DROP TABLE IF EXISTS `gallery_translations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `gallery_translations` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `gallery_id` bigint(20) unsigned NOT NULL,
  `locale` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `gallery_translations_gallery_id_locale_unique` (`gallery_id`,`locale`),
  KEY `gallery_translations_locale_index` (`locale`),
  CONSTRAINT `gallery_translations_gallery_id_foreign` FOREIGN KEY (`gallery_id`) REFERENCES `gallery` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `gallery_translations`
--

LOCK TABLES `gallery_translations` WRITE;
/*!40000 ALTER TABLE `gallery_translations` DISABLE KEYS */;
INSERT INTO `gallery_translations` VALUES (1,'حصاد أفضل ما في الطبيعة: تجربة GMA',1,'ar','2024-10-22 14:48:36','2024-10-22 14:48:36'),(2,'Harvesting Nature\'s Best: The GMA Experience',1,'en','2024-10-22 14:48:36','2024-10-22 14:48:36'),(3,'زرع بذور التميز: التزام GMA بالجودة',2,'ar','2024-10-22 14:48:36','2024-10-22 14:48:36'),(4,'Sowing Seeds of Excellence: GMA\'s Commitment to Quality',2,'en','2024-10-22 14:48:36','2024-10-22 14:48:36'),(5,'من المزرعة إلى المائدة: أعشاب ونباتات GMA الطازجة',3,'ar','2024-10-22 14:48:36','2024-10-22 14:48:36'),(6,'From Farm to Table: GMA\'s Fresh Herbs and Plants',3,'en','2024-10-22 14:48:36','2024-10-22 14:48:36'),(7,'تنمية التراث: إرث GMA في الزراعة',4,'ar','2024-10-22 14:48:36','2024-10-22 14:48:36'),(8,'Cultivating Tradition: GMA\'s Heritage in Agriculture',4,'en','2024-10-22 14:48:36','2024-10-22 14:48:36'),(9,'نزرع معًا: رؤية GMA للزراعة المستدامة',5,'ar','2024-10-22 14:48:36','2024-10-22 14:48:36'),(10,'Growing Together: GMA\'s Vision for Sustainable Farming',5,'en','2024-10-22 14:48:36','2024-10-22 14:48:36');
/*!40000 ALTER TABLE `gallery_translations` ENABLE KEYS */;
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
-- Table structure for table `maincategories`
--

DROP TABLE IF EXISTS `maincategories`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `maincategories` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `subcategory_id` bigint(20) unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `maincategories_subcategory_id_foreign` (`subcategory_id`),
  CONSTRAINT `maincategories_subcategory_id_foreign` FOREIGN KEY (`subcategory_id`) REFERENCES `subcategories` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=28 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `maincategories`
--

LOCK TABLES `maincategories` WRITE;
/*!40000 ALTER TABLE `maincategories` DISABLE KEYS */;
INSERT INTO `maincategories` VALUES (1,21,'2024-10-22 14:48:35','2024-10-22 14:48:35'),(2,19,'2024-10-22 14:48:35','2024-10-22 14:48:35'),(3,4,'2024-10-22 14:48:35','2024-10-22 14:48:35'),(4,5,'2024-10-22 14:48:35','2024-10-22 14:48:35'),(5,8,'2024-10-22 14:48:35','2024-10-22 14:48:35'),(6,18,'2024-10-22 14:48:35','2024-10-22 14:48:35'),(7,11,'2024-10-22 14:48:35','2024-10-22 14:48:35'),(8,12,'2024-10-22 14:48:35','2024-10-22 14:48:35'),(9,19,'2024-10-22 14:48:35','2024-10-22 14:48:35'),(10,10,'2024-10-22 14:48:35','2024-10-22 14:48:35'),(11,7,'2024-10-22 14:48:35','2024-10-22 14:48:35'),(12,2,'2024-10-22 14:48:35','2024-10-22 14:48:35'),(13,1,'2024-10-22 14:48:35','2024-10-22 14:48:35'),(14,12,'2024-10-22 14:48:35','2024-10-22 14:48:35'),(15,11,'2024-10-22 14:48:35','2024-10-22 14:48:35'),(16,24,'2024-10-22 14:48:35','2024-10-22 14:48:35'),(17,16,'2024-10-22 14:48:35','2024-10-22 14:48:35'),(18,21,'2024-10-22 14:48:35','2024-10-22 14:48:35'),(19,16,'2024-10-22 14:48:35','2024-10-22 14:48:35'),(20,22,'2024-10-22 14:48:35','2024-10-22 14:48:35'),(21,5,'2024-10-22 14:48:35','2024-10-22 14:48:35'),(22,19,'2024-10-22 14:48:35','2024-10-22 14:48:35'),(23,24,'2024-10-22 14:48:35','2024-10-22 14:48:35'),(24,18,'2024-10-22 14:48:35','2024-10-22 14:48:35'),(25,1,'2024-10-22 14:48:35','2024-10-22 14:48:35'),(26,20,'2024-10-22 14:48:35','2024-10-22 14:48:35'),(27,15,'2024-10-22 14:48:35','2024-10-22 14:48:35');
/*!40000 ALTER TABLE `maincategories` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `maincategory_translations`
--

DROP TABLE IF EXISTS `maincategory_translations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `maincategory_translations` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `locale` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `maincategory_id` bigint(20) unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `maincategory_translations_maincategory_id_locale_unique` (`maincategory_id`,`locale`),
  KEY `maincategory_translations_locale_index` (`locale`),
  CONSTRAINT `maincategory_translations_maincategory_id_foreign` FOREIGN KEY (`maincategory_id`) REFERENCES `maincategories` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=55 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `maincategory_translations`
--

LOCK TABLES `maincategory_translations` WRITE;
/*!40000 ALTER TABLE `maincategory_translations` DISABLE KEYS */;
INSERT INTO `maincategory_translations` VALUES (1,'العاب بلاي ستيشن 5','ar',1,'2024-10-22 14:48:35','2024-10-22 14:48:35'),(2,'PlayStation 5 Games','en',1,'2024-10-22 14:48:35','2024-10-22 14:48:35'),(3,'العاب بلاي ستيشن 4','ar',2,'2024-10-22 14:48:35','2024-10-22 14:48:35'),(4,'PlayStation 4 Games','en',2,'2024-10-22 14:48:35','2024-10-22 14:48:35'),(5,'العاب النينتندوا','ar',3,'2024-10-22 14:48:35','2024-10-22 14:48:35'),(6,'Nintendo Games','en',3,'2024-10-22 14:48:35','2024-10-22 14:48:35'),(7,'العاب اكس بوكس','ar',4,'2024-10-22 14:48:35','2024-10-22 14:48:35'),(8,'XBOX Games','en',4,'2024-10-22 14:48:35','2024-10-22 14:48:35'),(9,'العاب للحاسب (كمبيوتر)','ar',5,'2024-10-22 14:48:35','2024-10-22 14:48:35'),(10,'PC Games','en',5,'2024-10-22 14:48:35','2024-10-22 14:48:35'),(11,'مستعمل','ar',6,'2024-10-22 14:48:35','2024-10-22 14:48:35'),(12,'Pre-Owned Games','en',6,'2024-10-22 14:48:35','2024-10-22 14:48:35'),(13,'أجهزة بلاي ستيشن 5','ar',7,'2024-10-22 14:48:35','2024-10-22 14:48:35'),(14,'PlayStation 5 Consoles','en',7,'2024-10-22 14:48:35','2024-10-22 14:48:35'),(15,'أجهزة بلاي ستيشن 4','ar',8,'2024-10-22 14:48:35','2024-10-22 14:48:35'),(16,'PlayStation 4 Consoles','en',8,'2024-10-22 14:48:35','2024-10-22 14:48:35'),(17,'أجهزة نينتندوا سويتش','ar',9,'2024-10-22 14:48:35','2024-10-22 14:48:35'),(18,'Nintendo Switch Consoles','en',9,'2024-10-22 14:48:35','2024-10-22 14:48:35'),(19,'أجهزة اكس بوكس','ar',10,'2024-10-22 14:48:35','2024-10-22 14:48:35'),(20,'XBOX Consoles','en',10,'2024-10-22 14:48:35','2024-10-22 14:48:35'),(21,'الواقع الافتراضي (VR)','ar',11,'2024-10-22 14:48:35','2024-10-22 14:48:35'),(22,'Virtual Reality VR','en',11,'2024-10-22 14:48:35','2024-10-22 14:48:35'),(23,'مستعمل','ar',12,'2024-10-22 14:48:35','2024-10-22 14:48:35'),(24,'Pre-Owned','en',12,'2024-10-22 14:48:35','2024-10-22 14:48:35'),(25,'اكسسوارات بلاي ستيشن 5','ar',13,'2024-10-22 14:48:35','2024-10-22 14:48:35'),(26,'PlayStation 5 Accessories','en',13,'2024-10-22 14:48:35','2024-10-22 14:48:35'),(27,'اكسسوارات بلاي ستيشن 4','ar',14,'2024-10-22 14:48:35','2024-10-22 14:48:35'),(28,'PlayStation 4 Accessories','en',14,'2024-10-22 14:48:35','2024-10-22 14:48:35'),(29,'اكسسوارات نينتندوا','ar',15,'2024-10-22 14:48:35','2024-10-22 14:48:35'),(30,'Nintendo Accessories','en',15,'2024-10-22 14:48:35','2024-10-22 14:48:35'),(31,'اكسسوارات الاكس بوكس','ar',16,'2024-10-22 14:48:35','2024-10-22 14:48:35'),(32,'Xbox Accessories','en',16,'2024-10-22 14:48:35','2024-10-22 14:48:35'),(33,'وحدات التحكم','ar',17,'2024-10-22 14:48:35','2024-10-22 14:48:35'),(34,'Controllers','en',17,'2024-10-22 14:48:35','2024-10-22 14:48:35'),(35,'كراسي الألعاب','ar',18,'2024-10-22 14:48:35','2024-10-22 14:48:35'),(36,'Gaming Chairs','en',18,'2024-10-22 14:48:35','2024-10-22 14:48:35'),(37,'اجهزه وملحقات مستعمله','ar',19,'2024-10-22 14:48:35','2024-10-22 14:48:35'),(38,'Used Consoles And Accessories','en',19,'2024-10-22 14:48:35','2024-10-22 14:48:35'),(39,'العاب بلاي ستيشن 5 مستعمله','ar',20,'2024-10-22 14:48:35','2024-10-22 14:48:35'),(40,'PlayStation 5 Used Games','en',20,'2024-10-22 14:48:35','2024-10-22 14:48:35'),(41,'العاب بلاي ستيشن 4 مستعمله)','ar',21,'2024-10-22 14:48:35','2024-10-22 14:48:35'),(42,'PlayStation 4 Used Games','en',21,'2024-10-22 14:48:35','2024-10-22 14:48:35'),(43,'العاب نينتندوا مستعمله','ar',22,'2024-10-22 14:48:35','2024-10-22 14:48:35'),(44,'Nintendo Switch Used Games','en',22,'2024-10-22 14:48:35','2024-10-22 14:48:35'),(45,'ألعاب إكس بوكس مستعمله','ar',23,'2024-10-22 14:48:35','2024-10-22 14:48:35'),(46,'XBOX Used Games','en',23,'2024-10-22 14:48:35','2024-10-22 14:48:35'),(47,'فانكو بوب','ar',24,'2024-10-22 14:48:35','2024-10-22 14:48:35'),(48,'Funko Pop','en',24,'2024-10-22 14:48:35','2024-10-22 14:48:35'),(49,'مكعبات والعاب بناء','ar',25,'2024-10-22 14:48:35','2024-10-22 14:48:35'),(50,'Blocks & Building Sets','en',25,'2024-10-22 14:48:35','2024-10-22 14:48:35'),(51,'بازل - العاب الصور المقطوعة','ar',26,'2024-10-22 14:48:35','2024-10-22 14:48:35'),(52,'Puzzles','en',26,'2024-10-22 14:48:35','2024-10-22 14:48:35'),(53,'سيارات Diecast و RC','ar',27,'2024-10-22 14:48:35','2024-10-22 14:48:35'),(54,'RC & Diecast Cars','en',27,'2024-10-22 14:48:35','2024-10-22 14:48:35');
/*!40000 ALTER TABLE `maincategory_translations` ENABLE KEYS */;
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
  `email` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `phone` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `subject` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
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
INSERT INTO `messages` VALUES (1,'Ibrahim Samy','ibrahimsamy308@gmail.com','01289189890',NULL,'كيفيه عمل موقع بتكلفه اقل','2024-10-22 14:48:35','2024-10-22 14:48:35'),(2,'Kero Boula','Kero@gmail.com','0124578960',NULL,NULL,'2024-10-22 14:48:35','2024-10-22 14:48:35'),(3,'ابراهيم سامى','ibrahim@gmail.com','450015885',NULL,NULL,'2024-10-22 14:48:35','2024-10-22 14:48:35'),(4,'Raven Jacobson','picyj@mailinator.com','+1 (605) 489-9301','Voluptatem Excepteu','Quis pariatur Volup','2024-10-25 18:28:41','2024-10-25 18:28:41');
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
) ENGINE=InnoDB AUTO_INCREMENT=41 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `migrations`
--

LOCK TABLES `migrations` WRITE;
/*!40000 ALTER TABLE `migrations` DISABLE KEYS */;
INSERT INTO `migrations` VALUES (1,'2014_04_02_193005_create_translations_table',1),(2,'2014_10_12_000000_create_users_table',1),(3,'2014_10_12_100000_create_password_reset_tokens_table',1),(4,'2014_10_12_100000_create_password_resets_table',1),(5,'2019_08_19_000000_create_failed_jobs_table',1),(6,'2019_12_14_000001_create_personal_access_tokens_table',1),(7,'2022_10_21_075806_create_categories_table',1),(8,'2022_10_22_075807_create_subcategories_table',1),(9,'2022_10_22_075808_create_maincategories_table',1),(10,'2022_10_23_075806_create_blog_table',1),(11,'2022_10_23_075806_create_gallery_table',1),(12,'2022_10_23_075806_create_products_table',1),(13,'2022_10_23_075806_create_slider_table',1),(14,'2022_10_23_075806_create_testimonials_table',1),(15,'2022_10_23_075846_create_settings_table',1),(16,'2022_10_24_111948_create_partners_table',1),(17,'2022_10_24_111948_create_teams_table',1),(18,'2022_10_26_125729_create_pages_table',1),(19,'2022_10_29_155126_create_messages_table',1),(20,'2022_10_29_155126_create_newsletters_table',1),(21,'2022_10_29_155126_create_orders_table',1),(22,'2022_11_26_153759_create_orderproducts_table',1),(23,'2022_11_26_154654_create_contacts_table',1),(24,'2022_11_26_154654_create_counters_table',1),(25,'2023_06_26_124945_create_admins_table',1),(26,'2023_06_26_173744_create_permission_tables',1),(27,'2023_06_27_170717_create_blog_translations_table',1),(28,'2023_06_27_170717_create_category_translations_table',1),(29,'2023_06_27_170717_create_gallery_translations_table',1),(30,'2023_06_27_170717_create_maincategory_translations_table',1),(31,'2023_06_27_170717_create_product_translations_table',1),(32,'2023_06_27_170717_create_slider_translations_table',1),(33,'2023_06_27_170717_create_subcategory_translations_table',1),(34,'2023_06_27_170717_create_testimonial_translations_table',1),(35,'2023_06_28_105000_create_files_table',1),(36,'2023_06_28_175550_create_setting_translations_table',1),(37,'2023_06_28_180137_create_partner_translations_table',1),(38,'2023_06_28_180137_create_team_translations_table',1),(39,'2023_06_28_180243_create_page_translations_table',1),(40,'2023_06_28_180559_create_counter_translations_table',1);
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
INSERT INTO `model_has_roles` VALUES (1,'App\\Models\\Admin',1);
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
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `newsletters`
--

LOCK TABLES `newsletters` WRITE;
/*!40000 ALTER TABLE `newsletters` DISABLE KEYS */;
INSERT INTO `newsletters` VALUES (1,'ibrahimsamy308@gmail.com','2024-10-22 14:48:35','2024-10-22 14:48:35'),(2,'Kero@gmail.com','2024-10-22 14:48:35','2024-10-22 14:48:35'),(3,'ibrahim@gmail.com','2024-10-22 14:48:35','2024-10-22 14:48:35');
/*!40000 ALTER TABLE `newsletters` ENABLE KEYS */;
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
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
  `address` text COLLATE utf8mb4_unicode_ci,
  `user_id` bigint(20) unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `orders_user_id_foreign` (`user_id`),
  CONSTRAINT `orders_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `orders`
--

LOCK TABLES `orders` WRITE;
/*!40000 ALTER TABLE `orders` DISABLE KEYS */;
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
INSERT INTO `page_translations` VALUES (1,'من نحن','من المزرعة إلى المستقبل: جودة يمكنك الوثوق بها','<p>شركة GMA هي شركة رائدة في تصدير الأعشاب والنباتات والبذور. مع أكثر من 15 عامًا من الخبرة في الجودة والإنتاج والزراعة، نحن في موقع فريد يتيح لنا تقديم منتجات عالية الجودة بأسعار تنافسية. موقعنا في محافظة بني سويف، في قلب المناطق الزراعية في مصر، يسمح لنا بالحصول على أفضل المواد الخام مباشرة من المزارع. مهمتنا هي تقديم منتجات وخدمات استثنائية لعملائنا، مع ضمان رضا العملاء وتعزيز الشراكات طويلة الأمد.</p>',1,'ar','2024-10-22 14:48:35','2024-10-22 14:48:35'),(2,'About Us','From Farm to Future: Quality You Can Trust','<p>GMA is a leading company in the export of herbs, plants, and seeds. With over 15 years of experience in quality, production, and agriculture, we are uniquely positioned to deliver high-quality products at competitive prices. Our location in Beni Suef, at the heart of Egypt’s agricultural areas, allows us to source the best raw materials directly from the farms. Our mission is to provide exceptional products and service to our clients, ensuring customer satisfaction and fostering long-term partnerships.</p>',1,'en','2024-10-22 14:48:35','2024-10-22 14:48:35');
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
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `pages`
--

LOCK TABLES `pages` WRITE;
/*!40000 ALTER TABLE `pages` DISABLE KEYS */;
INSERT INTO `pages` VALUES (1,'about','2024-10-22 14:48:35','2024-10-22 14:48:35');
/*!40000 ALTER TABLE `pages` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `partner_translations`
--

DROP TABLE IF EXISTS `partner_translations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `partner_translations` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `partner_id` bigint(20) unsigned NOT NULL,
  `locale` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `partner_translations_partner_id_locale_unique` (`partner_id`,`locale`),
  KEY `partner_translations_locale_index` (`locale`),
  CONSTRAINT `partner_translations_partner_id_foreign` FOREIGN KEY (`partner_id`) REFERENCES `partners` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `partner_translations`
--

LOCK TABLES `partner_translations` WRITE;
/*!40000 ALTER TABLE `partner_translations` DISABLE KEYS */;
INSERT INTO `partner_translations` VALUES (1,NULL,1,'ar','2024-10-22 14:48:35','2024-10-22 14:48:35'),(2,NULL,1,'en','2024-10-22 14:48:35','2024-10-22 14:48:35');
/*!40000 ALTER TABLE `partner_translations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `partners`
--

DROP TABLE IF EXISTS `partners`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `partners` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `partners`
--

LOCK TABLES `partners` WRITE;
/*!40000 ALTER TABLE `partners` DISABLE KEYS */;
INSERT INTO `partners` VALUES (1,'2024-10-22 14:48:35','2024-10-22 14:48:35');
/*!40000 ALTER TABLE `partners` ENABLE KEYS */;
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
) ENGINE=InnoDB AUTO_INCREMENT=45 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `permissions`
--

LOCK TABLES `permissions` WRITE;
/*!40000 ALTER TABLE `permissions` DISABLE KEYS */;
INSERT INTO `permissions` VALUES (1,'role-list','admin','2024-10-22 14:48:35','2024-10-22 14:48:35'),(2,'role-create','admin','2024-10-22 14:48:35','2024-10-22 14:48:35'),(3,'role-edit','admin','2024-10-22 14:48:35','2024-10-22 14:48:35'),(4,'role-delete','admin','2024-10-22 14:48:35','2024-10-22 14:48:35'),(5,'product-list','admin','2024-10-22 14:48:35','2024-10-22 14:48:35'),(6,'product-create','admin','2024-10-22 14:48:35','2024-10-22 14:48:35'),(7,'product-edit','admin','2024-10-22 14:48:35','2024-10-22 14:48:35'),(8,'product-delete','admin','2024-10-22 14:48:35','2024-10-22 14:48:35'),(9,'slider-list','admin','2024-10-22 14:48:35','2024-10-22 14:48:35'),(10,'slider-create','admin','2024-10-22 14:48:35','2024-10-22 14:48:35'),(11,'slider-edit','admin','2024-10-22 14:48:35','2024-10-22 14:48:35'),(12,'slider-delete','admin','2024-10-22 14:48:35','2024-10-22 14:48:35'),(13,'contact-list','admin','2024-10-22 14:48:35','2024-10-22 14:48:35'),(14,'contact-create','admin','2024-10-22 14:48:35','2024-10-22 14:48:35'),(15,'contact-edit','admin','2024-10-22 14:48:35','2024-10-22 14:48:35'),(16,'contact-delete','admin','2024-10-22 14:48:35','2024-10-22 14:48:35'),(17,'image-list','admin','2024-10-22 14:48:35','2024-10-22 14:48:35'),(18,'image-create','admin','2024-10-22 14:48:35','2024-10-22 14:48:35'),(19,'image-edit','admin','2024-10-22 14:48:35','2024-10-22 14:48:35'),(20,'image-delete','admin','2024-10-22 14:48:35','2024-10-22 14:48:35'),(21,'page-list','admin','2024-10-22 14:48:35','2024-10-22 14:48:35'),(22,'page-edit','admin','2024-10-22 14:48:35','2024-10-22 14:48:35'),(23,'setting-list','admin','2024-10-22 14:48:35','2024-10-22 14:48:35'),(24,'setting-create','admin','2024-10-22 14:48:35','2024-10-22 14:48:35'),(25,'setting-edit','admin','2024-10-22 14:48:35','2024-10-22 14:48:35'),(26,'setting-delete','admin','2024-10-22 14:48:35','2024-10-22 14:48:35'),(27,'admin-list','admin','2024-10-22 14:48:35','2024-10-22 14:48:35'),(28,'admin-create','admin','2024-10-22 14:48:35','2024-10-22 14:48:35'),(29,'admin-edit','admin','2024-10-22 14:48:35','2024-10-22 14:48:35'),(30,'admin-delete','admin','2024-10-22 14:48:35','2024-10-22 14:48:35'),(31,'message-list','admin','2024-10-22 14:48:35','2024-10-22 14:48:35'),(32,'message-delete','admin','2024-10-22 14:48:35','2024-10-22 14:48:35'),(33,'message-reply','admin','2024-10-22 14:48:35','2024-10-22 14:48:35'),(34,'newsletter-list','admin','2024-10-22 14:48:35','2024-10-22 14:48:35'),(35,'newsletter-delete','admin','2024-10-22 14:48:35','2024-10-22 14:48:35'),(36,'newsletter-reply','admin','2024-10-22 14:48:35','2024-10-22 14:48:35'),(37,'blog-list','admin','2024-10-22 14:48:35','2024-10-22 14:48:35'),(38,'blog-create','admin','2024-10-22 14:48:35','2024-10-22 14:48:35'),(39,'blog-edit','admin','2024-10-22 14:48:35','2024-10-22 14:48:35'),(40,'blog-delete','admin','2024-10-22 14:48:35','2024-10-22 14:48:35'),(41,'gallery-list','admin','2024-10-22 14:48:35','2024-10-22 14:48:35'),(42,'gallery-create','admin','2024-10-22 14:48:35','2024-10-22 14:48:35'),(43,'gallery-edit','admin','2024-10-22 14:48:35','2024-10-22 14:48:35'),(44,'gallery-delete','admin','2024-10-22 14:48:35','2024-10-22 14:48:35');
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
-- Table structure for table `product_translations`
--

DROP TABLE IF EXISTS `product_translations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `product_translations` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `subtitle` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `product_id` bigint(20) unsigned NOT NULL,
  `locale` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `product_translations_product_id_locale_unique` (`product_id`,`locale`),
  KEY `product_translations_locale_index` (`locale`),
  CONSTRAINT `product_translations_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=23 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `product_translations`
--

LOCK TABLES `product_translations` WRITE;
/*!40000 ALTER TABLE `product_translations` DISABLE KEYS */;
INSERT INTO `product_translations` VALUES (1,'زهور البابونج','استرخاء طبيعي','<p>معروف بخصائصه المهدئة، يتم حصاد زهور البابونج وتجفيفها بعناية للحفاظ على جودتها الطبيعية. مثالي للشاي والزيوت ومنتجات العناية بالبشرة.</p>',1,'ar','2024-10-22 14:48:35','2024-10-22 14:48:35'),(2,'Chamomile Flowers','Natural Relaxation','<p>Known for its calming properties, our chamomile flowers are carefully harvested and dried to preserve their natural qualities. Ideal for teas, oils, and skin care products.</p>',1,'en','2024-10-22 14:48:35','2024-10-22 14:48:35'),(3,'أوراق النعناع','رائحة منعشة','<p>أوراق النعناع لدينا توفر نكهة منعشة ورائحة مميزة. مثالية للاستخدام في شاي الأعشاب والزيوت العطرية والأطباق.</p>',2,'ar','2024-10-22 14:48:35','2024-10-22 14:48:35'),(4,'Peppermint Leaves','Refreshing Aroma','<p>Our peppermint leaves provide a refreshing flavor and aroma. Perfect for use in herbal teas, essential oils, and culinary dishes.</p>',2,'en','2024-10-22 14:48:35','2024-10-22 14:48:35'),(5,'بذور الريحان','غنى بالعناصر الغذائية','<p>بذور الريحان عالية الجودة غنية بالألياف ومضادات الأكسدة، مثالية للترطيب ويمكن إضافتها للعصائر أو الحلويات.</p>',3,'ar','2024-10-22 14:48:35','2024-10-22 14:48:35'),(6,'Basil Seeds','Nutrient-Rich Goodness','<p>High-quality basil seeds, rich in fiber and antioxidants, are excellent for hydration and can be added to smoothies or desserts.</p>',3,'en','2024-10-22 14:48:35','2024-10-22 14:48:35'),(7,'الكركديه المجفف','طعم لاذع ومميز','<p>زهور الكركديه لدينا تم حصادها في أوج تفتحها، وتقدم نكهة غنية ولاذعة مثالية للشاي والمشروبات والتلوين الطبيعي.</p>',4,'ar','2024-10-22 14:48:35','2024-10-22 14:48:35'),(8,'Dried Hibiscus','Tart and Flavorful','<p>Our hibiscus flowers are harvested at peak bloom, offering a rich, tart flavor ideal for teas, beverages, and natural colorings.</p>',4,'en','2024-10-22 14:48:35','2024-10-22 14:48:35'),(9,'بذور الحلبة','فوائد صحية في كل بذور','<p>غنية بالعناصر الغذائية ومعروفة بخصائصها العلاجية، بذور الحلبة لدينا مثالية للاستخدامات الصحية والطهي.</p>',5,'ar','2024-10-22 14:48:35','2024-10-22 14:48:35'),(10,'Fenugreek Seeds','Health Benefits in Every Seed','<p>Rich in nutrients and known for their medicinal properties, our fenugreek seeds are perfect for both culinary and health applications.</p>',5,'en','2024-10-22 14:48:35','2024-10-22 14:48:35'),(11,'بذور الكزبرة','أساسي للطهي','<p>مكون أساسي في المطبخ الشرق أوسطي والمتوسطي، بذور الكزبرة لدينا طازجة وتحتفظ بنكهتها القوية.</p>',6,'ar','2024-10-22 14:48:35','2024-10-22 14:48:35'),(12,'Coriander Seeds','Culinary Essential','<p>A staple in Middle Eastern and Mediterranean cuisine, our coriander seeds are freshly sourced to retain their robust flavor.</p>',6,'en','2024-10-22 14:48:35','2024-10-22 14:48:35'),(13,'بذور الكمون','دافئ وترابي','<p>بذور الكمون لدينا ذات رائحة قوية وتوفر نكهة دافئة وترابية مثالية لتتبيل الأطباق أو إنتاج الزيوت العطرية.</p>',7,'ar','2024-10-22 14:48:35','2024-10-22 14:48:35'),(14,'Cumin Seeds','Warm and Earthy','<p>Our cumin seeds are highly aromatic, offering a warm, earthy flavor ideal for seasoning dishes or producing essential oils.</p>',7,'en','2024-10-22 14:48:35','2024-10-22 14:48:35'),(15,'بذور الشمر','مساعد للهضم','<p>حلوة وعطرية، بذور الشمر لدينا مثالية لشاي الهضم والاستخدامات الطهي أو كمُنعش للنفس.</p>',8,'ar','2024-10-22 14:48:35','2024-10-22 14:48:35'),(16,'Fennel Seeds','Digestive Aid','<p>Sweet and aromatic, our fennel seeds are perfect for digestive teas, culinary uses, or as a breath freshener.</p>',8,'en','2024-10-22 14:48:35','2024-10-22 14:48:35'),(17,'الميرمية المجففة','نكهة ترابية لأطباقك','<p>تم تجفيف الميرمية بعناية للحفاظ على نكهتها الترابية، مثالية للشاي أو العلاج العطري أو لإضافة عمق في الأطباق.</p>',9,'ar','2024-10-22 14:48:35','2024-10-22 14:48:35'),(18,'Dried Sage','Earthy Flavor for Your Dishes','<p>Carefully dried to preserve its earthy flavor, our sage is perfect for teas, aromatherapy, or adding depth to culinary dishes.</p>',9,'en','2024-10-22 14:48:35','2024-10-22 14:48:35'),(19,'بلسم الليمون','مهدئ ومريح','<p>يتميز بلسم الليمون بخصائصه الطبيعية المهدئة والعطرية، مثالي للشاي والعلاجات العشبية لتخفيف التوتر وتعزيز الاسترخاء.</p>',10,'ar','2024-10-22 14:48:35','2024-10-22 14:48:35'),(20,'Lemon Balm','Soothing and Calming','<p>Naturally soothing and aromatic, our lemon balm is ideal for teas and herbal remedies to relieve stress and promote relaxation.</p>',10,'en','2024-10-22 14:48:35','2024-10-22 14:48:35'),(21,'Yanson',NULL,'Herbals drink for recovery from disases',13,'en','2024-11-08 03:25:55','2024-11-08 03:25:55'),(22,'ينسون',NULL,'اعشاب مشاريب للشفاء من الامراض',13,'ar','2024-11-08 03:25:55','2024-11-08 03:25:55');
/*!40000 ALTER TABLE `product_translations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `products`
--

DROP TABLE IF EXISTS `products`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `products` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `price` double DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `products`
--

LOCK TABLES `products` WRITE;
/*!40000 ALTER TABLE `products` DISABLE KEYS */;
INSERT INTO `products` VALUES (1,59,'2024-10-22 14:48:35','2024-10-22 14:48:35'),(2,283,'2024-10-22 14:48:35','2024-10-22 14:48:35'),(3,55,'2024-10-22 14:48:35','2024-10-22 14:48:35'),(4,194,'2024-10-22 14:48:35','2024-10-22 14:48:35'),(5,185,'2024-10-22 14:48:35','2024-10-22 14:48:35'),(6,251,'2024-10-22 14:48:35','2024-10-22 14:48:35'),(7,136,'2024-10-22 14:48:35','2024-10-22 14:48:35'),(8,223,'2024-10-22 14:48:35','2024-10-22 14:48:35'),(9,224,'2024-10-22 14:48:35','2024-10-22 14:48:35'),(10,174,'2024-10-22 14:48:35','2024-10-22 14:48:35'),(11,1,'2024-10-29 15:04:18','2024-10-29 15:04:18'),(12,1,'2024-10-29 15:04:33','2024-10-29 15:04:33'),(13,50,'2024-11-08 03:25:55','2024-11-08 03:25:55');
/*!40000 ALTER TABLE `products` ENABLE KEYS */;
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
INSERT INTO `role_has_permissions` VALUES (1,1),(2,1),(3,1),(4,1),(5,1),(6,1),(7,1),(8,1),(9,1),(10,1),(11,1),(12,1),(13,1),(14,1),(15,1),(16,1),(17,1),(18,1),(19,1),(20,1),(21,1),(22,1),(23,1),(24,1),(25,1),(26,1),(27,1),(28,1),(29,1),(30,1),(31,1),(32,1),(33,1),(34,1),(35,1),(36,1),(37,1),(38,1),(39,1),(40,1),(41,1),(42,1),(43,1),(44,1);
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
INSERT INTO `roles` VALUES (1,'Admin','admin','2024-10-22 14:48:35','2024-10-22 14:48:35');
/*!40000 ALTER TABLE `roles` ENABLE KEYS */;
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
  `setting_id` bigint(20) unsigned NOT NULL,
  `locale` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `setting_translations_setting_id_locale_unique` (`setting_id`,`locale`),
  KEY `setting_translations_locale_index` (`locale`),
  CONSTRAINT `setting_translations_setting_id_foreign` FOREIGN KEY (`setting_id`) REFERENCES `settings` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `setting_translations`
--

LOCK TABLES `setting_translations` WRITE;
/*!40000 ALTER TABLE `setting_translations` DISABLE KEYS */;
INSERT INTO `setting_translations` VALUES (1,'Beni Suef','GMA','We are GMA, a company specialized in exporting herbs, plants, and seeds. With over 15 years of experience, we are committed to providing high-quality products at competitive prices.',': 24/7','Copyright reserved by GMA © 2024','Herbs, Plants, and Seeds Export Company',1,'en','2024-10-22 14:48:35','2024-10-22 14:48:35'),(2,'بني سويف','GMA','نحن شركة GMA متخصصة في تصدير الأعشاب والنباتات والبذور. لدينا أكثر من 15 عامًا من الخبرة وملتزمون بتوفير منتجات عالية الجودة بأسعار تنافسية.',': 24/7','جميع الحقوق محفوظة لدي GMA © 2024','شركة تصدير الأعشاب والنباتات والبذور',1,'ar','2024-10-22 14:48:35','2024-10-22 14:48:35');
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
  `breadcrump` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `map` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `settings`
--

LOCK TABLES `settings` WRITE;
/*!40000 ALTER TABLE `settings` DISABLE KEYS */;
INSERT INTO `settings` VALUES (1,'images/gmalogo.png','images/gmalogo.png','images/gmalogo.png','images/breadcrump.png','image','<iframe src=\"https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d55275.18948853619!2d31.18964315!3d30.016788299999998!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x1458469235579697%3A0x4e91d61f9878fc52!2sGiza%2C%20El%20Omraniya%2C%20Giza%20Governorate!5e0!3m2!1sen!2seg!4v1695471231297!5m2!1sen!2seg\" width=\"600\" height=\"450\" style=\"border:0;\" allowfullscreen=\"\" loading=\"lazy\" referrerpolicy=\"no-referrer-when-downgrade\"></iframe>','2024-10-22 14:48:35','2024-10-22 14:48:35');
/*!40000 ALTER TABLE `settings` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `slider`
--

DROP TABLE IF EXISTS `slider`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `slider` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `slider`
--

LOCK TABLES `slider` WRITE;
/*!40000 ALTER TABLE `slider` DISABLE KEYS */;
INSERT INTO `slider` VALUES (1,'2024-10-22 14:48:35','2024-10-22 14:48:35'),(2,'2024-10-22 14:48:35','2024-10-22 14:48:35'),(3,'2024-10-22 14:48:35','2024-10-22 14:48:35');
/*!40000 ALTER TABLE `slider` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `slider_translations`
--

DROP TABLE IF EXISTS `slider_translations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `slider_translations` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `subtitle` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `slider_id` bigint(20) unsigned NOT NULL,
  `locale` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `slider_translations_slider_id_locale_unique` (`slider_id`,`locale`),
  KEY `slider_translations_locale_index` (`locale`),
  CONSTRAINT `slider_translations_slider_id_foreign` FOREIGN KEY (`slider_id`) REFERENCES `slider` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `slider_translations`
--

LOCK TABLES `slider_translations` WRITE;
/*!40000 ALTER TABLE `slider_translations` DISABLE KEYS */;
INSERT INTO `slider_translations` VALUES (1,'اختبر أفضل جودة للأعشاب والبذور','أكثر من 15 عامًا من الخبرة في الزراعة والجودة',1,'ar','2024-10-22 14:48:35','2024-10-22 14:48:35'),(2,'Experience the Best Quality Herbs and Seeds','15+ Years of Experience in Agricultural Excellence',1,'en','2024-10-22 14:48:35','2024-10-22 14:48:35'),(3,'أسعار مناسبة لمنتجات مميزة','نقدم أسعارًا تنافسية دون المساس بالجودة',2,'ar','2024-10-22 14:48:35','2024-10-22 14:48:35'),(4,'Affordable Prices for Premium Products','Providing Competitive Prices Without Compromising Quality',2,'en','2024-10-22 14:48:35','2024-10-22 14:48:35'),(5,'رضا العملاء هو أولويتنا','نحن نقدر عملائنا ونسعى لتجاوز توقعاتهم',3,'ar','2024-10-22 14:48:35','2024-10-22 14:48:35'),(6,'Your Satisfaction is Our Priority','We Value Our Clients and Aim to Exceed Expectations',3,'en','2024-10-22 14:48:35','2024-10-22 14:48:35');
/*!40000 ALTER TABLE `slider_translations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `subcategories`
--

DROP TABLE IF EXISTS `subcategories`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `subcategories` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `category_id` bigint(20) unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `subcategories_category_id_foreign` (`category_id`),
  CONSTRAINT `subcategories_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=28 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `subcategories`
--

LOCK TABLES `subcategories` WRITE;
/*!40000 ALTER TABLE `subcategories` DISABLE KEYS */;
INSERT INTO `subcategories` VALUES (1,1,'2024-10-22 14:48:35','2024-10-22 14:48:35'),(2,1,'2024-10-22 14:48:35','2024-10-22 14:48:35'),(3,1,'2024-10-22 14:48:35','2024-10-22 14:48:35'),(4,1,'2024-10-22 14:48:35','2024-10-22 14:48:35'),(5,1,'2024-10-22 14:48:35','2024-10-22 14:48:35'),(6,1,'2024-10-22 14:48:35','2024-10-22 14:48:35'),(7,2,'2024-10-22 14:48:35','2024-10-22 14:48:35'),(8,2,'2024-10-22 14:48:35','2024-10-22 14:48:35'),(9,2,'2024-10-22 14:48:35','2024-10-22 14:48:35'),(10,2,'2024-10-22 14:48:35','2024-10-22 14:48:35'),(11,2,'2024-10-22 14:48:35','2024-10-22 14:48:35'),(12,2,'2024-10-22 14:48:35','2024-10-22 14:48:35'),(13,3,'2024-10-22 14:48:35','2024-10-22 14:48:35'),(14,3,'2024-10-22 14:48:35','2024-10-22 14:48:35'),(15,3,'2024-10-22 14:48:35','2024-10-22 14:48:35'),(16,3,'2024-10-22 14:48:35','2024-10-22 14:48:35'),(17,3,'2024-10-22 14:48:35','2024-10-22 14:48:35'),(18,3,'2024-10-22 14:48:35','2024-10-22 14:48:35'),(19,4,'2024-10-22 14:48:35','2024-10-22 14:48:35'),(20,4,'2024-10-22 14:48:35','2024-10-22 14:48:35'),(21,4,'2024-10-22 14:48:35','2024-10-22 14:48:35'),(22,4,'2024-10-22 14:48:35','2024-10-22 14:48:35'),(23,4,'2024-10-22 14:48:35','2024-10-22 14:48:35'),(24,4,'2024-10-22 14:48:35','2024-10-22 14:48:35'),(25,5,'2024-10-22 14:48:35','2024-10-22 14:48:35'),(26,5,'2024-10-22 14:48:35','2024-10-22 14:48:35'),(27,5,'2024-10-22 14:48:35','2024-10-22 14:48:35');
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
  `locale` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `subcategory_id` bigint(20) unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `subcategory_translations_subcategory_id_locale_unique` (`subcategory_id`,`locale`),
  KEY `subcategory_translations_locale_index` (`locale`),
  CONSTRAINT `subcategory_translations_subcategory_id_foreign` FOREIGN KEY (`subcategory_id`) REFERENCES `subcategories` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=55 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `subcategory_translations`
--

LOCK TABLES `subcategory_translations` WRITE;
/*!40000 ALTER TABLE `subcategory_translations` DISABLE KEYS */;
INSERT INTO `subcategory_translations` VALUES (1,'العاب بلاي ستيشن 5','ar',1,'2024-10-22 14:48:35','2024-10-22 14:48:35'),(2,'PlayStation 5 Games','en',1,'2024-10-22 14:48:35','2024-10-22 14:48:35'),(3,'العاب بلاي ستيشن 4','ar',2,'2024-10-22 14:48:35','2024-10-22 14:48:35'),(4,'PlayStation 4 Games','en',2,'2024-10-22 14:48:35','2024-10-22 14:48:35'),(5,'العاب النينتندوا','ar',3,'2024-10-22 14:48:35','2024-10-22 14:48:35'),(6,'Nintendo Games','en',3,'2024-10-22 14:48:35','2024-10-22 14:48:35'),(7,'العاب اكس بوكس','ar',4,'2024-10-22 14:48:35','2024-10-22 14:48:35'),(8,'XBOX Games','en',4,'2024-10-22 14:48:35','2024-10-22 14:48:35'),(9,'العاب للحاسب (كمبيوتر)','ar',5,'2024-10-22 14:48:35','2024-10-22 14:48:35'),(10,'PC Games','en',5,'2024-10-22 14:48:35','2024-10-22 14:48:35'),(11,'مستعمل','ar',6,'2024-10-22 14:48:35','2024-10-22 14:48:35'),(12,'Pre-Owned Games','en',6,'2024-10-22 14:48:35','2024-10-22 14:48:35'),(13,'أجهزة بلاي ستيشن 5','ar',7,'2024-10-22 14:48:35','2024-10-22 14:48:35'),(14,'PlayStation 5 Consoles','en',7,'2024-10-22 14:48:35','2024-10-22 14:48:35'),(15,'أجهزة بلاي ستيشن 4','ar',8,'2024-10-22 14:48:35','2024-10-22 14:48:35'),(16,'PlayStation 4 Consoles','en',8,'2024-10-22 14:48:35','2024-10-22 14:48:35'),(17,'أجهزة نينتندوا سويتش','ar',9,'2024-10-22 14:48:35','2024-10-22 14:48:35'),(18,'Nintendo Switch Consoles','en',9,'2024-10-22 14:48:35','2024-10-22 14:48:35'),(19,'أجهزة اكس بوكس','ar',10,'2024-10-22 14:48:35','2024-10-22 14:48:35'),(20,'XBOX Consoles','en',10,'2024-10-22 14:48:35','2024-10-22 14:48:35'),(21,'الواقع الافتراضي (VR)','ar',11,'2024-10-22 14:48:35','2024-10-22 14:48:35'),(22,'Virtual Reality VR','en',11,'2024-10-22 14:48:35','2024-10-22 14:48:35'),(23,'مستعمل','ar',12,'2024-10-22 14:48:35','2024-10-22 14:48:35'),(24,'Pre-Owned','en',12,'2024-10-22 14:48:35','2024-10-22 14:48:35'),(25,'اكسسوارات بلاي ستيشن 5','ar',13,'2024-10-22 14:48:35','2024-10-22 14:48:35'),(26,'PlayStation 5 Accessories','en',13,'2024-10-22 14:48:35','2024-10-22 14:48:35'),(27,'اكسسوارات بلاي ستيشن 4','ar',14,'2024-10-22 14:48:35','2024-10-22 14:48:35'),(28,'PlayStation 4 Accessories','en',14,'2024-10-22 14:48:35','2024-10-22 14:48:35'),(29,'اكسسوارات نينتندوا','ar',15,'2024-10-22 14:48:35','2024-10-22 14:48:35'),(30,'Nintendo Accessories','en',15,'2024-10-22 14:48:35','2024-10-22 14:48:35'),(31,'اكسسوارات الاكس بوكس','ar',16,'2024-10-22 14:48:35','2024-10-22 14:48:35'),(32,'Xbox Accessories','en',16,'2024-10-22 14:48:35','2024-10-22 14:48:35'),(33,'وحدات التحكم','ar',17,'2024-10-22 14:48:35','2024-10-22 14:48:35'),(34,'Controllers','en',17,'2024-10-22 14:48:35','2024-10-22 14:48:35'),(35,'كراسي الألعاب','ar',18,'2024-10-22 14:48:35','2024-10-22 14:48:35'),(36,'Gaming Chairs','en',18,'2024-10-22 14:48:35','2024-10-22 14:48:35'),(37,'اجهزه وملحقات مستعمله','ar',19,'2024-10-22 14:48:35','2024-10-22 14:48:35'),(38,'Used Consoles And Accessories','en',19,'2024-10-22 14:48:35','2024-10-22 14:48:35'),(39,'العاب بلاي ستيشن 5 مستعمله','ar',20,'2024-10-22 14:48:35','2024-10-22 14:48:35'),(40,'PlayStation 5 Used Games','en',20,'2024-10-22 14:48:35','2024-10-22 14:48:35'),(41,'العاب بلاي ستيشن 4 مستعمله)','ar',21,'2024-10-22 14:48:35','2024-10-22 14:48:35'),(42,'PlayStation 4 Used Games','en',21,'2024-10-22 14:48:35','2024-10-22 14:48:35'),(43,'العاب نينتندوا مستعمله','ar',22,'2024-10-22 14:48:35','2024-10-22 14:48:35'),(44,'Nintendo Switch Used Games','en',22,'2024-10-22 14:48:35','2024-10-22 14:48:35'),(45,'ألعاب إكس بوكس مستعمله','ar',23,'2024-10-22 14:48:35','2024-10-22 14:48:35'),(46,'XBOX Used Games','en',23,'2024-10-22 14:48:35','2024-10-22 14:48:35'),(47,'فانكو بوب','ar',24,'2024-10-22 14:48:35','2024-10-22 14:48:35'),(48,'Funko Pop','en',24,'2024-10-22 14:48:35','2024-10-22 14:48:35'),(49,'مكعبات والعاب بناء','ar',25,'2024-10-22 14:48:35','2024-10-22 14:48:35'),(50,'Blocks & Building Sets','en',25,'2024-10-22 14:48:35','2024-10-22 14:48:35'),(51,'بازل - العاب الصور المقطوعة','ar',26,'2024-10-22 14:48:35','2024-10-22 14:48:35'),(52,'Puzzles','en',26,'2024-10-22 14:48:35','2024-10-22 14:48:35'),(53,'سيارات Diecast و RC','ar',27,'2024-10-22 14:48:35','2024-10-22 14:48:35'),(54,'RC & Diecast Cars','en',27,'2024-10-22 14:48:35','2024-10-22 14:48:35');
/*!40000 ALTER TABLE `subcategory_translations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `team_translations`
--

DROP TABLE IF EXISTS `team_translations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `team_translations` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `subtitle` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `team_id` bigint(20) unsigned NOT NULL,
  `locale` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `team_translations_team_id_locale_unique` (`team_id`,`locale`),
  KEY `team_translations_locale_index` (`locale`),
  CONSTRAINT `team_translations_team_id_foreign` FOREIGN KEY (`team_id`) REFERENCES `teams` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `team_translations`
--

LOCK TABLES `team_translations` WRITE;
/*!40000 ALTER TABLE `team_translations` DISABLE KEYS */;
INSERT INTO `team_translations` VALUES (1,'بولا نسيم','لاعب',NULL,1,'ar','2024-10-22 14:48:35','2024-10-22 14:48:35'),(2,'Boula Nessim','Gammer',NULL,1,'en','2024-10-22 14:48:35','2024-10-22 14:48:35'),(3,'ابراهيم سامى','لاعب',NULL,2,'ar','2024-10-22 14:48:35','2024-10-22 14:48:35'),(4,'Ibrahim Samy','Gammer',NULL,2,'en','2024-10-22 14:48:35','2024-10-22 14:48:35'),(5,'جرجس مكرم','لاعب',NULL,3,'ar','2024-10-22 14:48:35','2024-10-22 14:48:35'),(6,'Gerges Makram','Gammer',NULL,3,'en','2024-10-22 14:48:35','2024-10-22 14:48:35');
/*!40000 ALTER TABLE `team_translations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `teams`
--

DROP TABLE IF EXISTS `teams`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `teams` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `facebook` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `twitter` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `instagram` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `linkedin` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `teams`
--

LOCK TABLES `teams` WRITE;
/*!40000 ALTER TABLE `teams` DISABLE KEYS */;
INSERT INTO `teams` VALUES (1,'https://www.facebook.com','https://www.twitter.com','https://www.instagram.com','https://www.linkedin.com','2024-10-22 14:48:35','2024-10-22 14:48:35'),(2,'https://www.facebook.com','https://www.twitter.com','https://www.instagram.com','https://www.linkedin.com','2024-10-22 14:48:35','2024-10-22 14:48:35'),(3,'https://www.facebook.com','https://www.twitter.com','https://www.instagram.com','https://www.linkedin.com','2024-10-22 14:48:35','2024-10-22 14:48:35');
/*!40000 ALTER TABLE `teams` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `testimonial_translations`
--

DROP TABLE IF EXISTS `testimonial_translations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `testimonial_translations` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `subtitle` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `testimonial_id` bigint(20) unsigned NOT NULL,
  `locale` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `testimonial_translations_testimonial_id_locale_unique` (`testimonial_id`,`locale`),
  KEY `testimonial_translations_locale_index` (`locale`),
  CONSTRAINT `testimonial_translations_testimonial_id_foreign` FOREIGN KEY (`testimonial_id`) REFERENCES `testimonials` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `testimonial_translations`
--

LOCK TABLES `testimonial_translations` WRITE;
/*!40000 ALTER TABLE `testimonial_translations` DISABLE KEYS */;
INSERT INTO `testimonial_translations` VALUES (1,'عمر محمد','العميل، الولايات المتحدة الأمريكية','<p>لا أستطيع أن أقول ما يكفي عن الاختيار والخدمة المذهلة في العالمية. لديهم كل ما يمكن أن يرغب فيه لاعب متحمس مثلي. لقد كنت عميلاً مخلصًا لسنوات، ولم يخيب ظني أبدًا!</p>',1,'ar','2024-10-22 14:48:36','2024-10-22 14:48:36'),(2,'Omar Mohamed','Customer,USA','<p>I can\'t say enough about the incredible selection and service at EL Alamia. They have everything a passionate gamer like me could ever want. I\'ve been a loyal customer for years, and they never disappoint!</p>',1,'en','2024-10-22 14:48:36','2024-10-22 14:48:36'),(3,' داليا سمير','العميل، الولايات المتحدة الأمريكية','<p>لقد أذهلني فريق العمل الودود وذو الخبرة في العالمية. لقد ساعدوني في العثور على اللعبة المثالية لعيد ميلاد ابني، وكانت توصياتهم في محلها. شكرًا لك على جعل تجربة التسوق ممتعة للغاية!</p>',2,'ar','2024-10-22 14:48:36','2024-10-22 14:48:36'),(4,'Dalia Samir','Customer,USA','<p>I was blown away by the knowledgeable and friendly staff at EL Alamia. They helped me find the perfect game for my son\'s birthday, and their recommendations were spot on. Thank you for making the shopping experience so enjoyable!</p>',2,'en','2024-10-22 14:48:36','2024-10-22 14:48:36'),(5,'ايميلى','العميل، الولايات المتحدة الأمريكية','<p>لقد اكتشفت مؤخرًا العالمية، وأصبح المكان الذي أقصده لكل ما يتعلق بالألعاب. المتجر منظم جيدًا، والموظفون متعاونون بشكل لا يصدق. إنهم يبذلون قصارى جهدهم لضمان العثور على الألعاب التي أبحث عنها أبحث عنه. إنها حقًا جنة اللاعب!</p>',3,'ar','2024-10-22 14:48:36','2024-10-22 14:48:36'),(6,'Emily','Customer,USA','<p>As an avid gamer, I\'ve visited many gaming stores, but EL Alamia stands out from the rest. Their attention to detail, competitive prices, and the overall atmosphere make it a haven for gamers. I highly recommend it to anyone in search of their next gaming adventure</p>',3,'en','2024-10-22 14:48:36','2024-10-22 14:48:36');
/*!40000 ALTER TABLE `testimonial_translations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `testimonials`
--

DROP TABLE IF EXISTS `testimonials`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `testimonials` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `testimonials`
--

LOCK TABLES `testimonials` WRITE;
/*!40000 ALTER TABLE `testimonials` DISABLE KEYS */;
INSERT INTO `testimonials` VALUES (1,'2024-10-22 14:48:36','2024-10-22 14:48:36'),(2,'2024-10-22 14:48:36','2024-10-22 14:48:36'),(3,'2024-10-22 14:48:36','2024-10-22 14:48:36');
/*!40000 ALTER TABLE `testimonials` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `users` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (1,'Ibrahim Samy','ibrahimsamy308@gmail.com',NULL,NULL,'$2y$10$KAqsx.UcnZHX6nJgEd68ouCiWntvdXNNJiwqiJABajmfiQQLCEPK2',NULL,'2024-10-22 14:48:36','2024-10-22 14:48:36'),(2,'Keroles Fouad','Kero@gmail.com',NULL,NULL,'$2y$10$dpSDk2SATRtBlYmEWB1mQO7MGwysnCstiPRLpS0hHxC6.3WMzvr9K',NULL,'2024-10-22 14:48:36','2024-10-22 14:48:36'),(3,'ابراهيم سامى','ibrahim@gmail.com',NULL,NULL,'$2y$10$oe95PaYr8kEq8woakN1uaeq4AF/T5/F7zhEEMTq99MQ9QFJhfWgJi',NULL,'2024-10-22 14:48:36','2024-10-22 14:48:36'),(4,'Boula Nessim','nessimswboula@gmail.com',NULL,NULL,'$2y$10$sTREUeGmipyXtlRCJ9gy1ez2Y19Ysq.Yv34POzYO6VagGrsn2qBFq',NULL,'2024-10-22 14:49:49','2024-10-22 14:49:49'),(5,'Boula Nessim','nessimswbomnmnula@gmail.com',NULL,NULL,'$2y$10$7aXq6sAISHaHfgCbBXKze.XFcegfTHlTbVFForEQQrvDKPZUGfNwu',NULL,'2024-10-23 19:14:45','2024-10-23 19:14:45'),(6,'Mohamed Heshm','mohesham3211@gmail.com',NULL,NULL,'$2y$10$NP9wLnQT/M9P2vb7YI7Tce.3JT8ZRNzKZ3WZsPM8GEfeEQy2uQ8uO',NULL,'2024-10-23 20:23:02','2024-10-23 20:23:02'),(7,'Boula Nessim','nessimswbomnmnulvvvva@gmail.com',NULL,NULL,'$2y$10$CUBcQvNUACJRUJ1U1n2/CeU1XWeaCgMDOsyU1Kh9vVzgmmLu38J6C',NULL,'2024-10-23 20:30:06','2024-10-23 20:30:06'),(8,'boula','boula@gmail.com',NULL,NULL,'$2y$10$PIf/IdLDapXa/L7N4TM9puUVRgRcBBAuQVSg8pfoa0FOVOsMu93qm',NULL,'2024-10-23 20:31:10','2024-10-23 20:31:10'),(9,'werk','admin@gmail.com',NULL,NULL,'$2y$10$gsQ.ZawqRISaOA2bVkmv2e5xopY8YmeRkdzPYKttUSYEsVIYNGYgW',NULL,'2024-10-23 20:33:21','2024-10-23 20:33:21'),(10,'thomas','thomas01997z20@gmail.com',NULL,NULL,'$2y$10$Zo107vqA1bLXD852iIQ8Y.X9Hb6atHNBNDkFsQEDrlEiW29IRz0u6',NULL,'2024-10-26 01:33:41','2024-10-26 01:33:41');
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
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

-- Dump completed on 2025-05-27  6:38:15
