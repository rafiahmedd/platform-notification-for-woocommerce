<?php
namespace PlatformNotificationApp\Discord;

class DiscordApi
{
    private static function getWebhookUrl()
    {
        return get_option('woocommerce_wc_discord_integration_settings')['discord_webhook_url'];
    }

    public static function sendNotification( $message )
    {
        $response = wp_remote_post( static::getWebhookUrl(), array(
            'body' => ['payload_json' => json_encode( $message )],
            'content-type' => 'application/json',
        ) );

        if ( is_wp_error( $response ) ) {
            return new \WP_Error( $response->get_error_code(), $response->get_error_message() );
        }

        if ( ! $response ) {
            return new \WP_Error( 'Discord_Error', 'Discord API Request Failed' );
        }

        if ( ! empty( $response['error'] ) ) {
            return new \WP_Error( 'Discord_Error', $response['error'] );
        }

        return $response;
    }
}