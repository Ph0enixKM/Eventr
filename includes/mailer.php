<?php

class Eventr_Mailer {

    function __construct() {
        add_action('rest_api_init', function () {
            register_rest_route( 'eventr', 'mail', [
                'methods' => 'POST',
                'callback' => array($this, 'send')
            ]);
        });
    }

    public function send(WP_REST_Request $data) {
        // Properties
        $pTitle = $_POST["t-title"];
        $pName = $_POST["name"];
        $pEmail = $_POST["email"];
        $pPhone = $_POST["phone"];
        $pAge = $_POST["age"];
        // Translations
        $tName = $_POST["t-name"];
        $tEmail = $_POST["t-email"];
        $tPhone = $_POST["t-phone"];
        $tAge = $_POST["t-age"];
        $tMail = $_POST["t-mail"];
        $tSubmission = $_POST["t-submission"];
        $tTarget = $_POST["t-target"];
        // Check whether target 
        // has been adressed
        if ($tTarget != 'BAD') {
            $target = base64_decode($tTarget);
            $subject = "$tMail: $pTitle!";
            $message = "$subject\n".
                "$tName: $pName\n".
                "$tEmail: $pEmail\n".
                "$tPhone: $pPhone\n".
                "$tAge: $pAge";
            // Send mail to the target
            $done = wp_mail($target, $subject, $message);
            // Render result
            // TMP:
            return 'OK';

            if ($done) return 'OK';
            return 'Mailer is unable to send email';
        }
        return 'Target is missing';
    }
}

?>