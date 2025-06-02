-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 02-06-2025 a las 08:09:34
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
-- Estructura de tabla para la tabla `cliente`
--

CREATE TABLE `cliente` (
  `id_cliente` int(3) NOT NULL,
  `nombre` varchar(100) DEFAULT NULL,
  `email` varchar(50) DEFAULT NULL,
  `direccion` varchar(100) DEFAULT NULL,
  `num_telefono` int(10) DEFAULT NULL,
  `apellidos` varchar(100) DEFAULT NULL,
  `fecha_registro` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `cliente`
--

INSERT INTO `cliente` (`id_cliente`, `nombre`, `email`, `direccion`, `num_telefono`, `apellidos`, `fecha_registro`) VALUES
(1, 'citlalli', 'citlallialvaradosilva@gmail.com', NULL, 2147483647, 'alvarado', '2025-06-01'),
(3, 'julia', 'alvaradocitlalli4@gmail.com', NULL, 2147483647, 'alvarado', '2025-06-01'),
(4, 'lilo', 'alvaradocitlalli4@gmail.com', NULL, 2147483647, 'lulu', '2025-06-01');

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

--
-- Volcado de datos para la tabla `factura`
--

INSERT INTO `factura` (`id_factura`, `id_cliente`, `id_reserva`, `fecha_emision`, `monto_total`) VALUES
(1, 4, 4, '2025-06-01', 15660);

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
(15, 13, 800, 'doble', 'ocupada', 3, '2025-06-01', '2025-06-04'),
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

--
-- Volcado de datos para la tabla `reserva`
--

INSERT INTO `reserva` (`id_reserva`, `id_cliente`, `id_habitacion`, `fecha_inicio`, `fecha_fin`, `estado`) VALUES
(3, 3, 5, '2025-06-27', '2025-07-02', 'confirmada'),
(4, 4, 23, '2025-06-10', '2025-06-01', 'completada');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuario`
--

CREATE TABLE `usuario` (
  `id_usuario` int(3) NOT NULL,
  `nombre` varchar(100) DEFAULT NULL,
  `ap_paterno` varchar(50) DEFAULT NULL,
  `ap_materno` varchar(50) DEFAULT NULL,
  `tipo` int(1) DEFAULT NULL,
  `nombre_usuario` varchar(30) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `num_telefono` int(10) DEFAULT NULL,
  `fecha_registro` date DEFAULT NULL,
  `ultimo_acceso` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Índices para tablas volcadas
--

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
-- AUTO_INCREMENT de la tabla `cliente`
--
ALTER TABLE `cliente`
  MODIFY `id_cliente` int(3) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `factura`
--
ALTER TABLE `factura`
  MODIFY `id_factura` int(3) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

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
  MODIFY `id_usuario` int(3) NOT NULL AUTO_INCREMENT;

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
