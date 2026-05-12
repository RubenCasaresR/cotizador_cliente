-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 11-05-2026 a las 19:44:56
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
-- Base de datos: `cotizador_db`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cotizaciones`
--

CREATE TABLE `cotizaciones` (
  `id` int(11) NOT NULL,
  `folio` varchar(20) NOT NULL,
  `tipo` enum('compra','venta') NOT NULL,
  `cliente_nombre` varchar(150) DEFAULT NULL,
  `cliente_correo` varchar(150) DEFAULT NULL,
  `fecha_hora` datetime DEFAULT current_timestamp(),
  `usd` decimal(15,2) NOT NULL,
  `tc` decimal(15,4) NOT NULL,
  `comision_pct` decimal(5,2) NOT NULL,
  `comision_monto` decimal(15,2) NOT NULL,
  `total` decimal(15,2) NOT NULL,
  `activo` tinyint(1) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `cotizaciones`
--

INSERT INTO `cotizaciones` (`id`, `folio`, `tipo`, `cliente_nombre`, `cliente_correo`, `fecha_hora`, `usd`, `tc`, `comision_pct`, `comision_monto`, `total`, `activo`) VALUES
(1, 'COT-77479', 'venta', NULL, NULL, '2026-04-08 12:05:03', 10000.00, 17.4700, 2.50, 4479.49, 179179.49, 0),
(2, 'COT-59403', 'venta', NULL, NULL, '2026-04-08 12:09:35', 8300.00, 17.5800, 1.25, 1847.01, 147761.01, 0),
(3, 'COT-58443', 'venta', NULL, NULL, '2026-04-08 14:12:54', 10000.00, 17.5500, 2.00, 3581.63, 179081.63, 0),
(4, 'COT-50243', 'venta', NULL, NULL, '2026-04-09 12:28:37', 10000.00, 17.3700, 2.00, 3544.90, 177244.90, 0),
(5, 'COT-75643', 'venta', NULL, NULL, '2026-04-09 12:29:10', 10000.00, 17.5000, 2.00, 3571.43, 178571.43, 0),
(6, 'COT-66783', 'venta', NULL, NULL, '2026-04-09 16:21:34', 53174.77, 17.3600, 1.00, 9324.38, 932438.39, 0),
(7, 'COT-91204', 'venta', NULL, NULL, '2026-04-10 11:24:44', 25878.97, 17.4400, 0.00, 0.00, 451329.24, 0),
(8, 'COT-17705', 'venta', NULL, NULL, '2026-04-10 11:55:25', 8800.00, 17.4300, 1.75, 2732.03, 156116.03, 0),
(9, 'COT-10400', 'compra', NULL, NULL, '2026-04-13 11:58:10', 47800.00, 17.3000, 1.50, -12404.10, 814535.90, 0),
(10, 'COT-71203', 'compra', NULL, NULL, '2026-04-13 11:58:23', 47800.00, 17.1400, 1.50, -12289.38, 807002.62, 0),
(11, 'COT-56830', 'compra', NULL, NULL, '2026-04-14 10:10:42', 49700.00, 17.1100, 1.50, -12755.51, 837611.50, 1),
(12, 'COT-32557', 'venta', NULL, NULL, '2026-04-14 10:40:14', 4500.00, 17.3900, 3.00, 2420.26, 80675.26, 1),
(13, 'COT-49121', 'compra', NULL, NULL, '2026-04-14 10:42:38', 10680.61, 17.1000, 2.00, -3652.77, 178985.66, 1),
(14, 'COT-13626', 'compra', NULL, NULL, '2026-04-15 12:14:32', 48655.00, 17.1000, 1.50, -12480.01, 819520.49, 1),
(15, 'COT-20204', 'venta', NULL, NULL, '2026-04-15 12:38:30', 8800.00, 17.3800, 1.75, 2724.19, 155668.19, 1),
(16, 'COT-95419', 'venta', NULL, NULL, '2026-04-16 08:42:28', 9750.00, 17.4100, 1.25, 2148.70, 171896.20, 1),
(17, 'COT-80888', 'venta', NULL, NULL, '2026-04-16 09:49:46', 6000.00, 17.3900, 1.75, 1858.47, 106198.47, 1),
(18, 'COT-47924', 'compra', NULL, NULL, '2026-04-20 10:19:15', 81585.08, 17.1600, 0.00, 0.00, 1399999.97, 1),
(19, 'COT-3182', 'venta', NULL, NULL, '2026-04-20 10:29:28', 102499.00, 17.4500, 3.00, 55317.76, 1843925.31, 1),
(20, 'COT-2761', 'venta', NULL, NULL, '2026-04-20 10:30:45', 124499.00, 17.4500, 3.00, 67190.96, 2239698.51, 1),
(21, 'COT-979', 'compra', NULL, NULL, '2026-04-22 08:58:37', 55465.31, 17.1800, 2.00, -19057.88, 933836.15, 1),
(22, 'COT-73676', 'compra', NULL, NULL, '2026-04-22 13:19:40', 42000.00, 17.1400, 1.50, -10798.20, 709081.80, 1),
(23, 'COT-79705', 'venta', NULL, NULL, '2026-04-22 13:25:11', 1500.00, 17.4700, 2.00, 534.80, 26739.80, 1),
(24, 'COT-45365', 'venta', NULL, NULL, '2026-04-23 08:50:36', 103.50, 17.4900, 3.00, 55.99, 1866.20, 1),
(25, 'COT-12662', 'venta', NULL, NULL, '2026-04-23 08:50:43', 10350.00, 17.4900, 3.00, 5598.60, 186620.10, 1),
(26, 'COT-93130', 'venta', NULL, NULL, '2026-04-23 11:14:50', 124499.00, 17.5300, 3.00, 67498.99, 2249966.46, 1),
(27, 'COT-82648', 'compra', NULL, NULL, '2026-04-24 13:32:09', 102499.00, 17.2500, 1.00, -17681.08, 1750426.67, 1),
(28, 'COT-88656', 'compra', NULL, NULL, '2026-04-27 09:52:21', 54000.00, 17.2300, 2.00, -18608.40, 911811.60, 1),
(29, 'COT-38068', 'compra', NULL, NULL, '2026-04-27 09:52:59', 53965.33, 17.2300, 2.00, -18596.45, 911226.18, 1),
(30, 'COT-88002', 'compra', NULL, NULL, '2026-04-29 08:19:34', 109990.00, 17.0800, 5.00, -93931.46, 1784697.74, 1),
(31, 'COT-30398', 'compra', NULL, NULL, '2026-04-29 08:45:30', 109990.00, 17.1500, 5.00, -94316.42, 1792012.07, 1),
(32, 'COT-1588', 'venta', NULL, NULL, '2026-04-29 12:24:28', 23000.00, 17.6600, 1.25, 5141.52, 411321.52, 1),
(33, 'COT-76915', 'venta', NULL, NULL, '2026-04-30 11:06:17', 1000.00, 17.6200, 1.75, 313.84, 17933.84, 1),
(34, 'COT-50948', 'compra', NULL, NULL, '2026-05-04 11:52:27', 70965.32, 17.5100, 2.00, -24852.06, 1217750.70, 1),
(35, 'COT-6656', 'compra', NULL, NULL, '2026-05-04 11:52:33', 70965.32, 17.3700, 2.00, -24653.35, 1208014.26, 1),
(36, 'COT-47825', 'venta', NULL, NULL, '2026-05-04 12:44:33', 150000.00, 17.6400, 1.50, 40294.42, 2686294.42, 1),
(37, 'COT-1566', 'venta', NULL, NULL, '2026-05-04 12:44:40', 150000.00, 17.7000, 1.50, 40431.47, 2695431.47, 1),
(38, 'COT-89255', 'venta', NULL, NULL, '2026-05-06 08:16:00', 9500.00, 17.3800, 1.75, 2940.89, 168050.89, 1),
(39, 'COT-92981', 'venta', NULL, NULL, '2026-05-07 08:13:06', 7500.00, 17.3400, 1.75, 2316.41, 132366.41, 1),
(40, 'COT-1886', 'compra', NULL, NULL, '2026-05-07 12:00:17', 10000.00, 17.1000, 1.50, -2565.00, 168435.00, 1),
(41, 'COT-74820', 'compra', NULL, NULL, '2026-05-07 16:01:32', 4000.00, 17.1500, 1.50, -1029.00, 67571.00, 1),
(42, 'COT-25681', 'compra', NULL, NULL, '2026-05-08 10:07:51', 4000.00, 17.0700, 1.50, -1024.20, 67255.80, 1),
(43, 'COT-46959', 'compra', NULL, NULL, '2026-05-08 10:08:05', 4000.00, 17.2200, 1.50, -1033.20, 67846.80, 1),
(44, 'COT-97896', 'compra', NULL, NULL, '2026-05-08 10:09:06', 4000.00, 17.0700, 1.50, -1024.20, 67255.80, 1);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `cotizaciones`
--
ALTER TABLE `cotizaciones`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `cotizaciones`
--
ALTER TABLE `cotizaciones`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=45;

ALTER TABLE `cotizaciones`
  ADD COLUMN `cliente_nombre` varchar(150) DEFAULT NULL AFTER `tipo`,
  ADD COLUMN `cliente_correo` varchar(150) DEFAULT NULL AFTER `cliente_nombre`;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
