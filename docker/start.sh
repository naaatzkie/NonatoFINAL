#!/bin/sh
set -e

cd /var/www/html

# Generate app key if not set
if [ -z "$APP_KEY" ]; then
    php artisan key:generate --force
fi

# Clear any cached config from build time
php artisan config:clear || true
php artisan cache:clear || true

# Run migrations
php artisan migrate --force || echo "Migration failed, continuing..."

# Cache for production
php artisan config:cache || true
php artisan route:cache || true
php artisan view:cache || true

# Storage symlink
php artisan storage:link || true

# Start PHP-FPM in background
php-fpm -D

# Wait for php-fpm to be ready
sleep 2

# Test php-fpm is running
if ! pgrep php-fpm > /dev/null; then
    echo "php-fpm failed to start"
    exit 1
fi

# Start Nginx in foreground
exec nginx -g "daemon off;"
