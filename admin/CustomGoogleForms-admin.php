<?php
on_activate();

add_action('wp_enqueue_scripts', 'load_as', 11);

function load_as()
{
    wp_register_style(
        'CustomAdminMenu',
        plugin_dir_url(__FILE__) . "/styles/AdminMenu.css"
    );
    wp_enqueue_style('CustomAdminMenu');
}

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

if (isset($_POST['delete'])) {

    $SQLformID = $_POST['formID'];

    $wpdb->query(
        'DELETE FROM ' . $wpdb->prefix . 'googleforms
         WHERE formID = "' . $SQLformID . '"'
    );

    header('Location: ' . $_SERVER['HTTP_REFERER']);
}

add_action('admin_menu', 'custom_google_forms');

function google_forms_redirect()
{
    if (isset($_POST['edit'])) {

        $editID = $_POST['editID'];
        global $wpdb;

        $table_name = $wpdb->prefix . "GoogleForms";
        $initialize = 'SELECT * FROM ' . $table_name . ' WHERE ' . $editID . ' = formID';

        $result = $wpdb->get_results($initialize);

        foreach ($result as $values) {
            $formName = $values->formName;
            $ConvertedHTML = $values->convertedFormHTML;
            $timer = $values->timer;
        }

?>
        <form method="POST">
            <div class="wrap" id="poststuff">
                <div>
                    <h1>Edit Form:</h1>
                </div>
                <div>
                    <label>*Name your form:
                        <div><input type="text" name="formName" value="<?php echo $formName ?>" required></input></div>
                    </label>
                </div>
                <div>
                    <label>Paste Google form sharing URL & copy HTML from: <a href="https://stefano.brilli.me/google-forms-html-exporter" target="_blank">Google Forms Converter</a></label>
                    <label><b>Note: Please do not copy the Javascript</b></label><br>
                </div>
                <br>
                <div>
                    <span><b>If you would like the user's email to be autofilled with the logged in user's email, please add or replace class="emailAddress" in the user-email inputs in the HTML.<br></b>For Example:</span>
                    <span>
                        <pre><code>&ltinput id="011235" type="text" class="form-control"></code></pre>
                    </span><span>Changed to:</span><span>
                        <pre><code>&ltinput id="011235" type="text" class="emailAddress"></code></pre>
                    </span>
                </div>
                <div>
                    <span><b>Please add ("(required)" or "*") to all legends linked to all required inputs.<br></b>For Example:</span>
                    <br>
                    <span>
                        <pre><code>&ltlegend for="233464">Your name&lt/legend><br> &ltinput id="011235" type="text" class="form-control" required></code></pre>
                    </span>

                    <span>Changed to:</span>
                    <span>
                        <pre><code>&ltlegend for="233464">Your name(required)&lt/legend><br> &ltinput id="011235" type="text" class="form-control" required></code></pre>
                    </span>
                </div>
                <div>
                    <label for="editGoogleFormConverted">*required</label>
                </div>
                <div>
                    <textarea name="editGoogleFormConverted" rows="10" cols="120" required><?php echo $ConvertedHTML ?></textarea>
                </div>
                <div>
                    <label>*Timer Length in <b>Seconds</b> (0 for no timer)</label>
                </div>
                <div>
                    <input type="number" name="Timer" value="<?php echo $timer ?>" required>
                </div>
                <input type="hidden" value=<?php echo $_POST['editID'] ?> name="editID">
                <input type="submit" value="Submit" name="editSubmit">
            </div>
        </form>

        <?php

        $_POST = array_map('stripslashes_deep', $_POST);

        if (isset($_POST["googleFormConverted"])) {

            global $wpdb;

            $table_name = $wpdb->prefix . "GoogleForms";

            $formName = $_POST['formName'];

            $wpdb->insert(
                $table_name,
                array(
                    'formName' => $_POST['formName'],
                    'convertedFormHTML' => $_POST['googleFormConverted'],
                    'timer' => $_POST['Timer'],
                    'shortcode' => '[GoogleForm snippet=' . $formName . ']'
                    //NOTE [GoogleForm snippet=quizform1]
                )
            );
        }
    } else {
        if (isset($_POST["editSubmit"])) {

            $_POST = array_map('stripslashes_deep', $_POST);

            global $wpdb;
            $eID = $_POST['editID'];

            $editFormName = $_POST['formName'];
            $editConvertedHTML = $_POST['editGoogleFormConverted'];
            $editTimer =  $_POST['Timer'];

            $table_name = $wpdb->prefix . "GoogleForms";
            $shortcodeUpdate = '[GoogleForm snippet=' . $editFormName . ']';

            $wpdb->query(
                $wpdb->prepare(
                    "UPDATE {$table_name} SET formName = %s, timer = %d, convertedFormHTML = %s, shortcode = %s  WHERE formID=$eID",
                    $editFormName,
                    $editTimer,
                    $editConvertedHTML,
                    $shortcodeUpdate
                )
            );
        }
        ?>
        <div class="wrap">
            <a href=<?php
                    echo $menu_slug = "admin.php?page=add_new";
                    ". menu_page_url( string $menu_slug) . "
                    ?> "><button>Add New</button></a><br>
<?php
        global $wpdb;
        $query = " SELECT * FROM " . $wpdb->prefix . "GoogleForms";
        $result = $wpdb->get_results($query);
        function trimtext($text, $start, $len)
        {
            return substr($text, $start, $len);
        }
?>
        <table class=" DisplayAdminTable">
                <thead>
                    <tr>
                        <th scope="col">Form Name</th>
                        <th scope="col">Timer Seconds</th>
                        <th scope="col">Shortcode</th>
                        <th scope="col">Form HTML</th>
                        <th scope="col">Edit</th>
                        <th scope="col">Remove</th>
                    </tr>
                </thead>

                <?php
                foreach ($result as $values) {
                    $formID = $values->formID;
                    $formName = $values->formName;
                    $seconds = $values->timer;
                    $shortcode = $values->shortcode;
                    $htmlConverted = $values->convertedFormHTML;

                    $EDIT = '
                    <form action="" method="post" id="editForm" onsubmit="location.reload()">
                    <input type="hidden" name="editID" value="' . $formID . '">
                    <input type="submit" value="Edit" name="edit">
                    </form>';

                    $DELETE = '
                    <form action="" method="post" id="deleteForm" onsubmit="location.reload()">
                    <input type="hidden" name="formID" value="' . $formID . '">
                    <input type="submit" value="X" name="delete">
                    </form>';

                    $checkLengthHTML = strlen($htmlConverted);

                    if ($checkLengthHTML > 80) {
                        $dotdotdot = '...';
                    } else {
                        $dotdotdot = '';
                    }

                    $final = '<tr>' . '<td>' . $formName . '</td><td>' . $seconds . '</td><td>' . $shortcode . '</td><td>' .  trimtext(htmlspecialchars($htmlConverted), 0, 80) . $dotdotdot . '</td><td>' . $EDIT . '</td><td style="text-align: center;">' . $DELETE . '</td>' . '<tr>';

                    echo $final;
                }
                ?>

                </table>
            <?php
        }
    }
    function sub_callback()
    {
            ?>
            <form method="POST">
                <div class="wrap" id="poststuff">
                    <div>
                        <h1>Add Form:</h1>
                    </div>
                    <?php
                    if (isset($_POST["googleFormsADD"])) {
                        $Saved = '<div id="setting-error-settings_updated" class="notice notice-success settings-error is-dismissible">
            <p><strong>Settings saved.</strong></p><button type="button" class="notice-dismiss"><span class="screen-reader-text">Dismiss this notice.</span></button>
        </div>';

                        echo $Saved;
                    }
                    ?>
                    <div>
                        <label><b>*</b>Name your form:
                            <div><input type="text" name="formName" required></input></div>
                        </label>
                    </div>
                    <div>
                        <div>

                            <label>Paste Google form sharing URL & copy HTML from: <a href="https://stefano.brilli.me/google-forms-html-exporter" target="_blank">Google Forms Converter</a></label>
                            <label><b>Note: Please do not copy the Javascript</b></label><br>
                        </div>
                        <br>
                        <div>
                            <span><b>If you would like the user's email to be autofilled with the logged in user's email, please add or replace class="emailAddress" in the user-email inputs in the HTML.<br></b>For Example:</span>
                            <span>
                                <pre><code>&ltinput id="011235" type="text" class="form-control"></code></pre>
                            </span><span>Changed to:</span><span>
                                <pre><code>&ltinput id="011235" type="text" class="emailAddress"></code></pre>
                            </span>
                        </div>
                    </div>
                    <div>
                        <span><b>Please add ("(required)" or "*") to all legends linked to all required inputs.<br></b>For Example:</span>
                        <br>
                        <span>
                            <pre><code>&ltlegend for="233464">Your name&lt/legend><br> &ltinput id="011235" type="text" class="form-control" required></code></pre>
                        </span>

                        <span>Changed to:</span>
                        <span>
                            <pre><code>&ltlegend for="233464">Your name(required)&lt/legend><br> &ltinput id="011235" type="text" class="form-control" required></code></pre>
                        </span>
                    </div>
                    <div>
                        <label for="editGoogleFormConverted">*required</label>
                        <br>
                        <textarea name="googleFormConverted" rows="10" cols="120" required></textarea>
                    </div>
                    <div>
                        <label>*Timer Length in <b>Seconds</b> (0 for no timer)</label>
                    </div>
                    <div>
                        <input type="number" name="Timer" value="0" required>
                    </div>

                    <input type="submit" value="Submit" name="googleFormsADD">
            </form>
        </div>
        <?php

        $_POST = array_map('stripslashes_deep', $_POST);

        if (isset($_POST["googleFormsADD"])) {

            global $wpdb;

            $table_name = $wpdb->prefix . "GoogleForms";

            //TODO check form name for uniqueness.
            $formName = $_POST['formName'];

            $wpdb->insert(
                $table_name,
                array(
                    'formName' => $_POST['formName'],
                    'convertedFormHTML' => $_POST['googleFormConverted'],
                    'timer' => $_POST['Timer'],
                    'shortcode' => '[GoogleForm snippet=' . $formName . ']'
                    //NOTE [GoogleForm snippet="1"]
                )
            );
        }
    }

    add_action('admin_menu', 'CSSadmin_menu');

    function CSSadmin_menu()
    {
        $setting = add_submenu_page(
            'google-forms',
            'CSS',
            'CSS',
            'manage_options',
            'css',
            'css_editor'
        );
    }

    add_action('admin_init', 'css_register_setting');

    function css_register_setting()
    {
        register_setting(
            'simple_css',
            'simple_css',
            'simple_css_validate'
        );
    }

    function css_editor()
    //ANCHOR css admin inputs
    {

        $options    = get_option('simple_css');
        $css = isset($options['css']) ? strip_tags($options['css']) : '';
        ?>

        <div class="wrap" id="poststuff">
            <h1>Add your custom CSS:</h1>

            <?php settings_errors(); ?>
            <div id="post-body" class="simple-css metabox-holder columns-2">
                <form action="options.php" method="post">
                    <div id="post-body-content">
                        <?php settings_fields('simple_css'); ?>
                        <div class="simple-css-container">
                            <textarea name="simple_css[css]" id="css-textarea" rows="20" cols="70"><?php echo $css; ?></textarea>
                        </div>
                    </div>
                    <div>
                        <input type="submit" name="submit" id="submit" value="Save CSS">
                    </div>
                </form>
            </div>
        </div>
    <?php
    }

    function _validate($input)
    {
        $input['css'] = strip_tags($input['css']);
        $input['theme'] = sanitize_text_field($input['theme']);
        return $input;
    }

    add_action('customize_register', '_customize');

    function css_customize($wp_customize)
    {
        require_once(plugin_dir_path(__FILE__) . 'customize/css-control.php');

        $wp_customize->add_section(
            'simple_css_section',
            array(
                'title'       => __('Simple CSS', 'simple-css'),
                'priority'    => 200,
            )
        );
    }

    function simple_css_sanitize_css($input)
    {
        return strip_tags($input);
    }

    add_action('wp_head', 'simple_css_generate');

    function simple_css_generate()
    {
        $options = get_option('simple_css', array());
        $output = '';

        if (isset($options['css'])) {
            $output = $options['css'];
        }

        if (is_singular()) {
            $output .= get_post_meta(get_the_ID(), '_css', true);
        }

        if ('' == $output) {
            return;
        }
    }
