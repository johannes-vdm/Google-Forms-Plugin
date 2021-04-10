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
    echo '<div class="wrap">Google Forms Customizer</div>';
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

        print_r($_POST);

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
<form action="https://docs.google.com/forms/d/e/1FAIpQLSfgHydE9zOpVm39S7mG_Bh6O3fjZnJ58i2DfFz8vcBYYxoQIw/formResponse"
    target="_self"
    id="bootstrapForm"
    method="POST">
  <fieldset>
      <h2>Contact Information<br><small>fill</small></h2>
  </fieldset>


  <!-- Field type: "short" id: "1633920210" -->
  <fieldset>
      <legend for="1633920210">Name</legend>
      <div class="form-group">
          <input id="2005620554" type="text" name="entry.2005620554" class="form-control" required>
      </div>
  </fieldset>


  <!-- Field type: "short" id: "227649005" -->
  <fieldset>
      <legend for="227649005">Email</legend>
      <div class="form-group">
          <input id="1045781291" type="text" name="entry.1045781291" class="form-control" required>
      </div>
  </fieldset>


  <!-- Field type: "paragraph" id: "790080973" -->
  <fieldset>
      <legend for="790080973">Address</legend>
      <div class="form-group">
          <textarea id="1065046570" name="entry.1065046570" class="form-control" required></textarea>
      </div>
  </fieldset>


  <!-- Field type: "short" id: "1770822543" -->
  <fieldset>
      <legend for="1770822543">Phone number</legend>
      <div class="form-group">
          <input id="1166974658" type="text" name="entry.1166974658" class="form-control" >
      </div>
  </fieldset>


  <!-- Field type: "paragraph" id: "1846923513" -->
  <fieldset>
      <legend for="1846923513">Comments</legend>
      <div class="form-group">
          <textarea id="839337160" name="entry.839337160" class="form-control" ></textarea>
      </div>
  </fieldset>

  <input type="hidden" name="fvv" value="1">
  <input type="hidden" name="fbzx" value="5620262948632809141">

  <input type="hidden" name="pageHistory" value="0">

  <input class="btn btn-primary" type="submit" value="Submit">
</form>;
*/
