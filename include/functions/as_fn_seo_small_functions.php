<?php

/*
** Version: 0.1 - AS function for adding small functions to SEO
*/

// Prevent direct access
if (!defined('ABSPATH')) exit;

// LOWERCASE
function as_force_lowercase_url () {
    if (preg_match('/[A-Z]/', $_SERVER['REQUEST_URI'])) { header('Location: ' . strtolower($_SERVER['REQUEST_URI']), TRUE, 301); exit(); }
}

// check if clicked, then add this to the theme
if(get_option('as_check_lowercase_db')):
    add_action('init', 'as_force_lowercase_url');
endif;

// noindex pagination
if(get_option('as_check_pagination_db')):
    function as_noindex_paginated_pages() {
        if (is_paged()) {
            echo '<meta name="robots" content="noindex, follow">' . "\n";
        }
    }
    add_action('wp_head', 'as_noindex_paginated_pages');
endif;


// 404 redirect home
if(get_option('as_check_404_db')):
    function as_redirect_404_to_home() {
        if (is_404()) {
            wp_redirect(home_url(), 301);
            exit;
        }
    }
    add_action('template_redirect', 'as_redirect_404_to_home');
endif;

// Archivetitle
if(get_option('as_check_archivetitle_db')):
    function as_clean_archive_title($title) {
        return preg_replace('/^.*?:\s*/', '', $title);
    }
    add_filter('get_the_archive_title', 'as_clean_archive_title');
endif;


//############## insert GTM ID

function as_insert_google_tag_manager() {
    // Exit function if no GTM ID is set
    if (empty(get_option('as_check_gtm'))) {
        return;
    }

    // Add GTM script in the <head>
    function as_gtm_head() {
        $gtm_id = get_option('as_check_gtm'); // Retrieve GTM ID directly in the function
        echo "<!-- Google Tag Manager -->
        <script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src='https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);})(window,document,'script','dataLayer','$gtm_id');</script>
        <!-- End Google Tag Manager -->";
    }
    add_action('wp_head', 'as_gtm_head');

    // Add GTM <noscript> in the <body>
    function as_gtm_body() {
        $gtm_id = get_option('as_check_gtm'); // Retrieve GTM ID directly in the function
        echo "<!-- Google Tag Manager (noscript) -->
        <noscript><iframe src='https://www.googletagmanager.com/ns.html?id=$gtm_id' height='0' width='0' style='display:none;visibility:hidden'></iframe></noscript>
        <!-- End Google Tag Manager (noscript) -->";
    }
    add_action('wp_body_open', 'as_gtm_body');
}

// Execute the function only if GTM is activated
if(get_option('as_check_gtm')):
    add_action('wp_loaded', 'as_insert_google_tag_manager');
endif;
