<?php

###### Render Fields FOR TAB SEO TOOLS

function as_tools_render_lowercase_field() {
    $option = get_option('as_check_lowercase_db');
    ?>
    <fieldset>
        <label for="as_remove_noreferrer">
            <input type="checkbox" id="as_check_lowercase_db" name="as_check_lowercase_db" value="1" class="wppd-ui-toggle" <?php checked(1, $option, true); ?> />
            activate Lowercase redirect
        </label>
        <p class="description">forces Wordpress to lowercase the URLs, like: domain.tld/XYZ -> domain.tld/xyz</p>
    </fieldset>
    <?php
}
// noindex pagination
function as_tools_render_pagination_field() {
    $option = get_option('as_check_pagination_db');
    ?>
    <fieldset>
        <label for="as_remove_pagi">
            <input type="checkbox" id="as_check_pagination_db" name="as_check_pagination_db" value="1" class="wppd-ui-toggle" <?php checked(1, $option, true); ?> />
            add noindex to paginated pages
        </label>
        <p class="description">This is a WordPress feature that ensures that all pagination pages starting from <b>/page/2/</b> are noindexed. <br>This helps avoid duplicate content and SEO problems with paginated pages. <span class="as_tooltip"><span class="as_tooltip_icon">!</span><span class="as_tooltip-text">adds meta name="robots" content="noindex, follow" to head.</span></span></p>
    </fieldset>
    <?php
}
// 404 redirect
function as_tools_render_404_field() {
    $option = get_option('as_check_404_db');
    ?>
    <fieldset>
        <label for="as_404">
            <input type="checkbox" id="as_check_404_db" name="as_check_404_db" value="1" class="wppd-ui-toggle" <?php checked(1, $option, true); ?> />
            activate 404 redirect to home
        </label>
        <p class="description">Redirects all 404 pages to your homepage. </p>
    </fieldset>
    <?php
}
// Clean Archive Title
function as_tools_render_archivetitle() {
    $option = get_option('as_check_archivetitle_db');
    ?>
    <fieldset>
        <label for="as_404">
            <input type="checkbox" id="as_check_archivetitle_db" name="as_check_archivetitle_db" value="1" class="wppd-ui-toggle" <?php checked(1, $option, true); ?> />
            remove "Category:" from Archive Title
        </label>
        <p class="description">removes "Category:", "Tag:" and "Author:" from Archives.<br>Use only if you have this kind of problem. </p>
    </fieldset>
    <?php
}


// Function to display the sitemap option in the admin area
function as_tools_render_sitemap_option() {
    $option = get_option('as_check_sitemap_db');
    ?>
    <fieldset>
        <label for="as_check_sitemap_db">
            <input type="checkbox" id="as_check_sitemap_db" name="as_check_sitemap_db" value="1" class="wppd-ui-toggle" <?php checked(1, $option, true); ?> />
            enable Sitemaps
        </label>
        <p class="description">Enable this option to generate the sitemap. If disabled, the sitemap will not be created. Maybe you have to update your permalinks. <br>If enabled, your Sitemap is here <a href="<?php echo site_url();?>/as-sitemap_xml" target="_blank"><?php echo site_url();?>/as-sitemap.xml</a> <span class="as_tooltip"><span class="as_tooltip_icon">!</span><span class="as_tooltip-text">This sitemap is not working with YOAST Sitemap. If you want to use YOAST and this Sitemap, just deactivate the YOAST Sitemap:<br>
        Go to SEO > General in the Yoast settings.
        Switch to the Features tab.
        Scroll down to XML Sitemaps and disable it.
        Save the changes.
        Save permalinks again (see previous instructions).
        Test your sitemap again (as-post-sitemap.xml).
        </span></span></p>
    </fieldset>
    <?php
}


//adding GTM ID
function as_tools_gtm() {
    $option = get_option('as_check_gtm');
    ?>
    <fieldset>
        <label for="as_check_gtm">
            <input type="text" id="as_check_gtm" name="as_check_gtm" value="<?php echo esc_attr($option); ?>" class="regular-text wp-ui-text-input"
            pattern="[a-zA-Z0-9-_]{5,50}" title="Only letters, numbers, hyphens, and underscores (5-50 chars)" maxlength="30" placeholder="GTM-XXXXXX"/>
            <p class="description">Just paste your GTM-ID like GTM-XXXXXX in this field. Allowed: letters, numbers, hyphens, underscores (5-50 chars).</p>
        </label>
    </fieldset>
    <?php
}
