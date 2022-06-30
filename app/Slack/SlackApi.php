<?php

namespace PlatformNotificationApp\Slack;

class SlackApi
{
    private static $apiUrl = 'https://slack.com/api/chat.postMessage';

    public static function sendNotification( $message )
    {
        $settings = get_option('woocommerce_wc_slack_integration_settings');

        $data = [
            'attachments' => json_encode( $message ),
            'channel'     => $settings['slack_channel_name'],
            'token'       => $settings['slack_bot_token']
        ];

        $response = wp_remote_post( self::$apiUrl, [
            'body'   => $data,
            'header' => [
                'content-type' => 'application/x-www-form-urlencoded'
            ]
        ] );


        if ( is_wp_error( $response ) ) {
            return new \WP_Error( $response->get_error_code(), $response->get_error_message() );
        }

        if (!$response) {
            return new \WP_Error( 'Slack_Error', 'Slack API Request Failed' );
        }

        if ( ! empty( $response['error'] ) ) {
            return new \WP_Error( 'Slack_Error', $response['error'] );
        }

        return $response;
    }
}