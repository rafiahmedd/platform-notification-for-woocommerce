<?php
namespace PlatformNotificationApp\Discord;

class SendNotification
{
    public static function sendNotification($url, $message)
    {
        wp_remote_post($url, array(
            'body' => ['payload_json' => json_encode( $message )],
            'content-type' => 'application/json',
        ));
    }
}