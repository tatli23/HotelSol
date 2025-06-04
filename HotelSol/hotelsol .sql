-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 04-06-2025 a las 06:21:54
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
-- Base de datos: `hotelsol`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `administrador`
--

CREATE TABLE `administrador` (
  `id` int(11) NOT NULL,
  `usuario` varchar(50) NOT NULL,
  `contrasena` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `administrador`
--

INSERT INTO `administrador` (`id`, `usuario`, `contrasena`) VALUES
(1, 'admin1', 'admin123');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cliente`
--

CREATE TABLE `cliente` (
  `id_cliente` int(3) NOT NULL,
  `nombre` varchar(100) DEFAULT NULL,
  `email` varchar(50) DEFAULT NULL,
  `num_telefono` int(10) DEFAULT NULL,
  `apellidos` varchar(100) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `fecha_nacimiento` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `cliente`
--

INSERT INTO `cliente` (`id_cliente`, `nombre`, `email`, `num_telefono`, `apellidos`, `password`, `fecha_nacimiento`) VALUES
(9, 'cliente', 'cliente2@gmail.com', 2147483647, 'ciente2', '$2y$10$wdSmAjpZGKRIHXgP3.ajfOdMMMr2nrJgqg7GH.7Q8v837uvufLoD.', '2000-11-15'),
(10, 'thai', 'thaimedina@gmail.com', 2147483647, 'medina', '$2y$10$LfaY.3nVgl6SeDGMDjRdXui3aPjj1T0oR88XO.U3hMqU.pvdR4hIO', '2004-03-05');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `factura`
--

CREATE TABLE `factura` (
  `id_factura` int(3) NOT NULL,
  `id_cliente` int(3) DEFAULT NULL,
  `id_reserva` int(3) DEFAULT NULL,
  `fecha_emision` date DEFAULT NULL,
  `monto_total` float DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `habitacion`
--

CREATE TABLE `habitacion` (
  `id_habitacion` int(3) NOT NULL,
  `numero` int(3) DEFAULT NULL,
  `precio_noche` float DEFAULT NULL,
  `tipo` varchar(30) DEFAULT NULL,
  `estado` varchar(30) DEFAULT NULL,
  `id_reserva` int(3) DEFAULT NULL,
  `fecha_inicio` date DEFAULT NULL,
  `fecha_fin` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `habitacion`
--

INSERT INTO `habitacion` (`id_habitacion`, `numero`, `precio_noche`, `tipo`, `estado`, `id_reserva`, `fecha_inicio`, `fecha_fin`) VALUES
(3, 1, 500, 'sencilla', 'Libre', NULL, NULL, NULL),
(4, 2, 500, 'sencilla', 'Libre', NULL, NULL, NULL),
(5, 3, 500, 'sencilla', 'Libre', NULL, NULL, NULL),
(6, 4, 500, 'sencilla', 'Libre', NULL, NULL, NULL),
(7, 5, 500, 'sencilla', 'Libre', NULL, NULL, NULL),
(8, 6, 500, 'sencilla', 'Libre', NULL, NULL, NULL),
(9, 7, 500, 'sencilla', 'Libre', NULL, NULL, NULL),
(10, 8, 500, 'sencilla', 'Libre', NULL, NULL, NULL),
(11, 9, 500, 'sencilla', 'Libre', NULL, NULL, NULL),
(12, 10, 500, 'sencilla', 'Libre', NULL, NULL, NULL),
(13, 11, 800, 'doble', 'Libre', NULL, NULL, NULL),
(14, 12, 800, 'doble', 'Libre', NULL, NULL, NULL),
(15, 13, 800, 'doble', 'Libre', NULL, NULL, NULL),
(16, 14, 800, 'doble', 'Libre', NULL, NULL, NULL),
(17, 15, 800, 'doble', 'Libre', NULL, NULL, NULL),
(18, 16, 800, 'doble', 'Libre', NULL, NULL, NULL),
(19, 17, 800, 'doble', 'Libre', NULL, NULL, NULL),
(20, 18, 800, 'doble', 'Libre', NULL, NULL, NULL),
(21, 19, 800, 'doble', 'Libre', NULL, NULL, NULL),
(22, 20, 800, 'doble', 'Libre', NULL, NULL, NULL),
(23, 21, 1500, 'suite', 'Libre', NULL, NULL, NULL),
(24, 22, 1500, 'suite', 'Libre', NULL, NULL, NULL),
(25, 23, 1500, 'suite', 'Libre', NULL, NULL, NULL),
(26, 24, 1500, 'suite', 'Libre', NULL, NULL, NULL),
(27, 25, 1500, 'suite', 'Libre', NULL, NULL, NULL),
(28, 26, 1500, 'suite', 'Libre', NULL, NULL, NULL),
(29, 27, 1500, 'suite', 'Libre', NULL, NULL, NULL),
(30, 28, 1500, 'suite', 'Libre', NULL, NULL, NULL),
(31, 29, 1500, 'suite', 'Libre', NULL, NULL, NULL),
(32, 30, 1500, 'suite', 'Libre', NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `reserva`
--

CREATE TABLE `reserva` (
  `id_reserva` int(3) NOT NULL,
  `id_cliente` int(3) DEFAULT NULL,
  `id_habitacion` int(3) DEFAULT NULL,
  `fecha_inicio` date DEFAULT NULL,
  `fecha_fin` date DEFAULT NULL,
  `estado` varchar(15) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuario`
--

CREATE TABLE `usuario` (
  `id_usuario` int(3) NOT NULL,
  `tipo` varchar(50) NOT NULL,
  `nombre_usuario` varchar(30) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `usuario`
--

INSERT INTO `usuario` (`id_usuario`, `tipo`, `nombre_usuario`, `password`) VALUES
(3, 'recepcionista', 'recep1', '$2y$10$pI7/n.Azsx2Awyb20zYRB.9wNZH1tSJ5q3YTEBib8PEj5XQqMncNm');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `administrador`
--
ALTER TABLE `administrador`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `cliente`
--
ALTER TABLE `cliente`
  ADD PRIMARY KEY (`id_cliente`);

--
-- Indices de la tabla `factura`
--
ALTER TABLE `factura`
  ADD PRIMARY KEY (`id_factura`),
  ADD KEY `id_cliente` (`id_cliente`),
  ADD KEY `id_reserva` (`id_reserva`);

--
-- Indices de la tabla `habitacion`
--
ALTER TABLE `habitacion`
  ADD PRIMARY KEY (`id_habitacion`);

--
-- Indices de la tabla `reserva`
--
ALTER TABLE `reserva`
  ADD PRIMARY KEY (`id_reserva`),
  ADD KEY `id_cliente` (`id_cliente`),
  ADD KEY `id_habitacion` (`id_habitacion`);

--
-- Indices de la tabla `usuario`
--
ALTER TABLE `usuario`
  ADD PRIMARY KEY (`id_usuario`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `administrador`
--
ALTER TABLE `administrador`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `cliente`
--
ALTER TABLE `cliente`
  MODIFY `id_cliente` int(3) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT de la tabla `factura`
--
ALTER TABLE `factura`
  MODIFY `id_factura` int(3) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `habitacion`
--
ALTER TABLE `habitacion`
  MODIFY `id_habitacion` int(3) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;

--
-- AUTO_INCREMENT de la tabla `reserva`
--
ALTER TABLE `reserva`
  MODIFY `id_reserva` int(3) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `usuario`
--
ALTER TABLE `usuario`
  MODIFY `id_usuario` int(3) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `factura`
--
ALTER TABLE `factura`
  ADD CONSTRAINT `factura_ibfk_1` FOREIGN KEY (`id_cliente`) REFERENCES `cliente` (`id_cliente`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `factura_ibfk_2` FOREIGN KEY (`id_reserva`) REFERENCES `reserva` (`id_reserva`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `reserva`
--
ALTER TABLE `reserva`
  ADD CONSTRAINT `reserva_ibfk_1` FOREIGN KEY (`id_cliente`) REFERENCES `cliente` (`id_cliente`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `reserva_ibfk_2` FOREIGN KEY (`id_habitacion`) REFERENCES `habitacion` (`id_habitacion`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
