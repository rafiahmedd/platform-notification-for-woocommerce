<?php
namespace PlatformNotificationApp\Discord;

class DiscordApi
{
    public static function sendNotification($url, $message)
    {
        $response = wp_remote_post( $url, array(
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