#!/bin/bash

# Create necessary directories
mkdir -p bootstrap/cache
mkdir -p storage/logs
mkdir -p storage/framework/cache
mkdir -p storage/framework/sessions
mkdir -p storage/framework/views

# Set permissions
chmod -R 775 bootstrap/cache
chmod -R 775 storage
chmod -R 775 public

# Install dependencies
composer install --no-dev --optimize-autoloader
npm install
npm run build

# Generate application key if not exists
if [ -z "$APP_KEY" ]; then
    php artisan key:generate
fi

# Cache configuration
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Run migrations
php artisan migrate --force

# Start the application
php artisan serve --host=0.0.0.0 --port=$PORT
