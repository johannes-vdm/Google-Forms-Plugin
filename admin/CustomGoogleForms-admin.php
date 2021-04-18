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

    // add_submenu_page(
    //     //'google-forms',
    //     //'CSS',
    //     //'CSS',
    //     //'manage_options',
    //     //'css',
    //     //'sub_add',
    // );
}

add_action('admin_menu', 'custom_google_forms');

function google_forms_redirect()
{
    echo "HELLO";
}

function sub_callback()
{
?>
    <form method="POST">
        <div>
            <label>Name your form:
                <div><input type="text" name="formName" required></input></div>
            </label>
        </div>
        <div>
            <label>Paste Google form sharing URL & copy HTML from: <a href="https://stefano.brilli.me/google-forms-html-exporter" target="_blank">Google Forms Converter</a></label>
        </div>
        <div>
            <textarea name="googleFormConverted" rows="10" cols="70" required></textarea>
        </div>
        <label>Additional CSS(not required)</label>
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

        //NOTE check form name for uniqueness.
        $formName = $_POST['formName'];

        $wpdb->insert(
            $table_name,
            array(
                'formName' => $_POST['formName'],
                'convertedFormHTML' => $_POST['googleFormConverted'],
                'customCSS' => $_POST['customCSS'],
                'timer' => $_POST['Timer'],
                'shortcode' => '[GoogleForm snippet=' . $formName . ']'
                //[GoogleForm snippet="1"]
            )
        );
    }
}

function sub_add()
{
    ?>

    <label>Your Custom CSS</label>
    <div>
        <textarea name="customCSS" rows="10" cols="70"></textarea>
    </div>

    <label>Your Custom CSS</label>
    <div>
        <textarea name="customCSS" rows="10" cols="70"></textarea>
    </div>
<?php
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

    add_action('load-' . $setting, 'simple_css_scripts');
}


function simple_css_scripts()
{
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
{
    $options    = get_option('simple_css');
    $css = isset($options['css']) ? strip_tags($options['css']) : '';
    $theme = isset($options['theme']) ? $options['theme'] : '';

    if ('' == $theme) {
        $theme = 1;
    }

    if (1 == $theme) {
        $theme_name = 'ambiance';
    } else {
        $theme_name = 'default';
    }
?>

    <div class="wrap" id="poststuff">
        <?php settings_errors(); ?>
        <div id="post-body" class="simple-css metabox-holder columns-2">
            <form action="options.php" method="post">
                <div id="post-body-content">
                    <?php settings_fields('simple_css'); ?>
                    <div class="simple-css-container" data-theme="<?php echo $theme_name; ?>">
                        <textarea name="simple_css[css]" id="simple-css-textarea"><?php echo $css; ?></textarea>
                    </div>
                </div>

                <div id="postbox-container-1" class="postbox-container simple-css-sidebar">
                    <div>
                        <?php submit_button(__('Save CSS', 'simple-css'), 'primary large simple-css-save'); ?>

                    </div>
                </div>
            </form>
        </div>
    </div>
<?php
}


function simple_css_validate($input)
{
    $input['css'] = strip_tags($input['css']);
    $input['theme'] = sanitize_text_field($input['theme']);
    return $input;
}

add_action('customize_register', 'simple_css_customize');

function simple_css_customize($wp_customize)
{
    require_once(plugin_dir_path(__FILE__) . 'customize/css-control.php');

    $wp_customize->add_section(
        'simple_css_section',
        array(
            'title'       => __('Simple CSS', 'simple-css'),
            'priority'    => 200,
        )
    );

    $wp_customize->add_setting(
        'simple_css[css]',
        array(
            'type'              => 'option',
            'capability'        => 'edit_theme_options',
            'sanitize_callback' => 'simple_css_sanitize_css',
            'transport'            => 'postMessage',
        )
    );
}

add_action('customize_preview_init', 'simple_css_live_preview');
/**
 * Add our live preview.
 *
 * @since 1.0
 */
function simple_css_live_preview()
{
    wp_enqueue_script('simple-css-live-preview', trailingslashit(plugin_dir_url(__FILE__)) . 'js/live-preview.js', array('customize-preview'), null, true);
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
        $output .= get_post_meta(get_the_ID(), '_simple_css', true);
    }

    if ('' == $output) {
        return;
    }

    $output = str_replace(array("\r", "\n"), '', $output);
    $output = preg_replace('/\s+/', ' ', $output);


    echo '<style type="text/css" id="simple-css-output">';
    echo strip_tags($output);
    echo '</style>';
}

add_action('add_meta_boxes', 'simple_css_metabox');

function simple_css_metabox()
{

    $allowed = apply_filters('simple_css_metabox_capability', 'activate_plugins');

    if (!current_user_can($allowed)) {
        return;
    }

    $args = array('public' => true);
    $post_types = get_post_types($args);
    foreach ($post_types as $type) {
        add_meta_box(
            'simple_css_metabox',
            __('Simple CSS', 'simple-css'),
            'simple_css_show_metabox',
            $type,
            'normal',
            'default'
        );
    }
}

function simple_css_show_metabox($post)
{
    wp_nonce_field(basename(__FILE__), 'simple_css_nonce');
    $options = get_post_meta($post->ID);
    $css = isset($options['_simple_css']) ? $options['_simple_css'][0] : false;
?>
    <p>
        <textarea style="width:100%;height:300px;" name="_simple_css" id="simple-css-textarea"><?php echo strip_tags($css); ?></textarea>
    </p>
<?php
}

add_action('save_post', 'simple_css_save_metabox');

function simple_css_save_metabox($post_id)
{
    $is_autosave = wp_is_post_autosave($post_id);
    $is_revision = wp_is_post_revision($post_id);
    $is_valid_nonce = (isset($_POST['simple_css_nonce']) && wp_verify_nonce($_POST['simple_css_nonce'], basename(__FILE__))) ? true : false;

    if ($is_autosave || $is_revision || !$is_valid_nonce) {
        return;
    }

    if (isset($_POST['_simple_css']) && $_POST['_simple_css'] !== '') {
        update_post_meta($post_id, '_simple_css', strip_tags($_POST['_simple_css']));
    } else {
        delete_post_meta($post_id, '_simple_css');
    }
}
