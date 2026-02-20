-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 20-02-2026 a las 01:04:56
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
-- Base de datos: `serviplus`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cargos`
--

CREATE TABLE `cargos` (
  `IDcargo` int(11) NOT NULL,
  `nombreCargo` varchar(70) NOT NULL,
  `estadoCargo` varchar(75) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `cargos`
--

INSERT INTO `cargos` (`IDcargo`, `nombreCargo`, `estadoCargo`) VALUES
(1, 'Tecnico', 'Activo'),
(2, 'Administrador', 'Inactivo'),
(3, 'Operario', 'Activo'),
(4, 'Asistente', 'Activo'),
(5, 'Desarrollo', 'Activo');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `departamentos`
--

CREATE TABLE `departamentos` (
  `IDdepartamento` int(11) NOT NULL,
  `nombreDepartamento` varchar(75) NOT NULL,
  `estadoDepartamento` varchar(75) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `departamentos`
--

INSERT INTO `departamentos` (`IDdepartamento`, `nombreDepartamento`, `estadoDepartamento`) VALUES
(1, 'Electricidad', 'Activo'),
(2, 'Mantenimiento', 'Activo'),
(3, 'Recursos humanos', 'Activo'),
(4, 'Contabilidad', 'Activo'),
(5, 'Sistemas', 'Activo'),
(8, 'Desarrollo web', 'Activo');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `empleados`
--

CREATE TABLE `empleados` (
  `IDempleado` int(11) NOT NULL,
  `nombre` varchar(70) NOT NULL,
  `numDocumento` int(11) NOT NULL,
  `cargo_id` int(11) NOT NULL,
  `departamento_id` int(11) NOT NULL,
  `fechaIngreso` date NOT NULL,
  `salarioBase` decimal(10,2) NOT NULL,
  `estado` varchar(45) NOT NULL,
  `correoElectronico` varchar(100) NOT NULL,
  `telefono` varchar(45) NOT NULL,
  `imagen` varchar(255) NOT NULL,
  `password` varchar(150) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `empleados`
--

INSERT INTO `empleados` (`IDempleado`, `nombre`, `numDocumento`, `cargo_id`, `departamento_id`, `fechaIngreso`, `salarioBase`, `estado`, `correoElectronico`, `telefono`, `imagen`, `password`) VALUES
(189, 'Cesar', 123, 3, 1, '2026-02-04', 123.00, 'Activo', 'cesar@gmail.com', '123', 'assets/fotos/imagen_20260219_235457000.jpg', '$2y$10$.fk9CJmSKj7yh85Ye7DgVufvW41GxG3HMm9EWcDZ3l8p9F9KzwBs6'),
(190, 'Cesar Rodas', 1192780277, 2, 8, '2026-02-02', 2000000.00, 'Activo', 'cesarrodas113@gmail.com', '3165728348', '', '$2y$10$.fk9CJmSKj7yh85Ye7DgVufvW41GxG3HMm9EWcDZ3l8p9F9KzwBs6');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `cargos`
--
ALTER TABLE `cargos`
  ADD PRIMARY KEY (`IDcargo`);

--
-- Indices de la tabla `departamentos`
--
ALTER TABLE `departamentos`
  ADD PRIMARY KEY (`IDdepartamento`);

--
-- Indices de la tabla `empleados`
--
ALTER TABLE `empleados`
  ADD PRIMARY KEY (`IDempleado`),
  ADD KEY `fk_cargo` (`cargo_id`),
  ADD KEY `fk_departamento` (`departamento_id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `cargos`
--
ALTER TABLE `cargos`
  MODIFY `IDcargo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT de la tabla `departamentos`
--
ALTER TABLE `departamentos`
  MODIFY `IDdepartamento` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT de la tabla `empleados`
--
ALTER TABLE `empleados`
  MODIFY `IDempleado` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=191;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `empleados`
--
ALTER TABLE `empleados`
  ADD CONSTRAINT `empleados_ibfk_1` FOREIGN KEY (`cargo_id`) REFERENCES `cargos` (`IDcargo`),
  ADD CONSTRAINT `empleados_ibfk_2` FOREIGN KEY (`departamento_id`) REFERENCES `departamentos` (`IDdepartamento`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
