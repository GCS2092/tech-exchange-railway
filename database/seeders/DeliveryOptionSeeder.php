<?php

namespace Database\Seeders;

use App\Models\DeliveryOption;
use Illuminate\Database\Seeder;

class DeliveryOptionSeeder extends Seeder
{
    public function run()
    {
        // Option de retrait en magasin
        DeliveryOption::create([
            'name' => 'Retrait en magasin',
            'type' => 'pickup',
            'zone' => null,
            'fixed_price' => 0,
            'is_active' => true
        ]);

        // Options de livraison par zone
        DeliveryOption::create([
            'name' => 'Livraison Zone 1',
            'type' => 'delivery',
            'zone' => 'zone1',
            'fixed_price' => 5.00,
            'is_active' => true
        ]);

        DeliveryOption::create([
            'name' => 'Livraison Zone 2',
            'type' => 'delivery',
            'zone' => 'zone2',
            'fixed_price' => 8.00,
            'is_active' => true
        ]);

        DeliveryOption::create([
            'name' => 'Livraison Zone 3',
            'type' => 'delivery',
            'zone' => 'zone3',
            'fixed_price' => 12.00,
            'is_active' => true
        ]);
    }
} 