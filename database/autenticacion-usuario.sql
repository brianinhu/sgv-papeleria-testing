-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 30-06-2024 a las 02:26:22
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
-- Base de datos: `papeleria`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `privilegio`
--

CREATE TABLE `privilegio` (
  `idprivilegio` int(11) NOT NULL,
  `label` varchar(60) NOT NULL,
  `ruta` varchar(500) NOT NULL,
  `icono` varchar(60) NOT NULL,
  `name` varchar(60) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `privilegio`
--

INSERT INTO `privilegio` (`idprivilegio`, `label`, `ruta`, `icono`, `name`) VALUES
(1, 'Emisión de proforma', '../../moduloVentas/indexEmisionProforma.php', '../../images/emisionProforma.png', 'moduloEmisionProforma'),
(2, 'Emisión de boleta', '', '', ''),
(3, 'Registro de despacho de boleta', '', '', ''),
(4, 'Emisión de ticket de reembolso', '../../moduloVentas/indexEmisionTicketReembolso.php', '../../images/emisionTicket.png', 'moduloEmisionTicketReembolso'),
(5, 'Anulación de ticket de reembolso', '', '', ''),
(6, 'Gestión de inventario', '', '', ''),
(7, 'Generación de reporte de cierre de caja', '', '', '');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `rol`
--

CREATE TABLE `rol` (
  `idrol` int(11) NOT NULL,
  `rol` varchar(60) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `rol`
--

INSERT INTO `rol` (`idrol`, `rol`) VALUES
(1, 'Vendedor'),
(2, 'Cajero'),
(3, 'Despachador');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `rol_privilegio`
--

CREATE TABLE `rol_privilegio` (
  `idrol` int(11) NOT NULL,
  `idprivilegio` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `rol_privilegio`
--

INSERT INTO `rol_privilegio` (`idrol`, `idprivilegio`) VALUES
(1, 1),
(1, 4),
(2, 2),
(2, 5),
(2, 7),
(3, 3),
(3, 6);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuario`
--

CREATE TABLE `usuario` (
  `idusuario` int(11) NOT NULL,
  `usuario` varchar(60) NOT NULL,
  `contraseña` varchar(60) NOT NULL,
  `estado` tinyint(1) NOT NULL DEFAULT 1,
  `idrol` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `usuario`
--

INSERT INTO `usuario` (`idusuario`, `usuario`, `contraseña`, `estado`, `idrol`) VALUES
(1, 'chacalito', 'chacalito2\"', 1, 1),
(2, 'minitacza', 'minitacza3#', 1, 2),
(3, 'rusita', 'rusitarusita1@', 1, 3);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `privilegio`
--
ALTER TABLE `privilegio`
  ADD PRIMARY KEY (`idprivilegio`);

--
-- Indices de la tabla `rol`
--
ALTER TABLE `rol`
  ADD PRIMARY KEY (`idrol`);

--
-- Indices de la tabla `rol_privilegio`
--
ALTER TABLE `rol_privilegio`
  ADD PRIMARY KEY (`idrol`,`idprivilegio`),
  ADD KEY `idprivilegio` (`idprivilegio`);

--
-- Indices de la tabla `usuario`
--
ALTER TABLE `usuario`
  ADD PRIMARY KEY (`idusuario`),
  ADD KEY `idrol` (`idrol`);

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `rol_privilegio`
--
ALTER TABLE `rol_privilegio`
  ADD CONSTRAINT `rol_privilegio_ibfk_1` FOREIGN KEY (`idrol`) REFERENCES `rol` (`idrol`),
  ADD CONSTRAINT `rol_privilegio_ibfk_2` FOREIGN KEY (`idprivilegio`) REFERENCES `privilegio` (`idprivilegio`);

--
-- Filtros para la tabla `usuario`
--
ALTER TABLE `usuario`
  ADD CONSTRAINT `usuario_ibfk_1` FOREIGN KEY (`idrol`) REFERENCES `rol` (`idrol`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
