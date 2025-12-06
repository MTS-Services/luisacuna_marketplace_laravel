<?php

if (!function_exists('delivery_methods')) {
    function delivery_methods()
    {
        return [
            'pickup' => 'Pickup',
            'shipping' => 'Shipping',
            'game_delivery' => 'Game Delivery',
        ];
    }
}
