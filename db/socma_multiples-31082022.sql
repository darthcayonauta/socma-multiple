-- MySQL dump 10.19  Distrib 10.3.34-MariaDB, for debian-linux-gnu (x86_64)
--
-- Host: localhost    Database: socma_multiples
-- ------------------------------------------------------
-- Server version	10.3.34-MariaDB-0ubuntu0.20.04.1

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
-- Table structure for table `accesos`
--

DROP TABLE IF EXISTS `accesos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `accesos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_usuario` int(11) DEFAULT NULL,
  `fecha` datetime DEFAULT NULL,
  `sesion` text DEFAULT NULL,
  `ip` text DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `id_usuario` (`id_usuario`),
  CONSTRAINT `accesos_ibfk_1` FOREIGN KEY (`id_usuario`) REFERENCES `usuario` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `accesos`
--

LOCK TABLES `accesos` WRITE;
/*!40000 ALTER TABLE `accesos` DISABLE KEYS */;
INSERT INTO `accesos` VALUES (1,1,'2022-08-11 18:10:30','jrfmvi6mlsd3rhv3cut63riio4','127.0.0.1'),(2,1,'2022-08-12 10:28:40','k52ad6tuku8tium3bvf67bbg0u','127.0.0.1'),(3,1,'2022-08-16 10:15:40','h2h63of5jtbm90dhdoqkosn3a8','127.0.0.1'),(4,1,'2022-08-22 10:11:22','k7pu1g3m2trm1aackp30inu20t','::1'),(5,1,'2022-08-24 12:14:20','fsutl3203def9509mjvrkkck34','::1'),(6,1,'2022-08-24 15:46:23','1u4khp78v1igrek8ghth76dbro','::1'),(7,1,'2022-08-24 17:47:07','2aku34q7ht62tbtibsui0gb51q','::1'),(8,1,'2022-08-25 10:33:19','ds4e7ntvgjrqtume32ess0s573','::1'),(9,1,'2022-08-25 18:42:44','f7l8ko4g4proefvfn6qb0svjph','::1'),(10,1,'2022-08-26 09:56:56','jhioirt7hasn9opt0rtbbeonn9','::1'),(11,1,'2022-08-29 10:06:09','uf03mth8k875mvl5rafpb4f2d3','::1'),(12,1,'2022-08-29 11:12:23','04uagvjhohlskn8m5omm6cg9gi','::1'),(13,1,'2022-08-30 10:14:15','as3hbf0usaadqghn40uievp6ss','::1'),(14,1,'2022-08-31 13:35:09','4an9os1jq243dgbbtj0nmjentm','::1');
/*!40000 ALTER TABLE `accesos` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `afirmacion`
--

DROP TABLE IF EXISTS `afirmacion`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `afirmacion` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `descripcion` text DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `afirmacion`
--

LOCK TABLES `afirmacion` WRITE;
/*!40000 ALTER TABLE `afirmacion` DISABLE KEYS */;
INSERT INTO `afirmacion` VALUES (1,'SI'),(2,'NO');
/*!40000 ALTER TABLE `afirmacion` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cuerpo_repecion`
--

DROP TABLE IF EXISTS `cuerpo_repecion`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cuerpo_repecion` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `col_izq` text DEFAULT NULL,
  `col_der` text DEFAULT NULL,
  `id_item` int(11) DEFAULT NULL,
  `token` text DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=38 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cuerpo_repecion`
--

LOCK TABLES `cuerpo_repecion` WRITE;
/*!40000 ALTER TABLE `cuerpo_repecion` DISABLE KEYS */;
INSERT INTO `cuerpo_repecion` VALUES (1,'1','ok',1,'20220831164510'),(2,'1','si',2,'20220831164510'),(3,'2','no+se',3,'20220831164510'),(4,'some','yay',4,'20220831164510'),(5,'kizas','na',5,'20220831164510'),(6,'tal+vez','na',6,'20220831164510'),(7,'nein','an',7,'20220831164510'),(8,'idem','nan',8,'20220831164510'),(9,'qt','isNan',9,'20220831164510'),(10,'','',10,'20220831164510'),(11,'','',11,'20220831164510'),(12,'','',12,'20220831164510'),(13,'','',13,'20220831164510'),(14,'','',14,'20220831164510'),(15,'','',15,'20220831164510'),(16,'','',16,'20220831164510'),(17,'','',17,'20220831164510'),(18,'','',18,'20220831164510'),(19,'','',19,'20220831164510'),(20,'','',20,'20220831164510'),(21,'','',21,'20220831164510'),(22,'','',22,'20220831164510'),(23,'','',23,'20220831164510'),(24,'','',24,'20220831164510'),(25,'','',25,'20220831164510'),(26,'','',26,'20220831164510'),(27,'','',27,'20220831164510'),(28,'','',28,'20220831164510'),(29,'','',29,'20220831164510'),(30,'','',30,'20220831164510'),(31,'','',31,'20220831164510'),(32,'','',32,'20220831164510'),(33,'','',33,'20220831164510'),(34,'1','zz',34,'20220831164510'),(35,'1','zz',35,'20220831164510'),(36,'1','zz',36,'20220831164510'),(37,'2','zz',37,'20220831164510');
/*!40000 ALTER TABLE `cuerpo_repecion` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `estado`
--

DROP TABLE IF EXISTS `estado`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `estado` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `descripcion` text DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `estado`
--

LOCK TABLES `estado` WRITE;
/*!40000 ALTER TABLE `estado` DISABLE KEYS */;
INSERT INTO `estado` VALUES (1,'ACTIVO'),(2,'INACTIVO');
/*!40000 ALTER TABLE `estado` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `item`
--

DROP TABLE IF EXISTS `item`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `item` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `descripcion` text DEFAULT NULL,
  `id_seccion` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `id_seccion` (`id_seccion`),
  CONSTRAINT `item_ibfk_1` FOREIGN KEY (`id_seccion`) REFERENCES `seccion` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=39 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `item`
--

LOCK TABLES `item` WRITE;
/*!40000 ALTER TABLE `item` DISABLE KEYS */;
INSERT INTO `item` VALUES (1,'Vigencia Revisión Técnica',1),(2,'Vigencia Permiso Circulación',1),(3,'Vigencia Seguro Obligatorio',1),(4,'Control de Niveles',2),(5,'Nivel de Combustible',2),(6,'Nivel de Aceite',2),(7,'Nivel de Agua Radiador',2),(8,'Nivel de Líquido de Frenos',2),(9,'Nivel de Agua de Limpia Parabrisas',2),(10,'Equipo Básico de Emergencia',3),(11,'Botiquín',3),(12,'Extintor Operativo y Vigente',3),(13,'Triángulos Luminosos',3),(14,'LLaves Rueda',3),(15,'Gata',3),(16,'Limpieza Interior',3),(17,'Limpieza Pick Up',3),(18,'Chaleco Reflectante',3),(19,'Cabos Para Amarrar',3),(20,'Rueda de Repuesto',3),(21,'Cargador USB Para Teléfono',4),(22,'Luces Frontales Altas\r\n',4),(23,'Luces Frontales Bajas',4),(24,'Intermitentes',4),(25,'Luz Patente',4),(26,'Luces de Frenos',4),(27,'Luces de Retroceso',4),(28,'Luces de Estacionamiento',4),(29,'Luces de Estacionamiento\r\n',4),(30,'Luces de Emergencia',4),(31,'Espejo Retrovisor',4),(32,'Espejos Laterales',4),(33,'Limpia Parabrisas',4),(34,'Parabrisas',4),(35,'Revisión Exterior Pintura',5),(36,'Revisión Espejos, Rayones , Etc.',5),(37,'Revisión 4 Neumáticos Aire/Estado',5),(38,'Revisión de Vidrios',5);
/*!40000 ALTER TABLE `item` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `menu`
--

DROP TABLE IF EXISTS `menu`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `menu` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `descripcion` text DEFAULT NULL,
  `link` text DEFAULT NULL,
  `id_link` text DEFAULT NULL,
  `dropdown` int(11) DEFAULT NULL,
  `tipo_usuario` int(11) DEFAULT NULL,
  `orden` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `tipo_usuario` (`tipo_usuario`),
  CONSTRAINT `menu_ibfk_1` FOREIGN KEY (`tipo_usuario`) REFERENCES `tipo_usuario` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `menu`
--

LOCK TABLES `menu` WRITE;
/*!40000 ALTER TABLE `menu` DISABLE KEYS */;
INSERT INTO `menu` VALUES (1,'Vehiculos','#','vehiculos',1,3,1),(2,'Vehiculos','#','vehiculos',1,1,1);
/*!40000 ALTER TABLE `menu` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `recepcion`
--

DROP TABLE IF EXISTS `recepcion`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `recepcion` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_vehiculo` int(11) DEFAULT NULL,
  `fecha` date DEFAULT NULL,
  `kilometraje` text DEFAULT NULL,
  `observacion` text DEFAULT NULL,
  `id_user` int(11) DEFAULT NULL,
  `token` text DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `id_user` (`id_user`),
  KEY `id_vehiculo` (`id_vehiculo`),
  CONSTRAINT `recepcion_ibfk_1` FOREIGN KEY (`id_user`) REFERENCES `usuario` (`id`),
  CONSTRAINT `recepcion_ibfk_2` FOREIGN KEY (`id_vehiculo`) REFERENCES `vehiculo` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `recepcion`
--

LOCK TABLES `recepcion` WRITE;
/*!40000 ALTER TABLE `recepcion` DISABLE KEYS */;
INSERT INTO `recepcion` VALUES (1,3,'2022-08-31','20000','<p>some</p>\n',1,'20220831164510');
/*!40000 ALTER TABLE `recepcion` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `seccion`
--

DROP TABLE IF EXISTS `seccion`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `seccion` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `descripcion` text DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `seccion`
--

LOCK TABLES `seccion` WRITE;
/*!40000 ALTER TABLE `seccion` DISABLE KEYS */;
INSERT INTO `seccion` VALUES (1,'VIGENCIA'),(2,'CONTROLES'),(3,'CHEQUEOS'),(4,'CONTROLES DE LUCES Y ACCESORIOS'),(5,'REVISION PARTE EXTERNA');
/*!40000 ALTER TABLE `seccion` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sub_menu`
--

DROP TABLE IF EXISTS `sub_menu`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `sub_menu` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `descripcion` text DEFAULT NULL,
  `link` text DEFAULT NULL,
  `id_link` text DEFAULT NULL,
  `id_menu` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `id_menu` (`id_menu`),
  CONSTRAINT `sub_menu_ibfk_1` FOREIGN KEY (`id_menu`) REFERENCES `menu` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sub_menu`
--

LOCK TABLES `sub_menu` WRITE;
/*!40000 ALTER TABLE `sub_menu` DISABLE KEYS */;
INSERT INTO `sub_menu` VALUES (1,'Listar Recepción de Vehículos','content-page.php','listarSolicitudes',1),(2,'Crear Recepción de Vehículos','content-page.php','crearSolicitud',1),(3,'Listar Recepción de Vehículos','content-page.php','listarSolicitudes',2),(4,'Crear Recepción de Vehículos','content-page.php','crearSolicitud',2),(5,'Listar Vehículos','content-page.php','listarVehiculos',2),(6,'Crear Vehiculo','content-page.php','crearVehiculo',2);
/*!40000 ALTER TABLE `sub_menu` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tipo_transmision`
--

DROP TABLE IF EXISTS `tipo_transmision`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tipo_transmision` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `descripcion` text DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tipo_transmision`
--

LOCK TABLES `tipo_transmision` WRITE;
/*!40000 ALTER TABLE `tipo_transmision` DISABLE KEYS */;
INSERT INTO `tipo_transmision` VALUES (1,'MANUAL'),(2,'AUTOMATICA');
/*!40000 ALTER TABLE `tipo_transmision` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tipo_usuario`
--

DROP TABLE IF EXISTS `tipo_usuario`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tipo_usuario` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `descripcion` text DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tipo_usuario`
--

LOCK TABLES `tipo_usuario` WRITE;
/*!40000 ALTER TABLE `tipo_usuario` DISABLE KEYS */;
INSERT INTO `tipo_usuario` VALUES (1,'admin'),(2,'chofer'),(3,'chofer-plus'),(4,'normal');
/*!40000 ALTER TABLE `tipo_usuario` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tipo_vehiculo`
--

DROP TABLE IF EXISTS `tipo_vehiculo`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tipo_vehiculo` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `descripcion` text DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tipo_vehiculo`
--

LOCK TABLES `tipo_vehiculo` WRITE;
/*!40000 ALTER TABLE `tipo_vehiculo` DISABLE KEYS */;
INSERT INTO `tipo_vehiculo` VALUES (1,'CAMIONETA'),(2,'AUTOMOVIL'),(3,'FURGON');
/*!40000 ALTER TABLE `tipo_vehiculo` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `usuario`
--

DROP TABLE IF EXISTS `usuario`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `usuario` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombres` text DEFAULT NULL,
  `apaterno` text DEFAULT NULL,
  `amaterno` text DEFAULT NULL,
  `email` text DEFAULT NULL,
  `rut` text DEFAULT NULL,
  `clave` text DEFAULT NULL,
  `id_estado` int(11) DEFAULT NULL,
  `tipo_usuario` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `tipo_usuario` (`tipo_usuario`),
  KEY `id_estado` (`id_estado`),
  CONSTRAINT `usuario_ibfk_1` FOREIGN KEY (`tipo_usuario`) REFERENCES `tipo_usuario` (`id`),
  CONSTRAINT `usuario_ibfk_2` FOREIGN KEY (`id_estado`) REFERENCES `estado` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `usuario`
--

LOCK TABLES `usuario` WRITE;
/*!40000 ALTER TABLE `usuario` DISABLE KEYS */;
INSERT INTO `usuario` VALUES (1,'claudio','guzman','herrera','claudio.guzman@socma.cl','12708715-6','*B9CE51111AF4DC33A48224BD77335BE3379AC6E6',1,1);
/*!40000 ALTER TABLE `usuario` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `vehiculo`
--

DROP TABLE IF EXISTS `vehiculo`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `vehiculo` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `marca` text DEFAULT NULL,
  `modelo` text DEFAULT NULL,
  `year` int(11) DEFAULT NULL,
  `patente` text DEFAULT NULL,
  `tipo_vehiculo` int(11) DEFAULT NULL,
  `transmision` int(11) DEFAULT NULL,
  `id_estado` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `tipo_vehiculo` (`tipo_vehiculo`),
  KEY `transmision` (`transmision`),
  KEY `id_estado` (`id_estado`),
  CONSTRAINT `vehiculo_ibfk_1` FOREIGN KEY (`tipo_vehiculo`) REFERENCES `tipo_vehiculo` (`id`),
  CONSTRAINT `vehiculo_ibfk_2` FOREIGN KEY (`transmision`) REFERENCES `tipo_transmision` (`id`),
  CONSTRAINT `vehiculo_ibfk_3` FOREIGN KEY (`id_estado`) REFERENCES `estado` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `vehiculo`
--

LOCK TABLES `vehiculo` WRITE;
/*!40000 ALTER TABLE `vehiculo` DISABLE KEYS */;
INSERT INTO `vehiculo` VALUES (1,'MITSUBISHI','KATANA',2019,'XX-XX-22',1,1,1),(3,'OPEL','SOME',2022,'XX-XX-23',3,1,1),(4,'CHEVROLET','CORSA',2011,'XX-XX-24',2,1,2),(5,'CHEVROLET','C10',1979,'XX-XX-25',1,1,2);
/*!40000 ALTER TABLE `vehiculo` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2022-08-31 16:32:13
