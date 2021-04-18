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
    'GoogleFormSubmitAuto', // name your script so that you can attach other scripts and de-register, etc.
    plugin_dir_url(__FILE__) . 'js/GoogleSubmitAjax.js', // this is the location of your script file
    array('jquery') // this array lists the scripts upon which your script depends
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

//////////////////////////////////////////

/**
 * Make sure jquery is loaded
 */
function add_to_header()
{
  wp_enqueue_script('GoogleFormSubmitAuto');
}
add_action('wp_enqueue_scripts', 'add_to_header');


/**
 * Add shortcode to show form and script
 */



////////////////////////////////////////

function ReadyForm()
{
  $ready = '<h3>You will be redirected to a form and have a quiz.</h3>
  <form action="" method="post" id="ReadyBtn">
      <input id="ReadyBtn" type="submit" name="ReadyCheck" value="Submit" />
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
  //$cloudflareJQUERY = '<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js" integrity="sha256-hwg4gsxgFZhOsEEamdOYGBf13FyQuiTwlAQgxVSNgt4=" crossorigin="anonymous"></script><script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.form/4.2.2/jquery.form.min.js" integrity="sha256-2Pjr1OlpZMY6qesJM68t2v39t+lMLvxwpa8QlRjJroA=" crossorigin="anonymous"></script>';

  foreach ($result as $values) {
    $htmlConverted = $values->convertedFormHTML;
    $seconds = $values->timer;

    $jQuery = '<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js" type="text/javascript"></script>';

    $jsHTML = '<div><h4 class="CountdownTime" value=' . $seconds . '>00:00:00</h4></div>';
    return $htmlConverted . $jQuery . $jsHTML;
  }
}
