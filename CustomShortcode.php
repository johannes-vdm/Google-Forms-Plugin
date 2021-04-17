<?php
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

function ReadyForm()
{
  $ready = '<iframe id=”hs-form-iframe-0″ class=”hs-form-iframe” scrolling=”no” style=”position: static; border: none; display: block; overflow: hidden; width: 690px; height: 969px;” height=”969″ width=”690″>

  <div class=”hs_submit hs-submit” data-reactid=”.hbspt-forms-0.5″><div class=”hs-field-desc” style=”display:none;” data-reactid=”.hbspt-forms-0.5.0″></div><div class=”actions” data-reactid=”.hbspt-forms-0.5.1″><input type=”submit” value=”Submit” class=”hs-button primary large” data-reactid=”.hbspt-forms-0.5.1.0″></div></div>
  
  </iframe>
  
  <script>
  jQuery(‘#hs-form-iframe-0’).ready(function(){
  
  jQuery(‘#hs-form-iframe-0’).contents()
  .find(‘.hs-button’).on(‘click’, function() {
  alert(‘ok’);
  });
  });
  </script>';
  //<form action="" method="post" id="ReadyForm" enctype="multipart/form-data">
  //  <input id="ReadyBtn" type="submit" name="ReadyCheck" value="Ready">
  //</form>';
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

if (!empty($_COOKIE["JSCountdown"])) {
  echo "I am alive";
}
