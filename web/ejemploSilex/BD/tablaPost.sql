SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='TRADITIONAL,ALLOW_INVALID_DATES';

CREATE SCHEMA IF NOT EXISTS `ejSilex` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci ;
USE `ejSilex` ;

-- -----------------------------------------------------
-- Table `ejSilex`.`Post`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `ejSilex`.`Post` (
  `idPost` INT NOT NULL,
  `titulo` VARCHAR(45) NULL,
  `autor` VARCHAR(45) NULL,
  `cuerpo` VARCHAR(100) NULL,
  `fecha` VARCHAR(10) NULL,
  PRIMARY KEY (`idPost`))
ENGINE = InnoDB;


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;

-- -----------------------------------------------------
-- Data for table `ejSilex`.`Post`
-- -----------------------------------------------------
START TRANSACTION;
USE `ejSilex`;
INSERT INTO `ejSilex`.`Post` (`idPost`, `titulo`, `autor`, `cuerpo`, `fecha`) VALUES (1, 'primer post', 'jng', 'Ejemplo de post #1', '15/10/2013');
INSERT INTO `ejSilex`.`Post` (`idPost`, `titulo`, `autor`, `cuerpo`, `fecha`) VALUES (2, 'segundo post', 'rm', 'Ejemplo de post #2', '15/09/2013');
INSERT INTO `ejSilex`.`Post` (`idPost`, `titulo`, `autor`, `cuerpo`, `fecha`) VALUES (3, 'tercer post', 'yoyodin', 'Ejemplo de post #3', '15/08/2013');

COMMIT;

