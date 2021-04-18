<?php

/**
 * @package Custom GoogleForms Plugin
 * Plugin Name: CustomGoogleForms-Plugin
 * Plugin URI: https://webdd.co.za
 * Description: Google Form Plugin Development
 * Author: Johannes van der Merwe
 * Version: 1.0.0
 * Licence: GPL2v2 or later 
 * Text Domain: CustomGoogleForms-Plugin
 */

defined('ABSPATH') or die('No access.');

require_once(plugin_dir_path(__FILE__) . 'CustomShortcode.php');
require_once(plugin_dir_path(__FILE__) . 'GoogleFormsTable.php');
require_once(plugin_dir_path(__FILE__) . 'admin\CustomGoogleForms-admin.php');
