<?php

function eventr_settings () {
    add_menu_page(
        'Eventr Settings',
        'Eventr',
        'manage_options',
        'eventr',
        'eventr_render',
        'dashicons-universal-access-alt',
        110
    );
}

function eventr_render() {
    ?>
    <h1>Eventr Settings</h1>
    <form method="POST" action="options.php">
        <?php settings_fields( 'eventr' );
        do_settings_sections( 'eventr' );
        submit_button();
        ?>
    </form>
    <?php
}

function eventr_general() {
    add_settings_section(
		'eventr_setting_section',
		'Settings section',
		null,
		'eventr'
    );
    
    add_settings_field(
		'eventr_email_target',
		'Email Target',
		'eventr_render_target_email',
		'eventr',
		'eventr_setting_section'
    );

    // LANGUAGE SETTINGS

    add_settings_section(
		'eventr_language_section',
		'Translations section',
		'eventr_render_translations_description',
		'eventr'
    );

    add_settings_field(
		'eventr_enroll_lang',
		'"Enroll" label',
		'eventr_render_enroll_lang',
		'eventr',
		'eventr_language_section'
    );
    
    register_setting( 'eventr', 'eventr_email_target' );
    register_setting( 'eventr', 'eventr_enroll_lang' );
}

function eventr_render_target_email() {
    echo 'Target Email: <input name="eventr_email_target" id="eventr_email_target" type="email" value="'.get_option( 'eventr_email_target' ).'" class="code" />';
}

function eventr_render_translations_description() {
    echo 'In this section you can change the messages written in English to match your language on website.<br>';
}

function eventr_render_enroll_lang() {
    echo '"Enroll": <input name="eventr_enroll_lang" id="eventr_enroll_lang" type="text" value="'.get_option( 'eventr_enroll_lang' ).'" class="code" />';
}


add_action('admin_init', 'eventr_general' );
add_action('admin_menu', 'eventr_settings')

?>