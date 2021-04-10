<?php
register_activation_hook(__FILE__, 'on_activate');

function on_activate()
{
    global $wpdb;
    $create_table_query = "
    CREATE TABLE IF NOT EXISTS `{$wpdb->prefix}GoogleForms` (
        `formID` INT NOT NULL AUTO_INCREMENT COMMENT 'NOT REQUIRED, AU_I',
        `dateTimePosted` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP(),
        `customCSS` TEXT NULL DEFAULT NULL COMMENT 'NOT REQUIRED, DEFAULT NULL',
        `formName` VARCHAR(50) NULL COMMENT 'REQUIRED',
        `timer` INT NULL DEFAULT 0 COMMENT 'MINUTES, NOT REQUIRED, DEFAULT 0',
        `convertedFormHTML` MEDIUMTEXT NULL COMMENT 'REQUIRED',
        PRIMARY KEY (`formID`),
        UNIQUE INDEX `formName` (`formName`)
    ) ENGINE=MyISAM  DEFAULT CHARSET=utf8;
    ";
    require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
    dbDelta($create_table_query);
}



/*
//remove prefix
CREATE TABLE `wp_GoogleForms` (
	`formID` INT NOT NULL AUTO_INCREMENT COMMENT 'NOT REQUIRED, AU_I',
	`dateTimePosted` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP(),
	`customCSS` TEXT NULL DEFAULT NULL COMMENT 'NOT REQUIRED, DEFAULT NULL',
	`formName` VARCHAR(50) NULL COMMENT 'REQUIRED',
	`timer` INT NULL DEFAULT 0 COMMENT 'MINUTES, NOT REQUIRED, DEFAULT 0',
	`convertedFormHTML` MEDIUMTEXT NULL COMMENT 'REQUIRED',
	PRIMARY KEY (`formID`),
	UNIQUE INDEX `formName` (`formName`)
)
COLLATE='utf8mb4_general_ci'
;

*/
