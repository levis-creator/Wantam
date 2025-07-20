#!/bin/bash
set -e

# ✅ Install required PHP extensions
apt-get update && apt-get install -y unzip curl git

cd /home/site/wwwroot
# nginx config
echo "📦 Configuring nginx..."
cp /home/site/wwwroot/default /etc/nginx/sites-enabled

# ✅ Install Composer globally
if ! command -v composer &>/dev/null; then
  echo "📦 Installing Composer..."
  curl -sS https://getcomposer.org/installer | php
  mv composer.phar /usr/local/bin/composer
  chmod +x /usr/local/bin/composer
fi

# ✅ Install PHP dependencies
echo "🔧 Installing PHP dependencies..."
composer install --no-dev --optimize-autoloader

# ✅ Install Node using NVM if npm is not found
if ! command -v npm &>/dev/null; then
  echo "📦 Installing Node.js via NVM..."
  export NVM_DIR="$HOME/.nvm"
  curl -o- https://raw.githubusercontent.com/nvm-sh/nvm/v0.40.0/install.sh | bash
  source "$NVM_DIR/nvm.sh"
  nvm install --lts
fi

# ✅ Run Node asset build if package.json exists
if [ -f "package.json" ]; then
  echo "📦 Installing Node dependencies..."
  npm ci
  echo "🔨 Building frontend assets..."
  npm run build
fi

# ✅ Laravel commands
echo "🔧 Caching Laravel config..."
php artisan config:cache

echo "📋 Caching Laravel routes..."
php artisan route:cache

echo "📦 Caching Laravel views..."
php artisan view:cache

echo "🛠 Caching Laravel events..."
php artisan event:cache

echo "🔄 Running database migrations..."
php artisan migrate --force

echo "✅ Startup script completed."
