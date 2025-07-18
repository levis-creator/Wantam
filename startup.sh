#!/bin/bash

# Install any missing PHP extensions (optional on Azure, can be skipped if already present)
apt-get update && apt-get install -y php-intl php-zip

# Navigate to the Laravel project root (Azure sets this as /home/site/wwwroot)
cd /home/site/wwwroot || exit

# Ensure proper permissions for storage and cache
echo "Setting correct permissions..."
chmod -R 775 storage bootstrap/cache
chown -R www-data:www-data storage bootstrap/cache

# Laravel optimization and caching
echo "Caching Laravel configuration..."
php artisan config:cache

echo "Caching Laravel routes..."
php artisan route:cache

echo "Caching Laravel views..."
php artisan view:cache

# Run database migrations
echo "Running Laravel migrations..."
php artisan migrate --force

echo "Startup script completed."
