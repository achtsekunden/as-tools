<?php
### ----------- Tab Security

add_settings_section('as_tools_security_section', 'Security Settings', 'as_tools_security_section_callback', 'as-tools-security');

/* register for DB */
register_setting('as_tools_settings_security', 'as_check_wpcron_db');
register_setting('as_tools_settings_security', 'as_check_restapi_db');
register_setting('as_tools_settings_security', 'as_check_xmlrpc_db');
register_setting('as_tools_settings_security', 'as_check_rightclick_db');
register_setting('as_tools_settings_security', 'as_check_disable_comments_db');
register_setting('as_tools_settings_security', 'as_check_failed_login_db');
register_setting('as_tools_settings_security', 'as_check_hide_version_db');
register_setting('as_tools_settings_security', 'as_check_change_login_db', array(
    'sanitize_callback' => 'as_tools_sanitize_change_login'
));
register_setting('as_tools_settings_security', 'as_blockip_db');
register_setting('as_tools_settings_security', 'as_blockip_enabled');
register_setting('as_tools_settings_security', 'as_check_xpower_db');
register_setting('as_tools_settings_security', 'as_check_htaccess_cross_db');
register_setting('as_tools_settings_security', 'as_check_htaccess_accessthemeplugins_db');
register_setting('as_tools_settings_security', 'as_check_http_header');


# ->  // SYNTAX: NAME (different), LABELNAME, FUNCTIONSNAME, TAB NAME,  TAB SECTION
add_settings_field("as_wpcron", "WP Cron", "as_tools_render_wpcron_field", "as-tools-security", "as_tools_security_section");
add_settings_field("as_restapi", "Rest API", "as_tools_render_restapi_field", "as-tools-security", "as_tools_security_section");
add_settings_field("as_xmlrpc", "XML-RPC", "as_tools_render_xmlrpc_field", "as-tools-security", "as_tools_security_section");
add_settings_field("as_rightclick", "Copy Protection", "as_tools_render_rightclick", "as-tools-security", "as_tools_security_section");
add_settings_field("as_disable_comments", "Comments", "as_tools_render_disable_comments", "as-tools-security", "as_tools_security_section");
add_settings_field("as_disable_failedlogin", "Failed Logins", "as_tools_render_redirect_failedlogin", "as-tools-security", "as_tools_security_section");
add_settings_field("as_hide_version", "Hide WP Version", "as_tools_render_hide_version", "as-tools-security", "as_tools_security_section");
add_settings_field("as_xpower", "X-Powered by", "as_tools_render_xpower", "as-tools-security", "as_tools_security_section");

add_settings_field("as_crossite", "Block Cross Site", "as_tools_block_xss", "as-tools-security", "as_tools_security_section");
add_settings_field("as_restrict_direct", "Restrict access", "as_tools_restrict_access", "as-tools-security", "as_tools_security_section");
add_settings_field("as_http_header", "Security header", "as_tools_http_header", "as-tools-security", "as_tools_security_section");

add_settings_field("as_change_login", "Change Login URL", "as_tools_render_change_login", "as-tools-security", "as_tools_security_section");
add_settings_field("as_blockips", "Block IPs", "as_tools_render_blockIPs_field", "as-tools-security", "as_tools_security_section");
