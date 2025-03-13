<?php

###### Render Fields FOR TAB Performance


// remove feeds
function as_tools_render_remove_feeds() {
    $option = get_option('as_check_feed_db');
    ?>
    <fieldset>
        <label for="as_feeds">
            <input type="checkbox" name="as_check_feed_db" id="as_check_feed_db" value="1" class="wppd-ui-toggle" <?php checked(1, $option, true); ?>  /> remove Feeds
        </label>
        <p class="description">Check this if you want to disable RSS and Atom feeds from WP</p>
    </fieldset>
    <?php
}

// remove rsd
function as_tools_render_remove_rsd() {
    $option = get_option('as_check_rsd_db');
    ?>
    <fieldset>
        <label for="as_rsd">
            <input type="checkbox" name="as_check_rsd_db" id="as_check_rsd_db" value="1" class="wppd-ui-toggle" <?php checked(1, $option, true); ?>  /> remove RSD Link
        </label>
        <p class="description">remove this from code: <code>&lt;link rel="EditURI" type="application/rsd+xml" title="RSD"&gt;</code></p>
    </fieldset>
    <?php
}

// remove EMOTICONS
function as_tools_render_remove_emoticons() {
    $option = get_option('as_check_emoticons_db');
    ?>
    <fieldset>
        <label for="as_emoticons">
            <input type="checkbox" name="as_check_emoticons_db" id="as_check_emoticons_db" value="1" class="wppd-ui-toggle" <?php checked(1, $option, true); ?>  /> remove Emoticons
        </label>
        <p class="description">remove the default emojis scripts</p>
    </fieldset>
    <?php
}

// remove EMBEDS
function as_tools_render_remove_embeds() {
    $option = get_option('as_check_embeds_db');
    ?>
    <fieldset>
        <label for="as_emoticons">
            <input type="checkbox" name="as_check_embeds_db" id="as_check_embeds_db" value="1" class="wppd-ui-toggle" <?php checked(1, $option, true); ?>  /> remove Embeds
        </label>
        <p class="description">remove the default embeds scripts like wp-embed.min.js</p>
    </fieldset>
    <?php
}

// remove WOO COMMERCE BLOCK STYLES
function as_tools_render_remove_wbs() {
    $option = get_option('as_check_wbs_db');
    ?>
    <fieldset>
        <label for="as_emoticons">
            <input type="checkbox" name="as_check_wbs_db" id="as_check_wbs_db" value="1" class="wppd-ui-toggle" <?php checked(1, $option, true); ?>  /> remove Woocommerce Block Styles
        </label>
    </fieldset>
    <?php
}
// remove jquery migrate script
function as_tools_render_remove_migrate() {
    $option = get_option('as_check_migrate_db');
    ?>
    <fieldset>
        <label for="as_emoticons">
            <input type="checkbox" name="as_check_migrate_db" id="as_check_migrate_db" value="1" class="wppd-ui-toggle" <?php checked(1, $option, true); ?>  /> remove jQuery Migrate Script
        </label>
    </fieldset>
    <?php
}

/* BROWSER CACHE  */

// add caching
function as_tools_render_cache() {
    $option = get_option('as_check_cache_db');
    if(!is_multisite() ){
    ?>
    <fieldset>
        <label for="as_emoticons">
            <input type="checkbox" name="as_check_cache_db" id="as_check_cache_db" value="1" class="wppd-ui-toggle" <?php checked(1, $option, true); ?>  /> Enable Caching
        </label>
        <p class="description">additional Compressing server files and Caching for Apache Server. Not working at NGINX Server. Don´t use it if you are already using caching plugin solutions.
        <span class="as_tooltip"><span class="as_tooltip_icon">!</span><span class="as_tooltip-text">Caching (mod_expires & mod_headers): CSS & JavaScript → 1 year, Images (JPEG, PNG, GIF, SVG, WebP) → 1 year, Videos (MP4, OGG, WebM) → 1 year, Web fonts (WOFF, WOFF2, TTF, OTF) → 1 year, HTML → No caching (0 seconds), Compression (mod_deflate): Text files (HTML, CSS, JS, JSON, XML) → GZIP compression, SVG & fonts → GZIP compression, Images are excluded.</span></span></p>
    </fieldset>
    <?php } else{
        echo "not for multisite";
    }
}

// Reduce Heartbeat frequency
function as_tools_render_heartbeat() {
    $option = get_option('as_check_heartbeat_db');
    ?>
    <fieldset>
        <label for="as_heartbeat">
            <input type="checkbox" name="as_check_heartbeat_db" id="as_check_heartbeat_db" value="1" class="wppd-ui-toggle" <?php checked(1, $option, true); ?>  /> Reduce Heartbeat frequency <span class="as_tooltip"><span class="as_tooltip_icon">!</span><span class="as_tooltip-text">This feature reduces the frequency of the Heartbeat API to 60 seconds (default is 15 sec) instead of disabling the API completely.</span></span>
        </label>
    </fieldset>
    <?php
}
