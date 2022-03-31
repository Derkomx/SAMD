-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Versión del servidor:         10.4.24-MariaDB - mariadb.org binary distribution
-- SO del servidor:              Win64
-- HeidiSQL Versión:             11.3.0.6295
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


-- Volcando estructura de base de datos para basenueva
CREATE DATABASE IF NOT EXISTS `basenueva` /*!40100 DEFAULT CHARACTER SET utf8mb4 */;
USE `basenueva`;

-- Volcando estructura para tabla basenueva.datos_personales
CREATE TABLE IF NOT EXISTS `datos_personales` (
  `id_datos_personales` int(11) NOT NULL AUTO_INCREMENT,
  `id_usuario` int(11) NOT NULL,
  `apellido` varchar(50) NOT NULL,
  `nombres` varchar(50) NOT NULL,
  `fecha_nacimiento` date NOT NULL,
  `email` varchar(50) DEFAULT '0',
  `bloqueado` int(11) NOT NULL DEFAULT 0,
  PRIMARY KEY (`id_datos_personales`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=latin1;

-- La exportación de datos fue deseleccionada.

-- Volcando estructura para tabla basenueva.intentos_logueo
CREATE TABLE IF NOT EXISTS `intentos_logueo` (
  `id_usuario` int(11) NOT NULL,
  `hora` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- La exportación de datos fue deseleccionada.

-- Volcando estructura para tabla basenueva.menu
CREATE TABLE IF NOT EXISTS `menu` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `user` varchar(50) DEFAULT NULL,
  `m1` varchar(50) DEFAULT NULL,
  `m2` varchar(50) DEFAULT NULL,
  `m3` varchar(50) DEFAULT NULL,
  `m4` varchar(50) DEFAULT NULL,
  `m5` varchar(50) DEFAULT NULL,
  `m6` varchar(50) DEFAULT NULL,
  `m7` varchar(50) DEFAULT NULL,
  `m8` varchar(50) DEFAULT NULL,
  `m9` varchar(50) DEFAULT NULL,
  `m10` varchar(50) DEFAULT NULL,
  `m11` varchar(50) DEFAULT NULL,
  `m12` varchar(50) DEFAULT NULL,
  `m13` varchar(50) DEFAULT NULL,
  `m14` varchar(50) DEFAULT NULL,
  `m15` varchar(50) DEFAULT NULL,
  UNIQUE KEY `user` (`user`) USING BTREE,
  KEY `id` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb4;

-- La exportación de datos fue deseleccionada.

-- Volcando estructura para tabla basenueva.publicacionesm1
CREATE TABLE IF NOT EXISTS `publicacionesm1` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `titulo` varchar(50) DEFAULT NULL,
  `fecha` varchar(50) DEFAULT NULL,
  `iduser` int(11) DEFAULT NULL,
  KEY `id` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb4;

-- La exportación de datos fue deseleccionada.

-- Volcando estructura para tabla basenueva.publicacionesm10
CREATE TABLE IF NOT EXISTS `publicacionesm10` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `titulo` varchar(50) DEFAULT NULL,
  `fecha` varchar(50) DEFAULT NULL,
  `iduser` int(11) DEFAULT NULL,
  KEY `id` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- La exportación de datos fue deseleccionada.

-- Volcando estructura para tabla basenueva.publicacionesm11
CREATE TABLE IF NOT EXISTS `publicacionesm11` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `titulo` varchar(50) DEFAULT NULL,
  `fecha` varchar(50) DEFAULT NULL,
  `iduser` int(11) DEFAULT NULL,
  KEY `id` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- La exportación de datos fue deseleccionada.

-- Volcando estructura para tabla basenueva.publicacionesm12
CREATE TABLE IF NOT EXISTS `publicacionesm12` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `titulo` varchar(50) DEFAULT NULL,
  `fecha` varchar(50) DEFAULT NULL,
  `iduser` int(11) DEFAULT NULL,
  KEY `id` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- La exportación de datos fue deseleccionada.

-- Volcando estructura para tabla basenueva.publicacionesm13
CREATE TABLE IF NOT EXISTS `publicacionesm13` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `titulo` varchar(50) DEFAULT NULL,
  `fecha` varchar(50) DEFAULT NULL,
  `iduser` int(11) DEFAULT NULL,
  KEY `id` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- La exportación de datos fue deseleccionada.

-- Volcando estructura para tabla basenueva.publicacionesm14
CREATE TABLE IF NOT EXISTS `publicacionesm14` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `titulo` varchar(50) DEFAULT NULL,
  `fecha` varchar(50) DEFAULT NULL,
  `iduser` int(11) DEFAULT NULL,
  KEY `id` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- La exportación de datos fue deseleccionada.

-- Volcando estructura para tabla basenueva.publicacionesm15
CREATE TABLE IF NOT EXISTS `publicacionesm15` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `titulo` varchar(50) DEFAULT NULL,
  `fecha` varchar(50) DEFAULT NULL,
  `iduser` int(11) DEFAULT NULL,
  KEY `id` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- La exportación de datos fue deseleccionada.

-- Volcando estructura para tabla basenueva.publicacionesm2
CREATE TABLE IF NOT EXISTS `publicacionesm2` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `titulo` varchar(50) DEFAULT NULL,
  `fecha` varchar(50) DEFAULT NULL,
  `iduser` int(11) DEFAULT NULL,
  KEY `id` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb4;

-- La exportación de datos fue deseleccionada.

-- Volcando estructura para tabla basenueva.publicacionesm3
CREATE TABLE IF NOT EXISTS `publicacionesm3` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `titulo` varchar(50) DEFAULT NULL,
  `fecha` varchar(50) DEFAULT NULL,
  `iduser` int(11) DEFAULT NULL,
  KEY `id` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- La exportación de datos fue deseleccionada.

-- Volcando estructura para tabla basenueva.publicacionesm4
CREATE TABLE IF NOT EXISTS `publicacionesm4` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `titulo` varchar(50) DEFAULT NULL,
  `fecha` varchar(50) DEFAULT NULL,
  `iduser` int(11) DEFAULT NULL,
  KEY `id` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- La exportación de datos fue deseleccionada.

-- Volcando estructura para tabla basenueva.publicacionesm5
CREATE TABLE IF NOT EXISTS `publicacionesm5` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `titulo` varchar(50) DEFAULT NULL,
  `fecha` varchar(50) DEFAULT NULL,
  `iduser` int(11) DEFAULT NULL,
  KEY `id` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- La exportación de datos fue deseleccionada.

-- Volcando estructura para tabla basenueva.publicacionesm6
CREATE TABLE IF NOT EXISTS `publicacionesm6` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `titulo` varchar(50) DEFAULT NULL,
  `fecha` varchar(50) DEFAULT NULL,
  `iduser` int(11) DEFAULT NULL,
  KEY `id` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- La exportación de datos fue deseleccionada.

-- Volcando estructura para tabla basenueva.publicacionesm7
CREATE TABLE IF NOT EXISTS `publicacionesm7` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `titulo` varchar(50) DEFAULT NULL,
  `fecha` varchar(50) DEFAULT NULL,
  `iduser` int(11) DEFAULT NULL,
  KEY `id` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- La exportación de datos fue deseleccionada.

-- Volcando estructura para tabla basenueva.publicacionesm8
CREATE TABLE IF NOT EXISTS `publicacionesm8` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `titulo` varchar(50) DEFAULT NULL,
  `fecha` varchar(50) DEFAULT NULL,
  `iduser` int(11) DEFAULT NULL,
  KEY `id` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- La exportación de datos fue deseleccionada.

-- Volcando estructura para tabla basenueva.publicacionesm9
CREATE TABLE IF NOT EXISTS `publicacionesm9` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `titulo` varchar(50) DEFAULT NULL,
  `fecha` varchar(50) DEFAULT NULL,
  `iduser` int(11) DEFAULT NULL,
  KEY `id` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- La exportación de datos fue deseleccionada.

-- Volcando estructura para tabla basenueva.usuarios
CREATE TABLE IF NOT EXISTS `usuarios` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user` int(11) DEFAULT NULL,
  `salt` int(11) DEFAULT NULL,
  `clave` int(11) DEFAULT NULL,
  `email` int(11) DEFAULT NULL,
  `lvl` int(11) DEFAULT NULL,
  KEY `id` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb4;

-- La exportación de datos fue deseleccionada.

-- Volcando estructura para tabla basenueva.usuarios2
CREATE TABLE IF NOT EXISTS `usuarios2` (
  `id_usuario` int(11) NOT NULL AUTO_INCREMENT,
  `cuil` varchar(20) NOT NULL,
  `nivel` int(11) NOT NULL,
  `email` varchar(128) NOT NULL,
  `nuevoemail` varchar(128) DEFAULT NULL,
  `password` char(128) NOT NULL,
  `salt` char(128) NOT NULL,
  `activo` int(11) NOT NULL,
  `activacion` char(32) DEFAULT NULL,
  `verificado` int(1) unsigned zerofill NOT NULL DEFAULT 0,
  `alta` datetime DEFAULT NULL,
  `datos_enviados` int(1) NOT NULL DEFAULT 0,
  `verificado2` int(10) unsigned NOT NULL DEFAULT 0,
  `denegado` int(1) NOT NULL DEFAULT 0,
  `darkmode` int(1) NOT NULL DEFAULT 0,
  `admin` int(11) DEFAULT NULL,
  PRIMARY KEY (`id_usuario`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=latin1;

-- La exportación de datos fue deseleccionada.

-- Volcando estructura para tabla basenueva.visitas
CREATE TABLE IF NOT EXISTS `visitas` (
  `id_visitas` int(11) NOT NULL,
  `id_usuario` int(11) NOT NULL,
  `fecha` datetime NOT NULL,
  PRIMARY KEY (`id_visitas`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- La exportación de datos fue deseleccionada.

/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
