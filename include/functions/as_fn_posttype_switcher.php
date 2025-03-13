<?php

/*
** Version: 0.2 - AS Change Posttype
*/

function as_add_post_type_switcher() {
  global $post;
  if (!$post || wp_is_post_autosave($post->ID) || wp_is_post_revision($post->ID)) {
      return;
  }

  // Get all public post types
  $post_types = get_post_types(['public' => true], 'objects');
  $current_post_type = get_post_type($post->ID);
  ?>
  <div class="misc-pub-section misc-pub-post-type">
      <label for="as_post_type_switcher"><?php _e('Post Type:', 'textdomain'); ?></label>
      <select name="as_post_type_switcher" id="as_post_type_switcher">
          <?php foreach ($post_types as $post_type => $post_type_obj) : ?>
              <option value="<?php echo esc_attr($post_type); ?>" <?php selected($current_post_type, $post_type); ?>>
                  <?php echo esc_html($post_type_obj->labels->singular_name); ?>
              </option>
          <?php endforeach; ?>
      </select>
  </div>
  <?php
}

function as_save_post_type_switcher($post_id) {
  // Check if the field is set
  if (!isset($_POST['as_post_type_switcher'])) {
      return;
  }

  // Sanitize and get the new post type
  $new_post_type = sanitize_text_field($_POST['as_post_type_switcher']);
  $current_post_type = get_post_type($post_id);

  // Update post type only if it's changed
  if ($new_post_type && $new_post_type !== $current_post_type) {
      set_post_type($post_id, $new_post_type);
  }
}

if (get_option('as_check_switchposttype')):
    // Adds the dropdown menu to the post editor under "Publish" button
  add_action('post_submitbox_misc_actions', 'as_add_post_type_switcher');
  // Saves the new post type when the post is updated
  add_action('save_post', 'as_save_post_type_switcher');
endif;
