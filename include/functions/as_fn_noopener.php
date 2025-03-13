<?php
/*
** Version: 0.1 - AS function for adding noopener function

Changelog:
Version: 0.1 - 18.02.2025 - created the basic function
*/

// Prevent direct access

if (!defined('ABSPATH')) exit;


############# FUNCTIONS ######################

    function as_targeted_link_rel_remove_noreferrer( $rel_values ) {
        return preg_replace( '/noreferrer\s*/i', '', $rel_values );
    }

    //remove noreferrer on the frontend, *will still show up in the editor.*
    function as_formatter($content) {
        $replace = array(" noreferrer" => "" );
        $new_content = strtr($content, $replace);
        return $new_content;
    }

    function as_targeted_link_rel_remove_noopener( $rel_values ) {
        return preg_replace( '/noopener\s*/i', '', $rel_values );
    }

    //remove noopener on the frontend, *will still show up in the editor.*
    function as_noopener_formatter($content) {
        $replace = array("noopener" => "" );
        $new_content = strtr($content, $replace);
        return $new_content;
    }

    //This code removes noreferrer from your new or updated posts
    function as_im_targeted_link_rel($rel_values) {
        return 'noopener';
        }

    //remove noreferrer on the frontend, but will still show in the editor
    function as_im_formatter($content) {
    $replace = array(" noreferrer" => "" ,"noreferrer " => "");
    $new_content = strtr($content, $replace);
    return $new_content;
    }



// ##################### check if clicked, add this to theme

if(get_option('as_check_noreferrer_db')):

    add_filter('wp_targeted_link_rel', 'as_im_targeted_link_rel',999);
    add_filter('the_content', 'as_im_formatter', 999);

    add_filter( 'wp_targeted_link_rel', 'as_targeted_link_rel_remove_noopener',999);
    add_filter('the_content', 'as_noopener_formatter', 999);

    add_filter( 'wp_targeted_link_rel', 'as_targeted_link_rel_remove_noreferrer',999);
    add_filter('the_content', 'as_formatter', 999);

endif;


function as_footer_scripts(){
    ?>
    <script type="text/javascript">
        document.addEventListener("DOMContentLoaded", function() {
            jQuery('a').each(function() {
                var $this = jQuery(this);
                var relAttr = $this.attr('rel');

                if (relAttr) {
                    var newRel = relAttr.replace(/\b(noreferrer|noopener)\b/g, '').trim();
                    newRel = newRel.replace(/\s{2,}/g, ' '); // Remove double spaces
                    if (newRel === '') {
                        $this.removeAttr('rel'); // Removes the attribute completely if empty
                    } else {
                        $this.attr('rel', newRel);
                    }
                }
            });
        });
    </script>
<?php
}


// if active, call as_footer_scripts
if(get_option('as_check_js_db')):
    add_action( 'wp_footer', 'as_footer_scripts' );
endif;
