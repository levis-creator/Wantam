#!/bin/bash

# Install missing PHP extensions for Laravel
apt-get update && \
apt-get install -y php-intl php-zip

# Move into the Laravel project root
cd /home/site/wwwroot

# Laravel cache & migration setup
echo "Running Laravel config cache..."
php artisan config:cache

echo "Running Laravel route cache..."
php artisan route:cache

echo "Running Laravel migrations..."
php artisan migrate --force

# Important: Do NOT start NGINX or PHP-FPM manually — Azure manages that
echo "Startup script completed."
