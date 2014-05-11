SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='TRADITIONAL,ALLOW_INVALID_DATES';

CREATE SCHEMA IF NOT EXISTS `book` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci ;

CREATE TABLE IF NOT EXISTS `book`.`customer` (
  `customer_id` INT(11) NOT NULL AUTO_INCREMENT,
  `firstname` VARCHAR(45) NOT NULL,
  `lastname` VARCHAR(45) NOT NULL,
  `email` VARCHAR(60) NOT NULL,
  PRIMARY KEY (`customer_id`),
  UNIQUE INDEX `email_UNIQUE` (`email` ASC))
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8
COLLATE = utf8_general_ci;

CREATE TABLE IF NOT EXISTS `book`.`product` (
  `product_id` INT(11) NOT NULL AUTO_INCREMENT,
  `title` VARCHAR(45) NULL DEFAULT NULL,
  `description` TEXT NULL DEFAULT NULL,
  `price` FLOAT(10,2) NULL DEFAULT NULL,
  PRIMARY KEY (`product_id`))
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8
COLLATE = utf8_general_ci;

CREATE TABLE IF NOT EXISTS `book`.`invoice` (
  `invoice_id` INT(11) NOT NULL AUTO_INCREMENT,
  `status_id` INT(11) NOT NULL,
  `customer_id` INT(11) NOT NULL,
  `price_total` FLOAT(10,2) NOT NULL,
  `date_created` DATETIME NOT NULL,
  PRIMARY KEY (`invoice_id`),
  INDEX `fk_invoice_customer_idx` (`customer_id` ASC),
  INDEX `fk_invoice_invoice_status1_idx` (`status_id` ASC),
  CONSTRAINT `fk_invoice_customer`
    FOREIGN KEY (`customer_id`)
    REFERENCES `book`.`customer` (`customer_id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_invoice_invoice_status1`
    FOREIGN KEY (`status_id`)
    REFERENCES `book`.`invoice_status` (`status_id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8
COLLATE = utf8_general_ci;

CREATE TABLE IF NOT EXISTS `book`.`invoice_item` (
  `invoice_item_id` INT(11) NOT NULL AUTO_INCREMENT,
  `invoice_id` INT(11) NOT NULL,
  `product_id` INT(11) NOT NULL,
  `quantity` INT(11) NOT NULL,
  `price` FLOAT(10,2) NOT NULL,
  PRIMARY KEY (`invoice_item_id`),
  INDEX `fk_invoice_item_product1_idx` (`product_id` ASC),
  CONSTRAINT `fk_invoice_item_invoice1`
    FOREIGN KEY (`invoice_id`)
    REFERENCES `book`.`invoice` (`invoice_id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_invoice_item_product1`
    FOREIGN KEY (`product_id`)
    REFERENCES `book`.`product` (`product_id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8
COLLATE = utf8_general_ci;

CREATE TABLE IF NOT EXISTS `book`.`invoice_status` (
  `status_id` INT(11) NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(45) NOT NULL,
  PRIMARY KEY (`status_id`))
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8
COLLATE = utf8_general_ci;


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
