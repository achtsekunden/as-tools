<?php

if ( !function_exists('as_display_php_errors_in_admin_bar') ) {
  function as_display_php_errors_in_admin_bar() {
      // Register error handler for all errors
      set_error_handler('as_capture_php_errors');

      // Display errors in the frontend (Admin Bar visible)
      add_filter( 'admin_bar_menu', 'as_show_php_errors_in_admin_bar', 100 );
  }

  // Display errors in the Admin Bar
  function as_show_php_errors_in_admin_bar($wp_admin_bar) {
      // Stored errors
      global $php_errors;

      // If there are errors, add them to the Admin Bar
      if (!empty($php_errors)) {
          // Create the main menu item "AS-Tools Debugging"
          $wp_admin_bar->add_node(array(
              'id'    => 'as_tools_debugging',
              'title' => 'AS-Tools Debugging', // Title in the Admin Bar
              'meta'  => array(
                  'class' => 'as-tools-debugging',
              ),
          ));

          // Add submenu items if errors exist
          foreach ($php_errors as $index => $error_message) {
              $wp_admin_bar->add_node(array(
                  'id'     => 'as_tools_error_' . $index,
                  'parent' => 'as_tools_debugging', // Submenu under "AS-Tools Debugging"
                  'title'  => $error_message, // Error message
              ));
          }
      }
      // Add custom CSS to style the admin bar node
      echo '<style>
    #wp-admin-bar-as_tools_debugging{background-color:rgb(0, 53, 143) !important;cursor:pointer;}
    #wp-admin-bar-as_tools_debugging .ab-item:hover{background-color:rgb(0, 53, 143);}
    </style>';
  }

  // Capture and store errors
  function as_capture_php_errors($errno, $errstr, $errfile, $errline) {
      // Only display errors if they are not notices
      if ($errno != E_NOTICE && $errno != E_USER_NOTICE) {
          $error_message = "Error: [$errno] $errstr - $errfile:$errline";

          // Store errors in a global variable
          global $php_errors;
          $php_errors[] = $error_message;
      }

      return false; // Continue with the next error handler
  }

}

if(get_option('as_check_debuggingbar')):
    // Activate error handling
    add_action( 'wp_loaded', 'as_display_php_errors_in_admin_bar' );
endif;
