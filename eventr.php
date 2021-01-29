<?php

/*
Plugin Name: Eventr
Plugin URI: https://github.com/Ph0enixKM/Eventr
Description: Create events easily
Version: 0.3.0
Author: Paweł Karaś
Author URI: https://github.com/Ph0enixKM
*/

// Prevent from accessing directly
if (!defined('ABSPATH')) {
    exit;
}

require_once(plugin_dir_path(__FILE__).'/includes/scripts.php');
require_once(plugin_dir_path(__FILE__).'/includes/widget.php');
require_once(plugin_dir_path(__FILE__).'/includes/settings.php');
require_once(plugin_dir_path(__FILE__).'/includes/mailer.php');
require_once(plugin_dir_path(__FILE__).'/includes/icons.php');

new Eventr_Mailer();

add_action('widgets_init', function () {
    register_widget('Eventr_Widget');
});

?>
