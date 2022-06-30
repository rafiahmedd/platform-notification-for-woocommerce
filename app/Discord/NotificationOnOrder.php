<?php
namespace PlatformNotificationApp\Discord;

class NotificationOnOrder
{
    public function newOrder ( $orderId )
    {
        $order = new \WC_Order( $orderId );
        $items = $order->get_items();
        $message = MessageTemplate::newOrderTemplate( $order, $items );
        DiscordApi::sendNotification( $message );
        return true;
    }
}