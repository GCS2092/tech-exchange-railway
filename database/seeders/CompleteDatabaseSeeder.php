<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;
use App\Models\User;
use App\Models\Product;
use App\Models\Category;
use App\Models\Brand;
use App\Models\Role;
use App\Models\Permission;
use Spatie\Permission\Models\Role as SpatieRole;
use Spatie\Permission\Models\Permission as SpatiePermission;

class CompleteDatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Vider toutes les tables
        $this->truncateTables();

        // Créer les rôles et permissions
        $this->createRolesAndPermissions();

        // Créer les utilisateurs avec leurs rôles
        $this->createUsers();

        // Créer les catégories
        $this->createCategoriesAndBrands();

        // Créer les appareils électroniques
        $this->createElectronicDevices();
    }

    private function truncateTables()
    {
        // Vider toutes les tables (PostgreSQL compatible) - seulement celles qui existent
        $tables = [
            'trade_offers',
            'products',
            'categories',
            'model_has_roles',
            'model_has_permissions',
            'role_has_permissions',
            'roles',
            'permissions',
            'users',
            'personal_access_tokens',
            'password_reset_tokens',
            'failed_jobs',
            'notifications'
        ];

        foreach ($tables as $table) {
            if (Schema::hasTable($table)) {
                DB::table($table)->truncate();
            }
        }
    }

    private function createRolesAndPermissions()
    {
        // Créer les permissions
        $permissions = [
            'view_dashboard',
            'manage_products',
            'manage_users',
            'manage_orders',
            'manage_categories',
            'manage_brands',
            'view_reports',
            'manage_settings',
            'manage_delivery',
            'manage_trades',
            'create_trade_offers',
            'accept_trade_offers',
            'reject_trade_offers'
        ];

        foreach ($permissions as $permission) {
            SpatiePermission::create(['name' => $permission]);
        }

        // Créer les rôles
        $adminRole = SpatieRole::create(['name' => 'admin']);
        $vendorRole = SpatieRole::create(['name' => 'vendor']);
        $deliveryRole = SpatieRole::create(['name' => 'delivery']);
        $userRole = SpatieRole::create(['name' => 'user']);

        // Assigner toutes les permissions à l'admin
        $adminRole->givePermissionTo(SpatiePermission::all());

        // Permissions pour les vendeurs
        $vendorRole->givePermissionTo([
            'view_dashboard',
            'manage_products',
            'manage_orders',
            'manage_trades',
            'create_trade_offers',
            'accept_trade_offers',
            'reject_trade_offers'
        ]);

        // Permissions pour les livreurs
        $deliveryRole->givePermissionTo([
            'view_dashboard',
            'manage_delivery',
            'view_reports'
        ]);

        // Permissions pour les utilisateurs
        $userRole->givePermissionTo([
            'view_dashboard',
            'create_trade_offers'
        ]);
    }

    private function createUsers()
    {
        // Admin principal
        $admin = User::create([
            'name' => 'Admin Principal',
            'username' => 'admin_principal',
            'email' => 'slovengama@gmail.com',
            'password' => Hash::make('admin123'),
            'email_verified_at' => now()
        ]);
        $admin->assignRole('admin');

        // Admin secondaire
        $admin2 = User::create([
            'name' => 'Admin Secondaire',
            'username' => 'admin_secondaire',
            'email' => 'stemk2151@gmail.com',
            'password' => Hash::make('admin123'),
            'email_verified_at' => now()
        ]);
        $admin2->assignRole('admin');

        // Vendeur 1
        $vendor1 = User::create([
            'name' => 'Vendeur Tech',
            'username' => 'vendeur_tech',
            'email' => 'vendeur1@techexchange.com',
            'password' => Hash::make('vendor123'),
            'email_verified_at' => now()
        ]);
        $vendor1->assignRole('vendor');

        // Vendeur 2
        $vendor2 = User::create([
            'name' => 'Vendeur Electronique',
            'username' => 'vendeur_electronique',
            'email' => 'vendeur2@techexchange.com',
            'password' => Hash::make('vendor123'),
            'email_verified_at' => now()
        ]);
        $vendor2->assignRole('vendor');

        // Livreur 1
        $delivery1 = User::create([
            'name' => 'Livreur Express',
            'username' => 'livreur_express',
            'email' => 'livreur1@techexchange.com',
            'password' => Hash::make('delivery123'),
            'email_verified_at' => now()
        ]);
        $delivery1->assignRole('delivery');

        // Livreur 2
        $delivery2 = User::create([
            'name' => 'Livreur Rapide',
            'username' => 'livreur_rapide',
            'email' => 'livreur2@techexchange.com',
            'password' => Hash::make('delivery123'),
            'email_verified_at' => now()
        ]);
        $delivery2->assignRole('delivery');

        // Utilisateur 1
        $user1 = User::create([
            'name' => 'Utilisateur Test',
            'username' => 'utilisateur_test',
            'email' => 'user1@techexchange.com',
            'password' => Hash::make('user123'),
            'email_verified_at' => now()
        ]);
        $user1->assignRole('user');

        // Utilisateur 2
        $user2 = User::create([
            'name' => 'Utilisateur Demo',
            'username' => 'utilisateur_demo',
            'email' => 'user2@techexchange.com',
            'password' => Hash::make('user123'),
            'email_verified_at' => now()
        ]);
        $user2->assignRole('user');
    }

    private function createCategoriesAndBrands()
    {
        // Créer les catégories
        $categories = [
            'smartphone' => Category::create(['name' => 'Smartphones', 'description' => 'Téléphones intelligents']),
            'tablet' => Category::create(['name' => 'Tablettes', 'description' => 'Tablettes tactiles']),
            'laptop' => Category::create(['name' => 'Ordinateurs portables', 'description' => 'Laptops et notebooks']),
            'desktop' => Category::create(['name' => 'Ordinateurs de bureau', 'description' => 'PC fixes']),
            'smartwatch' => Category::create(['name' => 'Montres connectées', 'description' => 'Smartwatches']),
            'headphones' => Category::create(['name' => 'Écouteurs', 'description' => 'Écouteurs et casques']),
            'console' => Category::create(['name' => 'Consoles de jeu', 'description' => 'Consoles de jeux vidéo']),
            'camera' => Category::create(['name' => 'Appareils photo', 'description' => 'Caméras et appareils photo']),
        ];

        // Retourner les catégories (pas de marques pour l'instant)
        return $categories;
    }

    private function createElectronicDevices()
    {
        $categories = Category::all()->keyBy('name');
        $vendors = User::role('vendeur')->get();

        // Appareils d'exemple
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
                'warranty_status' => 'Garantie Apple jusqu\'en 2025',
                'seller_id' => $vendors->first()->id
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
                'warranty_status' => 'Garantie Samsung jusqu\'en 2025',
                'seller_id' => $vendors->first()->id
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
                'warranty_status' => 'Garantie Apple jusqu\'en 2025',
                'seller_id' => $vendors->last()->id
            ],
            [
                'name' => 'iPad Pro 12.9" M2',
                'brand' => 'Apple',
                'model' => 'iPad Pro 12.9" M2',
                'device_type' => 'tablet',
                'condition' => 'very_good',
                'storage_capacity' => '256 GB',
                'color' => 'Space Gray',
                'price' => 1099.99,
                'trade_value' => 850.00,
                'is_trade_eligible' => true,
                'description' => 'iPad Pro 12.9" avec puce M2, Apple Pencil inclus.',
                'technical_specs' => [
                    'ecran' => '12.9 pouces Liquid Retina XDR',
                    'processeur' => 'Apple M2',
                    'ram' => '8 GB',
                    'stockage' => '256 GB',
                ],
                'has_original_box' => true,
                'has_original_accessories' => true,
                'warranty_status' => 'Garantie Apple jusqu\'en 2025',
                'seller_id' => $vendors->first()->id
            ],
            [
                'name' => 'Dell XPS 13 Plus',
                'brand' => 'Dell',
                'model' => 'XPS 13 Plus',
                'device_type' => 'laptop',
                'condition' => 'good',
                'storage_capacity' => '1 TB',
                'color' => 'Platinum Silver',
                'price' => 1499.99,
                'trade_value' => 1100.00,
                'is_trade_eligible' => true,
                'description' => 'Dell XPS 13 Plus en bon état, excellent pour le travail.',
                'technical_specs' => [
                    'ecran' => '13.4 pouces OLED 4K',
                    'processeur' => 'Intel Core i7-1260P',
                    'ram' => '16 GB',
                    'stockage' => '1 TB SSD',
                ],
                'has_original_box' => false,
                'has_original_accessories' => true,
                'warranty_status' => 'Garantie Dell jusqu\'en 2024',
                'seller_id' => $vendors->last()->id
            ],
            [
                'name' => 'Apple Watch Series 8',
                'brand' => 'Apple',
                'model' => 'Apple Watch Series 8',
                'device_type' => 'smartwatch',
                'condition' => 'excellent',
                'storage_capacity' => '32 GB',
                'color' => 'Midnight',
                'price' => 399.99,
                'trade_value' => 300.00,
                'is_trade_eligible' => true,
                'description' => 'Apple Watch Series 8 en excellent état, bracelet sport inclus.',
                'technical_specs' => [
                    'ecran' => 'Always-On Retina',
                    'processeur' => 'S8 SiP',
                    'ram' => '1 GB',
                    'stockage' => '32 GB',
                ],
                'has_original_box' => true,
                'has_original_accessories' => true,
                'warranty_status' => 'Garantie Apple jusqu\'en 2025',
                'seller_id' => $vendors->first()->id
            ],
            [
                'name' => 'Sony WH-1000XM5',
                'brand' => 'Sony',
                'model' => 'WH-1000XM5',
                'device_type' => 'headphones',
                'condition' => 'very_good',
                'storage_capacity' => 'N/A',
                'color' => 'Black',
                'price' => 349.99,
                'trade_value' => 250.00,
                'is_trade_eligible' => true,
                'description' => 'Sony WH-1000XM5 en très bon état, réduction de bruit active.',
                'technical_specs' => [
                    'type' => 'Casque sans fil',
                    'reduction_bruit' => 'Active',
                    'autonomie' => '30 heures',
                    'connectivite' => 'Bluetooth 5.2',
                ],
                'has_original_box' => true,
                'has_original_accessories' => true,
                'warranty_status' => 'Garantie Sony jusqu\'en 2024',
                'seller_id' => $vendors->last()->id
            ],
            [
                'name' => 'Nintendo Switch OLED',
                'brand' => 'Nintendo',
                'model' => 'Switch OLED',
                'device_type' => 'console',
                'condition' => 'good',
                'storage_capacity' => '64 GB',
                'color' => 'White',
                'price' => 299.99,
                'trade_value' => 200.00,
                'is_trade_eligible' => true,
                'description' => 'Nintendo Switch OLED en bon état, 2 manettes incluses.',
                'technical_specs' => [
                    'ecran' => '7 pouces OLED',
                    'stockage' => '64 GB',
                    'connectivite' => 'Wi-Fi + Bluetooth',
                    'autonomie' => '4.5-9 heures',
                ],
                'has_original_box' => false,
                'has_original_accessories' => true,
                'warranty_status' => 'Garantie Nintendo jusqu\'en 2024',
                'seller_id' => $vendors->first()->id
            ],
            [
                'name' => 'Canon EOS R6 Mark II',
                'brand' => 'Canon',
                'model' => 'EOS R6 Mark II',
                'device_type' => 'camera',
                'condition' => 'excellent',
                'storage_capacity' => 'N/A',
                'color' => 'Black',
                'price' => 2499.99,
                'trade_value' => 2000.00,
                'is_trade_eligible' => true,
                'description' => 'Canon EOS R6 Mark II en excellent état, objectif 24-105mm inclus.',
                'technical_specs' => [
                    'capteur' => '24.2 MP Full-Frame CMOS',
                    'video' => '4K 60p',
                    'autofocus' => 'Dual Pixel CMOS AF II',
                    'connectivite' => 'Wi-Fi + Bluetooth',
                ],
                'has_original_box' => true,
                'has_original_accessories' => true,
                'warranty_status' => 'Garantie Canon jusqu\'en 2025',
                'seller_id' => $vendors->last()->id
            ],
            [
                'name' => 'Xiaomi 13 Ultra',
                'brand' => 'Xiaomi',
                'model' => '13 Ultra',
                'device_type' => 'smartphone',
                'condition' => 'very_good',
                'storage_capacity' => '512 GB',
                'color' => 'Black',
                'price' => 999.99,
                'trade_value' => 750.00,
                'is_trade_eligible' => true,
                'description' => 'Xiaomi 13 Ultra en très bon état, excellent appareil photo.',
                'technical_specs' => [
                    'ecran' => '6.73 pouces AMOLED 2K',
                    'processeur' => 'Snapdragon 8 Gen 2',
                    'ram' => '16 GB',
                    'camera' => 'Quad caméra 50MP + 50MP + 50MP + 50MP',
                ],
                'has_original_box' => true,
                'has_original_accessories' => true,
                'warranty_status' => 'Garantie Xiaomi jusqu\'en 2025',
                'seller_id' => $vendors->first()->id
            ]
        ];

        // Créer les produits
        foreach ($devices as $device) {
            $category = $categories->get(ucfirst($device['device_type']));
            
            Product::create([
                'name' => $device['name'],
                'description' => $device['description'],
                'price' => $device['price'],
                'image' => 'default-device.jpg',
                'category_id' => $category ? $category->id : 1,
                'is_active' => true,
                'quantity' => 1,
                'is_featured' => rand(0, 1),
                'seller_id' => $device['seller_id'],
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