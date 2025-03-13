<?php

    ### ----------- General Settings
    add_settings_section('as_tools_general_section', 'General Settings', 'as_tools_general_section_callback', 'as-tools-general');

    /* register for DB */
    register_setting('as_tools_settings_general', 'as_check_noreferrer_db');
    register_setting('as_tools_settings_general', 'as_check_js_db');
    register_setting('as_tools_settings_general', 'as_check_tags_pages_db');
    register_setting('as_tools_settings_general', 'as_check_category_pages_db');
    register_setting('as_tools_settings_general', 'as_check_sc_title');
    register_setting('as_tools_settings_general', 'as_check_svg_db');
    register_setting('as_tools_settings_general', 'as_check_fontawesome_db');

    # ->  // SYNTAX: NAME (different), LABELNAME, FUNKTIONSNAME, TAB NAME,  TAB SECTION

    add_settings_field("as_tagpages", "Tags for Pages", "as_tools_render_tags_pages", "as-tools-general", "as_tools_general_section");
    add_settings_field("as_categorypages", "Categories for Pages", "as_tools_render_category_pages", "as-tools-general", "as_tools_general_section");
    add_settings_field("as_remove_noreferrer", "Remove noreferrer & noopener", "as_tools_render_noreferrer_field", "as-tools-general", "as_tools_general_section");
    add_settings_field("as_remove_noreferrer_js", "Remove noreferrer & noopener with JS", "as_tools_render_check_js", "as-tools-general", "as_tools_general_section");
    add_settings_field("as_allow_sc", "Shortcode for Title", "as_tools_render_shortcode_title", "as-tools-general", "as_tools_general_section");
    add_settings_field("as_svg", "SVG Images", "as_tools_render_allow_svg", "as-tools-general", "as_tools_general_section");
    add_settings_field("as_fontawesome", "FontAwesome", "as_tools_render_fontawesome", "as-tools-general", "as_tools_general_section");
