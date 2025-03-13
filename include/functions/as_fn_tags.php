<?php

// add tag and category support to pages
function as_add_tags_to_pages() {
    register_taxonomy_for_object_type('post_tag', 'page');
}
function as_add_category_to_pages() {
  register_taxonomy_for_object_type('category', 'page');
}

// ensure all tags are included in queries
function as_tags_register_query($wp_query) {
  if ($wp_query->get('tag')) $wp_query->set('post_type', 'any');
}

// ensure all categories are included in queries
function as_category_register_query($wp_query) {
  if ($wp_query->get('category_name')) $wp_query->set('post_type', 'any');
}

// custom post types
function as_add_tags_and_categories_to_custom_post_types() {
  $post_types = get_post_types(array('public' => true), 'names'); // get all CPTs

  foreach ($post_types as $post_type) {
      //register_taxonomy_for_object_type('post_tag', $post_type);
      register_taxonomy_for_object_type('category', $post_type);
  }
}

// if active TAG
if(get_option('as_check_tags_pages_db')):
    add_action('init', 'as_add_tags_to_pages');
    add_action('pre_get_posts', 'as_tags_register_query');
endif;

// if active CATEGORY
if(get_option('as_check_category_pages_db')):
    add_action('init', 'as_add_tags_and_categories_to_custom_post_types');
    add_action('init', 'as_add_category_to_pages');
    add_action('pre_get_posts', 'as_category_register_query');
endif;
