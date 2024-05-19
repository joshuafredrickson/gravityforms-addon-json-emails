<?php
/**
 * Plugin Name: Gravity Forms JSON-Formatted Email Notifications Add-On
 * Plugin URI: https://github.com/joshuafredrickson/gravityforms-addon-json-emails
 * Description: Allows you to send email notifications with JSON-formatted form entry data.
 * Version: 1.0.0
 * Requires PHP: 8.1
 * Author: Joshua Fredrickson
 * Author URI: https://orangepineapple.com
 * License: GPLv2 or later
 * License URI: http://www.gnu.org/licenses/gpl-2.0.html
 */

define('GF_JSON_EMAILS_ADDON_VERSION', '1.0.0');

add_action('gform_loaded', ['Gf_Json_Emails_AddOn_Bootstrap', 'load'], 5);

class Gf_Json_Emails_AddOn_Bootstrap
{
    public static function load()
    {
        if (! method_exists('GFForms', 'include_feed_addon_framework')) {
            return;
        }

        require_once('class-gf-json-emails-addon.php');

        GFAddOn::register('GfJsonEmailsAddOn');
    }
}

function gf_simple_feed_addon()
{
    return GfJsonEmailsAddOn::get_instance();
}
