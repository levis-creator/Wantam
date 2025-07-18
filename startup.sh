#!/bin/bash

# Install required extensions
apt-get update && \
apt-get install -y php-intl php-zip && \
service apache2 restart || true

# Continue with normal startup
cd /home/site/wwwroot

# Laravel-specific setup
php artisan config:cache
php artisan route:cache
php artisan migrate --force

# Start the web server (Apache or PHP built-in)
# Don't include this line if Azure manages it automatically
