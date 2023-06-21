-- MySQL dump 10.13  Distrib 8.0.21, for Win64 (x86_64)
--
-- Host: sneakershopdatabase-do-user-14060163-0.b.db.ondigitalocean.com    Database: project
-- ------------------------------------------------------
-- Server version	8.0.30

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!50503 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
SET @MYSQLDUMP_TEMP_LOG_BIN = @@SESSION.SQL_LOG_BIN;
SET @@SESSION.SQL_LOG_BIN= 0;

--
-- GTID state at the beginning of the backup 
--

SET @@GLOBAL.GTID_PURGED=/*!80000 '+'*/ 'f04593be-0b59-11ee-9665-166172d87967:1-64';

--
-- Table structure for table `cart`
--

DROP TABLE IF EXISTS `cart`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `cart` (
  `id` int NOT NULL AUTO_INCREMENT,
  `productId` int NOT NULL,
  `userId` int NOT NULL,
  `productName` varchar(200) NOT NULL,
  `image` varchar(200) NOT NULL,
  `price` varchar(200) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=31 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cart`
--

LOCK TABLES `cart` WRITE;
/*!40000 ALTER TABLE `cart` DISABLE KEYS */;
INSERT INTO `cart` VALUES (15,4,5,'abc product','648611f42d94f.jpg','2000'),(16,2,5,'abc product','6485ed30d8262.png','2000'),(17,6,5,'anyname','648879563d689.jpg','1231123'),(30,34,13,'Sneakers','6489c1c7973dd.jpg','123');
/*!40000 ALTER TABLE `cart` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `productdetails`
--

DROP TABLE IF EXISTS `productdetails`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `productdetails` (
  `id` int NOT NULL AUTO_INCREMENT,
  `productName` varchar(100) NOT NULL,
  `image` varchar(100) NOT NULL,
  `price` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=46 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `productdetails`
--

LOCK TABLES `productdetails` WRITE;
/*!40000 ALTER TABLE `productdetails` DISABLE KEYS */;
INSERT INTO `productdetails` VALUES (34,'Sneakers','6489c1c7973dd.jpg','123'),(35,'Converse All Star','6489c1ce29073.jpg','231'),(36,'Adidas Stan Smith','6489c1d5b2c2c.jpg','320'),(37,'Adidas Originals SL80','6489c1ddc4d5d.jpg','120'),(38,'Puma Suede','6489c1e527302.jpg','100'),(39,'Reebok Classics Leather','6489c1ed95fdc.jpg','90'),(40,'Nike Air Max 90','6489c20a9bf38.jpg','75'),(41,'Giannis Ant\' Sneakers','6489c2190306c.jpg','130'),(42,'Adidas Originals SL80','6489c22ad3afd.jpg','130'),(43,'Basic New Balance Sneakers','6489c239736a7.jpg','130'),(44,'Converse All Star','6489c24321d8e.jpg','132'),(45,'Adidas Stan Smith','6489c251ca1ae.jpg','410');
/*!40000 ALTER TABLE `productdetails` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `purchase`
--

DROP TABLE IF EXISTS `purchase`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `purchase` (
  `id` int NOT NULL AUTO_INCREMENT,
  `productName` varchar(100) NOT NULL,
  `image` varchar(100) NOT NULL,
  `price` varchar(100) NOT NULL,
  `status` int NOT NULL COMMENT 'int<padding|completed>',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `purchase`
--

LOCK TABLES `purchase` WRITE;
/*!40000 ALTER TABLE `purchase` DISABLE KEYS */;
INSERT INTO `purchase` VALUES (1,'abc product','648611f42d94f.jpg','2000',0),(2,'anyname','648879563d689.jpg','1231123',0),(3,'Converse All Star Sneakers','image_20230614113553.jpg','100',0),(4,'Vans Old Skool','image_20230614113325.jpg','300',0),(5,'Converse All Star','6489bdbe530a5.jpg','200',0);
/*!40000 ALTER TABLE `purchase` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `registration`
--

DROP TABLE IF EXISTS `registration`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `registration` (
  `id` int NOT NULL AUTO_INCREMENT,
  `fullName` varchar(20) NOT NULL,
  `email` varchar(1000) NOT NULL,
  `password` varchar(1000) NOT NULL,
  `role` varchar(200) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `registration`
--

LOCK TABLES `registration` WRITE;
/*!40000 ALTER TABLE `registration` DISABLE KEYS */;
INSERT INTO `registration` VALUES (1,'admin','admin@gmail.com','$2y$10$rPkKhlwIoiiSkVHsVETBT.WfWgdB.iE69CmgpvXW4wx7mp19jABcq','admin'),(9,'Lejla','lbrescic@gmail.com','$2y$10$rPkKhlwIoiiSkVHsVETBT.WfWgdB.iE69CmgpvXW4wx7mp19jABcq','user'),(10,'Lejla','lejla.brescic@stu.ibu.edu.ba','$2y$10$FpVt/a16J6BO.QiElye0meR0ZF6act56SEuwTHXsFegDFt6Xu2BqS','user'),(11,'Lejla Brescic','ema.kavazovic-devedzic@stu.ibu.edu.ba','$2y$10$Xt51uxTs9QryjrEbuxwkuOxCUWGLEFsnvOqlhvyb/cPUtb37AdvR6','admin'),(12,'Amila ','amilaaa@gmail.com','$2y$10$iFf9fbLFqIyc7wjGz13B6eBxJRJhWE1zq7Bew7RAdnaxhO9AAIV6G','user'),(13,'Lejla Brescic','test@yahoo.com','$2y$10$JsRNU7tVx4F2kICqoXl9PuT0YQFs0DFbabJ4twteiuPCfZA2Z93JK','user'),(14,'Amila ','avdao@gmail.com','$2y$10$rGT5Euxa4cNVqwWiwa17n.FbJzCNwSIpSoVilT/06WktzUjPcIpqO','user'),(15,'Lejla Brescic','lejla@gmail.com','$2y$10$m/SaI9fRxbrikOgXygAl5O6IM82cJN9jVznpP6XD/3hVz0EV3NNH6','admin'),(16,'Ajdin','ajdin@gmail.com','$2y$10$G3zkNVHOisr7Qt4Gs6ANluFUPcRfRpmSLI4G6JnHBYBKwrOCobJ1C','admin'),(17,'Test Testic','testtestic@gmail.com','$2y$10$JM6k8oWkHIaQuwz5SuYoLO0450kIG.A71vWoNz0wbu0jDuYAEUEfy','admin'),(18,'Ronaldo','ronaldo@gmail.com','$2y$10$8jy9apIlPMI9Zk5jAp.CCeWIA.0JqzviksmRQ42olcaVG5OLOYL7i','admin');
/*!40000 ALTER TABLE `registration` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `wishlist`
--

DROP TABLE IF EXISTS `wishlist`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `wishlist` (
  `id` int NOT NULL AUTO_INCREMENT,
  `productId` int NOT NULL,
  `userId` int NOT NULL,
  `productName` varchar(100) NOT NULL,
  `image` varchar(100) NOT NULL,
  `price` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `wishlist`
--

LOCK TABLES `wishlist` WRITE;
/*!40000 ALTER TABLE `wishlist` DISABLE KEYS */;
INSERT INTO `wishlist` VALUES (8,36,13,'Adidas Stan Smith','6489c1d5b2c2c.jpg','320'),(9,37,13,'Adidas Originals SL80','6489c1ddc4d5d.jpg','120'),(10,34,13,'Sneakers','6489c1c7973dd.jpg','123'),(11,36,13,'Adidas Stan Smith','6489c1d5b2c2c.jpg','320'),(12,36,13,'Adidas Stan Smith','6489c1d5b2c2c.jpg','320'),(13,35,13,'Converse All Star','6489c1ce29073.jpg','231'),(14,35,13,'Converse All Star','6489c1ce29073.jpg','231'),(15,36,13,'Adidas Stan Smith','6489c1d5b2c2c.jpg','320');
/*!40000 ALTER TABLE `wishlist` ENABLE KEYS */;
UNLOCK TABLES;
SET @@SESSION.SQL_LOG_BIN = @MYSQLDUMP_TEMP_LOG_BIN;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2023-06-21 22:48:42
