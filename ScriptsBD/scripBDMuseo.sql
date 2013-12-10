SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='TRADITIONAL';

CREATE SCHEMA IF NOT EXISTS `bd_Museo` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci ;
USE `bd_Museo` ;

-- -----------------------------------------------------
-- Table `bd_Museo`.`Administrador`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `bd_Museo`.`Administrador` (
  `email` VARCHAR(50) NOT NULL ,
  `clave` VARCHAR(100) NOT NULL ,
  `fechaAlta` DATE NOT NULL ,
  PRIMARY KEY (`email`) )
ENGINE = InnoDB;

-- -----------------------------------------------------
-- Table `bd_Museo`.`Pintor`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `bd_Museo`.`Pintor` (
  `idPintor` INT NOT NULL AUTO_INCREMENT ,
  `nombrePintor` VARCHAR(50) NULL ,
  `bioPintor` VARCHAR(4000) NULL ,
  `fechaNacimiento` DATE NOT NULL ,
  `fechaMuerte` DATE NULL ,
  `fotoPintor` VARCHAR(150) NULL ,
  PRIMARY KEY (`idPintor`) )
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `bd_Museo`.`Planta_Museo`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `bd_Museo`.`Planta_Museo` (
  `idPlanta` INT NOT NULL AUTO_INCREMENT ,
  `numeroPlanta` INT(2) NOT NULL ,
  `capacidad` INT(3) NOT NULL ,
  PRIMARY KEY (`idPlanta`) )
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `bd_Museo`.`Sala_Museo`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `bd_Museo`.`Sala_Museo` (
  `idSala` INT NOT NULL AUTO_INCREMENT ,
  `idPlanta` INT NOT NULL ,
  `nombreSala` VARCHAR(45) NOT NULL ,
  `descripcionSala` VARCHAR(45) NULL ,
  PRIMARY KEY (`idSala`) ,
  INDEX `fk_Sala_Museo_Planta_Museo1` (`idPlanta` ASC) ,
  CONSTRAINT `fk_Sala_Museo_Planta_Museo1`
    FOREIGN KEY (`idPlanta` )
    REFERENCES `bd_Museo`.`Planta_Museo` (`idPlanta` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `bd_Museo`.`Exposicion`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `bd_Museo`.`Exposicion` (
  `idExposicion` INT NOT NULL AUTO_INCREMENT ,
  `idSala` INT NOT NULL ,
  `nombreExposicion` VARCHAR(50) NULL ,
  `fechaInicio` DATE NULL ,
  `fechaFIn` DATE NULL ,
  `descripcionExpo` VARCHAR(100) NULL ,
  PRIMARY KEY (`idExposicion`) ,
  INDEX `fk_Exposicion_Sala_Museo1` (`idSala` ASC) ,
  CONSTRAINT `fk_Exposicion_Sala_Museo1`
    FOREIGN KEY (`idSala` )
    REFERENCES `bd_Museo`.`Sala_Museo` (`idSala` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `bd_Museo`.`Estilo`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `bd_Museo`.`Estilo` (
  `idEstilo` INT NOT NULL AUTO_INCREMENT ,
  `nombreEstilo` VARCHAR(50) NULL ,
  `descripcionEstilo` VARCHAR(100) NULL ,
  PRIMARY KEY (`idEstilo`) )
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `bd_Museo`.`Cuadro`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `bd_Museo`.`Cuadro` (
  `idCuadro` INT NOT NULL AUTO_INCREMENT ,
  `idPintor` INT NOT NULL ,
  `idExposicion` INT NOT NULL ,
  `idEstilo` INT NOT NULL ,
  `nombreCuadro` VARCHAR(100) NULL ,
  `descripcionCuadro` VARCHAR(100) NULL ,
  `fotoCuadro` VARCHAR(150) NULL ,
  PRIMARY KEY (`idCuadro`) ,
  INDEX `fk_Cuadro_Pintor` (`idPintor` ASC) ,
  INDEX `fk_Cuadro_Exposicion1` (`idExposicion` ASC) ,
  INDEX `fk_Cuadro_Estilo1` (`idEstilo` ASC) ,
  CONSTRAINT `fk_Cuadro_Pintor`
    FOREIGN KEY (`idPintor` )
    REFERENCES `bd_Museo`.`Pintor` (`idPintor` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_Cuadro_Exposicion1`
    FOREIGN KEY (`idExposicion` )
    REFERENCES `bd_Museo`.`Exposicion` (`idExposicion` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_Cuadro_Estilo1`
    FOREIGN KEY (`idEstilo` )
    REFERENCES `bd_Museo`.`Estilo` (`idEstilo` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `bd_Museo`.`Copia_Cuadro`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `bd_Museo`.`Copia_Cuadro` (
  `idCopia_Cuadro` INT NOT NULL AUTO_INCREMENT ,
  `nombreProducto` VARCHAR(100) NULL ,
  `autor` VARCHAR(50) NULL ,
  `estilo` VARCHAR(50) NULL ,
  `fechaAlta` DATE NOT NULL ,
  `descripcion` VARCHAR(200) NULL ,
  `precio` INT NOT NULL ,
  PRIMARY KEY (`idCopia_Cuadro`) )
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `bd_Museo`.`Usuario`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `bd_Museo`.`Usuario` (
  `email` VARCHAR(50) NOT NULL ,
  `clave` VARCHAR(100) NOT NULL ,
  `nombre` VARCHAR(20) NULL ,
  `nif` VARCHAR(10) NOT NULL ,
  `dir` VARCHAR(50) NULL ,
  `cp` INT NULL ,
  `telf` INT NULL ,
  `fechaAlta` DATE NOT NULL ,
  PRIMARY KEY (`email`) )
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `bd_Museo`.`Carrito`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `bd_Museo`.`Carrito` (
  `idCarrito` INT NOT NULL AUTO_INCREMENT ,
  `email` VARCHAR(50) NOT NULL ,
  `fechaCreacion` DATE NOT NULL ,
  `fechaExpir` DATE NULL ,
  PRIMARY KEY (`idCarrito`) ,
  INDEX `fk_Carrito_Usuario1` (`email` ASC) ,
  CONSTRAINT `fk_Carrito_Usuario1`
    FOREIGN KEY (`email` )
    REFERENCES `bd_Museo`.`Usuario` (`email` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `bd_Museo`.`Linea_Carrito`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `bd_Museo`.`Linea_Carrito` (
  `idLinea_Carrito` INT NOT NULL AUTO_INCREMENT,
  `idCarrito` INT NOT NULL ,
  `idCopia_Cuadro` INT NOT NULL ,
  `nombreProducto` VARCHAR(50) NULL ,
  `unidades` INT NULL ,
  `precio` INT NULL ,
  `IVA` INT NOT NULL ,
  `totalLinea` INT NULL ,
  PRIMARY KEY (`idLinea_Carrito`, `idCarrito`) ,
  INDEX `fk_Linea_Carrito_Carrito1` (`idCarrito` ASC) ,
  INDEX `fk_Linea_Carrito_Copia_Cuadro1` (`idCopia_Cuadro` ASC) ,
  CONSTRAINT `fk_Linea_Carrito_Carrito1`
    FOREIGN KEY (`idCarrito` )
    REFERENCES `bd_Museo`.`Carrito` (`idCarrito` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_Linea_Carrito_Copia_Cuadro1`
    FOREIGN KEY (`idCopia_Cuadro` )
    REFERENCES `bd_Museo`.`Copia_Cuadro` (`idCopia_Cuadro` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `bd_Museo`.`Datos_Bancarios`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `bd_Museo`.`Datos_Bancarios` (
  `email` VARCHAR(50) NOT NULL ,
  `numeroTarjeta` BIGINT NOT NULL ,
  `CCV` INT NOT NULL ,
  `fechaCaducidad` DATE NOT NULL ,
  INDEX `fk_Datos_Bancarios_Usuario1` (`email` ASC) ,
  PRIMARY KEY (`numeroTarjeta`, `CCV`) ,
  CONSTRAINT `fk_Datos_Bancarios_Usuario1`
    FOREIGN KEY (`email` )
    REFERENCES `bd_Museo`.`Usuario` (`email` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `bd_Museo`.`Pedido`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `bd_Museo`.`Pedido` (
  `email` VARCHAR(50) NOT NULL ,
  `idPedido` INT NOT NULL AUTO_INCREMENT ,
  `fecha` DATE NULL ,
  `precioTotal` INT NULL ,
  `estado` VARCHAR(45) NULL ,
  INDEX `fk_Pedido_Usuario1` (`email` ASC) ,
  PRIMARY KEY (`idPedido`) ,
  CONSTRAINT `fk_Pedido_Usuario1`
    FOREIGN KEY (`email` )
    REFERENCES `bd_Museo`.`Usuario` (`email` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `bd_Museo`.`Linea_Pedido`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `bd_Museo`.`Linea_Pedido` (
  `idLinea_Pedido` INT NOT NULL ,
  `idPedido` INT NOT NULL ,
  `idCopia_Cuadro` INT NOT NULL ,
  `nombreProducto` VARCHAR(50) NULL ,
  `unidades` INT NULL ,
  `precio` INT NULL ,
  `IVA` INT NULL ,
  `totalLinea` INT NULL ,
  INDEX `fk_LInea_Pedido_Pedido1` (`idPedido` ASC) ,
  INDEX `fk_LInea_Pedido_Copia_Cuadro1` (`idCopia_Cuadro` ASC) ,
  CONSTRAINT `fk_LInea_Pedido_Pedido1`
    FOREIGN KEY (`idPedido` )
    REFERENCES `bd_Museo`.`Pedido` (`idPedido` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_LInea_Pedido_Copia_Cuadro1`
    FOREIGN KEY (`idCopia_Cuadro` )
    REFERENCES `bd_Museo`.`Copia_Cuadro` (`idCopia_Cuadro` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `bd_Museo`.`Recibo`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `bd_Museo`.`Recibo` (
  `idRecibo` INT NOT NULL AUTO_INCREMENT ,
  `idPedido` INT NOT NULL ,
  `reciboHTML` VARCHAR(4000) NULL ,
  PRIMARY KEY (`idRecibo`) ,
  INDEX `fk_Recibo_Pedido1` (`idPedido` ASC) ,
  CONSTRAINT `fk_Recibo_Pedido1`
    FOREIGN KEY (`idPedido` )
    REFERENCES `bd_Museo`.`Pedido` (`idPedido` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `bd_Museo`.`Actualizacion`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `bd_Museo`.`Actualizacion` (
  `idActualizacion` INT NOT NULL AUTO_INCREMENT ,
  `tituloActualizacion` VARCHAR(50) NOT NULL ,
  `fechaActualizacion` DATE NOT NULL ,
  `descActualizacion` VARCHAR(200) NOT NULL ,
  `Usuario_email` VARCHAR(50) NOT NULL ,
  PRIMARY KEY (`idActualizacion`) ,
  INDEX `fk_Actualizacion_Usuario1` (`Usuario_email` ASC) ,
  CONSTRAINT `fk_Actualizacion_Usuario1`
    FOREIGN KEY (`Usuario_email` )
    REFERENCES `bd_Museo`.`Usuario` (`email` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;



SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
