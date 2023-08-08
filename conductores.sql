-- MySQL dump 10.13  Distrib 8.0.27, for Linux (x86_64)
--
-- Host: localhost    Database: conductores
-- ------------------------------------------------------
-- Server version	8.0.27

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
-- Table structure for table `Conductores`
--

DROP TABLE IF EXISTS `Conductores`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `Conductores` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nombre` varchar(256) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `apellido` varchar(256) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `ci` varchar(50) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `fec_nac` date NOT NULL,
  `id_estado` int NOT NULL,
  `documento` varchar(256) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `fecha_creacion` datetime NOT NULL,
  `creado_por` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `fecha_modificacion` datetime DEFAULT NULL,
  `modificado_por` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `Conductores_FK` (`id_estado`),
  CONSTRAINT `Conductores_FK` FOREIGN KEY (`id_estado`) REFERENCES `Estados` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb3 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Conductores`
--

LOCK TABLES `Conductores` WRITE;
/*!40000 ALTER TABLE `Conductores` DISABLE KEYS */;
INSERT INTO `Conductores` VALUES (1,'Guillermo','Gonzalez','45678952','1985-06-22',1,'no-imagen.jpg','now()','rminarro',NULL,NULL),(2,'Luis','Lopez','7896541','1983-01-21',1,'no-imagen.jpg','now()','rminarro',NULL,NULL),(3,'Walter','Caceres','1478523','1999-12-31',1,'no-imagen.jpg','now()','rminarro',NULL,NULL),(4,'Luciana','Nuñez','2589635','2001-01-31',1,'no-imagen.jpg','now()','rminarro',NULL,NULL);
/*!40000 ALTER TABLE `Conductores` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Estados`
--

DROP TABLE IF EXISTS `Estados`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `Estados` (
  `id` int NOT NULL AUTO_INCREMENT,
  `descripcion` varchar(256) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `activo` int NOT NULL,
  `fecha_creacion` datetime NOT NULL,
  `creado_por` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `fecha_modificacion` datetime DEFAULT NULL,
  `modificado_por` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb3 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Estados`
--

LOCK TABLES `Estados` WRITE;
/*!40000 ALTER TABLE `Estados` DISABLE KEYS */;
INSERT INTO `Estados` VALUES (1,'Activo',1,'2023-06-14 15:17:33','rminarro',NULL,NULL),(2,'Inactivo',1,'2023-06-14 15:17:33','rminarro',NULL,NULL),(3,'Lista',1,'2023-06-14 15:17:33','rminarro',NULL,NULL),(4,'Borrado',1,'2023-06-21 10:55:38','rminarro',NULL,NULL);
/*!40000 ALTER TABLE `Estados` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `HistorialConductores`
--

DROP TABLE IF EXISTS `HistorialConductores`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `HistorialConductores` (
  `id` int NOT NULL AUTO_INCREMENT,
  `id_estado` int NOT NULL,
  `id_conductor` int NOT NULL,
  `id_motivo` int NOT NULL,
  `observacion` varchar(256) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `fecha_creacion` datetime NOT NULL,
  `creado_por` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `fecha_modificacion` datetime DEFAULT NULL,
  `modificado_por` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `HistorialConductores_FK` (`id_estado`),
  CONSTRAINT `HistorialConductores_FK` FOREIGN KEY (`id_estado`) REFERENCES `Estados` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb3 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `HistorialConductores`
--

LOCK TABLES `HistorialConductores` WRITE;
/*!40000 ALTER TABLE `HistorialConductores` DISABLE KEYS */;
INSERT INTO `HistorialConductores` VALUES (1,3,1,1,'Alquilo sin autorización','now()','rminarro',NULL,NULL),(2,3,3,1,'Dejo deudas de mantenimiento sin pagar.','now()','rminarro',NULL,NULL);
/*!40000 ALTER TABLE `HistorialConductores` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Motivos`
--

DROP TABLE IF EXISTS `Motivos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `Motivos` (
  `id` int NOT NULL AUTO_INCREMENT,
  `id_estado` int NOT NULL,
  `descripcion` varchar(256) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `fecha_creacion` datetime NOT NULL,
  `creado_por` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `fecha_modificacion` datetime DEFAULT NULL,
  `modificado_por` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `Motivos_FK` (`id_estado`),
  CONSTRAINT `Motivos_FK` FOREIGN KEY (`id_estado`) REFERENCES `Estados` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb3 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Motivos`
--

LOCK TABLES `Motivos` WRITE;
/*!40000 ALTER TABLE `Motivos` DISABLE KEYS */;
INSERT INTO `Motivos` VALUES (1,1,'Sub alquila','now()','rminarro',NULL,NULL),(2,1,'Dejo deuda','now()','rminarro',NULL,NULL),(3,1,'Mala conducción','now()','rminarro',NULL,NULL);
/*!40000 ALTER TABLE `Motivos` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Usuarios`
--

DROP TABLE IF EXISTS `Usuarios`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `Usuarios` (
  `id` int NOT NULL AUTO_INCREMENT,
  `id_estado` int NOT NULL,
  `nombre` varchar(256) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `apellido` varchar(256) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `ci` varchar(50) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `usuario` varchar(256) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(256) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `fecha_creacion` datetime NOT NULL,
  `creado_por` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `fecha_modificacion` datetime DEFAULT NULL,
  `modificado_por` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `Usuarios_FK` (`id_estado`),
  CONSTRAINT `Usuarios_FK` FOREIGN KEY (`id_estado`) REFERENCES `Estados` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb3 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Usuarios`
--

LOCK TABLES `Usuarios` WRITE;
/*!40000 ALTER TABLE `Usuarios` DISABLE KEYS */;
INSERT INTO `Usuarios` VALUES (1,1,'Rubén','Miñarro','2240449','rminarro','$2a$12$JOe5OFLD9dFkI.KJ1k9TP.ixWX/YtYArB/Yv.A8XSeIcCBkIlPvoi','now()','rminarro',NULL,NULL),(2,1,'Albert','Camus','2589631','acamus','$2a$12$JOe5OFLD9dFkI.KJ1k9TP.ixWX/YtYArB/Yv.A8XSeIcCBkIlPvoi','now()','rminarro',NULL,NULL),(3,1,'Federico','Nietzche','fnietzche','963214','$2a$12$JOe5OFLD9dFkI.KJ1k9TP.ixWX/YtYArB/Yv.A8XSeIcCBkIlPvoi','now()','rminarro',NULL,NULL);
/*!40000 ALTER TABLE `Usuarios` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Permisos`
--

DROP TABLE IF EXISTS `Permisos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `Permisos` (
  `id` int NOT NULL AUTO_INCREMENT,
  `id_estado` int NOT NULL,
  `descripcion` varchar(256) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `fecha_creacion` datetime NOT NULL,
  `creado_por` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `fecha_modificacion` datetime DEFAULT NULL,
  `modificado_por` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `Permisos_FK` (`id_estado`),
  CONSTRAINT `Permisos_FK` FOREIGN KEY (`id_estado`) REFERENCES `Estados` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb3 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Permisos`
--

LOCK TABLES `Permisos` WRITE;
/*!40000 ALTER TABLE `Permisos` DISABLE KEYS */;
INSERT INTO `Permisos` VALUES (1,1,'Crear conductores','now()','rminarro',NULL,NULL),(2,1,'Editar conductores','now()','rminarro',NULL,NULL),(3,1,'Cambiar estado de conductores','now()','rminarro',NULL,NULL),(4,1,'Ver listado de conductores','now()','rminarro',NULL,NULL),(5,1,'Ver historial de conductores','now()','rminarro',NULL,NULL),(6,1,'Agregar historial a conductores','now()','rminarro',NULL,NULL),(7,1,'Ver listado de conductores','now()','rminarro',NULL,NULL),(8,1,'Ver motivos','now()','rminarro',NULL,NULL);
/*!40000 ALTER TABLE `Permisos` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Roles`
--

DROP TABLE IF EXISTS `Roles`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `Roles` (
  `id` int NOT NULL AUTO_INCREMENT,
  `id_estado` int NOT NULL,
  `descripcion` varchar(256) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `fecha_creacion` datetime NOT NULL,
  `creado_por` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `fecha_modificacion` datetime DEFAULT NULL,
  `modificado_por` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `Roles_FK` (`id_estado`),
  CONSTRAINT `Roles_FK` FOREIGN KEY (`id_estado`) REFERENCES `Estados` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb3 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Roles`
--

LOCK TABLES `Roles` WRITE;
/*!40000 ALTER TABLE `Roles` DISABLE KEYS */;
INSERT INTO `Roles` VALUES (1,1,'Administrador','now()','rminarro',NULL,NULL),(2,1,'Administrador ERP','now()','rminarro',NULL,NULL),(3,1,'Usuario de consultas','now()','rminarro',NULL,NULL);
/*!40000 ALTER TABLE `Roles` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `PermisosRoles`
--

DROP TABLE IF EXISTS `PermisosRoles`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `PermisosRoles` (
  `id` int NOT NULL AUTO_INCREMENT,
  `id_estado` int NOT NULL,
  `id_rol` int NOT NULL,
  `id_permiso` int NOT NULL,
  `fecha_creacion` datetime NOT NULL,
  `creado_por` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `fecha_modificacion` datetime DEFAULT NULL,
  `modificado_por` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `PermisosRoles_FK` (`id_estado`),
  CONSTRAINT `PermisosRoles_FK` FOREIGN KEY (`id_estado`) REFERENCES `Estados` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb3 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `PermisosRoles`
--

LOCK TABLES `PermisosRoles` WRITE;
/*!40000 ALTER TABLE `PermisosRoles` DISABLE KEYS */;
/*Permisos de Administrador*/
INSERT INTO `PermisosRoles` VALUES (1,1,1,1,'now()','rminarro',NULL,NULL),(2,1,1,2,'now()','rminarro',NULL,NULL),(3,1,1,3,'now()','rminarro',NULL,NULL),(4,1,1,4,'now()','rminarro',NULL,NULL),(5,1,1,5,'now()','rminarro',NULL,NULL),(6,1,1,6,'now()','rminarro',NULL,NULL),(7,1,1,7,'now()','rminarro',NULL,NULL),(8,1,1,8,'now()','rminarro',NULL,NULL);
/*Permisos de Administrador ERP*/
INSERT INTO `PermisosRoles` VALUES (9,1,2,1,'now()','rminarro',NULL,NULL),(10,1,2,2,'now()','rminarro',NULL,NULL),(11,1,2,3,'now()','rminarro',NULL,NULL),(12,1,2,4,'now()','rminarro',NULL,NULL),(13,1,2,5,'now()','rminarro',NULL,NULL),(14,1,2,6,'now()','rminarro',NULL,NULL),(15,1,2,7,'now()','rminarro',NULL,NULL),(16,1,2,8,'now()','rminarro',NULL,NULL);
/*Permisos de Usuarios de consultas*/
INSERT INTO `PermisosRoles` VALUES (17,1,3,4,'now()','rminarro',NULL,NULL),(18,1,3,5,'now()','rminarro',NULL,NULL),(19,1,3,7,'now()','rminarro',NULL,NULL),(20,1,3,8,'now()','rminarro',NULL,NULL);
/*!40000 ALTER TABLE `PermisosRoles` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `UsuariosRoles`
--

DROP TABLE IF EXISTS `UsuariosRoles`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `UsuariosRoles` (
  `id` int NOT NULL AUTO_INCREMENT,
  `id_estado` int NOT NULL,
  `id_rol` int NOT NULL,
  `id_usuario` int NOT NULL,
  `fecha_creacion` datetime NOT NULL,
  `creado_por` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `fecha_modificacion` datetime DEFAULT NULL,
  `modificado_por` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `UsuariosRoles_FK` (`id_estado`),
  CONSTRAINT `UsuariosRoles_FK` FOREIGN KEY (`id_estado`) REFERENCES `Estados` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb3 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `UsuariosRoles`
--

LOCK TABLES `UsuariosRoles` WRITE;
/*!40000 ALTER TABLE `UsuariosRoles` DISABLE KEYS */;
INSERT INTO `UsuariosRoles` VALUES (1,1,1,1,'now()','rminarro',NULL,NULL),(2,1,2,2,'now()','rminarro',NULL,NULL),(3,1,3,3,'now()','rminarro',NULL,NULL);
/*!40000 ALTER TABLE `UsuariosRoles` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping routines for database 'conductores'
--
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2023-07-15 10:50:19
