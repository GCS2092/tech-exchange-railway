<?php

namespace App\Console\Commands;

use App\Models\DeliveryOption;
use App\Services\DeliveryService;
use Illuminate\Console\Command;

class TestDeliverySystem extends Command
{
    protected $signature = 'delivery:test';
    protected $description = 'Test the delivery system';

    public function handle()
    {
        $this->info('Testing Delivery System...');
        
        // Test 1: Vérifier les options de livraison
        $this->info("\n1. Vérification des options de livraison :");
        $options = DeliveryOption::all();
        foreach ($options as $option) {
            $this->line("- {$option->name} (Type: {$option->type}, Zone: {$option->zone}, Prix: {$option->fixed_price}€)");
        }

        // Test 2: Tester le service de livraison
        $this->info("\n2. Test du service de livraison :");
        $deliveryService = new DeliveryService();
        
        // Test pour chaque zone
        foreach (['zone1', 'zone2', 'zone3'] as $zone) {
            $cost = $deliveryService->getDeliveryCost($zone);
            $this->line("- Coût de livraison pour {$zone}: {$cost}€");
        }

        // Test 3: Vérifier les zones disponibles
        $this->info("\n3. Zones disponibles :");
        $zones = $deliveryService->getZones();
        foreach ($zones as $key => $value) {
            $this->line("- {$key}: {$value}");
        }

        $this->info("\nTest terminé !");
    }
} 