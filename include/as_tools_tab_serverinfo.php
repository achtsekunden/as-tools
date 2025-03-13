<?php

###### Render Fields FOR TAB Serverinfo

function as_tools_serverinfo_section_echo_serverinfo() {
    // Collect server information
    $server_info = array(
        'PHP Version'        => phpversion(),
        'MySQL Version'      => $GLOBALS['wpdb']->db_version(),
        'Server Software'    => $_SERVER['SERVER_SOFTWARE'],
        'WordPress Version'  => get_bloginfo('version'),
        'Memory Limit'       => ini_get('memory_limit'),
        'Max Execution Time' => ini_get('max_execution_time') . ' Seconds',
        'Upload Max Size'    => ini_get('upload_max_filesize'),
        'Post Max Size'      => ini_get('post_max_size'),
        'Server IP'             => $_SERVER['SERVER_ADDR'],
        'Server Hostname'       => gethostname(),
        'Server Port'           => $_SERVER['SERVER_PORT'],
        'Document Root'         => $_SERVER['DOCUMENT_ROOT'],
        'Operation System'      => php_uname(),
        'CPU Cores'            => function_exists('shell_exec') ? trim(shell_exec('nproc')) : 'Not available',
        'RAM'       => function_exists('shell_exec') ? trim(shell_exec("free -m | awk '/^Mem:/{print $2}'")) . ' MB' : 'Not available',
        'Time Zone'          => date_default_timezone_get(),
        'Multisite activated'    => is_multisite() ? 'Yes' : 'No',
        'Aktives Theme'         => wp_get_theme()->get('Name') . ' (' . wp_get_theme()->get('Version') . ')',
        'WP Debug Mode'         => (defined('WP_DEBUG') && WP_DEBUG) ? 'active' : 'not active',
        'WP Memory Limit'       => WP_MEMORY_LIMIT,
        'Uploads Path'          => wp_upload_dir()['basedir'],
        'Language'               => get_locale(),
        'Permalink-Structure'    => get_option('permalink_structure'),
        'Count User'            => count_users()['total_users'],
        'Count Posts'           => wp_count_posts()->publish,
        'Count Pages'           => wp_count_posts('page')->publish,
        'Comments'              => wp_count_comments()->approved,
    );

    // Output HTML table
    echo '<table class="widefat fixed" style="max-width: 800px;">';
    echo '<thead><tr><th>Setting</th><th>Value</th></tr></thead>';
    echo '<tbody>';

    foreach ($server_info as $key => $value) {
        echo '<tr><td><strong>' . esc_html($key) . '</strong></td><td>' . esc_html($value) . '</td></tr>';
    }

    echo '</tbody></table>';
}
