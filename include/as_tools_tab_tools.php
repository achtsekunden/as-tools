<?php

###### Render Fields FOR TAB TOOLS


// function activating Maintenance Mode
function as_tools_render_maintenance() {
    $option = get_option('as_check_maintenance_db');
    ?>
    <fieldset>
        <label for="as_categories">
            <input type="checkbox" name="as_check_maintenance_db" id="as_check_maintenance_db" value="1" class="wppd-ui-toggle" <?php checked(1, $option, true); ?>  /> activate the Maintenance Mode <span class="as_tooltip"><span class="as_tooltip_icon">!</span><span class="as_tooltip-text">Your page will then no longer be displayed to visitors. <b>If you are using a caching plugin, delete the cache.</span></span>
        </label>
    </fieldset>
    <?php
}

// REMOVE REVISIONS
function as_tools_render_remove_revisions() {
    $option = get_option('as_check_revisions_db');
    global $wpdb;
    $revision_count = $wpdb->get_var("SELECT COUNT(ID) FROM $wpdb->posts WHERE post_type = 'revision'");
    ?>
    <fieldset>
        <label for="as_revisions">
            <input type="checkbox" name="as_check_revisions_db" id="as_check_revisions_db" value="1" class="wppd-ui-toggle" <?php checked(1, $option, true); ?> /> remove Post/Page Revisions (new Window opens!)
        </label>
        <p class="description">remove Revisions (<span class="revision-count"><?php echo $revision_count; ?></span> Revisions found)
        <span class="as_tooltip"><span class="as_tooltip_icon">!</span><span class="as_tooltip-text">After deleting, the checkbox goes back to unchecked. To prevent your website from crashing, revisions are deleted every 100. This may take some time depending on the number of revisions.</span></span>
        </p>
    </fieldset>

    <script>
    document.addEventListener('DOMContentLoaded', function() {
    document.getElementById('submit').addEventListener('click', function() {
        if (document.getElementById('as_check_revisions_db').checked) {
            window.open('<?php echo admin_url('admin.php?action=as_delete_revisions_page'); ?>', '_blank', 'width=500,height=300');
        }
    });
});
    </script>
<?php
}

// remove Comments
function as_tools_render_remove_comments() {
    $option = get_option('as_check_comments_db');
    // count comments
    global $wpdb;
    $comments_count = $wpdb->get_var("SELECT COUNT(comment_ID) FROM $wpdb->comments WHERE comment_approved = '0'");
    ?>
    <fieldset>
        <label for="as_comments">
            <input type="checkbox" name="as_check_comments_db" id="as_check_comments_db" value="1" class="wppd-ui-toggle" <?php checked(1, $option, true); ?>  /> remove unpublished Comments (new Window opens!)
        </label>
        <p class="description">remove all unpublished comments. Only use this if you got no real comments, only spam-comments! <br>(<?php echo $comments_count; ?> unpublished Comments found)
        <span class="as_tooltip"><span class="as_tooltip_icon">!</span><span class="as_tooltip-text">After deleting, the checkbox goes back to unchecked.</span></span></p>
    </fieldset>
    <script>
document.addEventListener('DOMContentLoaded', function() {
    document.getElementById('submit').addEventListener('click', function() {
        if (document.getElementById('as_check_comments_db').checked) {
            window.open('<?php echo admin_url('admin.php?action=as_delete_comments_page'); ?>', '_blank', 'width=500,height=300');
        }
    });
});
</script>
    <?php
}

// function activating CLONE Posts
function as_tools_render_cloneposts() {
    $option = get_option('as_check_cloneposts_db');
    ?>
    <fieldset>
        <label for="as_categories">
            <input type="checkbox" name="as_check_cloneposts_db" id="as_check_cloneposts_db" value="1" class="wppd-ui-toggle" <?php checked(1, $option, true); ?>  /> activate Clone Posts / Pages <span class="as_tooltip"><span class="as_tooltip_icon">!</span><span class="as_tooltip-text">A new clone button appears in the posts/pages overview (below the title) and close to the save button. Your new post is always unpublished.</span></span>
        </label>
    </fieldset>
    <?php
}


// activate widget shortcode
function as_tools_render_widget_shortcode() {
    $option = get_option('as_check_widget_shortcode_db');
    ?>
    <fieldset>
        <label for="as_widget_sc">
            <input type="checkbox" name="as_check_widget_shortcode_db" id="as_check_widget_shortcode_db" value="1" class="wppd-ui-toggle" <?php checked(1, $option, true); ?>  /> activate a Shortcode for Widgets <span class="as_tooltip"><span class="as_tooltip_icon">!</span><span class="as_tooltip-text">The function enables shortcodes for widgets (Classic Widgets). <br>You can find the shortcode directly below the widget (Appearance -> Widgets). <br>Simply copy the shortcode and paste it into the editor where you want the widget to be displayed.</span></span>
        </label>
    </fieldset>
    <?php
}


// activate Template File in Admin Bar
function as_tools_render_templatefile() {
    $option = get_option('as_check_templatefile');
    ?>
    <fieldset>
        <label for="as_widget_sc">
            <input type="checkbox" name="as_check_templatefile" id="as_check_templatefile" value="1" class="wppd-ui-toggle" <?php checked(1, $option, true); ?>  /> show Template Files in the Admin Bar
        </label>
        <p class="description">This shows the current template name in the frontend WP admin-bar.</p>
    </fieldset>
    <?php
}
// activate Switch Post Type
function as_tools_switch_posttype() {
    $option = get_option('as_check_switchposttype');
    ?>
    <fieldset>
        <label for="as_switch">
            <input type="checkbox" name="as_check_switchposttype" id="as_check_switchposttype" value="1" class="wppd-ui-toggle" <?php checked(1, $option, true); ?>  /> activate switch Posttype Select Box in Posts and Pages <span class="as_tooltip"><span class="as_tooltip_icon">!</span><span class="as_tooltip-text">This function adds a Post Type Switcher dropdown in the WordPress post editor, allowing users to change the post type before saving or publishing. When the post is updated, the selected post type is applied automatically. It supports all public post types dynamically.</span></span>
        </label>
    </fieldset>
    <?php
}
// activate Debugging Bar
function as_tools_debuggingbar() {
    $option = get_option('as_check_debuggingbar');
    ?>
    <fieldset>
        <label for="as_switch">
            <input type="checkbox" name="as_check_debuggingbar" id="as_check_debuggingbar" value="1" class="wppd-ui-toggle" <?php checked(1, $option, true); ?>  /> show Debugging Bar in the WP admin-bar <span class="as_tooltip"><span class="as_tooltip_icon">!</span><span class="as_tooltip-text">This function captures PHP errors and displays them in the WordPress frontend admin bar under the "AS-Tools Debugging" menu. Each error is listed as a submenu item for easy access.</span></span>
        </label>
    </fieldset>
    <?php
}
