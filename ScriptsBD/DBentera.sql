CREATE DATABASE  IF NOT EXISTS `bd_museo` /*!40100 DEFAULT CHARACTER SET latin1 */;
USE `bd_museo`;
-- MySQL dump 10.13  Distrib 5.6.13, for Win32 (x86)
--
-- Host: 127.0.0.1    Database: bd_museo
-- ------------------------------------------------------
-- Server version	5.5.27

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

--
-- Table structure for table `actualizacion`
--

DROP TABLE IF EXISTS `actualizacion`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `actualizacion` (
  `idActualizacion` int(11) NOT NULL AUTO_INCREMENT,
  `tituloActualizacion` varchar(50) NOT NULL,
  `fechaActualizacion` date NOT NULL,
  `descActualizacion` varchar(200) NOT NULL,
  `Usuario_email` varchar(50) NOT NULL,
  PRIMARY KEY (`idActualizacion`),
  KEY `fk_Actualizacion_Usuario1` (`Usuario_email`),
  CONSTRAINT `fk_Actualizacion_Usuario1` FOREIGN KEY (`Usuario_email`) REFERENCES `usuario` (`email`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `actualizacion`
--

LOCK TABLES `actualizacion` WRITE;
/*!40000 ALTER TABLE `actualizacion` DISABLE KEYS */;
/*!40000 ALTER TABLE `actualizacion` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `administrador`
--

DROP TABLE IF EXISTS `administrador`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `administrador` (
  `email` varchar(50) NOT NULL,
  `clave` varchar(100) NOT NULL,
  `fechaAlta` date NOT NULL,
  PRIMARY KEY (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `administrador`
--

LOCK TABLES `administrador` WRITE;
/*!40000 ALTER TABLE `administrador` DISABLE KEYS */;
INSERT INTO `administrador` VALUES ('bullerwins@gmail.com','admin','0000-00-00');
/*!40000 ALTER TABLE `administrador` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `carrito`
--

DROP TABLE IF EXISTS `carrito`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `carrito` (
  `idCarrito` int(11) NOT NULL,
  `email` varchar(50) NOT NULL,
  `fechaCreacion` date NOT NULL,
  `fechaExpir` date DEFAULT NULL,
  PRIMARY KEY (`idCarrito`),
  KEY `fk_Carrito_Usuario1` (`email`),
  CONSTRAINT `fk_Carrito_Usuario1` FOREIGN KEY (`email`) REFERENCES `usuario` (`email`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `carrito`
--

LOCK TABLES `carrito` WRITE;
/*!40000 ALTER TABLE `carrito` DISABLE KEYS */;
/*!40000 ALTER TABLE `carrito` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `copia_cuadro`
--

DROP TABLE IF EXISTS `copia_cuadro`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `copia_cuadro` (
  `idCopia_Cuadro` int(11) NOT NULL,
  `nombreProducto` varchar(100) DEFAULT NULL,
  `autor` varchar(50) DEFAULT NULL,
  `estilo` varchar(50) DEFAULT NULL,
  `fechaAlta` date NOT NULL,
  `descripcion` varchar(200) DEFAULT NULL,
  `precio` int(11) NOT NULL,
  PRIMARY KEY (`idCopia_Cuadro`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `copia_cuadro`
--

LOCK TABLES `copia_cuadro` WRITE;
/*!40000 ALTER TABLE `copia_cuadro` DISABLE KEYS */;
INSERT INTO `copia_cuadro` VALUES (1,'Gernika','Pablo Picasso','Renancentista','0000-00-00',NULL,111);
/*!40000 ALTER TABLE `copia_cuadro` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cuadro`
--

DROP TABLE IF EXISTS `cuadro`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cuadro` (
  `idCuadro` int(11) NOT NULL,
  `idPintor` int(11) NOT NULL,
  `idExposicion` int(11) NOT NULL,
  `idEstilo` int(11) NOT NULL,
  `nombreCuadro` varchar(100) DEFAULT NULL,
  `estilo` varchar(20) DEFAULT NULL,
  `descripcionCuadro` varchar(100) DEFAULT NULL,
  `fotoCuadro` varchar(150) DEFAULT NULL,
  `foto` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`idCuadro`),
  KEY `fk_Cuadro_Pintor` (`idPintor`),
  KEY `fk_Cuadro_Excposicion1` (`idExposicion`),
  KEY `fk_Cuadro_Estilo1` (`idEstilo`),
  CONSTRAINT `fk_Cuadro_Estilo1` FOREIGN KEY (`idEstilo`) REFERENCES `estilo` (`idEstilo`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_Cuadro_Excposicion1` FOREIGN KEY (`idExposicion`) REFERENCES `exposicion` (`idExposicion`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_Cuadro_Pintor` FOREIGN KEY (`idPintor`) REFERENCES `pintor` (`idPintor`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cuadro`
--

LOCK TABLES `cuadro` WRITE;
/*!40000 ALTER TABLE `cuadro` DISABLE KEYS */;
INSERT INTO `cuadro` VALUES (1,1,1,1,'Gernika',NULL,'Guernica es un famoso cuadro de Pablo Picasso, pintado en los meses de mayo y junio de 1937, cuyo tí','Gernika.jpg','Gernika.jpg');
/*!40000 ALTER TABLE `cuadro` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `datos_bancarios`
--

DROP TABLE IF EXISTS `datos_bancarios`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `datos_bancarios` (
  `email` varchar(50) NOT NULL,
  `numeroTarjeta` int(11) NOT NULL,
  `CCV` int(11) NOT NULL,
  `fechaCaducidad` date NOT NULL,
  PRIMARY KEY (`numeroTarjeta`,`CCV`),
  KEY `fk_Datos_Bancarios_Usuario1` (`email`),
  CONSTRAINT `fk_Datos_Bancarios_Usuario1` FOREIGN KEY (`email`) REFERENCES `usuario` (`email`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `datos_bancarios`
--

LOCK TABLES `datos_bancarios` WRITE;
/*!40000 ALTER TABLE `datos_bancarios` DISABLE KEYS */;
/*!40000 ALTER TABLE `datos_bancarios` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `estilo`
--

DROP TABLE IF EXISTS `estilo`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `estilo` (
  `idEstilo` int(11) NOT NULL,
  `nombreEstilo` varchar(50) DEFAULT NULL,
  `descripcionEstilo` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`idEstilo`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `estilo`
--

LOCK TABLES `estilo` WRITE;
/*!40000 ALTER TABLE `estilo` DISABLE KEYS */;
INSERT INTO `estilo` VALUES (1,'Renacentista','Descripcion prueba renac'),(2,'Cubista','descr');
/*!40000 ALTER TABLE `estilo` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `exposicion`
--

DROP TABLE IF EXISTS `exposicion`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `exposicion` (
  `idExposicion` int(11) NOT NULL,
  `idSala` int(11) NOT NULL,
  `nombreExposicion` varchar(50) DEFAULT NULL,
  `fechaInicio` date DEFAULT NULL,
  `fechaFin` date DEFAULT NULL,
  `descripcionExpo` varchar(5000) DEFAULT NULL,
  `cartel` varchar(500) DEFAULT NULL,
  PRIMARY KEY (`idExposicion`),
  KEY `fk_Excposicion_Sala_Museo1` (`idSala`),
  CONSTRAINT `fk_Excposicion_Sala_Museo1` FOREIGN KEY (`idSala`) REFERENCES `sala_museo` (`idSala`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `exposicion`
--

LOCK TABLES `exposicion` WRITE;
/*!40000 ALTER TABLE `exposicion` DISABLE KEYS */;
INSERT INTO `exposicion` VALUES (1,1,'Exposicion Renacentista','0000-00-00','0000-00-00','Renacimiento es el nombre dado a un amplio movimiento cultural que se produjo en Europa Occidental en los siglos XV y XVI. Sus principales exponentes se hallan en el campo de las artes, aunque también se produjo una renovación en las ciencias, tanto naturales como humanas. Italia fue el lugar de nacimiento y desarrollo de este movimiento.El Renacimiento fue fruto de la difusión de las ideas del humanismo, que determinaron una nueva concepción del hombre y del mundo. El nombre «renacimiento» se utilizó porque este movimiento retomaba ciertos elementos de la cultura clásica. El término se aplicó originariamente como una vuelta a los valores de la cultura grecolatina y a la contemplación libre de la naturaleza tras siglos de predominio de un tipo de mentalidad más rígida y dogmática establecida en la Europa de la Edad Media. Esta nueva etapa planteó una nueva forma de ver el mundo y al ser humano, con nuevos enfoques en los campos de las artes, la política y las ciencias, sustituyendo el teocentrismo medieval por cierto antropocentrismo.','Exposicion Renacentista.jpg'),(2,2,'Epoca Negra Goya',NULL,NULL,'Pinturas negras (1819–1823) es el nombre que recibe una serie de catorce obras murales de Francisco de Goya, pintadas con la técnica de óleo al secco (sobre paredes recubiertas de yeso). Las creó como decoración de los muros de su casa, llamada la Quinta del Sordo, que había adquirido en febrero de 1819. Estos murales fueron trasladados a lienzo a partir de 1874, y actualmente se conservan en el Museo del Prado de Madrid.La serie, a cuyos óleos Goya no puso título, fue catalogada en 1828 por el amigo de Goya Antonio de Brugada1 y se compone de los siguientes lienzos: Átropos o Las Parcas, Dos viejos o Un viejo y un fraile, Dos viejos comiendo sopa, Duelo a garrotazos o La riña, El aquelarre, Hombres leyendo, Judith y Holofernes, La romería de San Isidro, Dos mujeres y un hombre, Peregrinación a la fuente de San Isidro o Procesión del Santo Oficio, Perro semihundido o más simplemente El perro, Saturno devorando a un hijo, Una manola: doña Leocadia Zorrilla y Visión fantástica o Asmodea.','Epoca Negra Goya.jpg');
/*!40000 ALTER TABLE `exposicion` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `linea_carrito`
--

DROP TABLE IF EXISTS `linea_carrito`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `linea_carrito` (
  `idLinea_Carrito` int(11) NOT NULL,
  `idCarrito` int(11) NOT NULL,
  `idCopia_Cuadro` int(11) NOT NULL,
  `imagenProducto` varchar(150) DEFAULT NULL,
  `nombreProducto` varchar(50) DEFAULT NULL,
  `unidades` int(11) DEFAULT NULL,
  `precio` int(11) DEFAULT NULL,
  `IVA` int(11) NOT NULL,
  `totalLinea` int(11) DEFAULT NULL,
  PRIMARY KEY (`idLinea_Carrito`,`idCarrito`),
  KEY `fk_Linea_Carrito_Carrito1` (`idCarrito`),
  KEY `fk_Linea_Carrito_Copia_Cuadro1` (`idCopia_Cuadro`),
  CONSTRAINT `fk_Linea_Carrito_Carrito1` FOREIGN KEY (`idCarrito`) REFERENCES `carrito` (`idCarrito`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_Linea_Carrito_Copia_Cuadro1` FOREIGN KEY (`idCopia_Cuadro`) REFERENCES `copia_cuadro` (`idCopia_Cuadro`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `linea_carrito`
--

LOCK TABLES `linea_carrito` WRITE;
/*!40000 ALTER TABLE `linea_carrito` DISABLE KEYS */;
/*!40000 ALTER TABLE `linea_carrito` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `linea_pedido`
--

DROP TABLE IF EXISTS `linea_pedido`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `linea_pedido` (
  `idLinea_Pedido` int(11) NOT NULL,
  `idPedido` int(11) NOT NULL,
  `idCopia_Cuadro` int(11) NOT NULL,
  `nombreProducto` varchar(50) DEFAULT NULL,
  `unidades` int(11) DEFAULT NULL,
  `precio` int(11) DEFAULT NULL,
  `IVA` int(11) DEFAULT NULL,
  `totalLinea` int(11) DEFAULT NULL,
  KEY `fk_LInea_Pedido_Pedido1` (`idPedido`),
  KEY `fk_LInea_Pedido_Copia_Cuadro1` (`idCopia_Cuadro`),
  CONSTRAINT `fk_LInea_Pedido_Copia_Cuadro1` FOREIGN KEY (`idCopia_Cuadro`) REFERENCES `copia_cuadro` (`idCopia_Cuadro`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_LInea_Pedido_Pedido1` FOREIGN KEY (`idPedido`) REFERENCES `pedido` (`idPedido`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `linea_pedido`
--

LOCK TABLES `linea_pedido` WRITE;
/*!40000 ALTER TABLE `linea_pedido` DISABLE KEYS */;
/*!40000 ALTER TABLE `linea_pedido` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `pedido`
--

DROP TABLE IF EXISTS `pedido`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `pedido` (
  `email` varchar(50) NOT NULL,
  `idPedido` int(11) NOT NULL,
  `fecha` date DEFAULT NULL,
  `precioTotal` int(11) DEFAULT NULL,
  `estado` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`idPedido`),
  KEY `fk_Pedido_Usuario1` (`email`),
  CONSTRAINT `fk_Pedido_Usuario1` FOREIGN KEY (`email`) REFERENCES `usuario` (`email`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `pedido`
--

LOCK TABLES `pedido` WRITE;
/*!40000 ALTER TABLE `pedido` DISABLE KEYS */;
/*!40000 ALTER TABLE `pedido` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `pintor`
--

DROP TABLE IF EXISTS `pintor`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `pintor` (
  `idPintor` int(11) NOT NULL,
  `nombrePintor` varchar(50) DEFAULT NULL,
  `bioPintor` varchar(5000) DEFAULT NULL,
  `fechaNacimiento` date NOT NULL,
  `fechaMuerte` date DEFAULT NULL,
  `fotoPintor` varchar(150) DEFAULT NULL,
  PRIMARY KEY (`idPintor`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `pintor`
--

LOCK TABLES `pintor` WRITE;
/*!40000 ALTER TABLE `pintor` DISABLE KEYS */;
INSERT INTO `pintor` VALUES (1,'Peter Paul Rubens','Peter Paul Rubens (Siegen, Sacro Imperio Romano Germánico, actual Alemania, 28 de junio de 1577 — Amberes, Flandes (Países Bajos Españoles), actual Bélgica, 30 de mayo de 1640), también conocido en español como Pedro Pablo Rubens,1 fue un pintor barroco de la escuela flamenca. Su estilo exuberante enfatizaba el movimiento, el color y la sensualidad. Sus principales influencias procedían del arte de la Antigua Grecia, el de la Antigua Roma y la pintura renacentista, en especial Leonardo da Vinci, Tiziano y Miguel Ángel, del que admiraba su representación de la anatomía.','0000-00-00',NULL,'Peter Paul Rubens.jpg'),(2,'Joan Miro','Joan Miró i Ferrà (Barcelona, 20 de abril de 1893 — Palma de Mallorca, 25 de diciembre de 1983) pintor, escultor, grabador y ceramista español, considerado uno de los máximos representantes del surrealismo. En su obra reflejó su interés en el subconsciente, en lo \"infantil\" y en su país. En un principio mostró fuertes influencias fauves, cubistas y expresionistas, pasando a una pintura plana con cierto aire naïf, como lo es su conocido cuadro La Masía del año 1920. A partir de su estancia en París, su obra se vuelve más onírica, coincidiendo con los puntos del surrealismo e incorporándose a este movimiento.','0000-00-00',NULL,'Joan Miro.jpg'),(3,'Pablo Picasso','Pablo Ruiz y Picasso1 (Málaga, España; 25 de octubre de 1881 — Mougins, Francia; 8 de abril de 1973), conocido como Pablo Picasso, fue un pintor y escultor español, creador, junto con Georges Braque y Juan Gris, del movimiento cubista.','0000-00-00',NULL,'Pablo Picasso.jpg'),(4,'Salvador Dali','Salvador Felipe Jacinto Dalí i Domènech,1 marqués de Dalí de Púbol (Figueras, 11 de mayo de 1904 – ibídem, 23 de enero de 1989), fue un pintor, escultor, grabador, escenógrafo y escritor español, considerado uno de los máximos representantes del surrealismo.','0000-00-00',NULL,'Salvador Dali.jpg');
/*!40000 ALTER TABLE `pintor` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `planta_museo`
--

DROP TABLE IF EXISTS `planta_museo`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `planta_museo` (
  `idPlanta` int(11) NOT NULL,
  `numeroPlanta` int(2) NOT NULL,
  `capacidad` int(3) NOT NULL,
  PRIMARY KEY (`idPlanta`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `planta_museo`
--

LOCK TABLES `planta_museo` WRITE;
/*!40000 ALTER TABLE `planta_museo` DISABLE KEYS */;
INSERT INTO `planta_museo` VALUES (1,1,100),(2,2,100),(3,3,100);
/*!40000 ALTER TABLE `planta_museo` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `recibo`
--

DROP TABLE IF EXISTS `recibo`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `recibo` (
  `idRecibo` int(11) NOT NULL,
  `idPedido` int(11) NOT NULL,
  `reciboHTML` varchar(4000) DEFAULT NULL,
  PRIMARY KEY (`idRecibo`),
  KEY `fk_Recibo_Pedido1` (`idPedido`),
  CONSTRAINT `fk_Recibo_Pedido1` FOREIGN KEY (`idPedido`) REFERENCES `pedido` (`idPedido`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `recibo`
--

LOCK TABLES `recibo` WRITE;
/*!40000 ALTER TABLE `recibo` DISABLE KEYS */;
/*!40000 ALTER TABLE `recibo` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sala_museo`
--

DROP TABLE IF EXISTS `sala_museo`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `sala_museo` (
  `idSala` int(11) NOT NULL,
  `idPlanta` int(11) NOT NULL,
  `nombreSala` varchar(45) NOT NULL,
  `descripcionSala` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`idSala`),
  KEY `fk_Sala_Museo_Planta_Museo1` (`idPlanta`),
  CONSTRAINT `fk_Sala_Museo_Planta_Museo1` FOREIGN KEY (`idPlanta`) REFERENCES `planta_museo` (`idPlanta`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sala_museo`
--

LOCK TABLES `sala_museo` WRITE;
/*!40000 ALTER TABLE `sala_museo` DISABLE KEYS */;
INSERT INTO `sala_museo` VALUES (1,1,'Sala 1','Primera sala'),(2,2,'Sala 2','Segunda sala');
/*!40000 ALTER TABLE `sala_museo` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `usuario`
--

DROP TABLE IF EXISTS `usuario`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `usuario` (
  `email` varchar(50) NOT NULL,
  `clave` varchar(100) NOT NULL,
  `nombre` varchar(20) DEFAULT NULL,
  `nif` varchar(10) NOT NULL,
  `dir` varchar(50) DEFAULT NULL,
  `cp` int(11) DEFAULT NULL,
  `telf` int(11) DEFAULT NULL,
  `fechaAlta` date NOT NULL,
  PRIMARY KEY (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `usuario`
--

LOCK TABLES `usuario` WRITE;
/*!40000 ALTER TABLE `usuario` DISABLE KEYS */;
INSERT INTO `usuario` VALUES ('bullerwins@gmail.com','admin','rodri','51112811A','calle ass',28002,91555555,'0000-00-00');
/*!40000 ALTER TABLE `usuario` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2013-12-26 17:25:20
