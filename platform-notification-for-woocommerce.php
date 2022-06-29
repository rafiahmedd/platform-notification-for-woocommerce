<?php
/**
 * Plugin Name: Platform Notification For WooCommerce - Get notification on different platform on WooCommerce action
 * Plugin URI: https://wordpress.org/plugins/platform-notification-for-woocommerce/
 * Description: Get notified on slack when a new order is placed in your WooCommerce store.
 * Author: Rafi Ahmed
 * Author URI: https://devrafi.com/
 * Version: 1.0
 * text-domain: platform-notification-for-woocommerce
 * License: GPLv2 or later
 */

require_once __DIR__ . '/vendor/autoload.php';
class PlatformNotificationForWooCommerce {

	public function __construct() {

        if ( !defined('APP_TEXTDOMAIN') ) {
            define('APP_TEXTDOMAIN', 'platform-notification-for-woocommerce');
        }

		add_action( 'plugins_loaded', array( $this, 'init' ) );
	}

	public function init() {
        add_filter( 'woocommerce_integrations', array( $this, 'add_integration' ) );
	}

	/**
	 * Add new integrations to WooCommerce.
	 */
	public function add_integration( $integrations ) {
        $integrations =  [
            new \PlatformNotificationApp\Slack\SlackIntegration,
            new \PlatformNotificationApp\Discord\DiscordIntegration,
        ];

        return $integrations;
	}

}

new PlatformNotificationForWooCommerce( __FILE__ );

