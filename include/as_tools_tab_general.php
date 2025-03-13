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
