<?php
namespace PlatformNotificationApp\Discord;

class NotificationOnOrder
{
    public function newOrder ( $orderId )
    {
        $settings = get_option('woocommerce_wc_discord_integration_settings')['notifications'];

        if ( in_array( 'new_order', $settings ) || in_array( 'all', $settings )  ) {
            $order = new \WC_Order( $orderId );
            $items = $order->get_items();
            $message = MessageTemplate::newOrderTemplate( $order, $items );
            DiscordApi::sendNotification( $message );
            return true;
        }
    }
}