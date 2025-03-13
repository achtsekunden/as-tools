<?php
/*
Plugin Name: AS-Tools
Description: Adds more SEO tools and some helping functions to your theme: - Uninstall notes: Deactivate all checkboxes, then uninstall
Version: 0.2.14
Author: achtsekunden.com
Author URI: https://achtsekunden.com
*/

########### SCRIPTS ############

 // frontend scripts
function as_enqueue_custom_scripts() {
    if (!wp_script_is('jquery', 'enqueued')) {
        wp_enqueue_script('jquery');
    }
    //wp_register_script( 'as-tools-js', plugins_url('/assets/js/as_tools_scripts.js', __FILE__), array('jquery'), '2.5.1' );
    //wp_enqueue_style( 'as-tools-styles', plugins_url('/assets/css/as_tools_styles.css', __FILE__), false, '1.0.0', 'all');
}
add_action('wp_enqueue_scripts', 'as_enqueue_custom_scripts');

// AS Admin Styles + Scripts
function as_tools_admin_style(){
    // Get the plugin data
    $plugin_data = get_plugin_data( __FILE__ );
    $plugin_version = $plugin_data['Version']; // Get the plugin version

    wp_enqueue_style('as-admin-styles', plugins_url('/assets/css/as_tools_styles.css', __FILE__), false, $plugin_version, 'all');
    wp_enqueue_script('as-tools-admin-js', plugins_url('/assets/js/as_tools_admin.js', __FILE__), array('jquery'), $plugin_version, true);

    add_action('admin_footer', function() {
        echo '<script>console.log("Admin Footer Loaded - Checking Script!");</script>';
    });
}
add_action('admin_enqueue_scripts', "as_tools_admin_style");


// adding scripts to admin backend
function as_tools_enqueue_scripts($hook) {
    if ($hook !== 'toplevel_page_as-tools') {
        return;
    }

    // WordPress' eigenen CodeMirror-Stil und Skripte laden
    wp_enqueue_code_editor(array('type' => 'text/javascript'));
    wp_enqueue_script('wp-theme-plugin-editor');
    wp_enqueue_style('wp-codemirror');


    // Eigenes Skript für die Initialisierung von CodeMirror
    wp_add_inline_script('wp-theme-plugin-editor', '
        document.addEventListener("DOMContentLoaded", function() {
            const fields = ["as_header_script", "as_footer_script", "as_blockip_db"];
            fields.forEach(function(id) {
                let textarea = document.getElementById(id);
                if (textarea) {
                    wp.codeEditor.initialize(textarea, { mode: "javascript", lineNumbers: true });
                }
            });
        });
    ');
}
add_action('admin_enqueue_scripts', 'as_tools_enqueue_scripts');


########### ADMIN PAGE ############


// Add Admin Menu
function as_tools_add_menu() {
    add_menu_page(
        'AS-Tools',
        'AS-Tools',
        'manage_options',
        'as-tools',
        'as_tools_render_admin_page',
        'dashicons-admin-generic',
        100
    );
}
add_action('admin_menu', 'as_tools_add_menu');

########################## // Render Admin Page ################################

function as_tools_render_admin_page() {
    $active_tab = isset($_GET['tab']) ? $_GET['tab'] : 'general';
    // Get the plugin data (including the version number)
    $plugin_data = get_plugin_data( __FILE__ );
    $plugin_version = $plugin_data['Version']; // Get the plugin version
    ?>
    <div class="wrap wrap_as_tools">
        <h1>AS-Tools (<?php echo esc_html($plugin_version); ?>)</h1>
        <h2 class="nav-tab-wrapper">
            <a href="?page=as-tools&tab=general" class="nav-tab <?php echo $active_tab == 'general' ? 'nav-tab-active' : ''; ?>">General</a>
            <a href="?page=as-tools&tab=tools" class="nav-tab <?php echo $active_tab == 'tools' ? 'nav-tab-active' : ''; ?>">Tools</a>
            <a href="?page=as-tools&tab=performance" class="nav-tab <?php echo $active_tab == 'performance' ? 'nav-tab-active' : ''; ?>">Performance</a>
            <a href="?page=as-tools&tab=security" class="nav-tab <?php echo $active_tab == 'security' ? 'nav-tab-active' : ''; ?>">Security</a>
            <a href="?page=as-tools&tab=seo" class="nav-tab <?php echo $active_tab == 'seo' ? 'nav-tab-active' : ''; ?>">SEO</a>
            <a href="?page=as-tools&tab=advanced" class="nav-tab <?php echo $active_tab == 'advanced' ? 'nav-tab-active' : ''; ?>">Header | Footer</a>
            <a href="?page=as-tools&tab=serverinfo" class="nav-tab <?php echo $active_tab == 'serverinfo' ? 'nav-tab-active' : ''; ?>">Serverinfo</a>
        </h2>
        <form method="post" action="options.php" class="as_form_<?php echo $active_tab;?>">
            <?php
            settings_fields('as_tools_settings_' . $active_tab);

            do_settings_sections('as-tools-' . $active_tab);

            submit_button();
            ?>
        </form>
    </div>
    <?php
}

########################## // Register Settings ################################

function as_tools_register_settings() {

    ### ----------- Fields Tab General
    include_once plugin_dir_path(__FILE__) . 'include/as_tools_register_tab_general.php';

    ### ----------- Fields Tab Performance
    include_once plugin_dir_path(__FILE__) . 'include/as_tools_register_tab_performance.php';

    ### ----------- Advanced Code Tools Settings
    include_once plugin_dir_path(__FILE__) . 'include/as_tools_register_tab_code.php';

    ### ----------- Security Settings
    include_once plugin_dir_path(__FILE__) . 'include/as_tools_register_tab_security.php';

    ### ----------- SEO Settings
    include_once plugin_dir_path(__FILE__) . 'include/as_tools_register_tab_seo.php';

    ### ----------- Serverinfo Settings
    include_once plugin_dir_path(__FILE__) . 'include/as_tools_register_tab_serverinfo.php';

    ### ----------- TOOLS Settings
    include_once plugin_dir_path(__FILE__) . 'include/as_tools_register_tab_tools.php';

}
add_action('admin_init', 'as_tools_register_settings');


########################## // Section Callbacks ################################


function as_tools_general_section_callback() {
    echo '<p></p>';
}
function as_tools_performance_section_callback() {
    echo '<p></p>';
}
function as_tools_advanced_section_callback() {
    echo '<p></p>';
}
function as_tools_security_section_callback() {
    echo '';
}
function as_tools_seo_section_callback() {
    echo '';
}
function as_tools_serverinfo_section_callback() {
    echo '';
}
function as_tools_tools_section_callback() {
    echo '';
}


###### Render Fields Tab General
include_once plugin_dir_path(__FILE__) . 'include/as_tools_tab_general.php';

###### Render Fields Tab Performance
include_once plugin_dir_path(__FILE__) . 'include/as_tools_tab_performance.php';

###### Render Fields FOR TAB SEO TOOLS
include_once plugin_dir_path(__FILE__) . 'include/as_tools_tab_seo.php';

###### Render Fields FOR TAB CODE TOOLS
include_once plugin_dir_path(__FILE__) . 'include/as_tools_tab_code.php';

###### Render Fields FOR TAB SECURITY TOOLS
include_once plugin_dir_path(__FILE__) . 'include/as_tools_tab_security.php';

###### Render Fields FOR TAB SERVERINFO
include_once plugin_dir_path(__FILE__) . 'include/as_tools_tab_serverinfo.php';

###### Render Fields FOR TAB TOOLS
include_once plugin_dir_path(__FILE__) . 'include/as_tools_tab_tools.php';



########################## Execute Functionality ################################

############## Include functions for General ############

// Include function noopener noreferer
include_once plugin_dir_path(__FILE__) . 'include/functions/as_fn_noopener.php';

// Include function header footer scripts
include_once plugin_dir_path(__FILE__) . 'include/functions/as_fn_header_footer.php';

// Include function htaccess harden
include_once plugin_dir_path(__FILE__) . 'include/functions/as_fn_htaccess_harden.php';

// Include function htaccess settings
include_once plugin_dir_path(__FILE__) . 'include/functions/as_fn_htaccess_settings.php';

// Include small EO functions
include_once plugin_dir_path(__FILE__) . 'include/functions/as_fn_seo_small_functions.php';

// Include function TAGS
include_once plugin_dir_path(__FILE__) . 'include/functions/as_fn_tags.php';


############## Include functions for TOOLS ############

// Include function Switch Posttypes
include_once plugin_dir_path(__FILE__) . 'include/functions/as_fn_posttype_switcher.php';

include_once plugin_dir_path(__FILE__) . 'include/functions/as_fn_debugbar.php';

include_once plugin_dir_path(__FILE__) . 'include/functions/as_fn_remove_revisions.php';

include_once plugin_dir_path(__FILE__) . 'include/functions/as_fn_remove_comments.php';

// Include widget shortcode code
include_once plugin_dir_path(__FILE__) . 'include/functions/as_fn_widget_shortcode.php';

// Include Template File Admin Bar
include_once plugin_dir_path(__FILE__) . 'include/functions/as_fn_templatefile.php';

// Include CLONE
include_once plugin_dir_path(__FILE__) . 'include/functions/as_fn_cloneposts.php';


############## Include small functions for general and performance ############

include_once plugin_dir_path(__FILE__) . 'include/functions/as_fn_general_small_functions.php';

// Include small functions for tab security
include_once plugin_dir_path(__FILE__) . 'include/functions/as_fn_security_small_functions.php';

// Include Rename Login Path
include_once plugin_dir_path(__FILE__) . 'include/functions/as_fn_rename_login.php';

// Include Sitemap
include_once plugin_dir_path(__FILE__) . 'include/functions/as_fn_sitemap.php';


// ############################### Update Scripts

require 'update/plugin-update-checker/plugin-update-checker.php';
$myUpdateChecker = Puc_v4_Factory::buildUpdateChecker(
	'http://achtsekunden.com/updates/as_tools_details.json',
	__FILE__,
	'as_tools'
);
