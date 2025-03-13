<?php

# Render Fields Tab CODE TOOLS

function as_tools_render_header_script_field() {
    $option = get_option('as_header_script', '');
    echo '<textarea id="as_header_script" name="as_header_script" rows="10" cols="50" class="large-text code">' . esc_textarea($option) . '</textarea>';
    echo '<p><small>Add a script for the header, like Analytics Code. <b>Use</b> <code>&lt;script&gt;</code> tags. You can also use <code>&lt;style&gt;</code> tags.</small></p>';
}

function as_tools_render_footer_script_field() {
    $option = get_option('as_footer_script', '');
    echo '<textarea id="as_footer_script" name="as_footer_script" rows="10" cols="50" class="large-text code">' . esc_textarea($option) . '</textarea>';
    echo '<p><small>Add a script for the footer. <b>Use</b> <code>&lt;script&gt;</code> tags.</small></p>';
}
