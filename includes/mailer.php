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
        $html = '';
        // Get the target
        $target = $_POST['_target'];
        if ($target == 'BAD') return 'Target is missing';
        $target = base64_decode($target);
        // Create subject
        $_mail = $_POST['_mail'];
        $_title = $_POST['_title'];
        $subject = "$_mail: $_title!";
        // Add body
        $html .= "<span style='font-size: 1.5em'>$subject</span>";
        $html .= "<ul>";
        foreach ($_POST as $key => $value) {
            if ($key[0] != '_') {
                $name = str_replace('_', ' ', $key);
                if (strlen(trim($value)) == 0) {
                    $html .= "<li> $name: <span style='color: gray'>(empty)</span></li>";
                }
                else {
                    $html .= "<li> $name: <span style='font-weight:600;font-size:1.2em'>$value</span></li>";
                }
            }
        }
        $html .= "</ul>";
        // Send result
        add_filter('wp_mail_content_type', function() {
            return 'text/html';
        });
        $done = wp_mail($target, $subject, $html);
        if ($done) return 'OK';
        return 'Mailer is unable to send email';
    }
}

?>
