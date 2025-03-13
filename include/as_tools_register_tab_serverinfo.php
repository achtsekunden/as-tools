<?php
### ----------- Tab Serversettings

add_settings_section('as_tools_server_section', 'Server Settings', 'as_tools_serverinfo_section_callback', 'as-tools-serverinfo');
add_settings_section('as_tools_server_section','Server Settings','as_tools_serverinfo_section_echo_serverinfo', 'as-tools-serverinfo');

register_setting('as_tools_settings_serverinfo', 'as_tools_serverinfo_options');
