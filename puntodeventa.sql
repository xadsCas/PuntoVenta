-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 07-05-2025 a las 10:19:59
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
-- Base de datos: `puntodeventa`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `arqueo`
--

CREATE TABLE `arqueo` (
  `Id_Arqueo` int(11) NOT NULL,
  `IdEmpleado` int(11) NOT NULL,
  `Fecha` datetime NOT NULL DEFAULT current_timestamp(),
  `Total_efectivo` decimal(10,2) NOT NULL,
  `Diferencia` decimal(10,2) NOT NULL,
  `Observaciones` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `arqueo`
--

INSERT INTO `arqueo` (`Id_Arqueo`, `IdEmpleado`, `Fecha`, `Total_efectivo`, `Diferencia`, `Observaciones`) VALUES
(1, 23, '2025-05-05 04:13:31', 15409.00, 0.00, 'Ninguna'),
(2, 23, '2025-05-05 04:14:30', 2.00, -15407.00, 'Prueba con diferencia'),
(3, 42, '2025-05-06 23:05:47', 10000.00, -6646.00, 'Ninguna'),
(4, 43, '2025-05-07 00:23:19', 1600.00, -15184.00, 'ninguna');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `caja`
--

CREATE TABLE `caja` (
  `id` int(11) NOT NULL,
  `dinero_actual` decimal(10,2) NOT NULL DEFAULT 0.00,
  `ultima_actualizacion` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `caja`
--

INSERT INTO `caja` (`id`, `dinero_actual`, `ultima_actualizacion`) VALUES
(1, 16869.00, '2025-05-07 01:14:53'),
(2, 10000.00, '2025-03-31 23:46:40');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `clientes`
--

CREATE TABLE `clientes` (
  `ID_cliente` int(11) NOT NULL,
  `Rfc` varchar(13) NOT NULL,
  `Nombre` varchar(100) NOT NULL,
  `Direccion` varchar(255) DEFAULT NULL,
  `Correo` varchar(100) DEFAULT NULL,
  `Telefono` varchar(15) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `clientes`
--

INSERT INTO `clientes` (`ID_cliente`, `Rfc`, `Nombre`, `Direccion`, `Correo`, `Telefono`) VALUES
(6, '12121', 'Ernesto', 'angel flores 3027, vicente guerrero', 'ernestocastilloinzunza@gmail.com', '6674699939'),
(7, 'iu743222', 'bryan', 'angel flores 3027, vicente guerrero', '12121@gmail.com', '666'),
(8, '1523122', 'bryan', 'angel flores 3027, vicente guerrero', '6674699939@gmail.com', '121121212'),
(12, 'iu7432222', 'Evelynn2', 'angel flores 3027, vicente guerrero', '222222@yopmail.com', '6674699939'),
(16, 'RFC16', 'Cliente 16', 'Dirección 16', 'Correo 16', 'Telefono 16'),
(17, '98765432', 'Crispin Alejandro', '98765432', 'ernestocastilloinzunza@gmail.com', '212'),
(18, '213247r8t9876', '12312u7635', '1326o6852354', '12467859568346214@gmail.com', '12342475'),
(19, '123456', '65432', '12345678', 'castillotito099@gmail.com', '124567'),
(20, 'si', 'Evelynn', 'angel flores 3027, vicente guerrero', 'ernestocastilloinzunza@gmail.com', '6672476969'),
(21, '5678909', 'arturo', 'fic', 'arturo@gmail.com', '456789'),
(22, '23456789op', 'Antonio', 'sdagyudbi', 'oa@yopmail.com', '678io');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `compra`
--

CREATE TABLE `compra` (
  `ID_Compra` int(11) NOT NULL,
  `Id_proveedor` int(11) NOT NULL,
  `Fecha` datetime NOT NULL DEFAULT current_timestamp(),
  `Total` decimal(10,2) NOT NULL,
  `Estado` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `compra`
--

INSERT INTO `compra` (`ID_Compra`, `Id_proveedor`, `Fecha`, `Total`, `Estado`) VALUES
(13, 8, '2025-03-31 23:44:49', 150.00, 'Pendiente'),
(14, 8, '2025-03-31 23:47:04', 75.00, 'Pendiente'),
(15, 8, '2025-03-31 23:49:54', 45.00, 'Pendiente'),
(16, 8, '2025-04-23 20:07:03', 60.00, 'Pendiente'),
(17, 8, '2025-04-23 20:07:36', 60.00, 'Pendiente'),
(18, 8, '2025-04-23 20:07:39', 45.00, 'Pendiente'),
(19, 8, '2025-04-23 20:10:29', 45.00, 'Pendiente'),
(20, 8, '2025-04-23 20:22:02', 45.00, 'Pendiente'),
(21, 8, '2025-04-23 20:26:05', 15.00, 'Pendiente'),
(22, 8, '2025-04-23 20:29:40', 30.00, 'Pendiente'),
(23, 8, '2025-04-23 20:31:48', 30.00, 'Pendiente'),
(24, 8, '2025-04-23 20:31:54', 15.00, 'Pendiente'),
(25, 10, '2025-04-23 20:35:27', 60.00, 'Pendiente'),
(26, 8, '2025-04-23 20:35:38', 70.00, 'Pendiente'),
(27, 11, '2025-04-27 19:35:51', 100.00, 'Pendiente'),
(28, 12, '2025-04-28 13:08:55', 50.00, 'Pendiente'),
(29, 10, '2025-04-28 13:09:01', 75.00, 'Pendiente'),
(30, 8, '2025-04-28 13:09:07', 115.00, 'Pendiente'),
(31, 11, '2025-04-28 13:09:12', 70.00, 'Pendiente'),
(32, 12, '2025-04-28 14:18:00', 510.00, 'Pendiente'),
(33, 8, '2025-04-30 21:12:27', 855.00, 'Pendiente'),
(34, 10, '2025-05-01 02:49:00', 90.00, 'Pendiente'),
(35, 10, '2025-05-01 02:49:00', 90.00, 'Pendiente'),
(36, 10, '2025-05-01 02:49:01', 90.00, 'Pendiente'),
(37, 10, '2025-05-01 02:49:01', 90.00, 'Pendiente'),
(38, 8, '2025-05-03 17:11:19', 200.00, 'Pendiente'),
(39, 12, '2025-05-04 19:02:59', 70.00, 'Pendiente'),
(40, 12, '2025-05-04 19:03:46', 70.00, 'Pendiente'),
(41, 12, '2025-05-04 19:04:40', 70.00, 'Pendiente'),
(42, 8, '2025-05-04 19:05:26', 110.00, 'Pendiente'),
(43, 11, '2025-05-04 19:06:24', 30.00, 'Pendiente'),
(44, 8, '2025-05-06 15:19:55', 530.00, 'Pendiente'),
(45, 10, '2025-05-07 01:14:53', 75.00, 'Pendiente');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `corte_caja`
--

CREATE TABLE `corte_caja` (
  `Id_Corte` int(11) NOT NULL,
  `Id_Empleado` int(11) NOT NULL,
  `Fecha` datetime NOT NULL DEFAULT current_timestamp(),
  `Total_sistema` decimal(10,2) NOT NULL,
  `Total_efectivo` decimal(10,2) NOT NULL,
  `Diferencia` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `corte_caja`
--

INSERT INTO `corte_caja` (`Id_Corte`, `Id_Empleado`, `Fecha`, `Total_sistema`, `Total_efectivo`, `Diferencia`) VALUES
(1, 23, '2025-05-07 01:12:03', 100.00, 100.00, 0.00),
(2, 23, '2025-05-07 01:15:04', 25.00, 25.00, 0.00);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `detalle_compra`
--

CREATE TABLE `detalle_compra` (
  `Id_Detalle` int(11) NOT NULL,
  `Id_compra` int(11) NOT NULL,
  `Id_producto` int(11) NOT NULL,
  `Cantidad` int(11) NOT NULL,
  `Precio_unitario` decimal(10,2) NOT NULL,
  `Subtotal` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `detalle_compra`
--

INSERT INTO `detalle_compra` (`Id_Detalle`, `Id_compra`, `Id_producto`, `Cantidad`, `Precio_unitario`, `Subtotal`) VALUES
(1, 13, 8, 10, 15.00, 150.00),
(2, 14, 8, 5, 15.00, 75.00),
(3, 15, 8, 3, 15.00, 45.00),
(4, 16, 8, 4, 15.00, 60.00),
(5, 17, 8, 4, 15.00, 60.00),
(6, 18, 8, 3, 15.00, 45.00),
(7, 19, 8, 3, 15.00, 45.00),
(8, 20, 8, 3, 15.00, 45.00),
(9, 21, 8, 1, 15.00, 15.00),
(10, 22, 8, 2, 15.00, 30.00),
(11, 23, 8, 2, 15.00, 30.00),
(12, 24, 8, 1, 15.00, 15.00),
(13, 25, 10, 4, 15.00, 60.00),
(14, 26, 8, 2, 15.00, 30.00),
(15, 26, 9, 4, 10.00, 40.00),
(16, 27, 11, 10, 10.00, 100.00),
(17, 28, 12, 10, 5.00, 50.00),
(18, 29, 10, 5, 15.00, 75.00),
(19, 30, 8, 5, 15.00, 75.00),
(20, 30, 9, 4, 10.00, 40.00),
(21, 31, 11, 7, 10.00, 70.00),
(22, 32, 12, 100, 5.00, 500.00),
(23, 32, 13, 1, 10.00, 10.00),
(24, 33, 8, 57, 15.00, 855.00),
(25, 34, 10, 6, 15.00, 90.00),
(26, 35, 10, 6, 15.00, 90.00),
(27, 36, 10, 6, 15.00, 90.00),
(28, 37, 10, 6, 15.00, 90.00),
(29, 38, 8, 10, 15.00, 150.00),
(30, 38, 9, 5, 10.00, 50.00),
(31, 39, 12, 2, 5.00, 10.00),
(32, 39, 13, 6, 10.00, 60.00),
(33, 40, 12, 2, 5.00, 10.00),
(34, 40, 13, 6, 10.00, 60.00),
(35, 41, 12, 2, 5.00, 10.00),
(36, 41, 13, 6, 10.00, 60.00),
(37, 42, 8, 4, 15.00, 60.00),
(38, 42, 9, 5, 10.00, 50.00),
(39, 43, 11, 3, 10.00, 30.00),
(40, 44, 8, 13, 15.00, 195.00),
(41, 44, 9, 2, 10.00, 20.00),
(42, 44, 26, 15, 21.00, 315.00),
(43, 45, 10, 5, 15.00, 75.00);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `detalle_venta`
--

CREATE TABLE `detalle_venta` (
  `Id_Detalle` int(11) NOT NULL,
  `Folio_venta` int(11) NOT NULL,
  `Id_producto` int(11) NOT NULL,
  `Cantidad` int(11) NOT NULL,
  `Precio_unitario` decimal(10,2) NOT NULL,
  `Subtotal` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `detalle_venta`
--

INSERT INTO `detalle_venta` (`Id_Detalle`, `Folio_venta`, `Id_producto`, `Cantidad`, `Precio_unitario`, `Subtotal`) VALUES
(1, 8, 8, 2, 25.00, 50.00),
(2, 9, 8, 4, 25.00, 100.00),
(3, 10, 8, 1, 25.00, 25.00),
(4, 11, 8, 3, 25.00, 75.00),
(5, 11, 9, 3, 21.00, 63.00),
(6, 11, 10, 3, 21.00, 63.00),
(7, 12, 9, 2, 21.00, 42.00),
(8, 12, 11, 19, 20.00, 380.00),
(9, 13, 9, 3, 21.00, 63.00),
(10, 13, 12, 8, 10.00, 80.00),
(11, 14, 8, 2, 25.00, 50.00),
(12, 14, 11, 1, 20.00, 20.00),
(13, 14, 13, 50, 50.00, 2500.00),
(14, 15, 8, 3, 25.00, 75.00),
(15, 15, 9, 4, 21.00, 84.00),
(16, 16, 13, 3, 50.00, 150.00),
(17, 16, 8, 2, 25.00, 50.00),
(18, 17, 8, 4, 25.00, 100.00),
(19, 17, 13, 4, 50.00, 200.00),
(20, 18, 8, 3, 25.00, 75.00),
(21, 18, 10, 3, 21.00, 63.00),
(22, 19, 8, 1, 25.00, 25.00),
(23, 20, 8, 4, 25.00, 100.00),
(24, 20, 12, 3, 10.00, 30.00),
(25, 21, 8, 4, 25.00, 100.00),
(26, 21, 12, 3, 10.00, 30.00),
(27, 22, 8, 4, 25.00, 100.00),
(28, 22, 12, 3, 10.00, 30.00),
(29, 23, 8, 4, 25.00, 100.00),
(30, 23, 12, 3, 10.00, 30.00),
(31, 24, 8, 4, 25.00, 100.00),
(32, 24, 12, 3, 10.00, 30.00),
(33, 25, 8, 4, 25.00, 100.00),
(34, 25, 12, 3, 10.00, 30.00),
(35, 26, 8, 4, 25.00, 100.00),
(36, 26, 12, 3, 10.00, 30.00),
(37, 27, 8, 4, 25.00, 100.00),
(38, 27, 12, 3, 10.00, 30.00),
(39, 28, 8, 4, 25.00, 100.00),
(40, 28, 12, 3, 10.00, 30.00),
(41, 29, 8, 4, 25.00, 100.00),
(42, 29, 12, 3, 10.00, 30.00),
(43, 30, 8, 4, 25.00, 100.00),
(44, 30, 12, 3, 10.00, 30.00),
(45, 31, 10, 4, 21.00, 84.00),
(46, 32, 8, 10, 25.00, 250.00),
(47, 33, 8, 5, 25.00, 125.00),
(48, 33, 11, 4, 20.00, 80.00),
(49, 33, 13, 2, 50.00, 100.00),
(50, 34, 13, 20, 50.00, 1000.00),
(51, 34, 14, 1, 1212.00, 1212.00),
(52, 35, 8, 1, 25.00, 25.00),
(53, 35, 14, 1, 1212.00, 1212.00),
(54, 36, 8, 2, 25.00, 50.00),
(55, 36, 23, 4, 121.00, 484.00),
(56, 36, 25, 2, 22.00, 44.00),
(57, 36, 26, 3, 30.00, 90.00),
(58, 37, 26, 2, 30.00, 60.00),
(59, 38, 8, 4, 25.00, 100.00);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `empleado`
--

CREATE TABLE `empleado` (
  `Id_Empleado` int(11) NOT NULL,
  `Nombre` varchar(100) NOT NULL,
  `Puesto` varchar(50) NOT NULL,
  `Id_Puesto` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `empleado`
--

INSERT INTO `empleado` (`Id_Empleado`, `Nombre`, `Puesto`, `Id_Puesto`) VALUES
(23, 'Ernesto', 'si', NULL),
(24, 'Carlos Zapotitlán', 'Administrador ', NULL),
(25, 'raquel', 'barrendera', NULL),
(26, 'Nico', 'Jefe', NULL),
(27, 'raquel2', 'cajera', NULL),
(28, 'chucho', 'gerente', NULL),
(29, 'Juan', 'Cajero', NULL),
(30, 'Empleado Insano', '', 2),
(31, 'Crispin insano', '', 4),
(32, 'Crispin Alejandro', '', 1),
(33, 'Crispin Alejandro', '', 1),
(34, 'Marialuisa', '', 3),
(35, 'Marialuisa', '', 3),
(36, 'Empleado 36', '', 1),
(37, 'Marialuisa', '', 3),
(38, 'Marialuisa', '', 2),
(39, 'Evelynn', '', 2),
(40, 'bryan', '', 1),
(41, 'Juanito Alcachofa', '', 1),
(42, 'Guillermo', '', 3),
(43, 'Victor', '', 2);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `factura`
--

CREATE TABLE `factura` (
  `ID_Factura` int(11) NOT NULL,
  `Folio_venta` int(11) NOT NULL,
  `Rfc_cliente` varchar(13) NOT NULL,
  `Fecha_emision` datetime NOT NULL DEFAULT current_timestamp(),
  `Estado` varchar(50) NOT NULL,
  `Monto` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `inventario`
--

CREATE TABLE `inventario` (
  `id_producto` int(11) NOT NULL,
  `Nombre` varchar(100) NOT NULL,
  `Descripcion` text DEFAULT NULL,
  `Precio_venta` decimal(10,2) NOT NULL,
  `Precio_compra` decimal(10,2) NOT NULL,
  `Categoria` varchar(50) DEFAULT NULL,
  `Stock_actual` int(11) NOT NULL DEFAULT 0,
  `Stock_minimo` int(11) NOT NULL DEFAULT 0,
  `Ultima_entrada` datetime DEFAULT NULL,
  `Ultima_salida` datetime DEFAULT NULL,
  `Id_proveedor` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `inventario`
--

INSERT INTO `inventario` (`id_producto`, `Nombre`, `Descripcion`, `Precio_venta`, `Precio_compra`, `Categoria`, `Stock_actual`, `Stock_minimo`, `Ultima_entrada`, `Ultima_salida`, `Id_proveedor`) VALUES
(8, 'Roles de canela', 'Roles', 25.00, 15.00, 'Pan', 41, 0, NULL, NULL, 8),
(9, 'Sabritas', 'Sabritas de sal', 21.00, 10.00, 'Sabritas', 18, 1, NULL, NULL, 8),
(10, 'Galletas', ':v', 21.00, 15.00, 'galletas', 38, 2, NULL, NULL, 10),
(11, 'Jugo', 'Jugo', 20.00, 10.00, 'Jugo', 16, 2, NULL, NULL, 11),
(12, 'Galvez', 'Profesor de programacion', 10.00, 5.00, 'si', 85, 1, NULL, NULL, 12),
(13, 'Chocolate', 'si', 50.00, 10.00, 'sasaa', 940, 1, NULL, NULL, 12),
(14, 'papa', ':v', 1212.00, 1.00, 'Sabritas', 1210, 1, NULL, NULL, 13),
(15, 'papa', ':v', 1212.00, 1.00, 'Sabritas', 1212, 1, NULL, NULL, 13),
(16, 'Papa52', 'modificado', 11212.00, 1.00, 'Sabritas', 12, 1, NULL, NULL, 13),
(17, 'papa', ':v', 1212.00, 1.00, 'Sabritas', 1212, 1, NULL, NULL, 13),
(18, 'papa', ':v', 1212.00, 1.00, 'Sabritas', 1212, 1, NULL, NULL, 13),
(19, 'papa', ':v', 1212.00, 1.00, 'Sabritas', 1212, 1, NULL, NULL, 13),
(20, 'papa', ':v', 1212.00, 1.00, 'Sabritas', 1212, 1, NULL, NULL, 13),
(21, 'papa', ':v', 1212.00, 1.00, 'Sabritas', 1212, 1, NULL, NULL, 13),
(22, 'papa', ':v', 1212.00, 1.00, 'Sabritas', 1212, 1, NULL, NULL, 13),
(23, 'Sabritas', '12122121', 121.00, 121.00, 'Sabritas', 8, 1, NULL, NULL, 18),
(24, 'Evelynncita', 'Rica', 150.00, 100.00, 'si', 1, 0, NULL, NULL, 20),
(25, 'Coca', 'Coca', 22.00, 18.00, 'coca', 99997, 1, NULL, NULL, 21),
(26, 'Ch2', 'chocolate', 30.00, 21.00, 'sass', 25, 1, NULL, NULL, 8);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `movimiento_inventario`
--

CREATE TABLE `movimiento_inventario` (
  `Id_movimiento` int(11) NOT NULL,
  `Id_producto` int(11) NOT NULL,
  `Cantidad` int(11) NOT NULL,
  `Fecha` datetime NOT NULL DEFAULT current_timestamp(),
  `TipoMovimiento` enum('ENTRADA','SALIDA','AJUSTE') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `proveedores`
--

CREATE TABLE `proveedores` (
  `ID_Proveedor` int(11) NOT NULL,
  `Nombre` varchar(100) NOT NULL,
  `RFC` varchar(13) NOT NULL,
  `Domicilio` varchar(255) DEFAULT NULL,
  `Telefono` varchar(15) DEFAULT NULL,
  `Correo` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `proveedores`
--

INSERT INTO `proveedores` (`ID_Proveedor`, `Nombre`, `RFC`, `Domicilio`, `Telefono`, `Correo`) VALUES
(8, 'Bimbo', 'iu7432', 'culiacan', '666', 'bimbo@bimbo.com'),
(10, 'Crispin Alejandro', '22121', 'angel flores 3027, vicente guerrero', '6674699939', 'ernestocastilloinzunza@gmail.com'),
(11, 'Juanito', '12123121132', 'alauakbar', '66674699939', 'juanito@yopmail.com'),
(12, 'Pancho', '56789', 'jakajska', '88888', '9999@juan.com'),
(13, 'Papa', '313211212', 'Juanito 20', '2112122112', 'uas@gmail.com'),
(14, 'gamesa', '124223', 'Angel flores', '1212121', 'Uas1@gmail.com'),
(15, 'qwqw', '121212', 'qwqwq', '89', 'wqwq@gmail.com'),
(18, 'Juanito', '214321q23', 'tonota', '12121212121', 'juanito@gmail.com'),
(19, 'bryan', '12212222', '22222', '121222222', '22222@yopmail.com'),
(20, 'Tostadas Carmelita', '56789o0987654', 'angel flores 3027, vicente guerrero', '6657921', 'carmelita@gmail.com'),
(21, 'roy', 'roy123', 'fic', '78987656', 'roy@fic.com');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `puesto`
--

CREATE TABLE `puesto` (
  `Id_Puesto` int(11) NOT NULL,
  `Nombre` varchar(50) NOT NULL,
  `Descripcion` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `puesto`
--

INSERT INTO `puesto` (`Id_Puesto`, `Nombre`, `Descripcion`) VALUES
(1, 'Cajero', 'Encargado de caja y atención al cliente'),
(2, 'Gerente', 'Administra el negocio'),
(3, 'Almacenista', 'Control de inventario y almacén'),
(4, 'Mesero', 'Atiende a los clientes en mesa');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `venta`
--

CREATE TABLE `venta` (
  `Folio` int(11) NOT NULL,
  `Id_Empleado` int(11) NOT NULL,
  `Fecha` datetime NOT NULL DEFAULT current_timestamp(),
  `Total` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `venta`
--

INSERT INTO `venta` (`Folio`, `Id_Empleado`, `Fecha`, `Total`) VALUES
(8, 23, '2025-03-31 23:49:37', 50.00),
(9, 23, '2025-04-23 20:18:49', 100.00),
(10, 24, '2025-04-23 20:23:26', 25.00),
(11, 25, '2025-04-23 20:35:51', 201.00),
(12, 26, '2025-04-27 19:34:58', 422.00),
(13, 27, '2025-04-28 13:08:20', 143.00),
(14, 26, '2025-04-28 14:18:46', 2570.00),
(15, 23, '2025-04-28 18:59:52', 159.00),
(16, 23, '2025-04-30 19:24:02', 200.00),
(17, 25, '2025-04-30 19:26:20', 300.00),
(18, 23, '2025-04-30 19:36:30', 138.00),
(19, 23, '2025-04-30 19:57:51', 25.00),
(20, 23, '2025-04-30 21:04:16', 130.00),
(21, 23, '2025-04-30 21:06:58', 130.00),
(22, 23, '2025-04-30 21:06:59', 130.00),
(23, 23, '2025-04-30 21:07:01', 130.00),
(24, 23, '2025-04-30 21:07:01', 130.00),
(25, 23, '2025-04-30 21:07:02', 130.00),
(26, 23, '2025-04-30 21:07:02', 130.00),
(27, 23, '2025-04-30 21:07:03', 130.00),
(28, 23, '2025-04-30 21:07:03', 130.00),
(29, 23, '2025-04-30 21:07:03', 130.00),
(30, 23, '2025-04-30 21:07:03', 130.00),
(31, 23, '2025-04-30 21:10:55', 84.00),
(32, 23, '2025-04-30 21:14:10', 250.00),
(33, 23, '2025-05-01 04:40:53', 305.00),
(34, 39, '2025-05-03 17:12:12', 2212.00),
(35, 42, '2025-05-06 14:02:30', 1237.00),
(36, 43, '2025-05-06 15:21:23', 668.00),
(37, 23, '2025-05-06 23:26:59', 60.00),
(38, 23, '2025-05-07 01:11:53', 100.00);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `arqueo`
--
ALTER TABLE `arqueo`
  ADD PRIMARY KEY (`Id_Arqueo`),
  ADD KEY `IdEmpleado` (`IdEmpleado`);

--
-- Indices de la tabla `caja`
--
ALTER TABLE `caja`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `clientes`
--
ALTER TABLE `clientes`
  ADD PRIMARY KEY (`ID_cliente`),
  ADD UNIQUE KEY `Rfc` (`Rfc`);

--
-- Indices de la tabla `compra`
--
ALTER TABLE `compra`
  ADD PRIMARY KEY (`ID_Compra`),
  ADD KEY `Id_proveedor` (`Id_proveedor`);

--
-- Indices de la tabla `corte_caja`
--
ALTER TABLE `corte_caja`
  ADD PRIMARY KEY (`Id_Corte`),
  ADD KEY `Id_Empleado` (`Id_Empleado`);

--
-- Indices de la tabla `detalle_compra`
--
ALTER TABLE `detalle_compra`
  ADD PRIMARY KEY (`Id_Detalle`),
  ADD KEY `Id_compra` (`Id_compra`),
  ADD KEY `Id_producto` (`Id_producto`);

--
-- Indices de la tabla `detalle_venta`
--
ALTER TABLE `detalle_venta`
  ADD PRIMARY KEY (`Id_Detalle`),
  ADD KEY `Folio_venta` (`Folio_venta`),
  ADD KEY `Id_producto` (`Id_producto`);

--
-- Indices de la tabla `empleado`
--
ALTER TABLE `empleado`
  ADD PRIMARY KEY (`Id_Empleado`),
  ADD KEY `fk_puesto` (`Id_Puesto`);

--
-- Indices de la tabla `factura`
--
ALTER TABLE `factura`
  ADD PRIMARY KEY (`ID_Factura`),
  ADD KEY `Folio_venta` (`Folio_venta`),
  ADD KEY `Rfc_cliente` (`Rfc_cliente`);

--
-- Indices de la tabla `inventario`
--
ALTER TABLE `inventario`
  ADD PRIMARY KEY (`id_producto`),
  ADD KEY `Id_proveedor` (`Id_proveedor`);

--
-- Indices de la tabla `movimiento_inventario`
--
ALTER TABLE `movimiento_inventario`
  ADD PRIMARY KEY (`Id_movimiento`),
  ADD KEY `Id_producto` (`Id_producto`);

--
-- Indices de la tabla `proveedores`
--
ALTER TABLE `proveedores`
  ADD PRIMARY KEY (`ID_Proveedor`),
  ADD UNIQUE KEY `RFC` (`RFC`);

--
-- Indices de la tabla `puesto`
--
ALTER TABLE `puesto`
  ADD PRIMARY KEY (`Id_Puesto`);

--
-- Indices de la tabla `venta`
--
ALTER TABLE `venta`
  ADD PRIMARY KEY (`Folio`),
  ADD KEY `Id_Empleado` (`Id_Empleado`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `arqueo`
--
ALTER TABLE `arqueo`
  MODIFY `Id_Arqueo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `clientes`
--
ALTER TABLE `clientes`
  MODIFY `ID_cliente` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT de la tabla `compra`
--
ALTER TABLE `compra`
  MODIFY `ID_Compra` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=46;

--
-- AUTO_INCREMENT de la tabla `corte_caja`
--
ALTER TABLE `corte_caja`
  MODIFY `Id_Corte` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `detalle_compra`
--
ALTER TABLE `detalle_compra`
  MODIFY `Id_Detalle` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=44;

--
-- AUTO_INCREMENT de la tabla `detalle_venta`
--
ALTER TABLE `detalle_venta`
  MODIFY `Id_Detalle` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=60;

--
-- AUTO_INCREMENT de la tabla `empleado`
--
ALTER TABLE `empleado`
  MODIFY `Id_Empleado` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=44;

--
-- AUTO_INCREMENT de la tabla `factura`
--
ALTER TABLE `factura`
  MODIFY `ID_Factura` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `inventario`
--
ALTER TABLE `inventario`
  MODIFY `id_producto` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT de la tabla `movimiento_inventario`
--
ALTER TABLE `movimiento_inventario`
  MODIFY `Id_movimiento` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `proveedores`
--
ALTER TABLE `proveedores`
  MODIFY `ID_Proveedor` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT de la tabla `puesto`
--
ALTER TABLE `puesto`
  MODIFY `Id_Puesto` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `venta`
--
ALTER TABLE `venta`
  MODIFY `Folio` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=39;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `arqueo`
--
ALTER TABLE `arqueo`
  ADD CONSTRAINT `arqueo_ibfk_1` FOREIGN KEY (`IdEmpleado`) REFERENCES `empleado` (`Id_Empleado`) ON DELETE CASCADE;

--
-- Filtros para la tabla `compra`
--
ALTER TABLE `compra`
  ADD CONSTRAINT `compra_ibfk_1` FOREIGN KEY (`Id_proveedor`) REFERENCES `proveedores` (`ID_Proveedor`) ON DELETE CASCADE;

--
-- Filtros para la tabla `corte_caja`
--
ALTER TABLE `corte_caja`
  ADD CONSTRAINT `corte_caja_ibfk_1` FOREIGN KEY (`Id_Empleado`) REFERENCES `empleado` (`Id_Empleado`) ON DELETE CASCADE;

--
-- Filtros para la tabla `detalle_compra`
--
ALTER TABLE `detalle_compra`
  ADD CONSTRAINT `detalle_compra_ibfk_1` FOREIGN KEY (`Id_compra`) REFERENCES `compra` (`ID_Compra`) ON DELETE CASCADE,
  ADD CONSTRAINT `detalle_compra_ibfk_2` FOREIGN KEY (`Id_producto`) REFERENCES `inventario` (`id_producto`) ON DELETE CASCADE;

--
-- Filtros para la tabla `detalle_venta`
--
ALTER TABLE `detalle_venta`
  ADD CONSTRAINT `detalle_venta_ibfk_1` FOREIGN KEY (`Folio_venta`) REFERENCES `venta` (`Folio`) ON DELETE CASCADE,
  ADD CONSTRAINT `detalle_venta_ibfk_2` FOREIGN KEY (`Id_producto`) REFERENCES `inventario` (`id_producto`) ON DELETE CASCADE;

--
-- Filtros para la tabla `empleado`
--
ALTER TABLE `empleado`
  ADD CONSTRAINT `fk_puesto` FOREIGN KEY (`Id_Puesto`) REFERENCES `puesto` (`Id_Puesto`);

--
-- Filtros para la tabla `factura`
--
ALTER TABLE `factura`
  ADD CONSTRAINT `factura_ibfk_1` FOREIGN KEY (`Folio_venta`) REFERENCES `venta` (`Folio`) ON DELETE CASCADE,
  ADD CONSTRAINT `factura_ibfk_2` FOREIGN KEY (`Rfc_cliente`) REFERENCES `clientes` (`Rfc`);

--
-- Filtros para la tabla `inventario`
--
ALTER TABLE `inventario`
  ADD CONSTRAINT `inventario_ibfk_1` FOREIGN KEY (`Id_proveedor`) REFERENCES `proveedores` (`ID_Proveedor`) ON DELETE CASCADE;

--
-- Filtros para la tabla `movimiento_inventario`
--
ALTER TABLE `movimiento_inventario`
  ADD CONSTRAINT `movimiento_inventario_ibfk_1` FOREIGN KEY (`Id_producto`) REFERENCES `inventario` (`id_producto`) ON DELETE CASCADE;

--
-- Filtros para la tabla `venta`
--
ALTER TABLE `venta`
  ADD CONSTRAINT `venta_ibfk_1` FOREIGN KEY (`Id_Empleado`) REFERENCES `empleado` (`Id_Empleado`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
