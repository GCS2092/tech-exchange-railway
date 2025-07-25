<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\User;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;

class OrderTest extends TestCase
{
    use RefreshDatabase;

    public function test_order_belongs_to_user()
    {
        $user = User::factory()->create();
        $order = Order::factory()->create(['user_id' => $user->id]);

        $this->assertInstanceOf(User::class, $order->user);
        $this->assertEquals($user->id, $order->user->id);
    }

    public function test_order_has_many_products()
    {
        $order = Order::factory()->create();
        $product = Product::factory()->create();

        $order->products()->attach($product->id, ['quantity' => 2]);

        $this->assertTrue($order->products->contains($product));
    }

    public function test_is_status_returns_true()
    {
        $order = Order::factory()->create(['status' => 'en attente']);

        $this->assertTrue($order->isStatus('en attente'));
        $this->assertFalse($order->isStatus('livré'));
    }

    public function test_scope_status_returns_expected_orders()
    {
        Order::factory()->create(['status' => 'expédié']);
        Order::factory()->create(['status' => 'livré']);

        $expedieOrders = Order::status('expédié')->get();

        $this->assertCount(1, $expedieOrders);
        $this->assertEquals('expédié', $expedieOrders->first()->status);
    }
}
