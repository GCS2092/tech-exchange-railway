<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;
use App\Models\Category;
use App\Models\Brand;

class ElectronicDevicesSeeder extends Seeder
{
    public function run(): void
    {
        // Créer des marques
        $brands = [
            'Apple' => Brand::create(['name' => 'Apple']),
            'Samsung' => Brand::create(['name' => 'Samsung']),
            'Xiaomi' => Brand::create(['name' => 'Xiaomi']),
            'Dell' => Brand::create(['name' => 'Dell']),
        ];

        // Créer des catégories
        $categories = [
            'smartphone' => Category::create(['name' => 'Smartphones', 'description' => 'Téléphones intelligents']),
            'tablet' => Category::create(['name' => 'Tablettes', 'description' => 'Tablettes tactiles']),
            'laptop' => Category::create(['name' => 'Ordinateurs portables', 'description' => 'Laptops et notebooks']),
            'smartwatch' => Category::create(['name' => 'Montres connectées', 'description' => 'Smartwatches']),
        ];

        // Données d'exemple d'appareils
        $devices = [
            [
                'name' => 'iPhone 14 Pro',
                'brand' => 'Apple',
                'model' => 'iPhone 14 Pro',
                'device_type' => 'smartphone',
                'condition' => 'excellent',
                'storage_capacity' => '256 GB',
                'color' => 'Space Black',
                'price' => 899.99,
                'trade_value' => 750.00,
                'is_trade_eligible' => true,
                'description' => 'iPhone 14 Pro en excellent état, boîte d\'origine incluse.',
                'technical_specs' => [
                    'ecran' => '6.1 pouces Super Retina XDR',
                    'processeur' => 'A16 Bionic',
                    'ram' => '6 GB',
                    'camera' => 'Triple caméra 48MP + 12MP + 12MP',
                ],
                'has_original_box' => true,
                'has_original_accessories' => true,
                'warranty_status' => 'Garantie Apple jusqu\'en 2025'
            ],
            [
                'name' => 'Samsung Galaxy S23 Ultra',
                'brand' => 'Samsung',
                'model' => 'Galaxy S23 Ultra',
                'device_type' => 'smartphone',
                'condition' => 'very_good',
                'storage_capacity' => '512 GB',
                'color' => 'Phantom Black',
                'price' => 1199.99,
                'trade_value' => 950.00,
                'is_trade_eligible' => true,
                'description' => 'Samsung Galaxy S23 Ultra en très bon état, stylo S Pen inclus.',
                'technical_specs' => [
                    'ecran' => '6.8 pouces Dynamic AMOLED 2X',
                    'processeur' => 'Snapdragon 8 Gen 2',
                    'ram' => '12 GB',
                    'camera' => 'Quad caméra 200MP + 12MP + 10MP + 10MP',
                ],
                'has_original_box' => true,
                'has_original_accessories' => true,
                'warranty_status' => 'Garantie Samsung jusqu\'en 2025'
            ],
            [
                'name' => 'MacBook Pro 14" M2',
                'brand' => 'Apple',
                'model' => 'MacBook Pro 14" M2',
                'device_type' => 'laptop',
                'condition' => 'excellent',
                'storage_capacity' => '512 GB',
                'color' => 'Space Gray',
                'price' => 1999.99,
                'trade_value' => 1600.00,
                'is_trade_eligible' => true,
                'description' => 'MacBook Pro 14" avec puce M2, en excellent état.',
                'technical_specs' => [
                    'ecran' => '14 pouces Liquid Retina XDR',
                    'processeur' => 'Apple M2',
                    'ram' => '16 GB',
                    'stockage' => '512 GB SSD',
                ],
                'has_original_box' => true,
                'has_original_accessories' => true,
                'warranty_status' => 'Garantie Apple jusqu\'en 2025'
            ],
        ];

        // Créer les produits
        foreach ($devices as $device) {
            $brand = $brands[$device['brand']];
            $category = $categories[$device['device_type']];
            
            Product::create([
                'name' => $device['name'],
                'description' => $device['description'],
                'price' => $device['price'],
                'image' => 'default-device.jpg',
                'category_id' => $category->id,
                'brand_id' => $brand->id,
                'is_active' => true,
                'quantity' => 1,
                'is_featured' => rand(0, 1),
                'seller_id' => 1,
                'brand' => $device['brand'],
                'model' => $device['model'],
                'condition' => $device['condition'],
                'year_of_manufacture' => 2023,
                'technical_specs' => $device['technical_specs'],
                'is_trade_eligible' => $device['is_trade_eligible'],
                'trade_value' => $device['trade_value'],
                'device_type' => $device['device_type'],
                'storage_capacity' => $device['storage_capacity'],
                'color' => $device['color'],
                'has_original_box' => $device['has_original_box'],
                'has_original_accessories' => $device['has_original_accessories'],
                'warranty_status' => $device['warranty_status'],
            ]);
        }
    }
} 