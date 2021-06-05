CREATE DATABASE `csv_parser` /*!40100 COLLATE 'utf8_general_ci' */;

CREATE TABLE `apl_appel` (
    `apl_id` BIGINT(20) UNSIGNED NOT NULL AUTO_INCREMENT,
    `apl_date` DATE NULL DEFAULT NULL,
    `apl_heure` TIME NULL DEFAULT NULL,
    `apl_duree_reelle` FLOAT UNSIGNED NULL DEFAULT NULL,
    `apl_duree_facture` FLOAT UNSIGNED NULL DEFAULT NULL,
    `apl_numero_abonne` BIGINT(20) UNSIGNED NULL DEFAULT NULL,
    `apl_type` ENUM('SMS','AUTRES') NOT NULL COLLATE 'utf8_general_ci',
    PRIMARY KEY (`apl_id`) USING BTREE,
    INDEX `numero_abonne` (`apl_numero_abonne`) USING BTREE
) COLLATE='utf8_general_ci' ENGINE=MyISAM AUTO_INCREMENT=1;