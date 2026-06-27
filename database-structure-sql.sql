# ************************************************************
# Sequel Ace SQL dump
# Version 20095
#
# https://sequel-ace.com/
# https://github.com/Sequel-Ace/Sequel-Ace
#
# Host: 127.0.0.1 (MySQL 8.0.42)
# Database: reportesv2
# Generation Time: 2026-05-09 2:35:01 PM +0000
# ************************************************************


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
SET NAMES utf8mb4;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE='NO_AUTO_VALUE_ON_ZERO', SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


# Dump of table ampacities
# ------------------------------------------------------------

CREATE TABLE `ampacities` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `size` varchar(11) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `ampacity` int DEFAULT NULL,
  `temperature` int DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=36 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;



# Dump of table asignacions
# ------------------------------------------------------------

CREATE TABLE `asignacions` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `id_motor` int NOT NULL,
  `id_user` int NOT NULL,
  `asignado_por` int NOT NULL,
  `responsabilidad` double(5,2) DEFAULT NULL,
  `pago` double(5,2) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10936 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;



# Dump of table balanceos
# ------------------------------------------------------------

CREATE TABLE `balanceos` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `service_speed` float DEFAULT NULL,
  `balancing_speed` float DEFAULT NULL,
  `comments` tinytext COLLATE utf8mb4_unicode_ci,
  `left_radius` float DEFAULT NULL,
  `right_radius` float DEFAULT NULL,
  `dimensionA` float DEFAULT NULL,
  `dimensionB` float DEFAULT NULL,
  `gin_initial_left` float DEFAULT NULL,
  `gin_initial_right` float DEFAULT NULL,
  `gin_final_left` float DEFAULT NULL,
  `gin_final_right` float DEFAULT NULL,
  `key_drive_wide` float DEFAULT NULL,
  `key_drive_thick` float DEFAULT NULL,
  `key_drive_long` float DEFAULT NULL,
  `key_rear_wide` float DEFAULT NULL,
  `key_rear_thick` float DEFAULT NULL,
  `key_rear_long` float DEFAULT NULL,
  `grade` float DEFAULT NULL,
  `motor_id` int unsigned NOT NULL,
  `item_weight` float DEFAULT NULL,
  `date` varchar(120) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `balanceos_arts_id` int DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `mil_tolerance` float unsigned DEFAULT '0.3',
  PRIMARY KEY (`id`),
  KEY `motor_id` (`motor_id`),
  CONSTRAINT `balanceos_ibfk_1` FOREIGN KEY (`motor_id`) REFERENCES `motors` (`id_motor`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=158 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;



# Dump of table balanceos_arts
# ------------------------------------------------------------

CREATE TABLE `balanceos_arts` (
  `id` int NOT NULL AUTO_INCREMENT,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=98 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;



# Dump of table balanceos_steps
# ------------------------------------------------------------

CREATE TABLE `balanceos_steps` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `mils_left` float DEFAULT NULL,
  `mils_right` float DEFAULT NULL,
  `balanceo_id` int unsigned NOT NULL,
  `angle_left` float DEFAULT NULL,
  `angle_right` float DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `balanceos_steps_ibfk_1` (`balanceo_id`),
  CONSTRAINT `balanceos_steps_ibfk_1` FOREIGN KEY (`balanceo_id`) REFERENCES `balanceos` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=912 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;



# Dump of table bitacoras
# ------------------------------------------------------------

CREATE TABLE `bitacoras` (
  `titulo` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `descripcion` text COLLATE utf8mb4_unicode_ci,
  `id_usuario` int NOT NULL,
  `id_motor` int NOT NULL DEFAULT '0',
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1999 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;



# Dump of table boards
# ------------------------------------------------------------

CREATE TABLE `boards` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `owner_id` int unsigned DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `boards_owner_id_foreign` (`owner_id`),
  CONSTRAINT `boards_owner_id_foreign` FOREIGN KEY (`owner_id`) REFERENCES `users` (`id`) ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;



# Dump of table boards_users
# ------------------------------------------------------------

CREATE TABLE `boards_users` (
  `board_id` int unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`board_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;



# Dump of table clientes
# ------------------------------------------------------------

CREATE TABLE `clientes` (
  `id_cliente` int unsigned NOT NULL AUTO_INCREMENT,
  `cliente` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `ciudad` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `pais` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id_cliente`)
) ENGINE=InnoDB AUTO_INCREMENT=661 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;



# Dump of table cojinete_motors
# ------------------------------------------------------------

CREATE TABLE `cojinete_motors` (
  `id_motor` int NOT NULL,
  `id_cojinete` int NOT NULL,
  `pos_cojinete` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `diam_externo` double(12,4) NOT NULL,
  `diam_interno` double(12,4) NOT NULL,
  `sellos` int NOT NULL,
  `juego` int NOT NULL,
  `jaula` int NOT NULL,
  `marca_original` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `marca_colocar` int NOT NULL,
  `tolerancia` tinyint NOT NULL,
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;



# Dump of table cojinetes
# ------------------------------------------------------------

CREATE TABLE `cojinetes` (
  `serie` int DEFAULT NULL,
  `designacion` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `foto` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `diam_interno` int NOT NULL DEFAULT '0',
  `diam_externo` int NOT NULL DEFAULT '0',
  `ancho` int NOT NULL DEFAULT '0',
  `limite_velocidad` int NOT NULL DEFAULT '11000',
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;



# Dump of table configs
# ------------------------------------------------------------

CREATE TABLE `configs` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `year` int DEFAULT NULL,
  `view_cards` tinyint(1) DEFAULT '0',
  `user_id` int unsigned DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `configs_user_id_foreign` (`user_id`),
  CONSTRAINT `configs_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;



# Dump of table contactos
# ------------------------------------------------------------

CREATE TABLE `contactos` (
  `contacto` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `telefono` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `puesto` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `id_cliente` int NOT NULL,
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=947 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;



# Dump of table diagnosticos
# ------------------------------------------------------------

CREATE TABLE `diagnosticos` (
  `id_motor` int NOT NULL,
  `alto_voltaje` tinyint DEFAULT NULL,
  `desfase` tinyint DEFAULT NULL,
  `pico_voltaje` tinyint DEFAULT NULL,
  `desbalance` tinyint DEFAULT NULL,
  `desalineacion` tinyint DEFAULT NULL,
  `desajuste` tinyint DEFAULT NULL,
  `rod_inapropiado` tinyint DEFAULT NULL,
  `exceso_carga` tinyint DEFAULT NULL,
  `golpe_mecanico` tinyint DEFAULT NULL,
  `falta_lubricacion` tinyint DEFAULT NULL,
  `exceso_lubricacion` tinyint DEFAULT NULL,
  `exceso_contaminacion` tinyint DEFAULT NULL,
  `falla_sello` tinyint DEFAULT NULL,
  `mala_grasa` tinyint DEFAULT NULL,
  `sobrecarga` tinyint DEFAULT NULL,
  `falla_ventilacion` tinyint DEFAULT NULL,
  `pico_amperaje` tinyint DEFAULT NULL,
  `mal_diseno` tinyint DEFAULT NULL,
  `perdida_eficiencia` tinyint unsigned DEFAULT NULL,
  `mala_conexion` tinyint DEFAULT NULL,
  `corto_humedad` tinyint DEFAULT NULL,
  `corto_aislamiento` tinyint DEFAULT NULL,
  `corto_vueltas` tinyint DEFAULT NULL,
  `golpe_bobinado` tinyint DEFAULT NULL,
  `roze_rotor` tinyint DEFAULT NULL,
  `corto_cables` tinyint DEFAULT NULL,
  `descripcion` text COLLATE utf8mb4_unicode_ci,
  `trabajo_electrico` tinyint NOT NULL DEFAULT '0',
  `contaminacion` tinyint NOT NULL DEFAULT '0',
  `aislamiento` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `folder_surge` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `modo_lavado` tinyint NOT NULL DEFAULT '0',
  `cantidad_reprocesos` tinyint NOT NULL DEFAULT '0',
  `iCheckTermo` tinyint NOT NULL DEFAULT '0',
  `iCheckTerminales` tinyint NOT NULL DEFAULT '0',
  `iCheckExtraer` tinyint NOT NULL DEFAULT '0',
  `tipo_carcaza` tinyint NOT NULL DEFAULT '1',
  `multiples_velocidades` tinyint NOT NULL DEFAULT '0',
  `tipo_alambre` tinyint NOT NULL DEFAULT '0',
  `libras_alambre` tinyint NOT NULL DEFAULT '0',
  `iCheckSeparar` tinyint NOT NULL DEFAULT '0',
  `bobinado_puntos` blob,
  `iCheckEpoxitar` tinyint NOT NULL DEFAULT '0',
  `puntas_salida` tinyint NOT NULL DEFAULT '6',
  `complejidad` tinyint NOT NULL DEFAULT '2',
  `desc_bobinado` text COLLATE utf8mb4_unicode_ci,
  `balancear` tinyint NOT NULL DEFAULT '0',
  `peso_balanceo` tinyint NOT NULL DEFAULT '2',
  `finalizado` tinyint NOT NULL DEFAULT '0',
  `fecha_fin_diagnostico` datetime DEFAULT NULL,
  `id_user` int DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  UNIQUE KEY `diagnosticos_id_motor_unique` (`id_motor`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;



# Dump of table documentos
# ------------------------------------------------------------

CREATE TABLE `documentos` (
  `id` int NOT NULL AUTO_INCREMENT,
  `documento` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `titulo` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `descripcion` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `id_motor` int NOT NULL,
  `id_user` int NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `seccion` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3470 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;



# Dump of table envios
# ------------------------------------------------------------

CREATE TABLE `envios` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `fecha` datetime DEFAULT NULL,
  `tipo_vehiculo` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `placa_vehiculo` varchar(40) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `nombre_piloto` varchar(75) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `dpi_piloto` varchar(25) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tipo_envio` enum('1','2') COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '1=Envio Final, 2=Envio Parcial',
  `id_motor` int unsigned NOT NULL,
  `comentarios` mediumtext COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `envios_id_motor_foreign` (`id_motor`),
  CONSTRAINT `envios_id_motor_foreign` FOREIGN KEY (`id_motor`) REFERENCES `motors` (`id_motor`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=1256 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;



# Dump of table envios_adicionales
# ------------------------------------------------------------

CREATE TABLE `envios_adicionales` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `parte` varchar(250) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `envio_id` int unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `envios_adicionales_envio_id_foreign` (`envio_id`),
  CONSTRAINT `envios_adicionales_envio_id_foreign` FOREIGN KEY (`envio_id`) REFERENCES `envios` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=1161 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;



# Dump of table fotos
# ------------------------------------------------------------

CREATE TABLE `fotos` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `id_motor` int NOT NULL,
  `foto` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `thumb` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `titulo` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `type` tinyint NOT NULL,
  `descripcion` text COLLATE utf8mb4_unicode_ci,
  `accion` tinyint NOT NULL DEFAULT '0',
  `trabajo_agregado` tinyint NOT NULL DEFAULT '0',
  `user_id` int DEFAULT NULL,
  `addToReport` tinyint(1) DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=193043 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;



# Dump of table fotos_trabajos
# ------------------------------------------------------------

CREATE TABLE `fotos_trabajos` (
  `id_foto` int NOT NULL,
  `id_trabajo` int NOT NULL,
  `progress` int DEFAULT NULL,
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2550 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;



# Dump of table grasas
# ------------------------------------------------------------

CREATE TABLE `grasas` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `ficha` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;



# Dump of table horas_extras
# ------------------------------------------------------------

CREATE TABLE `horas_extras` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `init` datetime NOT NULL,
  `final` datetime NOT NULL,
  `descripcion` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `autorizado_por` int unsigned NOT NULL,
  `user_id` int unsigned NOT NULL,
  `id_motor` int unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `hours` float DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `horas_extras_autorizado_por_foreign` (`autorizado_por`),
  KEY `horas_extras_user_id_foreign` (`user_id`),
  KEY `horas_extras_id_motor_foreign` (`id_motor`),
  CONSTRAINT `horas_extras_autorizado_por_foreign` FOREIGN KEY (`autorizado_por`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  CONSTRAINT `horas_extras_id_motor_foreign` FOREIGN KEY (`id_motor`) REFERENCES `motors` (`id_motor`) ON DELETE CASCADE,
  CONSTRAINT `horas_extras_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;



# Dump of table images
# ------------------------------------------------------------

CREATE TABLE `images` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `comentario` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `imageable_id` int unsigned DEFAULT NULL,
  `imageable_type` varchar(150) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_id` int unsigned DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `addToReport` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=706 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;



# Dump of table info_clientes
# ------------------------------------------------------------

CREATE TABLE `info_clientes` (
  `nit` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `razon_social` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `id_cliente` int NOT NULL,
  `direccion_fiscal` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `direccion_planta` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `comentarios` text COLLATE utf8mb4_unicode_ci,
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=825 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;



# Dump of table info_motors
# ------------------------------------------------------------

CREATE TABLE `info_motors` (
  `id_motor` int NOT NULL DEFAULT '1',
  `emergencia` int DEFAULT NULL,
  `nombre_equipo` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `contacto` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `telefono` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `cotizar` tinyint DEFAULT '1',
  `aplicacion` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `reales` tinyint DEFAULT '1',
  `horas_operacion` int DEFAULT NULL,
  `volts_operacion` tinyint NOT NULL DEFAULT '0',
  `vab` double(8,2) DEFAULT NULL,
  `vbc` double(8,2) DEFAULT NULL,
  `vca` double(8,2) DEFAULT NULL,
  `amps_operacion` tinyint DEFAULT '0',
  `aa` double(8,2) DEFAULT NULL,
  `ab` double(8,2) DEFAULT NULL,
  `ac` double(8,2) DEFAULT NULL,
  `modo_arranque` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT '',
  `vibracion` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT '',
  `temp_estator` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT '',
  `temp_cojinetes` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT '',
  `coment_operacion` text COLLATE utf8mb4_unicode_ci,
  `enviar_os` tinyint DEFAULT '1',
  `enviar_progreso` tinyint DEFAULT '1',
  `enviar_diagnostico` tinyint DEFAULT '1',
  `estatus` tinyint DEFAULT '0',
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `balanceo` tinyint DEFAULT NULL,
  `encamisado_lc_mm` int DEFAULT NULL,
  `encamisado_lcc_mm` int DEFAULT NULL,
  `cojinete1` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `cojinete2` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `cojinete3` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `cojinete4` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `retenedor1` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `retenedor2` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `retenedor3` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `usa_freno` tinyint DEFAULT NULL,
  `bobinado` tinyint DEFAULT NULL,
  `ventilador_pulg` int DEFAULT NULL,
  `bornera_tipo` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `extracciones_complicadas` mediumtext COLLATE utf8mb4_unicode_ci,
  `grasa` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tornilleria` int DEFAULT NULL,
  `metalizado` tinyint DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10165 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;



# Dump of table informar_a_contactos
# ------------------------------------------------------------

CREATE TABLE `informar_a_contactos` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `id_motor` int unsigned NOT NULL,
  `id_contacto` int unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `informar_a_contactos_id_motor_foreign` (`id_motor`),
  KEY `informar_a_contactos_id_contacto_foreign` (`id_contacto`),
  CONSTRAINT `informar_a_contactos_id_contacto_foreign` FOREIGN KEY (`id_contacto`) REFERENCES `contactos` (`id`) ON DELETE CASCADE,
  CONSTRAINT `informar_a_contactos_id_motor_foreign` FOREIGN KEY (`id_motor`) REFERENCES `motors` (`id_motor`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=889 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;



# Dump of table inventarios
# ------------------------------------------------------------

CREATE TABLE `inventarios` (
  `id_motor` int NOT NULL,
  `acople` tinyint NOT NULL,
  `caja_conexiones` tinyint NOT NULL,
  `tapa_caja` tinyint NOT NULL,
  `difusor` tinyint NOT NULL,
  `ventilador` tinyint NOT NULL,
  `bornera` tinyint NOT NULL,
  `cunia` tinyint NOT NULL,
  `graseras` tinyint NOT NULL,
  `cancamo` tinyint NOT NULL,
  `placa` tinyint NOT NULL,
  `capacitor` tinyint NOT NULL,
  `tornillos` tinyint NOT NULL,
  `comentarios` text COLLATE utf8mb4_unicode_ci,
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10165 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;



# Dump of table item_bodegas
# ------------------------------------------------------------

DROP TABLE IF EXISTS `item_bodegas`;

CREATE TABLE `item_bodegas` (
  `nombre_item` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nombre_descriptor1` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `nombre_descriptor2` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `nombre_descriptor3` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `valor_descriptor1` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `valor_descriptor2` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `valor_descriptor3` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `unidad` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `maximo` double(8,2) NOT NULL DEFAULT '0.00',
  `minimo` double(8,2) NOT NULL DEFAULT '0.00',
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;



# Dump of table job_type
# ------------------------------------------------------------

CREATE TABLE `job_type` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `prefix` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `campo1` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `campo2` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `userTypes` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;



# Dump of table jobs
# ------------------------------------------------------------

CREATE TABLE `jobs` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `year` varchar(7) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `os` int DEFAULT NULL,
  `value_campo1` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `value_campo2` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `id_motor` int unsigned DEFAULT NULL,
  `job_type_id` int unsigned DEFAULT NULL,
  `finished` datetime DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `jobs_id_motor_foreign` (`id_motor`),
  KEY `jobs_job_type_id_foreign` (`job_type_id`),
  CONSTRAINT `jobs_id_motor_foreign` FOREIGN KEY (`id_motor`) REFERENCES `motors` (`id_motor`) ON DELETE SET NULL ON UPDATE CASCADE,
  CONSTRAINT `jobs_job_type_id_foreign` FOREIGN KEY (`job_type_id`) REFERENCES `job_type` (`id`) ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=637 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;



# Dump of table jobs_assigned
# ------------------------------------------------------------

CREATE TABLE `jobs_assigned` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int unsigned DEFAULT NULL,
  `job_id` int unsigned DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `assigned_by` int unsigned DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `jobs_assigned_user_id_foreign` (`user_id`),
  KEY `jobs_assigned_job_id_foreign` (`job_id`),
  KEY `jobs_assigned_assigned_by_foreign` (`assigned_by`),
  CONSTRAINT `jobs_assigned_assigned_by_foreign` FOREIGN KEY (`assigned_by`) REFERENCES `users` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  CONSTRAINT `jobs_assigned_job_id_foreign` FOREIGN KEY (`job_id`) REFERENCES `jobs` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  CONSTRAINT `jobs_assigned_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=647 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;



# Dump of table looks
# ------------------------------------------------------------

CREATE TABLE `looks` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `motor_id` int unsigned NOT NULL,
  `user_id` int unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `looks_motor_id_foreign` (`motor_id`),
  KEY `looks_user_id_foreign` (`user_id`),
  CONSTRAINT `looks_motor_id_foreign` FOREIGN KEY (`motor_id`) REFERENCES `motors` (`id_motor`) ON DELETE CASCADE,
  CONSTRAINT `looks_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=178 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;



# Dump of table materiales
# ------------------------------------------------------------

CREATE TABLE `materiales` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `material` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `descripcion` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `foto` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `datasheet` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `unidad` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `minimo` float NOT NULL DEFAULT '0',
  `maximo` float NOT NULL DEFAULT '0',
  `id_proveedor1` int DEFAULT NULL,
  `id_proveedor2` int DEFAULT NULL,
  `id_proveedor3` int DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;



# Dump of table materiales_movimientos
# ------------------------------------------------------------

CREATE TABLE `materiales_movimientos` (
  `id` int NOT NULL AUTO_INCREMENT,
  `id_motor` int DEFAULT NULL,
  `id_material` int NOT NULL,
  `cantidad` float NOT NULL,
  `id_user` int NOT NULL,
  `operacion` int NOT NULL COMMENT '1>compra 2>salida 3>prestamo 4>descarte5>consignacion',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `precio_unitario` float DEFAULT NULL,
  `factura_no` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `id_proveedor` int DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;



# Dump of table materiales_pedidos
# ------------------------------------------------------------

CREATE TABLE `materiales_pedidos` (
  `id` int NOT NULL AUTO_INCREMENT,
  `id_material` int NOT NULL,
  `material` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `presentacion` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `cantidad` float NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `id_motor` int NOT NULL,
  `id_user` int NOT NULL,
  `despachado` int NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=73147 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;



# Dump of table medidas_rodamientos
# ------------------------------------------------------------

CREATE TABLE `medidas_rodamientos` (
  `designacion` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `inside_diameter` int NOT NULL,
  `outside_diameter` int NOT NULL,
  PRIMARY KEY (`designacion`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;



# Dump of table migrations
# ------------------------------------------------------------

CREATE TABLE `migrations` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=270 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;



# Dump of table motors
# ------------------------------------------------------------

CREATE TABLE `motors` (
  `id_motor` int unsigned NOT NULL AUTO_INCREMENT,
  `year` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `os` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `hp` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT '',
  `hpkw` tinyint NOT NULL DEFAULT '1',
  `serie` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `modelo` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `marca` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `rpm` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `volts` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `amps` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `frame` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `pf` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `eff` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `inverter_duty` tinyint(1) DEFAULT '0',
  `id_tipoequipo` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `fecha_ingreso` datetime NOT NULL,
  `acdc` tinyint DEFAULT NULL,
  `id_enclosure` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `id_cliente` int DEFAULT NULL,
  `id_trabajo` int unsigned DEFAULT NULL,
  `comentarios` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `recibido` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `hz` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `phases` tinyint DEFAULT NULL,
  `status_id` tinyint DEFAULT '-1',
  `inicio` datetime DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `diagnostico_img` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `diagnosticado_por` int DEFAULT NULL,
  `autorizado_por` int DEFAULT NULL,
  `fin` datetime DEFAULT NULL,
  `temperaturas` blob,
  `temperaturas_comentario` text COLLATE utf8mb4_unicode_ci,
  `temperaturas_path` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id_motor`),
  KEY `motors_id_trabajo_foreign` (`id_trabajo`),
  CONSTRAINT `motors_id_trabajo_foreign` FOREIGN KEY (`id_trabajo`) REFERENCES `tipo_trabajos` (`id`) ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=10167 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;



# Dump of table motors_ajustes
# ------------------------------------------------------------

CREATE TABLE `motors_ajustes` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `rpm` int DEFAULT NULL,
  `p` double(8,4) DEFAULT NULL,
  `q` double(8,4) DEFAULT NULL,
  `r` double(8,4) DEFAULT NULL,
  `s` double(8,4) DEFAULT NULL,
  `t` double(8,4) DEFAULT NULL,
  `ax` double(8,4) DEFAULT NULL,
  `bx` double(8,4) DEFAULT NULL,
  `cx` double(8,4) DEFAULT NULL,
  `ay` double(8,4) DEFAULT NULL,
  `by` double(8,4) DEFAULT NULL,
  `cy` double(8,4) DEFAULT NULL,
  `e1` double(8,4) DEFAULT NULL,
  `e2` double(8,4) DEFAULT NULL,
  `e3` double(8,4) DEFAULT NULL,
  `initial_final` int DEFAULT NULL,
  `carga_opuesto` int DEFAULT NULL,
  `sellos` int DEFAULT NULL,
  `juego_radial` int DEFAULT NULL,
  `jaula` int DEFAULT NULL,
  `grasa_id` int DEFAULT NULL,
  `aislado` int DEFAULT NULL,
  `comentarios` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `rodamiento_id` int DEFAULT NULL,
  `rodamiento_marca_id` int unsigned DEFAULT NULL,
  `recomendacion` varchar(200) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `recomendacion_eje` varchar(200) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `id_motor` int unsigned DEFAULT NULL,
  `options_tornero_id` int unsigned DEFAULT NULL,
  `options_tornero_eje_id` int DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `user_medida_id` int unsigned DEFAULT NULL,
  `user_medida_eje_id` int unsigned DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `motors_ajustes_id_motor_foreign` (`id_motor`),
  KEY `motors_ajustes_rodamiento_id_foreign` (`rodamiento_id`),
  KEY `motors_ajustes_rodamiento_marca_id_foreign` (`rodamiento_marca_id`),
  KEY `motors_ajustes_options_tornero_id_foreign` (`options_tornero_id`),
  KEY `fk_motors_ajustes_user_medida_id` (`user_medida_id`),
  KEY `fk_motors_ajustes_user_decision_id` (`user_medida_eje_id`),
  CONSTRAINT `fk_motors_ajustes_user_decision_id` FOREIGN KEY (`user_medida_eje_id`) REFERENCES `users` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  CONSTRAINT `fk_motors_ajustes_user_medida_id` FOREIGN KEY (`user_medida_id`) REFERENCES `users` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  CONSTRAINT `motors_ajustes_id_motor_foreign` FOREIGN KEY (`id_motor`) REFERENCES `motors` (`id_motor`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `motors_ajustes_options_tornero_id_foreign` FOREIGN KEY (`options_tornero_id`) REFERENCES `options_tornero` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  CONSTRAINT `motors_ajustes_rodamiento_id_foreign` FOREIGN KEY (`rodamiento_id`) REFERENCES `rodamientos` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `motors_ajustes_rodamiento_marca_id_foreign` FOREIGN KEY (`rodamiento_marca_id`) REFERENCES `rodamientos_marcas` (`id`) ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=434 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;



# Dump of table motors_metalizados
# ------------------------------------------------------------

CREATE TABLE `motors_metalizados` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `year` varchar(11) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `os` varchar(11) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `diametro` float DEFAULT NULL,
  `largo` float DEFAULT NULL,
  `profundidad` int DEFAULT NULL,
  `id_cliente` int unsigned DEFAULT NULL,
  `id_motor` int unsigned DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_motors_metalizados_clientes` (`id_cliente`),
  KEY `fk_motors_metalizados_motors` (`id_motor`),
  CONSTRAINT `fk_motors_metalizados_clientes` FOREIGN KEY (`id_cliente`) REFERENCES `clientes` (`id_cliente`) ON DELETE SET NULL ON UPDATE CASCADE,
  CONSTRAINT `fk_motors_metalizados_motors` FOREIGN KEY (`id_motor`) REFERENCES `motors` (`id_motor`) ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;



# Dump of table no_load_amps
# ------------------------------------------------------------

CREATE TABLE `no_load_amps` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `poles` int DEFAULT NULL,
  `minA` int DEFAULT NULL,
  `maxA` int DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;



# Dump of table no_load_test
# ------------------------------------------------------------

CREATE TABLE `no_load_test` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `origen` tinyint DEFAULT NULL,
  `voltaje_placa` float(8,2) DEFAULT NULL,
  `amperaje_placa` float(8,2) DEFAULT NULL,
  `conexion_placa` tinyint DEFAULT NULL,
  `circuitos_placa` tinyint DEFAULT NULL,
  `rpm_placa` int DEFAULT NULL,
  `hz_placa` int DEFAULT NULL,
  `volts_prueba_A` float(8,2) DEFAULT NULL,
  `volts_prueba_B` float(8,2) DEFAULT NULL,
  `volts_prueba_C` float(8,2) DEFAULT NULL,
  `amps_prueba_A` float(8,2) DEFAULT NULL,
  `amps_prueba_B` float(8,2) DEFAULT NULL,
  `amps_prueba_C` float(8,2) DEFAULT NULL,
  `conexion_prueba` tinyint DEFAULT NULL,
  `circuitos_prueba` tinyint DEFAULT NULL,
  `rpm_prueba` int DEFAULT NULL,
  `id_motor` int unsigned DEFAULT NULL,
  `id_user_test` int unsigned DEFAULT NULL,
  `ct` float(6,2) DEFAULT '1.00',
  `pt` float(6,2) DEFAULT '1.00',
  `useBalanced` tinyint(1) DEFAULT '0',
  `imbalance` float(6,2) DEFAULT '2.00',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `recorded` tinyint(1) DEFAULT NULL,
  `finished` datetime DEFAULT NULL,
  `id_user` int DEFAULT NULL,
  `graph_fl` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `last_graph_saved_by` int DEFAULT NULL,
  `amps_comment` text COLLATE utf8mb4_unicode_ci,
  PRIMARY KEY (`id`),
  KEY `idx_no_load_test_motor` (`id_motor`),
  KEY `idx_no_load_test_user` (`id_user_test`),
  CONSTRAINT `fk_no_load_test_motor` FOREIGN KEY (`id_motor`) REFERENCES `motors` (`id_motor`) ON DELETE SET NULL ON UPDATE CASCADE,
  CONSTRAINT `fk_no_load_test_user` FOREIGN KEY (`id_user_test`) REFERENCES `users` (`id`) ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=120 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;



# Dump of table options_tornero
# ------------------------------------------------------------

CREATE TABLE `options_tornero` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `cuna_eje` int DEFAULT NULL,
  `decision` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;



# Dump of table other_works
# ------------------------------------------------------------

CREATE TABLE `other_works` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `descripcion` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `fecha` datetime DEFAULT NULL,
  `pago` double(8,2) DEFAULT NULL,
  `user_id` int unsigned DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `other_works_user_id_foreign` (`user_id`),
  CONSTRAINT `other_works_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;



# Dump of table pilotos
# ------------------------------------------------------------

CREATE TABLE `pilotos` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(150) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `dpi` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;



# Dump of table pins
# ------------------------------------------------------------

CREATE TABLE `pins` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int unsigned NOT NULL,
  `board_id` int unsigned DEFAULT NULL,
  `pinable_id` int unsigned NOT NULL,
  `pinable_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `comment` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `pins_user_id_foreign` (`user_id`),
  KEY `pins_board_id_foreign` (`board_id`),
  CONSTRAINT `pins_board_id_foreign` FOREIGN KEY (`board_id`) REFERENCES `boards` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `pins_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=145 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;



# Dump of table proveedors
# ------------------------------------------------------------

CREATE TABLE `proveedors` (
  `id` int NOT NULL AUTO_INCREMENT,
  `proveedor` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `razon_social` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `direccion` varchar(150) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `telefono` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `contacto` varchar(200) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `correo` varchar(150) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;



# Dump of table pruebas
# ------------------------------------------------------------

CREATE TABLE `pruebas` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;



# Dump of table pruebas_motors
# ------------------------------------------------------------

CREATE TABLE `pruebas_motors` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `id_prueba` int unsigned DEFAULT NULL,
  `id_motor` int unsigned DEFAULT NULL,
  `done` tinyint(1) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `pruebas_motors_id_prueba_foreign` (`id_prueba`),
  KEY `pruebas_motors_id_motor_foreign` (`id_motor`),
  CONSTRAINT `pruebas_motors_id_motor_foreign` FOREIGN KEY (`id_motor`) REFERENCES `motors` (`id_motor`) ON DELETE SET NULL ON UPDATE CASCADE,
  CONSTRAINT `pruebas_motors_id_prueba_foreign` FOREIGN KEY (`id_prueba`) REFERENCES `pruebas` (`id`) ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;



# Dump of table rodamientos
# ------------------------------------------------------------

CREATE TABLE `rodamientos` (
  `id` int NOT NULL AUTO_INCREMENT,
  `designacion` varchar(10) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `diametro_interno` double(6,2) DEFAULT NULL,
  `diametro_externo` double(6,2) DEFAULT NULL,
  `ancho` double(6,2) DEFAULT NULL,
  `diametro_resalte` double(6,2) DEFAULT NULL,
  `diametro_rebaje` double(6,2) DEFAULT NULL,
  `chaflan` double(6,2) DEFAULT NULL,
  `tipo` int DEFAULT NULL,
  `D1` double(6,2) DEFAULT NULL,
  `F` double(6,2) DEFAULT NULL,
  `r3_4` double(6,2) DEFAULT NULL,
  `s` double(6,2) DEFAULT NULL,
  `H6` double(8,4) DEFAULT NULL,
  `teorica` double(8,4) DEFAULT NULL,
  `probable_min` double(8,4) DEFAULT NULL,
  `probable_max` double(8,4) DEFAULT NULL,
  `eje_ball_min` double(8,4) DEFAULT NULL,
  `eje_ball_max` double(8,4) DEFAULT NULL,
  `eje_ball_tol` varchar(5) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=129 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;



# Dump of table rodamientos_marcas
# ------------------------------------------------------------

CREATE TABLE `rodamientos_marcas` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;



# Dump of table sessions
# ------------------------------------------------------------

CREATE TABLE `sessions` (
  `id` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` int unsigned DEFAULT NULL,
  `ip_address` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_agent` text COLLATE utf8mb4_unicode_ci,
  `payload` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_activity` int NOT NULL,
  UNIQUE KEY `sessions_id_unique` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;



# Dump of table shared_boards
# ------------------------------------------------------------

CREATE TABLE `shared_boards` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `board_id` int unsigned NOT NULL,
  `user_id` int unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `shared_boards_board_id_foreign` (`board_id`),
  KEY `shared_boards_user_id_foreign` (`user_id`),
  CONSTRAINT `shared_boards_board_id_foreign` FOREIGN KEY (`board_id`) REFERENCES `boards` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `shared_boards_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;



# Dump of table statuses
# ------------------------------------------------------------

CREATE TABLE `statuses` (
  `id` int NOT NULL AUTO_INCREMENT,
  `status` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;



# Dump of table temperaturas
# ------------------------------------------------------------

CREATE TABLE `temperaturas` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `carga` float(5,2) DEFAULT NULL,
  `opuesto` float(5,2) DEFAULT NULL,
  `estator` float(5,2) DEFAULT NULL,
  `time` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `id_motor` int unsigned DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `temperaturas_id_motor_foreign` (`id_motor`),
  CONSTRAINT `temperaturas_id_motor_foreign` FOREIGN KEY (`id_motor`) REFERENCES `motors` (`id_motor`) ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=352 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;



# Dump of table tipo_equipos
# ------------------------------------------------------------

CREATE TABLE `tipo_equipos` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=28 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;



# Dump of table tipo_fotos
# ------------------------------------------------------------

CREATE TABLE `tipo_fotos` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=109 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;



# Dump of table tipo_trabajos
# ------------------------------------------------------------

CREATE TABLE `tipo_trabajos` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;



# Dump of table tolerancia_ejes
# ------------------------------------------------------------

CREATE TABLE `tolerancia_ejes` (
  `min_medida` int NOT NULL,
  `max_medida` int NOT NULL,
  `min_k5` int DEFAULT NULL,
  `max_k5` int DEFAULT NULL,
  `min_k6` int DEFAULT NULL,
  `max_k6` int DEFAULT NULL,
  `min_m5` int DEFAULT NULL,
  `max_m5` int DEFAULT NULL,
  `min_m6` int DEFAULT NULL,
  `max_m6` int DEFAULT NULL,
  `min_n5` int DEFAULT NULL,
  `max_n5` int DEFAULT NULL,
  `min_n6` int DEFAULT NULL,
  `max_n6` int DEFAULT NULL,
  `min_js5` int DEFAULT NULL,
  `max_js5` int DEFAULT NULL,
  `min_j5` int DEFAULT NULL,
  `max_j5` int DEFAULT NULL,
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;



# Dump of table tolerancias
# ------------------------------------------------------------

CREATE TABLE `tolerancias` (
  `min_medida` int NOT NULL,
  `max_medida` int NOT NULL,
  `min_K7` int DEFAULT NULL,
  `max_K7` int DEFAULT NULL,
  `min_H6` int DEFAULT NULL,
  `max_H6` int DEFAULT NULL,
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;



# Dump of table trabajos
# ------------------------------------------------------------

CREATE TABLE `trabajos` (
  `id_motor` int NOT NULL,
  `trabajo` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `cotizar` tinyint NOT NULL DEFAULT '1',
  `autorizado` tinyint NOT NULL DEFAULT '0',
  `fecha_autorizado` datetime DEFAULT NULL,
  `fecha_iniciado` datetime DEFAULT NULL,
  `fecha_finalizado` datetime DEFAULT NULL,
  `precio_compra` double(8,2) DEFAULT NULL,
  `precio_venta` double(8,2) DEFAULT NULL,
  `place_order` int DEFAULT NULL,
  `progress` int NOT NULL DEFAULT '0',
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=63966 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;



# Dump of table unidades
# ------------------------------------------------------------

CREATE TABLE `unidades` (
  `id` int NOT NULL AUTO_INCREMENT,
  `unidad` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;



# Dump of table user_types
# ------------------------------------------------------------

CREATE TABLE `user_types` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;



# Dump of table users
# ------------------------------------------------------------

CREATE TABLE `users` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `username` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `userType` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `foto` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `activo` tinyint NOT NULL DEFAULT '0',
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `id_cliente` int DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_username_unique` (`username`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=72 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;



# Dump of table usuarios
# ------------------------------------------------------------

CREATE TABLE `usuarios` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `id_user` int NOT NULL,
  `nombre` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `segundo_nombre` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `apellido` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `segundo_apellido` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `fecha_nacimiento` date DEFAULT NULL,
  `fecha_ingreso` date DEFAULT NULL,
  `dpi` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `igss` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `telefono` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `domicilio` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `estado_civil` tinyint DEFAULT NULL,
  `conyugue` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `puesto` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `departamento` tinyint DEFAULT NULL,
  `no_cuenta` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `banco` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `activo` tinyint DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=35 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;



# Dump of table vehiculos
# ------------------------------------------------------------

CREATE TABLE `vehiculos` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tipo` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `placa` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;




/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
