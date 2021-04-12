<?php
on_activate();

function custom_google_forms()
{
    add_menu_page(
        'Google Forms',
        'Google Forms',
        'administrator',
        'google-forms',
        'google_forms_redirect',
        'dashicons-google'
    );

    add_submenu_page(
        'google-forms',
        'Add new',
        'Add new',
        'manage_options',
        'add_new',
        'sub_callback',
    );
}



add_action('admin_menu', 'custom_google_forms');


function google_forms_redirect()
{
    echo "HELLO";
    global $wpdb;
    $table_name = $wpdb->prefix . "GoogleForms";
}

function sub_callback()
{
?>
    <form method="POST">
        <div>
            <label>Name your form:
                <div><input type="text" name="formName"></input></div>
            </label>
        </div>
        <div>
            <label>Paste Google form sharing URL & copy HTML from: <a href="https://stefano.brilli.me/google-forms-html-exporter" target="_blank">Google Forms Converter</a></label>
        </div>
        <div>
            <textarea name="googleFormConverted" rows="10" cols="70"></textarea>
        </div>
        <label>Custom CSS</label>
        <div>
            <textarea name="customCSS" rows="10" cols="70"></textarea>
        </div>
        <div>
            <label>Timer Length in <b>Seconds</b> (0 for no timer)</label>
        </div>
        <div>
            <input type="number" name="Timer" value="0">
        </div>

        <input type="submit" value="Submit">
    </form>
<?php


    if (isset($_POST["googleFormConverted"])) {

        //print_r($_POST);

        global $wpdb;

        $table_name = $wpdb->prefix . "GoogleForms";

        //check form name for uniqueness.
        $formName = $_POST['formName'];

        $wpdb->insert(
            $table_name,
            array(
                'formName' => $_POST['formName'],
                'convertedFormHTML' => $_POST['googleFormConverted'],
                'customCSS' => $_POST['customCSS'],
                'timer' => $_POST['Timer'],
                'shortcode' => "[GoogleForm snippet=" . $formName . "]"
                //[GoogleForm snippet="1"]
            )
        );
    }
}
