#!/bin/bash

# Install missing PHP extensions (just in case)
apt-get update && apt-get install -y php-mysql php-intl php-zip unzip

cd /home/site/wwwroot

echo "🔧 Running Laravel config cache..."
php artisan config:cache

echo "📋 Running Laravel route cache..."
php artisan route:cache

echo "📦 Running Laravel view cache..."
php artisan view:cache

echo "🛠 Running Laravel database migrations..."
php artisan migrate --force

echo "✅ Startup script completed."

