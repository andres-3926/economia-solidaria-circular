-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1:3306
-- Tiempo de generación: 12-11-2025 a las 20:16:37
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
-- Base de datos: `reciclandojuntas_db`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `acuerdos_trueque`
--

CREATE TABLE `acuerdos_trueque` (
  `id` int(11) NOT NULL,
  `trueque_id` int(11) NOT NULL,
  `usuario_a_id` int(11) NOT NULL,
  `usuario_b_id` int(11) NOT NULL,
  `fecha_acuerdo` datetime DEFAULT current_timestamp(),
  `detalles` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `comunidades`
--

CREATE TABLE `comunidades` (
  `id` int(11) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `tipo` enum('barrio','oficio','interés') DEFAULT NULL,
  `descripcion` text DEFAULT NULL,
  `creador_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `imagenes_emprendimiento`
--

CREATE TABLE `imagenes_emprendimiento` (
  `id` int(11) NOT NULL,
  `usuario_id` int(11) DEFAULT NULL,
  `ruta_imagen` varchar(255) DEFAULT NULL,
  `fecha_subida` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `imagenes_emprendimiento`
--

INSERT INTO `imagenes_emprendimiento` (`id`, `usuario_id`, `ruta_imagen`, `fecha_subida`) VALUES
(10, 48, 'uploads/productos/68d31b30c5ced_felices.webp', '2025-09-23 17:12:00'),
(11, 48, 'uploads/productos/68d31b30c788f_herta3.jpg', '2025-09-23 17:12:00'),
(12, 48, 'uploads/productos/68d31b30c9603_herta5.jpg', '2025-09-23 17:12:00'),
(13, 48, 'uploads/productos/68d31b30cabc7_herta6.jpg', '2025-09-23 17:12:00'),
(14, 49, 'uploads/productos/68d31cec7b6cd_team-3.jpg', '2025-09-23 17:19:24'),
(15, 49, 'uploads/productos/68d31cec7c18f_team-4.jpg', '2025-09-23 17:19:24');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `imagenes_trueque`
--

CREATE TABLE `imagenes_trueque` (
  `id` int(11) NOT NULL,
  `trueque_id` int(11) NOT NULL,
  `ruta_imagen` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `imagenes_trueque`
--

INSERT INTO `imagenes_trueque` (`id`, `trueque_id`, `ruta_imagen`) VALUES
(12, 19, 'uploads/trueques/68d36d114dd09_Bicicleta.webp'),
(16, 21, 'uploads/trueques/68d3ea168a930_retazos de tela.webp'),
(17, 21, 'uploads/trueques/68d3ea168b42a_retazos tela2.webp'),
(18, 21, 'uploads/trueques/68d3ea168bed2_retazos tela3.webp');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `interacciones_trueque`
--

CREATE TABLE `interacciones_trueque` (
  `id` int(11) NOT NULL,
  `trueque_id` int(11) NOT NULL,
  `interesado_id` int(11) NOT NULL,
  `mensaje` text DEFAULT NULL,
  `fecha_interaccion` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `intercambios_usuario`
--

CREATE TABLE `intercambios_usuario` (
  `id` int(11) NOT NULL,
  `usuario_id` int(11) NOT NULL,
  `descripcion` text DEFAULT NULL,
  `tipo` enum('trueque','colaboración','donación') DEFAULT NULL,
  `fecha` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `mensajes_trueque`
--

CREATE TABLE `mensajes_trueque` (
  `id` int(11) NOT NULL,
  `trueque_id` int(11) NOT NULL,
  `de_usuario_id` int(11) NOT NULL,
  `para_usuario_id` int(11) NOT NULL,
  `mensaje` text NOT NULL,
  `fecha_envio` datetime DEFAULT current_timestamp(),
  `respuesta_a_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `mensajes_trueque`
--

INSERT INTO `mensajes_trueque` (`id`, `trueque_id`, `de_usuario_id`, `para_usuario_id`, `mensaje`, `fecha_envio`, `respuesta_a_id`) VALUES
(1, 21, 48, 49, 'Hola buena noche, me interesan los bultos de retazos.', '2025-09-30 21:13:52', NULL),
(2, 21, 49, 48, 'Hola Diana, claro que si quieres déjame tu numero de contacto', '2025-09-30 21:14:45', NULL),
(3, 21, 50, 49, 'Hola Buena noche', '2025-09-30 21:20:49', NULL),
(4, 21, 49, 50, 'hola buenas noches', '2025-09-30 22:25:00', 3),
(5, 21, 49, 48, 'aun te interesan', '2025-09-30 22:25:25', 1),
(6, 21, 48, 49, 'si claro', '2025-09-30 22:26:15', NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `miembros_comunidad`
--

CREATE TABLE `miembros_comunidad` (
  `usuario_id` int(11) NOT NULL,
  `comunidad_id` int(11) NOT NULL,
  `rol_en_comunidad` enum('miembro','moderador') DEFAULT 'miembro'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `notificaciones`
--

CREATE TABLE `notificaciones` (
  `id` int(11) NOT NULL,
  `usuario_id` int(11) DEFAULT NULL,
  `mensaje` varchar(255) DEFAULT NULL,
  `leida` tinyint(1) DEFAULT 0,
  `fecha` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `notificaciones`
--

INSERT INTO `notificaciones` (`id`, `usuario_id`, `mensaje`, `leida`, `fecha`) VALUES
(1, 43, 'El usuario Diana Giraldo Arias está esperando habilitación como emprendedor.', 1, '2025-09-17 08:56:17'),
(2, 40, 'El usuario Andres Echeverri Giraldo está esperando habilitación como emprendedor.', 0, '2025-09-17 08:56:56'),
(3, 44, 'El usuario Diana Giraldo Arias está esperando habilitación como emprendedor.', 1, '2025-09-17 09:43:35'),
(4, 45, 'El usuario Diana Giraldo Arias está esperando habilitación como emprendedor.', 1, '2025-09-17 09:57:51'),
(5, 45, 'El usuario Diana Giraldo Arias está esperando habilitación como emprendedor.', 1, '2025-09-17 10:15:50'),
(6, 46, 'El usuario Diana Giraldo Arias está esperando habilitación como emprendedor.', 1, '2025-09-23 04:43:11'),
(7, 47, 'El usuario Diana Giraldo Arias está esperando habilitación como emprendedor.', 1, '2025-09-23 14:23:05'),
(8, 47, 'El usuario Diana Giraldo Arias está esperando habilitación como emprendedor.', 0, '2025-09-23 14:42:03'),
(9, 48, 'El usuario Diana Giraldo Arias está esperando habilitación como emprendedor.', 1, '2025-09-23 14:44:37'),
(10, 49, 'El usuario Claudia Marcela Lince Salazar está esperando habilitación como emprendedor.', 1, '2025-09-23 17:15:20'),
(11, 48, 'El usuario Diana Giraldo Arias está esperando habilitación como emprendedor.', 1, '2025-09-23 22:41:47'),
(12, 49, 'El usuario Claudia Marcela Lince Salazar está esperando habilitación como emprendedor.', 1, '2025-09-24 06:53:15'),
(13, 49, 'El usuario Claudia Marcela Lince Salazar está esperando habilitación como emprendedor.', 1, '2025-09-28 10:36:52'),
(14, 48, 'El usuario Diana Giraldo Arias está esperando habilitación como emprendedor.', 1, '2025-09-28 11:44:57'),
(15, 48, 'El usuario Diana Giraldo Arias está esperando habilitación como emprendedor.', 1, '2025-09-29 14:10:16'),
(16, 49, 'El usuario Claudia Marcela Lince Salazar está esperando habilitación como emprendedor.', 1, '2025-09-30 19:17:44'),
(17, 48, 'El usuario Diana Giraldo Arias está esperando habilitación como emprendedor.', 1, '2025-09-30 21:13:23'),
(18, 50, 'El usuario Carlos Arturo Sanchez Ortegón está esperando habilitación como emprendedor.', 1, '2025-09-30 21:20:27'),
(19, 48, 'El usuario Diana Giraldo Arias está esperando habilitación como emprendedor.', 1, '2025-10-09 14:13:19'),
(20, 48, 'El usuario Diana Giraldo Arias está esperando habilitación como emprendedor.', 0, '2025-10-09 16:53:47'),
(21, 51, 'El usuario Diana Giraldo Arias está esperando habilitación como emprendedor.', 1, '2025-10-10 15:39:57'),
(22, 51, 'El usuario Diana Giraldo Arias está esperando habilitación como emprendedor.', 1, '2025-10-10 16:05:22'),
(23, 51, 'El usuario Diana Giraldo Arias está esperando habilitación como emprendedor.', 1, '2025-10-13 19:00:55'),
(24, 51, 'El usuario Diana Giraldo Arias está esperando habilitación como emprendedor.', 1, '2025-10-15 14:03:00'),
(25, 51, 'El usuario Diana Giraldo Arias está esperando habilitación como emprendedor.', 1, '2025-10-16 20:10:57'),
(26, 51, 'El usuario Diana Giraldo Arias está esperando habilitación como emprendedor.', 1, '2025-11-04 21:33:13'),
(27, 51, 'El usuario Diana Giraldo Arias está esperando habilitación como emprendedor.', 0, '2025-11-10 15:56:22');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `participacion_comunidad`
--

CREATE TABLE `participacion_comunidad` (
  `id` int(11) NOT NULL,
  `usuario_id` int(11) NOT NULL,
  `comunidad_id` int(11) NOT NULL,
  `rol` enum('participante','facilitador','coordinador') DEFAULT NULL,
  `fecha_union` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `preguntas_trueques`
--

CREATE TABLE `preguntas_trueques` (
  `id` int(11) NOT NULL,
  `trueque_id` int(11) NOT NULL,
  `usuario_id` int(11) NOT NULL,
  `pregunta` text NOT NULL,
  `respuesta` text DEFAULT NULL,
  `fecha_pregunta` datetime DEFAULT current_timestamp(),
  `fecha_respuesta` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `preguntas_trueques`
--

INSERT INTO `preguntas_trueques` (`id`, `trueque_id`, `usuario_id`, `pregunta`, `respuesta`, `fecha_pregunta`, `fecha_respuesta`) VALUES
(1, 19, 49, 'me interesa la bicicleta', 'claro con mucho gusto aún la tengo disponible, si quieres me puedes contactar y coordinamos!', '2025-09-28 12:52:43', '2025-09-28 12:53:50'),
(2, 21, 48, 'hola, me interesan los retazos', 'claro con mucho gusto, si quieres me puedes contactar cuando quieras.', '2025-09-28 12:55:18', '2025-09-28 12:55:57');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `reconocimientos_usuario`
--

CREATE TABLE `reconocimientos_usuario` (
  `id` int(11) NOT NULL,
  `usuario_id` int(11) NOT NULL,
  `titulo` varchar(100) DEFAULT NULL,
  `descripcion` text DEFAULT NULL,
  `otorgado_por` int(11) DEFAULT NULL,
  `fecha` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `saberes_usuario`
--

CREATE TABLE `saberes_usuario` (
  `id` int(11) NOT NULL,
  `usuario_id` int(11) NOT NULL,
  `titulo` varchar(100) DEFAULT NULL,
  `descripcion` text DEFAULT NULL,
  `tipo` enum('oficio','experiencia','teoría') DEFAULT NULL,
  `fecha_registro` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `trueques`
--

CREATE TABLE `trueques` (
  `id` int(11) NOT NULL,
  `numero_documento` varchar(50) NOT NULL,
  `que_ofreces` varchar(255) NOT NULL,
  `que_necesitas` varchar(255) NOT NULL,
  `descripcion` text NOT NULL,
  `barrio` varchar(100) DEFAULT NULL,
  `etiquetas` varchar(255) DEFAULT NULL,
  `estado` varchar(50) DEFAULT 'activo',
  `fecha_publicacion` datetime DEFAULT NULL,
  `categoria` varchar(50) DEFAULT NULL,
  `subcategoria` varchar(100) DEFAULT NULL,
  `fecha_expiracion` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `trueques`
--

INSERT INTO `trueques` (`id`, `numero_documento`, `que_ofreces`, `que_necesitas`, `descripcion`, `barrio`, `etiquetas`, `estado`, `fecha_publicacion`, `categoria`, `subcategoria`, `fecha_expiracion`) VALUES
(19, '30291824', 'Una bicicleta para regalar', 'Abono', 'Tengo una bicicleta en buen estado para regalar.', 'la maria', NULL, 'cancelado', '2025-09-24 06:01:21', 'Varios', 'Donaciones', '2025-10-18'),
(21, '1053787426', 'Tengo retazos de tela para regalar', 'Ropa usada', 'Tengo 2 bultos de retazos de tela para regalar', 'Siloe', NULL, 'activo', '2025-09-24 14:54:46', 'Mis Residuos', 'Reciclables (papel, cartón, plásticos, metales, vidrio, etc)', '2025-10-15');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `id` int(11) NOT NULL,
  `numero_documento` varchar(20) NOT NULL,
  `tipo_documento` enum('CC','CE','PPT') NOT NULL,
  `nombre_completo` varchar(100) NOT NULL,
  `celular` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_croatian_ci NOT NULL,
  `correo` varchar(100) DEFAULT NULL,
  `contrasena` varchar(255) NOT NULL,
  `comuna` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_croatian_ci NOT NULL,
  `barrio` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_croatian_ci NOT NULL,
  `direccion` varchar(255) DEFAULT NULL,
  `emprendimiento` varchar(100) NOT NULL,
  `habilitado` tinyint(1) DEFAULT 0,
  `foto` varchar(255) DEFAULT NULL,
  `rol` varchar(50) DEFAULT 'usuario',
  `fecha_registro` datetime DEFAULT current_timestamp(),
  `instagram` varchar(255) DEFAULT NULL,
  `facebook` varchar(255) DEFAULT NULL,
  `resena` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id`, `numero_documento`, `tipo_documento`, `nombre_completo`, `celular`, `correo`, `contrasena`, `comuna`, `barrio`, `direccion`, `emprendimiento`, `habilitado`, `foto`, `rol`, `fecha_registro`, `instagram`, `facebook`, `resena`) VALUES
(40, '16071402', 'CC', 'Andres Echeverri Giraldo', '3113079637', 'aecheverrig20@hotmail.com', '$2y$10$S8F8xy4PKj9bg.Cld0eCfut/fTohcl8Qmj.1KEz5lHm7fMGoKTQsm', '20', 'Siloe', 'Carrera 8 # 57E 2-03', 'Instructor', 1, '16071402_1757978022.jpg', 'administrador', '2025-09-15 16:40:33', NULL, NULL, NULL),
(51, '30291824', 'CC', 'Diana Giraldo Arias', '3147748010', 'monafeliz57@hotmail.com', '$2y$10$vC3zbiIfqqph8zUcs2o0E.cCe3JkvCr/YiKnCA95GGiQxlR.h5tpm', '22', 'Siloe', 'Carrera 8 #57E2-03', 'Artesanias Diana', 0, '30291824_1760554992.jpg', 'emprendedor', '2025-10-10 15:39:46', NULL, NULL, 'hola yo soy diana'),
(52, '1053787426', 'CC', 'Claudia Marcela Lince Salazar', '3217108776', 'lince627@hotmail.com', '$2y$10$3.jHvbdlhyEKhzM4GkL5eOINE4g7EV8a/4zJCpSIOR07PRmTL75rC', '20', 'Siloe', 'carrera 29 # 15-45', 'Ropero Claudia', 0, NULL, 'emprendedor', '2025-10-15 16:59:16', NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `valoraciones_trueque`
--

CREATE TABLE `valoraciones_trueque` (
  `id` int(11) NOT NULL,
  `acuerdo_id` int(11) NOT NULL,
  `evaluador_id` int(11) NOT NULL,
  `evaluado_id` int(11) NOT NULL,
  `puntuacion` int(11) DEFAULT NULL CHECK (`puntuacion` between 1 and 5),
  `comentario` text DEFAULT NULL,
  `fecha_valoracion` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `visitas_trueques`
--

CREATE TABLE `visitas_trueques` (
  `id` int(11) NOT NULL,
  `trueque_id` int(11) NOT NULL,
  `usuario_id` int(11) NOT NULL,
  `fecha_vista` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `visitas_trueques`
--

INSERT INTO `visitas_trueques` (`id`, `trueque_id`, `usuario_id`, `fecha_vista`) VALUES
(1, 19, 49, '2025-09-28 12:45:05'),
(2, 21, 48, '2025-09-28 12:53:09'),
(3, 21, 40, '2025-09-29 13:50:15'),
(4, 21, 50, '2025-09-30 21:20:34');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `acuerdos_trueque`
--
ALTER TABLE `acuerdos_trueque`
  ADD PRIMARY KEY (`id`),
  ADD KEY `trueque_id` (`trueque_id`),
  ADD KEY `usuario_a_id` (`usuario_a_id`),
  ADD KEY `usuario_b_id` (`usuario_b_id`);

--
-- Indices de la tabla `comunidades`
--
ALTER TABLE `comunidades`
  ADD PRIMARY KEY (`id`),
  ADD KEY `creador_id` (`creador_id`);

--
-- Indices de la tabla `imagenes_emprendimiento`
--
ALTER TABLE `imagenes_emprendimiento`
  ADD PRIMARY KEY (`id`),
  ADD KEY `usuario_id` (`usuario_id`);

--
-- Indices de la tabla `imagenes_trueque`
--
ALTER TABLE `imagenes_trueque`
  ADD PRIMARY KEY (`id`),
  ADD KEY `trueque_id` (`trueque_id`);

--
-- Indices de la tabla `interacciones_trueque`
--
ALTER TABLE `interacciones_trueque`
  ADD PRIMARY KEY (`id`),
  ADD KEY `trueque_id` (`trueque_id`),
  ADD KEY `interesado_id` (`interesado_id`);

--
-- Indices de la tabla `intercambios_usuario`
--
ALTER TABLE `intercambios_usuario`
  ADD PRIMARY KEY (`id`),
  ADD KEY `usuario_id` (`usuario_id`);

--
-- Indices de la tabla `mensajes_trueque`
--
ALTER TABLE `mensajes_trueque`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `miembros_comunidad`
--
ALTER TABLE `miembros_comunidad`
  ADD PRIMARY KEY (`usuario_id`,`comunidad_id`),
  ADD KEY `comunidad_id` (`comunidad_id`);

--
-- Indices de la tabla `notificaciones`
--
ALTER TABLE `notificaciones`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `participacion_comunidad`
--
ALTER TABLE `participacion_comunidad`
  ADD PRIMARY KEY (`id`),
  ADD KEY `usuario_id` (`usuario_id`),
  ADD KEY `comunidad_id` (`comunidad_id`);

--
-- Indices de la tabla `preguntas_trueques`
--
ALTER TABLE `preguntas_trueques`
  ADD PRIMARY KEY (`id`),
  ADD KEY `trueque_id` (`trueque_id`),
  ADD KEY `usuario_id` (`usuario_id`);

--
-- Indices de la tabla `reconocimientos_usuario`
--
ALTER TABLE `reconocimientos_usuario`
  ADD PRIMARY KEY (`id`),
  ADD KEY `usuario_id` (`usuario_id`),
  ADD KEY `otorgado_por` (`otorgado_por`);

--
-- Indices de la tabla `saberes_usuario`
--
ALTER TABLE `saberes_usuario`
  ADD PRIMARY KEY (`id`),
  ADD KEY `usuario_id` (`usuario_id`);

--
-- Indices de la tabla `trueques`
--
ALTER TABLE `trueques`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `documento` (`numero_documento`),
  ADD UNIQUE KEY `correo` (`correo`);

--
-- Indices de la tabla `valoraciones_trueque`
--
ALTER TABLE `valoraciones_trueque`
  ADD PRIMARY KEY (`id`),
  ADD KEY `acuerdo_id` (`acuerdo_id`),
  ADD KEY `evaluador_id` (`evaluador_id`),
  ADD KEY `evaluado_id` (`evaluado_id`);

--
-- Indices de la tabla `visitas_trueques`
--
ALTER TABLE `visitas_trueques`
  ADD PRIMARY KEY (`id`),
  ADD KEY `trueque_id` (`trueque_id`),
  ADD KEY `usuario_id` (`usuario_id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `acuerdos_trueque`
--
ALTER TABLE `acuerdos_trueque`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `comunidades`
--
ALTER TABLE `comunidades`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `imagenes_emprendimiento`
--
ALTER TABLE `imagenes_emprendimiento`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT de la tabla `imagenes_trueque`
--
ALTER TABLE `imagenes_trueque`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT de la tabla `interacciones_trueque`
--
ALTER TABLE `interacciones_trueque`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `intercambios_usuario`
--
ALTER TABLE `intercambios_usuario`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `mensajes_trueque`
--
ALTER TABLE `mensajes_trueque`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `notificaciones`
--
ALTER TABLE `notificaciones`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT de la tabla `participacion_comunidad`
--
ALTER TABLE `participacion_comunidad`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `preguntas_trueques`
--
ALTER TABLE `preguntas_trueques`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `reconocimientos_usuario`
--
ALTER TABLE `reconocimientos_usuario`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `saberes_usuario`
--
ALTER TABLE `saberes_usuario`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `trueques`
--
ALTER TABLE `trueques`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=53;

--
-- AUTO_INCREMENT de la tabla `valoraciones_trueque`
--
ALTER TABLE `valoraciones_trueque`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `visitas_trueques`
--
ALTER TABLE `visitas_trueques`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `acuerdos_trueque`
--
ALTER TABLE `acuerdos_trueque`
  ADD CONSTRAINT `acuerdos_trueque_ibfk_1` FOREIGN KEY (`trueque_id`) REFERENCES `trueques` (`id`),
  ADD CONSTRAINT `acuerdos_trueque_ibfk_2` FOREIGN KEY (`usuario_a_id`) REFERENCES `usuarios` (`id`),
  ADD CONSTRAINT `acuerdos_trueque_ibfk_3` FOREIGN KEY (`usuario_b_id`) REFERENCES `usuarios` (`id`);

--
-- Filtros para la tabla `comunidades`
--
ALTER TABLE `comunidades`
  ADD CONSTRAINT `comunidades_ibfk_1` FOREIGN KEY (`creador_id`) REFERENCES `usuarios` (`id`);

--
-- Filtros para la tabla `imagenes_emprendimiento`
--
ALTER TABLE `imagenes_emprendimiento`
  ADD CONSTRAINT `imagenes_emprendimiento_ibfk_1` FOREIGN KEY (`usuario_id`) REFERENCES `usuarios` (`id`);

--
-- Filtros para la tabla `imagenes_trueque`
--
ALTER TABLE `imagenes_trueque`
  ADD CONSTRAINT `imagenes_trueque_ibfk_1` FOREIGN KEY (`trueque_id`) REFERENCES `trueques` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `interacciones_trueque`
--
ALTER TABLE `interacciones_trueque`
  ADD CONSTRAINT `interacciones_trueque_ibfk_1` FOREIGN KEY (`trueque_id`) REFERENCES `trueques` (`id`),
  ADD CONSTRAINT `interacciones_trueque_ibfk_2` FOREIGN KEY (`interesado_id`) REFERENCES `usuarios` (`id`);

--
-- Filtros para la tabla `intercambios_usuario`
--
ALTER TABLE `intercambios_usuario`
  ADD CONSTRAINT `intercambios_usuario_ibfk_1` FOREIGN KEY (`usuario_id`) REFERENCES `usuarios` (`id`);

--
-- Filtros para la tabla `miembros_comunidad`
--
ALTER TABLE `miembros_comunidad`
  ADD CONSTRAINT `miembros_comunidad_ibfk_1` FOREIGN KEY (`usuario_id`) REFERENCES `usuarios` (`id`),
  ADD CONSTRAINT `miembros_comunidad_ibfk_2` FOREIGN KEY (`comunidad_id`) REFERENCES `comunidades` (`id`);

--
-- Filtros para la tabla `participacion_comunidad`
--
ALTER TABLE `participacion_comunidad`
  ADD CONSTRAINT `participacion_comunidad_ibfk_1` FOREIGN KEY (`usuario_id`) REFERENCES `usuarios` (`id`),
  ADD CONSTRAINT `participacion_comunidad_ibfk_2` FOREIGN KEY (`comunidad_id`) REFERENCES `comunidades` (`id`);

--
-- Filtros para la tabla `preguntas_trueques`
--
ALTER TABLE `preguntas_trueques`
  ADD CONSTRAINT `preguntas_trueques_ibfk_1` FOREIGN KEY (`trueque_id`) REFERENCES `trueques` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `preguntas_trueques_ibfk_2` FOREIGN KEY (`usuario_id`) REFERENCES `usuarios` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `reconocimientos_usuario`
--
ALTER TABLE `reconocimientos_usuario`
  ADD CONSTRAINT `reconocimientos_usuario_ibfk_1` FOREIGN KEY (`usuario_id`) REFERENCES `usuarios` (`id`),
  ADD CONSTRAINT `reconocimientos_usuario_ibfk_2` FOREIGN KEY (`otorgado_por`) REFERENCES `usuarios` (`id`);

--
-- Filtros para la tabla `saberes_usuario`
--
ALTER TABLE `saberes_usuario`
  ADD CONSTRAINT `saberes_usuario_ibfk_1` FOREIGN KEY (`usuario_id`) REFERENCES `usuarios` (`id`);

--
-- Filtros para la tabla `valoraciones_trueque`
--
ALTER TABLE `valoraciones_trueque`
  ADD CONSTRAINT `valoraciones_trueque_ibfk_1` FOREIGN KEY (`acuerdo_id`) REFERENCES `acuerdos_trueque` (`id`),
  ADD CONSTRAINT `valoraciones_trueque_ibfk_2` FOREIGN KEY (`evaluador_id`) REFERENCES `usuarios` (`id`),
  ADD CONSTRAINT `valoraciones_trueque_ibfk_3` FOREIGN KEY (`evaluado_id`) REFERENCES `usuarios` (`id`);

--
-- Filtros para la tabla `visitas_trueques`
--
ALTER TABLE `visitas_trueques`
  ADD CONSTRAINT `visitas_trueques_ibfk_1` FOREIGN KEY (`trueque_id`) REFERENCES `trueques` (`id`),
  ADD CONSTRAINT `visitas_trueques_ibfk_2` FOREIGN KEY (`usuario_id`) REFERENCES `usuarios` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
