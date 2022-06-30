<?php
namespace PlatformNotificationApp\Discord;

class NotificationOnStatusChange
{

    private function getWebhookUrl()
    {
        return get_option('woocommerce_wc_discord_integration_settings')['discord_webhook_url'];
    }

    public function onStatusChanged ( $orderId, $oldStatus, $newStatus )
    {
        $order = new \WC_Order( $orderId );
        $items = $order->get_items();
        $message = MessageTemplate::statusChangeTemplate( $order, $items, $oldStatus, $newStatus );

        SendNotification::sendNotification( $this->getWebhookUrl(), $message );
        return true;
    }
}