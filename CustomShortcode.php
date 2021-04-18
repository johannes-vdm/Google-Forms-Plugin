<?php

add_action('wp_loaded', 'register_ajax_handlers');

function register_ajax_handlers()
{
  add_action('wp_ajax_jp_ajax_request', 'jp_ajax_process');
  add_action('wp_ajax_nopriv_jp_ajax_request', 'jp_ajax_process');
}

add_action('wp_enqueue_scripts', 'load_au');
add_action('wp_enqueue_scripts', 'load_tj');

function load_au()
{
  wp_enqueue_script(
    'GoogleFormSubmitAuto',
    plugin_dir_url(__FILE__) . 'js/GoogleSubmitAjax.js',
    array('jquery')
  );
}

function load_tj()
{
  wp_enqueue_script(
    'CustomGoogleFormTimer',
    plugin_dir_url(__FILE__) . 'js/timer.js',
    '1.0',
    false
  );
}

if (!defined('ABSPATH'))
  exit;

global $wpdb;

add_shortcode('GoogleForm', 'ReadyForm');

function add_to_header()
{
  wp_enqueue_script('GoogleFormSubmitAuto');
}
add_action('wp_enqueue_scripts', 'add_to_header');

function ReadyForm()
{
  $ready = '<h3>You will be redirected to a form and have a quiz.</h3>
  <form action="" method="post" id="ReadyBtn">
      <input id="ReadyBtn" type="submit" name="ReadyCheck" value="Ready" />
  </form>
</div>';

  return $ready;
}

if (isset($_POST['ReadyCheck'])) {
  add_shortcode('GoogleForm', 'GoogleForm_display_content');
}

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
