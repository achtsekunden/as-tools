<?php
### ----------- SEO Settings

add_settings_section('as_tools_seo_section', 'SEO Settings', 'as_tools_seo_section_callback', 'as-tools-seo');

// adding lowercase redirects
register_setting('as_tools_settings_seo', 'as_check_lowercase_db');
register_setting('as_tools_settings_seo', 'as_check_pagination_db');
register_setting('as_tools_settings_seo', 'as_check_404_db');
register_setting('as_tools_settings_seo', 'as_check_archivetitle_db');
register_setting('as_tools_settings_seo', 'as_check_sitemap_db');
register_setting('as_tools_settings_seo', 'as_check_gtm');


add_settings_field("as_check_lowercase", "lowercase URLs", "as_tools_render_lowercase_field", "as-tools-seo", "as_tools_seo_section");
add_settings_field("as_check_pagination", "Pagination", "as_tools_render_pagination_field", "as-tools-seo", "as_tools_seo_section");
add_settings_field("as_check_404", "404 redirect", "as_tools_render_404_field", "as-tools-seo", "as_tools_seo_section");
add_settings_field("as_check_archivetitle", "Archivetitle", "as_tools_render_archivetitle", "as-tools-seo", "as_tools_seo_section");
add_settings_field("as_check_sitemap", "Sitemap-Option", "as_tools_render_sitemap_option", "as-tools-seo", "as_tools_seo_section");
add_settings_field("as_check_gtm", "GTM-ID", "as_tools_gtm", "as-tools-seo", "as_tools_seo_section");
