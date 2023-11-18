-- Adminer 4.8.1 MySQL 8.0.35-0ubuntu0.22.04.1 dump

SET NAMES utf8;
SET time_zone = '+00:00';
SET foreign_key_checks = 0;
SET sql_mode = 'NO_AUTO_VALUE_ON_ZERO';

SET NAMES utf8mb4;

DROP TABLE IF EXISTS `tg_files`;
CREATE TABLE `tg_files` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `file_id` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_520_ci NOT NULL COMMENT 'Telegram file ID',
  `md5_sum` binary(16) NOT NULL,
  `sha1_sum` binary(20) NOT NULL,
  `file_type` varchar(32) COLLATE utf8mb4_unicode_520_ci NOT NULL DEFAULT 'unknown',
  `extension` varchar(32) COLLATE utf8mb4_unicode_520_ci NOT NULL,
  `size` bigint unsigned NOT NULL,
  `hit_count` bigint unsigned NOT NULL DEFAULT '1',
  `description` text COLLATE utf8mb4_unicode_520_ci,
  `created_at` datetime NOT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `md5_sum` (`md5_sum`),
  KEY `sha1_sum` (`sha1_sum`),
  KEY `file_type` (`file_type`),
  KEY `extension` (`extension`),
  KEY `size` (`size`),
  KEY `hit_count` (`hit_count`),
  KEY `created_at` (`created_at`),
  KEY `updated_at` (`updated_at`),
  KEY `telegram_file_id` (`file_id`),
  FULLTEXT KEY `description` (`description`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_520_ci;


DROP TABLE IF EXISTS `tg_group_messages`;
CREATE TABLE `tg_group_messages` (
  `id` bigint NOT NULL AUTO_INCREMENT,
  `group_id` bigint unsigned NOT NULL COMMENT 'Foreign key to tg_groups.id',
  `user_id` bigint unsigned NOT NULL COMMENT 'Foreign key to tg_users.id',
  `tmsg_id` bigint unsigned NOT NULL COMMENT 'Telegram message ID',
  `reply_to_tmsg_id` bigint unsigned DEFAULT NULL,
  `msg_type` varchar(32) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT 'unknown',
  `text` text COLLATE utf8mb4_unicode_520_ci,
  `text_entities` json DEFAULT NULL,
  `file` bigint unsigned DEFAULT NULL,
  `is_edited` enum('0','1') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT '0',
  `tmsg_datetime` datetime DEFAULT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `group_id` (`group_id`),
  KEY `file` (`file`),
  KEY `user_id` (`user_id`),
  KEY `tmsg_id` (`tmsg_id`),
  KEY `reply_to_tmsg_id` (`reply_to_tmsg_id`),
  KEY `msg_type` (`msg_type`),
  KEY `is_edited` (`is_edited`),
  KEY `tmsg_datetime` (`tmsg_datetime`),
  KEY `created_at` (`created_at`),
  KEY `updated_at` (`updated_at`),
  FULLTEXT KEY `text` (`text`),
  CONSTRAINT `tg_group_messages_ibfk_4` FOREIGN KEY (`group_id`) REFERENCES `tg_groups` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `tg_group_messages_ibfk_5` FOREIGN KEY (`file`) REFERENCES `tg_files` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  CONSTRAINT `tg_group_messages_ibfk_6` FOREIGN KEY (`user_id`) REFERENCES `tg_users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_520_ci;


DROP TABLE IF EXISTS `tg_group_messages_edit`;
CREATE TABLE `tg_group_messages_edit` (
  `id` bigint NOT NULL AUTO_INCREMENT,
  `msg_id` bigint NOT NULL COMMENT 'Foreign key to tg_group_messages.id',
  `text` text COLLATE utf8mb4_unicode_520_ci,
  `text_entities` json DEFAULT NULL,
  `file` bigint unsigned DEFAULT NULL,
  `tmsg_datetime` datetime DEFAULT NULL,
  `created_at` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `msg_id` (`msg_id`),
  KEY `file` (`file`),
  KEY `tmsg_datetime` (`tmsg_datetime`),
  KEY `created_at` (`created_at`),
  FULLTEXT KEY `text` (`text`),
  CONSTRAINT `tg_group_messages_edit_ibfk_3` FOREIGN KEY (`msg_id`) REFERENCES `tg_group_messages` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `tg_group_messages_edit_ibfk_4` FOREIGN KEY (`file`) REFERENCES `tg_files` (`id`) ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_520_ci;


DROP TABLE IF EXISTS `tg_groups`;
CREATE TABLE `tg_groups` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `group_id` bigint NOT NULL COMMENT 'Telegram group ID (can be negative)',
  `name` varchar(255) COLLATE utf8mb4_unicode_520_ci NOT NULL,
  `username` varchar(72) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `link` varchar(128) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `photo` bigint unsigned DEFAULT NULL,
  `msg_count` bigint unsigned NOT NULL DEFAULT '0',
  `description` text COLLATE utf8mb4_unicode_520_ci,
  `welcome_msg` bigint unsigned DEFAULT NULL,
  `captcha` varchar(32) COLLATE utf8mb4_unicode_520_ci DEFAULT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `group_id` (`group_id`),
  KEY `welcome_msg` (`welcome_msg`),
  KEY `name` (`name`),
  KEY `username` (`username`),
  KEY `link` (`link`),
  KEY `photo` (`photo`),
  KEY `created_at` (`created_at`),
  KEY `updated_at` (`updated_at`),
  CONSTRAINT `tg_groups_ibfk_3` FOREIGN KEY (`photo`) REFERENCES `tg_files` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  CONSTRAINT `tg_groups_ibfk_4` FOREIGN KEY (`welcome_msg`) REFERENCES `tg_files` (`id`) ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_520_ci;


DROP TABLE IF EXISTS `tg_groups_histroy`;
CREATE TABLE `tg_groups_histroy` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `group_id` bigint unsigned NOT NULL COMMENT 'Foreign key to tg_groups.id',
  `name` varchar(255) COLLATE utf8mb4_unicode_520_ci NOT NULL,
  `username` varchar(72) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `link` varchar(128) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `photo` bigint unsigned DEFAULT NULL,
  `description` text COLLATE utf8mb4_unicode_520_ci,
  `created_at` datetime NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `link` (`link`),
  KEY `group_id` (`group_id`),
  KEY `photo` (`photo`),
  KEY `name` (`name`),
  KEY `username` (`username`),
  KEY `created_at` (`created_at`),
  FULLTEXT KEY `description` (`description`),
  CONSTRAINT `tg_groups_histroy_ibfk_5` FOREIGN KEY (`group_id`) REFERENCES `tg_groups` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `tg_groups_histroy_ibfk_6` FOREIGN KEY (`photo`) REFERENCES `tg_files` (`id`) ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_520_ci;


DROP TABLE IF EXISTS `tg_private_messages`;
CREATE TABLE `tg_private_messages` (
  `id` bigint NOT NULL AUTO_INCREMENT,
  `user_id` bigint unsigned NOT NULL COMMENT 'Foreign key to tg_users.id',
  `tmsg_id` bigint unsigned NOT NULL COMMENT 'Telegram message ID',
  `reply_to_tmsg_id` bigint unsigned DEFAULT NULL,
  `msg_type` varchar(32) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT 'unknown',
  `text` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_520_ci,
  `text_entities` json DEFAULT NULL,
  `file` bigint unsigned DEFAULT NULL,
  `is_edited` enum('0','1') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT '0',
  `tmsg_datetime` datetime DEFAULT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `file` (`file`),
  KEY `user_id` (`user_id`),
  KEY `tmsg_id` (`tmsg_id`),
  KEY `reply_to_tmsg_id` (`reply_to_tmsg_id`),
  KEY `msg_type` (`msg_type`),
  KEY `is_edited` (`is_edited`),
  KEY `tmsg_datetime` (`tmsg_datetime`),
  KEY `created_at` (`created_at`),
  KEY `updated_at` (`updated_at`),
  FULLTEXT KEY `text` (`text`),
  CONSTRAINT `tg_private_messages_ibfk_5` FOREIGN KEY (`file`) REFERENCES `tg_files` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  CONSTRAINT `tg_private_messages_ibfk_6` FOREIGN KEY (`user_id`) REFERENCES `tg_users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_520_ci;


DROP TABLE IF EXISTS `tg_private_messages_edit`;
CREATE TABLE `tg_private_messages_edit` (
  `id` bigint NOT NULL AUTO_INCREMENT,
  `msg_id` bigint NOT NULL COMMENT 'Foreign key to tg_private_messages.id',
  `text` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_520_ci,
  `text_entities` json DEFAULT NULL,
  `file` bigint unsigned DEFAULT NULL,
  `tmsg_datetime` datetime DEFAULT NULL,
  `created_at` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `msg_id` (`msg_id`),
  KEY `file` (`file`),
  KEY `tmsg_datetime` (`tmsg_datetime`),
  KEY `created_at` (`created_at`),
  FULLTEXT KEY `text` (`text`),
  CONSTRAINT `tg_private_messages_edit_ibfk_3` FOREIGN KEY (`msg_id`) REFERENCES `tg_private_messages` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `tg_private_messages_edit_ibfk_4` FOREIGN KEY (`file`) REFERENCES `tg_files` (`id`) ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_520_ci;


DROP TABLE IF EXISTS `tg_users`;
CREATE TABLE `tg_users` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint unsigned NOT NULL COMMENT 'Telegram user ID',
  `username` varchar(72) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `first_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_520_ci NOT NULL,
  `last_name` varchar(255) COLLATE utf8mb4_unicode_520_ci NOT NULL,
  `photo` bigint unsigned DEFAULT NULL,
  `is_bot` enum('0','1') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT '0',
  `bio` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci,
  `group_msg_count` bigint unsigned NOT NULL DEFAULT '0',
  `private_msg_count` bigint unsigned NOT NULL DEFAULT '0',
  `created_at` datetime NOT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `user_id` (`user_id`),
  KEY `username` (`username`),
  KEY `first_name` (`first_name`),
  KEY `last_name` (`last_name`),
  KEY `is_bot` (`is_bot`),
  KEY `group_msg_count` (`group_msg_count`),
  KEY `private_msg_count` (`private_msg_count`),
  KEY `created_at` (`created_at`),
  KEY `updated_at` (`updated_at`),
  KEY `photo` (`photo`),
  CONSTRAINT `tg_users_ibfk_2` FOREIGN KEY (`photo`) REFERENCES `tg_files` (`id`) ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_520_ci;

INSERT INTO `tg_users` (`id`, `user_id`, `username`, `first_name`, `last_name`, `photo`, `is_bot`, `bio`, `group_msg_count`, `private_msg_count`, `created_at`, `updated_at`) VALUES
(2,	243692601,	'ammarfaizi2',	'Ammar',	'Faizi',	NULL,	'0',	'Drinking strawberry milk.',	0,	0,	'2023-11-18 22:21:40',	NULL);

DROP TABLE IF EXISTS `tg_users_history`;
CREATE TABLE `tg_users_history` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint unsigned NOT NULL COMMENT 'Foreign key to tg_users.id',
  `username` varchar(72) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `first_name` varchar(255) COLLATE utf8mb4_unicode_520_ci NOT NULL,
  `last_name` varchar(255) COLLATE utf8mb4_unicode_520_ci DEFAULT NULL,
  `photo` bigint unsigned DEFAULT NULL,
  `bio` text COLLATE utf8mb4_unicode_520_ci,
  `created_at` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `username` (`username`),
  KEY `first_name` (`first_name`),
  KEY `last_name` (`last_name`),
  KEY `photo` (`photo`),
  KEY `created_at` (`created_at`),
  KEY `user_id` (`user_id`),
  CONSTRAINT `tg_users_history_ibfk_3` FOREIGN KEY (`user_id`) REFERENCES `tg_users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `tg_users_history_ibfk_4` FOREIGN KEY (`photo`) REFERENCES `tg_files` (`id`) ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_520_ci;


-- 2023-11-18 22:22:59
