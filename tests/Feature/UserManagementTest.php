<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Support\Facades\Notification;
use App\Notifications\NewUserCreatedNotification;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UserManagementTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function admin_receives_notification_when_user_is_created()
    {
        Notification::fake();

        // Créer un admin connecté
        $admin = User::factory()->create(['role' => 'admin']);
        $this->actingAs($admin);

        // Données valides d'utilisateur
        $newUserData = [
            'name' => 'Nouveau Test',
            'email' => 'nouveau@test.com',
            'password' => 'password',
            'password_confirmation' => 'password',
            'role' => 'user',
        ];

        // Effectuer la requête POST
        $response = $this->post(route('admin.storeUser'), $newUserData);

        $response->assertRedirect(); // Vérifie qu’on est bien redirigé

        // 🧨 Vérifie que la notification a été envoyée
        Notification::assertSentTo(
            [$admin],
            NewUserCreatedNotification::class,
            function ($notification, $channels) use ($newUserData) {
                return $notification->user->email === $newUserData['email'];
            }
        );
    }
}
