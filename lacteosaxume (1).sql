-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 29-07-2026 a las 02:33:51
-- Versión del servidor: 10.4.32-MariaDB
-- Versión de PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `lacteosaxume`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `bitacora`
--

CREATE TABLE `bitacora` (
  `bitacoracod` int(11) NOT NULL,
  `bitacorafch` datetime DEFAULT NULL,
  `bitprograma` varchar(255) DEFAULT NULL,
  `bitdescripcion` varchar(255) DEFAULT NULL,
  `bitobservacion` mediumtext DEFAULT NULL,
  `bitTipo` char(3) DEFAULT NULL,
  `bitusuario` bigint(18) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `carretilla`
--

CREATE TABLE `carretilla` (
  `usercod` bigint(10) NOT NULL,
  `productId` int(11) NOT NULL,
  `crrctd` int(5) NOT NULL,
  `crrprc` decimal(12,2) NOT NULL,
  `crrfching` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `carretilla`
--

INSERT INTO `carretilla` (`usercod`, `productId`, `crrctd`, `crrprc`, `crrfching`) VALUES
(1, 7, 2, 36.00, '2026-07-26 14:30:57'),
(1, 9, 2, 45.00, '2026-07-26 14:30:51');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `carretillaanon`
--

CREATE TABLE `carretillaanon` (
  `anoncod` varchar(128) NOT NULL,
  `productId` int(11) NOT NULL,
  `crrctd` int(5) NOT NULL,
  `crrprc` decimal(12,2) NOT NULL,
  `crrfching` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `funciones`
--

CREATE TABLE `funciones` (
  `fncod` varchar(255) NOT NULL,
  `fndsc` varchar(255) DEFAULT NULL,
  `fnest` char(3) DEFAULT NULL,
  `fntyp` char(3) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Volcado de datos para la tabla `funciones`
--

INSERT INTO `funciones` (`fncod`, `fndsc`, `fnest`, `fntyp`) VALUES
('Controllers\\Carretilla\\Carretilla', 'Controllers\\Carretilla\\Carretilla', 'ACT', 'CTR'),
('Controllers\\Mnt\\ProductForm', 'Controllers\\Mnt\\ProductForm', 'ACT', 'CRT'),
('Controllers\\Mnt\\ProductForm\\DEL', 'Controllers\\Mnt\\ProductForm\\DEL', 'ACT', 'FNC'),
('Controllers\\Mnt\\ProductForm\\DSP', 'Controllers\\Mnt\\ProductForm\\DSP', 'ACT', 'FNC'),
('Controllers\\Mnt\\ProductForm\\INS', 'Controllers\\Mnt\\ProductForm\\INS', 'ACT', 'FNC'),
('Controllers\\Mnt\\ProductForm\\UPD', 'Controllers\\Mnt\\ProductForm\\UPD', 'ACT', 'FNC'),
('Controllers\\Mnt\\ProductList', 'Controllers\\Mnt\\ProductList', 'ACT', 'CTR'),
('Controllers\\Mnt\\ProductList\\DEL', 'Controllers\\Mnt\\ProductList\\DEL', 'ACT', 'FNC'),
('Controllers\\Mnt\\ProductList\\DSP', 'Controllers\\Mnt\\ProductList\\DSP', 'ACT', 'FNC'),
('Controllers\\Mnt\\ProductList\\INS', 'Controllers\\Mnt\\ProductList\\INS', 'ACT', 'FNC'),
('Controllers\\Mnt\\ProductList\\UPD', 'Controllers\\Mnt\\ProductList\\UPD', 'ACT', 'FNC'),
('Controllers\\Mnt\\ResultList', 'Controllers\\Mnt\\ResultList', 'ACT', 'CTR'),
('Menu_PaymentCheckout', 'Menu_PaymentCheckout', 'ACT', 'MNU');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `funciones_roles`
--

CREATE TABLE `funciones_roles` (
  `rolescod` varchar(128) NOT NULL,
  `fncod` varchar(255) NOT NULL,
  `fnrolest` char(3) DEFAULT NULL,
  `fnexp` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Volcado de datos para la tabla `funciones_roles`
--

INSERT INTO `funciones_roles` (`rolescod`, `fncod`, `fnrolest`, `fnexp`) VALUES
('admin', 'Controllers\\Carretilla\\Carretilla', 'ACT', '2026-12-31 13:51:41'),
('admin', 'Controllers\\Mnt\\ProductList', 'ACT', '2026-07-25 21:48:37'),
('admin', 'Controllers\\Mnt\\ProductList\\DEL', 'ACT', '2026-12-31 21:20:51'),
('admin', 'Controllers\\Mnt\\ProductList\\DSP', 'ACT', '2026-12-31 21:21:55'),
('admin', 'Controllers\\Mnt\\ProductList\\INS', 'ACT', '2026-12-31 21:19:20'),
('admin', 'Controllers\\Mnt\\ProductList\\UPD', 'ACT', '2026-12-31 21:20:30'),
('admin', 'Controllers\\Mnt\\ResultList', 'ACT', '2026-12-31 20:57:44'),
('cliente', 'Controllers\\Mnt\\ProductList', 'ACT', '2026-07-26 20:24:06'),
('cliente', 'Controllers\\Mnt\\ProductList\\DEL', 'INA', '2026-07-26 20:24:32'),
('cliente', 'Controllers\\Mnt\\ProductList\\DSP', 'ACT', '2026-07-26 20:24:48'),
('cliente', 'Controllers\\Mnt\\ProductList\\INS', 'ACT', '2026-07-26 20:25:15'),
('cliente', 'Controllers\\Mnt\\ProductList\\UPD', 'ACT', '2026-07-26 20:25:28'),
('empleado', 'Controllers\\Mnt\\ProductForm', 'ACT', '2026-12-31 20:49:52'),
('empleado', 'Controllers\\Mnt\\ProductForm\\DEL', 'ACT', '2026-12-31 20:50:18'),
('empleado', 'Controllers\\Mnt\\ProductForm\\DSP', 'ACT', '2026-12-31 20:50:35'),
('empleado', 'Controllers\\Mnt\\ProductForm\\INS', 'ACT', '2026-12-31 20:51:08'),
('empleado', 'Controllers\\Mnt\\ProductForm\\UPD', 'ACT', '2026-12-31 20:51:23'),
('empleado', 'Controllers\\Mnt\\ProductList', 'ACT', '2026-07-26 20:30:29'),
('empleado', 'Controllers\\Mnt\\ProductList\\DEL', 'ACT', '2026-07-26 20:30:46'),
('empleado', 'Controllers\\Mnt\\ProductList\\DSP', 'ACT', '2026-07-26 20:31:01'),
('empleado', 'Controllers\\Mnt\\ProductList\\INS', 'ACT', '2026-07-26 20:31:18'),
('empleado', 'Controllers\\Mnt\\ProductList\\UPD', 'INA', '2026-07-26 20:31:39'),
('supervisor', 'Controllers\\Mnt\\ProductList\\DSP', 'ACT', '2026-12-31 21:24:34');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `products`
--

CREATE TABLE `products` (
  `productId` int(11) NOT NULL,
  `productName` varchar(255) NOT NULL,
  `productDescription` text NOT NULL,
  `productPrice` decimal(10,2) NOT NULL,
  `productImgUrl` varchar(255) NOT NULL,
  `productStock` int(11) NOT NULL DEFAULT 0,
  `productStatus` char(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `products`
--

INSERT INTO `products` (`productId`, `productName`, `productDescription`, `productPrice`, `productImgUrl`, `productStock`, `productStatus`) VALUES
(7, 'Mantequilla', 'Crema', 36.00, 'https://importadoramaizo.com/wp-content/uploads/2023/12/93-mantequilla-crema-la-surena-768px.jpg', 230, 'DISPO'),
(8, 'Queso', 'Friolero', 24.00, 'https://tse1.mm.bing.net/th/id/OIP.0M6L0yNWnb2ilOpQ3gkiawHaHa?r=0&rs=1&pid=ImgDetMain&o=7&rm=3', 0, 'AGO'),
(9, 'Queso', 'Semiseco', 45.00, 'https://tse3.mm.bing.net/th/id/OIP.Rg9LUmuQgSKqQSmbf5C7uQHaHa?r=0&rs=1&pid=ImgDetMain&o=7&rm=3', 200, 'DISPO'),
(10, 'Pan', 'Bolillo', 24.00, 'https://th.bing.com/th/id/OIP.hK3QKV-X_IHzCWDZ4uylLwHaHa?r=0&o=7rm=3&rs=1&pid=ImgDetMain&o=7&rm=3', 256, 'DISPO');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `roles`
--

CREATE TABLE `roles` (
  `rolescod` varchar(128) NOT NULL,
  `rolesdsc` varchar(45) DEFAULT NULL,
  `rolesest` char(3) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Volcado de datos para la tabla `roles`
--

INSERT INTO `roles` (`rolescod`, `rolesdsc`, `rolesest`) VALUES
('admin', 'Administrador', 'ACT'),
('cliente', 'Cliente', 'ACT'),
('empleado', 'Empleado', 'ACT'),
('supervisor', 'Supervisor', 'ACT');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `roles_usuarios`
--

CREATE TABLE `roles_usuarios` (
  `usercod` bigint(10) NOT NULL,
  `rolescod` varchar(128) NOT NULL,
  `roleuserest` char(3) DEFAULT NULL,
  `roleuserfch` datetime DEFAULT NULL,
  `roleuserexp` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Volcado de datos para la tabla `roles_usuarios`
--

INSERT INTO `roles_usuarios` (`usercod`, `rolescod`, `roleuserest`, `roleuserfch`, `roleuserexp`) VALUES
(1, 'admin', 'ACT', '2026-07-25 20:55:44', '2026-12-31 20:55:44'),
(2, 'supervisor', 'ACT', '2026-07-31 21:34:32', '2026-12-31 21:34:32'),
(3, 'cliente', 'ACT', '2026-07-26 20:23:10', '2026-12-31 20:23:10'),
(4, 'empleado', 'ACT', '2026-07-26 20:29:04', '2026-12-31 20:29:04');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuario`
--

CREATE TABLE `usuario` (
  `usercod` bigint(10) NOT NULL,
  `useremail` varchar(80) DEFAULT NULL,
  `username` varchar(80) DEFAULT NULL,
  `userpswd` varchar(128) DEFAULT NULL,
  `userfching` datetime DEFAULT NULL,
  `userpswdest` char(3) DEFAULT NULL,
  `userpswdexp` datetime DEFAULT NULL,
  `userest` char(3) DEFAULT NULL,
  `useractcod` varchar(128) DEFAULT NULL,
  `userpswdchg` varchar(128) DEFAULT NULL,
  `usertipo` char(3) DEFAULT NULL COMMENT 'Tipo de Usuario, admin, empleado,cliente, supervisor'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Volcado de datos para la tabla `usuario`
--

INSERT INTO `usuario` (`usercod`, `useremail`, `username`, `userpswd`, `userfching`, `userpswdest`, `userpswdexp`, `userest`, `useractcod`, `userpswdchg`, `usertipo`) VALUES
(1, 'kleonelaarias@gmail.com', 'Administrador', '$2y$10$Z5Sz1Ks1QWXA9npRSqpJuePe9muomfV7hZ0AXKn3a1MgdgIT5ddRS', '2026-07-25 20:52:27', 'ACT', '2026-10-23 00:00:00', 'ACT', 'e8fccbe441e88f0fc7d9b2571291f8014e0e3aab8ea70486ff96dac46e0f9f07', '2026-07-25 20:52:27', 'PBL'),
(2, 'ariasleonela360@gmail.com', 'Supervisor', '$2y$10$A6ye8jboGGP7QEz6Tkjs6e8rhFsOVRacSwze4K3om/9NlkBdaSuJu', '2026-07-25 21:33:51', 'ACT', '2026-10-23 00:00:00', 'ACT', 'fc3d1fbbf61e21e2258f9f3fe32711c514c420d1bcc964277fbe51467db4471d', '2026-07-25 21:33:51', 'PBL'),
(3, 'dayannaespinal14@gmail.com', 'Cliente', '$2y$10$Hc9gXRX1RxTCeDPl0tDSaOfM0Auq20WmUumcigSDEkgYbkOmYReZW', '2026-07-26 20:22:30', 'ACT', '2026-10-24 00:00:00', 'ACT', '855e0eaebfd931bf8d3a5f0eab3df60c94f6d3a8f8772744ee28f8fe88c38077', '2026-07-26 20:22:30', 'PBL'),
(4, 'ivetteespinalm@gmail.com', 'Empleado', '$2y$10$2KfCmTncBjdxyL2BjfQI9.QjllziVvAAeipJcwwOlS5X/.GsOqLf2', '2026-07-26 20:27:52', 'ACT', '2026-10-24 00:00:00', 'ACT', '43b09a795afdaa237a0b21bb086dacdcc69f573f977424a3ca1c1258cdc8c810', '2026-07-26 20:27:52', 'PBL');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `bitacora`
--
ALTER TABLE `bitacora`
  ADD PRIMARY KEY (`bitacoracod`);

--
-- Indices de la tabla `carretilla`
--
ALTER TABLE `carretilla`
  ADD PRIMARY KEY (`usercod`,`productId`),
  ADD KEY `productId_idx` (`productId`);

--
-- Indices de la tabla `carretillaanon`
--
ALTER TABLE `carretillaanon`
  ADD PRIMARY KEY (`anoncod`,`productId`),
  ADD KEY `productId_idx` (`productId`);

--
-- Indices de la tabla `funciones`
--
ALTER TABLE `funciones`
  ADD PRIMARY KEY (`fncod`);

--
-- Indices de la tabla `funciones_roles`
--
ALTER TABLE `funciones_roles`
  ADD PRIMARY KEY (`rolescod`,`fncod`),
  ADD KEY `rol_funcion_key_idx` (`fncod`);

--
-- Indices de la tabla `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`productId`);

--
-- Indices de la tabla `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`rolescod`);

--
-- Indices de la tabla `roles_usuarios`
--
ALTER TABLE `roles_usuarios`
  ADD PRIMARY KEY (`usercod`,`rolescod`),
  ADD KEY `rol_usuario_key_idx` (`rolescod`);

--
-- Indices de la tabla `usuario`
--
ALTER TABLE `usuario`
  ADD PRIMARY KEY (`usercod`),
  ADD UNIQUE KEY `useremail_UNIQUE` (`useremail`),
  ADD KEY `usertipo` (`usertipo`,`useremail`,`usercod`,`userest`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `bitacora`
--
ALTER TABLE `bitacora`
  MODIFY `bitacoracod` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT de la tabla `products`
--
ALTER TABLE `products`
  MODIFY `productId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT de la tabla `usuario`
--
ALTER TABLE `usuario`
  MODIFY `usercod` bigint(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `carretilla`
--
ALTER TABLE `carretilla`
  ADD CONSTRAINT `carretilla_prd_key` FOREIGN KEY (`productId`) REFERENCES `products` (`productId`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `carretilla_user_key` FOREIGN KEY (`usercod`) REFERENCES `usuario` (`usercod`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `carretillaanon`
--
ALTER TABLE `carretillaanon`
  ADD CONSTRAINT `carretillaanon_prd_key` FOREIGN KEY (`productId`) REFERENCES `products` (`productId`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `funciones_roles`
--
ALTER TABLE `funciones_roles`
  ADD CONSTRAINT `funcion_rol_key` FOREIGN KEY (`rolescod`) REFERENCES `roles` (`rolescod`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `rol_funcion_key` FOREIGN KEY (`fncod`) REFERENCES `funciones` (`fncod`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `roles_usuarios`
--
ALTER TABLE `roles_usuarios`
  ADD CONSTRAINT `rol_usuario_key` FOREIGN KEY (`rolescod`) REFERENCES `roles` (`rolescod`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `usuario_rol_key` FOREIGN KEY (`usercod`) REFERENCES `usuario` (`usercod`) ON DELETE NO ACTION ON UPDATE NO ACTION;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
