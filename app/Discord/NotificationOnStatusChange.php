<?php
namespace PlatformNotificationApp\Discord;

class NotificationOnStatusChange
{

    private function getWebhookUrl()
    {
        return get_option('woocommerce_wc_discord_integration_settings')['discord_webhook_url'];
    }

    public function onOrderCompleted ( $orderId )
    {
        $order = new \WC_Order( $orderId );
        $items = $order->get_items();
//        $products = [];
//        foreach ($items as $item) {
//            $products[] = $item['name'];
//        }
        $message = "Order No.{$orderId} is now {$order->get_status()} see here{$order->get_view_order_url()}";
//        $message = 'New order has been placed by ' . $order->get_billing_first_name() . ' ' . $order->get_billing_last_name() . ' with the following products: ' . implode(', ', $products);
        return (new SendNotification())->sendNotification( $this->getWebhookUrl(), $message );
    }

    public function onOrderProcessing ( $orderId )
    {
        $order = new \WC_Order( $orderId );
        $items = $order->get_items();
//        $products = [];
//        foreach ($items as $item) {
//            $products[] = $item['name'];
//        }

        $message = "Order No.{$orderId} is now {$order->get_status()} see here{$order->get_view_order_url()}";
//        $message = 'New order has been placed by ' . $order->get_billing_first_name() . ' ' . $order->get_billing_last_name() . ' with the following products: ' . implode(', ', $products);
        return (new SendNotification())->sendNotification( $this->getWebhookUrl(), $message );
    }

    public function onOrderCanceled ( $orderId )
    {
        $order = new \WC_Order( $orderId );
        $items = $order->get_items();
        $products = [];
        foreach ($items as $item) {
            $products[] = $item['name'];
        }
        $message = "Order No.{$orderId} is now {$order->get_status()}";
//        $message = 'New order has been placed by ' . $order->get_billing_first_name() . ' ' . $order->get_billing_last_name() . ' with the following products: ' . implode(', ', $products);
        (new SendNotification())->sendNotification( $this->getWebhookUrl(), $message );
    }

    public function onOrderRefunded ( $orderId )
    {
        $order = new \WC_Order( $orderId );
        $items = $order->get_items();
        $products = [];
        foreach ($items as $item) {
            $products[] = $item['name'];
        }
        $message = "Order No.{$orderId} is now {$order->get_status()}";
//        $message = 'New order has been placed by ' . $order->get_billing_first_name() . ' ' . $order->get_billing_last_name() . ' with the following products: ' . implode(', ', $products);
        (new SendNotification())->sendNotification( $this->getWebhookUrl(), $message );
    }
}