<?php

/*
** Version: 0.1 - AS function for adding scripts to header and footer

Changelog:
Version: 0.1 - 18.02.2025 - created the basic function
*/

// Prevent direct access

if (!defined('ABSPATH')) exit;

// adding header field to header
function as_headerfooter_header_scripts(){
   // Get the stored value and add <script> tags
    $script_content = get_option('as_header_script');
    if ($script_content) {
        echo $script_content;
    }
}

// if active, call as_header_scripts
if(get_option('as_header_script')):
    add_action( 'wp_head', 'as_headerfooter_header_scripts' );
endif;

################ FOOTER

// adding FOOTER field to footer
function as_headerfooter_footer_scripts(){
    $script_content = get_option('as_footer_script');
    if ($script_content) {
        echo $script_content;
    }
}

// if active, call as_footer_scripts
if(get_option('as_footer_script')):
    add_action( 'wp_footer', 'as_headerfooter_footer_scripts' );
endif;
