-- MySQL dump 10.13  Distrib 5.7.23-23, for Linux (x86_64)
--
-- Host: localhost    Database: yousabte_todo
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
  PRIMARY KEY (`id`),
  UNIQUE KEY `admins_email_unique` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `admins`
--

LOCK TABLES `admins` WRITE;
/*!40000 ALTER TABLE `admins` DISABLE KEYS */;
INSERT INTO `admins` VALUES (1,'Boula','nessimboula@gmail.com','admin',NULL,'$2y$10$cd6ldNcNY2uJI.Hqjz.6AeOccdV4PHzzlmiX/weBkV6VBzmrK.g.u',NULL,'2024-08-31 08:15:16','2024-12-26 18:24:00'),(2,'Kermina','Kerminamelad688@gmail.com','admin',NULL,'$2y$10$iivali4xbYVxQbJ6Z/Ogc.viph6.21hQ7dS.iQwU2VKa1mBJ9vSvO','nqcxWiBViQtYk6L8jc7aue1ZplGZVKF0x7hElLr3hADm18W4qDbTZPsAqgBB','2024-08-31 08:15:16','2024-12-27 08:47:51'),(3,'Ibrahim','ibrahim@gmail.com','admin',NULL,'$2y$10$UUH.ssvBXjeTkhvoaj.Z7ODDV7bAgViMaEQVA.h0c6rD7EjKo59NW',NULL,'2024-08-31 08:15:16','2024-08-31 08:15:16'),(5,'Melad','melad@gmail.com','employee',NULL,'$2y$10$ibFdtvVkRZWojtgxa/w.NOkXBjVH3jYvsmVn0C.AFZyJPuxnI21lW',NULL,'2024-08-31 08:15:17','2024-08-31 08:15:17'),(10,'Zeyad','zeyad@gmail.com','employee',NULL,'$2y$10$TEiQ7hFZmzoxiKr98k.Tz.dwYGx0ZhW6f/jfcNblOkrYHYsdNOgSq','zPKbNVFeDd5FqNUVg7C6CijaPIFWMd1UeY0cD6x44QNWU5NTGMyWWBD2J84Z','2024-09-03 12:05:56','2024-09-03 12:05:56'),(11,'Tadros','tadros@gmail.com','employee',NULL,'$2y$10$KxvgoB7.TUJj3IxTM3XnROHrxaZlFAmlC1KaZvAjE7S3qx8RLGCOC',NULL,'2024-10-13 17:07:54','2024-10-13 17:07:54'),(12,'Mohamed','mohamed@gmail.com','employee',NULL,'$2y$10$t5A.KlCpSAE.Bk6s0I3fTurxMK0CNMwzzQ76aJEqy9vzxgboNQ.P6',NULL,'2024-10-13 17:09:59','2024-10-16 23:14:52'),(13,'All','all@gmail.com','employee',NULL,'$2y$10$qvMXWdJoa/I2UuJ8xy7BaOfVbQZ4YyVQlzdty5bwPlxb3Hpp7W90S',NULL,'2024-12-07 03:38:45','2024-12-07 03:38:45');
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
INSERT INTO `categories` VALUES (1,'far fa-window-restore','2024-08-31 08:15:17','2024-08-31 08:15:17'),(2,'fas fa-shopping-cart','2024-08-31 08:15:17','2024-08-31 08:15:17'),(3,'fas fa-cog','2024-08-31 08:15:17','2024-08-31 08:15:17'),(4,'fab fa-ioxhost','2024-08-31 08:15:17','2024-08-31 08:15:17');
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
INSERT INTO `category_translations` VALUES (1,'انشاء مواقع الويب',NULL,'<p>نحن متخصصون في إنشاء مواقع ويب مخصصة تناسب احتياجات عملك المحددة. يعمل فريقنا من المطورين والمصممين ذوي الخبرة بشكل وثيق معك لفهم متطلباتك وتطوير موقع ويب يعكس هوية علامتك التجارية. نحن نستفيد من أحدث تقنيات الويب ومبادئ التصميم سريع الاستجابة لضمان أن يبدو موقع الويب الخاص بك مذهلاً ويعمل بشكل لا تشوبه شائبة عبر الأجهزة وبالاضافه الى لوحة تحكم لنجعلك قادر على التحكم فى جميع محتويات الموقع  </p>',1,'ar','2024-08-31 08:15:17','2024-08-31 08:15:17'),(2,'Custom Website Development',NULL,'<p>We specialize in creating custom websites that fit your specific business needs. Our team of experienced developers and designers work closely with you to understand your requirements and develop a website that reflects your brand identity. We take advantage of the latest web technologies and responsive design principles to ensure that your website looks amazing and works flawlessly across devices and in addition to a control panel to make you able to control all     site content</p>',1,'en','2024-08-31 08:15:17','2024-08-31 08:15:17'),(3,'انشاء مواقع تجارة الكترونية',NULL,'<p>إذا كنت تتطلع إلى بيع منتجات أو خدمات عبر الإنترنت، فيمكن أن تساعدك خدمات تطوير التجارة الإلكترونية لدينا. لدينا خبرة في بناء منصات تجارة إلكترونية آمنة وقابلة للتطوير توفر تجارب مستخدم سلسة وتكاملًا قويًا للدفع. بدءًا من كتالوجات المنتجات وعربات التسوق وحتى إدارة المخزون ومعالجة الطلبات، نقوم بإنشاء حلول للتجارة الإلكترونية تعمل على زيادة التحويلات وزيادة الإيرادات إلى أقصى حد</p>',2,'ar','2024-08-31 08:15:17','2024-08-31 08:15:17'),(4,'E-commerce Development',NULL,'<p>If you\'re looking to sell products or categories online, our e-commerce development categories can help. We have expertise in building secure and scalable e-commerce platforms that offer seamless user experiences and robust payment integration. From product catalogs and shopping carts to inventory management and order processing, we create e-commerce solutions that drive conversions and maximize revenue</p>',2,'en','2024-08-31 08:15:17','2024-08-31 08:15:17'),(5,'صيانة ودعم الموقع',NULL,'<p>نحن نؤمن بالشراكات طويلة الأمد مع عملائنا. تضمن خدمات صيانة ودعم موقع الويب لدينا بقاء موقع الويب الخاص بك آمنًا وحديثًا ومحسّنًا للأداء. نحن نقدم تحديثات منتظمة وتصحيحات أمنية ونسخًا احتياطية لحماية موقع الويب الخاص بك من نقاط الضعف. فريق الدعم لدينا متاح لمعالجة أية مشكلات والإجابة على الأسئلة وتقديم المساعدة الفنية المستمرة</p>',3,'ar','2024-08-31 08:15:17','2024-08-31 08:15:17'),(6,'Website Maintenance and Support',NULL,'<p>We believe in long-term partnerships with our clients. Our website maintenance and support categories ensure that your website remains secure, up-to-date, and optimized for performance. We provide regular updates, security patches, and backups to protect your website from vulnerabilities. Our support team is available to address any issues, answer questions, and provide ongoing technical assistance </p>',3,'en','2024-08-31 08:15:17','2024-08-31 08:15:17'),(7,'استضافت مواقع ',NULL,'<p>في شركة تطوير الويب لدينا، نقدم خدمات استضافة شاملة للتأكد من أن موقع الويب الخاص بك يعمل على النحو الأمثل ويظل في متناول زوار موقعك. توفر خدمة الاستضافة لدينا بيئة موثوقة وآمنة لازدهار موقع الويب الخاص بك. فيما يلي نظرة عامة على خدمة الاستضافة لدينا:\r\n\r\nبنية تحتية موثوقة للاستضافة: نحن نحافظ على بنية تحتية قوية للاستضافة مع خوادم ومعدات شبكات حديثة. تم تحسين خوادمنا من أجل الأداء، مما يوفر أوقات تحميل سريعة وأقل وقت توقف. نحن نعطي الأولوية للموثوقية للتأكد من أن موقع الويب الخاص بك في متناول الزوار على مدار الساعة.\r\n\r\nحلول قابلة للتطوير: تم تصميم خدمة الاستضافة لدينا لاستيعاب نمو موقع الويب الخاص بك. سواء كان لديك موقع ويب خاص بشركة صغيرة أو تطبيق ويب معقد، فإننا نقدم حلول استضافة قابلة للتطوير يمكنها التكيف مع احتياجاتك المتغيرة. مع توسع موقع الويب الخاص بك، يمكننا بسهولة زيادة موارد الاستضافة للتعامل مع زيادة حركة المرور ومتطلبات البيانات.\r\n\r\nالتدابير الأمنية: نحن نعطي الأولوية لأمن موقع الويب الخاص بك والبيانات التي يحتوي عليها. تتضمن خدمة الاستضافة لدينا إجراءات أمنية قوية مثل جدران الحماية، وأنظمة كشف التسلل، والتحديثات الأمنية المنتظمة. نقوم أيضًا بتنفيذ شهادات SSL لتشفير نقل البيانات وحماية المعلومات الحساسة وبناء الثقة مع زوار موقعك.\r\n\r\nالنسخ الاحتياطي والتعافي من الكوارث: نحن ندرك أهمية حماية البيانات. تتضمن خدمة الاستضافة لدينا نسخًا احتياطية منتظمة لموقعك على الويب والبيانات المرتبطة به. في حالة وجود مشكلة فنية أو حدث غير متوقع، يمكننا استعادة موقع الويب الخاص بك بسرعة لتقليل وقت التوقف عن العمل وفقدان البيانات.\r\n\r\nالدعم الفني: فريق الدعم المخصص لدينا متاح لمساعدتك في أي مخاوف أو مشكلات فنية متعلقة بالاستضافة. سواء كانت لديك أسئلة حول تكوينات الخادم، أو كنت بحاجة إلى مساعدة بشأن إعدادات DNS، أو كنت بحاجة إلى استكشاف الأخطاء وإصلاحها، فإن موظفي الدعم ذوي المعرفة لدينا ليسوا سوى مكالمة هاتفية أو بريد إلكتروني.\r\n\r\nالتوافق مع تقنيات الويب: تدعم خدمة الاستضافة لدينا مجموعة واسعة من تقنيات الويب ولغات البرمجة. سواء تم إنشاء موقع الويب الخاص بك باستخدام PHP أو Python أو Node.js أو أطر عمل أخرى، يمكن لبيئة الاستضافة لدينا أن تلبي متطلباتك المحددة.\r\n\r\nشبكة تسليم المحتوى (CDN): لتحسين أداء موقع الويب الخاص بك، يمكننا دمج شبكة تسليم المحتوى (CDN) في خدمة الاستضافة لدينا. تساعد شبكة CDN على تقديم محتوى موقع الويب الخاص بك بسرعة للزائرين من مواقع جغرافية مختلفة، مما يحسن أوقات التحميل وتجربة المستخدم.\r\n\r\nاستضافة البريد الإلكتروني: إلى جانب استضافة مواقع الويب، نقدم أيضًا خدمات استضافة البريد الإلكتروني. يمكنك الحصول على عناوين بريد إلكتروني احترافية مرتبطة باسم النطاق الخاص بك، مما يوفر تجربة اتصال سلسة وموحدة لشركتك. </p>',4,'ar','2024-08-31 08:15:17','2024-08-31 08:15:17'),(8,'Website Hosting',NULL,'<p>At our web development company, we offer comprehensive hosting categories to ensure that your website performs optimally and remains accessible to your visitors. Our hosting category provides a reliable and secure environment for your website to thrive. Here\'s an overview of our hosting category:\r\n\r\n                                Reliable Hosting Infrastructure: We maintain a robust hosting infrastructure with state-of-the-art servers and network equipment. Our servers are optimized for performance, offering fast load times and minimal downtime. We prioritize reliability to ensure that your website is accessible to visitors around the clock.\r\n                                \r\n                                Scalable Solutions: Our hosting category is designed to accommodate your website\'s growth. Whether you have a small business website or a complex web application, we offer scalable hosting solutions that can adapt to your changing needs. As your website expands, we can seamlessly scale up the hosting resources to handle increased traffic and data requirements.\r\n                                \r\n                                Security Measures: We prioritize the security of your website and the data it contains. Our hosting category includes robust security measures such as firewalls, intrusion detection systems, and regular security updates. We also implement SSL certificates to encrypt data transmission, safeguarding sensitive information and building trust with your visitors.\r\n                                \r\n                                Backup and Disaster Recovery: We understand the importance of data protection. Our hosting category includes regular backups of your website and its associated data. In the event of a technical issue or unexpected event, we can quickly restore your website to minimize downtime and data loss.\r\n                                \r\n                                Technical Support: Our dedicated support team is available to assist you with any hosting-related concerns or technical issues. Whether you have questions about server configurations, need assistance with DNS settings, or require troubleshooting, our knowledgeable support staff is just a phone call or email away.\r\n                                \r\n                                Compatibility with Web Technologies: Our hosting category supports a wide range of web technologies and programming languages. Whether your website is built with PHP, Python, Node.js, or other frameworks, our hosting environment can accommodate your specific requirements.\r\n                                \r\n                                Content Delivery Network (CDN): To enhance the performance of your website, we can integrate a Content Delivery Network (CDN) into our hosting category. A CDN helps deliver your website content quickly to visitors from various geographical locations, improving load times and user experience.\r\n                                \r\n                                Email Hosting: Along with website hosting, we also offer email hosting categories. You can have professional email addresses associated with your domain name, providing a seamless and unified communication experience for your business.\r\n                                \r\n                                 </p>',4,'en','2024-08-31 08:15:17','2024-08-31 08:15:17');
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
INSERT INTO `complain_translations` VALUES (1,'كم من الوقت يستغرق تطوير موقع ويب أو تطبيق ويب؟','<p> يعتمد الجدول الزمني لتطوير الويب على مدى تعقيد المشروع وميزاته ومتطلبات العميل. يمكن تطوير موقع ويب بسيط في غضون أيام قليلة، بينما قد تستغرق المشاريع الأكثر شمولاً مثل منصات التجارة الإلكترونية أو تطبيقات الويب المخصصة عدة أسابيع. نحن نقدم جدولًا زمنيًا مفصلاً خلال مرحلة تخطيط المشروع، ونبقيك على اطلاع بالإطار الزمني المتوقع.</P>',1,'ar','2024-08-31 08:15:16','2024-08-31 08:15:16'),(2,'How long does it take to develop a website or web application?','<p>The timeline for web development depends on the project\'s complexity, features, and client requirements. A simple website can be developed within a few days, while more extensive projects like e-commerce platforms or custom web applications may take several weeks. We provide a detailed timeline during the project planning phase, keeping you informed about the expected timeframe.</P>',1,'en','2024-08-31 08:15:16','2024-08-31 08:15:16'),(3,'هل يمكنك المساعدة في إعادة تصميم موقع الويب أو تحديث موقع ويب موجود؟','<p>نعم، نحن نقدم خدمات إعادة تصميم مواقع الويب ويمكننا المساعدة في تحديث مواقع الويب الحالية. سواء كنت بحاجة إلى إصلاح شامل أو تحديثات محددة، يمكن لفريقنا العمل معك لتحسين تصميم موقع الويب الخاص بك ووظائفه وتجربة المستخدم.</P>',2,'ar','2024-08-31 08:15:16','2024-08-31 08:15:16'),(4,'Can you help with website redesign or updates to an existing website?','<p>Yes, we offer website redesign services and can assist with updating existing websites. Whether you need a complete overhaul or specific updates, our team can work with you to enhance your website\'s design, functionality, and user experience.</P>',2,'en','2024-08-31 08:15:16','2024-08-31 08:15:16'),(5,'هل سيكون موقع الويب الخاص بي متوافقًا مع الجوّال وسريع الاستجابة؟','<p>قطعاً! نحن نعطي الأولوية لتصميم الويب سريع الاستجابة، مما يضمن أن يبدو موقع الويب الخاص بك ويعمل بسلاسة عبر الأجهزة المختلفة، بما في ذلك أجهزة الكمبيوتر المكتبية والأجهزة اللوحية والهواتف الذكية. يعد موقع الويب المتوافق مع الأجهزة المحمولة أمرًا ضروريًا للوصول إلى جمهور أوسع وتوفير تجربة مستخدم إيجابية.</P>',3,'ar','2024-08-31 08:15:16','2024-08-31 08:15:16'),(6,' Will my website be mobile-friendly and responsive?','<p>Absolutely! We prioritize responsive web design, ensuring that your website looks and functions seamlessly across various devices, including desktops, tablets, and smartphones. A mobile-friendly website is essential for reaching a wider audience and providing a positive user experience.</P>',3,'en','2024-08-31 08:15:16','2024-08-31 08:15:16'),(7,'هل يمكنك المساعدة في تحسين محركات البحث (SEO)؟','<p>نعم، نحن نقدم خدمات تطوير الويب الصديقة لمحركات البحث (SEO). في حين أن التركيز الأساسي ينصب على إنشاء موقع ويب عملي وجذاب من الناحية المرئية، فإننا نطبق أفضل الممارسات لتحسين موقع الويب الخاص بك لمحركات البحث. يتضمن ذلك بنية HTML المناسبة والتعليمات البرمجية النظيفة وسرعة الصفحة المحسنة وعناوين URL سهلة الاستخدام. بالنسبة لاستراتيجيات تحسين محركات البحث الشاملة، يمكننا أيضًا تقديم التوجيه أو التعاون مع متخصصي تحسين محركات البحث.</p>',4,'ar','2024-08-31 08:15:16','2024-08-31 08:15:16'),(8,'Can you assist with search engine optimization (SEO)?','<p>Yes, we provide SEO-friendly web development services. While the primary focus is on creating a functional and visually appealing website, we implement best practices to optimize your website for search engines. This includes proper HTML structure, clean code, optimized page speed, and user-friendly URLs. For comprehensive SEO strategies, we can also offer guidance or collaborate with SEO specialists.</p>',4,'en','2024-08-31 08:15:16','2024-08-31 08:15:16'),(9,'هل سيكون لدي القدرة على تحديث محتوى موقع الويب الخاص بي؟','<p>نعم، نحن نقدم حلول نظام إدارة المحتوى (CMS) التي تتيح لك تحديث محتوى موقع الويب الخاص بك وإدارته بسهولة. يمكننا أن نوصي وندمج منصات CMS الشائعة مثل WordPress أو Drupal أو Joomla، مما يتيح لك إجراء تغييرات دون الحاجة إلى خبرة فنية.</p>',5,'ar','2024-08-31 08:15:16','2024-08-31 08:15:16'),(10,'Will I have the ability to update my website\'s content?','<p>Yes, we offer content management system (CMS) solutions that allow you to update and manage your website\'s content easily. We can recommend and integrate popular CMS platforms such as WordPress, Drupal, or Joomla, enabling you to make changes without requiring technical expertise.\n                        </p>',5,'en','2024-08-31 08:15:16','2024-08-31 08:15:16'),(11,'هل تقدمون الدعم المستمر وصيانة الموقع؟','<p>نعم، نحن نقدم خدمات الدعم والصيانة المستمرة لضمان بقاء موقع الويب الخاص بك آمنًا وحديثًا ومحسنًا للأداء. نحن نقدم تحديثات منتظمة وتصحيحات أمنية ونسخًا احتياطية ومساعدة فنية لمعالجة أي مشكلات قد تنشأ.</p>',6,'ar','2024-08-31 08:15:16','2024-08-31 08:15:16'),(12,'Do you provide ongoing support and website maintenance?','<p>Yes, we offer ongoing support and maintenance services to ensure your website remains secure, up-to-date, and optimized for performance. We provide regular updates, security patches, backups, and technical assistance to address any issues that may arise.</p>',6,'en','2024-08-31 08:15:16','2024-08-31 08:15:16'),(13,'ما هي التسعير وشروط الدفع الخاصة بك؟','<p>تعتمد أسعارنا على نطاق المشروع وتعقيده. نحن نقدم مقترحات مشاريع مفصلة وتقديرات التكلفة بناء على متطلباتك. عادةً ما تتم مناقشة شروط الدفع والاتفاق عليها خلال مرحلة بدء المشروع.</p>',7,'ar','2024-08-31 08:15:16','2024-08-31 08:15:16'),(14,'What are your pricing and payment terms?','<p>Our pricing depends on the scope and complexity of the project. We provide detailed project proposals and cost estimates based on your requirements. Payment terms are typically discussed and agreed upon during the project initiation phase.</p>',7,'en','2024-08-31 08:15:16','2024-08-31 08:15:16'),(15,'ماذا تتضمن عملية تطوير الويب؟','<p>تتضمن عملية تطوير الويب عادةً عدة مراحل، بما في ذلك تحليل المتطلبات والتصميم والتطوير والاختبار والنشر والصيانة المستمرة. يبدأ الأمر بفهم أهداف مشروعك، يليه تصميم وبرمجة موقع الويب أو تطبيق الويب. يضمن الاختبار وظائفه، وبمجرد الموافقة عليه، يتم نشره على خادم مباشر. تتضمن الصيانة المستمرة التحديثات وتصحيحات الأمان والدعم الفني.</p>',8,'ar','2024-08-31 08:15:16','2024-08-31 08:15:16'),(16,'What does the web development process involve?','<p>The web development process typically involves several stages, including requirement analysis, design, development, testing, deployment, and ongoing maintenance. It begins with understanding your project goals, followed by designing and coding the website or web application. Testing ensures its functionality, and once approved, it is deployed to a live server. Ongoing maintenance includes updates, security patches, and technical support.</p>',8,'en','2024-08-31 08:15:16','2024-08-31 08:15:16');
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
INSERT INTO `complains` VALUES (1,2,'2024-08-31 08:15:16','2024-08-31 08:15:16'),(2,4,'2024-08-31 08:15:16','2024-08-31 08:15:16'),(3,5,'2024-08-31 08:15:16','2024-08-31 08:15:16'),(4,6,'2024-08-31 08:15:16','2024-08-31 08:15:16'),(5,7,'2024-08-31 08:15:16','2024-08-31 08:15:16'),(6,9,'2024-08-31 08:15:16','2024-08-31 08:15:16'),(7,4,'2024-08-31 08:15:16','2024-08-31 08:15:16'),(8,7,'2024-08-31 08:15:16','2024-08-31 08:15:16');
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
INSERT INTO `contacts` VALUES (1,'https://www.facebook.com/YousabTech?mibextid=ZbWKwL','fab fa-facebook-f','social','2024-08-31 08:15:16','2024-08-31 08:15:16'),(2,'www.linkedin.com/in/yousab-tech-3707b428b','fab fa-linkedin-in','social','2024-08-31 08:15:16','2024-08-31 08:15:16'),(3,'https://www.instagram.com','fab fa-instagram','social','2024-08-31 08:15:16','2024-08-31 08:15:16'),(4,'yousabtech@gmail.com','fas fa-mail-bulk','email','2024-08-31 08:15:16','2024-08-31 08:15:16'),(5,'01126785910','fas fa-phone','phone','2024-08-31 08:15:16','2024-08-31 08:15:16'),(6,'01208050298','fab fa-whatsapp','whatsapp','2024-08-31 08:15:16','2024-08-31 08:15:16');
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
INSERT INTO `counter_translations` VALUES (1,'مواقع تم تنفيذها',1,'ar','2024-08-31 08:15:16','2024-08-31 08:15:16'),(2,'Built Web Projects',1,'en','2024-08-31 08:15:16','2024-08-31 08:15:16'),(3,'مواقع تحت الانشاء',2,'ar','2024-08-31 08:15:16','2024-08-31 08:15:16'),(4,'New Web Project',2,'en','2024-08-31 08:15:16','2024-08-31 08:15:16'),(5,'تطبيقات موبيل تم تنفيذها',3,'ar','2024-08-31 08:15:16','2024-08-31 08:15:16'),(6,'Created Mobile Applications',3,'en','2024-08-31 08:15:16','2024-08-31 08:15:16'),(7,'تطبيقات موبيل تحت الانشاء',4,'ar','2024-08-31 08:15:16','2024-08-31 08:15:16'),(8,'New  Mobile Applications',4,'en','2024-08-31 08:15:16','2024-08-31 08:15:16');
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
INSERT INTO `counters` VALUES (1,'30','2024-08-31 08:15:16','2024-08-31 08:15:16'),(2,'15','2024-08-31 08:15:16','2024-08-31 08:15:16'),(3,'10','2024-08-31 08:15:16','2024-08-31 08:15:16'),(4,'5','2024-08-31 08:15:16','2024-08-31 08:15:16');
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
INSERT INTO `faq_translations` VALUES (1,'كم من الوقت يستغرق تطوير موقع ويب أو تطبيق ويب؟','<p> يعتمد الجدول الزمني لتطوير الويب على مدى تعقيد المشروع وميزاته ومتطلبات العميل. يمكن تطوير موقع ويب بسيط في غضون أيام قليلة، بينما قد تستغرق المشاريع الأكثر شمولاً مثل منصات التجارة الإلكترونية أو تطبيقات الويب المخصصة عدة أسابيع. نحن نقدم جدولًا زمنيًا مفصلاً خلال مرحلة تخطيط المشروع، ونبقيك على اطلاع بالإطار الزمني المتوقع.</P>',1,'ar','2024-08-31 08:15:16','2024-08-31 08:15:16'),(2,'How long does it take to develop a website or web application?','<p>The timeline for web development depends on the project\'s complexity, features, and client requirements. A simple website can be developed within a few days, while more extensive projects like e-commerce platforms or custom web applications may take several weeks. We provide a detailed timeline during the project planning phase, keeping you informed about the expected timeframe.</P>',1,'en','2024-08-31 08:15:16','2024-08-31 08:15:16'),(3,'هل يمكنك المساعدة في إعادة تصميم موقع الويب أو تحديث موقع ويب موجود؟','<p>نعم، نحن نقدم خدمات إعادة تصميم مواقع الويب ويمكننا المساعدة في تحديث مواقع الويب الحالية. سواء كنت بحاجة إلى إصلاح شامل أو تحديثات محددة، يمكن لفريقنا العمل معك لتحسين تصميم موقع الويب الخاص بك ووظائفه وتجربة المستخدم.</P>',2,'ar','2024-08-31 08:15:16','2024-08-31 08:15:16'),(4,'Can you help with website redesign or updates to an existing website?','<p>Yes, we offer website redesign services and can assist with updating existing websites. Whether you need a complete overhaul or specific updates, our team can work with you to enhance your website\'s design, functionality, and user experience.</P>',2,'en','2024-08-31 08:15:16','2024-08-31 08:15:16'),(5,'هل سيكون موقع الويب الخاص بي متوافقًا مع الجوّال وسريع الاستجابة؟','<p>قطعاً! نحن نعطي الأولوية لتصميم الويب سريع الاستجابة، مما يضمن أن يبدو موقع الويب الخاص بك ويعمل بسلاسة عبر الأجهزة المختلفة، بما في ذلك أجهزة الكمبيوتر المكتبية والأجهزة اللوحية والهواتف الذكية. يعد موقع الويب المتوافق مع الأجهزة المحمولة أمرًا ضروريًا للوصول إلى جمهور أوسع وتوفير تجربة مستخدم إيجابية.</P>',3,'ar','2024-08-31 08:15:16','2024-08-31 08:15:16'),(6,' Will my website be mobile-friendly and responsive?','<p>Absolutely! We prioritize responsive web design, ensuring that your website looks and functions seamlessly across various devices, including desktops, tablets, and smartphones. A mobile-friendly website is essential for reaching a wider audience and providing a positive user experience.</P>',3,'en','2024-08-31 08:15:16','2024-08-31 08:15:16'),(7,'هل يمكنك المساعدة في تحسين محركات البحث (SEO)؟','<p>نعم، نحن نقدم خدمات تطوير الويب الصديقة لمحركات البحث (SEO). في حين أن التركيز الأساسي ينصب على إنشاء موقع ويب عملي وجذاب من الناحية المرئية، فإننا نطبق أفضل الممارسات لتحسين موقع الويب الخاص بك لمحركات البحث. يتضمن ذلك بنية HTML المناسبة والتعليمات البرمجية النظيفة وسرعة الصفحة المحسنة وعناوين URL سهلة الاستخدام. بالنسبة لاستراتيجيات تحسين محركات البحث الشاملة، يمكننا أيضًا تقديم التوجيه أو التعاون مع متخصصي تحسين محركات البحث.</p>',4,'ar','2024-08-31 08:15:16','2024-08-31 08:15:16'),(8,'Can you assist with search engine optimization (SEO)?','<p>Yes, we provide SEO-friendly web development services. While the primary focus is on creating a functional and visually appealing website, we implement best practices to optimize your website for search engines. This includes proper HTML structure, clean code, optimized page speed, and user-friendly URLs. For comprehensive SEO strategies, we can also offer guidance or collaborate with SEO specialists.</p>',4,'en','2024-08-31 08:15:16','2024-08-31 08:15:16'),(9,'هل سيكون لدي القدرة على تحديث محتوى موقع الويب الخاص بي؟','<p>نعم، نحن نقدم حلول نظام إدارة المحتوى (CMS) التي تتيح لك تحديث محتوى موقع الويب الخاص بك وإدارته بسهولة. يمكننا أن نوصي وندمج منصات CMS الشائعة مثل WordPress أو Drupal أو Joomla، مما يتيح لك إجراء تغييرات دون الحاجة إلى خبرة فنية.</p>',5,'ar','2024-08-31 08:15:16','2024-08-31 08:15:16'),(10,'Will I have the ability to update my website\'s content?','<p>Yes, we offer content management system (CMS) solutions that allow you to update and manage your website\'s content easily. We can recommend and integrate popular CMS platforms such as WordPress, Drupal, or Joomla, enabling you to make changes without requiring technical expertise.\n                        </p>',5,'en','2024-08-31 08:15:16','2024-08-31 08:15:16'),(11,'هل تقدمون الدعم المستمر وصيانة الموقع؟','<p>نعم، نحن نقدم خدمات الدعم والصيانة المستمرة لضمان بقاء موقع الويب الخاص بك آمنًا وحديثًا ومحسنًا للأداء. نحن نقدم تحديثات منتظمة وتصحيحات أمنية ونسخًا احتياطية ومساعدة فنية لمعالجة أي مشكلات قد تنشأ.</p>',6,'ar','2024-08-31 08:15:16','2024-08-31 08:15:16'),(12,'Do you provide ongoing support and website maintenance?','<p>Yes, we offer ongoing support and maintenance services to ensure your website remains secure, up-to-date, and optimized for performance. We provide regular updates, security patches, backups, and technical assistance to address any issues that may arise.</p>',6,'en','2024-08-31 08:15:16','2024-08-31 08:15:16'),(13,'ما هي التسعير وشروط الدفع الخاصة بك؟','<p>تعتمد أسعارنا على نطاق المشروع وتعقيده. نحن نقدم مقترحات مشاريع مفصلة وتقديرات التكلفة بناء على متطلباتك. عادةً ما تتم مناقشة شروط الدفع والاتفاق عليها خلال مرحلة بدء المشروع.</p>',7,'ar','2024-08-31 08:15:16','2024-08-31 08:15:16'),(14,'What are your pricing and payment terms?','<p>Our pricing depends on the scope and complexity of the project. We provide detailed project proposals and cost estimates based on your requirements. Payment terms are typically discussed and agreed upon during the project initiation phase.</p>',7,'en','2024-08-31 08:15:16','2024-08-31 08:15:16'),(15,'ماذا تتضمن عملية تطوير الويب؟','<p>تتضمن عملية تطوير الويب عادةً عدة مراحل، بما في ذلك تحليل المتطلبات والتصميم والتطوير والاختبار والنشر والصيانة المستمرة. يبدأ الأمر بفهم أهداف مشروعك، يليه تصميم وبرمجة موقع الويب أو تطبيق الويب. يضمن الاختبار وظائفه، وبمجرد الموافقة عليه، يتم نشره على خادم مباشر. تتضمن الصيانة المستمرة التحديثات وتصحيحات الأمان والدعم الفني.</p>',8,'ar','2024-08-31 08:15:16','2024-08-31 08:15:16'),(16,'What does the web development process involve?','<p>The web development process typically involves several stages, including requirement analysis, design, development, testing, deployment, and ongoing maintenance. It begins with understanding your project goals, followed by designing and coding the website or web application. Testing ensures its functionality, and once approved, it is deployed to a live server. Ongoing maintenance includes updates, security patches, and technical support.</p>',8,'en','2024-08-31 08:15:16','2024-08-31 08:15:16');
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
INSERT INTO `faqs` VALUES (1,'2024-08-31 08:15:16','2024-08-31 08:15:16'),(2,'2024-08-31 08:15:16','2024-08-31 08:15:16'),(3,'2024-08-31 08:15:16','2024-08-31 08:15:16'),(4,'2024-08-31 08:15:16','2024-08-31 08:15:16'),(5,'2024-08-31 08:15:16','2024-08-31 08:15:16'),(6,'2024-08-31 08:15:16','2024-08-31 08:15:16'),(7,'2024-08-31 08:15:16','2024-08-31 08:15:16'),(8,'2024-08-31 08:15:16','2024-08-31 08:15:16');
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
  `rest` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `project_id` bigint(20) unsigned DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fees_project_id_foreign` (`project_id`),
  CONSTRAINT `fees_project_id_foreign` FOREIGN KEY (`project_id`) REFERENCES `projects` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=88 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `fees`
--

LOCK TABLES `fees` WRITE;
/*!40000 ALTER TABLE `fees` DISABLE KEYS */;
INSERT INTO `fees` VALUES (1,5000,NULL,'0',3,'2024-09-28 01:50:57','2024-09-28 01:50:57'),(2,15590,NULL,'400',4,'2024-09-28 01:51:16','2024-09-28 01:51:16'),(3,10000,NULL,'10000',41,'2024-09-28 01:52:27','2024-09-29 05:25:22'),(4,400,NULL,'0',4,'2024-09-28 01:53:01','2024-09-28 01:53:01'),(5,13000,NULL,'0',12,'2024-09-28 01:53:18','2024-09-28 01:53:18'),(6,10000,NULL,'2000',20,'2024-09-28 01:53:39','2024-09-28 01:53:39'),(7,10000,NULL,'6000',28,'2024-09-28 01:53:58','2024-09-28 01:53:58'),(8,15000,NULL,'5000',39,'2024-09-28 01:55:15','2024-09-29 05:26:00'),(9,9399,NULL,'3601',32,'2024-09-28 01:56:36','2024-09-28 01:56:36'),(10,7500,NULL,'0',35,'2024-09-28 01:57:01','2024-09-28 01:57:01'),(11,7000,NULL,'0',42,'2024-09-28 01:57:19','2024-09-28 01:57:19'),(12,6000,NULL,'0',7,'2024-09-28 01:57:48','2024-09-28 01:57:48'),(13,10000,NULL,'0',51,'2024-09-28 01:58:26','2024-09-28 01:58:26'),(14,6000,NULL,'0',25,'2024-09-28 01:58:45','2024-09-28 01:58:45'),(15,6000,NULL,'0',13,'2024-09-28 01:58:56','2024-09-28 01:58:56'),(16,5000,NULL,'0',11,'2024-09-28 02:00:10','2024-09-28 02:00:10'),(17,5000,NULL,'0',10,'2024-09-28 02:00:37','2024-09-28 02:00:37'),(18,3000,NULL,'3000',23,'2024-09-28 02:00:56','2024-09-28 02:00:56'),(19,3000,NULL,'700',47,'2024-09-28 02:01:20','2024-09-28 02:01:20'),(20,3000,NULL,'3000',44,'2024-09-28 02:01:40','2024-09-28 02:01:40'),(21,2500,NULL,'0',9,'2024-09-28 02:01:55','2024-09-28 02:01:55'),(22,2000,NULL,'0',14,'2024-09-28 02:02:18','2024-09-28 02:02:18'),(23,2000,NULL,'8000',31,'2024-09-28 02:02:35','2024-09-28 02:02:35'),(24,2000,NULL,'0',49,'2024-09-28 02:02:54','2024-09-28 02:02:54'),(25,2000,NULL,'2000',21,'2024-09-28 02:03:09','2024-09-28 02:03:09'),(26,1472,NULL,'1528',48,'2024-09-28 02:03:35','2024-09-28 02:03:35'),(27,1000,NULL,'0',37,'2024-09-28 02:04:02','2024-09-28 02:04:02'),(31,-1330,NULL,'1330',12,'2024-09-28 02:21:31','2024-09-28 02:21:31'),(32,-1200,NULL,'1200',52,'2024-09-28 02:22:14','2024-09-28 02:22:14'),(33,-1000,NULL,'7000',28,'2024-09-28 02:22:35','2024-09-28 02:22:35'),(34,-1000,NULL,'1000',7,'2024-09-28 02:22:49','2024-09-28 02:22:49'),(35,-940,NULL,'940',42,'2024-09-28 02:23:15','2024-09-28 02:23:15'),(36,-700,NULL,'1400',47,'2024-09-28 02:24:50','2024-09-28 02:24:50'),(37,-700,NULL,'3700',44,'2024-09-28 02:25:34','2024-09-28 02:25:34'),(38,-550,NULL,'550',4,'2024-09-28 02:26:18','2024-09-28 02:26:18'),(39,-550,NULL,'10550',41,'2024-09-28 02:41:19','2024-09-28 02:41:19'),(40,-300,NULL,'300',14,'2024-09-28 02:41:46','2024-09-28 02:41:46'),(54,-90,NULL,NULL,11,'2024-09-28 05:21:52','2024-09-28 05:23:17'),(55,-90,NULL,NULL,3,'2024-09-28 05:22:25','2024-09-28 05:23:06'),(56,-90,NULL,NULL,51,'2024-09-28 05:22:39','2024-09-28 05:22:54'),(59,-3000,NULL,NULL,51,'2024-09-29 01:47:20','2024-09-29 01:47:20'),(60,-3000,NULL,NULL,10,'2024-09-29 01:48:06','2024-09-29 01:48:06'),(61,-4000,NULL,NULL,12,'2024-09-29 01:48:40','2024-09-29 01:48:52'),(62,-500,NULL,NULL,42,'2024-09-29 01:49:46','2024-09-29 01:49:46'),(63,-300,NULL,NULL,7,'2024-09-29 01:50:25','2024-09-29 01:50:25'),(64,-700,'Zeyad cost',NULL,10,'2024-09-29 01:51:00','2024-09-29 01:51:14'),(65,-4000,NULL,NULL,41,'2024-09-29 01:52:11','2024-09-29 01:52:21'),(66,3000,'Rest money',NULL,44,'2024-10-03 16:53:09','2024-10-03 16:53:09'),(67,-500,'Kermina cost',NULL,41,'2024-10-03 23:48:53','2024-10-04 04:42:15'),(68,1528,'Sent 2796 hassan',NULL,48,'2024-10-06 01:53:23','2024-10-06 01:53:23'),(69,1266,'Sent 2794 hassan divided them on harminy and vega',NULL,26,'2024-10-06 01:54:23','2024-10-06 01:54:23'),(70,-700,'Comission on credit card',NULL,6,'2024-10-08 01:35:00','2024-10-08 01:35:00'),(71,5000,'Maher',NULL,53,'2024-10-08 01:37:04','2024-10-08 01:37:04'),(72,-1005,'Kermina cost in gym eva and harmony',NULL,21,'2024-10-11 23:34:03','2024-10-15 23:05:26'),(73,-350,'Card renwal fees',NULL,41,'2024-10-12 22:34:04','2024-10-12 22:34:04'),(74,700,NULL,NULL,47,'2024-10-26 05:24:22','2024-10-26 05:24:22'),(75,5000,NULL,NULL,56,'2024-10-26 05:26:01','2024-10-26 05:26:01'),(76,-5000,'Kermina cost',NULL,56,'2024-10-26 05:26:40','2024-10-26 05:27:03'),(77,2000,NULL,NULL,21,'2024-11-03 15:30:52','2024-11-03 15:30:52'),(78,4000,NULL,NULL,53,'2024-11-03 15:31:32','2024-11-03 15:31:43'),(79,-1200,'kermina cost',NULL,53,'2024-11-03 15:32:24','2024-11-03 15:32:24'),(80,2500,NULL,NULL,41,'2024-11-05 06:47:36','2024-11-05 06:47:36'),(81,-1000,'Zryad cost',NULL,41,'2024-11-06 04:37:25','2024-11-06 04:37:25'),(82,-1000,'Tadros cost jaiden+gma',NULL,28,'2024-11-11 05:13:03','2024-11-11 05:13:03'),(83,5000,NULL,NULL,41,'2024-11-23 07:28:47','2024-11-23 07:28:47'),(84,-1000,'Kermina cost',NULL,41,'2024-11-23 07:29:24','2024-11-23 07:29:24'),(85,-3000,'Gerges fees',NULL,53,'2024-12-02 23:28:55','2024-12-02 23:28:55'),(86,2000,'Additional cost',NULL,20,'2024-12-16 00:05:56','2024-12-16 00:05:56'),(87,-1000,'Kermina cost',NULL,20,'2024-12-16 00:06:35','2024-12-16 00:06:35');
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
) ENGINE=InnoDB AUTO_INCREMENT=174 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `files`
--

LOCK TABLES `files` WRITE;
/*!40000 ALTER TABLE `files` DISABLE KEYS */;
INSERT INTO `files` VALUES (1,'images/cgWPIBaJgb4Scv32ZJiBUlfgxxmN1VBPaZXHuBNQ.png',1,'App\\Models\\Gallery','2024-08-31 08:15:16','2024-08-31 08:15:16'),(2,'images/jt56GhBaJfQpaA0NvqXZ7bdakujTuzyW70lRLtoE.png',1,'App\\Models\\Gallery','2024-08-31 08:15:16','2024-08-31 08:15:16'),(3,'images/Ix6TIYHwCvxgPtWaspfddbGvyZYXXt9jrec8yAkn.png',1,'App\\Models\\Gallery','2024-08-31 08:15:16','2024-08-31 08:15:16'),(4,'images/7eXRM4Y6H4A8avrsL6ihOwVZ4b7abBbA6pDuyET4.png',1,'App\\Models\\Gallery','2024-08-31 08:15:16','2024-08-31 08:15:16'),(5,'images/ynASd3T5mGdFuUZi6uvWaih3GZjs4w0VRltMK470.png',1,'App\\Models\\Gallery','2024-08-31 08:15:16','2024-08-31 08:15:16'),(6,'images/PbJ4udZknEOWeALHvGi3sQuThWWohAonTar88NOF.png',1,'App\\Models\\Gallery','2024-08-31 08:15:16','2024-08-31 08:15:16'),(7,'images/Y94snrI09Gex5SNQO5yZrqzE2e3Guht71rEWbsXX.png',1,'App\\Models\\Gallery','2024-08-31 08:15:16','2024-08-31 08:15:16'),(8,'images/NhEKA5TSZe0EOe15L4jDznG48seP3urSspWgl79u.png',1,'App\\Models\\Gallery','2024-08-31 08:15:16','2024-08-31 08:15:16'),(9,'images/fu4OVbhm6tLlfpM0JOESaKkSMRLuF6OuOlVT13DF.png',1,'App\\Models\\Gallery','2024-08-31 08:15:16','2024-08-31 08:15:16'),(10,'images/ipHIqPYZfDEcp6EjxpQzumYCBPt0GzsFnhtCt294.png',1,'App\\Models\\Gallery','2024-08-31 08:15:16','2024-08-31 08:15:16'),(11,'images/mOPxVTc5mVCGnZTkxFFokefhj9jR52Ws1k1kTbMZ.png',1,'App\\Models\\Gallery','2024-08-31 08:15:16','2024-08-31 08:15:16'),(12,'images/NBuecH0kpfPECl0Hjqk4KRh60BnDzVpVTm1l3aaQ.png',2,'App\\Models\\Gallery','2024-08-31 08:15:16','2024-08-31 08:15:16'),(13,'images/bwq9e5TPGiu6FZj1xtmqeMYhJwTs3FQtOSDjBWg1.png',2,'App\\Models\\Gallery','2024-08-31 08:15:16','2024-08-31 08:15:16'),(14,'images/lHoEcIQO2nOpcFTPJeLWktWtwqSPNcteQ46NFWlA.png',2,'App\\Models\\Gallery','2024-08-31 08:15:16','2024-08-31 08:15:16'),(15,'images/rCkgzRr6gD7Eozb4hzrZdGRWKbDZmMKEsGWBCjgw.png',2,'App\\Models\\Gallery','2024-08-31 08:15:16','2024-08-31 08:15:16'),(16,'images/PT070XhctXpMgtxLv6liva7IKqZdpvAZCacOt73V.png',2,'App\\Models\\Gallery','2024-08-31 08:15:16','2024-08-31 08:15:16'),(17,'images/hcYqQxwjM2yv6m5BTKSuYQ8jh3Nnk358woGX8y5C.png',2,'App\\Models\\Gallery','2024-08-31 08:15:16','2024-08-31 08:15:16'),(18,'images/Sq4e5UYueEeU3E7yy70isDq0WfKOwgujUHCo2PuD.png',2,'App\\Models\\Gallery','2024-08-31 08:15:16','2024-08-31 08:15:16'),(19,'images/reservyaprofile/1.jpeg',3,'App\\Models\\Gallery','2024-08-31 08:15:16','2024-08-31 08:15:16'),(20,'images/reservyaprofile/2.jpeg',3,'App\\Models\\Gallery','2024-08-31 08:15:16','2024-08-31 08:15:16'),(21,'images/reservyaprofile/3.jpeg',3,'App\\Models\\Gallery','2024-08-31 08:15:16','2024-08-31 08:15:16'),(22,'images/reservyaprofile/4.jpeg',3,'App\\Models\\Gallery','2024-08-31 08:15:16','2024-08-31 08:15:16'),(23,'images/reservyaprofile/5.jpeg',3,'App\\Models\\Gallery','2024-08-31 08:15:16','2024-08-31 08:15:16'),(24,'images/reservyaprofile/6.jpeg',3,'App\\Models\\Gallery','2024-08-31 08:15:16','2024-08-31 08:15:16'),(25,'images/reservyaprofile/7.jpeg',3,'App\\Models\\Gallery','2024-08-31 08:15:16','2024-08-31 08:15:16'),(26,'images/reservyaprofile/8.jpeg',3,'App\\Models\\Gallery','2024-08-31 08:15:16','2024-08-31 08:15:16'),(27,'images/reservyaprofile/9.jpeg',3,'App\\Models\\Gallery','2024-08-31 08:15:16','2024-08-31 08:15:16'),(28,'images/reservyaprofile/10.jpeg',3,'App\\Models\\Gallery','2024-08-31 08:15:16','2024-08-31 08:15:16'),(29,'images/reservyaprofile/11.jpeg',3,'App\\Models\\Gallery','2024-08-31 08:15:16','2024-08-31 08:15:16'),(30,'images/reservyaprofile/12.jpeg',3,'App\\Models\\Gallery','2024-08-31 08:15:16','2024-08-31 08:15:16'),(31,'images/reservyaprofile/13.jpeg',3,'App\\Models\\Gallery','2024-08-31 08:15:16','2024-08-31 08:15:16'),(32,'images/reservyaprofile/14.jpeg',3,'App\\Models\\Gallery','2024-08-31 08:15:16','2024-08-31 08:15:16'),(33,'images/elmandra_elarabia/1.jpeg',4,'App\\Models\\Gallery','2024-08-31 08:15:16','2024-08-31 08:15:16'),(34,'images/elmandra_elarabia/2.jpeg',4,'App\\Models\\Gallery','2024-08-31 08:15:16','2024-08-31 08:15:16'),(35,'images/elmandra_elarabia/3.jpeg',4,'App\\Models\\Gallery','2024-08-31 08:15:16','2024-08-31 08:15:16'),(36,'images/elmandra_elarabia/4.jpeg',4,'App\\Models\\Gallery','2024-08-31 08:15:16','2024-08-31 08:15:16'),(37,'images/elmandra_elarabia/5.jpeg',4,'App\\Models\\Gallery','2024-08-31 08:15:16','2024-08-31 08:15:16'),(38,'images/elmandra_elarabia/6.jpeg',4,'App\\Models\\Gallery','2024-08-31 08:15:16','2024-08-31 08:15:16'),(39,'images/elmandra_elarabia/7.jpeg',4,'App\\Models\\Gallery','2024-08-31 08:15:16','2024-08-31 08:15:16'),(40,'images/elmandra_elarabia/8.jpeg',4,'App\\Models\\Gallery','2024-08-31 08:15:16','2024-08-31 08:15:16'),(41,'images/elmandra_elarabia/9.jpeg',4,'App\\Models\\Gallery','2024-08-31 08:15:16','2024-08-31 08:15:16'),(42,'images/elmandra_elarabia/10.jpeg',4,'App\\Models\\Gallery','2024-08-31 08:15:16','2024-08-31 08:15:16'),(43,'images/elmandra_elarabia/11.jpeg',4,'App\\Models\\Gallery','2024-08-31 08:15:16','2024-08-31 08:15:16'),(44,'images/elmandra_elarabia/12.jpeg',4,'App\\Models\\Gallery','2024-08-31 08:15:16','2024-08-31 08:15:16'),(45,'images/elmandra_elarabia/13.jpeg',4,'App\\Models\\Gallery','2024-08-31 08:15:16','2024-08-31 08:15:16'),(46,'images/gym/1.jpeg',5,'App\\Models\\Gallery','2024-08-31 08:15:16','2024-08-31 08:15:16'),(47,'images/gym/2.jpeg',5,'App\\Models\\Gallery','2024-08-31 08:15:16','2024-08-31 08:15:16'),(48,'images/gym/3.jpeg',5,'App\\Models\\Gallery','2024-08-31 08:15:16','2024-08-31 08:15:16'),(49,'images/gym/4.jpeg',5,'App\\Models\\Gallery','2024-08-31 08:15:16','2024-08-31 08:15:16'),(50,'images/gym/5.jpeg',5,'App\\Models\\Gallery','2024-08-31 08:15:16','2024-08-31 08:15:16'),(51,'images/gym/6.jpeg',5,'App\\Models\\Gallery','2024-08-31 08:15:16','2024-08-31 08:15:16'),(52,'images/gym/7.jpeg',5,'App\\Models\\Gallery','2024-08-31 08:15:16','2024-08-31 08:15:16'),(53,'images/gym/8.jpeg',5,'App\\Models\\Gallery','2024-08-31 08:15:16','2024-08-31 08:15:16'),(54,'images/gym/9.jpeg',5,'App\\Models\\Gallery','2024-08-31 08:15:16','2024-08-31 08:15:16'),(55,'images/gym/10.jpeg',5,'App\\Models\\Gallery','2024-08-31 08:15:16','2024-08-31 08:15:16'),(56,'images/gym/11.jpeg',5,'App\\Models\\Gallery','2024-08-31 08:15:16','2024-08-31 08:15:16'),(57,'images/gym/12.jpeg',5,'App\\Models\\Gallery','2024-08-31 08:15:16','2024-08-31 08:15:16'),(58,'images/asleltawfeer/1.png',6,'App\\Models\\Gallery','2024-08-31 08:15:16','2024-08-31 08:15:16'),(59,'images/asleltawfeer/2.png',6,'App\\Models\\Gallery','2024-08-31 08:15:16','2024-08-31 08:15:16'),(60,'images/asleltawfeer/3.png',6,'App\\Models\\Gallery','2024-08-31 08:15:16','2024-08-31 08:15:16'),(61,'images/asleltawfeer/4.png',6,'App\\Models\\Gallery','2024-08-31 08:15:16','2024-08-31 08:15:16'),(62,'images/asleltawfeer/5.png',6,'App\\Models\\Gallery','2024-08-31 08:15:16','2024-08-31 08:15:16'),(63,'images/asleltawfeer/6.png',6,'App\\Models\\Gallery','2024-08-31 08:15:16','2024-08-31 08:15:16'),(64,'images/asleltawfeer/7.png',6,'App\\Models\\Gallery','2024-08-31 08:15:16','2024-08-31 08:15:16'),(65,'images/asleltawfeer/8.png',6,'App\\Models\\Gallery','2024-08-31 08:15:16','2024-08-31 08:15:16'),(66,'images/asleltawfeer/9.png',6,'App\\Models\\Gallery','2024-08-31 08:15:16','2024-08-31 08:15:16'),(67,'images/asleltawfeer/10.png',6,'App\\Models\\Gallery','2024-08-31 08:15:16','2024-08-31 08:15:16'),(68,'images/asleltawfeer/11.png',6,'App\\Models\\Gallery','2024-08-31 08:15:16','2024-08-31 08:15:16'),(69,'images/asleltawfeer/12.png',6,'App\\Models\\Gallery','2024-08-31 08:15:16','2024-08-31 08:15:16'),(70,'images/asleltawfeer/13.png',6,'App\\Models\\Gallery','2024-08-31 08:15:16','2024-08-31 08:15:16'),(71,'images/asleltawfeer/14.png',6,'App\\Models\\Gallery','2024-08-31 08:15:16','2024-08-31 08:15:16'),(72,'images/celine/1.jpeg',7,'App\\Models\\Gallery','2024-08-31 08:15:16','2024-08-31 08:15:16'),(73,'images/celine/2.jpeg',7,'App\\Models\\Gallery','2024-08-31 08:15:16','2024-08-31 08:15:16'),(74,'images/celine/3.jpeg',7,'App\\Models\\Gallery','2024-08-31 08:15:16','2024-08-31 08:15:16'),(75,'images/celine/4.jpeg',7,'App\\Models\\Gallery','2024-08-31 08:15:16','2024-08-31 08:15:16'),(76,'images/celine/5.jpeg',7,'App\\Models\\Gallery','2024-08-31 08:15:16','2024-08-31 08:15:16'),(77,'images/celine/6.jpeg',7,'App\\Models\\Gallery','2024-08-31 08:15:16','2024-08-31 08:15:16'),(78,'images/celine/7.jpeg',7,'App\\Models\\Gallery','2024-08-31 08:15:16','2024-08-31 08:15:16'),(79,'images/celine/8.jpeg',7,'App\\Models\\Gallery','2024-08-31 08:15:16','2024-08-31 08:15:16'),(80,'images/celine/9.jpeg',7,'App\\Models\\Gallery','2024-08-31 08:15:16','2024-08-31 08:15:16'),(81,'images/celine/10.jpeg',7,'App\\Models\\Gallery','2024-08-31 08:15:16','2024-08-31 08:15:16'),(82,'images/celine/11.jpeg',7,'App\\Models\\Gallery','2024-08-31 08:15:16','2024-08-31 08:15:16'),(83,'images/celine/12.jpeg',7,'App\\Models\\Gallery','2024-08-31 08:15:16','2024-08-31 08:15:16'),(84,'images/celine/13.jpeg',7,'App\\Models\\Gallery','2024-08-31 08:15:16','2024-08-31 08:15:16'),(85,'images/celine/14.jpeg',7,'App\\Models\\Gallery','2024-08-31 08:15:16','2024-08-31 08:15:16'),(86,'images/celine/15.jpeg',7,'App\\Models\\Gallery','2024-08-31 08:15:16','2024-08-31 08:15:16'),(87,'images/celine/16.jpeg',7,'App\\Models\\Gallery','2024-08-31 08:15:16','2024-08-31 08:15:16'),(88,'images/celine/17.jpeg',7,'App\\Models\\Gallery','2024-08-31 08:15:16','2024-08-31 08:15:16'),(89,'images/msabaatsteel/1.png',8,'App\\Models\\Gallery','2024-08-31 08:15:16','2024-08-31 08:15:16'),(90,'images/msabaatsteel/2.png',8,'App\\Models\\Gallery','2024-08-31 08:15:16','2024-08-31 08:15:16'),(91,'images/msabaatsteel/3.png',8,'App\\Models\\Gallery','2024-08-31 08:15:16','2024-08-31 08:15:16'),(92,'images/msabaatsteel/4.png',8,'App\\Models\\Gallery','2024-08-31 08:15:16','2024-08-31 08:15:16'),(93,'images/msabaatsteel/5.png',8,'App\\Models\\Gallery','2024-08-31 08:15:16','2024-08-31 08:15:16'),(94,'images/msabaatsteel/6.png',8,'App\\Models\\Gallery','2024-08-31 08:15:16','2024-08-31 08:15:16'),(95,'images/msabaatsteel/7.png',8,'App\\Models\\Gallery','2024-08-31 08:15:16','2024-08-31 08:15:16'),(96,'images/msabaatsteel/8.png',8,'App\\Models\\Gallery','2024-08-31 08:15:16','2024-08-31 08:15:16'),(97,'images/msabaatsteel/9.png',8,'App\\Models\\Gallery','2024-08-31 08:15:16','2024-08-31 08:15:16'),(98,'images/msabaatsteel/10.png',8,'App\\Models\\Gallery','2024-08-31 08:15:16','2024-08-31 08:15:16'),(99,'images/msabaatsteel/11.png',8,'App\\Models\\Gallery','2024-08-31 08:15:16','2024-08-31 08:15:16'),(100,'images/msabaatsteel/12.png',8,'App\\Models\\Gallery','2024-08-31 08:15:16','2024-08-31 08:15:16'),(101,'images/haddak/1.jpeg',9,'App\\Models\\Gallery','2024-08-31 08:15:16','2024-08-31 08:15:16'),(102,'images/haddak/2.jpeg',9,'App\\Models\\Gallery','2024-08-31 08:15:16','2024-08-31 08:15:16'),(103,'images/haddak/3.jpeg',9,'App\\Models\\Gallery','2024-08-31 08:15:16','2024-08-31 08:15:16'),(104,'images/haddak/4.jpeg',9,'App\\Models\\Gallery','2024-08-31 08:15:16','2024-08-31 08:15:16'),(105,'images/haddak/5.jpeg',9,'App\\Models\\Gallery','2024-08-31 08:15:16','2024-08-31 08:15:16'),(106,'images/haddak/6.jpeg',9,'App\\Models\\Gallery','2024-08-31 08:15:16','2024-08-31 08:15:16'),(107,'images/haddak/7.jpeg',9,'App\\Models\\Gallery','2024-08-31 08:15:16','2024-08-31 08:15:16'),(108,'images/haddak/8.jpeg',9,'App\\Models\\Gallery','2024-08-31 08:15:16','2024-08-31 08:15:16'),(109,'images/haddak/9.jpeg',9,'App\\Models\\Gallery','2024-08-31 08:15:16','2024-08-31 08:15:16'),(110,'images/haddak/10.jpeg',9,'App\\Models\\Gallery','2024-08-31 08:15:16','2024-08-31 08:15:16'),(111,'images/haddak/11.jpeg',9,'App\\Models\\Gallery','2024-08-31 08:15:16','2024-08-31 08:15:16'),(112,'images/eljazira/1.png',10,'App\\Models\\Gallery','2024-08-31 08:15:16','2024-08-31 08:15:16'),(113,'images/eljazira/2.png',10,'App\\Models\\Gallery','2024-08-31 08:15:16','2024-08-31 08:15:16'),(114,'images/eljazira/3.png',10,'App\\Models\\Gallery','2024-08-31 08:15:16','2024-08-31 08:15:16'),(115,'images/eljazira/4.png',10,'App\\Models\\Gallery','2024-08-31 08:15:16','2024-08-31 08:15:16'),(116,'images/eljazira/5.png',10,'App\\Models\\Gallery','2024-08-31 08:15:16','2024-08-31 08:15:16'),(117,'images/eljazira/6.png',10,'App\\Models\\Gallery','2024-08-31 08:15:16','2024-08-31 08:15:16'),(118,'images/eljazira/7.png',10,'App\\Models\\Gallery','2024-08-31 08:15:16','2024-08-31 08:15:16'),(119,'images/eljazira/8.png',10,'App\\Models\\Gallery','2024-08-31 08:15:16','2024-08-31 08:15:16'),(120,'images/eljazira/9.png',10,'App\\Models\\Gallery','2024-08-31 08:15:16','2024-08-31 08:15:16'),(121,'images/egypttourism/1.jpeg',11,'App\\Models\\Gallery','2024-08-31 08:15:16','2024-08-31 08:15:16'),(122,'images/egypttourism/2.jpeg',11,'App\\Models\\Gallery','2024-08-31 08:15:16','2024-08-31 08:15:16'),(123,'images/egypttourism/3.jpeg',11,'App\\Models\\Gallery','2024-08-31 08:15:16','2024-08-31 08:15:16'),(124,'images/egypttourism/4.jpeg',11,'App\\Models\\Gallery','2024-08-31 08:15:16','2024-08-31 08:15:16'),(125,'images/egypttourism/5.jpeg',11,'App\\Models\\Gallery','2024-08-31 08:15:16','2024-08-31 08:15:16'),(126,'images/egypttourism/6.jpeg',11,'App\\Models\\Gallery','2024-08-31 08:15:16','2024-08-31 08:15:16'),(127,'images/egypttourism/7.jpeg',11,'App\\Models\\Gallery','2024-08-31 08:15:16','2024-08-31 08:15:16'),(128,'images/egypttourism/8.jpeg',11,'App\\Models\\Gallery','2024-08-31 08:15:16','2024-08-31 08:15:16'),(129,'images/egypttourism/9.jpeg',11,'App\\Models\\Gallery','2024-08-31 08:15:16','2024-08-31 08:15:16'),(130,'images/egypttourism/10.jpeg',11,'App\\Models\\Gallery','2024-08-31 08:15:16','2024-08-31 08:15:16'),(131,'images/egypttourism/11.jpeg',11,'App\\Models\\Gallery','2024-08-31 08:15:16','2024-08-31 08:15:16'),(132,'images/6Uc5BhjmQJtfneedg6lKQ4U0Mh4SHOs5OAd8StZd.webp',1,'App\\Models\\Page','2024-08-31 08:15:16','2024-08-31 08:15:16'),(133,'images/dbfWCgbV5jglKcWKTYT6SeIsuAsQxCQ4GGDLHXex.webp',2,'App\\Models\\Page','2024-08-31 08:15:16','2024-08-31 08:15:16'),(134,'images/8dTGgGdIWqURKxo2SYehtgjCL3AKeSKmINcUVMyy.webp',6,'App\\Models\\Page','2024-08-31 08:15:16','2024-08-31 08:15:16'),(135,'images/l2K1cEb5wcsPVzhHhj2OWNcQXBPKKrofxrfhgu5W.webp',7,'App\\Models\\Page','2024-08-31 08:15:16','2024-08-31 08:15:16'),(136,'images/khyVZVtSks0zZfm3NQAA3496oI8ovcN3rzKD9rX4.webp',7,'App\\Models\\Page','2024-08-31 08:15:16','2024-08-31 08:15:16'),(137,'images/NzpSLncvvrosX4WqGDJLZtWvY3Xrvxzw6saO8xr6.webp',7,'App\\Models\\Page','2024-08-31 08:15:16','2024-08-31 08:15:16'),(138,'images/lFm4BhN2x9t3xJnk42ivFtqCWzMCcLppx1Mlr9gN.jpg',1,'App\\Models\\Service','2024-08-31 08:15:17','2024-08-31 08:15:17'),(139,'images/tqmoHh1nzC4Zg0IE4JykvWbBigfJpdIxMqxNcYPF.jpg',2,'App\\Models\\Service','2024-08-31 08:15:17','2024-08-31 08:15:17'),(140,'images/fih4AHmLMdr3mBpXqeeellC00S18BZm5dDCHcntw.jpg',3,'App\\Models\\Service','2024-08-31 08:15:17','2024-08-31 08:15:17'),(141,'images/yvxLurP4RFhTzwsih8n5pYC62eHgY74TDzQ3J8xF.jpg',4,'App\\Models\\Service','2024-08-31 08:15:17','2024-08-31 08:15:17'),(142,'images/tykEYLJg6IvrEdpzYcHTmLm5WWErcSklnEZcOjcI.webp',1,'App\\Models\\Partner','2024-08-31 08:15:17','2024-08-31 08:15:17'),(143,'images/HsWogOvEjxPtEStdNr913ols44RFifVERaoyxkwh.webp',2,'App\\Models\\Partner','2024-08-31 08:15:17','2024-08-31 08:15:17'),(144,'images/PF6upRmlXRiiLF1JVifLw2q43EI50i0dnTGHP6xu.webp',3,'App\\Models\\Partner','2024-08-31 08:15:17','2024-08-31 08:15:17'),(145,'images/TpVI2ZX1wEb42aAx56kLkGIpwGHyW1sPLeBgF5e8.webp',4,'App\\Models\\Partner','2024-08-31 08:15:17','2024-08-31 08:15:17'),(146,'images/zlqIgyZxaZJCmqfSvsxqkTIFsou1vItih8tUaqXi.jpg',1,'App\\Models\\Team','2024-08-31 08:15:17','2024-08-31 08:15:17'),(147,'images/YE92B4LXiM6QhFcQbr5YKECGaMU5k8NokXve9o1m.jpg',2,'App\\Models\\Team','2024-08-31 08:15:17','2024-08-31 08:15:17'),(148,'images/YQXLPLiQgi8H1E9YE77J3lwUX0qSOYXkHMP192Nz.png',3,'App\\Models\\Team','2024-08-31 08:15:17','2024-08-31 08:15:17'),(149,'images/pekmLKsEWdfVwDSwbG0sSIZARXfO8GavZPaoOF1D.jpg',4,'App\\Models\\Team','2024-08-31 08:15:17','2024-08-31 08:15:17'),(150,'images/tAgfJG0vAJHhQsCii9FR441z6tGs9fyGKj92MUzy.jpg',5,'App\\Models\\Team','2024-08-31 08:15:17','2024-08-31 08:15:17'),(151,'images/melad.jpeg',6,'App\\Models\\Team','2024-08-31 08:15:17','2024-08-31 08:15:17'),(152,'images/zaid_sayed.jpeg',7,'App\\Models\\Team','2024-08-31 08:15:17','2024-08-31 08:15:17'),(153,'images/w66o7ZleB0PAmRNOOiLp37gmh9iwImRphogPhjFy.webp',1,'App\\Models\\Testimonial','2024-08-31 08:15:17','2024-08-31 08:15:17'),(154,'images/w66o7ZleB0PAmRNOOiLp37gmh9iwImRphogPhjFy.webp',2,'App\\Models\\Testimonial','2024-08-31 08:15:17','2024-08-31 08:15:17'),(155,'images/w66o7ZleB0PAmRNOOiLp37gmh9iwImRphogPhjFy.webp',3,'App\\Models\\Testimonial','2024-08-31 08:15:17','2024-08-31 08:15:17'),(156,'images/w66o7ZleB0PAmRNOOiLp37gmh9iwImRphogPhjFy.webp',4,'App\\Models\\Testimonial','2024-08-31 08:15:17','2024-08-31 08:15:17'),(157,'images/w66o7ZleB0PAmRNOOiLp37gmh9iwImRphogPhjFy.webp',5,'App\\Models\\Testimonial','2024-08-31 08:15:17','2024-08-31 08:15:17'),(158,'images/lFm4BhN2x9t3xJnk42ivFtqCWzMCcLppx1Mlr9gN.jpg',1,'App\\Models\\Product','2024-08-31 08:15:17','2024-08-31 08:15:17'),(159,'images/tqmoHh1nzC4Zg0IE4JykvWbBigfJpdIxMqxNcYPF.jpg',2,'App\\Models\\Product','2024-08-31 08:15:17','2024-08-31 08:15:17'),(160,'images/fih4AHmLMdr3mBpXqeeellC00S18BZm5dDCHcntw.jpg',3,'App\\Models\\Product','2024-08-31 08:15:17','2024-08-31 08:15:17'),(161,'images/yvxLurP4RFhTzwsih8n5pYC62eHgY74TDzQ3J8xF.jpg',4,'App\\Models\\Product','2024-08-31 08:15:17','2024-08-31 08:15:17'),(162,'images/lFm4BhN2x9t3xJnk42ivFtqCWzMCcLppx1Mlr9gN.jpg',1,'App\\Models\\Category','2024-08-31 08:15:17','2024-08-31 08:15:17'),(163,'images/tqmoHh1nzC4Zg0IE4JykvWbBigfJpdIxMqxNcYPF.jpg',2,'App\\Models\\Category','2024-08-31 08:15:17','2024-08-31 08:15:17'),(164,'images/fih4AHmLMdr3mBpXqeeellC00S18BZm5dDCHcntw.jpg',3,'App\\Models\\Category','2024-08-31 08:15:17','2024-08-31 08:15:17'),(165,'images/yvxLurP4RFhTzwsih8n5pYC62eHgY74TDzQ3J8xF.jpg',4,'App\\Models\\Category','2024-08-31 08:15:17','2024-08-31 08:15:17'),(169,'images/OtaQZFGbmP8guPqIewRpDvqxxqFhFCMmbPcqm8pS.jpg',10,'App\\Models\\Admin','2024-09-03 12:05:57','2024-09-03 12:05:57'),(170,'images/55SamJOzOwjjnpm3AOvuXuJziJit9sMQEDhvPd50.jpg',11,'App\\Models\\Admin','2024-10-13 17:07:54','2024-10-13 17:07:54'),(171,'images/cmgd2jdkNwGrnvoCmpaUWthsdsr8mSJHSdSUSiRG.jpg',12,'App\\Models\\Admin','2024-10-13 17:09:59','2024-10-13 17:09:59'),(172,'images/kZMEFWhQrHe2mp6wCp6ueCZuBR03Z5nyidFhZODs.png',13,'App\\Models\\Admin','2024-12-07 03:38:45','2024-12-07 03:38:45'),(173,'images/ukSbMtSDjINqidGvFz9qxJEGVcawiOIg2nia8DZt.jpg',8,'App\\Models\\Team','2024-12-07 07:22:03','2024-12-07 07:22:03');
/*!40000 ALTER TABLE `files` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `followups`
--

DROP TABLE IF EXISTS `followups`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `followups` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '0',
  `employee_id` bigint(20) unsigned DEFAULT NULL,
  `difficulty` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `hasPhone` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `followups_employee_id_foreign` (`employee_id`),
  CONSTRAINT `followups_employee_id_foreign` FOREIGN KEY (`employee_id`) REFERENCES `admins` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=96 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `followups`
--

LOCK TABLES `followups` WRITE;
/*!40000 ALTER TABLE `followups` DISABLE KEYS */;
INSERT INTO `followups` VALUES (50,'https://www.facebook.com/share/p/17v2YmBTbj/',0,13,0,'2024-12-07 03:59:41','2024-12-08 07:08:36',0),(51,'https://www.facebook.com/share/p/17v2YmBTbj/',0,13,0,'2024-12-07 03:59:41','2024-12-08 07:08:36',0),(52,'https://www.facebook.com/share/p/17v2YmBTbj/',0,13,0,'2024-12-07 03:59:41','2024-12-08 07:08:36',0),(53,'https://www.facebook.com/share/p/17v2YmBTbj/',0,13,0,'2024-12-07 03:59:41','2024-12-08 07:08:36',0),(54,'https://www.facebook.com/share/p/17v2YmBTbj/',0,13,0,'2024-12-07 03:59:41','2024-12-08 07:08:36',0),(55,'https://www.facebook.com/share/p/17v2YmBTbj/',0,13,0,'2024-12-07 03:59:41','2024-12-08 07:08:36',0),(56,'https://www.facebook.com/share/p/17v2YmBTbj/',0,13,0,'2024-12-07 03:59:41','2024-12-08 07:08:36',0),(57,'https://www.facebook.com/share/p/17v2YmBTbj/',0,13,0,'2024-12-07 03:59:41','2024-12-08 07:08:36',0),(58,'https://www.facebook.com/groups/websitedesign.websitebuilder/permalink/3013901155429277/?rdid=HKIAyDyKfmLGtNZq#',1,13,0,'2024-12-07 03:59:41','2024-12-08 07:03:22',1),(59,'https://www.facebook.com/groups/websitedesign.websitebuilder/permalink/3013901155429277/?rdid=HKIAyDyKfmLGtNZq#',1,13,0,'2024-12-07 03:59:41','2024-12-08 07:03:22',1),(60,'https://www.facebook.com/groups/websitedesign.websitebuilder/permalink/3013901155429277/?rdid=HKIAyDyKfmLGtNZq#',1,13,0,'2024-12-07 03:59:41','2024-12-08 07:03:22',1),(61,'https://www.facebook.com/groups/websitedesign.websitebuilder/permalink/3013901155429277/?rdid=HKIAyDyKfmLGtNZq#',1,13,0,'2024-12-07 03:59:41','2024-12-08 07:03:22',1),(62,'https://www.facebook.com/groups/websitedesign.websitebuilder/permalink/3013901155429277/?rdid=HKIAyDyKfmLGtNZq#',1,13,0,'2024-12-07 03:59:41','2024-12-08 07:03:22',1),(63,'https://www.facebook.com/groups/websitedesign.websitebuilder/permalink/3013901155429277/?rdid=HKIAyDyKfmLGtNZq#',1,13,0,'2024-12-07 03:59:41','2024-12-08 07:03:22',1),(64,'https://www.facebook.com/groups/websitedesign.websitebuilder/permalink/3013901155429277/?rdid=HKIAyDyKfmLGtNZq#',1,13,0,'2024-12-07 03:59:41','2024-12-08 07:03:22',1),(65,'https://www.facebook.com/share/p/1Gf1pVuENp/',1,13,0,'2024-12-07 07:05:29','2024-12-08 05:01:33',0),(66,'https://www.facebook.com/share/p/15d7F48but/',0,13,0,'2024-12-07 17:34:46','2024-12-07 17:34:46',0),(67,'https://www.facebook.com/share/p/14qPdZssib/',0,13,0,'2024-12-07 17:37:44','2024-12-07 17:37:44',0),(68,'https://www.facebook.com/share/p/18BuFeawY4/',1,13,0,'2024-12-07 17:39:23','2024-12-09 02:07:28',0),(69,'https://www.facebook.com/share/p/1CnY9iWHXu/',1,13,0,'2024-12-07 17:40:55','2024-12-09 02:05:24',0),(70,'https://www.facebook.com/share/p/J6xnw7Azd1xU4CAu/',1,13,0,'2024-12-08 02:44:17','2024-12-08 05:00:12',1),(71,'https://www.facebook.com/share/p/18YX6JpXDh/',1,13,0,'2024-12-08 03:11:45','2024-12-08 04:58:37',0),(72,'https://www.facebook.com/share/p/18ziURun3E/',1,13,0,'2024-12-08 03:12:09','2024-12-08 04:58:37',0),(73,'https://www.facebook.com/share/p/15hoTxhQA1/',1,13,1,'2024-12-08 22:13:45','2024-12-09 02:04:49',1),(74,'https://www.facebook.com/share/p/aNKPLrcSrwbxNsy3/',0,13,1,'2024-12-09 00:15:51','2024-12-09 00:15:51',1),(75,'https://www.facebook.com/share/p/18F1mPaiYr/',0,13,0,'2024-12-09 01:41:03','2024-12-09 01:41:03',0),(76,'https://www.facebook.com/share/p/1AtByp9j7g/',0,13,0,'2024-12-09 01:42:05','2024-12-09 01:42:05',1),(77,'https://www.facebook.com/share/p/19b4SpaQfh/',0,13,0,'2024-12-09 01:49:23','2024-12-09 01:49:23',1),(78,'https://www.facebook.com/share/p/19b4SpaQfh/',0,13,0,'2024-12-09 01:56:15','2024-12-09 01:56:15',1),(79,'https://www.facebook.com/groups/dev.kareem/permalink/10160664908307385/?rdid=ReMYXf0l8PgVNfC8',0,13,1,'2024-12-09 06:20:15','2024-12-09 06:20:15',0),(80,'https://www.facebook.com/groups/dev.kareem/permalink/10160668628992385/?rdid=h3IhKT7OsOB5DEVa#',1,13,1,'2024-12-09 06:21:47','2024-12-09 08:03:11',0),(81,'https://www.facebook.com/groups/dev.kareem/permalink/10160668628992385/?rdid=h3IhKT7OsOB5DEVa#',1,13,0,'2024-12-09 06:21:55','2024-12-09 08:03:11',0),(82,'https://www.facebook.com/share/p/15Xi1yXZPE/',0,13,0,'2024-12-09 07:58:45','2024-12-09 07:58:45',0),(83,'https://www.facebook.com/share/p/1DAdX9EvfT/',0,13,0,'2024-12-10 08:21:20','2024-12-10 08:21:20',0),(84,'https://www.facebook.com/share/p/1B844VaVX5/',0,13,0,'2024-12-12 13:13:16','2024-12-12 13:13:16',0),(85,'https://www.facebook.com/share/p/15Z6JNjB5y/',0,13,0,'2024-12-12 13:16:41','2024-12-12 13:16:41',0),(86,'https://www.facebook.com/share/p/1AfQwpAr4R/',0,13,0,'2024-12-13 14:09:40','2024-12-13 14:09:40',0),(87,'https://www.facebook.com/share/p/1KcPQWrEA4/',0,13,0,'2024-12-14 19:38:28','2024-12-14 19:38:28',0),(88,'https://www.facebook.com/share/p/33xQMG5E7FnEjjuT/',0,13,0,'2024-12-27 07:15:37','2024-12-27 07:15:37',0),(89,'https://www.facebook.com/share/p/GSidGahSAGcSFQSy/',0,13,0,'2024-12-27 07:15:37','2024-12-27 07:15:37',0),(90,'https://www.facebook.com/share/p/ZAo714JHyeTJJ5p3/',0,13,0,'2024-12-27 07:15:37','2024-12-27 07:15:37',0),(91,'https://www.facebook.com/share/p/hUX48vDyLhYJJXpk/',0,13,0,'2024-12-27 07:15:37','2024-12-27 07:15:37',0),(92,'https://www.facebook.com/share/p/3EGfRsGCeq8dCdC1/',0,13,0,'2024-12-27 07:15:37','2024-12-27 07:15:37',0),(93,'https://www.facebook.com/share/p/YxmkzX6SMNTCBusC/',0,13,0,'2024-12-27 07:15:37','2024-12-27 07:15:37',0),(94,'',0,13,0,'2024-12-27 07:15:37','2024-12-27 07:15:37',0),(95,'https://www.facebook.com/share/p/ceZgRDfDsTKHH6FF/',0,13,0,'2024-12-27 10:18:51','2024-12-27 10:20:10',1);
/*!40000 ALTER TABLE `followups` ENABLE KEYS */;
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
INSERT INTO `galleries` VALUES (1,'2024-08-31 08:15:16','2024-08-31 08:15:16'),(2,'2024-08-31 08:15:16','2024-08-31 08:15:16'),(3,'2024-08-31 08:15:16','2024-08-31 08:15:16'),(4,'2024-08-31 08:15:16','2024-08-31 08:15:16'),(5,'2024-08-31 08:15:16','2024-08-31 08:15:16'),(6,'2024-08-31 08:15:16','2024-08-31 08:15:16'),(7,'2024-08-31 08:15:16','2024-08-31 08:15:16'),(8,'2024-08-31 08:15:16','2024-08-31 08:15:16'),(9,'2024-08-31 08:15:16','2024-08-31 08:15:16'),(10,'2024-08-31 08:15:16','2024-08-31 08:15:16'),(11,'2024-08-31 08:15:16','2024-08-31 08:15:16');
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
INSERT INTO `gallery_translations` VALUES (1,'العالمية (موقع للتجارة الإلكترونية)',NULL,NULL,1,'ar','2024-08-31 08:15:16','2024-08-31 08:15:16'),(2,'Elalamia (e-commerce website)',NULL,NULL,1,'en','2024-08-31 08:15:16','2024-08-31 08:15:16'),(3,'سول فارما (موقع التجارة الإلكترونية)',NULL,NULL,2,'ar','2024-08-31 08:15:16','2024-08-31 08:15:16'),(4,'Soul Pharma (e-commerce website)',NULL,NULL,2,'en','2024-08-31 08:15:16','2024-08-31 08:15:16'),(5,'ملف تعريف ريسيرفيا (موقع التجارة الإلكترونية)',NULL,NULL,3,'ar','2024-08-31 08:15:16','2024-08-31 08:15:16'),(6,'Reservya Profile (e-commerce website)',NULL,NULL,3,'en','2024-08-31 08:15:16','2024-08-31 08:15:16'),(7,'المندر العربية (موقع للتجارة الإلكترونية)',NULL,NULL,4,'ar','2024-08-31 08:15:16','2024-08-31 08:15:16'),(8,'Elmandr Alarabia (e-commerce website)',NULL,NULL,4,'en','2024-08-31 08:15:16','2024-08-31 08:15:16'),(9,'GYM (موقع التجارة الإلكترونية)',NULL,NULL,5,'ar','2024-08-31 08:15:16','2024-08-31 08:15:16'),(10,'GYM (e-commerce website)',NULL,NULL,5,'en','2024-08-31 08:15:16','2024-08-31 08:15:16'),(11,'أصل التوفير (موقع للتجارة الإلكترونية)',NULL,NULL,6,'ar','2024-08-31 08:15:16','2024-08-31 08:15:16'),(12,'Asl Al Tawfeer (e-commerce website)',NULL,NULL,6,'en','2024-08-31 08:15:16','2024-08-31 08:15:16'),(13,'سيلين (خدمات فندقية)',NULL,NULL,7,'ar','2024-08-31 08:15:16','2024-08-31 08:15:16'),(14,'Celine (Hotel Services)',NULL,NULL,7,'en','2024-08-31 08:15:16','2024-08-31 08:15:16'),(15,'مسابات ستيل (موقع للتجارة الإلكترونية)',NULL,NULL,8,'ar','2024-08-31 08:15:16','2024-08-31 08:15:16'),(16,'Msabaat Steel (e-commerce website)',NULL,NULL,8,'en','2024-08-31 08:15:16','2024-08-31 08:15:16'),(17,'حداق الفيروز',NULL,NULL,9,'ar','2024-08-31 08:15:16','2024-08-31 08:15:16'),(18,'Haddak Elfayrouz',NULL,NULL,9,'en','2024-08-31 08:15:16','2024-08-31 08:15:16'),(19,'الجزيرة (خدمات فندقية)',NULL,NULL,10,'ar','2024-08-31 08:15:16','2024-08-31 08:15:16'),(20,'Al Jazira (Hotel Services)',NULL,NULL,10,'en','2024-08-31 08:15:16','2024-08-31 08:15:16'),(21,'ايجيبت للسياحة',NULL,NULL,11,'ar','2024-08-31 08:15:16','2024-08-31 08:15:16'),(22,'Egypt Tourism',NULL,NULL,11,'en','2024-08-31 08:15:16','2024-08-31 08:15:16');
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
INSERT INTO `messages` VALUES (1,'Ibrahim Samy','ibrahimsamy308@gmail.com','01289189890','ًكيفيه عمل موقع بتكلفه اقل','2024-08-31 08:15:16','2024-08-31 08:15:16'),(2,'Kero Boula','Kero@gmail.com','0124578960',NULL,'2024-08-31 08:15:16','2024-08-31 08:15:16'),(3,'ابراهيم سامى','ibrahim@gmail.com','450015885',NULL,'2024-08-31 08:15:16','2024-08-31 08:15:16');
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
) ENGINE=InnoDB AUTO_INCREMENT=50 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `migrations`
--

LOCK TABLES `migrations` WRITE;
/*!40000 ALTER TABLE `migrations` DISABLE KEYS */;
INSERT INTO `migrations` VALUES (1,'2014_04_02_193005_create_translations_table',1),(2,'2014_10_12_000000_create_users_table',1),(3,'2014_10_12_100000_create_password_reset_tokens_table',1),(4,'2014_10_12_100000_create_password_resets_table',1),(5,'2019_08_19_000000_create_failed_jobs_table',1),(6,'2019_12_14_000001_create_personal_access_tokens_table',1),(7,'2022_10_23_075806_create_categories_table',1),(8,'2022_10_23_075806_create_processes_table',1),(9,'2022_10_23_075806_create_products_table',1),(10,'2022_10_23_075806_create_services_table',1),(11,'2022_10_23_075806_create_testimonials_table',1),(12,'2022_10_23_075828_create_faqs_table',1),(13,'2022_10_23_075846_create_settings_table',1),(14,'2022_10_23_080942_create_galleries_table',1),(15,'2022_10_24_111948_create_partners_table',1),(16,'2022_10_24_111948_create_teams_table',1),(17,'2022_10_26_125729_create_pages_table',1),(18,'2022_10_29_155126_create_messages_table',1),(19,'2022_10_29_155126_create_newsletters_table',1),(20,'2022_10_29_155126_create_serviceRequests_table',1),(21,'2022_11_06_150334_create_images_table',1),(22,'2022_11_26_153759_create_videos_table',1),(23,'2022_11_26_154654_create_contacts_table',1),(24,'2022_11_26_154654_create_counters_table',1),(25,'2022_11_26_154654_create_projects_table',1),(26,'2023_06_26_124955_create_admins_table',1),(27,'2023_06_26_173744_create_permission_tables',1),(28,'2023_06_27_154699_create_fees_table',1),(29,'2023_06_27_154699_create_followups_table',1),(30,'2023_06_27_154699_create_tasks_table',1),(31,'2023_06_27_170717_create_category_translations_table',1),(32,'2023_06_27_170717_create_process_translations_table',1),(33,'2023_06_27_170717_create_product_translations_table',1),(34,'2023_06_27_170717_create_service_translations_table',1),(35,'2023_06_27_170717_create_testimonial_translations_table',1),(36,'2023_06_28_105000_create_files_table',1),(37,'2023_06_28_175347_create_faq_translations_table',1),(38,'2023_06_28_175550_create_setting_translations_table',1),(39,'2023_06_28_180004_create_gallery_translations_table',1),(40,'2023_06_28_180137_create_partner_translations_table',1),(41,'2023_06_28_180137_create_team_translations_table',1),(42,'2023_06_28_180243_create_page_translations_table',1),(43,'2023_06_28_180523_create_video_translations_table',1),(44,'2023_06_28_180559_create_counter_translations_table',1),(45,'2024_06_17_142322_create_complains_table',1),(46,'2024_06_17_143258_create_complain_translations_table',1),(47,'2024_06_19_070504_create_vaccancies_table',1),(48,'2024_06_20_090402_create_vaccancy_translations_table',1),(49,'2024_12_07_105246_add_hasphone_to_followups_table',2);
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
INSERT INTO `model_has_roles` VALUES (1,'App\\Models\\Admin',1),(1,'App\\Models\\Admin',2),(1,'App\\Models\\Admin',3),(2,'App\\Models\\Admin',5),(2,'App\\Models\\Admin',10),(2,'App\\Models\\Admin',11),(2,'App\\Models\\Admin',12),(2,'App\\Models\\Admin',13);
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
INSERT INTO `newsletters` VALUES (1,'ibrahimsamy308@gmail.com','2024-08-31 08:15:16','2024-08-31 08:15:16'),(2,'Kero@gmail.com','2024-08-31 08:15:16','2024-08-31 08:15:16'),(3,'ibrahim@gmail.com','2024-08-31 08:15:16','2024-08-31 08:15:16');
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
INSERT INTO `page_translations` VALUES (1,'إنشاء مواقع ويب للشركات الكبيرة و الصغيرة','أفضل حلول برمجة الويب','ً<p>نحن من ذوي الخبرة في إنشاء مواقع الويب التي يمكن أن تخدم أعمالك وتلبي جميع متطلباتك</p>',1,'ar','2024-08-31 08:15:16','2024-08-31 08:15:16'),(2,'Creating Websites for small and big businesses','Best Web Solutions','<p>We are experienced in creating websites that can serve your business and meet all your requirements</p>',1,'en','2024-08-31 08:15:16','2024-08-31 08:15:16'),(3,'معلومات عنا','نحن شركة برمجة مواقع ويب ','<p>مرحبًا بكم في شركة يوساب تك، الشركة الرائدة في مجال تطوير الويب والملتزمة بتقديم تجارب رقمية استثنائية. بفضل شغفنا بالإبداع والخبرة التقنية، نحن متخصصون في صياغة حلول الويب المخصصة التي تساعد الشركات على الازدهار في العالم الرقمي. في يوساب تك، نحن نفهم قوة موقع الويب المصمم جيدًا. إنها بمثابة واجهة متجر رقمية لعلامتك التجارية، حيث تربطك بجمهورك المستهدف وتدفع النمو. يعمل فريقنا من مطوري الويب والمصممين والاستراتيجيين الرقميين المهرة بشكل تعاوني لإنشاء مواقع ويب جذابة تركز على المستخدم وتترك انطباعًا دائمًا.</p>',2,'ar','2024-08-31 08:15:16','2024-08-31 08:15:16'),(4,'About US','We are a web development company.','<p>Welcome to Yousab Tech, a leading web development company committed to delivering exceptional digital experiences. With a passion for creativity and technical expertise, we specialize in crafting custom web solutions that help businesses thrive in the digital world. At Yousab Tech, we understand the power of a well-designed website. It serves as the digital storefront for your brand, connecting you with your target audience and driving growth. Our team of skilled web developers, designers, and digital strategists work collaboratively to create engaging, user-centric websites that leave a lasting impression.</p>',2,'en','2024-08-31 08:15:16','2024-08-31 08:15:16'),(5,'نحن نقدم أفضل حلول الويب',NULL,'<p>نحن نقدم مجموعة شاملة من خدمات تطوير الويب لمساعدة الشركات على تأسيس تواجد قوي عبر الإنترنت وتحقيق أهدافها الرقمية. مع فريق من المهنيين ذوي المهارات العالية، فإننا نجمع بين الإبداع والخبرة الفنية وأفضل ممارسات الصناعة لتقديم حلول ويب استثنائية. وهنا بعض من الخدمات التي نقدمها</p>',3,'ar','2024-08-31 08:15:16','2024-08-31 08:15:16'),(6,'We provide the best Web solutions',NULL,'<p>We offer a comprehensive range of web development services to help businesses   establish a strong online presence and achieve their digital goals. With a team of highly skilled professionals, we combine creativity, technical expertise, and industry best practices to deliver exceptional web solutions. Here are some of the services we provide</p>',3,'en','2024-08-31 08:15:16','2024-08-31 08:15:16'),(7,'سابقة اعمالنا ','سابقة الأعمال','<p>نحن نفخر بالمجموعة المتنوعة من المشاريع التي نجحنا في تسليمها لعملائنا. تعرض  سابقة اعمالنا خبرتنا في تطوير الويب والتصميم والحلول الرقمية</p>',4,'ar','2024-08-31 08:15:16','2024-08-31 08:15:16'),(8,'Our latest Portfolio for your choice','Portfolio Templates','<p>We take great pride in the diverse range of projects we have successfully delivered for our clients. Our portfolio showcases our expertise in web development, design, and digital solutions. Here are a few highlights</p>',4,'en','2024-08-31 08:15:16','2024-08-31 08:15:16'),(9,'كيف نعمل','آلية العمل','<p>تم تصميم الية العمل لدينا لإبقاء عملائنا مشاركين ومطلعين وراضين طوال كل مرحلة من مراحل المشروع. وفيما يلي نظرة عامة على عملية عملنا</p>',5,'ar','2024-08-31 08:15:16','2024-08-31 08:15:16'),(10,'How it works','Work Process','<p>Our work process is designed to keep our clients involved, informed, and satisfied throughout each stage of the project. Here\'s an overview of our work process</p>',5,'en','2024-08-31 08:15:16','2024-08-31 08:15:16'),(11,'اعرف المزيد عن حلول الويب لدينا','الأسئلة التي قد تتبادر إلى ذهنك','<p>إذا كان لديك المزيد من الأسئلة، نحن هنا للمساعدة! لا تتردد في الاتصال بنا، وسيكون فريقنا سعيدًا بتزويدك بمزيد من المعلومات ومعالجة أي مخاوف محددة قد تكون لديك</p>',6,'ar','2024-08-31 08:15:16','2024-08-31 08:15:16'),(12,'Know more about our web solutions','Questions that may come to your mind','<p>If you have more questions, We\'re here to help! Feel free to contact us, and our team will be happy to provide you with further information and address any specific concerns you may have</p>',6,'en','2024-08-31 08:15:16','2024-08-31 08:15:16'),(13,'لدينا مهارة مهنية','مهارة احترافية',NULL,7,'ar','2024-08-31 08:15:16','2024-08-31 08:15:16'),(14,'We have professional skilled','Professional Skill',NULL,7,'en','2024-08-31 08:15:16','2024-08-31 08:15:16'),(15,'فريق العمل','تعرف على فريق العمل','<p>لقد قمنا بتجميع فريق من المهنيين ذوي المهارات العالية والحماس الذين يكرسون جهودهم لتقديم حلول استثنائية لتطوير الويب</p>',8,'ar','2024-08-31 08:15:16','2024-08-31 08:15:16'),(16,'Expert Team','Meet with our expert','<p>we have assembled a team of highly skilled and passionate professionals who are dedicated to delivering exceptional web development solutions</p>',8,'en','2024-08-31 08:15:16','2024-08-31 08:15:16'),(17,'تواصل معنا ','ابقى على تواصل','<p>نحن نقدر التواصل المفتوح والشفاف مع عملائنا. سواء كان لديك سؤال، أو فكرة مشروع، أو ببساطة تريد معرفة المزيد حول خدمات تطوير الويب لدينا، فإن فريقنا موجود لمساعدتك</p>',9,'ar','2024-08-31 08:15:16','2024-08-31 08:15:16'),(18,'Contact','Get in touch','<p>We value open and transparent communication with our clients. Whether you have a question, a project idea, or simply want to learn more about our web development services, our team is here to assist you</p>',9,'en','2024-08-31 08:15:16','2024-08-31 08:15:16'),(19,'نحن هنا للإجابة على أسئلتك على مدار اليوم','تحتاج إلى خدمات الحل','<p>Dcidunt eget semper nec quam. Sed hendrerit. acfelis Nunc egestas augue atpellentesque laoreet</p>',10,'ar','2024-08-31 08:15:16','2024-08-31 08:15:16'),(20,'We are here to answer your questions 24/7','Need for it solution services','<p>Dcidunt eget semper nec quam. Sed hendrerit. acfelis Nunc egestas augue atpellentesque laoreet</p>',10,'en','2024-08-31 08:15:16','2024-08-31 08:15:16');
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
INSERT INTO `pages` VALUES (1,'home-banner','2024-08-31 08:15:16','2024-08-31 08:15:16'),(2,'about-us','2024-08-31 08:15:16','2024-08-31 08:15:16'),(3,'service-section','2024-08-31 08:15:16','2024-08-31 08:15:16'),(4,'portfolio-section','2024-08-31 08:15:16','2024-08-31 08:15:16'),(5,'process-section','2024-08-31 08:15:16','2024-08-31 08:15:16'),(6,'faq-section','2024-08-31 08:15:16','2024-08-31 08:15:16'),(7,'skills-section','2024-08-31 08:15:16','2024-08-31 08:15:16'),(8,'team-section','2024-08-31 08:15:16','2024-08-31 08:15:16'),(9,'contact-section','2024-08-31 08:15:16','2024-08-31 08:15:16'),(10,'solution-section','2024-08-31 08:15:16','2024-08-31 08:15:16');
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
INSERT INTO `partner_translations` VALUES (1,'SEO Mind',1,'ar','2024-08-31 08:15:17','2024-08-31 08:15:17'),(2,'SEO Mind',1,'en','2024-08-31 08:15:17','2024-08-31 08:15:17'),(3,'Boosterio',2,'ar','2024-08-31 08:15:17','2024-08-31 08:15:17'),(4,'Boosterio',2,'en','2024-08-31 08:15:17','2024-08-31 08:15:17'),(5,'Atomic SEO',3,'ar','2024-08-31 08:15:17','2024-08-31 08:15:17'),(6,'Atomic SEO',3,'en','2024-08-31 08:15:17','2024-08-31 08:15:17'),(7,'Green Host',4,'ar','2024-08-31 08:15:17','2024-08-31 08:15:17'),(8,'Green Host',4,'en','2024-08-31 08:15:17','2024-08-31 08:15:17');
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
INSERT INTO `partners` VALUES (1,'2024-08-31 08:15:17','2024-08-31 08:15:17'),(2,'2024-08-31 08:15:17','2024-08-31 08:15:17'),(3,'2024-08-31 08:15:17','2024-08-31 08:15:17'),(4,'2024-08-31 08:15:17','2024-08-31 08:15:17');
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
) ENGINE=InnoDB AUTO_INCREMENT=103 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `permissions`
--

LOCK TABLES `permissions` WRITE;
/*!40000 ALTER TABLE `permissions` DISABLE KEYS */;
INSERT INTO `permissions` VALUES (1,'role-list','admin','2024-12-06 19:57:07','2024-12-06 19:57:07'),(2,'role-create','admin','2024-12-06 19:57:07','2024-12-06 19:57:07'),(3,'role-edit','admin','2024-12-06 19:57:07','2024-12-06 19:57:07'),(4,'role-delete','admin','2024-12-06 19:57:07','2024-12-06 19:57:07'),(5,'product-list','admin','2024-12-06 19:57:07','2024-12-06 19:57:07'),(6,'product-create','admin','2024-12-06 19:57:07','2024-12-06 19:57:07'),(7,'product-edit','admin','2024-12-06 19:57:07','2024-12-06 19:57:07'),(8,'product-delete','admin','2024-12-06 19:57:07','2024-12-06 19:57:07'),(9,'faq-list','admin','2024-12-06 19:57:07','2024-12-06 19:57:07'),(10,'faq-create','admin','2024-12-06 19:57:07','2024-12-06 19:57:07'),(11,'faq-edit','admin','2024-12-06 19:57:07','2024-12-06 19:57:07'),(12,'faq-delete','admin','2024-12-06 19:57:07','2024-12-06 19:57:07'),(13,'complain-list','admin','2024-12-06 19:57:08','2024-12-06 19:57:08'),(14,'complain-create','admin','2024-12-06 19:57:08','2024-12-06 19:57:08'),(15,'complain-edit','admin','2024-12-06 19:57:08','2024-12-06 19:57:08'),(16,'complain-delete','admin','2024-12-06 19:57:08','2024-12-06 19:57:08'),(17,'vaccancy-list','admin','2024-12-06 19:57:08','2024-12-06 19:57:08'),(18,'vaccancy-create','admin','2024-12-06 19:57:08','2024-12-06 19:57:08'),(19,'vaccancy-edit','admin','2024-12-06 19:57:08','2024-12-06 19:57:08'),(20,'vaccancy-delete','admin','2024-12-06 19:57:08','2024-12-06 19:57:08'),(21,'counter-list','admin','2024-12-06 19:57:08','2024-12-06 19:57:08'),(22,'counter-create','admin','2024-12-06 19:57:08','2024-12-06 19:57:08'),(23,'counter-edit','admin','2024-12-06 19:57:08','2024-12-06 19:57:08'),(24,'counter-delete','admin','2024-12-06 19:57:08','2024-12-06 19:57:08'),(25,'contact-list','admin','2024-12-06 19:57:08','2024-12-06 19:57:08'),(26,'contact-create','admin','2024-12-06 19:57:08','2024-12-06 19:57:08'),(27,'contact-edit','admin','2024-12-06 19:57:08','2024-12-06 19:57:08'),(28,'contact-delete','admin','2024-12-06 19:57:08','2024-12-06 19:57:08'),(29,'image-list','admin','2024-12-06 19:57:08','2024-12-06 19:57:08'),(30,'image-create','admin','2024-12-06 19:57:08','2024-12-06 19:57:08'),(31,'image-edit','admin','2024-12-06 19:57:08','2024-12-06 19:57:08'),(32,'project-list','admin','2024-12-06 19:57:08','2024-12-06 19:57:08'),(33,'project-create','admin','2024-12-06 19:57:08','2024-12-06 19:57:08'),(34,'project-edit','admin','2024-12-06 19:57:08','2024-12-06 19:57:08'),(35,'project-delete','admin','2024-12-06 19:57:08','2024-12-06 19:57:08'),(36,'image-delete','admin','2024-12-06 19:57:08','2024-12-06 19:57:08'),(37,'task-list','admin','2024-12-06 19:57:08','2024-12-06 19:57:08'),(38,'task-create','admin','2024-12-06 19:57:08','2024-12-06 19:57:08'),(39,'task-edit','admin','2024-12-06 19:57:08','2024-12-06 19:57:08'),(40,'task-delete','admin','2024-12-06 19:57:08','2024-12-06 19:57:08'),(41,'page-list','admin','2024-12-06 19:57:08','2024-12-06 19:57:08'),(42,'page-create','admin','2024-12-06 19:57:08','2024-12-06 19:57:08'),(43,'page-edit','admin','2024-12-06 19:57:08','2024-12-06 19:57:08'),(44,'page-delete','admin','2024-12-06 19:57:08','2024-12-06 19:57:08'),(45,'followup-list','admin','2024-12-06 19:57:08','2024-12-06 19:57:08'),(46,'followup-create','admin','2024-12-06 19:57:08','2024-12-06 19:57:08'),(47,'followup-edit','admin','2024-12-06 19:57:08','2024-12-06 19:57:08'),(48,'followup-delete','admin','2024-12-06 19:57:08','2024-12-06 19:57:08'),(49,'fee-list','admin','2024-12-06 19:57:08','2024-12-06 19:57:08'),(50,'fee-create','admin','2024-12-06 19:57:08','2024-12-06 19:57:08'),(51,'fee-edit','admin','2024-12-06 19:57:08','2024-12-06 19:57:08'),(52,'fee-delete','admin','2024-12-06 19:57:08','2024-12-06 19:57:08'),(53,'portfolio-list','admin','2024-12-06 19:57:08','2024-12-06 19:57:08'),(54,'portfolio-create','admin','2024-12-06 19:57:08','2024-12-06 19:57:08'),(55,'portfolio-edit','admin','2024-12-06 19:57:08','2024-12-06 19:57:08'),(56,'portfolio-delete','admin','2024-12-06 19:57:08','2024-12-06 19:57:08'),(57,'service-list','admin','2024-12-06 19:57:08','2024-12-06 19:57:08'),(58,'service-create','admin','2024-12-06 19:57:08','2024-12-06 19:57:08'),(59,'service-edit','admin','2024-12-06 19:57:08','2024-12-06 19:57:08'),(60,'service-delete','admin','2024-12-06 19:57:08','2024-12-06 19:57:08'),(61,'testimonial-list','admin','2024-12-06 19:57:08','2024-12-06 19:57:08'),(62,'testimonial-create','admin','2024-12-06 19:57:08','2024-12-06 19:57:08'),(63,'testimonial-edit','admin','2024-12-06 19:57:08','2024-12-06 19:57:08'),(64,'testimonial-delete','admin','2024-12-06 19:57:08','2024-12-06 19:57:08'),(65,'category-list','admin','2024-12-06 19:57:08','2024-12-06 19:57:08'),(66,'category-create','admin','2024-12-06 19:57:08','2024-12-06 19:57:08'),(67,'category-edit','admin','2024-12-06 19:57:08','2024-12-06 19:57:08'),(68,'category-delete','admin','2024-12-06 19:57:08','2024-12-06 19:57:08'),(69,'process-list','admin','2024-12-06 19:57:08','2024-12-06 19:57:08'),(70,'process-create','admin','2024-12-06 19:57:08','2024-12-06 19:57:08'),(71,'process-edit','admin','2024-12-06 19:57:08','2024-12-06 19:57:08'),(72,'process-delete','admin','2024-12-06 19:57:08','2024-12-06 19:57:08'),(73,'setting-list','admin','2024-12-06 19:57:08','2024-12-06 19:57:08'),(74,'setting-create','admin','2024-12-06 19:57:08','2024-12-06 19:57:08'),(75,'setting-edit','admin','2024-12-06 19:57:08','2024-12-06 19:57:08'),(76,'setting-delete','admin','2024-12-06 19:57:08','2024-12-06 19:57:08'),(77,'partner-list','admin','2024-12-06 19:57:08','2024-12-06 19:57:08'),(78,'partner-create','admin','2024-12-06 19:57:08','2024-12-06 19:57:08'),(79,'partner-edit','admin','2024-12-06 19:57:08','2024-12-06 19:57:08'),(80,'partner-delete','admin','2024-12-06 19:57:08','2024-12-06 19:57:08'),(81,'team-list','admin','2024-12-06 19:57:08','2024-12-06 19:57:08'),(82,'team-create','admin','2024-12-06 19:57:08','2024-12-06 19:57:08'),(83,'team-edit','admin','2024-12-06 19:57:08','2024-12-06 19:57:08'),(84,'team-delete','admin','2024-12-06 19:57:08','2024-12-06 19:57:08'),(85,'video-list','admin','2024-12-06 19:57:08','2024-12-06 19:57:08'),(86,'video-create','admin','2024-12-06 19:57:08','2024-12-06 19:57:08'),(87,'video-edit','admin','2024-12-06 19:57:08','2024-12-06 19:57:08'),(88,'video-delete','admin','2024-12-06 19:57:08','2024-12-06 19:57:08'),(89,'user-list','admin','2024-12-06 19:57:08','2024-12-06 19:57:08'),(90,'user-create','admin','2024-12-06 19:57:08','2024-12-06 19:57:08'),(91,'user-edit','admin','2024-12-06 19:57:08','2024-12-06 19:57:08'),(92,'user-delete','admin','2024-12-06 19:57:08','2024-12-06 19:57:08'),(93,'admin-list','admin','2024-12-06 19:57:08','2024-12-06 19:57:08'),(94,'admin-create','admin','2024-12-06 19:57:08','2024-12-06 19:57:08'),(95,'admin-edit','admin','2024-12-06 19:57:08','2024-12-06 19:57:08'),(96,'admin-delete','admin','2024-12-06 19:57:08','2024-12-06 19:57:08'),(97,'message-list','admin','2024-12-06 19:57:08','2024-12-06 19:57:08'),(98,'message-delete','admin','2024-12-06 19:57:08','2024-12-06 19:57:08'),(99,'message-reply','admin','2024-12-06 19:57:08','2024-12-06 19:57:08'),(100,'newsletter-list','admin','2024-12-06 19:57:08','2024-12-06 19:57:08'),(101,'newsletter-delete','admin','2024-12-06 19:57:08','2024-12-06 19:57:08'),(102,'newsletter-reply','admin','2024-12-06 19:57:08','2024-12-06 19:57:08');
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
INSERT INTO `process_translations` VALUES (1,'حدد أهدافك ومتطلباتك:',NULL,'<p>حدد بوضوح أهدافك وغاياتك للموقع.</p>',1,'ar','2024-08-31 08:15:17','2024-08-31 08:15:17'),(2,'Define Your Goals and Requirements',NULL,'<p>Clearly identify your goals and objectives for the website.</p>',1,'en','2024-08-31 08:15:17','2024-08-31 08:15:17'),(3,'المشاورات الأولية',NULL,'<p>تواصل معنا للحصول على رسم توضيحي كامل لمناقشة أهداف مشروعك </p>',2,'ar','2024-08-31 08:15:17','2024-08-31 08:15:17'),(4,'Initial Consultation',NULL,'<p>Connect with us to have a full illustration to discuss your project goals </p>',2,'en','2024-08-31 08:15:17','2024-08-31 08:15:17'),(5,'الاقتراح والاتفاق',NULL,'<p>سنزودك بمقترح يوضح نطاق المشروع والجدول الزمني والتكلفة.</p>',3,'ar','2024-08-31 08:15:17','2024-08-31 08:15:17'),(6,'Proposal and Agreement',NULL,'<p>we will provide you with a proposal that outlines the project scope, timeline, and cost.</p>',3,'en','2024-08-31 08:15:17','2024-08-31 08:15:17'),(7,'تنفيذ وتسليم الموقع',NULL,'<p>مراجعة الموقع وتسليمه للعميل بمجرد رضاه عن المخرجات.</p>',4,'ar','2024-08-31 08:15:17','2024-08-31 08:15:17'),(8,'Executing and Delivering',NULL,'<p>reviewing the website and deliver it to client once he is satisfied with the output. </p>',4,'en','2024-08-31 08:15:17','2024-08-31 08:15:17');
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
INSERT INTO `processes` VALUES (1,'2024-08-31 08:15:17','2024-08-31 08:15:17'),(2,'2024-08-31 08:15:17','2024-08-31 08:15:17'),(3,'2024-08-31 08:15:17','2024-08-31 08:15:17'),(4,'2024-08-31 08:15:17','2024-08-31 08:15:17');
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
INSERT INTO `product_translations` VALUES (1,'انشاء مواقع الويب',NULL,'<p>نحن متخصصون في إنشاء مواقع ويب مخصصة تناسب احتياجات عملك المحددة. يعمل فريقنا من المطورين والمصممين ذوي الخبرة بشكل وثيق معك لفهم متطلباتك وتطوير موقع ويب يعكس هوية علامتك التجارية. نحن نستفيد من أحدث تقنيات الويب ومبادئ التصميم سريع الاستجابة لضمان أن يبدو موقع الويب الخاص بك مذهلاً ويعمل بشكل لا تشوبه شائبة عبر الأجهزة وبالاضافه الى لوحة تحكم لنجعلك قادر على التحكم فى جميع محتويات الموقع  </p>',1,'ar','2024-08-31 08:15:17','2024-08-31 08:15:17'),(2,'Custom Website Development',NULL,'<p>We specialize in creating custom websites that fit your specific business needs. Our team of experienced developers and designers work closely with you to understand your requirements and develop a website that reflects your brand identity. We take advantage of the latest web technologies and responsive design principles to ensure that your website looks amazing and works flawlessly across devices and in addition to a control panel to make you able to control all     site content</p>',1,'en','2024-08-31 08:15:17','2024-08-31 08:15:17'),(3,'انشاء مواقع تجارة الكترونية',NULL,'<p>إذا كنت تتطلع إلى بيع منتجات أو خدمات عبر الإنترنت، فيمكن أن تساعدك خدمات تطوير التجارة الإلكترونية لدينا. لدينا خبرة في بناء منصات تجارة إلكترونية آمنة وقابلة للتطوير توفر تجارب مستخدم سلسة وتكاملًا قويًا للدفع. بدءًا من كتالوجات المنتجات وعربات التسوق وحتى إدارة المخزون ومعالجة الطلبات، نقوم بإنشاء حلول للتجارة الإلكترونية تعمل على زيادة التحويلات وزيادة الإيرادات إلى أقصى حد</p>',2,'ar','2024-08-31 08:15:17','2024-08-31 08:15:17'),(4,'E-commerce Development',NULL,'<p>If you\'re looking to sell products or products online, our e-commerce development products can help. We have expertise in building secure and scalable e-commerce platforms that offer seamless user experiences and robust payment integration. From product catalogs and shopping carts to inventory management and order processing, we create e-commerce solutions that drive conversions and maximize revenue</p>',2,'en','2024-08-31 08:15:17','2024-08-31 08:15:17'),(5,'صيانة ودعم الموقع',NULL,'<p>نحن نؤمن بالشراكات طويلة الأمد مع عملائنا. تضمن خدمات صيانة ودعم موقع الويب لدينا بقاء موقع الويب الخاص بك آمنًا وحديثًا ومحسّنًا للأداء. نحن نقدم تحديثات منتظمة وتصحيحات أمنية ونسخًا احتياطية لحماية موقع الويب الخاص بك من نقاط الضعف. فريق الدعم لدينا متاح لمعالجة أية مشكلات والإجابة على الأسئلة وتقديم المساعدة الفنية المستمرة</p>',3,'ar','2024-08-31 08:15:17','2024-08-31 08:15:17'),(6,'Website Maintenance and Support',NULL,'<p>We believe in long-term partnerships with our clients. Our website maintenance and support products ensure that your website remains secure, up-to-date, and optimized for performance. We provide regular updates, security patches, and backups to protect your website from vulnerabilities. Our support team is available to address any issues, answer questions, and provide ongoing technical assistance </p>',3,'en','2024-08-31 08:15:17','2024-08-31 08:15:17'),(7,'استضافت مواقع ',NULL,'<p>في شركة تطوير الويب لدينا، نقدم خدمات استضافة شاملة للتأكد من أن موقع الويب الخاص بك يعمل على النحو الأمثل ويظل في متناول زوار موقعك. توفر خدمة الاستضافة لدينا بيئة موثوقة وآمنة لازدهار موقع الويب الخاص بك. فيما يلي نظرة عامة على خدمة الاستضافة لدينا:\r\n\r\nبنية تحتية موثوقة للاستضافة: نحن نحافظ على بنية تحتية قوية للاستضافة مع خوادم ومعدات شبكات حديثة. تم تحسين خوادمنا من أجل الأداء، مما يوفر أوقات تحميل سريعة وأقل وقت توقف. نحن نعطي الأولوية للموثوقية للتأكد من أن موقع الويب الخاص بك في متناول الزوار على مدار الساعة.\r\n\r\nحلول قابلة للتطوير: تم تصميم خدمة الاستضافة لدينا لاستيعاب نمو موقع الويب الخاص بك. سواء كان لديك موقع ويب خاص بشركة صغيرة أو تطبيق ويب معقد، فإننا نقدم حلول استضافة قابلة للتطوير يمكنها التكيف مع احتياجاتك المتغيرة. مع توسع موقع الويب الخاص بك، يمكننا بسهولة زيادة موارد الاستضافة للتعامل مع زيادة حركة المرور ومتطلبات البيانات.\r\n\r\nالتدابير الأمنية: نحن نعطي الأولوية لأمن موقع الويب الخاص بك والبيانات التي يحتوي عليها. تتضمن خدمة الاستضافة لدينا إجراءات أمنية قوية مثل جدران الحماية، وأنظمة كشف التسلل، والتحديثات الأمنية المنتظمة. نقوم أيضًا بتنفيذ شهادات SSL لتشفير نقل البيانات وحماية المعلومات الحساسة وبناء الثقة مع زوار موقعك.\r\n\r\nالنسخ الاحتياطي والتعافي من الكوارث: نحن ندرك أهمية حماية البيانات. تتضمن خدمة الاستضافة لدينا نسخًا احتياطية منتظمة لموقعك على الويب والبيانات المرتبطة به. في حالة وجود مشكلة فنية أو حدث غير متوقع، يمكننا استعادة موقع الويب الخاص بك بسرعة لتقليل وقت التوقف عن العمل وفقدان البيانات.\r\n\r\nالدعم الفني: فريق الدعم المخصص لدينا متاح لمساعدتك في أي مخاوف أو مشكلات فنية متعلقة بالاستضافة. سواء كانت لديك أسئلة حول تكوينات الخادم، أو كنت بحاجة إلى مساعدة بشأن إعدادات DNS، أو كنت بحاجة إلى استكشاف الأخطاء وإصلاحها، فإن موظفي الدعم ذوي المعرفة لدينا ليسوا سوى مكالمة هاتفية أو بريد إلكتروني.\r\n\r\nالتوافق مع تقنيات الويب: تدعم خدمة الاستضافة لدينا مجموعة واسعة من تقنيات الويب ولغات البرمجة. سواء تم إنشاء موقع الويب الخاص بك باستخدام PHP أو Python أو Node.js أو أطر عمل أخرى، يمكن لبيئة الاستضافة لدينا أن تلبي متطلباتك المحددة.\r\n\r\nشبكة تسليم المحتوى (CDN): لتحسين أداء موقع الويب الخاص بك، يمكننا دمج شبكة تسليم المحتوى (CDN) في خدمة الاستضافة لدينا. تساعد شبكة CDN على تقديم محتوى موقع الويب الخاص بك بسرعة للزائرين من مواقع جغرافية مختلفة، مما يحسن أوقات التحميل وتجربة المستخدم.\r\n\r\nاستضافة البريد الإلكتروني: إلى جانب استضافة مواقع الويب، نقدم أيضًا خدمات استضافة البريد الإلكتروني. يمكنك الحصول على عناوين بريد إلكتروني احترافية مرتبطة باسم النطاق الخاص بك، مما يوفر تجربة اتصال سلسة وموحدة لشركتك. </p>',4,'ar','2024-08-31 08:15:17','2024-08-31 08:15:17'),(8,'Website Hosting',NULL,'<p>At our web development company, we offer comprehensive hosting products to ensure that your website performs optimally and remains accessible to your visitors. Our hosting product provides a reliable and secure environment for your website to thrive. Here\'s an overview of our hosting product:\r\n\r\n                                Reliable Hosting Infrastructure: We maintain a robust hosting infrastructure with state-of-the-art servers and network equipment. Our servers are optimized for performance, offering fast load times and minimal downtime. We prioritize reliability to ensure that your website is accessible to visitors around the clock.\r\n                                \r\n                                Scalable Solutions: Our hosting product is designed to accommodate your website\'s growth. Whether you have a small business website or a complex web application, we offer scalable hosting solutions that can adapt to your changing needs. As your website expands, we can seamlessly scale up the hosting resources to handle increased traffic and data requirements.\r\n                                \r\n                                Security Measures: We prioritize the security of your website and the data it contains. Our hosting product includes robust security measures such as firewalls, intrusion detection systems, and regular security updates. We also implement SSL certificates to encrypt data transmission, safeguarding sensitive information and building trust with your visitors.\r\n                                \r\n                                Backup and Disaster Recovery: We understand the importance of data protection. Our hosting product includes regular backups of your website and its associated data. In the event of a technical issue or unexpected event, we can quickly restore your website to minimize downtime and data loss.\r\n                                \r\n                                Technical Support: Our dedicated support team is available to assist you with any hosting-related concerns or technical issues. Whether you have questions about server configurations, need assistance with DNS settings, or require troubleshooting, our knowledgeable support staff is just a phone call or email away.\r\n                                \r\n                                Compatibility with Web Technologies: Our hosting product supports a wide range of web technologies and programming languages. Whether your website is built with PHP, Python, Node.js, or other frameworks, our hosting environment can accommodate your specific requirements.\r\n                                \r\n                                Content Delivery Network (CDN): To enhance the performance of your website, we can integrate a Content Delivery Network (CDN) into our hosting product. A CDN helps deliver your website content quickly to visitors from various geographical locations, improving load times and user experience.\r\n                                \r\n                                Email Hosting: Along with website hosting, we also offer email hosting products. You can have professional email addresses associated with your domain name, providing a seamless and unified communication experience for your business.\r\n                                \r\n                                 </p>',4,'en','2024-08-31 08:15:17','2024-08-31 08:15:17');
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
INSERT INTO `products` VALUES (1,'far fa-window-restore','2024-08-31 08:15:17','2024-08-31 08:15:17'),(2,'fas fa-shopping-cart','2024-08-31 08:15:17','2024-08-31 08:15:17'),(3,'fas fa-cog','2024-08-31 08:15:17','2024-08-31 08:15:17'),(4,'fab fa-ioxhost','2024-08-31 08:15:17','2024-08-31 08:15:17');
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
) ENGINE=InnoDB AUTO_INCREMENT=57 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `projects`
--

LOCK TABLES `projects` WRITE;
/*!40000 ALTER TABLE `projects` DISABLE KEYS */;
INSERT INTO `projects` VALUES (3,'Aljazira',1,5000,NULL,'2024-09-28 05:30:05'),(4,'Asl Eltawfeer',1,15990,NULL,NULL),(5,'Automation',1,0,NULL,NULL),(6,'Boula Nessim',1,0,NULL,NULL),(7,'Celine',1,6000,NULL,NULL),(9,'dreem',1,2500,NULL,NULL),(10,'Egypt Tourism',1,5000,NULL,NULL),(11,'Elalamia Gaming...',1,5000,NULL,NULL),(12,'Elmandra',1,13000,NULL,NULL),(13,'Elmesbaat',1,6000,NULL,NULL),(14,'Elmesbaat image...',1,2000,NULL,NULL),(15,'Emad App',1,0,NULL,NULL),(16,'Emad Website',1,0,NULL,NULL),(17,'Eman',1,0,NULL,NULL),(18,'Eman Cables e-c...',1,0,NULL,NULL),(19,'Eman Mangement...',1,0,NULL,NULL),(20,'ERP system',1,12000,NULL,'2024-11-11 07:28:54'),(21,'eva',1,4000,NULL,NULL),(23,'Ghaz Masr',1,6000,NULL,NULL),(24,'Google Ads',1,0,NULL,NULL),(25,'Haddak Elfayrou...',1,6000,NULL,NULL),(26,'Harmony',1,4000,NULL,NULL),(27,'Instadoctorz',1,0,NULL,NULL),(28,'Jaiden',1,16000,NULL,NULL),(29,'Kareem',1,0,NULL,NULL),(31,'Logat Elasr Mob...',1,10000,NULL,NULL),(32,'Logat Elasr Web...',1,13000,NULL,NULL),(33,'Maher',1,0,NULL,NULL),(34,'Melad Youssef',1,0,NULL,NULL),(35,'Orthodox News',1,7500,NULL,NULL),(36,'Osama',1,0,NULL,NULL),(37,'Payment Gateway...',1,1000,NULL,NULL),(38,'Real Estate (OL...',1,0,NULL,NULL),(39,'Reservya Compan...',1,15000,NULL,NULL),(40,'Reservya Mobile...',1,10000,NULL,NULL),(41,'Reservya Web',1,25000,NULL,NULL),(42,'SoulPharma',1,7000,NULL,NULL),(43,'speed services',1,0,NULL,NULL),(44,'Tadawy',1,6000,NULL,NULL),(45,'Tasks and Auto',1,0,NULL,NULL),(46,'Templates',1,0,NULL,NULL),(47,'unihome',1,3700,NULL,NULL),(48,'Vega',1,3000,NULL,NULL),(49,'Vera Design',1,2000,NULL,NULL),(50,'Video Courses A...',1,0,NULL,NULL),(51,'World Sports',1,10000,NULL,NULL),(52,'Yousab Tech',1,0,NULL,NULL),(53,'Herpal Website',1,9000,'2024-10-08 01:35:43','2024-10-08 01:35:43'),(55,'Aloo',1,0,'2024-10-16 14:14:48','2024-10-16 14:14:48'),(56,'Solution Gates',1,5000,'2024-10-22 15:28:51','2024-11-03 15:33:38');
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
INSERT INTO `role_has_permissions` VALUES (1,1),(2,1),(3,1),(4,1),(32,1),(33,1),(34,1),(35,1),(37,1),(38,1),(39,1),(40,1),(45,1),(46,1),(47,1),(48,1),(49,1),(50,1),(51,1),(52,1),(69,1),(70,1),(71,1),(72,1),(81,1),(82,1),(83,1),(84,1),(89,1),(90,1),(91,1),(92,1),(93,1),(94,1),(95,1),(96,1),(37,2),(38,2),(39,2),(40,2),(45,2),(46,2),(47,2),(48,2);
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
INSERT INTO `roles` VALUES (1,'Admin','admin','2024-08-31 08:15:17','2024-08-31 08:15:17'),(2,'Employee','admin','2024-08-31 08:15:17','2024-08-31 08:15:17');
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
INSERT INTO `service_translations` VALUES (1,'انشاء مواقع الويب',NULL,'<p>نحن متخصصون في إنشاء مواقع ويب مخصصة تناسب احتياجات عملك المحددة. يعمل فريقنا من المطورين والمصممين ذوي الخبرة بشكل وثيق معك لفهم متطلباتك وتطوير موقع ويب يعكس هوية علامتك التجارية. نحن نستفيد من أحدث تقنيات الويب ومبادئ التصميم سريع الاستجابة لضمان أن يبدو موقع الويب الخاص بك مذهلاً ويعمل بشكل لا تشوبه شائبة عبر الأجهزة وبالاضافه الى لوحة تحكم لنجعلك قادر على التحكم فى جميع محتويات الموقع  </p>',1,'ar','2024-08-31 08:15:17','2024-08-31 08:15:17'),(2,'Custom Website Development',NULL,'<p>We specialize in creating custom websites that fit your specific business needs. Our team of experienced developers and designers work closely with you to understand your requirements and develop a website that reflects your brand identity. We take advantage of the latest web technologies and responsive design principles to ensure that your website looks amazing and works flawlessly across devices and in addition to a control panel to make you able to control all     site content</p>',1,'en','2024-08-31 08:15:17','2024-08-31 08:15:17'),(3,'انشاء مواقع تجارة الكترونية',NULL,'<p>إذا كنت تتطلع إلى بيع منتجات أو خدمات عبر الإنترنت، فيمكن أن تساعدك خدمات تطوير التجارة الإلكترونية لدينا. لدينا خبرة في بناء منصات تجارة إلكترونية آمنة وقابلة للتطوير توفر تجارب مستخدم سلسة وتكاملًا قويًا للدفع. بدءًا من كتالوجات المنتجات وعربات التسوق وحتى إدارة المخزون ومعالجة الطلبات، نقوم بإنشاء حلول للتجارة الإلكترونية تعمل على زيادة التحويلات وزيادة الإيرادات إلى أقصى حد</p>',2,'ar','2024-08-31 08:15:17','2024-08-31 08:15:17'),(4,'E-commerce Development',NULL,'<p>If you\'re looking to sell products or services online, our e-commerce development services can help. We have expertise in building secure and scalable e-commerce platforms that offer seamless user experiences and robust payment integration. From product catalogs and shopping carts to inventory management and order processing, we create e-commerce solutions that drive conversions and maximize revenue</p>',2,'en','2024-08-31 08:15:17','2024-08-31 08:15:17'),(5,'صيانة ودعم الموقع',NULL,'<p>نحن نؤمن بالشراكات طويلة الأمد مع عملائنا. تضمن خدمات صيانة ودعم موقع الويب لدينا بقاء موقع الويب الخاص بك آمنًا وحديثًا ومحسّنًا للأداء. نحن نقدم تحديثات منتظمة وتصحيحات أمنية ونسخًا احتياطية لحماية موقع الويب الخاص بك من نقاط الضعف. فريق الدعم لدينا متاح لمعالجة أية مشكلات والإجابة على الأسئلة وتقديم المساعدة الفنية المستمرة</p>',3,'ar','2024-08-31 08:15:17','2024-08-31 08:15:17'),(6,'Website Maintenance and Support',NULL,'<p>We believe in long-term partnerships with our clients. Our website maintenance and support services ensure that your website remains secure, up-to-date, and optimized for performance. We provide regular updates, security patches, and backups to protect your website from vulnerabilities. Our support team is available to address any issues, answer questions, and provide ongoing technical assistance </p>',3,'en','2024-08-31 08:15:17','2024-08-31 08:15:17'),(7,'استضافت مواقع ',NULL,'<p>في شركة تطوير الويب لدينا، نقدم خدمات استضافة شاملة للتأكد من أن موقع الويب الخاص بك يعمل على النحو الأمثل ويظل في متناول زوار موقعك. توفر خدمة الاستضافة لدينا بيئة موثوقة وآمنة لازدهار موقع الويب الخاص بك. فيما يلي نظرة عامة على خدمة الاستضافة لدينا:\r\n\r\nبنية تحتية موثوقة للاستضافة: نحن نحافظ على بنية تحتية قوية للاستضافة مع خوادم ومعدات شبكات حديثة. تم تحسين خوادمنا من أجل الأداء، مما يوفر أوقات تحميل سريعة وأقل وقت توقف. نحن نعطي الأولوية للموثوقية للتأكد من أن موقع الويب الخاص بك في متناول الزوار على مدار الساعة.\r\n\r\nحلول قابلة للتطوير: تم تصميم خدمة الاستضافة لدينا لاستيعاب نمو موقع الويب الخاص بك. سواء كان لديك موقع ويب خاص بشركة صغيرة أو تطبيق ويب معقد، فإننا نقدم حلول استضافة قابلة للتطوير يمكنها التكيف مع احتياجاتك المتغيرة. مع توسع موقع الويب الخاص بك، يمكننا بسهولة زيادة موارد الاستضافة للتعامل مع زيادة حركة المرور ومتطلبات البيانات.\r\n\r\nالتدابير الأمنية: نحن نعطي الأولوية لأمن موقع الويب الخاص بك والبيانات التي يحتوي عليها. تتضمن خدمة الاستضافة لدينا إجراءات أمنية قوية مثل جدران الحماية، وأنظمة كشف التسلل، والتحديثات الأمنية المنتظمة. نقوم أيضًا بتنفيذ شهادات SSL لتشفير نقل البيانات وحماية المعلومات الحساسة وبناء الثقة مع زوار موقعك.\r\n\r\nالنسخ الاحتياطي والتعافي من الكوارث: نحن ندرك أهمية حماية البيانات. تتضمن خدمة الاستضافة لدينا نسخًا احتياطية منتظمة لموقعك على الويب والبيانات المرتبطة به. في حالة وجود مشكلة فنية أو حدث غير متوقع، يمكننا استعادة موقع الويب الخاص بك بسرعة لتقليل وقت التوقف عن العمل وفقدان البيانات.\r\n\r\nالدعم الفني: فريق الدعم المخصص لدينا متاح لمساعدتك في أي مخاوف أو مشكلات فنية متعلقة بالاستضافة. سواء كانت لديك أسئلة حول تكوينات الخادم، أو كنت بحاجة إلى مساعدة بشأن إعدادات DNS، أو كنت بحاجة إلى استكشاف الأخطاء وإصلاحها، فإن موظفي الدعم ذوي المعرفة لدينا ليسوا سوى مكالمة هاتفية أو بريد إلكتروني.\r\n\r\nالتوافق مع تقنيات الويب: تدعم خدمة الاستضافة لدينا مجموعة واسعة من تقنيات الويب ولغات البرمجة. سواء تم إنشاء موقع الويب الخاص بك باستخدام PHP أو Python أو Node.js أو أطر عمل أخرى، يمكن لبيئة الاستضافة لدينا أن تلبي متطلباتك المحددة.\r\n\r\nشبكة تسليم المحتوى (CDN): لتحسين أداء موقع الويب الخاص بك، يمكننا دمج شبكة تسليم المحتوى (CDN) في خدمة الاستضافة لدينا. تساعد شبكة CDN على تقديم محتوى موقع الويب الخاص بك بسرعة للزائرين من مواقع جغرافية مختلفة، مما يحسن أوقات التحميل وتجربة المستخدم.\r\n\r\nاستضافة البريد الإلكتروني: إلى جانب استضافة مواقع الويب، نقدم أيضًا خدمات استضافة البريد الإلكتروني. يمكنك الحصول على عناوين بريد إلكتروني احترافية مرتبطة باسم النطاق الخاص بك، مما يوفر تجربة اتصال سلسة وموحدة لشركتك. </p>',4,'ar','2024-08-31 08:15:17','2024-08-31 08:15:17'),(8,'Website Hosting',NULL,'<p>At our web development company, we offer comprehensive hosting services to ensure that your website performs optimally and remains accessible to your visitors. Our hosting service provides a reliable and secure environment for your website to thrive. Here\'s an overview of our hosting service:\r\n\r\n                                Reliable Hosting Infrastructure: We maintain a robust hosting infrastructure with state-of-the-art servers and network equipment. Our servers are optimized for performance, offering fast load times and minimal downtime. We prioritize reliability to ensure that your website is accessible to visitors around the clock.\r\n                                \r\n                                Scalable Solutions: Our hosting service is designed to accommodate your website\'s growth. Whether you have a small business website or a complex web application, we offer scalable hosting solutions that can adapt to your changing needs. As your website expands, we can seamlessly scale up the hosting resources to handle increased traffic and data requirements.\r\n                                \r\n                                Security Measures: We prioritize the security of your website and the data it contains. Our hosting service includes robust security measures such as firewalls, intrusion detection systems, and regular security updates. We also implement SSL certificates to encrypt data transmission, safeguarding sensitive information and building trust with your visitors.\r\n                                \r\n                                Backup and Disaster Recovery: We understand the importance of data protection. Our hosting service includes regular backups of your website and its associated data. In the event of a technical issue or unexpected event, we can quickly restore your website to minimize downtime and data loss.\r\n                                \r\n                                Technical Support: Our dedicated support team is available to assist you with any hosting-related concerns or technical issues. Whether you have questions about server configurations, need assistance with DNS settings, or require troubleshooting, our knowledgeable support staff is just a phone call or email away.\r\n                                \r\n                                Compatibility with Web Technologies: Our hosting service supports a wide range of web technologies and programming languages. Whether your website is built with PHP, Python, Node.js, or other frameworks, our hosting environment can accommodate your specific requirements.\r\n                                \r\n                                Content Delivery Network (CDN): To enhance the performance of your website, we can integrate a Content Delivery Network (CDN) into our hosting service. A CDN helps deliver your website content quickly to visitors from various geographical locations, improving load times and user experience.\r\n                                \r\n                                Email Hosting: Along with website hosting, we also offer email hosting services. You can have professional email addresses associated with your domain name, providing a seamless and unified communication experience for your business.\r\n                                \r\n                                 </p>',4,'en','2024-08-31 08:15:17','2024-08-31 08:15:17');
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
INSERT INTO `services` VALUES (1,'far fa-window-restore','2024-08-31 08:15:17','2024-08-31 08:15:17'),(2,'fas fa-shopping-cart','2024-08-31 08:15:17','2024-08-31 08:15:17'),(3,'fas fa-cog','2024-08-31 08:15:17','2024-08-31 08:15:17'),(4,'fab fa-ioxhost','2024-08-31 08:15:17','2024-08-31 08:15:17');
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
INSERT INTO `setting_translations` VALUES (1,'Online','Yousab Tech','We are a web development company specialized in creating, fixing and mangaing websites using latest technologies and web services',': 24/7','Copyright reserved by Yousab Tech © 2024','Web Development Company',1,'en','2024-08-31 08:15:17','2024-08-31 08:15:17'),(2,'عبر الانترنت','يوساب تك','نحن شركة تطوير لمواقع الويب متخصصون في انشاء,صيانة وادارة مواقع الويب',': 24/7','جميع الحقوق محفوظة لدي يوساب تك © 2023','شركة خدمات ويب',1,'ar','2024-08-31 08:15:17','2024-08-31 08:27:02');
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
INSERT INTO `settings` VALUES (1,'images/xvTLss2FRKaFg0mwU5qtukmQVhMxFKBVqQxVv4JL.png','images/M8wYYa6zQnLin0iqw5wsCbXELXeJcY9duAPAcstX.png','images/V6EupaXIUSDRmVR4kazZXNgORRj3Lipp0muJnHci.png','image','<iframe src=\"https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d55275.18948853619!2d31.18964315!3d30.016788299999998!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x1458469235579697%3A0x4e91d61f9878fc52!2sGiza%2C%20El%20Omraniya%2C%20Giza%20Governorate!5e0!3m2!1sen!2seg!4v1695471231297!5m2!1sen!2seg\" width=\"600\" height=\"450\" style=\"border:0;\" allowfullscreen=\"\" loading=\"lazy\" referrerpolicy=\"no-referrer-when-downgrade\"></iframe>','2024-08-31 08:15:17','2024-08-31 08:27:02');
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
  `title` longtext COLLATE utf8mb4_unicode_ci,
  `keywords` longtext COLLATE utf8mb4_unicode_ci,
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
) ENGINE=InnoDB AUTO_INCREMENT=1237 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tasks`
--

LOCK TABLES `tasks` WRITE;
/*!40000 ALTER TABLE `tasks` DISABLE KEYS */;
INSERT INTO `tasks` VALUES (41,'add shipping details and other additional costs to bill total',NULL,1,3,20,'2024-08-31 13:42:27','2024-10-21 21:07:12'),(42,'change logo',NULL,1,1,47,'2024-08-31 16:32:28','2024-09-03 01:31:24'),(43,'change logo',NULL,1,2,47,'2024-08-31 16:32:28','2024-09-03 01:31:24'),(44,'change logo',NULL,1,3,47,'2024-08-31 16:32:28','2024-09-03 01:31:24'),(45,'add title to products',NULL,1,1,47,'2024-08-31 16:32:28','2024-08-31 17:26:41'),(46,'add title to products',NULL,1,2,47,'2024-08-31 16:32:28','2024-08-31 17:26:41'),(47,'add title to products',NULL,1,3,47,'2024-08-31 16:32:28','2024-08-31 17:26:41'),(48,'remove images',NULL,1,1,47,'2024-08-31 16:32:28','2024-08-31 17:26:41'),(49,'remove images',NULL,1,1,47,'2024-08-31 16:32:28','2024-08-31 17:26:41'),(50,'remove images',NULL,1,3,47,'2024-08-31 16:32:28','2024-08-31 17:26:41'),(51,'api for products',NULL,1,3,41,'2024-08-31 16:37:13','2024-08-31 17:23:27'),(59,' add levels module with title type(standard none standard) benefits',NULL,1,3,41,'2024-08-31 17:13:22','2024-09-04 04:00:29'),(60,' add levels module with title type(standard none standard) benefits',NULL,1,3,41,'2024-08-31 17:13:22','2024-09-04 04:00:29'),(61,' add levels module with title type(standard none standard) benefits',NULL,1,3,41,'2024-08-31 17:13:22','2024-09-04 04:00:29'),(62,' change $ to EGP',NULL,1,3,41,'2024-08-31 17:23:00','2024-09-02 18:14:11'),(63,' change $ to EGP',NULL,1,3,41,'2024-08-31 17:23:00','2024-09-02 18:14:11'),(64,' change $ to EGP',NULL,1,3,41,'2024-08-31 17:23:00','2024-09-02 18:14:11'),(83,' subscrip strict cors origin working but need to reload and there is no toastr',NULL,1,1,41,'2024-08-31 17:30:37','2024-09-04 03:58:32'),(84,' subscrip strict cors origin working but need to reload and there is no toastr',NULL,1,1,41,'2024-08-31 17:30:37','2024-09-04 03:58:32'),(85,' subscrip strict cors origin working but need to reload and there is no toastr',NULL,1,1,41,'2024-08-31 17:30:37','2024-09-04 03:58:32'),(89,'purchase ph must be percentage',NULL,1,1,20,'2024-08-31 17:44:50','2024-09-16 22:57:15'),(90,'purchase ph must be percentage',NULL,1,3,20,'2024-08-31 17:44:50','2024-09-16 22:57:15'),(91,'product transfer need to update',NULL,1,1,20,'2024-08-31 17:44:50','2024-09-01 03:03:46'),(92,'product transfer need to update',NULL,1,3,20,'2024-08-31 17:44:50','2024-09-01 03:03:46'),(93,'products count in branches',NULL,1,1,20,'2024-08-31 17:44:50','2024-09-02 19:32:24'),(94,'products count in branches',NULL,1,3,20,'2024-08-31 17:44:50','2024-09-02 19:32:24'),(95,'when delete must do the opposite in producttransfer',NULL,1,1,20,'2024-08-31 17:44:50','2024-09-02 23:21:19'),(96,'when delete must do the opposite in producttransfer',NULL,1,3,20,'2024-08-31 17:44:50','2024-09-02 23:21:19'),(97,'damageproduct ajax issuesame as producttransfer',NULL,1,1,20,'2024-08-31 17:44:50','2024-09-02 19:02:35'),(98,'damageproduct ajax issuesame as producttransfer',NULL,1,3,20,'2024-08-31 17:44:50','2024-09-02 19:02:35'),(99,'show price in producttransfer',NULL,1,1,20,'2024-08-31 17:44:50','2024-09-02 19:02:11'),(100,'show price in producttransfer',NULL,1,3,20,'2024-08-31 17:44:50','2024-09-02 19:02:11'),(101,'enable permissions in admin',NULL,1,1,20,'2024-08-31 17:44:50','2024-09-02 23:22:58'),(102,'enable permissions in admin',NULL,1,3,20,'2024-08-31 17:44:50','2024-09-02 23:22:58'),(103,'',NULL,1,1,20,'2024-08-31 17:44:50','2024-12-07 05:06:30'),(104,'',NULL,1,3,20,'2024-08-31 17:44:50','2024-12-07 05:06:30'),(105,'handle google ad',NULL,1,1,5,'2024-08-31 17:49:21','2024-09-16 22:57:15'),(106,'supervise google ad',NULL,1,1,28,'2024-08-31 17:49:43','2024-09-16 22:57:15'),(107,'make the website resbonsive',NULL,1,1,48,'2024-08-31 17:51:35','2024-09-16 22:57:15'),(108,'have meeting with client',NULL,1,1,26,'2024-08-31 17:51:56','2024-10-08 22:22:06'),(109,'have meeting with client',NULL,1,3,26,'2024-08-31 17:51:56','2024-10-08 22:22:06'),(112,'fix resbonsive',NULL,1,1,44,'2024-08-31 17:53:03','2024-09-02 00:21:10'),(113,'fix resbonsive',NULL,1,2,44,'2024-08-31 17:53:03','2024-09-02 00:21:10'),(116,'revise appli8cation to complete it',NULL,1,1,28,'2024-08-31 17:53:36','2024-10-16 05:50:51'),(117,'revise appli8cation to complete it',NULL,1,3,28,'2024-08-31 17:53:36','2024-10-16 05:50:51'),(118,'fix design',NULL,1,1,51,'2024-08-31 17:54:25','2024-09-07 23:22:30'),(119,'fix design',NULL,1,2,51,'2024-08-31 17:54:25','2024-09-07 23:22:30'),(124,'add quiz',NULL,1,1,47,'2024-08-31 17:55:36','2024-09-08 20:47:49'),(125,'reactive their hosting',NULL,1,1,5,'2024-08-31 17:56:47','2024-09-16 22:57:15'),(137,' solve cors origin error',NULL,1,1,41,'2024-08-31 18:03:12','2024-09-09 17:00:58'),(138,'change logo image',NULL,1,2,41,'2024-08-31 18:05:10','2024-08-31 21:04:37'),(139,' change cards to be two in small screens',NULL,1,2,41,'2024-08-31 18:05:10','2024-08-31 21:16:47'),(140,'change admin color icon ',NULL,1,2,41,'2024-08-31 18:05:10','2024-08-31 23:50:21'),(141,' disable button when creating a hangout',NULL,1,2,41,'2024-08-31 18:05:10','2024-09-04 20:29:14'),(142,' in system message minimum charge add value',NULL,1,2,41,'2024-08-31 18:05:10','2024-09-02 02:43:15'),(148,'enable reciving messages through email',NULL,1,1,28,'2024-08-31 18:28:54','2024-09-10 07:24:51'),(149,'enable reciving messages through email',NULL,1,3,28,'2024-08-31 18:28:54','2024-09-10 07:24:51'),(150,'navbar design',NULL,1,2,41,'2024-08-31 18:55:00','2024-08-31 23:19:45'),(151,' show ads after specific number of restaurants ',NULL,1,1,41,'2024-08-31 18:59:34','2024-09-03 01:31:24'),(155,'Remove visa from hosting',NULL,1,1,5,'2024-08-31 20:33:32','2024-09-02 17:51:33'),(156,'Signup is not working',NULL,1,1,41,'2024-08-31 21:30:15','2024-09-03 01:31:24'),(159,'forget password',NULL,1,1,47,'2024-09-01 00:02:09','2024-09-03 01:31:24'),(160,'forget password',NULL,1,3,47,'2024-09-01 00:02:09','2024-09-03 01:31:24'),(161,'google login',NULL,1,1,47,'2024-09-01 00:02:09','2024-09-16 22:57:15'),(162,'google login',NULL,1,3,47,'2024-09-01 00:02:09','2024-09-16 22:57:15'),(163,'Send mina email credentials ',NULL,1,1,28,'2024-09-01 08:25:00','2024-09-03 01:31:24'),(164,' edit contacts data',NULL,1,1,28,'2024-09-01 08:25:00','2024-09-02 17:52:18'),(167,'change logo ',NULL,1,1,41,'2024-09-01 21:13:26','2024-09-03 01:31:24'),(168,' edit api',NULL,1,1,41,'2024-09-01 21:13:26','2024-09-03 01:31:24'),(190,'change email in contacts',NULL,1,1,28,'2024-09-02 02:56:41','2024-09-16 22:57:15'),(191,'change email in contacts',NULL,1,3,28,'2024-09-02 02:56:41','2024-09-16 22:57:15'),(192,'Show count of unique tasks',NULL,1,1,5,'2024-09-02 12:05:07','2024-09-02 17:30:30'),(196,' remove hangout after specific time determined in dashboard',NULL,1,3,41,'2024-09-02 17:53:56','2024-09-03 21:30:30'),(197,' remove hangout after specific time determined in dashboard',NULL,1,3,41,'2024-09-02 17:53:56','2024-09-03 21:30:30'),(198,' remove hangout after specific time determined in dashboard',NULL,1,3,41,'2024-09-02 17:53:56','2024-09-03 21:30:30'),(199,'Fix csrf issue',NULL,1,1,47,'2024-09-02 18:05:37','2024-09-08 20:47:49'),(205,'fix responsive in arabic (mobile)',NULL,1,2,44,'2024-09-02 23:05:53','2024-09-03 21:10:17'),(206,'Check eman new app reqs cost',NULL,1,1,5,'2024-09-03 01:42:52','2024-09-09 19:04:59'),(207,'Check eman new app reqs cost',NULL,1,3,5,'2024-09-03 01:42:52','2024-09-09 19:04:59'),(208,'Add ibrahim to google add as admin',NULL,1,1,5,'2024-09-03 02:07:52','2024-09-16 22:57:15'),(209,'Make ibrahim see all tasks',NULL,1,1,5,'2024-09-03 02:08:59','2024-09-16 22:57:15'),(210,'Fix dropdown menu',NULL,1,1,48,'2024-09-03 02:17:58','2024-09-16 22:57:15'),(211,'Edit logo as required',NULL,1,1,5,'2024-09-03 02:33:13','2024-10-16 06:03:40'),(213,'Trip opens on bottom of page',NULL,1,1,28,'2024-09-03 12:30:59','2024-10-16 05:50:51'),(214,'Trip opens on bottom of page',NULL,1,2,28,'2024-09-03 12:30:59','2024-10-16 05:50:51'),(217,'lates 10 reviews only appear in reviews',NULL,1,3,41,'2024-09-03 17:08:34','2024-09-03 18:58:01'),(218,'lates 10 reviews only appear in reviews',NULL,1,3,41,'2024-09-03 17:08:34','2024-09-03 18:58:01'),(219,'lates 10 reviews only appear in reviews',NULL,1,3,41,'2024-09-03 17:08:34','2024-09-03 18:58:01'),(220,' rename Minimum Charge Value to Minimum Charge Value per person',NULL,1,2,41,'2024-09-03 17:24:54','2024-09-04 02:08:46'),(221,' rename Minimum Charge Value to Minimum Charge Value per person',NULL,1,2,41,'2024-09-03 17:24:54','2024-09-04 02:08:46'),(222,' rename Minimum Charge Value to Minimum Charge Value per person',NULL,1,2,41,'2024-09-03 17:24:54','2024-09-04 02:08:46'),(226,' system messages appear after reservation',NULL,1,10,41,'2024-09-03 17:32:08','2024-09-04 20:37:15'),(227,' system messages appear after reservation',NULL,1,10,41,'2024-09-03 17:32:08','2024-09-04 20:37:15'),(228,' system messages appear after reservation',NULL,1,10,41,'2024-09-03 17:32:08','2024-09-04 20:37:15'),(232,'Fix reservation process in backend',NULL,1,1,41,'2024-09-03 17:35:06','2024-12-21 15:43:42'),(236,'test forms in front',NULL,1,3,28,'2024-09-03 17:37:06','2024-09-10 07:22:43'),(241,'change content',NULL,1,3,44,'2024-09-03 17:43:00','2024-09-09 18:57:41'),(242,'change content',NULL,1,3,44,'2024-09-03 17:43:00','2024-09-09 18:57:41'),(243,'change sections order',NULL,1,3,44,'2024-09-03 17:43:26','2024-09-09 18:56:43'),(244,'change sections order',NULL,1,3,44,'2024-09-03 17:43:26','2024-09-09 18:56:43'),(254,'Add view ingredient in other mwals',NULL,1,10,41,'2024-09-04 00:28:52','2024-09-09 17:00:58'),(257,' change options to make order pay minimum charge and cance',NULL,1,10,41,'2024-09-04 01:28:21','2024-10-20 06:19:06'),(258,' change options to make order pay minimum charge and cance',NULL,1,10,41,'2024-09-04 01:28:21','2024-10-20 06:19:06'),(259,' change options to make order pay minimum charge and cance',NULL,1,10,41,'2024-09-04 01:28:21','2024-10-20 06:19:06'),(267,' confirm system message should appear when it is time',NULL,1,10,41,'2024-09-04 03:57:11','2024-10-21 18:12:27'),(268,'password should be of table not reservation ',NULL,1,10,41,'2024-09-04 03:57:11','2024-11-09 01:37:19'),(269,' cannot add meals from two restaurants',NULL,1,3,41,'2024-09-04 03:58:07','2024-09-04 23:02:59'),(270,' cannot add meals from two restaurants',NULL,1,10,41,'2024-09-04 03:58:07','2024-09-04 23:02:59'),(271,'add qrcode to table to navigate you to in restaurant with table number',NULL,1,3,41,'2024-09-04 03:58:07','2024-09-09 17:00:58'),(272,'add qrcode to table to navigate you to in restaurant with table number',NULL,1,10,41,'2024-09-04 03:58:07','2024-09-09 17:00:58'),(273,'add hide option to category and add appearance time interval(note local and future)',NULL,1,10,41,'2024-09-04 04:00:07','2024-09-04 20:29:14'),(274,'add hide option to category and add appearance time interval(note local and future)',NULL,1,10,41,'2024-09-04 04:00:07','2024-09-04 20:29:14'),(275,'add hide option to category and add appearance time interval(note local and future)',NULL,1,10,41,'2024-09-04 04:00:07','2024-09-04 20:29:14'),(276,'Add extras as backend and local storage',NULL,1,1,41,'2024-09-04 14:34:53','2024-09-04 23:02:49'),(277,'Add extras as backend and local storage',NULL,1,3,41,'2024-09-04 14:34:53','2024-09-04 23:02:49'),(278,'Add extras as backend and local storage',NULL,1,10,41,'2024-09-04 14:34:53','2024-09-04 23:02:49'),(282,'Activate the bonus when paying the total in cash; otherwise, the bonus remains inactive.',NULL,1,1,20,'2024-09-04 18:49:39','2024-09-06 23:14:42'),(283,'Activate the bonus when paying the total in cash; otherwise, the bonus remains inactive.',NULL,1,3,20,'2024-09-04 18:49:39','2024-09-06 23:14:42'),(284,'add discount percentage value  before  general total ',NULL,1,1,20,'2024-09-04 18:53:18','2024-09-07 02:25:08'),(285,'add discount percentage value  before  general total ',NULL,1,3,20,'2024-09-04 18:53:18','2024-09-07 02:25:08'),(286,' remove print button',NULL,1,1,20,'2024-09-04 18:53:18','2024-09-06 21:43:09'),(287,' remove print button',NULL,1,3,20,'2024-09-04 18:53:18','2024-09-06 21:43:09'),(288,'update status of the sales that depend on payment period',NULL,1,1,20,'2024-09-04 18:56:43','2024-09-07 08:58:42'),(289,'update status of the sales that depend on payment period',NULL,1,3,20,'2024-09-04 18:56:43','2024-09-07 08:58:42'),(290,'arrange sales product in sales show to product, patch,  sales price, discount, price after discount, count, bouns, total',NULL,1,1,20,'2024-09-04 18:57:58','2024-09-06 21:42:15'),(291,'arrange sales product in sales show to product, patch,  sales price, discount, price after discount, count, bouns, total',NULL,1,3,20,'2024-09-04 18:57:58','2024-09-06 21:42:15'),(292,'add reports in the roles',NULL,1,1,20,'2024-09-04 18:59:01','2024-09-06 21:49:46'),(293,'add reports in the roles',NULL,1,3,20,'2024-09-04 18:59:01','2024-09-06 21:49:46'),(294,'appear discount percentage in product create',NULL,1,1,20,'2024-09-04 19:03:34','2024-09-06 22:27:44'),(295,'appear discount percentage in product create',NULL,1,3,20,'2024-09-04 19:03:34','2024-09-06 22:27:44'),(296,'check transaction from and to (calculate balance wrong )',NULL,1,1,20,'2024-09-04 19:29:17','2024-09-06 23:53:38'),(297,'check transaction from and to (calculate balance wrong )',NULL,1,3,20,'2024-09-04 19:29:17','2024-09-06 23:53:38'),(298,'update admin register API (firstname,lastname,username,file) (trainer,trainee)',NULL,1,3,51,'2024-09-04 20:20:13','2024-09-10 07:19:50'),(299,'Add extras as backend and local storage',NULL,1,1,41,'2024-09-04 20:24:48','2024-09-04 23:02:49'),(300,'Add extras as backend and local storage',NULL,1,3,41,'2024-09-04 20:24:48','2024-09-04 23:02:49'),(301,'Add extras as backend and local storage',NULL,1,10,41,'2024-09-04 20:24:48','2024-09-04 23:02:49'),(302,'Add Restaurant_id inside the single meal API',NULL,1,3,41,'2024-09-04 20:45:19','2024-09-04 23:02:34'),(303,' categories inside restaurant should be renamed to menu categories and categories outside restaurant should be like bar ... etc',NULL,1,10,41,'2024-09-04 21:14:17','2024-09-09 17:00:58'),(304,' categories inside restaurant should be renamed to menu categories and categories outside restaurant should be like bar ... etc',NULL,1,10,41,'2024-09-04 21:14:17','2024-09-09 17:00:58'),(305,' categories inside restaurant should be renamed to menu categories and categories outside restaurant should be like bar ... etc',NULL,1,10,41,'2024-09-04 21:14:17','2024-09-09 17:00:58'),(306,' categories inside restaurant should be renamed to menu categories and categories outside restaurant should be like bar ... etc',NULL,1,10,41,'2024-09-04 21:14:17','2024-09-09 17:00:58'),(307,' categories inside restaurant should be renamed to menu categories and categories outside restaurant should be like bar ... etc',NULL,1,10,41,'2024-09-04 21:14:17','2024-09-09 17:00:58'),(308,' categories inside restaurant should be renamed to menu categories and categories outside restaurant should be like bar ... etc',NULL,1,10,41,'2024-09-04 21:14:17','2024-09-09 17:00:58'),(309,' categories inside restaurant should be renamed to menu categories and categories outside restaurant should be like bar ... etc',NULL,1,10,41,'2024-09-04 21:14:17','2024-09-09 17:00:58'),(310,' categories inside restaurant should be renamed to menu categories and categories outside restaurant should be like bar ... etc',NULL,1,10,41,'2024-09-04 21:14:17','2024-09-09 17:00:58'),(311,' categories inside restaurant should be renamed to menu categories and categories outside restaurant should be like bar ... etc',NULL,1,10,41,'2024-09-04 21:14:17','2024-09-09 17:00:58'),(312,'Change API restaurant_location_category, restaurant_category_location to Outside Category not the normal category',NULL,1,3,41,'2024-09-04 21:20:30','2024-09-04 22:58:24'),(313,'Reservation using QR Code Send Params in URL Restaurant_id , Table_id',NULL,1,3,41,'2024-09-04 21:25:40','2024-09-09 17:00:58'),(314,'Add  delete option to permissions and group them',NULL,1,1,5,'2024-09-05 00:24:50','2024-10-11 19:06:49'),(315,'Make options inside datatable work with localstorage to eemmber settings',NULL,1,1,5,'2024-09-05 00:59:12','2024-10-11 19:06:49'),(317,'Fix profile teacher and profile student ',NULL,1,1,47,'2024-09-05 02:32:12','2024-09-08 20:47:49'),(318,' add api to get profile data of logged in user',NULL,1,1,47,'2024-09-05 02:32:12','2024-09-08 20:47:49'),(319,'Add more options in reservation with somking,non smoking',NULL,1,3,41,'2024-09-05 03:31:42','2024-09-12 02:45:43'),(321,'Follow ads from yoyr mobile',NULL,1,1,5,'2024-09-05 03:38:03','2024-09-16 22:57:15'),(322,'Send miba correct email credentials',NULL,1,1,28,'2024-09-05 05:25:58','2024-09-16 22:57:15'),(323,'Show mab once loaded',NULL,1,1,51,'2024-09-05 17:13:37','2024-09-06 04:40:32'),(324,'Show mab once loaded',NULL,1,2,51,'2024-09-05 17:13:37','2024-09-06 04:40:32'),(332,'Copy quiz module from logat to unihome',NULL,1,1,5,'2024-09-06 19:42:39','2024-09-08 20:47:49'),(333,'Copy quiz module from logat to unihome',NULL,1,3,5,'2024-09-06 19:42:39','2024-09-08 20:47:49'),(336,'Change slider images',NULL,1,1,5,'2024-09-06 19:44:30','2024-09-16 22:57:15'),(337,'show all data as latest',NULL,1,1,41,'2024-09-06 19:44:30','2024-09-09 00:31:18'),(338,'show all data as latest',NULL,1,1,41,'2024-09-06 19:44:30','2024-09-09 00:31:18'),(339,'show all data as latest',NULL,1,1,41,'2024-09-06 19:44:30','2024-09-09 00:31:18'),(340,'remove Max Price For Person from hangout',NULL,1,1,41,'2024-09-06 19:44:30','2024-09-09 00:31:18'),(341,'remove Max Price For Person from hangout',NULL,1,1,41,'2024-09-06 19:44:30','2024-09-09 00:31:18'),(346,'Reschdeul and cancel options ',NULL,1,1,47,'2024-09-08 20:49:14','2024-09-16 22:57:15'),(347,' calc session out of wallet',NULL,1,1,47,'2024-09-08 20:49:14','2024-09-16 22:57:15'),(348,'Chwck with maher bew app details and create for him a contract',NULL,1,1,47,'2024-09-08 20:51:18','2024-09-08 20:51:53'),(349,'Chwck with maher bew app details and create for him a contract',NULL,1,3,47,'2024-09-08 20:51:18','2024-09-08 20:51:53'),(350,'Check with maher new app and give him a contract',NULL,1,1,47,'2024-09-08 20:52:36','2024-09-16 23:15:00'),(351,'Check with maher new app and give him a contract',NULL,1,3,47,'2024-09-08 20:52:36','2024-09-16 23:15:00'),(354,'make insert doctors dynamic',NULL,1,1,26,'2024-09-10 07:26:31','2024-09-12 02:45:25'),(355,'make insert doctors dynamic',NULL,1,2,26,'2024-09-10 07:26:31','2024-09-12 02:45:25'),(356,'make insert doctors dynamic',NULL,1,3,26,'2024-09-10 07:26:31','2024-09-12 02:45:25'),(357,'fix responsive',NULL,1,1,20,'2024-09-11 17:41:43','2024-09-11 19:07:43'),(358,'fix responsive',NULL,1,2,20,'2024-09-11 17:41:43','2024-09-11 19:07:43'),(359,'fix responsive',NULL,1,3,20,'2024-09-11 17:41:43','2024-09-11 19:07:43'),(360,'fix responsive',NULL,1,1,20,'2024-09-11 17:41:43','2024-09-11 19:07:43'),(361,'fix responsive',NULL,1,2,20,'2024-09-11 17:41:43','2024-09-11 19:07:43'),(362,'fix responsive',NULL,1,3,20,'2024-09-11 17:41:43','2024-09-11 19:07:43'),(363,'fix Discount Percentage  value in sales',NULL,1,1,20,'2024-09-11 18:09:05','2024-09-26 21:41:45'),(364,'fix Discount Percentage  value in sales',NULL,1,3,20,'2024-09-11 18:09:05','2024-09-26 21:41:45'),(365,'make branches connected with  Pharmacists by Ajax',NULL,1,1,20,'2024-09-11 18:11:20','2024-09-11 19:20:41'),(366,'make branches connected with  Pharmacists by Ajax',NULL,1,3,20,'2024-09-11 18:11:20','2024-09-11 19:20:41'),(367,'fix errors while testing  reference on WhatsApp',NULL,1,1,20,'2024-09-11 18:12:11','2024-09-12 02:42:20'),(368,'fix errors while testing  reference on WhatsApp',NULL,1,3,20,'2024-09-11 18:12:11','2024-09-12 02:42:20'),(369,'Subject in Contact form ',NULL,1,3,51,'2024-09-11 19:24:46','2024-09-12 02:45:08'),(370,' Product details {  desc, custom block ,review form}',NULL,1,3,51,'2024-09-11 19:24:46','2024-09-12 02:45:20'),(371,'video link in single career',NULL,1,2,51,'2024-09-11 19:40:06','2024-09-12 02:45:15'),(372,'video link in single career',NULL,1,3,51,'2024-09-11 19:40:06','2024-09-12 02:45:15'),(373,'fix icon',NULL,1,1,26,'2024-09-12 18:58:45','2024-09-15 21:19:59'),(374,'fix icon',NULL,1,3,26,'2024-09-12 18:58:45','2024-09-15 21:19:59'),(375,'remove dubai and change number of watssapp',NULL,1,1,26,'2024-09-12 19:04:51','2024-09-15 21:19:50'),(376,'remove dubai and change number of watssapp',NULL,1,3,26,'2024-09-12 19:04:51','2024-09-15 21:19:50'),(377,'add email support@unihome.com',NULL,1,1,47,'2024-09-15 17:34:56','2024-09-15 21:26:45'),(378,'add email support@unihome.com',NULL,1,3,47,'2024-09-15 17:34:56','2024-09-15 21:26:45'),(379,'enable change password in profile',NULL,1,1,47,'2024-09-15 17:34:56','2024-09-16 23:11:48'),(380,'enable change password in profile',NULL,1,3,47,'2024-09-15 17:34:56','2024-09-16 23:11:48'),(381,'check front and take descession about creating',NULL,1,1,5,'2024-09-15 17:43:45','2024-09-16 23:11:37'),(382,'check front and take descession about creating',NULL,1,3,5,'2024-09-15 17:43:45','2024-09-16 23:11:37'),(383,'fix design of mishoo app',NULL,1,1,5,'2024-09-15 17:48:41','2024-09-16 22:57:15'),(384,'check medhat ad issue',NULL,1,1,5,'2024-09-15 19:43:09','2024-09-16 22:57:15'),(385,'make time in teacher edit in minuts only no seconds',NULL,1,1,47,'2024-09-15 19:43:55','2024-09-16 22:57:15'),(389,'Show indoor and outdoor inside them put options smoking,seaview,pool,etc',NULL,1,1,41,'2024-09-17 20:55:30','2024-10-16 06:02:53'),(390,'Show indoor and outdoor inside them put options smoking,seaview,pool,etc',NULL,1,2,41,'2024-09-17 20:55:30','2024-10-16 06:02:53'),(391,'Show indoor and outdoor inside them put options smoking,seaview,pool,etc',NULL,1,3,41,'2024-09-17 20:55:30','2024-10-16 06:02:53'),(392,'Edit breadcrump when choose category',NULL,1,1,41,'2024-09-17 21:05:44','2024-09-20 01:27:37'),(393,'Edit breadcrump when choose category',NULL,1,2,41,'2024-09-17 21:05:44','2024-09-20 01:27:37'),(394,'change the breadcrumb title dynamically based on the name of the page or section (OutsideCategories)',NULL,1,1,41,'2024-09-17 21:09:06','2024-09-20 01:27:37'),(395,'change the breadcrumb title dynamically based on the name of the page or section (OutsideCategories)',NULL,1,2,41,'2024-09-17 21:09:06','2024-09-20 01:27:37'),(396,'change the breadcrumb title dynamically based on the name of the page or section (OutsideCategories)',NULL,1,3,41,'2024-09-17 21:09:06','2024-09-20 01:27:37'),(399,'hide or show the outside category based on whether it belongs to a specific restaurant',NULL,1,1,41,'2024-09-17 21:16:46','2024-09-19 23:14:40'),(400,'hide or show the outside category based on whether it belongs to a specific restaurant',NULL,1,2,41,'2024-09-17 21:16:46','2024-09-19 23:14:40'),(401,'hide or show the outside category based on whether it belongs to a specific restaurant',NULL,1,3,41,'2024-09-17 21:16:46','2024-09-19 23:14:40'),(402,'Qr code design not same abd need to show options when click call waiter',NULL,1,10,41,'2024-09-17 21:40:08','2024-11-09 01:37:09'),(403,'If table more than persons ok but less restrict or valudate it',NULL,1,1,41,'2024-09-17 22:47:37','2024-09-20 01:57:14'),(404,'If table more than persons ok but less restrict or valudate it',NULL,1,2,41,'2024-09-17 22:47:37','2024-09-20 01:57:14'),(408,'Display none unneeded inputs in students dashboard',NULL,1,3,47,'2024-09-18 04:59:12','2024-09-18 19:02:57'),(409,'Test routes',NULL,1,1,41,'2024-09-18 05:10:10','2024-11-09 01:36:56'),(410,'Add single session api ',NULL,1,1,47,'2024-09-18 05:59:28','2024-09-18 18:09:46'),(411,'Add single session api ',NULL,1,3,47,'2024-09-18 05:59:28','2024-09-18 18:09:46'),(412,' make wallet sender admin only and check missings',NULL,1,1,47,'2024-09-18 05:59:28','2024-09-18 18:26:56'),(413,' make wallet sender admin only and check missings',NULL,1,3,47,'2024-09-18 05:59:28','2024-09-18 18:26:56'),(414,'Fix login expiration and redirect if not athinticated',NULL,1,10,41,'2024-09-18 20:36:02','2024-11-09 06:46:06'),(415,'Make sure that booking session deduct from user balance ',NULL,1,3,47,'2024-09-19 02:41:54','2024-09-19 03:00:28'),(416,' send user balance in wallet resource ',NULL,1,3,47,'2024-09-19 02:41:54','2024-09-19 03:00:28'),(417,' make edit stident has only student attributes and show as well',NULL,1,3,47,'2024-09-19 02:41:54','2024-09-19 02:51:34'),(418,'Add percenrage of admin in setting',NULL,1,3,41,'2024-09-19 09:22:45','2024-09-22 23:40:32'),(419,' cancel sesion should be within 24 hours',NULL,1,3,41,'2024-09-19 09:22:45','2024-09-22 23:40:32'),(420,'Add percenrage of admin in setting',NULL,1,3,47,'2024-09-19 09:23:15','2024-09-22 23:40:32'),(421,' cancel sesion should be within 24 hours',NULL,1,3,47,'2024-09-19 09:23:15','2024-09-22 23:40:32'),(422,'Edit email content',NULL,1,1,28,'2024-09-19 22:52:55','2024-10-11 19:45:18'),(423,'Edit email content',NULL,1,3,28,'2024-09-19 22:52:55','2024-10-11 19:45:18'),(424,'rotate email srnd and receivee',NULL,1,1,28,'2024-09-19 22:52:55','2024-10-11 19:45:18'),(425,'rotate email srnd and receivee',NULL,1,3,28,'2024-09-19 22:52:55','2024-10-11 19:45:18'),(426,'Website needs to be dynamic but not before getting half of its cost',NULL,1,1,26,'2024-09-20 11:36:14','2024-10-16 06:01:32'),(427,'Website needs to be dynamic but not before getting half of its cost',NULL,1,3,26,'2024-09-20 11:36:14','2024-10-16 06:01:32'),(428,'Add quiz to app',NULL,1,1,32,'2024-09-20 11:37:16','2024-10-16 06:00:39'),(429,'Remove /admin from routes',NULL,1,1,5,'2024-09-21 03:19:08','2024-10-11 19:06:49'),(430,'Add new page reservation hangout process abd add reservation number ',NULL,1,3,41,'2024-09-21 04:12:18','2024-10-20 06:14:39'),(431,'Add new page reservation hangout process abd add reservation number ',NULL,1,10,41,'2024-09-21 04:12:18','2024-10-20 06:14:39'),(432,'add note to show that left people may increase in yellow',NULL,1,3,41,'2024-09-21 04:12:18','2024-10-20 06:14:45'),(433,'add note to show that left people may increase in yellow',NULL,1,10,41,'2024-09-21 04:12:18','2024-10-20 06:14:45'),(434,' restaurant logo in in restaurant',NULL,1,3,41,'2024-09-21 04:12:18','2024-10-20 06:14:47'),(435,' restaurant logo in in restaurant',NULL,1,10,41,'2024-09-21 04:12:18','2024-10-20 06:14:47'),(436,' show call waiter salt and other options in  witer and add them dynamic in dashboard ',NULL,1,3,41,'2024-09-21 04:12:18','2024-11-09 18:16:39'),(437,' show call waiter salt and other options in  witer and add them dynamic in dashboard ',NULL,1,10,41,'2024-09-21 04:12:18','2024-11-09 18:16:39'),(438,' in zeyads additional page make it welcone to restayrant name and remove call manager',NULL,1,3,41,'2024-09-21 04:12:18','2024-10-20 06:14:57'),(439,' in zeyads additional page make it welcone to restayrant name and remove call manager',NULL,1,10,41,'2024-09-21 04:12:18','2024-10-20 06:14:57'),(440,'Chage handling order from two restaurants  using modal with two options complete or empty cart',NULL,1,3,41,'2024-09-21 04:15:00','2024-10-20 06:14:35'),(441,'Chage handling order from two restaurants  using modal with two options complete or empty cart',NULL,1,10,41,'2024-09-21 04:15:00','2024-10-20 06:14:35'),(442,'Fix responsive design ( mobile - tablet)',NULL,1,1,20,'2024-09-21 04:35:16','2024-11-22 20:00:10'),(443,'Fix responsive design ( mobile - tablet)',NULL,1,2,20,'2024-09-21 04:35:16','2024-11-22 20:00:10'),(450,'Hack photoshop',NULL,0,1,5,'2024-09-21 10:32:27','2024-09-21 10:32:27'),(451,'fix sidebar in(doctor ',NULL,1,1,20,'2024-09-21 21:54:06','2024-11-22 20:00:10'),(452,'fix sidebar in(doctor ',NULL,1,2,20,'2024-09-21 21:54:06','2024-11-22 20:00:10'),(453,' commission ',NULL,1,1,20,'2024-09-21 21:54:06','2024-10-16 06:04:06'),(454,' commission ',NULL,1,2,20,'2024-09-21 21:54:06','2024-10-16 06:04:06'),(455,')',NULL,1,1,20,'2024-09-21 21:54:06','2024-09-22 05:04:47'),(456,')',NULL,1,2,20,'2024-09-21 21:54:06','2024-09-22 05:04:47'),(458,'Remove unused files from code',NULL,1,1,41,'2024-09-22 03:07:42','2024-09-22 04:57:51'),(459,'Temove unused files from dashboard',NULL,1,3,47,'2024-09-22 03:08:12','2024-09-22 20:40:22'),(460,' add background color to status',NULL,1,10,41,'2024-09-22 04:58:49','2024-10-20 06:14:26'),(461,' add background color to status',NULL,1,10,41,'2024-09-22 04:58:49','2024-10-20 06:14:26'),(470,'make difrrences between products to allow user see diffrence in prices in all products',NULL,1,1,28,'2024-09-23 07:14:33','2024-10-08 22:20:14'),(471,'make difrrences between products to allow user see diffrence in prices in all products',NULL,1,3,28,'2024-09-23 07:14:33','2024-10-08 22:20:14'),(472,'Card with employee or student image snd other basic data and expiration date and userId and production date',NULL,1,1,32,'2024-09-24 09:09:42','2024-09-27 00:41:53'),(473,'Card with employee or student image snd other basic data and expiration date and userId and production date',NULL,1,3,32,'2024-09-24 09:09:42','2024-09-27 00:41:53'),(474,' card contain qrcode ',NULL,1,1,32,'2024-09-24 09:09:42','2024-09-26 21:41:45'),(475,' card contain qrcode ',NULL,1,3,32,'2024-09-24 09:09:42','2024-09-26 21:41:45'),(476,' qrcode will be for shops owner ',NULL,1,1,32,'2024-09-24 09:09:42','2024-10-08 20:34:39'),(477,' qrcode will be for shops owner ',NULL,1,3,32,'2024-09-24 09:09:42','2024-10-08 20:34:39'),(478,' card data is namr third , image, card production date, card expiration date ',NULL,1,1,32,'2024-09-24 09:09:42','2024-09-27 00:44:53'),(479,' card data is namr third , image, card production date, card expiration date ',NULL,1,3,32,'2024-09-24 09:09:42','2024-09-27 00:44:53'),(480,' card has two faces one for logo and logat elasr data and other face for user data',NULL,1,1,32,'2024-09-24 09:09:42','2024-09-27 00:45:00'),(481,' card has two faces one for logo and logat elasr data and other face for user data',NULL,1,3,32,'2024-09-24 09:09:42','2024-09-27 00:45:00'),(484,' shop owner should has accounts to differ betwwen owner and other',NULL,1,1,32,'2024-09-24 09:09:42','2024-10-08 20:34:39'),(485,' shop owner should has accounts to differ betwwen owner and other',NULL,1,3,32,'2024-09-24 09:09:42','2024-10-08 20:34:39'),(486,' add also barcode to on card ',NULL,1,1,32,'2024-09-24 09:09:42','2024-09-27 00:45:21'),(487,' add also barcode to on card ',NULL,1,3,32,'2024-09-24 09:09:42','2024-09-27 00:45:21'),(488,' stop card if graduared frozen and if expired ',NULL,1,1,32,'2024-09-24 09:09:42','2024-09-27 01:04:22'),(489,' stop card if graduared frozen and if expired ',NULL,1,3,32,'2024-09-24 09:09:42','2024-09-27 01:04:22'),(490,' if graduated he can buy the card and make use of it for a cost or year',NULL,1,1,32,'2024-09-24 09:09:42','2024-10-08 20:34:39'),(491,' if graduated he can buy the card and make use of it for a cost or year',NULL,1,3,32,'2024-09-24 09:09:42','2024-10-08 20:34:39'),(492,'Sebd tables cabacities inside restaurants',NULL,1,3,41,'2024-09-25 00:03:28','2024-09-25 02:34:04'),(493,' add isQrcode in reservations table',NULL,1,3,41,'2024-09-25 00:03:28','2024-09-25 02:21:01'),(494,'Add waitings as api to allow see waitings details',NULL,1,1,41,'2024-09-25 00:07:13','2024-09-25 03:18:47'),(495,'Add waitings as api to allow see waitings details',NULL,1,3,41,'2024-09-25 00:07:13','2024-09-25 03:18:47'),(497,'QR code for restaurant waiting list',NULL,1,3,41,'2024-09-28 19:39:48','2024-10-08 22:19:09'),(498,'big distance in blades',NULL,1,1,47,'2024-10-03 18:23:54','2024-10-16 06:01:02'),(499,'big distance in blades',NULL,1,3,47,'2024-10-03 18:23:54','2024-10-16 06:01:02'),(500,' password is required',NULL,1,1,47,'2024-10-03 18:23:54','2024-10-03 20:40:46'),(501,' password is required',NULL,1,3,47,'2024-10-03 18:23:54','2024-10-03 20:40:46'),(502,'image of users do not return in api dunamically',NULL,1,1,47,'2024-10-03 18:23:54','2024-10-03 21:09:16'),(503,'image of users do not return in api dunamically',NULL,1,3,47,'2024-10-03 18:23:54','2024-10-03 21:09:16'),(504,' setting design bad',NULL,1,1,47,'2024-10-03 18:23:54','2024-10-16 06:01:02'),(505,' setting design bad',NULL,1,3,47,'2024-10-03 18:23:54','2024-10-16 06:01:02'),(506,' title in users index should be teacher or students',NULL,1,1,47,'2024-10-03 18:23:54','2024-10-03 20:57:09'),(507,' title in users index should be teacher or students',NULL,1,3,47,'2024-10-03 18:23:54','2024-10-03 20:57:09'),(508,'reviews issue',NULL,1,1,47,'2024-10-03 18:23:54','2024-10-03 20:43:11'),(509,'reviews issue',NULL,1,3,47,'2024-10-03 18:23:54','2024-10-03 20:43:11'),(510,'show phone in users',NULL,1,1,47,'2024-10-03 18:23:54','2024-10-03 20:47:13'),(511,'show phone in users',NULL,1,3,47,'2024-10-03 18:23:54','2024-10-03 20:47:13'),(512,'remove confirmation',NULL,1,1,47,'2024-10-03 18:23:54','2024-10-03 20:53:17'),(513,'remove confirmation',NULL,1,3,47,'2024-10-03 18:23:54','2024-10-03 20:53:17'),(518,'add meta key words',NULL,1,1,32,'2024-10-07 04:31:52','2024-10-08 20:33:55'),(519,'add meta key words',NULL,1,3,32,'2024-10-07 04:31:52','2024-10-08 20:33:55'),(530,'',NULL,1,1,51,'2024-10-11 19:14:06','2024-12-07 05:06:30'),(531,'',NULL,1,2,51,'2024-10-11 19:14:06','2024-12-07 05:06:30'),(532,'Create logo on canva',NULL,1,1,53,'2024-10-11 19:46:56','2024-10-16 06:03:46'),(538,'email issue',NULL,1,1,10,'2024-10-11 19:52:21','2024-10-20 05:08:47'),(539,'',NULL,1,1,10,'2024-10-11 19:52:21','2024-12-07 05:06:30'),(540,'add breadcrumb',NULL,1,11,53,'2024-10-14 15:32:52','2024-10-16 15:22:48'),(541,'add multi images in single product',NULL,1,11,53,'2024-10-14 15:33:27','2024-10-14 19:57:15'),(542,'add multi images in single product',NULL,1,11,53,'2024-10-14 15:33:28','2024-10-14 19:57:15'),(543,'Add localization',NULL,1,11,53,'2024-10-14 15:33:50','2024-10-14 19:30:56'),(544,'add breadcrumb',NULL,1,5,53,'2024-10-14 15:34:18','2024-10-16 15:22:48'),(545,'when click in geographical remove only clicked item ',NULL,1,11,28,'2024-10-16 05:51:15','2024-10-21 20:01:50'),(546,'when click in geographical remove only clicked item ',NULL,1,11,28,'2024-10-16 05:51:15','2024-10-21 20:01:50'),(547,' make it be governrates only and landmark cities so show',NULL,1,11,28,'2024-10-16 05:51:15','2024-10-21 20:01:44'),(548,' make it be governrates only and landmark cities so show',NULL,1,11,28,'2024-10-16 05:51:15','2024-10-21 20:01:44'),(549,' make it select all',NULL,1,11,28,'2024-10-16 05:51:15','2024-10-21 21:07:32'),(550,' make it select all',NULL,1,11,28,'2024-10-16 05:51:15','2024-10-21 21:07:32'),(551,'add in product licence images',NULL,1,11,28,'2024-10-16 05:51:15','2024-10-21 20:13:06'),(552,'add in product licence images',NULL,1,11,28,'2024-10-16 05:51:15','2024-10-21 20:13:06'),(556,'chat',NULL,1,5,51,'2024-10-16 05:52:50','2024-10-16 22:40:21'),(557,'chat',NULL,1,11,51,'2024-10-16 05:52:50','2024-10-16 22:40:21'),(558,'chat',NULL,1,5,51,'2024-10-16 05:52:50','2024-10-16 22:40:21'),(559,'chat',NULL,1,11,51,'2024-10-16 05:52:50','2024-10-16 22:40:21'),(560,'edit course and job filter',NULL,1,12,51,'2024-10-16 05:54:20','2024-10-20 05:11:09'),(561,'edit course and job filter',NULL,1,12,51,'2024-10-16 05:54:20','2024-10-20 05:11:09'),(562,'test single pages',NULL,1,12,51,'2024-10-16 05:54:20','2024-10-20 05:11:09'),(563,'test single pages',NULL,1,12,51,'2024-10-16 05:54:20','2024-10-20 05:11:09'),(564,'product detail missing some section',NULL,1,12,51,'2024-10-16 05:54:20','2024-10-20 05:11:09'),(565,'product detail missing some section',NULL,1,12,51,'2024-10-16 05:54:20','2024-10-20 05:11:09'),(566,'sort by in trainers ',NULL,1,12,51,'2024-10-16 05:54:20','2024-10-20 05:11:09'),(567,'sort by in trainers ',NULL,1,12,51,'2024-10-16 05:54:20','2024-10-20 05:11:09'),(568,'search by map isnot working',NULL,1,12,51,'2024-10-16 05:54:20','2024-10-20 05:11:09'),(569,'search by map isnot working',NULL,1,12,51,'2024-10-16 05:54:20','2024-10-20 05:11:09'),(570,'feedback only appears when if the customer bought ',NULL,1,12,51,'2024-10-16 05:54:20','2024-10-20 05:11:09'),(571,'feedback only appears when if the customer bought ',NULL,1,12,51,'2024-10-16 05:54:20','2024-10-20 05:11:09'),(572,'nutritions and details in product',NULL,1,12,51,'2024-10-16 05:54:20','2024-10-20 05:11:09'),(573,'nutritions and details in product',NULL,1,12,51,'2024-10-16 05:54:20','2024-10-20 05:11:09'),(574,'videos page',NULL,1,12,10,'2024-10-16 05:55:26','2024-10-17 17:24:54'),(575,'create your trip page',NULL,1,12,10,'2024-10-16 05:55:26','2024-10-22 15:08:38'),(576,'vack to top issue',NULL,1,12,10,'2024-10-16 05:55:26','2024-10-20 05:07:37'),(577,'close when click anywhere',NULL,0,12,10,'2024-10-16 05:55:26','2024-10-16 05:55:26'),(580,'Images on big screens are not good',NULL,1,12,10,'2024-10-16 05:57:00','2024-10-21 16:31:47'),(581,'make it image only',NULL,1,5,47,'2024-10-16 05:57:31','2024-10-20 05:02:17'),(582,'make it image only',NULL,1,5,47,'2024-10-16 05:57:31','2024-10-20 05:02:17'),(585,'In response of post request return number of waiting reqursts',NULL,1,5,41,'2024-10-16 05:58:38','2024-10-23 00:04:40'),(586,'Fix resbonsive in some pages',NULL,1,2,41,'2024-10-16 05:59:07','2024-11-09 20:08:22'),(587,'Put logo in track order page and put track order after order submit ',NULL,1,10,41,'2024-10-16 05:59:56','2024-10-20 06:14:26'),(588,'Put logo in track order page and put track order after order submit ',NULL,1,10,41,'2024-10-16 05:59:56','2024-10-20 06:14:26'),(589,' remove breadcrumb from all the website',NULL,1,10,41,'2024-10-16 06:00:25','2024-11-01 04:01:35'),(590,' remove breadcrumb from all the website',NULL,1,10,41,'2024-10-16 06:00:25','2024-11-01 04:01:35'),(591,'Client pay minimum charge and add value to reservation wallet if he made order under minimum or even many orders that does not exceed min and if exceeded min psy the extra by credit or when reach restaurant',NULL,1,3,41,'2024-10-16 06:02:09','2024-10-21 18:20:18'),(592,'Client pay minimum charge and add value to reservation wallet if he made order under minimum or even many orders that does not exceed min and if exceeded min psy the extra by credit or when reach restaurant',NULL,1,10,41,'2024-10-16 06:02:09','2024-10-21 18:20:18'),(593,'Client pay minimum charge and add value to reservation wallet if he made order under minimum or even many orders that does not exceed min and if exceeded min psy the extra by credit or when reach restaurant',NULL,1,3,41,'2024-10-16 06:02:09','2024-10-21 18:20:18'),(594,'Client pay minimum charge and add value to reservation wallet if he made order under minimum or even many orders that does not exceed min and if exceeded min psy the extra by credit or when reach restaurant',NULL,1,10,41,'2024-10-16 06:02:09','2024-10-21 18:20:18'),(595,'Client pay minimum charge and add value to reservation wallet if he made order under minimum or even many orders that does not exceed min and if exceeded min psy the extra by credit or when reach restaurant',NULL,1,3,41,'2024-10-16 06:02:09','2024-10-21 18:20:18'),(596,'Client pay minimum charge and add value to reservation wallet if he made order under minimum or even many orders that does not exceed min and if exceeded min psy the extra by credit or when reach restaurant',NULL,1,10,41,'2024-10-16 06:02:09','2024-10-21 18:20:18'),(597,'Do not show categories and locations if tgey are empty',NULL,1,5,41,'2024-10-16 06:02:28','2024-10-22 17:19:05'),(598,'Do not show categories and locations if tgey are empty',NULL,1,5,41,'2024-10-16 06:02:28','2024-10-22 17:19:05'),(602,'Complete offers',NULL,1,1,55,'2024-10-16 14:16:16','2024-10-16 18:20:17'),(603,'Check new with damasy',NULL,1,1,55,'2024-10-16 14:16:16','2024-10-16 18:20:17'),(610,'sessions issue',NULL,1,3,47,'2024-10-16 15:26:26','2024-10-20 05:01:29'),(611,'sessions issue',NULL,1,3,47,'2024-10-16 15:26:26','2024-10-20 05:01:29'),(612,'required and ont required in erp',NULL,1,3,20,'2024-10-16 15:45:50','2024-10-21 21:07:12'),(613,'required and ont required in erp',NULL,1,5,20,'2024-10-16 15:45:50','2024-10-21 21:07:12'),(614,'remove some attributes',NULL,1,3,20,'2024-10-16 15:48:20','2024-10-20 05:01:09'),(615,'remove some attributes',NULL,1,5,20,'2024-10-16 15:48:20','2024-10-20 05:01:09'),(616,'Upload front website on server',NULL,1,3,53,'2024-10-16 17:16:55','2024-10-16 21:39:55'),(617,'Upload front website on server',NULL,1,11,53,'2024-10-16 17:16:55','2024-10-16 21:39:55'),(618,' test dasbboard',NULL,1,3,53,'2024-10-16 17:16:55','2024-10-16 23:54:53'),(619,' test dasbboard',NULL,1,11,53,'2024-10-16 17:16:55','2024-10-16 23:54:53'),(620,'Fix store-offers edit',NULL,1,1,55,'2024-10-16 17:21:42','2024-10-20 15:10:58'),(621,'Upload on client server',NULL,1,3,26,'2024-10-16 17:32:08','2024-10-20 04:39:06'),(622,'http://127.0.0.1:8000/ar/admin/vendor/addBranch/1681 city hidden',NULL,1,1,55,'2024-10-16 18:00:00','2024-10-21 17:56:31'),(623,'http://127.0.0.1:8000/ar/admin/stores-offers/create no no branches appear',NULL,1,1,55,'2024-10-16 18:19:44','2024-10-20 15:10:08'),(624,'loader animation',NULL,1,2,21,'2024-10-16 21:21:43','2024-10-16 21:21:49'),(625,'Offer does not return in api of offers',NULL,1,1,55,'2024-10-17 14:07:16','2024-10-21 21:19:00'),(626,'remove some attributes',NULL,1,3,21,'2024-10-17 19:16:54','2024-10-20 05:01:09'),(627,'remove some attributes',NULL,1,5,21,'2024-10-17 19:16:54','2024-10-20 05:01:09'),(628,'Trip opens in bottom',NULL,1,2,10,'2024-10-20 05:04:47','2024-10-22 15:06:57'),(629,'Back to top issue',NULL,1,12,10,'2024-10-20 05:08:02','2024-10-21 16:31:40'),(630,'  with any scan send to dashboard record about this transaction ',NULL,1,3,32,'2024-10-20 05:10:07','2024-10-22 23:40:55'),(631,'  with any scan send to dashboard record about this transaction ',NULL,1,5,32,'2024-10-20 05:10:07','2024-10-22 23:40:55'),(632,'  with any scan send to dashboard record about this transaction ',NULL,1,3,32,'2024-10-20 05:10:07','2024-10-22 23:40:55'),(633,'  with any scan send to dashboard record about this transaction ',NULL,1,5,32,'2024-10-20 05:10:07','2024-10-22 23:40:55'),(634,'add obligatory attribute to stores qwam or categories',NULL,1,1,55,'2024-10-20 15:08:15','2024-10-21 17:56:14'),(635,'https://test.aloo.com.sa/ar/admin/notification/notify-only translate title,description,image',NULL,1,1,55,'2024-10-20 17:56:44','2024-10-21 17:56:14'),(636,'Old in branches and titles in add offer',NULL,1,1,55,'2024-10-20 19:07:46','2024-11-05 19:20:20'),(637,'Translated atrributes in offers banners',NULL,1,1,55,'2024-10-20 20:46:31','2024-10-20 20:48:10'),(638,'Add mcamara and translate website to en and fr with adjust alignment',NULL,1,1,6,'2024-10-20 20:47:33','2024-10-20 20:50:35'),(639,'Add mcamara and translate website to en and fr with adjust alignment',NULL,1,1,55,'2024-10-20 20:50:10','2024-10-20 20:50:35'),(640,'Add sessiontables oytside teachers and determine breaks',NULL,1,1,47,'2024-10-21 01:26:15','2024-11-04 17:26:22'),(641,'handle wallet to be on users only even admin',NULL,1,1,47,'2024-10-21 01:26:15','2024-11-04 17:26:22'),(642,'email verification',NULL,1,1,47,'2024-10-21 01:26:15','2024-12-17 15:22:32'),(643,'header design',NULL,1,1,47,'2024-10-21 01:26:15','2024-11-04 17:26:22'),(644,'remove unneeded inputs from settings',NULL,1,1,47,'2024-10-21 01:26:15','2024-11-04 17:26:22'),(645,'Show date in requests',NULL,1,5,10,'2024-10-21 19:13:19','2024-10-23 22:48:51'),(646,'Show requests as latest',NULL,1,5,10,'2024-10-21 19:15:50','2024-10-22 23:38:22'),(651,'fix trip submit',NULL,1,1,10,'2024-10-21 19:21:41','2024-10-22 23:38:16'),(652,'fix trip submit',NULL,1,5,10,'2024-10-21 19:21:41','2024-10-22 23:38:16'),(653,'Revise translations attributes in all modules worked on',NULL,1,1,55,'2024-10-21 21:56:32','2024-10-27 02:54:06'),(654,'Show options in reservation according to restaurant in dashboard',NULL,1,3,41,'2024-10-22 15:25:02','2024-10-23 00:04:40'),(655,'Show options in reservation according to restaurant in dashboard',NULL,1,5,41,'2024-10-22 15:25:02','2024-10-23 00:04:40'),(656,'Show options in reservation according to restaurant in dashboard',NULL,1,12,41,'2024-10-22 15:25:02','2024-10-23 00:04:40'),(657,'Show options in reservation according to restaurant in dashboard',NULL,1,3,41,'2024-10-22 15:25:02','2024-10-23 00:04:40'),(658,'Show options in reservation according to restaurant in dashboard',NULL,1,5,41,'2024-10-22 15:25:02','2024-10-23 00:04:40'),(659,'Show options in reservation according to restaurant in dashboard',NULL,1,12,41,'2024-10-22 15:25:02','2024-10-23 00:04:40'),(660,'Show options in reservation according to restaurant in dashboard',NULL,1,3,41,'2024-10-22 15:25:02','2024-10-23 00:04:40'),(661,'Show options in reservation according to restaurant in dashboard',NULL,1,5,41,'2024-10-22 15:25:02','2024-10-23 00:04:40'),(662,'Show options in reservation according to restaurant in dashboard',NULL,1,12,41,'2024-10-22 15:25:02','2024-10-23 00:04:40'),(663,'Show options in reservation according to restaurant in dashboard',NULL,1,3,41,'2024-10-22 15:25:02','2024-10-23 00:04:40'),(664,'Show options in reservation according to restaurant in dashboard',NULL,1,5,41,'2024-10-22 15:25:02','2024-10-23 00:04:40'),(665,'Show options in reservation according to restaurant in dashboard',NULL,1,12,41,'2024-10-22 15:25:02','2024-10-23 00:04:40'),(666,'Show options in reservation according to restaurant in dashboard',NULL,1,3,41,'2024-10-22 15:25:02','2024-10-23 00:04:40'),(667,'Show options in reservation according to restaurant in dashboard',NULL,1,5,41,'2024-10-22 15:25:02','2024-10-23 00:04:40'),(668,'Show options in reservation according to restaurant in dashboard',NULL,1,12,41,'2024-10-22 15:25:02','2024-10-23 00:04:40'),(669,'Show options in reservation according to restaurant in dashboard',NULL,1,3,41,'2024-10-22 15:25:02','2024-10-23 00:04:40'),(670,'Show options in reservation according to restaurant in dashboard',NULL,1,5,41,'2024-10-22 15:25:02','2024-10-23 00:04:40'),(671,'Show options in reservation according to restaurant in dashboard',NULL,1,12,41,'2024-10-22 15:25:02','2024-10-23 00:04:40'),(673,'Nake ster offer date looks like end offer date',NULL,1,1,55,'2024-10-22 17:16:21','2024-10-23 14:04:06'),(674,'Add permissions of offers',NULL,1,1,55,'2024-10-22 17:18:37','2024-10-22 21:33:12'),(675,'Make imsges optional in offers',NULL,1,1,55,'2024-10-22 17:20:02','2024-11-05 22:14:50'),(676,'fix trip submit',NULL,1,1,41,'2024-10-22 23:09:38','2024-10-22 23:38:16'),(677,'fix trip submit',NULL,1,5,41,'2024-10-22 23:09:38','2024-10-22 23:38:16'),(678,'Show requests as latest',NULL,1,1,41,'2024-10-22 23:10:13','2024-10-22 23:38:22'),(679,'Show requests as latest',NULL,1,5,41,'2024-10-22 23:10:13','2024-10-22 23:38:22'),(680,'fix trip submit',NULL,1,1,41,'2024-10-22 23:37:36','2024-10-22 23:38:16'),(681,'fix trip submit',NULL,1,5,41,'2024-10-22 23:37:36','2024-10-22 23:38:16'),(682,'Fawry money bank issue',NULL,1,1,6,'2024-10-23 13:16:57','2024-11-05 00:08:35'),(683,'Do not delete all sessions when update teacher',NULL,1,1,47,'2024-10-23 13:23:44','2024-11-04 17:26:22'),(684,'Do not delete all sessions when update teacher',NULL,1,3,47,'2024-10-23 13:23:44','2024-11-04 17:26:22'),(685,' adjust google search console',NULL,1,1,47,'2024-10-23 13:23:44','2024-12-17 15:22:32'),(686,' adjust google search console',NULL,1,3,47,'2024-10-23 13:23:44','2024-12-17 15:22:32'),(687,' skip fridays in adding sessions',NULL,1,1,47,'2024-10-23 13:23:44','2024-11-04 17:26:22'),(688,' skip fridays in adding sessions',NULL,1,3,47,'2024-10-23 13:23:44','2024-11-04 17:26:22'),(689,'Check why obligatory is not returend to mobile',NULL,1,1,55,'2024-10-23 14:10:34','2024-10-23 14:10:34'),(690,'Add store timinigs','Tge only issue is when adding in edit all branches it adds more data to store storeschedules after accept \r\n\r\n\r\n\r\nYou are not using it when accept and this what cause the problem        \r\n// Delete old from other branches\r\n\r\n        ScheduleStation::withoutGlobalScope(\'withoutRamadan\')\r\n\r\n            ->where(\'day\', $request->day)\r\n\r\n            ->whereIn(\'store_id\', $branches)\r\n\r\n            ->when($request->type == \'rest\', function ($q) {\r\n                $q->whereNull(\'ramadan_schedule\');\r\n            }, function ($q) {\r\n                $q->where(\'ramadan_schedule\', 1);\r\n            })->delete();Vendor [res-ramadan]\r\n***done with no diffrence in count***\r\nSingle\r\n#Add + Remove + apply to store schedule [accept + reject]\r\n ***done with no diffrence in count****\r\n\r\nAll\r\n#Add + Remove + apply to child branches + apply to store_schedules [accept + reject]\r\n\r\nAdmin [res-ramadan]\r\n***done with no diffrence in count**\r\nSingle\r\n#Add + Remove + apply to schedule_station\r\n***done with no diffrence in count***\r\n\r\n***done with no diffrence in count***\r\nAll\r\n#Add + Remove + apply to child branches + apply to schedule_station\r\n***done with no diffrence in count***\r\n\r\n\r\n\r\n\r\nSolution:\r\n1- copy add and remove branch or branches from admin to vendor\r\n2- modify them to add with color green and remove with color red without delete  \r\n3- remove sore_schedules related matters \r\n4- in accept case do tge following \r\n#remove store_schedules with confirmed 2\r\n# update store_schedules with confirmef 0 to be 1\r\n#clone databases \r\n5- in case of reject \r\n#remove store_schedules with confirmed 0\r\n# update store_schedules with confirmed 2 to be 1\r\n\r\nWhen adding schedules after accept or reject it add them to schedulesations and not to storeschedules\r\nramadan_schedule is 0 in schedulesations  and null in storeschedules !!!!!\r\n\r\nBig Note: in add or remove schedule function it doesnot see type in link an it doesnot see link of ramdan and rest in general. Only edit functions see them.\r\n\r\nupdate maping databases\r\nalloo\r\nadmin \r\nhttps://test.aloo.com.sa/ar/admin/vendor/branchs-working-days/190/rest\r\nhttps://test.aloo.com.sa/ar/admin/vendor/view/190\r\nApp\\Http\\Controllers\\Admin\\VendorController@add_schedule\r\nApp\\Http\\Controllers\\Admin\\VendorController@remove_schedule\r\nApp\\Http\\Controllers\\Admin\\VendorController@add_branches_schedule\r\nApp\\Http\\Controllers\\Admin\\VendorController@remove_branches_schedule\r\nApp\\Http\\Controllers\\Admin\\VendorController@editBranchWorkingDays\r\nApp\\Http\\Controllers\\Admin\\VendorController@editAllBranchsWorkingDaysRequest\r\n\r\nE:\\xampp\\htdocs\\Aloo\\Alloo-Live\\app\\Http\\Controllers\\Admin\\WorkingDaysRequestController.php\r\n\r\n\r\nvendor\r\nhttps://test.aloo.com.sa/ar/vendor-panel/branchs-working-days/190/rest\r\nadmin7@gmail.com\r\n123456789\r\nApp\\Http\\Controllers\\Vendor\\BusinessSettingsController@add_schedule\r\nApp\\Http\\Controllers\\Vendor\\BusinessSettingsController@remove_schedule\r\nApp\\Http\\Controllers\\Vendor\\VendorController@add_branches_schedule\r\nApp\\Http\\Controllers\\Vendor\\VendorController@remove_branches_schedule\r\nApp\\Http\\Controllers\\Vendor\\VendorController@editBranchWorkingDays\r\nApp\\Http\\Controllers\\Vendor\\VendorController@editAllBranchsWorkingDays\r\nE:\\xampp\\htdocs\\Aloo\\Alloo-Live\\app\\Http\\Controllers\\Vendor\\WorkingDaysRequestController.php\r\nselect * from store_schedule order by id desc limit 1;\r\nselect * from schedule_stations order by id desc limit 1;\r\n\r\nselect count(*) from store_schedule;\r\nselect count(*) from schedule_stations;\r\n\r\nselect * from schedule_stations where ramadan_schedule=0;\r\n select * from store_schedule where ramadan_schedule=0;\r\n\r\ntruncate table schedule_stations;\r\ntruncate table working_days_requests;\r\nphp artisan import:schedule\r\n\r\nfunction deleteBranchesSchedule(route) {\r\n\r\nEverything is good except for updating all store_schedule other branches when accept. It almost update mainbranch schedules only\r\n\r\npublic function accept($id)\r\n    {               \r\n\r\n        $workingDayRequest = workingDaysRequest::find($id);\r\n           \r\n        if ($workingDayRequest) {\r\n            DB::beginTransaction();\r\n            DB::statement(\'SET FOREIGN_KEY_CHECKS = 0;\');\r\n            try {\r\n                $workingDayRequest->reviewer_id = auth(\'admin\')->user()->id;\r\n                $workingDayRequest->status = \'accepted\';\r\n                $workingDayRequest->save();\r\n                DB::statement(\'SET FOREIGN_KEY_CHECKS = 1;\');\r\n                DB::commit();\r\n                $stores = Store::where(\'main_store_id\', $workingDayRequest->store_id)\r\n                ->with([\'schedule_stations\' => function ($query){\r\n                    $query->where(\'confirmed\',\'!=\',1);\r\n                    $query->withoutGlobalScope(\'withoutRamadan\');\r\n                }])->get();\r\n\r\n                foreach($stores as $store){\r\n                    foreach ($store->schedule_stations as $schedule){\r\n                        if($schedule->confirmed==0){\r\n                            $schedule->update([\'confirmed\'=>1]);\r\n                            StoreLogic::insert_schedule([$schedule->store_id], [$schedule->day], $schedule->opening_time, $schedule->closing_time . \':59\', $schedule->ramadan_schedule==1?\'ramadan\':\'rest\');\r\n                        }\r\n                       else if($schedule->confirmed==2){\r\n\r\n                        $type=$schedule->ramadan_schedule==1?\'ramadan\':\'rest\';\r\n                        $item = StoreSchedule::where(\'store_id\', $schedule->store_id)->withoutGlobalScope(\'withoutRamadan\') // Filter by store ID\r\n                        ->where(\'day\', $schedule->day) // Filter by day\r\n                        ->where(\'opening_time\', $schedule->opening_time) // Filter by day\r\n                        ->where(\'closing_time\', $schedule->closing_time) // Filter by day\r\n                        ->where(function ($query) use ($type) {\r\n                        $query->when($type == \'rest\', function ($q) {\r\n                            $q->whereNull(\'ramadan_schedule\');\r\n                        });\r\n                        $query->when($type == \'ramadan\', function ($q) {\r\n                            $q->where(\'ramadan_schedule\', 1);\r\n                        });\r\n                        })\r\n                        ->where(\'timezone\', $schedule->timezone) // Filter by timezone\r\n                        ->whereNotNull(\'country_id\') // Ensure country ID is not null\r\n                        ->orderBy(\'schedule_order\', \'asc\') // Sort by schedule order\r\n                        ->first();\r\n                        \r\n                        if(isset($item)){\r\n                               $item->delete();\r\n                               $schedule->delete();\r\n                           }\r\n    \r\n                       }\r\n                    }\r\n                }\r\n                \r\n                $store = Store::where(\'id\', $workingDayRequest->store_id)\r\n                ->with([\'schedule_stations\' => function ($query){\r\n                    $query->where(\'confirmed\',\'!=\',1);\r\n                    $query->withoutGlobalScope(\'withoutRamadan\');\r\n                }])->first();\r\n\r\n                foreach ($store->schedule_stations as $schedule){\r\n                    if($schedule->confirmed==0){\r\n                        $schedule->update([\'confirmed\'=>1]);\r\n                        StoreLogic::insert_schedule([$schedule->store_id], [$schedule->day], $schedule->opening_time, $schedule->closing_time . \':59\', $schedule->ramadan_schedule==1?\'ramadan\':\'rest\');\r\n                    }\r\n                   else if($schedule->confirmed==2){\r\n\r\n                    $type=$schedule->ramadan_schedule==1?\'ramadan\':\'rest\';\r\n                    $item = StoreSchedule::where(\'store_id\', $schedule->store_id)->withoutGlobalScope(\'withoutRamadan\') // Filter by store ID\r\n                    ->where(\'day\', $schedule->day) // Filter by day\r\n                    ->where(\'opening_time\', $schedule->opening_time) // Filter by day\r\n                    ->where(\'closing_time\', $schedule->closing_time) // Filter by day\r\n                    ->where(function ($query) use ($type) {\r\n                    $query->when($type == \'rest\', function ($q) {\r\n                        $q->whereNull(\'ramadan_schedule\');\r\n //  $q->orWhere(\'ramadan_schedule\',0);;\r\n                    });\r\n                    $query->when($type == \'ramadan\', function ($q) {\r\n                        $q->where(\'ramadan_schedule\', 1);\r\n                    });\r\n                    })\r\n                    ->where(\'timezone\', $schedule->timezone) // Filter by timezone\r\n                    ->whereNotNull(\'country_id\') // Ensure country ID is not null\r\n                    ->orderBy(\'schedule_order\', \'asc\') // Sort by schedule order\r\n                    ->first();\r\n                    \r\n                    if(isset($item)){\r\n\r\n                           $item->delete();\r\n                           $schedule->delete();\r\n                       }\r\n\r\n                   }\r\n                }\r\n\r\n\r\n                Toastr::success(__(\'messages.workingDayRequest_added_successfully\'));\r\n                return redirect()->route(\'admin.WorkingDaysRequest.list\');\r\n            } catch (\\Exception $ex) {\r\n                DB::rollBack();\r\n                Toastr::error($ex->getMessage());\r\n                return redirect()->back();\r\n            }\r\n        }\r\n\r\n        Toastr::error(__(\'messages.not_found\'));\r\n        return redirect()->back();\r\n    }',1,1,55,'2024-10-23 14:36:29','2024-12-15 19:19:49'),(691,'store timings permissions',NULL,1,1,55,'2024-10-23 14:36:29','2024-11-05 22:14:50'),(692,'Adjusting the api',NULL,1,3,28,'2024-10-23 16:55:18','2024-10-28 15:06:18'),(693,'Adjusting the api',NULL,1,5,28,'2024-10-23 16:55:18','2024-10-28 15:06:18'),(694,'Add startdate,enddate',NULL,1,1,55,'2024-10-23 17:27:24','2024-10-27 17:22:35'),(695,'add in discount dropdown to choose a category or all categories',NULL,1,1,55,'2024-10-23 17:27:24','2024-10-28 15:41:53'),(696,'Add to main branch ability to change a child branch or are children',NULL,1,1,55,'2024-10-23 17:27:24','2024-11-05 22:14:50'),(697,'Add number of people * trip price',NULL,1,5,10,'2024-10-23 21:56:29','2024-10-23 22:48:51'),(698,'Add table of trib detail under form ',NULL,0,11,10,'2024-10-23 22:48:22','2024-10-23 22:48:22'),(699,'Add table of trib detail under form ',NULL,0,11,10,'2024-10-23 22:48:22','2024-10-23 22:48:22'),(700,' add toaster',NULL,0,11,10,'2024-10-23 22:48:22','2024-10-23 22:48:22'),(701,' add toaster',NULL,0,11,10,'2024-10-23 22:48:22','2024-10-23 22:48:22'),(703,'upload gma and solve background issue',NULL,1,2,53,'2024-10-24 17:42:45','2024-10-24 20:12:30'),(704,'upload gma and solve background issue',NULL,1,3,53,'2024-10-24 17:42:45','2024-10-24 20:12:30'),(705,'Enable login and register using new api',NULL,0,12,56,'2024-10-24 17:54:38','2024-10-24 17:54:38'),(706,'Return home apis ',NULL,0,12,56,'2024-10-24 17:55:35','2024-10-24 17:55:35'),(707,' return all sent apis',NULL,0,12,56,'2024-10-24 17:55:35','2024-10-24 17:55:35'),(708,'learn postman from ibrahime',NULL,1,12,56,NULL,'2024-11-01 20:48:29'),(709,'Take money from clients',NULL,1,NULL,6,NULL,'2024-11-05 00:22:22'),(710,'Take money from clients',NULL,1,1,6,NULL,'2024-11-05 00:22:22'),(711,'Depit in wallets do not return',NULL,1,1,47,'2024-10-25 02:24:05','2024-10-28 15:06:46'),(712,'Depit in wallets do not return',NULL,1,3,47,'2024-10-25 02:24:05','2024-10-28 15:06:46'),(713,'Depit in wallets do not return',NULL,1,5,47,'2024-10-25 02:24:05','2024-10-28 15:06:46'),(714,'Error in edit news ',NULL,1,1,35,'2024-10-25 02:25:08','2024-10-28 15:06:10'),(715,'Error in edit news ',NULL,1,3,35,'2024-10-25 02:25:08','2024-10-28 15:06:10'),(716,'Error in edit news ',NULL,1,5,35,'2024-10-25 02:25:08','2024-10-28 15:06:10'),(717,'upload website',NULL,1,1,35,'2024-10-25 02:25:08','2024-10-25 02:25:08'),(718,'upload website',NULL,1,3,35,'2024-10-25 02:25:08','2024-10-25 02:25:08'),(719,'upload website',NULL,1,5,35,'2024-10-25 02:25:08','2024-10-25 02:25:08'),(720,'Add wallet transactions in all sessions cases',NULL,1,1,47,'2024-10-26 06:21:15','2024-11-05 00:06:08'),(721,'Remove time zone and language and country and proficency only from blades and requests',NULL,1,1,47,'2024-10-27 13:57:22','2024-10-28 15:06:12'),(722,'Remove time zone and language and country and proficency only from blades and requests',NULL,1,5,47,'2024-10-27 13:57:22','2024-10-28 15:06:12'),(723,'Order do not apply in dashboard from front',NULL,1,1,55,'2024-10-27 14:07:55','2024-10-29 14:06:26'),(724,'image and file document not working',NULL,1,1,20,'2024-10-28 15:08:03','2024-11-05 00:05:59'),(725,'when adding item it should take same discount of its category if it did not has discount',NULL,1,1,55,'2024-10-28 15:53:04','2024-11-07 21:19:17'),(726,'apply offers in order according to their typres',NULL,1,1,55,'2024-10-28 18:20:03','2024-11-05 18:10:55'),(727,'Dashboard order details total not right according to offer in red',NULL,1,1,55,'2024-10-29 14:05:47','2024-11-22 19:47:39'),(728,'Add static stats chats in home of yousab-tech for marketting matters',NULL,0,3,52,'2024-10-31 21:15:48','2024-10-31 21:15:48'),(729,'Fix medhat site upload',NULL,0,1,25,'2024-11-01 04:06:54','2024-11-01 04:06:54'),(730,'Buy mina trip',NULL,1,1,10,'2024-11-01 04:07:15','2024-11-02 02:27:42'),(731,'Subscribe not working ',NULL,1,1,41,'2024-11-01 04:34:41','2024-11-09 01:36:07'),(733,'',NULL,1,1,41,'2024-11-01 04:34:41','2024-12-07 05:06:30'),(736,'If indoor remove serving time',NULL,1,1,41,'2024-11-01 04:51:37','2024-11-04 18:22:21'),(737,'If indoor remove serving time',NULL,1,2,41,'2024-11-01 04:51:37','2024-11-04 18:22:21'),(738,' order from other restaurant in cart issue',NULL,1,1,41,'2024-11-01 04:51:37','2024-11-04 03:34:12'),(739,' order from other restaurant in cart issue',NULL,1,2,41,'2024-11-01 04:51:37','2024-11-04 03:34:12'),(742,'Update egypttourism front',NULL,0,3,10,'2024-11-02 02:29:40','2024-11-02 02:29:40'),(743,'Make select all option',NULL,1,1,55,'2024-11-02 17:52:51','2024-11-05 18:17:16'),(744,' Reserve in slots reserved not appear',NULL,1,2,41,'2024-11-04 01:59:15','2024-11-04 18:22:21'),(745,'cashback limit should be enables if percentage only and in case of percentage it may be optional',NULL,1,1,55,'2024-11-04 16:38:50','2024-11-05 00:05:18'),(746,'check if discount is applied on total products prices or total preva and delivery',NULL,1,1,55,'2024-11-04 16:38:50','2024-11-05 00:05:18'),(747,'delivery discount is applied directly from input data without any additional deuction',NULL,1,1,55,'2024-11-04 16:38:50','2024-11-05 16:48:23'),(748,'offers should not return if expired or not active of interval time',NULL,1,1,55,'2024-11-04 16:38:50','2024-11-07 18:30:12'),(749,'return min cashback if percentage',NULL,1,1,55,'2024-11-04 18:15:45','2024-11-05 00:05:18'),(750,'return max-fund in single store offer',NULL,1,1,55,'2024-11-04 19:01:20','2024-11-05 00:05:18'),(751,'checkbox as latest in home api',NULL,0,1,35,'2024-11-04 23:57:09','2024-11-04 23:57:09'),(752,'news and essay modules add a filter to choose category and subcategory to edit on them',NULL,0,1,35,'2024-11-04 23:57:09','2024-11-04 23:57:09'),(753,'make max-fund required when appears',NULL,1,1,55,'2024-11-05 15:09:40','2024-11-05 18:16:54'),(754,'No one is allowed to reset the table for reservations.',NULL,1,1,41,'2024-11-05 16:29:58','2024-12-21 15:43:42'),(755,'No one is allowed to reset the table for reservations.',NULL,1,3,41,'2024-11-05 16:29:58','2024-12-21 15:43:42'),(756,'apply select all as backend',NULL,1,1,55,'2024-11-05 18:17:34','2024-11-07 21:15:31'),(757,'branches appointments fixing and enabling permissions',NULL,1,1,55,'2024-11-05 22:16:11','2024-11-16 18:47:11'),(758,'in offer edit it do not validate the enterfarance of time interval',NULL,1,1,55,'2024-11-06 03:36:51','2024-11-06 16:21:34'),(759,'in stores-offers/create there is a problem in hiding max-fund',NULL,1,1,55,'2024-11-06 03:57:44','2024-11-06 16:21:34'),(760,'discount may not be applied on categories products only check it',NULL,1,1,55,'2024-11-06 03:58:17','2024-11-06 16:21:34'),(761,'avaliable order should be the latest order in list',NULL,1,1,55,'2024-11-06 15:13:35','2024-11-07 18:38:57'),(762,'when adding discount we have to do dblclick',NULL,1,1,55,'2024-11-06 17:33:04','2024-11-07 18:29:48'),(763,' in order detail discount order 0 add $',NULL,1,1,55,'2024-11-06 17:33:04','2024-11-07 18:29:48'),(764,'in discount when update or delete we should apply this change on all categories products that relate to them',NULL,1,1,55,'2024-11-06 18:24:56','2024-11-07 18:55:42'),(765,' lates issue that abdullah told me about',NULL,1,1,55,'2024-11-06 18:24:56','2024-11-07 18:42:03'),(766,'always make sure thatr discount is on products only and offers on stores',NULL,1,1,55,'2024-11-06 18:27:21','2024-11-07 18:32:20'),(767,'Add device vaمبروك! جالك خصم 25% على جميييع المنتجات من كازيون علشان انت على باقة فري ماكس، بحد أقصى 50 جنيه! كود الخصم 075385162  صالح لمدة 14 يومlue and device percentage in editbranch',NULL,1,1,6,'2024-11-07 00:43:11','2024-11-07 00:45:52'),(768,'Add device value and device percentage in editbranch',NULL,1,1,55,'2024-11-07 00:45:31','2024-12-25 00:51:25'),(769,'مبروك! جالك خصم  على جميييع المنتجات من كازيون علشان انت على باقة فري ماكس، بحد أقصى 50 جنيه! كود الخصم 075385162  صالح لمدة 14 يوم بدء من 6/11/2025',NULL,0,1,6,'2024-11-07 00:47:06','2024-11-07 00:47:06'),(770,'add boolean isIn in resevationmeals to show if meal is requested when customer is in restaurant',NULL,1,3,41,'2024-11-09 01:16:37','2024-11-10 00:30:29'),(771,'add boolean isIn in resevationmeals to show if meal is requested when customer is in restaurant',NULL,1,10,41,'2024-11-09 01:16:37','2024-11-10 00:30:29'),(772,' meals required from resgtaurant should be shown in a sidebar option called inrestaurant reservations',NULL,1,3,41,'2024-11-09 01:16:37','2024-11-12 22:32:43'),(773,' meals required from resgtaurant should be shown in a sidebar option called inrestaurant reservations',NULL,1,10,41,'2024-11-09 01:16:37','2024-11-12 22:32:43'),(774,'if subscribed show button as subscribed not subscribe',NULL,1,3,41,'2024-11-09 01:16:37','2024-11-12 00:47:00'),(775,'if subscribed show button as subscribed not subscribe',NULL,1,10,41,'2024-11-09 01:16:37','2024-11-12 00:47:00'),(776,'make stories dynamic',NULL,1,3,41,'2024-11-09 01:16:37','2024-11-10 00:30:16'),(777,'make stories dynamic',NULL,1,10,41,'2024-11-09 01:16:37','2024-11-10 00:30:16'),(778,'add chat to restaurant',NULL,1,3,41,'2024-11-09 01:24:44','2024-11-24 05:29:22'),(779,'add chat to restaurant',NULL,1,10,41,'2024-11-09 01:24:44','2024-11-24 05:29:22'),(780,'Change colors according to color palette',NULL,1,2,41,'2024-11-09 01:35:39','2024-11-09 01:36:15'),(781,'Store/16 add restaurant logo',NULL,1,2,41,'2024-11-09 01:35:50','2024-11-09 16:07:09'),(782,'Make slider be created by adding multi locations and multi categories',NULL,1,1,41,'2024-11-09 01:36:39','2024-11-12 21:27:34'),(783,'Make slider be created by adding multi locations and multi categories',NULL,1,3,41,'2024-11-09 01:36:39','2024-11-12 21:27:34'),(784,'Make slider be created by adding multi locations and multi categories',NULL,1,10,41,'2024-11-09 01:36:39','2024-11-12 21:27:34'),(785,'Make slider be created by adding multi locations and multi categories',NULL,1,1,41,'2024-11-09 01:36:39','2024-11-12 21:27:34'),(786,'Make slider be created by adding multi locations and multi categories',NULL,1,3,41,'2024-11-09 01:36:39','2024-11-12 21:27:34'),(787,'Make slider be created by adding multi locations and multi categories',NULL,1,10,41,'2024-11-09 01:36:39','2024-11-12 21:27:34'),(788,'show and donot show cost should be enabled in front ',NULL,1,2,41,'2024-11-09 01:37:43','2024-11-12 00:24:45'),(789,'show and donot show cost should be enabled in front ',NULL,1,10,41,'2024-11-09 01:37:43','2024-11-12 00:24:45'),(790,'show and donot show cost should be enabled in front ',NULL,1,2,41,'2024-11-09 01:37:43','2024-11-12 00:24:45'),(791,'show and donot show cost should be enabled in front ',NULL,1,10,41,'2024-11-09 01:37:43','2024-11-12 00:24:45'),(792,'show and donot show cost should be enabled in front ',NULL,1,2,41,'2024-11-09 01:37:43','2024-11-12 00:24:45'),(793,'show and donot show cost should be enabled in front ',NULL,1,10,41,'2024-11-09 01:37:43','2024-11-12 00:24:45'),(794,'Backtotop design on mobile screen',NULL,0,1,10,'2024-11-09 08:39:21','2024-11-09 08:39:21'),(795,'Email missing data',NULL,0,1,10,'2024-11-09 08:40:25','2024-11-09 08:40:25'),(796,'Email missing data',NULL,0,3,10,'2024-11-09 08:40:25','2024-11-09 08:40:25'),(797,'editing styles according to color pallete',NULL,1,2,41,'2024-11-09 20:24:16','2024-11-09 20:24:28'),(798,' making contact us dynamic',NULL,1,2,41,'2024-11-09 20:24:16','2024-11-09 20:24:28'),(799,' making waiter options dynamic',NULL,1,2,41,'2024-11-09 20:24:16','2024-11-09 20:24:28'),(800,' making pagination dynamic',NULL,1,2,41,'2024-11-09 20:24:16','2024-11-09 20:24:28'),(801,'making restaurant profile in restaurant chat dynamic',NULL,1,2,41,'2024-11-09 20:26:22','2024-11-09 20:26:32'),(802,'fixing subscrible issue',NULL,1,2,41,'2024-11-09 23:45:09','2024-11-09 23:45:24'),(803,'editing breadcrumb to go to previous page',NULL,1,2,41,'2024-11-09 23:45:09','2024-11-09 23:45:24'),(804,'fixing subscrible issue',NULL,1,2,41,'2024-11-09 23:45:11','2024-11-09 23:45:24'),(805,'editing breadcrumb to go to previous page',NULL,1,2,41,'2024-11-09 23:45:11','2024-11-09 23:45:24'),(806,'categories display wrong meals',NULL,1,2,41,'2024-11-12 00:22:24','2024-11-12 22:31:57'),(807,'categories display wrong meals',NULL,1,3,41,'2024-11-12 00:22:24','2024-11-12 22:31:57'),(808,'categories display wrong meals',NULL,1,10,41,'2024-11-12 00:22:24','2024-11-12 22:31:57'),(812,'add comment in ingredits extra',NULL,1,2,41,'2024-11-12 00:22:58','2024-11-12 21:52:35'),(813,'add comment in ingredits extra',NULL,1,3,41,'2024-11-12 00:22:58','2024-11-12 21:52:35'),(814,'add comment in ingredits extra',NULL,1,10,41,'2024-11-12 00:22:58','2024-11-12 21:52:35'),(815,'search homepage should display the restuarant name and image',NULL,1,2,41,'2024-11-12 00:24:31','2024-11-17 06:28:17'),(816,'search homepage should display the restuarant name and image',NULL,1,3,41,'2024-11-12 00:24:31','2024-11-17 06:28:17'),(817,'search homepage should display the restuarant name and image',NULL,1,10,41,'2024-11-12 00:24:31','2024-11-17 06:28:17'),(824,'indoor out door seating in restaurant should be dynamic',NULL,1,2,41,'2024-11-12 00:24:31','2024-11-12 21:27:28'),(825,'indoor out door seating in restaurant should be dynamic',NULL,1,3,41,'2024-11-12 00:24:31','2024-11-12 21:27:28'),(826,'indoor out door seating in restaurant should be dynamic',NULL,1,10,41,'2024-11-12 00:24:31','2024-11-12 21:27:28'),(833,'change in restaurant profile openhour close hour to time instead of date',NULL,1,3,41,'2024-11-12 00:36:35','2024-11-12 17:09:20'),(834,'change in restaurant profile openhour close hour to time instead of date',NULL,1,5,41,'2024-11-12 00:36:35','2024-11-12 17:09:20'),(835,'add cusine type others',NULL,1,3,41,'2024-11-12 00:36:35','2024-11-12 15:33:42'),(836,'add cusine type others',NULL,1,5,41,'2024-11-12 00:36:35','2024-11-12 15:33:42'),(837,'add Is on app yes or no to show restuarant on reservya app or not ',NULL,1,3,41,'2024-11-12 00:36:35','2024-11-23 20:33:32'),(838,'add Is on app yes or no to show restuarant on reservya app or not ',NULL,1,5,41,'2024-11-12 00:36:35','2024-11-23 20:33:32'),(839,'In category create restaurant profile returned wrong',NULL,1,3,41,'2024-11-12 00:36:35','2024-11-12 15:33:58'),(840,'In category create restaurant profile returned wrong',NULL,1,5,41,'2024-11-12 00:36:35','2024-11-12 15:33:58'),(841,' kitchen view orders should be displayed before its estimated time',NULL,1,3,41,'2024-11-12 00:36:35','2024-12-19 17:39:04'),(842,' kitchen view orders should be displayed before its estimated time',NULL,1,5,41,'2024-11-12 00:36:35','2024-12-19 17:39:04'),(843,' Show daily reservation for restaurant',NULL,1,3,41,'2024-11-12 00:36:35','2024-11-13 17:47:07'),(844,' Show daily reservation for restaurant',NULL,1,5,41,'2024-11-12 00:36:35','2024-11-13 17:47:07'),(845,' Ingredients comment backend',NULL,1,3,41,'2024-11-12 00:36:35','2024-11-12 16:38:07'),(846,' Ingredients comment backend',NULL,1,5,41,'2024-11-12 00:36:35','2024-11-12 16:38:07'),(847,' Ingredients not customized in dashboard',NULL,1,3,41,'2024-11-12 00:36:35','2024-11-12 15:30:52'),(848,' Ingredients not customized in dashboard',NULL,1,5,41,'2024-11-12 00:36:35','2024-11-12 15:30:52'),(849,' Estimated time should be in minutes',NULL,1,3,41,'2024-11-12 00:36:35','2024-11-12 17:31:28'),(850,' Estimated time should be in minutes',NULL,1,5,41,'2024-11-12 00:36:35','2024-11-12 17:31:28'),(851,' Reservation time should be >= Estimated time',NULL,1,3,41,'2024-11-12 00:36:35','2024-12-19 17:39:04'),(852,' Reservation time should be >= Estimated time',NULL,1,5,41,'2024-11-12 00:36:35','2024-12-19 17:39:04'),(853,'Test1',NULL,1,1,6,'2024-11-12 01:28:24','2024-11-12 01:28:40'),(854,'Test2',NULL,1,1,6,'2024-11-12 01:28:24','2024-11-12 01:28:40'),(855,'Add discount to purchase',NULL,1,1,20,'2024-11-12 06:14:28','2024-12-07 18:16:10'),(856,'Add discount to purchase',NULL,1,3,20,'2024-11-12 06:14:28','2024-12-07 18:16:10'),(857,' fix sales filter',NULL,1,1,20,'2024-11-12 06:14:28','2024-11-22 20:05:24'),(858,' fix sales filter',NULL,1,3,20,'2024-11-12 06:14:28','2024-11-22 20:05:24'),(859,' add filrer to comissions',NULL,1,1,20,'2024-11-12 06:14:28','2024-11-22 20:05:24'),(860,' add filrer to comissions',NULL,1,3,20,'2024-11-12 06:14:28','2024-11-22 20:05:24'),(861,'revise filters',NULL,1,1,20,'2024-11-12 06:14:28','2024-11-22 20:05:24'),(862,'revise filters',NULL,1,3,20,'2024-11-12 06:14:28','2024-11-22 20:05:24'),(863,' test adding sales from mobile',NULL,1,1,20,'2024-11-12 06:14:28','2024-12-07 18:16:10'),(864,' test adding sales from mobile',NULL,1,3,20,'2024-11-12 06:14:28','2024-12-07 18:16:10'),(865,'Translate french in in mjaret elsmaa',NULL,1,1,55,'2024-11-12 15:34:22','2024-11-22 19:47:27'),(866,'add stettle data to excel and to calculations',NULL,1,1,55,'2024-11-12 15:34:22','2024-11-16 18:47:11'),(867,' workingdayrequest in appointments',NULL,1,1,55,'2024-11-12 15:34:22','2024-11-16 18:47:11'),(868,'responsive in medium devices not working',NULL,1,2,41,'2024-11-12 18:02:38','2024-11-13 01:16:19'),(869,'responsive in medium devices not working',NULL,1,2,41,'2024-11-12 18:02:38','2024-11-13 01:16:19'),(870,'responsive in medium devices not working',NULL,1,2,41,'2024-11-12 18:02:38','2024-11-13 01:16:19'),(871,'ai selection cards should be like the ones inside locations,category page',NULL,1,2,41,'2024-11-12 18:02:38','2024-11-12 20:17:43'),(872,'ai selection cards should be like the ones inside locations,category page',NULL,1,2,41,'2024-11-12 18:02:38','2024-11-12 20:17:43'),(873,'ai selection cards should be like the ones inside locations,category page',NULL,1,2,41,'2024-11-12 18:02:38','2024-11-12 20:17:43'),(874,'remove bg in ai selection',NULL,1,2,41,'2024-11-12 18:02:38','2024-11-12 19:03:44'),(875,'remove bg in ai selection',NULL,1,2,41,'2024-11-12 18:02:38','2024-11-12 19:03:44'),(876,'remove bg in ai selection',NULL,1,2,41,'2024-11-12 18:02:38','2024-11-12 19:03:44'),(877,'add terms and conditions',NULL,1,2,41,'2024-11-12 18:02:38','2024-11-12 18:26:46'),(878,'add terms and conditions',NULL,1,2,41,'2024-11-12 18:02:38','2024-11-12 18:26:46'),(879,'add terms and conditions',NULL,1,2,41,'2024-11-12 18:02:38','2024-11-12 18:26:46'),(880,'instagram,facebook,linkedin should at least input one of them',NULL,1,2,41,'2024-11-12 18:02:38','2024-11-13 00:15:07'),(881,'instagram,facebook,linkedin should at least input one of them',NULL,1,2,41,'2024-11-12 18:02:38','2024-11-13 00:15:07'),(882,'instagram,facebook,linkedin should at least input one of them',NULL,1,2,41,'2024-11-12 18:02:38','2024-11-13 00:15:07'),(883,'logo need adjustment',NULL,1,1,20,'2024-11-15 22:49:43','2024-11-22 20:00:10'),(884,'logo need adjustment',NULL,1,3,20,'2024-11-15 22:49:43','2024-11-22 20:00:10'),(885,'add preloader in admins',NULL,1,1,20,'2024-11-15 22:49:43','2024-11-22 20:00:10'),(886,'add preloader in admins',NULL,1,3,20,'2024-11-15 22:49:43','2024-11-22 20:00:10'),(887,'search in select',NULL,1,1,20,'2024-11-15 22:49:43','2024-12-07 05:14:43'),(888,'search in select',NULL,1,3,20,'2024-11-15 22:49:43','2024-12-07 05:14:43'),(889,'in sales return it does not retunr patch quantiti and need to return discount',NULL,1,1,20,'2024-11-15 22:49:43','2024-12-07 05:16:37'),(890,'in sales return it does not retunr patch quantiti and need to return discount',NULL,1,3,20,'2024-11-15 22:49:43','2024-12-07 05:16:37'),(891,' when deleting sales return it should affect on sales itself',NULL,1,1,20,'2024-11-15 22:49:43','2024-12-07 18:16:10'),(892,' when deleting sales return it should affect on sales itself',NULL,1,3,20,'2024-11-15 22:49:43','2024-12-07 18:16:10'),(893,'design of tables is expanded leeading to bad resbonsive',NULL,1,1,20,'2024-11-15 22:49:43','2024-11-22 20:00:10'),(894,'design of tables is expanded leeading to bad resbonsive',NULL,1,3,20,'2024-11-15 22:49:43','2024-11-22 20:00:10'),(895,'add in sales work only one time',NULL,1,1,20,'2024-11-15 22:49:43','2024-12-07 05:14:58'),(896,'add in sales work only one time',NULL,1,3,20,'2024-11-15 22:49:43','2024-12-07 05:14:58'),(897,'reports',NULL,1,1,20,'2024-11-15 22:49:43','2024-12-07 05:16:26'),(898,'reports',NULL,1,3,20,'2024-11-15 22:49:43','2024-12-07 05:16:26'),(899,'ask hassan how to update withdraw_able_balance',NULL,1,1,55,'2024-11-16 06:50:05','2024-11-22 19:49:25'),(900,'discount validation if price less than discount',NULL,1,1,55,'2024-11-16 06:50:05','2024-11-17 05:04:46'),(901,' Required if entered one of discount inputs in items',NULL,1,1,55,'2024-11-16 06:50:05','2024-11-17 19:36:42'),(902,'make offer or discount in orders stored statically',NULL,1,1,55,'2024-11-16 06:50:05','2024-11-17 18:02:39'),(903,'Add search same as restaurants in other modules',NULL,1,1,41,'2024-11-17 02:40:08','2024-11-24 20:05:25'),(904,'Add search same as restaurants in other modules',NULL,1,3,41,'2024-11-17 02:40:08','2024-11-24 20:05:25'),(905,'waiter will appear for him notifications or waiters options only',NULL,1,1,41,'2024-11-17 02:40:08','2024-11-24 05:30:03'),(906,'waiter will appear for him notifications or waiters options only',NULL,1,3,41,'2024-11-17 02:40:08','2024-11-24 05:30:03'),(907,'Kitchen will appear for it orders only and makereservations',NULL,1,1,41,'2024-11-17 02:40:08','2024-11-24 05:30:03'),(908,'Kitchen will appear for it orders only and makereservations',NULL,1,3,41,'2024-11-17 02:40:08','2024-11-24 05:30:03'),(909,' add stats to restaurant admin and especially reservation that are not confirmed and subscribers',NULL,0,1,41,'2024-11-17 02:40:08','2024-11-17 02:40:08'),(910,' add stats to restaurant admin and especially reservation that are not confirmed and subscribers',NULL,0,3,41,'2024-11-17 02:40:08','2024-11-17 02:40:08'),(911,'if in restaurant and there are two persons both of them can order and has split cheque',NULL,1,1,41,'2024-11-17 02:40:08','2024-12-21 15:43:42'),(912,'if in restaurant and there are two persons both of them can order and has split cheque',NULL,1,3,41,'2024-11-17 02:40:08','2024-12-21 15:43:42'),(913,'add isVisible to restaurants',NULL,1,1,41,'2024-11-17 02:40:08','2024-11-23 19:40:30'),(914,'add isVisible to restaurants',NULL,1,3,41,'2024-11-17 02:40:08','2024-11-23 19:40:30'),(917,'Check if offers has any errors ',NULL,1,1,55,'2024-11-17 16:19:35','2024-11-17 16:22:02'),(918,' check if missing anything in offers',NULL,1,1,55,'2024-11-17 16:19:35','2024-11-22 19:48:45'),(919,'translate discount validations',NULL,1,1,55,'2024-11-17 16:19:35','2024-11-22 19:49:08'),(920,'tell ali how long it take for adding discounts in settle excel',NULL,1,1,55,'2024-11-17 16:19:35','2024-11-17 17:57:16'),(921,'Translate untranslated words over all site',NULL,1,1,55,'2024-11-17 16:21:30','2024-11-23 02:04:36'),(922,'Check for static offer and discount in orders',NULL,1,1,55,'2024-11-17 16:38:06','2024-11-17 19:36:25'),(923,'Revise offer details accuracy and apply discount inside it',NULL,1,1,55,'2024-11-22 19:51:23','2024-12-06 20:14:27'),(924,'select all in edit items not working',NULL,1,1,55,'2024-11-22 19:51:23','2024-11-23 02:03:51'),(925,'discount in stores need to apply',NULL,1,1,55,'2024-11-22 19:51:23','2024-12-06 20:14:27'),(926,' Add middlwears to mjaret elsmaa',NULL,1,1,55,'2024-11-22 19:51:23','2024-12-06 20:14:27'),(928,'Filter(fix sales,comission,revise)',NULL,1,1,20,'2024-11-22 20:06:06','2024-12-07 18:26:57'),(929,'Calculate total income of reservia in each restaurant',NULL,0,1,39,'2024-11-23 16:17:37','2024-11-23 16:17:37'),(930,'Calculate total income of reservia in each restaurant',NULL,0,3,39,'2024-11-23 16:17:37','2024-11-23 16:17:37'),(931,'hide controls here except for show https://yousab-tech.com/ReservyaDashboardPortal/public/en/dashboard/restaurants ',NULL,1,3,39,'2024-11-23 18:02:18','2024-11-23 20:19:31'),(932,' SittingTime: 00:30 hours is not dynamic in makereservations',NULL,1,3,39,'2024-11-23 18:02:18','2024-12-19 17:38:35'),(933,' translate the website',NULL,1,3,39,'2024-11-23 18:02:18','2024-11-23 19:40:07'),(934,'add permsiions to restaurant to control allowing reservation pickups and hangout',NULL,1,2,41,'2024-11-23 19:41:18','2024-11-23 20:23:49'),(935,'add permsiions to restaurant to control allowing reservation pickups and hangout',NULL,1,2,41,'2024-11-23 19:41:18','2024-11-23 20:23:49'),(936,'رقم سعودى والمتجر فى مصر .... عند طلب اوردر لديه خصم يظهر القيمه التى تم تحصيلها من العميل فى الداش بورد مختلفه عن الظاهره عل الapp   Revise offer details accuracy and apply offerinside it','start https://test.aloo.com.sa/ar/admin/vendor/view/815\r\nstart https://test.aloo.com.sa/ar/admin/order/details/110043\r\nstart https://test.aloo.com.sa/ar/admin/order/report-search\r\nApp\\Http\\Controllers\\Admin\\OrderController@reportSearch\r\ncode E:\\xampp\\htdocs\\Aloo\\Alloo-Live\\resources\\views\\admin-views\\order\\report-search.blade.php\r\ncode E:\\xampp\\htdocs\\Aloo\\Alloo-Live\\resources\\views\\partials\\admin-views\\order\\order-view\\_order-tab-main.blade.php\r\n    public function place_order(Request $request)\r\n    {\r\nfunction applyOffer($offer){',1,1,55,'2024-12-06 20:12:11','2024-12-08 17:05:11'),(937,'رقم سعودى والمتجر فى مصر .... عند طلب اوردر لديه خصم يظهر القيمه التى تم تحصيلها من العميل فى الداش بورد مختلفه عن الظاهره عل الapp   Revise offer details accuracy and apply offerinside it','start https://test.aloo.com.sa/ar/admin/vendor/view/815\r\nstart https://test.aloo.com.sa/ar/admin/order/details/110043\r\nstart https://test.aloo.com.sa/ar/admin/order/report-search\r\nApp\\Http\\Controllers\\Admin\\OrderController@reportSearch\r\ncode E:\\xampp\\htdocs\\Aloo\\Alloo-Live\\resources\\views\\admin-views\\order\\report-search.blade.php\r\ncode E:\\xampp\\htdocs\\Aloo\\Alloo-Live\\resources\\views\\partials\\admin-views\\order\\order-view\\_order-tab-main.blade.php\r\n    public function place_order(Request $request)\r\n    {\r\nfunction applyOffer($offer){',1,1,55,'2024-12-06 20:13:46','2024-12-08 17:05:11'),(938,'عند ادخال جهازين قيمه الاول 3000 ونسبته 10 % ف متجر .. واخر قيمته 4000 ونسبته 20 % .... عند التسويه للمره الثانيه يظهر كانه يقوم بالتسويه ك اول مره ولا تقل القيمه الكليه للاجهزه ولا يظهر القيمه المتبقية من تسويه فى الخصومات الحاليه نتيجه ان قيمه المستحقه من تحصل الاجهزه اكبر من قيمه الرصيد القابل للسحب ويظهر فى الملف القيم السابقه ف اول تسوية','start https://test.aloo.com.sa/ar/admin/vendor/view/815\r\nstart https://test.aloo.com.sa/ar/admin/WorkingDaysRequest/list\r\n\r\nApp\\Http\\Controllers\\Admin\\VendorController@settle_report\r\n    public function settle_report($id)\r\n    {\r\n    public static function format_export_settle_report($orders, $comission, $mainStore_id)\r\n    {\r\n\r\ncode E:\\xampp\\htdocs\\Aloo\\Alloo-Live\\app\\CentralLogics\\V2\\store.php\r\n\r\nprice_after_deductions\r\n\r\nmain_store_id=815\r\n\r\nselect id,device_value,device_rest,device_percent from stores where main_store_id=815;\r\nupdate stores set device_rest=device_value where id>981;\r\nhere where I update the store deductions that appear in excel\r\n $totals[\'price_after_deductions\'] -= $array[0] - $totals[\'res_bears_value\'];',1,1,55,'2024-12-06 20:13:46','2024-12-09 17:07:19'),(939,'add discounts and offers to deductions','تاجر - ( بيت الشاورما )\r\nmysqldump -u root -p aloo_test_db > aloo_test_db_export.sql\r\nmysql -u root -p aloo_test_db < /var/www/html/Alloo-Live/aloo_test_db_export.sql\r\n\r\n\r\nالخصومات هتبقي مستحقات اخري \r\nجرب التعويض\r\nتعويض من الطرفين \r\n\r\ncredit=المتسبب\r\ndebit=اللي علي حق\r\n\r\nلو المتسبب العميل\r\nلو المتسسب المطعم تنزل في التعويضات \r\nلو المتسبب العميل يبقا مستحقات اخري \r\nلو المتسبب الو نشوف مطعم ولا عميل وتنزله \r\nعناصر مفقودة علي المطعم \r\n\r\n                                        <div class=\"col-md-4 mb-4\">\r\n                                            <div class=\"d-flex align-items-center\">\r\n                                                <div class=\"badge rounded-pill bg-label-success me-3 p-2\"><i\r\n                                                        class=\"ti ti-report-money ti-sm\"></i></div>\r\n                                                <div class=\"card-info\">\r\n                                                    <h5 class=\"mb-0\">\r\n                                                        {{ number_format($wallet->balance, 2, \'.\', \'\') }}\r\n                                                    </h5>\r\n                                                    <small>@lang(\'messages.withdraw_able_balance\')</small>\r\n                                                </div>\r\n                                            </div>\r\n                                        </div>\r\n\r\nselect id,order_status from orders order by id desc limit 1;\r\nSELECT TABLE_NAME, COLUMN_NAME, DATA_TYPE\r\nFROM INFORMATION_SCHEMA.COLUMNS\r\nWHERE TABLE_SCHEMA = \'aloo\' \r\n  AND COLUMN_NAME LIKE \'%balance%\'\r\nORDER BY TABLE_NAME;\r\nUPDATE orders \r\nJOIN (SELECT id FROM orders ORDER BY id DESC LIMIT 1) AS temp_table \r\nON orders.id = temp_table.id\r\nSET orders.order_status = \'pending\';\r\n\r\n\r\nissue is here \r\n            $res_bears_value = !in_array($order->order_status, [\'canceled\', \'failed\', \'refunded\'])\r\n            ? floatval($order->offer_discount_value) * (isset($order->offer) ? floatval($order->offer->res_bears_percent) : 0) / 100 + floatval($order->store_discount_amount)\r\n            : 0;\r\n\r\n\r\n1-check price after deductions value \r\nIf postive ad to his balance if negative add to his debits in wallet \r\n2- prevent balance to be negative \r\n3- \r\n\r\nWithrwal amount should not be in negative so when settle handle it\r\n\r\nTesting \r\n\r\nDiscount\r\n#Fixed - percent\r\n\r\nOffer \r\n#Delivery - order - cashback \r\n#Fixed - percent \r\n\r\nAplly their total in deductions\r\n\r\nstart https://test.aloo.com.sa/ar/admin/vendor/view/815\r\nstart https://test.aloo.com.sa/ar/admin/WorkingDaysRequest/list\r\n\r\nApp\\Http\\Controllers\\Admin\\VendorController@settle_report\r\n    public function settle_report($id)\r\n    {\r\n    public static function format_export_settle_report($orders, $comission, $mainStore_id)\r\n    {\r\n\r\n    public function place_order(Request $request)\r\n    {\r\n\r\nStoreSettle::create([\r\n    public function place_order(Request $request)\r\n    {\r\n\r\nfunction applyOffer(\r\n\r\n    public function place_order(Request $request)\r\n    {\r\n\r\n\r\nforeach ($cartList as $c) {\r\n$product_price\r\n\r\ncode E:\\xampp\\htdocs\\Aloo\\Alloo-Live\\app\\CentralLogics\\V2\\store.php\r\n\r\nprice_after_deductions\r\n\r\nmain_store_id=815\r\n\r\nselect id,device_value,device_rest,device_percent from stores where main_store_id=815;\r\nupdate stores set device_rest=device_value where id>981;\r\nhere where I update the store deductions that appear in excel\r\n $totals[\'price_after_deductions\'] -= $array[0] - $totals[\'res_bears_value\'];\r\n$store_discount_amount += $or_d[\'discount_on_item\']\r\n\r\nstart https://test.aloo.com.sa/ar/admin/vendor/view/815\r\nstart https://test.aloo.com.sa/ar/admin/order/details/110043\r\nstart https://test.aloo.com.sa/ar/admin/order/report-search\r\nApp\\Http\\Controllers\\Admin\\OrderController@reportSearch\r\ncode E:\\xampp\\htdocs\\Aloo\\Alloo-Live\\resources\\views\\admin-views\\order\\report-search.blade.php\r\ncode E:\\xampp\\htdocs\\Aloo\\Alloo-Live\\resources\\views\\partials\\admin-views\\order\\order-view\\_order-tab-main.blade.php\r\n\r\n\r\n1- add all deductions comes from offers and discounts with res_bears_percent to wallet deductions \r\n2- in settlement if price_after_deduction is negative add it to wallet deductions\r\naloo_bears_percent\r\nres_bears_percent\r\nmax_fund \r\nmin_purchase  \r\nstore_id   \r\ntype\r\nvalue\r\nvalue_type\r\n\r\nMost important keywords: offer_discount_value, order_amount, coupon_discount_amount  : using them you can do this task easily\r\n\r\nDatabase \r\norders\r\naccepted accept_schedule adjusment aloo_bears_value app_revenue callback canceled cancel_reason cancel_type charge_payer checked confirmed country_id coupon_code coupon_discount_amount coupon_discount_title date_sent_to_store delivered delivery_address delivery_address_id delivery_charge delivery_man_id delivery_time distance dm_tips edited failed free_delivery_by gift_accepted_at gift_delivery_address gift_phone gift_rejected_at gift_sender_name gift_status gift_zone handover has_sent increased_order_amount invoice_attachment is_gift is_sent_to_store messing_items module_id offer_discount_value offer_id offer_type order_amount order_attachment order_code order_note order_status order_type original_delivery_charge otp paid_at parcel_category_id payment_code payment_method payment_method_amount payment_name payment_status pending phone picked_up prev_comp processing receiver_details refunded refund_reason refund_requested res_bears_value scheduled schedule_at sendNot send_majratalsama shop_revenue store_discount_amount store_id timezone total_tax_amount transaction_reference user_id user_package_delivery_fees user_package_id wallet_amount zone_id\r\norder_delivery_histories\r\n\r\norder_details\r\nadd_ons country_id discount_on_item discount_type item_campaign_id item_details item_id note oldPrice order_id price quantity tax_amount timezone total_add_on_price variant variation\r\n\r\ncompensations\r\nadmin_action admin_id amount checked country_id credit credit_type debit financial_action financial_action1 financial_action2 financial_audit increase_value items note order_id reason_type rejected_reason timezone\r\n\r\nin case of cahback percengt it save  offer_discount_value , order_amount  in half\r\nthe issue is that it count order_amount wrongly in case of cashback percent\r\naccording to abdullah\r\nخصم المنتجات خصم الكوبون خصم العرض',1,1,55,'2024-12-06 20:13:46','2024-12-25 00:51:00'),(940,'Revise offer details accuracy and apply offerinside it ','start https://test.aloo.com.sa/ar/admin/vendor/view/815\r\nstart https://test.aloo.com.sa/ar/admin/order/details/110043\r\nstart https://test.aloo.com.sa/ar/admin/order/report-search\r\nApp\\Http\\Controllers\\Admin\\OrderController@reportSearch\r\ncode E:\\xampp\\htdocs\\Aloo\\Alloo-Live\\resources\\views\\admin-views\\order\\report-search.blade.php\r\ncode E:\\xampp\\htdocs\\Aloo\\Alloo-Live\\resources\\views\\partials\\admin-views\\order\\order-view\\_order-tab-main.blade.php\r\n    public function place_order(Request $request)\r\n    {',1,1,55,'2024-12-06 20:15:34','2024-12-07 08:21:57'),(941,'complete appearing controls to general admin in mjaret elsamaa','code E:\\xampp\\htdocs\\majartalsama\r\nadmin@app.com\r\nAlsama@2030\r\nadmin_all@majratalsama.com\r\nAll@2025',1,1,55,'2024-12-06 20:15:34','2024-12-11 02:40:01'),(942,'',NULL,1,1,51,'2024-12-06 20:22:42','2024-12-07 05:06:30'),(961,'Ask active clients for more money because what rest is not covered and you will afford 50% and them other 50%','start E:\\xampp\\htdocs\\todo\\resources\\views\\admin\\crud\\followups\\index.blade.php',0,1,6,'2024-12-06 20:53:31','2024-12-06 23:56:58'),(962,'add filter to tasks app','start E:\\xampp\\htdocs\\todo\\resources\\views\\admin\\crud\\followups\\index.blade.php\r\n<form  action=\"{{ route(\'followups.bulkAction\') }}\" method=\"POST\">',0,1,5,'2024-12-06 22:44:28','2024-12-06 22:47:48'),(963,'',NULL,1,1,20,'2024-12-07 05:06:22','2024-12-07 05:06:30'),(964,'الاستجابه على الموبايل  \r\n',NULL,1,1,20,'2024-12-07 05:06:22','2024-12-07 18:18:15'),(967,' لوجو سول فارما على طول مخبى الى وراه \r\n',NULL,1,1,20,'2024-12-07 05:06:22','2024-12-07 18:18:15'),(970,'create apk for jaiden and ar5as','you will find the folder here G:\\My Drive\\Refrence\r\n how to build an expo app\r\njava -jar \"C:\\Users\\User\\Desktop\\generateAPK/bundletool.jar\" build-apks --bundle=C:\\Users\\User\\Desktop\\generateAPK/my_app.aab --output=C:\\Users\\User\\Desktop\\generateAPK/myapp.apks --mode=universal\r\n\r\nthen rename myapp.apks to myapp.zip and extract it to get the apk\r\n\r\ncode E:\\xampp\\htdocs\\ar5as\\api\\advertisments.js\r\ncode E:\\xampp\\htdocs\\Shoppa\\Shoppa\r\nboulanessim\r\nRealDeveloper@2024\r\neas build -p android\r\n\r\nthere is a problem building ar5as because of copy paste from jaiden',0,1,28,'2024-12-07 05:17:19','2024-12-08 06:16:22'),(979,' بعد إضافة وظيفة والدخول لطلب هذه الوظيفة، لا يمكن إرسال البيانات الشخصية ولا يحدث أي شيء عند الضغط على زر الإرسال.\r\n',NULL,1,2,51,'2024-12-07 05:27:54','2024-12-07 20:38:23'),(980,' عند الاشتراك في الموقع من الصفحة الرئيسية سواء كمدرب أو متدرب، لا يمكن ملء خانات الاسم الأول والأخير وزر الاشتراك لا يعمل.\r\n',NULL,1,2,51,'2024-12-07 05:27:54','2024-12-07 21:19:03'),(981,' عند إضافة وظائف والدخول على صفحة الوظيفة لعمل طلب (طلب توظيف)، يتم إدخال بيانات الطالب، ولكن زر الإرسال لا يعمل.\r\n',NULL,1,2,51,'2024-12-07 05:27:54','2024-12-07 20:38:23'),(983,' يمكن نسخ شعار الموقع بسهولة من الصفحة الرئيسية. يجب إيجاد حل لمنع نسخه وإعادة استخدامه بسهولة.\r\n',NULL,1,2,51,'2024-12-07 05:27:54','2024-12-07 21:25:47'),(985,' عند إضافة وظيفة والتقدم لها، توجد خانة للموعد المفضل للمقابلة، ولكنها تتيح تحديد الساعة فقط دون التاريخ. بالإضافة إلى أن زر الإرسال لا يعمل.\r\n',NULL,1,2,51,'2024-12-07 05:27:54','2024-12-07 19:36:53'),(986,' غرفة المحادثة (الشات) لا تعمل كما ينبغي. عند إرسال رسالة، لا تصل أي إشعارات للإدارة. يجب أن يتمكن السوبر أدمن من تحديد من يتواصل مع العملاء.\r\n',NULL,1,2,51,'2024-12-07 05:27:54','2024-12-07 21:25:03'),(987,' عند الضغط على كورس في صفحة الكورسات والانتقال إلى صفحة الكورس، لا توجد وسيلة لحجز الكورس، كما أن أزرار \"الرجوع للكورس\" و\"Back to Course\" لا تعمل.\r\n',NULL,1,2,51,'2024-12-07 05:27:54','2024-12-07 18:13:34'),(988,' في صفحة التواصل (Contact)، عند إدخال البيانات والضغط على زر الإرسال، تظهر رسالة \"The subject field is required\" رغم ملء خانة الموضوع.\r\n',NULL,1,2,51,'2024-12-07 05:27:54','2024-12-07 20:13:22'),(989,'add comment to meals','reservationmeals على ما اعتقد',1,5,41,'2024-12-07 15:49:33','2024-12-21 15:43:42'),(990,' التقارير كلها بتضرب ايرور مع اى فيلتر \r\n',NULL,1,3,20,'2024-12-07 18:15:50','2024-12-07 19:15:42'),(991,' فى البيعات فى الصفحه الاولى بيظهر البيانات وعند اختيار اى صفحه تليها بيظهر كلمه select فقط بدون اى بيانات \r\n',NULL,1,3,20,'2024-12-07 18:15:50','2024-12-07 19:47:18'),(999,'in restaurant in reservya','/ReservyaDashboardPortal/public/api/auth/reservationmealssrc\\pages\\reservation\\in-store.tsx\r\nhttps://reservya.yousab-tech.com/store/1 {699320} (login with test)',1,1,41,'2024-12-07 23:34:22','2024-12-10 17:39:30'),(1000,'in restaurant in reservya','/ReservyaDashboardPortal/public/api/auth/reservationmealssrc\\pages\\reservation\\in-store.tsx\r\nhttps://reservya.yousab-tech.com/store/1 {699320} (login with test)',1,3,41,'2024-12-07 23:34:22','2024-12-10 17:39:30'),(1001,'in restaurant in reservya','/ReservyaDashboardPortal/public/api/auth/reservationmealssrc\\pages\\reservation\\in-store.tsx\r\nhttps://reservya.yousab-tech.com/store/1 {699320} (login with test)',1,2,41,'2024-12-07 23:34:22','2024-12-10 17:39:30'),(1002,'in restaurant in reservya','/ReservyaDashboardPortal/public/api/auth/reservationmealssrc\\pages\\reservation\\in-store.tsx\r\nhttps://reservya.yousab-tech.com/store/1 {699320} (login with test)',1,1,41,'2024-12-07 23:34:22','2024-12-10 17:39:30'),(1003,'in restaurant in reservya','/ReservyaDashboardPortal/public/api/auth/reservationmealssrc\\pages\\reservation\\in-store.tsx\r\nhttps://reservya.yousab-tech.com/store/1 {699320} (login with test)',1,3,41,'2024-12-07 23:34:22','2024-12-10 17:39:30'),(1004,'in restaurant in reservya','/ReservyaDashboardPortal/public/api/auth/reservationmealssrc\\pages\\reservation\\in-store.tsx\r\nhttps://reservya.yousab-tech.com/store/1 {699320} (login with test)',1,2,41,'2024-12-07 23:34:22','2024-12-10 17:39:30'),(1005,'check updating wallet in case of cashback','E:\\xampp\\htdocs\\Aloo\\Alloo-Live\\app\\Http\\Controllers\\Api\\V3\\OrderController.php\r\nit saves offer_discount_value  in order wronlgy and thats why it counts it wrongly in order controller \r\n    public function place_order(Request $request)\r\n    {',1,1,55,'2024-12-08 02:50:41','2024-12-11 03:45:00'),(1006,'Majrat elsama logout fastly','http://159.122.109.123/en/admin\r\nadmin@app.com\r\nAlsama@2030\r\nadmin_all@majratalsama.com\r\nAll@2025',0,1,55,'2024-12-08 15:57:59','2024-12-08 16:15:10'),(1007,'check adding disocunts and offers to store deductions',NULL,1,1,55,'2024-12-08 15:57:59','2024-12-08 15:59:43'),(1008,'Send incomplete for session with ended time',NULL,0,1,47,'2024-12-10 23:20:52','2024-12-10 23:20:52'),(1009,'comperess images in website',NULL,0,1,12,'2024-12-11 02:38:00','2024-12-11 02:38:00'),(1010,' remove purchasing option',NULL,0,1,12,'2024-12-11 02:38:00','2024-12-11 02:38:00'),(1011,'revise product data',NULL,0,1,12,'2024-12-11 02:38:00','2024-12-11 02:38:00'),(1012,'apply navbar in word',NULL,0,1,12,'2024-12-11 02:38:00','2024-12-11 02:38:00'),(1013,'remove companies from navbar',NULL,0,1,12,'2024-12-11 02:38:00','2024-12-11 02:38:00'),(1014,'check issue with updating enddate of offer and disabling delete if offer runing',NULL,0,1,55,'2024-12-11 19:29:01','2024-12-11 19:29:01'),(1015,'create apk for the app',NULL,0,1,28,'2024-12-14 01:14:34','2024-12-14 01:14:34'),(1020,'Fix session','public function complete(Request $request)\r\n            {\r\n            try {\r\n                $session = Session::find($request->session_id);\r\n                // Update session status\r\n                $session->update([\r\n                    \'status\' => \"Completed\",\r\n                ]);\r\n\r\n                return successResponse($session);\r\n            } catch (Exception $e) {\r\n                return failedResponse($e->getMessage());\r\n            }\r\n            }',0,1,47,'2024-12-14 16:48:20','2024-12-16 10:03:28'),(1021,'upload build',NULL,1,1,47,'2024-12-14 16:48:20','2024-12-17 15:22:54'),(1022,'Add missing atrributes in reservation ',NULL,1,1,41,'2024-12-14 16:49:53','2024-12-21 15:43:42'),(1023,' fix call waiter',NULL,1,1,41,'2024-12-14 16:49:53','2024-12-21 15:43:42'),(1024,' correct rable number',NULL,1,1,41,'2024-12-14 16:49:53','2024-12-21 15:43:42'),(1030,'compress images to make site faster',NULL,1,1,39,'2024-12-14 21:22:56','2024-12-22 15:47:39'),(1031,'make website faster',NULL,1,1,39,'2024-12-14 21:22:56','2024-12-22 15:47:39'),(1032,'solve reservsation handking in  backend',NULL,0,1,39,'2024-12-14 21:22:56','2024-12-14 21:22:56'),(1033,'fix table number issue in backend ',NULL,1,1,39,'2024-12-14 21:22:56','2024-12-21 15:43:42'),(1034,' comments when click checkout do not save',NULL,1,1,39,'2024-12-14 21:22:56','2024-12-21 15:43:42'),(1035,'make reservation data not accurate',NULL,0,1,39,'2024-12-14 21:22:56','2024-12-14 21:22:56'),(1036,'Payment in Reservya','payment_type: \"{\\\"1\\\":\\\"Cash in restaurant\\\"}\", \r\npayment_type: \"{\\\"1\\\":\\\"Wallet Point\\\"}\",\r\npayment_type: \"{\\\"1\\\":\\\"Pay with Credit/Debit Card\\\"}\",',1,1,41,'2024-12-15 00:30:26','2024-12-21 15:43:42'),(1037,'Payment in Reservya','payment_type: \"{\\\"1\\\":\\\"Cash in restaurant\\\"}\", \r\npayment_type: \"{\\\"1\\\":\\\"Wallet Point\\\"}\",\r\npayment_type: \"{\\\"1\\\":\\\"Pay with Credit/Debit Card\\\"}\",',1,2,41,'2024-12-15 00:30:26','2024-12-21 15:43:42'),(1038,'make restaurant you may like dynamic','src\\components\\shoppingCart\\shoppingCartV1.tsx\r\nsrc\\components\\shoppingCart\\shoppingCartV2.tsx\r\nexport const getRestaurants = async ({ locale }: any) => {\r\n  api.defaults.headers = { locale };\r\n  const res = await api.get(\"/restaurant_page\");\r\n  return res;\r\n};',1,2,41,'2024-12-15 01:30:37','2024-12-15 01:48:12'),(1040,'Fix abdullah issue','API Response: [500] /api/v3/customer/wish-list?lat=30.04440012177067&long=31.23569995164871\r\n<!doctype html>\r\n<html class=\"theme-light\">\r\n<!--\r\nError: Call to a member function format() on string in file /var/www/html/Alloo-Live/app/CentralLogics/V2/helpers.php on line 534',1,1,55,'2024-12-15 15:19:22','2024-12-18 16:42:53'),(1041,'branches show 10 only issue','return view(\'vendor-views.branches.index\', compact(\'store\', \'branches\', \'schedule_terms\', \'schedule_terms_en\',\'stores\',\'mainBranch\'));\r\nAlkhafeef@aloo.com',1,1,55,'2024-12-15 19:21:20','2024-12-16 06:11:27'),(1043,' فى التفارير للمبيعات فى المنتجات بيحسب كمان طلبات المبيعات الى متنفزتش يعنى بيجمع اعداد طلبات المبيعات بالرغم من عدم نزولها فى اى فواتير  مجرد بس طلب مبيعات',NULL,1,1,20,'2024-12-15 22:16:20','2024-12-20 19:13:54'),(1054,'whenc clik done on order reach waiter as table number not counter',NULL,1,1,41,'2024-12-17 17:29:49','2024-12-18 06:28:14'),(1055,'whenc clik done on order reach waiter as table number not counter',NULL,1,3,41,'2024-12-17 17:29:49','2024-12-18 06:28:14'),(1056,'whenc clik done on order reach waiter as table number not counter',NULL,1,2,41,'2024-12-17 17:29:49','2024-12-18 06:28:14'),(1066,'Make paginate solid',NULL,0,1,55,'2024-12-18 15:44:31','2024-12-18 15:44:31'),(1067,'increase max excution time',NULL,0,1,55,'2024-12-18 15:44:31','2024-12-18 15:44:31'),(1068,'make mashawear same like majaret elsama',NULL,0,1,55,'2024-12-18 16:48:40','2024-12-18 16:48:40'),(1069,' add roles to mashawear same like majaret elsama',NULL,0,1,55,'2024-12-18 16:48:40','2024-12-18 16:48:40'),(1070,'order in restaurant do not reach dashboard',NULL,1,1,41,'2024-12-19 05:07:39','2024-12-21 15:43:42'),(1071,'order in restaurant do not reach dashboard',NULL,1,2,41,'2024-12-19 05:07:39','2024-12-21 15:43:42'),(1072,'order in restaurant do not reach dashboard',NULL,1,1,41,'2024-12-19 05:07:39','2024-12-21 15:43:42'),(1073,'order in restaurant do not reach dashboard',NULL,1,2,41,'2024-12-19 05:07:39','2024-12-21 15:43:42'),(1074,'order in restaurant do not reach dashboard',NULL,1,1,41,'2024-12-19 05:07:39','2024-12-21 15:43:42'),(1075,'order in restaurant do not reach dashboard',NULL,1,2,41,'2024-12-19 05:07:39','2024-12-21 15:43:42'),(1076,' send to kitchen is dealed as reservation',NULL,1,1,41,'2024-12-19 05:11:09','2024-12-21 15:43:42'),(1077,' send to kitchen is dealed as reservation',NULL,1,2,41,'2024-12-19 05:11:09','2024-12-21 15:43:42'),(1078,' send to kitchen is dealed as reservation',NULL,1,1,41,'2024-12-19 05:11:09','2024-12-21 15:43:42'),(1079,' send to kitchen is dealed as reservation',NULL,1,2,41,'2024-12-19 05:11:09','2024-12-21 15:43:42'),(1080,' send to kitchen is dealed as reservation',NULL,1,1,41,'2024-12-19 05:11:09','2024-12-21 15:43:42'),(1081,' send to kitchen is dealed as reservation',NULL,1,2,41,'2024-12-19 05:11:09','2024-12-21 15:43:42'),(1082,'make order when is reached from qrcode should redirect to login',NULL,0,1,41,'2024-12-19 05:13:24','2024-12-19 05:13:24'),(1083,'make order when is reached from qrcode should redirect to login',NULL,0,2,41,'2024-12-19 05:13:24','2024-12-19 05:13:24'),(1084,'make order when is reached from qrcode should redirect to login',NULL,0,1,41,'2024-12-19 05:13:24','2024-12-19 05:13:24'),(1085,'make order when is reached from qrcode should redirect to login',NULL,0,2,41,'2024-12-19 05:13:24','2024-12-19 05:13:24'),(1086,'make order when is reached from qrcode should redirect to login',NULL,0,1,41,'2024-12-19 05:13:24','2024-12-19 05:13:24'),(1087,'make order when is reached from qrcode should redirect to login',NULL,0,2,41,'2024-12-19 05:13:24','2024-12-19 05:13:24'),(1088,'points should be 1 pound per 100 LE and need to be dynamic from dashboard',NULL,1,1,41,'2024-12-19 05:18:12','2024-12-21 15:43:42'),(1089,'points should be 1 pound per 100 LE and need to be dynamic from dashboard',NULL,1,2,41,'2024-12-19 05:18:12','2024-12-21 15:43:42'),(1090,'points should be 1 pound per 100 LE and need to be dynamic from dashboard',NULL,1,1,41,'2024-12-19 05:18:12','2024-12-21 15:43:42'),(1091,'points should be 1 pound per 100 LE and need to be dynamic from dashboard',NULL,1,2,41,'2024-12-19 05:18:12','2024-12-21 15:43:42'),(1092,'points should be 1 pound per 100 LE and need to be dynamic from dashboard',NULL,1,1,41,'2024-12-19 05:18:12','2024-12-21 15:43:42'),(1093,'points should be 1 pound per 100 LE and need to be dynamic from dashboard',NULL,1,2,41,'2024-12-19 05:18:12','2024-12-21 15:43:42'),(1094,'debit still 0',NULL,1,1,41,'2024-12-19 05:19:01','2024-12-19 19:32:15'),(1095,'debit still 0',NULL,1,3,41,'2024-12-19 05:19:01','2024-12-19 19:32:15'),(1096,'max-rank in userdata',NULL,1,3,41,'2024-12-19 05:21:33','2024-12-27 20:39:57'),(1097,'order filter not working',NULL,1,3,39,'2024-12-19 07:00:46','2024-12-19 19:01:40'),(1098,'test cash and visas in backend','https://yousab-tech.com/ReservyaDashboardPortal/public/api/auth/reservationmeals',1,1,41,'2024-12-19 17:37:56','2024-12-21 15:43:42'),(1099,'test cash and visas in backend','https://yousab-tech.com/ReservyaDashboardPortal/public/api/auth/reservationmeals',1,2,41,'2024-12-19 17:37:56','2024-12-21 15:43:42'),(1100,'test cash and visas in backend','https://yousab-tech.com/ReservyaDashboardPortal/public/api/auth/reservationmeals',1,1,41,'2024-12-19 17:37:56','2024-12-21 15:43:42'),(1101,'test cash and visas in backend','https://yousab-tech.com/ReservyaDashboardPortal/public/api/auth/reservationmeals',1,2,41,'2024-12-19 17:37:56','2024-12-21 15:43:42'),(1102,'test cash and visas in backend','https://yousab-tech.com/ReservyaDashboardPortal/public/api/auth/reservationmeals',1,1,41,'2024-12-19 17:37:56','2024-12-21 15:43:42'),(1103,'test cash and visas in backend','https://yousab-tech.com/ReservyaDashboardPortal/public/api/auth/reservationmeals',1,2,41,'2024-12-19 17:37:56','2024-12-21 15:43:42'),(1104,'Send islam course data',NULL,0,1,6,'2024-12-21 15:15:56','2024-12-21 15:16:27'),(1105,' البحث فى اى مكان بيكون فى customer او صيدليه',NULL,1,1,20,'2024-12-21 15:17:00','2024-12-21 18:38:13'),(1106,' البحث فى اى مكان بيكون فى customer او صيدليه',NULL,1,3,20,'2024-12-21 15:17:00','2024-12-21 18:38:13'),(1107,'add bills to supplier as pharmacist and add total credit and total debit to both of them',NULL,0,1,20,'2024-12-21 15:17:00','2024-12-21 15:17:00'),(1108,'add bills to supplier as pharmacist and add total credit and total debit to both of them',NULL,0,3,20,'2024-12-21 15:17:00','2024-12-21 15:17:00'),(1109,'give doctor details about the new system',NULL,1,1,20,'2024-12-21 15:17:00','2024-12-27 05:04:05'),(1110,'give doctor details about the new system',NULL,1,3,20,'2024-12-21 15:17:00','2024-12-27 05:04:05'),(1111,'Design(logo,preloader,table expand,dosctor sidebar,resbonsiveness)','https://yousab-tech.com/erp/public/en/dashboard/purchases',1,1,20,'2024-12-21 15:17:00','2024-12-27 05:10:26'),(1112,'Design(logo,preloader,table expand,dosctor sidebar,resbonsiveness)','https://yousab-tech.com/erp/public/en/dashboard/purchases',1,3,20,'2024-12-21 15:17:00','2024-12-27 05:10:26'),(1113,'Design(logo,preloader,table expand,dosctor sidebar,resbonsiveness)','https://yousab-tech.com/erp/public/en/dashboard/purchases',1,1,20,'2024-12-21 15:17:00','2024-12-27 05:10:26'),(1114,'Design(logo,preloader,table expand,dosctor sidebar,resbonsiveness)','https://yousab-tech.com/erp/public/en/dashboard/purchases',1,3,20,'2024-12-21 15:17:00','2024-12-27 05:10:26'),(1115,'تعديل اخطاء التصميم كريسبونسيف وظهور ال sidebar ومعالجة اخطاء تصميم اخري ',NULL,0,1,20,'2024-12-21 15:17:00','2024-12-21 15:17:00'),(1116,'تعديل اخطاء التصميم كريسبونسيف وظهور ال sidebar ومعالجة اخطاء تصميم اخري ',NULL,0,3,20,'2024-12-21 15:17:00','2024-12-21 15:17:00'),(1117,'\r\nعمل احصائيات في الصفحة الرئيسية ',NULL,0,1,20,'2024-12-21 15:17:00','2024-12-21 15:17:00'),(1118,'\r\nعمل احصائيات في الصفحة الرئيسية ',NULL,0,3,20,'2024-12-21 15:17:00','2024-12-21 15:17:00'),(1119,'\r\nاظهار اجمالي الفواتير اسفل الجدول حسب نتائج الفلتر ',NULL,1,1,20,'2024-12-21 15:17:00','2024-12-27 05:11:31'),(1120,'\r\nاظهار اجمالي الفواتير اسفل الجدول حسب نتائج الفلتر ',NULL,1,3,20,'2024-12-21 15:17:00','2024-12-27 05:11:31'),(1121,'\r\nاظهار المحتوي حسب الصيدلية فقط خصوصا في ال sales وال purchases ',NULL,0,1,20,'2024-12-21 15:17:00','2024-12-21 15:17:00'),(1122,'\r\nاظهار المحتوي حسب الصيدلية فقط خصوصا في ال sales وال purchases ',NULL,0,3,20,'2024-12-21 15:17:00','2024-12-21 15:17:00'),(1123,'\r\nعدم ظهور مدخل اختيار الصيدلية عند تسجيل دخول بصيدلية',NULL,1,1,20,'2024-12-21 15:17:00','2024-12-27 05:09:20'),(1124,'\r\nعدم ظهور مدخل اختيار الصيدلية عند تسجيل دخول بصيدلية',NULL,1,3,20,'2024-12-21 15:17:00','2024-12-27 05:09:20'),(1125,'طلب المبيعات المفروض يتحول فاتوره وبعد ما يتنفذ يتشال من طلبات المبيعات\r\n',NULL,0,1,20,'2024-12-21 15:17:00','2024-12-21 15:17:00'),(1126,'طلب المبيعات المفروض يتحول فاتوره وبعد ما يتنفذ يتشال من طلبات المبيعات\r\n',NULL,0,3,20,'2024-12-21 15:17:00','2024-12-21 15:17:00'),(1127,' عند إضافة شركة أو مدرب له تكون كامل الصلاحيات يتم إضافته كأدمن بما في ذلك مسح الأدمن الرئيسي أو المنتجات. له كامل الصلاحيات على الموقع.\r\n',NULL,1,1,51,'2024-12-21 15:36:52','2024-12-27 07:36:36'),(1128,' عند إضافة شركة أو مدرب له تكون كامل الصلاحيات يتم إضافته كأدمن بما في ذلك مسح الأدمن الرئيسي أو المنتجات. له كامل الصلاحيات على الموقع.\r\n',NULL,1,5,51,'2024-12-21 15:36:52','2024-12-27 07:36:36'),(1129,' بعد إضافة المدرب يستطيع التسجيل من الداشبورد ويتم الدخول كأدمن على الموقع له كامل الصلاحيات.\r\n',NULL,1,1,51,'2024-12-21 15:36:52','2024-12-27 07:36:36'),(1130,' بعد إضافة المدرب يستطيع التسجيل من الداشبورد ويتم الدخول كأدمن على الموقع له كامل الصلاحيات.\r\n',NULL,1,5,51,'2024-12-21 15:36:52','2024-12-27 07:36:36'),(1131,' عند إضافة منتج جديد، لا ضرورة لملء كافة البيانات حتى يسمح بإضافة المنتج. كما أن بعض الحقول يتم تعبئتها تلقائيًا ويتم طلب إكمالها لاحقًا عند الإضافة للمنتج وكأنها ليست مستوفاة.\r\n',NULL,1,1,51,'2024-12-21 15:36:52','2024-12-27 07:36:36'),(1132,' عند إضافة منتج جديد، لا ضرورة لملء كافة البيانات حتى يسمح بإضافة المنتج. كما أن بعض الحقول يتم تعبئتها تلقائيًا ويتم طلب إكمالها لاحقًا عند الإضافة للمنتج وكأنها ليست مستوفاة.\r\n',NULL,1,5,51,'2024-12-21 15:36:52','2024-12-27 07:36:36'),(1133,' في الداشبورد عند إضافة مدرب، لا يوجد حقل لتحديد المواعيد المتاحة للمدرب. مطلوب إدراج تقويم شهري لتحديد المواعيد المتاحة التي يحددها المدرب. وأيضًا عند حجز موعد معين يجب أن يصبح هذا الموعد غير متاح للحجز مرة أخرى.\r\n',NULL,0,1,51,'2024-12-21 15:36:52','2024-12-21 15:36:52'),(1134,' في الداشبورد عند إضافة مدرب، لا يوجد حقل لتحديد المواعيد المتاحة للمدرب. مطلوب إدراج تقويم شهري لتحديد المواعيد المتاحة التي يحددها المدرب. وأيضًا عند حجز موعد معين يجب أن يصبح هذا الموعد غير متاح للحجز مرة أخرى.\r\n',NULL,0,5,51,'2024-12-21 15:36:52','2024-12-21 15:36:52'),(1135,' عند دخول المدرب إلى صفحته في طلبات المدربين، يجد الطلبات غير مؤرخة. مطلوب إدراج تاريخ الطلب وتاريخ وموعد الحجز الذي أدخله المتدرب.\r\n',NULL,0,1,51,'2024-12-21 15:36:52','2024-12-21 15:36:52'),(1136,' عند دخول المدرب إلى صفحته في طلبات المدربين، يجد الطلبات غير مؤرخة. مطلوب إدراج تاريخ الطلب وتاريخ وموعد الحجز الذي أدخله المتدرب.\r\n',NULL,0,5,51,'2024-12-21 15:36:52','2024-12-21 15:36:52'),(1137,' في صفحة المدرب عند مراجعة طلبات المدربين، يجب أن يكون هناك زر يفيد بإتمام الجلسة من قبل المدرب، وعند الضغط عليه يتم إرسال رسالة للمتدرب لتأكيد الإتمام وطلب تقييم الجلسة.\r\n',NULL,0,1,51,'2024-12-21 15:36:52','2024-12-21 15:36:52'),(1138,' في صفحة المدرب عند مراجعة طلبات المدربين، يجب أن يكون هناك زر يفيد بإتمام الجلسة من قبل المدرب، وعند الضغط عليه يتم إرسال رسالة للمتدرب لتأكيد الإتمام وطلب تقييم الجلسة.\r\n',NULL,0,5,51,'2024-12-21 15:36:52','2024-12-21 15:36:52'),(1139,' في الداشبورد، عند الضغط على خيار \"الأخبار (News)\"، تظهر صفحة \"Not Found\" ولا يتم فتح أي صفحة.\r\n',NULL,0,1,51,'2024-12-21 15:36:52','2024-12-21 15:36:52'),(1140,' في الداشبورد، عند الضغط على خيار \"الأخبار (News)\"، تظهر صفحة \"Not Found\" ولا يتم فتح أي صفحة.\r\n',NULL,0,5,51,'2024-12-21 15:36:52','2024-12-21 15:36:52'),(1141,' الإشعارات (Notifications): عند الضغط على الجرس تظهر ثلاثة خيارات، ولكنها لا تعمل. ورغم ذلك يظهر الرقم 15 بجانب الجرس كعدد الإشعارات.',NULL,0,1,51,'2024-12-21 15:36:52','2024-12-21 15:36:52'),(1142,' الإشعارات (Notifications): عند الضغط على الجرس تظهر ثلاثة خيارات، ولكنها لا تعمل. ورغم ذلك يظهر الرقم 15 بجانب الجرس كعدد الإشعارات.',NULL,0,5,51,'2024-12-21 15:36:52','2024-12-21 15:36:52'),(1147,' في صفحة المدرب عند طلب حجز مدرب، توجد خانة لتحديد موعد الجلسة، ولكن لا يمكن إدخال أي بيانات فيها. مطلوب تسهيل إدراج الموعد (اليوم، التاريخ، الساعة المطلوبة).\r\n',NULL,0,1,51,'2024-12-21 15:36:52','2024-12-21 15:36:52'),(1148,' في صفحة المدرب عند طلب حجز مدرب، توجد خانة لتحديد موعد الجلسة، ولكن لا يمكن إدخال أي بيانات فيها. مطلوب تسهيل إدراج الموعد (اليوم، التاريخ، الساعة المطلوبة).\r\n',NULL,0,5,51,'2024-12-21 15:36:52','2024-12-21 15:36:52'),(1149,' في صفحة المدرب عند طلب حجز مدرب، توجد خانة لتحديد موعد الجلسة، ولكن لا يمكن إدخال أي بيانات فيها. مطلوب تسهيل إدراج الموعد (اليوم، التاريخ، الساعة المطلوبة).\r\n',NULL,0,1,51,'2024-12-21 15:36:52','2024-12-21 15:36:52'),(1150,' في صفحة المدرب عند طلب حجز مدرب، توجد خانة لتحديد موعد الجلسة، ولكن لا يمكن إدخال أي بيانات فيها. مطلوب تسهيل إدراج الموعد (اليوم، التاريخ، الساعة المطلوبة).\r\n',NULL,0,5,51,'2024-12-21 15:36:52','2024-12-21 15:36:52'),(1153,'Fix place order issue','{\"error\": {\"data\": \"SQLSTATE[42S22]: Column not found: 1054 Unknown column \'stock\' in \'field list\' (Connection: mysql, SQL: update `products` set `stock` = -1, `products`.`updated_at` = 2024-12-15 11:52:33 where `id` = 21)\", \"message\": \"error\", \"status\": 400}}',1,5,28,'2024-12-21 15:45:59','2024-12-21 21:47:16'),(1154,'Fix place order issue','{\"error\": {\"data\": \"SQLSTATE[42S22]: Column not found: 1054 Unknown column \'stock\' in \'field list\' (Connection: mysql, SQL: update `products` set `stock` = -1, `products`.`updated_at` = 2024-12-15 11:52:33 where `id` = 21)\", \"message\": \"error\", \"status\": 400}}',1,5,28,'2024-12-21 15:45:59','2024-12-21 21:47:16'),(1155,'When show in make reservation and order load on same page',NULL,1,3,39,'2024-12-22 15:46:58','2024-12-27 20:38:55'),(1156,'When show in make reservation and order load on same page',NULL,1,5,39,'2024-12-22 15:46:58','2024-12-27 20:38:55'),(1157,'When show in make reservation and order load on same page',NULL,1,3,39,'2024-12-22 15:46:58','2024-12-27 20:38:55'),(1158,'When show in make reservation and order load on same page',NULL,1,5,39,'2024-12-22 15:46:58','2024-12-27 20:38:55'),(1192,'pickup is not working','Error: Error posting order: \r\nAxiosError {message: \"Request failed with status code 400\", name: \"AxiosError\", code: \"ERR_BAD_REQUEST\", config: {…}, request: XMLHttpRequest, …}\r\n\r\nTypeError: Xt.substring is not a function',1,1,39,'2024-12-22 17:19:35','2024-12-27 20:24:57'),(1193,'pickup is not working','Error: Error posting order: \r\nAxiosError {message: \"Request failed with status code 400\", name: \"AxiosError\", code: \"ERR_BAD_REQUEST\", config: {…}, request: XMLHttpRequest, …}\r\n\r\nTypeError: Xt.substring is not a function',1,3,39,'2024-12-22 17:19:35','2024-12-27 20:24:57'),(1194,'Trainee should fill checkup form to register',NULL,0,1,51,'2024-12-22 22:54:54','2024-12-22 22:54:54'),(1195,'Trainee should fill checkup form to register',NULL,0,2,51,'2024-12-22 22:54:54','2024-12-22 22:54:54'),(1196,'Islam programming course','Frontdnd Developer\r\nHtml = 4 sessions \r\nCss = 6 sessions \r\nBootstrap= 2 sessions\r\nJs = 10 sessions \r\nProject= 2 sessions\r\n\r\nBackend \r\nPHP=12 sessions\r\nMysql= 8 sesdions\r\nProject= 2 sessions\r\nGit = 2 sessions \r\n\r\nCareer and Freelance \r\nCV and applying= 4 sessions\r\nFreelance =4 sessions',0,1,6,'2024-12-24 02:16:21','2024-12-24 02:16:37'),(1197,'applyin max discount in offers and discount','Applyed to offers and need to check it in discounts',0,1,55,'2024-12-24 17:48:16','2024-12-25 00:59:14'),(1198,'api search discoun issue','/api/v3/items/search?store_id=1413&name=Kisha&offset=1&limit=10&type=all&lat=24.709422248310045&long=46.67074464261532',1,1,55,'2024-12-24 17:48:16','2024-12-25 00:51:00'),(1199,'applying restaurant percent on discount in adding discounts of items','Decided to add two columns to orders to specify how much on restaurant and how much on all while looping in items in place_order\r\n\r\n1- add to migrations table to coljmns \r\nres_affair\r\nstore_affair\r\n2- in order place_order make the be filled\r\n3- update adding discounts on store in dashboard make it count from store_affair\r\n4- update adding discount in settlement make it count from store_affair',0,1,55,'2024-12-24 17:48:16','2024-12-25 01:04:12'),(1200,'value must be 10:23','In some date time inputs',0,1,55,'2024-12-24 18:57:13','2024-12-25 00:58:12'),(1201,'may affect applying discount on order','if (isset($store_discount)) {\r\n            if ($product_price + $total_addon_price < $store_discount[\'min_purchase\']) {\r\n                $store_discount_amount = 0;\r\n                Log::info(\"max_discount =>\".$store_discount[\'max_discount\']);\r\n\r\n            }\r\n\r\n            if ($store_discount[\'max_discount\'] != 0 && $store_discount_amount > $store_discount[\'max_discount\']) {\r\n                $store_discount_amount = $store_discount[\'max_discount\'];\r\n                Log::info(\"store_discount =>\".$store_discount[\'max_discount\']);\r\n\r\n            }\r\n        }',0,1,55,'2024-12-25 19:31:19','2024-12-25 19:31:31'),(1202,'offer discount value while crating order does not apply max_discount',NULL,0,1,55,'2024-12-25 21:34:02','2024-12-25 21:34:02'),(1203,'show stats according to date of sales in sales and purchases',NULL,0,1,20,'2024-12-27 06:47:03','2024-12-27 06:47:03'),(1204,'check stats and allover the system',NULL,0,1,20,'2024-12-27 06:47:03','2024-12-27 06:47:03'),(1205,' check all stats ',NULL,0,1,20,'2024-12-27 06:47:03','2024-12-27 06:47:03'),(1206,' total allover the system not according to paginate ',NULL,0,1,20,'2024-12-27 06:47:03','2024-12-27 06:47:03'),(1207,' add paginate dynamically',NULL,0,1,20,'2024-12-27 06:47:03','2024-12-27 06:47:03'),(1208,'when adding sales to sales bill remove payment and ither options in sales reques inly leave turn to bill ',NULL,0,1,20,'2024-12-27 06:47:03','2024-12-27 06:47:03'),(1209,' in sales request diffenciate between it an sales whdn pharmacy and show sales requests according to logged pharmacy',NULL,0,1,20,'2024-12-27 06:47:03','2024-12-27 06:47:03'),(1210,' in payment show bills according to logged in pharmacy not empliyee payed',NULL,0,1,20,'2024-12-27 06:47:03','2024-12-27 06:47:03'),(1211,' show all dropdown content in rabs in bills',NULL,0,1,20,'2024-12-27 06:47:03','2024-12-27 06:47:03'),(1212,' عند إضافة منتج والدخول على صفحة المنتج من الرئيسية، نجد فيديو من اليوتيوب لا يمكن حذفه أو تغييره، ولا توجد خانة لإضافة أو تعديل الفيديو.\r\n',NULL,0,3,51,'2024-12-27 07:37:49','2024-12-27 07:37:49'),(1213,' عند إضافة منتج والدخول على صفحة المنتج من الرئيسية، نجد فيديو من اليوتيوب لا يمكن حذفه أو تغييره، ولا توجد خانة لإضافة أو تعديل الفيديو.\r\n',NULL,0,2,51,'2024-12-27 07:37:49','2024-12-27 07:37:49'),(1214,' عند إضافة منتج والدخول على صفحة المنتج من الرئيسية، نجد فيديو من اليوتيوب لا يمكن حذفه أو تغييره، ولا توجد خانة لإضافة أو تعديل الفيديو.\r\n',NULL,0,3,51,'2024-12-27 07:37:49','2024-12-27 07:37:49'),(1215,' عند إضافة منتج والدخول على صفحة المنتج من الرئيسية، نجد فيديو من اليوتيوب لا يمكن حذفه أو تغييره، ولا توجد خانة لإضافة أو تعديل الفيديو.\r\n',NULL,0,2,51,'2024-12-27 07:37:49','2024-12-27 07:37:49'),(1216,'add video link to careers',NULL,0,3,51,'2024-12-27 07:37:49','2024-12-27 07:37:49'),(1217,'add video link to careers',NULL,0,2,51,'2024-12-27 07:37:49','2024-12-27 07:37:49'),(1218,'add video link to careers',NULL,0,3,51,'2024-12-27 07:37:49','2024-12-27 07:37:49'),(1219,'add video link to careers',NULL,0,2,51,'2024-12-27 07:37:49','2024-12-27 07:37:49'),(1221,'Remove 2 1 addtional input in register',NULL,0,1,51,'2024-12-27 08:09:38','2024-12-27 08:09:38'),(1222,'Remove 2 1 addtional input in register',NULL,0,2,51,'2024-12-27 08:09:38','2024-12-27 08:09:38'),(1227,'accept arabella invitation ',NULL,0,1,6,'2024-12-27 08:26:40','2024-12-27 08:26:40'),(1228,' make follow ups from latest',NULL,0,1,6,'2024-12-27 08:26:40','2024-12-27 08:26:40'),(1230,'make kermina my wife with heart icon in dashboard',NULL,0,1,6,'2024-12-27 08:49:15','2024-12-27 08:49:15'),(1231,'totaaa',NULL,0,1,6,'2024-12-27 09:00:02','2024-12-27 09:00:02'),(1232,'totaaa',NULL,0,2,6,'2024-12-27 09:00:02','2024-12-27 09:00:02'),(1233,'totaaa2',NULL,0,1,6,'2024-12-27 09:03:09','2024-12-27 09:03:09'),(1234,'totaaa2',NULL,0,2,6,'2024-12-27 09:03:09','2024-12-27 09:03:09'),(1235,'totaaa3',NULL,0,1,6,'2024-12-27 09:06:13','2024-12-27 09:06:13'),(1236,'totaaa3',NULL,0,2,6,'2024-12-27 09:06:13','2024-12-27 09:06:13');
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
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `team_translations`
--

LOCK TABLES `team_translations` WRITE;
/*!40000 ALTER TABLE `team_translations` DISABLE KEYS */;
INSERT INTO `team_translations` VALUES (1,'جرجس مكرم','مدير',NULL,1,'ar','2024-08-31 08:15:17','2024-08-31 08:15:17'),(2,'Gerges Makram','Manager',NULL,1,'en','2024-08-31 08:15:17','2024-08-31 08:15:17'),(3,'بولا نسيم','مهندس برمجيات',NULL,2,'ar','2024-08-31 08:15:17','2024-08-31 08:15:17'),(4,'Boula Nessim','Project Manager',NULL,2,'en','2024-08-31 08:15:17','2024-08-31 08:15:17'),(5,'ابراهيم سامى','مهندس برمجيات',NULL,3,'ar','2024-08-31 08:15:17','2024-08-31 08:15:17'),(6,'Ibrahim Samy','Software Engineer',NULL,3,'en','2024-08-31 08:15:17','2024-08-31 08:15:17'),(7,'كيرلس ادوارد','مصمم ويب ',NULL,4,'ar','2024-08-31 08:15:17','2024-08-31 08:15:17'),(8,'Kyrillos Edward','Software Engineer',NULL,4,'en','2024-08-31 08:15:17','2024-08-31 08:15:17'),(9,'تادرس اميل','مطور ويب',NULL,5,'ar','2024-08-31 08:15:17','2024-08-31 08:15:17'),(10,'Tadrous Emil','Software Engineer',NULL,5,'en','2024-08-31 08:15:17','2024-08-31 08:15:17'),(11,'ميلاد يوسف','مطور ويب',NULL,6,'ar','2024-08-31 08:15:17','2024-08-31 08:15:17'),(12,'Melad Youssef','Web Developer',NULL,6,'en','2024-08-31 08:15:17','2024-08-31 08:15:17'),(13,'زياد محمد','مطور ويب',NULL,7,'ar','2024-08-31 08:15:17','2024-08-31 08:15:17'),(14,'Zeiad Mohamed','Web Developer',NULL,7,'en','2024-08-31 08:15:17','2024-08-31 08:15:17'),(15,'Kermina Milad','Frontend Developer','Frontend Developer',8,'en','2024-12-07 07:22:03','2024-12-07 07:22:03'),(16,'كرمينا ميلاد','مطور واجهات امامية','مطور واجهات امامية',8,'ar','2024-12-07 07:22:03','2024-12-07 07:22:03');
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
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `teams`
--

LOCK TABLES `teams` WRITE;
/*!40000 ALTER TABLE `teams` DISABLE KEYS */;
INSERT INTO `teams` VALUES (1,'https://www.facebook.com','https://www.twitter.com','https://www.instagram.com','https://www.linkedin.com','2024-08-31 08:15:17','2024-08-31 08:15:17'),(2,'https://www.facebook.com','https://www.twitter.com','https://www.instagram.com','https://www.linkedin.com','2024-08-31 08:15:17','2024-08-31 08:15:17'),(3,'https://www.facebook.com','https://www.twitter.com','https://www.instagram.com','https://www.linkedin.com','2024-08-31 08:15:17','2024-08-31 08:15:17'),(4,'https://www.facebook.com','https://www.twitter.com','https://www.instagram.com','https://www.linkedin.com','2024-08-31 08:15:17','2024-08-31 08:15:17'),(5,'https://www.facebook.com','https://www.twitter.com','https://www.instagram.com','https://www.linkedin.com','2024-08-31 08:15:17','2024-08-31 08:15:17'),(6,'https://www.facebook.com','https://www.twitter.com','https://www.instagram.com','https://www.linkedin.com','2024-08-31 08:15:17','2024-08-31 08:15:17'),(7,'https://www.facebook.com','https://www.twitter.com','https://www.instagram.com','https://www.linkedin.com','2024-08-31 08:15:17','2024-08-31 08:15:17'),(8,'https://www.facebook.com/profile.php?id=100026394494172&mibextid=ZbWKwL','https://x.com/home?lang=ar','https://www.instagram.com/kermina_milad/profilecard/?igsh=MXF5eDdiN3p5bWluZg==','https://www.linkedin.com/in/kermina-milad-239797244/','2024-12-07 07:22:03','2024-12-07 07:24:28');
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
INSERT INTO `testimonial_translations` VALUES (1,'عمر محمد','العميل، الولايات المتحدة الأمريكية','<p> لقد كان من دواعي سروري العمل مع فريق شركة يوساب تك في مشروع موقع الويب الخاص بي، ولم أستطع أن أكون أكثر سعادة بالنتائج. لقد أظهروا، منذ البداية وحتى النهاية، مستوىً عالٍ من الاحترافية والخبرة والتفاني </p>',1,'ar','2024-08-31 08:15:17','2024-08-31 08:15:17'),(2,'Omar Mohamed','Customer,USA','<p>I had the pleasure of working with the team at Yousab Tech company for my website project, and I couldn\'t be happier with the results. From start to finish, they demonstrated a high level of professionalism, expertise, and dedication</p>',1,'en','2024-08-31 08:15:17','2024-08-31 08:15:17'),(3,'محمد احمد','العميل، الولايات المتحدة الأمريكية','<p>استغرق فريق شركة يوساب تك الوقت الكافي لفهم رؤيتي وأهدافي للموقع. لقد استمعوا باهتمام لمتطلباتي وقدموا رؤى واقتراحات قيمة لتعزيز تجربة المستخدم الشاملة. كان تواصلهم طوال المشروع ممتازًا، وأبقوني على اطلاع دائم بالتقدم المحرز بانتظام.</p>',2,'ar','2024-08-31 08:15:17','2024-08-31 08:15:17'),(4,'Mohamed Ahmed','Customer,USA','<p> The team at Yousab Tech company took the time to understand my vision and goals for the website. They listened attentively to my requirements and provided valuable insights and suggestions to enhance the overall user experience. Their communication throughout the project was excellent, and they kept me updated on the progress regularly</p>',2,'en','2024-08-31 08:15:17','2024-08-31 08:15:17'),(5,' علياء عماد','العميل، الولايات المتحدة الأمريكية','<p>لقد تأثرت بمهاراتهم الفنية واهتمامهم بالتفاصيل. موقع الويب الذي أنشأوه لي لا يبدو مذهلاً فحسب، بل يعمل أيضًا بشكل لا تشوبه شائبة. لقد تأكدوا من أن الموقع سريع الاستجابة ومُحسّن لمحركات البحث وسهل الاستخدام. التصميم حديث وجذاب بصريًا ويتوافق تمامًا مع هوية علامتي التجارية.</p>',3,'ar','2024-08-31 08:15:17','2024-08-31 08:15:17'),(6,'Alia Emad','Customer,USA','<p>I was impressed by their technical skills and attention to detail. The website they created for me not only looks stunning but also functions flawlessly. They ensured that the site is responsive, optimized for search engines, and user-friendly. The design is modern, visually appealing, and aligned perfectly with my brand identity</p>',3,'en','2024-08-31 08:15:17','2024-08-31 08:15:17'),(7,'شريف عاطف','العميل، الولايات المتحدة الأمريكية','<p>ما يميز شركة يوساب تك هو التزامها برضا العملاء. لقد ذهبوا إلى أبعد من ذلك لمعالجة أي مخاوف أو تعديلات كانت لدي، وكانوا دائمًا سريعين في ردودهم. خدمة العملاء الخاصة بهم استثنائية حقًا.</p>',4,'ar','2024-08-31 08:15:17','2024-08-31 08:15:17'),(8,'Sherif Atef','Customer,USA','<p>What sets Yousab Tech company apart is their commitment to customer satisfaction. They went above and beyond to address any concerns or modifications I had, and they were always prompt in their responses. Their customer service is truly exceptional.</p>',4,'en','2024-08-31 08:15:17','2024-08-31 08:15:17'),(9,' داليا سمير','العميل، الولايات المتحدة الأمريكية','<p>أوصي بشدة بشركة يوساب تك لأي شخص يحتاج إلى خدمات تطوير الويب الاحترافية. إنهم فريق موهوب وموثوق يحقق نتائج رائعة. لقد كان العمل معهم ممتعًا، وأتطلع إلى التعاون معهم مرة أخرى في المستقبل</p>',5,'ar','2024-08-31 08:15:17','2024-08-31 08:15:17'),(10,'Dalia Samir','Customer,USA','<p>I highly recommend Yousab Tech company to anyone in need of professional web development services. They are a talented and reliable team that delivers outstanding results. Working with them has been a pleasure, and I look forward to collaborating with them again in the future</p>',5,'en','2024-08-31 08:15:17','2024-08-31 08:15:17');
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
INSERT INTO `testimonials` VALUES (1,'2024-08-31 08:15:17','2024-08-31 08:15:17'),(2,'2024-08-31 08:15:17','2024-08-31 08:15:17'),(3,'2024-08-31 08:15:17','2024-08-31 08:15:17'),(4,'2024-08-31 08:15:17','2024-08-31 08:15:17'),(5,'2024-08-31 08:15:17','2024-08-31 08:15:17');
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
INSERT INTO `users` VALUES (1,'Ibrahim Samy','ibrahimsamy308@gmail.com',NULL,'$2y$10$csIDPRL1upEn/Q7DGUSa3uOnydLzoFsN3AJpcqBGKQqxJOvmI68Xm',NULL,'2024-08-31 08:15:17','2024-08-31 08:15:17'),(2,'Keroles Fouad','Kero@gmail.com',NULL,'$2y$10$9Vfpd0SzpR.EXblEosRESuHIjbkYB7Ky0JFLnUGoY4dl9I4vk57EO',NULL,'2024-08-31 08:15:17','2024-08-31 08:15:17'),(3,'ابراهيم سامى','ibrahim@gmail.com',NULL,'$2y$10$MDRIT2H8Fv2SNKp4yvQ2qOPEoSMp/Afeepv0B1P2i6CujxOzJiiI.',NULL,'2024-08-31 08:15:17','2024-08-31 08:15:17');
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
INSERT INTO `vaccancies` VALUES (1,7000,'2024-08-31 08:15:16','2024-08-31 08:15:16');
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
INSERT INTO `vaccancy_translations` VALUES (1,'مطور وجهات المواقع','<p>يقوم مطور الواجهة الأمامية بإنشاء مواقع الويب والتطبيقات باستخدام لغات الويب مثل HTML وCSS وJavaScript التي تتيح للمستخدمين الوصول إلى الموقع أو التطبيق والتفاعل معه. عندما تزور موقع ويب، تم إنشاء عناصر التصميم التي تراها بواسطة مطور الواجهة الأمامية</p>',1,'ar','2024-08-31 08:15:16','2024-08-31 08:15:16'),(2,'frontend developer','<p>A front-end developer creates websites and applications using web languages such as HTML, CSS, and JavaScript that allow users to access and interact with the site or app. When you visit a website, the design elements you see were created by a front-end developer</p>',1,'en','2024-08-31 08:15:16','2024-08-31 08:15:16');
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
INSERT INTO `video_translations` VALUES (1,'رفع المواقع',1,'ar','2024-08-31 08:15:17','2024-08-31 08:15:17'),(2,'Upload websites',1,'en','2024-08-31 08:15:17','2024-08-31 08:15:17'),(3,'انشاء المواقع',2,'ar','2024-08-31 08:15:17','2024-08-31 08:15:17'),(4,'Create websites',2,'en','2024-08-31 08:15:17','2024-08-31 08:15:17');
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
INSERT INTO `videos` VALUES (1,'www.youtube.com','2024-08-31 08:15:17','2024-08-31 08:15:17'),(2,'www.google.com','2024-08-31 08:15:17','2024-08-31 08:15:17');
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

-- Dump completed on 2024-12-27 13:32:25
