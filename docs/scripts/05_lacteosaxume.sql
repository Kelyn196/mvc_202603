CREATE TABLE `productos` (
    `id_producto` INT NOT NULL AUTO_INCREMENT,
    `nombre` VARCHAR(150) NOT NULL,
    `descripcion` TEXT,
    `precio_menor` DECIMAL(10,2) NOT NULL,
    `precio_mayor` DECIMAL(10,2) NOT NULL,
    `stock` INT NOT NULL,
    `imagen` VARCHAR(255),
    `categoria` VARCHAR(50),
    PRIMARY KEY (`id_producto`)
) ENGINE = InnoDB DEFAULT CHARSET = utf8;

CREATE TABLE `carrito` (
    `id_carrito` INT NOT NULL AUTO_INCREMENT,
    `id_usuario` INT NOT NULL,
    `fecha_creacion` DATETIME DEFAULT CURRENT_TIMESTAMP,
    `estado` ENUM('activo','pagado','cancelado') NOT NULL DEFAULT 'activo',
    PRIMARY KEY (`id_carrito`),
    CONSTRAINT `fk_carrito_usuario` FOREIGN KEY (`id_usuario`)
        REFERENCES `usuarios`(`id_usuario`)
        ON DELETE NO ACTION
) ENGINE = InnoDB DEFAULT CHARSET = utf8;

CREATE TABLE `carrito_detalle` (
    `id_detalle` INT NOT NULL AUTO_INCREMENT,
    `id_carrito` INT NOT NULL,
    `id_producto` INT NOT NULL,
    `cantidad` INT NOT NULL,
    `precio_unitario` DECIMAL(10,2) NOT NULL,
    PRIMARY KEY (`id_detalle`),
    CONSTRAINT `fk_detalle_carrito` FOREIGN KEY (`id_carrito`)
        REFERENCES `carrito`(`id_carrito`)
        ON DELETE CASCADE,
    CONSTRAINT `fk_detalle_producto` FOREIGN KEY (`id_producto`)
        REFERENCES `productos`(`id_producto`)
        ON DELETE NO ACTION
) ENGINE = InnoDB DEFAULT CHARSET = utf8;

CREATE TABLE `transacciones` (
    `id_transaccion` INT NOT NULL AUTO_INCREMENT,
    `id_usuario` INT NOT NULL,
    `id_carrito` INT NOT NULL UNIQUE,
    `monto_total` DECIMAL(10,2) NOT NULL,
    `metodo_pago` VARCHAR(50) NOT NULL,
    `estado_pago` ENUM('pendiente','aprobado','rechazado') NOT NULL DEFAULT 'pendiente',
    `fecha_pago` DATETIME DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (`id_transaccion`),
    CONSTRAINT `fk_transaccion_usuario` FOREIGN KEY (`id_usuario`)
        REFERENCES `usuarios`(`id_usuario`),
    CONSTRAINT `fk_transaccion_carrito` FOREIGN KEY (`id_carrito`)
        REFERENCES `carrito`(`id_carrito`)
) ENGINE = InnoDB DEFAULT CHARSET = utf8;

CREATE TABLE `logs_seguridad` (
    `id_log` INT NOT NULL AUTO_INCREMENT,
    `id_usuario` INT NOT NULL,
    `accion` VARCHAR(255) NOT NULL,
    `fecha` DATETIME DEFAULT CURRENT_TIMESTAMP,
    `ip` VARCHAR(50),
    PRIMARY KEY (`id_log`),
    CONSTRAINT `fk_log_usuario` FOREIGN KEY (`id_usuario`)
        REFERENCES `usuarios`(`id_usuario`)
) ENGINE = InnoDB DEFAULT CHARSET = utf8;