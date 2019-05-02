<?php
class WPKlaviyoPopup {
    function __construct() {
        add_action('wp_footer', array(&$this, 'insert_popup'));
    }
    function insert_popup() {
        global $current_user;
        wp_reset_query();
        wp_get_current_user();
        $klaviyo_settings = get_option('klaviyo_settings');
        if ($klaviyo_settings['public_api_key'] == '' || $klaviyo_settings['klaviyo_popup'] == false) {
          return;
        }
                
        echo "\n" . '<!-- BEGIN KLAVIYO SIGNUP FORM CODE -->' . "\n";
        echo '<script type="text/javascript">' . "\n";
        echo 'var __klKey = __klKey || \'' . $klaviyo_settings['public_api_key'] . '\';' . "\n";
        echo '(function() {' . "\n";
        echo 'var s = document.createElement(\'script\');' . "\n";
        echo 's.type = \'text/javascript\';' . "\n";
        echo 's.async = true;' . "\n";
        echo 's.src = \'//static.klaviyo.com/forms/js/client.js\';' . "\n";
        echo 'var x = document.getElementsByTagName(\'script\')[0];' . "\n";
        echo 'x.parentNode.insertBefore(s, x);' . "\n";
        echo '})();' . "\n";
        echo '</script>' . "\n";
        echo '<!-- END KLAVIYO SIGNUP FORM CODE -->' . "\n";
    }
}
?>
