-- MySQL Workbench Forward Engineering

SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION';

-- -----------------------------------------------------
-- Schema mydb
-- -----------------------------------------------------
-- -----------------------------------------------------
-- Schema lucidkart
-- -----------------------------------------------------

-- -----------------------------------------------------
-- Schema lucidkart
-- -----------------------------------------------------
CREATE SCHEMA IF NOT EXISTS `lucidkart` DEFAULT CHARACTER SET latin1 ;
USE `lucidkart` ;

-- -----------------------------------------------------
-- Table `lucidkart`.`category`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `lucidkart`.`category` (
  `categoryId` INT(11) NOT NULL AUTO_INCREMENT,
  `categoryName` VARCHAR(20) NOT NULL,
  PRIMARY KEY (`categoryId`))
ENGINE = InnoDB
AUTO_INCREMENT = 24
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `lucidkart`.`customer`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `lucidkart`.`customer` (
  `customerId` INT(11) NOT NULL AUTO_INCREMENT,
  `userId` VARCHAR(15) NOT NULL,
  `password` VARCHAR(15) NOT NULL,
  `firstName` VARCHAR(20) NOT NULL,
  `lastName` VARCHAR(20) NOT NULL,
  `phone` VARCHAR(14) NOT NULL,
  `email` VARCHAR(50) NOT NULL,
  `address` VARCHAR(20) NOT NULL,
  `city` VARCHAR(10) NOT NULL,
  `province` VARCHAR(2) NOT NULL,
  `postalCode` VARCHAR(7) NOT NULL,
  PRIMARY KEY (`customerId`),
  UNIQUE INDEX `userId` (`userId` ASC) VISIBLE)
ENGINE = InnoDB
AUTO_INCREMENT = 20
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `lucidkart`.`item`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `lucidkart`.`item` (
  `itemId` INT(11) NOT NULL AUTO_INCREMENT,
  `itemName` VARCHAR(30) NOT NULL,
  `itemCategory` INT(11) NOT NULL,
  `latestCollection` TINYINT(1) NOT NULL,
  `itemPrice` FLOAT NOT NULL,
  `itemImage` VARCHAR(100) NOT NULL,
  `description` TEXT NOT NULL,
  `onHand` INT(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`itemId`))
ENGINE = InnoDB
AUTO_INCREMENT = 70
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `lucidkart`.`orderDetail`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `lucidkart`.`orderDetail` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `orderId` INT(11) NOT NULL,
  `itemId` INT(11) NOT NULL,
  `qty` INT(11) NOT NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB
AUTO_INCREMENT = 47
DEFAULT CHARACTER SET = utf8
COLLATE = utf8_unicode_ci;


-- -----------------------------------------------------
-- Table `lucidkart`.`orderHeader`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `lucidkart`.`orderHeader` (
  `orderId` INT(11) NOT NULL AUTO_INCREMENT,
  `customerId` INT(11) NOT NULL,
  `orderDate` DATE NOT NULL,
  `firstName` VARCHAR(20) NOT NULL,
  `lastName` VARCHAR(20) NOT NULL,
  `phoneNumber` VARCHAR(15) NOT NULL,
  `address` VARCHAR(30) NOT NULL,
  `city` VARCHAR(15) NOT NULL,
  `province` VARCHAR(2) NOT NULL,
  `postalCode` VARCHAR(7) NOT NULL,
  `dispatchedDate` DATE NULL DEFAULT NULL,
  PRIMARY KEY (`orderId`),
  INDEX `customerId` (`customerId` ASC) VISIBLE)
ENGINE = InnoDB
AUTO_INCREMENT = 29
DEFAULT CHARACTER SET = utf8
COLLATE = utf8_unicode_ci;


-- -----------------------------------------------------
-- Table `lucidkart`.`province`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `lucidkart`.`province` (
  `code` VARCHAR(2) NOT NULL,
  `name` VARCHAR(30) NOT NULL,
  `taxrate` FLOAT NOT NULL)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8
COLLATE = utf8_unicode_ci;


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
