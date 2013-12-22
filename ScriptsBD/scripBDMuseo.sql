SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='TRADITIONAL,ALLOW_INVALID_DATES';

CREATE SCHEMA IF NOT EXISTS `bd_Museo` DEFAULT CHARACTER SET latin1 ;
USE `bd_Museo` ;

-- -----------------------------------------------------
-- Table `bd_Museo`.`Administrador`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `bd_Museo`.`Administrador` (
  `email` VARCHAR(50) NOT NULL,
  `clave` VARCHAR(100) NOT NULL,
  `fechaAlta` DATE NOT NULL,
  PRIMARY KEY (`email`))
ENGINE = InnoDB
DEFAULT CHARACTER SET = latin1;


-- -----------------------------------------------------
-- Table `bd_Museo`.`Actualizacion`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `bd_Museo`.`Actualizacion` (
  `idActualizacion` INT(11) NOT NULL AUTO_INCREMENT,
  `tituloActualizacion` VARCHAR(50) NOT NULL,
  `fechaActualizacion` DATE NOT NULL,
  `descActualizacion` VARCHAR(200) NOT NULL,
  `Usuario_email` VARCHAR(50) NOT NULL,
  PRIMARY KEY (`idActualizacion`),
  INDEX `fk_Actualizacion_Usuario1` (`Usuario_email` ASC),
  CONSTRAINT `fk_Actualizacion_Usuario1`
    FOREIGN KEY (`Usuario_email`)
    REFERENCES `bd_Museo`.`Administrador` (`email`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
AUTO_INCREMENT = 10
DEFAULT CHARACTER SET = latin1;


-- -----------------------------------------------------
-- Table `bd_Museo`.`Usuario`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `bd_Museo`.`Usuario` (
  `email` VARCHAR(50) NOT NULL,
  `clave` VARCHAR(100) NOT NULL,
  `nombre` VARCHAR(20) NULL DEFAULT NULL,
  `nif` VARCHAR(10) NOT NULL,
  `dir` VARCHAR(50) NULL DEFAULT NULL,
  `pais` VARCHAR(50) NULL DEFAULT NULL,
  `provincia` VARCHAR(50) NULL DEFAULT NULL,
  `poblacion` VARCHAR(50) NULL DEFAULT NULL,
  `cp` INT(11) NULL DEFAULT NULL,
  `telf` INT(11) NULL DEFAULT NULL,
  `fechaAlta` DATE NOT NULL,
  PRIMARY KEY (`email`))
ENGINE = InnoDB
DEFAULT CHARACTER SET = latin1;


-- -----------------------------------------------------
-- Table `bd_Museo`.`Carrito`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `bd_Museo`.`Carrito` (
  `idCarrito` INT(11) NOT NULL AUTO_INCREMENT,
  `email` VARCHAR(50) NOT NULL,
  `fechaCreacion` DATE NOT NULL,
  `fechaExpir` DATE NULL DEFAULT NULL,
  PRIMARY KEY (`idCarrito`),
  INDEX `fk_Carrito_Usuario1` (`email` ASC),
  CONSTRAINT `fk_Carrito_Usuario1`
    FOREIGN KEY (`email`)
    REFERENCES `bd_Museo`.`Usuario` (`email`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = latin1;


-- -----------------------------------------------------
-- Table `bd_Museo`.`Copia_Cuadro`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `bd_Museo`.`Copia_Cuadro` (
  `idCopia_Cuadro` INT(11) NOT NULL AUTO_INCREMENT,
  `nombreProducto` VARCHAR(100) NULL DEFAULT NULL,
  `autor` VARCHAR(50) NULL DEFAULT NULL,
  `estilo` VARCHAR(50) NULL DEFAULT NULL,
  `orientacion` VARCHAR(10) NULL DEFAULT NULL,
  `anioCuadro` VARCHAR(4) NULL DEFAULT NULL,
  `fechaAlta` DATE NOT NULL,
  `descripcion` VARCHAR(3000) NULL DEFAULT NULL,
  `precio` INT(11) NOT NULL,
  `fotoCuadro` VARCHAR(150) NULL DEFAULT NULL,
  PRIMARY KEY (`idCopia_Cuadro`))
ENGINE = InnoDB
AUTO_INCREMENT = 5
DEFAULT CHARACTER SET = latin1;


-- -----------------------------------------------------
-- Table `bd_Museo`.`Estilo`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `bd_Museo`.`Estilo` (
  `idEstilo` INT(11) NOT NULL AUTO_INCREMENT,
  `nombreEstilo` VARCHAR(50) NULL DEFAULT NULL,
  `descripcionEstilo` VARCHAR(3000) NULL DEFAULT NULL,
  PRIMARY KEY (`idEstilo`))
ENGINE = InnoDB
AUTO_INCREMENT = 2
DEFAULT CHARACTER SET = latin1;


-- -----------------------------------------------------
-- Table `bd_Museo`.`Planta_Museo`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `bd_Museo`.`Planta_Museo` (
  `idPlanta` INT(11) NOT NULL AUTO_INCREMENT,
  `numeroPlanta` INT(2) NOT NULL,
  `capacidad` INT(3) NOT NULL,
  PRIMARY KEY (`idPlanta`))
ENGINE = InnoDB
AUTO_INCREMENT = 2
DEFAULT CHARACTER SET = latin1;


-- -----------------------------------------------------
-- Table `bd_Museo`.`Sala_Museo`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `bd_Museo`.`Sala_Museo` (
  `idSala` INT(11) NOT NULL AUTO_INCREMENT,
  `idPlanta` INT(11) NOT NULL,
  `nombreSala` VARCHAR(45) NOT NULL,
  `descripcionSala` VARCHAR(45) NULL DEFAULT NULL,
  PRIMARY KEY (`idSala`),
  INDEX `fk_Sala_Museo_Planta_Museo1` (`idPlanta` ASC),
  CONSTRAINT `fk_Sala_Museo_Planta_Museo1`
    FOREIGN KEY (`idPlanta`)
    REFERENCES `bd_Museo`.`Planta_Museo` (`idPlanta`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
AUTO_INCREMENT = 2
DEFAULT CHARACTER SET = latin1;


-- -----------------------------------------------------
-- Table `bd_Museo`.`Exposicion`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `bd_Museo`.`Exposicion` (
  `idExposicion` INT(11) NOT NULL AUTO_INCREMENT,
  `idSala` INT(11) NOT NULL,
  `nombreExposicion` VARCHAR(50) NULL DEFAULT NULL,
  `fechaInicio` DATE NULL DEFAULT NULL,
  `fechaFin` DATE NULL DEFAULT NULL,
  `descripcionExpo` VARCHAR(2000) NULL DEFAULT NULL,
  PRIMARY KEY (`idExposicion`),
  INDEX `fk_Exposicion_Sala_Museo1` (`idSala` ASC),
  CONSTRAINT `fk_Exposicion_Sala_Museo1`
    FOREIGN KEY (`idSala`)
    REFERENCES `bd_Museo`.`Sala_Museo` (`idSala`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
AUTO_INCREMENT = 2
DEFAULT CHARACTER SET = latin1;


-- -----------------------------------------------------
-- Table `bd_Museo`.`Pintor`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `bd_Museo`.`Pintor` (
  `idPintor` INT(11) NOT NULL AUTO_INCREMENT,
  `nombrePintor` VARCHAR(50) NULL DEFAULT NULL,
  `bioPintor` VARCHAR(4000) NULL DEFAULT NULL,
  `fechaNacimiento` DATE NOT NULL,
  `fechaMuerte` DATE NULL DEFAULT NULL,
  `fotoPintor` VARCHAR(150) NULL DEFAULT NULL,
  PRIMARY KEY (`idPintor`))
ENGINE = InnoDB
AUTO_INCREMENT = 2
DEFAULT CHARACTER SET = latin1;


-- -----------------------------------------------------
-- Table `bd_Museo`.`Cuadro`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `bd_Museo`.`Cuadro` (
  `idCuadro` INT(11) NOT NULL AUTO_INCREMENT,
  `idPintor` INT(11) NOT NULL,
  `idExposicion` INT(11) NOT NULL,
  `idEstilo` INT(11) NOT NULL,
  `nombreCuadro` VARCHAR(100) NULL DEFAULT NULL,
  `descripcionCuadro` VARCHAR(4000) NULL DEFAULT NULL,
  `orientacion` VARCHAR(10) NULL DEFAULT NULL,
  `anioCuadro` VARCHAR(4) NOT NULL,
  `fotoCuadro` VARCHAR(150) NULL DEFAULT NULL,
  PRIMARY KEY (`idCuadro`),
  INDEX `fk_Cuadro_Pintor` (`idPintor` ASC),
  INDEX `fk_Cuadro_Exposicion1` (`idExposicion` ASC),
  INDEX `fk_Cuadro_Estilo1` (`idEstilo` ASC),
  CONSTRAINT `fk_Cuadro_Estilo1`
    FOREIGN KEY (`idEstilo`)
    REFERENCES `bd_Museo`.`Estilo` (`idEstilo`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_Cuadro_Exposicion1`
    FOREIGN KEY (`idExposicion`)
    REFERENCES `bd_Museo`.`Exposicion` (`idExposicion`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_Cuadro_Pintor`
    FOREIGN KEY (`idPintor`)
    REFERENCES `bd_Museo`.`Pintor` (`idPintor`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
AUTO_INCREMENT = 21
DEFAULT CHARACTER SET = latin1;


-- -----------------------------------------------------
-- Table `bd_Museo`.`Datos_Bancarios`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `bd_Museo`.`Datos_Bancarios` (
  `email` VARCHAR(50) NOT NULL,
  `numeroTarjeta` BIGINT(20) NOT NULL,
  `CCV` INT(11) NOT NULL,
  `fechaCaducidad` DATE NOT NULL,
  PRIMARY KEY (`numeroTarjeta`, `CCV`),
  INDEX `fk_Datos_Bancarios_Usuario1` (`email` ASC),
  CONSTRAINT `fk_Datos_Bancarios_Usuario1`
    FOREIGN KEY (`email`)
    REFERENCES `bd_Museo`.`Usuario` (`email`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = latin1;


-- -----------------------------------------------------
-- Table `bd_Museo`.`Linea_Carrito`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `bd_Museo`.`Linea_Carrito` (
  `idLinea_Carrito` INT(11) NOT NULL,
  `idCarrito` INT(11) NOT NULL,
  `idCopia_Cuadro` INT(11) NOT NULL,
  `nombreProducto` VARCHAR(50) NULL DEFAULT NULL,
  `unidades` INT(11) NULL DEFAULT NULL,
  `precio` INT(11) NULL DEFAULT NULL,
  `IVA` INT(11) NOT NULL,
  `totalLinea` INT(11) NULL DEFAULT NULL,
  PRIMARY KEY (`idLinea_Carrito`, `idCarrito`),
  INDEX `fk_Linea_Carrito_Carrito1` (`idCarrito` ASC),
  INDEX `fk_Linea_Carrito_Copia_Cuadro1` (`idCopia_Cuadro` ASC),
  CONSTRAINT `fk_Linea_Carrito_Carrito1`
    FOREIGN KEY (`idCarrito`)
    REFERENCES `bd_Museo`.`Carrito` (`idCarrito`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_Linea_Carrito_Copia_Cuadro1`
    FOREIGN KEY (`idCopia_Cuadro`)
    REFERENCES `bd_Museo`.`Copia_Cuadro` (`idCopia_Cuadro`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = latin1;


-- -----------------------------------------------------
-- Table `bd_Museo`.`Pedido`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `bd_Museo`.`Pedido` (
  `email` VARCHAR(50) NOT NULL,
  `idPedido` INT(11) NOT NULL AUTO_INCREMENT,
  `fecha` DATE NULL DEFAULT NULL,
  `precioTotal` INT(11) NULL DEFAULT NULL,
  `estado` VARCHAR(45) NULL DEFAULT NULL,
  PRIMARY KEY (`idPedido`),
  INDEX `fk_Pedido_Usuario1` (`email` ASC),
  CONSTRAINT `fk_Pedido_Usuario1`
    FOREIGN KEY (`email`)
    REFERENCES `bd_Museo`.`Usuario` (`email`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = latin1;


-- -----------------------------------------------------
-- Table `bd_Museo`.`Linea_Pedido`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `bd_Museo`.`Linea_Pedido` (
  `idLinea_Pedido` INT(11) NOT NULL,
  `idPedido` INT(11) NOT NULL,
  `idCopia_Cuadro` INT(11) NOT NULL,
  `nombreProducto` VARCHAR(50) NULL DEFAULT NULL,
  `unidades` INT(11) NULL DEFAULT NULL,
  `precio` INT(11) NULL DEFAULT NULL,
  `IVA` INT(11) NULL DEFAULT NULL,
  `totalLinea` INT(11) NULL DEFAULT NULL,
  INDEX `fk_LInea_Pedido_Pedido1` (`idPedido` ASC),
  INDEX `fk_LInea_Pedido_Copia_Cuadro1` (`idCopia_Cuadro` ASC),
  CONSTRAINT `fk_LInea_Pedido_Copia_Cuadro1`
    FOREIGN KEY (`idCopia_Cuadro`)
    REFERENCES `bd_Museo`.`Copia_Cuadro` (`idCopia_Cuadro`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_LInea_Pedido_Pedido1`
    FOREIGN KEY (`idPedido`)
    REFERENCES `bd_Museo`.`Pedido` (`idPedido`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = latin1;


-- -----------------------------------------------------
-- Table `bd_Museo`.`Recibo`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `bd_Museo`.`Recibo` (
  `idRecibo` INT(11) NOT NULL AUTO_INCREMENT,
  `idPedido` INT(11) NOT NULL,
  `ReciboHTML` VARCHAR(4000) NULL DEFAULT NULL,
  PRIMARY KEY (`idRecibo`),
  INDEX `fk_Recibo_Pedido1` (`idPedido` ASC),
  CONSTRAINT `fk_Recibo_Pedido1`
    FOREIGN KEY (`idPedido`)
    REFERENCES `bd_Museo`.`Pedido` (`idPedido`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = latin1;


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
