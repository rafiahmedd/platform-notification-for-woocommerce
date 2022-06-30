<?php
namespace PlatformNotificationApp\Discord;

class NotificationOnStatusChange
{
    public function onStatusChanged ( $orderId, $oldStatus, $newStatus )
    {
        $order = new \WC_Order( $orderId );
        $items = $order->get_items();
        $message = MessageTemplate::statusChangeTemplate( $order, $items, $oldStatus, $newStatus );

        DiscordApi::sendNotification( $message );
        return true;
    }
}