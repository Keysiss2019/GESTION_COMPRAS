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
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_contactos_proveedores`
--

LOCK TABLES `tbl_contactos_proveedores` WRITE;
/*!40000 ALTER TABLE `tbl_contactos_proveedores` DISABLE KEYS */;
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
) ENGINE=InnoDB AUTO_INCREMENT=135 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_cotizacion`
--

LOCK TABLES `tbl_cotizacion` WRITE;
/*!40000 ALTER TABLE `tbl_cotizacion` DISABLE KEYS */;
INSERT INTO `tbl_cotizacion` VALUES (131,117,23,'89','Tecnologia','2024-04-21','Proceso','http://localhost/Gestionmain/cotizaciones/add_cotizacion.php?id=117','2024-04-21 22:26:19','2024-04-21 22:58:01',NULL,NULL),(132,118,23,'90909','Tecnologia','2024-04-21','Aprobada','http://localhost/GESTION_COMPRAS/cotizaciones/add_cotizacion.php?id=118','2024-04-22 03:23:57','2024-04-22 03:25:37',NULL,NULL),(133,119,23,'9090','CONTABILIDAD','2024-04-21','Proceso','http://localhost/Gestionmain/pantallas/admin.php','2024-04-22 03:27:21','2024-04-22 03:28:25',NULL,NULL),(134,121,23,'32562','CONTABILIDAD','2024-04-20','Proceso','http://localhost/GESTION_COMPRAS/pantallas/admin.php','2024-04-22 04:12:06','2024-04-22 17:48:16',NULL,NULL);
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
) ENGINE=InnoDB AUTO_INCREMENT=42 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_cotizacion_detalle`
--

LOCK TABLES `tbl_cotizacion_detalle` WRITE;
/*!40000 ALTER TABLE `tbl_cotizacion_detalle` DISABLE KEYS */;
INSERT INTO `tbl_cotizacion_detalle` VALUES (36,131,'4','fumigaciones',9),(37,132,'3','FUMIGACIÓN',9),(38,132,'1','SILLAS DE ESCRITORIO',10),(39,133,'1','CAJA LAPIZ',8),(40,133,'1','MESA',10),(41,134,'32','Pupitres',8);
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
) ENGINE=InnoDB AUTO_INCREMENT=24 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_cuenta_proveedor`
--

LOCK TABLES `tbl_cuenta_proveedor` WRITE;
/*!40000 ALTER TABLE `tbl_cuenta_proveedor` DISABLE KEYS */;
INSERT INTO `tbl_cuenta_proveedor` VALUES (12,'20909','OCCIDENTE','Cheques','2023-11-30 23:40:17','2024-04-21 00:20:47',23),(23,'23583225','BAC CREDOMATIC','ahorro','2024-04-22 04:50:11','2024-04-22 04:50:11',35);
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
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_departamentos`
--

LOCK TABLES `tbl_departamentos` WRITE;
/*!40000 ALTER TABLE `tbl_departamentos` DISABLE KEYS */;
INSERT INTO `tbl_departamentos` VALUES (7,3,'CONTABILIDAD','A','KENYO','2024-01-16 22:56:22','2024-01-17 05:56:22','k'),(8,3,'Tecnologia','I','kenyo','2024-01-16 23:04:14','2024-01-17 06:04:14','luis'),(9,3,'IBS TEGUCIGALPA','A','KENYO','2024-04-22 06:00:00','2024-04-22 04:44:51','');
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
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_empresa`
--

LOCK TABLES `tbl_empresa` WRITE;
/*!40000 ALTER TABLE `tbl_empresa` DISABLE KEYS */;
INSERT INTO `tbl_empresa` VALUES (3,'PACASSA','1990-02-01 06:00:00',22012891,'pacasa@pacasa.com','Tegucigalpa','Activo','','2023-11-30 23:53:36','2023-11-30 23:53:36'),(4,'IHCI','0000-00-00 00:00:00',223565894,'info@ihci.edu.hn','Col. Matamoros, Tegucigalpa, M.D.C.','Activo','','2024-04-22 17:44:42','2024-04-22 17:44:42');
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
-- Table structure for table `tbl_modulos`
--

DROP TABLE IF EXISTS `tbl_modulos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_modulos` (
  `ID_MODULO` int(11) NOT NULL AUTO_INCREMENT,
  `NOMBRE_MODULO` varchar(255) NOT NULL,
  PRIMARY KEY (`ID_MODULO`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_modulos`
--

LOCK TABLES `tbl_modulos` WRITE;
/*!40000 ALTER TABLE `tbl_modulos` DISABLE KEYS */;
INSERT INTO `tbl_modulos` VALUES (1,'ADMINISTRACION'),(2,'SEGURIDAD'),(3,'COMPRAS');
/*!40000 ALTER TABLE `tbl_modulos` ENABLE KEYS */;
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
) ENGINE=InnoDB AUTO_INCREMENT=58 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_ms_roles`
--

LOCK TABLES `tbl_ms_roles` WRITE;
/*!40000 ALTER TABLE `tbl_ms_roles` DISABLE KEYS */;
INSERT INTO `tbl_ms_roles` VALUES (36,'ADMINISTRADOR','admin','2023-09-08 21:01:38','2024-04-10 04:56:28',NULL,NULL,'A'),(37,'APROBADOR','apro','2023-09-08 21:02:44','2024-02-22 02:11:35',NULL,NULL,'A'),(38,'USUARIO','usu','2023-09-08 21:03:09','2024-02-22 02:09:02',NULL,NULL,'A');
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
) ENGINE=InnoDB AUTO_INCREMENT=164 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_ms_usuario`
--

LOCK TABLES `tbl_ms_usuario` WRITE;
/*!40000 ALTER TABLE `tbl_ms_usuario` DISABLE KEYS */;
INSERT INTO `tbl_ms_usuario` VALUES (151,'LILIAN','KENYO','KENYO','$2y$10$OfdSFOwwYy7kRJWOMqJBLuqeyMSyBN087Ji./eqTOyeAnALjfdcEm',NULL,'lilian.kenyon@unah.hn','A',36,'2023-11-30 21:58:10','2024-04-22 04:32:37',NULL,NULL),(152,NULL,NULL,'LUIS','$2y$10$wDWIRCwByvh68LulghCPKOObtzxXnYGM3NTGHZg8h1fnCY8fcXSry',NULL,'luis@gmail.com','A',36,'2023-12-04 20:02:51','2024-03-20 02:05:23',NULL,NULL),(159,NULL,NULL,'KAREN','$2y$10$xJoPaTjcPfkhwErZMSVVXuwXBbpHfeAuHX7ECgjJWjDXX49/Ok2la',NULL,'karen@gmail.com','A',36,'2024-03-20 02:31:16','2024-03-20 02:31:48',NULL,NULL),(163,NULL,NULL,'KENYOs',NULL,NULL,NULL,NULL,NULL,'2024-04-21 20:17:50','2024-04-21 20:17:50',NULL,NULL);
/*!40000 ALTER TABLE `tbl_ms_usuario` ENABLE KEYS */;
UNLOCK TABLES;

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
  `ID_COTIZACION` int(11) NOT NULL,
  `ID_PROVEEDOR` int(11) DEFAULT NULL,
  `ID_CONTACTO` int(11) NOT NULL,
  `NUMERO_ORDEN` varchar(255) DEFAULT NULL,
  `FECHA_ORDEN` date DEFAULT NULL,
  `FECHA_CREACION` timestamp NOT NULL DEFAULT current_timestamp(),
  `FECHA_MODIFICACION` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `ESTADO` varchar(255) NOT NULL,
  `MONTO` decimal(10,2) NOT NULL,
  `CREADO_POR` int(11) DEFAULT NULL,
  `MODIFICADO_POR` int(11) DEFAULT NULL,
  PRIMARY KEY (`ID_ORDEN_COMPRA`),
  KEY `ID_PROVEEDOR` (`ID_PROVEEDOR`),
  KEY `ID_CONTACTO` (`ID_CONTACTO`),
  KEY `fk_tbl_orden_compra_tbl_cotizacion` (`ID_COTIZACION`),
  CONSTRAINT `fk_tbl_orden_compra_tbl_cotizacion` FOREIGN KEY (`ID_COTIZACION`) REFERENCES `tbl_cotizacion` (`ID_COTIZACION`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=840 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_orden_compra`
--

LOCK TABLES `tbl_orden_compra` WRITE;
/*!40000 ALTER TABLE `tbl_orden_compra` DISABLE KEYS */;
INSERT INTO `tbl_orden_compra` VALUES (833,131,23,0,'0015','2024-04-22','2024-04-22 01:16:06','2024-04-22 01:16:37','pagado',409.00,151,NULL),(837,133,23,0,'0017','2024-04-22','2024-04-22 03:31:40','2024-04-22 03:32:32','pagado',78.00,151,NULL),(839,134,23,0,'0018','2024-04-22','2024-04-22 17:48:38','2024-04-22 17:49:29','pagado',84640.00,151,NULL);
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
  `EXCENTO` varchar(255) NOT NULL,
  PRIMARY KEY (`ID`),
  KEY `tbl_orden_compra_tbl_orden_compra_productos` (`ID_ORDEN`) USING BTREE,
  CONSTRAINT `tbl_orden_compra_tbl_ordenCompra_productos` FOREIGN KEY (`ID_ORDEN`) REFERENCES `tbl_orden_compra` (`ID_ORDEN_COMPRA`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=178 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_orden_compra_productos`
--

LOCK TABLES `tbl_orden_compra_productos` WRITE;
/*!40000 ALTER TABLE `tbl_orden_compra_productos` DISABLE KEYS */;
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
  `ID_ORDEN` int(11) DEFAULT NULL,
  `BANCO` varchar(255) NOT NULL,
  `NUMERO_CUENTA` varchar(255) NOT NULL,
  `TIPO_CUENTA` varchar(255) NOT NULL,
  `SOLICITANTE` varchar(255) NOT NULL,
  `FECHA_ORDEN` date DEFAULT NULL,
  `MONTO_TOTAL` decimal(10,2) DEFAULT NULL,
  `LUGAR` varchar(255) NOT NULL,
  `CONCEPTO` varchar(255) NOT NULL,
  `FECHA_MODIFICACION` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `CREADO_POR` int(11) DEFAULT NULL,
  `MODIFICADO_POR` int(11) DEFAULT NULL,
  PRIMARY KEY (`ID_ORDEN_PAGO`),
  KEY `ID_PROVEEDOR` (`ID_PROVEEDOR`),
  KEY `tbl_orden_compra_tbl_orden_pago` (`ID_ORDEN`),
  CONSTRAINT `tbl_orden_compra_tbl_orden_pago` FOREIGN KEY (`ID_ORDEN`) REFERENCES `tbl_orden_compra` (`ID_ORDEN_COMPRA`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=68 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_orden_pago`
--

LOCK TABLES `tbl_orden_pago` WRITE;
/*!40000 ALTER TABLE `tbl_orden_pago` DISABLE KEYS */;
INSERT INTO `tbl_orden_pago` VALUES (64,23,833,'OCCIDENTE','20909','Cheques','L','2024-04-21',409.00,'O','L','2024-04-22 01:24:20',NULL,NULL),(66,23,837,'OCCIDENTE','20909','Cheques','KENYO','2024-04-21',78.00,'COMAYAGUELA','SUMINISTRO','2024-04-22 03:32:32',NULL,NULL),(67,23,839,'OCCIDENTE','20909','Cheques','Lilian','2024-04-23',84640.00,'Tegucigalpa, M.D.C.','Compra de pupitres','2024-04-22 17:49:29',NULL,NULL);
/*!40000 ALTER TABLE `tbl_orden_pago` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tbl_password_resets`
--

DROP TABLE IF EXISTS `tbl_password_resets`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_password_resets` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `expires` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_password_resets`
--

LOCK TABLES `tbl_password_resets` WRITE;
/*!40000 ALTER TABLE `tbl_password_resets` DISABLE KEYS */;
INSERT INTO `tbl_password_resets` VALUES (1,'keysiss2019@gmail.com','6198c0d81614697ba7ed33fcf655725f64ca6c42054154caa501fdfdab9b6984','1709779576'),(2,'keysiss2019@gmail.com','c3efd70f9768248f80238dd64030772650efc012fa5d104b34b7b3bff4be49de','1709779739'),(3,'keysiss2019@gmail.com','0899fc24fa53c8391ec1a040a4a45c3397245c8053b0412cf4fdf340f68499f2','1709779805'),(4,'keysiss2019@gmail.com','de259850e1a972d482d8f0a4c34d15b70a2df5510a7258c77d03f547b9ba6b13','1709779817'),(5,'keysiss2019@gmail.com','f221eac7202794981b7edfa4ab1a5d6ccc8f90d3232d2c7312b156d45fda6b82','1709780026'),(6,'keysiss2019@gmail.com','c5025bc77b4712877b332eb8734404a7a8d376e287a7feccd1c7eaebd9d509ba','1709780072'),(7,'keysiss2019@gmail.com','647c4ee2662d8db49f90556d0b50c7261648d11880ee9efdf559977e87f46dd0','1709780081'),(8,'keysiss2019@gmail.com','2e5f575f12c527c7a92a2ea30b771a34f311c3278e717888b32c42ea51ac3192','1709780390'),(9,'keysiss2019@gmail.com','vLtYCK5QTwKCwvTYSiXhP414xKKwJtDN',''),(10,'keysiss2019@gmail.com','q3sUIPwKeDSVyw4Dkl8iyt1K1kRcbru5',''),(11,'keysiss2019@gmail.com','3h917qF6EsVo9vkiGXAom9iqPD5WrBtr',''),(12,'keysiss2019@gmail.com','T79INNP8H9aTcKejEhvyRbVjmHZbDbYy',''),(13,'keysiss2019@gmail.com','7HGnqBNnVgRBVeX0NtP9TMGODSnsfJ7y',''),(14,'keysiss2019@gmail.com','4vl1FHUsb5pXAO7zL47NYClrakztvwJx','');
/*!40000 ALTER TABLE `tbl_password_resets` ENABLE KEYS */;
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
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_preguntas`
--

LOCK TABLES `tbl_preguntas` WRITE;
/*!40000 ALTER TABLE `tbl_preguntas` DISABLE KEYS */;
INSERT INTO `tbl_preguntas` VALUES (1,'¿Cuál es su color favorito?','2023-08-17 01:04:42','2024-01-27 20:07:53','KENYO',NULL),(2,'¿Cual es su color favorito?','2023-08-17 01:06:01','2024-02-21 11:57:39','1',NULL),(3,'¿Cuál es la fecha de tu nacimiento?\r\n','2023-09-26 20:42:03','2023-09-26 20:42:03',NULL,NULL),(4,'¿Cuál es su lugar favorito?','2023-09-30 23:07:01','2024-02-21 12:10:36',NULL,NULL);
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
) ENGINE=InnoDB AUTO_INCREMENT=211 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_productos`
--

LOCK TABLES `tbl_productos` WRITE;
/*!40000 ALTER TABLE `tbl_productos` DISABLE KEYS */;
INSERT INTO `tbl_productos` VALUES (202,117,'5','fumigaciones',9,NULL,'0000-00-00',NULL,'0000-00-00'),(210,121,'32','Pupitres',8,NULL,'0000-00-00',NULL,'0000-00-00');
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
) ENGINE=InnoDB AUTO_INCREMENT=36 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_proveedores`
--

LOCK TABLES `tbl_proveedores` WRITE;
/*!40000 ALTER TABLE `tbl_proveedores` DISABLE KEYS */;
INSERT INTO `tbl_proveedores` VALUES (23,'PACCASA','TOROCAGUA','22012891','pacasa@gmail.com','2023-11-30 23:39:34','2024-04-21 00:20:12',NULL,'ADMIN',NULL,NULL,NULL,'A'),(35,'LEOPLAST','Tegucigalpa, Francisco Morazán. Col.el Country, Atrás De Fábrica De Galletas Lido Y Taller Morazán','22210394','leoplast@gmail.com','2024-04-22 04:50:00','2024-04-22 04:50:00','ADMIN',NULL,NULL,NULL,NULL,'A');
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
) ENGINE=InnoDB AUTO_INCREMENT=1320 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_roles_permisos`
--

LOCK TABLES `tbl_roles_permisos` WRITE;
/*!40000 ALTER TABLE `tbl_roles_permisos` DISABLE KEYS */;
INSERT INTO `tbl_roles_permisos` VALUES (1286,38,16,1),(1287,38,16,2),(1288,38,16,3),(1289,38,16,4),(1290,56,14,1),(1291,57,14,1),(1292,36,14,1),(1293,36,14,2),(1294,36,14,3),(1295,36,14,4),(1296,36,15,1),(1297,36,15,2),(1298,36,15,3),(1299,36,15,4),(1300,36,16,1),(1301,36,16,2),(1302,36,16,3),(1303,36,16,4),(1304,36,17,1),(1305,36,17,2),(1306,36,17,3),(1307,36,17,4),(1308,36,18,1),(1309,36,18,2),(1310,36,18,3),(1311,36,18,4),(1312,36,19,1),(1313,36,19,2),(1314,36,19,3),(1315,36,19,4),(1316,36,20,1),(1317,36,20,2),(1318,36,20,3),(1319,36,20,4);
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
) ENGINE=InnoDB AUTO_INCREMENT=122 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_solicitudes`
--

LOCK TABLES `tbl_solicitudes` WRITE;
/*!40000 ALTER TABLE `tbl_solicitudes` DISABLE KEYS */;
INSERT INTO `tbl_solicitudes` VALUES (117,'1',151,8,'2024-04-22 03:20:29','2024-04-22 03:20:29','PAGADO'),(121,'2',151,7,'2024-04-22 17:49:29','2024-04-22 04:11:15','PAGADO');
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
-- Table structure for table `tbl_tokens`
--

DROP TABLE IF EXISTS `tbl_tokens`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_tokens` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `token` varchar(255) NOT NULL,
  `correo_electronico` varchar(255) NOT NULL,
  `fecha_expiracion` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `token_idx` (`token`),
  KEY `correo_idx` (`correo_electronico`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_tokens`
--

LOCK TABLES `tbl_tokens` WRITE;
/*!40000 ALTER TABLE `tbl_tokens` DISABLE KEYS */;
INSERT INTO `tbl_tokens` VALUES (1,'','keysiss2019@gmail.com','2024-03-13 03:03:20'),(2,'2983ef1cc39aa493fad5b873ccae941de89611ceabeb2bd28faeea5808e93b02','keysiss2019@gmail.com','2024-03-17 18:29:14'),(3,'d7c5f477683a995b3d4f599d3bebee90828306ce13dffec7695604f26c23cbab','keysiss2019@gmail.com','2024-03-17 18:41:37'),(4,'59076386920d7d6ff6af88780e62372836aa635f85472869ea258ced51bbd65c','keysiss2019@gmail.com','2024-03-17 18:43:04');
/*!40000 ALTER TABLE `tbl_tokens` ENABLE KEYS */;
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
) ENGINE=InnoDB AUTO_INCREMENT=157 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_user_pregunta`
--

LOCK TABLES `tbl_user_pregunta` WRITE;
/*!40000 ALTER TABLE `tbl_user_pregunta` DISABLE KEYS */;
INSERT INTO `tbl_user_pregunta` VALUES (143,152,4,'$2y$10$DtOcAL/9DvXTiTvpWmjaZ.ip.Czrb7Mcp0G6AaasS5Vhqb15zjhii'),(144,152,2,'$2y$10$IQWNxB6DvwAgVxPqaYQeLeTj5AtiRQdZEf.n1NqTZQ6kqhin7dJzu'),(155,151,1,'$2y$10$iyhi3TiKtq63n4I6y3k0i.aVdeYnmwch.cAhJzSQtT5KyXdGU0eM2'),(156,151,4,'$2y$10$AiNM6A3gNVriXwjwNWmLXO8zd6BAhYG7GVhl1cepV5GjxZTJcJKsa');
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

-- Dump completed on 2024-04-22 12:50:07
