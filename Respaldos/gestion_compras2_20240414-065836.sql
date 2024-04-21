-- MariaDB dump 10.19  Distrib 10.4.32-MariaDB, for Win64 (AMD64)
--
-- Host: localhost    Database: gestion_compras2
-- ------------------------------------------------------
-- Server version	10.4.32-MariaDB

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
-- Table structure for table `auditoria_tbl_ms_usuario`
--

DROP TABLE IF EXISTS `auditoria_tbl_ms_usuario`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `auditoria_tbl_ms_usuario` (
  `id_auditoria` int(11) NOT NULL AUTO_INCREMENT,
  `tipo_operacion` varchar(20) DEFAULT NULL,
  `fecha_operacion` timestamp NULL DEFAULT current_timestamp(),
  `id_usuario_operacion` int(11) DEFAULT NULL,
  `nombre_usuario_afectado` varchar(100) NOT NULL,
  `nombre_usuario_operacion` varchar(100) DEFAULT NULL,
  `tabla_afectada` varchar(100) NOT NULL,
  `id_usuario_afectado` int(11) DEFAULT NULL,
  `detalle_anterior` text DEFAULT NULL,
  `detalle_posterior` text DEFAULT NULL,
  PRIMARY KEY (`id_auditoria`)
) ENGINE=InnoDB AUTO_INCREMENT=52 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `auditoria_tbl_ms_usuario`
--

LOCK TABLES `auditoria_tbl_ms_usuario` WRITE;
/*!40000 ALTER TABLE `auditoria_tbl_ms_usuario` DISABLE KEYS */;
INSERT INTO `auditoria_tbl_ms_usuario` VALUES (1,'INSERT','2024-03-20 07:32:23',NULL,'LIZETH','root@localhost','tbl_ms_usuario',163,NULL,'Nuevo usuario creado: LIZETH'),(2,'UPDATE','2024-03-20 07:35:39',NULL,'LISSETH','','tbl_ms_usuario',163,'Detalle antes de la actualización: LIZETH','Detalle después de la actualización: LISSETH'),(3,'DELETE','2024-03-20 07:37:29',NULL,'LISSETH','','tbl_ms_usuario',163,'Detalle antes de la eliminación: LISSETH',NULL),(4,'INSERT','2024-03-20 07:41:46',NULL,'LISSETH','root@localhost','tbl_ms_usuario',164,NULL,'Nuevo usuario creado: LISSETH'),(5,'INSERT','2024-04-07 02:26:22',NULL,'KENYON','root@localhost','tbl_ms_usuario',165,NULL,'Nuevo usuario creado: KENYON'),(6,'UPDATE','2024-04-07 02:40:39',NULL,'KENYON','','tbl_ms_usuario',165,'Detalle antes de la actualización: KENYON','Detalle después de la actualización: KENYON'),(7,'UPDATE','2024-04-07 02:40:39',NULL,'KENYON','','tbl_ms_usuario',165,'Detalle antes de la actualización: KENYON','Detalle después de la actualización: KENYON'),(8,'UPDATE','2024-04-07 03:52:12',NULL,'LUISA','','tbl_ms_usuario',152,'Detalle antes de la actualización: LUIS','Detalle después de la actualización: LUISA'),(9,'INSERT','2024-04-07 04:14:08',NULL,'RONY',NULL,'tbl_ms_usuario',170,NULL,'Nuevo usuario creado: RONY'),(10,'INSERT','2024-04-07 04:58:03',NULL,'ALICIA',NULL,'tbl_ms_usuario',174,NULL,'Nuevo usuario creado: ALICIA'),(11,'INSERT','2024-04-07 05:01:57',NULL,'ANA',NULL,'tbl_ms_usuario',175,NULL,'Nuevo usuario creado: ANA'),(12,'UPDATE','2024-04-07 05:03:21',NULL,'KENYON',NULL,'tbl_ms_usuario',165,'Detalle antes de la actualización: KENYON','Detalle después de la actualización: KENYON'),(13,'UPDATE','2024-04-07 05:03:41',NULL,'KENYO',NULL,'tbl_ms_usuario',151,'Detalle antes de la actualización: KENYO','Detalle después de la actualización: KENYO'),(14,'UPDATE','2024-04-07 05:05:28',NULL,'KENYO',NULL,'tbl_ms_usuario',151,'Detalle antes de la actualización: KENYO','Detalle después de la actualización: KENYO'),(15,'UPDATE','2024-04-07 05:06:42',NULL,'KENYON',NULL,'tbl_ms_usuario',165,'Detalle antes de la actualización: KENYON','Detalle después de la actualización: KENYON'),(16,'INSERT','2024-04-11 20:43:41',NULL,'LIZETH',NULL,'tbl_ms_usuario',176,NULL,'Nuevo usuario creado: LIZETH'),(17,'UPDATE','2024-04-11 20:44:28',NULL,'LIZETH',NULL,'tbl_ms_usuario',176,'Detalle antes de la actualización: LIZETH','Detalle después de la actualización: LIZETH'),(18,'UPDATE','2024-04-11 20:44:28',NULL,'LIZETH',NULL,'tbl_ms_usuario',176,'Detalle antes de la actualización: LIZETH','Detalle después de la actualización: LIZETH'),(19,'UPDATE','2024-04-11 20:48:26',NULL,'LIZETH',NULL,'tbl_ms_usuario',176,'Detalle antes de la actualización: LIZETH','Detalle después de la actualización: LIZETH'),(20,'UPDATE','2024-04-11 20:55:38',NULL,'LIZETH',NULL,'tbl_ms_usuario',176,'Detalle antes de la actualización: LIZETH','Detalle después de la actualización: LIZETH'),(21,'UPDATE','2024-04-11 20:55:49',NULL,'LIZETH',NULL,'tbl_ms_usuario',176,'Detalle antes de la actualización: LIZETH','Detalle después de la actualización: LIZETH'),(22,'UPDATE','2024-04-11 20:56:01',NULL,'LIZETH',NULL,'tbl_ms_usuario',176,'Detalle antes de la actualización: LIZETH','Detalle después de la actualización: LIZETH'),(23,'UPDATE','2024-04-11 20:57:46',NULL,'LIZETH',NULL,'tbl_ms_usuario',176,'Detalle antes de la actualización: LIZETH','Detalle después de la actualización: LIZETH'),(24,'UPDATE','2024-04-11 20:57:56',NULL,'LIZETH',NULL,'tbl_ms_usuario',176,'Detalle antes de la actualización: LIZETH','Detalle después de la actualización: LIZETH'),(25,'UPDATE','2024-04-11 21:21:23',NULL,'LIZETH',NULL,'tbl_ms_usuario',176,'Detalle antes de la actualización: LIZETH','Detalle después de la actualización: LIZETH'),(26,'UPDATE','2024-04-11 21:26:22',NULL,'LIZETH',NULL,'tbl_ms_usuario',176,'Detalle antes de la actualización: LIZETH','Detalle después de la actualización: LIZETH'),(27,'UPDATE','2024-04-11 21:29:47',NULL,'LIZETH',NULL,'tbl_ms_usuario',176,'Detalle antes de la actualización: LIZETH','Detalle después de la actualización: LIZETH'),(28,'UPDATE','2024-04-11 22:46:25',NULL,'LIZETH',NULL,'tbl_ms_usuario',176,'Detalle antes de la actualización: LIZETH','Detalle después de la actualización: LIZETH'),(29,'UPDATE','2024-04-11 22:50:36',NULL,'LIZETH',NULL,'tbl_ms_usuario',176,'Detalle antes de la actualización: LIZETH','Detalle después de la actualización: LIZETH'),(30,'UPDATE','2024-04-11 22:56:04',NULL,'LIZETH',NULL,'tbl_ms_usuario',176,'Detalle antes de la actualización: LIZETH','Detalle después de la actualización: LIZETH'),(31,'UPDATE','2024-04-12 00:04:54',NULL,'LIZETH',NULL,'tbl_ms_usuario',176,'Detalle antes de la actualización: LIZETH','Detalle después de la actualización: LIZETH'),(32,'UPDATE','2024-04-12 04:09:11',NULL,'LIZETH',NULL,'tbl_ms_usuario',176,'Detalle antes de la actualización: LIZETH','Detalle después de la actualización: LIZETH'),(33,'UPDATE','2024-04-12 04:38:21',NULL,'LIZETH',NULL,'tbl_ms_usuario',176,'Detalle antes de la actualización: LIZETH','Detalle después de la actualización: LIZETH'),(34,'UPDATE','2024-04-12 04:39:49',NULL,'LISSETH',NULL,'tbl_ms_usuario',164,'Detalle antes de la actualización: LISSETH','Detalle después de la actualización: LISSETH'),(35,'UPDATE','2024-04-12 04:43:08',NULL,'LIZETH',NULL,'tbl_ms_usuario',176,'Detalle antes de la actualización: LIZETH','Detalle después de la actualización: LIZETH'),(36,'UPDATE','2024-04-12 04:44:15',NULL,'LIZETH',NULL,'tbl_ms_usuario',176,'Detalle antes de la actualización: LIZETH','Detalle después de la actualización: LIZETH'),(37,'UPDATE','2024-04-12 04:46:37',NULL,'LIZETH',NULL,'tbl_ms_usuario',176,'Detalle antes de la actualización: LIZETH','Detalle después de la actualización: LIZETH'),(38,'UPDATE','2024-04-12 04:51:34',NULL,'LIZETH',NULL,'tbl_ms_usuario',176,'Detalle antes de la actualización: LIZETH','Detalle después de la actualización: LIZETH'),(39,'UPDATE','2024-04-12 04:52:03',NULL,'LIZETH',NULL,'tbl_ms_usuario',176,'Detalle antes de la actualización: LIZETH','Detalle después de la actualización: LIZETH'),(40,'UPDATE','2024-04-12 04:52:27',NULL,'LIZETH',NULL,'tbl_ms_usuario',176,'Detalle antes de la actualización: LIZETH','Detalle después de la actualización: LIZETH'),(41,'UPDATE','2024-04-12 04:53:15',NULL,'LIZETH',NULL,'tbl_ms_usuario',176,'Detalle antes de la actualización: LIZETH','Detalle después de la actualización: LIZETH'),(42,'UPDATE','2024-04-12 04:55:38',NULL,'LIZETH',NULL,'tbl_ms_usuario',176,'Detalle antes de la actualización: LIZETH','Detalle después de la actualización: LIZETH'),(43,'UPDATE','2024-04-12 04:56:54',NULL,'LIZETH',NULL,'tbl_ms_usuario',176,'Detalle antes de la actualización: LIZETH','Detalle después de la actualización: LIZETH'),(44,'UPDATE','2024-04-12 04:59:22',NULL,'LIZETH',NULL,'tbl_ms_usuario',176,'Detalle antes de la actualización: LIZETH','Detalle después de la actualización: LIZETH'),(45,'UPDATE','2024-04-12 04:59:42',NULL,'LIZETH',NULL,'tbl_ms_usuario',176,'Detalle antes de la actualización: LIZETH','Detalle después de la actualización: LIZETH'),(46,'UPDATE','2024-04-12 05:01:09',NULL,'LIZETH',NULL,'tbl_ms_usuario',176,'Detalle antes de la actualización: LIZETH','Detalle después de la actualización: LIZETH'),(47,'UPDATE','2024-04-12 05:03:12',NULL,'LIZETH',NULL,'tbl_ms_usuario',176,'Detalle antes de la actualización: LIZETH','Detalle después de la actualización: LIZETH'),(48,'UPDATE','2024-04-12 05:12:53',NULL,'LIZETH',NULL,'tbl_ms_usuario',176,'Detalle antes de la actualización: LIZETH','Detalle después de la actualización: LIZETH'),(49,'UPDATE','2024-04-13 02:08:58',NULL,'LIZETH',NULL,'tbl_ms_usuario',176,'Detalle antes de la actualización: LIZETH','Detalle después de la actualización: LIZETH'),(50,'UPDATE','2024-04-13 02:12:26',NULL,'LIZETH',NULL,'tbl_ms_usuario',176,'Detalle antes de la actualización: LIZETH','Detalle después de la actualización: LIZETH'),(51,'UPDATE','2024-04-13 02:12:48',NULL,'LIZETH',NULL,'tbl_ms_usuario',176,'Detalle antes de la actualización: LIZETH','Detalle después de la actualización: LIZETH');
/*!40000 ALTER TABLE `auditoria_tbl_ms_usuario` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tbl_categorias`
--

DROP TABLE IF EXISTS `tbl_categorias`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_categorias` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `categoria` varchar(50) NOT NULL,
  `creado` varchar(50) NOT NULL,
  `fecha_creacion` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `fecha_modificacion` timestamp NOT NULL DEFAULT current_timestamp(),
  `modificado` varchar(30) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_categorias`
--

LOCK TABLES `tbl_categorias` WRITE;
/*!40000 ALTER TABLE `tbl_categorias` DISABLE KEYS */;
INSERT INTO `tbl_categorias` VALUES (8,'insumos','kenyo','2024-01-09 20:15:49','2024-01-09 06:00:00','KENYO'),(9,'SERVICIOS','ADMIN','2023-12-02 06:00:00','2023-12-02 03:39:19',''),(10,'linea blanca','admin','2024-01-02 06:00:00','2024-01-02 18:39:26','');
/*!40000 ALTER TABLE `tbl_categorias` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tbl_compra_cai`
--

DROP TABLE IF EXISTS `tbl_compra_cai`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_compra_cai` (
  `ID_COMPRA_CAI` int(11) NOT NULL AUTO_INCREMENT,
  `ID_EMPRESA` int(11) NOT NULL,
  `ID_ORDEN_COMPRA` int(11) NOT NULL,
  `ID_LOTE_CAI` int(11) NOT NULL,
  `TIPO_RECIBO` varchar(100) NOT NULL,
  `CAI` varchar(100) NOT NULL,
  `FECHA_FACTURA_PROVEEDOR` varchar(15) NOT NULL,
  `FACTURA_REGIMEN` date NOT NULL,
  `SECUENCIA_REGIMEN` varchar(100) NOT NULL,
  `ESTADO_FACTURA` tinyint(1) NOT NULL DEFAULT 0,
  `FECHA_ANULACION` date NOT NULL,
  PRIMARY KEY (`ID_COMPRA_CAI`),
  KEY `ID_EMPRESA` (`ID_EMPRESA`),
  KEY `ID_ORDEN_COMPRA` (`ID_ORDEN_COMPRA`),
  KEY `ID_LOTE_CAI` (`ID_LOTE_CAI`),
  CONSTRAINT `tbl_compra_cai_ibfk_1` FOREIGN KEY (`ID_EMPRESA`) REFERENCES `tbl_empresa` (`id_empresa`),
  CONSTRAINT `tbl_compra_cai_ibfk_2` FOREIGN KEY (`ID_ORDEN_COMPRA`) REFERENCES `tbl_orden_compra` (`ID_ORDEN_COMPRA`),
  CONSTRAINT `tbl_compra_cai_ibfk_3` FOREIGN KEY (`ID_LOTE_CAI`) REFERENCES `tbl_lotes_proveedores_cai` (`ID_LOTE_CAI`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_compra_cai`
--

LOCK TABLES `tbl_compra_cai` WRITE;
/*!40000 ALTER TABLE `tbl_compra_cai` DISABLE KEYS */;
/*!40000 ALTER TABLE `tbl_compra_cai` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tbl_contactos_proveedores`
--

DROP TABLE IF EXISTS `tbl_contactos_proveedores`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_contactos_proveedores` (
  `ID_CONTACTO_PROVEEDOR` int(11) NOT NULL AUTO_INCREMENT,
  `ID_PROVEEDOR` int(11) NOT NULL,
  `NOMBRE` varchar(30) DEFAULT NULL,
  `CARGO` varchar(45) DEFAULT NULL,
  `ESTADO` varchar(200) DEFAULT NULL,
  `CREADO_POR` varchar(15) DEFAULT NULL,
  `FECHA_CREACION` timestamp NOT NULL DEFAULT current_timestamp(),
  `MODIFICADO_POR` varchar(15) DEFAULT NULL,
  `FECHA_MODIFICACION` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`ID_CONTACTO_PROVEEDOR`),
  KEY `tbl_contactos_proveedores_ibfk_1` (`ID_PROVEEDOR`),
  CONSTRAINT `tbl_contactos_proveedores_ibfk_1` FOREIGN KEY (`ID_PROVEEDOR`) REFERENCES `tbl_proveedores` (`ID_PROVEEDOR`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_contactos_proveedores`
--

LOCK TABLES `tbl_contactos_proveedores` WRITE;
/*!40000 ALTER TABLE `tbl_contactos_proveedores` DISABLE KEYS */;
INSERT INTO `tbl_contactos_proveedores` VALUES (4,29,'LARACH','GERENTE','A',NULL,'2023-12-01 21:22:13',NULL,'2023-12-01 21:22:13');
/*!40000 ALTER TABLE `tbl_contactos_proveedores` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tbl_cotizacion`
--

DROP TABLE IF EXISTS `tbl_cotizacion`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_cotizacion` (
  `ID_COTIZACION` int(11) NOT NULL AUTO_INCREMENT,
  `ID` int(11) DEFAULT NULL,
  `ID_PROVEEDOR` int(11) DEFAULT NULL,
  `NUMERO_COTIZACION` varchar(20) DEFAULT NULL,
  `DEPARTAMENTO` varchar(100) NOT NULL,
  `FECHA_COTIZACION` date DEFAULT NULL,
  `ESTADO` varchar(255) NOT NULL,
  `URL` varchar(255) NOT NULL,
  `FECHA_CREACION` timestamp NOT NULL DEFAULT current_timestamp(),
  `FECHA_MODIFICACION` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `CREADO_POR` varchar(255) DEFAULT NULL,
  `MODIFICADO_POR` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`ID_COTIZACION`),
  KEY `ID_PROVEEDOR` (`ID_PROVEEDOR`),
  KEY `tbl_solicitudes_tbl_cotizacion` (`ID`),
  CONSTRAINT `tbl_cotizacion_ibfk_1` FOREIGN KEY (`ID_PROVEEDOR`) REFERENCES `tbl_proveedores` (`ID_PROVEEDOR`)
) ENGINE=InnoDB AUTO_INCREMENT=110 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_cotizacion`
--

LOCK TABLES `tbl_cotizacion` WRITE;
/*!40000 ALTER TABLE `tbl_cotizacion` DISABLE KEYS */;
INSERT INTO `tbl_cotizacion` VALUES (105,111,23,'1234','CONTABILIDAD','2023-12-18','Aprobada','http://localhost/Gestionmain/cotizaciones/add_cotizacion.php?id=111','2023-12-18 22:07:55','2024-01-27 15:51:47',NULL,NULL),(106,112,23,'234','CONTABILIDAD','2023-12-18','Aprobada','http://localhost/Gestionmain/cotizaciones/add_cotizacion.php?id=112','2023-12-18 22:13:04','2023-12-18 22:13:16',NULL,NULL),(107,113,26,'165','CONTABILIDAD','2023-12-19','Aprobada','http://localhost/Gestionmain/cotizaciones/add_cotizacion.php?id=113','2023-12-19 17:37:03','2023-12-19 17:37:09',NULL,NULL),(108,116,23,'','CONTABILIDAD','0000-00-00','P','ffffff','2024-03-22 01:09:07','2024-03-22 01:09:07',NULL,NULL),(109,117,26,'352865','CONTABILIDAD','2024-04-05','P','https://www.google.com/search?sca_esv=5bdfde399b30e227&rlz=1C1CHBF_esHN1046HN1046&sxsrf=ACQVn0_R-E4Z1vyUxm9iAoKCjCpKY56MKg:1712290608108&q=El+Poder+Del+Metabolismo&stick=H4sIAAAAAAAAAONgVeLRT9c3NErKNco2Nco2EszJTCrKV0hJVUgtLkg8vDE_5xQjL0iFYUG8WVlSSkoRjF-WY','2024-04-05 04:17:30','2024-04-05 04:17:30',NULL,NULL);
/*!40000 ALTER TABLE `tbl_cotizacion` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tbl_cotizacion_detalle`
--

DROP TABLE IF EXISTS `tbl_cotizacion_detalle`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_cotizacion_detalle` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `ID_COTIZACION` int(11) NOT NULL,
  `CANTIDAD` varchar(255) NOT NULL,
  `DESCRIPCION` varchar(255) NOT NULL,
  `ID_CATEGORIA` int(11) NOT NULL,
  PRIMARY KEY (`ID`),
  KEY `tbl_cotizacion_tbl_cotizacion_detalle` (`ID_COTIZACION`),
  KEY `tbl_categorias_tbl_cotizacion_detalle` (`ID_CATEGORIA`),
  CONSTRAINT `tbl_categorias_tbl_cotizacion_detalle` FOREIGN KEY (`ID_CATEGORIA`) REFERENCES `tbl_categorias` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `tbl_cotizacion_tbl_cotizacion_detalle` FOREIGN KEY (`ID_COTIZACION`) REFERENCES `tbl_cotizacion` (`ID_COTIZACION`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_cotizacion_detalle`
--

LOCK TABLES `tbl_cotizacion_detalle` WRITE;
/*!40000 ALTER TABLE `tbl_cotizacion_detalle` DISABLE KEYS */;
INSERT INTO `tbl_cotizacion_detalle` VALUES (7,105,'2','papel',8),(8,106,'2','fumigación. ',9),(9,107,'3','Cartulina.',8),(10,107,'5','lápiz grafito',8),(11,108,'1','Fumigacion',9),(12,109,'60','Libros de matemáticas para segundo grado',8),(13,109,'80','Libros de español para segundo grado',8);
/*!40000 ALTER TABLE `tbl_cotizacion_detalle` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tbl_cuenta_proveedor`
--

DROP TABLE IF EXISTS `tbl_cuenta_proveedor`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_cuenta_proveedor` (
  `ID_CUENTA_PROVEEDOR` int(11) NOT NULL AUTO_INCREMENT,
  `NUMERO_CUENTA` varchar(20) DEFAULT NULL,
  `BANCO` varchar(50) DEFAULT NULL,
  `DESCRIPCION_CUENTA` text DEFAULT NULL,
  `FECHA_CREACION` timestamp NOT NULL DEFAULT current_timestamp(),
  `FECHA_MODIFICACION` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `ID_PROVEEDOR` int(11) DEFAULT NULL,
  PRIMARY KEY (`ID_CUENTA_PROVEEDOR`),
  KEY `fk_tbl_proveedores_tbl_cuenta_proveedor` (`ID_PROVEEDOR`) USING BTREE,
  CONSTRAINT `fk_tbl_proveedores_tbl_cuenta_proveedor` FOREIGN KEY (`ID_PROVEEDOR`) REFERENCES `tbl_proveedores` (`ID_PROVEEDOR`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_cuenta_proveedor`
--

LOCK TABLES `tbl_cuenta_proveedor` WRITE;
/*!40000 ALTER TABLE `tbl_cuenta_proveedor` DISABLE KEYS */;
INSERT INTO `tbl_cuenta_proveedor` VALUES (12,'20909','OCCIDENTE','CHEQUES','2023-11-30 23:40:17','2023-11-30 23:40:17',23),(15,'345','ficohsa','ahorro','2023-12-01 15:52:44','2023-12-01 15:52:44',26),(17,'23456','BAMER','cheque','2023-12-01 21:21:49','2023-12-01 21:21:49',29);
/*!40000 ALTER TABLE `tbl_cuenta_proveedor` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tbl_departamentos`
--

DROP TABLE IF EXISTS `tbl_departamentos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_departamentos` (
  `id_departamento` int(11) NOT NULL AUTO_INCREMENT,
  `id_empresa` int(11) NOT NULL,
  `nombre_departamento` varchar(50) NOT NULL,
  `estado_departamento` varchar(50) NOT NULL,
  `creado` varchar(50) NOT NULL,
  `fecha_creacion` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `fecha_modificacion` timestamp NOT NULL DEFAULT current_timestamp(),
  `modificado_por` varchar(30) NOT NULL,
  PRIMARY KEY (`id_departamento`),
  KEY `fk_tbl_empresa_id_empresa_tbl_departamentos` (`id_empresa`),
  CONSTRAINT `fk_tbl_empresa_id_empresa_tbl_departamentos` FOREIGN KEY (`id_empresa`) REFERENCES `tbl_empresa` (`id_empresa`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_departamentos`
--

LOCK TABLES `tbl_departamentos` WRITE;
/*!40000 ALTER TABLE `tbl_departamentos` DISABLE KEYS */;
INSERT INTO `tbl_departamentos` VALUES (7,3,'CONTABILIDAD','A','KENYO','2024-01-16 22:56:22','2024-01-17 05:56:22','k'),(8,3,'Tecnologia','I','kenyo','2024-01-16 23:04:14','2024-01-17 06:04:14','luis');
/*!40000 ALTER TABLE `tbl_departamentos` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tbl_direcciones_proveedores`
--

DROP TABLE IF EXISTS `tbl_direcciones_proveedores`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_direcciones_proveedores` (
  `ID_DIRECCION_PROVEEDOR` int(11) NOT NULL AUTO_INCREMENT,
  `ID_PROVEEDOR` int(11) NOT NULL,
  `DEPARTAMENTO` varchar(30) DEFAULT NULL,
  `MUNICIPIO` varchar(30) DEFAULT NULL,
  `COLONIA` varchar(15) DEFAULT NULL,
  `ESTADO` tinyint(1) DEFAULT NULL,
  `CREADO_POR` varchar(15) DEFAULT NULL,
  `FECHA_CREACION` timestamp NOT NULL DEFAULT current_timestamp(),
  `MODIFICADO_POR` varchar(15) DEFAULT NULL,
  `FECHA_MODIFICACION` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`ID_DIRECCION_PROVEEDOR`),
  KEY `ID_PROVEEDOR` (`ID_PROVEEDOR`),
  CONSTRAINT `tbl_direcciones_proveedores_ibfk_1` FOREIGN KEY (`ID_PROVEEDOR`) REFERENCES `tbl_proveedores` (`ID_PROVEEDOR`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_direcciones_proveedores`
--

LOCK TABLES `tbl_direcciones_proveedores` WRITE;
/*!40000 ALTER TABLE `tbl_direcciones_proveedores` DISABLE KEYS */;
/*!40000 ALTER TABLE `tbl_direcciones_proveedores` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tbl_empresa`
--

DROP TABLE IF EXISTS `tbl_empresa`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_empresa` (
  `id_empresa` int(11) NOT NULL AUTO_INCREMENT,
  `nombre_empresa` varchar(100) NOT NULL,
  `fecha_inicio_operacion` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `tel_empresa` int(11) NOT NULL,
  `email_empresa` text NOT NULL,
  `direccion` text NOT NULL,
  `estado` varchar(50) NOT NULL,
  `creado` varchar(30) NOT NULL,
  `fecha_creacion` timestamp NOT NULL DEFAULT current_timestamp(),
  `fecha_modificacion` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id_empresa`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_empresa`
--

LOCK TABLES `tbl_empresa` WRITE;
/*!40000 ALTER TABLE `tbl_empresa` DISABLE KEYS */;
INSERT INTO `tbl_empresa` VALUES (3,'PACASSA','2023-11-30 23:53:36',22012891,'','','','','2023-11-30 23:53:36','2023-11-30 23:53:36');
/*!40000 ALTER TABLE `tbl_empresa` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tbl_lotes_proveedores_cai`
--

DROP TABLE IF EXISTS `tbl_lotes_proveedores_cai`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_lotes_proveedores_cai` (
  `ID_LOTE_CAI` int(11) NOT NULL,
  `ID_EMPRESA` int(11) NOT NULL,
  `ID_PROVEEDOR` int(11) NOT NULL,
  `FECHA_LIMITE` date NOT NULL,
  `FECHA_INICIO` date NOT NULL,
  `RANGO_DESDE` varchar(100) NOT NULL,
  `RANGO_HASTA` varchar(100) NOT NULL,
  `DESTINO` date NOT NULL,
  `TIPO_RECIBO` varchar(15) NOT NULL,
  `CAI` varchar(100) NOT NULL,
  `PUNTO_EMISION` varchar(100) NOT NULL,
  `ESTABLECIMIENTO` varchar(100) NOT NULL,
  `TIPO_DOCUMENTO` varchar(100) NOT NULL,
  `SECUENCIA_REGIMEN` varchar(100) NOT NULL,
  `ESTADO` tinyint(1) NOT NULL DEFAULT 0,
  `STOCK_MINIMO` varchar(100) NOT NULL,
  `CREADO_POR` varchar(15) DEFAULT NULL,
  `FECHA_CREACION` timestamp NOT NULL DEFAULT current_timestamp(),
  `MODIFICADO_POR` varchar(15) DEFAULT NULL,
  `FECHA_MODIFICACION` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`ID_LOTE_CAI`),
  KEY `ID_EMPRESA` (`ID_EMPRESA`),
  KEY `ID_PROVEEDOR` (`ID_PROVEEDOR`),
  CONSTRAINT `tbl_lotes_proveedores_cai_ibfk_1` FOREIGN KEY (`ID_EMPRESA`) REFERENCES `tbl_empresa` (`id_empresa`),
  CONSTRAINT `tbl_lotes_proveedores_cai_ibfk_2` FOREIGN KEY (`ID_PROVEEDOR`) REFERENCES `tbl_proveedores` (`ID_PROVEEDOR`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_lotes_proveedores_cai`
--

LOCK TABLES `tbl_lotes_proveedores_cai` WRITE;
/*!40000 ALTER TABLE `tbl_lotes_proveedores_cai` DISABLE KEYS */;
/*!40000 ALTER TABLE `tbl_lotes_proveedores_cai` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tbl_ms_hist_contrasena`
--

DROP TABLE IF EXISTS `tbl_ms_hist_contrasena`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_ms_hist_contrasena` (
  `ID_HIST` int(11) NOT NULL AUTO_INCREMENT,
  `ID_USUARIO` int(11) DEFAULT NULL,
  `CONTRASENA` varchar(100) DEFAULT NULL,
  `FECHA_CREACION` timestamp NOT NULL DEFAULT current_timestamp(),
  `FECHA_MODIFICACION` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `CREADO_POR` int(11) DEFAULT NULL,
  `MODIFICADO_POR` int(11) DEFAULT NULL,
  PRIMARY KEY (`ID_HIST`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_ms_hist_contrasena`
--

LOCK TABLES `tbl_ms_hist_contrasena` WRITE;
/*!40000 ALTER TABLE `tbl_ms_hist_contrasena` DISABLE KEYS */;
/*!40000 ALTER TABLE `tbl_ms_hist_contrasena` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tbl_ms_parametros`
--

DROP TABLE IF EXISTS `tbl_ms_parametros`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_ms_parametros` (
  `ID_PARAMETRO` int(11) NOT NULL AUTO_INCREMENT,
  `PARAMETRO` varchar(100) DEFAULT NULL,
  `VALOR` varchar(100) DEFAULT NULL,
  `FECHA_CREACION` timestamp NOT NULL DEFAULT current_timestamp(),
  `FECHA_MODIFICACION` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `CREADO_POR` varchar(255) DEFAULT NULL,
  `MODIFICADO_POR` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`ID_PARAMETRO`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_ms_parametros`
--

LOCK TABLES `tbl_ms_parametros` WRITE;
/*!40000 ALTER TABLE `tbl_ms_parametros` DISABLE KEYS */;
INSERT INTO `tbl_ms_parametros` VALUES (1,'Nombre de la empresa','IHCI','2023-09-24 03:42:15','2023-12-08 06:00:00',NULL,'KENYO'),(2,'preguntas_seguridad','2','2023-09-24 03:45:02','2023-09-28 16:51:45',NULL,NULL),(3,'Intentos','3','2023-09-24 03:45:02','2023-09-24 03:45:02',NULL,NULL);
/*!40000 ALTER TABLE `tbl_ms_parametros` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tbl_ms_roles`
--

DROP TABLE IF EXISTS `tbl_ms_roles`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_ms_roles` (
  `ID_ROL` int(11) NOT NULL AUTO_INCREMENT,
  `NOMBRE_ROL` varchar(100) DEFAULT NULL,
  `DESCRIPCION` varchar(200) DEFAULT NULL,
  `FECHA_CREACION` timestamp NOT NULL DEFAULT current_timestamp(),
  `FECHA_MODIFICACION` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `CREADO_POR` int(11) DEFAULT NULL,
  `MODIFICADO_POR` int(11) DEFAULT NULL,
  `ESTADO_ROL` varchar(50) NOT NULL,
  PRIMARY KEY (`ID_ROL`)
) ENGINE=InnoDB AUTO_INCREMENT=56 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_ms_roles`
--

LOCK TABLES `tbl_ms_roles` WRITE;
/*!40000 ALTER TABLE `tbl_ms_roles` DISABLE KEYS */;
INSERT INTO `tbl_ms_roles` VALUES (36,'Administrador','admin','2023-09-08 21:01:38','2023-10-09 15:27:23',NULL,NULL,'A'),(37,'Aprobador','apro','2023-09-08 21:02:44','2023-10-09 15:57:16',NULL,NULL,'A'),(38,'Usuario','usu','2023-09-08 21:03:09','2023-10-13 00:39:55',NULL,NULL,'A');
/*!40000 ALTER TABLE `tbl_ms_roles` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tbl_ms_usuario`
--

DROP TABLE IF EXISTS `tbl_ms_usuario`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_ms_usuario` (
  `id_usuario` int(11) NOT NULL AUTO_INCREMENT,
  `nombres` varchar(255) DEFAULT NULL,
  `apellidos` varchar(255) DEFAULT NULL,
  `nombre_usuario` varchar(255) DEFAULT NULL,
  `contraseña` varchar(255) DEFAULT NULL,
  `contraseñaTemp` varchar(255) DEFAULT NULL,
  `correo_electronico` varchar(100) DEFAULT NULL,
  `estado` varchar(20) DEFAULT NULL,
  `rol` int(11) DEFAULT NULL,
  `fecha_creacion` timestamp NOT NULL DEFAULT current_timestamp(),
  `fecha_modificacion` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `creado_por` int(11) DEFAULT NULL,
  `modificado_por` int(11) DEFAULT NULL,
  PRIMARY KEY (`id_usuario`),
  KEY `tbl_ms_roles_tbl_ms_usuario` (`rol`),
  CONSTRAINT `tbl_ms_roles_tbl_ms_usuario` FOREIGN KEY (`rol`) REFERENCES `tbl_ms_roles` (`ID_ROL`) ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=177 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_ms_usuario`
--

LOCK TABLES `tbl_ms_usuario` WRITE;
/*!40000 ALTER TABLE `tbl_ms_usuario` DISABLE KEYS */;
INSERT INTO `tbl_ms_usuario` VALUES (151,'LILIAN','KENYO','KENYO','$2y$10$YgJ9pEaMjYlrfE2m0DzBI.UN9CWHbJrtrgB.0z/nOLiySDzsqp7nW',NULL,'kenyo@gmail.com','A',36,'2023-11-30 21:58:10','2024-04-07 05:05:28',NULL,NULL),(152,NULL,NULL,'LUISA','$2y$10$wDWIRCwByvh68LulghCPKOObtzxXnYGM3NTGHZg8h1fnCY8fcXSry',NULL,'luis@gmail.com','A',38,'2023-12-04 20:02:51','2024-04-07 03:52:12',NULL,NULL),(164,NULL,NULL,'LISSETH','$2y$10$DK79DuBTGt0V96cr1iajxuI2.tbLNwGrQ.ERraOYWG7V1yPECjw1C','$2y$10$kOPRAHGSBFnMTsBoT7JWO.K39/J388k/I53ShfODne33NeSRvMOJ.','lilian.kenyon@ihci.edu.hn','A',36,'2024-03-20 14:41:46','2024-04-12 04:39:49',NULL,NULL),(165,NULL,NULL,'KENYON','$2y$10$4yYRSV3IWcm82.8CL70SVOZnjaaZv/WFGVs1WNRy5aa/rA88BBAE2',NULL,'kenyonlilian@gmail.com','A',36,'2024-04-07 10:26:22','2024-04-07 05:06:42',NULL,NULL),(170,NULL,NULL,'RONY',NULL,'$2y$10$sVLBbhMHFCem5cTaqH9sS.7R7BTuqtHOqz/mIdYKMSBGiFjOvU1yS','rony.barahona@ihcji.edu.hn','A',36,'2024-04-07 12:14:08','2024-04-07 04:14:08',NULL,NULL),(174,NULL,NULL,'ALICIA',NULL,'$2y$10$rNMOUUfRqyOWpunKxHQHDOy6/qCmZZXmbit2uFldGYW.LejtHT2nC','ali@unah.hn','A',36,'2024-04-07 12:58:03','2024-04-07 04:58:03',NULL,NULL),(175,NULL,NULL,'ANA',NULL,'$2y$10$F3LIGWKrwOjvRHTz33WS4u6jQ9.UwLP3cxXm4sfHdrR/BuWOf4IWu','ana.lacayo@ihci.edu.hn','A',36,'2024-04-07 13:01:57','2024-04-07 05:01:57',NULL,NULL),(176,NULL,NULL,'LIZETH','$2y$10$29lt.VvzNrP9fPpLo3JBm.8kq612S3QXmrYBuHO1YA3ngFFPFjLwG',NULL,'lilian.kenyon@unah.hn','A',36,'2024-04-12 04:43:41','2024-04-13 02:12:48',NULL,NULL);
/*!40000 ALTER TABLE `tbl_ms_usuario` ENABLE KEYS */;
UNLOCK TABLES;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_unicode_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'NO_ZERO_IN_DATE,NO_ZERO_DATE,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
/*!50003 CREATE*/ /*!50017 DEFINER=`root`@`localhost`*/ /*!50003 TRIGGER `TRIGGER_tbl_usuarios` AFTER INSERT ON `tbl_ms_usuario` FOR EACH ROW BEGIN
    DECLARE usuario_operacion_id INT; 
    DECLARE usuario_operacion_nombre VARCHAR(255); 

    -- Obtener el ID del usuario actual
    SET usuario_operacion_id = (SELECT id_usuario FROM tbl_ms_usuario WHERE nombre_usuario = @usuario_php); -- @usuario_php es un parámetro que pasaremos desde PHP

    -- Obtener el nombre del usuario actual
    SET usuario_operacion_nombre = @usuario_php;

    -- Insertar en la tabla de auditoría
    INSERT INTO auditoria_tbl_ms_usuario (tipo_operacion, id_usuario_afectado, nombre_usuario_afectado, id_usuario_operacion, nombre_usuario_operacion, tabla_afectada, detalle_anterior, detalle_posterior) 
    VALUES ('INSERT', NEW.id_usuario, NEW.nombre_usuario, usuario_operacion_id, @usuario_php, 'tbl_ms_usuario', NULL, CONCAT('Nuevo usuario creado: ', NEW.nombre_usuario)); 
END */;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_unicode_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'NO_ZERO_IN_DATE,NO_ZERO_DATE,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
/*!50003 CREATE*/ /*!50017 DEFINER=`root`@`localhost`*/ /*!50003 TRIGGER TRIGGER_tbl_usuarios_update AFTER UPDATE ON tbl_ms_usuario
FOR EACH ROW
BEGIN
    DECLARE usuario_operacion_id INT;
    DECLARE usuario_operacion_nombre VARCHAR(255);
    
    -- Obtener el ID del usuario actual
    SET usuario_operacion_id = (SELECT id_usuario FROM tbl_ms_usuario WHERE nombre_usuario = CURRENT_USER());
    
    -- Obtener el nombre del usuario actual
    SET usuario_operacion_nombre = CURRENT_USER();
    
    -- Insertar en la tabla de auditoría
    INSERT INTO auditoria_tbl_ms_usuario (tipo_operacion, id_usuario_afectado, nombre_usuario_afectado, tabla_afectada, detalle_anterior, detalle_posterior, id_usuario_operacion)
    VALUES ('UPDATE', NEW.id_usuario, NEW.nombre_usuario, 'tbl_ms_usuario', CONCAT('Detalle antes de la actualización: ', OLD.nombre_usuario), CONCAT('Detalle después de la actualización: ', NEW.nombre_usuario), usuario_operacion_id);
END */;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_unicode_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'NO_ZERO_IN_DATE,NO_ZERO_DATE,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
/*!50003 CREATE*/ /*!50017 DEFINER=`root`@`localhost`*/ /*!50003 TRIGGER TRIGGER_tbl_usuarios_delete AFTER DELETE ON tbl_ms_usuario
FOR EACH ROW
BEGIN
    DECLARE usuario_operacion_id INT;
    DECLARE usuario_operacion_nombre VARCHAR(255);
    
    -- Obtener el ID del usuario actual
    SET usuario_operacion_id = (SELECT id_usuario FROM tbl_ms_usuario WHERE nombre_usuario = USER());
    
    -- Obtener el nombre del usuario actual
    SET usuario_operacion_nombre = USER();
    
    -- Insertar en la tabla de auditoría
    INSERT INTO auditoria_tbl_ms_usuario (tipo_operacion, id_usuario_afectado, nombre_usuario_afectado, tabla_afectada, detalle_anterior, detalle_posterior, id_usuario_operacion, nombre_usuario_operacion)
    VALUES ('DELETE', OLD.id_usuario, OLD.nombre_usuario, 'tbl_ms_usuario', CONCAT('Detalle antes de la eliminación: ', OLD.nombre_usuario), NULL, usuario_operacion_id, usuario_operacion_nombre);
END */;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;

--
-- Table structure for table `tbl_objetos`
--

DROP TABLE IF EXISTS `tbl_objetos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_objetos` (
  `ID_OBJETO` int(11) NOT NULL AUTO_INCREMENT,
  `NOMBRE_OBJETO` varchar(100) DEFAULT NULL,
  `DESCRIPCION` varchar(200) DEFAULT NULL,
  `FECHA_CREACION` timestamp NOT NULL DEFAULT current_timestamp(),
  `FECHA_MODIFICACION` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `CREADO_POR` int(11) DEFAULT NULL,
  `MODIFICADO_POR` int(11) DEFAULT NULL,
  PRIMARY KEY (`ID_OBJETO`)
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_objetos`
--

LOCK TABLES `tbl_objetos` WRITE;
/*!40000 ALTER TABLE `tbl_objetos` DISABLE KEYS */;
INSERT INTO `tbl_objetos` VALUES (14,'Administración ','ADMIN','2023-12-08 22:48:10','2023-12-08 22:48:10',NULL,NULL),(15,'Cotización ','COTIZAR','2023-12-08 22:48:10','2023-12-08 22:48:10',NULL,NULL),(16,'Solicitudes','SOLICITUD','2023-12-08 22:49:10','2023-12-08 22:49:10',NULL,NULL),(17,'Ordenes de Compras','ORDEN','2023-12-08 22:49:10','2023-12-08 22:49:10',NULL,NULL),(18,'Orden de Pagó','ORDEN','2023-12-08 22:50:21','2023-12-08 22:50:21',NULL,NULL),(19,'Reportes','REPORTES','2023-12-08 22:50:21','2023-12-08 22:50:21',NULL,NULL),(20,'Seguridad','SEGURIDAD','2023-12-08 22:50:52','2023-12-08 22:50:52',NULL,NULL);
/*!40000 ALTER TABLE `tbl_objetos` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tbl_orden_compra`
--

DROP TABLE IF EXISTS `tbl_orden_compra`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_orden_compra` (
  `ID_ORDEN_COMPRA` int(11) NOT NULL AUTO_INCREMENT,
  `ID_PROVEEDOR` int(11) DEFAULT NULL,
  `ID_CONTACTO` int(11) NOT NULL,
  `NUMERO_ORDEN` varchar(255) DEFAULT NULL,
  `FECHA_ORDEN` date DEFAULT NULL,
  `FECHA_CREACION` timestamp NOT NULL DEFAULT current_timestamp(),
  `FECHA_MODIFICACION` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `CREADO_POR` int(11) DEFAULT NULL,
  `MODIFICADO_POR` int(11) DEFAULT NULL,
  PRIMARY KEY (`ID_ORDEN_COMPRA`),
  KEY `ID_PROVEEDOR` (`ID_PROVEEDOR`),
  KEY `ID_CONTACTO` (`ID_CONTACTO`)
) ENGINE=InnoDB AUTO_INCREMENT=723 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_orden_compra`
--

LOCK TABLES `tbl_orden_compra` WRITE;
/*!40000 ALTER TABLE `tbl_orden_compra` DISABLE KEYS */;
INSERT INTO `tbl_orden_compra` VALUES (722,26,0,'0004','2023-12-19','2023-12-19 21:54:34','2023-12-19 21:54:34',NULL,NULL);
/*!40000 ALTER TABLE `tbl_orden_compra` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tbl_orden_compra_productos`
--

DROP TABLE IF EXISTS `tbl_orden_compra_productos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_orden_compra_productos` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `ID_ORDEN` int(11) NOT NULL,
  `CANTIDAD` varchar(255) NOT NULL,
  `DESCRIPCION` varchar(255) NOT NULL,
  `PRECIO` decimal(10,2) NOT NULL,
  `TOTAL` decimal(10,2) NOT NULL,
  `SUBTOTAL` decimal(10,2) NOT NULL,
  `ISV` decimal(10,2) NOT NULL,
  `MONTO` decimal(10,2) NOT NULL,
  `EXCENTO` varchar(255) NOT NULL,
  PRIMARY KEY (`ID`),
  KEY `tbl_orden_compra_tbl_orden_compra_productos` (`ID_ORDEN`) USING BTREE,
  CONSTRAINT `tbl_orden_compra_tbl_ordenCompra_productos` FOREIGN KEY (`ID_ORDEN`) REFERENCES `tbl_orden_compra` (`ID_ORDEN_COMPRA`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=111 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_orden_compra_productos`
--

LOCK TABLES `tbl_orden_compra_productos` WRITE;
/*!40000 ALTER TABLE `tbl_orden_compra_productos` DISABLE KEYS */;
INSERT INTO `tbl_orden_compra_productos` VALUES (109,722,'3','Cartulina.',2.00,6.00,56.00,8.40,64.40,'NO'),(110,722,'5','lápiz grafito',10.00,50.00,56.00,8.40,64.40,'NO');
/*!40000 ALTER TABLE `tbl_orden_compra_productos` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tbl_orden_pago`
--

DROP TABLE IF EXISTS `tbl_orden_pago`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_orden_pago` (
  `ID_ORDEN_PAGO` int(11) NOT NULL AUTO_INCREMENT,
  `ID_PROVEEDOR` int(11) DEFAULT NULL,
  `NUMERO_ORDEN` varchar(20) DEFAULT NULL,
  `FECHA_ORDEN` date DEFAULT NULL,
  `MONTO_TOTAL` decimal(10,2) DEFAULT NULL,
  `FECHA_CREACION` timestamp NOT NULL DEFAULT current_timestamp(),
  `FECHA_MODIFICACION` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `CREADO_POR` int(11) DEFAULT NULL,
  `MODIFICADO_POR` int(11) DEFAULT NULL,
  PRIMARY KEY (`ID_ORDEN_PAGO`),
  KEY `ID_PROVEEDOR` (`ID_PROVEEDOR`),
  CONSTRAINT `tbl_orden_pago_ibfk_1` FOREIGN KEY (`ID_PROVEEDOR`) REFERENCES `tbl_proveedores` (`ID_PROVEEDOR`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_orden_pago`
--

LOCK TABLES `tbl_orden_pago` WRITE;
/*!40000 ALTER TABLE `tbl_orden_pago` DISABLE KEYS */;
/*!40000 ALTER TABLE `tbl_orden_pago` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tbl_permisos`
--

DROP TABLE IF EXISTS `tbl_permisos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_permisos` (
  `id_permiso` int(11) NOT NULL AUTO_INCREMENT,
  `nombre_permiso` varchar(100) DEFAULT NULL,
  `descripcion` varchar(200) DEFAULT NULL,
  `fecha_creacion` timestamp NOT NULL DEFAULT current_timestamp(),
  `fecha_modificacion` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `creado_por` int(11) DEFAULT NULL,
  `modificado_por` int(11) DEFAULT NULL,
  PRIMARY KEY (`id_permiso`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_permisos`
--

LOCK TABLES `tbl_permisos` WRITE;
/*!40000 ALTER TABLE `tbl_permisos` DISABLE KEYS */;
INSERT INTO `tbl_permisos` VALUES (1,'Ver','solo lectura','2023-09-06 14:12:51','2023-09-06 14:12:51',NULL,NULL),(2,'Crear','Crea datos','2023-09-06 14:11:30','2023-09-06 14:12:51',NULL,NULL),(3,'Editar','edita el dato','2023-09-06 14:13:51','2023-09-06 14:13:51',NULL,NULL),(4,'Eliminar','elimina el dato','2023-09-06 14:13:51','2023-09-06 14:13:51',NULL,NULL);
/*!40000 ALTER TABLE `tbl_permisos` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tbl_preguntas`
--

DROP TABLE IF EXISTS `tbl_preguntas`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_preguntas` (
  `ID_PREGUNTA` int(11) NOT NULL AUTO_INCREMENT,
  `PREGUNTA` varchar(255) DEFAULT NULL,
  `FECHA_CREACION` timestamp NOT NULL DEFAULT current_timestamp(),
  `FECHA_MODIFICACION` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `CREADO_POR` varchar(255) DEFAULT NULL,
  `MODIFICADO_POR` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`ID_PREGUNTA`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_preguntas`
--

LOCK TABLES `tbl_preguntas` WRITE;
/*!40000 ALTER TABLE `tbl_preguntas` DISABLE KEYS */;
INSERT INTO `tbl_preguntas` VALUES (1,'¿Cuál es su color favorito?','2023-08-17 01:04:42','2023-12-05 06:39:08','1',NULL),(2,'¿Cual es tu comida favorita?','2023-08-17 01:06:01','2023-08-29 23:27:32','1',NULL),(3,'¿Cuál es la fecha de tu nacimiento?\r\n','2023-09-26 20:42:03','2023-09-26 20:42:03',NULL,NULL),(4,'¿Cuál es tu animal favorito?','2023-09-30 23:07:01','2023-09-30 23:07:01',NULL,NULL);
/*!40000 ALTER TABLE `tbl_preguntas` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tbl_productos`
--

DROP TABLE IF EXISTS `tbl_productos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_productos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_solicitud` int(11) NOT NULL,
  `cantidad` varchar(200) NOT NULL,
  `descripcion` text DEFAULT NULL,
  `categoria` int(11) NOT NULL,
  `creado_por` varchar(30) DEFAULT NULL,
  `fecha_creacion` date NOT NULL,
  `modificado_por` varchar(30) DEFAULT NULL,
  `fecha_modificacion` date NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_tbl_solicitudes_id_solicitud_tbl_productos` (`id_solicitud`),
  KEY `fk_tbl_categorias_categoria_tbl_productos` (`categoria`) USING BTREE,
  CONSTRAINT `fk_tbl_solicitudes_tbl_productos` FOREIGN KEY (`id_solicitud`) REFERENCES `tbl_solicitudes` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=153 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_productos`
--

LOCK TABLES `tbl_productos` WRITE;
/*!40000 ALTER TABLE `tbl_productos` DISABLE KEYS */;
INSERT INTO `tbl_productos` VALUES (144,111,'1','papel',8,NULL,'0000-00-00',NULL,'0000-00-00'),(145,112,'3','fumigación. ',9,NULL,'0000-00-00',NULL,'0000-00-00'),(146,113,'2','Cartulina.',8,NULL,'0000-00-00',NULL,'0000-00-00'),(147,113,'3','lápiz grafito',8,NULL,'0000-00-00',NULL,'0000-00-00'),(148,115,'2','pizarrón',8,NULL,'0000-00-00',NULL,'0000-00-00'),(149,116,'1','Fumigacion',9,NULL,'0000-00-00',NULL,'0000-00-00'),(150,117,'60','Libros de matemáticas para segundo grado',8,NULL,'0000-00-00',NULL,'0000-00-00'),(151,117,'80','Libros de español para segundo grado',8,NULL,'0000-00-00',NULL,'0000-00-00'),(152,118,'2','Resma de papel tamaño carta',8,NULL,'0000-00-00',NULL,'0000-00-00');
/*!40000 ALTER TABLE `tbl_productos` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tbl_proveedores`
--

DROP TABLE IF EXISTS `tbl_proveedores`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_proveedores` (
  `ID_PROVEEDOR` int(11) NOT NULL AUTO_INCREMENT,
  `NOMBRE` varchar(100) DEFAULT NULL,
  `DIRECCION` varchar(200) DEFAULT NULL,
  `TELEFONO` varchar(20) DEFAULT NULL,
  `CORREO_ELECTRONICO` varchar(100) DEFAULT NULL,
  `FECHA_CREACION` timestamp NOT NULL DEFAULT current_timestamp(),
  `FECHA_MODIFICACION` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `CREADO_POR` varchar(255) DEFAULT NULL,
  `MODIFICADO_POR` varchar(255) DEFAULT NULL,
  `id_empresa` int(11) DEFAULT NULL,
  `SERVICIO_PRESTADO` varchar(150) DEFAULT NULL,
  `RTN_EMPRESA` varchar(15) DEFAULT NULL,
  `ESTADO_PROVEEDOR` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`ID_PROVEEDOR`)
) ENGINE=InnoDB AUTO_INCREMENT=31 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_proveedores`
--

LOCK TABLES `tbl_proveedores` WRITE;
/*!40000 ALTER TABLE `tbl_proveedores` DISABLE KEYS */;
INSERT INTO `tbl_proveedores` VALUES (23,'PACCASA','TOROCAGUA','22012891','pacasa@gmail.com','2023-11-30 23:39:34','2023-11-30 23:39:34',NULL,NULL,NULL,NULL,NULL,'A'),(26,'ACCOSA','MALL PREMIER','22012891','accosa@gmail.com','2023-12-01 15:52:30','2023-12-01 15:52:30',NULL,NULL,NULL,NULL,NULL,'A'),(29,'LARACH','TOROCAGUA','22012891','larach@gmail.com','2023-12-01 21:21:32','2023-12-01 21:45:43',NULL,'ADMIN',NULL,NULL,NULL,'I');
/*!40000 ALTER TABLE `tbl_proveedores` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tbl_roles_permisos`
--

DROP TABLE IF EXISTS `tbl_roles_permisos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_roles_permisos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_rol` int(11) NOT NULL,
  `id_objeto` int(11) NOT NULL,
  `id_permiso` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `tbl_ms_roles_tbl_roles_permisos` (`id_rol`),
  KEY `tbl_objetos_tbl_roles_permisos` (`id_objeto`),
  KEY `tbl_permisos_tbl_roles_permios` (`id_permiso`)
) ENGINE=InnoDB AUTO_INCREMENT=1290 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_roles_permisos`
--

LOCK TABLES `tbl_roles_permisos` WRITE;
/*!40000 ALTER TABLE `tbl_roles_permisos` DISABLE KEYS */;
INSERT INTO `tbl_roles_permisos` VALUES (1258,36,14,1),(1259,36,14,2),(1260,36,14,3),(1261,36,14,4),(1262,36,15,1),(1263,36,15,2),(1264,36,15,3),(1265,36,15,4),(1266,36,16,1),(1267,36,16,2),(1268,36,16,3),(1269,36,16,4),(1270,36,17,1),(1271,36,17,2),(1272,36,17,3),(1273,36,17,4),(1274,36,18,1),(1275,36,18,2),(1276,36,18,3),(1277,36,18,4),(1278,36,19,1),(1279,36,19,2),(1280,36,19,3),(1281,36,19,4),(1282,36,20,1),(1283,36,20,2),(1284,36,20,3),(1285,36,20,4),(1286,38,16,1),(1287,38,16,2),(1288,38,16,3),(1289,38,16,4);
/*!40000 ALTER TABLE `tbl_roles_permisos` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tbl_solicitudes`
--

DROP TABLE IF EXISTS `tbl_solicitudes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_solicitudes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `codigo` varchar(100) NOT NULL,
  `usuario_id` int(11) DEFAULT NULL,
  `idDepartamento` int(11) DEFAULT NULL,
  `fecha_ingreso` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `fecha_modificacion` timestamp NOT NULL DEFAULT current_timestamp(),
  `estado` varchar(100) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_tbl_solicitudes_tbl_departamentos` (`idDepartamento`),
  KEY `fk_tbl_solicitudes_tbl_ms_usuario` (`usuario_id`),
  CONSTRAINT `fk_tbl_solicitudes_tbl_departamentos` FOREIGN KEY (`idDepartamento`) REFERENCES `tbl_departamentos` (`id_departamento`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=119 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_solicitudes`
--

LOCK TABLES `tbl_solicitudes` WRITE;
/*!40000 ALTER TABLE `tbl_solicitudes` DISABLE KEYS */;
INSERT INTO `tbl_solicitudes` VALUES (111,'1',151,7,'2023-12-18 22:08:04','2023-12-18 22:07:10','Aprobada'),(112,'2',151,7,'2023-12-18 22:13:16','2023-12-18 22:12:30','Aprobada'),(113,'3',151,7,'2023-12-19 17:37:09','2023-12-19 17:36:21','Aprobada'),(115,'5',151,7,'2024-03-21 06:00:00','2024-03-21 17:30:34','Proceso'),(116,'6',151,7,'2024-03-22 01:12:09','2024-03-22 01:12:09','Proceso'),(117,'7',151,7,'2024-04-05 04:18:21','2024-04-05 04:18:21','Aprobada'),(118,'8',165,7,'2024-04-07 06:00:00','2024-04-07 02:43:12','Proceso');
/*!40000 ALTER TABLE `tbl_solicitudes` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tbl_solictud_cotizacion`
--

DROP TABLE IF EXISTS `tbl_solictud_cotizacion`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_solictud_cotizacion` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `ID_COTIZACION` int(11) NOT NULL,
  `ID_SOLICITUD` int(11) NOT NULL,
  `DESCRIPCION` varchar(255) NOT NULL,
  `CATEGORIA` int(11) NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_solictud_cotizacion`
--

LOCK TABLES `tbl_solictud_cotizacion` WRITE;
/*!40000 ALTER TABLE `tbl_solictud_cotizacion` DISABLE KEYS */;
/*!40000 ALTER TABLE `tbl_solictud_cotizacion` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tbl_user_pregunta`
--

DROP TABLE IF EXISTS `tbl_user_pregunta`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_user_pregunta` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `ID_USER` int(11) NOT NULL,
  `ID_PREGUNTA` int(11) NOT NULL,
  `RESPUESTA` varchar(300) NOT NULL,
  PRIMARY KEY (`ID`),
  KEY `tbl_preguntas_tbl_user_pregunta` (`ID_PREGUNTA`),
  KEY `tbl_ms_usuario_tbl_user_pregunta` (`ID_USER`),
  CONSTRAINT `tbl_ms_usuario_tbl_user_pregunta` FOREIGN KEY (`ID_USER`) REFERENCES `tbl_ms_usuario` (`id_usuario`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `tbl_preguntas_tbl_user_pregunta` FOREIGN KEY (`ID_PREGUNTA`) REFERENCES `tbl_preguntas` (`ID_PREGUNTA`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=147 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_user_pregunta`
--

LOCK TABLES `tbl_user_pregunta` WRITE;
/*!40000 ALTER TABLE `tbl_user_pregunta` DISABLE KEYS */;
INSERT INTO `tbl_user_pregunta` VALUES (141,151,2,'$2y$10$6dal4JAVmWp1g0A0tFCSCO.3PU4BikyDwv.QPy3BWFU/LDXx4ANjC'),(142,151,3,'$2y$10$ADK3G24eVGQzuzKFsI1/Ye81cztawU66eyK18.fO8Jd.TgUWIj9SK'),(143,152,4,'$2y$10$DtOcAL/9DvXTiTvpWmjaZ.ip.Czrb7Mcp0G6AaasS5Vhqb15zjhii'),(144,152,2,'$2y$10$IQWNxB6DvwAgVxPqaYQeLeTj5AtiRQdZEf.n1NqTZQ6kqhin7dJzu'),(145,176,1,'$2y$10$7o4ohYYBfuU3LeXEb/HGW./qoV/ios1etT4dwb0GmvKXlFczaMYHC'),(146,176,2,'$2y$10$BC4f8mhEAoTPHeapUZA8/uhoReLQW9e9hMU10dg1a5J8OxHZkkuym');
/*!40000 ALTER TABLE `tbl_user_pregunta` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2024-04-13 22:58:37
