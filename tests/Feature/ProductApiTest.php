<?php

namespace Tests\Feature;

use App\Models\Product;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProductApiTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_get_all_products()
    {
        // Créer quelques produits de test
        Product::factory()->count(3)->create();

        // Faire une requête GET à l'API
        $response = $this->getJson('/api/products');

        // Vérifier la réponse
        $response->assertStatus(200)
            ->assertJsonStructure([
                'data' => [
                    '*' => [
                        'id',
                        'name',
                        'description',
                        'price',
                        'category',
                        'image',
                        'created_at',
                        'updated_at'
                    ]
                ]
            ]);
    }

    public function test_can_get_single_product()
    {
        // Créer un produit de test
        $product = Product::factory()->create();

        // Faire une requête GET à l'API
        $response = $this->getJson("/api/products/{$product->id}");

        // Vérifier la réponse
        $response->assertStatus(200)
            ->assertJson([
                'data' => [
                    'id' => $product->id,
                    'name' => $product->name,
                    'description' => $product->description,
                    'price' => $product->price,
                    'category' => $product->category,
                    'image' => $product->image,
                ]
            ]);
    }

    public function test_can_create_product()
    {
        // Créer un utilisateur admin
        $user = User::factory()->create(['role' => 'admin']);

        // Données du produit
        $productData = [
            'name' => 'Test Product',
            'description' => 'Test Description',
            'price' => 99.99,
            'category' => 'Test Category',
            'image' => 'test.jpg'
        ];

        // Faire une requête POST à l'API
        $response = $this->actingAs($user)
            ->postJson('/api/products', $productData);

        // Vérifier la réponse
        $response->assertStatus(201)
            ->assertJson([
                'data' => $productData
            ]);

        // Vérifier que le produit a été créé dans la base de données
        $this->assertDatabaseHas('products', $productData);
    }

    public function test_can_update_product()
    {
        // Créer un utilisateur admin
        $user = User::factory()->create(['role' => 'admin']);
        
        // Créer un produit de test
        $product = Product::factory()->create();

        // Données de mise à jour
        $updateData = [
            'name' => 'Updated Product',
            'price' => 149.99
        ];

        // Faire une requête PUT à l'API
        $response = $this->actingAs($user)
            ->putJson("/api/products/{$product->id}", $updateData);

        // Vérifier la réponse
        $response->assertStatus(200)
            ->assertJson([
                'data' => [
                    'id' => $product->id,
                    'name' => $updateData['name'],
                    'price' => $updateData['price']
                ]
            ]);

        // Vérifier que le produit a été mis à jour dans la base de données
        $this->assertDatabaseHas('products', $updateData);
    }

    public function test_can_delete_product()
    {
        // Créer un utilisateur admin
        $user = User::factory()->create(['role' => 'admin']);
        
        // Créer un produit de test
        $product = Product::factory()->create();

        // Faire une requête DELETE à l'API
        $response = $this->actingAs($user)
            ->deleteJson("/api/products/{$product->id}");

        // Vérifier la réponse
        $response->assertStatus(204);

        // Vérifier que le produit a été supprimé de la base de données
        $this->assertDatabaseMissing('products', ['id' => $product->id]);
    }
} 