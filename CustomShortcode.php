<?php

if (isset($_COOKIE['shortcodeCookie'])) {
  $ShortcodeCookie = $_COOKIE['shortcodeCookie'];
  unset($_COOKIE['shortcodeCookie']);
  setcookie('shortcodeCookie', null, -1, '/');
  echo "COOKIE EXIST";
}

include(ABSPATH . "wp-includes/pluggable.php");

if (isset($ShortcodeCookie)) {
  global $wpdb;
  $table_name = $wpdb->prefix . "googleformscomplete";

  $current_user = wp_get_current_user();
  $current_email = $current_user->user_email;

  $wpdb->insert(
    $table_name,
    array(
      'UserEmail' => $current_email,
      'FormCompleted' => $ShortcodeCookie
    )
  );
}

unset($_COOKIE['shortcodeCookie']);

add_action('wp_loaded', 'register_ajax_handlers');

function register_ajax_handlers()
{
  add_action('wp_ajax_jp_ajax_request', 'jp_ajax_process');
  add_action('wp_ajax_nopriv_jp_ajax_request', 'jp_ajax_process');
}

add_action('wp_enqueue_scripts', 'load_cs', 11);
add_action('wp_enqueue_scripts', 'load_au');
add_action('wp_enqueue_scripts', 'load_tj');

function load_cs()
{
  wp_register_style(
    'CustomFormStyle',
    plugin_dir_url(__FILE__) . "/styles/CustomGoogleForms.css"
  );
  wp_enqueue_style('CustomFormStyle');
}

function load_au()
{
  wp_register_script(
    'GoogleFormSubmitAuto',
    plugin_dir_url(__FILE__) . 'js/GoogleSubmitAjax.js',
    array('jquery')
  );
  wp_enqueue_script('GoogleFormSubmitAuto');
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

if (!defined('ABSPATH')) {
  exit;
}

function add_to_header()
{
  wp_enqueue_script('GoogleFormSubmitAuto');
}

include_once(ABSPATH . 'wp-includes/pluggable.php');

add_action('wp_enqueue_scripts', 'add_to_header');

$current_user = wp_get_current_user();
$currentUserEmail = $current_user->user_email;

if (isset($currentUserEmail)) {
?>
  <script type="text/javascript">
    var currentUserEmail = '<?php echo $currentUserEmail ?>'
  </script>
<?php
}

if (isset($ShortcodeCookie)) {

  global $wpdb;

  $query = "SELECT 'true' FROM " . $wpdb->prefix . "googleformscomplete WHERE '$currentUserEmail' = UserEmail AND FormCompleted IN ('$ShortcodeCookie') LIMIT 1";
  $result = $wpdb->get_results($query);

  //FIXME
  //FIXME
  //FIXME
  foreach ($result as $values) {
    $userCompleted = $values->true;
    echo $userCompleted;
    //FIXME
    //FIXME
    //FIXME
  }
}


if (is_user_logged_in()) {
  if (isset($userCompleted)) {
    add_shortcode('GoogleForm', 'CompletedForm');
  } else {
    add_shortcode('GoogleForm', 'ReadyForm');
  }
} else {
  add_shortcode('GoogleForm', 'NotLoggedIn');
}

function ReadyForm()
{
  $ready = '<div id="readyBox">
  <h3>You will be redirected to a form and have a quiz.</h3>
  <form action="" method="post" id="ReadyBtn">
    <input id="ReadyBtn" type="submit" name="ReadyCheck" value="Ready" />
  </form>
</div>';

  return $ready;
}

if (isset($_POST['ReadyCheck'])) {
  add_shortcode('GoogleForm', 'GoogleForm_display_content');
}

function CompletedForm()
{
  $completed = '<div id="readyBox">
  <h3>You have completed this quiz.</h3>
</div>';

  return $completed;
}

function NotLoggedIn()
{
  $notLoggedin = '<div id="readyBox">
  <h3>You are not logged in.</h3>
</div>';

  return $notLoggedin;
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

    if ($seconds == 0) {
      return '<div id="shrtcode" value=' . $shortcode_name . '><div class="CompleteGoogleForm">' . $htmlConverted . '</div></div>';
    } else if ($seconds !== 0) {
      $jsHTML = '<div id="CountdownContainer">
  <h4 class="CountdownTime" value=' . $seconds . '>00:00:00</h4>
</div>';
      return '<div id="shrtcode" value=' . $shortcode_name . '><div class="CompleteGoogleForm">' . $htmlConverted . '</div>' . $jsHTML . '</div>';
    }
  }
}
