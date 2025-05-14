-- MariaDB dump 10.19  Distrib 10.4.21-MariaDB, for osx10.10 (x86_64)
--
-- Host: localhost    Database: finca2
-- ------------------------------------------------------
-- Server version	10.4.21-MariaDB

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `animal_set`
--

DROP TABLE IF EXISTS `animal_set`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `animal_set` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `set_id` bigint(20) unsigned NOT NULL,
  `animal_id` bigint(20) unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `animal_set_set_id_foreign` (`set_id`),
  KEY `animal_set_animal_id_foreign` (`animal_id`),
  CONSTRAINT `animal_set_animal_id_foreign` FOREIGN KEY (`animal_id`) REFERENCES `animals` (`id`) ON DELETE CASCADE,
  CONSTRAINT `animal_set_set_id_foreign` FOREIGN KEY (`set_id`) REFERENCES `sets` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `animal_set`
--

LOCK TABLES `animal_set` WRITE;
/*!40000 ALTER TABLE `animal_set` DISABLE KEYS */;
/*!40000 ALTER TABLE `animal_set` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `animals`
--

DROP TABLE IF EXISTS `animals`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `animals` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `number` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `gender` enum('1','2') COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `cost` double(8,2) DEFAULT NULL,
  `value` double(8,2) DEFAULT NULL,
  `is_criollo` enum('1','2') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '2',
  `bought_from` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `sold_to` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `born_date` date DEFAULT NULL,
  `bought_date` date DEFAULT NULL,
  `sold_date` date DEFAULT NULL,
  `bought_weight` int(11) DEFAULT NULL,
  `color_id` bigint(20) unsigned DEFAULT NULL,
  `type_id` bigint(20) unsigned DEFAULT NULL,
  `owner_id` bigint(20) unsigned DEFAULT NULL,
  `status_id` bigint(20) unsigned DEFAULT NULL,
  `animal_id` bigint(20) unsigned DEFAULT NULL,
  `earing_color_id` bigint(20) unsigned DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `animals_color_id_foreign` (`color_id`),
  KEY `animals_type_id_foreign` (`type_id`),
  KEY `animals_owner_id_foreign` (`owner_id`),
  KEY `animals_status_id_foreign` (`status_id`),
  KEY `animals_animal_id_foreign` (`animal_id`),
  KEY `animals_earing_color_id_foreign` (`earing_color_id`),
  CONSTRAINT `animals_animal_id_foreign` FOREIGN KEY (`animal_id`) REFERENCES `animals` (`id`) ON DELETE SET NULL,
  CONSTRAINT `animals_color_id_foreign` FOREIGN KEY (`color_id`) REFERENCES `colors` (`id`) ON DELETE SET NULL,
  CONSTRAINT `animals_earing_color_id_foreign` FOREIGN KEY (`earing_color_id`) REFERENCES `earing_colors` (`id`) ON DELETE SET NULL,
  CONSTRAINT `animals_owner_id_foreign` FOREIGN KEY (`owner_id`) REFERENCES `owners` (`id`) ON DELETE SET NULL,
  CONSTRAINT `animals_status_id_foreign` FOREIGN KEY (`status_id`) REFERENCES `statuses` (`id`) ON DELETE SET NULL,
  CONSTRAINT `animals_type_id_foreign` FOREIGN KEY (`type_id`) REFERENCES `types` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=41 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `animals`
--

LOCK TABLES `animals` WRITE;
/*!40000 ALTER TABLE `animals` DISABLE KEYS */;
INSERT INTO `animals` VALUES (1,'0001','1','Samuel',4010.00,NULL,'2','Manuel Tut',NULL,NULL,'2022-02-03',NULL,460,1,1,3,1,NULL,9,'2022-04-08 08:49:25','2024-02-16 01:20:19'),(2,'0001','2','Mi papa me la dio en reposicion de la vaca blanca tambien comprada a chango que salio mala.\r\n\r\nAntes vaca 53',NULL,NULL,'2','Chango',NULL,NULL,NULL,NULL,NULL,4,7,3,10,NULL,9,'2022-04-08 08:51:33','2022-04-15 03:49:39'),(3,'0025','2','Editar Info',NULL,NULL,'2',NULL,NULL,NULL,NULL,NULL,NULL,1,7,1,9,NULL,3,'2022-04-08 08:53:16','2022-04-08 08:53:16'),(4,'0003','1','Hijo de vaca 25, de Amjor',NULL,NULL,'1',NULL,NULL,NULL,NULL,NULL,NULL,1,2,3,1,3,9,'2022-04-08 08:55:41','2022-06-01 03:29:30'),(5,'0002','1','Desmadrado 11/8/2021',NULL,NULL,'1',NULL,NULL,'2021-02-20',NULL,NULL,NULL,4,1,3,1,2,3,'2022-04-15 03:53:20','2024-02-16 01:17:44'),(6,'0001','2','Se vendio, y me dieron en remplazo la #1 bermeja',NULL,NULL,'2','Chango',NULL,NULL,NULL,NULL,NULL,1,7,3,1,NULL,9,'2022-04-15 03:56:35','2022-04-15 03:56:35'),(7,'0002','2','Hija de vaca blanca que se cambio por vaca #1 bermeja.',NULL,NULL,'1',NULL,NULL,'2019-10-04',NULL,NULL,NULL,1,7,3,7,6,9,'2022-04-15 03:58:26','2025-01-30 05:27:15'),(8,'0004','1','Hijo de vaca 1, pario cuando mis papas estaban aca. La vaca dejo adentro la placenta',NULL,NULL,'1',NULL,NULL,'2022-03-04',NULL,NULL,NULL,6,2,3,1,2,9,'2022-04-15 04:02:20','2025-02-19 02:42:01'),(9,'0088','2','Es criolla pero no se tienen datos',NULL,NULL,'2',NULL,NULL,NULL,NULL,NULL,NULL,5,7,1,8,NULL,4,'2022-04-15 04:08:02','2022-04-15 04:08:02'),(10,'0003','2','No ha desmadrado',NULL,NULL,'1',NULL,NULL,'2021-08-14',NULL,NULL,NULL,5,5,5,10,9,9,'2022-04-15 04:09:21','2025-01-30 05:28:34'),(11,'0004','2','Regalo de amjor a juandi, Vaca hosca Cachuda',0.00,NULL,'2','Amjor',NULL,NULL,'2019-08-24',NULL,NULL,3,7,4,8,NULL,9,'2022-04-15 04:11:39','2022-04-15 04:11:39'),(12,'0005','2','Antes era la 136. Ya anda con toro. Blanca cara hosca',NULL,NULL,'1',NULL,NULL,'2018-07-21',NULL,NULL,NULL,1,7,4,7,11,9,'2022-04-15 04:22:08','2025-01-30 05:36:20'),(13,'0006','2','Esta en crecimiento, era la numero 50',NULL,NULL,'1',NULL,NULL,'2021-03-16',NULL,NULL,NULL,4,5,4,7,11,9,'2022-04-15 04:25:23','2025-01-30 05:36:05'),(14,'0005','1','Antes era numero 21.',NULL,NULL,'1',NULL,NULL,'2020-03-09',NULL,NULL,NULL,3,1,4,1,11,9,'2022-04-15 04:33:01','2023-02-10 22:39:58'),(15,'0008','2','Vaca herencia de Abuelo Miguel, vino novilla pero ya esta vieja',NULL,NULL,'2','Herencia Irma',NULL,NULL,'2010-04-02',NULL,NULL,1,7,2,1,NULL,3,'2022-04-18 21:11:49','2025-02-01 06:28:34'),(16,'0069','2',NULL,NULL,NULL,'2',NULL,NULL,NULL,NULL,NULL,NULL,1,7,1,7,NULL,4,'2022-04-22 01:46:27','2022-04-22 01:46:27'),(18,'0088','1',NULL,NULL,NULL,'1',NULL,NULL,NULL,NULL,NULL,NULL,4,1,1,10,16,4,'2022-04-24 04:42:51','2022-04-24 05:08:07'),(19,'0006','1','Compradop junto con el 7, en reposicion del chivo #3',4509.00,NULL,'2','Mario Xal',NULL,NULL,'2022-05-27',NULL,480,4,1,3,1,NULL,9,'2022-06-01 03:48:51','2024-02-16 01:19:49'),(20,'0007','1','Comprado junto con el 6, en reposicion del numero 3',4509.00,NULL,'2','Mario Xal',NULL,NULL,'2022-05-27',NULL,490,5,1,3,1,NULL,9,'2022-06-01 03:51:50','2025-02-01 06:27:03'),(21,'0009','1','Chivito que le nacio a juandi',NULL,NULL,'1',NULL,NULL,'2022-07-15',NULL,NULL,NULL,1,1,4,10,11,9,'2022-08-19 05:59:14','2025-01-30 05:40:06'),(22,'0008','1','Lo compro mi papa a Q10 x libra cuando se fue con mi mama a la finca',4350.00,NULL,'2','Mario Xal',NULL,NULL,'2022-08-18',NULL,435,1,1,3,1,NULL,9,'2022-08-19 06:07:05','2025-02-01 06:28:08'),(23,'0010','1','Chivo de juandi',NULL,NULL,'1',NULL,NULL,'2023-01-28',NULL,NULL,NULL,1,1,4,5,12,9,'2023-06-01 05:47:03','2025-04-18 23:58:01'),(24,'0007','2','Reportada en febrero, no se sabe el color',NULL,NULL,'1',NULL,NULL,'2023-12-10',NULL,NULL,NULL,6,4,3,8,7,1,'2024-02-16 01:12:12','2024-02-16 01:12:49'),(25,'0008','2','Chiva Blanca, reportada en febrero 2024',NULL,NULL,'1',NULL,NULL,'2023-12-24',NULL,NULL,NULL,6,4,4,7,11,9,'2024-02-16 01:14:23','2024-02-16 01:14:23'),(26,'0011','1',NULL,5000.00,NULL,'2','Papa',NULL,NULL,'2023-11-14',NULL,100,5,1,3,9,NULL,9,'2024-02-16 01:22:20','2025-04-19 07:30:25'),(27,'0012','1','Se reporta nacimiento en febrero 2024',NULL,NULL,'1',NULL,NULL,'2024-02-15',NULL,NULL,NULL,6,1,3,3,6,9,'2024-02-16 01:23:20','2025-02-01 06:30:39'),(28,'0009','2',NULL,NULL,NULL,'1',NULL,NULL,'2025-01-15',NULL,NULL,NULL,6,4,3,7,2,9,'2025-01-30 05:24:38','2025-01-30 05:25:46'),(29,'0021','1','no se sabe si es macho o hembra',NULL,NULL,'1',NULL,NULL,'2025-01-28',NULL,NULL,NULL,1,1,4,7,12,9,'2025-01-30 05:35:19','2025-01-30 05:35:19'),(31,'0013','1',NULL,NULL,NULL,'2','papa',NULL,NULL,'2024-09-18',NULL,450,6,1,4,3,NULL,9,'2025-01-30 05:47:59','2025-01-30 06:02:48'),(32,'0014','1','chivos comprados en lote grande',NULL,NULL,'2','papa',NULL,NULL,'2024-10-19',NULL,NULL,3,1,4,3,NULL,9,'2025-01-30 05:52:48','2025-01-30 06:03:27'),(33,'0015','1','comprados en lote grande',4000.00,NULL,'2','papa',NULL,NULL,'2024-10-26',NULL,NULL,4,1,5,3,NULL,9,'2025-01-30 05:53:47','2025-01-30 06:03:55'),(34,'0016','1','comprado en lote grande no se sabe el color',4000.00,NULL,'2','papa',NULL,NULL,'2024-10-29',NULL,NULL,6,1,3,3,NULL,9,'2025-01-30 05:55:17','2025-02-01 06:30:25'),(35,'0017','1','comprado en lote grande',4000.00,NULL,'2','papa',NULL,NULL,'2024-10-29',NULL,480,6,1,3,3,NULL,9,'2025-01-30 05:56:28','2025-01-30 05:56:28'),(36,'0018','1','comprado en lote grande',NULL,NULL,'2','papa',NULL,NULL,'2024-10-26',NULL,NULL,4,1,3,1,NULL,9,'2025-01-30 05:58:02','2025-05-02 22:50:21'),(37,'0019','1','comprado en lote grande',4000.00,NULL,'2','papa',NULL,NULL,'2024-10-26',NULL,480,5,1,3,3,NULL,9,'2025-01-30 05:59:15','2025-01-30 05:59:33'),(38,'0020','1','comprado en lote grande',400.00,NULL,'2','papa',NULL,NULL,'2024-10-26',NULL,500,6,1,3,1,NULL,9,'2025-01-30 06:00:51','2025-05-02 22:48:35'),(39,'0010','2',NULL,NULL,NULL,'1',NULL,NULL,'2025-02-05',NULL,NULL,NULL,3,4,4,7,11,9,'2025-02-06 04:15:37','2025-04-19 00:45:24'),(40,'0022','1',NULL,NULL,NULL,'1',NULL,NULL,'2025-03-03',NULL,NULL,NULL,5,1,5,8,10,9,'2025-04-19 00:58:40','2025-04-19 00:58:40');
/*!40000 ALTER TABLE `animals` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `badge_colors`
--

DROP TABLE IF EXISTS `badge_colors`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `badge_colors` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `color` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `badge_colors`
--

LOCK TABLES `badge_colors` WRITE;
/*!40000 ALTER TABLE `badge_colors` DISABLE KEYS */;
INSERT INTO `badge_colors` VALUES (1,'badge-soft-primary','Celeste','2022-04-08 08:47:59','2022-04-08 08:47:59'),(2,'badge-soft-secondary','Gris','2022-04-08 08:47:59','2022-04-08 08:47:59'),(3,'badge-soft-success','Verde','2022-04-08 08:47:59','2022-04-08 08:47:59'),(4,'badge-soft-info','Aqua','2022-04-08 08:47:59','2022-04-08 08:47:59'),(5,'badge-soft-warning','Naranja','2022-04-08 08:47:59','2022-04-08 08:47:59'),(6,'badge-soft-danger','Rojo','2022-04-08 08:47:59','2022-04-08 08:47:59'),(7,'badge-soft-dark','Negro','2022-04-08 08:47:59','2022-04-08 08:47:59');
/*!40000 ALTER TABLE `badge_colors` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `colors`
--

DROP TABLE IF EXISTS `colors`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `colors` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `colors`
--

LOCK TABLES `colors` WRITE;
/*!40000 ALTER TABLE `colors` DISABLE KEYS */;
INSERT INTO `colors` VALUES (1,'Blanco','2022-04-08 08:47:59','2022-04-08 08:47:59'),(2,'Prieto','2022-04-08 08:47:59','2022-04-08 08:47:59'),(3,'Hosco','2022-04-08 08:47:59','2022-04-08 08:47:59'),(4,'Bermejo','2022-04-08 08:47:59','2022-04-08 08:47:59'),(5,'Rojo','2022-04-08 08:47:59','2022-04-08 08:47:59'),(6,'Bermeja Cara Overa','2022-04-08 08:56:22','2022-04-08 08:56:22'),(7,'Blanco cara hosca','2022-04-15 04:26:54','2022-04-15 04:26:54');
/*!40000 ALTER TABLE `colors` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `comment_types`
--

DROP TABLE IF EXISTS `comment_types`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `comment_types` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `icon` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'far fa-comment-dots',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `comment_types`
--

LOCK TABLES `comment_types` WRITE;
/*!40000 ALTER TABLE `comment_types` DISABLE KEYS */;
INSERT INTO `comment_types` VALUES (1,'Comentarios','far fa-comment-dots','2022-04-08 08:48:00','2022-04-08 08:48:00'),(2,'Pesa','fas fa-weight','2022-04-08 08:48:00','2022-04-08 08:48:00'),(3,'Edicion','far fa-edit','2022-04-08 08:48:00','2022-04-08 08:48:00');
/*!40000 ALTER TABLE `comment_types` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `comments`
--

DROP TABLE IF EXISTS `comments`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `comments` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `comment` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `animal_id` bigint(20) unsigned DEFAULT NULL,
  `comment_type_id` bigint(20) unsigned DEFAULT NULL,
  `user_id` bigint(20) unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `comments_animal_id_foreign` (`animal_id`),
  KEY `comments_comment_type_id_foreign` (`comment_type_id`),
  KEY `comments_user_id_foreign` (`user_id`),
  CONSTRAINT `comments_animal_id_foreign` FOREIGN KEY (`animal_id`) REFERENCES `animals` (`id`) ON DELETE SET NULL,
  CONSTRAINT `comments_comment_type_id_foreign` FOREIGN KEY (`comment_type_id`) REFERENCES `comment_types` (`id`) ON DELETE SET NULL,
  CONSTRAINT `comments_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=155 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `comments`
--

LOCK TABLES `comments` WRITE;
/*!40000 ALTER TABLE `comments` DISABLE KEYS */;
INSERT INTO `comments` VALUES (1,'Animal #1 ingresado el dia 08/04/2022',1,1,1,'2022-04-08 08:49:25','2022-04-08 08:49:25'),(2,'Peso de compra Chivo# 1: 460lbs',1,2,1,'2022-04-08 08:49:25','2022-04-08 08:49:25'),(3,'Animal #53 ingresado el dia 08/04/2022',2,1,1,'2022-04-08 08:51:33','2022-04-08 08:51:33'),(4,'Animal #25 ingresado el dia 08/04/2022',3,1,1,'2022-04-08 08:53:16','2022-04-08 08:53:16'),(5,'Animal #3 ingresado el dia 08/04/2022',4,1,1,'2022-04-08 08:55:41','2022-04-08 08:55:41'),(6,'Datos reales',1,3,1,'2022-04-15 03:42:02','2022-04-15 03:42:02'),(7,'Datos Reales',4,3,1,'2022-04-15 03:45:25','2022-04-15 03:45:25'),(8,'Pesa al dia 03/02/2022: 775',4,2,1,'2022-04-15 03:45:59','2022-04-15 03:45:59'),(9,'Vendido a Samuel el 30 dic 2020',4,1,1,'2022-04-15 03:46:32','2022-04-15 03:46:32'),(10,'Cambio de numeracion a correlativos sam',2,3,1,'2022-04-15 03:49:39','2022-04-15 03:49:39'),(11,'Animal #2 ingresado el dia 14/04/2022',5,1,1,'2022-04-15 03:53:20','2022-04-15 03:53:20'),(12,'Animal #1 ingresado el dia 14/04/2022',6,1,1,'2022-04-15 03:56:35','2022-04-15 03:56:35'),(13,'Animal #2 ingresado el dia 14/04/2022',7,1,1,'2022-04-15 03:58:26','2022-04-15 03:58:26'),(14,'Anda con toro, ',7,1,1,'2022-04-15 03:58:51','2022-04-15 03:58:51'),(15,'Animal #4 ingresado el dia 14/04/2022',8,1,1,'2022-04-15 04:02:20','2022-04-15 04:02:20'),(16,'Animal #88 ingresado el dia 14/04/2022',9,1,1,'2022-04-15 04:08:02','2022-04-15 04:08:02'),(17,'Animal #3 ingresado el dia 14/04/2022',10,1,1,'2022-04-15 04:09:21','2022-04-15 04:09:21'),(18,'Animal #4 ingresado el dia 14/04/2022',11,1,1,'2022-04-15 04:11:39','2022-04-15 04:11:39'),(19,'Palpada por marvin, Cargada',11,1,1,'2022-04-15 04:12:41','2022-04-15 04:12:41'),(20,'Antes era numero 33, arete rojo',11,1,1,'2022-04-15 04:15:48','2022-04-15 04:15:48'),(21,'Animal #5 ingresado el dia 14/04/2022',12,1,1,'2022-04-15 04:22:08','2022-04-15 04:22:08'),(22,'Animal #6 ingresado el dia 14/04/2022',13,1,1,'2022-04-15 04:25:23','2022-04-15 04:25:23'),(23,'se agrega numero',13,3,1,'2022-04-15 04:26:16','2022-04-15 04:26:16'),(24,'Animal #5 ingresado el dia 14/04/2022',14,1,1,'2022-04-15 04:33:01','2022-04-15 04:33:01'),(25,'puesto a nombre de juandi, me equivoque en ingreso',12,3,1,'2022-04-17 19:11:23','2022-04-17 19:11:23'),(26,'Pesa al dia 17/04/2022: 430',1,2,1,'2022-04-17 20:30:38','2022-04-17 20:30:38'),(27,'Pesa al dia 17/04/2022: 775',4,2,1,'2022-04-17 20:31:17','2022-04-17 20:31:17'),(28,'Pesa al dia 03/02/2022: 390',5,2,1,'2022-04-17 20:32:40','2022-04-17 20:32:40'),(29,'Pesa al dia 17/04/2022: 430',5,2,1,'2022-04-17 20:33:15','2022-04-17 20:33:15'),(30,'Pesa al dia 03/02/2022: 630',14,2,1,'2022-04-17 20:34:11','2022-04-17 20:34:11'),(31,'Pesa al dia 17/04/2022: 655',14,2,1,'2022-04-17 20:34:53','2022-04-17 20:34:53'),(32,'Pesa al dia 17/04/2022: 760',2,2,1,'2022-04-17 20:35:49','2022-04-17 20:35:49'),(33,'Pesa al dia 17/04/2022: 665',7,2,1,'2022-04-17 20:36:53','2022-04-17 20:36:53'),(34,'Pesa al dia 17/04/2022: 1085',11,2,1,'2022-04-17 20:37:41','2022-04-17 20:37:41'),(35,'ya anda con toro',12,1,1,'2022-04-17 20:38:42','2022-04-17 20:38:42'),(36,'Pesa al dia 17/04/2022: 790',12,2,1,'2022-04-17 20:38:52','2022-04-17 20:38:52'),(37,'Pesa al dia 17/04/2022: 300',13,2,1,'2022-04-17 20:39:46','2022-04-17 20:39:46'),(38,'Pesa al dia 17/04/2022: 370',10,2,1,'2022-04-17 20:40:43','2022-04-17 20:40:43'),(39,'Animal #8 ingresado el dia 18/04/2022',15,1,1,'2022-04-18 21:11:49','2022-04-18 21:11:49'),(40,'Pesa al dia 18/04/2022: 100',8,2,1,'2022-04-18 21:31:45','2022-04-18 21:31:45'),(41,'Animal #69 ingresado el dia 21/04/2022',16,1,1,'2022-04-22 01:46:27','2022-04-22 01:46:27'),(42,'Se le aplico apetovit, 10ml el dia 16/4/22',16,1,1,'2022-04-22 01:51:42','2022-04-22 01:51:42'),(43,'Pesa al dia 16/04/2022: 730',16,2,1,'2022-04-22 01:58:47','2022-04-22 01:58:47'),(44,'Animal #88 ingresado el dia 21/04/2022',NULL,1,1,'2022-04-22 02:02:32','2022-04-22 02:02:32'),(45,'Pesa al dia 16/04/2022: 890',9,2,1,'2022-04-24 04:38:05','2022-04-24 04:38:05'),(46,'Animal #88 ingresado el dia 23/04/2022',18,1,1,'2022-04-24 04:42:51','2022-04-24 04:42:51'),(47,'se cambia la mama por la 69, habia error',18,3,1,'2022-04-24 05:02:02','2022-04-24 05:02:02'),(48,'Pesa al dia 16/04/2022: 195',18,2,1,'2022-04-24 05:09:29','2022-04-24 05:09:29'),(49,'Pesa al dia 06/05/2022: 900',4,2,1,'2022-06-01 03:25:55','2022-06-01 03:25:55'),(50,'Se vendio Animal, en 900lb a 8.30 x lb, a Amjor',4,1,1,'2022-06-01 03:26:39','2022-06-01 03:26:39'),(51,'Animal #6 ingresado el dia 31/05/2022',19,1,1,'2022-06-01 03:48:51','2022-06-01 03:48:51'),(52,'Peso de compra Chivo# 6: 480lbs',19,2,1,'2022-06-01 03:48:51','2022-06-01 03:48:51'),(53,'Animal #7 ingresado el dia 31/05/2022',20,1,1,'2022-06-01 03:51:50','2022-06-01 03:51:50'),(54,'Peso de compra Chivo# 7: 490lbs',20,2,1,'2022-06-01 03:51:50','2022-06-01 03:51:50'),(55,'Animal #8 ingresado el dia 18/08/2022',21,1,1,'2022-08-19 05:59:14','2022-08-19 05:59:14'),(56,'Animal #9 ingresado el dia 19/08/2022',22,1,1,'2022-08-19 06:07:05','2022-08-19 06:07:05'),(57,'Peso de compra Chivo# 9: 435lbs',22,2,1,'2022-08-19 06:07:05','2022-08-19 06:07:05'),(58,'Pesa al dia 19/08/2022: 435',22,2,1,'2022-08-19 06:08:22','2022-08-19 06:08:22'),(59,'Pesa al dia 17/01/2023: 890',14,2,1,'2023-01-17 22:06:05','2023-01-17 22:06:05'),(60,'se vendio el 16 de enero del 2023, aun no han pagado...',14,1,1,'2023-01-17 23:55:29','2023-01-17 23:55:29'),(61,'Pesa al dia 20/01/2023: 500',19,2,1,'2023-01-20 06:04:31','2023-01-20 06:04:31'),(62,'Pesa al dia 20/01/2023: 430',21,2,1,'2023-01-20 06:10:37','2023-01-20 06:10:37'),(63,'Pesa al dia 20/01/2023: 560',1,2,1,'2023-01-20 06:12:21','2023-01-20 06:12:21'),(64,'Pesa al dia 10/02/2023: 890',14,2,1,'2023-02-10 22:13:33','2023-02-10 22:13:33'),(65,'Se pago el 10 de febrero, con cheque 3407004877 Amjor,',14,1,1,'2023-02-10 22:14:45','2023-02-10 22:14:45'),(66,'Precio de venta x libra=9.10',14,1,1,'2023-02-10 22:15:42','2023-02-10 22:15:42'),(67,'Pario el 4 de febrero 2023, pario Macho',12,1,1,'2023-02-10 22:41:27','2023-02-10 22:41:27'),(68,'Pesa al dia 29/05/2023: 575',10,2,1,'2023-05-30 05:29:33','2023-05-30 05:29:33'),(69,'Pesa al dia 29/05/2023: 350',8,2,1,'2023-05-30 05:30:04','2023-05-30 05:30:04'),(70,'Pesa al dia 29/05/2023: 570',19,2,1,'2023-05-30 05:37:28','2023-05-30 05:37:28'),(71,'Pesa al dia 29/05/2023: 605',1,2,1,'2023-05-30 05:38:09','2023-05-30 05:38:09'),(72,'Pesa al dia 29/05/2023: 505',20,2,1,'2023-05-30 05:38:32','2023-05-30 05:38:32'),(73,'Pesa al dia 29/05/2023: 480',21,2,1,'2023-05-30 05:39:49','2023-05-30 05:39:49'),(74,'Esta en lote ya listo para la venta en jovente (Cuando juandi fue a la finca)',5,1,1,'2023-05-30 05:40:59','2023-05-30 05:40:59'),(75,'Pesa al dia 31/05/2023: 480',22,2,1,'2023-06-01 05:38:52','2023-06-01 05:38:52'),(76,'Mayo 2023 desmadrado',21,1,1,'2023-06-01 05:41:47','2023-06-01 05:41:47'),(77,'Hubo una confusion entre el numero 8 y 9. Los pesos inicialmente escritos no son los correctos. Ver pesos a partir de mayo 2023',21,1,1,'2023-06-01 05:42:33','2023-06-01 05:42:33'),(78,'Pesa al dia 31/05/2023: 290',21,2,1,'2023-06-01 05:42:41','2023-06-01 05:42:41'),(79,'Pesa al dia 31/05/2023: 805',5,2,1,'2023-06-01 05:43:17','2023-06-01 05:43:17'),(80,'Animal #10 ingresado el dia 31/05/2023',23,1,1,'2023-06-01 05:47:03','2023-06-01 05:47:03'),(81,'Pesa al dia 08/11/2023: 1010',5,2,1,'2023-11-08 22:47:22','2023-11-08 22:47:22'),(82,'Vendido 6 noviembre 2023, pagado con un checque por Q9595, Se le paga a mi papa Q5205 por un chivo bermejo nuevo por lo que el cheque sale por 4390',5,1,1,'2023-11-08 22:52:36','2023-11-08 22:52:36'),(83,'Animal #7 ingresado el dia 15/02/2024',24,1,1,'2024-02-16 01:12:12','2024-02-16 01:12:12'),(84,'Animal #8 ingresado el dia 15/02/2024',25,1,1,'2024-02-16 01:14:23','2024-02-16 01:14:23'),(85,'Supuestamente se vendio en enero 2024, en febrero se reporta como vendido',1,1,1,'2024-02-16 01:16:28','2024-02-16 01:16:28'),(86,'Supuestamente se vendio en enero, se reporta como vendido en febrero 2024',5,1,1,'2024-02-16 01:17:07','2024-02-16 01:17:07'),(87,'Se vendio en enero, aun se debe',19,1,1,'2024-02-16 01:19:39','2024-02-16 01:19:39'),(88,'se confirma vendido',1,1,1,'2024-02-16 01:20:12','2024-02-16 01:20:12'),(89,'Animal #11 ingresado el dia 15/02/2024',26,1,1,'2024-02-16 01:22:20','2024-02-16 01:22:20'),(90,'Peso de compra Chivo# 11: 100lbs',26,2,1,'2024-02-16 01:22:20','2024-02-16 01:22:20'),(91,'Animal #12 ingresado el dia 15/02/2024',27,1,1,'2024-02-16 01:23:20','2024-02-16 01:23:20'),(92,'Animal #9 ingresado el dia 29/01/2025',28,1,1,'2025-01-30 05:24:38','2025-01-30 05:24:38'),(93,'sexo',28,3,1,'2025-01-30 05:25:46','2025-01-30 05:25:46'),(94,'Cambio a ser vaca',7,3,1,'2025-01-30 05:27:15','2025-01-30 05:27:15'),(95,'Cambia novilla, regalo irma',10,3,1,'2025-01-30 05:28:34','2025-01-30 05:28:34'),(96,'Pesa al dia 29/01/2025: 700',8,2,1,'2025-01-30 05:29:01','2025-01-30 05:29:01'),(97,'ya es novillo',8,3,1,'2025-01-30 05:29:37','2025-01-30 05:29:37'),(98,'Animal #21 ingresado el dia 29/01/2025',29,1,1,'2025-01-30 05:35:19','2025-01-30 05:35:19'),(99,'cambia a ser novilla',13,3,1,'2025-01-30 05:36:05','2025-01-30 05:36:05'),(100,'cambia a ser vaca',12,3,1,'2025-01-30 05:36:20','2025-01-30 05:36:20'),(101,'considerado peso \"intermedio\"',23,1,1,'2025-01-30 05:42:47','2025-01-30 05:42:47'),(102,'considerado peso intermedio',26,1,1,'2025-01-30 05:45:03','2025-01-30 05:45:03'),(103,'Se reporta peso intermedio',27,1,1,'2025-01-30 05:45:51','2025-01-30 05:45:51'),(104,'Animal #13 ingresado el dia 29/01/2025',NULL,1,1,'2025-01-30 05:47:36','2025-01-30 05:47:36'),(105,'Animal #13 ingresado el dia 29/01/2025',31,1,1,'2025-01-30 05:47:59','2025-01-30 05:47:59'),(106,'Peso de compra Chivo# 13: 450lbs',31,2,1,'2025-01-30 05:47:59','2025-01-30 05:47:59'),(107,'Animal #14 ingresado el dia 29/01/2025',32,1,1,'2025-01-30 05:52:48','2025-01-30 05:52:48'),(108,'Animal #15 ingresado el dia 29/01/2025',33,1,1,'2025-01-30 05:53:47','2025-01-30 05:53:47'),(109,'Animal #16 ingresado el dia 29/01/2025',34,1,1,'2025-01-30 05:55:17','2025-01-30 05:55:17'),(110,'Animal #17 ingresado el dia 29/01/2025',35,1,1,'2025-01-30 05:56:28','2025-01-30 05:56:28'),(111,'Peso de compra Chivo# 17: 480lbs',35,2,1,'2025-01-30 05:56:28','2025-01-30 05:56:28'),(112,'Animal #18 ingresado el dia 29/01/2025',36,1,1,'2025-01-30 05:58:02','2025-01-30 05:58:02'),(113,'Animal #19 ingresado el dia 29/01/2025',37,1,1,'2025-01-30 05:59:15','2025-01-30 05:59:15'),(114,'Peso de compra Chivo# 19: 480lbs',37,2,1,'2025-01-30 05:59:15','2025-01-30 05:59:15'),(115,'Animal #20 ingresado el dia 30/01/2025',38,1,1,'2025-01-30 06:00:51','2025-01-30 06:00:51'),(116,'Peso de compra Chivo# 20: 500lbs',38,2,1,'2025-01-30 06:00:51','2025-01-30 06:00:51'),(117,'se vendio el 10/7/2024',20,1,1,'2025-02-01 06:26:51','2025-02-01 06:26:51'),(118,'Se vendio el 10/7/2024 junto con el chivo 7. por Q17,955',22,1,1,'2025-02-01 06:27:57','2025-02-01 06:27:57'),(119,'Animal #22 ingresado el dia 05/02/2025',39,1,1,'2025-02-06 04:15:37','2025-02-06 04:15:37'),(120,'vendido por Q9792',8,1,1,'2025-02-19 02:42:39','2025-02-19 02:42:39'),(121,'Pesa al dia 18/04/2025: 740',10,2,1,'2025-04-18 23:49:00','2025-04-18 23:49:00'),(122,'Pesa al dia 18/04/2025: 760',26,2,1,'2025-04-18 23:51:41','2025-04-18 23:51:41'),(123,'Pesa al dia 18/04/2025: 1020',7,2,1,'2025-04-18 23:53:56','2025-04-18 23:53:56'),(124,'Pesa al dia 18/04/2025: 780',23,2,1,'2025-04-18 23:57:45','2025-04-18 23:57:45'),(125,'Pesa al dia 18/04/2025: 570',31,2,1,'2025-04-19 00:00:49','2025-04-19 00:00:49'),(126,'Pesa al dia 18/04/2025: 500',25,2,1,'2025-04-19 00:02:35','2025-04-19 00:02:35'),(127,'Pesa al dia 18/04/2025: 500',34,2,1,'2025-04-19 00:09:36','2025-04-19 00:09:36'),(128,'feo',34,1,1,'2025-04-19 00:11:58','2025-04-19 00:11:58'),(129,'Pesa al dia 18/04/2025: 580',33,2,1,'2025-04-19 00:13:20','2025-04-19 00:13:20'),(130,'Pesa al dia 18/04/2025: 990',11,2,1,'2025-04-19 00:16:56','2025-04-19 00:16:56'),(131,'Pesa al dia 18/04/2025: 870',21,2,1,'2025-04-19 00:21:37','2025-04-19 00:21:37'),(132,'va pa disney',21,1,1,'2025-04-19 00:23:45','2025-04-19 00:23:45'),(133,'Pesa al dia 18/04/2025: 180',29,2,1,'2025-04-19 00:24:45','2025-04-19 00:24:45'),(134,'Pesa al dia 18/04/2025: 600',37,2,1,'2025-04-19 00:26:47','2025-04-19 00:26:47'),(135,'Pesa al dia 18/04/2025: 420',24,2,1,'2025-04-19 00:28:24','2025-04-19 00:28:24'),(136,'Pesa al dia 18/04/2025: 1020',38,2,1,'2025-04-19 00:29:50','2025-04-19 00:29:50'),(137,'va para disney',38,1,1,'2025-04-19 00:30:09','2025-04-19 00:30:09'),(138,'Pesa al dia 18/04/2025: 940',2,2,1,'2025-04-19 00:33:06','2025-04-19 00:33:06'),(139,'Pesa al dia 18/04/2025: 560',32,2,1,'2025-04-19 00:35:59','2025-04-19 00:35:59'),(140,'Pesa al dia 18/04/2025: 680',27,2,1,'2025-04-19 00:37:40','2025-04-19 00:37:40'),(141,'Pesa al dia 18/04/2025: 865',12,2,1,'2025-04-19 00:39:41','2025-04-19 00:39:41'),(142,'Pesa al dia 18/04/2025: 160',39,2,1,'2025-04-19 00:45:55','2025-04-19 00:45:55'),(143,'Pesa al dia 18/04/2025: 900',13,2,1,'2025-04-19 00:48:08','2025-04-19 00:48:08'),(144,'Pesa al dia 18/04/2025: 950',36,2,1,'2025-04-19 00:50:43','2025-04-19 00:50:43'),(145,'Pesa al dia 18/04/2025: 550',35,2,1,'2025-04-19 00:52:51','2025-04-19 00:52:51'),(146,'Pesa al dia 18/04/2025: 180',28,2,1,'2025-04-19 00:54:25','2025-04-19 00:54:25'),(147,'Animal #22 ingresado el dia 18/04/2025',40,1,1,'2025-04-19 00:58:40','2025-04-19 00:58:40'),(148,'Pesa al dia 18/04/2025: 140',40,2,1,'2025-04-19 01:00:41','2025-04-19 01:00:41'),(149,'Vendido a 1000',38,1,1,'2025-05-02 22:48:07','2025-05-02 22:48:07'),(150,'Pesa al dia 02/05/2025: 1000',38,2,1,'2025-05-02 22:48:13','2025-05-02 22:48:13'),(151,'Pesa al dia 02/05/2025: 1020',36,2,1,'2025-05-02 22:49:58','2025-05-02 22:49:58'),(152,'vendido con 1020',36,1,1,'2025-05-02 22:50:12','2025-05-02 22:50:12'),(153,'Q9.60  x lb',36,1,1,'2025-05-02 22:51:40','2025-05-02 22:51:40'),(154,'9.60 x libra',38,1,1,'2025-05-02 22:52:02','2025-05-02 22:52:02');
/*!40000 ALTER TABLE `comments` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `earing_colors`
--

DROP TABLE IF EXISTS `earing_colors`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `earing_colors` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `earing_colors`
--

LOCK TABLES `earing_colors` WRITE;
/*!40000 ALTER TABLE `earing_colors` DISABLE KEYS */;
INSERT INTO `earing_colors` VALUES (1,'Azul','2022-04-08 08:48:00','2022-04-08 08:48:00'),(2,'Verde','2022-04-08 08:48:00','2022-04-08 08:48:00'),(3,'Amarillo','2022-04-08 08:48:00','2022-04-08 08:48:00'),(4,'Rojo','2022-04-08 08:48:00','2022-04-08 08:48:00'),(5,'Negro','2022-04-08 08:48:00','2022-04-08 08:48:00'),(6,'Blanco','2022-04-08 08:48:00','2022-04-08 08:48:00'),(7,'Naranja','2022-04-08 08:48:00','2022-04-08 08:48:00'),(8,'Cafe','2022-04-08 08:48:00','2022-04-08 08:48:00'),(9,'Celeste','2022-04-08 08:48:00','2022-04-08 08:48:00');
/*!40000 ALTER TABLE `earing_colors` ENABLE KEYS */;
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
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp(),
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
-- Table structure for table `images`
--

DROP TABLE IF EXISTS `images`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `images` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `url` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `imageable_id` bigint(20) unsigned NOT NULL,
  `imageable_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=255 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `images`
--

LOCK TABLES `images` WRITE;
/*!40000 ALTER TABLE `images` DISABLE KEYS */;
INSERT INTO `images` VALUES (1,'2/WhatsApp Image 2022-03-12 at 12.26.43 PM_1649386293.jpeg',2,'App\\Models\\Animal','2022-04-08 08:51:33','2022-04-08 08:51:33'),(2,'1/m0qSDfpB8MC84W4C4QcIM6TgkUxJlfpXBliB1aZO.jpg',1,'App\\Models\\Animal','2022-04-15 09:30:01','2022-04-15 09:30:01'),(3,'1/MggoTtE00nqoQiYGtU98lhIoiqPlBiZahyhpp8gu.jpg',1,'App\\Models\\Animal','2022-04-15 09:30:18','2022-04-15 09:30:18'),(4,'1/ASTNG66EOnGMnhb2luZcN8w7CDsFNFjxgGPvExjb.jpg',1,'App\\Models\\Animal','2022-04-15 09:30:30','2022-04-15 09:30:30'),(5,'1/sFACFmDcPJEgCnN14hpnWFJ0xUxeggp9WHQTdTGK.jpg',1,'App\\Models\\Animal','2022-04-15 09:30:41','2022-04-15 09:30:41'),(6,'1/6HUSEQ6La8BmGEWZjAHnx1evFqTYYZMMfucyShxj.jpg',1,'App\\Models\\Animal','2022-04-15 09:30:55','2022-04-15 09:30:55'),(7,'1/UWyA6SIwRt2KOy4TrBvC3jZP3qUCnE9GMCr5wVEI.jpg',1,'App\\Models\\Animal','2022-04-15 09:33:36','2022-04-15 09:33:36'),(8,'5/LBVPWXFiSVM0zQkBGtq2hVqicXkhNEluDV3l19tG.jpg',5,'App\\Models\\Animal','2022-04-15 09:41:46','2022-04-15 09:41:46'),(9,'5/bdY3NtU28J1eorxuixv4TKQXbmRRdLvkfaWemqBj.jpg',5,'App\\Models\\Animal','2022-04-15 09:41:55','2022-04-15 09:41:55'),(10,'5/F35p9eDVdkRzcWbMQFR4HgPrpWIwbGtviTv2TZAV.jpg',5,'App\\Models\\Animal','2022-04-15 09:42:04','2022-04-15 09:42:04'),(11,'5/x1nszaXt07H91053ibd4PUcthuVCL9UuoLjAGUNc.jpg',5,'App\\Models\\Animal','2022-04-15 09:42:19','2022-04-15 09:42:19'),(12,'5/rTN5YRur5f8YJmoz2ACgzkFkaXm8Rhvscw1OzO0S.jpg',5,'App\\Models\\Animal','2022-04-15 09:42:27','2022-04-15 09:42:27'),(13,'5/JM6T5Bd04BacGXp92kFawFiyFgQMjQaV4Q2reooG.jpg',5,'App\\Models\\Animal','2022-04-15 09:42:38','2022-04-15 09:42:38'),(14,'4/1s2YUZngD0AQQUUQkj2QFa9AlILht6LhiiKFFaUM.jpg',4,'App\\Models\\Animal','2022-04-15 09:46:36','2022-04-15 09:46:36'),(15,'4/wWKf18SZqSJcjAwJQdkO2mzDEgi3lR0d3hdrcqsk.jpg',4,'App\\Models\\Animal','2022-04-15 09:46:49','2022-04-15 09:46:49'),(16,'4/1mBQYM33wCNS6XLDQzOyhFuS5qKwRN7eqyAYz7C9.jpg',4,'App\\Models\\Animal','2022-04-15 09:47:02','2022-04-15 09:47:02'),(17,'4/N1IeOqwqE5mhDrLEnSk6sGVkFMRq7eWZ9iiCCRBM.jpg',4,'App\\Models\\Animal','2022-04-15 09:47:21','2022-04-15 09:47:21'),(18,'4/hM5RIE5su6z1tVDvifCsYYKfcfIQIxZtsLKhtfLU.jpg',4,'App\\Models\\Animal','2022-04-15 09:47:35','2022-04-15 09:47:35'),(19,'4/yMajKWDCGvNraqzhWXH1ZquWodlw45vmArWIQmNR.jpg',4,'App\\Models\\Animal','2022-04-15 09:47:48','2022-04-15 09:47:48'),(20,'4/iwzFCHspiCibdCy0F39w05bSLwswRKl5bja5EAXD.jpg',4,'App\\Models\\Animal','2022-04-15 09:48:01','2022-04-15 09:48:01'),(21,'8/uwBaLGlPpc4TgmZ92EnsWVO82sqzeZQUSt77K9ml.jpg',8,'App\\Models\\Animal','2022-04-15 09:51:51','2022-04-15 09:51:51'),(22,'8/cXF4paToMRwPD4f4tfeMDwf9cgUwayJhe2DYI52V.jpg',8,'App\\Models\\Animal','2022-04-15 09:52:11','2022-04-15 09:52:11'),(23,'8/JN18jWjDyYiKO0jWgU1SFLwRqc4QCSpNK3EoBg0V.jpg',8,'App\\Models\\Animal','2022-04-15 09:52:23','2022-04-15 09:52:23'),(24,'8/sHlA9XybDxc0Zg9McaLwVUdljgobEp9N2fSTXaVx.jpg',8,'App\\Models\\Animal','2022-04-15 09:52:33','2022-04-15 09:52:33'),(25,'8/TnyPJxTIJ8694nuXLb9nPxvUBXW4hZMv3IYZASnw.jpg',8,'App\\Models\\Animal','2022-04-15 09:52:47','2022-04-15 09:52:47'),(26,'8/HtHVe4PWpjgSyaDAhRYYVSE6uEmjybAyy1rjrcAy.jpg',8,'App\\Models\\Animal','2022-04-15 09:53:53','2022-04-15 09:53:53'),(27,'8/rd5hWKfqbgafjuWgkwRxspJWZpIo4HEWviJMwIKn.jpg',8,'App\\Models\\Animal','2022-04-15 09:55:03','2022-04-15 09:55:03'),(28,'2/SndI0mQ5RGMxJCxvEVGGZNUjDcxMSOaj7XL0rZNq.jpg',2,'App\\Models\\Animal','2022-04-15 09:59:47','2022-04-15 09:59:47'),(29,'2/Q7LE7LDz6rEve8I793Cn7iui3HxCDoua4ttd1Xlk.jpg',2,'App\\Models\\Animal','2022-04-15 09:59:59','2022-04-15 09:59:59'),(30,'2/Rr19SZmSQA3ZZAxpkzjg6tmc4TttZBiijdeJMxMt.jpg',2,'App\\Models\\Animal','2022-04-15 10:00:13','2022-04-15 10:00:13'),(31,'2/uAJG2AW1FtAubyRrnu5R1UtRTy9hUDycBpW2X6fF.jpg',2,'App\\Models\\Animal','2022-04-15 10:00:23','2022-04-15 10:00:23'),(32,'2/5K8P3ipccJDhDtgl6cAgcL54K87EhWg40LsVGUdv.jpg',2,'App\\Models\\Animal','2022-04-15 10:00:35','2022-04-15 10:00:35'),(33,'2/6y12APXTdJdYV4tMkFh2JYeH14Zmx3fTWy451zZh.jpg',2,'App\\Models\\Animal','2022-04-15 10:00:46','2022-04-15 10:00:46'),(34,'2/kA9yBBO1oNmdxd8h6S6tZXB1mE5ituBcWpWOtOan.jpg',2,'App\\Models\\Animal','2022-04-15 10:00:59','2022-04-15 10:00:59'),(35,'7/FtLVZvZYrDxyRhw1n3UNFp120mWKHZ6DVg7pqkZb.jpg',7,'App\\Models\\Animal','2022-04-15 10:04:53','2022-04-15 10:04:53'),(36,'7/AlhySSzGTqv4YI8CUtJUJUdUBS7jgxWNYn8wj0rh.jpg',7,'App\\Models\\Animal','2022-04-15 10:05:01','2022-04-15 10:05:01'),(37,'7/FWrAguK805Jq6yACqkFTNTsWpVDg039trz7ZKVtg.jpg',7,'App\\Models\\Animal','2022-04-15 10:05:10','2022-04-15 10:05:10'),(38,'7/F0uxddlFuMafKdfcxK6WRI4XZ0l2hWCQ5OPuVcqH.jpg',7,'App\\Models\\Animal','2022-04-15 10:05:19','2022-04-15 10:05:19'),(39,'7/cfPAna9uhUiAhsE3BCse42RsXDYzwpJyDape6ZfX.jpg',7,'App\\Models\\Animal','2022-04-15 10:05:28','2022-04-15 10:05:28'),(40,'7/yGBVkAhvOV35ZkBK7fdQIb2cJ4XaGuC0cAlt91A9.jpg',7,'App\\Models\\Animal','2022-04-15 10:05:47','2022-04-15 10:05:47'),(41,'14/Su1yZQpk2aB65Qa68k6E4DPrckuLGgYTmR9wLYHj.jpg',14,'App\\Models\\Animal','2022-04-15 10:24:49','2022-04-15 10:24:49'),(42,'14/kEKSKITJs5ZkcQiZ2lIBRXCExNRRGYsbC9eC2lu8.jpg',14,'App\\Models\\Animal','2022-04-15 10:25:07','2022-04-15 10:25:07'),(43,'14/lqQEPmJYSLv9YxpscvQPXCCl4vREsr2pVn0Nm8qX.jpg',14,'App\\Models\\Animal','2022-04-15 10:25:23','2022-04-15 10:25:23'),(44,'14/A5wnpVdhLRTb0E7wqJtJmzOcB5Og8EqbqIvMesNo.jpg',14,'App\\Models\\Animal','2022-04-15 10:25:32','2022-04-15 10:25:32'),(45,'14/74640UMpHDew656CY5NNKpoFiK0A6WHaXKrDK3Gz.jpg',14,'App\\Models\\Animal','2022-04-15 10:25:47','2022-04-15 10:25:47'),(46,'14/aBZZ2KSmatQFXzs6SXF6vElVeCLM6ZMW5GsHXHL2.jpg',14,'App\\Models\\Animal','2022-04-15 10:26:00','2022-04-15 10:26:00'),(47,'14/W5K8kp7PHyvmbEYdXVm9QvWbl8z9FEbfBxDulTKG.jpg',14,'App\\Models\\Animal','2022-04-15 10:26:10','2022-04-15 10:26:10'),(48,'14/vPnSTFVS8sOl6ReaHdMuLrvpBdt2mDp4gWzR7mge.jpg',14,'App\\Models\\Animal','2022-04-15 10:26:20','2022-04-15 10:26:20'),(49,'11/MYQVdvr1N0N1XjnH19vvm1ANtwfYaZc3MRf3waFL.jpg',11,'App\\Models\\Animal','2022-04-15 21:49:26','2022-04-15 21:49:26'),(50,'11/d4dwcpFEjFGYlKsRydQuNnz3cPFNWFZfsuOcHznt.jpg',11,'App\\Models\\Animal','2022-04-15 21:51:47','2022-04-15 21:51:47'),(51,'11/HOawfkzcS4IZoT0sjdRYsBOqyETBBepP8j6q1ri9.jpg',11,'App\\Models\\Animal','2022-04-15 21:51:57','2022-04-15 21:51:57'),(52,'11/x5mxfV0GCWexqjkOiv0aJXPlkxwXws761g2wqPXG.jpg',11,'App\\Models\\Animal','2022-04-15 21:52:07','2022-04-15 21:52:07'),(53,'11/gfIsaO0l9Z0YVspOd8wBY68xWdLeCqEP1yzQdGXE.jpg',11,'App\\Models\\Animal','2022-04-15 21:52:23','2022-04-15 21:52:23'),(54,'11/Nkoud7tq2xpDMkovEq0Y0RqiaGJxACo4EkwjJlMJ.jpg',11,'App\\Models\\Animal','2022-04-15 21:52:46','2022-04-15 21:52:46'),(55,'11/7Dzv7wCZ8qbHLP7QooxZrV0jpqRgMuwOVtGKcx9f.jpg',11,'App\\Models\\Animal','2022-04-15 21:52:58','2022-04-15 21:52:58'),(56,'11/IkdK7OY04w3ISWfRqqvceBZHzdqoXllo6YrmSu6l.jpg',11,'App\\Models\\Animal','2022-04-15 21:53:11','2022-04-15 21:53:11'),(57,'11/GCQPCNNaHF5SFPYBClMwD9BvFnR6jVvSIpDW1VVa.jpg',11,'App\\Models\\Animal','2022-04-15 21:54:16','2022-04-15 21:54:16'),(58,'10/OCdkg5syLF7PThGaD0WuI9HkQsMdKOfZhZAbRXRL.jpg',10,'App\\Models\\Animal','2022-04-17 19:01:43','2022-04-17 19:01:43'),(59,'10/TmjH8ovXF45bRhVxrYePg3eEKaiYpFHNQUC8g7Nl.jpg',10,'App\\Models\\Animal','2022-04-17 19:02:12','2022-04-17 19:02:12'),(60,'10/SPGkwSBh3EPvwaGWCGdeQbmhS4rCdu7eAmHnMG0N.jpg',10,'App\\Models\\Animal','2022-04-17 19:02:22','2022-04-17 19:02:22'),(61,'10/xb9G9BAKUtQkuEOLaoBZOQTViwlyUi4imONfH9Jf.jpg',10,'App\\Models\\Animal','2022-04-17 19:02:32','2022-04-17 19:02:32'),(62,'10/oXm8mzQWAoIrXb6z7NrCyouK2oyY4hTEYlOeHZYK.jpg',10,'App\\Models\\Animal','2022-04-17 19:02:51','2022-04-17 19:02:51'),(63,'10/7MDlYxtWvsETN5JzQepQJWWe94qO0f4qU0EwhAS7.jpg',10,'App\\Models\\Animal','2022-04-17 19:03:03','2022-04-17 19:03:03'),(64,'10/cmMhelV2lJNIMmzk7IqKs6gybxi8EYQuwELueyTU.jpg',10,'App\\Models\\Animal','2022-04-17 19:03:19','2022-04-17 19:03:19'),(65,'10/45NIr0POXvTKCRbUppKeLKL4kpbpicSH86Sir6oh.jpg',10,'App\\Models\\Animal','2022-04-17 19:03:28','2022-04-17 19:03:28'),(66,'13/tDn4NCGte0lcEZcbSxzCx7NbUBuALMynPHnoY4PY.jpg',13,'App\\Models\\Animal','2022-04-17 19:07:30','2022-04-17 19:07:30'),(67,'13/emABq9Sip1lXyVevrosj3Fj8NMH1A1DYZTy70rqH.jpg',13,'App\\Models\\Animal','2022-04-17 19:07:36','2022-04-17 19:07:36'),(68,'13/jSQFCFHElIdYiHWCHCb2Iki6Vr0sMisEpzK0VEbJ.jpg',13,'App\\Models\\Animal','2022-04-17 19:07:43','2022-04-17 19:07:43'),(69,'13/LYVo2zL8SomrxAWpyouaWFxOpwHAMHSI2brEfCpN.jpg',13,'App\\Models\\Animal','2022-04-17 19:07:52','2022-04-17 19:07:52'),(70,'13/8LfNyoW3qTNAT7Xxxue3Em3mzwzBMOooUtPnkcAK.jpg',13,'App\\Models\\Animal','2022-04-17 19:08:04','2022-04-17 19:08:04'),(71,'13/z0VpbDI5TcGIoDy2b9a6hSi5YypPjYiQixzvNQ2z.jpg',13,'App\\Models\\Animal','2022-04-17 19:08:15','2022-04-17 19:08:15'),(72,'13/89TG0F3mW3T5jxB4qcvEcdXZT1nyJZQ5HpAacqH7.jpg',13,'App\\Models\\Animal','2022-04-17 19:08:32','2022-04-17 19:08:32'),(73,'13/ln0KEvJMQwuR5SBtDQkVQyvetty4Br8qTwCH9u3R.jpg',13,'App\\Models\\Animal','2022-04-17 19:08:50','2022-04-17 19:08:50'),(74,'13/3S2SPyQDjr1atLgiI00TaAiLOObP1lKLx6L04jsd.jpg',13,'App\\Models\\Animal','2022-04-17 19:08:57','2022-04-17 19:08:57'),(75,'12/pWyUFZg9edosoNgkKNnIlxUXO7Gjm3MNIPutAkd8.jpg',12,'App\\Models\\Animal','2022-04-17 19:15:27','2022-04-17 19:15:27'),(76,'12/k84hEgWuCCk7biGJGbzkJWRAgcVuJ4Za0dGeZjMT.jpg',12,'App\\Models\\Animal','2022-04-17 19:15:42','2022-04-17 19:15:42'),(77,'12/OrfqS34aVW7z4QYNRAIUS479LHay86aJzFUhgnkj.jpg',12,'App\\Models\\Animal','2022-04-17 19:15:51','2022-04-17 19:15:51'),(78,'12/MnBVitvdZQwgxZTMDfxGz2C1oaTg7nscQClbQXas.jpg',12,'App\\Models\\Animal','2022-04-17 19:16:02','2022-04-17 19:16:02'),(79,'12/PYwDv1ixWQhenOD0NyfEUgzEnTDi3dGWdkPh3Jjf.jpg',12,'App\\Models\\Animal','2022-04-17 19:16:14','2022-04-17 19:16:14'),(80,'12/ftPYa7fFNDklcaamAsT5mewS9NsEDPlpqU5mDvXn.jpg',12,'App\\Models\\Animal','2022-04-17 19:17:03','2022-04-17 19:17:03'),(81,'12/G9A9eKUPpg3UHjdsh0dqLhNfueTluSL9ayVf7LQf.jpg',12,'App\\Models\\Animal','2022-04-17 19:17:17','2022-04-17 19:17:17'),(82,'12/5rXxGpX9a9PRexiHRVNqWylbjVigY4WvWGh1mBF2.jpg',12,'App\\Models\\Animal','2022-04-17 19:17:24','2022-04-17 19:17:24'),(83,'12/dFSEMbt8vueAAsY0YmDBVUTsW60dEER0F1TNGZRX.jpg',12,'App\\Models\\Animal','2022-04-17 19:17:31','2022-04-17 19:17:31'),(84,'12/1mcYo6R5ETx3fE5LV9SYWQgKGjRAj2jRw3kzf4yf.jpg',12,'App\\Models\\Animal','2022-04-17 19:17:37','2022-04-17 19:17:37'),(85,'15/XvyohZZvrBI8oYBIJmVWCFTu0GOUbzH9i1aPVUAM.jpg',15,'App\\Models\\Animal','2022-04-18 21:12:27','2022-04-18 21:12:27'),(86,'15/nOZyNd8Wh94iQv6xv9Uk7ldiPE9kmCEmwVLwJMtJ.jpg',15,'App\\Models\\Animal','2022-04-18 21:12:34','2022-04-18 21:12:34'),(87,'15/zPTfDyTOWcNjWzfDd7BBVFWHLYtWCXtFDTEqYwhU.jpg',15,'App\\Models\\Animal','2022-04-18 21:12:42','2022-04-18 21:12:42'),(88,'15/Ctq9cVKqSr1zBkC1klclrTjcdS6yn2HKmAFna3Z8.jpg',15,'App\\Models\\Animal','2022-04-18 21:12:51','2022-04-18 21:12:51'),(89,'16/fURtSRWjzCRJXbyzNw4KMYYpZXNq9ltZJeKYCL2g.jpg',16,'App\\Models\\Animal','2022-04-22 01:49:34','2022-04-22 01:49:34'),(90,'16/d3oxKJWzycVCpAdtBxnXuGFZvuuNxoJ4kkmt9l53.jpg',16,'App\\Models\\Animal','2022-04-22 01:49:47','2022-04-22 01:49:47'),(91,'16/4OFVSbFbWbLyJ51OH1osZ7v4ucaIHNaaYJJL8VJO.jpg',16,'App\\Models\\Animal','2022-04-22 01:49:59','2022-04-22 01:49:59'),(92,'16/AMS0oGpd03sIzbD1rVQyXvmTQ5DGjc264kThyF6A.jpg',16,'App\\Models\\Animal','2022-04-22 01:50:10','2022-04-22 01:50:10'),(93,'9/YRtKQQSOtuHQ3BMA0FDW4XRxbh7Eri3LuDts61Xn.jpg',9,'App\\Models\\Animal','2022-04-22 02:03:29','2022-04-22 02:03:29'),(94,'9/NB4Ahq28sVpLXr0Xg4cdH2142Md4BKXYBigdK4wO.jpg',9,'App\\Models\\Animal','2022-04-22 02:03:40','2022-04-22 02:03:40'),(95,'9/B68L9B1lkjLqjsJqcXjTxgrJQlJG3wGZsJbMcMGa.jpg',9,'App\\Models\\Animal','2022-04-22 02:03:47','2022-04-22 02:03:47'),(96,'9/JSJGURRagt2ckPGtrmW4VwFuqONsmI6eBvN0VdQp.jpg',9,'App\\Models\\Animal','2022-04-22 02:03:53','2022-04-22 02:03:53'),(97,'18/MRQf2ugi30XKSFwPXavHyplBY0GaC6NUvfthRsmm.jpg',18,'App\\Models\\Animal','2022-04-24 04:43:16','2022-04-24 04:43:16'),(98,'18/lbl7tjLeCegUxMs9xJ6eEh5CopqaAEDMBAGy2qyc.jpg',18,'App\\Models\\Animal','2022-04-24 04:43:23','2022-04-24 04:43:23'),(99,'18/oBloDO1mdLLYTObbmnx9OMYfxRZmi427oPK8kyvS.jpg',18,'App\\Models\\Animal','2022-04-24 04:43:29','2022-04-24 04:43:29'),(100,'18/1By7Zoj5Xpl7MMPT7KFQJP7iTY97tMbLnK7JMbNV.jpg',18,'App\\Models\\Animal','2022-04-24 04:43:35','2022-04-24 04:43:35'),(101,'18/YisdHtDZdt7yIihE82Ye9tqFytST5S6ZMiM9uOx2.jpg',18,'App\\Models\\Animal','2022-04-24 04:43:44','2022-04-24 04:43:44'),(102,'18/NV0goHzP4bb7yLlwcF9qxAYrDihBMYAQeJCnN16i.jpg',18,'App\\Models\\Animal','2022-04-24 04:43:53','2022-04-24 04:43:53'),(103,'18/uUJBfjHTH7LmbJPsOnlI8w8appZkozMULOcApb8s.jpg',18,'App\\Models\\Animal','2022-04-24 04:44:01','2022-04-24 04:44:01'),(104,'4/iSIZqA8Rq1bQ18ggUqmMEITorzDiMdL2c6cvQyGR.jpg',4,'App\\Models\\Animal','2022-06-01 03:28:55','2022-06-01 03:28:55'),(105,'19/WhatsApp Image 2022-05-31 at 3.33.27 PM_1654033731.jpeg',19,'App\\Models\\Animal','2022-06-01 03:48:51','2022-06-01 03:48:51'),(106,'20/WhatsApp Image 2022-05-31 at 3.33.27 PM_1654033910.jpeg',20,'App\\Models\\Animal','2022-06-01 03:51:50','2022-06-01 03:51:50'),(107,'21/WhatsApp Image 2022-08-12 at 9.20.15 PM_1660867154.jpeg',21,'App\\Models\\Animal','2022-08-19 05:59:14','2022-08-19 05:59:14'),(108,'21/eUu1H6o9uvvUpPP9pfSQDr4kuVL1RZDaV6aPm7R2.jpg',21,'App\\Models\\Animal','2022-08-19 05:59:36','2022-08-19 05:59:36'),(109,'19/WIc9AwTVzWitRDOfFeik5NMg1FylRUii05N6TfsW.jpg',19,'App\\Models\\Animal','2022-08-19 06:01:07','2022-08-19 06:01:07'),(110,'20/NXbiGB1Je2bzNg0jQKDDi58HKaP2e73bu5FQszzY.jpg',20,'App\\Models\\Animal','2022-08-19 06:04:07','2022-08-19 06:04:07'),(111,'20/ceHgg83ozF4znKDZSVYa2twVyOyLt2Ezp5fb0eOo.jpg',20,'App\\Models\\Animal','2022-08-19 06:04:21','2022-08-19 06:04:21'),(112,'20/rLfI7QWIzOSwNhs6sf5ybmQUD59PGJHMFMy4YqId.jpg',20,'App\\Models\\Animal','2022-08-19 06:04:33','2022-08-19 06:04:33'),(113,'22/WhatsApp Image 2022-08-13 at 12.02.27 PM_1660867625.jpeg',22,'App\\Models\\Animal','2022-08-19 06:07:05','2022-08-19 06:07:05'),(114,'12/9eUMq0RXb9dbHHET9kmSwhLnLkfjBAH55YJurtz3.jpg',12,'App\\Models\\Animal','2023-02-10 22:42:50','2023-02-10 22:42:50'),(115,'23/WhatsApp Image 2023-05-30 at 3.35.43 PM_1685576823.jpeg',23,'App\\Models\\Animal','2023-06-01 05:47:03','2023-06-01 05:47:03'),(116,'23/6uuZTDPC4bDxuwZplDu6qa0GrC7FzDCLZ9cZSwMc.jpg',23,'App\\Models\\Animal','2023-06-01 05:47:19','2023-06-01 05:47:19'),(118,'21/RtfkoeUMGb2oh71QcuI9KJHCArOXZtKyBSEI291Q.jpg',21,'App\\Models\\Animal','2023-06-07 05:52:25','2023-06-07 05:52:25'),(119,'5/OYKyC2ytXqDvXG5Qe6qv3B4XVxIdkymfN5He2xeV.jpg',5,'App\\Models\\Animal','2023-11-08 22:57:51','2023-11-08 22:57:51'),(120,'5/Fw5mRxaiLzXhbJMvzac9tCXxZqvfnwGhded3eVPP.jpg',5,'App\\Models\\Animal','2023-11-08 22:58:25','2023-11-08 22:58:25'),(121,'28/PHOTO-2025-01-16-09-18-11_1738193078.jpg',28,'App\\Models\\Animal','2025-01-30 05:24:38','2025-01-30 05:24:38'),(123,'31/IMG_0519_1745025952.jpg',31,'App\\Models\\Animal','2025-04-19 07:25:52','2025-04-19 07:25:52'),(124,'31/8Cj9yd3xrVdVWILEoBUqseD1JbjvjdDc54NmJNqT.jpg',31,'App\\Models\\Animal','2025-04-19 07:26:11','2025-04-19 07:26:11'),(125,'31/YDB2NKxSp2FLm6Lf3HKmAsDacAoyuoavvUcbZXkG.jpg',31,'App\\Models\\Animal','2025-04-19 07:26:20','2025-04-19 07:26:20'),(126,'31/uKL2uqYyawlAyTcSfRB4GMyi8mXLKa1GHhdni5kI.jpg',31,'App\\Models\\Animal','2025-04-19 07:26:33','2025-04-19 07:26:33'),(127,'31/Y6qLDMqeIoLQuIPo0yPzCM8Z0AZD2Sq1RmnnFJNm.jpg',31,'App\\Models\\Animal','2025-04-19 07:26:44','2025-04-19 07:26:44'),(128,'23/IMG_0513_1745026076.jpg',23,'App\\Models\\Animal','2025-04-19 07:27:56','2025-04-19 07:27:56'),(129,'23/g2LxqjEf8HtGALxifziEc1T7yAk90MUSaVBEgV3C.jpg',23,'App\\Models\\Animal','2025-04-19 07:28:14','2025-04-19 07:28:14'),(130,'23/y9HYq5S8SgELAwG9GYh5WbIruF4HwRK1QR7fG41y.jpg',23,'App\\Models\\Animal','2025-04-19 07:28:33','2025-04-19 07:28:33'),(131,'23/DDYiYFxQc3OXQ7R80h99dQ4cU4UnSgj0GgASe455.jpg',23,'App\\Models\\Animal','2025-04-19 07:28:43','2025-04-19 07:28:43'),(132,'23/28xmFuGpljFgfTOx3kn5xAKq94Tqn3GEnfzp9Zvm.jpg',23,'App\\Models\\Animal','2025-04-19 07:29:29','2025-04-19 07:29:29'),(133,'26/IMG_0500_1745026225.jpg',26,'App\\Models\\Animal','2025-04-19 07:30:25','2025-04-19 07:30:25'),(134,'26/6Z3tcBdxOV1ZQDZnB4KVe3MQmtpyGxPHkdxw7juK.jpg',26,'App\\Models\\Animal','2025-04-19 07:30:43','2025-04-19 07:30:43'),(135,'26/xDS2pRSYCeJ7Ar4FAPJk8UQ5ir2mtRI1FnLCMB3O.jpg',26,'App\\Models\\Animal','2025-04-19 07:30:55','2025-04-19 07:30:55'),(136,'26/R57FH5Ookz7W7XMUpDnAMrJelpUxl2wcHzjXiOgP.jpg',26,'App\\Models\\Animal','2025-04-19 07:31:03','2025-04-19 07:31:03'),(137,'26/OG8ILndMrtdGdL7W48zP7w6bmA1OYAC4BlaqGxrp.jpg',26,'App\\Models\\Animal','2025-04-19 07:31:13','2025-04-19 07:31:13'),(138,'10/XyfNi3dmvqqcjPOjQfyMEBOoKqPPLMocuYF7owDS.jpg',10,'App\\Models\\Animal','2025-04-19 07:32:15','2025-04-19 07:32:15'),(139,'10/syt9OrVfotWpFQ33WQq3yDanPz7y2zxTqQoTI12e.jpg',10,'App\\Models\\Animal','2025-04-19 07:32:26','2025-04-19 07:32:26'),(140,'10/Pq6ZU3b2junLIqtDm3QSfWwz0Xz3F6VFo3BD0LjT.jpg',10,'App\\Models\\Animal','2025-04-19 07:33:22','2025-04-19 07:33:22'),(141,'7/SGEjYHvjN2bR1nQvmgqxRLJSFRugcDmP9DabpMdD.jpg',7,'App\\Models\\Animal','2025-04-19 07:34:16','2025-04-19 07:34:16'),(142,'7/oJLVxt14DVSgVe6RCQ3znT7IeAaXHaiPZcFvPQqm.jpg',7,'App\\Models\\Animal','2025-04-19 07:34:28','2025-04-19 07:34:28'),(143,'7/WaqTt0Vv1fnTzhfqqGVHXfsRsi9nxCjHT20IZdz0.jpg',7,'App\\Models\\Animal','2025-04-19 07:34:37','2025-04-19 07:34:37'),(144,'7/bEQ4gMDg8geQvwuAJkGWoYoAClYXM2SbBvswFb9L.jpg',7,'App\\Models\\Animal','2025-04-19 07:34:48','2025-04-19 07:34:48'),(145,'7/Jjn8ci1aZ648Mcx08AevfGeRyMiIsx0zCADaDtRu.jpg',7,'App\\Models\\Animal','2025-04-19 07:34:57','2025-04-19 07:34:57'),(146,'25/IMG_0522_1745026752.jpg',25,'App\\Models\\Animal','2025-04-19 07:39:12','2025-04-19 07:39:12'),(147,'25/QtoW4yQRhjUDG47ziYCTLui5NHOQnnOVgkMh4I92.jpg',25,'App\\Models\\Animal','2025-04-19 07:39:22','2025-04-19 07:39:22'),(148,'25/kjDBcLrkVKh6RG624fDXYx5Glw29cIeZMW8oUtiA.jpg',25,'App\\Models\\Animal','2025-04-19 07:39:31','2025-04-19 07:39:31'),(149,'25/ZGotNjxBBiicAhWaZPpvab1VJQzWSer2phktdhHS.jpg',25,'App\\Models\\Animal','2025-04-19 07:39:39','2025-04-19 07:39:39'),(150,'25/Z5V4ieBTqFwIagBr4U8H96pt3RaoUchygfjAERL7.jpg',25,'App\\Models\\Animal','2025-04-19 07:39:46','2025-04-19 07:39:46'),(151,'34/IMG_0528_1745027119.jpg',34,'App\\Models\\Animal','2025-04-19 07:45:19','2025-04-19 07:45:19'),(152,'34/IJEwBAh1QauTRrOrxdIL1yYNmHYvrQiIaSntpQm4.jpg',34,'App\\Models\\Animal','2025-04-19 07:45:36','2025-04-19 07:45:36'),(153,'34/BjA3Bc7y66tChXnpihI1UFMO5qDB6uR9nKIO7ZoY.jpg',34,'App\\Models\\Animal','2025-04-19 07:45:43','2025-04-19 07:45:43'),(154,'34/Pt0N8AtIKKD8AxYiALJQGc1pkLQs538ZkiDbYqfV.jpg',34,'App\\Models\\Animal','2025-04-19 07:45:55','2025-04-19 07:45:55'),(155,'33/IMG_0537_1745027377.jpg',33,'App\\Models\\Animal','2025-04-19 07:49:37','2025-04-19 07:49:37'),(156,'33/Eb5gJqplLn6O0d5G6aGnqP2hdiobOYfiKFBa4FEO.jpg',33,'App\\Models\\Animal','2025-04-19 07:49:50','2025-04-19 07:49:50'),(157,'33/K2Kf253pOK4tQ6ViuOt3WNDeVwrUnO0gffAqWzTn.jpg',33,'App\\Models\\Animal','2025-04-19 07:49:56','2025-04-19 07:49:56'),(158,'33/trN60c9SQcVoUdPjhcdlNMPPQzEMsyavTPSqpRjw.jpg',33,'App\\Models\\Animal','2025-04-19 07:50:04','2025-04-19 07:50:04'),(159,'33/bbfh78nTztTfJ8zhdEhNmHO76s8jTpGtCPh2Kzg6.jpg',33,'App\\Models\\Animal','2025-04-19 07:50:11','2025-04-19 07:50:11'),(160,'11/ag3uTjGqGzB5vIcV11Le6u1eXhoFn6LL3ylUPgyQ.jpg',11,'App\\Models\\Animal','2025-04-19 07:54:51','2025-04-19 07:54:51'),(161,'11/P4IMD8FjgTEVYRwQdjOPXibzS01rYVrjGc4S7IAc.jpg',11,'App\\Models\\Animal','2025-04-19 07:55:02','2025-04-19 07:55:02'),(162,'11/aUZg0uH8W5RJDf5jvG66PkFO064QNxGyTp7SSthY.jpg',11,'App\\Models\\Animal','2025-04-19 07:55:13','2025-04-19 07:55:13'),(163,'11/8Gx0UwqxovWHqOxiwRasNE8OqJeXUyou3DxFCaA6.jpg',11,'App\\Models\\Animal','2025-04-19 07:55:21','2025-04-19 07:55:21'),(164,'21/cZyhYl44YkE87T0r049dZCArDwLnyT5Aa6fQj9jG.jpg',21,'App\\Models\\Animal','2025-04-19 08:01:47','2025-04-19 08:01:47'),(165,'21/bCwnLvJ4hPNEcjA0AH5kWfzM3KIKQxdVuvhPPLfz.jpg',21,'App\\Models\\Animal','2025-04-19 08:02:07','2025-04-19 08:02:07'),(166,'21/xaMNCjrh3bNBxfYkWoZUs4AIiwmNvxU5jxGjD8ux.jpg',21,'App\\Models\\Animal','2025-04-19 08:02:14','2025-04-19 08:02:14'),(167,'21/pAlKBdPz8XndyxjZwFGQlmR61AIFDCwVoBuLVZSS.jpg',21,'App\\Models\\Animal','2025-04-19 08:02:21','2025-04-19 08:02:21'),(168,'21/K6jcc2iYV5h9oOYZgwDfst8lIVhyqKCXFKqpeIMl.jpg',21,'App\\Models\\Animal','2025-04-19 08:02:29','2025-04-19 08:02:29'),(169,'21/iBYIHl2LDNFr3k0OzJSXZnjSznTnlXWLTAYZhxww.jpg',21,'App\\Models\\Animal','2025-04-19 08:02:36','2025-04-19 08:02:36'),(170,'21/qbDbdacZshcvY2fWiFB3fvZO16uUxTJnEgs78WG6.jpg',21,'App\\Models\\Animal','2025-04-19 08:02:43','2025-04-19 08:02:43'),(171,'29/IMG_0558_1745028421.jpg',29,'App\\Models\\Animal','2025-04-19 08:07:01','2025-04-19 08:07:01'),(172,'29/lKZuJLpMF35pFDZpCqrXUGsMvk7gbtHVWEeHg5OB.jpg',29,'App\\Models\\Animal','2025-04-19 08:07:14','2025-04-19 08:07:14'),(173,'29/EZP2hQkJF43P7oyBJeoq75NVIXa9v4hFz1AogjJv.jpg',29,'App\\Models\\Animal','2025-04-19 08:07:21','2025-04-19 08:07:21'),(174,'29/RzBIG1iNwofYvex5wyt26yw7pBl96Oe0O3pPk8lV.jpg',29,'App\\Models\\Animal','2025-04-19 08:07:29','2025-04-19 08:07:29'),(175,'29/D49QtvAOsMtGTA3gBXjS07aZF6xWc8dysKUFL5R4.jpg',29,'App\\Models\\Animal','2025-04-19 08:07:38','2025-04-19 08:07:38'),(176,'29/AcCVj4nkrtMqXj5LB8eO2D0keZRiDk7gqCrHPOtL.jpg',29,'App\\Models\\Animal','2025-04-19 08:07:45','2025-04-19 08:07:45'),(177,'37/IMG_0565_1745029139.jpg',37,'App\\Models\\Animal','2025-04-19 08:18:59','2025-04-19 08:18:59'),(178,'37/igwae7VP5oRilaFc2EP5LKMSQpvBMgDX5LLMJtOz.jpg',37,'App\\Models\\Animal','2025-04-19 08:20:24','2025-04-19 08:20:24'),(179,'37/wjVLxROyRMjLkMDzR8nT0t4ic3hDRc8YDEZ0gQGR.jpg',37,'App\\Models\\Animal','2025-04-19 08:20:30','2025-04-19 08:20:30'),(180,'37/CdFjYSGcLnZsncLCRabzkf4mrfVVEJcEmrsDwaYj.jpg',37,'App\\Models\\Animal','2025-04-19 08:20:36','2025-04-19 08:20:36'),(181,'37/VPMCLZCjIwIiSCvnzwLGkuOYXM6Ulryolq91Q2xe.jpg',37,'App\\Models\\Animal','2025-04-19 08:20:43','2025-04-19 08:20:43'),(182,'24/IMG_0571_1745029412.jpg',24,'App\\Models\\Animal','2025-04-19 08:23:32','2025-04-19 08:23:32'),(183,'24/3H3DGB5NkflYeRKU5NtzcOjVp0LJheqBeEh0CAFz.jpg',24,'App\\Models\\Animal','2025-04-19 08:23:48','2025-04-19 08:23:48'),(184,'24/dZCays5G8w58fls6kFbWJqDGfUNG1ZXSTdXMvWpx.jpg',24,'App\\Models\\Animal','2025-04-19 08:23:55','2025-04-19 08:23:55'),(185,'24/SGlsREeYFlitOEVKnCkp5hXZ9sKoStcZC7zTr9zV.jpg',24,'App\\Models\\Animal','2025-04-19 08:24:02','2025-04-19 08:24:02'),(186,'24/xDtk66kVOq2c4oQGcaUPLeI5BfC787eTvDfRzE0R.jpg',24,'App\\Models\\Animal','2025-04-19 08:24:10','2025-04-19 08:24:10'),(187,'38/IMG_0575_1745029698.jpg',38,'App\\Models\\Animal','2025-04-19 08:28:18','2025-04-19 08:28:18'),(188,'38/xN11hZvWJe6nIyCwtu1gYkkwoYDYseUX6XJHQnZA.jpg',38,'App\\Models\\Animal','2025-04-19 08:28:29','2025-04-19 08:28:29'),(189,'38/hWT3LnFjDFE2kNF4rPvwwqNfMvTjWkq5y8PsIrrD.jpg',38,'App\\Models\\Animal','2025-04-19 08:28:36','2025-04-19 08:28:36'),(190,'38/M89EhGa6nc83dz8CTBZa9j16VF0pNSBWAGJwKoBK.jpg',38,'App\\Models\\Animal','2025-04-19 08:28:43','2025-04-19 08:28:43'),(191,'38/iZPkYxtPdN6q7iu4sueCdgGZXbd8zfP8UvS0oo6o.jpg',38,'App\\Models\\Animal','2025-04-19 08:28:49','2025-04-19 08:28:49'),(192,'2/RQv7pNZD1iQMLo9494XZOpL6lGm2XMoi7ONMdbgW.jpg',2,'App\\Models\\Animal','2025-04-19 08:31:21','2025-04-19 08:31:21'),(193,'2/UmqRt2y577wBpNsUMjwna6NF1oI494M0ARm8OFFy.jpg',2,'App\\Models\\Animal','2025-04-19 08:31:28','2025-04-19 08:31:28'),(194,'2/mMo0HZEW3afTz7p9ZiChsuzfd9yOUsABcP3X4SlD.jpg',2,'App\\Models\\Animal','2025-04-19 08:31:33','2025-04-19 08:31:33'),(195,'2/5vIjM5BCP8AtEcZz9THY2LFnbqqEoQg71tRhWRlE.jpg',2,'App\\Models\\Animal','2025-04-19 08:31:40','2025-04-19 08:31:40'),(196,'2/bnfjhKKcFLXkJkY8tf2TxhL7fXQww2MJH9zBeoKb.jpg',2,'App\\Models\\Animal','2025-04-19 08:31:46','2025-04-19 08:31:46'),(197,'2/muDpYtccacs9ahvIBXRfKYF1csOePUuBP2ix15Iu.jpg',2,'App\\Models\\Animal','2025-04-19 08:31:52','2025-04-19 08:31:52'),(198,'32/IMG_0588_1745030221.jpg',32,'App\\Models\\Animal','2025-04-19 08:37:01','2025-04-19 08:37:01'),(199,'32/s4vZ00KiDFxSdOoZDCeZI8hUaexFWp9VPSaSLlXS.jpg',32,'App\\Models\\Animal','2025-04-19 08:37:13','2025-04-19 08:37:13'),(200,'32/ka5GH41IonBjn6bGvWQY5vy3j9pk0qwJ3GXFo1mg.jpg',32,'App\\Models\\Animal','2025-04-19 08:37:18','2025-04-19 08:37:18'),(201,'32/8T7kgacRfBe3PDgV0e3MS53g8XJmw9A13Xxx6Jdt.jpg',32,'App\\Models\\Animal','2025-04-19 08:37:24','2025-04-19 08:37:24'),(202,'32/j5mxJkUNVMyIMySaIJhEJB3DFzbkfdcR2RNymlHK.jpg',32,'App\\Models\\Animal','2025-04-19 08:37:32','2025-04-19 08:37:32'),(203,'27/IMG_0590_1745030542.jpg',27,'App\\Models\\Animal','2025-04-19 08:42:22','2025-04-19 08:42:22'),(204,'27/jE2TVXtNfimS7Qj79bGbAlwogh3zBI1dUiz9U8uc.jpg',27,'App\\Models\\Animal','2025-04-19 08:42:34','2025-04-19 08:42:34'),(205,'27/0e9ljF7cc44HelRiZbZxMfLLa0U24AQEjZ9mnRUt.jpg',27,'App\\Models\\Animal','2025-04-19 08:42:39','2025-04-19 08:42:39'),(206,'27/Rgx0usab5wvUpGztop5ZSv8YmRxzhTRrycNVlaG4.jpg',27,'App\\Models\\Animal','2025-04-19 08:42:48','2025-04-19 08:42:48'),(207,'27/Br2YwJ7XZiOT84iE6zCsgYOR4wkTFpdGZKpadSeK.jpg',27,'App\\Models\\Animal','2025-04-19 08:42:56','2025-04-19 08:42:56'),(208,'27/r90lwkwSh7X3Fa4xD8lKvGWpsYa0aJWV34A2LMLB.jpg',27,'App\\Models\\Animal','2025-04-19 08:43:02','2025-04-19 08:43:02'),(209,'12/ZZyFiHrywsFKfO5HIIJ6ZGknFkFMyHHdIT77c1TI.jpg',12,'App\\Models\\Animal','2025-04-19 08:54:01','2025-04-19 08:54:01'),(210,'12/qM5kBuqPUH2GzmbGs3fUGeePT4aBLhKzYeBGGln9.jpg',12,'App\\Models\\Animal','2025-04-19 08:54:09','2025-04-19 08:54:09'),(211,'12/OHGcqA5AAkTprUrWngniK1MItFrxOz64ld7sxnBz.jpg',12,'App\\Models\\Animal','2025-04-19 08:54:15','2025-04-19 08:54:15'),(212,'12/ptYhz73b30tPbTP0KXj1OpbVeQNWQEivsRlUJ0vv.jpg',12,'App\\Models\\Animal','2025-04-19 08:54:21','2025-04-19 08:54:21'),(213,'39/IMG_0614_1745031496.jpg',39,'App\\Models\\Animal','2025-04-19 08:58:16','2025-04-19 08:58:16'),(214,'39/xi8Q0YBmNs60XWQzArsctRhslnnqt2cdl179E2nx.jpg',39,'App\\Models\\Animal','2025-04-19 08:58:31','2025-04-19 08:58:31'),(215,'39/lMayzr1BXDty6qOxhcgmZLTwc7Zi7TRYfWuj1MCh.jpg',39,'App\\Models\\Animal','2025-04-19 08:58:38','2025-04-19 08:58:38'),(216,'39/E2TrLS8fTra4uAleWvSQPV3QA5hvq7AM8sv5ADWu.jpg',39,'App\\Models\\Animal','2025-04-19 08:58:47','2025-04-19 08:58:47'),(217,'39/JNvbTOOnzmk3hKtAgna91JOzYvnGFdue1W50BmDn.jpg',39,'App\\Models\\Animal','2025-04-19 08:58:55','2025-04-19 08:58:55'),(218,'39/Hl0ofrx9i6XQ3JIaIbVXmYrrwqpzPgYftqmIy1mo.jpg',39,'App\\Models\\Animal','2025-04-19 08:59:02','2025-04-19 08:59:02'),(219,'39/FWSYFyOM5HlsQ0KZGPeyibHWZVCeOxxpsDGpuDNz.jpg',39,'App\\Models\\Animal','2025-04-19 09:02:34','2025-04-19 09:02:34'),(220,'13/HACWeZy2rRBdBhNPxX1jliCYfeqczfBncpIzrUbi.jpg',13,'App\\Models\\Animal','2025-04-19 09:04:41','2025-04-19 09:04:41'),(221,'13/2Zy1oC5YS5GggemdpyOx9hWpqlAlrbg1LIue10aC.jpg',13,'App\\Models\\Animal','2025-04-19 09:04:55','2025-04-19 09:04:55'),(222,'13/oHF5wmNUUBGEkx6AwZx3WOZ93Ds4zSPA4NgtYlsN.jpg',13,'App\\Models\\Animal','2025-04-19 09:05:04','2025-04-19 09:05:04'),(223,'13/dUfIk1GsyiPN0LEB5qpUSBBW26lHXLelW9GvZvfx.jpg',13,'App\\Models\\Animal','2025-04-19 09:05:11','2025-04-19 09:05:11'),(224,'35/IMG_0669_1745032448.jpg',35,'App\\Models\\Animal','2025-04-19 09:14:08','2025-04-19 09:14:08'),(225,'35/H8KHowCYtbVuWk9S2MiAnynGpiKVvjy1V8r0AEVO.jpg',35,'App\\Models\\Animal','2025-04-19 09:14:22','2025-04-19 09:14:22'),(226,'35/kdLa1yHcbrlWuZysylgT86wgbMTHWVuZkbCrmmGo.jpg',35,'App\\Models\\Animal','2025-04-19 09:14:28','2025-04-19 09:14:28'),(227,'35/BABEMy5GEAxewbsqIQrdokxITUh7WN6leYX54oPM.jpg',35,'App\\Models\\Animal','2025-04-19 09:14:35','2025-04-19 09:14:35'),(228,'35/vmeG5CCbVMVewTlEJfVuFe3lfVKEwSfGAgQC11tm.jpg',35,'App\\Models\\Animal','2025-04-19 09:14:43','2025-04-19 09:14:43'),(229,'35/KkwOTkm6558nkVacedYED39191lA1w9E8W4XRYml.jpg',35,'App\\Models\\Animal','2025-04-19 09:14:52','2025-04-19 09:14:52'),(230,'35/vvnJiZfnjbixltGFdTd4j2MjH9JJhYCGTRfAVzgD.jpg',35,'App\\Models\\Animal','2025-04-19 09:15:00','2025-04-19 09:15:00'),(231,'35/U7XyBcajMaYMh7ftMqa32CKotyXBp6stav3Z5KNq.jpg',35,'App\\Models\\Animal','2025-04-19 09:15:06','2025-04-19 09:15:06'),(232,'35/yiUPhCbGvlM1XGfDdnJnr4hyrMM5IGE8ErdN4XMh.jpg',35,'App\\Models\\Animal','2025-04-19 09:15:11','2025-04-19 09:15:11'),(233,'35/acrOZqeT2GIRrWuhC9syw15JVXaiLKcL4KKFQigp.jpg',35,'App\\Models\\Animal','2025-04-19 09:17:20','2025-04-19 09:17:20'),(234,'28/0e5C3TEwk18thyCm6fgCMNCS6PRWeMZvTpMq9Me0.jpg',28,'App\\Models\\Animal','2025-04-19 09:33:56','2025-04-19 09:33:56'),(235,'28/IVW6HJpYbq1wmFt9jXJUE0IW9yyO6qkAQajYOCu2.jpg',28,'App\\Models\\Animal','2025-04-19 09:34:03','2025-04-19 09:34:03'),(236,'28/kKOe8giRoFbEomImcK4Uqq1DzDfDDHD3Rrcfrhz7.jpg',28,'App\\Models\\Animal','2025-04-19 09:34:10','2025-04-19 09:34:10'),(237,'28/W4HPGpKmjdx7su7nRATP6OeVi3bSvVUE9OWHcwJp.jpg',28,'App\\Models\\Animal','2025-04-19 09:34:18','2025-04-19 09:34:18'),(238,'28/tQNeVxOzZ69jsIEyTu6XvoBJ8taCoeGqbl8A9u01.jpg',28,'App\\Models\\Animal','2025-04-19 09:34:25','2025-04-19 09:34:25'),(239,'28/NKRExA8QFdv0iNkoM1zw8Xy8M3UsaKFHKPh3ygtD.jpg',28,'App\\Models\\Animal','2025-04-19 09:34:31','2025-04-19 09:34:31'),(240,'28/GUqmmczFAWryb7pN0VWKU5wefe6Cr3apFzkM4cSp.jpg',28,'App\\Models\\Animal','2025-04-19 09:34:44','2025-04-19 09:34:44'),(241,'28/f8GDyaXMvoB8c1tYu4eOOToKS8c2UwOrAYqcOLId.jpg',28,'App\\Models\\Animal','2025-04-19 09:34:55','2025-04-19 09:34:55'),(242,'40/IMG_0708_1745034031.jpg',40,'App\\Models\\Animal','2025-04-19 09:40:31','2025-04-19 09:40:31'),(243,'40/8Tb0IASkxwIb27BaOKvyQTvWTwQYdKbAliIMz4I8.jpg',40,'App\\Models\\Animal','2025-04-19 09:40:43','2025-04-19 09:40:43'),(244,'40/YJUuxRkRfQwZkYKcM2MMSDYX83CmnaCnFGyQtgWJ.jpg',40,'App\\Models\\Animal','2025-04-19 09:40:49','2025-04-19 09:40:49'),(245,'40/eNJ1B5HHTLJ6NTCHOJZ6AyrOl3fAU1tevOKpcRjA.jpg',40,'App\\Models\\Animal','2025-04-19 09:40:56','2025-04-19 09:40:56'),(246,'40/hARQyeIbpCnUcHUiaIHnuk20TIg5Unz6AFdNJrcr.jpg',40,'App\\Models\\Animal','2025-04-19 09:41:04','2025-04-19 09:41:04'),(247,'40/hCkZ80JhkiQQ6bfoKmKiuQk60G0pz5jGq6XiYnXj.jpg',40,'App\\Models\\Animal','2025-04-19 09:41:15','2025-04-19 09:41:15'),(248,'36/IMG_0645_1745034362.jpg',36,'App\\Models\\Animal','2025-04-19 09:46:02','2025-04-19 09:46:02'),(249,'36/jSXJbzXtuIlq20TV6xALLGnBh58SgK5jnQ5CZvcJ.jpg',36,'App\\Models\\Animal','2025-04-19 09:46:12','2025-04-19 09:46:12'),(250,'36/lupiI5MxTf6FmheeFAk31k7afiKmM90SDr1BvcvO.jpg',36,'App\\Models\\Animal','2025-04-19 09:46:19','2025-04-19 09:46:19'),(251,'36/4GHIaEJR93f4bvdZolQHAe63lh461le29Lq9s8sY.jpg',36,'App\\Models\\Animal','2025-04-19 09:46:27','2025-04-19 09:46:27'),(252,'36/iaPT3CUexYFsfPFtiTnks3WoGG33CP28bPOlzx5S.jpg',36,'App\\Models\\Animal','2025-04-19 09:46:34','2025-04-19 09:46:34'),(253,'36/SpYTcqnJvh4kKAamC4s7IbjRxawYYFLfa7y49omv.jpg',36,'App\\Models\\Animal','2025-04-19 09:46:42','2025-04-19 09:46:42'),(254,'36/jGOzF9c86pW43ENF7IHgCxvQOYL8WtF4ljFMX9nM.jpg',36,'App\\Models\\Animal','2025-04-19 09:46:50','2025-04-19 09:46:50');
/*!40000 ALTER TABLE `images` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `logs`
--

DROP TABLE IF EXISTS `logs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `logs` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `log` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `logable_id` bigint(20) unsigned NOT NULL,
  `logable_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint(20) unsigned DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `logs_user_id_foreign` (`user_id`),
  CONSTRAINT `logs_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `logs`
--

LOCK TABLES `logs` WRITE;
/*!40000 ALTER TABLE `logs` DISABLE KEYS */;
/*!40000 ALTER TABLE `logs` ENABLE KEYS */;
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
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `migrations`
--

LOCK TABLES `migrations` WRITE;
/*!40000 ALTER TABLE `migrations` DISABLE KEYS */;
INSERT INTO `migrations` VALUES (1,'2014_10_12_000000_create_users_table',1),(2,'2014_10_12_100000_create_password_resets_table',1),(3,'2014_10_12_200000_add_two_factor_columns_to_users_table',1),(4,'2019_08_19_000000_create_failed_jobs_table',1),(5,'2019_12_14_000001_create_personal_access_tokens_table',1),(6,'2022_03_07_221446_create_badge_colors_table',1),(7,'2022_03_08_111629_create_earing_colors_table',1),(8,'2022_03_08_125302_create_comment_types_table',1),(9,'2022_03_08_132714_create_sessions_table',1),(10,'2022_03_08_135953_create_owners_table',1),(11,'2022_03_08_140017_create_types_table',1),(12,'2022_03_08_140026_create_colors_table',1),(13,'2022_03_08_140041_create_statuses_table',1),(14,'2022_03_08_140444_create_animals_table',1),(15,'2022_03_08_141415_create_weights_table',1),(16,'2022_03_08_141426_create_comments_table',1),(17,'2022_03_08_141458_create_images_table',1),(18,'2022_04_07_204714_create_logs_table',1),(19,'2022_04_24_001248_create_sets_table',2),(20,'2022_04_24_001756_create_animal_set_table',2);
/*!40000 ALTER TABLE `migrations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `owners`
--

DROP TABLE IF EXISTS `owners`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `owners` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `owners`
--

LOCK TABLES `owners` WRITE;
/*!40000 ALTER TABLE `owners` DISABLE KEYS */;
INSERT INTO `owners` VALUES (1,'Armando','2022-04-08 08:47:59','2022-04-08 08:47:59'),(2,'Irma','2022-04-08 08:47:59','2022-04-08 08:47:59'),(3,'Samuel','2022-04-08 08:47:59','2022-04-08 08:47:59'),(4,'Juan Diego','2022-04-15 03:26:40','2022-04-15 03:26:40'),(5,'Isa','2022-04-15 04:05:52','2022-04-15 04:05:52');
/*!40000 ALTER TABLE `owners` ENABLE KEYS */;
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
  `abilities` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
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
-- Table structure for table `sessions`
--

DROP TABLE IF EXISTS `sessions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `sessions` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint(20) unsigned DEFAULT NULL,
  `ip_address` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_agent` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `payload` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_activity` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `sessions_user_id_index` (`user_id`),
  KEY `sessions_last_activity_index` (`last_activity`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sessions`
--

LOCK TABLES `sessions` WRITE;
/*!40000 ALTER TABLE `sessions` DISABLE KEYS */;
INSERT INTO `sessions` VALUES ('djanRwYfGZvHv2JO5SAsulnTnZ9A5uPrGd5tU0p0',1,'127.0.0.1','Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/135.0.0.0 Safari/537.36','YTo2OntzOjY6Il90b2tlbiI7czo0MDoiNDgzY2I5VnM5YVVzOW1ST1kxeUhBeTB3VGs3YVNBUnlmSFl5MktVVyI7czozOiJ1cmwiO2E6MDp7fXM6OToiX3ByZXZpb3VzIjthOjE6e3M6MzoidXJsIjtzOjQzOiJodHRwOi8vMTI3LjAuMC4xOjgwMDEvYW5pbWFscy9nZXRXZWlnaHRzLzM4Ijt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo1MDoibG9naW5fd2ViXzU5YmEzNmFkZGMyYjJmOTQwMTU4MGYwMTRjN2Y1OGVhNGUzMDk4OWQiO2k6MTtzOjE3OiJwYXNzd29yZF9oYXNoX3dlYiI7czo2MDoiJDJ5JDEwJG9hNkwwa2UuRzdwclAuSWo4S28zMC5xSnJCbGMyOXRUc09uSlNxcExJMmFwU0kycXZ5NUxXIjt9',1746204722);
/*!40000 ALTER TABLE `sessions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sets`
--

DROP TABLE IF EXISTS `sets`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `sets` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sets`
--

LOCK TABLES `sets` WRITE;
/*!40000 ALTER TABLE `sets` DISABLE KEYS */;
/*!40000 ALTER TABLE `sets` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `statuses`
--

DROP TABLE IF EXISTS `statuses`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `statuses` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `badge_color_id` bigint(20) unsigned DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `statuses_badge_color_id_foreign` (`badge_color_id`),
  CONSTRAINT `statuses_badge_color_id_foreign` FOREIGN KEY (`badge_color_id`) REFERENCES `badge_colors` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `statuses`
--

LOCK TABLES `statuses` WRITE;
/*!40000 ALTER TABLE `statuses` DISABLE KEYS */;
INSERT INTO `statuses` VALUES (1,'Vendido',0,6,'2022-04-08 08:47:59','2022-04-08 08:47:59'),(2,'Muerto',0,7,'2022-04-08 08:47:59','2022-04-08 08:47:59'),(3,'Tronconero',1,3,'2022-04-08 08:47:59','2022-04-08 08:47:59'),(4,'Medianero',1,3,'2022-04-08 08:47:59','2022-04-08 08:47:59'),(5,'Puntero',1,3,'2022-04-08 08:47:59','2022-04-08 08:47:59'),(6,'Estabulado',1,1,'2022-04-08 08:47:59','2022-04-08 08:47:59'),(7,'Crianza',1,2,'2022-04-08 08:47:59','2022-04-08 08:47:59'),(8,'Cargadas',1,4,'2022-04-08 08:47:59','2022-04-08 08:47:59'),(9,'General',1,5,'2022-04-08 08:47:59','2022-04-08 08:47:59'),(10,'Paridas',1,4,'2022-04-08 08:47:59','2022-04-08 08:47:59');
/*!40000 ALTER TABLE `statuses` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `types`
--

DROP TABLE IF EXISTS `types`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `types` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `gender` enum('1','2') COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `types`
--

LOCK TABLES `types` WRITE;
/*!40000 ALTER TABLE `types` DISABLE KEYS */;
INSERT INTO `types` VALUES (1,'Chivo','1','2022-04-08 08:47:59','2022-04-08 08:47:59'),(2,'Novillo','1','2022-04-08 08:47:59','2022-04-08 08:47:59'),(3,'Toro','1','2022-04-08 08:47:59','2022-04-08 08:47:59'),(4,'Chiva','2','2022-04-08 08:47:59','2022-04-08 08:47:59'),(5,'Novilla','2','2022-04-08 08:47:59','2022-04-08 08:47:59'),(6,'Cargada','2','2022-04-08 08:47:59','2022-04-08 08:47:59'),(7,'Vaca','2','2022-04-08 08:47:59','2022-04-08 08:47:59');
/*!40000 ALTER TABLE `types` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `users` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `two_factor_secret` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `two_factor_recovery_codes` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `current_team_id` bigint(20) unsigned DEFAULT NULL,
  `profile_photo_path` varchar(2048) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (1,'Samuel Mayorga','sams134@gmail.com','2022-04-08 08:47:59','$2y$10$oa6L0ke.G7prP.Ij8Ko30.qJrBlc29tTsOnJSqpLI2apSI2qvy5LW',NULL,NULL,NULL,NULL,NULL,'2022-04-08 08:48:00','2022-04-08 08:48:00');
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `weights`
--

DROP TABLE IF EXISTS `weights`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `weights` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `weight` int(11) NOT NULL,
  `date` date NOT NULL,
  `comment` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `animal_id` bigint(20) unsigned DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `weights_animal_id_foreign` (`animal_id`),
  CONSTRAINT `weights_animal_id_foreign` FOREIGN KEY (`animal_id`) REFERENCES `animals` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=71 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `weights`
--

LOCK TABLES `weights` WRITE;
/*!40000 ALTER TABLE `weights` DISABLE KEYS */;
INSERT INTO `weights` VALUES (1,460,'2022-02-03',NULL,1,'2022-04-08 08:49:25','2022-04-08 08:49:25'),(2,775,'2022-02-03',NULL,4,'2022-04-15 03:45:59','2022-04-15 03:45:59'),(3,430,'2022-04-17',NULL,1,'2022-04-17 20:30:38','2022-04-17 20:30:38'),(4,775,'2022-04-17',NULL,4,'2022-04-17 20:31:17','2022-04-17 20:31:17'),(5,390,'2022-02-03',NULL,5,'2022-04-17 20:32:40','2022-04-17 20:32:40'),(6,430,'2022-04-17',NULL,5,'2022-04-17 20:33:15','2022-04-17 20:33:15'),(7,630,'2022-02-03',NULL,14,'2022-04-17 20:34:11','2022-04-17 20:34:11'),(8,655,'2022-04-17',NULL,14,'2022-04-17 20:34:53','2022-04-17 20:34:53'),(9,760,'2022-04-17',NULL,2,'2022-04-17 20:35:49','2022-04-17 20:35:49'),(10,665,'2022-04-17',NULL,7,'2022-04-17 20:36:53','2022-04-17 20:36:53'),(11,1085,'2022-04-17',NULL,11,'2022-04-17 20:37:41','2022-04-17 20:37:41'),(12,790,'2022-04-17',NULL,12,'2022-04-17 20:38:52','2022-04-17 20:38:52'),(13,300,'2022-04-17',NULL,13,'2022-04-17 20:39:46','2022-04-17 20:39:46'),(14,370,'2022-04-17',NULL,10,'2022-04-17 20:40:43','2022-04-17 20:40:43'),(15,100,'2022-04-18',NULL,8,'2022-04-18 21:31:45','2022-04-18 21:31:45'),(16,730,'2022-04-16',NULL,16,'2022-04-22 01:58:47','2022-04-22 01:58:47'),(17,890,'2022-04-16',NULL,9,'2022-04-24 04:38:05','2022-04-24 04:38:05'),(18,195,'2022-04-16',NULL,18,'2022-04-24 05:09:29','2022-04-24 05:09:29'),(19,900,'2022-05-06',NULL,4,'2022-06-01 03:25:55','2022-06-01 03:25:55'),(20,480,'2022-05-27',NULL,19,'2022-06-01 03:48:51','2022-06-01 03:48:51'),(21,490,'2022-05-27',NULL,20,'2022-06-01 03:51:50','2022-06-01 03:51:50'),(22,435,'2022-08-18',NULL,22,'2022-08-19 06:07:05','2022-08-19 06:07:05'),(23,435,'2022-08-19',NULL,22,'2022-08-19 06:08:22','2022-08-19 06:08:22'),(24,890,'2023-01-17',NULL,14,'2023-01-17 22:06:05','2023-01-17 22:06:05'),(25,500,'2023-01-20',NULL,19,'2023-01-20 06:04:31','2023-01-20 06:04:31'),(26,430,'2023-01-20',NULL,21,'2023-01-20 06:10:37','2023-01-20 06:10:37'),(27,560,'2023-01-20',NULL,1,'2023-01-20 06:12:21','2023-01-20 06:12:21'),(28,890,'2023-02-10',NULL,14,'2023-02-10 22:13:33','2023-02-10 22:13:33'),(29,575,'2023-05-29',NULL,10,'2023-05-30 05:29:33','2023-05-30 05:29:33'),(30,350,'2023-05-29',NULL,8,'2023-05-30 05:30:04','2023-05-30 05:30:04'),(31,570,'2023-05-29',NULL,19,'2023-05-30 05:37:28','2023-05-30 05:37:28'),(32,605,'2023-05-29',NULL,1,'2023-05-30 05:38:09','2023-05-30 05:38:09'),(33,505,'2023-05-29',NULL,20,'2023-05-30 05:38:32','2023-05-30 05:38:32'),(34,480,'2023-05-29',NULL,21,'2023-05-30 05:39:49','2023-05-30 05:39:49'),(35,480,'2023-05-31',NULL,22,'2023-06-01 05:38:52','2023-06-01 05:38:52'),(36,290,'2023-05-31',NULL,21,'2023-06-01 05:42:41','2023-06-01 05:42:41'),(37,805,'2023-05-31',NULL,5,'2023-06-01 05:43:17','2023-06-01 05:43:17'),(38,1010,'2023-11-08',NULL,5,'2023-11-08 22:47:22','2023-11-08 22:47:22'),(39,100,'2023-11-14',NULL,26,'2024-02-16 01:22:20','2024-02-16 01:22:20'),(40,700,'2025-01-29',NULL,8,'2025-01-30 05:29:01','2025-01-30 05:29:01'),(41,450,'2024-09-18',NULL,31,'2025-01-30 05:47:59','2025-01-30 05:47:59'),(42,480,'2024-10-29',NULL,35,'2025-01-30 05:56:28','2025-01-30 05:56:28'),(43,480,'2024-10-26',NULL,37,'2025-01-30 05:59:15','2025-01-30 05:59:15'),(44,500,'2024-10-26',NULL,38,'2025-01-30 06:00:51','2025-01-30 06:00:51'),(45,740,'2025-04-18',NULL,10,'2025-04-18 23:49:00','2025-04-18 23:49:00'),(46,760,'2025-04-18',NULL,26,'2025-04-18 23:51:41','2025-04-18 23:51:41'),(47,1020,'2025-04-18',NULL,7,'2025-04-18 23:53:56','2025-04-18 23:53:56'),(48,780,'2025-04-18',NULL,23,'2025-04-18 23:57:45','2025-04-18 23:57:45'),(49,570,'2025-04-18',NULL,31,'2025-04-19 00:00:49','2025-04-19 00:00:49'),(50,500,'2025-04-18',NULL,25,'2025-04-19 00:02:35','2025-04-19 00:02:35'),(51,500,'2025-04-18',NULL,34,'2025-04-19 00:09:36','2025-04-19 00:09:36'),(52,580,'2025-04-18',NULL,33,'2025-04-19 00:13:20','2025-04-19 00:13:20'),(53,990,'2025-04-18',NULL,11,'2025-04-19 00:16:56','2025-04-19 00:16:56'),(54,870,'2025-04-18',NULL,21,'2025-04-19 00:21:37','2025-04-19 00:21:37'),(55,180,'2025-04-18',NULL,29,'2025-04-19 00:24:45','2025-04-19 00:24:45'),(56,600,'2025-04-18',NULL,37,'2025-04-19 00:26:47','2025-04-19 00:26:47'),(57,420,'2025-04-18',NULL,24,'2025-04-19 00:28:24','2025-04-19 00:28:24'),(58,1020,'2025-04-18',NULL,38,'2025-04-19 00:29:50','2025-04-19 00:29:50'),(59,940,'2025-04-18',NULL,2,'2025-04-19 00:33:06','2025-04-19 00:33:06'),(60,560,'2025-04-18',NULL,32,'2025-04-19 00:35:59','2025-04-19 00:35:59'),(61,680,'2025-04-18',NULL,27,'2025-04-19 00:37:39','2025-04-19 00:37:39'),(62,865,'2025-04-18',NULL,12,'2025-04-19 00:39:41','2025-04-19 00:39:41'),(63,160,'2025-04-18',NULL,39,'2025-04-19 00:45:55','2025-04-19 00:45:55'),(64,900,'2025-04-18',NULL,13,'2025-04-19 00:48:08','2025-04-19 00:48:08'),(65,950,'2025-04-18',NULL,36,'2025-04-19 00:50:43','2025-04-19 00:50:43'),(66,550,'2025-04-18',NULL,35,'2025-04-19 00:52:51','2025-04-19 00:52:51'),(67,180,'2025-04-18',NULL,28,'2025-04-19 00:54:25','2025-04-19 00:54:25'),(68,140,'2025-04-18',NULL,40,'2025-04-19 01:00:41','2025-04-19 01:00:41'),(69,1000,'2025-05-02',NULL,38,'2025-05-02 22:48:13','2025-05-02 22:48:13'),(70,1020,'2025-05-02',NULL,36,'2025-05-02 22:49:58','2025-05-02 22:49:58');
/*!40000 ALTER TABLE `weights` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2025-05-13 21:02:33
