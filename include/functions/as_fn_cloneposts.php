<?php

/*
** Version: 0.1 - AS function for Clonung Posts
*/

// Clone function to duplicate posts including custom fields
function as_clone_post($post_id) {
    // Get the original post
    $post = get_post($post_id);

    // Ensure the post exists
    if (!$post) {
        return new WP_Error('invalid_post', 'Post not found.');
    }

    // Prepare new post data
    $new_post_data = array(
        'post_title'   => $post->post_title . ' (Copy)',
        'post_content' => $post->post_content,
        'post_excerpt' => $post->post_excerpt,
        'post_status'  => 'draft', // Set to draft
        'post_type'    => $post->post_type,
        'post_author'  => get_current_user_id(),
    );

    // Insert the cloned post
    $new_post_id = wp_insert_post($new_post_data);

    if ($new_post_id && !is_wp_error($new_post_id)) {
      // Copy custom fields including ACF fields
      $custom_fields = get_post_custom($post_id);
      if (!empty($custom_fields)) {
          foreach ($custom_fields as $key => $values) {
              foreach ($values as $value) {
                  // ACF compatibility: handle serialized fields correctly
                  update_post_meta($new_post_id, $key, maybe_unserialize($value));
              }
          }
      }
    }

    return $new_post_id;
}

// Handle the clone request via admin action
function as_handle_clone_request() {
    if (!isset($_GET['post_id']) || !isset($_GET['_wpnonce']) || !wp_verify_nonce($_GET['_wpnonce'], 'as_clone_post_' . $_GET['post_id'])) {
        wp_die('Invalid request.');
    }

    $post_id = intval($_GET['post_id']);
    $new_post_id = as_clone_post($post_id);

    if (is_wp_error($new_post_id)) {
        wp_die('Error cloning post: ' . $new_post_id->get_error_message());
    }

    wp_redirect(get_edit_post_link($new_post_id, 'redirect'));
    exit;
}



// 1️⃣ Add "Clone" option in row actions (post/page list)
function as_add_clone_link_row_action($actions, $post) {
    $url = wp_nonce_url(admin_url('admin-post.php?action=as_clone_post&post_id=' . $post->ID), 'as_clone_post_' . $post->ID);
    $actions['clone'] = '<a href="' . esc_url($url) . '" title="Clone this post">Clone</a>';
    return $actions;
}


// 2️⃣ Add "Clone Post" button in Publish Metabox (Edit Screen)
function as_add_clone_button_metabox() {
    global $post;
    if (!$post) return;

    $url = wp_nonce_url(admin_url('admin-post.php?action=as_clone_post&post_id=' . $post->ID), 'as_clone_post_' . $post->ID);
    echo '<div class="misc-pub-section"><a href="' . esc_url($url) . '" class="button button-primary">Clone Post</a></div>';
}


// 3️⃣ Add "Clone Post" button to Admin Bar (Frontend)
function as_add_clone_button_admin_bar($wp_admin_bar) {
    if (is_admin() || !is_singular()) return;

    $post_id = get_the_ID();
    $url = wp_nonce_url(admin_url('admin-post.php?action=as_clone_post&post_id=' . $post_id), 'as_clone_post_' . $post_id);

    $wp_admin_bar->add_node(array(
        'id'    => 'as_clone_post',
        'title' => 'Clone Post',
        'href'  => $url,
    ));
}

if(get_option('as_check_cloneposts_db')):
  add_action('admin_post_as_clone_post', 'as_handle_clone_request');
  add_filter('post_row_actions', 'as_add_clone_link_row_action', 10, 2);
  add_filter('page_row_actions', 'as_add_clone_link_row_action', 10, 2);
  add_action('post_submitbox_misc_actions', 'as_add_clone_button_metabox');
  add_action('admin_bar_menu', 'as_add_clone_button_admin_bar', 100);
endif;
?>
