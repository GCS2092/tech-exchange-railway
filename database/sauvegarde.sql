-- Drop all tables to avoid conflicts
DROP TABLE IF EXISTS cache, cache_locks, categories, delivery_options, failed_jobs, favorites, job_batches, jobs, messages, migrations, model_has_permissions, model_has_roles, notification_logs, notifications, order_items, order_product, orders, password_reset_codes, password_reset_tokens, permissions, personal_access_tokens, products, promo_usages, promotions, role_has_permissions, roles, sessions, users;

-- Create ENUM types
CREATE TYPE order_status AS ENUM ('en attente', 'expédié', 'livré');
CREATE TYPE promotion_type AS ENUM ('percent', 'fixed');

-- Table: cache
CREATE TABLE cache (
    key VARCHAR(255) NOT NULL,
    value TEXT NOT NULL,
    expiration INTEGER NOT NULL,
    PRIMARY KEY (key)
);

-- Table: cache_locks
CREATE TABLE cache_locks (
    key VARCHAR(255) NOT NULL,
    owner VARCHAR(255) NOT NULL,
    expiration INTEGER NOT NULL,
    PRIMARY KEY (key)
);

-- Table: categories
CREATE TABLE categories (
    id BIGSERIAL PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    created_at TIMESTAMP,
    updated_at TIMESTAMP,
    CONSTRAINT categories_name_unique UNIQUE (name)
);

-- Insert data into categories
INSERT INTO categories (id, name, created_at, updated_at) 
VALUES (1, 'cosmetique', '2025-05-01 18:59:14', '2025-05-01 18:59:14');

-- Table: users
CREATE TABLE users (
    id BIGSERIAL PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    username VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL,
    profile_photo VARCHAR(255),
    email_verified_at TIMESTAMP,
    password VARCHAR(255) NOT NULL,
    role VARCHAR(255) NOT NULL DEFAULT 'user',
    remember_token VARCHAR(100),
    created_at TIMESTAMP,
    updated_at TIMESTAMP,
    phone_number VARCHAR(255),
    active BOOLEAN NOT NULL DEFAULT TRUE,
    last_login_at TIMESTAMP,
    eligible_for_reward BOOLEAN NOT NULL DEFAULT FALSE,
    CONSTRAINT users_email_unique UNIQUE (email),
    CONSTRAINT users_username_unique UNIQUE (username)
);

-- Insert data into users
INSERT INTO users (id, name, username, email, profile_photo, email_verified_at, password, role, remember_token, created_at, updated_at, phone_number, active, last_login_at, eligible_for_reward) 
VALUES 
    (2, 'Regular User', 'regular_user', 'Stemk2151@gmail.com', NULL, NULL, '$2y$12$K6YcjCYbwIoI3qvmxtDPG.0vuxz7tVWHkK3OZaHTUutXVeyuT9jsG', 'user', NULL, '2025-05-01 16:49:23', '2025-05-02 11:04:00', NULL, TRUE, '2025-05-02 11:04:00', FALSE),
    (5, 'Slovengama', 'slovengama', 'slovengama@gmail.com', NULL, NULL, '$2y$12$SSORfT3K7afy7ZsxMMd5OOviavwHP2aGWCZPhTZDqCHcSyqHzZvJ6', 'admin', NULL, '2025-05-01 18:25:12', '2025-05-02 10:59:31', NULL, TRUE, '2025-05-02 10:59:31', FALSE);

-- Table: products
CREATE TABLE products (
    id BIGSERIAL PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    description TEXT,
    price NUMERIC(10,2) NOT NULL,
    image VARCHAR(255) NOT NULL,
    category_id BIGINT,
    category VARCHAR(255),
    is_active BOOLEAN NOT NULL DEFAULT TRUE,
    is_featured BOOLEAN NOT NULL DEFAULT FALSE,
    quantity INTEGER NOT NULL DEFAULT 0,
    created_at TIMESTAMP,
    updated_at TIMESTAMP,
    CONSTRAINT products_category_id_foreign FOREIGN KEY (category_id) REFERENCES categories (id) ON DELETE CASCADE
);

-- Insert data into products
INSERT INTO products (id, name, description, price, image, category_id, category, is_active, is_featured, quantity, created_at, updated_at) 
VALUES 
    (1, 'Parfum Dior Sauvage', 'Force', 2500.00, 'products/CBbUQBdUW6CxtihZoPwjgiMYMBNxKgtuAb4SiG1X.jpg', 1, NULL, TRUE, FALSE, 9, '2025-05-02 04:41:48', '2025-05-02 11:27:03'),
    (2, 'Parfum Dior Sauvage', 'rt', 234.00, 'https://www.poudrine.com/cdn/shop/files/270754-dior-sauvage-elixir-parfum-60-ml-autre1-1000x1000.jpg?v=1741282864', 1, NULL, TRUE, FALSE, 12, '2025-05-02 05:16:11', '2025-05-02 05:16:11');

-- Table: favorites
CREATE TABLE favorites (
    id BIGSERIAL PRIMARY KEY,
    user_id BIGINT NOT NULL,
    product_id BIGINT NOT NULL,
    created_at TIMESTAMP,
    updated_at TIMESTAMP,
    CONSTRAINT favorites_user_id_foreign FOREIGN KEY (user_id) REFERENCES users (id) ON DELETE CASCADE,
    CONSTRAINT favorites_product_id_foreign FOREIGN KEY (product_id) REFERENCES products (id) ON DELETE CASCADE
);

-- Create indexes for favorites
CREATE INDEX favorites_user_id_idx ON favorites (user_id);
CREATE INDEX favorites_product_id_idx ON favorites (product_id);

-- Insert data into favorites
INSERT INTO favorites (id, user_id, product_id, created_at, updated_at) 
VALUES 
    (1, 5, 2, '2025-05-02 05:24:36', '2025-05-02 05:24:36'),
    (2, 5, 1, '2025-05-02 05:44:37', '2025-05-02 05:44:37');

-- Table: jobs
CREATE TABLE jobs (
    id BIGSERIAL PRIMARY KEY,
    queue VARCHAR(255) NOT NULL,
    payload TEXT NOT NULL,
    attempts SMALLINT NOT NULL,
    reserved_at INTEGER,
    available_at INTEGER NOT NULL,
    created_at INTEGER NOT NULL
);

-- Create index for jobs
CREATE INDEX jobs_queue_idx ON jobs (queue);

-- Table: messages
CREATE TABLE messages (
    id BIGSERIAL PRIMARY KEY,
    user_id BIGINT NOT NULL,
    content TEXT NOT NULL,
    created_at TIMESTAMP,
    updated_at TIMESTAMP,
    CONSTRAINT messages_user_id_foreign FOREIGN KEY (user_id) REFERENCES users (id) ON DELETE CASCADE
);

-- Create index for messages
CREATE INDEX messages_user_id_idx ON messages (user_id);

-- Table: migrations
CREATE TABLE migrations (
    id SERIAL PRIMARY KEY,
    migration VARCHAR(255) NOT NULL,
    batch INTEGER NOT NULL
);

-- Insert data into migrations
INSERT INTO migrations (id, migration, batch) 
VALUES 
    (1, '0001_01_01_000000_create_users_table', 1),
    (2, '0001_01_01_000001_create_cache_table', 1),
    (3, '0001_01_01_000002_create_jobs_table', 1),
    (4, '2024_03_19_000001_create_products_table', 1),
    (5, '2024_03_19_remove_role_column_from_users_table', 1),
    (6, '2024_03_21_create_delivery_options_table', 1),
    (7, '2025_02_18_224135_add_role_to_users_table', 1),
    (8, '2025_02_18_233429_create_categories_table', 1),
    (9, '2025_02_18_233504_add_category_id_to_products_table', 1),
    (10, '2025_02_19_011815_create_orders_table', 1),
    (11, '2025_02_19_015057_update_total_price_default_value', 1),
    (12, '2025_02_22_113727_add_phone_number_to_orders_table', 1),
    (13, '2025_02_23_035258_add_phone_number_to_users_table', 1),
    (14, '2025_02_26_175032_create_messages_table', 1),
    (15, '2025_03_23_002845_create_notifications_table', 1),
    (16, '2025_03_23_165304_create_order_product_table', 1),
    (17, '2025_03_25_090509_add_role_to_users_table', 1),
    (18, '2025_03_25_093401_modify_status_column_in_orders_table', 1),
    (19, '2025_03_25_225650_add_payment_method_to_orders_table', 1),
    (20, '2025_03_27_153615_add_active_to_users_table', 1),
    (21, '2025_03_27_233101_add_last_login_at_to_users_table', 1),
    (22, '2025_03_31_161508_create_notification_logs_table', 1),
    (23, '2025_04_03_132207_create_password_reset_codes_table', 1),
    (24, '2025_04_04_011632_add_profile_photo_to_users_table', 1),
    (25, '2025_04_13_220248_add_location_to_orders_table', 1),
    (26, '2025_04_14_231615_add_shipping_coords_to_orders_table', 1),
    (27, '2025_04_15_005721_add_delivery_address_to_orders_table', 1),
    (28, '2025_04_15_103735_add_livreur_id_to_orders_table', 1),
    (29, '2025_04_16_054157_add_delivered_at_to_orders_table', 1),
    (30, '2025_04_17_170502_add_username_and_profile_photo_to_users_table', 1),
    (31, '2025_04_21_222900_create_promotions_table', 1),
    (32, '2025_04_21_223421_create_favorite_table', 1),
    (33, '2025_04_22_022432_create_promo_usages_table', 1),
    (34, '2025_04_22_111045_add_amount_fields_to_promo_usages_table', 1),
    (35, '2025_04_22_115938_add_order_id_to_promo_usages_table', 1),
    (36, '2025_04_22_170820_add_usage_stats_to_promotions_table', 1),
    (37, '2025_04_22_171202_add_price_to_order_product_table', 1),
    (38, '2025_04_22_201800_add_eligible_for_reward_to_users_table', 1),
    (39, '2025_04_24_001605udden_order_items_table', 1),
    (40, '2025_04_25_093043_create_personal_access_tokens_table', 1),
    (41, '2025_04_28_112854_add_variation_to_order_items_table', 1),
    (42, '2025_04_28_125825_make_category_nullable_in_products_table', 1),
    (43, '2025_05_01_040444_create_permission_tables', 1),
    (44, '2025_05_01_041747_remove_role_column_from_users_table', 1),
    (45, '2025_04_22_000000_add_is_active_to_promotions_table', 2),
    (46, '2025_04_22_000001_add_promo_fields_to_orders_table', 3);

-- Table: permissions
CREATE TABLE permissions (
    id BIGSERIAL PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    guard_name VARCHAR(255) NOT NULL,
    created_at TIMESTAMP,
    updated_at TIMESTAMP,
    CONSTRAINT permissions_name_guard_name_unique UNIQUE (name, guard_name)
);

-- Insert data into permissions
INSERT INTO permissions (id, name, guard_name, created_at, updated_at) 
VALUES 
    (1, 'view dashboard', 'web', '2025-05-01 18:29:06', '2025-05-01 18:29:06'),
    (2, 'manage products', 'web', '2025-05-01 18:29:07', '2025-05-01 18:29:07'),
    (3, 'manage users', 'web', '2025-05-01 18:29:07', '2025-05-01 18:29:07'),
    (4, 'manage orders', 'web', '2025-05-01 18:29:07', '2025-05-01 18:29:07'),
    (5, 'manage categories', 'web', '2025-05-01 18:29:07', '2025-05-01 18:29:07'),
    (6, 'view categories', 'web', '2025-05-01 18:39:17', '2025-05-01 18:39:17'),
    (7, 'create categories', 'web', '2025-05-01 18:39:17', '2025-05-01 18:39:17'),
    (8, 'edit categories', 'web', '2025-05-01 18:39:17', '2025-05-01 18:39:17'),
    (9, 'delete categories', 'web', '2025-05-01 18:39:17', '2025-05-01 18:39:17'),
    (10, 'view promotions', 'web', '2025-05-01 18:41:08', '2025-05-01 18:41:08'),
    (11, 'create promotions', 'web', '2025-05-01 18:41:08', '2025-05-01 18:41:08'),
    (12, 'edit promotions', 'web', '2025-05-01 18:41:08', '2025-05-01 18:41:08'),
    (13, 'delete promotions', 'web', '2025-05-01 18:41:08', '2025-05-01 18:41:08'),
    (14, 'manage promotions', 'web', '2025-05-01 18:41:08', '2025-05-01 18:41:08');

-- Table: roles
CREATE TABLE roles (
    id BIGSERIAL PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    guard_name VARCHAR(255) NOT NULL,
    created_at TIMESTAMP,
    updated_at TIMESTAMP,
    CONSTRAINT roles_name_guard_name_unique UNIQUE (name, guard_name)
);

-- Insert data into roles
INSERT INTO roles (id, name, guard_name, created_at, updated_at) 
VALUES 
    (1, 'admin', 'web', '2025-05-01 18:28:47', '2025-05-01 18:28:47'),
    (2, 'user', 'web', '2025-05-01 19:14:16', '2025-05-01 19:14:16'),
    (3, 'delivery', 'web', '2025-05-01 19:14:17', '2025-05-01 19:14:17'),
    (4, 'client', 'web', '2025-05-01 19:14:17', '2025-05-01 19:14:17'),
    (5, 'vendeur', 'web', '2025-05-01 19:14:19', '2025-05-01 19:14:19');

-- Table: model_has_permissions
CREATE TABLE model_has_permissions (
    permission_id BIGINT NOT NULL,
    model_type VARCHAR(255) NOT NULL,
    model_id BIGINT NOT NULL,
    PRIMARY KEY (permission_id, model_id, model_type),
    CONSTRAINT model_has_permissions_permission_id_foreign FOREIGN KEY (permission_id) REFERENCES permissions (id) ON DELETE CASCADE
);

-- Create index for model_has_permissions
CREATE INDEX model_has_permissions_model_id_model_type_idx ON model_has_permissions (model_id, model_type);

-- Table: model_has_roles
CREATE TABLE model_has_roles (
    role_id BIGINT NOT NULL,
    model_type VARCHAR(255) NOT NULL,
    model_id BIGINT NOT NULL,
    PRIMARY KEY (role_id, model_id, model_type),
    CONSTRAINT model_has_roles_role_id_foreign FOREIGN KEY (role_id) REFERENCES roles (id) ON DELETE CASCADE
);

-- Create index for model_has_roles
CREATE INDEX model_has_roles_model_id_model_type_idx ON model_has_roles (model_id, model_type);

-- Insert data into model_has_roles
INSERT INTO model_has_roles (role_id, model_type, model_id) 
VALUES 
    (3, 'App\Models\User', 2),
    (1, 'App\Models\User', 5);

-- Table: role_has_permissions
CREATE TABLE role_has_permissions (
    permission_id BIGINT NOT NULL,
    role_id BIGINT NOT NULL,
    PRIMARY KEY (permission_id, role_id),
    CONSTRAINT role_has_permissions_permission_id_foreign FOREIGN KEY (permission_id) REFERENCES permissions (id) ON DELETE CASCADE,
    CONSTRAINT role_has_permissions_role_id_foreign FOREIGN KEY (role_id) REFERENCES roles (id) ON DELETE CASCADE
);

-- Create index for role_has_permissions
CREATE INDEX role_has_permissions_role_id_idx ON role_has_permissions (role_id);

-- Insert data into role_has_permissions
INSERT INTO role_has_permissions (permission_id, role_id) 
VALUES 
    (1, 1), (2, 1), (3, 1), (4, 1), (5, 1), (6, 1), (7, 1), (8, 1),
    (9, 1), (10, 1), (11, 1), (12, 1), (13, 1), (14, 1);

-- Table: orders
CREATE TABLE orders (
    id BIGSERIAL PRIMARY KEY,
    user_id BIGINT NOT NULL,
    livreur_id BIGINT,
    total_price NUMERIC(10,2) NOT NULL DEFAULT 0.00,
    original_price NUMERIC(10,2) NOT NULL,
    discount_amount NUMERIC(10,2),
    promo_code VARCHAR(255),
    status order_status DEFAULT 'en attente',
    delivered_at TIMESTAMP,
    created_at TIMESTAMP,
    updated_at TIMESTAMP,
    phone_number VARCHAR(255),
    payment_method VARCHAR(255),
    latitude NUMERIC(10,7),
    longitude NUMERIC(10,7),
    delivery_address VARCHAR(255),
    CONSTRAINT orders_user_id_foreign FOREIGN KEY (user_id) REFERENCES users (id) ON DELETE CASCADE,
    CONSTRAINT orders_livreur_id_foreign FOREIGN KEY (livreur_id) REFERENCES users (id) ON DELETE SET NULL
);

-- Create indexes for orders
CREATE INDEX orders_user_id_idx ON orders (user_id);
CREATE INDEX orders_livreur_id_idx ON orders (livreur_id);

-- Insert data into orders
INSERT INTO orders (id, user_id, livreur_id, total_price, original_price, discount_amount, promo_code, status, delivered_at, created_at, updated_at, phone_number, payment_method, latitude, longitude, delivery_address) 
VALUES 
    (2, 2, NULL, 5000.00, 5000.00, NULL, NULL, 'livré', NULL, '2025-05-02 11:27:03', '2025-05-02 14:49:32', NULL, 'livraison', NULL, NULL, 'OUEST FOIRE');

-- Modify status column in orders table (PostgreSQL-compatible)
ALTER TABLE orders ALTER COLUMN status TYPE order_status USING (status::order_status);

-- Table: order_items
CREATE TABLE order_items (
    id BIGSERIAL PRIMARY KEY,
    order_id BIGINT NOT NULL,
    product_id BIGINT NOT NULL,
    quantity INTEGER NOT NULL,
    created_at TIMESTAMP,
    updated_at TIMESTAMP,
    variation VARCHAR(255),
    CONSTRAINT order_items_order_id_foreign FOREIGN KEY (order_id) REFERENCES orders (id) ON DELETE CASCADE,
    CONSTRAINT order_items_product_id_foreign FOREIGN KEY (product_id) REFERENCES products (id) ON DELETE CASCADE
);

-- Create indexes for order_items
CREATE INDEX order_items_order_id_idx ON order_items (order_id);
CREATE INDEX order_items_product_id_idx ON order_items (product_id);

-- Table: order_product
CREATE TABLE order_product (
    id BIGSERIAL PRIMARY KEY,
    order_id BIGINT NOT NULL,
    product_id BIGINT NOT NULL,
    quantity INTEGER NOT NULL,
    created_at TIMESTAMP,
    updated_at TIMESTAMP,
    price NUMERIC(10,2),
    CONSTRAINT order_product_order_id_foreign FOREIGN KEY (order_id) REFERENCES orders (id) ON DELETE CASCADE,
    CONSTRAINT order_product_product_id_foreign FOREIGN KEY (product_id) REFERENCES products (id) ON DELETE CASCADE
);

-- Create indexes for order_product
CREATE INDEX order_product_order_id_idx ON order_product (order_id);
CREATE INDEX order_product_product_id_idx ON order_product (product_id);

-- Insert data into order_product
INSERT INTO order_product (id, order_id, product_id, quantity, created_at, updated_at, price) 
VALUES 
    (2, 2, 1, 2, '2025-05-02 11:27:03', '2025-05-02 11:27:03', 2500.00);

-- Table: promotions
CREATE TABLE promotions (
    id BIGSERIAL PRIMARY KEY,
    code VARCHAR(255) NOT NULL,
    type promotion_type NOT NULL,
    value NUMERIC(8,2) NOT NULL,
    is_active BOOLEAN NOT NULL DEFAULT TRUE,
    expires_at DATE,
    created_at TIMESTAMP,
    updated_at TIMESTAMP,
    last_used_at TIMESTAMP,
    last_used_by_id BIGINT,
    uses_count INTEGER NOT NULL DEFAULT 0,
    CONSTRAINT promotions_code_unique UNIQUE (code)
);

-- Insert data into promotions
INSERT INTO promotions (id, code, type, value, is_active, expires_at, created_at, updated_at, last_used_at, last_used_by_id, uses_count) 
VALUES 
    (1, 'WELCOME10', 'percent', 15.00, TRUE, '2025-05-03', '2025-05-02 11:01:00', '2025-05-02 11:01:00', NULL, NULL, 0);

-- Table: promo_usages
CREATE TABLE promo_usages (
    id BIGSERIAL PRIMARY KEY,
    user_id BIGINT NOT NULL,
    promotion_id BIGINT NOT NULL,
    order_id BIGINT,
    created_at TIMESTAMP,
    updated_at TIMESTAMP,
    original_amount NUMERIC(10,2),
    discount_amount NUMERIC(10,2),
    final_amount NUMERIC(10,2),
    CONSTRAINT promo_usages_user_id_foreign FOREIGN KEY (user_id) REFERENCES users (id) ON DELETE CASCADE,
    CONSTRAINT promo_usages_promotion_id_foreign FOREIGN KEY (promotion_id) REFERENCES promotions (id) ON DELETE CASCADE
);

-- Create indexes for promo_usages
CREATE INDEX promo_usages_user_id_idx ON promo_usages (user_id);
CREATE INDEX promo_usages_promotion_id_idx ON promo_usages (promotion_id);

-- Insert data into promo_usages
INSERT INTO promo_usages (id, user_id, promotion_id, order_id, created_at, updated_at, original_amount, discount_amount, final_amount) 
VALUES 
    (1, 2, 1, 2, '2025-05-02 11:27:03', '2025-05-02 11:27:03', 0.00, 0.00, NULL);

-- Table: notifications
CREATE TABLE notifications (
    id CHAR(36) NOT NULL,
    type VARCHAR(255) NOT NULL,
    notifiable_type VARCHAR(255) NOT NULL,
    notifiable_id BIGINT NOT NULL,
    data TEXT NOT NULL,
    read_at TIMESTAMP,
    created_at TIMESTAMP,
    updated_at TIMESTAMP,
    PRIMARY KEY (id)
);

-- Create index for notifications
CREATE INDEX notifications_notifiable_type_notifiable_id_idx ON notifications (notifiable_type, notifiable_id);

-- Insert data into notifications
INSERT INTO notifications (id, type, notifiable_type, notifiable_id, data, read_at, created_at, updated_at) 
VALUES 
    ('2c9b0555-4a44-4472-81f0-b9636bebf8d8', 'App\Notifications\OrderPlacedNotification', 'App\Models\User', 2, '{"message":"Votre commande #1 a été passée avec succès.","order_id":1}', NULL, '2025-05-02 08:22:44', '2025-05-02 08:22:44'),
    ('487d8266-67ee-45ef-9479-46252863bcfc', 'App\Notifications\OrderPlacedNotification', 'App\Models\User', 2, '{"message":"Votre commande #2 a été passée avec succès.","order_id":2}', NULL, '2025-05-02 11:27:07', '2025-05-02 11:27:07'),
    ('6f5bdf67-6216-4ecd-ad15-8cd1201a11fa', 'App\Notifications\OrderStatusUpdatedNotification', 'App\Models\User', 2, '{"order_id":2,"status":"expédié","message":"Le statut de la commande #2 a été mis à jour à expédié"}', NULL, '2025-05-02 14:44:42', '2025-05-02 14:44:42'),
    ('7fd811ab-b029-47e9-af7b-1b253205e953', 'App\Notifications\OrderStatusUpdatedNotification', 'App\Models\User', 2, '{"order_id":2,"status":"expédié","message":"Statut de la commande #2 : expédié","updated_at":"2025-05-02 14:44:14"}', NULL, '2025-05-02 14:48:42', '2025-05-02 14:48:42'),
    ('800a8ca8-08a4-40f2-bc24-d5a397594d77', 'App\Notifications\OrderStatusUpdatedNotification', 'App\Models\User', 2, '{"order_id":2,"status":"livré","message":"Statut de la commande #2 : livré","updated_at":"2025-05-02 14:49:32"}', NULL, '2025-05-02 14:49:36', '2025-05-02 14:49:36'),
    ('9810ebe8-03df-4f42-92e0-c5313b5af612', 'App\Notifications\NewOrderNotification', 'App\Models\User', 5, '{"message":"Une nouvelle commande (#2) a été passée par Regular User","order_id":2,"user_name":"Regular User","total":null,"status":"en attente"}', NULL, '2025-05-02 11:27:33', '2025-05-02 11:27:33'),
    ('b4532fa8-ea64-4c0f-9d95-461633a34154', 'App\Notifications\OrderStatusUpdatedNotification', 'App\Models\User', 2, '{"order_id":2,"status":"livré","message":"Statut de la commande #2 : livré","updated_at":"2025-05-02 14:49:32"}', NULL, '2025-05-02 14:51:08', '2025-05-02 14:51:08'),
    ('b7a8c74d-c837-48db-a2a5-6600ebb8c8c6', 'App\Notifications\OrderStatusUpdatedNotification', 'App\Models\User', 5, '{"order_id":2,"status":"livré","message":"Statut de la commande #2 : livré","updated_at":"2025-05-02 14:49:32"}', NULL, '2025-05-02 14:49:38', '2025-05-02 14:49:38'),
    ('c3b349c1-b1f8-4509-97f1-9308c4088048', 'App\Notifications\OrderStatusUpdatedNotification', 'App\Models\User', 5, '{"order_id":2,"status":"expédié","message":"Statut de la commande #2 : expédié","updated_at":"2025-05-02 14:44:14"}', NULL, '2025-05-02 14:48:44', '2025-05-02 14:48:44'),
    ('cdb086d4-d520-416f-a79b-573e4b56cf9d', 'App\Notifications\OrderStatusUpdatedNotification', 'App\Models\User', 5, '{"order_id":2,"status":"expédié","message":"Le statut de la commande #2 a été mis à jour à expédié"}', NULL, '2025-05-02 14:44:43', '2025-05-02 14:44:43'),
    ('cfc773cd-88e0-4571-a2e0-6187fee24800', 'App\Notifications\NewOrderNotification', 'App\Models\User', 5, '{"message":"Une nouvelle commande (#1) a été passée par Regular User","order_id":1,"user_name":"Regular User","total":null,"status":"en attente"}', '2025-05-02 08:51:02', '2025-05-02 08:23:06', '2025-05-02 08:51:02'),
    ('e8cd40da-51d1-457d-a753-5770091f99fa', 'App\Notifications\OrderStatusUpdatedNotification', 'App\Models\User', 5, '{"order_id":2,"status":"livré","message":"Statut de la commande #2 : livré","updated_at":"2025-05-02 14:49:32"}', NULL, '2025-05-02 14:51:10', '2025-05-02 14:51:10');

-- Table: password_reset_codes
CREATE TABLE password_reset_codes (
    id BIGSERIAL PRIMARY KEY,
    email VARCHAR(255) NOT NULL,
    code VARCHAR(255) NOT NULL,
    expires_at TIMESTAMP NOT NULL,
    created_at TIMESTAMP,
    updated_at TIMESTAMP
);

-- Create index for password_reset_codes
CREATE INDEX password_reset_codes_email_idx ON password_reset_codes (email);

-- Table: password_reset_tokens
CREATE TABLE password_reset_tokens (
    email VARCHAR(255) NOT NULL,
    token VARCHAR(255) NOT NULL,
    created_at TIMESTAMP,
    PRIMARY KEY (email)
);

-- Table: personal_access_tokens
CREATE TABLE personal_access_tokens (
    id BIGSERIAL PRIMARY KEY,
    tokenable_type VARCHAR(255) NOT NULL,
    tokenable_id BIGINT NOT NULL,
    name VARCHAR(255) NOT NULL,
    token VARCHAR(64) NOT NULL,
    abilities TEXT,
    last_used_at TIMESTAMP,
    expires_at TIMESTAMP,
    created_at TIMESTAMP,
    updated_at TIMESTAMP,
    CONSTRAINT personal_access_tokens_token_unique UNIQUE (token)
);

-- Create index for personal_access_tokens
CREATE INDEX personal_access_tokens_tokenable_type_tokenable_id_idx ON personal_access_tokens (tokenable_type, tokenable_id);

-- Table: sessions
CREATE TABLE sessions (
    id VARCHAR(255) NOT NULL,
    user_id BIGINT,
    ip_address VARCHAR(45),
    user_agent TEXT,
    payload TEXT NOT NULL,
    last_activity INTEGER NOT NULL,
    PRIMARY KEY (id),
    CONSTRAINT sessions_user_id_foreign FOREIGN KEY (user_id) REFERENCES users (id)
);

-- Create indexes for sessions
CREATE INDEX sessions_user_id_idx ON sessions (user_id);
CREATE INDEX sessions_last_activity_idx ON sessions (last_activity);

-- Table: delivery_options
CREATE TABLE delivery_options (
    id BIGSERIAL PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    type VARCHAR(50) NOT NULL CHECK (type IN ('delivery', 'pickup')),
    zone VARCHAR(255),
    fixed_price NUMERIC(8,2),
    is_active BOOLEAN NOT NULL DEFAULT TRUE,
    created_at TIMESTAMP,
    updated_at TIMESTAMP
);

-- Table: failed_jobs
CREATE TABLE failed_jobs (
    id BIGSERIAL PRIMARY KEY,
    uuid VARCHAR(255) NOT NULL,
    connection TEXT NOT NULL,
    queue TEXT NOT NULL,
    payload TEXT NOT NULL,
    exception TEXT NOT NULL,
    failed_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    CONSTRAINT failed_jobs_uuid_unique UNIQUE (uuid)
);

-- Table: job_batches
CREATE TABLE job_batches (
    id VARCHAR(255) NOT NULL,
    name VARCHAR(255) NOT NULL,
    total_jobs INTEGER NOT NULL,
    pending_jobs INTEGER NOT NULL,
    failed_jobs INTEGER NOT NULL,
    failed_job_ids TEXT NOT NULL,
    options TEXT,
    cancelled_at INTEGER,
    created_at INTEGER NOT NULL,
    finished_at INTEGER,
    PRIMARY KEY (id)
);

-- Table: notification_logs
CREATE TABLE notification_logs (
    id BIGSERIAL PRIMARY KEY,
    user_id BIGINT NOT NULL,
    type VARCHAR(255) NOT NULL,
    data JSONB NOT NULL,
    created_at TIMESTAMP,
    updated_at TIMESTAMP
);