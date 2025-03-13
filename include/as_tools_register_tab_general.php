<?php

    ### ----------- General Settings
    add_settings_section('as_tools_general_section', 'General Settings', 'as_tools_general_section_callback', 'as-tools-general');

    /* register for DB */
    register_setting('as_tools_settings_general', 'as_check_noreferrer_db');
    register_setting('as_tools_settings_general', 'as_check_js_db');
    register_setting('as_tools_settings_general', 'as_check_tags_pages_db');
    register_setting('as_tools_settings_general', 'as_check_category_pages_db');
    register_setting('as_tools_settings_general', 'as_check_maintenance_db');
    register_setting('as_tools_settings_general', 'as_check_sc_title');
    register_setting('as_tools_settings_general', 'as_check_revisions_db');
    register_setting('as_tools_settings_general', 'as_check_comments_db');
    register_setting('as_tools_settings_general', 'as_check_svg_db');
    register_setting('as_tools_settings_general', 'as_check_fontawesome_db');
    register_setting('as_tools_settings_general', 'as_check_widget_shortcode_db');
    register_setting('as_tools_settings_general', 'as_check_templatefile');
    register_setting('as_tools_settings_general', 'as_check_switchposttype');
    register_setting('as_tools_settings_general', 'as_check_debuggingbar');

    # ->  // SYNTAX: NAME (different), LABELNAME, FUNKTIONSNAME, TAB NAME,  TAB SECTION
    add_settings_field("as_maintenance", "Maintenance Mode", "as_tools_render_maintenance", "as-tools-general", "as_tools_general_section");
    add_settings_field("as_tagpages", "Tags for Pages", "as_tools_render_tags_pages", "as-tools-general", "as_tools_general_section");
    add_settings_field("as_categorypages", "Categories for Pages", "as_tools_render_category_pages", "as-tools-general", "as_tools_general_section");
    add_settings_field("as_remove_noreferrer", "Remove noreferrer & noopener", "as_tools_render_noreferrer_field", "as-tools-general", "as_tools_general_section");
    add_settings_field("as_remove_noreferrer_js", "Remove noreferrer & noopener with JS", "as_tools_render_check_js", "as-tools-general", "as_tools_general_section");
    add_settings_field("as_allow_sc", "Shortcode for Title", "as_tools_render_shortcode_title", "as-tools-general", "as_tools_general_section");
    add_settings_field("as_revisions", "Revisions", "as_tools_render_remove_revisions", "as-tools-general", "as_tools_general_section");
    add_settings_field("as_comments", "Comments", "as_tools_render_remove_comments", "as-tools-general", "as_tools_general_section");
    add_settings_field("as_svg", "SVG Images", "as_tools_render_allow_svg", "as-tools-general", "as_tools_general_section");
    add_settings_field("as_fontawesome", "FontAwesome", "as_tools_render_fontawesome", "as-tools-general", "as_tools_general_section");
    add_settings_field("as_widget_shortcode", "Widget Shortcode", "as_tools_render_widget_shortcode", "as-tools-general", "as_tools_general_section");
    add_settings_field("as_template_bar", "Template Name Bar", "as_tools_render_templatefile", "as-tools-general", "as_tools_general_section");
    add_settings_field("as_switchposttype", "Switch Posttype", "as_tools_switch_posttype", "as-tools-general", "as_tools_general_section");
    add_settings_field("as_debugbar", "Debug Bar", "as_tools_debuggingbar", "as-tools-general", "as_tools_general_section");
