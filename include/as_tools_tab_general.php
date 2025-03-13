<?php

###### Render Fields FOR TAB General

function as_tools_render_noreferrer_field() {
    $option = get_option('as_check_noreferrer_db');
    ?>
    <fieldset>
        <label for="as_remove_noreferrer">
            <input type="checkbox" id="as_check_noreferrer_db" name="as_check_noreferrer_db" value="1" class="wppd-ui-toggle" <?php checked(1, $option, true); ?> />
            removes noopener and norefferer from links.
        </label>
        <p class="description">remove noopener and norefferer on the frontend, but will still show up in the wordpress editor.</p>
    </fieldset>
    <?php
}


// function for displaying js
function as_tools_render_check_js()
{ ?>
    <fieldset>
    <label for="as_check_js">
        <input type="checkbox" name="as_check_js_db" id="as_check_js_db" value="1" class="wppd-ui-toggle" <?php checked(1, get_option('as_check_js_db'), true); ?>  />
        remove noopener and norefferer with JavaScript
    </label>
    <p class="description">just use this in case the other version is not working. This will try to remove with JavaScript. <br>jQuery will be included then. </p>
    </fieldset>
    <?php
}

// function for adding TAGS to pages
function as_tools_render_tags_pages() { ?>
    <fieldset>
        <label for="as_tags">
            <input type="checkbox" name="as_check_tags_pages_db" id="as_check_tags_pages_db" value="1" class="wppd-ui-toggle" <?php checked(1, get_option('as_check_tags_pages_db'), true); ?>  /> Tags for Pages.
        </label>
        <p class="description">Click here, if you want to add the Tag functionality to pages.</p>
    </fieldset>
    <?php
}

// function for adding CATEGORIES to pages
function as_tools_render_category_pages() {
    $option = get_option('as_check_category_pages_db');
    ?>
    <fieldset>
        <label for="as_categories">
            <input type="checkbox" name="as_check_category_pages_db" id="as_check_category_pages_db" value="1" class="wppd-ui-toggle" <?php checked(1, $option, true); ?>  /> Categories for pages.
        </label>
        <p class="description">only if you want to add the Category functionality to pages and custom post types.</p>
    </fieldset>
    <?php
}

// function activating Maintenance Mode
function as_tools_render_maintenance() {
    $option = get_option('as_check_maintenance_db');
    ?>
    <fieldset>
        <label for="as_categories">
            <input type="checkbox" name="as_check_maintenance_db" id="as_check_maintenance_db" value="1" class="wppd-ui-toggle" <?php checked(1, $option, true); ?>  /> activate the Maintenance Mode
        </label>
        <p class="description">Your page will then no longer be displayed to visitors. <b>If you are using a caching plugin, delete the cache.</b></p>
    </fieldset>
    <?php
}

// allow SCs title
function as_tools_render_shortcode_title() {
    $option = get_option('as_check_sc_title');
    ?>
    <fieldset>
        <label for="as_retitle">
            <input type="checkbox" name="as_check_sc_title" id="as_check_sc_title" value="1" class="wppd-ui-toggle" <?php checked(1, $option, true); ?>  /> allow Shortcodes for Title
        </label>
        <p class="description">allow Shortcodes for wordpress title field (and YOAST title field)</p>
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

// allow SVG Image Type
function as_tools_render_allow_svg() {
    $option = get_option('as_check_svg_db');
    ?>
    <fieldset>
        <label for="as_svg">
            <input type="checkbox" name="as_check_svg_db" id="as_check_svg_db" value="1" class="wppd-ui-toggle" <?php checked(1, $option, true); ?>  /> enable SVG Image Type
        </label>
        <p class="description">Enable and you can upload SVG image type.</p>
    </fieldset>
    <?php
}
// add fontawesome
function as_tools_render_fontawesome() {
    $option = get_option('as_check_fontawesome_db');
    ?>
    <fieldset>
        <label for="as_fontawesome">
            <input type="checkbox" name="as_check_fontawesome_db" id="as_check_fontawesome_db" value="1" class="wppd-ui-toggle" <?php checked(1, $option, true); ?>  /> add FontAwesome
        </label>
        <p class="description">this will import Fontawesome to your website and is hosted by your server and not from CDN. Normally this comes with Version 6. <br/>Don´t activate if you already use FontAwesome in your Theme.</p>
    </fieldset>
    <?php
}

// activate widget shortcode
function as_tools_render_widget_shortcode() {
    $option = get_option('as_check_widget_shortcode_db');
    ?>
    <fieldset>
        <label for="as_widget_sc">
            <input type="checkbox" name="as_check_widget_shortcode_db" id="as_check_widget_shortcode_db" value="1" class="wppd-ui-toggle" <?php checked(1, $option, true); ?>  /> activate a Shortcode for Widgets
        </label>
        <p class="description">The function enables shortcodes for widgets (Classic Widgets). <br>You can find the shortcode directly below the widget (Appearance -> Widgets). <br>Simply copy the shortcode and paste it into the editor where you want the widget to be displayed..</p>
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
