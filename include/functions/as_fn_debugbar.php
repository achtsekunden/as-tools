<?php

if ( !function_exists('as_display_php_errors_in_admin_bar') ) {
    function as_display_php_errors_in_admin_bar() {
        // Execute only in the frontend
        if ( is_admin() ) {
            return;
        }
        // Register error handler (frontend only)
        set_error_handler('as_capture_php_errors');

        // Display errors in the Admin Bar on the frontend
        add_filter( 'admin_bar_menu', 'as_show_php_errors_in_admin_bar', 100 );
    }

    // Display errors in the Admin Bar
    function as_show_php_errors_in_admin_bar($wp_admin_bar) {
        global $php_errors;

        // If no errors are captured, add a notice
        if ( empty($php_errors) ) {
            $php_errors[] = 'No errors found';
        }

        // Create the main menu node "AS-Tools Debugging"
        $wp_admin_bar->add_node(array(
            'id'    => 'as_tools_debugging',
            'title' => 'AS-Tools Debugging',
            'meta'  => array(
                'class' => 'as-tools-debugging',
            ),
        ));

        // Add a submenu item for each error
        foreach ( $php_errors as $index => $error_message ) {
            $wp_admin_bar->add_node(array(
                'id'     => 'as_tools_error_' . $index,
                'parent' => 'as_tools_debugging',
                'title'  => $error_message,
            ));
        }
        // Custom CSS for the menu node
        echo '<style>
            #wp-admin-bar-as_tools_debugging { background-color: rgb(0, 53, 143) !important; cursor: pointer; }
            #wp-admin-bar-as_tools_debugging .ab-item:hover { background-color: rgb(0, 53, 143); }
            </style>';
    }

    // Capture and store errors
    function as_capture_php_errors($errno, $errstr, $errfile, $errline) {
        // Capture only errors and warnings, skip notices
        if ( $errno != E_NOTICE && $errno != E_USER_NOTICE ) {
            $error_message = "Error: [$errno] $errstr - $errfile:$errline";
            global $php_errors;
            $php_errors[] = $error_message;
        }

        return false; // Pass execution to the next error handler
    }
}

// Condition: Option active AND frontend only
if ( get_option('as_check_debuggingbar') && !is_admin() ) {
    add_action( 'wp_loaded', 'as_display_php_errors_in_admin_bar' );
}
?>
