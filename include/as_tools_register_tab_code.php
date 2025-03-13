<?php

### ----------- Advanced Code Tools Settings
add_settings_section('as_tools_advanced_section', '', 'as_tools_advanced_section_callback', 'as-tools-advanced');

register_setting('as_tools_settings_advanced', 'as_header_script');
register_setting('as_tools_settings_advanced', 'as_footer_script');

add_settings_field('as_header_script', 'Header Script', 'as_tools_render_header_script_field', 'as-tools-advanced', 'as_tools_advanced_section');
add_settings_field('as_footer_script', 'Footer Script', 'as_tools_render_footer_script_field', 'as-tools-advanced', 'as_tools_advanced_section');
