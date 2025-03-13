<?php

/*
** Version: 0.1 - AS function for adding small functions to tab security

Changelog:
Version: 0.1 - 24.02.2025 - created the basic function
*/

// Prevent direct access
if (!defined('ABSPATH')) exit;

############# Disable WP Cron
function as_disable_wp_cron() {
    if (!defined('DISABLE_WP_CRON')) {
        define('DISABLE_WP_CRON', true);
    }
}

if(get_option('as_check_wpcron_db')):
    add_action('init', 'as_disable_wp_cron');
endif;

#############  Disable REST-API
function as_restrict_rest_api_access( $result ) {
    // Allow REST API only for logged in users
    if ( ! is_user_logged_in() ) {
        return new WP_Error( 'rest_forbidden', __( 'REST API access is restricted.', 'as-tools' ), array( 'status' => 403 ) );
    }
    return $result;
}
//  Remove REST API headers in HTTP response
function as_remove_rest_api_header() {
    remove_action('template_redirect', 'rest_output_link_header', 11);
}
// Remove REST API links in <head>
function as_remove_rest_api_links() {
    remove_action('wp_head', 'rest_output_link_wp_head', 10);
    remove_action('xmlrpc_rsd_apis', 'rest_output_rsd');
}

if(get_option('as_check_wpcron_db')):
    add_filter( 'rest_authentication_errors', 'as_restrict_rest_api_access' );
    add_action('init', 'as_remove_rest_api_header');
    add_action('init', 'as_remove_rest_api_links');
endif;

// Completely disable XML-RPC in WordPress
if(get_option('as_check_xmlrpc_db')):
    function as_disable_xmlrpc() {
        add_filter('xmlrpc_enabled', '__return_false'); // Disable XML-RPC function
        add_filter('xmlrpc_methods', function($methods) {
            return []; // Remove all XML-RPC methods
        });
    }
endif;


function as_disable_right_click() {
    if (!is_admin() && !is_user_logged_in()) { // Only active in the frontend
        echo '
        <script>
        document.addEventListener("contextmenu", function(event) {
            event.preventDefault(); // Rechtsklick deaktivieren
        });

        document.addEventListener("keydown", function(event) {
            if (event.ctrlKey && (event.key === "c" || event.key === "x" || event.key === "u")) {
                event.preventDefault(); // Strg + C, Strg + X und Strg + U blockieren
            }
        });

        document.addEventListener("copy", function(event) {
            event.preventDefault(); // Kopieren verhindern
        });

        document.addEventListener("selectstart", function(event) {
            event.preventDefault(); // Textauswahl verhindern
        });
        console.log("AS-Tools: rightclick not allowed");
        </script>
        ';
    }
}
if(get_option('as_check_rightclick_db')):
    add_action('wp_footer', 'as_disable_right_click');
endif;

################# DISABLE COMMENTS
function as_disable_comments() {
    // Disable comments for all post types
    if (is_admin()) {
    // Prevent comments from being created in the admin area

    } else {
       // Prevent comments from being displayed on frontend pages
        remove_action('wp_head', 'feed_links_extra', 3); // RSS-Feeds
        remove_action('wp_head', 'feed_links', 2); // Standard-Feeds
        remove_action('wp_head', 'rsd_link'); // Really Simple Discovery Link
        remove_action('wp_head', 'wlwmanifest_link'); // Windows Live Writer
    }
   // Prevent the creation of comments on all post types
}


if(get_option('as_check_disable_comments_db')):
    add_filter('comments_open', '__return_false', 10, 2);
    add_filter('pings_open', '__return_false', 10, 2);
    add_filter('comments_array', '__return_empty_array', 10, 2);
    add_filter('pre_comment_content', '__return_empty_string');
    add_action('init', 'as_disable_comments');
endif;


################# redirect to home after failed login
function as_redirect_failed_login_to_home($username) {
  // Prevent the error message from being displayed
    remove_action('login_head', 'wp_authenticate');
  // Make sure we are not on the wp-login.php page
    if (strpos($_SERVER['REQUEST_URI'], 'wp-login.php') !== false) {
        wp_redirect(home_url());
        exit;
    }
}

if(get_option('as_check_failed_login_db')):
    add_action('wp_login_failed', 'as_redirect_failed_login_to_home');
endif;

################# HIDE WP Version

if(get_option('as_check_hide_version_db')):

    function as_remove_wp_version() {
        return '';
    }
    add_filter('the_generator', 'as_remove_wp_version');

    function as_remove_wp_version_from_scripts($src) {
        if (strpos($src, 'ver=')) {
            $src = remove_query_arg('ver', $src);
        }
        return $src;
    }
    add_filter('style_loader_src', 'as_remove_wp_version_from_scripts', 9999);
    add_filter('script_loader_src', 'as_remove_wp_version_from_scripts', 9999);

endif;

################# Remove X-Powered

if(get_option('as_check_xpower_db')):

    // Entfernt den "X-Powered-By" HTTP Header
    if (function_exists('remove_action')) {
        remove_filter('wp_headers', 'wp_headers_x_powered_by');
    }

    // Entfernen des X-Powered-By Headers
    add_filter('header', function($headers) {
        if (isset($headers['X-Powered-By'])) {
            unset($headers['X-Powered-By']);
        }
        return $headers;
    });

    remove_action('wp_head', 'wp_generator');
    remove_action('wp_head', 'rsd_link');
    remove_action('wp_head', 'wlwmanifest_link');
endif;

################# Activate security header

function as_set_security_headers() {
  // HSTS - Forces HTTPS
    header('Strict-Transport-Security: max-age=31536000; includeSubDomains; preload');
    // Content Security Policy (CSP) - Verhindert XSS & Code Injection
    header("Content-Security-Policy: default-src 'self'; script-src 'self' 'unsafe-inline' https://trusted-scripts.com; style-src 'self' 'unsafe-inline'; img-src 'self' data:;");
  // X-Content-Type-Options - Prevents MIME type sniffing
    header('X-Content-Type-Options: nosniff');
    // X-Frame-Options - Prevents clickjacking
    header('X-Frame-Options: SAMEORIGIN');
   // X-XSS-Protection - Protection against Cross-Site Scripting (XSS)
    header('X-XSS-Protection: 1; mode=block');
}

if(get_option('as_check_http_header')):
    add_action('send_headers', 'as_set_security_headers');
endif;
