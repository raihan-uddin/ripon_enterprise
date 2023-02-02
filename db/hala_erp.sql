-- MySQL dump 10.13  Distrib 8.0.29, for Linux (x86_64)
--
-- Host: localhost    Database: hala_erp
-- ------------------------------------------------------
-- Server version	8.0.29-0ubuntu0.22.04.2

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
-- Table structure for table `AuthAssignment`
--

DROP TABLE IF EXISTS `AuthAssignment`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `AuthAssignment`
(
    `itemname` varchar(255) NOT NULL,
    `userid`   varchar(64)  NOT NULL,
    `bizrule`  text,
    `data`     text,
    PRIMARY KEY (`itemname`, `userid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `AuthAssignment`
--

LOCK
TABLES `AuthAssignment` WRITE;
/*!40000 ALTER TABLE `AuthAssignment` DISABLE KEYS */;
INSERT INTO `AuthAssignment`
VALUES ('Admin', '1', NULL, 'N');
/*!40000 ALTER TABLE `AuthAssignment` ENABLE KEYS */;
UNLOCK
TABLES;

--
-- Table structure for table `AuthItem`
--

DROP TABLE IF EXISTS `AuthItem`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `AuthItem`
(
    `name`        varchar(255) NOT NULL,
    `type`        int          NOT NULL,
    `description` text,
    `bizrule`     text,
    `data`        text,
    PRIMARY KEY (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `AuthItem`
--

LOCK
TABLES `AuthItem` WRITE;
/*!40000 ALTER TABLE `AuthItem` DISABLE KEYS */;
INSERT INTO `AuthItem`
VALUES ('Admin', 2, 'Admin', NULL, 'N;');
/*!40000 ALTER TABLE `AuthItem` ENABLE KEYS */;
UNLOCK
TABLES;

--
-- Table structure for table `YiiCache`
--

DROP TABLE IF EXISTS `YiiCache`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `YiiCache`
(
    `id`     char(128) NOT NULL,
    `expire` int DEFAULT NULL,
    `value`  longblob,
    PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `YiiCache`
--

LOCK
TABLES `YiiCache` WRITE;
/*!40000 ALTER TABLE `YiiCache` DISABLE KEYS */;
INSERT INTO `YiiCache`
VALUES ('303deed359a62a9065a78f3653d956e0', 1658558341,
        _binary 'a:2:{i:0;O:17:\"CMysqlTableSchema\":9:{s:10:\"schemaName\";N;s:4:\"name\";s:12:\"your_company\";s:7:\"rawName\";s:14:\"`your_company`\";s:10:\"primaryKey\";s:2:\"id\";s:12:\"sequenceName\";s:0:\"\";s:11:\"foreignKeys\";a:0:{}s:7:\"columns\";a:22:{s:2:\"id\";O:18:\"CMysqlColumnSchema\":15:{s:4:\"name\";s:2:\"id\";s:7:\"rawName\";s:4:\"`id`\";s:9:\"allowNull\";b:0;s:6:\"dbType\";s:3:\"int\";s:4:\"type\";s:7:\"integer\";s:12:\"defaultValue\";N;s:4:\"size\";N;s:9:\"precision\";N;s:5:\"scale\";N;s:12:\"isPrimaryKey\";b:1;s:12:\"isForeignKey\";b:0;s:13:\"autoIncrement\";b:1;s:7:\"comment\";s:0:\"\";s:14:\"\0CComponent\0_e\";N;s:14:\"\0CComponent\0_m\";N;}s:12:\"company_name\";O:18:\"CMysqlColumnSchema\":15:{s:4:\"name\";s:12:\"company_name\";s:7:\"rawName\";s:14:\"`company_name`\";s:9:\"allowNull\";b:1;s:6:\"dbType\";s:12:\"varchar(255)\";s:4:\"type\";s:6:\"string\";s:12:\"defaultValue\";N;s:4:\"size\";i:255;s:9:\"precision\";i:255;s:5:\"scale\";N;s:12:\"isPrimaryKey\";b:0;s:12:\"isForeignKey\";b:0;s:13:\"autoIncrement\";b:0;s:7:\"comment\";s:0:\"\";s:14:\"\0CComponent\0_e\";N;s:14:\"\0CComponent\0_m\";N;}s:8:\"location\";O:18:\"CMysqlColumnSchema\":15:{s:4:\"name\";s:8:\"location\";s:7:\"rawName\";s:10:\"`location`\";s:9:\"allowNull\";b:1;s:6:\"dbType\";s:12:\"varchar(255)\";s:4:\"type\";s:6:\"string\";s:12:\"defaultValue\";N;s:4:\"size\";i:255;s:9:\"precision\";i:255;s:5:\"scale\";N;s:12:\"isPrimaryKey\";b:0;s:12:\"isForeignKey\";b:0;s:13:\"autoIncrement\";b:0;s:7:\"comment\";s:0:\"\";s:14:\"\0CComponent\0_e\";N;s:14:\"\0CComponent\0_m\";N;}s:4:\"road\";O:18:\"CMysqlColumnSchema\":15:{s:4:\"name\";s:4:\"road\";s:7:\"rawName\";s:6:\"`road`\";s:9:\"allowNull\";b:1;s:6:\"dbType\";s:12:\"varchar(255)\";s:4:\"type\";s:6:\"string\";s:12:\"defaultValue\";N;s:4:\"size\";i:255;s:9:\"precision\";i:255;s:5:\"scale\";N;s:12:\"isPrimaryKey\";b:0;s:12:\"isForeignKey\";b:0;s:13:\"autoIncrement\";b:0;s:7:\"comment\";s:0:\"\";s:14:\"\0CComponent\0_e\";N;s:14:\"\0CComponent\0_m\";N;}s:5:\"house\";O:18:\"CMysqlColumnSchema\":15:{s:4:\"name\";s:5:\"house\";s:7:\"rawName\";s:7:\"`house`\";s:9:\"allowNull\";b:1;s:6:\"dbType\";s:12:\"varchar(255)\";s:4:\"type\";s:6:\"string\";s:12:\"defaultValue\";N;s:4:\"size\";i:255;s:9:\"precision\";i:255;s:5:\"scale\";N;s:12:\"isPrimaryKey\";b:0;s:12:\"isForeignKey\";b:0;s:13:\"autoIncrement\";b:0;s:7:\"comment\";s:0:\"\";s:14:\"\0CComponent\0_e\";N;s:14:\"\0CComponent\0_m\";N;}s:7:\"contact\";O:18:\"CMysqlColumnSchema\":15:{s:4:\"name\";s:7:\"contact\";s:7:\"rawName\";s:9:\"`contact`\";s:9:\"allowNull\";b:1;s:6:\"dbType\";s:12:\"varchar(255)\";s:4:\"type\";s:6:\"string\";s:12:\"defaultValue\";N;s:4:\"size\";i:255;s:9:\"precision\";i:255;s:5:\"scale\";N;s:12:\"isPrimaryKey\";b:0;s:12:\"isForeignKey\";b:0;s:13:\"autoIncrement\";b:0;s:7:\"comment\";s:0:\"\";s:14:\"\0CComponent\0_e\";N;s:14:\"\0CComponent\0_m\";N;}s:5:\"email\";O:18:\"CMysqlColumnSchema\":15:{s:4:\"name\";s:5:\"email\";s:7:\"rawName\";s:7:\"`email`\";s:9:\"allowNull\";b:1;s:6:\"dbType\";s:12:\"varchar(255)\";s:4:\"type\";s:6:\"string\";s:12:\"defaultValue\";N;s:4:\"size\";i:255;s:9:\"precision\";i:255;s:5:\"scale\";N;s:12:\"isPrimaryKey\";b:0;s:12:\"isForeignKey\";b:0;s:13:\"autoIncrement\";b:0;s:7:\"comment\";s:0:\"\";s:14:\"\0CComponent\0_e\";N;s:14:\"\0CComponent\0_m\";N;}s:3:\"web\";O:18:\"CMysqlColumnSchema\":15:{s:4:\"name\";s:3:\"web\";s:7:\"rawName\";s:5:\"`web`\";s:9:\"allowNull\";b:1;s:6:\"dbType\";s:12:\"varchar(255)\";s:4:\"type\";s:6:\"string\";s:12:\"defaultValue\";N;s:4:\"size\";i:255;s:9:\"precision\";i:255;s:5:\"scale\";N;s:12:\"isPrimaryKey\";b:0;s:12:\"isForeignKey\";b:0;s:13:\"autoIncrement\";b:0;s:7:\"comment\";s:0:\"\";s:14:\"\0CComponent\0_e\";N;s:14:\"\0CComponent\0_m\";N;}s:11:\"vat_regi_no\";O:18:\"CMysqlColumnSchema\":15:{s:4:\"name\";s:11:\"vat_regi_no\";s:7:\"rawName\";s:13:\"`vat_regi_no`\";s:9:\"allowNull\";b:1;s:6:\"dbType\";s:12:\"varchar(255)\";s:4:\"type\";s:6:\"string\";s:12:\"defaultValue\";N;s:4:\"size\";i:255;s:9:\"precision\";i:255;s:5:\"scale\";N;s:12:\"isPrimaryKey\";b:0;s:12:\"isForeignKey\";b:0;s:13:\"autoIncrement\";b:0;s:7:\"comment\";s:0:\"\";s:14:\"\0CComponent\0_e\";N;s:14:\"\0CComponent\0_m\";N;}s:3:\"tin\";O:18:\"CMysqlColumnSchema\":15:{s:4:\"name\";s:3:\"tin\";s:7:\"rawName\";s:5:\"`tin`\";s:9:\"allowNull\";b:1;s:6:\"dbType\";s:12:\"varchar(255)\";s:4:\"type\";s:6:\"string\";s:12:\"defaultValue\";N;s:4:\"size\";i:255;s:9:\"precision\";i:255;s:5:\"scale\";N;s:12:\"isPrimaryKey\";b:0;s:12:\"isForeignKey\";b:0;s:13:\"autoIncrement\";b:0;s:7:\"comment\";s:0:\"\";s:14:\"\0CComponent\0_e\";N;s:14:\"\0CComponent\0_m\";N;}s:6:\"trn_no\";O:18:\"CMysqlColumnSchema\":15:{s:4:\"name\";s:6:\"trn_no\";s:7:\"rawName\";s:8:\"`trn_no`\";s:9:\"allowNull\";b:1;s:6:\"dbType\";s:12:\"varchar(255)\";s:4:\"type\";s:6:\"string\";s:12:\"defaultValue\";N;s:4:\"size\";i:255;s:9:\"precision\";i:255;s:5:\"scale\";N;s:12:\"isPrimaryKey\";b:0;s:12:\"isForeignKey\";b:0;s:13:\"autoIncrement\";b:0;s:7:\"comment\";s:0:\"\";s:14:\"\0CComponent\0_e\";N;s:14:\"\0CComponent\0_m\";N;}s:11:\"opening_vat\";O:18:\"CMysqlColumnSchema\":15:{s:4:\"name\";s:11:\"opening_vat\";s:7:\"rawName\";s:13:\"`opening_vat`\";s:9:\"allowNull\";b:1;s:6:\"dbType\";s:6:\"double\";s:4:\"type\";s:6:\"double\";s:12:\"defaultValue\";N;s:4:\"size\";N;s:9:\"precision\";N;s:5:\"scale\";N;s:12:\"isPrimaryKey\";b:0;s:12:\"isForeignKey\";b:0;s:13:\"autoIncrement\";b:0;s:7:\"comment\";s:0:\"\";s:14:\"\0CComponent\0_e\";N;s:14:\"\0CComponent\0_m\";N;}s:10:\"opening_sd\";O:18:\"CMysqlColumnSchema\":15:{s:4:\"name\";s:10:\"opening_sd\";s:7:\"rawName\";s:12:\"`opening_sd`\";s:9:\"allowNull\";b:1;s:6:\"dbType\";s:6:\"double\";s:4:\"type\";s:6:\"double\";s:12:\"defaultValue\";N;s:4:\"size\";N;s:9:\"precision\";N;s:5:\"scale\";N;s:12:\"isPrimaryKey\";b:0;s:12:\"isForeignKey\";b:0;s:13:\"autoIncrement\";b:0;s:7:\"comment\";s:0:\"\";s:14:\"\0CComponent\0_e\";N;s:14:\"\0CComponent\0_m\";N;}s:18:\"previous_month_vat\";O:18:\"CMysqlColumnSchema\":15:{s:4:\"name\";s:18:\"previous_month_vat\";s:7:\"rawName\";s:20:\"`previous_month_vat`\";s:9:\"allowNull\";b:1;s:6:\"dbType\";s:6:\"double\";s:4:\"type\";s:6:\"double\";s:12:\"defaultValue\";N;s:4:\"size\";N;s:9:\"precision\";N;s:5:\"scale\";N;s:12:\"isPrimaryKey\";b:0;s:12:\"isForeignKey\";b:0;s:13:\"autoIncrement\";b:0;s:7:\"comment\";s:0:\"\";s:14:\"\0CComponent\0_e\";N;s:14:\"\0CComponent\0_m\";N;}s:17:\"previous_month_sd\";O:18:\"CMysqlColumnSchema\":15:{s:4:\"name\";s:17:\"previous_month_sd\";s:7:\"rawName\";s:19:\"`previous_month_sd`\";s:9:\"allowNull\";b:1;s:6:\"dbType\";s:6:\"double\";s:4:\"type\";s:6:\"double\";s:12:\"defaultValue\";N;s:4:\"size\";N;s:9:\"precision\";N;s:5:\"scale\";N;s:12:\"isPrimaryKey\";b:0;s:12:\"isForeignKey\";b:0;s:13:\"autoIncrement\";b:0;s:7:\"comment\";s:0:\"\";s:14:\"\0CComponent\0_e\";N;s:14:\"\0CComponent\0_m\";N;}s:19:\"registration_nature\";O:18:\"CMysqlColumnSchema\":15:{s:4:\"name\";s:19:\"registration_nature\";s:7:\"rawName\";s:21:\"`registration_nature`\";s:9:\"allowNull\";b:1;s:6:\"dbType\";s:3:\"int\";s:4:\"type\";s:7:\"integer\";s:12:\"defaultValue\";N;s:4:\"size\";N;s:9:\"precision\";N;s:5:\"scale\";N;s:12:\"isPrimaryKey\";b:0;s:12:\"isForeignKey\";b:0;s:13:\"autoIncrement\";b:0;s:7:\"comment\";s:0:\"\";s:14:\"\0CComponent\0_e\";N;s:14:\"\0CComponent\0_m\";N;}s:21:\"registration_criteria\";O:18:\"CMysqlColumnSchema\":15:{s:4:\"name\";s:21:\"registration_criteria\";s:7:\"rawName\";s:23:\"`registration_criteria`\";s:9:\"allowNull\";b:1;s:6:\"dbType\";s:3:\"int\";s:4:\"type\";s:7:\"integer\";s:12:\"defaultValue\";N;s:4:\"size\";N;s:9:\"precision\";N;s:5:\"scale\";N;s:12:\"isPrimaryKey\";b:0;s:12:\"isForeignKey\";b:0;s:13:\"autoIncrement\";b:0;s:7:\"comment\";s:0:\"\";s:14:\"\0CComponent\0_e\";N;s:14:\"\0CComponent\0_m\";N;}s:13:\"business_type\";O:18:\"CMysqlColumnSchema\":15:{s:4:\"name\";s:13:\"business_type\";s:7:\"rawName\";s:15:\"`business_type`\";s:9:\"allowNull\";b:1;s:6:\"dbType\";s:3:\"int\";s:4:\"type\";s:7:\"integer\";s:12:\"defaultValue\";N;s:4:\"size\";N;s:9:\"precision\";N;s:5:\"scale\";N;s:12:\"isPrimaryKey\";b:0;s:12:\"isForeignKey\";b:0;s:13:\"autoIncrement\";b:0;s:7:\"comment\";s:0:\"\";s:14:\"\0CComponent\0_e\";N;s:14:\"\0CComponent\0_m\";N;}s:16:\"business_process\";O:18:\"CMysqlColumnSchema\":15:{s:4:\"name\";s:16:\"business_process\";s:7:\"rawName\";s:18:\"`business_process`\";s:9:\"allowNull\";b:1;s:6:\"dbType\";s:3:\"int\";s:4:\"type\";s:7:\"integer\";s:12:\"defaultValue\";N;s:4:\"size\";N;s:9:\"precision\";N;s:5:\"scale\";N;s:12:\"isPrimaryKey\";b:0;s:12:\"isForeignKey\";b:0;s:13:\"autoIncrement\";b:0;s:7:\"comment\";s:0:\"\";s:14:\"\0CComponent\0_e\";N;s:14:\"\0CComponent\0_m\";N;}s:16:\"company_vat_type\";O:18:\"CMysqlColumnSchema\":15:{s:4:\"name\";s:16:\"company_vat_type\";s:7:\"rawName\";s:18:\"`company_vat_type`\";s:9:\"allowNull\";b:1;s:6:\"dbType\";s:7:\"tinyint\";s:4:\"type\";s:7:\"integer\";s:12:\"defaultValue\";N;s:4:\"size\";N;s:9:\"precision\";N;s:5:\"scale\";N;s:12:\"isPrimaryKey\";b:0;s:12:\"isForeignKey\";b:0;s:13:\"autoIncrement\";b:0;s:7:\"comment\";s:0:\"\";s:14:\"\0CComponent\0_e\";N;s:14:\"\0CComponent\0_m\";N;}s:17:\"company_sales_vat\";O:18:\"CMysqlColumnSchema\":15:{s:4:\"name\";s:17:\"company_sales_vat\";s:7:\"rawName\";s:19:\"`company_sales_vat`\";s:9:\"allowNull\";b:1;s:6:\"dbType\";s:6:\"double\";s:4:\"type\";s:6:\"double\";s:12:\"defaultValue\";N;s:4:\"size\";N;s:9:\"precision\";N;s:5:\"scale\";N;s:12:\"isPrimaryKey\";b:0;s:12:\"isForeignKey\";b:0;s:13:\"autoIncrement\";b:0;s:7:\"comment\";s:0:\"\";s:14:\"\0CComponent\0_e\";N;s:14:\"\0CComponent\0_m\";N;}s:9:\"is_active\";O:18:\"CMysqlColumnSchema\":15:{s:4:\"name\";s:9:\"is_active\";s:7:\"rawName\";s:11:\"`is_active`\";s:9:\"allowNull\";b:1;s:6:\"dbType\";s:3:\"int\";s:4:\"type\";s:7:\"integer\";s:12:\"defaultValue\";i:1;s:4:\"size\";N;s:9:\"precision\";N;s:5:\"scale\";N;s:12:\"isPrimaryKey\";b:0;s:12:\"isForeignKey\";b:0;s:13:\"autoIncrement\";b:0;s:7:\"comment\";s:0:\"\";s:14:\"\0CComponent\0_e\";N;s:14:\"\0CComponent\0_m\";N;}}s:14:\"\0CComponent\0_e\";N;s:14:\"\0CComponent\0_m\";N;}i:1;N;}'),
       ('57a11cfa0d653a8206c11075cc8a6be4', 1658558341,
        _binary 'a:2:{i:0;O:17:\"CMysqlTableSchema\":9:{s:10:\"schemaName\";N;s:4:\"name\";s:5:\"users\";s:7:\"rawName\";s:7:\"`users`\";s:10:\"primaryKey\";s:2:\"id\";s:12:\"sequenceName\";s:0:\"\";s:11:\"foreignKeys\";a:0:{}s:7:\"columns\";a:18:{s:2:\"id\";O:18:\"CMysqlColumnSchema\":15:{s:4:\"name\";s:2:\"id\";s:7:\"rawName\";s:4:\"`id`\";s:9:\"allowNull\";b:0;s:6:\"dbType\";s:3:\"int\";s:4:\"type\";s:7:\"integer\";s:12:\"defaultValue\";N;s:4:\"size\";N;s:9:\"precision\";N;s:5:\"scale\";N;s:12:\"isPrimaryKey\";b:1;s:12:\"isForeignKey\";b:0;s:13:\"autoIncrement\";b:1;s:7:\"comment\";s:0:\"\";s:14:\"\0CComponent\0_e\";N;s:14:\"\0CComponent\0_m\";N;}s:11:\"employee_id\";O:18:\"CMysqlColumnSchema\":15:{s:4:\"name\";s:11:\"employee_id\";s:7:\"rawName\";s:13:\"`employee_id`\";s:9:\"allowNull\";b:1;s:6:\"dbType\";s:3:\"int\";s:4:\"type\";s:7:\"integer\";s:12:\"defaultValue\";N;s:4:\"size\";N;s:9:\"precision\";N;s:5:\"scale\";N;s:12:\"isPrimaryKey\";b:0;s:12:\"isForeignKey\";b:0;s:13:\"autoIncrement\";b:0;s:7:\"comment\";s:0:\"\";s:14:\"\0CComponent\0_e\";N;s:14:\"\0CComponent\0_m\";N;}s:12:\"usersroll_id\";O:18:\"CMysqlColumnSchema\":15:{s:4:\"name\";s:12:\"usersroll_id\";s:7:\"rawName\";s:14:\"`usersroll_id`\";s:9:\"allowNull\";b:1;s:6:\"dbType\";s:3:\"int\";s:4:\"type\";s:7:\"integer\";s:12:\"defaultValue\";N;s:4:\"size\";N;s:9:\"precision\";N;s:5:\"scale\";N;s:12:\"isPrimaryKey\";b:0;s:12:\"isForeignKey\";b:0;s:13:\"autoIncrement\";b:0;s:7:\"comment\";s:0:\"\";s:14:\"\0CComponent\0_e\";N;s:14:\"\0CComponent\0_m\";N;}s:7:\"uniq_id\";O:18:\"CMysqlColumnSchema\":15:{s:4:\"name\";s:7:\"uniq_id\";s:7:\"rawName\";s:9:\"`uniq_id`\";s:9:\"allowNull\";b:1;s:6:\"dbType\";s:12:\"varchar(255)\";s:4:\"type\";s:6:\"string\";s:12:\"defaultValue\";N;s:4:\"size\";i:255;s:9:\"precision\";i:255;s:5:\"scale\";N;s:12:\"isPrimaryKey\";b:0;s:12:\"isForeignKey\";b:0;s:13:\"autoIncrement\";b:0;s:7:\"comment\";s:0:\"\";s:14:\"\0CComponent\0_e\";N;s:14:\"\0CComponent\0_m\";N;}s:8:\"username\";O:18:\"CMysqlColumnSchema\":15:{s:4:\"name\";s:8:\"username\";s:7:\"rawName\";s:10:\"`username`\";s:9:\"allowNull\";b:0;s:6:\"dbType\";s:12:\"varchar(255)\";s:4:\"type\";s:6:\"string\";s:12:\"defaultValue\";N;s:4:\"size\";i:255;s:9:\"precision\";i:255;s:5:\"scale\";N;s:12:\"isPrimaryKey\";b:0;s:12:\"isForeignKey\";b:0;s:13:\"autoIncrement\";b:0;s:7:\"comment\";s:0:\"\";s:14:\"\0CComponent\0_e\";N;s:14:\"\0CComponent\0_m\";N;}s:8:\"password\";O:18:\"CMysqlColumnSchema\":15:{s:4:\"name\";s:8:\"password\";s:7:\"rawName\";s:10:\"`password`\";s:9:\"allowNull\";b:0;s:6:\"dbType\";s:12:\"varchar(255)\";s:4:\"type\";s:6:\"string\";s:12:\"defaultValue\";N;s:4:\"size\";i:255;s:9:\"precision\";i:255;s:5:\"scale\";N;s:12:\"isPrimaryKey\";b:0;s:12:\"isForeignKey\";b:0;s:13:\"autoIncrement\";b:0;s:7:\"comment\";s:0:\"\";s:14:\"\0CComponent\0_e\";N;s:14:\"\0CComponent\0_m\";N;}s:5:\"email\";O:18:\"CMysqlColumnSchema\":15:{s:4:\"name\";s:5:\"email\";s:7:\"rawName\";s:7:\"`email`\";s:9:\"allowNull\";b:1;s:6:\"dbType\";s:12:\"varchar(128)\";s:4:\"type\";s:6:\"string\";s:12:\"defaultValue\";N;s:4:\"size\";i:128;s:9:\"precision\";i:128;s:5:\"scale\";N;s:12:\"isPrimaryKey\";b:0;s:12:\"isForeignKey\";b:0;s:13:\"autoIncrement\";b:0;s:7:\"comment\";s:0:\"\";s:14:\"\0CComponent\0_e\";N;s:14:\"\0CComponent\0_m\";N;}s:8:\"activkey\";O:18:\"CMysqlColumnSchema\":15:{s:4:\"name\";s:8:\"activkey\";s:7:\"rawName\";s:10:\"`activkey`\";s:9:\"allowNull\";b:1;s:6:\"dbType\";s:12:\"varchar(128)\";s:4:\"type\";s:6:\"string\";s:12:\"defaultValue\";N;s:4:\"size\";i:128;s:9:\"precision\";i:128;s:5:\"scale\";N;s:12:\"isPrimaryKey\";b:0;s:12:\"isForeignKey\";b:0;s:13:\"autoIncrement\";b:0;s:7:\"comment\";s:0:\"\";s:14:\"\0CComponent\0_e\";N;s:14:\"\0CComponent\0_m\";N;}s:12:\"lastvisit_at\";O:18:\"CMysqlColumnSchema\":15:{s:4:\"name\";s:12:\"lastvisit_at\";s:7:\"rawName\";s:14:\"`lastvisit_at`\";s:9:\"allowNull\";b:1;s:6:\"dbType\";s:9:\"timestamp\";s:4:\"type\";s:6:\"string\";s:12:\"defaultValue\";s:19:\"0000-00-00 00:00:00\";s:4:\"size\";N;s:9:\"precision\";N;s:5:\"scale\";N;s:12:\"isPrimaryKey\";b:0;s:12:\"isForeignKey\";b:0;s:13:\"autoIncrement\";b:0;s:7:\"comment\";s:0:\"\";s:14:\"\0CComponent\0_e\";N;s:14:\"\0CComponent\0_m\";N;}s:9:\"superuser\";O:18:\"CMysqlColumnSchema\":15:{s:4:\"name\";s:9:\"superuser\";s:7:\"rawName\";s:11:\"`superuser`\";s:9:\"allowNull\";b:0;s:6:\"dbType\";s:3:\"int\";s:4:\"type\";s:7:\"integer\";s:12:\"defaultValue\";i:0;s:4:\"size\";N;s:9:\"precision\";N;s:5:\"scale\";N;s:12:\"isPrimaryKey\";b:0;s:12:\"isForeignKey\";b:0;s:13:\"autoIncrement\";b:0;s:7:\"comment\";s:0:\"\";s:14:\"\0CComponent\0_e\";N;s:14:\"\0CComponent\0_m\";N;}s:9:\"is_active\";O:18:\"CMysqlColumnSchema\":15:{s:4:\"name\";s:9:\"is_active\";s:7:\"rawName\";s:11:\"`is_active`\";s:9:\"allowNull\";b:0;s:6:\"dbType\";s:7:\"tinyint\";s:4:\"type\";s:7:\"integer\";s:12:\"defaultValue\";i:1;s:4:\"size\";N;s:9:\"precision\";N;s:5:\"scale\";N;s:12:\"isPrimaryKey\";b:0;s:12:\"isForeignKey\";b:0;s:13:\"autoIncrement\";b:0;s:7:\"comment\";s:0:\"\";s:14:\"\0CComponent\0_e\";N;s:14:\"\0CComponent\0_m\";N;}s:6:\"status\";O:18:\"CMysqlColumnSchema\":15:{s:4:\"name\";s:6:\"status\";s:7:\"rawName\";s:8:\"`status`\";s:9:\"allowNull\";b:0;s:6:\"dbType\";s:10:\"tinyint(1)\";s:4:\"type\";s:7:\"integer\";s:12:\"defaultValue\";i:0;s:4:\"size\";i:1;s:9:\"precision\";i:1;s:5:\"scale\";N;s:12:\"isPrimaryKey\";b:0;s:12:\"isForeignKey\";b:0;s:13:\"autoIncrement\";b:0;s:7:\"comment\";s:0:\"\";s:14:\"\0CComponent\0_e\";N;s:14:\"\0CComponent\0_m\";N;}s:8:\"store_id\";O:18:\"CMysqlColumnSchema\":15:{s:4:\"name\";s:8:\"store_id\";s:7:\"rawName\";s:10:\"`store_id`\";s:9:\"allowNull\";b:1;s:6:\"dbType\";s:3:\"int\";s:4:\"type\";s:7:\"integer\";s:12:\"defaultValue\";N;s:4:\"size\";N;s:9:\"precision\";N;s:5:\"scale\";N;s:12:\"isPrimaryKey\";b:0;s:12:\"isForeignKey\";b:0;s:13:\"autoIncrement\";b:0;s:7:\"comment\";s:0:\"\";s:14:\"\0CComponent\0_e\";N;s:14:\"\0CComponent\0_m\";N;}s:9:\"create_by\";O:18:\"CMysqlColumnSchema\":15:{s:4:\"name\";s:9:\"create_by\";s:7:\"rawName\";s:11:\"`create_by`\";s:9:\"allowNull\";b:1;s:6:\"dbType\";s:12:\"varchar(255)\";s:4:\"type\";s:6:\"string\";s:12:\"defaultValue\";N;s:4:\"size\";i:255;s:9:\"precision\";i:255;s:5:\"scale\";N;s:12:\"isPrimaryKey\";b:0;s:12:\"isForeignKey\";b:0;s:13:\"autoIncrement\";b:0;s:7:\"comment\";s:0:\"\";s:14:\"\0CComponent\0_e\";N;s:14:\"\0CComponent\0_m\";N;}s:9:\"create_at\";O:18:\"CMysqlColumnSchema\":15:{s:4:\"name\";s:9:\"create_at\";s:7:\"rawName\";s:11:\"`create_at`\";s:9:\"allowNull\";b:0;s:6:\"dbType\";s:9:\"timestamp\";s:4:\"type\";s:6:\"string\";s:12:\"defaultValue\";N;s:4:\"size\";N;s:9:\"precision\";N;s:5:\"scale\";N;s:12:\"isPrimaryKey\";b:0;s:12:\"isForeignKey\";b:0;s:13:\"autoIncrement\";b:0;s:7:\"comment\";s:0:\"\";s:14:\"\0CComponent\0_e\";N;s:14:\"\0CComponent\0_m\";N;}s:11:\"create_time\";O:18:\"CMysqlColumnSchema\":15:{s:4:\"name\";s:11:\"create_time\";s:7:\"rawName\";s:13:\"`create_time`\";s:9:\"allowNull\";b:1;s:6:\"dbType\";s:8:\"datetime\";s:4:\"type\";s:6:\"string\";s:12:\"defaultValue\";N;s:4:\"size\";N;s:9:\"precision\";N;s:5:\"scale\";N;s:12:\"isPrimaryKey\";b:0;s:12:\"isForeignKey\";b:0;s:13:\"autoIncrement\";b:0;s:7:\"comment\";s:0:\"\";s:14:\"\0CComponent\0_e\";N;s:14:\"\0CComponent\0_m\";N;}s:9:\"update_by\";O:18:\"CMysqlColumnSchema\":15:{s:4:\"name\";s:9:\"update_by\";s:7:\"rawName\";s:11:\"`update_by`\";s:9:\"allowNull\";b:1;s:6:\"dbType\";s:12:\"varchar(255)\";s:4:\"type\";s:6:\"string\";s:12:\"defaultValue\";N;s:4:\"size\";i:255;s:9:\"precision\";i:255;s:5:\"scale\";N;s:12:\"isPrimaryKey\";b:0;s:12:\"isForeignKey\";b:0;s:13:\"autoIncrement\";b:0;s:7:\"comment\";s:0:\"\";s:14:\"\0CComponent\0_e\";N;s:14:\"\0CComponent\0_m\";N;}s:11:\"update_time\";O:18:\"CMysqlColumnSchema\":15:{s:4:\"name\";s:11:\"update_time\";s:7:\"rawName\";s:13:\"`update_time`\";s:9:\"allowNull\";b:1;s:6:\"dbType\";s:8:\"datetime\";s:4:\"type\";s:6:\"string\";s:12:\"defaultValue\";N;s:4:\"size\";N;s:9:\"precision\";N;s:5:\"scale\";N;s:12:\"isPrimaryKey\";b:0;s:12:\"isForeignKey\";b:0;s:13:\"autoIncrement\";b:0;s:7:\"comment\";s:0:\"\";s:14:\"\0CComponent\0_e\";N;s:14:\"\0CComponent\0_m\";N;}}s:14:\"\0CComponent\0_e\";N;s:14:\"\0CComponent\0_m\";N;}i:1;N;}'),
       ('6a5abbc57511ccb4665443c32eb66800', 1658558341,
        _binary 'a:2:{i:0;O:17:\"CMysqlTableSchema\":9:{s:10:\"schemaName\";N;s:4:\"name\";s:15:\"expense_details\";s:7:\"rawName\";s:17:\"`expense_details`\";s:10:\"primaryKey\";s:2:\"id\";s:12:\"sequenceName\";s:0:\"\";s:11:\"foreignKeys\";a:0:{}s:7:\"columns\";a:9:{s:2:\"id\";O:18:\"CMysqlColumnSchema\":15:{s:4:\"name\";s:2:\"id\";s:7:\"rawName\";s:4:\"`id`\";s:9:\"allowNull\";b:0;s:6:\"dbType\";s:3:\"int\";s:4:\"type\";s:7:\"integer\";s:12:\"defaultValue\";N;s:4:\"size\";N;s:9:\"precision\";N;s:5:\"scale\";N;s:12:\"isPrimaryKey\";b:1;s:12:\"isForeignKey\";b:0;s:13:\"autoIncrement\";b:1;s:7:\"comment\";s:0:\"\";s:14:\"\0CComponent\0_e\";N;s:14:\"\0CComponent\0_m\";N;}s:10:\"expense_id\";O:18:\"CMysqlColumnSchema\":15:{s:4:\"name\";s:10:\"expense_id\";s:7:\"rawName\";s:12:\"`expense_id`\";s:9:\"allowNull\";b:0;s:6:\"dbType\";s:3:\"int\";s:4:\"type\";s:7:\"integer\";s:12:\"defaultValue\";N;s:4:\"size\";N;s:9:\"precision\";N;s:5:\"scale\";N;s:12:\"isPrimaryKey\";b:0;s:12:\"isForeignKey\";b:0;s:13:\"autoIncrement\";b:0;s:7:\"comment\";s:0:\"\";s:14:\"\0CComponent\0_e\";N;s:14:\"\0CComponent\0_m\";N;}s:15:\"expense_head_id\";O:18:\"CMysqlColumnSchema\":15:{s:4:\"name\";s:15:\"expense_head_id\";s:7:\"rawName\";s:17:\"`expense_head_id`\";s:9:\"allowNull\";b:0;s:6:\"dbType\";s:3:\"int\";s:4:\"type\";s:7:\"integer\";s:12:\"defaultValue\";N;s:4:\"size\";N;s:9:\"precision\";N;s:5:\"scale\";N;s:12:\"isPrimaryKey\";b:0;s:12:\"isForeignKey\";b:0;s:13:\"autoIncrement\";b:0;s:7:\"comment\";s:0:\"\";s:14:\"\0CComponent\0_e\";N;s:14:\"\0CComponent\0_m\";N;}s:6:\"amount\";O:18:\"CMysqlColumnSchema\":15:{s:4:\"name\";s:6:\"amount\";s:7:\"rawName\";s:8:\"`amount`\";s:9:\"allowNull\";b:0;s:6:\"dbType\";s:6:\"double\";s:4:\"type\";s:6:\"double\";s:12:\"defaultValue\";N;s:4:\"size\";N;s:9:\"precision\";N;s:5:\"scale\";N;s:12:\"isPrimaryKey\";b:0;s:12:\"isForeignKey\";b:0;s:13:\"autoIncrement\";b:0;s:7:\"comment\";s:0:\"\";s:14:\"\0CComponent\0_e\";N;s:14:\"\0CComponent\0_m\";N;}s:7:\"remarks\";O:18:\"CMysqlColumnSchema\":15:{s:4:\"name\";s:7:\"remarks\";s:7:\"rawName\";s:9:\"`remarks`\";s:9:\"allowNull\";b:1;s:6:\"dbType\";s:4:\"text\";s:4:\"type\";s:6:\"string\";s:12:\"defaultValue\";N;s:4:\"size\";N;s:9:\"precision\";N;s:5:\"scale\";N;s:12:\"isPrimaryKey\";b:0;s:12:\"isForeignKey\";b:0;s:13:\"autoIncrement\";b:0;s:7:\"comment\";s:0:\"\";s:14:\"\0CComponent\0_e\";N;s:14:\"\0CComponent\0_m\";N;}s:10:\"created_by\";O:18:\"CMysqlColumnSchema\":15:{s:4:\"name\";s:10:\"created_by\";s:7:\"rawName\";s:12:\"`created_by`\";s:9:\"allowNull\";b:1;s:6:\"dbType\";s:3:\"int\";s:4:\"type\";s:7:\"integer\";s:12:\"defaultValue\";N;s:4:\"size\";N;s:9:\"precision\";N;s:5:\"scale\";N;s:12:\"isPrimaryKey\";b:0;s:12:\"isForeignKey\";b:0;s:13:\"autoIncrement\";b:0;s:7:\"comment\";s:0:\"\";s:14:\"\0CComponent\0_e\";N;s:14:\"\0CComponent\0_m\";N;}s:10:\"created_at\";O:18:\"CMysqlColumnSchema\":15:{s:4:\"name\";s:10:\"created_at\";s:7:\"rawName\";s:12:\"`created_at`\";s:9:\"allowNull\";b:1;s:6:\"dbType\";s:8:\"datetime\";s:4:\"type\";s:6:\"string\";s:12:\"defaultValue\";N;s:4:\"size\";N;s:9:\"precision\";N;s:5:\"scale\";N;s:12:\"isPrimaryKey\";b:0;s:12:\"isForeignKey\";b:0;s:13:\"autoIncrement\";b:0;s:7:\"comment\";s:0:\"\";s:14:\"\0CComponent\0_e\";N;s:14:\"\0CComponent\0_m\";N;}s:10:\"updated_by\";O:18:\"CMysqlColumnSchema\":15:{s:4:\"name\";s:10:\"updated_by\";s:7:\"rawName\";s:12:\"`updated_by`\";s:9:\"allowNull\";b:1;s:6:\"dbType\";s:3:\"int\";s:4:\"type\";s:7:\"integer\";s:12:\"defaultValue\";N;s:4:\"size\";N;s:9:\"precision\";N;s:5:\"scale\";N;s:12:\"isPrimaryKey\";b:0;s:12:\"isForeignKey\";b:0;s:13:\"autoIncrement\";b:0;s:7:\"comment\";s:0:\"\";s:14:\"\0CComponent\0_e\";N;s:14:\"\0CComponent\0_m\";N;}s:10:\"updated_at\";O:18:\"CMysqlColumnSchema\":15:{s:4:\"name\";s:10:\"updated_at\";s:7:\"rawName\";s:12:\"`updated_at`\";s:9:\"allowNull\";b:1;s:6:\"dbType\";s:8:\"datetime\";s:4:\"type\";s:6:\"string\";s:12:\"defaultValue\";N;s:4:\"size\";N;s:9:\"precision\";N;s:5:\"scale\";N;s:12:\"isPrimaryKey\";b:0;s:12:\"isForeignKey\";b:0;s:13:\"autoIncrement\";b:0;s:7:\"comment\";s:0:\"\";s:14:\"\0CComponent\0_e\";N;s:14:\"\0CComponent\0_m\";N;}}s:14:\"\0CComponent\0_e\";N;s:14:\"\0CComponent\0_m\";N;}i:1;N;}'),
       ('78dac939742ab10f08169ef7b8318edb', 0,
        _binary 'a:2:{i:0;a:2:{i:0;a:5:{i:0;O:8:\"CUrlRule\":16:{s:9:\"urlSuffix\";N;s:13:\"caseSensitive\";N;s:13:\"defaultParams\";a:0:{}s:10:\"matchValue\";N;s:4:\"verb\";N;s:11:\"parsingOnly\";b:0;s:5:\"route\";s:17:\"<controller>/view\";s:10:\"references\";a:1:{s:10:\"controller\";s:12:\"<controller>\";}s:12:\"routePattern\";s:30:\"/^(?P<controller>\\w+)\\/view$/u\";s:7:\"pattern\";s:39:\"/^(?P<controller>\\w+)\\/(?P<id>\\d+)\\/$/u\";s:8:\"template\";s:17:\"<controller>/<id>\";s:6:\"params\";a:1:{s:2:\"id\";s:3:\"\\d+\";}s:6:\"append\";b:0;s:11:\"hasHostInfo\";b:0;s:14:\"\0CComponent\0_e\";N;s:14:\"\0CComponent\0_m\";N;}i:1;O:8:\"CUrlRule\":16:{s:9:\"urlSuffix\";N;s:13:\"caseSensitive\";N;s:13:\"defaultParams\";a:0:{}s:10:\"matchValue\";N;s:4:\"verb\";N;s:11:\"parsingOnly\";b:0;s:5:\"route\";s:21:\"<controller>/<action>\";s:10:\"references\";a:2:{s:10:\"controller\";s:12:\"<controller>\";s:6:\"action\";s:8:\"<action>\";}s:12:\"routePattern\";s:41:\"/^(?P<controller>\\w+)\\/(?P<action>\\w+)$/u\";s:7:\"pattern\";s:56:\"/^(?P<controller>\\w+)\\/(?P<action>\\w+)\\/(?P<id>\\d+)\\/$/u\";s:8:\"template\";s:26:\"<controller>/<action>/<id>\";s:6:\"params\";a:1:{s:2:\"id\";s:3:\"\\d+\";}s:6:\"append\";b:0;s:11:\"hasHostInfo\";b:0;s:14:\"\0CComponent\0_e\";N;s:14:\"\0CComponent\0_m\";N;}i:2;O:8:\"CUrlRule\":16:{s:9:\"urlSuffix\";N;s:13:\"caseSensitive\";N;s:13:\"defaultParams\";a:0:{}s:10:\"matchValue\";N;s:4:\"verb\";N;s:11:\"parsingOnly\";b:0;s:5:\"route\";s:21:\"<controller>/<action>\";s:10:\"references\";a:2:{s:10:\"controller\";s:12:\"<controller>\";s:6:\"action\";s:8:\"<action>\";}s:12:\"routePattern\";s:41:\"/^(?P<controller>\\w+)\\/(?P<action>\\w+)$/u\";s:7:\"pattern\";s:43:\"/^(?P<controller>\\w+)\\/(?P<action>\\w+)\\/$/u\";s:8:\"template\";s:21:\"<controller>/<action>\";s:6:\"params\";a:0:{}s:6:\"append\";b:0;s:11:\"hasHostInfo\";b:0;s:14:\"\0CComponent\0_e\";N;s:14:\"\0CComponent\0_m\";N;}i:3;O:8:\"CUrlRule\":16:{s:9:\"urlSuffix\";N;s:13:\"caseSensitive\";N;s:13:\"defaultParams\";a:0:{}s:10:\"matchValue\";N;s:4:\"verb\";N;s:11:\"parsingOnly\";b:0;s:5:\"route\";s:30:\"<module>/<controller>/<action>\";s:10:\"references\";a:3:{s:6:\"module\";s:8:\"<module>\";s:10:\"controller\";s:12:\"<controller>\";s:6:\"action\";s:8:\"<action>\";}s:12:\"routePattern\";s:58:\"/^(?P<module>\\w+)\\/(?P<controller>\\w+)\\/(?P<action>\\w+)$/u\";s:7:\"pattern\";s:73:\"/^(?P<module>\\w+)\\/(?P<controller>\\w+)\\/(?P<action>\\w+)\\/(?P<id>\\d+)\\/$/u\";s:8:\"template\";s:35:\"<module>/<controller>/<action>/<id>\";s:6:\"params\";a:1:{s:2:\"id\";s:3:\"\\d+\";}s:6:\"append\";b:0;s:11:\"hasHostInfo\";b:0;s:14:\"\0CComponent\0_e\";N;s:14:\"\0CComponent\0_m\";N;}i:4;O:8:\"CUrlRule\":16:{s:9:\"urlSuffix\";N;s:13:\"caseSensitive\";N;s:13:\"defaultParams\";a:0:{}s:10:\"matchValue\";N;s:4:\"verb\";N;s:11:\"parsingOnly\";b:0;s:5:\"route\";s:30:\"<module>/<controller>/<action>\";s:10:\"references\";a:3:{s:6:\"module\";s:8:\"<module>\";s:10:\"controller\";s:12:\"<controller>\";s:6:\"action\";s:8:\"<action>\";}s:12:\"routePattern\";s:58:\"/^(?P<module>\\w+)\\/(?P<controller>\\w+)\\/(?P<action>\\w+)$/u\";s:7:\"pattern\";s:60:\"/^(?P<module>\\w+)\\/(?P<controller>\\w+)\\/(?P<action>\\w+)\\/$/u\";s:8:\"template\";s:30:\"<module>/<controller>/<action>\";s:6:\"params\";a:0:{}s:6:\"append\";b:0;s:11:\"hasHostInfo\";b:0;s:14:\"\0CComponent\0_e\";N;s:14:\"\0CComponent\0_m\";N;}}i:1;s:32:\"11e14944ead3d161a9aca4d8200ac9db\";}i:1;N;}'),
       ('ce41a6a59e2f79c116a4de432627f977', 1658558341,
        _binary 'a:2:{i:0;O:17:\"CMysqlTableSchema\":9:{s:10:\"schemaName\";N;s:4:\"name\";s:7:\"expense\";s:7:\"rawName\";s:9:\"`expense`\";s:10:\"primaryKey\";s:2:\"id\";s:12:\"sequenceName\";s:0:\"\";s:11:\"foreignKeys\";a:0:{}s:7:\"columns\";a:11:{s:2:\"id\";O:18:\"CMysqlColumnSchema\":15:{s:4:\"name\";s:2:\"id\";s:7:\"rawName\";s:4:\"`id`\";s:9:\"allowNull\";b:0;s:6:\"dbType\";s:3:\"int\";s:4:\"type\";s:7:\"integer\";s:12:\"defaultValue\";N;s:4:\"size\";N;s:9:\"precision\";N;s:5:\"scale\";N;s:12:\"isPrimaryKey\";b:1;s:12:\"isForeignKey\";b:0;s:13:\"autoIncrement\";b:1;s:7:\"comment\";s:0:\"\";s:14:\"\0CComponent\0_e\";N;s:14:\"\0CComponent\0_m\";N;}s:9:\"max_sl_no\";O:18:\"CMysqlColumnSchema\":15:{s:4:\"name\";s:9:\"max_sl_no\";s:7:\"rawName\";s:11:\"`max_sl_no`\";s:9:\"allowNull\";b:0;s:6:\"dbType\";s:3:\"int\";s:4:\"type\";s:7:\"integer\";s:12:\"defaultValue\";N;s:4:\"size\";N;s:9:\"precision\";N;s:5:\"scale\";N;s:12:\"isPrimaryKey\";b:0;s:12:\"isForeignKey\";b:0;s:13:\"autoIncrement\";b:0;s:7:\"comment\";s:0:\"\";s:14:\"\0CComponent\0_e\";N;s:14:\"\0CComponent\0_m\";N;}s:8:\"entry_no\";O:18:\"CMysqlColumnSchema\":15:{s:4:\"name\";s:8:\"entry_no\";s:7:\"rawName\";s:10:\"`entry_no`\";s:9:\"allowNull\";b:0;s:6:\"dbType\";s:12:\"varchar(255)\";s:4:\"type\";s:6:\"string\";s:12:\"defaultValue\";N;s:4:\"size\";i:255;s:9:\"precision\";i:255;s:5:\"scale\";N;s:12:\"isPrimaryKey\";b:0;s:12:\"isForeignKey\";b:0;s:13:\"autoIncrement\";b:0;s:7:\"comment\";s:0:\"\";s:14:\"\0CComponent\0_e\";N;s:14:\"\0CComponent\0_m\";N;}s:4:\"date\";O:18:\"CMysqlColumnSchema\":15:{s:4:\"name\";s:4:\"date\";s:7:\"rawName\";s:6:\"`date`\";s:9:\"allowNull\";b:0;s:6:\"dbType\";s:4:\"date\";s:4:\"type\";s:6:\"string\";s:12:\"defaultValue\";N;s:4:\"size\";N;s:9:\"precision\";N;s:5:\"scale\";N;s:12:\"isPrimaryKey\";b:0;s:12:\"isForeignKey\";b:0;s:13:\"autoIncrement\";b:0;s:7:\"comment\";s:0:\"\";s:14:\"\0CComponent\0_e\";N;s:14:\"\0CComponent\0_m\";N;}s:6:\"amount\";O:18:\"CMysqlColumnSchema\":15:{s:4:\"name\";s:6:\"amount\";s:7:\"rawName\";s:8:\"`amount`\";s:9:\"allowNull\";b:0;s:6:\"dbType\";s:6:\"double\";s:4:\"type\";s:6:\"double\";s:12:\"defaultValue\";N;s:4:\"size\";N;s:9:\"precision\";N;s:5:\"scale\";N;s:12:\"isPrimaryKey\";b:0;s:12:\"isForeignKey\";b:0;s:13:\"autoIncrement\";b:0;s:7:\"comment\";s:0:\"\";s:14:\"\0CComponent\0_e\";N;s:14:\"\0CComponent\0_m\";N;}s:7:\"remarks\";O:18:\"CMysqlColumnSchema\":15:{s:4:\"name\";s:7:\"remarks\";s:7:\"rawName\";s:9:\"`remarks`\";s:9:\"allowNull\";b:1;s:6:\"dbType\";s:4:\"text\";s:4:\"type\";s:6:\"string\";s:12:\"defaultValue\";N;s:4:\"size\";N;s:9:\"precision\";N;s:5:\"scale\";N;s:12:\"isPrimaryKey\";b:0;s:12:\"isForeignKey\";b:0;s:13:\"autoIncrement\";b:0;s:7:\"comment\";s:0:\"\";s:14:\"\0CComponent\0_e\";N;s:14:\"\0CComponent\0_m\";N;}s:11:\"is_approved\";O:18:\"CMysqlColumnSchema\":15:{s:4:\"name\";s:11:\"is_approved\";s:7:\"rawName\";s:13:\"`is_approved`\";s:9:\"allowNull\";b:1;s:6:\"dbType\";s:7:\"tinyint\";s:4:\"type\";s:7:\"integer\";s:12:\"defaultValue\";i:0;s:4:\"size\";N;s:9:\"precision\";N;s:5:\"scale\";N;s:12:\"isPrimaryKey\";b:0;s:12:\"isForeignKey\";b:0;s:13:\"autoIncrement\";b:0;s:7:\"comment\";s:32:\"0=>Pending, 1=>Approved, 2=>Deny\";s:14:\"\0CComponent\0_e\";N;s:14:\"\0CComponent\0_m\";N;}s:10:\"created_by\";O:18:\"CMysqlColumnSchema\":15:{s:4:\"name\";s:10:\"created_by\";s:7:\"rawName\";s:12:\"`created_by`\";s:9:\"allowNull\";b:1;s:6:\"dbType\";s:3:\"int\";s:4:\"type\";s:7:\"integer\";s:12:\"defaultValue\";N;s:4:\"size\";N;s:9:\"precision\";N;s:5:\"scale\";N;s:12:\"isPrimaryKey\";b:0;s:12:\"isForeignKey\";b:0;s:13:\"autoIncrement\";b:0;s:7:\"comment\";s:0:\"\";s:14:\"\0CComponent\0_e\";N;s:14:\"\0CComponent\0_m\";N;}s:10:\"created_at\";O:18:\"CMysqlColumnSchema\":15:{s:4:\"name\";s:10:\"created_at\";s:7:\"rawName\";s:12:\"`created_at`\";s:9:\"allowNull\";b:1;s:6:\"dbType\";s:8:\"datetime\";s:4:\"type\";s:6:\"string\";s:12:\"defaultValue\";N;s:4:\"size\";N;s:9:\"precision\";N;s:5:\"scale\";N;s:12:\"isPrimaryKey\";b:0;s:12:\"isForeignKey\";b:0;s:13:\"autoIncrement\";b:0;s:7:\"comment\";s:0:\"\";s:14:\"\0CComponent\0_e\";N;s:14:\"\0CComponent\0_m\";N;}s:10:\"updated_by\";O:18:\"CMysqlColumnSchema\":15:{s:4:\"name\";s:10:\"updated_by\";s:7:\"rawName\";s:12:\"`updated_by`\";s:9:\"allowNull\";b:1;s:6:\"dbType\";s:3:\"int\";s:4:\"type\";s:7:\"integer\";s:12:\"defaultValue\";N;s:4:\"size\";N;s:9:\"precision\";N;s:5:\"scale\";N;s:12:\"isPrimaryKey\";b:0;s:12:\"isForeignKey\";b:0;s:13:\"autoIncrement\";b:0;s:7:\"comment\";s:0:\"\";s:14:\"\0CComponent\0_e\";N;s:14:\"\0CComponent\0_m\";N;}s:10:\"updated_at\";O:18:\"CMysqlColumnSchema\":15:{s:4:\"name\";s:10:\"updated_at\";s:7:\"rawName\";s:12:\"`updated_at`\";s:9:\"allowNull\";b:1;s:6:\"dbType\";s:8:\"datetime\";s:4:\"type\";s:6:\"string\";s:12:\"defaultValue\";N;s:4:\"size\";N;s:9:\"precision\";N;s:5:\"scale\";N;s:12:\"isPrimaryKey\";b:0;s:12:\"isForeignKey\";b:0;s:13:\"autoIncrement\";b:0;s:7:\"comment\";s:0:\"\";s:14:\"\0CComponent\0_e\";N;s:14:\"\0CComponent\0_m\";N;}}s:14:\"\0CComponent\0_e\";N;s:14:\"\0CComponent\0_m\";N;}i:1;N;}');
/*!40000 ALTER TABLE `YiiCache` ENABLE KEYS */;
UNLOCK
TABLES;

--
-- Table structure for table `ah_proll_normal`
--

DROP TABLE IF EXISTS `ah_proll_normal`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `ah_proll_normal`
(
    `id`      int NOT NULL AUTO_INCREMENT,
    `title`   varchar(255) DEFAULT NULL,
    `ac_type` int          DEFAULT NULL,
    PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ah_proll_normal`
--

LOCK
TABLES `ah_proll_normal` WRITE;
/*!40000 ALTER TABLE `ah_proll_normal` DISABLE KEYS */;
INSERT INTO `ah_proll_normal`
VALUES (1, 'BASIC SALARY', 13),
       (2, 'SALARY ALLOWANCE', 13),
       (3, 'SALARY OTHERS', 13),
       (4, 'OVER TIME', 13),
       (5, 'BREAKFAST', 13),
       (6, 'HOLYDAY ALLOWANCE', 13),
       (7, 'NIGHT ALLOWANCE', 13),
       (8, 'ATTENDANCE BONUS', 13);
/*!40000 ALTER TABLE `ah_proll_normal` ENABLE KEYS */;
UNLOCK
TABLES;

--
-- Table structure for table `authitemchild`
--

DROP TABLE IF EXISTS `authitemchild`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `authitemchild`
(
    `parent` varchar(255) NOT NULL,
    `child`  varchar(255) NOT NULL,
    PRIMARY KEY (`parent`, `child`),
    KEY      `child` (`child`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `authitemchild`
--

LOCK
TABLES `authitemchild` WRITE;
/*!40000 ALTER TABLE `authitemchild` DISABLE KEYS */;
/*!40000 ALTER TABLE `authitemchild` ENABLE KEYS */;
UNLOCK
TABLES;

--
-- Table structure for table `balance_carried_from_prev_year`
--

DROP TABLE IF EXISTS `balance_carried_from_prev_year`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `balance_carried_from_prev_year`
(
    `id`           int NOT NULL AUTO_INCREMENT,
    `amount`       double   DEFAULT NULL,
    `start_date`   date     DEFAULT NULL,
    `end_date`     date     DEFAULT NULL,
    `created_by`   int      DEFAULT NULL,
    `created_time` datetime DEFAULT NULL,
    `updated_by`   int      DEFAULT NULL,
    `updated_time` datetime DEFAULT NULL,
    PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `balance_carried_from_prev_year`
--

LOCK
TABLES `balance_carried_from_prev_year` WRITE;
/*!40000 ALTER TABLE `balance_carried_from_prev_year` DISABLE KEYS */;
INSERT INTO `balance_carried_from_prev_year`
VALUES (1, 70761047, '2017-07-01', '2018-06-30', 1, '2020-04-06 19:47:29', 0, '0000-00-00 00:00:00'),
       (2, 124397212, '2018-07-01', '2019-06-30', 1, '2020-04-07 12:22:03', 1, '2020-04-07 16:36:47');
/*!40000 ALTER TABLE `balance_carried_from_prev_year` ENABLE KEYS */;
UNLOCK
TABLES;

--
-- Table structure for table `bom`
--

DROP TABLE IF EXISTS `bom`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `bom`
(
    `id`          int          NOT NULL AUTO_INCREMENT,
    `fg_model_id` int          NOT NULL,
    `bom_no`      varchar(255) NOT NULL,
    `date`        date         NOT NULL,
    `qty`         double       NOT NULL DEFAULT '1',
    `created_at`  datetime              DEFAULT CURRENT_TIMESTAMP,
    `created_by`  int                   DEFAULT NULL,
    `updated_at`  datetime              DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
    `updated_by`  int                   DEFAULT NULL,
    PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `bom`
--

LOCK
TABLES `bom` WRITE;
/*!40000 ALTER TABLE `bom` DISABLE KEYS */;
INSERT INTO `bom`
VALUES (1, 5, '62C51D5FC2B6E', '2022-07-06', 1, '2022-07-06 11:27:59', 1, '2022-07-19 14:07:35', 1),
       (2, 19, '62C51D9D60CE3', '2022-07-06', 1, '2022-07-06 11:29:01', 1, '2022-07-06 16:30:32', 1),
       (3, 14, '62D665FE7101F', '2022-07-19', 1, '2022-07-19 14:06:22', 1, NULL, NULL);
/*!40000 ALTER TABLE `bom` ENABLE KEYS */;
UNLOCK
TABLES;

--
-- Table structure for table `bom_details`
--

DROP TABLE IF EXISTS `bom_details`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `bom_details`
(
    `id`         int    NOT NULL AUTO_INCREMENT,
    `bom_id`     int    NOT NULL,
    `model_id`   int    NOT NULL,
    `unit_id`    int      DEFAULT NULL,
    `qty`        double NOT NULL,
    `created_by` int      DEFAULT NULL,
    `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `bom_details`
--

LOCK
TABLES `bom_details` WRITE;
/*!40000 ALTER TABLE `bom_details` DISABLE KEYS */;
INSERT INTO `bom_details`
VALUES (4, 2, 22, 10, 100, 1, '2022-07-06 11:29:01'),
       (5, 2, 20, 9, 250, 1, '2022-07-06 11:29:01'),
       (6, 2, 21, 1, 200, 1, '2022-07-06 11:29:01'),
       (7, 3, 22, 1, 5, 1, '2022-07-19 14:06:22'),
       (8, 3, 23, 1, 30, 1, '2022-07-19 14:06:22'),
       (9, 3, 20, 9, 5, 1, '2022-07-19 14:06:22'),
       (10, 3, 21, 1, 50, 1, '2022-07-19 14:06:22'),
       (11, 1, 22, 1, 1, 1, '2022-07-19 14:07:35'),
       (12, 1, 21, 1, 5, 1, '2022-07-19 14:07:35');
/*!40000 ALTER TABLE `bom_details` ENABLE KEYS */;
UNLOCK
TABLES;

--
-- Table structure for table `bonus_titles`
--

DROP TABLE IF EXISTS `bonus_titles`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `bonus_titles`
(
    `id`      int NOT NULL AUTO_INCREMENT,
    `title`   varchar(255) DEFAULT NULL,
    `details` text,
    PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `bonus_titles`
--

LOCK
TABLES `bonus_titles` WRITE;
/*!40000 ALTER TABLE `bonus_titles` DISABLE KEYS */;
INSERT INTO `bonus_titles`
VALUES (1, 'Ed-Ul-Fitar', 'Ed-Ul-Fitar'),
       (2, 'Ed-Ul-Azha', 'Ed-Ul-Azha');
/*!40000 ALTER TABLE `bonus_titles` ENABLE KEYS */;
UNLOCK
TABLES;

--
-- Table structure for table `branches`
--

DROP TABLE IF EXISTS `branches`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `branches`
(
    `id`    int NOT NULL AUTO_INCREMENT,
    `title` varchar(255) DEFAULT NULL,
    PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `branches`
--

LOCK
TABLES `branches` WRITE;
/*!40000 ALTER TABLE `branches` DISABLE KEYS */;
INSERT INTO `branches`
VALUES (1, 'MAIN BRANCH');
/*!40000 ALTER TABLE `branches` ENABLE KEYS */;
UNLOCK
TABLES;

--
-- Table structure for table `chart_of_ac`
--

DROP TABLE IF EXISTS `chart_of_ac`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `chart_of_ac`
(
    `id`               int NOT NULL AUTO_INCREMENT,
    `code`             int unsigned DEFAULT NULL,
    `title`            varchar(255) DEFAULT NULL,
    `root`             int          DEFAULT '0',
    `tdr`              double       DEFAULT NULL COMMENT ' Tax Depreciation Rate',
    `remarks`          varchar(255) DEFAULT NULL,
    `bank_or_cash`     int          DEFAULT NULL,
    `account_type`     int          DEFAULT '2',
    `opening_dep`      double       DEFAULT NULL,
    `transaction_type` int          DEFAULT NULL,
    `dep`              double       DEFAULT '0',
    `opening_acc_dep`  double       DEFAULT NULL,
    `dep_start_dt`     date         DEFAULT NULL,
    `create_by`        int          DEFAULT NULL,
    `create_time`      datetime     DEFAULT NULL,
    `update_by`        int          DEFAULT NULL,
    `update_time`      datetime     DEFAULT NULL,
    PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1560 DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `chart_of_ac`
--

LOCK
TABLES `chart_of_ac` WRITE;
/*!40000 ALTER TABLE `chart_of_ac` DISABLE KEYS */;
INSERT INTO `chart_of_ac`
VALUES (1, 1, 'ASSET', 0, 0, '', 0, 0, 0, 0, 0, 0, NULL, NULL, NULL, NULL, NULL),
       (2, 2, 'LIABILITY', 0, 0, '', 0, 0, 0, 0, 0, 0, NULL, NULL, NULL, NULL, NULL),
       (3, 3, 'INCOME & REVENUE', 0, 0, '', 0, 0, 0, 3, 0, 0, NULL, NULL, NULL, NULL, NULL),
       (4, 4, 'EXPENSE', 0, 0, '', 0, 0, 0, 0, 0, 0, NULL, NULL, NULL, NULL, NULL),
       (5, 5, 'EQUITY', 0, 0, '', 0, 0, 0, 0, 0, 0, NULL, NULL, NULL, NULL, NULL),
       (6, 6, 'NON-CURRENT ASSET', 1, 0, '', 0, 0, 0, 3, 0, 0, NULL, NULL, NULL, NULL, NULL),
       (7, 7, 'CURRENT ASSET', 1, 0, '', 0, 0, 0, 3, 0, 0, NULL, NULL, NULL, NULL, NULL),
       (8, 8, 'INVESTMENT', 7, 0, '', 0, 0, 0, 3, 0, 0, NULL, NULL, NULL, NULL, NULL),
       (9, 9, 'SHARE CAPITAL', 5, 0, '', 0, 0, 0, 3, 0, 0, NULL, NULL, NULL, NULL, NULL),
       (10, 10, 'CURRENT LIABILITY', 2, 0, '', 0, 0, 0, 3, 0, 0, NULL, NULL, NULL, NULL, NULL),
       (11, 11, 'NON-CURRENT LIABILITY', 2, 0, '', 0, 0, 0, 3, 0, 0, NULL, NULL, NULL, NULL, NULL),
       (14, 12, 'OPERATING INCOME', 3, 0, '', 0, 0, 0, 3, 0, 0, NULL, NULL, NULL, NULL, NULL),
       (15, 13, 'OPERATING EXPENSES', 4, 0, '', 0, 0, 0, 3, 0, 0, NULL, NULL, NULL, NULL, NULL),
       (16, 14, 'ADMINISTRATIVE EXPENSE', 4, 0, '', 0, 0, 0, 3, 0, 0, NULL, NULL, NULL, NULL, NULL),
       (19, 15, 'ACCOUNTS PAYABLE', 10, 0, '', 0, 0, 0, 3, 0, 0, NULL, NULL, NULL, NULL, NULL),
       (20, 16, 'ACCOUNTS RECEIVABLE', 7, 0, '', 0, 0, 0, 3, 0, 0, NULL, NULL, NULL, NULL, NULL),
       (156, 17, 'CASH IN HAND', 1559, 0, '', 0, 0, 0, 3, 0, 0, NULL, NULL, NULL, NULL, NULL),
       (157, 18, 'CASH IN BANK', 1559, 0, '', 0, 0, 0, 3, 0, 0, NULL, NULL, NULL, NULL, NULL),
       (251, 19, 'MARKETING , SELLING & DISTRIBUTION EXPENSES', 4, 0, '', 0, 0, 0, 3, 0, 0, NULL, NULL, NULL, NULL,
        NULL),
       (252, 20, 'FINANCIAL EXPNESE', 4, 0, '', 0, 0, 0, 3, 0, 0, NULL, NULL, NULL, NULL, NULL),
       (253, 21, 'DAMAGED & LOST OF GOODS', 4, 0, '', 0, 0, 0, 3, 0, 0, NULL, NULL, NULL, NULL, NULL),
       (266, 22, 'INVENTORY', 7, 0, '', 0, 0, 0, 3, 0, 0, NULL, NULL, NULL, NULL, NULL),
       (384, 23, 'LIABILITY FOR EXPENSE', 10, 0, '', 0, 0, 0, 3, 0, 0, NULL, NULL, NULL, NULL, NULL),
       (509, 24, 'DISCOUNT ON SALES (SO)', 4, 0, '', 0, 0, 0, 3, 0, 0, NULL, NULL, NULL, NULL, NULL),
       (577, 25, 'ACCOUNTS RECEIVABLE', 20, 0, '', 0, 0, 0, 3, 0, 0, NULL, NULL, NULL, NULL, NULL),
       (595, 26, 'ADVANCE FROM CUSTOMER', 10, 0, '', 0, 0, 0, 3, 0, 0, NULL, NULL, NULL, NULL, NULL),
       (754, 27, 'VAT RECEIVABLE (CUSTOMER)', 20, 0, '', 0, 0, 0, 3, 0, 0, NULL, NULL, NULL, NULL, NULL),
       (832, 28, 'SHORT TERM LOAN', 10, 0, '', 0, 0, 0, 3, 0, 0, NULL, NULL, NULL, NULL, NULL),
       (842, 30, 'NON-OPERATING INCOME', 3, 0, '', 0, 0, 0, 3, 0, 0, NULL, NULL, NULL, NULL, NULL),
       (843, 31, 'OPERATING INCOME', 3, 0, '', 0, 0, 0, 3, 0, 0, NULL, NULL, NULL, NULL, NULL),
       (923, 32, 'DISCOUNT RECEIVED FROM SUPPLIER', 842, 0, '', 0, 0, 0, 4, 0, 0, NULL, NULL, NULL, NULL, NULL),
       (924, 33, 'TDS RECEIVABLE (CUSTOMER)', 20, 0, '', 0, 0, 0, 3, 0, 0, NULL, NULL, NULL, NULL, NULL),
       (932, 34, 'BANK INTEREST RECEIVED', 842, 0, '', 0, 0, 0, 3, 0, 0, NULL, NULL, NULL, NULL, NULL),
       (954, 35, 'SALARY & ALLOWANCES (SDE)', 251, 0, '', 0, 0, 0, 3, 0, 0, NULL, NULL, NULL, NULL, NULL),
       (955, 36, 'FACTORY OVERHEAD EXPENSES', 15, 0, '', 0, 0, 0, 3, 0, 0, NULL, NULL, NULL, NULL, NULL),
       (1004, 39, 'CARRIAGE OUTWARD (SDE)', 251, 0, '', 0, 0, 0, 3, 0, 0, NULL, NULL, NULL, NULL, NULL),
       (1010, 40, 'SALES', 843, 0, '', 0, 0, 0, 3, 0, 0, NULL, NULL, NULL, NULL, NULL),
       (1043, 42, 'PROPERTY PLANT &EQUIPMENT', 6, 0, '', 0, 0, 0, 3, 0, 0, NULL, NULL, NULL, NULL, NULL),
       (1426, 43, 'COST OF SALES', 15, 0, '', 0, 0, 0, 3, 0, 0, NULL, NULL, NULL, NULL, NULL),
       (1428, 44, 'DISCOUNT ON SALES', 15, 0, '', 0, 0, 0, 3, 0, 0, NULL, NULL, NULL, NULL, NULL),
       (1434, 45, 'ADVANCE, DEPOSIT & PREOAYMENT', 7, 0, '', 0, 0, 0, 3, 0, 0, NULL, NULL, NULL, NULL, NULL),
       (1436, 46, 'VAT DEPOSIT', 1434, 0, '', 0, 0, 0, 3, 0, 0, NULL, NULL, NULL, NULL, NULL),
       (1442, 50, 'DEFERRED TAX EXPENSES', 11, 0, '', 0, 0, 0, 4, 0, 0, NULL, NULL, NULL, NULL, NULL),
       (1519, 54, 'ACCOUNTS RECEIVABLE (OTHERS)', 20, 0, '', 0, 0, 0, 3, 0, 0, NULL, NULL, NULL, NULL, NULL),
       (1528, 55, 'OTHERS PAYABLE', 10, 0, '', 0, 0, 0, 3, 0, 0, NULL, NULL, NULL, NULL, NULL),
       (1543, 57, 'ADVANCE TAX (AT)', 1436, 0, '', 0, 0, 0, 3, 0, 0, NULL, NULL, NULL, NULL, NULL),
       (1559, 65, 'CASH & BANK', 7, NULL, '', 0, 0, NULL, 3, 0, NULL, NULL, NULL, NULL, NULL, NULL);
/*!40000 ALTER TABLE `chart_of_ac` ENABLE KEYS */;
UNLOCK
TABLES;

--
-- Table structure for table `chart_of_ac_opening`
--

DROP TABLE IF EXISTS `chart_of_ac_opening`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `chart_of_ac_opening`
(
    `id`                  int    NOT NULL AUTO_INCREMENT,
    `ca_id`               int    NOT NULL,
    `opening_amount_date` date     DEFAULT NULL,
    `transaction_type`    int    NOT NULL,
    `opening_amount`      double NOT NULL,
    `opening_acc_dep`     double   DEFAULT NULL,
    `create_by`           int      DEFAULT NULL,
    `create_time`         datetime DEFAULT NULL,
    `update_by`           int      DEFAULT NULL,
    `update_time`         datetime DEFAULT NULL,
    PRIMARY KEY (`id`),
    UNIQUE KEY `ca_id` (`ca_id`),
    KEY                   `chart_of_ac_opening` (`ca_id`),
    KEY                   `ca_id_2` (`ca_id`),
    CONSTRAINT `chart_of_ac_opening` FOREIGN KEY (`ca_id`) REFERENCES `chart_of_ac` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `chart_of_ac_opening`
--

LOCK
TABLES `chart_of_ac_opening` WRITE;
/*!40000 ALTER TABLE `chart_of_ac_opening` DISABLE KEYS */;
INSERT INTO `chart_of_ac_opening`
VALUES (1, 157, '2021-09-08', 3, 100000, NULL, 1, '2021-09-04 15:15:46', NULL, NULL),
       (2, 156, '2021-09-01', 3, 150000, NULL, 1, '2021-09-04 15:16:37', NULL, NULL),
       (3, 9, '2021-09-08', 3, 250000, NULL, 1, '2021-09-04 15:18:31', NULL, NULL);
/*!40000 ALTER TABLE `chart_of_ac_opening` ENABLE KEYS */;
UNLOCK
TABLES;

--
-- Table structure for table `com_bank`
--

DROP TABLE IF EXISTS `com_bank`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `com_bank`
(
    `id`         int          NOT NULL AUTO_INCREMENT,
    `name`       varchar(255) NOT NULL,
    `status`     tinyint(1) NOT NULL DEFAULT '1',
    `created_by` int      DEFAULT NULL,
    `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
    `updated_by` int      DEFAULT NULL,
    `updated_at` datetime DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`),
    UNIQUE KEY `name` (`name`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `com_bank`
--

LOCK
TABLES `com_bank` WRITE;
/*!40000 ALTER TABLE `com_bank` DISABLE KEYS */;
INSERT INTO `com_bank`
VALUES (1, 'IBBL', 1, NULL, '2022-07-23 09:59:34', NULL, NULL),
       (2, 'IFIC', 1, NULL, '2022-07-23 10:38:39', NULL, NULL);
/*!40000 ALTER TABLE `com_bank` ENABLE KEYS */;
UNLOCK
TABLES;

--
-- Table structure for table `countries`
--

DROP TABLE IF EXISTS `countries`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `countries`
(
    `id`      int NOT NULL AUTO_INCREMENT,
    `iso2`    char(2)     DEFAULT NULL,
    `iso3`    char(3)     DEFAULT NULL,
    `country` varchar(62) DEFAULT NULL,
    PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=243 DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `countries`
--

LOCK
TABLES `countries` WRITE;
/*!40000 ALTER TABLE `countries` DISABLE KEYS */;
INSERT INTO `countries`
VALUES (1, 'AF', 'AFG', 'Afghanistan'),
       (2, 'AX', 'ALA', '?land Islands'),
       (3, 'AL', 'ALB', 'Albania'),
       (4, 'DZ', 'DZA', 'Algeria (El Djaza?r)'),
       (5, 'AS', 'ASM', 'American Samoa'),
       (6, 'AD', 'AND', 'Andorra'),
       (7, 'AO', 'AGO', 'Angola'),
       (8, 'AI', 'AIA', 'Anguilla'),
       (9, 'AQ', 'ATA', 'Antarctica'),
       (10, 'AG', 'ATG', 'Antigua and Barbuda'),
       (11, 'AR', 'ARG', 'Argentina'),
       (12, 'AM', 'ARM', 'Armenia'),
       (13, 'AW', 'ABW', 'Aruba'),
       (14, 'AU', 'AUS', 'Australia'),
       (15, 'AT', 'AUT', 'Austria'),
       (16, 'AZ', 'AZE', 'Azerbaijan'),
       (17, 'BS', 'BHS', 'Bahamas'),
       (18, 'BH', 'BHR', 'Bahrain'),
       (19, 'BD', 'BGD', 'Bangladesh'),
       (20, 'BB', 'BRB', 'Barbados'),
       (21, 'BY', 'BLR', 'Belarus'),
       (22, 'BE', 'BEL', 'Belgium'),
       (23, 'BZ', 'BLZ', 'Belize'),
       (24, 'BJ', 'BEN', 'Benin'),
       (25, 'BM', 'BMU', 'Bermuda'),
       (26, 'BT', 'BTN', 'Bhutan'),
       (27, 'BO', 'BOL', 'Bolivia'),
       (28, 'BA', 'BIH', 'Bosnia and Herzegovina'),
       (29, 'BW', 'BWA', 'Botswana'),
       (30, 'BV', 'BVT', 'Bouvet Island'),
       (31, 'BR', 'BRA', 'Brazil'),
       (32, 'IO', 'IOT', 'British Indian Ocean Territory'),
       (33, 'BN', 'BRN', 'Brunei Darussalam'),
       (34, 'BG', 'BGR', 'Bulgaria'),
       (35, 'BF', 'BFA', 'Burkina Faso'),
       (36, 'BI', 'BDI', 'Burundi'),
       (37, 'KH', 'KHM', 'Cambodia'),
       (38, 'CM', 'CMR', 'Cameroon'),
       (39, 'CA', 'CAN', 'Canada'),
       (40, 'CV', 'CPV', 'Cape Verde'),
       (41, 'KY', 'CYM', 'Cayman Islands'),
       (42, 'CF', 'CAF', 'Central African Republic'),
       (43, 'TD', 'TCD', 'Chad (T\\\'Chad)'),(44,'CL','CHL','Chile'),(45,'CN','CHN','China'),(46,'CX','CXR','Christmas Island'),(47,'CC','CCK','Cocos (Keeling) Islands'),(48,'CO','COL','Colombia'),(49,'KM','COM','Comoros'),(50,'CG','COG','Congo, Republic Of'),(51,'CD','COD','Congo, The Democratic Republic of the (formerly Zaire)'),(52,'CK','COK','Cook Islands'),(53,'CR','CRI','Costa Rica'),(54,'CI','CIV','C?te D\\\'Ivoire (Ivory Coast)'),(55,'HR','HRV','Croatia (hrvatska)'),(56,'CU','CUB','Cuba'),(57,'CY','CYP','Cyprus'),(58,'CZ','CZE','Czech Republic'),(59,'DK','DNK','Denmark'),(60,'DJ','DJI','Djibouti'),(61,'DM','DMA','Dominica'),(62,'DO','DOM','Dominican Republic'),(63,'EC','ECU','Ecuador'),(64,'EG','EGY','Egypt'),(65,'SV','SLV','El Salvador'),(66,'GQ','GNQ','Equatorial Guinea'),(67,'ER','ERI','Eritrea'),(68,'EE','EST','Estonia'),(69,'ET','ETH','Ethiopia'),(70,'FO','FRO','Faeroe Islands'),(71,'FK','FLK','Falkland Islands (Malvinas)'),(72,'FJ','FJI','Fiji'),(73,'FI','FIN','Finland'),(74,'FR','FRA','France'),(75,'GF','GUF','French Guiana'),(76,'PF','PYF','French Polynesia'),(77,'TF','ATF','French Southern Territories'),(78,'GA','GAB','Gabon'),(79,'GM','GMB','Gambia, The'),(80,'GE','GEO','Georgia'),(81,'DE','DEU','Germany (Deutschland)'),(82,'GH','GHA','Ghana'),(83,'GI','GIB','Gibraltar'),(84,'GB','GBR','Great Britain'),(85,'GR','GRC','Greece'),(86,'GL','GRL','Greenland'),(87,'GD','GRD','Grenada'),(88,'GP','GLP','Guadeloupe'),(89,'GU','GUM','Guam'),(90,'GT','GTM','Guatemala'),(91,'GN','GIN','Guinea'),(92,'GW','GNB','Guinea-bissau'),(93,'GY','GUY','Guyana'),(94,'HT','HTI','Haiti'),(95,'HM','HMD','Heard Island and Mcdonald Islands'),(96,'HN','HND','Honduras'),(97,'HK','HKG','Hong Kong (Special Administrative Region of China)'),(98,'HU','HUN','Hungary'),(99,'IS','ISL','Iceland'),(100,'IN','IND','India'),(101,'ID','IDN','Indonesia'),(102,'IR','IRN','Iran (Islamic Republic of Iran)'),(103,'IQ','IRQ','Iraq'),(104,'IE','IRL','Ireland'),(105,'IL','ISR','Israel'),(106,'IT','ITA','Italy'),(107,'JM','JAM','Jamaica'),(108,'JP','JPN','Japan'),(109,'JO','JOR','Jordan (Hashemite Kingdom of Jordan)'),(110,'KZ','KAZ','Kazakhstan'),(111,'KE','KEN','Kenya'),(112,'KI','KIR','Kiribati'),(113,'KP','PRK','Korea (Democratic Peoples Republic pf [North] Korea)'),(114,'KR','KOR','Korea (Republic of [South] Korea)'),(115,'KW','KWT','Kuwait'),(116,'KG','KGZ','Kyrgyzstan'),(117,'LA','LAO','Lao People\\\'s Democratic Republic'),(118,'LV','LVA','Latvia'),(119,'LB','LBN','Lebanon'),(120,'LS','LSO','Lesotho'),(121,'LR','LBR','Liberia'),(122,'LY','LBY','Libya (Libyan Arab Jamahirya)'),(123,'LI','LIE','Liechtenstein (F?rstentum Liechtenstein)'),(124,'LT','LTU','Lithuania'),(125,'LU','LUX','Luxembourg'),(126,'MO','MAC','Macao (Special Administrative Region of China)'),(127,'MK','MKD','Macedonia (Former Yugoslav Republic of Macedonia)'),(128,'MG','MDG','Madagascar'),(129,'MW','MWI','Malawi'),(130,'MY','MYS','Malaysia'),(131,'MV','MDV','Maldives'),(132,'ML','MLI','Mali'),(133,'MT','MLT','Malta'),(134,'MH','MHL','Marshall Islands'),(135,'MQ','MTQ','Martinique'),(136,'MR','MRT','Mauritania'),(137,'MU','MUS','Mauritius'),(138,'YT','MYT','Mayotte'),(139,'MX','MEX','Mexico'),(140,'FM','FSM','Micronesia (Federated States of Micronesia)'),(141,'MD','MDA','Moldova'),(142,'MC','MCO','Monaco'),(143,'MN','MNG','Mongolia'),(144,'MS','MSR','Montserrat'),(145,'MA','MAR','Morocco'),(146,'MZ','MOZ','Mozambique (Mo?ambique)'),(147,'MM','MMR','Myanmar (formerly Burma)'),(148,'NA','NAM','Namibia'),(149,'NR','NRU','Nauru'),(150,'NP','NPL','Nepal'),(151,'NL','NLD','Netherlands'),(152,'AN','ANT','Netherlands Antilles'),(153,'NC','NCL','New Caledonia'),(154,'NZ','NZL','New Zealand'),(155,'NI','NIC','Nicaragua'),(156,'NE','NER','Niger'),(157,'NG','NGA','Nigeria'),(158,'NU','NIU','Niue'),(159,'NF','NFK','Norfolk Island'),(160,'MP','MNP','Northern Mariana Islands'),(161,'NO','NOR','Norway'),(162,'OM','OMN','Oman'),(163,'PK','PAK','Pakistan'),(164,'PW','PLW','Palau'),(165,'PS','PSE','Palestinian Territories'),(166,'PA','PAN','Panama'),(167,'PG','PNG','Papua New Guinea'),(168,'PY','PRY','Paraguay'),(169,'PE','PER','Peru'),(170,'PH','PHL','Philippines'),(171,'PN','PCN','Pitcairn'),(172,'PL','POL','Poland'),(173,'PT','PRT','Portugal'),(174,'PR','PRI','Puerto Rico'),(175,'QA','QAT','Qatar'),(176,'RE','REU','R?
union
'),(177,'
RO
','
ROU
','
Romania
'),(178,'
RU
','
RUS
','
Russian
Federation
'),(179,'
RW
','
RWA
','
Rwanda
'),(180,'
SH
','
SHN
','
Saint
Helena
'),(181,'
KN
','
KNA
','
Saint
Kitts
and
Nevis
'),(182,'
LC
','
LCA
','
Saint
Lucia
'),(183,'
PM
','
SPM
','
Saint
Pierre
and
Miquelon
'),(184,'
VC
','
VCT
','
Saint
Vincent
and
the
Grenadines
'),(185,'
WS
','
WSM
','
Samoa
(
formerly
Western
Samoa
)
'),(186,'
SM
','
SMR
','
San
Marino
(
Republic
of
)
'),(187,'
ST
','
STP
','
Sao
Tome
and
Principe
'),(188,'
SA
','
SAU
','
Saudi
Arabia
(
Kingdom
of
Saudi
Arabia
)
'),(189,'
SN
','
SEN
','
Senegal
'),(190,'
CS
','
SCG
','
Serbia
and
Montenegro
(
formerly
Yugoslavia
)
'),(191,'
SC
','
SYC
','
Seychelles
'),(192,'
SL
','
SLE
','
Sierra
Leone
'),(193,'
SG
','
SGP
','
Singapore
'),(194,'
SK
','
SVK
','
Slovakia
(
Slovak
Republic
)
'),(195,'
SI
','
SVN
','
Slovenia
'),(196,'
SB
','
SLB
','
Solomon
Islands
'),(197,'
SO
','
SOM
','
Somalia
'),(198,'
ZA
','
ZAF
','
South
Africa
(
zuid
Afrika
)
'),(199,'
GS
','
SGS
','
South
Georgia
and
the
South
Sandwich
Islands
'),(200,'
ES
','
ESP
','
Spain
(
espa
?
a
)
'),(201,'
LK
','
LKA
','
Sri
Lanka
'),(202,'
SD
','
SDN
','
Sudan
'),(203,'
SR
','
SUR
','
Suriname
'),(204,'
SJ
','
SJM
','
Svalbard
and
Jan
Mayen
'),(205,'
SZ
','
SWZ
','
Swaziland
'),(206,'
SE
','
SWE
','
Sweden
'),(207,'
CH
','
CHE
','
Switzerland
(
Confederation
of
Helvetia
)
'),(208,'
SY
','
SYR
','
Syrian
Arab
Republic
'),(209,'
TW
','
TWN
','
Taiwan
(
\\\"Chinese Taipei\\\" for IOC)'),(210,'TJ','TJK','Tajikistan'),(211,'TZ','TZA','Tanzania'),(212,'TH','THA','Thailand'),(213,'TL','TLS','Timor-Leste (formerly East Timor)'),(214,'TG','TGO','Togo'),(215,'TK','TKL','Tokelau'),(216,'TO','TON','Tonga'),(217,'TT','TTO','Trinidad and Tobago'),(218,'TN','TUN','Tunisia'),(219,'TR','TUR','Turkey'),(220,'TM','TKM','Turkmenistan'),(221,'TC','TCA','Turks and Caicos Islands'),(222,'TV','TUV','Tuvalu'),(223,'UG','UGA','Uganda'),(224,'UA','UKR','Ukraine'),(225,'AE','ARE','United Arab Emirates'),(226,'GB','GBR','United Kingdom (Great Britain)'),(227,'US','USA','United States'),(228,'UM','UMI','United States Minor Outlying Islands'),(229,'UY','URY','Uruguay'),(230,'UZ','UZB','Uzbekistan'),(231,'VU','VUT','Vanuatu'),(232,'VA','VAT','Vatican City (Holy See)'),(233,'VE','VEN','Venezuela'),(234,'VN','VNM','Viet Nam'),(235,'VG','VGB','Virgin Islands, British'),(236,'VI','VIR','Virgin Islands, U.S.'),(237,'WF','WLF','Wallis and Futuna'),(238,'EH','ESH','Western Sahara (formerly Spanish Sahara)'),(239,'YE','YEM','Yemen (Arab Republic)'),(240,'ZM','ZMB','Zambia'),(241,'ZW','ZWE','Zimbabwe'),(242,'','','Germany');
/*!40000 ALTER TABLE `countries` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `crm_bank`
--

DROP TABLE IF EXISTS `crm_bank`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `crm_bank` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `created_by` int DEFAULT NULL,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `updated_by` int DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `crm_bank`
--

LOCK TABLES `crm_bank` WRITE;
/*!40000 ALTER TABLE `crm_bank` DISABLE KEYS */;
INSERT INTO `crm_bank` VALUES (1,'DBBL',1,NULL,'2022-07-19 12:22:21',NULL,NULL),(2,'SIBL',1,NULL,'2022-07-19 12:24:38',NULL,NULL),(3,'UCBL',1,NULL,'2022-07-19 12:25:20',NULL,NULL),(4,'IBBL',1,NULL,'2022-07-19 12:40:57',NULL,NULL);
/*!40000 ALTER TABLE `crm_bank` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `customer_contact_persons`
--

DROP TABLE IF EXISTS `customer_contact_persons`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `customer_contact_persons` (
  `id` int NOT NULL AUTO_INCREMENT,
  `company_id` int DEFAULT NULL,
  `contact_person_name` varchar(255) DEFAULT NULL,
  `designation_id` int DEFAULT NULL,
  `contact_number1` varchar(20) DEFAULT NULL,
  `contact_number2` varchar(20) DEFAULT NULL,
  `contact_number3` varchar(20) DEFAULT NULL,
  `email` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_contact_persons2` (`company_id`),
  KEY `FK_contact_persons_designation` (`designation_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `customer_contact_persons`
--

LOCK TABLES `customer_contact_persons` WRITE;
/*!40000 ALTER TABLE `customer_contact_persons` DISABLE KEYS */;
/*!40000 ALTER TABLE `customer_contact_persons` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `customers`
--

DROP TABLE IF EXISTS `customers`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `customers` (
  `id` int NOT NULL AUTO_INCREMENT,
  `company_name` varchar(255) DEFAULT NULL,
  `customer_code` varchar(255) NOT NULL,
  `company_address` text,
  `company_contact_no` varchar(20) DEFAULT NULL,
  `company_fax` varchar(20) DEFAULT NULL,
  `company_email` varchar(50) DEFAULT NULL,
  `company_web` varchar(50) DEFAULT NULL,
  `opening_amount` double DEFAULT '0',
  `max_sl_no` varchar(255) DEFAULT NULL,
  `trn_no` varchar(255) DEFAULT NULL,
  `city` varchar(255) DEFAULT NULL,
  `state` varchar(255) DEFAULT NULL,
  `zip` varchar(255) DEFAULT NULL,
  `owner_mobile_no` varchar(255) DEFAULT NULL,
  `owner_person` varchar(255) DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `created_by` int DEFAULT NULL,
  `created_datetime` datetime DEFAULT CURRENT_TIMESTAMP,
  `updated_by` int DEFAULT NULL,
  `updated_datetime` datetime DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `customers`
--

LOCK TABLES `customers` WRITE;
/*!40000 ALTER TABLE `customers` DISABLE KEYS */;
INSERT INTO `customers` VALUES (1,'AL NAJAH FURNISHINGS L.L.C','CUS00001',NULL,NULL,NULL,'','',0,'1','100294888100003','Abh Dhabi, UAE','Salam Street, ','PO Box : 26351,','+971 24447654','',1,1,'2022-07-06 09:27:27',NULL,NULL),(2,'CLICK','CUS00002',NULL,NULL,NULL,'','',0,'2','','','','','','',1,1,'2022-07-16 11:09:49',NULL,NULL);
/*!40000 ALTER TABLE `customers` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `departments`
--

DROP TABLE IF EXISTS `departments`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `departments` (
  `id` int NOT NULL AUTO_INCREMENT,
  `department_name` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `departments`
--

LOCK TABLES `departments` WRITE;
/*!40000 ALTER TABLE `departments` DISABLE KEYS */;
INSERT INTO `departments` VALUES (1,'HR ');
/*!40000 ALTER TABLE `departments` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `departments_sub`
--

DROP TABLE IF EXISTS `departments_sub`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `departments_sub` (
  `id` int NOT NULL AUTO_INCREMENT,
  `department_id` int DEFAULT NULL,
  `title` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_sections_sub` (`department_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `departments_sub`
--

LOCK TABLES `departments_sub` WRITE;
/*!40000 ALTER TABLE `departments_sub` DISABLE KEYS */;
INSERT INTO `departments_sub` VALUES (1,1,'ADMIN');
/*!40000 ALTER TABLE `departments_sub` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `designations`
--

DROP TABLE IF EXISTS `designations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `designations` (
  `id` int NOT NULL AUTO_INCREMENT,
  `designation` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `designations`
--

LOCK TABLES `designations` WRITE;
/*!40000 ALTER TABLE `designations` DISABLE KEYS */;
/*!40000 ALTER TABLE `designations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `employees`
--

DROP TABLE IF EXISTS `employees`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `employees` (
  `id` int NOT NULL AUTO_INCREMENT,
  `full_name` varchar(255) DEFAULT NULL,
  `designation_id` bigint DEFAULT NULL,
  `department_id` bigint DEFAULT NULL,
  `id_no` varchar(255) DEFAULT NULL,
  `contact_no` varchar(20) DEFAULT NULL,
  `email` varchar(50) DEFAULT NULL,
  `address` text,
  `is_active` int DEFAULT NULL,
  `permanent_address` text,
  `gender` int DEFAULT NULL,
  `marital_status` int DEFAULT NULL,
  `blood_group` int DEFAULT NULL,
  `branch_id` int DEFAULT NULL,
  `employee_type` int DEFAULT NULL,
  `national_id_no` varchar(255) DEFAULT NULL,
  `contact_no_office` varchar(255) DEFAULT NULL,
  `contact_no_home` varchar(255) DEFAULT NULL,
  `contact_end` date DEFAULT NULL,
  `photo` varchar(255) DEFAULT NULL,
  `files` varchar(255) DEFAULT NULL,
  `emp_id_no` varchar(255) DEFAULT NULL,
  `tin` varchar(100) DEFAULT NULL,
  `flag` int DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `employees`
--

LOCK TABLES `employees` WRITE;
/*!40000 ALTER TABLE `employees` DISABLE KEYS */;
INSERT INTO `employees` VALUES (2,'Alamin',88,40,'170829000101','','jessc@acmeglobal.com','',1,'',0,0,0,170530507,0,'','','','0000-00-00','','','01404','',1),(3,'Sohel',88,40,'170829000102','','','',1,'',0,0,0,170507502,0,'','','','0000-00-00','','','1781','',0),(4,'Admin',88,40,'170829000035','','bogsc@acmeglobal.com','',1,'',0,0,0,170530505,0,'','','','0000-00-00','','','03P41','',0),(5,'Hira Ahmed',0,0,'','','','',1,'',57,59,62,0,0,'','','','0000-00-00','','','201810202009','',0);
/*!40000 ALTER TABLE `employees` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `expense`
--

DROP TABLE IF EXISTS `expense`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `expense` (
  `id` int NOT NULL AUTO_INCREMENT,
  `max_sl_no` int NOT NULL,
  `entry_no` varchar(255) NOT NULL,
  `date` date NOT NULL,
  `amount` double NOT NULL,
  `remarks` text,
  `is_approved` tinyint DEFAULT '0' COMMENT '0=>Pending, 1=>Approved, 2=>Deny',
  `created_by` int DEFAULT NULL,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `updated_by` int DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `expense`
--

LOCK TABLES `expense` WRITE;
/*!40000 ALTER TABLE `expense` DISABLE KEYS */;
INSERT INTO `expense` VALUES (1,1,'22-07-001','2022-07-23',400,'',0,1,'2022-07-23 12:30:04',NULL,NULL),(2,2,'22-07-002','2022-07-23',400,'',0,1,'2022-07-23 12:30:37',NULL,NULL),(3,3,'22-07-003','2022-07-23',400,'',0,1,'2022-07-23 12:30:49',NULL,NULL),(4,4,'2207004','2022-07-23',130,'',0,1,'2022-07-23 12:36:40',NULL,NULL);
/*!40000 ALTER TABLE `expense` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `expense_details`
--

DROP TABLE IF EXISTS `expense_details`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `expense_details` (
  `id` int NOT NULL AUTO_INCREMENT,
  `expense_id` int NOT NULL,
  `expense_head_id` int NOT NULL,
  `amount` double NOT NULL,
  `remarks` text,
  `created_by` int DEFAULT NULL,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `updated_by` int DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `expense_details`
--

LOCK TABLES `expense_details` WRITE;
/*!40000 ALTER TABLE `expense_details` DISABLE KEYS */;
INSERT INTO `expense_details` VALUES (1,1,4,100,'',1,'2022-07-23 12:30:04',NULL,NULL),(2,1,2,300,'',1,'2022-07-23 12:30:04',NULL,NULL),(3,2,4,100,'',1,'2022-07-23 12:30:37',NULL,NULL),(4,2,2,300,'',1,'2022-07-23 12:30:37',NULL,NULL),(5,3,4,100,'',1,'2022-07-23 12:30:49',NULL,NULL),(6,3,2,300,'',1,'2022-07-23 12:30:49',NULL,NULL),(7,4,4,30,'',1,'2022-07-23 12:36:40',NULL,NULL),(8,4,3,100,'',1,'2022-07-23 12:36:40',NULL,NULL);
/*!40000 ALTER TABLE `expense_details` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `expense_head`
--

DROP TABLE IF EXISTS `expense_head`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `expense_head` (
  `id` int NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `created_by` int DEFAULT NULL,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `updated_by` int DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `title` (`title`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `expense_head`
--

LOCK TABLES `expense_head` WRITE;
/*!40000 ALTER TABLE `expense_head` DISABLE KEYS */;
INSERT INTO `expense_head` VALUES (1,'Entertainment',1,NULL,'2022-07-22 22:01:20',NULL,NULL),(2,'Mobile Bill',1,NULL,'2022-07-22 22:05:05',NULL,NULL),(3,'TA',1,NULL,'2022-07-22 22:05:12',1,'2022-07-22 22:23:08'),(4,'DA',1,NULL,'2022-07-22 22:05:15',NULL,NULL);
/*!40000 ALTER TABLE `expense_head` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `inventory`
--

DROP TABLE IF EXISTS `inventory`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `inventory` (
  `id` int NOT NULL AUTO_INCREMENT,
  `sl_no` int DEFAULT NULL COMMENT '\r\n',
  `date` date DEFAULT NULL,
  `challan_no` varchar(255) DEFAULT NULL,
  `store_id` int DEFAULT NULL,
  `location_id` int DEFAULT NULL,
  `model_id` int DEFAULT NULL,
  `stock_in` double NOT NULL DEFAULT '0',
  `stock_out` double NOT NULL DEFAULT '0',
  `sell_price` double NOT NULL DEFAULT '0',
  `row_total` double NOT NULL DEFAULT '0',
  `purchase_price` double DEFAULT '0',
  `stock_status` int DEFAULT '0' COMMENT '0.MANUAL STOCK ENTRY, 1.PURCHASE RECEIVE, 2.PURCHASE RECEIVE RETURN, 3.SALES DELIVERY, 4.SALES DELIVERY RETURN',
  `source_id` int NOT NULL DEFAULT '0',
  `stock_of` int NOT NULL DEFAULT '1' COMMENT '1=> Depo, 2=>Factory, 3=>Head Office',
  `remarks` varchar(255) DEFAULT NULL,
  `create_time` datetime DEFAULT NULL,
  `create_by` int DEFAULT NULL,
  `update_time` datetime DEFAULT NULL,
  `update_by` int DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `model_fg_fk` (`model_id`)
) ENGINE=InnoDB AUTO_INCREMENT=41 DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `inventory`
--

LOCK TABLES `inventory` WRITE;
/*!40000 ALTER TABLE `inventory` DISABLE KEYS */;
INSERT INTO `inventory` VALUES (1,1,'2022-07-14','GRN-000001',1,1,14,1000,0,5000,5000000,0,0,0,1,NULL,'2022-07-14 12:00:14',1,NULL,NULL),(2,1,'2022-07-14','GRN-000001',1,1,5,3000,0,0,0,0,0,0,1,NULL,'2022-07-14 12:00:14',1,NULL,NULL),(3,1,'2022-07-14','GRN-000001',1,1,8,5000,0,0,0,0,0,0,1,NULL,'2022-07-14 12:00:14',1,NULL,NULL),(4,1,'2022-07-14','GRN-000001',1,1,16,2000,0,0,0,0,0,0,1,NULL,'2022-07-14 12:00:14',1,NULL,NULL),(5,1,'2022-07-14','GRN-000001',1,1,13,5000,0,0,0,0,0,0,1,NULL,'2022-07-14 12:00:14',1,NULL,NULL),(6,2,'2022-07-14','GI-000002',NULL,NULL,14,0,1,5000,5000,0,0,0,1,NULL,'2022-07-14 14:57:48',1,NULL,NULL),(7,3,'2022-07-15','RCV-000003',1,NULL,20,10000,0,25,250000,25,1,2,1,'SFT','2022-07-15 20:07:25',1,NULL,NULL),(8,3,'2022-07-15','RCV-000003',1,NULL,21,100000,0,0.75,75000,0.75,1,3,1,'Pcs','2022-07-15 20:07:25',1,NULL,NULL),(9,4,'2022-07-15','RCV-000004',1,NULL,20,10000,0,25,250000,25,1,4,1,'SFT','2022-07-15 20:10:36',1,NULL,NULL),(10,4,'2022-07-15','RCV-000004',1,NULL,21,100000,0,0.75,75000,0.75,1,5,1,'Pcs','2022-07-15 20:10:36',1,NULL,NULL),(11,5,'2022-07-15','RCV-000005',1,NULL,20,10000,0,25,250000,25,1,6,1,'SFT','2022-07-15 20:11:59',1,NULL,NULL),(12,5,'2022-07-15','RCV-000005',1,NULL,21,100000,0,0.75,75000,0.75,1,7,1,'Pcs','2022-07-15 20:11:59',1,NULL,NULL),(13,6,'2022-07-15','RCV-000006',1,NULL,20,10000,0,25,250000,25,1,8,1,'SFT','2022-07-15 20:12:12',1,NULL,NULL),(14,6,'2022-07-15','RCV-000006',1,NULL,21,100000,0,0.75,75000,0.75,1,9,1,'Pcs','2022-07-15 20:12:12',1,NULL,NULL),(15,7,'2022-07-15','RCV-000007',1,NULL,20,10000,0,25,250000,25,1,10,1,'SFT','2022-07-15 20:12:40',1,NULL,NULL),(16,7,'2022-07-15','RCV-000007',1,NULL,21,100000,0,0.75,75000,0.75,1,11,1,'Pcs','2022-07-15 20:12:40',1,NULL,NULL),(17,8,'2022-07-16','GRN-000008',1,1,15,5000,0,0,0,0,0,0,1,NULL,'2022-07-16 15:47:35',1,NULL,NULL),(18,9,'2022-07-16','CHALLAN-000004',NULL,NULL,14,0,1,500,500,0,500,3,1,NULL,'2022-07-16 23:47:10',1,NULL,NULL),(19,10,'2022-07-16','CHALLAN-000001',NULL,NULL,14,0,1,500,500,0,500,1,1,NULL,'2022-07-16 23:53:32',1,NULL,NULL),(20,11,'2022-07-16','CHALLAN-000002',NULL,NULL,14,0,1,500,500,0,500,2,1,NULL,'2022-07-16 23:53:55',1,NULL,NULL),(21,12,'2022-07-16','CHALLAN-000003',NULL,NULL,14,0,1,500,500,0,500,3,1,NULL,'2022-07-16 23:54:41',1,NULL,NULL),(22,13,'2022-07-16','CHALLAN-000004',NULL,NULL,14,0,1,500,500,0,500,4,1,NULL,'2022-07-17 09:10:43',1,NULL,NULL),(23,14,'2022-07-16','CHALLAN-000001',NULL,NULL,14,0,1,500,500,0,500,1,1,NULL,'2022-07-17 09:12:21',1,NULL,NULL),(24,15,'2022-07-16','CHALLAN-000001',NULL,NULL,14,0,1,500,500,0,500,1,1,NULL,'2022-07-17 09:24:05',1,NULL,NULL),(25,16,'2022-07-16','CHALLAN-000001',NULL,NULL,14,0,1,500,500,0,500,1,1,NULL,'2022-07-17 09:27:01',1,NULL,NULL),(26,17,'2022-07-16','CHALLAN-000002',NULL,NULL,14,0,1,500,500,0,500,2,1,NULL,'2022-07-17 09:28:14',1,NULL,NULL),(27,18,'2022-07-16','CHALLAN-000003',NULL,NULL,14,0,1,500,500,0,500,3,1,NULL,'2022-07-17 09:29:11',1,NULL,NULL),(28,19,'2022-07-17','CHALLAN-000001',1,1,14,0,1,500,500,0,500,1,1,NULL,'2022-07-17 09:30:56',1,NULL,NULL),(29,20,'2022-07-17','CHALLAN-000002',1,1,14,0,1,500,500,0,500,2,1,NULL,'2022-07-17 09:34:25',1,NULL,NULL),(30,21,'2022-07-17','CHALLAN-000003',1,1,14,0,1,500,500,0,500,3,1,NULL,'2022-07-17 09:35:58',1,NULL,NULL),(31,22,'2022-07-17','CHALLAN-000004',1,1,14,0,1,500,500,0,500,4,1,NULL,'2022-07-17 09:37:39',1,NULL,NULL),(32,23,'2022-07-17','CHALLAN-000005',1,1,14,0,1,500,500,0,500,5,1,NULL,'2022-07-17 09:38:57',1,NULL,NULL),(33,24,'2022-07-17','CHALLAN-000006',1,1,15,0,10,500,5000,0,5000,6,1,NULL,'2022-07-17 09:39:20',1,NULL,NULL),(34,25,'2022-07-20','CHALLAN-000007',NULL,NULL,20,10,0,10,100,10,1,12,1,NULL,'2022-07-20 21:27:59',1,NULL,NULL),(35,26,'2022-07-20','CHALLAN-000007',NULL,NULL,20,1,0,11,11,11,1,13,1,NULL,'2022-07-20 21:29:54',1,NULL,NULL),(36,27,'2022-07-20','CHALLAN-000007',NULL,NULL,22,1,0,2,2,2,1,14,1,NULL,'2022-07-20 22:46:29',1,NULL,NULL),(37,28,'2022-07-20','CHALLAN-000007',NULL,NULL,22,1,0,1,1,1,1,1,1,NULL,'2022-07-20 23:00:47',1,NULL,NULL),(38,29,'2022-07-20','CHALLAN-000007',NULL,NULL,22,1,0,1,1,1,1,2,1,NULL,'2022-07-20 23:07:54',1,NULL,NULL),(39,30,'2022-07-20','CHALLAN-000007',NULL,NULL,22,1,0,1,1,1,1,3,1,NULL,'2022-07-20 23:08:08',1,NULL,NULL),(40,30,'2022-07-20','CHALLAN-000007',NULL,NULL,20,1,0,2,2,2,1,4,1,NULL,'2022-07-20 23:08:08',1,NULL,NULL);
/*!40000 ALTER TABLE `inventory` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `invoice`
--

DROP TABLE IF EXISTS `invoice`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `invoice` (
  `id` int NOT NULL AUTO_INCREMENT,
  `date` date NOT NULL,
  `order_id` int NOT NULL,
  `customer_id` int NOT NULL,
  `max_sl_no` int NOT NULL,
  `invoice_no` varchar(255) NOT NULL,
  `vat_percentage` double NOT NULL DEFAULT '0',
  `vat_amount` double NOT NULL DEFAULT '0',
  `discount_percentage` double NOT NULL DEFAULT '0',
  `discount_amount` double NOT NULL DEFAULT '0',
  `total_amount` double NOT NULL COMMENT 'total amount without vat and discount	',
  `grand_total` double NOT NULL,
  `remarks` text,
  `is_paid` tinyint(1) NOT NULL DEFAULT '0',
  `created_by` int DEFAULT NULL,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `updated_by` int DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `invoice`
--

LOCK TABLES `invoice` WRITE;
/*!40000 ALTER TABLE `invoice` DISABLE KEYS */;
INSERT INTO `invoice` VALUES (1,'2022-07-18',5,1,1,'INV-22-07-00001',0,0,0,0,1000,1000,NULL,0,NULL,'2022-07-18 17:11:39',1,'2022-07-19 14:52:39'),(2,'2022-07-18',5,1,2,'INV-22-07-00002',0,0,0,0,1000,1000,NULL,0,NULL,'2022-07-18 17:12:15',1,'2022-07-19 14:52:41'),(3,'2022-07-18',5,1,3,'INV-22-07-00003',0,0,0,0,500,500,NULL,0,NULL,'2022-07-18 17:15:47',1,'2022-07-19 14:52:36'),(4,'2022-07-18',5,1,4,'INV-22-07-00004',5,0,0,0,500,500,NULL,0,NULL,'2022-07-18 17:22:15',NULL,NULL),(5,'2022-07-18',5,1,5,'INV-22-07-00005',5,50,0,0,1000,1050,NULL,0,NULL,'2022-07-18 17:30:07',NULL,NULL);
/*!40000 ALTER TABLE `invoice` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `invoice_details`
--

DROP TABLE IF EXISTS `invoice_details`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `invoice_details` (
  `id` int NOT NULL AUTO_INCREMENT,
  `invoice_id` int NOT NULL,
  `model_id` int NOT NULL,
  `unit_price` double NOT NULL DEFAULT '0',
  `qty` double NOT NULL,
  `row_total` double NOT NULL DEFAULT '0',
  `color` text,
  `note` text,
  `created_by` int DEFAULT NULL,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `updated_by` int DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `invoice_details`
--

LOCK TABLES `invoice_details` WRITE;
/*!40000 ALTER TABLE `invoice_details` DISABLE KEYS */;
INSERT INTO `invoice_details` VALUES (1,1,14,500,1,500,'ABC','TEST NOTE',NULL,'2022-07-18 17:11:39',NULL,NULL),(2,1,15,500,1,500,'5','TEST NOTE',NULL,'2022-07-18 17:11:39',NULL,NULL),(3,2,14,500,1,500,'ABC','TEST NOTE',NULL,'2022-07-18 17:12:15',NULL,NULL),(4,2,15,500,1,500,'5','TEST NOTE',NULL,'2022-07-18 17:12:15',NULL,NULL),(5,3,15,500,1,500,'5','TEST NOTE',NULL,'2022-07-18 17:15:47',NULL,NULL),(6,4,15,500,1,500,'5','TEST NOTE',NULL,'2022-07-18 17:22:15',NULL,NULL),(7,5,14,500,1,500,'ABC','TEST NOTE',NULL,'2022-07-18 17:30:07',NULL,NULL),(8,5,15,500,1,500,'5','TEST NOTE',NULL,'2022-07-18 17:30:07',NULL,NULL);
/*!40000 ALTER TABLE `invoice_details` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `journal_entry`
--

DROP TABLE IF EXISTS `journal_entry`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `journal_entry` (
  `id` bigint NOT NULL AUTO_INCREMENT,
  `entry_no` int(5) unsigned zerofill DEFAULT NULL,
  `ca_id` int DEFAULT NULL,
  `entry_date` date DEFAULT NULL,
  `voucher_type` int DEFAULT NULL,
  `amount` double DEFAULT NULL,
  `narration` text,
  `overall_narration` text,
  `cash_bank` int DEFAULT NULL,
  `transaction_type` int DEFAULT NULL,
  `main_ca` int DEFAULT NULL,
  `is_canceled` tinyint(1) NOT NULL DEFAULT '0' COMMENT '1 = Canceled',
  `is_deletable` tinyint(1) NOT NULL DEFAULT '1' COMMENT '1=> deletable',
  `create_by` int DEFAULT NULL,
  `create_time` datetime DEFAULT NULL,
  `update_by` int DEFAULT NULL,
  `update_time` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `journal_entry_ca_idfk1` (`ca_id`),
  CONSTRAINT `journal_entry_ca_idfk1` FOREIGN KEY (`ca_id`) REFERENCES `chart_of_ac` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `journal_entry`
--

LOCK TABLES `journal_entry` WRITE;
/*!40000 ALTER TABLE `journal_entry` DISABLE KEYS */;
INSERT INTO `journal_entry` VALUES (11,00001,157,'2021-09-02',8,5000,'Cash withdrew for patty cash','',NULL,3,1,0,1,1,'2021-09-04 15:21:54',NULL,NULL),(12,00001,156,'2021-09-02',8,5000,'Cash withdrew for patty cash','',NULL,4,1,0,1,1,'2021-09-04 15:21:54',NULL,NULL);
/*!40000 ALTER TABLE `journal_entry` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `lh_proll_normal`
--

DROP TABLE IF EXISTS `lh_proll_normal`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `lh_proll_normal` (
  `id` int NOT NULL AUTO_INCREMENT,
  `title` varchar(255) DEFAULT NULL,
  `short_code` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `lh_proll_normal`
--

LOCK TABLES `lh_proll_normal` WRITE;
/*!40000 ALTER TABLE `lh_proll_normal` DISABLE KEYS */;
INSERT INTO `lh_proll_normal` VALUES (1,'Earn Leave',NULL),(2,'Casual Leave',NULL),(3,'Medical Leave',NULL),(4,'Maternity/Paternity Leave',NULL),(5,'Marriage Leave',NULL),(6,'Special Leave',NULL);
/*!40000 ALTER TABLE `lh_proll_normal` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `location`
--

DROP TABLE IF EXISTS `location`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `location` (
  `id` int NOT NULL AUTO_INCREMENT,
  `store_id` int NOT NULL,
  `name` varchar(255) NOT NULL,
  `address` text,
  `created_by` int DEFAULT NULL,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `updated_by` int DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `store_id` (`store_id`,`name`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `location`
--

LOCK TABLES `location` WRITE;
/*!40000 ALTER TABLE `location` DISABLE KEYS */;
INSERT INTO `location` VALUES (1,1,'DEFAULT LOCATION','',1,'2022-07-14 09:18:08',1,'2022-07-14 09:23:34');
/*!40000 ALTER TABLE `location` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `login_history`
--

DROP TABLE IF EXISTS `login_history`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `login_history` (
  `id` bigint NOT NULL AUTO_INCREMENT,
  `user_id` int DEFAULT NULL,
  `username` varchar(255) DEFAULT NULL,
  `ip` varchar(255) DEFAULT NULL,
  `hostname` varchar(255) DEFAULT NULL,
  `city` varchar(255) DEFAULT NULL,
  `region` varchar(255) DEFAULT NULL,
  `country` varchar(255) DEFAULT NULL,
  `loc` varchar(255) DEFAULT NULL,
  `postal` varchar(255) DEFAULT NULL,
  `browser` varchar(255) NOT NULL,
  `mobile_desktop` tinyint(1) NOT NULL DEFAULT '1' COMMENT '1 => web, 2=>mobile',
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `remarks` text,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `user` (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=108 DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `login_history`
--

LOCK TABLES `login_history` WRITE;
/*!40000 ALTER TABLE `login_history` DISABLE KEYS */;
INSERT INTO `login_history` VALUES (1,1,'superadmin','103.231.160.129','','','','',', ','','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/88.0.4324.190 Safari/537.36\n\n',1,1,NULL,'2021-03-01 00:22:47'),(2,1,'superadmin','103.231.160.129','','','','',', ','','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/88.0.4324.190 Safari/537.36\n\n',1,1,NULL,'2021-03-01 00:34:22'),(3,1,'superadmin','103.147.162.158','','','','',', ','','Mozilla/5.0 (Linux; Android 9; Redmi S2 Build/PKQ1.181203.001; wv) AppleWebKit/537.36 (KHTML, like Gecko) Version/4.0 Chrome/88.0.4324.181 Mobile Safari/537.36 [FB_IAB/Orca-Android;FBAV/301.0.0.12.112;]\n\n',2,1,NULL,'2021-03-01 08:27:02'),(4,1,'superadmin','182.163.102.201','','','','',', ','','Mozilla/5.0 (Linux; Android 10; SM-M205F) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/88.0.4324.181 Mobile Safari/537.36\n\n',2,1,NULL,'2021-03-01 10:25:40'),(5,NULL,'admin@admin.com','103.230.105.62','','','','',', ','','Mozilla/5.0 (Linux; Android 10; SM-M205F) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/88.0.4324.181 Mobile Safari/537.36\n\n',2,0,'Incorrect username or password., ','2021-03-01 18:09:52'),(6,1,'superadmin','103.230.105.62','','','','',', ','','Mozilla/5.0 (Linux; Android 10; SM-M205F) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/88.0.4324.181 Mobile Safari/537.36\n\n',2,1,NULL,'2021-03-01 18:10:12'),(7,1,'superadmin','103.147.162.158','','','','',', ','','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/88.0.4324.190 Safari/537.36\n\n',1,1,NULL,'2021-03-01 21:21:33'),(8,1,'superadmin','103.231.160.129','','','','',', ','','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/88.0.4324.190 Safari/537.36\n\n',1,1,NULL,'2021-03-01 23:03:18'),(9,1,'superadmin','103.231.160.129','','','','',', ','','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/88.0.4324.190 Safari/537.36\n\n',1,1,NULL,'2021-03-01 23:10:15'),(10,1,'superadmin','103.231.160.129','','','','',', ','','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/88.0.4324.190 Safari/537.36\n\n',1,1,NULL,'2021-03-02 22:21:25'),(11,1,'superadmin','103.231.160.129','','','','',', ','','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/88.0.4324.190 Safari/537.36\n\n',1,1,NULL,'2021-03-03 21:06:00'),(12,1,'accounting_demo','103.231.160.129','','','','',', ','','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/88.0.4324.190 Safari/537.36\n\n',1,1,NULL,'2021-03-03 21:24:35'),(13,1,'accounting_demo','103.231.160.129','','','','',', ','','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/88.0.4324.190 Safari/537.36\n\n',1,1,NULL,'2021-03-04 20:59:00'),(14,1,'accounting_demo','103.231.160.129','','','','',', ','','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/88.0.4324.190 Safari/537.36\n\n',1,1,NULL,'2021-03-04 21:24:42'),(15,1,'accounting_demo','103.231.160.129','','','','',', ','','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/89.0.4389.72 Safari/537.36\n\n',1,1,NULL,'2021-03-05 10:34:32'),(16,1,'accounting_demo','103.231.160.129','','','','',', ','','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/89.0.4389.72 Safari/537.36\n\n',1,1,NULL,'2021-03-05 12:27:39'),(17,1,'accounting_demo','103.231.160.129','','','','',', ','','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/89.0.4389.72 Safari/537.36\n\n',1,1,NULL,'2021-03-05 12:29:00'),(18,1,'accounting_demo','103.231.160.129','','','','',', ','','Mozilla/5.0 (Linux; Android 10; SM-M205F) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/89.0.4389.72 Mobile Safari/537.36\n\n',2,1,NULL,'2021-03-05 13:56:07'),(19,1,'accounting_demo','103.231.160.129','','','','',', ','','Mozilla/5.0 (Linux; Android 10; SM-M205F) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/89.0.4389.72 Mobile Safari/537.36\n\n',2,1,NULL,'2021-03-05 13:59:48'),(20,1,'accounting_demo','182.163.102.201','','','','',', ','','Mozilla/5.0 (Linux; Android 10; SM-M205F) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/89.0.4389.72 Mobile Safari/537.36\n\n',2,1,NULL,'2021-03-06 09:45:51'),(21,1,'accounting_demo','182.163.102.201','','','','',', ','','Mozilla/5.0 (Linux; Android 10; SM-M205F) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/89.0.4389.72 Mobile Safari/537.36\n\n',2,1,NULL,'2021-03-06 09:46:58'),(22,1,'accounting_demo','182.163.102.201','','','','',', ','','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/89.0.4389.72 Safari/537.36\n\n',1,1,NULL,'2021-03-06 10:44:59'),(23,1,'accounting_demo','182.163.102.201','','','','',', ','','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/89.0.4389.72 Safari/537.36\n\n',1,1,NULL,'2021-03-06 12:40:50'),(24,1,'accounting_demo','103.147.162.158','','','','',', ','','Mozilla/5.0 (Linux; Android 10; SM-M205F) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/89.0.4389.72 Mobile Safari/537.36\n\n',2,1,NULL,'2021-03-06 21:23:05'),(25,1,'accounting_demo','103.147.162.158','','','','',', ','','Mozilla/5.0 (Linux; Android 10; SM-M205F) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/89.0.4389.72 Mobile Safari/537.36\n\n',2,1,NULL,'2021-03-06 21:23:56'),(26,1,'accounting_demo','103.147.162.158','','','','',', ','','Mozilla/5.0 (Linux; Android 10; SM-M205F) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/89.0.4389.72 Mobile Safari/537.36\n\n',2,1,NULL,'2021-03-06 21:23:58'),(27,1,'accounting_demo','203.76.110.91','','','','',', ','','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/89.0.4389.82 Safari/537.36\n\n',1,1,NULL,'2021-03-08 15:27:49'),(28,1,'accounting_demo','182.163.102.201','','','','',', ','','Mozilla/5.0 (Linux; Android 10; SM-M205F) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/89.0.4389.72 Mobile Safari/537.36\n\n',2,1,NULL,'2021-03-08 15:28:49'),(29,1,'accounting_demo','103.231.160.129','','','','',', ','','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/89.0.4389.82 Safari/537.36\n\n',1,1,NULL,'2021-03-09 07:49:10'),(30,1,'accounting_demo','103.231.160.129','','','','',', ','','Mozilla/5.0 (Linux; Android 10; SM-M205F) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/89.0.4389.72 Mobile Safari/537.36\n\n',2,1,NULL,'2021-03-09 07:56:04'),(31,1,'accounting_demo','182.163.102.201','','','','',', ','','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/89.0.4389.82 Safari/537.36\n\n',1,1,NULL,'2021-03-09 15:01:02'),(32,1,'accounting_demo','103.231.160.129','','','','',', ','','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/89.0.4389.82 Safari/537.36\n\n',1,1,NULL,'2021-03-15 21:23:20'),(33,1,'accounting_demo','182.163.102.201','','','','',', ','','Mozilla/5.0 (Linux; Android 10; SM-M205F) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/89.0.4389.90 Mobile Safari/537.36\n\n',2,1,NULL,'2021-03-18 11:22:13'),(34,1,'accounting_demo','182.163.102.201','','','','',', ','','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/89.0.4389.90 Safari/537.36\n\n',1,1,NULL,'2021-03-18 11:29:37'),(35,1,'accounting_demo','103.230.105.20','','','','',', ','','Mozilla/5.0 (Linux; Android 10; SM-M205F) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/89.0.4389.105 Mobile Safari/537.36\n\n',2,1,NULL,'2021-03-28 10:46:18'),(36,1,'accounting_demo','103.231.160.129','','','','',', ','','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/89.0.4389.90 Safari/537.36\n\n',1,1,NULL,'2021-04-02 16:07:00'),(37,1,'accounting_demo','103.231.160.129','','','','',', ','','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/89.0.4389.114 Safari/537.36\n\n',1,1,NULL,'2021-04-14 15:54:45'),(38,NULL,'superadmin','103.147.162.158','','','','',', ','','Mozilla/5.0 (Linux; Android 9; moto g(8) power lite Build/POD29.345-25; wv) AppleWebKit/537.36 (KHTML, like Gecko) Version/4.0 Chrome/89.0.4389.105 Mobile Safari/537.36 [FB_IAB/Orca-Android;FBAV/307.1.0.12.121;]\n\n',2,0,'Incorrect username or password., ','2021-04-14 16:35:46'),(39,NULL,'superadmin','103.147.162.158','','','','',', ','','Mozilla/5.0 (Linux; Android 9; moto g(8) power lite Build/POD29.345-25; wv) AppleWebKit/537.36 (KHTML, like Gecko) Version/4.0 Chrome/89.0.4389.105 Mobile Safari/537.36 [FB_IAB/Orca-Android;FBAV/307.1.0.12.121;]\n\n',2,0,'Incorrect username or password., ','2021-04-14 16:36:04'),(40,NULL,'accounting_demo','103.147.162.158','','','','',', ','','Mozilla/5.0 (Linux; Android 9; moto g(8) power lite Build/POD29.345-25; wv) AppleWebKit/537.36 (KHTML, like Gecko) Version/4.0 Chrome/89.0.4389.105 Mobile Safari/537.36 [FB_IAB/Orca-Android;FBAV/307.1.0.12.121;]\n\n',2,0,'Incorrect username or password., ','2021-04-14 16:42:16'),(41,NULL,'superadmin','103.147.162.158','','','','',', ','','Mozilla/5.0 (Linux; Android 9; moto g(8) power lite Build/POD29.345-25; wv) AppleWebKit/537.36 (KHTML, like Gecko) Version/4.0 Chrome/89.0.4389.105 Mobile Safari/537.36 [FB_IAB/Orca-Android;FBAV/307.1.0.12.121;]\n\n',2,0,'Incorrect username or password., ','2021-04-14 16:42:39'),(42,NULL,'accounting_demo','103.147.162.158','','','','',', ','','Mozilla/5.0 (Linux; Android 9; moto g(8) power lite Build/POD29.345-25; wv) AppleWebKit/537.36 (KHTML, like Gecko) Version/4.0 Chrome/89.0.4389.105 Mobile Safari/537.36 [FB_IAB/Orca-Android;FBAV/307.1.0.12.121;]\n\n',2,0,'Incorrect username or password., ','2021-04-14 16:43:18'),(43,NULL,'accounting_demo','103.147.162.158','','','','',', ','','Mozilla/5.0 (Linux; Android 9; moto g(8) power lite Build/POD29.345-25; wv) AppleWebKit/537.36 (KHTML, like Gecko) Version/4.0 Chrome/89.0.4389.105 Mobile Safari/537.36 [FB_IAB/Orca-Android;FBAV/307.1.0.12.121;]\n\n',2,0,'Incorrect username or password., ','2021-04-14 16:43:26'),(44,NULL,'accounting_demo','103.147.162.158','','','','',', ','','Mozilla/5.0 (Linux; Android 9; moto g(8) power lite Build/POD29.345-25; wv) AppleWebKit/537.36 (KHTML, like Gecko) Version/4.0 Chrome/89.0.4389.105 Mobile Safari/537.36 [FB_IAB/Orca-Android;FBAV/307.1.0.12.121;]\n\n',2,0,'Incorrect username or password., ','2021-04-14 16:46:19'),(45,NULL,'accounting_demo','103.147.162.158','','','','',', ','','Mozilla/5.0 (Linux; Android 9; moto g(8) power lite Build/POD29.345-25; wv) AppleWebKit/537.36 (KHTML, like Gecko) Version/4.0 Chrome/89.0.4389.105 Mobile Safari/537.36 [FB_IAB/Orca-Android;FBAV/307.1.0.12.121;]\n\n',2,0,'Incorrect username or password., ','2021-04-14 16:46:23'),(46,NULL,'accounting_demo','103.231.160.129','','','','',', ','','Mozilla/5.0 (Linux; Android 10; SM-M205F Build/QP1A.190711.020; wv) AppleWebKit/537.36 (KHTML, like Gecko) Version/4.0 Chrome/89.0.4389.105 Mobile Safari/537.36 [FB_IAB/Orca-Android;FBAV/307.1.0.12.121;]\n\n',2,0,'Incorrect username or password., ','2021-04-14 16:46:31'),(47,NULL,'accounting_demo','103.231.160.129','','','','',', ','','Mozilla/5.0 (Linux; Android 10; SM-M205F Build/QP1A.190711.020; wv) AppleWebKit/537.36 (KHTML, like Gecko) Version/4.0 Chrome/89.0.4389.105 Mobile Safari/537.36 [FB_IAB/Orca-Android;FBAV/307.1.0.12.121;]\n\n',2,0,'Incorrect username or password., ','2021-04-14 16:46:39'),(48,1,'accounting_demo','103.231.160.129','','','','',', ','','Mozilla/5.0 (Linux; Android 10; SM-M205F) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/89.0.4389.105 Mobile Safari/537.36\n\n',2,1,NULL,'2021-04-14 16:47:04'),(49,1,'accounting_demo','103.231.160.129','','','','',', ','','Mozilla/5.0 (Linux; Android 10; SM-M205F) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/89.0.4389.105 Mobile Safari/537.36\n\n',2,1,NULL,'2021-04-14 16:48:46'),(50,NULL,'accounting_demo@21','103.147.162.158','','','','',', ','','Mozilla/5.0 (Linux; Android 9; moto g(8) power lite Build/POD29.345-25; wv) AppleWebKit/537.36 (KHTML, like Gecko) Version/4.0 Chrome/90.0.4430.91 Mobile Safari/537.36 [FB_IAB/Orca-Android;FBAV/310.0.0.20.117;]\n\n',2,0,'Incorrect username or password., ','2021-05-04 00:31:24'),(51,NULL,'superadmin','103.147.162.158','','','','',', ','','Mozilla/5.0 (Linux; Android 9; moto g(8) power lite Build/POD29.345-25; wv) AppleWebKit/537.36 (KHTML, like Gecko) Version/4.0 Chrome/90.0.4430.91 Mobile Safari/537.36 [FB_IAB/Orca-Android;FBAV/310.0.0.20.117;]\n\n',2,0,'Incorrect username or password., ','2021-05-04 00:31:41'),(52,NULL,'superadmin','103.147.162.158','','','','',', ','','Mozilla/5.0 (Linux; Android 9; moto g(8) power lite Build/POD29.345-25; wv) AppleWebKit/537.36 (KHTML, like Gecko) Version/4.0 Chrome/90.0.4430.91 Mobile Safari/537.36 [FB_IAB/Orca-Android;FBAV/310.0.0.20.117;]\n\n',2,0,'Incorrect username or password., ','2021-05-04 00:31:53'),(53,1,'accounting_demo','202.134.10.140','','','','',', ','','Mozilla/5.0 (Linux; Android 10; SM-M205F) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/90.0.4430.91 Mobile Safari/537.36\n\n',2,1,NULL,'2021-05-07 12:33:37'),(54,1,'accounting_demo','103.220.204.37','','','','',', ','','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/92.0.4515.159 Safari/537.36\n\n',1,1,NULL,'2021-08-21 19:18:10'),(55,1,'accounting_demo','103.220.204.37','','','','',', ','','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/92.0.4515.159 Safari/537.36\n\n',1,1,NULL,'2021-08-21 19:21:10'),(56,1,'accounting_demo','103.220.204.37','','','','',', ','','Mozilla/5.0 (Linux; Android 9; moto g(8) power lite) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/92.0.4515.159 Mobile Safari/537.36\n\n',2,1,NULL,'2021-08-21 19:42:49'),(57,1,'accounting_demo','103.220.204.37','','','','',', ','','Mozilla/5.0 (Linux; Android 9; moto g(8) power lite) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/92.0.4515.159 Mobile Safari/537.36\n\n',2,1,NULL,'2021-08-21 20:13:06'),(58,1,'accounting_demo','::1','','','','',', ','','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/92.0.4515.159 Safari/537.36\n\n',1,1,NULL,'2021-08-22 21:27:45'),(59,1,'accounting_demo','::1','','','','',', ','','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/92.0.4515.159 Safari/537.36\n\n',1,1,NULL,'2021-08-22 21:28:41'),(60,1,'accounting_demo','::1','','','','',', ','','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/92.0.4515.159 Safari/537.36\n\n',1,1,NULL,'2021-08-23 22:03:05'),(61,1,'accounting_demo','103.231.161.169','','','','',', ','','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/92.0.4515.159 Safari/537.36\n\n',1,1,NULL,'2021-09-02 21:30:23'),(62,1,'accounting_demo','103.13.133.69','','','','',', ','','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/92.0.4515.159 Safari/537.36\n\n',1,1,NULL,'2021-09-03 00:47:11'),(63,1,'accounting_demo','103.231.161.169','','','','',', ','','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/92.0.4515.159 Safari/537.36\n\n',1,1,NULL,'2021-09-03 14:13:45'),(64,1,'accounting_demo','37.111.199.192','','','','',', ','','Mozilla/5.0 (Linux; Android 9; moto g(8) power lite) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/92.0.4515.166 Mobile Safari/537.36\n\n',2,1,NULL,'2021-09-03 23:25:52'),(65,1,'accounting_demo','103.13.133.69','','','','',', ','','Mozilla/5.0 (Linux; Android 9; moto g(8) power lite) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/92.0.4515.166 Mobile Safari/537.36\n\n',2,1,NULL,'2021-09-04 21:03:12'),(66,1,'accounting_demo','103.231.161.169','','','','',', ','','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/92.0.4515.159 Safari/537.36\n\n',1,1,NULL,'2021-09-04 21:09:17'),(67,1,'accounting_demo','103.231.161.169','','','','',', ','','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/92.0.4515.159 Safari/537.36\n\n',1,1,NULL,'2021-09-04 21:18:42'),(68,1,'superadmin','::1','','','','',', ','','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/103.0.0.0 Safari/537.36\n\n',1,1,NULL,'2022-07-05 20:27:12'),(69,1,'superadmin','::1','','','','',', ','','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/103.0.0.0 Safari/537.36\n\n',1,1,NULL,'2022-07-05 22:01:39'),(70,1,'superadmin','::1','','','','',', ','','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/103.0.0.0 Safari/537.36\n\n',1,1,NULL,'2022-07-06 09:11:58'),(71,1,'superadmin','::1','','','','',', ','','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/103.0.0.0 Safari/537.36\n\n',1,1,NULL,'2022-07-06 16:05:22'),(72,1,'superadmin','::1','','','','',', ','','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/103.0.0.0 Safari/537.36\n\n',1,1,NULL,'2022-07-07 09:49:15'),(73,1,'superadmin','::1','','','','',', ','','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/103.0.0.0 Safari/537.36\n\n',1,1,NULL,'2022-07-07 11:21:05'),(74,1,'superadmin','::1','','','','',', ','','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/103.0.0.0 Safari/537.36\n\n',1,1,NULL,'2022-07-07 14:37:18'),(75,1,'superadmin','::1','','','','',', ','','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/103.0.0.0 Safari/537.36\n\n',1,1,NULL,'2022-07-07 15:20:23'),(76,1,'superadmin','::1','','','','',', ','','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/103.0.0.0 Safari/537.36\n\n',1,1,NULL,'2022-07-07 18:54:19'),(77,1,'superadmin','::1','','','','',', ','','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/103.0.0.0 Safari/537.36\n\n',1,1,NULL,'2022-07-13 20:20:55'),(78,1,'superadmin','::1','','','','',', ','','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/103.0.0.0 Safari/537.36\n\n',1,1,NULL,'2022-07-14 09:12:37'),(79,1,'superadmin','::1','','','','',', ','','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/103.0.0.0 Safari/537.36\n\n',1,1,NULL,'2022-07-14 11:57:24'),(80,1,'superadmin','::1','','','','',', ','','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/103.0.0.0 Safari/537.36\n\n',1,1,NULL,'2022-07-14 16:40:55'),(81,1,'superadmin','::1','','','','',', ','','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/103.0.0.0 Safari/537.36\n\n',1,1,NULL,'2022-07-14 17:57:09'),(82,1,'superadmin','::1','','','','',', ','','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/103.0.0.0 Safari/537.36\n\n',1,1,NULL,'2022-07-15 09:34:10'),(83,1,'superadmin','::1','','','','',', ','','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/103.0.0.0 Safari/537.36\n\n',1,1,NULL,'2022-07-15 16:00:58'),(84,1,'superadmin','::1','','','','',', ','','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/103.0.0.0 Safari/537.36\n\n',1,1,NULL,'2022-07-15 18:15:39'),(85,1,'superadmin','::1','','','','',', ','','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/103.0.0.0 Safari/537.36\n\n',1,1,NULL,'2022-07-15 19:31:24'),(86,1,'superadmin','::1','','','','',', ','','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/103.0.0.0 Safari/537.36\n\n',1,1,NULL,'2022-07-15 20:40:09'),(87,1,'superadmin','::1','','','','',', ','','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/103.0.0.0 Safari/537.36\n\n',1,1,NULL,'2022-07-16 09:38:23'),(88,1,'superadmin','::1','','','','',', ','','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/103.0.0.0 Safari/537.36\n\n',1,1,NULL,'2022-07-16 12:26:30'),(89,1,'superadmin','::1','','','','',', ','','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/103.0.0.0 Safari/537.36\n\n',1,1,NULL,'2022-07-16 15:17:14'),(90,1,'superadmin','::1','','','','',', ','','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/103.0.0.0 Safari/537.36\n\n',1,1,NULL,'2022-07-16 19:06:30'),(91,1,'superadmin','::1','','','','',', ','','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/103.0.0.0 Safari/537.36\n\n',1,1,NULL,'2022-07-16 21:22:55'),(92,1,'superadmin','::1','','','','',', ','','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/103.0.0.0 Safari/537.36\n\n',1,1,NULL,'2022-07-16 23:02:11'),(93,1,'superadmin','::1','','','','',', ','','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/103.0.0.0 Safari/537.36\n\n',1,1,NULL,'2022-07-17 09:10:27'),(94,1,'superadmin','::1','','','','',', ','','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/103.0.0.0 Safari/537.36\n\n',1,1,NULL,'2022-07-18 09:19:13'),(95,1,'superadmin','::1','','','','',', ','','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/103.0.0.0 Safari/537.36\n\n',1,1,NULL,'2022-07-18 11:14:09'),(96,1,'superadmin','::1','','','','',', ','','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/103.0.0.0 Safari/537.36\n\n',1,1,NULL,'2022-07-18 15:42:27'),(97,1,'superadmin','::1','','','','',', ','','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/103.0.0.0 Safari/537.36\n\n',1,1,NULL,'2022-07-19 09:20:55'),(98,1,'superadmin','::1','','','','',', ','','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/103.0.0.0 Safari/537.36\n\n',1,1,NULL,'2022-07-20 08:39:27'),(99,1,'superadmin','::1','','','','',', ','','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/103.0.0.0 Safari/537.36\n\n',1,1,NULL,'2022-07-20 17:18:44'),(100,1,'superadmin','::1','','','','',', ','','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/103.0.0.0 Safari/537.36\n\n',1,1,NULL,'2022-07-20 17:38:00'),(101,1,'superadmin','::1','','','','',', ','','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/103.0.0.0 Safari/537.36\n\n',1,1,NULL,'2022-07-20 19:46:52'),(102,1,'superadmin','::1','','','','',', ','','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/103.0.0.0 Safari/537.36\n\n',1,1,NULL,'2022-07-20 22:40:00'),(103,1,'superadmin','::1','','','','',', ','','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/103.0.0.0 Safari/537.36\n\n',1,1,NULL,'2022-07-22 09:37:00'),(104,1,'superadmin','::1','','','','',', ','','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/103.0.0.0 Safari/537.36\n\n',1,1,NULL,'2022-07-22 21:46:53'),(105,1,'superadmin','::1','','','','',', ','','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/103.0.0.0 Safari/537.36\n\n',1,1,NULL,'2022-07-23 09:26:08'),(106,1,'superadmin','::1','','','','',', ','','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/103.0.0.0 Safari/537.36\n\n',1,1,NULL,'2022-07-23 11:25:35'),(107,1,'superadmin','::1','','','','',', ','','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/103.0.0.0 Safari/537.36\n\n',1,1,NULL,'2022-07-23 12:17:35');
/*!40000 ALTER TABLE `login_history` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `lookup`
--

DROP TABLE IF EXISTS `lookup`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `lookup` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  `code` int DEFAULT NULL,
  `type` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=264 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `lookup`
--

LOCK TABLES `lookup` WRITE;
/*!40000 ALTER TABLE `lookup` DISABLE KEYS */;
INSERT INTO `lookup` VALUES (1,'ACTIVE',1,'is_active'),(2,'INACTIVE',2,'is_active'),(3,'NOT RECEIVED',5,'is_received'),(4,'RECEIVED',6,'is_received'),(5,'CURRENCY',7,'unit_type'),(6,'QUANTITY',8,'unit_type'),(7,'PENDING',9,'approved_status'),(8,'APPROVED',10,'approved_status'),(9,'COLOR',15,'color_or_size'),(10,'SIZE',16,'color_or_size'),(11,'MEASUREMENT',17,'unit_type'),(12,'WEIGHT',18,'unit_type'),(13,'NOT ADDED',21,'isAddedToInventory'),(14,'ADDED',22,'isAddedToInventory'),(15,'ALL NOT DELIVERED',23,'is_all_delivered'),(16,'ALL DELIVERED',24,'is_all_delivered'),(17,'PO',27,'voucher_type'),(18,'SO',28,'voucher_type'),(19,'POS',29,'voucher_type'),(20,'STOCK',30,'voucher_type'),(21,'DELIVERY VOUCHER',31,'voucher_type'),(22,'RECEIVE VOUCHER',32,'voucher_type'),(23,'PO',33,'operation_type'),(24,'SO',34,'operation_type'),(25,'POS',35,'operation_type'),(26,'ALL NOT RECEIVED',36,'is_all_received'),(27,'ALL RECEIVED',37,'is_all_received'),(30,'SO',40,'no_type'),(31,'POS',41,'no_type'),(32,'Dr',42,'amount_type'),(33,'Cr',43,'amount_type'),(34,'ESTABLISHED',44,'order_status'),(36,'CANCELED',45,'order_status'),(37,'COMPLAIN NO',46,'report_type'),(38,'ASSIGNED',47,'assign_status'),(39,'REVOKED',48,'assign_status'),(55,'EARNING',13,'ac_type'),(56,'DEDUCTION',14,'ac_type'),(57,'PENDING',15,'is_approved'),(58,'APPROVED',16,'is_approved'),(59,'DENIED',17,'is_approved'),(60,'ABSENT',18,'is_present'),(61,'PRESENT',19,'is_present'),(63,'CURRENT',20,'adv_pay_type'),(64,'LONG-TERM',21,'adv_pay_type'),(66,'PAY',22,'payOrReceive'),(67,'RECEIVE',23,'payOrReceive'),(68,'LOCAL',54,'local_import'),(69,'IMPORT',55,'local_import'),(70,'MALE',56,'gender'),(71,'FEMALE',57,'gender'),(72,'SINGLE',58,'marital_status'),(73,'MARRIED',59,'marital_status'),(74,'DIVORCED',60,'marital_status'),(75,'A (+ve)',61,'blood_group'),(76,'B (+ve)',62,'blood_group'),(77,'O (+ve)',63,'blood_group'),(78,'AB (+ve)',64,'blood_group'),(79,'AB (-ve)',65,'blood_group'),(80,'O (-ve)',66,'blood_group'),(81,'B (-ve)',67,'blood_group'),(82,'A (-ve)',68,'blood_group'),(83,'REGULAR',69,'employee_type'),(84,'PART-TIME',70,'employee_type'),(85,'FATHER',71,'spouse_relation'),(86,'MOTHER',72,'spouse_relation'),(87,'SISTER',73,'spouse_relation'),(88,'BROTHER',74,'spouse_relation'),(89,'HUSBAND',75,'spouse_relation'),(90,'WIFE',76,'spouse_relation'),(91,'UNCLE',77,'spouse_relation'),(92,'OTHER',78,'spouse_relation'),(93,'MONTHLY',79,'earn_deduct_type'),(94,'DAILY',80,'earn_deduct_type'),(95,'CASH',81,'cash_due'),(96,'CREDIT',82,'cash_due'),(97,'ISLAM',83,'religion'),(98,'HINDU',84,'religion'),(99,'CHRISTIAN',85,'religion'),(100,'BUDDHISM',86,'religion'),(101,'OTHER',87,'religion'),(102,'VERIFIED',88,'varified_po'),(103,'NOT VERIFIED',89,'varified_po'),(104,'2WD',90,'wheel_type'),(105,'4WD',91,'wheel_type'),(106,'MANUAL',92,'transmission_type'),(107,'AUTO',93,'transmission_type'),(108,'DUEL FUEL',94,'fuel_type'),(109,'HYBRID',95,'fuel_type'),(110,'DIESEL',96,'fuel_type'),(111,'TAX TOKEN',97,'car_docs'),(112,'BLUE BOOK',98,'car_docs'),(113,'FITNESS',99,'car_docs'),(114,'INSURANCE',100,'car_docs'),(115,'BATTERY W.CARD',101,'car_docs'),(116,'W',102,'complain_types'),(117,'EST',103,'complain_types'),(118,'RW',104,'complain_types'),(119,'DW',105,'complain_types'),(120,'CHECK',106,'complain_types'),(121,'Diagnosis Complete',107,'work_status'),(123,'INR Completed L1',109,'work_status'),(124,'Estimated L1',110,'work_status'),(127,'QC Running',113,'work_status'),(129,'COMPLIMENTORY',115,'complain_types'),(130,'MAINTENANCE BOOKLET',116,'car_docs'),(131,'ROAD PARMIT',117,'car_docs'),(134,'Estimated From Store L1',120,'work_status'),(135,'G_ACTIVE',121,'active_parts_price'),(136,'NG1_ACTIVE',122,'active_parts_price'),(137,'RC_ACTIVE',123,'active_parts_price'),(138,'INR Completed L2',124,'work_status'),(139,'Estimated From Store L2',125,'work_status'),(140,'Estimated L2',126,'work_status'),(141,'INR Completed L3',127,'work_status'),(142,'Estimated From Store L3',128,'work_status'),(143,'Estimated L3',129,'work_status'),(144,'INR Completed L4',130,'work_status'),(145,'Estimated From Store L4',131,'work_status'),(146,'Estimated L4',132,'work_status'),(147,'CASH',133,'payment_type'),(148,'CHEQUE',134,'payment_type'),(149,'DUE',135,'payment_type'),(150,'OTHERS',136,'payment_type'),(151,'OWNER\\\'S MANUAL',137,'car_docs'),(152,'NG2_ACTIVE',138,'active_parts_price'),(153,'NG3_ACTIVE',139,'active_parts_price'),(154,'NG4_ACTIVE',140,'active_parts_price'),(155,'NG5_ACTIVE',141,'active_parts_price'),(156,'YES',142,'doc_rcv'),(157,'NO',143,'doc_rcv'),(158,'ESTIMATE NO',144,'voucher_type'),(159,'HOME',145,'home_office'),(160,'OFFICE',146,'home_office'),(161,'ESTIMATE L1',147,'active_estimate'),(162,'ESTIMATE L2',148,'active_estimate'),(163,'ESTIMATE L3',149,'active_estimate'),(164,'ESTIMATE L4',150,'active_estimate'),(165,'JOB CARD NO',151,'voucher_type'),(166,'JOB Card Created',152,'work_status'),(167,'OK',153,'qc_status'),(168,'NOT-OK',154,'qc_status'),(169,'QC Completed',155,'work_status'),(170,'JOB Card Closed',156,'work_status'),(171,'CASH',1,'received_type'),(172,'CHEQUE',2,'received_type'),(173,'DIPOSIT_INTO_BANK',3,'received_type'),(174,'CARD',4,'received_type'),(175,'ADVANCE',1,'collection_type'),(176,'CASH_SALES',2,'collection_type'),(177,'DUE',3,'collection_type'),(178,'INR Final Completed L1',157,'work_status'),(179,'JOB PANDING',158,'work_status'),(180,'INR Restarted',159,'work_status'),(182,'HYBRID+GASOLINE',97,'fuel_type'),(183,'HYBRID+DIESEL',98,'fuel_type'),(184,'ELECTRIC DRIVE',99,'fuel_type'),(185,'OTHERS',100,'fuel_type'),(186,'GASOLINE',101,'fuel_type'),(187,'GASOLINE+CNG',102,'fuel_type'),(188,'GASOLINE+LPG',103,'fuel_type'),(189,'Waiting For JOB Card Create',160,'work_status'),(190,'CASH',1,'payment_status'),(191,'CHEQUE',2,'payment_status'),(192,'Dr/Cr CARD',3,'payment_status'),(193,'FOC',4,'payment_status'),(194,'DUE',5,'payment_status'),(195,'N/A',6,'payment_status'),(196,'Bill',1,'delivery_terms'),(197,'Est',2,'delivery_terms'),(198,'Adjustment',3,'delivery_terms'),(199,'Check Up',4,'delivery_terms'),(200,'D/W',5,'delivery_terms'),(201,'JP',6,'delivery_terms'),(202,'R/W',7,'delivery_terms'),(203,'Car Delivered',161,'work_status'),(204,'INR Completed L5',162,'work_status'),(205,'Estimated From Store L5',163,'work_status'),(206,'Estimated L5',164,'work_status'),(207,'ESTIMATE L5',151,'active_estimate'),(208,'Direct Work',165,'work_status'),(209,'Level 1
',1,'need_more_info_on'),(210,'Level 2
',2,'need_more_info_on'),(211,'Level 3
',3,'need_more_info_on'),(212,'Level 4
',4,'need_more_info_on'),(213,'Level 5
',5,'need_more_info_on'),(214,'Job Card',1,'req_type'),(215,'Production',2,'req_type'),(216,'Observation',8,'delivery_terms'),(217,'PPI',116,'complain_types'),(218,'PD',118,'complain_types'),(219,'WCC',119,'complain_types'),(220,'CCW',120,'complain_types'),(221,'ODS',121,'complain_types'),(222,'FOC',9,'delivery_terms'),(223,'NW',10,'delivery_terms'),(224,'Not Available',144,'doc_rcv'),(225,'Improper',145,'doc_rcv'),(226,'J/P',122,'complain_types'),(228,'PROVIDENT FUND',24,'adv_pay_type'),(229,'Nissan Autos',1,'company_name'),(232,'Black',1,'color'),(233,'Green',2,'color'),(234,'Orange',3,'color'),(235,'Blue',4,'color'),(236,'Yellow',5,'color'),(237,'CASH',1,'expense_type'),(238,'BANK',2,'expense_type'),(239,'Local',1,'local_export'),(240,'Export',2,'local_export'),(241,'ISLAM',83,'religion'),(242,'HINDU',84,'religion'),(243,'CHRISTIAN',85,'religion'),(244,'BUDDHISM',86,'religion'),(245,'OTHER',87,'religion'),(246,'A (+ve)',61,'blood_group'),(247,'B (+ve)',62,'blood_group'),(248,'O (+ve)',63,'blood_group'),(249,'AB (+ve)',64,'blood_group'),(250,'AB (-ve)',65,'blood_group'),(251,'O (-ve)',66,'blood_group'),(252,'B (-ve)',67,'blood_group'),(253,'A (-ve)',68,'blood_group'),(254,'SINGLE',58,'marital_status'),(255,'MARRIED',59,'marital_status'),(256,'DIVORCED',60,'marital_status'),(257,'ADVANCE ADJUSTMENT',5,'received_type'),(258,'Partnership',1,'business_type'),(259,'Private Limited',2,'business_type'),(260,'Public Limited',3,'business_type'),(261,'Proprietorship',4,'business_type'),(262,'Organization',5,'business_type');
/*!40000 ALTER TABLE `lookup` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `lookup_ac`
--

DROP TABLE IF EXISTS `lookup_ac`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `lookup_ac` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  `code` int DEFAULT NULL,
  `type` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=99 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `lookup_ac`
--

LOCK TABLES `lookup_ac` WRITE;
/*!40000 ALTER TABLE `lookup_ac` DISABLE KEYS */;
INSERT INTO `lookup_ac` VALUES (1,'ACTIVE',1,'is_active'),(2,'INACTIVE',2,'is_active'),(47,'Dr',3,'transaction_type'),(48,'Cr',4,'transaction_type'),(49,'ADJUSTMENT',7,'voucher_type'),(50,'CONTRA',8,'voucher_type'),(51,'RECEIPT',9,'voucher_type'),(52,'PAYMENT',10,'voucher_type'),(53,'FIXED',11,'is_fixed'),(54,'NOT FIXED',12,'is_fixed'),(55,'EARNING',13,'ac_type'),(56,'DEDUCTION',14,'ac_type'),(57,'PENDING',15,'is_approved'),(58,'APPROVED',16,'is_approved'),(59,'DENIED',17,'is_approved'),(60,'ABSENT',18,'is_present'),(61,'PRESENT',19,'is_present'),(63,'CURRENT',20,'adv_pay_type'),(64,'LONG-TERM',21,'adv_pay_type'),(66,'PAY',22,'payOrReceive'),(67,'RECEIVE',23,'payOrReceive'),(68,'LOCAL',54,'local_import'),(69,'IMPORT',55,'local_import'),(70,'MALE',56,'gender'),(71,'FEMALE',57,'gender'),(72,'SINGLE',58,'marital_status'),(73,'MARRIED',59,'marital_status'),(74,'DIVORCED',60,'marital_status'),(75,'A (+ve)',61,'blood_group'),(76,'B (+ve)',62,'blood_group'),(77,'O (+ve)',63,'blood_group'),(78,'AB (+ve)',64,'blood_group'),(79,'AB (-ve)',65,'blood_group'),(80,'O (-ve)',66,'blood_group'),(81,'B (-ve)',67,'blood_group'),(82,'A (-ve)',68,'blood_group'),(83,'REGULAR',69,'employee_type'),(84,'PART-TIME',70,'employee_type'),(85,'FATHER',71,'spouse_relation'),(86,'MOTHER',72,'spouse_relation'),(87,'SISTER',73,'spouse_relation'),(88,'BROTHER',74,'spouse_relation'),(89,'HUSBAND',75,'spouse_relation'),(90,'WIFE',76,'spouse_relation'),(91,'UNCLE',77,'spouse_relation'),(92,'OTHER',78,'spouse_relation'),(93,'MONTHLY',79,'earn_deduct_type'),(94,'DAILY',80,'earn_deduct_type'),(95,'NOT DELETE/EDITABLE',1,'account_type'),(96,'DELETE/EDITABLE',2,'account_type'),(97,'OE',1,'depr_type'),(98,'AO',2,'depr_type');
/*!40000 ALTER TABLE `lookup_ac` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `money_receipt`
--

DROP TABLE IF EXISTS `money_receipt`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `money_receipt` (
  `id` int NOT NULL AUTO_INCREMENT,
  `date` date NOT NULL,
  `customer_id` int NOT NULL,
  `invoice_id` int NOT NULL,
  `max_sl_no` int NOT NULL,
  `mr_no` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `payment_type` int NOT NULL,
  `bank_id` int DEFAULT NULL,
  `cheque_no` varchar(255) DEFAULT NULL,
  `cheque_date` date DEFAULT NULL,
  `amount` double NOT NULL,
  `discount` double DEFAULT '
0',
  `is_approved` tinyint NOT NULL DEFAULT '
0' COMMENT '
0=>Pending, 1=>Approved, 2=>Deny',
  `remarks` text,
  `created_by` int DEFAULT NULL,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `updated_by` int DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `money_receipt`
--

LOCK TABLES `money_receipt` WRITE;
/*!40000 ALTER TABLE `money_receipt` DISABLE KEYS */;
INSERT INTO `money_receipt` VALUES (1,'
2022-07-19
',1,1,1,'MR-22-07-00001
',1,NULL,'',NULL,1,0,0,'',1,'2022-07-19 14:48:57
',NULL,NULL),(2,'2022-07-19
',1,2,2,'MR-22-07-00001
',1,NULL,'',NULL,1,0,0,'',1,'2022-07-19 14:48:57
',NULL,NULL),(3,'2022-07-19
',1,3,3,'MR-22-07-00001
',1,NULL,'',NULL,1,0,0,'',1,'2022-07-19 14:48:57
',NULL,NULL),(4,'2022-07-19
',1,1,4,'MR-22-07-00004
',1,NULL,'',NULL,1,0,0,'',1,'2022-07-19 14:49:19
',NULL,NULL),(5,'2022-07-19
',1,2,5,'MR-22-07-00004
',1,NULL,'',NULL,1,0,0,'',1,'2022-07-19 14:49:19
',NULL,NULL),(6,'2022-07-19
',1,3,6,'MR-22-07-00004
',1,NULL,'',NULL,1,0,0,'',1,'2022-07-19 14:49:19
',NULL,NULL),(7,'2022-07-20
',1,1,7,'MR-22-07-00007
',1,NULL,'',NULL,18,0,0,'',1,'2022-07-20 11:59:05
',NULL,NULL),(8,'2022-07-20
',1,2,8,'MR-22-07-00007
',1,NULL,'',NULL,28,0,0,'',1,'2022-07-20 11:59:05
',NULL,NULL),(9,'2022-07-20
',1,3,9,'MR-22-07-00007
',1,NULL,'',NULL,98,0,0,'',1,'2022-07-20 11:59:05
',NULL,NULL),(10,'2022-07-20
',1,1,10,'MR-22-07-00010
',1,NULL,'',NULL,100,0,0,'',1,'2022-07-20 12:13:12
',NULL,NULL),(11,'2022-07-20
',1,2,11,'MR-22-07-00010
',1,NULL,'',NULL,20,0,0,'',1,'2022-07-20 12:13:12
',NULL,NULL);
/*!40000 ALTER TABLE `money_receipt` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `payment_receipt`
--

DROP TABLE IF EXISTS `payment_receipt`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `payment_receipt` (
  `id` int NOT NULL AUTO_INCREMENT,
  `date` date NOT NULL,
  `supplier_id` int NOT NULL,
  `order_id` int NOT NULL,
  `max_sl_no` int NOT NULL,
  `pr_no` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `payment_type` int NOT NULL,
  `bank_id` int DEFAULT NULL,
  `cheque_no` varchar(255) DEFAULT NULL,
  `cheque_date` date DEFAULT NULL,
  `amount` double NOT NULL,
  `discount` double DEFAULT '0
',
  `is_approved` tinyint NOT NULL DEFAULT '0
' COMMENT '0=>Pending, 1=>Approved, 2=>Deny',
  `remarks` text,
  `created_by` int DEFAULT NULL,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `updated_by` int DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `payment_receipt`
--

LOCK TABLES `payment_receipt` WRITE;
/*!40000 ALTER TABLE `payment_receipt` DISABLE KEYS */;
INSERT INTO `payment_receipt` VALUES (1,'
2022-07-20
',1,11,1,'PR-000001
',133,NULL,NULL,NULL,56.65,0,0,NULL,1,'2022-07-20 20:10:33
',NULL,NULL),(2,'2022-07-23
',1,1,2,'PR-22-07-00002
',1,NULL,'',NULL,1,0,0,'',1,'2022-07-23 10:14:57
',NULL,NULL),(3,'2022-07-23
',1,1,3,'PR-22-07-00003
',1,NULL,'',NULL,1,0,0,'',1,'2022-07-23 10:15:20
',NULL,NULL),(4,'2022-07-23
',1,1,4,'PR-22-07-00004
',1,NULL,'',NULL,1,0,0,'',1,'2022-07-23 10:16:12
',NULL,NULL),(5,'2022-07-23
',1,1,5,'PR-22-07-00005
',1,NULL,'',NULL,1,0,0,'',1,'2022-07-23 10:16:33
',NULL,NULL),(6,'2022-07-23
',1,1,6,'PR-22-07-00006
',2,2,'5555
','2022-07-23
',5,0,0,'',1,'2022-07-23 10:38:53
',NULL,NULL);
/*!40000 ALTER TABLE `payment_receipt` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `prod_brands`
--

DROP TABLE IF EXISTS `prod_brands`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `prod_brands` (
  `id` int NOT NULL AUTO_INCREMENT,
  `item_id` int NOT NULL,
  `brand_name` varchar(255) NOT NULL,
  `ca_id` int DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_prod_brands` (`item_id`),
  CONSTRAINT `prod_brands` FOREIGN KEY (`item_id`) REFERENCES `prod_items` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `prod_brands`
--

LOCK TABLES `prod_brands` WRITE;
/*!40000 ALTER TABLE `prod_brands` DISABLE KEYS */;
INSERT INTO `prod_brands` VALUES (1,2,'MAIN RAW MATERIALS',1279),(2,2,'OTHERS RAW MATERIALS',1284),(3,2,'CHEMICALS',1297),(4,4,'PARTS OF MACHINERIES',1317),(5,3,'FINISHED GOODS',1421),(6,7,'STATIONERY',1472),(7,8,'OIL',1544),(8,10,'SECURITY SERVICE',1546),(9,7,'STICKER',1554),(10,10,'TRANSPORT SERVIE',1556),(11,10,'TRANSPORT SERVICE',1558);
/*!40000 ALTER TABLE `prod_brands` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `prod_items`
--

DROP TABLE IF EXISTS `prod_items`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `prod_items` (
  `id` int NOT NULL AUTO_INCREMENT,
  `item_name` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `prod_items`
--

LOCK TABLES `prod_items` WRITE;
/*!40000 ALTER TABLE `prod_items` DISABLE KEYS */;
INSERT INTO `prod_items` VALUES (2,'RAW MATERIALS'),(3,'FINISHED GOODS'),(4,'MACHINARIES AND SPARE PARTSPARTS'),(6,'OTHERS RAW MATERIAL'),(7,'PRINTING AND STATIONERY'),(8,'UTILITY'),(9,'FUEL, OIL & LUBRICANTS'),(10,'SERVICE');
/*!40000 ALTER TABLE `prod_items` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `prod_models`
--

DROP TABLE IF EXISTS `prod_models`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `prod_models` (
  `id` int NOT NULL AUTO_INCREMENT,
  `item_id` int DEFAULT NULL,
  `brand_id` int DEFAULT NULL,
  `model_name` varchar(255) DEFAULT NULL,
  `code` varchar(255) DEFAULT NULL,
  `unit_id` int DEFAULT NULL,
  `manufacturer_id` int DEFAULT NULL,
  `country_id` int DEFAULT NULL,
  `min_order_qty` int DEFAULT NULL,
  `measurement` varchar(255) DEFAULT NULL,
  `weight` double DEFAULT NULL,
  `features` text,
  `warranty` double DEFAULT NULL,
  `description` text,
  `vatable` tinyint NOT NULL DEFAULT '
1',
  `image` varchar(300) DEFAULT NULL,
  `thumbnail` varchar(300) DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `created_by` int DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  `updated_by` int DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_prod_models` (`brand_id`),
  KEY `FK_prod_models_2` (`item_id`),
  KEY `unit` (`unit_id`),
  CONSTRAINT `prodBrand` FOREIGN KEY (`brand_id`) REFERENCES `prod_brands` (`id`),
  CONSTRAINT `prodItem` FOREIGN KEY (`item_id`) REFERENCES `prod_items` (`id`),
  CONSTRAINT `unit` FOREIGN KEY (`unit_id`) REFERENCES `units` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=24 DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `prod_models`
--

LOCK TABLES `prod_models` WRITE;
/*!40000 ALTER TABLE `prod_models` DISABLE KEYS */;
INSERT INTO `prod_models` VALUES (1,3,5,'LOUNGE CHAIR','Lounge Chair',1,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,1,'165703704362c460f30dabc.png',NULL,'
2022-07-05 22:04:03
',1,NULL,NULL),(2,3,5,'TRIANGLE POUF 800X800X500','Triangle Pouf 800X800X500',8,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,1,'165703709462c4612647a8a.png',NULL,'
2022-07-05 22:04:54
',1,NULL,NULL),(3,3,5,'600X600X500 POUF','600X600X500 Pouf',1,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,1,'165703712462c46144e8d17.png',NULL,'
2022-07-05 22:05:24
',1,NULL,NULL),(4,3,5,'ROUND POUF 800X800X500','Round Pouf 800X800X500',1,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,1,'165703717362c46175a9029.png',NULL,'
2022-07-05 22:06:00
',1,'2022-07-05 22:06:13
',1),(5,3,5,'1 STR SOFA CHROME LEGS 82X75X77','
1 Str Sofa Chrome Legs 82X75X77',1,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,1,'165703722762c461ab1ab8f.png',NULL,'
2022-07-05 22:07:07
',1,NULL,NULL),(6,3,5,'SIDE TABLE 40X40X45','Side Table 40X40X45',1,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,1,'165703726662c461d222515.png',NULL,'
2022-07-05 22:07:46
',1,NULL,NULL),(7,3,5,'RE UPH SOFA 3 STR GIO','Re Uph Sofa 3 Str Gio',1,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,1,NULL,NULL,'
2022-07-05 22:08:00
',1,NULL,NULL),(8,3,5,'3STR SOFA','3Str Sofa',1,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,1,'165703731362c46201a6fdf.png',NULL,'
2022-07-05 22:08:33
',1,NULL,NULL),(9,3,5,'CUBE 1 STR SOFA','Cube 1 Str Sofa',1,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,1,'165703734962c46225ccb3a.png',NULL,'
2022-07-05 22:09:09
',1,NULL,NULL),(10,3,5,'REUPHOLSTRY SOFA','Reupholstry Sofa',1,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,1,NULL,NULL,'
2022-07-05 22:09:31
',1,NULL,NULL),(11,3,5,'REUPHOLSTRY LB CHAIR','Reupholstry Lb Chair',1,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,1,NULL,NULL,'
2022-07-05 22:09:44
',1,NULL,NULL),(12,3,5,'REUPHOLSTRY','Reupholstry',1,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,1,NULL,NULL,'
2022-07-05 22:09:59
',1,NULL,NULL),(13,3,5,'REUPHOLSTRY CHAIR SLIM','Reupholstry Chair Slim',1,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,1,'165703743562c4627b204d5.png',NULL,'
2022-07-05 22:10:35
',1,NULL,NULL),(14,3,5,'1 STR SOFA 55X53X82','
1 Str Sofa 55X53X82',1,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,1,'165703746762c4629b2e8a3.png',NULL,'
2022-07-05 22:11:07
',1,NULL,NULL),(15,3,5,'2 STR SOFA 140X53X82','
2 Str Sofa 140X53X82',1,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,1,'165703750062c462bc28ef9.png',NULL,'
2022-07-05 22:11:40
',1,'2022-07-05 22:11:48
',1),(16,3,5,'INDEX 1 STR','Index 1 Str',1,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,1,'165703756062c462f823bde.png',NULL,'
2022-07-05 22:12:40
',1,NULL,NULL),(17,3,5,'INDEX 2 STR','Index 2 Str',1,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,1,'165703760162c4632116fe1.png',NULL,'
2022-07-05 22:13:21
',1,NULL,NULL),(18,3,5,'CHESTERFILED 1 STR','Chesterfiled 1 Str',1,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,1,'165703762962c4633dc80f8.png',NULL,'
2022-07-05 22:13:49
',1,NULL,NULL),(19,3,5,'RICA 2STR SOFA WITH FRAME, WITH THINNER SIDE ARMREST 10CM WIDTH.SHOULD HAVE ENOUGH FOAM, INSIDE CARCASS SHOULD NOT BE FELT WHILE TOUCHING. 143LX 50WX70H CM ','Rica 2Str Sofa With Frame, With Thinner Side Armrest 10Cm Width.Should Have Enough Foam, Inside Carcass Should Not Be Felt While Touching. 143Lx 50Wx70H Cm ',1,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,1,'165703772362c4639b374d9.png',NULL,'
2022-07-05 22:15:23
',1,NULL,NULL),(20,2,1,'PLYWOOD','Plywood',9,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'',1,'165703901462c468a608592.png',NULL,'
2022-07-05 22:36:54
',1,NULL,NULL),(21,4,4,'SCREW ','Screw ',1,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'',1,'165708510462c51cb00ba24.webp',NULL,'
2022-07-06 11:24:28
',1,'2022-07-06 11:25:04
',1),(22,2,1,'GLUE','Glue',1,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'',1,'165708517862c51cfad187e.jpg',NULL,'
2022-07-06 11:26:18
',1,'2022-07-06 16:21:30
',1),(23,2,1,'PIN','PIN',1,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'ALPIN',1,NULL,NULL,'
2022-07-16 10:37:53
',1,NULL,NULL);
/*!40000 ALTER TABLE `prod_models` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `profiles`
--

DROP TABLE IF EXISTS `profiles`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `profiles` (
  `user_id` int NOT NULL AUTO_INCREMENT,
  `lastname` varchar(50) NOT NULL DEFAULT '',
  `firstname` varchar(50) NOT NULL DEFAULT '',
  PRIMARY KEY (`user_id`),
  CONSTRAINT `user_profile_id` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `profiles`
--

LOCK TABLES `profiles` WRITE;
/*!40000 ALTER TABLE `profiles` DISABLE KEYS */;
INSERT INTO `profiles` VALUES (1,'Admin','Administrator');
/*!40000 ALTER TABLE `profiles` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `profiles_fields`
--

DROP TABLE IF EXISTS `profiles_fields`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `profiles_fields` (
  `id` int NOT NULL AUTO_INCREMENT,
  `varname` varchar(50) NOT NULL,
  `title` varchar(255) NOT NULL,
  `field_type` varchar(50) NOT NULL,
  `field_size` varchar(15) NOT NULL DEFAULT '
0',
  `field_size_min` varchar(15) NOT NULL DEFAULT '
0',
  `required` int NOT NULL DEFAULT '
0',
  `match` varchar(255) NOT NULL DEFAULT '',
  `range` varchar(255) NOT NULL DEFAULT '',
  `error_message` varchar(255) NOT NULL DEFAULT '',
  `other_validator` varchar(5000) NOT NULL DEFAULT '',
  `default` varchar(255) NOT NULL DEFAULT '',
  `widget` varchar(255) NOT NULL DEFAULT '',
  `widgetparams` varchar(5000) NOT NULL DEFAULT '',
  `position` int NOT NULL DEFAULT '
0',
  `visible` int NOT NULL DEFAULT '
0',
  PRIMARY KEY (`id`),
  KEY `varname` (`varname`,`widget`,`visible`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `profiles_fields`
--

LOCK TABLES `profiles_fields` WRITE;
/*!40000 ALTER TABLE `profiles_fields` DISABLE KEYS */;
INSERT INTO `profiles_fields` VALUES (1,'lastname','Last Name','VARCHAR','
50','
3',1,'','','Incorrect Last Name (length between 3 and 50 characters).','','','','',1,3),(2,'firstname','First Name','VARCHAR','
50','
3',1,'','','Incorrect First Name (length between 3 and 50 characters).','','','','',0,3);
/*!40000 ALTER TABLE `profiles_fields` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `prov_for_income_tax`
--

DROP TABLE IF EXISTS `prov_for_income_tax`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `prov_for_income_tax` (
  `id` int NOT NULL AUTO_INCREMENT,
  `amount` double DEFAULT NULL,
  `start_date` date DEFAULT NULL,
  `end_date` date DEFAULT NULL,
  `created_by` int DEFAULT NULL,
  `created_time` datetime DEFAULT NULL,
  `updated_by` int DEFAULT NULL,
  `updated_time` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `prov_for_income_tax`
--

LOCK TABLES `prov_for_income_tax` WRITE;
/*!40000 ALTER TABLE `prov_for_income_tax` DISABLE KEYS */;
INSERT INTO `prov_for_income_tax` VALUES (1,17769262,'
2017-07-01
','2018-06-30
',1,'2020-04-06 14:38:23
',0,'0000-00-00 00:00:00
'),(2,41809211,'2018-07-01
','2019-06-30
',1,'2020-04-06 14:45:19
',1,'2020-04-07 16:38:00
');
/*!40000 ALTER TABLE `prov_for_income_tax` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `psm_log`
--

DROP TABLE IF EXISTS `psm_log`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `psm_log` (
  `log_id` int unsigned NOT NULL AUTO_INCREMENT,
  `server_id` int unsigned NOT NULL,
  `type` enum('status','email','sms','pushover') NOT NULL,
  `message` varchar(255) NOT NULL,
  `datetime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`log_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `psm_log`
--

LOCK TABLES `psm_log` WRITE;
/*!40000 ALTER TABLE `psm_log` DISABLE KEYS */;
/*!40000 ALTER TABLE `psm_log` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `psm_log_users`
--

DROP TABLE IF EXISTS `psm_log_users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `psm_log_users` (
  `log_id` int unsigned NOT NULL,
  `user_id` int unsigned NOT NULL,
  PRIMARY KEY (`log_id`,`user_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `psm_log_users`
--

LOCK TABLES `psm_log_users` WRITE;
/*!40000 ALTER TABLE `psm_log_users` DISABLE KEYS */;
/*!40000 ALTER TABLE `psm_log_users` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `purchase_order`
--

DROP TABLE IF EXISTS `purchase_order`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `purchase_order` (
  `id` int NOT NULL AUTO_INCREMENT,
  `order_type` tinyint NOT NULL DEFAULT '
1' COMMENT '
1=>PURCHASE, 2=>PURCHASE_RECEIVE',
  `date` date NOT NULL,
  `store_id` int DEFAULT NULL,
  `location_id` int DEFAULT NULL,
  `exp_receive_date` date DEFAULT NULL,
  `max_sl_no` int NOT NULL,
  `po_no` varchar(255) NOT NULL,
  `manual_po_no` varchar(255) DEFAULT NULL,
  `supplier_id` int NOT NULL,
  `total_amount` double NOT NULL,
  `vat_percentage` double DEFAULT '
0',
  `vat_amount` double NOT NULL DEFAULT '
0',
  `discount_percentage` double NOT NULL DEFAULT '
0',
  `discount` double NOT NULL DEFAULT '
0',
  `grand_total` double NOT NULL,
  `is_paid` tinyint(1) NOT NULL DEFAULT '
0',
  `is_all_received` tinyint(1) NOT NULL DEFAULT '
0',
  `order_note` text,
  `cash_due` tinyint NOT NULL,
  `ship_by` int DEFAULT NULL,
  `bill_to` text,
  `ship_to` text,
  `created_by` int DEFAULT NULL,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `updated_by` int DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `purchase_order`
--

LOCK TABLES `purchase_order` WRITE;
/*!40000 ALTER TABLE `purchase_order` DISABLE KEYS */;
INSERT INTO `purchase_order` VALUES (1,1,'
2022-07-20
',NULL,NULL,NULL,1,'PO-22-07-00001
',NULL,1,10020,5,501,0,0,10521,0,0,NULL,82,5,'','',1,'2022-07-20 23:00:25
',1,'2022-07-20 23:08:08
');
/*!40000 ALTER TABLE `purchase_order` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `purchase_order_details`
--

DROP TABLE IF EXISTS `purchase_order_details`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `purchase_order_details` (
  `id` int NOT NULL AUTO_INCREMENT,
  `order_id` int NOT NULL,
  `model_id` int NOT NULL,
  `qty` double NOT NULL,
  `unit_price` double NOT NULL,
  `note` text,
  `row_total` double NOT NULL,
  `is_all_received` tinyint(1) NOT NULL DEFAULT '0
',
  `created_by` int DEFAULT NULL,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `updated_by` int DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `purchase_order_details`
--

LOCK TABLES `purchase_order_details` WRITE;
/*!40000 ALTER TABLE `purchase_order_details` DISABLE KEYS */;
INSERT INTO `purchase_order_details` VALUES (1,1,22,20,1,'',20,0,1,'2022-07-20 23:00:25
',NULL,NULL),(2,1,20,5000,2,'',10000,0,1,'2022-07-20 23:00:25
',NULL,NULL);
/*!40000 ALTER TABLE `purchase_order_details` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `receive_purchase`
--

DROP TABLE IF EXISTS `receive_purchase`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `receive_purchase` (
  `id` int NOT NULL AUTO_INCREMENT,
  `date` date NOT NULL,
  `max_sl_no` int NOT NULL,
  `receive_no` varchar(255) NOT NULL,
  `supplier_memo_no` varchar(255) DEFAULT NULL,
  `supplier_memo_date` date DEFAULT NULL,
  `supplier_id` int NOT NULL,
  `purchase_order_id` int NOT NULL,
  `rcv_amount` double NOT NULL,
  `remarks` text,
  `created_by` int DEFAULT NULL,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `updated_by` int DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `receive_purchase`
--

LOCK TABLES `receive_purchase` WRITE;
/*!40000 ALTER TABLE `receive_purchase` DISABLE KEYS */;
INSERT INTO `receive_purchase` VALUES (1,'2022-07-20
',7,'RCV-22-07-00007
','',NULL,1,1,1,'',1,'2022-07-20 23:00:47
',1,'2022-07-20 23:00:47
'),(2,'2022-07-20
',7,'RCV-22-07-00007
','',NULL,1,1,1,'',1,'2022-07-20 23:07:54
',1,'2022-07-20 23:07:54
'),(3,'2022-07-20
',7,'RCV-22-07-00007
','',NULL,1,1,3,'',1,'2022-07-20 23:08:08
',1,'2022-07-20 23:08:08
');
/*!40000 ALTER TABLE `receive_purchase` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `receive_purchase_details`
--

DROP TABLE IF EXISTS `receive_purchase_details`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `receive_purchase_details` (
  `id` int NOT NULL AUTO_INCREMENT,
  `receive_purchase_id` int NOT NULL,
  `model_id` int NOT NULL,
  `qty` double NOT NULL,
  `unit_price` double NOT NULL,
  `row_total` double NOT NULL,
  `created_by` int DEFAULT NULL,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `updated_by` int DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `receive_purchase_details`
--

LOCK TABLES `receive_purchase_details` WRITE;
/*!40000 ALTER TABLE `receive_purchase_details` DISABLE KEYS */;
INSERT INTO `receive_purchase_details` VALUES (1,1,22,1,1,1,NULL,'2022-07-20 23:00:47
',NULL,NULL),(2,2,22,1,1,1,1,'2022-07-20 23:07:54
',NULL,NULL),(3,3,22,1,1,1,1,'2022-07-20 23:08:08
',NULL,NULL),(4,3,20,1,2,2,1,'2022-07-20 23:08:08
',NULL,NULL);
/*!40000 ALTER TABLE `receive_purchase_details` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `rights`
--

DROP TABLE IF EXISTS `rights`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `rights` (
  `itemname` varchar(64) NOT NULL,
  `type` int NOT NULL,
  `weight` int NOT NULL,
  PRIMARY KEY (`itemname`),
  CONSTRAINT `rights_ibfk_1` FOREIGN KEY (`itemname`) REFERENCES `authitem_old` (`name`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `rights`
--

LOCK TABLES `rights` WRITE;
/*!40000 ALTER TABLE `rights` DISABLE KEYS */;
/*!40000 ALTER TABLE `rights` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sell_delivery`
--

DROP TABLE IF EXISTS `sell_delivery`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `sell_delivery` (
  `id` int NOT NULL AUTO_INCREMENT,
  `sell_order_id` int NOT NULL,
  `date` date NOT NULL,
  `max_sl_no` int NOT NULL,
  `delivery_no` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `customer_id` int NOT NULL,
  `grand_total` double NOT NULL,
  `remarks` text CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci,
  `created_by` int DEFAULT NULL,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `updated_by` int DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sell_delivery`
--

LOCK TABLES `sell_delivery` WRITE;
/*!40000 ALTER TABLE `sell_delivery` DISABLE KEYS */;
INSERT INTO `sell_delivery` VALUES (1,5,'2022-07-17
',1,'CHALLAN-000001
',1,500,'',1,'2022-07-17 09:30:56
',1,'2022-07-17 09:30:56
'),(2,5,'2022-07-17
',2,'CHALLAN-000002
',1,500,'',1,'2022-07-17 09:34:25
',1,'2022-07-17 09:34:25
'),(3,5,'2022-07-17
',3,'CHALLAN-000003
',1,500,'',1,'2022-07-17 09:35:58
',1,'2022-07-17 09:35:58
'),(4,5,'2022-07-17
',4,'CHALLAN-000004
',1,500,'',1,'2022-07-17 09:37:39
',1,'2022-07-17 09:37:39
'),(5,5,'2022-07-17
',5,'CHALLAN-000005
',1,500,'',1,'2022-07-17 09:38:57
',1,'2022-07-17 09:38:57
'),(6,5,'2022-07-17
',6,'CHALLAN-000006
',1,5000,'',1,'2022-07-17 09:39:20
',1,'2022-07-17 09:39:20
');
/*!40000 ALTER TABLE `sell_delivery` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sell_delivery_details`
--

DROP TABLE IF EXISTS `sell_delivery_details`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `sell_delivery_details` (
  `id` int NOT NULL AUTO_INCREMENT,
  `sell_delivery_id` int NOT NULL,
  `model_id` int NOT NULL,
  `store_id` int DEFAULT NULL,
  `location_id` int DEFAULT NULL,
  `qty` double NOT NULL,
  `unit_price` double NOT NULL,
  `row_total` double NOT NULL,
  `created_by` int DEFAULT NULL,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `updated_by` int DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sell_delivery_details`
--

LOCK TABLES `sell_delivery_details` WRITE;
/*!40000 ALTER TABLE `sell_delivery_details` DISABLE KEYS */;
INSERT INTO `sell_delivery_details` VALUES (1,1,14,1,1,1,500,500,1,'2022-07-17 09:30:56
',NULL,NULL),(2,2,14,1,1,1,500,500,1,'2022-07-17 09:34:25
',NULL,NULL),(3,3,14,1,1,1,500,500,1,'2022-07-17 09:35:58
',NULL,NULL),(4,4,14,1,1,1,500,500,1,'2022-07-17 09:37:39
',NULL,NULL),(5,5,14,1,1,1,500,500,1,'2022-07-17 09:38:57
',NULL,NULL),(6,6,15,1,1,10,500,5000,1,'2022-07-17 09:39:20
',NULL,NULL);
/*!40000 ALTER TABLE `sell_delivery_details` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sell_order`
--

DROP TABLE IF EXISTS `sell_order`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `sell_order` (
  `id` int NOT NULL AUTO_INCREMENT,
  `order_type` tinyint NOT NULL DEFAULT '1
' COMMENT '1 => New, 2=>Repair',
  `customer_id` int NOT NULL,
  `date` date NOT NULL,
  `max_sl_no` int NOT NULL,
  `so_no` varchar(255) NOT NULL,
  `cash_due` int NOT NULL,
  `job_card_date` date DEFAULT NULL,
  `job_max_sl_no` int DEFAULT NULL,
  `job_no` varchar(255) DEFAULT NULL,
  `vat_percentage` double NOT NULL DEFAULT '
0',
  `vat_amount` double NOT NULL DEFAULT '
0',
  `bom_complete` tinyint NOT NULL DEFAULT '
2' COMMENT '
1=>complete, 2=>not complete',
  `exp_delivery_date` date DEFAULT NULL,
  `discount_percentage` double NOT NULL DEFAULT '
0',
  `discount_amount` double NOT NULL DEFAULT '
0',
  `total_amount` double NOT NULL COMMENT 'total amount without vat and discount',
  `grand_total` double NOT NULL,
  `order_note` text,
  `is_invoice_done` tinyint(1) NOT NULL DEFAULT '
0',
  `is_job_card_done` tinyint(1) NOT NULL DEFAULT '
0',
  `is_delivery_done` tinyint(1) NOT NULL DEFAULT '
0',
  `is_partial_delivery` tinyint(1) NOT NULL DEFAULT '
0',
  `is_partial_invoice` tinyint(1) NOT NULL DEFAULT '
0',
  `created_by` int DEFAULT NULL,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `updated_by` int DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sell_order`
--

LOCK TABLES `sell_order` WRITE;
/*!40000 ALTER TABLE `sell_order` DISABLE KEYS */;
INSERT INTO `sell_order` VALUES (1,1,1,'
2022-07-06
',1,'22-07-00001
',81,NULL,NULL,NULL,0,0,1,'2022-07-06
',0,0,900,900,NULL,0,0,0,0,0,1,'2022-07-06 09:29:33
',1,'2022-07-07 17:51:20
'),(2,1,1,'2022-07-06
',2,'22-07-00002
',81,NULL,NULL,NULL,10,550,1,NULL,0,0,5500,6050,'CHECK',0,0,0,0,0,1,'
2022-07-06 10:31:55
',1,'2022-07-07 16:36:31
'),(3,1,1,'2022-07-06
',3,'22-07-00003
',81,'2022-07-06
',1,'SO-JC-00001
',5,300,1,NULL,0,0,6000,6300,NULL,0,1,0,0,0,1,'2022-07-06 10:43:54
',1,'2022-07-07 10:07:59
'),(4,1,1,'2022-07-06
',4,'SO-22-07-00004
',81,NULL,NULL,NULL,0,0,1,NULL,0,0,200,200,NULL,0,0,0,0,0,1,'2022-07-06 14:09:31
',1,'2022-07-07 09:50:35
'),(5,1,1,'2022-07-07
',5,'SO-22-07-00005
',81,'2022-07-20
',3,'SO-JC-00003
',5,375,1,'2022-07-17
',0,0,7500,7875,'',0,1,1,1,1,1,'2022-07-07 17:52:24
',1,'2022-07-20 11:03:45
'),(6,1,2,'2022-07-19
',6,'SO-22-07-00006
',81,'2022-07-19
',2,'SO-JC-00002
',5,4000,1,'2022-07-19
',0,0,80000,84000,'DUMMY ORDER',0,1,0,0,0,1,'
2022-07-19 14:05:11
',1,'2022-07-20 11:04:02
');
/*!40000 ALTER TABLE `sell_order` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sell_order_bom`
--

DROP TABLE IF EXISTS `sell_order_bom`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `sell_order_bom` (
  `id` int NOT NULL AUTO_INCREMENT,
  `date` date NOT NULL,
  `sell_order_id` int NOT NULL,
  `max_sl_no` int NOT NULL,
  `bom_no` varchar(255) NOT NULL,
  `model_id` int NOT NULL,
  `qty` double NOT NULL,
  `created_by` int DEFAULT NULL,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `updated_by` int DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sell_order_bom`
--

LOCK TABLES `sell_order_bom` WRITE;
/*!40000 ALTER TABLE `sell_order_bom` DISABLE KEYS */;
INSERT INTO `sell_order_bom` VALUES (6,'2022-07-07
',2,19,'SO-BOM-22-07-00019
',22,50,1,'2022-07-07 16:23:27
',1,'2022-07-07 16:36:31
'),(7,'2022-07-07
',2,19,'SO-BOM-22-07-00019
',20,30,1,'2022-07-07 16:23:27
',1,'2022-07-07 16:36:31
'),(8,'2022-07-07
',2,19,'SO-BOM-22-07-00019
',21,100,1,'2022-07-07 16:23:27
',1,'2022-07-07 16:36:31
'),(9,'2022-07-07
',1,21,'SO-BOM-22-07-00021
',22,200,1,'2022-07-07 17:50:24
',1,'2022-07-07 17:51:20
'),(10,'2022-07-07
',1,21,'SO-BOM-22-07-00021
',20,50,1,'2022-07-07 17:50:24
',1,'2022-07-07 17:51:20
'),(11,'2022-07-07
',5,23,'SO-BOM-22-07-00023
',22,300,1,'2022-07-07 17:52:58
',1,'2022-07-07 17:53:04
'),(12,'2022-07-07
',5,23,'SO-BOM-22-07-00023
',20,50,1,'2022-07-07 17:52:58
',1,'2022-07-07 17:53:04
'),(13,'2022-07-07
',5,23,'SO-BOM-22-07-00023
',21,100,1,'2022-07-07 17:52:58
',1,'2022-07-07 17:53:04
'),(14,'2022-07-20
',6,24,'SO-BOM-22-07-00024
',22,325,1,'2022-07-20 11:04:02
',NULL,NULL),(15,'2022-07-20
',6,24,'SO-BOM-22-07-00024
',23,150,1,'2022-07-20 11:04:02
',NULL,NULL),(16,'2022-07-20
',6,24,'SO-BOM-22-07-00024
',20,25,1,'2022-07-20 11:04:02
',NULL,NULL),(17,'2022-07-20
',6,24,'SO-BOM-22-07-00024
',21,1750,1,'2022-07-20 11:04:02
',NULL,NULL);
/*!40000 ALTER TABLE `sell_order_bom` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sell_order_details`
--

DROP TABLE IF EXISTS `sell_order_details`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `sell_order_details` (
  `id` int NOT NULL AUTO_INCREMENT,
  `sell_order_id` int NOT NULL,
  `model_id` int NOT NULL,
  `qty` double NOT NULL,
  `amount` double NOT NULL,
  `row_total` double NOT NULL,
  `color` varchar(255) NOT NULL,
  `note` text,
  `is_delivery_done` tinyint(1) NOT NULL DEFAULT '0
',
  `is_invoice_done` tinyint(1) NOT NULL DEFAULT '0
',
  `created_by` int DEFAULT NULL,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `updated_by` int DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sell_order_details`
--

LOCK TABLES `sell_order_details` WRITE;
/*!40000 ALTER TABLE `sell_order_details` DISABLE KEYS */;
INSERT INTO `sell_order_details` VALUES (10,2,14,5,500,2500,'222
',NULL,0,0,1,'2022-07-07 12:13:25
',1,'2022-07-07 12:25:33
'),(11,2,5,6,500,3000,'55
',NULL,0,0,1,'2022-07-07 12:25:33
',NULL,NULL),(12,5,14,5,500,2500,'ABC','TEST NOTE',1,0,1,'
2022-07-07 17:52:24
',1,'2022-07-17 09:38:57
'),(13,5,15,10,500,5000,'5
','TEST NOTE',1,0,1,'
2022-07-07 17:52:24
',1,'2022-07-17 09:39:20
'),(14,6,14,5,5000,25000,'BLACK','ABC',0,0,1,'
2022-07-19 14:05:11
',NULL,NULL),(15,6,5,300,100,30000,'WHITE','DEF',0,0,1,'
2022-07-19 14:05:11
',NULL,NULL),(16,6,8,5,5000,25000,'XXX','XYZ',0,0,1,'
2022-07-19 14:05:11
',NULL,NULL);
/*!40000 ALTER TABLE `sell_order_details` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sell_price`
--

DROP TABLE IF EXISTS `sell_price`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `sell_price` (
  `id` int NOT NULL AUTO_INCREMENT,
  `model_id` int DEFAULT NULL,
  `sell_price` double DEFAULT NULL,
  `discount` double DEFAULT '0
',
  `ideal_qty` int DEFAULT NULL,
  `warn_qty` int DEFAULT NULL,
  `start_date` date DEFAULT NULL,
  `end_date` date DEFAULT NULL,
  `is_active` int DEFAULT NULL,
  `add_by` int DEFAULT NULL,
  `add_time` datetime DEFAULT NULL,
  `update_by` int DEFAULT NULL,
  `update_time` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`),
  KEY `FK_sell_price` (`model_id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sell_price`
--

LOCK TABLES `sell_price` WRITE;
/*!40000 ALTER TABLE `sell_price` DISABLE KEYS */;
INSERT INTO `sell_price` VALUES (1,1,5000,0,NULL,NULL,NULL,NULL,1,1,'2022-07-05 20:34:08
',NULL,NULL),(2,14,5000,0,NULL,NULL,NULL,NULL,1,1,'2022-07-14 10:51:15
',NULL,NULL);
/*!40000 ALTER TABLE `sell_price` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `shift_heads`
--

DROP TABLE IF EXISTS `shift_heads`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `shift_heads` (
  `id` int NOT NULL AUTO_INCREMENT,
  `title` varchar(255) DEFAULT NULL,
  `in_time` varchar(255) DEFAULT NULL,
  `out_time` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `shift_heads`
--

LOCK TABLES `shift_heads` WRITE;
/*!40000 ALTER TABLE `shift_heads` DISABLE KEYS */;
INSERT INTO `shift_heads` VALUES (3,'Night Shift','
21:00
','09:00
'),(4,'Day Shift','
09:00
','21:00
'),(5,'PACKING SHIFT','
08:00
','20:00
');
/*!40000 ALTER TABLE `shift_heads` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ship_by`
--

DROP TABLE IF EXISTS `ship_by`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `ship_by` (
  `id` int NOT NULL AUTO_INCREMENT,
  `ship_by` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ship_by`
--

LOCK TABLES `ship_by` WRITE;
/*!40000 ALTER TABLE `ship_by` DISABLE KEYS */;
INSERT INTO `ship_by` VALUES (1,'DHL'),(2,'Air Cargo'),(3,'By Hand'),(4,'Cover Van'),(5,'Hand'),(6,'Hand Carry'),(7,'BY CAR'),(8,'VAN CARY'),(9,'By Ship'),(10,'BY Sea'),(11,'By Air'),(12,'By Road');
/*!40000 ALTER TABLE `ship_by` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `stores`
--

DROP TABLE IF EXISTS `stores`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `stores` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `address` text,
  `created_by` int DEFAULT NULL,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `updated_by` int DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `stores`
--

LOCK TABLES `stores` WRITE;
/*!40000 ALTER TABLE `stores` DISABLE KEYS */;
INSERT INTO `stores` VALUES (1,'DEFAULT STORE','DEFAULT STORE',1,'
2022-07-13 21:10:21
',1,'2022-07-14 09:12:47
'),(2,'STORE 2
','',1,'2022-07-16 19:28:19
',NULL,NULL);
/*!40000 ALTER TABLE `stores` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `stuff_cat`
--

DROP TABLE IF EXISTS `stuff_cat`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `stuff_cat` (
  `id` int NOT NULL AUTO_INCREMENT,
  `title` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `stuff_cat`
--

LOCK TABLES `stuff_cat` WRITE;
/*!40000 ALTER TABLE `stuff_cat` DISABLE KEYS */;
INSERT INTO `stuff_cat` VALUES (3,'Part Time'),(4,'Full Time'),(5,'Daily Basis');
/*!40000 ALTER TABLE `stuff_cat` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `supplier_contact_persons`
--

DROP TABLE IF EXISTS `supplier_contact_persons`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `supplier_contact_persons` (
  `id` int NOT NULL AUTO_INCREMENT,
  `company_id` int DEFAULT NULL,
  `contact_person_name` varchar(255) DEFAULT NULL,
  `designation_id` int DEFAULT NULL,
  `contact_number1` varchar(20) DEFAULT NULL,
  `contact_number2` varchar(20) DEFAULT NULL,
  `contact_number3` varchar(20) DEFAULT NULL,
  `email` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_supplier_contact_persons` (`company_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `supplier_contact_persons`
--

LOCK TABLES `supplier_contact_persons` WRITE;
/*!40000 ALTER TABLE `supplier_contact_persons` DISABLE KEYS */;
/*!40000 ALTER TABLE `supplier_contact_persons` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `suppliers`
--

DROP TABLE IF EXISTS `suppliers`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `suppliers` (
  `id` int NOT NULL AUTO_INCREMENT,
  `company_name` varchar(255) DEFAULT NULL,
  `supplier_type` int DEFAULT NULL COMMENT 'From Lookup',
  `short_name` varchar(255) DEFAULT NULL,
  `company_address` text,
  `company_contact_no` varchar(255) DEFAULT NULL,
  `contact_number_2` varchar(20) DEFAULT NULL,
  `company_fax` varchar(20) DEFAULT NULL,
  `company_email` varchar(50) DEFAULT NULL,
  `company_web` varchar(50) DEFAULT NULL,
  `opening_amount` double DEFAULT '
0',
  `created_datetime` datetime DEFAULT CURRENT_TIMESTAMP,
  `created_by` int DEFAULT NULL,
  `updated_datetime` datetime DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  `updated_by` int DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `suppliers`
--

LOCK TABLES `suppliers` WRITE;
/*!40000 ALTER TABLE `suppliers` DISABLE KEYS */;
INSERT INTO `suppliers` VALUES (1,'RAIHAN',NULL,NULL,'
245/1
','015000000
','0159000000
','','raihan@gmail.com','www.raihan.com',0,'
2022-07-14 15:01:30
',1,'2022-07-16 10:15:42
',1);
/*!40000 ALTER TABLE `suppliers` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `units`
--

DROP TABLE IF EXISTS `units`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `units` (
  `id` int NOT NULL AUTO_INCREMENT,
  `label` varchar(50) NOT NULL,
  `value` double DEFAULT NULL,
  `remarks` text,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `units`
--

LOCK TABLES `units` WRITE;
/*!40000 ALTER TABLE `units` DISABLE KEYS */;
INSERT INTO `units` VALUES (1,'PCS',0,''),(2,'SET',0,''),(4,'KG',0,''),(5,'Dozen',0,''),(6,'ltr.',0,''),(7,'PERSON',0,''),(8,'PACKAGE',0,''),(9,'Feet',NULL,NULL),(10,'gm',NULL,NULL);
/*!40000 ALTER TABLE `units` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `users` (
  `id` int NOT NULL AUTO_INCREMENT,
  `employee_id` int DEFAULT NULL,
  `usersroll_id` int DEFAULT NULL,
  `uniq_id` varchar(255) DEFAULT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `email` varchar(128) DEFAULT NULL,
  `activkey` varchar(128) DEFAULT NULL,
  `lastvisit_at` timestamp NULL DEFAULT '
0000-00-00 00:00:00
',
  `superuser` int NOT NULL DEFAULT '0
',
  `is_active` tinyint NOT NULL DEFAULT '1
',
  `status` tinyint(1) NOT NULL DEFAULT '0
',
  `store_id` int DEFAULT NULL,
  `create_by` varchar(255) DEFAULT NULL,
  `create_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `create_time` datetime DEFAULT NULL,
  `update_by` varchar(255) DEFAULT NULL,
  `update_time` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (1,1,46,'','superadmin','17c4520f6cfd1ab53d8745e84681eb49','','','
0000-00-00 00:00:00
',1,1,1,NULL,'','2020-01-29 05:08:46
','0000-00-00 00:00:00
','superadmin','
2019-12-22 12:20:49
');
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users_token`
--

DROP TABLE IF EXISTS `users_token`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `users_token` (
  `id` int NOT NULL AUTO_INCREMENT,
  `users_id` int DEFAULT NULL,
  `token` varchar(255) DEFAULT NULL,
  `last_login_time` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users_token`
--

LOCK TABLES `users_token` WRITE;
/*!40000 ALTER TABLE `users_token` DISABLE KEYS */;
INSERT INTO `users_token` VALUES (2,2,'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJuYW1lIjoiYWRtaW4iLCJ1c2VyX2lkIjoiMiJ9.oVluAWk6rbA2dKv6VuM9Fcw1c2setzMqnOf-OM7S76g','
2019-11-06 10:20:58
'),(3,1,'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJuYW1lIjoic3VwZXJhZG1pbiIsInVzZXJfaWQiOiIxIn0.PRSwvu4Cakt06_KIJEk1nRN7QfPwPUIGuTo-mIzNJtc','
2019-11-12 15:43:03
'),(4,12,'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJuYW1lIjoiZHJpdmVyIiwidXNlcl9pZCI6IjEyIn0.HVNMWyn_oT_y2kYmUmrBnErBrSl-IEOpCvwPEDuUEWo','
2019-10-13 10:46:21
'),(5,11,'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJuYW1lIjoidXNlciIsInVzZXJfaWQiOiIxMSJ9.DFYs1J8lK1xOztocpG9utiNz27ta0bU06ug1Sbb6_sw','
2019-09-28 15:17:49
'),(6,16,'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJuYW1lIjoidXNlcjIiLCJ1c2VyX2lkIjoiMTYifQ.Qk8tKC2KjVXMKASXRKf_yz6FHUpbMqiWcunG10w8xPo','
0000-00-00 00:00:00
'),(7,18,'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJuYW1lIjoiZHJpdmVyMiIsInVzZXJfaWQiOiIxOCJ9.KTDUETvJUqe7WkaEAtn1Dvyr-5kKW1kvKMbRisYl8T0','
0000-00-00 00:00:00
'),(8,19,'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJuYW1lIjoiZHJpdmVyMyIsInVzZXJfaWQiOiIxOSJ9.MPcU9yqJmCtCLn65MELEUwC3Ql0eV3ia9--eMw9C6_E','0000-00-00 00:00:00'),(9,20,'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJuYW1lIjoiZHJpdmVyNCIsInVzZXJfaWQiOiIyMCJ9.6A57bGOOI_n25cFPecBtWsfoa2r-_VR-Atz249rmbPo','0000-00-00 00:00:00'),(10,1,'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJuYW1lIjoic3VwZXJhZG1pbiIsInVzZXJfaWQiOiIxIn0.0kaQAZqY08YVdvtgDpcibOvEJGJug6hqrzCVZJf6w0Q','2019-11-30 14:54:04');
/*!40000 ALTER TABLE `users_token` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `voucher_no_formate`
--

DROP TABLE IF EXISTS `voucher_no_formate`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `voucher_no_formate` (
  `id` int NOT NULL AUTO_INCREMENT,
  `type` int DEFAULT NULL,
  `type_format` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `voucher_no_formate`
--

LOCK TABLES `voucher_no_formate` WRITE;
/*!40000 ALTER TABLE `voucher_no_formate` DISABLE KEYS */;
INSERT INTO `voucher_no_formate` VALUES (1,27,'PO'),(2,28,'SO'),(3,29,'INV'),(4,31,'CHALLAN'),(5,32,'RV'),(10,144,'MQ'),(11,151,'JBC'),(12,33,'SL');
/*!40000 ALTER TABLE `voucher_no_formate` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `voucher_no_formate_ac`
--

DROP TABLE IF EXISTS `voucher_no_formate_ac`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `voucher_no_formate_ac` (
  `id` int NOT NULL AUTO_INCREMENT,
  `type` int DEFAULT NULL,
  `type_format` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `voucher_no_formate_ac`
--

LOCK TABLES `voucher_no_formate_ac` WRITE;
/*!40000 ALTER TABLE `voucher_no_formate_ac` DISABLE KEYS */;
INSERT INTO `voucher_no_formate_ac` VALUES (6,7,'JV#'),(7,8,'CO#'),(8,9,'RV#'),(9,10,'PV#');
/*!40000 ALTER TABLE `voucher_no_formate_ac` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `your_company`
--

DROP TABLE IF EXISTS `your_company`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `your_company` (
  `id` int NOT NULL AUTO_INCREMENT,
  `company_name` varchar(255) DEFAULT NULL,
  `location` varchar(255) DEFAULT NULL,
  `road` varchar(255) DEFAULT NULL,
  `house` varchar(255) DEFAULT NULL,
  `contact` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `web` varchar(255) DEFAULT NULL,
  `vat_regi_no` varchar(255) DEFAULT NULL,
  `tin` varchar(255) DEFAULT NULL,
  `trn_no` varchar(255) DEFAULT NULL,
  `opening_vat` double DEFAULT NULL,
  `opening_sd` double DEFAULT NULL,
  `previous_month_vat` double DEFAULT NULL,
  `previous_month_sd` double DEFAULT NULL,
  `registration_nature` int DEFAULT NULL,
  `registration_criteria` int DEFAULT NULL,
  `business_type` int DEFAULT NULL,
  `business_process` int DEFAULT NULL,
  `company_vat_type` tinyint DEFAULT NULL,
  `company_sales_vat` double DEFAULT NULL,
  `is_active` int DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `your_company`
--

LOCK TABLES `your_company` WRITE;
/*!40000 ALTER TABLE `your_company` DISABLE KEYS */;
INSERT INTO `your_company` VALUES (4,'DHAKA THAI LIMITED','Ashulia, Savar, Dhaka','Burirpara','Eastnorsinghapur','01747638340','dtlshahidullah@gmail.com','http://WWW.MAXXALUMINIUM.COM','000248178-0403','861566184319',NULL,0,0,0,0,1,1,2,1,1,15,1);
/*!40000 ALTER TABLE `your_company` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2022-07-23 12:45:45
