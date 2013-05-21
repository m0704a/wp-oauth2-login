<?php
'namespace org\muge\oauth2login';
/*
Plugin Name: OAuth2Login
Plugin URI: https://github.com/m0704a/wp-oauth2-login
Description: OAuth2Login
Version: 0.1
Author: m0704a
*/
include_once 'olo_actor.php';
if (!class_exists('M0704aOauth2LoginAdmin')) {


    class M0704aOauth2LoginAdmin
    {


        const CLASS_NAME = 'M0704aOauth2LoginAdmin';

        function __construct()
        {
            if (is_admin()) {

                /* Call the html code */
                add_action('admin_menu', array(&$this, 'oauth2_login_admin_menu'));

             }
        }

        public static function oauth2_login_admin_menu()
        {
            add_options_page('OAuth2 Login', 'OAuth2 Login', 'administrator',
                'oauth2-login', M0704aOauth2LoginAdmin::CLASS_NAME . '::oauth2_login_html_page');
        }


        public static function oauth2_login_html_page()
        {
            ?>
            <div>
                <h2>OAuth2 Login Options</h2>

                <form method="post" action="options.php">
                    <?php wp_nonce_field('update-options'); ?>

                    <table width="510">
                        <tr valign="top">
                            <th width="92" scope="row">Auth URI</th>
                            <td width="406">
                                <input name="oauth2_login_uri_auth" type="text" id="oauth2_login_uri_auth"
                                       value="<?php echo get_option('oauth2_login_uri_auth'); ?>"/>
                                OAuth2 auth URI
                            </td>
                        </tr>
                        <tr valign="top">
                            <th width="92" scope="row">Token URI</th>
                            <td width="406">
                                <input name="oauth2_login_uri_token" type="text" id="oauth2_login_uri_token"
                                       value="<?php echo get_option('oauth2_login_uri_token'); ?>"/><label
                                    for="oauth2_login_uri_token">OAuth2 token URI</label></td>
                        </tr>
                        <tr valign="top">
                            <th width="92" scope="row">Userdata URI</th>
                            <td width="406">
                                <input name="oauth2_login_uri_user_data" type="text" id="oauth2_login_uri_user_data"
                                       value="<?php echo get_option('oauth2_login_uri_user_data'); ?>"/>
                                URI to get the userdata in JSON format.
                            </td>
                        </tr>
                        <tr valign="top">
                            <th width="92" scope="row">Userdata Parse Info</th>
                            <td width="406">
                                <input name="oauth2_login_uri_user_parse_info" type="text"
                                       id="oauth2_login_uri_user_parse_info"
                                       value="<?php echo get_option('oauth2_login_uri_user_parse_info'); ?>"/>
                                How to parse userdata. Leave blank for default
                            </td>
                        </tr>
                    </table>

                    <input type="hidden" name="action" value="update"/>
                    <input type="hidden" name="page_options" value="oauth2_login_uri_auth"/>
                    <input type="hidden" name="page_options" value="oauth2_login_uri_token"/>
                    <input type="hidden" name="page_options" value="oauth2_login_uri_user_data"/>
                    <input type="hidden" name="page_options" value="oauth2_login_uri_user_parse_info"/>

                    <p>
                        <input type="submit" value="<?php _e('Save Changes') ?>"/>
                    </p>

                </form>
            </div>
        <?php
        }

        public static function activate()
        {
            /* Creates new database field */
            $json_str = '{"alma":"körte", "barack":"citrom"}';
            $json = M0704aOauth2LoginActor::oauth2_login_parse_json($json_str);
            $def = $json["alma"];
            add_option("oauth2_login_uri_auth", $def, '', 'yes');
            add_option("oauth2_login_uri_token", 'Default', '', 'yes');
            add_option("oauth2_login_uri_user_data", 'Default', '', 'yes');
            add_option("oauth2_login_uri_user_parse_info", '', '', 'yes');

        }

        public static function deactivate()
        {
            /* Deletes the database field */
            delete_option('oauth2_login_uri_auth');
            delete_option('oauth2_login_uri_token');
            delete_option('oauth2_login_uri_user_data');
            delete_option('oauth2_login_uri_user_parse_info');
        }
    }


}
/* Runs when plugin is activated */
register_activation_hook(__FILE__, M0704aOauth2LoginAdmin::CLASS_NAME . '::activate');

/* Runs on plugin deactivation*/
register_deactivation_hook(__FILE__, M0704aOauth2LoginAdmin::CLASS_NAME . '::deactivate');

$oauth_2_login = new M0704aOauth2LoginAdmin();

?>