<?php
namespace PlatformNotificationApp\Discord;

class NotificationOnStatusChange
{
    public function onStatusChanged ( $orderId, $oldStatus, $newStatus )
    {
        $settings = get_option('woocommerce_wc_discord_integration_settings')['notifications'];

        if ( in_array( $newStatus, $settings ) || in_array( 'all', $settings )  ) {
            $order = new \WC_Order( $orderId );
            $items = $order->get_items();
            $message = MessageTemplate::statusChangeTemplate( $order, $items, $oldStatus, $newStatus );
            DiscordApi::sendNotification( $message );
            return true;
        }
    }
}