<?php
// Import scripts (CSS and JS)
function eventr_import_scripts() {
    wp_enqueue_style('main-style', plugins_url().'/eventr/assets/css/style.css');
    wp_enqueue_script('main-script', plugins_url().'/eventr/assets/js/main.js');
}

add_action('wp_enqueue_scripts', 'eventr_import_scripts');

?>