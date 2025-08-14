-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Versión del servidor:         10.4.32-MariaDB - mariadb.org binary distribution
-- SO del servidor:              Win64
-- HeidiSQL Versión:             12.10.0.7000
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


-- Volcando estructura de base de datos para arrendaoco
CREATE DATABASE IF NOT EXISTS `arrendaoco` /*!40100 DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci */;
USE `arrendaoco`;

-- Volcando estructura para tabla arrendaoco.comentarios
CREATE TABLE IF NOT EXISTS `comentarios` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_inmueble` int(11) NOT NULL,
  `id_usuario` int(11) NOT NULL,
  `comentario` text NOT NULL,
  `fecha` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `id_inmueble` (`id_inmueble`),
  KEY `id_usuario` (`id_usuario`),
  CONSTRAINT `comentarios_ibfk_1` FOREIGN KEY (`id_inmueble`) REFERENCES `inmuebles` (`id_in`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `comentarios_ibfk_2` FOREIGN KEY (`id_usuario`) REFERENCES `usuarios` (`id_user`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=35 DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- Volcando datos para la tabla arrendaoco.comentarios: ~2 rows (aproximadamente)
INSERT INTO `comentarios` (`id`, `id_inmueble`, `id_usuario`, `comentario`, `fecha`) VALUES
	(32, 16, 5, '1', '2025-08-08 17:50:04'),
	(33, 16, 5, '1', '2025-08-08 17:50:59');

-- Volcando estructura para tabla arrendaoco.imagenes_inmueble
CREATE TABLE IF NOT EXISTS `imagenes_inmueble` (
  `id_img` int(11) NOT NULL AUTO_INCREMENT,
  `id_in` int(11) NOT NULL,
  `ruta_imagen` varchar(255) NOT NULL,
  PRIMARY KEY (`id_img`),
  KEY `FK_imagenes_inmueble` (`id_in`),
  CONSTRAINT `FK_imagenes_inmueble` FOREIGN KEY (`id_in`) REFERENCES `inmuebles` (`id_in`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=106 DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- Volcando datos para la tabla arrendaoco.imagenes_inmueble: ~22 rows (aproximadamente)
INSERT INTO `imagenes_inmueble` (`id_img`, `id_in`, `ruta_imagen`) VALUES
	(39, 16, 'uploads/inmuebles/6892f28f3f441_casa3.jpg'),
	(40, 16, 'uploads/inmuebles/6892f28f40214_cuarto1.1.jpg'),
	(41, 16, 'uploads/inmuebles/6892f28f40bf0_cuarto1.2.jpg'),
	(42, 16, 'uploads/inmuebles/6892f28f41416_cuarto1.jpg'),
	(63, 21, 'uploads/inmuebles/6893d0ca28340_casa3.2.jpg'),
	(64, 21, 'uploads/inmuebles/6893d0ca28c8e_casa3.3.jpg'),
	(65, 21, 'uploads/inmuebles/6893d0ca29a02_casa3.4.jpg'),
	(66, 21, 'uploads/inmuebles/6893d0ca2a587_casa3.5.jpg'),
	(84, 25, 'uploads/inmuebles/6893d3188f44a_casa1.1.webp'),
	(85, 25, 'uploads/inmuebles/6893d3189031c_casa1.2.webp'),
	(86, 25, 'uploads/inmuebles/6893d31890c3e_casa1.3.webp'),
	(87, 25, 'uploads/inmuebles/6893d3189160f_casa1.4.webp'),
	(88, 26, 'uploads/inmuebles/689409096837f_cuarto2.3.jpeg'),
	(89, 26, 'uploads/inmuebles/6894090968d79_cuarto3.1.jpg'),
	(90, 26, 'uploads/inmuebles/6894090969494_departamento1.1.jpg'),
	(91, 26, 'uploads/inmuebles/6894090969d53_departamento1.jpeg'),
	(92, 27, 'uploads/inmuebles/689409c691b3d_cuarto3.3.jpeg'),
	(93, 27, 'uploads/inmuebles/689409c692757_cuarto3.jpeg'),
	(94, 27, 'uploads/inmuebles/689409c693401_departamento1.1.jpg'),
	(95, 27, 'uploads/inmuebles/689409c694030_departamento1.2.jpg'),
	(99, 36, 'uploads/inmuebles/68956af67af41_Captura de pantalla 2025-04-30 175231.png'),
	(100, 37, 'uploads/inmuebles/68956be3e1234_Captura de pantalla 2025-06-02 102503.png');

-- Volcando estructura para tabla arrendaoco.inmuebles
CREATE TABLE IF NOT EXISTS `inmuebles` (
  `id_in` int(11) NOT NULL AUTO_INCREMENT,
  `propietario` int(10) NOT NULL,
  `nombre_in` varchar(50) NOT NULL,
  `precio` float NOT NULL DEFAULT 0,
  `descripcion` varchar(255) NOT NULL,
  `estatus` enum('Disponible','Ocupado') NOT NULL,
  `categoria` enum('Cuarto','Casa','Departamento') NOT NULL,
  `contacto` varchar(50) NOT NULL,
  `ubicacion` varchar(100) NOT NULL,
  PRIMARY KEY (`id_in`),
  KEY `FK_inmuebles_usuarios` (`propietario`),
  CONSTRAINT `FK_inmuebles_usuarios` FOREIGN KEY (`propietario`) REFERENCES `usuarios` (`id_user`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=39 DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- Volcando datos para la tabla arrendaoco.inmuebles: ~7 rows (aproximadamente)
INSERT INTO `inmuebles` (`id_in`, `propietario`, `nombre_in`, `precio`, `descripcion`, `estatus`, `categoria`, `contacto`, `ubicacion`) VALUES
	(16, 1, 'Departamento Tonina', 1231230, 'asdas', 'Disponible', 'Casa', 'd1412dsdaa', '1sur oreinte entre 15 y 16 sureste'),
	(21, 3, 'Departamento Tonina', 25001, 'kjahskjdah', 'Disponible', 'Casa', '651458416514', '1sur oreinte entre 15 y 16 sur'),
	(25, 1, 'Departamento Tonina', 25001, 'kkjskjsk', 'Disponible', 'Casa', '651458416514', '1sur oreinte entre 15 y 16 sur'),
	(26, 3, 'Departamento Tonina', 25001, 'kjkkhg', 'Disponible', 'Casa', '651458416514', '1sur oreinte entre 15 y 16 sur'),
	(27, 3, 'Departamento Tonina', 1, 'asdasda', 'Disponible', 'Departamento', '1234567890', '1sur oreinte entre 15 y 16 sur'),
	(36, 1, 'casapruebaestilo', 789456, 'asdfghjkl,mnbvcx', 'Disponible', 'Casa', '54654654', 'ocosingo,Chis'),
	(37, 1, 'prueba222', 123456, 'prueba para ver si funcionan las imagenes', 'Ocupado', 'Departamento', '9191585016', 'ocosingo,Chis');

-- Volcando estructura para tabla arrendaoco.usuarios
CREATE TABLE IF NOT EXISTS `usuarios` (
  `id_user` int(10) NOT NULL AUTO_INCREMENT,
  `user` varchar(25) NOT NULL,
  `pass` char(50) NOT NULL,
  `nombre` varchar(45) NOT NULL,
  `direccion` varchar(100) NOT NULL,
  `tel` bigint(10) NOT NULL,
  `correo` varchar(50) NOT NULL,
  `bandera` enum('1','2','3') NOT NULL COMMENT '1=admin, 2=arrendador, 3=inquilino',
  PRIMARY KEY (`id_user`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- Volcando datos para la tabla arrendaoco.usuarios: ~7 rows (aproximadamente)
INSERT INTO `usuarios` (`id_user`, `user`, `pass`, `nombre`, `direccion`, `tel`, `correo`, `bandera`) VALUES
	(1, 'admin', '123', 'ADMINISTRADOR', 'Calle conocida', 55123456789, 'admin@correo.com', '1'),
	(2, 'arrendador1', '123', 'Propietario Uno', 'Calle A', 5511111111, 'prop1@correo.com', '2'),
	(3, 'propietario', '123', 'Propietario Dos', 'Calle B', 78945612345545, 'prop2@correo.com', '2'),
	(5, 'inquilino', '123', 'Eduardo Aguilar', '1 sur', 98248429298, 'edag@gmail.com', '3'),
	(8, 'hola', '123', 'holaa', 'conocida', 1234567891, 'fdgfdgfdf@ddf', '3'),
	(9, 'fati', '123', 'FATIMA', 'conocida', 13213654654, 'hola@hola.com', '2'),
	(10, 'yo', '123', 'Eduardo', '1 sur', 98248429298, 'edag@gmail.com', '2');

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
