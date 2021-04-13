<?php
//$FormID = 1; //INCREMENT IN FUTURE WITH FOR LOOP IF $FORMID NOT FOUND THEN $FORMID + 1;
//global $wpdb;
//$allposts = $wpdb->get_results("SELECT * FROM " . $wpdb->prefix . "GoogleForms", ARRAY_A);

if (!defined('ABSPATH'))
  exit;

global $wpdb;




add_action('wp_enqueue_scripts', 'load_ss');




function load_ss()
{
  wp_enqueue_script(
    'CustomGoogleFormTimer',
    plugin_dir_url(__FILE__) . 'js/timer.js',
    array('jquery'),
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

    /*  $jsHTML = '<div class="container">
    <form class="form">
 
      <input type="number" min="1" class="time-input" placeholder="Enter Countdown">
   
      <button type="submit" class="set-btn">SET</button>
    </form>
    <p class="countdown">00 : 00 : 00</p>
    <div class="buttons">
      <button class="stop-btn" disabled>STOP</button>
      <button class="reset-btn" disabled>RESET</button>
    </div>
  </div>';*/
    // echo "CHARLES";
    //echo "HERE ARE THE SECONDS" . $seconds;
    $jsHTML = '<div><h1>OVER HERE</h1></div><div class="CountdownTime" data-value=' . $seconds . '></div>';

    return $htmlConverted . $jsHTML;
  }
}
