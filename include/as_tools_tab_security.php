<?php

###### Render Fields FOR TAB Security


// WP CRON
function as_tools_render_wpcron_field() {
    $option = get_option('as_check_wpcron_db');
    ?>
    <fieldset>
        <label for="as_wpcron">
            <input type="checkbox" id="as_check_wpcron_db" name="as_check_wpcron_db" value="1" class="wppd-ui-toggle" <?php checked(1, $option, true); ?> />
            disable WP-Cron
        </label>
        <p class="description">Preventing WordPress from checking for scheduled events on every page load. <br>If disabled, you should add a cron in your serversettings for getting WP and Plugins updates. Maybe for every 30minutes. <span class="as_tooltip"><span class="as_tooltip_icon">!</span><span class="as_tooltip-text">WP-Cron can be called externally via wp-cron.php (http://example.com/wp-cron.php), which could be abused for DDoS attacks. Some bots or attackers could try to trigger WP-Cron calls specifically to consume resources.</span></span> </p>
    </fieldset>
    <?php
}
// REST API
function as_tools_render_restapi_field() {
    $option = get_option('as_check_restapi_db');
    ?>
    <fieldset>
        <label for="as_remove_restapi">
            <input type="checkbox" id="as_check_restapi_db" name="as_check_restapi_db" value="1" class="wppd-ui-toggle" <?php checked(1, $option, true); ?> />
            disable Rest API
        </label>
        <p class="description">REST API remains allowed for logged in users, removes the REST API header from the HTTP response headers and from head.
        <br/> Check if it is working by coping the link: <code><?php echo site_url();?>/wp-json</code> <br/>You should see <code>REST API access is restricted to logged-in users.</code>
        <span class="as_tooltip"><span class="as_tooltip_icon">!</span><span class="as_tooltip-text">User Data Exposure: By default, WordPress REST API exposes information like user IDs, which attackers could use for username enumeration (e.g., example.com/wp-json/wp/v2/users). Unauthorized Access: Some plugins rely on the REST API and may introduce security vulnerabilities if not properly secured.</span></span> </p>
    </fieldset>
    <?php
}

// disable XML RPC
function as_tools_render_xmlrpc_field() {
    $option = get_option('as_check_xmlrpc_db');
    ?>
    <fieldset>
        <label for="as_remove_xmlrpc">
            <input type="checkbox" id="as_check_xmlrpc_db" name="as_check_xmlrpc_db" value="1" class="wppd-ui-toggle" <?php checked(1, $option, true); ?> />
            disable XML RPC
        </label>
        <p class="description">XML-RPC is often the target of brute-force attacks. DDoS attacks can be amplified via XML-RPC.</p>
    </fieldset>
    <?php
}

// disable right click frontend
function as_tools_render_rightclick() {
    $option = get_option('as_check_rightclick_db');
    ?>
    <fieldset>
        <label for="as_rightclick">
            <input type="checkbox" id="as_check_rightclick_db" name="as_check_rightclick_db" value="1" class="wppd-ui-toggle" <?php checked(1, $option, true); ?> />
            activate copy protection
        </label>
        <p class="description">Blocks right click (no context menu display), Prevents Ctrl + C, Ctrl + X and Ctrl + U (no copying, source code view), Disables Mark & Copy. <span class="as_tooltip"><span class="as_tooltip_icon">!</span><span class="as_tooltip-text">This is a JavaScript function. If it's not working, delete your browsercache and try again. </span></span> </p>
    </fieldset>
    <?php
}

// disable comments
function as_tools_render_disable_comments() {
    $option = get_option('as_check_disable_comments_db');
    ?>
    <fieldset>
        <label for="as_remove_comments">
            <input type="checkbox" id="as_check_disable_comments_db" name="as_check_disable_comments_db" value="1" class="wppd-ui-toggle" <?php checked(1, $option, true); ?> />
            disable Comments
        </label>
        <p class="description">If you don´t want to offer comments in your workflow.</p>
    </fieldset>
    <?php
}

// redirect failed logib to home
function as_tools_render_redirect_failedlogin() {
    $option = get_option('as_check_failed_login_db');
    ?>
    <fieldset>
        <label for="as_remove_failedlogin">
            <input type="checkbox" id="as_check_failed_login_db" name="as_check_failed_login_db" value="1" class="wppd-ui-toggle" <?php checked(1, $option, true); ?> />
            redirect failed login
        </label>
        <p class="description">If an incorrect login attempt is detected, the user is redirected to the homepage</p>
    </fieldset>
    <?php
}

// Hide WP Version
function as_tools_render_hide_version() {
    $option = get_option('as_check_hide_version_db');
    ?>
    <fieldset>
        <label for="as_remove_hide">
            <input type="checkbox" id="as_check_hide_version_db" name="as_check_hide_version_db" value="1" class="wppd-ui-toggle" <?php checked(1, $option, true); ?> />
            Hide WP Version in Code  <span class="as_tooltip"><span class="as_tooltip_icon">!</span><span class="as_tooltip-text">This means that the WordPress version is no longer visible in the source code or resource URLs.</span></span>
        </label>
    </fieldset>
    <?php
}


//remove X-Powered by Header
function as_tools_render_xpower() {
    $option = get_option('as_check_xpower_db');
    ?>
    <fieldset>
        <label for="as_remove_xpower">
            <input type="checkbox" id="as_check_xpower_db" name="as_check_xpower_db" value="1" class="wppd-ui-toggle" <?php checked(1, $option, true); ?> />
            remove Header X-Powered-By  <span class="as_tooltip"><span class="as_tooltip_icon">!</span><span class="as_tooltip-text">Removing the HTTP header X-Powered-By is a common security practice because this header reveals information about the technology used (e.g. PHP)..</span></span>
        </label>
    </fieldset>
    <?php
}



// Change Login Path
function as_tools_render_change_login() {
    $option = get_option('as_check_change_login_db'); // Default Value
    ?>
    <fieldset>
        <label for="as_check_change_login_db">
            <input type="text" id="as_check_change_login_db" name="as_check_change_login_db" value="<?php echo esc_attr($option); ?>" class="regular-text wp-ui-text-input"
            pattern="[a-zA-Z0-9-_]{5,50}" title="Only letters, numbers, hyphens, and underscores (5-50 chars)" maxlength="50" placeholder="enter your new login path..."/>
            <p class="description">Enter a custom login path (e.g., "my-secret-login"). Allowed: letters, numbers, hyphens, underscores (5-50 chars).</p>
        </label>
    </fieldset>
    <?php
}
// Sanitize & Validate Input
function as_tools_sanitize_change_login($input) {
    $input = sanitize_text_field($input); // Entfernt unsichere Zeichen
    $input = preg_replace('/[^a-zA-Z0-9-_]/', '', $input); // Erlaubt nur Buchstaben, Zahlen, - und _
    $input = substr($input, 0, 50); // Begrenzung auf max. 50 Zeichen
    return $input;
}


//Block XSS attacks
function as_tools_block_xss() {
    $option = get_option('as_check_htaccess_cross_db');
    ?>
    <fieldset>
        <label for="as_remove_cross">
            <input type="checkbox" id="as_check_htaccess_cross_db" name="as_check_htaccess_cross_db" value="1" class="wppd-ui-toggle" <?php checked(1, $option, true); ?> />
            Block XSS attacks (only for Apache Server)  <span class="as_tooltip"><span class="as_tooltip_icon">!</span><span class="as_tooltip-text">(Please backup your htaccess file before) Uses Apache mod_rewrite to block malicious query strings. Prevents access to GLOBALS and _REQUEST variables, common XSS targets. Blocks suspicious characters (|>, encoded inputs) in URLs. Denies access (403 Forbidden) if any condition matches.</span></span>
        </label>
    </fieldset>
    <?php
}

//adding Restrict Direct Access To Plugin and Theme PHP files rule
function as_tools_restrict_access() {
    $option = get_option('as_check_htaccess_accessthemeplugins_db');
    ?>
    <fieldset>
        <label for="as_restrict">
            <input type="checkbox" id="as_check_htaccess_accessthemeplugins_db" name="as_check_htaccess_accessthemeplugins_db" value="1" class="wppd-ui-toggle" <?php checked(1, $option, true); ?> />
            Restrict Direct Access To Plugin and Theme PHP files rule (only for Apache Server) <span class="as_tooltip"><span class="as_tooltip_icon">!</span><span class="as_tooltip-text">(Please backup your htaccess file before) This function enhances WordPress security by preventing direct access to PHP files inside the wp-content/plugins/ and wp-content/themes/ directories using .htaccess rules.</span></span>
        </label>
    </fieldset>
    <?php
}

//adding HTTP Security Headers
function as_tools_http_header() {
    $option = get_option('as_check_http_header');
    ?>
    <fieldset>
        <label for="as_httpheader">
            <input type="checkbox" id="as_check_http_header" name="as_check_http_header" value="1" class="wppd-ui-toggle" <?php checked(1, $option, true); ?> />
            activate HTTP Security Headers <span class="as_tooltip"><span class="as_tooltip_icon">!</span><span class="as_tooltip-text">The function adds key HTTP security headers to your WordPress site: HSTS: Enforces HTTPS. CSP: Controls where content can be loaded from. X-Content-Type-Options: Prevents MIME type misinterpretation. X-Frame-Options: Blocks embedding in iframes. X-XSS-Protection: Protects against XSS attacks.It enhances security by modifying headers via WordPress.</span></span>
        </label>
    </fieldset>
    <?php
}


#################### BLOCK IPS

// Funktion zur Anzeige des Textfeldes und der Checkbox
function as_tools_render_blockIPs_field() {
    $ips = get_option('as_blockip_db', '');
    $block_ips_enabled = get_option('as_blockip_enabled', 0);  // default deactivated
    ?>
    <p><small>Be very careful. Use only correct IP syntax like <code>192.168.1.1</code><br>
    Please enter one IP address per line. Don´t use Comma, <b>only Linebreaks</b>. Only IPs are allowed. The entries will be added to the .htaccess file.<br>Not working for NGINX Server.</small></p>
    <textarea id="as_blockip_db" name="as_blockip_db" rows="10" cols="50" class="large-text code"><?php echo esc_textarea($ips); ?></textarea>
    <p><small><input type="checkbox" id="as_blockip_enabled" name="as_blockip_enabled" value="1" <?php checked(1, $block_ips_enabled); ?> />
        <b>Enable IP Block</b></small>
    </p>
    <?php
}
