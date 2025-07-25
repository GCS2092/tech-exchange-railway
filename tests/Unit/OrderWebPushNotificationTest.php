<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\User;
use App\Notifications\OrderWebPushNotification;
use Illuminate\Notifications\Messages\MailMessage;

class OrderWebPushNotificationTest extends TestCase
{
    public function test_via_returns_mail_channel()
    {
        $user = User::factory()->make();
        $notification = new OrderWebPushNotification();

        $channels = $notification->via($user);

        $this->assertEquals(['mail'], $channels);
    }

    public function test_to_mail_returns_mail_message()
    {
        $user = User::factory()->make();
        $notification = new OrderWebPushNotification();

        $mail = $notification->toMail($user);

        $this->assertInstanceOf(MailMessage::class, $mail);
        $this->assertStringContainsString('The introduction to the notification.', $mail->introLines[0]);
        $this->assertStringContainsString('Notification Action', $mail->actionText);
    }

    public function test_to_array_returns_array()
    {
        $user = User::factory()->make();
        $notification = new OrderWebPushNotification();

        $array = $notification->toArray($user);

        $this->assertIsArray($array);
    }
}
