<?php

    ### ----------- Performance Settings
    add_settings_section('as_tools_performance_section', 'Performance Settings', 'as_tools_performance_section_callback', 'as-tools-performance');

    /* register for DB */
    register_setting('as_tools_settings_performance', 'as_check_feed_db');
    register_setting('as_tools_settings_performance', 'as_check_rsd_db');
    register_setting('as_tools_settings_performance', 'as_check_emoticons_db');
    register_setting('as_tools_settings_performance', 'as_check_embeds_db');
    register_setting('as_tools_settings_performance', 'as_check_wbs_db');
    register_setting('as_tools_settings_performance', 'as_check_migrate_db');
    register_setting('as_tools_settings_performance', 'as_check_cache_db');
    register_setting('as_tools_settings_performance', 'as_check_heartbeat_db');

    # ->  // SYNTAX: NAME, LABELNAME, FUNKTIONSNAME, TAB NAME,  TAB SECTION
    add_settings_field("as_remove_feed", "Remove Feeds", "as_tools_render_remove_feeds", "as-tools-performance", "as_tools_performance_section");
    add_settings_field("as_remove_rsd", "RSD Link", "as_tools_render_remove_rsd", "as-tools-performance", "as_tools_performance_section");
    add_settings_field("as_remove_emoticons", "Emojis", "as_tools_render_remove_emoticons", "as-tools-performance", "as_tools_performance_section");
    add_settings_field("as_remove_embeds", "Embeds", "as_tools_render_remove_embeds", "as-tools-performance", "as_tools_performance_section");
    add_settings_field("as_remove_wbs", "WooCommerce Blockstyles", "as_tools_render_remove_wbs", "as-tools-performance", "as_tools_performance_section");
    add_settings_field("as_remove_migrate", "jQuery Migrate", "as_tools_render_remove_migrate", "as-tools-performance", "as_tools_performance_section");
    add_settings_field("as_caching", "Caching & Compressing", "as_tools_render_cache", "as-tools-performance", "as_tools_performance_section");
    add_settings_field("as_heartbeat", "Heartbeat", "as_tools_render_heartbeat", "as-tools-performance", "as_tools_performance_section");
