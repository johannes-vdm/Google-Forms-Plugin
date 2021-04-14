<?php

if (!defined('ABSPATH'))
  exit;

global $wpdb;

add_action('wp_enqueue_scripts', 'load_ss');

function load_ss()
{
  wp_enqueue_script(
    'CustomGoogleFormTimer',
    plugin_dir_url(__FILE__) . 'js/timer.js',
    '1.0',
    false
  );
}


add_shortcode('GoogleForm', 'GoogleForm_display_content');

function GoogleForm_display_content($shortcode_class)
{

  global $wpdb;

  $shortcode_name = $shortcode_class['snippet'];

  $query = "SELECT * FROM " . $wpdb->prefix . "GoogleForms WHERE '$shortcode_name' = formName";

  $result = $wpdb->get_results($query);

  foreach ($result as $values) {

    $htmlConverted = $values->convertedFormHTML;
    $seconds = $values->timer;

    $jsHTML = '<div><h4 class="CountdownTime" value=' . $seconds . '>00:00:00</h4></div>';

    return $htmlConverted . $jsHTML;
  }
}
