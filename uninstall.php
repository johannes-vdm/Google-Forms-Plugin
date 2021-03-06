<?php
if (!defined('WP_UNINSTALL_PLUGIN')) {
    die;
}

register_uninstall_hook(__FILE__, 'pluginprefix_function_to_run');

$settingOptions = array('plugin_status', 'export_status', 'notifications', 'label_settings');

if (!defined('WP_UNINSTALL_PLUGIN')) exit();
global $wpdb;
$wpdb->query("DROP TABLE IF EXISTS `{$wpdb->prefix}GoogleForms`");

foreach ($settingOptions as $settingName) {
    delete_option($settingName);
}
