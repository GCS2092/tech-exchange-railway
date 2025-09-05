<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\User;
use App\Models\Order;
use App\Notifications\OrderStatusUpdatedNotification;
use Illuminate\Notifications\Messages\BroadcastMessage;
use Illuminate\Notifications\Messages\MailMessage;

class OrderStatusUpdatedNotificationTest extends TestCase
{
    public function test_via_returns_channels()
    {
        $order = new Order();
        $notification = new OrderStatusUpdatedNotification($order);

        $user = User::factory()->make();
        $channels = $notification->via($user);

        $this->assertEquals(['database', 'broadcast', 'mail'], $channels);
    }

    public function test_to_database_structure()
    {
        $user = User::factory()->make(['name' => 'Jean']);
        $order = Order::factory()->make([
            'id' => 1,
            'status' => 'livré',
            'user_id' => $user->id,
        ]);
        $order->setRelation('user', $user);

        $notification = new OrderStatusUpdatedNotification($order);
        $data = $notification->toDatabase($user);

        $this->assertArrayHasKey('message', $data);
        $this->assertArrayHasKey('order_id', $data);
        $this->assertArrayHasKey('status', $data);
        $this->assertArrayHasKey('user_name', $data);
    }

    public function test_to_broadcast_returns_broadcast_message()
    {
        $user = User::factory()->make(['name' => 'Sophie']);
        $order = Order::factory()->make([
            'id' => 2,
            'status' => 'expédié',
            'user_id' => $user->id,
        ]);
        $order->setRelation('user', $user);

        $notification = new OrderStatusUpdatedNotification($order);
        $message = $notification->toBroadcast($user);

        $this->assertInstanceOf(BroadcastMessage::class, $message);
    }

    public function test_to_mail_returns_mail_message()
    {
        $user = User::factory()->make(['name' => 'Marie']);
        $order = Order::factory()->make([
            'id' => 3,
            'status' => 'préparé',
            'user_id' => $user->id,
        ]);
        $order->setRelation('user', $user);

        $notification = new OrderStatusUpdatedNotification($order);
        $mail = $notification->toMail($user);

        $this->assertInstanceOf(MailMessage::class, $mail);
        $this->assertStringContainsString("Mise à jour de votre commande", $mail->subject);
        $this->assertStringContainsString((string) $order->id, $mail->introLines[0]);
    }
}
