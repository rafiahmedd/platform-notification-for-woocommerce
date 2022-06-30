<?php
namespace PlatformNotificationApp\Discord;

class MessageTemplate
{
    public static function statusChangeTemplate ( $order, $items, $oldStatus, $newStatus )
    {
        $products = [];

        foreach ($items as $item) {
            $products[] = [
                'name' => $item->get_name(),
                'value' => "Quantity: {$item->get_quantity()} Price: {$item->get_total()}",
                'inline' => true
            ];
        }

        $message = [
            'embeds' => [
                0 => [
                    'fields' => $products,
                    'title' => "Order #{$order->get_order_number()} is changed from {$oldStatus} to {$newStatus}",
                    'url' => esc_url_raw($order->get_view_order_url()),
                    'description' => "{$order->get_billing_first_name()}'s order is {$order->get_status()}.",
                    'color' => 9442302,
                ],
            ],
            'content' => "* Status updated of order no. #{$order->get_order_number()} *",
        ];

        return $message;
    }

    public static function newOrderTemplate ( $order, $items )
    {
        $products = [];

        foreach ($items as $item) {
            $products[] = [
                'name' => $item->get_name(),
                'value' => "Quantity: {$item->get_quantity()} Price: {$item->get_total()}",
                'inline' => true
            ];
        }

        $message = [
            'embeds' => [
                0 => [
                    'fields' => $products,
                    'title' => "New order #{$order->get_order_number()}",
                    'url' => esc_url_raw($order->get_view_order_url()),
                    'description' => "{$order->get_billing_first_name()} place a new order(#{$order->get_order_number()}).",
                    'color' => 9442302,
                ],
            ],
            'content' => "*{$order->get_billing_first_name()} place a new order(#{$order->get_order_number()}).*",
        ];

        return $message;
    }
}