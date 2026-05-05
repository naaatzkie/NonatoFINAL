#!/bin/sh
set -e

cd /var/www/html

# Run post-install scripts that were skipped during build
php artisan package:discover --ansi || true

# Generate app key if not set
if [ -z "$APP_KEY" ]; then
    php artisan key:generate --force
fi

# Run migrations
php artisan migrate --force || echo "Migration failed, continuing..."

# Cache for production
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Storage symlink
php artisan storage:link || true

# Start PHP-FPM in background
php-fpm -D

# Start Nginx in foreground
nginx -g "daemon off;"
