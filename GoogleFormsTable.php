<?php
register_activation_hook(__FILE__, 'on_activate');

function on_activate()
{
    global $wpdb;
    $create_table_query = "
    CREATE TABLE IF NOT EXISTS `{$wpdb->prefix}GoogleForms` (
        `formID` INT(11) NOT NULL AUTO_INCREMENT COMMENT 'NOT REQUIRED, AU_I',
        `dateTimePosted` TIMESTAMP NOT NULL DEFAULT current_timestamp() COMMENT 'GENERATED',
        `formName` VARCHAR(50) NOT NULL COMMENT 'REQUIRED' COLLATE 'utf8mb4_general_ci',
        `timer` INT(11) NULL DEFAULT '0' COMMENT 'MINUTES, NOT REQUIRED, DEFAULT 0',
        `convertedFormHTML` MEDIUMTEXT NOT NULL COMMENT 'REQUIRED' COLLATE 'utf8mb4_general_ci',
        `shortcode` TEXT NOT NULL COMMENT 'GENERATED FROM formName' COLLATE 'utf8mb4_general_ci',
        PRIMARY KEY (`formID`) USING BTREE,
        UNIQUE INDEX `formName` (`formName`) USING BTREE
    )
    COLLATE='utf8mb4_general_ci'
    ENGINE=InnoDB";
    //NOTE REMOVED AUTO_INCREMENT=0

    require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
    dbDelta($create_table_query);
}

/*
   CREATE TABLE IF NOT EXISTS `{$wpdb->prefix}GoogleForms` (
	`formID` INT(11) NOT NULL AUTO_INCREMENT COMMENT 'NOT REQUIRED, AU_I',
	`dateTimePosted` TIMESTAMP NOT NULL DEFAULT current_timestamp() COMMENT 'GENERATED',
	`formName` VARCHAR(50) NOT NULL COMMENT 'REQUIRED' COLLATE 'utf8mb4_general_ci',
	`timer` INT(11) NULL DEFAULT '0' COMMENT 'MINUTES, NOT REQUIRED, DEFAULT 0',
	`convertedFormHTML` MEDIUMTEXT NOT NULL COMMENT 'REQUIRED' COLLATE 'utf8mb4_general_ci',
	`shortcode` TEXT NOT NULL COMMENT 'GENERATED FROM formName' COLLATE 'utf8mb4_general_ci',
	PRIMARY KEY (`formID`) USING BTREE,
	UNIQUE INDEX `formName` (`formName`) USING BTREE
)
COLLATE='utf8mb4_general_ci'
ENGINE=InnoDB
AUTO_INCREMENT=0
;

*/
