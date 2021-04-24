<?php

$settingOptions = array('plugin_status', 'export_status', 'notifications', 'label_settings');

if (!defined('WP_UNINSTALL_PLUGIN')) exit();
global $wpdb;
$wpdb->query("DROP TABLE IF EXISTS `{$wpdb->prefix}GoogleForms`");
$wpdb->query("DROP TABLE IF EXISTS `{$wpdb->prefix}googleformscomplete`");

foreach ($settingOptions as $settingName) {
    delete_option($settingName);
}
