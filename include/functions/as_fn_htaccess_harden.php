<?php

// htaccess harden by wordpress permalinks

if(get_option('as_check_hardener_db')):
    add_filter('flush_rewrite_rules_hard','__return_false');
endif;
