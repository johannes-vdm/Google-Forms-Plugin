<?php
//=======CLEAR COOKIES HERE + REFRESH PAGES A FEW TIMES=====
  #setcookie("readyCheck", "", time() - 3600);
  #$readyCheck='';
  #setcookie("ReturnedShortcodeCookie", "", time() - 3600);
//==========================================================

if (isset($_COOKIE['ReturnedShortcodeCookie'])) {
  $ReturnedShortcodeCookie = $_COOKIE['ReturnedShortcodeCookie'];
  unset($_COOKIE['ReturnedShortcodeCookie']);
  setcookie('ReturnedShortcodeCookie', null, -1, '/');
}

if (isset($_COOKIE['readyCheck'])) {
  $ReadyCheck = $_COOKIE['readyCheck'];
  setcookie("readyCheck", "", time() - 3600);
}


include(ABSPATH . "wp-includes/pluggable.php");

//ANCHOR currentURL()

  global $wp;
  $currentURL = home_url($_SERVER['REQUEST_URI']);


//ANCHOR currentUserEmail()
function currentUserEmail()
{
  global $current_user;
  wp_get_current_user();
  return $email = (string) $current_user->user_email;
}

if (isset($ReturnedShortcodeCookie)) {

  global $wpdb;

  $table_name = $wpdb->prefix . "googleformscomplete";

  $current_user = wp_get_current_user();
  $current_email = $current_user->user_email;

  if (is_user_logged_in()) {

    $URL = home_url($_SERVER['REQUEST_URI']);
    $wpdb->insert(
      $table_name,
      array(
        'UserEmail' => $current_email,
        'FormCompleted' => $ReturnedShortcodeCookie,
        'URL' => $currentURL
      )
    );
  }
}

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

//ANCHOR currentURL()
//ANCHOR currentUserEmail()
global $wpdb;
$query = "SELECT 'true' FROM " . $wpdb->prefix . "googleformscomplete WHERE '" . (currentUserEmail()) . "' = UserEmail AND URL = '" . $currentURL . "' ORDER BY TIMESTAMP DESC LIMIT 1";
$result = $wpdb->get_results($query);
foreach ($result as $values) {
  $userCompleted = $values->true;
}

if (is_user_logged_in()) {
  if (isset($userCompleted)) {
    add_shortcode('GoogleForm', 'CompletedForm');
    //NOTE You have completed this quiz
  } else if (isset($ReadyCheck)){
    //NOTE Person left
    add_shortcode('GoogleForm', 'CompletedForm');
  }
    else {
    add_shortcode('GoogleForm', 'ReadyForm');
    //NOTE You will be redirected. Ready?
  } 

} else {
  add_shortcode('GoogleForm', 'NotLoggedIn');
  //NOTE You are not logged in.
}

function ReadyForm($shortcode_class)
{
  $shortcode_name = $shortcode_class['snippet'];
  $ready = '<div id="Shortcodegrab" value="' . $shortcode_name . '"></div>
<div id="readyBox">
  <h3>You will be redirected to a form and have a quiz.</h3>
  <form action="" method="post" id="ReadyBtn">
    <input id="ReadyBtn" type="submit" name="ReadyCheck" value="Ready" />
  </form>
</div>';

  return $ready;
}

if (isset($_POST['ReadyCheck'])) {
  add_shortcode('GoogleForm', 'GoogleForm_display_content');
  setcookie("readyCheck","true");
}

function CompletedForm($shortcode_class)
{
  $shortcode_name = $shortcode_class['snippet'];
  $completed = '<div id="shrtcode" value="' . $shortcode_name . '">
  <div id="readyBox">
    <h3>You have completed this quiz.</h3>
  </div>';

  return $completed;
}

function NotLoggedIn($shortcode_class)
{
  $shortcode_name = $shortcode_class['snippet'];
  $notLoggedin = '<div id="shrtcode" value="' . $shortcode_name . '">
    <div id="readyBox">
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
      return '<div id="currentUserEmail" value="'.currentUserEmail().'"></div><div id="shrtcode" value="' . $shortcode_name . '">
      <div class="CompleteGoogleForm">' . $htmlConverted . '</div>';
    } else if ($seconds !== 0) {
      $jsHTML = '<div id="CountdownContainer">
        <h4 class="CountdownTime" value=' . $seconds . '>00:00:00</h4>
      </div>';
      return '<div id="currentUserEmail" value="'.currentUserEmail().'"></div><div id="shrtcode" value="' . $shortcode_name . '">
        <div class="CompleteGoogleForm"></div>' . $htmlConverted . '
      </div>' . $jsHTML;
    }
  }
}

