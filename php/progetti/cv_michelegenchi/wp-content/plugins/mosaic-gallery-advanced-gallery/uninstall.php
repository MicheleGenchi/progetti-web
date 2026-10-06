<?php
if (!defined('WP_UNINSTALL_PLUGIN')) {
    exit();
}

delete_option('migy_show_activation_popup');
delete_option('migy_show_deactivation_popup');
delete_option('migy-filter-category_default');
