<?php

namespace PlatformNotificationApp\Slack;

class NotificationOnOrder
{
    public function newOrder ( $orderId )
    {
        $order = new \WC_Order( $orderId );
        $items = $order->get_items();
        $message = MessageTemplate::newOrderTemplate( $order, $items );

        SlackApi::sendNotification( $message );
        return true;
    }
}