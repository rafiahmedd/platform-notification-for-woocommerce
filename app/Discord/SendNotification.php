<?php
namespace PlatformNotificationApp\Discord;

class SendNotification
{
    public function sendNotification( $url, $message )
    {
        wp_remote_post( $url, array(
            'body' => [ 'content' => json_encode( $message ) ],
            'content-type' => 'application/json'
        ) );
    }
}