-- phpMyAdmin SQL Dump
-- version 4.0.10.12
-- http://www.phpmyadmin.net
--
-- Хост: kbkarat.mysql.ukraine.com.ua
-- Время создания: Янв 27 2017 г., 09:44
-- Версия сервера: 5.6.27-75.0-log
-- Версия PHP: 5.6.28

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- База данных: `kbkarat_rmt`
--

--
-- Структура таблицы `auth_tokens`
--

CREATE TABLE IF NOT EXISTS `auth_tokens` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `selector` varchar(12) NOT NULL,
  `token` varchar(64) NOT NULL,
  `userid` int(11) NOT NULL,
  `expires` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `userid` (`userid`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=21 ;

-- --------------------------------------------------------

--
-- Структура таблицы `hubs`
--

CREATE TABLE IF NOT EXISTS `hubs` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `hub_id` varchar(45) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `customer_id` int(11) DEFAULT NULL,
  `installation_date` timestamp NULL DEFAULT NULL,
  `installation_city` varchar(64) DEFAULT NULL,
  `installation_street` varchar(64) DEFAULT NULL,
  `installation_house_number` varchar(45) DEFAULT NULL,
  `firmware_status` enum('0','1') DEFAULT NULL,
  `sms_notifications` enum('0','1') DEFAULT NULL,
  `inventory_number` varchar(45) DEFAULT NULL,
  `installer_name` varchar(45) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `hub_id` (`hub_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=19 ;

-- --------------------------------------------------------

--
-- Структура таблицы `logs`
--

CREATE TABLE IF NOT EXISTS `logs` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `hub_id` varchar(45) COLLATE utf8_unicode_ci DEFAULT NULL,
  `temperature` float DEFAULT NULL,
  `event_time` varchar(45) COLLATE utf8_unicode_ci DEFAULT NULL,
  `position` varchar(45) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `hub_id_position` (`hub_id`,`position`),
  KEY `created_at` (`created_at`),
  KEY `hub_id` (`hub_id`,`position`),
  KEY `createdat` (`created_at`),
  FULLTEXT KEY `position` (`position`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1247274 ;

-- --------------------------------------------------------

--
-- Структура таблицы `options`
--

CREATE TABLE IF NOT EXISTS `options` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `hub_id` varchar(45) COLLATE utf8_unicode_ci DEFAULT NULL,
  `hw_version` varchar(45) COLLATE utf8_unicode_ci DEFAULT NULL,
  `fw_version` varchar(45) COLLATE utf8_unicode_ci DEFAULT NULL,
  `ap_ssid` varchar(45) COLLATE utf8_unicode_ci DEFAULT NULL,
  `ap_password` varchar(45) CHARACTER SET utf8 DEFAULT NULL,
  `sta_ssid` varchar(45) COLLATE utf8_unicode_ci DEFAULT NULL,
  `sta_password` varchar(45) COLLATE utf8_unicode_ci DEFAULT NULL,
  `license_key` varchar(45) COLLATE utf8_unicode_ci DEFAULT NULL,
  `time` timestamp NULL DEFAULT NULL,
  `last_time_update` timestamp NULL DEFAULT NULL,
  `last_dispatch` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=60 ;

-- --------------------------------------------------------

--
-- Структура таблицы `setpoints`
--

CREATE TABLE IF NOT EXISTS `setpoints` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `hub_id` varchar(45) COLLATE utf8_unicode_ci DEFAULT NULL,
  `thermometer_position` int(11) DEFAULT NULL,
  `themperature` float DEFAULT NULL,
  `setpoint_themperature` float DEFAULT NULL,
  `setpoint_type` enum('min','max') COLLATE utf8_unicode_ci DEFAULT NULL,
  `event_time` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=811687 ;

-- --------------------------------------------------------

--
-- Структура таблицы `sms`
--

CREATE TABLE IF NOT EXISTS `sms` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `hub_id` varchar(45) COLLATE utf8_unicode_ci DEFAULT NULL,
  `position` int(11) DEFAULT NULL,
  `phone` varchar(45) CHARACTER SET utf8 DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=24 ;

-- --------------------------------------------------------

--
-- Структура таблицы `sms_log`
--

CREATE TABLE IF NOT EXISTS `sms_log` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `hub_id` varchar(45) COLLATE utf8_unicode_ci DEFAULT NULL,
  `position` varchar(45) COLLATE utf8_unicode_ci DEFAULT NULL,
  `message` text COLLATE utf8_unicode_ci,
  `phone` varchar(45) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=583 ;

-- --------------------------------------------------------

--
-- Структура таблицы `thermometers`
--

CREATE TABLE IF NOT EXISTS `thermometers` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `hub_id` varchar(45) COLLATE utf8_unicode_ci DEFAULT NULL,
  `name` varchar(45) CHARACTER SET utf8 DEFAULT 'No name',
  `setpoint_min` float DEFAULT NULL,
  `setpoint_max` float DEFAULT NULL,
  `zero_correction` float NOT NULL DEFAULT '0',
  `sms_timeout` int(11) NOT NULL DEFAULT '30',
  `status` enum('Online','Offline','Deleted') CHARACTER SET utf8 DEFAULT NULL,
  `position` int(11) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `fk_HubTherm` (`hub_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=215 ;

-- --------------------------------------------------------

--
-- Структура таблицы `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `login` varchar(45) NOT NULL,
  `password` varchar(120) NOT NULL,
  `email` varchar(64) NOT NULL,
  `first_name` varchar(45) DEFAULT NULL,
  `last_name` varchar(45) DEFAULT NULL,
  `phone` varchar(45) DEFAULT NULL,
  `group_name` enum('god','superadmin','admin','technician','superuser','user') NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `login_UNIQUE` (`login`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=28 ;

--
-- Ограничения внешнего ключа сохраненных таблиц
--

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
