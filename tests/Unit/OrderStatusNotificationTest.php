<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\User;
use App\Notifications\OrderStatusNotification;
use Illuminate\Notifications\Messages\MailMessage;

class OrderStatusNotificationTest extends TestCase
{
    public function test_via_returns_mail_channel()
    {
        $notification = new OrderStatusNotification();
        $user = User::factory()->make();

        $channels = $notification->via($user);

        $this->assertEquals(['mail'], $channels);
    }

    public function test_to_mail_returns_mail_message()
    {
        $notification = new OrderStatusNotification();
        $user = User::factory()->make(['name' => 'Alice']);

        $mail = $notification->toMail($user);

        $this->assertInstanceOf(MailMessage::class, $mail);
        $this->assertStringContainsString('The introduction to the notification', $mail->introLines[0]);
        $this->assertStringContainsString('Notification Action', $mail->actionText);
    }

    public function test_to_array_returns_array()
    {
        $notification = new OrderStatusNotification();
        $user = User::factory()->make();

        $data = $notification->toArray($user);

        $this->assertIsArray($data);
    }
}
