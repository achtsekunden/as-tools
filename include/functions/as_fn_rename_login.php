<?php

/*
** Version: 0.1 - AS function for changing login path

Changelog:
Version: 0.1 - 24.02.2025 - created the basic function


# NOTES:
wp-login and Custom Name URL open !
*/



function as_custom_rewrite_rules() {
  // Get the custom login slug from the options
  $custom_login_slug = get_option('as_check_change_login_db', '');

// If no custom login slug is set, do not add any more rewrite rules
  if (empty($custom_login_slug)) {
      return;
  }

// Add a custom rewrite rule to redirect the custom login slug
  add_rewrite_rule('^' . $custom_login_slug . '/?', 'index.php?as_custom_login=1', 'top');

// Only flush_rewrite_rules if the permalink structure has been changed
  if (get_option('permalink_structure')) {
      flush_rewrite_rules();
  }
}

add_action('init', 'as_custom_rewrite_rules');

function as_register_custom_query_var($vars) {
// Get the custom login slug from the options
  $custom_login_slug = get_option('as_check_change_login_db', '');

// If no custom login slug is set, do not register a query variable
  if (empty($custom_login_slug)) {
      return $vars;
  }

// Add our custom query variable
  $vars[] = 'as_custom_login';
  return $vars;
}

add_filter('query_vars', 'as_register_custom_query_var');

// Redirect when calling the custom login URL
function as_custom_login_redirect() {
// Get the custom login slug from the options
  $custom_login_slug = get_option('as_check_change_login_db', '');

// If no custom login slug is set, do not redirect
  if (empty($custom_login_slug)) {
      return;
  }

// If the URL contains wp-login.php, redirect to the homepage
  if (strpos($_SERVER['REQUEST_URI'], 'wp-login.php') !== false) {
      wp_redirect(home_url());
      exit;
  }

// When the custom login page is called, redirect to wp-login.php
  if (get_query_var('as_custom_login') == 1) {
      wp_redirect(site_url('wp-login.php'));  // Redirect to the login page (wp-login.php)
      exit;
  }
}

add_action('template_redirect', 'as_custom_login_redirect');

// Prevent access to wp-admin if not logged in
function as_block_wp_admin() {
// Get the custom login slug from the options
  $custom_login_slug = get_option('as_check_change_login_db', '');

  // Wenn kein benutzerdefinierter Login-Slug gesetzt ist, blockiere wp-admin nicht
  if (empty($custom_login_slug)) {
      return;
  }

  // Blockiere den Zugriff auf wp-admin, wenn der Benutzer nicht eingeloggt ist
  if (strpos($_SERVER['REQUEST_URI'], '/wp-admin') !== false && !is_user_logged_in()) {
      wp_redirect(home_url());
      exit;
  }
}

add_action('init', 'as_block_wp_admin');

// Ersetze die Login-URL durch den benutzerdefinierten Login-Slug
function as_replace_login_url($url, $redirect, $force_reauth) {
  // Hole den benutzerdefinierten Login-Slug aus den Optionen
  $custom_login_slug = get_option('as_check_change_login_db', '');

  // Wenn kein benutzerdefinierter Login-Slug gesetzt ist, benutze die Standard-Login-URL
  if (empty($custom_login_slug)) {
      return home_url('/wp-login.php');
  }

  // Andernfalls leite zur benutzerdefinierten Login-Seite um
  return home_url('/' . $custom_login_slug . '/');
}

add_filter('login_url', 'as_replace_login_url', 10, 3);
