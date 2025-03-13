<?php

/*
** Version: 0.1 - AS function for adding Sitemap

Changelog:
Version: 0.1 - 21.02.2025 - created the basic function
*/


class As_Sitemap_Generator {
    private $sitemap_index = [];

    public function __construct() {
        // Check if the sitemap option is enabled
        if (get_option('as_check_sitemap_db') == 1) {
            add_action('init', [$this, 'as_register_sitemap_routes']);
            add_action('template_redirect', [$this, 'as_handle_sitemap_request']);
        }
    }

    // Register sitemap routes
    public function as_register_sitemap_routes() {
        add_rewrite_rule('as-sitemap.xml$', 'index.php?sitemap=as_index', 'top');
        add_rewrite_rule('as-post-sitemap([0-9]+)?\.xml$', 'index.php?sitemap=as_posts&paged=$matches[1]', 'top');
        add_rewrite_rule('as-page-sitemap([0-9]+)?\.xml$', 'index.php?sitemap=as_pages&paged=$matches[1]', 'top');
        add_rewrite_rule('as-archive-sitemap([0-9]+)?\.xml$', 'index.php?sitemap=as_archives&paged=$matches[1]', 'top');
        add_rewrite_rule('as-([a-zA-Z0-9_-]+)-sitemap([0-9]+)?\.xml$', 'index.php?sitemap=as_custom&post_type=$matches[1]&paged=$matches[2]', 'top');
    }

    // Generate the main sitemap (index page)
    public function as_generate_sitemap_index() {
        header('Content-Type: application/xml; charset=utf-8');
        echo "<?xml version='1.0' encoding='UTF-8'?>\n";
        echo "<sitemapindex xmlns='http://www.sitemaps.org/schemas/sitemap/0.9'>\n";

        // Current date for last modification
        $lastmod = current_time('Y-m-d\TH:i:s+00:00');

        // Check for standard post types
        $this->as_maybe_add_sitemap('post', 'as-post-sitemap.xml', $lastmod);
        $this->as_maybe_add_sitemap('page', 'as-page-sitemap.xml', $lastmod);
        $this->as_maybe_add_sitemap('post', 'as-archive-sitemap.xml', $lastmod, true); // Archives for post types

        // Add paginated post sitemaps
        $this->as_add_paginated_sitemaps('post', 'as-post-sitemap', $lastmod);

        // Recognize and add custom post types
        $post_types = get_post_types(['public' => true], 'names');

        foreach ($post_types as $post_type) {
            if (!in_array($post_type, ['post', 'page'])) { // 'post' and 'page' are already handled
                $this->as_add_paginated_sitemaps($post_type, "as-{$post_type}-sitemap", $lastmod);
            }
        }

        // Go through all sitemaps and output them
        foreach ($this->sitemap_index as $sitemap) {
            echo "\t<sitemap>\n";
            echo "\t\t<loc>" . esc_url($sitemap['loc']) . "</loc>\n";
            echo "\t\t<lastmod>" . esc_html($sitemap['lastmod']) . "</lastmod>\n";
            echo "\t</sitemap>\n";
        }

        echo "</sitemapindex>\n";
        exit;
    }

    public function as_add_paginated_sitemaps($post_type, $sitemap_base_name, $lastmod) {
        $paged = 1;
        while (true) {
            $url = home_url("/{$sitemap_base_name}{$paged}.xml");
            $query = new WP_Query([
                'post_type' => $post_type,
                'posts_per_page' => 100,
                'paged' => $paged,
                'no_found_rows' => true,
            ]);
            if ($query->have_posts()) {
                $this->as_add_sitemap($url, $lastmod);
            } else {
                break; // Stop pagination if no more posts are found
            }
            $paged++;
        }
    }


    // Function to add sitemaps if they contain posts
    public function as_maybe_add_sitemap($post_type, $sitemap_filename, $lastmod, $is_archive = false) {
        if ($is_archive) {
            // Check for archives
            $query = new WP_Query([
                'post_type' => $post_type,
                'posts_per_page' => 1, // Only check if there are any posts
                'no_found_rows' => true,
                'fields' => 'ids',
            ]);
            if ($query->have_posts()) {
                $this->as_add_sitemap(home_url("/{$sitemap_filename}"), $lastmod);
            }
        } else {
            // Check for posts or custom post types
            $query = new WP_Query([
                'post_type' => $post_type,
                'posts_per_page' => 1, // Only check if there are any posts
                'no_found_rows' => true,
                'fields' => 'ids',
            ]);
            if ($query->have_posts()) {
                $this->as_add_sitemap(home_url("/{$sitemap_filename}"), $lastmod);
            }
        }
    }

    // Add sitemap to the index file
    public function as_add_sitemap($loc, $lastmod) {
        $this->sitemap_index[] = [
            'loc' => $loc,
            'lastmod' => $lastmod
        ];
    }

    public function as_generate_post_sitemap($paged = 1) {
        header('Content-Type: application/xml; charset=utf-8');
        echo "<?xml version='1.0' encoding='UTF-8'?>\n";
        echo "<urlset xmlns='http://www.sitemaps.org/schemas/sitemap/0.9'>\n";

        // Arguments for WP_Query with pagination
        $args = [
            'post_type'      => 'post',
            'posts_per_page' => 100, // Maximum posts per page
            'paged'          => $paged,
        ];

        $query = new WP_Query($args);

        // Loop through posts and add URLs
        if ($query->have_posts()) {
            while ($query->have_posts()) {
                $query->the_post();
                echo "\t<url>\n";
                echo "\t\t<loc>" . esc_url(get_permalink()) . "</loc>\n";
                echo "\t\t<lastmod>" . get_the_modified_date('c') . "</lastmod>\n";
                echo "\t</url>\n";
            }
        }

        wp_reset_postdata();

        echo "</urlset>\n";
        exit;
    }


     // Generate sitemap for custom post types
     public function as_generate_custom_post_type_sitemap($post_type, $paged = 1) {
        header('Content-Type: application/xml; charset=utf-8');
        echo "<?xml version='1.0' encoding='UTF-8'?>\n";
        echo "<urlset xmlns='http://www.sitemaps.org/schemas/sitemap/0.9'>\n";

        // Arguments for WP_Query with pagination
        $args = [
            'post_type' => $post_type,
            'posts_per_page' => 100, // Maximum custom posts per page
            'paged' => $paged,
        ];

        $query = new WP_Query($args);

        // Loop through custom posts and add URLs
        if ($query->have_posts()) {
            while ($query->have_posts()) {
                $query->the_post();
                echo "\t<url>\n";
                echo "\t\t<loc>" . esc_url(get_permalink()) . "</loc>\n";
                echo "\t\t<lastmod>" . get_the_modified_date('c') . "</lastmod>\n";
                echo "\t</url>\n";
            }
        }

        wp_reset_postdata();

        echo "</urlset>\n";
        exit;
    }

    // Process the sitemap request and decide which sitemap to output
    public function as_handle_sitemap_request() {
        $sitemap = get_query_var('sitemap');
        $paged = get_query_var('paged') ? get_query_var('paged') : 1;
        $post_type = get_query_var('post_type');

        if ($sitemap === 'as_index') {
            $this->as_generate_sitemap_index();
        } elseif ($sitemap === 'as_posts') {
            $this->as_generate_post_sitemap($paged);
        } elseif ($sitemap === 'as_pages') {
            $this->as_generate_page_sitemap($paged);
        } elseif ($sitemap === 'as_archives') {
            $this->as_generate_archive_sitemap($paged);
        } elseif ($sitemap === 'as_custom' && $post_type) {
            $this->as_generate_custom_post_type_sitemap($post_type, $paged);
        }
    }
}

// Instantiate the class
new As_Sitemap_Generator();
