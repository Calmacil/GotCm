-- -----------------------------------------
-- This file is a part of the GotCm project.
-- author: Calmacil
-- version: 1.0
-- -----------------------------------------

-- Drops
DROP TABLE IF EXISTS `unit`;
DROP TABLE IF EXISTS `house_wealth`;
DROP TABLE IF EXISTS `domain_defense`;
DROP TABLE IF EXISTS `domain_land`;
DROP TABLE IF EXISTS `domain`;
DROP TABLE IF EXISTS `unit_type`;
DROP TABLE IF EXISTS `speciality`;
DROP TABLE IF EXISTS `skill`;
DROP TABLE IF EXISTS `land_asset`;
DROP TABLE IF EXISTS `wealth_asset`;
DROP TABLE IF EXISTS `defense_asset`;
DROP TABLE IF EXISTS `house`;
DROP TABLE IF EXISTS `crown`;

SET CHARSET utf8;

-- Structure tables
CREATE TABLE `crown` (
  `id` TINYINT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `name` VARCHAR(32) NOT NULL,
  `small_name` VARCHAR(12) NOT NULL,
  `base_color` VARCHAR(7) NOT NULL DEFAULT '#000000',
  `leader_house` TINYINT(1) DEFAULT 0,
  `defense_bonus` TINYINT NOT NULL DEFAULT 0,
  `influence_bonus` TINYINT NOT NULL DEFAULT 0,
  `law_bonus` TINYINT NOT NULL DEFAULT 0,
  `population_bonus` TINYINT NOT NULL DEFAULT 0,
  `power_bonus` TINYINT NOT NULL DEFAULT 0,
  `wealth_bonus` TINYINT NOT NULL DEFAULT 0,
  `land_bonus` TINYINT NOT NULL DEFAULT 0
)ENGINE InnoDB;

CREATE TABLE `house` (
  `id` SMALLINT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `crown_id` TINYINT UNSIGNED NOT NULL,
  `family_name` VARCHAR(32) NOT NULL,
  `family_subname` VARCHAR(32) DEFAULT NULL,
  `color_mod` ENUM('lightest','lighter','light','normal','dark','darker','darkest') DEFAULT 'normal',
  `max_status` TINYINT UNSIGNED NOT NULL DEFAULT 4,
  `defense` SMALLINT UNSIGNED NOT NULL DEFAULT 1,
  `influence` SMALLINT UNSIGNED NOT NULL DEFAULT 1,
  `law` SMALLINT UNSIGNED NOT NULL DEFAULT 1,
  `population` SMALLINT UNSIGNED NOT NULL DEFAULT 1,
  `power` SMALLINT UNSIGNED NOT NULL DEFAULT 1,
  `wealth` SMALLINT UNSIGNED NOT NULL DEFAULT 1,
  `land` SMALLINT UNSIGNED NOT NULL DEFAULT 1,
  `indendance_bonus` TINYINT NOT NULL DEFAULT 0,
  `coat_of_arms` TINYTEXT DEFAULT NULL,
  `coat_of_arms_img` VARCHAR(64) DEFAULT NULL,
  `words` VARCHAR(256) DEFAULT NULL,
  CONSTRAINT `f_house_crown` FOREIGN KEY (`crown_id`) REFERENCES `crown`(`id`)
)ENGINE InnoDB;

CREATE TABLE `defense_asset` (
  `id` TINYINT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `name` VARCHAR(32) NOT NULL,
  `cost` TINYINT UNSIGNED NOT NULL DEFAULT 0,
  `min_ttb` TINYINT UNSIGNED NOT NULL DEFAULT 0,
  `max_ttb` TINYINT UNSIGNED NOT NULL DEFAULT 0,
  `units_capacity` TINYINT UNSIGNED NOT NULL DEFAULT 0,
  `units_defense` TINYINT UNSIGNED NOT NULL DEFAULT 0,
  `description` TINYTEXT DEFAULT NULL
) ENGINE InnoDB;

CREATE TABLE `wealth_asset` (
  `id` TINYINT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `name` VARCHAR(32) NOT NULL,
  `cost` TINYINT UNSIGNED NOT NULL DEFAULT 0,
  `min_ttb` TINYINT UNSIGNED NOT NULL DEFAULT 0,
  `max_ttb` TINYINT UNSIGNED NOT NULL DEFAULT 0,
  `intendance_bonus` TINYINT UNSIGNED NOT NULL DEFAULT 0,
  `description` TINYTEXT DEFAULT NULL
) ENGINE InnoDB;

CREATE TABLE `land_asset` (
  `id` TINYINT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `name` VARCHAR(32) NOT NULL,
  `cost` TINYINT UNSIGNED NOT NULL DEFAULT 0,
  `type` ENUM('Terrain','Bois','Cours d’eau', 'Île', 'Localité','Autre')
);

CREATE TABLE `skill` (
  `id` TINYINT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `name` VARCHAR(32)
)ENGINE InnoDB;

CREATE TABLE `speciality` (
  `id`     TINYINT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
  skill_id TINYINT UNSIGNED NOT NULL,
  `name`   VARCHAR(32)      NOT NULL,
  CONSTRAINT `f_speciality_skill` FOREIGN KEY (skill_id) REFERENCES `skill`(`id`)
)ENGINE InnoDB;

CREATE TABLE `unit_type` (
  `id` TINYINT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `name` VARCHAR(32) NOT NULL,
  `cost_mod` TINYINT UNSIGNED NOT NULL DEFAULT 0,
  `population_cost` TINYINT NOT NULL DEFAULT 0,
  `wealth_cost` TINYINT NOT NULL DEFAULT 0,
  `discipline_mod` TINYINT NOT NULL DEFAULT 0,
  `skill_1` TINYINT UNSIGNED NOT NULL,
  `skill_2` TINYINT UNSIGNED NOT NULL,
  `skill_3` TINYINT UNSIGNED NOT NULL,
  `armor` TINYINT NOT NULL DEFAULT 0,
  `armor_malus` TINYINT NOT NULL DEFAULT 0,
  `encumbrance` TINYINT NOT NULL DEFAULT 0,
  `melee_damage_skill` TINYINT NOT NULL,
  `melee_damage_mod` TINYINT NOT NULL,
  `dist_damage_skill` TINYINT DEFAULT NULL,
  `dist_damage_mod` TINYINT DEFAULT NULL,
  `dist_range` enum('n/a','courte portée','longue portée'),
  `armor_upg` TINYINT NOT NULL DEFAULT 0,
  `armor_malus_upg` TINYINT NOT NULL DEFAULT 0,
  `encumbrance_upg` TINYINT NOT NULL DEFAULT 0,
  `melee_damage_mod_upg` TINYINT NOT NULL,
  `dist_damage_mod_upg` TINYINT DEFAULT NULL,
  CONSTRAINT `f_unit_type_skill1` FOREIGN KEY (`skill_1`) REFERENCES `skill`(`id`),
  CONSTRAINT `f_unit_type_skill2` FOREIGN KEY (`skill_2`) REFERENCES `skill`(`id`),
  CONSTRAINT `f_unit_type_skill3` FOREIGN KEY (`skill_3`) REFERENCES `skill`(`id`)
) ENGINE InnoDB;

-- CONSTRAINT `f_unit_type_melee` FOREIGN KEY (`melee_damage_skill`) REFERENCES `skill`(`id`)

CREATE TABLE `domain` (
  `id` MEDIUMINT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `house_id` SMALLINT UNSIGNED NOT NULL,
  `name` VARCHAR(32) DEFAULT NULL,
  `terrain` TINYINT UNSIGNED NOT NULL,
  `pos_row` TINYINT UNSIGNED NOT NULL DEFAULT 0,
  `pos_col` TINYINT UNSIGNED NOT NULL DEFAULT 0,
  `description` TEXT,
  CONSTRAINT `f_domain_house` FOREIGN KEY (`house_id`) REFERENCES `house`(`id`),
  CONSTRAINT `f_domain_terrain` FOREIGN KEY (`terrain`) REFERENCES `land_asset`(`id`)
) ENGINE InnoDB;

CREATE TABLE `domain_land` (
  `id`       INT UNSIGNED       NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `domain_id`  MEDIUMINT UNSIGNED NOT NULL,
  `id_asset` TINYINT UNSIGNED   NOT NULL,
  `name`     VARCHAR(32) DEFAULT NULL,
  CONSTRAINT `fk_domland_domain` FOREIGN KEY (`domain_id`) REFERENCES `domain`(`id`),
  CONSTRAINT `fk_domland_land` FOREIGN KEY (`id_asset`) REFERENCES `land_asset`(`id`)
) ENGINE InnoDB;

CREATE TABLE `domain_defense` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `domain_id` MEDIUMINT UNSIGNED NOT NULL,
  `asset_id` TINYINT UNSIGNED NOT NULL,
  `remaining_time` TINYINT NOT NULL DEFAULT 0,
  CONSTRAINT FOREIGN KEY (`domain_id`) REFERENCES `domain`(`id`),
  CONSTRAINT FOREIGN KEY (`asset_id`) REFERENCES `defense_asset`(`id`)
) ENGINE InnoDB;

CREATE TABLE `house_wealth` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `asset_id` TINYINT UNSIGNED NOT NULL,
  `house_id` SMALLINT UNSIGNED NOT NULL,
  `domain_id` MEDIUMINT UNSIGNED DEFAULT NULL,
  `remaining_time` TINYINT NOT NULL DEFAULT 0,
  CONSTRAINT FOREIGN KEY (`domain_id`) REFERENCES `domain`(`id`),
  CONSTRAINT FOREIGN KEY (`house_id`) REFERENCES `house`(`id`),
  CONSTRAINT FOREIGN KEY (`asset_id`) REFERENCES `wealth_asset`(`id`)
) ENGINE InnoDB;

CREATE TABLE `unit` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `type_id` TINYINT UNSIGNED NOT NULL,
  `house_id` SMALLINT UNSIGNED NOT NULL,
  `name` VARCHAR(32) DEFAULT NULL,
  `skill_1_value` TINYINT DEFAULT 2,
  `skill_2_value` TINYINT DEFAULT 2,
  `skill_3_value` TINYINT DEFAULT 2,
  `armor_upg` TINYINT DEFAULT 0,
  `melee_upg` TINYINT DEFAULT 0,
  `dist_upg` TINYINT DEFAULT 0,
  `xp_spent` TINYINT UNSIGNED DEFAULT 0,
  CONSTRAINT FOREIGN KEY (`type_id`) REFERENCES `unit_type`(`id`),
  CONSTRAINT FOREIGN KEY (`house_id`) REFERENCES `house`(`id`)
) ENGINE InnoDB;