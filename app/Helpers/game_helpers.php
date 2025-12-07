<?php

if (!function_exists('delivery_methods')) {
    function delivery_methods()
    {
        return [
            'manual' => 'Manual Delivery',
            'instant' => 'Instant Delivery',
        ];
    }
}
