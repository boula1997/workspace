-- MySQL dump 10.13  Distrib 5.7.23-23, for Linux (x86_64)
--
-- Host: localhost    Database: yousabte_db
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
  `type` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `dark` tinyint(1) DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `admins_email_unique` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `admins`
--

LOCK TABLES `admins` WRITE;
/*!40000 ALTER TABLE `admins` DISABLE KEYS */;
INSERT INTO `admins` (`id`, `name`, `email`, `type`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`, `dark`) VALUES (1,'Boula','boula@gmail.com','admin',NULL,'$2y$10$cd6ldNcNY2uJI.Hqjz.6AeOccdV4PHzzlmiX/weBkV6VBzmrK.g.u',NULL,'2024-08-31 08:15:16','2025-09-23 04:02:47',1),(2,'Kermina','kermina@gmail.com','employee',NULL,'$2y$10$rk6tW.Ihx2L2QvG/I2i6Zu68rxbAjJZeohppc33atTui5iraLqAem','nqcxWiBViQtYk6L8jc7aue1ZplGZVKF0x7hElLr3hADm18W4qDbTZPsAqgBB','2024-08-31 08:15:16','2024-08-31 08:15:16',0),(3,'Ibrahim','ibrahim@gmail.com','employee',NULL,'$2y$10$UUH.ssvBXjeTkhvoaj.Z7ODDV7bAgViMaEQVA.h0c6rD7EjKo59NW',NULL,'2024-08-31 08:15:16','2024-08-31 08:15:16',0),(4,'Konuz','konuz@gmail.com','employee',NULL,'$2y$10$V6QUBcKGZQxDV4kUvpgH0uPEvUKilAklAMYK6Q.Hh3snhEJuztSeK','yeSnk3DaiC2LtBFY3RsQUIMUJ2zLePFWItmd0EHo3updMD0ULSmfxKH6zmUb','2024-08-31 08:15:17','2024-08-31 08:15:17',0),(5,'Melad','melad@gmail.com','employee',NULL,'$2y$10$ibFdtvVkRZWojtgxa/w.NOkXBjVH3jYvsmVn0C.AFZyJPuxnI21lW',NULL,'2024-08-31 08:15:17','2024-08-31 08:15:17',0),(9,'ahmed','ahmed@gmail.com',NULL,NULL,'$2y$10$ShSEf3cUT7TpOjBEiyz6S.fC9cXGi9YrHrRmYBAd6VkT4FFqUCxQK',NULL,'2024-09-02 23:10:10','2024-09-02 23:10:10',0),(10,'Zeyad','zeyad@gmail.com',NULL,NULL,'$2y$10$TEiQ7hFZmzoxiKr98k.Tz.dwYGx0ZhW6f/jfcNblOkrYHYsdNOgSq','zPKbNVFeDd5FqNUVg7C6CijaPIFWMd1UeY0cD6x44QNWU5NTGMyWWBD2J84Z','2024-09-03 12:05:56','2024-09-03 12:05:56',0),(11,'Admin','admin@gmail.com',NULL,NULL,'$2y$10$K20sb5GA74oiqg2Yl.rmiuz0EByRElLr68Io3K8uVCl3LU6UFUoBe',NULL,'2025-09-23 03:45:11','2025-09-23 03:45:11',0);
/*!40000 ALTER TABLE `admins` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `categories`
--

DROP TABLE IF EXISTS `categories`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `categories` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `icon` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `categories`
--

LOCK TABLES `categories` WRITE;
/*!40000 ALTER TABLE `categories` DISABLE KEYS */;
INSERT INTO `categories` (`id`, `icon`, `created_at`, `updated_at`) VALUES (1,'far fa-window-restore','2024-08-31 08:15:17','2024-08-31 08:15:17'),(2,'fas fa-shopping-cart','2024-08-31 08:15:17','2024-08-31 08:15:17'),(3,'fas fa-cog','2024-08-31 08:15:17','2024-08-31 08:15:17'),(4,'fab fa-ioxhost','2024-08-31 08:15:17','2024-08-31 08:15:17');
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
  `subtitle` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `category_id` bigint(20) unsigned NOT NULL,
  `locale` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `category_translations_category_id_locale_unique` (`category_id`,`locale`),
  KEY `category_translations_locale_index` (`locale`),
  CONSTRAINT `category_translations_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `category_translations`
--

LOCK TABLES `category_translations` WRITE;
/*!40000 ALTER TABLE `category_translations` DISABLE KEYS */;
INSERT INTO `category_translations` (`id`, `title`, `subtitle`, `description`, `category_id`, `locale`, `created_at`, `updated_at`) VALUES (1,'انشاء مواقع الويب',NULL,'<p>نحن متخصصون في إنشاء مواقع ويب مخصصة تناسب احتياجات عملك المحددة. يعمل فريقنا من المطورين والمصممين ذوي الخبرة بشكل وثيق معك لفهم متطلباتك وتطوير موقع ويب يعكس هوية علامتك التجارية. نحن نستفيد من أحدث تقنيات الويب ومبادئ التصميم سريع الاستجابة لضمان أن يبدو موقع الويب الخاص بك مذهلاً ويعمل بشكل لا تشوبه شائبة عبر الأجهزة وبالاضافه الى لوحة تحكم لنجعلك قادر على التحكم فى جميع محتويات الموقع  </p>',1,'ar','2024-08-31 08:15:17','2024-08-31 08:15:17'),(2,'Custom Website Development',NULL,'<p>We specialize in creating custom websites that fit your specific business needs. Our team of experienced developers and designers work closely with you to understand your requirements and develop a website that reflects your brand identity. We take advantage of the latest web technologies and responsive design principles to ensure that your website looks amazing and works flawlessly across devices and in addition to a control panel to make you able to control all     site content</p>',1,'en','2024-08-31 08:15:17','2024-08-31 08:15:17'),(3,'انشاء مواقع تجارة الكترونية',NULL,'<p>إذا كنت تتطلع إلى بيع منتجات أو خدمات عبر الإنترنت، فيمكن أن تساعدك خدمات تطوير التجارة الإلكترونية لدينا. لدينا خبرة في بناء منصات تجارة إلكترونية آمنة وقابلة للتطوير توفر تجارب مستخدم سلسة وتكاملًا قويًا للدفع. بدءًا من كتالوجات المنتجات وعربات التسوق وحتى إدارة المخزون ومعالجة الطلبات، نقوم بإنشاء حلول للتجارة الإلكترونية تعمل على زيادة التحويلات وزيادة الإيرادات إلى أقصى حد</p>',2,'ar','2024-08-31 08:15:17','2024-08-31 08:15:17'),(4,'E-commerce Development',NULL,'<p>If you\'re looking to sell products or categories online, our e-commerce development categories can help. We have expertise in building secure and scalable e-commerce platforms that offer seamless user experiences and robust payment integration. From product catalogs and shopping carts to inventory management and order processing, we create e-commerce solutions that drive conversions and maximize revenue</p>',2,'en','2024-08-31 08:15:17','2024-08-31 08:15:17'),(5,'صيانة ودعم الموقع',NULL,'<p>نحن نؤمن بالشراكات طويلة الأمد مع عملائنا. تضمن خدمات صيانة ودعم موقع الويب لدينا بقاء موقع الويب الخاص بك آمنًا وحديثًا ومحسّنًا للأداء. نحن نقدم تحديثات منتظمة وتصحيحات أمنية ونسخًا احتياطية لحماية موقع الويب الخاص بك من نقاط الضعف. فريق الدعم لدينا متاح لمعالجة أية مشكلات والإجابة على الأسئلة وتقديم المساعدة الفنية المستمرة</p>',3,'ar','2024-08-31 08:15:17','2024-08-31 08:15:17'),(6,'Website Maintenance and Support',NULL,'<p>We believe in long-term partnerships with our clients. Our website maintenance and support categories ensure that your website remains secure, up-to-date, and optimized for performance. We provide regular updates, security patches, and backups to protect your website from vulnerabilities. Our support team is available to address any issues, answer questions, and provide ongoing technical assistance </p>',3,'en','2024-08-31 08:15:17','2024-08-31 08:15:17'),(7,'استضافت مواقع ',NULL,'<p>في شركة تطوير الويب لدينا، نقدم خدمات استضافة شاملة للتأكد من أن موقع الويب الخاص بك يعمل على النحو الأمثل ويظل في متناول زوار موقعك. توفر خدمة الاستضافة لدينا بيئة موثوقة وآمنة لازدهار موقع الويب الخاص بك. فيما يلي نظرة عامة على خدمة الاستضافة لدينا:\r\n\r\nبنية تحتية موثوقة للاستضافة: نحن نحافظ على بنية تحتية قوية للاستضافة مع خوادم ومعدات شبكات حديثة. تم تحسين خوادمنا من أجل الأداء، مما يوفر أوقات تحميل سريعة وأقل وقت توقف. نحن نعطي الأولوية للموثوقية للتأكد من أن موقع الويب الخاص بك في متناول الزوار على مدار الساعة.\r\n\r\nحلول قابلة للتطوير: تم تصميم خدمة الاستضافة لدينا لاستيعاب نمو موقع الويب الخاص بك. سواء كان لديك موقع ويب خاص بشركة صغيرة أو تطبيق ويب معقد، فإننا نقدم حلول استضافة قابلة للتطوير يمكنها التكيف مع احتياجاتك المتغيرة. مع توسع موقع الويب الخاص بك، يمكننا بسهولة زيادة موارد الاستضافة للتعامل مع زيادة حركة المرور ومتطلبات البيانات.\r\n\r\nالتدابير الأمنية: نحن نعطي الأولوية لأمن موقع الويب الخاص بك والبيانات التي يحتوي عليها. تتضمن خدمة الاستضافة لدينا إجراءات أمنية قوية مثل جدران الحماية، وأنظمة كشف التسلل، والتحديثات الأمنية المنتظمة. نقوم أيضًا بتنفيذ شهادات SSL لتشفير نقل البيانات وحماية المعلومات الحساسة وبناء الثقة مع زوار موقعك.\r\n\r\nالنسخ الاحتياطي والتعافي من الكوارث: نحن ندرك أهمية حماية البيانات. تتضمن خدمة الاستضافة لدينا نسخًا احتياطية منتظمة لموقعك على الويب والبيانات المرتبطة به. في حالة وجود مشكلة فنية أو حدث غير متوقع، يمكننا استعادة موقع الويب الخاص بك بسرعة لتقليل وقت التوقف عن العمل وفقدان البيانات.\r\n\r\nالدعم الفني: فريق الدعم المخصص لدينا متاح لمساعدتك في أي مخاوف أو مشكلات فنية متعلقة بالاستضافة. سواء كانت لديك أسئلة حول تكوينات الخادم، أو كنت بحاجة إلى مساعدة بشأن إعدادات DNS، أو كنت بحاجة إلى استكشاف الأخطاء وإصلاحها، فإن موظفي الدعم ذوي المعرفة لدينا ليسوا سوى مكالمة هاتفية أو بريد إلكتروني.\r\n\r\nالتوافق مع تقنيات الويب: تدعم خدمة الاستضافة لدينا مجموعة واسعة من تقنيات الويب ولغات البرمجة. سواء تم إنشاء موقع الويب الخاص بك باستخدام PHP أو Python أو Node.js أو أطر عمل أخرى، يمكن لبيئة الاستضافة لدينا أن تلبي متطلباتك المحددة.\r\n\r\nشبكة تسليم المحتوى (CDN): لتحسين أداء موقع الويب الخاص بك، يمكننا دمج شبكة تسليم المحتوى (CDN) في خدمة الاستضافة لدينا. تساعد شبكة CDN على تقديم محتوى موقع الويب الخاص بك بسرعة للزائرين من مواقع جغرافية مختلفة، مما يحسن أوقات التحميل وتجربة المستخدم.\r\n\r\nاستضافة البريد الإلكتروني: إلى جانب استضافة مواقع الويب، نقدم أيضًا خدمات استضافة البريد الإلكتروني. يمكنك الحصول على عناوين بريد إلكتروني احترافية مرتبطة باسم النطاق الخاص بك، مما يوفر تجربة اتصال سلسة وموحدة لشركتك. </p>',4,'ar','2024-08-31 08:15:17','2024-08-31 08:15:17'),(8,'Website Hosting',NULL,'<p>At our web development company, we offer comprehensive hosting categories to ensure that your website performs optimally and remains accessible to your visitors. Our hosting category provides a reliable and secure environment for your website to thrive. Here\'s an overview of our hosting category:\r\n\r\n                                Reliable Hosting Infrastructure: We maintain a robust hosting infrastructure with state-of-the-art servers and network equipment. Our servers are optimized for performance, offering fast load times and minimal downtime. We prioritize reliability to ensure that your website is accessible to visitors around the clock.\r\n                                \r\n                                Scalable Solutions: Our hosting category is designed to accommodate your website\'s growth. Whether you have a small business website or a complex web application, we offer scalable hosting solutions that can adapt to your changing needs. As your website expands, we can seamlessly scale up the hosting resources to handle increased traffic and data requirements.\r\n                                \r\n                                Security Measures: We prioritize the security of your website and the data it contains. Our hosting category includes robust security measures such as firewalls, intrusion detection systems, and regular security updates. We also implement SSL certificates to encrypt data transmission, safeguarding sensitive information and building trust with your visitors.\r\n                                \r\n                                Backup and Disaster Recovery: We understand the importance of data protection. Our hosting category includes regular backups of your website and its associated data. In the event of a technical issue or unexpected event, we can quickly restore your website to minimize downtime and data loss.\r\n                                \r\n                                Technical Support: Our dedicated support team is available to assist you with any hosting-related concerns or technical issues. Whether you have questions about server configurations, need assistance with DNS settings, or require troubleshooting, our knowledgeable support staff is just a phone call or email away.\r\n                                \r\n                                Compatibility with Web Technologies: Our hosting category supports a wide range of web technologies and programming languages. Whether your website is built with PHP, Python, Node.js, or other frameworks, our hosting environment can accommodate your specific requirements.\r\n                                \r\n                                Content Delivery Network (CDN): To enhance the performance of your website, we can integrate a Content Delivery Network (CDN) into our hosting category. A CDN helps deliver your website content quickly to visitors from various geographical locations, improving load times and user experience.\r\n                                \r\n                                Email Hosting: Along with website hosting, we also offer email hosting categories. You can have professional email addresses associated with your domain name, providing a seamless and unified communication experience for your business.\r\n                                \r\n                                 </p>',4,'en','2024-08-31 08:15:17','2024-08-31 08:15:17');
/*!40000 ALTER TABLE `category_translations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `complain_translations`
--

DROP TABLE IF EXISTS `complain_translations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `complain_translations` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `complain_id` bigint(20) unsigned NOT NULL,
  `locale` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `complain_translations_complain_id_locale_unique` (`complain_id`,`locale`),
  KEY `complain_translations_locale_index` (`locale`),
  CONSTRAINT `complain_translations_complain_id_foreign` FOREIGN KEY (`complain_id`) REFERENCES `complains` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `complain_translations`
--

LOCK TABLES `complain_translations` WRITE;
/*!40000 ALTER TABLE `complain_translations` DISABLE KEYS */;
INSERT INTO `complain_translations` (`id`, `title`, `description`, `complain_id`, `locale`, `created_at`, `updated_at`) VALUES (1,'كم من الوقت يستغرق تطوير موقع ويب أو تطبيق ويب؟','<p> يعتمد الجدول الزمني لتطوير الويب على مدى تعقيد المشروع وميزاته ومتطلبات العميل. يمكن تطوير موقع ويب بسيط في غضون أيام قليلة، بينما قد تستغرق المشاريع الأكثر شمولاً مثل منصات التجارة الإلكترونية أو تطبيقات الويب المخصصة عدة أسابيع. نحن نقدم جدولًا زمنيًا مفصلاً خلال مرحلة تخطيط المشروع، ونبقيك على اطلاع بالإطار الزمني المتوقع.</P>',1,'ar','2024-08-31 08:15:16','2024-08-31 08:15:16'),(2,'How long does it take to develop a website or web application?','<p>The timeline for web development depends on the project\'s complexity, features, and client requirements. A simple website can be developed within a few days, while more extensive projects like e-commerce platforms or custom web applications may take several weeks. We provide a detailed timeline during the project planning phase, keeping you informed about the expected timeframe.</P>',1,'en','2024-08-31 08:15:16','2024-08-31 08:15:16'),(3,'هل يمكنك المساعدة في إعادة تصميم موقع الويب أو تحديث موقع ويب موجود؟','<p>نعم، نحن نقدم خدمات إعادة تصميم مواقع الويب ويمكننا المساعدة في تحديث مواقع الويب الحالية. سواء كنت بحاجة إلى إصلاح شامل أو تحديثات محددة، يمكن لفريقنا العمل معك لتحسين تصميم موقع الويب الخاص بك ووظائفه وتجربة المستخدم.</P>',2,'ar','2024-08-31 08:15:16','2024-08-31 08:15:16'),(4,'Can you help with website redesign or updates to an existing website?','<p>Yes, we offer website redesign services and can assist with updating existing websites. Whether you need a complete overhaul or specific updates, our team can work with you to enhance your website\'s design, functionality, and user experience.</P>',2,'en','2024-08-31 08:15:16','2024-08-31 08:15:16'),(5,'هل سيكون موقع الويب الخاص بي متوافقًا مع الجوّال وسريع الاستجابة؟','<p>قطعاً! نحن نعطي الأولوية لتصميم الويب سريع الاستجابة، مما يضمن أن يبدو موقع الويب الخاص بك ويعمل بسلاسة عبر الأجهزة المختلفة، بما في ذلك أجهزة الكمبيوتر المكتبية والأجهزة اللوحية والهواتف الذكية. يعد موقع الويب المتوافق مع الأجهزة المحمولة أمرًا ضروريًا للوصول إلى جمهور أوسع وتوفير تجربة مستخدم إيجابية.</P>',3,'ar','2024-08-31 08:15:16','2024-08-31 08:15:16'),(6,' Will my website be mobile-friendly and responsive?','<p>Absolutely! We prioritize responsive web design, ensuring that your website looks and functions seamlessly across various devices, including desktops, tablets, and smartphones. A mobile-friendly website is essential for reaching a wider audience and providing a positive user experience.</P>',3,'en','2024-08-31 08:15:16','2024-08-31 08:15:16'),(7,'هل يمكنك المساعدة في تحسين محركات البحث (SEO)؟','<p>نعم، نحن نقدم خدمات تطوير الويب الصديقة لمحركات البحث (SEO). في حين أن التركيز الأساسي ينصب على إنشاء موقع ويب عملي وجذاب من الناحية المرئية، فإننا نطبق أفضل الممارسات لتحسين موقع الويب الخاص بك لمحركات البحث. يتضمن ذلك بنية HTML المناسبة والتعليمات البرمجية النظيفة وسرعة الصفحة المحسنة وعناوين URL سهلة الاستخدام. بالنسبة لاستراتيجيات تحسين محركات البحث الشاملة، يمكننا أيضًا تقديم التوجيه أو التعاون مع متخصصي تحسين محركات البحث.</p>',4,'ar','2024-08-31 08:15:16','2024-08-31 08:15:16'),(8,'Can you assist with search engine optimization (SEO)?','<p>Yes, we provide SEO-friendly web development services. While the primary focus is on creating a functional and visually appealing website, we implement best practices to optimize your website for search engines. This includes proper HTML structure, clean code, optimized page speed, and user-friendly URLs. For comprehensive SEO strategies, we can also offer guidance or collaborate with SEO specialists.</p>',4,'en','2024-08-31 08:15:16','2024-08-31 08:15:16'),(9,'هل سيكون لدي القدرة على تحديث محتوى موقع الويب الخاص بي؟','<p>نعم، نحن نقدم حلول نظام إدارة المحتوى (CMS) التي تتيح لك تحديث محتوى موقع الويب الخاص بك وإدارته بسهولة. يمكننا أن نوصي وندمج منصات CMS الشائعة مثل WordPress أو Drupal أو Joomla، مما يتيح لك إجراء تغييرات دون الحاجة إلى خبرة فنية.</p>',5,'ar','2024-08-31 08:15:16','2024-08-31 08:15:16'),(10,'Will I have the ability to update my website\'s content?','<p>Yes, we offer content management system (CMS) solutions that allow you to update and manage your website\'s content easily. We can recommend and integrate popular CMS platforms such as WordPress, Drupal, or Joomla, enabling you to make changes without requiring technical expertise.\n                        </p>',5,'en','2024-08-31 08:15:16','2024-08-31 08:15:16'),(11,'هل تقدمون الدعم المستمر وصيانة الموقع؟','<p>نعم، نحن نقدم خدمات الدعم والصيانة المستمرة لضمان بقاء موقع الويب الخاص بك آمنًا وحديثًا ومحسنًا للأداء. نحن نقدم تحديثات منتظمة وتصحيحات أمنية ونسخًا احتياطية ومساعدة فنية لمعالجة أي مشكلات قد تنشأ.</p>',6,'ar','2024-08-31 08:15:16','2024-08-31 08:15:16'),(12,'Do you provide ongoing support and website maintenance?','<p>Yes, we offer ongoing support and maintenance services to ensure your website remains secure, up-to-date, and optimized for performance. We provide regular updates, security patches, backups, and technical assistance to address any issues that may arise.</p>',6,'en','2024-08-31 08:15:16','2024-08-31 08:15:16'),(13,'ما هي التسعير وشروط الدفع الخاصة بك؟','<p>تعتمد أسعارنا على نطاق المشروع وتعقيده. نحن نقدم مقترحات مشاريع مفصلة وتقديرات التكلفة بناء على متطلباتك. عادةً ما تتم مناقشة شروط الدفع والاتفاق عليها خلال مرحلة بدء المشروع.</p>',7,'ar','2024-08-31 08:15:16','2024-08-31 08:15:16'),(14,'What are your pricing and payment terms?','<p>Our pricing depends on the scope and complexity of the project. We provide detailed project proposals and cost estimates based on your requirements. Payment terms are typically discussed and agreed upon during the project initiation phase.</p>',7,'en','2024-08-31 08:15:16','2024-08-31 08:15:16'),(15,'ماذا تتضمن عملية تطوير الويب؟','<p>تتضمن عملية تطوير الويب عادةً عدة مراحل، بما في ذلك تحليل المتطلبات والتصميم والتطوير والاختبار والنشر والصيانة المستمرة. يبدأ الأمر بفهم أهداف مشروعك، يليه تصميم وبرمجة موقع الويب أو تطبيق الويب. يضمن الاختبار وظائفه، وبمجرد الموافقة عليه، يتم نشره على خادم مباشر. تتضمن الصيانة المستمرة التحديثات وتصحيحات الأمان والدعم الفني.</p>',8,'ar','2024-08-31 08:15:16','2024-08-31 08:15:16'),(16,'What does the web development process involve?','<p>The web development process typically involves several stages, including requirement analysis, design, development, testing, deployment, and ongoing maintenance. It begins with understanding your project goals, followed by designing and coding the website or web application. Testing ensures its functionality, and once approved, it is deployed to a live server. Ongoing maintenance includes updates, security patches, and technical support.</p>',8,'en','2024-08-31 08:15:16','2024-08-31 08:15:16');
/*!40000 ALTER TABLE `complain_translations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `complains`
--

DROP TABLE IF EXISTS `complains`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `complains` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `repeat` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `complains`
--

LOCK TABLES `complains` WRITE;
/*!40000 ALTER TABLE `complains` DISABLE KEYS */;
INSERT INTO `complains` (`id`, `repeat`, `created_at`, `updated_at`) VALUES (1,2,'2024-08-31 08:15:16','2024-08-31 08:15:16'),(2,4,'2024-08-31 08:15:16','2024-08-31 08:15:16'),(3,5,'2024-08-31 08:15:16','2024-08-31 08:15:16'),(4,6,'2024-08-31 08:15:16','2024-08-31 08:15:16'),(5,7,'2024-08-31 08:15:16','2024-08-31 08:15:16'),(6,9,'2024-08-31 08:15:16','2024-08-31 08:15:16'),(7,4,'2024-08-31 08:15:16','2024-08-31 08:15:16'),(8,7,'2024-08-31 08:15:16','2024-08-31 08:15:16');
/*!40000 ALTER TABLE `complains` ENABLE KEYS */;
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
INSERT INTO `contacts` (`id`, `contact`, `icon`, `type`, `created_at`, `updated_at`) VALUES (1,'https://www.facebook.com/YousabTech?mibextid=ZbWKwL','fab fa-facebook-f','social','2024-08-31 08:15:16','2024-08-31 08:15:16'),(2,'www.linkedin.com/in/yousab-tech-3707b428b','fab fa-linkedin-in','social','2024-08-31 08:15:16','2024-08-31 08:15:16'),(3,'https://www.instagram.com','fab fa-instagram','social','2024-08-31 08:15:16','2024-08-31 08:15:16'),(4,'yousabtech@gmail.com','fas fa-mail-bulk','email','2024-08-31 08:15:16','2024-08-31 08:15:16'),(5,'01126785910','fas fa-phone','phone','2024-08-31 08:15:16','2024-08-31 08:15:16'),(6,'01208050298','fab fa-whatsapp','whatsapp','2024-08-31 08:15:16','2024-08-31 08:15:16');
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
INSERT INTO `counter_translations` (`id`, `title`, `counter_id`, `locale`, `created_at`, `updated_at`) VALUES (1,'مواقع تم تنفيذها',1,'ar','2024-08-31 08:15:16','2024-08-31 08:15:16'),(2,'Built Web Projects',1,'en','2024-08-31 08:15:16','2024-08-31 08:15:16'),(3,'مواقع تحت الانشاء',2,'ar','2024-08-31 08:15:16','2024-08-31 08:15:16'),(4,'New Web Project',2,'en','2024-08-31 08:15:16','2024-08-31 08:15:16'),(5,'تطبيقات موبيل تم تنفيذها',3,'ar','2024-08-31 08:15:16','2024-08-31 08:15:16'),(6,'Created Mobile Applications',3,'en','2024-08-31 08:15:16','2024-08-31 08:15:16'),(7,'تطبيقات موبيل تحت الانشاء',4,'ar','2024-08-31 08:15:16','2024-08-31 08:15:16'),(8,'New  Mobile Applications',4,'en','2024-08-31 08:15:16','2024-08-31 08:15:16');
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
INSERT INTO `counters` (`id`, `count`, `created_at`, `updated_at`) VALUES (1,'30','2024-08-31 08:15:16','2024-08-31 08:15:16'),(2,'15','2024-08-31 08:15:16','2024-08-31 08:15:16'),(3,'10','2024-08-31 08:15:16','2024-08-31 08:15:16'),(4,'5','2024-08-31 08:15:16','2024-08-31 08:15:16');
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
-- Table structure for table `faq_translations`
--

DROP TABLE IF EXISTS `faq_translations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `faq_translations` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `faq_id` bigint(20) unsigned NOT NULL,
  `locale` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `faq_translations_faq_id_locale_unique` (`faq_id`,`locale`),
  KEY `faq_translations_locale_index` (`locale`),
  CONSTRAINT `faq_translations_faq_id_foreign` FOREIGN KEY (`faq_id`) REFERENCES `faqs` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `faq_translations`
--

LOCK TABLES `faq_translations` WRITE;
/*!40000 ALTER TABLE `faq_translations` DISABLE KEYS */;
INSERT INTO `faq_translations` (`id`, `title`, `description`, `faq_id`, `locale`, `created_at`, `updated_at`) VALUES (1,'كم من الوقت يستغرق تطوير موقع ويب أو تطبيق ويب؟','<p> يعتمد الجدول الزمني لتطوير الويب على مدى تعقيد المشروع وميزاته ومتطلبات العميل. يمكن تطوير موقع ويب بسيط في غضون أيام قليلة، بينما قد تستغرق المشاريع الأكثر شمولاً مثل منصات التجارة الإلكترونية أو تطبيقات الويب المخصصة عدة أسابيع. نحن نقدم جدولًا زمنيًا مفصلاً خلال مرحلة تخطيط المشروع، ونبقيك على اطلاع بالإطار الزمني المتوقع.</P>',1,'ar','2024-08-31 08:15:16','2024-08-31 08:15:16'),(2,'How long does it take to develop a website or web application?','<p>The timeline for web development depends on the project\'s complexity, features, and client requirements. A simple website can be developed within a few days, while more extensive projects like e-commerce platforms or custom web applications may take several weeks. We provide a detailed timeline during the project planning phase, keeping you informed about the expected timeframe.</P>',1,'en','2024-08-31 08:15:16','2024-08-31 08:15:16'),(3,'هل يمكنك المساعدة في إعادة تصميم موقع الويب أو تحديث موقع ويب موجود؟','<p>نعم، نحن نقدم خدمات إعادة تصميم مواقع الويب ويمكننا المساعدة في تحديث مواقع الويب الحالية. سواء كنت بحاجة إلى إصلاح شامل أو تحديثات محددة، يمكن لفريقنا العمل معك لتحسين تصميم موقع الويب الخاص بك ووظائفه وتجربة المستخدم.</P>',2,'ar','2024-08-31 08:15:16','2024-08-31 08:15:16'),(4,'Can you help with website redesign or updates to an existing website?','<p>Yes, we offer website redesign services and can assist with updating existing websites. Whether you need a complete overhaul or specific updates, our team can work with you to enhance your website\'s design, functionality, and user experience.</P>',2,'en','2024-08-31 08:15:16','2024-08-31 08:15:16'),(5,'هل سيكون موقع الويب الخاص بي متوافقًا مع الجوّال وسريع الاستجابة؟','<p>قطعاً! نحن نعطي الأولوية لتصميم الويب سريع الاستجابة، مما يضمن أن يبدو موقع الويب الخاص بك ويعمل بسلاسة عبر الأجهزة المختلفة، بما في ذلك أجهزة الكمبيوتر المكتبية والأجهزة اللوحية والهواتف الذكية. يعد موقع الويب المتوافق مع الأجهزة المحمولة أمرًا ضروريًا للوصول إلى جمهور أوسع وتوفير تجربة مستخدم إيجابية.</P>',3,'ar','2024-08-31 08:15:16','2024-08-31 08:15:16'),(6,' Will my website be mobile-friendly and responsive?','<p>Absolutely! We prioritize responsive web design, ensuring that your website looks and functions seamlessly across various devices, including desktops, tablets, and smartphones. A mobile-friendly website is essential for reaching a wider audience and providing a positive user experience.</P>',3,'en','2024-08-31 08:15:16','2024-08-31 08:15:16'),(7,'هل يمكنك المساعدة في تحسين محركات البحث (SEO)؟','<p>نعم، نحن نقدم خدمات تطوير الويب الصديقة لمحركات البحث (SEO). في حين أن التركيز الأساسي ينصب على إنشاء موقع ويب عملي وجذاب من الناحية المرئية، فإننا نطبق أفضل الممارسات لتحسين موقع الويب الخاص بك لمحركات البحث. يتضمن ذلك بنية HTML المناسبة والتعليمات البرمجية النظيفة وسرعة الصفحة المحسنة وعناوين URL سهلة الاستخدام. بالنسبة لاستراتيجيات تحسين محركات البحث الشاملة، يمكننا أيضًا تقديم التوجيه أو التعاون مع متخصصي تحسين محركات البحث.</p>',4,'ar','2024-08-31 08:15:16','2024-08-31 08:15:16'),(8,'Can you assist with search engine optimization (SEO)?','<p>Yes, we provide SEO-friendly web development services. While the primary focus is on creating a functional and visually appealing website, we implement best practices to optimize your website for search engines. This includes proper HTML structure, clean code, optimized page speed, and user-friendly URLs. For comprehensive SEO strategies, we can also offer guidance or collaborate with SEO specialists.</p>',4,'en','2024-08-31 08:15:16','2024-08-31 08:15:16'),(9,'هل سيكون لدي القدرة على تحديث محتوى موقع الويب الخاص بي؟','<p>نعم، نحن نقدم حلول نظام إدارة المحتوى (CMS) التي تتيح لك تحديث محتوى موقع الويب الخاص بك وإدارته بسهولة. يمكننا أن نوصي وندمج منصات CMS الشائعة مثل WordPress أو Drupal أو Joomla، مما يتيح لك إجراء تغييرات دون الحاجة إلى خبرة فنية.</p>',5,'ar','2024-08-31 08:15:16','2024-08-31 08:15:16'),(10,'Will I have the ability to update my website\'s content?','<p>Yes, we offer content management system (CMS) solutions that allow you to update and manage your website\'s content easily. We can recommend and integrate popular CMS platforms such as WordPress, Drupal, or Joomla, enabling you to make changes without requiring technical expertise.\n                        </p>',5,'en','2024-08-31 08:15:16','2024-08-31 08:15:16'),(11,'هل تقدمون الدعم المستمر وصيانة الموقع؟','<p>نعم، نحن نقدم خدمات الدعم والصيانة المستمرة لضمان بقاء موقع الويب الخاص بك آمنًا وحديثًا ومحسنًا للأداء. نحن نقدم تحديثات منتظمة وتصحيحات أمنية ونسخًا احتياطية ومساعدة فنية لمعالجة أي مشكلات قد تنشأ.</p>',6,'ar','2024-08-31 08:15:16','2024-08-31 08:15:16'),(12,'Do you provide ongoing support and website maintenance?','<p>Yes, we offer ongoing support and maintenance services to ensure your website remains secure, up-to-date, and optimized for performance. We provide regular updates, security patches, backups, and technical assistance to address any issues that may arise.</p>',6,'en','2024-08-31 08:15:16','2024-08-31 08:15:16'),(13,'ما هي التسعير وشروط الدفع الخاصة بك؟','<p>تعتمد أسعارنا على نطاق المشروع وتعقيده. نحن نقدم مقترحات مشاريع مفصلة وتقديرات التكلفة بناء على متطلباتك. عادةً ما تتم مناقشة شروط الدفع والاتفاق عليها خلال مرحلة بدء المشروع.</p>',7,'ar','2024-08-31 08:15:16','2024-08-31 08:15:16'),(14,'What are your pricing and payment terms?','<p>Our pricing depends on the scope and complexity of the project. We provide detailed project proposals and cost estimates based on your requirements. Payment terms are typically discussed and agreed upon during the project initiation phase.</p>',7,'en','2024-08-31 08:15:16','2024-08-31 08:15:16'),(15,'ماذا تتضمن عملية تطوير الويب؟','<p>تتضمن عملية تطوير الويب عادةً عدة مراحل، بما في ذلك تحليل المتطلبات والتصميم والتطوير والاختبار والنشر والصيانة المستمرة. يبدأ الأمر بفهم أهداف مشروعك، يليه تصميم وبرمجة موقع الويب أو تطبيق الويب. يضمن الاختبار وظائفه، وبمجرد الموافقة عليه، يتم نشره على خادم مباشر. تتضمن الصيانة المستمرة التحديثات وتصحيحات الأمان والدعم الفني.</p>',8,'ar','2024-08-31 08:15:16','2024-08-31 08:15:16'),(16,'What does the web development process involve?','<p>The web development process typically involves several stages, including requirement analysis, design, development, testing, deployment, and ongoing maintenance. It begins with understanding your project goals, followed by designing and coding the website or web application. Testing ensures its functionality, and once approved, it is deployed to a live server. Ongoing maintenance includes updates, security patches, and technical support.</p>',8,'en','2024-08-31 08:15:16','2024-08-31 08:15:16');
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
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `faqs`
--

LOCK TABLES `faqs` WRITE;
/*!40000 ALTER TABLE `faqs` DISABLE KEYS */;
INSERT INTO `faqs` (`id`, `created_at`, `updated_at`) VALUES (1,'2024-08-31 08:15:16','2024-08-31 08:15:16'),(2,'2024-08-31 08:15:16','2024-08-31 08:15:16'),(3,'2024-08-31 08:15:16','2024-08-31 08:15:16'),(4,'2024-08-31 08:15:16','2024-08-31 08:15:16'),(5,'2024-08-31 08:15:16','2024-08-31 08:15:16'),(6,'2024-08-31 08:15:16','2024-08-31 08:15:16'),(7,'2024-08-31 08:15:16','2024-08-31 08:15:16'),(8,'2024-08-31 08:15:16','2024-08-31 08:15:16');
/*!40000 ALTER TABLE `faqs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `fees`
--

DROP TABLE IF EXISTS `fees`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `fees` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `amount` double DEFAULT NULL,
  `note` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `project_id` bigint(20) unsigned DEFAULT NULL,
  `rest` double DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fees_project_id_foreign` (`project_id`),
  CONSTRAINT `fees_project_id_foreign` FOREIGN KEY (`project_id`) REFERENCES `projects` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=72 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `fees`
--

LOCK TABLES `fees` WRITE;
/*!40000 ALTER TABLE `fees` DISABLE KEYS */;
INSERT INTO `fees` (`id`, `amount`, `note`, `project_id`, `rest`, `created_at`, `updated_at`) VALUES (1,5000,NULL,3,0,'2024-09-28 01:50:57','2024-09-28 01:50:57'),(2,15590,NULL,4,400,'2024-09-28 01:51:16','2024-09-28 01:51:16'),(3,10000,NULL,41,10000,'2024-09-28 01:52:27','2024-09-29 05:25:22'),(4,400,NULL,4,0,'2024-09-28 01:53:01','2024-09-28 01:53:01'),(5,13000,NULL,12,0,'2024-09-28 01:53:18','2024-09-28 01:53:18'),(6,10000,NULL,20,2000,'2024-09-28 01:53:39','2024-09-28 01:53:39'),(7,10000,NULL,28,6000,'2024-09-28 01:53:58','2024-09-28 01:53:58'),(8,15000,NULL,39,5000,'2024-09-28 01:55:15','2024-09-29 05:26:00'),(9,9399,NULL,32,3601,'2024-09-28 01:56:36','2024-09-28 01:56:36'),(10,7500,NULL,35,0,'2024-09-28 01:57:01','2024-09-28 01:57:01'),(11,7000,NULL,42,0,'2024-09-28 01:57:19','2024-09-28 01:57:19'),(12,6000,NULL,7,0,'2024-09-28 01:57:48','2024-09-28 01:57:48'),(13,10000,NULL,51,0,'2024-09-28 01:58:26','2024-09-28 01:58:26'),(14,6000,NULL,25,0,'2024-09-28 01:58:45','2024-09-28 01:58:45'),(15,6000,NULL,13,0,'2024-09-28 01:58:56','2024-09-28 01:58:56'),(16,5000,NULL,11,0,'2024-09-28 02:00:10','2024-09-28 02:00:10'),(17,5000,NULL,10,0,'2024-09-28 02:00:37','2024-09-28 02:00:37'),(18,3000,NULL,23,3000,'2024-09-28 02:00:56','2024-09-28 02:00:56'),(19,3000,NULL,47,700,'2024-09-28 02:01:20','2024-09-28 02:01:20'),(20,3000,NULL,44,3000,'2024-09-28 02:01:40','2024-09-28 02:01:40'),(21,2500,NULL,9,0,'2024-09-28 02:01:55','2024-09-28 02:01:55'),(22,2000,NULL,14,0,'2024-09-28 02:02:18','2024-09-28 02:02:18'),(23,2000,NULL,31,8000,'2024-09-28 02:02:35','2024-09-28 02:02:35'),(24,2000,NULL,49,0,'2024-09-28 02:02:54','2024-09-28 02:02:54'),(25,2000,NULL,21,2000,'2024-09-28 02:03:09','2024-09-28 02:03:09'),(26,1472,NULL,48,1528,'2024-09-28 02:03:35','2024-09-28 02:03:35'),(27,1000,NULL,37,0,'2024-09-28 02:04:02','2024-09-28 02:04:02'),(31,-1330,NULL,12,1330,'2024-09-28 02:21:31','2024-09-28 02:21:31'),(32,-1200,NULL,52,1200,'2024-09-28 02:22:14','2024-09-28 02:22:14'),(33,-1000,NULL,28,7000,'2024-09-28 02:22:35','2024-09-28 02:22:35'),(34,-1000,NULL,7,1000,'2024-09-28 02:22:49','2024-09-28 02:22:49'),(35,-940,NULL,42,940,'2024-09-28 02:23:15','2024-09-28 02:23:15'),(36,-700,NULL,47,1400,'2024-09-28 02:24:50','2024-09-28 02:24:50'),(37,-700,NULL,44,3700,'2024-09-28 02:25:34','2024-09-28 02:25:34'),(38,-550,NULL,4,550,'2024-09-28 02:26:18','2024-09-28 02:26:18'),(39,-550,NULL,41,10550,'2024-09-28 02:41:19','2024-09-28 02:41:19'),(40,-300,NULL,14,300,'2024-09-28 02:41:46','2024-09-28 02:41:46'),(54,-90,NULL,11,NULL,'2024-09-28 05:21:52','2024-09-28 05:23:17'),(55,-90,NULL,3,NULL,'2024-09-28 05:22:25','2024-09-28 05:23:06'),(56,-90,NULL,51,NULL,'2024-09-28 05:22:39','2024-09-28 05:22:54'),(59,-3000,NULL,51,NULL,'2024-09-29 01:47:20','2024-09-29 01:47:20'),(60,-3000,NULL,10,NULL,'2024-09-29 01:48:06','2024-09-29 01:48:06'),(61,-4000,NULL,12,NULL,'2024-09-29 01:48:40','2024-09-29 01:48:52'),(62,-500,NULL,42,NULL,'2024-09-29 01:49:46','2024-09-29 01:49:46'),(63,-300,NULL,7,NULL,'2024-09-29 01:50:25','2024-09-29 01:50:25'),(64,-700,'Zeyad cost',10,NULL,'2024-09-29 01:51:00','2024-09-29 01:51:14'),(65,-4000,NULL,41,NULL,'2024-09-29 01:52:11','2024-09-29 01:52:21'),(66,3000,'Rest money',44,NULL,'2024-10-03 16:53:09','2024-10-03 16:53:09'),(67,-500,'Kermina cost',41,NULL,'2024-10-03 23:48:53','2024-10-04 04:42:15'),(68,1528,'Sent 2796 hassan',48,NULL,'2024-10-06 01:53:23','2024-10-06 01:53:23'),(69,1266,'Sent 2794 hassan divided them on harminy and vega',26,NULL,'2024-10-06 01:54:23','2024-10-06 01:54:23'),(70,-700,'Comission on credit card',6,NULL,'2024-10-08 01:35:00','2024-10-08 01:35:00'),(71,5000,'Maher',53,NULL,'2024-10-08 01:37:04','2024-10-08 01:37:04');
/*!40000 ALTER TABLE `fees` ENABLE KEYS */;
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
) ENGINE=InnoDB AUTO_INCREMENT=170 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `files`
--

LOCK TABLES `files` WRITE;
/*!40000 ALTER TABLE `files` DISABLE KEYS */;
INSERT INTO `files` (`id`, `url`, `fileable_id`, `fileable_type`, `created_at`, `updated_at`) VALUES (1,'images/cgWPIBaJgb4Scv32ZJiBUlfgxxmN1VBPaZXHuBNQ.png',1,'App\\Models\\Gallery','2024-08-31 08:15:16','2024-08-31 08:15:16'),(2,'images/jt56GhBaJfQpaA0NvqXZ7bdakujTuzyW70lRLtoE.png',1,'App\\Models\\Gallery','2024-08-31 08:15:16','2024-08-31 08:15:16'),(3,'images/Ix6TIYHwCvxgPtWaspfddbGvyZYXXt9jrec8yAkn.png',1,'App\\Models\\Gallery','2024-08-31 08:15:16','2024-08-31 08:15:16'),(4,'images/7eXRM4Y6H4A8avrsL6ihOwVZ4b7abBbA6pDuyET4.png',1,'App\\Models\\Gallery','2024-08-31 08:15:16','2024-08-31 08:15:16'),(5,'images/ynASd3T5mGdFuUZi6uvWaih3GZjs4w0VRltMK470.png',1,'App\\Models\\Gallery','2024-08-31 08:15:16','2024-08-31 08:15:16'),(6,'images/PbJ4udZknEOWeALHvGi3sQuThWWohAonTar88NOF.png',1,'App\\Models\\Gallery','2024-08-31 08:15:16','2024-08-31 08:15:16'),(7,'images/Y94snrI09Gex5SNQO5yZrqzE2e3Guht71rEWbsXX.png',1,'App\\Models\\Gallery','2024-08-31 08:15:16','2024-08-31 08:15:16'),(8,'images/NhEKA5TSZe0EOe15L4jDznG48seP3urSspWgl79u.png',1,'App\\Models\\Gallery','2024-08-31 08:15:16','2024-08-31 08:15:16'),(9,'images/fu4OVbhm6tLlfpM0JOESaKkSMRLuF6OuOlVT13DF.png',1,'App\\Models\\Gallery','2024-08-31 08:15:16','2024-08-31 08:15:16'),(10,'images/ipHIqPYZfDEcp6EjxpQzumYCBPt0GzsFnhtCt294.png',1,'App\\Models\\Gallery','2024-08-31 08:15:16','2024-08-31 08:15:16'),(11,'images/mOPxVTc5mVCGnZTkxFFokefhj9jR52Ws1k1kTbMZ.png',1,'App\\Models\\Gallery','2024-08-31 08:15:16','2024-08-31 08:15:16'),(12,'images/NBuecH0kpfPECl0Hjqk4KRh60BnDzVpVTm1l3aaQ.png',2,'App\\Models\\Gallery','2024-08-31 08:15:16','2024-08-31 08:15:16'),(13,'images/bwq9e5TPGiu6FZj1xtmqeMYhJwTs3FQtOSDjBWg1.png',2,'App\\Models\\Gallery','2024-08-31 08:15:16','2024-08-31 08:15:16'),(14,'images/lHoEcIQO2nOpcFTPJeLWktWtwqSPNcteQ46NFWlA.png',2,'App\\Models\\Gallery','2024-08-31 08:15:16','2024-08-31 08:15:16'),(15,'images/rCkgzRr6gD7Eozb4hzrZdGRWKbDZmMKEsGWBCjgw.png',2,'App\\Models\\Gallery','2024-08-31 08:15:16','2024-08-31 08:15:16'),(16,'images/PT070XhctXpMgtxLv6liva7IKqZdpvAZCacOt73V.png',2,'App\\Models\\Gallery','2024-08-31 08:15:16','2024-08-31 08:15:16'),(17,'images/hcYqQxwjM2yv6m5BTKSuYQ8jh3Nnk358woGX8y5C.png',2,'App\\Models\\Gallery','2024-08-31 08:15:16','2024-08-31 08:15:16'),(18,'images/Sq4e5UYueEeU3E7yy70isDq0WfKOwgujUHCo2PuD.png',2,'App\\Models\\Gallery','2024-08-31 08:15:16','2024-08-31 08:15:16'),(19,'images/reservyaprofile/1.jpeg',3,'App\\Models\\Gallery','2024-08-31 08:15:16','2024-08-31 08:15:16'),(20,'images/reservyaprofile/2.jpeg',3,'App\\Models\\Gallery','2024-08-31 08:15:16','2024-08-31 08:15:16'),(21,'images/reservyaprofile/3.jpeg',3,'App\\Models\\Gallery','2024-08-31 08:15:16','2024-08-31 08:15:16'),(22,'images/reservyaprofile/4.jpeg',3,'App\\Models\\Gallery','2024-08-31 08:15:16','2024-08-31 08:15:16'),(23,'images/reservyaprofile/5.jpeg',3,'App\\Models\\Gallery','2024-08-31 08:15:16','2024-08-31 08:15:16'),(24,'images/reservyaprofile/6.jpeg',3,'App\\Models\\Gallery','2024-08-31 08:15:16','2024-08-31 08:15:16'),(25,'images/reservyaprofile/7.jpeg',3,'App\\Models\\Gallery','2024-08-31 08:15:16','2024-08-31 08:15:16'),(26,'images/reservyaprofile/8.jpeg',3,'App\\Models\\Gallery','2024-08-31 08:15:16','2024-08-31 08:15:16'),(27,'images/reservyaprofile/9.jpeg',3,'App\\Models\\Gallery','2024-08-31 08:15:16','2024-08-31 08:15:16'),(28,'images/reservyaprofile/10.jpeg',3,'App\\Models\\Gallery','2024-08-31 08:15:16','2024-08-31 08:15:16'),(29,'images/reservyaprofile/11.jpeg',3,'App\\Models\\Gallery','2024-08-31 08:15:16','2024-08-31 08:15:16'),(30,'images/reservyaprofile/12.jpeg',3,'App\\Models\\Gallery','2024-08-31 08:15:16','2024-08-31 08:15:16'),(31,'images/reservyaprofile/13.jpeg',3,'App\\Models\\Gallery','2024-08-31 08:15:16','2024-08-31 08:15:16'),(32,'images/reservyaprofile/14.jpeg',3,'App\\Models\\Gallery','2024-08-31 08:15:16','2024-08-31 08:15:16'),(33,'images/elmandra_elarabia/1.jpeg',4,'App\\Models\\Gallery','2024-08-31 08:15:16','2024-08-31 08:15:16'),(34,'images/elmandra_elarabia/2.jpeg',4,'App\\Models\\Gallery','2024-08-31 08:15:16','2024-08-31 08:15:16'),(35,'images/elmandra_elarabia/3.jpeg',4,'App\\Models\\Gallery','2024-08-31 08:15:16','2024-08-31 08:15:16'),(36,'images/elmandra_elarabia/4.jpeg',4,'App\\Models\\Gallery','2024-08-31 08:15:16','2024-08-31 08:15:16'),(37,'images/elmandra_elarabia/5.jpeg',4,'App\\Models\\Gallery','2024-08-31 08:15:16','2024-08-31 08:15:16'),(38,'images/elmandra_elarabia/6.jpeg',4,'App\\Models\\Gallery','2024-08-31 08:15:16','2024-08-31 08:15:16'),(39,'images/elmandra_elarabia/7.jpeg',4,'App\\Models\\Gallery','2024-08-31 08:15:16','2024-08-31 08:15:16'),(40,'images/elmandra_elarabia/8.jpeg',4,'App\\Models\\Gallery','2024-08-31 08:15:16','2024-08-31 08:15:16'),(41,'images/elmandra_elarabia/9.jpeg',4,'App\\Models\\Gallery','2024-08-31 08:15:16','2024-08-31 08:15:16'),(42,'images/elmandra_elarabia/10.jpeg',4,'App\\Models\\Gallery','2024-08-31 08:15:16','2024-08-31 08:15:16'),(43,'images/elmandra_elarabia/11.jpeg',4,'App\\Models\\Gallery','2024-08-31 08:15:16','2024-08-31 08:15:16'),(44,'images/elmandra_elarabia/12.jpeg',4,'App\\Models\\Gallery','2024-08-31 08:15:16','2024-08-31 08:15:16'),(45,'images/elmandra_elarabia/13.jpeg',4,'App\\Models\\Gallery','2024-08-31 08:15:16','2024-08-31 08:15:16'),(46,'images/gym/1.jpeg',5,'App\\Models\\Gallery','2024-08-31 08:15:16','2024-08-31 08:15:16'),(47,'images/gym/2.jpeg',5,'App\\Models\\Gallery','2024-08-31 08:15:16','2024-08-31 08:15:16'),(48,'images/gym/3.jpeg',5,'App\\Models\\Gallery','2024-08-31 08:15:16','2024-08-31 08:15:16'),(49,'images/gym/4.jpeg',5,'App\\Models\\Gallery','2024-08-31 08:15:16','2024-08-31 08:15:16'),(50,'images/gym/5.jpeg',5,'App\\Models\\Gallery','2024-08-31 08:15:16','2024-08-31 08:15:16'),(51,'images/gym/6.jpeg',5,'App\\Models\\Gallery','2024-08-31 08:15:16','2024-08-31 08:15:16'),(52,'images/gym/7.jpeg',5,'App\\Models\\Gallery','2024-08-31 08:15:16','2024-08-31 08:15:16'),(53,'images/gym/8.jpeg',5,'App\\Models\\Gallery','2024-08-31 08:15:16','2024-08-31 08:15:16'),(54,'images/gym/9.jpeg',5,'App\\Models\\Gallery','2024-08-31 08:15:16','2024-08-31 08:15:16'),(55,'images/gym/10.jpeg',5,'App\\Models\\Gallery','2024-08-31 08:15:16','2024-08-31 08:15:16'),(56,'images/gym/11.jpeg',5,'App\\Models\\Gallery','2024-08-31 08:15:16','2024-08-31 08:15:16'),(57,'images/gym/12.jpeg',5,'App\\Models\\Gallery','2024-08-31 08:15:16','2024-08-31 08:15:16'),(58,'images/asleltawfeer/1.png',6,'App\\Models\\Gallery','2024-08-31 08:15:16','2024-08-31 08:15:16'),(59,'images/asleltawfeer/2.png',6,'App\\Models\\Gallery','2024-08-31 08:15:16','2024-08-31 08:15:16'),(60,'images/asleltawfeer/3.png',6,'App\\Models\\Gallery','2024-08-31 08:15:16','2024-08-31 08:15:16'),(61,'images/asleltawfeer/4.png',6,'App\\Models\\Gallery','2024-08-31 08:15:16','2024-08-31 08:15:16'),(62,'images/asleltawfeer/5.png',6,'App\\Models\\Gallery','2024-08-31 08:15:16','2024-08-31 08:15:16'),(63,'images/asleltawfeer/6.png',6,'App\\Models\\Gallery','2024-08-31 08:15:16','2024-08-31 08:15:16'),(64,'images/asleltawfeer/7.png',6,'App\\Models\\Gallery','2024-08-31 08:15:16','2024-08-31 08:15:16'),(65,'images/asleltawfeer/8.png',6,'App\\Models\\Gallery','2024-08-31 08:15:16','2024-08-31 08:15:16'),(66,'images/asleltawfeer/9.png',6,'App\\Models\\Gallery','2024-08-31 08:15:16','2024-08-31 08:15:16'),(67,'images/asleltawfeer/10.png',6,'App\\Models\\Gallery','2024-08-31 08:15:16','2024-08-31 08:15:16'),(68,'images/asleltawfeer/11.png',6,'App\\Models\\Gallery','2024-08-31 08:15:16','2024-08-31 08:15:16'),(69,'images/asleltawfeer/12.png',6,'App\\Models\\Gallery','2024-08-31 08:15:16','2024-08-31 08:15:16'),(70,'images/asleltawfeer/13.png',6,'App\\Models\\Gallery','2024-08-31 08:15:16','2024-08-31 08:15:16'),(71,'images/asleltawfeer/14.png',6,'App\\Models\\Gallery','2024-08-31 08:15:16','2024-08-31 08:15:16'),(72,'images/celine/1.jpeg',7,'App\\Models\\Gallery','2024-08-31 08:15:16','2024-08-31 08:15:16'),(73,'images/celine/2.jpeg',7,'App\\Models\\Gallery','2024-08-31 08:15:16','2024-08-31 08:15:16'),(74,'images/celine/3.jpeg',7,'App\\Models\\Gallery','2024-08-31 08:15:16','2024-08-31 08:15:16'),(75,'images/celine/4.jpeg',7,'App\\Models\\Gallery','2024-08-31 08:15:16','2024-08-31 08:15:16'),(76,'images/celine/5.jpeg',7,'App\\Models\\Gallery','2024-08-31 08:15:16','2024-08-31 08:15:16'),(77,'images/celine/6.jpeg',7,'App\\Models\\Gallery','2024-08-31 08:15:16','2024-08-31 08:15:16'),(78,'images/celine/7.jpeg',7,'App\\Models\\Gallery','2024-08-31 08:15:16','2024-08-31 08:15:16'),(79,'images/celine/8.jpeg',7,'App\\Models\\Gallery','2024-08-31 08:15:16','2024-08-31 08:15:16'),(80,'images/celine/9.jpeg',7,'App\\Models\\Gallery','2024-08-31 08:15:16','2024-08-31 08:15:16'),(81,'images/celine/10.jpeg',7,'App\\Models\\Gallery','2024-08-31 08:15:16','2024-08-31 08:15:16'),(82,'images/celine/11.jpeg',7,'App\\Models\\Gallery','2024-08-31 08:15:16','2024-08-31 08:15:16'),(83,'images/celine/12.jpeg',7,'App\\Models\\Gallery','2024-08-31 08:15:16','2024-08-31 08:15:16'),(84,'images/celine/13.jpeg',7,'App\\Models\\Gallery','2024-08-31 08:15:16','2024-08-31 08:15:16'),(85,'images/celine/14.jpeg',7,'App\\Models\\Gallery','2024-08-31 08:15:16','2024-08-31 08:15:16'),(86,'images/celine/15.jpeg',7,'App\\Models\\Gallery','2024-08-31 08:15:16','2024-08-31 08:15:16'),(87,'images/celine/16.jpeg',7,'App\\Models\\Gallery','2024-08-31 08:15:16','2024-08-31 08:15:16'),(88,'images/celine/17.jpeg',7,'App\\Models\\Gallery','2024-08-31 08:15:16','2024-08-31 08:15:16'),(89,'images/msabaatsteel/1.png',8,'App\\Models\\Gallery','2024-08-31 08:15:16','2024-08-31 08:15:16'),(90,'images/msabaatsteel/2.png',8,'App\\Models\\Gallery','2024-08-31 08:15:16','2024-08-31 08:15:16'),(91,'images/msabaatsteel/3.png',8,'App\\Models\\Gallery','2024-08-31 08:15:16','2024-08-31 08:15:16'),(92,'images/msabaatsteel/4.png',8,'App\\Models\\Gallery','2024-08-31 08:15:16','2024-08-31 08:15:16'),(93,'images/msabaatsteel/5.png',8,'App\\Models\\Gallery','2024-08-31 08:15:16','2024-08-31 08:15:16'),(94,'images/msabaatsteel/6.png',8,'App\\Models\\Gallery','2024-08-31 08:15:16','2024-08-31 08:15:16'),(95,'images/msabaatsteel/7.png',8,'App\\Models\\Gallery','2024-08-31 08:15:16','2024-08-31 08:15:16'),(96,'images/msabaatsteel/8.png',8,'App\\Models\\Gallery','2024-08-31 08:15:16','2024-08-31 08:15:16'),(97,'images/msabaatsteel/9.png',8,'App\\Models\\Gallery','2024-08-31 08:15:16','2024-08-31 08:15:16'),(98,'images/msabaatsteel/10.png',8,'App\\Models\\Gallery','2024-08-31 08:15:16','2024-08-31 08:15:16'),(99,'images/msabaatsteel/11.png',8,'App\\Models\\Gallery','2024-08-31 08:15:16','2024-08-31 08:15:16'),(100,'images/msabaatsteel/12.png',8,'App\\Models\\Gallery','2024-08-31 08:15:16','2024-08-31 08:15:16'),(101,'images/haddak/1.jpeg',9,'App\\Models\\Gallery','2024-08-31 08:15:16','2024-08-31 08:15:16'),(102,'images/haddak/2.jpeg',9,'App\\Models\\Gallery','2024-08-31 08:15:16','2024-08-31 08:15:16'),(103,'images/haddak/3.jpeg',9,'App\\Models\\Gallery','2024-08-31 08:15:16','2024-08-31 08:15:16'),(104,'images/haddak/4.jpeg',9,'App\\Models\\Gallery','2024-08-31 08:15:16','2024-08-31 08:15:16'),(105,'images/haddak/5.jpeg',9,'App\\Models\\Gallery','2024-08-31 08:15:16','2024-08-31 08:15:16'),(106,'images/haddak/6.jpeg',9,'App\\Models\\Gallery','2024-08-31 08:15:16','2024-08-31 08:15:16'),(107,'images/haddak/7.jpeg',9,'App\\Models\\Gallery','2024-08-31 08:15:16','2024-08-31 08:15:16'),(108,'images/haddak/8.jpeg',9,'App\\Models\\Gallery','2024-08-31 08:15:16','2024-08-31 08:15:16'),(109,'images/haddak/9.jpeg',9,'App\\Models\\Gallery','2024-08-31 08:15:16','2024-08-31 08:15:16'),(110,'images/haddak/10.jpeg',9,'App\\Models\\Gallery','2024-08-31 08:15:16','2024-08-31 08:15:16'),(111,'images/haddak/11.jpeg',9,'App\\Models\\Gallery','2024-08-31 08:15:16','2024-08-31 08:15:16'),(112,'images/eljazira/1.png',10,'App\\Models\\Gallery','2024-08-31 08:15:16','2024-08-31 08:15:16'),(113,'images/eljazira/2.png',10,'App\\Models\\Gallery','2024-08-31 08:15:16','2024-08-31 08:15:16'),(114,'images/eljazira/3.png',10,'App\\Models\\Gallery','2024-08-31 08:15:16','2024-08-31 08:15:16'),(115,'images/eljazira/4.png',10,'App\\Models\\Gallery','2024-08-31 08:15:16','2024-08-31 08:15:16'),(116,'images/eljazira/5.png',10,'App\\Models\\Gallery','2024-08-31 08:15:16','2024-08-31 08:15:16'),(117,'images/eljazira/6.png',10,'App\\Models\\Gallery','2024-08-31 08:15:16','2024-08-31 08:15:16'),(118,'images/eljazira/7.png',10,'App\\Models\\Gallery','2024-08-31 08:15:16','2024-08-31 08:15:16'),(119,'images/eljazira/8.png',10,'App\\Models\\Gallery','2024-08-31 08:15:16','2024-08-31 08:15:16'),(120,'images/eljazira/9.png',10,'App\\Models\\Gallery','2024-08-31 08:15:16','2024-08-31 08:15:16'),(121,'images/egypttourism/1.jpeg',11,'App\\Models\\Gallery','2024-08-31 08:15:16','2024-08-31 08:15:16'),(122,'images/egypttourism/2.jpeg',11,'App\\Models\\Gallery','2024-08-31 08:15:16','2024-08-31 08:15:16'),(123,'images/egypttourism/3.jpeg',11,'App\\Models\\Gallery','2024-08-31 08:15:16','2024-08-31 08:15:16'),(124,'images/egypttourism/4.jpeg',11,'App\\Models\\Gallery','2024-08-31 08:15:16','2024-08-31 08:15:16'),(125,'images/egypttourism/5.jpeg',11,'App\\Models\\Gallery','2024-08-31 08:15:16','2024-08-31 08:15:16'),(126,'images/egypttourism/6.jpeg',11,'App\\Models\\Gallery','2024-08-31 08:15:16','2024-08-31 08:15:16'),(127,'images/egypttourism/7.jpeg',11,'App\\Models\\Gallery','2024-08-31 08:15:16','2024-08-31 08:15:16'),(128,'images/egypttourism/8.jpeg',11,'App\\Models\\Gallery','2024-08-31 08:15:16','2024-08-31 08:15:16'),(129,'images/egypttourism/9.jpeg',11,'App\\Models\\Gallery','2024-08-31 08:15:16','2024-08-31 08:15:16'),(130,'images/egypttourism/10.jpeg',11,'App\\Models\\Gallery','2024-08-31 08:15:16','2024-08-31 08:15:16'),(131,'images/egypttourism/11.jpeg',11,'App\\Models\\Gallery','2024-08-31 08:15:16','2024-08-31 08:15:16'),(132,'images/6Uc5BhjmQJtfneedg6lKQ4U0Mh4SHOs5OAd8StZd.webp',1,'App\\Models\\Page','2024-08-31 08:15:16','2024-08-31 08:15:16'),(133,'images/dbfWCgbV5jglKcWKTYT6SeIsuAsQxCQ4GGDLHXex.webp',2,'App\\Models\\Page','2024-08-31 08:15:16','2024-08-31 08:15:16'),(134,'images/8dTGgGdIWqURKxo2SYehtgjCL3AKeSKmINcUVMyy.webp',6,'App\\Models\\Page','2024-08-31 08:15:16','2024-08-31 08:15:16'),(135,'images/l2K1cEb5wcsPVzhHhj2OWNcQXBPKKrofxrfhgu5W.webp',7,'App\\Models\\Page','2024-08-31 08:15:16','2024-08-31 08:15:16'),(136,'images/khyVZVtSks0zZfm3NQAA3496oI8ovcN3rzKD9rX4.webp',7,'App\\Models\\Page','2024-08-31 08:15:16','2024-08-31 08:15:16'),(137,'images/NzpSLncvvrosX4WqGDJLZtWvY3Xrvxzw6saO8xr6.webp',7,'App\\Models\\Page','2024-08-31 08:15:16','2024-08-31 08:15:16'),(138,'images/lFm4BhN2x9t3xJnk42ivFtqCWzMCcLppx1Mlr9gN.jpg',1,'App\\Models\\Service','2024-08-31 08:15:17','2024-08-31 08:15:17'),(139,'images/tqmoHh1nzC4Zg0IE4JykvWbBigfJpdIxMqxNcYPF.jpg',2,'App\\Models\\Service','2024-08-31 08:15:17','2024-08-31 08:15:17'),(140,'images/fih4AHmLMdr3mBpXqeeellC00S18BZm5dDCHcntw.jpg',3,'App\\Models\\Service','2024-08-31 08:15:17','2024-08-31 08:15:17'),(141,'images/yvxLurP4RFhTzwsih8n5pYC62eHgY74TDzQ3J8xF.jpg',4,'App\\Models\\Service','2024-08-31 08:15:17','2024-08-31 08:15:17'),(142,'images/tykEYLJg6IvrEdpzYcHTmLm5WWErcSklnEZcOjcI.webp',1,'App\\Models\\Partner','2024-08-31 08:15:17','2024-08-31 08:15:17'),(143,'images/HsWogOvEjxPtEStdNr913ols44RFifVERaoyxkwh.webp',2,'App\\Models\\Partner','2024-08-31 08:15:17','2024-08-31 08:15:17'),(144,'images/PF6upRmlXRiiLF1JVifLw2q43EI50i0dnTGHP6xu.webp',3,'App\\Models\\Partner','2024-08-31 08:15:17','2024-08-31 08:15:17'),(145,'images/TpVI2ZX1wEb42aAx56kLkGIpwGHyW1sPLeBgF5e8.webp',4,'App\\Models\\Partner','2024-08-31 08:15:17','2024-08-31 08:15:17'),(146,'images/zlqIgyZxaZJCmqfSvsxqkTIFsou1vItih8tUaqXi.jpg',1,'App\\Models\\Team','2024-08-31 08:15:17','2024-08-31 08:15:17'),(147,'images/YE92B4LXiM6QhFcQbr5YKECGaMU5k8NokXve9o1m.jpg',2,'App\\Models\\Team','2024-08-31 08:15:17','2024-08-31 08:15:17'),(148,'images/YQXLPLiQgi8H1E9YE77J3lwUX0qSOYXkHMP192Nz.png',3,'App\\Models\\Team','2024-08-31 08:15:17','2024-08-31 08:15:17'),(149,'images/pekmLKsEWdfVwDSwbG0sSIZARXfO8GavZPaoOF1D.jpg',4,'App\\Models\\Team','2024-08-31 08:15:17','2024-08-31 08:15:17'),(150,'images/tAgfJG0vAJHhQsCii9FR441z6tGs9fyGKj92MUzy.jpg',5,'App\\Models\\Team','2024-08-31 08:15:17','2024-08-31 08:15:17'),(151,'images/melad.jpeg',6,'App\\Models\\Team','2024-08-31 08:15:17','2024-08-31 08:15:17'),(152,'images/zaid_sayed.jpeg',7,'App\\Models\\Team','2024-08-31 08:15:17','2024-08-31 08:15:17'),(153,'images/w66o7ZleB0PAmRNOOiLp37gmh9iwImRphogPhjFy.webp',1,'App\\Models\\Testimonial','2024-08-31 08:15:17','2024-08-31 08:15:17'),(154,'images/w66o7ZleB0PAmRNOOiLp37gmh9iwImRphogPhjFy.webp',2,'App\\Models\\Testimonial','2024-08-31 08:15:17','2024-08-31 08:15:17'),(155,'images/w66o7ZleB0PAmRNOOiLp37gmh9iwImRphogPhjFy.webp',3,'App\\Models\\Testimonial','2024-08-31 08:15:17','2024-08-31 08:15:17'),(156,'images/w66o7ZleB0PAmRNOOiLp37gmh9iwImRphogPhjFy.webp',4,'App\\Models\\Testimonial','2024-08-31 08:15:17','2024-08-31 08:15:17'),(157,'images/w66o7ZleB0PAmRNOOiLp37gmh9iwImRphogPhjFy.webp',5,'App\\Models\\Testimonial','2024-08-31 08:15:17','2024-08-31 08:15:17'),(158,'images/lFm4BhN2x9t3xJnk42ivFtqCWzMCcLppx1Mlr9gN.jpg',1,'App\\Models\\Product','2024-08-31 08:15:17','2024-08-31 08:15:17'),(159,'images/tqmoHh1nzC4Zg0IE4JykvWbBigfJpdIxMqxNcYPF.jpg',2,'App\\Models\\Product','2024-08-31 08:15:17','2024-08-31 08:15:17'),(160,'images/fih4AHmLMdr3mBpXqeeellC00S18BZm5dDCHcntw.jpg',3,'App\\Models\\Product','2024-08-31 08:15:17','2024-08-31 08:15:17'),(161,'images/yvxLurP4RFhTzwsih8n5pYC62eHgY74TDzQ3J8xF.jpg',4,'App\\Models\\Product','2024-08-31 08:15:17','2024-08-31 08:15:17'),(162,'images/lFm4BhN2x9t3xJnk42ivFtqCWzMCcLppx1Mlr9gN.jpg',1,'App\\Models\\Category','2024-08-31 08:15:17','2024-08-31 08:15:17'),(163,'images/tqmoHh1nzC4Zg0IE4JykvWbBigfJpdIxMqxNcYPF.jpg',2,'App\\Models\\Category','2024-08-31 08:15:17','2024-08-31 08:15:17'),(164,'images/fih4AHmLMdr3mBpXqeeellC00S18BZm5dDCHcntw.jpg',3,'App\\Models\\Category','2024-08-31 08:15:17','2024-08-31 08:15:17'),(165,'images/yvxLurP4RFhTzwsih8n5pYC62eHgY74TDzQ3J8xF.jpg',4,'App\\Models\\Category','2024-08-31 08:15:17','2024-08-31 08:15:17'),(168,'images/BOYbk3BSMCwQLGT5aeASYxkozs124nyhDHxiGghK.jpg',9,'App\\Models\\Admin','2024-09-02 23:10:10','2024-09-02 23:10:10'),(169,'images/OtaQZFGbmP8guPqIewRpDvqxxqFhFCMmbPcqm8pS.jpg',10,'App\\Models\\Admin','2024-09-03 12:05:57','2024-09-03 12:05:57');
/*!40000 ALTER TABLE `files` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `galleries`
--

DROP TABLE IF EXISTS `galleries`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `galleries` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `galleries`
--

LOCK TABLES `galleries` WRITE;
/*!40000 ALTER TABLE `galleries` DISABLE KEYS */;
INSERT INTO `galleries` (`id`, `created_at`, `updated_at`) VALUES (1,'2024-08-31 08:15:16','2024-08-31 08:15:16'),(2,'2024-08-31 08:15:16','2024-08-31 08:15:16'),(3,'2024-08-31 08:15:16','2024-08-31 08:15:16'),(4,'2024-08-31 08:15:16','2024-08-31 08:15:16'),(5,'2024-08-31 08:15:16','2024-08-31 08:15:16'),(6,'2024-08-31 08:15:16','2024-08-31 08:15:16'),(7,'2024-08-31 08:15:16','2024-08-31 08:15:16'),(8,'2024-08-31 08:15:16','2024-08-31 08:15:16'),(9,'2024-08-31 08:15:16','2024-08-31 08:15:16'),(10,'2024-08-31 08:15:16','2024-08-31 08:15:16'),(11,'2024-08-31 08:15:16','2024-08-31 08:15:16');
/*!40000 ALTER TABLE `galleries` ENABLE KEYS */;
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
  `subtitle` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `gallery_id` bigint(20) unsigned NOT NULL,
  `locale` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `gallery_translations_gallery_id_locale_unique` (`gallery_id`,`locale`),
  KEY `gallery_translations_locale_index` (`locale`),
  CONSTRAINT `gallery_translations_gallery_id_foreign` FOREIGN KEY (`gallery_id`) REFERENCES `galleries` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=23 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `gallery_translations`
--

LOCK TABLES `gallery_translations` WRITE;
/*!40000 ALTER TABLE `gallery_translations` DISABLE KEYS */;
INSERT INTO `gallery_translations` (`id`, `title`, `subtitle`, `description`, `gallery_id`, `locale`, `created_at`, `updated_at`) VALUES (1,'العالمية (موقع للتجارة الإلكترونية)',NULL,NULL,1,'ar','2024-08-31 08:15:16','2024-08-31 08:15:16'),(2,'Elalamia (e-commerce website)',NULL,NULL,1,'en','2024-08-31 08:15:16','2024-08-31 08:15:16'),(3,'سول فارما (موقع التجارة الإلكترونية)',NULL,NULL,2,'ar','2024-08-31 08:15:16','2024-08-31 08:15:16'),(4,'Soul Pharma (e-commerce website)',NULL,NULL,2,'en','2024-08-31 08:15:16','2024-08-31 08:15:16'),(5,'ملف تعريف ريسيرفيا (موقع التجارة الإلكترونية)',NULL,NULL,3,'ar','2024-08-31 08:15:16','2024-08-31 08:15:16'),(6,'Reservya Profile (e-commerce website)',NULL,NULL,3,'en','2024-08-31 08:15:16','2024-08-31 08:15:16'),(7,'المندر العربية (موقع للتجارة الإلكترونية)',NULL,NULL,4,'ar','2024-08-31 08:15:16','2024-08-31 08:15:16'),(8,'Elmandr Alarabia (e-commerce website)',NULL,NULL,4,'en','2024-08-31 08:15:16','2024-08-31 08:15:16'),(9,'GYM (موقع التجارة الإلكترونية)',NULL,NULL,5,'ar','2024-08-31 08:15:16','2024-08-31 08:15:16'),(10,'GYM (e-commerce website)',NULL,NULL,5,'en','2024-08-31 08:15:16','2024-08-31 08:15:16'),(11,'أصل التوفير (موقع للتجارة الإلكترونية)',NULL,NULL,6,'ar','2024-08-31 08:15:16','2024-08-31 08:15:16'),(12,'Asl Al Tawfeer (e-commerce website)',NULL,NULL,6,'en','2024-08-31 08:15:16','2024-08-31 08:15:16'),(13,'سيلين (خدمات فندقية)',NULL,NULL,7,'ar','2024-08-31 08:15:16','2024-08-31 08:15:16'),(14,'Celine (Hotel Services)',NULL,NULL,7,'en','2024-08-31 08:15:16','2024-08-31 08:15:16'),(15,'مسابات ستيل (موقع للتجارة الإلكترونية)',NULL,NULL,8,'ar','2024-08-31 08:15:16','2024-08-31 08:15:16'),(16,'Msabaat Steel (e-commerce website)',NULL,NULL,8,'en','2024-08-31 08:15:16','2024-08-31 08:15:16'),(17,'حداق الفيروز',NULL,NULL,9,'ar','2024-08-31 08:15:16','2024-08-31 08:15:16'),(18,'Haddak Elfayrouz',NULL,NULL,9,'en','2024-08-31 08:15:16','2024-08-31 08:15:16'),(19,'الجزيرة (خدمات فندقية)',NULL,NULL,10,'ar','2024-08-31 08:15:16','2024-08-31 08:15:16'),(20,'Al Jazira (Hotel Services)',NULL,NULL,10,'en','2024-08-31 08:15:16','2024-08-31 08:15:16'),(21,'ايجيبت للسياحة',NULL,NULL,11,'ar','2024-08-31 08:15:16','2024-08-31 08:15:16'),(22,'Egypt Tourism',NULL,NULL,11,'en','2024-08-31 08:15:16','2024-08-31 08:15:16');
/*!40000 ALTER TABLE `gallery_translations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `images`
--

DROP TABLE IF EXISTS `images`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `images` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `gallery_id` bigint(20) unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `images_gallery_id_foreign` (`gallery_id`),
  CONSTRAINT `images_gallery_id_foreign` FOREIGN KEY (`gallery_id`) REFERENCES `galleries` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `images`
--

LOCK TABLES `images` WRITE;
/*!40000 ALTER TABLE `images` DISABLE KEYS */;
/*!40000 ALTER TABLE `images` ENABLE KEYS */;
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
  `message` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `messages`
--

LOCK TABLES `messages` WRITE;
/*!40000 ALTER TABLE `messages` DISABLE KEYS */;
INSERT INTO `messages` (`id`, `name`, `email`, `phone`, `message`, `created_at`, `updated_at`) VALUES (1,'Ibrahim Samy','ibrahimsamy308@gmail.com','01289189890','ًكيفيه عمل موقع بتكلفه اقل','2024-08-31 08:15:16','2024-08-31 08:15:16'),(2,'Kero Boula','Kero@gmail.com','0124578960',NULL,'2024-08-31 08:15:16','2024-08-31 08:15:16'),(3,'ابراهيم سامى','ibrahim@gmail.com','450015885',NULL,'2024-08-31 08:15:16','2024-08-31 08:15:16');
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
) ENGINE=InnoDB AUTO_INCREMENT=48 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `migrations`
--

LOCK TABLES `migrations` WRITE;
/*!40000 ALTER TABLE `migrations` DISABLE KEYS */;
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (1,'2014_04_02_193005_create_translations_table',1),(2,'2014_10_12_000000_create_users_table',1),(3,'2014_10_12_100000_create_password_reset_tokens_table',1),(4,'2014_10_12_100000_create_password_resets_table',1),(5,'2019_08_19_000000_create_failed_jobs_table',1),(6,'2019_12_14_000001_create_personal_access_tokens_table',1),(7,'2022_10_23_075806_create_categories_table',1),(8,'2022_10_23_075806_create_processes_table',1),(9,'2022_10_23_075806_create_products_table',1),(10,'2022_10_23_075806_create_services_table',1),(11,'2022_10_23_075806_create_testimonials_table',1),(12,'2022_10_23_075828_create_faqs_table',1),(13,'2022_10_23_075846_create_settings_table',1),(14,'2022_10_23_080942_create_galleries_table',1),(15,'2022_10_24_111948_create_partners_table',1),(16,'2022_10_24_111948_create_teams_table',1),(17,'2022_10_26_125729_create_pages_table',1),(18,'2022_10_29_155126_create_messages_table',1),(19,'2022_10_29_155126_create_newsletters_table',1),(20,'2022_10_29_155126_create_serviceRequests_table',1),(21,'2022_11_06_150334_create_images_table',1),(22,'2022_11_26_153759_create_videos_table',1),(23,'2022_11_26_154654_create_contacts_table',1),(24,'2022_11_26_154654_create_counters_table',1),(25,'2022_11_26_154654_create_projects_table',1),(26,'2023_06_26_124955_create_admins_table',1),(27,'2023_06_26_173744_create_permission_tables',1),(28,'2023_06_27_154699_create_fees_table',1),(29,'2023_06_27_154699_create_tasks_table',1),(30,'2023_06_27_170717_create_category_translations_table',1),(31,'2023_06_27_170717_create_process_translations_table',1),(32,'2023_06_27_170717_create_product_translations_table',1),(33,'2023_06_27_170717_create_service_translations_table',1),(34,'2023_06_27_170717_create_testimonial_translations_table',1),(35,'2023_06_28_105000_create_files_table',1),(36,'2023_06_28_175347_create_faq_translations_table',1),(37,'2023_06_28_175550_create_setting_translations_table',1),(38,'2023_06_28_180004_create_gallery_translations_table',1),(39,'2023_06_28_180137_create_partner_translations_table',1),(40,'2023_06_28_180137_create_team_translations_table',1),(41,'2023_06_28_180243_create_page_translations_table',1),(42,'2023_06_28_180523_create_video_translations_table',1),(43,'2023_06_28_180559_create_counter_translations_table',1),(44,'2024_06_17_142322_create_complains_table',1),(45,'2024_06_17_143258_create_complain_translations_table',1),(46,'2024_06_19_070504_create_vaccancies_table',1),(47,'2024_06_20_090402_create_vaccancy_translations_table',1);
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
INSERT INTO `model_has_roles` (`role_id`, `model_type`, `model_id`) VALUES (1,'App\\Models\\Admin',1),(2,'App\\Models\\Admin',2),(1,'App\\Models\\Admin',3),(2,'App\\Models\\Admin',4),(2,'App\\Models\\Admin',5),(2,'App\\Models\\Admin',9),(2,'App\\Models\\Admin',10),(1,'App\\Models\\Admin',11);
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
  `newsletterEmail` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `newsletters`
--

LOCK TABLES `newsletters` WRITE;
/*!40000 ALTER TABLE `newsletters` DISABLE KEYS */;
INSERT INTO `newsletters` (`id`, `newsletterEmail`, `created_at`, `updated_at`) VALUES (1,'ibrahimsamy308@gmail.com','2024-08-31 08:15:16','2024-08-31 08:15:16'),(2,'Kero@gmail.com','2024-08-31 08:15:16','2024-08-31 08:15:16'),(3,'ibrahim@gmail.com','2024-08-31 08:15:16','2024-08-31 08:15:16');
/*!40000 ALTER TABLE `newsletters` ENABLE KEYS */;
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
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `page_translations`
--

LOCK TABLES `page_translations` WRITE;
/*!40000 ALTER TABLE `page_translations` DISABLE KEYS */;
INSERT INTO `page_translations` (`id`, `title`, `subtitle`, `description`, `page_id`, `locale`, `created_at`, `updated_at`) VALUES (1,'إنشاء مواقع ويب للشركات الكبيرة و الصغيرة','أفضل حلول برمجة الويب','ً<p>نحن من ذوي الخبرة في إنشاء مواقع الويب التي يمكن أن تخدم أعمالك وتلبي جميع متطلباتك</p>',1,'ar','2024-08-31 08:15:16','2024-08-31 08:15:16'),(2,'Creating Websites for small and big businesses','Best Web Solutions','<p>We are experienced in creating websites that can serve your business and meet all your requirements</p>',1,'en','2024-08-31 08:15:16','2024-08-31 08:15:16'),(3,'معلومات عنا','نحن شركة برمجة مواقع ويب ','<p>مرحبًا بكم في شركة يوساب تك، الشركة الرائدة في مجال تطوير الويب والملتزمة بتقديم تجارب رقمية استثنائية. بفضل شغفنا بالإبداع والخبرة التقنية، نحن متخصصون في صياغة حلول الويب المخصصة التي تساعد الشركات على الازدهار في العالم الرقمي. في يوساب تك، نحن نفهم قوة موقع الويب المصمم جيدًا. إنها بمثابة واجهة متجر رقمية لعلامتك التجارية، حيث تربطك بجمهورك المستهدف وتدفع النمو. يعمل فريقنا من مطوري الويب والمصممين والاستراتيجيين الرقميين المهرة بشكل تعاوني لإنشاء مواقع ويب جذابة تركز على المستخدم وتترك انطباعًا دائمًا.</p>',2,'ar','2024-08-31 08:15:16','2024-08-31 08:15:16'),(4,'About US','We are a web development company.','<p>Welcome to Yousab Tech, a leading web development company committed to delivering exceptional digital experiences. With a passion for creativity and technical expertise, we specialize in crafting custom web solutions that help businesses thrive in the digital world. At Yousab Tech, we understand the power of a well-designed website. It serves as the digital storefront for your brand, connecting you with your target audience and driving growth. Our team of skilled web developers, designers, and digital strategists work collaboratively to create engaging, user-centric websites that leave a lasting impression.</p>',2,'en','2024-08-31 08:15:16','2024-08-31 08:15:16'),(5,'نحن نقدم أفضل حلول الويب',NULL,'<p>نحن نقدم مجموعة شاملة من خدمات تطوير الويب لمساعدة الشركات على تأسيس تواجد قوي عبر الإنترنت وتحقيق أهدافها الرقمية. مع فريق من المهنيين ذوي المهارات العالية، فإننا نجمع بين الإبداع والخبرة الفنية وأفضل ممارسات الصناعة لتقديم حلول ويب استثنائية. وهنا بعض من الخدمات التي نقدمها</p>',3,'ar','2024-08-31 08:15:16','2024-08-31 08:15:16'),(6,'We provide the best Web solutions',NULL,'<p>We offer a comprehensive range of web development services to help businesses   establish a strong online presence and achieve their digital goals. With a team of highly skilled professionals, we combine creativity, technical expertise, and industry best practices to deliver exceptional web solutions. Here are some of the services we provide</p>',3,'en','2024-08-31 08:15:16','2024-08-31 08:15:16'),(7,'سابقة اعمالنا ','سابقة الأعمال','<p>نحن نفخر بالمجموعة المتنوعة من المشاريع التي نجحنا في تسليمها لعملائنا. تعرض  سابقة اعمالنا خبرتنا في تطوير الويب والتصميم والحلول الرقمية</p>',4,'ar','2024-08-31 08:15:16','2024-08-31 08:15:16'),(8,'Our latest Portfolio for your choice','Portfolio Templates','<p>We take great pride in the diverse range of projects we have successfully delivered for our clients. Our portfolio showcases our expertise in web development, design, and digital solutions. Here are a few highlights</p>',4,'en','2024-08-31 08:15:16','2024-08-31 08:15:16'),(9,'كيف نعمل','آلية العمل','<p>تم تصميم الية العمل لدينا لإبقاء عملائنا مشاركين ومطلعين وراضين طوال كل مرحلة من مراحل المشروع. وفيما يلي نظرة عامة على عملية عملنا</p>',5,'ar','2024-08-31 08:15:16','2024-08-31 08:15:16'),(10,'How it works','Work Process','<p>Our work process is designed to keep our clients involved, informed, and satisfied throughout each stage of the project. Here\'s an overview of our work process</p>',5,'en','2024-08-31 08:15:16','2024-08-31 08:15:16'),(11,'اعرف المزيد عن حلول الويب لدينا','الأسئلة التي قد تتبادر إلى ذهنك','<p>إذا كان لديك المزيد من الأسئلة، نحن هنا للمساعدة! لا تتردد في الاتصال بنا، وسيكون فريقنا سعيدًا بتزويدك بمزيد من المعلومات ومعالجة أي مخاوف محددة قد تكون لديك</p>',6,'ar','2024-08-31 08:15:16','2024-08-31 08:15:16'),(12,'Know more about our web solutions','Questions that may come to your mind','<p>If you have more questions, We\'re here to help! Feel free to contact us, and our team will be happy to provide you with further information and address any specific concerns you may have</p>',6,'en','2024-08-31 08:15:16','2024-08-31 08:15:16'),(13,'لدينا مهارة مهنية','مهارة احترافية',NULL,7,'ar','2024-08-31 08:15:16','2024-08-31 08:15:16'),(14,'We have professional skilled','Professional Skill',NULL,7,'en','2024-08-31 08:15:16','2024-08-31 08:15:16'),(15,'فريق العمل','تعرف على فريق العمل','<p>لقد قمنا بتجميع فريق من المهنيين ذوي المهارات العالية والحماس الذين يكرسون جهودهم لتقديم حلول استثنائية لتطوير الويب</p>',8,'ar','2024-08-31 08:15:16','2024-08-31 08:15:16'),(16,'Expert Team','Meet with our expert','<p>we have assembled a team of highly skilled and passionate professionals who are dedicated to delivering exceptional web development solutions</p>',8,'en','2024-08-31 08:15:16','2024-08-31 08:15:16'),(17,'تواصل معنا ','ابقى على تواصل','<p>نحن نقدر التواصل المفتوح والشفاف مع عملائنا. سواء كان لديك سؤال، أو فكرة مشروع، أو ببساطة تريد معرفة المزيد حول خدمات تطوير الويب لدينا، فإن فريقنا موجود لمساعدتك</p>',9,'ar','2024-08-31 08:15:16','2024-08-31 08:15:16'),(18,'Contact','Get in touch','<p>We value open and transparent communication with our clients. Whether you have a question, a project idea, or simply want to learn more about our web development services, our team is here to assist you</p>',9,'en','2024-08-31 08:15:16','2024-08-31 08:15:16'),(19,'نحن هنا للإجابة على أسئلتك على مدار اليوم','تحتاج إلى خدمات الحل','<p>Dcidunt eget semper nec quam. Sed hendrerit. acfelis Nunc egestas augue atpellentesque laoreet</p>',10,'ar','2024-08-31 08:15:16','2024-08-31 08:15:16'),(20,'We are here to answer your questions 24/7','Need for it solution services','<p>Dcidunt eget semper nec quam. Sed hendrerit. acfelis Nunc egestas augue atpellentesque laoreet</p>',10,'en','2024-08-31 08:15:16','2024-08-31 08:15:16');
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
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `pages`
--

LOCK TABLES `pages` WRITE;
/*!40000 ALTER TABLE `pages` DISABLE KEYS */;
INSERT INTO `pages` (`id`, `identifier`, `created_at`, `updated_at`) VALUES (1,'home-banner','2024-08-31 08:15:16','2024-08-31 08:15:16'),(2,'about-us','2024-08-31 08:15:16','2024-08-31 08:15:16'),(3,'service-section','2024-08-31 08:15:16','2024-08-31 08:15:16'),(4,'portfolio-section','2024-08-31 08:15:16','2024-08-31 08:15:16'),(5,'process-section','2024-08-31 08:15:16','2024-08-31 08:15:16'),(6,'faq-section','2024-08-31 08:15:16','2024-08-31 08:15:16'),(7,'skills-section','2024-08-31 08:15:16','2024-08-31 08:15:16'),(8,'team-section','2024-08-31 08:15:16','2024-08-31 08:15:16'),(9,'contact-section','2024-08-31 08:15:16','2024-08-31 08:15:16'),(10,'solution-section','2024-08-31 08:15:16','2024-08-31 08:15:16');
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
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `partner_translations`
--

LOCK TABLES `partner_translations` WRITE;
/*!40000 ALTER TABLE `partner_translations` DISABLE KEYS */;
INSERT INTO `partner_translations` (`id`, `title`, `partner_id`, `locale`, `created_at`, `updated_at`) VALUES (1,'SEO Mind',1,'ar','2024-08-31 08:15:17','2024-08-31 08:15:17'),(2,'SEO Mind',1,'en','2024-08-31 08:15:17','2024-08-31 08:15:17'),(3,'Boosterio',2,'ar','2024-08-31 08:15:17','2024-08-31 08:15:17'),(4,'Boosterio',2,'en','2024-08-31 08:15:17','2024-08-31 08:15:17'),(5,'Atomic SEO',3,'ar','2024-08-31 08:15:17','2024-08-31 08:15:17'),(6,'Atomic SEO',3,'en','2024-08-31 08:15:17','2024-08-31 08:15:17'),(7,'Green Host',4,'ar','2024-08-31 08:15:17','2024-08-31 08:15:17'),(8,'Green Host',4,'en','2024-08-31 08:15:17','2024-08-31 08:15:17');
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
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `partners`
--

LOCK TABLES `partners` WRITE;
/*!40000 ALTER TABLE `partners` DISABLE KEYS */;
INSERT INTO `partners` (`id`, `created_at`, `updated_at`) VALUES (1,'2024-08-31 08:15:17','2024-08-31 08:15:17'),(2,'2024-08-31 08:15:17','2024-08-31 08:15:17'),(3,'2024-08-31 08:15:17','2024-08-31 08:15:17'),(4,'2024-08-31 08:15:17','2024-08-31 08:15:17');
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
) ENGINE=InnoDB AUTO_INCREMENT=99 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `permissions`
--

LOCK TABLES `permissions` WRITE;
/*!40000 ALTER TABLE `permissions` DISABLE KEYS */;
INSERT INTO `permissions` (`id`, `name`, `guard_name`, `created_at`, `updated_at`) VALUES (1,'role-list','admin','2024-09-18 06:28:44','2024-09-18 06:28:44'),(2,'role-create','admin','2024-09-18 06:28:44','2024-09-18 06:28:44'),(3,'role-edit','admin','2024-09-18 06:28:44','2024-09-18 06:28:44'),(4,'role-delete','admin','2024-09-18 06:28:44','2024-09-18 06:28:44'),(5,'product-list','admin','2024-09-18 06:28:44','2024-09-18 06:28:44'),(6,'product-create','admin','2024-09-18 06:28:44','2024-09-18 06:28:44'),(7,'product-edit','admin','2024-09-18 06:28:44','2024-09-18 06:28:44'),(8,'product-delete','admin','2024-09-18 06:28:44','2024-09-18 06:28:44'),(9,'faq-list','admin','2024-09-18 06:28:44','2024-09-18 06:28:44'),(10,'faq-create','admin','2024-09-18 06:28:44','2024-09-18 06:28:44'),(11,'faq-edit','admin','2024-09-18 06:28:44','2024-09-18 06:28:44'),(12,'faq-delete','admin','2024-09-18 06:28:44','2024-09-18 06:28:44'),(13,'complain-list','admin','2024-09-18 06:28:44','2024-09-18 06:28:44'),(14,'complain-create','admin','2024-09-18 06:28:44','2024-09-18 06:28:44'),(15,'complain-edit','admin','2024-09-18 06:28:44','2024-09-18 06:28:44'),(16,'complain-delete','admin','2024-09-18 06:28:44','2024-09-18 06:28:44'),(17,'vaccancy-list','admin','2024-09-18 06:28:44','2024-09-18 06:28:44'),(18,'vaccancy-create','admin','2024-09-18 06:28:44','2024-09-18 06:28:44'),(19,'vaccancy-edit','admin','2024-09-18 06:28:44','2024-09-18 06:28:44'),(20,'vaccancy-delete','admin','2024-09-18 06:28:44','2024-09-18 06:28:44'),(21,'counter-list','admin','2024-09-18 06:28:44','2024-09-18 06:28:44'),(22,'counter-create','admin','2024-09-18 06:28:44','2024-09-18 06:28:44'),(23,'counter-edit','admin','2024-09-18 06:28:44','2024-09-18 06:28:44'),(24,'counter-delete','admin','2024-09-18 06:28:44','2024-09-18 06:28:44'),(25,'contact-list','admin','2024-09-18 06:28:44','2024-09-18 06:28:44'),(26,'contact-create','admin','2024-09-18 06:28:44','2024-09-18 06:28:44'),(27,'contact-edit','admin','2024-09-18 06:28:44','2024-09-18 06:28:44'),(28,'contact-delete','admin','2024-09-18 06:28:44','2024-09-18 06:28:44'),(29,'image-list','admin','2024-09-18 06:28:44','2024-09-18 06:28:44'),(30,'image-create','admin','2024-09-18 06:28:44','2024-09-18 06:28:44'),(31,'image-edit','admin','2024-09-18 06:28:44','2024-09-18 06:28:44'),(32,'project-list','admin','2024-09-18 06:28:44','2024-09-18 06:28:44'),(33,'project-create','admin','2024-09-18 06:28:44','2024-09-18 06:28:44'),(34,'project-edit','admin','2024-09-18 06:28:44','2024-09-18 06:28:44'),(35,'project-delete','admin','2024-09-18 06:28:44','2024-09-18 06:28:44'),(36,'image-delete','admin','2024-09-18 06:28:44','2024-09-18 06:28:44'),(37,'task-list','admin','2024-09-18 06:28:44','2024-09-18 06:28:44'),(38,'task-create','admin','2024-09-18 06:28:44','2024-09-18 06:28:44'),(39,'task-edit','admin','2024-09-18 06:28:44','2024-09-18 06:28:44'),(40,'task-delete','admin','2024-09-18 06:28:44','2024-09-18 06:28:44'),(41,'page-list','admin','2024-09-18 06:28:44','2024-09-18 06:28:44'),(42,'page-create','admin','2024-09-18 06:28:44','2024-09-18 06:28:44'),(43,'page-edit','admin','2024-09-18 06:28:44','2024-09-18 06:28:44'),(44,'page-delete','admin','2024-09-18 06:28:44','2024-09-18 06:28:44'),(45,'fee-list','admin','2024-09-18 06:28:44','2024-09-18 06:28:44'),(46,'fee-create','admin','2024-09-18 06:28:44','2024-09-18 06:28:44'),(47,'fee-edit','admin','2024-09-18 06:28:44','2024-09-18 06:28:44'),(48,'fee-delete','admin','2024-09-18 06:28:44','2024-09-18 06:28:44'),(49,'portfolio-list','admin','2024-09-18 06:28:44','2024-09-18 06:28:44'),(50,'portfolio-create','admin','2024-09-18 06:28:44','2024-09-18 06:28:44'),(51,'portfolio-edit','admin','2024-09-18 06:28:44','2024-09-18 06:28:44'),(52,'portfolio-delete','admin','2024-09-18 06:28:44','2024-09-18 06:28:44'),(53,'service-list','admin','2024-09-18 06:28:44','2024-09-18 06:28:44'),(54,'service-create','admin','2024-09-18 06:28:44','2024-09-18 06:28:44'),(55,'service-edit','admin','2024-09-18 06:28:44','2024-09-18 06:28:44'),(56,'service-delete','admin','2024-09-18 06:28:44','2024-09-18 06:28:44'),(57,'testimonial-list','admin','2024-09-18 06:28:44','2024-09-18 06:28:44'),(58,'testimonial-create','admin','2024-09-18 06:28:44','2024-09-18 06:28:44'),(59,'testimonial-edit','admin','2024-09-18 06:28:44','2024-09-18 06:28:44'),(60,'testimonial-delete','admin','2024-09-18 06:28:44','2024-09-18 06:28:44'),(61,'category-list','admin','2024-09-18 06:28:44','2024-09-18 06:28:44'),(62,'category-create','admin','2024-09-18 06:28:44','2024-09-18 06:28:44'),(63,'category-edit','admin','2024-09-18 06:28:44','2024-09-18 06:28:44'),(64,'category-delete','admin','2024-09-18 06:28:44','2024-09-18 06:28:44'),(65,'process-list','admin','2024-09-18 06:28:44','2024-09-18 06:28:44'),(66,'process-create','admin','2024-09-18 06:28:44','2024-09-18 06:28:44'),(67,'process-edit','admin','2024-09-18 06:28:44','2024-09-18 06:28:44'),(68,'process-delete','admin','2024-09-18 06:28:44','2024-09-18 06:28:44'),(69,'setting-list','admin','2024-09-18 06:28:44','2024-09-18 06:28:44'),(70,'setting-create','admin','2024-09-18 06:28:44','2024-09-18 06:28:44'),(71,'setting-edit','admin','2024-09-18 06:28:44','2024-09-18 06:28:44'),(72,'setting-delete','admin','2024-09-18 06:28:44','2024-09-18 06:28:44'),(73,'partner-list','admin','2024-09-18 06:28:44','2024-09-18 06:28:44'),(74,'partner-create','admin','2024-09-18 06:28:44','2024-09-18 06:28:44'),(75,'partner-edit','admin','2024-09-18 06:28:44','2024-09-18 06:28:44'),(76,'partner-delete','admin','2024-09-18 06:28:44','2024-09-18 06:28:44'),(77,'team-list','admin','2024-09-18 06:28:44','2024-09-18 06:28:44'),(78,'team-create','admin','2024-09-18 06:28:44','2024-09-18 06:28:44'),(79,'team-edit','admin','2024-09-18 06:28:44','2024-09-18 06:28:44'),(80,'team-delete','admin','2024-09-18 06:28:44','2024-09-18 06:28:44'),(81,'video-list','admin','2024-09-18 06:28:44','2024-09-18 06:28:44'),(82,'video-create','admin','2024-09-18 06:28:44','2024-09-18 06:28:44'),(83,'video-edit','admin','2024-09-18 06:28:44','2024-09-18 06:28:44'),(84,'video-delete','admin','2024-09-18 06:28:44','2024-09-18 06:28:44'),(85,'user-list','admin','2024-09-18 06:28:44','2024-09-18 06:28:44'),(86,'user-create','admin','2024-09-18 06:28:44','2024-09-18 06:28:44'),(87,'user-edit','admin','2024-09-18 06:28:44','2024-09-18 06:28:44'),(88,'user-delete','admin','2024-09-18 06:28:44','2024-09-18 06:28:44'),(89,'admin-list','admin','2024-09-18 06:28:44','2024-09-18 06:28:44'),(90,'admin-create','admin','2024-09-18 06:28:44','2024-09-18 06:28:44'),(91,'admin-edit','admin','2024-09-18 06:28:44','2024-09-18 06:28:44'),(92,'admin-delete','admin','2024-09-18 06:28:44','2024-09-18 06:28:44'),(93,'message-list','admin','2024-09-18 06:28:44','2024-09-18 06:28:44'),(94,'message-delete','admin','2024-09-18 06:28:44','2024-09-18 06:28:44'),(95,'message-reply','admin','2024-09-18 06:28:44','2024-09-18 06:28:44'),(96,'newsletter-list','admin','2024-09-18 06:28:44','2024-09-18 06:28:44'),(97,'newsletter-delete','admin','2024-09-18 06:28:45','2024-09-18 06:28:45'),(98,'newsletter-reply','admin','2024-09-18 06:28:45','2024-09-18 06:28:45');
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
-- Table structure for table `process_translations`
--

DROP TABLE IF EXISTS `process_translations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `process_translations` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `subtitle` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `process_id` bigint(20) unsigned NOT NULL,
  `locale` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `process_translations_process_id_locale_unique` (`process_id`,`locale`),
  KEY `process_translations_locale_index` (`locale`),
  CONSTRAINT `process_translations_process_id_foreign` FOREIGN KEY (`process_id`) REFERENCES `processes` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `process_translations`
--

LOCK TABLES `process_translations` WRITE;
/*!40000 ALTER TABLE `process_translations` DISABLE KEYS */;
INSERT INTO `process_translations` (`id`, `title`, `subtitle`, `description`, `process_id`, `locale`, `created_at`, `updated_at`) VALUES (1,'حدد أهدافك ومتطلباتك:',NULL,'<p>حدد بوضوح أهدافك وغاياتك للموقع.</p>',1,'ar','2024-08-31 08:15:17','2024-08-31 08:15:17'),(2,'Define Your Goals and Requirements',NULL,'<p>Clearly identify your goals and objectives for the website.</p>',1,'en','2024-08-31 08:15:17','2024-08-31 08:15:17'),(3,'المشاورات الأولية',NULL,'<p>تواصل معنا للحصول على رسم توضيحي كامل لمناقشة أهداف مشروعك </p>',2,'ar','2024-08-31 08:15:17','2024-08-31 08:15:17'),(4,'Initial Consultation',NULL,'<p>Connect with us to have a full illustration to discuss your project goals </p>',2,'en','2024-08-31 08:15:17','2024-08-31 08:15:17'),(5,'الاقتراح والاتفاق',NULL,'<p>سنزودك بمقترح يوضح نطاق المشروع والجدول الزمني والتكلفة.</p>',3,'ar','2024-08-31 08:15:17','2024-08-31 08:15:17'),(6,'Proposal and Agreement',NULL,'<p>we will provide you with a proposal that outlines the project scope, timeline, and cost.</p>',3,'en','2024-08-31 08:15:17','2024-08-31 08:15:17'),(7,'تنفيذ وتسليم الموقع',NULL,'<p>مراجعة الموقع وتسليمه للعميل بمجرد رضاه عن المخرجات.</p>',4,'ar','2024-08-31 08:15:17','2024-08-31 08:15:17'),(8,'Executing and Delivering',NULL,'<p>reviewing the website and deliver it to client once he is satisfied with the output. </p>',4,'en','2024-08-31 08:15:17','2024-08-31 08:15:17');
/*!40000 ALTER TABLE `process_translations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `processes`
--

DROP TABLE IF EXISTS `processes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `processes` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `processes`
--

LOCK TABLES `processes` WRITE;
/*!40000 ALTER TABLE `processes` DISABLE KEYS */;
INSERT INTO `processes` (`id`, `created_at`, `updated_at`) VALUES (1,'2024-08-31 08:15:17','2024-08-31 08:15:17'),(2,'2024-08-31 08:15:17','2024-08-31 08:15:17'),(3,'2024-08-31 08:15:17','2024-08-31 08:15:17'),(4,'2024-08-31 08:15:17','2024-08-31 08:15:17');
/*!40000 ALTER TABLE `processes` ENABLE KEYS */;
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
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `product_translations`
--

LOCK TABLES `product_translations` WRITE;
/*!40000 ALTER TABLE `product_translations` DISABLE KEYS */;
INSERT INTO `product_translations` (`id`, `title`, `subtitle`, `description`, `product_id`, `locale`, `created_at`, `updated_at`) VALUES (1,'انشاء مواقع الويب',NULL,'<p>نحن متخصصون في إنشاء مواقع ويب مخصصة تناسب احتياجات عملك المحددة. يعمل فريقنا من المطورين والمصممين ذوي الخبرة بشكل وثيق معك لفهم متطلباتك وتطوير موقع ويب يعكس هوية علامتك التجارية. نحن نستفيد من أحدث تقنيات الويب ومبادئ التصميم سريع الاستجابة لضمان أن يبدو موقع الويب الخاص بك مذهلاً ويعمل بشكل لا تشوبه شائبة عبر الأجهزة وبالاضافه الى لوحة تحكم لنجعلك قادر على التحكم فى جميع محتويات الموقع  </p>',1,'ar','2024-08-31 08:15:17','2024-08-31 08:15:17'),(2,'Custom Website Development',NULL,'<p>We specialize in creating custom websites that fit your specific business needs. Our team of experienced developers and designers work closely with you to understand your requirements and develop a website that reflects your brand identity. We take advantage of the latest web technologies and responsive design principles to ensure that your website looks amazing and works flawlessly across devices and in addition to a control panel to make you able to control all     site content</p>',1,'en','2024-08-31 08:15:17','2024-08-31 08:15:17'),(3,'انشاء مواقع تجارة الكترونية',NULL,'<p>إذا كنت تتطلع إلى بيع منتجات أو خدمات عبر الإنترنت، فيمكن أن تساعدك خدمات تطوير التجارة الإلكترونية لدينا. لدينا خبرة في بناء منصات تجارة إلكترونية آمنة وقابلة للتطوير توفر تجارب مستخدم سلسة وتكاملًا قويًا للدفع. بدءًا من كتالوجات المنتجات وعربات التسوق وحتى إدارة المخزون ومعالجة الطلبات، نقوم بإنشاء حلول للتجارة الإلكترونية تعمل على زيادة التحويلات وزيادة الإيرادات إلى أقصى حد</p>',2,'ar','2024-08-31 08:15:17','2024-08-31 08:15:17'),(4,'E-commerce Development',NULL,'<p>If you\'re looking to sell products or products online, our e-commerce development products can help. We have expertise in building secure and scalable e-commerce platforms that offer seamless user experiences and robust payment integration. From product catalogs and shopping carts to inventory management and order processing, we create e-commerce solutions that drive conversions and maximize revenue</p>',2,'en','2024-08-31 08:15:17','2024-08-31 08:15:17'),(5,'صيانة ودعم الموقع',NULL,'<p>نحن نؤمن بالشراكات طويلة الأمد مع عملائنا. تضمن خدمات صيانة ودعم موقع الويب لدينا بقاء موقع الويب الخاص بك آمنًا وحديثًا ومحسّنًا للأداء. نحن نقدم تحديثات منتظمة وتصحيحات أمنية ونسخًا احتياطية لحماية موقع الويب الخاص بك من نقاط الضعف. فريق الدعم لدينا متاح لمعالجة أية مشكلات والإجابة على الأسئلة وتقديم المساعدة الفنية المستمرة</p>',3,'ar','2024-08-31 08:15:17','2024-08-31 08:15:17'),(6,'Website Maintenance and Support',NULL,'<p>We believe in long-term partnerships with our clients. Our website maintenance and support products ensure that your website remains secure, up-to-date, and optimized for performance. We provide regular updates, security patches, and backups to protect your website from vulnerabilities. Our support team is available to address any issues, answer questions, and provide ongoing technical assistance </p>',3,'en','2024-08-31 08:15:17','2024-08-31 08:15:17'),(7,'استضافت مواقع ',NULL,'<p>في شركة تطوير الويب لدينا، نقدم خدمات استضافة شاملة للتأكد من أن موقع الويب الخاص بك يعمل على النحو الأمثل ويظل في متناول زوار موقعك. توفر خدمة الاستضافة لدينا بيئة موثوقة وآمنة لازدهار موقع الويب الخاص بك. فيما يلي نظرة عامة على خدمة الاستضافة لدينا:\r\n\r\nبنية تحتية موثوقة للاستضافة: نحن نحافظ على بنية تحتية قوية للاستضافة مع خوادم ومعدات شبكات حديثة. تم تحسين خوادمنا من أجل الأداء، مما يوفر أوقات تحميل سريعة وأقل وقت توقف. نحن نعطي الأولوية للموثوقية للتأكد من أن موقع الويب الخاص بك في متناول الزوار على مدار الساعة.\r\n\r\nحلول قابلة للتطوير: تم تصميم خدمة الاستضافة لدينا لاستيعاب نمو موقع الويب الخاص بك. سواء كان لديك موقع ويب خاص بشركة صغيرة أو تطبيق ويب معقد، فإننا نقدم حلول استضافة قابلة للتطوير يمكنها التكيف مع احتياجاتك المتغيرة. مع توسع موقع الويب الخاص بك، يمكننا بسهولة زيادة موارد الاستضافة للتعامل مع زيادة حركة المرور ومتطلبات البيانات.\r\n\r\nالتدابير الأمنية: نحن نعطي الأولوية لأمن موقع الويب الخاص بك والبيانات التي يحتوي عليها. تتضمن خدمة الاستضافة لدينا إجراءات أمنية قوية مثل جدران الحماية، وأنظمة كشف التسلل، والتحديثات الأمنية المنتظمة. نقوم أيضًا بتنفيذ شهادات SSL لتشفير نقل البيانات وحماية المعلومات الحساسة وبناء الثقة مع زوار موقعك.\r\n\r\nالنسخ الاحتياطي والتعافي من الكوارث: نحن ندرك أهمية حماية البيانات. تتضمن خدمة الاستضافة لدينا نسخًا احتياطية منتظمة لموقعك على الويب والبيانات المرتبطة به. في حالة وجود مشكلة فنية أو حدث غير متوقع، يمكننا استعادة موقع الويب الخاص بك بسرعة لتقليل وقت التوقف عن العمل وفقدان البيانات.\r\n\r\nالدعم الفني: فريق الدعم المخصص لدينا متاح لمساعدتك في أي مخاوف أو مشكلات فنية متعلقة بالاستضافة. سواء كانت لديك أسئلة حول تكوينات الخادم، أو كنت بحاجة إلى مساعدة بشأن إعدادات DNS، أو كنت بحاجة إلى استكشاف الأخطاء وإصلاحها، فإن موظفي الدعم ذوي المعرفة لدينا ليسوا سوى مكالمة هاتفية أو بريد إلكتروني.\r\n\r\nالتوافق مع تقنيات الويب: تدعم خدمة الاستضافة لدينا مجموعة واسعة من تقنيات الويب ولغات البرمجة. سواء تم إنشاء موقع الويب الخاص بك باستخدام PHP أو Python أو Node.js أو أطر عمل أخرى، يمكن لبيئة الاستضافة لدينا أن تلبي متطلباتك المحددة.\r\n\r\nشبكة تسليم المحتوى (CDN): لتحسين أداء موقع الويب الخاص بك، يمكننا دمج شبكة تسليم المحتوى (CDN) في خدمة الاستضافة لدينا. تساعد شبكة CDN على تقديم محتوى موقع الويب الخاص بك بسرعة للزائرين من مواقع جغرافية مختلفة، مما يحسن أوقات التحميل وتجربة المستخدم.\r\n\r\nاستضافة البريد الإلكتروني: إلى جانب استضافة مواقع الويب، نقدم أيضًا خدمات استضافة البريد الإلكتروني. يمكنك الحصول على عناوين بريد إلكتروني احترافية مرتبطة باسم النطاق الخاص بك، مما يوفر تجربة اتصال سلسة وموحدة لشركتك. </p>',4,'ar','2024-08-31 08:15:17','2024-08-31 08:15:17'),(8,'Website Hosting',NULL,'<p>At our web development company, we offer comprehensive hosting products to ensure that your website performs optimally and remains accessible to your visitors. Our hosting product provides a reliable and secure environment for your website to thrive. Here\'s an overview of our hosting product:\r\n\r\n                                Reliable Hosting Infrastructure: We maintain a robust hosting infrastructure with state-of-the-art servers and network equipment. Our servers are optimized for performance, offering fast load times and minimal downtime. We prioritize reliability to ensure that your website is accessible to visitors around the clock.\r\n                                \r\n                                Scalable Solutions: Our hosting product is designed to accommodate your website\'s growth. Whether you have a small business website or a complex web application, we offer scalable hosting solutions that can adapt to your changing needs. As your website expands, we can seamlessly scale up the hosting resources to handle increased traffic and data requirements.\r\n                                \r\n                                Security Measures: We prioritize the security of your website and the data it contains. Our hosting product includes robust security measures such as firewalls, intrusion detection systems, and regular security updates. We also implement SSL certificates to encrypt data transmission, safeguarding sensitive information and building trust with your visitors.\r\n                                \r\n                                Backup and Disaster Recovery: We understand the importance of data protection. Our hosting product includes regular backups of your website and its associated data. In the event of a technical issue or unexpected event, we can quickly restore your website to minimize downtime and data loss.\r\n                                \r\n                                Technical Support: Our dedicated support team is available to assist you with any hosting-related concerns or technical issues. Whether you have questions about server configurations, need assistance with DNS settings, or require troubleshooting, our knowledgeable support staff is just a phone call or email away.\r\n                                \r\n                                Compatibility with Web Technologies: Our hosting product supports a wide range of web technologies and programming languages. Whether your website is built with PHP, Python, Node.js, or other frameworks, our hosting environment can accommodate your specific requirements.\r\n                                \r\n                                Content Delivery Network (CDN): To enhance the performance of your website, we can integrate a Content Delivery Network (CDN) into our hosting product. A CDN helps deliver your website content quickly to visitors from various geographical locations, improving load times and user experience.\r\n                                \r\n                                Email Hosting: Along with website hosting, we also offer email hosting products. You can have professional email addresses associated with your domain name, providing a seamless and unified communication experience for your business.\r\n                                \r\n                                 </p>',4,'en','2024-08-31 08:15:17','2024-08-31 08:15:17');
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
  `icon` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `products`
--

LOCK TABLES `products` WRITE;
/*!40000 ALTER TABLE `products` DISABLE KEYS */;
INSERT INTO `products` (`id`, `icon`, `created_at`, `updated_at`) VALUES (1,'far fa-window-restore','2024-08-31 08:15:17','2024-08-31 08:15:17'),(2,'fas fa-shopping-cart','2024-08-31 08:15:17','2024-08-31 08:15:17'),(3,'fas fa-cog','2024-08-31 08:15:17','2024-08-31 08:15:17'),(4,'fab fa-ioxhost','2024-08-31 08:15:17','2024-08-31 08:15:17');
/*!40000 ALTER TABLE `products` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `projects`
--

DROP TABLE IF EXISTS `projects`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `projects` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '0',
  `cost` double DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=54 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `projects`
--

LOCK TABLES `projects` WRITE;
/*!40000 ALTER TABLE `projects` DISABLE KEYS */;
INSERT INTO `projects` (`id`, `title`, `status`, `cost`, `created_at`, `updated_at`) VALUES (3,'Aljazira',1,5000,NULL,'2024-09-28 05:30:05'),(4,'Asl Eltawfeer',1,15990,NULL,NULL),(5,'Automation',1,0,NULL,NULL),(6,'Boula Nessim',1,0,NULL,NULL),(7,'Celine',1,6000,NULL,NULL),(9,'dreem',1,2500,NULL,NULL),(10,'Egypt Tourism',1,5000,NULL,NULL),(11,'Elalamia Gaming...',1,5000,NULL,NULL),(12,'Elmandra',1,13000,NULL,NULL),(13,'Elmesbaat',1,6000,NULL,NULL),(14,'Elmesbaat image...',1,2000,NULL,NULL),(15,'Emad App',1,0,NULL,NULL),(16,'Emad Website',1,0,NULL,NULL),(17,'Eman',1,0,NULL,NULL),(18,'Eman Cables e-c...',1,0,NULL,NULL),(19,'Eman Mangement...',1,0,NULL,NULL),(20,'ERP',1,12000,NULL,NULL),(21,'eva',1,4000,NULL,NULL),(23,'Ghaz Masr',1,6000,NULL,NULL),(24,'Google Ads',1,0,NULL,NULL),(25,'Haddak Elfayrou...',1,6000,NULL,NULL),(26,'Harmony',1,4000,NULL,NULL),(27,'Instadoctorz',1,0,NULL,NULL),(28,'Jaiden',1,16000,NULL,NULL),(29,'Kareem',1,0,NULL,NULL),(31,'Logat Elasr Mob...',1,10000,NULL,NULL),(32,'Logat Elasr Web...',1,13000,NULL,NULL),(33,'Maher',1,0,NULL,NULL),(34,'Melad Youssef',1,0,NULL,NULL),(35,'Orthodox News',1,7500,NULL,NULL),(36,'Osama',1,0,NULL,NULL),(37,'Payment Gateway...',1,1000,NULL,NULL),(38,'Real Estate (OL...',1,0,NULL,NULL),(39,'Reservya Compan...',1,15000,NULL,NULL),(40,'Reservya Mobile...',1,10000,NULL,NULL),(41,'Reservya Web',1,25000,NULL,NULL),(42,'SoulPharma',1,7000,NULL,NULL),(43,'speed services',1,0,NULL,NULL),(44,'Tadawy',1,6000,NULL,NULL),(45,'Tasks and Auto',1,0,NULL,NULL),(46,'Templates',1,0,NULL,NULL),(47,'unihome',1,3700,NULL,NULL),(48,'Vega',1,3000,NULL,NULL),(49,'Vera Design',1,2000,NULL,NULL),(50,'Video Courses A...',1,0,NULL,NULL),(51,'World Sports',1,10000,NULL,NULL),(52,'Yousab Tech',1,0,NULL,NULL),(53,'Herpal Website',1,9000,'2024-10-08 01:35:43','2024-10-08 01:35:43');
/*!40000 ALTER TABLE `projects` ENABLE KEYS */;
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
INSERT INTO `role_has_permissions` (`permission_id`, `role_id`) VALUES (1,1),(2,1),(3,1),(4,1),(5,1),(6,1),(7,1),(8,1),(9,1),(10,1),(11,1),(12,1),(13,1),(14,1),(15,1),(16,1),(17,1),(18,1),(19,1),(20,1),(21,1),(22,1),(23,1),(24,1),(25,1),(26,1),(27,1),(28,1),(29,1),(30,1),(31,1),(32,1),(33,1),(34,1),(35,1),(36,1),(37,1),(38,1),(39,1),(40,1),(41,1),(42,1),(43,1),(44,1),(45,1),(46,1),(47,1),(48,1),(49,1),(50,1),(51,1),(52,1),(53,1),(54,1),(55,1),(56,1),(57,1),(58,1),(59,1),(60,1),(61,1),(62,1),(63,1),(64,1),(65,1),(66,1),(67,1),(68,1),(69,1),(70,1),(71,1),(72,1),(73,1),(74,1),(75,1),(76,1),(77,1),(78,1),(79,1),(80,1),(81,1),(82,1),(83,1),(84,1),(85,1),(86,1),(87,1),(88,1),(89,1),(90,1),(91,1),(92,1),(93,1),(94,1),(95,1),(96,1),(97,1),(98,1),(37,2),(38,2),(39,2),(40,2);
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
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `roles`
--

LOCK TABLES `roles` WRITE;
/*!40000 ALTER TABLE `roles` DISABLE KEYS */;
INSERT INTO `roles` (`id`, `name`, `guard_name`, `created_at`, `updated_at`) VALUES (1,'Admin','admin','2024-08-31 08:15:17','2024-08-31 08:15:17'),(2,'Employee','admin','2024-08-31 08:15:17','2024-08-31 08:15:17');
/*!40000 ALTER TABLE `roles` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `serviceRequests`
--

DROP TABLE IF EXISTS `serviceRequests`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `serviceRequests` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `phone` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `serviceRequest` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `serviceRequests`
--

LOCK TABLES `serviceRequests` WRITE;
/*!40000 ALTER TABLE `serviceRequests` DISABLE KEYS */;
/*!40000 ALTER TABLE `serviceRequests` ENABLE KEYS */;
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
  `subtitle` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `service_id` bigint(20) unsigned NOT NULL,
  `locale` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `service_translations_service_id_locale_unique` (`service_id`,`locale`),
  KEY `service_translations_locale_index` (`locale`),
  CONSTRAINT `service_translations_service_id_foreign` FOREIGN KEY (`service_id`) REFERENCES `services` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `service_translations`
--

LOCK TABLES `service_translations` WRITE;
/*!40000 ALTER TABLE `service_translations` DISABLE KEYS */;
INSERT INTO `service_translations` (`id`, `title`, `subtitle`, `description`, `service_id`, `locale`, `created_at`, `updated_at`) VALUES (1,'انشاء مواقع الويب',NULL,'<p>نحن متخصصون في إنشاء مواقع ويب مخصصة تناسب احتياجات عملك المحددة. يعمل فريقنا من المطورين والمصممين ذوي الخبرة بشكل وثيق معك لفهم متطلباتك وتطوير موقع ويب يعكس هوية علامتك التجارية. نحن نستفيد من أحدث تقنيات الويب ومبادئ التصميم سريع الاستجابة لضمان أن يبدو موقع الويب الخاص بك مذهلاً ويعمل بشكل لا تشوبه شائبة عبر الأجهزة وبالاضافه الى لوحة تحكم لنجعلك قادر على التحكم فى جميع محتويات الموقع  </p>',1,'ar','2024-08-31 08:15:17','2024-08-31 08:15:17'),(2,'Custom Website Development',NULL,'<p>We specialize in creating custom websites that fit your specific business needs. Our team of experienced developers and designers work closely with you to understand your requirements and develop a website that reflects your brand identity. We take advantage of the latest web technologies and responsive design principles to ensure that your website looks amazing and works flawlessly across devices and in addition to a control panel to make you able to control all     site content</p>',1,'en','2024-08-31 08:15:17','2024-08-31 08:15:17'),(3,'انشاء مواقع تجارة الكترونية',NULL,'<p>إذا كنت تتطلع إلى بيع منتجات أو خدمات عبر الإنترنت، فيمكن أن تساعدك خدمات تطوير التجارة الإلكترونية لدينا. لدينا خبرة في بناء منصات تجارة إلكترونية آمنة وقابلة للتطوير توفر تجارب مستخدم سلسة وتكاملًا قويًا للدفع. بدءًا من كتالوجات المنتجات وعربات التسوق وحتى إدارة المخزون ومعالجة الطلبات، نقوم بإنشاء حلول للتجارة الإلكترونية تعمل على زيادة التحويلات وزيادة الإيرادات إلى أقصى حد</p>',2,'ar','2024-08-31 08:15:17','2024-08-31 08:15:17'),(4,'E-commerce Development',NULL,'<p>If you\'re looking to sell products or services online, our e-commerce development services can help. We have expertise in building secure and scalable e-commerce platforms that offer seamless user experiences and robust payment integration. From product catalogs and shopping carts to inventory management and order processing, we create e-commerce solutions that drive conversions and maximize revenue</p>',2,'en','2024-08-31 08:15:17','2024-08-31 08:15:17'),(5,'صيانة ودعم الموقع',NULL,'<p>نحن نؤمن بالشراكات طويلة الأمد مع عملائنا. تضمن خدمات صيانة ودعم موقع الويب لدينا بقاء موقع الويب الخاص بك آمنًا وحديثًا ومحسّنًا للأداء. نحن نقدم تحديثات منتظمة وتصحيحات أمنية ونسخًا احتياطية لحماية موقع الويب الخاص بك من نقاط الضعف. فريق الدعم لدينا متاح لمعالجة أية مشكلات والإجابة على الأسئلة وتقديم المساعدة الفنية المستمرة</p>',3,'ar','2024-08-31 08:15:17','2024-08-31 08:15:17'),(6,'Website Maintenance and Support',NULL,'<p>We believe in long-term partnerships with our clients. Our website maintenance and support services ensure that your website remains secure, up-to-date, and optimized for performance. We provide regular updates, security patches, and backups to protect your website from vulnerabilities. Our support team is available to address any issues, answer questions, and provide ongoing technical assistance </p>',3,'en','2024-08-31 08:15:17','2024-08-31 08:15:17'),(7,'استضافت مواقع ',NULL,'<p>في شركة تطوير الويب لدينا، نقدم خدمات استضافة شاملة للتأكد من أن موقع الويب الخاص بك يعمل على النحو الأمثل ويظل في متناول زوار موقعك. توفر خدمة الاستضافة لدينا بيئة موثوقة وآمنة لازدهار موقع الويب الخاص بك. فيما يلي نظرة عامة على خدمة الاستضافة لدينا:\r\n\r\nبنية تحتية موثوقة للاستضافة: نحن نحافظ على بنية تحتية قوية للاستضافة مع خوادم ومعدات شبكات حديثة. تم تحسين خوادمنا من أجل الأداء، مما يوفر أوقات تحميل سريعة وأقل وقت توقف. نحن نعطي الأولوية للموثوقية للتأكد من أن موقع الويب الخاص بك في متناول الزوار على مدار الساعة.\r\n\r\nحلول قابلة للتطوير: تم تصميم خدمة الاستضافة لدينا لاستيعاب نمو موقع الويب الخاص بك. سواء كان لديك موقع ويب خاص بشركة صغيرة أو تطبيق ويب معقد، فإننا نقدم حلول استضافة قابلة للتطوير يمكنها التكيف مع احتياجاتك المتغيرة. مع توسع موقع الويب الخاص بك، يمكننا بسهولة زيادة موارد الاستضافة للتعامل مع زيادة حركة المرور ومتطلبات البيانات.\r\n\r\nالتدابير الأمنية: نحن نعطي الأولوية لأمن موقع الويب الخاص بك والبيانات التي يحتوي عليها. تتضمن خدمة الاستضافة لدينا إجراءات أمنية قوية مثل جدران الحماية، وأنظمة كشف التسلل، والتحديثات الأمنية المنتظمة. نقوم أيضًا بتنفيذ شهادات SSL لتشفير نقل البيانات وحماية المعلومات الحساسة وبناء الثقة مع زوار موقعك.\r\n\r\nالنسخ الاحتياطي والتعافي من الكوارث: نحن ندرك أهمية حماية البيانات. تتضمن خدمة الاستضافة لدينا نسخًا احتياطية منتظمة لموقعك على الويب والبيانات المرتبطة به. في حالة وجود مشكلة فنية أو حدث غير متوقع، يمكننا استعادة موقع الويب الخاص بك بسرعة لتقليل وقت التوقف عن العمل وفقدان البيانات.\r\n\r\nالدعم الفني: فريق الدعم المخصص لدينا متاح لمساعدتك في أي مخاوف أو مشكلات فنية متعلقة بالاستضافة. سواء كانت لديك أسئلة حول تكوينات الخادم، أو كنت بحاجة إلى مساعدة بشأن إعدادات DNS، أو كنت بحاجة إلى استكشاف الأخطاء وإصلاحها، فإن موظفي الدعم ذوي المعرفة لدينا ليسوا سوى مكالمة هاتفية أو بريد إلكتروني.\r\n\r\nالتوافق مع تقنيات الويب: تدعم خدمة الاستضافة لدينا مجموعة واسعة من تقنيات الويب ولغات البرمجة. سواء تم إنشاء موقع الويب الخاص بك باستخدام PHP أو Python أو Node.js أو أطر عمل أخرى، يمكن لبيئة الاستضافة لدينا أن تلبي متطلباتك المحددة.\r\n\r\nشبكة تسليم المحتوى (CDN): لتحسين أداء موقع الويب الخاص بك، يمكننا دمج شبكة تسليم المحتوى (CDN) في خدمة الاستضافة لدينا. تساعد شبكة CDN على تقديم محتوى موقع الويب الخاص بك بسرعة للزائرين من مواقع جغرافية مختلفة، مما يحسن أوقات التحميل وتجربة المستخدم.\r\n\r\nاستضافة البريد الإلكتروني: إلى جانب استضافة مواقع الويب، نقدم أيضًا خدمات استضافة البريد الإلكتروني. يمكنك الحصول على عناوين بريد إلكتروني احترافية مرتبطة باسم النطاق الخاص بك، مما يوفر تجربة اتصال سلسة وموحدة لشركتك. </p>',4,'ar','2024-08-31 08:15:17','2024-08-31 08:15:17'),(8,'Website Hosting',NULL,'<p>At our web development company, we offer comprehensive hosting services to ensure that your website performs optimally and remains accessible to your visitors. Our hosting service provides a reliable and secure environment for your website to thrive. Here\'s an overview of our hosting service:\r\n\r\n                                Reliable Hosting Infrastructure: We maintain a robust hosting infrastructure with state-of-the-art servers and network equipment. Our servers are optimized for performance, offering fast load times and minimal downtime. We prioritize reliability to ensure that your website is accessible to visitors around the clock.\r\n                                \r\n                                Scalable Solutions: Our hosting service is designed to accommodate your website\'s growth. Whether you have a small business website or a complex web application, we offer scalable hosting solutions that can adapt to your changing needs. As your website expands, we can seamlessly scale up the hosting resources to handle increased traffic and data requirements.\r\n                                \r\n                                Security Measures: We prioritize the security of your website and the data it contains. Our hosting service includes robust security measures such as firewalls, intrusion detection systems, and regular security updates. We also implement SSL certificates to encrypt data transmission, safeguarding sensitive information and building trust with your visitors.\r\n                                \r\n                                Backup and Disaster Recovery: We understand the importance of data protection. Our hosting service includes regular backups of your website and its associated data. In the event of a technical issue or unexpected event, we can quickly restore your website to minimize downtime and data loss.\r\n                                \r\n                                Technical Support: Our dedicated support team is available to assist you with any hosting-related concerns or technical issues. Whether you have questions about server configurations, need assistance with DNS settings, or require troubleshooting, our knowledgeable support staff is just a phone call or email away.\r\n                                \r\n                                Compatibility with Web Technologies: Our hosting service supports a wide range of web technologies and programming languages. Whether your website is built with PHP, Python, Node.js, or other frameworks, our hosting environment can accommodate your specific requirements.\r\n                                \r\n                                Content Delivery Network (CDN): To enhance the performance of your website, we can integrate a Content Delivery Network (CDN) into our hosting service. A CDN helps deliver your website content quickly to visitors from various geographical locations, improving load times and user experience.\r\n                                \r\n                                Email Hosting: Along with website hosting, we also offer email hosting services. You can have professional email addresses associated with your domain name, providing a seamless and unified communication experience for your business.\r\n                                \r\n                                 </p>',4,'en','2024-08-31 08:15:17','2024-08-31 08:15:17');
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
  `icon` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
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
INSERT INTO `services` (`id`, `icon`, `created_at`, `updated_at`) VALUES (1,'far fa-window-restore','2024-08-31 08:15:17','2024-08-31 08:15:17'),(2,'fas fa-shopping-cart','2024-08-31 08:15:17','2024-08-31 08:15:17'),(3,'fas fa-cog','2024-08-31 08:15:17','2024-08-31 08:15:17'),(4,'fab fa-ioxhost','2024-08-31 08:15:17','2024-08-31 08:15:17');
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
  `appointment1` text COLLATE utf8mb4_unicode_ci,
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
INSERT INTO `setting_translations` (`id`, `address`, `title`, `description`, `appointment1`, `copyright`, `meta_data`, `setting_id`, `locale`, `created_at`, `updated_at`) VALUES (1,NULL,'Yousab Tech','We are a web development company specialized in creating, fixing and mangaing websites using latest technologies and web services',': 24/7','Copyright reserved by Yousab Tech © 2024','Web Development Company',1,'en','2024-08-31 08:15:17','2025-09-23 02:02:55'),(2,'عبر الانترنت','يوساب تك','نحن شركة تطوير لمواقع الويب متخصصون في انشاء,صيانة وادارة مواقع الويب',': 24/7','جميع الحقوق محفوظة لدي يوساب تك © 2023','شركة خدمات ويب',1,'ar','2024-08-31 08:15:17','2024-08-31 08:27:02');
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
INSERT INTO `settings` (`id`, `logo`, `white_logo`, `tab`, `image`, `map`, `created_at`, `updated_at`) VALUES (1,'images/xvTLss2FRKaFg0mwU5qtukmQVhMxFKBVqQxVv4JL.png','images/M8wYYa6zQnLin0iqw5wsCbXELXeJcY9duAPAcstX.png','images/V6EupaXIUSDRmVR4kazZXNgORRj3Lipp0muJnHci.png','images/dE9UdbPVgsAlUq9JDb9lTtn02JH8Au7rdVBTMEGp.png','<iframe src=\"https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d55275.18948853619!2d31.18964315!3d30.016788299999998!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x1458469235579697%3A0x4e91d61f9878fc52!2sGiza%2C%20El%20Omraniya%2C%20Giza%20Governorate!5e0!3m2!1sen!2seg!4v1695471231297!5m2!1sen!2seg\" width=\"600\" height=\"450\" style=\"border:0;\" allowfullscreen=\"\" loading=\"lazy\" referrerpolicy=\"no-referrer-when-downgrade\"></iframe>','2024-08-31 08:15:17','2025-09-23 02:02:55');
/*!40000 ALTER TABLE `settings` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tasks`
--

DROP TABLE IF EXISTS `tasks`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tasks` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '0',
  `employee_id` bigint(20) unsigned DEFAULT NULL,
  `project_id` bigint(20) unsigned DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `tasks_employee_id_foreign` (`employee_id`),
  KEY `tasks_project_id_foreign` (`project_id`),
  CONSTRAINT `tasks_employee_id_foreign` FOREIGN KEY (`employee_id`) REFERENCES `admins` (`id`) ON DELETE CASCADE,
  CONSTRAINT `tasks_project_id_foreign` FOREIGN KEY (`project_id`) REFERENCES `projects` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=520 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tasks`
--

LOCK TABLES `tasks` WRITE;
/*!40000 ALTER TABLE `tasks` DISABLE KEYS */;
INSERT INTO `tasks` (`id`, `title`, `status`, `employee_id`, `project_id`, `created_at`, `updated_at`) VALUES (41,'add shipping details and other additional costs to bill total',0,3,20,'2024-08-31 13:42:27','2024-08-31 16:17:14'),(42,'change logo',1,1,47,'2024-08-31 16:32:28','2024-09-03 01:31:24'),(43,'change logo',1,2,47,'2024-08-31 16:32:28','2024-09-03 01:31:24'),(44,'change logo',1,3,47,'2024-08-31 16:32:28','2024-09-03 01:31:24'),(45,'add title to products',1,1,47,'2024-08-31 16:32:28','2024-08-31 17:26:41'),(46,'add title to products',1,2,47,'2024-08-31 16:32:28','2024-08-31 17:26:41'),(47,'add title to products',1,3,47,'2024-08-31 16:32:28','2024-08-31 17:26:41'),(48,'remove images',1,1,47,'2024-08-31 16:32:28','2024-08-31 17:26:41'),(49,'remove images',1,1,47,'2024-08-31 16:32:28','2024-08-31 17:26:41'),(50,'remove images',1,3,47,'2024-08-31 16:32:28','2024-08-31 17:26:41'),(51,'api for products',1,3,41,'2024-08-31 16:37:13','2024-08-31 17:23:27'),(59,' add levels module with title type(standard none standard) benefits',1,3,41,'2024-08-31 17:13:22','2024-09-04 04:00:29'),(60,' add levels module with title type(standard none standard) benefits',1,3,41,'2024-08-31 17:13:22','2024-09-04 04:00:29'),(61,' add levels module with title type(standard none standard) benefits',1,3,41,'2024-08-31 17:13:22','2024-09-04 04:00:29'),(62,' change $ to EGP',1,3,41,'2024-08-31 17:23:00','2024-09-02 18:14:11'),(63,' change $ to EGP',1,3,41,'2024-08-31 17:23:00','2024-09-02 18:14:11'),(64,' change $ to EGP',1,3,41,'2024-08-31 17:23:00','2024-09-02 18:14:11'),(68,' Customers can send hangout invitation to unregistered users via copy link.',1,4,41,'2024-08-31 17:29:05','2024-09-09 17:00:58'),(69,' Customers can send hangout invitation to unregistered users via copy link.',1,4,41,'2024-08-31 17:29:05','2024-09-09 17:00:58'),(70,' Customers can send hangout invitation to unregistered users via copy link.',1,4,41,'2024-08-31 17:29:05','2024-09-09 17:00:58'),(74,' add payed_ingredients meal_id cost type(extra) as checkbox to meals',1,4,41,'2024-08-31 17:29:35','2024-09-04 03:59:36'),(75,' add payed_ingredients meal_id cost type(extra) as checkbox to meals',1,4,41,'2024-08-31 17:29:35','2024-09-04 03:59:36'),(76,' add payed_ingredients meal_id cost type(extra) as checkbox to meals',1,4,41,'2024-08-31 17:29:35','2024-09-04 03:59:36'),(77,' in cart should determine extras and add them to cart as meals like all added tocart meals but take meal_id',1,4,41,'2024-08-31 17:29:54','2024-09-04 03:59:06'),(78,' in cart should determine extras and add them to cart as meals like all added tocart meals but take meal_id',1,4,41,'2024-08-31 17:29:54','2024-09-04 03:59:06'),(79,' in cart should determine extras and add them to cart as meals like all added tocart meals but take meal_id',1,4,41,'2024-08-31 17:29:54','2024-09-04 03:59:06'),(83,' subscrip strict cors origin working but need to reload and there is no toastr',1,1,41,'2024-08-31 17:30:37','2024-09-04 03:58:32'),(84,' subscrip strict cors origin working but need to reload and there is no toastr',1,1,41,'2024-08-31 17:30:37','2024-09-04 03:58:32'),(85,' subscrip strict cors origin working but need to reload and there is no toastr',1,1,41,'2024-08-31 17:30:37','2024-09-04 03:58:32'),(86,' subscription pla',1,4,41,'2024-08-31 17:30:56','2024-09-04 20:38:37'),(87,' subscription pla',1,4,41,'2024-08-31 17:30:56','2024-09-04 20:38:37'),(88,' subscription pla',1,4,41,'2024-08-31 17:30:56','2024-09-04 20:38:37'),(89,'purchase ph must be percentage',1,1,20,'2024-08-31 17:44:50','2024-09-16 22:57:15'),(90,'purchase ph must be percentage',1,3,20,'2024-08-31 17:44:50','2024-09-16 22:57:15'),(91,'product transfer need to update',1,1,20,'2024-08-31 17:44:50','2024-09-01 03:03:46'),(92,'product transfer need to update',1,3,20,'2024-08-31 17:44:50','2024-09-01 03:03:46'),(93,'products count in branches',1,1,20,'2024-08-31 17:44:50','2024-09-02 19:32:24'),(94,'products count in branches',1,3,20,'2024-08-31 17:44:50','2024-09-02 19:32:24'),(95,'when delete must do the opposite in producttransfer',1,1,20,'2024-08-31 17:44:50','2024-09-02 23:21:19'),(96,'when delete must do the opposite in producttransfer',1,3,20,'2024-08-31 17:44:50','2024-09-02 23:21:19'),(97,'damageproduct ajax issuesame as producttransfer',1,1,20,'2024-08-31 17:44:50','2024-09-02 19:02:35'),(98,'damageproduct ajax issuesame as producttransfer',1,3,20,'2024-08-31 17:44:50','2024-09-02 19:02:35'),(99,'show price in producttransfer',1,1,20,'2024-08-31 17:44:50','2024-09-02 19:02:11'),(100,'show price in producttransfer',1,3,20,'2024-08-31 17:44:50','2024-09-02 19:02:11'),(101,'enable permissions in admin',1,1,20,'2024-08-31 17:44:50','2024-09-02 23:22:58'),(102,'enable permissions in admin',1,3,20,'2024-08-31 17:44:50','2024-09-02 23:22:58'),(103,'',1,1,20,'2024-08-31 17:44:50','2024-08-31 17:45:09'),(104,'',1,3,20,'2024-08-31 17:44:50','2024-08-31 17:45:09'),(105,'handle google ad',1,1,5,'2024-08-31 17:49:21','2024-09-16 22:57:15'),(106,'supervise google ad',1,1,28,'2024-08-31 17:49:43','2024-09-16 22:57:15'),(107,'make the website resbonsive',1,1,48,'2024-08-31 17:51:35','2024-09-16 22:57:15'),(108,'have meeting with client',1,1,26,'2024-08-31 17:51:56','2024-10-08 22:22:06'),(109,'have meeting with client',1,3,26,'2024-08-31 17:51:56','2024-10-08 22:22:06'),(112,'fix resbonsive',1,1,44,'2024-08-31 17:53:03','2024-09-02 00:21:10'),(113,'fix resbonsive',1,2,44,'2024-08-31 17:53:03','2024-09-02 00:21:10'),(116,'revise appli8cation to complete it',0,1,28,'2024-08-31 17:53:36','2024-08-31 17:53:36'),(117,'revise appli8cation to complete it',0,3,28,'2024-08-31 17:53:36','2024-08-31 17:53:36'),(118,'fix design',1,1,51,'2024-08-31 17:54:25','2024-09-07 23:22:30'),(119,'fix design',1,2,51,'2024-08-31 17:54:25','2024-09-07 23:22:30'),(124,'add quiz',1,1,47,'2024-08-31 17:55:36','2024-09-08 20:47:49'),(125,'reactive their hosting',1,1,5,'2024-08-31 17:56:47','2024-09-16 22:57:15'),(137,' solve cors origin error',1,1,41,'2024-08-31 18:03:12','2024-09-09 17:00:58'),(138,'change logo image',1,2,41,'2024-08-31 18:05:10','2024-08-31 21:04:37'),(139,' change cards to be two in small screens',1,2,41,'2024-08-31 18:05:10','2024-08-31 21:16:47'),(140,'change admin color icon ',1,2,41,'2024-08-31 18:05:10','2024-08-31 23:50:21'),(141,' disable button when creating a hangout',1,2,41,'2024-08-31 18:05:10','2024-09-04 20:29:14'),(142,' in system message minimum charge add value',1,2,41,'2024-08-31 18:05:10','2024-09-02 02:43:15'),(145,' after hangout submit navigate to chat',1,4,41,'2024-08-31 18:07:14','2024-08-31 19:07:07'),(148,'enable reciving messages through email',1,1,28,'2024-08-31 18:28:54','2024-09-10 07:24:51'),(149,'enable reciving messages through email',1,3,28,'2024-08-31 18:28:54','2024-09-10 07:24:51'),(150,'navbar design',1,2,41,'2024-08-31 18:55:00','2024-08-31 23:19:45'),(151,' show ads after specific number of restaurants ',1,1,41,'2024-08-31 18:59:34','2024-09-03 01:31:24'),(152,' show ads after specific number of restaurants ',1,4,41,'2024-08-31 18:59:34','2024-09-03 01:31:24'),(154,'after hangout submit navigate to chat http://localhost:5173/chat/12 where 12 refer to hangout id',1,4,41,'2024-08-31 19:07:53','2024-09-03 01:31:24'),(155,'Remove visa from hosting',1,1,5,'2024-08-31 20:33:32','2024-09-02 17:51:33'),(156,'Signup is not working',1,1,41,'2024-08-31 21:30:15','2024-09-03 01:31:24'),(157,'Signup is not working',1,4,41,'2024-08-31 21:30:15','2024-09-03 01:31:24'),(158,'Show forms validations using html attributes',0,4,41,'2024-08-31 22:30:34','2024-08-31 22:30:34'),(159,'forget password',1,1,47,'2024-09-01 00:02:09','2024-09-03 01:31:24'),(160,'forget password',1,3,47,'2024-09-01 00:02:09','2024-09-03 01:31:24'),(161,'google login',1,1,47,'2024-09-01 00:02:09','2024-09-16 22:57:15'),(162,'google login',1,3,47,'2024-09-01 00:02:09','2024-09-16 22:57:15'),(163,'Send mina email credentials ',1,1,28,'2024-09-01 08:25:00','2024-09-03 01:31:24'),(164,' edit contacts data',1,1,28,'2024-09-01 08:25:00','2024-09-02 17:52:18'),(167,'change logo ',1,1,41,'2024-09-01 21:13:26','2024-09-03 01:31:24'),(168,' edit api',1,1,41,'2024-09-01 21:13:26','2024-09-03 01:31:24'),(172,'show and donot show cost should be enabled in front ',0,2,41,'2024-09-01 21:49:17','2024-09-04 14:33:24'),(173,'show and donot show cost should be enabled in front ',0,3,41,'2024-09-01 21:49:17','2024-09-04 14:33:24'),(174,'show and donot show cost should be enabled in front ',0,4,41,'2024-09-01 21:49:17','2024-09-04 14:33:24'),(190,'change email in contacts',1,1,28,'2024-09-02 02:56:41','2024-09-16 22:57:15'),(191,'change email in contacts',1,3,28,'2024-09-02 02:56:41','2024-09-16 22:57:15'),(192,'Show count of unique tasks',1,1,5,'2024-09-02 12:05:07','2024-09-02 17:30:30'),(196,' remove hangout after specific time determined in dashboard',1,3,41,'2024-09-02 17:53:56','2024-09-03 21:30:30'),(197,' remove hangout after specific time determined in dashboard',1,3,41,'2024-09-02 17:53:56','2024-09-03 21:30:30'),(198,' remove hangout after specific time determined in dashboard',1,3,41,'2024-09-02 17:53:56','2024-09-03 21:30:30'),(199,'Fix csrf issue',1,1,47,'2024-09-02 18:05:37','2024-09-08 20:47:49'),(205,'fix responsive in arabic (mobile)',1,2,44,'2024-09-02 23:05:53','2024-09-03 21:10:17'),(206,'Check eman new app reqs cost',1,1,5,'2024-09-03 01:42:52','2024-09-09 19:04:59'),(207,'Check eman new app reqs cost',1,3,5,'2024-09-03 01:42:52','2024-09-09 19:04:59'),(208,'Add ibrahim to google add as admin',1,1,5,'2024-09-03 02:07:52','2024-09-16 22:57:15'),(209,'Make ibrahim see all tasks',1,1,5,'2024-09-03 02:08:59','2024-09-16 22:57:15'),(210,'Fix dropdown menu',1,1,48,'2024-09-03 02:17:58','2024-09-16 22:57:15'),(211,'Edit logo as required',0,1,5,'2024-09-03 02:33:13','2024-09-03 02:33:13'),(213,'Trip opens on bottom of page',0,1,28,'2024-09-03 12:30:59','2024-09-03 12:30:59'),(214,'Trip opens on bottom of page',0,2,28,'2024-09-03 12:30:59','2024-09-03 12:30:59'),(217,'lates 10 reviews only appear in reviews',1,3,41,'2024-09-03 17:08:34','2024-09-03 18:58:01'),(218,'lates 10 reviews only appear in reviews',1,3,41,'2024-09-03 17:08:34','2024-09-03 18:58:01'),(219,'lates 10 reviews only appear in reviews',1,3,41,'2024-09-03 17:08:34','2024-09-03 18:58:01'),(220,' rename Minimum Charge Value to Minimum Charge Value per person',1,2,41,'2024-09-03 17:24:54','2024-09-04 02:08:46'),(221,' rename Minimum Charge Value to Minimum Charge Value per person',1,2,41,'2024-09-03 17:24:54','2024-09-04 02:08:46'),(222,' rename Minimum Charge Value to Minimum Charge Value per person',1,2,41,'2024-09-03 17:24:54','2024-09-04 02:08:46'),(226,' system messages appear after reservation',1,10,41,'2024-09-03 17:32:08','2024-09-04 20:37:15'),(227,' system messages appear after reservation',1,10,41,'2024-09-03 17:32:08','2024-09-04 20:37:15'),(228,' system messages appear after reservation',1,10,41,'2024-09-03 17:32:08','2024-09-04 20:37:15'),(229,' add order cost besides Minimum Charge Value 390 EGP',1,4,41,'2024-09-03 17:33:05','2024-09-04 01:28:43'),(230,' add order cost besides Minimum Charge Value 390 EGP',1,4,41,'2024-09-03 17:33:05','2024-09-04 01:28:43'),(231,' add order cost besides Minimum Charge Value 390 EGP',1,4,41,'2024-09-03 17:33:05','2024-09-04 01:28:43'),(232,'Fix reservation process in backend',0,1,41,'2024-09-03 17:35:06','2024-09-03 17:35:06'),(236,'test forms in front',1,3,28,'2024-09-03 17:37:06','2024-09-10 07:22:43'),(237,'edit course and job filter',0,1,51,'2024-09-03 17:42:31','2024-09-03 17:42:31'),(238,'edit course and job filter',0,1,51,'2024-09-03 17:42:31','2024-09-03 17:42:31'),(239,'test single pages',0,1,51,'2024-09-03 17:42:31','2024-09-03 17:42:31'),(240,'test single pages',0,1,51,'2024-09-03 17:42:31','2024-09-03 17:42:31'),(241,'change content',1,3,44,'2024-09-03 17:43:00','2024-09-09 18:57:41'),(242,'change content',1,3,44,'2024-09-03 17:43:00','2024-09-09 18:57:41'),(243,'change sections order',1,3,44,'2024-09-03 17:43:26','2024-09-09 18:56:43'),(244,'change sections order',1,3,44,'2024-09-03 17:43:26','2024-09-09 18:56:43'),(254,'Add view ingredient in other mwals',1,10,41,'2024-09-04 00:28:52','2024-09-09 17:00:58'),(257,' change options to make order pay minimum charge and cance',0,10,41,'2024-09-04 01:28:21','2024-09-04 01:28:21'),(258,' change options to make order pay minimum charge and cance',0,10,41,'2024-09-04 01:28:21','2024-09-04 01:28:21'),(259,' change options to make order pay minimum charge and cance',0,10,41,'2024-09-04 01:28:21','2024-09-04 01:28:21'),(260,'Validate instgram in signup form',1,4,41,'2024-09-04 01:30:31','2024-09-04 20:33:43'),(261,'Validate instgram in signup form',1,4,41,'2024-09-04 01:30:31','2024-09-04 20:33:43'),(267,' confirm system message should appear when it is time',0,10,41,'2024-09-04 03:57:11','2024-09-04 03:57:11'),(268,'password should be of table not reservation ',0,10,41,'2024-09-04 03:57:11','2024-09-04 03:57:11'),(269,' cannot add meals from two restaurants',1,3,41,'2024-09-04 03:58:07','2024-09-04 23:02:59'),(270,' cannot add meals from two restaurants',1,10,41,'2024-09-04 03:58:07','2024-09-04 23:02:59'),(271,'add qrcode to table to navigate you to in restaurant with table number',1,3,41,'2024-09-04 03:58:07','2024-09-09 17:00:58'),(272,'add qrcode to table to navigate you to in restaurant with table number',1,10,41,'2024-09-04 03:58:07','2024-09-09 17:00:58'),(273,'add hide option to category and add appearance time interval(note local and future)',1,10,41,'2024-09-04 04:00:07','2024-09-04 20:29:14'),(274,'add hide option to category and add appearance time interval(note local and future)',1,10,41,'2024-09-04 04:00:07','2024-09-04 20:29:14'),(275,'add hide option to category and add appearance time interval(note local and future)',1,10,41,'2024-09-04 04:00:07','2024-09-04 20:29:14'),(276,'Add extras as backend and local storage',1,1,41,'2024-09-04 14:34:53','2024-09-04 23:02:49'),(277,'Add extras as backend and local storage',1,3,41,'2024-09-04 14:34:53','2024-09-04 23:02:49'),(278,'Add extras as backend and local storage',1,10,41,'2024-09-04 14:34:53','2024-09-04 23:02:49'),(282,'Activate the bonus when paying the total in cash; otherwise, the bonus remains inactive.',1,1,20,'2024-09-04 18:49:39','2024-09-06 23:14:42'),(283,'Activate the bonus when paying the total in cash; otherwise, the bonus remains inactive.',1,3,20,'2024-09-04 18:49:39','2024-09-06 23:14:42'),(284,'add discount percentage value  before  general total ',1,1,20,'2024-09-04 18:53:18','2024-09-07 02:25:08'),(285,'add discount percentage value  before  general total ',1,3,20,'2024-09-04 18:53:18','2024-09-07 02:25:08'),(286,' remove print button',1,1,20,'2024-09-04 18:53:18','2024-09-06 21:43:09'),(287,' remove print button',1,3,20,'2024-09-04 18:53:18','2024-09-06 21:43:09'),(288,'update status of the sales that depend on payment period',1,1,20,'2024-09-04 18:56:43','2024-09-07 08:58:42'),(289,'update status of the sales that depend on payment period',1,3,20,'2024-09-04 18:56:43','2024-09-07 08:58:42'),(290,'arrange sales product in sales show to product, patch,  sales price, discount, price after discount, count, bouns, total',1,1,20,'2024-09-04 18:57:58','2024-09-06 21:42:15'),(291,'arrange sales product in sales show to product, patch,  sales price, discount, price after discount, count, bouns, total',1,3,20,'2024-09-04 18:57:58','2024-09-06 21:42:15'),(292,'add reports in the roles',1,1,20,'2024-09-04 18:59:01','2024-09-06 21:49:46'),(293,'add reports in the roles',1,3,20,'2024-09-04 18:59:01','2024-09-06 21:49:46'),(294,'appear discount percentage in product create',1,1,20,'2024-09-04 19:03:34','2024-09-06 22:27:44'),(295,'appear discount percentage in product create',1,3,20,'2024-09-04 19:03:34','2024-09-06 22:27:44'),(296,'check transaction from and to (calculate balance wrong )',1,1,20,'2024-09-04 19:29:17','2024-09-06 23:53:38'),(297,'check transaction from and to (calculate balance wrong )',1,3,20,'2024-09-04 19:29:17','2024-09-06 23:53:38'),(298,'update admin register API (firstname,lastname,username,file) (trainer,trainee)',1,3,51,'2024-09-04 20:20:13','2024-09-10 07:19:50'),(299,'Add extras as backend and local storage',1,1,41,'2024-09-04 20:24:48','2024-09-04 23:02:49'),(300,'Add extras as backend and local storage',1,3,41,'2024-09-04 20:24:48','2024-09-04 23:02:49'),(301,'Add extras as backend and local storage',1,10,41,'2024-09-04 20:24:48','2024-09-04 23:02:49'),(302,'Add Restaurant_id inside the single meal API',1,3,41,'2024-09-04 20:45:19','2024-09-04 23:02:34'),(303,' categories inside restaurant should be renamed to menu categories and categories outside restaurant should be like bar ... etc',1,10,41,'2024-09-04 21:14:17','2024-09-09 17:00:58'),(304,' categories inside restaurant should be renamed to menu categories and categories outside restaurant should be like bar ... etc',1,10,41,'2024-09-04 21:14:17','2024-09-09 17:00:58'),(305,' categories inside restaurant should be renamed to menu categories and categories outside restaurant should be like bar ... etc',1,10,41,'2024-09-04 21:14:17','2024-09-09 17:00:58'),(306,' categories inside restaurant should be renamed to menu categories and categories outside restaurant should be like bar ... etc',1,10,41,'2024-09-04 21:14:17','2024-09-09 17:00:58'),(307,' categories inside restaurant should be renamed to menu categories and categories outside restaurant should be like bar ... etc',1,10,41,'2024-09-04 21:14:17','2024-09-09 17:00:58'),(308,' categories inside restaurant should be renamed to menu categories and categories outside restaurant should be like bar ... etc',1,10,41,'2024-09-04 21:14:17','2024-09-09 17:00:58'),(309,' categories inside restaurant should be renamed to menu categories and categories outside restaurant should be like bar ... etc',1,10,41,'2024-09-04 21:14:17','2024-09-09 17:00:58'),(310,' categories inside restaurant should be renamed to menu categories and categories outside restaurant should be like bar ... etc',1,10,41,'2024-09-04 21:14:17','2024-09-09 17:00:58'),(311,' categories inside restaurant should be renamed to menu categories and categories outside restaurant should be like bar ... etc',1,10,41,'2024-09-04 21:14:17','2024-09-09 17:00:58'),(312,'Change API restaurant_location_category, restaurant_category_location to Outside Category not the normal category',1,3,41,'2024-09-04 21:20:30','2024-09-04 22:58:24'),(313,'Reservation using QR Code Send Params in URL Restaurant_id , Table_id',1,3,41,'2024-09-04 21:25:40','2024-09-09 17:00:58'),(314,'Add  delete option to permissions and group them',0,1,5,'2024-09-05 00:24:50','2024-09-05 00:24:50'),(315,'Make options inside datatable work with localstorage to eemmber settings',0,1,5,'2024-09-05 00:59:12','2024-09-05 00:59:12'),(317,'Fix profile teacher and profile student ',1,1,47,'2024-09-05 02:32:12','2024-09-08 20:47:49'),(318,' add api to get profile data of logged in user',1,1,47,'2024-09-05 02:32:12','2024-09-08 20:47:49'),(319,'Add more options in reservation with somking,non smoking',1,3,41,'2024-09-05 03:31:42','2024-09-12 02:45:43'),(320,'Add more options in reservation with somking,non smoking',1,4,41,'2024-09-05 03:31:42','2024-09-12 02:45:43'),(321,'Follow ads from yoyr mobile',1,1,5,'2024-09-05 03:38:03','2024-09-16 22:57:15'),(322,'Send miba correct email credentials',1,1,28,'2024-09-05 05:25:58','2024-09-16 22:57:15'),(323,'Show mab once loaded',1,1,51,'2024-09-05 17:13:37','2024-09-06 04:40:32'),(324,'Show mab once loaded',1,2,51,'2024-09-05 17:13:37','2024-09-06 04:40:32'),(332,'Copy quiz module from logat to unihome',1,1,5,'2024-09-06 19:42:39','2024-09-08 20:47:49'),(333,'Copy quiz module from logat to unihome',1,3,5,'2024-09-06 19:42:39','2024-09-08 20:47:49'),(336,'Change slider images',1,1,5,'2024-09-06 19:44:30','2024-09-16 22:57:15'),(337,'show all data as latest',1,1,41,'2024-09-06 19:44:30','2024-09-09 00:31:18'),(338,'show all data as latest',1,1,41,'2024-09-06 19:44:30','2024-09-09 00:31:18'),(339,'show all data as latest',1,1,41,'2024-09-06 19:44:30','2024-09-09 00:31:18'),(340,'remove Max Price For Person from hangout',1,1,41,'2024-09-06 19:44:30','2024-09-09 00:31:18'),(341,'remove Max Price For Person from hangout',1,1,41,'2024-09-06 19:44:30','2024-09-09 00:31:18'),(346,'Reschdeul and cancel options ',1,1,47,'2024-09-08 20:49:14','2024-09-16 22:57:15'),(347,' calc session out of wallet',1,1,47,'2024-09-08 20:49:14','2024-09-16 22:57:15'),(348,'Chwck with maher bew app details and create for him a contract',1,1,47,'2024-09-08 20:51:18','2024-09-08 20:51:53'),(349,'Chwck with maher bew app details and create for him a contract',1,3,47,'2024-09-08 20:51:18','2024-09-08 20:51:53'),(350,'Check with maher new app and give him a contract',1,1,47,'2024-09-08 20:52:36','2024-09-16 23:15:00'),(351,'Check with maher new app and give him a contract',1,3,47,'2024-09-08 20:52:36','2024-09-16 23:15:00'),(352,'product detail missing some section',0,1,51,'2024-09-10 07:22:00','2024-09-10 07:22:00'),(353,'product detail missing some section',0,3,51,'2024-09-10 07:22:00','2024-09-10 07:22:00'),(354,'make insert doctors dynamic',1,1,26,'2024-09-10 07:26:31','2024-09-12 02:45:25'),(355,'make insert doctors dynamic',1,2,26,'2024-09-10 07:26:31','2024-09-12 02:45:25'),(356,'make insert doctors dynamic',1,3,26,'2024-09-10 07:26:31','2024-09-12 02:45:25'),(357,'fix responsive',1,1,20,'2024-09-11 17:41:43','2024-09-11 19:07:43'),(358,'fix responsive',1,2,20,'2024-09-11 17:41:43','2024-09-11 19:07:43'),(359,'fix responsive',1,3,20,'2024-09-11 17:41:43','2024-09-11 19:07:43'),(360,'fix responsive',1,1,20,'2024-09-11 17:41:43','2024-09-11 19:07:43'),(361,'fix responsive',1,2,20,'2024-09-11 17:41:43','2024-09-11 19:07:43'),(362,'fix responsive',1,3,20,'2024-09-11 17:41:43','2024-09-11 19:07:43'),(363,'fix Discount Percentage  value in sales',1,1,20,'2024-09-11 18:09:05','2024-09-26 21:41:45'),(364,'fix Discount Percentage  value in sales',1,3,20,'2024-09-11 18:09:05','2024-09-26 21:41:45'),(365,'make branches connected with  Pharmacists by Ajax',1,1,20,'2024-09-11 18:11:20','2024-09-11 19:20:41'),(366,'make branches connected with  Pharmacists by Ajax',1,3,20,'2024-09-11 18:11:20','2024-09-11 19:20:41'),(367,'fix errors while testing  reference on WhatsApp',1,1,20,'2024-09-11 18:12:11','2024-09-12 02:42:20'),(368,'fix errors while testing  reference on WhatsApp',1,3,20,'2024-09-11 18:12:11','2024-09-12 02:42:20'),(369,'Subject in Contact form ',1,3,51,'2024-09-11 19:24:46','2024-09-12 02:45:08'),(370,' Product details {  desc, custom block ,review form}',1,3,51,'2024-09-11 19:24:46','2024-09-12 02:45:20'),(371,'video link in single career',1,2,51,'2024-09-11 19:40:06','2024-09-12 02:45:15'),(372,'video link in single career',1,3,51,'2024-09-11 19:40:06','2024-09-12 02:45:15'),(373,'fix icon',1,1,26,'2024-09-12 18:58:45','2024-09-15 21:19:59'),(374,'fix icon',1,3,26,'2024-09-12 18:58:45','2024-09-15 21:19:59'),(375,'remove dubai and change number of watssapp',1,1,26,'2024-09-12 19:04:51','2024-09-15 21:19:50'),(376,'remove dubai and change number of watssapp',1,3,26,'2024-09-12 19:04:51','2024-09-15 21:19:50'),(377,'add email support@unihome.com',1,1,47,'2024-09-15 17:34:56','2024-09-15 21:26:45'),(378,'add email support@unihome.com',1,3,47,'2024-09-15 17:34:56','2024-09-15 21:26:45'),(379,'enable change password in profile',1,1,47,'2024-09-15 17:34:56','2024-09-16 23:11:48'),(380,'enable change password in profile',1,3,47,'2024-09-15 17:34:56','2024-09-16 23:11:48'),(381,'check front and take descession about creating',1,1,5,'2024-09-15 17:43:45','2024-09-16 23:11:37'),(382,'check front and take descession about creating',1,3,5,'2024-09-15 17:43:45','2024-09-16 23:11:37'),(383,'fix design of mishoo app',1,1,5,'2024-09-15 17:48:41','2024-09-16 22:57:15'),(384,'check medhat ad issue',1,1,5,'2024-09-15 19:43:09','2024-09-16 22:57:15'),(385,'make time in teacher edit in minuts only no seconds',1,1,47,'2024-09-15 19:43:55','2024-09-16 22:57:15'),(386,'Show options in reservation according to restaurant in dashboard',0,1,41,'2024-09-17 20:50:43','2024-09-17 20:50:43'),(387,'Show options in reservation according to restaurant in dashboard',0,2,41,'2024-09-17 20:50:43','2024-09-17 20:50:43'),(388,'Show options in reservation according to restaurant in dashboard',0,3,41,'2024-09-17 20:50:43','2024-09-17 20:50:43'),(389,'Show indoor and outdoor inside them put options smoking,seaview,pool,etc',0,1,41,'2024-09-17 20:55:30','2024-09-17 20:55:30'),(390,'Show indoor and outdoor inside them put options smoking,seaview,pool,etc',0,2,41,'2024-09-17 20:55:30','2024-09-17 20:55:30'),(391,'Show indoor and outdoor inside them put options smoking,seaview,pool,etc',0,3,41,'2024-09-17 20:55:30','2024-09-17 20:55:30'),(392,'Edit breadcrump when choose category',1,1,41,'2024-09-17 21:05:44','2024-09-20 01:27:37'),(393,'Edit breadcrump when choose category',1,2,41,'2024-09-17 21:05:44','2024-09-20 01:27:37'),(394,'change the breadcrumb title dynamically based on the name of the page or section (OutsideCategories)',1,1,41,'2024-09-17 21:09:06','2024-09-20 01:27:37'),(395,'change the breadcrumb title dynamically based on the name of the page or section (OutsideCategories)',1,2,41,'2024-09-17 21:09:06','2024-09-20 01:27:37'),(396,'change the breadcrumb title dynamically based on the name of the page or section (OutsideCategories)',1,3,41,'2024-09-17 21:09:06','2024-09-20 01:27:37'),(397,'Do not show categories and locations if tgey are empty',0,1,41,'2024-09-17 21:12:49','2024-09-17 21:12:49'),(398,'Do not show categories and locations if tgey are empty',0,3,41,'2024-09-17 21:12:49','2024-09-17 21:12:49'),(399,'hide or show the outside category based on whether it belongs to a specific restaurant',1,1,41,'2024-09-17 21:16:46','2024-09-19 23:14:40'),(400,'hide or show the outside category based on whether it belongs to a specific restaurant',1,2,41,'2024-09-17 21:16:46','2024-09-19 23:14:40'),(401,'hide or show the outside category based on whether it belongs to a specific restaurant',1,3,41,'2024-09-17 21:16:46','2024-09-19 23:14:40'),(402,'Qr code design not same abd need to show options when click call waiter',0,10,41,'2024-09-17 21:40:08','2024-09-17 21:40:08'),(403,'If table more than persons ok but less restrict or valudate it',1,1,41,'2024-09-17 22:47:37','2024-09-20 01:57:14'),(404,'If table more than persons ok but less restrict or valudate it',1,2,41,'2024-09-17 22:47:37','2024-09-20 01:57:14'),(405,'Client pay minimum charge and add value to reservation wallet if he made order under minimum or even many orders that does not exceed min and if exceeded min psy the extra by credit or when reach restaurant',0,1,41,'2024-09-17 23:36:57','2024-09-17 23:36:57'),(406,'Client pay minimum charge and add value to reservation wallet if he made order under minimum or even many orders that does not exceed min and if exceeded min psy the extra by credit or when reach restaurant',0,3,41,'2024-09-17 23:36:57','2024-09-17 23:36:57'),(407,'Client pay minimum charge and add value to reservation wallet if he made order under minimum or even many orders that does not exceed min and if exceeded min psy the extra by credit or when reach restaurant',0,4,41,'2024-09-17 23:36:57','2024-09-17 23:36:57'),(408,'Display none unneeded inputs in students dashboard',1,3,47,'2024-09-18 04:59:12','2024-09-18 19:02:57'),(409,'Test routes',0,1,41,'2024-09-18 05:10:10','2024-09-18 05:10:10'),(410,'Add single session api ',1,1,47,'2024-09-18 05:59:28','2024-09-18 18:09:46'),(411,'Add single session api ',1,3,47,'2024-09-18 05:59:28','2024-09-18 18:09:46'),(412,' make wallet sender admin only and check missings',1,1,47,'2024-09-18 05:59:28','2024-09-18 18:26:56'),(413,' make wallet sender admin only and check missings',1,3,47,'2024-09-18 05:59:28','2024-09-18 18:26:56'),(414,'Fix login expiration and redirect if not athinticated',0,10,41,'2024-09-18 20:36:02','2024-09-18 20:36:02'),(415,'Make sure that booking session deduct from user balance ',1,3,47,'2024-09-19 02:41:54','2024-09-19 03:00:28'),(416,' send user balance in wallet resource ',1,3,47,'2024-09-19 02:41:54','2024-09-19 03:00:28'),(417,' make edit stident has only student attributes and show as well',1,3,47,'2024-09-19 02:41:54','2024-09-19 02:51:34'),(418,'Add percenrage of admin in setting',1,3,41,'2024-09-19 09:22:45','2024-09-22 23:40:32'),(419,' cancel sesion should be within 24 hours',1,3,41,'2024-09-19 09:22:45','2024-09-22 23:40:32'),(420,'Add percenrage of admin in setting',1,3,47,'2024-09-19 09:23:15','2024-09-22 23:40:32'),(421,' cancel sesion should be within 24 hours',1,3,47,'2024-09-19 09:23:15','2024-09-22 23:40:32'),(422,'Edit email content',0,1,28,'2024-09-19 22:52:55','2024-09-19 22:52:55'),(423,'Edit email content',0,3,28,'2024-09-19 22:52:55','2024-09-19 22:52:55'),(424,'rotate email srnd and receivee',0,1,28,'2024-09-19 22:52:55','2024-09-19 22:52:55'),(425,'rotate email srnd and receivee',0,3,28,'2024-09-19 22:52:55','2024-09-19 22:52:55'),(426,'Website needs to be dynamic but not before getting half of its cost',0,1,26,'2024-09-20 11:36:14','2024-09-20 11:36:14'),(427,'Website needs to be dynamic but not before getting half of its cost',0,3,26,'2024-09-20 11:36:14','2024-09-20 11:36:14'),(428,'Add quiz to app',0,1,32,'2024-09-20 11:37:16','2024-09-20 11:37:16'),(429,'Remove /admin from routes',0,1,5,'2024-09-21 03:19:08','2024-09-21 03:19:08'),(430,'Add new page reservation hangout process abd add reservation number ',0,3,41,'2024-09-21 04:12:18','2024-09-21 04:12:18'),(431,'Add new page reservation hangout process abd add reservation number ',0,10,41,'2024-09-21 04:12:18','2024-09-21 04:12:18'),(432,'add note to show that left people may increase in yellow',0,3,41,'2024-09-21 04:12:18','2024-09-21 04:12:18'),(433,'add note to show that left people may increase in yellow',0,10,41,'2024-09-21 04:12:18','2024-09-21 04:12:18'),(434,' restaurant logo in in restaurant',0,3,41,'2024-09-21 04:12:18','2024-09-21 04:12:18'),(435,' restaurant logo in in restaurant',0,10,41,'2024-09-21 04:12:18','2024-09-21 04:12:18'),(436,' show call waiter salt and other options in  witer and add them dynamic in dashboard ',0,3,41,'2024-09-21 04:12:18','2024-09-21 04:12:18'),(437,' show call waiter salt and other options in  witer and add them dynamic in dashboard ',0,10,41,'2024-09-21 04:12:18','2024-09-21 04:12:18'),(438,' in zeyads additional page make it welcone to restayrant name and remove call manager',0,3,41,'2024-09-21 04:12:18','2024-09-21 04:12:18'),(439,' in zeyads additional page make it welcone to restayrant name and remove call manager',0,10,41,'2024-09-21 04:12:18','2024-09-21 04:12:18'),(440,'Chage handling order from two restaurants  using modal with two options complete or empty cart',0,3,41,'2024-09-21 04:15:00','2024-09-21 04:15:00'),(441,'Chage handling order from two restaurants  using modal with two options complete or empty cart',0,10,41,'2024-09-21 04:15:00','2024-09-21 04:15:00'),(442,'Fix responsive design ( mobile - tablet)',0,1,20,'2024-09-21 04:35:16','2024-09-21 04:35:16'),(443,'Fix responsive design ( mobile - tablet)',0,2,20,'2024-09-21 04:35:16','2024-09-21 04:35:16'),(444,'Put logo in track order page and put track order after order submit ',0,1,41,'2024-09-21 04:56:22','2024-09-21 04:56:22'),(445,'Put logo in track order page and put track order after order submit ',0,3,41,'2024-09-21 04:56:22','2024-09-21 04:56:22'),(448,' remove breadcrumb from all the website',0,1,41,'2024-09-21 04:56:22','2024-09-21 04:56:22'),(449,' remove breadcrumb from all the website',0,3,41,'2024-09-21 04:56:22','2024-09-21 04:56:22'),(450,'Hack photoshop',0,1,5,'2024-09-21 10:32:27','2024-09-21 10:32:27'),(451,'fix sidebar in(doctor ',0,1,20,'2024-09-21 21:54:06','2024-09-21 21:54:06'),(452,'fix sidebar in(doctor ',0,2,20,'2024-09-21 21:54:06','2024-09-21 21:54:06'),(453,' commission ',0,1,20,'2024-09-21 21:54:06','2024-09-21 21:54:06'),(454,' commission ',0,2,20,'2024-09-21 21:54:06','2024-09-21 21:54:06'),(455,')',1,1,20,'2024-09-21 21:54:06','2024-09-22 05:04:47'),(456,')',1,2,20,'2024-09-21 21:54:06','2024-09-22 05:04:47'),(457,'Fix resbonsive in some pages',0,1,41,'2024-09-22 03:06:41','2024-09-22 03:06:41'),(458,'Remove unused files from code',1,1,41,'2024-09-22 03:07:42','2024-09-22 04:57:51'),(459,'Temove unused files from dashboard',1,3,47,'2024-09-22 03:08:12','2024-09-22 20:40:22'),(460,' add background color to status',0,10,41,'2024-09-22 04:58:49','2024-09-22 04:58:49'),(461,' add background color to status',0,10,41,'2024-09-22 04:58:49','2024-09-22 04:58:49'),(462,'when click in geographical remove only clicked item ',0,1,28,'2024-09-23 07:14:33','2024-09-23 07:14:33'),(463,'when click in geographical remove only clicked item ',0,3,28,'2024-09-23 07:14:33','2024-09-23 07:14:33'),(464,' make it be governrates only and landmark cities so show',0,1,28,'2024-09-23 07:14:33','2024-09-23 07:14:33'),(465,' make it be governrates only and landmark cities so show',0,3,28,'2024-09-23 07:14:33','2024-09-23 07:14:33'),(466,' make it select all',0,1,28,'2024-09-23 07:14:33','2024-09-23 07:14:33'),(467,' make it select all',0,3,28,'2024-09-23 07:14:33','2024-09-23 07:14:33'),(468,'add in product licence images',0,1,28,'2024-09-23 07:14:33','2024-09-23 07:14:33'),(469,'add in product licence images',0,3,28,'2024-09-23 07:14:33','2024-09-23 07:14:33'),(470,'make difrrences between products to allow user see diffrence in prices in all products',1,1,28,'2024-09-23 07:14:33','2024-10-08 22:20:14'),(471,'make difrrences between products to allow user see diffrence in prices in all products',1,3,28,'2024-09-23 07:14:33','2024-10-08 22:20:14'),(472,'Card with employee or student image snd other basic data and expiration date and userId and production date',1,1,32,'2024-09-24 09:09:42','2024-09-27 00:41:53'),(473,'Card with employee or student image snd other basic data and expiration date and userId and production date',1,3,32,'2024-09-24 09:09:42','2024-09-27 00:41:53'),(474,' card contain qrcode ',1,1,32,'2024-09-24 09:09:42','2024-09-26 21:41:45'),(475,' card contain qrcode ',1,3,32,'2024-09-24 09:09:42','2024-09-26 21:41:45'),(476,' qrcode will be for shops owner ',1,1,32,'2024-09-24 09:09:42','2024-10-08 20:34:39'),(477,' qrcode will be for shops owner ',1,3,32,'2024-09-24 09:09:42','2024-10-08 20:34:39'),(478,' card data is namr third , image, card production date, card expiration date ',1,1,32,'2024-09-24 09:09:42','2024-09-27 00:44:53'),(479,' card data is namr third , image, card production date, card expiration date ',1,3,32,'2024-09-24 09:09:42','2024-09-27 00:44:53'),(480,' card has two faces one for logo and logat elasr data and other face for user data',1,1,32,'2024-09-24 09:09:42','2024-09-27 00:45:00'),(481,' card has two faces one for logo and logat elasr data and other face for user data',1,3,32,'2024-09-24 09:09:42','2024-09-27 00:45:00'),(482,'  with any scan send to dashboard record about this transaction ',0,1,32,'2024-09-24 09:09:42','2024-09-24 09:09:42'),(483,'  with any scan send to dashboard record about this transaction ',0,3,32,'2024-09-24 09:09:42','2024-09-24 09:09:42'),(484,' shop owner should has accounts to differ betwwen owner and other',1,1,32,'2024-09-24 09:09:42','2024-10-08 20:34:39'),(485,' shop owner should has accounts to differ betwwen owner and other',1,3,32,'2024-09-24 09:09:42','2024-10-08 20:34:39'),(486,' add also barcode to on card ',1,1,32,'2024-09-24 09:09:42','2024-09-27 00:45:21'),(487,' add also barcode to on card ',1,3,32,'2024-09-24 09:09:42','2024-09-27 00:45:21'),(488,' stop card if graduared frozen and if expired ',1,1,32,'2024-09-24 09:09:42','2024-09-27 01:04:22'),(489,' stop card if graduared frozen and if expired ',1,3,32,'2024-09-24 09:09:42','2024-09-27 01:04:22'),(490,' if graduated he can buy the card and make use of it for a cost or year',1,1,32,'2024-09-24 09:09:42','2024-10-08 20:34:39'),(491,' if graduated he can buy the card and make use of it for a cost or year',1,3,32,'2024-09-24 09:09:42','2024-10-08 20:34:39'),(492,'Sebd tables cabacities inside restaurants',1,3,41,'2024-09-25 00:03:28','2024-09-25 02:34:04'),(493,' add isQrcode in reservations table',1,3,41,'2024-09-25 00:03:28','2024-09-25 02:21:01'),(494,'Add waitings as api to allow see waitings details',1,1,41,'2024-09-25 00:07:13','2024-09-25 03:18:47'),(495,'Add waitings as api to allow see waitings details',1,3,41,'2024-09-25 00:07:13','2024-09-25 03:18:47'),(496,'In response of post request return number of waiting reqursts',0,1,41,'2024-09-25 00:10:34','2024-09-25 00:10:34'),(497,'QR code for restaurant waiting list',1,3,41,'2024-09-28 19:39:48','2024-10-08 22:19:09'),(498,'big distance in blades',0,1,47,'2024-10-03 18:23:54','2024-10-03 18:23:54'),(499,'big distance in blades',0,3,47,'2024-10-03 18:23:54','2024-10-03 18:23:54'),(500,' password is required',1,1,47,'2024-10-03 18:23:54','2024-10-03 20:40:46'),(501,' password is required',1,3,47,'2024-10-03 18:23:54','2024-10-03 20:40:46'),(502,'image of users do not return in api dunamically',1,1,47,'2024-10-03 18:23:54','2024-10-03 21:09:16'),(503,'image of users do not return in api dunamically',1,3,47,'2024-10-03 18:23:54','2024-10-03 21:09:16'),(504,' setting design bad',0,1,47,'2024-10-03 18:23:54','2024-10-03 18:23:54'),(505,' setting design bad',0,3,47,'2024-10-03 18:23:54','2024-10-03 18:23:54'),(506,' title in users index should be teacher or students',1,1,47,'2024-10-03 18:23:54','2024-10-03 20:57:09'),(507,' title in users index should be teacher or students',1,3,47,'2024-10-03 18:23:54','2024-10-03 20:57:09'),(508,'reviews issue',1,1,47,'2024-10-03 18:23:54','2024-10-03 20:43:11'),(509,'reviews issue',1,3,47,'2024-10-03 18:23:54','2024-10-03 20:43:11'),(510,'show phone in users',1,1,47,'2024-10-03 18:23:54','2024-10-03 20:47:13'),(511,'show phone in users',1,3,47,'2024-10-03 18:23:54','2024-10-03 20:47:13'),(512,'remove confirmation',1,1,47,'2024-10-03 18:23:54','2024-10-03 20:53:17'),(513,'remove confirmation',1,3,47,'2024-10-03 18:23:54','2024-10-03 20:53:17'),(514,'make it image only',0,1,47,'2024-10-03 18:23:54','2024-10-03 18:23:54'),(515,'make it image only',0,3,47,'2024-10-03 18:23:54','2024-10-03 18:23:54'),(516,'sessions issue',0,1,47,'2024-10-03 18:23:54','2024-10-03 18:23:54'),(517,'sessions issue',0,3,47,'2024-10-03 18:23:54','2024-10-03 18:23:54'),(518,'add meta key words',1,1,32,'2024-10-07 04:31:52','2024-10-08 20:33:55'),(519,'add meta key words',1,3,32,'2024-10-07 04:31:52','2024-10-08 20:33:55');
/*!40000 ALTER TABLE `tasks` ENABLE KEYS */;
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
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `team_translations`
--

LOCK TABLES `team_translations` WRITE;
/*!40000 ALTER TABLE `team_translations` DISABLE KEYS */;
INSERT INTO `team_translations` (`id`, `title`, `subtitle`, `description`, `team_id`, `locale`, `created_at`, `updated_at`) VALUES (1,'جرجس مكرم','مدير',NULL,1,'ar','2024-08-31 08:15:17','2024-08-31 08:15:17'),(2,'Gerges Makram','Manager',NULL,1,'en','2024-08-31 08:15:17','2024-08-31 08:15:17'),(3,'بولا نسيم','مهندس برمجيات',NULL,2,'ar','2024-08-31 08:15:17','2024-08-31 08:15:17'),(4,'Boula Nessim','Project Manager',NULL,2,'en','2024-08-31 08:15:17','2024-08-31 08:15:17'),(5,'ابراهيم سامى','مهندس برمجيات',NULL,3,'ar','2024-08-31 08:15:17','2024-08-31 08:15:17'),(6,'Ibrahim Samy','Software Engineer',NULL,3,'en','2024-08-31 08:15:17','2024-08-31 08:15:17'),(7,'كيرلس ادوارد','مصمم ويب ',NULL,4,'ar','2024-08-31 08:15:17','2024-08-31 08:15:17'),(8,'Kyrillos Edward','Software Engineer',NULL,4,'en','2024-08-31 08:15:17','2024-08-31 08:15:17'),(9,'تادرس اميل','مطور ويب',NULL,5,'ar','2024-08-31 08:15:17','2024-08-31 08:15:17'),(10,'Tadrous Emil','Software Engineer',NULL,5,'en','2024-08-31 08:15:17','2024-08-31 08:15:17'),(11,'ميلاد يوسف','مطور ويب',NULL,6,'ar','2024-08-31 08:15:17','2024-08-31 08:15:17'),(12,'Melad Youssef','Web Developer',NULL,6,'en','2024-08-31 08:15:17','2024-08-31 08:15:17'),(13,'زياد محمد','مطور ويب',NULL,7,'ar','2024-08-31 08:15:17','2024-08-31 08:15:17'),(14,'Zeiad Mohamed','Web Developer',NULL,7,'en','2024-08-31 08:15:17','2024-08-31 08:15:17');
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
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `teams`
--

LOCK TABLES `teams` WRITE;
/*!40000 ALTER TABLE `teams` DISABLE KEYS */;
INSERT INTO `teams` (`id`, `facebook`, `twitter`, `instagram`, `linkedin`, `created_at`, `updated_at`) VALUES (1,'https://www.facebook.com','https://www.twitter.com','https://www.instagram.com','https://www.linkedin.com','2024-08-31 08:15:17','2024-08-31 08:15:17'),(2,'https://www.facebook.com','https://www.twitter.com','https://www.instagram.com','https://www.linkedin.com','2024-08-31 08:15:17','2024-08-31 08:15:17'),(3,'https://www.facebook.com','https://www.twitter.com','https://www.instagram.com','https://www.linkedin.com','2024-08-31 08:15:17','2024-08-31 08:15:17'),(4,'https://www.facebook.com','https://www.twitter.com','https://www.instagram.com','https://www.linkedin.com','2024-08-31 08:15:17','2024-08-31 08:15:17'),(5,'https://www.facebook.com','https://www.twitter.com','https://www.instagram.com','https://www.linkedin.com','2024-08-31 08:15:17','2024-08-31 08:15:17'),(6,'https://www.facebook.com','https://www.twitter.com','https://www.instagram.com','https://www.linkedin.com','2024-08-31 08:15:17','2024-08-31 08:15:17'),(7,'https://www.facebook.com','https://www.twitter.com','https://www.instagram.com','https://www.linkedin.com','2024-08-31 08:15:17','2024-08-31 08:15:17');
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
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `testimonial_translations`
--

LOCK TABLES `testimonial_translations` WRITE;
/*!40000 ALTER TABLE `testimonial_translations` DISABLE KEYS */;
INSERT INTO `testimonial_translations` (`id`, `title`, `subtitle`, `description`, `testimonial_id`, `locale`, `created_at`, `updated_at`) VALUES (1,'عمر محمد','العميل، الولايات المتحدة الأمريكية','<p> لقد كان من دواعي سروري العمل مع فريق شركة يوساب تك في مشروع موقع الويب الخاص بي، ولم أستطع أن أكون أكثر سعادة بالنتائج. لقد أظهروا، منذ البداية وحتى النهاية، مستوىً عالٍ من الاحترافية والخبرة والتفاني </p>',1,'ar','2024-08-31 08:15:17','2024-08-31 08:15:17'),(2,'Omar Mohamed','Customer,USA','<p>I had the pleasure of working with the team at Yousab Tech company for my website project, and I couldn\'t be happier with the results. From start to finish, they demonstrated a high level of professionalism, expertise, and dedication</p>',1,'en','2024-08-31 08:15:17','2024-08-31 08:15:17'),(3,'محمد احمد','العميل، الولايات المتحدة الأمريكية','<p>استغرق فريق شركة يوساب تك الوقت الكافي لفهم رؤيتي وأهدافي للموقع. لقد استمعوا باهتمام لمتطلباتي وقدموا رؤى واقتراحات قيمة لتعزيز تجربة المستخدم الشاملة. كان تواصلهم طوال المشروع ممتازًا، وأبقوني على اطلاع دائم بالتقدم المحرز بانتظام.</p>',2,'ar','2024-08-31 08:15:17','2024-08-31 08:15:17'),(4,'Mohamed Ahmed','Customer,USA','<p> The team at Yousab Tech company took the time to understand my vision and goals for the website. They listened attentively to my requirements and provided valuable insights and suggestions to enhance the overall user experience. Their communication throughout the project was excellent, and they kept me updated on the progress regularly</p>',2,'en','2024-08-31 08:15:17','2024-08-31 08:15:17'),(5,' علياء عماد','العميل، الولايات المتحدة الأمريكية','<p>لقد تأثرت بمهاراتهم الفنية واهتمامهم بالتفاصيل. موقع الويب الذي أنشأوه لي لا يبدو مذهلاً فحسب، بل يعمل أيضًا بشكل لا تشوبه شائبة. لقد تأكدوا من أن الموقع سريع الاستجابة ومُحسّن لمحركات البحث وسهل الاستخدام. التصميم حديث وجذاب بصريًا ويتوافق تمامًا مع هوية علامتي التجارية.</p>',3,'ar','2024-08-31 08:15:17','2024-08-31 08:15:17'),(6,'Alia Emad','Customer,USA','<p>I was impressed by their technical skills and attention to detail. The website they created for me not only looks stunning but also functions flawlessly. They ensured that the site is responsive, optimized for search engines, and user-friendly. The design is modern, visually appealing, and aligned perfectly with my brand identity</p>',3,'en','2024-08-31 08:15:17','2024-08-31 08:15:17'),(7,'شريف عاطف','العميل، الولايات المتحدة الأمريكية','<p>ما يميز شركة يوساب تك هو التزامها برضا العملاء. لقد ذهبوا إلى أبعد من ذلك لمعالجة أي مخاوف أو تعديلات كانت لدي، وكانوا دائمًا سريعين في ردودهم. خدمة العملاء الخاصة بهم استثنائية حقًا.</p>',4,'ar','2024-08-31 08:15:17','2024-08-31 08:15:17'),(8,'Sherif Atef','Customer,USA','<p>What sets Yousab Tech company apart is their commitment to customer satisfaction. They went above and beyond to address any concerns or modifications I had, and they were always prompt in their responses. Their customer service is truly exceptional.</p>',4,'en','2024-08-31 08:15:17','2024-08-31 08:15:17'),(9,' داليا سمير','العميل، الولايات المتحدة الأمريكية','<p>أوصي بشدة بشركة يوساب تك لأي شخص يحتاج إلى خدمات تطوير الويب الاحترافية. إنهم فريق موهوب وموثوق يحقق نتائج رائعة. لقد كان العمل معهم ممتعًا، وأتطلع إلى التعاون معهم مرة أخرى في المستقبل</p>',5,'ar','2024-08-31 08:15:17','2024-08-31 08:15:17'),(10,'Dalia Samir','Customer,USA','<p>I highly recommend Yousab Tech company to anyone in need of professional web development services. They are a talented and reliable team that delivers outstanding results. Working with them has been a pleasure, and I look forward to collaborating with them again in the future</p>',5,'en','2024-08-31 08:15:17','2024-08-31 08:15:17');
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
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `testimonials`
--

LOCK TABLES `testimonials` WRITE;
/*!40000 ALTER TABLE `testimonials` DISABLE KEYS */;
INSERT INTO `testimonials` (`id`, `created_at`, `updated_at`) VALUES (1,'2024-08-31 08:15:17','2024-08-31 08:15:17'),(2,'2024-08-31 08:15:17','2024-08-31 08:15:17'),(3,'2024-08-31 08:15:17','2024-08-31 08:15:17'),(4,'2024-08-31 08:15:17','2024-08-31 08:15:17'),(5,'2024-08-31 08:15:17','2024-08-31 08:15:17');
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
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES (1,'Ibrahim Samy','ibrahimsamy308@gmail.com',NULL,'$2y$10$csIDPRL1upEn/Q7DGUSa3uOnydLzoFsN3AJpcqBGKQqxJOvmI68Xm',NULL,'2024-08-31 08:15:17','2024-08-31 08:15:17'),(2,'Keroles Fouad','Kero@gmail.com',NULL,'$2y$10$9Vfpd0SzpR.EXblEosRESuHIjbkYB7Ky0JFLnUGoY4dl9I4vk57EO',NULL,'2024-08-31 08:15:17','2024-08-31 08:15:17'),(3,'ابراهيم سامى','ibrahim@gmail.com',NULL,'$2y$10$MDRIT2H8Fv2SNKp4yvQ2qOPEoSMp/Afeepv0B1P2i6CujxOzJiiI.',NULL,'2024-08-31 08:15:17','2024-08-31 08:15:17');
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `vaccancies`
--

DROP TABLE IF EXISTS `vaccancies`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `vaccancies` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `salary` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `vaccancies`
--

LOCK TABLES `vaccancies` WRITE;
/*!40000 ALTER TABLE `vaccancies` DISABLE KEYS */;
INSERT INTO `vaccancies` (`id`, `salary`, `created_at`, `updated_at`) VALUES (1,7000,'2024-08-31 08:15:16','2024-08-31 08:15:16');
/*!40000 ALTER TABLE `vaccancies` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `vaccancy_translations`
--

DROP TABLE IF EXISTS `vaccancy_translations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `vaccancy_translations` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `vaccancy_id` bigint(20) unsigned NOT NULL,
  `locale` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `vaccancy_translations_vaccancy_id_locale_unique` (`vaccancy_id`,`locale`),
  KEY `vaccancy_translations_locale_index` (`locale`),
  CONSTRAINT `vaccancy_translations_vaccancy_id_foreign` FOREIGN KEY (`vaccancy_id`) REFERENCES `vaccancies` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `vaccancy_translations`
--

LOCK TABLES `vaccancy_translations` WRITE;
/*!40000 ALTER TABLE `vaccancy_translations` DISABLE KEYS */;
INSERT INTO `vaccancy_translations` (`id`, `title`, `description`, `vaccancy_id`, `locale`, `created_at`, `updated_at`) VALUES (1,'مطور وجهات المواقع','<p>يقوم مطور الواجهة الأمامية بإنشاء مواقع الويب والتطبيقات باستخدام لغات الويب مثل HTML وCSS وJavaScript التي تتيح للمستخدمين الوصول إلى الموقع أو التطبيق والتفاعل معه. عندما تزور موقع ويب، تم إنشاء عناصر التصميم التي تراها بواسطة مطور الواجهة الأمامية</p>',1,'ar','2024-08-31 08:15:16','2024-08-31 08:15:16'),(2,'frontend developer','<p>A front-end developer creates websites and applications using web languages such as HTML, CSS, and JavaScript that allow users to access and interact with the site or app. When you visit a website, the design elements you see were created by a front-end developer</p>',1,'en','2024-08-31 08:15:16','2024-08-31 08:15:16');
/*!40000 ALTER TABLE `vaccancy_translations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `video_translations`
--

DROP TABLE IF EXISTS `video_translations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `video_translations` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `video_id` bigint(20) unsigned NOT NULL,
  `locale` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `video_translations_video_id_locale_unique` (`video_id`,`locale`),
  KEY `video_translations_locale_index` (`locale`),
  CONSTRAINT `video_translations_video_id_foreign` FOREIGN KEY (`video_id`) REFERENCES `videos` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `video_translations`
--

LOCK TABLES `video_translations` WRITE;
/*!40000 ALTER TABLE `video_translations` DISABLE KEYS */;
INSERT INTO `video_translations` (`id`, `title`, `video_id`, `locale`, `created_at`, `updated_at`) VALUES (1,'رفع المواقع',1,'ar','2024-08-31 08:15:17','2024-08-31 08:15:17'),(2,'Upload websites',1,'en','2024-08-31 08:15:17','2024-08-31 08:15:17'),(3,'انشاء المواقع',2,'ar','2024-08-31 08:15:17','2024-08-31 08:15:17'),(4,'Create websites',2,'en','2024-08-31 08:15:17','2024-08-31 08:15:17');
/*!40000 ALTER TABLE `video_translations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `videos`
--

DROP TABLE IF EXISTS `videos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `videos` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `youtube_link` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `videos`
--

LOCK TABLES `videos` WRITE;
/*!40000 ALTER TABLE `videos` DISABLE KEYS */;
INSERT INTO `videos` (`id`, `youtube_link`, `created_at`, `updated_at`) VALUES (1,'www.youtube.com','2024-08-31 08:15:17','2024-08-31 08:15:17'),(2,'www.google.com','2024-08-31 08:15:17','2024-08-31 08:15:17');
/*!40000 ALTER TABLE `videos` ENABLE KEYS */;
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

-- Dump completed on 2025-09-23  7:59:46
