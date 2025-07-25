<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\Order;
use App\Models\User;
use App\Notifications\NewOrderNotification;
use Illuminate\Notifications\AnonymousNotifiable;
use Illuminate\Notifications\Messages\BroadcastMessage;

class NewOrderNotificationTest extends TestCase
{
    public function test_constructor_loads_user_relation()
    {
        $user = User::factory()->create();
        $order = Order::factory()->create(['user_id' => $user->id]);

        $notification = new NewOrderNotification($order);
        $this->assertTrue($notification instanceof NewOrderNotification);
    }

    public function test_via_returns_database_and_broadcast()
    {
        $order = Order::factory()->for(User::factory())->create();
        $notification = new NewOrderNotification($order);

        $this->assertEquals(['database', 'broadcast'], $notification->via(new AnonymousNotifiable()));
    }

    public function test_to_database_contains_expected_keys()
    {
        $order = Order::factory()->for(User::factory())->create([
            'status' => 'en attente',
            'total_price' => 199.99,
        ]);

        $notification = new NewOrderNotification($order);
        $data = $notification->toDatabase(new AnonymousNotifiable());

        $this->assertArrayHasKey('message', $data);
        $this->assertArrayHasKey('order_id', $data);
        $this->assertArrayHasKey('user_name', $data);
        $this->assertArrayHasKey('total', $data);
        $this->assertArrayHasKey('status', $data);
    }

    public function test_to_broadcast_returns_broadcast_message_instance()
    {
        $order = Order::factory()->for(User::factory())->create([
            'status' => 'expédié',
            'total_price' => 250,
        ]);

        $notification = new NewOrderNotification($order);
        $message = $notification->toBroadcast(new AnonymousNotifiable());

        $this->assertInstanceOf(BroadcastMessage::class, $message);
    }
}
