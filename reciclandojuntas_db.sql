-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 24-11-2025 a las 14:42:47
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
(2, 40, 'El usuario Andres Echeverri Giraldo está esperando habilitación como emprendedor.', 1, '2025-09-17 08:56:56'),
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
(27, 51, 'El usuario Diana Giraldo Arias está esperando habilitación como emprendedor.', 1, '2025-11-10 15:56:22'),
(28, 51, 'El usuario Diana Giraldo Arias está esperando habilitación como emprendedor.', 1, '2025-11-23 07:33:44'),
(29, 51, 'El usuario Diana Giraldo Arias está esperando habilitación como emprendedor.', 1, '2025-11-23 19:06:58'),
(30, 51, 'El usuario Diana Giraldo Arias está esperando habilitación como emprendedor.', 1, '2025-11-24 06:07:58'),
(31, 53, 'El usuario Jose Arnulfo Reyes está esperando habilitación como emprendedor.', 0, '2025-11-24 07:59:53');

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
-- Estructura de tabla para la tabla `resultados_quiz`
--

CREATE TABLE `resultados_quiz` (
  `id` int(11) NOT NULL,
  `numero_documento` varchar(20) NOT NULL,
  `titulo_quiz` varchar(255) NOT NULL,
  `tipo_quiz` varchar(50) NOT NULL,
  `datos_respuestas` text NOT NULL,
  `fecha_completado` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `resultados_quiz`
--

INSERT INTO `resultados_quiz` (`id`, `numero_documento`, `titulo_quiz`, `tipo_quiz`, `datos_respuestas`, `fecha_completado`) VALUES
(1, '30291824', 'Reto del Tema: ¿Dónde lo pongo?', 'actividad_quiz', '{\"respuestas\":{\"pregunta_1\":{\"respuesta_usuario\":\"Org\\u00e1nicos\",\"es_correcta\":false},\"pregunta_2\":{\"respuesta_usuario\":\"Reciclaje\",\"es_correcta\":false},\"pregunta_3\":{\"respuesta_usuario\":\"Reuso \\/ Artesan\\u00edas\",\"es_correcta\":false}},\"respuestas_correctas\":3,\"total_preguntas\":3,\"porcentaje_acierto\":100,\"tiempo_segundos\":12,\"minimo_requerido\":3,\"aprobado\":\"SI\",\"instrucciones\":\"Ahora que conoces c\\u00f3mo separar tus residuos, te invitamos a practicar. <b>Selecciona la opci\\u00f3n correcta para cada residuo. Necesitas las 3 respuestas correctas para aprobar.<\\/b>\"}', '2025-11-24 04:41:29'),
(2, '30291824', 'Reto del Tema 4: ¡Mi Primer Paso con el Compost!', 'reto_compostaje', '{\"items_seleccionados\":\"1,2,3,4,5,6,7,8\",\"items_texto\":\"\\ud83c\\udf4c                                    \\n                                    \\n                                        C\\u00e1scaras de frutas y\\/o hortalizas | \\u2615                                    \\n                                    \\n                                        Borra de caf\\u00e9 | \\ud83c\\udf5e                                    \\n                                    \\n                                        Cereales y pan | \\ud83e\\udd5a                                    \\n                                    \\n                                        C\\u00e1scaras de huevo | \\ud83d\\udcc4                                    \\n                                    \\n                                        Filtros de papel de t\\u00e9 y caf\\u00e9 | \\ud83c\\udf75                                    \\n                                    \\n                                        Bolsitas de t\\u00e9 | \\ud83c\\udf42                                    \\n                                    \\n                                        Residuos de jard\\u00edn | \\ud83d\\udce6                                    \\n                                    \\n                                        Cart\\u00f3n y papel limpio\",\"total_seleccionados\":8,\"minimo_requerido\":3,\"aprobado\":\"SI\"}', '2025-11-24 04:41:58'),
(3, '30291824', 'Preguntas y Respuestas Comunes', 'quiz_preguntas_respuestas', '{\"respuestas\":[],\"respuestas_correctas\":8,\"total_preguntas\":8,\"porcentaje_acierto\":100,\"tiempo_segundos\":120,\"minimo_requerido\":4,\"aprobado\":\"SI\",\"instrucciones\":\"\"}', '2025-11-24 05:09:40');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `retos_usuarios`
--

CREATE TABLE `retos_usuarios` (
  `id` int(11) NOT NULL,
  `numero_documento` varchar(20) NOT NULL,
  `pagina` int(11) NOT NULL,
  `respuesta_1` varchar(255) DEFAULT NULL,
  `respuesta_2` varchar(255) DEFAULT NULL,
  `respuesta_3` varchar(255) DEFAULT NULL,
  `respuesta_4` varchar(255) DEFAULT NULL,
  `respuesta_5` varchar(255) DEFAULT NULL,
  `respuesta_6` varchar(255) DEFAULT NULL,
  `respuestas_correctas` int(11) NOT NULL DEFAULT 0,
  `total_preguntas` int(11) NOT NULL DEFAULT 6,
  `porcentaje_acierto` decimal(5,2) NOT NULL DEFAULT 0.00,
  `tiempo_segundos` int(11) NOT NULL DEFAULT 0,
  `aprobado` tinyint(1) NOT NULL DEFAULT 0,
  `titulo_quiz` varchar(255) DEFAULT NULL,
  `tipo_quiz` varchar(100) DEFAULT NULL,
  `instrucciones` text DEFAULT NULL,
  `fecha_realizacion` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `retos_usuarios`
--

INSERT INTO `retos_usuarios` (`id`, `numero_documento`, `pagina`, `respuesta_1`, `respuesta_2`, `respuesta_3`, `respuesta_4`, `respuesta_5`, `respuesta_6`, `respuestas_correctas`, `total_preguntas`, `porcentaje_acierto`, `tiempo_segundos`, `aprobado`, `titulo_quiz`, `tipo_quiz`, `instrucciones`, `fecha_realizacion`) VALUES
(1, '30291824', 6, 'Orgánico para compost', 'Orgánico para compost', 'Reutilizable para artesanías', 'Reutilizable para artesanías', 'Reciclable (plástico, vidrio, papel)', '0', 6, 6, 100.00, 47, 1, NULL, NULL, NULL, '2025-11-23 11:47:09'),
(2, '30291824', 12, 'Orgánicos', 'Reciclaje', 'Reuso / Artesanías', '', '', '0', 3, 3, 100.00, 113, 0, NULL, NULL, NULL, '2025-11-23 23:36:32'),
(3, '30291824', 12, 'Orgánicos', 'Reciclaje', 'Reuso / Artesanías', '', '', '0', 3, 3, 100.00, 153, 0, NULL, NULL, NULL, '2025-11-23 23:39:11'),
(4, '30291824', 12, 'Orgánicos', 'Reciclaje', 'Reuso / Artesanías', '', '', '0', 3, 3, 100.00, 209, 0, NULL, NULL, NULL, '2025-11-23 23:43:46'),
(5, '30291824', 12, 'Orgánicos', 'Reciclaje', 'Reuso / Artesanías', '', '', '0', 3, 3, 100.00, 21, 0, NULL, NULL, NULL, '2025-11-24 00:09:23'),
(6, '30291824', 0, 'Orgánicos', 'Reciclaje', 'Reuso / Artesanías', '', '', '0', 3, 3, 100.00, 13, 1, 'Reto del Tema: ¿Dónde lo pongo?', 'actividad_quiz', 'Ahora que conoces cómo separar tus residuos, te invitamos a practicar. <b>Selecciona la opción correcta para cada residuo. Necesitas las 3 respuestas correctas para aprobar.</b>', '2025-11-24 00:26:05'),
(7, '30291824', 0, 'Orgánicos', 'Reciclaje', 'Reuso / Artesanías', '', '', '0', 3, 3, 100.00, 200, 1, 'Reto del Tema: ¿Dónde lo pongo?', 'actividad_quiz', 'Ahora que conoces cómo separar tus residuos, te invitamos a practicar. <b>Selecciona la opción correcta para cada residuo. Necesitas las 3 respuestas correctas para aprobar.</b>', '2025-11-24 00:29:42'),
(8, '30291824', 0, 'Orgánicos', 'Reciclaje', 'Reuso / Artesanías', '', '', '0', 3, 3, 100.00, 14, 1, 'Reto del Tema: ¿Dónde lo pongo?', 'actividad_quiz', 'Ahora que conoces cómo separar tus residuos, te invitamos a practicar. <b>Selecciona la opción correcta para cada residuo. Necesitas las 3 respuestas correctas para aprobar.</b>', '2025-11-24 00:47:07'),
(9, '30291824', 0, 'Orgánicos', 'Reciclaje', 'Reuso / Artesanías', '', '', '0', 3, 3, 100.00, 9, 1, 'Reto del Tema: ¿Dónde lo pongo?', 'actividad_quiz', 'Ahora que conoces cómo separar tus residuos, te invitamos a practicar. <b>Selecciona la opción correcta para cada residuo. Necesitas las 3 respuestas correctas para aprobar.</b>', '2025-11-24 01:26:37');

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
(51, '30291824', 'CC', 'Diana Giraldo Arias', '3147748010', 'monafeliz57@hotmail.com', '$2y$10$vC3zbiIfqqph8zUcs2o0E.cCe3JkvCr/YiKnCA95GGiQxlR.h5tpm', '22', 'Siloe', 'Carrera 8 #57E2-03', 'Artesanias Diana', 0, '30291824_1760554992.jpg', 'emprendedor', '2025-10-10 15:39:46', NULL, NULL, 'hola yo soy diana'),
(53, '14893162', 'CC', 'Jose Arnulfo Reyes', '3013779948', 'josearnulforeyes@gmail.com', '$2y$10$RBg5YUK0MgSaprNHtqblNe490XvPBNym7.JUmFV55ZH/rNFRU7zo.', '1', 'la maria', 'Cali', 'Instructor', 1, NULL, 'administrador', '2025-11-24 07:59:25', NULL, NULL, NULL);

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
-- Indices de la tabla `notificaciones`
--
ALTER TABLE `notificaciones`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `preguntas_trueques`
--
ALTER TABLE `preguntas_trueques`
  ADD PRIMARY KEY (`id`),
  ADD KEY `trueque_id` (`trueque_id`),
  ADD KEY `usuario_id` (`usuario_id`);

--
-- Indices de la tabla `resultados_quiz`
--
ALTER TABLE `resultados_quiz`
  ADD PRIMARY KEY (`id`),
  ADD KEY `numero_documento` (`numero_documento`);

--
-- Indices de la tabla `retos_usuarios`
--
ALTER TABLE `retos_usuarios`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_documento` (`numero_documento`),
  ADD KEY `idx_pagina` (`pagina`),
  ADD KEY `idx_aprobado` (`aprobado`),
  ADD KEY `idx_fecha` (`fecha_realizacion`);

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT de la tabla `preguntas_trueques`
--
ALTER TABLE `preguntas_trueques`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `resultados_quiz`
--
ALTER TABLE `resultados_quiz`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `retos_usuarios`
--
ALTER TABLE `retos_usuarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=54;

--
-- AUTO_INCREMENT de la tabla `visitas_trueques`
--
ALTER TABLE `visitas_trueques`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `imagenes_trueque`
--
ALTER TABLE `imagenes_trueque`
  ADD CONSTRAINT `imagenes_trueque_ibfk_1` FOREIGN KEY (`trueque_id`) REFERENCES `trueques` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `resultados_quiz`
--
ALTER TABLE `resultados_quiz`
  ADD CONSTRAINT `resultados_quiz_ibfk_1` FOREIGN KEY (`numero_documento`) REFERENCES `usuarios` (`numero_documento`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
