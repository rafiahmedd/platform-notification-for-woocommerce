<?php

namespace PlatformNotificationApp\Slack;

class MessageTemplate
{
    public static function statusChangeTemplate ( $order, $items, $oldStatus, $newStatus )
    {
        $products = [];

        foreach ($items as $item) {
            $products[] = [
                'title' => $item->get_name(),
                'value' => "Quantity: {$item->get_quantity()} Price: {$item->get_total()}",
                'short' => true
            ];
        }

        $message = [
            0 => [
                'mrkdwn_in'  => ['text', 'pretext'],
                'fallback'   => "*Order #{$order->get_order_number()} is changed from {$oldStatus} to {$newStatus}*",
                'color'      => '#9944f7',
                'pretext'    => "*Order #{$order->get_order_number()} is changed from {$oldStatus} to {$newStatus}*",
                'title'      => "Order #{$order->get_order_number()} is changed from {$oldStatus} to {$newStatus}",
                'text'       => "{$order->get_billing_first_name()}'s order is {$order->get_status()}.",
                'fields'     => $products,
                'ts'         => time(),
            ],
        ];

        return $message;
    }
}