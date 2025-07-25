<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\Order;
use App\Models\User;
use App\Notifications\OrderPlacedNotification;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Support\Facades\Notification;

class OrderPlacedNotificationTest extends TestCase
{
    public function test_via_returns_expected_channels()
    {
        $order = Order::factory()->make();
        $notification = new OrderPlacedNotification($order);

        $notifiable = new User();
        $channels = $notification->via($notifiable);

        $this->assertEquals(['database', 'broadcast', 'mail'], $channels);
    }

    public function test_to_array_returns_expected_structure()
    {
        $order = Order::factory()->make(['id' => 123]);
        $notification = new OrderPlacedNotification($order);

        $array = $notification->toArray(new User());

        $this->assertArrayHasKey('message', $array);
        $this->assertArrayHasKey('order_id', $array);
        $this->assertEquals('Votre commande #123 a été passée avec succès.', $array['message']);
        $this->assertEquals(123, $array['order_id']);
    }

    public function test_to_mail_returns_mail_message()
    {
        $user = User::factory()->make(['name' => 'Jean Dupont']);
        $order = Order::factory()->make(['id' => 789]);
        $notification = new OrderPlacedNotification($order);

        $mail = $notification->toMail($user);

        $this->assertInstanceOf(MailMessage::class, $mail);
        $this->assertStringContainsString('Nouvelle commande confirmée', $mail->subject);
        $this->assertStringContainsString('Jean Dupont', $mail->greeting);
        $this->assertStringContainsString('#789', $mail->introLines[0]);
    }
}
