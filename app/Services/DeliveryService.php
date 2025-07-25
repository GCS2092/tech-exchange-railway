<?php

namespace App\Services;

use App\Models\DeliveryOption;

class DeliveryService
{
    public function getDeliveryCost($zone)
    {
        $option = DeliveryOption::where('zone', $zone)
            ->where('type', 'delivery')
            ->where('is_active', true)
            ->first();

        return $option ? $option->fixed_price : 0;
    }

    public function getAvailableOptions()
    {
        return DeliveryOption::where('is_active', true)->get();
    }

    public function getZones()
    {
        return [
            'zone1' => 'Centre-ville',
            'zone2' => 'Périphérie proche',
            'zone3' => 'Périphérie éloignée'
        ];
    }
} 