<?php
### ----------- Tab Tools

add_settings_section('as_tools_tools_section', 'Tools Settings', 'as_tools_tools_section_callback', 'as-tools-tools');

/* register for DB */
register_setting('as_tools_settings_tools', 'as_check_maintenance_db');
register_setting('as_tools_settings_tools', 'as_check_widget_shortcode_db');
register_setting('as_tools_settings_tools', 'as_check_templatefile');
register_setting('as_tools_settings_tools', 'as_check_switchposttype');
register_setting('as_tools_settings_tools', 'as_check_debuggingbar');
register_setting('as_tools_settings_tools', 'as_check_revisions_db');
register_setting('as_tools_settings_tools', 'as_check_comments_db');
register_setting('as_tools_settings_tools', 'as_check_cloneposts_db');


# ->  // SYNTAX: NAME (different), LABELNAME, FUNCTIONSNAME, TAB NAME,  TAB SECTION
add_settings_field("as_maintenance", "Maintenance Mode", "as_tools_render_maintenance", "as-tools-tools", "as_tools_tools_section");
add_settings_field("as_widget_shortcode", "Widget Shortcode", "as_tools_render_widget_shortcode", "as-tools-tools", "as_tools_tools_section");
add_settings_field("as_switchposttype", "Switch Posttype", "as_tools_switch_posttype", "as-tools-tools", "as_tools_tools_section");
add_settings_field("as_cloneposts", "Duplicate Posts", "as_tools_render_cloneposts", "as-tools-tools", "as_tools_tools_section");
add_settings_field("as_revisions", "Revisions", "as_tools_render_remove_revisions", "as-tools-tools", "as_tools_tools_section");
add_settings_field("as_comments", "Comments", "as_tools_render_remove_comments", "as-tools-tools", "as_tools_tools_section");
add_settings_field("as_template_bar", "Template Name Bar", "as_tools_render_templatefile", "as-tools-tools", "as_tools_tools_section");
add_settings_field("as_debugbar", "Debug Bar", "as_tools_debuggingbar", "as-tools-tools", "as_tools_tools_section");
