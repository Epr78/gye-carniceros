-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 18-04-2026 a las 10:44:53
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
-- Base de datos: `gye_carniceros`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `administradores`
--

CREATE TABLE `administradores` (
  `id` int(11) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `email` varchar(120) NOT NULL,
  `password` varchar(255) NOT NULL,
  `activo` tinyint(1) NOT NULL DEFAULT 1,
  `fecha_creacion` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `administradores`
--

INSERT INTO `administradores` (`id`, `nombre`, `email`, `password`, `activo`, `fecha_creacion`) VALUES
(1, 'Administrador', 'admin@gyecarniceros.local', '$2y$10$mv.QRlD.4r2gezcLo.Wt2.d0hwsk8n1Eqwjten/UV/Ipf4qPT3/YW', 1, '2026-03-21 19:40:56');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `contacto_mensajes`
--

CREATE TABLE `contacto_mensajes` (
  `id` int(11) NOT NULL,
  `nombre` varchar(120) NOT NULL,
  `email` varchar(120) NOT NULL,
  `telefono` varchar(30) DEFAULT NULL,
  `asunto` varchar(150) NOT NULL,
  `mensaje` text NOT NULL,
  `contestado` tinyint(1) NOT NULL DEFAULT 0,
  `fecha_creacion` datetime NOT NULL DEFAULT current_timestamp(),
  `alerta` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `contacto_mensajes`
--

INSERT INTO `contacto_mensajes` (`id`, `nombre`, `email`, `telefono`, `asunto`, `mensaje`, `contestado`, `fecha_creacion`, `alerta`) VALUES
(1, 'jose maria', 'jose@gmail.com', '654654789', 'Reclamación', 'No estuve bien tratado el otro día', 0, '2026-03-29 12:56:07', 0),
(2, 'Esther', 'stherpr@gmail.com', '639867225', 'CARNE DURA', 'La carne estaba dura.', 0, '2026-04-16 05:35:28', 0),
(3, 'Cristina', 'cristinagonzalez@yahoo.es', '639867220', 'La carne estaba dura', 'La carne estaba muy dura', 1, '2026-04-16 05:41:17', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `despiece_reglas`
--

CREATE TABLE `despiece_reglas` (
  `id` int(11) NOT NULL,
  `pieza_base_id` int(11) NOT NULL,
  `producto_id` int(11) NOT NULL,
  `cantidad_resultante` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `despiece_reglas`
--

INSERT INTO `despiece_reglas` (`id`, `pieza_base_id`, `producto_id`, `cantidad_resultante`) VALUES
(1, 1, 1, 12.00),
(2, 1, 2, 10.00),
(3, 1, 3, 8.00),
(4, 1, 4, 9.00),
(5, 1, 5, 3.00),
(6, 1, 6, 10.00),
(7, 1, 7, 7.00),
(8, 1, 8, 5.50),
(9, 2, 9, 14.00),
(10, 2, 10, 4.50),
(11, 2, 11, 3.00),
(12, 2, 6, 5.00),
(13, 2, 7, 8.00),
(14, 2, 8, 8.00),
(15, 3, 12, 2.50),
(16, 3, 13, 7.50),
(17, 3, 14, 3.50),
(18, 3, 15, 4.00),
(19, 4, 17, 10.00),
(20, 5, 18, 7.00),
(21, 5, 19, 3.50),
(22, 5, 20, 2.00),
(23, 5, 21, 2.50),
(24, 5, 22, 2.50),
(32, 6, 18, 14.00),
(33, 6, 19, 7.00),
(34, 6, 20, 4.00),
(35, 6, 21, 5.00),
(36, 6, 22, 5.00),
(39, 9, 24, 15.00),
(40, 10, 25, 15.00),
(41, 11, 27, 3.50),
(42, 12, 28, 3.50),
(43, 13, 29, 3.50),
(44, 14, 30, 3.50),
(45, 15, 31, 3.50),
(46, 16, 26, 5.00),
(77, 17, 1, 12.00),
(78, 17, 2, 10.00),
(79, 17, 3, 8.00),
(80, 17, 4, 9.00),
(81, 17, 5, 3.00),
(82, 17, 6, 15.00),
(83, 17, 7, 15.00),
(84, 17, 8, 13.50),
(85, 17, 9, 14.00),
(86, 17, 10, 4.50),
(87, 17, 11, 3.00),
(92, 18, 1, 24.00),
(93, 18, 2, 20.00),
(94, 18, 3, 16.00),
(95, 18, 4, 18.00),
(96, 18, 5, 6.00),
(97, 18, 6, 30.00),
(98, 18, 7, 30.00),
(99, 18, 8, 27.00),
(100, 18, 9, 28.00),
(101, 18, 10, 9.00),
(102, 18, 11, 6.00);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `entradas_compra`
--

CREATE TABLE `entradas_compra` (
  `id` int(11) NOT NULL,
  `pieza_base_id` int(11) NOT NULL,
  `administrador_id` int(11) NOT NULL,
  `cantidad_entrada` decimal(10,2) NOT NULL,
  `coste_total_compra` decimal(10,2) NOT NULL DEFAULT 0.00,
  `observaciones` text DEFAULT NULL,
  `fecha_creacion` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `entradas_compra`
--

INSERT INTO `entradas_compra` (`id`, `pieza_base_id`, `administrador_id`, `cantidad_entrada`, `coste_total_compra`, `observaciones`, `fecha_creacion`) VALUES
(10, 6, 1, 1.00, 0.00, '', '2026-03-28 11:35:12'),
(11, 2, 1, 1.00, 95.00, '', '2026-03-28 13:24:12'),
(12, 3, 1, 2.00, 60.00, '', '2026-03-28 13:24:49'),
(13, 5, 1, 1.00, 90.00, '-Carne scura con mucha grasa hablar con proveedor', '2026-03-28 14:35:58');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `entrada_detalles`
--

CREATE TABLE `entrada_detalles` (
  `id` int(11) NOT NULL,
  `entrada_compra_id` int(11) NOT NULL,
  `producto_id` int(11) NOT NULL,
  `cantidad_generada` decimal(10,2) NOT NULL,
  `coste_unitario` decimal(10,4) NOT NULL DEFAULT 0.0000,
  `coste_total` decimal(10,2) NOT NULL DEFAULT 0.00
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `entrada_detalles`
--

INSERT INTO `entrada_detalles` (`id`, `entrada_compra_id`, `producto_id`, `cantidad_generada`, `coste_unitario`, `coste_total`) VALUES
(32, 10, 19, 7.00, 0.0000, 0.00),
(33, 10, 22, 5.00, 0.0000, 0.00),
(34, 10, 21, 5.00, 0.0000, 0.00),
(35, 10, 20, 4.00, 0.0000, 0.00),
(36, 10, 18, 14.00, 0.0000, 0.00),
(37, 11, 9, 14.00, 2.2353, 31.29),
(38, 11, 11, 3.00, 2.2353, 6.71),
(39, 11, 7, 8.00, 2.2353, 17.88),
(40, 11, 8, 8.00, 2.2353, 17.88),
(41, 11, 10, 4.50, 2.2353, 10.06),
(42, 11, 6, 5.00, 2.2353, 11.18),
(43, 12, 12, 5.00, 1.7143, 8.57),
(44, 12, 15, 8.00, 1.7143, 13.71),
(45, 12, 14, 7.00, 1.7143, 12.00),
(46, 12, 13, 15.00, 1.7143, 25.71),
(47, 13, 19, 3.50, 5.1429, 18.00),
(48, 13, 22, 2.50, 5.1429, 12.86),
(49, 13, 21, 2.50, 5.1429, 12.86),
(50, 13, 20, 2.00, 5.1429, 10.29),
(51, 13, 18, 7.00, 5.1429, 36.00);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `familias`
--

CREATE TABLE `familias` (
  `id` int(11) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `slug` varchar(120) NOT NULL,
  `descripcion` varchar(255) DEFAULT NULL,
  `activa` tinyint(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `familias`
--

INSERT INTO `familias` (`id`, `nombre`, `slug`, `descripcion`, `activa`) VALUES
(1, 'Vacuno', 'vacuno', 'Productos de vacuno', 1),
(2, 'Pollo', 'pollo', 'Productos de pollo', 1),
(3, 'Cerdo', 'cerdo', 'Productos de cerdo', 1),
(4, 'Elaborados', 'elaborados', 'Hamburguesas y embutidos', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pedidos`
--

CREATE TABLE `pedidos` (
  `id` int(11) NOT NULL,
  `usuario_id` int(11) DEFAULT NULL,
  `nombre_cliente` varchar(120) NOT NULL,
  `telefono` varchar(30) NOT NULL,
  `email` varchar(120) DEFAULT NULL,
  `direccion` varchar(255) DEFAULT NULL,
  `fecha_recogida` date DEFAULT NULL,
  `observaciones` text DEFAULT NULL,
  `metodo_pago` enum('efectivo','tarjeta') NOT NULL DEFAULT 'efectivo',
  `estado` enum('pendiente','preparado','entregado','cancelado') NOT NULL DEFAULT 'pendiente',
  `total` decimal(10,2) NOT NULL DEFAULT 0.00,
  `fecha_creacion` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `pedidos`
--

INSERT INTO `pedidos` (`id`, `usuario_id`, `nombre_cliente`, `telefono`, `email`, `direccion`, `fecha_recogida`, `observaciones`, `metodo_pago`, `estado`, `total`, `fecha_creacion`) VALUES
(4, 2, 'Guillermo', '637807226', 'guille@gmail.com', '', NULL, '', 'efectivo', 'pendiente', 9.75, '2026-03-28 13:22:31'),
(5, 2, 'Guillermo', '637807226', 'guille@gmail.com', 'calle jesus y maria, 7', '2026-04-02', '', 'tarjeta', 'pendiente', 26.25, '2026-03-28 13:26:23'),
(6, 2, 'Guillermo', '637807226', 'guille@gmail.com', '', NULL, '', 'efectivo', 'entregado', 13.50, '2026-03-28 13:27:35'),
(7, 3, 'esther puga', '676679', 'esther@gmail.com', '', NULL, '', 'efectivo', 'preparado', 21.50, '2026-03-28 14:19:58'),
(9, 3, 'esther puga', '676679', 'esther@gmail.com', 'calle falsa 123', NULL, '', 'efectivo', 'pendiente', 6.95, '2026-03-28 15:24:00'),
(10, 3, 'esther puga', '676679', 'esther@gmail.com', 'calle falsa 123', '2026-04-02', '[PAGO EFECTIVO] Necesita cambio. Paga con billete de 30,00 €.', 'efectivo', 'pendiente', 18.00, '2026-03-29 12:54:12');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pedido_detalles`
--

CREATE TABLE `pedido_detalles` (
  `id` int(11) NOT NULL,
  `pedido_id` int(11) NOT NULL,
  `producto_id` int(11) NOT NULL,
  `nombre_producto` varchar(120) NOT NULL,
  `tipo_venta` enum('peso','unidad') NOT NULL,
  `cantidad` decimal(10,2) NOT NULL,
  `tipo_corte` varchar(50) DEFAULT NULL,
  `precio_unitario` decimal(10,2) NOT NULL,
  `coste_unitario` decimal(10,4) NOT NULL DEFAULT 0.0000,
  `coste_total` decimal(10,2) NOT NULL DEFAULT 0.00,
  `subtotal` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `pedido_detalles`
--

INSERT INTO `pedido_detalles` (`id`, `pedido_id`, `producto_id`, `nombre_producto`, `tipo_venta`, `cantidad`, `tipo_corte`, `precio_unitario`, `coste_unitario`, `coste_total`, `subtotal`) VALUES
(6, 4, 22, 'Chuletas de aguja', 'peso', 1.00, 'filete fino', 9.75, 0.0000, 0.00, 9.75),
(7, 5, 22, 'Chuletas de aguja', 'peso', 1.00, 'filete fino', 9.75, 0.0000, 0.00, 9.75),
(8, 5, 15, 'Contramuslos', 'peso', 1.30, 'filete fino', 7.50, 1.7143, 2.23, 9.75),
(9, 5, 11, 'Cañón', 'peso', 0.50, 'filete fino', 13.50, 2.2353, 1.12, 6.75),
(10, 6, 11, 'Cañón', 'peso', 1.00, 'filete fino', 13.50, 2.2353, 2.24, 13.50),
(11, 7, 3, 'Babilla', 'peso', 0.50, 'filete grueso', 15.50, 0.0000, 0.00, 7.75),
(12, 7, 12, 'Alas', 'peso', 1.00, 'filete fino', 6.95, 1.7143, 1.71, 6.95),
(13, 7, 19, 'Carne para estofar', 'peso', 0.80, 'filete fino', 8.50, 0.0000, 0.00, 6.80),
(17, 9, 12, 'Alas', 'peso', 1.00, 'filete fino', 6.95, 1.7143, 1.71, 6.95),
(18, 10, 3, 'Babilla', 'peso', 0.50, 'filete fino', 16.50, 0.0000, 0.00, 8.25),
(19, 10, 22, 'Chuletas de aguja', 'peso', 1.00, 'filete fino', 9.75, 5.1429, 5.14, 9.75);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `piezas_base`
--

CREATE TABLE `piezas_base` (
  `id` int(11) NOT NULL,
  `nombre` varchar(120) NOT NULL,
  `slug` varchar(140) NOT NULL,
  `tipo_unidad` enum('kg','unidad','caja') NOT NULL DEFAULT 'unidad',
  `precio_compra_unitario` decimal(10,2) NOT NULL DEFAULT 0.00,
  `activa` tinyint(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `piezas_base`
--

INSERT INTO `piezas_base` (`id`, `nombre`, `slug`, `tipo_unidad`, `precio_compra_unitario`, `activa`) VALUES
(1, 'Pierna', 'pierna', 'unidad', 105.00, 1),
(2, 'Delantero', 'delantero', 'unidad', 95.00, 1),
(3, 'Caja pollo despiece', 'caja-pollo-despiece', 'caja', 30.00, 1),
(4, 'Caja pollo entero', 'caja-pollo-entero', 'caja', 20.00, 1),
(5, 'Media canal cerdo', 'media-canal-cerdo', 'unidad', 90.00, 1),
(6, 'Canal completa cerdo', 'canal-completa-cerdo', 'unidad', 180.00, 1),
(7, 'Cajas de hamburguesas', 'cajas-hamburguesas', 'caja', 0.00, 0),
(8, 'Cajas de embutidos', 'cajas-embutidos', 'caja', 0.00, 0),
(9, 'Caja hamburguesas vacuno', 'caja-hamburguesas-vacuno', 'caja', 14.50, 1),
(10, 'Caja hamburguesas mixtas', 'caja-hamburguesas-mixtas', 'caja', 11.25, 1),
(11, 'Caja chorizo fresco', 'caja-chorizo-fresco', 'caja', 11.00, 1),
(12, 'Caja chorizo criollo', 'caja-chorizo-criollo', 'caja', 12.50, 1),
(13, 'Caja longaniza', 'caja-longaniza', 'caja', 7.50, 1),
(14, 'Caja morcilla de arroz', 'caja-morcilla-de-arroz', 'caja', 10.00, 1),
(15, 'Caja morcilla de cebolla', 'caja-morcilla-de-cebolla', 'caja', 10.00, 1),
(16, 'Caja carne picada mixta', 'caja-carne-picada-mixta', 'caja', 15.00, 1),
(17, 'Media canal ternera', 'media-canal-ternera', 'unidad', 210.00, 1),
(18, 'Canal completa ternera', 'canal-completa-ternera', 'unidad', 420.00, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `productos`
--

CREATE TABLE `productos` (
  `id` int(11) NOT NULL,
  `familia_id` int(11) NOT NULL,
  `nombre` varchar(120) NOT NULL,
  `slug` varchar(140) NOT NULL,
  `descripcion` text DEFAULT NULL,
  `precio` decimal(10,2) NOT NULL DEFAULT 0.00,
  `tipo_venta` enum('peso','unidad') NOT NULL,
  `imagen` varchar(255) DEFAULT NULL,
  `en_oferta` tinyint(1) NOT NULL DEFAULT 0,
  `precio_oferta` decimal(10,2) DEFAULT NULL,
  `activo` tinyint(1) NOT NULL DEFAULT 1,
  `destacado` tinyint(1) NOT NULL DEFAULT 0,
  `apto_plancha` tinyint(1) NOT NULL DEFAULT 0,
  `apto_empanar` tinyint(1) NOT NULL DEFAULT 0,
  `apto_estofar` tinyint(1) NOT NULL DEFAULT 0,
  `apto_picar` tinyint(1) NOT NULL DEFAULT 0,
  `apto_asar` tinyint(1) NOT NULL DEFAULT 0,
  `fecha_creacion` datetime NOT NULL DEFAULT current_timestamp(),
  `fecha_actualizacion` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `productos`
--

INSERT INTO `productos` (`id`, `familia_id`, `nombre`, `slug`, `descripcion`, `precio`, `tipo_venta`, `imagen`, `en_oferta`, `precio_oferta`, `activo`, `destacado`, `apto_plancha`, `apto_empanar`, `apto_estofar`, `apto_picar`, `apto_asar`, `fecha_creacion`, `fecha_actualizacion`) VALUES
(1, 1, 'Tapa', 'tapa', 'Corte de vacuno ideal para filetes', 14.95, 'peso', 'tapaterneraremovebg.png', 1, 13.50, 1, 0, 1, 0, 0, 0, 1, '2026-03-21 19:40:56', '2026-04-15 21:14:10'),
(2, 1, 'Contra', 'contra', 'Corte magro de vacuno', 13.95, 'peso', 'magravacunoremovebg.png', 0, NULL, 1, 0, 1, 0, 0, 0, 1, '2026-03-21 19:40:56', '2026-04-15 21:14:56'),
(3, 1, 'Babilla', 'babilla', 'Corte tierno de vacuno', 15.50, 'peso', 'babillavacunoremovebg.png', 0, NULL, 1, 0, 1, 0, 0, 0, 1, '2026-03-21 19:40:56', '2026-04-15 21:15:50'),
(4, 1, 'Cadera', 'cadera', 'Corte jugoso de vacuno', 16.20, 'peso', 'caderaternera.jpeg', 0, NULL, 1, 0, 1, 0, 0, 0, 1, '2026-03-21 19:40:56', '2026-04-15 21:17:47'),
(5, 1, 'Redondo', 'redondo', 'Ideal para asar', 15.80, 'peso', 'redondoternera.jpg', 0, NULL, 1, 0, 1, 0, 0, 0, 1, '2026-03-21 19:40:56', '2026-04-15 21:18:32'),
(6, 1, 'Morcillo', 'morcillo', 'Perfecto para guisos', 12.90, 'peso', 'morcilloternera.jpg', 0, NULL, 1, 0, 0, 0, 1, 0, 0, '2026-03-21 19:40:56', '2026-04-15 21:19:26'),
(7, 1, 'Carne para guisar', 'carne-para-guisar', 'Carne de vacuno para guisos', 11.95, 'peso', 'guisarvacuno.jpg', 0, NULL, 1, 0, 0, 0, 1, 0, 0, '2026-03-21 19:40:56', '2026-04-15 21:19:42'),
(8, 1, 'Carne picada', 'carne-picada', 'Carne picada de vacuno', 10.95, 'peso', 'picadavacuno.jpg', 0, NULL, 1, 0, 1, 0, 0, 0, 1, '2026-03-21 19:40:56', '2026-04-15 21:20:45'),
(9, 1, 'Aguja', 'aguja', 'Corte de delantero de vacuno', 13.50, 'peso', 'agujavacunoremovebg.png', 0, NULL, 1, 0, 1, 0, 0, 0, 1, '2026-03-21 19:40:56', '2026-04-15 21:21:31'),
(10, 1, 'Espaldilla', 'espaldilla', 'Pieza de vacuno para filetear o guisar', 13.20, 'peso', 'espaldillaternerajpg.jpg', 0, NULL, 1, 0, 1, 0, 0, 0, 1, '2026-03-21 19:40:56', '2026-04-15 21:22:12'),
(11, 1, 'Cañón', 'canon', 'Corte del delantero', 12.50, 'peso', 'cañonternera.jpg', 0, NULL, 1, 0, 1, 0, 0, 0, 1, '2026-03-21 19:40:56', '2026-04-15 21:23:21'),
(12, 2, 'Alas', 'alas', 'Alitas de pollo frescas', 5.95, 'peso', 'alitasdepollo.avif', 1, 4.95, 1, 0, 1, 0, 0, 0, 1, '2026-03-21 19:40:56', '2026-04-15 21:23:45'),
(13, 2, 'Pechuga', 'pechuga', 'Pechuga de pollo fresca', 7.95, 'peso', 'pechugapollo.jpg', 0, NULL, 1, 1, 1, 1, 0, 0, 1, '2026-03-21 19:40:56', '2026-04-15 20:57:17'),
(14, 2, 'Jamoncitos', 'jamoncitos', 'Jamoncitos de pollo', 6.95, 'peso', 'jamoncitospollo.webp', 0, NULL, 1, 0, 1, 0, 0, 0, 1, '2026-03-21 19:40:56', '2026-04-15 21:00:06'),
(15, 2, 'Contramuslos', 'contramuslos', 'Contramuslos de pollo', 6.50, 'peso', 'contramuslospolloremovebg.png', 0, NULL, 1, 0, 1, 0, 0, 0, 1, '2026-03-21 19:40:56', '2026-04-15 21:01:28'),
(16, 2, 'Traseros', 'traseros', 'Traseros de pollo', 5.90, 'peso', 'traserospolloremovebg.png', 0, NULL, 1, 0, 1, 0, 0, 0, 1, '2026-03-21 19:40:56', '2026-04-15 21:02:23'),
(17, 2, 'Pollo entero', 'pollo-entero', 'Pollo entero fresco', 1.00, 'unidad', 'Polloremovebg.png', 0, NULL, 1, 1, 1, 0, 0, 0, 1, '2026-03-21 19:40:56', '2026-04-15 21:26:31'),
(18, 3, 'Jamón', 'jamon', 'Jamón fresco de cerdo', 8.95, 'peso', 'jamonfrescocerdoremovebgneri.png', 0, NULL, 1, 0, 1, 1, 1, 1, 0, '2026-03-21 19:40:56', '2026-04-15 21:33:51'),
(19, 3, 'Carne para estofar', 'carne-para-estofar', 'Carne de cerdo para estofado', 7.50, 'peso', 'cerdoestofarremovebgbis.png', 0, NULL, 1, 0, 0, 0, 1, 1, 0, '2026-03-21 19:40:56', '2026-04-15 20:49:54'),
(20, 3, 'Costillas', 'costillas', 'Costillas frescas de cerdo', 8.20, 'peso', 'costillacerdofresca.jpg', 1, 7.20, 1, 1, 0, 0, 1, 0, 1, '2026-03-21 19:40:56', '2026-04-15 01:05:53'),
(21, 3, 'Chuletas de lomo', 'chuletas-de-lomo', 'Chuletas de lomo de cerdo', 8.95, 'peso', 'chuletaslomocerdo.jpg', 0, NULL, 1, 0, 1, 0, 0, 0, 0, '2026-03-21 19:40:56', '2026-04-15 21:03:32'),
(22, 3, 'Chuletas de aguja', 'chuletas-de-aguja', 'Chuletas de aguja de cerdo', 8.75, 'peso', 'chuletitasagujacerdo.jpg', 0, NULL, 1, 0, 1, 0, 0, 0, 1, '2026-03-21 19:40:56', '2026-04-15 21:05:17'),
(23, 3, 'Panceta', 'panceta', 'Panceta fresca de cerdo', 7.95, 'peso', 'pancetafrescacerdo.jpg', 0, NULL, 1, 0, 1, 0, 0, 0, 1, '2026-03-21 19:40:56', '2026-04-15 21:07:23'),
(24, 4, 'Hamburguesas de ternera', 'hamburguesas-ternera', 'Hamburguesas caseras de ternera', 1.80, 'unidad', 'hmremovebg.png', 0, NULL, 1, 1, 1, 0, 0, 0, 1, '2026-03-21 19:40:56', '2026-04-15 21:29:07'),
(25, 4, 'Hamburguesas mixtas', 'hamburguesas-mixtas', 'Hamburguesas mixtas caseras', 1.70, 'unidad', 'hmixta.jpg', 1, 1.50, 1, 0, 1, 0, 0, 0, 1, '2026-03-21 19:40:56', '2026-04-15 21:29:45'),
(26, 4, 'Carne picada mixta', 'carne-picada-mixta', 'Mezcla de cerdo y vacuno', 9.95, 'peso', 'carnepicadamixtaremovebg.png', 0, NULL, 1, 0, 1, 0, 0, 0, 1, '2026-03-21 19:40:56', '2026-04-15 21:31:23'),
(27, 4, 'Chorizo fresco', 'chorizo-fresco', 'Chorizo fresco casero', 9.20, 'peso', 'chorizofrescoremovebg.png', 1, 7.20, 1, 0, 1, 0, 0, 0, 1, '2026-03-21 19:40:56', '2026-04-15 21:33:04'),
(28, 4, 'Chorizo criollo', 'chorizo-criollo', 'Chorizo criollo fresco', 9.80, 'peso', 'chcriolloremovebg.png', 0, NULL, 1, 0, 1, 0, 0, 0, 1, '2026-03-21 19:40:56', '2026-04-15 21:32:20'),
(29, 4, 'Longaniza', 'longaniza', 'Longaniza fresca', 8.90, 'peso', 'longanizafrescaremovebg.png', 0, NULL, 1, 0, 1, 0, 0, 0, 1, '2026-03-21 19:40:56', '2026-04-15 21:30:15'),
(30, 4, 'Morcilla de arroz', 'morcilla-de-arroz', 'Morcilla tradicional de arroz', 8.40, 'peso', 'morcillaarrozremovebg.png', 0, NULL, 1, 0, 1, 0, 0, 0, 1, '2026-03-21 19:40:56', '2026-04-15 21:27:40'),
(31, 4, 'Morcilla de cebolla', 'morcilla-de-cebolla', 'Morcilla de cebolla fresca', 8.40, 'peso', 'morcillacebollaremovebg.png', 0, NULL, 1, 0, 1, 0, 0, 0, 1, '2026-03-21 19:40:56', '2026-04-15 21:27:55');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `recetas`
--

CREATE TABLE `recetas` (
  `id` int(11) NOT NULL,
  `titulo` varchar(150) NOT NULL,
  `slug` varchar(160) NOT NULL,
  `descripcion_corta` varchar(255) DEFAULT NULL,
  `elaboracion` text NOT NULL,
  `imagen` varchar(255) DEFAULT NULL,
  `activa` tinyint(1) NOT NULL DEFAULT 1,
  `fecha_creacion` datetime NOT NULL DEFAULT current_timestamp(),
  `fecha_actualizacion` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `ingredientes` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `recetas`
--

INSERT INTO `recetas` (`id`, `titulo`, `slug`, `descripcion_corta`, `elaboracion`, `imagen`, `activa`, `fecha_creacion`, `fecha_actualizacion`, `ingredientes`) VALUES
(1, 'Hamburguesas caseras', 'hamburguesas-caseras', 'Receta tradicional con carne picada', 'Mezclar la carne picada con sal, pimienta, ajo, perejil, un huevo, una cucharada sopera de leche (si se quiere jugosidad).\r\n\r\nFormar 4 bolas de carne del mismo tamaño, aplastarlas suavemente hasta obtener el grosor deseado.\r\n\r\nSartén: Calentar una sartén a fuego medio-alto. Cocinar las hamburguesas 4-5 minutos por cada lado (o al gusto).\r\n\r\nFundir queso: Cuando falte poco para acabar la cocción, añadir dos lonchas de queso cheddar sobre cada hamburguesa para que se funda.\r\n\r\nHorno: precalentar el horno y posteriormente calentar las hamburguesas a 200ºC entre 15 y 25 minutos. \r\n\r\nPara asegurar una cocción uniforme, se recomienda voltearlas a mitad de tiempo (alrededor del minuto 10-12). \r\n\r\nSi añades queso, colócalo en los últimos 2-5 minutos para que se derrita.\r\n\r\nTostar el pan: Tostar el pan de hamburguesa o brioche en la misma sartén o en una plancha con un poco de mantequilla o aceite hasta que esté dorado.\r\n\r\nMontaje: Sobre el pan base, colocar la carne con el queso, añadir los vegetales (lechuga, tomate, cebolla) y añadir un hilo de aceite de oliva crudo por encima para potenciar el sabor.\r\n\r\nFinalizar: Cerrar con la tapa del pan y servir.', 'hamburguesascaseras.jpg', 1, '2026-03-21 19:40:56', '2026-04-15 02:35:32', 'Carne picada 500 g \r\nPan de hamburguesa (o brioche)\r\nVarias lonchas de queso\r\nTrozos de lechuga\r\nRodaja de tomate \r\nTiras de cebolla\r\n'),
(2, 'Pollo al horno', 'pollo-al-horno', 'Pollo jugoso al horno.\r\n', 'Tiempo de preparación: 15 minutos\r\nTiempo de cocinado: 1 hora y 30 minutos\r\nTiempo total: 1 hora y 45 minutos\r\n\r\nPelamos, lavamos y cortamos en rodajas las patatas.\r\n\r\nLas salpimentamos, las ponemos sobre una bandeja de horno engrasada y añadimos la cebolla y los ajos.\r\n\r\nSalpimentamos el pollo y lo ponemos sobre la cama de patatas, vertemos el vino y añadimos el romero.\r\n\r\nAsamos el pollo con las patatas 45 minutos a 200 ºC y giramos las piezas\r\nDevolvemos el pollo al horno para hornearlo otros 45 minutos y servimos.', 'polloasadohorno2.jpg', 1, '2026-03-21 19:40:56', '2026-04-15 03:01:01', '\r\n\r\n4 patatas medianas (4 raciones)\r\n30 ml de aceite de oliva virgen extra\r\nSal\r\nPimienta negra molida\r\nMedia cebolla\r\n6 dientes de ajo\r\n1,2 kg de pollo aproximadamente (en nuestro caso, 4 muslos y 4 contramuslos)\r\n200 ml de vino blanco\r\n1 rama de romero'),
(3, 'Solomillo wellington', 'solomillo-wellington', 'Solomillo de cerdo con hojaldre', 'Preparación del relleno (Duxelle):\r\nNecesitaremos los champiñones, cebollas, nata, vino blanco y un poco de aceite de oliva. \r\n\r\nProcederemos a calentar un chorro de aceite en una sartén, a la vez que limpiamos y partimos tanto los champiñones como la cebolla, todo bien picadito para que una vez caliente la sartén, doremos las cebollas en ella.\r\n\r\nAñadimos los champiñones y esperamos a que el jugo desaparezca, momento en el que añadiremos el vino blanco, y posteriormente la nata.\r\n\r\nLo dejaremos tapado a fuego medio-suave durante unos 5 minutos. \r\n\r\nEl resultado lo trituraremos con la batidora hasta conseguir un aspecto de masa espesa. Esto será lo que envuelva posteriormente el solomillo.\r\n\r\nPreparación del solomillo Wellington:\r\nUtilizaremos la misma sartén en la que preparamos el relleno. Quitaremos los posibles restos que hayan quedado, y calentaremos otro poco de aceite. \r\n\r\nCon respecto al solomillo Wellington, lo salpimentamos al gusto de cada uno y simplemente lo sellamos por todos los lados, que se haga por fuera y quede dorado. \r\n\r\npuedes hacerlo a fuego lento, o a fuego fuerte, y posteriormente, dejar que se enfríe.\r\n\r\nMezcla de solomillo y Duxelle:\r\nLlegados a este punto tenemos por un lado sellado el solomillo, y por otro la duxelle, ambos ya fríos y listos para crear una fusión de sabor. \r\n\r\nEntra en acción el jamón ibérico, que colocaremos sobre papel de horno, o en su defecto film transparente.\r\n\r\nCada loncha irá solapada ligeramente con la siguiente e intentaremos que tenga como mínimo la misma longitud que el trozo de solomillo, creando así la base de trabajo. \r\n\r\nUna vez listo, untamos el jamón con la mostaza, y encima hacemos lo mismo con la duxelle. \r\n\r\nUntaremos el foie por toda la pieza de solomillo.\r\n\r\nColocamos el solomillo Wellington sobre la base de jamón, y con la ayuda del papel de horno o el film, empezamos a enrollar todo sobre la carne, teniendo que obtener una forma cilíndrica. \r\n\r\nIntentamos cerrar los lados y quitar el exceso de relleno que pueda sobresalir para posteriormente colocar en la nevera durante aproximadamente una hora, tratando de conseguir así una mejor unión y mezcla de todos los ingredientes.\r\n\r\nPreparación del hojaldre:\r\nEn un papel de horno colocaremos la masa de hojaldre de esta receta de solomillo Wellington, donde pondremos la preparación anterior y lo envolveremos completamente, tratando de dejar la unión de la masa hacia abajo.\r\n\r\nBatiremos un huevo y untaremos todo el hojaldre, además de ayudarnos también para cerrar los lados. \r\n\r\nEn caso de que nos sobre algo de masa, se puede partir en tiras y colocarla encima para decorar un poco.              \r\n\r\nCon el horno ya precalentado, hornearemos nuestra creación durante 35 minutos a 200ºC. \r\n\r\nSi se quiere la carne más hecha, se puede dejar más tiempo en el horno. \r\n\r\nAntes de cortar y servir, es recomendable dejar reposar 10 minutos.', 'solomillow.jpg', 1, '2026-03-28 08:26:10', '2026-04-15 03:00:31', '\r\n\r\n1 kg de solomillo (6 personas)\r\n2 cebollas\r\n400 gr de champiñones\r\n150 gr de jamón ibérico\r\n1 lámina de hojaldre\r\n75 gr de foie\r\n1 huevo\r\n25 ml de nata\r\n100 ml de vino blanco\r\n4 cucharadas de mostaza\r\nAceite de oliva virgen extra\r\nSal\r\nPimienta'),
(4, 'Costillas BBQ', 'costillas-bbq', 'Costillas al horno con salsa barbacoa', 'Tiempo total 1 h 30 m\r\nElaboración 15 m\r\nCocción 1 h 15 m\r\n\r\n\r\nPrecalentamos el horno a 190 grados con calor arriba y abajo.\r\n\r\nLa salsa barbacoa:\r\nEn el vaso de una batidora echamos el azúcar moreno, el ketchup, el vinagre, el agua, la mostaza en grano, el pimentón, la salsa Perrins, la sal y el Tabasco.\r\n\r\nTrituramos con la batidora todos los ingredientes hasta formar la salsa barbacoa. \r\n\r\nSalamos el costillar y lo untamos bien por ambos lados con la salsa barbacoa, para que quede bien impregnado. \r\n\r\nReservamos lo que nos sobre para ir pincelando durante el horneado y para servir en una salsera.\r\n\r\nColocamos en una fuente de horno engrasada con el aceite de oliva las costillas y horneamos durante una hora y quince minutos girándolo a media cocción y pincelándolo cada poco la primera media hora con la salsa barbacoa.\r\n\r\n', 'costillascerdo.webp', 1, '2026-04-15 01:58:48', '2026-04-15 03:08:51', 'Costilla de cerdo 2 kg (4 personas)\r\nAzúcar moreno 125 g\r\nKetchup 130 g\r\nVinagre 30 ml\r\nAgua 40 ml\r\nSalsa Perrins 30 ml\r\nSemillas de mostaza 10 g\r\nSalsa Tabasco 15 ml\r\nAceite de oliva virgen extra 45 ml');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `receta_productos`
--

CREATE TABLE `receta_productos` (
  `id` int(11) NOT NULL,
  `receta_id` int(11) NOT NULL,
  `producto_id` int(11) NOT NULL,
  `cantidad` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `receta_productos`
--

INSERT INTO `receta_productos` (`id`, `receta_id`, `producto_id`, `cantidad`) VALUES
(1, 1, 8, '500 g'),
(2, 2, 17, '1 unidad'),
(3, 4, 20, '1 kg'),
(4, 1, 8, '500 g');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `stock`
--

CREATE TABLE `stock` (
  `id` int(11) NOT NULL,
  `producto_id` int(11) NOT NULL,
  `cantidad` decimal(10,2) NOT NULL DEFAULT 0.00,
  `fecha_actualizacion` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `stock`
--

INSERT INTO `stock` (`id`, `producto_id`, `cantidad`, `fecha_actualizacion`) VALUES
(1, 1, 0.00, '2026-03-28 10:53:07'),
(2, 2, 0.00, '2026-03-28 10:53:07'),
(3, 3, 0.00, '2026-03-29 12:54:12'),
(4, 4, 0.00, '2026-03-28 10:53:07'),
(5, 5, 0.00, '2026-03-28 10:53:07'),
(6, 6, 5.00, '2026-03-28 13:24:12'),
(7, 7, 8.00, '2026-03-28 13:24:12'),
(8, 8, 8.00, '2026-03-28 13:24:12'),
(9, 9, 14.00, '2026-03-28 13:24:12'),
(10, 10, 4.50, '2026-03-28 13:24:12'),
(11, 11, 1.50, '2026-03-28 14:33:11'),
(12, 12, 3.00, '2026-03-28 15:24:00'),
(13, 13, 15.00, '2026-03-28 13:24:49'),
(14, 14, 7.00, '2026-03-28 13:24:49'),
(15, 15, 6.70, '2026-03-28 13:26:23'),
(16, 16, 0.00, '2026-03-21 19:40:56'),
(17, 17, 0.00, '2026-03-28 11:23:55'),
(18, 18, 21.00, '2026-03-28 14:35:58'),
(19, 19, 11.95, '2026-03-28 14:35:58'),
(20, 20, 6.00, '2026-03-28 14:35:58'),
(21, 21, 7.50, '2026-03-28 14:35:58'),
(22, 22, 4.50, '2026-03-29 12:54:12'),
(23, 23, 0.00, '2026-03-21 19:40:56'),
(24, 24, 0.00, '2026-03-21 19:40:56'),
(25, 25, 0.00, '2026-03-21 19:40:56'),
(26, 26, 0.00, '2026-03-21 19:40:56'),
(27, 27, 0.00, '2026-03-21 19:40:56'),
(28, 28, 0.00, '2026-03-21 19:40:56'),
(29, 29, 0.00, '2026-03-28 11:23:46'),
(30, 30, 0.00, '2026-03-21 19:40:56'),
(31, 31, 0.00, '2026-03-21 19:40:56');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `id` int(11) NOT NULL,
  `nombre` varchar(120) NOT NULL,
  `email` varchar(120) NOT NULL,
  `telefono` varchar(30) DEFAULT NULL,
  `direccion` varchar(255) DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `activo` tinyint(1) NOT NULL DEFAULT 1,
  `fecha_creacion` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id`, `nombre`, `email`, `telefono`, `direccion`, `password`, `activo`, `fecha_creacion`) VALUES
(1, 'guille', 'aguille@gmail.com', '666666666', NULL, '$2y$10$n3G1oTtIxSJBciy7wnE.juaMIieOa8R4cp4R7Ixdfjf4MRipmiGZC', 1, '2026-03-22 19:50:03'),
(2, 'Guillermo', 'guille@gmail.com', '637807226', NULL, '$2y$10$.D7eAMASKT7ol2sOegeW1OkgKgGR./H9sd5D.Xo6lDuJocVEEZNxa', 1, '2026-03-28 13:18:38'),
(3, 'esther puga', 'esther@gmail.com', '676679', 'calle falsa 123', '$2y$10$liYvHb9NAdlKlRNGNLXl/.LJWtYt7euk57VSLQPk8.SOj0Unss7u2', 1, '2026-03-28 14:18:48'),
(4, 'esther puga 2', 'esther2@gmail.com', '64732932323', 'callefalsa 123', '$2y$10$CKEUIwvs6KzQh9xCgKXfzOjPvCapsgo.99n6kPvbTkPW0rMpnDtui', 1, '2026-03-28 14:27:20');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `administradores`
--
ALTER TABLE `administradores`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indices de la tabla `contacto_mensajes`
--
ALTER TABLE `contacto_mensajes`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `despiece_reglas`
--
ALTER TABLE `despiece_reglas`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_despiece_reglas_pieza` (`pieza_base_id`),
  ADD KEY `fk_despiece_reglas_producto` (`producto_id`);

--
-- Indices de la tabla `entradas_compra`
--
ALTER TABLE `entradas_compra`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_entradas_compra_pieza` (`pieza_base_id`),
  ADD KEY `fk_entradas_compra_admin` (`administrador_id`);

--
-- Indices de la tabla `entrada_detalles`
--
ALTER TABLE `entrada_detalles`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_entrada_detalles_entrada` (`entrada_compra_id`),
  ADD KEY `fk_entrada_detalles_producto` (`producto_id`);

--
-- Indices de la tabla `familias`
--
ALTER TABLE `familias`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `slug` (`slug`);

--
-- Indices de la tabla `pedidos`
--
ALTER TABLE `pedidos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_pedidos_usuario` (`usuario_id`);

--
-- Indices de la tabla `pedido_detalles`
--
ALTER TABLE `pedido_detalles`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_pedido_detalles_pedido` (`pedido_id`),
  ADD KEY `fk_pedido_detalles_producto` (`producto_id`);

--
-- Indices de la tabla `piezas_base`
--
ALTER TABLE `piezas_base`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `slug` (`slug`);

--
-- Indices de la tabla `productos`
--
ALTER TABLE `productos`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `slug` (`slug`),
  ADD KEY `fk_productos_familias` (`familia_id`);

--
-- Indices de la tabla `recetas`
--
ALTER TABLE `recetas`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `slug` (`slug`);

--
-- Indices de la tabla `receta_productos`
--
ALTER TABLE `receta_productos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_receta_productos_receta` (`receta_id`),
  ADD KEY `fk_receta_productos_producto` (`producto_id`);

--
-- Indices de la tabla `stock`
--
ALTER TABLE `stock`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `producto_id` (`producto_id`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `administradores`
--
ALTER TABLE `administradores`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `contacto_mensajes`
--
ALTER TABLE `contacto_mensajes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `despiece_reglas`
--
ALTER TABLE `despiece_reglas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=103;

--
-- AUTO_INCREMENT de la tabla `entradas_compra`
--
ALTER TABLE `entradas_compra`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT de la tabla `entrada_detalles`
--
ALTER TABLE `entrada_detalles`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=52;

--
-- AUTO_INCREMENT de la tabla `familias`
--
ALTER TABLE `familias`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `pedidos`
--
ALTER TABLE `pedidos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT de la tabla `pedido_detalles`
--
ALTER TABLE `pedido_detalles`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT de la tabla `piezas_base`
--
ALTER TABLE `piezas_base`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT de la tabla `productos`
--
ALTER TABLE `productos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT de la tabla `recetas`
--
ALTER TABLE `recetas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `receta_productos`
--
ALTER TABLE `receta_productos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `stock`
--
ALTER TABLE `stock`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `despiece_reglas`
--
ALTER TABLE `despiece_reglas`
  ADD CONSTRAINT `fk_despiece_reglas_pieza` FOREIGN KEY (`pieza_base_id`) REFERENCES `piezas_base` (`id`),
  ADD CONSTRAINT `fk_despiece_reglas_producto` FOREIGN KEY (`producto_id`) REFERENCES `productos` (`id`);

--
-- Filtros para la tabla `entradas_compra`
--
ALTER TABLE `entradas_compra`
  ADD CONSTRAINT `fk_entradas_compra_admin` FOREIGN KEY (`administrador_id`) REFERENCES `administradores` (`id`),
  ADD CONSTRAINT `fk_entradas_compra_pieza` FOREIGN KEY (`pieza_base_id`) REFERENCES `piezas_base` (`id`);

--
-- Filtros para la tabla `entrada_detalles`
--
ALTER TABLE `entrada_detalles`
  ADD CONSTRAINT `fk_entrada_detalles_entrada` FOREIGN KEY (`entrada_compra_id`) REFERENCES `entradas_compra` (`id`),
  ADD CONSTRAINT `fk_entrada_detalles_producto` FOREIGN KEY (`producto_id`) REFERENCES `productos` (`id`);

--
-- Filtros para la tabla `pedidos`
--
ALTER TABLE `pedidos`
  ADD CONSTRAINT `fk_pedidos_usuario` FOREIGN KEY (`usuario_id`) REFERENCES `usuarios` (`id`);

--
-- Filtros para la tabla `pedido_detalles`
--
ALTER TABLE `pedido_detalles`
  ADD CONSTRAINT `fk_pedido_detalles_pedido` FOREIGN KEY (`pedido_id`) REFERENCES `pedidos` (`id`),
  ADD CONSTRAINT `fk_pedido_detalles_producto` FOREIGN KEY (`producto_id`) REFERENCES `productos` (`id`);

--
-- Filtros para la tabla `productos`
--
ALTER TABLE `productos`
  ADD CONSTRAINT `fk_productos_familias` FOREIGN KEY (`familia_id`) REFERENCES `familias` (`id`);

--
-- Filtros para la tabla `receta_productos`
--
ALTER TABLE `receta_productos`
  ADD CONSTRAINT `fk_receta_productos_producto` FOREIGN KEY (`producto_id`) REFERENCES `productos` (`id`),
  ADD CONSTRAINT `fk_receta_productos_receta` FOREIGN KEY (`receta_id`) REFERENCES `recetas` (`id`);

--
-- Filtros para la tabla `stock`
--
ALTER TABLE `stock`
  ADD CONSTRAINT `fk_stock_producto` FOREIGN KEY (`producto_id`) REFERENCES `productos` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
