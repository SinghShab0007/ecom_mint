-- MySQL dump 10.13  Distrib 8.4.8, for macos15 (arm64)
--
-- Host: 127.0.0.1    Database: billmint_mall
-- ------------------------------------------------------
-- Server version	8.4.8

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `sellers`
--

DROP TABLE IF EXISTS `sellers`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `sellers` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `company_name` varchar(125) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `first_name` varchar(125) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_name` varchar(125) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `wallet` double NOT NULL DEFAULT '0',
  `password` varchar(125) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `category_id` bigint DEFAULT NULL,
  `image` varchar(125) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `remember_token` varchar(125) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `mobile` varchar(125) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(125) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `gender` int NOT NULL COMMENT '0 = other, 1 = male, 2 = female',
  `address` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `business_address` varchar(125) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `business_email` varchar(125) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `business_mobile` varchar(125) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `post_code` varchar(125) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `city` varchar(125) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `nid_no` varchar(125) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `passport_no` varchar(125) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `domain_name` varchar(125) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `domain_ssl_stat` tinyint DEFAULT NULL,
  `slug` varchar(125) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `verification_code` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `verification_expire_at` timestamp NULL DEFAULT NULL,
  `is_active` tinyint NOT NULL DEFAULT '1',
  `is_approve` tinyint NOT NULL DEFAULT '0',
  `is_suspended` tinyint NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `tin` varchar(125) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `website` varchar(125) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `banner` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `facebook` varchar(125) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `business_type` varchar(125) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `gstin` varchar(32) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `gstin_verified_at` timestamp NULL DEFAULT NULL,
  `referral_code` varchar(125) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `pan` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `pan_image` varchar(125) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `aadhaar` varchar(12) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `bank_account_number` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `ifsc_code` varchar(11) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `business_name` varchar(125) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `shop_owner_name` varchar(125) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `shop_manager_name` varchar(125) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `shop_manager_mobile` varchar(32) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `shop_no_complex` varchar(125) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `area` varchar(125) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `landmark` varchar(125) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `district` varchar(125) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `state` varchar(125) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `country` varchar(120) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `shipping_phone` varchar(32) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `deal_categories` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin,
  `data_consent` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `sellers_slug_unique` (`slug`),
  CONSTRAINT `sellers_chk_1` CHECK (json_valid(`deal_categories`))
) ENGINE=InnoDB AUTO_INCREMENT=44 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sellers`
--

LOCK TABLES `sellers` WRITE;
/*!40000 ALTER TABLE `sellers` DISABLE KEYS */;
INSERT INTO `sellers` VALUES (1,'Online Park','Online','Park',800,'$2y$10$A.XgNh.F0e/NWKfo0fQ3Nu4SZvOY1.YKYishEDPROKKxkY4YRp0Mm',NULL,'ItEZJKKEWiArkdVHMHUbTU5hVxJfLc2wY5xT5inP.jpg','Kghi0IKs3svJIs5l5hsqOrhzyyvoQjBg0PAMxraL4Gtz8ymLfb7mQzvN7P8w',' 9528070571','seller1@poros.com',NULL,1,'india','india','sahidul11182@gmail.com','01712022529','1000','nodia',NULL,NULL,'http://mybazarupdate.maantheme.com/',0,'online-park',NULL,NULL,1,1,0,NULL,'2023-07-10 14:04:46','2023-07-10 14:04:46',NULL,NULL,'banner/611TYX1C2b3VbKbsqcVXcM4DE5PlbVriNDaEqFwi.jpg',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,0),(3,'Jindal electric','Jindal Electric Store','Jatin Jindal',900,'$2y$10$A.XgNh.F0e/NWKfo0fQ3Nu4SZvOY1.YKYishEDPROKKxkY4YRp0Mm',NULL,'YsnkP5XCUMe6RZKNUx5tRIvzFOuJD8xPZFjlxPSR.png','HxHJcJ2LG40XX6JlHdBPe2sP3xZHhH5PioCjr03P1nnOqXX7OdvTxZOiaSzs','9528070578','jatinjindal@gmail.com',NULL,1,'india','India','jatinjindal@gmail.com','9528070578',NULL,'Noida',NULL,NULL,NULL,0,'jindal-electric-store-jindal-electric-store',NULL,NULL,1,1,0,NULL,'2026-04-06 05:32:57',NULL,NULL,'','banner/Aqq72ghLx74UfjI620WK4YbdWwPY7R9NwKMLQT2c.jpg',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,0),(32,'Mahi beauty point','Mahi Beauty Point','Mahi Yadav',30755.6,'$2y$10$7w0F14qJn5u7tqabX07BuOCARcIfwShokYCCZ7yGAGF5Wjarp8hJy',NULL,NULL,NULL,'9528070577','mahibeauty@gmail.com',NULL,2,'India','India','mahibeauty@gmail.com','9528070577','1211','Noida',NULL,NULL,NULL,NULL,'mahi-beauty-point-mahi-beauty-point',NULL,NULL,1,1,0,'2023-07-10 14:10:29','2026-04-06 05:29:32',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,0),(33,'Home Appliance House','Home Appliance House','Ram Singh',0,'$2y$10$NjEmgnX8ALvOVhJacOKyg.2kaLx7TRy2n856ZzUbGwI4HvNLurrvS',6,NULL,NULL,'9528070576','homeappliance@gmail.com',NULL,1,'India','India','homeappliance@gmail.com','9528070576',NULL,'Noida',NULL,NULL,NULL,NULL,'home-appliance-house-home-appliance-house',NULL,NULL,1,1,0,'2023-07-14 23:00:58','2026-04-06 05:27:16',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,0),(34,'Shivam Mobile house','Shivam Mobile house','Shivam',810,'$2y$10$zP6vPAfcrJDfB.svS91JyOwvqGktq99agX651nfb8FUSyMXHxNpm.',NULL,NULL,NULL,'9528070574','mobilehouse@gmail.com',NULL,1,'India','India','mobilehouse@gmail.com','9528070574',NULL,'Delhi',NULL,NULL,NULL,NULL,'shivam-mobile-house-shivam-mobile-house',NULL,NULL,1,1,0,'2023-07-15 11:46:47','2026-04-06 05:23:16',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,0),(35,'A One Sports Store','A One Sports Store','Rahul',0,'$2y$10$UUQkG20QR4gDUluuv3AT/OgMqhNOAc2dYCb7a55SO2QH27jLv9AxC',NULL,NULL,NULL,'9528070571','aonesports@gmail.com',NULL,1,'Dhaka','India','aonesports@gmail.com','9528070572',NULL,'India',NULL,NULL,NULL,NULL,'a-one-sports-store-a-one-sports-store',NULL,NULL,1,1,0,'2023-08-02 09:59:57','2026-04-06 05:34:44',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,0),(36,'VOLTSETU TRADING PRIVATE LIMITED','SURESH','SINGH',0,'$2y$10$zie0LD1unZ2R65spkSz4zeDgSw0D42NGeDGwiIGZqHXT1cUuAnh2e',1,NULL,NULL,'8276096832','contactvolsetu@gmail.com',NULL,1,'S/O. SUDHEER SINGH, D-3, 2ND FLOOR, PLOT NO. 4A AND 4B, KH NO.684, CONDUCTER COLONY, SHANI MANDIR, VILLAGE – BURARI,, India, North, Delhi, India, 110084','India','shyamfashion@gmail.com',NULL,'110084','India','',NULL,NULL,NULL,'shayam-fashion-store-shayam-fashion-store',NULL,NULL,1,1,0,'2023-08-03 11:58:47','2026-07-24 09:21:32',NULL,'07AAMCV0874E1Z5',NULL,NULL,NULL,'gstin','07AAMCV0874E1Z5',NULL,NULL,'',NULL,NULL,NULL,NULL,'VOLTSETU TRADING','SURESH SINGH',NULL,NULL,'S/O. SUDHEER SINGH, D-3, 2ND FLOOR, PLOT NO. 4A AND 4B, KH NO.684, CONDUCTER COLONY, SHANI MANDIR, VILLAGE – BURARI,',NULL,NULL,'North','Delhi','India',NULL,NULL,1),(39,'Rana Fashion point','Shahil','Rana',0,'$2y$10$zGKlOO.nGyRbYZrVLdjzW.aMmdy9PLQED8vTMW07hVMaU9JQX6z/e',1,NULL,NULL,'7505457658','shahilrana0007@gmail.com','2026-05-12 11:31:43',1,'c-42, sector 63, metro station, noida, Gautham buddha nagar, Uttar Pradesh, India, 201302',NULL,NULL,'7505457658','201302','noida','AAICP8274E',NULL,NULL,NULL,'ZtkwqZfLZtT97fDG',NULL,NULL,1,1,0,'2026-05-12 11:31:06','2026-05-12 12:24:54',NULL,NULL,NULL,NULL,NULL,'without_gstin',NULL,NULL,NULL,'AAICP8274E','sellers/pan/hhWh1eNo5prCKrLWuDF8J2jWNeBDQD9TuOtK6YFP.pdf',NULL,NULL,NULL,'Clothing business','Shahil','Shahil','7505457658','c-42','sector 63','metro station','Gautham buddha nagar','Uttar Pradesh','India','7505457658',NULL,1);
/*!40000 ALTER TABLE `sellers` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2026-08-27 16:06:13
