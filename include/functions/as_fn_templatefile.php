<?php

/*
** Version: 0.1 - AS function for adding template file to admin bar

Changelog:
Version: 0.1 - 21.02.2025 - created the basic function
*/

// Prevent direct access
if (!defined('ABSPATH')) exit;

function as_show_current_template_in_admin_bar($wp_admin_bar) {
    // Ensure we are not in the admin area and the user is logged in
    if (is_admin() || !is_user_logged_in()) {
        return;
    }

    // Get the global $template variable to determine the current template file
    global $template;

    // Get just the filename of the template
    $template_name = basename($template);

    // Add the current template to the admin bar
    $wp_admin_bar->add_node(array(
        'id'    => 'current_template',
        'title' => 'Current Template: ' . $template_name,
        'href'  => '#',
    ));
      // Add custom CSS to style the admin bar node
      echo '<style>
      #wp-admin-bar-current_template {
          background-color: #0044bc!important;
      }
  </style>';
}
if(get_option('as_check_templatefile')):
  add_action( 'admin_bar_menu', 'as_show_current_template_in_admin_bar', 100 );
endif;
