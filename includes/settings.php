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

    add_settings_field(
      'eventr_email_confirm',
      'Email Confirm',
      'eventr_render_email_confirm',
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

    add_settings_field(
      'eventr_back_lang',
      '"Back" label',
      'eventr_render_back_lang',
      'eventr',
      'eventr_language_section'
    );

    add_settings_field(
      'eventr_mail_lang',
      '"New person applied to" label',
      'eventr_render_mail_lang',
      'eventr',
      'eventr_language_section'
    );

    add_settings_field(
      'eventr_submission_lang',
      '"Submission sent" label',
      'eventr_render_submission_lang',
      'eventr',
      'eventr_language_section'
    );
    
    add_settings_field(
      'eventr_submission_confirm_lang',
      '"Submission sent confirmation title" label',
      'eventr_render_submission_confirm_lang',
      'eventr',
      'eventr_language_section'
    );

    add_settings_field(
      'eventr_submission_confirm_comment_lang',
      '"Submission sent confirmation comment / description" label',
      'eventr_render_submission_confirm_comment_lang',
      'eventr',
      'eventr_language_section'
    );

    register_setting( 'eventr', 'eventr_email_target' );
    register_setting( 'eventr', 'eventr_email_confirm' );
    register_setting( 'eventr', 'eventr_enroll_lang' );
    register_setting( 'eventr', 'eventr_back_lang' );
    register_setting( 'eventr', 'eventr_mail_lang' );
    register_setting( 'eventr', 'eventr_submission_lang' );
    register_setting( 'eventr', 'eventr_submission_confirm_lang' );
    register_setting( 'eventr', 'eventr_submission_confirm_comment_lang' );
}

function eventr_render_target_email() {
    echo 'Target Email: <input name="eventr_email_target" id="eventr_email_target" type="email" value="'.get_option( 'eventr_email_target' ).'" class="code" />';
}

function eventr_render_email_confirm() {
    echo 'Send email confirmation when enrolled: <input name="eventr_email_confirm" id="eventr_email_confirm" type="checkbox" value="1" '.checked(1, get_option('eventr_email_confirm'), false).'" />';
}

function eventr_render_translations_description() {
  echo 'In this section you can change the messages written in English to match your language on website.<br>';
}

function eventr_render_enroll_lang() {
    echo '"Enroll": <input name="eventr_enroll_lang" id="eventr_enroll_lang" type="text" value="'.get_option( 'eventr_enroll_lang' ).'" class="code" />';
}

function eventr_render_back_lang() {
    echo '"Back": <input name="eventr_back_lang" id="eventr_back_lang" type="text" value="'.get_option( 'eventr_back_lang' ).'" class="code" />';
}

function eventr_render_mail_lang() {
    echo '"New person applied to": <input name="eventr_mail_lang" id="eventr_mail_lang" type="text" value="'.get_option( 'eventr_mail_lang' ).'" class="code" />';
}

function eventr_render_submission_lang() {
    echo '"Submission sent": <input name="eventr_submission_lang" id="eventr_submission_lang" type="text" value="'.get_option( 'eventr_submission_lang' ).'" class="code" />';
}

function eventr_render_submission_confirm_lang() {
  echo '"Congratulations! You have successfully enrolled to": <input name="eventr_submission_confirm_lang" id="eventr_submission_confirm_lang" type="text" value="'.get_option( 'eventr_submission_confirm_lang' ).'" class="code" />';
}

function eventr_render_submission_confirm_comment_lang() {
  echo '(empty by default) "Thank you, we will respond soon": <input name="eventr_submission_confirm_comment_lang" id="eventr_submission_confirm_comment_lang" type="text" value="'.get_option( 'eventr_submission_confirm_comment_lang' ).'" class="code" />';
}

add_action('admin_init', 'eventr_general' );
add_action('admin_menu', 'eventr_settings')

?>