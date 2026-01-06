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

if (!function_exists('delivery_timelines')) {
    function delivery_timelines($deliveryMethod = null)
    {
        if($deliveryMethod == 'manual') {
            return [
                'instant' => 'Instant Delivery',
                '1-hour' => '1 Hour',
                '12-hour' => '12 Hours',
                '24-hour' => '24 Hours',
                '1-day' => '1 Day'
            ];
        }else{
           return [
                'instant' => 'Instant Delivery',
            ]; 
        }
    }
}

