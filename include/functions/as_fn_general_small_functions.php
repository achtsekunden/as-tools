<?php

/*
** Version: 0.1 - AS function for adding small functions to tab general

Changelog:
Version: 0.1 - 18.02.2025 - created the basic function
*/

// Prevent direct access
if (!defined('ABSPATH')) exit;

function as_maintenance() {
    if (get_option('as_check_maintenance_db')) {
        if (!current_user_can('edit_themes') || !is_user_logged_in()) {
            wp_die('<h2>This page is under construction</h2>', 'Website under construction');
        }
    }
}

// Enable Maintenance Mode if the option is active
add_action('template_redirect', 'as_maintenance');

// if active Maintenance
if(get_option('as_check_maintenance_db')):
    add_action('get_header', 'as_maintenance');
endif;



############ FEED #######################

function as_as_disable_feeds() {
	wp_redirect( home_url() );
	die;
}

// if active FEED
if(get_option('as_check_feed_db')):
    // Disable global RSS, RDF & Atom feeds.
    add_action( 'do_feed',      'as_disable_feeds', -1 );
    add_action( 'do_feed_rdf',  'as_disable_feeds', -1 );
    add_action( 'do_feed_rss',  'as_disable_feeds', -1 );
    add_action( 'do_feed_rss2', 'as_disable_feeds', -1 );
    add_action( 'do_feed_atom', 'as_disable_feeds', -1 );

    // Disable comment feeds.
    add_action( 'do_feed_rss2_comments', 'as_disable_feeds', -1 );
    add_action( 'do_feed_atom_comments', 'as_disable_feeds', -1 );

    // Prevent feed links from being inserted in the <head> of the page.
    add_action( 'feed_links_show_posts_feed',    '__return_false', -1 );
    add_action( 'feed_links_show_comments_feed', '__return_false', -1 );
    remove_action( 'wp_head', 'feed_links',       2 );
    remove_action( 'wp_head', 'feed_links_extra', 3 );
endif;


############ Shortcodes for Title Field #######################

function as_apply_shortcodes_to_title($title, $id = null) {
    if (is_admin() || !$id) {
        return $title;
    }
    return do_shortcode($title);
}

if(get_option('as_check_sc_title')):
    add_filter('the_title', 'as_apply_shortcodes_to_title', 10, 2);
    //for yoast
    add_filter( 'wpseo_title', 'do_shortcode' );
endif;

############ RSD LINK #######################

if(get_option('as_check_rsd_db')):
    remove_action('wp_head', 'rsd_link');
endif;


############ Remove Emoticons #######################

if(get_option('as_check_emoticons_db')):

    add_action( 'init', 'as_ec_emoji_scripts' );

function as_ec_emoji_scripts() {
	remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
	remove_action( 'admin_print_scripts', 'print_emoji_detection_script' );
	remove_action( 'wp_print_styles', 'print_emoji_styles' );
	remove_action( 'admin_print_styles', 'print_emoji_styles' );
	remove_filter( 'the_content_feed', 'wp_staticize_emoji' );
	remove_filter( 'comment_text_rss', 'wp_staticize_emoji' );
	remove_filter( 'wp_mail', 'wp_staticize_emoji_for_email' );

	add_filter('tiny_mce_plugins', function ($plugins) {
		if (is_array($plugins)) {
			return array_diff($plugins, array('wpemoji'));
		} else {
			return array();
		}
	});

	add_filter('wp_resource_hints', function ($urls, $relation_type) {
		if ('dns-prefetch' === $relation_type) {
			$emoji_svg_url = apply_filters('emoji_svg_url', 'https://s.w.org/images/core/emoji/2/svg/');

			$urls = array_diff($urls, array($emoji_svg_url));
		}

		return $urls;
	}, 10, 2);
}
endif;

############ Remove EMBEDS #######################

if(get_option('as_check_embeds_db')):
    add_action('init', 'as_disable_embeds', 9999);
    function as_disable_embeds(){
        global $wp;
        $wp->public_query_vars = array_diff($wp->public_query_vars, array('embed'));
        add_filter('embed_oembed_discover', '__return_false');
        remove_filter('oembed_dataparse', 'wp_filter_oembed_result', 10);
        remove_action('wp_head', 'wp_oembed_add_discovery_links');
        remove_action('wp_head', 'wp_oembed_add_host_js');
        add_filter('tiny_mce_plugins', function( $plugins ) {
            return array_diff($plugins, array('wpembed'));
        });
        add_filter('rewrite_rules_array', function($rules) {
            foreach($rules as $rule => $rewrite) {
                if(false !== strpos($rewrite, 'embed=true')) {
                    unset($rules[$rule]);
                }
            }
            return $rules;
        });
        remove_filter('pre_oembed_result', 'wp_filter_pre_oembed_result', 10);
    }
endif;

############ Remove WO Commerce Block Styles #######################

if(get_option('as_check_wbs_db')):
    function as_deregister_woocommerce_block_styles() {
        wp_deregister_style( 'wc-blocks-style' );
        wp_dequeue_style( 'wc-blocks-style' );
    }
    add_action( 'enqueue_block_assets', 'as_deregister_woocommerce_block_styles' );
endif;

############ Remove jQuery Migrate #######################

if(get_option('as_check_migrate_db')):
    function as_remove_jquery_migrate($scripts) {
        if (!is_admin() && !empty($scripts->registered['jquery'])) {
            $jquery_dependencies = $scripts->registered['jquery']->deps;
            $scripts->registered['jquery']->deps = array_diff($jquery_dependencies, array('jquery-migrate'));
        }
    }
    add_action('wp_default_scripts', 'as_remove_jquery_migrate');
endif;

############ SVG  #######################

if(get_option('as_check_svg_db')):

// Allows uploading SVG files to WordPress
function as_allow_svg_upload($mimes) {
    $mimes['svg'] = 'image/svg+xml';
    return $mimes;
}
add_filter('upload_mimes', 'as_allow_svg_upload');

// Ensure that SVGs are displayed correctly in the media library
function as_fix_svg_display() {
    echo '<style>
        .attachment-266x266, .thumbnail img[src$=".svg"] {
            width: 100% !important;
            height: auto !important;
        }
    </style>';
}
add_action('admin_head', 'as_fix_svg_display');

endif;

############ FONTAWESOME  #######################

if (get_option('as_check_fontawesome_db')):
    function as_enqueue_fontawesome_local() {
        $plugin_url = plugin_dir_url(dirname(dirname(__FILE__))); // Two levels back to the plugin main directory
        $css_path = plugin_dir_path(dirname(dirname(__FILE__))) . 'assets/css/all.min.css'; // Corrected path

        // Fallback: If the file does not exist, set an empty version number
        $version = file_exists($css_path) ? filemtime($css_path) : null;

        wp_enqueue_style('as-tools-fontawesome-local', $plugin_url . 'assets/css/all.min.css', array(), $version);
    }

    add_action('wp_enqueue_scripts', 'as_enqueue_fontawesome_local');
endif;

############ Reduce Heartbeat frequency

function as_reduce_heartbeat_frequency( $settings ) {
    $settings['interval'] = 60; // Sets the interval to 60 seconds (default is 15 seconds)
    return $settings;
}
if (get_option('as_check_heartbeat_db')):
    add_filter( 'heartbeat_send', 'as_reduce_heartbeat_frequency' );
endif;
