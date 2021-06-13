-- phpMyAdmin SQL Dump
-- version 5.1.0
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 13-06-2021 a las 23:04:37
-- Versión del servidor: 10.4.19-MariaDB
-- Versión de PHP: 8.0.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `tp`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `changelogs`
--

CREATE TABLE `changelogs` (
  `id` int(18) NOT NULL,
  `tabla_afectada` varchar(50) COLLATE latin1_spanish_ci NOT NULL,
  `id_afectado` int(18) NOT NULL,
  `id_empleado` int(18) NOT NULL,
  `accion` varchar(50) COLLATE latin1_spanish_ci NOT NULL,
  `descripcion` varchar(150) COLLATE latin1_spanish_ci NOT NULL,
  `fecha_hora` datetime NOT NULL,
  `fecha_de_baja` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci;

--
-- Volcado de datos para la tabla `changelogs`
--

INSERT INTO `changelogs` (`id`, `tabla_afectada`, `id_afectado`, `id_empleado`, `accion`, `descripcion`, `fecha_hora`, `fecha_de_baja`) VALUES
(1, 'pedidos', 2, 3, 'Modificar', 'pagado', '2021-06-11 17:09:00', NULL),
(2, 'pedidos', 3, 3, 'Modificar', 'pagado', '2021-06-11 17:09:00', NULL),
(3, 'pedidos', 3, 3, 'Modificar', 'pagado', '2021-06-11 17:30:19', NULL),
(4, 'pedidos', 0, 3, 'Obtener datos', 'Datos de todos los pedidos', '2021-06-11 17:54:40', NULL),
(5, 'pedidos', 3, 3, 'Eliminar', 'Se realizo el softdelete de la fila', '2021-06-11 18:17:20', NULL),
(6, 'productos', 5, 3, 'Cargar', 'Stock: 50', '2021-06-11 19:34:34', NULL),
(7, 'productos', 0, 3, 'Obtener datos', 'Datos de todos los producto', '2021-06-11 19:35:18', NULL),
(8, 'empleados', 0, 3, 'Obtener datos', 'Datos de todos los empleados', '2021-06-11 19:53:58', NULL),
(9, 'pedidos', 0, 3, 'Carga Archivo', 'Se cargo en la DB los datos de un archivo CSV', '2021-06-13 03:26:55', NULL),
(10, 'empleados', 7, 3, 'Cargar', 'Antonio mozo', '2021-06-13 03:37:59', NULL),
(11, 'empleados', 8, 3, 'Cargar', 'Carlos socio', '2021-06-13 03:39:58', NULL),
(12, 'empleados', 9, 3, 'Cargar', 'Maria socio', '2021-06-13 03:42:22', NULL),
(13, 'empleados', 10, 3, 'Cargar', 'Maria socio', '2021-06-13 03:42:45', NULL),
(14, 'empleados', 11, 3, 'Cargar', 'Maria socio', '2021-06-13 03:43:12', NULL),
(15, 'empleados', 12, 3, 'Cargar', 'Maria socio', '2021-06-13 03:46:15', NULL),
(16, 'empleados', 0, 3, 'Guardar Archivo', 'Se descargaron los datos de la DB en formato csv', '2021-06-13 03:48:15', NULL),
(17, 'pedidos', 6, 3, 'Cargar', 'en preparacion', '2021-06-13 17:18:20', NULL),
(18, 'productos', 2, 3, 'Reduccion de stock', 'Se redujo stock en 3', '2021-06-13 17:18:20', NULL),
(19, 'pedidos', 7, 3, 'Cargar', 'en preparacion', '2021-06-13 17:19:12', NULL),
(20, 'productos', 2, 3, 'Reduccion de stock', 'Se redujo stock en 3', '2021-06-13 17:19:12', NULL),
(21, 'pedidos', 8, 3, 'Cargar', 'en preparacion', '2021-06-13 17:20:28', NULL),
(22, 'productos', 2, 3, 'Reduccion de stock', 'Se redujo stock en 3', '2021-06-13 17:20:28', NULL),
(23, 'pedidos', 9, 3, 'Cargar', 'en preparacion', '2021-06-13 17:21:53', NULL),
(24, 'productos', 2, 3, 'Reduccion de stock', 'Se redujo stock en 3', '2021-06-13 17:21:53', NULL),
(25, 'pedidos', 10, 3, 'Cargar', 'en preparacion', '2021-06-13 17:22:42', NULL),
(26, 'productos', 2, 3, 'Reduccion de stock', 'Se redujo stock en 3', '2021-06-13 17:22:42', NULL),
(27, 'pedidos', 11, 3, 'Cargar', 'en preparacion', '2021-06-13 17:23:10', NULL),
(28, 'productos', 2, 3, 'Reduccion de stock', 'Se redujo stock en 3', '2021-06-13 17:23:10', NULL),
(29, 'pedidos', 12, 3, 'Cargar', 'en preparacion', '2021-06-13 17:25:08', NULL),
(30, 'productos', 2, 3, 'Reduccion de stock', 'Se redujo stock en 3', '2021-06-13 17:25:08', NULL),
(31, 'pedidos', 13, 3, 'Cargar', 'en preparacion', '2021-06-13 17:26:23', NULL),
(32, 'productos', 2, 3, 'Reduccion de stock', 'Se redujo stock en 3', '2021-06-13 17:26:23', NULL),
(33, 'pedidos', 14, 3, 'Cargar', 'en preparacion', '2021-06-13 17:26:51', NULL),
(34, 'productos', 2, 3, 'Reduccion de stock', 'Se redujo stock en 3', '2021-06-13 17:26:51', NULL),
(35, 'pedidos', 15, 3, 'Cargar', 'en preparacion', '2021-06-13 17:27:46', NULL),
(36, 'productos', 2, 3, 'Reduccion de stock', 'Se redujo stock en 3', '2021-06-13 17:27:46', NULL),
(37, 'pedidos', 16, 3, 'Cargar', 'en preparacion', '2021-06-13 17:28:14', NULL),
(38, 'productos', 2, 3, 'Reduccion de stock', 'Se redujo stock en 3', '2021-06-13 17:28:14', NULL),
(39, 'pedidos', 17, 3, 'Cargar', 'en preparacion', '2021-06-13 17:28:38', NULL),
(40, 'productos', 1, 3, 'Reduccion de stock', 'Se redujo stock en 3', '2021-06-13 17:28:38', NULL),
(41, 'pedidos', 18, 3, 'Cargar', 'en preparacion', '2021-06-13 17:29:12', NULL),
(42, 'productos', 1, 3, 'Reduccion de stock', 'Se redujo stock en 3', '2021-06-13 17:29:12', NULL),
(43, 'pedidos', 19, 3, 'Cargar', 'en preparacion', '2021-06-13 17:29:33', NULL),
(44, 'productos', 1, 3, 'Reduccion de stock', 'Se redujo stock en 3', '2021-06-13 17:29:33', NULL),
(45, 'pedidos', 0, 3, 'Guardar Archivo', 'Se descargaron los datos de la DB en formato csv', '2021-06-13 17:30:37', NULL),
(46, 'pedidos', 0, 3, 'Carga Archivo', 'Se cargo en la DB los datos de un archivo CSV', '2021-06-13 17:31:47', NULL),
(47, 'pedidos', 5, 3, 'Cargar', 'en preparacion | 1623618239', '2021-06-13 17:48:59', NULL),
(48, 'productos', 1, 3, 'Reduccion de stock', 'Se redujo stock en 3', '2021-06-13 17:48:59', NULL),
(49, 'pedidos', 5, 3, 'Modificar', 'listo para servir(Entregado a tiempo)', '2021-06-13 17:51:17', NULL),
(50, 'pedidos', 5, 3, 'Modificar', 'servido(Servido tarde)', '2021-06-13 17:53:21', NULL),
(51, 'pedidos', 5, 3, 'Modificar', 'pagado()', '2021-06-13 18:01:50', NULL),
(52, 'pedidos', 5, 3, 'Modificar', 'pagado(pagado)', '2021-06-13 18:03:37', NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `clientes`
--

CREATE TABLE `clientes` (
  `id` int(11) NOT NULL,
  `nombre` varchar(50) COLLATE latin1_spanish_ci NOT NULL,
  `apellido` varchar(50) COLLATE latin1_spanish_ci NOT NULL,
  `mail` varchar(50) COLLATE latin1_spanish_ci NOT NULL,
  `dni` int(8) NOT NULL,
  `fecha_de_baja` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci;

--
-- Volcado de datos para la tabla `clientes`
--

INSERT INTO `clientes` (`id`, `nombre`, `apellido`, `mail`, `dni`, `fecha_de_baja`) VALUES
(1, 'Lucas', 'Valdiviezo', 'lucas@lucas.com', 40091498, NULL),
(2, 'Mauro', 'Ovando', 'mauro@mauro.com', 30030501, '2021-06-05');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `empleados`
--

CREATE TABLE `empleados` (
  `id` int(18) NOT NULL,
  `nombre` varchar(50) COLLATE latin1_spanish_ci NOT NULL,
  `apellido` varchar(50) COLLATE latin1_spanish_ci NOT NULL,
  `mail` varchar(50) COLLATE latin1_spanish_ci NOT NULL,
  `clave` varchar(50) COLLATE latin1_spanish_ci NOT NULL,
  `puesto` varchar(50) COLLATE latin1_spanish_ci NOT NULL,
  `estado` varchar(50) COLLATE latin1_spanish_ci NOT NULL,
  `fecha_de_baja` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci;

--
-- Volcado de datos para la tabla `empleados`
--

INSERT INTO `empleados` (`id`, `nombre`, `apellido`, `mail`, `clave`, `puesto`, `estado`, `fecha_de_baja`) VALUES
(1, 'Mauro', 'Ovando', 'mauro@mauro.com', 'contraseña123', 'bartender', 'activo', NULL),
(2, 'Martin', 'Bottani', 'martin@martin.com', 'chau534', 'cocina', 'activo', NULL),
(3, 'Nicolas', 'Alvarez', 'nico@nico.com', '123asd', 'socio', 'activo', NULL),
(4, 'Mauro', 'Ovando', 'mauro@mauro.com', 'contraseña123', 'bartender', 'activo', NULL),
(5, 'Martin', 'Bottani', 'martin@martin.com', 'chau534', 'cocina', 'activo', NULL),
(6, 'Nicolas', 'Alvarez', 'nico@nico.com', '123asd', 'socio', 'activo', NULL),
(7, 'Antonio', 'Garibaldi', 'antonio@antonio.com', 'jojoji', 'mozo', 'activo', NULL),
(8, 'Carlos', 'Gonzales', 'carlos@carlos.com', 'montene51s', 'socio', 'activo', NULL),
(9, 'Maria', 'Dolores', 'maria@maria.com', 'tonto125', 'socio', 'activo', NULL),
(10, 'Jonatan', 'Antores', 'jona@jona.com', 'trentonono1', 'cocina', 'activo', NULL),
(11, 'Pablo', 'Allo', 'pablo@pablo.com', 'pablotosaz', 'candybar', 'actvio', NULL),
(12, 'Adriana', 'Allo', 'adri@adri.com', 'jajazjojo', 'mozo', 'activo', NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `mesas`
--

CREATE TABLE `mesas` (
  `id` int(10) NOT NULL,
  `numero` varchar(5) COLLATE latin1_spanish_ci NOT NULL,
  `estado` varchar(50) COLLATE latin1_spanish_ci NOT NULL,
  `fecha_de_baja` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci;

--
-- Volcado de datos para la tabla `mesas`
--

INSERT INTO `mesas` (`id`, `numero`, `estado`, `fecha_de_baja`) VALUES
(1, 'wst3b', 'cerrada', NULL),
(2, '4qhij', 'cerrada', NULL),
(3, '620ed', 'cerrada', '2021-06-05'),
(4, '4kib9', 'cerrada', NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pedidos`
--

CREATE TABLE `pedidos` (
  `id` int(18) NOT NULL,
  `codigo` varchar(5) COLLATE latin1_spanish_ci NOT NULL,
  `id_cliente` int(18) NOT NULL,
  `id_mesa` int(18) NOT NULL,
  `datos_productos` varchar(100) COLLATE latin1_spanish_ci NOT NULL,
  `id_empleado` int(18) NOT NULL,
  `estado` varchar(50) COLLATE latin1_spanish_ci NOT NULL,
  `total` varchar(50) COLLATE latin1_spanish_ci NOT NULL,
  `puesto` varchar(100) COLLATE latin1_spanish_ci NOT NULL,
  `fecha_hora_creacion` datetime NOT NULL,
  `ultima_modificacion` time NOT NULL,
  `tiempo_estimado` time NOT NULL,
  `fecha_de_baja` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci;

--
-- Volcado de datos para la tabla `pedidos`
--

INSERT INTO `pedidos` (`id`, `codigo`, `id_cliente`, `id_mesa`, `datos_productos`, `id_empleado`, `estado`, `total`, `puesto`, `fecha_hora_creacion`, `ultima_modificacion`, `tiempo_estimado`, `fecha_de_baja`) VALUES
(1, 'iuo71', 1, 2, 'Id: 2 - Cantidad: 6 / ', 1, 'pagado', '$66', '-mesa-', '2021-06-13 02:50:10', '10:00:57', '10:15:57', NULL),
(2, '1hrgb', 1, 2, 'Id: 2 - Cantidad: 3 / ', 3, 'pagado', '$33', '-mesa-', '2021-06-11 16:59:42', '17:08:16', '17:20:16', NULL),
(3, 'iuo71', 1, 2, 'Id: 2 - Cantidad: 6 / ', 1, 'pagado', '$66', '-mesa-', '2021-06-13 02:50:10', '10:00:57', '10:10:57', NULL),
(4, 'iuo71', 1, 2, 'Id: 2 - Cantidad: 6 / ', 1, 'pagado', '$66', '-mesa-', '2021-06-13 02:50:10', '10:00:57', '10:30:57', NULL),
(5, 'h2pxe', 1, 1, 'Id: 1 - Cantidad: 3 / ', 3, 'pagado', '$24', '-mesa-', '2021-06-13 17:48:59', '18:03:37', '17:41:01', NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `productos`
--

CREATE TABLE `productos` (
  `id` int(18) NOT NULL,
  `nombre` varchar(50) COLLATE latin1_spanish_ci NOT NULL,
  `precio` decimal(30,0) NOT NULL,
  `stock` int(18) NOT NULL,
  `tipo` varchar(50) COLLATE latin1_spanish_ci NOT NULL,
  `fecha_de_baja` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci;

--
-- Volcado de datos para la tabla `productos`
--

INSERT INTO `productos` (`id`, `nombre`, `precio`, `stock`, `tipo`, `fecha_de_baja`) VALUES
(1, 'Papas Fritas', '8', 276, 'comida', NULL),
(2, 'Coca Cola', '11', 494, 'bebida', NULL),
(3, 'Sprite', '6', 200, 'bebida', '2021-06-05'),
(4, 'Hamburguesa', '21', 50, 'comida', NULL),
(5, 'Hamburguesa Vegana', '21', 50, 'comida', NULL);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `changelogs`
--
ALTER TABLE `changelogs`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `clientes`
--
ALTER TABLE `clientes`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `empleados`
--
ALTER TABLE `empleados`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `mesas`
--
ALTER TABLE `mesas`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `pedidos`
--
ALTER TABLE `pedidos`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `productos`
--
ALTER TABLE `productos`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `changelogs`
--
ALTER TABLE `changelogs`
  MODIFY `id` int(18) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=53;

--
-- AUTO_INCREMENT de la tabla `clientes`
--
ALTER TABLE `clientes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `empleados`
--
ALTER TABLE `empleados`
  MODIFY `id` int(18) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT de la tabla `mesas`
--
ALTER TABLE `mesas`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `pedidos`
--
ALTER TABLE `pedidos`
  MODIFY `id` int(18) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `productos`
--
ALTER TABLE `productos`
  MODIFY `id` int(18) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
