<?php


//$FormID = 1; //INCREMENT IN FUTURE WITH FOR LOOP IF $FORMID NOT FOUND THEN $FORMID + 1;


//global $wpdb;

//$allposts = $wpdb->get_results("SELECT * FROM " . $wpdb->prefix . "GoogleForms", ARRAY_A);

if (!defined('ABSPATH'))
    exit;

global $wpdb;


add_shortcode('GoogleForm', 'GoogleForm_display_content');
//[GoogleForm snippet="1"]
function GoogleForm_display_content($shortcode_class)
{

    global $wpdb;

    //if (is_array($shortcode_class) && isset($shortcode_class['snippet'])) {

    $shortcode_name = $shortcode_class['snippet'];


    //$query = $wpdb->get_results($wpdb->prepare("SELECT * FROM " . $wpdb->prefix . "GoogleForms WHERE formName=%s", $shortcode_name));


    $query = "SELECT * FROM " . $wpdb->prefix . "GoogleForms WHERE '$shortcode_name' = formName";
    //$initialize = $wpdb->get_results($wpdb->prepare("SELECT * FROM " . $wpdb->prefix . "GoogleForms WHERE //formName=%s", $shortcode_name));

    $result = $wpdb->get_results($query);

    global $wpdb;


    foreach ($result as $values) {

        $htmlConverted = $values->convertedFormHTML;
        return $htmlConverted;
    }
}
