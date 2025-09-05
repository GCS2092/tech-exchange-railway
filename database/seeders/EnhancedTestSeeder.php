<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Product;
use App\Models\Category;
use App\Models\Brand;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\TradeOffer;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class EnhancedTestSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Créer les rôles d'abord
        $this->call(RoleSeeder::class);

        // 2. Créer un utilisateur par rôle
        $this->createUsersPerRole();

        // 3. Créer des marques et catégories
        $this->createBrandsAndCategories();

        // 4. Créer beaucoup de produits électroniques pour les échanges
        $this->createElectronicProducts();

        // 5. Créer des commandes de test (désactivé temporairement)
        // $this->createTestOrders();

        // 6. Créer des offres d'échange de test (désactivé temporairement)
        // $this->createTestTradeOffers();
    }

    private function createUsersPerRole()
    {
        // Admin - Utiliser l'existant ou créer
        $admin = User::firstOrCreate(
            ['email' => 'slovengama@gmail.com'],
            [
                'name' => 'Coeurson Admin',
                'username' => 'admin',
                'password' => Hash::make('qwertyuiop'),
                'email_verified_at' => now(),
            ]
        );
        if (!$admin->hasRole('admin')) {
            $admin->assignRole('admin');
        }

        // Vendeur
        $vendeur = User::firstOrCreate(
            ['email' => 'vendeur@techhub.com'],
            [
                'name' => 'Marc Vendeur',
                'username' => 'vendeur',
                'password' => Hash::make('password123'),
                'email_verified_at' => now(),
            ]
        );
        if (!$vendeur->hasRole('vendeur')) {
            $vendeur->assignRole('vendeur');
        }

        // Livreur
        $livreur = User::firstOrCreate(
            ['email' => 'livreur@techhub.com'],
            [
                'name' => 'Paul Livreur',
                'username' => 'livreur',
                'password' => Hash::make('password123'),
                'email_verified_at' => now(),
            ]
        );
        if (!$livreur->hasRole('livreur')) {
            $livreur->assignRole('livreur');
        }

        // Client
        $client = User::firstOrCreate(
            ['email' => 'client@techhub.com'],
            [
                'name' => 'Sophie Client',
                'username' => 'client',
                'password' => Hash::make('password123'),
                'email_verified_at' => now(),
            ]
        );
        if (!$client->hasRole('client')) {
            $client->assignRole('client');
        }

        echo "✅ Utilisateurs créés/mis à jour par rôle (admin, vendeur, livreur, client)\n";
    }

    private function createBrandsAndCategories()
    {
        // Marques technologiques
        $brands = [
            'Apple', 'Samsung', 'Xiaomi', 'OnePlus', 'Google', 'Huawei',
            'Dell', 'HP', 'Lenovo', 'Asus', 'MSI', 'Acer',
            'Sony', 'Nintendo', 'Microsoft', 'Logitech', 'Razer',
            'Canon', 'Nikon', 'GoPro', 'DJI', 'Bose', 'JBL',
            'Beats', 'Sennheiser', 'Audio-Technica'
        ];

        foreach ($brands as $brandName) {
            Brand::firstOrCreate(['name' => $brandName]);
        }

        // Catégories d'appareils électroniques
        $categories = [
            ['name' => 'Smartphones', 'description' => 'Téléphones intelligents et accessoires'],
            ['name' => 'Tablettes', 'description' => 'Tablettes tactiles et e-readers'],
            ['name' => 'Ordinateurs portables', 'description' => 'Laptops, notebooks et ultrabooks'],
            ['name' => 'Gaming', 'description' => 'Consoles, PC gaming et accessoires'],
            ['name' => 'Audio', 'description' => 'Casques, écouteurs et enceintes'],
            ['name' => 'Photo/Vidéo', 'description' => 'Appareils photo et caméras'],
            ['name' => 'Montres connectées', 'description' => 'Smartwatches et trackers fitness'],
            ['name' => 'Accessoires', 'description' => 'Coques, chargeurs et supports'],
        ];

        foreach ($categories as $category) {
            Category::firstOrCreate(['name' => $category['name']], $category);
        }

        echo "✅ Marques et catégories créées\n";
    }

    private function createElectronicProducts()
    {
        $vendeurId = User::where('email', 'vendeur@techhub.com')->first()->id;
        $adminId = User::where('email', 'slovengama@gmail.com')->first()->id;

        $products = [
            // SMARTPHONES
            [
                'name' => 'iPhone 15 Pro Max',
                'brand' => 'Apple',
                'model' => 'iPhone 15 Pro Max',
                'device_type' => 'smartphone',
                'condition' => 'excellent',
                'storage' => '256GB',
                'ram' => '8GB',
                'screen_size' => '6.7"',
                'os' => 'iOS 17',
                'color' => 'Titane Naturel',
                'year' => 2023,
                'price' => 1299000,
                'trade_value' => 1100000,
                'category' => 'Smartphones',
                'description' => 'iPhone 15 Pro Max en titane, état excellent, boîte complète avec tous les accessoires.'
            ],
            [
                'name' => 'Samsung Galaxy S24 Ultra',
                'brand' => 'Samsung',
                'model' => 'Galaxy S24 Ultra',
                'device_type' => 'smartphone',
                'condition' => 'excellent',
                'storage' => '512GB',
                'ram' => '12GB',
                'screen_size' => '6.8"',
                'os' => 'Android 14',
                'color' => 'Phantom Black',
                'year' => 2024,
                'price' => 1199000,
                'trade_value' => 1000000,
                'category' => 'Smartphones',
                'description' => 'Galaxy S24 Ultra avec S Pen, écran Dynamic AMOLED 2X, appareil photo 200MP.'
            ],
            [
                'name' => 'Google Pixel 8 Pro',
                'brand' => 'Google',
                'model' => 'Pixel 8 Pro',
                'device_type' => 'smartphone',
                'condition' => 'très bon',
                'storage' => '256GB',
                'ram' => '12GB',
                'screen_size' => '6.7"',
                'os' => 'Android 14',
                'color' => 'Bay Blue',
                'year' => 2023,
                'price' => 899000,
                'trade_value' => 750000,
                'category' => 'Smartphones',
                'description' => 'Pixel 8 Pro avec IA avancée, appareil photo exceptionnel et Android pur.'
            ],
            [
                'name' => 'OnePlus 12',
                'brand' => 'OnePlus',
                'model' => 'OnePlus 12',
                'device_type' => 'smartphone',
                'condition' => 'excellent',
                'storage' => '256GB',
                'ram' => '16GB',
                'screen_size' => '6.82"',
                'os' => 'OxygenOS 14',
                'color' => 'Silky Black',
                'year' => 2024,
                'price' => 799000,
                'trade_value' => 650000,
                'category' => 'Smartphones',
                'description' => 'OnePlus 12 avec Snapdragon 8 Gen 3, charge rapide 100W.'
            ],

            // LAPTOPS
            [
                'name' => 'MacBook Pro 16" M3 Max',
                'brand' => 'Apple',
                'model' => 'MacBook Pro 16"',
                'device_type' => 'laptop',
                'condition' => 'excellent',
                'storage' => '1TB',
                'ram' => '36GB',
                'screen_size' => '16.2"',
                'processor' => 'Apple M3 Max',
                'gpu' => 'Intégrée M3 Max',
                'os' => 'macOS Sonoma',
                'color' => 'Space Black',
                'year' => 2023,
                'price' => 3999000,
                'trade_value' => 3400000,
                'category' => 'Ordinateurs portables',
                'description' => 'MacBook Pro 16" avec puce M3 Max, écran Liquid Retina XDR.'
            ],
            [
                'name' => 'Dell XPS 15 OLED',
                'brand' => 'Dell',
                'model' => 'XPS 15 9530',
                'device_type' => 'laptop',
                'condition' => 'très bon',
                'storage' => '512GB',
                'ram' => '32GB',
                'screen_size' => '15.6"',
                'processor' => 'Intel Core i9-13900H',
                'gpu' => 'NVIDIA RTX 4070',
                'os' => 'Windows 11',
                'color' => 'Platinum Silver',
                'year' => 2023,
                'price' => 2499000,
                'trade_value' => 2000000,
                'category' => 'Ordinateurs portables',
                'description' => 'Dell XPS 15 avec écran OLED 4K, processeur Intel i9 et RTX 4070.'
            ],
            [
                'name' => 'ASUS ROG Zephyrus G16',
                'brand' => 'Asus',
                'model' => 'ROG Zephyrus G16',
                'device_type' => 'laptop',
                'condition' => 'excellent',
                'storage' => '1TB',
                'ram' => '32GB',
                'screen_size' => '16"',
                'processor' => 'AMD Ryzen 9 7940HS',
                'gpu' => 'NVIDIA RTX 4080',
                'os' => 'Windows 11',
                'color' => 'Eclipse Gray',
                'year' => 2023,
                'price' => 2799000,
                'trade_value' => 2300000,
                'category' => 'Gaming',
                'description' => 'Laptop gaming premium avec RTX 4080 et écran 240Hz.'
            ],

            // TABLETTES
            [
                'name' => 'iPad Pro 12.9" M2',
                'brand' => 'Apple',
                'model' => 'iPad Pro 12.9"',
                'device_type' => 'tablet',
                'condition' => 'excellent',
                'storage' => '256GB',
                'screen_size' => '12.9"',
                'os' => 'iPadOS 17',
                'color' => 'Space Gray',
                'year' => 2022,
                'price' => 1199000,
                'trade_value' => 950000,
                'category' => 'Tablettes',
                'description' => 'iPad Pro avec puce M2, écran Liquid Retina XDR, Apple Pencil compatible.'
            ],
            [
                'name' => 'Samsung Galaxy Tab S9 Ultra',
                'brand' => 'Samsung',
                'model' => 'Galaxy Tab S9 Ultra',
                'device_type' => 'tablet',
                'condition' => 'très bon',
                'storage' => '512GB',
                'screen_size' => '14.6"',
                'os' => 'Android 13',
                'color' => 'Graphite',
                'year' => 2023,
                'price' => 1099000,
                'trade_value' => 850000,
                'category' => 'Tablettes',
                'description' => 'Tablette premium avec écran AMOLED 14.6", S Pen inclus.'
            ],

            // GAMING
            [
                'name' => 'PlayStation 5',
                'brand' => 'Sony',
                'model' => 'PS5',
                'device_type' => 'console',
                'condition' => 'excellent',
                'storage' => '825GB',
                'color' => 'Blanc',
                'year' => 2020,
                'price' => 499000,
                'trade_value' => 400000,
                'category' => 'Gaming',
                'description' => 'PlayStation 5 avec manette DualSense, SSD ultra-rapide.'
            ],
            [
                'name' => 'Xbox Series X',
                'brand' => 'Microsoft',
                'model' => 'Xbox Series X',
                'device_type' => 'console',
                'condition' => 'très bon',
                'storage' => '1TB',
                'color' => 'Noir',
                'year' => 2020,
                'price' => 499000,
                'trade_value' => 380000,
                'category' => 'Gaming',
                'description' => 'Xbox Series X avec 4K native, 120fps, Xbox Game Pass.'
            ],
            [
                'name' => 'Nintendo Switch OLED',
                'brand' => 'Nintendo',
                'model' => 'Switch OLED',
                'device_type' => 'console',
                'condition' => 'excellent',
                'storage' => '64GB',
                'screen_size' => '7"',
                'color' => 'Blanc',
                'year' => 2021,
                'price' => 349000,
                'trade_value' => 280000,
                'category' => 'Gaming',
                'description' => 'Nintendo Switch avec écran OLED 7", dock et Joy-Con inclus.'
            ],

            // AUDIO
            [
                'name' => 'AirPods Pro 2',
                'brand' => 'Apple',
                'model' => 'AirPods Pro 2ème génération',
                'device_type' => 'écouteurs',
                'condition' => 'excellent',
                'color' => 'Blanc',
                'year' => 2022,
                'price' => 279000,
                'trade_value' => 220000,
                'category' => 'Audio',
                'description' => 'AirPods Pro avec réduction de bruit active, boîtier MagSafe.'
            ],
            [
                'name' => 'Sony WH-1000XM5',
                'brand' => 'Sony',
                'model' => 'WH-1000XM5',
                'device_type' => 'casque',
                'condition' => 'excellent',
                'color' => 'Noir',
                'year' => 2022,
                'price' => 399000,
                'trade_value' => 300000,
                'category' => 'Audio',
                'description' => 'Casque sans fil premium avec réduction de bruit de pointe.'
            ],
            [
                'name' => 'Bose QuietComfort Ultra',
                'brand' => 'Bose',
                'model' => 'QuietComfort Ultra',
                'device_type' => 'casque',
                'condition' => 'très bon',
                'color' => 'Blanc Fumé',
                'year' => 2023,
                'price' => 429000,
                'trade_value' => 340000,
                'category' => 'Audio',
                'description' => 'Casque avec spatial audio et réduction de bruit immersive.'
            ],

            // MONTRES CONNECTÉES
            [
                'name' => 'Apple Watch Ultra 2',
                'brand' => 'Apple',
                'model' => 'Watch Ultra 2',
                'device_type' => 'smartwatch',
                'condition' => 'excellent',
                'screen_size' => '49mm',
                'color' => 'Titane Naturel',
                'year' => 2023,
                'price' => 899000,
                'trade_value' => 720000,
                'category' => 'Montres connectées',
                'description' => 'Apple Watch Ultra 2 avec boîtier titane, GPS double fréquence.'
            ],
            [
                'name' => 'Samsung Galaxy Watch6 Classic',
                'brand' => 'Samsung',
                'model' => 'Galaxy Watch6 Classic',
                'device_type' => 'smartwatch',
                'condition' => 'excellent',
                'screen_size' => '47mm',
                'color' => 'Noir',
                'year' => 2023,
                'price' => 429000,
                'trade_value' => 320000,
                'category' => 'Montres connectées',
                'description' => 'Smartwatch avec lunette rotative, suivi santé avancé.'
            ],

            // PHOTO/VIDÉO
            [
                'name' => 'Canon EOS R6 Mark II',
                'brand' => 'Canon',
                'model' => 'EOS R6 Mark II',
                'device_type' => 'appareil photo',
                'condition' => 'excellent',
                'color' => 'Noir',
                'year' => 2022,
                'price' => 2499000,
                'trade_value' => 2000000,
                'category' => 'Photo/Vidéo',
                'description' => 'Appareil photo mirrorless avec capteur 24MP, vidéo 4K 60fps.'
            ],
            [
                'name' => 'DJI Mini 4 Pro',
                'brand' => 'DJI',
                'model' => 'Mini 4 Pro',
                'device_type' => 'drone',
                'condition' => 'excellent',
                'color' => 'Gris',
                'year' => 2023,
                'price' => 759000,
                'trade_value' => 600000,
                'category' => 'Photo/Vidéo',
                'description' => 'Drone compact avec caméra 4K HDR, évitement d\'obstacles omnidirectionnel.'
            ],
        ];

        foreach ($products as $index => $productData) {
            $category = Category::where('name', $productData['category'])->first();
            $brand = Brand::where('name', $productData['brand'])->first();
            
            // Alterner les vendeurs entre admin et vendeur
            $sellerId = $index % 2 === 0 ? $adminId : $vendeurId;

            Product::create([
                'name' => $productData['name'],
                'description' => $productData['description'],
                'price' => $productData['price'],
                'image' => 'default-device.jpg',
                'category_id' => $category ? $category->id : null,
                'is_active' => true,
                'quantity' => rand(1, 5),
                'is_featured' => rand(0, 1),
                'seller_id' => $sellerId,
                'brand' => $productData['brand'],
                'model' => $productData['model'],
                'condition' => $productData['condition'],
                'year_of_manufacture' => $productData['year'],
                'is_trade_eligible' => true,
                'trade_value' => $productData['trade_value'],
                'device_type' => $productData['device_type'],
                'storage_capacity' => $productData['storage'] ?? null,
                'color' => $productData['color'],
                'has_original_box' => true,
                'has_original_accessories' => true,
                'warranty_status' => 'Garantie constructeur',
                // Champs spécifiques selon le type (stockés dans technical_specs)
                'technical_specs' => [
                    'ram' => $productData['ram'] ?? null,
                    'screen_size' => $productData['screen_size'] ?? null,
                    'os' => $productData['os'] ?? null,
                    'processor' => $productData['processor'] ?? null,
                    'gpu' => $productData['gpu'] ?? null,
                ],
            ]);
        }

        echo "✅ " . count($products) . " produits électroniques créés pour le système d'échange\n";
    }

    private function createTestOrders()
    {
        $client = User::where('email', 'client@techhub.com')->first();
        if (!$client) {
            echo "❌ Client introuvable pour créer les commandes\n";
            return;
        }
        
        $products = Product::limit(3)->get();

        foreach ($products as $product) {
            // Créer une commande simple avec seulement les colonnes de base
            $order = Order::create([
                'user_id' => $client->id,
                'status' => ['pending', 'confirmed', 'shipped', 'delivered'][rand(0, 3)],
            ]);

            // Créer l'item de commande
            OrderItem::create([
                'order_id' => $order->id,
                'product_id' => $product->id,
                'quantity' => 1,
                'price' => $product->price,
            ]);
        }

        echo "✅ Commandes de test créées\n";
    }

    private function createTestTradeOffers()
    {
        $client = User::where('email', 'client@techhub.com')->first();
        $vendeur = User::where('email', 'vendeur@techhub.com')->first();
        $products = Product::where('is_trade_eligible', true)->limit(3)->get();

        foreach ($products as $product) {
            TradeOffer::create([
                'product_id' => $product->id,
                'user_id' => $client->id,
                'offer_type' => 'custom_device',
                'message' => 'Je propose mon iPhone 13 en excellent état contre cet appareil.',
                'status' => ['pending', 'accepted', 'rejected'][rand(0, 2)],
                'custom_device_name' => 'iPhone 13',
                'custom_device_brand' => 'Apple',
                'custom_device_model' => 'iPhone 13',
                'custom_device_type' => 'smartphone',
                'custom_device_condition' => 'excellent',
                'custom_device_description' => 'iPhone 13 128GB en excellent état, boîte et accessoires inclus.',
                'custom_device_year' => 2021,
                'custom_device_ram' => '6GB',
                'custom_device_storage' => '128GB',
                'custom_device_screen_size' => '6.1"',
                'custom_device_os' => 'iOS 17',
                'custom_device_color' => 'Bleu',
            ]);
        }

        echo "✅ Offres d'échange de test créées\n";
    }
}
