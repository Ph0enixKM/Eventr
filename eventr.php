<?php

/*
Plugin Name: Eventr
Plugin URI: https://github.com/Ph0enixKM/Eventr
Description: Create events easily
Version: 0.1.0
Author: Paweł Karaś
Author URI: https://github.com/Ph0enixKM
*/

// Prevent from accessing directly
if (!defined('ABSPATH')) {
    exit;
}

require_once(plugin_dir_path(__FILE__).'/includes/scripts.php');
require_once(plugin_dir_path(__FILE__).'/includes/class.php');
require_once(plugin_dir_path(__FILE__).'/includes/settings.php');

function register_eventr() {
    register_widget('Eventr_Widget');
}

add_action('widgets_init', 'register_eventr');

?>