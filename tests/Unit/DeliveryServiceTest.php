<?php

namespace Tests\Unit;

use App\Models\DeliveryOption;
use App\Services\DeliveryService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DeliveryServiceTest extends TestCase
{
    use RefreshDatabase;

    protected $deliveryService;

    public function setUp(): void
    {
        parent::setUp();
        $this->deliveryService = new DeliveryService();
    }

    public function test_get_delivery_cost_for_zone1()
    {
        // Créer une option de livraison pour zone1
        DeliveryOption::create([
            'name' => 'Livraison Zone 1',
            'type' => 'delivery',
            'zone' => 'zone1',
            'fixed_price' => 5.00,
            'is_active' => true
        ]);

        $cost = $this->deliveryService->getDeliveryCost('zone1');
        $this->assertEquals(5.00, $cost);
    }

    public function test_get_delivery_cost_for_invalid_zone()
    {
        $cost = $this->deliveryService->getDeliveryCost('invalid_zone');
        $this->assertEquals(0, $cost);
    }

    public function test_get_available_options()
    {
        // Créer quelques options de livraison
        DeliveryOption::create([
            'name' => 'Livraison Zone 1',
            'type' => 'delivery',
            'zone' => 'zone1',
            'fixed_price' => 5.00,
            'is_active' => true
        ]);

        DeliveryOption::create([
            'name' => 'Retrait en magasin',
            'type' => 'pickup',
            'zone' => null,
            'fixed_price' => 0,
            'is_active' => true
        ]);

        $options = $this->deliveryService->getAvailableOptions();
        $this->assertCount(2, $options);
    }

    public function test_get_zones()
    {
        $zones = $this->deliveryService->getZones();
        $this->assertArrayHasKey('zone1', $zones);
        $this->assertArrayHasKey('zone2', $zones);
        $this->assertArrayHasKey('zone3', $zones);
    }
} 