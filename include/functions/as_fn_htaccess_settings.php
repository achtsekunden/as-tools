<?php
/*
** AS function for adding htaccess settings to htaccess
*/

// Function to flush the permalinks
function as_ftc_flush_rewrites() {
    if (function_exists('flush_rewrite_rules')) {
        flush_rewrite_rules(); // Verwende die sichere Funktion von WordPress
    }
}

// Safely delay the flush call after plugin activation
register_activation_hook(__FILE__, 'as_ftc_activate_plugin');
function as_ftc_activate_plugin() {
    // Flushing the rewrite rules delayed to the 'init' hook
    add_action('init', 'as_ftc_flush_rewrites');
}

// adding rule
function as_htaccess_rules_wpconfig( $rules ) {

$as_content = <<<EOD
\n # BEGIN AS-Tools wpconfig
<Files wp-config.php>
    Order Allow,Deny
    Deny from all
</Files>
# END AS-Tools wpconfig
\n
EOD;
    return $as_content . $rules;
}

// add function if true
if(get_option('as_check_htaccess_configfile_db')):
    add_filter('mod_rewrite_rules', 'as_htaccess_rules_wpconfig');
    add_action('shutdown', 'as_ftc_flush_rewrites');
endif;

// removing rule
if(get_option('as_check_htaccess_configfile_db') == false ):
    remove_filter( 'mod_rewrite_rules', 'as_htaccess_rules_wpconfig', 10, 1 );
    add_action('shutdown', 'as_ftc_flush_rewrites');
endif;


/* ##########  adding Block cross-site scripting rule ########## */

function as_cross_rules( $rules ) {

$as_content = <<<EOD
\n # BEGIN AS-Tools Block XSS attacks
<IfModule mod_rewrite.c>
RewriteCond %{QUERY_STRING} (\|%3E) [NC,OR]
RewriteCond %{QUERY_STRING} GLOBALS(=|\[|\%[0-9A-Z]{0,2}) [OR]
RewriteCond %{QUERY_STRING} _REQUEST(=|\[|\%[0-9A-Z]{0,2})
RewriteRule .* index.php [F,L]
</IfModule>
# END AS-Tools Block XSS attacks
\n
EOD;
return $as_content . $rules;
}

// adding Cross site rule function if true
if(get_option('as_check_htaccess_cross_db')):
    add_filter('mod_rewrite_rules', 'as_cross_rules');
    add_action('shutdown', 'as_ftc_flush_rewrites');
endif;

// removing Cross site rule
if(get_option('as_check_htaccess_cross_db') == false ):
    remove_filter( 'mod_rewrite_rules', 'as_cross_rules', 10, 1 );
    add_action('shutdown', 'as_ftc_flush_rewrites');
endif;

/* ##########  adding Block cross-site scripting rule ########## */


/* ##########  adding Restrict All Access To WP Includes rule ########## */

function as_htaccess_includes_rules( $rules ) {

$as_content = <<<EOD
\n # BEGIN AS-Tools Restrict Access To WP Includes
<IfModule mod_rewrite.c>
RewriteEngine On
RewriteBase /
RewriteRule ^wp-admin/includes/ - [F,L]
RewriteRule !^wp-includes/ - [S=3]
RewriteRule ^wp-includes/[^/]+\.php$ - [F,L]
RewriteRule ^wp-includes/js/tinymce/langs/.+\.php - [F,L]
RewriteRule ^wp-includes/theme-compat/ - [F,L]
</IfModule>
# END AS-Tools Restrict Access To WP Includes
\n
EOD;
return $as_content . $rules;
}

// adding includes rule function if true
if(get_option('as_check_htaccess_wpincludes_db')):
    add_filter('mod_rewrite_rules', 'as_htaccess_includes_rules');
    add_action('shutdown', 'as_ftc_flush_rewrites');
endif;

// removing includes rule
if(get_option('as_check_htaccess_wpincludes_db') == false ):
    remove_filter( 'mod_rewrite_rules', 'as_htaccess_includes_rules', 10, 1 );
    add_action('shutdown', 'as_ftc_flush_rewrites');
endif;

/* ##########  adding Restrict All Access To WP Includes rule ########## */


/* ##########  adding Restrict Direct Access To Plugin and Theme PHP files rule ########## */

function as_htaccess_themeplugin( $rules ) {
    $as_content = <<<EOD
\n# BEGIN AS-Tools: Restrict direct access to plugin & theme PHP files
<IfModule mod_rewrite.c>
RewriteEngine On
RewriteBase /
RewriteCond %{REQUEST_URI} !^/wp-content/plugins/file/to/exclude\.php
RewriteCond %{REQUEST_URI} !^/wp-content/plugins/directory/to/exclude/
RewriteRule ^wp-content/plugins/.*\.php$ - [F,L]
RewriteCond %{REQUEST_URI} !^/wp-content/themes/file/to/exclude\.php
RewriteCond %{REQUEST_URI} !^/wp-content/themes/directory/to/exclude/
RewriteRule ^wp-content/themes/.*\.php$ - [F,L]
</IfModule>
# END AS-Tools
\n
EOD;
    return $as_content . $rules;
}

// adding includes rule function if true
if(get_option('as_check_htaccess_accessthemeplugins_db')):
    add_filter('mod_rewrite_rules', 'as_htaccess_themeplugin');
    add_action('shutdown', 'as_ftc_flush_rewrites');
endif;

// removing includes rule
if(get_option('as_check_htaccess_accessthemeplugins_db') == false ):
    remove_filter( 'mod_rewrite_rules', 'as_htaccess_themeplugin', 10, 1 );
    add_action('shutdown', 'as_ftc_flush_rewrites');
endif;

/* ##########  adding File Compressing and caching rule ########## */

function as_htaccess_compressing($rules) {
  $as_content = <<<EOD
\n# BEGIN AS-Tools Compressing and Caching
<IfModule mod_expires.c>
  ExpiresActive on
  ExpiresDefault "access plus 1 month"

  # CSS
  ExpiresByType text/css "access plus 1 year"

  # JavaScript
  ExpiresByType application/javascript "access plus 1 year"

  # HTML - No Caching
  ExpiresByType text/html "access plus 0 seconds"

  # Media files
  ExpiresByType image/jpeg "access plus 1 year"
  ExpiresByType image/png "access plus 1 year"
  ExpiresByType image/gif "access plus 1 year"
  ExpiresByType video/mp4 "access plus 1 year"

  # Web fonts
  ExpiresByType font/woff2 "access plus 1 year"
  ExpiresByType font/woff "access plus 1 year"
</IfModule>

<IfModule mod_deflate.c>
  # Compression aktivieren
  AddOutputFilterByType DEFLATE text/plain text/html text/xml text/css application/javascript application/json
  AddOutputFilterByType DEFLATE image/svg+xml
</IfModule>

<IfModule mod_headers.c>
  <FilesMatch "\.(ico|pdf|flv|swf|js|css|gif|png|jpg|jpeg|woff2|woff)$">
      Header set Cache-Control "max-age=31536000, public"
  </FilesMatch>

  # Set Keep Alive Header
  Header set Connection keep-alive
</IfModule>

# END AS-Tools Compressing and Caching
\n
EOD;
  return $rules . $as_content;
}


// adding includes rule function if true
if(get_option('as_check_cache_db')):
    add_filter('mod_rewrite_rules', 'as_htaccess_compressing');
    add_action('shutdown', 'as_ftc_flush_rewrites');
endif;


/* ##########  /adding File Compressing and caching rule ########## */


/* ##########  adding Hotfixing ########## */

function as_htaccess_hotfixing( $rules ) {

$url = get_site_url();

$find = array( 'http://', 'https://', 'www.' );
$replace = '';
$output = str_replace( $find, $replace, $url );

//echo '<h1>' . $output . '</h1>';


$as_content = <<<EOD
\n # BEGIN AS-Tools Hotlinking
RewriteEngine On
RewriteBase /
RewriteCond %{HTTP_REFERER} ^$
RewriteCond %{HTTP_REFERER} !^http(s)?://(www.)?$output\.de [NC]
RewriteRule \.(jpg|jpeg|png|gif)$ - [NC,R,L]
# END AS-Tools Hotlinking
\n
EOD;
return $as_content . $rules;
}

// adding includes rule function if true
if(get_option('as_check_htaccess_hotlinking_db')):
    add_filter('mod_rewrite_rules', 'as_htaccess_hotfixing');
    add_action('shutdown', 'as_ftc_flush_rewrites');
endif;

// removing includes rule
if(get_option('as_check_htaccess_hotlinking_db') == false ):
    remove_filter( 'mod_rewrite_rules', 'as_htaccess_hotfixing', 10, 1 );
    add_action('shutdown', 'as_ftc_flush_rewrites');
endif;

/* ##########  / adding Hotfixing ########## */

############ BLOCK IPS HTACCESS ##############

function as_htaccess_ip_blocking( $rules ) {

  // Get the blocked IPs from the database
    $ips = array_map('trim', explode("\n", get_option('as_blockip_db')));
    $ips = array_filter($ips, function($ip) { return !empty($ip); }); // Remove empty IPs
    $block_ips_enabled = get_option('as_blockip_enabled', 1); // Get the value of the checkbox

   // Only continue if blocking is enabled and IPs exist
    if ($block_ips_enabled && !empty($ips)) {
        $ip_block_content = "\n# BEGIN AS Tools IP Block\n";
        foreach ($ips as $ip) {
            $ip_block_content .= "Deny from $ip\n";
        }
        $ip_block_content .= "# END AS Tools IP Block\n";

      // Add the blocking to the rules
        return $ip_block_content . $rules;
    }

  // If no IPs are blocked or the option is disabled, remove the block
    $rules = preg_replace('/# BEGIN AS Tools IP Block.*?# END AS Tools IP Block/s', '', $rules);

    return $rules;
}

// Apply filter if blocking is enabled
if(get_option('as_blockip_enabled')):
    add_filter('mod_rewrite_rules', 'as_htaccess_ip_blocking');
endif;
