<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ApiTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test de la route /api/test
     */
    public function test_api_test_route()
    {
        $response = $this->getJson('/api/test');
        
        $response->assertStatus(200)
                ->assertJsonStructure([
                    'status',
                    'message',
                    'timestamp'
                ]);
    }

    /**
     * Test de la route /api/ping
     */
    public function test_api_ping_route()
    {
        $response = $this->getJson('/api/ping');
        
        $response->assertStatus(200)
                ->assertJson([
                    'pong' => true
                ]);
    }

    /**
     * Test de la route /api/products
     */
    public function test_api_products_route()
    {
        $response = $this->getJson('/api/products');
        
        $response->assertStatus(200)
                ->assertJsonStructure([
                    '*' => [
                        'id',
                        'name',
                        'description',
                        'price',
                        'image',
                        'created_at',
                        'updated_at'
                    ]
                ]);
    }

    /**
     * Test de la route /api/categories
     */
    public function test_api_categories_route()
    {
        $response = $this->getJson('/api/categories');
        
        $response->assertStatus(200)
                ->assertJsonStructure([
                    '*' => [
                        'id',
                        'name',
                        'description',
                        'created_at',
                        'updated_at'
                    ]
                ]);
    }

    /**
     * Test de l'inscription
     */
    public function test_api_register()
    {
        $response = $this->postJson('/api/register', [
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => 'password123',
            'password_confirmation' => 'password123'
        ]);

        $response->assertStatus(201)
                ->assertJsonStructure([
                    'user' => [
                        'id',
                        'name',
                        'email',
                        'created_at',
                        'updated_at'
                    ],
                    'token'
                ]);
    }

    /**
     * Test de la connexion
     */
    public function test_api_login()
    {
        // Créer un utilisateur de test
        $user = User::factory()->create([
            'email' => 'test@example.com',
            'password' => bcrypt('password123')
        ]);

        $response = $this->postJson('/api/login', [
            'email' => 'test@example.com',
            'password' => 'password123'
        ]);

        $response->assertStatus(200)
                ->assertJsonStructure([
                    'user' => [
                        'id',
                        'name',
                        'email',
                        'created_at',
                        'updated_at'
                    ],
                    'token'
                ]);
    }

    /**
     * Test de la route protégée /api/user
     */
    public function test_api_user_route()
    {
        // Créer un utilisateur de test
        $user = User::factory()->create();
        
        // Générer un token pour l'utilisateur
        $token = $user->createToken('test-token')->plainTextToken;

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $token
        ])->getJson('/api/user');

        $response->assertStatus(200)
                ->assertJsonStructure([
                    'id',
                    'name',
                    'email',
                    'created_at',
                    'updated_at'
                ]);
    }
} 