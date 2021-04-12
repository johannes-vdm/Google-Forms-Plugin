<?php

/**
 * @package CustomGoogleForms-Plugin
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
on_activate();

function custom_google_forms()
{
    add_menu_page(
        "Google Forms",
        "Google Forms",
        "administrator",
        "google-forms",
        "google_forms_redirect",
        $icon_url = 'dashicons-google',
        $position = 4
    );
}
add_action('admin_menu', 'custom_google_forms');


function google_forms_redirect()
{
    //check form name for uniqueness.
    echo '<form method="POST"> 
    <div>
    <label>Name your form:
        <div><input type="text" name="formName"></input></div>
    </label>
    </div>
        <div>
            <label>Paste Google form sharing URL & copy HTML from: <a href="https://stefano.brilli.me/google-forms-html-exporter" target="_blank">Google Forms Converter</a></label>
        </div>
        <div>
            <textarea name="googleFormConverted"
            rows="10" cols="70"></textarea>
        </div>
        <label>Custom CSS</label>
        <div>
        <textarea name="customCSS"
        rows="10" cols="70"></textarea>
    </div>
        <div>
               <label>Timer Length in <b>Seconds</b> (0 for no timer)</label>
        </div>  
        <div>
               <input type="number" name="Timer" value="0">
        </div>   
          
            <input type="submit" value="Submit">
           </form>';

    if (isset($_POST["googleFormConverted"])) {

        //print_r($_POST);

        global $wpdb;

        $table_name = $wpdb->prefix . "GoogleForms";

        $wpdb->insert(
            $table_name,
            array(
                'formName' => $_POST["formName"],
                'convertedFormHTML' => $_POST['googleFormConverted'],
                'customCSS' => $_POST['customCSS'],
                'timer' => $_POST['Timer']
            )
        );
    }
}

/*
<html>
<form action="https://docs.google.com/forms/d/e/1FAIpQLSdjeZagH9IK7VqMNZR3dkX-DBQmK3XAfj42rzDWxMmiKpHzSw/formResponse" target="_self" id="bootstrapForm" method="POST">
    <fieldset>
        <h2>Party Invite<br><small>Test</small></h2>
    </fieldset>


    <!-- Field type: "choices" id: "1888537516" -->
    <fieldset>
        <legend for="1888537516"></legend>
        <div class="form-group">
            <div class="radio">
                <label>
                    <input type="radio" name="entry.399460587" value="Option 1">
                    Option 1
                </label>
            </div>
        </div>
    </fieldset>


    <!-- Field type: "short" id: "360421792" -->
    <fieldset>
        <legend for="360421792">What is your name?</legend>
        <div class="form-group">
            <input id="559352220" type="text" name="entry.559352220" class="form-control">
        </div>
    </fieldset>


    <!-- Field type: "choices" id: "1275419724" -->
    <fieldset>
        <legend for="1275419724">Can you attend?</legend>
        <div class="form-group">
            <div class="radio">
                <label>
                    <input type="radio" name="entry.877086558" value="Yes,  I&#x27;ll be there" required>
                    Yes, I&#x27;ll be there
                </label>
            </div>
            <div class="radio">
                <label>
                    <input type="radio" name="entry.877086558" value="Sorry, can&#x27;t make it" required>
                    Sorry, can&#x27;t make it
                </label>
            </div>
        </div>
    </fieldset>


    <!-- Field type: "short" id: "2124567779" -->
    <fieldset>
        <legend for="2124567779">How many of you are attending?</legend>
        <div class="form-group">
            <input id="924523986" type="text" name="entry.924523986" class="form-control" required>
        </div>
    </fieldset>


    <!-- Field type: "checkboxes" id: "234994015" -->
    <fieldset>
        <legend for="234994015">What will you be bringing?</legend>
        <div class="form-group">
            <p class="help-block">Let us know what kind of dish(es) you&#x27;ll be bringing</p>
            <div class="checkbox">
                <label>
                    <input type="checkbox" name="entry.186230675" value="Mains">
                    Mains
                </label>
            </div>
            <div class="checkbox">
                <label>
                    <input type="checkbox" name="entry.186230675" value="Salad">
                    Salad
                </label>
            </div>
            <div class="checkbox">
                <label>
                    <input type="checkbox" name="entry.186230675" value="Dessert">
                    Dessert
                </label>
            </div>
            <div class="checkbox">
                <label>
                    <input type="checkbox" name="entry.186230675" value="Drinks">
                    Drinks
                </label>
            </div>
            <div class="checkbox">
                <label>
                    <input type="checkbox" name="entry.186230675" value="Sides/Appetizers">
                    Sides/Appetizers
                </label>
            </div>
            <div class="checkbox">
                <label>
                    <input type="checkbox" name="entry.186230675" value="__other_option__">
                </label>
                <input type="text" name="entry.186230675.other_option_response" placeholder="custom value">
            </div>
        </div>
    </fieldset>


    <!-- Field type: "short" id: "120135225" -->
    <fieldset>
        <legend for="120135225">Do you have any allergies or dietary restrictions?</legend>
        <div class="form-group">
            <input id="1751303409" type="text" name="entry.1751303409" class="form-control">
        </div>
    </fieldset>


    <!-- Field type: "short" id: "1930256188" -->
    <fieldset>
        <legend for="1930256188">What is your email address?</legend>
        <div class="form-group">
            <input id="443565211" type="text" name="entry.443565211" class="form-control">
        </div>
    </fieldset>


    <!-- Field type: "section" id: "1827333776" -->
    <fieldset>
        <legend for="1827333776">NEW PAGE</legend>
        <div class="form-group">
        </div>
    </fieldset>


    <!-- Field type: "linear" id: "1519072917" -->
    <fieldset>
        <legend for="1519072917">AGE</legend>
        <div class="form-group">
            <div>
                <label class="radio-inline">
                    <input type="radio" name="entry.509282163" value="1">
                    1
                </label>
                <label class="radio-inline">
                    <input type="radio" name="entry.509282163" value="2">
                    2
                </label>
                <label class="radio-inline">
                    <input type="radio" name="entry.509282163" value="3">
                    3
                </label>
                <label class="radio-inline">
                    <input type="radio" name="entry.509282163" value="4">
                    4
                </label>
                <label class="radio-inline">
                    <input type="radio" name="entry.509282163" value="5">
                    5
                </label>
            </div>
            <div>
                <div>1: </div>
                <div>5: </div>
            </div>
        </div>
    </fieldset>


    <!-- Field type: "grid" id: "987379900" -->
    <fieldset>
        <legend for="987379900">backlit</legend>
        <div class="form-group">
            <div>
                <span>Row 1: </span>
                <label class="radio-inline">
                    <input type="radio" name="entry.2108237869" value="Column 1">
                    Column 1
                </label>
            </div>
        </div>
    </fieldset>

    <input type="hidden" name="fvv" value="1">
    <input type="hidden" name="fbzx" value="4334292585893045143">
    <!--
        CAVEAT: In multipages (multisection) forms, *pageHistory* field tells to google what sections we've currently completed.
        This usually starts as "0" for the first page, then "0,1" in the second page... up to "0,1,2..N" in n-th page.
        Keep this in mind if you plan to change this code to recreate any sort of multipage-feature in your exported form.
        We're setting this to the total number of pages in this form because we're sending all fields from all the section together.
    -->
    <input type="hidden" name="pageHistory" value="0,1">

    <input class="btn btn-primary" type="submit" value="Submit">
</form>

</html>
*/
