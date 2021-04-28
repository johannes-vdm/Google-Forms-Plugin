<?php

/**
 * @package Custom GoogleForms Plugin
 * Plugin Name: CustomGoogleForms-Plugin
 * Description: Google Form Plugin Development
 * Author: Johannes van der Merwe
 * Version: 1.0.0
 * Licence: GPL2v2 or later 
 * Text Domain: CustomGoogleForms-Plugin
 */

defined('ABSPATH') or die('No access.');

require_once(plugin_dir_path(__FILE__) . 'CustomShortcode.php');
require_once(plugin_dir_path(__FILE__) . 'GoogleFormsTable.php');
require_once(plugin_dir_path(__FILE__) . 'admin/CustomGoogleForms-admin.php');

//NOTE add error checking
add_action('activated_plugin', 'my_save_error');
function my_save_error()
{
    file_put_contents(dirname(__file__) . '/error_activation.txt', ob_get_contents());
}
