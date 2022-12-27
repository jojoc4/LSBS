-- Adminer 4.8.1 MySQL 5.5.5-10.9.4-MariaDB-1:10.9.4+maria~ubu2204 dump

SET NAMES utf8;
SET time_zone = '+00:00';
SET foreign_key_checks = 0;
SET sql_mode = 'NO_AUTO_VALUE_ON_ZERO';

SET NAMES utf8mb4;

CREATE DATABASE `bench` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci */;
USE `bench`;

CREATE TABLE `benchmark` (
  `id_bench` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(30) NOT NULL,
  PRIMARY KEY (`id_bench`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO `benchmark` (`id_bench`, `name`) VALUES
(1,	'HPCC'),
(2,	'FIO'),
(3,	'IPerf'),
(4,	'Blender'),
(5,	'DB'),
(6,	'DL'),
(7,	'Rest');

CREATE TABLE `system` (
  `id_system` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `cpu` text NOT NULL,
  `memory` text NOT NULL,
  `disk` text NOT NULL,
  `network` text NOT NULL,
  `gpu` text NOT NULL,
  `uuid` text NOT NULL,
  PRIMARY KEY (`id_system`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;


CREATE TABLE `target` (
  `id_target` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `system` int(10) unsigned NOT NULL,
  `ip` text NOT NULL,
  PRIMARY KEY (`id_target`),
  KEY `system` (`system`),
  CONSTRAINT `target_ibfk_1` FOREIGN KEY (`system`) REFERENCES `system` (`id_system`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;


CREATE TABLE `type` (
  `id_type` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `category` smallint(5) unsigned NOT NULL,
  `name` varchar(60) NOT NULL,
  PRIMARY KEY (`id_type`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;


CREATE TABLE `job` (
  `id_job` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `target` int(10) unsigned NOT NULL,
  `type` int(10) unsigned NOT NULL,
  `nb_run` int(10) unsigned NOT NULL,
  `status` smallint(5) unsigned NOT NULL DEFAULT 0,
  `benchmark` int(10) unsigned NULL,
  PRIMARY KEY (`id_job`),
  KEY `target` (`target`),
  KEY `type` (`type`),
  CONSTRAINT `job_ibfk_1` FOREIGN KEY (`target`) REFERENCES `target` (`id_target`),
  CONSTRAINT `job_ibfk_2` FOREIGN KEY (`type`) REFERENCES `type` (`id_type`),
  CONSTRAINT `job_ibfk_3` FOREIGN KEY (`benchmark`) REFERENCES `benchmark` (`id_bench`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;


CREATE TABLE `results` (
  `id_result` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `system` int(10) unsigned NOT NULL,
  `type` int(10) unsigned NOT NULL,
  `result` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL CHECK (json_valid(`result`)),
  `time` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `benchmark` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id_result`),
  KEY `system` (`system`),
  KEY `type` (`type`),
  KEY `benchmark` (`benchmark`),
  CONSTRAINT `results_ibfk_1` FOREIGN KEY (`system`) REFERENCES `system` (`id_system`),
  CONSTRAINT `results_ibfk_2` FOREIGN KEY (`type`) REFERENCES `type` (`id_type`),
  CONSTRAINT `results_ibfk_3` FOREIGN KEY (`benchmark`) REFERENCES `benchmark` (`id_bench`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;




INSERT INTO `type` (`id_type`, `category`, `name`) VALUES
(1,	1,	'bare-metal'),
(2,	2,	'Docker on bare-metal'),
(3,	3,	'k8s(containerd) on bare-metal'),
(4,	1,	'VM(Proxmox) on bare-metal'),
(5,	1,	'LXC(Proxmox) on bare-metal'),
(6,	2,	'Docker on VM(Proxmox) on bare-metal'),
(7,	3,	'k8s(containerd) on VM(Proxmox) on bare-metal'),
(8,	1,	'VM(VMWare) on bare-metal'),
(9,	2,	'Docker on VM(VMWare) on bare-metal'),
(10,	3,	'k8s(containerd) on VM(VMWare) on bare-metal'),
(11,	1,	'VM(XCP-ng) on bare-metal'),
(12,	2,	'Docker on VM(XCP-ng) on bare-metal'),
(13,	3,	'k8s(containerd) on VM(XCP-ng) on bare-metal'),
(14,	1,	'VM(Hyper-V) on bare-metal'),
(15,	2,	'Docker on VM(Hyper-V) on bare-metal'),
(16,	3,	'k8s(containerd) on VM(Hyper-V) on bare-metal');

-- 2022-11-14 13:11:32
