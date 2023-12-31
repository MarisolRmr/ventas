-- MySQL Script generated by MySQL Workbench
-- Sun Jul  2 22:33:37 2023
-- Model: New Model    Version: 1.0
-- MySQL Workbench Forward Engineering

SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION';

-- -----------------------------------------------------
-- Schema puntoventa
-- -----------------------------------------------------
DROP SCHEMA IF EXISTS `puntoventa` ;

-- -----------------------------------------------------
-- Schema puntoventa
-- -----------------------------------------------------
CREATE SCHEMA IF NOT EXISTS `puntoventa` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_mysql500_ci ;
USE `puntoventa` ;

-- -----------------------------------------------------
-- Table `puntoventa`.`usuarios`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `puntoventa`.`usuarios` ;

CREATE TABLE IF NOT EXISTS `puntoventa`.`usuarios` (
  `id_usuario` INT NOT NULL AUTO_INCREMENT,
  `username` VARCHAR(50) NOT NULL,
  `password` VARCHAR(50) NOT NULL,
  `fotografia` VARCHAR(50) NULL,
  `nombre` VARCHAR(200) NOT NULL,
  `apellido` VARCHAR(200) NOT NULL,
  `telefono` VARCHAR(15) NULL,
  `email` VARCHAR(255) NULL,
  `estatus` VARCHAR(20) NOT NULL,
  `rol` VARCHAR(20) NOT NULL,
  PRIMARY KEY (`id_usuario`),
  UNIQUE INDEX `username_UNIQUE` (`username` ASC) VISIBLE,
  UNIQUE INDEX `email_UNIQUE` (`email` ASC) VISIBLE)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `puntoventa`.`categorias`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `puntoventa`.`categorias` ;

CREATE TABLE IF NOT EXISTS `puntoventa`.`categorias` (
  `id_categoria` INT NOT NULL AUTO_INCREMENT,
  `nombre` VARCHAR(200) NOT NULL,
  `codigo` VARCHAR(50) NOT NULL,
  `descripcion` TEXT NULL,
  `id_usuario` INT NOT NULL,
  PRIMARY KEY (`id_categoria`),
  UNIQUE INDEX `codigo_UNIQUE` (`codigo` ASC) VISIBLE,
  INDEX `fk_categoria_usuario_idx` (`id_usuario` ASC) VISIBLE,
  CONSTRAINT `fk_categoria_usuario`
    FOREIGN KEY (`id_usuario`)
    REFERENCES `puntoventa`.`usuarios` (`id_usuario`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `puntoventa`.`subcategorias`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `puntoventa`.`subcategorias` ;

CREATE TABLE IF NOT EXISTS `puntoventa`.`subcategorias` (
  `id_subcategoria` INT NOT NULL AUTO_INCREMENT,
  `nombre` VARCHAR(200) NOT NULL,
  `codigo` VARCHAR(50) NOT NULL,
  `descripcion` TEXT NULL,
  `id_categoria` INT NOT NULL,
  `id_usuario` INT NOT NULL,
  PRIMARY KEY (`id_subcategoria`),
  UNIQUE INDEX `codigo_UNIQUE` (`codigo` ASC) VISIBLE,
  INDEX `fk_subcategoria_usuario_idx` (`id_usuario` ASC) VISIBLE,
  INDEX `fk_subcategoria_categoria_idx` (`id_categoria` ASC) VISIBLE,
  CONSTRAINT `fk_subcategoria_usuario`
    FOREIGN KEY (`id_usuario`)
    REFERENCES `puntoventa`.`usuarios` (`id_usuario`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_subcategoria_categoria`
    FOREIGN KEY (`id_categoria`)
    REFERENCES `puntoventa`.`categorias` (`id_categoria`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `puntoventa`.`marcas`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `puntoventa`.`marcas` ;

CREATE TABLE IF NOT EXISTS `puntoventa`.`marcas` (
  `id_marca` INT NOT NULL AUTO_INCREMENT,
  `nombre` VARCHAR(200) NOT NULL,
  `imagen` VARCHAR(50) NULL,
  `descripcion` TEXT NULL,
  `id_usuario` INT NOT NULL,
  PRIMARY KEY (`id_marca`),
  INDEX `fk_marca_usuario_idx` (`id_usuario` ASC) VISIBLE,
  CONSTRAINT `fk_marca_usuario`
    FOREIGN KEY (`id_usuario`)
    REFERENCES `puntoventa`.`usuarios` (`id_usuario`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `puntoventa`.`productos`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `puntoventa`.`productos` ;

CREATE TABLE IF NOT EXISTS `puntoventa`.`productos` (
  `id_producto` INT NOT NULL AUTO_INCREMENT,
  `nombre` VARCHAR(200) NOT NULL,
  `precio_compra` DOUBLE NOT NULL,
  `precio_venta` DOUBLE NOT NULL,
  `unidades` INT NOT NULL,
  `id_usuario` INT NOT NULL,
  `id_categoria` INT NOT NULL,
  `id_subcategoria` INT NULL,
  `id_marca` INT NOT NULL,
  PRIMARY KEY (`id_producto`),
  INDEX `fk_producto_usuario_idx` (`id_usuario` ASC) VISIBLE,
  INDEX `fk_producto_categoria_idx` (`id_categoria` ASC) VISIBLE,
  INDEX `fk_producto_subcategoria_idx` (`id_subcategoria` ASC) VISIBLE,
  INDEX `fk_producto_marca_idx` (`id_marca` ASC) VISIBLE,
  CONSTRAINT `fk_producto_usuario`
    FOREIGN KEY (`id_usuario`)
    REFERENCES `puntoventa`.`usuarios` (`id_usuario`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_producto_categoria`
    FOREIGN KEY (`id_categoria`)
    REFERENCES `puntoventa`.`categorias` (`id_categoria`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_producto_subcategoria`
    FOREIGN KEY (`id_subcategoria`)
    REFERENCES `puntoventa`.`subcategorias` (`id_subcategoria`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_producto_marca`
    FOREIGN KEY (`id_marca`)
    REFERENCES `puntoventa`.`marcas` (`id_marca`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `puntoventa`.`recibos`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `puntoventa`.`recibos` ;

CREATE TABLE IF NOT EXISTS `puntoventa`.`recibos` (
  `id_recibo` INT NOT NULL AUTO_INCREMENT,
  `codigo` VARCHAR(50) NOT NULL,
  `estatus` VARCHAR(20) NOT NULL,
  `fecha` DATE NOT NULL,
  PRIMARY KEY (`id_recibo`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `puntoventa`.`clientes`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `puntoventa`.`clientes` ;

CREATE TABLE IF NOT EXISTS `puntoventa`.`clientes` (
  `id_cliente` INT NOT NULL AUTO_INCREMENT,
  `nombre` VARCHAR(200) NOT NULL,
  `codigo` VARCHAR(50) NOT NULL,
  `empresa` VARCHAR(200) NULL,
  `telefono` VARCHAR(50) NULL,
  `email` VARCHAR(200) NULL,
  PRIMARY KEY (`id_cliente`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `puntoventa`.`ventas`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `puntoventa`.`ventas` ;

CREATE TABLE IF NOT EXISTS `puntoventa`.`ventas` (
  `id_venta` INT NOT NULL AUTO_INCREMENT,
  `referencia` VARCHAR(50) NOT NULL,
  `fecha` DATE NOT NULL,
  `estatus` VARCHAR(20) NOT NULL,
  `pago` VARCHAR(20) NOT NULL,
  `total` DOUBLE NULL,
  `pagado` DOUBLE NULL,
  `adeudo` DOUBLE NULL,
  `id_usuario` INT NOT NULL,
  `id_recibo` INT NOT NULL,
  `id_cliente` INT NOT NULL,
  PRIMARY KEY (`id_venta`),
  INDEX `fk_venta_usuario_idx` (`id_usuario` ASC) VISIBLE,
  INDEX `fk_venta_recibo_idx` (`id_recibo` ASC) VISIBLE,
  INDEX `fk_venta_cliente_idx` (`id_cliente` ASC) VISIBLE,
  CONSTRAINT `fk_venta_usuario`
    FOREIGN KEY (`id_usuario`)
    REFERENCES `puntoventa`.`usuarios` (`id_usuario`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_venta_recibo`
    FOREIGN KEY (`id_recibo`)
    REFERENCES `puntoventa`.`recibos` (`id_recibo`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_venta_cliente`
    FOREIGN KEY (`id_cliente`)
    REFERENCES `puntoventa`.`clientes` (`id_cliente`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `puntoventa`.`detalle_ventas`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `puntoventa`.`detalle_ventas` ;

CREATE TABLE IF NOT EXISTS `puntoventa`.`detalle_ventas` (
  `id_detalle_venta` INT NOT NULL AUTO_INCREMENT,
  `cantidad` INT NOT NULL,
  `descuento` DOUBLE NOT NULL,
  `subtotal` DOUBLE NOT NULL,
  `impuestos` DOUBLE NOT NULL,
  `id_producto` INT NOT NULL,
  `id_venta` INT NOT NULL,
  PRIMARY KEY (`id_detalle_venta`),
  INDEX `fk_detalles_venta_idx` (`id_venta` ASC) VISIBLE,
  INDEX `fk_detalles_producto_idx` (`id_producto` ASC) VISIBLE,
  CONSTRAINT `fk_detalles_venta`
    FOREIGN KEY (`id_venta`)
    REFERENCES `puntoventa`.`ventas` (`id_venta`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_detalles_producto`
    FOREIGN KEY (`id_producto`)
    REFERENCES `puntoventa`.`productos` (`id_producto`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `puntoventa`.`devoluciones`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `puntoventa`.`devoluciones` ;

CREATE TABLE IF NOT EXISTS `puntoventa`.`devoluciones` (
  `id_devolucion` INT NOT NULL AUTO_INCREMENT,
  `fecha` DATE NOT NULL,
  `estatus` VARCHAR(20) NOT NULL,
  `total` DOUBLE NOT NULL,
  `pagado` DOUBLE NULL,
  `adeudo` DOUBLE NULL,
  `estatus_pago` VARCHAR(20) NOT NULL,
  `id_producto` INT NOT NULL,
  PRIMARY KEY (`id_devolucion`),
  INDEX `fk_devoluciones_producto_idx` (`id_producto` ASC) VISIBLE,
  CONSTRAINT `fk_devoluciones_producto`
    FOREIGN KEY (`id_producto`)
    REFERENCES `puntoventa`.`productos` (`id_producto`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `puntoventa`.`cotizaciones`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `puntoventa`.`cotizaciones` ;

CREATE TABLE IF NOT EXISTS `puntoventa`.`cotizaciones` (
  `id_cotizacion` INT NOT NULL AUTO_INCREMENT,
  `referencia` VARCHAR(50) NOT NULL,
  `estatus` VARCHAR(20) NOT NULL,
  `total` DOUBLE NOT NULL,
  `id_producto` INT NOT NULL,
  `id_cliente` INT NOT NULL,
  PRIMARY KEY (`id_cotizacion`),
  INDEX `fk_cotizacion_producto_idx` (`id_producto` ASC) VISIBLE,
  INDEX `kk_cotizacion_cliente_idx` (`id_cliente` ASC) VISIBLE,
  CONSTRAINT `fk_cotizacion_producto`
    FOREIGN KEY (`id_producto`)
    REFERENCES `puntoventa`.`productos` (`id_producto`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `kk_cotizacion_cliente`
    FOREIGN KEY (`id_cliente`)
    REFERENCES `puntoventa`.`clientes` (`id_cliente`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `puntoventa`.`proveedores`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `puntoventa`.`proveedores` ;

CREATE TABLE IF NOT EXISTS `puntoventa`.`proveedores` (
  `id_proveedor` INT NOT NULL AUTO_INCREMENT,
  `nombre` VARCHAR(200) NOT NULL,
  `codigo` VARCHAR(50) NOT NULL,
  `telefono` VARCHAR(15) NULL,
  `email` VARCHAR(200) NULL,
  PRIMARY KEY (`id_proveedor`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `puntoventa`.`compras`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `puntoventa`.`compras` ;

CREATE TABLE IF NOT EXISTS `puntoventa`.`compras` (
  `id_compra` INT NOT NULL AUTO_INCREMENT,
  `referencia` VARCHAR(50) NOT NULL,
  `fecha` DATE NOT NULL,
  `estatus` VARCHAR(20) NOT NULL,
  `total` DOUBLE NOT NULL,
  `pagado` DOUBLE NULL,
  `adeudo` DOUBLE NULL,
  `estatus_pago` VARCHAR(20) NOT NULL,
  `id_proveedor` INT NOT NULL,
  PRIMARY KEY (`id_compra`),
  INDEX `fk_compra_proveedor_idx` (`id_proveedor` ASC) VISIBLE,
  CONSTRAINT `fk_compra_proveedor`
    FOREIGN KEY (`id_proveedor`)
    REFERENCES `puntoventa`.`proveedores` (`id_proveedor`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
