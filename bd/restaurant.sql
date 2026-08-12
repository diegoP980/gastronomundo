-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 16-12-2025 a las 02:36:28
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
-- Base de datos: `db_gastronomundo`
--
CREATE DATABASE IF NOT EXISTS `db_gastronomundo` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `db_gastronomundo`;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `dishes`
--

CREATE TABLE `dishes` (
  `id` int(11) NOT NULL,
  `name` varchar(50) DEFAULT NULL,
  `descripcion` varchar(100) DEFAULT NULL,
  `price` decimal(10,2) DEFAULT NULL,
  `discount` int(11) DEFAULT NULL,
  `image` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `dishes`
--

INSERT INTO `dishes` (`id`, `name`, `descripcion`, `price`, `discount`, `image`) VALUES
(1, 'Estofado de pollo', 'Pollo guisado con papas, zanahorias y ají panca. Sabor casero que une tradición y hogar.', 35.00, 10, 'img-dish-69015bc75b063.jpg'),
(2, 'Adobo de cerdo', 'Cerdo en chicha de jora y ají panca. Tesoro arequipeño de sabor fuerte y corazón andino.', 40.00, 10, 'img-dish-69015c337aa51.jpg'),
(3, 'Pollo al sillao', 'Pollo salteado con sillao y kión. Fusión criolla oriental que conquista con su sabor único.', 45.00, 20, 'img-dish-69015c9a3c352.jpg'),
(4, 'Ceviche peruano', 'Pescado fresco con limón, ají y cebolla. Orgullo peruano, fresco, picante y lleno de vida.', 50.00, 15, 'img-dish-69015ccbc364a.jpeg'),
(5, 'Seco de res', 'Res tierna al culantro y chicha de jora. Orgullo norteño de aroma intenso y sabor profundo.', 35.00, 20, 'img-dish-69015d0a9cc50.jpg');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `nombre` varchar(30) NOT NULL,
  `apellido` varchar(30) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(200) DEFAULT NULL,
  `photo` varchar(100) DEFAULT NULL,
  `perfil` int(11) NOT NULL,
  `biografia` varchar(300) DEFAULT NULL,
  `ubicacion` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `users`
--

INSERT INTO `users` (`id`, `nombre`, `apellido`, `email`, `password`, `photo`, `perfil`, `biografia`, `ubicacion`) VALUES
(1, 'admin', 'gastro', 'admin.gastro@gmundo.com', '$2y$10$2K9cvNb2gR42U6WKlIR2J.d6cGi0wwMqSSjzl1cbhq6bLdZVJ5Tum', NULL, 9, '', ''),
(2, 'Diego', 'Paredes', 'diego@gmail.com', '$2y$10$.YOCivgMVM.sOitCji9qsu9FwkW/lJnprOzobbgvHyCb42hc06l1m', 'img-perfil-6917adb28f1e4.png', 1, '', ''),
(3, 'Roque', 'Bermejo', 'roque@gmail.com', '$2y$10$6PPnkJzqOOILFXdt5vWtwu30v0y9WHjsyqwETmto5.uiGajMjJziq', NULL, 1, '', ''),
(4, 'Daniel', 'Davidson', 'daniel@gmail.com', '$2y$10$r8hS2xlXoudzf/oe9FKYCuYRnggSXTmn7w0rjY4jOHupD40pXSh7u', 'img-perfil-6917b99f5d17d.jpg', 1, '', ''),
(5, 'Marcia', 'Anderson', 'marcia@gmail.com', '$2y$10$k5Zwn21v5pv0TFXjWr23se2YMpDuyVhTeTJo4UsULoGjXLMGOQu.6', 'img-perfil-6917b9ce717c8.jpg', 1, '', ''),
(6, 'Stephen', 'Boyd', 'stephen@gmail.com', '$2y$10$NmnrcfbBH31aqhq15yPbKOoxcGnVM1yaAtv91vutdv36Pngl8bbje', 'img-perfil-6917ba0b60fcc.jpg', 1, '', ''),
(7, 'tacos', 'de canasta', 'tacosdecanasta@gmail.com', '$2y$10$0e8tr7ixTl/CV3zTdQ.5ge8q1y8t.5Zfi8DX3qRRZc5b7sDb7iZEO', 'img-perfil-693cacc03e1bf.jpeg', 9, 'si', 'Andorra'),
(8, 'Daniel', 'Fuentes', 'daniel.fuentes@gmail.com', '$2y$10$uzjZTt5sKYN3dZeZEg0s3utM4Kh26L2eMATGalO2ET9tbuunQjnvG', 'img-perfil-6940b55759f62.jpeg', 1, 'Desarrollador web senior', 'Venezuela');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `dishes`
--
ALTER TABLE `dishes`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `dishes`
--
ALTER TABLE `dishes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
